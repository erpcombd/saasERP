<?php

  
	
	
session_start();
//====================== EOF ===================
//var_dump($_SESSION);

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
//require_once ('../../../acc_mod/common/class.numbertoword.php');


$bill_no 		= $_REQUEST['bill_no'];

$sql="select * from bill_info where  bill_no='$bill_no'";
$data=db_query($sql);
$all=mysqli_fetch_object($data);

$req_type=find_a_field('requisition_master','req_type','req_no='.$all->req_no);

$sub_depot_id=$all->sub_depot;
$group_for=$all->group_for;

$warehouse=find_all_field('warehouse','','warehouse_id='.$all->warehouse_id);

$grp=find_all_field('user_group','','id='.$_SESSION['user']['group']);

$customer=find_all_field('service_customer','','customer_id='.$all->customer);


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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>ERP BILL</title>
<link href="../../../assets/css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
<style type="text/css">
<!--
.style3 {color: #FFFFFF; font-weight: bold; font-size: 16px; }
.style4 {font-size: 14px}
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

</style>
</head>
<body>
<table width="701" border="0" cellspacing="0" cellpadding="0" align="center">
  
  
  
  
  <tr>
   <td colspan="2" align="center"><h4 style="font-size:18px; padding:10px 0; margin:0; font-family:  'MYRIADPRO-REGULAR'; letter-spacing:1px;text-decoration:underline;"> INVOICE </h4></td>
  </tr>
  
  
   <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  

<tr>
    <td><table width="50%">
			<tr>
				<td colspan="2" width="100%"><div align="justify"><strong>To </strong></div></td>
			</tr>
			<tr>
				
				<td width="100%" align="justify"><strong>
				  <?=$customer->customer_name?>
				</strong></td>
				
			</tr>
			<tr>
				<td width="100%" align="justify"><strong>
				  <?=$customer->address?>
				</strong></td>
			</tr>
			<tr>
				<td width="100%" align="justify"><strong>
				 BIN: <?=$customer->bin?>
				</strong></td>
			</tr>
			
			
	  </table></td>
    <td>
		<table width="100%" >
			<tr>
				<td width="50%"><div align="justify"><strong>Invoice No </strong></div></td>
				<td width="50%" align="justify"><strong>:<?=$all->manual_bill_no?></strong></td>
			</tr>
			<tr>
				<td width="50%"><div align="justify"><strong>Invoice Date </strong></div></td>
				<td width="50%" align="justify"><strong>:<?php echo date("d-m-Y",strtotime($all->bill_date)); ?></strong></td>
			</tr>
			<tr>
				<td width="50%"><div align="justify"><strong>Work Order Date </strong></div></td>
				<td width="50%" align="justify"><strong>:<?php echo $req_type->req_no;?></strong></td>
			</tr>
			<tr>
				<td width="50%"><div align="justify"><strong>Document No </strong></div></td>
				<td width="50%" align="justify"><strong>:<?php echo $req_type->req_no;?></strong></td>
			</tr>
			<tr>
				<td width="50%"><div align="justify"><strong>BIN NO </strong></div></td>
				<td width="50%" align="justify"><strong>:003408615&shy;0401</strong></td>
			</tr>
	  </table>	</td>
</tr>


   <tr>
    <td colspan="2">&nbsp;	</td>
  </tr>
  
</table>
 <div id="pr">
<div align="left">


<table width="701" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="126"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
	
    <td width="582" style=" font-size:14px;"><?
	 
	 $sql = 'select * from document_upload where tr_from="BillReceive" and master_id="'.$_GET['bill_no'].'"';
	 $qry=db_query($sql);
	 while($att=mysqli_fetch_object($qry)){
	 echo '<a href="'.$att->file_name.'" target="_blank">Attachment '.++$i.'</a>,  ';
	 }
	 
	?></td>
  </tr>
</table>
</div>
</div>
<table width="701" border="0" cellspacing="0" cellpadding="0" align="center">

<tr><td>

<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="6%" bgcolor="#CCCCCC"><strong>SL</strong></td>
        <td width="40%" bgcolor="#CCCCCC"><strong>Description</strong></td>
        <td width="9%" bgcolor="#CCCCCC"><strong>Total Amount(TAKA) </strong></td>
        
       </tr>
       
	  <?php
$final_amt=(int)$data1[0];
$pi=0;
$total=0;
 $sql2="select b.*, a.type,sum(b.service_charge) as total_amt from bill_details b, acc_bill_type a where a.id=b.service_type and b.bill_no='$bill_no' group by b.bill_no";
$data2=db_query($sql2);
//echo $sql2;
while($info=mysqli_fetch_object($data2)){ 
$pi++;

$tot_ord_qty +=$ord_qty;
$tot_ord_bag +=$ord_bag;


?>
      <tr>
        <td valign="top"><?=++$sl?></td>
        
        <td valign="top" align="left">Service Charge for the period of <?=date('M-Y',strtotime($all->bill_date))?></td>
        <td valign="top" align="right"><?=number_format($info->total_amt,2); $total_amount+=$info->total_amt; $vat=($total_amount*10)/100;$g_total=$total_amount+$vat;?></td>
        
        
      </tr>
	  
	   <? }?>
	   
	   <? if($all->discount_amt>0){?>
	   <tr>
        <td valign="top" align="right" colspan="2">Discount Amount</td>
        <td valign="top" align="right"><?=number_format($all->discount_amt,2);?></td>
	   </tr>
	   <? } ?>
	  
	   <tr>
        <td valign="top" align="right" colspan="2">Total Payable Amount</td>
        
        <td valign="top" align="right"><?=number_format($net_recv=$total_amount-$all->discount_amt,2);?></td>
        
        
      </tr>
	
	  
	 
    </table>
	
	
	</td>
  </tr>
  
  
  <tr>
  	<td>
			<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" style="width:700px">
        <tr>
          <td colspan="5">&nbsp;</td>
        </tr>
        
        

        <tr>
			<td valign="top" align="left" >Amount In Words</td>
        
        	<td valign="top" align="left"><?=convertNumberToWordsForIndia($net_recv);?></td>
         
        </tr>
        <tr>
          <td valign="top"  align="left">Account Name</td>
		  <td valign="top"  align="left">:ERP.COM.BD </td>
        </tr>
		<tr>
          
		  <td valign="top"  align="left">A/C No</td>
		  <td valign="top"  align="left">:022311100000149</td>
        </tr>
        <tr>
         
		  <td valign="top"  align="left">Bank</td>
		  <td valign="top"  align="left">:First Security Islami Bank Limited.</td>
        </tr>
		<tr>
          <td colspan="5" align="left"> N. B: Invoice as per  Work  Order Instruction.</td>
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
      </table>	</td>
  </tr>
  
  <tr>
  	<td>
			<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" style="width:700px">
        <tr>
          <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
		<td colspan="5">&nbsp;</td>
          </tr>
        <tr>
		<td colspan="5" align="right">&nbsp;</td>
          </tr>
<? if($data->transport_bill>0){?>
<? }?>
<? if($data->labor_bill>0){?>
<? }?>
        <tr>
          <td colspan="5" align="left">Authorized Person</td>
        </tr>
        <tr>
          <td colspan="5" align="left">Md Mhafuzur Rahman</td>
        </tr>
        <tr>
          <td colspan="5" align="left">Chief Executive Officer</td>
        </tr>
		<br />
        <tr>
          <td colspan="5" align="left">ERP COM BD</td>
        </tr>
		<tr>
          <td colspan="5" align="left">[Software Generated Bill. No Signatory Required.]</td>
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
      </table>	</td>
  </tr>
  
  
  </td>
  
  </table>
</table>


</body>
</html>
