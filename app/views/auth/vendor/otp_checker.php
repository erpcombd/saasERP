<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('../../../controllers/mailer/phpmail.php');
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_AUTH."db_con_live_static.php";


if(isset($_POST['ibssignin']))
{

$otp = $_POST['new_otp'];

$sqlc = 'select count(id) as total_id from otp_block where email="'.$_SESSION['pass_changer_email'].'" and expire>"'.date('Y-m-d H:i:s').'"';
$lockQry = $conn->query($sqlc);
$block = $lockQry->fetch_assoc();
if($block['total_id']>0){
$_SESSION['mmsg'] = '<span style="color:red; font-weight:bold; font-size:20px;">You Are Blocked For 15 Minutes!</span>';
echo '<script>window.location.href="index.php"</script>';

}else{

$sql = 'select otp,user_id,email from forgot_pass_email_otp where otp="'.$otp.'" and status="PENDING" and email="'.$_SESSION['pass_changer_email'].'" 
and expire_date>"'.date('Y-m-d H:i:s').'"';
$check = $conn->query($sql);


$check_mail = $check->fetch_assoc();
if($check_mail['otp']==$otp){
 
 if($check_mail['user_id']>0){
 $Upsql = 'update forgot_pass_email_otp set status="VERIFIED" where otp="'.$check_mail['otp'].'" and user_id="'.$check_mail['user_id'].'" and email="'.$check_mail['email'].'"';
 $update = $conn->query($Upsql);
 
 $key = 'ROBI'; // 256-bit key for AES-256
 $iv = '1234567890123456'; // 16 char
 $new_plain_pass = $_SESSION['pass_changer_email'].'_2';
 $encode_pass = urlencode(base64_encode(openssl_encrypt($_SESSION['pass_changer_email'].'_2', 'aes-256-cbc', $key, 0, $iv)));
 
 $sql = 'update vendor set password="'.$encode_pass.'",pass_change="NO" where vendor_id="'.$_SESSION['pass_changer_user_id'].'" 
 and email="'.$_SESSION['pass_changer_email'].'"';
 $update = $conn->query($sql);
 
 //mail
$subject = "Temporary Credential";
$body = '<html><body><p><br> <span style="font-size:18px; font-weight:bold;">Password : '.$new_plain_pass.'</span></p></body></html>';
mailer($_SESSION['pass_changer_email'],$subject,$body);
//mail

  unset($_SESSION['pass_changer_user_id']);
  unset($_SESSION['pass_changer_email']);
 $_SESSION['mmsg'] = '<span style="color:green; font-weight:bold; font-size:20px;">Temporary Password Sent To Your Email. Login With This</span>';
 echo '<script>window.location.href="index.php"</script>';
 }
 
 
}else{

$invalid_sql = 'insert into invalid_opt_try set otp="'.$otp.'",session_id="'.session_id().'",email="'.$_SESSION['pass_changer_email'].'"';
$conn->query($invalid_sql);

$sqlc = 'select count(id) as total_id from invalid_opt_try where session_id="'.session_id().'"';
$lockQry = $conn->query($sqlc);
$block = $lockQry->fetch_assoc();
if($block['total_id']>2){
$newTime = date('Y-m-d H:i:s', strtotime('+15 minutes'));

$invalid_sql2 = 'insert into otp_block set expire="'.$newTime.'",session_id="'.session_id().'",email="'.$_SESSION['pass_changer_email'].'"';
$conn->query($invalid_sql2);
}

$_SESSION['mmsg'] = '<span style="color:red; font-weight:bold; font-size:20px;">Invalid OTP</span>';
echo '<script>window.location.href="forgot_pass_step_2.php"</script>';
}
}
}


?>