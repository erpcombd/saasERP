<?php
session_start();

require_once("../../config/default_values.php");
require_once('../../config/db_connect_scb_main.php');


if(isset($_POST['ibssignin']))
{
	
	$uid  = $_POST['uid'];
	$passward = $_POST['pass'];
	
	if($_POST['uid']==$_POST['pass']){
	$uid=(int)$uid;
	$passward=(int)$passward;
	}else{
	$uid=(int)$uid;
	}
	
	$cid  = $_POST['cid'];

$sql="SELECT b.db_user,b.db_pass,b.db_name,a.cid,a.id FROM company_info a,database_info b WHERE a.cid='$cid' and a.id=b.company_id and a.status='ON' limit 1";

	$sql=@mysql_query($sql);
	if($proj=@mysql_fetch_object($sql))
	{


					$_SESSION['proj_id']	= $proj->cid;
					$_SESSION['db_name']	= $proj->db_name;
					$_SESSION['db_user']	= $proj->db_user;
					$_SESSION['db_pass']	= $proj->db_pass;
					
require_once "../../config/db_connect.php";		
$user_sql="select * from personnel_basic_info where  PBI_ID='$uid' AND pass = '$passward'";
		
				$user_query=mysql_query($user_sql);
				if(mysql_num_rows($user_query)>0)
				{
				$proj_sql="select * from project_info limit 1";
				$proj=@mysql_fetch_object(mysql_query($proj_sql));
				$info=@mysql_fetch_row($user_query);
				
					
			$_SESSION['user']['level']	= 1;
					$_SESSION['user']['id']	= $_SESSION['employee_selected'] = $info[0];
					$_SESSION['user']['fname']	= $info[4];
					
					$_SESSION['separator']='';
					$_SESSION['mhafuz']='Active';
					$_SESSION['voucher_type']=3;
		
					
//add_user_activity_log($_SESSION['user']['id'],1,1,'Login Page','Succ4essfully Logged In',$_SESSION['user']['level']);

?>
<script>

    window.location.assign("../inventory/home.php")

</script>
<?
					
				}
		}

}
else
session_destroy();
?>
<!DOCTYPE html>
<html style="height: 100%">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>AKSID HRM Solution</title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="index.css" media="all">
</head>
<body>
<div class="openerp openerp_webclient_container">
<table class="oe_webclient">
  <tbody>
    <tr style="display: none;">
      <td class="oe_topbar" colspan="2"><div class="oe_menu_placeholder"></div>
        <div class="oe_user_menu_placeholder"></div>
        <div class="oe_systray"></div></td>
    </tr>
    <tr>
      <td style="display: none;" class="oe_leftbar" valign="top">&nbsp;</td>
      <td class="oe_application"><div>
          <div class="oe_enterprise oe_login_signup">
            <div class="oe_enterprise_content">
              <div class="oe_enterprise_background_header"></div>
              <div class="oe_login_pane oe_enterprise_pane">
                <form action="" method="post">
                <div style="opacity: 0; display: none;" class="oe_enterprise_signin">
                  <h2>Inventory Sign In</h2>
                </div>
                <div style="opacity: 1; display: block;" class="oe_enterprise_signup">
                  <h2>AKSID User Access </h2>
                </div>
                <div class="oe_login_error_message oe_enterprise_error_message"></div>
                <p>Welcome to the AKSID User Access </p>
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
                <input autofocus class="oe_enterprise_login_input" name="cid" value="" type="text" width="95%">
                </fieldset>
                <fieldset>
                <label>Your User ID </label>
                <input autofocus class="oe_enterprise_login_input" name="uid" value="" type="text" width="95%">
                <input autofocus class="oe_enterprise_login_input" name="ibssignin" value="" type="hidden" width="95%">
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
                <br>
                <form action="../../../" method="post">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left"><a href="../../../"><img src="images.png" height="50"></a></td>
                      <td><button name="submit">Sign In</button></td>
                    </tr>
                  </table>
                </form>
                </fieldset>
              </div>
              </form>
            </div>
          </div>
        </div>
  </div>
  </td>
  
  </tr>
  
  </tbody>
</table>
<div class="oe_notification ui-notify"></div>
<div style="display: none;" class="oe_loading">Loading</div>
</div>
</body>
</html>
