<?php
session_start();
ob_start();
$warehouse_id = 3;

require_once "../../support/inc.all.php";
$x = 1;
$sql = 'select * from item_info where finish_goods_code>0 ';
$query = db_query($sql);
while($data = mysqli_fetch_object($query))
{
	$sql2 = 'select sum(item_in-item_ex) from journal_item where item_id="'.$data->item_id.'" and warehouse_id='.$warehouse_id.' and ji_date < "2014-08-01"';
	$query2 = db_query($sql2);
	$data2 = mysqli_fetch_row($query2);
	$qty = $data2[0];
	if($qty<0)
	journal_item_control($data->item_id ,3,'2014-07-31',((-1)*$qty),0,'Closing',0,$data->f_price);
	
	if($qty>0)
	journal_item_control($data->item_id ,3,'2014-07-31',0,(($qty)),'Closing',0,$data->f_price);
}
?>