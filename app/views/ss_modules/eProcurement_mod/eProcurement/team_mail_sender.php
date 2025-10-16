<?php   
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once(SERVER_CORE.'mailer/phpmailwithCC.php');

$rfq = find_all_field('rfq_master','','rfq_no="'.$_SESSION['rfq_no'].'"');


$eventEndAt = $rfq->eventEndDate.' '.$rfq->eventEndTime;
$start_time = date('D, d M Y h:i a',strtotime($rfq->eventStartAt));
$end_time = date('D, d M Y h:i a',strtotime($eventEndAt));

?>
<? ob_start();?>
<div style="max-width: 1000px; margin-right: auto; margin-left: auto; padding: 24px; font-family: 'Source Sans Pro', sans-serif;">
   <p style="font-size: 18px; ">Event has been submitted successfully</p>
   <p><br />
   
<? echo $rfq->mail_template; ?>
<br>
<? echo 'Event      : '.$rfq->event_name.'-'.$_SESSION['rfq_no'];?>
<br>
<? echo 'Start Time : '.$start_time; ?>
<br>
<? echo 'End Time   : '.$end_time; ?>
<br>
<? echo '<a href="https://esourcing.robi.com.bd/esourcing/app/views/auth/vendor/" target="_blank" rel="noopener">View Event</a><br><br>'; ?>
</p>
    <p style="font-size: 18px;  text-align:center;">Supplier List</p>
    <table style="width: 100%; border-collapse: collapse; border: 1px solid #EEEEEE;">
        <thead style="background: #000; color: white;">
            <tr>
                <th style="padding: 12px;">Date Added</th>
                <th style="padding: 12px;">Name</th>
                <th style="padding: 12px;">Contact Name</th>
                <th style="padding: 12px;">Email</th>
               
            </tr>
        </thead>
        <tbody>
        <?
		 $sql = 'select v.*,r.id from vendor v,rfq_vendor_details r where v.vendor_id=r.vendor_id and r.rfq_no="'.$_SESSION['rfq_no'].'"';
		 $qry = db_query($sql);
         while($vendor=mysqli_fetch_object($qry)){
         ?>
            <tr style="background: #EEEEEE;">
                <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;"><?=$vendor->entry_at?></td>
                <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;"><?=$vendor->vendor_name?></td>
                <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;"><?=$vendor->contact_person_name?></td>
                <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;"><?=$vendor->email?></td>
              
            </tr>
        <? }?>
        </tbody>
    </table>
    <p style="font-size: 16px;">Thank you<br>Robi eSourcing Platform</p>
</div>
<?
                //  $mail_Subject = find_a_field('rfq_evaluation_team','action','user_id="'.$_SESSION['user']['id'].'" and rfq_no="'.$_GET['rfq_no'].'"');
          		 $sql = 'select a.id,u.email,u.fname,a.action,a.is_master,m.event_name,m.master_rfq_no,m.rfq_version from rfq_evaluation_team a, user_activity_management u,rfq_master m where a.user_id=u.user_id and a.rfq_no="'.$_SESSION['rfq_no'].'" and a.rfq_no=m.rfq_no';
                 $qry = db_query($sql);
                 $teamsinfo = [];
                 while ($vendor = mysqli_fetch_object($qry)) {
                    $teamsinfo[] = $vendor; 
                }
                $subject= $teamsinfo[0]->event_name.'#'.$teamsinfo[0]->rfq_version;
                $body = ob_get_clean();
                mailerwithCC($teamsinfo,$subject,$body);
            





?>