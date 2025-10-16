<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Progress Entry';			// Page Name and Page Title
$page="daily_task.php";		// PHP File Name
$input_page="daily_task_input.php";
$root='attendence';

$table='daily_progress';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='task';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::

do_calander("#request_date");
do_calander("#complete_date");

create_combobox("module_id");

$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert'])||isset($_POST['insertn']))
{		
$now				= time();
$_POST['entry_by']=$_SESSION['employee_selected'];
$_POST['entry_at']=date('Y-m-d H:i:s');
$_POST['entry_date']=date('Y-m-d');
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
foreach ($data as $key => $value)
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
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
        <a href="home2.php" rel = "gb_page_center[940, 600]"></a>
    </label>
          </h1><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row">
            <td class="oe_form_group_cell"><table width="274" height="156" border="0" cellpadding="0" cellspacing="0" class="oe_form_group "><tbody>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" width="19%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Project:</td>
                  <td bgcolor="#E8E8E8" width="29%" class="oe_form_group_cell">
					<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                    <select name="project" id="project" class="selectpicker" data-show-subtext="true" data-live-search="true" required>
					<option></option>
                    <? foreign_relation('project','PROJECT_ID','PROJECT_NAME',$project);?>
                     
                    </select></td>
                  <td bgcolor="#E8E8E8" width="15%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</span></td>
                  <td bgcolor="#E8E8E8" width="37%" class="oe_form_group_cell">&nbsp;</td>
                </tr>
				<tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" width="19%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Module:</td>
                  <td bgcolor="#E8E8E8" width="29%" class="oe_form_group_cell">
					<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                    <select name="module_id" id="module_id" class="selectpicker" data-show-subtext="true" data-live-search="true" required>
					<option></option>
                    <? foreign_relation('user_module_manage','id','module_name',$module_id);?>
                     
                    </select></td>
                  <td bgcolor="#E8E8E8" width="15%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Feature :</span></td>
                  <td bgcolor="#E8E8E8" width="37%" class="oe_form_group_cell"><input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                    <select name="feature_id" id="feature_id" class="selectpicker" data-show-subtext="true" data-live-search="true">
					<option></option>
                    <? foreign_relation('user_feature_manage','id','feature_name',$feature_id);?>
                     
                    </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;Task :</label></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input type="text" name="task" id="task" value="<?=$task?>" style="width:95%; height:40px;" required></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Request From :</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input type="text" name="request_by" value="<?=$request_by?>" style="width:74%; height:40px;" required></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Status :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">
                  <select name="status" style="width:95%; height:40px;">
                    <option></option>
					<option <?=($status=='PENDING')?'selected':''?>>PENDING</option>
					<option <?=($status=='PROCESSING')?'selected':''?>>PROCESSING</option>
					<option <?=($status=='DONE')?'selected':''?>>DONE</option>
					<option <?=($status=='CANCEL')?'selected':''?>>CANCEL</option>
                  </select>
                  </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Request Date :</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="request_date" type="date" id="request_date" value="<?=$request_date?>" required /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Remarks :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="remarks" type="text" id="remarks" value="<?=$remarks?>" style="width:95%; height:40px;" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Complete Date :</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="complete_date" type="date" id="complete_date" value="<?=$complete_date?>" /></td>
                </tr>
                
                
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="4" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
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
