<?php
session_start();
include 'config/db.php';
include 'config/function.php';
include 'config/access.php';
$user_id	=$_SESSION['user_id'];

$page="do_unfinished";

include "inc/header.php";

?>
<!-- main page content -->
<div class="main-container container">
           
<!-- User list items  -->
<div class="row">
<div class="row text-center mb-2"><h4>Report<br /><?=$_SESSION['msg'];unset($_SESSION['msg']);?></h4></div>    
    
<div class="row">
	<div class="card">
		<form action="" method="post" style="padding:10px">
			<div class="form-group" >
				<label for="date">From Date</label>
				<input type="date" name="fdate" class="form-control border border-info" tabindex="1" value="<?=$_POST['fdate'];?>" />
				<label for="date">To Date</label>
				<input type="date" name="tdate" class="form-control border border-info" tabindex="1"  value="<?=$_POST['tdate'];?>" />
			</div>
			
			<div class="form-group" >
				<input type="submit" name="show" class="btn btn-info" style="margin-left:20%" value="Show" />
			</div>
		</form>
	</div>
</div>

           </div>         
           <div class="col-md-8 text-end">
		      <?
			   if(isset($_POST['show'])){
	if($_POST['fdate'] !='' && $_POST['tdate'] !='') $con = ' and m.expense_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'" ' ;		

			  ?>
					<table align="center" border="1" style="border-collapse:collapse;">
						<tr class="col-auto text-end">
							<td class="text-primary text-muted size-12 mb-0" style="text-align:center; padding-left:20px; padding-right:20px;"><strong>Entry Date</strong></td>
							
							<td class="text-primary text-muted size-12 mb-0" style="text-align:center; padding-left:20px; padding-right:20px;"><strong>Bill No.</strong></td>
							
							<td class="text-primary text-muted size-12 mb-0" style="text-align:center; padding-left:20px; padding-right:20px;"><strong>Expense Type</strong></td>
							
							<td class="text-primary text-muted size-12 mb-0" style="text-align:center; padding-left:20px; padding-right:20px;"><strong>Qty</strong></td>
							
							<td class="text-primary text-muted size-12 mb-0" style="text-align:center; padding-left:20px; padding-right:20px;"><strong>Rate</strong></td>
							
							<td class="text-primary text-muted size-12 mb-0" style="text-align:center; padding-left:20px; padding-right:20px;"><strong>Amount</strong></td>
							
						</tr>
			<? 
			
   $sql1 = "select   m.expense_date,  m.expense_no,s.qty,s.rate,s.amount,i.item_name, m.status, m.entry_by,m.entry_at from fuel_expense m,fuel_expense_detail s,item_info i 
where m.expense_no=s.expense_no and i.item_id=s.item_id ".$con." order by m.expense_date asc";
//and m.do_date='".date('Y-m-d')."'
//and m.entry_by = '".$data->entry_by."'
$query1=db_query($conn, $sql1);
while($data1=mysqli_fetch_object($query1)){
?>  			
						<tr class="col-auto text-end">
							<td class="text-primary text-muted size-12 mb-0 " style="text-align:center"><?=$data1->expense_date;?></td>
							<td class="text-primary text-muted size-12 mb-0 " style="text-align:center"><?=$data1->expense_no;?></td>
							
							<td class="text-primary text-muted size-12 mb-0 " style="text-align:center"><?=$data1->item_name?></td>
							<td class="text-primary text-muted size-12 mb-0 " style="text-align:center"><?=$data1->qty;?></td>
							<td class="text-primary text-muted size-12 mb-0 " style="text-align:center"><?=$data1->rate;?></td>
							<td class="text-primary text-muted size-12 mb-0 " style="text-align:center"><?=$data1->amount;$tot_amt +=$data1->amount;?></td>
						</tr>
		<? } ?>				
		                <tr>
						   <td colspan="5">Total Amount</td>
						   <td><?=number_format($tot_amt,2)?></td>
						</tr>
					</table>
					<? } ?>
					</div>
            


        </div>
        <!-- main page content ends -->


    </main>
    <!-- Page ends-->

<?php include "inc/footer.php"; ?>