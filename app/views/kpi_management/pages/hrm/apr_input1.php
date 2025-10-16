<?php
session_start();

require "../../config/inc.all.php";

// ::::: Edit This Section ::::: 
$title='APR Entry Management';			// Page Name and Page Title
$page="apr1.php";		// PHP File Name
$input_page="apr_input1.php";
$root='hrm';

$table='apr_detail';		// Database Table Name Mainly related to this page
$unique='APR_D_ID';			// Primary Key of this Database table
$shown='APR_YEAR';				// For a New or Edit Data a must have data field

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
            <td class="oe_form_group_cell"><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0">
              <tbody>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" width="12%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;ID :</td>
                  <td bgcolor="#E8E8E8" width="17%" colspan="1" class="oe_form_group_cell">
                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                  <input name="APR_DESG_TO2" type="text" id="APR_DESG_TO2" value="<?=$APR_DESG_TO?>" /></td>
                  <td bgcolor="#E8E8E8" width="40%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Domain :</span></td>
                  <td bgcolor="#E8E8E8" width="31%" class="oe_form_group_cell"><input name="APR_DESG_TO4" type="text" id="APR_DESG_TO4" value="<?=$APR_DESG_TO?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;Name :</label></td>
                  <td class="oe_form_group_cell"><input name="APR_DESG_TO3" type="text" id="APR_DESG_TO3" value="<?=$APR_DESG_TO?>" /></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Department  :</span></td>
                  <td class="oe_form_group_cell"><input name="APR_DESG_FROM" type="text" id="APR_DESG_FROM" value="<?=$APR_DESG_FROM?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Sex :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="APR_MARKS" type="text" id="APR_MARKS" value="<?=$APR_MARKS?>" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Project :</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="APR_DESG_TO" type="text" id="APR_DESG_TO" value="<?=$APR_DESG_TO?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td height="26" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Education Qualification :</td>
                  <td class="oe_form_group_cell"><input name="APR_MARKS6" type="text" id="APR_MARKS7" value="<?=$APR_MARKS?>" /></td>
                  <td class="oe_form_group_cell">Zone :</td>
                  <td class="oe_form_group_cell"><input name="APR_MARKS5" type="text" id="APR_MARKS6" value="<?=$APR_MARKS?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Institute :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="APR_MARKS2" type="text" id="APR_MARKS2" value="<?=$APR_MARKS?>" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"> Present Department :</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="APR_DESG_TO4" type="text" id="APR_DESG_TO5" value="<?=$APR_DESG_TO?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td height="27" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Initial Joining Date :</td>
                  <td class="oe_form_group_cell"><input name="APR_MARKS3" type="text" id="APR_MARKS4" value="<?=$APR_MARKS?>" /></td>
                  <td class="oe_form_group_cell">APR Year :</td>
                  <td class="oe_form_group_cell"><input name="APR_MARKS4" type="text" id="APR_MARKS5" value="<?=$APR_MARKS?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Date of Birth  :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="APR_MARKS2" type="text" id="APR_MARKS3" value="<?=$APR_MARKS?>" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Date of Present Post :</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="APR_DESG_TO4" type="text" id="APR_DESG_TO6" value="<?=$APR_DESG_TO?>" /></td>
                </tr>
                </tbody></table>
              <p>&nbsp;</p>
              <table width="38%" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
                <tbody>
                  <tr class="oe_form_group_row">
                    <td bgcolor="#E8E8E8" width="14%" colspan="1" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;Totel Service Length :</span></td>
                    <td width="44%" bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="<?=$unique?>2" id="<?=$unique?>2" value="<?=$$unique?>" type="hidden" />
                      <input name="APR_DESG_TO6" type="text" id="APR_DESG_TO7" value="<?=$APR_DESG_TO?>" /></td>
                    </tr>
                  <tr class="oe_form_group_row">
                    <td colspan="1" class="oe_form_group_cell">Services Length (PP)</td>
                    <td class="oe_form_group_cell"><input name="APR_DESG_TO5" type="text" id="APR_DESG_TO8" value="<?=$APR_DESG_TO?>" /></td>
                    </tr>
                  <tr class="oe_form_group_row">
                    <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell">Age :</td>
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="APR_DESG_TO7" type="text" id="APR_DESG_TO9" value="<?=$APR_DESG_TO?>" /></td>
                    </tr>
                  <tr class="oe_form_group_row">
                    <td colspan="1" class="oe_form_group_cell">Cross Year :</td>
                    <td class="oe_form_group_cell"><input name="APR_DESG_TO8" type="text" id="APR_DESG_TO10" value="<?=$APR_DESG_TO?>" /></td>
                    </tr>
                  <tr class="oe_form_group_row">
                    <td bgcolor="#E8E8E8" colspan="2" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                    </tr>
                </tbody>
              </table>              
              <p>&nbsp;</p>
              <table class="oe_form_group " border="0" cellpadding="0" cellspacing="0">
                <tbody>
                  <tr class="oe_form_group_row">
                    <td height="30" colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</span>     
                      <input name="<?=$unique?>3" id="<?=$unique?>3" value="<?=$$unique?>" type="hidden" /> 
                      APR Year Marks Calculation</td>
                    </tr>
                  <tr class="oe_form_group_row">
                    <td class="oe_form_group_cell oe_form_group_cell_label">Marks (Within 85) :</td>
                    <td width="43%" class="oe_form_group_cell"><input name="APR_DESG_TO9" type="text" id="APR_DESG_TO12" value="<?=$APR_DESG_TO?>" /></td>
                    </tr>
                  <tr class="oe_form_group_row">
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Marks (Within 15 ) :</td>
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="APR_DESG_TO9" type="text" id="APR_DESG_TO13" value="<?=$APR_DESG_TO?>" /></td>
                    </tr>
                  <tr class="oe_form_group_row">
                    <td class="oe_form_group_cell oe_form_group_cell_label">Marks :</td>
                    <td class="oe_form_group_cell"><input name="APR_DESG_TO9" type="text" id="APR_DESG_TO14" value="<?=$APR_DESG_TO?>" /></td>
                    </tr>
                  <tr class="oe_form_group_row">
                    <td height="27" colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                    </tr>
                </tbody>
              </table>              
              <p>&nbsp;</p>
              <table class="oe_form_group " border="0" cellpadding="0" cellspacing="0">
                <tbody>
                  <tr class="oe_form_group_row">
                    <td height="30" colspan="4" bgcolor="#E8E8E8" class="oe_form_group_cell">
                      <span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</span>
                      <input name="<?=$unique?>5" id="<?=$unique?>5" value="<?=$$unique?>" type="hidden" />
                      APR Year Average Marks Calculation</td>
                    </tr>
                  <tr class="oe_form_group_row">
                    <td width="12%" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell">Year :</td>
                    <td width="14%" bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">
                      <input name="APR_DESG_TO10" type="text" id="APR_DESG_TO11" value="<?=$APR_DESG_TO?>" />
                      </span></td>
                    <td width="8%" bgcolor="#E8E8E8" class="oe_form_group_cell">Marks :</td>
                    <td width="12%" bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">
                      <input name="APR_DESG_TO19" type="text" id="APR_DESG_TO23" value="<?=$APR_DESG_TO?>" />
                    </span></td>
                    </tr>
                  <tr class="oe_form_group_row">
                    <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell">Year :</td>
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">
                      <input name="APR_DESG_TO10" type="text" id="APR_DESG_TO11" value="<?=$APR_DESG_TO?>" />
                    </span></td>
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell">Marks :</td>
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">
                      <input name="APR_DESG_TO19" type="text" id="APR_DESG_TO23" value="<?=$APR_DESG_TO?>" />
                    </span></td>
                    </tr>
                  <tr class="oe_form_group_row">
                    <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell">Year :</td>
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">
                      <input name="APR_DESG_TO10" type="text" id="APR_DESG_TO11" value="<?=$APR_DESG_TO?>" />
                    </span></td>
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell">Marks :</td>
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">
                      <input name="APR_DESG_TO19" type="text" id="APR_DESG_TO23" value="<?=$APR_DESG_TO?>" />
                    </span></td>
                    </tr>
                  <tr class="oe_form_group_row">
                    <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell">&nbsp;</td>
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                    </tr>
                  <tr class="oe_form_group_row">
                    <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Total Marks :</span></td>
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">
                      <input name="APR_DESG_TO16" type="text" id="APR_DESG_TO20" value="<?=$APR_DESG_TO?>" />
                    </span></td>
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Average Marks :</span></td>
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">
                      <input name="APR_DESG_TO17" type="text" id="APR_DESG_TO21" value="<?=$APR_DESG_TO?>" />
                    </span></td>
                    </tr>
                  <tr class="oe_form_group_row">
                    <td colspan="1" class="oe_form_group_cell">&nbsp;</td>
                    <td class="oe_form_group_cell">&nbsp;</td>
                    <td colspan="2" class="oe_form_group_cell">&nbsp;</td>
                  </tr>
                  <tr class="oe_form_group_row">
                    <td height="27" colspan="4" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  </tr>
                </tbody>
              </table>
              <p>&nbsp;</p>
              <table class="oe_form_group " border="0" cellpadding="0" cellspacing="0">
                <tbody>
                  <tr class="oe_form_group_row">
                    <td height="30" colspan="3" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</span>
                      <input name="<?=$unique?>4" id="<?=$unique?>4" value="<?=$$unique?>" type="hidden" /> 
                      Employee Promotion By APR</td>
                    </tr>
                  <tr class="oe_form_group_row">
                    <td width="16%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Overall assessment:</td>
                    <td colspan="2" class="oe_form_group_cell"><select name="PF_STATUS_APPOINTMENT_LETTER" id="PF_STATUS_APPOINTMENT_LETTER">
                      <option selected>
                        <?=$PF_STATUS_APPOINTMENT_LETTER?>
                        </option>
                      <option>Excellent</option>
                      <option>Good</option>
                      <option>Not Bad</option>
                      <option>Not Full Unsatisfied</option>
                      <option>Not Satisfied</option>
                    </select></td>
                    </tr>
                  <tr class="oe_form_group_row">
                    <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Recommend For Promotion :</td>
                    <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="PF_STATUS_APPOINTMENT_LETTER" id="PF_STATUS_APPOINTMENT_LETTER">
                      <option selected>
                        <?=$PF_STATUS_APPOINTMENT_LETTER?>
                        </option>
                      <option>Yes</option>
                      <option>No</option>
                    </select></td>
                  </tr>
                  <tr class="oe_form_group_row">
                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Imitate Higher Authirity Signature :</td>
                    <td colspan="2" class="oe_form_group_cell"><select name="PF_STATUS_APPOINTMENT_LETTER" id="PF_STATUS_APPOINTMENT_LETTER">
                      <option selected>
                        <?=$PF_STATUS_APPOINTMENT_LETTER?>
                        </option>
                      <option>Yes</option>
                      <option>No</option>
                    </select></td>
                  </tr>
                  <tr class="oe_form_group_row">
                    <td height="27" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Next Higher Authirity Signature:</td>
                    <td height="27" colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><select name="PF_STATUS_APPOINTMENT_LETTER" id="PF_STATUS_APPOINTMENT_LETTER">
                      <option selected>
                        <?=$PF_STATUS_APPOINTMENT_LETTER?>
                        </option>
                      <option>Yes</option>
                      <option>No</option>
                    </select></td>
                  </tr>
                  <tr class="oe_form_group_row">
                    <td height="27" colspan="3" class="oe_form_group_cell oe_form_group_cell_label"></td>
                    </tr>
                  <tr class="oe_form_group_row">
                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Above Recommended With :</td>
                    <td colspan="2" class="oe_form_group_cell"><select name="PF_STATUS_APPOINTMENT_LETTER" id="PF_STATUS_APPOINTMENT_LETTER">
                      <option selected>
                        <?=$PF_STATUS_APPOINTMENT_LETTER?>
                        </option>
                      <option>Full Agree</option>
                      <option>Not Full Agree</option>
                      <option>Full Differ</option>
                      <option>Not Full Differ</option>
                      <option>N/A</option>
                    </select></td>
                  </tr>
                  <tr class="oe_form_group_row">
                    <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Recommend For Promotion:</td>
                    <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="PF_STATUS_APPOINTMENT_LETTER" id="PF_STATUS_APPOINTMENT_LETTER">
                      <option selected>
                        <?=$PF_STATUS_APPOINTMENT_LETTER?>
                        </option>
                      <option>Yes</option>
                      <option>No</option>
                      <option>N/A</option>
                    </select></td>
                  </tr>
                  <tr class="oe_form_group_row">
                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Zone In Cherge Signature :</td>
                    <td colspan="2" class="oe_form_group_cell"><select name="PF_STATUS_APPOINTMENT_LETTER" id="PF_STATUS_APPOINTMENT_LETTER">
                      <option selected>
                        <?=$PF_STATUS_APPOINTMENT_LETTER?>
                        </option>
                      <option>Yes</option>
                      <option>No</option>
                      <option>N/A</option>
                    </select></td>
                  </tr>
                  <tr class="oe_form_group_row">
                    <td height="27" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">CC Signature :</td>
                    <td height="27" colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">
                    <select name="PF_STATUS_APPOINTMENT_LETTER" id="PF_STATUS_APPOINTMENT_LETTER">
                      <option selected>
                        <?=$PF_STATUS_APPOINTMENT_LETTER?>
                        </option>
                      <option>Yes</option>
                      <option>No</option>
                      <option>N/A</option>
                    </select></td>
                  </tr>
                  <tr class="oe_form_group_row">
                    <td height="27" colspan="3" class="oe_form_group_cell oe_form_group_cell_label"></td>
                    </tr>
                  <tr class="oe_form_group_row">
                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Above Reconneded With:</td>
                    <td colspan="2" class="oe_form_group_cell"><select name="PF_STATUS_APPOINTMENT_LETTER" id="PF_STATUS_APPOINTMENT_LETTER">
                      <option selected>
                        <?=$PF_STATUS_APPOINTMENT_LETTER?>
                        </option>
                      <option>Full Agree</option>
                      <option>Not Full Agree</option>
                      <option>Full Differ</option>
                      <option>Not Full Differ</option>
                    </select></td>
                  </tr>
                  <tr class="oe_form_group_row">
                    <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Recommend For Promotion:</td>
                    <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="PF_STATUS_APPOINTMENT_LETTER" id="PF_STATUS_APPOINTMENT_LETTER">
                      <option selected>
                        <?=$PF_STATUS_APPOINTMENT_LETTER?>
                        </option>
                      <option>Yes</option>
                      <option>No</option>
                    </select></td>
                  </tr>
                  <tr class="oe_form_group_row">
                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Departmental Head Signature :</td>
                    <td colspan="2" class="oe_form_group_cell"><select name="PF_STATUS_APPOINTMENT_LETTER" id="PF_STATUS_APPOINTMENT_LETTER">
                      <option selected>
                        <?=$PF_STATUS_APPOINTMENT_LETTER?>
                        </option>
                      <option>Yes</option>
                      <option>No</option>
                    </select></td>
                  </tr>
                  <tr class="oe_form_group_row">
                    <td height="20" colspan="3" class="oe_form_group_cell oe_form_group_cell_label"></td>
                    </tr>
                  <tr class="oe_form_group_row">
                    <td height="20" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><p>&nbsp;</p>
                      <p>&nbsp;</p></td>
                    <td width="46%" height="20" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">
                    <textarea name="textarea" id="textarea" cols="45" rows="5"></textarea></td>
                    <td width="38%" height="20" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  </tr>
                </tbody>
              </table>
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
