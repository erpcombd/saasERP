<?php
session_start();
ob_start();

require "../../../warehouse_mod/support/inc.all.php";
// ::::: Start Edit Section ::::: 
$title='Store to Store Transfer Issue Re-Hit(Only Inter SG)';			// Page Name and Page Title
$table_detail='production_issue_detail';

 /*
// Start For all re-hit
$pi_no =$req_no = $_REQUEST['pi_no'];
$unique_master='pi_no';

$sql = "SELECT *
FROM `production_issue_master`
WHERE `pi_date` > '2015-12-31' and  `status` = 'RECEIVED'
AND `warehouse_to`
IN ( 3, 6, 9, 7, 10, 8, 11, 54, 53, 5, 17 )";
$query = db_query($sql);
while($data  =  mysqli_fetch_object($query)){
$master = $pi = find_all_field('production_issue_master','','pi_no='.$data->pi_no);
$warehouse_to = $master->warehouse_to;
$warehouse_from = $master->warehouse_from;
$pi_no = $data->pi_no;
//End For All re-hit
 */

// /*
// Start For Single Re-hit
$pi_no =$req_no = $_REQUEST['pi_no'];
$unique_master='pi_no';
if($pi_no>0)
{
$master = $pi = find_all_field('production_issue_master','','pi_no='.$req_no);
$warehouse_to = $master->warehouse_to;
$warehouse_from = $master->warehouse_from;
// End Single Re-hit
//*/

		
		if($warehouse_from==5)
		{
$sales_ledger = '1070000100020000';
$cc_code = find_a_field_sql('select c.id from cost_center c, warehouse w where c.cc_code=w.acc_code and w.warehouse_id='.$pi->warehouse_to);
$ledger = find_a_field('warehouse','ledger_id','warehouse_id='.$pi->warehouse_to);	
$narration = 'PI No-'.$pi_no.'||RSL-'.$pi->rec_sl_no.'||RecDt:'.$pi->receive_date;
auto_insert_sale_sc_in($pi->pi_date,$ledger,$sales_ledger,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$pi_no),$pi_no,$cc_code,$narration);
		}
		elseif($warehouse_from==17)
		{
if($pi->warehouse_to==5){
$sales_ledger = '2043000101960000';
$ledger_dr ='1079000400030001';}
else{
$sales_ledger = '1070001500020000';
$cc_code = find_a_field_sql('select c.id from cost_center c, warehouse w where c.cc_code=w.acc_code and w.warehouse_id='.$pi->warehouse_to);
//$ledger = find_a_field('config_group_class','purchase_ledger','group_for=2');	
$ledger_dr = find_a_field('warehouse','ledger_id','warehouse_id='.$pi->warehouse_to);	}
$narration = 'PI No-'.$pi_no.'||RSL-'.$pi->rec_sl_no.'||RecDt:'.$pi->receive_date;
auto_insert_sale_sc_in($pi->pi_date,$ledger_dr,$sales_ledger,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$pi_no),$pi_no,$cc_code,$narration);
		}
		elseif($warehouse_from==68)
		{
if($pi->warehouse_to==5){
$sales_ledger = '2043000103410000';
$ledger_dr = '1079000400030001';}
if($pi->warehouse_to==17){
$sales_ledger = '1126000300010000';
$ledger_dr = '1127000100030001';}
else{
$sales_ledger = '1070004000100000';
$ledger_dr = find_a_field('warehouse','ledger_id','warehouse_id='.$pi->warehouse_to);	
$cc_code = find_a_field_sql('select c.id from cost_center c, warehouse w where c.cc_code=w.acc_code and w.warehouse_id='.$pi->warehouse_to);}
//$ledger = find_a_field('config_group_class','purchase_ledger','group_for=2');	

$narration = 'PI No-'.$pi_no.'||RSL-'.$pi->rec_sl_no.'||RecDt:'.$pi->receive_date;
auto_insert_sale_sc_in($pi->pi_date,$ledger_dr,$sales_ledger,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$pi_no),$pi_no,$cc_code,$narration);
		}
		else
		{
$sales_ledger = '1078000200010000';
$cc_code = find_a_field_sql('select c.id from cost_center c, warehouse w where c.cc_code=w.acc_code and w.warehouse_id='.$pi->warehouse_to);
$ledger = find_a_field('warehouse','ledger_id','warehouse_id='.$pi->warehouse_to);	
$narration = 'PI No-'.$pi_no.'||RSL-'.$pi->rec_sl_no.'||RecDt:'.$pi->receive_date;
auto_insert_store_transfer_receive($pi->receive_date,$ledger,$sales_ledger,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no,$cc_code,$narration);
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