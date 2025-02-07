<?php

// Load the bot token from config.php
$config = include('config.php');
$token = $config["bot_token"];
$api = "https://api.telegram.org/bot$token";

// Colorful debugging messages
function debug($message, $color_code = '0') {
    $colors = [
        '0' => "\033[0m",    // Default
        '32' => "\033[32m",  // Green
        '33' => "\033[33m",  // Yellow
        '34' => "\033[34m",  // Blue
        '31' => "\033[31m",  // Red
        '36' => "\033[36m",  // Cyan
        '37' => "\033[37m"   // White
    ];

    echo $colors[$color_code] . $message . $colors['0'] . "\n";
}

// Function to send messages to Telegram
function sendMessage($chat_id, $message, $markdown = false) {
    global $api;
    $params = [
        "chat_id" => $chat_id,
        "text" => $message,
        "parse_mode" => $markdown ? "Markdown" : ""
    ];
    $response = file_get_contents($api . "/sendMessage?" . http_build_query($params));
    debug("Sent message to chat ID: $chat_id", '34');
    debug("Response: $response", '32');
}

// Start polling for updates
$last_update_id = 0;

while (true) {
    // Fetch updates from Telegram API
    $debug_msg = "Fetching updates from Telegram API...";
    debug($debug_msg, '36');
    $updates = json_decode(file_get_contents($api . "/getUpdates?offset=" . ($last_update_id + 1)), true);

    if ($updates["ok"]) {
        foreach ($updates["result"] as $update) {
            // Update the last processed update ID
            $last_update_id = $update["update_id"];

            // Extract chat id and message text
            $chat_id = $update["message"]["chat"]["id"];
            $text = $update["message"]["text"];

            // Debug the received message
            debug("Received message: $text from chat ID: $chat_id", '33');

            // Process /start command
            if ($text == "/start") {
                $start_message = "👋 *Hello!* Please send an Instagram link here.";
                sendMessage($chat_id, $start_message, true);
            } 
            // Process Instagram URL
            elseif (filter_var($text, FILTER_VALIDATE_URL) && strpos($text, "instagram.com") !== false) {
                // Modify Instagram link for downloading
                $new_link = str_replace(["www.instagram.com", "instagram.com"], ["www.ddinstagram.com", "instagram.com"], $text);
                sendMessage($chat_id, "🚀 *Your video is ready to download!*\n\n [📥 Click Here]($new_link)", true);
                debug("Processed Instagram URL and sent modified link: $new_link", '32');
            } 
            // Invalid message
            else {
                sendMessage($chat_id, "❌ Invalid input. Please try again.");
                debug("Invalid input from chat ID: $chat_id", '31');
            }
        }
    } else {
        debug("Error fetching updates. Response: " . json_encode($updates), '31');
    }

    // Delay to avoid hitting API rate limits
    sleep(2);
}

?>
