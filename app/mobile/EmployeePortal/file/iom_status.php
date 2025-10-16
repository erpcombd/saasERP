<?php 


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once '../assets/support/emp_apps_function.php';

$title = "IOM Status";
$page = "iom_status.php";


require_once '../assets/template/inc.header.php';



$u_id= $_SESSION['user']['id']; //$_SESSION['user']['id'];

$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);



$user_id	= $PBI_ID; //$_SESSION['user_id'];









?>



    

<!-- start of Page Content-->  
   <div class="page-content header-clear-medium">
   

			<div class="content">
				  <table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;">
						<thead>
							<tr class="bg-night-light1">
								<th scope="col" class="color-white">SL</th>
								<th scope="col" class="color-white">IOM Type</th>
								<th scope="col" class="color-white">IOM Date</th>
								<th scope="col" class="color-white">Start Time</th>
								<th scope="col" class="color-white">End Time</th>
								<th scope="col" class="color-white">Total Days</th>
								<th scope="col" class="color-white">Status</th>

							</tr>
						</thead>
						<tbody>
			<?php 
					
			$g_s_date=date('Y-01-01');
			$g_e_date=date('Y-12-31');
			
			 $sql_t = "select a.* from hrm_iom_info a where s_date between '".$g_s_date."' and '".$g_e_date."' and PBI_ID='".$PBI_ID ."'   order by id desc";
			
			$query2=db_query($sql_t);
			
			while($data2=mysqli_fetch_object($query2)){
			
			?> 
							<tr>
								<th scope="row"><?=++$s?></th>
								<td><?=$data2->type?></td>

                            <td><?=$data2->iom_apply_date?></td>

                            <td><?=$data2->s_time?></td>

                            <td><?=$data2->e_time?></td>

                            <td><?=$data2->total_days?></td>
							
							 <td><?=$data2->iom_status?></td>
							</tr>
						<?php } ?> 
							
						</tbody>
					</table>
			</div>
			
			
			
			
						

			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
        </div>
    <!-- End of Page Content--> 
    
    











<?php 
 require_once '../assets/template/inc.footer.php';
 ?>