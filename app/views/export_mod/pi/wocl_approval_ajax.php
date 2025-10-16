<?

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$do_no = $_REQUEST['do_no'];
$app_date = $_REQUEST['app_date'];

$tr_data = find_all_field('sale_do_master','','do_no="'.$do_no.'"');

 $app_val = $_REQUEST['valc'];
 
 	$checked_by = $_SESSION['user']['id'];
	$checked_at=date('Y-m-d H:i:s');


		 if ($app_val==1) {

   $YR = date('Y',strtotime($app_date));
   $year = date('y',strtotime($app_date));
   $month = date('m',strtotime($app_date));
   $digital_sign_id = find_a_field('management_approval_history','max(digital_sign_id)','year="'.$YR.'"')+1;
   $cy_id = sprintf("%08d", $digital_sign_id);
   $digital_sign=$year.''.$month.''.$cy_id;

	$status = 'CANCELED';
	$checked_by = $_SESSION['user']['id'];
	$checked_at=date('Y-m-d H:i:s');


	$flag = $_REQUEST['flag'];





			 $new_sql="UPDATE sale_do_master SET status='".$status."', 
			 cancel_app_by = '".$checked_by."', cancel_app_at = '".$checked_at."' WHERE do_no = '".$do_no."'";
			 db_query($new_sql);
			 
			 
			// $pi_type = find_a_field('pi_type','pi_type','id='.$pi_data->pi_type);
			 
			 

	$am_ins = "INSERT INTO management_approval_history (app_date, tr_no, tr_no_view, tr_date, tr_type, year, digital_sign_id, digital_sign, checked_by, checked_at)
  
  VALUES('".$app_date."', '".$do_no."', '".$tr_data->job_no."', '".$tr_data->do_date."', 'WO Canceled', '".$YR."', '".$digital_sign_id."', '".$digital_sign."', 
  '".$checked_by."',  '".$checked_at."')";

db_query($am_ins);
	



} elseif ($app_val==2) {


 $up_h="UPDATE sale_do_master SET c_mis_hold='No' WHERE  do_no = '".$do_no."'";
db_query($up_h);

 $hr_ins = "INSERT INTO mis_hold_reject_history (app_date, tr_no, tr_no_view, tr_date, tr_type, tr_from, checked_by, checked_at)
  
  VALUES('".$app_date."', '".$do_no."', '".$tr_data->job_no."', '".$tr_data->do_date."',  'Unhold',  'WO CANCELE', 
  '".$checked_by."',  '".$checked_at."')";
db_query($hr_ins);

}  elseif ($app_val==3) {

 $up_h="UPDATE sale_do_master SET c_mis_hold='Yes' WHERE do_no = '".$do_no."'";
db_query($up_h);

 $hr_ins = "INSERT INTO mis_hold_reject_history (app_date, tr_no, tr_no_view, tr_date, tr_type, tr_from, checked_by, checked_at)
  
  VALUES('".$app_date."', '".$do_no."', '".$tr_data->job_no."', '".$tr_data->do_date."',  'Hold',  'WO CANCELE', 
  '".$checked_by."',  '".$checked_at."')";
db_query($hr_ins);

}elseif  ($app_val==4){

$up_c ="UPDATE sale_do_master SET c_mis_reject='Yes', status='CHECKED' WHERE do_no = '".$do_no."'";
db_query($up_c);

$hr_ins = "INSERT INTO mis_hold_reject_history (app_date, tr_no, tr_no_view, tr_date, tr_type, tr_from, checked_by, checked_at)
  
  VALUES('".$app_date."', '".$do_no."', '".$tr_data->job_no."', '".$tr_data->do_date."',  'Reject', 'WO CANCELE', 
  '".$checked_by."',  '".$checked_at."')";
db_query($hr_ins);

}


	



echo 'Success!';


?>