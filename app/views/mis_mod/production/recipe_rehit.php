<?php
session_start();
ob_start();

require "../../../warehouse_mod/support/inc.all.php";
// ::::: Start Edit Section ::::: 
$title='Store to Store Transfer Issue Re-Hit(Only Inter SG)';			// Page Name and Page Title
do_calander('#fdate');





if($_POST['line_id']>0)
{
$line_id = $_POST['line_id'];
$fdate = $_POST['fdate'];
	$sql = 'select pr_no from production_floor_receive_master where pr_date<="'.$fdate.'" and warehouse_to = "'.$line_id.'"';
	$query = db_query($sql);
	while($data=mysqli_fetch_object($query))
	{auto_insert_recipe_pr_id($data->pr_no);}
}
	?>
<style type="text/css">
<!--
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
    <td height="35" bgcolor="#33CCFF"><div align="right"><strong>Date From:</strong></div></td>
    <td bgcolor="#33CCFF"><strong>
      <input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>" required />
    </strong></td>
    </tr>
  <tr>
    <td height="35" bgcolor="#6699FF"><div align="right"><strong>Production Line:</strong></div></td>
    <td bgcolor="#6699FF"><strong>
      <select name="line_id" id="line_id" style="width:200px;" required> 
      <option></option>     
<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['line_id'],'use_type="PL" order by warehouse_name',$_POST['line_id']);?>
      </select>
    </strong></td>
    </tr>
  <tr>
    <td height="35" colspan="2" bgcolor="#FF3366"><div align="center">
      <input name="search" type="submit" id="search" value="Re-Hit Recipe" />
    </div></td>
    </tr>
  
  <? if($new_ledger>0&&$old_ledger>0){?>
  
    <tr>
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