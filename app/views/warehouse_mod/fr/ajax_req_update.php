<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$req_no      = $_REQUEST['req_no'];
$id         = $_REQUEST['item_id'];

$qty         = $_REQUEST['ptotal'];


	
$uu = 'UPDATE requisition_fg_order 
SET qty = "'.$qty.'"
WHERE id="'.$id.'" and req_no = "'.$req_no.'"';



db_query($uu);
	
	
echo 'Done';
	


?>