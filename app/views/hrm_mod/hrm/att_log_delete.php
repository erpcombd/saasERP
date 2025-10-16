<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$attedance = find_all_field('hrm_attdump','','sl="'.$_GET['asign_id'].'"');

 $sql="INSERT INTO attendance_delete_log (ztime, bizid, xdate,xtime,EMP_CODE,latitude,longitude, entry_by , delete_by)

VALUES ('".$attedance->ztime."', '".$attedance->bizid."', '".$attedance->xdate."', '".$attedance->xtime."', '".$attedance->EMP_CODE."', '".$attedance->latitude."','".$attedance->longitude."',
'".$attedance->entry_by."' , '".$_SESSION['user']['id']."')";



$query=db_query($sql);





// run a query to delete the note
$sql = "DELETE FROM hrm_attdump WHERE sl = '".$_GET['asign_id']." '";
$result = db_query($sql);
if($result){
header('location:atendance_delete_panel.php');
}else{
echo 'error';  
}

?>