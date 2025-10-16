<?
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$adj = $_REQUEST['orate'] - $_REQUEST['oqty'];
$rate = $_REQUEST['orate1'];
$warehouse_id = $_REQUEST['warehouse_id'];

$item_all = find_all_field('item_info','','item_id="'.$_REQUEST['item_id'].'"');

$purpose = $_REQUEST['purpose'];

$group_for = $_REQUEST['group_for'];

$ledger_id=$_REQUEST['ledger_id'];


$sub_group = $_REQUEST['sub_group'];
$sub_group_ledger = find_all_field('item_sub_group','','sub_group_id="'.$sub_group.'"');



$jv_no=next_journal_sec_voucher_id('','Opening Adjustment',$group_for);

$proj_id = 'clouderp'; 

$narration = 'Opening Adjustment#'.$_REQUEST['odate'].' (Item#'.$_REQUEST['item_id'].')';


//$amount = $_REQUEST['oqty']*$_REQUEST['orate'];

$jv_date = $_REQUEST['odate'];
$tr_from = 'Opening Adjustment';


if($adj>0)
{
	$in = 0; $out = $adj;
	$dr_amount=$out * $rate;

}
if($adj<0)
{
	$in = (-1)* $adj; $out = 0;
	$cr_amount=$in*$rate;
}

$del_id = find_a_field('journal_item','id','warehouse_id="'.$warehouse_id.'" and item_id = "'.$_REQUEST['item_id'].'" and tr_from = "Opening Adjustment"');

		
		if($del_id>0)
		{
		
			$sql = 'delete from journal_item where warehouse_id="'.$warehouse_id.'" and item_id = "'.$_REQUEST['item_id'].'" and tr_from = "Opening Adjustment"';
			db_query($sql);

			journal_item_control($_REQUEST['item_id'] ,$warehouse_id,$_REQUEST['odate'],$in,$out,'Opening Adjustment','0',$rate);
			echo 'Del & OK';
		}
		else
		{



		if($adj<0){

			add_to_sec_journal($proj_id, $jv_no, $jv_date, $sub_group_ledger->item_ledger, $narration,$cr_amount,'0',$tr_from,$item_all->item_id,$item_all->sub_ledger_id,'','',$group_for);
			add_to_sec_journal($proj_id, $jv_no, $jv_date,$ledger_id,$narration,'0',$cr_amount, $tr_from,$item_all->item_id,$item_all->sub_ledger_id,'','',$group_for);

		}else{

			add_to_sec_journal($proj_id, $jv_no, $jv_date, $sub_group_ledger->item_ledger, $narration,'0',$dr_amount,$tr_from,$item_all->item_id,$item_all->sub_ledger_id,'','',$group_for);
			add_to_sec_journal($proj_id, $jv_no, $jv_date,$ledger_id,$narration,$dr_amount,'0', $tr_from,$item_all->item_id,$item_all->sub_ledger_id,'','',$group_for);

		}


		sec_journal_journal($jv_no,$jv_no,$tr_from);
		

		journal_item_control($_REQUEST['item_id'] ,$warehouse_id,$_REQUEST['odate'],$in,$out,'Opening Adjustment','0',$rate,'','','','',$group_for);
		echo 'Ok';
		}

?>