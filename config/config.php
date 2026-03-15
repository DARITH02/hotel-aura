<?php
/**
 * Configuration file for different environments (Local vs Production)
 */

return [
    'db' => [
        'host' => 'localhost',
        'name' => 'db_hotel',
        'user' => 'root',
        'pass' => '',
    ],
    'app' => [
        'name' => 'Hotel Aura',
        'url' => 'http://localhost/hotel-system-two', // Change this to your InfinityFree URL
    ],
    'telegram' => [
        'bot_token' => '8642404952:AAFN6fsTjticiS0HcW4djWrQj5DOuT2-OFw',
        'admin_chat_id' => '',
    ]
];
