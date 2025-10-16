<?php

//require "../../config/inc.all.php";

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Training Entry From Management';			// Page Name and Page Title
$page="training.php";		// PHP File Name
$input_page="training_input.php";
$root='hrm';

$table='training_detail';		// Database Table Name Mainly related to this page
$unique='TRAINING_D_ID';			// Primary Key of this Database table
$shown='TRAINING_NAME';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert'])||isset($_POST['insertn']))
{		
$now= time();

$date1=date_create($_POST['TRAINING_DATE_FROM']);
$date2=date_create($_POST['TRAINING_DATE_TO']);
$diff=date_diff($date1,$date2);

$interval = date_diff(date_create($_POST['TRAINING_DATE_FROM']), date_create($_POST['TRAINING_DATE_TO']));

		    $service_length =  $interval->format("%Y Year, %M Months, %d Days");
			
$_POST['TRAINING_LENGTH']=$service_length;



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

$date1=date_create($_POST['TRAINING_DATE_FROM']);
$date2=date_create($_POST['TRAINING_DATE_TO']);
$diff=date_diff($date1,$date2);

$interval = date_diff(date_create($_POST['TRAINING_DATE_FROM']), date_create($_POST['TRAINING_DATE_TO']));

		    $service_length =  $interval->format("%Y Year, %M Months, %d Days");
			
$_POST['TRAINING_LENGTH']=$service_length;
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
<? do_calander('#TRAINING_DATE_FROM');?>
<? do_calander('#TRAINING_DATE_TO');?>
</head>


<style>

body{
display:flex;

}

.oe_form_group_cell_label {
  background-color: #3498db; 
   padding: 15px; 
  padding-top: 50px; 
  border-radius: 8px;
  font-size: 16px;  
  text-align: center;
  
}

.oe_form_group_cell input,
.oe_form_group_cell select {
 
  padding: 0px;
  margin-bottom: 15px;
  border: none;
  background-color: #dbf1f8; 
  border-radius: 8px;
  box-sizing: border-box;
  font-size: 14px; 
  color: #333;
  transition: background-color 0.3s ease-in-out;
}

.oe_form_group_cell {
  background-color: #d9e3fc; 
  padding: 0px; 
  border-radius: 8px;
  
}


  
 .oe_form_group_row {
  margin-bottom: 20px; /* Increased margin */
}


.openerp .oe_form input[type="text"], .openerp .oe_form input[type="password"], .openerp .oe_form input[type="file"], .openerp .oe_form select
{
  height: 30px;
  padding-top: 0px;
}
.openerp .oe_form td.oe_form_group_cell_label
{
  border-right: none;
  padding: 8px 0px;
}

.openerp .oe_form_editable .oe_form .oe_form_field_date input {
    width: 14.5em;
}




</style>


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
            <td class="oe_form_group_cell"><table width="100%" height="167" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
              <tbody>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" width="19%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Name of Training :</td>
                  <td bgcolor="#E8E8E8" colspan="3" class="oe_form_group_cell">
                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                    <input name="TRAINING_NAME" type="text" id="TRAINING_NAME" value="<?=$TRAINING_NAME?>" /></td>
                </tr>
                
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp; Date(From) :</label></td>
                  <td width="30%" colspan="1" class="oe_form_group_cell"><input name="TRAINING_DATE_FROM" type="text" id="TRAINING_DATE_FROM" value="<?=$TRAINING_DATE_FROM?>" /></td>
                  <td width="16%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Date (To) :</span></td>
                  <td width="35%" class="oe_form_group_cell"><input name="TRAINING_DATE_TO" type="text" id="TRAINING_DATE_TO" value="<?=$TRAINING_DATE_TO?>" /></td>
                </tr>
                
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Domestic/Overseas :</td>
                  <td class="oe_form_group_cell">
                  <input name="TRAINING_DOMESTIC_OVERSEAS" type="text" id="TRAINING_DOMESTIC_OVERSEAS" value="<?=$TRAINING_DOMESTIC_OVERSEAS?>" /></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Place :</span></td>
                  <td class="oe_form_group_cell"><input name="TRAINING_PLACE" type="text" id="TRAINING_PLACE" value="<?=$TRAINING_PLACE?>" /></td>
                </tr>
                <tr class="TRAINING_DOMESTIC_OVERSEAS">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Country : </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="TRAINING_COUNTRY" type="text" id="TRAINING_COUNTRY" value="<?=$TRAINING_COUNTRY?>" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Sponsor Organi : </span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_field oe_datepicker_root oe_form_field_date">
                    <input name="TRAINING_SPONSOR_ORGANIZATION" type="text" id="TRAINING_SPONSOR_ORGANIZATION" value="<?=$TRAINING_SPONSOR_ORGANIZATION?>" />
                  </span></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Venue :</td>
                  <td colspan="3" class="oe_form_group_cell"><input name="TRAINING_VENUE" type="text" id="TRAINING_VENUE" value="<?=$TRAINING_VENUE?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Document :</td>
                  <td bgcolor="#E8E8E8" colspan="3" class="oe_form_group_cell"><select name="TRAINING_DOCUMENT">
                      <option selected>
                        <?=$TRAINING_DOCUMENT?>
                        </option>
                      <option>Yes</option>
                      <option>No</option>
                    </select></td>
                </tr>
                </tbody></table>
              <p>&nbsp;</p></td>
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
