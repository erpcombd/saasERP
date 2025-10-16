<?php
session_start();
//====================== EOF ===================

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$po_no		= $_REQUEST['po_no'];

$req_bar_no = 2104000001;

		  $barcode_content = $req_bar_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';

if(isset($_POST['cash_discount']))
{
	$po_no = $_POST['po_no'];
	$cash_discount = $_POST['cash_discount'];
	$ssql='update purchase_master set cash_discount="'.$_POST['cash_discount'].'" where po_no="'.$po_no.'"';
	db_query($ssql);
}

$sql1="select * from purchase_master where po_no='$po_no'";
$data=mysqli_fetch_object(db_query($sql1));
$vendor=find_all_field('vendor','','vendor_id='.$data->vendor_id );
$whouse=find_all_field('warehouse','','warehouse_id='.$data->warehouse_id);


 $req_type=find_a_field('requisition_master','req_type','req_no='.$data->req_no);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Purchase Order :.</title>
<link href="../../../assets/css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
<style type="text/css">
<!--
.style8 {
	color: #FFFFFF;
	font-weight: bold;
}
-->



.header table tr td table tr td table tr td table tr td {
	color: #000;
}

/*@media print{
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;

   color: white;
   text-align: center;
}
}*/
-->


@font-face {
  font-family: 'MYRIADPRO-REGULAR';
  src: url('MYRIADPRO-REGULAR.OTF'); /* IE9 Compat Modes */

}

@font-face {
  font-family: 'TradeGothicLTStd-Extended';
  src: url('TradeGothicLTStd-Extended.otf'); /* IE9 Compat Modes */

}


@font-face {
  font-family: 'Humaira demo';
  src: url('Humaira demo.otf'); /* IE9 Compat Modes */

}



.number {
    width: 8em;
    display: block;
    word-wrap: break-word;
    columns: 6;
    column-gap: 0.2em;
}

</style></head>
<body>
<form action="" method="post">
<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
  
  <tr>
    <td width="68%">
                       		<table  width="97%" border="0" cellspacing="0" cellpadding="0"  style="font-size:15px">
								<tr>
					    <td width="50%" align="left" style="padding-bottom:0px;"><img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['user']['depot']?>.png"  width="64%" /></td>
					    <td width="50%" align="left">&nbsp;</td>
							  </tr>
							  
							  


						<tr>
					    <td align="left" width="50%" style="padding-top:25px;"><?='<img style=" margin-left:-8px;  font-size:12px;" class="barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?></td>
					    <td align="left" width="50%">&nbsp;</td>
						</tr>
						
						<tr>
					    <td align="left" width="50%"><span style="font-size:14px; padding: 3px 0 0 5px; letter-spacing:5px;"><?=$master->pi_no;?></span></td>
					    <td align="left" width="50%">&nbsp;</td>
						</tr>
						
						<tr>
					    <td align="left" width="50%">&nbsp;</td>
					    <td align="left" width="50%">&nbsp;</td>
						</tr>
						  </table>					    </td>
    <td width="32%"> 
							<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px">
								
									
									<tr>
									  <td style="padding-bottom:3px;"><span style="font-size:14px; color:#000000; margin:0; padding: 0 0 0 0; text-transform:uppercase; 
									   font-weight:500; font-family: 'TradeGothicLTStd-Extended'; "><?=find_a_field('user_group','group_name','id='.$_SESSION['user']['group'])?>.
									  </span></td>
							  </tr>
							  
							  <tr>
									  <td style="padding-bottom:3px; font-size:12px;">(A Member of Nassa Group)</td>
							  </tr>
									<tr><td style="padding-bottom:3px; font-size:12px;">107, 128 Nischintapur,</td>
									</tr>
									<tr><td style="padding-bottom:3px; font-size:12px;">Zerabo, Ashulia, Dhaka.</td>
									</tr>
									<tr><td style="padding-bottom:3px; font-size:12px;">Phone No. : +8809666700800</td>
									</tr>
									<tr><td style="padding-bottom:3px; font-size:12px;">Email: npl@nassagroup.org</td>
									</tr>
									<tr>
									  <td style="padding-bottom:3px; font-size:12px;">FSC Certificate Code: SCS-COC-007014</td>
							  </tr>
							  
							  <tr><td style="padding-bottom:3px;  font-size:12px;">BIN/VAT Reg. No. : 000073153-0403</td>
							  </tr>
						  </table>						  </td>
  </tr>
  
  <!--<tr>
    <td colspan="2"><div class="line">
      <div align="center">      </div>
    </div></td>
  </tr>-->
  
  
  
  <tr>
   <td colspan="2" align="center"><h4 style="font-size:18px; padding:10px 0; margin:0; font-family:  'MYRIADPRO-REGULAR'; letter-spacing:1px;text-decoration:underline;">  PURCHASE ORDER </h4></td>
  </tr>
  
  
  
  
  
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  
   <tr>
    <td >&nbsp;</td>
    <td>
		<table width="100%" border="1">
			<tr>
				<td width="50%"><div align="right"><strong>Purchase No: </strong></div></td>
				<td width="50%" align="center"><strong>
				  <?=$_GET['po_no']?>
				</strong></td>
			</tr>
			<tr>
				<td width="50%"><div align="right"><strong>Purchase  Date: </strong></div></td>
				<td width="50%" align="center"><strong>
				  <?php echo date("d-m-Y",strtotime($data->po_date)); ?>
				</strong></td>
			</tr>
			
			<tr>
				<td width="50%"><div align="right"><strong>Quotation No: </strong></div></td>
				<td width="50%" align="center"><strong>
				  <?php echo $data->quotation_no; ?>
				</strong></td>
			</tr>
			
			
	  </table>	</td>
  </tr>
  
   
  
  
  </table>
  
  <table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
  	<tr>
  	  <td colspan="2">&nbsp;</td>
  	  <td>&nbsp;</td>
  	  <td colspan="2">&nbsp;</td>
    </tr>
  	<tr>
  	  <td colspan="2" bgcolor="#004269" headers="25"><span style="font-size:14px; font-weight:700; color:#FFFFFF; padding-left:10px;">SUPPLIER </span></td>
  	  <td width="10%">&nbsp;</td>
  	  <td height="25" colspan="2" bgcolor="#004269"><span style="font-size:14px; font-weight:700; color:#FFFFFF; padding-left:10px;">SHIP TO </span></td>
    </tr>
  	<tr style="font-size:14px;">
		<td  height="25"  width="10%">&nbsp;&nbsp;Name</td>
		<td  height="25"  width="35%">: <?=$vendor->vendor_name;?></td>
		<td  height="25" width="10%"></td>
		<td  height="25"  width="10%">&nbsp;&nbsp;Warehouse</td>
	    <td  height="25"  width="35%">: <?=$whouse->warehouse_name?></td>
  	</tr>
	<tr style="font-size:14px;">
		<td  height="25"  width="10%">&nbsp;&nbsp;Address</td>
		<td  height="25"  width="35%">: <?=$vendor->address;?></td>
		<td  height="25" width="10%"></td>
		<td  height="25"  width="10%">&nbsp;&nbsp;Address</td>
	    <td  height="25"  width="35%">: <?=$whouse->address?></td>
  	</tr>
	<tr style="font-size:14px;">
		<td  height="25"  width="10%">&nbsp;&nbsp;Phone</td>
		<td  height="25"  width="35%">: <?=$vendor->contact_no;?></td>
		<td  height="25" width="10%"></td>
		<td  height="25"  width="10%">&nbsp;&nbsp;Phone</td>
	    <td  height="25"  width="35%">: <?=$whouse->contact_no?></td>
  	</tr>
	
	<tr style="font-size:14px;">
		<td  height="25"  width="10%">&nbsp;&nbsp;E-mail</td>
		<td  height="25"  width="35%">: <?=$vendor->email;?></td>
		<td  height="25" width="10%"></td>
		<td  height="25"  width="10%">&nbsp;&nbsp;E-mail</td>
	    <td  height="25"  width="35%">: <?=$whouse->email?></td>
  	</tr>
	
	<tr>
  	  <td colspan="2">&nbsp;</td>
  	  <td>&nbsp;</td>
  	  <td colspan="2">&nbsp;</td>
    </tr>
  </table>
  
  
  
  <table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
 
  <tr>
    <td colspan="2"><div id="pr">
      <div align="left">
        
          <table width="60%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
          <?php /*?><td><span class="style3">Special Cash Discount: </span></td>
          <td><label>
            <input name="cash_discount" type="text" id="cash_discount" value="<?=$cash_discount?>" />
            </label>
            <input type="hidden" name="po_no" id="po_no" value="<?=$po_no?>" /></td>
          <td><label>
            <input type="submit" name="Update" value="Update" />
          </label></td><?php */?>
        </tr>
      </table>
      </div>
    </div>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="4%" bgcolor="#004269"><span class="style8">SL</span></td>
        <td width="48%" bgcolor="#004269"><div align="center" class="style8">Description of the Goods </div></td>
        <td width="6%" bgcolor="#004269"><span class="style8">Unit</span></td>
        <td width="10%" bgcolor="#004269"><span class="style8">Quantity</span></td>
        <td width="7%" bgcolor="#004269"><span class="style8">  Price </span></td>
        <td width="17%" bgcolor="#004269"><span class="style8">Amount</span></td>
      </tr>
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
$sl=$pi;
$item=find_all_field('item_info','concat(item_short_name)','item_id='.$info->item_id);
$qty=$info->qty;
$pkt_unit=$info->pkt_unit;
$unit_name=$info->unit_name;
$rate=$info->rate;
$disc=$info->disc;
?>
<tr>
        <td valign="top"><?=$sl?></td>
        <td align="left" valign="top"><?=$item->item_name?></td>
        <td valign="top"><?=$unit_name?></td>
        <td valign="top"><?=$qty?></td>
        <td align="right" valign="top"><? if($req_type==2) {?>$<? }?><?=number_format($rate,5)?></td>
        <td align="right" valign="top"><? if($req_type==2) {?>$<? }?><?=number_format($amount,2)?></td>
      </tr>
<? }?>
      <tr>
        <td colspan="4"><div align="right"><strong>Total:</strong></div></td>
        <td align="right">&nbsp;</td>
        <td align="right"><strong><? if($req_type==2) {?>$<? }?><?php echo number_format($total,2);?></strong></td>
      </tr>
    </table>
	
	 <table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
	 <tr>
	   <td >&nbsp;</td>
	   <td>&nbsp;</td>
	   </tr>
	 <tr>
    <td width="60%" >&nbsp;</td>
    <td width="40%">
		<table width="100%" border="1">
			<tr>
				<td width="50%"><div align="right"><strong>Sub Total: </strong></div></td>
				<td width="50%" align="center"><strong><? if($req_type==2) {?> $ <? }?><?php echo number_format($total,2);?>
				</strong></td>
			</tr>
			<? if($data->ait>0){?>
			<tr>
				<td width="50%"><div align="right"><strong>AIT(<?=$data->ait?> %): </strong> <? $ait_total=(($total*$data->ait)/100);?></div></td>
				<td width="50%" align="center"><strong>
				  <?  echo number_format($ait_total,2);?>
				</strong></td>
			</tr>
			 <? }?>
			 <? if($data->tax>0){?>
			<tr>
				<td width="50%"><div align="right"><strong>VAT(<?=$data->tax?> %): </strong> <? $tax_total=(($total*$data->tax)/100);?></div></td>
				<td width="50%" align="center"><strong>
				  <?  echo number_format($tax_total,2);?>
				</strong></td>
			</tr>
			<? }?>
			<? if($data->transport_bill>0){?>
			<tr>
			  <td><div align="right"><strong>Transport: </strong></div></td>
			  <td align="center"><strong><? echo number_format(($data->transport_bill),2);?></strong></td>
			  </tr>
			  
			  <? }?>
			  
			 <? if($data->labor_bill>0){?>
			<tr>
			  <td><div align="right"><strong>Labour: </strong></div></td>
			  <td align="center"><strong><? echo number_format(($data->labor_bill),2);?></strong></td>
			  </tr>
			  
			  <? }?>
			<tr>
				<td width="50%"><div align="right"><strong>Grand Total : </strong></div></td>
				<td width="50%" align="center"><strong><? if($req_type==2) {?> $ <? }?><? echo number_format(($total+$data->transport_bill+$ait_total+$tax_total+$data->labor_bill-$data->cash_discount),2);?></strong></td>
			</tr>
	  </table>	</td>
  </tr>
	 </table>
	
	
	
	
      <table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" style="width:700px">
        <tr>
          <td colspan="5">&nbsp;</td>
        </tr>
        <?php /*?><tr>
		<td colspan="4"><strong>In Word:</strong> BDT <?
		$ait_total=(($total*$data->ait)/100);
		$tax_total=(($total*$data->tax)/100);
		$scs =  $aatotal = ($total+$ait_total+$tax_total+$data->transport_bill+$data->labor_bill-$data->cash_discount);
			 $credit_amt = explode('.',$scs);
	 if($credit_amt[0]>0){
	 
	 echo convertNumberToWordsForIndia($credit_amt[0]);}
	 if($credit_amt[1]>0){
	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;
	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa ';}
	 echo ' Only.';
		?></td>
          </tr><?php */?>
        <tr>
		<td colspan="5" align="right">&nbsp;</td>
          </tr>
<? if($data->transport_bill>0){?>
<? }?>
<? if($data->labor_bill>0){?>
<? }?>
        <tr>
          <td colspan="5" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="5" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="5" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="5" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><em>
            <?=find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?>
			<br />
			<?=$data->entry_at?>
          </em></td>
          <td align="center"><? if ($data->checked_by>0) {?>
            <?=find_a_field('user_activity_management','fname','user_id='.$data->checked_by)?>
            <br />
            <?=$data->checked_at?>
            <? }?></td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="center">---------------------</td>
          <td align="center">---------------------</td>
          <td align="center">------------------</td>
          <td align="center">---------------------</td>
          <td align="center">---------------------</td>
        </tr>
        <tr style="font-size:12px">
          <td align="center" width="20%">Prepared By</td>
          <td align="center" width="20%"><strong>Store Incharge</strong></td>
          <td align="center" width="17%"><strong>Prod. Manager</strong></td>
          <td align="center" width="21%"><strong>Executive Director</strong></td>
          <td align="center" width="22%"><strong>Approved by</strong></td>
        </tr>
        
        
        <?php /*?><tr>
          <td align="left" style="font-size:10px">
          <ul>
            <li>The Copy of Work Order must be shown at the factory premises during the delivery.</li>
            <li>Company protects the right to reconsider or cancel the Work-Order every nowby any administrational dictation.</li>
            <li>Any inefficiency in maintanence must be informed(Officially) before the execution to avoid the compensation.</li>
        </ul></td>
        </tr><?php */?>
        <tr>
          <td colspan="5" align="left">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</form>
</body>
</html>
