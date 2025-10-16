<?

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$pi_id = $_REQUEST['pi_id'];
$lc_no = $_REQUEST['lc_no'];

$flag = $_REQUEST['flag'];

$lc_data = find_all_field('lc_master','','lc_no='.$lc_no);
$pi_data = find_all_field('pi_details','','pi_id='.$pi_id);


$entry_by=$_SESSION['user']['id'];
$entry_at=date('Y-m-d H:i:s');

$pi_id_found = find_a_field('lc_receive_details','pi_id','pi_id='.$pi_id);


if($_REQUEST['flag']!=0)
{


// $log_uptade = "DELETE from production_log_sheet_ffw_rope where log_no='".$log_no."' and log_date = '".$p_date."' and  log_shift='".$log_shift ."' and  machine_id='".$machine_id ."' ";
//
//db_query($log_uptade);

}


   $so_invoice = 'INSERT INTO lc_receive ( lc_no, year, lc_id, lc_no_view, lc_date, export_lc_no, export_lc_date, expiry_date, pi_id, pi_no, pi_date, pi_type, bank_buyers, dealer_group, dealer_code, marketing_team, marketing_person, tolerance, tenor_days, contact_no, remarks, status, entry_at, entry_by)
  
  VALUES("'.$lc_data->lc_no.'", "'.$lc_data->year.'", "'.$lc_data->lc_id.'", "'.$lc_data->lc_no_view.'", "'.$lc_data->lc_date.'", "'.$lc_data->export_lc_no.'", "'.$lc_data->export_lc_date.'", "'.$lc_data->expiry_date.'", "'.$pi_data->pi_id.'", "'.$pi_data->pi_no.'", "'.$pi_data->pi_date.'", "'.$pi_data->pi_type.'", "'.$lc_data->bank_buyers.'", "'.$lc_data->dealer_group.'", "'.$lc_data->dealer_code.'", "'.$pi_data->marketing_team.'", "'.$pi_data->marketing_person.'", "'.$lc_data->tolerance.'", "'.$lc_data->tenor_days.'", "'.$lc_data->contact_no.'", "'.$lc_data->remarks.'", "CHECKED", "'.$entry_at.'", "'.$entry_by.'")';

db_query($so_invoice);


//if($pi_id_found=="") {
//
//
//  $sql = 'select * from pi_details where pi_id ="'.$pi_id.'"  order by id';
//
//		$query = db_query($sql);
//
//		while($data=mysqli_fetch_object($query))
//
//		{
//	
//
// $lc_rec_ins = 'INSERT INTO lc_receive_details (lc_no, lc_no_view, export_lc_no, pi_id, pi_no, pi_date, pi_order_no, pi_type, order_no, do_no, do_date, job_no, delivery_date, cbm_no, group_for, dealer_code, buyer_code, merchandizer_code, marketing_team, marketing_person, destination, delivery_place, customer_po_no, unit_name, measurement_unit, ply, paper_combination_id, paper_combination, L_cm, W_cm, H_cm, WL, WW, item_id, formula_id, formula_cal, sqm_rate, sqm, weight_per_sqm, total_weight, additional_info, additional_charge, number_format, final_price, unit_price, total_unit, total_amt, style_no, po_no, referance, sku_no, printing_info, color, pack_type, size, depot_id, status, entry_time, entry_by, entry_at)
//  
//  VALUES("'.$lc_data->lc_no.'", "'.$lc_data->lc_no_view.'", "'.$lc_data->export_lc_no.'", "'.$data->pi_id.'", "'.$data->pi_no.'", "'.$data->pi_date.'", "'.$data->id.'", "'.$data->pi_type.'", "'.$data->order_no.'", "'.$data->do_no.'", "'.$data->do_date.'", "'.$data->job_no.'", "'.$data->delivery_date.'", "'.$data->cbm_no.'", "'.$data->group_for.'", "'.$data->dealer_code.'", "'.$data->buyer_code.'", "'.$data->merchandizer_code.'", "'.$data->marketing_team.'", "'.$data->marketing_person.'", "'.$data->destination.'", "'.$data->delivery_place.'", "'.$data->customer_po_no.'", "'.$data->unit_name.'", "'.$data->measurement_unit.'", "'.$data->ply.'", "'.$data->paper_combination_id.'", "'.$data->paper_combination.'", "'.$data->L_cm.'", "'.$data->W_cm.'", "'.$data->H_cm.'", "'.$data->WL.'", "'.$data->WW.'", "'.$data->item_id.'", "'.$data->formula_id.'", "'.$data->formula_cal.'", "'.$data->sqm_rate.'", "'.$data->sqm.'", "'.$data->weight_per_sqm.'", "'.$data->total_weight.'", "'.$data->additional_info.'", "'.$data->additional_charge.'", "'.$data->number_format.'", "'.$data->final_price.'", "'.$data->unit_price.'", "'.$data->total_unit.'", "'.$data->total_amt.'", "'.$data->style_no.'", "'.$data->po_no.'", "'.$data->referance.'", "'.$data->sku_no.'", "'.$data->printing_info.'", "'.$data->color.'", "'.$data->pack_type.'", "'.$data->size.'", "'.$data->depot_id.'", "'.$data->status.'", "'.$entry_at.'",
//  "'.$entry_by.'", "'.$entry_at.'")';
//  
//  db_query($lc_rec_ins);
//  
//  }
//
//}




echo 'Success!';


?>