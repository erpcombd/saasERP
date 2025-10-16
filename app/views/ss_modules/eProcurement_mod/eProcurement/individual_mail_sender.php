<?php   

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

require_once(SERVER_CORE.'mailer/phpmail.php');

$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

$vendor_email = $data['vendor_email'];


?>

<?
$rfq = find_all_field('rfq_master','','rfq_no="'.$_SESSION['rfq_no'].'"');

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

/*$master_up = 'update rfq_master set status="CHECKED",eventStartTime="'.$_POST['eventStartTime'].'",eventStartDate="'.$_POST['eventStartDate'].'",eventStartAt="'.$_POST['eventStartAt'].'" where rfq_no="'.$_SESSION['rfq_no'].'"';
db_query($master_up);*/

$type=1;
$up = 'update rfq_vendor_details set status="INVITED", reject_status="No" where rfq_no="'.$_SESSION['rfq_no'].'" and email like "'.$vendor_email.'" ';
db_query($up);


$start_time = date('D, d M Y h:i a',strtotime($_POST['eventStartAt']));
$end_time = date('D, d M Y h:i a',strtotime($eventEndAt));


$subject = '#'.$rfq->rfq_version.' '.$rfq->rfx_stage.' for '.$rfq->event_name;
$str = $_POST['data'];
$data=explode('##',$str);
$sql = 'select v.vendor_name,v.email,v.cc_email,v.vendor_id from vendor v, rfq_vendor_details r where  r.vendor_id=v.vendor_id and r.rfq_no="'.$_SESSION['rfq_no'].'"';
$qry = db_query($sql);
// while($data=mysqli_fetch_object($qry)){
$pass_info = find_all_field('vendor','','email="'.$vendor_email.'"');
$body .= $rfq->mail_template;
$body .= '<br>';

$body .= 'Event      : '.$rfq->event_name;
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


mailer($vendor_email,$subject,$body);
if($pass_info->cc_email!=''){
  mailer($pass_info->cc_email,$subject,$body);
  }
// mailer('fahimfoysal177@gmail.com',$subject,$body);

// $body = '';
// }

            //    $rfq = find_all_field('rfq_master','','rfq_no="'.$_SESSION['rfq_no'].'"');
            //    $body = $rfq->mail_template;
            //    $subject = 'Request for Quotation';
            //    echo '<script>alert('dfdfdf')';
             
               //mailer($vendor_email,$subject,$body);
               


                 $response = array('success' => true, 'msg' => 'Email Sent Successfully');
                 echo json_encode($response);
            

?>