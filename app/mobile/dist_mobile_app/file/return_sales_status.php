<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Sales Return Report";
$page = "return_sales_status.php";
require_once '../assets/template/inc.header.php';

$user_id	= $_SESSION['user']['username'];
$emp_code = $user_id;
$today 		= date('Y-m-d');

$unique 		= 'po_no';
$status 		= 'CHECKED';
$target_url 	= 'receive_view.php';

if (isset($_REQUEST[$unique]) && $_REQUEST[$unique] > 0) {
	$_SESSION[$unique] = $_REQUEST[$unique];
	header('location:' . $target_url);
	exit(); // Important: Always exit after header redirect
}

?>
<script language="javascript">
	function custom(theUrl) {
		window.open('<?= $target_url ?>?v_no=' + theUrl);
	}
</script>

<!-- start of Page Content-->
<div class="page-content header-clear-medium">

	<div class="card card-style mb-0">
		<form action="" method="post" name="codz" id="codz">
			<div class="content m-0">
				<label for="fdate">Date From</label>
				<input type="date" name="fdate" id="fdate" value="<?= isset($_POST['fdate']) ? $_POST['fdate'] : date('Y-m-01'); ?>" placeholder="Date From" class="form-control validate-text" />

				<label for="tdate">Date To</label>
				<input type="date" name="tdate" id="tdate" value="<?= isset($_POST['tdate']) ? $_POST['tdate'] : date('Y-m-d'); ?>" placeholder="Date To" class="form-control validate-text" />
				<div class="d-flex justify-content-center row mt-3">
					<div class="col-6">
						<input type="submit" name="submitit" id="submitit" class="b-n btn btn-success btn-3d btn-block  text-light w-100 py-3" value="View" />
					</div>
				</div>
			</div>
		</form>
	</div>

	<div class="table-responsive pt-2 p-2" style="zoom: 70%;">
		
		<style>
			table {
				width: 100%;
				border-collapse: collapse;
			}
			th, td {
				border: 1px solid black;
				padding: 8px;
				text-align: center;
			}
			th {
				background-color: #f2f2f2;
			}
		</style>    
		
		<?php
		// Initialize variables
		$gqty = 0;
		$gtotal = 0;
		$con = '';
		$res = '';
		
		if (isset($_POST['submitit'])) {
			// Build date condition
			if (!empty($_POST['fdate']) && !empty($_POST['tdate'])) {
				$con .= ' and a.or_date between "' . $_POST['fdate'] . '" and "' . $_POST['tdate'] . '"';
			}

			$res = 'SELECT a.or_no, a.or_date as return_date, a.vendor_id as Party_Code, a.vendor_name as Party_Name, sum(b.qty) as qty, sum(b.amount) as total
					FROM ss_receive_master a, ss_receive_details b 
					WHERE a.or_no = b.or_no
					AND a.receive_type = "Sales Return" 
					AND a.status = "Checked"
					AND a.warehouse_id = "' . $emp_code . '"
					' . $con . '
					GROUP BY a.or_no 
					ORDER BY a.or_no DESC';
			
			// Debug: Show the query (remove this in production)
			echo "<!-- DEBUG SQL: " . $res . " -->";
		}
		?>
		
		<table class="table text-center table-scroll">
		   <thead>
			   <tr class="bg-night-light">
					<th>Return No</th>
					<th>Return Date</th>
					<th>Party Code</th>
					<th>Party Name</th>
					<th>Qty</th>
					<th>Total</th>
				</tr>
			</thead> 
			<tbody>
		<?php 
		if (!empty($res) && trim($res) != '') {
			$query = mysqli_query($conn, $res);
			
			// Check if query executed successfully
			if (!$query) {
				echo "<tr><td colspan='6'>Query Error: " . mysqli_error($conn) . "</td></tr>";
			} else if (mysqli_num_rows($query) == 0) {
				echo "<tr><td colspan='6'>No records found</td></tr>";
			} else {
				while ($row = mysqli_fetch_object($query)) {
		?>
					<tr>
						<td><a href="receive_view1.php?v_no=<?= $row->or_no ?>"><?= $row->or_no ?></a></td>
						<td><?= $row->return_date ?></td>
						<td><?= $row->Party_Code ?></td>
						<td style="text-align:left;"><?= htmlspecialchars($row->Party_Name) ?></td>
						<td><?= $row->qty; $gqty += $row->qty; ?></td>
						<td><?= number_format($row->total, 2); $gtotal += $row->total; ?></td>
					</tr>
		<?php 
				}
				// Show totals row only if there are records
				if ($gqty > 0 || $gtotal > 0) {
		?>
				<tr style="font-weight:700;">
				  <td colspan="4">Total</td>
				  <td><?= number_format($gqty, 2); ?></td>
				  <td><?= number_format($gtotal, 2); ?></td>
				</tr>
		<?php 
				}
			}
		} else {
			echo "<tr><td colspan='6'>Please select date range and click View</td></tr>";
		}
		?>
			</tbody>
		</table>	
		
	</div>
</div>
<!-- End of Page Content-->

<?php
require_once '../assets/template/inc.footer.php';
?>