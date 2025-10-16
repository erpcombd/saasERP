<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$dealer_code	=$_SESSION['user']['warehouse_id'];
$dinfo=findall("select * from dealer_info where dealer_code='".$dealer_code."' ");

$dealer_code = $dinfo->dealer_code;

$cqty  = $_REQUEST['cqty'];



$odate = $_REQUEST['odate'];
$item_id = $_REQUEST['item_id'];


$sodate = date('ymd',strtotime($odate));
$tr_from = 'Opening';
$warehouse_id = $dealer_code;

$sql = 'delete from ss_journal_item where warehouse_id="'.$warehouse_id.'" and ji_date="'.$odate.'" and item_id = "'.$item_id.'" and tr_from = "'.$tr_from.'"';
mysqli_query($conn, $sql);

if($cqty>0){
journal_item_ss($item_id ,$warehouse_id,$odate,$cqty,$pqty,$tr_from,'0',$rate);
}
echo 'Done';


?>