<?

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$pi_id = $_REQUEST['pi_id'];
$order_no = $_REQUEST['id'];

$item_id = $_REQUEST['item_id'];
$L_cm = $_REQUEST['L_cm'];
$W_cm = $_REQUEST['W_cm'];
$H_cm = $_REQUEST['H_cm'];
$ply = $_REQUEST['ply'];
$total_unit = $_REQUEST['total_unit'];
$total_weight = $_REQUEST['total_weight'];
$unit_price = $_REQUEST['unit_price'];
$total_amt = $_REQUEST['total_amt'];


//$acknowledgement_no = next_transection_no('0',$acknowledgement_date,'sale_do_chalan_acknowledgement','acknowledgement_no');

$flag = $_REQUEST['flag'];

$pi_ms = find_all_field('pi_master','','id='.$pi_id);




$entry_by=$_SESSION['user']['id'];
$entry_at=date('Y-m-d H:i:s');




if($_REQUEST['flag']!=0)
{


    $del_sql = "DELETE from pi_details_master_pi where pi_id='".$pi_id."' and order_no = '".$order_no."' ";
	db_query($del_sql);

}



  $so_invoice = 'INSERT INTO pi_details_master_pi (  pi_id, pi_no, pi_date, pi_type, order_no, dealer_code, unit_name, measurement_unit, ply, L_cm, W_cm, H_cm, 
  item_id, status, entry_by, entry_at)
  
  VALUES("'.$pi_id.'", "'.$pi_ms->pi_no.'", "'.$pi_ms->pi_date.'", "'.$pi_ms->pi_type.'", "'.$order_no.'",  "'.$pi_ms->dealer_code.'",
    "'.$unit_name.'", "'.$measurement_unit.'", "'.$ply.'", "'.$L_cm.'", "'.$W_cm.'", "'.$H_cm.'", "'.$item_id.'",  "CHECKED", "'.$entry_by.'", "'.$entry_at.'")';

db_query($so_invoice);












echo 'Success!';


?>