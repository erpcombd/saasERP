			<?

//




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$p_date = $_REQUEST['p_date'];
$dealer_code = $_REQUEST['dealer_code'];
$buyer_code = $_REQUEST['buyer_code'];
$merchandizer_code = $_REQUEST['merchandizer_code'];
$item_id = $_REQUEST['item_id'];
$unit_name = find_a_field('item_info','unit_name',"item_id=".$item_id);
$fg_code = find_a_field('item_info','finish_goods_code',"item_id=".$item_id);
$L_cm = $_REQUEST['L_cm'];
$W_cm = $_REQUEST['W_cm'];
$H_cm = $_REQUEST['H_cm'];
$WL = $_REQUEST['WL'];
$WW = $_REQUEST['WW'];
$ply = $_REQUEST['ply'];
$paper_combination = $_REQUEST['paper_combination'];
$sqm_rate = $_REQUEST['sqm_rate'];
$pcs_rate = $_REQUEST['pcs_rate'];

$group_for=$_SESSION['user']['group'];

$flag = $_REQUEST['flag'];

$entry_by = $_REQUEST['entry_by']=$_SESSION['user']['id'];

$entry_at = $_REQUEST['entry_at']=date('Y-m-d H:i:s');


$tr_no = 10000+$group_for.$dealer_code;

$cbm_no = $dealer_code.$buyer_code.$merchandizer_code;

$tr_id = find_a_field('raw_input_data','count(id)',"item_id='".$item_id."' and dealer_code='".$dealer_code."'")+1;

$reference_no = $fg_code.'-'.$dealer_code.'-'.$buyer_code.'-'.$merchandizer_code.'-'.$tr_id;

//$tr_no = next_transection_no($group_for,$p_date,'production_rmc_sheet_ftr2','tr_no');	

//$mn_tr_no = (date('ym',strtotime($p_date))*10000)+$group_for.$sub_company;

//$wh_tr_no = (date('ymd',strtotime($p_date))*10000)+$group_for.$sub_company;




if($_REQUEST['flag']!=0)
{



$log_del = "DELETE from raw_input_sheet where item_id='".$item_id."' and dealer_code = '".$dealer_code."' and buyer_code='".$buyer_code ."' 
and merchandizer_code='".$merchandizer_code."' ";
db_query($log_del);


}



// $prevent_multi = find_a_field('raw_input_sheet','id',"item_id='".$item_id."' and dealer_code='".$dealer_code."' and buyer_code='".$buyer_code ."' 
//and merchandizer_code='".$merchandizer_code."'");
//
//if ($prevent_multi<1) {}



  $sql = "INSERT INTO raw_input_sheet ( `tr_no`, cbm_no, `group_for`, `tr_id`, `reference_no`, `reference_date`, `dealer_code`, `buyer_code`, `merchandizer_code`, `item_id`, `unit_name`, `L_cm`, `W_cm`, `H_cm`, `WL`, `WW`, `ply`, `paper_combination`, `sqm_rate`, pcs_rate, `status`, `entry_at`, `entry_by`) VALUES

('".$tr_no."','".$cbm_no."', '".$group_for."','".$tr_id."', '".$reference_no."', '".$p_date."', '".$dealer_code."', '".$buyer_code."', '".$merchandizer_code."',  '".$item_id."',  '".$unit_name."', '".$L_cm."',  '".$W_cm."', '".$H_cm."', '".$WL."', '".$WW."', '".$ply."', '".$paper_combination."', '".$sqm_rate."', '".$pcs_rate."',  'CHECKED', '".$entry_at."', '".$entry_by."')";


db_query($sql);



$sql2 = "INSERT INTO raw_input_data ( `tr_no`, cbm_no, `group_for`, `tr_id`, `reference_no`, `reference_date`, `dealer_code`, `buyer_code`, `merchandizer_code`, `item_id`, `unit_name`, `L_cm`, `W_cm`, `H_cm`, `WL`, `WW`, `ply`, `paper_combination`, `sqm_rate`, pcs_rate, `status`, `entry_at`, `entry_by`) VALUES

('".$tr_no."', '".$cbm_no."', '".$group_for."','".$tr_id."', '".$reference_no."', '".$p_date."', '".$dealer_code."', '".$buyer_code."', '".$merchandizer_code."',  '".$item_id."',  '".$unit_name."', '".$L_cm."',  '".$W_cm."', '".$H_cm."', '".$WL."', '".$WW."', '".$ply."', '".$paper_combination."', '".$sqm_rate."', '".$pcs_rate."',  'CHECKED', '".$entry_at."', '".$entry_by."')";


db_query($sql2);





echo 'Success!';



?>