<?php
session_start();
require_once "../../../assets/support/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['data'];
$data=explode('##',$str);

$field='vendor_id'; $table='vendor';$get_field='vendor_id';$show_field='vendor_name';
$group_for = find_a_field('user_group','id','id='.$data[0].' ');
?>

<select id="vendor_id" name="vendor_id" required>
<? foreign_relation($table,$get_field,$show_field,$$field,"vendor_type=1 and group_for='".$group_for."' order by vendor_name");?>
</select>