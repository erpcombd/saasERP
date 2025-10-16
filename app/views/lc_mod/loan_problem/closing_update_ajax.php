<?

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$closing_no = $_REQUEST['order_no'];
$closing_amt = $_REQUEST['closing_amt'];

$flag = $_REQUEST['flag'];



$entry_by=$_SESSION['user']['id'];
$entry_at=date('Y-m-d H:i:s');


$del_sql1 = "DELETE from secondary_journal where tr_no='".$closing_no."' and tr_from='LC Journal'";
db_query($del_sql1);

$del_sql2 = "DELETE from journal where tr_no='".$closing_no."' and tr_from='LC Journal'";
db_query($del_sql2);


if($closing_no>0)
{
auto_insert_lc_closing_secoundary($closing_no);
}


//if($total_unit==0){
//$del_sql = "DELETE from production_receive_detail where id='".$order_no."'";
//db_query($del_sql);
//}else{}


//$up_sql='update lc_ltr_loan set ledger_id="'.$ledger_id.'" where id='.$order_no;
//db_query($up_sql);





// $po_bill = 'INSERT INTO po_bill_details (bill_id, bill_no, bill_date, purchase_manager, po_no, jv_no, vendor_id, ledger_id, entry_at, entry_by)
//  
//  VALUES("'.$bill_id.'", "'.$bill_no.'", "'.$bill_date.'", "'.$purchase_manager.'", "'.$po_no.'", "'.$jv_no.'", "'.$vendor_id.'", "'.$ledger_id.'", "'.$entry_at.'", "'.$entry_by.'")';
//
//db_query($po_bill);


echo 'Success!';


?>