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
header("Location:../inventory/home.php");}
}else session_destroy();



if(isset($_POST['ibssignin']))
{
$msg="Invalid Login Information!!!";
$type=0;
}

?>
<!DOCTYPE html>
<html style="height: 100%">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">


        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
 <!--    <script>
  var screen_width = screen.width;
  if(screen_width<=600){
    window.location.href = "index2.php";
  }
</script>-->
        <title>Inventory Software</title>
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        
        
        
        
    
<link rel="stylesheet" type="text/css" href="index.css" media="all">
<link href="../../../assets/css/style.css" type="text/css" rel="stylesheet"/>



<link href="../../../assets/css/menu.css" type="text/css" rel="stylesheet"/>



<link href="../../../assets/css/table.css" type="text/css" rel="stylesheet"/>



<link href="../../../assets/css/input.css" type="text/css" rel="stylesheet"/>



<link href="../../../assets/css/form.css" type="text/css" rel="stylesheet"/>



<link href="../../../assets/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>







<link href="../../../assets/css/pagination.css" rel="stylesheet" type="text/css" />



<link href="../../../assets/css/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />



<meta name="Developer" content="Md. Mhafuzur Rahman Cell:01815-224424 email:mhafuz@yahoo.com" />



<link href="../../../assets/css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />







<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">







<script type="text/javascript" src="../../../assets/js/jquery-1.4.2.min.js"></script>



<script type="text/javascript" src="../../../assets/js/jquery-ui-1.8.2.custom.min.js"></script>



<script type="text/javascript" src="../../../assets/js/jquery.ui.datepicker.js"></script>



<script type="text/javascript" src="../../../assets/js/jquery.autocomplete.js"></script>



<script type="text/javascript" src="../../../assets/js/jquery.validate.js"></script>



<script type="text/javascript" src="../../../assets/js/paging.js"></script>



<script type="text/javascript" src="../../../assets/js/ddaccordion.js"></script>



<script type="text/javascript" src="../../../assets/js/js.js"></script>

<style>
	.login-box {
  width: 360px;
  margin-top:10%;
}






@media (max-width: 576px) {
  .login-box,
   {
    margin-top:15%;
  }
}
</style>

</head>
<body>
<div class="openerp openerp_webclient_container">
    <table class="oe_webclient">
        <tbody><tr style="display: none;">
            <td class="oe_topbar" colspan="2">
                <div class="oe_menu_placeholder"></div>
                <div class="oe_user_menu_placeholder"></div>
                <div class="oe_systray"></div>
            </td>
        </tr>
        <tr>
            <td style="display: none;" class="oe_leftbar" valign="top">&nbsp;</td>
            <td class="oe_application">
            <div><div class="oe_enterprise oe_login_signup" style="height:100vh">
            
            <div class="oe_enterprise_content">
                <div class="oe_enterprise_background_header"></div>
                <div class="oe_login_pane oe_enterprise_pane col-md-4 col-sm-12 col-xs-12">
                    <form action="" method="post">
                        <div style="opacity: 0; display: none;" class="oe_enterprise_signin">
                            <h2>Inventory Sign In</h2>
                        </div>
                        <div style="opacity: 1; display: block;" class="oe_enterprise_signup">
                            <h2>User Module  - ERP Solution</h2>
                        </div>
                        <div class="oe_login_error_message oe_enterprise_error_message"></div>

                        
                        <p>Welcome to the User Module. Please provide access information to enter in.</p>
                        <div style="display: none;" class="oe_login_dbpane">
                            <fieldset>
                                <label>Database</label>
                                
    <select name="db">
        
            
            
                <option value="openerp">openerp</option>
    </select>
                            </fieldset>
                      </div>
                     <fieldset>
                          <label>Your Company ID</label>
                          <input autofocus="autofocus" class="oe_enterprise_login_input" name="ibssignin" value="cloudhrm" type="hidden" width="95%">
						   <input autofocus="autofocus" class="oe_enterprise_login_input" name="cid" value="" type="text" width="95%">
                      </fieldset>
                        <fieldset>
                          <label>Your Email Address</label>
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
                            <button name="submit">Sign In</button>
                          </fieldset>
                            <div class="oe_enterprise_bottom signin"><p><a href="#">Forgot Password</a></p></div>
                      </div>
                    </form>
                </div>
            </div>
        </div></div></td>
        </tr>
    </tbody></table>
<div class="oe_notification ui-notify"></div>
<div style="display: none;" class="oe_loading">Loading</div>
</div>


</body>
</html>
