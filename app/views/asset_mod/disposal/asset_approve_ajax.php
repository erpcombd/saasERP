<?php

session_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$all['msg'] = $_POST['id'];
//$asset_ledger=$_POST['asset_ledger'];
$info = find_all_field('asset_disposal_info','','id="'.$_POST['id'].'"');
$item_id=find_a_field('asset_register','item_id','asset_id="'.$info->asset_id.'"');
//$asset_ledger=find_a_field('item_sub_group','asset_ledger','sub_group_id="'.$sub_group_id.'"');
$update = 'update asset_disposal_info set status="Checked" where id="'.$_POST['id'].'"';
db_query($update);
$tr_from = 'Disposal';
$jv_date = date('Y-m-d');
$jv_no=next_journal_sec_voucher_id('',$tr_from,$info->group_for);
journal_asset_item_control($info->item_id ,$_SESSION['user']['depot'],$jv_date,0,1,$tr_from,$_POST['id'],$info->po_value,0,$_POST['id'],$info->po_value,0,0,$info->serial_no,$info->asset_id,'');
$narration = 'Asset Disposal';

$ledger_all=find_all_field('item_info i','i.item_id','i.item_id='.$item_id.'');

 $disposal_ac=$ledger_all->disposal_acc;
 $adep_ledger =$ledger_all->acc_depreciation;
$asset_ledger=$ledger_all->asset_ledger;
$sub_ledger=$ledger_all->item_sub_ledger;

asset_journal($jv_no,$jv_date,$info->asset_id,$asset_ledger,$narration,0,($info->current_value),$tr_from,$_POST['id'],$info->group_for,'');
//Secondary Journal
//add_to_sec_journal('AMI', $jv_no, $jv_date, $disposal_ac,$narration,$info->current_value,'0', $tr_from, $_POST['id'],'','','',$info->group_for,$entry_by,$entry_at);

//add_to_sec_journal('AMI', $jv_no, $jv_date, $adep_ledger,$narration,$info->total_dpc,'0', $tr_from, $_POST['id'],'','','',$info->group_for,$entry_by,$entry_at);

//add_to_sec_journal('AMI', $jv_no, $jv_date, $asset_ledger,$narration,'0',$info->po_value, $tr_from, $_POST['id'],'','','',$info->group_for,$entry_by,$entry_at);

//sec_journal_journal($jv_no,$jv_no,$tr_from);

$insert_sec="INSERT INTO `secondary_journal` 
( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, sub_ledger, `group_for`, `entry_by`, `entry_at`) 

VALUES 

('MEP',".$jv_no.", '".$jv_date."', ".$disposal_ac.",'".$narration."',".$info->current_value.",'0', '".$tr_from."', ".$_POST['id'].",".$sub_ledger.",".$info->group_for.",".$_SESSION['user']['id'].",''),
('MEP',".$jv_no.", '".$jv_date."', ".$adep_ledger.",'".$narration."',".$info->total_dpc.",'0', '".$tr_from."', ".$_POST['id'].",".$sub_ledger.",".$info->group_for.",".$_SESSION['user']['id'].",''),
('MEP',".$jv_no.", '".$jv_date."', ".$asset_ledger.",'".$narration."','0',".$info->po_value.", '".$tr_from."', ".$_POST['id'].",".$sub_ledger.",".$info->group_for.",".$_SESSION['user']['id'].",'')";

db_query($insert_sec);

//sec_journal_journal2($jv_no,$jv_no,$tr_from);

$sa_config = find_a_field('voucher_config','secondary_approval','voucher_type="'.$tr_from.'"');



$time_now = date('Y-m-d H:i:s');



if($sa_config=="Yes"){



$sa_up='update secondary_journal set secondary_approval="Yes", om_checked_at="'.$time_now.'", om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';



db_query($sa_up);



$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$tr_from.'"');





if($jv_config=="Yes"){


$insert_jur="INSERT INTO `journal` 
( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, sub_ledger, `group_for`, `entry_by`, `entry_at`) 

VALUES 

('MEP',".$jv_no.", '".$jv_date."', ".$disposal_ac.",'".$narration."',".$info->current_value.",'0', '".$tr_from."', ".$_POST['id'].",".$sub_ledger.",".$info->group_for.",".$_SESSION['user']['id'].",''),
('MEP',".$jv_no.", '".$jv_date."', ".$adep_ledger.",'".$narration."',".$info->total_dpc.",'0', '".$tr_from."', ".$_POST['id'].",".$sub_ledger.",".$info->group_for.",".$_SESSION['user']['id'].",''),
('MEP',".$jv_no.", '".$jv_date."', ".$asset_ledger.",'".$narration."','0',".$info->po_value.", '".$tr_from."', ".$_POST['id'].",".$sub_ledger.",".$info->group_for.",".$_SESSION['user']['id'].",'')";

db_query($insert_jur);

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


$update_register = 'update asset_register set item_status="Disposed" where asset_id="'.$info->asset_id.'"';
db_query($update_register);

$all['msg'] = 'Success! Approved';
echo json_encode($all)
?>