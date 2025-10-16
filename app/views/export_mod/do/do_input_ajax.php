<?php

//


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');

//--========Table information==========-----------//
$table_master='sale_requisition_master';

$unique_master='do_no';

$table_detail='sale_requisition_details';

$unique_detail='id';

//--========Table information==========-----------//

$unique = $_POST[$unique_master];

$details_insert = new crud($table_detail)	;
$_POST['unit_price']=$_POST['unit_price'] ;
$details_insert->insert();
unset($$unique);
$type=1;
$msg='Item Entry Succesfull';

$res='select a.id,b.finish_goods_code as code,a.item_description,a.unit_price as price,a.dist_unit as qty ,a.total_amt,"X" from sale_requisition_details a,item_info b where b.item_id=a.item_id and a.do_no='.$unique.' order by a.id';


$all_dealer[]=link_report_add_del_auto($res,'',6);
echo json_encode($all_dealer);

?>



