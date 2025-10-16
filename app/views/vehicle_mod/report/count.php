<?php
session_start();
require_once "../../../assets/support/inc.all.php";

//$sql = 'SELECT jv_no, count(DISTINCT tr_no) as con FROM `journal` WHERE count(distinct tr_no)>0 and jv_no >201508000000 GROUP BY jv_no';
$sql = 'SELECT jv_no, count(DISTINCT tr_no) FROM `journal` WHERE jv_no >201508000000 GROUP BY jv_no';
$query = mysql_query($sql);
while($data=mysql_fetch_object($query)){
if($data->con>1)
$count++;
}
echo $count;
?>