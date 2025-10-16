<?php
session_start();
require_once "../../../assets/support/inc.all.php";
$pos_id = $_REQUEST['pos_id'];
$item_id = $_REQUEST['item_id'];
$register_mod = $_REQUEST['register_mode'];
$sales_person = $_REQUEST['sales_person'];
$group_id = $_SESSION['user']['group'];
$register_bonus = $_REQUEST['register_discount'];
$address = $_REQUEST['address_e'];
$nid = $_REQUEST['nid'];
$customer_type = $_REQUEST['customer_type'];
$old_customer = $_REQUEST['customer_info'];
if($old_customer!=''){
$old = explode("#",$old_customer);
$customer_name = $old[0];
$customer_phone = $old[1];
$dealer_id = find_a_field('dealer_pos','dealer_code','contact_no="'.$customer_phone.'" and dealer_name="'.$customer_name.'"');
$register_bonus = find_a_field('dealer_pos','register_bonus-bonus_avail','dealer_code="'.$dealer_id.'"');
}else{
$customer_name = $_REQUEST['dealer_name'];
$customer_phone = $_REQUEST['contact_no'];
$customer_id = find_a_field('dealer_pos','dealer_code','contact_no="'.$customer_phone.'" and dealer_name="'.$customer_name.'"');
if($customer_id=='' || $customer_id==0){
$insert_new = 'insert into dealer_pos set dealer_name="'.$customer_name.'",contact_no="'.$customer_phone.'",address_e="'.$address.'",national_id="'.$nid.'",customer_type="'.$customer_type.'"';
mysql_query($insert_new);
$customer_id = mysql_insert_id();
}
}

$pos_date = date("Y-m-d");
$warehouse_id = $_SESSION['user']['depot'];
$main_status = "MANUAL";

$serial_no = '';
$check_item = find_a_field('journal_item','item_id','serial_no="'.$item_id.'"');
if($check_item>0){
$serial_no = $item_id;
$item_id = find_a_field('item_info','finish_goods_code','item_id="'.$check_item.'"');
}





$con.=" and item_info.finish_goods_code='".$item_id."'";
$cus_sql = "select item_info.*, sum(journal_item.item_in-journal_item.item_ex) as stock from item_info left join journal_item on journal_item.item_id = item_info.item_id and journal_item.warehouse_id='".$_SESSION['user']['depot']."' where 1 ".$con;

$cus_query = mysql_query($cus_sql);
$data = mysql_fetch_assoc($cus_query);
extract($data);
//if($stock>0){ 
$entry_by = $_SESSION['user']['id'];
$total_amt = 1*$m_price;
$checking_pos_id = find_a_field('sale_pos_master', 'pos_id', 'pos_id='.$pos_id);

$item_in = find_a_field('journal_item','sum(item_in)','item_id="'.$item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'"');
$item_ex = find_a_field('journal_item','sum(item_ex)','item_id="'.$item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'"');
$stock = $item_in-$item_ex;
if($stock>0){

if($checking_pos_id=="" || $checking_pos_id==0){
$isql = "INSERT INTO `sale_pos_master`(`pos_id`, `pos_date`, `group_for`, `dealer_id`,`warehouse_id`, `register_mode`, `status`, `entry_by`,`register_discount`,`sales_person`) VALUES ('$pos_id','$pos_date','$group_id','$dealer_id','$warehouse_id','$register_mod','$main_status','$entry_by','$register_bonus','$sales_person')";
mysql_query($isql);
}  

$pos_item_check = find_all_field('sale_pos_details', 'item_id', 'pos_id="'.$pos_id.'" and item_id="'.$item_id.'"');

if($pos_item_check->item_id>0){

$new_qty = $pos_item_check->qty+1;
$new_amt = $pos_item_check->rate*$new_qty;
$posUpdate = "update sale_pos_details set qty='".$new_qty."', total_amt='".$new_amt."' where item_id='".$item_id."' and pos_id='".$pos_id."'";
mysql_query($posUpdate);

}else{

$iisql = "INSERT INTO `sale_pos_details`(`pos_id`, `pos_date`, `group_for`, `item_id`, `dealer_id`, `qty`, `rate`, `total_amt`, `warehouse_id`,`serial_no`) VALUES ('$pos_id','$pos_date','$group_id','$item_id','$dealer_id','1','$m_price','$total_amt','$warehouse_id','$serial_no')";
mysql_query($iisql);

}
$all_dealer[] ="Data Inserted";

}else{
$all_dealer[] ="No Stock Found";
}
echo json_encode($all_dealer);
?>