<?php
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
require "../common/my.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['ledger'];
$con="select a.flat_no,a.flat_no from tbl_flat_info a where a.build_code=1 and a.proj_code=".$str;
?>
<select name="flat_no" id="flat_no">
<?
join_relation($con);?>
</select>