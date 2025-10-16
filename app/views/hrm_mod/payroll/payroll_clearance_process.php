<?php




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";





// ::::: Edit This Section ::::: 

$title='Payroll Clearance Proceess Entry';			// Page Name and Page Title

$page="pf_status.php";		// PHP File Name

$input_page="pf_status_input.php";

$root='hrm';



$table='hrm_off_board';		// Database Table Name Mainly related to this page

$unique='PF_STATUS_ID';			// Primary Key of this Database table

$shown='PBI_ID';				// For a New or Edit Data a must have data field



// ::::: End Edit Section :::::


if(isset($_POST['button'])){

    

	$_SESSION['employee_selected'] = find_a_field('personnel_basic_info','PBI_ID','PBI_CODE="'.$_POST['employee_selected'].'"');

	$_SESSION['PBI_CODE'] = $_POST['employee_selected'];



}


$crud      =new crud($table);





$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);







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

$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);

if($required_id>0)

$$unique = $_GET[$unique] = $required_id;

		}

	//for Modify..................................

	if(isset($_POST['update']))

	{
	
	
	$crud->update($unique);

				$type=1;

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



<?


?>













<script type="text/javascript"> function DoNav(lk){

	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)

	}</script>
<style>

.style1{

padding-left:20px;

}

</style>






<form action="" method="post" enctype="multipart/form-data">


<div class="oe_view_manager oe_view_manager_current">
<? include('../common/title_bar.php');?>
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
<div class="oe_form_sheetbg" >
<div class="oe_form_sheet oe_form_sheet_width">






<table class="table1  table-striped table-bordered table-hover table-sm">




<thead class="thead1" style="z-index: 1;">

<tr class="bgc-info">

<th width="50%">Clearance Type</th>

<th width="20%">Clearance From</th>

<th width="15%">Icon</th>

<th width="15%">Action</th>

</tr>

</thead>

<tbody>

<tr>

<td>
 

  <p class="m-0 bold text-left">Accounts</p>

  <p class="m-0 text-left">Loan, advances, joining expenses, notice pay reimbursement, travel advance.</p>
  
  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
  <input name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['employee_selected']?>" type="hidden" />
  
 <!-- <input type="hidden" name="accounts" value="account" />-->
  </td>

<td><div style= "margin-top:25px;" class="col-md-12 form-group">
<select name="acc_clearance" id="acc_clearance" class="form-control">
<option>-- Please Selected --</option>
<? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$acc_clearance,' 1 order by PBI_NAME asc');?>
</select>
</div>
</td>

	
<td><p class="fancy-checkbox mr-0"><span class="w60"><img width="60" height="60" style="margin-right: 20px; margin-top:15px;"  
src="../../pic/payroll/account.png" data-toggle="tooltip" data-placement="top" title="" alt="Avatar" class="rounded-circle w35" data-original-title="Avatar Name"></span>

</td>

<td>
		<select name="Accounts" id="Accounts">
          <option selected="selected">
          <?=$Accounts?>
          </option>
          <option>Yes</option>
          <option>No</option>
        </select>
		
		</p>
</td>






</tr>

<tr>

<td>

  <p class="m-0 bold text-left">HR & Administration</p>

  <p class="m-0 text-left">Mobile bill, sim card, credit card, health insurance card, key.</p>

</td>

<td><div style= "margin-top:25px;"  class="col-md-12 form-group">


	<select  name="HR_Clearance" id="HR_Clearance" class="form-control">



	<option>-- Please Selected --</option>



	<? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$HR_Clearance,' 1 order by PBI_NAME asc');?>



	</select>

	</div>

</td>

<td><p class="w60"><img width="60" height="60" style="margin-right: 20px; margin-top:15px;" src="../../pic/payroll/hra.png" data-toggle="tooltip" data-placement="top" title="" alt="Avatar" class="rounded-circle w35" data-original-title="Avatar Name"><span class="fancy-checkbox mr-0">



</span></p></td>

  <td> <select name="HR_Administration" id="HR_Administration">
          <option selected="selected">
          <?=$HR_Administration?>
          </option>
          <option>Yes</option>
          <option>No</option>
        </select></td>

</tr>

<tr>

<td>

  <p class="m-0 bold text-left">HR & Administration (Plant)</p>

  <p class="m-0 text-left">Id card, company accommodation, electricity bill.</p></td>

<td><div style= "margin-top:25px;" class="col-md-12 form-group">



	<select  name="Plant_Clearance" id="Plant_Clearance" class="form-control">



	<option>-- Please Selected --</option>



	<? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$Plant_Clearance,' 1 order by PBI_NAME asc');?>



	</select>

	</div>

</td>

<td><p><span class="w60"><img width="60" height="60" style="margin-right: 20px; margin-top:15px;" src="../../pic/payroll/hrap.png" data-toggle="tooltip" data-placement="top" title="" alt="Avatar" class="rounded-circle w35" data-original-title="Avatar Name"></span><span class="fancy-checkbox mr-0">

  </span>

  </p>
</td>


      <td> 
           <select name="HR_Administration_plant" id="HR_Administration_plant">
          <option selected="selected">
          <?=$HR_Administration_plant?>
          </option>
          <option>Yes</option>
          <option>No</option>
        </select></td>
		
		

</tr>

<tr>

<td>

  <p class="m-0 bold text-left">Information Technology</p>

  <p class="m-0 text-left">Pc, laptop, printers, email id, SAP id, data drive, other it peripherals etc.</p>

</td>

<td><div style= "margin-top:25px;" class="col-md-12 form-group">





	<select  name="it_Clearance" id="it_Clearance" class="form-control">



	<option>-- Please Selected --</option>



	<? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$it_Clearance,' 1 order by PBI_NAME asc');?>



	</select>

	</div>

</td>

<td><p><span class="w60"><img width="60" height="60" style="margin-right: 20px; margin-top:15px;" src="../../pic/payroll/it.png" data-toggle="tooltip" data-placement="top" title="" alt="Avatar" class="rounded-circle w35" data-original-title="Avatar Name" aria-describedby="tooltip836013"></span><span class="fancy-checkbox mr-0">

 </span>

</p>

</td>

    <td> 
           <select name="IT" id="IT">
          <option selected="selected">
          <?=$IT?>
          </option>
          <option>Yes</option>
          <option>No</option>
        </select></td>

</tr>

<tr>

<td>

  <p class="m-0 bold text-left">Project</p>

  <p class="m-0 text-left">All assigned projects.</p>
  </td>

<td><div style= "margin-top:25px;" class="col-md-12 form-group">





	<select name="project_Clearance" id="project_Clearance" class="form-control">



	<option>-- Please Selected --</option>



	<? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$project_Clearance,' 1 order by PBI_NAME asc');?>



	</select>

	</div>

</td>

<td><p><span class="w60"><img width="60" height="60" style="margin-right:20px; margin-top:15px;"src="../../pic/payroll/project.jpg" data-toggle="tooltip" data-placement="top" title="" alt="Avatar" class="rounded-circle w35" data-original-title="Avatar Name"></span><span class="fancy-checkbox mr-0">



    </span>

  </p>

</td>


    <td> 
           <select name="Project" id="Project">
          <option selected="selected">
          <?=$Project?>
          </option>
          <option>Yes</option>
          <option>No</option>
        </select></td>
		

</tr>

 </tbody>


</table>

</form>
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>
