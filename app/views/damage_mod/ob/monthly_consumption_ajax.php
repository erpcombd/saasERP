<?
session_start();
require "../../support/inc.all.php";

$adj = $_REQUEST['orate'] - $_REQUEST['oqty'];
$rate = $_REQUEST['orate1'];
if($adj>0)
{$in = 0; $out = $adj;}
if($adj<0)
{$in = (-1)*$adj; $out = 0;}
//$rate = find_a_field('item_info','f_price','item_id='.$_REQUEST['item_id']);

		if($_REQUEST['flag']==0)
		journal_item_control($_REQUEST['item_id'] ,$_SESSION['user']['depot'],$_REQUEST['odate'],$in,$out,'Adjustment','0',$rate);
		else
		{
		db_delete('journal_item','warehouse_id="'.$_SESSION['user']['depot'].'" and item_id = "'.$_REQUEST['item_id'].'" and tr_from = "Adjustment"');
		journal_item_control($_REQUEST['item_id'] ,$_SESSION['user']['depot'],$_REQUEST['odate'],$in,$out,'Adjustment','0',$rate);
		}


echo 'Success!';
?>