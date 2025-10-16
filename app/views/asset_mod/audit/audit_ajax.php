<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

$crud= new crud('asset_audit_info');
$str = $_POST['data'];
$data=explode('##',$str);
$info = find_all_field('asset_register','','id="'.$data[0].'"');
$ndata = explode("#>",$data[1]);

$_POST['asset_id']  =$info->asset_id;
$_POST['item_id']   =$info->item_id;
$_POST['serial_no'] =$info->serial_no;
$_POST['audit_date']=date('Y-m-d');
$_POST['serial_no'] =$info->serial_no;
$_POST['audit_note']=$ndata[0];
$_POST['entry_at']  =date('Y-m-d H:i:s');
$_POST['entry_by']  =$_SESSION['user']['id'];
$_POST['group_for']  =$ndata[1];

$id = $crud->insert();

echo 'Saved';
?>