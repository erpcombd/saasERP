<?php
require_once "../../../assets/template/layout.top.php";
$x = 1;
$sql = "select * from journal_item WHERE `tr_from`='Issue'";
$query = mysql_query($sql);
while($data1 = mysql_fetch_object($query))
{
	$sql2 = 'select * from journal_item where `tr_from`="Issue" and tr_no ="'.$data1->tr_no.'" and id!='.$data1->id.'';
	$query2 = mysql_query($sql2);
	while($data2 = mysql_fetch_object($query2))
	{
		$up_sql = "UPDATE journal_item SET relevant_warehouse = '".$data1->warehouse_id."' WHERE  id=".$data2->id;
		mysql_query($up_sql);
	}
}
?>