<?php
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
require "../common/my.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['ledger'].'%';

$res='select party_code,party_code,party_name,per_add,per_tel from tbl_party_info where party_name like \''.$str.'\' limit 5';
echo ajax_report($res,'../../common/rec_no1.php','gid');
?>
	