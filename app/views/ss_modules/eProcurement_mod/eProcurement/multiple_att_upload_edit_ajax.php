<?php
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
// ini_set('display_errors','1');
// ini_set('display_startup_errors','1');
// error_reporting(E_ALL);

$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

$rfq_no  = $_SESSION['rfq_no'];

$unique='id';
$table_master = 'rfq_doc_details';
$Crud   = new Crud($table_master);
$_POST['rfq_no'] = $rfq_no;
if($rfq_no>0){

$_POST['id'] = $data['doc_id_individual'];
$_POST['terms'] = $data['section_terms'];
$_POST['section_type'] = $data['section_type'];
$_POST['is_required'] = $data['is_required'];
$_POST['att_response'] = $data['att_response'];
$_POST['section_name'] = $data['section_name'];

$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
 $Crud->update('id');


    // $r_file_name = $_FILES['files']['name'];
	// $r_file_size = $_FILES['files']['size'];
	// $r_file_temp = $_FILES['files']['tmp_name'];
	// if($r_file_size>0){
    foreach ($data['files'] as $file) {


    $base64_data = $file['data'];
    $file_name = $file['name'];
    $file_type = $file['type'];

    // Remove data URI scheme (e.g., 'data:image/jpeg;base64,')
    $base64_data = preg_replace('/^data:[\w\/\-\+]+;base64,/', '', $base64_data);
    // $random_eprocfiles_name = uniqid() . '.' . pathinfo($file_name, PATHINFO_EXTENSION);

	// $r_div[$r] = explode('.', $r_file_name[$r]);
	$r_file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
	
	$allowed = array('jpg','jpeg','png','pdf', 'docx', 'eml', 'xlsx', 'xls', 'msg','txt','csv','xlsm','zip','rar');
	// if(in_array($r_file_ext,$allowed)){
	$r_unique_image = uniqid() . '.' . pathinfo($file_name, PATHINFO_EXTENSION);
	if (preg_match('/[\'^£$%&*}{@#~?><>,|=+¬]/', $file_name)) {
		// Replace special characters with underscore
		$file_name = preg_replace('/[\'^£$%&*}{@#~?><>,|=+¬]/', '_', $file_name);
	  }
	$orginal_file_name = $file_name;
	$r_uploaded_image = "../../../../public/uploads/doc_section/".$r_unique_image;
	// $dd = move_uploaded_file($r_file_temp[$r], $r_uploaded_image);
    $file_data = base64_decode($base64_data);
    file_put_contents($r_uploaded_image, $file_data);

	$ii_query = 'INSERT INTO `rfq_documents_information`(`tr_from`, `rfq_no`, `folder_path`,`new_name`,`original_name`,`section_id`,`entry_at`,`entry_by`) VALUES ("multiple_doc_section","'.$rfq_no.'","../../../../public/uploads/doc_section/","'.$r_unique_image.'","'.$orginal_file_name.'","'.$data['doc_id_individual'].'","'.date('Y-m-d H:i:s').'","'.$_SESSION['user']['id'].'")';
	$new_pp = db_query($ii_query);		
	$k++;
	// }
	// else{
	// $type= 0;
	// $msg='Invalid Attached Document Format';	    
	// }
	}
	// }
	}
		$all['section_id'] = "";
		echo json_encode($all);
		?>