<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title = "IT Support Request";

$table = 'it_support_request';

$crud = new crud($table);


function getNewReqId(){
    
    $key = chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).rand(1,9).rand(1,9).rand(1,9);
    
    $findQry = "SELECT request_id FROM it_support_request WHERE request_id = '$key'";
    $finding_rslt = db_query($findQry);
    if(mysqli_fetch_object($finding_rslt)){
        return getNewReqId();
    }else{
        return $key;
    }
    
}


if(isset($_POST['insert'])){
    
    $_POST['entry_by'] = $_SESSION['user']['id'];
    $_POST['PBI_ID'] = $_SESSION['employee_selected'];
    $_POST['request_id'] = getNewReqId();
   
    if(!isset($_POST['subcategory']) || $_POST['subcategory']=='' || $_POST['subcategory']==0){
        $_POST['subcategory'] = NULL;
    }
    
    if(!isset($_POST['otherNeed']) || $_POST['otherNeed']==''){
        $_POST['otherNeed'] = NULL;
    }
    
    if(!empty($_FILES['attachment']['tmp_name'][0])) {
        $uploaded_files = [];
        $path = '../../../../../../mvc_media/ticketing/';

        if (!is_dir($path)) {
            if (!mkdir($path, 0777, true) && !is_dir($path)) {
                //die("Failed to create directory: $path");
                echo "Failed to create directory";
            }
        }

        foreach ($_FILES['attachment']['tmp_name'] as $key => $tmp_name) {
            $file_name = $_FILES['attachment']['name'][$key];
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);

            $unique_id = rand(1, 9) . '_' . date("Ymd_His") . '_' . rand(11, 99);
            if (move_uploaded_file($tmp_name, $path . $new_file_name)) {
                $uploaded_files[] = $new_file_name;
            } else {
                die("Failed to upload file: $file_name");
            }
                $uploaded_files[] = $new_file_name;
            }
        }

        if (!empty($uploaded_files)) {
            $_POST['attachment'] = implode(',', $uploaded_files);
        }
    }
    
    
    //if(){
    
        $newID = $crud->insert();
        
        // $pInfo = find_all_field('personnel_basic_info', '', 'PBI_ID="'.$_POST['PBI_ID'].'"');
   
        // $msg = 'Hello '.$pInfo->PBI_NAME.' ('.$pInfo->PBI_CODE.'),<br>You have successfully submitted a support ticket. Here are the details below-';$msg .= '<br><br>Your Request ID: '.$_POST['request_id'];
        // $msg .= '<br>Support Type: '.find_a_field('it_support_type', 'name', 'id="'.$_POST['type'].'"');
        
        // if(isset($_POST['subcategory']) && $_POST['subcategory'] > 0){
        //     $msg .= '<br>Requested for: '.find_a_field('it_support_subcategory', 'name', 'id="'.$_POST['subcategory'].'"');
        // }else if(isset($_POST['subcategory']) && $_POST['subcategory'] <= 0 && isset($_POST['otherNeed'])){
        //     $msg .= '<br>Requested for: '.$_POST['otherNeed'];
        // }
        
        // $msg .= '<br>Priority: '.find_a_field('it_support_priority', 'name', 'id="'.$_POST['priority'].'"');
        // $msg .= '<br>Problem: '.$_POST['subject'];
        
        // if(isset($_POST['device']) && $_POST['device'] > 0){
        //     $msg .= '<br>Device: '.find_a_field('it_support_device', 'name', 'id="'.$_POST['device'].'"');
        // }
        
        // $msg .= '<br>Note: '.$_POST['note'];
        // $msg .= '<br><br>We will contact you using: '.$pInfo->PBI_EMAIL.' OR '.$pInfo->PBI_MOBILE.' if required.';
        // $msg .= '<br>We will try our best to solve your issue as soon as possible. Please check the status using the Request ID. Thank you.';
        
        // $userMail = $pInfo->PBI_EMAIL;
        
        // if($userMail == '' || $userMail == NULL){
        //     mail_srabon('it@reverie-bd.com', 'Requesting IT Support', $msg);
        // }else{
        //     mail_srabon($userMail, 'Requesting IT Support', $msg, '', 'it@reverie-bd.com');
        // }
        
        //echo "<script>location.href='support_request.php?update=".$newID."';</script>"; 
        //exit;
    
    // }
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
    
    
    if($_FILES['attachment']['tmp_name']!=''){

	   $file_name= $_FILES['attachment']['name'];

	   $file_tmp= $_FILES['attachment']['tmp_name'];

	   $ext=end(explode('.',$file_name));
	   
	    $unique_id= rand(1,9).'_'.date("Ymd_His").'_'.rand(11,99);

	   $path='../../../../media_attachment/support_documents/';
       $uploaded_file = $unique_id.'.'.$ext;
        
	   if(move_uploaded_file($file_tmp, $path.$unique_id.'.'.$ext)){
	   
	    $oldImageName = find_a_field($table, 'attachment', 'id = "'.$_POST['id'].'"');
        if($oldImageName != NULL && $oldImageName != $uploaded_file){
            unlink($path.$oldImageName);
        }else{
            $_POST['attachment'] = $uploaded_file;
        }
	   
	   }

        $_POST['attachment'] = $uploaded_file;
        
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

.upload-box {
    border: 2px dashed #dcdcdc;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    background: #f9f9ff;
}
#upload-icon {
    font-size: 24px;
    color: #888;
}
.file-list {
    margin-top: 10px;
}
.file-item {
    background: #f3f6fc;
    padding: 5px 10px;
    border-radius: 5px;
    margin-bottom: 5px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.file-item span {
    flex-grow: 1;
}
.file-item .remove-btn {
    color: red;
    cursor: pointer;
}



</style>

<form method="post" enctype="multipart/form-data">
<div class="container-fluid p-0">
			<div class="col-12 shadow1  round">

				<div class="row new-bg m-0">
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group m-0 p-0">
                        <label>Support Date:</label>
                            <input type="date" name="fdate" value="<?=date('Y-m-d')?>" class="form-control req" readonly>
                    </div>

                </div>
				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group m-0 p-0">
                        <label class=" bg-form-titel-text">Support Type:</label>
						<select name="type" data-live-search="true"  class="req" onchange="getData2('getSubCat.php', 'subCatSelect', this.value); setDeviceRequired(this.value);" required>
							<option value=""></option>
							<?php foreign_relation('it_support_type', 'id', 'name', $datas->type, 'is_active=1') ?>
						</select>
                       
                    </div>

                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group m-0 p-0">
                        <label class=" bg-form-titel-text">Priority:</label>
                           	<select name="priority" class="req" required>
								<option value=""></option>
								<?php foreign_relation('it_support_priority', 'id', 'name', $datas->priority, 'is_active=1') ?>
							</select> 
                       
                    </div>

                </div>


                
<?php /*?>                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
							<span id="subCatSelect"></span>
							<span id="otherSubCat"></span>
							<?php if($datas->otherNeed!=''){ ?>
                    		<div class="form-group m-0 p-0">
                        		<!--<label class=" bg-form-titel-text">To:</label>-->
								<input type="text" class="form-control req1" value="<?=$datas->otherNeed?>" name="otherNeed" placeholder="What do you need that isn't enlisted yet..." required>
							</div>
						<?php } ?>
                </div><?php */?>
				    
				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group m-0 p-0">
                        <label class=" bg-form-titel-text">Problem:</label>
                        <input type="text" name="subject" class="req" value="<?=$datas->subject?>" placeholder="Write in short, what are you facing" required>
                       
                    </div>

                </div>
				
				    
				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group m-0 p-0">
                        <label class=" bg-form-titel-text">Module</label>
                        <select name="module_id" id="module_id" class="req">
						<option value=""></option>
						
						<?php foreign_relation('module_list', 'id', 'module_name', $datas->module_id, '1') ?>
						</select>
                       
                    </div>

                </div>		

				<div class="form-group">
                    <label>Attachment <small>(Upload up to 6 files)</small></label>
                    <div id="drop-area" class="upload-box">
                    <input type="file" id="attachment" name="attachment[]" accept=".jpg,.jpeg,.png,.pdf" multiple hidden>
                    <div id="upload-icon" onclick="document.getElementById('attachment').click();">
                        <i class="fa fa-upload"></i>
                    </div>
                </div>
                    <div id="file-list" class="file-list"></div>
                </div>  	
						    
				<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="form-group m-0 p-0">
                        <label class=" bg-form-titel-text">Details:</label>
                        <textarea name="note" class="req" rows="4" placeholder="Please, write proper details of the problem including the device model, location, etc. (if required) for getting quick support" required><?=$datas->note?></textarea>
                       
                    </div>

                </div>
				
				
				<div class="n-form-btn-class col-12">
					<?php if($datas->id > 0){ ?>
					<input type="hidden" name="id" value="<?=$datas->id?>">
					<input type="submit" name="update" class="btn1 btn1-bg-update" value="Update" style="margin-top:12px;margin-bottom:12px;">
					<?php }else{ ?>
					<input type="submit" name="insert" class="btn1 btn1-bg-submit" value="Submit" style="margin-top:12px;margin-bottom:12px;">
					<?php } ?>
				</div>
                

            </div>
				
			</div>
        </div>
</form>
  
    

<?php

require_once SERVER_CORE."routing/layout.bottom.php";

?>


<script>
    
    let A = document.getElementById('mayReq');
    let B = document.getElementById('device');
    let c = document.getElementById('device');
    
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

<script>
let maxFiles = 6;
let selectedFiles = [];

document.getElementById('attachment').addEventListener('change', function (e) {
    let files = Array.from(e.target.files);
    if ((selectedFiles.length + files.length) > maxFiles) {
        alert("You can upload up to 6 files.");
        return;
    }

    files.forEach(file => {
        selectedFiles.push(file);
        displayFile(file);
    });

    // Reset the input
    this.value = "";
});

function displayFile(file) {
    let list = document.getElementById('file-list');

    let item = document.createElement('div');
    item.classList.add('file-item');

    let fileName = document.createElement('span');
    fileName.innerText = file.name;

    let removeBtn = document.createElement('span');
    removeBtn.classList.add('remove-btn');
    removeBtn.innerHTML = '&times;';
    removeBtn.onclick = () => {
        selectedFiles = selectedFiles.filter(f => f !== file);
        item.remove();
    };

    item.appendChild(fileName);
    item.appendChild(removeBtn);
    list.appendChild(item);
}
</script>


