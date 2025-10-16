<?
//---------------------------------------------------------------------------
//--------------------------This code for ss login apps----------------------
//---------------------------------------------------------------------------
function check_for_login_apps($cid,$uid,$passward,$type){

if($type==1){
require_once('../../../engine/tools/my.php');
require_once('../../../engine/configure/db_connect_acc_main.php');}
if($type==0){
require_once('../../engine/tools/my.php');
require_once('../../engine/configure/db_connect_acc_main.php');}
if($type==2){
require_once('../../../engine/tools/my.php');
require_once('../../../engine/configure/db_connect_acc_main.php');}


$sql="SELECT b.db_user,b.db_pass,b.db_name,a.cid,a.id FROM company_info a,database_info b WHERE a.cid='$cid' and a.id=b.company_id and a.status='ON' and register_date>'".date('Y-m-d')."' limit 1";
	$sql=@mysqli_query($con,$sql);
	if($proj=@mysqli_fetch_object($sql))
	{
					$_SESSION['proj_id']	= $proj->cid;
					$_SESSION['db_name']	= $proj->db_name;
					$_SESSION['db_user']	= $proj->db_user;
					$_SESSION['db_pass']	= $proj->db_pass;
					
if($type==1)
require_once('../../../engine/configure/db_connect.php');
if($type==0)
require_once('../../engine/configure/db_connect.php');
if($type==2)
require_once('../../../engine/configure/db_connect.php');
		
$user_sql="select * from ss_user where  username='$uid' AND password = '$passward'";
				$user_query=db_query($user_sql);
				if(mysqli_num_rows($user_query)>0)
				{
				$proj_sql="select * from project_info limit 1";
				$proj=@mysqli_fetch_object(db_query($proj_sql));
				$info=@mysqli_fetch_row($user_query);

                    //$_SESSION['user']['qr_code'] = $qr_code = rand(111111,999999);
                    //db_query($conn, "update user_activity_management set qr_code='".$qr_code."' where id='".$info[0]."'");
                    
					$_SESSION['user']['level']	= $info[3];
					$_SESSION['user']['id']	= $info[0];
					$_SESSION['user']['fname']	= $info[4];
					$_SESSION['user']['dealer']	= $info[11];
					$_SESSION['user']['group']	= $info[10];
					$_SESSION['user']['product_group']	= $info[12];
					$_SESSION['user']['region_id']	= $info[13];
					$_SESSION['user']['zone_id']	= $info[14];
					$_SESSION['user']['area_id']	= $info[15];
					
					
//$_SESSION['user']['acc_depot']	= find_a_field('warehouse','acc_code','warehouse_id='.$_SESSION['user']['depot']);
//$_SESSION['user']['group_name']	= find_a_field('warehouse','warehouse_name',"warehouse_id=".$_SESSION['user']['depot']);

					$_SESSION['mhafuz']='Active';
					$_SESSION['Authorized']='No';

					$_SESSION['company_name']=$_SESSION['proj_name']=$proj->proj_name;
					$_SESSION['company_address']=$proj->proj_address;
					$_SESSION['company_logo']='../../../logo/'.$_SESSION['proj_id'].'.jpg';

					return true;
				}
		}else return false;

}
?>