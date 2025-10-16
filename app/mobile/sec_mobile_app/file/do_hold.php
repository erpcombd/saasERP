<?php 
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';


$title = "Hold Order List";
$page = "do_hold.php";
$user_id	=$_SESSION['user_id'];
$username = $_SESSION['user']['username'];
$emp_code = $username;
$today 		= date('Y-m-d');

$unique 		= 'do_no';
$target_url 	= 'do_view.php';


require_once '../assets/template/inc.header.php';

if($_REQUEST[$unique]>0)
{
$_SESSION[$unique] = $_REQUEST[$unique];
header('location:'.$target_url);
}

?>
 <script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?do='+theUrl);
}
</script>


    

<!-- start of Page Content-->  
   <div class="page-content header-clear-medium">
     <form action="" method="post" name="codz" id="codz">
		<div class="card card-style mb-0">
						<div class="content m-0">	
								<label for="fdate" class="p-0 pb-1">Date Form</label>				
								<input type="date" class="form-control validate-text" name="fdate" id="fdate" value="<?=$_POST['fdate']?$_POST['fdate']:date('Y-m-01')?>" />
								<label for="tdate"  class="p-0 pb-1 pt-2">Date To</label>			
								<input type="date" class="form-control validate-text" name="tdate" id="tdate" value="<?=$_POST['tdate']?$_POST['tdate']:date('Y-m-d')?>" />
							<div class="d-flex justify-content-center row m-0 mt-3">
								<div class="col-6">					
								<input class=" b-n btn btn-success btn-3d btn-block  text-light w-100 py-3" type="submit" name="submitit" id="submitit" value="View" />			
								</div>
							</div>		
						</div>
		</div>
	</form>

				<div class="card card-style">
					<div class="content ms-0 me-0">
					<div class="table-responsive pt-3" style="zoom: 70%;">
					
					<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;">
						<thead>
							<tr class="bg-night-light1">
								<th scope="col" class="color-white"> Order No</th>
								<th scope="col" class="color-white"> Order Date</th>
								<th scope="col" class="color-white"> Party Code</th>
								<th scope="col" class="color-white"> Party Name</th>
								<th scope="col" class="color-white"> Order Qty</th>
								<th scope="col" class="color-white"> Amount</th>
								<th scope="col" class="color-white"> Action</th>

							</tr>
						</thead>
						<tbody>
				
					<? 
					
					if(isset($_POST['submitit'])){
					
						if($_POST['fdate']!=''&&$_POST['tdate']!='')
						$con .= 'and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
						
						 $res = 'SELECT * FROM ss_do_master WHERE  status = "MANUAL" and do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'" and entry_by="'.$emp_code.'" ORDER BY do_no DESC;';
							$query=mysqli_query($conn,$res);
							$sl=1;
							while($data=mysqli_fetch_object($query)){
							?>
					
							<tr>
								<td style=" color: green; font-weight: bold;"><?=$data->do_no;?></td>
								<td><?=$data->do_date;?></td>
								<td style=" color: #0069b5; font-weight: bold;"><?=$data->dealer_code;?></td>
								<td><?=find_a_field('ss_shop','shop_name','dealer_code="'.$data->dealer_code.'"');?></td>
								<td><? $total_pkt_unit=find_a_field('ss_do_details','SUM(pkt_unit)','do_no="'.$data->do_no.'" group by do_no'); if($total_pkt_unit > 0){echo $total_pkt_unit;}else{ echo '0.00';}?></td>
								<td><? $total_amt=find_a_field('ss_do_details','SUM(total_amt)','do_no="'.$data->do_no.'" group by do_no'); if($total_amt > 0){echo $total_amt;}else{ echo '0.00';}?></td>
								<td class="d-flex gap-2 p-0">
							   <a href="do_entry.php?order_id=<?=$data->do_no?>"> <button class=" b-n btn btn-info btn-3d btn-block  text-light w-100"><i class="fa-solid fa-eye"></i>	</button></a>
								</td>
							</tr>
							<? } ?>    
						</tbody>
					</table>
					</div>
					
					</div>
				</div>
			
				 
					<? } ?>
					
						
							
						
			
		</div>
    <!-- End of Page Content--> 
    
    


<?php 
 require_once '../assets/template/inc.footer.php';
 ?>