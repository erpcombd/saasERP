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

 $vl_sql = 'SELECT  sum(s.total_amt) as lc_value FROM lc_receive a, pi_details b, sale_do_details s WHERE  a.pi_id=b.pi_id and b.do_no=s.do_no and a.lc_no="'.$lc_no.'" GROUP by a.lc_no ';
$lc_value = find_all_field_sql($vl_sql);

 $lc_sql2 = 'SELECT  sum(s.total_unit) as lc_value FROM lc_receive a, pi_details b, sale_do_details s WHERE  a.pi_id=b.pi_id and b.do_no=s.do_no and a.lc_no="'.$lc_no.'" GROUP by a.lc_no ';
$lc_qty = find_all_field_sql($lc_sql2);


 



if(isset($_POST['insert'])){
$user=$_SESSION['user']['id'];
	$unit_get=$_POST['unit_acceptancec_certificate']; 
	$inspection_date=$_POST['inspection_date'];
	$insql='insert into delivery_unit(lc_no,unit_data,inspection_date,entry_by)values("'.$lc_no.'","'.$unit_get.'","'.$inspection_date.'","'.$user.'")';
	db_query($insql);
	header("Location: applicant_certificate.php?v_no=$lc_no");
}
?>
 
 <!DOCTYPE HTML>
 <html>
 	<head>
		<title>Applicant Certificate</title>
		  <meta charset="UTF-8">
	</head>
	
	<body>
	<table width="900" align="center" >
	<tr>
	<td>
		<h2 style="text-align:center;font-weight:bold;"><u>APPLICANT CERTIFICATE</u></h2>
		
		<table style="width:100%;">
		<tr style="font-size:16px">
			<td width="25%" valign="top"> </td>
			<td width="50%" valign="middle" align="center">&nbsp;</td>
			<td width="25%" valign="left" align="left">Date: <?php  //date('d-m-Y',strtotime($lc_data->lc_date));?></td>
			</tr>
			<tr>
			<td style="text-align:left;">Applicant:</td>
			<td style="text-align:left;"><?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$lc_data->dealer_code);?></td>
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
			<td style="text-align:left;width:30%;">PROFORMA INVOICE NO:</td>
			<td style="text-align:left;"><?  
$a=0;
		 $pi_sql = 'SELECT  c.pi_no, c.pi_date FROM lc_master a, lc_receive b, pi_details c 
		 WHERE a.lc_no=b.lc_no  and b.pi_id=c.pi_id and a.lc_no="'.$lc_no.'" GROUP by c.pi_id ';
			$pi_query=db_query($pi_sql);
			while($pi_data= mysqli_fetch_object($pi_query)){
			$a++;
			if ($a>1) echo ', ';
echo find_a_field('pi_master','manual_pi_no','pi_no="'.$pi_data->pi_no.'"').'   Date. '.date('d-m-Y',strtotime($pi_data->pi_date));}?></td>
		 
			</tr>
			<tr>
			<td style="text-align:left;">&nbsp; </td>
			<td style="text-align:left;"> </td>	 
			</tr>
			<tr style="font-weight:bold;">
			<td style="text-align:left;width:30%;">DOCUMENTARY CREDIT NO:</td>
			<td style="text-align:left;"><?=$lc_data->export_lc_no;?>   Date: <?php echo date('d-m-Y',strtotime($lc_data->export_lc_date));?></td>
		 
			</tr>
		</table>
		<BR />
		<table style="width:100%;">
			<tr style="font-weight:bold;">
	  <? 
	  $lquery=db_query('select * from lc_export_contact where lc_no='.$lc_no);
	  while($ldata=mysqli_fetch_object($lquery)){
	  ?> 
		  	<tr style="font-weight:bold;">
  	  <td valign="top" colspan="2">Export Sales Contract No : <?=$ldata->contact;?>  &nbsp;&nbsp; Date : <?=$ldata->date?></td>
	  
	  <? }?>
  	  <td valign="middle" align="left"></td>
	  
	  </tr>
		 
			
			
			<tr style="font-weight:bold;">
			<td style="text-align:left;" colspan="2"><?php if($lc_data->importer_irc_no!='' ){?>APPICANT'S IRC NO : <?=$lc_data->importer_irc_no;?>&nbsp; <?php } ?>         <?php if($lc_data->appplicant_erc_no!='' ){?> & ERC NO : <?=$lc_data->appplicant_erc_no;?> <?php } ?> </td>
			 
			</tr>
			
			<tr style="font-weight:bold;">
			<td style="text-align:left;" colspan="2"><?php if($lc_data->applicants_bin_no!='' ){?>APPICANT'S BIN NO : <?=$lc_data->applicants_bin_no;?>&nbsp;<?php } ?>       <?php if($lc_data->applicants_tin_no!='' ){?> TIN NO : <?=$lc_data->applicants_tin_no;?><?php } ?></td>
			 
			</tr>
			
		 
			  <?php if($lc_data->issuing_bank_bin_no!='' ){?><tr style="font-weight:bold;">
  	  <td valign="top" colspan="2">ISSUING BANK BIN NO : <?=$lc_data->issuing_bank_bin_no;?></td>
  	 
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
	  <?php } ?>
			<tr>
			<td style="text-align:left; ">H.S. CODE NO : <?php echo  find_a_field('pi_master p,lc_receive b','p.hs_code','b.pi_id=p.pi_id and b.lc_no="'.$lc_no.'"'); ?></td>
			<td style="text-align:left;"> </td>
			</tr>
		</table>
		
		<BR />
		<form action="" method="post">
		<table style="width:100%;">
			<tr>
			<td style="text-align:left;">INSPECTION DATE : <?php $check_inspection_date=find_a_field('delivery_unit','inspection_date','lc_no="'.$lc_no.'"');
			if($check_inspection_date==''){
			?><input type="date" name="inspection_date" id="inspection_date" > <?php } else{echo $check_inspection_date;}?> </td>
			<td style="text-align:left;"> </td>
		 
			</tr>
			<tr>
			<td style="text-align:left;"> </td>
			<td style="text-align:left;"> </td>	 
			</tr>
			
			<tr>
			<td style="text-align:left;"> LC AMOUNT : US$   <?=$lc_value->lc_value;?> </td>
			<td style="text-align:left;"> </td>	 
			</tr>
				<tr>
			<td style="text-align:left;"> </td>
			<td style="text-align:left;"> </td>	 
			</tr>
			<tr>
			<td style="text-align:left;">DELIVERY OF GOODS : <?=$lc_qty->lc_qty;?> <?php 
			$check_unit=find_a_field('delivery_unit','unit_data','lc_no="'.$lc_no.'"');
			if($check_unit==''){
			?><input type="text" name="unit_acceptancec_certificate" id="unit_acceptancec_certificate" placeholder="Type Unit" ><input type="submit" name="insert" id="insert" > <?php }  ?> <?php echo $check_unit;?></td>
			<td style="text-align:left;"> .</td>
		 
			</tr>
				<tr>
			<td style="text-align:left;"> </td>
			<td style="text-align:left;"> </td>	 
			</tr>
				<tr>
			<td style="text-align:left;">DESCRIPTION OF GOODS:</td>
			<td style="text-align:left;"> </td>	 
			</tr>
			<tr>
			<td style="text-align:left;"><?php 
			$desc_sql = 'SELECT  s.item_id FROM lc_receive l, pi_details p, sale_do_details s 
		 WHERE l.pi_id=p.pi_id  and p.do_no=s.do_no and l.lc_no="'.$lc_data->lc_no.'" ';
$des_query=db_query($desc_sql);
while($row2=mysqli_fetch_object($des_query)){
echo find_a_field('item_info','item_name','item_id="'.$row2->item_id.'"')." .<br>";
}
?></td>
			<td style="text-align:left;"> </td>	 
			</tr>
			<tr>
			<td style="text-align:left;">FOR 100% EXPORT ORIENTED GARMENTS ACCESSORIES MANUFACTURER.</td>
			<td style="text-align:left;"> </td>	 
			</tr>
		</table>
		</form>
		<BR />
		
		<table style="width:100%;">
			<tr>
			<td style="text-align:left;">COUNTRY OF ORIGIN: WE CERTIFY THAT THE ABOVE MENTIONED GOODS ARE OF BANGLADESHI ORIGIN.</td>
			 
		 
			</tr>
		 
		</table>
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
