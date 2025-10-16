<?php
//


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Kpi Set';			// Page Name and Page Title
$page="kpi_set.php";		// PHP File Name
$input_page="kpi_set_input.php";
$root='setup';

$table='hrm_kpi_set';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='PBI_ID';	
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

<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
	
  <style>
    .li a{
	  color:#FFFFFF;
	}
  </style>
<html style="height: 100%;"><head>
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <meta content="text/html; charset=UTF-8" http-equiv="content-type">
        <link href="../../css/css.css" rel="stylesheet"></head>
<body>
        <!--[if lte IE 8]>
        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>
        <script>CFInstall.check({mode: "overlay"});</script>
        <![endif]-->
       <form action="" method="post"> <div class="ui-dialog ui-widget ui-widget-content ui-corner-all oe_act_window ui-draggable ui-resizable openerp" style="outline: 0px none; z-index: 1002; position: absolute; height: auto; width: 900px; display: block; /* [disabled]left: 217.5px; */ left: 16px; top: 21px;" tabindex="-1" role="dialog" aria-labelledby="ui-id-19">
          <? include('../../common/title_bar_popup.php');?>
      <div style="display: block; max-height: 464px; overflow-y: auto; width: auto; min-height: 82px; height: auto;" class="ui-dialog-content ui-widget-content" scrolltop="0" scrollleft="0">

            <div style="width:100%" class="oe_popup_form">
              <div class="oe_formview oe_view oe_form_editable" style="opacity: 1;">
                <div class="oe_form_buttons"></div>
                <div class="oe_form_sidebar" style="display: none;"></div>
                <div class="oe_form_container">
                  <div class="oe_form">
                    <div class="">
                      <? include('../../common/input_bar_setup.php');?>
                      <div class="oe_form_sheetbg">
                        <div class="oe_form_sheet oe_form_sheet_width">
        <h1><label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right">
        <a href="home2.php" rel = "gb_page_center[940, 600]"><?=$title?></a>
    </label>
          </h1><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row">
            <td class="oe_form_group_cell"><table width="261" height="66" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
              <tbody>
                <tr class="oe_form_group_row">
   <td bgcolor="#E8E8E8" width="18%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;KPI For :</td>
                  <td bgcolor="#E8E8E8" width="82%" class="oe_form_group_cell oe_form_group_cell_label">
                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
				  <input name="entry_by" id="entry_by" value="<?=$_SESSION['employee_selected']?>" type="hidden" />
                 
                 <select name="PBI_ID" id="PBI_ID" class="selectpicker" data-show-subtext="true" data-live-search="true">
				  <? foreign_relation('personnel_basic_info','PBI_ID','concat(PBI_NAME," (", PBI_ID,") ")',$PBI_ID,'PBI_JOB_STATUS="In Service"')?>
				 </select>
				  </td>
                </tr><tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" width="18%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;KPI Authority :</td>
                  <td bgcolor="#E8E8E8" width="82%" class="oe_form_group_cell oe_form_group_cell_label">
                  <select name="LINE_MANAGER" id="LINE_MANAGER" class="selectpicker" data-show-subtext="true" data-live-search="true">
				  <? foreign_relation('personnel_basic_info','PBI_ID','concat(PBI_NAME," (", PBI_ID,") ")',$LINE_MANAGER,'PBI_JOB_STATUS="In Service"')?>
				 </select>
				  </td>
                </tr>
				
				<tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" width="18%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Department Head :</td>
                  <td bgcolor="#E8E8E8" width="82%" class="oe_form_group_cell oe_form_group_cell_label">
                 <select name="DEPT_HEAD" id="DEPT_HEAD" class="selectpicker" data-show-subtext="true" data-live-search="true">
				  <? foreign_relation('personnel_basic_info','PBI_ID','concat(PBI_NAME," (", PBI_ID,") ")',$DEPT_HEAD,'PBI_JOB_STATUS="In Service"')?>
				 </select>
				  </td>
                </tr>
				
				<tr class="oe_form_group_row">
   <td bgcolor="#E8E8E8" width="18%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Status :</td>
                  <td bgcolor="#E8E8E8" width="82%" class="oe_form_group_cell oe_form_group_cell_label">
                 
                  
                  <select name="status" id="status">
				  <option><?=$status?></option>
				   <option>Active</option>
				    <option>Deactive</option>
				 </select>
				  </td>
                </tr>
				<tr class="oe_form_group_row">
                  <td height="33" colspan="2" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
