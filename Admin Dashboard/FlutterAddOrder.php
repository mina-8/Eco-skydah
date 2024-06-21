<?php
include "connection/connection.php";
ob_start();
session_start();
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

$cartItems = $data['cartItems'];
$userID = $data['userID'];  // Assuming userID is sent from the Flutter app

try {
    // Insert each product into wasteentries table
    $stmt = $connect->prepare("INSERT INTO wasteentries (UserID, ProductID, WasteType, Quantity, CollectionTime, Status) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($cartItems as $item) {
        $stmt->execute([$userID, $item['id'], 'Recyclable', $item['quantity'], null, 'Pending']);  // Assuming 'Type' is a placeholder for WasteType
    }

    echo json_encode(['status' => 'success', 'message' => 'Order placed successfully']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
