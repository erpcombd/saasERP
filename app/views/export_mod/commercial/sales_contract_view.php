<?php



//



//====================== EOF ===================



//var_dump($_SESSION);




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

$sc_no 		= $_REQUEST['v_no'];


$sc_data = find_all_field('sales_contract_master','','sc_no='.$sc_no); 



		  $barcode_content = $sc_data->sc_no_view;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';





$dept = 'select sales_contract from warehouse where warehouse_id='.$dept;

$deptt = find_all_field_sql($dept);




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$invoice_no;?></title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
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


  <tr>
     <td colspan="2"><div class="header" style="margin-top:0;">
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
    
		  <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="68%">
                       		<table  width="97%" border="0" cellspacing="0" cellpadding="0"  style="font-size:15px">
								<tr>
					    <td width="50%" align="left" style="padding-bottom:0px;"><img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['user']['depot']?>.png"  width="62%" /></td>
					    <td width="50%" align="left">&nbsp;</td>
							  </tr>
							  
							  


						<tr>
					    <td align="left" width="50%" style="padding-top:25px;"><?='<img style=" margin-left:-8px;  font-size:12px;" class="barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?></td>
					    <td align="left" width="50%">&nbsp;</td>
						</tr>
						
						<tr>
					    <td align="left" width="50%"><span style="font-size:14px; padding: 3px 0 0 5px; letter-spacing:5px;">
						<?=$sc_data->sc_no_view;?></span></td>
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
						  </table>						  </td>                    </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
        </table>
       </div></td>
 </tr>
  

 
 
 
 
 
 

 <tbody>
  
  <tr>
   <td colspan="2" align="center"><h4 style="font-size:18px; padding:10px 0; margin:0; font-family:  'MYRIADPRO-REGULAR'; letter-spacing:1px;text-decoration:underline;">SALES CONTRACT</h4></td>
  </tr>
  
 
  
  
 <tr> 
   <td colspan="2">&nbsp;</td>
 </tr>
		
		
		<tr> <td colspan="2">
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  	<tr style="font-size:14px">
  	  <td valign="top"><strong>SALES CONTRACT NO. : <?=$sc_data->sc_no_view;?></strong></td>
  	  <td valign="middle" align="center">&nbsp;</td>
  	  <td valign="right" align="right"><strong><?php echo date('d-M-Y',strtotime($sc_data->invoice_date));?></strong></td>
	  </tr>
  	<tr>
		<td width="52%" valign="top"></td>
			<td width="23%" valign="middle" align="center">&nbsp;</td>
		<td width="25%" valign="right" align="right">&nbsp;</td>
	</tr>
	
	<?php /*?><tr>
		<td width="25%" valign="top"><strong>Attn: All Concern </strong></td>
			<td width="50%" valign="middle" align="center">&nbsp;</td>
		<td width="25%" valign="right" align="right">&nbsp;</td>
	</tr><?php */?>
	

	<tr>
	  <td colspan="3" valign="top" style="font-size:13px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >
	  WE DO HEREBY CONFIRMING THAT THE SUBJECT AGREEMENT BEEN MADE BETWEEN <?=find_a_field('user_group','group_name','id='.$sc_data->group_for); ?> AND  <?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$sc_data->dealer_code); ?> UNDER THE BELOW	  </td>
	  </tr>
	<tr>
	  <td colspan="3" valign="top" style="font-size:13px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px" >TERMS AND CONDITIONS:</td>
	  </tr>
	<tr>
	  <td colspan="3" valign="top" style="font-size:13px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px" >&nbsp;</td>
	  </tr>
  </table>
  
  </td></tr>
  
  
 
  <tr>
    <td colspan="2"><div id="pr">
        <div align="left">
         
            <input name="button" type="button" onclick="hide();window.print();" value="Print" />
          
         <?php /*?> <nobr>
          <!--<a href="chalan_bill_view.php?v_no=<?=$_REQUEST['v_no']?>">Bill</a>&nbsp;&nbsp;--><!--<a href="do_view.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank"><span style="display:inline-block; font-size:14px; color: #0033FF;">Bill Copy</span></a>-->
          </nobr>
		  <nobr>
          
          <!--<a href="chalan_bill_distributor_vat_copy.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank">Vat Copy</a>-->
          </nobr><?php */?>	    </div>
      </div>	  </td>
	  </tr>
	  
	  
	  
	  
	  
	  <tr>
    <td colspan="2">
      
      <table width="100%" class="tabledesign"   border="1" bordercolor="#0000" cellspacing="0" cellpadding="5"  
	  style="font-size:12px; text-transform:uppercase;">
        
       
        <tr style="font-size:12px;">
          <td width="35%" align="left" valign="center">CONSIGNEE / IMPORTER</td>
          <td width="5%" align="center" valign="center">:</td>
          <td width="60%" align="left" valign="center"> <strong>
		  <? $dealer = find_all_field('dealer_info','','dealer_code='.$sc_data->dealer_code); ?>
		  <?=$dealer->dealer_name_e;?>, <?=$dealer->address_e;?>
		  </strong>
		 </td>
          </tr>
		  
		  <tr style="font-size:12px;">
          <td width="35%" align="left" valign="center">CONSIGNEE/BUYER'S BANK</td>
          <td width="5%" align="center" valign="center">:</td>
          <td width="60%" align="left" valign="center"> <strong>
		  <? $c_bank = find_all_field('bank_buyers','','bank_id='.$sc_data->bank_buyers); ?>
		  <?=$c_bank->bank_name;?>, Account No.: <?=$c_bank->account_no;?>, SWIFT Code: <?=$c_bank->swift_code;?>, Branch: <?=$c_bank->branch_name;?>
		  </strong>
		 </td>
          </tr>
		  
		  
		  <tr style="font-size:12px;">
          <td width="35%" align="left" valign="center">SHIPPER / EXPORTER</td>
          <td width="5%" align="center" valign="center">:</td>
          <td width="60%" align="left" valign="center">
		  <? $company = find_all_field('user_group','','id='.$sc_data->group_for); ?>
		   <strong><?=$company->group_name;?></strong>, Factory: <?=$company->address;?>
		  
		 </td>
          </tr>
		  
		  
		  <tr style="font-size:12px;">
          <td width="35%" align="left" valign="center">SHIPPER'S / SELLER'S BANK</td>
          <td width="5%" align="center" valign="center">:</td>
          <td width="60%" align="left" valign="center"> <strong>
		  <? $s_bank = find_all_field('bank_sellers','','bank_id='.$sc_data->bank_sellers); ?>
		  <?=$s_bank->bank_name;?>,  Branch: <?=$s_bank->branch_name;?>,  A/C No.: <?=$s_bank->account_no;?>, SWIFT Code: <?=$s_bank->swift_code;?>,
		  AD CODE: <?=$s_bank->ad_code;?>
		  </strong>
		 </td>
          </tr>
		  
		  <tr style="font-size:12px;">
          <td width="35%" align="left" valign="center">DESCRIPTION OF COMMODITY</td>
          <td width="5%" align="center" valign="center">:</td>
          <td width="60%" align="left" valign="center">
		  <?=$sc_data->discription_goods; ?>
		 
		 
		 </td>
          </tr>
		  
		  <tr style="font-size:12px;">
          <td width="35%" align="left" valign="center">TOTAL QUANTITY</td>
          <td width="5%" align="center" valign="center">:</td>
          <td width="60%" align="left" valign="center">
		  
		  
		  <? $pi_data_sql="SELECT sum(c.total_unit) as pi_qty, sum(c.total_amt) as pi_value
		  FROM sales_contract_master a, sales_contract b, pi_details c  
		   WHERE a.sc_no=b.sc_no and b.pi_id=c.pi_id and a.sc_no='".$sc_no."' GROUP by b.sc_no ";
		 $pi_qt_vl = find_all_field_sql($pi_data_sql); ?>
		
		
		 <?= number_format($pi_qt_vl->pi_qty,0); ?> Pcs
		 
		 
		 </td>
          </tr>
		  
		  
		  <tr style="font-size:12px;">
          <td width="35%" align="left" valign="center">TOTAL VALUE</td>
          <td width="5%" align="center" valign="center">:</td>
          <td width="60%" align="left" valign="center"> <strong>
		 $ <?= number_format($pi_qt_vl->pi_value,2); ?>
		 </strong>
		 
		 </td>
          </tr>
		  
		  
		  <tr style="font-size:12px;">
          <td width="35%" align="left" valign="center">VALUE IN WORDS</td>
          <td width="5%" align="center" valign="center">:</td>
          <td width="60%" align="left" valign="center"> <strong>
		 
		
		
		<?

		

		$scs =  $pi_qt_vl->pi_value;

			 $credit_amt = explode('.',$scs);

	 if($credit_amt[0]>0){

	 

	 echo convertNumberToWordsForIndia($credit_amt[0]);}

	 if($credit_amt[1]>0){


	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' Cents ';}

	 echo ' Only';

		?>
		 </strong>
		 
		 </td>
          </tr>
		 
		  
		  <tr style="font-size:12px;">
          <td width="35%" align="left" valign="center">TOLERANCE</td>
          <td width="5%" align="center" valign="center">:</td>
          <td width="60%" align="left" valign="center">
		  <?=$sc_data->tolerance; ?>
		 
		 
		 </td>
          </tr>
		  
		  
		  <tr style="font-size:12px;">
          <td width="35%" align="left" valign="center">TERMS OF PAYMENT</td>
          <td width="5%" align="center" valign="center">:</td>
          <td width="60%" align="left" valign="center">
		  <?=$sc_data->payment_terms; ?>
		 
		 
		 </td>
          </tr>
		  
		  <tr style="font-size:12px;">
          <td width="35%" align="left" valign="center">PI. NO. & DATE</td>
          <td width="5%" align="center" valign="center">:</td>
          <td width="60%" align="left" valign="center">
		 <?php /*?> <?=$sc_data->view_pi_no; ?>, Date: <?php echo date('d-m-Y',strtotime($sc_data->pi_date));?><?php */?>
		  
		  
		  <?  
$a=0;
		 $pi_sql = 'SELECT  c.pi_no, c.pi_date FROM sales_contract_master a, sales_contract b, pi_details c 
		 WHERE a.sc_no=b.sc_no  and b.pi_id=c.pi_id and a.sc_no="'.$sc_no.'" GROUP by c.pi_id ';
			$pi_query=db_query($pi_sql);
			while($pi_data= mysqli_fetch_object($pi_query)){
			$a++;
			if ($a>1) echo ', ';
echo $pi_data->pi_no.' Date. '.date('d-m-Y',strtotime($pi_data->pi_date));}?>
		 
		 
		 </td>
          </tr>
		  
		   <tr style="font-size:12px;">
          <td width="35%" align="left" valign="center">SHIPMENT FROM</td>
          <td width="5%" align="center" valign="center">:</td>
          <td width="60%" align="left" valign="center">
		  <? $company = find_all_field('user_group','','id='.$sc_data->group_for); ?>
		   <strong><?=$company->group_name;?></strong>, Factory: <?=$company->address;?>
		  
		 </td>
          </tr>
		  
		  <tr style="font-size:12px;">
          <td width="35%" align="left" valign="center">SHIPMENT TO / DELIVERY ADDRESS</td>
          <td width="5%" align="center" valign="center">:</td>
          <td width="60%" align="left" valign="center">
		  <? $dealer = find_all_field('dealer_info','','dealer_code='.$sc_data->dealer_code); ?>
		  <?=$dealer->dealer_name_e;?>, <?=$dealer->address_e;?>
		  
		 </td>
          </tr>
		  
		  <tr style="font-size:12px;">
          <td width="35%" align="left" valign="center">H.S. CODE</td>
          <td width="5%" align="center" valign="center">:</td>
          <td width="60%" align="left" valign="center">
		  <?=$sc_data->hs_code; ?>
		 
		 
		 </td>
          </tr>
		  
		  
		  <tr style="font-size:12px;">
          <td width="35%" align="left" valign="center">TRADE TERMS / INCOTERMS</td>
          <td width="5%" align="center" valign="center">:</td>
          <td width="60%" align="left" valign="center">
		  <?=$sc_data->trade_terms; ?>
		 
		 
		 </td>
          </tr>
		  
		  <tr style="font-size:12px;">
          <td width="35%" align="left" valign="center">BUYER PO NO</td>
          <td width="5%" align="center" valign="center">:</td>
          <td width="60%" align="left" valign="center">
		   <?  
$o=0;
		 $po_sql = 'SELECT m.customer_po_no, m.customer_po_date
		 FROM sales_contract s, pi_details p, sale_do_master m 
		 WHERE s.pi_id=p.pi_id and p.do_no=m.do_no and s.sc_no="'.$sc_no.'" GROUP by p.do_no ';
			$po_query=db_query($po_sql);
			while($po_data= mysqli_fetch_object($po_query)){
			$o++;
			if ($o>1) echo ', ';
echo $po_data->customer_po_no;}?>
		 
		 
		 </td>
          </tr>
		  
		  
		  <tr style="font-size:12px;">
          <td width="35%" align="left" valign="center">SHIPMENT BY</td>
          <td width="5%" align="center" valign="center">:</td>
          <td width="60%" align="left" valign="center">
		  <?= find_a_field('shipment_mode','shipment_mode','id='.$sc_data->shipment_mode); ?>
		  
		  
		 </td>
          </tr>
		  
		  
		  <tr style="font-size:12px;">
          <td width="35%" align="left" valign="center">PARTIAL SHIPMENT</td>
          <td width="5%" align="center" valign="center">:</td>
          <td width="60%" align="left" valign="center">
		  <?= find_a_field('allow_type','allow_type','id='.$sc_data->partial_shipment); ?>
		  
		  
		 </td>
          </tr>
		  
		   <tr style="font-size:12px;">
          <td width="35%" align="left" valign="center">TRANS SHIPMENT</td>
          <td width="5%" align="center" valign="center">:</td>
          <td width="60%" align="left" valign="center">
		  <?= find_a_field('allow_type','allow_type','id='.$sc_data->trans_shipment); ?>
		  
		  
		 </td>
          </tr>
		  
		  
		   <tr style="font-size:12px;">
          <td width="35%" align="left" valign="center">MODE OF SHIPMENT</td>
          <td width="5%" align="center" valign="center">:</td>
          <td width="60%" align="left" valign="center">
		  <?= $sc_data->mode_of_shipment; ?>
		  
		  
		 </td>
          </tr>
		  
		  
		    <tr style="font-size:12px;">
          <td width="35%" align="left" valign="center">LAST SHIPMENT DATE</td>
          <td width="5%" align="center" valign="center">:</td>
          <td width="60%" align="left" valign="center">
		  <?php echo date('d-M-Y',strtotime($sc_data->last_shipment_date));?>
		 
		 
		 </td>
          </tr>
		  
		  <tr style="font-size:12px;">
          <td width="35%" align="left" valign="center">EXPIRY OF THE CONTRACT</td>
          <td width="5%" align="center" valign="center">:</td>
          <td width="60%" align="left" valign="center">
		  <?php echo date('d-M-Y',strtotime($sc_data->expiry_date));?>
		 
		 
		 </td>
          </tr>
		  
		  
		    <tr style="font-size:12px;">
          <td width="35%" align="left" valign="center">COUNTRY OF ORIGIN</td>
          <td width="5%" align="center" valign="center">:</td>
          <td width="60%" align="left" valign="center">
		  BANGLADESH
		 
		 
		 </td>
          </tr>

		  
		  
       
      </table>      </td>
  </tr>
  
  
  
  
  <tr>
  
  	<td colspan="2">&nbsp;</td>
  </tr>
  
  
  
	
  
  
  
  
  <tr>
  	<td colspan="3">
			<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >
        
        
        
		  
		  
		  
		  

        <tr>
          <td colspan="3" align="left" style="font-size:13px; font-weight:400; letter-spacing:.3px; text-transform:uppercase;">
		  WE AGREED ON ABOVE INFORMATION AND HAVE THE SAME OPINION.
		  </td>
        </tr>
		
		 
        
      
        <tr>
          <td colspan="3" align="left">&nbsp;</td>
        </tr>
		
		<tr>
          <td colspan="3" align="left">
		  	<table  width="100%" class="tabledesign" border="0" bordercolor="#CCCCCC" cellspacing="0"   >
				<tr>
          <td colspan="2"  style="font-size:14px; border-right:0;  padding: 6px 0 5px 0; " valign="top"><div align="center"><strong>NOTE:</strong></div></td>
          <td align="left"  width="93%" style="font-size:14px;  border-left:0; line-height:18px; padding: 5px 0 5px 0; "> 
		  ANY SORT OF CLAIMS ACCEPTED BY THE NATIVE PACKAGES LTD, VALUE MUST NOT BE MORE THAN THE PI VALUE.		  </td>
        </tr>
			</table>		  </td>
        </tr>
      </table>	</td>
  </tr>
	
	
	
	

	<tr>
		<td colspan="2">
	
	
	<!-- style="border:1px solid #000; color: #000;"-->
	      <div class="footer"> 
	
	<table width="100%" cellspacing="0" cellpadding="0"  >
		<tr style="font-size:12px">
		  <td width="25%" align="center">&nbsp;</td>
		  <td width="25%"  align="center">&nbsp;</td>
		  <td width="25%"  align="center">&nbsp;</td>
		  <td width="25%" align="center">&nbsp;</td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="center" style="font-size:14px; text-transform: capitalize; font-weight:700;">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center" style="font-size:14px; text-transform: capitalize; font-weight:700;">&nbsp;</td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="center">CONFIRM BY SELLER</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center">ACCEPT BY BUYER</td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<td align="center">
		 <?php /*?> <? if ($master->digital_sign>0) {?>	<? }?>	<?php */?>
		  	<p style="font-size:35px; color:#000000; margin:0; padding: 0; font-family: 'Humaira demo'; font-weight:400; ">Walid Islam</p>
			<p style="font-size:11px;  margin:-8px 0 0 -20px;  padding: 0 ; letter-spacing:.3px; color: #999999; ">Digitally signed in ERP system</p>		  </td>
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="center"><hr /></td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center"><hr /></td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="center">Authorized Signature</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center">Authorized Signature</td>
		  </tr>
		<tr style="font-size:14px; text-transform:uppercase; font-weight:700;">
		  <td align="center" ><?=$company->group_name;?></td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center"><?=$dealer->dealer_name_e;?></td>
		  </tr>
		
		<tr>
            <td colspan="2"><?php /*?>Prepared By :
                <?=find_a_field('user_activity_management','fname','user_id='.$master->entry_by);?>,&nbsp; Prepared At :
                <?=$master->entry_at?> <?php */?> This is an ERP generated report </td>
		    <td colspan="2" align="left">&nbsp;</td>
		    </tr>
	
	<?php /*?><tr>
            <td colspan="4">  <hr /> </td>
		</tr><?php */?>
	
        
	
         <?php /*?> <tr>
            <td colspan="4" style="border:0px;border-color:#FFF; color: #000; font-size:16px; text-transform:uppercase; font-weight:700;" align="center" >Nassa Group</td>
		</tr>
		  <tr>
			 <td colspan="4" style="border:0px;border-color:#FFF; color: #000;  font-size:12px; " align="center" >Head Office: 238, Tejgaon Industrial Area, Gulshan Link Road, Dhaka -1208.</td>
		</tr>
		  <tr>
			 <td colspan="4" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Phone: 
			  88-02- 8878543-49. Cell :- +88 01401140030</td>
          </tr>
		  <tr>
			 <td colspan="4" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Web: 
			 www.nassagroup.org</td>
          </tr><?php */?>
	</table>
	  </div>	</td>
  </tr>
   </tbody>
</table>
</body>
</html>
