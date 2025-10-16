<?php 
session_start();
//

require_once "../../../engine/configure/default_values.php";
require_once "../../../engine/configure/check_login.php";

if(isset($_POST['ibssignin']))
{
	$passward 	= $_POST['pass'];
	$uid  		= $_POST['uid'];
	$cid  		= $_POST['cid'];
if(check_for_login($cid,$uid,$passward,1))

$ip=$_SERVER['REMOTE_ADDR'];
$log_sql="INSERT INTO user_activity_log(user_id,access_date,access_time,module_id,page_name,access_detail,ip)
VALUES('".$uid."',NOW(),NOW(),'2','Login_Page','hrm_mod','".$ip."')";
db_query($log_sql);

header("Location:home.php");
}else session_destroy();
?>
<!DOCTYPE html>
<html style="height: 100%">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        
        <title>Inventory Software</title>
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        
        
        
        
    
<link rel="stylesheet" type="text/css" href="index.css" media="all">
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
            <div><div class="oe_enterprise oe_login_signup">
            
            <div class="oe_enterprise_content">
                <div class="oe_enterprise_background_header"></div>
                <div class="oe_login_pane oe_enterprise_pane">
                    <form action="" method="post">
                        <div style="opacity: 0; display: none;" class="oe_enterprise_signin">
                            <h2>Inventory Sign In</h2>
                        </div>
                        <div style="opacity: 1; display: block;" class="oe_enterprise_signup">
                            <h2>Sajeeb HRM Solution</h2>
                        </div>
                        <div class="oe_login_error_message oe_enterprise_error_message"></div>

                        
                        <p>Welcome to the Sajeeb HRM Solution. Please provide access information to enter in.</p>
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
                            <a href="../../../"><img src="images.png" height="50"></a><button name="submit">Sign In</button>
                          </fieldset>
                            <div class="oe_enterprise_bottom signin"><p>
							<a href="../../../../app/MIS/pass" target="_blank">Forgot passwod?</a><a href="#"></a></p>
                            </div>
                      </div>
                        
                    </form>
                </div>
            </div>
        </div></div></td>
        </tr>
    </tbody></table>
<div class="oe_notification ui-notify"></div><div style="display: none;" class="oe_loading">Loading</div></div></body>
</html>
