<?php
define('AES_KEY', 'ROBI');
define('AES_IV', '1234567890123456');


function auth_encode($data){
    
$dataToEncrypt = $data;
    
$key = AES_KEY;
$iv = AES_IV;
$encode_parse = openssl_encrypt($dataToEncrypt, 'aes-256-cbc', $key, 0, $iv);
    
return $encode_parse ;
}

function url_encode($data){
    
$dataToEncrypt = $data;
    
    $key = AES_KEY;
    $iv = AES_IV;
$encode_parse = openssl_encrypt($dataToEncrypt, 'aes-256-cbc', $key, 0, $iv);
    
return $encode_parse ;
}

function url_decode($data){
$encryptedData = $data;
    $key = AES_KEY;
    $iv = AES_IV;
$decryptedData = openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
    return $decryptedData;
}
function auto_insert_sales_return_cogs_secoundary_toriqul($chalan_no)
{
$sql = 'select sr_no, sr_date, do_no, group_for, sum(cost_amt) as total_amt from sale_return_details
where sr_no="'.$chalan_no.'" GROUP by sr_no';
$query = db_query($sql);
$data=mysqli_fetch_object($query);
$group_for = $_SESSION['user']['group'];
$cc_code = 0;
$tr_from = 'GoodsReturnCOGS';
$proj_id='clouderp';
$config = find_all_field('config_group_class','',"group_for=".$group_for);
$jv_no=find_a_field('secondary_journal','jv_no','tr_no="'.$chalan_no.'" and tr_from="Goods Return"');
//next_journal_sec_voucher_id('','COGS',$_SESSION['user']['depot']);
$tr_no = $data->sr_no;
$tr_id = $data->do_no;
$jv_date = $data->sr_date;
$narration = 'SR# '.$chalan_no.' (SO# '.$data->do_no.')';

  $sql2 = 'select s.item_ledger,  c.cost_amt  as item_amt,i.sub_ledger_id from sale_return_details c, item_info i, item_sub_group s 
where c.item_id=i.item_id and i.sub_group_id=s.sub_group_id and c.sr_no="'.$chalan_no.'"  order by s.sub_group_id';
$query2 =db_query($sql2);
while($data2=mysqli_fetch_object($query2)){
//$narration_dr ='PR# '.$data2->pr_no.' (PO# '.$data2->po_no.')';
add_to_sec_journal($proj_id, $jv_no, $jv_date, $config->cogs_ledger, $narration,    '0',$data2->item_amt,  $tr_from, $tr_no,$data2->sub_ledger_id,$tr_id, $cc_code, $group_for,'','','','','','','','NO');
add_to_sec_journal($proj_id, $jv_no, $jv_date, $data2->item_ledger, $narration,  ($data2->item_amt),  '0', $tr_from, $tr_no,$data2->sub_ledger_id,$tr_id, $cc_code, $group_for,'','','','','','','','NO');
}
$trr_from='Goods Return';
$sa_config = find_a_field('voucher_config','secondary_approval','voucher_type="'.$trr_from.'"');
$time_now = date('Y-m-d H:i:s');
if($sa_config=="Yes"){
$sa_up='update secondary_journal set secondary_approval="Yes", om_checked_at="'.$time_now.'", om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$trr_from.'"';
db_query($sa_up);
$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$trr_from.'"');
if($jv_config=="Yes"){
//sec_journal_journal($jv_no,$jv_no,$trr_from);
$time_now = date('Y-m-d H:i:s');
//$up2='update secondary_journal set checked="YES",checked_at="'.$time_now.'", checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$trr_from.'"';
//db_query($up2);
//$sa_up2='update journal set secondary_approval="Yes", checked="YES", checked_by="'.$_SESSION['user']['id'].'", checked_at="'.$time_now.'", om_checked_at="'.$time_now.'" ,om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$trr_from.'"';
//db_query($sa_up2);
}
} else {
$sa_up='update secondary_journal set secondary_approval="No" where jv_no="'.$jv_no.'" and tr_from="'.$trr_from.'"';
db_query($sa_up);
}
}

function auto_insert_sales_return_secoundary_toriqul($chalan_no)
{
$proj_id = 'clouderp';
$group_for =  $_SESSION['user']['group'];
$do_master = find_all_field('sale_return_master','','sr_no='.$chalan_no);
$dealer = find_all_field('dealer_info','',"dealer_code=".$do_master->dealer_code);
$sale_master=find_all_field('sale_do_master','','do_no='.$do_master->do_no);
$return_type = find_a_field('sales_return_type','sales_return_type','id="'.$do_master->do_type.'"');
$jv_no=next_journal_sec_voucher_id('',$return_type,$group_for);
$tr_id = $do_master->sr_no;
$tr_no = $chalan_no;
$tr_from = $return_type;
$narration = 'SR No# '.$chalan_no.' (SO# '.$do_master->do_no.')';
$sql = "select sum(total_amt) as total_amt from sale_return_details c where sr_no=".$do_master->sr_no;
$ch = find_all_field_sql($sql);
$sales_amt = $ch->total_amt;
$jv_date = $do_master->sr_date;
$invoice_amt = ($sales_amt);
if($sale_master->vat>0){
$vat=$sale_master->vat;
$vat_amt=$invoice_amt*$vat/100;
}
if($sale_master->discount>0){
$dis=$sale_master->discount;
$dis_amt=$invoice_amt*$dis/100;
}

if($sale_master->ait>0){
$ait_on_sales = ($invoice_amt*$sale_master->ait)/100;
}

$totAmt=($invoice_amt+$vat_amt+$ait_on_sales)-$dis_amt;
//$config_ledger = find_all_field('config_group_class','sales_ledger',"group_for=".$group_for);
$config_ledger = find_all_field('config_group_class','sales_ledger',"group_for=".$_SESSION['user']['group']);
$dealer_ledger= $dealer->account_code;
$cc_code = $do_master->depot_id;
//debit	
//$ssql='select sum(d.total_amt) as total_amt,s.item_ledger from sale_return_details d,item_info i,item_sub_group s where d.item_id=i.item_id and i.sub_group_id=s.sub_group_id and d.sr_no='.$chalan_no.' group by s.sub_group_id';
//$squery=db_query($ssql);
//while($sdata=mysqli_fetch_object($squery)){
//if($invoice_amt>0)
//add_to_sec_journal($proj_id, $jv_no, $jv_date, $sdata->item_ledger, $narration,$sdata->total_amt, '0',  $tr_from, $tr_no,'',$tr_id,$cc_code,$group_for,'','','','','','','','NO'); 
//}
if($invoice_amt>0)
add_to_sec_journal($proj_id, $jv_no, $jv_date, $config_ledger->sales_return, $narration,($invoice_amt), '0', $tr_from, $tr_no,$dealer->sub_ledger_id,$tr_id,$cc_code,$group_for,'','','','','','','','NO');


if($sale_master->vat>0){
add_to_sec_journal($proj_id, $jv_no, $jv_date, $config_ledger->sales_vat, $narration, ($vat_amt), '0', $tr_from, $tr_no,$dealer->sub_ledger_id,$tr_id,$cc_code,$group_for,'','','','','','','','NO');
}

if($ait_on_sales>0){

add_to_sec_journal($proj_id, $jv_no, $jv_date, $config_ledger->ait_payable, $narration,  ($ait_on_sales), '0', $tr_from, $tr_no,$dealer->sub_ledger_id,$tr_id,$cc_code,$group_for);
}


if($sale_master->discount>0){
add_to_sec_journal($proj_id, $jv_no, $jv_date, $config_ledger->sales_discount, $narration,'0', ($dis_amt), $tr_from, $tr_no,$dealer->sub_ledger_id,$tr_id,$cc_code,$group_for,'','','','','','','','NO');
}
if($invoice_amt>0)
add_to_sec_journal($proj_id, $jv_no, $jv_date, $dealer_ledger, $narration, '0', ($totAmt) , $tr_from, $tr_no,$dealer->sub_ledger_id,$tr_id,$cc_code,$group_for,'','','','','','','','NO');
auto_insert_sales_return_cogs_secoundary_toriqul($chalan_no);
$sa_config = find_a_field('voucher_config','secondary_approval','voucher_type="'.$tr_from.'"');
$time_now = date('Y-m-d H:i:s');
if($sa_config=="Yes"){
$sa_up='update secondary_journal set secondary_approval="Yes", om_checked_at="'.$time_now.'", om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';
db_query($sa_up);
$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$tr_from.'"');
if($jv_config=="Yes"){
//sec_journal_journal($jv_no,$jv_no,$tr_from);
$time_now = date('Y-m-d H:i:s');
//$up2='update secondary_journal set checked="YES",checked_at="'.$time_now.'", checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';
//db_query($up2);
//$sa_up2='update journal set secondary_approval="Yes", checked="YES", checked_by="'.$_SESSION['user']['id'].'", checked_at="'.$time_now.'", om_checked_at="'.$time_now.'" ,om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';
//db_query($sa_up2);
}
} else {
$sa_up='update secondary_journal set secondary_approval="No" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';
db_query($sa_up);
}
}


function auto_insert_bulksales_return_cogs_secoundary_toriqul($chalan_no)
{
$group_for = $_SESSION['user']['group'];
$cc_code = 0;
$tr_from = 'GoodsReturnCOGS';
$proj_id='clouderp';
$config = find_all_field('config_group_class','',"group_for=".$group_for);
$jv_no=find_a_field('secondary_journal','jv_no','tr_no="'.$chalan_no.'" and tr_from="Goods Return"');
//next_journal_sec_voucher_id('','COGS',$_SESSION['user']['depot']);
$cogSql='select item_price,final_price from journal_item where tr_from in ("Purchase","Opening","Production Receive") order by id desc group by item_id';
$sql = 'select item_id,sr_no, sr_date, do_no, group_for,total_unit from sale_return_details where sr_no="'.$chalan_no.'" GROUP by item_id';
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$tr_no = $data->sr_no;
$tr_id = $data->do_no;
$jv_date = $data->sr_date;
$narration = 'SR# '.$chalan_no.' (SO# '.$data->do_no.')';
$cost_price=find_a_field('journal_item','final_price','item_id="'.$data->item_id.'"   order by id desc ');
$cost_amt+= ($data->total_unit*$cost_price); 
}

  $sql2 = 'select s.item_ledger, c.item_id,c.total_unit,i.sub_ledger_id from sale_return_details c, item_info i, item_sub_group s 
where c.item_id=i.item_id and i.sub_group_id=s.sub_group_id and c.sr_no="'.$chalan_no.'"  order by s.sub_group_id';
$query2 = db_query ($sql2);
while($data2=mysqli_fetch_object($query2)){
$cost_price1=find_a_field('journal_item','final_price','item_id="'.$data2->item_id.'"  order by id desc ');
$cost_amt1= ($data2->total_unit*$cost_price1); 
//$narration_dr ='PR# '.$data2->pr_no.' (PO# '.$data2->po_no.')';
add_to_sec_journal($proj_id, $jv_no, $jv_date, $data2->item_ledger, $narration,  ($cost_amt1),   '0',$tr_from, $tr_no,$data2->sub_ledger_id,$tr_id, $cc_code, $group_for,'','','','','','','','NO');
add_to_sec_journal($proj_id, $jv_no, $jv_date, $config->cogs_ledger, $narration,  '0', $cost_amt1,   $tr_from, $tr_no,$data2->sub_ledger_id,$tr_id, $cc_code, $group_for,'','','','','','','','NO');
}
$sa_config = find_a_field('voucher_config','secondary_approval','voucher_type="'.$tr_from.'"');
$time_now = date('Y-m-d H:i:s');
if($sa_config=="Yes"){
//$sa_up='update secondary_journal set secondary_approval="Yes", om_checked_at="'.$time_now.'", om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';
//b_query($sa_up);
$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$tr_from.'"');
if($jv_config=="Yes"){
//sec_journal_journal($jv_no,$jv_no,$tr_from);
//$time_now = date('Y-m-d H:i:s');
//$up2='update secondary_journal set checked="YES", checked_at="'.$time_now.'", checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';
//db_query($up2);
//$sa_up2='update journal set secondary_approval="Yes", checked="YES", checked_by="'.$_SESSION['user']['id'].'", checked_at="'.$time_now.'", om_checked_at="'.$time_now.'" ,om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';
//db_query($sa_up2);
}
} else {
$sa_up='update secondary_journal set secondary_approval="No" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';
db_query($sa_up);
}
}

function auto_insert_bulksales_return_secoundary_toriqul($chalan_no)
{
$proj_id = 'clouderp';
$group_for =  $_SESSION['user']['group'];
$do_master = find_all_field('sale_return_master','','sr_no='.$chalan_no);
$dealer = find_all_field('dealer_info','',"dealer_code=".$do_master->dealer_code);
//$sale_master=find_all_field('sale_do_master','','do_no='.$do_master->do_no);
$return_type = find_a_field('sales_return_type','sales_return_type','id="'.$do_master->do_type.'"');
$jv_no=next_journal_sec_voucher_id('',$return_type,$group_for);
$tr_id = $do_master->sr_no;
$tr_no = $chalan_no;
$tr_from = $return_type;
$narration = 'SR No# '.$chalan_no;
$sql = "select sum(total_amt) as total_amt from sale_return_details c where  sr_no=".$do_master->sr_no;
$ch = find_all_field_sql($sql);
$sales_amt = $ch->total_amt;
$jv_date = $do_master->sr_date;
$invoice_amt = ($sales_amt);
if($sale_master->vat>0){
$vat=$sale_master->vat;
$vat_amt=$invoice_amt*$vat/100;
}
if($sale_master->discount>0){
$dis=$sale_master->discount;
$dis_amt=$invoice_amt*$dis/100;
}
$totAmt=$invoice_amt+$vat_amt-$dis_amt;
//$config_ledger = find_all_field('config_group_class','sales_ledger',"group_for=".$group_for);
$config_ledger = find_all_field('config_group_class','sales_ledger',"group_for=".$_SESSION['user']['group']);
$dealer_ledger= $dealer->account_code;
$cc_code = $do_master->depot_id;
//debit	
if($invoice_amt>0)
add_to_sec_journal($proj_id, $jv_no, $jv_date, $config_ledger->sales_return, $narration,($invoice_amt), '0',  $tr_from, $tr_no,$dealer->sub_ledger_id,$tr_id,$cc_code,$group_for,'','','','','','','','NO'); 
if($invoice_amt>0)
add_to_sec_journal($proj_id, $jv_no, $jv_date, $dealer_ledger, $narration, '0', ($totAmt) , $tr_from, $tr_no,$dealer->sub_ledger_id,$tr_id,$cc_code,$group_for,'','','','','','','','NO');
auto_insert_bulksales_return_cogs_secoundary_toriqul($chalan_no);
$sa_config = find_a_field('voucher_config','secondary_approval','voucher_type="'.$tr_from.'"');
$time_now = date('Y-m-d H:i:s');
if($sa_config=="Yes"){
$sa_up='update secondary_journal set secondary_approval="Yes", om_checked_at="'.$time_now.'", om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';
db_query($sa_up);
$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$tr_from.'"');
if($jv_config=="Yes"){
//sec_journal_journal($jv_no,$jv_no,$tr_from);
//$time_now = date('Y-m-d H:i:s');
//$up2='update secondary_journal set checked="YES",checked_at="'.$time_now.'", checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';
//db_query($up2);
//$sa_up2='update journal set secondary_approval="Yes", checked="YES", checked_by="'.$_SESSION['user']['id'].'", checked_at="'.$time_now.'", om_checked_at="'.$time_now.'" ,om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';
//db_query($sa_up2);
}
} else {
$sa_up='update secondary_journal set secondary_approval="No" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';
db_query($sa_up);
}
}
////Purchase Return 
function auto_insert_purchase_return_secoundary_toriqul($pr_no)
{
$proj_id = 'clouderp';
$group_for =  $_SESSION['user']['group'];
$po_master = find_all_field('purchase_return_master','','pr_no='.$pr_no);
$vendor = find_all_field('vendor','',"vendor_id=".$po_master->vendor_id);
$return_type = find_a_field('purchase_return_type','return_type','id="'.$po_master->return_type.'"');
$jv_no=next_journal_sec_voucher_id('',$return_type,$group_for);
$tr_id = $po_master->pr_no;
$tr_no = $pr_no;
$tr_from = $return_type;
$narration = 'PurchaseReturn# '.$pr_no;
$sql = "select sum(total_amt) as total_amt from purchase_return_details  where  pr_no=".$po_master->pr_no;
$ch = find_all_field_sql($sql);
$return_amt = $ch->total_amt;
$jv_date = $po_master->pr_date;
$invoice_amt = ($return_amt);
if($po_master->vat>0){
$vat=$po_master->vat;
$vat_amt=$invoice_amt*$vat/100;
}
//	if($sale_master->discount>0){
//	$dis=$sale_master->discount;
//	$dis_amt=$invoice_amt*$dis/100;
//	}
$totAmt=$invoice_amt+$vat_amt;
//$config_ledger = find_all_field('config_group_class','sales_ledger',"group_for=".$group_for);
$config_ledger = find_all_field('config_group_class','sales_ledger',"group_for=".$_SESSION['user']['group']);
$vendor_ledger= $vendor->ledger_id;
$cc_code = $po_master->depot_id;
//debit	
$rql='select  d.total_amt  as total_amt,s.item_ledger,i.sub_group_id,i.sub_ledger_id from purchase_return_details d,item_info i,item_sub_group s where d.item_id=i.item_id and i.sub_group_id=s.sub_group_id and d.pr_no='.$pr_no.'  ';
$rquery=db_query($rql);
while($rdata=mysqli_fetch_object($rquery)){
 
add_to_sec_journal($proj_id, $jv_no, $jv_date, $rdata->item_ledger, $narration, '0',$rdata->total_amt,  $tr_from, $tr_no,$rdata->sub_ledger_id,$tr_id,$cc_code,$group_for,'','','','','','','','NO'); 
}
if($po_master->vat>0){
add_to_sec_journal($proj_id, $jv_no, $jv_date, $config_ledger->purchase_vat, $narration, '0',($vat_amt), $tr_from, $tr_no,$vendor->sub_ledger_id,$tr_id,$cc_code,$group_for,'','','','','','','','NO');
}
if($invoice_amt>0)
add_to_sec_journal($proj_id, $jv_no, $jv_date, $vendor_ledger, $narration, ($totAmt) ,'0', $tr_from, $tr_no,$vendor->sub_ledger_id,$tr_id,$cc_code,$group_for,'','','','','','','','NO');
$sa_config = find_a_field('voucher_config','secondary_approval','voucher_type="'.$tr_from.'"');
$time_now = date('Y-m-d H:i:s');
if($sa_config=="Yes"){
//$sa_up='update secondary_journal set secondary_approval="Yes", om_checked_at="'.$time_now.'", om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';
//db_query($sa_up);
$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$tr_from.'"');
//if($jv_config=="Yes"){
//sec_journal_journal($jv_no,$jv_no,$tr_from);
//$time_now = date('Y-m-d H:i:s');
//$up2='update secondary_journal set checked="YES",checked_at="'.$time_now.'", checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';
//db_query($up2);
//$sa_up2='update journal set secondary_approval="Yes", checked="YES", checked_by="'.$_SESSION['user']['id'].'", checked_at="'.$time_now.'", om_checked_at="'.$time_now.'" ,om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';
//db_query($sa_up2);
//}
} else {
//$sa_up='update secondary_journal set secondary_approval="No" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';
//db_query($sa_up);
}
}


function haversineDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo) {
  $earthRadius = 6371000; // Radius of the earth in meters


  
  $latFrom = deg2rad((float) $latitudeFrom);
  $lonFrom = deg2rad((float) $longitudeFrom);
  $latTo = deg2rad((float) $latitudeTo);
  $lonTo = deg2rad((float) $longitudeTo);

  $latDelta = $latTo - $latFrom;
  $lonDelta = $lonTo - $lonFrom;

  $a = pow(sin($latDelta / 2), 2) +
       cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2);
  $c = 2 * asin(sqrt($a));

  return $earthRadius * $c;
}

?>