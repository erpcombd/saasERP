<?php
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$master_id   = $_POST['id'];
$group_for = $_POST['group_for'];
$dpc_date=$_POST['dpc_date'];
$production=$_POST['monthly_production'];
$asset_all=find_all_field('asset_register','id','id="'.$master_id.'"');

$dpc_value=$asset_all->unit_cost*$production;
$dpc_rate=($asset_all->price-$asset_all->salvage_value)/$dpc_value;
 $mon = (int) date('m', strtotime($dpc_date));
$year = date('Y', strtotime($dpc_date));

 $exist=find_a_field('dpc_duration_info','id','mon="'.$mon.'" and year="'.$year.'" and asset_id="'.$asset_all->asset_id.'"');

	if(!$exist){
	$minsert = 'insert into dpc_duration_info set mon="'.$mon.'",year="'.$year.'",dpc_date="'.$dpc_date.'",asset_id="'.$asset_all->asset_id.'",item_id="'.$asset_all->item_id.'",sub_group_id="'.$asset_all->sub_group_id.'",entry_by="'.$_SESSION['user']['id'].'",entry_at="'.date('Y-m-d H:i:s').'",group_for="'.$group_for.'",warehouse_id="'.$asset_all->warehouse_id.'",dpc_type="'.$asset_all->dpc_type.'",dpc_cycle="'.$asset_all->dpc_cycle.'",dpc_rate="'.$dpc_rate.'",monthly_production="'.$production.'"';
	db_query($minsert);
}
else{
echo "<span style='color:red;font-size:20px;'><strong>Already Depriciated this month!!</strong></span>";
}


//$sql='select a.*,i.*,d.id as master_id,d.dpc_date,d.group_for as cid, d.dpc_type as type,d.dpc_cycle as cycle,d.dpc_rate as rate 
//
//from asset_register a, item_info i, dpc_duration_info d 
//
//where a.item_id=i.item_id and a.asset_id=d.asset_id and d.status="pending" and r.id="'.$master_id.'"';
//$query=db_query($sql);
//
//$data = mysqli_fetch_object($query);
//$actual_value = $data->price-$data->salvage_value;
//
//$tr_from = 'Depreciation';
//
//
//
//$jv_date = $data->dpc_date;
//$narration = 'Depreciation Calculation';
//$update = 'update dpc_duration_info set status="done" where id="'.$exist.'"';
//db_query($update);
//
//$jv_no=next_journal_sec_voucher_id('',$tr_from,$data->cid);
//$ledger_all=find_all_field('item_info i','i.ledger_id','i.item_id='.$data->item_id.'');
//asset_journal($jv_no,$jv_date,$data->asset_id,$ledger_all->asset_ledger,$narration,0,($dpc_value),$tr_from,$master_id,$data->cid,$data->warehouse_id);
//$dr_ledger =$ledger_all->depreciation_expense;
//$cr_ledger = $ledger_all->acc_depreciation;
//
////add_to_sec_journal('mep', $jv_no, $jv_date, $dr_ledger, $narration, $dpc_value, 0, $tr_from, $tr_no,$data->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
////add_to_sec_journal('mep', $jv_no, $jv_date, $cr_ledger, $narration,  0,$dpc_value, $tr_from, $tr_no,$data->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
//
// $insert_sec="INSERT INTO `secondary_journal` 
//( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`,sub_ledger,  `group_for`, `entry_by`, `entry_at`) 
//
//VALUES 
//
//('MEP',".$jv_no.", '".$jv_date."', ".$dr_ledger.",'".$narration."',".$dpc_value.",'0', '".$tr_from."', ".$master_id.",". $ledger_all->item_sub_ledger.",".$data->cid.",".$_SESSION['user']['id'].",''),
//('MEP',".$jv_no.", '".$jv_date."', ".$cr_ledger.",'".$narration."','0',".$dpc_value.", '".$tr_from."', ".$master_id.",". $ledger_all->item_sub_ledger.",".$data->cid.",".$_SESSION['user']['id'].",'')";
//
//db_query($insert_sec);
//
////sec_journal_journal2($jv_no,$jv_no,$tr_from);
//
//$sa_config = find_a_field('voucher_config','secondary_approval','voucher_type="'.$tr_from.'"');
//
//
//
//$time_now = date('Y-m-d H:i:s');
//
//
//
//if($sa_config=="Yes"){
//
//
//
//$sa_up='update secondary_journal set secondary_approval="Yes", om_checked_at="'.$time_now.'", om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';
//
//
//
//db_query($sa_up);
//
//
//
//$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$tr_from.'"');
//
//
//
//
//
//if($jv_config=="Yes"){
//
//
//$insert_jur="INSERT INTO `journal` 
//( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`,sub_ledger,  `group_for`, `entry_by`, `entry_at`) 
//
//VALUES 
//
//('MEP',".$jv_no.", '".$jv_date."', ".$dr_ledger.",'".$narration."',".$dpc_value.",'0', '".$tr_from."', ".$master_id.",". $ledger_all->item_sub_ledger.",".$data->cid.",".$_SESSION['user']['id'].",''),
//('MEP',".$jv_no.", '".$jv_date."', ".$cr_ledger.",'".$narration."','0',".$dpc_value.", '".$tr_from."', ".$master_id.",". $ledger_all->item_sub_ledger.",".$data->cid.",".$_SESSION['user']['id'].",'')";
//
//db_query($insert_jur);
//$time_now = date('Y-m-d H:i:s');
//
//
//
//$up2='update secondary_journal set checked="YES", checked_at="'.$time_now.'", checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';
//
//
//
//db_query($up2);
//
//
//
//$sa_up2='update journal set secondary_approval="Yes", checked="YES", checked_by="'.$_SESSION['user']['id'].'", checked_at="'.$time_now.'", om_checked_at="'.$time_now.'" ,om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';
//
//db_query($sa_up2);
//
//
//
//
//
//}
//
//
//
//} else {
//
//
//
//$sa_up='update secondary_journal set secondary_approval="No" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';
//
//
//
//db_query($sa_up);
//
//
//
//}

$all['msg'] = 'Done';

echo json_encode($all);

?>
