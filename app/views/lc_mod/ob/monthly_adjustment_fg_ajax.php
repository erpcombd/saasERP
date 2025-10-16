<?
//
require "../../support/inc.all.php";

$cqty  = $_REQUEST['cqty'];
$pqty  = $_REQUEST['pqty'];


$odate = $_REQUEST['odate'];
$item_id = $_REQUEST['item_id'];
$rate = $_REQUEST['orate'];

$sodate = date('ymd',strtotime($odate));
$tr_from = 'adj-'.$sodate;
$warehouse_id = $_SESSION['user']['depot'];

$sql = 'delete from journal_item where warehouse_id="'.$warehouse_id.'" and item_id = "'.$item_id.'" and tr_from = "'.$tr_from.'"';
db_query($sql);
journal_item_control($item_id ,$warehouse_id,$odate,$cqty,$pqty,$tr_from,'0',$rate);
echo 'Done';


?>