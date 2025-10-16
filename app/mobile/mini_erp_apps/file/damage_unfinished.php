<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Damage Hold List";
$page = "damage_unfinished.php";
$username = $_SESSION['user']['username'];
$emp_code = $username;
require_once '../assets/template/inc.header.php';
?>

<div class="page-content header-clear-medium">
	<?php
	$sql = 'select  a.oi_no,a.oi_no as no,a.oi_date, a.vendor_name as party
	from ss_issue_master a
	where a.status="MANUAL" and a.issue_type = "Damage" 
	' . $con . ' 
	group by a.oi_no order by a.oi_no desc';

	$query = db_query($sql);
	while ($data = mysqli_fetch_object($query)) {
	?>
		<div class="card card-style card-bg mb-3">
			<div class="content p-3">
				<div class="d-flex align-items-start">
					<div>

						<div class="d-flex pb-0">
							<div class="align-self-center pe-3 challan-i">
								<i class="fa-sharp-duotone fa-solid fa-house-chimney-crack text-success"></i>
							</div>
							<div class="align-self-center">
								<h2 class="font-700 mb-0 f-14"><span class="text-span">No:</span> <?= $data->oi_no ?> -<?= $data->party ?><?= $data->oi_date ?></h2>
								<h2 class="font-700 mb-0 f-12"><span class="text-span"> Date:</span> <span class="color-highlight"><?= htmlspecialchars($data->oi_date) ?></span></h2>
							</div>
						</div>

					</div>
					<div class="ms-auto">
						<a href="damage_entry.php?oi_no=<?= $data->oi_no; ?>" class="btn btn-info btn-3d text-light" style="height: 35px; padding: 5px 10px;">
							<i class="fa-solid fa-eye"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
</div>

<?php
require_once '../assets/template/inc.footer.php';
?>