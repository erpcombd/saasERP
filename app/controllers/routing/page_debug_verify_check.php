<?php
if (isset($_POST['errorCheck'])) {

	$Crud = new Crud('error_check_details');
	$_POST['entry_by'] = $_SESSION['user']['id'];
	$_POST['status'] = "PROBLEM";
	$Crud->insert();
}
?>

<style>
	.tb {
		min-height: 600px  !important;
	}

	.re-titel {
		font-weight: bolder  !important;
		text-align: center  !important;
		color: #fff  !important;
		
		background: linear-gradient(to top, #1c1c56 0%, #306fcd 80%) !important;
	}
	.re-tite2{
		font-weight: bold !important;
		color: #333  !important;
	}
	.erro tr:nth-child(odd) {
		background-color: #feffbf  !important;
		color: #333 !important;
	}
</style>

<?php
				?>




<div class="tb"></div>

<form action="" method="post">
	<table id="error" class="table table-bordered table-sm table-stripped erro">
		<thead>
			<tr>
				<th scope="col" colspan="2" class="re-titel">Page Problem And Debugger Issue</th>

			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="w-80" class="pl-3">
					<div class="form-group row">
						<label for="staticEmail" class="col-sm-2 col-form-label re-tite2">Problem types</label>
						<div class="col-sm-10">
							<select class="custom-select my-1 mr-sm-2" name="error_type" required>
								<option selected>Choose...</option>
								<option value="Design Problem">Design Problem</option>
								<option value="Function Problem">Function Problem</option>
							</select>
						</div>
					</div>
					<input type="hidden" name="page_id" value="<?= $page_id ?>">
					<input type="hidden" name="url" value="<?= $_SERVER['REQUEST_URI']; ?>">

					<div class="form-group row">
						<label for="inputPassword" class="col-sm-2 col-form-label re-tite2">Note</label>
						<div class="col-sm-10">
							<textarea name="note" required></textarea>
						</div>
					</div>
				</td>
				<td class="w-20">
					<br>
					<button type="submit" name="errorCheck" class="btn1 btn1-bg-submit p-2">Submit</button>
				</td>
			</tr>
		</tbody>
	</table>
</form>