<?php
require_once "../../../controllers/routing/layout.top.php";
$current_page = "events";
$title = 'eProcurement Entry';
do_calander("#f_date");
do_calander("#t_date");
do_datatable('rfq_table');
// unset($_SESSION['rfq_no']);
// unset($_SESSION['rfq_version']);
// unset($_SESSION['master_status']);

// ini_set('display_errors','1');
// ini_set('display_startup_errors','1');
// error_reporting(E_ALL);

ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);

$rfq_no = $_SESSION['rfq_no'];
$rfq_version_name=find_a_field('rfq_master','rfq_version','rfq_no="'.$_SESSION['rfq_no'].'" ');

$zipDir = "../../../../public/uploads/zip";
if (!is_dir($zipDir)) {
    
    mkdir($zipDir, 0755, true);
}

// Create a unique name for the zip file
$zipFileName2 = 'rfq_files_'.$rfq_version_name.'_' .  date('Y-m-d_H-i-s') . '.zip';
$zipFileName = $zipDir.'/'.$zipFileName2;

// Initialize ZipArchive
$zip = new ZipArchive();
if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
 $sql = 'select r.*,v.vendor_name,v.vendor_id,m.status as m_status, r.response_name 
    from rfq_vendor_response r, vendor v, rfq_master m 
    where r.rfq_no = m.rfq_no and r.vendor_id=v.vendor_id and r.status like "SUBMITED" and r.rfq_no="'.$_SESSION['rfq_no'].'"';
    
    
    $qry = db_query($sql);
    while ($item = mysqli_fetch_object($qry)) {
        $sql_vendor_response = 'SELECT * FROM rfq_vendor_response WHERE rfq_no = "' . $rfq_no . '" AND vendor_id = "' . $item->vendor_id . '" AND status = "SUBMITED"
                                ORDER BY id DESC 
                                LIMIT 1;';
        $qry_vendor_response = db_query($sql_vendor_response);
        $result_vendor_response = mysqli_fetch_object($qry_vendor_response);
        $vendor_section_id = $result_vendor_response->id;

        // Create folder for each vendor
        $vendor_folder = $item->vendor_name . '_Files';
        $zip->addEmptyDir($vendor_folder);

        // Create subfolders inside the vendor folder
        $subfolders = ['general', 'technical', 'commercial'];
        foreach ($subfolders as $subfolder) {
            $zip->addEmptyDir("$vendor_folder/$subfolder");
        }

        // Fetch files from the database
        $sql2 = 'SELECT * FROM `rfq_documents_information` WHERE `section_id` LIKE "' . $vendor_section_id . '" AND entry_by="'.$item->vendor_id.'"';
        $qry2 = db_query($sql2);

        // Add files to the appropriate subfolder
        while ($res2 = mysqli_fetch_object($qry2)) {
          $file_doc_section_id = $res2->tr_from;

            preg_match('/\d+/', $file_doc_section_id, $matches);
             $file_doc_section_id_number = $matches[0];

            // Fetch the section_type from rfq_doc_details table
            $sql3 = 'SELECT section_type FROM `rfq_doc_details` WHERE id = ' . $file_doc_section_id_number;
            $qry3 = db_query($sql3);
            $res3 = mysqli_fetch_object($qry3);
            $section_type = $res3->section_type;

            $file_name = $res2->new_name;
            $file_path = "../../../../public/uploads/" . $res2->tr_from . "/" . $file_name;
            if (file_exists($file_path)) {
                $new_file_name = $res2->original_name;
                // Determine the subfolder based on section_type
                if ($section_type == 'general') {
                    $subfolder = 'general';
                } elseif ($section_type == 'technical') {
                    $subfolder = 'technical';
                } elseif ($section_type == 'commercial') {
                    $subfolder = 'commercial';
                } else {
                    // Default to general if no match is found
                    $subfolder = 'general';
                }
                $zip->addFile($file_path, "$vendor_folder/$subfolder/$new_file_name");
            }
        }
    }
    // Close the zip archive
    $zip->close();
} else {
    echo 'Failed to create zip file.';
}

// Provide a link to download the zip file
echo '<a href="'.$zipFileName.'" download>Downloaded All Files as ZIP</a>';

?>

<script>
// Trigger download when page loads
window.onload = function() {
    var downloadLinks = document.querySelectorAll('a[download]');
    downloadLinks.forEach(function(link) {
        link.click();
        // setTimeout(function() {
         <?//unlink($zipFileName);?>
        //     }, 1000000);
       window.location.href="/esourcing/app/views/eProcurement_mod/eProcurement/eprocurement_entry_entry.php?tab6";
    });
};
</script>


<?php
require_once "../../../controllers/routing/layout.bottom.php";
?>
