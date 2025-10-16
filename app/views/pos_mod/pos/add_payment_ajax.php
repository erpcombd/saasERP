<?php
session_start();
require_once "../../../assets/support/inc.all.php";
$pos_id = $_REQUEST['pos_id'];
$total_item = $_REQUEST['total_item'];
$due_amt = $_REQUEST['due_amt'];
$total_amt = $_REQUEST['total_amt'];
$paid_amt = $_REQUEST['paid_amt'];
$left_amt = $_REQUEST['left_amt'];
$payment_method = $_REQUEST['payment_method'];
$status = "UNPAID";
$id = $_REQUEST['id'];
$created_by = $_SESSION['user']['id'];
$req_type = $_REQUEST['req_type'];
if($req_type=="insert"){
if($pos_id>0){
$isql = "INSERT INTO `pos_payment`(`pos_id`, `total_item`, `total_amt`, `paid_amt`, `left_amt`, `payment_method`, `status`,`created_by`) VALUES ('$pos_id', '$total_item', '$total_amt', '$paid_amt', '$left_amt', '$payment_method', '$status', '$created_by')";
$verify = mysql_query($isql);
if($verify==true){
echo json_encode("ok");
}
}	
}
if($req_type=="delete"){
$dsql = "delete from pos_payment where id = '$id'";
$verify = mysql_query($dsql);
if($verify){
echo json_encode("ok")	;
	}
}
if($req_type=="select"){
$ssql= "select * from pos_payment where pos_id = '$pos_id'";
$squery = mysql_query($ssql);
$o = 0;
$count = mysql_num_rows($squery);
if($count>0){
while($data = mysql_fetch_assoc($squery)){
extract($data);
$datas[$o]['id'] = $id;
$datas[$o]['pos_id'] = $pos_id; 
$datas[$o]['total_item'] = $total_item;
$datas[$o]['total_amt'] = $total_amt;
$datas[$o]['paid_amt'] = $paid_amt;
$datas[$o]['left_amt'] = $left_amt;
$datas[$o]['payment_method'] = find_a_field('accounts_ledger','ledger_name','ledger_id="'.$payment_method.'"');
$o++;
}	
}else{
$datas[0]['result'] = "remove";
	}

echo json_encode($datas);
}
?>