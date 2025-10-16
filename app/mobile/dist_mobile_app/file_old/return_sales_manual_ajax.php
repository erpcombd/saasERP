<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';



$warehouse_id	=$_SESSION['user']['warehouse_id'];

$gift_status    =$_POST['gift_status'];
$item_id        =$_POST['id'];

$info = findall("select * from item_info where item_id='".$item_id."'");


if($gift_status==1){

$git_items = [100104125, 100104126, 100104127, 100104128, 100104129, 100104130, 100104133, 100104134, 100104135, 100104136, 100104137, 100104138];
if (in_array($info->item_id, $git_items)) {
    $nsp_per        = $info->nsp_per-7;
} else {
    $nsp_per        = $info->nsp_per;
}

}else{
    $nsp_per        = $info->nsp_per;
}







$price          = $info->t_price;
$unit           = $info->unit_name;
$pkt_size       = $info->pack_size;
$nsp_amt        = $price-(($nsp_per/100)*$price);
$item_name      = $info->finish_goods_code.' '.$info->item_name;



// ------------- stock qty
$t_date=date('Y-m-d');
$date_con       = ' and chalan_date <= "'.$t_date.'"';
//$opening_date   = find1("select max(ji_date) from ss_journal_item where tr_from='".Opening."' and warehouse_id='".$warehouse_id."' ");
$opening_date   ='2023-10-01';

$pri_chalan=find1("select sum(total_unit) as qty 
from sale_do_chalan 
where chalan_date>='".$opening_date."' and chalan_date<='".date('Y-m-d')."' and dealer_code='".$warehouse_id."' ".$date_con." and item_id='".$item_id."' ");

// pri return
$pri_return=find1("select sum(d.total_unit) as qty 
from sale_return_master m, sale_return_details d 
where m.do_no=d.do_no and m.dealer_code='".$warehouse_id."' and m.do_date>='".$opening_date."' and d.item_id='".$item_id."' and m.status in ('CHECKED') ");


// 2nd bin card
$bin=find1("select sum(item_in-item_ex) as qty
from ss_journal_item
where warehouse_id='".$warehouse_id."' and ji_date>='".$opening_date."'
and ji_date<='".$t_date."' and item_id='".$item_id."'
");

$item_stock_view= ($pri_chalan+$bin-$pri_return);





$arr = array('price' => $price, 'unit' => $unit, 'pkt_size' => $pkt_size, 'nsp_per' => $nsp_per, 'nsp_amt' => $nsp_amt, 'item_name' => $item_name, 'item_stock_view' => $item_stock_view);

echo json_encode($arr);


?>