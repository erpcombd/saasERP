<?php
session_start();

//require "../../config/inc.all.php";

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Promotion Management';			// Page Name and Page Title
$page="promotion.php";		// PHP File Name
$input_page="promotion_input.php";
$root='hrm';

$table='promotion_detail';		// Database Table Name Mainly related to this page
$unique='PROMOTION_D_ID';			// Primary Key of this Database table
$shown='PROMOTION_TYPE';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::




$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert'])||isset($_POST['insertn']))
{		
$now				= time();
$PBI_DESIGNATION = find_a_field('designation','DESG_SHORT_NAME','DESG_ID='.$_POST['PROMOTION_PRESENT_DESG']);

$_POST['PBI_ID']=$_SESSION['employee_selected'];

/*$vars['PBI_DESIGNATION']=$_POST['PROMOTION_PRESENT_DESG'];
$vars['PBI_DOJ_PP']=$_POST['PROMOTION_DATE'];
$vars['PBI_DESG_GRADE'] = find_a_field('designation','DESG_GRADE','DESG_SHORT_NAME="'.$vars['PBI_DESIGNATION'].'"');
db_update('personnel_basic_info', $_POST['PBI_ID'], $vars, 'PBI_ID');*/
$u_sql='UPDATE personnel_basic_info SET 
DESG_ID="'.$_POST['PROMOTION_PRESENT_DESG'].'",  
PBI_DESIGNATION="'.$PBI_DESIGNATION.'", 
PBI_DOJ_PP="'.$_POST['PROMOTION_DATE'].'" 
WHERE PBI_ID='.$_SESSION['employee_selected'];
db_query($u_sql);


$_REQUEST['entry_by']=$_SESSION['user']['id'];
$_REQUEST['entry_at']=date('Y-m-d H:i:s');
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
$PBI_DESIGNATION = find_a_field('designation','DESG_SHORT_NAME','DESG_ID='.$_POST['PROMOTION_PRESENT_DESG']);
/*$vars['PBI_DESIGNATION']=$_POST['PROMOTION_PRESENT_DESG'];
$vars['PBI_DOJ_PP']=$_POST['PROMOTION_DATE'];
$vars['PBI_DESG_GRADE'] = find_a_field('designation','DESG_GRADE','DESG_SHORT_NAME="'.$vars['PBI_DESIGNATION'].'"');
db_update('personnel_basic_info', $_POST['PBI_ID'], $vars, 'PBI_ID');*/
$u_sql='UPDATE personnel_basic_info SET 
DESG_ID="'.$_POST['PROMOTION_PRESENT_DESG'].'",
PBI_DESIGNATION="'.$PBI_DESIGNATION.'", 
PBI_DOJ_PP="'.$_POST['PROMOTION_DATE'].'" WHERE PBI_ID='.$_SESSION['employee_selected'];
db_query($u_sql);


$_REQUEST['update_by']=$_SESSION['user']['id'];
$_REQUEST['update_at']=date('Y-m-d H:i:s');
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
$past=find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);
$PROMOTION_PAST_DESG=$past->DESG_ID;
?>
<html style="height: 100%;"><head>
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <meta content="text/html; charset=UTF-8" http-equiv="content-type">
        <link href="../../../../public/assets/css/css.css" rel="stylesheet">
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.datepicker.js"></script>
<? do_calander('#PROMOTION_DATE');?>
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
            <td class="oe_form_group_cell"><table width="100%" height="128" border="0" cellpadding="0" cellspacing="0" class="oe_form_group "><tbody>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Ref. No  :</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">
				  <input name="PROMOTION_NOTES" type="text" id="PROMOTION_NOTES" value="<?=$PROMOTION_NOTES?>" required="required"/></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" width="17%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Promotion Type :</td>
                  <td bgcolor="#E8E8E8" width="28%" colspan="1" class="oe_form_group_cell">
                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" required="required"/>
                    <select name="PROMOTION_TYPE">
                     <option selected><?=$PROMOTION_TYPE?></option>
                            <option>APR</option>
                            <option>SP</option>
                            <option>Internal Exa.</option>
                            <option>External Exa.</option>
                    </select></td>
                  <td bgcolor="#E8E8E8" width="18%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Effect Date :</span></td>
                  <td bgcolor="#E8E8E8" width="37%" class="oe_form_group_cell">
				  <input name="PROMOTION_DATE" type="text" id="PROMOTION_DATE" value="<?=$PROMOTION_DATE?>" required="required"/></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>Present Designation :</label></td>
                  <td class="oe_form_group_cell">
				  <?=find_a_field('designation','DESG_DESC','DESG_ID='.$PROMOTION_PAST_DESG);?>
				  <input name="PROMOTION_PAST_DESG" type="hidden" id="PROMOTION_PAST_DESG" value="<?=$PROMOTION_PAST_DESG?>" /></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">New Designation :</span></td>
                  <td class="oe_form_group_cell">
				  <select name="PROMOTION_PRESENT_DESG" required="required">
                    <? foreign_relation('designation','DESG_ID','DESG_DESC',$PROMOTION_PRESENT_DESG);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Level Up :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="PROMOTION_CROSSED_LEVEL" id="PROMOTION_CROSSED_LEVEL">
                      <option selected>
                        <?=$PROMOTION_CROSSED_LEVEL?>
                        </option>
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                      <option>6</option>
                  </select></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Report To:</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">
				  <input name="report_to" type="text" id="report_to" value="<?=$report_to?>" required="required"/></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
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
