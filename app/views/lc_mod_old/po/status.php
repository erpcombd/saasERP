<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$proj_all=find_all_field('project_info','*','1');
$po_no 		= $_REQUEST['po_no'];

 $condition="po_no=".$po_no;
$data=find_all_field('lc_purchase_master','*',$condition);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$lc_data->lc_no_view;?></title>
<link href="../../../assets/css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">



function hide()



{



    document.getElementById("pr").style.display="none";



}



</script>
<style type="text/css">




<!--
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
<body style="font-family: Arial, Helvetica, sans-serif; font-size: 10px;">
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">




 <tbody>
  
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
   <td colspan="2" align="center"><h4 style="font-size:22px; padding:10px 0; margin:0; font-family:  'MYRIADPRO-REGULAR'; letter-spacing:1px;text-decoration:underline;">
   PI Information</h4></td>
  </tr>
  
 
  
  
 <tr> <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>
		    <td valign="top">&nbsp;</td>
	      </tr>
		  <tr>


		    <td width="68%" valign="top">&nbsp;	        </td>
		  </tr>


		</table>		</td></tr>
		
		
		<tr> <td colspan="2">
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:14px">
  	
  	<tr>
  	  <td valign="top">&nbsp;</td>
  	  <td valign="middle" align="center">&nbsp;</td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
  	<tr  >
  	  <td valign="top">Entry Date: <strong><?=$data->po_date;?></strong></td>
	  <td>&nbsp;</td>
  	  <td valign="middle" align="left">Company: <strong><?=find_a_field('user_group','group_name','id="'.$data->group_for.'"')?></strong> </td>
	  </tr>
	  <tr  >
  	  <td valign="top">PI NO: <strong><?=$pi_no?></strong></td>
	  <td>&nbsp;</td>
  	  <td valign="middle" align="left">Reference No: <strong><?=find_a_field('lc_pi_reference_setup','pi_number','id="'.$data->pi_reference.'"')?></strong></td>
	  </tr>
	  <tr  >
  	  <td valign="top">PI Date:	<strong><?=$data->pi_date?></strong></td>
	  <td>&nbsp;</td>
  	  <td valign="middle" align="left">H.S. Code: <strong><?=$data->hs_code?></strong></td>
	  </tr>
	  <tr  >
  	  <td valign="top">Inco Tearms: <strong><?=find_a_field('inco_tearms','inco_tearms','id="'.$data->inco_tearms.'"')?></strong></td>
	  <td>&nbsp;</td>
  	  <td valign="middle" align="left">Date Of Shipment: <strong><?=$data->date_of_shipment?></strong></td>
	  </tr>
	  <tr  >
  	  <td valign="top">Port Of Shipment: <strong><?=$data->port_of_shipment?></strong></td>
	  <td>&nbsp;</td>
  	  <td valign="middle" align="left">Place Of Expiry: <strong><?=$data->place_of_expiry?> </strong></td>
	  </tr>
	  <tr  >
  	  <td valign="top">Port Of Destination: <strong><?=$data->port_of_destination?></strong></td>
	  <td>&nbsp;</td>
  	  <td valign="middle" align="left">Available With By: <strong><?=$data->available_with_by?></strong></td>
	  </tr>
	  <tr  >
  	  <td valign="top">Partial Shipment: <strong><?=$data->partial_shipment?></strong></td>
	  <td>&nbsp;</td>
  	  <td valign="middle" align="left">Shipping Mark: <strong><?=$data->shipping_mark?></strong></td>
	  </tr><tr  >
  	  <td valign="top">Trans Shipment: <strong><?=$data->trans_shipment?></strong></td>
	  <td>&nbsp;</td>
  	  <td valign="middle" align="left">Beneficiary: <strong><?=$data->beneficiary?></strong></td>
	  </tr><tr  >
  	  <td valign="top">Terms Of Payment: <strong><?=$data->trans_of_payment?></strong></td>
	  <td>&nbsp;</td>
  	  <td valign="middle" align="left">Beneficiary Bank: <strong><?=$data->beneficiary_bank?></strong></td>
	  </tr><tr  >
  	  <td valign="top">Packing: <strong><?=$data->packing?></strong></td>
	  <td>&nbsp;</td>
  	  <td valign="middle" align="left">Bank Swift Code: <strong><?=$data->bank_swift_code?></strong></td>
	  </tr><tr  >
  	  <td valign="top">Supplier Name: <strong><?=find_a_field('vendor','vendor_name','vendor_id="'.$data->vendor_id.'"')?></strong></td>
	  <td>&nbsp;</td>
  	  <td valign="middle" align="left">Bank Address: <strong><?=$data->bank_address?></strong></td>
	  </tr>
	  <tr  >
  	  <td valign="top">Suppliers Agent: <strong><?=find_a_field('agent_info','agent_name','agent_id="'.$data->supplier_agent.'"')?></strong></td>
	  <td>&nbsp;</td>
  	  <td valign="middle" align="left">A/C NO: <strong><?=$data->bank_Ac_no?></strong></td>
	  </tr>
	  <tr  >
  	  <td valign="top">Suppliers Bank Details: <strong><?=$data->supplier_bank_details?></strong></td>
	  <td>&nbsp;</td>
  	  <td valign="middle" align="left">Remarks: <strong><?=$data->remarks?></strong></td>
	  </tr>
	  
	   

  </table>
  
  </td></tr>
  
  
 
  <tr>
    <td colspan="2"><div id="pr">
        <div align="left">
         
            <input name="button" type="button" onclick="hide();window.print();" value="Print" />
             </div>
      </div>	  </td>
	  </tr>
	  
	  
	  <?php /*?><tr>
	 <td  width="75%"  style="font-size:12px; " align="right">&nbsp;</td>
	  <td  width="25%"  style="font-size:12px; padding-bottom: 10px; " align="right"><div style=" padding:8px 40px; border:2px solid   #CCCCCC; text-align:center; font-size:12px; font-weight:200;" >
	   H.S. Code 4819.10.00
	  </div></td>
	  </tr><?php */?>
	  
	  
	  
	  <tr>
    <td colspan="2">
      
      <table width="100%" class="tabledesign"   border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="5"  style="font-size:12px">
       
        <tr>
          <th   align="center" bgcolor="#CCCCCC">SL</th>
          <th   align="center" bgcolor="#CCCCCC">Item Name </th>
		  <th   align="center" bgcolor="#CCCCCC">Unit</th>
		  <th   align="center" bgcolor="#CCCCCC">Specification</th>
          <th   align="center"  bgcolor="#CCCCCC">Quantity</th>
          <th  align="center" bgcolor="#CCCCCC">Rate(USD$)</th>
		  <th  align="center" bgcolor="#CCCCCC">Amount(USD$) </th>
       
        </tr>
        
<?
$s=0;
 $res='select a.id, b.item_name, a.specification,  a.rate as unit_price,
 a.qty, a.unit_name, a.amount,  a.rate_usd, a.amount_usd, a.rate_ud, a.amount_ud,a.unit_name
 
  from lc_purchase_invoice a,item_info b where b.item_id=a.item_id  and a.po_no="'.$data->po_no.'" order by id asc';

$query=db_query($res);

while($datac=mysqli_fetch_object($query)){
?>

		<tr style="font-size:12px;">
          <td align="center" valign="top"><?=++$s;?></td>
          <td align="left" valign="top"><?=$datac->item_name;?></td>
		 <td align="left" valign="top"><?=$datac->unit_name;?></td>
		 
			    <td align="left" valign="top"><?=$datac->specification;?></td>
				 
          <td align="center" valign="top"><?=$datac->qty;?></td>
		  <td align="center" valign="top"><?=$datac->rate_usd;?></td>
		  <td align="center" valign="top"><?=$datac->amount_usd; $tp+=$datac->amount_usd;?></td>
         
        </tr>
        
        <? } ?>
		
        <tr style="font-size:12px;">
        <td colspan="6" align="right" valign="middle"><strong> Total:</strong></td>
        
        <td align="center" valign="middle"><strong>
          <?=number_format($tp,2) ;?>
        </strong></td>
 
        </tr>
      </table>      </td>
  </tr>
	  
	  
	
   </tbody>
</table>
</body>
</html>
