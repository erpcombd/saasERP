<?php
session_start();

require "../../config/inc.all.php";

// ::::: Edit This Section ::::: 
$title='Schedule Type Information';			// Page Name and Page Title
$page="schedule_type.php";		// PHP File Name
$input_page="schedule_type_input.php";
$root='setup';

$table='hrm_schedule_info';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='schedule_name';				// For a New or Edit Data a must have data field

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
while (list($key, $value)=each($data))
{ $$key=$value;}
}
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
?>
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
          </h1>
		  <table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row">
            <td class="oe_form_group_cell"><table width="261" height="66" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
              <tbody>
                
				<tr class="oe_form_group_row">
   <td bgcolor="#E8E8E8" width="32%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Schedule Group Name:</td>
                  <td bgcolor="#E8E8E8" width="30%" class="oe_form_group_cell oe_form_group_cell_label">
                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                  <input name="schedule_name" type="text" id="schedule_name" value="<?=$schedule_name?>" />
				  </td>
				  
				  <td bgcolor="#E8E8E8" width="23%" class="oe_form_group_cell">
				  <span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Off day :</span>
				  </td>
                  <td bgcolor="#E8E8E8" width="25%" class="oe_form_group_cell">
				 <select name="off_day">
				 <option></option>
						<option value="5" <?=($off_day==5)?'selected':'';?>>Friday</option>
						<option value="6" <?=($off_day==6)?'selected':'';?>>Saturday</option>
						<option value="7" <?=($off_day==7)?'selected':'';?>>Sunday</option>
						<option value="1" <?=($off_day==1)?'selected':'';?>>Monday</option>
						<option value="2" <?=($off_day==2)?'selected':'';?>>Tuesday</option>
						<option value="3" <?=($off_day==3)?'selected':'';?>>Wednesday</option>
						<option value="4" <?=($off_day==4)?'selected':'';?>>Thursday</option>
						
                  </select>
				 
				  </td>
				  
                </tr>
				
				
				<tr class="oe_form_group_row">
   <td bgcolor="#fff" width="32%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Office Start Time :</td>
                  <td bgcolor="#fff" width="30%" class="oe_form_group_cell oe_form_group_cell_label">
                  <select name="office_start_time">
                   <option selected>
				   <?=$office_start_time?>
				   </option>
						<option>00:00</option>
						<option>00:30</option>
						<option>01:00</option>
						<option>01.30</option>
						<option>02.00</option>
						<option>02.30</option>
						<option>03:00</option>
						<option>03:30</option>
						<option>04:00</option>
						<option>04.30</option>
						<option>05.00</option>
						<option>05.30</option>
						<option>06:00</option>
						<option>06:30</option>
						<option>07:00</option>
						<option>07.30</option>
						<option>08.00</option>
						<option>08.30</option>
						<option>09:00</option>
						<option>09:30</option>
						<option>10:00</option>
						<option>10.30</option>
						<option>11.00</option>
						<option>11.30</option>
						<option>12.00</option>
						<option>12.30</option>
						<option>13.00</option>
						<option>13:30</option>
						<option>14:00</option>
						<option>14:30</option>
						<option>15.00</option>
						<option>15.30</option>
						<option>16.00</option>
						<option>16:30</option>
						<option>17:00</option>
						<option>17:30</option>
						<option>18.00</option>
						<option>18.30</option>
						<option>19.00</option>
						<option>19:30</option>
						<option>20.00</option>
						<option>20.30</option>
						<option>21.00</option>
						<option>21:30</option>
						<option>22:00</option>
						<option>22:30</option>
						<option>23.00</option>
						<option>23.30</option>
						<option>24.00</option>
                  </select>
                  
				  </td>
				  
				  <td bgcolor="#fff" width="23%" class="oe_form_group_cell">
				  <span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Office End Time :</span>
				  </td>
                  <td bgcolor="#fff" width="25%" class="oe_form_group_cell">
				  <select name="office_end_time">
                   <option selected>
				   <?=$office_end_time?>
				   </option>
						<option>00:00</option>
						<option>00:30</option>
						<option>01:00</option>
						<option>01.30</option>
						<option>02.00</option>
						<option>02.30</option>
						<option>03:00</option>
						<option>03:30</option>
						<option>04:00</option>
						<option>04.30</option>
						<option>05.00</option>
						<option>05.30</option>
						<option>06:00</option>
						<option>06:30</option>
						<option>07:00</option>
						<option>07.30</option>
						<option>08.00</option>
						<option>08.30</option>
						<option>09:00</option>
						<option>09:30</option>
						<option>10:00</option>
						<option>10.30</option>
						<option>11.00</option>
						<option>11.30</option>
						<option>12.00</option>
						<option>12.30</option>
						<option>13.00</option>
						<option>13:30</option>
						<option>14:00</option>
						<option>14:30</option>
						<option>15.00</option>
						<option>15.30</option>
						<option>16.00</option>
						<option>16:30</option>
						<option>17:00</option>
						<option>17:30</option>
						<option>18.00</option>
						<option>18.30</option>
						<option>19.00</option>
						<option>19:30</option>
						<option>20.00</option>
						<option>20.30</option>
						<option>21.00</option>
						<option>21:30</option>
						<option>22:00</option>
						<option>22:30</option>
						<option>23.00</option>
						<option>23.30</option>
						<option>24.00</option>
                  </select>
				  </td>
				  
                </tr>
				
				
				
				<tr class="oe_form_group_row">
   <td bgcolor="#E8E8E8" width="32%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Status :</td>
                  <td bgcolor="#E8E8E8" width="30%" class="oe_form_group_cell oe_form_group_cell_label">
                  <select name="status">
                   <option selected><?=$status?></option>
						<option>Enable</option>
						<option>Disable</option>
                  </select>
				  </td>
				  
				  <td bgcolor="#E8E8E8" width="23%" class="oe_form_group_cell">
				  <span class="oe_form_group_cell oe_form_group_cell_label"></span>
				  </td>
                  <td bgcolor="#E8E8E8" width="25%" class="oe_form_group_cell">
				 
				  </td>
				  
				  
				  
                </tr>
				
				
				
				
				<!--<tr class="oe_form_group_row">
                  <td height="33" colspan="2" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                </tr>-->
				
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
