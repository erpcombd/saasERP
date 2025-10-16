<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL); 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


do_datatable('example');

$title = "Vehicle List";
$page = 'vehicle_list.php';
$pages = 'vehicle_info.php';
$table = 'vehicle_information';
$crud = new crud($table);
?>





    <style>

        td {

            text-align: center!important;

        }

    </style>





    <div class="row well">
        <div class="col-xs-12 text-right">
            <a href="vehicle_info.php" class="btn btn-md btn-success"><i class="glyphicon glyphicon-plus"></i> New</a>
        </div>
    </div>

            

    <div class="row"  style="overflow-x:auto;">
        <div class="col-md-12 col-xs-12">

            

            <table class="table" id="example"  width="100%">
                <thead>
                    <tr>
                        <th>Vehicle Name</th>
                        <th>Registration Number</th>
                        <th>Vehicle Type</th>
                        <th>Insurance Deadline</th>
                        <th>Tax Deadline</th>
                        <th>Fitness Deadline</th>
                        <th>Route Permission Deadline</th>
                        <!-- <th>Vehicle User</th>
                        <th>SBU Type</th> -->
                        <th>Status</th>
                        <th>Entry_By</th>
                    </tr>
                </thead>
                <tbody>

                    

                    <?php
                        $qry = "SELECT * FROM $table";
                        $rslt = db_query($qry);
                        while($data = mysqli_fetch_object($rslt)){
                    ?>

                    

                    <tr>
                        <td>
                            <a class="btn btn-xs btn-warning" style="color:black;" href="<?=$pages?>?update=<?=$data->id?>">
                            <?php echo $data->vehicle_model ?>
                            </a>
                            </td>
                            <? $attpage='../../../../media_attachment/vehicle/';?>

                        <td> <?if(!empty($data->reg_file) && file_exists($attpage.'vehicle_registration/'.$data->reg_file)){?><a class="btn btn-xs btn-success" style="color:black;" href="<?=$attpage.'vehicle_registration/'.$data->reg_file?>"><strong><?=$data->reg_number?></strong></a><?} else {?><strong><?=$data->reg_number?></strong><?}?></td>

                        <td><?=find_a_field('vehicle_type_list','type_name','id='.$data->vehicle_type) ?></td>

                        <td>
                            <?php if( !empty($data->insurance_file) &&  file_exists( $attpage.'vehicle_insurance/'.$data->insurance_file )){ ?>
                        <a class="btn btn-xs btn-success" style="color:black;" href="<?=$attpage.'vehicle_insurance/'.$data->insurance_file?>">
                            <strong>
                                <?=$data->insurance_deadline ?></strong>
                                <?php }else{ ?>
                                <strong><?=$data->insurance_deadline ?></strong><?php }?>
                        </td>
                        
                        <td><?if(!empty($data->tax_file) && file_exists($attpage.'vehicle_registration/'.$data->tax_file)){?><a class="btn btn-xs btn-success" style="color:black;" href="<?=$attpage.'vehicle_tax/'.$data->tax_file?>"><strong><?=$data->tax_deadline?></strong><?}else{?><strong><?=$data->tax_deadline?></strong> <? }?></td>
                        
                         <td><?if( !empty($data->fitness_file) && file_exists($attpage.'vehicle_registration/'.$data->fitness_file)){?> 
                            <a class="btn btn-xs btn-success" style="color:black;" href="<?=$attpage.'vehicle_tax/'.$data->fitness_file?>">
                                <strong><?=$data->fitness_deadline?></strong></a>
                                <? }else{?><strong><?=$data->fitness_deadline?></strong><?}?></td>
                         
                         <td><?if( !empty($data->root_permission_deadline) && file_exists($attpage.'vehicle_registration/'.$data->root_permission_deadline)){?><a class="btn btn-xs btn-success" style="color:black;" href="<?=$attpage.'vehicle_permission/'.$data->root_permission_deadline?>"><strong><?=$data->root_permission_deadline?></strong> <?}else{?><?=$data->root_permission_deadline?></strong><? }?></td>
                         
                         <!-- <td><?=find_a_field('user_activity_management','fname','user_id="'.$data->vehicle_owner.'"')?> </td>
                         
                         <td><?
                         if($data->sbu_type == 1){echo 'PMO-1';}
                         else if($data->sbu_type == 2){echo 'PMO-2';}
                         else if($data->sbu_type == 3){echo 'PMO-3';}
                         else if($data->sbu_type == 4){echo 'HEAD-OFFICE';}
                         ?> </td> -->
                         
                         <td><?if($data->status==1){
                         echo 'Active';
                         }else{
                         echo 'Inactive';
                         }?> </td>
                         <td><?=find_a_field('user_activity_management','fname','user_id="'.$data->entry_by.'"')?> </td>
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

