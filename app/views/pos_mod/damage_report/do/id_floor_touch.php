<?php
require_once "../../../assets/template/layout.top.php";

$sql = 'select * from sale_do_chalan where `id` >51174';
$query = mysql_query($sql);
while($data = mysql_fetch_object($query))
{

	journal_item_control($data->item_id ,$data->depot_id,$data->chalan_date,0,$data->total_unit,'Sales',$data->id);
}
?>