<?php
include "connection/connection.php";
session_start();

$message = $_POST["message"];
$chatId = $_POST["chat"];
$senderId = $_POST["Uid"];
$receiverId = 1;
$timestamp = date("Y-m-d H:i:s");

$create_message = $connect->prepare("INSERT INTO messages (ChatID, SenderID, ReceiverID, `Message`, `Timestamp`)
VALUES (:chatid, :senderid, :receiverid, :message, :timestamp)");

$create_message->execute(array(
    'chatid' => $chatId,
    'senderid' => $senderId,
    'receiverid' => $receiverId,
    'message' => $message,
    'timestamp' => $timestamp,
));

echo json_encode(['status' => 'success']);
?>
