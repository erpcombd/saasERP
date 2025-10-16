<?php
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$rfq_no  = $_SESSION['rfq_no'];

$unique='id';
$table_master = 'rfq_doc_details';
$Crud   = new Crud($table_master);
$_POST['rfq_no'] = $rfq_no;
if($rfq_no>0){
$_POST['terms'] = $_POST['section_terms'];

$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$section_id = $Crud->insert();


    $r_file_name = $_FILES['files']['name'];
	$r_file_size = $_FILES['files']['size'];
	$r_file_temp = $_FILES['files']['tmp_name'];
	if($r_file_size>0){
	for($r=0; $r<count($r_file_name);$r++){

	$r_div[$r] = explode('.', $r_file_name[$r]);
	$r_file_ext = strtolower(end($r_div[$r]));
	
	$allowed = array('jpg','jpeg','png','pdf', 'docx', 'eml', 'xlsx', 'xls', 'msg','txt','csv','xlsm','zip','rar');
	if(in_array($r_file_ext,$allowed)){
	$r_unique_image = uniqid().'.'.$r_file_ext;
	$orginal_file_name = $r_div[$r][0].'.'.$r_file_ext;
	$r_uploaded_image = "../../../../public/uploads/doc_section/".$r_unique_image;
	$dd = move_uploaded_file($r_file_temp[$r], $r_uploaded_image);

	$ii_query = 'INSERT INTO `rfq_documents_information`(`tr_from`, `rfq_no`, `folder_path`,`new_name`,`original_name`,`section_id`,`entry_at`,`entry_by`) VALUES ("multiple_doc_section","'.$rfq_no.'","../../../../public/uploads/doc_section/","'.$r_unique_image.'","'.$orginal_file_name.'","'.$section_id.'","'.date('Y-m-d H:i:s').'","'.$_SESSION['user']['id'].'")';
	$new_pp = db_query($ii_query);		
	$k++;
	}
	else{
	$type= 0;
	$msg='Invalid Attached Document Format';	    
	}
	}
	}
	}
		$all['section_id'] = $section_id;
		echo json_encode($all);
		?>
		

	