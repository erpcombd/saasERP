<?

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$do_no = $_REQUEST['do_no'];
$pi_id = $_REQUEST['pi_id'];

//$acknowledgement_no = next_transection_no('0',$acknowledgement_date,'sale_do_chalan_acknowledgement','acknowledgement_no');

$flag = $_REQUEST['flag'];

$pi_data = find_all_field('pi_master','','id='.$pi_id);


//$acknow_date = strtotime($acknowledgement_date);
//$chalan_date = strtotime($ch_data->chalan_date);
//$datediff = $acknow_date - $chalan_date;
//$acknowledgement_days =  round($datediff / (60 * 60 * 24));


$entry_by=$_SESSION['user']['id'];
$entry_at=date('Y-m-d H:i:s');




if($_REQUEST['flag']!=0)
{


// $log_uptade = "DELETE from production_log_sheet_ffw_rope where log_no='".$log_no."' and log_date = '".$p_date."' and  log_shift='".$log_shift ."' and  machine_id='".$machine_id ."' ";
//
//db_query($log_uptade);

}


$individual_pi_found = find_a_field('pi_details','pi_type','do_no="'.$do_no.'" and pi_type=1');

if ($individual_pi_found>0) {
individual_pi_backup($do_no,$individual_pi_found);

 $del_sql = 'delete from pi_details where do_no="'.$do_no.'" and pi_type="'.$individual_pi_found.'"';
db_query($del_sql);
}




		$ms_data = find_all_field('sale_do_master','','do_no='.$do_no);
		
		
		
			
$pi_dtls = "INSERT INTO pi_details (pi_id, pi_no, pi_date, pi_type, do_no, do_date, job_no, group_for, dealer_code, buyer_code, merchandizer_code, marketing_team, marketing_person, customer_po_no, status, entry_by, entry_at)
  
  VALUES('".$pi_data->id."', '".$pi_data->pi_no."', '".$pi_data->pi_date."', '".$pi_data->pi_type."', '".$do_no."', '".$ms_data->do_date."', '".$ms_data->job_no."', '".$ms_data->group_for."',
   '".$ms_data->dealer_code."', '".$ms_data->buyer_code."', '".$ms_data->merchandizer_code."', '".$ms_data->marketing_team."', '".$ms_data->marketing_person."', '".$ms_data->customer_po_no."', 'CHECKED', '".$entry_by."', '".$entry_at."')";

db_query($pi_dtls);


		 
		 // $sql = 'select s.*, g.weight_per_sqm from sale_do_details s, paper_combination c, paper_grade_type g where s.paper_combination_id=c.id and c.paper_grade_type=g.id and s.do_no ="'.$do_no.'" and s.ms_pi=0 order by s.id';
//
//		$query = db_query($sql);
//
//		//$pr_no = next_pr_no($warehouse_id,$rec_date);
//
//
//		while($data=mysqli_fetch_object($query))
//
//		{
//
//  $so_invoice = 'INSERT INTO pi_details ( pi_id, pi_no, pi_date, pi_type, order_no, do_no, do_date, job_no, delivery_date, cbm_no, group_for, dealer_code, buyer_code, merchandizer_code, marketing_team, marketing_person, destination, delivery_place, customer_po_no, unit_name, measurement_unit, ply, paper_combination_id, paper_combination, L_cm, W_cm, H_cm, WL, WW, item_id, formula_id, formula_cal, sqm_rate, sqm, weight_per_sqm, total_weight,  additional_info, additional_charge, number_format, final_price, unit_price, total_unit, total_amt, style_no, po_no, referance, sku_no, printing_info, color, pack_type, size, depot_id, status, entry_by, entry_at)
//  
//  VALUES("'.$pi_id.'", "'.$pi_data->pi_no.'", "'.$pi_data->pi_date.'", "'.$pi_data->pi_type.'", "'.$data->id.'", "'.$data->do_no.'", "'.$data->do_date.'", "'.$data->job_no.'", "'.$data->delivery_date.'", "'.$data->cbm_no.'", "'.$data->group_for.'", "'.$data->dealer_code.'", "'.$data->buyer_code.'", "'.$data->merchandizer_code.'", "'.$ms_data->marketing_team.'", "'.$ms_data->marketing_person.'", "'.$data->destination.'", "'.$data->delivery_place.'", "'.$data->customer_po_no.'", "'.$data->unit_name.'", "'.$data->measurement_unit.'", "'.$data->ply.'", "'.$data->paper_combination_id.'", "'.$data->paper_combination.'", "'.$data->L_cm.'", "'.$data->W_cm.'", "'.$data->H_cm.'", "'.$data->WL.'", "'.$data->WW.'", "'.$data->item_id.'", "'.$data->formula_id.'", "'.$data->formula_cal.'", "'.$data->sqm_rate.'", "'.$data->sqm.'", "'.$data->weight_per_sqm.'", "'.($data->sqm*$data->weight_per_sqm*$data->total_unit).'",  "'.$data->additional_info.'", "'.$data->additional_charge.'", "'.$data->number_format.'", "'.$data->final_price.'", "'.$data->unit_price.'", "'.$data->total_unit.'", "'.$data->total_amt.'", "'.$data->style_no.'", "'.$data->po_no.'", "'.$data->referance.'", "'.$data->sku_no.'", "'.$data->printing_info.'", "'.$data->color.'", "'.$data->pack_type.'", "'.$data->size.'", "'.$data->depot_id.'", "CHECKED",  "'.$entry_by.'", "'.$entry_at.'")';
//
//db_query($so_invoice);
//
//}


		//if ($pi_data->pi_type==2) {
//
//			 $new_sql="UPDATE sale_do_details SET lc_id = '".$pi_id."', ms_pi = '".$pi_id."'  WHERE do_no = '".$do_no."'";
//			 db_query($new_sql);
//
//
//		} elseif ($pi_data->pi_type==3) {
//		
//		$new_sql="UPDATE sale_do_details SET lc_id = '".$pi_id."', ms_pi = '".$pi_id."', cm_pi = '".$pi_id."' WHERE do_no = '".$do_no."'";
//			 db_query($new_sql);
//			 
//		}
		
		
		
		



echo 'Success!';


?>