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

    <style type="text/css">
        *{
            padding: 0;
            margin: 0;
            outline: none;
        }
        body{
            font-family: 'Roboto', sans-serif !important;
            height:100vh;
            color: #3a3e42 !important;
			background: linear-gradient(45deg,#124DE8,#16E9FD);
        }
        .AppFormLeft{
            width: 300px;
        }
        .AppForm .AppFormLeft h1{
            font-size: 35px;
        }
        .AppForm .AppFormLeft input:focus{
            border-color: #ced4da;
        }
        .AppForm .AppFormLeft input::placeholder{
            font-size: 15px;
        }
        .AppForm .AppFormLeft i{
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
        }
        .AppForm .AppFormLeft a{
            color: #3a3e42 ;
        }
        .AppForm .AppFormLeft button{
			background: #3940EB;
            border-radius: 30px;
        }
        .AppForm .AppFormLeft p span{
            color: #007bff;
        }
        .AppForm .AppFormRight{

			background: linear-gradient(45deg,#16EAFD,#3940EB);
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
			border-radius: 0px 10px 10px 0px;
			
        }
        .AppForm .AppFormRight:after{
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg,#16EAFD,#3940EB);
            opacity: 0.5;
        }
        .AppForm .AppFormRight h2{
            z-index: 1;
        }
        .AppForm .AppFormRight h2::after{
            content: "";
            position: absolute;
            width: 100%;
            height: 2px;
            background-color: #fff;
            bottom: 0;
            left:50%;
            transform: translateX(-50%);
        }
        .AppForm .AppFormRight p{
            z-index: 1;
        }
		.sec-display{
			display:block;
		}
		
		.ds-row{
			background-color: #fff;
			border-radius: 10px 10px 12px 10px;
		}
		
		@media only screen and (max-width: 768px) {
			.sec-display{
				display: none;
			}
			.ds-row{
			    background-color: #fff;
				border-radius: 20px;
				margin: 1px;
			}
		}
		.zoom {
		  zoom: 90%;
		}
		
				/* Password css start showin eye*/
		.password-input-container {
            position: relative;
        }
		.password-toggle {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            font-size: 16px;
        }
		/* Password css End showin eye*/
		
		
    </style>

</head>

<body>


<div class="container zoom h-100">
    <div class="row h-100 justify-content-center align-items-center">
        

        
        <form class="col-md-9" action="" method="post">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <div class="AppForm shadow-lg">
                <div class="row ds-row">
                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                        <div class="AppFormLeft">

                            <div style="text-align:center;margin-bottom: 10px;margin-top: 10px;padding: 10px;">
							   <?
									$cloud_logo = "../../../../public/assets/images/logo/clouderplogo.png";
									$project_logo = "../../../../public/assets/images/logo/".$cid.".png";
									if(is_file($project_logo)) {
									$show_logo = $project_logo;
									} else {
									$show_logo = $cloud_logo;
									}
								?>
							<img alt="Company Logo" src="<?=htmlspecialchars($show_logo) ?>" style="width: 200px;" loading="lazy">
							
							</div>

                            <div class="oe_login_error_message oe_enterprise_error_message">
                                
                                <!-- Show Error Message if Login Fails -->
                                <?php if (!empty($msg)) { ?>
                                <div class="alert alert-danger text-center mt-3"><?= htmlspecialchars($msg) ?></div>
                                <?php } ?>
                            </div>


                            <div class="form-group position-relative mb-4">
                                <input type="text" autofocus="autofocus" name="cid" value="<?= $cid ?>" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" id="Companyid" placeholder="Company ID" required>

<!--								<select id="Companyid" name="cid" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" required>
                                        <option value="cloudmvc">cloudmvc</option>
										<option value="rahimgroup">rahimgroup</option>
										
                                    </select>-->
                                <i class="fas fa-building"></i>
                            </div>

                            <div class="form-group position-relative mb-4">
                                <input type="text" autofocus="autofocus" name="uid"  value="" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" id="username"
                                       placeholder="Username" required>
                                <i class="fas fa-user"></i>
                            </div>


                            <div class="form-group position-relative mb-4">
                                <input type="password"  name="pass" value=""  class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" id="password"
                                       placeholder="Password" required>
                                <button type="button" class="password-toggle" onClick="togglePassword('password')"><i class="far fa-eye"></i></button>

                            </div>


                            <div class="row  mt-4 mb-4">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                        <label class="form-check-label" for="defaultCheck1">
                                            Remember me
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 text-right">

                                </div>
                            </div>

                            <button  name="submit"  class="btn btn-success btn-block shadow border-0 py-2 text-uppercase ">
                                Login
                            </button>

                            <p class="text-center mt-5">

                            </p>

                        </div>

                    </div>
                    <div class="col-md-6 p-0 sec-display">
                        <div class="AppFormRight position-relative d-flex justify-content-center flex-column align-items-center text-center p-5 text-white">
                            <img src="../../../../public/assets/images/login/erp2.png" class="w-100" height="100%" alt="This is image">
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

<footer class="text-center mt-4 py-3" style="background: #3940EB; color: white; border-radius: 0 0 10px 10px;">
    <p class="mb-0">&copy; <?= date('Y') ?> <strong>CloudERP</strong>. All rights reserved.</p>
</footer>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
	</script>
</body>

</html>