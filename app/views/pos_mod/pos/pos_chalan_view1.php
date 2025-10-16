<?php



session_start();



//====================== EOF ===================



//var_dump($_SESSION);



require_once "../../../assets/template/layout.top.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

$pos_id 		= $_REQUEST['v_no'];

$group_data = find_all_field('user_group','group_name','id='.$_SESSION['user']['group']);

$master= find_all_field('sale_pos_master','','pos_id='.$pos_id);



  		  $barcode_content = $chalan_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';


foreach($challan as $key=>$value){
$$key=$value;
}

$ssql = 'select a.*,b.do_date, b.group_for, b.via_customer from dealer_pos a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;



$dealer = find_all_field_sql($ssql);
$entry_time=$dealer->do_date;

$wh_info = find_all_field('warehouse','','warehouse_id="'.$master->warehouse_id.'"');
$pos_payment = find_all_field('pos_payment','','pos_id="'.$pos_id.'"');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>POS <?=$pos_id;?></title>
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

@media print {
  .brack {page-break-after: always;}
}


</style>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif; font-size: 10px;">

<div class="page_brack" >

<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
  <tbody>
  <tr>
    <td><div class="header">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="20%">
                        <!--<img src="../../../logo/<?=$_SESSION['user']['group']?>.png" style=" width:100%" />-->
                        <td width="60%"><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                            <tr>
                              <td style="text-align:center; color:#000; font-size:14px; font-weight:bold;">
						
								<p style="font-size:18px; color:#000000; margin:0; padding: 0 0 5px 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"><img src="../../../logo/whitelogo.png"/></p>
								<p style="font-size:14px; font-weight:300; color:#000000; margin:0; padding:0;"><?=$wh_info->address?></p>
								  
								<p style="font-size:14px; font-weight:300; color:#000000; margin:0; padding:07px;">Phon No. : <?=$wh_info->contact_no?>,  Email : <?=$wh_info->email?></p>                              </td>
                            </tr>
                            <tr>


        <!--<td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">WORK ORDER </td>-->
      </tr>
                          </table>
                        <td width="20%"> 
						
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					
					<!--<tr>
					  
					  <td align="center"><h4 style="font-size:16px;">Customer's Copy</h4></td>
					  </tr>-->
                      
					  
					  <tr>
					  
					  <td><?='<img class="barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?></td>
					  </tr>
					  
					  <tr>
					  
					  <td><span style="font-size:14px; padding: 3px 0 0 10px; letter-spacing:7px;"><?=$chalan_no?></span></td>
					  </tr>
					  </table>						</td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
          <tr>          </tr>
        </table>
      </div></td>
  </tr>
  

 
 
 
 
 
 

 
  <tr> <td><hr /></td></tr>
 
  
  
  <tr> <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  	<tr height="30" style=" background-color: #cccccc; ">
  	  <td width="25%" valign="top"></td>
  	  <td width="50%"  style="text-align:center; color:#FFF; font-size:18px; padding:0px; color:#000000; font-weight:bold;">CHALLAN</td>
  	  <td width="25%" align="right" valign="right">&nbsp;</td>
	  </tr>
  </table>
	  
	 <!-- <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" style="background:darkgray;">
      <tr>
        <td style="text-align:center; color:white; font-size:18px; font-weight:bold;"><span class="style1" >POS SALES</span></td>
      </tr>
    </table></td>
              </tr>
            </table>
  -->
  </td></tr>
  
  
  <tr> <td>&nbsp;</td></tr>
  
  
  
 <tr> <td><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="100%" valign="top">


		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:12px">


				 <tr>
		          <td width="20%" align="left" style="font-size:12px; font-weight:700;" >Sales Order  No </td>
				  <td width="30%" style="font-size:12px; font-weight:700;">	:  &nbsp;<?php echo $pos_id;?>
		          <td style="font-size:12px; font-weight:700;">Sale Date :<?php echo $master->pos_date;?> </td>
				  <td rowspan="4" style="font-size:12px;">
						<img id="image_id" src="https://chart.googleapis.com/chart?chs=150x150&amp;cht=qr&amp;chl=Whiteshell-&nbsp;POS No.<?=$pos_id?>.&nbsp;Customer :<?=$dealer->dealer_name?>.&nbsp;Total Amt : <?=number_format($grand_total,2)?>&amp;choe=UTF-8" alt="QR code">
					</td>
				</tr>
				  
		        <tr>
		          <td width="20%" align="left" valign="middle" style="font-size:12px; font-weight:700;">Customer Name</td>
		          <td width="30%" style="font-size:12px; font-weight:700;">:	&nbsp;
		            <?= find_a_field('dealer_pos','dealer_name','dealer_code="'.$master->dealer_id.'"');?></td>
					<td style="font-size:12px; font-weight:700;">Payment Terms :<?=$pos_payment->payment_method?></td>
	              </tr>
		        <tr>
		          <td align="left" valign="middle" style="font-size:12px; font-weight:700;">Address</td>
		          <td width="30%" style="font-size:12px; font-weight:700;">:	&nbsp;
		            <?= find_a_field('dealer_pos','address_e','dealer_code="'.$master->dealer_id.'"');?></td>
					<td style="font-size:12px; font-weight:700;">Sales Person					  : <?= find_a_field('personnel_basic_info','PBI_NAME','PBI_CODE="'.$master->sales_person.'"');?></td>
	              </tr>
		        
		        <tr>
		          <td align="left" valign="middle" style="font-size:12px; font-weight:700;">Mobile No </td>
		         <td width="30%" style="font-size:12px; font-weight:700;">:	&nbsp;
	              <?= find_a_field('dealer_pos','contact_no','dealer_code="'.$master->dealer_id.'"');?></td>
					<td style="font-size:12px; font-weight:700;">Stock : Banani,Dhaka-1213</td>
	              </tr>
				 
		        <tr>
		        		        </table>		      </td>
		  </tr>


		</table>		</td></tr>
  
  
 
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
      
      <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#000000" class="tabledesign"  style="font-size:12px">
        <tr>
          <th width="4%" bgcolor="#CCCCCC">SL</th>
          <th width="9%" bgcolor="#CCCCCC">Item Name </th>
          <th width="37%" bgcolor="#CCCCCC">Item Description </th>
          <th width="9%" bgcolor="#CCCCCC">Unit</th>
          <th width="10%" bgcolor="#CCCCCC">Quantity</th>
         <!-- <th width="10%" bgcolor="#CCCCCC">Unit Price</th>
          <th width="21%" bgcolor="#CCCCCC">Amount</th>-->
        </tr>
        <? 

   
$res='select  i.item_id,i.item_name,rate, sum(qty) as total_unit,sum(total_amt) as total_amt, discount_amt

 from sale_pos_details s,item_info i
 
 WHERE i.item_id=s.item_id and pos_id='.$pos_id.' group by id';
   
   $i=1;

$query = mysql_query($res);

while($data=mysql_fetch_object($query)){
$item_amt = $data->rate*$data->total_unit;
$total_amt +=$item_amt;
$item_discount +=$data->discount_amt; 
?>
        <tr>
          <td><?=$i++?></td>
          <td><?=$data->item_name?></td>
          <td><?=find_a_field('item_info','item_name','item_id="'.$data->item_id.'"')?></td>
          <td><?=find_a_field('item_info','unit_name','item_id="'.$data->item_id.'"')?></td>
          <td><?=$data->total_unit?></td>
          <?php /*?><td><?=$data->rate?></td>
          <td><?=$item_amt?></td><?php */?>
        </tr>
        <?
		 }
		$total_discount = $item_discount+$master->register_discount;
		?>
		
		<!--<tr>
          <td colspan="6"><div align="right"><strong>Item Total:</strong></div></td>
		  <td><strong><?=number_format($total_amt,3);?></td>
        </tr>
		
		<tr>
          <td colspan="6"><div align="right"><strong>Discount:</strong></div></td>
		  <td><strong><?=number_format($total_discount,3);?></td>
        </tr>
		
		<tr>
          <td colspan="6"><div align="right"><strong>Vat 5 %:</strong></div></td>
		  <td><strong><?=number_format(($vat=$total_amt*5/100),3);?></td>
        </tr>
		
		<tr>
          <td colspan="6"><div align="right"><strong>Total Payable:</strong></div></td>
		  <td><strong><?=number_format($total_payable=($total_amt+$vat)-$total_discount,3);?></td>
        </tr>
       
        <tr style="font-size:16px; font-weight:500; letter-spacing:.3px;">
          <td colspan="7">In Word:-->
            </td>
        </tr>
      </table></td>
  </tr>
  
  
  
  
  <tr>
  
  	<td>&nbsp;</td>
  </tr>
  

  
  
  
	
	
	

	<tr>
		<td>
	
	
	<!-- style="border:1px solid #000; color: #000;"-->
	      <div class="footer"> 
	
	<table width="100%" cellspacing="0" cellpadding="0"  >
	
	
		
		<tr>
		  <td colspan="4">&nbsp;</td>
		  </tr>
	
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		
				
		   
		<tr style="font-size:12px">
		
            <td align="center" colspan="2">
				<?=find_a_field('user_activity_management','fname','user_id="'.$master->entry_by.'"')?></h3></td>
			 
		   
		    <td  align="center" colspan="2"><br /></td>
			
		    </tr>

		
		   
		<tr style="font-size:12px">
		
            <td align="center" colspan="2">
				 <p style="margin: 0; padding: 0px;">.......................</p>
				<h3 style="margin: 0; padding: 0px;">Prepared By</h3>
			
			</td>
			 
		   
		    <td  align="center" colspan="2">
				<p style="margin: 0; padding: 0px;">.......................</p>
				<h3 style="margin: 0; padding: 0px;">Checked By</h3>
			</td>
			
		    </tr>
			
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  </tr>
		
			<tr>
            <td colspan="4">&nbsp;  </td>
		</tr>
			

				<tr>
            <td colspan="4">&nbsp;  </td>
		</tr>
	
	<?php /*?><tr>
            <td colspan="3">  <hr /> </td>
		</tr>
	
        
	
          <tr>
            <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:16px; text-transform:uppercase; font-weight:700;" align="center" >Nassa Group</td>
		</tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000;  font-size:12px; " align="center" >Head Office: 238, Tejgaon Industrial Area, Gulshan Link Road, Dhaka -1208.</td>
		</tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Phone: 
			  88-02- 8878543-49. Cell :- +88 01401140030</td>
          </tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Web: 
			 www.nassagroup.org</td>
          </tr><?php */?>
	</table>
	
<!--	<tr>
	  <td>&nbsp;</td>
	  </tr>
	<tr>
	  <td>&nbsp;</td>
	  </tr>
	<tr>-->
	  <td>&nbsp;</td>
	  </tr>
	<tr>
	  <td>&nbsp;</td>
	  </tr>
  </tbody>
</table>


</div>
<div class="brack">&nbsp;</div>




</body>
</html>
