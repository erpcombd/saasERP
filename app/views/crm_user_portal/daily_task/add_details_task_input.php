<?php

//

//

require "../../config/inc.all.php";

$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';

do_calander('#pi_issue_date');

// ::::: Edit This Section ::::: 

$title = 'Give Daily Task to Employee';   // Page Name and Page Title

$page = "add_details_task.php";  // PHP File Name

$input_page = "add__details_task_input.php";

$root='daily_task';



$table='daily_give_task_master';		// Database Table Name Mainly related to this page

$table_deatils = 'given_task_details';	

$unique='id';			// Primary Key of this Database table

$shown='task_id';				// For a New or Edit Data a must have data field



// ::::: End Edit Section :::::



$task_id = $_SESSION['task_id'];  



$crud      =new crud($table_deatils);



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

 echo '<script type="text/javascript">  parent.parent.document.location.href = "../'.$root.'/'.$page.'";  </script>';

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

{		$condition=$unique."=".$$unique;			$crud->delete($condition);

  //   echo $condition;

		unset($$unique);

		echo '<script type="text/javascript"> parent.parent.document.location.href = "../'.$root.'/'.$page.'";  </script>';   

		$type=1;

		$msg='Successfully Deleted.';

}

}



if(isset($$unique))

{

$condition=$unique."=".$$unique;



$data=db_fetch_object($table_deatils,$condition);



foreach ($data as $key => $value)

{ $$key=$value;}

}

?>
<html style="height: 100%;">
<head>
<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
<meta content="text/html; charset=UTF-8" http-equiv="content-type">
<link href="../../css/css.css" rel="stylesheet">
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.datepicker.js"></script>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data" name="cloud" id="cloud">
  <div class="ui-dialog ui-widget ui-widget-content ui-corner-all oe_act_window ui-draggable ui-resizable openerp" style="outline: 0px none; z-index: 1002; position: absolute; height: auto; width: 900px; display: block; /* [disabled]left: 217.5px; */" tabindex="-1" role="dialog" aria-labelledby="ui-id-19">
    <? include('../../common/title/title_bar_popup.php');?>
    <div style="display: block; max-height: 464px; overflow-y: auto; width: auto; min-height: 82px; height: auto;" class="ui-dialog-content ui-widget-content" scrolltop="0" scrollleft="0">
      <div style="width:100%" class="oe_popup_form">
        <div class="oe_formview oe_view oe_form_editable" style="opacity: 1;">
          <div class="oe_form_buttons"></div>
          <div class="oe_form_sidebar" style="display: none;"></div>
          <div class="oe_form_container">
            <div class="oe_form">
              <div class="">
                <? include('../../common/title/input_bar.php');?>
                <div class="oe_form_sheetbg">
                  <div class="oe_form_sheet oe_form_sheet_width">
                    <h1>
                      <label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right"> <a href="home2.php" rel = "gb_page_center[940, 600]">
                      <?=$title?>
                      </a> </label>
                    </h1>
                    <table class="oe_form_group " border="0" cellpadding="0" cellspacing="0">
                      <tbody>
                        <tr class="oe_form_group_row">
                          <td class="oe_form_group_cell"><table width="274" height="156" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
                              <tbody>
                                <tr class="oe_form_group_row">
                             
                                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">Details <span class="oe_form_group_cell oe_form_group_cell_label">Task Name </span></td>
                                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">Task Details </td>
								  <td bgcolor="#E8E8E8" class="oe_form_group_cell">Task Status </td>
								  <td bgcolor="#E8E8E8" class="oe_form_group_cell">Remarks </td>
                                </tr>
                                <tr class="oe_form_group_row">
                                    <input name="id" id="id" value="<?php echo $$unique;?>" type="hidden" />
                                    <input name="task_id" id="task_id" value="<?php echo $_SESSION['task_id'];?>" type="hidden" />
									<input name="emp_id" id="emp_id" value="<?php echo $_SESSION['user']['id'];?>" type="hidden" />
									<input name="master_id" id="master_id" value="<?php echo find_a_field('daily_give_task_details','task_id','id='.$_SESSION['task_id']);?>" type="hidden" />
                                  <td width="29%" class="oe_form_group_cell"><input name="task_name" type="text" class="input3" id="task_name" value="<?=$task_name?>" maxlength="400" /></td>
                                  <td width="28%" class="oe_form_group_cell"><textarea name="task_desc"><?=$task_desc;?></textarea></td>
								  <td width="29%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">
                                    <select name="status" id="status" style="width:100px;" >
                                      <option value="PENDING" <? if($status=='PENDING') echo "selected";?>>PENDING</option>
									  <option value="ONGOING" <? if($status=='ONGOING') echo "selected";?>>ONGOING</option>
									  <option value="COMPLETED" <? if($status=='COMPLETED') echo "selected";?>>COMPLETED</option>
                                    </select>
                                  </span></td>
								  
								  <td width="28%" class="oe_form_group_cell"><textarea name="task_remarks"><?=$task_remarks;?></textarea></td>
                                </tr>
                              </tbody>
                          </table></td>
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
    <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix"> </div>
  </div>
</form>
</body>
</html>
