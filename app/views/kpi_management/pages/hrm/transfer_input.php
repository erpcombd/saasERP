<?php
session_start();

require "../../config/inc.all.php";

// ::::: Edit This Section ::::: 
$title='Transfer Management';			// Page Name and Page Title
$page="transfer.php";		// PHP File Name
$input_page="transfer_input.php";
$root='hrm';

$table='transfer_detail';		// Database Table Name Mainly related to this page
$unique='TRANSFER_D_ID';			// Primary Key of this Database table
$shown='TRANSFER_ORDER_NO';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud      =new crud($table);

$$unique = $_GET[$unique];

if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert'])||isset($_POST['insertn']))
{		
$now				= time();

$vars['PBI_ID']=$_REQUEST['PBI_ID']=$_SESSION['employee_selected'];


$vars['PBI_DESIGNATION']=$_POST['TRANSFER_DESIGNATION'];
$vars['PBI_DOMAIN']=$_POST['TRANSFER_PRESENT_DOMAIN'];
$vars['PBI_DEPARTMENT']=$_POST['TRANSFER_PRESENT_DEPT'];
$vars['PBI_PROJECT']=$_POST['TRANSFER_PRESENT_PROJECT'];
$vars['PBI_ZONE']=$_POST['TRANSFER_PRESENT_ZONE'];
$vars['PBI_AREA']=$_POST['TRANSFER_PRESENT_AREA'];
$vars['PBI_BRANCH']=$_POST['TRANSFER_PRESENT_BRANCH'];
$vars['PBI_REGION']=$_POST['TRANSFER_PRESENT_REGION'];
db_update('personnel_basic_info', $vars['PBI_ID'], $vars, 'PBI_ID');

$crud->insert();
$type=1;
$msg='New Entry Successfully Inserted.';

if(isset($_POST['insert']))
{
echo '<script type="text/javascript">parent.parent.document.location.href = "../'.$root.'/'.$page.'";</script>';
}
unset($_POST);
unset($$unique);


}


//for Modify..................................

if(isset($_POST['update']))
{
$vars['PBI_ID']=$_SESSION['employee_selected'];



$vars['PBI_DESIGNATION']=$_POST['TRANSFER_DESIGNATION'];
$vars['PBI_DOMAIN']=$_POST['TRANSFER_PRESENT_DOMAIN'];
$vars['PBI_DEPARTMENT']=$_POST['TRANSFER_PRESENT_DEPT'];
$vars['PBI_PROJECT']=$_POST['TRANSFER_PRESENT_PROJECT'];
$vars['PBI_ZONE']=$_POST['TRANSFER_PRESENT_ZONE'];
$vars['PBI_AREA']=$_POST['TRANSFER_PRESENT_AREA'];
$vars['PBI_BRANCH']=$_POST['TRANSFER_PRESENT_BRANCH'];
$vars['PBI_REGION']=$_POST['TRANSFER_PRESENT_REGION'];
db_update('personnel_basic_info', $vars['PBI_ID'], $vars, 'PBI_ID');

		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
				echo '<script type="text/javascript">parent.parent.document.location.href = "../'.$root.'/'.$page.'";</script>';
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
if(!isset($$unique)) {$$unique=db_last_insert_id($table,$unique);



$past=find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);
//var_dump($past);

$TRANSFER_PAST_DOMAIN=$past->PBI_DOMAIN;
$TRANSFER_PAST_DEPT=$past->PBI_DEPARTMENT;
$TRANSFER_PAST_PROJECT=$past->PBI_PROJECT;
$TRANSFER_PAST_ZONE=$past->PBI_ZONE;
$TRANSFER_PAST_AREA=$past->PBI_AREA;
$TRANSFER_PAST_BRANCH=$past->PBI_BRANCH;
$TRANSFER_PAST_REGION=$past->PBI_REGION;
}
//var_dump($past);
?>
<html style="height: 100%;"><head>
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <meta content="text/html; charset=UTF-8" http-equiv="content-type">
        <link href="../../css/css.css" rel="stylesheet">
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.datepicker.js"></script>
<? do_calander('#TRANSFER_ORDER_DATE');?>
<? do_calander('#TRANSFER_AFFECT_DATE');?>
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
            <td class="oe_form_group_cell"><table width="100%" height="229" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
              <tbody>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" width="40%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Memo No : </td>
                  <td bgcolor="#E8E8E8" width="20%" colspan="1" class="oe_form_group_cell">
                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                    <input name="TRANSFER_ORDER_NO" type="text" id="TRANSFER_ORDER_NO" value="<?=$TRANSFER_ORDER_NO?>" /></td>
                  <td bgcolor="#E8E8E8" width="40%" class="oe_form_group_cell">Issue Date :</td>
                  <td bgcolor="#E8E8E8" width="20%" class="oe_form_group_cell"><input name="TRANSFER_ORDER_DATE" type="text" id="TRANSFER_ORDER_DATE" value="<?=$TRANSFER_ORDER_DATE?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;Effect Date : </label></td>
                  <td width="20%" class="oe_form_group_cell"><input name="TRANSFER_AFFECT_DATE" type="text" id="TRANSFER_AFFECT_DATE" value="<?=$TRANSFER_AFFECT_DATE?>" /></td>
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Designation :</td>
                  <td class="oe_form_group_cell"><select name="TRANSFER_DESIGNATION">
                    <? foreign_relation('designation','DESG_SHORT_NAME','DESG_DESC',$TRANSFER_DESIGNATION);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Past Domain :</td>
                  <td width="20%" bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="TRANSFER_PAST_DOMAIN">
                    <? foreign_relation('domai','DOMAIN_SHORT_NAME','DOMAIN_SHORT_NAME',$TRANSFER_PAST_DOMAIN);?>
                  </select></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Present Domain :</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="TRANSFER_PRESENT_DOMAIN">
                    <? foreign_relation('domai','DOMAIN_SHORT_NAME','DOMAIN_SHORT_NAME',$TRANSFER_PRESENT_DOMAIN);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Past Department :</td>
                  <td width="20%" class="oe_form_group_cell"><select name="TRANSFER_PAST_DEPT">
                    <? foreign_relation('department','DEPT_SHORT_NAME','DEPT_DESC',$TRANSFER_PAST_DEPT);?>
                  </select></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Present Dept :</span></td>
                  <td class="oe_form_group_cell"><select name="TRANSFER_PRESENT_DEPT">
                    <? foreign_relation('department','DEPT_SHORT_NAME','DEPT_DESC',$TRANSFER_PRESENT_DEPT);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Past</span> Project :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="TRANSFER_PAST_PROJECT">
                    <? foreign_relation('project','PROJECT_SHORT_NAME','PROJECT_DESC',$TRANSFER_PAST_PROJECT);?>
                  </select></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">Present Project :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="TRANSFER_PRESENT_PROJECT">
                    <? foreign_relation('project','PROJECT_SHORT_NAME','PROJECT_DESC',$TRANSFER_PRESENT_PROJECT);?>
                  </select></td>
                </tr>
				
                <tr class="oe_form_group_row">
                  <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Past Region :</td>
                  <td width="20%" bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="TRANSFER_PAST_REGION">
                     <? foreign_relation('region','region_id','region_name',$TRANSFER_PAST_REGION);?>
                  </select></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Present Region :</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="TRANSFER_PRESENT_REGION">
                   <? foreign_relation('region','region_id','region_name',$TRANSFER_PRESENT_REGION);?>
                  </select></td>
                </tr>
				
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Past Zone :</td>
                  <td width="20%" class="oe_form_group_cell"><select name="TRANSFER_PAST_ZONE">
                    <? foreign_relation('zon','ZONE_NAME','ZONE_NAME',$TRANSFER_PAST_ZONE);?>
                  </select></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Present Zone :</span></td>
                  <td class="oe_form_group_cell"><select name="TRANSFER_PRESENT_ZONE">
                    <? foreign_relation('zon','ZONE_NAME','ZONE_NAME',$TRANSFER_PRESENT_ZONE);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Past Area :</td>
                  <td width="20%" bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="TRANSFER_PAST_AREA">
                    <? foreign_relation('area','AREA_NAME','AREA_NAME',$TRANSFER_PAST_AREA);?>
                  </select></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Present Area</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="TRANSFER_PRESENT_AREA">
                    <? foreign_relation('area','AREA_NAME','AREA_NAME',$TRANSFER_PRESENT_AREA);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Past Branch :</td>
                  <td width="20%" class="oe_form_group_cell"><select name="TRANSFER_PAST_BRANCH">
                    <? foreign_relation('branch','BRANCH_NAME','BRANCH_NAME',$TRANSFER_PAST_BRANCH);?>
                  </select></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Present Branch :</span></td>
                  <td class="oe_form_group_cell"><select name="TRANSFER_PRESENT_BRANCH">
                    <? foreign_relation('branch','BRANCH_NAME','BRANCH_NAME',$TRANSFER_PRESENT_BRANCH);?>
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
