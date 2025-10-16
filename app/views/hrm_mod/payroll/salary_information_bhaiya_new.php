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

$title ='Salary and Allowance Information';			
$page ="salary_information.php";		
$input_page ="employee_essential_information_input.php";
$root ='hrm';
$table ='salary_info';	// Database Table Name Mainly related to this page
$unique ='id';			// Primary Key of this Database table
$shown ='basic_salary';	// For a New or Edit Data a must have data field
$crud =new crud($table);

$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected'],' order by id desc limit 1');
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;


if(isset($_POST[$shown])){
	if(isset($_POST['insert'])){		
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

	if(isset($_POST['update'])){
				$crud->update($unique);
				$type=1;
	}
	//for Delete..................................
	if(isset($_POST['delete'])){
		$condition=$unique."=".$$unique;
		$crud->delete($condition);
		unset($$unique);
		echo '<script type="text/javascript">
		parent.parent.document.location.href = "../'.$root.'/'.$page.'";
		</script>';
		$type=1;
		$msg='Successfully Deleted.';
	}
}


if(isset($$unique)){
	$condition=$unique."=".$$unique;
	$data=db_fetch_object($table,$condition);
	foreach($data as $key => $value)
	{ $$key=$value;}
}
?>


<script type="text/javascript"> function DoNav(lk){
	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}
</script>


<script>
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
								
								<input type="hidden" id="gender"
                                value="<?=find_a_field('personnel_basic_info','PBI_SEX','PBI_ID='.$_SESSION['employee_selected']);?>"/>
								
								
                           	    <input type="text" id="basic-salary"class="form-control" oninput="calculateSalary()" required value="<?=$basic_salary?>"/>
                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">House Rent </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="house_rent" type="text" id="house-rent"
                                        class="form-control" value="<?=$house_rent?>" />
                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Medical Allowance </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="medical-allowance" type="text" id="medical-allowance" value="<?=$medical_allowance?>" class="form-control" />
                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Conveyance Allowance</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="ta" type="text" id="convenience" 
                                        class="form-control" value="<?=$ta?>" />
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
								<input name="salary_after_tax" type="text" id="tax" value="<?php echo $salary_after_tax; ?>" class="form-control console"/><span id="salary-after-tax"></span>
								
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
                                <input name="cash_amt" type="text" id="cash_amt" value="<?=$cash_amt?>" />
                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Bank Paid</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="bank_amt" type="text" id="bank_amt"  value="<?=$bank_amt?>" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
		<br />
			
	<br>
			
			
		<div class="container-fluid bg-form-titel">
            <div class="row">
                
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="form-group row m-0">
                        <label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Gross Salary</label>
                        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
                          <input name="gross_salary" type="text" id="gross-salary"
                                    class="form-control" value="<?=$gross_salary?>"/>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="form-group row m-0">
                        <label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Total Payable</label>
                        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
                            <input name="total_payable" type="text" id="total-payable" value="" readonly=""
                                    class="form-control"/>

                        </div>
                    </div>
                </div>
            </div>
        </div>       
    </div>
</form>
                                                                                                

<script>

 function calculateSalary() {
            var basicSalary = parseFloat(document.getElementById("basic-salary").value); 
            var houseRent = basicSalary * 0.5;
            var medicalAllowance = basicSalary * 0.1;
            var convenience = basicSalary * 0.15;
            var grossSalary = basicSalary + houseRent + medicalAllowance + convenience;
            var tax;
	 
	        var genders = document.getElementById('gender').value;
	 
           
	 		
	 		var male_yearly_gross = grossSalary*14;
	 		var female_yearly_gross = grossSalary*14;
	 
	 		if (genders=='Male' && male_yearly_gross>=300000){
				if (grossSalary < 80000) {
                tax = grossSalary * 0.05;
				} else if (grossSalary < 150000) {
					tax = grossSalary * 0.075;
				} else {
					tax = grossSalary * 0.1;
				}
			}
	 			 
			else if (female_yearly_gross>=350000){
				if (grossSalary < 80000) {
				tax = grossSalary * 0.05;
				} else if (grossSalary < 150000) {
					tax = grossSalary * 0.075;
				} else {
					tax = grossSalary * 0.1;
				}
			}
			else{
				tax = 0;
			}
            
            var totalPayable = grossSalary - tax;
            document.getElementById("house-rent").value = houseRent.toFixed(2);
            document.getElementById("medical-allowance").value = medicalAllowance.toFixed(2);
            document.getElementById("convenience").value = convenience.toFixed(2);
            document.getElementById("gross-salary").value = grossSalary.toFixed(2);
            document.getElementById("tax").value = tax.toFixed(2);
            document.getElementById("total-payable").value = totalPayable.toFixed(2);
        }

</script>

<? require_once SERVER_CORE."routing/layout.bottom.php"; ?>
