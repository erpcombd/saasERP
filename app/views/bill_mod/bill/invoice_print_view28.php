<?php
/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/
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


@media print {
.head{
display:none !important}
        body {
            margin-top:60px ;
			margin-left:30px;
			margin-right:30px;
            padding: 0;
            font-size: 14px;
			
        }
		
		
        table {
            width: 100%;
        }
        td {
            padding: 2px;
        }
        /* Prevents page breaks within table rows */
        table, tr, td {
            page-break-inside: avoid;
        }
        /* Controls the page margins for printing */
        @page {
            size: A4;
            margin: 1cm; /* Adjust margins as needed */
        }
    }
</style>
<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.1/css/all.css">
</head>
<body>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  
  
  
  <tr class="head">
    <td colspan="3">
            <table  width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:15px">
				<tr>
					    <td width="20%" align="left" style="padding-bottom:0px;"><img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['user']['depot']?>.png"  width="64%" /></td>
					    <td width="60%" align="right">
								<table>
						
									<tr>
									  <td style="padding-bottom:3px;"><span style="font-size:14px; color:#000000; margin:0; padding: 0 0 0 0; text-transform:uppercase; 
									   font-weight:500; font-family: 'TradeGothicLTStd-Extended'; "><?=find_a_field('user_group','group_name','id='.$_SESSION['user']['group'])?>.
									  </span>
									  </td>
							 		</tr>
							  
							  		<tr>
										<td style="font-size:12px; line-height:20px;"><?=find_a_field('user_group','address','id='.$_SESSION['user']['group'])?></td>
									</tr>						
								</table>
						</td>
						<td width="20%">&nbsp;</td>
				</tr>
	
		</table>	
	</td>
  </tr>
  <tr>
   <td colspan="3" align="center"><p>&nbsp;</p>
   <h4 style="font-size:18px; padding:10px 0px; margin:0px; font-family:  'MYRIADPRO-REGULAR'; letter-spacing:1px; text-decoration:underline;"> INVOICE </h4></td>
  </tr>
  
  
   <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  

	<tr width="100%">
		<td width="40%">
			<table width="100%">
					<tr>
						<td colspan="2" width="100%"><div align="justify"><strong>To, </strong></div></td>
					</tr>
					<tr>
						<td width="100%" align="left"><strong><?=$customer->customer_name?></strong></td>
					</tr>
					<tr>
						<td width="100%" align="left"><?=$customer->address?></td>
					</tr>
					<? if ($customer->bin !=''){?>
					<tr>
						<td width="100%" align="left"><strong>BIN:</strong> <?=$customer->bin?></td>
					</tr>
					<? } ?>
			  </table>
		</td>
		
		<td width="20%">&nbsp;  </td>
		
		<td width="40%">
			<table width="100%" border="1" cellspacing="0" cellpadding="1" style="border-collapse: collapse; border: 1px solid black;">
				<tr>
					<th colspan="3" align="center" style="font-weight:bold; font-size:14px"><strong>Invoice</strong></th>
				</tr>
				<tr>
					<th><strong>Invoice # </strong></th>
					<th><strong>Date</strong></th>
					<? if ($customer->bin !=''){?>
					<th><strong>BIN</strong></th><? } ?>
				</tr>
				<tr>
					<td><?=$all->manual_bill_no?></td>
					<td><?php echo date("d-m-Y",strtotime($all->bill_date)); ?></td>
					<? if ($customer->bin !=''){?>
					<td>003408615-0401</td><? } ?>
				</tr>
	<!--			<tr>
				  <td width="47%"><div align="justify">Work Order Date</div></td>
					<td width="53%" align="justify"><strong>:<?//php echo $req_type->req_no;?></strong></td>
				</tr>
				<tr>
				  <td width="47%"><div align="justify">Document No </div></td>
					<td width="53%" align="justify"><strong>:<?//php echo $req_type->req_no;?></strong></td>
				</tr>-->
	<!--			<tr>
				  <td width="47%"><div align="justify"><strong>BIN NO </strong></div></td>
					<td width="53%" align="justify"><strong>:003408615&shy;0401</strong></td>
				</tr>-->
		  </table>	
		 </td>
	</tr>


  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  
  
   <tr>
    <td colspan="3">&nbsp;	</td>
  </tr>
</table>

<div id="pr">
<div align="left">


<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" class="head">
  <tr>
    <td width="126" ><input name="button" type="button" onclick="hide();window.print();" value="Print" /><a href="invoice_print_view_client.php?bill_no=<?=$_REQUEST['bill_no']?>" target="_blank">Client Copy</a></td>
	
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

<table width="800" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5" align="center" style="border-collapse: collapse; border: 1px solid black;">
       <tr align="center">
        <td width="6%" bgcolor="#CCCCCC"><strong>SL</strong></td>
        <td width="40%" bgcolor="#CCCCCC"><strong>Description</strong></td>
        <td width="9%" bgcolor="#CCCCCC"><strong>Total Amount(TAKA) </strong></td>
        
       </tr>
       
	  <?php
$final_amt=(int)$data1[0];
$pi=0;
$total=0;
 $sql2="select b.*, a.type from bill_details b, acc_bill_type a where a.id=b.service_type and b.bill_no='$bill_no'";
$data2=db_query($sql2);
//echo $sql2;
while($info=mysqli_fetch_object($data2)){ 
$pi++;
$tot_ord_qty +=$ord_qty;
$tot_ord_bag +=$ord_bag;
?>
      <tr>
        <td align="center"><?=++$sl?></td>
        <td align="left"><?=$info->type?> for the period of <?=date('M-Y',strtotime($all->bill_date))?></td>
        <td align="right"><?=number_format($info->service_charge,2); $total_amount+=$info->service_charge; $vat=($total_amount*10)/100;$g_total=$total_amount+$vat;?></td>
      </tr>
	   <? }?>
	   
	   <? if($all->discount_amt>0){?>
	   <tr>
        <td align="right" colspan="2">Discount Amount</td>
        <td align="right"><?=number_format($all->discount_amt,2);?></td>
	   </tr>
	   <? } ?>
	   <tr>
        <td align="right" colspan="2">Total Payable Amount</td>
        <td align="right"><?=number_format($net_recv=$total_amount-$all->discount_amt,2);?></td>
      </tr>

</table>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td colspan="2">&nbsp;</td>
        </tr>
		<tr>
			<td width="20%" align="left" ><strong>Amount In Words</strong></td>
        	<td width="80%" align="left">: <?=convertNumberToWordsForIndia($net_recv);?> Taka Only.</td>
        </tr>
		
		<tr>
			<td colspan="2">&nbsp;</td>
        </tr>
		<tr>
			<td colspan="2">&nbsp;</td>
        </tr>
		<tr>
			<td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td align="left"><strong>Account Name</strong></td>
		  <td align="left"><strong>:&nbsp; ERP COM BD LIMITED</strong></td>
        </tr>
		
		<tr>
		  <td align="left">A/C No</td>
		  <td align="left">: &nbsp; 1071070003413</td>
        </tr>
		
        <tr>
		  <td align="left">Bank</td>
		  <td align="left">:&nbsp; Eastern Bank Limited</td>
        </tr>
		
		<tr>
		  <td align="left">Branch</td>
		  <td align="left">: &nbsp; Mirpur</td>
        </tr>
		
		<tr>
		  <td align="left">Routing No </td>
		  <td align="left">:&nbsp; 095262987</td>
        </tr>
		<tr>
			<td colspan="2">&nbsp;</td>
        </tr>
		<tr>
			<td colspan="2">&nbsp;</td>
        </tr>
</table>

<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
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
          <td colspan="5" align="left">Managing Director </td>
        </tr>
		<br />
        <tr>
          <td colspan="5" align="left"><p>ERP COM BD LIMITED </p>
          <p>&nbsp;</p></td>
        </tr>
        
        <tr>
    <td colspan="2">
	<p style=" margin:0px;"><u><b>N.B:</b></u></p>
	<ol>
	  <li  style="line-height:20px; text-align: justify;">To avoid any service interruption, please ensure that payments are made within 10 days.</li>
	  <li  style="line-height:20px; text-align: justify;">For RTGS or BFTN bank transfers, kindly send the corresponding transfer documentation to our email address. Failure to provide this documentation may result in delays or service disruptions. </li>
	  <li  style="line-height:20px; text-align: justify;">ERP COM BD LTD will provide a digital bill copy from 2024. The user will pay the bill directly to the ERP Bank account & send the pay slip to the ERP COM BD LTD service E-mail.</li>
	</ol> 
	</td>
  </tr>
</table>


</body>
</html>
