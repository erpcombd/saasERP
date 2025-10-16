<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

$crud= new crud('asset_disposal_info');
 $str = $_POST['data'];

 $data=explode('##',$str);

$_POST['asset_id']=$data[0];


$info = explode('#',$data[1]);

$_POST['current_value'] = $info[0];
$_POST['item_id'] = $info[1];
$_POST['total_dpc'] = $info[2];
$_POST['reason'] = $info[3];
$_POST['po_value'] = $info[4];
$_POST['group_for'] = $info[6];
$_POST['disposal_date'] = date('Y-m-d');
$_POST['entry_by'] = $_SESSION['user']['id'];
$_POST['entry_at'] = date('Y-m-d H:i:s');

$id = $crud->insert();

if($id>0){
echo 'Request Applied';
}else{
echo 'Try Again!';
}
?>