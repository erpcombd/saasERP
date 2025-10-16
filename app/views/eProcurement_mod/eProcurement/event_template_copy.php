<?php

session_start();

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once "../../../controllers/routing/layout.top.php";
$old_rfq_no = url_decode($_GET['rfq_no']);
$unique='rfq_no';
unset($_SESSION[$unique]);
$Crud   = new Crud('rfq_master');
$sql = 'select * from rfq_master where rfq_no="'.$old_rfq_no.'"';
$qry = db_query($sql);
	
	while ($row = mysqli_fetch_assoc($qry)){
        foreach ($row as $COLUMN_NAME => $value) {
            $_POST[$COLUMN_NAME] = $value;
        }
    }	
$_POST['event_name'] = 'Copy from Template event no: '.$old_rfq_no.' '.find_a_field('rfq_master','event_name','rfq_no="'.$old_rfq_no.'"');
$_POST['rfq_no'] = '';
$_POST['master_rfq_no'] = '';
$_POST['rfx_stage'] = 'RFQ';
$_POST['status'] = 'MANUAL';
$_POST['manual_unseal'] = 'SEALED';
$_POST['copy_master_rfq'] = $old_rfq_no;
$_POST['copy_rfq_remarks'] = 'Copy from event no: '.$old_rfq_no;
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
 $version = find_a_field('rfq_master','count(rfq_no)','master_rfq_no="'.$old_rfq_no.'"');
if($version<1){
$version = 1;
}
$_POST['rfq_version'] = find_a_field('rfq_master','max(rfq_no)+1','1').'-Round.0';
$_SESSION['rfq_version'] = $_POST['rfq_version'];
$_SESSION[$unique] = $Crud->insert();
$_SESSION['master_status'] = 'MANUAL';



$_POST['new_rfq_no'] = $_SESSION[$unique];
$Crud   = new Crud('rfq_rounding_info');
$Crud->insert();
unset($_POST);

$table_row['table_name']='';
$all_table = "SELECT table_name FROM information_schema.tables WHERE table_schema ='robierp_livedb' AND table_name LIKE 'rfq_%' and table_name in ('rfq_doc_details','rfq_evaluation_section','rfq_form_master','rfq_vendor_details','rfq_item_details',
'rfq_documents_url_information','rfq_section_evaluation_team','rfq_group_for','rfq_multiple_currency')";
$all_table_qry = db_query($all_table);
while ($table_row = mysqli_fetch_assoc($all_table_qry)) {
        $table_name = $table_row['TABLE_NAME'];
		$Crud = new Crud($table_name);

$psql = "SELECT COLUMN_NAME FROM information_schema.columns WHERE table_schema = 'robierp_livedb' AND table_name = '$table_name' AND column_key = 'PRI'";
$pqry = db_query($psql);
$primary_key = mysqli_fetch_object($pqry);
$sql = 'select * from '.$table_name.' where rfq_no="'.$old_rfq_no.'"';
$qry = db_query($sql);
while ($row = mysqli_fetch_assoc($qry)) {

        foreach ($row as $COLUMN_NAME => $value) {
			
		  
           $_POST[$COLUMN_NAME] = $value;
	

			
			
        }
		    $_POST[$primary_key->COLUMN_NAME] = '';
			$_POST['rfq_no'] = $_SESSION[$unique];
			$_POST['master_row_id'] = $row[$primary_key->COLUMN_NAME];
            $_POST['entry_at'] = date('Y-m-d H:i:s');
            $_POST['entry_by'] = $_SESSION['user']['id'];
			
            $_POST['table_id'] = $Crud->insert();
            unset($_POST);
    }

	
}

$upQl = 'update rfq_vendor_details set status = "PROCESSING" where rfq_no = '.$_SESSION[$unique].' ';
db_query($upQl);

$Crud = new Crud('rfq_documents_information');	
$sqql = 'select * from rfq_documents_information where rfq_no="'.$old_rfq_no.'" and tr_from not in ("multiple_doc_section") and section_id IS NULL';
$qrry = db_query($sqql);
while($data=mysqli_fetch_assoc($qrry)){
			
			foreach ($data as $COLUMN_NAME => $value) {
			$_POST[$COLUMN_NAME] = $value;
			}
			
			$_POST['documents_id'] = '';
			$_POST['rfq_no'] = $_SESSION[$unique];
			$_POST['entry_at'] = date('Y-m-d H:i:s');
            $_POST['entry_by'] = $_SESSION['user']['id'];
		    $Crud->insert();
 } unset($_POST); 
 
 /////////////
$Crud = new Crud('rfq_evaluation_team');	
$sqql = 'select * from rfq_evaluation_team where rfq_no="'.$old_rfq_no.'" and is_master = "Yes" ';
$qrry = db_query($sqql);
while($data=mysqli_fetch_assoc($qrry)){
			
			foreach ($data as $COLUMN_NAME => $value) {
				$_POST[$COLUMN_NAME] = $value;
			}
			
			$_POST['id'] = '';
			$_POST['rfq_no'] = $_SESSION[$unique];
			$_POST['entry_at'] = date('Y-m-d H:i:s');
            $_POST['entry_by'] = $_SESSION['user']['id'];
			$_POST['user_id'] = $_SESSION['user']['id'];
		    $Crud->insert();
 } unset($_POST); 
/////////// 


$Crud = new Crud('rfq_documents_information');	
$sqql = 'select * from rfq_doc_details where rfq_no="'.$_SESSION[$unique].'"';
$qrry = db_query($sqql);
while($data=mysqli_fetch_assoc($qrry)){

 $sqqll = 'select * from rfq_documents_information where rfq_no="'.$old_rfq_no.'" and tr_from in ("multiple_doc_section") and 
 section_id="'.$data['master_row_id'].'"';
 $qrrry = db_query($sqqll);
 while($data1=mysqli_fetch_assoc($qrrry)){
			
			foreach ($data1 as $COLUMN_NAME => $value) {
				
			$_POST[$COLUMN_NAME] = $value;
			}
			
			$_POST['documents_id'] = '';
			$_POST['section_id'] = $data['id'];
			$_POST['rfq_no'] = $_SESSION[$unique];
			$_POST['entry_at'] = date('Y-m-d H:i:s');
            $_POST['entry_by'] = $_SESSION['user']['id'];
		    $Crud->insert();
 }
 
}



$Crud = new Crud('rfq_form_details');	
 $sqql = 'select * from rfq_form_master where rfq_no="'.$_SESSION[$unique].'"';
$qrry = db_query($sqql);
while($data=mysqli_fetch_assoc($qrry)){

 $sqqll = 'select * from rfq_form_details where rfq_no="'.$old_rfq_no.'" and form_no="'.$data['master_row_id'].'"';
 $qrrry = db_query($sqqll);
 while($data1=mysqli_fetch_assoc($qrrry)){
			
			foreach ($data1 as $COLUMN_NAME => $value) {
			$_POST[$COLUMN_NAME] = $value;
			}
			
			$_POST['id'] = '';
			$_POST['form_no'] = $data['form_no'];
			$_POST['rfq_no'] = $_SESSION[$unique];
			$_POST['entry_at'] = date('Y-m-d H:i:s');
            $_POST['entry_by'] = $_SESSION['user']['id'];
		    $details_id = $Crud->insert();
			
			$sqqll = 'select * from rfq_form_element_options where rfq_no="'.$old_rfq_no.'" and form_no="'.$data1['form_no'].'" 
			and form_detail_id="'.$data1['id'].'"';
			 $qrrry = db_query($sqqll);
			 $Crud = new Crud('rfq_form_element_options');	
			 while($data2=mysqli_fetch_assoc($qrrry)){
				   foreach ($data2 as $COLUMN_NAME => $value) {
						$_POST[$COLUMN_NAME] = $value;
						}
						$_POST['id'] = '';
						$_POST['form_no'] = $data['form_no'];
						$_POST['form_detail_id'] = $details_id;
						$_POST['rfq_no'] = $_SESSION[$unique];
						$_POST['entry_at'] = date('Y-m-d H:i:s');
						$_POST['entry_by'] = $_SESSION['user']['id'];
						$Crud->insert();
			 }
			
			
 }
 
} unset($_POST);




$Crud = new Crud('rfq_evaluation_section_child');	
$sqql = 'select * from rfq_evaluation_section where rfq_no="'.$_SESSION[$unique].'"';
$qrry = db_query($sqql);
while($data=mysqli_fetch_assoc($qrry)){

 $sqqll = 'select * from rfq_evaluation_section_child where rfq_no="'.$old_rfq_no.'" and section_id="'.$data['master_row_id'].'"';
 $qrrry = db_query($sqqll);
 while($data3=mysqli_fetch_assoc($qrrry)){
			
			foreach ($data3 as $COLUMN_NAME => $value) {
			$_POST[$COLUMN_NAME] = $value;
			}
			
			$_POST['id'] = '';
			$_POST['section_id'] = $data['id'];
			$_POST['rfq_no'] = $_SESSION[$unique];
			$_POST['entry_at'] = date('Y-m-d H:i:s');
            $_POST['entry_by'] = $_SESSION['user']['id'];
		    $Crud->insert();
 }
 
} unset($_POST);


echo '<script>window.location.href = "eprocurement_entry_entry.php";</script>';
;
?>
