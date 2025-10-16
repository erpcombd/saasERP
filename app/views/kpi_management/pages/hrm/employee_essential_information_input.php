<?php
session_start();

require "../../config/inc.all.php";

// ::::: Edit This Section ::::: 
$title='Employee Essential Information';			// Page Name and Page Title
$page="employee_essential_information.php";		// PHP File Name
$input_page="employee_essential_information_input.php";
$root='hrm';

$table='essential_info';		// Database Table Name Mainly related to this page
$unique='ESSENTIAL_ID';			// Primary Key of this Database table
$shown='ESSENTIAL_BANK_NAME';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert'])||isset($_POST['insertn']))
{		
$now				= time();

$_REQUEST['PBI_ID']=$_SESSION['employee_selected'];
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
while (list($key, $value)=each($data))
{ $$key=$value;}
}
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
?>
<html style="height: 100%;"><head>
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <meta content="text/html; charset=UTF-8" http-equiv="content-type">
        <link href="../../css/css.css" rel="stylesheet">
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.datepicker.js"></script>
</head>
<body>
        <!--[if lte IE 8]>
        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>
        <script>CFInstall.check({mode: "overlay"});</script>
        <![endif]-->
       <form action="" method="post" enctype="multipart/form-data"> <div class="ui-dialog ui-widget ui-widget-content ui-corner-all oe_act_window ui-draggable ui-resizable openerp" style="outline: 0px none; z-index: 1002; position: absolute; height: auto; width: 900px; display: block; /* [disabled]left: 217.5px; */" tabindex="-1" role="dialog" aria-labelledby="ui-id-19">
          <? include('../../common/title_bar_popup.php');?>
          <div style="display: block; max-height: 464px; overflow-y: auto; width: auto; min-height: 82px; height: auto;" class="ui-dialog-content ui-widget-content" scrolltop="0" scrollleft="0">

            <div style="width:100%" class="oe_popup_form">
              <div class="oe_formview oe_view oe_form_editable" style="opacity: 1;">
                <div class="oe_form_buttons"></div>
                <div class="oe_form_sidebar" style="display: none;"></div>
                <div class="oe_form_container">
                  <div class="oe_form">
                    <div class="">
                      <? include('../../common/input_bar.php');?>
                      <div class="oe_form_sheetbg">
                        <div class="oe_form_sheet oe_form_sheet_width">
        <h1><label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right">
        <a href="home2.php" rel = "gb_page_center[940, 600]"><?=$title?></a>
    </label>
          </h1><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row">
            <td class="oe_form_group_cell"><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" width="33%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Code :</td>
                  <td bgcolor="#E8E8E8" width="33%" colspan="1" class="oe_form_group_cell">
                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                    <input name="item_name" type="text" id="item_name" value="<?=$item_name?>" /></td>
                  <td bgcolor="#E8E8E8" width="34%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Name :</span></td>
                  <td bgcolor="#E8E8E8" width="67%" class="oe_form_group_cell"><input name="cost_price" type="text" id="cost_price" value="<?=$cost_price?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;Bank Name :</label></td>
                  <td class="oe_form_group_cell"><input name="ESSENTIAL_BANK_NAME" type="text" id="ESSENTIAL_BANK_NAME" value="<?=$ESSENTIAL_BANK_NAME?>" /></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Bank List :</span></td>
                  <td class="oe_form_group_cell"><input name="sale_price" type="text" id="sale_price" value="<?=$sale_price?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Branch :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="ESSENTIAL_BRANCH" type="text" id="ESSENTIAL_BRANCH" value="<?=$ESSENTIAL_BRANCH?>" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Blood Group:</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="ESSENTIAL_BLOOD_GROUP">
                    <option selected>
                      <?=$ESSENTIAL_BLOOD_GROUP?>
                      </option>
                    <option>A+</option>
                    <option>A-</option>
                    <option>B+</option>
                    <option>B-</option>
                    <option>O+</option>
                    <option>O-</option>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Address # :</td>
                  <td class="oe_form_group_cell"><input name="ESSENTIAL_BANK_ADDRESS" type="text" id="ESSENTIAL_BANK_ADDRESS" value="<?=$ESSENTIAL_BANK_ADDRESS?>" /></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Passport # :</span></td>
                  <td class="oe_form_group_cell"><span class="oe_form_field oe_datepicker_root oe_form_field_date">
                    <input name="ESSENTIAL_PASSPORT_NO" type="text" id="ESSENTIAL_PASSPORT_NO" value="<?=$ESSENTIAL_PASSPORT_NO?>" />
                  </span></td>
                </tr>
                <tr class="oe_form_group_row">
                        <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;National ID :</td>
                        <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="item_name4" type="text" id="item_name4" value="<?=$item_name?>" /></td>
                        <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Type of passport :</span></td>
                        <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="ESSENTIAL_TYPE_OF_PASSPORT">
                          <option selected>
                            <?=$ESSENTIAL_TYPE_OF_PASSPORT?>
                            </option>
                          <option>PASSPORT</option>
                          <option>PASSPORT</option>
                          <option>PASSPORT</option>
                        </select></td>
                </tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Issue Date :</td>
                        <td class="oe_form_group_cell"><input name="ESSENTIAL_ISSUE_DATE" type="text" id="ESSENTIAL_ISSUE_DATE" value="<?=$ESSENTIAL_ISSUE_DATE?>" /></td>
                        <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">TIN # :</span></td>
                        <td class="oe_form_group_cell"><input name="ESSENTIAL_TIN_NO" type="text" id="ESSENTIAL_TIN_NO" value="<?=$ESSENTIAL_TIN_NO?>" /></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Visited Country: </td>
                        <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="ESSENTIAL_VISITED_COUNTRY" type="text" id="ESSENTIAL_VISITED_COUNTRY" value="<?=$ESSENTIAL_VISITED_COUNTRY?>" /></td>
                        <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                        <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Driding Licence # :</td>
                        <td class="oe_form_group_cell"><input name="ESSENTIAL_DRIVING_LICENSE_NO" type="text" id="ESSENTIAL_DRIVING_LICENSE_NO" value="<?=$ESSENTIAL_DRIVING_LICENSE_NO?>" /></td>
                        <td class="oe_form_group_cell">&nbsp;</td>
                        <td class="oe_form_group_cell">&nbsp;</td>
                      </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Type of Licence : </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="ESSENTIAL_DRIVING_LICENSE_NO">
                   <option selected><?=$ESSENTIAL_DRIVING_LICENSE_NO?></option>
						<option>Licence</option>
						<option>Licence</option>

                 		</select></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                </tr>
                </tbody></table>
              </td>
            </tr></tbody></table>
                        </div>
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
