<?php




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";







if(isset($_POST['button'])){



      //$pbi = find_a_field('personnel_basic_info','PBI_ID','PBI_CODE="'.$_POST['employee_selected'].'"');



      $_SESSION['employee_selected'] = $_POST['employee_selected'];



}







 if(isset($_POST['reset'])){



      //$pbi = find_a_field('personnel_basic_info','PBI_ID','PBI_CODE="'.$_POST['employee_selected'].'"');



      unset($_SESSION['employee_selected']);



}



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





<!--<style type="text/css">







.style1 {font-weight: bold}



.style2 {color: #FF0000}







    </style>-->

	

	



<? do_calander('#security_amnt_till_date');



   //do_calander('#action_complete_date');?>

   

   

   

   <form action="" method="post" enctype="multipart/form-data">

    <div class="form-container_large">

		 <? include('../common/title_bar.php'); do_calander('#comm_till_date');?>

		 <? include('../common/input_bar.php');?>

        <h4 class="text-center bg-titel bold pt-2 pb-2"> Select Options </h4>

        <div class="container-fluid bg-form-titel">

            <div class="row">

                <!--left form-->

                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                    <div class="container n-form2">

       

                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Salary Type :</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" class="form-control" />

								<input name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['employee_selected']?>" type="hidden" />

								<select name="salary_type" class="form-control">

								  <option></option>

								  <option <?=($salary_type=='Consolidated')? 'selected' : ''?>>Consolidated</option>

								  <option <?=($salary_type=='Non-Consolidated')? 'selected' : ''?>>Non-Consolidated</option>

								</select>

                            </div>

                        </div>

						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Basic</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />

                           	    <input name="basic_salary" type="text" id="basic_salary" class="console" value="<?=$basic_salary?>" onclick="pf_cal()" class="form-control"  />

                            </div>

                        </div>

						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">House Rent </label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <input name="house_rent" type="text" id="house_rent" class="console" onclick="pf_cal()" class="form-control"  value="<?=$house_rent?>" />

                            </div>

                        </div>

						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Medical Allowance </label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <input name="medical_allowance" type="text" id="medical_allowance" class="console" onclick="pf_cal()"  value="<?=$medical_allowance?>" class="form-control" />

                            </div>

                        </div>

						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Conveyance Allowance</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <input name="ta" type="text" id="ta" class="console" onclick="pf_cal()"  value="<?=$ta?>" class="form-control" />

                            </div>

                      </div>

						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Food Allowance</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <input name="food_allowance" type="text" id="food_allowance" class="console" onclick="pf_cal()"  value="<?=$food_allowance?>" class="form-control" />

                            </div>

                      </div>

						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Mobile Allowance:</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <input name="mobile_allowance" type="text" id="mobile_allowance" class="console" onclick="pf_cal()"  value="<?=$mobile_allowance?>" class="form-control" />

                            </div>

                      </div>

					  <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Entertainment Allowance</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <input name="entertainment" type="text" id="entertainment" class="console" onclick="pf_cal()"  value="<?=$entertainment?>" class="form-control" />

                            </div>

                      </div>

						









                    </div>

                </div>



                <!--Right form-->

                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                    <div class="container n-form2">

                       



                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Consolidated Salary</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <input name="consolidated_salary" type="text" id="consolidated_salary" value="<?=$consolidated_salary?>" class="form-control" />

                            </div>

                      </div>

						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Overtime Applicable?</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <select name="overtime_applicable" class="form-control">

								  <option></option>

								  <option <?=($overtime_applicable=='YES')? 'selected' : ''?>>YES</option>

								  <option <?=($overtime_applicable=='NO')? 'selected' : ''?>>NO</option>

								</select>

                            </div>

                        </div>

						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Income Tax</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <input name="income_tax" type="text" id="income_tax" class="console" value="<?=$income_tax?>" class="form-control" />

                            </div>

                        </div>

						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> PF (5%)</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                 <input name="pf" type="text" id="pf" value="<?=$pf?>" onclick="pf_cal()" class="console" />

                            </div>

                        </div>

						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Account No </label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <input name="cash" type="text" id="cash" value="<?=$cash?>" class="form-control" />

                            </div>

                        </div>

						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Salary Given by</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <select name="cash_bank" id="cash_bank" class="form-control">

                                              <option></option>

                                              <option <?=($cash_bank=='Bank')?'selected':'';?>>Bank</option>

                                              <option <?=($cash_bank=='Cash')?'selected':'';?>>Cash</option>

                                              <option <?=($cash_bank=='Bank+Cash')?'selected':'';?>>Bank+Cash</option>

                                </select>

                            </div>

                        </div>

						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Cash Paid</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <input name="cash_amt" type="text" id="cash_amt" onclick="pf_cal()"  value="<?=$cash_amt?>" />

                            </div>

                        </div>

						

						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Bank Paid</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <input name="bank_amt" type="text" id="bank_amt" onclick="pf_cal()"  value="<?=$bank_amt?>" />

                            </div>

                        </div>











                    </div>

                </div>





            </div>



        </div>

		<br />

		<div class="container-fluid bg-form-titel">

            <div class="row">

                

                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                    <div class="form-group row m-0">

                        <label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Gross Salary</label>

                        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">

                          <input name="gross_salary" type="text" id="gross_salary" onclick="pf_cal()" onkeyup="count()" value="<?=$gross_salary?>" class="form-control" />

                        </div>

                    </div>

                </div>



                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                    <div class="form-group row m-0">

                        <label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Total Payable</label>

                        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">

                            <input name="total_payable" type="text" id="total_payable" value="" readonly="" class="form-control"/>



                        </div>

                    </div>

                </div>



            </div>

        </div>

		



        

    </div>



</form>

   

   

   

<?php /*?><form action="" method="post" enctype="multipart/form-data">

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

                          <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Basic :

                            <input name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['employee_selected']?>" type="hidden" /></td>

                          <td  class="oe_form_group_cell"><input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />

                            <input name="basic_salary" type="text" id="basic_salary" value="<?=$basic_salary?>" onclick="pf_cal()" class="form-control"  /></td>

                          <td width="" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label style2"> &nbsp;&nbsp;Overtime Applicable? :</span></td>

                          <td width="" class="oe_form_group_cell"><select name="overtime_applicable" class="form-control">

                              <option></option>

                              <option <?=($overtime_applicable=='YES')? 'selected' : ''?>>YES</option>

                              <option <?=($overtime_applicable=='NO')? 'selected' : ''?>>NO</option>

                            </select></td>

                        </tr><?php */?>

                        <!--<tr class="oe_form_group_row">



                                          <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;<span class="style2">Special Allowance :</span></td>



                                          <td  class="oe_form_group_cell"><input name="special_allowance" type="text" id="special_allowance" value="<?=$special_allowance?>" /></td>



                                          <td  class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Income Tax :</span></td>



                                          <td  class="oe_form_group_cell"><input name="income_tax" type="text" id="income_tax" value="<?=$income_tax?>" /></td>



                                        </tr>-->

                        <?php /*?><tr class="oe_form_group_row">

                          <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;House Rent : </td>

                          <td class="oe_form_group_cell"><input name="house_rent" type="text" id="house_rent" onclick="pf_cal()" class="form-control"  value="<?=$house_rent?>" /></td>

                          <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Income Tax </span></td>

                          <td class="oe_form_group_cell"><input name="income_tax" type="text" id="income_tax" value="<?=$income_tax?>" class="form-control" /></td>

                        </tr>

                        <tr class="oe_form_group_row">

                          <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Medical Allowance :</td>

                          <td  class="oe_form_group_cell"><input name="medical_allowance" type="text" id="medical_allowance" onclick="pf_cal()"  value="<?=$medical_allowance?>" class="form-control" /></td>

						  

						  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; PF (5%) :</span></td>

                          <td class="oe_form_group_cell"><span class="oe_form_field oe_datepicker_root oe_form_field_date"><?php */?>

                           <?php /*?> <input name="pf" type="text" id="pf" value="<?=$pf?>" onclick="pf_cal()" class="form-control" /><?php */?>

                            </span></td>

							

                        

                       <?php /*?> </tr>

                        <tr class="oe_form_group_row">

                          <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Conveyance Allowance:</td>

                          <td  class="oe_form_group_cell"><input name="ta" type="text" id="ta" onclick="pf_cal()"  value="<?=$ta?>" class="form-control" /></td>

                          

						  

						  <td  class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"> &nbsp;&nbsp; Account No :</span></td>

                          <td  class="oe_form_group_cell"><input name="cash" type="text" id="cash" value="<?=$cash?>" class="form-control" /></td>

						  

						  

						  

                        </tr>

                        <tr class="oe_form_group_row">

                          <td bgcolor="#FFFFFF" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Food Allowance :</td>

                          <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="food_allowance" type="text" id="food_allowance" onclick="pf_cal()"  value="<?=$food_allowance?>" class="form-control" /></td>

                          

						  

						  

						    <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;&nbsp;Salary Given by :</span></td>

                          <td class="oe_form_group_cell"><select name="cash_bank" id="cash_bank" class="form-control">

                                              <option></option>

                                              <option <?=($cash_bank=='Bank')?'selected':'';?>>Bank</option>

                                              <option <?=($cash_bank=='Cash')?'selected':'';?>>Cash</option>

                                              <option <?=($cash_bank=='Bank+Cash')?'selected':'';?>>Bank+Cash</option>

                                            </select></td>

											

                        </tr>

                        <tr class="oe_form_group_row">

                          <td colspan="1" bgcolor="#FFFFFF" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Mobile Allowance:</td>

                          <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="mobile_allowance" type="text" id="mobile_allowance" onclick="pf_cal()"  value="<?=$mobile_allowance?>" class="form-control" /></td>                     <td bgcolor="#FFFFFF" class="oe_form_group_cell">&nbsp;&nbsp; Cash Paid</td>

                          <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="cash_amt" type="text" id="cash_amt" onclick="pf_cal()"  value="<?=$cash_amt?>" /></td>

                        </tr>

                        <tr class="oe_form_group_row">

                          <td bgcolor="#FFFFFF" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Entertainment Allowance</td>

                          <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="entertainment" type="text" id="entertainment" onclick="pf_cal()"  value="<?=$entertainment?>" class="form-control" /></td>

                        <td bgcolor="#FFFFFF" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Bank Paid</span></td>

                         <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="bank_amt" type="text" id="bank_amt" onclick="pf_cal()"  value="<?=$bank_amt?>" /></td>

                        </tr><?php */?>

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

                       <?php /*?> <tr class="bg-info">

                          <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Gross Salary :</td>

                          <td  class="oe_form_group_cell"><input name="gross_salary" type="text" id="gross_salary" onclick="pf_cal()" value="<?=$gross_salary?>" class="form-control" /></td>

                          <td  colspan="1" class="oe_form_group_cell_label oe_form_group_cell"><strong>&nbsp;&nbsp; Total Payable : </strong></td>

                          <td  class="oe_form_group_cell"><input name="total_payable" type="text" id="total_payable" value="" readonly="" class="form-control"/></td>

                        </tr><?php */?>

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

                     <?php /*?> </tbody>

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

</form><?php */?>







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



  



  



  //document.getElementById('pf').value = ecpf;



  //old    var net_pay = gross-ecpf;





  var net_pay = gross;



  document.getElementById('total_payable').value = net_pay;



 



 }

 

 

 

function count()







{







var num=((document.getElementById('gross_salary').value)*1);





document.getElementById('basic_salary').value = ((num*60)/100);



document.getElementById('house_rent').value = ((num*30)/100);



document.getElementById('medical_allowance').value = ((num*5)/100);



document.getElementById('ta').value = ((num*5)/100);







}



</script>

<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>

