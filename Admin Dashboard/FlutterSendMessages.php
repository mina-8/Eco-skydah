<?php
include "connection/connection.php";
ob_start();
session_start();

$message = $_POST["message"];
$chatId = $_POST["chat"];
$senderId = $_POST["Uid"];
$receiverId = 1;
$timestamp = date("Y-m-d H:i:s");

// $create_message = $connect->prepare("INSERT INTO messages (ChatID, SenderID, ReceiverID, `Message`, `Timestamp`)
// VALUES (:chatid, :senderid, :receiverid, :messages, :timestm)");

// $create_message->execute(array(
//     'chatid' => $chatId,
//     'senderid' => $senderId,
//     'receiverid' => $receiverId,
//     'messages' => $message,
//     'timestm' => $timestamp,
// ));

    // check first if exist chats betwen sender and reciver or not
  $fetch_chat = $connect->prepare("SELECT * FROM chats Where SenderID=? AND ReceiverID=? OR SenderID=? AND ReceiverID=?  AND `Timestamp` IS NOT NULL");
  $fetch_chat->execute(array($_SESSION['Admin_id'] , $row_user['UserID'] , $row_user['UserID'] , $_SESSION['Admin_id']  ));
  $row_chat = $fetch_chat->fetch();
  $count_chat = $fetch_chat->rowCount();
  if($count_chat > 0){
        $create_message = $connect->prepare("INSERT INTO
                                            messages
                                            (ChatID , SenderID , ReceiverID , `Message` , `Timestamp`)
                                            VALUES
                                            (:chatid , :senderid , :receiverid , :messages , :createat) ");
        // sql create users
        $create_message->execute(array(
        "chatid" => $row_chat['ChatID'] ,
        "senderid" => $senderId ,
        "receiverid" => $receiverId ,
        "messages" => $message ,
        "createat" => $timestamp ,
        ));
    }else{
            $create_chat = $connect->prepare("INSERT INTO
                                            chats
                                            (SenderID , ReceiverID , `Timestamp`)
                                            VALUES
                                            (:senderid , :receiverid , :createat) ");
            // sql create users
            $create_chat->execute(array(
            "senderid" => $senderId ,
            "receiverid" => $receiverId ,
            "createat" => $timestamp ,
            ));
            $last_record = $connect->lastInsertId();

            $create_message = $connect->prepare("INSERT INTO
                                                messages
                                                (ChatID , SenderID , ReceiverID , `Message` , `Timestamp`)
                                                VALUES
                                                (:chatid , :senderid , :receiverid , :messages , :createat) ");
            // sql create users
            $create_message->execute(array(
            "chatid" => $last_record ,
            "senderid" => $senderId ,
            "receiverid" => $receiverId ,
            "messages" => $message ,
            "createat" => $timestamp ,
            ));

    }


echo json_encode(['status' => 'success']);

ob_end_flush();

