<?php
@session_start();
ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title="Password Change";

$u_id=$_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);


if(isset($_POST['update']))

{

  $old_pass = md5($_POST['old_pass']);

  $new_pass = md5($_POST['new_pass']);

  $confirm_pass = md5($_POST['confirm_pass']);

  $orginal_old_pass = find_a_field('user_activity_management','password','PBI_ID="'.$PBI_ID.'"');

  if($old_pass==$orginal_old_pass){

      if($new_pass==$confirm_pass){

	  $update = 'update user_activity_management set password="'.$confirm_pass.'",default_checker="1" where user_id="'.$_SESSION['user']['id'].'" and PBI_ID="'.$PBI_ID.'"';

      $updated = db_query($update);

      $_SESSION['msggg']= '<span style="color:green;">Password Updated. Login Now</span>';

      echo "<script>window.top.location='../../pages/main/logout.php'</script>";

	  

	  }else{

	  $msg = '<span style="color:red; font-weight:bold;">New password & confirm password not match!</span>';

	  }

  }else{

     $msg = '<span style="color:red; font-weight:bold;">Old password not match!</span>';

  }

}

?>



<link rel="icon" type="image/x-icon" href="../../../../public/assets/images/login/robi_favicon-32x32.png">
<meta name="Developer" content="Md. Mhafuzur Rahman Cell:01815-224424 email:mhafuz@yahoo.com" />
    <!--Bootstrap 4.4.1 css-->
    <link href="../../../assets/css/bootstrap.v4.4.1.min.css" type="text/css" rel="stylesheet"/>

<link rel="stylesheet" type="text/css" href="../../../assets/css/acc_mod_index.css" media="all">
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" >
<?php /*?><?
 $cloud_bg_logo = "../../../logo/bg_image/New_ERP.png";
 $project_bg_logo = "../../../logo/bg_image/".$cid.".png";
								
	if(is_file($project_bg_logo)) {
		$bg_image = $project_bg_logo;
	} else {
		$bg_image = $cloud_bg_logo;
	}
								
?><?php */?>

    <style type="text/css">
::-webkit-scrollbar {
    display: none;
}
.sidebar ,.sr-main-content-heading,.navbar-fixed-top{display: none;}
.main_content{
overflow: hidden !important;

width:100% !important}
        @import url('https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap');
        *{
            padding: 0;
            margin: 0;
            outline: none;
        }
		.sr-main-content-padding{
		padding:0px !important;
		margin:0px !important;}
.ep-body {
    position: relative !important;
    top: -5px;
    left:-5px;
    font-family: 'Roboto', sans-serif !important;
    width: 110%;
    height: 110vh; /* Change height to 100vh to fill the entire viewport height */
    margin: 0 !important; /* Remove any default margins */
    color: #3a3e42 !important;
    /*background: #891c36 !important;*/
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
            /*background-image: url('../../../../public/assets/images/erp.jpg');*/
           /* background-color: #e41a4c;*/
		    /*background-color: #ed1a2b;*/
			background: linear-gradient(45deg,#cd3b00,#060506) !important;
            height: 100% !important;
            /*height: 450px;*/
            background-position: center !important;
            background-repeat: no-repeat !important;
            background-size: cover !important;
            /*background-size: cover;*/
            /*background-position: center;*/
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
    border: none !important; /* Remove border */
    outline: none !important;
}
input[type=text]:focus, input[type=password]:focus, select:focus {
    border-color: transparent !important;
}


.form-group {
    border:none !important;
}
    </style>



<div class="ep-body">


<div class="container h-100" style=" zoom: 85%; " style="transform: scale(0.7);">
    <div class="row h-100 justify-content-center align-items-center">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="AppForm shadow-lg">
                <div class="row ds-row">
                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                        <div class="AppFormLeft">

                            <div style="text-align:center;  margin-bottom: 22px; margin-top: 12px;">
<?php /*?>							   <?
									$cloud_logo = "../../../logo/clouderplogo.png";
									$project_logo = "../../../logo/".$cid.".png";
									if(is_file($project_logo)) {
									$show_logo = $project_logo;
									} else {
									$show_logo = $cloud_logo;
									}
								?>
								<img src="<?=$show_logo?>" style=" width: 200px;">
								<?php */?>
							
							<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" style=" width: 200px;">
							
							</div>

							
                            <div class="form-group position-relative mb-4">
							<input name="old_pass" type="password" id="old_pass" value="" placeholder="Old Password" required/>
                                <i class="fa fa-key"></i>
                            <hr>
                            </div>

                            <div class="form-group position-relative mb-4">
							<input name="new_pass" type="password" id="new_pass" value="" placeholder="New Password" required/>
                                <i class="fa fa-key"></i>
                            <hr>
                            </div>


                            <div class="form-group position-relative mb-4">
							<input name="confirm_pass" type="password" id="confirm_pass" value="" placeholder="Confirm Password" required/>
                                <i class="fa fa-key"></i>
                            <hr>
                            </div>


                          
                            <button  name="update" accesskey="S" type="submit" class="btn btn-success btn-block shadow border-0 py-2 text-uppercase ">
                                Update
                            </button>

                            <p class="text-center mt-5">

                            </p>

                        </div>

                    </div>
                    <div class="col-md-6 p-0 sec-display" >
                        <div class="AppFormRight position-relative d-flex justify-content-center flex-column align-items-center text-center p-5 text-white">

                            <img src="../../../../public/assets/images/login/erp01.png" width="100%" height="100%">
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>



</div>


<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>