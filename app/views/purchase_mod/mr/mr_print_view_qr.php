<?php


require_once "../../../controllers/routing/default_values.php";

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
// require_once ('../../../acc_mod/common/class.numbertoword.php');




$req_no = url_decode(str_replace(' ', '+', $_REQUEST['req_no']));

  		  $barcode_content = $req_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';
		  
		  
		  $req_qty=find_a_field('requisition_order','sum(qty)','req_no="'.$req_no.'"');
		  
		  $po_qty=find_a_field('purchase_invoice','sum(qty)','req_no="'.$req_no.'"');
		  
$group_data = find_all_field('user_group','group_name','id='.$_SESSION['user']['group']);
$sql="select * from requisition_master where  req_no='$req_no'";
$data=db_query($sql);
$all=mysqli_fetch_object($data);

if(isset($_POST['create_po'])){
  
 if($_POST['req_no']>0){
  unset($_SESSION['po_no']);
  $_SESSION['selected_req_no'] = $_POST['req_no'];
  header('location:../po/po_create.php');
 }

}
$tr_type="Show";


	// echo 'req:'.$req_no;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Requsition Copy</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>
</head>

<style>
@media print {
  #mr_print{
    margin-top: 20px !important;
  }
  }
  
  .footer1{
  	margin-top: 30px !important;
  }
</style>

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
			<p class="qrl-text"><?php echo $all->req_no;?></p>
		</td>
		
		</tr>
		 
		</table>
	</div>
	
	<div class="header-one">
	<hr class="hr">
		<h5 class="report-titel">PURCHASE REQUISITION</h5>
	<br>


	<div class="row">

		<div class="col-md-6 col-sm-6 col-lg-6 left">
			
			<p class="left-text mt-1 mb-1">Requisition No : <span><?php echo $all->req_no;?> </span></p>
			<p class="left-text mt-1 mb-1">Requisition Date : <span> <?php echo $all->req_date;?></span></p>
			<p class="left-text mt-1 mb-1">Requisition For : <span><?php echo $all->req_for;?> </span></p>
		</div>

		<div class="col-md-6 col-sm-6 col-lg-6 right">

			<p class="right-text mt-1 mb-1">Warehouse :  <span> <?php echo find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_id);?></span></p>
			<p class="right-text mt-1 mb-1">Need Before : <span><?php echo $all->need_by;?> </span></p>
			<p class="right-text mt-1 mb-1">Note : <span><?php echo $all->req_note;?>  </span></p>
		</div>
	</div>


<!--	<p class="p-text">
		Dear Sir/Madam,
			<br>
		We are pleased to issue Purchase Order for the following goods/services as per below mentioned terms &amp; conditions:
			<br>
	</p>-->	

</div>


<div class="main-content">
	
	
	<div id="pr">
        <div align="left">
         	 <p> <input name="button" type="button" onclick="hide();window.print();" value="Print"> </p>    
		</div>
     </div>
	  
	  
	  
	<table id="mr_print" class="table1">
		<thead>
			<tr>
				<th>SL</th>
				<th class="w-8">REQ-ID</th>
				<th>Description of the Goods</th>
				<th>Remarks</th>
				<th>Required In</th>
				<th>In Stock</th>
				<th> Last Pur. Vendor </th>
				<th>Last Pur. Date</th>
				<th>Last Pur. QTY</th>
				<th>Last Pur. Rate</th>
				<th>Req QTY</th>
			</tr>
		</thead>
       
		<tbody>

			  <?php
			  
			  	  //vendor ////
	  $sql='select * from vendor group by vendor_id';
	  $query=db_query($sql);
	  while($vrow=mysqli_fetch_object($query)){
	  	$vendor_name[$vrow->vendor_id]=$vrow->vendor_name;
	  }
			  
		$final_amt=(int)$data1[0];
		$pi=0;
		$total=0;
		$sql2="select * from requisition_order where  req_no='$req_no'";
		$data2=db_query($sql2);
		//echo $sql2;
		while($info=mysqli_fetch_object($data2)){ 
		$pi++;
		$amount=$info->qty*$info->rate;
		$total=$total+($info->qty*$info->rate);
		$sl=$pi;
		$item=find_all_field('item_info','concat(item_name," : ",	item_description)','item_id='.$info->item_id);
		$qty=$info->qty;
		$qoh=$info->qoh;
		$po_all=find_all_field('purchase_master','*','po_no="'.$info->last_po_id.'"');
	 $last_p_date=$info->last_p_date;
		$last_p_rate=$info->last_p_rate;
		$last_p_qty=$info->last_p_qty;
		$item_for=$info->item_for;
		$total_qty +=$qty;
		?>
			  <tr>
				<td align="center"><?=$sl?></td>
				<td align="center"><?=$info->id?></td>
				<td align="left" >Code:<?=$info->item_id?><br><?=$item->item_name.' : '.$item->item_description?></td>
				<td ><?=$info->remarks?></td>
				<td ><?=$info->required_in?></td>
				<td align="right"><?=$qoh?></td>
			 <td valign="top"><?=$vendor_name[$po_all->vendor_id]?></td>
				<td align="center"><?=$last_p_date?></td>
				<td align="right" ><?=$last_p_qty?></td>
				<td align="right" > <?= number_format($last_p_rate, 2); ?></td>
				<td align="right" ><?=$qty.' '.$item->unit_name?></td>
			  </tr>
		<? }?>
		  
			  <tr>
				<td align="right" colspan="10" style="text-align:right;"><strong>Total Amount </strong></td>
				<td align="right" style="text-align:right;"><strong><?=number_format($total_qty,2)?></strong></td>
			  </tr>
			  
		
			</tbody>
		
    </table>
	

	<p class="p bold">In Words : 
		<? $scs =  $total_qty;
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
	<? if($req_qty>$po_qty){?>
	<div align="center">
		<form method="post" action="" target="_blank">
	  <input name="create_po" type="submit" class="btn btn-info" value="Create Purchase Order" style="width:200px; font-weight:bold; font-size:12px; height:30px; color:white; background:cornflowerblue; border:0px; cursor: pointer;" />
	  <input type="hidden" name="req_no" value="<?=$req_no?>" />
	  </form> </div>
	<? }  else{ echo '<strong style=" color:red;"><span>Requisition Fully Completed.</span></strong>';}?>
<!--
<p class="p-text"> The Vendor has agreed to provide the above goods/services to ERP COM BD agreed to accept the merchandise from the Vendor in the quantities, at the prices, at the time and subject to the terms, provisions and conditions stated below: </p>


	<table class="terms-table">
			<tr>
			  <td colspan="4" class="terms-titel">Terms &amp; Condition : </td>
			</tr>
			
			 <? 		
			$sql = 'select * from terms_condition_setup where type="PO" group by id order by sl_no';
				$tc_query=db_query($sql);
				while($tc_data= mysqli_fetch_object($tc_query)){
				?>		
			<tr style="letter-spacing:.3px; line-height: 16px;">
			  <td class="text-center w-5" ><?=++$id;?>.</td>
			  <td class="text-left w-95"><?=$tc_data->terms_condition;?></td>
			  </tr> 
			 <? }?>
	</table>
	
	<p class="p-text">	For <?=$group_data->group_name?>. </p>
	
	-->
</div>





<div class="footer1"  id="footer">
	<table class="footer-table">
        <tr>
          <td colspan="4">&nbsp;</td>
        </tr>

        <tr>
          <td class="text-center w-25">
		  <p style="font-weight:600; margin: 0;"> <?=find_a_field('user_activity_management','fname','user_id='.$all->entry_by)?> </p>
		  <p style="font-size:11px; margin: 0;">(<?=find_a_field('user_activity_management','designation','user_id='.$all->entry_by);?>) <br/> <?=$all->entry_at?></p>
		  </td>
          <td class="text-center w-25">&nbsp;</td>
          <td class="text-center w-25">&nbsp;</td>
          <td class="text-center w-25">
		  <p style="font-weight:600; margin: 0;"> <?=find_a_field('user_activity_management','fname','user_id='.$all->checked_by)?></p>
		  <p style="font-size:11px; margin: 0;">(<?=find_a_field('user_activity_management','designation','user_id='.$all->checked_by);?>) <br/> <?=$all->checked_at?></p>
		  </td>
        </tr>
        <tr>
          <td class="text-center">-------------------------------</td>
          <td class="text-center"> </td>
          <td class="text-center"> </td>
          <td class="text-center">-------------------------------</td>
        </tr>
        <tr>
          <td class="text-center"><strong>Prepared By</strong></td>
          <td class="text-center"><strong> </strong></td>
          <td class="text-center"><strong> </strong></td>
          <td class="text-center"><strong>Approved By</strong></td>
        </tr>
	</table>
	<?php include("../../../assets/template/report_print_buttom_content.php");?>
	  </div>
	  	  
</div>




</body>
</html>

<?
$page_name="purchase Requisition";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>
