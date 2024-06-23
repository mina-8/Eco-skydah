<?php
include "connection/connection.php";
ob_start();
session_start();

$message = $_POST["message"];
$senderId = $_POST["Uid"];
$receiverId = 1; // Assuming receiver ID is fixed or can be determined dynamically
$timestamp = date("Y-m-d H:i:s");

// Check if a chat exists between sender and receiver
$fetch_chat = $connect->prepare("SELECT * FROM chats WHERE (SenderID=? AND ReceiverID=?) OR (SenderID=? AND ReceiverID=?) AND `Timestamp` IS NOT NULL");
$fetch_chat->execute(array($receiverId, $senderId, $senderId, $receiverId));
$row_chat = $fetch_chat->fetch();
$count_chat = $fetch_chat->rowCount();

if ($count_chat > 0) {
    // Chat exists, insert message into existing chat
    $chatId = $row_chat['ChatID'];
} else {
    // Chat does not exist, create a new chat and insert message
    $create_chat = $connect->prepare("INSERT INTO chats (SenderID, ReceiverID, `Timestamp`) VALUES (?, ?, ?)");
    $create_chat->execute(array($senderId, $receiverId, $timestamp));
    $chatId = $connect->lastInsertId();
}

// Insert user's message
$create_message = $connect->prepare("INSERT INTO messages (ChatID, SenderID, ReceiverID, `Message`, `Timestamp`) VALUES (?, ?, ?, ?, ?)");
$create_message->execute(array($chatId, $senderId, $receiverId, $message, $timestamp));

// Prepare predefined responses
$predefinedResponses = [
    "What are the benefits of recycling?" => "Recycling helps to reduce the pollution caused by waste, conserves natural resources, saves energy, reduces greenhouse gas emissions, and creates jobs.",
    "How to start recycling?" => "To start recycling, you can begin by sorting your waste into recyclables and non-recyclables, find out your local recycling rules, and drop off or have your recyclables collected.",
    "Why is recycling important?" => "Recycling is important because it helps to reduce the waste sent to landfills and incinerators, conserves natural resources, saves energy, and supports environmental sustainability.",
    "What materials can be recycled?" => "Common recyclable materials include paper, cardboard, glass, metal, plastic, and certain electronics. Always check local guidelines for specific recycling rules.",
    "What is the recycling process?" => "The recycling process involves collecting and sorting materials, cleaning and processing them into raw materials, and manufacturing new products from these recycled materials.",
    "What is composting?" => "Composting is the process of recycling organic waste, such as food scraps and yard waste, into a valuable soil amendment that enriches soil and plants.",
    "How does recycling save energy?" => "Recycling saves energy by reducing the need to extract, transport, and process raw materials. For example, recycling aluminum saves up to 95% of the energy required to produce new aluminum.",
    "What are the economic benefits of recycling?" => "Recycling creates jobs in the recycling and manufacturing industries, reduces disposal costs, and generates revenue from the sale of recycled materials.",
    "Can all plastics be recycled?" => "Not all plastics can be recycled. It depends on the type of plastic and local recycling capabilities. Commonly recycled plastics include PET (1) and HDPE (2).",
    "How can I recycle electronics?" => "To recycle electronics, look for e-waste recycling programs or drop-off locations in your area. Many retailers and manufacturers also offer take-back programs.",
    "What is upcycling?" => "Upcycling is the process of creatively reusing and repurposing waste materials or old products into new, higher-value items.",
    "What is downcycling?" => "Downcycling is the process of recycling materials into new products of lesser quality and reduced functionality compared to the original material.",
    "How can schools promote recycling?" => "Schools can promote recycling by setting up recycling bins, educating students and staff about the benefits of recycling, and organizing recycling programs and competitions.",
    "What is zero waste?" => "Zero waste is a philosophy and goal to reduce the amount of waste generated and to manage products and resources in a way that all materials are reused, repaired, or recycled, minimizing the need for landfills and incineration.",
    "How can I reduce my plastic use?" => "You can reduce plastic use by choosing reusable products like bags, bottles, and containers, avoiding single-use plastics, and opting for products with minimal or eco-friendly packaging.",
    "What is a circular economy?" => "A circular economy is an economic system aimed at eliminating waste and the continual use of resources by designing products for longer use, repair, remanufacturing, and recycling."
];


// Check if the received message matches any predefined question
$matchedResponse = isset($predefinedResponses[$message]) ? $predefinedResponses[$message] : null;

// If there is a predefined response, insert it into the messages table
if ($matchedResponse !== null) {
    $create_response = $connect->prepare("INSERT INTO messages (ChatID, SenderID, ReceiverID, `Message`, `Timestamp`) VALUES (?, ?, ?, ?, ?)");
    $create_response->execute(array($chatId, 1, $senderId, $matchedResponse, $timestamp));
}

echo json_encode(['status' => 'success']);

ob_end_flush();
?>