<?

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$po_no = $_REQUEST['po_no'];
$bill_id = $_REQUEST['bill_id'];
$bill_no = $_REQUEST['bill_no'];
$bill_date = $_REQUEST['bill_date'];
$purchase_manager = $_REQUEST['purchase_manager'];
$vendor_id = $_REQUEST['vendor_id'];
$ledger_id = $_REQUEST['ledger_id'];
$jv_no = $_REQUEST['jv_no'];

$flag = $_REQUEST['flag'];



$entry_by=$_SESSION['user']['id'];
$entry_at=date('Y-m-d H:i:s');




if($_REQUEST['flag']!=0)
{


// $log_uptade = "DELETE from production_log_sheet_ffw_rope where log_no='".$log_no."' and log_date = '".$p_date."' and  log_shift='".$log_shift ."' and  machine_id='".$machine_id ."' ";
//
//db_query($log_uptade);

}


   $po_bill = 'INSERT INTO po_bill_details (bill_id, bill_no, bill_date, purchase_manager, po_no, jv_no, vendor_id, ledger_id, entry_at, entry_by)
  
  VALUES("'.$bill_id.'", "'.$bill_no.'", "'.$bill_date.'", "'.$purchase_manager.'", "'.$po_no.'", "'.$jv_no.'", "'.$vendor_id.'", "'.$ledger_id.'", "'.$entry_at.'", "'.$entry_by.'")';

db_query($po_bill);






echo 'Success!';


?>