<? //$cid = explode('.', $_SERVER['HTTP_HOST'])[0];
?>

<!doctype html>
<html lang="en" xml:lang="en" style="height: 100%">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Secondary Seals</title>
    <link rel="icon" type="image/x-icon" href="../assets/images/login/erp_favicon-32x32.png">

    <link href="../assets/styles/bootstrap.v4.4.1.min.css" type="text/css" rel="stylesheet" />
    <link href="../assets/styles/style.css" type="text/css" rel="stylesheet" />



    <style>
        body {
            background-color: #0066b3;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo {
            max-width: 150px;
        }

        .login-card {
            background: white;
            border-radius: 8px;
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .login-title {
            color: #0066b3;
            margin-bottom: 2rem;
        }

        .form-control {
            border: 1px solid #0066b3;
            border-radius: 4px;
            padding: 0.75rem;
        }

        .btn-login {
            background-color: #0066b3;
            border: none;
            padding: 0.75rem;
            width: 100%;
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        .forgot-password {
            color: #0066b3;
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
            <form class="col-md-6 col-lg-4 p-0" action="" method="post">
                <div>
                    <br><br>
                    <div class="row ds-row">
                        <div class="col-md-6 col-sm-6 col-lg-12 d-flex justify-content-center align-items-center p-0">
                            <div class="col-12 w-100 ">

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
                                    <div class="text-center mt-3">
                                        <a href="#" class="forgot-password">Forgot Password?</a>
                                    </div>
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