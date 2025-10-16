<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


// ::::: Start Edit Section ::::: 

$title='Duplicate Item Tranfer and Remove';			// Page Name and Page Title

$page="old_2_new_item.php";			// PHP File Name




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

	
	
	$sql="SELECT DISTINCT TABLE_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME='item_id' AND TABLE_SCHEMA='".$_SESSION['db_name']."'" ;
	
	$query = db_query($sql);
	
	while($data=mysqli_fetch_object($query)){
	
		if($data->TABLE_NAME!='item_info'){
		$update_sql = "update ".$data->TABLE_NAME." set item_id = ".$new_ledger." where item_id=".$old_ledger."";
		db_query($update_sql);
		}
	}
	
	
	
	$insert_sql = "INSERT INTO item_info_del select * from item_info where item_id=".$old_ledger."";
	db_query($insert_sql);
	
	
	


	$sql5 = 'delete from item_info where item_id = "'.$old_ledger.'"';

	db_query($sql5);

echo "Data Transfer successfully done.";
}

?><title>AFPL MIS</title>

<form action="" method="post">

<div class="oe_view_manager oe_view_manager_current">

        


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

           	 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">

  <tr>

    <td height="35" bgcolor="#33CCFF"><strong>Duplicate Item ID : </strong></td>

    <td bgcolor="#33CCFF"><strong>

      <label>

      <input name="old_ledger" type="text" id="old_ledger" maxlength="16" value="<?=$old_ledger?>" required <? if($new_ledger>0&&$old_ledger>0) echo 'readonly';?> />

        </label>

    </strong></td>

    <td rowspan="2" align="center" valign="middle" bgcolor="#33CCCC"><strong>

      <label>

      <input name="search" type="submit" id="search" value="Search Item"   class="btn1 btn1-submit-input">

        </label>

    </strong></td>

  </tr>

  <tr>

    <td height="35" bgcolor="#FFCCCC"><strong>Real Item ID : </strong></td>

    <td bgcolor="#FFCCCC"><input name="new_ledger" type="text" id="new_ledger" maxlength="16" value="<?=$new_ledger?>" required <? if($new_ledger>0&&$old_ledger>0) echo 'readonly';?> /></td>

    </tr>

  <? if($new_ledger>0&&$old_ledger>0){?>

  

    <tr>

    <td bgcolor="#FFFFFF">&nbsp;</td>

    <td bgcolor="#FFFFFF">&nbsp;</td>

    <td bgcolor="#FFFFFF">&nbsp;</td>

  </tr>

  <tr>

    <td height="35" colspan="2" align="center" valign="middle" bgcolor="#33CCCC"><label>

      <input name="old" type="text" id="old" value="<?=find_a_field('item_info','item_name','item_id='.$old_ledger);?>" style="width:320px; font-size:11px;"  class="form-control"/>

      transfer to 

      <input name="new" type="text" id="new" value="<?=find_a_field('item_info','item_name','item_id='.$new_ledger);?>" style="width:320px;font-size:11px;"  class="form-control"/>

    </label></td>

    <td bgcolor="#CC99CC"><div align="center">

      <input name="change_ledger" type="submit" id="change_ledger" value="Transfer & Delete"   class="btn1 btn1-bg-update"/>

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