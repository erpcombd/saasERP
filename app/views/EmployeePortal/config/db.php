<?php

error_reporting(E_ALL);
ini_set('display_errors',1);
//define('SERVER_ENGINE','../../../../../../controller/clouderp/controller/');
//
//require_once SERVER_ENGINE."tools/mod.php"; 

if($_SESSION['dbName']==''){
$ser=explode(".cl",$_SERVER['HTTP_HOST']) ;
$cid=$ser[0];

//echo $name=find_a_field('user_activity_management','username','user_id="10001"');

@mysqli_connect('localhost', 'clouderp_userportal_apps', 'userportal_apps224424');
@mysqli_select_db('clouderp_cloudmvcdb');
$sql='select id from company_info where cid="'.$cid.'"';
$query=db_query($sql);
$row=mysqli_fetch_row($query);
if($row[0]!=''){
    
  $dsql='select db_name,db_user,db_pass from database_info where company_id='.$row[0].'';
 $dquery=db_query($dsql);
 $data=mysqli_fetch_object($dquery);
    $_SESSION['dbName']=$data->db_name;
    $_SESSION['dbuser']=$data->db_user;
    $_SESSION['dbPass']=$data->db_pass;
 
}else{
    
    die();
}
}
date_default_timezone_set('Asia/Dhaka');



//$conn = mysqli_connect("localhost","jahirgrouperp_erp_mobile_apps","jahir224424","jahirgrouperp_masterbd");



$conn = mysqli_connect("localhost", $_SESSION['dbuser'], $_SESSION['dbPass'], $_SESSION['dbName']);



// Check connection

if (mysqli_connect_errno()) {

  echo "Failed to connect to MySQL: " . mysqli_connect_error();

  exit();
}
