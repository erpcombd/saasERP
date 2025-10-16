<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";








$rfq_no = $_POST['rfq_no'];
$tr_from = $_POST['tr_from'];
$entry_by = $_POST['entry_by'];

$query_delete = "DELETE FROM rfq_documents_information WHERE rfq_no = '$rfq_no' AND tr_from = '$tr_from'";
$result_delete = db_query($query_delete);


$responses = array();


$upload_dir = SERVER_ROOT."public/uploads/";


$tr_from_dir = $upload_dir . $tr_from . '/';
if (!is_dir($tr_from_dir)) {
    mkdir($tr_from_dir, 0777, true); 
}


foreach ($_FILES['eprocfiles']['tmp_name'] as $key => $tmp_name) {
    $original_eprocfiles_name = $_FILES['eprocfiles']['name'][$key];
    $eprocfiles_extension = pathinfo($original_eprocfiles_name, PATHINFO_EXTENSION);
    $eprocfiles = $_FILES['eprocfiles']['tmp_name'][$key];
    
    if (!empty($eprocfiles)) {
        $random_eprocfiles_name = uniqid() . '.' . $eprocfiles_extension;
        $eprocfiles_path = $tr_from_dir . $random_eprocfiles_name;
        
        if (move_uploaded_file($eprocfiles, $eprocfiles_path)) {
            
            $query = "INSERT INTO rfq_documents_information (rfq_no,tr_from,folder_path,original_name,new_name,entry_by,entry_at) VALUES ('$rfq_no','$tr_from','../../../../uploaded_documents/','$original_eprocfiles_name','$random_eprocfiles_name','$entry_by', NOW())";
            $result = db_query($query);
            
            if($result) {
                $attachment_id = mysqli_insert_id($conn);
                
                $responses[] = array(
                    "status" => "success", 
                    "message" => "eprocfiles uploaded successfully.", 
                    "original_name" => $original_eprocfiles_name,
                    "new_name" => $random_eprocfiles_name,
                    "rfq_no" => $rfq_no,
                    "tr_from" => $tr_from,
                    "entry_by" => $entry_by,
                    "attachment_id"=>$attachment_id
                );
            } else {
                
                $responses[] = array("status" => "error", "message" => "Error inserting original eprocfiles name into database.");
            }

        } else {
            $responses[] = array(
                "status" => "error", 
                "message" => "Error uploading eprocfiles '$original_eprocfiles_name'."
            );
        }
    } else {
        $responses[] = array(
            "status" => "error", 
            "message" => "No eprocfiles uploaded."
        );
    }
}


echo json_encode($responses);


mysqli_close($conn);
?>
