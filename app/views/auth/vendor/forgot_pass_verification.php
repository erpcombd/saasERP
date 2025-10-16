<?php
session_start();

include_once('../../../controllers/mailer/phpmail.php');
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_AUTH."db_con_live_static.php";


if(isset($_POST['ibssignin']))
{



$email = $_POST['user_email'];

$sqlc = 'select count(id) as total_id from otp_block where email="'.$email.'" and expire>"'.date('Y-m-d H:i:s').'"';
$lockQry = $conn->query($sqlc);
$block = $lockQry->fetch_assoc();
if($block['total_id']>0){
$_SESSION['mmsg'] = '<span style="color:red; font-weight:bold; font-size:20px;">You Are Blocked For 15 Minutes!</span>';
echo '<script>window.location.href="forgot_pass.php"</script>';

}else{

$sql = 'select vendor_id from vendor where email="'.$email.'"';
$check = $conn->query($sql);
$check_mail = $check->fetch_assoc();
if($check_mail['vendor_id']>0){
$otp = rand(100000,90000000);
$newTime = date('Y-m-d H:i:s', strtotime('+5 minutes'));
$insert = $conn->query('insert into `forgot_pass_email_otp` (`otp`,`email`,`status`,`user_id`,`expire_date`,`entry_at`) value("'.$otp.'","'.$email.'","PENDING","'.$check_mail['vendor_id'].'","'.$newTime.'","'.date('Y-m-d H:i:s').'")');

$subject = "Password Reset Verification";
$body = '<html><body><p><br> <span style="font-size:18px; font-weight:bold;">OTP : '.$otp.'</span></p></body></html>';
mailer($email,$subject,$body);
$_SESSION['mmsg'] = '<span style="color:green; font-weight:bold; font-size:20px;">Success! Enter OTP</span>';
$_SESSION['pass_changer_email'] = $email;
$_SESSION['pass_changer_user_id'] = $check_mail['vendor_id'];
echo '<script>window.location.href="forgot_pass_step_2.php"</script>';

}else{
$_SESSION['mmsg'] = '<span style="color:red; font-weight:bold; font-size:20px;">Invalid Email Address</span>';
header('location:forgot_pass.php');
}
}
}


?>