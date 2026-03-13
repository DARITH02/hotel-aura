<?php
class BookingController extends Controller {
    private $bookingModel;
    private $roomModel;
    private $guestModel;

    public function __construct() {
        $this->checkAuth();
        $this->bookingModel = new Booking();
        $this->roomModel = new Room();
        $this->guestModel = new Guest();
    }

    public function index() {
        $bookings = $this->bookingModel->getAllBookingsWithDetails();
        $this->view('bookings/index', [
            'title' => __('manage_bookings'),
            'bookings' => $bookings
        ]);
    }

    public function show() {
        $id = $_GET['id'] ?? 0;
        if (!$id) $this->redirect('bookings');

        $booking = $this->bookingModel->getBookingById($id);
        if (!$booking) $this->redirect('bookings');

        $serviceModel = new Service();
        $services = $serviceModel->getServicesForBooking($id);

        $paymentModel = new Payment();
        $payments = $paymentModel->getPaymentsByBooking($id);

        $allServices = $serviceModel->getAllServices();
        
        $this->view('bookings/show', [
            'title' => __('details') . " #$id",
            'booking' => $booking,
            'services' => $services,
            'payments' => $payments,
            'allServices' => $allServices
        ]);
    }

    public function create() {
        // Get all guests and available rooms for dropdowns
        $guests = $this->guestModel->getAllGuests();
        // Just get all rooms for the view, we can filter availability in JS or backend
        $rooms = $this->roomModel->getAllRoomsWithDetails();
        
        $this->view('bookings/create', [
            'title' => __('add_new'),
            'guests' => $guests,
            'rooms' => $rooms
        ]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'guest_id' => $_POST['guest_id'],
                'room_id' => $_POST['room_id'],
                'check_in' => $_POST['check_in'],
                'check_out' => $_POST['check_out'],
                'total_price' => floatval($_POST['total_price']),
                'status' => 'pending' // default for new bookings via admin
            ];

            if ($this->bookingModel->create($data)) {
                // Update room status to booked
                $room = $this->roomModel->getRoomById($data['room_id']);
                if ($room) {
                    $room['status'] = 'booked';
                    $this->roomModel->update($room['id'], $room);
                }
                
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => __("msg_booking_created"), 'reload' => true]);
                    exit;
                }

                $_SESSION['success_msg'] = __("msg_booking_created");
                $this->redirect('bookings');
            } else {
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => __("msg_booking_error")]);
                    exit;
                }

                $_SESSION['error_msg'] = __("msg_booking_error");
                $this->redirect('bookings/create'); 
            }
        }
    }

    /* Workflow Actions */
    public function confirm() {
        $id = $_GET['id'] ?? 0;
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        if ($id) {
            $booking = $this->bookingModel->getBookingById($id);
            if ($booking) {
                // 1. Update status in DB
                $this->bookingModel->updateStatus($id, 'confirmed');
                
                // 2. Update room status to occupied
                $room = $this->roomModel->getRoomById($booking['room_id']);
                if ($room) {
                    $room['status'] = 'occupied';
                    $this->roomModel->update($room['id'], $room);
                }

                // 3. TELEGRAM NOTIFICATION
                $botToken = "8642404952:AAFN6fsTjticiS0HcW4djWrQj5DOuT2-OFw"; 
                $chatId = "8642404952"; 
                
                $cleanPhone = str_replace(['+', ' ', '-'], '', $booking['guest_phone']);
                $message = "✅ *Booking CONFIRMED*\n\n";
                $message .= "*Booking ID:* #" . $id . "\n";
                $message .= "*Guest:* " . $booking['guest_name'] . "\n";
                $message .= "*Phone:* " . $booking['guest_phone'] . "\n";
                $message .= "*Room:* " . ($room['room_number'] ?? 'N/A') . "\n";
                $message .= "*Status:* Updated to Confirmed in DB\n";
                $message .= "*Amount:* $" . number_format($booking['total_price'], 2) . "\n\n";
                
                $message .= "💬 [Message Guest on Telegram](https://t.me/+" . $cleanPhone . ")";

                $url = "https://api.telegram.org/bot" . $botToken . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($message) . "&parse_mode=Markdown";
                @file_get_contents($url);

                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => __('msg_booking_confirmed'), 'reload' => true]);
                    exit;
                }
                $_SESSION['success_msg'] = __('msg_booking_confirmed');
            }
        }
        $this->redirect('bookings');
    }

    public function checkIn() {
        $id = $_GET['id'] ?? 0;
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if ($id) {
            $booking = $this->bookingModel->getBookingById($id);
            if ($booking) {
                // Update booking to occupied (Guest is now physically in the room)
                $this->bookingModel->updateStatus($id, 'occupied');
                
                // Ensure room is occupied
                $room = $this->roomModel->getRoomById($booking['room_id']);
                $room['status'] = 'occupied';
                $this->roomModel->update($room['id'], $room);
                
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => true, 
                        'message' => __('msg_checkin_success'), 
                        'roomId' => $room['id'], 
                        'newStatus' => 'occupied',
                        'reload' => true
                    ]);
                    exit;
                }
                $_SESSION['success_msg'] = __('msg_checkin_success');
            }
        }
        $this->redirect('bookings');
    }

    public function checkOut() {
        $id = $_GET['id'] ?? 0;
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if ($id) {
            $booking = $this->bookingModel->getBookingById($id);
            if ($booking) {
                // Update booking
                $this->bookingModel->updateStatus($id, 'checked_out');
                
                // Update room to available
                $room = $this->roomModel->getRoomById($booking['room_id']);
                $room['status'] = 'available';
                $this->roomModel->update($room['id'], $room);
                
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => true, 
                        'message' => __('msg_checkout_success'), 
                        'roomId' => $room['id'], 
                        'newStatus' => 'available',
                        'reload' => true
                    ]);
                    exit;
                }
                $_SESSION['success_msg'] = __('msg_checkout_success');
            }
        }
        $this->redirect('bookings');
    }

    public function cancel() {
        $id = $_GET['id'] ?? 0;
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if ($id) {
            $booking = $this->bookingModel->getBookingById($id);
            if ($booking) {
                // Update booking
                $this->bookingModel->updateStatus($id, 'cancelled');
                
                // Free room if it was previously confirmed/checked-in/pending
                $room = $this->roomModel->getRoomById($booking['room_id']);
                $room['status'] = 'available';
                $this->roomModel->update($room['id'], $room);
                
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => true, 
                        'message' => __('msg_booking_cancelled'), 
                        'roomId' => $room['id'], 
                        'newStatus' => 'available',
                        'reload' => true
                    ]);
                    exit;
                }
                $_SESSION['success_msg'] = __('msg_booking_cancelled');
            }
        }
        $this->redirect('bookings');
    }
}
