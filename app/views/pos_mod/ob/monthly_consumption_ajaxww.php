<?
session_start();
require_once "../../../assets/support/inc.all.php";

$adj = $_REQUEST['orate'] - $_REQUEST['oqty'];
$rate = $_REQUEST['orate1'];
if($adj>0)
{$in = 0; $out = $adj;}
if($adj<0)
{$in = (-1)*$adj; $out = 0;}
$del_id = find_a_field('journal_item','id','warehouse_id="'.$_SESSION['user']['depot'].'" and item_id = "'.$_REQUEST['item_id'].'" and tr_from = "Adjustment-141231"');

		
		if($del_id>0)
		{
				$sql = 'delete from journal_item where warehouse_id="'.$_SESSION['user']['depot'].'" and item_id = "'.$_REQUEST['item_id'].'" and tr_from = "Adjustment-141231"';
		mysql_query($sql);
		journal_item_control($_REQUEST['item_id'] ,$_SESSION['user']['depot'],$_REQUEST['odate'],$in,$out,'Adjustment-141231','0',$rate);

		echo 'Del & OK';
		}
		else
		{
		journal_item_control($_REQUEST['item_id'] ,$_SESSION['user']['depot'],$_REQUEST['odate'],$in,$out,'Adjustment-141231','0',$rate);
		echo 'OK';
		}

?>