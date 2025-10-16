<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

echo $str = $_POST['data'];

$data=explode('##',$str);
$type=$data[0];
echo 'Disposed';
?>