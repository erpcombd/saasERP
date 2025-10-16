<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
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

$page = "increment_new.php";

$root = 'salary_config';

$table = 'increment_detail';    // Database Table Name Mainly related to this page

$unique = 'INCREMENT_D_ID ';            // Primary Key of this Database table

$shown = 'PBI_ID';    // For a New or Edit Data a must have data field

$crud = new crud($table);

$required_id = find_a_field($table, $unique, 'PBI_ID=' . $_SESSION['employee_selected'], ' order by id desc limit 1');

$all=find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);
$info=find_all_field('salary_info','','PBI_ID='.$_SESSION['employee_selected']);




if ($required_id > 0)
$$unique = $_GET[$unique] = $required_id;


if (isset($_POST[$shown])) {

	if (isset($_POST['insert'])) {

		echo $_POST['PBI_ID'] = $_SESSION['employee_selected'];

		$crud->insert();

		$type = 1;
			$updates="UPDATE salary_info a
JOIN increment_detail b ON b.pbi_id = a.PBI_ID
SET 
a.basic_salary = b.new_basic_salary,
a.house_rent = b.new_house_rent,
a.convenience = b.new_convenience,
a.medical_allowance = b.new_medical_allowance,
a.gross_salary = b.grossSalary_new,
a.food_allowance = b.new_food_allowance,
a.cash_amt = b.grossSalary_new,  
a.bank_amt = 0,
a.total_salary = b.grossSalary_new,
a.total_payable = b.grossSalary_new,
a.cash_bank = 'Cash' where a.PBI_ID='".$_SESSION['employee_selected']."' ";
db_query($updates);
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
$updates="UPDATE salary_info a
JOIN increment_detail b ON b.pbi_id = a.PBI_ID
SET 
a.basic_salary = b.new_basic_salary,
a.house_rent = b.new_house_rent,
a.convenience = b.new_convenience,
a.medical_allowance = b.new_medical_allowance,
a.gross_salary = b.grossSalary_new,
a.food_allowance = b.new_food_allowance,
a.cash_amt = b.grossSalary_new,  
a.bank_amt = 0,
a.total_salary = b.grossSalary_new,
a.total_payable = b.grossSalary_new,
a.cash_bank = 'Cash' where a.PBI_ID='".$_SESSION['employee_selected']."' ";
db_query($updates);
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

    if (is_array($data) || is_object($data)) {
        foreach ($data as $key => $value) {
            $$key = $value;
        }
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
		
		<div class="container-fluid bg-form-titel mt-3">
							  <div class="row ">
							  
								<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
								  <div class="form-group row m-0">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Inc. Effective Date : </label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
									  <input type="date" name="INCREMENT_EFFECT_DATE" autocomplete="off" id="INCREMENT_EFFECT_DATE" style="width:50%;" class="form-control" />
									  
									   
									</div>
								  </div>
								</div>
								
						
								
								
						
								
								
								
								<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
								  <div class="form-group row m-0">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Inc. Type : </label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
									  <select name="INCREMENT_TYPE" id="INCREMENT_TYPE">
										<option></option>
										<option value="Confirmation">Confirmation</option>
										<option value="Confirmation and Promotion">Confirmation and Promotion</option>
										<option value="Merit Increment">Merit Increment</option>
										<option value="Promotion">Promotion</option>
										<option value="Transfer">Transfer</option>
									  </select>
									</div>
								  </div>
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
								  <div class="form-group row m-0">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Assesment Score : </label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
									  <input type="text" name="score" autocomplete="off" id="score" style="width:50%;" class="form-control" />
									  
									</div>
								  </div>
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
								  <div class="form-group row m-0">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Inc. Amount : </label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
									  <input type="text" name="INCREMENT_AMT" autocomplete="off" id="INCREMENT_AMT" oninput="calculateSalary()" style="width:50%;" class="form-control" />
									  
									</div>
								  </div>
								</div>
								
								<div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
								  <input name="insert" id="insert" value="Save" type="submit" class="btn btn-danger">
								</div>
							  </div>
    </div>
		
		
						  
						  
						  
      <div class="oe_clear"></div>
    </header>
    <div class="padding new-color pt-3 pb-3 pl-2 pr-2">
    <div class="row  p-0 m-0">
    <div class="col-sm-6">
    <div class="card new-bg-color">
 <p class="new-header"><strong> Existing Information</strong>  </p> 
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
                                        <label for="PBI_ORG" class="col-sm-4 col-md-4 req-input col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Company : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select  id="PBI_ORG_OLD" class="form-control" name="PBI_ORG_OLD" >
                                            <? foreign_relation('user_group','id','group_name',$PBI_ORG_OLD,' id='.$all->PBI_ORG);?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      <? if($_SESSION['proj_id'] != 'demo'){ ?>
                                                                              
                                      <div class="form-group row m-0 pb-1">
                                        <label for="section" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Function : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="PBI_FUNCTION_OLD" id="PBI_FUNCTION_OLD" class="form-control" >
                                            
                                            <? foreign_relation('hrm_function','id','function_name',$PBI_FUNCTION_OLD, 'id='.$all->PBI_FUNCTION);?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      <? } ?>
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 req-input d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Cost Center : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="cost_center_old" id="cost_center_old" class="form-control">
                                            
                                            <? foreign_relation('hrm_cost_center','id','center_name',$cost_center_old,'1 and  id='.$all->cost_center);?>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="form-group row m-0 pb-1">
                                        <label for="DEPT_ID" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Department : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="DEPT_ID_OLD" id="DEPT_ID_OLD" class="form-control">
                                             
                                            <? foreign_relation('department','DEPT_ID','DEPT_DESC',$DEPT_ID_OLD,'DEPT_ID='.$all->DEPT_ID);?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="section" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Section : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="section_old" id="section_old" class="form-control">
                                            
                                            <? foreign_relation('PBI_Section','sec_id','sec_name',$section_old,' 1 and sec_id='.$all->section);?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      <? if($_SESSION['proj_id']=='demo'){ ?>
                                      <div class="form-group row m-0 pb-1">
                                        <label for="section" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Region : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="PBI_BRANCH" id="PBI_BRANCH" onchange="getData2('ajax_zone.php', 'zone', this.value,  this.value)">
                                            <option selected="selected">
                                            <? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$PBI_BRANCH,' 1 order by BRANCH_NAME and BRANCH_ID='.$all->PBI_BRANCH);?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="section" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Zone : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                            <span id="zone">
                                          <select name="PBI_ZONE" id="PBI_ZONE"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)">
                                            <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$PBI_ZONE,' 1 order by ZONE_NAME and ZONE_CODE='.$all->PBI_ZONE);?>
                                          </select>
                                          </span>
                                        </div>
                                      </div>
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="section" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Area : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                            <span id="area">
                                          <select name="PBI_AREA" id="PBI_AREA">
                                            <? foreign_relation('area','AREA_CODE','AREA_NAME',$PBI_AREA,' 1 order by AREA_NAME');?>
                                          </select>
                                          </span>
                                        </div>
                                      </div>
                                      
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="section" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Payroll Designation : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <input name="payroll_designation" id="payroll_designation" class="form-control" value="<?=$payroll_designation;?>" type="text" />
                                            
                                        </div>
                                      </div>
                                      
                                      <? } ?>
                                      
                                  
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="DESG_ID" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text req-input">Designation : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="DESG_ID_OLD" id="DESG_ID_OLD" class="form-control">
                                           
                                            <? foreign_relation('designation','DESG_ID','DESG_DESC',$DESG_ID_OLD,'DESG_ID='.$all->DESG_ID);?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="grade" class="col-sm-4 col-md-4 col-lg-4 req-input col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Grade : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="grade_old" id="grade_old" class="form-control" >
                                            
                                            <? foreign_relation('hrm_grade','id','grade_name',$grade_old,' id='.$all->grade);?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                        <!--                     <div class="form-group row m-0 pb-1">-->
                                      <!--	<label for="define_offday" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 req-input d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Employment Type : </label>-->
                                      <!--	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">-->
                                      <!--                     <select name="EMPLOYMENT_TYPE" id="EMPLOYMENT_TYPE" class="form-control">-->
                                      <!--                       <option selected="selected">-->
                                      <!--                       <?=$EMPLOYMENT_TYPE?>-->
                                      <!--                       </option>-->
                                      <!--                       <option>Contractual</option>-->
                                      <!--                       <option>Casual Staff</option>-->
                                      <!--                       <option>Probationary</option>-->
                                      <!--                       <option>Permanent</option>-->
                                      <!--                       <option>Temporary</option>-->
                                      <!--                     </select>-->
                                      <!--	</div>-->
                                      <!--</div>-->
                                      
                                      <? if($_SESSION['proj_id'] != 'demo'){ ?>
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="salary_schedule" class="col-sm-4 req-input col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Salary Schedule : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="salary_schedule" id="salary_schedule" class="form-control" >
                                           
                                            <? foreign_relation('salary_schedule','id','schedule_name',$salary_schedule,' id='.$all->salary_schedule);?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      <? } ?>
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="class" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Class : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="class_old" id="class_old" class="form-control" >
                                            
                                            <? foreign_relation('hrm_class','id','class_name',$class_old,' id='.$all->class);?>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="form-group row m-0 pb-1">
                                        <label for="class" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Location : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="JOB_LOC_ID_OLD" id="JOB_LOC_ID_OLD" class="form-control" >
                                            
                                            <? foreign_relation('project','PROJECT_ID','PROJECT_DESC',$JOB_LOC_ID_OLD,' PROJECT_ID='.$all->JOB_LOC_ID); ?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                
<br />
                                   
                              
                               
                <div class="form-group row m-0 pb-1">
                <label for="gross_salary" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Gross Salary : </label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                <input type="text" id="grossSalary_old" name="grossSalary_old" oninput="calculateSalary()" value="<?=$info->gross_salary?>">
                </div></div>
                                    
                <div class="form-group row m-0 pb-1">
                <label for="basic_salary" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Basic Salary : </label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                <input type="text" id="past_basic_salary" name="past_basic_salary" value="<?=$info->basic_salary?>">
                </div>
                </div> 
                
                
                <div class="form-group row m-0 pb-1">
                <label for="basic_salary" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> House Rent : </label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                <input type="text" id="past_house_rent" name="past_house_rent" value="<?=$info->house_rent?>">
                </div>
                </div> 
                
                <div class="form-group row m-0 pb-1">
                <label for="basic_salary" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Medical Allowance  : </label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                <input type="text" id="past_medical_allowance" name="past_medical_allowance" value="<?=$info->medical_allowance?>">
                </div>
                </div> 
                
                <div class="form-group row m-0 pb-1">
                <label for="basic_salary" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Conveyance Allowance : </label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                <input type="text" id="past_convenience" name="past_convenience" value="<?=$info->convenience?>">
                </div>
                </div> 
                
                
                <div class="form-group row m-0 pb-1">
                <label for="basic_salary" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Food Allowance : </label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                 <input type="text" id="past_food_allowance" name="past_food_allowance" value="<?=$info->food_allowance?>">
                </div>
                </div> 
                <div class="form-group row m-0 pb-1">
                
				<label for="special_allowance" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Special Allowance : </label>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2 ">
                <input name="past_special_allowance" type="text" id="past_special_allowance" class="form-control"  value="<?=$info->special_allowance?>" />
                </div>
				
				<!--<label for="special_allowance" class="col-sm-2 col-md-2 col-lg-2 col-xl-2 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Special Allowance Type: </label>-->
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2 ">
                <select name="special_status_old" type="text" id="special_status_old" class="form-control" >
					<option></option>
					<option value="1">With Salary</option>
					<option value="0">Without Salary</option>
				</select>
                </div>
                </div>
                 
				<div class="form-group row m-0 pb-1">
                
				<label for="special_allowance" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Technical Allowance : </label>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2 ">
               <input name="technical_old" type="text" id="technical_old" class="form-control"  value="<?=$info->technical?>" />
                </div>
				
				<!--<label for="special_allowance" class="col-sm-2 col-md-2 col-lg-2 col-xl-2 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Special Allowance Type: </label>-->
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2 ">
                <select name="technical_status_old" type="text" id="technical_status_old" class="form-control" >
					<option></option>
					<option value="1">With Salary</option>
					<option value="0">Without Salary</option>
				</select>
                </div>
                </div>
				
				
                <div class="form-group row m-0 pb-1">
                
				<label for="special_allowance" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Dislocation Allowance : </label>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2 ">
               <input name="dislocation_old" type="text" id="dislocation_old" class="form-control"  value="<?=$info->dislocation?>" />
                </div>
				
				<!--<label for="special_allowance" class="col-sm-2 col-md-2 col-lg-2 col-xl-2 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Special Allowance Type: </label>-->
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2 ">
                <select name="dislocation_status_old" type="text" id="dislocation_status_old" class="form-control" >
					<option></option>
					<option value="1">With Salary</option>
					<option value="0">Without Salary</option>
				</select>
                </div>
                </div>
				
				<div class="form-group row m-0 pb-1">
                
				<label for="special_allowance" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Mobile Allowance : </label>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2 ">
                <input name="past_mobile_allowance" type="text" id="past_mobile_allowance" class="form-control"  value="<?=$info->mobile_allowance?>" />
                </div>
				
				<!--<label for="special_allowance" class="col-sm-2 col-md-2 col-lg-2 col-xl-2 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Special Allowance Type: </label>-->
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2 ">
                <select name="mobile_status_old" type="text" id="mobile_status_old" class="form-control" >
					<option></option>
					<option value="1">With Salary</option>
					<option value="0">Without Salary</option>
				</select>
                </div>
                </div>
				
                
                
                
                 <br> </div>
                           
        
        
        
        
        
        
        
        
        
        
   
      </div>
    </div>
 
</div>





<div class="col-sm-6">
<div class="card new-bg-color">
<p class="new-header"><strong> Proposed Information. </strong>  </p> 
<div class="container new-bg-color">
<div class="card-body n-form2">         
           
   
          <div class="container n-form2">
                                      
                           
                               
                <div class="form-group row m-0 pb-1">
                                        <label for="PBI_ORG" class="col-sm-4 col-md-4 req-input col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Company : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select  id="PBI_ORG_NEW" class="form-control" name="PBI_ORG_NEW">
                                            <? foreign_relation('user_group','id','group_name',$PBI_ORG_NEW,' 1');?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      <? if($_SESSION['proj_id'] != 'demo'){ ?>
                                                                              
                                      <div class="form-group row m-0 pb-1">
                                        <label for="section" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Function : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="PBI_FUNCTION_NEW" id="PBI_FUNCTION_NEW" class="form-control">
                                            
                                            <? foreign_relation('hrm_function','id','function_name',$PBI_FUNCTION_NEW, '1');?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      <? } ?>
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 req-input d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Cost Center : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="cost_center_new" id="cost_center_new" class="form-control">
                                            
                                            <? foreign_relation('hrm_cost_center','id','center_name',$cost_center_new,'1');?>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="form-group row m-0 pb-1">
                                        <label for="DEPT_ID" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Department : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="DEPT_ID_NEW" id="DEPT_ID_NEW" class="form-control">
                                             
                                            <? foreign_relation('department','DEPT_ID','DEPT_DESC',$DEPT_ID_NEW,'1');?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="section" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Section : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="section_new" id="section_new" class="form-control" >
                                            
                                            <? foreign_relation('PBI_Section','sec_id','sec_name',$section_new,' 1');?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      <? if($_SESSION['proj_id']=='demo'){ ?>
                                      <div class="form-group row m-0 pb-1">
                                        <label for="section" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Region : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="PBI_BRANCH" id="PBI_BRANCH" onchange="getData2('ajax_zone.php', 'zone', this.value,  this.value)">
                                            <option selected="selected">
                                            <? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$PBI_BRANCH,' 1 order by BRANCH_NAME ');?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="section" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Zone : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                            <span id="zone">
                                          <select name="PBI_ZONE" id="PBI_ZONE"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)">
                                            <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$PBI_ZONE,' 1 order by ZONE_NAME ');?>
                                          </select>
                                          </span>
                                        </div>
                                      </div>
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="section" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Area : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                            <span id="area">
                                          <select name="PBI_AREA" id="PBI_AREA">
                                            <? foreign_relation('area','AREA_CODE','AREA_NAME',$PBI_AREA,' 1 order by AREA_NAME');?>
                                          </select>
                                          </span>
                                        </div>
                                      </div>
                                      
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="section" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Payroll Designation : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <input name="payroll_designation" id="payroll_designation" class="form-control" value="<?=$payroll_designation;?>" type="text" />
                                            
                                        </div>
                                      </div>
                                      
                                      <? } ?>
                                      
                                  
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="DESG_ID" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text req-input">Designation : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="DESG_ID_NEW" id="DESG_ID_NEW" class="form-control">
                                           
                                            <? foreign_relation('designation','DESG_ID','DESG_DESC',$DESG_ID_NEW,'1');?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="grade" class="col-sm-4 col-md-4 col-lg-4 req-input col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Grade : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="grade_new" id="grade_new" class="form-control" >
                                            <option></option>
                                            <? foreign_relation('hrm_grade','id','grade_name',$grade_new,' 1');?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                        <!--                     <div class="form-group row m-0 pb-1">-->
                                      <!--	<label for="define_offday" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 req-input d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Employment Type : </label>-->
                                      <!--	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">-->
                                      <!--                     <select name="EMPLOYMENT_TYPE" id="EMPLOYMENT_TYPE" class="form-control">-->
                                      <!--                       <option selected="selected">-->
                                      <!--                       <?=$EMPLOYMENT_TYPE?>-->
                                      <!--                       </option>-->
                                      <!--                       <option>Contractual</option>-->
                                      <!--                       <option>Casual Staff</option>-->
                                      <!--                       <option>Probationary</option>-->
                                      <!--                       <option>Permanent</option>-->
                                      <!--                       <option>Temporary</option>-->
                                      <!--                     </select>-->
                                      <!--	</div>-->
                                      <!--</div>-->
                                      
                                      <? if($_SESSION['proj_id'] != 'demo'){ ?>
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="salary_schedule" class="col-sm-4 req-input col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Salary Schedule : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="salary_schedule" id="salary_schedule" class="form-control">
                                           
                                            <? foreign_relation('salary_schedule','id','schedule_name',$salary_schedule,' 1');?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      <? } ?>
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="class" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Class : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="class_new" id="class_new" class="form-control" >
                                            
                                            <? foreign_relation('hrm_class','id','class_name',$class_new,' 1');?>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="form-group row m-0 pb-1">
                                        <label for="class" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Location : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="JOB_LOC_ID_NEW" id="JOB_LOC_ID_NEW" class="form-control">
                                            
                                            <? foreign_relation('project','PROJECT_ID','PROJECT_DESC',$JOB_LOC_ID_NEW,' 1'); ?>
                                          </select>
                                        </div>
                                      </div>
									  
									  
									  <br />
									  
									                  
                <div class="form-group row m-0 pb-1">
                <label for="gross_salary" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Gross Salary : </label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                <input type="text" id="grossSalary_new" name="grossSalary_new"  value="<?=$grossSalary_new?>">
                </div></div>
                                    
                <div class="form-group row m-0 pb-1">
                <label for="basic_salary" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Basic Salary : </label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                <input type="text" id="new_basic_salary" name="new_basic_salary" value="<?=$new_basic_salary?>">
                </div>
                </div> 
                
                
                <div class="form-group row m-0 pb-1">
                <label for="basic_salary" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> House Rent : </label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                <input type="text" id="new_house_rent" name="new_house_rent" value="<?=$new_house_rent?>">
                </div>
                </div> 
                
                <div class="form-group row m-0 pb-1">
                <label for="basic_salary" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Medical Allowance  : </label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                <input type="text" id="new_medical_allowance" name="new_medical_allowance" value="<?=$new_medical_allowance?>">
                </div>
                </div> 
                
                <div class="form-group row m-0 pb-1">
                <label for="basic_salary" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Conveyance Allowance : </label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                <input type="text" id="new_convenience" name="new_convenience" value="<?=$new_convenience?>">
                </div>
                </div> 
                
                
                <div class="form-group row m-0 pb-1">
                <label for="basic_salary" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Food Allowance : </label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                 <input type="text" id="new_food_allowance" name="new_food_allowance" value="<?=$new_food_allowance?>">
                </div>
                </div> 
                <div class="form-group row m-0 pb-1">
                
				<label for="special_allowance" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Special Allowance : </label>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2 ">
                <input name="new_special_allowance" type="text" id="new_special_allowance" class="form-control"  value="<?=$new_special_allowance?>" />
                </div>
				
				<!--<label for="special_allowance" class="col-sm-2 col-md-2 col-lg-2 col-xl-2 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Special Allowance Type: </label>-->
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2 ">
                <select name="special_status_new" type="text" id="special_status_new" class="form-control" >
					<option></option>
					<option value="1">With Salary</option>
					<option value="0">Without Salary</option>
				</select>
                </div>
                </div>
                 
				<div class="form-group row m-0 pb-1">
                
				<label for="special_allowance" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Technical Allowance : </label>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2 ">
               <input name="technical_new" type="text" id="technical_new" class="form-control"  value="<?=$technical_new?>" />
                </div>
				
				<!--<label for="special_allowance" class="col-sm-2 col-md-2 col-lg-2 col-xl-2 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Special Allowance Type: </label>-->
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2 ">
                <select name="technical_status_new" type="text" id="technical_status_new" class="form-control" >
					<option></option>
					<option <?= ($technical_status_new == 1) ? 'selected' : ''; ?> value="1">With Salary</option>
					<option <?= ($technical_status_new == 0) ? 'selected' : ''; ?> value="0">Without Salary</option>
				</select>
                </div>
                </div>
				
				
                <div class="form-group row m-0 pb-1">
                
				<label for="special_allowance" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Dislocation Allowance : </label>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2 ">
               <input name="dislocation_new" type="text" id="dislocation_new" class="form-control"  value="<?=$dislocation_new?>" />
                </div>
				
				<!--<label for="special_allowance" class="col-sm-2 col-md-2 col-lg-2 col-xl-2 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Special Allowance Type: </label>-->
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2 ">
                <select name="dislocation_status_new" type="text" id="dislocation_status_new" class="form-control" >
					<option></option>
					<option <?= ($dislocation_status_new == 1) ? 'selected' : ''; ?> value="1">With Salary</option>
					<option <?= ($dislocation_status_new == 0) ? 'selected' : ''; ?> value="0">Without Salary</option>
				</select>
                </div>
                </div>
				
				<div class="form-group row m-0 pb-1">
                
				<label for="special_allowance" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Mobile Allowance : </label>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2 ">
                <input name="new_mobile_allowance" type="text" id="new_mobile_allowance" class="form-control"  value="<?=$new_mobile_allowance?>" />
                </div>
				
				<!--<label for="special_allowance" class="col-sm-2 col-md-2 col-lg-2 col-xl-2 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Special Allowance Type: </label>-->
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2 ">
                <select name="mobile_status_new" type="text" id="mobile_status_new" class="form-control" >
					<option></option>
					<option <?= ($mobile_status_new == 1) ? 'selected' : ''; ?> value="1">With Salary</option>
					<option <?= ($mobile_status_new == 0) ? 'selected' : ''; ?> value="0">Without Salary</option>
				</select>
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
	    var inc_amt = parseFloat(document.getElementById("INCREMENT_AMT").value);
	   var grossSalary_old = parseFloat(document.getElementById("grossSalary_old").value);
	   var grossSalary=inc_amt+grossSalary_old;
	   
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
		 document.getElementById("grossSalary_new").value = grossSalary.toFixed(2);
        document.getElementById("new_basic_salary").value = basicSalary.toFixed(2);
		document.getElementById("new_house_rent").value = houseRent.toFixed(2);
		document.getElementById("new_medical_allowance").value = medicalAllowance.toFixed(2);
		document.getElementById("new_convenience").value = convenience.toFixed(2);
		document.getElementById("new_food_allowance").value = foodAllowance.toFixed(2);
		
   
		//document.getElementById("total_salary").value = totalSalary.toFixed(2);
//		document.getElementById("total_payable").value = totalPayable.toFixed(2);
//		
//		document.getElementById("cash_amt").value = grossSalary.toFixed(2);
//		document.getElementById("bank_amt").value = bank_amt.toFixed(2);
		

	
		
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

require_once SERVER_CORE."routing/layout.bottom.php";

?>
