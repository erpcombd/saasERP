<?php

session_start();

//



//error_reporting(E_ALL);

//ini_set('display_errors', '1');



//require_once "../../config/inc.all.php";



//$mysqli = new mysqli("localhost","user","password","database");



$mysqli = new mysqli("localhost","cloudhrm_Erp_att_users","att_user","cloudhrm_master_hrm");



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

 

 //$EMP_CODE = find_a_field('personnel_basic_info','PBI_ID','MACHINE_ID="'.$_REQUEST['EMP_CODE'].'"');

 $EMP_CODE = $_REQUEST['EMP_CODE'];



 

 if($ztime!=''){

     $sql = 'INSERT INTO hrm_attdump(bizid,xenrollid,xlocationid,xmechineid,xdate,xtime,time,EMP_CODE) VALUES

	

	 ( "'.$bizid.'", "'.$EMP_CODE.'", "'.$xlocationid.'",  "'.$xmechineid.'", "'.$xdate.'", "'.$xtime.'", "'.$time.'",  "'.$EMP_CODE.'" )';

	

    $result = $mysqli->query($sql); 

    echo 'successfully inserted  :'.$bizid.' : '.$ztime;

    

 }

?>