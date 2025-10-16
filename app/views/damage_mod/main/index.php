<?php 

session_start();

ob_start();



require_once "../../../engine/configure/default_values.php";

require_once "../../../engine/configure/check_login.php";



if(isset($_POST['ibssignin']))

{

	$passward 	= $_POST['pass'];

	$uid  		= $_POST['uid'];

	$cid  		= $_POST['cid'];

if(check_for_login($cid,$uid,$passward,1))

header("Location:home.php");

}else session_destroy();

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

                      <td>Company ID  : </td>

                      <td><input name="cid" type="text" class="input" id="cid" size="15" value="alinfoods" /></td>

                    </tr>

                    <tr>

                      <td>&nbsp;</td>

                      <td>&nbsp;</td>

                    </tr>

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



      </table></td>

    </tr>

  </table>

</div>

<?

$main_content=ob_get_contents();

ob_end_clean();

include ("../../template/main_layout_index.php");

?>