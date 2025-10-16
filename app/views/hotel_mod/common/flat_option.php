<?php
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
require "../common/my.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['ledger'];
$con="select a.fid,a.flat_no from tbl_flat_info a,tbl_building_info b where a.build_code=b.build_code and a.proj_code=b.proj_code and b.build_code=".$str;
?>
<select name="flat" id="flat">
<?
join_relation($con);?>
</select>