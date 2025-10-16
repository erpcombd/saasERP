<?php
session_start();
require_once "../../../assets/support/inc.all.php";
$con= "";
if(isset($_REQUEST['customer']) && $_REQUEST['customer']!=""){
	if(strpos($_REQUEST['customer'], "::")==true){
	$new_item_id = explode("::", $_REQUEST['customer'])	;
	    $con=" and ( dealer_name_e like '%".$new_item_id[1]."%' or customer_id = '".$new_item_id[0]."'";
		}
	else{
	if(is_numeric($_REQUEST['customer']) && !is_string($_REQUEST['customer'])){
	$con=" and (customer_id like '".$_REQUEST['customer']."' or dealer_name_e like '%".$_REQUEST['customer']."%'";
		}
			}

}
$cus_sql = "select * from dealer_info where 1 ".$con;

$cus_query = mysql_query($cus_sql);

while($data = mysql_fetch_assoc($cus_query)){
     extract($data);
     $all_dealer[] = $customer_id."::".$dealer_name_e;
    
    }
echo json_encode($all_dealer);
?>