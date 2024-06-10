<?php
include "connection/connection.php";
ob_start();
session_start();

// check for type user in table user
if (isset($_SESSION["Admin"])) {
  header("location: dashboard.php");
  exit();
}

// check if not tabel users has no admin
$check_admin = $connect->prepare("SELECT UserID FROM users WHERE `Type`=? AND UserID=?");
$check_admin->execute(array("Admin", 1));
$row_admin = $check_admin->fetch();
$count_admin = $check_admin->rowCount();
if ($count_admin > 0) {

  // get request from form php self
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];
    // sql in database of users table
    $sql_statement = $connect->prepare("SELECT 
                                          UserID , FirstName , Email , `Password` , `Type`
                                        FROM
                                          users
                                        WHERE
                                           Email=? 
                                        AND
                                            `Type`='Admin'
                                        ");
    $sql_statement->execute(array($email));
    $row = $sql_statement->fetch();
    $count = $sql_statement->rowCount();
    if ($count > 0) {
      if (password_verify($password, $row["Password"])) {
        $_SESSION["Admin"] = $row["Type"];
        $_SESSION["Admin_id"] = $row["UserID"];
        $_SESSION["Admin_name"] = $row["FirstName"];
        header("location: dashboard.php?user=" . $_SESSION["Admin"]);
        exit();

      }
    }

  }
} else {
  if ($row_admin["UserID"] !== 1) {

    // create admin by default if not admin in table users
    $firstname = "Admin";
    $lastname = "my admin";
    $email = "admin@mail.com";
    $password = password_hash("password", PASSWORD_DEFAULT);
    $type = "Admin";
    $registerdate = date("Y-m-d H:i:s");
    $points = 0;
    $create_admin = $connect->prepare("INSERT INTO
                                          users
                                          (FirstName , LastName , Email , `Password` , `Type` , RegistrationDate , Points)
                                          VALUES
                                          (:firstname , :lastname , :email , :pass , :types , :registerdate , :points) ");
    // sql create admin
    $create_admin->execute(
      array(
        "firstname" => $firstname,
        "lastname" => $lastname,
        "email" => $email,
        "pass" => $password,
        "types" => $type,
        "registerdate" => $registerdate,
        "points" => $points
      )
    );
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
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto ">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo text-center mt-4 font-weight-light">
                <img src="images/eco-logo.png" alt="logo">
              </div>
              <h4>Hello! let's get started</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form class="pt-3" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post"
                enctype="application/x-www-form-urlencoded">
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" name="email"
                    placeholder="email" Required>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" name="password"
                    placeholder="Password" Required>
                </div>
                <div class="mt-3">
                  <input class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit"
                    value="Login">
                  <!-- <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" href="index.html">SIGN IN</a> -->
                </div>

                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="auth-link text-black">Forgot password?</a>
                </div>
                <div class="mb-2">
                  <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                    <i class="ti-facebook mr-2"></i>Connect using facebook
                  </button>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Don't have an account? <a href="register.html" class="text-primary">Create</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
</body>

</html>