<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once SERVER_CORE."routing/inc.notify.php";

// ::::: Edit This Section ::::: 
$title = 'Vehical Requisition'; // Page Name and Page Title
$page = "vehical_requisition.php"; // PHP File Name

$table = 'vehicle_requisition'; // Database Table Name Mainly related to this page
$unique = 'req_no'; // Primary Key of this Database table
// ::::: End Edit Section :::::
$crud = new crud($table);


if ($_GET['id'] > 0) {
    $condition = "req_no=" . $_GET['id'];

    $data = db_fetch_object($table, $condition);

    foreach ($data as $key => $value) {
        $$key = $value;
    }

}

?>
<form action="" method="post">
    <div class="card">
        <div class="card-body">
            <div class="row">

                <div class="col-md-4 form-group">
                    <label class="label" for="PBI_MOTHER_NAME">Vehicle Type : </label>
                    <select name="vehicle_type" class="form-control" type="text" id="vehicle_type" disabled>
                        <option value=""></option>
                        <? foreign_relation('vehicle_type', 'id', 'type', $vehicle_type, ' 1'); ?>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label class="label" for="PBI_MOTHER_NAME">Requisition For : </label>
                    <input name="req_for" class="form-control" type="text" id="req_for" value="<?= $req_for ?>"
                        readonly />
                </div>
                <div class="col-md-4 form-group">
                    <label class="label" for="PBI_MOTHER_NAME">Number of Passenger: </label>
                    <input name="passenger" class="form-control" type="text" id="passenger" value="<?= $passenger ?>"
                        readonly />
                </div>
                <div class="col-md-3 form-group">
                    <label class="label" for="PBI_MOTHER_NAME">From Date : </label>
                    <input class="form-control" type="text" id="from_date" value="<?= $from_date ?>" readonly />
                </div>
                <div class="col-md-3 form-group">
                    <label class="label" for="PBI_MOTHER_NAME">To Date : </label>
                    <input class="form-control" type="text" id="to_date" value="<?= $to_date ?>" readonly />
                </div>
                <div class="col-md-3 form-group">
                    <label class="label" for="PBI_MOTHER_NAME">From Time : </label>
                    <input class="form-control" type="time" id="from_time" value="<?= $from_time ?>" readonly />
                </div>
                <div class="col-md-3 form-group">
                    <label class="label" for="PBI_MOTHER_NAME">To Time : </label>
                    <input class="form-control" type="time" id="to_time" value="<?= $to_time ?>" readonly />
                </div>
                <div class="col-md-3 form-group">
                    <label class="label" for="PBI_MOTHER_NAME">Where From : </label>
                    <input name="where_from" class="form-control" type="text" id="where_from" value="<?= $where_from ?>"
                        readonly />
                </div>
                <div class="col-md-3 form-group">
                    <label class="label" for="PBI_MOTHER_NAME">Where To : </label>
                    <input name="where_to" class="form-control" type="text" id="where_to" value="<?= $where_to ?>"
                        readonly />
                </div>


                <div class="col-md-6 form-group">
                    <label class="label" for="PBI_MOTHER_NAME">Details : </label>
                    <textarea name="details" class="form-control" type="text" id="details"
                        readonly><?= $details ?></textarea>
                </div>
                <div class="col-md-3 form-group">
                    <label class="label" for="PBI_MOTHER_NAME">Assign Vehicle : </label>
                    <select name="assign_vehicle" class="form-control" type="text" id="assign_vehicle">
                        <option value=""></option>
                        <? foreign_relation('vehicle_info', 'vehicle_id', 'vehicle_name', $assign_vehicle, ' 1'); ?>
                    </select>
                </div>
                <div class="col-md-3 form-group">
                    <label class="label" for="PBI_MOTHER_NAME">Driven By : </label>
                    <select name="driven_by" class="form-control" type="text" id="driven_by">
                        <option value=""></option>
                        <? foreign_relation('driver_info', 'driver_id', 'driver_name', $driven_by, ' 1'); ?>
                    </select>
                </div>

            </div>
            <hr>
            <div class="col-md-12 form-group">
                <span id="results"></span>
            </div>


        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $("#assign_vehicle").change(function () {
            var fdate = $("#from_date").val();
            var tdate = $("#to_date").val();
            var from = $("#from_time").val();
            var to = $("#to_time").val();
            var vehicle = $("#assign_vehicle").val();

            $.ajax({
                url: "req_ajax.php",
                cache: false,
                method: "POST",
                data: { fdate: fdate, tdate: tdate, from: from, to: to, vehicle: vehicle },

                success: function (html) {
                    $("#results").html(html);
                }
            });
        })

    });


</script>
<? require_once SERVER_CORE."routing/layout.bottom.php"; ?>