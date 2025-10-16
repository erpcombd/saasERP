<?php
session_start();
require_once "../../../assets/support/inc.all.php";
$pos_id = $_REQUEST['pos_id'];
$table_master = "sale_pos_master";
$table_details = "sale_pos_details";
$main_sql = "select item_info.item_name,item_info.d_price,item_info.item_id,`$table_details`.id,`$table_details`.qty, `$table_details`.rate, `$table_details`.total_amt, `$table_details`.discount_amt,`$table_details`.discount, (sum(journal_item.item_in-journal_item.item_ex)-`$table_details`.qty) as stock, `$table_details`.serial_no, `$table_details`.dealer_id from `$table_details` left join item_info on item_info.item_id = `$table_details`.item_id left join journal_item on journal_item.item_id = item_info.item_id where `$table_details`.pos_id='$pos_id' group by sale_pos_details.id order by sale_pos_details.id desc";
$main_query = mysql_query($main_sql);
$datas['total_item'] = mysql_num_rows($main_query);
$i = 0;
while($data = mysql_fetch_assoc($main_query)){
extract($data);

$datas['item_details'][$i]['register_bonus'] = find_a_field('sale_pos_master','register_discount','dealer_id="'.$dealer_id.'" and pos_id="'.$pos_id.'"'); 
$item_in = find_a_field('journal_item','sum(item_in)','item_id="'.$item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'"');
$item_ex = find_a_field('journal_item','sum(item_ex)','item_id="'.$item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'"');
$stock = $item_in-$item_ex;
$datas['item_details'][$i]['id'] = $id;
$datas['item_details'][$i]['item_name'] = $item_name;
$datas['item_details'][$i]['qty'] = number_format($qty, 2, '.', '');
if($rate>0) $datas['item_details'][$i]['rate'] = number_format($rate, 2, '.', '');else $datas['item_details'][$i]['rate'] = '';
$datas['item_details'][$i]['actual_price'] = number_format($m_price, 2, '.', '');
$datas['item_details'][$i]['total_amt'] = number_format($total_amt, 2, '.', '');
$datas['item_details'][$i]['discount'] = number_format($discount, 2, '.', '');
$datas['item_details'][$i]['discount_amt'] = number_format($discount_amt, 2, '.', '');
$datas['item_details'][$i]['stock'] = number_format($stock, 2, '.', '');
$datas['item_details'][$i]['serial_no'] = $serial_no;
if($serial_no!=''){
$datas['item_details'][$i]['unit_readonly'] = 'readonly';
}else{
$datas['item_details'][$i]['unit_readonly'] = '';
}

$i++;
}
echo json_encode($datas);
?>