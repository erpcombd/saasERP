<!doctype html>
<html  lang="en" xml:lang="en" style="height: 100%">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>ERP Secure Login | CloudERP | ERP.COM.BD</title>

<link rel="icon" type="image/x-icon" href="../../../../public/assets/images/login/erp_favicon-32x32.png"> 
<!--<link href="../../../../public/assets/css/bootstrap.v4.4.1.min.css" type="text/css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="../../../../public/assets/css/acc_mod_index.css" media="all">
-->

<?
 $cloud_bg_logo = "../../../../public/assets/images/logo/bg_image/New_ERP.png";
 $project_bg_logo = "../../../../public/assets/images/logo/bg_image/".$cid.".png";
								
	if(is_file($project_bg_logo)) {
		$bg_image = $project_bg_logo;
	} else {
		$bg_image = $cloud_bg_logo;
	}
								
?>

    <style type="text/css">
	        :root {
            --primary-color: #4361ee;
            --primary-light: #4895ef;
            --primary-dark: #3f37c9;
            --secondary-color: #7209b7;
            --accent-color: #4cc9f0;
            --success-color: #0cce6b;
            --warning-color: #ff9e00;
            --danger-color: #e5383b;
            --dark-color: #212529;
            --light-color: #f8f9fa;
            --background: #f0f2f5;
            --card-bg: rgba(255, 255, 255, 0.8);
            --card-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            --hover-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
            --transition-fast: 0.2s;
            --transition-normal: 0.3s;
            --border-radius-sm: 8px;
            --border-radius-md: 12px;
            --border-radius-lg: 20px;
            --gradient-primary: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            --gradient-secondary: linear-gradient(135deg, var(--secondary-color), #f72585);
            --gradient-success: linear-gradient(135deg, #2ec4b6, var(--success-color));
            --gradient-warning: linear-gradient(135deg, #ff9e00, #ff4d00);
            --gradient-accent: linear-gradient(135deg, #4cc9f0, #06d6a0);
            --gradient-bg: linear-gradient(135deg, #f8f9fa, #e9ecef);
        }
		
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

/*    body {
      font-family: Arial, sans-serif;
      background: #ffffff;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }*/
        body {
            background: var(--background);
            color: var(--dark-color);
            line-height: 1.6;
            position: relative;
		    height: 100vh;
		    display: flex;
		    align-items: center;
		    justify-content: center;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
/*         background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect fill="%234361ee" opacity="0.03" width="50" height="50" x="0" y="0"/><rect fill="%234361ee" opacity="0.03" width="50" height="50" x="50" y="50"/></svg>');*/
			background: url('<?=SERVER_ASSET?>/images/login/bg_image.svg');
			background-repeat: repeat;

            z-index: -1;
        }
        
    .container {
      display: flex;
      width: 60%;
      height: 70%;
      background: #ffffff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 20px rgba(0, 64, 255, 0.3);
      zoom: 80%;
    }

    .angled-banner {
      width: 100%;
      height: 100%;
      background:#0074BF;
      border-radius: 0px 200px 0px 200px;
      -moz-border-radius: 0px 200px 0px 200px;
      -webkit-border-radius: 0px 200px 0px 200px;
      border: 0px solid #000000;border-radius: 0px 200px 0px 200px;
      -moz-border-radius: 0px 200px 0px 200px;
      -webkit-border-radius: 0px 200px 0px 200px;
      border: 0px solid #000000;
    }
    .angled-banner-white {
      width: 100%;
      height: 100%;
      background: rgb(255, 255, 255, 0.1);
      border-radius: 0px 0px 200px 0px;
      -moz-border-radius: 0px 0px 200px 0px;
      -webkit-border-radius: 0px 0px 200px 0px;
      border: 0px solid #000000;
    }

    .container > div:first-child {
      flex: 1;
      position: relative;
    }

    .banner {
      position: relative;
      width: 100%;
      height: 100%;
      background: #ffffff00;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      gap: 15px;
    }

    .company-name {
      position: absolute;
      top: 40%;
      left: 47%;
      transform: translate(-50%, -50%);
      text-align: center;
      color: #ffffff;
    }
    .solgan {
      position: absolute;
      top: 46%;
      left: 47%;
      transform: translate(-50%, -50%);
      text-align: center;
      color: #ffffff;
    }

    .login-container-wrapper{
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #0074BF;
      position: relative;
    }

    .login-container {
      height: 100%;
      flex: 1;
      padding: 40px;
      background: #ffffff;
      display: flex;
      flex-direction: column;
      justify-content: center;
      color: #000000;
      border-radius: 0px 200px 0px 0px;
      -moz-border-radius: 0px 200px 0px 0px;
      -webkit-border-radius: 0px 200px 0px 0px;
      border: 0px solid #000000;
    }
    .logo-div{
      background-color: #fff;
      height: 100px;
      width: 100px;
      position: absolute;
      top: 17%;
      left: 37%;
      border-radius: 95px;
    }

    .logo {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        }


    .logo img {
      width: 70px;
    }
    .mobile-logo{
      display: none;
    }

    h2 {
      color: #0074BF;
      text-align: center;
      margin-bottom: 25px;
    }
    .login-form{
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .input-group {
      margin-bottom: 20px;
      width: 90%;
    }

    .input-group label {
      display: block;
      margin-bottom: 5px;
    }

    .input-group input {
      width: 100%;
      padding: 14px;
      border: 1px solid #555;
      border-radius: 20px;
      background: #ffffff;
      color: #000000;
    }

    .input-group input:focus {
      border-color: #0075bf;
      outline: none;
    }

    .forgot-password{
      margin-left: 20px;
      color: #0075bf;
      text-decoration: none;
      font-size: 14px;
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
      width: 50%;
      padding: 12px;
      background: #0075bf;
      border: 1px solid #ffffff;
      border-radius: 20px;
      color: #ffffff;
      font-weight: bold;
      cursor: pointer;
    }

    .login-btn:hover {
      background: #003557;
    }
.custom-alert {
      width: 90%;
  padding: 15px 20px;
  border: 1px solid transparent;
  border-radius: 4px;
  font-size: 16px;
  margin-bottom: 1rem;
}

.custom-alert-warning {
      width: 90%;
  color: #856404;
  background-color: #fff3cd;
  border-color: #ffeeba;
}


    /* =============== Responsive Styles =============== */

    @media (max-width: 768px) {
  .container {
    flex-direction: column;
    width: 100%;
    height: 100%;
    border-radius: 0;
    box-shadow: none;
    zoom: 100%;
  }

  .mobile {
    display: none;
  }

  .login-container-wrapper {
    background-color: #ffffff;
    width: 100%;
    height: 100%;
  }

  .login-container {
    background: linear-gradient(to bottom,  #00BFFF, #003b62);
    padding: 20px;
    height: 100%;
    border-radius: 0px 0px 0px 200px;
    -moz-border-radius: 0px 0px 0px 200px;
    -webkit-border-radius: 0px 0px 0px 200px;
    border: 0px solid #000000;
  }

  .company-name,
  .solgan {
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    font-size: 18px;
  }

  .logo-div {
    top: 10px;
    left: 50%;
    transform: translateX(-50%);
  }

  .logo {
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
  .heading {
    color : #ffffff;
  }
}

  </style>

</head>

<body>


<div class="container">
  <div class="mobile">
    <div class="angled-banner">
      <div class="angled-banner-white">
        <div class="banner">
          <div class="logo-div">
            <div class="logo">
				<?
					$cloud_logo = "../../../../public/assets/images/logo/clouderplogo.png";
					$project_logo = "../../../../public/assets/images/logo/".$cid.".png";
					if(is_file($project_logo)) {
						$show_logo = $project_logo;
					} else {
						$show_logo = $cloud_logo;
					}
				?>
				<img src="<?=htmlspecialchars($show_logo)?>" alt="Company Logo" >
            </div>
          </div>
          <h3 class="company-name">&nbsp;</h3>
          <h5 class="solgan">&nbsp;</h5>
		  <img src="<?=SERVER_ASSET?>/images/login/erp2.gif" alt="This is image" style=" width: 345px; margin-top: 120px; ">
        </div>
      </div>
    </div>
  </div>

  <div class="login-container-wrapper">
    <div class="login-container">
      <h2 class="heading">Login</h2>
      <!-- <img class="mobile-logo" src="C:/Users/shahr/OneDrive/Documents/ezzy-erp/ERP-OLD-LOGO.png" alt="ERP Logo"> -->
      <form class="login-form"  action="" method="post">
	  <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <!-- Show Error Message if Login Fails -->
            <?php if (!empty($msg)) { ?>
				  <div class="custom-alert custom-alert-warning" role="alert"><?=htmlspecialchars($msg);?></div>
            <?php } ?>
	   
        <div class="input-group">
          <input type="text" autofocus="autofocus" name="qr_input"  value="" id="qr_input" placeholder="OTP" required>
        </div>
        
        
        <button type="submit" name="submit" class="login-btn">Login</button>
      </form>
    </div>
  </div>
</div>




</body>

</html>