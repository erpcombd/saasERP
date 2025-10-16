<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";

// ini_set('display_errors','1');
// ini_set('display_startup_errors','1');
// error_reporting(E_ALL);


$rfq_no = $_POST['rfq_no'];
$attachment_text = $_POST['attachmenttextinput'];
$_POST['attachment_text'] = $_POST['attachmenttextinput'];
$tr_from = $_POST['tr_from'];
$entry_by = $_POST['entry_by'];
$section_id = $_POST['section_id'];

$table_master='rfq_documents_url_information';

// $query = "INSERT INTO rfq_documents_url_information (rfq_no,tr_from,attachment_text,entry_by,entry_at,section_id) 
// VALUES ('".$rfq_no."','$tr_from','$attachment_text','$entry_by', NOW(),'$section_id')";
// $result = db_query($query);
$Crud   = new Crud($table_master);
$Crud->insert();

$response = []; 

if($Crud) {

    $attachment_id = mysqli_insert_id($conn);


    
    $response = array(
        "rfq_no" => $rfq_no,
        "tr_from" => $tr_from,
        "entry_by" => $entry_by,
        "attachment_id" => $attachment_id,
		"section_id" => $section_id,
        "status" => "success", 
        "message" => "URL successfully submitted", 
        "text_data" => $attachment_text
    );
} else {
    
    $response = array(
    );
}


echo json_encode($response);


mysqli_close($conn);
?>
