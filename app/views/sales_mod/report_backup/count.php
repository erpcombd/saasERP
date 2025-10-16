<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

//$sql = 'SELECT jv_no, count(DISTINCT tr_no) as con FROM `journal` WHERE count(distinct tr_no)>0 and jv_no >201508000000 GROUP BY jv_no';
$sql = 'SELECT jv_no, count(DISTINCT tr_no) FROM `journal` WHERE jv_no >201508000000 GROUP BY jv_no';
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
if($data->con>1)
$count++;
}
echo $count;
?>