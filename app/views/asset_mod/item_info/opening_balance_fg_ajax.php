<?

//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";






db_delete('journal_item','warehouse_id="'.$_SESSION['user']['depot'].'" and item_id = "'.$_REQUEST['item_id'].'" and tr_from = "Opening" order by id desc');

journal_item_control($_REQUEST['item_id'] ,$_SESSION['user']['depot'],$_REQUEST['date'],$_REQUEST['qty'],0,'Opening','0',$_REQUEST['rate']);





?>