<?php
session_start ();
include ("../config/access_admin.php");
include ("../config/db.php");
include '../config/function.php';
$menu       = 'Setup';
$sub_menu   = 'card';
$today      = date('Y-m-d');
$company_id = $_SESSION['company_id'];
?>
        
<!--Top header	-->	
<?php include("inc/header.php");?>
<?php include("inc/header_top.php");?>
        
<?php
if(isset($_REQUEST['update'])){

$card_no     =get_safe_value($conn,$_POST['card_no']);


$ins_query="update setup_card_no set card_no='".$card_no."'
where id='".$company_id."'";
$query = mysqli_query($conn, $ins_query) or die(mysqli_error($conn));


}

$show = findall("select * from setup_card_no where id='".$company_id."'");
?>

<section class="content-main">
<div class="content-header">
<h2 class="content-title">Setup Card NO</h2>
</div>

<div class="card mb-4">
<div class="card-body">
<!--BODY Start	-->
				
<div class="row">
              <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title"><?php if($msg!=''){ echo $msg;} ?>
                   <h2>Visitor Card Details</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

<?php //echo @$msg; ?>
<form action="" method="post" id="myform" role="form" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
						
<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Card Nos<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12 mb-10">
<input type="text" name="card_no" required="required" 
class="form-control col-md-7 col-xs-12" value="<?php echo $show->card_no;?>">
</div></div>

		
					  
<div class="ln_solid"></div>
<div class="form-group">
<div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-3">
<!--<button class="btn btn-primary mt-10" type="reset">Reset</button>-->
<button name="update" type="submit"  class="btn btn-success">Update</button>
</div>
</div>
</form>

                  </div>
                </div>
              </div>
			  
			 

		  
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