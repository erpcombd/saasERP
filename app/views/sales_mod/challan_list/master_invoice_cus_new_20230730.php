<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once ('../../../assets/support/class.numbertoword.php');
$title='Challan Details';
do_calander('#invoice_date');
do_calander('#tdate');

  $get_master_inv_no=$_GET['master_invoice_no'];
  
  //bar code start
	$req_bar_no = $get_master_inv_no;
	$barcode_content = $req_bar_no;
	$barcodeText = $barcode_content;
    $barcodeType='code128';
	$barcodeDisplay='horizontal';
    $barcodeSize=40;
    $printText='';
  //bar code end
  
 $master_all=find_all_field('master_invoice_master','*','master_invoice_no="'.$get_master_inv_no.'"');

 $challan= $master_all->chalan_no;
$do = $master_all->do_no;
$group_data = find_all_field('user_group','group_name','id='.$_SESSION['user']['group']);

$sql='select * from sale_do_master

where do_no="'.$do.'"';

$query=db_query($sql);
$data5=mysqli_fetch_object($query);

      $sql1='SELECT  s.chalan_no,s.do_no,s.dealer_code,s.chalan_date,d.dealer_name_e,d.dealer_code,d.address_e,d.email,d.contact_no,d.contact_person_name,d.contact_person_designation
	
	from sale_do_chalan s,dealer_info d
	
	where s.chalan_no="'.$challan.'" and s.dealer_code=d.dealer_code limit 1 ';     
$query=db_query($sql1);
$data = mysqli_fetch_object($query);


?>


<!doctype html>
<html lang="en">
  <head>
  
	 <title>Master Invoice</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>
	
<!--    <style>
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
  
  th,tr,th,td{
  border:1px solid;
  }
label{

}

    </style>-->
    <script>
function print_cus(){
document.getElementById('pr0').style.display='none';
document.getElementById('pr').style.display='none';
document.getElementById('pr1').style.display='none';
document.getElementById('pr12').style.display='none';

window.print();
}
function print_pad(){
document.getElementById('pr0').style.display='none';
document.getElementById('pr').style.display='none';
document.getElementById('pr1').style.display='none';
document.getElementById('pr12').style.display='none';
document.getElementById('header3').style.display='none';
document.getElementById("top_margin").style.marginTop = "50px";
window.print();
}

</script>
  </head>
  
  <body> 
  <div class="body">
  <form action="" method="post">
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
			<p class="qrl-text" style="padding-right: 15px !important;"> <?=$_GET['master_invoice_no'];?></p>
		</td>
		
		</tr>
		 
		</table>
	</div>
	
	<div class="header-one">
	<hr class="hr">
		<h5 class="report-titel"> <span>MASTER INVOICE</span></h5>
	<br>


	<div class="row">

		<div class="col-md-6 col-sm-6 col-lg-6 left">
			
			<p class="left-text mb-2">Customer Name: <span><?=$data->dealer_name_e?> </span></p>
			<p class="left-text mb-2">Address: <span><?=$data->address_e;?></span></p>
			<p class="left-text mb-2">Contact Person: <span><?=$data->contact_person_name?> </span></p>
			<p class="left-text mb-2">Customer Cell NO: <span><?=$data->contact_no?> </span></p>
			<p class="left-text mb-2">E-Mail: <span><?=$data->email?> </span></p>

		</div>

		<div class="col-md-6 col-sm-6 col-lg-6 right">

			<p class="right-text mb-2">Invoice NO: <span><?=$_GET['master_invoice_no'];?> </span></p>
			<p class="right-text mb-2">Invoice Date: <span> <?php echo  $newDate4 = date("d-m-Y", strtotime($data->chalan_date));?></span></p>
			<p class="right-text mb-2">PO NO: <span> <?=$data5->po_no?> </span></p>
			<p class="right-text mb-2">PO Date: <span><?php echo  $newDate4 = date("d-m-Y", strtotime($data5->po_date));?>  </span></p>
			<p class="right-text mb-2" style="display:none;">SO NO: <span> <?=$data->do_no?> </span></p>
			<p class="right-text mb-2" style="display:none;">SO Date: <span> <?php  $do_date=find_a_field('sale_do_master','do_date','do_no="'.$data->do_no.'"');
              echo  $newDate3 = date("d-m-Y", strtotime($do_date)); ?> </span></p>
		</div>
	</div>	

</div>


<div class="main-content">
	
	<div class="d-flex" id="pr">
        <div class="p-2" id="pr0"><button type="button" class="btn btn-success" onClick="print_cus()">Print</button></div>
		<div class="p-2" id="pr1"><button type="button" class="btn btn-success"   onClick="print_pad()"> Pad Print</button></div>
		<div class="p-2"id="pr12" ><a href="master_challan.php"><button type="button" class="btn btn-danger"  > Go Back to Invoice List</button></a></div>
     </div>


	 

	  
	  
	<table class="table1 mt-2">
		<thead>
			<tr>
				<th>SL</th>
				<th>Challan Date</th>
				<th>Challan NO</th>
				<th>Product Code</th>
				<th>Description of Product</th>
				<th>UOM</th>
				<th>Quantity</th>
				<th>Unit Price</th>
				<th>Amount(Tk)</th>
			</tr>
		</thead>
		
		<tbody>
  <?php
  $sl = 0;
  $sql='SELECT s.do_no,s.chalan_no,s.item_id,s.dealer_code,s.unit_price,sum(s.total_unit) as total_unit,sum(s.total_amt) as total_amt,s.chalan_date,s.dealer_code,i.item_name,i.unit_name,i.pack_size,i.secondary_unit_quantity,i.secondary_unit_name
from sale_do_chalan s,item_info i
where s.chalan_no in(select chalan_no from master_invoice_master where master_invoice_no="'.$get_master_inv_no.'") and s.item_id=i.item_id group by s.chalan_no
';
$query=db_query($sql);
while($data = mysqli_fetch_object($query)){
$sl ++;
?>
    <tr>
	  <td style="text-align:center;"><?=$sl?></td>
      <td style="text-align:center;"><?= $data->chalan_date; ?></td>
      <td style="text-align:center;"><?=$data->chalan_no; ?></td>
      <td style="text-align:center;"><?=find_a_field('item_info','finish_goods_code','item_id='.$data->item_id); ?></td>
      <td style="text-align:left;"><?=$data->item_name;?></td>
      <td style="text-align:center;"><?=$data->unit_name;?></td>
      <td style="text-align:right;"><?=$final_unit=round($data->total_unit,0);?></td>
	 
<input type="hidden" name="chalan_no" id="chalan_no" value="<?=$data->chalan_no; ?>">
      <td style="text-align:center;"><?=number_format($data->unit_price,2);?> </td>

      <td style="text-align:right;"><?=$total=$data->total_amt;?></td>

    </tr>
   <? $total1 =$total1+$total;
   	$total2 =  $total2+$final_unit;
     $cost=$data->transport_cost;

    $grand_total_weight= $grand_total_weight + $total_weight_Qty;
   ?> 
    <?php } ?>
<tr>
<td colspan="6" class="bold" style="text-align:right;">SubTotal : </td>

<td class="bold" style="text-align:right;"><?=$total2?></td>
<td></td>

<td class="bold" style="text-align:right;"><?=number_format($total1,2);?> </td>
<!--<td>--><?php //echo $total1; ?><!--</td>-->
</tr>

<?php 
if($data5->vat>0){
?>
<tr>
<td colspan="6" class="bold" style="text-align:right;"><center>VAT Amount <b>(<? if( $data5->vat>0){ echo $data5->vat;echo '%'; }?>)</b></center></td>


<td><?php 
if( $data5->vat>0){
echo $vat= ($total1*$data5->vat)/100;
}else{
echo $vat= ($data5->vat_amt_tk);
}



 ?> </td>

</tr>
<?php } ?>
<?php 
if($cost>0){
?>
<tr>
<td colspan="6" class="bold" style="text-align:right;"><center>Transportation Expences :</center></td>

<td><?php echo number_format($cost,2); ?></td>

</tr>
<?php } ?>
<?php 
if($other_charge>0){
?>
<tr>
<td colspan="6" class="bold" style="text-align:right;"><center>Other Charge/(Discount) :</center></td>

<td></td>
<td><?php echo $other_charge; ?></td>

</tr>
<?php } ?>
<tr >
<td colspan="6" class="bold" style="text-align:right;">Gross Total :</td>
    <td></td>
    <td></td>    
	<td class="bold" style="text-align:right;"><?php echo number_format($all_amt=$vat+$total1+$cost,2); ?></td>

</tr>
   
  </tbody>
  
		
    </table>
	<?php 
$all_appro=find_all_field('sale_do_chalan','','chalan_no="'.$challan.'"');
	$check_sta=find_a_field('sale_do_chalan','invoice_check','chalan_no="'.$challan.'"');
	$appro_sta=find_a_field('sale_do_chalan','approve_status','chalan_no="'.$challan.'"');
?>

	<p class="p bold">In Words : 
		<? $scs =  $all_amt;
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
	
	
	
</div>





<div class="footer"  id="footer">
	<table class="footer-table">
        <tr>
          <td colspan="4">&nbsp;</td>
        </tr>

        <tr>
          <td class="text-center w-25" style=" padding-top: 100px; ">
			  <p style="font-weight:600; margin: 0;">  </p>
			  <p style="font-size:11px; margin: 0;"> </p>
		  </td>
          <td class="text-center w-25" style=" padding-top: 100px;">
			  <p style="font-weight:600; margin: 0;"> <?=find_a_field('user_activity_management','fname','user_id='.$all_appro->entry_by);?> </p>
			  <p style="font-size:11px; margin: 0;"><?=find_a_field('user_activity_management','designation','user_id='.$all_appro->entry_by);?> <br/> <?=$all_appro->entry_at?></p>
		  </td>
          <td class="text-center w-25" style=" padding-top: 100px;">		  
		  		  <p style="font-weight:600; margin: 0;"> <?=find_a_field('user_activity_management','fname','user_id='.$all_appro->check_inv_by);?> </p>
		  <p style="font-size:11px; margin: 0;"><?=find_a_field('user_activity_management','designation','user_id='.$all_appro->check_inv_by);?> <br/> <?=$all_appro->check_inv_at?></p>
		  
		  </td>
          <td class="text-center w-25">
			   <img src="md_sign.PNG"  style="height: 150px;"/>
			   <?php //echo find_a_field('user_activity_management','fname','user_id='.$all_appro->check_appr_by); ?>
		  </td>
        </tr>
        <tr>
          <td class="text-center">-------------------------------</td>
          <td class="text-center">-------------------------------</td>
          <td class="text-center">-------------------------------</td>
          <td class="text-center">-------------------------------</td>
        </tr>
        <tr>
          <td class="text-center"><strong>Received By</strong></td>
          <td class="text-center"><strong>Prepared By</strong></td>
          <td class="text-center"><strong>Checked By</strong></td>
          <td class="text-center"><strong>Approved By</strong></td>
        </tr>
	
	
	
		<tr>
		  <td colspan="4">  	
				<hr style="color:black;border:1px solid black;" />
				<table width="100%" cellspacing="0" cellpadding="0">
						<tr style=" font-size: 12px; font-weight: 500;">
							<td class="text-left w-33">Printed by: <?=find_a_field('user_activity_management','user_id','user_id='.$_SESSION['user']['id'])?></td>
							<td class="text-center w-33"><?=date("h:i A")?></td>
							<td class="text-right w-33"><?=date("d-m-Y")?></td>
						</tr>
						<tr>
						<td colspan="4" style="text-align: center;font-size: 11px;color: #444;"> This is an ERP generated report. That is Powered By www.erp.com.bd</td>
						</tr>
				</table>
		  </td>
		  </tr>
	</table>

	  </div>
	  
	  
</form> 
</div>
  

  </body>
</html>









