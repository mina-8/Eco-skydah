
<!-- start session to check login -->
<?php

include "connection/connection.php";
ob_start();
session_start();

// check for type user in table user
if(!isset($_SESSION["Admin"])){
  header("location: index.php");
  exit();
}


// fetch user form table users
$fetch_user = $connect->prepare("SELECT * FROM users WHERE UserID=?");
$fetch_user->execute(array($_GET['chat']));
$row_user = $fetch_user->fetch();


// check message sinder
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $message = $_POST["message"];
  $reciever = $row_user["UserID"];
  $sneder = $_SESSION["Admin_id"];
  $registerdate = date("Y-m-d H:i:s");
  

  // create users 
  // $fetch_chat = $connect->prepare("SELECT * FROM chats Where SenderID=? AND ReceiverID=? AND `Timestamp` IS NOT NULL");
  // $fetch_chat->execute(array($_SESSION['Admin_id'] , $_GET["chat"]));
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
      "senderid" => $sneder ,
      "receiverid" => $reciever ,
      "messages" => $message ,
      "createat" => $registerdate ,
    ));
  }else{

    $create_chat = $connect->prepare("INSERT INTO
                                    chats
                                    (SenderID , ReceiverID , `Timestamp`)
                                    VALUES
                                    (:senderid , :receiverid , :createat) ");
    // sql create users
    $create_chat->execute(array(
      "senderid" => $sneder ,
      "receiverid" => $reciever ,
      "createat" => $registerdate ,
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
      "senderid" => $sneder ,
      "receiverid" => $reciever ,
      "messages" => $message ,
      "createat" => $registerdate ,
    ));

    

}

  header("location: Chats.php?chat=" . $_GET['chat']);
  exit(); 
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Eco Admin</title>
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" type="text/css" href="js/select.dataTables.min.css">
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="css/chats/chats.css">
  
  <link rel="shortcut icon" href="images/favicon.png" />


  <style>
        /* Customize chat box styles here */
        .chat-container {
          height: 400px; /* Adjust height as needed */
          overflow-y: auto;
        }
        .message {
          background-color: #f2f2f2;
          padding: 10px;
          border-radius: 10px;
          margin-bottom: 10px;
          display: inline-block;
            width: fit-content;
            border-bottom-left-radius: 0px;
        }
        .message.me {
          background-color: #00b98e;
          color: white;
          text-align: right;
          margin-left: auto;
          border-bottom-right-radius: 0px;
          border-bottom-left-radius: 10px;
        }
        .input-group {
          margin-top: 20px;
        }
        .mssOut{
            text-align: left;
        }
        .mssOut.me{
            text-align: right;
        }
        p,h2,h3,span,h1,h4,h6,h5,button,a,div{
        font-family: 'Cairo', sans-serif!important;
        }
        html {
          scroll-behavior: auto; /* Or scroll-behavior: smooth for smooth scrolling */
        }
        .sidebar-right {
            background-color: #f8f9fa;
            
            overflow-y: auto;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
        }

      .chat-list {
          list-style: none;
          padding: 0;
          margin: 0;
      }

      .lists {
          padding: 10px;
          border-bottom: 1px solid #e9ecef;
      }

      .profile {
          display: flex;
          align-items: center;
          text-decoration: none;
          color: #333;
          transition: background-color 0.3s;
      }

      .profile:hover {
          background-color: #e2e6ea;
      }

      .profile-image {
          width: 40px;
          height: 40px;
          border-radius: 50%;
          margin-right: 10px;
          object-fit: cover;
      }

      .online {
          width: 10px;
          height: 10px;
          background-color: green;
          border-radius: 50%;
          margin-left: -15px;
          margin-top: 30px;
          border: 2px solid #f8f9fa;
      }

      .info {
          display: flex;
          flex-direction: column;
      }

      .user-name {
          font-weight: bold;
          margin: 0;
      }

      .chat-status {
          font-size: 0.9em;
          color: #888;
          margin: 0;
      }

      </style>
  
</head>
<body>
  <div class="container-scroller">
  <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <!-- this change header  -->
        <a class="navbar-brand brand-logo mr-5" href=<?php echo "dashboard.php?user=" . $_SESSION["Admin"]?>>ECO Recycling</a>
        <a class="navbar-brand brand-logo-mini" href=<?php echo "dashboard.php?user=" . $_SESSION["Admin"]?>><img src="images/eco-icon.png" alt="logo"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">
          <li class="nav-item nav-search d-none d-lg-block">
            <div class="input-group">
              <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                <span class="input-group-text" id="search">
                  <i class="icon-search"></i>
                </span>
              </div>
              <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
            </div>
          </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item">
            <div class="mx-0" style="margin-right: 5px;"><?php echo $_SESSION['Admin_name'] ?></div>
          </li>
          <!-- <li class="nav-item">
            <div class="mx-0" style="margin-right: 5px;">
            Points : 
          php 
          $fetch_points = $connect->prepare("SELECT Points FROM `users` WHERE UserID=?");
          $fetch_points->execute(array($_SESSION['Admin_id']));
          $row_points = $fetch_points->fetch();
          $count_points = $fetch_points->rowCount();
          if($count_points > 0){
            echo $row_points['Points'];
          }else{
            echo "0";
          }
          ?>
          </div>
          </li> -->
          <!-- <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="icon-bell mx-0"></i>
              <span class="count"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
              
              <a class="dropdown-item preview-item">
                
                <div class="preview-item-content">
                  
                  php 
                  $fetch_notfication = $connect->prepare("SELECT * FROM notifcations WHERE User_id=?");
                  $fetch_notfication->execute(array($_SESSION["Admin_id"]));
                  $row_notfi = $fetch_notfication->fetchAll();
                  $count_notfi = $fetch_notfication->rowCount();
                  if($count_notfi > 0){
                    foreach($row_notfi as $notfi){?>
                     <h6 class="preview-subject font-weight-normal"> php echo $notfi['textnotfication']?> </h6>
                  php }
                  }
                  ?>
                  
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-success">
                    <i class="ti-info-alt mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-normal">Application Error</h6>
                  <p class="font-weight-light small-text mb-0 text-muted">
                    Just now
                  </p>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-warning">
                    <i class="ti-settings mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-normal">Settings</h6>
                  <p class="font-weight-light small-text mb-0 text-muted">
                    Private message
                  </p>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-info">
                    <i class="ti-user mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-normal">New user registration</h6>
                  <p class="font-weight-light small-text mb-0 text-muted">
                    2 days ago
                  </p>
                </div>
              </a>
            </div>
          </li> -->
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <img src="images/eco-icon.png" alt="profile"/>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <!-- <a class="dropdown-item">
                <i class="ti-settings text-primary"></i>
                Settings
              </a> -->
              <a href="logout.php" class="dropdown-item">
                <i class="ti-power-off text-primary"></i>
                Logout
              </a>
            </div>
          </li>
          
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>
    <div class="container-fluid page-body-wrapper">
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href=<?php echo "dashboard.php?user=" . $_SESSION["Admin"]?>>
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-user" aria-expanded="false" aria-controls="ui-user">
              <i class="mdi mdi-account-multiple icon-layout menu-icon"></i>
              <span class="menu-title">Users</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-user">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href=<?php echo "indexUser.php?user=" . $_SESSION["Admin"]?>>All Users</a></li>
                <li class="nav-item"> <a class="nav-link" href=<?php echo "CreateUser.php?user=" . $_SESSION["Admin"]?>>Create New User</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-product" aria-expanded="false" aria-controls="ui-product">
            <i class="icon-layout menu-icon mdi mdi-book-open-variant"></i>
              <span class="menu-title">Products</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-product">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="indexProduct.php">All Products</a></li>
                <li class="nav-item"> <a class="nav-link" href="CreateProduct.php">Create New Product</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-order" aria-expanded="false" aria-controls="ui-product">
            <i class="icon-layout menu-icon mdi mdi-briefcase"></i>
              <span class="menu-title">Orders</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-order">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="Allorders.php">All Orders</a></li>
                
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-chat" aria-expanded="false" aria-controls="ui-product">
              <i class="mdi mdi-wechat icon-layout menu-icon"></i>
              <span class="menu-title">Chats</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-chat">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="MainChat.php">All Chats</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>


      
      <div class="main-panel main-panel-chats">
        <div class="content-wrappers">
        <div class="container-fluid overflow-hidden ">
            <div class="">
                <div class=" col-12 mx-auto border p-3 bg-white"><h6 class="mb-0"><?php echo $row_user['FirstName'].' '.$row_user['LastName'] ?></h6></div>
                
                <?php
                  // check if chats table has exist chat or not
                  // fetch chat form table chats
                  $fetch_chat = $connect->prepare("SELECT * FROM chats Where SenderID=? AND ReceiverID=? OR SenderID=? AND ReceiverID=?  AND `Timestamp` IS NOT NULL");
                  $fetch_chat->execute(array($_SESSION['Admin_id'] , $row_user['UserID'] ,  $row_user['UserID'] , $_SESSION['Admin_id'] ));
                  $row_chat = $fetch_chat->fetch();
                  $count_chat = $fetch_chat->rowCount();
                  // start if condition is users > 0
                ?>
                <div class="chat-container col-12 mx-auto border p-3 bg-white" id="chatload">
                    <?php 
                      if($count_chat > 0){
                        // fetch message form table messages
                        $fetch_message = $connect->prepare("SELECT * FROM messages Where ChatID=? AND `Timestamp` IS NOT NULL ");
                        $fetch_message->execute(array($row_chat['ChatID']));
                        $row_message = $fetch_message->fetchAll();
                        $count_message = $fetch_message->rowCount();

                        // check messages 
                        if($count_message > 0){
                          foreach($row_message as $messages){?>
                                
                                <?php 
                                // check receiver
                                if($messages['ReceiverID'] == $_SESSION['Admin_id']){?>
                                  <div class="mssOut">
                                      <div class="message col-10"><?php echo $messages['Message'] ?></div>
                                  </div>
                                  <?php } ?>
                                <?php 
                                // check sender
                                if($messages['ReceiverID'] == $row_user['UserID']){?>
                                    <div class="mssOut me">
                                      <div class="message col-10 me" ><?php echo $messages['Message'] ?></div>
                                    </div>
                                    <?php }?>

                          <?php } // end loop message
                            ?>
                            <div id="target-message"></div>
                            <?php
                        } // end if condtion check message
                      } // end if conition check chat
                    ?>
                    
                </div>
                
                <div class=" col-12 mx-auto border p-3 bg-white">
                  <form class="" action="<?php echo $_SERVER["PHP_SELF"] . "?chat=" . $_GET['chat'] ?>" method="POST" enctype="application/x-www-form-urlencoded">
                    <div class="input-group">
                      <textarea type="text" name="message" class="form-control me-2 rounded" placeholder="Write Here ..."></textarea>
                      <div class="input-group-append">
                      
                      <input class="btn btn-primary px-5" style="height: 62px;" type="submit" value="Send"/>
                      </div>
                    </div>
                </form>
            </div>
            </div>
        </div>
          
          
        </div>
        <!-- content-wrapper ends -->
        
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024.  Premium <a href="https://www.bootstrapdash.com/" target="_blank"></a>. All rights reserved.</span>
          </div>
        </footer> 
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
      
      <nav class="sidebar-right sidebar-offcanvas" id="sidebar">
    <ul class="chat-list">
        <?php  
        // Fetch users from the table 'users'
        $fetch_user = $connect->prepare("SELECT * FROM users WHERE `UserID` != ? AND `Type` != ?");
        $fetch_user->execute(array($_SESSION['Admin_id'], 'Admin'));
        $row_user = $fetch_user->fetchAll();
        $count_user = $fetch_user->rowCount();
        
        // Check if there are users to display
        if ($count_user > 0) { 
            // Loop through each user
            foreach ($row_user as $user) {
        ?>
                <li class="lists">
                    <a class="profile" href="Chats.php?chat=<?php echo $user['UserID']; ?>">
                        <img src="images/faces/face1.jpg" alt="image" class="profile-image">
                        <span class="online"></span>
                        <div class="info">
                            <p class="user-name"><?php echo $user['FirstName'] . " " . $user['LastName']; ?></p>
                            <?php if ($user['UserID'] == $_GET['chat']) { ?>
                                <p class="chat-status">Chating now</p>
                            <?php } ?>
                        </div>
                    </a>
                </li>
        <?php 
            } // End loop
        } // End if condition
        ?>        
    </ul>
</nav>


      
      
    </div>   
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="vendors/chart.js/Chart.min.js"></script>
  <script src="vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="js/dataTables.select.min.js"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <script src="js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->
  
  <!-- fresh chat every 5 second -->
  <script>
    setInterval(function () {
      location.reload(true)
    }, 12000);
    
    window.onload = function() {
      const targetElement = document.getElementById('target-message'); // Replace with your element ID
      if (targetElement) {
        document.getElementById('target-message').scrollIntoView()
      }
    };
  </script>
</body>

</html>

i
<!-- this line to end session -->
<?php
ob_end_flush();
?>
