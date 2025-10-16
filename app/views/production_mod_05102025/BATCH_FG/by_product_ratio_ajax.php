<?php


session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$itemcode=$_POST['fg_code'];



$a2="select rate_ratio from scrap_rate_formula where scrap_id='".$itemcode."' ";

$query=mysql_query($a2);

$data=mysql_fetch_assoc($query);


echo json_encode($data);


?>




