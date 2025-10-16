<?php
//


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Nominee Management';			// Page Name and Page Title
$page="nominee.php";		// PHP File Name
$input_page="nominee_input.php";
$root='hrm';

$table='nominee_detail';		// Database Table Name Mainly related to this page
$unique='NOMINEE_DETAIL_ID';			// Primary Key of this Database table
$shown='NOMINEE_NAME';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert'])||isset($_POST['insertn']))
{		
$now				= time();
$crud->insert();
$path='../../pic/nominnee';
$id=(db_last_insert_id($table,$unique)-1);
$_POST['pic']=image_upload($path,$_FILES['pic'],$id);
$_REQUEST['PBI_ID']=$_SESSION['employee_selected'];

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
$path='../../pic/nominnee';
$_POST['pic']=image_upload($path,$_FILES['pic'],$$unique);
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
            <td class="oe_form_group_cell"><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" width="21%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Name:</td>
                  <td bgcolor="#E8E8E8" width="29%" colspan="1" class="oe_form_group_cell">
                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                  <input name="PBI_ID" type="hidden" id="PBI_ID" value="<?=$_SESSION['employee_selected']?>" />
                    <input name="NOMINEE_NAME" type="text" id="NOMINEE_NAME" value="<?=$NOMINEE_NAME?>" /></td>
                  <td bgcolor="#E8E8E8" width="12%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Percent :</span></td>
                  <td bgcolor="#E8E8E8" width="38%" class="oe_form_group_cell"><input name="NOMINEE_PERCENT" type="text" id="NOMINEE_PERCENT" value="<?=$NOMINEE_PERCENT?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>Relation :</label></td>
                  <td class="oe_form_group_cell"><select name="NOMINEE_RELATION">
                    <? foreign_relation('relation','RELATION_NAME','RELATION_NAME',$NOMINEE_RELATION);?>
                  </select></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Phone :</span></td>
                  <td class="oe_form_group_cell"><input name="NOMINEE_PHONE" type="text" id="NOMINEE_PHONE" value="<?=$NOMINEE_PHONE?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Address :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="NOMINEE_ADDRESS" type="text" id="NOMINEE_ADDRESS" value="<?=$NOMINEE_ADDRESS?>" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Mobile :</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="NOMINEE_MOBILE" type="text" id="NOMINEE_MOBILE" value="<?=$NOMINEE_MOBILE?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Voter ID :</td>
                  <td colspan="1" class="oe_form_group_cell"><input name="NOMINEE_VOTER_ID" type="text" id="NOMINEE_VOTER_ID" value="<?=$NOMINEE_VOTER_ID?>" /></td>
                  <td colspan="2" rowspan="2" align="center" class="oe_form_group_cell oe_form_group_cell_label"><img src="../../pic/nominnee/<?=$$unique?>.jpg" width="105" height="90" border="1" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Nominee Picture :</td>
                  <td colspan="1" class="oe_form_group_cell"><input name="pic" type="file" id="pic" /></td>
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
