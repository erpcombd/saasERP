<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Update Password";
$page = "update_password.php";
require_once '../assets/template/inc.header.php';


$user_id	= $_SESSION['user']['id'];
$emp_code   = $user_id;
$today 		= date('Y-m-d');


if($_POST['submitit']){
  
$dealer_code = $_SESSION['user']['id'];  
    
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $new_password2 = $_POST['new_password2'];

    $real_old_password = find_a_field('dealer_info','password','dealer_code="'.$dealer_code.'" ');
    //$real_old_password = find1(' select password from  dealer_info where dealer_code="'.$dealer_code.'" ');
    
    if($real_old_password == $old_password){
        
        if($new_password == $new_password2){
            
            $sql="update dealer_info set password='".$new_password."' where dealer_code='".$dealer_code."' ";
            mysqli_query($conn,$sql);
            
            $view = 'Your Password Changed Successfully !!';
            
        }else{
           $view = 'Sorry!! Your new password and repeat password not matched'; 
        }
        
        
        
        
    }else{
        
        $view = 'Sorry!! Your old Password not matched';
    }
    
}




?>





<!-- start of Page Content-->
<div class="page-content header-clear-medium">


        <div class="ps-3 pe-3 pt-0 mt-2 mb-2">
            <div class="d-flex pt-3">
                <div class="me-3">
                    <img src="../assets/images/profile.png" width="43">
                </div>
                <div class="flex-grow-1">
                    <h1 class="font-15 font-700 mb-0 titel_sub"><?=$_SESSION['user']['fname'];?> (<?=$_SESSION['user']['username'];?>)</h1>
                    <p class="mt-n2 m-0 font-11 font-400"><strong>Address:</strong> <?=$_SESSION['user']['address'];?></p>
                </div>
            </div>
        </div>

<p>
  <div><?=$view?></div>  
<p>


	<div class="card card-style mb-0">
		<form action="" method="post" name="codz" id="codz">
			<div class="content m-0">

				<label for="old_password">Old Password</label>
				<input type="password" name="old_password" id="old_password" value="" placeholder="" class="form-control validate-text" required/>
				
				<label for="fdate">New Password</label>
				<input type="password" name="new_password" id="new_password" value="" placeholder="" class="form-control validate-text" required/>
				
				<label for="fdate">New Password Repeat</label>
				<input type="password" name="new_password2" id="new_password2" value="" placeholder="" class="form-control validate-text" required/>

				<div class="d-flex justify-content-center row mt-3">
					<div class="col-6">
						<input type="submit" name="submitit" id="submitit" class="b-n btn btn-success btn-3d btn-block  text-light w-100 py-3" value="Update Password" />
					</div>
				</div>

			</div>
		</form>
	</div>



<div class="table-responsive pt-2" style="zoom: 70%;">

</div>


</div>
<!-- End of Page Content-->



<?php
require_once '../assets/template/inc.footer.php';
?>