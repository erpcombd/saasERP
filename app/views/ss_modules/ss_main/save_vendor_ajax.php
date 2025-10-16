<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$str = $_POST['data'];
$data=explode('##',$str);

$unique='vendor_id';
$table_master = 'vendor';
$Crud   = new Crud($table_master);

$company  = $data[0];

$info = explode("|",$data[1]);

if($_SESSION['rfq_no']>0){

$_POST['vendor_company'] = $company;
$_POST['vendor_name'] = $company;
$_POST['contact_person_name'] = $info[0];
$_POST['email'] = $info[1];
$_POST['country'] = $info[2];
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$new_vendor_id = $Crud->insert();

$_POST['field_name'] = 'event_item_insert';
$_POST['field_value'] = $info[0];
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud   = new Crud('rfq_logs');
$Crud->insert();
}
$sql = 'select * from vendor where vendor_id="'.$new_vendor_id.'" and vendor_id not in (select vendor_id from rfq_vendor_details where rfq_no="'.$_SESSION['rfq_no'].'")';
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
							<td><input type="checkbox" name="vendor_id_<?=$vendor->vendor_id?>" id="vendor_id_<?=$vendor->vendor_id?>" onclick="assign_vendor(document.getElementById('new_rfq_no').value,<?=$vendor->vendor_id?>)" value="<?=$vendor->vendor_id?>" <?php if($check>0) {echo 'checked';} else {echo '';}?> /></td>
                        </tr>
<? } ?>

<?
		 $sql = 'select v.*,r.id from vendor v,rfq_vendor_details r where v.vendor_id=r.vendor_id and r.rfq_no="'.$_SESSION['rfq_no'].'"';
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
							<td><input type="checkbox" name="vendor_id_<?=$vendor->vendor_id?>" id="vendor_id_<?=$vendor->vendor_id?>" value="<?=$vendor->vendor_id?>" checked="checked"/>&nbsp;<button type="button" name="remove_vendor" class="btn2 btn1-bg-cancel" onclick="remove_vendor(<?=$vendor->id?>)">x</button></td>
                        </tr>
						<? } ?>