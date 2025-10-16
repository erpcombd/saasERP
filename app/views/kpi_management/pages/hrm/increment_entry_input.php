<?php
session_start();

require "../../config/inc.all.php";

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

$_REQUEST['PBI_ID']=$_SESSION['employee_selected'];
$crud->insert();
$type=1;
$msg='New Entry Successfully Inserted.';

mysql_query("UPDATE `salary_info` SET 
	`basic_salary` = '".$_REQUEST['new_basic_salary']."', 
	`house_rent` = '".$_REQUEST['new_house_rent']."', 
	`ta` = '".$_REQUEST['new_ta']."', 
	`da` = '".$_REQUEST['new_da']."', 
	`medical_allowance` = '".$_REQUEST['new_medical_allowance']."', 
	`pf` = '".$_REQUEST['new_pf']."', 
	`pf_organization` = '".$_REQUEST['new_pf_organization']."' 
WHERE `PBI_ID` = '".$_SESSION['employee_selected']."'");

if(isset($_POST['insert']))
{
echo '<script type="text/javascript">parent.parent.document.location.href = "../'.$root.'/'.$page.'";</script>';
}
unset($_POST);
unset($$unique);


}


//for Modify..................................

if(isset($_POST['update']))
{

$table='increment_detail';		// Database Table Name Mainly related to this page
$unique='INCREMENT_D_ID';			// Primary Key of this Database table
$shown='INCREMENT_TYPE';	

echo $last_ip = find_a_field('increment_detail','max(INCREMENT_D_ID)','PBI_ID='.$_SESSION['employee_selected']);
echo $$unique;
if($$unique==$last_ip)
mysql_query("UPDATE `salary_info` SET 
	`basic_salary` = '".$_REQUEST['new_basic_salary']."', 
	`house_rent` = '".$_REQUEST['new_house_rent']."', 
	`ta` = '".$_REQUEST['new_ta']."', 
	`da` = '".$_REQUEST['new_da']."', 
	`medical_allowance` = '".$_REQUEST['new_medical_allowance']."', 
	`pf` = '".$_REQUEST['new_pf']."', 
	`pf_organization` = '".$_REQUEST['new_pf_organization']."' 
WHERE `PBI_ID` = '".$_SESSION['employee_selected']."'");

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
while (list($key, $value)=each($data))
{ $$key=$value;}
}
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
if($INCREMENT_DESG==0) $INCREMENT_DESG=find_a_field('personnel_basic_info','PBI_DESIGNATION','PBI_ID='.$_SESSION['employee_selected']);
if($old_basic_salary==0) $old_basic_salary=(int)find_a_field('salary_info','basic_salary','PBI_ID='.$_SESSION['employee_selected']);
if($new_basic_salary==0) 
{
$new_basic_salary=(int)($old_basic_salary + ($old_basic_salary)/10);
$new_house_rent=(int)(($new_basic_salary)*.6);
$old_house_rent=(int)find_a_field('salary_info','house_rent','PBI_ID='.$_SESSION['employee_selected']);
$old_pf=(int)find_a_field('salary_info','pf','PBI_ID='.$_SESSION['employee_selected']);
$old_pf_organization=(int)find_a_field('salary_info','pf_organization','PBI_ID='.$_SESSION['employee_selected']);

$old_medical_allowance=$new_medical_allowance=(int)find_a_field('salary_info','medical_allowance','PBI_ID='.$_SESSION['employee_selected']);
$old_ta=$new_ta=(int)find_a_field('salary_info','ta','PBI_ID='.$_SESSION['employee_selected']);
$old_da=$new_da=(int)find_a_field('salary_info','da','PBI_ID='.$_SESSION['employee_selected']);

if($new_basic_salary>3499)
$new_pf_organization=(int)(($new_basic_salary)*.1);
else $new_pf_organization = '350';
$new_pf=(int)(($new_basic_salary)*.1);
}

?>
<html style="height: 100%;"><head>
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <meta content="text/html; charset=UTF-8" http-equiv="content-type">
        <link href="../../css/css.css" rel="stylesheet">
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.datepicker.js"></script>
<script type="text/javascript">
	
	function autocal(){
	var basic = document.getElementById('new_basic_salary').value;
	if(basic>0){
	var house_rent=(basic*1)*(.6);
	var pf=(basic*1)*(.1);
	
	if(basic>3499)
	{
	var pf_organization=(basic*1)*(.1);
	}
	else
	{
	var pf_organization=350;
	}
	document.getElementById('new_house_rent').value = house_rent.toFixed(2);
	document.getElementById('new_pf').value = pf.toFixed(2);
	document.getElementById('new_pf_organization').value = pf_organization.toFixed(2);
	}
	}</script>
<? do_calander('#INCREMENT_EFFECT_DATE');?>

</head>
<body <? if(!isset($$unique)) echo ' onLoad="autocal()"';?>>
        <!--[if lte IE 8]>
        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>
        <script>CFInstall.check({mode: "overlay"});</script>
        <![endif]-->
       <form action="" method="post" enctype="multipart/form-data"> <div class="ui-dialog ui-widget ui-widget-content ui-corner-all oe_act_window ui-draggable ui-resizable openerp" style="outline: 0px none; z-index: 1002; position: absolute; height: auto; width: 900px; display: block; /* [disabled]left: 217.5px; */ left: 16px; top: 21px;" tabindex="-1" role="dialog" aria-labelledby="ui-id-19">
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
          </h1><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row">
            <td class="oe_form_group_cell"><table width="261" height="330" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
              <tbody>
                <tr class="oe_form_group_row">
   <td bgcolor="#E8E8E8" width="18%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Increment Type :</td>
                  <td bgcolor="#E8E8E8" width="28%" colspan="1" class="oe_form_group_cell">
                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                  <input name="INCREMENT_TYPE" type="text" id="INCREMENT_TYPE" value="<?=$INCREMENT_TYPE?>" /></td>
                  
                  
                  <td bgcolor="#E8E8E8" width="19%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Name of Increment :</span></td>
                  <td bgcolor="#E8E8E8" width="35%" class="oe_form_group_cell"><input name="INCREMENT_AMT" id="INCREMENT_AMT" value="<?=$INCREMENT_AMT?>" type="text" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Effect Date :</td>
                  <td class="oe_form_group_cell"><input name="INCREMENT_EFFECT_DATE" type="text" id="INCREMENT_EFFECT_DATE" value="<?=$INCREMENT_EFFECT_DATE?>" /></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Designation :</span></td>
                  <td class="oe_form_group_cell"><select name="INCREMENT_DESG">
                    <? foreign_relation('designation','DESG_ID','DESG_DESC',$INCREMENT_DESG);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td height="33" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Old Basic Amt: </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input readonly name="old_basic_salary" type="text" id="old_basic_salary" value="<?=$old_basic_salary?>" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">New Basic Amt: </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="new_basic_salary" type="text" id="new_basic_salary" value="<?=$new_basic_salary?>"  onchange="autocal()" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td height="33" colspan="1" bgcolor="#FFFFFF" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Old House Rent: </td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input readonly name="old_house_rent" type="text" id="old_house_rent" value="<?=$old_house_rent?>" /></td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell">New <span class="oe_form_group_cell oe_form_group_cell_label">House Rent:</span> </td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="new_house_rent" type="text" id="new_house_rent" value="<?=$new_house_rent?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td height="33" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Old Medical Al: </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input readonly name="old_medical_allowance" type="text" id="old_medical_allowance" value="<?=$old_medical_allowance?>" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">New <span class="oe_form_group_cell oe_form_group_cell_label">Medical Al</span>: </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="new_medical_allowance" type="text" id="new_medical_allowance" value="<?=$new_medical_allowance?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td height="33" colspan="1" bgcolor="#FFFFFF" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Old Conv.: </td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input readonly name="old_ta" type="text" id="old_ta" value="<?=$old_ta?>" /></td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell">New <span class="oe_form_group_cell oe_form_group_cell_label">Conv.</span>: </td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="new_ta" type="text" id="new_ta" value="<?=$new_ta?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td height="33" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Old City Conv.: </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input readonly name="old_da" type="text" id="old_da" value="<?=$old_da?>" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">New <span class="oe_form_group_cell oe_form_group_cell_label">City Conv.</span>: </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="new_da" type="text" id="new_da" value="<?=$new_da?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td height="33" colspan="1" bgcolor="#FFFFFF" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Old PF: </td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input readonly name="old_pf" type="text" id="old_pf" value="<?=$old_pf?>" /></td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell">New PF: </td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="new_pf" type="text" id="new_pf" value="<?=$new_pf?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td height="33" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Old PF Organiz.: </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input readonly name="old_pf_organization" type="text" id="old_pf_organization" value="<?=$old_pf_organization?>" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">New <span class="oe_form_group_cell oe_form_group_cell_label">PF Organiz.</span>: </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="new_pf_organization" type="text" id="new_pf_organization" value="<?=$new_pf_organization?>" /></td>
                </tr>
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
