<?php

 

 

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
?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}</script>

<form action="" method="post">
<div class="oe_view_manager oe_view_manager_current">
        
    <? include('../../common/title_bar.php');?>
        <div class="oe_view_manager_body">
            
                <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
    <? include('../../common/report_bar.php');?>
<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
            <table style="width:757px" height="66" border="0" class="oe_form_group ">
                <th></th>
              <tbody>
                <tr class="oe_form_group_row">
                  <td style="padding-left:10px; width:20%; background-color:#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Ticket No:</td>
                  <td style="background-color:#E8E8E8; width:77%" class="oe_form_group_cell oe_form_group_cell_label"><input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="text" readonly="readonly"/></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td style="padding-left:10px; background-color:#fff" class="oe_form_group_cell oe_form_group_cell_label">Location:</td>
                  <td style="background-color:#fff" class="oe_form_group_cell oe_form_group_cell_label"><select name="location">
                      <? foreign_relation('warehouse','warehouse_id','warehouse_name',$location);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td style="padding-left:10px; background-color:#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Module Info:</td>
                  <td style="background-color:#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><select name="module">
                      <? foreign_relation('mis_module_info','id','module_name',$module);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td style="padding-left:10px; background-color:#fff" class="oe_form_group_cell oe_form_group_cell_label">Task type:</td>
                  <td style="background-color:#fff" class="oe_form_group_cell oe_form_group_cell_label"><select name="task_type">
                      <? foreign_relation('mis_task_type','id','task_type',$task_type);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td style="padding-left:10px; background-color:#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Task Priority:</td>
                  <td style="background-color:#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><select name="task_priority">
                      <option>
                      <?=$task_priority?>
                      </option>
                      <? foreign_relation('mis_task_priority','id','priority',$task_priority);?>
                    </select>
                  </td>
                </tr>
                <tr class="oe_form_group_row">
                  <td style="padding-left:10px; background-color:#fff" class="oe_form_group_cell oe_form_group_cell_label">Attached File:</td>
                  <td style="background-color:#fff" class="oe_form_group_cell oe_form_group_cell_label"><input name="attached_file" type="file" id="attached_file" value="upload" style="height:auto; width:213px" />
                  </td>
                </tr>
                <tr class="oe_form_group_row">
                  <td style="padding-left:10px; background-color:#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Task Details:</td>
                  <td style="background-color:#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><textarea name="task_details" id="task_details" style="height:170px; width:480px"><?=$task_details?>
            </textarea>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          </div>
          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
            
        </div>
    </div>
</form>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>