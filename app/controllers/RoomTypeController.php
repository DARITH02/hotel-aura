<?php
class RoomTypeController extends Controller {
    private $roomTypeModel;

    public function __construct() {
        $this->checkAuth();
        $this->roomTypeModel = new RoomType();
    }

    public function index() {
        $types = $this->roomTypeModel->getAllTypes();
        // Fetch gallery images for each type
        foreach ($types as &$type) {
            $type['gallery'] = $this->roomTypeModel->getGalleryImages($type['id']);
        }
        $this->view('room_types/index', [
            'title' => __('room_types'),
            'types' => $types
        ]);
    }

    private function handleMultipleImagesUpload($inputName = 'images') {
        $uploadedFiles = [];
        if (!isset($_FILES[$inputName]) || empty($_FILES[$inputName]['name'][0])) {
            return $uploadedFiles;
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $uploadDir = APP_DIR . '/../public/uploads/room_types/';
        
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                return $uploadedFiles;
            }
        }

        if (!is_writable($uploadDir)) {
            return $uploadedFiles;
        }

        $fileCount = count($_FILES[$inputName]['name']);
        for ($i = 0; $i < $fileCount; $i++) {
            if ($_FILES[$inputName]['error'][$i] === UPLOAD_ERR_OK) {
                if (in_array($_FILES[$inputName]['type'][$i], $allowedTypes)) {
                    $fileExtension = pathinfo($_FILES[$inputName]['name'][$i], PATHINFO_EXTENSION);
                    $fileName = uniqid() . '_' . $i . '.' . $fileExtension;
                    $targetPath = $uploadDir . $fileName;

                    if (move_uploaded_file($_FILES[$inputName]['tmp_name'][$i], $targetPath)) {
                        $uploadedFiles[] = $fileName;
                    }
                }
            }
        }
        return $uploadedFiles;
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $capacity = intval($_POST['capacity'] ?? 2);

            $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

            if ($name && $price >= 0) {
                try {
                    $uploadedImages = $this->handleMultipleImagesUpload('images');
                    $primaryImage = !empty($uploadedImages) ? $uploadedImages[0] : null;

                    $insertedId = $this->roomTypeModel->addType($name, $description, $price, $capacity, $primaryImage);
                    if ($insertedId && !empty($uploadedImages)) {
                        foreach ($uploadedImages as $img) {
                            $this->roomTypeModel->addGalleryImage($insertedId, $img);
                        }
                    }
                    
                    if ($isAjax) {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => true, 'message' => 'Room Type added successfully.', 'reload' => true]);
                        exit;
                    }
                    $_SESSION['success_msg'] = "Room Type added successfully.";
                } catch (Exception $e) {
                    if ($isAjax) {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
                        exit;
                    }
                    $_SESSION['error_msg'] = "Error adding room type.";
                }
            } else {
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Valid name and price are required.']);
                    exit;
                }
                $_SESSION['error_msg'] = "Valid name and price are required.";
            }
        }
        $this->redirect('room-types');
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $capacity = intval($_POST['capacity'] ?? 2);

            $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

            if ($id && $name && $price >= 0) {
                try {
                    $uploadedImages = $this->handleMultipleImagesUpload('images');
                    
                    $currentType = $this->roomTypeModel->getTypeById($id);
                    $primaryImage = null;

                    // If NO primary image exists, use the first new upload as primary
                    if (!empty($uploadedImages) && empty($currentType['image'])) {
                         $primaryImage = $uploadedImages[0];
                    }

                    $this->roomTypeModel->updateType($id, $name, $description, $price, $capacity, $primaryImage);
                    
                    if (!empty($uploadedImages)) {
                        foreach ($uploadedImages as $img) {
                            $this->roomTypeModel->addGalleryImage($id, $img);
                        }
                    }
                    
                    if ($isAjax) {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => true, 'message' => 'Room Type updated successfully.', 'reload' => true]);
                        exit;
                    }
                    $_SESSION['success_msg'] = "Room Type updated successfully.";
                } catch (Exception $e) {
                    if ($isAjax) {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
                        exit;
                    }
                    $_SESSION['error_msg'] = "Error updating room type.";
                }
            } else {
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Valid ID, name, and price are required.']);
                    exit;
                }
                $_SESSION['error_msg'] = "Valid ID, name, and price are required.";
            }
        }
        $this->redirect('room-types');
    }

    public function delete() {
        $this->checkSuperAdmin();
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            // Check if there are rooms using this type
            if ($this->roomTypeModel->countRoomsUsingType($id) > 0) {
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Cannot delete room type: It is being used by one or more rooms.']);
                    exit;
                }
                $_SESSION['error_msg'] = "Cannot delete room type: It is being used by one or more rooms.";
                $this->redirect('room-types');
                return;
            }

            try {
                // Delete old gallery images
                $galleryImages = $this->roomTypeModel->getGalleryImages($id);
                foreach ($galleryImages as $galImg) {
                    $galPath = APP_DIR . '/../public/uploads/room_types/' . $galImg['image'];
                    if (file_exists($galPath)) {
                        unlink($galPath);
                    }
                }

                $this->roomTypeModel->deleteType($id);
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Room Type deleted successfully.']);
                    exit;
                }
                $_SESSION['success_msg'] = "Room Type deleted successfully.";
            } catch (Exception $e) {
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
                    exit;
                }
                $_SESSION['error_msg'] = "Database error: Cannot delete this item. It might be referenced by other records.";
            }
        } else {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'ID not provided.']);
                exit;
            }
        }
        $this->redirect('room-types');
    }

    public function deleteGalleryImage() {
        $this->checkSuperAdmin();
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        if (isset($_GET['id'])) {
            $imageId = $_GET['id'];
            $image = $this->roomTypeModel->getGalleryImageById($imageId);
            if ($image) {
                $path = APP_DIR . '/../public/uploads/room_types/' . $image['image'];
                if (file_exists($path)) {
                    unlink($path);
                }
                $this->roomTypeModel->deleteGalleryImage($imageId);
                
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Image removed from gallery.']);
                    exit;
                }
                $_SESSION['success_msg'] = "Image removed.";
            }
        }
        $this->redirect('room-types');
    }
    public function deletePrimaryImage() {
        $this->checkSuperAdmin();
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $type = $this->roomTypeModel->getTypeById($id);
            if ($type && !empty($type['image'])) {
                $path = APP_DIR . '/../public/uploads/room_types/' . $type['image'];
                if (file_exists($path)) {
                    unlink($path);
                }
                $this->roomTypeModel->updateType($id, $type['name'], $type['description'], $type['price'], $type['capacity'], ''); // Clear the image
                
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Primary image removed.']);
                    exit;
                }
                $_SESSION['success_msg'] = "Primary image removed.";
            }
        }
        $this->redirect('room-types');
    }
}
