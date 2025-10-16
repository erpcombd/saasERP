<?php
session_start();

//require "../../config/inc.all.php";

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Increment Entry Management';			// Page Name and Page Title
$page="increment_entry.php";		// PHP File Name
$input_page="increment_entry_input.php";
$root='hrm';

$table='increment_detail';		// Database Table Name Mainly related to this page
$unique='INCREMENT_D_ID';			// Primary Key of this Database table
$shown='INCREMENT_TYPE';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert'])||isset($_POST['insertn']))
{		
$now				= time();

//$_REQUEST['PBI_ID']=$_SESSION['employee_selected'];
$crud->insert();
$type=1;
$msg='New Entry Successfully Inserted.';

$new_gross = $_POST['new_basic_salary']+$_POST['new_house_rent']+$_POST['new_medical_allowance']+$_POST['new_ta']+$_POST['new_food_allowance'];

$u_sql='UPDATE salary_info SET 
basic_salary="'.$_POST['new_basic_salary'].'",house_rent="'.$_POST['new_house_rent'].'",medical_allowance="'.$_POST['new_medical_allowance'].'",ta="'.$_POST['new_ta'].'",pf="'.$_POST['new_pf'].'",income_tax="'.$_POST['new_income_tax'].'",food_allowance="'.$_POST['new_food_allowance'].'",gross_salary="'.$new_gross.'" WHERE PBI_ID='.$_SESSION['employee_selected'];
db_query($u_sql);


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
		$new_gross = $_POST['new_basic_salary']+$_POST['new_house_rent']+$_POST['new_medical_allowance']+$_POST['new_ta']+$_POST['new_food_allowance'];

$u_sql='UPDATE salary_info SET 
basic_salary="'.$_POST['new_basic_salary'].'",house_rent="'.$_POST['new_house_rent'].'",medical_allowance="'.$_POST['new_medical_allowance'].'",ta="'.$_POST['new_ta'].'",pf="'.$_POST['new_pf'].'",income_tax="'.$_POST['new_income_tax'].'",food_allowance="'.$_POST['new_food_allowance'].'",gross_salary="'.$new_gross.'" WHERE PBI_ID='.$_SESSION['employee_selected'];
db_query($u_sql);
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
else{
$past=find_all_field('salary_info','','PBI_ID='.$_SESSION['employee_selected']);
//var_dump($past);


$past_consolidated_salary=$past->consolidated_salary;
$past_basic_salary=$past->basic_salary;
$past_house_rent=$past->house_rent;
$past_food_allowance=$past->food_allowance;
$past_medical_allowance=$past->medical_allowance;
$past_special_allowance=$past->special_allowance;
$past_ta=$past->ta;
$past_group_insurance=$past->group_insurance;
$past_mobile_allowance=$past->mobile_allowance;
$past_vehicle_allowance=$past->vehicle_allowance;
$past_pf=$past->pf;
$past_income_tax=$past->income_tax;}

if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
?>
<html style="height: 100%;">
<head>
<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
<meta content="text/html; charset=UTF-8" http-equiv="content-type">
<link href="../../../../public/assets/css/css.css" rel="stylesheet">
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.datepicker.js"></script>
<? do_calander('#INCREMENT_EFFECT_DATE');?>
</head>
<body>
<!--[if lte IE 8]>
        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>
        <script>CFInstall.check({mode: "overlay"});</script>
        <![endif]-->
<form action="" method="post" enctype="multipart/form-data">
  <div class="ui-dialog ui-widget ui-widget-content ui-corner-all oe_act_window ui-draggable ui-resizable openerp" style="outline: 0px none; z-index: 1002; position: absolute; height: auto; width: 900px; display: block; /* [disabled]left: 217.5px; */ left: 16px; top: 21px;" tabindex="-1" role="dialog" aria-labelledby="ui-id-19">
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
                    <h1>
                      <label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right"> <a href="home2.php" rel = "gb_page_center[940, 600]">
                      <?=$title?>
                      </a> </label>
                    </h1>
                    <table class="oe_form_group " border="0" cellpadding="0" cellspacing="0">
                      <tbody>
                        <tr class="oe_form_group_row">
                          <td class="oe_form_group_cell"><table width="261" height="66" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
                              <tbody>
                                <tr class="oe_form_group_row">
                                  <td  width="33%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Increment Type :</td>
                                  <td  width="33%" colspan="1" class="oe_form_group_cell"><input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
								  <input type="hidden" name="PBI_ID" value="<?=$_SESSION['employee_selected']?>" >
                                    <select name="INCREMENT_TYPE" value="" required="required" type="text" >
									  <? //foreign_relation('increment_type','INCREMENT_TYPE','INCREMENT_TYPE',$INCREMENT_TYPE,'1');?>
									  <option></option>
									  <option>Yearly</option>
									  <option>Promotion</option>
									  <option>Performance</option>
									</select>
                                                                       </td>
                                  <td  width="34%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">
                                    <label>&nbsp;&nbsp;Ettect Date :</label>
                                  </span></td>
                                  <td  width="67%" class="oe_form_group_cell">
								  <input name="INCREMENT_EFFECT_DATE" type="text" id="INCREMENT_EFFECT_DATE" value="<?=$INCREMENT_EFFECT_DATE?>" required="required"/></td>
                                </tr>
                                
                                <tr class="oe_form_group_row">
                                  <td colspan="2" align="center" bgcolor="#E8E8E8" class="oe_form_group_cell_label oe_form_group_cell"><strong>Present</strong></td>
                                  <td colspan="2" align="center" bgcolor="#E8E8E8" class="oe_form_group_cell"><strong>New</strong></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;<span class="style2">Consolidated Salary :</span></td>
                                  <td  class="oe_form_group_cell"><input name="past_consolidated_salary" type="text" id="past_consolidated_salary" value="<?=$past_consolidated_salary?>" /></td>
                                  <td  class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">New <span class="style2">Consolidated Salary :</span></span></td>
                                  <td  class="oe_form_group_cell"><input name="new_consolidated_salary" type="text" id="new_consolidated_salary" value="<?=$new_consolidated_salary?>" /></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Basic : </td>
                                  <td  class="oe_form_group_cell"><input name="past_basic_salary" type="text" id="past_basic_salary" value="<?=$past_basic_salary?>" /></td>
                                  <td  class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">New&nbsp;Basic : </span></td>
                                  <td  class="oe_form_group_cell"><input name="new_basic_salary" type="text" id="new_basic_salary" value="<?=$new_basic_salary?>" /></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;House Rent : </td>
                                  <td class="oe_form_group_cell"><input name="past_house_rent" type="text" id="past_house_rent" value="<?=$past_house_rent?>" /></td>
                                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">New&nbsp;House Rent : </span></td>
                                  <td class="oe_form_group_cell"><input name="new_house_rent" type="text" id="new_house_rent" value="<?=$new_house_rent?>" /></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;<span class="style2">Food Allowance :</span></td>
                                  <td  class="oe_form_group_cell"><input name="past_food_allowance" type="text" id="past_food_allowance" value="<?=$past_food_allowance?>" /></td>
                                  <td  class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">New </span><span class="oe_form_group_cell oe_form_group_cell_label"><span class="style2">Food Allowance :</span></span></td>
                                  <td  class="oe_form_group_cell"><input name="new_food_allowance" type="text" id="new_food_allowance" value="<?=$new_food_allowance?>" /></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Medical Allowance :</td>
                                  <td  class="oe_form_group_cell"><input name="past_medical_allowance" type="text" id="past_medical_allowance" value="<?=$past_medical_allowance?>" /></td>
                                  <td  class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">New&nbsp;Medical Allowance :</span></td>
                                  <td  class="oe_form_group_cell"><input name="new_medical_allowance" type="text" id="new_medical_allowance" value="<?=$new_medical_allowance?>" /></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;<span class="style2">Special Allowance :</span></td>
                                  <td  class="oe_form_group_cell"><input name="past_special_allowance" type="text" id="past_special_allowance" value="<?=$past_special_allowance?>" /></td>
                                  <td  class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">New&nbsp;<span class="style2">Special Allowance :</span></span></td>
                                  <td  class="oe_form_group_cell"><input name="new_special_allowance" type="text" id="new_special_allowance" value="<?=$new_special_allowance?>" /></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;<span class="style2">TA/DA :</span></td>
                                  <td  class="oe_form_group_cell"><input name="past_ta" type="text" id="past_ta" value="<?=$past_ta?>" /></td>
                                  <td  class="oe_form_group_cell style2"><span class="oe_form_group_cell oe_form_group_cell_label">New&nbsp;<span class="style2">TA/DA :</span></span></td>
                                  <td  class="oe_form_group_cell"><input name="new_ta" type="text" id="new_ta" value="<?=$new_ta?>" /></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Group Insurance :</td>
                                  <td  class="oe_form_group_cell"><input name="past_group_insurance" type="text" id="past_group_insurance" value="<?=$past_group_insurance?>" /></td>
                                  <td  class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">New&nbsp;Group Insurance :</span></td>
                                  <td  class="oe_form_group_cell"><input name="new_group_insurance" type="text" id="new_group_insurance" value="<?=$new_group_insurance?>" /></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;<span class="style2">Mobile Allowance:</span></td>
                                  <td class="oe_form_group_cell"><input name="past_mobile_allowance" type="text" id="past_mobile_allowance" value="<?=$past_mobile_allowance?>" /></td>
                                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;New <span class="style2">Mobile Allowance:</span></span></td>
                                  <td class="oe_form_group_cell"><input name="new_mobile_allowance" type="text" id="new_mobile_allowance" value="<?=$new_mobile_allowance?>" /></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Vehicle Allowance :</td>
                                  <td class="oe_form_group_cell"><input name="past_vehicle_allowance" type="text" id="past_vehicle_allowance" value="<?=$past_vehicle_allowance?>" /></td>
                                  <td bordercolor="#FF99FF" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;New&nbsp;</span>Vehicle Allowance  :</td>
                                  <td bordercolor="#FF99FF" class="oe_form_group_cell"><input name="new_vehicle_allowance" type="text" id="new_vehicle_allowance" value="<?=$new_vehicle_allowance?>" /></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;PF :</td>
                                  <td class="oe_form_group_cell"><span class="oe_form_field oe_datepicker_root oe_form_field_date">
                                    <input name="past_pf" type="text" id="past_pf" value="<?=$past_pf?>" />
                                    </span></td>
                                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;New PF  :</span></td>
                                  <td class="oe_form_group_cell"><span class="oe_form_field oe_datepicker_root oe_form_field_date">
                                    <input name="new_pf" type="text" id="new_pf" value="<?=$new_pf?>" />
                                  </span></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Income Tax :</td>
                                  <td class="oe_form_group_cell"><input name="past_income_tax" type="text" id="past_income_tax" value="<?=$past_income_tax?>" /></td>
                                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;New Income Tax  :</span></td>
                                  <td class="oe_form_group_cell"><input name="new_income_tax" type="text" id="new_income_tax" value="<?=$new_income_tax?>" /></td>
                                </tr>
                              </tbody>
                            </table>
                          <p>&nbsp;</p></td>
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
