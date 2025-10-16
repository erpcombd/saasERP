<?php
session_start();

require "../../config/inc.all.php";

// ::::: Edit This Section ::::: 
$title='Guardian Management';			// Page Name and Page Title
$page="guardian.php";		// PHP File Name
$input_page="guardian_input.php";
$root='hrm';

$table='guardian';		// Database Table Name Mainly related to this page
$unique='GUARDIAN_ID';			// Primary Key of this Database table
$shown='GUARDIAN_NAME';				// For a New or Edit Data a must have data field

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
$path='../../pic/gardian';
$_POST['pic']=image_upload($path,$_FILES['pic']);
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
$path='../../pic/gardian';
$_POST['pic']=image_upload($path,$_FILES['pic']);
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';

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
       <td colspan="1" class="oe_form_group_cell" width="100%"><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody>
          <tr class="oe_form_group_row">
           <td bgcolor="#E8E8E8" width="23%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Guardian Name :</td>
                 <td bgcolor="#E8E8E8" width="38%" colspan="1" class="oe_form_group_cell">
                 <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                 <input name="GUARDIAN_NAME" type="text" id="GUARDIAN_NAME" value="<?=$GUARDIAN_NAME?>" /></td>
                 <td width="39%" rowspan="6" align="center" bgcolor="#E8E8E8" class="oe_form_group_cell"><img src="../../pic/gardian/<?=$_SESSION['employee_selected']?>.jpg" width="105" height="90" border="1" align="middle" />&nbsp;</td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;Relation :</label></td>
                  <td class="oe_form_group_cell"><select name="GUARDIAN_RELATION">
                    <? foreign_relation('relation','RELATION_NAME','RELATION_NAME',$GUARDIAN_RELATION);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; National ID# :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="GUARDIAN_NID" type="text" id="GUARDIAN_NID" value="<?=$GUARDIAN_NID?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Profession :</td>
                  <td class="oe_form_group_cell"><select name="GUARDIAN_PROFESSION" id="GUARDIAN_PROFESSION">
                   <? foreign_relation('profession','profession_name','profession_name',$GUARDIAN_PROFESSION);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Working Location :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="GUARDIAN_WORKING_LOCATION" type="text" id="GUARDIAN_WORKING_LOCATION" value="<?=$GUARDIAN_WORKING_LOCATION?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Present Address :</td>
                  <td class="oe_form_group_cell"><input name="GUARDIAN_PRESENT_ADDRESS" type="text" id="GUARDIAN_PRESENT_ADDRESS" value="<?=$GUARDIAN_PRESENT_ADDRESS?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Permanent Address :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="GUARDIAN_PERMANENT_ADDRESS" type="text" id="GUARDIAN_PERMANENT_ADDRESS" value="<?=$GUARDIAN_PERMANENT_ADDRESS?>" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; E-mail :</td>
                  <td class="oe_form_group_cell"><input name="GUARDIAN_EMAIL" type="text" id="GUARDIAN_EMAIL" value="<?=$GUARDIAN_EMAIL?>" /></td>
                  <td class="oe_form_group_cell">&nbsp;</td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Phone # :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="GUARDIAN_PHONE" type="text" id="GUARDIAN_PHONE" value="<?=$GUARDIAN_PHONE?>" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Fax# :</td>
                  <td class="oe_form_group_cell"><input name="GUARDIAN_FAX" type="text" id="GUARDIAN_FAX" value="<?=$GUARDIAN_FAX?>" /></td>
                  <td class="oe_form_group_cell">&nbsp;</td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Mobile :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="GUARDIAN_MOBILE" type="text" id="GUARDIAN_MOBILE" value="<?=$GUARDIAN_MOBILE?>" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Gardian Picture :</td>
                  <td bgcolor="#E8E8E8"colspan="2" class="oe_form_group_cell"><input name="pic" id="pic" type="file"></td>
                </tr>
                </tbody></table></td>
            <td colspan="1" class="oe_form_group_cell oe_group_right" width="1%">&nbsp;</td>
          </tr></tbody></table></div>
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
