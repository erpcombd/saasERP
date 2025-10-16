<?php

//

//

require "../../config/inc.all.php";

$head = '<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';

do_calander('#task_date');
do_calander('#pi_revise_date');

// ::::: Edit This Section ::::: 

$title = 'Task Details Update';   // Page Name and Page Title

$page = "add_details_task.php";  // PHP File Name

$input_page = "add_details_task_input.php";

$root = 'daily_task';



$table = 'daily_give_task_details';  // Database Table Name Mainly related to this page

$unique = 'id';   // Primary Key of this Database table

$shown = 'project_id';    // For a New or Edit Data a must have data field
$to_date = date('Y-m-d');

// ::::: End Edit Section :::::

$crud = new crud($table);



if ($_GET['first_task'] > 0)

    unset($_SESSION['task_id']);

elseif ($_REQUEST['untask_id'] > 0)

    $task_id = $_SESSION['task_id'] = $_REQUEST['untask_id'];


elseif ($_POST['task_id'] > 0)

    $task_id= $_POST['task_id'];






if (isset($_POST['new'])) {

    $_REQUEST['entry_at'] = date('Y-m-d H:s:i');
	$_REQUEST['PBI_ID'] = $_SESSION['employee_selected'];
	
    if (!isset($_SESSION['task_id'])) {

        //unset($$unique);
$crud->insert();


$file_name = $_FILES['task_img_1']['name'];
$temp_name = $_FILES['task_img_1']['tmp_name'];
$target = 'file1/'.$task_id.'.jpg';
move_uploaded_file($temp_name, $target);


$file_name = $_FILES['task_img_2']['name'];
$temp_name = $_FILES['task_img_2']['tmp_name'];
$target = 'file2/'.$task_id.'.jpg';
move_uploaded_file($temp_name, $target);


$file_name = $_FILES['task_img_3']['name'];
$temp_name = $_FILES['task_img_3']['tmp_name'];
$target = 'file3/'.$task_id.'.jpg';
move_uploaded_file($temp_name, $target);





$sql = 'select max(task_id) from daily_give_task_details'; $val = mysqli_fetch_row(db_query($sql));
       $$unique = $task_id = $_SESSION['task_id'] =$_POST['task_id'] = $val[0];

        //unset($$unique);

        $type = 1;

        $msg = '<span style="color:green; font-weight:bold; font-size:15px;">Task Status Initialized. (Task ID-' . $task_id . ')</span>';

    } else {
         $_REQUEST['status']=$_POST['status'];
        $crud->update($unique);

        $type = 1;

        $msg = '<span style="color:green; font-weight:bold; font-size:15px;">Successfully Updated.</span>';

    }

    $_SESSION['buyer_id'] = $_POST['buyer_id'];

}

$task_id = $_SESSION['task_id'];





if (isset($_POST['confirm'])) {

    unset($_POST);

    $_POST['task_id'] = $task_id;

    $_POST['prepared_at'] = date('Y-m-d h:s:i');
	$master_id=find_a_field('daily_give_task_details','task_id','1 and id='.$task_id);
	$st=find_a_field('daily_give_task_details','count(id)','status not like "COMPLETED" and id='.$task_id);
	if($st>0){ 
	}else{ 
	 $up="update daily_give_task_master set status='COMPLETED' where task_id=".$master_id;
	db_query($up);
	}

    //$_REQUEST['status'] = 'PENDING';

    $crud = new crud('daily_give_task_details');

    $crud->update('id');

    unset($task_id);

    unset($_SESSION['task_id']);

    $type = 1;

    $msg = '<span style="color:green; font-weight:bold; font-size:15px;">Successfully Submitted.</span>';
   header('Location:https://newsofbd.com/CloudERP/user_mod/pages/inventory/home.php');
}

if (isset($_POST['delete'])) {

    $crud = new crud('daily_give_task_details');

    $condition = "task_id=" . $task_id;

    $crud->delete($condition);

    $crud = new crud('daily_task_details');

    $condition = "task_id=" . $task_id;

    $crud->delete_all($condition);

    unset($task_id);

    unset($_SESSION['task_id']);

    $type = 1;

    $msg = '<span style="color:green; font-weight:bold; font-size:15px;">Successfully Deleted.</span>';

}



if ($task_id > 0) {

    $condition = $unique . "=" . $task_id;

    $data = db_fetch_object($table, $condition);

    while (list($key, $value) = each($data)) {

        $$key = $value;

    }

}

?>
<style>
.oe_list_content {
    width: 100% !important;
    padding: 0 !important;
    overflow: auto !important;
    margin: 0px auto 1px auto !important;
    background-color: #ffffff !important;
    text-align: left !important;
	cursor:pointer !important;
}
.oe_list_content tr {
    color: #4f6b72;
	background-color: beige;
}

</style>
<script type = "text/javascript">var GB_ROOT_DIR = "../../GBox/";</script>
<script type = "text/javascript" src = "../../GBox/AJS.js"></script>
<script type = "text/javascript" src = "../../GBox/AJS_fx.js"></script>
<script type = "text/javascript" src = "../../GBox/gb_scripts.js"></script>
<link href = "../../GBox/gb_styles.css" rel = "stylesheet" type = "text/css" media = "all"/>

<script type="text/javascript">

    function DoNav(lk) {

        return GB_show('ggg', '../pages/<?=$root;?>/<?=$input_page;?>?id=' + lk, 600, 940)

    }





</script>
<script type="text/javascript">

    function confirmation()

    {

        var answer = confirm("Are you sure?")

        if (answer)

        {

            return true;

        } else {

            if (window.event) // True with IE, false with other browsers

            {

                window.event.returnValue = false; //IE specific

            } else {

                return false

            }

        }

    }

function count()
{
var num=((document.getElementById('bus_exp').value)*1)+((document.getElementById('rickshaw').value)*1)+((document.getElementById('lunch').value)*1)+((document.getElementById('other').value)*1);

document.getElementById('total').value = num.toFixed(0);	
}

</script>

<form action="add_details_task.php" method="post" enctype="multipart/form-data" autocomplete="off">
  <div class="oe_view_manager oe_view_manager_current">
    <? //include('../../common/title/title_bar_lc.php');?>
    <div class="oe_view_manager_body">
      <div  class="oe_view_manager_view_list"></div>
      <div class="oe_view_manager_view_form">
        <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
          <div class="oe_form_buttons"></div>
          <div class="oe_form_sidebar"></div>
          <div class="oe_form_pager"></div>
          <div class="oe_form_container">
            <div class="oe_form">
              <div class="">
                <?php /* ?>    <? include('../../common/report_bar.php');?><?php */ ?>
                <div class="oe_form_sheetbg">
                  <div class="oe_form_sheet oe_form_sheet_width">
                    <div  class="oe_view_manager_view_list">
                      <div  class="oe_list oe_view">
                        <table class="table table-bordered"  >
                          <tbody>
                            <tr class="oe_form_group_row">
                              <td class="oe_form_group_cell"><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0" style="width: 100% !important;background-color:aliceblue;"><div align="center"><?=$msg?></div>
                                  <tbody>
                                    <tr class="oe_form_group_row" style="margin-top:10px;">
                                      <td width="24%" colspan="1"class="oe_form_group_cell" style="padding-top:5px; text-align:right; vertical-align:middle;">&nbsp;Task ID : </td>
                                      <td width="29%"class="oe_form_group_cell" style="padding-top:5px;">
									  <span class="oe_form_group_cell" style="padding-top:5px; width: 170px;">
                                        <?

if($_SESSION['task_id']>0) $task_id =  $_SESSION['task_id']; 

else 

{$task_id =  find_a_field('daily_give_task_details','max(task_id)+1','1');

if($task_id<1) $task_id = 1;

}

?>
                                        </span>
										
                                        <input  name="id" style="height: 30px;" type="text" id="id" value="<?=$task_id ?>" readonly="readonly"/>
                                        </center>                                      </td>
                                      <td width="24%" class="oe_form_group_cell" style="padding-top:5px; vertical-align:middle; text-align:right;"><span class="oe_form_group_cell oe_form_group_cell_label">Task Name :</span></td>
                                      <td width="29%" class="oe_form_group_cell">
									  <textarea  style="height: 54px; margin-top: 0px; margin-bottom: 0px;" name="task_name1" type="text" id="task_name1" required readonly="" value="<?=$task_name=find_a_field('daily_give_task_details','task_name','id='.$task_id);?>"><?=$task_name;?></textarea>									  </td>
                                    </tr>
									
									
									<tr class="oe_form_group_row" style="margin-top:10px;">
                                      <td width="24%" colspan="1"class="oe_form_group_cell" style="padding-top:5px; text-align:right; vertical-align:middle;">&nbsp;Task Status : </td>
                                      <td width="29%"class="oe_form_group_cell" style="padding-top:5px;"><select name="status" id="status" style="width:100px;" >
                                      <option value="PENDING" <? if($status=='PENDING') echo "selected";?>>PENDING</option>
									  <option value="ONGOING" <? if($status=='ONGOING') echo "selected";?>>ONGOING</option>
									  <option value="COMPLETED" <? if($status=='COMPLETED') echo "selected";?>>COMPLETED</option>
                                    </select></td>
                                      <td width="24%" class="oe_form_group_cell" style="padding-top:5px; vertical-align:middle; text-align:right;"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</span></td>
                                      <td width="29%" class="oe_form_group_cell">&nbsp;</td>
                                    </tr>
									
									<tr class="oe_form_group_row" style="margin-top:10px;">
                                      
                                      <td colspan="4" align="center" class="oe_form_group_cell"><? $btn_name = 'Update';?>
<input name="new" type="submit" class="btn1" value="<?=$btn_name ?>" style="width:120px; height: 35px; background: #2AC337; font-weight:bold; font-size:16px; margin-bottom:5px; color:white;" />
</td>
                                    </tr>
                                  </tbody>
                                </table>
                                <p>&nbsp;</p></td>
                            </tr>
                          </tbody>
                        </table>
                        <? if($_SESSION['task_id']>0){?>
                        <? include('../../common/title/report_bar_proforma.php');?>
                        <?php
			
			 $res = 'select d.id, d.id, d.task_id,(select MODUL_NAME FROM project_modul where MODUL_ID=d.module_id ) as MODUL_NAME, d.task_name, d.task_desc as description from given_task_details d where d.task_id='.$_SESSION['task_id'];
			
			//echo $res;
			
			echo $crud->link_report($res, $link);
			
			?>
			
                        <? } ?>
                      </div>
                    </div>
                  </div>
                </div>
				<input name="confirm" type="submit" class="btn1" value="CONFIRM" style="width:100px; font-weight:bold; font-size:12px; background-color:#99FF99" />
                <div class="oe_chatter">
                  <div class="oe_followers oe_form_invisible">
                    <div class="oe_follower_list"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script>
  $( function() {
    $( "#task_date" ).datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat:"yy-mm-dd"
    });
  } );
$(document).ready(function(){
    $('#in_time').timepicker({});
$('#out_time').timepicker({});
});
  </script>

<?

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>
