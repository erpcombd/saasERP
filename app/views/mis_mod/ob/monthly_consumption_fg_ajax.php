<?
session_start();
require "../../support/inc.all.php";

$adj = $_REQUEST['orate'] - $_REQUEST['oqty'];
$rate = $_REQUEST['orate1'];
if($adj>0)
{$in = 0; $out = $adj;}
if($adj<0)
{$in = (-1)*$adj; $out = 0;}

//$sql = 'delete from journal_item where warehouse_id="'.$_SESSION['user']['depot'].'" and item_id = "'.$_REQUEST['item_id'].'" and tr_from = "Adj-1807"';
//db_query($sql);
journal_item_control($_REQUEST['item_id'] ,$_SESSION['user']['depot'],$_REQUEST['odate'],$in,$out,'Opening','0',$rate);

//journal_item_control($item_id ,$_SESSION['user']['depot'],$oi_date,0,$total_unit,$page_for,$d_id,$rate,'',$oi->oi_no);
echo 'Done';


?>