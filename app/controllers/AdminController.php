<?php
class AdminController extends Controller {
    private $adminModel;

    public function __construct() {
        $this->checkAuth();
        $this->adminModel = new Admin();
    }

    public function index() {
        $admins = $this->adminModel->getAll();
        $this->view('admins/index', [
            'title' => __('manage_admins'),
            'admins' => $admins
        ]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'admin';

            $errors = [];
            if (empty($name)) $errors[] = "Name is required.";
            if (empty($email)) $errors[] = "Email is required.";
            if (empty($password)) $errors[] = "Password is required.";
            if ($this->adminModel->findByEmail($email)) $errors[] = "Email already exists.";

            if (empty($errors)) {
                $this->adminModel->create([
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                    'role' => $role
                ]);
                
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Admin added successfully.', 'reload' => true]);
                    exit;
                }
                $_SESSION['success_msg'] = "Admin added successfully.";
            } else {
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
                    exit;
                }
                $_SESSION['error_msg'] = implode(' ', $errors);
            }
        }
        $this->redirect('admins');
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'admin';

            if ($id && $name && $email) {
                $this->adminModel->update($id, [
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                    'role' => $role
                ]);
                
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Admin updated successfully.', 'reload' => true]);
                    exit;
                }
                $_SESSION['success_msg'] = "Admin updated successfully.";
            }
        }
        $this->redirect('admins');
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            // Prevent self-deletion
            if ($id == $_SESSION['admin_id']) {
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'You cannot delete yourself!']);
                    exit;
                }
                $_SESSION['error_msg'] = "You cannot delete yourself!";
            } else {
                $this->adminModel->delete($id);
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Admin deleted successfully.']);
                    exit;
                }
                $_SESSION['success_msg'] = "Admin deleted successfully.";
            }
        }
        $this->redirect('admins');
    }

    public function profile() {
        $admin = $this->adminModel->findById($_SESSION['admin_id']);
        $this->view('admins/profile', [
            'title' => __('profile_settings'),
            'admin' => $admin
        ]);
    }

    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_SESSION['admin_id'];
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $admin = $this->adminModel->findById($id);

            if ($id && $name && $email) {
                // Check if email is already taken by another admin
                $existing = $this->adminModel->findByEmail($email);
                if ($existing && $existing['id'] != $id) {
                    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => false, 'message' => 'Email already exists.']);
                        exit;
                    }
                    $_SESSION['error_msg'] = "Email already exists.";
                    $this->redirect('admins/profile');
                    return;
                }

                $this->adminModel->update($id, [
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                    'role' => $admin['role'] // Keep existing role
                ]);

                // Update session data
                $_SESSION['admin_name'] = $name;
                $_SESSION['admin_email'] = $email;
                
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Profile updated successfully.', 'reload' => true]);
                    exit;
                }
                $_SESSION['success_msg'] = "Profile updated successfully.";
            }
        }
        $this->redirect('admins/profile');
    }
}
