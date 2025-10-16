<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";



$pdata = file_get_contents("php://input");
$data = json_decode($pdata, true);

$attachmentid = $data['attachmentid'];
$masterId = $data['masterId'];
$vendor_id = $data['vendor_id'];
$section_id = $data['section_id'];


$sqlDelete = "DELETE FROM evaluation_documents_information WHERE id = ?";
$stmtDelete = $conn->prepare($sqlDelete);
if ($stmtDelete === false) {
    die('Error preparing statement: ' . $conn->error);
}

$stmtDelete->bind_param("i", $attachmentid);
$stmtDelete->execute();
if ($stmtDelete->error) {
    die('Error executing statement: ' . $stmtDelete->error);
}

$stmtDelete->close();

$sqlSelect = "SELECT * FROM evaluation_documents_information WHERE rfq_no = ? AND vendor_id = ? AND section_id = ?";
$stmtSelect = $conn->prepare($sqlSelect);
$stmtSelect->bind_param("iss", $masterId, $vendor_id, $section_id);
$stmtSelect->execute();
$result = $stmtSelect->get_result();

$responses = []; 

if ($result->num_rows > 0) {
  
    while ($row = $result->fetch_assoc()) {
     
        $responses[] = array(
            "original_name" => $row['original_name'],
            "new_name" => $row['new_name'],
            "rfq_no" => $row['rfq_no'],
            "tr_from" => $row['tr_from'],
			"section_id" => $row['section_id'],
			"vendor_id" => $row['vendor_id'],
            "entry_by" => $row['entry_by'],
            "attachment_id" => $row['id']
        );
    }
} else {
  
    $responses = array();
}


echo json_encode($responses);


mysqli_close($conn);
?>
