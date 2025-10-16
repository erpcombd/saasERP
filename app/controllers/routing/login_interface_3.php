<!doctype html>
<html  lang="en" xml:lang="en" style="height: 100%">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>ERP Secure Login | CloudERP | ERP.COM.BD</title>

<link rel="icon" type="image/x-icon" href="../../../../public/assets/images/login/erp_favicon-32x32.png"> 
<link href="../../../../public/assets/css/bootstrap.v4.4.1.min.css" type="text/css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="../../../../public/assets/css/acc_mod_index.css" media="all">


<?
 $cloud_bg_logo = "../../../../public/assets/images/logo/bg_image/New_ERP.png";
 $project_bg_logo = "../../../../public/assets/images/logo/bg_image/".$cid.".png";
								
	if(is_file($project_bg_logo)) {
		$bg_image = $project_bg_logo;
	} else {
		$bg_image = $cloud_bg_logo;
	}
								
?>

<style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg, #920000, #df0000, #570101);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .container {
      padding: 0;
      display: flex;
      width: 60%;
      height: 60%;
      background: #8b0000;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 20px rgba(23, 23, 23, 0.3);
      zoom: 65%;
    }

    .angled-banner {
      width: 100%;
      height: 100%;
      background: rgb(255, 255, 255);
      clip-path: polygon(0 0, 100% 0, 80% 100%, 0% 100%);
    }

    .container > div:first-child {
      flex: 1;
      position: relative;
    }

    .login-container {
      flex: 1;
      padding: 40px;
      background: transparent;
      display: flex;
      flex-direction: column;
      justify-content: center;
      color: #fff;
    }

    .logo {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        }


    .logo img {
      width: 100px;
    }
    .mobile-logo{
      display: none;
    }

    h2 {
      color: #ffffff;
      text-align: center;
      margin-bottom: 25px;
    }

    .input-group {
      margin-bottom: 20px;
    }

    .input-group label {
      display: block;
      margin-bottom: 5px;
    }

    .input-group input {
      width: 100%;
      padding: 10px;
      border: 1px solid #555;
      border-radius: 5px;
      background: #ffffff;
      color: #000000;
    }

    .input-group input:focus {
      border-color: #0075bf;
      outline: none;
    }

    .options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 14px;
      margin-bottom: 20px;
    }

    .options input {
      margin-right: 5px;
    }

    .login-btn {
      width: 100%;
      padding: 12px;
      background: #540000;
      border: none;
      border-radius: 5px;
      color: #ffffff;
      font-weight: bold;
      cursor: pointer;
    }

    .login-btn:hover {
      background: #710000;
    }
    .bg-bubbles {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1;
}
.bg-bubbles li {
  position: absolute;
  list-style: none;
  display: block;
  width: 40px;
  height: 40px;
  background-color: rgba(45, 45, 45, 0.3);
  bottom: -160px;
  animation: square 25s infinite; 
  transition-timing-function: linear;
}
.bg-bubbles li:nth-child(1) {
  left: 10%;
}
.bg-bubbles li:nth-child(2) {
  left: 20%;
  width: 80px;
  height: 80px;
  animation-delay: 2s;
  animation-duration: 17s;
}
.bg-bubbles li:nth-child(3) {
  left: 25%;
  animation-delay: 4s;
  
}
.bg-bubbles li:nth-child(4) {
  left: 40%;
  width: 60px;
  height: 60px;
  animation-duration: 22s;
  background-color: rgba(45, 45, 45, 0.3);
}
.bg-bubbles li:nth-child(5) {
  left: 70%;
}
.bg-bubbles li:nth-child(6) {
  left: 80%;
  width: 120px;
  height: 120px;
  animation-delay: 3s;
  background-color: rgba(45, 45, 45, 0.3);
}
.bg-bubbles li:nth-child(7) {
  left: 32%;
  width: 160px;
  height: 160px;
  animation-delay: 7s;
}
.bg-bubbles li:nth-child(8) {
  left: 55%;
  width: 20px;
  height: 20px;
  animation-delay: 15s;
  animation-duration: 40s;
}
.bg-bubbles li:nth-child(9) {
  left: 25%;
  width: 10px;
  height: 10px;
  animation-delay: 2s;
  animation-duration: 40s;
  background-color: rgba(29, 29, 29, 0.3);
}
.bg-bubbles li:nth-child(10) {
  left: 90%;
  width: 160px;
  height: 160px;
  animation-delay: 11s;        
}
@keyframes square {
  0% {
    transform: translateY(0);
  }
  100% {
    transform: translateY(-700px) rotate(600deg);
  }
}
@keyframes square {
  0% {
            transform: translateY(0);
  }
  100% {
            transform: translateY(-700px) rotate(600deg);
  }
}

    /* =============== Responsive Styles =============== */

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
        height: auto;
        width: 85%;
      }
      .mobile {
        display: none;
      }
      .mobile-heading{
        display: none;
      }
      .mobile-logo {
        padding: 5px;
        background-color: #fff;
        display: block;
        width: 100px;
        margin: 0 auto 20px;
        border-radius: 5px;
        -webkit-box-shadow: 1px 6px 30px -9px rgba(252, 252, 252, 1);
        -moz-box-shadow: 1px 6px 30px -9px rgba(252, 252, 252, 1);
        box-shadow: 1px 6px 30px -9px rgba(252, 252, 252, 1);
      }
      .angled-banner {
        clip-path: none;
        height: 200px;
      }

      .login-container {
        padding: 30px 20px;
      }

      .logo img {
        width: 80px;
      }

      h2 {
        font-size: 22px;
      }
      .bg-bubbles{
        display: none;
      }
    }

    @media (max-width: 480px) {
      .login-container {
        padding: 20px 15px;
      }

      .input-group input {
        padding: 8px;
      }

      .login-btn {
        padding: 10px;
        font-size: 16px;
      }

      .options {
        flex-direction: column;
        align-items: flex-start;
      }
      .bg-bubbles{
        display: none;
      }
    }
    .custom-alert {
      position: fixed;
      top: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 100%;
      max-width: 600px;
      z-index: 1050;
      border-radius: 0;
      margin: 0;
  }
  </style>

</head>

<body>
<div class="oe_login_error_message oe_enterprise_error_message">
        <!-- Show Error Message if Login Fails -->
        <?php if (!empty($msg)) { ?>
        <div class="custom-alert alert alert-danger text-center">
            <?= htmlspecialchars($msg) ?>
        </div>
<?php } ?>

</div>
<div class="container">
  <div class="mobile">
    <div class="angled-banner">
      <div class="logo">
        <img src="../../../../public/assets/images/ERP-OLD-LOGO.png" alt="ERP Logo">
      </div>
      <ul class="bg-bubbles">
        <li></li><li></li><li></li><li></li><li></li>
        <li></li><li></li><li></li><li></li><li></li>
      </ul>
    </div>
  </div>

  <div class="login-container">
    <h2 class="mobile-heading">Login</h2>
    <img class="mobile-logo" src="../../../../public/assets/images/ERP-OLD-LOGO.png" alt="ERP Logo">
    <form action="" method="post">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="input-group">
            <!-- <label for="username">Company ID</label> -->
            <input type="text" autofocus="autofocus" name="cid" value="<?= $cid ?>" id="Companyid" placeholder="Company ID" required />
        </div>
      <div class="input-group">
        <!-- <label for="username">Username</label> -->
        <input type="text" autofocus="autofocus" name="uid"  value=""  id="username" placeholder="Username" required />
      </div>
      <div class="input-group">
        <!-- <label for="password">Password</label> -->
        <input type="password" id="password" placeholder="Password" required />
      </div>
      <div class="options">
        <label><input type="checkbox" value="" id="defaultCheck1" /> Remember me</label>
      </div>
      <button type="submit" class="login-btn">Login</button>
    </form>
  </div>
</div>


</body>

</html>