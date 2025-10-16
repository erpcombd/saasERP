<?php



//



//====================== EOF ===================



//var_dump($_SESSION);




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once SERVER_CORE."core/class.numbertoword.php";

$lc_no 		= $_REQUEST['v_no'];

$proj_all=find_all_field('project_info','*','1');
$lc_data = find_all_field('lc_master','','lc_no='.$lc_no); 



 $buyer_bank = find_all_field('bank_buyers','','bank_id='.$lc_data->bank_buyers); 
 $seller_bank = find_all_field('bank_sellers','','bank_id='.$lc_data->bank_sellers); 
// $dealer = find_all_field('lc_buyer','','id='.$lc_data->dealer_code); 
$dealer=find_all_field('dealer_info','*','dealer_code="'.$lc_data->dealer_code.'"');


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

 $vl_sql = 'SELECT  sum(s.total_amt) as lc_value FROM lc_receive a, pi_details b, sale_do_details_foreign s WHERE  a.pi_id=b.pi_id and b.do_no=s.do_no and a.lc_no="'.$lc_no.'" GROUP by a.lc_no ';
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
									   font-weight:500; font-family: 'TradeGothicLTStd-Extended'; "><? $company_data=find_all_field('user_group','','1');?>
									   
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
   <td colspan="2" align="center"><h4 style="font-size:18px; padding:10px 0; margin:0; font-family:  'MYRIADPRO-REGULAR'; letter-spacing:1px;text-decoration:underline;">BILL OF EXCHANGE-1</h4></td>
  </tr>
  
 
  
  
 <tr> <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="68%" valign="top">&nbsp;	        </td>
		  </tr>


		</table>		</td></tr>
		
		
		<tr> <td colspan="2">
		<br />
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:14px">
  <tr>
		<td width="25%" valign="top">Date: <?php //echo date('d-m-Y',strtotime($lc_data->lc_date));?></td>
			<td width="50%" valign="middle" align="center">&nbsp;</td>
		<td width="25%" valign="right" align="right"> </td>
	</tr>
  	<tr>
		<td width="25%" valign="top">Bill No: <?=$lc_data->lc_no_view;?></td>
			<td width="50%" valign="middle" align="center">&nbsp;</td>
		<td width="25%" valign="right" align="right"></td>
	</tr>
  	<tr>
  	  <td valign="top"><strong>Exchange for US$ 
  	      <?=$lc_value->lc_value;?>
  	  </strong></td>
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
	  <? if($lc_data->amd_no!='' || $lc_data->amd_no!=''){?>
	  	   <tr style="font-weight:bold;">
  	  <td valign="top">	Amendment No : <?=$lc_data->amd_no;?></td>
  	  <td valign="middle" align="left">Date : <?php echo date('d-m-Y',strtotime($lc_data->amd_date));?></td>
	  <td valign="right" align="right"></td>
	  </tr>
	  <? }?>
	  <? 
	  $lquery=db_query('select * from lc_export_contact where lc_no='.$lc_no);
	  while($ldata=mysqli_fetch_object($lquery)){
	  ?> 
		  	<tr style="font-weight:bold;">
  	  <td valign="top" colspan="2">Export Sales Contract No : <?=$ldata->contact;?>  &nbsp;&nbsp; Date : <?=$ldata->date?></td>
	  
	  <? }?>
  	 
	  <td valign="right" align="left"></td>
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
  	  <td valign="top" colspan="2">ISSUING BANK BIN NO : <?=$lc_data->issuing_bank_bin_no;?></td>
  
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
	  <?php } ?>
	  	  <tr style="font-weight:bold;">
  	  <td valign="top">H.S. CODE NO :  <?php echo  find_a_field('pi_master p,lc_receive b','p.hs_code','b.pi_id=p.pi_id and b.lc_no="'.$lc_no.'"'); ?></td>
  	  <td valign="middle" align="center"></td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
	<?php /*?><tr>
		<td width="25%" valign="top"><strong>Attn: All Concern </strong></td>
			<td width="50%" valign="middle" align="center">&nbsp;</td>
		<td width="25%" valign="right" align="right">&nbsp;</td>
	</tr><?php */?>
	
	
	<tr>
	  <td colspan="3" valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px" ><div align="justify">
	  <br />
	  At <?php if($lc_data->tenor_days=="AT SIGHT"){echo "SIGHT";}else{echo $lc_data->tenor_days;};?> days of this First Bill of Exchange (Second of the same tenor and  date  being unpaid) pay to the order of  <?=$seller_bank->bank_name;?>, 
	  <?=$seller_bank->branch_name;?> the sum of  <strong>U.S DOLLAR (
		 <?
		$scs =  $lc_value->lc_value;

			 $credit_amt = explode('.',$scs);

	 if($credit_amt[0]>0){

	 

	 echo convertNumberToWordsForIndia($credit_amt[0]);}

	 if($credit_amt[1]>0){


	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' Cents ';}

	 echo ' Only.';

		?>)
		 </strong>  
		 .</b>   
		 <br />
		 <b>As per PROFORMA INVOICE NO. <?  
$a=0;
		 $pi_sql = 'SELECT  c.pi_no, c.pi_date FROM lc_master a, lc_receive b, pi_details c 
		 WHERE a.lc_no=b.lc_no  and b.pi_id=c.pi_id and a.lc_no="'.$lc_no.'" GROUP by c.pi_id ';
			$pi_query=db_query($pi_sql);
			while($pi_data= mysqli_fetch_object($pi_query)){
			$a++;
			if ($a>1) echo ', ';
echo find_a_field('pi_master','manual_pi_no','pi_no="'.$pi_data->pi_no.'"').' Date. '.date('d-m-Y',strtotime($pi_data->pi_date));}?></b>
	  
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
	 <td  width="75%"  style="font-size:12px; " align="right">&nbsp;</td>
	  <td  width="25%"  style="font-size:12px; padding-bottom: 10px; " align="right">&nbsp;</td>
	  </tr>
	  
	  
	  
  
  
  
  
  
  
  
	
	
	
	

	<tr>
		<td colspan="2">
	
	
	<!-- style="border:1px solid #000; color: #000;"-->
	      <div class="footer"> 
	
	<table width="100%" cellspacing="0" cellpadding="0"  >
	
		  <tr style="font-size:12px">
		  <td align="left" style="font-size:16px; text-transform: capitalize; font-weight:700;">To </td>
		  <td  align="left">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center" style="font-size:16px; text-transform: uppercase; font-weight:700;"></td>
		  </tr>
		  <tr style="font-size:12px">
		  <td align="left" style="font-size:16px; text-transform:uppercase;"><?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$lc_data->dealer_code);?></td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		  <tr style="font-size:12px">
		  <td align="left" style="font-size:16px; text-transform:uppercase;"><?= find_a_field('dealer_info','address_e','dealer_code='.$lc_data->dealer_code);?></td>
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
		  <td align="left" style="font-size:16px; text-transform: capitalize; font-weight:700;">A/C </td>
		  <td  align="left">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center" style="font-size:16px; text-transform: uppercase; font-weight:700;"> </td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="left" style="font-size:16px; text-transform:uppercase;"><?=$buyer_bank->bank_name;?></td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="left" style="font-size:14px; text-transform:uppercase; font-weight:300"><?=$buyer_bank->branch_name;?></td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr style="font-size:12px" >
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;					  </td>
		  </tr>
		

		  
		<?php /*?>  <tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center" style="font-size:12px;  border-left:0;  padding: 0 0 5px 0; letter-spacing:.3px; ">Digitally signed in ERP system</td>
		  </tr>
		  
		  <tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="left" style="font-size:12px;  border-left:0;  padding: 0px 0 0 47px; letter-spacing:1px; "><?=$master->digital_sign?></td>
		  </tr><?php */?>
		  
		
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
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center"><hr /></td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="left"><?php /*?>Prepared By :
                <?=find_a_field('user_activity_management','fname','user_id='.$master->entry_by);?>,&nbsp; Prepared At :
                <?=$master->entry_at?> <?php */?>
This is an ERP generated report </td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center" style="text-transform: uppercase; font-size: 16px; font-weight:700;">Authorized Signature</td>
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


<br /><br />
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />







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
									   font-weight:500; font-family: 'TradeGothicLTStd-Extended'; "><? $company_data=find_all_field('user_group','','1');?>
									   
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
   <td colspan="2" align="center"><h4 style="font-size:18px; padding:10px 0; margin:0; font-family:  'MYRIADPRO-REGULAR'; letter-spacing:1px;text-decoration:underline;">BILL OF EXCHANGE - 2 </h4></td>
  </tr>
  
 
  
  
 <tr> <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="68%" valign="top">&nbsp;	        </td>
		  </tr>


		</table>		</td></tr>
		
		
		<tr> <td colspan="2">
		<br />
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:14px">
  <tr>
		<td width="25%" valign="top">Date: <?php  //date('d-m-Y',strtotime($lc_data->lc_date));?></td>
			<td width="50%" valign="middle" align="center">&nbsp;</td>
		<td width="25%" valign="right" align="right"> </td>
	</tr>
  	<tr>
		<td width="25%" valign="top">Bill No: <?=$lc_data->lc_no_view;?></td>
			<td width="50%" valign="middle" align="center">&nbsp;</td>
		<td width="25%" valign="right" align="right"></td>
	</tr>
  	<tr>
  	  <td valign="top"><strong>Exchange for US$ 
  	      <?=$lc_value->lc_value;?>
  	  </strong></td>
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
	  	  <? if($lc_data->amd_no!='' || $lc_data->amd_no!=''){?>
	  	   <tr style="font-weight:bold;">
  	  <td valign="top">	Amendment No : <?=$lc_data->amd_no;?></td>
  	  <td valign="middle" align="left">Date : <?php echo date('d-m-Y',strtotime($lc_data->amd_date));?></td>
	  <td valign="right" align="right"></td>
	  </tr>
	  <? }?>
	    
	  <? 
	  $lquery=db_query('select * from lc_export_contact where lc_no='.$lc_no);
	  while($ldata=mysqli_fetch_object($lquery)){
	  ?> 
		  	<tr style="font-weight:bold;">
  	  <td valign="top" colspan="2">Export Sales Contract No : <?=$ldata->contact;?>  &nbsp;&nbsp; Date : <?=$ldata->date?></td>
	  
	  <? }?>
 
	  <td valign="right" align="right"></td>
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
  	  <td valign="top" colspan="2">ISSUING BANK BIN NO : <?=$lc_data->issuing_bank_bin_no;?></td>
  	   
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
	  <?php } ?>
	  	  <tr style="font-weight:bold;">
  	  <td valign="top">H.S. CODE NO :  <?php echo  find_a_field('pi_master p,lc_receive b','p.hs_code','b.pi_id=p.pi_id and b.lc_no="'.$lc_no.'"'); ?></td>
  	  <td valign="middle" align="center"></td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
	  
	
	<?php /*?><tr>
		<td width="25%" valign="top"><strong>Attn: All Concern </strong></td>
			<td width="50%" valign="middle" align="center">&nbsp;</td>
		<td width="25%" valign="right" align="right">&nbsp;</td>
	</tr><?php */?>
	
	
	<tr>
	  <td colspan="3" valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px" ><div align="justify">
	  <br />
	  At <?php if($lc_data->tenor_days=="AT SIGHT"){echo "SIGHT";}else{echo $lc_data->tenor_days;};?> days of this First Bill of Exchange (First of the same tenor and  date  being unpaid) pay to the order of  <?=$seller_bank->bank_name;?>, 
	  <?=$seller_bank->branch_name;?> the sum of  <strong>U.S DOLLAR (
		 <?
		$scs =  $lc_value->lc_value;

			 $credit_amt = explode('.',$scs);

	 if($credit_amt[0]>0){

	 

	 echo convertNumberToWordsForIndia($credit_amt[0]);}

	 if($credit_amt[1]>0){


	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' Cents ';}

	 echo ' Only.';

		?>)
		 </strong>  
		 .</b>   
		 <br />
		 <b>As per PROFORMA INVOICE NO. <?  
$a=0;
		 $pi_sql = 'SELECT  c.pi_no, c.pi_date FROM lc_master a, lc_receive b, pi_details c 
		 WHERE a.lc_no=b.lc_no  and b.pi_id=c.pi_id and a.lc_no="'.$lc_no.'" GROUP by c.pi_id ';
			$pi_query=db_query($pi_sql);
			while($pi_data= mysqli_fetch_object($pi_query)){
			$a++;
			if ($a>1) echo ', ';
echo find_a_field('pi_master','manual_pi_no','pi_no="'.$pi_data->pi_no.'"').' Date. '.date('d-m-Y',strtotime($pi_data->pi_date));}?></b>
	  
	  </div></td>
	  </tr>
  </table>
  
  </td></tr>
  
  
 
  
	  
	  
	  <tr>
	 <td  width="75%"  style="font-size:12px; " align="right">&nbsp;</td>
	  <td  width="25%"  style="font-size:12px; padding-bottom: 10px; " align="right">&nbsp;</td>
	  </tr>
	  
	  
	  
  
  
  
  
  
  
  
	
	
	
	

	<tr>
		<td colspan="2">
	
	
	<!-- style="border:1px solid #000; color: #000;"-->
	      <div class="footer"> 
	
	<table width="100%" cellspacing="0" cellpadding="0"  >
	
		  <tr style="font-size:12px">
		  <td align="left" style="font-size:16px; text-transform: capitalize; font-weight:700;">To </td>
		  <td  align="left">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center" style="font-size:16px; text-transform: uppercase; font-weight:700;"></td>
		  </tr>
		  <tr style="font-size:12px">
		  <td align="left" style="font-size:16px; text-transform:uppercase;"><?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$lc_data->dealer_code);?></td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		  <tr style="font-size:12px">
		  <td align="left" style="font-size:16px; text-transform:uppercase;"><?= find_a_field('dealer_info','address_e','dealer_code='.$lc_data->dealer_code);?></td>
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
		  <td align="left" style="font-size:16px; text-transform: capitalize; font-weight:700;">A/C </td>
		  <td  align="left">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center" style="font-size:16px; text-transform: uppercase; font-weight:700;"> </td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="left" style="font-size:16px; text-transform:uppercase;"><?=$buyer_bank->bank_name;?></td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="left" style="font-size:14px; text-transform:uppercase; font-weight:300"><?=$buyer_bank->branch_name;?></td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr style="font-size:12px" >
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;					  </td>
		  </tr>
		

		  
		<?php /*?>  <tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center" style="font-size:12px;  border-left:0;  padding: 0 0 5px 0; letter-spacing:.3px; ">Digitally signed in ERP system</td>
		  </tr>
		  
		  <tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="left" style="font-size:12px;  border-left:0;  padding: 0px 0 0 47px; letter-spacing:1px; "><?=$master->digital_sign?></td>
		  </tr><?php */?>
		  
		
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
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
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
