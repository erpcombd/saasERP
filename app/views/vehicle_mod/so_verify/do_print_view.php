<?php

session_start();

//====================== EOF ===================

require_once "../../../assets/support/inc.all.php";

$do_no		= $_GET['do_no'];
 $company_name=find_a_field('project_info','proj_name','1');
 $all_details=find_all_field('sale_do_master','*','do_no="'.$do_no.'"');
 $discount=$all_details->discount;
 $vat=$all_details->vat;
 if(isset($_POST['rej2'])){
 $do_no_get=$_POST['do'];
  $rejection_note=$_POST['rej_note'];
  $user=$_SESSION['user']['id'];
  
  
  $sql='update sale_do_master set status="MANUAL",rejection_note="'.$rejection_note.'",acc_check="'.$user.'",additional_status="REJECTED" where do_no="'.$do_no.'"';
mysql_query($sql);

 $sql1='update sale_do_details set status="MANUAL" where do_no="'.$do_no.'"';
 mysql_query($sql1);
 
  echo "<script>window.top.location='approve_do.php'  </script>";

  
 }
// if($_GET['unfinished']>0){
 //$do_no=$_GET['unfinished'];
  
 
// }
 

 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sales Approve</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 
</head>
<script>
function pr(){
document.getElementById('pr').style.display='none';
document.getElementById('tr').style.display='none';
  window.print();
}
</script>
<style>
	.form-control{
		border:1px solid black;
		color:black;
	}
	.input-group-text{
	border:1px solid black;
	}
	.table-bordered td, .table-bordered thead th{
	border:1px solid black;
	}
</style>
<body>
  
  <div class="container">
  <h4 class="text-center"><?php echo $company_name; ?></h4>
  <h6 class="text-center">
 Sales Order
  </h6>
  <div class="row">
  <button class="btn btn-success" onClick="pr()" id="pr">Print</button>
 &nbsp; 
 <a type="button" href="do_pdf.php?file_name=<?=$all_details->do_file?>" target="_blank" class="btn btn-success" id="tr" > View Original Copy</a>
		<!--<a href="barcode.php?pr_no=<?=$pr_no?>" id="bar" target="_blank">View Barcode</a>-->
  </div>
  <div class="row">

		  <div class="col-sm-6">
		    
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">SO No</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly" value="<?=$all_details->do_no;?>">
			</div>
			
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text" style="font-weight:bold;">Customer Name</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$all_details->dealer_code);?>">
			</div>
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">PO No</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?=$all_details->po_no;?>" >
			</div>
				<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Entry By</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?=find_a_field('user_activity_management','fname','user_id='.$all_details->entry_by);?>" >
			</div>
			
			
		  </div>
		  
		  
			<div class="col-sm-6">
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">SO Date</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?=$all_details->do_date?>" >
			</div>
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Address</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?=find_a_field('dealer_info','address_e','dealer_code='.$all_details->dealer_code);?>" >
			</div>
				<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">PO Date</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?=$all_details->po_date;?>" >
			</div>
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Delivery Address</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?=find_a_field('dealer_info','delivery_address','dealer_code='.$all_details->dealer_code);?>" >
			</div>
			
				
			
			</div>
  </div>
  
  <div class="row" style="margin:0 auto;">
  	<table class="table table-bordered table-sm">
		<thead>
			<tr>
		<th>Item Code</th>
			<th>Item Name</th>
			<th>Quantity</th>
			<th>Unit</th>
				<th>Item Price</th>
				
				<th>Amount</th>
				
				
			</tr>
		</thead>
		
		<tbody>
		<?php 
		 $sql="select * from sale_do_details where do_no='".$do_no."'";
		$query=mysql_query($sql);
		
		  $vat_amt_tk=find_a_field('sale_do_master','vat_amt_tk','do_no="'.$do_no.'"');
		while($data=mysql_fetch_object($query)){
		$fg_v_code=find_a_field('item_info','volt_code','item_id='.$data->item_id);
		?>
			<tr>
<td><?=find_a_field('item_info','finish_goods_code','item_id="'.$data->item_id.'"');?></td>
			<td><?=find_a_field('item_info','item_name','item_id="'.$data->item_id.'"');?></td>
			<td><?=$data->total_unit?></td>
			<td><?=find_a_field('item_info','unit_name','item_id="'.$data->item_id.'"');?></td>
				<td><?=$data->unit_price;?></td>
				
				<td><?=$data->total_amt?></td>
				
			</tr>
			<?php 
			$total_qty+=$data->total_unit;
			$total_amt+=$data->total_amt;
			
			 } ?>
			<tr>
				<td colspan="2"><strong>Total</strong></td>
				<td style="font-weight:bold;"> <?=$total_qty?></td>
				<td></td>
				<td></td>
				<td style="font-weight:bold;"> <?=number_format($total_amt,2)?></td>
				
			</tr>
				<tr>
				<td colspan="5"><strong>Discount</strong></td>
		
				<td style="font-weight:bold;"> <?=$disc_amt=(($total_amt*$discount)/100)."  (".$discount."%  )";?></td>
			</tr>
				<tr>
				<td colspan="5"><strong>VAT</strong></td>
		
				<td style="font-weight:bold;"> <? if($vat>0) { echo $vat_amt=(($total_amt*$vat)/100)."  (".$vat."%)";} else{ echo $vat_amt= $vat_amt_tk."  (taka)";}
				
				?></td>
			</tr>
				<tr>
				<td colspan="5"><strong> Total Payable</strong></td>
		
				<td style="font-weight:bold;"> <?=number_format(($total_amt+$vat_amt)-$disc_amt,2)?></td>
			</tr>
		</tbody>
	</table>
	


  </div>
    <br><br>
  <div class="row" style="margin:0 auto;">
  
  <div class="col-sm-6 text-center">
  
<!--	 <a  href="do_print_view.php?unfinished=<?=$do_no?>" >--> <button  class="btn btn-danger" id="rej" style="width:200px;" onClick="rej_note()" type="button" >Not Accepted</button><!--</a>-->

<!--	<button  class="btn btn-danger" id="rej2" style="width:200px;display:none;" type="submit" >Confirm Reject</button>-->
  </div>

   <div class="col-sm-6 text-center">
  <a  href="approve_sales_challan.php?do_no=<?=$do_no ?>" > <button  class="btn btn-success" style="width:200px;">Accepted</button></a>
   </div>
  </div> 
  
    <form action="" method="post">
  <div class="row" style="margin:0 auto;">
    	<input type="hidden" name="do" id="do" value="<?=$do_no?>" >

  <div class="col-sm-6 text-center">
  
	<textarea id="rej_note" name="rej_note" rows="4" cols="50" style="display:none;">
		
  </textarea><br>

	<button  class="btn btn-danger" id="rej2" name="rej2" style="width:200px;display:none;" type="submit" >Confirm Return</button>
  </div>


   
  </div>
  <br><br>
  
  </div>
  </form>
  <script>
  	function rej_note(){
document.getElementById('rej').style.display="none";
document.getElementById('rej2').style.display="block";
document.getElementById('rej_note').style.display="block";
	}
  </script>


</body>
</html>

