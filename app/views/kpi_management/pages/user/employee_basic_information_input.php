<?php
session_start();

require "../../config/inc.all.php";

// ::::: Edit This Section ::::: 
$title='Employee Basic Info';		// Page Name and Page Title
$page="employee_basic_information.php";		// PHP File Name
$input_page="employee_basic_information_input.php";
$root='hrm';

$table='personnel_basic_info';		// Database Table Name Mainly related to this page
$unique='PBI_ID';			// Primary Key of this Database table
$shown='PBI_FATHER_NAME';	

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
            <td colspan="1" class="oe_form_group_cell" width="50%"><table width="303" border="0" cellpadding="0" cellspacing="0" class="oe_form_group "><tbody>
                <tr class="oe_form_group_row">
                  <td width="46%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">ID :</td>
                  <td width="54%" colspan="1" class="oe_form_group_cell"><input name="<?=$PBI_ID?>" id="<?=$PBI_ID?>" value="<?=$PBI_ID?>" type="hidden" />
                    <input name="PBI_ID" type="text" id="PBI_ID" value="<?=$PBI_ID?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>Name :</label></td>
                  <td colspan="1" class="oe_form_group_cell"><input name="PBI_NAME" type="text" id="PBI_NAME" value="<?=$PBI_NAME?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Father's Name : </td>
                  <td colspan="1" class="oe_form_group_cell"><input name="PBI_FATHER_NAME" type="text" id="PBI_FATHER_NAME" value="<?=$PBI_FATHER_NAME?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Mother's Name :</td>
                  <td colspan="1" class="oe_form_group_cell"><input name="PBI_MOTHER_NAME" type="text" id="PBI_MOTHER_NAME" value="<?=$PBI_MOTHER_NAME?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Designation :</td>
                  <td colspan="1" class="oe_form_group_cell"><select name="category_id">
                    <? foreign_relation('inv_item_category','id','category_name',$PBI_DESIGNATION);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Branch : </td>
                  <td colspan="1" class="oe_form_group_cell"><select name="category_id6">
                    <? foreign_relation('inv_item_category','id','category_name',$PBI_BRANCH);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Appointment Letter :</td>
                  <td colspan="1" class="oe_form_group_cell"><input name="PBI_APPOINTMENT_LETTER_NO" type="text" id="PBI_APPOINTMENT_LETTER_NO" value="<?=$PBI_APPOINTMENT_LETTER_NO?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Initial Joining Date :</td>
                  <td colspan="1" class="oe_form_group_cell"><input name="item_name6" type="text" id="item_name6" value="<?=$item_name?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Confirmation Date :</td>
                  <td colspan="1" class="oe_form_group_cell"><input name="quantity" type="text" id="quantity" value="<?=$quantity?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Joining Date (PP):</td>
                  <td colspan="1" class="oe_form_group_cell"><select name="category_id14">
                    <? foreign_relation('inv_item_category','id','category_name',$category_id);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Gender :</td>
                  <td colspan="1" class="oe_form_group_cell"><select name="category_id7">
                    <? foreign_relation('inv_item_category','id','category_name',$category_id);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Religion : </td>
                  <td colspan="1" class="oe_form_group_cell"><select name="category_id8">
                    <? foreign_relation('inv_item_category','id','category_name',$category_id);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Permanent Add :</td>
                  <td colspan="1" class="oe_form_group_cell"><input name="item_name7" type="text" id="item_name7" value="<?=$item_name?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Present Add :</td>
                  <td colspan="1" class="oe_form_group_cell"><input name="item_name8" type="text" id="item_name8" value="<?=$item_name?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Mobile :</td>
                  <td colspan="1" class="oe_form_group_cell"><input name="item_name9" type="text" id="item_name9" value="<?=$item_name?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Phone :</td>
                  <td colspan="1" class="oe_form_group_cell"><input name="item_name10" type="text" id="item_name10" value="<?=$item_name?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">E_Mail :</td>
                  <td colspan="1" class="oe_form_group_cell"><input name="item_name11" type="text" id="item_name11" value="<?=$item_name?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Initial Job Tpe :</td>
                  <td colspan="1" class="oe_form_group_cell"><select name="category_id9">
                    <? foreign_relation('inv_item_category','id','category_name',$category_id);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td colspan="1" class="oe_form_group_cell">&nbsp;</td>
                </tr>
                </tbody></table></td><td colspan="1" class="oe_form_group_cell oe_group_right" width="50%"><table width="273" border="0" cellpadding="0" cellspacing="0" class="oe_form_group "><tbody><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" width="47%"><label>Domain :</label></td><td colspan="1" class="oe_form_group_cell" width="53%"><input name="cost_price" type="text" id="cost_price" value="<?=$cost_price?>" /></td></tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Department :</td>
                        <td colspan="1" class="oe_form_group_cell"><select name="category_id2">
                          <? foreign_relation('inv_item_category','id','category_name',$category_id);?>
                        </select></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Project :</td>
                        <td colspan="1" class="oe_form_group_cell"><select name="category_id3">
                          <? foreign_relation('inv_item_category','id','category_name',$category_id);?>
                        </select></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Zone : </td>
                        <td colspan="1" class="oe_form_group_cell"><select name="category_id4">
                          <? foreign_relation('inv_item_category','id','category_name',$category_id);?>
                        </select></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Area : </td>
                        <td colspan="1" class="oe_form_group_cell"><select name="category_id5">
                          <? foreign_relation('inv_item_category','id','category_name',$category_id);?>
                        </select></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Totel Service Length</td>
                        <td colspan="1" class="oe_form_group_cell"><input name="cost_price2" type="text" id="cost_price2" value="<?=$cost_price?>" /></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Service Length (PP):</td>
                        <td colspan="1" class="oe_form_group_cell"><input name="item_name12" type="text" id="item_name12" value="<?=$item_name?>" /></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Date of Birth :</td>
                        <td colspan="1" class="oe_form_group_cell"><select name="category_id13">
                          <? foreign_relation('inv_item_category','id','category_name',$category_id);?>
                        </select></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Place of Birth (Dstrict):</td>
                        <td colspan="1" class="oe_form_group_cell"><select name="category_id10">
                          <? foreign_relation('inv_item_category','id','category_name',$category_id);?>
                        </select></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Edu Qualification :</td>
                        <td colspan="1" class="oe_form_group_cell"><select name="category_id14">
                            <? foreign_relation('inv_item_category','id','category_name',$category_id);?>
                        </select></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Marital Status :</td>
                        <td colspan="1" class="oe_form_group_cell"><select name="category_id14">
                            <? foreign_relation('inv_item_category','id','category_name',$category_id);?>
                        </select></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Nationality : </td>
                        <td colspan="1" class="oe_form_group_cell"><select name="category_id14">
                            <? foreign_relation('inv_item_category','id','category_name',$category_id);?>
                        </select></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>Area of expertise :</label></td>
                        <td colspan="1" class="oe_form_group_cell"><span class="oe_form_field oe_datepicker_root oe_form_field_date"><span>
                          <input value="" id="dp2" class="oe_datepicker_container hasDatepicker" disabled="disabled" style="display: none;" type="text">
                          <input name="description2" type="text" id="description2" value="<?=$description?>" />
                        </span></span></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Job Status</td>
                        <td colspan="1" class="oe_form_group_cell"><input name="item_name14" type="text" id="item_name14" value="<?=$item_name?>" /></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                        <td colspan="1" class="oe_form_group_cell">&nbsp;</td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                        <td colspan="1" class="oe_form_group_cell">&nbsp;</td>
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
