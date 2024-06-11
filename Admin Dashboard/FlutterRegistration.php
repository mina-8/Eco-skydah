<?php

$dsn = "mysql:host=localhost;dbname=skydash";
$user = "root";
$password = "";

// Options for PDO connection
$options = [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
];

// Handling CORS (Cross-Origin Resource Sharing) headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Establish PDO connection
try {
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e) {
    // On connection error, return a JSON response with error message
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Database connection error: " . $e->getMessage()]);
    exit();
}

// Handling POST request from Flutter application
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from POST request
    $firstName = $_POST["FirstName"];
    $lastName = $_POST["LastName"];
    $email = $_POST["Email"];
    $password = $_POST["Password"];
    $type = $_POST["Type"]; // Ensure this matches the enum values in your MySQL table

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement to insert user into the database
    $sql = "INSERT INTO users (FirstName, LastName, Email, Password, Type, RegistrationDate) 
            VALUES (?, ?, ?, ?, ?, NOW())";

    // Execute the SQL statement with prepared parameters
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$firstName, $lastName, $email, $hashedPassword, $type]);

        // Return success response to Flutter application
        echo json_encode(["status" => "success", "message" => "User registered successfully"]);
    } catch (PDOException $e) {
        // On SQL error, return a JSON response with error message
        http_response_code(500); // Internal Server Error
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
} else {
    // If request method is not POST, return error response
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Invalid request method"]);
}
?>
