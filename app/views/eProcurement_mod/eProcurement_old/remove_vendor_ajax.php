<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$str = $_POST['data'];
$data=explode('##',$str);

$vendor  = $data[0];

if($_SESSION['rfq_no']>0 && $vendor>0){
$del = 'delete from rfq_vendor_details where id="'.$vendor.'"';
db_query($del);

$_POST['rfq_no'] = $rfq_no;
$_POST['field_name'] = 'event_vendor_cancel';
$_POST['field_value'] = $vendor;
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud   = new Crud('rfq_logs');
$Crud->insert();
}
?>

<?
		 $sql = 'select v.* from vendor v,rfq_vendor_details r where v.vendor_id=r.vendor_id and r.rfq_no="'.$_SESSION['rfq_no'].'"';
		 $qry = db_query($sql);
		 while($vendor=mysqli_fetch_object($qry)){
		
		?>
					    <tr>
                            <td><?=$vendor->entry_at?></td>
							<td><?=$vendor->vendor_name.' ('.$vendor->vendor_id.')'?></td>
                            <td><?=$vendor->contact_no?></td>
                            <td><?=$vendor->email?></td>
							<td></td>
                            <td></td>
                            <td></td>
							<td></td>
							<td><input type="checkbox" name="vendor_id_<?=$vendor->vendor_id?>" id="vendor_id_<?=$vendor->vendor_id?>" value="<?=$vendor->vendor_id?>" checked="checked"/>&nbsp;<button type="button" name="remove_vendor" class="btn2 btn1-bg-cancel" onclick="remove_vendor(<?=$vendor->vendor_id?>)">x</button></td>
                        </tr>
						<? } ?>