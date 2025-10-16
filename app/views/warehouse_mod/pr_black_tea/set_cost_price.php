<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$x = 1;
$sql = 'select item_id from item_info';
$query = db_query($sql);
while($data = mysqli_fetch_object($query))
{
	$sql2 = 'select sum(item_in) as qty,sum(item_in*item_price) as amt from journal_item where warehouse_id=5 and ji_date between "2014-12-31" and "2015-05-31" and item_in>0 and item_id="'.$data->item_id.'"';
	$query2 = db_query($sql2);
	while($info = mysqli_fetch_object($query2))
	{
			echo '<br>';
			echo $up_sql = "UPDATE item_info SET tran_pr = '".$info->amt/$info->qty."' WHERE item_id ='".$data->item_id."' ";
			db_query($up_sql);
	}
}
?>