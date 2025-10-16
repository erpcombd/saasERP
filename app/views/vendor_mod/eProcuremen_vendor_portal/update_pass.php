<?php
session_start();

 session_start();
//  require_once "../../../controllers/core/init.php";
 require_once "../../../controllers/routing/layout.top.php";

if(isset($_POST['ibspassupdate']))

{
	$user_id = $_SESSION['vendor']['id'];
	
 if($_POST['pass_verify']>0 && $user_id>0){

   $old_pass = auth_encode($_POST['old_pass']);	 
   $confirm_pass = auth_encode($_POST['confirm_pass']);
   
   $update = 'update vendor set password="'.$confirm_pass.'",pass_change="YES" where vendor_id="'.$user_id.'" and password="'.$old_pass.'"';
   $updated = db_query($update);
   $pass_log_insert = 'insert into password_logs set user_id="'.$user_id.'",password="'.$confirm_pass.'",entry_at="'.date('Y-m-d H:i:s').'",entry_by="'.$user_id.'"';
   db_query($pass_log_insert);
   $_SESSION['mmsg'] = '<span style="color:green; font-size:20px;">Password Changed! Login Now</span>';
   echo "<script>window.top.location='../../auth/vendor/index.php'</script>";
   
 }else{
	 $msg = '<span style="color:red; font-size:20px;">Invalid Information!</span>';
	 }

}

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
    background: #fff !important;
    /* background: linear-gradient(45deg,#e84e10,#801b61) !important; */
    overflow: hidden !important;
}

        .AppFormLeft{
            width: 80%;
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

        input[type=text], input[type=password], select {
    height: 35px !important;
    margin: 0px !important;
    width: 100% !important;
    background-color: var(--form-white) !important;
    border: 0px !important; /* Remove border */
    outline: none !important;
}
input[type=text]:focus, input[type=password]:focus, select:focus {
    border-color: transparent !important;
}


.form-group {
    border:none !important;
}
.sr-main-content-padding {
    padding-top:60px !important;
}
    </style>



<body>


<div class="container h-100" style=" zoom: 80%; " style="transform: scale(0.7);">
    <div class="row h-100 justify-content-center align-items-center">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="AppForm shadow-lg">
                <div class="row ds-row">
                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                        <div class="AppFormLeft">

                            <div style="text-align:center;  margin-bottom: 22px; margin-top: 12px;">
							
							<img alt="" src="../../../../public/assets/images/logo/<?=$_SESSION['proj_id']?>.png" style=" width: 150px;">
							
							</div>
							<div id="passMsg" style="font-size:20px; color:#FF0000;"><?=$msg?></div>

							
                            <div class="form-group position-relative mb-4">
							<input name="old_pass" type="password" id="old_pass" value="" placeholder="Old Password" onKeyUp="checkPassword()" required autocomplete="off"/>
                               
                            <hr>
                            </div>

                            <div class="form-group position-relative mb-4">
							<input name="new_pass" type="password" id="new_pass" value="" placeholder="New Password" onKeyUp="checkPassword()" required autocomplete="off"/>
                               
                            <hr>
                            </div>

                             
                            <div class="form-group position-relative mb-4">
							<input name="confirm_pass" type="password" id="confirm_pass" value="" placeholder="Confirm Password" onKeyUp="checkPassword()" required autocomplete="off"/>
                               
                            <hr>
                            </div>


                            
                            <input type="hidden" name="pass_verify" id="pass_verify" value="0"/>
                            <span id="submitButton"></span>
							<span id="pass_policy">
                           <ul>
						    <li>The password should comprise of the following requirements:
							<ul style="color:red;">
							  <li>8 or more characters long</li>
							  <li>Password must contain 1 number</li>
							  <li>Password must contain 1 upper case character</li>
							  <li>Password must contain 1 lower case character</li>
							  <li>Password must contain 1 special character</li>
							  <li>Unable to reuse 6 or more previous passwords</li>
							</ul>
							</li>
							</ul>
							</span>

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

 <script>
        function checkPassword() {
            var password = document.getElementById('new_pass').value;
			var old_pass = document.getElementById('old_pass').value;
			var confirm_pass = document.getElementById('confirm_pass').value;
            
            
            var xhr = new XMLHttpRequest();

            
            xhr.open('POST', 'check_password_vendor.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

           
            xhr.send('password=' + password + '&old_pass=' + old_pass + '&confirm_pass=' + confirm_pass);

            
            xhr.onload = function() {
                if (xhr.status == 200) {
					var res = JSON.parse(xhr.responseText);
					
                    document.getElementById('passMsg').innerText = res['msg'];
					
					document.getElementById('pass_policy').innerHTML = res['policy'];
					document.getElementById('pass_verify').value = res['final_status'];
			
					document.getElementById('submitButton').innerHTML = res['passchangebutton'];
                }
            };
        }
    </script>

</body>

</html>
<?
require_once "../../../controllers/routing/layout.bottom.php";
?>