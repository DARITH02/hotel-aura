<?php
class Controller {
    protected function view($viewPath, $data = []) {
        extract($data);
        
        $fullPath = APP_DIR . DS . 'views' . DS . ltrim($viewPath, '/') . '.php';
        
        // Exclude layout for auth views
        if (strpos($viewPath, 'auth/') === 0) {
            if (file_exists($fullPath)) include $fullPath;
        } else {
            // Include layouts for dashboard pages
            if (file_exists(APP_DIR . DS . 'views/layouts/header.php')) include APP_DIR . DS . 'views/layouts/header.php';
            if (file_exists(APP_DIR . DS . 'views/layouts/sidebar.php')) include APP_DIR . DS . 'views/layouts/sidebar.php';
            if (file_exists(APP_DIR . DS . 'views/layouts/navbar.php')) include APP_DIR . DS . 'views/layouts/navbar.php';
            
            if (file_exists($fullPath)) include $fullPath;
            else echo "<div class='alert alert-danger m-4'>View file not found: $fullPath</div>";
            
            if (file_exists(APP_DIR . DS . 'views/layouts/footer.php')) include APP_DIR . DS . 'views/layouts/footer.php';
        }
    }

    protected function redirect($url) {
        header("Location: " . rtrim(BASE_URL, '/') . '/' . ltrim($url, '/'));
        exit();
    }
    
    protected function checkAuth() {
        if (!isset($_SESSION['admin_id'])) {
            $this->redirect('login');
        }
    }

    /**
     * Centralized Telegram Sender
     */
    protected function sendTelegramMessage($chatId, $message) {
        $botToken = "8642404952:AAFN6fsTjticiS0HcW4djWrQj5DOuT2-OFw";
        $url = "https://api.telegram.org/bot" . $botToken . "/sendMessage";
        
        $postData = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'Markdown',
            'disable_web_page_preview' => false
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
