<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


// ::::: Edit This Section ::::: 
$title='Salary and Allowance Information';			// Page Name and Page Title
$page="salary_information.php";		// PHP File Name
$input_page="employee_essential_information_input.php";
$root='hrm';

$table='salary_info';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='salary_type';				// For a New or Edit Data a must have data field


//do_calander('#ESSENTIAL_ISSUE_DATE');


// ::::: End Edit Section :::::


$crud      =new crud($table);


$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected'],' order by id desc limit 1');
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;


if(isset($_POST[$shown]))
{	if(isset($_POST['insert']))
		{		
				$_POST['PBI_ID']=$_SESSION['employee_selected'];
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
foreach($data as $key => $value)
{ $$key=$value;}
}



?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}</script>
	


<script>
/*$(document).ready(function(){

   $('#mobile_allowance_rules').click(function(){

     var rBtnVal = $(this).val();

     if(rBtnVal == "Fixed"){
         $("#mobile_allowance").attr("readonly", false); 
     }
     else{ 
         $("#mobile_allowance").attr("readonly", true);
		 $("#mobile_allowance").val("0.00"); 
     }
   });
});*/




$(document).ready(function(){

   $('#vehicle_allowance_rules').click(function(){

     var rBtnVal = $(this).val();

     if(rBtnVal == "Fixed"){
         $("#vehicle_allowance").attr("readonly", false); 
     }
     else{ 
         $("#vehicle_allowance").attr("readonly", true); 
		 $("#vehicle_allowance").val("0.00");
     }
   });
});






function fixed_comm(){
     var rBtnVal = document.getElementById('commission_type').value;

     if(rBtnVal == "Conditional"){
         document.getElementById('view').style.display = 'block'; 
     }
     else{ 
         document.getElementById('view').style.display = 'none'; 
		 
		 
     }

}

</script>



	<style type="text/css">
<!--
.style1 {font-weight: bold}
.style2 {color: #FF0000}
-->
    </style>
<? do_calander('#security_amnt_till_date');
   //do_calander('#action_complete_date');?>	

<form action="" method="post" enctype="multipart/form-data">
<div class="oe_view_manager oe_view_manager_current">
        
    <? include('../common/title_bar.php'); do_calander('#comm_till_date');?>
        <div class="oe_view_manager_body">
            
                <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
                      <? include('../common/input_bar.php');?>
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
                        <td width="33%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;<span class="style2">Salary Type :</span></label></td>
                        <td width="33%" class="oe_form_group_cell"><input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                          <input name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['employee_selected']?>" type="hidden" />
                          <select name="salary_type">
<? if($salary_type!='') echo '<option selected="selected">'.$salary_type.'</option>';?>
<option>Consolidated</option>
<option>Non-Consolidated</option>
                          </select></td>
                        <td width="34%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label style2">Bonus Applicable? :</span></td>
                        <td width="67%" class="oe_form_group_cell"><select name="bonus_applicable">
                        <? if($bonus_applicable!='') echo '<option selected="selected">'.$bonus_applicable.'</option>';?>
                          <option>YES</option>
                          <option>NO</option>
                        </select></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Basic : </td>
                        <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="basic_salary" type="text" id="basic_salary" value="<?=$basic_salary?>" /></td>
                        <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Overtime Applicable? :</span></td>
                        <td bgcolor="#E8E8E8" class="oe_form_group_cell">
                        <select name="overtime_applicable">
							<? if($overtime_applicable!='') echo '<option selected="selected">'.$overtime_applicable.'</option>';?>
                            <option>NO</option><option>YES</option>
                        </select></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;<span class="style2">Consolidated Salary :</span></td>
                        <td class="oe_form_group_cell"><input name="consolidated_salary" type="text" id="consolidated_salary" value="<?=$consolidated_salary?>" /></td>
                        <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">PF :</span></td>
                        <td class="oe_form_group_cell"><span class="oe_form_field oe_datepicker_root oe_form_field_date">
                          <input name="pf" type="text" id="pf" value="<?=$pf?>" />
                        </span></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;<span class="style2">Special Allowance :</span></td>
                        <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="special_allowance" type="text" id="special_allowance" value="<?=$special_allowance?>" /></td>
                        <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Income Tax :</span></td>
                        <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="income_tax" type="text" id="income_tax" value="<?=$income_tax?>" /></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;House Rent : </td>
                        <td class="oe_form_group_cell"><input name="house_rent" type="text" id="house_rent" value="<?=$house_rent?>" /></td>
                        <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Group Insurance :</span></td>
                        <td class="oe_form_group_cell"><input name="group_insurance" type="text" id="group_insurance" value="<?=$group_insurance?>" /></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;<span class="style2">TA/DA Package:</span></td>
                        <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="ta_type">
                        <? if($ta_type!='') echo '<option selected="selected">'.$ta_type.'</option>';?>
                          <option>TA / DA</option>
                          <option>TA</option>
						  <option>DA</option>
                        </select>
						
						<input name="ta" type="text" id="ta" value="<?=$ta?>" /></td>
                        <td bgcolor="#E8E8E8" class="oe_form_group_cell style2">Salary Given by :</td>
                        <td bgcolor="#E8E8E8" class="oe_form_group_cell">
						<select name="cash_bank">
                          <option selected="selected"><?=$cash_bank?></option>
                          <option>Cash</option>
                          <option>DBBL</option>
                          <option>IBBL</option>
                          <option>NCC</option>
                          <option>Bkash</option>
                          <option>Dealer</option>
						  <option>Both</option>
                        </select></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td bgcolor="#FFFFFF" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;<span class="style2">Food Allowance :</span></td>
                        <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="food_allowance" type="text" id="food_allowance" value="<?=$food_allowance?>" /></td>
                        <td bgcolor="#FFFFFF" class="oe_form_group_cell style2">Account No :</td>
                        <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="cash" type="text" id="cash" value="<?=$cash?>" /></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;<span class="style2">Mobile Allowance Rules:</span></td>
                        <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="mobile_allowance_rules" id="mobile_allowance_rules">
						<option selected value="<?=$mobile_allowance_rules?>"><?=$mobile_allowance_rules?></option>
                          <option value="Fixed Amount Company Payable">Fixed Amount Company Payable</option>
                          <option value="Fixed Amount Personal Payable">Fixed Amount Personal Payable</option>
						  <option value="Actual Company Payable">Actual Company Payable</option>
						  <option value="Fixed Ceiling and Excess Deductible">Fixed Ceiling and Excess deductible</option>
						  <option value="No Mobile Allowance">No Mobile Allowance</option>
						  <option value="Full Actual Deduction (Sales)">Full Actual Deduction (Sales)</option>
                        </select></td>
                        <td bgcolor="#E8E8E8" class="oe_form_group_cell">Branch Info :</td>
                        <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="branch_info" type="text" id="branch_info" value="<?=$branch_info?>" /></td>
                        </tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" bgcolor="#FFFFFF" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;<span class="style2">Mobile Allowance:</span></td>
                        <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="mobile_allowance" type="text" id="mobile_allowance" value="<?=$mobile_allowance?>" /></td>
                        <td bgcolor="#FFFFFF" class="oe_form_group_cell">Co-Operative Share : </td>
                        <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="cooperative_share" type="text" id="cooperative_share" value="<?=$cooperative_share?>" /></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td bgcolor="#FFFFFF" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                        <td bgcolor="#FFFFFF" class="oe_form_group_cell">&nbsp;</td>
                        <td bordercolor="#FF99FF" bgcolor="#E8E8E8" class="oe_form_group_cell">Security Deduction Amount : </td>
                        <td bordercolor="#FF99FF" bgcolor="#E8E8E8" class="oe_form_group_cell"><input placeholder="Amount" name="security_amnt" type="text" id="security_amnt" value="<?=$security_amnt?>" /></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                        <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                        <td bordercolor="#FF99FF" bgcolor="#E8E8E8" class="oe_form_group_cell">Security Deduction Till: :</td>
                        <td bordercolor="#FF99FF" bgcolor="#E8E8E8" class="oe_form_group_cell"><input  placeholder="Date" name="security_amnt_till_date" type="text" id="security_amnt_till_date" value="<?=$security_amnt_till_date?>" /></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td bgcolor="#FFFFFF" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Medical Allowance :</td>
                        <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="medical_allowance" type="text" id="medical_allowance" value="<?=$medical_allowance?>" /></td>
                        <td bordercolor="#FF99FF" bgcolor="#FFFFFF" class="oe_form_group_cell"><? if($cash_bank=='Dealer'){?>
                          Dealer : 
                            <? }?></td>
                        <td bordercolor="#FF99FF" bgcolor="#FFFFFF" class="oe_form_group_cell">
						
						<? if($cash_bank=='Dealer'){
						$area_code = find_a_field('personnel_basic_info','PBI_AREA','PBI_ID='.$_SESSION['employee_selected']);
						$group_code = find_a_field('personnel_basic_info','PBI_GROUP','PBI_ID='.$_SESSION['employee_selected']);
						?><?=find_a_field('dealer_info','concat( dealer_code ,"-",dealer_name_e,"(",product_group,")")','product_group="'.$group_code.'" and area_code="'.$area_code.'"')?>&nbsp;-&nbsp;<?=find_a_field('area','AREA_NAME','AREA_CODE='.$area_code)?><? }?></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td bgcolor="#FFFFFF" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Sales Commission : </td>
                        <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="fixed_commission" type="text" id="fixed_commission" value="<?=$fixed_commission?>" /></td>
                        <td bgcolor="#FFFFFF" class="oe_form_group_cell">Vehicle Allowance Rules :</td>
                        <td bgcolor="#FFFFFF" class="oe_form_group_cell"><select name="vehicle_allowance_rules" id="vehicle_allowance_rules">
                          <option selected value="<?=$vehicle_allowance_rules?>"><?=$vehicle_allowance_rules?></option>
                          <option value="Fixed">Fixed</option>
                          <option value="Variable">Variable</option>
                        </select></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td bgcolor="#CCCCCC" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><span class="oe_form_group_cell_label oe_form_group_cell">&nbsp;&nbsp;Commission Type :</span></td>
                        <td bgcolor="#CCCCCC" class="oe_form_group_cell"><select name="commission_type" id="commission_type" onchange="fixed_comm()">
                          <option selected="selected" value="<?=$commission_type?>"><?=$commission_type?></option>
						  
                          <option value="No Commission">No Commission</option>
                          <option value="Permanent">Permanent</option>
                          <option value="Conditional">Conditional</option>
                        </select></td>
                        <td bgcolor="#CCCCCC" class="oe_form_group_cell">Vehicle Allowance :</td>
                        <td bgcolor="#CCCCCC" class="oe_form_group_cell"><input name="vehicle_allowance" type="text" id="vehicle_allowance" value="<?=$vehicle_allowance?>" /></td>
                      </tr>
                      
                      <tr class="oe_form_group_row">
                        <td colspan="4" bgcolor="#FFFFFF" class="oe_form_group_cell_label oe_form_group_cell"><span id="view"  <?php if($commission_type=="Conditional") echo ' style="display:block"'; else echo ' style="display:none"';?> >
						<span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;</span>Commission Range: 
						<select name="min_max" id="min_max">
                          <option selected="selected" value="<?=$min_max?>"><?=$min_max?></option>
                          <option value="3 Months">3 Months</option>
                          <option value="6 Months">6 Months</option>
                          <option value="9 Months">9 Months</option>
                          <option value="12 Months">12 Months</option>
                          <option value="Till Date">Till Date</option>
                        </select>
						
						
						<span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;</span>Till Date : <input name="comm_till_date" type="text" id="comm_till_date" value="<?=$comm_till_date?>" />
						</span></td>
                        </tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" bgcolor="#FFCCFF" class="oe_form_group_cell_label oe_form_group_cell"><strong>Total Salary : </strong></td>
                        <td bgcolor="#FFCCFF" class="oe_form_group_cell">
<input name="mobile_ceiling2" type="text" class="style1" id="mobile_ceiling2" value="<?=($consolidated_salary!=0)?($consolidated_salary+$special_allowance):($basic_salary+$special_allowance+$house_rent+$ta+$mobile_allowance+$medical_allowance+($food_allowance*30))?>" readonly="" /></td>
                        <td colspan="1" bgcolor="#FFCCFF" class="oe_form_group_cell_label oe_form_group_cell"><strong>Total Payable : </strong></td>
                        <td bgcolor="#FFCCFF" class="oe_form_group_cell"><input name="total_payable" type="text" class="style1" id="total_payable" value="<?=($total_payable==0)?($basic_salary+$special_allowance):($total_payable)?>" readonly="" /></td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" bgcolor="#FFCCFF" class="oe_form_group_cell_label oe_form_group_cell">Bank:</td>
                        <td bgcolor="#FFCCFF" class="oe_form_group_cell"><input name="bank_paid" type="text" id="bank_paid" value="<?=$bank_paid?>" /></td>
                        <td bgcolor="#FFCCFF" class="oe_form_group_cell">&nbsp;</td>
                        <td bgcolor="#FFCCFF" class="oe_form_group_cell">&nbsp;</td>
                      </tr>
                      <tr class="oe_form_group_row">
                        <td colspan="1" bgcolor="#FFCCFF" class="oe_form_group_cell_label oe_form_group_cell">Cash:</td>
                        <td bgcolor="#FFCCFF" class="oe_form_group_cell"><input name="cash_paid" type="text" id="cash_paid" value="<?=$cash_paid?>" /></td>
                        <td bgcolor="#FFCCFF" class="oe_form_group_cell">&nbsp;</td>
                        <td bgcolor="#FFCCFF" class="oe_form_group_cell">&nbsp;</td>
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
require_once SERVER_CORE."routing/layout.bottom.php";
?>