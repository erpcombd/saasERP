<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$str = $_POST['data'];
$data=explode('##',$str);
$unique = 'rfq_no';
$search_with  = $data[0];
$search_text  = $data[1];

if($search_text!=''){
$con = ' and '.$search_with.' like "%'.$search_text.'%"';
}
$sql = 'select * from vendor where vendor_id not in (select vendor_id from rfq_vendor_details where rfq_no="'.$_SESSION['rfq_no'].'") '.$con.' order by vendor_name asc';
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
		 $sql = 'select v.*,r.id from vendor v,rfq_vendor_details r where v.vendor_id=r.vendor_id and r.rfq_no="'.$_SESSION[$unique].'"';
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