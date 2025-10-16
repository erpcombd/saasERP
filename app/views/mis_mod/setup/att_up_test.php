<?php
/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";
require 'upload_function.php';

if(isset($_POST['insert'])){
    
    /*if($_FILES['attachment']['tmp_name']!=''){

	   $file_name= $_FILES['attachment']['name'];

	   $file_tmp= $_FILES['attachment']['tmp_name'];

	   $ext=end(explode('.',$file_name));
	   
	   $unique_id= rand(1,9).'_'.date("Ymd_His").'_'.rand(11,99);

	   $path='../../../../media_attachment_demo/test_upload/';

	   move_uploaded_file($file_tmp, $path.$unique_id.'.'.$ext);
	   $uploaded_file = $unique_id.'.'.$ext;
	   
    }*/
	
$fieldName = 'attachment';
//echo file_upload_wasabi($fieldName);
echo file_upload_aws($fieldName,'mis','bimol');
}

?>
<style>
    .card {
      margin-bottom: 20px;
    }
    .attachment-img {
      height: 200px;
      object-fit: cover;
    }
  </style>


<form method="post" enctype="multipart/form-data">
<div class="row">


 <a href="<?=upload_view_redirect('saaserp', 'mis', 'bimol.pdf');?>" target="_blank">View File</a>
 
    <div class="col-md-4 col-xs-12">
        <div class="form-group">
            <label>Upload Documents: </label>
            <input type="file" name="attachment" id="attachment" accept=".jpg, .jpeg, .png, .pdf">
            <?php if($datas->attachment!=''){ ?>
                <small>Currently attached: <?=$datas->attachment?></small>
            <?php } ?>
        </div>
    </div>
 
    
    <div class="col-md-12 col-xs-12 text-center">
        <div class="form-group text-center">
            <?php if($datas->id > 0){ ?>
            <input type="hidden" name="id" value="<?=$datas->id?>">
            <input type="submit" name="update" class="btn btn-warning" value="Update" style="margin-top:12px;margin-bottom:12px;">
            <?php }else{ ?>
            <input type="submit" name="insert" class="btn btn-success" value="Submit" style="margin-top:12px;margin-bottom:12px;">
            <?php } ?>
        </div>
    </div>
</div>
</form>



<div class="container mt-5">
  <div class="row">
    <?php
    $path = '../../../../media_attachment_demo/test_upload/';
    $dir = realpath($path);

    if ($dir && is_dir($dir)) {
        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $filePath = $path . $file;
                $fullUrl = htmlspecialchars($filePath); // Sanitize for HTML
                ?>
                <div class="col-md-4">
                  <div class="card">
                    <?php if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $file)): ?>
                      <img src="<?= $fullUrl ?>" class="card-img-top attachment-img" alt="<?= htmlspecialchars($file) ?>">
                    <?php else: ?>
                      <div class="card-body text-center">
                        <p class="card-text"><?= htmlspecialchars($file) ?></p>
                      </div>
                    <?php endif; ?>
                    <div class="card-body">
                      <h5 class="card-title"><?= htmlspecialchars($file) ?></h5>
                      <a href="<?= $fullUrl ?>" target="_blank" class="btn btn-primary">View</a>
                      <a href="<?= $fullUrl ?>" download class="btn btn-success">Download</a>
                    </div>
                  </div>
                </div>
                <?php
            }
        }
    } else {
        echo "<p class='text-danger'>Directory not found.</p>";
    }
    ?>
  </div>
</div>
  
    

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>
