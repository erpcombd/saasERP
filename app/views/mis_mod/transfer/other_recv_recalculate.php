<?php
session_start();
ob_start();

require "../../../warehouse_mod/support/inc.all.php";
// ::::: Start Edit Section ::::: 
$title='Other receive Re-hit';			// Page Name and Page Title



$or_no = $_REQUEST['or_no'];


if($or_no>0)
{
$found = find_a_field('journal','tr_no','1 and tr_no = "'.$or_no.'" and tr_from = "Other Receive" ');


if($found<1){


$sql= 'DELETE FROM `journal_item` WHERE sr_no='.$or_no.' and tr_from = "Other Receive"';
	db_query($sql);
	
	$sql2= 'DELETE FROM `secondary_journal` WHERE tr_no='.$or_no.' and tr_from = "Other Receive"';
	db_query($sql2);

	
$jv=next_journal_sec_voucher_id();

  $sql4 ='SELECT rr.warehouse_id,rr.or_no,r.id,r.item_id ,i.item_name,i.brand_category,i.sub_group_id,s.sub_group_name,r.qty,r.amount,r.purpose,rr.or_date FROM warehouse_other_receive_detail r,warehouse_other_receive rr,item_info i,item_sub_group s  WHERE r.or_no="'.$or_no.'" and  rr.or_no=r.or_no and i.item_id=r.item_id and i.sub_group_id=s.sub_group_id ';

$result = db_query($sql4);

while($roww=mysqli_fetch_object($result)){




journal_item_control($roww->item_id,$roww->warehouse_id,$roww->or_date,$roww->qty,0,'Other Receive',$roww->id,$roww->rate,0,$roww->or_no);


$final_amt =  $roww->amount;

$or_date = strtotime($roww->or_date);






 $test="INSERT INTO `secondary_journal` (`id`, `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, `sub_ledger`, `cc_code`, `user_id`, `tr_id`, `group_for`, `entry_at`) VALUES ( NULL, 'Alinfoods', '".$jv."', '".$or_date."', '".$roww->purpose."', 'Or NO#".$or_no."(sub_group#".$roww->sub_group_name.") item id-".$roww->item_id."', '".$final_amt."', '0.00', 'Other Receive', '".$or_no."', '', '0', '".$_SESSION['user']['id']."', '', '2', '".date('Y-m-d H:i:s')."')";

db_query($test);


if($roww->sub_group_id != 500100000){

		
		$inventory_ledger = find_a_field('item_sub_group','ledger_id','sub_group_id='.$roww->sub_group_id);

}
else {
		$inventory_ledger = find_a_field('brand_category_info','ledger_id_local','brand_category="'.$roww->brand_category.'"');
}


db_query("INSERT INTO `secondary_journal` (`id`, `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, `sub_ledger`, `cc_code`, `user_id`, `tr_id`, `group_for`, `entry_at`) VALUES ( NULL, 'Alinfoods', '".$jv."', '".$or_date."', '".$inventory_ledger."', 'Or NO#".$or_no."(sub_group#".$roww->sub_group_name.") item id-".$roww->item_id."', '0.00','".$final_amt."',  'Other Receive', '".$or_no."', '', '0', '".$_SESSION['user']['id']."', '', '2', '".date('Y-m-d H:i:s')."')");

$final_amt =0;	


$type=1;




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
if($found>0){
?>
		<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FF0000">
      <tr>
        <td><div align="center" class="style2">Sorry Journal Exists! </div></td>
      </tr>
    </table>
<? 
}
elseif($or_no>0)
{

?>
		<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99FF66">
      <tr>
        <td><div align="center" class="style2">Other Receive Re-hit Successfull </div></td>
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
    <td height="35" bgcolor="#33CCFF"><strong>OR No: </strong></td>
    <td bgcolor="#33CCFF"><input name="or_no" type="text" id="or_no" maxlength="16" value="<?=$or_no?>" required /></td>
    <td align="center" valign="middle" bgcolor="#33CCCC"><input name="search" type="submit" id="search" value="Re-Cal Discount" /></td>
  </tr>
  

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