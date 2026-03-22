<?php
class TelegramController extends Controller {
    private $guestModel;

    public function __construct() {
        $this->guestModel = new Guest();
    }

    public function webhook() {
        $input = file_get_contents('php://input');
        $update = json_decode($input, true);

        // LOG ALL UPDATES FOR DEBUGGING
        if ($input) {
            file_put_contents(ROOT_DIR . '/telegram_log.txt', date('[Y-m-d H:i:s] ') . $input . PHP_EOL, FILE_APPEND);
        }

        if (!$update) return;

        if (isset($update['message'])) {
            $message = $update['message'];
            $chatId = $message['chat']['id'] ?? null;
            $text = $message['text'] ?? '';

            // Handle /start [guest_id]
            if (strpos($text, '/start') === 0 && $chatId) {
                $parts = explode(' ', $text);
                if (count($parts) > 1) {
                    $guestId = $parts[1]; 
                    $this->guestModel->updateTelegramChatId($guestId, $chatId);
                    $this->sendWelcomeMessage($chatId);
                }
            }
        }
    }
    
    public function setupWebhook() {
        $config = require ROOT_DIR . '/config/config.php';
        $botToken = $config['telegram']['bot_token'] ?? "";
        
        // Ensure we are using HTTPS if available, as Telegram requires it
        $webhookUrl = FULL_BASE_URL . "/telegram/webhook";
        if (strpos($webhookUrl, 'http://') === 0 && !isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            // Force HTTPS for the webhook registration if possible
            // Note: Telegram WILL NOT deliver webhooks to plain http://
            $webhookUrl = str_replace('http://', 'https://', $webhookUrl);
        }

        $url = "https://api.telegram.org/bot" . $botToken . "/setWebhook?url=" . urlencode($webhookUrl);
        
        // Use cURL instead of file_get_contents
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        $total_time = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
        curl_close($ch);
        
        echo "<h2>Telegram Webhook Setup</h2>";
        echo "<p>Attempting to set webhook to: <a href='$webhookUrl' target='_blank'>$webhookUrl</a></p>";
        echo "<p><i>Note: Telegram requires <b>HTTPS</b>. If your site doesn't have an SSL certificate, webhooks won't work.</i></p>";
        echo "<h3>API Response:</h3>";
        echo "<pre>" . htmlspecialchars($response) . "</pre>";
        
        echo "<h3>System Checks:</h3>";
        echo "<li><b>Bot Token:</b> " . ($botToken ? '✅ Configured' : '❌ MISSING in config/config.php') . "</li>";
        echo "<li><b>URL detected:</b> " . FULL_BASE_URL . "</li>";
        echo "<li><b>Response Time:</b> " . $total_time . " seconds</li>";
    }

    private function sendWelcomeMessage($chatId) {
        $message = "Welcome to AURA Hotel! 🏨\n\nYour account is now linked to Telegram. We will send you updates and confirmations here.";
        $this->sendTelegramMessage($chatId, $message);
    }
}
