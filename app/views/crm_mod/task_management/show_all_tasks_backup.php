<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');

$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"');


 $cur = '&#x9f3;';
 
 require "../include/custom.php";
 
 $title = "All ".$CRMtaskName." List";
 
 
 
 $table1 = 'crm_task_lists';
 
 $crud1 = new crud($table1);
 
 
 if(isset($_POST['insert'])){
     
     if(!isset($_POST['reminder_on'])){
         $_POST['remind_at'] = '0000-00-00 00:00:00';
     }
     
     //Insert attachment --Start--
     if(isset($_FILES['attachment'])){

        $target_dir = "imgs/task_attachment/";
    
        $filename = $_FILES["attachment"]["name"];
        $imageFileType = strtolower(end(explode(".", $filename)));
        $newfilename = rand(100,99).'_'.date('Y-m-d H:i:s')."_". rand(100,999) .".".$imageFileType;
        
        $target_file = $target_dir.$newfilename;
    
        $imageOK = 1;
    
        $check = getimagesize($_FILES["attachment"]["tmp_name"]);
        if($check !== false) {
          $imageOK = 1;
        }else{
          $imageOK = 0;
        }
        
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
          $imageOK = 0;
        }
        
        if ($_FILES["attachment"]["size"] > 2000000) {
          $imageOK = 0;
        }
        
        if($imageOK==0){
          $_POST['attachment'] = NULL;
    
        }else{
          if(move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)){
            $_POST['attachment'] = $newfilename;
          }else{
             $_POST['attachment'] = NULL;
          }
        }
         
     }else{
         echo '<script>alert("attachment Update Failed! Size should be below 2MB and only supported formats are JPG, JPEG, PNG.");</script>';

         $_POST['attachment'] = NULL;
     }
     //Insert attachment --End--
     
     $_POST['entry_by'] = $_SESSION['employee_selected'];
     
     $crud1->insert();
 }
 
 
 
 if(isset($_POST['update'])){
     
     if(!isset($_POST['reminder_on'])){
         $_POST['remind_at'] = '0000-00-00 00:00:00';
     }
     
     
     //Update attachment --Start--
     if(isset($_FILES['attachment'])){

        $target_dir = "imgs/task_attachment/";
    
        $filename = $_FILES["attachment"]["name"];
        $imageFileType = strtolower(end(explode(".", $filename)));
        $newfilename = rand(100,99).'_'.date('Y-m-d H:i:s')."_". rand(100,999) .".".$imageFileType;
        
        $target_file = $target_dir.$newfilename;
    
        $imageOK = 1;
    
        $check = getimagesize($_FILES["attachment"]["tmp_name"]);
        if($check !== false) {
          $imageOK = 1;
        }else{
          $imageOK = 0;
        }
        
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
          $imageOK = 0;
        }
        
        if ($_FILES["attachment"]["size"] > 2000000) {
          $imageOK = 0;
        }
        
        if($imageOK==0){
          $_POST['attachment'] = NULL;
    
        }else{
          if(move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)){
            
            $oldImageName = find_a_field($table1, 'attachment', 'id = "'.$_POST['id'].'"');
            if($oldImageName != NULL && $oldImageName != $newfilename){
                unlink($target_dir.$oldImageName);
            }
            
            $_POST['attachment'] = $newfilename;
          }else{
             $_POST['attachment'] = NULL;
          }
        }
         
     }else{
         echo '<script>alert("attachment Update Failed! Size should be below 2MB and only supported formats are JPG, JPEG, PNG.");</script>';

         $_POST['attachment'] = NULL;
     }
     //Update attachment --End--
     
     $_POST['update_by'] = $_SESSION['employee_selected'];
     $_POST['update_at'] = date('Y-m-d h:s:i');
     
     $crud1->update('id');
 }
 
 

  require_once "../include/reg__ajax.php";
 

?>

    <script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>

    <div class="row well">
        <div class="col-md-12 text-right">
            <a href="../home/home.php" class="btn btn-warning" style="margin-top:12px; margin-bottom:14px;">Go Back</a>
            <a href="show_all_tasks.php?update=<?=encrypTS('new')?>" class="btn btn-success text-light" style="margin-top:12px; margin-bottom:14px;">+ Add New</a>
        </div>    
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <table id="example" class="table">
                
                <thead>
                    <th>SN</th>
                    <th>Task</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Assigned to</th>
                    <th>Start at</th>
                    <th>End at</th>
                    <th>Delay</th>
                    <th>Action</th>
                </thead>
                <tbody>
                
                <?php 
                
                    $sn = 1;
                    if(in_array($_SESSION['employee_selected'], $superID)){
                        $con = " 1 ";
                    }else{
                        $con = " assigned_person_id = '".$_SESSION['employee_selected']."' ";
                    }

                    
                    $leadsQry = "SELECT * FROM $table1 WHERE ".$con;
                    $rslt = db_query($leadsQry); 
                    while($row = mysqli_fetch_object($rslt)){
                    
                ?>
                
                    <tr>
                        <td><?=$sn?></td>
                        <td><?=$row->task_name?></td>
                        <td><?=find_a_field('crm_task_purpose', 'purpose', 'id= "'.$row->purpose.'"')?></td>
                        <td><?=find_a_field('crm_task_status', 'status', 'id = "'.$row->status.'"')?></td>
                        <td><?=find_a_field('user_activity_management', 'fname', 'PBI_ID = "'.$row->assigned_person_id.'"')?></td>
                        <td><?=$row->entry_at?></td>
                        <td><?=$row->to_time?></td>
                        <td>
                            <?php if($row->status!=2){
                                     echo '--:--';
                                  }else{ 
                                      ts_time_diff_show($row->to_time, $row->update_at, $msg='On Time');
                            } ?>
                        </td>
                        <td class="d-flex">
                            
                            <a class="btn btn-sm btn-info mr-2" href="../info_maker/crm_view.php?view=<?=encrypTS($row->id)?>&tp=<?=encrypTS('task')?>"><i class="fa-solid fa-eye"></i></a>
                            
                            <a class="btn btn-sm btn-warning" href="show_all_tasks.php?update=<?=encrypTS($row->id)?>"><i class="fa-solid fa-pencil"></i></a>
                            
                        </td>
                    </tr>
                
                <?php 
                
                    $sn++;
                    
                    } 
                    
                ?>
                
                </tbody>
                <tfoot>
                    <td>SN</td>
                    <td>Task</td>
                    <td>Purpose</td>
                    <td>Status</td>
                    <td>Assigned to</td>
                    <td>Start at</td>
                    <td>End at</td>
                    <td>Delay</td>
                    <td>Action</td>
                </tfoot>
                
            </table>   
            
        </div>
    </div>



    <!-- Task Manage Modal Start Here -->
    <?php if(isset($_GET['update'])){ 
        $datas = find_all_field($table1, '', 'id="'.decrypTS($_GET['update']).' AND '.$con.'"'); 
        if(isset($datas)){$assigned_id = $datas->assigned_person_id;}else{$assigned_id = $_SESSION['employee_selected'];} 
    } ?>
    
    <div class="modal fade task-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Create Task</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" enctype="multipart/form-data">
          <div class="modal-body">
          <h5 class=text-center>Task Information</h5>
            <div class="row">
             
                <div class="col-md-6">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td>Task For</td>
                        <td>
                          <select name="assigned_person_id" id="Pid" class="form-control" style="border-left:3.5px solid #df5b5b!important;" required <?php if($datas->email != NULL){echo '';}else{echo 'onchange="fetch_select_userEmail(this.value);"';}?>>
                            
                            <?php
                                if(in_array($_SESSION['employee_selected'], $superID)){ 
                                    foreign_relation('user_activity_management', 'distinct(PBI_ID)', 'fname', $datas->assigned_person_id, '1'); 
                                }else{ 
                                    foreign_relation('user_activity_management', 'distinct(PBI_ID)', 'fname', $assigned_person_id, 'PBI_ID="'.$assigned_id.'"'); 
                                }
                            ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                          <td>Project: </td>
                        <td>
                          <select name="project_id" id="project_id" class="form-control" style="border-left:3.5px solid #df5b5b!important;" required onchange="fetch_select_projectContact(this.value, <?=$datas->contact_person?>);">
                             <option value="">--SELECT ONE--</option>
                            <?php foreign_relation('crm_project_lead', 'id', 'name', $datas->project_id, '1') ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Status: </td>
                        <td>
                          <select name="status" id="status" style="border-left:3.5px solid #df5b5b!important;" required>
                            <option value="">-- SELECT--</option>
                            <?php foreign_relation('crm_task_status', 'id', 'status', $datas->status, '1') ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Contact: </td>
                        <td>
                          <select name="contact_person" id="contact_person" style="border-left: 3.5px solid #aeddf7 !important;">

                          </select>
                        </td>
                      </tr>
                      <tr style="height:60px;">
                          <td>Reminder: </td>
                          <td>
                              <div class="custom-control custom-switch">
                                <input name="reminder_on" type="checkbox" class="custom-control-input" id="customSwitch2" onclick="myReminderSB()" <?php if($datas->remind_at!='0000-00-00 00:00:00'){echo 'checked';} ?>>
                                <input type="datetime-local" name="remind_at" id="remind_at" class="form-control" style="border-left:3.5px solid #df5b5b!important;<?php if($datas->remind_at!='0000-00-00 00:00:00' || !isset($datas->remind_at)){echo 'display:none;';}else{echo 'display:block;';} ?>float:right;width:80%!important;padding:0px;height:34px;" value="<?=$datas->remind_at?>" <?php if(!isset($datas)){echo 'min="<?=$today?>"';} ?> <?php if($datas->remind_at!='0000-00-00 00:00:00' || !isset($datas->remind_at)){echo 'disabled';} ?> required>
                                <label class="custom-control-label" for="customSwitch2"></label>
                              </div>
                          </td>
                        </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-md-6">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td>Subject: </td>
                        <td><input type="text" name="task_name" class="form-control" style="border-left:3.5px solid #df5b5b!important;" value="<?=$datas->task_name?>" required></td>
                      </tr>
                      <tr>
                        <td>Due Time: </td>
                        <td><input type="datetime-local" name="to_time" class="form-control" style="border-left:3.5px solid #df5b5b!important;" min="<?=$today?>" value="<?=$datas->to_time?>" <?php if(isset($datas->to_time) && !in_array($_SESSION['employee_selected'], $superID)){echo 'disabled';} ?> required></td>
                      </tr>
                      <tr>
                        <td>Email: </td>
                        <td><input type="email" name="email" id="email" class="form-control" style="border-left:3.5px solid #df5b5b!important;" value="<?=$datas->email?>" required></td>
                      </tr>
                      <tr>
                        <td>Purpose</td>
                        <td>
                          <select name="purpose" id="purpose" class="form-control" style="border-left:3.5px solid #df5b5b!important;" required>
                            <?php foreign_relation('crm_task_purpose', 'id', 'purpose', $datas->purpose, '1') ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Priority</td>
                        <td>
                          <select name="priority" id="priority" class="form-control" style="border-left:3.5px solid #df5b5b!important;" required>
                            <option value="1" <?php if($datas->priority=='1'){echo 'selected';} ?>>High</option>
                            <option value="2" <?php if($datas->priority=='2'){echo 'selected';} ?>>Medium</option>
                            <option value="3" <?php if($datas->priority=='3'){echo 'selected';} ?>>Low</option>
                          </select>
                        </td>
                      </tr>

                    </tbody>
                  </table>
                </div>
             
            </div>
          
            <div class="row">
              <div class="form-group pt-3 m-0 m-auto">
                <label for="message text-center">Description</label>
                <textarea name="description" class="form-control" cols="40" rows="4" style="border-left: 3.5px solid #aeddf7 !important;"><?=$datas->description?></textarea>
              </div>

              <div class="form-group text-center col-12 pt-3 pb-3 m-0 m-auto">
                    <input type="file" name="attachment" id="image" style="display:none;" accept=".png,.jpg,.jpeg,.pdf">
                    <label for="image">
                        
                        <?php if($datas->attachment!=NULL || $datas->attachment!=''){echo '<small>Attached:</small> <span class="text-primary" style="cursor:pointer;font-size:11px;">'.$datas->attachment.'</span>';}else{echo '<span class="text-info" style="cursor:pointer;font-size:11px;"><i class="fa fa-paperclip"></i> Add Attachment</span>';} ?>
                        
                    </label>
              </div>
            </div>  
          </div>     
          
          <?php if(!isset($datas)){ ?>
          <div class="modal-footer">
            <a type="button" class="btn btn-secondary text-light" data-dismiss="modal">Close</a>
            <button type="submit" class="btn btn-primary" name="insert">Save</button>
          </div>
          <?php }else{ ?>
            <div class="modal-footer">
                <input type="hidden" name="id" value="<?=$datas->id?>">
                <a type="button" class="btn btn-secondary text-light" data-dismiss="modal">Close</a>
                <button type="submit" class="btn btn-warning" name="update">Update</button>
            </div>
          <?php } ?>
          
          </form>
          
          </div>
        </div>
        
    </div>


    <!-- Task Manage Modal End Here  -->


<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>


<?php if(isset($datas->remind_at)){ ?>
    <script>
        remind_at.style.display = "block";
        remind_at.enabled;
    </script>
<?php }else{ ?>
    <script>
        remind_at.style.display = "none";
        remind_at.disabled;
    </script>
<?php } ?>


<?php if(isset($_GET['update'])){ ?>
    <script>
        $('.task-modal-lg').modal('show');
    </script>
<?php } ?>

<script>

    myReminderSB();
    
    function myReminderSB() {
      var check = document.getElementById("customSwitch2");
      var remind_at = document.getElementById("remind_at");
      if (check.checked == true){
        remind_at.style.display = "block";
        remind_at.disabled=false;
      } else {
         remind_at.style.display = "none";
         remind_at.disabled=true;
      }
    }
    
</script>

<script type="text/javascript" src="../include/functions.js"></script>

<script>
    
    <?php if($datas->email == NULL){ ?>
        if(document.getElementById("Pid").value > 0 && document.getElementById("Pid").value !== null && document.getElementById("Pid").value !== ''){
        var x=document.getElementById("Pid").value;
        fetch_select_userEmail(x);
        }
    <?php } ?>
    
    if(document.getElementById("project_id").value > 0 && document.getElementById("project_id").value !== null && document.getElementById("project_id").value !== ''){
        var y=document.getElementById("project_id").value;
        fetch_select_projectContact(y, <?=$datas->contact_person?>);
        
    }
    
</script>

