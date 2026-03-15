<?php
class FloorController extends Controller {
    private $floorModel;

    public function __construct() {
        $this->checkAuth();
        $this->floorModel = new Floor();
    }

    public function index() {
        $floors = $this->floorModel->getAllFloors();
        $this->view('floors/index', [
            'title' => __('floors'),
            'floors' => $floors
        ]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $floor_number = $_POST['floor_number'] ?? '';
            $description = $_POST['description'] ?? '';

            $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

            if ($floor_number) {
                $this->floorModel->addFloor($floor_number, $description);
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Floor added successfully.', 'reload' => true]);
                    exit;
                }
                $_SESSION['success_msg'] = "Floor added successfully.";
            } else {
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Floor number is required.']);
                    exit;
                }
                $_SESSION['error_msg'] = "Floor number is required.";
            }
        }
        $this->redirect('floors');
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $floor_number = $_POST['floor_number'] ?? '';
            $description = $_POST['description'] ?? '';

            $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

            if ($id && $floor_number) {
                $this->floorModel->updateFloor($id, $floor_number, $description);
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Floor updated successfully.', 'reload' => true]);
                    exit;
                }
                $_SESSION['success_msg'] = "Floor updated successfully.";
            } else {
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Valid Floor ID and number are required.']);
                    exit;
                }
                $_SESSION['error_msg'] = "Valid Floor ID and number are required.";
            }
        }
        $this->redirect('floors');
    }

    public function delete() {
        $this->checkSuperAdmin();
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            // Check if there are rooms on this floor
            if ($this->floorModel->countRooms($id) > 0) {
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Cannot delete floor: It still has rooms. Move or delete rooms first.']);
                    exit;
                }
                $_SESSION['error_msg'] = "Cannot delete floor: It still has rooms. Move or delete rooms first.";
                $this->redirect('floors');
                return;
            }

            try {
                $this->floorModel->deleteFloor($id);
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Floor deleted successfully.']);
                    exit;
                }
                $_SESSION['success_msg'] = "Floor deleted successfully.";
            } catch (Exception $e) {
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
                    exit;
                }
                $_SESSION['error_msg'] = "Database error: Cannot delete this floor. It might be referenced by other records.";
            }
        } else {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'ID not provided.']);
                exit;
            }
        }
        $this->redirect('floors');
    }
}
