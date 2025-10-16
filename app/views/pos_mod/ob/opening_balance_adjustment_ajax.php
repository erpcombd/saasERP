<?
session_start();
require_once "../../../assets/support/inc.all.php";

$adj = $_REQUEST['orate'] - $_REQUEST['oqty'];
$rate = $_REQUEST['orate1'];
$warehouse_id = $_REQUEST['warehouse_id'];
if($adj>0)
{$in = 0; $out = $adj;}
if($adj<0)
{$in = (-1)*$adj; $out = 0;}
$del_id = find_a_field('journal_item','id','warehouse_id="'.$warehouse_id.'" and item_id = "'.$_REQUEST['item_id'].'" and tr_from = "Opening Adjustment"');

		
		if($del_id>0)
		{
				$sql = 'delete from journal_item where warehouse_id="'.$warehouse_id.'" and item_id = "'.$_REQUEST['item_id'].'" and tr_from = "Opening Adjustment"';
		mysql_query($sql);
		journal_item_control($_REQUEST['item_id'] ,$warehouse_id,$_REQUEST['odate'],$in,$out,'Opening Adjustment','0',$rate);

		echo 'Del & OK';
		}
		else
		{
		journal_item_control($_REQUEST['item_id'] ,$warehouse_id,$_REQUEST['odate'],$in,$out,'Opening Adjustment','0',$rate);
		echo 'OK';
		}

?>