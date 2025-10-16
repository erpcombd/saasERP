<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Other Receive Hold List";
$page = "other_receive_unfinished.php";
$username	= $_SESSION['user']['username'];
$emp_code = $username;
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
								<th scope="col" class="color-white"> Replace No</th>
								<th scope="col" class="color-white"> Replace Date</th>
								<th scope="col" class="color-white"> Party Code</th>
								<th scope="col" class="color-white"> Party Name</th>
								<th scope="col" class="color-white"> Replace Qty</th>
								<!-- <th scope="col" class="color-white"> Amount</th> -->
								<th scope="col" class="color-white"> Action</th>

							</tr>
						</thead>
						<tbody>	
							<?php
							$sql = 'select  a.or_no,a.or_no as no,a.or_date, a.vendor_name as party, a.vendor_id
							from ss_receive_master a
							where a.status="MANUAL" and a.receive_type = "Other Receive" 
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
									<!-- <td>0.00</td> -->
									<td class="d-flex gap-2 p-0">
										<a href="other_receive.php?or_no=<?= $data->or_no ?>"> <button class=" b-n btn btn-info btn-3d btn-block  text-light w-100"><i class="fa-solid fa-eye"></i>	</button></a>
									</td>
								</tr>

							<?php } ?>
						</tbody>
					</table>
				</div>
		</div>		
	</div>

	<?php } ?>
</div>



<?php
require_once '../assets/template/inc.footer.php';
?>