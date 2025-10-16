<?php
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
require "../common/my.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['ledger'];
?>
<select name="building" id="building">
<? foreign_relation('tbl_building_info','proj_code','proj_name',$proj_code);?>
</select>