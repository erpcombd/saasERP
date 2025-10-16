<?php

session_start();

//====================== EOF ===================

require_once "../../../assets/support/inc.all.php";
echo $_POST['do_no'];
$do_no		= $_GET['do_no'];
 $company_name=find_a_field('project_info','proj_name','1');
 $all_details=find_all_field('sale_do_master','*','do_no="'.$do_no.'"');
 $discount=$all_details->discount;
 $vat=$all_details->vat;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sales Order</title>
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
	 .mb-3{
margin-bottom:4px!important;
}
	.form-control{
		/*border:1px solid black;*/
		color:black;
	}
/*	.input-group-text{
	border:1px solid black;
	}*/
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
		<div>	  <a type="button" href="do_pdf.php?file_name=<?=$all_details->do_file?>" target="_blank" class="btn btn-success" id="tr" > View PO Copy</a></div>
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
				<span class="input-group-text"  style="font-weight:bold;">PO No</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly" value="<?=$all_details->po_no;?>">
			</div>
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text" style="font-weight:bold;">Customer ID</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?=$all_details->dealer_code;?>">
			</div>
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text" style="font-weight:bold;">Customer Name</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$all_details->dealer_code);?>">
			</div>
				<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text" style="font-weight:bold;">Contact Person</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?=find_a_field('dealer_info','contact_person_inv','dealer_code='.$all_details->dealer_code);?>">
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
			  <input type="text" class="form-control" readonly="readonly"  value="<?php 
		
			  echo  $newDate = date("d-m-Y", strtotime($all_details->do_date));
			  
			  ?>" >
			</div>
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">PO Date</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly" value="<?php 

			  		  echo  $newDate2 = date("d-m-Y", strtotime($all_details->po_date));
			  ?> ">
			</div>
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Address</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<? ?>" >
			</div>
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Cell No</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<? echo $all_details->mobile_no;?>" >
			</div>
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Contact Person Designation</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?=find_a_field('dealer_info','designation2','dealer_code='.$all_details->dealer_code);?>" >
			</div>
				
			
			</div>
  </div>
  
  <div class="row" style="margin:0 auto;">
  	<table class="table table-bordered table-sm">
		<thead>
			<tr>
		<th style="text-align:center;" >Item Code</th>
			<th style="text-align:center;" >Item Name</th>
			<th style="text-align:center;">Quantity</th>
			<th style="text-align:center;">Unit</th>
				<th style="text-align:center;" >Item Price</th>
				
				<th style="text-align:center;" >Amount (BDT)</th>
			</tr>
		</thead>
		
		<tbody>
		<?php 
		$do_all=find_all_field('sale_do_master','','do_no="'.$do_no.'"');
		 $sql="select * from sale_do_details where do_no='".$do_no."'";
		$query=mysql_query($sql);
		$vat_amt_tk=find_a_field('sale_do_master','vat_amt_tk','do_no="'.$do_no.'"');
		while($data=mysql_fetch_object($query)){
		$fg_v_code=find_a_field('item_info','volt_code','item_id='.$data->item_id);
		?>
			<tr>
	<td><?=find_a_field('item_info','finish_goods_code','item_id="'.$data->item_id.'"');?></td>
			<td><?=find_a_field('item_info','item_name','item_id="'.$data->item_id.'"');?></td>
			
				<td style="text-align:right;"><?=number_format($data->total_unit,2);?></td>
				<td><?=find_a_field('item_info','unit_name','item_id="'.$data->item_id.'"');?></td>
					<td style="text-align:right;"><?=$data->unit_price;?></td>
				<td style="text-align:right;"><?=number_format($data->total_amt,2);?></td>
			</tr>
			<?php 
			$total_qty+=$data->total_unit;
			$total_amt+=$data->total_amt;
			 } ?>
			<tr>
				<td colspan="2" ><strong>Sub Total</strong></td>
				<td style="font-weight:bold;text-align:right;" > <?=number_format($total_qty,2);?></td>
				<td></td>
				<td></td>
				<td style="font-weight:bold;text-align:right;"> <?=number_format($total_amt,2)?></td>
			</tr>
				<tr>
				<td colspan="5"><strong>Discount</strong></td>
		
				<td style="font-weight:bold;text-align:right;"> <?=number_format($disc_amt=(($total_amt*$discount)/100),2)."  (".$discount."%  )";?></td>
			</tr>
				<tr>
				<td colspan="5"><strong>VAT (<?php echo $vat." %";?>)</strong></td>
		
				<td style="font-weight:bold;text-align:right;"> <? if($vat>0) { echo number_format($vat_amt=(($total_amt*$vat)/100),2);} else{ echo $vat_amt= $vat_amt_tk."  (taka)";}
				
				?></td>
			</tr>
				<tr>
				<td colspan="5"><strong> Grand Total</strong></td>
		
				<td style="font-weight:bold;text-align:right;"> <?php $gr_tot=($total_amt+$vat_amt)-$disc_amt;
			echo	number_format($gr_tot,2);
				?></td>
			</tr>
		</tbody>
	</table>
	
	
	<br><br>
	
	<tr>

    <td class="tabledesign_text"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        

        <td align="center" valign="bottom"><b><?=find_a_field('user_activity_management','fname','user_id='.$do_all->entry_by);?></b></td>

		<td align="center" valign="bottom"><b><?=find_a_field('user_activity_management','fname','user_id='.$do_all->acc_check);?></td>

        <td align="center" valign="bottom"><b><?php echo find_a_field('user_activity_management','fname','user_id='.$do_all->new_verify);?></b></td>
		
		<td align="center" valign="bottom"><b><?php echo find_a_field('user_activity_management','fname','user_id='.$do_all->approved_by);?></b></td>

      </tr>

      <tr>

	    <td><div align="center">Prepared by </div></td>


        <td><div align="center">Checked By</div></td>


        <td><div align="center">Verify By</div></td>
		
		<td><div align="center">Approved By</div></td>

      </tr>

    </table></td>

  </tr>
	
	
  
  </div>
  
  
  </div>
  


</body>
</html>

