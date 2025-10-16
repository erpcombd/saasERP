<?
session_start();
require "../../support/inc.all.php";

$i = 0;
$entry_time = date('Y-m-d H:i:s');
$sql = 'select warehouse_id,item_id,sum(item_in-item_ex) qty,final_price from journal_item where ji_date<"2018-01-01"  group by warehouse_id,item_id ';
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
if($data->qty<>0)
{
$item_id[$i] 	  = $data->item_id;
$warehouse_id[$i] = $data->warehouse_id;
$final_price[$i] = $data->final_price;
$qty = $data->qty;
if($data->qty>0)
{

$item_in1[$i] =  0;
$item_ex1[$i] =  $qty;
$item_in2[$i] =  $qty;
$item_ex2[$i] =  0;
}
else
{
$qty = $data->qty;
$item_in1[$i] =  $qty;
$item_ex1[$i] =  0;
$item_in2[$i] =  0;
$item_ex2[$i] =  $qty;
}

$i++;
}
}

for($p=0;$p<$i;$p++)
{

	$sql="INSERT INTO `journal_item` 
	(`ji_date`, `item_id`, `warehouse_id`, `pre_stock`, `pre_price`, `item_in`, `item_ex`, `item_price`, `final_stock`, `final_price`,`tr_from`, `tr_no`, `entry_by`, `entry_at`,relevant_warehouse,sr_no,c_price) 
	VALUES 
	('2017-12-31', '".$item_id[$p]."', '".$warehouse_id[$p]."', '0', '".$final_price[$p]."', '".$item_in1[$p]."', '".$item_ex1[$p]."', '".$final_price[$p]."', 
	'".($item_in1[$p]-$item_ex1[$p])."', '".$final_price[$p]."', 'Closing-17', '2017', '10004', '".$entry_time."', '', '', '')";
	db_query($sql);
	
	$sql="INSERT INTO `journal_item` 
	(`ji_date`, `item_id`, `warehouse_id`, `pre_stock`, `pre_price`, `item_in`, `item_ex`, `item_price`, `final_stock`, `final_price`,`tr_from`, `tr_no`, `entry_by`, `entry_at`,relevant_warehouse,sr_no,c_price) 
	VALUES 
	('2017-12-31', '".$item_id[$p]."', '".$warehouse_id[$p]."', '0', '".$final_price[$p]."', '".$item_in2[$p]."', '".$item_ex2[$p]."', '".$final_price[$p]."', 
	'".($item_in2[$p]-$item_ex2[$p])."', '".$final_price[$p]."', 'Opening-18', '2017', '10004', '".$entry_time."', '', '', '')";
	db_query($sql);

}

?>