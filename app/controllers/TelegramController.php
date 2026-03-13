<?php
class TelegramController extends Controller {
    private $guestModel;

    public function __construct() {
        $this->guestModel = new Guest();
    }

    /**
     * Webhook endpoint for Telegram
     * URL: [YOUR_DOMAIN]/telegram/webhook
     */
    public function webhook() {
        $input = file_get_contents('php://input');
        $update = json_decode($input, true);

        if (!$update || !isset($update['message'])) {
            return;
        }

        $message = $update['message'];
        $chatId = $message['chat']['id'] ?? null;
        $text = $message['text'] ?? '';

        // Handle /start [guest_id]
        if (strpos($text, '/start') === 0 && $chatId) {
            $parts = explode(' ', $text);
            if (count($parts) > 1) {
                $guestId = $parts[1]; // This is the ID passed from deep link
                
                // Update the guest record with their Telegram chat ID
                $this->guestModel->updateTelegramChatId($guestId, $chatId);
                
                // Optional: Send a welcome message back via bot
                $this->sendWelcomeMessage($chatId);
            }
        }
    }

    private function sendWelcomeMessage($chatId) {
        $botToken = "8642404952:AAFN6fsTjticiS0HcW4djWrQj5DOuT2-OFw";
        $message = "Welcome to AURA Hotel! 🏨\n\nYour account is now linked to Telegram. We will send you updates and confirmations here.";
        
        $url = "https://api.telegram.org/bot" . $botToken . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($message);
        @file_get_contents($url);
    }
}
