<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE."core/init.php");
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
 
$str = $_POST['data'];
$data = explode('##', $str);
$item = explode('#>', $data[0]);

$item_id = isset($item[2]) ? $item[2] : '';
$status = $data[1];   
$record_id = $item[0];  
if (empty($record_id) || empty($status)) {
    echo '<span style="color: red;">Invalid data received</span>';
    exit;
}
 
$status = trim($status);
$record_id = (int)$record_id;
 
if (!in_array($status, ['Active', 'In-Active'])) {
    echo '<span style="color: red;">Invalid status value</span>';
    exit;
}
 
$update = "UPDATE salary_months SET status='".$status."' WHERE id='".$record_id."'";
$updated = db_query($update);

if ($updated) {
    echo '<span class="btn1 btn1-bg-submit">Saved Complete</span>';
} else {
    echo '<span style="color: red;">Update failed</span>';
}

?>