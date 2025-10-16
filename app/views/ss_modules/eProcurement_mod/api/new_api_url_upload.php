<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";




$rfq_no = $_POST['rfq_no'];
$attachment_url = $_POST['attachmenturlinput'];
$tr_from = $_POST['tr_from'];
$entry_by = $_POST['entry_by'];
$section_id = $_POST['section_id'];

$query = "INSERT INTO rfq_documents_url_information (rfq_no,tr_from,attachment_url,entry_by,entry_at,section_id) 
VALUES ('$rfq_no','$tr_from','$attachment_url','$entry_by', NOW(),'$section_id')";
$result = db_query($query);

$response = []; 

if($result) {
    $attachment_id = mysqli_insert_id($conn);


    
    $response = array(
        "rfq_no" => $rfq_no,
        "tr_from" => $tr_from,
        "entry_by" => $entry_by,
		"section_id" => $section_id,
        "attachment_id" => $attachment_id,
        "status" => "success", 
        "message" => "URL successfully submitted", 
        "url_data" => $attachment_url
    );
} else {
    
    $response = array(
    );
}


echo json_encode($response);


mysqli_close($conn);
?>
