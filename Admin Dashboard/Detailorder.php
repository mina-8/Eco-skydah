
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


  // get request from form php self
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    

    $product_id = $_POST['productid'];
    $user_id = $_POST['userid'];
    $PointsRedeemed = '';
    $RewardType = '';
    $RedemptionDate = date("Y-m-d H:i:s");
    
    //get product
    $fetch_product = $connect->prepare("SELECT *  FROM `rewards` WHERE UserID=?");
    $fetch_product->execute(array($product_id));
    $row_product = $fetch_product->fetch();
    $count_product = $fetch_product->rowCount();
    if($count_product > 0){

    
    // create rewards 
    // $update_rewards = $connect->prepare("UPDATE
    //                                       rewards
    //                                       SET
    //                                       UserID =? , `PointsRedeemed`=? , RewardType=? , RedemptionDate=?
    //                                       WHERE
    //                                       UserID=? ");
    // // sql update product
    // $update_rewards->execute(array($user_id , $PointsRedeemed , $RewardType ,  $RedemptionDate));

      // create notifcation 
      // $create_product = $connect->prepare("INSERT INTO
      //                                       notifcations
      //                                     (User_id , `text` , created_at)
      //                                     VALUES
      //                                     (:UserID , :`text` , :created_at ) ");
      // // sql create wasteentries
      // $create_product->execute(array(
      //   "UserID" => $_SESSION['Admin_id'] ,
      //   "text" => $last_record ,
      //   "created_at" => $RedemptionDate ,
      // ));
      


    header("location: Allorders.php");
    exit(); 
    }else{
      
    // create rewards 
    // $create_product = $connect->prepare("INSERT INTO
    //                                       rewards
    //                                     (UserID , PointsRedeemed , RewardType , RedemptionDate)
    //                                     VALUES
    //                                     (:UserID , :PointsRedeemed , :RewardType , :RedemptionDate) ");
    // // sql create wasteentries
    // $create_product->execute(array(
    //   "UserID" => $_SESSION['Admin_id'] ,
    //   "PointsRedeemed" => $last_record ,
    //   "RewardType" => $waste_type ,
    //   "RedemptionDate" => $RedemptionDate ,
    // ));

    // // create notifcation 
    // $create_product = $connect->prepare("INSERT INTO
    //                                       notifcations
    //                                     (User_id , `text` , created_at)
    //                                     VALUES
    //                                     (:UserID , :`text` , :created_at ) ");
    // // sql create wasteentries
    // $create_product->execute(array(
    //   "UserID" => $_SESSION['Admin_id'] ,
    //   "text" => $last_record ,
    //   "created_at" => $RedemptionDate ,
    // ));

    // header("location: Allorders.php");
    // exit(); 
    }
    
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
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="vendors/select2/select2.min.css">
  <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- new file css upload file button -->
  <link rel="stylesheet" href="css/uploadbtn/upload-btn.css">
  
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
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
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="icon-bell mx-0"></i>
              <span class="count"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
              
              <a class="dropdown-item preview-item">
                
                <div class="preview-item-content">
                  
                  <?php 
                  $fetch_notfication = $connect->prepare("SELECT * FROM notifcations WHERE User_id=?");
                  $fetch_notfication->execute(array($_SESSION["Admin_id"]));
                  $row_notfi = $fetch_notfication->fetchAll();
                  $count_notfi = $fetch_notfication->rowCount();
                  if($count_notfi > 0){
                    foreach($row_notfi as $notfi){?>
                     <h6 class="preview-subject font-weight-normal"> <?php echo $notfi['text']?> </h6>
                  <?php }
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
          </li>
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <img src="images/eco-icon.png" alt="profile"/>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item">
                <i class="ti-settings text-primary"></i>
                Settings
              </a>
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
            <a class="nav-link"href=<?php echo "dashboard.php?user=" . $_SESSION["Admin"]?>>
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
                <li class="nav-item"> <a class="nav-link" href="MainChat.php">all chats</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-panel">      
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Edit Product</h4>
                  <?php 
                    $fetch_product = $connect->prepare("SELECT * , products.* , users.* FROM `wasteentries` 
                    INNER JOIN products ON wasteentries.ProductID = products.ProductID 
                    INNER JOIN users ON wasteentries.UserID = users.UserID
                    WHERE wasteentries.ProductID=?");
                    $fetch_product->execute(array($_GET['orderid']));
                    $row_procudt = $fetch_product->fetchAll();
                    $count_product = $fetch_product->rowCount();
                    // start check product
                    if($count_product > 0){?>
                      <form class="form-sample"  action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data">

                      <?php 
                      foreach($row_procudt as $product){?>
                          <p class="card-description">
                            Product info
                          </p>
                          <input type="hidden" name="productid" value=<?php echo $product['ProductID']?> />
                          <input type="hidden" name="userid" value=<?php echo $product['UserID']?> />
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Product Name</label>
                                <div class="col-sm-9">
                                  <div class="col-sm-3 col-form-label"><?php echo $product['ProductName'] ?></div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Description</label>
                                <div class="col-sm-9">
                                  <div class="col-sm-3 col-form-label"><?php echo $product['Description'] ?></div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">price</label>
                                <div class="col-sm-9">
                                  <div class="col-sm-3 col-form-label"><?php echo $product['Price'] . " pound" ?></div>
                                </div>
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">waste type</label>
                                <div class="col-sm-9">
                                  <div class="col-sm-3 col-form-label"><?php echo $product['WasteType'] ?></div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">quantity</label>
                                <div class="col-sm-9">
                                  <div class="col-sm-3 col-form-label"><?php echo $product['Quantity'] ?></div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">status</label>
                                <div class="col-sm-9">
                                  <div class="col-sm-3 col-form-label"><?php echo $product['Status'] ?></div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">user name</label>
                                <div class="col-sm-9">
                                  <div class="col-sm-3 col-form-label"><?php echo $product['FirstName'] ?></div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                  <input class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit" value="rewards" />
                                </div>
                              </div>
                            </div>
                          </div>
                          
                    <?php } // end for loop ?>
                    <?php  } // end if main conition  ?>
                  </form>
                </div>
              </div>
            </div>            
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.  Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
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
</body>

</html>


<!-- this line to end session -->
<?php
ob_end_flush();
?>