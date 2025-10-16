<?php
session_start();
ob_start();
require_once "../../config/inc.all.php";


// ::::: Edit This Section ::::: 
$title='Salary and Allowance Information';			// Page Name and Page Title
$page="salary_information.php";		// PHP File Name
$input_page="employee_essential_information_input.php";
$root='payroll';

$table='salary_info';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='salary_type';				// For a New or Edit Data a must have data field


//do_calander('#ESSENTIAL_ISSUE_DATE');

$employee_selected = $_SESSION['employee_selected'];
// ::::: End Edit Section :::::
if($employee_selected>0){
$ab="SELECT a.PBI_NAME as name, b.DOMAIN_DESC as company_name, c.DEPT_DESC as department, d.DESG_DESC as designation FROM personnel_basic_info a, domai b, department c, designation d WHERE a.PBI_DOMAIN=b.DOMAIN_CODE and a.PBI_DEPARTMENT=c.DEPT_ID and a.PBI_DESIGNATION=d.DESG_ID and a.PBI_ID=$employee_selected";
$data=mysql_query($ab);
$view=mysql_fetch_object($data);
}

if($_GET['remove']=='selected'){ unset($_SESSION['employee_selected']);}
$crud      =new crud($table);


$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected'],' order by id desc limit 1');
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;


if(isset($_POST[$shown]))
{	if(isset($_POST['insert']))
		{		
				$_REQUEST['PBI_ID']=$_SESSION['employee_selected'];
				$crud->insert();
				$type=1;
				$msg='New Entry Successfully Inserted.';
				unset($_POST);
				unset($$unique);
$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected'],' order by id desc limit 1');
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;
		}
		
	//for Modify..................................
	if(isset($_POST['update']))
	{
	$fromEmail = 'info@cloudsoftbd.com';  	
    $toEmail = 'ceo@cloudsoftbd.com'; 
    $EmailSubject = 'Salary Update Notification';
	
	$_SESSION['employee_selected'];
	
//	$old_salary = find_a_field('salary_info','consolidated_salary','id='.$$unique);
//	$new_salary = $_POST["consolidated_salary"];
//	$emp = find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);
//  $MESSAGE_BODY .= "Employee ID :".$_SESSION['employee_selected']." <br/>";
//	$MESSAGE_BODY .= "Employee Name  :".$emp->PBI_NAME." <br/>";
//	$MESSAGE_BODY .= "Company Name :".find_a_field('domai','DOMAIN_DESC','DOMAIN_CODE='.$emp->PBI_DOMAIN)."<br/>";
//	$MESSAGE_BODY .= "Department :".find_a_field('department','DEPT_DESC','DEPT_ID='.$emp->PBI_DEPARTMENT)."<br/>";
//	$MESSAGE_BODY .= "Designation :".find_a_field('designation','DESG_DESC','DESG_ID='.$emp->PBI_DESIGNATION)."<br/>";
//	$MESSAGE_BODY .= "Old Salary :".$old_salary."<br/>";
//	$MESSAGE_BODY .= "New Salary :".$new_salary."<br/>";
	
				//sendMail($fromEmail,$toEmail,$EmailSubject,$MESSAGE_BODY);
				$crud->update($unique);
				$type=1;
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

?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}
	
	function autocal(){
	var basic = document.getElementById('basic_salary').value;
	var special_allowance = document.getElementById('special_allowance').value;
	var ta = document.getElementById('ta').value;
	var da = document.getElementById('da').value;
	var others = document.getElementById('others').value;
	var food_allowance = document.getElementById('food_allowance').value;
	var mobile_allowance = document.getElementById('mobile_allowance').value;
	var medical_allowance = document.getElementById('medical_allowance').value;
	var group_insurance = document.getElementById('group_insurance').value;
	var cfund = document.getElementById('cfund').value;
	var security_amount = document.getElementById('security_amount').value;
	var income_tax = document.getElementById('income_tax').value;
		if(basic>0){
		var house_rent=(basic*1)*(.6);
		var pf=(basic*1)*(.1);
		
			if(basic>3499)	{	var pf_organization=(basic*1)*(.1);}
			else			{   var pf_organization=350;}
		
		var consolidated_salary = 
((+basic*1) +   (+house_rent*1) +   (+special_allowance*1) +   (+ta*1)+   (+da*1) +   (+others*1) +   (+food_allowance*1)+   (+mobile_allowance*1) +   (+medical_allowance*1) )
 +  
((+pf*1) + (+pf_organization*1) +  (+group_insurance*1) + (+cfund*1)+ (+security_amount*1)+ (+income_tax*1));
		
		document.getElementById('house_rent').value = house_rent.toFixed(2);
		document.getElementById('pf').value = pf.toFixed(2);
		document.getElementById('pf_organization').value = pf_organization.toFixed(2);
		document.getElementById('consolidated_salary').value = consolidated_salary.toFixed(2);
		}
	 
	}</script>

<form action="?" method="post" enctype="multipart/form-data">
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
          </h1><table width="987" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
            <tbody><tr class="oe_form_group_row">
            <td class="oe_form_group_cell"><table width="858" height="364" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
              <tbody>
                <tr class="oe_form_group_row">
                  <td class="oe_form_group_cell"><table width="100%" height="279" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
                    <tbody>
                        <tr class="oe_form_group_row">
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Name : </td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="name1" id="name1" type="text" value="<?=$view->name;?>" readonly="readonly"/></td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell">Company Name :</td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="com_name" id="com_name" type="text" value="<?=$view->company_name;?>" readonly="readonly"/></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Department : </td>
                          <td class="oe_form_group_cell">
						  <input name="com_namea" id="com_namea" type="text" value="<?=$view->department;?>" readonly="readonly"/>						  </td>
                          <td class="oe_form_group_cell">Designation :</td>
                          <td class="oe_form_group_cell">
						  <input name="com_nameaa" id="com_nameaa" type="text" value="<?=$view->designation;?>" readonly="readonly"/>						  </td>
                        </tr>
                        <tr bgcolor="blue" class="oe_form_group_row">
                          <td colspan="4" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                          </tr>
                        <tr class="oe_form_group_row">
                          <td width="33%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;Salary Type :</label></td>
                          <td width="33%" class="oe_form_group_cell">
                          <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                          <input name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['employee_selected']?>" type="hidden" />
                            <select name="salary_type">
                            <option><?=$salary_type?></option>
                              <option>Consolidated</option>
                              <option>Non-Consolidated</option>
                              </select></td>
                          <td width="34%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Bonus Applicable? :</span></td>
                          <td width="67%" class="oe_form_group_cell"><select name="bonus_applicable">
                            <option selected="selected">
                              <?=$bonus_applicable?>
                              </option>
                            <option>YES</option>
                            <option>NO</option>
                          </select></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Consolidated Salary :</td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="consolidated_salary" readonly="" type="text" id="consolidated_salary" value="<?=$consolidated_salary?>" /></td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Overtime Applicable? :</span></td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="overtime_applicable">
                            <option selected="selected">
                              <?=$overtime_applicable?>
                              </option>
                            <option>YES</option>
                            <option>NO</option>
                          </select></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Basic : </td>
                          <td class="oe_form_group_cell"><input name="basic_salary" type="text" id="basic_salary" value="<?=$basic_salary?>" onchange="autocal()" /></td>
                          <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">PF (Own):</span></td>
                          <td class="oe_form_group_cell"><span class="oe_form_field oe_datepicker_root oe_form_field_date">
                            <input name="pf" type="text" id="pf" value="<?=$pf?>" readonly="" />
                          </span></td>
                        </tr>
                       <tr class="oe_form_group_row">
                        <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;House Rent :</td>
                        <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="house_rent" type="text" id="house_rent" value="<?=$house_rent?>" readonly="" /></td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell">PF Organization : </td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_field oe_datepicker_root oe_form_field_date"><input name="pf_organization" type="text" id="pf_organization" value="<?=$pf_organization?>" readonly="" /></span></td>
                       </tr>
                        <tr class="oe_form_group_row">
                          <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Special Allowance :</td>
                          <td class="oe_form_group_cell"><input name="special_allowance" type="text" id="special_allowance" value="<?=$special_allowance?>" onchange="autocal()" /></td>
                          <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Group Insurance :</span></td>
                          <td class="oe_form_group_cell"><input name="group_insurance" type="text" id="group_insurance" value="<?=$group_insurance?>" onchange="autocal()" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Conveyance Allowance:</td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="ta" type="text" id="ta" value="<?=$ta?>"  onchange="autocal()"/></td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"> Other Fund : </span></td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="cfund" type="text" id="cfund" value="<?=$cfund?>"  onchange="autocal()"/></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;City Allowance. :</td>
                          <td class="oe_form_group_cell">
  <input name="da" type="text" id="da" value="<?=$da?>"   onchange="autocal()"/>                            </td>
                          <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">  Cash/Bank :</span></td>
                          <td class="oe_form_group_cell"><select name="cash">
                            <option selected="selected">
                              <?=$cash?>
                              </option>
                            <option>Cash</option>
                            <option>Bank</option>
                          </select></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Other Allowance :</td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="others" type="text" id="others" value="<?=$others?>"  onchange="autocal()"/></td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Bank Name</span>(if bank) :</td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="cash_bank" type="text" id="cash_bank" value="<?=$cash_bank?>"  onchange="autocal()"/></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td bgcolor="#FFFFFF" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Food Allowance :</td>
                          <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="food_allowance" type="text" id="food_allowance" value="<?=$food_allowance?>"  onchange="autocal()"/></td>
                          <td bgcolor="#FFFFFF" class="oe_form_group_cell">Security Amount :</td>
                          <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="security_amount" type="text" id="security_amount" value="<?=$security_amount?>"  onchange="autocal()"/></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Mobile Allowance :</td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="mobile_allowance" type="text" id="mobile_allowance" value="<?=$mobile_allowance?>"  onchange="autocal()" /></td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Income Tax :</span></td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="income_tax" type="text" id="income_tax" value="<?=$income_tax?>"  onchange="autocal()" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td bgcolor="#FFFFFF" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Medical Allowance :</td>
                          <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="medical_allowance" type="text" id="medical_allowance" value="<?=$medical_allowance?>"  onchange="autocal()" /></td>
                          <td bgcolor="#FFFFFF" class="oe_form_group_cell">&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="oe_form_group_cell">&nbsp;</td>
                        </tr>
                      </tbody>
                  </table></td>
                  </tr>
              </tbody>
            </table>            </td>
            </tr></tbody></table>
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
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>