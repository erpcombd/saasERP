<?php
session_start();
require_once "../../../assets/support/inc.all.php";
$details_id = $_REQUEST['details_id'];
$table_master = "sale_pos_master";
$table_details = "sale_pos_details";
$dsql = "delete from `$table_details` where id = '$details_id'";
$verify = mysql_query($dsql);
echo json_encode("yes")	;

?>