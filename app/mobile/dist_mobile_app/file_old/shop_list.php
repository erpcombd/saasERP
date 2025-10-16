<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Shop List";
$page = "shop_list.php";
$menu = 'shop';
$menu_active='active';
$username = $_SESSION['user']['id'];
$emp_code = $username;
require_once '../assets/template/inc.header.php';
?>

<div class="page-content header-clear-medium">

        <div class="card card-style card-bg mb-3">
            <div class="content p-0 m-0">
				<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden; zoom: 75%;">
				<tr class="bg-night-light1">
				<th scope="col" class="color-white">S/L</th>
				<th scope="col" class="color-white">Shop Code</th>
				<th scope="col" class="color-white">Shop Name</th>
				<th scope="col" class="color-white">Address</th>
				<th scope="col" class="color-white">SO Code</th>
				
				<th scope="col" class="color-white">Owner Name</th>
				<th scope="col" class="color-white">Owner Mobile</th>
<!--				<th scope="col" class="color-white">Manager Name</th>
				<th scope="col" class="color-white">Manager Mobile</th>-->
				
				<th scope="col" class="color-white">Class</th>
				<th scope="col" class="color-white">Type</th>
				<th scope="col" class="color-white">Channel</th>
				<th scope="col" class="color-white">Route Type</th>
				<th scope="col" class="color-white">Shop Identity</th>
				
				<!--<th scope="col" class="color-white">Image</th>-->
				</tr>
				<tbody>
				<? 
				$res="select * from ss_shop where master_dealer_code='".$emp_code."' order by dealer_code desc";
				$query = mysqli_query($conn, $res);
				while($data=mysqli_fetch_object($query)){
				$s++;
				?>
				<tr>
				<td><?=$s?></td>
				<td><?=$data->dealer_code?></td>
				<td align="left"><?=$data->shop_name?></td>
				<td align="left"><?=$data->shop_address?></td>
				<td><?=$data->emp_code?></td>
				  
				<td align="left"><?=$data->shop_owner_name?></td>  
				<td><?=$data->mobile?></td>
<!--				<td><?=$data->manager_name?></td>  
				<td><?=$data->manager_mobile?></td>  -->
				
				<td align="left"><?=$data->shop_class?></td>
				<td><?=$data->shop_type?></td>
				<td><?=$data->shop_channel?></td>
				<td><?=$data->shop_route_type?></td>
				<td><?=$data->shop_identity?></td>
				<!--<td><? if($data->picture!=''){ ?><a href="../sec_mobile_app/<?=$data->picture?>" target="_blank">View</a><? } ?></td>-->
				</tr>
				<? } ?>
				</tbody>
				</table>
            </div>
        </div>


</div>

<?php
require_once '../assets/template/inc.footer.php';
?>