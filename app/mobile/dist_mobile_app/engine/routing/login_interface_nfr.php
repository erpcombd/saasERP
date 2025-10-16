<? //$cid = explode('.', $_SERVER['HTTP_HOST'])[0];
?>

<!doctype html>
<html lang="en" xml:lang="en" style="height: 100%">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Distributor Portal</title>
    <link rel="icon" type="image/x-icon" href="../assets/images/login/erp_favicon-32x32.png">

    <link href="../assets/styles/bootstrap.v4.4.1.min.css" type="text/css" rel="stylesheet" />
    <link href="../assets/styles/style.css" type="text/css" rel="stylesheet" />



    <style>
        /* .bg-img{
			 background-image: url("../assets/images/logo/bg_image/bacground-img.png");
			 background-repeat: no-repeat;
			 background-attachment: fixed;
			 background-size: 100% 100%;
		}
		.form-input{
			height: 70px;
			border: 2px solid #FBD776; 
			border-radius: 10px; 
			padding: 10px;
			box-sizing: border-box;
			
		}
		.form-button{
			height: 70px;
			border: 2px solid #FBD776; 
			border-radius: 10px; 
			padding: 10px;
			box-sizing: border-box;
			
		} */


        .bg-img {
            background-color: var(--theme-color-bgc) !important;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow: hidden;

        }

        .logo {
            width: 180px;
            margin-top: 4rem;
            margin-bottom: 2rem;
        }

        .login-card {
            background-color: white;
            border-radius: 20px;
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            min-height: 74vh;
            margin-top: 3rem;


        }

        .header1 {
            color: var(--theme-color-bgc) !important;
            font-size: 22px;
            font-weight: 500;
            margin-bottom: 1.5rem;
            /*text-shadow: 0 0 15px #0069b5, 0 0 5px #ffffff;*/
        }

        .form-label {
            color: var(--theme-color-bgc) !important;
            font-size: 15px;
        }

        .form-control {
            height: 48px;
            background-color: #F5F5F5;
            border: none;

        }

        .btn-login {
            background-color: var(--theme-color-bgc) !important;
            border: none;
            height: 48px;
            border-radius: 10px;
            font-size: 15px;
            margin-top: 1.5rem;
        }

        .btn-login:hover {
            background-color: var(--theme-color-bgc) !important;
            opacity: 0.9;
        }

        .forgot-password {
            color: var(--theme-color-bgc) !important;
            font-size: 15px;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }
    </style>

</head>

<body class=" bg-img ">


    <div class="container zoom h-100" style="overflow: hidden;">
        <div class="row h-100 justify-content-center align-items-center">
            <form class="col-md-6 col-lg-4 col-12 p-0" action="" method="post">
                <div> 
                    <br><br>
                    <div class="row ds-row">
                        <div class="col-md-6 col-sm-6 col-lg-12 col-12 d-flex justify-content-center align-items-center p-0">
                            <div class="col-12 col-sm-12 col-md-12 w-100 ">

                                <div style="text-align:center;margin-bottom: 10px;margin-top: 10px; padding: 10px;">
                                    <?
                                    $cloud_logo = "../assets/images/logo/clouderplogo.png";
                                    $project_logo = "../assets/images/logo/" . $cid . ".png";
                                    if (is_file($project_logo)) {
                                        $show_logo = $project_logo;
                                    } else {
                                        $show_logo = $cloud_logo;
                                    }
                                    ?>
                                    <img alt="this is img" src="<?= $show_logo ?>" style=" width: 200px;">

                                </div>

                                <div class="oe_login_error_message oe_enterprise_error_message"></div>
                                <div class="form-group position-relative mb-4" style=" display: none !important;">
                                    <input type="text" autofocus="autofocus" name="cid" value="<?= $cid; ?>" class="form-control form-input" id="Companyid" placeholder="Company ID" required>
                                </div>

                                <div class="login-card">
                                    <h1 class="header1 text-center">Welcome Back!</h1>
                                    <form>
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" autofocus="autofocus" name="uid" value="" class="form-control" id="username" placeholder="Username" required>
                                            <input autofocus="autofocus" name="ibssignin" value="" type="hidden">
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" name="pass" value="" class="form-control " id="password" placeholder="Password" required>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-primary btn-login w-100">Login</button>
                                    </form>
                                    <!--<div class="text-center mt-3">
                                        <a href="#" class="forgot-password">Forgot Password?</a>
                                    </div>-->
                                </div>


                                <div style="opacity: 0; display: none;" class="oe_enterprise_signin">

                                    <div style="display: block;" class="oe_enterprise_checker_message">An account with this email address already exists.</div>

                                </div>


                            </div>

                        </div>

                    </div>
                </div>

            </form>
        </div>
    </div>



</body>

</html>