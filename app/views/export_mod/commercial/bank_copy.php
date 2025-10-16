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

 $vl_sql = 'SELECT  sum(s.total_amt) as lc_value FROM lc_receive a, pi_details b, sale_do_details s WHERE  a.pi_id=b.pi_id and b.do_no=s.do_no and a.lc_no="'.$lc_no.'" GROUP by a.lc_no ';
$lc_value = find_all_field_sql($vl_sql);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$lc_data->lc_no_view;?></title>
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
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center" style="padding-top: 15% !important;">


  <?php /*?><tr>
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
 </tr><?php */?>
  

 
 
 
 
 
 

 <tbody>
  
 
  
  
 <tr> <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="68%" valign="top">&nbsp;	        </td>
		  </tr>


		</table>		</td></tr>
		
		<tr>
    <td colspan="2"><div id="pr">
        <div align="left">
         
            <input name="button" type="button" onclick="hide();window.print();" value="Print" />
             </div>
      </div>	  </td>
	  </tr>
		
		
		<tr> <td colspan="2">
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
 
  	<tr style="font-size:16px">
		<td width="33%" valign="top">Date: <?php  //date('d-m-Y',strtotime($lc_data->lc_date));?></td>
			<td width="42%" valign="middle" align="center">&nbsp;</td>
		<td width="25%" valign="right" align="right">&nbsp;</td>
	</tr>
  	<tr style="font-size:16px">
  	  <td valign="top">&nbsp;</td>
  	  <td valign="middle" align="center">&nbsp;</td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
 
  	<tr style="font-size:16px">
  	  <td valign="top">To</td>
  	  <td valign="middle" align="center">&nbsp;</td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
  	<tr style="font-size:16px">
  	  <td valign="top"><strong>The Manager</strong></td>
  	  <td valign="middle" align="center">&nbsp;</td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
  	<tr style="font-size:16px">
  	  <td colspan="2" valign="top"><?=$seller_bank->bank_name;?></td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
  	<tr style="font-size:16px">
  	  <td colspan="2" valign="top"><?=$seller_bank->branch_name;?>.</td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
  	<tr style="font-size:16px">
  	  <td valign="top">&nbsp;</td>
  	  <td valign="middle" align="center">&nbsp;</td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
  	<tr style="font-size:16px">
  	  <td valign="top">&nbsp;</td>
  	  <td valign="middle" align="center">&nbsp;</td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
	

	  
	  
	  <tr>
	  <td colspan="3" valign="top" style="font-size:16px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; " ><div align="justify">Sub: <b>Submission of <?php if($lc_data->tenor_days=="AT SIGHT"){echo $lc_data->tenor_days;}else{echo $lc_data->tenor_days." Days";};?> Documents for Negotiation/Collection Against LDBC No:  </b> BTB L/C No. <?=$lc_data->export_lc_no;?> Date <?php echo date('d-m-Y',strtotime($lc_data->export_lc_date));?> for USD <?=$lc_value->lc_value;?>.</div></td>
	  </tr>
	  <tr>
	    <td colspan="3" valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; " >&nbsp;</td>
	    </tr>
		
		
	  <tr>
	    <td colspan="3" valign="top" style="font-size:14px;   " >MS </td>
	    </tr>
	  	  <tr>
	    <td colspan="3" valign="top" style="font-size:14px;   " ><?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$lc_data->dealer_code);?></td>
	    </tr>
			  <tr>
	    <td  valign="top" style="font-size:14px;   " ><?= find_a_field('dealer_info','address_e','dealer_code='.$lc_data->dealer_code);?></td>
		<td></td>
		<td></td>
	    </tr>
		<tr>
	    <td colspan="3" valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; " >&nbsp;</td>
	    </tr>
			  <tr>
	    <td colspan="3" valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; " >TO </td>
	    </tr>
	  	  <tr>
	    <td colspan="3" valign="top" style="font-size:14px;   " ><?=$buyer_bank->bank_name;?></td>
	    </tr>
			  <tr>
	    <td   valign="top" style="font-size:14px;   " ><?=$buyer_bank->branch_name;?></td>
		<td></td>
		<td></td>
	    </tr>
		
		
		<tr>
	    <td colspan="3" valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; " >&nbsp;</td>
	    </tr>
	  <tr>
	    <td colspan="3" valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; " >Dear Sir, </td>
	    </tr>

	  <tr>
	    <td colspan="3" valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; " >
		With reference to above we are submitting herewith the documents for collection basis L/C issuing since we have supplied the goods to L/C applicant.Details of which are mentioned:		</td>
	    </tr>
	  <tr>
	    <td colspan="3" valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; " >&nbsp;</td>
	    </tr>
	  
	  
	  
	  <tr>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >&nbsp;&nbsp;1.&nbsp;&nbsp;&nbsp;Bill of Exchange</td>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >:&nbsp;&nbsp;&nbsp;02 sets</td>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >&nbsp;</td>
	    </tr>
	  <tr>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >&nbsp;&nbsp;2.&nbsp;&nbsp;&nbsp;Commercial Invoice</td>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >:&nbsp;&nbsp;&nbsp;06 copies</td>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >&nbsp;</td>
	  </tr>
	  <tr>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >&nbsp;&nbsp;3.&nbsp;&nbsp;&nbsp;Packing list</td>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >:&nbsp;&nbsp;&nbsp;05 copies</td>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >&nbsp;</td>
	    </tr>
	  <tr>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >&nbsp;&nbsp;4.&nbsp;&nbsp;&nbsp;Delivery Challan</td>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >:&nbsp;&nbsp;&nbsp;02 copies</td>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >&nbsp;</td>
	    </tr>
	  <tr>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >&nbsp;&nbsp;5.&nbsp;&nbsp;&nbsp;Truck Receipt</td>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >:&nbsp;&nbsp;&nbsp;02 copies</td>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >&nbsp;</td>
	    </tr>
		
		  <tr>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >&nbsp;&nbsp;6.&nbsp;&nbsp;&nbsp;Beneficiary Certificate</td>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >:&nbsp;&nbsp;&nbsp;02 copies</td>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >&nbsp;</td>
	    </tr>
		<tr>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >&nbsp;&nbsp;7.&nbsp;&nbsp;&nbsp; Certificate of Origin</td>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >:&nbsp;&nbsp;&nbsp;02 copies</td>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >&nbsp;</td>
	    </tr>
		<tr>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >&nbsp;&nbsp;8.&nbsp;&nbsp;&nbsp; Inspection Certificate</td>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >:&nbsp;&nbsp;&nbsp;02 copies</td>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >&nbsp;</td>
	    </tr>
		<tr>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >&nbsp;&nbsp;9.&nbsp;&nbsp;&nbsp; Applicant Certificate</td>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >:&nbsp;&nbsp;&nbsp;02 copies</td>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >&nbsp;</td>
	    </tr>
		
	  <tr>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >&nbsp;</td>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >&nbsp;</td>
	    <td valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; text-transform:uppercase;" >&nbsp;</td>
	    </tr>
	  <tr>
	    <td colspan="3" valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; " >
		
			So we request you to send the documents for negotiation at early and your cooperation in this regard shall be highly appreciated. <br />  	</td>
	    </tr>
	   
	  <tr>
	    <td colspan="3" valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; " >&nbsp;</td>
	    </tr>
		
		<tr>
	    <td colspan="3" valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; " >	Thanking you for your best co-operation.</td>
	    </tr>

	  <tr>
	    <td colspan="3" valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; " >Yours faithfully,</td>
	    </tr>
	  
	  
	  <tr>
	 
	 <td colspan="2" align="left"  style="font-size:16px; text-transform: uppercase; letter-spacing: .3px; line-height:20px;"> </td>
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
		  <td width="37%" align="center">&nbsp;</td>
		  <td width="13%"  align="center">&nbsp;</td>
		  <td width="20%"  align="center">&nbsp;</td>
		  <td width="30%" align="center">&nbsp;</td>
		  </tr>
		 
		<tr style="font-size:12px">
		  <td align="left" style="font-size:14px; text-transform:uppercase; font-weight:300">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr style="font-size:12px">
		  <td  align="center"  style="font-size:14px; text-transform:uppercase; font-weight:300"><span style="font-size:16px; text-transform: uppercase; font-weight:700;">
		    <?=find_a_field('user_group','group_name','id='.$_SESSION['user']['group'])?>.
		  </span></td>
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
		  <td align="center">&nbsp;</td>
		  </tr>
		  
		<tr style="font-size:12px">
		  <td  align="center" ><span style="text-transform: uppercase; font-size: 16px; font-weight:700;">Authorized Signature</span></td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center" style="text-transform: uppercase; font-size: 16px; font-weight:700;">&nbsp;</td>
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
