<?php
 session_start();


 $u_id=$_SESSION['user']['id'];
  unset($_SESSION['pass_changer_user_id']);
  unset($_SESSION['pass_changer_email']);
?>

<!doctype html>
<html lang="en" style="height: 100%">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title><?php echo $module_name; ?></title>
<link rel="icon" type="image/x-icon" href="../../../../public/assets/images/login/erp_favicon-32x32.png"> 
<meta name="Developer" content="Md. Mhafuzur Rahman Cell:01815-224424 email:mhafuz@yahoo.com" />
    <!--Bootstrap 4.4.1 css-->
    <link href="../../../../public/assets/css/bootstrap.v4.4.1.min.css" type="text/css" rel="stylesheet"/>
<link rel="stylesheet" href="../../../../public/assets/css/all.min.css">

    <style type="text/css">
::-webkit-scrollbar {
    display: none;
}
        
        *{
            padding: 0;
            margin: 0;
            outline: none;
        }
		.sr-main-content-padding{
		padding:0px !important;
		margin:0px !important;}
body {
    position: relative !important;
    top: -5px;
    left:-5px;
    font-family: 'Roboto', sans-serif !important;
    width: 110%;
    height: 110vh; 
    margin: 0 !important; 
    color: #3a3e42 !important;
    background: linear-gradient(45deg,#e84e10,#801b61) !important;
    overflow: hidden !important;
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
            background: linear-gradient(45deg,#c70c43,#e41a4c);
            border-radius: 30px;
        }
        .AppForm .AppFormLeft p span{
            color: #007bff;
        }
        .AppForm .AppFormRight{

			background: linear-gradient(45deg,#cd3b00,#060506) !important;
            height: 100% !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
            background-size: cover !important;
        }
        .AppForm .AppFormRight:after{
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg,#8D334C,#CF6964) !important;
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
			border-radius: 10px 0px 0px 10px;
            
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

        input[type=text], input[type=password],input[type=email], select {
    height: 35px !important;
    margin: 0px !important;
    width: 100% !important;
    background-color: var(--form-white) !important;
    border: 0px !important; 
    outline: none !important;
}
input[type=text]:focus, input[type=password]:focus, select:focus {
    border-color: transparent !important;
}


.form-group {
    border:none !important;
}
    </style>



<body>


<div class="container h-100" style=" zoom: 70%; " style="transform: scale(0.7);">
    <div class="row h-100 justify-content-center align-items-center">
        <form action="forgot_pass_verification.php" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="AppForm shadow-lg">
                <div class="row ds-row">
                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                        <div class="AppFormLeft">
<div><?=$_SESSION['mmsg'];unset($_SESSION['mmsg']);?></div>
                            <div style="text-align:center;  margin-bottom: 22px; margin-top: 12px;">
							
							<img alt="" src="../../../../public/assets/images/logo/<?=$_SESSION['proj_id']?>.png" style=" width: 200px;">
							
							</div>

							
                            <div class="form-group position-relative mb-4">
							<input name="user_email" type="email" id="user_email" value="" placeholder="Enter Your Email.." required/>
                               
                            <hr>
                            </div>


                          
                            <button  name="ibssignin" accesskey="S" type="submit" class="btn btn-success btn-block shadow border-0 py-2 text-uppercase ">
                                Submit
                            </button>

                            <p class="text-center mt-5">

                            </p>

                        </div>

                    </div>
                    <div class="col-md-6 p-0 sec-display" >
                        <div class="AppFormRight position-relative d-flex justify-content-center flex-column align-items-center text-center p-5 text-white">

                            <img alt="" src="../../../../public/assets/images/login/erp01.png" class="w-100" height="100%">
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>


</body>

</html>
