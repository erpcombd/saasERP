<?php



session_start();



//====================== EOF ===================



//var_dump($_SESSION);



require "../../support/inc.all.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

$chalan_no 		= $_REQUEST['v_no'];


$challan= find_all_field('sale_do_chalan','','chalan_no='.$chalan_no);

$via_cust= find_all_field('customer_info','','customer_code='.$challan->via_customer);

$master2 = find_all_field('sale_do_master','','do_no='.$challan->do_no);

foreach($challan as $key=>$value){
$$key=$value;
}

 $ssql = 'select a.*,b.do_date, b.group_for,  b.customer_name, b.cash_discount from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;



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
<title>.: Sales Invoice :.</title>
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



-->



</style>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif; font-size: 14px;">
<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="2"><div class="header">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="30%">
                        <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$master2->group_for?>.png" width="100%" />						</td>
                        <td width="40%" align="center"><strong>
						<span style="font-size:16px; padding:0; margin:0;">
						<?=find_a_field('user_group','group_name','id='.$master2->group_for);?></span></strong></td>
                        <td width="30%"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:14px; color: #F00;">
                            <tr>
                              <td align="right" valign="middle"> Sale No : </td>
                              <td><table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="3">
                                  <tr>
                                    <td><strong><?php echo $do_no;?></strong></td>
                                  </tr>
                                </table></td>
                            </tr>
                            <tr>
                              <td align="right" valign="middle">Sale Date :  </td>
                              <td><table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="3">
                                  <tr>
                                    <td><strong><?php echo date('d-m-Y',strtotime($do_date));?></strong></td>
                                  </tr>
                                </table></td>
                            </tr>
							
							
							
							
                      </table>                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
  <tr>
    <td colspan="2" align="center">	</td>
  </tr>
  
  
  <tr>
    <td colspan="2">
		<tr>

          <td valign="top" style="padding: 10px;" width="50%">
		  
		  <table style="width: 100%;" border="1" cellpadding="0" cellspacing="0">
		  
		  <tr>
		    <td bgcolor="#E2E2E2" style=" text-align:center; font-size: 16px; border: 1px solid black;"><strong>Customer</strong></td>
		  </tr>
		  <tr><td valign="top" align="center" style="height: 90px; border: 1px solid black; padding: 10px; font-size: 14px;"><span class="style2">
		   <strong> <?=$dealer->dealer_name_e;?></strong><br />
			
			<?
	if($dealer->customer_name!==""){?>
	
			<strong>Customer Name: <?=$dealer->customer_name?></strong>
	 <? }  ?>
			
			
		  </span></td>
		  </tr>
		  </table>		 </td>

          <td valign="top"  style="padding: 10px;" width="50%">
		  
		  <table style="width: 100%;" border="1" cellpadding="0" cellspacing="0">
		  
		  <tr>
		    <td colspan="2" bgcolor="#E2E2E2" style=" text-align:center; font-size: 16px; border: 1px solid black;"><strong>Sales Rep </strong></td>
		  </tr>
		  <tr>
		    <td width="40%" valign="top" style=" border: 1px solid black; padding: 5px; font-size: 13px;"><strong>DATE:</strong></td>
		    <td width="60%" valign="top" style=" border: 1px solid black; padding: 5px; font-size: 13px;"><span class="style1">
	        <?=$chalan_date?>
		    </span></td>
		  </tr>
		  <tr>
		    <td valign="top" style="border: 1px solid black; padding: 5px; font-size: 13px;"><strong>DO NO: </strong></td>
		    <td valign="top" style=" border: 1px solid black; padding: 5px; font-size: 13px;"><strong><?php echo $do_no;?></strong></strong></td>
		  </tr>
		  <tr>
		    <td valign="top" style="border: 1px solid black; padding: 5px; font-size: 13px;"><strong>Invoice  No: </strong></td>
		    <td valign="top" style="border: 1px solid black; padding: 5px; font-size: 13px;"><strong><?php echo $chalan_no;?></strong></td>
		  </tr>
		  
		  <tr>
		    <td valign="top" style="border: 1px solid black; padding: 5px; font-size: 13px;"><strong>Store  No: </strong></td>
		    <td valign="top" style="border: 1px solid black; padding: 5px; font-size: 13px;"><strong><?php echo $master2->store_issue_no;?></strong></td>
		  </tr>
		  </table>		  </td>
        </tr>
	
	</td>
  </tr>
  
  
  
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  

  
  <?
	if($dealer->customer_name!==""){?>
  
  
  <? }  ?>
  
  <tr>
    <td colspan="2"><div id="pr">
        <div align="left">
          <p>
            <input name="button" type="button" onclick="hide();window.print();" value="Print" />
          </p>
          <nobr>
          <!--<a href="chalan_bill_view.php?v_no=<?=$_REQUEST['v_no']?>">Bill</a>&nbsp;&nbsp;--><!--<a href="do_view.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank"><span style="display:inline-block; font-size:14px; color: #0033FF;">Bill Copy</span></a>-->
          </nobr>
		  <nobr>
          
          <!--<a href="chalan_bill_distributor_vat_copy.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank">Vat Copy</a>-->
          </nobr></div>
      </div>
      <div style="min-height:auto;">
      <table width="100%" class="tabledesign" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="2" style="font-size:14px;">
        <tr>
          <td width="8%" align="center" bordercolor="#000000" bgcolor="#99B4D1"><strong>SL</strong></td>
          <td width="37%" align="center" bordercolor="#000000" bgcolor="#99B4D1"><strong>Description </strong></td>
          <td width="15%" align="center" bordercolor="#000000" bgcolor="#99B4D1"><strong>Qty</strong></td>
          <td width="12%" align="center" bordercolor="#000000" bgcolor="#99B4D1"><strong>Price</strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#99B4D1"><strong>Per</strong></td>
          <td width="18%" align="center" bordercolor="#000000" bgcolor="#99B4D1"><strong>Amount</strong></td>
        </tr>
        
        <? $sqlc = 'select c.id, sum(c.dist_unit) dist_unit, c.unit_price, i.unit_name, sum(c.pkt_unit) pkt_unit,  sum(c.cash_discount) as cash_discount, sum(c.total_amt) as total_amt, i.item_id, i.item_name, i.finish_goods_code, s.sub_group_name, i.item_description from sale_do_chalan c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and g.group_id not in (900000000) and c.chalan_no='.$chalan_no.' group by c.id order by c.id asc';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			$details= find_all_field('sale_do_chalan','','id='.$datac->order_no);
			
			
			?>
        <tr style="font-size:16px;">
          <td align="center" valign="top"><?=++$kk;?></td>
          <td align="left" valign="top"><?=$datac->item_name; if($datac->unit_price<1) echo ' <b>[Gift Item]</b>';?></td>
          <td align="center" valign="top"><?=(substr($datac->item_id,0,1)==9)?'':$datac->dist_unit; $tot_qty +=(substr($datac->item_id,0,1)==9)?'':$datac->dist_unit;?></td>
          <td align="center" valign="top"><?=number_format($datac->unit_price,2);?></td>
          <td align="center" valign="top"><?=$datac->unit_name;?></td>
          <td align="center" valign="top"><?=number_format($datac->total_amt+$datac->cash_discount,2); $grand_tot_amt1 +=($datac->total_amt+$datac->cash_discount);?></td>
        </tr>
        
        <? }
		
		?>
        <tr style="font-size:16px;">
        <td colspan="2" align="right" valign="middle"><strong>Order Total:</strong></td>
        <td align="center" valign="middle"><strong><?=number_format($tot_qty,2) ;?></strong></td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle"><strong>
          <?=number_format($grand_tot_amt1,2) ;?>
        </strong></td>
        </tr>
		<tr style="font-size:14px;">
        <td colspan="5" align="right" valign="middle"><strong>Cash Discount 
				<? if ($master2->sp_discount>0) {?>(<?=$master2->sp_discount;?> %)<? }?>:</strong> </td>
        <td align="center" valign="middle"><strong>
          <?=number_format($dealer->cash_discount,2) ;?>
        </strong></td>
        </tr>
		
		<tr style="font-size:14px;">
        <td colspan="5" align="right" valign="middle"><strong>Grand Total :</strong> </td>
        <td align="center" valign="middle"><strong>
          <?=number_format($grand_total = $grand_tot_amt1-$dealer->cash_discount,2) ;?>
        </strong></td>
        </tr>
		
		<tr style="font-size:14px;">
        <td colspan="5" align="right" valign="middle"><strong>VAT 
		<? if ($master2->vat>0) {?>(<?=$master2->vat;?> %)<? }?> :</strong> </td>
        <td align="center" valign="middle"><strong>
          <?=number_format($vat_amt = $grand_total*$master2->vat/100,2) ;?>
        </strong></td>
        </tr>
		
		
		<tr style="font-size:14px;">
        <td colspan="5" align="right" valign="middle"><strong>Total Receivable :</strong> </td>
        <td align="center" valign="middle"><strong>
          <?=number_format($total_receivable = $grand_total+$vat_amt,2) ;?>
        </strong></td>
        </tr>
      </table>
      </div>	  	    </td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      
      <div align="center">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="4" style="font-size:10px">&nbsp;</td>
          </tr>
		  <tr>
            <td colspan="4" style="font-size:10px">&nbsp;</td>
          </tr>
		  
		  <tr>
            <td colspan="4" style="font-size:10px">&nbsp;</td>
          </tr>
		  
          <?php /*?><tr>
            <td colspan="2" style="font-size:10px"><span style="font-size:16px">Payment Method :
                <strong><?=find_a_field('payment_method','payment_type','id='.$master2->debit_head);?></strong>
               
            </span></td>
          </tr><?php */?>
		  
          <tr>
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr>
            <td width="100%" colspan="3"><span style="font-size:12px"><strong>Amount in Word : (
               SR
				
				 <?



		$scs =  $aatotal = number_format($total_receivable,2,'.','');

			 $amt = explode('.',$scs);

	 if($amt[0]>0){

	 

	 echo convertNumberToWordsForIndia($amt[0]);}

	 if($amt[1]>0){

	 if($amt[1]<10) $amt[1] = $amt[1]*10;

	 echo  ' & '.convertNumberToWordsForIndia($amt[1]).' Halala ';}

	 echo ' Only';

		?>
				
				
				</strong>
) </span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="center">&nbsp;</td>
          </tr>
          
             <tr>
            <td colspan="4"  align="center" >&nbsp;</td>
          </tr>
		     <tr>
		       <td colspan="4"  align="center" >&nbsp;</td>
          </tr>
	         <tr>
	           <td  align="center" ><?=find_a_field('user_activity_management','fname','user_id='.$master2->entry_by);?></td>
	           <td  align="center" >&nbsp;</td>
	           <td  align="center" >&nbsp;</td>
	           <td  align="center" >&nbsp;</td>
          </tr>
	         <tr>
	           <td  align="center" >-------------------------------</td>
	           <td  align="center" >&nbsp;</td>
	           <td  align="center" >-------------------------------</td>
	           <td  align="center" >&nbsp;</td>
          </tr>
           <tr>
            <td  align="center" ><strong>Preapred by</strong></td>
            <td  align="center" >&nbsp;</td>
            <td  align="center" ><strong>Checked by</strong></td>
            <td  align="center" >&nbsp;</td>
          </tr>
            
            
            
          <tr>
            <td colspan="4"  align="center" >&nbsp;</td>
          </tr>
        </table>
    </div>      <div class="footer1"> </div></td>
  </tr>
</table>
</body>
</html>
