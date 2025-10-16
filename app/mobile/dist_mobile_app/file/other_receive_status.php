<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Replace Return Report";
$page = "other_receive_status.php";
require_once '../assets/template/inc.header.php';


$user_id	= $_SESSION['user']['id'];
$emp_code = $user_id;
$today 		= date('Y-m-d');



$unique 		= 'po_no';
$status 		= 'CHECKED';
$target_url 	= 'receive_view.php';

if ($_REQUEST[$unique] > 0) {
	$_SESSION[$unique] = $_REQUEST[$unique];
	header('location:' . $target_url);
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

				<label for="fdate">Date Form</label>
				<input type="date" name="fdate" id="fdate" value="<?=$_POST['fdate']?$_POST['fdate']:date('Y-m-01') ?>" placeholder="Date Form" class="form-control validate-text" />
				
				<label for="fdate">Date To</label>
				<input type="date" name="tdate" id="tdate" value="<?=$_POST['tdate']?$_POST['tdate']:date('Y-m-d') ?>" placeholder="Date To" class="form-control validate-text" />

				<div class="d-flex justify-content-center row mt-3">
					<div class="col-6">
						<input type="submit" name="submitit" id="submitit" class="b-n btn btn-success btn-3d btn-block  text-light w-100 py-3" value="View" />
					</div>
				</div>

			</div>
		</form>
	</div>


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





<div class="table-responsive pt-2 p-2" style="zoom: 70%;">
	<?
	if (isset($_POST['submitit'])) {

		if ($_POST['fdate'] != '' && $_POST['tdate'] != '')
			$con .= 'and a.or_date between "' . $_POST['fdate'] . '" and "' . $_POST['tdate'] . '"';
			

		$res = 'select  a.or_no,a.or_no,a.or_date as return_date, a.vendor_id as Party_Code, a.vendor_name as Party_Name, FORMAT(sum(qty),2) as Replace_Qty, sum(amount) as total
        from ss_receive_master a,ss_receive_details b 
        where a.or_no=b.or_no and a.receive_type = "Other Receive"  and a.status="Checked"
        ' . $con . ' and a.warehouse_id="' . $emp_code . '"
        group by a.or_no order by a.or_no desc';
		
		
		//echo link_report_ss($res, 'po_print_view.php');
?>		
	<table class="table text-center table-scroll ">
    <thead>
       	<tr class="bg-night-light">
            <th>Replace No</th>
            <th>Return Date</th>
            <th>Party Code</th>
            <th style="padding: 18px;">Party Name</th>
            <th>Replace Qty</th>
            <th style="padding: 18px;">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $result = mysqli_query($conn,$res);
            while ($row = mysqli_fetch_object($result)) { ?>
               <tr>
                    <td><a href="receive_view.php?v_no=<?= $row->or_no?>"><?=$row->or_no?></a></td>
                    <td><?= $row->return_date?></td>
                    <td><?= $row->Party_Code?></td>
                    <td style="text-align:left;"><?= $row->Party_Name?></td>
                    <td><?= $row->Replace_Qty; $gqty+=$row->Replace_Qty;?></td>
                    <td><?=number_format($row->total,2); $gtotal+=$row->total;?></td>
                </tr>
            
<?
}
?>
<tr style="font-weight:700;">
    <td colspan="4">Total</td>
    <td><?=$gqty?></td>
    <td><?=number_format($gtotal,2);?></td>
</tr>
    </tbody>
</table>		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
<?		
	}
	?>

</div>


</div>
<!-- End of Page Content-->



<?php
require_once '../assets/template/inc.footer.php';
?>