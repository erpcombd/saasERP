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

$upload_dir = SERVER_ROOT . "public/uploads/";
$tr_from_dir = $upload_dir . $tr_from . '/';

if (!is_dir($tr_from_dir)) {
    mkdir($tr_from_dir, 0777, true);
}

$max_file_size = 50 * 1024 * 1024;

// Allowed file extensions
$allowed = array(
    'jpg', 'jpeg', 'jpe', 'jfif', 'png', 'gif', 'bmp', 'dib', 'tiff', 'tif', 'svg', 'svgz', 'webp', 'heif', 
    'heic', 'psd', 'pspimage', 'ppm', 'xbm', 'xpm', 'ico', 'pdf', 'fdf', 'xfdf', 'pdfa', 'pdfx', 'pdfe', 
    'pdfua', 'doc', 'docx', 'docm', 'dot', 'dotx', 'dotm', 'rtf', 'txt', 'odt', 'wps', 'wbk', 'wiz', 
    'xls', 'xlsx', 'xlsm', 'xlsb', 'xltx', 'xltm', 'xlam', 'xla', 'xlm', 'xlw', 'xlc', 'xlb', 'csv', 
    'prn', 'ods', 'dif', 'symlink', 'ppt', 'pptx', 'pptm', 'pps', 'ppsx', 'ppsm', 'pot', 'potx', 
    'potm', 'ppam', 'odp', 'thmx', 'ppz', 'eml', 'msg', 'zip', 'rar', '7z', 'tar', 'sit', 'ar', 'iso'
);

foreach ($data['files'] as $file) {
    $file_name = $file['name'];
    $base64_data = $file['data'];
    
    // Get file extension
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    // Check if the extension is allowed
    if (!in_array($file_ext, $allowed)) {
        $responses[] = array(
            "status" => "error",
            "message" => "The file '$file_name' extension is not supported.",
            "original_name" => $file_name
        );
        continue; // Skip this file
    }

    // Remove data URI scheme (e.g., 'data:image/jpeg;base64,')
    $base64_data = preg_replace('/^data:[\w\/\-\+]+;base64,/', '', $base64_data);
    $random_eprocfiles_name = uniqid() . '.' . $file_ext;
    $file_size = strlen(base64_decode($base64_data));

    if (preg_match('/[\'^£$%&*}{@#~?><>,|=+¬]/', $file_name)) {
        $responses[] = array(
            "status" => "error",
            "message" => "File '$file_name' contains special characters and cannot be uploaded. These characters are not allowed.",
            "original_name" => $file_name
        );
        continue; // Skip this file
    }

    // Save the decoded file
    $file_path = $tr_from_dir . $random_eprocfiles_name;
    $file_data = base64_decode($base64_data);
    file_put_contents($file_path, $file_data);

    // Simulate database insertion
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
        $responses[] = array(
            "status" => "error",
            "message" => "Error inserting file into database."
        );
    }
}

// Respond with JSON
echo json_encode($responses);
mysqli_close($conn);

function insertIntoDatabase($rfq_no, $tr_from, $original_name, $new_name, $entry_by, $section_id = '') {
    global $conn;
    $query = "INSERT INTO rfq_documents_information (rfq_no, tr_from, folder_path, original_name, new_name, entry_by, entry_at, section_id) 
              VALUES ('$rfq_no', '$tr_from', '../../../../uploaded_documents/', '$original_name', '$new_name', '$entry_by', NOW(), '$section_id')";
    $result = db_query($query);
    return $result ? mysqli_insert_id($conn) : false;
}
?>
