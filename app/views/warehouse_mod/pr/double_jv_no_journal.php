<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$sql = 'SELECT jv_no , count(distinct tr_no) as tr_count,tr_no,tr_from
FROM `journal`
WHERE  1 group by jv_no';

$query = db_query($sql);
while($data = mysqli_fetch_object($query))
{
	if($data->tr_count>1)
	{
	$date_format = substr($data->jv_no,0,8);
	$new_jv_no = next_journal_voucher_id2($date_format);
	$x++;
	$data->jv_no.'  '.$date_format.'  '.$new_jv_no .'  '.'  '.$data->tr_no.'<br>';
	echo $update_sql = 'update journal set jv_no = "'.$new_jv_no.'"  where jv_no = "'.$data->jv_no.'" and tr_from="'.$data->tr_from.'" and tr_no="'.$data->tr_no.'" ';
	$update = db_query($update_sql);
	echo ' -OK<br>';
	}
}
echo 'TOTAL FOUND: '.$x;
?>