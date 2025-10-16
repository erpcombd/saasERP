<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Sales Return Hold List";
$page = "return_sales_unfinished.php";
$user_id	= $_SESSION['user_id'];
require_once '../assets/template/inc.header.php';

?>

<div class="page-content header-clear-medium">

<form action="" method="post" name="codz" id="codz">

<div class="card card-style">
<div class="content mt-0 ms-0 me-0">

<label for="fdate">Date Form</label>
<input type="date" class="form-control validate-text" name="fdate" id="fdate" value="<?= $_POST['fdate'] ? $_POST['fdate'] : date('Y-m-01') ?>" />


<label for="tdate">Date To</label>
<input type="date" class="form-control validate-text" name="tdate" id="tdate" value="<?= $_POST['tdate'] ? $_POST['tdate'] : date('Y-m-d') ?>" />


<div class="d-flex justify-content-center row m-0 mt-3">
	<div class="col-6">
		<input class="b-n btn btn-success btn-3d btn-block  text-light w-100 py-3" type="submit" name="submitit" id="submitit" value="View" />
	</div>
</div>
</div>
</div>
</form>

<?php	if(isset($_POST['submitit'])){
			if($_POST['fdate']!=''&&$_POST['tdate']!='')
			$con .= 'and a.or_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
?>
<div class="card card-style">
					<div class="content ms-0 me-0">
					<div class="table-responsive pt-3" style="zoom: 70%;">
					<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;">
						<thead>
							<tr class="bg-night-light1">
								<th scope="col" class="color-white"> Return No</th>
								<th scope="col" class="color-white"> Return Date</th>
								<th scope="col" class="color-white"> Party Code</th>
								<th scope="col" class="color-white"> Party Name</th>
								<th scope="col" class="color-white"> Return Qty</th>
								<th scope="col" class="color-white"> Amount</th>
								<th scope="col" class="color-white"> Action</th>

							</tr>
						</thead>
						<tbody>	
							<?php
							$sql = 'select  a.or_no,a.or_no as no,a.or_date, a.vendor_name as party, a.vendor_id
							from ss_receive_master a
							where a.status="MANUAL" and a.receive_type = "Sales Return" 
							' . $con . ' 
							group by a.or_no order by a.or_no desc';

							$query = db_query($sql);
							while ($data = mysqli_fetch_object($query)) {
							?>		
								<tr>
									<td style=" color: green; font-weight: bold;"><?=$data->or_no ?></td>
									<td><?= htmlspecialchars($data->or_date) ?></td>
									<td style=" color: #0069b5; font-weight: bold;"><?=$data->vendor_id;?></td>
									<td><?= $data->party ?></td>
									<td>0.00</td>
									<td>0.00</td>
									<td class="d-flex gap-2 p-0">
										<a href="return_sales_manual.php?or_no=<?= $data->or_no ?>"> <button class=" b-n btn btn-info btn-3d btn-block  text-light w-100"><i class="fa-solid fa-eye"></i>	</button></a>
									</td>
								</tr>

							<?php } ?>
						</tbody>
					</table>
				</div>
		</div>		
	</div>
<? } ?>




</div>






<!-- <?php
// 	if(isset($_POST['submitit'])){
// 		if($_POST['fdate']!=''&&$_POST['tdate']!='')
// $con .= 'and a.or_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

// 	$sql = 'select  a.or_no,a.or_no as no,a.or_date, a.vendor_name as party
// 	from ss_receive_master a
// 	where a.status="MANUAL" and a.receive_type = "Sales Return" 
// 	' . $con . ' 
// 	group by a.or_no order by a.or_no desc';

// 	$query = db_query($sql);
// 	while ($data = mysqli_fetch_object($query)) {
	?>
		<div class="card card-style card-bg mb-3">
			<div class="content p-3">
				<div class="d-flex align-items-start">
					<div>

						<div class="d-flex pb-0">
							<div class="align-self-center pe-3 challan-i">
								<i class="fa-duotone fa-light fa-arrow-rotate-left"></i>
							</div>
							<div class="align-self-center">
								<h2 class="font-700 mb-0 f-14"><span class="text-span">No:</span> <?//= $data->or_no ?>-<?//= $data->party ?></h2>
								<h2 class="font-700 mb-0 f-12"><span class="text-span"> Date:</span> <span class="color-highlight"><?//=htmlspecialchars($data->or_date) ?></span></h2>
							</div>
						</div>

					</div>
					<div class="ms-auto">
						<a href="return_sales.php?or_no=<?//= $data->or_no ?>" class="btn btn-info btn-3d text-light" style="height: 35px; padding: 5px 10px;">
							<i class="fa-solid fa-eye"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	<?php //} }?> -->




<?php
require_once '../assets/template/inc.footer.php';
?>