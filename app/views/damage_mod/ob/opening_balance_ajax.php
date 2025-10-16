<?
session_start();
require "../../support/inc.all.php";

if($_REQUEST['item_id']==0)
journal_item_control($_REQUEST['item_id'] ,$_SESSION['user']['depot'],$_REQUEST['odate'],$_REQUEST['oqty'],0,'Opening','0',$_REQUEST['orate']);
else
{
db_delete('journal_item','warehouse_id="'.$_SESSION['user']['depot'].'" and item_id = "'.$_REQUEST['item_id'].'" and tr_from = "Opening" order by id desc');
journal_item_control($_REQUEST['item_id'] ,$_SESSION['user']['depot'],$_REQUEST['odate'],$_REQUEST['oqty'],0,'Opening','0',$_REQUEST['orate']);
}
echo 'Success!';
?>