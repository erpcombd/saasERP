<?php
session_start();

require "../../config/inc.all.php";

// ::::: Edit This Section ::::: 
$title='Posting Entey Management';			// Page Name and Page Title
$page="posting_entry.php";		// PHP File Name
$input_page="posting_entry_input.php";
$root='hrm';

$table='posting';		// Database Table Name Mainly related to this page
$unique='POSTING_CODE';			// Primary Key of this Database table
$shown='POSTING_NAME';				// For a New or Edit Data a must have data field

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
            <td class="oe_form_group_cell"><table width="100%" height="171" border="0" cellpadding="0" cellspacing="0" class="oe_form_group "><tbody>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" width="100%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;ID :</td>
                  <td bgcolor="#E8E8E8" width="100%" colspan="1" class="oe_form_group_cell">
                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$unique?>" type="hidden" />
                    <input name="PBI_ID" type="text" id="PBI_ID" value="<?=$PBI_ID?>" /></td>
                  <td bgcolor="#E8E8E8" width="100%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Zone :</span></td>
                  <td bgcolor="#E8E8E8" width="100%" class="oe_form_group_cell"><select name="zon">
                    <? foreign_relation('zon','U_ID','ZONE_NAME',$zon);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;Name :</label></td>
                  <td class="oe_form_group_cell"><input name="POSTING_NAME" type="text" id="POSTING_NAME" value="<?=$POSTING_NAME?>" /></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Area :</span></td>
                  <td class="oe_form_group_cell"><select name="area">
                    <? foreign_relation('area','U_ID','AREA_NAME',$area);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Designation :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="POSTING_DESIGNATION" id="DESG_ID">
     			  <? foreign_relation('designation','DESG_ID','DESG_DESC',$PBI_DESIGNATION);?>
      
   				 </select></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Branch :</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="POSTING_BRANCH">
                    <? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$PBI_BRANCH);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Project :</td>
                  <td class="oe_form_group_cell"><select name="POSTING_PROJECT">
                    <? foreign_relation('project','PROJECT_ID','PROJECT_DESC',$POSTING_PROJECT);?>
                  </select></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Posting By</span></td>
                  <td class="oe_form_group_cell"><span class="oe_form_field oe_datepicker_root oe_form_field_date">
                    <input name="POSTING_BY" type="text" id="POSTING_BY" value="<?=$POSTING_BY?>" />
                  </span></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Department :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="POSTING_DEPARTMENT">
                    <? foreign_relation('department','DEPT_ID','DEPT_DESC',$POSTING_DEPARTMENT);?>
                  </select></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Memo No :</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_field oe_datepicker_root oe_form_field_date">
                    <input name="POSTING_MEMO" type="text" id="POSTING_MEMO" value="<?=$POSTING_MEMO?>" />
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
