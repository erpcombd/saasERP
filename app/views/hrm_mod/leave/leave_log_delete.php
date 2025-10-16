<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// run a query to delete the note
$sql = "DELETE FROM hrm_leave_info WHERE id = '".$_GET['asign_id']." '";
$result = db_query($sql);

/*$sql2 = "DELETE FROM 

hrm_att_summary WHERE leave_id = '".$_GET['asign_id']." '";
$result = db_query($sql2);*/


          $sql2 = "update hrm_att_summary set leave_id='', leave_type='',
          leave_reason='',leave_duration='', leave_approved_by='',
          leave_entry_at='', leave_entry_by='' where leave_id=" . $_GET['asign_id'];
          $result = db_query($sql2);
		  
		  

if($result){
header('location:leave_entry.php');
}else{
echo 'error';  
}

?>