<?php

session_start(); // Start session to manage user's session variables

// Database credentials
 $dsn = "mysql:host=localhost;dbname=id22221257_ech";
// $user = "id22221257_eco";
// $password = "Eco20192020@";

// Database connection credentials
$host = 'localhost'; // Replace with your host
$dbname = 'skydash'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

// Options for PDO connection
$options = [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
];

try {
    // Establish PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if it's a POST request
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve userid from POST data
        $userid = $_POST["userid"];

        // Prepare and execute SQL query
        $sql = "SELECT * FROM notifcations WHERE User_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userid]);

        // Fetch all rows as associative array
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();
        http_response_code(200); // OK

        // Check if notifications were found
        if ($count > 0) {
            // Return JSON response with notifications
            echo json_encode(['status' => 'success', 'message' => 'Data retrieved successfully', 'notifications' => $notifications]);
        } else {
            // Return JSON response if no notifications found
            echo json_encode(['status' => 'error', 'message' => 'No notifications found']);
        }
    } else {
        // Return JSON response for invalid request method
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    }
} catch (PDOException $e) {
    // Return JSON response for database errors
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>