<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$str = $_POST['data'];
$data=explode('##',$str);

$vendor  = $data[0];
$vendor_name =  find_a_field('rfq_vendor_details','vendor_name','id="'.$vendor.'"');

if($_SESSION['rfq_no']>0 && $vendor>0){
$del = 'delete from rfq_vendor_details where id="'.$vendor.'"';
db_query($del);

$_POST['rfq_no'] = $_SESSION['rfq_no'];
$_POST['field_name'] = 'Event vendor removed';
$_POST['field_value'] = $vendor_name;
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
							<td></td>
							<td><button type="button" name="remove_vendor" class="btn2 btn1-bg-cancel" onclick="remove_vendor(<?=$vendor->id?>)">x</button></td>
							<td><button type="button" onclick="notify_supplier_individual('<?=$vendor->email?>')" class="btn btn-primary">Send Email</button></td>
                        </tr>
						<? } ?>