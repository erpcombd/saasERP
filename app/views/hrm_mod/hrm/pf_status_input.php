<?php
session_start();

//require "../../config/inc.all.php";

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Personal File Check Status';			// Page Name and Page Title
$page="pf_status.php";		// PHP File Name
$input_page="pf_status_input.php";
$root='hrm';

$table='pf_status';		// Database Table Name Mainly related to this page
$unique='PF_STATUS_ID';			// Primary Key of this Database table
$shown='PF_STATUS_CV';				// For a New or Edit Data a must have data field

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
            <td colspan="1" class="oe_form_group_cell" width="100%"><table width="105%" height="171" border="0" cellpadding="0" cellspacing="0" class="oe_form_group "><tbody>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" width="21%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;CV :</td>
                  <td bgcolor="#E8E8E8" width="27%" colspan="1" class="oe_form_group_cell">
                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                  <select name="PF_STATUS_APPOINTMENT_LETTER2" id="	PF_STATUS_APPOINTMENT_LETTER">
                    <option selected><?=$PF_STATUS_APPOINTMENT_LETTER?></option>
                    <option>Yes</option>
                    <option>No</option>
                  </select></td>
                  <td bgcolor="#E8E8E8" width="23%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"> Medical Certificate :</span></td>
                  <td bgcolor="#E8E8E8" width="29%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">
                    <select name="EPF_STATUS_MC" id="EPF_STATUS_MC">
                      <option selected>
                        <?=$EPF_STATUS_MC?>
                        </option>
                      <option>Yes</option>
                      <option>No</option>
                    </select>
                  </span></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Appointment Letter :</td>
                  <td class="oe_form_group_cell"><select name="PF_STATUS_APPOINTMENT_LETTER" id="PF_STATUS_APPOINTMENT_LETTER">
                    <option selected><?=$PF_STATUS_APPOINTMENT_LETTER?></option>
                    <option>Yes</option>
                    <option>No</option>
                  </select></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Security Money Receipt :</span></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">
                    <select name="PF_STATUS_SM_RECITE" id="PF_STATUS_SM_RECITE">
                      <option selected>
                        <?=$PF_STATUS_SM_RECITE?>
                        </option>
                      <option>Yes</option>
                      <option>No</option>
                    </select>
                  </span></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Joining Letter:</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="PF_STATUS_JOINING_LETTER" id="PF_STATUS_JOINING_LETTER">
                    <option selected><?=$PF_STATUS_JOINING_LETTER?></option>
                         <option>Yes</option>
                         <option>No</option>
                  </select></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"> Received Aya Allowance :</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">
                    <select name="PF_STATUS_R_AYA_A" id="PF_STATUS_R_AYA_A">
                      <option selected>
                        <?=$PF_STATUS_R_AYA_A?>
                        </option>
                          <option>Yes</option>
                          <option>No</option>
                    </select>
                  </span></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Employee's Affidavit :</td>
                  <td class="oe_form_group_cell"><select name="PF_STATUS_E_AFFIDAVIT" id="PF_STATUS_E_AFFIDAVIT">
                    <option selected><?=$PF_STATUS_E_AFFIDAVIT?></option>
                            <option>Yes</option>
                            <option>No</option>
                  </select></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Posting Letter :</span></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">
                    <select name="PF_STATUS_POSTING_LETTER" id="PF_STATUS_POSTING_LETTER">
                      <option selected>
                        <?=$PF_STATUS_POSTING_LETTER?>
                        </option>
                              <option>Posting</option>
                              <option>Posting</option>
                    </select>
                  </span></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Affidavit of Guardian  :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="PF_STATUS_G_AFFIDAVIT" id="PF_STATUS_G_AFFIDAVIT">
                    <option selected><?=$PF_STATUS_G_AFFIDAVIT?></option>
                            <option>Yes</option>
                            <option>No</option>
                  </select></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Cleanrance Certificate :</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">
                    <select name="PF_STATUS_C_CERTIFICATE" id="PF_STATUS_C_CERTIFICATE">
                      <option selected>
                        <?=$PF_STATUS_C_CERTIFICATE?>
                        </option>
                              <option>Yes</option>
                              <option>No</option>
                    </select>
                  </span></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Guardian Certify Letter :</td>
                  <td class="oe_form_group_cell oe_form_group_cell_label"><select name="PF_STATUS_G_CERTIFY_LETTER" id="PF_STATUS_G_CERTIFY_LETTER">
                    <option selected><?=$PF_STATUS_G_CERTIFY_LETTER?></option>
                            <option>Yes</option>
                            <option>No</option>
                  </select></td>
                  <td class="oe_form_group_cell oe_form_group_cell_label"> Nominee :</td>
                  <td class="oe_form_group_cell oe_form_group_cell_label"><select name="PF_STATUS_NOMINEE" id="PF_STATUS_NOMINEE">
                    <option selected>
                      <?=$PF_STATUS_NOMINEE?>
                      </option>
                              <option>Yes</option>
                              <option>No</option>
                    </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Guardian's Photo :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><select name="PF_STATUS_G_PHOTO" id="PF_STATUS_G_PHOTO">
                    <option selected><?=$PF_STATUS_G_PHOTO?></option>
                            <option>Yes</option>
                            <option>No</option>
                  </select></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Nominee Photo :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><select name="PF_STATUS_NOMINEE_PHOTO" id="PF_STATUS_NOMINEE_PHOTO">
                    <option selected>
                      <?=$PF_STATUS_NOMINEE_PHOTO?>
                      </option>
                              <option>Yes</option>
                              <option>No</option>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Employee's Photo :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><select name="PF_STATUS_NOMINEE_PHOTO" id="PF_STATUS_NOMINEE_PHOTO">
                    <option selected>
                    <?=$PF_STATUS_NOMINEE_PHOTO?>
                    </option>
                    <option>Yes</option>
                    <option>No</option>
                  </select></td>
                </tr>
                
                </tbody></table></td>
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
