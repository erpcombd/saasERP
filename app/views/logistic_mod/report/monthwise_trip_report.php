<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL); 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

do_datatable('table_head');


$title = "Vehicle REQ List";

$page = 'vehicle_req_list.php';

$pages = 'driver_info.php';

$table = 'vehicle_req_list';

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

 $return_trip_qry = 'SELECT * FROM return_vehicle_trip WHERE 1';
 $return_trip_res = db_query($return_trip_qry);
 while($ret_trip_row = mysqli_fetch_object($return_trip_res)){
    $ret_trip_amt[$ret_trip_row->req_no]= $ret_trip_row->rent_amt;
    $ret_trip_ven[$ret_trip_row->req_no] = $ret_trip_row->customer_info;
 };

 $customer_list_qry = 'SELECT * FROM  customer_list WHERE 1';
 $customer_res = db_query($customer_list_qry );
 while($customer_row = mysqli_fetch_object($customer_res)){
    $customer_name[$customer_row->id]= $customer_row->customer_name;
 };




?>





    <style>

        td {

            text-align: center!important;

        }

    </style>





    <div class="row well">
<!-- 
        <div class="col-xs-12 text-right">


            <a href="manual_req.php" class="btn btn-md btn-success"><i class="glyphicon glyphicon-plus"></i> New</a>

            

        </div> -->

    </div>

            

    <div class="row"  style="overflow-x:auto;">

        <div class="col-md-12 col-xs-12">

            

            <table id="table_head" class="table table-bordered"  width="100%">

                <thead>

                    <tr>
                        <th style="width:20px">ID</th>
                        <th>Trip Date</th>
                        <th>Vehicle Info</th>
                        <th>Employee Name</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Rent Amount</th>
                        <th>Note</th>
                        <th>Vendor</th>
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
                    <td><?=$data->FromDate?></td>
                    <td ><?=$v_info_name[$data->approved_vehicle]?></td>
                    <td>
                        <a>
                            <strong><?=$user_name[$data->entry_by] ?></strong>
                        </a>
                    </td>

                    <!--<td ><a class="btn btn-xs btn-warning" style="white-space: normal;color:black;">-->
                  
                                <!--</a></td>-->

                    <td> From: <?=$data->from_location ?> <br>
                    To: <?=$data->to_location ?>
                    </td>
                        
                    <td><a style="white-space: normal;padding:1px;"><?='Start :'.$data->FromDate.'<br>End:'.$data->ToDate?></a></td>
                        
                    <td><a style="white-space: normal;padding:1px;"><?='Start :'.$data->StartTime.'<br>End:'.$data->ENDTime?></a></td>

                    <td>
                        On Trip: <?=$data->rent_amt?><br>
                        Ret Trip: <?=$ret_trip_amt[$data->id]?> 
                    </td>
                    <td>
                        On Trip: <?=$customer_name[$data->customer_info]?><br>
                        Ret Trip: <?=$customer_name[$ret_trip_ven[$data->id]]?>    
                    </td>

                    <td><?=$data->note?> </td>
                              
                        <td>
                            <a class="btn btn-warning" href="req_approve_list.php?id=<?=$data->id?>"><strong>View</strong> </a>
                               <br> 

                            <? $return_trip = find_a_field('return_vehicle_trip','count(id)','req_no ="'.$data->id.'" ');
                            if($return_trip == 0){
                            ?>   
                            <a class="btn btn-danger" href="return_trip.php?id=<?=$data->id?>"><strong>Return Trip</strong> </a>
                            <br>
                            <?}?>
                            <? $cost_id = find_a_field('vehicle_cost_master','id','req_no = "'.$data->id.'"');
                            if($cost_id > 0){?>
                                  <a class="btn btn-success" href="../vehicle_cost/add_cost.php?id=<?= $cost_id ?>&req_no=<?= $data->id ?>"><strong>Cost Entry</strong> </a>
                            <? }else{ ?>
                            <a class="btn btn-success" href="../vehicle_cost/add_cost.php?req_no=<?=$data->id?>"><strong>Cost Entry</strong> </a>
                            <? } ?>
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

