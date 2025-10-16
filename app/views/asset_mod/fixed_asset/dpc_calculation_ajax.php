<?php
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$master_id   = $_POST['master_id'];
$group_for = $_POST['group_for'];

$dpc_date = $_POST['dpc_date'];

$sql='select a.*,i.*,d.id as master_id,d.dpc_date,d.group_for as cid, d.dpc_type as type,d.dpc_cycle as cycle,d.dpc_rate as rate ,d.monthly_production, sum(f.dr_amt-f.cr_amt) asset_value

from asset_register a, item_info i, dpc_duration_info d, fixed_asset_journal f 

where a.item_id=i.item_id and a.asset_id=d.asset_id and  f.fixed_asset_id=a.asset_id and d.status="pending" and d.id="'.$master_id.'"';
$query=db_query($sql);

$data = mysqli_fetch_object($query);
$actual_value = $data->asset_value-$data->salvage_value;

$tr_from = 'Depreciation';

if($data->dpc_type==1){
$dpc_value = $actual_value/$data->life_duration;
}elseif($data->dpc_type==2){
$dpc_value = $data->monthly_production*$data->unit_cost;
}elseif($data->dpc_type==3){
$dpc_value = $actual_value/$data->life_duration;
}
$jv_date = $dpc_date;
$narration = 'Depreciation Calculation';
$update = 'update dpc_duration_info set status="done", dpc_date="'.$dpc_date.'" where id="'.$master_id.'"';
db_query($update);

$jv_no=next_journal_sec_voucher_id('',$tr_from,$data->cid);
$ledger_all=find_all_field('item_info i','item_id','i.item_id='.$data->item_id.'');
asset_journal($jv_no,$jv_date,$data->asset_id,$ledger_all->asset_ledger,$narration,0,($dpc_value),$tr_from,$master_id,$data->cid,$data->warehouse_id);
$moh_ledger =$ledger_all->depreciation_expense;
$aoh_ledger =$ledger_all->depreciation_aoh;
$soh_ledger =$ledger_all->depreciation_soh;
$cr_ledger = $ledger_all->acc_depreciation;
$sub_ledger = $ledger_all->item_sub_ledger;
$cc_code=$ledger_all->cc_code;

$moh_dpc_value=$dpc_value*($ledger_all->moh_per/100);
$aoh_dpc_value=$dpc_value*($ledger_all->aoh_per/100);
$soh_dpc_value=$dpc_value*($ledger_all->soh_per/100);

//add_to_sec_journal('mep', $jv_no, $jv_date, $dr_ledger, $narration, $dpc_value, 0, $tr_from, $tr_no,$data->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
//add_to_sec_journal('mep', $jv_no, $jv_date, $cr_ledger, $narration,  0,$dpc_value, $tr_from, $tr_no,$data->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
if($moh_dpc_value>0 && $aoh_dpc_value>0 && $soh_dpc_value>0){
 $insert_sec="INSERT INTO `secondary_journal` 
( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, sub_ledger,cc_code, `group_for`, `entry_by`, `entry_at`) 

VALUES 

('MEP',".$jv_no.", '".$jv_date."', ".$moh_ledger.",'".$narration."',".$moh_dpc_value.",'0', '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",''),

('MEP',".$jv_no.", '".$jv_date."', ".$aoh_ledger.",'".$narration."',".$aoh_dpc_value.",'0', '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",''),
('MEP',".$jv_no.", '".$jv_date."', ".$soh_ledger.",'".$narration."',".$soh_dpc_value.",'0', '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",''),
('MEP',".$jv_no.", '".$jv_date."', ".$cr_ledger.",'".$narration."','0',".$dpc_value.", '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",'')";

db_query($insert_sec);
}

elseif($moh_dpc_value>0 && $aoh_dpc_value>0 && $soh_dpc_value<=0){

 $insert_sec="INSERT INTO `secondary_journal` 
( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, sub_ledger,cc_code, `group_for`, `entry_by`, `entry_at`) 

VALUES 

('MEP',".$jv_no.", '".$jv_date."', ".$moh_ledger.",'".$narration."',".$moh_dpc_value.",'0', '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",''),

('MEP',".$jv_no.", '".$jv_date."', ".$aoh_ledger.",'".$narration."',".$aoh_dpc_value.",'0', '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",''),

('MEP',".$jv_no.", '".$jv_date."', ".$cr_ledger.",'".$narration."','0',".$dpc_value.", '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",'')";

db_query($insert_sec);


}

elseif($moh_dpc_value>0 && $soh_dpc_value>0 && $aoh_dpc_value<=0){

 $insert_sec="INSERT INTO `secondary_journal` 
( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, sub_ledger,cc_code, `group_for`, `entry_by`, `entry_at`) 

VALUES 

('MEP',".$jv_no.", '".$jv_date."', ".$moh_ledger.",'".$narration."',".$moh_dpc_value.",'0', '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",''),

('MEP',".$jv_no.", '".$jv_date."', ".$soh_dpc_value.",'".$narration."',".$soh_dpc_value.",'0', '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",''),

('MEP',".$jv_no.", '".$jv_date."', ".$cr_ledger.",'".$narration."','0',".$dpc_value.", '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",'')";

db_query($insert_sec);


}
elseif($aoh_dpc_value>0 && $soh_dpc_value>0 && $moh_dpc_value<=0){

 $insert_sec="INSERT INTO `secondary_journal` 
( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, sub_ledger,cc_code, `group_for`, `entry_by`, `entry_at`) 

VALUES 

('MEP',".$jv_no.", '".$jv_date."', ".$moh_ledger.",'".$narration."',".$aoh_dpc_value.",'0', '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",''),

('MEP',".$jv_no.", '".$jv_date."', ".$soh_dpc_value.",'".$narration."',".$soh_dpc_value.",'0', '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",''),

('MEP',".$jv_no.", '".$jv_date."', ".$cr_ledger.",'".$narration."','0',".$dpc_value.", '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",'')";

db_query($insert_sec);


}

elseif($moh_dpc_value>0 && $soh_dpc_value<=0 && $aoh_dpc_value<=0){

 $insert_sec="INSERT INTO `secondary_journal` 
( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, sub_ledger,cc_code, `group_for`, `entry_by`, `entry_at`) 

VALUES 

('MEP',".$jv_no.", '".$jv_date."', ".$moh_ledger.",'".$narration."',".$moh_dpc_value.",'0', '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",''),

('MEP',".$jv_no.", '".$jv_date."', ".$cr_ledger.",'".$narration."','0',".$dpc_value.", '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",'')";

db_query($insert_sec);


}
elseif($aoh_dpc_value>0 && $soh_dpc_value<=0 && $moh_dpc_value<=0){

 $insert_sec="INSERT INTO `secondary_journal` 
( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, sub_ledger,cc_code, `group_for`, `entry_by`, `entry_at`) 

VALUES 

('MEP',".$jv_no.", '".$jv_date."', ".$moh_ledger.",'".$narration."',".$aoh_dpc_value.",'0', '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",''),

('MEP',".$jv_no.", '".$jv_date."', ".$cr_ledger.",'".$narration."','0',".$dpc_value.", '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",'')";

db_query($insert_sec);


}

elseif($soh_dpc_value>0 && $moh_dpc_value<=0 && $aoh_dpc_value<=0){

 $insert_sec="INSERT INTO `secondary_journal` 
( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, sub_ledger,cc_code, `group_for`, `entry_by`, `entry_at`) 

VALUES 

('MEP',".$jv_no.", '".$jv_date."', ".$moh_ledger.",'".$narration."',".$soh_dpc_value.",'0', '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",''),

('MEP',".$jv_no.", '".$jv_date."', ".$cr_ledger.",'".$narration."','0',".$dpc_value.", '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",'')";

db_query($insert_sec);


}


//sec_journal_journal2($jv_no,$jv_no,$tr_from);

$sa_config = find_a_field('voucher_config','secondary_approval','voucher_type="'.$tr_from.'"');



$time_now = date('Y-m-d H:i:s');



if($sa_config=="Yes"){



$sa_up='update secondary_journal set secondary_approval="Yes", om_checked_at="'.$time_now.'", om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';



db_query($sa_up);



$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$tr_from.'"');





if($jv_config=="Yes"){


if($moh_dpc_value>0 && $aoh_dpc_value>0 && $soh_dpc_value>0){
 $insert_jur="INSERT INTO `journal` 
( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, sub_ledger,cc_code, `group_for`, `entry_by`, `entry_at`) 

VALUES 

('MEP',".$jv_no.", '".$jv_date."', ".$moh_ledger.",'".$narration."',".$moh_dpc_value.",'0', '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",''),

('MEP',".$jv_no.", '".$jv_date."', ".$aoh_ledger.",'".$narration."',".$aoh_dpc_value.",'0', '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",''),
('MEP',".$jv_no.", '".$jv_date."', ".$soh_ledger.",'".$narration."',".$soh_dpc_value.",'0', '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",''),
('MEP',".$jv_no.", '".$jv_date."', ".$cr_ledger.",'".$narration."','0',".$dpc_value.", '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",'')";

db_query($insert_jur);
}

elseif($moh_dpc_value>0 && $aoh_dpc_value>0 && $soh_dpc_value<=0){

 $insert_jur="INSERT INTO `journal` 
( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, sub_ledger,cc_code, `group_for`, `entry_by`, `entry_at`) 

VALUES 

('MEP',".$jv_no.", '".$jv_date."', ".$moh_ledger.",'".$narration."',".$moh_dpc_value.",'0', '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",''),

('MEP',".$jv_no.", '".$jv_date."', ".$aoh_ledger.",'".$narration."',".$aoh_dpc_value.",'0', '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",''),

('MEP',".$jv_no.", '".$jv_date."', ".$cr_ledger.",'".$narration."','0',".$dpc_value.", '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",'')";

db_query($insert_jur);


}

elseif($moh_dpc_value>0 && $soh_dpc_value>0 && $aoh_dpc_value<=0){

 $insert_jur="INSERT INTO `journal` 
( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, sub_ledger,cc_code, `group_for`, `entry_by`, `entry_at`) 

VALUES 

('MEP',".$jv_no.", '".$jv_date."', ".$moh_ledger.",'".$narration."',".$moh_dpc_value.",'0', '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",''),

('MEP',".$jv_no.", '".$jv_date."', ".$soh_dpc_value.",'".$narration."',".$soh_dpc_value.",'0', '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",''),

('MEP',".$jv_no.", '".$jv_date."', ".$cr_ledger.",'".$narration."','0',".$dpc_value.", '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",'')";

db_query($insert_jur);


}
elseif($aoh_dpc_value>0 && $soh_dpc_value>0 && $moh_dpc_value<=0){

 $insert_jur="INSERT INTO `journal` 
( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, sub_ledger,cc_code, `group_for`, `entry_by`, `entry_at`) 

VALUES 

('MEP',".$jv_no.", '".$jv_date."', ".$moh_ledger.",'".$narration."',".$aoh_dpc_value.",'0', '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",''),

('MEP',".$jv_no.", '".$jv_date."', ".$soh_dpc_value.",'".$narration."',".$soh_dpc_value.",'0', '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",''),

('MEP',".$jv_no.", '".$jv_date."', ".$cr_ledger.",'".$narration."','0',".$dpc_value.", '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",'')";

db_query($insert_jur);


}

elseif($moh_dpc_value>0 && $soh_dpc_value<=0 && $aoh_dpc_value<=0){

 $insert_jur="INSERT INTO `journal` 
( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, sub_ledger,cc_code, `group_for`, `entry_by`, `entry_at`) 

VALUES 

('MEP',".$jv_no.", '".$jv_date."', ".$moh_ledger.",'".$narration."',".$moh_dpc_value.",'0', '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",''),

('MEP',".$jv_no.", '".$jv_date."', ".$cr_ledger.",'".$narration."','0',".$dpc_value.", '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",'')";

db_query($insert_jur);


}
elseif($aoh_dpc_value>0 && $soh_dpc_value<=0 && $moh_dpc_value<=0){

 $insert_jur="INSERT INTO `journal` 
( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, sub_ledger,cc_code, `group_for`, `entry_by`, `entry_at`) 

VALUES 

('MEP',".$jv_no.", '".$jv_date."', ".$moh_ledger.",'".$narration."',".$aoh_dpc_value.",'0', '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",''),

('MEP',".$jv_no.", '".$jv_date."', ".$cr_ledger.",'".$narration."','0',".$dpc_value.", '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",'')";

db_query($insert_jur);


}

elseif($soh_dpc_value>0 && $moh_dpc_value<=0 && $aoh_dpc_value<=0){

 $insert_jur="INSERT INTO `journal` 
( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, sub_ledger,cc_code, `group_for`, `entry_by`, `entry_at`) 

VALUES 

('MEP',".$jv_no.", '".$jv_date."', ".$moh_ledger.",'".$narration."',".$soh_dpc_value.",'0', '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",''),

('MEP',".$jv_no.", '".$jv_date."', ".$cr_ledger.",'".$narration."','0',".$dpc_value.", '".$tr_from."', ".$master_id.",".$sub_ledger.",".$cc_code.",".$data->cid.",".$_SESSION['user']['id'].",'')";

db_query($insert_jur);


}

$time_now = date('Y-m-d H:i:s');



$up2='update secondary_journal set checked="YES", checked_at="'.$time_now.'", checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';



db_query($up2);



$sa_up2='update journal set secondary_approval="Yes", checked="YES", checked_by="'.$_SESSION['user']['id'].'", checked_at="'.$time_now.'", om_checked_at="'.$time_now.'" ,om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';

db_query($sa_up2);





}



} else {



$sa_up='update secondary_journal set secondary_approval="No" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';



db_query($sa_up);



}

$all['msg'] = 'Done';

echo json_encode($all);

?>
