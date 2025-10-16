<?php
//


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='APR Entry Management';			// Page Name and Page Title
$page="apr.php";		// PHP File Name
$input_page="apr_input.php";
$root='hrm';

$table='apr_detail';		// Database Table Name Mainly related to this page
$unique='APR_D_ID';			// Primary Key of this Database table
$shown='APR_YEAR';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::

$personnel_basic_info=find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);

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
foreach ($data as $key => $value)
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
<? do_calander('#APR_DESG_FROM');?>
<? do_calander('#APR_DESG_TO');?>
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
                  <td bgcolor="#00CC00" colspan="4" class="oe_form_group_cell oe_form_group_cell_label"><strong>APR Achievement in Marks:</strong></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Name :</td>
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell"><input name="APR_MARKS2" type="text" id="APR_MARKS2" value="<?=$personnel_basic_info->PBI_NAME?>" readonly /></td>
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Designation :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="APR_MARKS3" type="text" id="APR_MARKS3" value="<?=$personnel_basic_info->PBI_DESIGNATION?>" readonly /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Domain :</td>
                  <td colspan="1" class="oe_form_group_cell"><input name="APR_MARKS4" type="text" id="APR_MARKS4" value="<?=$personnel_basic_info->PBI_DOMAIN?>"  readonly/></td>
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Area :</td>
                  <td class="oe_form_group_cell"><input name="APR_MARKS5" type="text" id="APR_MARKS5" readonly value="<?=$personnel_basic_info->PBI_AREA?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Service Length PP:</td>
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell"><input name="APR_MARKS6" type="text" id="APR_MARKS6" value="<?=Date2age($personnel_basic_info->PBI_DOJ_PP)?>"  readonly/></td>
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Job Status :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="APR_MARKS7" type="text" id="APR_MARKS7" value="<?=$personnel_basic_info->PBI_JOB_STATUS?>"  readonly/></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Year :</td>
                  <td colspan="1" class="oe_form_group_cell">
                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                    <select name="APR_YEAR">
                      <option selected><?=$APR_YEAR?></option>
                        <option>2000</option>
                        <option>2001</option>
                        <option>2002</option>
                        <option>2003</option>
                        <option>2004</option>
                        <option>2005</option>
                        <option>2006</option>
                        <option>2007</option>
                        <option>2008</option>
                        <option>2009</option>
                        <option>2010</option>
                        <option>2011</option>
                        <option>2012</option>
                        <option>2013</option>
                        <option>2014</option>
                        <option>2015</option>
                        <option>2016</option>
                    </select></td>
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Marks :</td>
                  <td class="oe_form_group_cell"><input name="APR_MARKS" type="text" id="APR_MARKS" value="<?=$APR_MARKS?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="4" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="4" bgcolor="#CCFF66" class="oe_form_group_cell oe_form_group_cell_label"><strong>APR Recommendation:</strong></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;Recommendation:</label></td>
                  <td class="oe_form_group_cell"><select name="APR_RECOMMENDATION">
                   <option selected><?=$APR_RECOMMENDATION?></option>
                    <option>Increment</option>
                    <option>Promotion</option>
                    <option>N/A</option>
                  </select></td>
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Status :</td>
                  <td class="oe_form_group_cell"><select name="APR_STATUS">
                    <option selected>
                      <?=$APR_STATUS?>
                    </option>
                    <option>Everything Ok</option>
                    <option>Below Service Length</option>
                    <option>Financial Objection</option>
                    <option>Below Marks</option>
                    <option>Over Age</option>
                    <option>Below Average Marks</option>
                    <option>Already Promoted</option>
                    <option>LPD</option>
                    <option>Already Get Increnent</option>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="4" class="oe_form_group_cell">&nbsp;</td>
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
