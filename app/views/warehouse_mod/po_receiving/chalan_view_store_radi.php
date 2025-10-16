<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$pr_no 		= $_REQUEST['v_no'];

$req_bar_no = $v_no;
	$barcode_content = $req_bar_no;
	$barcodeText = $barcode_content;
    $barcodeType='code128';
	$barcodeDisplay='horizontal';
    $barcodeSize=40;
    $printText='';
$group_data = find_all_field('user_group','group_name','id='.$_SESSION['user']['group']);

$datas=find_all_field('purchase_receive','s','pr_no='.$pr_no);
$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);


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
   <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
	 <?php include("../../../../public/assets/css/theme_responsib_new_table_report1.php");?>
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
  
	body {
    width: 1186px;
    margin: 0 auto;
    font-size: 16px;
}
@font-face {
  font-family: 'TradeGothicLTStd-Extended';
  src: url('TradeGothicLTStd-Extended.otf'); /* IE9 Compat Modes */

}

@media print {
	body{
		width:  100% !important;
		font-size: 18px !important;
	 }
}
  </style>
</head>
<body style="font-family: Poppins, serif;">

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <thead>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="2" border="0">
      <tr>
        <td width="20%" ><img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" class="logo-img"/></td>
        <td width="60%" align="center">
				<p style="font-size:28px; color:#000000; margin:0; padding: 0 0 5px 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"> <?=$group_data->group_name?> </p>			  
				<p class="text"><strong>Address: </strong><?=$group_data->address?></p>
				<p class="text"><strong>Cell:</strong> <?=$group_data->mobile?>. <strong>Email: </strong><i><?=$group_data->email?> </i><br><strong> <?=$group_data->vat_reg?> </strong></p>
		</td>
        <td class="qrl-text">
			<?='<img class="barcode Qrl_code_barcode mt-4" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
			<p style="font-size:12px; padding: 3px 25px 0px 0px; letter-spacing:7px;"><?php echo $pr_no;?></p>
		</td>
		
      </tr>
	 
    </table>      </td>
  </tr>
   <tr><td><hr class="hr  mt-1"/></td></tr>
  </thead>
  <tbody>
  <tr>
    <td>
	<table width="100%" cellspacing="0" cellpadding="2" border="0">
      <tr>
        <td>
		<h5 class=" text-center font-weight-bold mt-0 ml-0 mb-2 ">GOODS RECEIVE NOTE</h5>
		<!--<hr class="hr1 w-25">-->
		</td>
      </tr>
      <tr>
        <td><table width="100%" cellspacing="0" cellpadding="2" border="0" >
          <tr>
            <td width="35%">
				<table>
				<tr>
				<td width="32%">GRN No </td>
					<td width="68%"> : <?php echo $pr_no;?></td>
				</tr>
				<tr>
					<td width="32%">GRN Date </td>
					<td width="68%"> : <?=$rec_date?></td>
				</tr>
				<tr>
					<td>Requisition No</td>
					<td> : <?php echo !empty($req_all->req_no) ? $req_all->req_no: 'N/A';?></td>
				</tr>
				<tr>
					<td>Supplier</td>
					<td>: <?php echo $dealer->vendor_name;?></td>
				</tr>
				<tr>
					<td>Address</td>
					<td>: <?php echo $dealer->address;?></td>
				</tr>
				<tr>
					<td>Truck No</td>
					<td>: <?php echo !empty ($truck_no) ? $truck_no: 'N/A';?></td>
				</tr>
				
				</table>
			
				
				
            <td width="30%"></td>
            <td width="35%" >
				<table width="100%" cellspacing="0" cellpadding="2" border="0">
				
				<tr>
					<td width="35%">PO No</td>
					<td width="65%">:  <?php 
			  $po_all=find_all_field('purchase_master','','po_no="'.$po_no.'"');
			  $req_all=find_all_field('requisition_master','','req_no="'.$po_all->req_no.'"');
			  ?><?php echo $po_no;?></td>
				</tr>
				<tr>
					<td >PO Date</td>
					<td >: <?=$po_all->po_date?></td>
				</tr>
				<tr>
					<td >Requisition Date</td>
					<td>: <?php echo !empty($req_all->req_date) ? $req_all->req_date: 'N/A';?></td>
				</tr>
				<tr>
					<td>Manual Rec No</td>
					<td>: <?php echo $rec_no;?></td>
				</tr>
				<tr>
					<td>QC By</td>
					<td>: <?php echo !empty($qc_by) ? $qc_by: 'N/A';?></td>
				</tr>
				<tr>
					<td>S Challan No</td>
					<td>: <?php echo !empty($ch_no) ? $ch_no: 'N/A';?></td>
				</tr>
				
				</table>
			</td>
          </tr>

        </table>
		</td>
      </tr>
      
      <tr>
        <td>
		<div id="pr">
        <div align="left">
          <p>
            <input name="button" type="button" onClick="hide();window.print();" value="Print" />
          </p>	    
		  </div>
      </div>
		<table width="100%" cellspacing="1" cellpadding="2" border="1">
		<tr>
				<th class="text-center">SL</th>
				<th class="w-15 text-center">Item Code</th>
				<th colspan="2" class="w-40 ">Item Name</th>
				<th class="text-center">UOM</th>
				<th class="text-center">Received Qty</th>
				<!--<th class="text-center">Unit Price</th>
				<th class="text-center">Amount</th>-->
			</tr>
			
         <? for($i=0;$i<$pi;$i++){?>

     
     <tr>
				<td style="text-align:center;"><?=$i+1?></td>
				<td style="text-align:center;"><?=find_a_field('item_info','finish_goods_code','item_id='.$item_id[$i]);?></td>
				<td colspan="2"><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>
				<td class="text-center"><?=find_a_field('item_info','unit_name','item_id='.$item_id[$i]);?></td>
				<td class="text-right"><?php 
		echo $unit=number_format($unit_qty[$i],2)."<br>"; 
		 ?></td>
				
			  </tr>

<? }?>
        
        </table>
		</td>
      </tr>
    <?php /*?>  <tr>
        <td><p class="p bold mb-1 mt-1">In Words : 
		<? $scs =  $payable_amount;
					$credit_amt = explode('.',$scs);
	
		 if($credit_amt[0]>0){
		  echo convertNumberToWordsForIndia($credit_amt[0]);}
	
			 if($credit_amt[1]>0){
			 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;
			 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' Paisa ';
								 }
		  echo ' Only .';

		?> 
		</p></td>
      </tr><?php */?>
      <tr>
        <td >
		<table width="100%" cellspacing="0" cellpadding="7" border="1" class="mb-5 mt-3">
			<tr>
				<td><p class=" mb-1 ml-1 mt-1"><strong>Remarks: </strong>All goods are received in a good condition as per Terms</p>
				

			</tr>
		</table>
		</td>
      </tr>
      <?php /*?><tr>
         <td colspan="4" class="terms-titel">Terms &amp; Condition : </td>
      </tr>
	  
	  <tr>
		  <td>
			<table width="100%" cellspacing="0" cellpadding="2" border="0" class="teg">
			  <? $sql = 'select * from terms_condition_setup where type="PO" order by sl_no';
						$tc_query=db_query($sql);
						while($tc_data= mysqli_fetch_object($tc_query)){
				?>	
							  <tr style="letter-spacing:.3px; line-height: 22px;">
							  	 <td width="2%">&nbsp;</td>
								 <td width="1%"><?=$tc_data->sl_no;?>.</td>
								 <td width="18%"><?=$tc_data->category;?></td>
								 <td width="1%"> : </td>
								 <td width="78%"> <?=$tc_data->terms_condition;?></td>
								 
							  </tr>
							 
						   <? }?>
				</table>		  
			</td>
	   </tr><?php */?>

    </table>
	</td>
  </tr>
 
  
  <tr class="mb-20">
    <td >
	<table width="100%" cellspacing="0" cellpadding="2" border="0" style=" margin-bottom: 100px; margin-top:50px;">
      <tr>
        
		   
       
	
      </tr>
	   <tr>
          <td align="center" >---------------</td>
          <td align="center" >---------------</td>
		  <td align="center" >---------------</td>
		     <td align="center" >---------------</td>
          
        </tr>
        <tr>
          <td class="text-center"><strong>Received By</strong></td>
		 <td class="text-center"><strong>Quality Controller </strong></td>
		 	 <td class="text-center"><strong>Store Manager </strong></td>
			 	 <td class="text-center"><strong>Authorized By  </strong></td>
		 
         
		  
		
         
        </tr>
    </table>
	</td>
  </tr>
 </tbody>
  
</table>

   <?php include("../../../controllers/routing/report_print_buttom_content.php");?>
</body>
</html>