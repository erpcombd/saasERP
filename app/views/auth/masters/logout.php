<?php
session_start();

if($_SESSION['cid_log']== 1){

unset($_SESSION["uid"]);
unset($_SESSION["pass"]);

$domain = explode('.', $_SERVER['HTTP_HOST'])[1];
setcookie('clouderp','',time()- (10 * 365 * 24 * 60 * 60));

session_destroy();
header("Location:../../../views/auth/masters/index.php");
}
elseif($_SESSION['cid_log']== 2){

unset($_SESSION["uid"]);
unset($_SESSION["pass"]);

$domain = explode('.', $_SERVER['HTTP_HOST'])[1];
setcookie('clouderp','',time()- (10 * 365 * 24 * 60 * 60));

session_destroy();
header("Location:../../../views/auth/masters/index_robi.php");
}
elseif($_SESSION['cid_log']== 3){

unset($_SESSION["uid"]);
unset($_SESSION["pass"]);

$domain = explode('.', $_SERVER['HTTP_HOST'])[1];
setcookie('clouderp','',time()- (10 * 365 * 24 * 60 * 60));


session_destroy();
header("Location:../../../views/auth/masters/index_aamra.php");
}
elseif($_SESSION['cid_log']== 4){
unset($_SESSION["uid"]);
unset($_SESSION["pass"]);


$domain = explode('.', $_SERVER['HTTP_HOST'])[1];
setcookie('clouderp','',time()- (10 * 365 * 24 * 60 * 60));

session_destroy();
header("Location:../../../views/auth/masters/index_banglalink.php");
}
elseif($_SESSION['cid_log']== 5){

unset($_SESSION["uid"]);
unset($_SESSION["pass"]);


$domain = explode('.', $_SERVER['HTTP_HOST'])[1];
setcookie('clouderp','',time()- (10 * 365 * 24 * 60 * 60));

session_destroy();
header("Location:../../../views/auth/masters/index_demo.php");
}

else{
unset($_SESSION["uid"]);
unset($_SESSION["pass"]);


$domain = explode('.', $_SERVER['HTTP_HOST'])[1];
setcookie('clouderp','',time()- (10 * 365 * 24 * 60 * 60));


session_destroy();
header("Location:../../../views/auth/masters/index.php");
}


?>