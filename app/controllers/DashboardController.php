<?php
class DashboardController extends Controller {
    public function index() {
        $this->checkAuth();
        
        require_once APP_DIR . '/models/Dashboard.php';
        $dashboardModel = new Dashboard();
        
        $stats = $dashboardModel->getQuickStats();
        $recentBookings = $dashboardModel->getRecentBookings(5);
        $roomStatuses = $dashboardModel->getRoomStatusCounts();
        
        // Ensure all statuses have at least 0
        $statuses = ['available', 'booked', 'occupied', 'cleaning', 'maintenance'];
        foreach ($statuses as $status) {
            if (!isset($roomStatuses[$status])) {
                $roomStatuses[$status] = 0;
            }
        }

        $this->view('dashboard/index', [
            'title' => __('dashboard'),
            'stats' => $stats,
            'recentBookings' => $recentBookings,
            'roomStatuses' => $roomStatuses
        ]);
    }

    public function switchLanguage() {
        if (isset($_GET['lang'])) {
            $lang = $_GET['lang'];
            if (in_array($lang, ['en', 'km'])) {
                $_SESSION['lang'] = $lang;
            }
        }
        
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : BASE_URL;
        header("Location: $referer");
        exit;
    }
}
