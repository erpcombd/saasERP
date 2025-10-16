<?php
session_start ();
include ("config/db.php");
include ("config/function.php");



if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = validation($_POST['username']);
    $password = validation($_POST['password']);
    $password = md5($password); // Consider using a more secure hashing algorithm like bcrypt

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT * FROM user_activity_management WHERE username = ? AND password = ?");
    // Bind the parameters
    $stmt->bind_param("ss", $username, $password);
    // Execute the statement
    $stmt->execute();
    // Get the result
    $result = $stmt->get_result();
    $numrows = $result->num_rows;

    if ($numrows != 0) {
        while ($row = $result->fetch_assoc()) {
            $dbuserid  = $row['id'];
            $dbusername = $row['username'];
            $dbpassword = $row['password'];
            $dbcompany = $row['group_for'];
            $dblevel = $row['level'];
            $dbr = $row['region_id'];
            $dbz = $row['zone_id'];
            $dba = $row['area_id'];
        }

        if ($username == $dbusername && $password == $dbpassword) {
            session_start();
            $_SESSION['user_id'] = $dbuserid;
            $_SESSION['username'] = $dbusername;
            $_SESSION['group_for'] = $_SESSION['company_id'] = $dbcompany;
            $_SESSION['level'] = $dblevel;
            $_SESSION['region_id'] = $dbr;
            $_SESSION['zone_id'] = $dbz;
            $_SESSION['area_id'] = $dba;
            $_SESSION['admin_login'] = 'YES';

            // Admin Login log
            // $group_for = 1;
            // $type = 'Admin Login';
            // $ip = $_SERVER['REMOTE_ADDR'];
            // $location = '';

            // $log_date = date('Y-m-d');
            // $sql_log = "INSERT INTO user_activity_log (group_for,type,username,ip,location,log_date) VALUES (?,?,?,?,?,?)";
            // $log_stmt = $conn->prepare($sql_log);
            // $log_stmt->bind_param("isssss", $group_for, $type, $dbusername, $ip, $location, $log_date);
            // $log_stmt->execute();
            // $log_stmt->close();

            header('Location: home.php');
            exit();
        } else {
            echo "Incorrect password";
        }
    } else {
        die("That username doesn't exist");
    }

    // Close the statement
    $stmt->close();
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Secondary Sales</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Secondary</b>Sales</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" name="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>



      <p class="mb-1">
        <a href="#">I forgot my password</a>
      </p>
<!--       <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->





<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
