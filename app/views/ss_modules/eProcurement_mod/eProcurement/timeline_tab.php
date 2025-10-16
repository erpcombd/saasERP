<?php
  $notification_send = find_a_field('rfq_master','notification_status','rfq_no="'.$_SESSION['rfq_no'].'"');
  $notify_buyer = find_a_field('rfq_master','notify_buyer','rfq_no="'.$_SESSION['rfq_no'].'"');
  $notification_setup_info = find_all_field('notification_setup_information','','rfq_no="'.$_SESSION['rfq_no'].'"');
  $currentDate = date('Y-m-d');
  $currentTime = date('H:i');
  function calculateAdditionalDays($endDate, $actualDate) {
    $end = new DateTime($endDate);
    $actual = new DateTime($actualDate);
    $interval = $end->diff($actual);
    return $interval->days * ($interval->invert ? -1 : 1);
}
  ?>

<div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="timeline-tab">

<div id="motherDivtobluer" class="pt-5 pl-3">
		
		<div   class="row align-items-center">
		
		  <label class="col-3 fs-18 bold" for=" eventtimezone" style="font-size: 14px !important;color: #60768a; !important">Event Time Zone :</label>
		  
			<input class="motherDivtobluer col-3" type="text" id="eventtimezone" name="eventtimezone" style="width: 40% !important;" list="timezoneList" value="<?=$eventtimezone?>" onchange="master_data(this.name,this.value)">
			
		</div>
	
		
	   
		<div   class="mt-2 row align-items-center">
		
		  <label class="col-3 fs-18 bold" style="font-size: 14px !important;color: #60768a; !important" for="eventend">Event Start Time : </label>
		 
		  <input type="date" min="<?php echo $currentDate; ?>" style="width: 12% !important; border: 1px solid #ced4da; border-radius: 0.25rem;" class="<?if($immediate_event_shoot=='checked') echo 'blur-effect ' ?>motherDivtobluer form-control pt-1 col-3" id="eventStartDate" name="eventStartDate" value="<? if($eventStartDate!= '') echo $eventStartDate; else echo date('Y-m-d');?>" onchange="master_data_event_timeline(this.name,this.value)" />
		  <input type="Time" min="<?php echo $currentTime; ?>"  style="width: 12% !important; border: 1px solid #ced4da; border-radius: 0.25rem;" class="<?if($immediate_event_shoot=='checked') echo 'blur-effect ' ?> form-control  pt-1 col-3 ml-2" id="eventStartTime" name="eventStartTime" value="<? if($eventStartTime!='00:00:00') echo $eventStartTime; else echo date('H:s');?>" onchange="master_data_event_timeline(this.name,this.value)" />&nbsp;<lebel>At Event Submission</lebel>&nbsp;<input type="checkbox" name="immediate_event_shoot" id="immediate_event_shoot" 
      <?if($immediate_event_shoot=='checked') echo 'checked' ?>
       onchange="master_data(this.name,this.checked ? 'checked' : '')"/>
		</div>
		
		<div   class="mt-2 row align-items-center">
		  <label class="col-3 fs-18 bold" style="font-size: 14px !important;color: #60768a; !important; font-size: 14px !important;color: #60768a; !important;" for="eventend">Event End Time</label>
		  
		  <input type="date" min="<?php echo $currentDate; ?>" style="width: 12% !important; border: 1px solid #ced4da; border-radius: 0.25rem; pointer-events: fill !important; filter: none !important;" class="<?if($immediate_event_shoot=='checked') echo 'blur-effect ' ?> form-control pt-1 col-3" id="eventEndDate" name="eventEndDate" value="<? if($eventEndDate!='') echo $eventEndDate; else echo date('Y-m-d', strtotime('+7 day'));?>" onchange="master_data_event_timeline(this.name,this.value)" />
		  <input type="time" min="<?php echo $currentTime; ?>"  style="border: 1px solid #ced4da; border-radius: 0.25rem; width: 12% !important; pointer-events: fill !important; filter: none !important;" class="<?if($immediate_event_shoot=='checked') echo 'blur-effect ' ?> form-control pt-1 col-3 ml-2" id="eventEndTime" name="eventEndTime" value="<? if($eventEndTime!='00:00:00') echo $eventEndTime; else echo date('H:s');?>"  onchange="master_data_event_timeline(this.name,this.value)" />
		</div>
		
	
		
	  </div>




<!-- notification sending  -->
<h1 class="h1 m-0 p-0 pt-4 pl-3" style="font-size: 30px !important;"><em class="fa-solid fa-file-lines"></em> Reminder </h1>
		 <hr style="height:1px;border:none;color:#333;background-color:#333;">
    <section>
    <div class="form_element pl-3">
	                        
                          <label class="inlineSelection" style="font-family: Helvetica,Arial,sans-serif !important; color: #60768a !important;font-size: 16px !important; font-weight: 400 !important; cursor: pointer;">
                          <input type="radio" name="want_to_send_notification"  <? if($notification_send=='Yes') {echo 'checked';}?> id="want_to_send_notification" value="Yes" class="s-termAccept"     onclick="want_to_send(this.value,this.name)">
                           Send Reminder
                          </label>
                          
                          <label class="inlineSelection pl-3" style="font-family: Helvetica,Arial,sans-serif !important; color: #60768a !important;font-size: 16px !important; font-weight: 400 !important; cursor: pointer;">
                          <input type="radio"  <? if($notification_send=='No') {echo 'checked';}?> name="want_to_send_notification" id="want_to_send_notification" value="No" class="s-termReject"  onclick="want_to_send(this.value,this.name)">
                           Don't send Reminder
                          </label>
                          <label class="inlineSelection pl-3" style="font-family: Helvetica,Arial,sans-serif !important; color: #60768a !important;font-size: 16px !important; font-weight: 400 !important; cursor: pointer;">
                          <input type="checkbox"  <? if($notify_buyer=='Yes') {echo 'checked';}?> name="notify_buyer" id="notify_buyer"  class="s-termReject"  onchange="master_data(this.name,this.checked ? 'Yes' : 'No')">
                             Also Notify Buyer?
                          </label>
    </div>
    <div id="want_to_notification_show">
        <? if($notification_send=='Yes'){?>

        
          <div class="row d-flex justify-content-center align-items-center">
              <div class="col-12 mb-2 row">
                  <label class="col-3" for="notification_start_date" style="font-size: 13px !important;">Reminder Start Date and time</label>
                  <input class="col-2 form-control" type="datetime-local" min="<?= date('Y-m-d\T00:00', strtotime($eventStartDate)); ?>"  name="notification_start_date" id="notification_start_date" onchange="is_want_to_send_notification(this.name,this.value)" value="<?=$notification_setup_info->notification_start_date?>" required>
              </div>
              <div class="col-12 mb-2 row">
                  <label class="col-3" for="each_notification_interval" style=" font-size: 13px !important; ">Reminder Frequency (in Hours)</label>
                  <input class="col-2 form-control" type="number" min="0" name="each_notification_interval" id="each_notification_interval" onchange="is_want_to_send_notification(this.name,this.value)" value="<?=$notification_setup_info->each_notification_interval?>" required>
              </div>
              <div class="col-12 mb-2 row">
                  <label class="col-3" for="last_notfication_hour" style=" font-size: 13px !important; ">Last Reminder before event end (in Hours)</label>
                  <input class="col-2 form-control" type="number" min="0" name="last_notfication_hour" id="last_notfication_hour" onchange="is_want_to_send_notification(this.name,this.value)" value="<?=$notification_setup_info->last_notfication_hour?>" required>
              </div>
			  
			  <div class="col-12 mb-2 row">
			  <p class="m-0 p-0 pl-3" style="color:#FF0000">*it's active every 30min <br />Example: 09:00am, 09:30am, 10:00am, 10:30am, 11:00am, 11:30am .....*</p>
              </div>
			  
			  
      </div>
        

        <? } ?>

  </div>

    </section>




	  <h1 class="h1 m-0 p-0 pt-4 pl-3" style="font-size: 30px !important;"><em class="fa-solid fa-file-lines"></em> Task Management </h1>
		<hr style="height:1px;border:none;color:#333;background-color:#333;">

	
<section class="bsb-timeline-7 ">
  <div class="container" style=" min-height: 500px !important; ">
  <button id="btnExport_task" class="btn btn-success" type="button" onclick="fnExcelReport_task();">Download </button>
  
  <table class="table1  table-striped table-bordered table-hover table-sm" style=" zoom: 90%; ">
                    <thead class="thead1">
                    <tr class="bgc-info" >
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
                    
					
                    <tbody class="tbody1" id="task_mangement_table">
					
                <tr>
                <td><input class="form-control" min='0' type="number" id="task_sequence" value="" style=" width: 50px !important; " readonly></td>
               
                <td><input class="form-control" type="text" id="task_task"  value="" style=" width: 250px !important; " <?if($_SESSION['user_role']=='Owner'){}else{echo 'readonly';}?>></td>
                <td><input class="form-control" type="date" id="task_start"  value="" style=" width: 100px !important; " <?if($_SESSION['user_role']=='Owner'){}else{echo 'readonly';}?>></td>
                <td><input class="form-control" type="date" id="task_end" value="" style=" width: 100px !important; " <?if($_SESSION['user_role']=='Owner'){}else{echo 'readonly';}?>></td>
                <td>
                  
                <!-- <input class="form-control" type="text" id="task_responsible" value=""> -->
                 <!-- <select name="task_responsible" id="task_responsible"> -->
                            <input class="form-control" type="text" name="task_responsible" id="task_responsible" onchange="task_responsible_dependency(this.value)" <?if($_SESSION['user_role']=='Owner'){}else{echo 'readonly';}?> value="" list="task_responsible_tinnnnnnn" style=" width: 100px !important; ">
                             <datalist id="task_responsible_tinnnnnnn">

                             <option value="supply chain">Supply Chain</option>
                             <option value="business user">Business User </option>
                             <option value="others">Others </option>
                             <option value="supplier">Supplier </option>

                             </datalist>

                 <!-- </select> -->
              
                 <?php
                              // $sql = 'select a.id,u.fname,a.action,a.is_master,u.email from rfq_evaluation_team a, user_activity_management u where a.user_id=u.user_id and a.rfq_no="'.$_SESSION[$unique].'"';
                              // $qry = db_query($sql);
                              // while($data=mysqli_fetch_object($qry)){
                              ?>
                              <!-- <option class="pl-3" value="<?//=//$data->email?>"><em class="fa-regular fa-user"></em>&nbsp;<?//=//$data->email?><span>(<?//=//$data->action?>)</span> </option><br /> -->
                              <? //} ?>
              
              
              </td>
                <td id="task_owner_input_feild_show">
                  
                <input class="form-control" type="text" id="task_owner" name="task_owner" value="" style=" width: 100px !important; " <?if($_SESSION['user_role']=='Owner'){}else{echo 'readonly';}?>>

              
              
              </td>
                <td><input class="form-control" type="date" id="task_actual_date" value="" style=" width: 100px !important; " <?if($_SESSION['user_role']=='Owner'){}else{echo 'readonly';}?>></td>
                <td><input class="form-control" type="text" id="task_traffic" value="" readonly></td>
                <td><input class="form-control" type="text" id="task_status" value="" readonly></td>
                <td><input class="form-control" type="number" id="task_planned_days" value="" readonly ></td>
                <td><input class="form-control" type="number" id="task_actual_days" value=""  readonly ></td>
                <td><input class="form-control" type="number" id="task_additional_days" value="" readonly ></td>
                <td><input class="form-control" type="text" id="task_remarks" value="" style=" width: 120px !important; " <?if($_SESSION['user_role']=='Owner'){}else{echo 'readonly';}?>></td>
                <?if($_SESSION['user_role']=='Owner'){?>
                <td><button type="button" onclick="task_data_insert()" class="btn btn-success action-btn">Add</button></td>
                <?}else{?>
                    <td></td>
                    <?}?>
            </tr>
            <!-- <tr>
              <td id="timeline_task_list" colspan='12'></td>
            </tr> -->
   
														
					</tbody>
					
					
            </table>
            <div id="timeline_task_list">
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
                  
                  <td> <span style="display:none;"><?=$task_data->startDate?></span><input class="form-control" type="date" min="<?php echo $currentDate; ?>" name="startDate"  onchange="timeline_task_update('<?=$task_data->id?>',this.name,this.value)"    id="task_start_<?=$task_data->id?>" value="<?=$task_data->startDate?>"  <?if($_SESSION['user_role']=='Owner'){}else{echo 'readonly';}?> style=" width: 100px !important; "></td>
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
            </div>
    
  </div>
</section>
         
	
  </div>

  <style>
  .blur-effect {
    filter: blur(1px); /* Adjust the blur strength as needed */
    pointer-events: none; /* Disables pointer events on the blurred element and its children */
}
</style>
<script>
    // Function to blur elements onload if checkbox is checked
   function customonload() {
      
        var checkbox = document.getElementById("immediate_event_shoot");
        if (checkbox.checked) {
            blurElements();
        }
    };

    // Function to blur elements if checkbox is checked
    document.getElementById("immediate_event_shoot").addEventListener("change", function() {
        if (this.checked) {
            blurElements();
        } else {
            unblurElements();
        }
    });

    // Function to blur elements
    function blurElements() {
        var divToBlur1 = document.getElementById("eventStartDate");
        var divToBlur2 = document.getElementById("eventStartTime");
        var divToBlur3 = document.getElementById("eventEndDate");
        var divToBlur4 = document.getElementById("eventEndTime");

        // Apply blur effect
        divToBlur1.classList.add("blur-effect");
        divToBlur2.classList.add("blur-effect");
        divToBlur3.classList.add("blur-effect");
        divToBlur4.classList.add("blur-effect");
    }

    // Function to unblur elements
    function unblurElements() {
        var divToBlur1 = document.getElementById("eventStartDate");
        var divToBlur2 = document.getElementById("eventStartTime");
        var divToBlur3 = document.getElementById("eventEndDate");
        var divToBlur4 = document.getElementById("eventEndTime");

        // Remove blur effect
        divToBlur1.classList.remove("blur-effect");
        divToBlur2.classList.remove("blur-effect");
        divToBlur3.classList.remove("blur-effect");
        divToBlur4.classList.remove("blur-effect");
    }


</script>
<script type="text/javascript" src="../../../../public/assets/js/xlsx.full.min.js"></script>
<script>
function want_to_send(radio_button_value,radio_button) {
  
  if(radio_button_value=='Yes'){
    master_data('notification_status',radio_button_value)

    document.getElementById('want_to_notification_show').innerHTML = `
          <div class="row d-flex justify-content-center align-items-center">
              <div class="col-12 mb-3">
                  <label class="col-3" for="notification_start_date">Remainder Start Date and time</label>
                  <input class="col-2" type="datetime-local" min="<?= date('Y-m-d\T00:00', strtotime($eventStartDate)); ?>"  name="notification_start_date" id="notification_start_date" onchange="is_want_to_send_notification(this.name,this.value)" value="<?=$notification_setup_info->notification_start_date?>" required>
              </div>
              <div class="col-12 mb-3">
                  <label class="col-3" for="each_notification_interval">Remainder Frequency (in Hours)</label>
                  <input class="col-2" type="number" min="0" name="each_notification_interval" id="each_notification_interval" onchange="is_want_to_send_notification(this.name,this.value)" value="<?=$notification_setup_info->each_notification_interval?>" required>
              </div>
              <div class="col-12 mb-3">
                  <label class="col-3" for="last_notfication_hour">Last Remainder before event end (in Hours)</label>
                  <input class="col-2" type="number" min="0" name="last_notfication_hour" id="last_notfication_hour" onchange="is_want_to_send_notification(this.name,this.value)" value="<?=$notification_setup_info->last_notfication_hour?>" required>
              </div>
      </div>`;
  }
  if(radio_button_value=='No'){
    master_data('notification_status',radio_button_value);
    document.getElementById('want_to_notification_show').innerHTML = '';
  }
}
function task_data_insert(){

  var hidden_rfq_data = document.getElementById('hidden_rfq_number').value;
   
    
    // Make an AJAX call to send data to the server
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "set_session.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {

          let sequence = document.getElementById('task_sequence').value; 
                let phase = '';
                let task = document.getElementById('task_task').value;
                let startDate = document.getElementById('task_start').value;
                let endDate = document.getElementById('task_end').value;
                let responsible = document.getElementById('task_responsible').value;
                let taskOwner = document.getElementById('task_owner').value;
                let actualDate = document.getElementById('task_actual_date').value;
                let traffic = document.getElementById('task_traffic').value;
                let status = document.getElementById('task_status').value;
                let additionalDays = document.getElementById('task_additional_days').value;
                let reasonRemarks = document.getElementById('task_remarks').value;

                var second_part = sequence + '|' +phase + '|' + task + '|' + startDate + '|' + endDate + '|' + responsible + '|' + taskOwner + '|' + actualDate + '|' + traffic + '|' + status + '|' + additionalDays + '|' + reasonRemarks;
                getData2('timeline_task_insert_ajax.php','timeline_task_list','tesssstaft',second_part);



      
        }
    };
    xhr.send("hidden_rfq_data=" + encodeURIComponent(hidden_rfq_data));
               
                // console.log('SL:', sequence);
                // console.log('Phase:', phase);
                // console.log('Task:', task);
                // console.log('Start Date & Time:', startDate);
                // console.log('End Date & Time:', endDate);
                // console.log('Responsible:', responsible);
                // console.log('Task Owner:', taskOwner);
                // console.log('Actual Date & Time:', actualDate);
                // console.log('Traffic:', traffic);
                // console.log('Status:', status);
                // console.log('Additional Days:', additionalDays);
      
      
                // console.log('Reason / Remarks:', reasonRemarks);

                
}


function timeline_task_update(id_to_update,button_name, button_value) {

  var hidden_rfq_data = document.getElementById('hidden_rfq_number').value;
   
    
   // Make an AJAX call to send data to the server
   var xhr = new XMLHttpRequest();
   xhr.open("POST", "set_session.php", true);
   xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
   xhr.onreadystatechange = function() {
       if (xhr.readyState == 4 && xhr.status == 200) {



        $.ajax({
        url: 'task_update_ajax.php',
        type: 'GET',
        dataType: 'json',
        data: {
            id_to_update: id_to_update,
            button_name: button_name,
            button_value: button_value
        },
        success: function(response) {
          // if(button_name=='sequence' || button_name=='actualDate'){
          console.log(response['direction'])
            task_data_show();
          // }
        },
        error: function(error) {
            
        }
    });





     
       }
   };
   xhr.send("hidden_rfq_data=" + encodeURIComponent(hidden_rfq_data));



    
    
    
}


function task_data_show(){
  var hidden_rfq_data = document.getElementById('hidden_rfq_number').value;
   
    
   // Make an AJAX call to send data to the server
   var xhr = new XMLHttpRequest();
   xhr.open("POST", "set_session.php", true);
   xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
   xhr.onreadystatechange = function() {
       if (xhr.readyState == 4 && xhr.status == 200) {

        getData2('timeline_task_datashow_ajax.php','timeline_task_list','tesssstaft',"jjjj");
     
       }
   };
   xhr.send("hidden_rfq_data=" + encodeURIComponent(hidden_rfq_data));


               

}




function task_responsible_dependency(responsible_dropdown_Value){
  var hidden_rfq_data = document.getElementById('hidden_rfq_number').value;
   
    
    // Make an AJAX call to send data to the server
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "set_session.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          getData2('update_task_responsibility_dropdown_dependency_ajax.php','task_owner_input_feild_show',responsible_dropdown_Value,'datashowtag');

        }
    };
    xhr.send("hidden_rfq_data=" + encodeURIComponent(hidden_rfq_data));
}

function task_data_delete(id_to_delete,button_name, button_value){

  var hidden_rfq_data = document.getElementById('hidden_rfq_number').value;
   
    
    // Make an AJAX call to send data to the server
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "set_session.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {

          $.ajax({
        url: 'task_delete_ajax.php',
        type: 'GET',
        dataType: 'json',
        data: {
            id_to_delete: id_to_delete,
            button_name: button_name,
            button_value: button_value
        },
        success: function(response) {
        
        
            task_data_show();
          
        },
        error: function(error) {
            
        }
    });

      
      
        }
    };
    xhr.send("hidden_rfq_data=" + encodeURIComponent(hidden_rfq_data));
 
  
}
function html_table_to_excel_task(type, filename)
    {
        var data = document.getElementById('task_table_excell');

        var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});

        XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });

        XLSX.writeFile(file, filename + '.' + type);
    }

function fnExcelReport_task()  {
         // Get the dynamic file name
    const eventName = "<?=$event_name ?>";
    const rfqVersion = "<?=$_SESSION['rfq_version'] ?>";
    const fileName = `${eventName} #${rfqVersion}_task_report`;
     
      html_table_to_excel_task('xlsx', fileName);
    };


</script>

<style>
        /* Chrome, Safari, Edge */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }

        /* Internet Explorer 10+ */
        input[type="number"]::-ms-clear,
        input[type="number"]::-ms-reveal {
            display: none;
        }

        input[type="number"] {
            -ms-appearance: textfield;
        }

</style>




  <!--this seript for excel-->


  <!--this seript for excel-->