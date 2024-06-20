<?php
include "connection/connection.php";
session_start();

$chatId = $_GET['chat'];

$fetch_message = $connect->prepare("SELECT * FROM messages WHERE ChatID=? AND `Timestamp` IS NOT NULL");
$fetch_message->execute(array($chatId));
$messages = $fetch_message->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($messages);
?>
