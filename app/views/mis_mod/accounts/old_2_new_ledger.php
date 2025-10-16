<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Start Edit Section ::::: 
$title='Ledger To Ledger Transfer';			// Page Name and Page Title
$page="task_assign.php";			// PHP File Name
$root='mis';

$table='sale_do_chalan';					// Database Table Name Mainly related to this page
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

	 $sql1 = "update receipt set ledger_id = '".$new_ledger."' where ledger_id='".$old_ledger."'";
	 $sql2 = "update payment set ledger_id = '".$new_ledger."' where ledger_id='".$old_ledger."'";
	 $sql3 = "update contra set ledger_id = '".$new_ledger."' where ledger_id='".$old_ledger."'";
	 $sql4 = "update journal_info set ledger_id = '".$new_ledger."' where ledger_id='".$old_ledger."'";
	
	 $sql8 = "update journal set ledger_id = '".$new_ledger."' where ledger_id='".$old_ledger."'";
	 $sql9 = "update secondary_journal set ledger_id = '".$new_ledger."' where ledger_id='".$old_ledger."'";
	
	db_query($sql1);db_query($sql2);db_query($sql3);db_query($sql4);db_query($sql8);db_query($sql9);
	 $sql5 = 'delete from accounts_ledger where ledger_id = "'.$old_ledger.'"';
	 $sql6 = 'delete from sub_ledger where sub_ledger_id = "'.$old_ledger.'"';
	 $sql7 = 'delete from sub_sub_ledger where sub_sub_ledger_id = "'.$old_ledger.'"';
	db_query($sql5);db_query($sql6);db_query($sql7);db_query($sql8);
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
    <td height="35" bgcolor="#33CCFF"><strong>Old Ledger ID: </strong></td>
    <td bgcolor="#33CCFF"><strong>
      <label>
      <input name="old_ledger" type="text" id="old_ledger" maxlength="16" value="<?=$old_ledger?>" required / class="form-control">
        </label>
    </strong></td>
    <td rowspan="2" align="center" valign="middle" bgcolor="#33CCCC"><strong>
      <label>
      <input name="search" type="submit" id="search" value="Search Ledgers" / class="form-control">
        </label>
    </strong></td>
  </tr>
  <tr>
    <td height="35" bgcolor="#FFCCCC"><strong>New Ledger ID: </strong></td>
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
      <input name="old" type="text" id="old" value="<?=find_a_field('accounts_ledger','ledger_name','ledger_id='.$old_ledger);?>" / class="form-control">
      transfer to 
      <input name="new" type="text" id="new" value="<?=find_a_field('accounts_ledger','ledger_name','ledger_id='.$new_ledger);?>" / class="form-control">
    </label></td>
    <td bgcolor="#CC99CC"><div align="center">
      <input name="change_ledger" type="submit" id="change_ledger" value="Transfer Now!" / class="form-control">
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