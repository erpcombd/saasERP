<?php



session_start();
require_once "../../../controllers/routing/print_view.top.php";


//====================== EOF ===================



//var_dump($_SESSION);




 

 
//
//require_once "../../../controllers/routing/default_values.php";
//require_once SERVER_CORE."routing/layout.top.php";

// require_once ('../../../acc_mod/common/class.numbertoword.php');


 echo $pr_no = url_decode(str_replace(' ', '+', $_REQUEST['v']));
 $c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));
 
 $master = find_all_field('purchase_return_details','','pr_no='.$pr_no);

$group = find_all_field('user_group','','id='.$master->group_for);

//$do_no= find_a_field('sale_return_details','do_no','chalan_no='.$chalan_no);






  		  $barcode_content = $pr_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';


foreach($challan as $key=>$value){
$$key=$value;
}

  $ssql = 'select a.*,b.* from vendor a, purchase_return_details b where a.vendor_id=b.vendor_id and b.pr_no='.$pr_no;

 $dealer = find_all_field_sql($ssql);

$entry_time=$dealer->do_date;



$dept = 'select warehouse_name from warehouse where warehouse_id='.$dept;

$deptt = find_all_field_sql($dept);

$to_ctn = find_a_field('purchase_return_details','sum(pkt_unit)','pr_no='.$pr_no);

$to_pcs = find_a_field('purchase_return_details','sum(dist_unit)','pr_no='.$pr_no); 



$ordered_total_ctn = find_a_field('purchase_return_details','sum(pkt_unit)','dist_unit = 0 and pr_no='.$pr_no);

$ordered_total_pcs = find_a_field('purchase_return_details','sum(dist_unit)','pr_no='.$pr_no); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta charset="UTF-8">
<title>.: Purchase Ruturn :.</title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
<?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>
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
<?php /*?>div.page_brack
{
    page-break-after:always;
}<?php */?>



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


@media print{
.footer {
    position: fixed;
    bottom: 900px;   
    left: 0;
    width: 100%;
    background: #fff;
  }
}

@media print {
  .brack {page-break-after: always;}
}

#pr input[type="button"] {
	width: 70px;
	height: 25px;
	background-color: #6cff36;
	color: #333;
	font-weight: bolder;
	border-radius: 5px;
	border: 1px solid #333;
	cursor: pointer;
}

.qrl-text {
padding-right: 19px !important;

}

.footer1{
	margin-top: 30px !important;
}


</style>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif; font-size: 10px;">

<div class="page_brack" >

<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">

  
  <thead>
  <tr>
    <td><div class="header">
		<table class="table1">
		<tr>
		<td class="logo">
			<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" class="logo-img"/>
		</td>
		
		<td class="titel">
				<h2 class="text-titel"> <?=$group->group_name?> </h2>			
				<p class="text"><?=$group->address?></p>
				<p class="text">Cell: <?=$group->mobile?>. Email: <?=$group->email?> <br> <?=$group_data->vat_reg?></p>
				<p class="text">
                     <? $war=find_all_field('warehouse','','warehouse_id='.$all->warehouse_id);
                      echo $war->warehouse_name;?>
				</p>
		</td>
		
		
		<?php /*?><td class="Qrl_code">
					<?='<img class="barcode Qrl_code_barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
			<p class="qrl-text"><?=$dealer->pr_no?></p>
		</td><?php */?>
		
		<td class="qr-code">
        <?php 
		$company_id=url_encode($cid);
        $req_no_qr_data = url_encode($pr_no);
        $print_url = "https://saaserp.ezzy-erp.com/app/views/warehouse_mod/purchase_return/purchase_invoice_print_view.php?c=".rawurlencode($company_id)."&v=" . rawurlencode($req_no_qr_data);
        $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=" . urlencode($print_url);
        ?>
        <img src="<?=$qr_code?>" alt="QR Code" style=" width: 110px; height: 110px; ">
    </td>
		
		</tr>
		 
		</table>
	</div></td>
  </tr>
  
  
  


 
 
 
 
 <tr> <td><hr /></td></tr>

 
  
 
  
  
  <tr> <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  <tr><td>&nbsp;</td></tr>
  
  	<tr height="30">
  	  <td width="25%" valign="top"></td>
  	  <td width="50%"  style="text-align:center; "><span style="color:#FFF; font-size:18px; background:#CCCCCC; padding:8px 40px; color:#000000; font-weight:bold; border: 2px solid #000000; border-radius: 5px; ">
	  PURCHASE RETURN</span> </td>
  	  <td width="25%" align="right" valign="right">&nbsp;</td>
	  </tr>
	  
	  <tr><td>&nbsp;</td></tr>
	 
  </table>
  
  </td></tr>
  
  
  
 
	  
	  
	   
  
  
  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		
		

		  <tr>

		    <td valign="top">

		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			  
			  
			  
			  
			  
			  
			  
			  <tr>
				  
				  <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; font-weight:bold;" class="style8"> PR No: <?php echo $dealer->pr_no?> &nbsp;</span></td>
		              </tr>

		            </table></td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; font-weight:bold; float: left;" class="style8"> PR Date:
                            <?=date("j-M-Y",strtotime($dealer->entry_time));?>
                     &nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>

		        

                  <tr>
				  
				  <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; " class="style8">
		               Customer:  <?php echo $dealer->vendor_name?>
		              &nbsp;</span></td>
		              </tr>

		            </table></td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; " class="style8"> Type: <?php if (!empty($dealer->category_name)) {echo $dealer->category_name;} else {echo "N/A";}?>&nbsp;
					  </span></td>
		              </tr>

		            </table></td>
		          </tr>

		        <tr>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8">VAT No: <?php if (!empty($dealer->vat_reg)) {echo $dealer->vat_reg;} else {echo "N/A";}?>&nbsp;
					  </span></td>
		              </tr>

		            </table></td>
					
					<td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8">Contact No: <?php echo $dealer->contact_no?>&nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>
				  
				  
				  <tr>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8">C.R No: <?php if (!empty($dealer->cr_no)) {echo $dealer->cr_no;} else {echo "N/A";}?>&nbsp;</span>			                      </td>
		              </tr>

		            </table></td>
					
					<td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8">Address: <?php if (!empty($dealer->address)) {echo $dealer->address;} else {echo "N/A";}?>&nbsp;
					  </span></td>
		              </tr>

		            </table></td>
		          </tr>

		        

                  
		        </table>		      </td>

		  </tr>

		</table></td>

	  </tr>
  
  <tr><td>&nbsp;</td></tr>
  
 
  <tr>
  	<td>
		<div id="pr">
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
	</td>
  
  </tr>
  
  
   </thead>
  
 
  <tbody >
 
  <tr >
    <td valign="top">
      
      <table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px"  >
       
       
<tr>

<th width="4%" bgcolor="#CCCCCC">SL</th>

<th style="text-align:center;" width="6%" bgcolor="#CCCCCC">Code</th>
<th style="text-align:center;" width="29%" bgcolor="#CCCCCC">Item Description</th>
<th style="text-align:center;" width="7%" bgcolor="#CCCCCC">Ctn Size </th>
<th style="text-align:center;" width="8%" bgcolor="#CCCCCC">Unit Price </th>
<th style="text-align:center;" width="6%" bgcolor="#CCCCCC">Ctn</th>
<th style="text-align:center;" width="7%" bgcolor="#CCCCCC">Pcs</th>
<th style="text-align:center;" width="7%" bgcolor="#CCCCCC"><span role="presentation" dir="ltr">Net  Amount</span></th>
</tr>


        
   <? 

//, (a.init_pkt_unit*a.unit_price) as Total,(a.init_pkt_unit-a.inStock_ctn) as Shortage

  $res='select  s.sub_group_name,  b.item_name, a.*
   from purchase_return_details a, item_info b, item_sub_group s 
   where b.item_id=a.item_id  and b.sub_group_id=s.sub_group_id and a.pr_no='.$pr_no.' order by a.pr_no ';
   
   
   $i=1;

$query = db_query($res);

while($data=mysqli_fetch_object($query)){

?>
        <tr>

<td><?=$i++?></td>

<td><?=$data->item_id?></td>
<td><?=$data->item_name?></td>
<td style="text-align:right;"><?=$data->pkt_size?></td>
<td style="text-align:right;"><?= number_format($data->unit_price, 2); ?></td>
<td style="text-align:right;"><?=$data->pkt_unit?></td>
<td style="text-align:right;"><?= number_format($data->dist_unit, 2); ?></td>
<td style="text-align:right;"><?=$data->total_amt; $tot_total_amt +=$data->total_amt;?></td>
</tr>
        
        <?  } ?>
        <tr>

<td colspan="7"><div align="right"><strong>   Total:</strong></div></td>

<td style="text-align:right;"><strong>
  <?=number_format($tot_total_amt,2);?>
</strong></td>
</tr>
      </table>      </td>
  </tr>
  
  
  
  
  
  
  
  
  <?php /*?><tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		
		

		  <tr>

		    <td valign="top">

		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">

		        

                  <tr>

		          <td><table width="100%" height="70" border="1" cellpadding="3" cellspacing="0">

		            <tr>

		              <td valign="top"><span style="font-size:16px; font-weight:500; letter-spacing:.3px;" class="style8">
					  In Word: SAR
            <?

$taxable_amount =  $tot_total_amt-$master->cash_discount;
$tot_vat_amt = ($taxable_amount*$master->vat)/100;
$amount_including_vat = $taxable_amount+$tot_vat_amt;
			
			

		$scs =  number_format($amount_including_vat,2);

			 $credit_amt = explode('.',$scs);

	 if($credit_amt[0]>0){

	 

	 echo convertNumberToWordsForIndia($credit_amt[0]);}

	 if($credit_amt[1]>0){

	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;

	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' Halala ';}

	 echo ' Only';

		?>.
					  
					  </span></td>
		              </tr>

		            </table></td>
		          </tr>
				  
				  
				  <tr>

		          <td><table width="100%" height="70" border="1" cellpadding="3" cellspacing="0">

		            <tr>

		              <td valign="top"><span style="font-size:12px; font-weight:500; letter-spacing:.3px;" class="style8">
					  <strong>Declaration:</strong><br />
					  We declare that this invoice shows actual price of Those goods described and that all particulars are true and correct. <br />
					  N.B.: Software Generate Bill. Signatory Not Required. 
            
					  
					  </span></td>
		              </tr>

		            </table></td>
		          </tr>
		        </table>		      </td>

			<td width="40%">
			 
			    <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			      
			      
			      
			      <tr>
			        
			        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			          
			          <tr>
			            
			            <td width="68%"><strong>Total (Excluding VAT) 
			              
			              </strong>&nbsp;</td>
						  
						   <td width="32%"><strong>
			              <?=number_format($tot_total_amt,2);?>
			              </strong>&nbsp;</td>
	                    </tr>
			          
			          </table></td>
		            </tr>
					
					
					
					<tr>
			        
			        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			          
			          <tr>
			            
			            <td width="68%"><strong>Discount
			              
			              </strong>&nbsp;</td>
						  
						   <td width="32%"><strong>
			              <?=number_format($master->cash_discount,2);?>
			              </strong>&nbsp;</td>
	                    </tr>
			          
			          </table></td>
		            </tr>
					
					
					<tr>
			        
			        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			          
			          <tr>
			            
			            <td width="68%"><strong>Total Taxable Amount
			              
			              </strong>&nbsp;</td>
						  
						   <td width="32%"><strong>
			             
						  
						  <?=$taxable_amount =  $tot_total_amt-$master->cash_discount;?>
						  
			              </strong>&nbsp;</td>
	                    </tr>
			          
			          </table></td>
		            </tr>
					
					
					<tr>
			        
			        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			          
			          <tr>
			            
			            <td width="68%"><strong>Total VAT
			              
			              </strong>&nbsp;</td>
						  
						   <td width="32%"><strong>
			              <?= $tot_vat_amt = ($taxable_amount*$master->vat)/100;?>
			              </strong>&nbsp;</td>
	                    </tr>
			          
			          </table></td>
		            </tr>
					
					
					<tr>
			        
			        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			          
			          <tr>
			            
			            <td width="68%"><strong>Total Amount Including VAT 
			              
			              </strong>&nbsp;</td>
						  
						   <td width="32%"><strong>
			              <?=number_format($amount_including_vat = $taxable_amount+$tot_vat_amt,2);?>
			              </strong>&nbsp;</td>
	                    </tr>
			          
			          </table></td>
		            </tr>
			      
			      
			      
			      </table>
		      </td>
		  </tr>

		</table></td>

	  </tr><?php */?>
  
  
  </tbody>
  
	
	
	<tfoot >

	<tr>
		<td>
	
	 <div class="footer1"> 
	<table width="100%" cellspacing="0" cellpadding="0"   >

		  <tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		   <tr>
		  <td align="center"  style=" font-size:12px;">
		  
		  <?php $uid=find_a_field('sale_return_master','entry_by','do_no="'.$do_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?></td>
		  <td align="center"></td>
		  <td align="center"></td>
		  </tr>
		<tr>
		  <td align="center" >---------------------------------</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">---------------------------------</td>
		  </tr>
		<tr>
		  <td align="center"></td>
		  <td align="center"></td>
		  <td align="center"></td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="25%"><strong>Sales Officer </strong></td>
		    <td  align="center" width="25%">&nbsp;</td>
		    <td  align="center" width="25%"><strong>Customer</strong></td>
		    </tr>
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  </tr>
	
          <tr>
            <td colspan="4"><?
$page_name="PO Print View";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?></td>
		</tr>
		  
		  
		  
	</table>
	
	</div>
	
</td>
	  </tr>
	
	</tfoot>
	
  
</table>


</div>



</body>
</html>
