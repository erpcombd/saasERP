
<?php

session_start();
//

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.core/init.php);
require_once SERVER_CORE."routing/layout.top.php";
// ::::: Edit This Section ::::: 
$title='Shift & Schedule Setup Input';			// Page Name and Page Title
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

if(isset($_POST['insert']) || isset($_POST['insertn']))
{		

$now= time();
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
        <link href="../../../assets/css/css.css" rel="stylesheet"></head>
<body>
        <!--[if lte IE 8]>
        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>
        <script>CFInstall.check({mode: "overlay"});</script>
        <![endif]-->
       <form action="" method="post"> <div class="ui-dialog ui-widget ui-widget-content ui-corner-all oe_act_window ui-draggable ui-resizable openerp" style="outline: 0px none; z-index: 1002; position: absolute; height: auto; width: 900px; display: block; /* [disabled]left: 217.5px; */ left: 16px; top: 21px;" tabindex="-1" role="dialog" aria-labelledby="ui-id-19">
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
        <table width="100%" class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row">
            <td class="oe_form_group_cell"><table width="100%" height="165" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
              <tbody>
                
				<tr class="oe_form_group_row">
   <td bgcolor="#E8E8E8" width="32%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Schedule Group Name:</td>
                  <td bgcolor="#E8E8E8" width="30%" class="oe_form_group_cell oe_form_group_cell_label">
                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                  <input name="schedule_name" type="text" id="schedule_name" value="<?=$schedule_name?>" />
				  </td>
				  
				  <td bgcolor="#E8E8E8" width="23%" class="oe_form_group_cell">
				  <span class="oe_form_group_cell oe_form_group_cell_label"><!--&nbsp;&nbsp;Off day :--></span>
				  </td>
                  <td bgcolor="#E8E8E8" width="25%" class="oe_form_group_cell">
				<?php /*?> <select name="off_day">
				 <option></option>
						<option value="5" <?=($off_day==5)?'selected':'';?>>Friday</option>
						<option value="6" <?=($off_day==6)?'selected':'';?>>Saturday</option>
						<option value="7" <?=($off_day==7)?'selected':'';?>>Sunday</option>
						<option value="1" <?=($off_day==1)?'selected':'';?>>Monday</option>
						<option value="2" <?=($off_day==2)?'selected':'';?>>Tuesday</option>
						<option value="3" <?=($off_day==3)?'selected':'';?>>Wednesday</option>
						<option value="4" <?=($off_day==4)?'selected':'';?>>Thursday</option>
						
                  </select><?php */?>
				 
				  </td>
				  
                </tr>
				
				
				<tr class="oe_form_group_row">
   <td bgcolor="#fff" width="32%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Office Start Time :</td>
                  <td bgcolor="#fff" width="30%" class="oe_form_group_cell oe_form_group_cell_label"><select name="office_start_time">
                    <option selected>
				   <?=$office_start_time?>
				   </option>
						<option value="00:00:00">12.00 AM</option>
						<option value="00:30:00">00.30 AM</option>
						<option value="01:00:00">01.00 AM</option>
						<option value="01:30:00">01.30 AM</option>
						<option value="02:00:00">02.00 AM</option>
						<option value="02:30:00">02.30 AM</option>
						<option value="03:00:00">03.00 AM</option>
						<option value="03:30:00">03.30 AM</option>
						<option value="04:00:00">04.00 AM</option>
						<option value="04:30:00">04.30 AM</option>
						<option value="05:00:00">05.00 AM</option>
						<option value="05:30:00">05.30 AM</option>
						<option value="06:00:00">06.00 AM</option>
						<option value="06:30:00">06.30 AM</option>
						<option value="07:00:00">07.00 AM</option>
						<option value="07:30:00">07.30 AM</option>
						<option value="08:00:00">08.00 AM</option>
						<option value="08:30:00">08.30 AM</option>
						<option value="09:00:00">09.00 AM</option>
						<option value="09:30:00">09.30 AM</option>
						<option value="10:00:00">10.00 AM</option>
						<option value="10:30:00">10.30 AM</option>
						<option value="11:00:00">11.00 AM</option>
						<option value="11:30:00">11.30 AM</option>
						<option value="12:00:00">12.00 PM</option>
						<option value="12:30:00">12.30 PM</option>
						<option value="13:00:00">01.00 PM</option>
						<option value="13:30:00">01.30 PM</option>
						<option value="14:00:00">02.00 PM</option>
						<option value="14:30:00">02.30 PM</option>
						<option value="15:00:00">03.00 PM</option>
						<option value="15:30:00">03.30 PM</option>
						<option value="16:00:00">04.00 PM</option>
						<option value="16:30:00">04.30 PM</option>
						<option value="17:00:00">05.00 PM</option>
						<option value="17:30:00">05.30 PM</option>
						<option value="18:00:00">06.00 PM</option>
						<option value="18:30:00">06.30 PM</option>
						<option value="19:00:00">07.00 PM</option>
						<option value="19:30:00">07.30 PM</option>
						<option value="20:00:00">08.00 PM</option>
						<option value="20:30:00">08.30 PM</option>
						<option value="21:00:00">09.00 PM</option>
						<option value="21:30:00">09.30 PM</option>
						<option value="22:00:00">10.00 PM</option>
						<option value="22:30:00">10.30 PM</option>
						<option value="23:00:00">11.00 PM</option>
						<option value="23:30:00">11.30 PM</option>
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
						</option>
						<option value="00:00:00">12.00 AM</option>
						<option value="00:30:00">00.30 AM</option>
						<option value="01:00:00">01.00 AM</option>
						<option value="01:30:00">01.30 AM</option>
						<option value="02:00:00">02.00 AM</option>
						<option value="02:30:00">02.30 AM</option>
						<option value="03:00:00">03.00 AM</option>
						<option value="03:30:00">03.30 AM</option>
						<option value="04:00:00">04.00 AM</option>
						<option value="04:30:00">04.30 AM</option>
						<option value="05:00:00">05.00 AM</option>
						<option value="05:30:00">05.30 AM</option>
						<option value="06:00:00">06.00 AM</option>
						<option value="06:30:00">06.30 AM</option>
						<option value="07:00:00">07.00 AM</option>
						<option value="07:30:00">07.30 AM</option>
						<option value="08:00:00">08.00 AM</option>
						<option value="08:30:00">08.30 AM</option>
						<option value="09:00:00">09.00 AM</option>
						<option value="09:30:00">09.30 AM</option>
						<option value="10:00:00">10.00 AM</option>
						<option value="10:30:00">10.30 AM</option>
						<option value="11:00:00">11.00 AM</option>
						<option value="11:30:00">11.30 AM</option>
						<option value="12:00:00">12.00 PM</option>
						<option value="12:30:00">12.30 PM</option>
						<option value="13:00:00">01.00 PM</option>
						<option value="13:30:00">01.30 PM</option>
						<option value="14:00:00">02.00 PM</option>
						<option value="14:30:00">02.30 PM</option>
						<option value="15:00:00">03.00 PM</option>
						<option value="15:30:00">03.30 PM</option>
						<option value="16:00:00">04.00 PM</option>
						<option value="16:30:00">04.30 PM</option>
						<option value="17:00:00">05.00 PM</option>
						<option value="17:30:00">05.30 PM</option>
						<option value="18:00:00">06.00 PM</option>
						<option value="18:30:00">06.30 PM</option>
						<option value="19:00:00">07.00 PM</option>
						<option value="19:30:00">07.30 PM</option>
						<option value="20:00:00">08.00 PM</option>
						<option value="20:30:00">08.30 PM</option>
						<option value="21:00:00">09.00 PM</option>
						<option value="21:30:00">09.30 PM</option>
						<option value="22:00:00">10.00 PM</option>
						<option value="22:30:00">10.30 PM</option>
						<option value="23:00:00">11.00 PM</option>
						<option value="23:30:00">11.30 PM</option>
                  </select>
				  </td>
				  
                </tr>
				
				
				
				<tr class="oe_form_group_row">
				  <td bgcolor="#E8E8E8" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Early In Hour:</td>
				  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">
					  <input name="min_in" type="text" id="min_in" value="<?=$min_in?>" /></td>
				  <td bgcolor="#E8E8E8" class="oe_form_group_cell">Max Out Hour:</td>
				  <td bgcolor="#E8E8E8" class="oe_form_group_cell">
					  <input name="max_out" type="text" id="max_out" value="<?=$max_out?>" /></td>
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
				  <span class="oe_form_group_cell oe_form_group_cell_label"></span> Group For : </td>
                  <td bgcolor="#E8E8E8" width="25%" class="oe_form_group_cell"><select name="group_for" style="width:160px;" id="group_for" required>
                    <? foreign_relation('user_group','id','group_name',$group_for);?>
                  </select></td>
				  
				  
				  
                </tr>
				
				<tr class="oe_form_group_row">
   <td bgcolor="#E8E8E8" width="32%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Office Middle Time</td>
                  <td bgcolor="#E8E8E8" width="30%" class="oe_form_group_cell oe_form_group_cell_label">
                 <select name="office_mid_time">
                    <option selected>
				   <?=$office_mid_time?>
				   </option>
						<option value="00:00:00">12.00 AM</option>
						<option value="00:30:00">00.30 AM</option>
						<option value="01:00:00">01.00 AM</option>
						<option value="01:30:00">01.30 AM</option>
						<option value="02:00:00">02.00 AM</option>
						<option value="02:30:00">02.30 AM</option>
						<option value="03:00:00">03.00 AM</option>
						<option value="03:30:00">03.30 AM</option>
						<option value="04:00:00">04.00 AM</option>
						<option value="04:30:00">04.30 AM</option>
						<option value="05:00:00">05.00 AM</option>
						<option value="05:30:00">05.30 AM</option>
						<option value="06:00:00">06.00 AM</option>
						<option value="06:30:00">06.30 AM</option>
						<option value="07:00:00">07.00 AM</option>
						<option value="07:30:00">07.30 AM</option>
						<option value="08:00:00">08.00 AM</option>
						<option value="08:30:00">08.30 AM</option>
						<option value="09:00:00">09.00 AM</option>
						<option value="09:30:00">09.30 AM</option>
						<option value="10:00:00">10.00 AM</option>
						<option value="10:30:00">10.30 AM</option>
						<option value="10:45:00">10.45 AM</option>
						<option value="11:00:00">11.00 AM</option>
						<option value="11:30:00">11.30 AM</option>
						<option value="11:45:00">11.45 AM</option>
						<option value="12:00:00">12.00 PM</option>
						<option value="12:30:00">12.30 PM</option>
						<option value="13:00:00">01.00 PM</option>
						<option value="13:30:00">01.30 PM</option>
						<option value="14:00:00">02.00 PM</option>
						<option value="14:30:00">02.30 PM</option>
						<option value="15:00:00">03.00 PM</option>
						<option value="15:30:00">03.30 PM</option>
						<option value="16:00:00">04.00 PM</option>
						<option value="16:30:00">04.30 PM</option>
						<option value="17:00:00">05.00 PM</option>
						<option value="17:30:00">05.30 PM</option>
						<option value="18:00:00">06.00 PM</option>
						<option value="18:30:00">06.30 PM</option>
						<option value="19:00:00">07.00 PM</option>
						<option value="19:30:00">07.30 PM</option>
						<option value="20:00:00">08.00 PM</option>
						<option value="20:30:00">08.30 PM</option>
						<option value="21:00:00">09.00 PM</option>
						<option value="21:30:00">09.30 PM</option>
						<option value="22:00:00">10.00 PM</option>
						<option value="22:30:00">10.30 PM</option>
						<option value="23:00:00">11.00 PM</option>
						<option value="23:30:00">11.30 PM</option>
                </select>
                  
				  </td>
				  
				  <td bgcolor="#E8E8E8" width="23%" class="oe_form_group_cell">
				  <span class="oe_form_group_cell oe_form_group_cell_label">Sch Type</span></td>
                  <td bgcolor="#E8E8E8" width="25%" class="oe_form_group_cell">
				  
				  	<select name="sch_type" style="width:160px;" id="sch_type" required>
					<option></option>
                    <option value="Duty" <?=($sch_type=='Duty') ? 'selected' : '' ?>>Duty</option>
					<option value="offday" <?=($sch_type=='offday') ? 'selected' : '' ?>>Off Day</option>
                  </select>
				  
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
