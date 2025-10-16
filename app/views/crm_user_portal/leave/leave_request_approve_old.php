<?php
@//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Leave Application Form';			// Page Name and Page Title
$page="leave_request_input.php";		// PHP File Name

$root='leave';

$table='hrm_leave_info';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='type';				// For a New or Edit Data a must have data field

$g_s_date=date('Y-01-01');
$g_e_date=date('Y-12-31');

do_calander('#leave_apply_date');
 

$unique_name = md5(uniqid(rand(), true));	

// ::::: End Edit Section :::::


// ::::: End Edit Section :::::

  

$crud      =new crud($table);

if(isset($_GET[$unique]))
$$unique = $_GET[$unique];
else
$$unique = $_POST[$unique];




 $max_id = find_a_field('hrm_leave_info','max(id)','1');
 $max_id = $max_id+1;

$PBI = find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);
$essentialInfo = find_all_field('essential_info','','PBI_ID='.$_SESSION['employee_selected']);
$leave_status = find_a_field('hrm_leave_info','leave_status','id='.$_REQUEST['id']);
$incharge_status = find_a_field('hrm_leave_info','incharge_status','id='.$_REQUEST['id']);

$leave_name = find_a_field('hrm_leave_type','leave_type_name','id='.$_POST['type']);

$leave_id = find_all_field('hrm_leave_info','','id='.$_REQUEST['id']);

$imp_info = find_all_field('personnel_basic_info','','PBI_ID='.$leave_id->PBI_ID);


$_REQUEST['s_date']= date('Y-m-d',strtotime($_REQUEST['s_date']));
$_REQUEST['e_date']= date('Y-m-d',strtotime($_REQUEST['e_date']));

$user_leave_rull = find_all_field('hrm_leave_rull_manage','','id='.$PBI->LEAVE_RULE_ID);


if($leave_id>0){
$leave_d = find_all_field('personnel_basic_info','','PBI_ID='.$leave_id->PBI_ID);
$interval = date_diff(date_create(date('Y-m-d')), date_create($leave_d->PBI_DOJ));
	
		 $interval->format("%Y Year, %M Months, %d Days");
		 $total_service_days = $interval->format('%a');
		 }else{
		   
$interval = date_diff(date_create(date('Y-m-d')), date_create($PBI->PBI_DOJ));
	
		 $interval->format("%Y Year, %M Months, %d Days");
		 $total_service_days = $interval->format('%a');
		 
		 }


 $my_leave=mysqli_fetch_object(db_query("select * from hrm_leave_info where PBI_ID='".$_SESSION['employee_selected']."' and s_date='".$_REQUEST['s_date']."' and e_date='".$_REQUEST['e_date']."'"));




$prev_lv=mysqli_num_rows(db_query("select * from hrm_leave_info where incharge_status='Approve' and leave_status='Granted' and PBI_ID='".$_SESSION['employee_selected']."' and s_date between '".$_REQUEST['s_date']."' and '".$_REQUEST['e_date']."'"));

$join_leave = mysqli_num_rows(db_query("select * from hrm_leave_info where PBI_ID='".$_SESSION['employee_selected']."' and s_date='".$_REQUEST['s_date']."' and e_date='".$_REQUEST['e_date']."'"));

  $leave_days_casual = find_a_field('hrm_leave_info','sum(total_days)','type=1 and  PBI_ID="'.$_SESSION['employee_selected'].'" and   s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'" and incharge_status not in ("Not Approve") ');
  
    $leave_days_sick = find_a_field('hrm_leave_info','sum(total_days)','type=2 and  PBI_ID="'.$_SESSION['employee_selected'].'" and   s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"  and incharge_status not in ("Not Approve")  ');
   
    $leave_days_annual = find_a_field('hrm_leave_info','sum(total_days)','type=3 and  PBI_ID="'.$_SESSION['employee_selected'].'" and   s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'" and incharge_status not in ("Not Approve")  ');
	
	$leave_days_marriage = find_a_field('hrm_leave_info','sum(total_days)','type=4 and  PBI_ID="'.$_SESSION['employee_selected'].'" and   s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"  and incharge_status not in ("Not Approve")  ');
	
	$leave_days_paternity = find_a_field('hrm_leave_info','sum(total_days)','type=6 and  PBI_ID="'.$_SESSION['employee_selected'].'" and   s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"  and incharge_status not in ("Not Approve")  ');
	
	$leave_days_hajj = find_a_field('hrm_leave_info','sum(total_days)','type=7 and  PBI_ID="'.$_SESSION['employee_selected'].'" and   s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"  and incharge_status not in ("Not Approve")  ');
	
	$leave_days_maternity = find_a_field('hrm_leave_info','sum(total_days)','type=5 and  PBI_ID="'.$_SESSION['employee_selected'].'" and   s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"  and incharge_status not in ("Not Approve")  ');

 //$leave_days_casual=mysqli_num_rows(db_query("select sum(total_days) from hrm_leave_info where  type='1' and  PBI_ID='".$_SESSION['employee_selected']."' and  s_date>='".$g_s_date."' and e_date<='".$g_e_date."' "));

 //$leave_days_sick=mysqli_num_rows(db_query("select sum(total_days) from hrm_leave_info where type='2' and  PBI_ID='".$_SESSION['employee_selected']."' and  s_date>='".$g_s_date."' and e_date<='".$g_e_date."' "));

//$leave_days_annual=mysqli_num_rows(db_query("select sum(total_days) from hrm_leave_info where type='3' and  PBI_ID='".$_SESSION['employee_selected']."' and  s_date>='".$g_s_date."' and e_date<='".$g_e_date."' "));

 $casual_last_date = find_a_field('hrm_leave_info','leave_join_date','type=1  and PBI_ID="'.$_SESSION['employee_selected'].'" and incharge_status not in ("Not Approve")  order by id desc ');
 $sick_last_date = find_a_field('hrm_leave_info','leave_join_date','type=2  and PBI_ID="'.$_SESSION['employee_selected'].'" and incharge_status not in ("Not Approve")  order by id desc ');
$marriage_last_date = find_a_field('hrm_leave_info','leave_join_date','type=4  and PBI_ID="'.$_SESSION['employee_selected'].'" and incharge_status not in ("Not Approve")  order by id desc ');
$annual_last_date = find_a_field('hrm_leave_info','leave_join_date','type=3  and PBI_ID="'.$_SESSION['employee_selected'].'" and incharge_status not in ("Not Approve")  order by id desc ');
$paternity_last_date = find_a_field('hrm_leave_info','leave_join_date','type=6  and PBI_ID="'.$_SESSION['employee_selected'].'" and incharge_status not in ("Not Approve")  order by id desc ');

$today_date = date('Y-m-d');


//echo $user_leave_rull->MED. ' OK '.$_POST['type']. ' lv '.$leave_days_sick;

			  
				  if(isset($_POST['insert']))
{



if($prev_lv>0){
$msggg= "<h2 style='color:#FF0000'>You Can't Add Same Leave Twice</h2>";
}

elseif(($_POST['type'] !=2) && ($_POST['s_date']) < $today_date){
$msggg= "<h2 style='color:#FF0000'>You Can't Apply Back Dated Leave<br> </h2>";
}
elseif(($_POST['type']==1) && ($_POST['total_days'])>8){
$msggg= "<h2 style='color:#FF0000'>Casual Leave (CL) will not take more than 8 days<br> (৮ দিনের বেশি Casual Leave (CL)  অনুমতি প্রাপ্ত না) </h2>";
}
elseif(($_POST['type']==1) && (($leave_days_casual+$_POST['total_days'])> 8)){
$msggg= "<h2 style='color:#FF0000'>Your Casual Leave (CL) already completed <br> (আপনার Casual Leave (CL)  সম্পূর্ণ হয়েছে) </h2>";
}
elseif( ($_POST['type']==1) && $essentialInfo->EMPLOYMENT_TYPE !='Permanent'){
$msggg="<h2 style='color:#FF0000'>You are not authorized for Casual Leave (CL) 
<br> (আপনি Casual Leave (CL)  এর জন্য অনুমতি প্রাপ্ত না) </h2>";
}
elseif( ($_POST['type']==1) && ($_POST['total_days'])>3){
$msggg="<h2 style='color:#FF0000'>Casual Leave (CL) will not take more than 3 days<br> (৩ দিনের বেশি Casual Leave (CL)  অনুমতি প্রাপ্ত না) </h2>";
}
elseif( ($_POST['type']==1) && $annual_last_date == $_REQUEST['s_date']){
$msggg="<h2 style='color:#FF0000'>Casual Leave cannot be joined with Annual Leave(AL) <br> Casual Leave(CL) এবং Annual Leave(AL) একসাথে নেওয়া যাবে না।
 </h2>";
}
elseif( ($_POST['type']==1) && $sick_last_date  == $_REQUEST['s_date']){
$msggg="<h2 style='color:#FF0000'>Sick Leave(SL) cannot be joined with Casual Leave(CL) <br> Sick Leave(SL) এবং Casual Leave(CL) একসাথে নেওয়া যাবে না।
 </h2>";
}

elseif( ($_POST['type']==1) && $paternity_last_date  == $_REQUEST['s_date']){
$msggg="<h2 style='color:#FF0000'>Casual Leave (CL) cannot be joined with Paternity Leave <br> Casual Leave (CL) এবং Paternity Leave একসাথে নেওয়া যাবে না।
 </h2>";
}
elseif( ($_POST['type']==1) && $casual_last_date  == $_REQUEST['s_date']){
$msggg="<h2 style='color:#FF0000'>Casual Leave (CL) will not take more than 3 days<br> (৩ দিনের বেশি Casual Leave (CL)  অনুমতি প্রাপ্ত না) </h2>";
}






elseif(($_POST['type']==2) && ($_POST['total_days'])>8){
$msggg= "<h2 style='color:#FF0000'>Sick Leave (SL) will not take more than 8 days<br> (৮ দিনের বেশি Sick Leave (SL)  অনুমতি প্রাপ্ত না) </h2>";
}
elseif(($_POST['type']==2) && (($leave_days_sick+$_POST['total_days'])>8)){
$msggg= "<h2 style='color:#FF0000'>Your Sick Leave (SL) already completed
<br> (আপনার Sick Leave (SL) সম্পূর্ণ হয়েছে)</h2>";
}
elseif( ($_POST['type']==2) && $essentialInfo->EMPLOYMENT_TYPE !='Permanent'){
$msggg="<h2 style='color:#FF0000'>You are not authorized for Sick Leave (SL) <br> (আপনি Sick Leave (SL) এর জন্য অনুমতি প্রাপ্ত না) </h2>";
}
elseif( ($_POST['type']==2)  && ($_POST['total_days'])>2 && $_FILES['att_file']['size'] == 0 && $_FILES['att_file']['error'] == 0){
$msggg="<h2 style='color:#FF0000'>Medical Certificate is required more than 2 days of sickness
<br> (২ দিনের অতিরিক্ত অসুস্থ থাকলে প্রেসক্রিপশন সংযুক্ত করুন)</h2>";
}





elseif(($_POST['type']==3) && ($_POST['total_days'])>14){
$msggg= "<h2 style='color:#FF0000'>Annual Leave (AL) will not take more than 8 days<br> (৮ দিনের বেশি Annual Leave (AL)  অনুমতি প্রাপ্ত না) </h2>";
}
elseif(($_POST['type']==3) && (($leave_days_annual+$_POST['total_days'])> 14)){
$msggg= "<h2 style='color:#FF0000'>Your Annual Leave (AL) already completed
 <br> (আপনার Annual Leave (AL) সম্পূর্ণ হয়েছে)</h2>";
}
elseif( ($_POST['type']==3) && $essentialInfo->EMPLOYMENT_TYPE !='Permanent'){
$msggg="<h2 style='color:#FF0000'>You are not authorized for Annual Leave (AL) 
<br> (আপনি Annual Leave (AL) এর জন্য অনুমতি প্রাপ্ত না) </h2>";
}
elseif( ($_POST['type']==3) && ($_POST['total_days'])>5){
$msggg="<h2 style='color:#FF0000'>Annual Leave (AL) will not take more than 5 days.
<br> (৫ দিনের অতিরিক্ত Annual Leave (AL) অনুমতি প্রাপ্ত না) </h2>";
}
elseif( ($_POST['type']==3) && $casual_last_date == $_REQUEST['s_date']){
$msggg="<h2 style='color:#FF0000'>Annual Leave(AL) cannot be joined with Casual Leave(CL)  <br> Annual Leave(AL) এবং  Casual Leave(CL) একসাথে নেওয়া যাবে না।
 </h2>";
}
elseif( ($_POST['type']==3) && $sick_last_date  == $_REQUEST['s_date']){
$msggg="<h2 style='color:#FF0000'>Annual Leave(AL) cannot be joined with Sick Leave(SL) <br> Sick Leave(SL) এবং Annual Leave(AL) একসাথে নেওয়া যাবে না।
 </h2>";
}
elseif( ($_POST['type']==3) && $paternity_last_date  == $_REQUEST['s_date']){
$msggg="<h2 style='color:#FF0000'>Annual Leave(AL) cannot be joined with Paternity Leave <br> Annual Leave(AL) এবং Paternity Leave একসাথে নেওয়া যাবে না।
 </h2>";
}
elseif( ($_POST['type']==3) && $annual_last_date  == $_REQUEST['s_date']){
$msggg="<h2 style='color:#FF0000'>Annual Leave(AL) cannot be joined with Annual Leave(AL) <br> Annual Leave(AL) এবং Annual Leave(AL) একসাথে নেওয়া যাবে না।
 </h2>";
}



elseif( ($_POST['type']==4) && ($_POST['total_days'])>5){
$msggg="<h2 style='color:#FF0000'>Marriage Leave will not take more than 5 days.
<br> (৫ দিনের অতিরিক্ত Marriage Leave অনুমতি প্রাপ্ত না) </h2>";
}
elseif( ($_POST['type']==4) && $casual_last_date == $_REQUEST['s_date']){
$msggg="<h2 style='color:#FF0000'>Marriage Leave cannot be joined with Casual Leave <br> Marriage Leave এবং Casual Leave(CL) একসাথে নেওয়া যাবে না।
 </h2>";
}
elseif( ($_POST['type']==4) && $annual_last_date == $_REQUEST['s_date']){
$msggg="<h2 style='color:#FF0000'>Marriage Leave cannot be joined with Annual Leave(AL) <br> Marriage Leave এবং Annual Leave(AL) একসাথে নেওয়া যাবে না।
 </h2>";
}
elseif(($_POST['type']==4) && (($leave_days_marriage+$_POST['total_days'])> 5)){
$msggg= "<h2 style='color:#FF0000'>Your Marriage Leave already completed
 <br> (আপনার Marriage Leave সম্পূর্ণ হয়েছে)</h2>";
}


elseif( ($_POST['type']==6) && ($_POST['total_days'])>3){
$msggg="<h2 style='color:#FF0000'>Paternity Leave will not take more than 3 days.
<br> (৩ দিনের অতিরিক্ত Paternity Leave অনুমতি প্রাপ্ত না) </h2>";
}
elseif( ($_POST['type']==6) && $casual_last_date == $_REQUEST['s_date']){
$msggg="<h2 style='color:#FF0000'>Paternity Leave cannot be joined with Casual Leave <br> Paternity Leave এবং Casual Leave(CL) একসাথে নেওয়া যাবে না।
 </h2>";
}
elseif( ($_POST['type']==6) && $annual_last_date == $_REQUEST['s_date']){
$msggg="<h2 style='color:#FF0000'>Paternity Leave  cannot be joined with Annual Leave(AL) <br> Paternity Leave  এবং Annual Leave(AL) একসাথে নেওয়া যাবে না।
 </h2>";
}
elseif(($_POST['type']==6) && (($leave_days_paternity+$_POST['total_days'])> 3)){
$msggg= "<h2 style='color:#FF0000'>Your Paternity Leave already completed
 <br> (আপনার Paternity Leave সম্পূর্ণ হয়েছে)</h2>";
}





elseif( ($_POST['type']==7) && $essentialInfo->EMPLOYMENT_TYPE !='Permanent'){
$msggg="<h2 style='color:#FF0000'>Hajj Leave will enjoy only for permanent employee.
<br> (শুধু মাত্র স্থায়ী কর্মী/কর্মকর্তা হজ্জ এর ছুটি উপভোগ করতে পারবেন ) </h2>";
}
elseif( ($_POST['type']==7) && ($_POST['total_days'])>10){
$msggg="<h2 style='color:#FF0000'>Hajj Leave will not take more than 10 days.
<br> (১০  দিনের অতিরিক্ত Hajj Leave অনুমতি প্রাপ্ত না) </h2>";
}
elseif(($_POST['type']==7) && (($leave_days_hajj+$_POST['total_days'])> 10)){
$msggg= "<h2 style='color:#FF0000'>Your Hajj Leave Leave already completed
 <br> (আপনার Hajj Leave সম্পূর্ণ হয়েছে)</h2>";
}



elseif( ($_POST['type']==5) && $essentialInfo->EMPLOYMENT_TYPE !='Permanent'){
$msggg="<h2 style='color:#FF0000'>You are not Authorized for Maternity Leave.
<br> (আপনি Maternity Leave এর জন্য অনুমতি প্রাপ্ত না) </h2>";
}
elseif( ($_POST['type']==5) && ($_POST['total_days'])>182){
$msggg="<h2 style='color:#FF0000'>Maternity Leave will not take more than 182 days.
<br> (১৮২ দিনের অতিরিক্ত Maternity Leave অনুমতি প্রাপ্ত না)</h2>";
}
elseif(($_POST['type']==5) && (($leave_days_maternity+$_POST['total_days'])> 182)){
$msggg= "<h2 style='color:#FF0000'>Your Maternity Leave Leave already completed
 <br> (আপনার Maternity Leave সম্পূর্ণ হয়েছে)</h2>";
}
elseif( ($_POST['type']==5) && $PBI->PBI_SEX !='Female'){
$msggg="<h2 style='color:#FF0000'>Maternity Leave Only Authorized for Female.
<br></h2>";
}


else{		
$now= time();
//$extention=explode('.',$_FILES['att_file']['name']);
//$extention=strtolower(end($extention));
//$target_dir = "picture/leave_files/";
//$target_file = $target_dir . $$unique.'.'.$extention;

$projectId = array(2,3,4,5);
//$_REQUEST['PBI_ID']=$_SESSION['employee_selected'];
$_REQUEST['PBI_IN_CHARGE'] = $essentialInfo->ESSENTIAL_REPORTING;

if(in_array($essentialInfo->ESSENTIAL_PROJECT, $projectId)){
$_REQUEST['PBI_DEPT_HEAD'] = 111659;}

$_REQUEST['leave_status'] = "Pending";

$_REQUEST['entry_at'] = date('Y-m-d H:i:s');
$_REQUEST['s_date']= date('Y-m-d',strtotime($_REQUEST['s_date']));
$_REQUEST['e_date']= date('Y-m-d',strtotime($_REQUEST['e_date']));
$_REQUEST['leave_join_date']= date('Y-m-d',strtotime($_REQUEST['leave_join_date']));

if($_FILES['att_file']['tmp_name']!=''){
			$file_name= $_FILES['att_file']['name'];
			$file_tmp= $_FILES['att_file']['tmp_name'];
			$ext=end(explode('.',$file_name));
			$path='../file/leave_file/';
			move_uploaded_file($file_tmp, $path.$max_id.'.'.$ext);
			}


$crud->insert();


//move_uploaded_file($_FILES["att_file"]["tmp_name"], '../../'.$target_file);

$type=1;
$msg='New Entry Successfully Inserted.';


unset($_POST);
unset($$unique);

$to = "tanvir@aksidcorp.com";
$subject = "New Leave Request Pending";
$txt = "Please Check New Leave Request.!";
$headers = "From: erp@aksidcorp.com" . "\r\n" .
"CC: bimol@erp.com.bd";

//mail($to,$subject,$txt,$headers);
echo '<script type="text/javascript">parent.parent.document.location.href = "../leave/view_leave.php?notify=12";</script>';

}
}

//for Modify..................................

if(isset($_POST['update']))
{

$extention=explode('.',$_FILES['att_file']['name']);
$extention=strtolower(end($extention));
$target_dir = "file/leave_file/";
$target_file = $target_dir . $$unique.'.'.$extention;

//$_REQUEST['PBI_ID']=$_SESSION['employee_selected'];
//$_REQUEST['leave_status'] = 'PENDING';
//$_REQUEST['leave_status_detail'] = 'Waiting for Replacement';
$_REQUEST['edit_at'] = date('Y-m-d H:i:s');
$_REQUEST['leave_from_date']= date('Y-m-d',strtotime($_REQUEST['leave_from_date']));
$_REQUEST['leave_to_date']= date('Y-m-d',strtotime($_REQUEST['leave_to_date']));
$_REQUEST['leave_join_date']= date('Y-m-d',strtotime($_REQUEST['leave_join_date']));

if($_FILES['att_file']['tmp']!=""){
$_REQUEST['att_file']= $target_file;}

		$crud->update($unique);
		
		move_uploaded_file($_FILES["att_file"]["tmp_name"], '../'.$target_file);
		
		$type=1;
		$msg='Successfully Updated.';
				echo '<script type="text/javascript">
parent.parent.document.location.href = "view_leave.php?notify=12";
</script>';
}
//for Delete..................................

if(isset($_POST['not_approve']))
{		unset($_REQUEST);
$_REQUEST['incharge_status'] = 'Not Approve';
$_REQUEST['leave_status'] = '';

$crud->update($unique);

echo '<script type="text/javascript">
parent.parent.document.location.href = "../leave/view_leave_incharge.php?notify=12";
</script>';

$type=1;
$msg='Successfully Deleted.';
}

if(isset($_POST['delete']))
{		$condition=$unique."=".$$unique;		$crud->delete($condition);
		unset($$unique);
		echo '<script type="text/javascript">
parent.parent.document.location.href = "view_leave_incharge.php?notify=12";
</script>';
		$type=1;
		$msg='Successfully Deleted.';
}

if(isset($_POST['reportingAuthority']))
{		
unset($_REQUEST);
$_REQUEST['leave_status'] = 'Pending';
$_REQUEST['incharge_status'] = 'Approve';
$_REQUEST['s_date'] = $_POST['s_date'];
$_REQUEST['e_date'] = $_POST['e_date'];
$_REQUEST['leave_join_date'] = $_POST['leave_join_date'];
$_REQUEST['total_days'] = $_POST['total_days'];
$crud->update($unique);

echo '<script type="text/javascript">
parent.parent.document.location.href = "../leave/view_leave_incharge.php?notify=12";
</script>';

$type=1;
$msg='Successfully Deleted.';
}

if(isset($_POST['granted']))
{		
unset($_REQUEST);
$_REQUEST['leave_status'] = 'GRANTED';
$_REQUEST['type'] = $_POST['type'];
$_REQUEST['s_date'] = $_POST['s_date'];
$_REQUEST['e_date'] = $_POST['e_date'];
$_REQUEST['leave_join_date'] = $_POST['leave_join_date'];
$_REQUEST['total_days'] = $_POST['total_days'];
$_REQUEST['reporting_note'] = $_POST['reporting_note'];

$crud->update($unique);




//Text Sms

function sms($dest_addr,$sms_text){
          
       
$url = "https://api.mobireach.com.bd/SendTextMessage?Username=aksid&Password=Akhr@2019&From=AKSID_HR";

$fields = array(
    'Username'      => "aksid",
    'Password'      => "Akhr@2019",
    'From'          => "AKSID HR",
    'To'            => $dest_addr,
    'Message'       => $sms_text
);

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, count($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));

//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);


}

            $recipients='88'.$imp_info->PBI_MOBILE.'';
			
			$massage  = "Your requested leave is granted\r\n";
			$massage.="Leave Type: ".find_a_field('hrm_leave_type','leave_type_name','id='.$_POST['type'])."\r\n";
			$massage.="Date: ".date('d-M-Y', strtotime($_POST['s_date']))." to ".date('d-M-Y', strtotime($_POST['e_date']))."\r\n";
			$massage.="Total Days: ".$_POST['total_days']."\r\n";
			

     
	      $sms_result=sms($recipients,$massage);
	
	
 //Text Sms



$to = $imp_info->PBI_EMAIL;
//$to = $reporting_mail;
$subject = "Leave Request Status";
$txt = "Your requested ".$leave_name." Granted";
$headers = "From: AKSID Human Resources<hr@aksidcorp.com>";
mail($to,$subject,$txt,$headers);

echo '<script type="text/javascript">
parent.parent.document.location.href = "../leave/view_leave_hrm.php?notify=12";
</script>';

$type=1;
$msg='Successfully Deleted.';
}

if(isset($_POST['notgranted']))
{		
unset($_REQUEST);
$_REQUEST['leave_status'] = 'Not Granted';
$_REQUEST['reporting_note'] = $_POST['reporting_note'];


$crud->update($unique);


//Text Sms

function sms($dest_addr,$sms_text){
          
       
$url = "https://api.mobireach.com.bd/SendTextMessage?Username=aksid&Password=Akhr@2019&From=AKSID_HR";

$fields = array(
    'Username'      => "aksid",
    'Password'      => "Akhr@2019",
    'From'          => "AKSID HR",
    'To'            => $dest_addr,
    'Message'       => $sms_text
);

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, count($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));

//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);


}

            $recipients='88'.$imp_info->PBI_MOBILE.'';
			
			$massage  = "Your requested ".find_a_field('hrm_leave_type','leave_type_name','id='.$_POST['type'])." is not Granted. \r\n";
			
			

     
	      $sms_result=sms($recipients,$massage);
	
	
 //Text Sms





//$to = $reporting_mail;
$to = $imp_info->PBI_EMAIL;
$subject = "Leave Request Status";
$txt = "Your requested ".$leave_name." Not Granted";
$headers = "From: AKSID Human Resources<hr@aksidcorp.com>";
mail($to,$subject,$txt,$headers);

echo '<script type="text/javascript">
parent.parent.document.location.href = "../leave/view_leave_hrm.php?notify=12";
</script>';

$type=1;
$msg='Successfully Deleted.';
}


if(isset($_POST['departmentHead']))
{		
unset($_REQUEST);
$_REQUEST['leave_status'] = 'Approve';
$crud->update($unique);

echo '<script type="text/javascript">
parent.parent.document.location.href = "../leave/view_leave_incharge.php?notify=12";
</script>';

$type=1;
$msg='Successfully Deleted.';
}

if(isset($_POST['hrapprove']))
{		
$_REQUEST['leave_status'] = 'Granted';
$crud->update($unique);

echo '<script type="text/javascript">
parent.parent.document.location.href = "../leave/view_leave_incharge.php?notify=12";
</script>';

$type=1;
$msg='Successfully Deleted.';
}

if(isset($$unique))
{+
$condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
foreach ($data as $key => $value)
{ $$key=$value;}
}
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);




if(isset($_POST['reportingAuthority']))
{
if($PBI_DEPT_HEAD>0)		
$_REQUEST['leave_status'] = 'Pending';
else
$_REQUEST['leave_status'] = 'Pending';

$crud->update($unique);

echo '<script type="text/javascript">
parent.parent.document.location.href = "../leave/view_leave_incharge.php?notify=12";
</script>';

$type=1;
$msg='Successfully Deleted.';
}

if(isset($_POST['departmentHead']))
{		
$_REQUEST['leave_status'] = 'Approve';
$crud->update($unique);

echo '<script type="text/javascript">
parent.parent.document.location.href = "../leave/view_leave_incharge.php?notify=12";
</script>';

$type=1;
$msg='Successfully Deleted.';
}


?>
<style type="text/css">
.MATERNITY_LEAVE{
display:none;
}

input[type="radio"], input[type="checkbox"] {
    line-height: normal;
    margin: 4px 0 0;
	width:20px;
}
.radio, .checkbox {
    min-height: 20px;
    padding-left: 20px;
}
.checkbox {
    margin-right: 4px !important;
}

.radio.inline, .checkbox.inline {
    display: inline-block;
    margin-bottom: 0;
    padding-top: 5px;
    vertical-align: middle;
}.radio.inline, .checkbox.inline {
    display: inline-block;
    margin-bottom: 0;
    padding-top: 5px;
    vertical-align: middle;
}
.radio.inline + .radio.inline, .checkbox.inline + .checkbox.inline {
    margin-left: 10px;
}
</style>
<script type="text/javascript">
$(document).ready(function(){

 $("#MATERNITY_LEAVE_LEVEL1").hide();
   $("#MATERNITY_LEAVE_INPUT1").hide();
 $('#leave_type').click(function(){
  var num =$("#leave_type").val();
   if(num=="MATERNITY"){
   $("#MATERNITY_LEAVE_LEVEL1").show();
   $("#MATERNITY_LEAVE_INPUT1").show();
    
   }
   else{
    $("#MATERNITY_LEAVE_LEVEL1").hide();
    $("#MATERNITY_LEAVE_INPUT1").hide();
     $("#materlan_count_level").hide();
   $("#materlan_count_input").hide();
   }
 });
 
 
  $('#MATERNITY_past').click(function(){
  var num =$("#MATERNITY_past").val();
   if(num=="yes"){
   $("#materlan_count_level").show();
   $("#materlan_count_input").show();
    
   }
   else{
    $("#materlan_count_level").hide();
   $("#materlan_count_input").hide();
   }
 });
 
  $("#materlan_count").change(function (){
    var materlan_count =  $("#materlan_count").val();
	
  if(materlan_count==2){
    alert("You are not Eligible for this Leave.");
	$('button[type="submit"]').attr('disabled','disabled');
  }else{
  $('button[type="submit"]').removeAttr('disabled');
  }
   
  });
   
  
    
    
  
});



 
</script>


<div class="right_col" role="main">   <!-- Must not delete it ,this is main design header-->
          <div class="">
		  
		  
           
        <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Plain Page</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
				  
				  	 <div class="openerp openerp_webclient_container">
                   
			
				  
				  
                  <div class="x_content">
				  
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
  <div class="oe_view_manager oe_view_manager_current">
    <? include('../../common/title_bar.php');?>
    <div class="oe_view_manager_body">
      <div  class="oe_view_manager_view_list"></div>
      <div class="oe_view_manager_view_form">
        <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
          <div class="oe_form_buttons"></div>
          <div class="oe_form_sidebar"></div>
          <div class="oe_form_pager"></div>
          <div class="oe_form_container">
            <div class="oe_form">
              <div class="">
                <div class="oe_form_sheetbg">
                  <div class="oe_form_sheet oe_form_sheet_width"> <span style=" text-align:center; font-size:12px;" ><?php echo $msggg; ?></span>

                    <table class="oe_form_group " border="0" cellpadding="0" cellspacing="0">
                      <tbody>
                        <tr class="oe_form_group_row">
                          <td colspan="1" class="oe_form_group_cell" width="100%"><table width="100%" border="0" cellpadding="2" cellspacing="0" class="oe_form_group ">
                              <tbody>
                                
                                <tr class="oe_form_group_row">
                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">
								  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                                    <input name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['user']['id']?>" type="hidden" />
									 <input name="mon" id="mon" value="<?=date('n')?>" type="hidden" />
									  <input name="year" id="year" value="<?=date('Y')?>" type="hidden" />
                                    &nbsp;&nbsp;Leave Types  :</td>
                                  	<? if($leave_id>0){
									  $leave_essential = find_all_field('essential_info','','PBI_ID='.$leave_id->PBI_ID);
									?>
                                  <td class="oe_form_group_cell" colspan="4"><select name="type" id="type" required>
								   <option value="<?=$type;?>"><?=find_a_field('hrm_leave_type','leave_type_name','id='.$type)?></option>
								   
								   <? 
								     if($leave_essential->EMPLOYMENT_TYPE !='Permanent'){
								   ?>
								       <option value="1" disabled="disabled">Casual Leave (CL)</option>
                                       <option value="2" disabled="disabled">Sick Leave (SL)</option>
									   <option  value="3" disabled="disabled">Annual Leave (AL)</option>
									   <option value="4">Marriage Leave (ML)</option>
									   <option value="5" disabled="disabled">Maternity Leave (MLV)</option>
									   <option value="6" disabled="disabled">Paternity Leave (PL)</option>
									   <option value="7" disabled="disabled">Hajj Leave</option>
									   <option value="8" >Extra Ordinary Leave (EOL)</option>
									   <option value="9">Leave Without Pay (LWP)</option>
									  <? }else {?>
									    <option value="1">Casual Leave (CL)</option>
                                       <option value="2">Sick Leave (SL)</option>
									  <? if($total_service_days>365 && $leave_essential->EMPLOYMENT_TYPE =='Permanent'){?>
									   <option  value="3" >Annual Leave (AL)</option>
									   <? }else{?>
									   <option  value="3" disabled="disabled">Annual Leave (AL)</option>
									   <? } ?>
									   <option value="4">Marriage Leave (ML)</option>
									   <? if($leave_d->PBI_SEX !='Female'){?>
									    <option value="6">Paternity Leave (PL)</option>
										<? } else{?>
									   <option value="5">Maternity Leave (MLV)</option>
									   
									   <? } ?>
									  
									   <option value="7">Hajj Leave</option>
									   <option value="8">Extra Ordinary Leave (EOL)</option>
									   <option value="9">Leave Without Pay (LWP)</option>
									  <? } ?>
                                     
                                    </select>                                  </td>
									<? } else{ ?>
									  <td class="oe_form_group_cell" colspan="4"><select name="type" id="type" required>
								   <option value="<?=$type;?>"><?=find_a_field('hrm_leave_type','leave_type_name','id='.$type)?></option>
								   
								   <? 
								     if($essentialInfo->EMPLOYMENT_TYPE !='Permanent'){
								   ?>
								       <option value="1" disabled="disabled">Casual Leave (CL)</option>
                                       <option value="2" disabled="disabled">Sick Leave (SL)</option>
									   <option  value="3" disabled="disabled">Annual Leave (AL)</option>
									   <option value="4">Marriage Leave (ML)</option>
									   <option value="5" disabled="disabled">Maternity Leave (MLV)</option>
									   <option value="6" disabled="disabled">Paternity Leave (PL)</option>
									   <option value="7" disabled="disabled">Hajj Leave</option>
									   <option value="8" >Extra Ordinary Leave (EOL)</option>
									   <option value="9">Leave Without Pay (LWP)</option>
									  <? }else {?>
									    <option value="1">Casual Leave (CL)</option>
                                       <option value="2">Sick Leave (SL)</option>
									  <? if($total_service_days>365 && $essentialInfo->EMPLOYMENT_TYPE =='Permanent'){?>
									   <option  value="3" >Annual Leave (AL)</option>
									   <? }else{?>
									   <option  value="3" disabled="disabled">Annual Leave (AL)</option>
									   <? } ?>
									   <option value="4">Marriage Leave (ML)</option>
									   <? if($PBI->PBI_SEX !='Female'){?>
									    <option value="6">Paternity Leave (PL)</option>
										<? } else{?>
									   <option value="5">Maternity Leave (MLV)</option>
									   
									   <? } ?>
									  
									   <option value="7">Hajj Leave</option>
									   <option value="8">Extra Ordinary Leave (EOL)</option>
									   <option value="9">Leave Without Pay (LWP)</option>
									  <? } ?>
                                     
                                    </select>                                  </td>
									<? } ?>
                                </tr>
                                <!--<tr class="oe_form_group_row">
                  <td  id="MATERNITY_LEAVE_LEVEL1" bgcolor="#fff" colspan="1" class="oe_form_group_cell oe_form_group_cell_label MATERNITY_LEAVE">&nbsp;&nbsp;আপনি কি আগে ছুটি ভোগ করেছেন? :</td>
                  <td id="MATERNITY_LEAVE_INPUT1" bgcolor="#fff" class="oe_form_group_cell MATERNITY_LEAVE">
				  <select onChange="MATERNITY_yes_check(this.value)" id="MATERNITY_past" name="MATERNITY_past">
                     <option value="" selected="selected">বাছাই করুন</option>
                          <option <?php if($MATERNITY_past=="yes") echo "selected"; ?> value="yes">হ্যা</option>
                             <option <?php if($MATERNITY_past=="no") echo "selected"; ?> value="no">না</option>
                         </select></td>
						    <td id="materlan_count_level" bgcolor="#fff" colspan="2" class="oe_form_group_cell oe_form_group_cell_label MATERNITY_LEAVE">&nbsp;&nbsp;কতবার ভোগ করেছেন? :</td>
                  <td id="materlan_count_input" bgcolor="#fff" class="oe_form_group_cell MATERNITY_LEAVE">
				  <select name="materlan_count" id="materlan_count">
                       <option value="" selected="selected">বাছাই করুন</option>
                       <option <?php if($materlan_count==1) echo "selected"; ?> value="1">১ বার</option>
                       <option <?php if($materlan_count==2) echo "selected"; ?> value="2">২ বার</option>
                       </select></td>
                  </tr>-->
                                
                                <!--<tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;সংযুক্তি :</td>
                  <td colspan="3" class="oe_form_group_cell"><input type="file" name="att_file" /></td>
                  </tr>-->
                                
                                <tr class="oe_form_group_row">
                                  <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Duration : </td>
                                  <td colspan="4" bgcolor="#E8E8E8" class="oe_form_group_cell"><table width="100%" border="0">
                                      <tr>
                                        <td width="1"><?php
					  do_calander('#s_date');
					  ?>                            
            
                        <input name="s_date" type="date" id="s_date"  value="<?php if($s_date=='') echo ''; else echo $s_date ; ?>"  /></td>
                                        <td width="80"><div align="center"><span class="oe_form_group_cell oe_form_group_cell_label">-to- </span></div></td>
                                        <td width="1"><span class="oe_form_group_cell oe_form_group_cell_label">
                                          <?
 do_calander('#e_date','-0','+30');
?>
                                          <input name="e_date" type="date" id="e_date"  value="<?php if($e_date=='') echo ''; else echo $e_date ; ?>"  onchange="getData2('leave_ajax.php', 'leave',document.getElementById('s_date').value,document.getElementById('e_date').value)" required/>
                                          </span></td>
                                        <td><input type="hidden" value="" name="total_days" id="total_days"/>
                                          &nbsp;&nbsp;<b id="total_leave"> 
                                          <span id="leave"><input type="text" value="<?=find_a_field('hrm_leave_info','total_days','id='.$$unique);?>" name="total_days" id="total_days" readonly="" style="width:10px; border:0px solid $ccc;"/></span>
                                          
                                        
										  
                                          </b></td>
                                      </tr>
                                    </table></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Reason :</td>
                                  <td class="oe_form_group_cell" colspan="4"><span class="oe_form_group_cell oe_form_group_cell_label">
                                    <textarea name="reason" style="width:500px;" required><?=$reason?></textarea>
                                  </span></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td colspan="" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Supporting Doc: </td>
                                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">
								  <table>
								  <tr>
								  <td>
								  <input type="file" name="att_file" id="att_file" /></td>
								     <td>
									 
									 <div  class="btn btn-primary btn-sm"  style="padding: 0px;width: 132px;margin-left: 5px;" >
									 <?
								     if($att_file != ''){
								   ?>
								   <a href="../file/leave_file/<?=$att_file?>" target="_blank" style="color:white;">&nbsp;&nbsp;View Attachment</a>
								   <? } ?>
								   </div>								   </td>
								   </tr>
								   </table>								  </td>
                                </tr>
								<tr class="oe_form_group_row">
                                  <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Submission Date: </td>
                                  <td colspan="4" bgcolor="#E8E8E8" class="oe_form_group_cell"><input type="date" name="leave_apply_date" id="leave_apply_date" value="<?=$leave_apply_date?>"  /></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Joining Date After Leave: </td>
                                  <td class="oe_form_group_cell" colspan="4"><script language="javascript">

$('#leave_to_date').change(function() {

     var from_leave = $("#leave_from_date").datepicker('getDate');
     var to_leave = $("#leave_to_date").datepicker('getDate');
    var days   = ((to_leave - from_leave)/1000/60/60/24)+1;

	

           $.ajax({
            success: function(response) {
           $( "#leave_join_date" ).datepicker({
			changeMonth: true,
			changeYear: true,
			minDate: +days, 
			maxDate: +30, 
			dateFormat: "dd-mm-yy"
		});
                /*added following line to solve this issue ..but not worked*/
                //$( ".datepicker" ).datepicker({dateFormat: "dd-mm-yy"});

            } ,
            error: function () {}
        });
       });
</script>


                                    <?php do_calander('#leave_join_date');?>
                                    <input  name="leave_join_date" type="date" id="leave_join_date" value="<?php if($leave_join_date) echo $leave_join_date; ?>" onclick="altmsg()"  /></td>
                                </tr>
                                
                                <tr class="oe_form_group_row">
                                  <td  bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Substitute Associate : </td>
                                  <td  bgcolor="#E8E8E8" class="oe_form_group_cell" colspan="4"><select name="leave_responsibility_name" id="leave_responsibility_name" style="width:420px;" >
                                    <? 
								  $emp_id = find_a_field('hrm_leave_info','PBI_ID','id='.$_REQUEST['id']);

								  $dept = find_a_field('personnel_basic_info','PBI_DEPARTMENT','PBI_ID='.$emp_id); 

								  $projec_t = find_a_field('personnel_basic_info','JOB_LOCATION','PBI_ID='.$emp_id); 

								  

								  if($emp_id>0){

								  if($projec_t>0){

								  foreign_relation('personnel_basic_info p, designation d','p.PBI_ID','concat(p.PBI_NAME," :: ",d.DESG_DESC)',$leave_responsibility_name,'p.PBI_DESIGNATION=d.DESG_ID and p.PBI_JOB_STATUS="In Service" and p.JOB_LOCATION="'.$projec_t.'" and p.PBI_ID not in (8,9,25)  and p.PBI_ID != '.$emp_id.' order by p.PBI_NAME');

								    }else{

									 foreign_relation('personnel_basic_info p, designation d','p.PBI_ID','concat(p.PBI_NAME," :: ",d.DESG_DESC)',$leave_responsibility_name,'p.PBI_DESIGNATION=d.DESG_ID and p.PBI_JOB_STATUS="In Service"  and p.PBI_DEPARTMENT="'.$dept.'" and p.PBI_ID not in (8,9,25) and p.PBI_ID != '.$emp_id.' order by p.PBI_NAME');

									 }

									 }
								  ?>
                                  </select>
                                    <input type="hidden" name="reporting_auth" value="<?=find_a_field('essential_info','ESSENTIAL_REPORTING','PBI_ID='.$_SESSION['user']['id'])?>" />                                
                                <tr class="oe_form_group_row">
                                  <td  bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;Approve/Not Approve Note</td>
                                  <td  bgcolor="#E8E8E8" class="oe_form_group_cell" colspan="4"><span class="oe_form_group_cell oe_form_group_cell_label">
                                    <textarea name="reporting_note" id="reporting_note" style="width:500px;" ><?=$reporting_note?>
                                    </textarea>
                                  </span>
                                </tbody>
                          </table></td>
						 
                        </tr>
                        <tr>
                          <td><div align="center">
                              
                             
							  <? if(isset($_GET[$unique]) && $_SESSION['employee_selected']==101656){?>
                              <span class="oe_form_buttons_edit" style="display: inline;">
                              <button name="granted" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Granted</button>
                              </span>
							  <span class="oe_form_buttons_edit" style="display: inline;">
                              <button name="notgranted" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Not Granted</button>
                              </span>
                              <? }?>
							 
							  
							    
								 
							  
							  
                            </div></td>
                        </tr>
                      </tbody>
                    </table>
					
					
					
					  <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#ccc">

    <?
	  
	    $emp_id = find_a_field('hrm_leave_info','PBI_ID','id='.$_REQUEST['id']);
	     $leave_days_casual=find_a_field('hrm_leave_info','sum(total_days)','type=1 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$emp_id);



$leave_days_sick=find_a_field('hrm_leave_info','sum(total_days)','type=2 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$emp_id);



$leave_days_annual=find_a_field('hrm_leave_info','sum(total_days)','type=3 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$emp_id);

$leave_days_marrige=find_a_field('hrm_leave_info','sum(total_days)','type=4 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$emp_id);

$leave_days_maternity=find_a_field('hrm_leave_info','sum(total_days)','type=5 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$emp_id);

$leave_days_paternity=find_a_field('hrm_leave_info','sum(total_days)','type=6 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$emp_id);

$leave_days_Hajj=find_a_field('hrm_leave_info','sum(total_days)','type=7 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$emp_id);

$leave_days_half=find_a_field('hrm_leave_info','sum(total_days)','type="Short Leave (SHL)" and leave_status="Granted" and half_leave_date>="'.$g_s_date.'" and half_leave_date<="'.$g_e_date.'"   and PBI_ID='.$emp_id);

$leave_days_EOL=find_a_field('hrm_leave_info','sum(total_days)','type=8 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$emp_id);

$leave_days_lwp= find_a_field('hrm_leave_info','sum(total_days)','type=9 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$emp_id);
	  ?>
	

    <tr>

      <td colspan="11"  bgcolor="#FFFFFF" style="background:#2299C3; color:#FFFFFF;"><div align="center" class="style1">Leave Status of <?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$emp_id)?> for <?php echo date('Y')?></div></td>
    </tr>
      
	  
	<tr style="background:#f1f1f0" height="60">

      <td width="118" align="center" valign="middle"><strong><span class="style10">
      <div align="center" style="margin-top:15px">Type</div></span></strong></td>

      <td width="101" align="center" valign="middle"><strong><span class="style10">
      <div align="center" style="margin-top:15px">Casual Leave (CL)</div></span></strong></td>

      <td width="130" align="center" valign="middle"><div align="center" style="margin-top:15px"><strong><span class="style10"><div align="center">Sick Leave (SL)</div></span></strong></div></td>

      <td width="98" align="center" valign="middle"><div align="center" style="margin-top:13px"><strong><span class="style10"><div align="center">Annual Leave (AL)</div></span></strong></div></td>

      <td width="109" align="center" valign="middle"><strong><span class="style10">
      <div align="center" style="margin-top:15px">Short Leave (SHL)</div></span></strong></td>
	  
	   <td width="127" align="center" valign="middle"><div align="center" style="margin-top:15px"><strong><span class="style10"><div align="center"><strong>Marriage Leave</strong></div>  
      </span></strong></div></td>
	  
	  
	  <?
	      if($PBI->PBI_SEX=="Female"){
	      ?>
	   <td width="125" align="center" valign="middle"><div align="center" style="margin-top:15px"><strong><span class="style10">Maternity Leave (ML)</span></strong></div> </td>
	   <? } else{?>
	   <td width="125" align="center" valign="middle"><div align="center" style="margin-top:15px"><strong><span class="style10">Paternity Leave (PL)</span></strong></div> </td>
	   <? } ?>
	  
	   <td width="127" align="center" valign="middle"><div align="center" style="margin-top:15px"><strong><span class="style10">Hajj Leave </span></strong></div></td>


      <td width="103" align="center" valign="middle"><div align="center"><strong><span class="style10"><div align="center">Leave <br> 

      Without Pay (LWP)</div></span></strong></div></td>



      <td width="125" align="center" valign="middle"><div align="center"><strong><span class="style10"><div align="center" style="margin-top:10px">Extra Ordinary Leave (EOL)</div></span></strong></div></td>
    </tr>
	
	
    

    <tr>

      <td width="118" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4"><strong>Balance</strong></span></div></td>

      <td width="101" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">

        <?=8?>

      </span></div></td>

      <td width="130" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">

        <?=8?>

      </span></div></td>

      <td width="98" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">
        <?=14?>
      </span></div></td>

      <td width="109" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><?=24?></div></td>
	         <td width="125" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><?=5?></div></td>
			  <?
	      if($PBI->PBI_SEX=="Female"){
	      ?>
      <td width="127" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><?=180?></div></td>
     <? }else{ ?>
      <td width="127" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><?=3?></div></td>
	  <? } ?>
      
      <td width="125" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><?=10?></div></td>


      <td width="103" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"></div></td>
     
   

      <td width="130" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center">As Per Management Approval</div></td>
    </tr>

    

	

	
	<tr>

      <td width="118" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4"><strong>Availed</strong></span></div></td>

      <td width="101" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">

        <?=$leave_days_casual?>

      </span></div></td>

      <td width="130" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">

        <?=$leave_days_sick?>

      </span></div></td>

      <td width="98" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">
        <?=$leave_days_annual?>
      </span></div></td>

      <td width="109" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><?=$leave_days_half?></div></td>
	         <td width="125" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><?=$leave_days_marrige?></div></td>
			  <?
	      if($personnel_basic_info->PBI_SEX=="Female"){
	      ?>
      <td width="127" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><?=$leave_days_maternity?></div></td>
     <? }else{ ?>
      <td width="127" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><?=$leave_days_paternity?></div></td>
	  <? } ?>
      
      <td width="125" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><?=$leave_days_Hajj?></div></td>


      <td width="103" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><?=$leave_days_lwp?></div></td>
     
   

      <td width="130" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"><?=$leave_days_EOL?></span></div></td>
    </tr>
	
	<tr style="font-weight:bold;">

      <td width="118" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"><strong>Balance</strong></span></div></td>

      <td width="101" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">

        <?=8-$leave_days_casual?>

      </span></div></td>

      <td width="130" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">

        <?=8-$leave_days_sick?>

      </span></div></td>

      <td width="98" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">

        <?=14-$leave_days_annual?>

      </span></div></td>

      <td width="98" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4"><?=24-$leave_days_half?></span></div></td>
	  
	  <td width="125" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">
        <?=5-$leave_days_marrige?>
      </div></td>
	  
	   <?
	      if($personnel_basic_info->PBI_SEX=="Female"){
	      ?>
      <td width="127" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"><?=180-$leave_days_maternity?></span></div></td>
   <? }else{ ?>
      <td width="127" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"><?=3-$leave_days_paternity?></span></div></td>
	  
	  <? } ?>
	  
	        <td width="125" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"><?=10-$leave_days_Hajj?></span></div></td>


      <td width="103" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"></span></div></td>


  
      
    
      

      <td width="130" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"></span></div></td>
    </tr>
	</table>
	
	
	
                  </div>
                </div>
                <div class="oe_chatter">
                  <div class="oe_followers oe_form_invisible">
                    <div class="oe_follower_list"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

<?
//
//
require_once SERVER_CORE."routing/layout.bottom.php";

?>


<?  include_once("../../template/footer.php");   ?>
