<?

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$order_no = $_REQUEST['order_no'];
$item_id = $_REQUEST['item_id'];
$color = $_REQUEST['color'];
$referance = $_REQUEST['referance'];
$shade = $_REQUEST['shade'];
$po_no = $_REQUEST['po_no'];
$style_no = $_REQUEST['style_no'];
$pack_type = $_REQUEST['pack_type'];
$sst = $_REQUEST['sst'];

$unit_price = $_REQUEST['unit_price'];
$total_unit = $_REQUEST['total_unit'];
$total_amt = $_REQUEST['total_amt'];

$flag = $_REQUEST['flag'];



$entry_by=$_SESSION['user']['id'];
$entry_at=date('Y-m-d H:i:s');




if($_REQUEST['flag']!=0)
{


// $log_uptade = "DELETE from production_log_sheet_ffw_rope where log_no='".$log_no."' and log_date = '".$p_date."' and  log_shift='".$log_shift ."' and  machine_id='".$machine_id ."' ";
//db_query($log_uptade);

}


  // $po_bill = 'INSERT INTO po_bill_details (bill_id, bill_no, bill_date, purchase_manager, po_no, jv_no, vendor_id, ledger_id, entry_at, entry_by)
//  
//  VALUES("'.$bill_id.'", "'.$bill_no.'", "'.$bill_date.'", "'.$purchase_manager.'", "'.$po_no.'", "'.$jv_no.'", "'.$vendor_id.'", "'.$ledger_id.'", "'.$entry_at.'", "'.$entry_by.'")';
//
//db_query($po_bill);

$up_sql='update sale_do_details set color="'.$color.'", referance="'.$referance.'", shade="'.$shade.'", po_no="'.$po_no.'", style_no="'.$style_no.'", pack_type="'.$pack_type.'", sst="'.$sst.'", 
 unit_price="'.$unit_price.'",  total_unit="'.$total_unit.'",  total_amt="'.$total_amt.'", reg_revise=1, reg_revise_by="'.$entry_by.'", reg_revise_at="'.$entry_at.'" where id='.$order_no;
db_query($up_sql);




echo 'Success!';


?>