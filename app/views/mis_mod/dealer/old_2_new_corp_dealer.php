<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Start Edit Section ::::: 
$title='Corporate Dealer Price Copy';			// Page Name and Page Title
$page="task_assign.php";			// PHP File Name
$root='mis';

$table='sales_corporate_price';					// Database Table Name Mainly related to this page
$unique='id';						// Primary Key of this Database table
$shown='chalan_date';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::
do_calander('#chalan_date');

$chalan_no = $_REQUEST['chalan_no'];
$crud      =new crud($table);

$$unique = $_GET[$unique];

	$old_ledger = $_REQUEST['old_ledger'];
	$new_ledger = $_REQUEST['new_ledger'];

if(isset($_REQUEST['change_ledger'])&&$_REQUEST['old_ledger']>0&&$_REQUEST['new_ledger']>0&&$_REQUEST['new']!=''&&$_REQUEST['new_ledger']!='')
{
	$old_ledger = $_REQUEST['old_ledger'];
	$new_ledger = $_REQUEST['new_ledger'];
	
	$csql = 'select 1 from sales_corporate_price where dealer_code = "'.$new_ledger.'" limit 1';
	$cquery = db_query($csql);
	$count = mysqli_num_rows($cquery);
	if($count==0){
	$sql = 'select * from sales_corporate_price where dealer_code="'.$old_ledger.'"';
	$query = db_query($sql);
	$entry_by = $edit_by = $_SESSION['user']['id'];
	$enrty_at = $edit_at = date('Y-m-d H:i:s');
	while($data = mysqli_fetch_object($query)){
	$sqlcc = "INSERT INTO `sales_corporate_price` (`dealer_code`, `item_id`, `discount`, `set_price`, `entry_by`, `entry_at`, `edit_by`, `edit_at`) VALUES ('".$new_ledger."', '".$data->item_id."', '".$data->discount."', '".$data->set_price."', '".$entry_by."', '".$enrty_at."', '".$entry_by."', '".$enrty_at."')";
	db_query($sqlcc);
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

		<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99FF66">
      <tr>
        <td><div align="center" class="style2">Price Set Successfull </div></td>
      </tr>
    </table>
	<?
	}
	
	}
	else{
		?>
		<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFCCFF">
      <tr>
        <td><div align="center" class="style1">Price Set is not Possible </div></td>
      </tr>
</table>
	<? }
	
}
?>

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
    <td height="35" bgcolor="#33CCFF"><strong>Old Dealer Code: </strong></td>
    <td bgcolor="#33CCFF"><strong>
      <label>
      <input name="old_ledger" type="text" id="old_ledger" maxlength="16" value="<?=$old_ledger?>" required / class="form-control">
        </label>
    </strong></td>
    <td rowspan="2" align="center" valign="middle" bgcolor="#33CCCC"><strong>
      <input name="search" type="submit" id="search" value="Search Dealer" / class="form-control">
      <label></label>
    </strong></td>
  </tr>
  <tr>
    <td height="35" bgcolor="#FFCCCC"><strong>New Dealer Code: </strong></td>
    <td bgcolor="#FFCCCC"><input name="new_ledger" type="text" id="new_ledger" maxlength="16" value="<?=$new_ledger?>" required / class="form-control"></td>
    </tr>
  <? if($new_ledger>0&&$old_ledger>0){?>
  
    <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td height="35" colspan="2" align="center" valign="middle" bgcolor="#33CCCC"><label>
      <input name="old" type="text" id="old" value="<?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$old_ledger);?>" / class="form-control">
      transfer to 
      <input name="new" type="text" id="new" value="<?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$new_ledger);?>" / class="form-control">
    </label></td>
    <td bgcolor="#CC99CC"><div align="center">
      <input name="change_ledger" type="submit" id="change_ledger" value="Set Price Now!" / class="form-control">
    </div></td>
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