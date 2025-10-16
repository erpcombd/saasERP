<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

$str = $_POST['data'];

$data=explode('##',$str);
$type=$data[0];
if($type=='User'){
?>
<select id="user_id" name="user_id" class="form-control">
<option></option>
										<? foreign_relation('user_activity_management', 'user_id', 'fname', $_POST['user_id'], '1') ?>

									</select>
									<? }else{?>
									
								<select name="department_name" type="text" id="department_name" class="form-control" >
								<option></option>
								<? foreign_relation('fixed_asset_issue_master a, department d','d.DEPT_ID','d.DEPT_DESC',$department_name,'a.department_name=d.DEPT_ID  and a.department_name!="" group by a.department_name');?>
								
								</select>
								<? }?>