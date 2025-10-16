<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


$str = $_POST['data'];
$data=explode('##',$str);

$unique='id';
$table_master = 'rfq_vendor_details';
$Crud   = new Crud($table_master);

$rfq_no  = $data[0];

$vendor = $data[1];

$_POST['rfq_no'] = $rfq_no;

if($rfq_no>0){
$_POST['vendor_id'] = $vendor;
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud->insert();

$_POST['field_name'] = 'event_item_insert';
$_POST['field_value'] = $info[0];
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud   = new Crud('rfq_logs');
$Crud->insert();
}
?>

 <?
		 $sql = 'select v.*,r.id from vendor v,rfq_vendor_details r where v.vendor_id=r.vendor_id and r.rfq_no="'.$_SESSION['rfq_no'].'"';
		 $qry = db_query($sql);
		 if(mysqli_num_rows($qry)<1){
		 ?>
		 <tr>
					 <td colspan="9" style="text-align:center;">..Empty..</td>
					</tr>
					
		 <?
		 }
		 while($vendor=mysqli_fetch_object($qry)){
		
		?>
					    <tr>
                            <td><?=$vendor->entry_at?></td>
							<td><?=$vendor->vendor_name.' ('.$vendor->vendor_id.')'?></td>
                            <td><?=$vendor->contact_person_name?></td>
                            <td><?=$vendor->email?></td>
							
							<td></td>
							<td><button type="button" name="remove_vendor" class="btn2 btn1-bg-cancel" onclick="remove_vendor(<?=$vendor->id?>)">x</button></td>
                        </tr>
						<? } ?>
