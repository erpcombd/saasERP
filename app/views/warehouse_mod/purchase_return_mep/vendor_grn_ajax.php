<?php


// $tst = 'omar';

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$group_for=$_POST['group_for'];
 

?>

<? echo '<option></option>'; ?>
<? foreign_relation('vendor','vendor_id','concat(vendor_name," (",vendor_id," )")',$vendor_id,'1 and group_for='.$group_for.'');?>







