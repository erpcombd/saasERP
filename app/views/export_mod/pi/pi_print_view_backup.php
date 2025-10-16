<?php



//



//====================== EOF ===================



//var_dump($_SESSION);




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

$pi_no 		= $_REQUEST['v_no'];


$master= find_all_field('pi_master','','id='.$pi_no);



		  $barcode_content = $master->pi_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';



foreach($challan as $key=>$value){
$$key=$value;
}

$ssql = 'select a.*,b.do_date, b.group_for, b.via_customer from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;



$dealer = find_all_field_sql($ssql);
$entry_time=$dealer->do_date;


$dept = 'select warehouse_name from warehouse where warehouse_id='.$dept;



$deptt = find_all_field_sql($dept);

$to_ctn = find_a_field('sale_do_chalan','sum(pkt_unit)','chalan_no='.$chalan_no);

$to_pcs = find_a_field('sale_do_chalan','sum(dist_unit)','chalan_no='.$chalan_no); 



$ordered_total_ctn = find_a_field('sale_do_details','sum(pkt_unit)','dist_unit = 0 and do_no='.$do_no);

$ordered_total_pcs = find_a_field('sale_do_details','sum(dist_unit)','do_no='.$do_no); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$master->pi_no;?></title>
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




</style>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size: 10px;">
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">

  <tbody>

  <tr>
    <td><div class="header">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <?php /*?><tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="20%">
                       
                        <td width="60%"><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                            <tr>
                              <td style="text-align:center; color:#000; font-size:14px; font-weight:bold;">
						
								<p style="font-size:20px; color:#000000; margin:0; padding:0; text-transform:uppercase;"><?=find_a_field('user_group','group_name',
								'id='.$_SESSION['user']['group'])?></p>
								<p style="font-size:14px; font-weight:300; color:#000000; margin:0; padding:0;"><?=find_a_field('user_group','address',
								'id='.$_SESSION['user']['group'])?></p>                              </td>
                            </tr>
                            <tr>


        <!--<td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">WORK ORDER </td>-->
      </tr>
                          </table>
                        <td width="20%">
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr><?php */?>
          <tr>
            
          </tr>
		  
		  <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="71%">
                       		<table  width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:15px">
								
									<tr>
									  <td style="padding-bottom:3px;"><span style="font-size:18px; color:#000000; margin:0; padding:0; text-transform:uppercase; font-weight:700">
									    <?=find_a_field('user_group','group_name',
								'id='.$_SESSION['user']['group'])?>
									  </span></td>
							  </tr>
									<tr>
									  <td style="padding-bottom:3px; font-size:12px;">(A member of Nassa Group)</td>
									</tr>
									<tr><td style="padding-bottom:3px; font-size:12px;">107, 128 Nischintapur,</td>
									</tr>
									<tr><td style="padding-bottom:3px; font-size:12px;">Zerabo, Ashulia, Dhaka.</td>
									</tr>
									<tr><td style="padding-bottom:3px; font-size:12px;">Mobile: 0140-1140030, 0191-5693272.</td>
									</tr>
									<tr><td style="padding-bottom:3px; font-size:12px;">Email: npl@nassagroup.org</td>
									</tr>
						  </table>					    </td>
                        
                        <td width="29%"> 
							<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px">
								
									<tr>
					  
					  <td align="center"><h4 style="font-size:18px;">PROFORMA INVOICE</h4></td>
					  
					  </tr>
									<tr>
					  
					  <td align="center"><?='<img class="barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?></td>
					  
					  </tr>
					  
					  <tr>
					  
					  <td align="center"><span style="font-size:14px; padding: 3px 0 0 10px; letter-spacing:5px;"><?=$master->pi_no;?></span></td>
					  
					  </tr>
						  </table>						  </td>                    </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
        </table>
      </div></td>
  </tr>
  

 
 
 
 
 
 

 
  <tr> <td><hr /></td></tr>
 
  
  
  <tr> <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  	<tr height="30">
  	  <td valign="top"></td>
  	  <td  style="text-align:center; color:#FFF; font-size:18px; padding:0px 0px 10px 0px; color:#000000; font-weight:bold;">
	  <span style="text-decoration:underline">PROFORMA INVOICE</span> </td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
  	<tr>
		<td width="25%" valign="top"></td>
			<td width="50%" valign="middle" align="center"><strong>FSC CERTIFICATE CODE: SCS-COC-007014 </strong></td>
		<td width="25%" valign="right" align="right"><?php /*?><strong>PI Date: <?=date("d M, Y",strtotime($master->pi_date))?></strong><?php */?></td>
	</tr>
  </table>
  
  </td></tr>
  
  
  <tr> <td>&nbsp;</td></tr>
  
  
  
 <tr> <td><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="54%" valign="top">


		      <table width="97%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px; letter-spacing:.3px;">


		        <tr>
		          <td width="34%" align="left" valign="middle"><strong>Proforma Invoice No: </strong></td>
		          <td width="66%"><strong><?php echo $master->pi_no;?></strong></td>
	            </tr>
		        <tr>
		          <td align="left" valign="middle"><strong>Proforma Invoice Date: </strong></td>
		          <td><strong>
		            <?=date("d M, Y",strtotime($master->pi_date))?>
		          </strong></td>
	            </tr>
				
				
		        </table>		      </td>


			<td width="46%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2"  style="font-size:13px; letter-spacing:.3px;">
			
			
			
			<tr>


                <td width="32%" align="right" valign="middle"><strong> Customer  </strong></td>


			    <td width="68%">: <?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$master->dealer_code);?></td> 
			</tr>




			  <tr>


                <td width="32%" align="right" valign="middle"><strong>Address</strong></td>


			    <td width="68%">: <?= find_a_field('dealer_info','address_e','dealer_code='.$master->dealer_code);?></td> 
			  </tr>


			  


			  


		    </table></td>
		  </tr>


		</table>		</td></tr>
		
		
		<tr> <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  	<tr>
		<td width="25%" valign="top"></td>
			<td width="50%" valign="middle" align="center">&nbsp;</td>
		<td width="25%" valign="right" align="right">&nbsp;</td>
	</tr>
	
	<?php /*?><tr>
		<td width="25%" valign="top"><strong>Attn: All Concern </strong></td>
			<td width="50%" valign="middle" align="center">&nbsp;</td>
		<td width="25%" valign="right" align="right">&nbsp;</td>
	</tr><?php */?>
	<tr>
	  <td colspan="3" valign="top" style="font-size:13px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px" >This Proforma Invoice (PI) has been issued in relation to the Purchase Order (PO) number 
	 <b>  <?  
$o=0;
		$po_sql = 'SELECT `customer_po_no` FROM `pi_details` WHERE `pi_id`="'.$pi_no.'" GROUP by customer_po_no ';
			$po_query=db_query($po_sql);
			while($po_data= mysqli_fetch_object($po_query)){
			$o++;
			if ($o>1) echo ', ';
echo $po_data->customer_po_no;}?></b> presented by the buyer/customer.</td>
	  </tr>
	<tr>
	  <td colspan="3" valign="top" style="font-size:12px; padding: 5px 0px 0px 0px; " >&nbsp;</td>
	  </tr>
  </table>
  
  </td></tr>
  
  
 
  <tr>
    <td><div id="pr">
        <div align="left">
          <p>
            <input name="button" type="button" onclick="hide();window.print();" value="Print" />
          </p>
          <nobr>
          <!--<a href="chalan_bill_view.php?v_no=<?=$_REQUEST['v_no']?>">Bill</a>&nbsp;&nbsp;--><!--<a href="do_view.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank"><span style="display:inline-block; font-size:14px; color: #0033FF;">Bill Copy</span></a>-->
          </nobr>
		  <nobr>
          
          <!--<a href="chalan_bill_distributor_vat_copy.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank">Vat Copy</a>-->
          </nobr>	    </div>
      </div>
      
      <table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px">
       
        <tr>
          <td width="6%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="14%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Item Name </strong></td>
          <td width="13%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Style No </strong></td>
          <td width="14%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Measurement</strong></td>
          <td width="6%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Ply</strong></td>
          <td width="5%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>UOM</strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Quantity</strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Quantity <br /> 
            in (KG)</strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong> Price US$ </strong></td>
          <td width="13%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Total Value US$ </strong></td>
        </tr>
        
        <?  
		
		$sqlc = 'select c.delivery_date, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, c.total_unit, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.style_no, c.po_no,  c.paper_combination, c.L_cm, c.W_cm, c.H_cm, c.weight_per_sqm, c.sqm from pi_details c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.pi_id='.$pi_no.' group by c.id order by c.id asc';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:10px;">
          <td align="center" valign="top"><?=++$kk;?></td>
          <td align="left" valign="top"><?=$datac->item_name;?></td>
          <td align="left" valign="top"><? 
		  if ($datac->style_no!="") {
		  echo $datac->style_no;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
          <td align="center" valign="top"><? if($datac->L_cm>0) {?><?=$datac->L_cm?><? }?><? if($datac->W_cm>0) {?>X<?=$datac->W_cm?><? }?><? if($datac->H_cm>0) {?>X<?=$datac->H_cm?><? }?> <?=$datac->measurement_unit?></td>
          <td align="center" valign="top"><?=$datac->ply;?></td>
          <td align="center" valign="top"><?=$datac->unit_name;?></td>
          <td align="center" valign="top"><?=number_format($datac->total_unit,0); $grand_tot_unit1 +=$datac->total_unit; ?></td>
          <td align="center" valign="top"><?= number_format($qty_in_kg = ($datac->sqm*$datac->weight_per_sqm*$datac->total_unit),2); $total_qty_in_kg +=$qty_in_kg;  ?></td>
          <td align="center" valign="top"><?=number_format($datac->unit_price,4);?></td>
          <td align="center" valign="top"><?=number_format($datac->total_amt,2); $grand_total_amt +=$datac->total_amt; ?></td>
        </tr>
        
        <? }
		
		?>
        <tr style="font-size:12px;">
        <td colspan="4" align="right" valign="middle"><strong> Total:</strong></td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle"><strong>
          <?=number_format($grand_tot_unit1,0) ;?>
        </strong></td>
        <td align="center" valign="middle"><strong>
          <?=number_format($total_qty_in_kg,0) ;?>
        </strong></td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle"><strong>
          $<?=number_format($grand_total_amt,2) ;?>
        </strong></td>
        </tr>
      </table>
        
	 
	  
	  
      </td>
  </tr>
  
  
  
  
  <tr>
  
  	<td>&nbsp;</td>
  
  </tr>
  
  
  <?php /*?><tr>
  	<td colspan="2">
			<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >
        <tr>
          <td colspan="4" width="50%"><table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px">
        
        <tr>
          <td colspan="3" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Summary</strong></td>
          </tr>
        <tr>
          <td width="7%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="65%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Measurement</strong></td>
          <td width="28%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Quantity</strong></td>
          </tr>
        
        <?  $sqlc = 'select c.delivery_date, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, sum(c.total_unit) as total_unit, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.style_no, c.po_no,  c.paper_combination, c.L_cm, c.W_cm, c.H_cm from sale_do_details c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.do_no='.$do_no.' group by c.L_cm, c.W_cm, c.H_cm, c.measurement_unit order by c.id asc';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:12px;">
          <td align="center" valign="top"><?=++$kksm;?></td>
          <td align="center" valign="top"><? if($datac->L_cm>0) {?><?=$datac->L_cm?><? }?><? if($datac->W_cm>0) {?>X<?=$datac->W_cm?><? }?><? if($datac->H_cm>0) {?>X<?=$datac->H_cm?><? }?> <?=$datac->measurement_unit?></td>
          <td align="center" valign="top"><?=number_format($datac->total_unit,2); $tot_unit_sum +=$datac->total_unit; ?></td>
          </tr>
        
        <? }
		
		?>
        <tr style="font-size:12px;">
        <td colspan="2" align="right" valign="middle"><strong> Total:</strong></td>
        <td align="center" valign="middle"><strong><?=number_format($tot_unit_sum,2) ;?></strong></td>
        </tr>
		
		
		
		
		
		
		
		
		 
        
        
        <?  $sqlc = 'select c.delivery_date, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, c.total_unit, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.paper_combination, c.L_cm, c.W_cm, c.H_cm from sale_do_details c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.do_no='.$do_no.' group by c.id order by c.id asc';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        
        
        <? }
		
		?>
        
      </table></td>
		  <td colspan="3" width="10%">&nbsp;</td>
		  
		  <td colspan="3" width="40%">
		  	<table width="100%" border="1" style="font-size:12px" class="tabledesign1">
			<tr>
				<td width="61%"><div align="right"><strong>Total Order Quantity: </strong></div></td>
				<td width="39%" align="center"><strong>
				  <?=number_format($grand_tot_unit1,2) ;?>
				</strong></td>
			</tr>
			
		
			
			<tr>
				<td width="61%"><div align="right"><strong>Total Order Value: </strong></div></td>
				<td width="39%" align="center"><strong>
				  
				  $ <?=number_format($grand_tot_amt=find_a_field('sale_do_details','sum(total_amt)','do_no='.$master->do_no),2);?>
				</strong></td>
			</tr>
	  </table>
		  </td>
        </tr>
		
		</table>
		
		</td>
</tr><?php */?>
	
  
  
  
  
  <tr>
  	<td colspan="2">
			<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >
        
        
        
		  
		  
		  
		  <tr style="font-size:13px; font-weight:700; letter-spacing:.3px;">
		<td colspan="3" align="left">
		
		In Word: US Dollar <?

		

		$scs =  $grand_total_amt;

			 $credit_amt = explode('.',$scs);

	 if($credit_amt[0]>0){

	 

	 echo convertNumberToWordsForIndia($credit_amt[0]);}

	 if($credit_amt[1]>0){

	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;

	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' Cents ';}

	 echo ' Only';

		?>.		</td>
          </tr>

        <tr>
          <td colspan="3" align="left" style="font-size:13px; font-weight:700; letter-spacing:.3px;">Terms &amp; Condition : </td>
        </tr>
		
		 <?  
		
		$tc_sql = 'select * from pi_terms_condition where pi_id="'.$pi_no.'" group by id order by sl_no ';
			$tc_query=db_query($tc_sql);
			while($tc_data= mysqli_fetch_object($tc_query)){

			?>
		
		
		<tr style="font-size:12px; letter-spacing:.3px; line-height: 16px;">
		  <td width="4%" align="left" >&nbsp;</td>
		  <td width="6%" align="left" ><?=++$as;?>.</td>
		  <td width="90%" align="left"><?=$tc_data->terms_condition;?></td>
		  </tr>
        
        
         <? }?>
        
      
        <tr>
          <td colspan="3" align="left">&nbsp;</td>
        </tr>
      </table>	</td>
  </tr>
	
	
	
	

	<tr>
		<td>
	
	
	<!-- style="border:1px solid #000; color: #000;"-->
	      <div class="footer"> 
	
	<table width="100%" cellspacing="0" cellpadding="0"  >
	
	
		
		<tr>
            <td colspan="4">&nbsp;  </td>
		</tr>
		
		<tr>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="25%">&nbsp;</td>
		    <td  align="center" width="25%">&nbsp;</td>
		    <td  align="center" width="25%">&nbsp;</td>
		    <td align="center"  width="25%">&nbsp;</td>
		</tr>
		
		<tr>
            <td colspan="2">Prepared By :
                <?=find_a_field('user_activity_management','fname','user_id='.$master->entry_by);?>,&nbsp; Prepared At :
                <?=$master->entry_at?>  </td>
		    <td colspan="2">This is an ERP generated report </td>
		    </tr>
	
	<tr>
            <td colspan="4">  <hr /> </td>
		</tr>
	
        
	
          <tr>
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
          </tr>
	</table>
	  </div>
	</td>
  </tr>
  
  </tbody>
</table>
</body>
</html>
