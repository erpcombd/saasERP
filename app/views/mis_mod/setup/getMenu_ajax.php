<?php

session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');



$str = $_POST['data'];

$data=explode('##',$str);

$feature_id=$data[0];

?>

<select name="menu_id" required id="menu_id"  tabindex="7" >
						<option></option>

                      		<? foreign_relation('user_page_manage','id','page_name',$menu_id,'feature_id="'.$feature_id.'"');?>
                   		 </select>