<?php
class AdminController extends Controller {
    private $adminModel;

    public function __construct() {
        $this->checkAuth();

        // ── Super Admin Gate ─────────────────────────────────────────
        if (($_SESSION['admin_role'] ?? '') !== 'super_admin') {
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Access denied. Super Admin only.']);
                exit;
            }
            $_SESSION['error_msg'] = 'Access denied. This section is restricted to Super Admins only.';
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }

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
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name     = trim($_POST['name'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $rawRole  = $_POST['role'] ?? 'admin';
            $role     = in_array($rawRole, ['admin', 'super_admin']) ? $rawRole : 'admin';

            $errors = [];
            if (empty($name))     $errors[] = 'Name is required.';
            if (empty($email))    $errors[] = 'Email is required.';
            if (empty($password)) $errors[] = 'Password is required.';
            if ($this->adminModel->findByEmail($email)) $errors[] = 'Email already exists.';

            // ── Enforce single super admin ──────────────────────────
            if ($role === 'super_admin' && $this->adminModel->getSuperAdminCount() >= 1) {
                $errors[] = 'A Super Admin already exists. Only one Super Admin is allowed in the system.';
            }

            if (empty($errors)) {
                $this->adminModel->create([
                    'name'     => $name,
                    'email'    => $email,
                    'password' => $password,
                    'role'     => $role
                ]);
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Admin added successfully.', 'reload' => true]);
                    exit;
                }
                $_SESSION['success_msg'] = 'Admin added successfully.';
            } else {
                if ($isAjax) {
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
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id       = $_POST['id'] ?? '';
            $name     = trim($_POST['name'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $rawRole  = $_POST['role'] ?? 'admin';
            $role     = in_array($rawRole, ['admin', 'super_admin']) ? $rawRole : 'admin';

            if ($id && $name && $email) {
                // ── Enforce single super admin ──────────────────────
                // Allow if: role is NOT super_admin, OR this admin is already the super_admin
                $existingSuperAdmin = $this->adminModel->getSuperAdmin();
                $isAlreadySuperAdmin = $existingSuperAdmin && ($existingSuperAdmin['id'] == $id);

                if ($role === 'super_admin' && !$isAlreadySuperAdmin && $this->adminModel->getSuperAdminCount() >= 1) {
                    $msg = 'A Super Admin already exists. Only one Super Admin is allowed.';
                    if ($isAjax) {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => false, 'message' => $msg]);
                        exit;
                    }
                    $_SESSION['error_msg'] = $msg;
                    $this->redirect('admins');
                    return;
                }

                $this->adminModel->update($id, [
                    'name'     => $name,
                    'email'    => $email,
                    'password' => $password,
                    'role'     => $role
                ]);
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Admin updated successfully.', 'reload' => true]);
                    exit;
                }
                $_SESSION['success_msg'] = 'Admin updated successfully.';
            }
        }
        $this->redirect('admins');
    }

    public function delete() {
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        // ── Role Gate: only super_admin can delete ──────────────────
        if (($_SESSION['admin_role'] ?? '') !== 'super_admin') {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Permission denied. Only Super Admins can delete administrators.']);
                exit;
            }
            $_SESSION['error_msg'] = 'Permission denied. Only Super Admins can delete administrators.';
            $this->redirect('admins');
            return;
        }

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            // Prevent self-deletion
            if ($id == $_SESSION['admin_id']) {
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'You cannot delete your own account!']);
                    exit;
                }
                $_SESSION['error_msg'] = 'You cannot delete your own account!';
            } else {
                $this->adminModel->delete($id);
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Admin deleted successfully.']);
                    exit;
                }
                $_SESSION['success_msg'] = 'Admin deleted successfully.';
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
