<?php

session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');

$table_master = 'rfq_form_response';

$str = $_POST['data'];
$data=explode('##',$str);

$rfq = $data[0];
//$vendor_id = find_a_field('rfq_vendor_details','vendor_id','rfq_no='.$rfq);
$vendor_id = find_a_field('user_activity_management','vendor_code','user_id="'.$_SESSION['user']['id'].'"');
//var_dump($data);
$forms = explode('##>',$rfq);


$i=0;
$crud   = new crud($table_master);

$del = 'DELETE FROM `rfq_form_response` WHERE  rfq_no = '.$rfq.'  and vendor_id='.$vendor_id.' ';
db_query($del);
foreach($data as $form){
	$dt = explode('#>',$form);
    if($dt[0]=='form_id_value'){
	  if($form_id!=$dt[1]){
		$form_id = $dt[1];
	   }
	} 
	
	//echo $form_id;
	
	if($dt[0]!='form_id_value'){
		$_POST['form_no'] = $form_id;
		$_POST['rfq_no'] = $rfq;
		if($dt[0] !='' && $form_id>0){
		    
			$_POST['form_id']  = $dt[0];
			$_POST['vendor_id']= $vendor_id;
			$_POST['value']    = $dt[1];
			
			
			$_POST['entry_at'] =  date('Y-m-d H:i:s');
			$_POST['entry_by'] = $_SESSION['user']['id'];
			$crud->insert();
		}
	}
}

/*if($id>0){
$crud   = new crud($table_master);
$_POST[$unique] = $id ;
$_POST['rfq_no'] = $rfq;
$_POST['vendor_id'] = $vendor;
$_POST['response_name'] = $value;
$_POST['response_date'] = date('Y-m-d');
$_POST['edit_at'] = date('Y-m-d H:i:s');
$_POST['edit_by'] = $_SESSION['user']['id'];
$crud->update($unique);

}else{
	$_POST['rfq_no'] = $rfq;
	$_POST['vendor_id'] = $vendor;
	$_POST['response_name'] = $value;
	$_POST['response_date'] = date('Y-m-d');
	$_POST['entry_at'] = date('Y-m-d H:i:s');
	$_POST['entry_by'] = $_SESSION['user']['id'];
	$crud   = new crud($table_master);
	$crud->insert();
}*/

echo $value;

/*$unique='rfq_no';
$table_master = 'rfq_master';
$crud   = new crud($table_master);

$field_name  = $data[0];
$field_value = $data[1];
// Common Field
$_POST['rfq_date'] = date('Y-m-d');


$_POST[$field_name] = $field_value;*/

/*if($_SESSION[$unique]>0){
$_POST[$unique] = $_SESSION[$unique];
$_POST['edit_at'] = date('Y-m-d H:i:s');
$_POST['edit_by'] = $_SESSION['user']['id'];
$crud->update($unique);

}*/

/*else{
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$_SESSION[$unique] = $crud->insert();

}


$_POST['field_name'] = $field_name;
$_POST['field_value'] = $field_value;
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$crud   = new crud('rfq_logs');
$crud->insert();*/

?>


