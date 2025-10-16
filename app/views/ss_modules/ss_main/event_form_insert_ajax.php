<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$unique='id';
$table_master = 'rfq_form_master';
$Crud   = new Crud($table_master);

$all[] = $_POST['form_description'];


$rfq_no = $_SESSION['rfq_no'];
$_POST['rfq_no'] = $rfq_no;

$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];

if($_SESSION['rfq_no']>0){

$_POST['form_no'] = $Crud->insert();


$sql = 'select * from form_elements where 1';
$qry = db_query($sql);

while($row=mysqli_fetch_object($qry)){
	
	  $info = explode("#",$_POST[$row->field_name]);
	  
	  if($row->element==$info[0] && $info[1]>0){
	  for($i=1;$i<=$info[1];$i++){
	  $Crud   = new Crud('rfq_form_details');
	  $unique_no = $row->field_name.'_'.$i;
      $_POST['form_element'] = $info[0];
	  $_POST['lebel'] = $_POST['lebel_'.$unique_no];
	  $_POST['is_required'] = $_POST['is_required_'.$unique_no];
	  $_POST['hints'] = $_POST['hint_'.$unique_no];
	  $_POST['default_values'] = $_POST['default_value_'.$unique_no];
	  $_POST['option_1'] = $_POST['option_1_'.$unique_no];
	  $_POST['option_2'] = $_POST['option_2_'.$unique_no];
	  $_POST['form_detail_id'] = $Crud->insert();
	  $total_options = $_POST['option_count_'.$unique_no];
	  $Crud   = new Crud('rfq_form_element_options');
	    for($j=3;$j<=$total_options;$j++){
		
			$_POST['options'] = $_POST['option_'.$j.'_'.$unique_no];
			$Crud->insert();
		}
      }

	  }
	  
	  unset($_SESSION[$row->element]);
	}
	
	

$_POST['field_name'] = 'event_form_insert';
$_POST['field_value'] = $_POST['form_name'];
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud   = new Crud('rfq_logs');
$Crud->insert();
}

echo json_encode($all);
?>

