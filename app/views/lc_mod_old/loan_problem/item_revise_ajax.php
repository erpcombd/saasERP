<?

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$order_no = $_REQUEST['order_no'];
$ledger_problem = $_REQUEST['ledger_problem'];
$ledger_id = $_REQUEST['ledger_id'];


$flag = $_REQUEST['flag'];



$entry_by=$_SESSION['user']['id'];
$entry_at=date('Y-m-d H:i:s');





//if($total_unit==0){
//$del_sql = "DELETE from production_receive_detail where id='".$order_no."'";
//db_query($del_sql);
//}else{}


$up_sql='update lc_ltr_loan set ledger_id="'.$ledger_id.'" where id='.$order_no;
db_query($up_sql);





// $po_bill = 'INSERT INTO po_bill_details (bill_id, bill_no, bill_date, purchase_manager, po_no, jv_no, vendor_id, ledger_id, entry_at, entry_by)
//  
//  VALUES("'.$bill_id.'", "'.$bill_no.'", "'.$bill_date.'", "'.$purchase_manager.'", "'.$po_no.'", "'.$jv_no.'", "'.$vendor_id.'", "'.$ledger_id.'", "'.$entry_at.'", "'.$entry_by.'")';
//
//db_query($po_bill);


echo 'Success!';


?>