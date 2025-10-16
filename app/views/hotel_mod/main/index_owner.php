<?php
session_start();
session_destroy();
ob_start();

if(isset($_POST['ibssignin']))
{
require_once "../../../engine/configure/default_values.php";
require_once "../../common/my.php";

connectDB();
	//echo "testing.....";
	$pass = $_POST['pass'];
	$uid  = $_POST['uid'];

				$user_sql="select * from hms_owner_detail where  username='$uid' AND password = '$pass'";
				$user_query=mysql_query($user_sql);
				if(mysql_num_rows($user_query)>0)
				{
					$info=mysql_fetch_object($user_query);
					session_register("Mhafuz");
					$_SESSION['proj_id']	= 'Mhafuz';
					$_SESSION['db_name']	= DB_NAME;
					$_SESSION['db_user']	= DB_USER;
					$_SESSION['db_pass']	= DB_PASS;
					
					$_SESSION['user']['id']	= $info->id;
					$_SESSION['user']['name']	= $info->name;
					
					header("Location:home_owner.php");
				}

}
?>

<div class="login_box">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="left"></td>
      <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="3"><img src="../../images/index_green_login_01.jpg" width="346" height="22" /></td>
        </tr>
        <tr>
          <td><img src="../../images/index_green_login_02.jpg" width="33" height="197" /></td>
          <td class="login_box_body"><div class="form">
              <div class="form">
                <form method="post" action="">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>User name : </td>
                      <td><input name="uid" type="text" class="input" id="uid" size="15" /></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>Password:</td>
                      <td><input name="pass" type="password" class="input" id="pass" size="15" /></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><input name="ibssignin"  type="submit" class="btn" id="ibssignin" value="Login" /></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2">Forgot passwod? Change password.</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2">New User? Register now</td>
                    </tr>
                  </table>
                </form>
              </div>
          </div></td>
          <td><img src="../../images/index_green_login_04.jpg" width="29" height="197" /></td>
        </tr>
        <tr>
          <td colspan="3"><img src="../../images/index_green_login_05.jpg" /></td>
        </tr>
      </table></td>
	  <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><div align="center"><a href="../main/index.php"><img src="../../images/images6.jpg" width="100" height="100" /></a></div></td>
        </tr>
        <tr>
          <td><div align="center"><a href="../main/index_service.php"><img src="../../images/images1.jpg" width="100" height="100"  /> </a></div></td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout_index.php");
?>