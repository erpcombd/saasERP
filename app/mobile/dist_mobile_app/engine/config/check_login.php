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
mysqli_stmt_bind_result($user_stmt, $user_id, $username, $password, $level, $fname, $address, $email, $mobile, $designation, $department, $entry_date, $expire_date, $status, $group_for, $warehouse_id, $cc_code, $region_id, $zone_id, $area_id, $file, $qr_code, $qr_code_date, $PBI_ID, $user_pic, $master_user, $user_type, $default_checker, $dealer_code, $vendor_code, $pass_change, $entry_by, $entry_at);

mysqli_stmt_fetch($user_stmt);
mysqli_stmt_close($user_stmt);

if($password === $passw) {



				
					$_SESSION['user']['level']		= $level;

					$_SESSION['user']['id']			= $user_id;

					$_SESSION['user']['fname']		= $fname;

					$_SESSION['user']['designation']= $designation;
					
					$_SESSION['user']['company_id'] = $group_for;
					
					$_SESSION['user']['depot']		= $warehouse_id;

					$_SESSION['user']['group']		= $group_for;

					$_SESSION['user']['username']	= $uid;
					
					$module_id=0;
                    $page_id=0;
					$tr_no=0;
					$tr_id=0;
					$tr_type='Show';
					$execution_time='0.00';

					$_SESSION['mhafuz']    ='Active';



				



					$_SESSION['company_name']=$_SESSION['proj_name']=find_a_field('user_group','group_name','id='.$group_for);

					$_SESSION['company_address']=$proj->address;

					 $_SESSION['user']['access_id']	= activity_log($module_id,$page_id,$page_name,$tr_from,$tr_no,$tr_id,$tr_type,$execution_time,$access_date);



					return true;

				
            }else{ return false;}

		}else {return false;}



}















//---------------------------------------------------------------------------
//--------------------------This code for ss login nfr apps----------------------
//---------------------------------------------------------------------------
function check_for_login_apps_nfr($cid,$uid,$passw,$type){
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
$user_sql = "select * from ss_user where  username=? and expire_date >= ?";
$user_stmt = mysqli_prepare($conn, $user_sql);
mysqli_stmt_bind_param($user_stmt, "ss", $uid, $today);
mysqli_stmt_execute($user_stmt);
mysqli_stmt_bind_result($user_stmt, $user_id, $username, $password, $level, $fname, $address, $email, $mobile, $designation, $status, $group_for, $dealer_code, $product_group, $region_id, $zone_id, $area_id, $entry_at, $edit_at, $last_login, $last_recovery, $app_level, $target_visit, $geo_lock,$geo_lock_meter,$fg_type,$PBI_GROUP,$expire_date);

mysqli_stmt_fetch($user_stmt);
mysqli_stmt_close($user_stmt);


if($password === $passw) {
					$_SESSION['user']['level']			= $level;
					$_SESSION['user']['id']				= $user_id;
					$_SESSION['user']['username']		= $username;
					$_SESSION['user']['fname']			= $fname;
					$_SESSION['user']['designation']	= $designation;
					$_SESSION['user']['dealer']			= $dealer_code;
					$_SESSION['user']['group']			= $group_for;
					$_SESSION['user']['product_group']	= $product_group;
					$_SESSION['user']['region_id']		= $region_id;
					$_SESSION['user']['zone_id']		= $zone_id;
					$_SESSION['user']['area_id']		= $area_id;	
					$_SESSION['user']['warehouse_id']	= $dealer_code;				
					
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


//---------------------------------------------------------------------------
//--------------------- This code for ss login apps Nfr end----------------------
//---------------------------------------------------------------------------




//---------------------------------------------------------------------------
//--------------------------This code for ss login apps----------------------
//---------------------------------------------------------------------------
function check_for_login_apps($cid,$uid,$passw,$type){
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
$user_sql = "select * from ss_user where  username=? and expire_date >= ?";
$user_stmt = mysqli_prepare($conn, $user_sql);
mysqli_stmt_bind_param($user_stmt, "ss", $uid, $today);
mysqli_stmt_execute($user_stmt);
mysqli_stmt_bind_result($user_stmt, $user_id, $username, $password, $level, $fname, $address, $email, $mobile, $designation, $status, $group_for, $dealer_code, $product_group, $region_id, $zone_id, $area_id, $point_id, $entry_at, $edit_at, $last_login, $last_recovery, $app_level, $target_visit,$expire_date);

mysqli_stmt_fetch($user_stmt);
mysqli_stmt_close($user_stmt);


if($password === $passw) {
					$_SESSION['user']['level']		= $level;
					$_SESSION['user']['id']			= $user_id;
					$_SESSION['user']['username']	= $username;
					$_SESSION['user']['fname']		= $fname;
					$_SESSION['user']['designation']= $designation;
					$_SESSION['user']['dealer']	= $dealer_code;
					$_SESSION['user']['group']	= $group_for;
					$_SESSION['user']['product_group']	= $product_group;
					$_SESSION['user']['region_id']	= $region_id;
					$_SESSION['user']['zone_id']	= $zone_id;
					$_SESSION['user']['area_id']	= $area_id;	
					$_SESSION['user']['warehouse_id']	= $dealer_code;				
					
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


//---------------------------------------------------------------------------
//--------------------- This code for ss login apps end----------------------
//---------------------------------------------------------------------------





//---------------------------------------------------------------------------
//------------- This code for distributor login apps Start ------------------
//---------------------------------------------------------------------------

function check_for_login_dealer($cid,$uid,$passw,$type){
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

$dealer_sql = "select * from dealer_info where dealer_code2=?";
$dealer_stmt = mysqli_prepare($conn, $dealer_sql);
mysqli_stmt_bind_param($dealer_stmt, "s", $uid);
mysqli_stmt_execute($dealer_stmt);
mysqli_stmt_store_result($dealer_stmt);

//if(mysqli_stmt_num_rows($dealer_stmt) > 0) {
//mysqli_stmt_bind_result($dealer_stmt, $dealer_code, $dealer_code2, $ledger_group, $account_code, $account_code2, $dealer_type, $dealer_nature, $region_id, $zone_id, 
//$area_code, $range, $product_group, $mobile_no, $tel_no, $division_code, $district_code, $thana_code, $security_deposit, $app_date, $app_type, $dealer_name_e,$propritor_name_e, $dealer_outlet_name, $address_e, $dealer_name_b, $propritor_name_b, $address_b, $email, $cc_email, $national_id, $passport_no, $credit_limit,$monthly_credit_limit,$credit_limit_bypass_date, 
//$canceled1, $cancel_date, $app_letter_issued, $depot, $contact_person_name, $contact_person_designation, $contact_person_mobile, $rickshaw_van, $motor_van, $tempoo, $boat, $pp, $np, $sp, $sa, $sn, $entry_by, $entry_at, $edit_by, $edit_at, $group_for, $add_lat, $add_lon, $bin, $nid, $tin, $trade_licence, $status, $order_status, $chalan_status, $sec_chalan_status, $lock_notification, $dealer_focode, $cor_team, $cor_company_group, $sub_ledger_id, $final_account_code, $sales_ledger, $updated, 
//$updated_at, $updated_by, $password, $sent_status, $return_code);

if(mysqli_stmt_num_rows($dealer_stmt) > 0) {
mysqli_stmt_bind_result($dealer_stmt, $dealer_code, $dealer_code2, $ledger_group, $account_code, $group_for, $dealer_type, $area_code, $zone_code, $region_code, $vat_type, $vat_no, $contact_no, $sms_mobile_no, $fax_no, $cc_email, $email, $cr_no, $cr_upload, $division_code, $district_code, $thana_code, $security_deposit, $app_date, $app_type, $dealer_name_e, $location, $propritor_name_e, $address_e, $status, $dealer_name_b, $propritor_name_b, $address_b, $national_id, $passport_no, $credit_limit, $canceled, $cancel_date, $depot, $contact_person_name, $contact_person_designation, $contact_person_mobile, $pp, $np, $sp, $sa, $sn, $entry_by, $entry_at, $edit_by, $edit_at, $add_lat, $add_lon, $product_group, $service_charge, $credit_limit_appli, $bank_reconsila, $tin, $trade, $bin, $cheque, $sub_ledger_id, $password);

mysqli_stmt_fetch($dealer_stmt);
mysqli_stmt_close($dealer_stmt);
}else{
echo "";
}
if($password === $passw) {
					$_SESSION['user']['id'] 		= $dealer_code;
					$_SESSION['user']['username'] 	= $dealer_code2;
					$_SESSION['user']['fname'] 		= $dealer_name_e;
					$_SESSION['user']['address'] 	= $address_e;
					$_SESSION['user']['group'] 		= $group_for;
					$_SESSION['user']['type']		= $dealer_type;
					$_SESSION['user']['depot'] 		= $depot;
					$_SESSION['user']['region_id'] 	= $region_id;
					$_SESSION['user']['zone_id'] 	= $zone_id;
					$_SESSION['user']['area_id'] 	= $area_code;

					$module_id	=0;
                    $page_id	=0;
					$tr_no		=0;
					$tr_id		=0;
					$tr_type	='Show';
					$execution_time='0.00';

					$_SESSION['mhafuz']    		= 'Active';
					$_SESSION['company_name']	= $_SESSION['proj_name']=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code);
					$_SESSION['dealer_address']	= $address_e;
					//$_SESSION['user']['access_id'] = activity_log($module_id,$page_id,$page_name,$tr_from,$tr_no,$tr_id,$tr_type,$execution_time);
					
					return true;
            }else{ return false;}

		}else {return false;}
}

//---------------------------------------------------------------------------
//------------- This code for distributor login apps end---------------------
//---------------------------------------------------------------------------

















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
mysqli_stmt_bind_result($vendor_stmt, $vendor_id , $ledger_group, $ledger_id, $group_for,$vendor_name, $vendor_category,$vendor_company,$beneficiary_name, $beneficiary_bank, $beneficiary_bank_ac, $iban_no, $swift_code, $address, $contact_no, $sms_mobile_no, $vendor_type, $fax_no, $email, $cc_email, $country, $contact_person_name, $contact_person_designation, $contact_person_mobile, $status, $entry_at, $entry_by, $edit_at, $edit_by, $proj_id, $tin, $trade, $bin, $cheque, $language, $password, $pass_change);

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

					$_SESSION['user']['access_id']	= activity_log($module_id,$page_id,$page_name,$tr_from,$tr_no,$tr_id,$tr_type,$execution_time);



					return true;

				
            }else{ return false;}

		}else {return false;}



}

?>