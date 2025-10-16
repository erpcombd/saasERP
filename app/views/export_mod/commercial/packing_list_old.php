<?php



//



//====================== EOF ===================



//var_dump($_SESSION);




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

$lc_no 		= $_REQUEST['v_no'];

$proj_all=find_all_field('project_info','*','1');
$lc_data = find_all_field('lc_master','','lc_no='.$lc_no); 



 $buyer_bank = find_all_field('bank_buyers','','bank_id='.$lc_data->bank_buyers); 
 $seller_bank = find_all_field('bank_sellers','','bank_id='.$lc_data->bank_sellers); 
 $dealer = find_all_field('dealer_info','','dealer_code='.$lc_data->dealer_code); 



		  $barcode_content = $lc_data->lc_no_view;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';



foreach($challan as $key=>$value){
$$key=$value;
}

// $lc_sql = 'SELECT  sum(w.us_amount) as lc_value FROM lc_receive l, pi_details p, lc_workorder_details w 
//		 WHERE l.pi_id=p.pi_id  and p.do_no=w.wo_id and l.lc_no="'.$lc_data->lc_no.'" GROUP by l.lc_no ';
//$lc_value = find_all_field_sql($lc_sql);

 $vl_sql = 'SELECT  sum(s.total_amt) as lc_value FROM lc_receive a, pi_details b, sale_do_details s WHERE  a.pi_id=b.pi_id and b.do_no=s.do_no and a.lc_no="'.$lc_no.'" GROUP by a.lc_no ';
$lc_value = find_all_field_sql($vl_sql);


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
					    <td width="50%" align="left" style="padding-bottom:0px;"><img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$proj_all->proj_img;?>"  width="27%" /></td>
					    <td width="50%" align="left">&nbsp;</td>
							  </tr>
							  
							  


						<tr>
					    <td align="left" width="50%" style="padding-top:25px;"><?='<img style=" margin-left:-8px;  font-size:12px;" class="barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?></td>
					    <td align="left" width="50%">&nbsp;</td>
						</tr>
						
						<tr>
					    <td align="left" width="50%"><span style="font-size:14px; padding: 3px 0 0 5px; letter-spacing:5px;"><?=$lc_data->lc_no_view;?></span></td>
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
									   font-weight:500; font-family: 'TradeGothicLTStd-Extended'; "><? $company_data=find_all_field('user_group','','1')?>
									   
									  <?=$company_data->group_name;?>.
									  </span></td>
							  </tr>
							  
							  
									<tr><td style="padding-bottom:3px; font-size:12px;"><?=$company_data->address;?></td>
									</tr>
									
									<tr><td style="padding-bottom:3px; font-size:12px;">Phone No. : <?=$company_data->phone_no;?></td>
									</tr>
									<tr><td style="padding-bottom:3px; font-size:12px;">Email: <?=$company_data->email;?></td>
									</tr>
									
							  
							  <tr><td style="padding-bottom:3px;  font-size:12px;">BIN/VAT Reg. No. : <?=$company_data->bin_reg_no;?></td>
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
   <td colspan="2" align="center"><h4 style="font-size:22px; padding:10px 0; margin:0; font-family:  'MYRIADPRO-REGULAR'; letter-spacing:1px;text-decoration:underline;">
   PACKING LIST</h4></td>
  </tr>
  
 
  
  

		
		
		<tr> <td colspan="2">
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  	<tr>
		<td width="25%" valign="top">INVOICE NO : <?=$lc_data->lc_no_view;?></td>
			<td width="50%" valign="middle" align="center">&nbsp;</td>
		<td width="25%" valign="right" align="right"></td>
	</tr>
  	<tr>
		<td width="25%" valign="top">Date : <?php echo date('d-m-Y',strtotime($lc_data->lc_date));?></td>
			<td width="50%" valign="middle" align="center">&nbsp;</td>
		<td width="25%" valign="right" align="right"> </td>
	</tr>

  	<tr>
  	  <td valign="top">&nbsp;</td>
  	  <td valign="middle" align="center">&nbsp;</td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
	   
  	<tr>
  	  <td valign="top">&nbsp;</td>
  	  <td valign="middle" align="center">&nbsp;</td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
 
	    	<tr style="font-weight:bold;">
  	  <td valign="top">LC NO : <?=$lc_data->export_lc_no;?></td>
  	  <td valign="middle" align="left">Date : <?php echo date('d-m-Y',strtotime($lc_data->export_lc_date));?></td>
	  <td valign="right" align="right"></td>
	  </tr>
	   
		  	<tr style="font-weight:bold;">
  	  <td valign="top" colspan="2">Export Sales Contract No : <?=$lc_data->exp_no;?>   &nbsp;&nbsp; Date : <?php 
	  if($lc_data->exp_date>0){
	  echo date('d-m-Y',strtotime($lc_data->exp_date)); } else{
	  echo '00-00-0000';
	  }?></td>
  	  <td valign="middle" align="left"></td>
	  
	  </tr>
	   
	  	<tr style="font-weight:bold;">
  	  <td valign="top" colspan="2"><?php if($lc_data->importer_irc_no!='' ){?>APPICANT'S IRC NO : <?=$lc_data->importer_irc_no;?>&nbsp; <?php } ?>         <?php if($lc_data->appplicant_erc_no!='' ){?> ERC NO : <?=$lc_data->appplicant_erc_no;?> <?php } ?></td>
  
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
	 
	  <tr style="font-weight:bold;">
  	  <td valign="top" colspan="2" ><?php if($lc_data->applicants_bin_no!='' ){?>APPICANT'S BIN NO : <?=$lc_data->applicants_bin_no;?>&nbsp;<?php } ?>       <?php if($lc_data->applicants_tin_no!='' ){?> TIN NO : <?=$lc_data->applicants_tin_no;?><?php } ?></td>
  	   
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
	  <?php if($lc_data->issuing_bank_bin_no!='' ){?><tr style="font-weight:bold;">
  	  <td valign="top">ISSUING BANK BIN NO : <?=$lc_data->issuing_bank_bin_no;?></td>
  	  <td valign="middle" align="center"></td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
	  <?php } ?>
	  	  <tr style="font-weight:bold;">
  	  <td valign="top">H.S. CODE NO :  <?php echo  find_a_field('pi_master p,lc_receive b','p.hs_code','b.pi_id=p.pi_id and b.lc_no="'.$lc_no.'"'); ?></td>
  	  <td valign="middle" align="center"></td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
	  	<tr>
  	  <td valign="top">&nbsp;</td>
  	  <td valign="middle" align="center">&nbsp;</td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
  	<tr>
  	  <td valign="top">MS:</td>
  	  <td valign="middle" align="center">&nbsp;</td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
	  <tr>
  	  <td valign="top"><?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$lc_data->dealer_code);?></td>
  	  <td valign="middle" align="center"></td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
	  <tr>
  	  <td valign="top"><?= find_a_field('dealer_info','address_e','dealer_code='.$lc_data->dealer_code);?></td>
  	  <td valign="middle" align="center">&nbsp;</td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
  	<tr>
  	  <td valign="top">&nbsp;</td>
  	  <td valign="middle" align="center">&nbsp;</td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>

	  <tr>
  	  <td valign="top">TO:</td>
  	  <td valign="middle" align="center">&nbsp;</td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
	  <tr>
  	  <td valign="top"><?=$buyer_bank->bank_name;?></td>
  	  <td valign="middle" align="center">&nbsp;</td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
	  <tr>
  	  <td valign="top"><?=$buyer_bank->branch_name;?></td>
  	  <td valign="middle" align="center">&nbsp;</td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
	
	<?php /*?><tr>
		<td width="25%" valign="top"><strong>Attn: All Concern </strong></td>
			<td width="50%" valign="middle" align="center">&nbsp;</td>
		<td width="25%" valign="right" align="right">&nbsp;</td>
	</tr><?php */?>
	
	
	<tr>
	  <td colspan="3" valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" ><div align="justify">
	 
		  

	  
	  </div></td>
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
	  
	  
 
	  
	  
	  
	  <tr>
    <td colspan="2">
      
      <table width="100%" class="tabledesign"   border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="5"  style="font-size:12px">
       <tr >
          <th   align="center" bgcolor="#CCCCCC">SL</th>
          <th   align="center" bgcolor="#CCCCCC">Item Name </th>
		   <th   align="center" bgcolor="#CCCCCC">Mesurement</th>
		  <!--  <th   align="center" bgcolor="#CCCCCC">Size </th>-->
			<th   align="center" bgcolor="#CCCCCC">Style/PO </th>
			<!--<th   align="center" bgcolor="#CCCCCC">Color </th>-->
          <th   align="center"  bgcolor="#CCCCCC">UOM</th>
          <th  align="center" bgcolor="#CCCCCC">Quantity</th>
       
        </tr>
		
 
        
        <?  
		
//		  $sqlc = 'select w.*, i.item_name, i.unit_name from lc_receive l, pi_details p, lc_workorder_details w, item_info i 
//		 where l.pi_id=p.pi_id  and p.do_no=w.wo_id and w.item_id=i.item_id and l.lc_no='.$lc_no.' order by w.wo_id, w.id ';
//			$queryc=db_query($sqlc);
//			while($datac = mysqli_fetch_object($queryc)){
				 $sqlc = 'select s.*, i.item_name, i.unit_name from lc_receive r, pi_details c, sale_do_details s, item_info i where r.pi_id=c.pi_id and i.item_id=s.item_id and c.do_no=s.do_no 
		 and r.lc_no='.$lc_no.' group by s.id order by s.item_id ';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			?>
        <tr style="font-size:12px;">
          <td align="center" valign="top"><?=++$kk;?></td>
          <td align="left" valign="top"><?=$datac->item_name;?></td>
		 <td align="left" valign="top"><?=$datac->measurement;?></td>
			<!--  <td align="left" valign="top"><?=$datac->size;?></td>-->
			    <td align="left" valign="top"><?=$datac->style_no;?></td>
				 <!-- <td align="left" valign="top"><?=$datac->color;?></td>-->
          <td align="center" valign="top"><?=$datac->unit_name;?></td>
          <td align="center" valign="top"><?=number_format($datac->total_unit,0); $grand_tot_unit1 +=$datac->total_unit; ?></td>
         
        </tr>
        
        <? }
		
		?>
	
        <tr style="font-size:12px;">
        <td colspan="5" align="right" valign="middle"><strong> Total:</strong></td>
       
        <td align="center" valign="middle"><strong>
          <?=number_format($grand_tot_unit1,0) ;?>
        </strong></td>
     
        </tr>
      </table>      </td>
  </tr>
	  
	  
	  <tr>
	 
	 <td colspan="2" align="left"  style="font-size:14px; text-transform: uppercase; letter-spacing: .3px; line-height:20px;"> <div align="justify">
	 

WE HEREBY CERTIFY THAT THE GOODS HAVE BEEN SHIPPED STRICTLY IN ACCORDANCE WITH THE TERMS OF THE PROFORMA INVOICE AS STATED ABOVE AND ALL THE TERMS & CONDITIONS THEREOF HAVE BEEN FULLY COMPLIED WITH. <br />

<b>PROFORMA INVOICE NO. <?  
$a=0;
		 $pi_sql = 'SELECT  c.pi_no, c.pi_date FROM lc_master a, lc_receive b, pi_details c 
		 WHERE a.lc_no=b.lc_no  and b.pi_id=c.pi_id and a.lc_no="'.$lc_no.'" GROUP by c.pi_id ';
			$pi_query=db_query($pi_sql);
			while($pi_data= mysqli_fetch_object($pi_query)){
			$a++;
			if ($a>1) echo ', ';
echo find_a_field('pi_master','manual_pi_no','pi_no="'.$pi_data->pi_no.'"').' Date. '.date('d-m-Y',strtotime($pi_data->pi_date));}?>.</b>  <? if($lc_data->importer_irc_no!="") {?> Importer IRC No: <?= $lc_data->importer_irc_no; ?><? }?><? if($lc_data->applicants_tin_no!="") {?>, Applicant's TIN No: <?= $lc_data->applicants_tin_no; ?><? }?><? if($lc_data->applicants_bin_no!="") {?>, Applicant's BIN No: <?= $lc_data->applicants_bin_no; ?><? }?><? if($lc_data->bangladesh_bank_dc_no!="") {?>, Bangladesh Bank DC No: <?= $lc_data->bangladesh_bank_dc_no; ?><? }?><? if($lc_data->issuing_bank_bin_no!="") {?>, Issuing Bank BIN No: <?= $lc_data->issuing_bank_bin_no; ?>.<? }?> </b> <br />
THE IMPORT IS BEING MADE UNDER BACK TO BACK SYSTEM AGAINST EXPORT CONTRACT AND SHIPMENT MADE FROM <?=find_a_field('user_group','group_name','1')?> TO <?=$dealer->dealer_name_e?>. <?=$dealer->address_e?>. 

	 
	 </div></td>
	  </tr>
	  
	  
	  
  
  
  
  
  
  
  
	
	
	
	

	<tr>
		<td colspan="2">
	
	
	<!-- style="border:1px solid #000; color: #000;"-->
	      <div class="footer"> 
	
	<table width="100%" cellspacing="0" cellpadding="0"  >
		 
		 
		
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr style="font-size:12px">
		  <td width="37%" align="center">&nbsp;</td>
		  <td width="13%"  align="center">&nbsp;</td>
		  <td width="20%"  align="center">&nbsp;</td>
		  <td width="30%" align="center">&nbsp;</td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="left" style="font-size:14px; text-transform: capitalize; font-weight:700;">&nbsp;</td>
		  <td  align="left">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center" style="font-size:16px; text-transform: uppercase; font-weight:700;"><?=find_a_field('user_group','group_name','id='.$_SESSION['user']['group'])?></td>
		  </tr>
		
	
		<tr style="font-size:12px" >
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		


		  
		
	
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center"><hr /></td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="left">
This is an ERP generated report </td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center" style="text-transform: uppercase; font-size: 16px; font-weight:700;">Authorized Signature</td>
		  </tr>
	

	</table>
	  </div>	</td>
  </tr>
   </tbody>
</table>
</body>
</html>
