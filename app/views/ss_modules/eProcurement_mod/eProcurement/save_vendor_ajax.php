<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$str = $_POST['data'];
// Decode the received data
$str = urldecode($str);
$data=explode('##',$str);

$unique='vendor_id';
$table_master = 'vendor';
$Crud   = new Crud($table_master);

$company  = $data[0];

$info = explode("|",$data[1]);


if($_SESSION['rfq_no']>0){

$pass_mail = $info[3].'_1';
$_POST['vendor_company'] = $info[0];
$_POST['vendor_name'] = $info[0];
$_POST['vendor_category'] = $info[1];
$_POST['contact_person_name'] = $info[2];
$_POST['email'] = $info[3];

$_POST['address'] = $info[4];
$_POST['beneficiary_name'] = $info[5];
$_POST['status'] = $info[6];
$_POST['tin'] = $info[7];
$_POST['cc_email'] = $info[8];
$_POST['country'] = $info[9];
$_POST['group_for'] = $company;

$_POST['password'] = auth_encode($pass_mail);
$_POST['pass_change'] = 'NO';
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$new_vendor_id = $Crud->insert();

$_POST['field_name'] = 'event_supplier_insert';
$_POST['field_value'] = $info[0];
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud   = new Crud('rfq_logs');
$Crud->insert();
}

?>
<table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
					<tr>
					 <th scope="col" colspan="9" style="text-align:center;">..Search Result..</th>
					</tr>
                    <tr class="bgc-info">
                        <th scope="col">Date Added </th>
                        <th scope="col">Name</th>
                        <th scope="col">Contact Name</th>
						<th scope="col">Email</th>
                        <th scope="col">T&C </th>
						<th scope="col">Action</th>
                        
                    </tr>
                    </thead>
                    
					
                    <tbody class="tbody1">
					<?
					$sql = 'select * from vendor where vendor_id="'.$new_vendor_id.'" and vendor_id not in (select vendor_id from rfq_vendor_details where rfq_no="'.$_SESSION['rfq_no'].'")';
$qry = db_query($sql);
while($vendor=mysqli_fetch_object($qry)){
					?>
<tr>
                            <td><?=$vendor->entry_at?></td>
							<td><?=$vendor->vendor_name.' ('.$vendor->vendor_id.')'?></td>
                            <td><?=$vendor->contact_person_name?></td>
                            <td><?=$vendor->email?></td>
							<td></td>
							<td><input type="checkbox" name="vendor_id_<?=$vendor->vendor_id?>" id="vendor_id_<?=$vendor->vendor_id?>" onclick="assign_vendor(document.getElementById('new_rfq_no').value,<?=$vendor->vendor_id?>)" value="<?=$vendor->vendor_id?>" <?php if($check>0) {echo 'checked';} else {echo '';}?> /></td>
                        </tr>
						<? } ?>
						</tbody>
						</table>

