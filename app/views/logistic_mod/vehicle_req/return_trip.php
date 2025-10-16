<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL); 


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title = "Request Approval";

$table = "vehicle_req_list"; 

$table2 = "return_vehicle_trip";

$crud = new crud($table2);




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






if(isset($_POST['insert'])){
        
    $_POST['entry_by'] = $_SESSION['user']['id'];


        $crud->insert();

        echo "<script>location.href='return_trip_list.php';</script>";

        exit;

}


?>
<div style= 'min-height: 100vh'>
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Trip Details</h4>
            <a href="vehicle_req_list.php" class="btn btn-warning"><i class="bi bi-arrow-left"></i> Back</a>
        </div>

        <div class="mt-3 p-4 bg-light rounded">
            <h3 class="text-center">Requisition BY : <?=$user_name[$data->entry_by]?></h3>
            <h5 class="text-center">Requisition No : <?=$data->id?></h5>

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

           
        </div>
    </div>



    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Return Trip:</h5>
            </div>
            <div class="card-body">
                <form  method="POST">
                <input type="text" name = "req_no" value="<?=$data->id?>" class="form-control"  hidden>
                <div class="mb-3">
                        <label class="form-label">Vehicle Category<span class="text-danger">*</span></label>
                        <select class="form-select ajax-select" name="category" id="vehicleCategory">
                            <option>Nothing selected</option>
                            <? foreign_relation('vehicle_category','id','category_name',$category_name,'status = "1" ');?>
                        </select>
                    </div>
                    
                    <div id="responseMessage" style="margin-top: 10px; font-weight: bold;"></div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" name = "FromDate">From Date: <span class="text-danger">*</span></label>
                            <input type="date" name = "FromDate"  class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3" >
                            <label class="form-label">To Date: <span class="text-danger">*</span></label>
                            <input type="date" name ="ToDate" class="form-control" required>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start Time: <span class="text-danger">*</span></label>
                            <input type="time" name="StartTime" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">End Time: <span class="text-danger">*</span></label>
                            <input type="time" name="ENDTime" class="form-control">
                        </div>
                    </div>
                    
                     <div class="mb-3">
                        <label class="form-label" >From Location: <span class="text-danger">*</span></label>
                        <input type="text" name= "from_location" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label" >To Location: <span class="text-danger">*</span></label>
                        <input type="text" name= "to_location" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" >Estimated distance (in Kilo) <span class="text-danger">*</span></label>
                        <input type="number" name= "distance" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Note:</label>
                        <textarea class="form-control" rows="3" name="note" placeholder="If you have any additional info to provide"></textarea>
                    </div>
                    

                    <div class="form-group">

                        <label>Vehicle To: <span class="text-danger">*</span></label>

                        <select name="vehicle_to" class="form-select ajax-select"  id="vehicleto" >
                        <option value="">--SELECT---</option>
                            <? foreign_relation('customer_list','id','customer_name',$customer_name,'1');?>
                        </select>
                    </div>
                        <div id="responseMessageTo" style="margin-top: 10px; font-weight: bold;"></div>

                    <div class="mb-3">
                        <label class="form-label" >Rent Amount:<span class="text-danger">*</span></label>
                        <input type="number" name= "rent_amt" class="form-control">
                    </div>
                        <br>
                        <br>
                      

                            
                        
                    <input type="submit" name ="insert" class="btn btn-primary" value="Insert"/>
                </form>
            </div>
        </div>
    </div>


</div>
  
<script>
    $(document).ready(function() {
        $('.ajax-select').change(function() {
            var selectedValue = $(this).val(); // Get selected value
            var fieldName = $(this).attr('id'); // Get the ID of the changed field
            var dataToSend = {}; // Create an empty object

            if (fieldName === 'vehicleCategory') {
                dataToSend['category'] = selectedValue; // Send category data
                var responseDiv = '#responseMessage'; // Target response div
            } else if (fieldName === 'vehicleto') {
                dataToSend['vehicle_to'] = selectedValue; // Send vehicle_to data
                var responseDiv = '#responseMessageTo'; // Target response div
            }

            if (selectedValue) {
                $.ajax({
                    url: 'vehicle_select_ajax.php',
                    type: 'POST',
                    data: dataToSend, // Send dynamic data
                    success: function(response) {
                        $(responseDiv).html(response); // Update correct response div
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        $(responseDiv).html('<span style="color: red;">Error loading data</span>');
                    }
                });
            } else {
                $(responseDiv).html('<span style="color: gray;">Please select a valid option.</span>');
            }
        });
    });
</script>



<?
	require_once SERVER_CORE."routing/layout.bottom.php";
?>