<?
//

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$item_id=$_REQUEST['item_id'];
$oqty=$_REQUEST['oqty'];
$orate=$_REQUEST['orate'];
$odate=$_REQUEST['odate'];
$flag=$_REQUEST['flag'];


$unit_name = find_a_field('item_info','unit_name','item_id="'.$item_id.'"');

$amount = $oqty*$orate;

$entry_by = $_SESSION['user']['id'];
$entry_at=date('Y-m-d H:i:s');



if ($orate>0) {

   $po_bill = 'INSERT INTO purchase_sp_invoice (po_no, po_date, vendor_id, item_id, warehouse_id, rate, pkt_size, qty, unit_name, amount, entry_by, entry_at)
  
  VALUES("10", "'.$odate.'", "48", "'.$item_id.'", "33",  "'.$orate.'", "1", "'.$oqty.'", "'.$unit_name.'", "'.$amount.'",  "'.$entry_by.'", "'.$entry_at.'" )';

  db_query($po_bill);

}




echo 'Success!';
?>