<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once ('../../../acc_mod/common/class.numbertoword.php');


$quotation_no 		= $_REQUEST['quotation_no'];

		  $req_bar_no = $quotation_no;
		  $barcode_content = $req_bar_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';
		  
$group_data = find_all_field('user_group','group_name','id='.$_SESSION['user']['group']);

$sql="select * from quotation_master where  quotation_no='$quotation_no'";
$data=db_query($sql);
$all=mysqli_fetch_object($data);

 $req_type=find_a_field('requisition_master','req_type','req_no='.$all->req_no);

$sub_depot_id=$all->sub_depot;
$group_for=$all->group_for;

$warehouse=find_all_field('warehouse','','warehouse_id='.$all->warehouse_id);

$grp=find_all_field('user_group','','id='.$_SESSION['user']['group']);

$vendor=find_all_field('vendor','','vendor_id='.$all->vendor_id);


$sub_ware=find_all_field('warehouse','warehouse_name','warehouse_id='.$all->sub_depot);

$sub_depot=$sub_ware->warehouse_name;

$address_depot=$sub_ware->address;

$delivery_spot=$sub_ware->delivery_spot;

$contect_p=$sub_ware->warehouse_company;
$contect_m=$sub_ware->contact_no;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Despatch Order Copy</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>
</head>

<body>

<div class="body">
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
			<p class="qrl-text"><?php echo $all->quotation_no;?></p>
		</td>
		
		</tr>
		 
		</table>
	</div>
	
	<div class="header-one">
	<hr class="hr">
		<h5 class="report-titel">PURCHASE QUOTATION</h5>
	<br>


	<div class="row">

		<div class="col-md-6 col-sm-6 col-lg-6 left">
			
			<p class="p bold">Quotation No : <span> <?php echo $all->quotation_no;?> </span></p>
			<p class="p bold">Quotation Date : <span> <?php echo date("d-m-Y",strtotime($all->quotation_date)); ?> </span></p>
			<p class="p bold">Requisition No: <span> <?php echo $all->req_no;?> </span></p>
			
			<div class="new-div">
				<p class="titel-text">CONSIGNOR</p>
				<p class="text1">Name : <span><?=$grp->group_name;?> </span></p>
				<p class="text1">Address : <span><?=$grp->address;?> </span></p>
				<p class="text1">Phone : <span><?=$grp->phone;?> </span></p>
				<p class="text1">E-mail : <span><?=$grp->email;?> </span></p>
			</div>

		</div>

		<div class="col-md-6 col-sm-6 col-lg-6 right">
		<br/><br/><br/>
			
			<div class="new-div">
				<p class="titel-text">SUPPLIER</p>

				<p class="text1">Name : <span><?=$vendor->vendor_name;?> </span></p>
				<p class="text1">Address : <span><?=$vendor->address;?> </span></p>
				<p class="text1">Phone : <span><?=$vendor->contact_no;?> </span></p>
				<p class="text1">E-mail : <span><?=$vendor->email;?> </span></p>

			</div>
		</div>
	</div>


<!--	<p class="p-text">
		Dear Sir/Madam,
			<br>
		We are pleased to issue Purchase Order for the following goods/services as per below mentioned terms &amp; conditions:
			<br>
	</p>-->	

</div>


<div class="main-content pt-3">
	
	
	<div id="pr">
        <div align="left">
         	 <p> <input name="button" type="button" onclick="hide();window.print();" value="Print"> </p>    
		</div>
     </div>
	  
	  
	  
	<table class="table1">
		<thead>
			<tr>
				<th>SL</th>
				<th>Product Name</th>
				<th>Unit</th>
				<th>Req Qty</th>
				<th>Quotation Price</th>
				<th>Remarks</th>
			</tr>
		</thead>
       
		<tbody>
				       
				  <?php
			$final_amt=(int)$data1[0];
			$pi=0;
			$total=0;
			$sql2="select * from quotation_detail where  quotation_no='$quotation_no'";
			$data2=db_query($sql2);
			//echo $sql2;
			while($info=mysqli_fetch_object($data2)){ 
			$pi++;
			
			$sl=$pi;
			$item=find_all_field('item_info','concat(item_name," : ",	item_description)','item_id='.$info->item_id);
			
			$ord_qty=$info->qty;
			$ord_bag=$ord_qty/$item->pakg_ctn_size;
			
			$in_stock=$info->in_stock;
			
			$tot_ord_qty +=$ord_qty;
			$tot_ord_bag +=$ord_bag;
			
			
			?>
				  <tr>
					<td align="center"><?=$sl?></td>
					<td align="left"><?=$item->item_name?></td>
					<td align="center"><?=$item->unit_name?></td>
					<td align="right"><?=number_format($ord_qty,2); $tot_ord_qty +=$ord_qty;?></td>
					<td align="right"><? if($req_type==2) {?> $ <? }?><?=$info->quotation_price; $tot_quotation_price +=$info->quotation_price;?></td>
					<td align="left"><?=$info->remarks?></td>
				  </tr>
				  
				   <? }?>
				  
<?php /*?>				  <tr>
					<td colspan="3" align="right" class="bold">Total:</td>
					<td class="bold" align="right"><?=number_format($tot_ord_qty,2);?></td>
					<td align="right">
							<strong>
							  <? if($req_type==2) {?> 
							  $ 
							  <? }?>
							  <?=number_format($tot_quotation_price,2);?>
							</strong>
					</td>
					<td>&nbsp;</td>
				  </tr><?php */?>
				 
		
			</tbody>
		
    </table>
	

	<p class="p bold">In Words : 
		<? $scs =  $tot_quotation_price;
					$credit_amt = explode('.',$scs);
	
		 if($credit_amt[0]>0){
		  echo convertNumberToWordsForIndia($credit_amt[0]);}
	
			 if($credit_amt[1]>0){
			 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;
			 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa ';
								 }
		  echo ' Only.';

		?> 
		</p>
	


<? if($data->transport_bill>0){?>
<? }?>
<? if($data->labor_bill>0){?>
<? }?>
</div>





<div class="footer"  id="footer">
	<table class="footer-table">
        <tr>
          <td colspan="5">&nbsp;</td>
        </tr>

        <tr>
          <td class="text-center w-20">
		  <?php /*?><p style="font-weight:600; margin: 0;"><?=find_a_field('user_activity_management','fname','user_id='.$all->entry_by)?> </p>
		  <p style="font-size:11px; margin: 0;">(<?=find_a_field('user_activity_management','designation','user_id='.$all->entry_by);?>) <br/> <?=$all->entry_at?></p><?php */?>
		  </td>
          <td class="text-center w-20">
		  		  <?php /*?><? if ($all->checked_by>0) {?>
				  <p style="font-weight:600; margin: 0;"><?=find_a_field('user_activity_management','fname','user_id='.$all->checked_by)?> </p>
				  <p style="font-size:11px; margin: 0;">(<?=find_a_field('user_activity_management','designation','user_id='.$all->checked_by);?>) <br/> <?=$all->checked_at?></p>
            
            <? }?><?php */?>
			
		  
		  
		  </td>
          <td class="text-center w-20">&nbsp;</td>
          <td class="text-center w-20">&nbsp;</td>
        </tr>
        <tr>
          <td class="text-center">-------------------------------</td>
          <td class="text-center">-------------------------------</td>
          <td class="text-center">-------------------------------</td>
          <td class="text-center">-------------------------------</td>
        </tr>
        <tr>
          <td class="text-center"><strong>Prepared By</strong></td>
          <td class="text-center"><strong>Checked By</strong></td>
          <td class="text-center"><strong>Approved By</strong></td>
		  <td class="text-center"><strong>Authorized By</strong></td>
        </tr>

	</table>
	
		<?php include("../../../assets/template/report_print_buttom_content.php");?>
	  </div>

</div>



</body>
</html>
