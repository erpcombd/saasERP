<?php



//



//====================== EOF ===================



//var_dump($_SESSION);




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');


$sc_no 	= $_REQUEST['v_no'];

$sc_data = find_all_field('sales_contract_master','','sc_no='.$sc_no); 



 $buyer_bank = find_all_field('bank_buyers','','bank_id='.$lc_data->bank_buyers); 
 $seller_bank = find_all_field('bank_sellers','','bank_id='.$sc_data->bank_sellers); 
 $dealer = find_all_field('dealer_info','','dealer_code='.$sc_data->dealer_code); 



		  $barcode_content = $sc_data->sc_no_view;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';



foreach($challan as $key=>$value){
$$key=$value;
}

 $lc_sql = 'SELECT  sum(c.total_amt) as lc_value, sum(c.total_unit) as total_unit  FROM lc_master a, lc_receive b, pi_details c 
		 WHERE a.lc_no=b.lc_no  and b.pi_id=c.pi_id and a.lc_no="'.$lc_data->lc_no.'" GROUP by a.lc_no ';
$lc_value = find_all_field_sql($lc_sql);




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
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">


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
  	  <td valign="top">&nbsp;</td>
  	  <td valign="middle" align="center">&nbsp;</td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
  	<tr style="font-size:16px" height="25">
  	  <td valign="top">Ref.  <?=$sc_data->sc_ref_no;?></td>
  	  <td valign="middle" align="center">&nbsp;</td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
  	<tr style="font-size:16px"> 
		<td width="33%" valign="top">Date: <?=date("d M, Y",strtotime($sc_data->invoice_date))?></td>
			<td width="42%" valign="middle" align="center">&nbsp;</td>
		<td width="25%" valign="right" align="right">&nbsp;</td>
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
  	<tr style="font-size:16px; height:25px;">
  	  <td valign="top">To</td>
  	  <td valign="middle" align="center">&nbsp;</td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
  	<tr style="font-size:18px; height:25px;">
  	  <td valign="top">The Manager</td>
  	  <td valign="middle" align="center">&nbsp;</td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
  	<tr style="font-size:16px; height:25px;">
  	  <td colspan="2" valign="top"><?=$seller_bank->bank_name;?></td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
  	<tr style="font-size:16px; height:25px;">
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
	  <td colspan="3" valign="top" style="font-size:16px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; " ><div align="justify">Sub: 
	  Request for Lien of  S/C or L/C No. 
	      <?=$sc_data->sc_no_view;?>
	   Date. <?=date("d M, Y",strtotime($sc_data->invoice_date))?>, Value US$  
	   
	     
		  <? $pi_data_sql="SELECT sum(c.total_unit) as pi_qty, sum(c.total_amt) as pi_value
		  FROM sales_contract_master a, sales_contract b, pi_details c  
		   WHERE a.sc_no=b.sc_no and b.pi_id=c.pi_id and a.sc_no='".$sc_no."' GROUP by b.sc_no ";
		 $pi_qt_vl = find_all_field_sql($pi_data_sql); ?>
	   
	   
	   <?= number_format($pi_qt_vl->pi_value,2); ?>
	   </div></td>
	  </tr>
	  <tr>
	    <td colspan="3" valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; " >&nbsp;</td>
	    </tr>
	  <tr>
	    <td colspan="3" valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; " >Dear Sir, </td>
	    </tr>
	  <tr>
	    <td colspan="3" valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; " >&nbsp;</td>
	    </tr>
	  <tr>
	    <td colspan="3" valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; " >
		We have the pleasure to inform you that we have received the captioned S/C or L/C No. 
		  <?=$sc_data->sc_no_view;?>  
		Date. 
		<?=date("d M, Y",strtotime($sc_data->invoice_date))?>, Value US$ 
		<?= number_format($pi_qt_vl->pi_value,2); ?> 
		 <strong>A/C Name: 
		 <?=$dealer->dealer_name_e?>
		 </strong>		 <strong>.</strong> </td>
	    </tr>
	  <tr>
	    <td colspan="3" valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; " >&nbsp;</td>
	    </tr>
	  <tr>
	    <td colspan="3" valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; " >
		We would like to request you to kindly LIEN with you. </td>
	    </tr>
	  <tr>
	    <td colspan="3" valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; " >&nbsp;</td>
	    </tr>
		
		<tr>
	    <td colspan="3" valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; " >	Thanking you and awaiting to avail your best co-operation.</td>
	    </tr>
		<tr>
		  <td colspan="3" valign="top" style="font-size:14px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px; " >&nbsp;</td>
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
		<tr style="font-size:14px">
		  <td align="left" style="font-size:14px; text-transform: capitalize; font-weight:700;">&nbsp;</td>
		  <td  align="left">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center" style="font-size:16px; text-transform: uppercase; font-weight:700;">&nbsp;</td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="left" style="font-size:16px; text-transform:uppercase;">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
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
		  <td align="left" style="font-size:14px; text-transform:uppercase; font-weight:300">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="left" style="font-size:14px; text-transform:uppercase; font-weight:300">&nbsp;</td>
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
