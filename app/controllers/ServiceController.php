<?php
class ServiceController extends Controller {
    private $serviceModel;
    private $bookingModel;

    public function __construct() {
        $this->checkAuth();
        $this->serviceModel = new Service();
        $this->bookingModel = new Booking();
    }

    public function index() {
        $booking_id = $_GET['booking_id'] ?? 0;
        
        if ($booking_id) {
            // View for adding services to a specific booking
            $booking = $this->bookingModel->getBookingById($booking_id);
            if (!$booking) $this->redirect('bookings');
            
            $allServices = $this->serviceModel->getAllServices();
            $bookingServices = $this->serviceModel->getServicesForBooking($booking_id);
            
            $this->view('services/booking_services', [
                'title' => __('manage_services'),
                'booking' => $booking,
                'allServices' => $allServices,
                'bookingServices' => $bookingServices
            ]);
        } else {
            // View for managing completely general services catalog
            $services = $this->serviceModel->getAllServices();
            $this->view('services/index', [
                'title' => __('services'),
                'services' => $services
            ]);
        }
    }

    private function handleImageUpload($inputName = 'image') {
        if (!isset($_FILES[$inputName]) || $_FILES[$inputName]['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($_FILES[$inputName]['type'], $allowedTypes)) {
            return null;
        }

        $uploadDir = APP_DIR . '/../public/uploads/services/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileExtension = pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION);
        $fileName = uniqid() . '.' . $fileExtension;
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $targetPath)) {
            return $fileName;
        }

        return null;
    }

    // Catalog CRUD
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description'] ?? ''),
                'price' => floatval($_POST['price']),
                'image' => $this->handleImageUpload('image')
            ];

            $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

            if ($data['name'] && $data['price'] >= 0) {
                $this->serviceModel->create($data);
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Service added successfully.', 'reload' => true]);
                    exit;
                }
                $_SESSION['success_msg'] = "Service added successfully.";
            } else {
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Invalid service data.']);
                    exit;
                }
                $_SESSION['error_msg'] = "Invalid service data.";
            }
        }
        $this->redirect('services');
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $data = [
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description'] ?? ''),
                'price' => floatval($_POST['price'])
            ];

            $uploadedImage = $this->handleImageUpload('image');
            if ($uploadedImage) {
                $data['image'] = $uploadedImage;
            }

            $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

            if ($id && $data['name'] && $data['price'] >= 0) {
                $this->serviceModel->update($id, $data);
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Service updated successfully.', 'reload' => true]);
                    exit;
                }
                $_SESSION['success_msg'] = "Service updated successfully.";
            } else {
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Invalid service data.']);
                    exit;
                }
                $_SESSION['error_msg'] = "Invalid service data.";
            }
        }
        $this->redirect('services');
    }

    public function delete() {
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if (isset($_GET['id'])) {
            try {
                $this->serviceModel->delete($_GET['id']);
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Service deleted successfully.']);
                    exit;
                }
                $_SESSION['success_msg'] = "Service deleted successfully.";
            } catch (PDOException $e) {
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Cannot delete service. It may be linked to existing bookings.']);
                    exit;
                }
                $_SESSION['error_msg'] = "Cannot delete service. It may be linked to existing bookings.";
            }
        } else {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'ID not provided.']);
                exit;
            }
        }
        $this->redirect('services');
    }

    // Booking Services mapping
    public function addToBooking() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $booking_id = $_POST['booking_id'];
            $service_id = $_POST['service_id'];
            $quantity = intval($_POST['quantity']);

            if ($booking_id && $service_id && $quantity > 0) {
                if ($this->serviceModel->addServiceToBooking($booking_id, $service_id, $quantity)) {
                    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => true, 'message' => 'Service added and bill updated.', 'reload' => true]);
                        exit;
                    }
                    $_SESSION['success_msg'] = "Service added and bill updated.";
                } else {
                    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => false, 'message' => 'Error adding service.']);
                        exit;
                    }
                    $_SESSION['error_msg'] = "Error adding service.";
                }
            } else {
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Invalid service assignment data.']);
                    exit;
                }
                $_SESSION['error_msg'] = "Invalid service assignment data.";
            }
            
            $this->redirect("services?booking_id=$booking_id");
        }
    }
}
