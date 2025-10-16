<?
session_start();

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$_REQUEST['oqty'] = ($_REQUEST['opkt']*$_REQUEST['opkt_sz'])+$_REQUEST['opic'];

$warehouse_id=$_REQUEST['warehouse_id'];

db_delete('journal_item','warehouse_id="'.$warehouse_id.'" and item_id = "'.$_REQUEST['item_id'].'" and tr_from = "Opening" order by id desc');
journal_item_control($_REQUEST['item_id'] ,$warehouse_id,$_REQUEST['odate'],$_REQUEST['oqty'],0,'Opening','0',$_REQUEST['orate']);

echo 'Success!';
?>