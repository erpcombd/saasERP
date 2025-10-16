<?

session_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$order_no = $_REQUEST['order_no'];
$item_id = $_REQUEST['item_id'];
 $batch_qty = $_REQUEST['batch_qty'];
$total_unit = $_REQUEST['total_unit'];

$final_unit=$total_unit/$batch_qty;

$flag = $_REQUEST['flag'];



$entry_by=$_SESSION['user']['id'];
$entry_at=date('Y-m-d H:i:s');




//if($total_unit==0)
//{
//$del_sql = "DELETE from bom_raw_material where id='".$order_no."'";
//db_query($del_sql);
//}else{
//$up_sql='update bom_raw_material set  total_unit="'.$amtotal_unitount.'",   edit_by="'.$entry_by.'", entry_at="'.$entry_at.'" where id='.$order_no;
//db_query($up_sql);
//}

$up_sql='update batch_raw_material set  final_qty="'.$total_unit.'", final_unit="'.$final_unit.'",  edit_by="'.$entry_by.'", entry_at="'.$entry_at.'" where id='.$order_no;
db_query($up_sql);



// $po_bill = 'INSERT INTO po_bill_details (bill_id, bill_no, bill_date, purchase_manager, po_no, jv_no, vendor_id, ledger_id, entry_at, entry_by)
//  
//  VALUES("'.$bill_id.'", "'.$bill_no.'", "'.$bill_date.'", "'.$purchase_manager.'", "'.$po_no.'", "'.$jv_no.'", "'.$vendor_id.'", "'.$ledger_id.'", "'.$entry_at.'", "'.$entry_by.'")';
//
//db_query($po_bill);


echo 'Success!';


?>