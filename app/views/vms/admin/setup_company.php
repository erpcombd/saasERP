<?php
session_start ();
include ("../config/access_admin.php");
include ("../config/db.php");
include '../config/function.php';
$menu = 'Setup';
$sub_menu = 'company';
$today = date('Y-m-d');
$company_id     = $_SESSION['company_id'];
?>
        
<!--Top header	-->	
<?php include("inc/header.php");?>
<?php include("inc/header_top.php");?>
        
<?php
if(isset($_REQUEST['update'])){

$name               =get_safe_value($conn,$_POST['name']);
$company_name 		=get_safe_value($conn, $_POST['company_name']);
$address 			=get_safe_value($conn, $_POST['address']);
$email 				=get_safe_value($conn, $_POST['email']);
$company_mobile 	=get_safe_value($conn, $_POST['company_mobile']);
$company_fb 		=get_safe_value($conn, $_POST['company_fb']);
$company_twitter 	=get_safe_value($conn, $_POST['company_twitter']);
$company_instagram 	=get_safe_value($conn, $_POST['company_instagram']);
$company_youtube 	=get_safe_value($conn, $_POST['company_youtube']);


$image_name = $company_id;

    extract($_REQUEST);
    $permited  = array('jpg','png','JPG');
    $file_name = $_FILES['picture']['name'];
    $file_size = $_FILES['picture']['size'];
    $file_temp = $_FILES['picture']['tmp_name'];

    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    $same_image = $image_name.'.png';
    $uploaded_image = "../images/logo/".$same_image;
    
$image = $same_image;


$ins_query="update setup_company set logo='".$image."',company_name='".$company_name."',address='".$address."',email='".$email."'
,company_mobile='".$company_mobile."',company_fb='".$company_fb."',company_twitter='".$company_twitter."',company_instagram='".$company_instagram."',company_youtube='".$company_youtube."'
where id='".$company_id."'";
$query = mysqli_query($conn, $ins_query) or die(mysqli_error($conn));


if(!empty($file_name)){
    if ($file_size >5555512) {
     $msg= "<span style='color:#FF7F50;font-size:20px;'>Image Size should be less then 512KB</span>";

} elseif (in_array($file_ext, $permited) === false) {
$msg= "<span style='color:#FF7F50;font-size:20px;'>You can upload only: ".implode(', ', $permited)." picture</span>";

} else{ 
move_uploaded_file($file_temp,$uploaded_image);
$msg='Update Successfull';

 }}
}

$show = findall("select * from setup_company where id='".$company_id."'");
?>

<section class="content-main">
<div class="content-header">
<h2 class="content-title">Setup Company</h2>
</div>

<div class="card mb-4">
<div class="card-body">
<!--BODY Start	-->
				
<div class="row">
              <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title"><?php if($msg!=''){ echo $msg;} ?>
                   <h2>Company Information</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

<?php //echo @$msg; ?>
<form action="" method="post" id="myform" role="form" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
						
<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Company<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="company_name" required="required" 
class="form-control col-md-7 col-xs-12" value="<?php echo $show->company_name;?>">
</div></div>


<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Logo<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="file" class="custom-file-input" name="picture" 
  id="capture" accept="image/*,video/*,audio/*" capture multiple/>
</div></div>  
  
<p><img src="" id="img" alt="" width="200px"/></p>


<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Address<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="address" required="required" 
class="form-control col-md-7 col-xs-12" value="<?php echo $show->address;?>">
</div></div>	

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">email<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="email" required="required" 
class="form-control col-md-7 col-xs-12" value="<?php echo $show->email;?>">
</div></div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mobile<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="company_mobile" required="required" 
class="form-control col-md-7 col-xs-12" value="<?php echo $show->company_mobile;?>">
</div></div>


<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Facebook<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="company_fb" required="required" 
class="form-control col-md-7 col-xs-12" value="<?php echo $show->company_fb;?>">
</div></div>


<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Twitter<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="company_twitter" required="required" 
class="form-control col-md-7 col-xs-12" value="<?php echo $show->company_twitter;?>">
</div></div>


<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Instagram<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="company_instagram" required="required" 
class="form-control col-md-7 col-xs-12" value="<?php echo $show->company_instagram;?>">
</div></div>


<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Youtube<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="company_youtube" required="required" 
class="form-control col-md-7 col-xs-12" value="<?php echo $show->company_youtube;?>">
</div></div>

						
<!--<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Google Map<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="google_map" required="required" 
class="form-control col-md-7 col-xs-12" value="<?php echo $show->google_map;?>">
</div></div>-->					
						
					  
<div class="ln_solid"></div>
<div class="form-group">
<div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-3">
<!--<button class="btn btn-primary" type="reset">Reset</button>-->
<button name="update" type="submit"  class="btn btn-success">Update</button>
</div>
</div>
</form>

                  </div>
                </div>
              </div>
			  
			 
<!--2nd column	-->		 
<div class="col-md-4 col-sm-4 col-xs-4">
                <div class="x_panel">
                  <div class="x_title">
                   <h2>Company Logo</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

<img src="../images/logo/<?=$show->logo;?>" width="200px">

                  </div>
                </div>
              </div>
<!--End 2nd column	-->	

		  
            </div>				

				

<!-- Body end -->
</section> 		

        
		
		
<?php include("inc/footer.php");?>


<script>
 document.addEventListener('DOMContentLoaded', (ev)=>{
            let form = document.getElementById('myform');
            //get the captured media file
            let input = document.getElementById('capture');
            
            input.addEventListener('change', (ev)=>{
                console.dir( input.files[0] );
                if(input.files[0].type.indexOf("image/") > -1){
                    let img = document.getElementById('img');
                    img.src = window.URL.createObjectURL(input.files[0]);
                }
        
            })
            
 })
</script>