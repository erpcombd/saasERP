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

?>
<table class="table1  table-striped table-bordered table-hover table-sm">
    <caption></caption>
                    <thead class="thead1">
				<tr class="bgc-info">
						<th scope="col" scope="col">ID</th>
						<th scope="col" scope="col">Suppliers Name</th>
						<th scope="col" scope="col">Contact Name</th>
						<th scope="col" scope="col">Suppliers Email</th>
						<th scope="col" scope="col">Language</th>
	
						<th scope="col" scope="col">Action</th>
				</tr>
				</thead>

				<tbody class="tbody1">
					<?
					$sql = 'select * from vendor where  1 '.$con.' order by vendor_name asc';
					$qry = db_query($sql);
					while($vendor=mysqli_fetch_object($qry)){
					?>
					
					<tr<?=$cls?>  bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
						<td><?=$vendor->vendor_id;?></td>
						<td style="text-align:left"><?=$vendor->vendor_name;?></td>
						<td><?=$vendor->contact_person_name;?></td>
						<td style="text-align:left"><?=$vendor->email;?></td>
						<td><?=$vendor->language;?></td>
						<td>
						<button type="button" onclick="DoNav('<?php echo $vendor->vendor_id;?>');" class="btn2 btn1-bg-update"><em class="fa-solid fa-pen-to-square"></em></button>
						</td>
					</tr>
						<? } ?>
						</tbody>
						</table>


