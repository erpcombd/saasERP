<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$pr_no 		= url_decode(str_replace(' ', '+', $_REQUEST['v_no']));


$group_data = find_all_field('user_group','group_name','id='.$_SESSION['user']['group']);




$datas=find_all_field('purchase_receive','s','pr_no='.$pr_no);
$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);


$master= find_all_field('purchase_master','*','po_no="'.$datas->po_no.'"');

$tr_no= find_a_field('vendor_invoice_master','system_invoice_no','grn_no="'.$pr_no.'"');


$jv_all=find_all_field('secondary_journal','','tr_from in ("vendor_invoice_receive", "service_bill") and tr_no='.$tr_no);

$tr_type="Show";

$sql1="select b.* from purchase_receive b where b.pr_no = '".$pr_no."'";

$data1=db_query($sql1);

$pi=0;

$total=0;

while($info=mysqli_fetch_object($data1)){ 

$pi++;

$rec_date=$info->rec_date;

$rec_no=$info->rec_no;

$po_no=$info->po_no;

$sale_no=$info->sale_no;

$order_no[]=$info->order_no;

$truck_no=$info->truck_no;

$ch_no=$info->ch_no;

$qc_by=$info->qc_by;

$remarks=$info->remarks;

$entry_at=$info->entry_at;

$entry_by=$info->entry_by;

$item_id[] = $info->item_id;

$rate[] = $info->rate;

$amount[] = $info->amount;
$rec_no=$info->rec_no;

$garden[]=find_a_field('tea_garden','garden_name','garden_id='.$info->garden_id);

$shed[]=find_a_field('tea_warehouse','warehouse_nickname','warehouse_id='.$info->shed_id);

$lot_no[]=$info->lot_no;

$invoice_no[]=$info->invoice_no;

$liquor_mark[]=$info->quality;

$pkgs[]=$info->pkgs;

$tpkgs+=$info->pkgs;

$sam_pay[]=$info->sam_pay;

$sam_qty[]=$info->sam_qty;

$secondary_carton=find_a_field('item_info','carton_qty','item_id='.$info->item_id);
         if ($secondary_carton > 0)
		 $ctnyy[]=$info->qty/$secondary_carton;

$unit_qty[] = $info->qty;

$tot_unit_qty+= $info->qty;

$unit_name[] = $info->unit_name;

}

$ssql = 'select a.* from vendor a, purchase_master b where a.vendor_id=b.vendor_id and b.po_no='.$po_no;

$dealer = find_all_field_sql($ssql);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Cash Memo :.</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  
<script type="text/javascript">
	function hide()
	{
		document.getElementById("pr").style.display="none";
		document.getElementById("pr1").style.display="none";
	}
</script>

<style>

table.table-bordered > thead > tr > th{
  border:1px solid black;
  font-size:12px;
}
table.table-bordered > tbody > tr > td{
  border:1px solid black;
    font-size:12px;
}

   .mb-3{
margin-bottom:4px!important;
}
.input-group-text{
font-size:12px;
}
      * {
    margin: 0;
    padding: 0;
	font-size:13px;
  }
  p {
    margin: 0;
    padding: 0;
  }
  h1,
  h2,
  h3,
  h4,
  h5,
  h6
   {
    margin: 0 !important;
    padding: 0 !important;
  }
  

#pr input[type="button"] {
	width: 70px;
	height: 25px;
	background-color: #6cff36;
	color: #333;
	font-weight: bolder;
	border-radius: 5px;
	border: 1px solid #333;
	cursor: pointer;
}
    </style>
</head>

<body style="font-family:Tahoma, Geneva, sans-serif">

<div class="container">
	<div class="row">
	
		<div class="col-2 text-center">
			<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png"  width="100%" />
		</div>
		
		<div class="col-8 text-center">
			<h1 style="font-family:tahoma;"><?=$group_data->group_name?> </h1>
			<!--<span><h5 style="letter-spacing:1px;">Quality product at affordable cost</h5></span>-->
			
			<?=$group_data->address?><br>
			Cell: <?=$group_data->mobile?>. Email: <?=$group_data->email?> <br> <?=$group_data->vat_reg?>
		</div>
		<div class="col-2"></div>
	</div>
	
	   <div class="text-center" >
              <button class="btn btn-default outline border rounded-pill border border-dark  text-black "><h4 style="font-size:15px;font-weight:bold; margin:0 auto;">GOODS RECEIVE NOTE</h4></button>
            </div><br />
	<div class="row">
      <div class="col-6">
		    
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">GRN No: </span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly" value="<?php echo $pr_no;?>">
			</div>
			 
			 		<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">GRN Date</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly" value="<?=$rec_date?>">
			</div>
				
			
			
			
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;"> Supplier :</span>
			  </div>
			   <input type="text" disabled class="form-control" id="no" value="  <?php echo $dealer->vendor_name;?>">
			</div>
			
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">VAT</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly" value="<?=$master->vat?>">
			</div>
			
			
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">TAX</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly" value="<?=$master->tax?>">
			</div>
			
					
			
			 
			<div id="pr">
			  <div align="left">
					<input name="button" type="button" onclick="hide();window.print();" value="Print" />
			  </div>
		    </div>

			
		  </div>
		  <div class="col-6">
		    

			
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">PO No:</span>
			  </div>
			  <?php 
			  $po_all=find_all_field('purchase_master','','po_no="'.$po_no.'"');
			  $req_all=find_all_field('requisition_master','','req_no="'.$po_all->req_no.'"');
			  ?>
			   <input type="text" disabled class="form-control" id="no" value=" <?php echo $po_no;?>">
			</div>
			
	<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">PO Date</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly" value="<?=$po_all->po_date?>">
			</div>
			
			
			
				
			
			
				<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">QC By: </span>
			  </div>
			  <input type="text" disabled class="form-control" id="no" value="<?php echo $qc_by;?>">
			</div>
			
			
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Supplier Challan No: </span>
			  </div>
			  <input type="text" disabled class="form-control" id="ch_no" value="<?php echo $ch_no;?>">
			</div>
			
		
		<table id="pr1" cellpadding="3" >
			



</tr>

<tr>
<td align="right">Purchase Order: </td>
<td><a href="../../../../app/views/purchase_mod/po/po_print_view_store.php?po_no='<?=url_encode($po_no); ?>'" target="_blank"><?=$po_no; ?></a></td>
</tr>
			
			
			</table>
			
		  </div>
              
            </div>
			
			
			  <tr> <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  	<tr height="30">
  	  <td width="25%" valign="top"></td>
  	  <td width="50%"  style="text-align:center; color:#FFF; font-size:18px; padding:0px 0px 10px 0px; color:#000000; font-weight:bold;"><span style="text-decoration:underline">TRANSACTION DETAILS</span> </td>
  	  <td width="25%" align="right" valign="right">&nbsp;</td>
	  </tr>
  </table>
  
  </td></tr>
  
  
  <tr> <td>&nbsp;</td></tr>

  

      

<table  class="table table-bordered table-condensed">
		<thead>
			<tr>
				<th>SL</th>
				<th class="w-8">Item Code</th>
				<th>Item Name/Discription/Note</th>
				<th>UOM</th>
				<th>Quantity</th>
				<th>Unit Price</th>
				<th>Amount</th>
			</tr>
		</thead>
       
		<tbody>
		<?php
			$final_amt=0;
			$pi=0;
			$total=0;
			$sql2="select * from purchase_invoice where po_no='$po_no'";
			$data2=db_query($sql2);
			//echo $sql2;
			while($info=mysqli_fetch_object($data2)){
			$pi++;
			$amount=$info->qty*$info->rate;
			$total=$total+($info->qty*$info->rate);
			$supplementary_duty_amt=(($total*$data->supplementary_duty)/100);
			$net_total= ($total+$supplementary_duty_amt);
			$sl=$pi;
			//$item=find_a_field('item_info','concat(item_name," ; ",	item_description)','item_id='.$info->item_id);
			$item=find_a_field('item_info','concat(item_name)','item_id='.$info->item_id);
			$item_code=find_a_field('item_info','finish_goods_code','item_id='.$info->item_id);
			$fg_code=find_a_field('item_info','concat(finish_goods_code)','item_id='.$info->item_id);
			$sku_code=find_a_field('item_info','concat(sku_code)','item_id='.$info->item_id);
			$qty=$info->qty;
			$unit_name=find_a_field('item_info','concat(unit_name)','item_id='.$info->item_id);
			$rate=$info->rate;
			$disc=$info->disc;
		?>
		
			<tr>
				<td style="text-align:center;"><?=$sl?></td>
				<td style="text-align:center;"><?=$item_code?></td>
				<td><?=$item?></td>
				<td style="text-align:center;"><?=$unit_name?></td>
				<td style="text-align:right;"><?=$qty?></td>
				<td style="text-align:right;"><?=number_format($rate,2)?></td>
				<td style="text-align:right;"><?=number_format($amount,2)?></td>
			  </tr>
		<? 
		 $total_pcs +=$info->total_unit;

 $total_amt +=$info->amount;
 
  $total_amt_withvat +=$info->with_vat_amt;
  
  
  $vat_amtt += $info->vat_amt;
 $tax_amtt += $info->tax_amt;
 
 $with_vat_amt = $info->with_vat_rate*$info->qty;
  $tot_with_vat_amt += $with_vat_amt;
  
   $tot_with_grandd_amt += $info->grand_amount;
		
		}?>
		
		
		
			  <tr>
				<td align="right" colspan="4" style="text-align:right;"><strong>Sub Total(BDT):</strong></td>
				<td align="right" style="text-align:right;"><strong><?php echo number_format($total,2);?></strong></td>
				<td></td>
				<td align="right" style="text-align:right;"><strong><?=number_format($total_amt_withvat,2);?></strong></td>
			  </tr>
			  <? if($master->cash_discount>0) {?>
			  <tr  align="right">
				<td colspan="6" style="text-align:right;"><strong>Discount(%) (<?=number_format($master->cash_discount,2)?>%):</strong></td>
				<td align="right" style="text-align:right;"><strong>
				  <?  echo number_format($discount_total=(($total*$master->cash_discount)/100),2);?>
				</strong></td>
			  </tr>
			  <? }?>
			  <? if($master->vat>0) {?>
			  <tr  align="right">
				<td colspan="6" style="text-align:right;"><strong>VAT (<?=number_format($master->vat,2)?>%):</strong></td>
				<td align="right" style="text-align:right;"><strong>
				  <?  echo number_format($vat_amtt,2);?>
				</strong></td>
			  </tr>
			  <? }?>
			   <? if($master->tax>0) {?>
			  <tr  align="right">
				<td colspan="6" style="text-align:right;"><strong>Tax (<?=number_format($master->tax,2)?>%):</strong></td>
				<td align="right" style="text-align:right;"><strong>
				  <?  echo number_format($tax_amtt,2);?>
				</strong></td>
			  </tr>
			  <? }?>
			  <? if($master->ait>0) {?>
			  <tr  align="right">
				<td colspan="6" style="text-align:right;"><strong>Ait(%) (<?=number_format($master->ait,2)?>%):</strong></td>
				<td align="right" style="text-align:right;"><strong>
				  <?  echo number_format($ait_total=(($total*$master->ait)/100),2);?>
				</strong></td>
			  </tr>
			  <? }?>
			  
			  
			  
			  
			  <tr >
				<td   align="right" colspan="6" style="text-align:right;"><strong>Net Amount(BDT): </strong></td>
				<td align="right" style="text-align:right;"><strong>
				
				<?
if($master->deductible == "Yes"){
echo number_format($payable_amount=($tot_with_grandd_amt-$vat_amtt),2);
}else{
echo number_format($payable_amount=($tot_with_grandd_amt),2);
}
?>
				
				<? //echo number_format($payable_amount=($tot_with_vat_amt+$vat_amtt),2);?>
				
				
				</strong></td>
				
				
			  </tr>
			  
		
			</tbody>
		
    </table>
	
	
				  <tr> <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  	<tr height="30">
  	  <td width="25%" valign="top"></td>
  	  <td width="50%"  style="text-align:center; color:#FFF; font-size:18px; padding:0px 0px 10px 0px; color:#000000; font-weight:bold;"><span style="text-decoration:underline">Journal After GRN</span> </td>
  	  <td width="25%" align="right" valign="right">&nbsp;</td>
	  </tr>
  </table>
  
  </td></tr>
  
	
	
	
	
	<table class="table table-bordered table-condensed">
      <tr>
        <td align="center"><div align="center">SL</div></td>
        <td align="center">A/C Ledger Head</td>
        <td align="center">Sub Ledger</td>
        <td align="center">Particulars</td>
        <td>Debit</td>
        <td>Credit</td>
      </tr>
      
	  <?
	  //////////sub ledger name////////
  $ssql='select * from general_sub_ledger where 1 group by sub_ledger_id';
	  $squery=db_query($ssql);
	  while($srow=mysqli_fetch_object($squery)){
	  $sub_ledger_name_get[$srow->sub_ledger_id]=$srow->sub_ledger_name;
	  }
	  
   $sql2="SELECT a.ledger_id,a.ledger_name,sum(dr_amt) as dr_amt, a.ledger_group_id, b.narration,b.sub_ledger FROM accounts_ledger a, secondary_journal b where b.tr_no='$pr_no' and a.ledger_id=b.ledger_id and tr_no=$pr_no and dr_amt>0 group by b.ledger_id , b.sub_ledger order by dr_amt desc";
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){		  
	  ?>
      <tr>
        <td align="left"><div align="center">
          <?=++$s;
		  ?>
        </div></td>
        <td align="left">
		<?=$info->ledger_name?>
		
		</td>
        <td align="left"><?=$sub_ledger_name_get[$info->sub_ledger]?></td>
        <td align="left"><?=$info->narration?></td>
        <td align="right"><? echo number_format($info->dr_amt,2); $ttd = $ttd + $info->dr_amt;?></td>
        <td align="right"><? echo number_format($info->cr_amt,2); $ttc = $ttc + $info->cr_amt;?></td>
        </tr>
<?php }?>
<?
	
  $sql2="SELECT a.ledger_id,a.ledger_name,sum(cr_amt) as cr_amt, a.ledger_group_id, b.narration,b.sub_ledger FROM accounts_ledger a, secondary_journal b where b.tr_no='$pr_no' and a.ledger_id=b.ledger_id and tr_no=$pr_no and cr_amt>0 group by b.ledger_id, b.sub_ledger order by cr_amt desc ";
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){	
 
	  ?>
      <tr>
        <td align="left"><div align="center">
          <?=++$s;?>
        </div></td>
        <td align="left"><?

       echo $info->ledger_name;

		//$ggrp = explode('>',$grp_name );

		//echo $ggrp[1];

		?></td>
        <td align="left"><?=$sub_ledger_name_get[$info->sub_ledger]?></td>
        <td align="left"><?=$info->narration?></td>
        <td align="right"><? echo number_format($info->dr_amt,2); $ttd = $ttd + $info->dr_amt;?></td>
        <td align="right"><? echo number_format($info->cr_amt,2); $ttc = $ttc + $info->cr_amt;?></td>
        </tr>
<?php }?>





      <tr>
        <td colspan="4" align="right">Total : </td>
        <td align="right"><?=number_format($ttd,2)?></td>
        <td align="right"><?=number_format($ttc,2)?></td>
        </tr>
      
    </table>
	
	
	
	
	
				  <tr> <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  	<tr height="30">
  	  <td width="25%" valign="top"></td>
  	  <td width="50%"  style="text-align:center; color:#FFF; font-size:18px; padding:0px 0px 10px 0px; color:#000000; font-weight:bold;"><span style="text-decoration:underline">Journal After Bill Receive</span> </td>
  	  <td width="25%" align="right" valign="right">&nbsp;</td>
	  </tr>
  </table>
  
  </td></tr>
  
  
  
  
  
 <table class="table table-bordered table-condensed">
      <tr>
        <td align="center"><div align="center">SL</div></td>
        <td align="center">Control Head</td>
        <td align="center">A/C Ledger Head</td>
        <td align="center">Sub Ledger</td>
        <td align="center">Particulars</td>
        <td>Debit</td>
        <td>Credit</td>
      </tr>
      
	  <?
$sql2="SELECT a.ledger_id,a.ledger_name,b.sub_ledger,sum(dr_amt) as dr_amt, a.ledger_group_id, b.narration FROM accounts_ledger a, secondary_journal b where b.jv_no='$jv_no' and a.ledger_id=b.ledger_id and jv_no='$jv_all->jv_no' and b.tr_from='$jv_all->tr_from' and dr_amt>0 group by b.ledger_id order by dr_amt desc";
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){	
 $sub_ledger = find_a_field('general_sub_ledger','sub_ledger_name','sub_ledger_id="'.$info->sub_ledger.'"');	  
	  ?>
      <tr>
        <td align="left"><div align="center">
          <?=++$s;
		  ?>
        </div></td>
        <td align="left"><?

       $grp_name=find_a_field('ledger_group','group_name','group_id='.$info->ledger_group_id);

		//$ggrp = explode('>',$grp_name );

		//echo $ggrp[1];

		?>		</td>
        <td align="left"><?=$info->ledger_name?></td>
        <td align="left"><?=$sub_ledger?></td>
        <td align="left"><?=$info->narration?></td>
        <td align="right"><? echo number_format($info->dr_amt,2); $ttd2 = $ttd2 + $info->dr_amt;?></td>
        <td align="right"><? echo number_format($info->cr_amt,2); $ttc2 = $ttc2 + $info->cr_amt;?></td>
        </tr>
<?php }?>
<?
$sql2="SELECT a.ledger_id,a.ledger_name,b.dr_amt,b.cr_amt, a.ledger_group_id,b.sub_ledger, b.narration FROM accounts_ledger a, secondary_journal b where b.jv_no='".$jv_all->jv_no."' and a.ledger_id=b.ledger_id and b.tr_from='$jv_all->tr_from' order by b.dr_amt desc";
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){	
$sub_ledger = find_a_field('general_sub_ledger','sub_ledger_name','sub_ledger_id="'.$info->sub_ledger.'"');		  
	  ?>
      <tr>
        <td align="left"><div align="center">
          <?=++$s;?>
        </div></td>
        <td align="left"><?

       echo $grp_name=find_a_field('ledger_group','group_name','group_id='.$info->ledger_group_id);

		//$ggrp = explode('>',$grp_name );

		//echo $ggrp[1];

		?></td>
        <td align="left"><?=$info->ledger_name?></td>
        <td align="left"><?=$sub_ledger?></td>
        <td align="left"><?=$info->narration?></td>
        <td align="right"><? echo number_format($info->dr_amt,2); $ttd2 = $ttd2 + $info->dr_amt;?></td>
        <td align="right"><? echo number_format($info->cr_amt,2); $ttc2 = $ttc2 + $info->cr_amt;?></td>
        </tr>
<?php }?>





      <tr>
        <td colspan="5" align="right">Total : </td>
        <td align="right"><?=number_format($ttd2,2)?></td>
        <td align="right"><?=number_format($ttc2,2)?></td>
        </tr>
      
    </table>
	
	
	
	
	
	
				  <tr> <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  	<tr height="30">
  	  <td width="25%" valign="top"></td>
  	  <td width="50%"  style="text-align:center; color:#FFF; font-size:18px; padding:0px 0px 10px 0px; color:#000000; font-weight:bold;"><span style="text-decoration:underline">Stock Details</span> </td>
  	  <td width="25%" align="right" valign="right">&nbsp;</td>
	  </tr>
  </table>
  
  </td></tr>	
	
	
	
 <tr>

    <td>	
	
	
<table width="100%" class="table table-bordered table-condensed" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px" >

      <tr>
		<th rowspan="2" bgcolor="#a7d6ff" style="text-align:center" >S/L</th>
		<th rowspan="2" bgcolor="#a7d6ff" style="text-align:center" >Date</th>
		<th rowspan="2" bgcolor="#a7d6ff" style="text-align:center" >Item Name</th>
		<th rowspan="2" bgcolor="#a7d6ff" style="text-align:center" >SR No</th>
		<th colspan="1" bgcolor="#99CC99" style="text-align:center">OPENING BALANCE</th>
		<th colspan="2" bgcolor="#339999" style="text-align:center">PRODUCT RECEIVED</th>
		<th colspan="2" bgcolor="#FFCC66" style="text-align:center">PRODUCT ISSUED</th>
		<th colspan="1" bgcolor="#FFFF99" style="text-align:center">CLOSING BALANCE</th>>
		</tr>
		<tr>
		<th bgcolor="#99CC99" style="text-align:center">Qty</th>

		<th bgcolor="#339999" style="text-align:center">Tr Type</th>
		<th bgcolor="#339999" style="text-align:center">Qty</th>
		<th bgcolor="#FFCC66" style="text-align:center">Tr Type</th>
		<th bgcolor="#FFCC66" style="text-align:center">Qty</th>
		<th bgcolor="#FFFF99" style="text-align:center">Qty</th>
		</tr>
      

	  <?

echo $op_sql = 'select item_id,sum(item_in-item_ex) as opening from journal_item where ji_date<="'.$$datas->rec_date.'" and entry_at<"'.$datas->entry_at.'" and warehouse_id="'.$datas->warehouse_id.'" group by item_id';
$op_qry = db_query($op_sql);
while($data=mysqli_fetch_object($op_qry)){
$op_stock[$data->item_id] = $data->opening;
}
$sql2="SELECT sum(c.qty) as qty,c.pr_no,i.item_name,i.item_id,c.rec_date from purchase_receive c, item_info i where c.item_id=i.item_id and c.pr_no=".$pr_no." group by c.item_id";
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){
$opening = $op_stock[$info->item_id];	  
$stock = $opening - $info->qty;
	  ?>

      <tr>

        <td align="left"><div align="center">

          <?=++$s;?>

        </div></td>

        <td align="left"><?=$info->rec_date?></td>
 <td align="left"><?=$info->item_name?></td>
        <td align="left"><?=$info->pr_no?></td>

        <td align="right"><? echo number_format($opening,2); $ttdd = $ttdd + $opening;?></td>

        <td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"><? echo number_format($info->qty,2); $ttcc = $ttcc + $info->qty;?></td>
		<td align="right"><? echo number_format($stock,2); $ttcc = $ttcc + $stock ;?></td>

        </tr>

<?php }?>

    </table>
	
	      </td>
  </tr>
  
	
	
	
	
	
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td colspan="2" style="font-size:12px"><em>All goods are received in a good condition as per Terms</em></td>
    </tr>
    </table>
	
	<br /><br />
	<div class="row">
 			<div class="col-1"></div>
              <div class="col-2 text-center">
               <b><?php 
			   $qc_all=find_a_field('qc_receive_purchase','qc_by','qc_no="'.$datas->qc_no.'"');
			  echo find_a_field('user_activity_management','fname','user_id="'.$datas->entry_by.'"');?></b>
                <br>
               <p style="border-top:1px solid"> Received By </p>
                
              </div>
			  
			  <div class="col-1"></div>
              <div class="col-2 text-center">
               <b><?php 
			   	  echo find_a_field('user_activity_management','fname','user_id="'.$qc_all.'"');
			   ?></b>
                <br>
               <p style="border-top:1px solid"> Quality Controller </p>
                
              </div>
			  
			  	<div class="col-1"></div>
              <div class="col-2 text-center">
               <b><?php echo find_a_field('user_activity_management','fname','user_id="'.$datas->post_pur_verify.'"');?></b>
                <br>
               <p style="border-top:1px solid"> Store Manager </p>
                
              </div>
			  	<div class="col-1"></div>
              <div class="col-2 text-center">
               <b>&nbsp;</b>
                <br>
               <p style="border-top:1px solid"> Authorized By </p>
                
              </div>
	
			  <?
$page_name="PO Print View";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>
            </div>

</div>
</body>

</html>

