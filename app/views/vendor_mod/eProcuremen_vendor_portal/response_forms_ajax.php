<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$table_master = 'rfq_form_response';

$str = $_POST['data'];
$data=explode('##',$str);

$rfq = $data[0];
$section_id = 0;
if($_SESSION['response_id']>0){
	$section_id = $_SESSION['response_id'];
}

$vendor_id = $_SESSION['vendor']['id'];

$forms = explode('##>',$rfq);


$i=0;
$Crud   = new Crud($table_master);

$del = 'DELETE FROM `rfq_form_response` WHERE  rfq_no = '.$rfq.'  and vendor_id='.$vendor_id.' and section_id = '.$section_id.' ';
db_query($del);
foreach($data as $form){
	$dt = explode('#>',$form);
    if(($dt[0]=='form_id_value')&&($form_id!=$dt[1])){
		$form_id = $dt[1];
	} 
	
	
	
	if($dt[0]!='form_id_value'){
		$_POST['form_no'] = $form_id;
		$_POST['rfq_no'] = $rfq;
		if($dt[0] !='' && $form_id>0){
		    
			$_POST['form_id']  = $dt[0];
			$_POST['vendor_id']= $vendor_id;
			$_POST['value']    = $dt[1];
			
			$_POST['section_id'] = $section_id;
			$_POST['entry_at'] =  date('Y-m-d H:i:s');
			$_POST['entry_by'] = $_SESSION['user']['id'];
			$Crud->insert();
		}
	}
}



echo $value;



?>


