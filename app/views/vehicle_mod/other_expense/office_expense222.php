<?php
require_once "../../../assets/template/layout.top.php";


// ::::: Edit This Section ::::: 
$title='Salary and Allowance Information';			// Page Name and Page Title
$page="salary_information.php";		// PHP File Name
$input_page="employee_essential_information_input.php";
$root='hrm';

$table='salary_info';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='basic_salary';				// For a New or Edit Data a must have data field


//do_calander('#ESSENTIAL_ISSUE_DATE');


// ::::: End Edit Section :::::

if(isset($_POST['reset'])){
unset($_SESSION['employee_selected']);
unset($_SESSION['PBI_CODE']);
$_POST['employee_selected'] = '';
}
if(isset($_POST['button'])){
      $pbi = find_a_field('personnel_basic_info','PBI_ID','PBI_CODE="'.$_POST['employee_selected'].'"');
      $_SESSION['employee_selected'] = $_POST['employee_selected'];//$pbi;
}

create_combobox('employee_selected');

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
while (list($key, $value)=each($data))
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
    <? include('../../common/title_bar.php'); do_calander('#comm_till_date');?>
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
                <? include('../../common/input_bar.php');?>
                <div class="oe_form_sheetbg">
                  <div class="oe_form_sheet oe_form_sheet_width">
                    <h1>
                      <label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right"> <a href="home2.php" rel = "gb_page_center[940, 600]">
                      <?=$title?>
                      </a> </label>
                    </h1>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
                      <tbody>
                        <tr class="oe_form_group_row">
                          <td class="oe_form_group_cell"><table width="100%" height="364" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
                              <tbody>
                                <tr class="oe_form_group_row">
                                  <td width="100%" class="oe_form_group_cell"><table width="100%" height="279" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
                                      <tbody>
                                        <!--<tr class="oe_form_group_row">
                                          <td width="19%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;<span class="style2">Salary Type :</span></label></td>
                                          <td width="" class="oe_form_group_cell"><input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                                            <input name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['employee_selected']?>" type="hidden" />
                                            <select name="salary_type">
                                              <? if($salary_type!='') echo '<option selected="selected">'.$salary_type.'</option>';?>
                                              <option>Consolidated</option>
                                              <option>Non-Consolidated</option>
                                          </select></td>
                                          <td width="" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label style2"> &nbsp;&nbsp;Bonus Applicable? :</span></td>
                                          <td width="" class="oe_form_group_cell"><select name="bonus_applicable">
                                              <? if($bonus_applicable!='') echo '<option selected="selected">'.$bonus_applicable.'</option>';?>
                                              <option>YES</option>
                                              <option>NO</option>
                                          </select></td>
                                        </tr>-->
                                        
                                        <tr class="oe_form_group_row">
                                         
										  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Basic : <input name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['employee_selected']?>" type="hidden" /></td>
                                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
										  <input name="basic_salary" type="text" id="basic_salary" value="<?=$basic_salary?>" onclick="pf_cal()"  /></td>
                                          <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; ECPF (5%) :</span></td>
                                          <td class="oe_form_group_cell"><span class="oe_form_field oe_datepicker_root oe_form_field_date">
                                            <input name="epf" type="text" id="epf" value="<?=$epf?>" onclick="pf_cal()" />
                                            </span></td>
                                        </tr>
                                        <!--<tr class="oe_form_group_row">
                                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;<span class="style2">Special Allowance :</span></td>
                                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="special_allowance" type="text" id="special_allowance" value="<?=$special_allowance?>" /></td>
                                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Income Tax :</span></td>
                                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="income_tax" type="text" id="income_tax" value="<?=$income_tax?>" /></td>
                                        </tr>-->
                                        <tr class="oe_form_group_row">
										<td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;House Rent : </td>
                                          <td class="oe_form_group_cell"><input name="house_rent" type="text" id="house_rent" onclick="pf_cal()"  value="<?=$house_rent?>" /></td>
                                          
                                          <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp; MCPF (2%)</span></td>
                                          <td class="oe_form_group_cell"><input name="cpf" type="text" id="cpf" value="<?=$cpf?>" onclick="pf_cal()" /></td>
                                        </tr>
                                        <tr class="oe_form_group_row">
                                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Medical Allowance :</td>
<td bgcolor="#E8E8E8" class="oe_form_group_cell">
<input name="medical_allowance" type="text" id="medical_allowance" onclick="pf_cal()"  value="<?=$medical_allowance?>" /></td>
                                          <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;&nbsp;&nbsp;Salary Given by :</span></td>
                                          <td class="oe_form_group_cell"><select name="cash_bank" id="cash_bank">
										   <option></option>
                                            <option <?=($cash_bank=='Bank')?'selected':'';?>>Bank</option>
                                            <option <?=($cash_bank=='Cash')?'selected':'';?>>Cash</option>
                                          </select></td>
                                        </tr>
                                        <tr class="oe_form_group_row">
                                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Conveyance Allowance:</td>
                                          <td bgcolor="#E8E8E8" class="oe_form_group_cell">
                                            <input name="ta" type="text" id="ta" onclick="pf_cal()"  value="<?=$ta?>" /></td>
                                         <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"> &nbsp;&nbsp; Account No :</span></td>
                                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="cash" type="text" id="cash" value="<?=$cash?>" /></td>
                                        </tr>
                                        <tr class="oe_form_group_row">
                                          <td bgcolor="#FFFFFF" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Food Allowance :</td>
                                          <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="food_allowance" type="text" id="food_allowance" onclick="pf_cal()"  value="<?=$food_allowance?>" /></td>
                                          <td bgcolor="#FFFFFF" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</span></td>
                                          <td bgcolor="#FFFFFF" class="oe_form_group_cell">&nbsp;</td>
                                        </tr>
                                        
                                        <tr class="oe_form_group_row">
                                          <td colspan="1" bgcolor="#FFFFFF" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Mobile Allowance:</td>
                                          <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="mobile_allowance" type="text" id="mobile_allowance" onclick="pf_cal()"  value="<?=$mobile_allowance?>" /></td>
                                          <td bgcolor="#FFFFFF" class="oe_form_group_cell">&nbsp;&nbsp;</td>
                                          <td bgcolor="#FFFFFF" class="oe_form_group_cell">&nbsp;</td>
                                        </tr>
                                        <tr class="oe_form_group_row">
                                          <td bgcolor="#FFFFFF" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Entertainment Allowance</td>
                                          <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="entertainment" type="text" id="entertainment" onclick="pf_cal()"  value="<?=$entertainment?>" /></td>
                                          <!--<td bordercolor="#FF99FF" bgcolor="#E8E8E8" class="oe_form_group_cell">Security Deduction Amount : </td>
                                          <td bordercolor="#FF99FF" bgcolor="#E8E8E8" class="oe_form_group_cell"><input placeholder="Amount" name="security_amnt" type="text" id="security_amnt" value="<?=$security_amnt?>" /></td>-->
                                        </tr>
                                        <tr class="oe_form_group_row">
                                         
                                          <!--<td bordercolor="#FF99FF" bgcolor="#E8E8E8" class="oe_form_group_cell">Security Deduction Till: :</td>
                                          <td bordercolor="#FF99FF" bgcolor="#E8E8E8" class="oe_form_group_cell"><input  placeholder="Date" name="security_amnt_till_date" type="text" id="security_amnt_till_date" value="<?=$security_amnt_till_date?>" /></td>-->
                                        </tr>
                                        
                                        <!--<tr class="oe_form_group_row">
                                          <td bgcolor="#CCCCCC" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><span class="oe_form_group_cell_label oe_form_group_cell">&nbsp;&nbsp;Commission Type :</span></td>
                                          <td bgcolor="#CCCCCC" class="oe_form_group_cell"><select name="commission_type" id="commission_type" onchange="fixed_comm()">
                                              <option selected="selected" value="<?=$commission_type?>">
                                              <?=$commission_type?>
                                              </option>
                                              <option value="No Commission">No Commission</option>
                                              <option value="Permanent">Permanent</option>
                                              <option value="Conditional">Conditional</option>
                                            </select></td>
                                          <td bgcolor="#CCCCCC" class="oe_form_group_cell">&nbsp;&nbsp; Vehicle Allowance :</td>
                                          <td bgcolor="#CCCCCC" class="oe_form_group_cell"><input name="vehicle_allowance" type="text" id="vehicle_allowance" value="<?=$vehicle_allowance?>" /></td>
                                        </tr>-->
                                        <!--<tr class="oe_form_group_row">
                                          <td colspan="4" bgcolor="#FFFFFF" class="oe_form_group_cell_label oe_form_group_cell"><span id="view"  <?php if($commission_type=="Conditional") echo ' style="display:block"'; else echo ' style="display:none"';?> > <span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;</span>Commission Range:
                                            <select name="min_max" id="min_max">
                                              <option selected="selected" value="<?=$min_max?>">
                                              <?=$min_max?>
                                              </option>
                                              <option value="3 Months">3 Months</option>
                                              <option value="6 Months">6 Months</option>
                                              <option value="9 Months">9 Months</option>
                                              <option value="12 Months">12 Months</option>
                                              <option value="Till Date">Till Date</option>
                                            </select>
                                            <span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;</span>Till Date :
                                            <input name="comm_till_date" type="text" id="comm_till_date" value="<?=$comm_till_date?>" />
                                            </span></td>
                                        </tr>-->
                                        <tr class="oe_form_group_row">
                                         <td bgcolor="#FFCCFF" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Gross Salary :</td>
                                          <td bgcolor="#FFCCFF" class="oe_form_group_cell"><input name="gross_salary" type="text" id="gross_salary" onclick="pf_cal()" value="<?=$gross_salary?>" /></td>
                                          <td colspan="1" bgcolor="#FFCCFF" class="oe_form_group_cell_label oe_form_group_cell"><strong>&nbsp;&nbsp; Total Payable : </strong></td>
                                          <td bgcolor="#FFCCFF" class="oe_form_group_cell"><input name="total_payable" type="text" class="style1" id="total_payable" value="" readonly="" /></td>
                                        </tr>
                                        <!--<tr class="oe_form_group_row">
                                          <td colspan="1" bgcolor="#FFCCFF" class="oe_form_group_cell_label oe_form_group_cell">&nbsp;&nbsp; Bank:</td>
                                          <td bgcolor="#FFCCFF" class="oe_form_group_cell"><input name="bank_paid" type="text" id="bank_paid" value="<?=$bank_paid?>" /></td>
                                          <td bgcolor="#FFCCFF" class="oe_form_group_cell">&nbsp;&nbsp; Bonus Paid By: </td>
                                          <td bgcolor="#FFCCFF" class="oe_form_group_cell">
										  <select name="bonus_mode">
                                              <option selected="selected"><?=$bonus_mode?></option>
                                              <option>Cash</option>
                                              <option>Bank</option>
                                            </select></td>
                                        </tr>-->
                                        <!--<tr class="oe_form_group_row">
                                          <td colspan="1" bgcolor="#FFCCFF" class="oe_form_group_cell_label oe_form_group_cell">&nbsp;&nbsp; Cash:</td>
                                          <td bgcolor="#FFCCFF" class="oe_form_group_cell"><input name="cash_paid" type="text" id="cash_paid" value="<?=$cash_paid?>" /></td>
                                          <td bgcolor="#FFCCFF" class="oe_form_group_cell">&nbsp;</td>
                                          <td bgcolor="#FFCCFF" class="oe_form_group_cell">&nbsp;</td>
                                        </tr>-->
                                      </tbody>
                                  </table></td>
                                </tr>
                              </tbody>
                            </table></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
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

<script>
 function pf_cal(){
  var basic = document.getElementById('basic_salary').value;
  var house = document.getElementById('house_rent').value;
  var conveyance = document.getElementById('ta').value;
  var medical = document.getElementById('medical_allowance').value;
  var food = document.getElementById('food_allowance').value;
  var entertainment = document.getElementById('entertainment').value;
  var mobile = document.getElementById('mobile_allowance').value;
  
  var gross = (+basic)+(+house)+(+conveyance)+(+medical)+(+food)+(+entertainment)+(+mobile);
  
  document.getElementById('gross_salary').value = gross;
  var mcpf = (gross*2)/100;
  var ecpf = (gross*5)/100;
  var h = (basic*55)/100;
  var c = (basic*15)/100;
  var m = (basic*10)/100;
  var f = (basic*10)/100;
  var e = (basic*10)/100;
  
  
  document.getElementById('epf').value = ecpf;
  document.getElementById('cpf').value = mcpf;
  
  document.getElementById('house_rent').value = h;
  document.getElementById('ta').value = c;
  document.getElementById('medical_allowance').value = m;
  document.getElementById('food_allowance').value = f;
  document.getElementById('entertainment').value = e;
  var net_pay = gross-ecpf;
  document.getElementById('total_payable').value = net_pay;
  
  
  
 }
</script>
<?
require_once "../../../assets/template/layout.bottom.php";
?>
























