<?php

session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');



$str = $_POST['data'];

$data=explode('##',$str);

$user=$data[0];
$role=$data[1];
$crud = new crud('user_role_access');
$_POST['user_id'] = $data[0];
$_POST['role_id'] = $data[1];
$_POST['entry_by'] = $_SESSION['user']['id'];
$_POST['entry_at'] = date('Y-m-d H:i:s');
$inserted=$crud->insert();
if($inserted){
?>
<input type="button" name="btn"  value="Saved" class="btn btn-primary" />
<? }else{?>
<input type="button" name="btn"  value="Failed" class="btn btn-danger" />
<? } ?>
