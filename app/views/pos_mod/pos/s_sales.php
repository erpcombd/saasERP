<?php
session_start();
require_once "../../../assets/support/inc.all.php";
$allsql ="select sale_pos_master.pos_id, sale_pos_master.pos_date, dealer_pos.contact_no ,dealer_pos.dealer_name, sale_pos_master.comments  from sale_pos_master left join dealer_pos on dealer_pos.dealer_code = sale_pos_master.dealer_id where sale_pos_master.status = 'MANUAL' order by sale_pos_master.pos_id desc ";
$tt = mysql_query($allsql);
$o=0;
while($data = mysql_fetch_assoc($tt)){
	extract($data);
$datas[$i]['s_id'] = $pos_id;
$datas[$i]['s_date'] = $pos_date;
$datas[$i]['customer_name'] = $dealer_name;
$datas[$i]['comments'] = $contact_no;
$datas[$i]['us_sale'] = "<input type='button' value='Unsuspend' id='us_button_".$pos_id."' onclick='us_func(".$pos_id.")'>";
$datas[$i]['s_receipt'] = "<input type='button' value='Sale Receipt' id='s_r_button_".$pos_id."' onclick='receipt(".$pos_id.")'>";
$datas[$i]['s_delete'] = "<input type='button' value='Delete Order' id='d_o_button_".$pos_id."' onclick='delete_s_func(".$pos_id.")'>";
$i++;
}

echo json_encode($datas);

?>