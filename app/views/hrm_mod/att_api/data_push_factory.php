<?php

session_start();

//


$mysqli = new mysqli("localhost","mahirgrouperp_att_users","mahirgrouperp224424","mahirgrouperp_dev_main");

if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}


 $ztime = $_REQUEST['ztime'];

 $bizid = $_REQUEST['bizid'];

 $xaction =$_REQUEST['xaction'];

 $xlocationid = $_REQUEST['xlocationid'];

 

 $xmechineid = $_REQUEST['xmechineid'];

 $xdate = $_REQUEST['xdate'];

 $xtime =$_REQUEST['xtime'];

 $time = $_REQUEST['time'];

 $machine_id = $_REQUEST['EMP_CODE'];

 
$sql2 = "SELECT PBI_ID  FROM personnel_basic_info WHERE MACHINE_ID='".$_REQUEST['EMP_CODE']."'";
$result2 = $mysqli->query($sql2); 

while($row = mysqli_fetch_object($result2)) {
     $EMP_CODE = $row->PBI_ID;
  }
  

 

 if($ztime!=''){

     $sql = 'INSERT INTO hrm_attdump(bizid,xenrollid,xlocationid,xmechineid,xdate,xtime,time,EMP_CODE) VALUES

	

	 ( "'.$bizid.'", "'.$machine_id.'", "'.$xlocationid.'",  "'.$xmechineid.'", "'.$xdate.'", "'.$xtime.'", "'.$time.'",  "'.$EMP_CODE.'" )';

	

    $result = $mysqli->query($sql); 

    echo 'successfully inserted  :'.$bizid.' : '.$ztime;

    

 }

?>