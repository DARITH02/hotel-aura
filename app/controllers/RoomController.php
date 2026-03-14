<?php
class RoomController extends Controller {
    private $roomModel;
    private $floorModel;
    private $roomTypeModel;

    public function __construct() {
        $this->checkAuth();
        $this->roomModel = new Room();
        $this->floorModel = new Floor();
        $this->roomTypeModel = new RoomType();
    }

    public function index() {
        $rooms = $this->roomModel->getAllRoomsWithDetails();
        
        // Group rooms by floor for the Visual Layout Grid
        $floors = [];
        $allFloors = $this->floorModel->getAllFloors();
        
        // Initialize the array structure with all floors so empty floors still show up
        foreach ($allFloors as $floor) {
            $floors[$floor['floor_number']] = [
                'id' => $floor['id'],
                'description' => $floor['description'],
                'rooms' => []
            ];
        }
        
        // Populate the rooms into their respective floors
        foreach ($rooms as $room) {
            if (isset($floors[$room['floor_number']])) {
                $floors[$room['floor_number']]['rooms'][] = $room;
            }
        }
        
        // Sort floors descending (highest floor at the top)
        krsort($floors);

        $this->view('rooms/index', [
            'title' => 'Manage Rooms',
            'floorsLayout' => $floors,
            'allRooms' => $rooms // For the table view
        ]);
    }

    private function handleImageUpload($inputName = 'image') {
        if (!isset($_FILES[$inputName]) || $_FILES[$inputName]['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($_FILES[$inputName]['type'], $allowedTypes)) {
            return null;
        }

        $uploadDir = APP_DIR . '/../public/uploads/rooms/';
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

    public function create() {
        $this->view('rooms/create', [
            'title' => 'Add Room',
            'floors' => $this->floorModel->getAllFloors(),
            'roomTypes' => $this->roomTypeModel->getAllTypes()
        ]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'room_number' => trim($_POST['room_number'] ?? ''),
                'floor_id' => $_POST['floor_id'] ?? '',
                'room_type_id' => $_POST['room_type_id'] ?? '',
                'status' => $_POST['status'] ?? 'available',
                'image' => $this->handleImageUpload('image')
            ];

            if ($data['room_number'] && $data['floor_id'] && $data['room_type_id']) {
                try {
                    $this->roomModel->create($data);
                    
                    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => true, 'message' => "Room added successfully.", 'reload' => true]);
                        exit;
                    }

                    $_SESSION['success_msg'] = "Room added successfully.";
                } catch (PDOException $e) {
                    $msg = ($e->errorInfo[1] == 1062) ? "Room number already exists." : "Error adding room.";
                    
                    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => false, 'message' => $msg]);
                        exit;
                    }
                    $_SESSION['error_msg'] = $msg;
                }
            } else {
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => "Please fill in all required fields."]);
                    exit;
                }
                $_SESSION['error_msg'] = "Please fill in all required fields.";
            }
        }
        $this->redirect('rooms');
    }

    public function edit() {
        $id = $_GET['id'] ?? 0;
        $room = $this->roomModel->getRoomById($id);
        
        if (!$room) {
            $this->redirect('rooms');
        }
        
        $this->view('rooms/edit', [
            'title' => 'Edit Room',
            'room' => $room,
            'floors' => $this->floorModel->getAllFloors(),
            'roomTypes' => $this->roomTypeModel->getAllTypes()
        ]);
    }
    
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $data = [
                'room_number' => trim($_POST['room_number'] ?? ''),
                'floor_id' => $_POST['floor_id'] ?? '',
                'room_type_id' => $_POST['room_type_id'] ?? '',
                'status' => $_POST['status'] ?? 'available'
            ];

            $uploadedImage = $this->handleImageUpload('image');
            if ($uploadedImage) {
                $data['image'] = $uploadedImage;
            }

            if ($id && $data['room_number'] && $data['floor_id'] && $data['room_type_id']) {
                try {
                    $this->roomModel->update($id, $data);
                    
                    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => true, 'message' => "Room updated successfully.", 'reload' => true]);
                        exit;
                    }

                    $_SESSION['success_msg'] = "Room updated successfully.";
                } catch (PDOException $e) {
                    $msg = ($e->errorInfo[1] == 1062) ? "Room number already exists." : "Error updating room.";
                    
                    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => false, 'message' => $msg]);
                        exit;
                    }
                    $_SESSION['error_msg'] = $msg;
                }
            } else {
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => "Please fill in all required fields."]);
                    exit;
                }
                $_SESSION['error_msg'] = "Please fill in all required fields.";
            }
        }
        $this->redirect('rooms');
    }
    
    public function delete() {
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Check if room has any bookings
            $bookingCount = $this->roomModel->countBookings($id);
            if ($bookingCount > 0) {
                $msg = "Cannot delete room: it has {$bookingCount} booking(s) on record. Cancel or delete the bookings first.";
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => $msg]);
                    exit;
                }
                $_SESSION['error_msg'] = $msg;
                $this->redirect('rooms');
                return;
            }

            try {
                $this->roomModel->delete($id);
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Room deleted successfully.']);
                    exit;
                }
                $_SESSION['success_msg'] = 'Room deleted successfully.';
            } catch (Exception $e) {
                $msg = 'Cannot delete room: it is linked to existing records.';
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
        $this->redirect('rooms');
    }
}
