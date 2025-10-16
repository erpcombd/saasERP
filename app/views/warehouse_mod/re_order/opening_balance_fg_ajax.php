<?
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$warehouse_id = $_REQUEST['warehouse_id'];
$_REQUEST['oqty'] = $_REQUEST['opic'];


$group_for =$_REQUEST['group_for'];
$item_all =find_all_field('item_info','','item_id="'.$_REQUEST['item_id'].'"');

$proj_id = 'clouderp'; 

$narration = 'Opening#'.$_REQUEST['odate'].' (Item#'.$_REQUEST['item_id'].')';


$amount = $_REQUEST['oqty']*$_REQUEST['orate'];

$jv_date = $_REQUEST['odate'];
$tr_from = 'Opening';

   // journal_item_control($_REQUEST['item_id'] ,$warehouse_id,$_REQUEST['odate'],$_REQUEST['oqty'],0,'Opening','0');
	

    $sql="INSERT INTO re_order_item 

  (ji_date, item_id, warehouse_id, item_in, tr_from,  entry_by, entry_at,group_for) 

  VALUES 

  ('".$_REQUEST['odate']."', '".$_REQUEST['item_id']."', '".$warehouse_id."',  '".$_REQUEST['oqty']."','Re-Order', '".$_SESSION['user']['id']."', '".date('Y-m-d H:i:s')."',  '".$group_for."')";

  db_query($sql);
    

    echo 'Success!';



?>