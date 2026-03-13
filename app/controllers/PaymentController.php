<?php
class PaymentController extends Controller {
    private $paymentModel;
    private $bookingModel;

    public function __construct() {
        $this->checkAuth();
        $this->paymentModel = new Payment();
        $this->bookingModel = new Booking();
    }

    public function index() {
        $payments = $this->paymentModel->getAllPayments();
        
        $this->view('payments/index', [
            'title' => __('manage_payments'),
            'payments' => $payments
        ]);
    }

    public function create() {
        $booking_id = $_GET['booking_id'] ?? 0;
        $booking = null;
        $existingPayments = [];
        $balance = 0;
        
        if ($booking_id) {
            $booking = $this->bookingModel->getBookingById($booking_id);
            if ($booking) {
                $existingPayments = $this->paymentModel->getPaymentsByBooking($booking_id);
                $totalPaid = array_sum(array_column($existingPayments, 'amount'));
                $balance = $booking['total_price'] - $totalPaid;
            }
        }
        
        // If not a specific booking, get all non-cancelled bookings
        $allBookings = [];
        if (!$booking) {
            $rawBookings = $this->bookingModel->getAllBookingsWithDetails();
            foreach ($rawBookings as $b) {
                if ($b['status'] != 'cancelled') {
                    $allBookings[] = $b;
                }
            }
        }

        $this->view('payments/create', [
            'title' => __('add_new'),
            'booking' => $booking,
            'existingPayments' => $existingPayments,
            'balance' => $balance,
            'allBookings' => $allBookings
        ]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'booking_id' => $_POST['booking_id'],
                'amount' => floatval($_POST['amount']),
                'payment_method' => $_POST['payment_method']
            ];

            if ($data['booking_id'] && $data['amount'] > 0) {
                $this->paymentModel->create($data);
                
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => "Payment recorded successfully.", 'reload' => true]);
                    exit;
                }
                
                $_SESSION['success_msg'] = "Payment recorded successfully.";
            } else {
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => "Invalid payment data."]);
                    exit;
                }

                $_SESSION['error_msg'] = "Invalid payment data.";
            }
        }
        $this->redirect('payments');
    }
}
