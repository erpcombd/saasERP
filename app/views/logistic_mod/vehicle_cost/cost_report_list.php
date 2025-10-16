<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL); 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

do_datatable('table_head');

$title = "Cost Report List";

$table = 'vehicle_cost_master';

$vehicle_qry = 'SELECT * FROM vehicle_information WHERE 1';
$vehicle_res = db_query($vehicle_qry);
while($vehicle_rows = mysqli_fetch_object($vehicle_res)){
    $vehicle_name[$vehicle_rows->id] = $vehicle_rows->vehicle_model;
}

$driver_qry = 'SELECT * FROM  vehicle_driver_info WHERE 1';
$driver_res = db_query($driver_qry);
while($driver_rows = mysqli_fetch_object($driver_res)){
    $driver_name[$driver_rows->id] = $driver_rows->d_name;
}


?>


    <!-- <style>
        td {
            text-align: center!important;
        }
    </style> -->


    <div class="row">
        <div class="col-12">
            
            <form method="post">
                
            <div class="row well">
                <div style="float:left;">
                <div class="row">
                    <div class="form-group col-6">
                        <input type="date" name="from_date" value="<?=$_POST['from_date']?>" placeholder="From..." class="form-control">
                    </div>
                    <div class="form-group col-6">
                        <input type="date" name="to_date" value="<?=$_POST['to_date']?>" placeholder="to..." class="form-control">
                    </div>
                    <div class="form-group col-2">
                        <input type="submit" name="filter" value="Filter" class="btn btn-primary">
                    </div>
                </div>
            </div>
            
                <div style="margin:auto;">
                    <!-- <a href="add_cost.php" class="btn btn-md btn-success" style="margin-top:10px!important;margin-bottom:10px!important;">
                        <i class="glyphicon glyphicon-plus"></i> Add New Cost
                    </a> -->
                </div>
        </div>

                
            </form>
            
        </div>
    </div>
            
        
    <div class="row">
        
        <div class="col-12">
            
            <table id="table_head" class="table">
                
                <thead>
                    <tr>
                        <th style="width:20px">ID</th>
                       <th>Vehicle No</th> 
                       <th>Date</th> 
                       <th>Driver</th>
                       <th>Note</th>
                       <th style="width:40px">Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    
                    <?php
                    
                        $con = '1';
                        
                        if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
                            $con .= " entry_date BETWEEN '".$_POST['from_date']."' AND '".$_POST['to_date']."' ";
                        }else if($_POST['from_date'] != '' && $_POST['to_date'] == ''){
                            $con .= " AND entry_date > '".$_POST['from_date']."' ";
                        }else if($_POST['from_date'] == '' && $_POST['to_date'] != ''){
                            $con .= " AND entry_date < '".$_POST['to_date']."' ";
                        }

                        $sql = "SELECT * FROM $table WHERE ".$con." ORDER BY entry_at DESC";
                        $rslt = db_query($sql);
                        while($data = mysqli_fetch_object($rslt)){
                    
                    ?>
                    
                    <tr>
                       <td><?=$data->id?></td> 
                       <td><?=$vehicle_name[$data->vehicle_id]?></td> 
                       <td><?=$data->entry_date?></td>
                       <td><?=$driver_name[$data->driver_id]?></td>
                       <td><?=$data->note?></td>
                       <td>
                        <a class="btn btn-xs btn-block btn-info"  href="cost_report.php?id=<?=$data->id?>&req_no=<?=$data->req_no?>">VIEW</a>
                        </td>
                    </tr>
                    
                    <?php
                    
                        $cnt++;
                        
                        }
                    
                    ?>
                    
                </tbody>
                
            </table>
            
        </div>
        
    </div>
    
    

<?
	require_once SERVER_CORE."routing/layout.bottom.php";
?>


<script>
        $('#example').DataTable({
            order: [[3, 'desc']],
        });
</script>