<?php
class AuthController extends Controller {
    private $adminModel;

    public function __construct() {
        $this->adminModel = new Admin();
    }

    public function login() {
        // If already logged in, redirect to dashboard
        if (isset($_SESSION['admin_id'])) {
            $this->redirect('dashboard');
        }
        
        $error = '';
        if (isset($_SESSION['login_error'])) {
            $error = $_SESSION['login_error'];
            unset($_SESSION['login_error']);
        }
        
        $this->view('auth/login', ['error' => $error]);
    }

    public function register() {
        if (isset($_SESSION['admin_id'])) {
            $this->redirect('dashboard');
        }

        $error = '';
        if (isset($_SESSION['register_error'])) {
            $error = $_SESSION['register_error'];
            unset($_SESSION['register_error']);
        }

        $adminModel = new Admin();
        $superAdminExists = $adminModel->getSuperAdminCount() >= 1;

        $this->view('auth/register', [
            'error'            => $error,
            'superAdminExists' => $superAdminExists
        ]);
    }

    public function postRegister() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name             = trim($_POST['name'] ?? '');
            $email            = trim($_POST['email'] ?? '');
            $password         = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            // Sanitize role — only allow two valid values
            $rawRole = $_POST['role'] ?? 'admin';
            $role    = in_array($rawRole, ['admin', 'super_admin']) ? $rawRole : 'admin';

            if (empty($name) || empty($email) || empty($password)) {
                $_SESSION['register_error'] = 'Please fill out all fields.';
                $this->redirect('register');
            }

            if ($password !== $confirm_password) {
                $_SESSION['register_error'] = 'Passwords do not match.';
                $this->redirect('register');
            }

            if ($this->adminModel->findByEmail($email)) {
                $_SESSION['register_error'] = 'Email already exists.';
                $this->redirect('register');
            }

            // ── Enforce single super admin ──────────────────────────
            if ($role === 'super_admin' && $this->adminModel->getSuperAdminCount() >= 1) {
                $_SESSION['register_error'] = 'A Super Admin already exists. You can only register as Admin.';
                $this->redirect('register');
            }

            $success = $this->adminModel->create([
                'name'     => $name,
                'email'    => $email,
                'password' => $password,
                'role'     => $role
            ]);

            if ($success) {
                // Auto-login after registration
                $admin = $this->adminModel->findByEmail($email);
                $_SESSION['admin_id']   = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];
                $_SESSION['admin_role'] = $admin['role'];
                $this->redirect('dashboard');
            } else {
                $_SESSION['register_error'] = 'Failed to create account. Please try again.';
                $this->redirect('register');
            }
        } else {
            $this->redirect('register');
        }
    }

    public function postLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $_SESSION['login_error'] = 'Please enter both email and password.';
                $this->redirect('login');
            }

            $admin = $this->adminModel->findByEmail($email);

            if ($admin && password_verify($password, $admin['password'])) {
                // Set session variables
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];
                $_SESSION['admin_role'] = $admin['role'];
                
                $this->redirect('dashboard');
            } else {
                $_SESSION['login_error'] = 'Invalid email or password.';
                $this->redirect('login');
            }
        } else {
            $this->redirect('login');
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        $this->redirect('login');
    }
}
