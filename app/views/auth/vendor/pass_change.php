<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_AUTH."db_con_live_static.php";

if(isset($_POST['ibssignin']))
{

$otp = $_POST['otp'];
$new_pass = $_POST['new_password'];
$confirm_pass = $_POST['confirm_password'];

 if($new_pass==$confirm_pass && $_SESSION['pass_changer_user_id']>0){
 
 $key = 'ROBI'; // 256-bit key for AES-256
 $iv = '1234567890123456'; // 16 char
 $encode_pass = openssl_encrypt($confirm_pass, 'aes-256-cbc', $key, 0, $iv);

 $update = $new_conn->query('update user_activity_management set password="'.$encode_pass.'" where user_id="'.$_SESSION['pass_changer_user_id'].'" 
 and email="'.$_SESSION['pass_changer_email'].'"');
  $_SESSION['mmsg'] = '<span style="color:green; font-weight:bold; font-size:20px;">Password Updated Successfully. Login Now</span>';
  unset($_SESSION['pass_changer_user_id']);
  unset($_SESSION['pass_changer_email']);
  echo '<script>window.location.href="index.php"</script>';
 }else{
  $_SESSION['mmsg'] = '<span style="color:red; font-weight:bold; font-size:20px;">New Password & Confirm Password Not Match!</span>';
  unset($_SESSION['pass_changer_user_id']);
  unset($_SESSION['pass_changer_email']);
  echo '<script>window.location.href="new_pass_setup.php"</script>';
 }

}

?>