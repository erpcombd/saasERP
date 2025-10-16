<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// run a query to delete the note
$sql = "DELETE FROM hrm_iom_info WHERE id = '".$_GET['asign_id']." '";
$result = db_query($sql);

/*$sql2 = "DELETE FROM 

hrm_att_summary WHERE leave_id = '".$_GET['asign_id']." '";
$result = db_query($sql2);*/


          $sql2 = "update hrm_att_summary set iom_id='', iom_type='',
          iom_sl_no='',iom_start_time='', iom_end_time='',iom_reason='',
          iom_entry_at='', iom_entry_by='' where iom_id=" . $_GET['asign_id'];
          $result = db_query($sql2);
		  
		  

if($result){
header('location:iom_entry.php');
}else{
echo 'error';  
}

?>