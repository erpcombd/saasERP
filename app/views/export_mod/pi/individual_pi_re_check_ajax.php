<?

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";




$pi_id = $_REQUEST['pi_id'];
$do_no = $_REQUEST['do_no'];
$pi_qty = $_REQUEST['pi_qty'];

$pi_all = find_all_field('pi_master','','id="'.$pi_id.'"');


if ($pi_qty>0) {


$del_1 = "DELETE from pi_details where pi_id='".$pi_id."' ";
db_query($del_1);





$approval_matrix = find_a_field('management_approval_matrix','approval_matrix','approval_type="PI"');


if ($approval_matrix=="Yes") {

   $YR = date('Y',strtotime($pi_all->pi_date));
   $year = date('y',strtotime($pi_all->pi_date));
   $month = date('m',strtotime($pi_all->pi_date));
   $digital_sign_id = find_a_field('pi_master','max(digital_sign_id)','year="'.$YR.'"')+1;
   $cy_id = sprintf("%08d", $digital_sign_id);
   $digital_sign=$year.''.$month.''.$cy_id;

	$status = 'CHECKED';
	$checked_by = $_SESSION['user']['id'];
	$checked_at=date('Y-m-d H:i:s');
} else {
	$status = 'UNCHECKED';
}


$flag = $_REQUEST['flag'];


//   $pi_no = find_a_field('pi_master','max(id)','1')+1;
//   $YR = date('Y',strtotime($pi_date));
//   $year = date('y',strtotime($pi_date));
//   $month = date('m',strtotime($pi_date));
//   $pi_id = find_a_field('pi_master','max(pi_id)','year="'.$YR.'"')+1;
//   $cy_id = sprintf("%06d", $pi_id);
//   $pi_no_generate='11'.$year.''.$month.''.$cy_id;
//   $view_pi_no='11 '.$year.' '.$month.' '.$cy_id;


$entry_by=$_SESSION['user']['id'];
$entry_at=date('Y-m-d H:i:s');


$pi_type=1;



//  $pi_mas = "INSERT INTO pi_master (id, year, pi_id, pi_no, view_pi_no, pi_date, pi_type, dealer_group, dealer_code, remarks, status, entry_at, entry_by,
//  digital_sign_id, digital_sign, checked_by, checked_at)
//  
//  VALUES('".$pi_no."', '".$YR."', '".$pi_id."', '".$pi_no_generate."', '".$view_pi_no."',  '".$pi_date."', '".$pi_type."', '".$dealer_group."', '".$dealer_code."', '".$remarks."',
//   '".$status."', '".$entry_at."', '".$entry_by."',  '".$digital_sign_id."', '".$digital_sign."', '".$checked_by."', '".$checked_at."')";
//
//db_query($pi_mas);






if($_REQUEST['flag']!=0)
{


// $log_uptade = "DELETE from production_log_sheet_ffw_rope where log_no='".$log_no."' and log_date = '".$p_date."' and  log_shift='".$log_shift ."' and  machine_id='".$machine_id ."' ";
//
//db_query($log_uptade);

}


		$ms_data = find_all_field('sale_do_master','','do_no='.$do_no);
		
		
		

		 $sql = 'select s.*, g.weight_per_sqm from sale_do_details s, paper_combination c, paper_grade_type g where s.paper_combination_id=c.id and c.paper_grade_type=g.id and s.do_no ="'.$do_no.'"';

		$query = db_query($sql);

		//$pr_no = next_pr_no($warehouse_id,$rec_date);


		while($data=mysqli_fetch_object($query))

		{
	

  $so_invoice = "INSERT INTO pi_details ( pi_id, pi_no,  pi_date, pi_type, order_no, do_no, do_date, job_no, delivery_date, cbm_no, group_for, dealer_code, buyer_code, merchandizer_code, marketing_team, marketing_person, destination, delivery_place, customer_po_no, unit_name, measurement_unit, ply, paper_combination_id, paper_combination, L_cm, W_cm, H_cm, WL, WW, item_id, formula_id, formula_cal, sqm_rate, sqm, weight_per_sqm, additional_info, additional_charge, number_format, final_price, unit_price, total_unit, total_amt, style_no, po_no, referance, sku_no, printing_info, color, pack_type, size, depot_id, status, entry_by, entry_at)
  
  VALUES('".$pi_id."', '".$pi_all->pi_no."', '".$pi_all->pi_date."', '".$pi_type."', '".$data->id."', '".$data->do_no."', '".$data->do_date."', '".$data->job_no."', '".$data->delivery_date."', '".$data->cbm_no."', '".$data->group_for."', '".$data->dealer_code."', '".$data->buyer_code."', '".$data->merchandizer_code."', '".$ms_data->marketing_team."', '".$ms_data->marketing_person."', '".$data->destination."', '".$data->delivery_place."', '".$data->customer_po_no."', '".$data->unit_name."', '".$data->measurement_unit."', '".$data->ply."', '".$data->paper_combination_id."', '".$data->paper_combination."', '".$data->L_cm."', '".$data->W_cm."', '".$data->H_cm."', '".$data->WL."', '".$data->WW."', '".$data->item_id."', '".$data->formula_id."', '".$data->formula_cal."', '".$data->sqm_rate."', '".$data->sqm."', '".$data->weight_per_sqm."',  '".$data->additional_info."', '".$data->additional_charge."', '".$data->number_format."', '".$data->final_price."', '".$data->unit_price."', '".$data->total_unit."', '".$data->total_amt."', '".$data->style_no."', '".$data->po_no."', '".$data->referance."', '".$data->sku_no."', '".$data->printing_info."', '".$data->color."', '".$data->pack_type."', '".$data->size."', '".$data->depot_id."', 'CHECKED',  '".$entry_by."', '".$entry_at."')";

db_query($so_invoice);

}




	//	 $pi_sql = 'select * from terms_condition_setup where status="Active" order by sl_no';
//
//		$pi_query = db_query($pi_sql);
//
//
//
//		while($pi_data=mysqli_fetch_object($pi_query))
//
//		{
//
//  $pi_terms = 'INSERT INTO pi_terms_condition ( pi_id, terms_condition, sl_no, entry_at, entry_by)
//  
//  VALUES("'.$pi_no.'", "'.$pi_data->terms_condition.'", "'.$pi_data->sl_no.'",  "'.$entry_at.'", "'.$entry_by.'")';
//
//db_query($pi_terms);
//
//}



			 $new_sql="UPDATE sale_do_details SET lc_id = '".$pi_id."'  WHERE do_no = '".$do_no."'";
			 db_query($new_sql);
			 
			 
			 $up_2="UPDATE pi_master SET status = '".$status."'  WHERE id = '".$pi_id."'";
			 db_query($up_2);
			 
			 
			 
			 
if ($approval_matrix=="Yes") {

	$am_ins = "INSERT INTO management_approval_history (tr_no, tr_no_view, tr_date, tr_type, year, digital_sign_id, digital_sign, checked_by, checked_at)
  
  VALUES('".$pi_no."', '".$pi_no_generate."', '".$pi_date."', 'Individual PI', '".$YR."', '".$digital_sign_id."', '".$digital_sign."', '".$entry_by."',  '".$entry_at."')";

db_query($am_ins);
	
}




	
	
//Text Sms

$sms_rec = find_all_field('sms_receiver','','id=1');

function sms($dest_addr,$sms_text){

$url = "https://vas.banglalink.net/sendSMS/sendSMS?userID=NASSA@123&passwd=LizAPI@019014&sender=NASSA_GROUP";


$fields = array(
    'userID'      => "NASSA@123",
    'passwd'      => "LizAPI@019014",
    'sender'      => "NASSA GROUP",
    'msisdn'      => $dest_addr,
    'message'     => $sms_text
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, count($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
$result = curl_exec($ch);
curl_close($ch);
}

$recipients =$sms_rec->receiver_3;
$recipients2 =$sms_rec->receiver_2;
$massage  = "Dear Sir,\r\nRequest for PI Approval. \r\n";
$massage  .= "PI No : ".$pi_no_generate." \r\n";
$massage  .= "Login : https://boxes.com.bd/NATIVE/lc_mod/pages/main/index.php?module_id=13 \r\n";
$sms_result=sms($recipients, $massage);
if($recipients2>0) {
$sms_result=sms($recipients2, $massage);
}
	
//Text Sms



}else {

$del_1 = "DELETE from pi_details where pi_id='".$pi_id."' ";
db_query($del_1);

$del_2 = "DELETE from pi_master where id='".$pi_id."' ";
db_query($del_2);

$del_3 = "DELETE from pi_terms_condition where pi_id='".$pi_id."' ";
db_query($del_3);

 $new_sql="UPDATE sale_do_details SET lc_id = 0  WHERE do_no = '".$do_no."'";
 db_query($new_sql);


}

echo 'Success!';


?>