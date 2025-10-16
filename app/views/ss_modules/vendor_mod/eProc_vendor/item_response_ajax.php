<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$str = $_POST['data'];
$data=explode('##',$str);

$rfq = $data[0];
$section_id = $data[1];

$vendor = $_SESSION['vendor']['id'];

$response_name = find_a_field('rfq_vendor_response','response_name',' rfq_no='.$rfq.' and id='.$section_id.' ');
if($response_name !=''){
	$completed = 1;																							
}


$sql_rfq_master = 'select * from rfq_master  where    rfq_no="'.$rfq.'" ';
$qry_rfq_master = db_query($sql_rfq_master);
$res_rfq_master = mysqli_fetch_object($qry_rfq_master);



 $event_end_date = $res_rfq_master->eventEndDate; 
 $event_end_time = $res_rfq_master->eventEndTime; 
 $event_end_at = $event_end_date . ' ' . $event_end_time; 

$current_time = time(); 
$event_end_timestamp = strtotime($event_end_at); 

if ($event_end_timestamp > $current_time) {






  $sql = 'select d.* from rfq_doc_details d where    rfq_no="'.$rfq.'" ';
  $qry = db_query($sql);
  $required = 1;
  
  while($res = mysqli_fetch_object($qry)){
	if($res->is_required==1){

		$resp = find_a_field('rfq_documents_information','count(documents_id)','tr_from like "sourcing_attachment_response'.$res->id.'" and section_id="'.$section_id.'" and entry_by="'.$_SESSION['user']['id'].'" and rfq_no="'.$rfq.'"');
		if($resp>0){
			$completed++;
		}
		
		$respURL = find_a_field('rfq_documents_url_information','count(documents_url_id)','tr_from like "sourcing_attachment_response_url'.$res->id.'" and section_id="'.$section_id.'" and entry_by="'.$_SESSION['user']['id'].'" and rfq_no="'.$rfq.'"');
		if($respURL>0){
			$completed++;
		}
		
		$respTXT = find_a_field('rfq_documents_url_information','count(documents_url_id)','tr_from like "sourcing_attachment_response_text'.$res->id.'" and section_id="'.$section_id.'" and entry_by="'.$_SESSION['user']['id'].'" and rfq_no="'.$rfq.'"');
		if($respTXT>0){
			$completed++;
		}
		
		$required++;
	}
  }
  		
  
  		$Crud   = new Crud("rfq_vendor_item_response");
		
		
		
		$_POST['rfq_no']=$rfq;
		$_POST['vendor_id']=$vendor;
		
		$delSql = 'DELETE FROM `rfq_vendor_item_response` WHERE rfq_no='.$rfq.' and section_id='.$section_id.' ';
		$qry = db_query($delSql);
		
		$sql = 'select * from rfq_item_details where 1 and rfq_no="'.$rfq.'"';
		$qry = db_query($sql);
		while($doc=mysqli_fetch_object($qry)){
		  $required++;
		if($_POST['vendor_price'.$doc->id]!=''){
			$_POST['capacity']=$_POST['capacity'.$doc->id];
			$_POST['expected_qty']=$doc->expected_qty;
			$_POST['unit_price']=$_POST['vendor_price'.$doc->id];
			$_POST['total_amount']=$_POST['vendor_total_amount'.$doc->id];
			$_POST['need_by']=$_POST['need_by'.$doc->id];
			$_POST['item_id']=$doc->item_id;
			$_POST['section_id'] = $section_id;
			$_POST['event_item_details_id']=$doc->id;
			
			$_POST['currency']=$_POST['currency_'.$doc->id];
			
			$Crud->insert();
			$completed++;
			
			$_SESSION['msg'] = 'Response Submitted successfully';
		}
		}
   
   if($required>$completed){ 
   
   }else{ 
	   $update_sql = 'update rfq_vendor_response set status="SUBMITED" where rfq_no='.$rfq.' and id='.$section_id.' ';
	   db_query($update_sql);
	   
	   $sql1l = 'insert into vendor_entry_log (rfq_no, response_no, field_name, field_value, vendor_id, entry_at) 
				values ('.$rfq.','.$section_id.',"Final Submit", "Final submit","'.$_SESSION['user']['id'].'", "'.$now.'")';
		db_query($sql1l);
	   
		$_SESSION['msg'] = 'Response Submitted successfully';
	}		
    $info['response_name'] = $response_name;
	$info['required'] = $required;
	$info['completed'] = $completed;

}else{
	$_SESSION['event_end_msg']='The event has ended you can not submit response now';
	$info['response_name'] = 'test';
	$info['required'] = 'time_exceded';
	$info['completed'] = 'time_exceded';
}

 echo json_encode($info);
 
 ?>

