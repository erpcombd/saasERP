<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL); 


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title = "Request Approval";

$table = "vehicle_req_list"; 


$crud = new crud($table);




$user_id = 'SELECT * FROM user_activity_management WHERE 1';
$user_id_res = db_query($user_id);
while($user_id_row = mysqli_fetch_object($user_id_res)){
    $user_name[$user_id_row->user_id] = $user_id_row->fname;
   
}



 $statusQry = 'SELECT * FROM vehicle_approval_details WHERE 1';
 $status_res = db_query($statusQry);
 while($status_row = mysqli_fetch_object($status_res)){
    $status_App_Id[$status_row->req_no][$status_row->app_type]= $status_row->approved_by;
 };

 $v_type_Qry = 'SELECT * FROM  vehicle_type_list WHERE 1';
 $v_type_res = db_query($v_type_Qry );
 while($v_type_row = mysqli_fetch_object($v_type_res)){
    $v_type_name[$v_type_row->id]= $v_type_row->type_name;
 };

 $v_info_qry = 'SELECT * FROM  vehicle_information WHERE 1';
 $v_info_res = db_query($v_info_qry );
 while($v_info_row = mysqli_fetch_object($v_info_res)){
    $v_info_name[$v_info_row->id]= $v_info_row->vehicle_model;
 };



 $data = find_all_field($table, '', 'id="'.$_GET['id'].'"');


 $return_data = find_all_field('return_vehicle_trip', '', 'req_no="'.$_GET['id'].'"');





?>
<style>
    h3, h5  {
        font-size:20px !important;
    }
</style>
<div style= 'min-height: 100vh'>
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
   
            <a href="vehicle_req_list.php" class="btn btn-warning"><i class="bi bi-arrow-left"></i> Back</a>
        </div>

        <div class="mt-3 p-4 bg-light rounded">
            <h3 class="text-center">Trip Entry BY : <?=$user_name[$data->entry_by]?></h3>
            <h5 class="text-center">Trip No : <?= $data->id?></h5>

            <div class="row mt-4">
                <div class="col-md-6">
                    <p><strong>From Location :</strong> <?=$data->from_location?> </p>
                    <p><strong>To Location :</strong> <?=$data->to_location?> </p>
                    <p><strong>Start Date:</strong> <?=$data->FromDate?>   &nbsp; <?=$data->StartTime?>  </p>
                    <p><strong>End Date:</strong> <?=$data->ToDate?>  &nbsp; <?=$data->ENDTime?>  </p>
                    <p><strong>Note:</strong> <?=$data->ToDate?>  &nbsp; <?=$data->note?> </p>
                    <p><strong>Entry at:</strong> 2025-02-22 10:58:51</p>
                </div>
                <div class="col-md-6 border-start">
                    <p><strong>Vehicle Type:</strong> <?=$v_type_name[$data->approved_vehicle_type]?></p>
                </div>
            </div>

            <!-- <div class="mt-4">
                <label for="note" class="form-label">Add Additional Note</label>
                <textarea class="form-control" id="note" rows="3"></textarea>
                <button class="btn btn-success mt-2">Add Note</button>
            </div> -->
        </div>
    </div>
    <br>
    <br>


    <div class="container">

        <div class="mt-3 p-4 bg-light rounded">
            <h3 class="text-center" >Return Trip <?=$user_name[$return_data->entry_by]?></h3>
            <h5 class="text-center">Return Trip No : <?=$return_data->id?></h5>

            <div class="row mt-4">
                <div class="col-md-6">
                    <p><strong>From Location :</strong> <?=$return_data->from_location?> </p>
                    <p><strong>To Location :</strong> <?=$return_data->to_location?> </p>
                    <p><strong>Start Date:</strong> <?=$return_data->FromDate?>   &nbsp; <?=$return_data->StartTime?>  </p>
                    <p><strong>End Date:</strong> <?=$return_data->ToDate?>  &nbsp; <?=$return_data->ENDTime?>  </p>
                    <p><strong>Note:</strong> <?=$return_data->ToDate?>  &nbsp; <?=$return_data->note?> </p>
                    <p><strong>Entry at:</strong><?=$return_data->entry_at?></p>
                </div>
                <div class="col-md-6 border-start">
                  
                </div>
            </div>

            <!-- <div class="mt-4">
                <label for="note" class="form-label">Add Additional Note</label>
                <textarea class="form-control" id="note" rows="3"></textarea>
                <button class="btn btn-success mt-2">Add Note</button>
            </div> -->
        </div>
    </div>

</div>
  




<?
	require_once SERVER_CORE."routing/layout.bottom.php";
?>