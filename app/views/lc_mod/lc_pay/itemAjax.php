<?php


//



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$itemcode=$_POST['itemCode'];

$lc_no = $_POST['lc_no'];


$a2="select order_no,qty from lc_purchase_receive where lc_no='".$lc_no."' and lc_part ='".$itemcode."' ";

$query=db_query($a2);

while($dataa=mysqli_fetch_object($query)){
	
	$data[] = $dataa;

}


echo json_encode($data);


?>



