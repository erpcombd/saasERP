<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once(SERVER_CORE.'mailer/phpmail.php');

$table_master = 'notification_send_information';
$first_notification_time = find_a_field('notification_setup_information','notification_start_date','rfq_no="'.$_SESSION['rfq_no'].'"');
$currentDateTime = new DateTime();
$currentTimestamp = $currentDateTime->getTimestamp();

$rfq = find_all_field('rfq_master','','rfq_no="'.$_SESSION['rfq_no'].'"');

//insert into notification table
if($rfq->notification_status=='Yes'){
$_POST['rfq_no']= $_SESSION['rfq_no'];
$_POST['event_start_date'] =$rfq->eventStartDate;
$_POST['event_start_time'] =$rfq->eventStartTime;
$_POST['event_end_date'] =$rfq->eventEndDate;
$_POST['event_end_time'] =$rfq->eventEndTime;
$_POST['eventStartAt'] =$rfq->eventStartDate.' '.$rfq->eventStartTime;

$eventStartAt_timestamp = strtotime($_POST['eventStartAt']);
// $next_notification_timestamp = $currentTimestamp + ($each_notification_interval * 3600);
$next_notification_timestamp = strtotime($first_notification_time);

$next_notification_time_date = date('Y-m-d H:i:s', $next_notification_timestamp);
$next_notification_date = date('Y-m-d', $next_notification_timestamp);
$next_notification_time = date('H:i:s', $next_notification_timestamp);


$_POST['next_notification_date_time'] =$next_notification_time_date;
$_POST['next_notfication_time'] =$next_notification_time;
$_POST['next_notification_date'] =$next_notification_date;


$crud_notification   = new Crud($table_master);

$crud_notification->insert();
}

 $_POST['eventEndAt'] =$rfq->eventEndDate.' '.$rfq->eventEndTime;
 $_POST['eventStartAt'] =$rfq->eventStartDate.' '.$rfq->eventStartTime;
 $_POST['status'] = 'CHECKED';
 if($rfq->immediate_event_shoot=='checked'){
 $_POST['eventStartTime'] = date('H:i');
 $_POST['eventStartDate'] = date('Y-m-d');
 $_POST['eventStartAt'] = date('Y-m-d H:i');
 }else{
 $_POST['eventStartTime'] = $rfq->eventStartTime;
 $_POST['eventStartDate'] = $rfq->eventStartDate;
 $_POST['eventStartAt'] = $rfq->eventStartAt;
 }
 
 $eventEndAt = $rfq->eventEndDate.' '.$rfq->eventEndTime;
 
 $master_up = 'update rfq_master set status="CHECKED",eventStartTime="'.$_POST['eventStartTime'].'",eventStartDate="'.$_POST['eventStartDate'].'",eventStartAt="'.$_POST['eventStartAt'].'" where rfq_no="'.$_SESSION['rfq_no'].'"';
 db_query($master_up);
 
 $type=1;
 $up = 'update rfq_vendor_details set status="INVITED",reject_status="No" where rfq_no="'.$_SESSION['rfq_no'].'"';
 db_query($up);

 $up_details = 'update rfq_item_details set visibility_start="'.$rfq->eventStartAt.'",visibility_end="'.$eventEndAt.'" where rfq_no="'.$_SESSION['rfq_no'].'"';
 db_query($up_details);



$start_time = date('D, d M Y h:i a',strtotime($_POST['eventStartAt']));
$end_time = date('D, d M Y h:i a',strtotime($eventEndAt));

$subject = '#'.$rfq->rfq_version.' '.$rfq->rfx_stage.' for '.$rfq->event_name;
$str = $_POST['data'];
$data=explode('##',$str);
$sql = 'select v.vendor_name,v.email,v.cc_email,v.vendor_id from vendor v, rfq_vendor_details r where  r.vendor_id=v.vendor_id and r.rfq_no="'.$_SESSION['rfq_no'].'"';
$qry = db_query($sql);
while($data=mysqli_fetch_object($qry)){

$pass_info = find_all_field('vendor','','vendor_id="'.$data->vendor_id.'"');
$body .= $rfq->mail_template;
$body .= '<br>';

$body .= 'Event      : '.$rfq->event_name.'-'.$_SESSION['rfq_no'];
$body .= '<br>';
$body .= 'Start Time : '.$start_time;
$body .= '<br>';
$body .= 'End Time   : '.$end_time;
$body .= '<br>';
$body .= '<a href="https://esourcing.robi.com.bd/esourcing/app/views/auth/vendor/" target="_blank" rel="noopener">View Event</a>';
$body .= '<br>';
$body .= '<br>';

if($pass_info->pass_change=='NO'){
$body .= 'User Name : '.$pass_info->email;
$body .= '<br>';
$body .= 'Password : '.$pass_info->email.'_1';
}

$body .= '<br>';
$body .= '<br>';
$body .= 'Thank You';
$body .= '<br>';
$body .= 'Robi eSourcing Platform';
$body .= '<br>';
if($data->email!=''){

mailer($data->email,$subject,$body);
}
if($pass_info->cc_email!=''){
    mailer($pass_info->cc_email,$subject,$body);
    }


// alternative email send  if exisit
// $sql_alternative = 'SELECT * FROM `rfq_alternative_mail` WHERE vendor_id="'.$data->vendor_id.'"';
// $qry_alternative = db_query($sql_alternative);
// while($data2=mysqli_fetch_object($qry_alternative)){
//     $pass_info = find_all_field('vendor','','vendor_id="'.$data->vendor_id.'"');
//     $body .= $rfq->mail_template;
//     $body .= '<br>';
    
//     $body .= 'Event      : '.$rfq->event_name.'-'.$_SESSION['rfq_no'];
//     $body .= '<br>';
//     $body .= 'Start Time : '.$start_time;
//     $body .= '<br>';
//     $body .= 'End Time   : '.$end_time;
//     $body .= '<br>';
//     $body .= '<a href="https://esourcing.robi.com.bd/esourcing/app/views/auth/vendor/" target="_blank" rel="noopener">View Event</a>';
//     $body .= '<br>';
//     $body .= '<br>';
    
//     if($pass_info->pass_change=='NO'){
//     $body .= 'User Name : '.$pass_info->email;
//     $body .= '<br>';
//     $body .= 'Password : '.$pass_info->email.'_1';
//     }
    
//     $body .= '<br>';
//     $body .= '<br>';
//     $body .= 'Thank You';
//     $body .= '<br>';
//     $body .= 'Robi eSourcing Platform';
//     $body .= '<br>';
//     if($data2->email!=''){
    
//     mailer($data2->email,$subject,$body);
//     }
    
// }
//end  alternative email send  if exisit









$body = '';
}
$all['msg'] = 'Mail Sending..';
$_SESSION['msg'] = '<span style="color:green; font-size:20px;">Event Floated Successfully</span>';
echo json_encode($all);

///////////
$now = date('Y-m-d H:i:s');
$_POST['rfq_no'] = $_SESSION['rfq_no'];
$_POST['field_name'] = 'Submit Event';
$_POST['field_value'] = 'Event started';
$_POST['entry_at'] = $now;
$_POST['entry_by'] = $_SESSION['user']['id'];


$Crud   = new Crud('rfq_logs');
$Crud->insert();
/////////////
?>