<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Start Edit Section ::::: 
$title='Depot Chalan Date Change';			// Page Name and Page Title
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
	

if(isset($_REQUEST['change_ledger'])&&$_REQUEST['old_ledger']>0&&$_REQUEST['new_ledger']>0)
{
	$old_ledger = $_REQUEST['old_ledger'];
	$new_ledger = $_REQUEST['new_ledger'];
	$difference = (int)($new_ledger - $old_ledger);
//echo $sql = 'select ledger_id from accounts_ledger where ledger_id like "'.$old_ledger.'%" and ledger_id != "'.$old_ledger.'0000"';
//$query = db_query($sql);
//while($info=mysqli_fetch_object($query)){
$ol = number_format(($old_ledger*10000),'0','.','');
//$nl = number_format(($old_ledger +$diff)*(10000)),'0','.','');
//$difference = ($diff)*(10000);
	echo $sql1 = "update receipt set ledger_id = ledger_id + '".$difference."' where ledger_id like '".$old_ledger."%' ;<br>";
	echo $sql2 = "update payment set ledger_id = ledger_id + '".$difference."' where ledger_id like '".$old_ledger."%' ;<br>";
	echo $sql3 = "update coutra set ledger_id = ledger_id + '".$difference."' where ledger_id like '".$old_ledger."%' ;<br>";
	echo $sql4 = "update journal_info set ledger_id = ledger_id + '".$difference."' where ledger_id like '".$old_ledger."%' ;<br>";
	
	echo $sql5 = 'update accounts_ledger set ledger_id = ledger_id + "'.$difference.'" where  ledger_id != "'.$ol.'" and ledger_id like "'.$old_ledger.'%" ;<br>';
	echo $sql6 = 'update sub_ledger set ledger_id = ledger_id + "'.$difference.'" where ledger_id != "'.$ol.'" and  ledger_id like "'.$old_ledger.'%" ;<br>';
	echo $sql11 = 'update sub_ledger set sub_ledger_id = sub_ledger_id + "'.$difference.'" where sub_ledger_id != "'.$ol.'" and  sub_ledger_id like "'.$old_ledger.'%" ;<br>';
	echo $sql12 = 'update sub_sub_ledger set sub_ledger_id = sub_ledger_id + "'.$difference.'" where sub_ledger_id like "'.$old_ledger.'%" ;<br>';
	echo $sql7 = 'update sub_sub_ledger set sub_sub_ledger_id = sub_sub_ledger_id + "'.$difference.'" where sub_sub_ledger_id like "'.$old_ledger.'%" ;<br>';
	
	echo $sql8 = "update journal set ledger_id = ledger_id + '".$difference."' where ledger_id like '".$old_ledger."%' ;<br>";
	echo $sql9 = "update secondary_journal set ledger_id = ledger_id + '".$difference."' where ledger_id like '".$old_ledger."%' ;<br>";
	echo $sql9 = "update dealer_info set account_code = account_code + '".$difference."' where account_code like '".$old_ledger."%' ;<br>";
	//db_query($sql11);db_query($sql12);db_query($sql1);db_query($sql2);db_query($sql3);db_query($sql4);
	//db_query($sql5);db_query($sql6);db_query($sql7);db_query($sql8);db_query($sql9);
echo $sql11 = 'delete from accounts_ledger where ledger_id like "'.$old_ledger.'%" ;<br>';
echo $sql12 = 'delete from sub_ledger where sub_ledger_id like "'.$old_ledger.'%" ;<br>';
echo $sql13 = 'delete from sub_sub_ledger where sub_sub_ledger_id like "'.$old_ledger.'%" ;<br>';
	//db_query($sql5);db_query($sql6);db_query($sql7);
//	}
}
?>
<form action="" method="post">
<div class="oe_view_manager oe_view_manager_current">
        
    <?php include('../../common/title_bar.php');?>
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
      <input name="old" type="text" id="old" value="<?=find_a_field('accounts_ledger','ledger_name','ledger_id='.number_format(($old_ledger*10000),'0','.',''));?>" / class="form-control">
      transfer to 
      <input name="new" type="text" id="new" value="<?=find_a_field('accounts_ledger','ledger_name','ledger_id='.number_format(($new_ledger*10000),'0','.',''));?>" / class="form-control">
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