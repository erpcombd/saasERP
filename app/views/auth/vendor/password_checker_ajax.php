<?

session_start();


$pass = $_POST['new_password'];
$cpass = $_POST['confirm_password'];
$info['msg'] = $pass;
echo json_encode($info);
?>