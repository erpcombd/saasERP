<?php

session_start();

//====================== EOF ===================


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$do_no		= $_GET['do_no'];
 $company_name=find_a_field('project_info','proj_name','1');
 $all_details=find_all_field('sale_do_master','*','do_no="'.$do_no.'"');
 $discount=$all_details->discount;
 $vat=$all_details->vat;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Purchase Receive</title>
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
  <button onClick="pr()" id="pr">Print</button>
		<!--<a href="barcode.php?pr_no=<?=$pr_no?>" id="bar" target="_blank">View Barcode</a>-->
  </div>
  <div class="row">

		  <div class="col-sm-6">
		    
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Do No</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly" value="<?=$all_details->do_no;?>">
			</div>
			
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text" style="font-weight:bold;">Party Name</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$all_details->dealer_code);?>">
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
				<span class="input-group-text"  style="font-weight:bold;">Do Date</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?=$all_details->do_date?>" >
			</div>
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Address</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<? ?>" >
			</div>
			
				
			
			</div>
  </div>
  
  <div class="row" style="margin:0 auto;">
  	<table class="table table-bordered table-sm">
		<thead>
			<tr>
		
			<th>Item Name</th>
				<th>Item Price</th>
				<th>Quantity</th>
				<th>Amount</th>
			</tr>
		</thead>
		
		<tbody>
		<?php 
		 $sql="select * from sale_do_details where do_no='".$do_no."'";
		$query=db_query($sql);
		$vat_amt_tk=find_a_field('sale_do_master','vat_amt_tk','do_no="'.$do_no.'"');
		while($data=mysqli_fetch_object($query)){
		$fg_v_code=find_a_field('item_info','volt_code','item_id='.$data->item_id);
		?>
			<tr>

			<td><?=find_a_field('item_info','item_name','item_id="'.$data->item_id.'"');?></td>
				<td><?=$data->unit_price;?></td>
				<td><?=$data->total_unit?></td>
				<td><?=$data->total_amt?></td>
			</tr>
			<?php 
			$total_qty+=$data->total_unit;
			$total_amt+=$data->total_amt;
			 } ?>
			<tr>
				<td colspan="2"><strong>Total</strong></td>
				<td style="font-weight:bold;"> <?=$total_qty?></td>
				<td style="font-weight:bold;"> <?=$total_amt?></td>
			</tr>
				<tr>
				<td colspan="3"><strong>Discount</strong></td>
		
				<td style="font-weight:bold;"> <?=$disc_amt=(($total_amt*$discount)/100)."  (".$discount."%  )";?></td>
			</tr>
				<tr>
				<td colspan="3"><strong>VAT</strong></td>
		
				<td style="font-weight:bold;"> <? if($vat>0) { echo $vat_amt=(($total_amt*$vat)/100)."  (".$vat."%)";} else{ echo $vat_amt= $vat_amt_tk."  (taka)";}
				
				?></td>
			</tr>
				<tr>
				<td colspan="3"><strong> Total Payable</strong></td>
		
				<td style="font-weight:bold;"> <?=($total_amt+$vat_amt)-$disc_amt?></td>
			</tr>
		</tbody>
	</table>
  </div>
  
  
  </div>
  


</body>
</html>

