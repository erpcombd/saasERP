<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL); 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


do_datatable('table_head');

$title = "Driver List";

$page = 'driver_list.php';

$pages = 'driver_info.php';

$table = 'vehicle_driver_info';

$crud = new crud($table);


?>





    <style>

        td {

            text-align: center!important;

        }

    </style>





    <div class="row well">

        <div class="col-xs-12 text-right">


            <a href="driver_info.php" class="btn btn-md btn-success"><i class="glyphicon glyphicon-plus"></i> New</a>

            

        </div>

    </div>

            

    <div class="row"  style="overflow-x:auto;">

        <div class="col-md-12 col-xs-12">

            

            <table id="table_head" class="table table-bordered" cellspacing="0"  width="100%">

                <thead>

                    <tr>


                        <th>Driver Name</th>

                        <th>Driver Contact</th>
                        
                        <th>Driver Nid</th>

                       
                        <th>Licence Number</th>
                        
                        
                         
                          <th>Status</th>

                        

                    </tr>

                </thead>

                <tbody>

                    

                    <?php

                    

                        $qry = "SELECT * FROM $table";

                        $rslt = db_query($qry);

                        while($data = mysqli_fetch_object($rslt)){

                    

                    ?>

                    

                    <tr>
<? $attpage='../../../../media_attachment/vehicle/';?>
  <td>
                           
                            <a class="btn btn-xs btn-warning" style="color:black;" href="<?=$pages?>?update=<?=$data->id?>">
                            <strong><?php echo $data->d_name ?></strong>
                            </a>
                            </td>

                        <td><?=$data->d_number?></td>

                        <td> <a class="btn btn-xs btn-success" style="color:black;" href="<?=$attpage.'driver_nid/'.$data->nid_file?>">
                            <strong><?=$data->nid_number ?></strong></td>

                        <td><a class="btn btn-xs btn-success" style="color:black;" href="<?=$attpage.'driver_licence/'.$data->licence_file?>">
                            <strong><?=$data->licence_number?></strong></td>
                        
                        <td><?if($data->status==1){
                        echo 'ACTIVE';
                        }else{
                        echo 'INACTIVE';
                        }?> </td>

                      
                    

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

