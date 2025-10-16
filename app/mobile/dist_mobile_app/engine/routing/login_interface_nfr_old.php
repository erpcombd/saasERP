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



    <style>
		.bg-img{
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
			
		}
	</style>

</head>

<body class=" bg-img ">


<div class="container zoom h-100">
    <div class="row h-100 justify-content-center align-items-center">
        <form class="col-md-12" action="" method="post">
            <div >
			<br><br>
                <div class="row ds-row">
                    <div class="col-md-6 col-sm-6 col-lg-12 d-flex justify-content-center align-items-center">
                        <div class="col-12 w-100">

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

                            <div class="form-group position-relative mb-4" style=" display: none !important;">
                                <input type="text" autofocus="autofocus" name="cid" value="<?=$cid;?>" class="form-control form-input" id="Companyid" placeholder="Company ID" required>

<!--								<select id="Companyid" name="cid" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" required>
                                        <option value="cloudmvc">cloudmvc</option>
										<option value="rahimgroup">rahimgroup</option>
										
                                    </select>-->
                                <em class="fa fa-building-o"></em >
                            </div>

                            <div class="form-group position-relative mb-4">
                                <input type="text" autofocus="autofocus" name="uid"  value="" class="form-control form-input " id="username"
                                       placeholder="Username" required>
                                <em class="fa fa-user-o"></em >
                                <input autofocus="autofocus" name="ibssignin" value="" type="hidden">
                            </div>


                            <div style="opacity: 0; display: none;" class="oe_enterprise_signin">

                                <div style="display: block;" class="oe_enterprise_checker_message">An account with this email address already exists.</div>

                            </div>



                            <div class="form-group position-relative mb-4">
                                <input type="password"  name="pass" value=""  class="form-control form-input " id="password"
                                       placeholder="Password" required>
                                <em class="fa fa-key"></em >

                            </div>



                            <button  name="submit"  class="btn form-button text-light btn-warning btn-block shadow border-0 py-2 text-uppercase ">
                                Login
                            </button>

                            <p class="text-center mt-5">

                            </p>

                        </div>

                    </div>
                    
                </div>
            </div>

        </form>
    </div>
</div>



</body>

</html>

