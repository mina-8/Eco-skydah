<?php


include "connection/connection.php";
ob_start();
session_start();

// check for type user in table user
if(!isset($_SESSION["Admin"])){
  header("location: index.php");
  exit();
}


if(isset($_POST["deleteuser"])){
    if($_POST["deleteuser"] === "deleteuser"){
        $user_id = $_POST["userid"];
        $delete_user = $connect->prepare("DELETE FROM users WHERE UserID=:user_id");
        $delete_user->bindParam("user_id" , $user_id);
        $delete_user->execute();
        echo "success";
    }
}