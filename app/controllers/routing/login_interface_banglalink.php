<!doctype html>
<html lang="en" style="height: 100%">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>ERP Secure Login</title>
<!--<link rel="icon" type="image/x-icon" href="../../../../public/assets/images/login/erp_favicon-32x32.png"> -->
<!--<meta name="Developer" content="Md. Mhafuzur Rahman Cell:01815-224424 email:mhafuz@yahoo.com" />-->

<!--Bootstrap 4.4.1 css-->
<link href="../../../../public/assets/css/bootstrap.v4.4.1.min.css" type="text/css" rel="stylesheet"/>

<link rel="stylesheet" type="text/css" href="../../../../public/assets/css/acc_mod_index.css" media="all">
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" >
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

        @import url('https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap');
        *{
            padding: 0;
            margin: 0;
            outline: none;
        }
        body{
            font-family: 'Roboto', sans-serif !important;
            height:100vh;
            color: #3a3e42 !important;
			/*background: #891c36 !important;*/
			/*background: linear-gradient(45deg,#124DE8,#16E9FD);*/
			background: linear-gradient(45deg, #f16522, #913d14, #ac4818);
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
			background: linear-gradient(45deg, #a94717, #eb6221, #ac4818);
			/*background: #3940EB;*/
            border-radius: 30px;
        }
        .AppForm .AppFormLeft p span{
            color: #007bff;
        }
        .AppForm .AppFormRight{
			background: linear-gradient(45deg, #a94717, #eb6221, #ac4818);
            height: 100%;
            /*height: 450px;*/
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            /*background-size: cover;*/
            /*background-position: center;*/
			border-radius: 0px 10px 10px 0px;
			
        }
        .AppForm .AppFormRight:after{
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg,#16EAFD,#3940EB);
            opacity: -0.5;
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
		
		@media only screen and (max-width: 600px) {
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
								$cloud_logo = "../../../../public/assets/images/logo/banglalink.png";
								$project_logo = "../../../../public/assets/images/logo/".$cid.".png";
								if(is_file($project_logo)) {
									$show_logo = $project_logo;
								} else {
									$show_logo = $cloud_logo;
								}
							?>
							<img src="<?=htmlspecialchars($show_logo)?>" alt="Company Logo"  style=" width: 90px;">
							
							
							</div>

                            <div class="oe_login_error_message oe_enterprise_error_message"></div>
                            <div style="display: none;" class="oe_login_dbpane">
                                <fieldset>
                                    <label>Database</label>
                                    <select name="db">
                                        <option value="erpcombd">erpcombd</option>
                                    </select>
                                </fieldset>
                            </div>
							<!-- Show Error Message if Login Fails -->
							<?php if (!empty($msg)) { ?>
								  <div class="custom-alert custom-alert-warning" role="alert"><?=htmlspecialchars($msg);?></div>
							<?php } ?>
							
                            <div  class="form-group position-relative mb-4">
                                <!--<input type="text" autofocus="autofocus" name="cid" value="<?=$cid?>" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" id="Companyid" placeholder="Company ID" required>-->
								<input type="text" autofocus="autofocus" name="cid" value="banglalink" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" id="Companyid" placeholder="Company ID" required>
                                <i class="fa fa-building-o"></i>
                            </div>

                            <div class="form-group position-relative mb-4">
                                <input type="text" autofocus="autofocus" name="uid"  value="" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" id="username" placeholder="Username" required>
								

                                <i class="fa fa-user-o"></i>
                                <input autofocus="autofocus" name="ibssignin" value="" type="hidden">
                            </div>


                            <div style="opacity: 0; display: none;" class="oe_enterprise_signin">

                                <div style="display: block;" class="oe_enterprise_checker_message">An account with this email address already exists.</div>

                            </div>



                            <div class="form-group position-relative mb-4">
                                <input type="password"  name="pass" value=""  class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" id="password" placeholder="Password" required>
									   <button type="button" class="password-toggle" onClick="togglePassword('password')"><i class="fa fa-eye" style=" right: -17px; "></i></button>
                                <!--<i class="fa fa-key"></i>-->

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
<!--                                    <a href="#">Forgot Password?</a>-->
                                </div>
                            </div>

                            <button  name="submit"  class="btn btn-success btn-block shadow border-0 py-2 text-uppercase ">
                                Login
                            </button>

                            <p class="text-center mt-5">
<!--                                Don't have an account?-->
<!--                                    <span>-->
<!--                                        Create your account-->
<!--                                    </span>-->

                            </p>

                        </div>

                    </div>
					
<!--                    <div class="col-md-6 p-0 sec-display" >
                        <div class="AppFormRight position-relative d-flex justify-content-center flex-column align-items-center text-center p-5 text-white">-->
<!--                            <h2 class="position-relative px-4 pb-3 mb-4">Welcome Back</h2>-->
<!--                            <p>Lorem ipsuing elit. Molomos totam est voluptatum i omos totam est voluptatum i ure sit consectetur ill</p>-->
<!--                            <img src="../../../../public/assets/images/login/banglalink.gif" width="100%">
                        </div>
                    </div>-->
                </div>
            </div>

        </form>
    </div>
</div>



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

