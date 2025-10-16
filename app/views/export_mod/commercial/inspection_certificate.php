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

 $buyer_all=find_all_field('dealer_info','','dealer_code='.$lc_data->dealer_code); 

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


 $vl_sql = 'SELECT  sum(s.total_amt) as lc_value FROM lc_receive a, pi_details b, sale_do_details_foreign s WHERE  a.pi_id=b.pi_id and b.do_no=s.do_no and a.lc_no="'.$lc_no.'" GROUP by a.lc_no ';
$lc_value = find_all_field_sql($vl_sql);

 $lc_sql2 = 'SELECT  sum(s.total_unit) as lc_value FROM lc_receive a, pi_details b, sale_do_details_foreign s WHERE  a.pi_id=b.pi_id and b.do_no=s.do_no and a.lc_no="'.$lc_no.'" GROUP by a.lc_no ';
$lc_qty = find_all_field_sql($lc_sql2);

?>
 
 <!DOCTYPE HTML>
 <html>
 	<head>
		<title>INSPECTION Certificate</title>
		  <meta charset="UTF-8">
	</head>
	
	<body>
	<table width="900" align="center" >
	<tr>
	<td>
		<h2 style="text-align:center;font-weight:bold;"><u>INSPECTION CERTIFICATE</u></h2>
		
		<table style="width:100%;">
		  	<tr style="font-size:16px">
			<td width="25%" valign="top"> </td>
			<td width="50%" valign="middle" align="center">&nbsp;</td>
			<td width="25%" valign="left" align="left">Date: <?php  //date('d-m-Y',strtotime($lc_data->lc_date));?></td>
			</tr>
			<tr>
			<td style="text-align:left;font-weight:bold;width:30%;">APPLICANT:</td>
			<td style="text-align:left;font-weight:bold;"><?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$lc_data->dealer_code);?></td>
			<td style="text-align:right;"><?php  //date('d-m-Y',strtotime($lc_data->lc_date));?></td>
			</tr>
			<tr>
			<td style="text-align:left;"> </td>
			<td style="text-align:left;"><?= find_a_field('dealer_info','address_e','dealer_code='.$lc_data->dealer_code);?></td>
			<td style="text-align:right;"> </td>
			</tr>
		</table>
		<br /><br />
		<table style="width:100%;">
			<tr style="font-weight:bold;">
			<td style="text-align:left;width:30%;">BENEFICIARY:</td>
			<td style="text-align:left;"> NATRAKONA ACCESSORIES LIMITED</td>	 
			</tr>
			<tr style="font-weight:bold;">
			<td style="text-align:left;width:30%;"> </td>
			<td style="text-align:left;">KEWA PURBA KHANDA,KEWA BAZAR SREEPUR, GAZIPUR,BANGLADESH</td>	 
			</tr>
			<tr>
			<td style="text-align:left;">&nbsp; </td>
			<td style="text-align:left;"> </td>	 
			</tr>
	
				 
		</table>
		<BR />
		<table style="width:100%;">
				<tr style="font-weight:bold;">
			<td style="text-align:left;width:30%;">L/C NO:</td>
			<td style="text-align:left;"><?=$lc_data->export_lc_no;?>  </td>	 
			</tr>
				<tr style="font-weight:bold;">
			<td style="text-align:left;width:30%;">DATE:</td>
			<td style="text-align:left;"><?php echo date('d-m-Y',strtotime($lc_data->export_lc_date));?>  </td>	 
			</tr>
	<?php /*?>		<tr style="font-weight:bold;">
			<td style="text-align:left;width:30%;">Amendment NO:</td>
			<td style="text-align:left;"><?=$lc_data->amd_no;?>  </td>	 
			</tr>
			<tr style="font-weight:bold;">
			<td style="text-align:left;width:30%;">DATE:</td>
			<td style="text-align:left;"><?=($lc_data->amd_date!='')? date('d-m-Y',strtotime($lc_data->amd_date)): '';?>  </td>	 
			</tr><?php */?>
			  <? 
	  $lquery=db_query('select * from lc_export_contact where lc_no='.$lc_no);
	  while($ldata=mysqli_fetch_object($lquery)){
	  ?> 	
			<tr style="font-weight:bold;">
			<td style="text-align:left;width:30%;">Export Sales Contract No :</td>
			<td style="text-align:left;"><?=$ldata->contact;?> </td>	 
			</tr>
			<tr style="font-weight:bold;">
			<td style="text-align:left;width:30%;">DATE:</td>
			<td style="text-align:left;"><?=$ldata->date?>  </td>	 
			</tr>
			<? }?>
<?php /*?>			<tr style="font-weight:bold;">
			<td style="text-align:left;width:30%;">EXPORT LC NO:</td>
			<td style="text-align:left;"><?=$lc_data->exp_no;?>   &nbsp;&nbsp; </td>
		 
			</tr>
		 
			<tr style="font-weight:bold;">
			<td style="text-align:left;width:30%;">DATE:</td>
			<td style="text-align:left;">Date : <?php 
	  if($lc_data->exp_date>0){
	  echo date('d-m-Y',strtotime($lc_data->exp_date)); } else{
	  echo '00-00-0000';
	  }?></td>
			</tr><?php */?>
			<tr style="font-weight:bold;">
  	  <td valign="top">H.S. CODE NO : <?php echo  find_a_field('pi_master p,lc_receive b','p.hs_code','b.pi_id=p.pi_id and b.lc_no="'.$lc_no.'"'); ?></td>
  	  <td valign="middle" align="center"></td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
			 
			
			 
			
		  
			 
		</table>
		
		<BR />
		
		<table style="width:100%;">
		<tr>
			<td style="text-align:left;"> AMOUNT : US$   <?=$lc_value->lc_value;?> </td>
			<td style="text-align:left;"> </td>	 
			</tr>
				<tr>
			<td style="text-align:left;"> </td>
			<td style="text-align:left;"> </td>	 
			</tr>
			<tr>
			<td style="text-align:left;"> </td>
			<td style="text-align:left;"> </td>	 
			</tr>
			<tr>
			<td style="text-align:left;"> </td>
			<td style="text-align:left;"> </td>	 
			</tr>
			<tr>
			<td style="text-align:left;">INSPECTION DATE :</td>
			<td style="text-align:left;"><?php echo $check_inspection_date=find_a_field('delivery_unit','inspection_date','lc_no="'.$lc_no.'"');?> </td>
		 
			</tr>
		
			
			<tr>
			<td style="text-align:left;"> </td>
			<td style="text-align:left;"> </td>	 
			</tr>
			<tr>
			<td style="text-align:left;"> </td>
			<td style="text-align:left;"> </td>	 
			</tr>
				<tr>
			<td style="text-align:left;"> </td>
			<td style="text-align:left;"> </td>	 
			</tr>
			<tr>
			<td style="text-align:left;">QUANTITY :   </td>
			<td style="text-align:left;"> AS PER PROFORMA INVOICE</td> 
			</tr>
				<tr>
			<td style="text-align:left;"> </td>
			<td style="text-align:left;"> </td>	 
			</tr>
			<tr>
			<td style="text-align:left;"> </td>
			<td style="text-align:left;"> </td>	 
			</tr>
			<tr>
			<td style="text-align:left;"> </td>
			<td style="text-align:left;"> </td>	 
			</tr>
				<tr>
			<td style="text-align:left;">DESCRIPTION OF GOODS:</td>
			<td style="text-align:left;"> ACCESSORIES FOR READYMADE GARMENTS INDUSTRY.</td>	 
			</tr>
			<tr>
			<td style="text-align:left;"> </td>
			<td style="text-align:left;"> </td>	 
			</tr>
			<tr>
			<td style="text-align:left;"> </td>
			<td style="text-align:left;"> </td>	 
			</tr>
			<tr>
			<td style="text-align:left;"> </td>
			<td style="text-align:left;"> </td>	 
			</tr>
			<tr>
			<td style="text-align:left;"> </td>
			<td style="text-align:left;"> </td>	 
			</tr>
			<tr>
			<td style="text-align:left;"> </td>
			<td style="text-align:left;"> </td>	 
			</tr>
			<tr>
			<td style="text-align:left;" colspan="2">THIS IS CERTIFY THAT THE ABOCE MENTIONED GOODS HAV SUPPLIED IN GOOD CONDITION AS PER PROFORMA INVOICE NO: <?  
$a=0;
		 $pi_sql = 'SELECT  c.pi_no , c.pi_date FROM lc_master a, lc_receive b, pi_details c 
		 WHERE a.lc_no=b.lc_no  and b.pi_id=c.pi_id and a.lc_no="'.$lc_no.'" GROUP by c.pi_id ';
			$pi_query=db_query($pi_sql);
			while($pi_data= mysqli_fetch_object($pi_query)){
			$a++;
			if ($a>1) echo ', ';
echo $pi_data->pi_no.' DATE. '.date('d-m-Y',strtotime($pi_data->pi_date));}?>.<br> GOODS ARE OF BANGLADESHI ORIGIN WE CERTIFY.</td>
			 
			</tr>
			
		</table>
		<BR />
		
 
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
		  <td align="center" style="font-size:16px; text-transform: uppercase; font-weight:700;"><?=find_a_field('user_group','group_name','1' )?>.</td>
		  <td  align="left">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center" style="font-size:16px; text-transform: uppercase; font-weight:700;"></td>
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
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr style="font-size:12px" >
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		  	<tr style="font-size:12px" >
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr style="font-size:12px" >
		    <td align="center"><hr /></td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		

		  
	 
		  
		
		  <tr style="font-size:12px">
		 <td align="center" style="text-transform: uppercase; font-size: 16px; font-weight:700;">Authorized Signature</td>
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
		  <td align="center"> </td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="left"> 
This is an ERP generated report </td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center" style="text-transform: uppercase; font-size: 16px; font-weight:700;"></td>
		  </tr>
	
	 
	
        
	
        
	</table>
		</div>
		</td>
		</tr>
		</table>
	</body>
 </html>
