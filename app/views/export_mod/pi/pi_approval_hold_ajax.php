<?

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$pi_id = $_REQUEST['id'];

echo $val = $_REQUEST['val'];

$app_date = $_REQUEST['app_date'];

$pi_data = find_all_field('pi_master','','id="'.$pi_id.'"');

   $YR = date('Y',strtotime($app_date));
   $year = date('y',strtotime($app_date));
   $month = date('m',strtotime($app_date));
   $digital_sign_id = find_a_field('management_approval_history','max(digital_sign_id)','year="'.$YR.'"')+1;
   $cy_id = sprintf("%08d", $digital_sign_id);
   $digital_sign=$year.''.$month.''.$cy_id;

	$status = 'CHECKED';
	$checked_by = $_SESSION['user']['id'];
	$checked_at=date('Y-m-d H:i:s');


	$flagh = $_REQUEST['flagh'];
	
			
			
			
			


			if ($flagh==1) {
			 $new_sql="UPDATE pi_master SET mis_hold='Yes' WHERE id = '".$pi_id."'";
			 db_query($new_sql);
			 }else {
			 $new_sql="UPDATE pi_master SET mis_hold='No' WHERE id = '".$pi_id."'";
			 db_query($new_sql);
			 }
			 
			 
			 //$pi_type = find_a_field('pi_type','pi_type','id='.$pi_data->pi_type);
			 
			 

//	$am_ins = "INSERT INTO management_approval_history (app_date, tr_no, tr_no_view, tr_date, tr_type, year, digital_sign_id, digital_sign, checked_by, checked_at)
//  VALUES('".$app_date."', '".$pi_id."', '".$pi_data->pi_no."', '".$pi_data->pi_date."', '".$pi_type."', '".$YR."', '".$digital_sign_id."', '".$digital_sign."', 
//  '".$checked_by."',  '".$checked_at."')";
//db_query($am_ins);
	







echo 'Success!';


?>