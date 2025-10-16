<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";



$pdata = file_get_contents("php://input");
$data = json_decode($pdata, true);

$attachmentid = $data['attachmentid'];
$masterId = $data['masterId'];
$trFrom = $data['trFrom'];
$entryBy = $data['entryBy'];


$sqlDelete = "DELETE FROM rfq_documents_url_information WHERE documents_url_id= ?";
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




$sqlSelect = "SELECT * FROM rfq_documents_url_information WHERE rfq_no = ? AND tr_from = ? AND entry_by = ? AND attachment_text IS NOT NULL";
$stmtSelect = $conn->prepare($sqlSelect);
$stmtSelect->bind_param("iss", $masterId, $trFrom, $entryBy);
$stmtSelect->execute();
$result = $stmtSelect->get_result();

$responses = [];

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
     
        $responses[]= array(

            "rfq_no" => $row['rfq_no'],
            "tr_from" => $row['tr_from'],
            "entry_by" => $row['entry_by'],
            "attachment_id" => $row['documents_url_id'],
            "text_data" => $row['attachment_text'],
        );
    }
} else {
       $responses = array();
}


echo json_encode($responses);


mysqli_close($conn);
?>
