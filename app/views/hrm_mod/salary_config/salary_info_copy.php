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

$title = 'Payroll Information Setup';

$page = "salary_info.php";

$root = 'salary_config';

$table = 'salary_info';    // Database Table Name Mainly related to this page

$unique = 'id';            // Primary Key of this Database table

$shown = 'basic_salary';    // For a New or Edit Data a must have data field

$crud = new crud($table);

$required_id = find_a_field($table, $unique, 'PBI_ID=' . $_SESSION['employee_selected'], ' order by id desc limit 1');




if ($required_id > 0)
$$unique = $_GET[$unique] = $required_id;


if (isset($_POST[$shown])) {

	if (isset($_POST['insert'])) {

		echo $_POST['PBI_ID'] = $_SESSION['employee_selected'];

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


if(isset($_POST['update'])){
$crud->update($unique);
$type=1;
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

	while (list($key, $value) = each($data)) {

		$$key = $value;
	}
}

?>

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
    /*background-color: #F0F1F3 !important;*/
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
    /*background-color: #31c971 !important;*/
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



<form method="post" id="form" enctype="multipart/form-data">

<div class="page-content page-container" id="page-content">
  
    <? include('../common/title_bar.php'); ?>
    <header class="pb-4">
      <? if (!isset($_GET[$unique])) { ?>
        <span class="oe_form_buttons_edit" style="display: inline;">
        <button name="insert" accesskey="S" class="btn1 btn1-bg-submit" type="submit"> Save </button>
        </span>
        <? } ?>
      <? if (isset($_GET[$unique])) { ?>
        <span class="oe_form_buttons_edit" style="display: inline;">
        <button name="update" accesskey="S" class=" btn1 btn1-bg-submit" type="submit"> Update </button>
        </span>
        <? } ?>

      <? if (isset($_GET[$unique])) { ?>
        <span class="oe_form_buttons_edit" style="display: inline;">
        <button name="delete" accesskey="S" class="btn1 btn1-bg-cancel" type="submit"> Delete </button>
        </span>
        <? } ?>
		
		
		<div class="mt-3 mb-0" data-sr-id="2"  style=" zoom: 77%; visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s; border-radius: 0px !important; border: 0px !important; background-color: #fff; box-shadow: none !important;">
                            <div class="d-flex">
                              <ul class="nav new-sr nav-pills">
 <li class="nav-item"><a class="nav-link" href="../hrm/employee_basic_information_nal.php" data-toggle="tab" data-target="#tab_1" style="color:#333;font-weight:bold"> <i class="fa-solid fa-pen-to-square"></i> EMPLOYEE  </a></li>
 
<li class="nav-item"><a class="nav-link" href="../hrm/employee_basic_information_nal.php" data-toggle="tab" data-target="#tab_3" style="color:#333;font-weight:bold"> <i class="fa-solid fa-business-time"></i> WORK </a></li>

<!--<li class="nav-item"><a class="nav-link" href="../payroll/salary_information.php"  style="color:#333;font-weight:bold"> <i class="fa-regular fa-folder-open"></i> SALARY (MGT) </a></li>-->

<li class="nav-item"><a class="nav-link active" href="salary_info.php"  style="color:#333;font-weight:bold"> <i class="fa-regular fa-folder-open"></i> SALARY </a></li>

<li class="nav-item"><a class="nav-link" href="../hrm/employee_basic_information_nal.php" data-toggle="tab" data-target="#tab_2" style="color:#333;font-weight:bold"> <i class="fa-solid fa-envelope-open"></i> PERSONAL INFORMATION </a></li>

 <li class="nav-item"><a class="nav-link" href="../hrm/employee_basic_information_nal.php" data-toggle="tab" data-target="#tab_6" style="color:#333;font-weight:bold"> <i class="fa-regular fa-clock"></i> SHIFT</a></li>
 
 <li class="nav-item"><a class="nav-link" href="../hrm/employee_basic_information_nal.php" data-toggle="tab" data-target="#tab_4" style="color:#333;font-weight:bold"> <i class="fa-solid fa-person-chalkboard"></i> EMPLOYEE RELIEVING INFO</a></li>
 
 <li class="nav-item"><a class="nav-link" href="../hrm/employee_basic_information_nal.php" data-toggle="tab" data-target="#tab_5" style="color:#333;font-weight:bold"> <i class="fa-solid fa-chart-user"></i> REFERANCE</a></li>

 <li class="nav-item"><a class="nav-link" href="../hrm/employee_basic_information_nal.php" data-toggle="tab" data-target="#tab_7" style="color:#333;font-weight:bold"> <i class="fa-regular fa-folder-open"></i> FILES UPLOAD</a></li>
                
                              </ul>
                            </div>
                          </div>
						  
						  
						  
      <div class="oe_clear"></div>
    </header>
    <div class="padding new-color pt-3 pb-3 pl-2 pr-2">
    <div class="row  p-0 m-0">
    <div class="col-sm-6">
    <div class="card new-bg-color">
 <p class="new-header"><strong> Please fill the information to continue </strong>  </p> 
      <div class="card-body">
        <!--<p class="text-muted" style="color:#E16127">Please fill the information to continue</p>-->
        <div class="form-row">
      
		 <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" class="form-control" />
		 
		<input name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['employee_selected']?>" type="hidden" />
		   
	    <input type="hidden" id="salary_schedule" name="salary_schedule" value="<?=find_a_field('personnel_basic_info','salary_schedule','PBI_ID='.$_SESSION['employee_selected']);?>">
		   
	    <input type="hidden" id="grade" name="grade" value="<?=find_a_field('personnel_basic_info','grade','PBI_ID='.$_SESSION['employee_selected']);?>">
	    
	    <input type="hidden" id="designation" name="designation" value="<?=find_a_field('personnel_basic_info','DESG_ID','PBI_ID='.$_SESSION['employee_selected']);?>">
            
            
          </div>
     
     
        
        
        
       
        
        
        
                <div class="container n-form2">
                                      
                           
                               
                <div class="form-group row m-0 pb-1">
                <label for="gross_salary" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Gross Salary : </label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                <input type="text" id="grossSalary" name="gross_salary" oninput="calculateSalary()" value="<?=$gross_salary?>">
                </div></div>
                                    
                <div class="form-group row m-0 pb-1">
                <label for="basic_salary" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Basic Salary : </label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                <input type="text" id="basicSalary" name="basic_salary" value="<?=$basic_salary?>">
                </div>
                </div> 
                
                
                <div class="form-group row m-0 pb-1">
                <label for="basic_salary" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> House Rent : </label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                <input type="text" id="houseRent" name="house_rent" value="<?=$house_rent?>">
                </div>
                </div> 
                
                <div class="form-group row m-0 pb-1">
                <label for="basic_salary" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Medical Allowance  : </label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                <input type="text" id="medicalAllowance" name="medical_allowance" value="<?=$medical_allowance?>">
                </div>
                </div> 
                
                <div class="form-group row m-0 pb-1">
                <label for="basic_salary" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Conveyance Allowance : </label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                <input type="text" id="convenience" name="convenience" value="<?=$convenience?>">
                </div>
                </div> 
                
                
                <div class="form-group row m-0 pb-1">
                <label for="basic_salary" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Food Allowance : </label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                 <input type="text" id="foodAllowance" name="food_allowance" value="<?=$food_allowance?>">
                </div>
                </div> 
                <div class="form-group row m-0 pb-1">
                
				<label for="special_allowance" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Special Allowance : </label>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2 ">
                <input name="special_allowance" type="text" id="special_allowance" class="form-control"  value="<?=$special_allowance?>" />
                </div>
				
				<!--<label for="special_allowance" class="col-sm-2 col-md-2 col-lg-2 col-xl-2 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Special Allowance Type: </label>-->
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2 ">
                <select name="special_status" type="text" id="special_status" class="form-control" >
					<option></option>
					<option <?= ($special_status == 1) ? 'selected' : ''; ?> value="1">With Salary</option>
					<option <?= ($special_status == 0) ? 'selected' : ''; ?> value="0">Without Salary</option>
				</select>
                </div>
                </div>
                 
				<div class="form-group row m-0 pb-1">
                
				<label for="special_allowance" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Technical Allowance : </label>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2 ">
               <input name="technical" type="text" id="technical" class="form-control"  value="<?=$technical?>" />
                </div>
				
				<!--<label for="special_allowance" class="col-sm-2 col-md-2 col-lg-2 col-xl-2 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Special Allowance Type: </label>-->
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2 ">
                <select name="technical_status" type="text" id="technical_status" class="form-control" >
					<option></option>
					<option <?= ($technical_status == 1) ? 'selected' : ''; ?> value="1">With Salary</option>
					<option <?= ($technical_status == 0) ? 'selected' : ''; ?> value="0">Without Salary</option>
				</select>
                </div>
                </div>
				
				
                <div class="form-group row m-0 pb-1">
                
				<label for="special_allowance" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Dislocation Allowance : </label>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2 ">
               <input name="dislocation" type="text" id="dislocation" class="form-control"  value="<?=$dislocation?>" />
                </div>
				
				<!--<label for="special_allowance" class="col-sm-2 col-md-2 col-lg-2 col-xl-2 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Special Allowance Type: </label>-->
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2 ">
                <select name="dislocation_status" type="text" id="dislocation_status" class="form-control" >
					<option></option>
					<option <?= ($dislocation_status == 1) ? 'selected' : ''; ?> value="1">With Salary</option>
					<option <?= ($dislocation_status == 0) ? 'selected' : ''; ?> value="0">Without Salary</option>
				</select>
                </div>
                </div>
				
				<div class="form-group row m-0 pb-1">
                
				<label for="special_allowance" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Mobile Allowance : </label>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2 ">
                <input name="mobile_allowance" type="text" id="mobile_allowance" class="form-control"  value="<?=$mobile_allowance?>" />
                </div>
				
				<!--<label for="special_allowance" class="col-sm-2 col-md-2 col-lg-2 col-xl-2 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Special Allowance Type: </label>-->
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2 ">
                <select name="mobile_status" type="text" id="mobile_status" class="form-control" >
					<option></option>
					<option <?= ($mobile_status == 1) ? 'selected' : ''; ?> value="1">With Salary</option>
					<option <?= ($mobile_status == 0) ? 'selected' : ''; ?> value="0">Without Salary</option>
				</select>
                </div>
                </div>
				
                
                
                
                 <br> </div>
                           
        
        
        
        
        
        
        
        
        
        
   
      </div>
    </div>
 
</div>





<div class="col-sm-6">
<div class="card new-bg-color">
<p class="new-header"><strong> Please fill the fields below. </strong>  </p> 
<div class="container new-bg-color">
<div class="card-body n-form2">         
           
   
        <div class="form-row">
          
        <div class="form-group col-sm-3">
        <label>OT Applicable In </label>
        <select name="overtime_applicable_in" id="overtime_applicable_in" class="form-control">
        <option <?= ($overtime_applicable_in == 'NO') ? 'selected' : '' ?>>NO</option>
        <option <?= ($overtime_applicable_in == 'YES') ? 'selected' : '' ?>>YES</option>
        </select>
        </div>
          
          
        <div class="form-group col-sm-3">
        <label>OT Applicable Out </label>
        <select name="overtime_applicable" id="overtime_applicable" class="form-control">
        <option <?= ($overtime_applicable == 'NO') ? 'selected' : '' ?>>NO</option>
        <option <?= ($overtime_applicable == 'YES') ? 'selected' : '' ?>>YES</option>
        </select>
        </div>
        
        
          <div class="form-group col-sm-3">
            <label>OT Holiday</label>
            <select name="ot_holiday_applicable" id="ot_holiday_applicable" class="form-control">
              <option <?= ($ot_holiday_applicable == 'NO') ? 'selected' : '' ?>>NO</option>
              <option <?= ($ot_holiday_applicable == 'YES') ? 'selected' : '' ?>>YES</option>
            </select>
          </div>
          <div class="form-group col-sm-3">
            <label>OT Weekend</label>
            <select name="ot_weekend_applicable" id="ot_weekend_applicable" class="form-control">
              <option <?= ($ot_weekend_applicable == 'NO') ? 'selected' : '' ?>>NO</option>
              <option <?= ($ot_weekend_applicable == 'YES') ? 'selected' : '' ?>>YES</option>
            </select>
          </div>
       
        
        
        
        </div>
                                      
      


		
		
		
		
        <p class="new-header"> Bank Iinformation Section : </p>
        
        
          <div class="container new-bg-color">
                                      
                           
                               
                <div class="form-group row m-0 pb-1">
                <label for="gross_salary" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Bank Name : </label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                  <select name="bank_name" id="bank_name" class="form-control">
              <option></option>
              <?
			foreign_relation('bank', 'BANK_CODE', 'BANK_NAME', $bank_name, ' 1 order by BANK_NAME'); ?>
            </select>
             </div></div>
                                    
                <div class="form-group row m-0 pb-1">
                <label for="basic_salary" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Account No : </label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                    <input name="ac_no" type="text" id="ac_no" value="<?= $ac_no ?>" class="form-control" />
                </div>
                </div> 
                
                  <div class="form-group row m-0 pb-1">
                <label for="receiving_bank_code" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Receiving Bank Code :</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                   <input name="receiving_bank_code" type="text" id="receiving_bank_code" value="<?= $receiving_bank_code ?>" class="form-control" />
                </div>
                </div> 
                
                
                  <div class="form-group row m-0 pb-1">
                <label for="receiving_bank_name" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Receiving Bank Name : </label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                   	<select name="receiving_bank_name" id="receiving_bank_name" class="form-control">
									<option></option>
									<?
									foreign_relation('bank', 'BANK_CODE', 'BANK_NAME', $receiving_bank_name, ' 1 order by BANK_NAME');
									?>
								</select>
                </div>
                </div> 
                
            
             <!--<div class="form-group row m-0 pb-1">
            <label for="gross_salary" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Salary Given by : </label>
            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
          <select name="cash_bank" id="cash_bank" class="form-control" onchange="calculateAmount()">
            <option <?= ($cash_bank == 'Cash') ? 'selected' : ''; ?> value="Cash">Cash</option>
            <option <?= ($cash_bank == 'Both') ? 'selected' : ''; ?> value="Both">Bank & Cash</option>
            <option <?= ($cash_bank == 'Bank') ? 'selected' : ''; ?> value="Bank">Bank</option>
          </select>
             </div>
             </div>-->
             
             
                <div class="form-group row m-0 pb-1">
                <label for="basic_salary" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Cash Paid : </label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                     <input name="cash_amt" type="text" id="cash_amt" onkeyup="calculateAmount()"  value="<?=$cash_amt;?>" />
                </div>
                </div>
                
                <div class="form-group row m-0 pb-1">
                <label for="basic_salary" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Bank Paid : </label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                     <input name="bank_amt" type="text" id="bank_amt" onkeyup="calculateAmount()" value="<?=$bank_amt;?>" />
                </div>
                </div> 
            
            
            </div>
                           
        
  
        
        
        </div>  
      </div>
      
      
      
    </div>
  </form>
</div>
</div>
</div>








		 <!-- <div class="container-fluid bg-form-titel">
			<div class="row">

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="form-group row m-0">
						<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">
							Total Salary :
						</label>
						<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
							<input name="total_salary" type="text" id="total_salary"   class="form-control" value="<?=$total_salary;?>" readonly />
						</div>
					</div>
				</div>



				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="form-group row m-0">
						<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">
							Total Payable :
						</label>
						<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
							<input name="total_payable" type="text" id="total_payable" value="<?=$total_payable;?>" readonly class="form-control" />
						</div>
					</div>
				</div>

			</div>
		</div> -->
</div>


<script>
    function updateSalary() {
        var salary_schedule = document.getElementById("salary_schedule").value;
        var grade = document.getElementById("grade").value;
        var designation = document.getElementById("designation").value;

        // Check if any dropdown is not selected
        if (!salary_schedule || !grade || !designation) {
            clearSalaryFields();
            return;
        }

        var xhr = new XMLHttpRequest();
        xhr.open("GET", "get_salary_info.php?salary_schedule=" + salary_schedule + "&grade=" + grade + "&designation=" + designation, true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var salaryData = JSON.parse(xhr.responseText);  

                document.getElementById("basicSalary").value = salaryData.basic || 'N/A';
                document.getElementById("grossSalary").value = salaryData.gross || 'N/A';
                document.getElementById("houseRent").value = salaryData.house || 'N/A';
				document.getElementById("medicalAllowance").value = salaryData.medical || 'N/A';
                document.getElementById("convenience").value = salaryData.conveyance || 'N/A';
                document.getElementById("foodAllowance").value = salaryData.food || 'N/A';
            }
        };
        xhr.send();
    }

    function clearSalaryFields() {
        document.getElementById("basicSalary").value = '';
        document.getElementById("grossSalary").value = '';
        document.getElementById("houseRent").value = '';
		document.getElementById("medicalAllowance").value = '';
        document.getElementById("convenience").value = '';
        document.getElementById("foodAllowance").value = '';
       
    }

    document.getElementById("salary_schedule").addEventListener("change", updateSalary);
    document.getElementById("grade").addEventListener("change", updateSalary);
    document.getElementById("designation").addEventListener("change", updateSalary);
</script>


<script>

function calculateSalary() {

       var salary_schedule = document.getElementById("salary_schedule").value;
	   var grossSalary = parseFloat(document.getElementById("grossSalary").value);
	   
	     if (salary_schedule == 3) {

     	var basicSalary = grossSalary * 0.5;
		var houseRent = grossSalary * 0.25;
		var medicalAllowance = grossSalary * 0.15;
		var convenience = grossSalary * 0.10;
		
		var totalSalary = grossSalary;
		var totalPayable = grossSalary;
		
		
		}else{
     
	 	var basicSalary = (grossSalary - (1850))/1.5;
		var houseRent = basicSalary * 0.5;
		var medicalAllowance = 600;
		var convenience = 350;
		var foodAllowance = 900;
		
		var totalSalary = grossSalary;
		var totalPayable = grossSalary;

		}
		
        document.getElementById("basicSalary").value = basicSalary.toFixed(2);
		document.getElementById("houseRent").value = houseRent.toFixed(2);
		document.getElementById("medicalAllowance").value = medicalAllowance.toFixed(2);
		document.getElementById("convenience").value = convenience.toFixed(2);
		document.getElementById("foodAllowance").value = foodAllowance.toFixed(2);
		
   
		document.getElementById("total_salary").value = totalSalary.toFixed(2);
		document.getElementById("total_payable").value = totalPayable.toFixed(2);
		
		document.getElementById("cash_amt").value = grossSalary.toFixed(2);
		document.getElementById("bank_amt").value = bank_amt.toFixed(2);
		

	
		
	}
</script>

<script>
	// Bank paid and Cash paid Calculations are here

	function calculateAmount() {
	    
	    

		var payable =  ((document.getElementById("grossSalary").value) * 1);
		var cashAmount = document.getElementById("cash_amt");
		var bankAmount = document.getElementById("bank_amt");
		var total_cash= document.getElementById("cash_amt").value=payable;
		
		//var total_bank=cashAmount-bankAmount;
		
		//cashAmount.value=total_bank;
		
		var bankInput = document.getElementById("bank_amt").value * 1;
			var bankAmt = Number(bankInput);
			var dueCashAmt = total_cash-bankAmt;

			cashAmount.value = dueCashAmt;
			bankAmount.value = bankAmt;

		 
	}

	window.addEventListener("load", function() {
		calculateAmount();
	});
</script>

<?

$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";

?>
