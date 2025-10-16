<?



session_start();




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$order_no = $_REQUEST['order_no'];

$item_id = $_REQUEST['item_id'];



$total_unit = $_REQUEST['total_unit'];







$flag = $_REQUEST['flag'];







$entry_by=$_SESSION['user']['id'];

$entry_at=date('Y-m-d H:i:s');









if($total_unit==0)

{

$del_sql = "DELETE from bom_by_product where id='".$order_no."'";

db_query($del_sql);

}else{

$up_sql='update bom_by_product set  total_unit="'.$total_unit.'",   edit_by="'.$entry_by.'", entry_at="'.$entry_at.'" where id='.$order_no;

db_query($up_sql);

}









// $po_bill = 'INSERT INTO po_bill_details (bill_id, bill_no, bill_date, purchase_manager, po_no, jv_no, vendor_id, ledger_id, entry_at, entry_by)

//  

//  VALUES("'.$bill_id.'", "'.$bill_no.'", "'.$bill_date.'", "'.$purchase_manager.'", "'.$po_no.'", "'.$jv_no.'", "'.$vendor_id.'", "'.$ledger_id.'", "'.$entry_at.'", "'.$entry_by.'")';

//

//db_query($po_bill);





echo 'Success!';





?>