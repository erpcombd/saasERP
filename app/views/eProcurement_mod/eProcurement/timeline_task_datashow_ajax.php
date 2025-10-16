<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');



function calculateAdditionalDays($endDate, $actualDate) {
    $end = new DateTime($endDate);
    $actual = new DateTime($actualDate);
    $interval = $end->diff($actual);
    return $interval->days * ($interval->invert ? -1 : 1);
}


?>
            <table id="task_table_excell" class="table1  table-striped table-bordered table-hover table-sm" style=" zoom: 90%; ">

<thead class="thead1">
    <tr class="bgc-info" style="color: #f7f7f7 !important;">
        <th scope="col">SL </th>
       
        <th scope="col">Task</th>
<th scope="col">Start Date </th>
        <th scope="col">End Date  </th>
<th scope="col">Responsible Team</th>
<th scope="col">Task Owner</th>
<th scope="col">Actual Date </th>
<th scope="col">Traffic</th>
<th scope="col">Status</th>
<th scope="col">Planned Days</th>
<th scope="col">Actual Days</th>
<th scope="col">Additianl Days</th>
<th scope="col">Reason / Remarks</th>
<th scope="col">Action </th>                        
    </tr>
    </thead>
<tbody class="tbody1" id="selected_vendor_detailss_2">

<?

$sql = 'SELECT * FROM timeline_Tasks WHERE rfq_no = "' . $_SESSION['rfq_no'] . '" ORDER BY sequence';
$count=1;
$qry = db_query($sql);
while($task_data=mysqli_fetch_object($qry)){
$additionalDays = calculateAdditionalDays($task_data->endDate, $task_data->actualDate);
$plannedDays = calculateAdditionalDays($task_data->startDate, $task_data->endDate);
$actualDays = calculateAdditionalDays($task_data->startDate, $task_data->actualDate);
?>
<!-- <style>
#task_task_<?//$task_data->id?>:hover{
width: 200px !important;


}
</style> -->
<tr>
<td><span style="display:none;"><?=$task_data->sequence?></span><input class="form-control" min='0' type="number" name="sequence"      onchange="timeline_task_update('<?=$task_data->id?>',this.name,this.value)" id="task_sequence_<?=$task_data->id?>" value="<?= $task_data->sequence;?>" style=" width: 50px !important; "></td>
<td><span style="display:none;"><?=$task_data->task?></span><input class="form-control" type="text" name="task"    onchange="timeline_task_update('<?=$task_data->id?>',this.name,this.value)"  id="task_task_<?=$task_data->id?>" value="<?=$task_data->task?>" <?if($_SESSION['user_role']=='Owner'){}else{echo 'readonly';}?> style=" width: 250px !important; "></td>

<td> <span style="display:none;"><?=$task_data->startDate?></span><input class="form-control" min="<?php echo date('Y-m-d'); ?>" type="date" name="startDate"  onchange="timeline_task_update('<?=$task_data->id?>',this.name,this.value)"    id="task_start_<?=$task_data->id?>" value="<?=$task_data->startDate?>"  <?if($_SESSION['user_role']=='Owner'){}else{echo 'readonly';}?> style=" width: 100px !important; "></td>
<td> <span style="display:none;"><?=$task_data->endDate?></span><input class="form-control" type="date" name="endDate"    onchange="timeline_task_update('<?=$task_data->id?>',this.name,this.value)"  id="task_end_<?=$task_data->id?>" value="<?=$task_data->endDate?>"  <?if($_SESSION['user_role']=='Owner'){}else{echo 'readonly';}?> style=" width: 100px !important; "></td>
<td> <span style="display:none;"><?=$task_data->responsible?></span><input class="form-control" type="text" name="responsible"  onchange="timeline_task_update('<?=$task_data->id?>',this.name,this.value)"    id="task_responsible_<?=$task_data->id?>" value="<?=$task_data->responsible?>"  <?if($_SESSION['user_role']=='Owner'){}else{echo 'readonly';}?> style=" width: 100px !important; "></td>
<td> <span style="display:none;"><?=$task_data->taskOwner?></span><input class="form-control" type="text" name="taskOwner"   onchange="timeline_task_update('<?=$task_data->id?>',this.name,this.value)"   id="task_owner_<?=$task_data->id?>" value="<?=$task_data->taskOwner?>"  <?if($_SESSION['user_role']=='Owner'){}else{echo 'readonly';}?> style=" width: 100px !important; "></td>
<td> <span style="display:none;"><?=$task_data->actualDate?></span><input class="form-control" type="date" name="actualDate"   onchange="timeline_task_update('<?=$task_data->id?>',this.name,this.value)"   id="task_actual_date_<?=$task_data->id?>" value="<?=$task_data->actualDate?>" <?if($_SESSION['user_role']=='Owner'){}else{echo 'readonly';}?> style=" width: 100px !important; "></td>

<?if($task_data->actualDate==''){?>
<td> <span style="display:none;"><?=$task_data->traffic?></span><input class="form-control" type="text" name="traffic" style="background-color:white !important"  onchange="timeline_task_update('<?=$task_data->id?>',this.name,this.value)" readonly    id="task_traffic_<?=$task_data->id?>" value="<?=$task_data->traffic?>"></td>

<?}elseif($additionalDays>0){?>
<td> <span style="display:none;"><?=$task_data->traffic?></span><input class="form-control" type="text" name="traffic" style="background-color:red !important"  onchange="timeline_task_update('<?=$task_data->id?>',this.name,this.value)"  readonly   id="task_traffic_<?=$task_data->id?>" value="<?=$task_data->traffic?>"></td>

<?}elseif($additionalDays<0){?>
<td> <span style="display:none;"><?=$task_data->traffic?></span><input class="form-control" type="text" name="traffic" style="background-color:green !important"  onchange="timeline_task_update('<?=$task_data->id?>',this.name,this.value)"  readonly  id="task_traffic_<?=$task_data->id?>" value="<?=$task_data->traffic?>"></td>

<?}else{?>
<td> <span style="display:none;"><?=$task_data->traffic?></span><input class="form-control" type="text" name="traffic" style="background-color:white !important"  onchange="timeline_task_update('<?=$task_data->id?>',this.name,this.value)"  readonly  id="task_traffic_<?=$task_data->id?>" value="<?=$task_data->traffic?>"></td>

<?}?>

<td> <span style="display:none;"><?=$task_data->status?></span><input class="form-control" type="text" name="status"   onchange="timeline_task_update('<?=$task_data->id?>',this.name,this.value)"   id="task_status_<?=$task_data->id?>" value="<? if($task_data->actualDate==''){echo 'WIP';}else{echo 'DONE';} ?>" readonly></td>
<td> <span style="display:none;"><?if($plannedDays<0){echo '0';}else{echo $plannedDays;}?></span><input class="form-control" type="number" name="additionalDays"   onchange="timeline_task_update('<?=$task_data->id?>',this.name,this.value)"   id="task_planned_days_<?=$task_data->id?>" value="<? if($plannedDays<0){echo '0';}else{echo $plannedDays;} ?>" readonly></td>
<td> <span style="display:none;"><?if($actualDays<0){echo '0';}else{echo $actualDays;}?></span><input class="form-control" type="number" name="additionalDays"   onchange="timeline_task_update('<?=$task_data->id?>',this.name,this.value)"   id="task_actual_days_<?=$task_data->id?>" value="<? if($actualDays<0){echo '0';}else{echo $actualDays;} ?>" readonly></td>
<td> <span style="display:none;"><?if($additionalDays<0){echo '0';}else{echo $additionalDays;}?></span><input class="form-control" type="number" name="additionalDays"   onchange="timeline_task_update('<?=$task_data->id?>',this.name,this.value)"   id="task_additional_days_<?=$task_data->id?>" value="<? if($additionalDays<0){echo '0';}else{echo $additionalDays;} ?>" readonly></td>
<td> <span style="display:none;"><?=$task_data->reasonRemarks?></span><input class="form-control" type="text" name="reasonRemarks"   onchange="timeline_task_update('<?=$task_data->id?>',this.name,this.value)"   id="task_remarks_<?=$task_data->id?>" value="<?=$task_data->reasonRemarks?>" <?if($_SESSION['user_role']=='Owner'){}else{echo 'readonly';}?> style=" width: 120px !important; "></td>
<?if($_SESSION['user_role']=='Owner'){?>
  <td><input type="button" onclick="task_data_delete('<?=$task_data->id?>','ddddddddddd',<?=$task_data->sequence?>)" class="btn1 btn1-bg-cancel action-btn" value="Delete" style=" min-width: 40px !important; height:30px !important;"/></td>
  <?}else{?>
<td></td>
<?}?>

</tr>
<?
$count++;
}?>
</tbody>


</table>

