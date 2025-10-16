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

//$ssql = 'select dealer_code from dealer_info where dealer_type="SuperShop"';
//$qquery = db_query($ssql);
//while($ddata = mysqli_fetch_object($qquery)){
//$sql = "INSERT INTO sales_corporate_price 
//(dealer_code, item_id, `discount`, `set_price`, `entry_by`, `entry_at`, `edit_by`, `edit_at`) VALUES
//('".$ddata->dealer_code."', 1096000100010342, 0.00, 313.8000, 10149, '2015-05-26 17:18:36', 10149, '2015-05-26 17:42:38')";
//db_query($sql);
//}

// ::::: End Edit Section :::::
do_calander('#chalan_date');

$chalan_no = $_REQUEST['chalan_no'];
$crud      =new crud($table);

$$unique = $_GET[$unique];

$old_item = $_REQUEST['old_item'];

if(isset($_REQUEST['change_ledger'])&&$_REQUEST['old_item_id']>0)
{

	$item_id = $_REQUEST['old_item_id'];
	$mrp_price = find_a_field('item_info','m_price','item_id='.$item_id);

	$sql = "select * from sales_corporate_price where discount>0 and item_id = '".$item_id."'";
	$query = db_query($sql);
	while($data = mysqli_fetch_object($query))
	{
		$set_price = $mrp_price - ($mrp_price*$data->discount)/100;
		$sql1 = "update sales_corporate_price set set_price = '".$set_price."' where id='".$data->id."'";
		db_query($sql1);
	}

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
    <td height="35" bgcolor="#33CCFF"><strong>FG Item Code:</strong></td>
    <td bgcolor="#33CCFF">
	<strong>
		<label>
<input name="old_item" type="text" id="old_item" maxlength="16" value="<?=$old_item?>" required / class="form-control">
		</label>
    </strong>
	</td>
<td align="center" valign="middle" bgcolor="#33CCFF">
	<strong>
		<label>
			<div align="center">
			  <input name="search" type="submit" id="search" value="Find Item!" style="width:100px;" / class="form-control">
			      </div>
		</label>
	</strong>
</td>
  </tr>
  
  <? if($old_item>0){?>
  
    <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
    <tr>
      <td height="35" align="center" valign="middle" bgcolor="#33CCCC">Item Name: </td>
      <td height="35" align="center" valign="middle" bgcolor="#33CCCC">
	  <div align="left">
		<input name="old_item_name" type="text" id="old_item_name" value="<?=find_a_field('item_info','item_name','finish_goods_code='.$old_item);?>" / class="form-control">
      </div>
	  </td>
      <td rowspan="2" bgcolor="#33CCCC">
		<div align="center">
		  <input name="change_ledger" type="submit" id="change_ledger" value="Re-Calculate % SuperShop Rate" / class="form-control">
		  </div></td>
    </tr>
    <tr>
    <td height="35" align="center" valign="middle" bgcolor="#33CCCC"><label>Item Code:</label></td>
    <td height="35" align="center" valign="middle" bgcolor="#33CCCC">
		<div align="left">
			<input name="old_item_id" type="text" id="old_item_id" value="<?=find_a_field('item_info','item_id','finish_goods_code='.$old_item);?>" / class="form-control">
		</div>
	</td>
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