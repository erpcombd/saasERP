<?php
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$rfq_no  = $_SESSION['rfq_no'];

// Check if JSON data is received
$postData = json_decode(file_get_contents("php://input"), true);

// Check if RFQ number is valid
if($rfq_no > 0 && !empty($postData)) {
    // Assign RFQ number and other data
    $_POST['rfq_no'] = $rfq_no;
    $_POST['terms'] = $postData['section_terms'];
    $_POST['entry_at'] = date('Y-m-d H:i:s');
    $_POST['entry_by'] = $_SESSION['user']['id'];
    
    // Insert section data into database
    $table_master = 'rfq_doc_details';
    $Crud = new Crud($table_master);
    $section_id = $Crud->insert();
    
    // Handle file uploads
    if(isset($postData['files'])) {
        foreach($postData['files'] as $file) {
            $r_file_name = $file['name'];
            $r_file_size = $file['size'];
            $r_file_temp = $file['tmp_name'];
            
            if($r_file_size > 0) {
                $r_div = explode('.', $r_file_name);
                $r_file_ext = strtolower(end($r_div));
                
                $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'docx', 'eml', 'xlsx', 'xls', 'msg', 'txt', 'csv', 'xlsm', 'zip', 'rar');
                
                if(in_array($r_file_ext, $allowed)) {
                    $r_unique_image = uniqid().'.'.$r_file_ext;
                    $orginal_file_name = $r_div[0].'.'.$r_file_ext;
                    $r_uploaded_image = "../../../../public/uploads/doc_section/".$r_unique_image;
                    
                    if(move_uploaded_file($r_file_temp, $r_uploaded_image)) {
                        $ii_query = 'INSERT INTO `rfq_documents_information`(`tr_from`, `rfq_no`, `folder_path`,`new_name`,`original_name`,`section_id`,`entry_at`,`entry_by`) VALUES ("multiple_doc_section","'.$rfq_no.'","../../../../public/uploads/doc_section/","'.$r_unique_image.'","'.$orginal_file_name.'","'.$section_id.'","'.date('Y-m-d H:i:s').'","'.$_SESSION['user']['id'].'")';
                        $new_pp = db_query($ii_query);
                    } else {
                        // Handle file upload failure
                        $type = 0;
                        $msg = 'Failed to upload file';
                    }
                } else {
                    // Handle invalid file format
                    $type = 0;
                    $msg = 'Invalid Attached Document Format';
                }
            }
        }
    }
    
    // Prepare response
    $response['section_id'] = $section_id;
    echo json_encode($response);
} else {
    // Handle invalid or empty data
    // You can return an error response or perform other actions as needed
}
?>
