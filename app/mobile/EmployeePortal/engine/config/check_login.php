<?	

function check_for_login($cid,$uid,$passw,$type){

require_once(SERVER_CORE.'core/init_master.php');

$sql = "SELECT b.db_user, b.db_pass, b.db_name, a.cid, a.id, a.company_name, a.address FROM company_info a, database_info b WHERE a.cid=? and a.id=b.company_id and a.status='ON' and register_date > ? limit 1";
    
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "ss", $cid, date('Y-m-d'));
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $db_user, $db_pass, $db_name, $c_id, $id, $company_name, $address);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
if ($id>0) {




        $_SESSION['proj_id'] = $c_id;
        $_SESSION['db_name'] = $db_name;
        $_SESSION['db_user'] = $db_user;
        $_SESSION['db_pass'] = $db_pass;
					
					

require_once(SERVER_CORE.'core/init_live.php');



$today = date('Y-m-d');

$user_sql = "select * from user_activity_management where  username=? and expire_date >= ?";
$user_stmt = mysqli_prepare($conn, $user_sql);
mysqli_stmt_bind_param($user_stmt, "ss", $uid, $today);
mysqli_stmt_execute($user_stmt);
mysqli_stmt_bind_result($user_stmt, $user_id, $username, $password, $level, $fname, $address, $email, $mobile, $designation, $department, $entry_date, $expire_date, $status, $group_for, $warehouse_id, $cc_code, $region_id, $zone_id, $area_id, $file, $qr_code, $qr_code_date, $PBI_ID, $user_pic, $master_user, $user_type, $sfa_user, $default_checker, $dealer_code, $vendor_code, $pass_change, $entry_by, $entry_at,$doj,$dob,$route,$token,$otp_verified);

mysqli_stmt_fetch($user_stmt);
mysqli_stmt_close($user_stmt);

if($password === $passw) {



				
					$_SESSION['user']['level']		= $level;

					$_SESSION['user']['id']			= $user_id;

					$_SESSION['user']['fname']		= $fname;

					$_SESSION['user']['designation']= $designation;

					$_SESSION['user']['depot']		= $warehouse_id;

					$_SESSION['user']['group']		= $group_for;

					$_SESSION['user']['username']	= $uid;
										echo "<script>
					sessionStorage.setItem('username', '$user_id');
					sessionStorage.setItem('password', '$passward');
					window.location.href = '../main/home.php';
				</script>";
					
					$module_id=0;
                    $page_id=0;
					$tr_no=0;
					$tr_id=0;
					$tr_type='Show';
					$execution_time='0.00';

					$_SESSION['mhafuz']    ='Active';



				



					$_SESSION['company_name']=$_SESSION['proj_name']=find_a_field('user_group','group_name','id='.$info->group_for);

					$_SESSION['company_address']=$proj->address;

					 $_SESSION['user']['access_id']	= activity_log($module_id,$page_id,$page_name,$tr_from,$tr_no,$tr_id,$tr_type,$execution_time,$access_date);



					return true;

				
            }else{ return false;}

		}else {return false;}



}


function check_for_login_vendor($cid,$uid,$passw,$type){

require_once(SERVER_CORE.'core/init_master.php');

$sqls = "SELECT b.db_user, b.db_pass, b.db_name, a.cid, a.id, a.company_name, a.address FROM company_info a, database_info b WHERE a.cid=? and a.id=b.company_id and a.status='ON' and register_date > ? limit 1";
    
$stmt = mysqli_prepare($con, $sqls);
mysqli_stmt_bind_param($stmt, "ss", $cid, date('Y-m-d'));
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $db_user, $db_pass, $db_name, $c_id, $id, $company_name, $address);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
if ($id>0) {




        $_SESSION['proj_id'] = $c_id;
        $_SESSION['db_name'] = $db_name;
        $_SESSION['db_user'] = $db_user;
        $_SESSION['db_pass'] = $db_pass;
					
					



require_once(SERVER_CORE.'core/init_live.php');

$vendor_sql = "select * from vendor where email=?";
$vendor_stmt = mysqli_prepare($conn, $vendor_sql);
mysqli_stmt_bind_param($vendor_stmt, "s", $uid);
mysqli_stmt_execute($vendor_stmt);
mysqli_stmt_store_result($vendor_stmt);
if(mysqli_stmt_num_rows($vendor_stmt) > 0) {
	mysqli_stmt_bind_result($vendor_stmt, 
    $vendor_id , $ledger_group, $ledger_id, $group_for, 
    $vendor_name, $vendor_category, $vendor_company, 
    $beneficiary_name, $beneficiary_bank, $beneficiary_bank_ac, 
    $iban_no, $swift_code, $address, $contact_no, 
    $sms_mobile_no, $vendor_type, $fax_no, $email, 
    $cc_email, $country, $contact_person_name, 
    $contact_person_designation, $contact_person_mobile, 
    $status, $entry_at, $entry_by, $edit_at, 
    $edit_by, $proj_id, $tin, $trade, $bin, 
    $cheque, $sub_ledger_id, $language, $password, $pass_change
);

mysqli_stmt_fetch($vendor_stmt);
mysqli_stmt_close($vendor_stmt);

}else{
echo "";
}
if($password === $passw) {

				
					$_SESSION['user']['level'] = $level;

					$_SESSION['vendor']['id'] = $vendor_id;
					
					$_SESSION['user']['id'] = $vendor_id;

					$_SESSION['vendor']['fname'] = $vendor_name;

					$_SESSION['user']['group'] = $group_for;

					$_SESSION['user']['username'] = $email;
					

					
					$_SESSION['user']['fname']		= $vendor_name;

					$_SESSION['user']['designation']= '';


					
					$module_id=0;
                    $page_id=0;
					$tr_no=0;
					$tr_id=0;
					$tr_type='Show';
					$execution_time='0.00';

					$_SESSION['mhafuz']    = 'Active';


					$_SESSION['company_name']=$_SESSION['proj_name']=find_a_field('vendor','address','vendor_id='.$vendor_id);

					$_SESSION['vendor_address']=$address;

					// $_SESSION['user']['access_id']	= activity_log($module_id,$page_id,$page_name,$tr_from,$tr_no,$tr_id,$tr_type,$execution_time);



					return true;

				
            }else{ return false;}

		}else {return false;}



}

?>