<?php require_once "../../../assets/template/layout.top.php"; 
//find_a_field('vehicle_requisition','req_no','from_date="'.$_POST['fdate'].'"');

?>
<center><b><?=find_a_field('vehicle_info','vehicle_name','vehicle_id="'.$_POST['vehicle'].'"');?></b> Schedule List</center>
       <div class="container-fluid pt-5 p-0 ">
                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Req No</th>
                        <th>Vehicle Type</th>
                        <th>assign Vehicle</th>
                        <th>Driven By</th>
                        <th>From Time</th>
                        <th>To Time</th>
                    </tr>
                    </thead>
                    <tbody class="tbody1">
                        <?
                         $sql='select * from vehicle_requisition where from_date between "'.$_POST['fdate'].'" and "'.$_POST['fdate'].'" and assign_vehicle="'.$_POST['vehicle'].'"';
                         $query=mysql_query($sql);
                         while($data=mysql_fetch_object($query)){
                        ?>
                        <tr>
                            <td><?=$data->req_no?></td>
                            <td><?=find_a_field('vehicle_type','type','id="'.$data->vehicle_type.'"');?></td>
                            <td><?=find_a_field('vehicle_info','vehicle_name','vehicle_id="'.$data->assign_vehicle.'"');?></td>
                            <td><?=find_a_field('driver_info','driver_name','driver_id="'.$data->driven_by.'"');?></td>
                            <td><?=$data->from_date." ".date('h:i A', strtotime($data->from_time)) ?></td>
                            <td><?=$data->to_date." ".date('h:i A', strtotime($data->to_time)) ?></td>
                        </tr>
                        <?}?>
                    </tbody>
                </table>
       </div>



