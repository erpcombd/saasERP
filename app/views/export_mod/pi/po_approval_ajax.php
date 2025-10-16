<?

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$po_no = $_REQUEST['po_no'];
$app_date = $_REQUEST['app_date'];


 $app_val = $_REQUEST['valw'];

$tr_data = find_all_field('purchase_master','','po_no="'.$po_no.'"');

	$checked_by = $_SESSION['user']['id'];
	$checked_at=date('Y-m-d H:i:s');


 if ($app_val==31) {

   $YR = date('Y',strtotime($app_date));
   $year = date('y',strtotime($app_date));
   $month = date('m',strtotime($app_date));
   $digital_sign_id = find_a_field('management_approval_history','max(digital_sign_id)','year="'.$YR.'"')+1;
   $cy_id = sprintf("%08d", $digital_sign_id);
   $digital_sign=$year.''.$month.''.$cy_id;

	$status = 'CHECKED';



	$flag = $_REQUEST['flag'];
	
	
	
	$new_sql="UPDATE purchase_master SET  status='".$status."',  digital_sign = '".$digital_sign."', 
	checked_by = '".$checked_by."', checked_at = '".$checked_at."' WHERE po_no = '".$po_no."'";
	db_query($new_sql);



	$am_ins = "INSERT INTO management_approval_history (app_date, tr_no, tr_no_view, tr_date, tr_type, year, digital_sign_id, digital_sign, checked_by, checked_at)
  
  VALUES('".$app_date."', '".$po_no."', '".$tr_data->po_no."', '".$tr_data->po_date."', 'Purchase Order', '".$YR."', '".$digital_sign_id."', '".$digital_sign."', 
  '".$checked_by."',  '".$checked_at."')";

db_query($am_ins);
	

} elseif ($app_val==32) {


 $up_h="UPDATE purchase_master SET mis_hold='No' WHERE  po_no = '".$po_no."'";
db_query($up_h);

 $hr_ins = "INSERT INTO mis_hold_reject_history (app_date, tr_no, tr_no_view, tr_date, tr_type, tr_from, checked_by, checked_at)
  
  VALUES('".$app_date."', '".$po_no."', '".$tr_data->po_no."', '".$tr_data->po_date."',  'Unhold', 'Purchase Order',
  '".$checked_by."',  '".$checked_at."')";
db_query($hr_ins);

}  elseif ($app_val==33) {

 $up_h="UPDATE purchase_master SET mis_hold='Yes' WHERE po_no = '".$po_no."'";
db_query($up_h);

 $hr_ins = "INSERT INTO mis_hold_reject_history (app_date, tr_no, tr_no_view, tr_date, tr_type, tr_from, checked_by, checked_at)
  
  VALUES('".$app_date."', '".$po_no."', '".$tr_data->po_no."', '".$tr_data->po_date."',  'Hold', 'Purchase Order',
  '".$checked_by."',  '".$checked_at."')";
db_query($hr_ins);

}elseif  ($app_val==4){

$up_c ="UPDATE sale_do_master SET wo_mis_reject='Yes', status='MANUAL' WHERE do_no = '".$do_no."'";
db_query($up_c);

$hr_ins = "INSERT INTO mis_hold_reject_history (app_date, tr_no, tr_no_view, tr_date, tr_type, tr_from, checked_by, checked_at)
  
  VALUES('".$app_date."', '".$do_no."', '".$tr_data->job_no."', '".$tr_data->do_date."',  'Reject', 'Work Order',
  '".$checked_by."',  '".$checked_at."')";
db_query($hr_ins);

}






echo 'Success!';


?>