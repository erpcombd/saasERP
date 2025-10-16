<?php
session_start();
//
//require "../../config/inc.all.php";
require "../../../warehouse_mod/support/inc.all.php";
// ::::: Start Edit Section ::::: 
$group_id=find_all_field('personnel_basic_info','','PBI_ID='.$_REQUEST['emp_id']);

?>

<input type="hidden" name="group_id" id="group_id" style="width:200px;" value="<?=$group_id->PBI_ORG?>"  />
<input type="hidden" name="user_name" id="user_name" style="width:200px;" value="<?=$group_id->PBI_NAME?>"  />