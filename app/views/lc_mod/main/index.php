<?php 
//
//

require_once "../../../assets/support/inc.login.php";
if(isset($_POST['ibssignin']))
{
	$passward 	= $_POST['pass'];
	$uid  		= $_POST['uid'];
	$cid  		= $_POST['cid'];
if(check_for_login($cid,$uid,$passward,1)){
//header("Location:home.php");
    header("Location:../../../login/pages/main/home.php");
}
}else session_destroy();



if(isset($_POST['ibssignin']))
{
$msg="Cash Management System!!!";
$type=0;
}

?>

<!DOCTYPE html>

<html style="height: 100%">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>L/C Management </title>
<meta name="Developer" content="Md. Mhafuzur Rahman Cell:01815-224424 email:mhafuz@yahoo.com" />


<link rel="stylesheet" type="text/css" href="../../../assets/css/acc_mod_index.css" media="all">
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" >

<style type="text/css">
/* Media Queries: Tablet Landscape */
@media screen and (max-width: 1060px) {
    #primary { width:67%; }
    #secondary { width:30%; margin-left:3%;}  
}

/* Media Queries: Tabled Portrait */
@media screen and (max-width: 768px) {
    #primary { width:100%; }
    #secondary { width:100%; margin:0; border:none; }
}
</style>
</head>

<body>



<div class="erpcombd erpcombd_webclient_container">

    <div class="oe_enterprise oe_login_signup">

            

            <div class="oe_enterprise_content">


                <div class="oe_login_pane oe_enterprise_pane">

                    <form action="" method="post">

                        <div style="opacity: 0; display: none;" class="oe_enterprise_signin">

                            <h2> Sign In</h2>

                        </div>

                        <div style="opacity: 1; display: block;" class="oe_enterprise_signup">
<div style="text-align:center"><img src="<?=SERVER_ROOT?>public/uploads/logo/logo.png" width="200px;" ></div>


                            <h2 style="text-align:center; background-color:#256CBA; color:#FFFFFF; padding:5px; margin:5px; > Accounting Software Solution</h2>

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

                      <fieldset>

                         <label>Your Company ID</label>

                          <input autofocus="autofocus" class="oe_enterprise_login_input" name="cid" value="faridgroup" type="text" width="95%">
						  
						  

                      </fieldset>

                        <fieldset>

                          <label>Your Username</label>

                          <input autofocus="autofocus" class="oe_enterprise_login_input" name="uid" value="" type="text" width="95%">

                          <input autofocus="autofocus" class="oe_enterprise_login_input" name="ibssignin" value="" type="hidden" width="95%">

                        </fieldset>

                        <div style="opacity: 0; display: none;" class="oe_enterprise_signin">

                        <div style="display: block;" class="oe_enterprise_checker_message">An account with this email address already exists.</div>

                      </div>



                      <div style="opacity: 1; display: block;" class="oe_enterprise_signup"></div>

                        <fieldset>

                          <label>Your Password</label>

                          <input name="pass" value="" type="password" width="95%">

                          <div style="opacity: 0; display: none;" class="oe_enterprise_signin"> <span class="contextual_message"> <a style="display: inline;" class="oe_signup_reset_password" href="#">Forgotten your password?</a> </span> </div>

                        </fieldset>

                        <div style="opacity: 1; display: block;" class="oe_enterprise_signup">

                          <fieldset class="oe_enterprise_submit">   
						  
						                              
<span title="Home" style="height:20px; width:30px;"><a href="../../../home/index.php"><i class="fa fa-home fa-3x" ></i></a></span>
                            <button name="submit">Sign In</button>

                          </fieldset>

                           

                      </div>

                        

                    </form>

                </div>

            </div>

        </div>

<div class="oe_notification ui-notify"></div></div></body>

</html>

