<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL); 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

do_datatable('table_head');


$title = "Other Cost List";

$page = 'other_cost_report.php';

$pages = 'driver_info.php';

$table = 'vehicle_other_cost_master';

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

 

?>





    <style>

        td {

            text-align: center!important;

        }

    </style>





    <div class="row well">

        <div class="col-xs-12 text-right">


            <a href="other_cost_entry.php" class="btn btn-md btn-success"><i class="glyphicon glyphicon-plus"></i> New</a>

            

        </div>

    </div>

            

    <div class="row"  style="overflow-x:auto;">

        <div class="col-md-12 col-xs-12">

            

            <table id="table_head" class="table table-bordered"  width="100%">

                <thead>

                    <tr>
                        <th style="width:20px">OT Cost ID</th>
                        <th>Vehicle Info</th>
                        <th>Note</th>
                        <th>Entry By</th>
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
                    <td ><?=$v_info_name[$data->vehicle_id]?></td>
                  
                    <td> From: <?=$data->from_location ?> <br>
                    To: <?=$data->note ?>
                        </td>
                        
                        <td>
                        <a>
                            <strong><?=$user_name[$data->entry_by] ?></strong>
                        </a>
                        </td>

                              
                    <td>
                            <a class="btn btn-success" href="other_cost_entry.php?id=<?=$data->id?>"><strong>Cost Entry</strong> </a>

                            <?if(find_a_field('vehicle_other_cost_details','count(id)','ot_cost_id="'.$data->id.'"') > 0){?>
                            <br><a class="btn btn-warning"  href="other_cost_print_view.php?id=<?=$data->id?>">VIEW</a>
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

