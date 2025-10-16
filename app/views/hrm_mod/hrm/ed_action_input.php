<?php
session_start();

require "../../config/inc.all.php";

// ::::: Edit This Section ::::: 
$title='ED Active Management';			// Page Name and Page Title
$page="ed_action.php";		// PHP File Name
$input_page="ed_action_input.php";
$root='hrm';

$table='ed_action_detail';		// Database Table Name Mainly related to this page
$unique='ED_ACTION_DID';			// Primary Key of this Database table
$shown='ED_ACTION_FROM';				// For a New or Edit Data a must have data field

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
<? do_calander('#ED_ACTION_CIRCULAR_DATE');?>
<? do_calander('#ED_ACTION_DATE');?>
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
            <td colspan="1" class="oe_form_group_cell" width="50%"><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" width="41%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Action From :</td>
                  <td bgcolor="#E8E8E8" width="59%" colspan="1" class="oe_form_group_cell">
                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                    <input name="ED_ACTION_FROM" type="text" id="ED_ACTION_FROM" value="<?=$ED_ACTION_FROM?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;Action No :</label></td>
                  <td colspan="1" class="oe_form_group_cell"><input name="ED_ACTION_NO" type="text" id="ED_ACTION_NO" value="<?=$ED_ACTION_NO?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Action Regrister No :</td>
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell"><input name="ED_ACTION_REGISTER_NO" type="text" id="ED_ACTION_REGISTER_NO" value="<?=$ED_ACTION_REGISTER_NO?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Action Date :</td>
                  <td colspan="1" class="oe_form_group_cell"><input name="ED_ACTION_DATE" type="text" id="ED_ACTION_DATE" value="<?=$ED_ACTION_DATE?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Action Memo No:</td>
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell"><input name="ED_ACTION_MEMO_NO" type="text" id="ED_ACTION_MEMO_NO" value="<?=$ED_ACTION_MEMO_NO?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Action Circulation Date :</td>
                  <td colspan="1" class="oe_form_group_cell"><input name="ED_ACTION_CIRCULAR_DATE" type="text" id="ED_ACTION_CIRCULAR_DATE" value="<?=$ED_ACTION_CIRCULAR_DATE?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Action Circulation By :</td>
                   <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell">
<select name="ED_ACTION_CIRCULAR_BY">
<option selected><?=$ED_ACTION_CIRCULAR_BY?></option>
<option>AD(ES)
</option><option>D(Admin)
</option><option>ZC(Admin)
</option><option>DD(Admin)
</option><option>ED
</option><option>JD(Admin)
</option><option>SZM(ES)HQ
</option><option>PS to ED (L)
</option><option>Ps to ED(L)
</option><option>D(AMIS)
</option><option>DD(P&M)
</option><option>DD(PMD)
</option><option>SPC(Ad.)DLO
</option><option>ZM(SS),DLO
</option><option>D(AIMS)
</option><option>EO(TMSS)
</option><option>D(HRDM)
</option><option>ED(TMSS)
</option><option>PS to ED(C&F)
</option><option>ZM(Rajshahi Zone)
</option><option>D(ES)
</option><option>ED, TMSS
</option><option>BM(IA)
</option><option>AD(ES)FO
</option><option>BM(Damkura Hat Branch)
</option><option>Advisor(PMD)
</option><option>AD(ML)
</option><option>N/I
</option><option>ZM(Admin)
</option><option>AD (ES),FO</option></select></td>
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
