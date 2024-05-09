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
}else if(isset($_POST['deleteproduct'])){
  if($_POST['deleteproduct'] === 'deleteproduct'){
    $porduct_id = $_POST['productid'];
    $check_prodcut = $connect->prepare("SELECT * FROM products WHERE ProductID=?");
    $check_prodcut->execute(array($porduct_id));
    $row_product = $check_prodcut->fetch();
    $count_product = $check_prodcut->rowCount();
    if($count_product > 0){
      $path_image = $row_product['Product_image'];
      // delete image from folder uploads
      unlink($path_image);
      
      // delete wasteentries
      $delete_wasteentr = $connect->prepare("DELETE FROM wasteentries WHERE ProductID=:productid");
      $delete_wasteentr->bindParam("productid" , $row_product['ProductID']);
      $delete_wasteentr->execute();
      // delete products
      $delete_product = $connect->prepare("DELETE FROM products WHERE ProductID=:productid");
      $delete_product->bindParam("productid" , $row_product['ProductID']);
      $delete_product->execute();
      echo "success";
    }
  }
}