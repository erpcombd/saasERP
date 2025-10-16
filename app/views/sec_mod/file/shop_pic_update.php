<?php
session_start ();
include ("config/access_admin.php");
include ("config/db.php");
include 'config/function.php';


$today 			  = date('Y-m-d');
$company_id   = $_SESSION['company_id'];
$menu 			  = 'Setup';
$sub_menu 		= 'admin_user';
$username	=$_SESSION['username'];


$id=$_GET['id'];
$pic=find1("select picture from ss_shop where dealer_code='".$id."'");


if(isset($_REQUEST['update']) && $_POST['randcheck']==$_SESSION['rand']){

// image upload

$ff = $username.'_'.time();
$target_dir = "../sec_mobile_app/uploads/";
$target_dir2 = "uploads/";
$file_name=$target_dir2.''.$ff;


$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$uploadOk = 1;

$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


// Check file size
if ($_FILES["fileToUpload"]["size"] > 26214400000) {
  echo "Sorry, your file is too large.<br>";
  $uploadOk = 0;
}



// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";

  //echo "Sorry, your given file type is not allowed.<br>";

  $uploadOk = 0;
  $image_ok=0;
}



$file_name=$file_name.'.'.$imageFileType;


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.<br>";


// if everything is ok, try to upload file
} else {

        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], '../sec_mobile_app/'.$file_name)) {


        echo "Picture has been uploaded.<br>";

        } else {

        echo "Sorry, there was an error uploading your file.<br>";

        }

   

}

// end image upload


$sql="update ss_shop set picture='".$file_name."' where dealer_code='".$_POST['dealer_code']."'";
mysqli_query($conn, $sql);

redirect("shop_pic_update.php?id='".$_POST['dealer_code']."'");

} // end update
?>



<?php
include 'inc/header.php';
include 'inc/sidebar.php';
?>  



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Shop Pic Update</h1>
          </div>
<!--           <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div> -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">








<form action="" method="post" enctype="multipart/form-data">
<?php $rand=rand(); $_SESSION['rand']=$rand; ?>
<input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />


<div class="form-floating mb-3">
<input type="text" class="form-control" name="dealer_code" id="dealer_code"  value="<?=$id?>" required readonly="readonly">
<label for="Shop Code">Shop Code</label>
</div> 


<div class="form-floating mb-3">
<input type="file" name="fileToUpload" id="fileToUpload" autocomplete="off" value="<?=$show->picture?>" class="form-control" required>
<label class="control-label" for="picture">Image<span class="required"></span></label>
</div> 


<div class="d-grid"><input type="submit" name="update" class="btn btn-lg btn-default shadow-sm btn-rounded" value="Update Image"/></div>

</form>



<br>
<div class="row mt-5">
    <img src="../sec_mobile_app/<?=$pic?>" width="400px">
</div>






      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 


<?php
include 'inc/footer.php';
?>  