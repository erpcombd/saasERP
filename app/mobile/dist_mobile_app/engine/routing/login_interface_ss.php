<? //$cid = explode('.', $_SERVER['HTTP_HOST'])[0];?>

<!doctype html>
<html  lang="en" xml:lang="en" style="height: 100%">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>Secondary Seals</title>
<link rel="icon" type="image/x-icon" href="../assets/images/login/erp_favicon-32x32.png"> 

    <link href="../assets/styles/bootstrap.v4.4.1.min.css" type="text/css" rel="stylesheet"/>

<link rel="stylesheet" type="text/css" href="../assets/styles/acc_mod_index.css" media="all">


<?
 $cloud_bg_logo = "../assets/images/logo/bg_image/New_ERP.png";
 $project_bg_logo = "../assets/images/logo/bg_image/".$cid.".png";
								
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
            <div class="AppForm shadow-lg">
                <div class="row ds-row">
                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                        <div class="AppFormLeft">

                            <div style="text-align:center;margin-bottom: 10px;margin-top: 10px;padding: 10px;">
							   <?
									$cloud_logo = "../assets/images/logo/clouderplogo.png";
									$project_logo = "../assets/images/logo/".$cid.".png";
									if(is_file($project_logo)) {
									$show_logo = $project_logo;
									} else {
									$show_logo = $cloud_logo;
									}
								?>
							<img alt="this is img" src="<?=$show_logo?>" style=" width: 200px;">
							
							</div>

                            <div class="oe_login_error_message oe_enterprise_error_message"></div>
                            <div style="display: none;" class="oe_login_dbpane">
                                <fieldset><legend>Required Information:</legend>
                                    <legend>Database</legend>
                                    <select name="db">
                                        <option value="erpcombd">erpcombd</option>
                                    </select>
                                </fieldset>
                            </div>

                            <div class="form-group position-relative mb-4" >
                                <input type="text" autofocus="autofocus" name="cid" value="<?=$cid;?>" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" id="Companyid" placeholder="Company ID" required>

<!--								<select id="Companyid" name="cid" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" required>
                                        <option value="cloudmvc">cloudmvc</option>
										<option value="rahimgroup">rahimgroup</option>
										
                                    </select>-->
                                <em class="fa fa-building-o"></em >
                            </div>

                            <div class="form-group position-relative mb-4">
                                <input type="text" autofocus="autofocus" name="uid"  value="" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" id="username"
                                       placeholder="Username" required>
                                <em class="fa fa-user-o"></em >
                                <input autofocus="autofocus" name="ibssignin" value="" type="hidden">
                            </div>


                            <div style="opacity: 0; display: none;" class="oe_enterprise_signin">

                                <div style="display: block;" class="oe_enterprise_checker_message">An account with this email address already exists.</div>

                            </div>



                            <div class="form-group position-relative mb-4">
                                <input type="password"  name="pass" value=""  class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" id="password"
                                       placeholder="Password" required>
                                <em class="fa fa-key"></em >

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
                            <img src="../assets/images/login/erp2.png" class="w-100" height="100%" alt="This is image">
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>



</body>

</html>

