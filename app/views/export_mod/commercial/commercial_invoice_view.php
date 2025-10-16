<?php



//



//====================== EOF ===================



//var_dump($_SESSION);




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once SERVER_CORE."core/class.numbertoword.php";

$ci_no 		= $_REQUEST['v_no'];


$ci_data = find_all_field('commercial_invoice','','ci_no='.$ci_no); 

$master= find_all_field('pi_master','','id='.$pi_no);



		  $barcode_content = $ci_no;
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
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$ci_no;?></title>
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
					    <td align="left" width="50%"><span style="font-size:14px; padding: 3px 0 0 5px; letter-spacing:5px;"><?=$ci_no;?></span></td>
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
							  
							  <tr><td style="padding-bottom:3px;  font-size:12px;">BIN/VAT Reg. No. : 000073530403</td>
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
   <td colspan="2" align="center"><h4 style="font-size:18px; padding:10px 0; margin:0; font-family:  'MYRIADPRO-REGULAR'; letter-spacing:1px;text-decoration:underline;">
   COMMERCIAL INVOICE</h4></td>
  </tr>
  
 
  
  
 <tr> <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="68%" valign="top">


		      <table width="97%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px; letter-spacing:.3px;">


		       
			   <tr>
		          <td align="left" valign="middle" style=" font-size:14px; text-transform: uppercase; font-weight:700; margin-bottom:10px;"><strong>SHOPPER/EXPORTER:</strong></td>
		          <td align="left" valign="middle" style="font-size:13px; text-transform: uppercase;">&nbsp;</td>
	            </tr>
			   
			   
		        
		        <tr>
		          <td colspan="2" align="left" valign="middle" style=" font-size:14px; text-transform: uppercase; font-weight:700; margin-bottom:10px;"><?=find_a_field('user_group','group_name','id='.$_SESSION['user']['group'])?> </td>
	            </tr>
		        
		        <tr>
		          <td align="left" valign="middle" style=" text-transform:capitalize;" width="60%" ><?=find_a_field('user_group','address','id='.$_SESSION['user']['group'])?></td>
	              <td align="left" valign="middle" style="font-size:13px; text-transform: uppercase;" width="40%">&nbsp;</td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle" style=" text-transform:capitalize;" >&nbsp;</td>
		          <td align="left" valign="middle" style="font-size:13px; text-transform: uppercase;">&nbsp;</td>
	            </tr>
		        <tr>
		          <td align="left" valign="middle" style=" font-size:14px; text-transform: uppercase; font-weight:700; margin-bottom:10px;" ><strong>CUSTOMER NAME: </strong></td>
		          <td align="left" valign="middle" style="font-size:13px; text-transform: uppercase;">&nbsp;</td>
	            </tr>
				
				 <tr>
		          <td colspan="2" align="left" valign="middle" style=" font-size:14px; text-transform: uppercase; font-weight:700; margin-bottom:10px;"><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$ci_data->dealer_code);?> </td>
	            </tr>
		        
		        <tr>
		          <td align="left" valign="middle" style=" text-transform:capitalize;" width="60%" ><?= find_a_field('dealer_info','address_e','dealer_code='.$ci_data->dealer_code);?></td>
	              <td align="left" valign="middle" style="font-size:13px; text-transform: uppercase;" width="40%">&nbsp;</td>
		        </tr>
            </table>		      </td>


			<td width="32%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2"  style="font-size:13px; letter-spacing:.3px;">
			
			
			
			<tr>


                <td width="55%" align="right" valign="middle"><div align="left">P/I No</div></td>


			    <td width="4%">: </td> 
			    <td width="41%"><span><?php echo $ci_data->view_pi_no;?></span></td>
			</tr>




			  <tr>


                <td width="55%" align="right" valign="middle"><div align="left">P/I Date</div></td>


			    <td>:</td> 
			    <td><?=date("d M, Y",strtotime($ci_data->pi_date))?></td>
			  </tr>
			  
			  <tr>
			    <td align="right" valign="middle"><div align="left"> L/C/ Sales Contract No </div></td>
			    <td>: </td>
			    <td><?php echo $ci_data->sc_invoice_no;?></td>
			  </tr>
			  
			  <tr>
			    <td align="right" valign="middle"><div align="left"> L/C/ Sales Contract Date </div></td>
			    <td>: </td>
			    <td><?=date("d M, Y",strtotime($ci_data->sc_invoice_date))?></td>
			  </tr>
			  
		
			  <tr>
			    <td align="right" valign="middle"><div align="left"> Export L/C No </div></td>
			    <td>: </td>
			    <td><?php echo $ci_data->export_lc_no;?></td>
			  </tr>
			  
			  <tr>
			    <td align="right" valign="middle"><div align="left"> Export L/C Date </div></td>
			    <td>: </td>
			    <td><?=date("d M, Y",strtotime($ci_data->export_lc_date))?></td>
			  </tr>
			  
			  
			  <tr>
			    <td align="right" valign="middle"><div align="left">D/N No </div></td>
			    <td>: </td>
			    <td><?php echo $ci_data->dn_no; ?></td>
			  </tr>
			  
		
			  <tr>
			    <td align="right" valign="middle"><div align="left">D/N Date </div></td>
			    <td>: </td>
			    <td><?=date("d M, Y",strtotime($ci_data->dn_date))?></td>
			  </tr>
			  
			  
			  <tr>
			    <td align="right" valign="middle"><div align="left">C/I No </div></td>
			    <td>: </td>
			    <td><?php echo $ci_data->ci_no; ?></td>
			  </tr>
			  
		
			  <tr>
			    <td align="right" valign="middle"><div align="left">C/I Date </div></td>
			    <td>: </td>
			    <td><?=date("d M, Y",strtotime($ci_data->ci_date))?></td>
			  </tr>
			
			  
			  
			


			  


			  


		    </table></td>
		  </tr>


		</table>		</td></tr>
		
		
		<tr> <td colspan="2">
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  	<tr>
		<td width="25%" valign="top"></td>
			<td width="50%" valign="middle" align="center">&nbsp;</td>
		<td width="25%" valign="right" align="right">&nbsp;</td>
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
      
      <table width="100%" class="tabledesign"   border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="5"  style="font-size:12px">
       
        <tr >
          <td width="6%" align="center" bgcolor="#CCCCCC">SL</td>
          <td width="14%" align="center" bgcolor="#CCCCCC">Item Name </td>
          <td width="14%" align="center"  bgcolor="#CCCCCC">Measurement</td>
          <td width="6%" align="center"  bgcolor="#CCCCCC">Ply</td>
          <td width="5%" align="center"  bgcolor="#CCCCCC">UOM</td>
          <td width="9%" align="center" bgcolor="#CCCCCC">Quantity</td>
          <td width="10%" align="center" bgcolor="#CCCCCC">Quantity <br /> 
            in (KG)</td>
          <td width="10%" align="center"  bgcolor="#CCCCCC"> Price  </td>
          <td width="13%" align="center" bgcolor="#CCCCCC">Total Value </td>
        </tr>
        
        <?  
		
		$sqlc = 'select c.delivery_date, c.delivery_place, c.printing_info, c.additional_info, c.measurement_unit, sum(c.total_unit) as total_unit, c.unit_price, i.unit_name, sum(c.total_amt) as total_amt, i.item_id, i.item_name, c.ply, c.style_no, c.po_no,  c.paper_combination, c.L_cm, c.W_cm, c.H_cm, c.weight_per_sqm, c.sqm from commercial_invoice a, pi_details c, item_info i,  item_sub_group s, item_group g where a.pi_id=c.pi_id and i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and a.ci_no='.$ci_no.' 
		group by i.item_id, c.L_cm, c.W_cm, c.H_cm, c.ply order by c.id asc';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:12px;">
          <td align="center" valign="top"><?=++$kk;?></td>
          <td align="left" valign="top"><?=$datac->item_name;?></td>
          <td align="center" valign="top"><? if($datac->L_cm>0) {?><?=$datac->L_cm?><? }?><? if($datac->W_cm>0) {?>X<?=$datac->W_cm?><? }?><? if($datac->H_cm>0) {?>X<?=$datac->H_cm?><? }?><?=$datac->measurement_unit?></td>
          <td align="center" valign="top"><?=$datac->ply;?></td>
          <td align="center" valign="top"><?=$datac->unit_name;?></td>
          <td align="center" valign="top"><?=number_format($datac->total_unit,0); $grand_tot_unit1 +=$datac->total_unit; ?></td>
          <td align="center" valign="top"><?= number_format($qty_in_kg = ($datac->sqm*$datac->weight_per_sqm*$datac->total_unit),2); $total_qty_in_kg +=$qty_in_kg;  ?></td>
          <td align="center" valign="top">$ <?=number_format($datac->unit_price,4);?></td>
          <td align="center" valign="top">$ <?=number_format($datac->total_amt,2); $grand_total_amt +=$datac->total_amt; ?></td>
        </tr>
        
        <? }
		
		?>
        <tr style="font-size:12px;">
        <td colspan="3" align="right" valign="middle"><strong> Total:</strong></td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle"><strong>
          <?=number_format($grand_tot_unit1,0) ;?>
        </strong></td>
        <td align="center" valign="middle"><strong>
          <?=number_format($total_qty_in_kg,2) ;?>
        </strong></td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle"><strong>
          $<?=number_format($grand_total_amt,2) ;?>
        </strong></td>
        </tr>
      </table>      </td>
  </tr>
  
  
  
  
  <tr>
  
  	<td colspan="2">&nbsp;</td>
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
  	<td colspan="3">
			<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >
        
        
        
		  
		  
		  
		  <tr style="font-size:14px; font-weight:500; letter-spacing:.5px; line-height:20px; text-transform:uppercase;">
		<td colspan="3" align="left">
		
		SAY TOTAL <b> US Dollar <?

		

		$scs =  $grand_total_amt;

			 $credit_amt = explode('.',$scs);

	 if($credit_amt[0]>0){

	 

	 echo convertNumberToWordsForIndia($credit_amt[0]);}

	 if($credit_amt[1]>0){

	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;

	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' Cents ';}

	 echo ' Only';

		?>.</b>  DRAWN UNDER <? $bank_buyers=find_a_field('sales_contract','bank_buyers','invoice_no='.$ci_data->sc_invoice_no);?>
		 <?= find_a_field('bank_buyers','bank_name','bank_id='.$bank_buyers);?>, <?= find_a_field('bank_buyers','branch_name','bank_id='.$bank_buyers);?>.		</td>
          </tr>
		  
		  
		   <tr style="font-size:14px; font-weight:700; letter-spacing:.5px; line-height:20px; text-transform:uppercase;">
		    <td colspan="3" align="left">
			L/C No. <?php echo $ci_data->export_lc_no;?> Dated 
			<?=date("d M, Y",strtotime($ci_data->export_lc_date))?>
			. EXPORT CONTRACT NO. <?php echo $ci_data->sc_invoice_no;?>.
PROFORMA INVOICE NO. <?php echo $ci_data->view_pi_no;?> DATED 
<?=date("d M, Y",strtotime($ci_data->pi_date))?>
. APPICANT BIN NO.
000187439-1105, BEPZA PERMISSION NO. PJT-IEPZ/40/219. LCF NO. SCB-2015142.
BENEFICIARY BIN NO. 000073153-0403H.S.CODE. 4819.10.00.		</td>
		    </tr>
			
			
			<tr style="font-size:14px; font-weight:500; letter-spacing:.5px; line-height:20px; text-transform:uppercase;">
		    <td colspan="3" align="left">
			WE HEREBY CERTIFY THAT THE GOODS HAVE BEEN SHIPPED STRICTLY IN
ACCORDANCE WITH THE TERMS OF THE PROFORMA INVOICE AS STATED ABOVE
AND ALL THE TERMS & CONDITIONS THEREOF HAVE BEEN FULLY COMPLIED WITH.
THE IMPORT IS BEING MADE UNDER BACK TO BACK SYSTEM AGAINST EXPORT
CONTRACT AND SHIPMENT MADE FROM M/S. 
<?=find_a_field('user_group','group_name','id='.$_SESSION['user']['group'])?>
 TO 
<?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$ci_data->dealer_code);?>
, 
<?= find_a_field('dealer_info','address_e','dealer_code='.$ci_data->dealer_code);?>.</td>
		    </tr>

        
	
		
		
      </table>	</td>
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
		  <td width="25%" align="center">&nbsp;</td>
		  <td width="25%"  align="center">&nbsp;</td>
		  <td width="25%"  align="center">&nbsp;</td>
		  <td width="25%" align="center">&nbsp;</td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="center" style="font-size:14px; text-transform: uppercase; font-weight:700; "><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$ci_data->dealer_code);?></td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center" style="font-size:14px; text-transform: uppercase; font-weight:700;"><?=find_a_field('user_group','group_name','id='.$_SESSION['user']['group'])?></td>
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
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
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
