<?

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$foc_no = $_REQUEST['foc_no'];
$app_date = $_REQUEST['app_date'];


 $app_val = $_REQUEST['valw'];

$tr_data = find_all_field('sale_foc_master','','foc_no="'.$foc_no.'"');

	$checked_by = $_SESSION['user']['id'];
	$checked_at=date('Y-m-d H:i:s');


 if ($app_val==1) {

   $YR = date('Y',strtotime($app_date));
   $year = date('y',strtotime($app_date));
   $month = date('m',strtotime($app_date));
   $digital_sign_id = find_a_field('management_approval_history','max(digital_sign_id)','year="'.$YR.'"')+1;
   $cy_id = sprintf("%08d", $digital_sign_id);
   $digital_sign=$year.''.$month.''.$cy_id;

	$status = 'CHECKED';



	$flag = $_REQUEST['flag'];

			
			//$max_delivery_date = find_a_field_sql('select max(delivery_date) as max_delivery_date from sale_do_details where do_no="'.$do_no.'" GROUP by do_no');
			
		

			 $new_sql="UPDATE sale_foc_master SET status='".$status."',  digital_sign = '".$digital_sign."', 
			 checked_by = '".$checked_by."', checked_at = '".$checked_at."' WHERE foc_no = '".$foc_no."'";
			 db_query($new_sql);
			 
			 
			// $pi_type = find_a_field('pi_type','pi_type','id='.$pi_data->pi_type);
			 
			 

	$am_ins = "INSERT INTO management_approval_history (app_date, tr_no, tr_no_view, tr_date, tr_type, year, digital_sign_id, digital_sign, checked_by, checked_at)
  
  VALUES('".$app_date."', '".$foc_no."', '".$tr_data->job_no."', '".$tr_data->foc_date."', 'FOC Order', '".$YR."', '".$digital_sign_id."', '".$digital_sign."', 
  '".$checked_by."',  '".$checked_at."')";

db_query($am_ins);
	

} elseif ($app_val==2) {


 $up_h="UPDATE sale_foc_master SET wo_mis_hold='No' WHERE  foc_no = '".$foc_no."'";
db_query($up_h);

 $hr_ins = "INSERT INTO mis_hold_reject_history (app_date, tr_no, tr_no_view, tr_date, tr_type, tr_from, checked_by, checked_at)
  
  VALUES('".$app_date."', '".$foc_no."', '".$tr_data->job_no."', '".$tr_data->foc_date."',  'Unhold', 'FOC Order',
  '".$checked_by."',  '".$checked_at."')";
db_query($hr_ins);

}  elseif ($app_val==3) {

 $up_h="UPDATE sale_foc_master SET wo_mis_hold='Yes' WHERE foc_no = '".$foc_no."'";
db_query($up_h);

 $hr_ins = "INSERT INTO mis_hold_reject_history (app_date, tr_no, tr_no_view, tr_date, tr_type, tr_from, checked_by, checked_at)
  
  VALUES('".$app_date."', '".$foc_no."', '".$tr_data->job_no."', '".$tr_data->foc_date."',  'Hold', 'FOC Order',
  '".$checked_by."',  '".$checked_at."')";
db_query($hr_ins);

}elseif  ($app_val==4){

$up_c ="UPDATE sale_foc_master SET wo_mis_reject='Yes', status='MANUAL' WHERE foc_no = '".$foc_no."'";
db_query($up_c);

$hr_ins = "INSERT INTO mis_hold_reject_history (app_date, tr_no, tr_no_view, tr_date, tr_type, tr_from, checked_by, checked_at)
  
  VALUES('".$app_date."', '".$foc_no."', '".$tr_data->job_no."', '".$tr_data->foc_date."',  'Reject', 'FOC Order',
  '".$checked_by."',  '".$checked_at."')";
db_query($hr_ins);


$foc_del_ms_sql = "delete from sale_foc_master where foc_no = '".$foc_no."'";
db_query($foc_del_ms_sql);

$foc_del_dt_sql = "delete from sale_foc_details where foc_no = '".$foc_no."'";
db_query($foc_del_dt_sql);

}






echo 'Success!';


?>