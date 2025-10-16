<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL); 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

do_datatable('table_head');


$title = "Return REQ List";

$page = 'return_trip.php';

$table = 'return_vehicle_trip';

$crud = new crud($table);




$user_id = 'SELECT * FROM user_activity_management WHERE 1';
$user_id_res = db_query($user_id);
while($user_id_row = mysqli_fetch_object($user_id_res)){
    $user_name[$user_id_row->user_id] = $user_id_row->fname;
   
}



 $vehicle_req_Qry = 'SELECT * FROM vehicle_req_list WHERE 1';
 $vehicle_req_res = db_query($vehicle_req_Qry);
 while($vehicle_req_row = mysqli_fetch_object($vehicle_req_res)){
    $v_req_vehicle_Id[$vehicle_req_row->id]= $vehicle_req_row->approved_vehicle;
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



?>





    <style>

        td {

            text-align: center!important;

        }

    </style>





    <div class="row well">

        <div class="col-xs-12 text-right">


            <a href="manual_req.php" class="btn btn-md btn-success"><i class="glyphicon glyphicon-plus"></i> New</a>

            

        </div>

    </div>

            

    <div class="row"  style="overflow-x:auto;">

        <div class="col-md-12 col-xs-12">

            

            <table id="table_head" class="table table-bordered"  width="100%">

                <thead>

                    <tr>
                        <th style="width:20px">ID</th>
                        <th>Vehicle Info</th>
                        <th>Trip No</th>
                        <th>Return Trip No</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Vehicle Type</th>
                        <th>Note</th>
                        <th>Action</th>
                    </tr>

                </thead>

                <tbody>

                    

                    <?php

                        $qry = "SELECT * FROM $table where 1 order by id DESC";
                        $rslt = db_query($qry);
                        while($data = mysqli_fetch_object($rslt)){

                    ?>

                    

                <tr>
                    <td style="width:20px"><?=$data->id?></td>
                    <td ><?=$v_info_name[$v_req_vehicle_Id[$data->req_no]]?> </td>
                    <td><a><strong><?=$data->req_no?></strong></a></td>
                    <td><a><strong><?=$data->id?></strong></a></td>
                    <td> From: <?=$data->from_location ?> <br>
                    To: <?=$data->to_location ?>
                    </td>
                        
                    <td><a style="white-space: normal;padding:1px;"><?='Start :'.$data->FromDate.'<br>End:'.$data->ToDate?></a></td>
                        
                    <td><a style="white-space: normal;padding:1px;"><?='Start :'.$data->StartTime.'<br>End:'.$data->ENDTime?></a></td>

                    <td><?=$v_type_name[$data->approved_vehicle_type]?></td>
                        
                    <td><?=$data->note?> </td>
                              
                    <td>
                        <a class="btn btn-warning" href="req_approve_list.php?id=<?=$data->req_no?>"><strong>View</strong> </a>
                        <!-- <br><a class="btn btn-danger" href="return_trip.php?id=<?//=$data->id?>"><strong>Return Trip</strong> </a> -->
                    </td>
                        
                        
                      
                    

                    </tr>
                    

                    <?php $sn++; } ?>

                    

                </tbody>

            </table>

            

        </div>



        <div class="col-md-4 col-xs-12">

            

        </div>

    </div>

    

    



<?
	require_once SERVER_CORE."routing/layout.bottom.php";
?>

