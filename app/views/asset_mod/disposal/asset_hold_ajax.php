<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

$all['msg'] = $_POST['id'];
$update = 'update asset_disposal_info set status="Hold" where id="'.$_POST['id'].'"';
db_query($update);
$all['msg'] = 'Success! Hold';
echo json_encode($all)
?>