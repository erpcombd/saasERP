<?php 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



 $po_no = url_decode(str_replace(' ', '+', $_REQUEST['po_no']));


	$req_bar_no = $po_no;
	$barcode_content = $req_bar_no;
	$barcodeText = $barcode_content;
    $barcodeType='code128';
	$barcodeDisplay='horizontal';
    $barcodeSize=40;
    $printText='';


$group_data = find_all_field('user_group','group_name','id='.$_SESSION['user']['group']);
$master= find_all_field('purchase_master','','po_no='.$po_no);
$vendor_all= find_all_field('vendor','*','vendor_id='.$master->vendor_id);
$tr_type="Show";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Invoice View</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>
	
	 <style>
    @page {
      size: A4;
	  margin: 1cm; 
      @bottom-center {
        content: "Page " counter(page) " of " counter(pages);
      }
	  	 @media print {
	  	  .body {
      transform: scale(0.7) !important; 
      transform-origin: top left !important; 
	  }
    }
  </style>
</head>

<body >
  
<div class="body" id="printContent" >
	<div class="header">
		<table class="table1">
		<tr>
		<td class="logo">
			<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" class="logo-img"/>
		</td>
		
		<td class="titel">
				<h2 class="text-titel"> <?=$group_data->group_name?> </h2>			
				<p class="text"><?=$group_data->address?></p>
				<p class="text">Cell: <?=$group_data->mobile?>. Email: <?=$group_data->email?> <br> <?=$group_data->vat_reg?></p>
		</td>
		
		
		<td class="Qrl_code">
					<?='<img class="barcode Qrl_code_barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
			<p class="qrl-text"><?php echo $master->po_no;?></p>
		</td>
		
		</tr>
		 
		</table>
	</div>
	
	<div class="header-one">
	<hr class="hr"/>
		<h5 class="report-titel">PURCHASE ORDER</h5>
	<br>


	<div class="row">

		<div class="col-md-6 col-sm-6 col-lg-6 left">
			<p class="left-text">Purchase Order Date: <span><?php echo $master->po_date;?></span></p>
			<p class="left-text">Purchase Order No: <span><?php echo $master->po_no;?></span></p>
			<p class="left-text">Name Of Supplier: <span><?php echo find_a_field('vendor','vendor_name','vendor_id="'.$master->vendor_id.'"');?></span></p>
			<p class="left-text">Account Name: <span><?php echo $vendor_all->beneficiary_name;?></span></p>
			<p class="left-text">Delivery Place: <span><?php echo find_a_field('vendor','address','vendor_id="'.$master->vendor_id.'"');?></span></p>
	<!--		
			<p class="left-text">Purchase Requisition No: <span> <?php echo $master->req_no;?></span></p>
			<p class="left-text">Estimated Delivery Date: <span> <?php echo $master->estimated_delivery_date;?></span></p>-->
			
			 

		</div>

		<div class="col-md-6 col-sm-6 col-lg-6 right">

			<p class="right-text">Section: <span><?php //echo $master->quotation_no;?>  </span></p>
			<p class="right-text">Indent No: <span> <?php echo $master->req_no;?></span></p>
				<p class="right-text">Delivery Time: <span> <?php echo $vendor_all->delivery_time;?></span></p>
				<p class="right-text">Payment Method: <span> <?php echo $vendor_all->payment_mode;?></span></p>
				<p class="right-text">Terms Of Payment: <span> <?php echo $vendor_all->term_condition;?></span></p>
			
	 
			
			 
		</div>
	</div>


	<p class="p-text">
		We are pleased to place order upon you to supply us the following items as per terms and conditions mention below:
	</p>	

</div>


<div class="main-content">
	
	
		<div id="pr">
        <div align="left">
          <p>
            <input name="button" type="button" onClick="hide();window.print();" value="Print" />
          </p>
          <nobr>
          <!--<a href="chalan_bill_view.php?v_no=<?=$_REQUEST['v_no']?>">Bill</a>&nbsp;&nbsp;--><!--<a href="do_view.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank"><span style="display:inline-block; font-size:14px; color: #0033FF;">Bill Copy</span></a>-->
          </nobr>
		  <nobr>
          <!--<a href="chalan_bill_distributor_vat_copy.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank">Vat Copy</a>-->
          </nobr>	    
		  </div>
      </div>
	  
	  
	  
	  
	  
	  
	<table class="table1">
		<thead>
			<tr>
				<th>SL</th>
				<th class="w-8">Item Code</th>
				<th>Item Name/Discription/Note</th>
				<th>UOM</th>
				<th>Quantity</th>
				<th>Rate</th>
				<th>Amount</th>
			<!--	<th>Unit Price  <? if($master->vat_include == 'Including'){echo $master->vat_include;} else{ echo $master->vat_include;} ?> VAT</th>		
				<th>Amount  <? if($master->vat_include == 'Including'){echo $master->vat_include;} else{ echo $master->vat_include;} ?> VAT</th>
			</tr>-->
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
	<!--			<td style="text-align:right;"><?=number_format($info->with_vat_rate,3);?></td>
				
				<td style="text-align:right;"><?=number_format($info->with_vat_amt,3);?></td>-->
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
			  <td colspan="5"><b>Terms & Conditions.</b></td>
				<td align="right"  style="text-align:right;"><strong>Total(BDT):</strong></td>
				<td align="right" style="text-align:right;"><strong><?php echo number_format($total,2);?></strong></td>
				<!--<td></td>
				<td align="right" style="text-align:right;"><strong><?=number_format($total_amt_withvat,2);?></strong></td>-->
			  </tr>
			  <? //if($master->cash_discount>0) {?>
			  <tr  >
			  		  <td colspan="5">1)All Items must be new and exactly as per specification.</td>
				<td   style="text-align:right;"><strong>Discount(%) (<?=number_format($master->cash_discount,2)?>%):</strong></td>
				<td align="right" style="text-align:right;"><strong>
				  <?  echo number_format($discount_total=(($total*$master->cash_discount)/100),2);?>
				</strong></td>
 </tr>
			  <? //}?>
			    <tr  >
				 <td colspan="5">2)Rejected/Short Quantity Goods to be replaced by supplier's own cost.</td>
				<td   style="text-align:right;"><strong>Sub Total:</strong></td>
					<td align="right" style="text-align:right;"><strong>
				  <?=number_format($sub_total=$total-$discount_total,2)?>
				</strong></td>
				</tr>
				
							  <tr  >
							   <td colspan="5">3)Challan along with goods to be given at the time of delivery.</td>
				<td  style="text-align:right;"><strong>Carring/Loading:</strong></td>
				<td align="right" style="text-align:right;"><strong>
				  <?php  
				  $carring_charge = (float) $master->transport_bill; 
echo number_format($carring_charge, 2);

				   // $master->transport_bill;
				 // echo number_format($carring_charge=$master->transport_bill,2); ?>
				</strong></td>
 </tr>
 							  <tr  >
							     <td colspan="5">4)Warranty Period: N/A</td>
				<td  style="text-align:right;"><strong>Grand Total:</strong></td>
				<td align="right" style="text-align:right;"><strong>
				  <?  echo number_format($payable_amount=( $sub_total+$carring_charge),2);?>
				</strong></td>
 </tr>
 <tr >
							     <td colspan="5">5)VAT: <?php echo $master->VAT;?></td>
				<td  style="text-align:right;"><strong></strong></td>
				<td align="right" style="text-align:right;"><strong>
				 
				</strong></td>
 </tr>
 <tr >
							     <td colspan="5">6)AIT: <?php echo $master->ait;?></td>
				<td  style="text-align:right;"> </strong></td>
				<td align="right" style="text-align:right;"><strong>
			 
				</strong></td>
 </tr>
				
			 
			  
			  
			  
			  
			   
			  
		
			</tbody>
		
    </table>
	

	<p class="p bold">In Words : 
		<? $scs =  $payable_amount;
					$credit_amt = explode('.',$scs);
	
		 if($credit_amt[0]>0){
		  echo convertNumberToWordsForIndia($credit_amt[0]);}
	
			 if($credit_amt[1]>0){
			 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;
			 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' Paisa ';
								 }
		  echo ' Only.';

		?> 
		</p>
	
	<table>
	<tr <?=($sl%20==0)? 'class="page-break"' : '' ?> >
	</tr>
	</table>
	
	
	
<!--
<p class="p-text"> The Vendor has agreed to provide the above goods/services to <?=$group_data->group_name?> agreed to accept the merchandise from the Vendor in the quantities, at the prices, at the time and subject to the terms, provisions and conditions stated below: <p>-->


	 
	 
	
</div>

<?

 $res_approval_member = '
SELECT a.*,u.fname,am.layer_name,am.signatory_tittle FROM approval_matrix_history a JOIN user_activity_management u ON a.approved_by=u.user_id JOIN approval_matrix_layer_setup am ON a.approval_level=am.layer_level  WHERE a.tr_no = "'.$po_no.'" and a.tr_from="Purchase" and a.status="1" ORDER BY a.approval_level DESC;
';



$query_approval_member=db_query($res_approval_member);
$query_approval_member2=db_query($res_approval_member);
$query_approval_member3=db_query($res_approval_member);



?>


	 
<div class="footer"  id="footer">
	<table class="footer-table">
        <tr>
          <td colspan="4">&nbsp;</td>
        </tr>

        <tr>
          <td class="text-center w-20">
		  <p style="font-weight:600; margin: 0;"> <?=find_a_field('user_activity_management','fname','user_id='.$master->entry_by);?> </p>
		  <p style="font-size:11px; margin: 0;">(<?=find_a_field('user_activity_management','designation','user_id='.$master->entry_by);?>) <br/> <?=$master->entry_at?></p>
		  </td>
		  <?
		  While($row4=mysqli_fetch_object($query_approval_member3)){ 

		  ?>
          <td class="text-center w-20">

		  <p style="font-weight:600; margin: 0;"> <?=$row4->fname?> </p>
		  <p style="font-size:11px; margin: 0;">(<?=$row4->layer_name?>) <br/> <?=$row4->approved_at?></p>

		  </td>
		  <?}?>
          <!-- <td class="text-center w-25">&nbsp;</td>
          <td class="text-center w-25">&nbsp;</td> -->
        </tr>
        <tr>
          <td class="text-center">-------------------------------</td>
		  <?
		  While($row2=mysqli_fetch_object($query_approval_member)){ 

		  ?>
          <td class="text-center">-------------------------------</td>
		  <?}?>
           <td class="text-center">-------------------------------</td>
          <td class="text-center">-------------------------------</td> 
		      <td class="text-center">-------------------------------</td> 
        </tr>
        <tr>
          <td class="text-center"><strong>Prepared By</strong></td>
		  <?
		While($row3=mysqli_fetch_object($query_approval_member2)){ 
			

		  ?>

          <td class="text-center"><strong><?=$row3->signatory_tittle?></strong></td>
		  <? } ?>
           <td class="text-center"><strong>Reviewed By</strong></td>
          <td class="text-center"><strong>Verify By</strong></td> 
		   <td class="text-center"><strong>Approved By</strong></td> 
        </tr>
	</table>

	<?php include("../../../assets/template/report_print_buttom_content.php");?>
	  </div>
	  
	  
	  
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        // JavaScript for page number counting
        function updatePageNumber() {
            var pageNumberElement = document.getElementById('footer');
            var totalPages = document.querySelectorAll('.pagedjs_page').length;

            pageNumberElement.textContent = 'Page ' + window.pagedConfig.pageCount + ' of ' + totalPages;
        }

        // Call the updatePageNumber function when the page is loaded and after printing
        window.onload = updatePageNumber;
        window.onafterprint = updatePageNumber;
    </script>

<!-- <script>
        window.onload = function () {
            generatePDF();
        };

        function generatePDF() {
            const element = document.getElementById('printContent');

			element.style.width = '100%';
			

            html2pdf(element, {
				margin:5,
                filename: 'invoice.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 1, scrollX: 0, scrollY: 0 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            });
        }
</script> -->

</body>
</html>


<?
$page_name="PO Print View";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>