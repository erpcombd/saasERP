<?
session_start();
require_once "../../../controllers/core/inc.login.php";

if(check_for_login('Robi','remonsarwar@gmail.com','V09VTUNOUU95RmxqR053eENoZG1vQT09',1)){




require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once(SERVER_CORE.'mailer/phpmail_multiple_recipents.php');




$currentDateTime = date('Y-m-d H:i:s');
$sql = 'select n.* from notification_send_information n,rfq_master r where n.rfq_no=r.rfq_no and n.send_status="No" and r.status="CHECKED" and r.eventEndAt>"'.$currentDateTime.'"';

$qry = db_query($sql);
while($notification_data=mysqli_fetch_object($qry)){
  $body = '';
    $rfq_info = find_all_field('rfq_master','','rfq_no="'.$notification_data->rfq_no.'"');
    $notification_setup_info = find_all_field('notification_setup_information','','rfq_no="'.$notification_data->rfq_no.'"');

    $currentDateTime = new DateTime();
    $currentTimestamp = $currentDateTime->getTimestamp();


    // Calculate the time range (-35 minutes and +35 minutes)
    $startRange = clone $currentDateTime;
    $startRange->modify('-35 minutes');
    
    $endRange = clone $currentDateTime;
    $endRange->modify('+35 minutes');

    // Convert next_notification_date_time to DateTime object
    $nextNotificationDateTime = new DateTime($notification_data->next_notification_date_time);
    $notification_start_date = new DateTime($notification_setup_info->notification_start_date);

    // Check if next_notification_date_time is within the time range
    // if ($nextNotificationDateTime >= $startRange && $nextNotificationDateTime <= $endRange) {
    //    echo "<script>alert('Yes I am in the range')</script>";
    // }
    if( $currentDateTime>=$notification_start_date){
    if ($nextNotificationDateTime >= $startRange && $nextNotificationDateTime <= $endRange) {
        if($rfq_info->status=='CHECKED' && $rfq_info->notification_status=='Yes'){
          $start_time = date('D, d M Y h:i a',strtotime($rfq_info->eventStartAt));
          $end_time = date('D, d M Y h:i a',strtotime($rfq_info->eventEndAt));
          $to='';
          $subject = 'Reminder'.$rfq_info->rfq_version.' '.$rfq_info->rfx_stage.' for '.$rfq_info->event_name;
      
          $body .= '<p><strong>Dear Concerned:</strong></p><p><strong>Please respond the RFQ on time, maintain all compliance.</strong></p>';
          $body .= '<br>';
          
          $body .= 'Event      : '.$rfq_info->event_name.'-'.$rfq_info->rfq_no;
          $body .= '<br>';
          $body .= 'Start Time : '.$start_time;
          $body .= '<br>';
          $body .= 'End Time   : '.$end_time;
          $body .= '<br>';
          $body .= '<a href="https://esourcing.robi.com.bd/esourcing/app/views/auth/vendor/" target="_blank" rel="noopener">View Event</a>';
          $body .= '<br>';
          $body .= '<br>';         
          $body .= '<br>';
          $body .= '<br>';
          $body .= 'Thank You';
          $body .= '<br>';
          $body .= 'Robi eSourcing Platform';
          $body .= '<br>';



            $sql_rfq_team = 'select a.id,u.email,u.fname,a.action,a.is_master,m.event_name,m.master_rfq_no,m.rfq_version from rfq_evaluation_team a, user_activity_management u,rfq_master m where a.user_id=u.user_id and a.rfq_no="'.$rfq_info->rfq_no.'" and a.rfq_no=m.rfq_no';
            $qry_rfq_team = db_query($sql_rfq_team);
            $teamsinfo = [];
            while ($rfq_team_each_member = mysqli_fetch_object($qry_rfq_team)) {
          
              $teamsinfo[] = $rfq_team_each_member; 
          }
        

          $sql_vendor_email = 'select * from rfq_vendor_details where rfq_no ="'.$rfq_info->rfq_no.'"';
          $qry_vendor_email = db_query($sql_vendor_email);
          while($vendor_email_data=mysqli_fetch_object($qry_vendor_email)){
            if($rfq_info->notify_buyer == 'Yes'){
            //  echo '<script>alert("buyer get notified")</script>';
              mailerwithCCReminder($vendor_email_data->email,$teamsinfo,$subject,$body);
            }else{
              // echo '<script>alert("buyer not get notified")</script>';
              mailer($vendor_email_data->email,$subject,$body);
            }
            

          }


          
        $up = 'update notification_send_information set send_status="Yes" where id="'.$notification_data->id.'"';
        db_query($up);


         //Next notification time add
        $rfq = find_all_field('rfq_master','','rfq_no="'.$rfq_info->rfq_no.'"');

        //insert into notification table
        $_POST['rfq_no']= $rfq_info->rfq_no;
        $_POST['event_start_date'] =$rfq->eventStartDate;
        $_POST['event_start_time'] =$rfq->eventStartTime;
        $_POST['event_end_date'] =$rfq->eventEndDate;
        $_POST['event_end_time'] =$rfq->eventEndTime;
        $_POST['eventStartAt'] =$rfq->eventStartDate.' '.$rfq->eventStartTime;
        
        $eventStartAt_timestamp = strtotime($_POST['eventStartAt']);
       
        $next_notification_timestamp =  $currentTimestamp + ($notification_setup_info->each_notification_interval * 3600);
        $next_notification_time_date = date('Y-m-d H:i:s', $next_notification_timestamp);
        $next_notification_date = date('Y-m-d', $next_notification_timestamp);
        $next_notification_time = date('H:i:s', $next_notification_timestamp);
        
        
        $_POST['next_notification_date_time'] =$next_notification_time_date;
        $_POST['next_notfication_time'] =$next_notification_time;
        $_POST['next_notification_date'] =$next_notification_date;
        
        
        $crud_notification   = new Crud('notification_send_information');
        
        $crud_notification->insert();   
        //nezt notification time add ends

        // echo $notification_setup_info->last_notfication_hour;
        // echo "br";
        // echo $rfq_info->rfqeventEndAt;
        // $interval = new DateInterval('PT' . $notification_setup_info->last_notfication_hour . 'H');
        // $lastNotificationHour = (new DateTime())->add($interval);

        // // Check if last notification time is after event end
        // if ($lastNotificationHour > new DateTime($rfq_info->eventEndAt) && $rfq_info->last_notification_send=='No') {
        //   mailer($rfq_info->rfq_no,$subject,$body);
        //   $up_2 = 'update rfq_master set last_notification_send="Yes" where rfq_no="'.$rfq_info->rfq_no.'"';
        //   db_query($up_2);
          
        // }

        // echo $lastNotificationHour = strtotime('+' . $notification_setup_info->last_notfication_hour . ' hours', $currentTimestamp);

        // // Check if last notification time is after event end
        // if ($lastNotificationHour >= strtotime($rfq_info->rfqeventEndAt)) {
        //   // Perform action for exceeding last notification time
        //   // (e.g., send a different notification or mark complete)
        //   echo "Last notification time exceeded for RFQ: " . $rfq_info->rfq_no;
        // }

  
      }
    }
  }

}

//for last notification
 $currentDateTime = date('Y-m-d H:i:s');
$sql_last_notification = 'select * from  rfq_master where notification_status="Yes" and last_notification_send="No" and eventEndAt>"'.$currentDateTime.'" and status="CHECKED"';

$qry_last_notification = db_query($sql_last_notification);
while($rfq_info=mysqli_fetch_object($qry_last_notification)){
  $start_time = date('D, d M Y h:i a',strtotime($rfq_info->eventStartAt));
  $end_time = date('D, d M Y h:i a',strtotime($rfq_info->eventEndAt));
  $subject = 'Reminder'.$rfq_info->rfq_version.' '.$rfq_info->rfx_stage.' for '.$rfq_info->event_name;
  $body .= '<p><strong>Dear Concerned:</strong></p><p><strong>Please respond the RFQ on time, maintain all compliance.</strong></p>';
  $body .= '<br>';
  
  $body .= 'Event      : '.$rfq_info->event_name.'-'.$rfq_info->rfq_no;
  $body .= '<br>';
  $body .= 'Start Time : '.$start_time;
  $body .= '<br>';
  $body .= 'End Time   : '.$end_time;
  $body .= '<br>';
  $body .= '<a href="https://esourcing.robi.com.bd/esourcing/app/views/auth/vendor/" target="_blank" rel="noopener">View Event</a>';
  $body .= '<br>';
  $body .= '<br>';         
  $body .= '<br>';
  $body .= '<br>';
  $body .= 'Thank You';
  $body .= '<br>';
  $body .= 'Robi eSourcing Platform';
  $body .= '<br>';










  $notification_setup_info = find_all_field('notification_setup_information','','rfq_no="'.$rfq_info->rfq_no.'"');
  if( $notification_setup_info->notification_setup_id>0){


  

  $interval = new DateInterval('PT' . $notification_setup_info->last_notfication_hour . 'H');
  $lastNotificationHour = (new DateTime())->add($interval);

  // Check if last notification time is after event end
  if ($lastNotificationHour >= new DateTime($rfq_info->eventEndAt) && $rfq_info->last_notification_send=='No') {
   $sql_vendor_email = 'select * from rfq_vendor_details where rfq_no ="'.$rfq_info->rfq_no.'"';
    $qry_vendor_email = db_query($sql_vendor_email);
    while($vendor_email_data=mysqli_fetch_object($qry_vendor_email)){
      mailer($vendor_email_data->email,$subject,$body);

    }
    $up_2 = 'update rfq_master set last_notification_send="Yes" where rfq_no="'.$rfq_info->rfq_no.'"';
    db_query($up_2);
    
  }
  
}
$body = '';
}

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
    $up_2 = 'update rfq_master set event_end_notfication_send="Yes" where rfq_no="'.$rfq_info->rfq_no.'"';
    db_query($up_2);
  }
}

//event end notification

}

?>
