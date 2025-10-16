<?php

session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 

$title='Leave Information';			// Page Name and Page Title

$page="leave_entry.php";		// PHP File Name

$input_page="leave_entry_input.php";

$root='leave';



$table='hrm_leave_info';

$unique='id';

$shown='s_date';



// ::::: End Edit Section :::::





$crud      =new crud($table);



$$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

$$unique = $_POST[$unique];



/*if(isset($_POST['insert'])||isset($_POST['insertn']))

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

echo '<script type="text/javascript">parent.parent.document.location.href = "../'.$root.'/'.$page.'";</script>';

}*/

//for Delete..................................



if(isset($_POST['delete']))

{		$condition=$unique."=".$$unique;		$crud->delete($condition);

$up_query='update hrm_att_summary set leave_id="", leave_type="", leave_reason="",leave_duration="", leave_approved_by="", leave_entry_at="0000-00-00 00:00:00", leave_entry_by="" where leave_id="'.$$unique.'" and emp_id="'.$_POST['EMP_ID'].'"';
db_query($up_query);

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

        <link href="../../../../public/assets/css/css.css" rel="stylesheet">





<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>

<script type="text/javascript" src="../../js/jquery-ui-1.8.2.custom.min.js"></script>

<script type="text/javascript" src="../../js/jquery.ui.datepicker.js"></script>

<script type="text/javascript" src="../../js/jquery.autocomplete.js"></script>

<script type="text/javascript" src="../../js/jquery.validate.js"></script>

<script type="text/javascript" src="../../js/paging.js"></script>

<script type="text/javascript" src="../../js/ddaccordion.js"></script>

<script type="text/javascript" src="../../js/js.js"></script>

<script type="text/javascript">

$(document).ready(function(){



  $("#e_date").change(function (){

     var from_leave = $("#s_date").datepicker('getDate');

     var to_leave = $("#e_date").datepicker('getDate');

    var days   = ((to_leave - from_leave)/1000/60/60/24)+1;



	if(days>0&&days<100){

	$("#total_days").val(days);}

  });

      $("#s_date").change(function (){

     var from_leave = $("#s_date").datepicker('getDate');

     var to_leave = $("#e_date").datepicker('getDate');

    var days   = ((to_leave - from_leave)/1000/60/60/24)+1;

	if(days>0&&days<100){

	$("#total_days").val(days);}

  });

    

  

});

 

</script>

<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>

        <? 

do_calander('#s_date');

do_calander('#e_date');



auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');?>

        </head>

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

<? if(
$_SESSION['user']['username']=='faysal' ||
$_SESSION['user']['username']=='9999' ||
$_SESSION['user']['username']=='12205'
){ ?>
					  <? include('../common/input_bar.php');?>

<? } ?>
                      <div class="oe_form_sheetbg">

                        <div class="oe_form_sheet oe_form_sheet_width">

        <table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row">

            <td class="oe_form_group_cell"><table width="261" height="297" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">

              <tbody>



                         <tr>

                <td width="20%" height="1" valign="middle"><div align="right">Employee Code : </div><input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" /></td>

                <td width="82%" height="1" valign="middle"><input name="EMP_ID"  type="text" id="EMP_ID" size="10" onBlur="" tabindex="1" style="width:400px;" required value="<?=$PBI_ID?>" /></td>

              </tr>

              <tr>

                <td height="1" align="right" valign="middle" bgcolor="#EBEBEB"><div align="right"> Type : </div></td>

                <td height="1" valign="middle" bgcolor="#EBEBEB"><label>

                  <select name="type" id="type">
<option><?=$type?></option>
				  <option>Casual Leave</option>

				  <option>Sick Leave</option>

				  <option>Maternity Leave</option>

				  <option>Annual </option>

				  <option>Compensatory Off</option>

				  <option>LWP (Leave Without Pay)</option>

				  </select>

                </label></td>

              </tr>

              <tr>

                <td height="1" align="right" valign="middle"><div align="right"> Start Date :</div></td>

                <td height="1" valign="middle"><input type="text" name="s_date" id="s_date" style="width:100px;" value="<?=$s_date?>" /></td>

              </tr>

              <tr>

                <td height="1" align="right" valign="middle" bgcolor="#EBEBEB"><div align="right"> End Date :</div></td>

                <td height="1" valign="middle" bgcolor="#EBEBEB"><input type="text" name="e_date" id="e_date" style="width:100px;" value="<?=$e_date?>" /></td>

              </tr>

              <tr>

                <td height="1" valign="middle"><div align="right">Total  Days : </div></td>

                <td height="1" valign="middle"><input type="text" name="total_days" id="total_days" style="width:100px;" readonly="" required="required" value="<?=$total_days?>" /></td>

              </tr>

              <tr>

                <td height="1" valign="middle" bgcolor="#EBEBEB"><div align="right">Reason :</div></td>

                <td height="1" valign="middle" bgcolor="#EBEBEB"><label>

                  <input name="reason" type="text" id="reason" value="<?=$reason?>" />

                </label></td>

              </tr>

              <tr>

                <td height="1" valign="middle"><div align="right">Paid Status : </div></td>

                <td height="1" valign="middle"><label>

                  <select name="paid_status" id="paid_status">

				  <option <?=($type=='Paid')?'Selected':'';?>>Paid</option>

				  <option <?=($type=='Unpaid')?'Selected':'';?>>Unpaid</option>

                  </select>

                  </label></td>

              </tr>

                <tr class="oe_form_group_row">

                  <td height="33" colspan="2" class="oe_form_group_cell oe_form_group_cell_label"></td>

                  </tr>

  </tbody></table>

<p></p></td>

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
