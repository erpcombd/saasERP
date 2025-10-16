<?php
session_start();

require "../../config/inc.all.php";

do_calander('#delivery_date');
$title='Item Receive';
$page="item_receive.php";		// PHP File Name
$input_page="item_receive_input.php";
if($_GET['cat_id']>0)
{		// Page Name and Page Title
$cat_id=$_GET['cat_id'];
$title=find_a_field('inv_item_category','category_name','id='.$cat_id).' Item Receive';
$page="item_receive.php?cat_id=".$cat_id;		// PHP File Name
$input_page="item_receive_input.php?cat_id=".$cat_id;
}

$root='inventory';

$table='inv_item_receive';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='item_id';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::

//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];
$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert'])||isset($_POST['insertn']))
{		
$now				= time();

$crud->insert();
$type=1;
$msg='New Entry Successfully Inserted.';

if(isset($_POST['insert']))
{
echo '<script type="text/javascript">
parent.parent.document.location.href = "../'.$root.'/'.$page.'";
</script>';
}
unset($_POST);
unset($$unique);


}


//for Modify..................................

if(isset($_POST['update']))
{

		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
				echo '<script type="text/javascript">
parent.parent.document.location.href = "../'.$root.'/'.$page.'";
</script>';
}
//for Delete..................................

if(isset($_POST['delete']))
{		$condition=$unique."=".$$unique;		$crud->delete($condition);
		unset($$unique);
		echo '<script type="text/javascript">
parent.parent.document.location.href = "../'.$root.'/'.$page.'";
</script>';
		$type=1;
		$msg='Successfully Deleted.';
}
}

if(isset($$unique))
{
$condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
foreach($data as $key => $value)
{ $$key=$value;}
}
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
?>
<html style="height: 100%;"><head>
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <meta content="text/html; charset=UTF-8" http-equiv="content-type">
        <link href="../css/css.css" rel="stylesheet"></head>
<body>
        <!--[if lte IE 8]>
        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>
        <script>CFInstall.check({mode: "overlay"});</script>
        <![endif]-->
       <form action="" method="post"> <div class="ui-dialog ui-widget ui-widget-content ui-corner-all oe_act_window ui-draggable ui-resizable openerp" style="outline: 0px none; z-index: 1002; position: absolute; height: auto; width: 900px; display: block; /* [disabled]left: 217.5px; */" tabindex="-1" role="dialog" aria-labelledby="ui-id-19">
          <? include('../common/title_bar_popup.php');?>
          <div style="display: block; max-height: 464px; overflow-y: auto; width: auto; min-height: 82px; height: auto;" class="ui-dialog-content ui-widget-content" scrolltop="0" scrollleft="0">

            <div style="width:100%" class="oe_popup_form">
              <div class="oe_formview oe_view oe_form_editable" style="opacity: 1;">
                <div class="oe_form_buttons"></div>
                <div class="oe_form_sidebar" style="display: none;"></div>
                <div class="oe_form_container">
                  <div class="oe_form">
                    <div class="">
                      <? include('../common/input_bar.php');?>
                      <div class="oe_form_sheetbg">
                        <div class="oe_form_sheet oe_form_sheet_width">
        <h1><label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right">
        <a href="home2.php" rel = "gb_page_center[940, 600]"><?=$title?></a>
    </label>
          </h1><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell" width="50%"><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody>
                <tr class="oe_form_group_row">
                  <td width="40%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">PO No:</td>
                  <td width="60%" colspan="1" class="oe_form_group_cell"><input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                    <input name="po_no" type="text" id="po_no" value="<?=$po_no?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Vendor Name:</td>
                  <td colspan="1" class="oe_form_group_cell"><select name="vendor_id" id="vendor_id">
      <? foreign_relation('inv_vendor','id','vendor_name',$vendor_id);?>
    </select>&nbsp;</td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Catton No:</td>
                  <td colspan="1" class="oe_form_group_cell"><input name="catton_no" type="text" id="catton_no" value="<?=$catton_no?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Colour:</td>
                  <td colspan="1" class="oe_form_group_cell"><input name="colour_no" type="text" id="colour_no" value="<?=$colour_no?>" /></td>
                </tr>
                </tbody></table></td><td colspan="1" class="oe_form_group_cell oe_group_right" width="50%"><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" width="1%"><label>Item Name:</label></td><td colspan="1" class="oe_form_group_cell" width="99%"><select name="item_id" id="item_id">
      <? 
	  if($cat_id>0)
	  foreign_relation('inv_item','id','item_name',$item_id,'category_id='.$cat_id);
	  else
	  foreign_relation('inv_item','id','item_name',$item_id);
	  ?>
    </select></td></tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Quantity:</td>
                        <td colspan="1" class="oe_form_group_cell"><input name="quantity" type="text" id="quantity" value="<?=$quantity?>" /></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Receive Date:</td>
                        <td colspan="1" class="oe_form_group_cell"><input name="delivery_date" type="text" id="delivery_date" value="<?=$delivery_date?>" /></td>
                      </tr>
                  </tbody></table></td></tr></tbody></table></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="ui-resizable-handle ui-resizable-n" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-e" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-s" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-w" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se ui-icon-grip-diagonal-se" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-sw" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-ne" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-nw" style="z-index: 1000;"></div>
          <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">

          </div>
        </div>
        </form>
</body></html>
