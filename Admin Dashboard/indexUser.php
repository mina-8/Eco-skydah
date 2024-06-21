
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Skydash Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" type="text/css" href="js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
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
            <a class="nav-link" href="index.php">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-user" aria-expanded="false" aria-controls="ui-user">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">Users</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-user">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="indexUser.php">All Users</a></li>
                <li class="nav-item"> <a class="nav-link" href="CreateUser.php">Create New User</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-product" aria-expanded="false" aria-controls="ui-product">
              <i class="icon-layout menu-icon"></i>
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
              <i class="icon-layout menu-icon"></i>
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
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">All Users</p>
                  <div class="row">
                    <div class="col-12">
                      <div class="table-responsive">
                        <table id="example" class="display expandable-table" style="width:100%">
                          <thead>
                            <tr>
                              <th>ID#</th>
                              <th>Full name</th>
                              <th>Email</th>
                              <th>Points</th>
                              <th>Created at</th>
                              <th>Options</th>
                              <!-- <th>Updated at</th> -->
                              <!-- <th></th> -->
                            </tr>
                          </thead>
                          <!-- start t body table -->
                          <tbody>
                            <?php
                              // fetch user form table users
                              $fetch_user = $connect->prepare("SELECT * FROM users");
                              $fetch_user->execute();
                              $row_user = $fetch_user->fetchAll();
                              $count_user = $fetch_user->rowCount();
                              // start if condition is users > 0
                              if($count_user > 0){ 
                                // start for loop of users
                                foreach($row_user as $user){
                                  ?>
                                  <tr class="odd"> 
                                  <td class="select-checkbox">
                                     <?php echo $user['UserID'] ?>
                                  </td>
                                  <td class="sorting_1">
                                    <?php echo $user['FirstName'] . " " . $user['LastName']?>
                                    <span class="badge btn-info"><?php echo $user['Type']?></span>
                                  </td>
                                  <td class="sorting_1">
                                    <?php echo $user['Email'] ?>
                                  </td>
                                  <td class="sorting_1">
                                    <?php echo $user['Points'] ?>
                                  </td>
                                  <td class="sorting_1">
                                    <?php echo $user['RegistrationDate'] ?>
                                  </td>
                                  <td>
                              <button type="button" class="btn btn-danger btn-sm" onclick="MyAlert(<?php echo htmlspecialchars($user['UserID']); ?>)">Delete</button>
                              <a class="btn btn-info btn-sm" href="EditUser.php?userid=<?php echo urlencode($user['UserID']); ?>">Edit</a>
                              <?php
                              if($user['UserID'] !== $_SESSION['Admin_id']){?>
                                  <a class="btn btn-info btn-sm" href="Chats.php?chat=<?php echo urlencode($user['UserID']); ?>">Msg</a>
                              <?php }
                              ?>
                            </td>
                                </tr> 

                              <?php 
                                } // end loop
                              } // end if count_user
                            ?>
                          </tbody>
                          <!-- end t body table -->
                      </table>
                      </div>
                    </div>
                  </div>
                  </div>
                </div>

                
              </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.  Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
          </div>
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Distributed by <a href="https://www.themewagon.com/" target="_blank">Themewagon</a></span> 
          </div>
        </footer> 
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>   
    <!-- page-body-wrapper ends -->
    
  </div>
  <!-- container-scroller -->


  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="vendors/chart.js/Chart.min.js"></script>
  <!-- <script src="vendors/datatables.net/jquery.dataTables.js"></script> -->
  <!-- <script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script> -->
  <!-- <script src="js/dataTables.select.min.js"></script> -->

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

  <!-- alart function delete -->
  <script>

    function MyAlert(user_id){
      if(confirm("Are you sure to delete") == true){
        let data_form = new FormData();
        data_form.append("deleteuser" , "deleteuser");
        data_form.append("userid" , user_id);
        $.ajax({
          url : 'Fetchdata.php',
          method : "POST",
          data :data_form,
          dataType : false,
          contentType : false,
          processData : false,
          success :function(data){
            location.reload()
          }
        })
      }
    }
  </script>
</body>

</html>


<!-- this line to end session -->
<?php
ob_end_flush();
?>