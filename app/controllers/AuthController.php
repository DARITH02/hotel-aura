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


        $this->view('auth/register', [
            'error'            => $error
        ]);
    }

    public function postRegister() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
            $name             = trim($_POST['name'] ?? '');
            $email            = trim($_POST['email'] ?? '');
            $password         = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $rawRole          = $_POST['role'] ?? 'admin';
            $role             = in_array($rawRole, ['admin', 'super_admin']) ? $rawRole : 'admin';

            $error = '';
            if (empty($name) || empty($email) || empty($password)) {
                $error = 'Please fill out all fields.';
            } elseif ($password !== $confirm_password) {
                $error = 'Passwords do not match.';
            } elseif ($this->adminModel->findByEmail($email)) {
                $error = 'Email already exists.';
            } elseif ($role === 'super_admin') {
                $accessKey    = $_POST['access_key'] ?? '';
                $config       = require ROOT_DIR . '/config/config.php';
                $masterSecret = $config['auth']['master_access_key'] ?? '';
                if ($accessKey !== $masterSecret) {
                    $error = 'Invalid Master Access Key. Unauthorized Super Admin registration.';
                }
            }

            if ($error) {
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => $error]);
                    exit;
                }
                $_SESSION['register_error'] = $error;
                $this->redirect('register');
                return;
            }

            $success = $this->adminModel->create([
                'name'     => $name,
                'email'    => $email,
                'password' => $password,
                'role'     => $role
            ]);

            if ($success) {
                $admin = $this->adminModel->findByEmail($email);
                $_SESSION['admin_id']   = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];
                $_SESSION['admin_role'] = $admin['role'];

                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'redirect' => BASE_URL . '/dashboard']);
                    exit;
                }
                $this->redirect('dashboard');
            } else {
                $error = 'Failed to create account. Please try again.';
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => $error]);
                    exit;
                }
                $_SESSION['register_error'] = $error;
                $this->redirect('register');
            }
        } else {
            $this->redirect('register');
        }
    }

    public function postLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $error = 'Please enter both email and password.';
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => $error]);
                    exit;
                }
                $_SESSION['login_error'] = $error;
                $this->redirect('login');
                return;
            }

            $admin = $this->adminModel->findByEmail($email);

            if ($admin && password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];
                $_SESSION['admin_role'] = $admin['role'];
                
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'redirect' => BASE_URL . '/dashboard']);
                    exit;
                }
                $this->redirect('dashboard');
            } else {
                $error = 'Invalid email or password.';
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => $error]);
                    exit;
                }
                $_SESSION['login_error'] = $error;
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
