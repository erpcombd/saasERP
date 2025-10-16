<?php
//error_reporting(E_ALL);
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$entry_at=date('Y-m-d H:i:s');

$f_date = $_REQUEST['f_date'];
$t_date = $_REQUEST['t_date'];


$emp_code		    =$_SESSION['username'];
$master_dealer_code	=$_SESSION['warehouse_id'];

$shop_code      =$_REQUEST['shop_code'];
$offer_name     =$_REQUEST['offer_name'];

$sinfo          =findall("select * from ss_shop where dealer_code='".$shop_code."' ");
$shop_name      =$sinfo->shop_name;

$gift_name      = $_REQUEST['gift_name'];

if($gift_name!=''){

$sql = 'delete from ss_gift_delivery_list where offer_name= "'.$offer_name.'" and start_date="'.$f_date.'" and shop_code = "'.$shop_code.'" ';
mysqli_query($conn, $sql);


// insert new
$sql_in="insert ignore into ss_gift_delivery_list (offer_name, master_dealer_code, start_date, end_date, shop_code, shop_name, sales_amount, gift_name, entry_by, entry_at)
VALUES(
'".$offer_name."','".$master_dealer_code."','".$f_date."' ,'".$t_date."' ,'".$shop_code."' ,'".$shop_name."' ,'".$sales_amount."','".$gift_name."' ,'".$emp_code."' ,'".$entry_at."'     
)";
mysqli_query($conn, $sql_in);

}


echo 'Done';


?>