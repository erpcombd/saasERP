<?php
//


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Action/Official Letters Management';			// Page Name and Page Title
$page="action_management.php";		// PHP File Name
$input_page="action_management_input.php";
$root='hrm';

$table='action_management';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='subject_id';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::
do_calander('#issued_date');
do_calander('#effect_date');
do_calander('#m_date');

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
$_POST['EXPERIENCE_LENGTH']=Date2Dateinterval($_POST['EXPERIENCE_FROM'],$_POST['EXPERIENCE_TO']);
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
<? do_calander('#issued_date');
do_calander('#effect_date');
do_calander('#m_date');?>
</head>
<body>

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
        <td class="oe_form_group_cell"><table width="282" height="109" border="0" cellpadding="0" cellspacing="0" class="oe_form_group "><tbody>
                <tr class="oe_form_group_row">
         <td bgcolor="#E8E8E8" width="38%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Subject:</td>
                  <td bgcolor="#E8E8E8" width="31%" colspan="1" class="oe_form_group_cell">
                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                  <select name="subject_id" id="subject_id" required>
				<? foreign_relation('action_subject','id','action_subject',$subject_id);?>
                  </select></td>
                  <td bgcolor="#E8E8E8" width="31%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Category:</span></td>
                  <td bgcolor="#E8E8E8" width="62%" class="oe_form_group_cell">
				  <select name="category_id" id="category_id" required>
					<? foreign_relation('action_category','id','action_category',$category_id);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Issued By:</td>
                  <td class="oe_form_group_cell"><select name="issued_by" id="issued_by">
                    <option selected><?=$issued_by?></option>
                    <option>ED</option>
                    <option>Department</option>
					<option>HR-M & Admin</option>
					<option>Others</option>
                  </select></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Memo No:</span></td>
                  <td class="oe_form_group_cell"><input name="memo_no" type="text" id="memo_no" value="<?=$memo_no?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Issued Date:</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="issued_date" type="text" id="issued_date" value="<?=$issued_date?>" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Amount:</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="amount" type="text" id="amount" value="<?=$amount?>" /></td>
                </tr>
				                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Effect Date:</td>
                  <td class="oe_form_group_cell"><input name="effect_date" type="text" id="effect_date" value="<?=$effect_date?>" /></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Description:</span></td>
                  <td rowspan="3" class="oe_form_group_cell"><textarea name="description" id="description"><?=$description?>
                  </textarea></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Type:</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">
				  <select name="type" id="type" required>
                    <option selected><?=$type?></option>
                    <option>Positive</option>
                    <option>Negative</option>
					<option>N/A</option>
                  </select>
				  </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                  </tr>
				                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td class="oe_form_group_cell">&nbsp;</td>
                  <td class="oe_form_group_cell">&nbsp;</td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td colspan="4" bgcolor="#FFCCCC" class="oe_form_group_cell_label oe_form_group_cell"><strong>&nbsp;&nbsp;Mitigation</strong></td>
                  </tr>
				                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Date:</td>
                  <td class="oe_form_group_cell"><input name="m_date" type="text" id="m_date" value="<?=$m_date?>" /></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Evidance:</span></td>
                  <td class="oe_form_group_cell"><select name="m_evidance" id="m_evidance">
                    <option selected><?=$m_evidance?></option>
                    <option>Yes</option>
                    <option>No</option>
					<option>N/A</option>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Mitigated:</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="m_mitigated" id="m_mitigated">
                    <option selected><?=$m_mitigated?></option>
                    <option>Yes</option>
                    <option>No</option>
                  </select></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Description:</span></td>
                  <td rowspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell">
				  <textarea name="m_description" id="m_description"><?=$m_description?></textarea></td>
                </tr>
				                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td class="oe_form_group_cell">&nbsp;</td>
                  <td class="oe_form_group_cell">&nbsp;</td>
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
