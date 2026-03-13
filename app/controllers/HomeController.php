<?php
class HomeController extends Controller {
    // We don't call checkAuth() here because these are public pages

    public function index() {
        $roomTypeModel = new RoomType();
        $roomTypes = $roomTypeModel->getAllTypes();
        
        // We can either serve the static HTML or include it as a view
        // For now, let's allow the MVC to serve it
        $this->fullView('frontend/index', ['roomTypes' => $roomTypes]);
    }

    public function about() {
        $this->fullView('frontend/about');
    }

    public function rooms() {
        $roomTypeModel = new RoomType();
        $roomTypes = $roomTypeModel->getAllTypes();
        
        // Fetch gallery images for fallback or slider
        foreach ($roomTypes as &$type) {
            $type['gallery'] = $roomTypeModel->getGalleryImages($type['id']);
        }
        
        $this->fullView('frontend/rooms', ['roomTypes' => $roomTypes]);
    }

    public function services() {
        $serviceModel = new Service();
        $services = $serviceModel->getAllServices();
        $this->fullView('frontend/services', ['services' => $services]);
    }

    public function gallery() {
        $roomTypeModel = new RoomType();
        $roomTypes = $roomTypeModel->getAllTypes();
        
        $images = [];
        foreach ($roomTypes as $type) {
            if ($type['image']) $images[] = ['src' => $type['image'], 'title' => $type['name']];
            
            $gallery = $roomTypeModel->getGalleryImages($type['id']);
            foreach ($gallery as $img) {
                $images[] = ['src' => $img['image'], 'title' => $type['name']];
            }
        }
        
        $this->fullView('frontend/gallery', ['images' => $images]);
    }

    public function contact() {
        $this->fullView('frontend/contact');
    }

    public function booking() {
        $roomTypeModel = new RoomType();
        $roomTypes = $roomTypeModel->getAllTypes();
        $this->fullView('frontend/booking', ['roomTypes' => $roomTypes]);
    }

    public function roomDetails() {
        $id = $_GET['id'] ?? null;
        if (!$id) $this->redirect('our-rooms');
        
        $roomTypeModel = new RoomType();
        $roomType = $roomTypeModel->getTypeById($id);
        if (!$roomType) $this->redirect('our-rooms');
        
        $gallery = $roomTypeModel->getGalleryImages($id);
        
        $this->fullView('frontend/room-details', [
            'room' => $roomType,
            'gallery' => $gallery
        ]);
    }

    public function submitReservation() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['full_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $check_in = $_POST['check_in'] ?? '';
            $check_out = $_POST['check_out'] ?? '';
            $room_type_id = $_POST['room_type_id'] ?? '';
            $description = $_POST['description'] ?? '';

            // Require models
            $guestModel = new Guest();
            $roomModel = new Room();
            $bookingModel = new Booking();
            $roomTypeModel = new RoomType();

            // 1. Handle Guest (create if not exists)
            $existingGuests = $guestModel->searchGuests($phone);
            if (empty($existingGuests)) {
                // If not found by phone, check by email if provided
                if ($email) {
                    $existingGuests = $guestModel->searchGuests($email);
                }
            }

            if (empty($existingGuests)) {
                $guestModel->create([
                    'name' => $name,
                    'phone' => $phone,
                    'email' => $email,
                    'address' => 'AURA Website Reservation'
                ]);
                // Use the database connection from the model to get the last ID
                $guest_id = $guestModel->getLastId();
            } else {
                $guest_id = $existingGuests[0]['id'];
                // Update existing guest info if needed
                $guestModel->update($guest_id, [
                    'name' => $name,
                    'phone' => $phone,
                    'email' => $email,
                    'address' => $existingGuests[0]['address'] ?? 'Website'
                ]);
            }

            // 2. Find Available Room
            $room = $roomModel->getAvailableRoomByType($room_type_id);
            if (!$room) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'No rooms of this type available for the selected dates.']);
                exit;
            }

            // 3. Calculate Price
            $type = $roomTypeModel->getTypeById($room_type_id);
            $total_price = $type['price']; // Base price (could add night multiplier if needed)

            // 4. Create Booking
            $data = [
                'guest_id' => $guest_id,
                'room_id' => $room['id'],
                'check_in' => $check_in,
                'check_out' => $check_out,
                'total_price' => $total_price,
                'status' => 'pending'
            ];

            if ($bookingModel->create($data)) {
                // Update room to booked
                $room['status'] = 'booked';
                $roomModel->update($room['id'], $room);

                // 5. Telegram Notification
                $botToken = "8642404952:AAFN6fsTjticiS0HcW4djWrQj5DOuT2-OFw"; 
                $chatId = "8642404952"; 
                
                $cleanPhone = str_replace(['+', ' ', '-'], '', $phone);
                $message = "🛎 *New Booking Request*\n\n";
                $message .= "*Guest:* " . $name . "\n";
                $message .= "*Phone:* " . $phone . "\n";
                $message .= "*Room Type:* " . $type['name'] . "\n";
                $message .= "*Check-in:* " . $check_in . "\n";
                $message .= "*Check-out:* " . $check_out . "\n";
                $message .= "*Total Est.:* $" . number_format($total_price, 2) . "\n";
                if ($description) $message .= "*Note:* " . $description . "\n\n";
                
                $message .= "💬 [Chat with Guest](https://t.me/+" . $cleanPhone . ")\n";
                $message .= "🏨 [Confirm in Dashboard](" . BASE_URL . "/bookings)";

                $url = "https://api.telegram.org/bot" . $botToken . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($message) . "&parse_mode=Markdown";
                @file_get_contents($url);

                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true, 
                    'message' => __('msg_booking_created'),
                    'guestId' => $guest_id
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => __('msg_booking_error')]);
            }
            exit;
        }
    }

    /**
     * Helper to render a full page without the admin layout
     */
    private function fullView($path, $data = []) {
        extract($data);
        $file = ROOT_DIR . DS . 'public' . DS . $path . '.php';
        if (file_exists($file)) {
            require_once $file;
        } else {
            die("Frontend page $path not found at: " . $file);
        }
    }
}
