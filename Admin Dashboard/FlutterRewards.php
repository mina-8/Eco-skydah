<?php

// session_start(); // Start session to manage user's session variables

// // Database credentials
// // $dsn = "mysql:host=localhost;dbname=id22221257_ech";
// // $user = "id22221257_eco";
// // $password = "Eco20192020@";
// $dsn = "mysql:host=localhost;dbname=skydash";
// $user = "root";
// $password = "";
// // Options for PDO connection
// $options = [
//     PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
// ];

// try {
//     $connect = new PDO($dsn, $user, $password, $options);

//     if ($_SERVER["REQUEST_METHOD"] == "POST") {
//         $userid = $_POST["userid"];
//         $sql_statement = $connect->prepare("SELECT * FROM `rewards` WHERE UserId = ?");
//         $sql_statement->execute([$userid]);
//         $rows = $sql_statement->fetchAll(PDO::FETCH_ASSOC);
//         $count = $sql_statement->rowCount();
//         http_response_code(200); // OK

//         if ($count > 0) {
//             echo json_encode(['status' => 'success', 'message' => 'Data retrieved successfully', 'UserData' => $rows]);
//         } else {
//             echo json_encode(['status' => 'error', 'message' => 'No data found']);
//         }
//     } else {
//         echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
//     }
// } catch (PDOException $e) {
//     echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
// }



include "connection/connection.php";
ob_start();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $userid = $_POST["userid"];
    $sql_statement = $connect->prepare("SELECT * FROM `rewards` WHERE UserId=?");
    $sql_statement->execute(array($userid));
    $rows = $sql_statement->fetchAll();
    $count = $sql_statement->rowCount();
    http_response_code(200); // OK
    if($count > 0){
        echo json_encode(['status' => 'success', 'message' => 'Data retrieved successfully', 'UserData' => $rows]);
    }else{
        echo json_encode(['status' => 'error', 'message' => 'No data found']);
    }
}else{
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

ob_end_flush();