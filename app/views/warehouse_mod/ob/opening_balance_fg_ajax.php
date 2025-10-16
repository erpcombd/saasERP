<?
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$warehouse_id = $_REQUEST['warehouse_id'];
$_REQUEST['oqty'] = $_REQUEST['opic'];


$group_for =$_REQUEST['group_for'];
$retained_earnings=find_a_field('config_group_class g,accounts_ledger a','g.retained_earnings',' g.retained_earnings=a.ledger_id and g.group_for="'.$group_for.'"');
$inv_ledger=find_a_field('item_sub_group','item_ledger','sub_group_id="'.$_REQUEST['sub_group'].'"');
$item_all =find_all_field('item_info','','item_id="'.$_REQUEST['item_id'].'"');

$jv_no=next_journal_sec_voucher_id('','Opening',$group_for);
$proj_id = 'clouderp'; 

$narration = 'Opening#'.$_REQUEST['odate'].' (Item#'.$_REQUEST['item_id'].')';


$amount = $_REQUEST['oqty']*$_REQUEST['orate'];

$jv_date = $_REQUEST['odate'];
$tr_from = 'Opening';


if($retained_earnings>0){

    db_delete('journal_item','warehouse_id="'.$warehouse_id.'" and item_id = "'.$_REQUEST['item_id'].'" and tr_from = "Opening" order by id desc');


    db_delete_all('secondary_journal','jv_date="'.$_REQUEST['odate'].'"  and tr_no="'.$_REQUEST['item_id'].'" and sub_ledger = "'.$item_all->sub_ledger_id.'" and tr_from = "Opening"');

    db_delete_all('journal','jv_date="'.$_REQUEST['odate'].'"  and tr_no="'.$_REQUEST['item_id'].'" and sub_ledger = "'.$item_all->sub_ledger_id.'" and tr_from = "Opening"');

    journal_item_control($_REQUEST['item_id'] ,$warehouse_id,$_REQUEST['odate'],$_REQUEST['oqty'],0,'Opening','0',$_REQUEST['orate'],'','','','',$group_for);
  
    add_to_sec_journal($proj_id, $jv_no, $jv_date, $inv_ledger, $narration,($amount), '0', $tr_from,$item_all->item_id,$item_all->sub_ledger_id,'','',$group_for);

    add_to_sec_journal($proj_id, $jv_no, $jv_date,$retained_earnings,$narration,'0',($amount), $tr_from,$item_all->item_id,$item_all->sub_ledger_id,'','',$group_for);


    sec_journal_journal($jv_no,$jv_no,$tr_from);

    echo 'Success!';



}else{
    echo 'Please set retained earnings ledger and set it in config!'.$_REQUEST['group_for'];
}
?>