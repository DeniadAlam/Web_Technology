<?php
// Start session
session_start();

// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tokenSid'])) {
    if (empty(trim($_POST['tokenSid']))) {
        $_SESSION['error'] = "Student ID is required.";
    } else {
        $tokenId = $_POST['tokenSid'];

        if (!preg_match("/^[0-9]{2}-[0-9]{5}-[1-3]{1}$/", $tokenId)) {
            $_SESSION['error'] = "Student ID must be in the format XX-XXXXX-X(1-3).";
        } else {
            $tokenId = htmlspecialchars($tokenId);

            // Directory for storing JSON files
            $jsDirectory = "token/";
            if (!is_dir($jsDirectory)) {
                mkdir($jsDirectory, 0777, true);
            }

            // Generate a new token (UID)
            $token = uniqid();
            $FilePath = $jsDirectory . $tokenId . ".json";

            if (file_exists($FilePath)) {
                $tokenData = json_decode(file_get_contents($FilePath), true);
                $token = $tokenData['uid'];
            } else {
                $tokenData = ['uid' => $token];
                if (!file_put_contents($FilePath, json_encode($tokenData, JSON_PRETTY_PRINT))) {
                    $_SESSION['error'] = "Failed to store token data.";
                }
            }

            // Store the token in the session
            $_SESSION['token'] = [
                'id' => $tokenId,
                'value' => $token
            ];
        }
    }

    // Redirect back to index.php
    header("Location: index.php");
    exit();
}
