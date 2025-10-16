<?php

// Check if the form has been submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $level = isset($_POST['level']) ? $_POST['level'] : '';
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
    $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $designation = isset($_POST['designation']) ? $_POST['designation'] : '';
    $warehouse_id = isset($_POST['warehouse_id']) ? $_POST['warehouse_id'] : '';
    $group_for = isset($_POST['group_for']) ? $_POST['group_for'] : '';
    $uid = isset($_POST['uid']) ? $_POST['uid'] : '';
	$cid = isset($_POST['cid']) ? $_POST['cid'] : '';	
	$dbname = isset($_POST['dbname']) ? $_POST['dbname'] : '';

}else{
	 echo "<script>
        alert('Invalid access');

        // Try to close the window
        window.open('', '_self', '');
        window.close();

        // If it fails, prompt the user to close the tab manually
        setTimeout(function() {
            document.body.innerHTML = '<h2 style=\"text-align:center;margin-top:50px;\">Unauthorized access detected.<br>Please close this tab.</h2>';
        }, 500);
    </script>";
}

require_once "../../../controllers/routing/default_values.php";
require_once "../../../controllers/config/check_login_static.php";


if(check_for_loginstatic('saaserp','supportuser','312351bff07989769097660a56395065')){

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
    $_POST['entry_at'] = date('Y-m-d H:i:s');
	
	
    
    $folder = 'support_ticketing';
    $field = 'attachment';

    $_POST['attachment'] = implode(',', upload_files($folder,$field,$file_name));
	
	
	
	$_POST['assigned_to']=find_a_field('crm_project_org','assigned_person_id',' cid LIKE "%'.$_POST['cid'].'%"');

    
    if($_POST['assigned_to']!==''){
		$_POST['status'] = 'Assigned';
	}else{
		$_POST['status'] = 'Open';
	}
	
    
    
    
        $newID = $crud->insert();

        if ($newID) {
            echo "<script>location.href='success_page_client.php?ticket=".$newID."';</script>"; 
            exit;
        }
        if (!$newID) {
            die("Failed to insert data into the database. Please contact with the project manager.");
        }
        
        
}


// if(isset($_POST['update'])){
    
//     $_POST['update_by'] = $_SESSION['user']['id'];
//     $_POST['update_at'] = date('Y-m-d');
    
//     if(!isset($_POST['subcategory']) || $_POST['subcategory']!=''){
//         $_POST['subcategory'] = NULL;
//     }
    
//     if(!isset($_POST['otherNeed']) || $_POST['otherNeed']!=''){
//         $_POST['otherNeed'] = NULL;
//     }
    
    
//     if($_FILES['attachment']['tmp_name']!=''){

// 	   $file_name= $_FILES['attachment']['name'];

// 	   $file_tmp= $_FILES['attachment']['tmp_name'];

// 	   $ext=end(explode('.',$file_name));
	   
// 	    $unique_id= rand(1,9).'_'.date("Ymd_His").'_'.rand(11,99);

// 	   $path='../../../../media_attachment/support_documents/';
//        $uploaded_file = $unique_id.'.'.$ext;
        
// 	   if(move_uploaded_file($file_tmp, $path.$unique_id.'.'.$ext)){
	   
// 	    $oldImageName = find_a_field($table, 'attachment', 'id = "'.$_POST['id'].'"');
//         if($oldImageName != NULL && $oldImageName != $uploaded_file){
//             unlink($path.$oldImageName);
//         }else{
//             $_POST['attachment'] = $uploaded_file;
//         }
	   
// 	   }

//         $_POST['attachment'] = $uploaded_file;
        
// 		}
    
//     if($crud->update('id')){
        
//         echo "<script>location.href='support_request.php?update=".$_POST['id']."';</script>"; 
//         exit;
    
//     }
// }


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

.cke_notifications_area{
	display:none !important;
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
				    
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="form-group m-0 p-0">
                        <label class=" bg-form-titel-text">Problem:</label>
                        <input type="text" name="subject" class="req" value="<?=$datas->subject?>" placeholder="Write in short, what are you facing" required>
                       
                    </div>

                </div>
				
				    
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="form-group m-0 p-0">
                        <label class=" bg-form-titel-text">Module</label>
                        <select name="module_id" id="module_id" class="req">
						<option value=""></option>
						
						<?php foreign_relation('module_list', 'id', 'module_name', $datas->module_id, '1') ?>
						</select>
                       
                    </div>

                </div>		

				 
                
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">


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
                </div>
						 
				
				<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
				    			<?php  $TandC="<p>Please, write proper details of the problem including the device model, location, etc. (if required) for getting quick support</p>"?>
                     <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
                     
                    <div class="form-group m-0 p-0">
                        <label class=" bg-form-titel-text">Details:</label>
                        <textarea name="note" class="req" rows="4" placeholder="" required><? if ($datas->note!=''){echo $datas->note;} else{echo $TandC;} ?></textarea>
                       
                    </div>

                </div>
				
				<div class="n-form-btn-class col-12">
					<?php if($datas->id > 0){ ?>
					<input type="hidden" name="id" value="<?=$datas->id?>">
					<input type="submit" name="update" class="btn1 btn1-bg-update" value="Update" style="margin-top:12px;margin-bottom:12px;">
					<?php }else{ ?>
					
					<input type="hidden" name="cid" value="<?=$cid?>">
					<input type="hidden" name="db" value="<?=$dbname?>">
					
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
document.getElementById('attachment').addEventListener('change', function(e) {
    const fileList = document.getElementById('file-list');
    fileList.innerHTML = ''; // Clear previous entries

    const files = e.target.files;
    const maxFiles = 6;
    const maxSize = 5 * 1024 * 1024; // 5MB
    const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];

    if (files.length > maxFiles) {
        alert(`You can upload up to ${maxFiles} files.`);
        e.target.value = ''; // Clear selection
        return;
    }

    for (let file of files) {
        if (!allowedTypes.includes(file.type)) {
            alert(`Invalid file type: ${file.name}. Only JPG, PNG, and PDF are allowed.`);
            e.target.value = '';
            return;
        }

        if (file.size > maxSize) {
            alert(`File too large: ${file.name} (Max 5MB allowed).`);
            e.target.value = '';
            return;
        }

        // Display selected files
        const fileItem = document.createElement('div');
        fileItem.className = 'file-item';
        fileItem.innerHTML = `
            <span>${file.name}</span>
            <span>(${(file.size / 1024 / 1024).toFixed(2)} MB)</span>
        `;
        fileList.appendChild(fileItem);
    }
});
</script>
<script>
    CKEDITOR.replace( 'note' );
</script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sceditor@3/minified/themes/default.min.css" />
<script src="https://cdn.jsdelivr.net/npm/sceditor@3/minified/sceditor.min.js"></script>
<? } ?>