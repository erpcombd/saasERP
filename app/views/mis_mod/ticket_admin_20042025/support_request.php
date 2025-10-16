<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title = "IT Support Request";

$table = 'it_support_request';

$crud = new crud($table);


function getNewReqId(){
    
    $key = chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).rand(1,9).rand(1,9).rand(1,9);
    
    $findQry = "SELECT request_id FROM $table WHERE request_id = '$key'";
    $finding_rslt = db_query($findQry);
    if(mysqli_fetch_object($finding_rslt)){
        return getNewReqId();
    }else{
        return $key;
    }
    
}


if(isset($_POST['insert'])){
    
    $_POST['entry_by'] = $_SESSION['user']['id'];
    $_POST['request_id'] = getNewReqId();
    
    if(!isset($_POST['subcategory']) || $_POST['subcategory']=='' || $_POST['subcategory']==0){
        $_POST['subcategory'] = NULL;
    }
    
    if(!isset($_POST['otherNeed']) || $_POST['otherNeed']==''){
        $_POST['otherNeed'] = NULL;
    }
    
    if($crud->insert()){
    
        $newID = getLastInsertID($table, 'id')+1;
        
        $pInfo = find_all_field('personnel_basic_info', '', 'PBI_ID="'.$_POST['PBI_ID'].'"');
        
        $msg = 'Hello '.$pInfo->PBI_NAME.' ('.$pInfo->PBI_CODE.'),<br>You have successfully submitted a support ticket. Here are the details below-';
        $msg .= '<br><br>Your Request ID: '.$_POST['request_id'];
        $msg .= '<br>Support Type: '.find_a_field('it_support_type', 'name', 'id="'.$_POST['type'].'"');
        
        if(isset($_POST['subcategory']) && $_POST['subcategory'] > 0){
            $msg .= '<br>Requested for: '.find_a_field('it_support_subcategory', 'name', 'id="'.$_POST['subcategory'].'"');
        }else if(isset($_POST['subcategory']) && $_POST['subcategory'] <= 0 && isset($_POST['otherNeed'])){
            $msg .= '<br>Requested for: '.$_POST['otherNeed'];
        }
        
        $msg .= '<br>Priority: '.find_a_field('it_support_priority', 'name', 'id="'.$_POST['priority'].'"');
        $msg .= '<br>Problem: '.$_POST['subject'];
        
        if(isset($_POST['device']) && $_POST['device'] > 0){
            $msg .= '<br>Device: '.find_a_field('it_support_device', 'name', 'id="'.$_POST['device'].'"');
        }
        
        $msg .= '<br>Note: '.$_POST['note'];
        $msg .= '<br><br>We will contact you using: '.$pInfo->PBI_EMAIL.' OR '.$pInfo->PBI_MOBILE.' if required.';
        $msg .= '<br>We will try our best to solve your issue as soon as possible. Please check the status using the Request ID. Thank you.';
        
        $userMail = $pInfo->PBI_EMAIL;
        
        if($userMail == '' || $userMail == NULL){
            mail_srabon('it@reverie-bd.com', 'Requesting IT Support', $msg);
        }else{
            mail_srabon($userMail, 'Requesting IT Support', $msg, '', 'it@reverie-bd.com');
        }
        
        echo "<script>location.href='support_request.php?update=".$newID."';</script>"; 
        exit;
    
    }
}


if(isset($_POST['update'])){
    
    $_POST['update_by'] = $_SESSION['user']['id'];
    $_POST['update_at'] = date('Y-m-d');
    
    if(!isset($_POST['subcategory']) || $_POST['subcategory']!=''){
        $_POST['subcategory'] = NULL;
    }
    
    if(!isset($_POST['otherNeed']) || $_POST['otherNeed']!=''){
        $_POST['otherNeed'] = NULL;
    }
    
    if($crud->update('id')){
        
        echo "<script>location.href='support_request.php?update=".$_POST['id']."';</script>"; 
        exit;
    
    }
}


$datas = find_all_field($table, '', 'id="'.$_GET['update'].'"');

?>
<style>
.sr-main-content-padding {
    background: #f5f5f5 !important;
    padding: 10px 20px;
    border: 1px solid #f5f5f5;
    border-bottom: none;
}
.sr-main-content, .wrapper {
    background-color: #f5f5f5 !important;
}
.sidebar {
    background: #F5F5F2 !important;
    position: fixed;
}

body {
    background-color: #f5f5f5 !important;
}
.form-container_large {
padding:0px !important;}
.round{
    border-radius: 5px !important;
}

.shadow1 {
    background-color: var(--add-shadow1-bg-color);
    box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.16), 0px 0px 0px rgba(0, 0, 0, 0.23);
}
</style>



   <!-- <div class="row well">-->
       <!-- <div class="col-12 text-right">
            <div class="form-group text-center">-->
                <a href="support_req_list.php" class="btn btn-sm btn-warning" style="margin-top:5px;margin-bottom:5px;"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
                <a href="support_request.php" class="btn btn-sm btn-danger" style="margin-top:5px;margin-bottom:5px;"><i class="glyphicon glyphicon-refresh"></i> Reset</a>
           <!-- </div>
            
        </div>
    </div>-->
	<form method="post" enctype="multipart/form-data">
	<div class="container-fluid p-0">
	<div class="col-12 shadow1  round">
    <div class="row new-bg m-0">
       
           
          <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group m-0 p-0">
                <label>Select Employee: <?php if($datas->PBI_ID>0){echo 'disabled';}else{echo '<span class="text-danger">*</span>';} ?></label>
                    <?php if($datas->PBI_ID <= 0){ ?>
                    <input type="hidden" name="PBI_ID" class="form-control req" value="<?=$_SESSION['employee_selected']?>">
                    <?php } ?>
                <select class="req" data-live-search="true" <?php if($datas->PBI_ID>0){echo 'disabled';}else{echo 'name="PBI_ID" required';} ?> onchange="getData2('employeeDevice.php', 'deviceList', this.value);">
                        <option value=""></option>
                        <?php foreign_relation('user_activity_management', 'PBI_ID', 'concat(fname,"::",username)', $datas->PBI_ID, 'status <> "Inactive"') ?>
                </select> 
            </div>
        </div>
        
      <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group m-0 p-0">
                <label>Support Type: <span class="text-danger">*</span></label>
                    <select name="type" class="req" data-live-search="true" onchange="getData2('getSubCat.php', 'subCatSelect', this.value); setDeviceRequired(this.value);" required>
                        <option value=""></option>
                        <?php foreign_relation('it_support_type', 'id', 'name', $datas->type, 'is_active=1') ?>
                    </select> 
            </div>
        </div>
        <!--<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group m-0 p-0">
                <span id="subCatSelect"></span>
            </div>
        </div>-->
       <!--<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group m-0 p-0">
                <span id="otherSubCat"></span>
            </div> 
        </div>-->
        <?php if($datas->otherNeed!=''){ ?>
        <div class="form-group">
            <input type="text" class="req" value="<?=$datas->otherNeed?>" name="otherNeed" placeholder="What do you need that isn't enlisted yet..." required>
        </div>
        <?php } ?>
       <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group m-0 p-0">
                <label>Priority: <span class="text-danger">*</span></label>
                    <select name="priority" class="req" required>
                        <option value=""></option>
                        <?php foreign_relation('it_support_priority', 'id', 'name', $datas->priority, 'is_active=1') ?>
                    </select> 
            </div>
        </div>
        
       <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group m-0 p-0">
                    <label>Assigned Device<span id="mayReq"></span></label>
                    <select name="device" id="device" class="req">
                        <option value=""></option>
                        <option value="0">Personal</option>
                        <?php foreign_relation('it_support_devices a, it_assigned_devices b', 'a.id', 'a.name', $datas->device, 'a.id=b.device and b.PBI_ID = "'.$_SESSION['user']['PBI_ID'].'"') ?>
                    </select>
            </div>
        </div>
        
        
       <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group m-0 p-0">
                <label>Problem: <span class="text-danger">*</span></label>
                <input type="text" name="subject" class=" req" value="<?=$datas->subject?>" placeholder="Write in short, what are you facing" required>
            </div>        
        </div>
      <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group m-0 p-0">
                <label>Details: <span class="text-danger">*</span></label>
                <textarea name="note" class=" req" rows="4" style="resize:none!important;" placeholder="Please, write proper details of the problem including the device model, location, etc. (if required) for getting quick support" required><?=$datas->note?></textarea>
            </div>
        </div>
        
        <div class="col-md-12 col-xs-12">
            <div class="form-group text-center">
                    <?php if($datas->id > 0){ ?>
                    <input type="hidden" name="id" value="<?=$datas->id?>">
                    <input type="submit" name="update" class="btn btn-warning" value="Update" style="margin-top:12px;margin-bottom:12px; padding:6px 18px !important; ">
                    <?php }else{ ?>
                    <input type="submit" name="insert" class="btn btn-success" value="Submit" style="margin-top:12px;margin-bottom:12px; padding:6px 18px !important;">
                    <?php } ?>
                </div>
        </div>
        </div>
        </form>
    </div>
</div>
</div>
<?php /*

    <div class="row">
        <div class="col-xs-12 d-flex mx-auto">
            
            <form method="post">
                
                <div class="form-group">
                    <label>Select Employee: <?php if($datas->PBI_ID>0){echo 'disabled';}else{echo '<span class="text-danger">*</span>';} ?></label>
                    <?php if($datas->PBI_ID <= 0){ ?>
                    <input type="hidden" name="PBI_ID" value="<?=$_SESSION['employee_selected']?>">
                    <?php } ?>
                    <select class="selectpicker form-control" data-live-search="true" <?php if($datas->PBI_ID>0){echo 'disabled';}else{echo 'name="PBI_ID" required';} ?> onchange="getData2('employeeDevice.php', 'deviceList', this.value);">
                        <option value=""></option>
                        <?php foreign_relation('user_activity_management', 'PBI_ID', 'concat(fname,"::",username)', $datas->PBI_ID, 'status <> "Inactive"') ?>
                    </select> 
                </div>
                
                <div class="form-group">
                    <label>Support Type: <span class="text-danger">*</span></label>
                    <select name="type" class="selectpicker form-control" data-live-search="true" onchange="getData2('getSubCat.php', 'subCatSelect', this.value); setDeviceRequired(this.value);" required>
                        <option value=""></option>
                        <?php foreign_relation('it_support_type', 'id', 'name', $datas->type, 'is_active=1') ?>
                    </select> 
                </div>
                
                <span id="subCatSelect"></span>
                <span id="otherSubCat"></span>
                
                <div class="form-group">
                    <label>Priority: <span class="text-danger">*</span></label>
                    <select name="priority" class="selectpicker form-control" required>
                        <option value=""></option>
                        <?php foreign_relation('it_support_priority', 'id', 'name', $datas->priority, 'is_active=1') ?>
                    </select> 
                </div>
                
                <div class="form-group">
                    <label>Problem: <span class="text-danger">*</span></label>
                    <input type="text" name="subject" class="form-control" value="<?=$datas->subject?>" placeholder="Write in short, what are you facing" required>
                </div>
                
                <span id="deviceList">
                <div class="form-group"> 
                    <label>Assigned Device<span id="mayReq"></span></label>
                    <select name="device" id="device" class="selectpicker form-control">
                        <option value=""></option>
                        <option value="0">Personal</option>
                        <?php foreign_relation('it_support_devices a, it_assigned_devices b', 'a.id', 'a.name', $datas->device, 'a.id=b.device and b.PBI_ID = "'.$_SESSION['user']['PBI_ID'].'"') ?>
                    </select>
                </div>
                </span>
                
                <div class="form-group">
                    <label>Details: <span class="text-danger">*</span></label>
                    <textarea name="note" class="form-control" rows="4" style="resize:none!important;" placeholder="Please, write proper details of the problem including the device model, location, etc. (if required) for getting quick support" required><?=$datas->note?></textarea>
                </div>
                
                <div class="form-group text-center">
                    <?php if($datas->id > 0){ ?>
                    <input type="hidden" name="id" value="<?=$datas->id?>">
                    <input type="submit" name="update" class="btn btn-warning" value="Update" style="margin-top:12px;margin-bottom:12px;">
                    <?php }else{ ?>
                    <input type="submit" name="insert" class="btn btn-success" value="Submit" style="margin-top:12px;margin-bottom:12px;">
                    <?php } ?>
                </div>
                
            </form>
            
        </div>
    </div>
    
*/ ?>

<?php

require_once SERVER_CORE."routing/layout.bottom.php";

?>


<script>
    
    let A = document.getElementById('mayReq');
    let B = document.getElementById('device');
    
    setDeviceRequired(<?=$datas->type?>);
    
    function setDeviceRequired(type){
        
        if(type == 2) {
            A.innerHTML = ':<small class="text-danger" style="font-size:10px;"> *</small>';
            B.setAttribute("required", "");
        }else{
            A.innerHTML = '<small>(optional)</small>:';
            B.removeAttribute("required");
        }
        
    }
    
    
    
</script>

