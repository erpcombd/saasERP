<?php   

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

require_once(SERVER_CORE.'mailer/phpmail.php');
$json_data = file_get_contents('php://input');

session_start();
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);
$data = json_decode($json_data, true);

$vendor_email = $data['vendor_email'];


?>

<?

               $rfq = find_all_field('rfq_master','','rfq_no="'.$_SESSION['rfq_no'].'"');
               $body = $rfq->mail_template;
               $subject = 'Request for Quotation';
               echo '<script>alert('dfdfdf')</script>';
             
                //  mailer($vendor_email,$subject,$body);
                //  mailer('fahimfoysal177@gmail.com',$subject,$body);
            





?>