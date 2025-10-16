<!doctype html>
<html lang="en" xml:lang="en" style="height: 100%">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Mini ERP Software</title>
    <link rel="icon" type="image/x-icon" href="../assets/images/login/erp_favicon-32x32.png">

    <link href="../assets/styles/bootstrap.v4.4.1.min.css" type="text/css" rel="stylesheet" />
    <link href="../assets/styles/style.css" type="text/css" rel="stylesheet" />

    <style>
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
            <form class="col-md-6 col-lg-4 p-0" action="index.php" method="post">
                <div>
                    <br><br>
                    <div class="row ds-row">
                        <div class="col-md-6 col-sm-6 col-lg-12 d-flex justify-content-center align-items-center p-0">
                            <div class="col-12 w-100">

                                <div style="text-align:center;margin-bottom: 10px;margin-top: 10px; padding: 10px;">
                                    <?
									$cid= 'saaserp';
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


                                <div class="login-card">
                                    <h1 class="header1 text-center">Confirm Password</h1>
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Password</label>
                                            <input type="text" autofocus="autofocus" name="password" value="" class="form-control" id="password" placeholder="******" >
                                        </div>
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Confirm Password</label>
                                            <input type="text" autofocus="autofocus" name="password1" value="" class="form-control" id="password" placeholder="******" >
                                        </div>
										
                                        <button type="submit" name="submit" class="btn btn-primary btn-login w-100">Confirm</button>
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