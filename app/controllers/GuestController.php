<?php
class GuestController extends Controller {
    private $guestModel;

    public function __construct() {
        $this->checkAuth();
        $this->guestModel = new Guest();
    }

    public function index() {
        $search = $_GET['search'] ?? '';
        
        if ($search) {
            $guests = $this->guestModel->searchGuests($search);
        } else {
            $guests = $this->guestModel->getAllGuests();
        }

        $stats = $this->guestModel->getGuestStats();

        $this->view('guests/index', [
            'title' => __('manage_guests'),
            'guests' => $guests,
            'search' => $search,
            'stats' => $stats
        ]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'phone' => trim($_POST['phone'] ?? ''),
                'address' => trim($_POST['address'] ?? '')
            ];

            $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

            if ($data['name']) {
                $this->guestModel->create($data);
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Guest added successfully.', 'reload' => true]);
                    exit;
                }
                $_SESSION['success_msg'] = "Guest added successfully.";
            } else {
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Guest name is required.']);
                    exit;
                }
                $_SESSION['error_msg'] = "Guest name is required.";
            }
        }
        $this->redirect('guests');
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'phone' => trim($_POST['phone'] ?? ''),
                'address' => trim($_POST['address'] ?? '')
            ];

            $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

            if ($id && $data['name']) {
                $this->guestModel->update($id, $data);
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Guest updated successfully.', 'reload' => true]);
                    exit;
                }
                $_SESSION['success_msg'] = "Guest updated successfully.";
            } else {
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Valid ID and Name are required.']);
                    exit;
                }
                $_SESSION['error_msg'] = "Valid ID and Name are required.";
            }
        }
        $this->redirect('guests');
    }

    public function delete() {
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Check if guest has any bookings before deleting
            $bookingCount = $this->guestModel->countBookings($id);
            if ($bookingCount > 0) {
                $msg = "Cannot delete guest: they have {$bookingCount} booking(s) on record. Cancel or delete the bookings first.";
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => $msg]);
                    exit;
                }
                $_SESSION['error_msg'] = $msg;
                $this->redirect('guests');
                return;
            }

            try {
                $this->guestModel->delete($id);
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Guest deleted successfully.']);
                    exit;
                }
                $_SESSION['success_msg'] = "Guest deleted successfully.";
            } catch (Exception $e) {
                $msg = 'Cannot delete guest: they are linked to existing records.';
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => $msg]);
                    exit;
                }
                $_SESSION['error_msg'] = $msg;
            }
        } else {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'ID not provided.']);
                exit;
            }
        }
        $this->redirect('guests');
    }
}
