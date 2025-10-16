<?php session_start();
ob_start();


require_once "../../../engine/configure/default_values.php";
include('../../../engine/configure/db_connect_scb_main.php');

if(isset($_POST['ibssignin']))
{
	$passward = $_POST['pass'];
	$uid  = $_POST['uid'];
	$cid  = $_POST['cid'];

$sql="SELECT b.db_user,b.db_pass,b.db_name,a.cid,a.id FROM company_info a,database_info b WHERE a.cid='$cid' and a.id=b.company_id and a.status='ON' limit 1";
//echo $sql;
	$sql=@mysql_query($sql);
	if($proj=@mysql_fetch_object($sql))
	{

					$_SESSION['proj_id']	= $proj->cid;
					$_SESSION['db_name']	= $proj->db_name;
					$_SESSION['db_user']	= $proj->db_user;
					$_SESSION['db_pass']	= $proj->db_pass;
					
		require_once "../../../scb_mod/common/db_connect.php";
		
		$user_sql="select * from user_activity_management where  username='$uid' AND password = '$passward' and service_group=0";
				$user_query=mysql_query($user_sql);
				mysql_num_rows($user_query);
				if(mysql_num_rows($user_query)>0)
				{
				$proj_sql="select * from project_info limit 1";
				$proj=@mysql_fetch_object(mysql_query($proj_sql));
				$info=@mysql_fetch_row($user_query);
					$_SESSION['user']['level']	= $info[3];
					$_SESSION['user']['id']	= $info[0];
					$_SESSION['user']['fname']	= $info[4];
					
					$_SESSION['separator']='';
					$_SESSION['mhafuz']='Active';
					$_SESSION['voucher_type']=3;
					
						function find_all_fields($table,$field,$condition)
	{
echo 	$sql="select * from $table where $condition limit 1";
	$res=mysql_query($sql);
	$count=mysql_num_rows($res);
	
	if($count>0)
		{
		$data=@mysql_fetch_object($res);
		return $data;
		}
	else
		return NULL;
	}
					$_SESSION['user_info'] = find_all_fields('user_activity_management','','user_id='.$_SESSION['user']['id']);
					
					$_SESSION['company_name']=$_SESSION['proj_name']=$proj->proj_name;
					$_SESSION['company_address']=$proj->proj_address;
					$_SESSION['company_logo']='../images/'.$_SESSION['proj_id'].'.jpg';
					
//add_user_activity_log($_SESSION['user']['id'],1,1,'Login Page','Successfully Logged In',$_SESSION['user']['level']);
					header("Location:home.php");
				}
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
                      <td>Company ID  : </td>
                      <td><input name="cid" type="text" class="input" id="cid" size="15" /></td>
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
        <tr>
          <td><div align="center"><a href="../main/index_service.php"><img src="../../images/images1.jpg" width="100" height="100" /></a></div></td>
        </tr>
        <tr>
          <td><div align="center"><a href="../main/index_owner.php"><img src="../../images/images5.jpg" width="100" height="100"  /> </a></div></td>
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