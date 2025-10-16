<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

//$chalan_no 		= $_REQUEST['chalan_no'];
//$sql = 'select distinct c.chalan_no from sale_do_chalan c, dealer_info d where c.dealer_code=d.dealer_code and d.dealer_type!="Distributor" and c.chalan_date>"2015-05-29"';
//$query = db_query($sql);
//while($data = mysqli_fetch_object($query))
//{
	$chalan_no 		= 15061103014;
	//$chalan_no 		= $data->chalan_no;
	echo $data->chalan_no.'<br>';
	auto_recalculate_sales_discount($chalan_no);
	auto_reinsert_sales_chalan_secoundary($chalan_no);
//}

?>
