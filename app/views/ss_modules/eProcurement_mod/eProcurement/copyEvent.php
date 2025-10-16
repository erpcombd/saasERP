<?php
unset($_SESSION['rfq_no']);
session_start();
require_once "../../../controllers/routing/layout.top.php";
$old_rfq_no = $_GET['rfq_no'];
$end_date = date('Y-m-d');
$end_time = date('H:i:s');
$end_at = date('Y-m-d H:i:s');

$unique='rfq_no';
$Crud   = new Crud('rfq_master');
$sql = 'select * from rfq_master where rfq_no="'.$old_rfq_no.'"';
$qry = db_query($sql);
	
	while ($row = mysqli_fetch_assoc($qry)){
        foreach ($row as $COLUMN_NAME => $value) {
            $_POST[$COLUMN_NAME] = $value;
        }
    }

$_POST['eventStartDate'] = $end_date;
$_POST['eventStartTime'] = $end_time;
$_POST['eventStartAt']   = $end_at;

$_POST['eventEndDate'] =  date('Y-m-d', strtotime('+7 day'));
$_POST['eventEndTime'] = date('H:s');
$_POST['eventEndAt'] = $_POST['eventEndDate'].' '.$_POST['eventEndTime'];

$_POST['rfq_no'] = '';

$check_master_rfq = find_a_field('rfq_master','master_rfq_no','rfq_no="'.$old_rfq_no.'"');
if($check_master_rfq>0){
$master_rfq_no = $check_master_rfq;
}else{
$master_rfq_no = $old_rfq_no;
}

//$_POST['master_rfq_no'] = $master_rfq_no;
$_POST['status'] = 'MANUAL';
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$_POST['unseal_status'] = 'SEALED';
	
 $version = 0;	
 //$version = find_a_field('rfq_master','count(rfq_no)','master_rfq_no="'.$master_rfq_no.'"')+1;
if($version<1){
$version = 1;
}
$_POST['rfq_version'] = $master_rfq_no.'-Round.'.$version;
$_SESSION[$unique] = $Crud->insert();
$_SESSION['rfq_version'] = $_POST['rfq_version'];



$_POST['new_rfq_no'] = $_SESSION[$unique];
$Crud   = new Crud('rfq_copy_info');
$Crud->insert();
unset($_POST);

$table_row['table_name']='';
$all_table = "SELECT table_name FROM information_schema.tables WHERE table_schema ='robierp_livedb' AND table_name LIKE 'rfq_%' and table_name in ('rfq_doc_details','rfq_evaluation_section','rfq_evaluation_team','rfq_form_master','rfq_vendor_details','rfq_item_details',
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


$Crud = new Crud('rfq_documents_information');	
 $sqql = 'select * from rfq_documents_information where rfq_no="'.$old_rfq_no.'" and tr_from not in ("multiple_doc_section") and section_id=""';
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

$_SESSION['roundingMessage'] = '<span style="color:green; font-size:20px;">New round created successfully</span>';

/*echo '<script>window.location.href = "eprocurement_entry_entry.php?rfq_no='.url_encode($_SESSION[$unique]).'";</script>';*/
echo '<script>window.location.href = "eprocurement_entry_entry.php?old_rfq_no='.url_encode($_SESSION[$unique]).'&&clear=1";</script>';
?>
