<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// run a query to delete the note
$sql = "DELETE FROM pf_status WHERE PF_STATUS_ID = '".$_GET['asign_id']." '";
$result = db_query($sql);
if($result){
header('location:pf_status.php');
}else{
echo 'error';  
}

?>