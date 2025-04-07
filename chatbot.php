<?php

// MySQL info
$DBConnect = mysqli_connect();

// Check connection
if ($DBConnect->connect_error) {
    die("Connection failed: " . $DBConnect->connect_error);
} else {
    $apiKey = '';
    // Debugging settings
    header('Content-Type: application/json');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Get message data from JSON
    $data = json_decode(file_get_contents('php://input'), true);
    $message = isset($data['message']) ? $data['message'] : '';

    if (empty($message)) {
        echo json_encode(['error' => 'No message provided']);
        exit;
    }

    // API request setup
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, '');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ['role' => 'user', 'content' => $message]
        ],
        'max_tokens' => 150,
    ]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json',
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode(['error' => 'Error: ' . curl_error($ch)]);
    } else {
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode == 200) {
            $responseData = json_decode($response, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $botResponse = $responseData['choices'][0]['message']['content'];

                // Save the conversation to the database
                $TableName = "chat_history";
                $SQLstring = "INSERT INTO `$TableName` (`user_message`, `bot_response`) 
                              VALUES ('$message', '$botResponse')";

                if (mysqli_query($DBConnect, $SQLstring)) {
                    echo json_encode(['response' => $botResponse]);
                } else {
                    echo json_encode(['error' => 'Error: ' . $SQLstring . '<br>' . mysqli_error($DBConnect)]);
                }

            } else {
                echo json_encode(['error' => 'Invalid JSON received from API']);
            }
        } else {
            echo json_encode(['error' => 'API request failed with HTTP code ' . $httpCode . ': ' . $response]);
        }
    }

    curl_close($ch);
    $DBConnect->close();
}

?>
