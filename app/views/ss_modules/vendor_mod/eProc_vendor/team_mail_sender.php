<?php   
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once(SERVER_CORE.'mailer/phpmailwithCC.php');

?>
<?ob_start();?>
<div style="max-width: 1000px; margin-right: auto; margin-left: auto; padding: 24px; font-family: 'Source Sans Pro', sans-serif;">
   <p style="font-size: 18px; "><?echo $_SESSION['user']['fname'];?> responded to your event</p>

    <table style="width: 100%; border-collapse: collapse; border: 1px solid #EEEEEE;">
        <thead style="background: #000; color: white;">
            <tr>
                <th style="padding: 12px;">Response Date</th>
         
                <th style="padding: 12px;">Vendor Name</th>
                <th style="padding: 12px;">Email</th>
               
            </tr>
        </thead>
        <tbody>
            <tr style="background: #EEEEEE;">
                <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;"><?=date('Y-m-d');?></td>

                <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;" style="word-wrap: normal !important;"><? echo $_SESSION['user']['fname'];?></td>
                <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;"><? echo $_SESSION['user']['username'];?></td>
              
            </tr>
        
        </tbody>
    </table>
    <p style="font-size: 16px;">Thank you<br>Robi eSourcing Platform</p>
</div>
<?

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