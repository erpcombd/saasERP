<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";

$rfq_no = $_POST['rfq_no'];
$tr_from = $_POST['tr_from'];
$entry_by = $_POST['entry_by'];
$section_id = $_POST['section_id'];

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
            $attachment_id = insertIntoDatabase($rfq_no, $tr_from, $original_eprocfiles_name, $random_eprocfiles_name, $entry_by, $section_id);

            if ($attachment_id) {
                $responses[] = array(
                    "status" => "success",
                    "message" => "eprocfiles uploaded successfully.",
                    "original_name" => $original_eprocfiles_name,
                    "new_name" => $random_eprocfiles_name,
                    "rfq_no" => $rfq_no,
                    "tr_from" => $tr_from,
                    "entry_by" => $entry_by,
					"section_id" => $section_id,
                    "attachment_id" => $attachment_id
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

function insertIntoDatabase($rfq_no, $tr_from, $original_name, $new_name, $entry_by, $section_id='')
{
    global $conn;
    $query = "INSERT INTO rfq_documents_information (rfq_no,tr_from,folder_path,original_name,new_name,entry_by,entry_at,section_id) VALUES ('$rfq_no','$tr_from','../../../../uploaded_documents/','$original_name','$new_name','$entry_by', NOW(), '$section_id')";
    $result = db_query($query);
    return $result ? mysqli_insert_id($conn) : false;
}
?>
