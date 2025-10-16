<?php


//



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$rate=$_POST['rate'];

$po_no = $_POST['po_no'];
$bill_type = $_POST['bill_type'];

 


$a2="select d.id,(d.amount_usd* ".$rate.") as amount, ((d.amount_usd* ".$rate.")* d.assessable_value ) as assessable_value,d.amount_bdt,(h.tti/100) as tti,h.cd,h.rd,h.sd,c.id as cat ,c.bill_type as type from lc_purchase_master m , lc_purchase_invoice d, lc_bill_category c, hs_code h where m.po_no=d.po_no and m.po_no='".$po_no."' and h.hs_code=d.hs_code and c.bill_type=".$bill_type."";

$query=db_query($a2);

while($dataa=mysqli_fetch_object($query)){

	
	$data[] = $dataa;

}


echo json_encode($data);


?>



