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

//     if ($_SERVER["REQUEST_METHOD"] == "POST") {
//         // Retrieve email and password from POST request
//         $email = $_POST["username"];
//         $password = $_POST["password"];

//         // Prepare SQL statement to fetch admin user details
//         $sql_statement = $connect->prepare("SELECT 
//                                               *
//                                             FROM
//                                               users
//                                             WHERE
//                                               Email = ? 
//                                               AND
//                                               Type = 'User'");
//         $sql_statement->execute([$email]);
//         $row = $sql_statement->fetch();
//         $count = $sql_statement->rowCount();

//         // Check if admin user with provided email exists
//         if ($count > 0) {
//             // Verify hashed password
//             if (password_verify($password, $row["Password"])) {
//                 // Set session variables for admin user
//                 $_SESSION["Admin"] = $row["Type"];
//                 $_SESSION["Admin_id"] = $row["UserID"];
//                 $_SESSION["Admin_name"] = $row["FirstName"];

//                 // Send success response
//                 echo json_encode(['status' => 'success', 'message' => 'Login successful','UserData' => $row]);
//             } else {
//                 // Password verification failed
//                 echo json_encode(['status' => 'error', 'message' => 'Invalid username or password']);
//             }
//         } else {
//             // Admin user with provided email not found
//             echo json_encode(['status' => 'error', 'message' => 'Invalid username or password']);
//         }
//     } else {
//         // Invalid request method
//         echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
//     }
// } catch (PDOException $e) {
//     // Database connection or query error
//     echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
// }



include "connection/connection.php";
ob_start();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    // Retrieve email and password from POST request
    $email = $_POST["username"]; // should be Firstname | email
    $password = $_POST["password"];
    
    // Prepare SQL statement to fetch admin user details
    $sql_statement = $connect->prepare("SELECT 
                                            *
                                        FROM
                                            users
                                        WHERE
                                            Email=? 
                                            AND
                                            `Type`='User'");
    $sql_statement->execute(array($email));
    $row = $sql_statement->fetch();
    $count = $sql_statement->rowCount();
    // Check if admin user with provided email exists
    if($count > 0){
        if (password_verify($password, $row["Password"])) {
            $_SESSION["Admin"] = $row["Type"];
            $_SESSION["Admin_id"] = $row["UserID"];
            $_SESSION["Admin_name"] = $row["FirstName"];
            // Send success response
            echo json_encode(['status' => 'success', 'message' => 'Login successful','UserData' => $row]);
        }else{
            // Password verification failed
            echo json_encode(['status' => 'error', 'message' => 'Invalid username or password']);
        }
    }else{
        // Invalid request method
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    }
}

ob_end_flush();