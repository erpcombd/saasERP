<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Start Edit Section ::::: 
$title='Task Asssign Input';			// Page Name and Page Title
$page="task_assign.php";			// PHP File Name
$input_page="task_assign_new.php";
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
$path='pic';
if($_FILES['attached_file']['name']!='')
$_POST['attached_file']=image_upload_on_id($path,$_FILES['attached_file'],$_SESSION['employee_selected']);		
$now= time();
$crud->insert();
$type=1;
$msg='New Entry Successfully Inserted.';
if(isset($_POST['insert']))

unset($_POST);
unset($$unique);
}
//for Modify..................................
if(isset($_POST['update']))
{
        $_REQUEST['solve_date']=date('Y-m-d H:i:s');
		$_REQUEST['solved_by']=$_SESSION['user']['id'];
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
<script language="javascript">
function DoNav(theUrl)
{
	window.open('<?=$target_url?>?<?=$unique?>='+theUrl);
}
</script>

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
    <? include('../../common/input_bar.php');?>
<div class="oe_form_sheetbg">
                        <div class="oe_form_sheet oe_form_sheet_width">
        <h1><label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right">
        <a href="home2.php" rel = "gb_page_center[940, 600]"><?=$title?></a>
    </label>
        </h1>
        <table class="oe_form_group " border="0">
            <th></th>
            <tbody>
                <tr class="oe_form_group_row">
            <td style="width:552px" class="oe_form_group_cell"><table style="width:757px" height="66" border="0" class="oe_form_group ">
              <tbody>
                <tr class="oe_form_group_row">
                  <td style="padding-left:10px; background-color:#E8E8E8; width: 20%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Ticket No:</td>
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
                  <td style="background-color:#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">
				  <select name="task_priority">
                      <option>
                      <?=$task_priority?>
                      </option>
                      <? foreign_relation('mis_task_priority','id','priority',$task_priority);?>
                  </select>				  </td>
				  </tr>
                  
                  
				  <tr class="oe_form_group_row">
                  <td style="padding-left:10px; background-color:#fff" class="oe_form_group_cell oe_form_group_cell_label">Attached File:</td>
                  <td style="background-color:#fff" class="oe_form_group_cell oe_form_group_cell_label">
				 <input name="attached_file" type="file" id="attached_file" value="upload" style="height:auto; width:213px">				  </td>
				  </tr>
				  <tr class="oe_form_group_row">
                    <td style="padding-left:10px; background-color:#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Task Details:</td>
				    <td style="background-color:#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><textarea name="task_details" id="task_details" style="height:100px; width:600px"><?=$task_details?>
                  </textarea>                    </td>
				    </tr>
                <?if($_GET['id']>0){?>
                  <tr class="oe_form_group_row">
                    <td colspan="2" style="background-color:green" class="oe_form_group_cell oe_form_group_cell_label" style="padding-left:10px">&nbsp;</td>
                  </tr>
                  
                  <tr class="oe_form_group_row">
                    <td style="padding-left:10px; background-color:#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Task Status:</td>
                    <td style="background-color:#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">
					
					
					<select name="task_status">
                        <option>Select Status</option>
						<option>Pending</option>
						<option>Processing</option>
						<option>Complete</option>
						<option>Cancel</option>
                    </select>					</td>
                  </tr>
                  <tr class="oe_form_group_row">
                    <td style="padding-left:10px; background-color:#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                    <td style="background-color:#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  </tr>
				  <?}?>
                  <tr class="oe_form_group_row">
                    <td style="padding-left:10px; background-color:#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                    <td style="background-color:#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  </tr>
              </tbody>
            </table>
            </td>
            </tr>
            </tbody>
        </table>
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