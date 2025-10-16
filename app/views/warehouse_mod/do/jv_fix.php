<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$sql="select jv_no,tr_no,tr_from,jv_date from secondary_journal b where jv_no = 1 group by tr_no,tr_from,jv_date";
$data=db_query($sql);
while($info=mysqli_fetch_object($data)){

$jv=next_journal_sec_voucher_id(date('Y-m-d',$info->jv_date));
echo $usql = 'update secondary_journal set jv_no="'.$jv.'" where jv_no=1 and tr_no="'.$info->tr_no.'" and tr_from="'.$info->tr_from.'" and jv_date="'.$info->jv_date.'"';
echo '<br>';
db_query($usql);
}


?>

