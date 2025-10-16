<?php
session_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Unapproved Quotation Entry';

do_calander('#fdate');
do_calander('#tdate');

$table = 'quotation_master';
$unique = 'quotation_no';
$status = 'UNCHECKED';

if(isset($_POST['convert'])){
 $quotation_no = $_POST['quotaiton_no'];
$sql = 'select * from quotation_master where quotation_no="'.$quotation_no.'"';
 $pdata = mysqli_fetch_object(db_query($sql));
  $insert = 'insert into purchase_master(`group_for`,`po_date`,`vendor_id`,`req_no`,`quotation_no`,`quotation_date`,`warehouse_id`,`entry_by`,`entry_at`) value("'.$_SESSION['user']['group'].'","'.date('Y-m-d').'","'.$pdata->vendor_id.'","'.$pdata->req_no.'","'.$pdata->quotation_no.'","'.$pdata->quotation_date.'","'.$pdata->warehouse_id.'","'.$_SESSION['user']['id'].'","'.date('Y-m-d H:i:s').'")';
 $master_insert = db_query($insert);
 $po_no = db_insert_id();
 
  $sql2 = 'select * from quotation_detail where quotation_no="'.$quotation_no.'" limit 1';
 $query2 = db_query($sql2);
 while($data=mysqli_fetch_object($query2)){
  echo  $details_insert = 'insert into purchase_invoice(`po_no`,`po_date`,`req_no`,`quotation_no`,`quotation_id`,`vendor_id`,`item_id`,`warehouse_id`,`rate`,`qty`,`amount`,`entry_by`,`entry_at`) value("'.$po_no.'","'.date('Y-m-d').'","'.$data->req_no.'","'.$quotation_no.'","'.$data->id.'","'.$data->vendor_id.'","'.$data->item_id.'","'.$data->warehouse_id.'","'.$data->quotation_price.'","'.$data->qty.'","'.($data->quotation_price*$data->qty).'","'.$_SESSION['user']['id'].'","'.date('Y-m-d H:i:s').'")';
  db_query($details_insert);
  
 }
 
$update = db_query('update quotation_master set is_po=1 where quotation_no="'.$quotation_no.'"');
$_SESSION['po_no'] = $po_no;

 
 echo 'Converted';
}
$target_url = '../quotation/mr_checking.php';

@session_destroy($_SESSION['quotation_no']);

?>





<?
/*$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";*/
?>