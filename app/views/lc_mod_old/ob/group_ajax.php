<?php
//
require "../../support/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$group_id = $data[0];

?>
<select class="chosen-select"  id="sub_group" name="sub_group" readonly="readonly" style="width:250px;height:23px;"  required>
<option></option>
<?=foreign_relation('item_sub_group','sub_group_id','sub_group_name','',' group_id =  '.$group_id)?>
</select>
