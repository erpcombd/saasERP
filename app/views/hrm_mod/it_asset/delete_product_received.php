<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// run a query to delete the note
$sql = "DELETE FROM product_asign WHERE asign_id = '".$_GET['asign_id']." '";
$result = db_query($sql);
if($result){
header('location:product_received.php');
}else{
echo 'error';  
}

?>