<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


if (isset($_POST['button'])) {

    //$pbi = find_a_field('personnel_basic_info','PBI_ID','PBI_CODE="'.$_POST['employee_selected'].'"');

    $_SESSION['employee_selected'] = find_a_field('personnel_basic_info', 'PBI_ID', 'PBI_CODE="' . $_POST['employee_selected'] . '"');
}



if (isset($_POST['reset'])) {

    //$pbi = find_a_field('personnel_basic_info','PBI_ID','PBI_CODE="'.$_POST['employee_selected'].'"');

    unset($_SESSION['employee_selected']);
}



// ::::: Edit This Section ::::: 



$title = 'Salary and Allowance Information';

$page = "salary_information.php";

$input_page = "employee_essential_information_input.php";

$root = 'hrm';

$table = 'salary_info';    // Database Table Name Mainly related to this page

$unique = 'id';            // Primary Key of this Database table

$shown = 'basic_salary';    // For a New or Edit Data a must have data field

$crud = new crud($table);

$image_path = find_all_field('personnel_basic_info', '', 'PBI_ID="' . $_SESSION['employee_selected'] . '"');

$required_id = find_a_field($table, $unique, 'PBI_ID=' . $_SESSION['employee_selected'], ' order by id desc limit 1');
if ($required_id > 0)
    $$unique = $_GET[$unique] = $required_id;





if (isset($_POST[$shown])) {

    if (isset($_POST['insert'])) {


        $_POST['PBI_ID'] = $_SESSION['employee_selected'];

        $crud->insert();

        $type = 1;

        $msg = 'New Entry Successfully Inserted.';

        unset($_POST);

        unset($$unique);



        $required_id = find_a_field($table, $unique, 'PBI_ID=' . $_SESSION['employee_selected'], ' order by id desc limit 1');

        if ($required_id > 0)

            $$unique = $_GET[$unique] = $required_id;
    }

    //for Modify..................................



    if (isset($_POST['update'])) {

        $crud->update($unique);

        $type = 1;
    }

    //for Delete..................................

    if (isset($_POST['delete'])) {

        $condition = $unique . "=" . $$unique;

        $crud->delete($condition);

        unset($$unique);

        echo '<script type="text/javascript">

		parent.parent.document.location.href = "../' . $root . '/' . $page . '";

		</script>';

        $type = 1;

        $msg = 'Successfully Deleted.';
    }
}




if (isset($$unique)) {

	$condition = $unique . "=" . $$unique;

	$data = db_fetch_object($table, $condition);

	foreach($data as $key => $value){

		$$key = $value;
	}
}

?>





<script type="text/javascript">
    function DoNav(lk) {

        return GB_show('ggg', '../pages/<?= $root ?>/<?= $input_page ?>?<?= $unique ?>=' + lk, 600, 940)

    }
</script>





<script>
    $(document).ready(function() {

        $('#vehicle_allowance_rules').click(function() {

            var rBtnVal = $(this).val();

            if (rBtnVal == "Fixed") {

                $("#vehicle_allowance").attr("readonly", false);

            } else {

                $("#vehicle_allowance").attr("readonly", true);

                $("#vehicle_allowance").val("0.00");

            }

        });

    });





    function fixed_comm() {

        var rBtnVal = document.getElementById('commission_type').value;

        if (rBtnVal == "Conditional") {

            document.getElementById('view').style.display = 'block';

        } else {

            document.getElementById('view').style.display = 'none';

        }

    }
</script>


<style>
    .new-color {
    background-color: #E3F1FD !important;
}
.new-bg-color {
    background-color: white !important;
    border-radius: 6px !important;
}
.card .card-header, .new-header{
    text-align: center;
    color: #000;
    background-color: #81c8ff;
}
</style>


<style type="text/css">

.style1{color: #FF0000;}

.oe_form_group_cell{padding:8px;}

.label {font-weight:bold;}

.new-color{ 

    background-color: #E3F1FD !important;
}

.new-bg-color{
    background-color: white;
    border-radius: 6px;
    padding-top: 1rem !important;
    padding-bottom: 1rem !important;
}

.h_titel{
    background-color: #81C8FF !important;
    color: #333;
}

.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color:#fff !important;

    background-color: #004d89 !important;
    border-radius: 0px;
} 
.search-bgc{
    background-color: #81c8ff !important;
    color: #333 !important;
}

.new-sr .nav-item{
   border: 1px solid #7a7a7a;
}
.nav-item .nav-link:hover, .nav-pills .nav-link.active:hover, .nav-pills .show>.nav-link:hover {
    background-color: #81c8ff !important;
    color: #333 !important;
    border-radius: 0px;
}

</style>


<? do_calander('#security_amnt_till_date');

//do_calander('#action_complete_date');

?>



<form action="" method="post" enctype="multipart/form-data">

    <div class="form-container_large">


        <? include('../common/title_bar.php');
        do_calander('#comm_till_date'); ?>

        <? include('../common/input_bar.php'); ?>



       <div class="mt-3 mb-0" data-sr-id="2"  style=" zoom: 77%; visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s; border-radius: 0px !important; border: 0px !important; background-color: #fff; box-shadow: none !important;">
                            <div class="d-flex">
                              <ul class="nav new-sr nav-pills">
 <li class="nav-item"><a class="nav-link" href="../hrm/employee_basic_information_nal.php" style="color:#333;font-weight:bold"> <i class="fa-solid fa-pen-to-square"></i> EMPLOYEE  </a></li>
 
<li class="nav-item"><a class="nav-link" href="../hrm/employee_basic_information_nal.php" style="color:#333;font-weight:bold"> <i class="fa-solid fa-business-time"></i> WORK </a></li>


<li class="nav-item"><a class="nav-link" href="../hrm/employee_basic_information_nal.php"  style="color:#333;font-weight:bold">
 <i class="fa-solid fa-envelope-open"></i> PERSONAL INFORMATION </a></li>

 <li class="nav-item"><a class="nav-link" href="../hrm/employee_basic_information_nal.php"  style="color:#333;font-weight:bold"> <i class="fa-regular fa-clock"></i> SHIFT</a></li>
 
 <li class="nav-item"><a class="nav-link" href="../hrm/employee_basic_information_nal.php"  style="color:#333;font-weight:bold"> <i class="fa-solid fa-person-chalkboard"></i> EMPLOYEE RELIEVING INFO</a></li>
 
 <li class="nav-item"><a class="nav-link" href="../hrm/employee_basic_information_nal.php"  style="color:#333;font-weight:bold"> <i class="fa-solid fa-chart-user"></i> REFERANCE</a></li>

 <li class="nav-item"><a class="nav-link" href="../hrm/employee_basic_information_nal.php"  style="color:#333;font-weight:bold"> <i class="fa-regular fa-folder-open"></i> FILES UPLOAD</a></li>
 
 
 <li class="nav-item"><a class="nav-link active" href="salary_info.php"  style="color:#333;font-weight:bold"> <i class="fa-regular fa-folder-open"></i> SALARY </a></li>
                
                              </ul>
                            </div>
                          </div>

        <div class="container-fluid bg-form-titel">

            <div class="row">



                <!--left form-->

                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                    <div class="container n-form2">

                        <!--<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Salary Type :</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                         



                                <select name="salary_type" class="form-control">

                                    <option></option>

                                    <option <?= ($salary_type == 'Consolidated') ? 'selected' : '' ?>>Consolidated</option>

                                    <option <?= ($salary_type == 'Non-Consolidated') ? 'selected' : '' ?>>Non-Consolidated</option>

                                </select>

                            </div>

                        </div>-->
											
						
						
						<div class="form-group row m-0 pb-1">
							
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Gross Salary :</label>
						

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">	
							
	

      <input name="PBI_ID" id="PBI_ID" value="<?= $_SESSION['employee_selected'] ?>" type="hidden" />
     <input name="<?= $unique ?>" id="<?= $unique ?>" value="<?= $$unique ?>" type="hidden"/>
	 <input name="gross_salary" type="text" id="gross-salary" class="form-control" oninput="calculateSalary(); calculateSalaryTax();" value="<?= $gross_salary ?>"/>	
	 
	 							
                            </div>
							
                        </div>



                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Basic :</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="<?= $unique ?>" id="<?= $unique ?>" value="<?= $$unique ?>" type="hidden" />

             <input type="hidden" id="gender" value="<?= find_a_field('personnel_basic_info', 'PBI_SEX', 'PBI_ID=' . $_SESSION['employee_selected']); ?>" />

                                <input type="text" name="basic_salary" id="basic-salary" class="form-control" readonly="" value="<?= $basic_salary ?>" />
                            </div>
                        </div>



                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">House Rent :</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <input name="house_rent" type="text" id="house_rent" class="form-control" readonly="" value="<?= $house_rent ?>" />

                            </div>

                        </div>



                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Medical Allowance :</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <input name="medical_allowance" type="text" id="medical_allowance" readonly="" value="<?= $medical_allowance ?>" class="form-control" />

                            </div>

                        </div>



                        <div class="form-group row m-0 pb-1">

      <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Conveyance Allowance :</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <input name="ta" type="text" id="convenience" class="form-control" readonly="" value="<?= $ta; ?>" />

                            </div>

                        </div>
						
						
						
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">
								Food Allowance:
							</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input name="food_allowance" type="text" id="food_allowance" class="form-control"  value="<?=$food_allowance?>" />
							</div>
						</div>
						
						
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">
								Special Allowance:
							</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input name="special_allowance" type="text" id="special_allowance" class="form-control"  value="<?=$special_allowance?>" />
							</div>
						</div>
						
						
						
							<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">
								Mobile Allowance:
							</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input name="mobile_allowance" type="text" id="mobile_allowance" class="form-control"  value="<?=$mobile_allowance?>" />
							</div>
						</div>
						
						
						
							<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">
								Personal PF :
							</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
								<input name="pf" type="text" id="personal-pf" value="<?= $pf ?>" class="form-control" />
							</div>
						</div>


						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">
								Company PF :
							</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
								<input name="pf_company" type="text" id="company-pf" value="<?= $pf_company ?>" class="form-control" />
							</div>
						</div>

                    </div>

                </div>





                <!--Right form-->

                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                    <div class="container n-form2">





                        <!--<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Consolidated Salary :</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <input name="consolidated_salary" type="text" id="consolidated_salary" value="<?= $consolidated_salary ?>" class="form-control" />

                            </div>

                        </div>-->



                        <div class="form-row">
          
        
         <div class="form-group col-sm-4">
        <label>OT Applicable Out </label>
        <select name="overtime_applicable" id="overtime_applicable" class="form-control">
        <option <?= ($overtime_applicable == 'NO') ? 'selected' : '' ?>>NO</option>
        <option <?= ($overtime_applicable == 'YES') ? 'selected' : '' ?>>YES</option>
        </select>
        </div>
        
        
          <div class="form-group col-sm-4">
            <label>OT Holiday</label>
            <select name="ot_holiday_applicable" id="ot_holiday_applicable" class="form-control">
              <option <?= ($ot_holiday_applicable == 'NO') ? 'selected' : '' ?>>NO</option>
              <option <?= ($ot_holiday_applicable == 'YES') ? 'selected' : '' ?>>YES</option>
            </select>
          </div>
          <div class="form-group col-sm-4">
            <label>OT Weekend</label>
            <select name="ot_weekend_applicable" id="ot_weekend_applicable" class="form-control">
              <option <?= ($ot_weekend_applicable == 'NO') ? 'selected' : '' ?>>NO</option>
              <option <?= ($ot_weekend_applicable == 'YES') ? 'selected' : '' ?>>YES</option>
            </select>
          </div>
       
        
        
        
        </div>



                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Monthly Income Tax :</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

      <input name="income_tax" type="text" id="monthly_tax" min="0" value="<?= $income_tax; ?>" class="form-control console" />
	  
	  
	  <span id="salary-after-tax"></span>

                            </div>

                        </div>





                       <div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">
								Bank Name :
							</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<select name="bank_name" id="bank_name" class="form-control">
									<option></option>
									<?
									foreign_relation('bank', 'BANK_CODE', 'BANK_NAME', $bank_name, ' 1 order by BANK_NAME');
									?>
								</select>
							</div>
						</div>



                        <div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">
								Account No :
							</label>

							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input name="ac_no" type="text" id="ac_no" value="<?= $ac_no ?>" class="form-control" />
							</div>
						</div>
						
						
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">
								Receiving Bank Code :
							</label>

							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input name="receiving_bank_code" type="text" id="receiving_bank_code" value="<?= $receiving_bank_code ?>" class="form-control" />
							</div>
						</div>
						
						
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">
								Receiving Bank Name :
							</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<select name="receiving_bank_name" id="receiving_bank_name" class="form-control">
									<option></option>
									<?
									foreign_relation('bank', 'BANK_CODE', 'BANK_NAME', $receiving_bank_name, ' 1 order by BANK_NAME');
									?>
								</select>
							</div>
						</div>



                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Salary Given by :</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <select name="cash_bank" id="cash_bank" class="form-control" onchange="calculateAmount()">

                                    <option></option>
										  <option <?=($cash_bank=='Bank')?'selected':'';?> value="Bank">Bank</option>

										  <option <?=($cash_bank=='Cash')?'selected':'';?> value="Cash">Cash</option>

										  <option <?=($cash_bank=='Both')?'selected':'';?> value="Both">Bank+Cash</option>

                                </select>

                            </div>

                        </div>



                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Cash Paid :</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <input name="cash_amt" type="text" id="cash_amt" onkeyup="calculateAmount()" value="<?= $cash_amt ?>" />

                            </div>

                        </div>



                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Bank Paid :</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <input name="bank_amt" type="text" id="bank_amt" value="<?= $bank_amt ?>" />

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

                        <label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Total Salary :</label>

                        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">

                            <input name="total_salary" type="text" id="total_salary" class="form-control" readonly="" value="<?= $total_salary ?>" />

                        </div>

                    </div>

                </div>



                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                    <div class="form-group row m-0">

                        <label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Total Payable :</label>
                        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">

                            <input name="total_payable" type="text" id="total-payable" value="<?= $total_payable ?>" readonly="" class="form-control" />



                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</form>







<script>
// Function to calculate tax and update the monthly tax field
// Function to calculate tax and update the monthly tax field
function calculateSalaryTax() {
    const grossSalary = parseFloat(document.getElementById('gross-salary').value);
    const basicSalary = parseFloat(document.getElementById('basic-salary').value);
    const genderElement = document.getElementById('gender');
    const gender = genderElement ? genderElement.value.toLowerCase() : null;

    if (!isNaN(grossSalary) && !isNaN(basicSalary) && gender) {
        fetch(`get_taxinfo_ajx.php?gross_salary=${grossSalary}&basic_salary=${basicSalary}&gender=${gender}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('monthly_tax').value = parseFloat(data.tax).toFixed(2);
                } else {
                    document.getElementById('monthly_tax').value = data.message;
                }
                calculateTotalPayable(); // Update total payable after tax calculation
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('monthly_tax').value = 'Error calculating tax';
            });
    } else {
        // Clear tax field if inputs are incomplete
        document.getElementById('monthly_tax').value = '';
        calculateTotalPayable();
    }
}


// Function to calculate salary breakdown
function calculateSalary() {
    var grossSalary = parseFloat(document.getElementById("gross-salary").value) || 0;

    var basicSalary = grossSalary * 0.571425;
    var houseRent = basicSalary * 0.5;
    var medicalAllowance = basicSalary * 0.1;
    var convenience = basicSalary * 0.15;

    // Update the calculated fields
    document.getElementById("house_rent").value = Math.round(houseRent);
    document.getElementById("medical_allowance").value = Math.round(medicalAllowance);
    document.getElementById("convenience").value = Math.round(convenience);
    document.getElementById("basic-salary").value = Math.round(basicSalary);
    document.getElementById("total_salary").value = Math.round(grossSalary);

    // Call the function to calculate tax after the salary breakdown
    calculateSalaryTax();
}

// Function to calculate total payable after deducting tax
function calculateTotalPayable() {
    var grossSalary = parseFloat(document.getElementById("gross-salary").value) || 0;
    var monthlyTax = parseFloat(document.getElementById("monthly_tax").value) || 0;

    var totalPayable = grossSalary - monthlyTax;

    // Update the total payable field
    document.getElementById("total-payable").value = Math.round(totalPayable);
}

// Attach the event listener to the gross salary input
document.getElementById('gross-salary').addEventListener('input', calculateSalary);

 
	
function calculateAmount() {
  var grossSalary = ((document.getElementById("gross-salary").value)*1);

  
  var paymentType = document.getElementById("cash_bank").value;
  //var totalAmount = document.getElementById("totalAmount");
  var cashAmount = document.getElementById("cash_amt");
  var bankAmount = document.getElementById("bank_amt");
  
  if (paymentType === "Cash") {
    cashAmount.value = grossSalary;
    bankAmount.value = "";

	
   
  } else if (paymentType === "Bank") {
    cashAmount.value = "";
	
    bankAmount.value = grossSalary;
  
  } else if (paymentType === "Both") {
   

        var cashInput = document.getElementById("cash_amt").value*1; // get the user input for cash amount
        
		var cashAmt = Number(cashInput); // convert user input to a number
        var bankAmt = grossSalary - cashAmt; // calculate bank amount
        
        cashAmount.value = cashAmt;
        bankAmount.value = bankAmt;
     
		
		
      
 
  } else {
    cashAmount.value = "";
    bankAmount.value = "";
	
   
  }
}

	
	
	
	
</script>




<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>
