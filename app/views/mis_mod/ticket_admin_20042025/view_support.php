<?php

session_start();

ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title = "Request Approval";

$table = "it_support_request"; 
$table2 = "it_support_devices"; 
$table3 = "it_assigned_devices"; 

$crud = new crud($table);
$crud2 = new crud($table2);
$crud3 = new crud($table3);

if(isset($_POST['Support_stat'])){
    
    $_POST['assigned_to'] = $_SESSION['employee_selected'];
    $_POST['assigned_at'] = date('Y-m-d H:i:s');
    $_POST['update_by'] = $_SESSION['user']['id'];
    $_POST['update_at'] = $_POST['assigned_at'];
    
    $crud->update('id');
    
    $status = find_all_field($table, '', 'id="'.srDecode($_GET['view']).'"');
    
    if($status->status == 4){
        $status2 = "REJECTED";
        
    }else if($status->status == 5){
        $status2 = "COMPLETED";
    }
    if($status2 == "REJECTED" || $status2 == "COMPLETED"){
            
        
        $pInfo = find_all_field('user_activity_management', 'PBI_ID', 'user_id="'.$status->entry_by.'"');
        
        
        $msg = 'Hello '.$pInfo->fname.' ('.$pInfo->username.'),<br>Your submitted support ticket is '.$status2.' Here are the details below-';$msg .= '<br><br>Your Request ID: '.$status->request_id;
        $msg .= '<br>Support Type: '.find_a_field('it_support_type', 'name', 'id="'.$status->type.'"');
        
        
        if($status->subcategory > 0){
             $msg .= '<br>Requested for: '.find_a_field('it_support_subcategory', 'name', 'id="'.$status->subcategory.'"');
        }else if($status->subcategory <= 0 && $status->otherNeed!=""){
            $msg .= '<br>Requested for: '.$status->otherNeed;
        }
    
        
        $msg .= '<br>Priority: '.find_a_field('it_support_priority', 'name', 'id="'.$status->priority.'"');
        $msg .= '<br>Problem: '.$status->subject;
        
        if($status->device > 0){
            $msg .= '<br>Device: '.find_a_field('it_support_device', 'name', 'id="'.$status->device.'"');
        }
        
        $msg .= '<br>Note: '.$status->note;
        // $msg .= '<br><br>We will contact you using: '.$pInfo->PBI_EMAIL.' OR '.$pInfo->PBI_MOBILE.' if required.';
        // $msg .= '<br>We will try our best to solve your issue as soon as possible. Please check the status using the Request ID. Thank you.';
        $msg .= '<br>'.$status2.' Note: '.$status->remarks;
        $msg.='<br> Thank You';
        
        $userMail = find_a_field('personnel_basic_info','PBI_EMAIL','PBI_ID="'.$pInfo->PBI_ID.'" ');
        // $userMail = $pInfo->email;
        
        if($userMail == '' || $userMail == NULL){
            mail_srabon('it@reverie-bd.com', 'Requesting IT Support', $msg);
        }else{
            mail_srabon($userMail, 'Requesting IT Support', $msg, '', 'it@reverie-bd.com');
        }
        
        echo "<script>location.href='support_req_list.php';</script>"; 
        exit;
        
    
    }
    
    
    
    
}

if(isset($_POST['reject_request'])){
    
    $_POST['assigned_to'] = $_SESSION['employee_selected'];
    $_POST['assigned_at'] = date('Y-m-d H:i:s');
    $_POST['update_by'] = $_SESSION['user']['id'];
    $_POST['update_at'] = $_POST['assigned_at'];
    $_POST['status'] = 4;
    
    unset($_POST['device']);
    
    $crud->update('id');
    
    $status = find_all_field($table, 'id', 'id="'.srDecode($_GET['view']).'"');
    
    $pInfo = find_all_field('user_activity_management', 'PBI_ID', 'user_id="'.$status->entry_by.'"');
        
    $msg = 'Hello '.$pInfo->fname.' ('.$pInfo->username.'),<br>Your submitted support ticket is REJECTED, Here are the details below-';$msg .= '<br><br>Your Request ID: '.$status->request_id;
    $msg .= '<br>Support Type: '.find_a_field('it_support_type', 'name', 'id="'.$status->type.'"');
        
    if($status->subcategory > 0){
             $msg .= '<br>Requested for: '.find_a_field('it_support_subcategory', 'name', 'id="'.$status->subcategory.'"');
        }else if($status->subcategory <= 0 && $status->otherNeed!=""){
            $msg .= '<br>Requested for: '.$status->otherNeed;
        }
    
        
        $msg .= '<br>Priority: '.find_a_field('it_support_priority', 'name', 'id="'.$status->priority.'"');
        $msg .= '<br>Problem: '.$status->subject;
        
        if($status->device > 0){
            $msg .= '<br>Device: '.find_a_field('it_support_device', 'name', 'id="'.$status->device.'"');
        }
        
        $msg .= '<br>Note: '.$status->note;
        // $msg .= '<br><br>We will contact you using: '.$pInfo->PBI_EMAIL.' OR '.$pInfo->PBI_MOBILE.' if required.';
        // $msg .= '<br>We will try our best to solve your issue as soon as possible. Please check the status using the Request ID. Thank you.';
        $msg .= '<br>Reject Note: '.$status->remarks;
        $msg.='<br> Thank You';
        
        $userMail = find_a_field('personnel_basic_info','PBI_EMAIL','PBI_ID="'.$pInfo->PBI_ID.'" ');
        // $userMail = $pInfo->email;
        
        if($userMail == '' || $userMail == NULL){
            mail_srabon('it@reverie-bd.com', 'Requesting IT Support', $msg);
        }else{
            mail_srabon($userMail, 'Requesting IT Support', $msg, '', 'it@reverie-bd.com');
        }
        
        echo "<script>location.href='support_req_list.php';</script>"; 
        exit;
        
    
    
}

if(isset($_POST['assign_device'])){
    
    $status = find_a_field($table2, 'status', 'id="'.$_POST['device'].'"');
    
    if($status!=1 && find_a_field($table3, 'count(id)', 'device="'.$_POST['device'].'" AND returned_to IS NOT NULL AND returned_at <> "0000-00-00 00:00:00"') > 0){
        echo '<script>alert("This Device Can Not be Assigned!!!");</script>';
    }else{
    
        $_POST['req_id'] = $_POST['id'];
        
        $_POST['assigned_to'] = $_SESSION['employee_selected'];
        $_POST['assigned_at'] = date('Y-m-d H:i:s');
        $_POST['update_by'] = $_SESSION['user']['id'];
        $_POST['update_at'] = $_POST['assigned_at'];
        $_POST['status'] = 5;
        $device = $_POST['device'];
        
        unset($_POST['device']);
        
        $crud->update('id');
        
        unset($_POST['id']);
        
        
        
        $_POST['device'] = $device;
        
        $query = "SELECT * FROM it_support_devices WHERE id='".$_POST['device']."' OR mother_item = '".$_POST['device']."' ";
        $result = db_query($query);
        while($rows= mysqli_fetch_object($result)){
            
            $_POST['entry_by'] = $_POST['update_by'];
            $_POST['entry_at'] = $_POST['update_at'];
            $_POST['device'] = $rows->id;
            $crud3->insert();
            
            unset($_POST['entry_by']);
            unset($_POST['entry_at']);
            
            // $_POST['id'] = $_POST['device'];
            $_POST['id'] = $rows->id;
            $_POST['status'] = 2;
            
            $crud2->update('id');
        }
        
        
       
        
        
        
    }
    
}



if(!isset($_GET['view']) || !isset($_GET['tp']) || srDecode($_GET['view']) <= 0 && ( srDecode($_GET['tp']) != 'dv' || srDecode($_GET['tp']) != 'sp')){
    echo '<script>location.href="../main/home.php";</script>';
    exit;
}


$datas = find_all_field($table, '', 'id="'.srDecode($_GET['view']).'"');

  echo '<pre>';
echo print_r($datas);
echo '</pre>';
$_GET['view'] = srDecode($_GET['view']);
die();

?>


    <style>
        td {
            padding: 7px!important;
        }
    </style>

    
    <div class="row well">
        <div class="col-xs-12 text-right">
            <?php if(srDecode($_GET['tp']) == 'sp') { ?>
            <a href="support_req_list.php" class="btn btn-md btn-warning" style="margin-top:8px;"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
            <?php }else if(srDecode($_GET['tp']) == 'dv'){ ?>
            <a href="device_req_list.php" class="btn btn-md btn-warning" style="margin-top:8px;"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
            <?php } ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            
            <div class="container">
                <div class="card">
                    
                    <div class="card-header">
                        <h3>Support Ticket View #<?=$datas->request_id?></h3>
                    </div>
                    
                    <div class="card-body">
                        
                        <table width="45%" style="margin-top:35px; margin-right: 20px; float:left; border-right: 2px solid #dfdfdf;">
                            <tbody>
                                
                                <tr>
                                    <th width="50%">Issue:</th>
                                    <td width="50%" style="word-break: break-all;"><?=$datas->subject?></td>
                                </tr>
                                
                                <?php if($datas->subcategory > 0 && $datas->subcategory != NULL){ ?>
                                <tr>
                                    <th width="50%">Subcategory:</th>
                                    <td width="50%" class="text-right"><?=find_a_field('it_support_subcategory', 'name', 'id="'.$datas->subcategory.'"')?> <?=find_a_field('it_support_subcategory a, it_support_category b', 'b.name', 'a.id="'.$datas->subcategory.'" AND b.id=a.category')?></td>
                                </tr>
                                <?php } ?>
                                
                                <?php if($datas->otherNeed != NULL){ ?>
                                <tr>
                                    <th width="50%">Request For:</th>
                                    <td width="50%" class="text-right"><?=$datas->otherNeed?></td>
                                </tr>
                                <?php } ?>
                                
                                <tr>
                                    <th width="50%">Description:</th>
                                    <td width="50%" class="text-right" style="word-break: break-all;"><?=$datas->note?></td>
                                </tr>
                                
                                <?php if($datas->PBI_ID != find_a_field('user_activity_management', 'PBI_ID', 'user_id="'.$datas->entry_by.'"')){ ?>
                                <tr>
                                    <th width="50%">Request For <small>(employee)</small>:</th>
                                    <td width="50%" class="text-right"><?=find_a_field('user_activity_management', 'concat(fname," (",username,")")', 'PBI_ID="'.$datas->PBI_ID.'"')?></td>
                                </tr>
                                
                                <tr>
                                    <th width="50%">Entry By:</th>
                                    <td width="50%" class="text-right"><?=find_a_field('user_activity_management', 'concat(fname," (",username,")")', 'user_id="'.$datas->entry_by.'"')?></td>
                                </tr>
                                <?php }else if($datas->PBI_ID == $_SESSION['employee_selected']){ ?> 
                                
                                <tr>
                                    <th width="50%">Requested by:</th>
                                    <td width="50%" class="text-right"> <b>Self</b> </td>
                                </tr>
                                
                                <?php }else{ ?>
                                
                                <tr>
                                    <th width="50%">Requested by:</th>
                                    <td width="50%" class="text-right"><?=find_a_field('user_activity_management', 'concat(fname," (",username,")")', 'PBI_ID="'.$datas->PBI_ID.'"')?></td>
                                </tr>
                                
                                <?php } ?>
                                
                                <tr>
                                    <th width="50%">Entry at:</th>
                                    <td width="50%" class="text-right"><?=$datas->entry_at?></td>
                                </tr>
                                
                                <?php if($datas->attachment!=''){ ?>
                                 <tr>
                                    <th width="50%">View Attachement: </th>
                                    <td width="50%" class="text-right"><a href="../../../../media_attachment/support_documents/<?=$datas->attachment?>" target="_blank" class="btn btn-primary btn-xs">VIEW</a></td>
                                </tr>
                                <?php } ?>
                                
                                <?php if($datas->update_by > 0 && $datas->update_by != NULL){ ?>
                                <tr>
                                    <th width="50%">Updated by:</th>
                                    <td width="50%" class="text-right"><?php if($datas->update_by!=NULL){echo find_a_field('user_activity_management', 'username', 'user_id="'.$datas->update_by.'"');}else{echo 'None';}?></td>
                                </tr>
                                <?php } ?>
                                
                                <?php if($datas->update_at!='0000-00-00 00:00:00' && $datas->update_at != NULL){ ?>
                                <tr>
                                    <th width="50%"><?php if($datas->assigned_to!=NULL && ($datas->status==3||$datas->status==4||$datas->status==5)){echo 'Responded at:';}else{echo 'Updated at:';} ?></th>
                                    <td width="50%" class="text-right"><?php if($datas->update_at!='0000-00-00 00:00:00'){echo $datas->update_at;}else{echo '--:--';}?></td>
                                </tr>
                                <?php } ?>
                                
                            </tbody>
                        </table>
                        
                        
                        <table width="50%" style="margin-top:35px; float:left;">
                            <tbody>
                                
                                <tr>
                                    <th width="50%">Request Type:</th>
                                    <td width="50%"><?=find_a_field('it_support_type', 'name', 'id="'.$datas->type.'"')?></td>
                                </tr>
                                
                                <tr>
                                    <th width="50%">Request Priority:</th>
                                    <td width="50%"><b><?=find_a_field('it_support_priority', 'name', 'id="'.$datas->priority.'"')?></b></td>
                                </tr>
                                
                                <?php if($datas->device != NULL){ ?>
                                <tr>
                                    <th width="50%">Device:</th>
                                    <td width="50%" class="text-right"><?php if($datas->device == 0){echo 'Personal';}else{echo find_a_field('it_support_devices', 'concat(name," (",serial,")")', 'id = "'.$datas->device.'"');} ?></td>
                                </tr>
                                <?php } ?>
                                
                                <?php if($datas->otherNeed > 0 && $datas->otherNeed != NULL){ ?>
                                <tr>
                                    <th width="50%">Unlisted Item:</th>
                                    <td width="50%" class="text-right"><?=$datas->otherNeed?></td>
                                </tr>
                                <?php } ?>
                                
                                <tr>
                                    <th>Assigned By:</th>
                                    <td><?php if($datas->assigned_to!=NULL){echo find_a_field('user_activity_management', 'username', 'PBI_ID="'.$datas->assigned_to.'"');}else{echo 'None';}?></td>
                                </tr>
                                
                                <tr>
                                    <th>Assigned At:</th>
                                    <td><?php if($datas->assigned_at!='0000-00-00 00:00:00'){echo $datas->assigned_at;}else{echo '--:--';}?></td>
                                </tr>
                                
                                <tr>
                                    <th>Status:</th>
                                    <td><?php if($datas->status > 0){echo find_a_field('it_support_status', 'name', 'id="'.$datas->status.'"');}else{echo 'Pending';}?></td>
                                </tr>
                                
                                <tr>
                                    <th>Remarks:</th>
                                    <td><p style="word-break: break-all;"><?php if($datas->remarks != NULL){echo $datas->remarks;}else{echo 'None!';}?></p></td>
                                </tr>
                                
                                
                            </tbody>
                        </table>
                        
                    </div>
                    
                </div>
        
            </div>
            
        </div>
    </div>
    
    
    <?php if((srDecode($_GET['tp'])=='dv' && ($datas->status == 0 || $datas->status == 1 || $datas->status == 8)) || (($datas->status == 0 || $datas->status == 1 || $datas->status == 2 || $datas->status == 8) && srDecode($_GET['tp'])!='dv')){ ?> 
    
    <br><br><br><br>
    
    <div class="row">
        <div class="col-xs-12">
    
            <h3>Update Ticket Status</h3>
    
            <br><br>
    
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        
                        <?php if(srDecode($_GET['tp'])=='sp'){ ?>
                        
                        <form method="post">
                            <input type="hidden" name="id" value="<?=$datas->id?>">
                            <div class="input-group col-md-6" style="margin:auto;padding:4px;">
                                <label>Update Status:</label>
                                <select name="status" class="form-control" required>
                                    <option value=""></option>
                                    <?php foreign_relation('it_support_status', 'id', 'name', $datas->status, 'is_active=1 AND id IN (2,3,4,5)') ?>
                                </select>
                            </div>
                            <div class="input-group col-md-6" style="margin:auto;padding:4px;">
                                <label>Remark:</label>
                                <textarea class="form-control" name="remarks" style="resize:none;"><?=$datas->remarks?></textarea>
                            </div>
                            
                            <div class="input-group col-md-6 text-center" style="margin:auto;padding:4px;">
                                <input type="submit" name="Support_stat" class="btn btn-warning text-center" value="Update">
                            </div>
                            
                        </form>
                        
                        <?php }else if(srDecode($_GET['tp'])=='dv'){ ?>
                            
                        <form method="post">
                            <input type="hidden" name="id" value="<?=$datas->id?>">
                            <input type="hidden" name="pbi_id" value="<?=$datas->PBI_ID?>">
                            <div class="input-group col-md-6" style="margin:auto;padding:4px;">
                                <label style="display:table-caption;">Assign <?php if($datas->type==2){echo 'Accessories';}else if($datas->type==4){echo 'Device';} ?>: <span class="text-danger">*</span></label>
                                <select name="device" id="device" class="selectpicker form-control" data-live-search="true" required>
                                    <option value=""></option>
                                    <?php foreign_relation('it_support_devices', 'id', 'concat(serial,"::",name)', $device, 'status="1" AND type="'.$datas->type.'"') ?>
                                </select>
                            </div> 
                            <br>
                            <div class="input-group col-md-6" style="margin:auto;padding:4px;">
                                <label style="display:table-caption;">Condition:</label>
                                <select name="device_condition" class="selectpicker form-control" data-live-search="true" required>
                                    <option value=""></option>
                                    <?php foreign_relation('it_support_condition', 'id', 'name', $device_condition, 'is_active=1 AND id NOT IN (5)') ?>
                                </select>
                            </div>
                            <br>
                            <div class="input-group col-md-6" style="margin:auto;padding:4px;">
                                <label style="display:table-caption;">Remarks:</label>
                                <textarea class="form-control" name="remarks" style="resize:none;"><?=$datas->remarks?></textarea>
                            </div>
                            
                            <div class="input-group col-md-6 text-center" style="margin:auto;padding:4px;">
                                <input type="submit" name="assign_device" class="btn btn-success text-center" value="Assign">
                                <input type="submit" name="reject_request" class="btn btn-danger text-center" value="Reject" formnovalidate>
                            </div>
                            
                        </form>
                        
                        <br><br>
                            <h3 class="text-center">-- OR --</h3>
                        <br>
                        
                        <form method="post">
                            <input type="hidden" name="id" value="<?=$datas->id?>">
                            <div class="input-group col-md-6" style="margin:auto;padding:4px;">
                                <label>Update Status:</label>
                                <select name="status" class="form-control" required>
                                    <option value=""></option>
                                    <?php foreign_relation('it_support_status', 'id', 'name', $datas->status, 'is_active=1 AND id IN (8)') ?>
                                </select>
                            </div>
                            <div class="input-group col-md-6" style="margin:auto;padding:4px;">
                                <label>Remark:</label>
                                <textarea class="form-control" name="remarks" style="resize:none;" required><?=$datas->remarks?></textarea>
                            </div>
                            
                            <div class="input-group col-md-6 text-center" style="margin:auto;padding:4px;">
                                <input type="submit" name="Support_stat" class="btn btn-warning text-center" value="Update">
                            </div>
                            
                        </form>
                            
                        <?php } ?>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <?php } ?>


<?php

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";



?> 