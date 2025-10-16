<?

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$order_no = $_REQUEST['order_no'];
$exjv_no = $_REQUEST['jv_no'];
$jv_date = $_REQUEST['jv_date'];
$ledger_id = $_REQUEST['ledger_id'];
$dr_amt = $_REQUEST['dr_amt'];
$cr_amt = $_REQUEST['cr_amt'];
$fixed_asset_id = $_REQUEST['asset_id'];
$tr_no = $_REQUEST['tr_no'];
$flag = $_REQUEST['flag'];
$group_for = $_REQUEST['group_for'];

if($dr_amt>0){
$tr_from='Addition';
}elseif($cr_amt>0){
$tr_from='Adjustment';
}

$entry_by=$_SESSION['user']['id'];
$entry_at=date('Y-m-d H:i:s');

$narration = "Spare Parts Addition";

$ledger_all=find_all_field('asset_register i,item_info s','s.ledger_id','i.item_id=s.item_id and i.asset_id='.$fixed_asset_id.'');

$jv_no=next_journal_sec_voucher_id('',$tr_from,$group_for);

if($fixed_asset_id>0){

//asset_journal($jv_no,$jv_date,$fixed_asset_id,$ledger_all->asset_ledger,$narration,$dr_amt,0,$tr_from,$exjv_no,$group_for,$_SESSION['user']['depot']);
// Fixed Asset Journal
  $insert = "INSERT INTO fixed_asset_journal
 
(jv_no,jv_date,fixed_asset_id,ledger_id,narration,dr_amt,cr_amt,tr_from,tr_no,group_for,warehouse_id)

VALUES 

(".$jv_no.", '".$jv_date."', ".$fixed_asset_id.",".$ledger_all->asset_ledger.",'".$narration."',".$dr_amt.",'0', '".$tr_from."', ".$exjv_no.",".$group_for.",".$_SESSION['user']['depot'].")";

 db_query($insert);


  $insert_sec="INSERT INTO `secondary_journal` 
( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, sub_ledger, `group_for`, `entry_by`, `entry_at`) 

VALUES 

('MEP',".$jv_no.", '".$jv_date."', ".$ledger_all->asset_ledger.",'".$narration."',".$dr_amt.",'0', '".$tr_from."', ".$exjv_no.",".$ledger_all->item_sub_ledger.",".$group_for.",".$_SESSION['user']['id'].",''),
('MEP',".$jv_no.", '".$jv_date."', ".$ledger_id.",'".$narration."','0',".$dr_amt.", '".$tr_from."', ".$exjv_no.",".$ledger_all->item_sub_ledger.",".$group_for.",".$_SESSION['user']['id'].",'')";

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
( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`,sub_ledger,  `group_for`, `entry_by`, `entry_at`) 

VALUES 

('MEP',".$jv_no.", '".$jv_date."', ".$ledger_all->asset_ledger.",'".$narration."',".$dr_amt.",'0', '".$tr_from."', ".$exjv_no.",".$ledger_all->item_sub_ledger.",".$group_for.",".$_SESSION['user']['id'].",''),
('MEP',".$jv_no.", '".$jv_date."', ".$ledger_id.",'".$narration."','0',".$dr_amt.", '".$tr_from."', ".$exjv_no.",".$ledger_all->item_sub_ledger.",".$group_for.",".$_SESSION['user']['id'].",'')";

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

$all['msg'] = 'Success!';
}else {
$all['msg'] = 'Failed!';
}

echo json_encode($all);
?>