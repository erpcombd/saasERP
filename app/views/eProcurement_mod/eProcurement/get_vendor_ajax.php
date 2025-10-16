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

if($data[0]=='vendor_category'){
	//$cat_id = find_a_field('vendor_category','id','category_name like "%'.$search_text.'%"');
	$sql = 'select * from vendor_category where category_name like "%'.$search_text.'%"  order by category_name asc';
	$qry = db_query($sql);
	while($vendor=mysqli_fetch_object($qry)){
		$catIds[] = $vendor->id;
	}
	if(!empty($catIds)){
	$catIdsIn = implode(",", $catIds); 
	 $con = ' and vendor_category in ('.$catIdsIn.') ';
	}
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
                        
						<th scope="col">Add</th>
                        
                    </tr>
                    </thead>
                    
					
                    <tbody class="tbody1">
					<?
					$sql = 'select * from vendor where vendor_id not in (select vendor_id from rfq_vendor_details where rfq_no="'.$_SESSION['rfq_no'].'") '.$con.' order by vendor_name asc';
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


