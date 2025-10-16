<?php


// $tst = 'omar';

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$group_for=$_POST['group_for'];
$vendor_id=$_POST['vendor'];
 

?>



<? 


 

foreign_relation('purchase_receive p, vendor v, journal_item j, user_group g','p.pr_no','concat(p.pr_no,"-",v.vendor_name)',$invoice_no,'p.group_for='.$group_for.' and v.vendor_id='.$vendor_id.' and p.item_id=j.item_id and j.sr_no=p.pr_no and p.status in ("Received","Bill Created") and v.vendor_id=p.vendor_id and g.id=p.group_for group by p.pr_no');

?>




