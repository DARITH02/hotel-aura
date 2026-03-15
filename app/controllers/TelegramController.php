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
        $config = require ROOT_DIR . DS . 'config' . DS . 'config.php';
        $botToken = $config['telegram']['bot_token'] ?? "";
        $webhookUrl = FULL_BASE_URL . "/telegram/webhook";
        
        $url = "https://api.telegram.org/bot" . $botToken . "/setWebhook?url=" . urlencode($webhookUrl);
        $response = @file_get_contents($url);
        
        echo "<h2>Telegram Webhook Setup</h2>";
        echo "<p>Attempting to set webhook to: <b>$webhookUrl</b></p>";
        echo "<pre>" . htmlspecialchars($response) . "</pre>";
        
        echo "<h3>Debug Info:</h3>";
        echo "<li><b>Project Root:</b> " . ROOT_DIR . "</li>";
        echo "<li><b>Log File:</b> " . (file_exists(ROOT_DIR . '/telegram_log.txt') ? '✅ Exists' : '❌ Not created yet') . "</li>";
        
        if (file_exists(ROOT_DIR . '/telegram_log.txt')) {
            echo "<h4>Last 5 logs:</h4><pre>" . htmlspecialchars(shell_exec('tail -n 5 ' . ROOT_DIR . '/telegram_log.txt')) . "</pre>";
        }
    }

    private function sendWelcomeMessage($chatId) {
        $message = "Welcome to AURA Hotel! 🏨\n\nYour account is now linked to Telegram. We will send you updates and confirmations here.";
        $this->sendTelegramMessage($chatId, $message);
    }
}
