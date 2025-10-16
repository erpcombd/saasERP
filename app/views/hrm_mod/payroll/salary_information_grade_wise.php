<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



if(isset($_POST['button'])){

      $pbi = find_a_field('personnel_basic_info','PBI_ID','PBI_CODE="'.$_POST['employee_selected'].'"');

      echo $_SESSION['employee_selected'] = $pbi;

}



 if(isset($_POST['reset'])){

      //$pbi = find_a_field('personnel_basic_info','PBI_ID','PBI_CODE="'.$_POST['employee_selected'].'"');

      unset($_SESSION['employee_selected']);

}

// ::::: Edit This Section ::::: 

$title='Grade Wise Salary Setup';			// Page Name and Page Title

$page="salary_information.php";		// PHP File Name

$input_page="employee_essential_information_input.php";

$root='hrm';



$table='salary_info';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='basic_salary';				// For a New or Edit Data a must have data field





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
tr:nth-child(odd){
    background-color: #fff !important;
}
tr:nth-child(even){
    background-color: #fff !important;
}

    </style>
<? do_calander('#security_amnt_till_date');

   //do_calander('#action_complete_date');?>
<form action="" method="post" enctype="multipart/form-data">
  <div class="oe_view_manager oe_view_manager_current">
    <? include('../common/title_bar.php'); do_calander('#comm_till_date');?>
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
                <? include('../common/input_bar.php');?>
                <div class="oe_form_sheetbg">
                  <div class="oe_form_sheet oe_form_sheet_width">
                    <table  border="0" cellpadding="0" cellspacing="0" class="table table-bordered table-sm">
                      <tbody>
                        <tr class="oe_form_group_row">
                          <td width="19%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;<span class="style2">Salary Type :</span></label></td>
                          <td width="" class="oe_form_group_cell"><input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" class="form-control" />
                            <input name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['employee_selected']?>" type="hidden" />
                            <select name="salary_type" class="form-control">
                              <option></option>
                              <option <?=($salary_type=='Consolidated')? 'selected' : ''?>>Consolidated</option>
                              <option <?=($salary_type=='Non-Consolidated')? 'selected' : ''?>>Non-Consolidated</option>
                            </select></td>
                          <td bgcolor="#FFFFFF" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Consolidated Salary</span></td>
                          <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="consolidated_salary" type="text" id="consolidated_salary" value="<?=$consolidated_salary?>" class="form-control" /></td>
                        </tr>
						
						
						  <tr class="oe_form_group_row">
                          <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Grade:</td>
                          <td  class="oe_form_group_cell"> 
						  
						  <select name="grade" id="grade" onchange="getData2('grade_ajax.php', 'grade_year_id', document.getElementById('grade').value,<?=date('y');?>)" >
						  <option></option>
                           <? foreign_relation('grade_settings','grade','grade',$grade,' 1 group by grade order by id');?>

                           </select></td>
                          
						  
						  <td  class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"> &nbsp;&nbsp; Year No :</span></td>
                          <td  class="oe_form_group_cell">
						          <span id="grade_year_id">
						                <select name="year_no"  id="year_no" value="<?=$year_no;?>"  tabindex="2" style="width:220px;">
										
										<?  foreign_relation('grade_settings','id','year_no',$year_no,'grade="'.$grade.'"');?>
										</select>
								</span>		
										
										</td>
						  
						  
						  
                        </tr>
						

                        <tr class="oe_form_group_row">
                          <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label" style=" padding-top: 5%; ">&nbsp;&nbsp;Salary Scale Grade Wise :
                            <input name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['employee_selected']?>" type="hidden" />
						  </td>
                          <td colspan="3" class="oe_form_group_cell">
						  <div class="row">
						  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
						  <span id="grade_year_val" style=" display: contents; ">
						  <div class="col-sm-4">
						    <label for="fname">Basic :</label>
                            <input name="basic_salary" type="text" id="basic_salary" value="<?=$basic_salary?>" onclick="pf_cal()" class="form-control"  />
							</div>
							<div class="col-sm-4">
							<label for="fname">House Rent:</label>
							<input name="house_rent" type="text" id="house_rent" onclick="pf_cal()" class="form-control"  value="<?=$house_rent?>" />
							
							</div>
							
							<div class="col-sm-4">
							<label for="fname">Medical Allowance:</label>
							<input name="medical_allowance" type="text" id="medical_allowance" onclick="pf_cal()"  value="<?=$medical_allowance?>" class="form-control" />
							</div>
							<div class="col-sm-4">
							<label for="fname">Conveyance Allowance:</label>
							<input name="convenience" type="text" id="convenience" onclick="pf_cal()"  value="<?=$convenience?>" class="form-control" />
							</div>
							
							<div class="col-sm-4">
							<label for="fname">Entertainment Allowance:</label>
							<input name="entertainment" type="text" id="entertainment" onclick="pf_cal()"  value="<?=$entertainment?>" class="form-control" />
							</div>
							

							</span>
							
							<div class="col-sm-4">
							<label for="fname">Other Allowance:</label>
							<input name="other_allowance" type="text" id="other_allowance" onclick="pf_cal()"  value="<?=$other_allowance?>" class="form-control" />
							
							</div>
							</div>
							</td>
                        </tr>
						
                        <!--<tr class="oe_form_group_row">

                                          <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;<span class="style2">Special Allowance :</span></td>

                                          <td  class="oe_form_group_cell"><input name="special_allowance" type="text" id="special_allowance" value="<?=$special_allowance?>" /></td>

                                          <td  class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Income Tax :</span></td>

                                          <td  class="oe_form_group_cell"><input name="income_tax" type="text" id="income_tax" value="<?=$income_tax?>" /></td>

                                        </tr>-->
                        <tr class="oe_form_group_row">
                        
                          <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Income Tax </span></td>
                          <td class="oe_form_group_cell"><input name="income_tax" type="text" id="income_tax" value="<?=$income_tax?>" class="form-control" /></td>
						  
						  
						    <td width="" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label style2"> &nbsp;&nbsp;Overtime Applicable? :</span></td>
                          <td width="" class="oe_form_group_cell"><select name="overtime_applicable" class="form-control">
                              <option></option>
                              <option <?=($overtime_applicable=='YES')? 'selected' : ''?>>YES</option>
                              <option <?=($overtime_applicable=='NO')? 'selected' : ''?>>NO</option>
                            </select></td>
							
                        </tr>
                        <tr class="oe_form_group_row">
						
			 <td colspan="1" bgcolor="#FFFFFF" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Mobile Allowance:</td>
            <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="mobile_allowance" type="text" id="mobile_allowance" onclick="pf_cal()"  value="<?=$mobile_allowance?>" class="form-control" /></td>
                       
						  
						  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; PF (5%) :</span></td>
                          <td class="oe_form_group_cell"><span class="oe_form_field oe_datepicker_root oe_form_field_date">
                            <input name="pf" type="text" id="pf" value="<?=$pf?>" onclick="pf_cal()" class="form-control" />
                            </span></td>
							
                        
                        </tr>
                        <tr class="oe_form_group_row">
                         
                          
						  
						  <td  class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"> &nbsp;&nbsp; Account No :</span></td>
                          <td  class="oe_form_group_cell"><input name="cash" type="text" id="cash" value="<?=$cash?>" class="form-control" /></td>
						  
						  
						  
						    <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;&nbsp;Salary Given by :</span></td>
                          <td class="oe_form_group_cell"><select name="cash_bank" id="cash_bank" class="form-control">
                                              <option></option>
                                              <option <?=($cash_bank=='Bank')?'selected':'';?>>Bank</option>
                                              <option <?=($cash_bank=='Cash')?'selected':'';?>>Cash</option>
                                              <option <?=($cash_bank=='Bank+Cash')?'selected':'';?>>Bank+Cash</option>
                                            </select></td>
						  
						  
						  
                        </tr>
                        
                     
                        <tr class="oe_form_group_row">
						
						 <td bgcolor="#FFFFFF" class="oe_form_group_cell">&nbsp;&nbsp; Cash Paid</td>
                          <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="cash_amt" type="text" id="cash_amt" onclick="pf_cal()"  value="<?=$cash_amt?>" /></td>
                        
                        <td bgcolor="#FFFFFF" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Bank Paid</span></td>
                         <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="bank_amt" type="text" id="bank_amt" onclick="pf_cal()"  value="<?=$bank_amt?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <!--<td bordercolor="#FF99FF"  class="oe_form_group_cell">Security Deduction Till: :</td>

                                          <td bordercolor="#FF99FF"  class="oe_form_group_cell"><input  placeholder="Date" name="security_amnt_till_date" type="text" id="security_amnt_till_date" value="<?=$security_amnt_till_date?>" /></td>-->
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
                        <tr class="bg-info">
                          <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Gross Salary :</td>
                          <td  class="oe_form_group_cell"><input name="gross_salary" type="text" id="gross_salary" onclick="pf_cal()" value="<?=$gross_salary?>" class="form-control" /></td>
                          <td  colspan="1" class="oe_form_group_cell_label oe_form_group_cell"><strong>&nbsp;&nbsp; Total Payable : </strong></td>
                          <td  class="oe_form_group_cell"><input name="total_payable" type="text" id="total_payable" value="" readonly="" class="form-control"/></td>
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

  var food = document.getElementById('other_allowance').value;

  var entertainment = document.getElementById('entertainment').value;

  var mobile = document.getElementById('mobile_allowance').value;

  

  var gross = (+basic)+(+house)+(+conveyance)+(+medical)+(+food)+(+entertainment)+(+mobile);

  

  document.getElementById('gross_salary').value = gross;

  var mcpf = (gross*2)/100;

  var ecpf = (gross*5)/100;

  

  

  document.getElementById('pf').value = ecpf;

  //old    
  var net_pay = gross-ecpf;


  var net_pay = gross;

  document.getElementById('total_payable').value = net_pay;


 }

</script>
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>
