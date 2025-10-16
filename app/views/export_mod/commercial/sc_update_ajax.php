<?

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$pi_id = $_REQUEST['pi_id'];
$sc_no = $_REQUEST['sc_no'];

$flag = $_REQUEST['flag'];

$sc_data = find_all_field('sales_contract_master','','sc_no='.$sc_no);
$pi_data = find_all_field('pi_master','','pi_id='.$pi_id);


$entry_by=$_SESSION['user']['id'];
$entry_at=date('Y-m-d H:i:s');




if($_REQUEST['flag']!=0)
{


// $log_uptade = "DELETE from production_log_sheet_ffw_rope where log_no='".$log_no."' and log_date = '".$p_date."' and  log_shift='".$log_shift ."' and  machine_id='".$machine_id ."' ";
//
//db_query($log_uptade);

}


   $so_invoice = 'INSERT INTO sales_contract (sc_no, sc_no_view, invoice_no, invoice_date, group_for, pi_id, pi_no, view_pi_no, pi_date, pi_type, dealer_group, dealer_code, status, entry_at, entry_by)
  
  VALUES("'.$sc_no.'", "'.$sc_data->sc_no_view.'", "'.$sc_data->invoice_no.'", "'.$sc_data->invoice_date.'", "'.$sc_data->group_for.'", "'.$pi_id.'", "'.$pi_data->pi_no.'", "'.$pi_data->view_pi_no.'",  "'.$pi_data->pi_date.'",  "'.$pi_data->pi_type.'", "'.$sc_data->dealer_group.'", "'.$sc_data->dealer_code.'", "CHECKED", "'.$entry_at.'", "'.$entry_by.'")';

db_query($so_invoice);






echo 'Success!';


?>