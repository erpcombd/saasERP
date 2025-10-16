<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once SERVER_CORE."routing/inc.notify.php";
do_calander('#issue_date');
do_calander('#exp_date');
do_calander('#rec_date');
do_calander('#ins_start_date');
do_calander('#ins_end_date');


if(isset($_POST['button'])){

$_SESSION['vehical_selected'] = $_POST['vehical_selected'];
}
if(isset($_POST['reset'])){
//$pbi = find_a_field('personnel_basic_info','PBI_ID','PBI_CODE="'.$_POST['employee_selected'].'"');
unset($_SESSION['vehical_selected']);
}

// ::::: Edit This Section ::::: 
$title='Vehical Information' ; 		// Page Name and Page Title
$page="vehical_info.php";		// PHP File Name

$table='vehicle_info';		// Database Table Name Mainly related to this page
$unique='vehicle_id';			// Primary Key of this Database table

// ::::: End Edit Section :::::
$crud      =new crud($table);
$required_id=find_a_field($table,$unique,'vehicle_id='.$_SESSION['vehical_selected']);
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;

if(isset($_POST['doc_submit'])){
$vc= new crud('vehicle_doc_type');
$_POST['vehicle_id']=$$unique;
$_POST['entry_by']=$_SESSION['user']['id'];

$vc->insert();


}


{	if(isset($_POST['insert'])) {
$crud->insert();
}
//for Modify..................................
if(isset($_POST['update']))
{
$crud->update($unique);
}
}
if(isset($$unique))
{
$condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
foreach ($data as $key => $value)
{ $$key=$value;}
}

?>
<script type="text/javascript">

</script>
<style type="text/css">
.style1{color: #FF0000;}
.oe_form_group_cell{padding:8px;}
.label {font-weight:bold;}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
<form action="" method="post" enctype="multipart/form-data">
<div class="oe_view_manager oe_view_manager_current">
    <? include('../../common/title_bar.php');?>
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
<div class="oe_form_sheetbg" style="margin-top:-10px">
<div class="oe_form_sheet oe_form_sheet_width">
<div class="card">
<div style="font-weight:bold; font-size:16px; background-color:#E74386; z-index: 0!important; text-transform:uppercase; color:#fff" class="card-header">
<center>
Basic Informations
</center>
</div>
<div class="card-body">
<div class="row ">
<div class="col-md-2 form-group">
<label  class="label success" for="PBI_ID" >Vehicle ID : </label>
<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />


<input   name="vehicle_id" type="text" id="vehicle_id" value="<?=$vehicle_id?>" readonly="readonly" class="form-control" />

</div>
<div class="col-md-2 form-group">
<label class="label" for="MACHINE_ID">Vehicle Name : </label>
<input   name="vehicle_name" class="form-control"  type="text" id="vehicle_name" value="<?=$vehicle_name?>"/>
</div>
<div class="col-md-2 form-group">
<label class="label" for="MACHINE_ID">Vehicle Type : </label>
<select   name="vehicle_type" class="form-control"  type="text" id="vehicle_type">
  <option value=""></option>
  <? foreign_relation('vehicle_type','id','type',$vehicle_type,' 1');?>
</select>
</div>
<div class="col-md-3 form-group">
<label class="label" for="PBI_NAME">Model : </label>
<input   name="vehicle_model" class="form-control"  type="text" id="vehicle_model" value="<?=$vehicle_model?>"/>
</div>
<div class="col-md-3 form-group">
<label class="label" for="PBI_FATHER_NAME">Vehicle No : </label>
<input   name="vehicle_no" class="form-control"  type="text" id="vehicle_no" value="<?=$vehicle_no?>"/>
</div>
<div class="col-md-2 form-group">
<label class="label" for="PBI_MOTHER_NAME">Engine No : </label>
<input   name="engine_no" class="form-control"  type="text" id="engine_no" value="<?=$engine_no ?>"/>
</div>
<div class="col-md-2 form-group">
<label class="label" for="PBI_MOTHER_NAME">Chassis No : </label>
<input   name="chassis_no" class="form-control"  type="text" id="chassis_no" value="<?=$chassis_no ?>"/>
</div>

<div class="col-md-2 form-group">
<label class="label" for="PBI_MOTHER_NAME">Registration No : </label>
<input   name="reg_no" class="form-control"  type="text" id="reg_no" value="<?=$reg_no ?>"/>
</div>


<div class="col-md-2 form-group">
<label class="label" for="PBI_MOTHER_NAME">Cubic capacity(CC) : </label>
<input   name="cc" class="form-control"  type="text" id="cc" value="<?=$cc ?>"/>
</div>

<div class="col-md-2 form-group">
<label class="label" for="PBI_MOTHER_NAME">Vehicle Length : </label>
<input   name="vehicle_length" class="form-control"  type="text" id="vehicle_length" value="<?=$vehicle_length ?>"/>
</div>

<div class="col-md-2 form-group">
<label class="label" for="PBI_MOTHER_NAME">Vehicle Width : </label>
<input   name="vehicle_width" class="form-control"  type="text" id="vehicle_width" value="<?=$vehicle_width ?>"/>
</div>

<div class="col-md-2 form-group">
<label class="label" for="PBI_MOTHER_NAME">Vehicle Height : </label>
<input   name="vehicle_height" class="form-control"  type="text" id="vehicle_height" value="<?=$vehicle_height ?>"/>
</div>

<div class="col-md-2 form-group">
<label class="label" for="PBI_MOTHER_NAME">Number of Tyre : </label>
<input   name="tyre" class="form-control"  type="number" id="tyre" value="<?=$tyre ?>"/>
</div>

<div class="col-md-2 form-group">
<label class="label" for="PBI_MOTHER_NAME">Tyre Size : </label>
<input   name="tyre_size" class="form-control"  type="text" id="tyre_size" value="<?=$tyre_size ?>"/>
</div>



</div>
<div class="row"> </div>
<!--Card END-->
</div>
</div>
<div class="card">
<div style="font-weight:bold; font-size:16px; background-color:#E74386; z-index: 0!important; text-transform:uppercase; color:#fff" class="card-header">
<center>
Insurance Information
</center>
</div>
<div class="card-body">
<div class="row">
<div class="col-md-6 form-group">
<label class="label" for="PBI_MOTHER_NAME">Policy Number : </label>
<input   name="ins_no" class="form-control"  type="text" id="ins_no" value="<?=$ins_no ?>"/>
</div>

<div class="col-md-6 form-group">
<label class="label" for="PBI_MOTHER_NAME">Insurance Company : </label>
<input   name="ins_company" class="form-control"  type="text" id="ins_company" value="<?=$ins_company ?>"/>
</div>
<div class="col-md-6 form-group">
<label class="label" for="PBI_MOTHER_NAME">Charge Payable : </label>
<input   name="charge_pay" class="form-control"  type="text" id="charge_pay" value="<?=$charge_pay ?>"/>
</div>
<div class="col-md-6 form-group">
<label class="label" for="PBI_MOTHER_NAME">Start Date : </label>
<input   name="ins_start_date" class="form-control"  type="text" id="ins_start_date" value="<?=$ins_start_date ?>"/>
</div>
<div class="col-md-6 form-group">
<label class="label" for="PBI_MOTHER_NAME">Recurring Period : </label>
<select   name="rec_period" class="form-control"  type="text" id="rec_period">
<option></option>
 <? foreign_relation('vehicle_recurring_period','id','period_name',$rec_period,' 1');?>
</select>
</div>
<div class="col-md-6 form-group">
<label class="label" for="PBI_MOTHER_NAME">End Date : </label>
<input   name="ins_end_date" class="form-control"  type="text" id="ins_end_date" value="<?=$ins_end_date ?>"/>
</div>
<div class="col-md-6 form-group">
<label class="label" for="PBI_MOTHER_NAME">Recurring Date : </label>
<input   name="rec_date" class="form-control"  type="text" id="rec_date" value="<?=$rec_date ?>"/>
</div>
<div class="col-md-6 form-group">
<label class="label" for="PBI_MOTHER_NAME">Remarks : </label>
<input   name="ins_note" class="form-control"  type="text" id="ins_note" value="<?=$ins_note ?>"/>
</div>
</div>
</div>
</div>
<div class="card">
<div style="font-weight:bold; font-size:16px; background-color:#E74386; z-index: 0!important; text-transform:uppercase; color:#fff" class="card-header">
<center>
Document/Equipment Information
</center>
</div>
<div class="card-body">
<div class="row">
<div class="col-md-12 form-group">
<label class="label" for="PBI_MOTHER_NAME"></label>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
Add New
</button>
</div>
<table class="table table-bordered">
<thead>
<tr>
<th>Type Name</th>
<th>Issue Date</th>
<th>Expire Date</th>
<th>Note</th>
</tr>
</thead>
<tbody>
<? /* php  $type='select * from vehicle_doc_type where vehicle_id='.$$unique.'';
$typequery=db_query($type);
while($tdata=mysqli_fetch_object($typequery)){
?>
<tr>
<td><?=$tdata->type_name?></td>
<td><?=$tdata->issue_date?></td>
<td><?=$tdata->exp_date?></td>
<td><?=$tdata->doc_note?></td>
</tr>
<? } */?>
</tbody>
</table>


</div>
</div>
</div>
</div>


</div>
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
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add New Document Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Type Name:</label>
               <input type="text" class="form-control" name="type_name" placeholder="Enter Type Name">
          </div>
        <div class="form-group">
            <label for="recipient-name" class="col-form-label">Issue Date:</label>
               <input type="text" class="form-control" name="issue_date" id="issue_date">
          </div>
		    <div class="form-group">
            <label for="recipient-name" class="col-form-label">Expire Date:</label>
               <input type="text" class="form-control" name="exp_date" id="exp_date">
          </div>
		     <div class="form-group">
            <label for="recipient-name" class="col-form-label">Note:</label>
               <input type="text" class="form-control" name="doc_note">
          </div>
		   <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="doc_submit" class="btn btn-primary">Save</button>
      </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?
require_once SERVER_CORE."routing/layout.bottom.php";



?>
