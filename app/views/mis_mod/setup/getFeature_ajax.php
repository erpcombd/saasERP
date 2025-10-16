<?php

session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');



$str = $_POST['data'];

$data=explode('##',$str);

$module_id=$data[0];

?>

<select name="feature_id" required id="feature_id"  tabindex="7" onchange="getMenu(this.value)">
						<option></option>

                      		<? foreign_relation('user_feature_manage','id','feature_name',$feature_id,'module_id="'.$module_id.'"');?>
                   		 </select>