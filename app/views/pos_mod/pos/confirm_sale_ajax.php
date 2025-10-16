<?php
session_start();
require_once "../../../assets/support/inc.all.php";
$details_id = $_REQUEST['details_id'];
$pos_id = $_REQUEST['pos_id'];
$comment = $_REQUEST['comment'];
$register_mode= $_REQUEST['register_mode'];
$payment_method=$_REQUEST['payment_method'];
$vat_percent = $_REQUEST['vat_percent'];
$old_customer = $_REQUEST['customer_info'];//"Tanjil..#123456";
//echo 'Bimol....';
if($old_customer!=''){
$old = explode("#",$old_customer);
$customer_name = $old[0];
$customer_phone = $old[1];
$customer_id = find_a_field('dealer_pos','dealer_code','contact_no="'.$customer_phone.'" and dealer_name="'.$customer_name.'"');
$register_bonus = find_a_field('dealer_pos','register_bonus','dealer_code="'.$customer_id.'"');
$bonus_update = 'update dealer_pos set bonus_avail="'.$register_bonus.'" where dealer_code="'.$customer_id.'"';
mysql_query($bonus_update);
}else{
$customer_name = $_REQUEST['dealer_name'];
$customer_phone = $_REQUEST['contact_no'];
$customer_id = find_a_field('dealer_pos','dealer_code','contact_no="'.$customer_phone.'" and dealer_name="'.$customer_name.'"');
if($customer_id=='' || $customer_id==0){
$insert_new = 'insert into dealer_pos set dealer_name="'.$customer_name.'",contact_no="'.$customer_phone.'",register_bonus="200"';
mysql_query($insert_new);
$customer_id = mysql_insert_id();
}
}

$usql = "update sale_pos_master set status = 'CHECKED', comments = '$comment', register_mode = '$register_mode', dealer_id='".$customer_id."',vat_percent='".$vat_percent."' where pos_id = '$pos_id' ";
mysql_query($usql);
$details_update = 'update sale_pos_details set dealer_id="'.$customer_id.'" where  pos_id = "'.$pos_id.'" ';
mysql_query($details_update);

$psql ="update pos_payment set status = 'PAID' where pos_id = '$pos_id'";
mysql_query($psql);
$max_id = mysql_fetch_object(mysql_query("select max(pos_id)+1 as max_pos_id from sale_pos_master"));
$data['max_id'] = $max_id->max_pos_id;
$data['status'] = "ok";
$data['test'] = "Bimol";
$rr_sql  = "select * from sale_pos_details where pos_id = '".$pos_id."' order by id asc";
	$rr_query = mysql_query($rr_sql);
	while($datas = mysql_fetch_assoc($rr_query )){
		extract($datas);
		$ji_date = $pos_date;
		if($register_mode=="sale"){
		$item_in = 0;
		$item_ex = $qty;
		$tr_from="POS Sale";			
		}
		if($register_mode=="return"){
		$item_in = $qty;
		$item_ex = 0;
		$tr_from="POS Return";						
			}

		$tr_no = $id;
		$sr_no = $pos_id;
		journal_item_control($item_id ,$warehouse_id,$ji_date,$item_in,$item_ex,$tr_from,$tr_no,$rate,$r_warehouse='',$sr_no,$c_price='',$lot_no='',$vendor_id='');
		}
echo json_encode($data);

?>