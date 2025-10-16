<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$oi_no 		= $_REQUEST['v_no'];

  		  $barcode_content = $oi_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';

$datas=find_all_field('warehouse_other_issue','s','oi_no='.$oi_no);
$group = find_all_field('user_group','','id="'.$_SESSION['user']['group'].'"');
$sql111="select b.* from warehouse_other_issue b where b.oi_no = '".$oi_no."'";
$data111=db_query($sql111);

$data=mysqli_fetch_object($data111);
$rec_frm=$data->vendor_name;
$requisition_from=$data->requisition_from;
$oi_date=$data->oi_date;
$entry_by = find_a_field('user_activity_management','fname','user_id="'.$data->entry_by.'"');


$sql1="select b.* from warehouse_other_issue_detail b where b.oi_no = '".$oi_no."'";
$data1=db_query($sql1);

$pi=0;
$total=0;
while($info=mysqli_fetch_object($data1)){ 
$pi++;

$order_no[]=$info->order_no;
$qc_by=$info->qc_by;

$item_id[] = $info->item_id;
$rate[] = $info->rate;
$amount[] = $info->amount;

$unit_qty[] = $info->qty;
$unit_name[] = $info->unit_name;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>.: Local Sales :.</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
	<?php include("../../../../public/assets/css/theme_responsib_new_table_report1.php");?>
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
		width: 100% !important;
		font-size: 18px !important;
	 }
}
	
  </style>
</head>
<body style="font-family: Poppins, serif; ">

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <thead>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="2" border="0">
      <tr>
        <td width="20%" class="logo"><img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" class="logo-img"/></td>
        <td width="60%" align="center">
				<p style="font-size:28px; color:#000000; margin:0; padding: 0 0 5px 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothic LT', sans-serif;">  <?=$group->group_name?> </p>			
				<p style="font-size:16px; font-weight:300; color:#000000; margin:0; padding:0;"><?=$group->address?></p>
				<p style="font-size:14px; font-weight:400; color:#000000; margin:0; padding:0;"><strong>Cell: </strong> <?=$group->mobile?>. <strong>Email: </strong><i><?=$group->email?> </i><br> <strong>  <?=$group_data->vat_reg?></strong></p>
		</td>
        <td class="Qrl_code">
					<?='<img class="barcode Qrl_code_barcode mt-4" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
				<p style="font-size:14px; padding: 2px 0px 0px 185px; letter-spacing:7px; "><?php echo $oi_no;?></p>
		</td>
		
      </tr>
	 
    </table>      </td>
  </tr>
   <tr><td><hr class="hr mt-1 mb-1"/></td></tr>
  </thead>
  <tbody>
  <tr>
    <td>
	<table width="100%" cellspacing="0" cellpadding="2" border="0">
      <tr>
        <td>
		<h5 class="text-center font-weight-bold mt-0 ml-0 mb-2 ">DIRECT SALES </h5>
		<!--<hr class="hr1 w-25">-->
		</td>
      </tr>
      <tr>
        <td><table width="100%" cellspacing="0" cellpadding="2" border="0" >
          <tr>
            <td width="35%">
				<table>
				<tr>
				
				<td width="36%"><strong>LS No</strong> </td>
					<td width="64%"> : <strong><?php echo $oi_no;?></strong></td>
				</tr>
				<tr>
					<td >LS Date  </td>
					<td > :  <?=date("d M, Y",strtotime($oi_date))?></td>
				</tr>
				<tr>
					<td>Customer Name  </td>
					<td> : <?php echo $rec_frm;?></td>
				</tr>
				<tr>
					<td>Note </td>
					<td>: <?php echo !empty ($data->oi_subject) ? $data->oi_subject: 'N/A';?></td>
				</tr>
				</table>
			
				
				
            <td width="30%"></td>
            <td width="35%" >
				<table width="100%" cellspacing="0" cellpadding="2" border="0">
				
				<tr>
					<td width="35%">SO Date</td>
					<td width="65%">: <?=date("j-M-Y",strtotime($master->do_date));?></td>
				</tr>
				<tr>
					<td >JOB  No</td>
					<td >: <?php echo !empty ($master->job_no) ? $master->job_no: 'N/A';?></td>
				</tr>
				<tr>
					<td >Contact No</td>
					<td>: <?php echo !empty ($dealer->contact_no) ? $dealer->contact_no: 'N/A';?></td>
				</tr>
				<tr>
					<td>Address</td>
					<td>: <?php echo !empty ( $dealer->address_e)  ? $dealer->address_e: 'N/A';?></td>
				</tr>
				
				</table>
			</td>
          </tr>
        </table></td>
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
	<table class="table1">
		<thead>
			<tr>
				<th>SL</th>
				<th class="w-10">Item Code</th>
				<th class="w-25 text-left">Item Name</th>
				<th class="w-7">Unit</th>
				<th class="w-10">Unit Price</th>
				<th class="w-10">Quantity</th>
				<th>Net Amount</th>
			</tr>
		</thead>
       
		<tbody>
		       
<? for($i=0;$i<$pi;$i++){?>
      
      <tr>
        <td align="center" valign="top"><?=$i+1?></td>
        <td align="left" valign="top"><?=$item_id[$i]?></td>
        <td align="left" valign="top"><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>
        <td align="center" valign="top"><?=$unit_name[$i]?></td>
        <td align="right" valign="top"><?=$rate[$i]?></td>
        <td align="right" valign="top"><?=$unit_qty[$i]?></td>
        <td align="right" valign="top"><strong><?=find_a_field('currency_type','icon','currency_type="BDT"');?></strong><?=$amount[$i]; $t_amount = $t_amount + $amount[$i];?></td>
        </tr>
<? }?>

		<tr>
		    <td colspan="6" class="bold" align="right">Total Amount(BDT):</td>
			<td class="bold" align="right"><?=find_a_field('currency_type','icon','currency_type="BDT"');?><?=$t_amount?></td>
		</tr>
	
		</tbody>
		
    </table>
	

	</td>
      </tr>
      <tr>
        <td>
	<p class="p  mb-5"><strong>In Words : </strong>
		
				<?php
$currency_type = 'taka'; // Set this to 'taka' or 'dollar' based on user input

$scs =  $t_amount;
$credit_amt = explode('.',$scs);

if($credit_amt[0]>0){
    echo convertNumberToWordsForIndia($credit_amt[0]);
    echo ' ' . ($currency_type == 'taka' ? 'Taka' : 'Dollars');
}

if($credit_amt[1]>0){
    if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;
    echo ' & ' . convertNumberToWordsForIndia($credit_amt[1]);
    echo ' ' . ($currency_type == 'taka' ? 'Paisa' : 'Cents');
}

echo ' Only.';
?>
		
		</p>
	
		</td>
      </tr>
      
    
				</table>		  
			</td>
	   </tr>

    </table></td>
  </tr>
  
<table >
        <tr>
          <td colspan="4">&nbsp;</td>
        </tr>

        <tr >
          <td class="text-center w-25">
		  <p style="font-weight:600; margin: 0;"> <?=$entry_by?> </p>
		  <p style="font-size:11px; margin: 0;"></p>
		  </td>
		  <td class="text-center w-25">
		  <p style="font-weight:600; margin: 0;"> <?=$entry_by?> </p>
		  <p style="font-size:11px; margin: 0;"></p>
		  </td>
		  <td class="text-center w-25">
		  <p style="font-weight:600; margin: 0;"> <?=$entry_by?> </p>
		  <p style="font-size:11px; margin: 0;"></p>
		  </td>
         <!-- <td class="text-center w-30">&nbsp;</td>
          <td class="text-center w-25">&nbsp;</td>
          <td class="text-center w-25">&nbsp;</td>-->
        </tr>
        <tr>
          <td class="text-center w-25">-------------------------------</td>
          <td class="text-center w-25">-------------------------------</td>
         <!-- <td class="text-center"></td>-->
          <td class="text-center w-25">-------------------------------</td>
        </tr>
        <tr>
          <td class="text-center"><strong>Prepared By</strong></td>
          <td class="text-center"><strong>Reviewd By</strong></td>
       <!--   <td class="text-center"><strong></strong></td>-->
          <td class="text-center"><strong>Approved By</strong></td>
        </tr>
	
		<tr>
			<td colspan="4"><?php include("../../../assets/template/report_print_buttom_content.php");?></td>
		</tr>
	
		<tr>
		  <td colspan="8" style="width:1100px;">  	
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
</table>
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
</body>
</html>