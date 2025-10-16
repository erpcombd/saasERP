<?
session_start();
require "../../support/inc.all.php";

$item_in = $_REQUEST['oqty'];
$vendor_id = $_REQUEST['vendor_id'];

$lot_no = $_REQUEST['lot_no'];
$id =  $_REQUEST['id'];
$item_price =  $_REQUEST['item_price'];


if($oqty<0)
{$in = 0; $out = (-1)*$oqty;}
if($oqty>0)
{$in = $oqty; $out = 0;}

$sql = 'update journal_item set 
vendor_id = "'.$vendor_id.'",
lot_no = "'.$lot_no.'",
item_price = "'.$item_price.'",
item_in = "'.$item_in.'"

where id = "'.$id.'"';

//$sql = 'delete from journal_item where warehouse_id="'.$_SESSION['user']['depot'].'" and item_id = "'.$_REQUEST['item_id'].'" and tr_from = "OPENING-1910"';
db_query($sql);
//journal_item_control($_REQUEST['item_id'] ,$_SESSION['user']['depot'],$_REQUEST['odate'],$in,$out,'OPENING-1910','0',$rate,'',$sr_no,'',$sr_no);
echo 'Done';


?>