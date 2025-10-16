<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$str = $_POST['data'];
$data=explode('##',$str);

$total = find_a_field('rfq_evaluation_section_child','sum(average_percent)','section_id="'.$data[0].'" and rfq_no="'.$_SESSION['rfq_no'].'"');
echo $total;
?>



