<?php



//



//====================== EOF ===================



//var_dump($_SESSION);




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once SERVER_CORE."core/class.numbertoword.php";

$lc_no 		= $_REQUEST['v_no'];


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

	 $do_no= find_all_field('pi_details p,sale_do_details d','','p.do_no=d.do_no and p.pi_id="'.$lc_no.'"');
	 
	 
	if(isset($_POST['confirm'])){

	db_query('update sale_do_details set truck_receipt="'.$_POST['truck_amt'].'",truck_no="'.$_POST['truck_no'].'" where do_no="'.$do_no->do_no.'"');
	echo "<script>window.top.location='truck_receipt.php?v_no=".$lc_no."'</script>";
	}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset="UTF-8"" />

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
                        <td width="20%">    </td>
                        
                        <td width="60%">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td colspan="2" align="center">
									<h4 style="font-size:24px; padding:5px 0; margin:0; font-family:  'MYRIADPRO-REGULAR'; letter-spacing:1px;text-decoration:underline; ">
   TRUCK RECEIPT</h4>
   
						  
						   
						     <h4 style="font-size:24px; padding:5px 0; margin:0; font-weight:500; font-family:  'MYRIADPRO-REGULAR'; letter-spacing:1px;text-decoration:underline; ">
   MASTER TRANSPORT  </h4>
   
   <h4 style="font-size:14px; padding:0 0; margin:0; margin:0; font-weight:300; font-style:italic;  letter-spacing:1px; ">Carrying Contractor & Commission Agent all Over the Bangladesh</h4>
   <h4 style="font-size:14px; padding:0 0; margin:0; margin:0; font-weight:300;  font-style:italic;  letter-spacing:1px;">82, TAJGAON MINI TRUCK STAND,TAJGAON,DHAKA-1208.</h4>
   
   
   
   
   
   
   
   
   </td>
								</tr>
								
								<tr>
									<td colspan="2" align="center">
									</td>
								</tr>
							</table>
						
						</td>
						
						<td width="20%"></td>
                      </tr>
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
		
		
		<tr> <td colspan="2">
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr style="font-size:16px" >
		<td width="25%" valign="top">Receipt No: <?=$lc_data->lc_no_view;?></td>
			<td width="50%" valign="middle" align="center">&nbsp;</td>
		<td width="25%" valign="right" align="center">Date: <?php //date('d-m-Y',strtotime($lc_data->lc_date));?></td>
	</tr>
  	<tr>
  	  <td valign="top">&nbsp;</td>
  	  <td valign="middle" align="center">&nbsp;</td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
	

	
	
	<tr>
	  <td colspan="3" valign="top" >
	  	<table width="100%" border="0" cellspacing="0" cellpadding="0" >
			<tr>
				<td width="50%">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:16px; text-transform:uppercase;">
						<tr>
							<td width="35%">প্রেরকের নাম</td>
							<td width="2%">:</td>
							<td  width="63%"> <?=find_a_field('user_group','group_name','1')?> </td>
						</tr>
						<tr>
						<td valign="top">ঠিকানা</td>
							<td  valign="top">:</td>
							<td  width="63%"  valign="top"> <?=find_a_field('user_group','address','1' )?> </td>
						</tr>
						<tr>
						<td> </td>
							<td> </td>
							<td  width="63%"> </td>
						</tr>
						</table>
						
				
				</td>
				<td width="50%">
				
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:16px;  text-transform:uppercase;">
						<tr>
							<td width="28%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;প্রাপকের নাম</td>
							<td width="2%">:</td>
							<td  width="70%"><?=$dealer->dealer_name_e?> </td>
						</tr>
						<tr>
						<td width="28%"  valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ঠিকানা</td>
							<td width="2%"  valign="top">:</td>
							<td  width="70%"  valign="top"><?=$dealer->address_e?> </td>
						</tr>
						
						</table>
				
				</td>
			</tr>
		</table>
	  </td>
	</tr>
	

	
	
	
  </table>
  
  </td></tr>
  <tr colspan="2" valign="top">
  	<td colspan="2">
	<table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:14px">
  	 
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
  	  <td valign="top">ISSUING BANK BIN NO : <?=$lc_data->issuing_bank_bin_no;?></td>
  	  <td valign="middle" align="center"></td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
	  <?php } ?>
	 
  	 
  </table>
  
	</td>
  </tr>
  
  
 
  <tr>
    <td colspan="2"><div id="pr">
        <div align="left">
         
            <input name="button" type="button" onclick="hide();window.print();" value="Print" />
             </div>
      </div>	  </td>
	  </tr>
	  <? if($do_no->truck_no!=''){?>
	  <tr>
    <td colspan="2">
        <div style="font-size: 15px; font-weight: bolder;" align="left"> Truck No: <?=$do_no->truck_no?></div>	  </td>
	  </tr>
	  <? }?>
	  
	  
	  <tr>
	 <td  width="75%"  style="font-size:12px; " align="left"><h5 style="margin:0; padding:0; font-weight:700; font-size:16px; "><em>Freight Terms:  Freight prepaid.</em></h5></td>
	  <td  width="25%"  style="font-size:12px; padding-bottom: 10px; " align="right"><div style=" padding:8px 40px; border:2px solid   #CCCCCC; text-align:center; font-size:12px; font-weight:200;" >
	   H.S. Code <?php echo  find_a_field('pi_master p,lc_receive b','p.hs_code','b.pi_id=p.pi_id and b.lc_no="'.$lc_no.'"'); ?>
	  </div></td>
	  </tr>
	  
	  
	  
	  <tr>
    <td colspan="2">
      
      <table width="100%" class="tabledesign"   border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="5"  style="font-size:12px">
       
	   <tr >
          <th   align="center" bgcolor="#CCCCCC">SL No</th>
           <th   align="center" bgcolor="#CCCCCC">Description of Goods</th>
		   <th   align="center" bgcolor="#CCCCCC">Measurement</th>
		   <th   align="center" bgcolor="#CCCCCC">Number of Packets</th>
          <th  align="center" bgcolor="#CCCCCC">Taka</th>
       
        </tr>
        
        
        <?  
		
	 $sqlc = 'select s.*, i.item_name, i.unit_name from lc_receive r, pi_details c, sale_do_details s, item_info i where r.pi_id=c.pi_id and i.item_id=s.item_id and c.do_no=s.do_no and r.lc_no='.$lc_no.' group by s.id order by s.id ';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			?>
        <tr style="font-size:12px;">
          <td align="center" valign="top"><?=++$kk;?></td>
          <td align="left" valign="top"><?=$datac->item_name;?></td>
		  <td><?=$datac->measurement;?></td>
		 
			    <td align="left" valign="top"><?=$datac->pack; $dfg+=$datac->pack;?></td>
				 
          <td align="center" valign="top"></td>
         
        </tr>
        
        <? }

		
		?>
	<form method="post">	 
        <tr style="font-size:12px;">
        <td colspan="3" align="right" valign="middle"><strong> Total:</strong></td>
       
        <td align="center" valign="middle"><strong>
          <?=number_format($dfg,0) ;?>
        </strong></td>
		
		<td width="20%" align="center" valign="middle">
		
	<? if($do_no->truck_receipt==''){?><input name="truck_amt" /><? }else{ echo $do_no->truck_receipt;}?>
		
		
		</</td
         
        ></tr>
<? if($do_no->truck_receipt==''){?>	

  <tr>
  <td colspan="5" align="center";>
  <span style="text-align:center">Truck Number:<input  name="truck_no" /></span>
  </td>
  
  </tr>	 
  <tr>
  <td colspan="5" align="center";>
  <span style="text-align:center"><input type="submit" name="confirm" /></span>
  </td>
  
  </tr>
  
  <? }?>
  </form>

      </table>      </td>
  </tr>
	  
	  
	  <tr>
	 
	 <td colspan="2" align="left"  style="font-size:16px; text-transform: uppercase; letter-spacing: .3px; line-height:20px;"> <div align="justify">
	 <b>PROFORMA INVOICE NO. <?  
$a=0;
		 $pi_sql = 'SELECT  c.pi_no, c.pi_date FROM lc_master a, lc_receive b, pi_details c 
		 WHERE a.lc_no=b.lc_no  and b.pi_id=c.pi_id and a.lc_no="'.$lc_no.'" GROUP by c.pi_id ';
			$pi_query=db_query($pi_sql);
			while($pi_data= mysqli_fetch_object($pi_query)){
			$a++;
			if ($a>1) echo ', ';
echo find_a_field('pi_master','manual_pi_no','pi_no="'.$pi_data->pi_no.'"').' Date. '.date('d-m-Y',strtotime($pi_data->pi_date));}?>.</b>  
	 
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
		  <td height="16" align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr style="font-size:12px">
		  <td width="29%" align="center">&nbsp;</td>
		  <td width="21%"  align="center">&nbsp;</td>
		  <td width="20%"  align="center">&nbsp;</td>
		  <td width="30%" align="center">&nbsp;</td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="center" style="font-size:16px; text-transform: capitalize; font-weight:700;">&nbsp;</td>
		  <td  align="left">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center" style="font-size:16px; text-transform: uppercase; font-weight:700;">&nbsp;</td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="left" style="font-size:14px; text-transform:uppercase; font-weight:300">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr style="font-size:12px" >
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;				  </td>
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
		  <td align="center"><hr /></td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		 
		  </tr>
		<tr style="font-size:12px">
		  <td align="center"><span style="text-transform: uppercase; font-size: 16px; font-weight:700;">Received BY</span></td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center" style="text-transform: uppercase; font-size: 16px; font-weight:700;"> </td>
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
