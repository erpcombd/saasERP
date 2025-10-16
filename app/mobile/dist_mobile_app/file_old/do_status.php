<?php 
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

	$menu = 'order';
	$menu_active='active';
	
$title = "Order List";
$page = "do_status.php";
$user_id	=$_SESSION['user_id'];
$username = $_SESSION['user']['id'];
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
	
					<label for="fdate" >Date Form</label>
						<input type="date" class="form-control validate-text" name="fdate" id="fdate" value="<?=$_POST['fdate']?$_POST['fdate']:date('Y-m-01')?>" />
					<label for="tdate" >Date To</label>
						<input type="date" class="form-control validate-text" name="tdate" id="tdate" value="<?=$_POST['tdate']?$_POST['tdate']:date('Y-m-d')?>" />
						

		<div class="d-flex justify-content-center row m-0 mt-3">
						<div class="col-6">					
	                    <input class=" b-n btn btn-success btn-3d btn-block  text-light w-100 py-3" 
						type="submit" name="submitit" id="submitit" value="View" />							
						</div>
					</div>		
				</div>
				            </div>
			</form>

			<div class="card card-style"> 
							<div class="content ms-0 me-0">
			
				<div class="table-responsive pt-3" style="zoom: 74%;">
					
					<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;">
						<thead>
							<tr class="bg-night-light1">
								<!--<th scope="col" class="color-white"> S/L</th>-->
								<th scope="col" class="color-white"> Order No</th>
								<th scope="col" class="color-white"> Order Date</th>
								<th scope="col" class="color-white"> Party Code</th>
								<th scope="col" class="color-white"> Party Name</th>
								<th scope="col" class="color-white"> Order Qty</th>
								<th scope="col" class="color-white"> Order amt</th>
								<!--<th scope="col" class="color-white"> Remarks</th>-->
								<th scope="col" class="color-white"> Action</th>

							</tr>
						</thead>
						<tbody>
				
					<? 
					
					if(isset($_POST['submitit'])){
					
						if($_POST['fdate']!=''&&$_POST['tdate']!='')
						$con .= 'and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
						
						$res='select  m.do_no,m.do_no as do_no,m.do_date,m.remarks, s.shop_name as party, s.dealer_code as party_code, FORMAT(sum(d.total_amt),2) as Total,sum(d.pkt_unit) as qty from ss_do_master m, ss_do_details d , ss_shop s where m.do_no=d.do_no and m.dealer_code=s.dealer_code and m.status in("Checked","COMPLETED") '.$con.' and m.depot_id="'.$emp_code.'" group by m.do_no order by m.do_no desc';
							//echo link_report_ss($res,'do_view.php');
							$query=mysqli_query($conn,$res);
							$sl=1;
							while($data=mysqli_fetch_object($query)){
							?>
					
							<tr>
								<!--<td><?=$sl++;?></td>-->
								<td style=" color: green; font-weight: bold;"><?=$data->do_no;?></td>
								<td><?=$data->do_date;?></td>
								<td style=" color: #0069b5; font-weight: bold;"><?=$data->party_code;?></td>
								<td><?=$data->party;?></td>
								<td><?=$data->qty;?></td>
								<td><?=$data->Total;?></td>
								<!--<td><?=$data->remarks;?></td>-->
								<td class="d-flex gap-2 justify-content-center align-items-center">
							   <a href="do_view.php?do=<?=$data->do_no;?>"> <button class="b-n btn btn-info btn-3d btn-block  text-light w-100"><i class="fa-solid fa-eye"></i></button></a>
							   <a href="do_print_view.php?do=<?=$data->do_no;?>">
								<button class="b-n btn btn-warning btn-3d btn-block  text-light w-100"><i class="fa-solid fa-print"></i></button>
								</a>
								</td>
							</tr>
							<? } ?>    
						</tbody>
					</table>
					</div> 
					</div></div>
					<? } ?>
					

		</div>
    <!-- End of Page Content--> 
    
    


<?php 
 require_once '../assets/template/inc.footer.php';
 ?>