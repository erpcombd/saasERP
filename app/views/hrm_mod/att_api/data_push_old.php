<?php

session_start();

//



//error_reporting(E_ALL);

//ini_set('display_errors', '1');



//require_once "../../config/inc.all.php";



//$mysqli = new mysqli("localhost","user","password","database");



$mysqli = new mysqli("localhost","mahirgrouperp_att_users","mahirgrouperp224424","mahirgrouperp_dev_main");



if ($mysqli -> connect_errno) {

  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;

  exit();

}


 $_REQUEST['EMP_CODE'] = $_REQUEST['machin_id'];
 
 $ztime = $_REQUEST['ztime'] = $_REQUEST['date'];

 $bizid = $_REQUEST['bizid'] = $_REQUEST['machin_id'];

 $xaction =$_REQUEST['xaction'];

 $xlocationid = $_REQUEST['xlocationid'];

 

 $xmechineid = $_REQUEST['xmechineid'] = $_REQUEST['id'];

 $xdate = $_REQUEST['xdate'];

 $xtime =$_REQUEST['xtime'];

 $time = $_REQUEST['time'];

 

 //$EMP_CODE = $_REQUEST['EMP_CODE'];

 //$_REQUEST['EMP_CODE'] = 12;


 
 $sql2 = "SELECT PBI_ID  FROM personnel_basic_info WHERE MACHINE_ID='".$_REQUEST['EMP_CODE']."'";
$result2 = $mysqli->query($sql2); 

while($row = mysqli_fetch_object($result2)) {
     $EMP_CODE = $row->PBI_ID;
  }
  

 

 if($ztime!=''){

     $sql = 'INSERT INTO hrm_attdump(bizid,xenrollid,xlocationid,xmechineid,xdate,xtime,time,EMP_CODE) VALUES

	

	 ( "'.$bizid.'", "'.$EMP_CODE.'", "'.$xlocationid.'",  "'.$xmechineid.'", "'.$xdate.'", "'.$xtime.'", "'.$time.'",  "'.$EMP_CODE.'" )';

	

    $result = $mysqli->query($sql); 

    echo 'successfully inserted  :'.$bizid.' : '.$ztime;

    

 }

?>