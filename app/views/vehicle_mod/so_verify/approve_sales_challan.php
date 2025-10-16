<?php

session_start();

require_once "../../../assets/template/layout.top.php";



$do_no 		= $_REQUEST['do_no'];


$user=$_SESSION['user']['id'];
//echo $sql1="UPDATE sale_do_details SET status = 'CHECKED' WHERE do_no = '".$do_no."';";
//
//mysql_query($sql1);

$sql ="UPDATE sale_do_master SET status = 'VERIFIED_SO',acc_check='".$user."' WHERE do_no = '".$do_no."';";
mysql_query($sql);
echo $msg1 = "Sales order no ".$do_no." is now waiting for your approval. Please check!! \n \n From ERP System";
mail("coo@habibindustries.net","Upcomming SO For Approval",$msg1);
echo $msg2 = "Sales order no ".$do_no." is now waiting for your approval. Please check!! \n \n From ERP System";
mail("gm@habibindustries.net","Upcomming SO For Approval",$msg2);

header('location:approve_do.php?msg=Purchase Receive Successfully');

?>


