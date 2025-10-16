<?php
session_start();
require_once "../../../controllers/core/init.php";
include 'pass_var.php';
$msg = '';
$password = $_POST['password'];
$old_pass = auth_encode($_POST['old_pass']);
$c_pass   = $_POST['confirm_pass'];
$final_status = 0;
$status = 1;
$length = 'style="color:red;"';
$number = 'style="color:red;"';
$upperCase = 'style="color:red;"';
$lowerCase = 'style="color:red;"';
$specialChar = 'style="color:red;"';
$previousPass = 'style="color:red;"';
$user_id = $_SESSION['vendor']['id'];

if (strlen($password) < 8) {
         $policy_status = 0;
	     $length = 'style="color:red;"';
    }else{
	     $policy_status = 1;
	     $length = 'style="color:green;"';
	}

    // Check if password contains at least one number
    if (!preg_match('/[0-9]/', $password)) {
         $policy_status = 0;
	     $number = 'style="color:red;"';
    }else{
	     $policy_status = 0;
	     $number = 'style="color:green;"';
	}

    // Check if password contains at least one uppercase letter
    if (!preg_match('/[A-Z]/', $password)) {
         $policy_status = 0;
	     $upperCase = 'style="color:red;"';
    }else{
	     $policy_status = 1;
	     $upperCase = 'style="color:green;"';
	}

    // Check if password contains at least one lowercase letter
    if (!preg_match('/[a-z]/', $password)) {
         $policy_status = 0;
	     $lowerCase = 'style="color:red;"';
    }else{
	     $policy_status = 1;
	     $lowerCase = 'style="color:green;"';
	}

    // Check if password contains at least one special character
    if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
         $policy_status = 0;
	     $specialChar = 'style="color:red;"';
    }else{
	     $policy_status = 1;
	     $specialChar = 'style="color:green;"';
	}
	

  
    

    $sql = "SELECT * FROM vendor WHERE vendor_id=".$user_id." and ".$pvalue."='".$old_pass."'";
    $qry = db_query($sql);
    $item = mysqli_fetch_object($qry);
    $orginal_old_pass = $item->password;
    if ($orginal_old_pass == $old_pass) {
		$old_pass_status = 1;
	}else{
		$msg = 'Old Password Not Match!';
		$old_pass_status = 0;
		}
	
	
	
    
	    
        if ($password == $c_pass) {
            $new_and_confirm_status = 1;
        } else {
            $new_and_confirm_status = 0;
            $msg = 'New Password And Confirm Password Not Matched!';
        }
		
		$pre_pass = 'select * from password_logs where user_id="'.$user_id.'" order by id desc limit 6';
		$qrry = db_query($pre_pass);
		$new_pass = auth_encode($password);
		while($pass_data = mysqli_fetch_object($qrry)){
		 if($new_pass==$pass_data){
		   $pre_pass_match += 1;
		 }else{
		 $pre_pass_match = 0;
		 }
		}
		
		if($pre_pass_match>0){
		$pre_pass_status = 0;
		$previousPass = 'style="color:red;"';
		}else{
		$pre_pass_status = 1;
		$previousPass = 'style="color:green;"';
		}
	
		
	/*function isPasswordExpired($lastChangedDate) {	
	$expirationPeriod = 45;

    $expirationDate = strtotime($lastChangedDate . " + $expirationPeriod days");
    $currentDate = time();
    if ($currentDate > $expirationDate) {
        return true;
    } else {
        return false;
    }
	
	}

$passwordLastChangedDate = $actual->change_date;

if (isPasswordExpired($passwordLastChangedDate)) {
   echo $valid = 0;
} else {
    echo $valid = 1;
}*/
    
$str = '';
$str = '<ul><li>The password should comprise of the following requirements:
                <ul>
                  <li '.$length.'>8 or more characters long</li>
                  <li '.$number.'>Password must contain 1 number</li>
                  <li '.$upperCase.'>Password must contain 1 upper case character</li>
                  <li '.$lowerCase.'>Password must contain 1 lower case character</li>
                  <li '.$specialChar.'>Password must contain 1 special character</li>
				  <li '.$previousPass.'>Unable to reuse 6 or more previous passwords</li>
                </ul>
                </li>
 
               </ul>';

if($policy_status==1 && $old_pass_status==1 && $new_and_confirm_status==1 && $pre_pass_status==1){	
$final_status = 1;		   
$button = '<button  name="ibspassupdate" accesskey="S" type="submit" class="btn btn-success btn-block shadow border-0 py-2 text-uppercase ">Update</button>';
}else{
$button = '';
}
$response['msg'] = $msg;
$response['policy'] = $str;
$response['final_status'] = $final_status;
$response['passchangebutton'] = $button;

echo json_encode($response);
?>

 