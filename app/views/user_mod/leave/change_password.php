<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE.'routing/layout.top.php';

$title="Password Change";

$u_id=$_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);


if(isset($_POST['update']))

{

  $old_pass = md5($_POST['old_pass']);

  $new_pass = md5($_POST['new_pass']);

  $confirm_pass = md5($_POST['confirm_pass']);

  $orginal_old_pass = find_a_field('user_activity_management','password','PBI_ID="'.$PBI_ID.'"');

  

  if($old_pass==$orginal_old_pass){

      if($new_pass==$confirm_pass){

	  $update = 'update user_activity_management set password="'.$confirm_pass.'",default_checker="1" where user_id="'.$_SESSION['user']['id'].'" and PBI_ID="'.$PBI_ID.'"';

      $updated = db_query($update);

      $_SESSION['msggg']= '<span style="color:green;">Password Updated. Login Now</span>';

      echo "<script>window.top.location='../../pages/main/logout.php'</script>";

	  

	  }else{

	  $msg = '<span style="color:red; font-weight:bold;">New password & confirm password not match!</span>';

	  }

  }else{

     $msg = '<span style="color:red; font-weight:bold;">Old password not match!</span>';

  }







}



?>




<form action="" method="post" enctype="multipart/form-data">

		<div class="d-flex justify-content-center">

            <div class="n-form1 fo-short pt-0">
                <h4 class="text-center bg-titel bold pt-2 pb-2">      Password Change    </h4>

                        <div class="container">
                            <div class="form-group row  m-0 mb-1 pl-3 pr-3">
                                <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Old Password </label>
                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                      
                                                <input name="old_pass" type="password" id="old_pass" value=""  />

                                </div>
                            </div>
							<div class="form-group row  m-0 mb-1 pl-3 pr-3">
                                <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">New Password </label>
                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                        
                                                <input name="new_pass" type="password" id="new_pass" value="" />

                                     
                                </div>
                            </div>
							<div class="form-group row  m-0 mb-1 pl-3 pr-3">
                                <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Confirm Password </label>
                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                        
                                                <input name="confirm_pass" type="password" id="confirm_pass" value=""  />

                                        
                                </div>
                            </div>

                        </div>

                    <div class="n-form-btn-class">
                        <button name="update" accesskey="S" class="btn1 btn1-bg-update" type="submit">Update</button>
                    </div>

                </div>

            </div>
			
			
			
</form>





<?

require_once SERVER_CORE."routing/layout.bottom.php";
?>

