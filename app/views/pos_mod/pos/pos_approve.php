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


$dept = 'select warehouse_name from warehouse where warehouse_id='.$dept;



$deptt = find_all_field_sql($dept);

$to_ctn = find_a_field('sale_do_chalan','sum(pkt_unit)','chalan_no='.$chalan_no);

$to_pcs = find_a_field('sale_do_chalan','sum(dist_unit)','chalan_no='.$chalan_no); 



$ordered_total_ctn = find_a_field('sale_do_details','sum(pkt_unit)','dist_unit = 0 and do_no='.$do_no);

$ordered_total_pcs = find_a_field('sale_do_details','sum(dist_unit)','do_no='.$do_no); 

if(isset($_POST['approve'])){
        $jv_no=next_journal_sec_voucher_id();
        $jv_date = $master->pos_date;
        $proj_id = 'clouderp'; 
        $group_for =  $_SESSION['user']['group'];
        $cc_code = '1';
        $tr_no = $pos_id;
        $tr_from = 'PosSales';
        $narration = 'PosSales#'.$tr_no;
		
		$cash_ledger = 403000100000000;
		$config_ledger = find_all_field('config_group_class','','group_for="'.$group_for.'"');
		$credit_ledger = $config_ledger->pos_receivable;
		$pos_sales_ledger =$config_ledger->pos_sales;
		$vat_ledger =$config_ledger->sales_vat;
		$sales_discount_ledger =$config_ledger->sales_discount; 
		$cogs_ledger =$config_ledger->cogs_ledger;
		
		
$sql = 'select m.pos_id,m.pos_date,s.qty,s.rate,p.total_amt as pos_amt,s.discount_amt,p.paid_amt,i.item_name,d.dealer_name,sub.ledger_id_2,i.product_type,i.item_id,s.serial_no,s.warehouse_id from sale_pos_master m left join dealer_pos d on d.dealer_code=m.dealer_id left join pos_payment p on p.pos_id=m.pos_id, sale_pos_details s, item_info i, item_sub_group sub where s.item_id=i.item_id and i.sub_group_id=sub.sub_group_id and m.pos_id=s.pos_id and m.status="CHECKED" and m.pos_id="'.$pos_id.'"';
$qry = mysql_query($sql);
while($data=mysql_fetch_object($qry)){


if($data->product_type=='Serialized'){
	$avg_rate = find_a_field('journal_item','final_price','tr_from in ("Purchase","Import","Transfered","Opening","SampleIssue","SampleReturn") and item_id="'.$data->item_id.'" and serial_no="'.$data->serial_no.'" and item_in>0 and warehouse_id="'.$data->warehouse_id.'"');
	}elseif($data->product_type=='Non-serialized'){
$total_item_price = find_a_field('journal_item','sum(item_in*item_price)','item_id="'.$data->item_id.'"  and item_in>0 and warehouse_id="'.$data->warehouse_id.'"');
$total_in = find_a_field('journal_item','sum(item_in)','item_id="'.$data->item_id.'" and warehouse_id="'.$data->warehouse_id.'"');
$avg_rate = $total_item_price/$total_in;
}

$cogs_amt = $data->qty*$avg_rate;
$item_amount = $data->qty*$data->rate;
$total_amt  += $item_amount;
$total_paid +=$data->paid_amt;
$discount +=$data->discount_amt;
add_to_sec_journal($proj_id, $jv_no, $jv_date, $data->ledger_id_2, $narration, '0',$cogs_amt,  $tr_from, $tr_no,'',$tr_id,$cc_code,$group_for);
add_to_sec_journal($proj_id, $jv_no, $jv_date, $cogs_ledger, $narration, $cogs_amt, '0', $tr_from, $tr_no,'',$tr_id,$cc_code,$group_for);
}
$vat_amt = ($total_amt*$master->vat_percent)/100;
$total_receivable_amt = ($total_amt+$vat_amt)-($discount+$master->register_discount);
add_to_sec_journal($proj_id, $jv_no, $jv_date, $pos_sales_ledger, $narration, '0', $total_amt, $tr_from, $tr_no,'',$tr_id=0,$cc_code,$group_for);
add_to_sec_journal($proj_id, $jv_no, $jv_date, $vat_ledger, $narration, '0', $vat_amt, $tr_from, $tr_no,'',$tr_id=0,$cc_code,$group_for);
add_to_sec_journal($proj_id, $jv_no, $jv_date, $sales_discount_ledger, $narration, $discount+$master->register_discount,'0', $tr_from, $tr_no,'',$tr_id=0,$cc_code,$group_for);
add_to_sec_journal($proj_id, $jv_no, $jv_date, $credit_ledger, $narration, $total_receivable_amt,'0', $tr_from, $tr_no,'',$tr_id=0,$cc_code,$group_for);
if($total_paid>0){
add_to_sec_journal($proj_id, $jv_no, $jv_date, $cash_ledger, $narration, $total_receivable_amt,'0', $tr_from, $tr_no,'',$tr_id=0,$cc_code,$group_for);
add_to_sec_journal($proj_id, $jv_no, $jv_date, $credit_ledger, $narration, '0',$total_receivable_amt, $tr_from, $tr_no,'',$tr_id=0,$cc_code,$group_for);
}
sec_journal_journal($jv_no,$jv,$tr_from);
$up = mysql_query('update sale_pos_master set status="COMPLETED" where pos_id="'.$pos_id.'"');
echo '<script>window.close()</script>';
}
$wh_info = find_all_field('warehouse','','warehouse_id="'.$master->warehouse_id.'"');
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
                        
                        <td width="60%"><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                            <tr>
                              <td style="text-align:center; color:#000; font-size:14px; font-weight:bold;">
						
								<p style="font-size:18px; color:#000000; margin:0; padding: 0 0 5px 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"><img src="../../../logo/whitelogo.png"/></p>
								<p style="font-size:14px; font-weight:300; color:#000000; margin:0; padding:0;"><?=$wh_info->address?></p>
								<p style="font-size:12px; font-weight:300; color:#000000; margin:0; padding:0;">Phon No. : <?=$wh_info->contact_no?>,  Email : <?=$wh_info->email?></p>                              </td>
                            </tr>
                            <tr>


        <!--<td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">WORK ORDER </td>-->
      </tr>
                          </table>
                        <td width="20%"> 
						
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					
					<tr>
					  
					  <td align="center"><h4 style="font-size:16px;"></h4></td>
					  </tr>
                      
					  
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
  
  	<tr height="30">
  	  <td width="25%" valign="top"></td>
  	  <td width="50%"  style="text-align:center; color:#FFF; font-size:18px; padding:0px 0px 10px 0px; color:#000000; font-weight:bold;"><span style="text-decoration:underline">POS SALES </span> </td>
  	  <td width="25%" align="right" valign="right">&nbsp;</td>
	  </tr>
  </table>
  
  </td></tr>
  
  
  <tr> <td>&nbsp;</td></tr>
  
  
  
 <tr> <td><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="100%" valign="top">


		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:12px">


		        <tr>
		          <td width="13%" align="left" valign="middle" style="font-size:12px; font-weight:700;">Customer Name</td>
		          <td width="30%" style="font-size:12px; font-weight:700;">:	&nbsp;
		            <?= find_a_field('dealer_pos','dealer_name','dealer_code="'.$master->dealer_id.'"');?></td>
	              </tr>
		        <tr>
		          <td align="left" valign="middle">Address</td>
		          <td>:	&nbsp;
		            <?= find_a_field('dealer_pos','address_e','dealer_code="'.$master->dealer_id.'"');?></td>
	              </tr>
		        
		          <td align="left" valign="middle">Mobile No </td>
		          <td>:	&nbsp;
	              <?= find_a_field('dealer_pos','contact_no','dealer_code="'.$master->dealer_id.'"');?></td>
	              </tr>
				  <tr>
		          <td align="left" valign="middle">Sales Person</td>
		          <td>:	&nbsp;
                    <?= find_a_field('personnel_basic_info','PBI_NAME','PBI_CODE="'.$master->sales_person.'"');?></td>
	              </tr>
		        <tr>
		        
		        <tr>
		          <td align="left" valign="middle">&nbsp;</td>
		          <td>&nbsp;</td>
		          </tr>
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
          <th width="9%" bgcolor="#CCCCCC">Item Code </th>
          <th width="37%" bgcolor="#CCCCCC">Item Description </th>
          <th width="9%" bgcolor="#CCCCCC">Unit</th>
          <th width="10%" bgcolor="#CCCCCC">Quantity</th>
          <th width="10%" bgcolor="#CCCCCC">U-Price</th>
          <th width="21%" bgcolor="#CCCCCC">Amount</th>
        </tr>
        <? 

   
$res='select  item_id,rate, sum(qty) as total_unit,sum(total_amt) as total_amt,discount_amt

 from sale_pos_details 
 
 WHERE pos_id='.$pos_id.' group by id';
   
   $i=1;

$query = mysql_query($res);

while($data=mysql_fetch_object($query)){
$item_amt = $data->rate*$data->total_unit;
$total_amt +=$item_amt;
$item_discount +=$data->discount_amt; 
?>
        <tr>
          <td><?=$i++?></td>
          <td><?=$data->item_id?></td>
          <td><?=find_a_field('item_info','item_name','item_id="'.$data->item_id.'"')?></td>
          <td><?=find_a_field('item_info','unit_name','item_id="'.$data->item_id.'"')?></td>
          <td><?=$data->total_unit?></td>
          <td><?=$data->rate?></td>
          <td><?=$item_amt?></td>
        </tr>
        <?
		 }
		$total_discount = $item_discount+$master->register_discount;
		?>
		
		<tr>
          <td colspan="6"><div align="right"><strong>Item Total:</strong></div></td>
		  <td><strong><?=number_format($total_amt,3);?></td>
        </tr>
		
		<tr>
          <td colspan="6"><div align="right"><strong>Discount:</strong></div></td>
		  <td><strong><?=number_format($total_discount,3);?></td>
        </tr>
		
		<tr>
          <td colspan="6"><div align="right"><strong>Vat <?=$master->vat_percent?> %:</strong></div></td>
		  <td><strong><?=number_format(($vat=$total_amt*$master->vat_percent/100),3);?></strong></td>
        </tr>
		
		<tr>
          <td colspan="6"><div align="right"><strong>Total Payable:</strong></div></td>
		  <td><strong><?=number_format(($total_amt+$vat)-$total_discount,3);?></td>
        </tr>
       
        <tr style="font-size:16px; font-weight:500; letter-spacing:.3px;">
          <td colspan="7">In Word:
            <?

		

		$scs =  $grand_total;

			 $credit_amt = explode('.',$scs);

	 if($credit_amt[0]>0){

	 

	 echo convertNumberToWordsForIndia($credit_amt[0]);}

	 if($credit_amt[1]>0){

	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;

	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa ';}

	 echo ' Only';

		?>. </td>
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
		   
		
		<?
		  if($master->status=="CHECKED"){
		?>
		<tr style="font-size:12px">
		<form name="" method="post">
            <td align="center" colspan="2"><input type="button" name="close" id="close" value="Close" class="btn btn-warning" onclick="window.close()"  style="height: 30px;width: 125px;background:darkorange;border: 0px;font-size: 16px;color: #fff;" /></td>
			 
		   
		    <td  align="center" colspan="2"><input type="submit" name="approve" id="approve" value="Approve" class="btn btn-primary" style="height: 30px;width: 125px;background:cornflowerblue;border: 0px;font-size: 16px;color: #fff;" /></td>
			</form>
		    </tr>
			<? }else{ ?>
			 <tr>
			   <td colspan="4" align="center" style="font-size:20px; color:green;">Already Approved</td>
			 </tr>
			<? } ?>
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
