<?php
session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Start Edit Section ::::: 
$title='Task Information';			// Page Name and Page Title
$page="task_assign.php";			// PHP File Name
$input_page="task_assign_input.php";
$root='mis';

$table='mis_task';					// Database Table Name Mainly related to this page
$unique='id';						// Primary Key of this Database table
$shown='task_details';				// For a New or Edit Data a must have data field

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
                      <? include('../../common/input_bar.php');?>
                      <div class="oe_form_sheetbg">
                        <div class="oe_form_sheet oe_form_sheet_width">
        <h1><label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right">
        <a href="home2.php" rel = "gb_page_center[940, 600]"><?=$title?></a>
    </label>
        </h1>
        <table class="oe_form_group " border="0" cellpadding="0" cellspacing="0">
            <tbody>
                <tr class="oe_form_group_row">
            <td width="552" class="oe_form_group_cell"><table width="757" height="66" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
              <tbody>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" width="20%" style="padding-left:10px" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Ticket No:</td>
                  <td bgcolor="#E8E8E8" width="77%" class="oe_form_group_cell oe_form_group_cell_label"><input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="text" readonly="readonly"/></td>
                
                  </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" style="padding-left:10px" class="oe_form_group_cell oe_form_group_cell_label">Location:</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><select name="location">
                      <option>
                      <?=$location?>
                      </option>
                      <? foreign_relation('warehouse','warehouse_id','warehouse_name',$location);?>
                  </select></td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" style="padding-left:10px" class="oe_form_group_cell oe_form_group_cell_label">Module Info:</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><select name="module">
                      <option>
                      <?=$module_name?>
                      </option>
                      <? foreign_relation('mis_module_info','id','module_name',$module_name);?>
                  </select></td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8"  style="padding-left:10px" class="oe_form_group_cell oe_form_group_cell_label">Task type:</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><select name="task_type">
                      <option>
                      <?=$task_type?>
                      </option>
                      <? foreign_relation('mis_task_type','id','task_type',$task_type);?>
                  </select></td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" style="padding-left:10px" class="oe_form_group_cell oe_form_group_cell_label">Task Priority:</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">
				  <select name="task_priority">
                      <option>
                      <?=$task_priority?>
                      </option>
                      <? foreign_relation('mis_task_priority','id','priority',$task_priority);?>
                  </select>
				  </td>
				  </tr>
                  
                  
				  <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" style="padding-left:10px" class="oe_form_group_cell oe_form_group_cell_label">Attached File:</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">
				 <input name="upload" type="file" value="upload" style="height:auto; width:213px">
				  </td>
				  </tr>
                
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" style="padding-left:10px" class="oe_form_group_cell oe_form_group_cell_label">Task Details:</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">
				  <textarea name="task_details" id="task_details" style="height:170px; width:480px"><?=$task_details?></textarea>
				  </td>
				  </tr>
				  
				  
              </tbody>
            </table>
            </td>
            </tr>
            </tbody>
        </table>
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
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
