<?php
session_start();
//====================== EOF ===================

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
//require "../../../engine/tools/class.numbertoword.php";


$po_no		= $_REQUEST['po_no'];

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
</style></head>
<body>
<form action="" method="post">
<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
  
  <tr>
    <td width="50%">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
	
	<tr>

    <td align="left"><strong style="font-size:24px">
	
				
			
				
				
				<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$data->group_for?>.png" style="width:100px;" />
				<br /></strong>    </td>
  </tr>
    </table>	</td>
    <td width="50%">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
	
	<tr>

    <td align="left"  ><strong><font style="font-size:20px; text-transform: uppercase;">
      <?=find_a_field('user_group','group_name','id='.$data->group_for);?>
    </font></strong></td>
  </tr>
  
  
  <tr>

    <td align="left">&nbsp; </td>
  </tr>
  
  <tr height="40" style="background:#000; color:#FFFFFF" align="center">

    <td >

    <strong><font style="font-size:20px">PURCHASE INVOICE </font></strong></td>
  </tr>
    </table>	</td>
  </tr>
  
  <tr>
    <td colspan="2"><div class="line">
      <div align="center">      </div>
    </div></td>
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
  	  <td colspan="2" bgcolor="#004269" headers="25"><span style="font-size:14px; font-weight:700; color:#FFFFFF; padding-left:10px;">SUPPLIYER </span></td>
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
        <td width="3%" bgcolor="#004269"><span class="style8">SL</span></td>
        <td width="11%" bgcolor="#004269"><span class="style8">Item Code </span></td>
        <td width="32%" bgcolor="#004269"><div align="center" class="style8">Description of the Goods </div></td>
        <td width="6%" bgcolor="#004269"><span class="style8">Unit</span></td>
        <td width="10%" bgcolor="#004269"><span class="style8">Pkt Unit</span></td>
        <td width="12%" bgcolor="#004269"><span class="style8">Total Unit </span></td>
        <td width="13%" bgcolor="#004269"><span class="style8"> CTN Price </span></td>
        <td width="13%" bgcolor="#004269"><span class="style8">Amount</span></td>
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
$ctn_rate=$info->ctn_rate;
$disc=$info->disc;
?>
<tr>
        <td valign="top"><?=$sl?></td>
        <td align="left" valign="top"><?=$item->finish_goods_code?></td>
        <td align="left" valign="top"><?=$item->item_name?></td>
        <td valign="top"><?=$unit_name?></td>
        <td valign="top"><?=$pkt_unit?></td>
        <td valign="top"><?=$qty?></td>
        <td align="right" valign="top"><?=number_format($ctn_rate,2)?></td>
        <td align="right" valign="top"><?=number_format($amount,2)?></td>
      </tr>
<? }?>
      <tr>
        <td colspan="6"></td>
        <td align="right"><strong>Total:</strong></td>
        <td align="right"><strong><?php echo number_format($total,2);?></strong></td>
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
				<td width="50%" align="center"><strong><?php echo number_format($total,2);?>
				</strong></td>
			</tr>
			<tr>
				<td width="50%"><div align="right"><strong>VAT(<?=$data->tax?> %): </strong> <? $tax_total=(($total*$data->tax)/100);?></div></td>
				<td width="50%" align="center"><strong>
				  <?  echo number_format($tax_total,2);?>
				</strong></td>
			</tr>
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
				<td width="50%" align="center"><strong><? echo number_format(($total+$data->transport_bill+$tax_total+$data->labor_bill-$data->cash_discount),2);?></strong></td>
			</tr>
	  </table>	</td>
  </tr>
	 </table>
	
	
	
	
      <table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" style="width:700px">
        <tr>
          <td colspan="4">&nbsp;</td>
        </tr>
        <?php /*?><tr>
		<td colspan="4"><strong>In Word:</strong> SR <?
		$tax_total=(($total*$data->tax)/100);
		$scs =  $aatotal = ($total+$tax_total+$data->transport_bill+$data->labor_bill-$data->cash_discount);
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
		<td colspan="4" align="right">&nbsp;</td>
          </tr>
<? if($data->transport_bill>0){?>
<? }?>
<? if($data->labor_bill>0){?>
<? }?>
        <tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><em>
            <?=find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?>
          </em></td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="center">----------------------</td>
          <td align="center">----------------------</td>
          <td align="center">----------------------</td>
          <td align="center">----------------------</td>
        </tr>
        <tr style="font-size:12px">
          <td align="center" width="25%">Prepared By</td>
          <td align="center" width="25%">Sr.  Manager</td>
          <td align="center" width="25%">Acc. Manager </td>
          <td align="center" width="25%">Director</td>
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
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</form>
</body>
</html>
