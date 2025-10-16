<?php
session_start();
require "../../config/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['data'];
$data=explode('##',$str);
?>
<select name="district_code" id="district_code" style="width:150px;" onchange="getData2('ajax_thana.php', 'thana', this.value,  this.value)">
<? foreign_relation('location','l_id','l_name',$district_code,"l_type='DT' and l_sub_main='".$data[0]."' order by l_name");?>
</select>