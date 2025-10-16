<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL); 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title = "Vehicle List";



$page = 'manual_req.php';



$table = 'vehicle_req_list';

$crud = new crud($table);



if(isset($_POST['insert'])){
        
    $_POST['entry_by'] = $_SESSION['user']['id'];


        $crud->insert();

        echo "<script>location.href='vehicle_req_list.php';</script>";

        exit;

        

    // }

}



if(isset($_POST['remove'])){

    

    $qry = "DELETE FROM $table WHERE id = '".$_POST['id']."'";

    db_query($qry);

    

    echo "<script>location.href='".$page."';</script>";

    exit;

}







$datas = find_all_field($table, '', 'id="'.$_GET['update'].'"');


?>





    <style>

        td {

            text-align: center!important;

        }

    </style>


      <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Manual Requisition</h5>
            </div>
            <div class="card-body">
                <form  method="POST">
                     <div class="mb-3">
                        <label class="form-label">Vehicle Category<span class="text-danger">*</span></label>
                        <select class="form-select ajax-select" name="category" id="vehicleCategory">
                            <option>Nothing selected</option>
                            <? foreign_relation('vehicle_category','id','category_name',$category_name,'status = "1" ');?>
                        </select>
                    </div>
                    
                    <div id="responseMessage" style="margin-top: 10px; font-weight: bold;"></div>
                    
            <div class="mb-3">
                        <label class="form-label">Person<span class="text-danger">*</span></label>
                        <select class="form-select" name="person">
                            <option>Nothing selected</option>
                            <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$person,'1');?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Driver Incharge: <span class="text-danger">*</span></label>
                        <select class="form-select" name  = "approved_driver">
                            <option>--SELECT--</option>
                             <? foreign_relation('vehicle_driver_info','id','d_name',$approved_driver,'1');?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vehicle Type: <span class="text-danger">*</span></label>
                        <select class="form-select" name = "approved_vehicle_type">
                            <option>--SELECT--</option>
                            <? foreign_relation('vehicle_type_list','id','type_name',$approved_vehicle_type,'1');?>
                        </select>
                    </div>
                    
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

                        <select name="customer_info" class="form-select ajax-select"  id="customer_info" >
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
                        <div id="own_div" style="height:300px; overflow-y: auto;">
                              
                            <label>Vehicle List <span class="text-danger">*</span></label>

                             <div class="search-container" style = "display: flex">
                            <label for="column">Select Column:</label>
                            <select id="column" class="col-3" >
                              <option value="0">Vehicle Name</option>
                              <option value="1">Seat</option>
                              <option value="2">Start Time</option>
                              <option value="3">End Time</option>
                              <option value="4">Location</option>
                            </select>
                        
                        <label for="keyword">Enter Keyword:</label>
                             <input type="text" class="col-3" id="keyword" placeholder="Search..." onkeyup="searchTable()">
                          </div>
                          <br>
                                
                               <table border="2" id="vehicleTable" class="example table">
                                    <thead>
                                        <th>Vehicle Name</th>
                                        <th>Seat</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Location</th>
                                    </thead>
                                    <tbody>
                                        <?
                                        $v_details_qry = 'SELECT 
                                            v.approved_vehicle,
                                            v.FromDate,
                                            v.ToDate,
                                            v.StartTime,
                                            v.ENDTime,
                                            v.from_location,
                                            v.to_location
                                        FROM 
                                            vehicle_req_list v
                                        JOIN 
                                            (SELECT 
                                                 approved_vehicle, MAX(id) AS max_id
                                             FROM 
                                                 vehicle_req_list
                                             WHERE 
                                                 1
                                             GROUP BY 
                                                 approved_vehicle) AS sub
                                        ON 
                                            v.approved_vehicle = sub.approved_vehicle 
                                            AND  v.approved_vehicle > 0 
                                            AND v.id = sub.max_id ';
                                         $v_details_res = db_query($v_details_qry);
                                        while($vehicle_details_rows =  mysqli_fetch_object($v_details_res)){
                                        $FromDate[$vehicle_details_rows->approved_vehicle]=$vehicle_details_rows->FromDate;
                                             
                                        $ToDate[$vehicle_details_rows->approved_vehicle]=$vehicle_details_rows->ToDate;
                                        
                                        $StartTime[$vehicle_details_rows->approved_vehicle]=$vehicle_details_rows->StartTime;
                                        
                                         $ENDTime[$vehicle_details_rows->approved_vehicle]=$vehicle_details_rows->ENDTime;
                                         
                                         $FromLocation[$vehicle_details_rows->approved_vehicle]=$vehicle_details_rows->from_location;
                                         $ToLocation[$vehicle_details_rows->approved_vehicle]=$vehicle_details_rows->to_location;
                                        }
                                        

                                    
                                        
                                        
                                        $vehicle_name_qry = 'SELECT id,vehicle_model, sit_number FROM vehicle_information WHERE 1';
                                        $vh_name_res = db_query($vehicle_name_qry);
                                        while($vehicle_name_rows =  mysqli_fetch_object($vh_name_res)){
                                        ?>
                                        <tr>
                                            
                                            <?php
                                            
                                                // $sSchedule = date('Y-m-d H:i:s', strtotime($FromDate.' '.$StartTime));
                                                
                                                // $eSchedule = date('Y-m-d H:i:s', strtotime($ToDate.' '.$ENDTime));
                                                
                                                // //FIX THIS CONDITION
                                                // if(date('Y-m-d H:i:s') >= $sSchedule && date('Y-m-d H:i:s') <= $eSchedule){
                                                //     $alreadyAvailed = 1;
                                                // }else{
                                                //     $alreadyAvailed = 0;
                                                // }
                                                
                                                // $alreadyAvailed = 0;



                                                           
                                                if (isset($FromDate[$vehicle_name_rows->id]) && isset($StartTime[$vehicle_name_rows->id])) {
                                                    $sSchedule = date('Y-m-d H:i:s', strtotime($FromDate[$vehicle_name_rows->id] . ' ' . $StartTime[$vehicle_name_rows->id]));
                                                } else {
                                                    $sSchedule = null; // Handle missing values
                                                }


                                                if (isset($ToDate[$vehicle_name_rows->id]) && isset($ENDTime[$vehicle_name_rows->id])) {
                                                    $eSchedule = date('Y-m-d H:i:s', strtotime($ToDate[$vehicle_name_rows->id] . ' ' . $ENDTime[$vehicle_name_rows->id]));
                                                } else {
                                                    $eSchedule = null; // Handle missing values
                                                }
                                                    
                                                    
                                                    
                                                            $alreadyAvailed = (date('Y-m-d H:i:s') >= $sSchedule && date('Y-m-d H:i:s') <= $eSchedule) ? 1 : 0;
                                                
                                            
                                            ?>
                                            
                                            <?php if($alreadyAvailed == 0){ ?>
                                            
                                            <td><input type="checkbox" name="approved_vehicle" value="<?=$vehicle_name_rows->id?>" style="height: 14px !important;" />
                                            <?=$vehicle_name_rows->vehicle_model?></td>
                                            <td>Total:<?=$vehicle_name_rows->sit_number?><br>Avail:<??></td>
                                            
                                            <td><?=$FromDate[$vehicle_name_rows->id]?><br> <?=$StartTime[$vehicle_name_rows->id]?></td>
                                            
                                            <td><?=$ToDate[$vehicle_name_rows->id]?><br> <?=$ENDTime[$vehicle_name_rows->id]?></td>
                                            
                                            <td><?=$Location[$vehicle_name_rows->id]?></td>
                                        
                                        <?php }else{ ?>
                                        
                                        <td style="background:red;color:white;"><input type="checkbox" disabled style="height: 14px !important;" />
                                            <?=$vehicle_name_rows->vehicle_model?></td>
                                            <td style="background:red;color:white;">Total:<?=$vehicle_name_rows->sit_number?><br>Avail:<??></td>
                                            <td style="background:red;color:white;"><?=$FromDate[$vehicle_name_rows->id]?><br> <?=$StartTime[$vehicle_name_rows->id]?></td>
                                            
                                            <td style="background:red;color:white;"><?=$ToDate[$vehicle_name_rows->id]?><br> <?=$StartTime[$vehicle_name_rows->id]?></td>
                                            
                                            <td style="background:red;color:white;"><?=$FromLocation[$vehicle_name_rows->id]?>
                                            <br>
                                            <?=$ToLocation[$vehicle_name_rows->id]?>
                                        </td>
                                        
                                        <?php } ?>
                                        
                                        </tr>
                                        <?}?>
                                    </tbody>
                                </table>
                            
                        </div>

                            
                        
                    <input type="submit" name ="insert" class="btn btn-primary" value="Insert"/>
                </form>
            </div>
        </div>
    </div>


  
 <script>
            function searchTable() {
              const column = document.getElementById('column').value;
              const keyword = document.getElementById('keyword').value.toLowerCase();
              const table = document.getElementById('vehicleTable');
              const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
    
              for (let i = 0; i < rows.length; i++) {
                const cell = rows[i].getElementsByTagName('td')[column]; 
                if (cell) {
                  const text = cell.textContent || cell.innerText;
               
                  if (text.toLowerCase().includes(keyword)) {
                    rows[i].style.display = ''; 
                  } else {
                    rows[i].style.display = 'none';
                  }
                }
              }
            }
</script>



<script>
$(document).ready(function() {
    $('.ajax-select').change(function() {
        var selectedValue = $(this).val(); // Get selected value
        var fieldName = $(this).attr('id'); // Get the ID of the changed field
        var dataToSend = {}; // Create an empty object

        if (fieldName === 'vehicleCategory') {
            dataToSend['category'] = selectedValue; // Send category data
            var responseDiv = '#responseMessage'; // Target response div
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

