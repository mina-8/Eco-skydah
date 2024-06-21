<?php

// session_start(); // Start session to manage user's session variables

// // Database credentials
// // $dsn = "mysql:host=localhost;dbname=id22221257_ech";
// // $user = "id22221257_eco";
// // $password = "Eco20192020@";
// $dsn = "mysql:host=localhost;dbname=skydash";
// $user = "root";
// $password ="";
// // Options for PDO connection
// $options = [
//     PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
// ];

// try {
//     // Establish PDO connection
//     $connect = new PDO($dsn, $user, $password, $options);

    
//         // Retrieve email and password from POST request
//         $email = $_GET["id"];

//         // Prepare SQL statement to fetch admin user details
//         $sql_statement = $connect->prepare("SELECT 
//                                               *
//                                             FROM
//                                               users
//                                             WHERE
//                                               UserID = ? 
//                                               AND
//                                               Type = 'User'");
//         $sql_statement->execute([$email]);
//         $row = $sql_statement->fetch();
//         $count = $sql_statement->rowCount();

//         // Check if admin user with provided email exists
//         if ($count > 0) {
//                 // Send success response
//                 echo json_encode(['status' => 'success', 'message' => 'Login successful','UserData' => $row]);
//         } else {
//             // Admin user with provided email not found
//             echo json_encode(['status' => 'error', 'message' => 'Invalid username or password']);
//         }
// } catch (PDOException $e) {
//     // Database connection or query error
//     echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
// }

include "connection/connection.php";
ob_start();
session_start();

  // Retrieve email and password from POST request
  $Userid = $_GET["id"];
  
    // Prepare SQL statement to fetch admin user details
    $sql_statement = $connect->prepare("SELECT 
                                          *
                                        FROM
                                          users
                                        WHERE
                                          UserID=? 
                                        AND
                                          `Type`='User'");
    $sql_statement->execute(array($Userid));
    $row = $sql_statement->fetch();
    $count = $sql_statement->rowCount();
    // Check if admin user with provided email exists
    if ($count > 0) {
            // Send success response
            echo json_encode(['status' => 'success', 'message' => 'Login successful','UserData' => $row]);
    } else {
        // Admin user with provided email not found
        echo json_encode(['status' => 'error', 'message' => 'Invalid username or password']);
    }
ob_end_flush();