<?php
session_start();
ob_start();
require_once "../../support/inc.all.php";

$sql = 'select * from sale_do_chalan where `id` >51174';
$query = db_query($sql);
while($data = mysqli_fetch_object($query))
{

	journal_item_control($data->item_id ,$data->depot_id,$data->chalan_date,0,$data->total_unit,'Sales',$data->id);
}
?>