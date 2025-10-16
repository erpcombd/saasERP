<?php
session_start();
$host	='localhost';
date_default_timezone_set('Asia/Dhaka');
$user 	= 'root';
$pass 	= '';
$db 	= 'db_sajeeb';

$link 	= mysqli_connect($host, $user, $pass);
mysqli_select_db($db);
if (!$link) die('Could not connect: ' . mysqli_error());
$sql = 'select * from item_info where item_brand="Tang"';
$query = db_query($sql);
echo $count = mysqli_num_rows($query);
while($data=mysqli_fetch_object($query)){
echo $data->item_name;
echo $add_discount = ($data->m_price/100)*4;

$update1 = 'update sales_corporate_price set `set`=1,set_price = (set_price-'.$add_discount.'),discount = (discount+'.$add_discount.') where `set`<1 and dealer_code not in (1067,1066,1057,1056,1055,1054,1053,1052,1051,1050,1049,1048,1006,1002) and set_price>0 and item_id="'.$data->item_id.'" ';

	db_query($update1); 
	echo '<br>';
	}

	
?>