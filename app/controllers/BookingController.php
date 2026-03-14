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
        
        // Calculate Statistics
        $totalBookings = count($bookings);
        $totalNights = 0;
        $totalRevenue = 0;
        
        foreach ($bookings as $booking) {
            $checkIn = new DateTime($booking['check_in']);
            $checkOut = new DateTime($booking['check_out']);
            $nights = $checkIn->diff($checkOut)->days;
            $totalNights += $nights;
            $totalRevenue += $booking['total_price'];
        }

        $this->view('bookings/index', [
            'title' => __('manage_bookings'),
            'bookings' => $bookings,
            'stats' => [
                'total_bookings' => $totalBookings,
                'total_nights' => $totalNights,
                'total_revenue' => $totalRevenue
            ]
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
                'status' => 'pending', // default for new bookings via admin
                'online_book' => 0 // Manual booking from admin
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

                // 3. TELEGRAM NOTIFICATION (Helper handles Admin + Guest)
                $this->notifyTelegram($booking, 'confirmed');

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

                // Notify Telegram
                $updatedBooking = $this->bookingModel->getBookingById($id); // Get fresh data for total price/details
                $this->notifyTelegram($updatedBooking, 'occupied');
                
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
                // 1. Check if balance is cleared before checkout
                $paymentModel = new Payment();
                $payments = $paymentModel->getPaymentsByBooking($id);
                $totalPaid = array_sum(array_column($payments, 'amount'));
                $balance = $booking['total_price'] - $totalPaid;

                if ($balance > 0.01) { // Allowance for minor float precision
                    if ($isAjax) {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => false, 'message' => __('msg_payment_required') . " (Balance: $" . number_format($balance, 2) . ")"]);
                        exit;
                    }
                    $_SESSION['error_msg'] = __('msg_payment_required');
                    $this->redirect('bookings/show?id=' . $id);
                    return;
                }

                // 2. Update booking
                $this->bookingModel->updateStatus($id, 'checked_out');
                
                // 3. Update room to available
                $room = $this->roomModel->getRoomById($booking['room_id']);
                $room['status'] = 'available';
                $this->roomModel->update($room['id'], $room);

                // 4. Load detailed booking for notification
                $updatedBooking = $this->bookingModel->getBookingById($id);
                $this->notifyTelegram($updatedBooking, 'checked_out');
                
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

                // Notify Telegram
                $this->notifyTelegram($booking, 'cancelled');
                
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

    /**
     * Unified Telegram Notification Helper
     * Notifies Admin and Guest (if linked)
     */
    private function notifyTelegram($booking, $status) {
        if (!$booking) return;

        // Configuration
        $botToken = "8642404952:AAFN6fsTjticiS0HcW4djWrQj5DOuT2-OFw";
        $adminChatId = "8776827027"; // Hotel Admin/Channel (Fixed from logs)
        
        // Fetch Payment Summary for this booking
        $paymentModel = new Payment();
        $payments = $paymentModel->getPaymentsByBooking($booking['id']);
        $totalPaid = array_sum(array_column($payments, 'amount'));
        $balance = $booking['total_price'] - $totalPaid;

        $statusEmoji = [
            'confirmed' => '✅',
            'occupied' => '🔑',
            'checked_out' => '🧾',
            'cancelled' => '❌'
        ];
        
        $emoji = $statusEmoji[$status] ?? 'ℹ️';
        // Force uppercase for status in both languages
        $statusEN = strtoupper(str_replace('_', ' ', $status)); 
        $statusKH = strtoupper(__($status));

        // Format Admin Message (Bilingual Labels for Professionalism & Clarity)
        $adminMsg = "$emoji *Booking $statusEN / " . __('tg_booking_status') . ": $statusKH*\n";
        $adminMsg .= "━━━━━━━━━━━━━━━━━━\n";
        $adminMsg .= "🆔 *ID:* #" . $booking['id'] . " / " . __('id') . "\n";
        $adminMsg .= "👤 *Guest:* " . $booking['guest_name'] . " / " . __('tg_guest') . "\n";
        $adminMsg .= "📞 *Phone:* " . $booking['guest_phone'] . " / " . __('tg_phone') . "\n";
        $adminMsg .= "🚪 *Room:* #" . ($booking['room_number'] ?? 'N/A') . " / " . __('tg_room') . "\n";
        $adminMsg .= "📅 *Stay:* " . date('d M', strtotime($booking['check_in'])) . " - " . date('d M', strtotime($booking['check_out'])) . " / " . __('tg_stay') . "\n";
        $adminMsg .= "━━━━━━━━━━━━━━━━━━\n";
        $adminMsg .= "💰 *Total:* $" . number_format($booking['total_price'], 2) . " / " . __('tg_total') . "\n";
        $adminMsg .= "💵 *Paid:* $" . number_format($totalPaid, 2) . " / " . __('tg_paid') . "\n";
        $adminMsg .= "🛑 *Balance:* $" . number_format($balance, 2) . " / " . __('tg_balance') . "\n";
        $adminMsg .= "━━━━━━━━━━━━━━━━━━\n\n";
        
        $cleanPhone = str_replace(['+', ' ', '-'], '', $booking['guest_phone']);
        $adminMsg .= "💬 [" . __('tg_chat_with_guest') . " / " . __('tg_chat_with_guest') . "](https://t.me/+" . $cleanPhone . ")";

        // 1. Notify Admin (REPLACE THIS ID WITH YOUR OWN ID FROM @userinfobot)
        $this->sendTelegramMessage($adminChatId, $adminMsg);
        
        // 2. Notify Guest if they have linked their Telegram
        if (!empty($booking['telegram_chat_id'])) {
            $guestMsg = "Hello " . $booking['guest_name'] . "! 👋\n";
            $guestMsg .= "Your booking # " . $booking['id'] . " status: *$statusEN*\n";
            $guestMsg .= "---------------------\n";
            $guestMsg .= "សួស្តី " . $booking['guest_name'] . "! 👋\n";
            $guestMsg .= "ការកក់លេខ " . $booking['id'] . " ស្ថានភាព: *$statusKH*\n\n";
            
            $guestMsg .= "💰 *Total / " . __('tg_total') . ":* $" . number_format($booking['total_price'], 2) . "\n";
            $guestMsg .= "💵 *Paid / " . __('tg_paid') . ":* $" . number_format($totalPaid, 2) . "\n";
            $guestMsg .= "🛑 *Balance / " . __('tg_balance') . ":* $" . number_format($balance, 2) . "\n\n";
            
            $guestMsg .= "Thank you for choosing AURA / សូមអរគុណ!";

            $this->sendTelegramMessage($booking['telegram_chat_id'], $guestMsg);
        }
    }
}
