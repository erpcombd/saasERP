<?php
session_start();
ob_start();

require "../../../warehouse_mod/support/inc.all.php";
// ::::: Start Edit Section ::::: 
$title='Reprocess Issue Re-Hit';			// Page Name and Page Title
$table_master='production_issue_master';
$unique_master='pi_no';
$table_detail='production_issue_detail';
$unique_detail='id';

// /*
// For Single Re-hit
if($_REQUEST['pi_no']>0){
$pi_no = $_REQUEST['pi_no'];
$pi = $data = find_all_field('production_issue_master','pi_no','pi_no='.$pi_no);


if($data->pi_no>0){
		unset($_POST);
		$group_for = find_a_field('warehouse','group_for','warehouse_id='.$pi->warehouse_from);
		if($pi->warehouse_from==5)
		{
		$ledger_dr = '1097000300010002';
		$sales_ledger = '3002000100070000';
		$narration = 'PI No-'.$pi_no.'||RSL-'.$pi->rec_sl_no.'||RecDt:'.$pi->receive_date;
		auto_insert_sale_sc_out($pi->pi_date,$ledger_dr,$sales_ledger,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no,$cc_code,$narration);

		}
		elseif($pi->warehouse_from==17)
		{
		$sales_ledger = '1127000100010001';
		if($pi->warehouse_to==5)
		$ledger_dr = '1126000200010000';
		else
		$ledger_dr = '1126000100020000';
		
		//$cc_code = find_a_field_sql('select c.id from cost_center c, warehouse w where c.cc_code=w.acc_code and w.warehouse_id='.$pi->warehouse_from);
		//$ledger_dr = find_a_field('warehouse','ledger_id','warehouse_id='.$pi->warehouse_from);	
		$narration = 'PI No-'.$pi_no.'||SendDt:'.$pi->pi_date;
		auto_insert_sale_sc_out($pi->pi_date,$ledger_dr,$sales_ledger,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no,$cc_code,$narration);
		}
		elseif($pi->warehouse_from==68)
		{
		$ledger_cr = '3026000100050000';
		
		if($pi->warehouse_to==5)
		$sales_ledger = '1116000200010000';
		if($pi->warehouse_to==17)
		$sales_ledger = '1116000300010000';
		else
		$sales_ledger = '1119000100040003';

		$narration = 'PI No-'.$pi_no.'||SendDt:'.$pi->pi_date;
		auto_insert_sale_sc_out($pi->pi_date,$sales_ledger,$ledger_cr,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no,$cc_code,$narration);
		}
		elseif($group_for==2&&($pi->warehouse_to==5||$pi->warehouse_to==17||$pi->warehouse_to==68))
		{

if($pi->warehouse_to==5)
$sales_ledger = '1070000100020000';
elseif($pi->warehouse_to==17)
$sales_ledger = '1070001500020000';
elseif($pi->warehouse_to==68)
$sales_ledger = '1070004000100000';

$cc_code = find_a_field_sql('select c.id from cost_center c, warehouse w where c.cc_code=w.acc_code and w.warehouse_id='.$pi->warehouse_from);
$ledger_dr = find_a_field('warehouse','ledger_id','warehouse_id='.$pi->warehouse_from);	


		$narration = 'PI No-'.$pi_no.'||RSL-'.$pi->rec_sl_no.'||RecDt:'.$pi->receive_date;
		auto_insert_sale_sc_out($pi->pi_date,$sales_ledger,$ledger_dr,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no,$cc_code,$narration);
		}
		else
		{
		$ledger_cr = 1078000200010000;
		$cc_code = find_a_field_sql('select c.id from cost_center c, warehouse w where c.cc_code=w.acc_code and w.warehouse_id='.$pi->warehouse_from);
		$sales_ledger = find_a_field('warehouse','ledger_id','warehouse_id='.$pi->warehouse_from);	
		$narration = 'PI No-'.$pi_no.'||SendDt:'.$pi->pi_date;
		auto_insert_store_transfer_issue($pi->pi_date,$ledger_cr,$sales_ledger,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no,$cc_code,$narration);
		}
		
}
}
	?>
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
.style2 {
	color: #006600;
	font-weight: bold;
}
-->
</style>
<? 
if($pi_no>0)
{

?>
		<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99FF66">
      <tr>
        <td><div align="center" class="style2">Price Set Successfull </div></td>
      </tr>
    </table>
<? }?>

<form action="" method="post">
<div class="oe_view_manager oe_view_manager_current">
        
    <? include('../../common/title_bar.php');?>
        <div class="oe_view_manager_body">
            
                <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
<div class="oe_form_sheetbg" style="min-height:10px;">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
           	 <table width="85%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td height="35" bgcolor="#33CCFF"><strong>Pi  No: </strong></td>
    <td bgcolor="#33CCFF"><input name="pi_no" type="text" id="pi_no" maxlength="16" value="<?=$pi_no?>" required /></td>
    <td align="center" valign="middle" bgcolor="#33CCCC"><input name="search" type="submit" id="search" value="Re-Cal Discount" /></td>
  </tr>
  
  <? if($new_ledger>0&&$old_ledger>0){?>
  
    <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  
  <? }?>
</table>

		
		  
          </div></div>
          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
            
        </div>
  </div>
</form>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>