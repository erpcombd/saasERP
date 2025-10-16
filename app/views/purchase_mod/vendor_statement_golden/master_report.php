<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Customer Statement';
$proj_id=$_SESSION['proj_id'];
$active='transdetrep';
 
 ?>
 <!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  
<div class="container">
<?php 
$date_con=' and j.jv_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
$dealer_name=find_a_field('vendor','vendor_name','ledger_id="'.$_POST['vendor_ledger'].'"');
?>
<h1 style="text-align:center;font-weight:bold;"><?php echo $dealer_name;?></h1>
     <table class="table table-bordered table-sm">
	 	<thead>
			<tr>
				<th>PO No</th>
				<th>GRN No</th>
				<th>GRN Date</th>
				<th>GRN Amount</th>
				<th>Paid Amount</th>
				<th>Due Amount</th>
				<th>Payment Details</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		 $account_code_con=" and v.ledger_id=".$_POST['vendor_ledger'];
		 
						$sql = "select sum(dr_amt) as payment_amt, ledger_id, tr_id  from journal where tr_from='Payment' group by tr_id ";
						$query = db_query($sql);
						while($data=mysqli_fetch_object($query)){
						$payment_amt[$data->ledger_id][$data->tr_id]=$data->payment_amt;
						
						}
						  
						  
						  
						 $sql = "select sum(dr_amt) as return_amt, ledger_id, tr_id  from journal where tr_from='Purchase Return'  group by tr_id";
						$query = db_query($sql);
						while($data=mysqli_fetch_object($query)){
						$return_amt[$data->ledger_id][$data->tr_id]=$data->return_amt;
						
						}
		 
		  $sql = "SELECT v.ledger_id, v.vendor_name, j.tr_no, j.jv_date, sum(j.cr_amt) as invoice_amt, j.tr_id FROM journal j, vendor v WHERE j.ledger_id=v.ledger_id and j.tr_from in ('Purchase')  ".$account_code_con.$date_con."  group by j.tr_no";
		$query=db_query($sql);
		while($data=mysqli_fetch_object($query)){
		?>
			<tr>
				<td><a href="../../../purchase_mod/pages/po/po_print_view.php?po_no=<?=$data->tr_id?>" target="_blank"><span class="style13" >
							  <?=$data->tr_id;?>
							</span></a></td>
				<td><a href="../../../warehouse_mod/pages/po_receiving/chalan_view2.php?v_no=<?=$data->tr_no?>" target="_blank"><span class="style13" >
							  <?=$data->tr_no?>
							</span></a><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$data->do_no?>"></a></td>
				<td><?php echo $data->jv_date;?></td>
				<td><?=number_format($data->invoice_amt,2);?></td>
				<td>  <a href="payment_details_vendor.php"> <?=number_format($payment_amt[$data->ledger_id][$data->tr_no]+$return_amt[$data->ledger_id][$data->tr_no],2);?></a></td>
				<td><? echo number_format($due_amt=$data->invoice_amt-$payment_amt[$data->ledger_id][$data->tr_no]+$return_amt[$data->ledger_id][$data->tr_no],2);?></td>
				<td>
				<table class="table table-bordered table-sm">
					<thead>
						<tr>
							<th>Payment Method</th>
							<th>Payment Form</th>
							<th>Details</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					$details_sql='select * from payment_vendor where pr_no="'.$data->tr_no.'"';
					$details_query=db_query($details_sql);
					while($row=mysqli_fetch_object($details_query)){
					?>
						<tr>
							<td><?php echo $row->payment_method;?></td>
							<td><?php echo find_a_field('accounts_ledger','ledger_name','ledger_id="'.$row->cr_ledger_id.'"')." Taka- ".$row->payment_amt;?></td>
							<td><?php echo "<span style='font-weight:bold;'>Check No: </span>".$row->cheque_no."<span style='font-weight:bold;'>  Check Date  </span>".$row->cheque_date."<span style='font-weight:bold;'>  Party Bank: </span>".$row->of_bank;?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	 </table>     
</div>

</body>
</html>

 