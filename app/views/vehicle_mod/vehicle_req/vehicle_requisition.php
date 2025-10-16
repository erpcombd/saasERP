<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once SERVER_CORE."routing/inc.notify.php";
do_calander('#from_date');
do_calander('#to_date');
// ::::: Edit This Section ::::: 
$title='Vehical Requisition' ; 		// Page Name and Page Title
$page="vehical_requisition.php";		// PHP File Name

$table='vehicle_requisition';		// Database Table Name Mainly related to this page
$unique='req_no';			// Primary Key of this Database table
// ::::: End Edit Section :::::
$crud= new crud($table);
if(isset($_POST['submit'])){
    $_POST['entry_by']=$_SESSION['user']['id'];
    $_POST['entry_at']=date('Y-m-d H:i:s');
$crud->insert();
echo "<script>window.location.href='vehicle_req_status.php'</script>";
}
?>
<form action="" method="post">
<div class="card">
<div class="card-body">
<div class="row">

<div class="col-md-4 form-group">
<label class="label" for="PBI_MOTHER_NAME">Vehicle Type : </label>
<select name="vehicle_type" class="form-control"  type="text" id="vehicle_type">
    <option value=""></option>
    <? foreign_relation('vehicle_type','id','type',$vehicle_type,' 1');?>
</select>
</div>

<div class="col-md-4 form-group">
<label class="label" for="PBI_MOTHER_NAME">Requisition For : </label>
<input   name="req_for" class="form-control"  type="text" id="req_for" />
</div>

<div class="col-md-4 form-group">
<label class="label" for="PBI_MOTHER_NAME">Number of Passenger: </label>
<input   name="passenger" class="form-control"  type="text" id="passenger" />
</div>
<div class="col-md-3 form-group">
<label class="label" for="PBI_MOTHER_NAME">From Date : </label>
<input name="from_date" class="form-control"  type="text" id="from_date"/>
</div>
<div class="col-md-3 form-group">
<label class="label" for="PBI_MOTHER_NAME">To Date : </label>
<input name="to_date" class="form-control"  type="text" id="to_date"/>
</div>
<div class="col-md-3 form-group">
<label class="label" for="PBI_MOTHER_NAME">From Time : </label>
<input   name="from_time" class="form-control"  type="time" id="from_time" />
</div>
<div class="col-md-3 form-group">
<label class="label" for="PBI_MOTHER_NAME">To Time : </label>
<input   name="to_time" class="form-control"  type="time" id="to_time" />
</div>
<div class="col-md-3 form-group">
<label class="label" for="PBI_MOTHER_NAME">Where From : </label>
<input   name="where_from" class="form-control"  type="text" id="where_from" />
</div>
<div class="col-md-3 form-group">
<label class="label" for="PBI_MOTHER_NAME">Where To : </label>
<input   name="where_to" class="form-control"  type="text" id="where_to" />
</div>


<div class="col-md-6 form-group">
<label class="label" for="PBI_MOTHER_NAME">Details : </label>
<textarea   name="details" class="form-control"  type="text" id="details" ></textarea>
</div>
</div>
<div class="col-12 text-center">
    <button class="btn btn-success" name="submit" type="submit">Submit Requisition</button>
</div>

</div>
</div>
</form>

<? require_once SERVER_CORE."routing/layout.bottom.php";

?>