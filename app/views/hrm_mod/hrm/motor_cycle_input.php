<?php
session_start();

require "../../config/inc.all.php";

// ::::: Edit This Section ::::: 
$title='Cycle/Motor Cycle input form';			// Page Name and Page Title
$page="motor_cycle.php";		// PHP File Name
$input_page="motor_cycle_input.php";
$root='hrm';

$table='motor_cycle_detail';		// Database Table Name Mainly related to this page
$unique='MOTOR_CYCLE_D_CODE';			// Primary Key of this Database table
$shown='MC_RECEIVED_DATE';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert'])||isset($_POST['insertn']))
{		
$now				= time();

$_POST['PBI_ID']=$_SESSION['employee_selected'];
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
        <link href="../../../../public/assets/css/css.css" rel="stylesheet">
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.datepicker.js"></script>
<? do_calander('#MC_RECEIVED_DATE');?>
</head>
<body>
        <!--[if lte IE 8]>
        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>
        <script>CFInstall.check({mode: "overlay"});</script>
        <![endif]-->
       <form action="" method="post" enctype="multipart/form-data"> <div class="ui-dialog ui-widget ui-widget-content ui-corner-all oe_act_window ui-draggable ui-resizable openerp" style="outline: 0px none; z-index: 1002; position: absolute; height: auto; width: 900px; display: block; /* [disabled]left: 217.5px; */" tabindex="-1" role="dialog" aria-labelledby="ui-id-19">
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
          </h1><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row">
            <td class="oe_form_group_cell"><table width="100%" class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" width="15%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Date:</td>
                  <td bgcolor="#E8E8E8" width="29%" class="oe_form_group_cell">
                 <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                    <input name="MC_RECEIVED_DATE" type="text" id="MC_RECEIVED_DATE" value="<?=$MC_RECEIVED_DATE?>" /></td>
                  <td bgcolor="#E8E8E8" width="15%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Company:</span></td>
                  <td bgcolor="#E8E8E8" width="41%" class="oe_form_group_cell"><input name="MC_COMPANY" type="text" id="MC_COMPANY" value="<?=$MC_COMPANY?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;Model:</label></td>
                  <td class="oe_form_group_cell"><input name="MC_MODEL" type="text" id="MC_MODEL" value="<?=$MC_MODEL?>" /></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">CC:</span></td>
                  <td class="oe_form_group_cell"><input name="MC_CC" type="text" id="MC_CC" value="<?=$MC_CC?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Engine No: </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="MC_ENGINE_NO" type="text" id="MC_ENGINE_NO" value="<?=$MC_ENGINE_NO?>" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Registration No: </span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="MC_REGISTRATION_NO" type="text" id="MC_REGISTRATION_NO" value="<?=$MC_REGISTRATION_NO?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Total Price :</td>
                  <td class="oe_form_group_cell"><input name="MC_TOTAL_PRICE" type="text" id="MC_TOTAL_PRICE" value="<?=$MC_TOTAL_PRICE?>" /></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Chassis No :</span></td>
                  <td class="oe_form_group_cell"><span class="oe_form_field oe_datepicker_root oe_form_field_date">
                    <input name="MC_CHASSIS_NO" type="text" id="MC_CHASSIS_NO" value="<?=$MC_CHASSIS_NO?>" />
                  </span></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Handover</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="CD_PASSING">
                    <select name="CD_PASSING">
                      <option selected>
                        <?=$CD_PASSING?>
                        </option>
                      <option>Yes</option>
                      <option>No</option>
                    </select>
                  </span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Received Status: </span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="MC_RECEIVED_STATUS">
                    <select name="MC_RECEIVED_STATUS" id="select">
                      <option selected>
                        <?=$MC_RECEIVED_STATUS?>
                        </option>
                      <option>Self</option>
                      <option>Organizational</option>
                    </select>
                  </span></td>
                </tr>
                
                </tbody></table>
              <br></td>
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
