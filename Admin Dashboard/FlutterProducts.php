<?php

session_start(); // Start session to manage user's session variables

// Database credentials
// $dsn = "mysql:host=localhost;dbname=id22221257_ech";
// $user = "id22221257_eco";
// $password = "Eco20192020@";
$dsn = "mysql:host=localhost;dbname=skydash";
$user = "root";
$password = "";
// Options for PDO connection
$options = [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
];

try {
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e) {
    // On connection error, return a JSON response with error message
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Database connection error: " . $e->getMessage()]);
    exit();
}

// Prepare SQL statement to fetch products
$sql = "SELECT * FROM products";

try {
    // Execute SQL query
    $stmt = $pdo->query($sql);

    // Fetch all products as associative array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // If products found, return JSON response
    if ($products) {
        http_response_code(200); // OK
        echo json_encode($products);
    } else {
        http_response_code(404); // Not Found
        echo json_encode(["error" => "No products found"]);
    }
} catch (PDOException $e) {
    // On query error, return a JSON response with error message
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Database query error: " . $e->getMessage()]);
}