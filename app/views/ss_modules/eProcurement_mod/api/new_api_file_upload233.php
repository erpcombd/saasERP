<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";


// Retrieve JSON data from the request body
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

$rfq_no = $data['rfq_no'];
$tr_from = $data['tr_from'];
$entry_by = $data['entry_by'];
$section_id = isset($data['section_id']) ? $data['section_id'] : '';

$responses = array();

$upload_dir = SERVER_ROOT."public/uploads/";
$tr_from_dir = $upload_dir . $tr_from . '/';

if (!is_dir($tr_from_dir)) {
    mkdir($tr_from_dir, 0777, true);
}
$max_file_size = 10 * 1024 * 1024;
foreach ($data['files'] as $file) {
    
    // Decode Base64 data and save the file
    $base64_data = $file['data'];
    $file_name = $file['name'];
    $file_type = $file['type'];

    // Remove data URI scheme (e.g., 'data:image/jpeg;base64,')
    $base64_data = preg_replace('/^data:[\w\/\-\+]+;base64,/', '', $base64_data);
    $random_eprocfiles_name = uniqid() . '.' . pathinfo($file_name, PATHINFO_EXTENSION);
    $file_size = strlen(base64_decode($base64_data));
    if ($file_size > $max_file_size) {
        $responses[] = array(
            "status" => "error",
            "message" => "File '$file_name' exceeds the maximum allowed size (10MB).",
            "original_name" => $file_name
        );
        continue; // Skip this file
    }

    // Decode Base64 data and save to file
    $file_path = $tr_from_dir . $random_eprocfiles_name;
    $file_data = base64_decode($base64_data);
    file_put_contents($file_path, $file_data);

    // Simulate successful upload and database insertion
   
    $attachment_id = insertIntoDatabase($rfq_no, $tr_from, $file_name, $random_eprocfiles_name, $entry_by, $section_id);

    if ($attachment_id) {
        $responses[] = array(
            "status" => "success",
            "message" => "File uploaded successfully.",
            "original_name" => $file_name,
            "new_name" => $random_eprocfiles_name,
            "rfq_no" => $rfq_no,
            "tr_from" => $tr_from,
            "entry_by" => $entry_by,
            "section_id" => $section_id,
            "attachment_id" => $attachment_id
        );
    } else {
        $responses[] = array("status" => "error", "message" => "Error inserting file into database.");
    }
}

// Respond with JSON
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
