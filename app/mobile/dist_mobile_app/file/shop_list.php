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

<style>
	.ccc{
			margin-bottom: -30px !important;
	
	}
	
</style>

<div class="page-content header-clear-medium" style="position: relative !important;">



        <div class="card card-style card-bg mb-3 ">
            <div class="content p-0 m-0">
			<div class="col-12 p-0">
						<div class="input-group m-0">
						  <div class="input-group-prepend">
							<span class="input-group-text" id="basic-addon1" style=" background-color: #0069b5; color: whitesmoke; font-size: 18px !important; font-weight: bolder; padding: 7px; border-radius: 5px 0px 0px 5px; "><i class="fa-solid fa-magnifying-glass"></i></span>
						  </div>
						  <input type="text" id="searchBox" class="form-control" aria-label="Username" aria-describedby="basic-addon1" placeholder="Search For Data..." style=" width: 90% !important; height: 33px !important; border: 2px solid #0069b5 !important; border-left: 0px !important;" >
						</div>
                      
                    </div></div>
					</div>





        <div class="card card-style card-bg mb-3 ccc">
            <div class="content p-0 m-0 ">
				<div class="table-responsive" style="zoom: 74%; height: 100vh; overflow-x: auto; overflow-y: auto;border: 1px solid #ddd; ">
					<table class="table table-borderless text-center table-scroll table_new_border">
						<thead style=" position: sticky; top: 0; ">
							<tr class="bg-night-light1" style="white-space: nowrap;">
								<th scope="col" class="color-white">S/L</th>
								<th scope="col" class="color-white">Route Name</th>
								<th scope="col" class="color-white">Shop Code</th>
								<th scope="col" class="color-white">Shop Name</th>
								<th scope="col" class="color-white">Address</th>
								<th scope="col" class="color-white">SO Code</th>
								
								<th scope="col" class="color-white">Owner Name</th>
								<th scope="col" class="color-white">Owner Mobile</th>
								
								<th scope="col" class="color-white">Class</th>
								<th scope="col" class="color-white">Type</th>
								<th scope="col" class="color-white">Channel</th>
								<th scope="col" class="color-white">Route Type</th>
								<th scope="col" class="color-white">Shop Identity</th>

							</tr>
						</thead>
					<tbody id="dataTable">
					<? 
					$res="select s.*,r.route_name 
					from ss_shop s, ss_route r, ss_user u 
					where s.route_id=r.route_id and u.username=s.emp_code and u.dealer_code='".$emp_code."' and s.status=1 
					order by s.dealer_code desc";
					
					$query = mysqli_query($conn, $res);
					while($data=mysqli_fetch_object($query)){
					$s++;
					?>
					<tr>
					<td><?=$s?></td>
					<td align="left"><?=$data->route_name?></td>
					<td align="left"><?=$data->dealer_code?></td>
					<td align="left"><?=$data->shop_name?></td>
					<td align="left"><?=$data->shop_address?></td>
					<td align="left"><?=$data->emp_code?></td>
					  
					<td align="left"><?=$data->shop_owner_name?></td>  
					<td align="left"><?=$data->mobile?></td>
					
					<td align="left"><?=$data->shop_class?></td>
					<td align="left"><?=$data->shop_type?></td>
					<td align="left"><?=$data->shop_channel?></td>
					<td align="left"><?=$data->shop_route_type?></td>
					<td align="left"><?=$data->shop_identity?></td>

					</tr>
					<? } ?>
					</tbody>
					</table>
				</div>
            </div>
        </div>


</div>

<?php
require_once '../assets/template/inc.footer.php';
?>


    <script>
        document.getElementById("searchBox").addEventListener("input", function () {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll("#dataTable tr");

            rows.forEach(row => {
                const cells = row.querySelectorAll("td");
                const rowText = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(" ");
                row.style.display = rowText.includes(filter) ? "" : "none";
            });
        });
    </script>