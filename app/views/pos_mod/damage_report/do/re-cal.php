<?php
session_start();
require_once "../../../assets/support/inc.all.php";

//$chalan_no 		= $_REQUEST['chalan_no'];

$sql = "SELECT distinct tr_no as chalan_no FROM `secondary_journal` WHERE tr_no in (15052110003,15052107020,15052208002,15052409007,15052409017,15052409024,15052406019,15052503047,15052503048,15052506017,15052603041,15052606010,15052707001,15052706019,15052706020,15052710004,15052707011,15052806014,15052903064,15052906024,15052908028,15053003047,15053006018,15060110003,15060103014,15060103030,15060107018,15060107019,15060108021,15060107021,15060108025,15060108028,15060206007,15060303062,15060307025) and checked != 'Yes'";

$query = mysql_query($sql);
while($data = mysql_fetch_object($query))
{
	$chalan_no 		= $data->chalan_no;
	auto_recalculate_sales_discount($chalan_no);
	auto_reinsert_sales_chalan_secoundary($chalan_no);
}

?>
