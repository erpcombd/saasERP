<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once(SERVER_CORE.'mailer/phpmail.php');


$rfq = find_all_field('rfq_master','','rfq_no="'.$_SESSION['rfq_no'].'"');
$end_time = date('D, d M Y h:i a');

$subject = 'Request for Quotation';
$str = $_POST['data'];
$data=explode('##',$str);
$sql = 'select v.vendor_name,v.email,v.vendor_id from vendor v, rfq_vendor_details r where  r.vendor_id=v.vendor_id and r.rfq_no="'.$_SESSION['rfq_no'].'"';
$qry = db_query($sql);
while($data=mysqli_fetch_object($qry)){
$pass_info = find_all_field('user_activity_management','','vendor_code="'.$data->vendor_id.'"');
$body .= ' Dear Concern,';
$body .= '<br>';

$body .= '<strong>'.$data->vendor_name.'</strong> has been invited by <strong>Axiata Group of Companies</strong> to participate in a sourcing event for <strong>'.$rfq->event_name.'</strong>';
$body .= '<br>';
$body .= '<br>';

$body .= 'Participation and submission is easy and all done within the system. Response may require forms, attachments, price quotes, and/or descriptions of products or services. If you have responded to the event, please ignore this message.';
$body .= '<br>';
$body .= '<br>';

$body .= 'Responses are due by '.$end_time;
$body .= '<br>';
$body .= '<a href="https://www.clouderp.com.bd/eProcurement/login/pages/vendor_login/index.php" target="_blank" rel="noopener">View Event</a>';
$body .= '<br>';
$body .= '<br>';

if($pass_info->pass_change=='NO'){
$body .= 'User Name : '.$pass_info->username;
$body .= '<br>';
$body .= 'Password : '.$pass_info->username;
}

$body .= '<br>';
$body .= '<br>';
if($data->email!=''){

mailer($data->email,$subject,$body);
}
$body = '';
}
echo 'Mail Sent';
?>