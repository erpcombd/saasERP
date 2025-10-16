<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


 $moh_per = $_POST['moh_per'];
 $aoh_per = $_POST['aoh_per'];

$all['moh_per'] = $moh_per;
$all['aoh_per'] = $aoh_per;
$all['soh_per'] = 100-$moh_per-$aoh_per;

echo json_encode($all);

?>

