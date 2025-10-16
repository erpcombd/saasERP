<?

session_start();
require_once "../../../controllers/core/inc.login.php";

if(check_for_login('Robi','remonsarwar@gmail.com','V09VTUNOUU95RmxqR053eENoZG1vQT09',1)){
    ini_set('display_errors','1');
    ini_set('display_startup_errors','1');
    error_reporting(E_ALL);


require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once(SERVER_CORE.'mailer/phpmail_multiple_recipents.php');


//for last notification
$currentDateTime = date('Y-m-d H:i:s');

//event end notification
$sql_event_end_notfication_send = 'select * from  rfq_master where event_end_notfication_send="No" and eventEndAt<"'.$currentDateTime.'" and status="CHECKED"';

$qry_event_end_notfication_send = db_query($sql_event_end_notfication_send);
while($rfq_info=mysqli_fetch_object($qry_event_end_notfication_send)){
 $body='';
  $start_time = date('D, d M Y h:i a',strtotime($rfq_info->eventStartAt));
  $end_time = date('D, d M Y h:i a',strtotime($rfq_info->eventEndAt));
  $subject = 'Event Ended'.$rfq_info->rfq_version.' '.$rfq_info->rfx_stage.' for '.$rfq_info->event_name;
  $body .= '<p><strong>Dear Concerned:</strong></p><p><strong>The event time ended</strong></p>';
  $body .= '<br>';
  
  $body .= 'Event      : '.$rfq_info->event_name.'-'.$rfq_info->rfq_no;
  $body .= '<br>';
  $body .= 'Start Time : '.$start_time;
  $body .= '<br>';
  $body .= 'End Time   : '.$end_time;
  $body .= '<br>';
  $body .= '';
  $body .= '<br>';
  $body .= '<br>';         
  $body .= '<br>';
  $body .= '<br>';
  $body .= 'Thank You';
  $body .= '<br>';
  $body .= 'Robi eSourcing Platform';
  $body .= '<br>';
  $sql_vendor_email = 'select * from rfq_vendor_details where rfq_no ="'.$rfq_info->rfq_no.'"';
  $qry_vendor_email = db_query($sql_vendor_email);
  while($vendor_email_data=mysqli_fetch_object($qry_vendor_email)){

    mailer($vendor_email_data->email,$subject,$body);
  }
}



// mailer('fahimfoysal177@gmail.com','test cron job','hi i am test cron job');






}

?>
