<?php



session_start();



//====================== EOF ===================



//var_dump($_SESSION);




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

$pos_id 		= $_REQUEST['v_no'];

$group_data = find_all_field('user_group','group_name','id='.$_SESSION['user']['group']);


$destination_count= find_a_field('sale_do_chalan','COUNT(destination)','chalan_no="'.$chalan_no.'" and destination!=""');
$referance_count= find_a_field('sale_do_chalan','COUNT(referance)','chalan_no="'.$chalan_no.'" and referance!=""');
$sku_no_count= find_a_field('sale_do_chalan','COUNT(sku_no)','chalan_no="'.$chalan_no.'" and sku_no!=""');
$pack_type_count= find_a_field('sale_do_chalan','COUNT(pack_type)','chalan_no="'.$chalan_no.'" and pack_type!=""');
$color_count= find_a_field('sale_do_chalan','COUNT(color)','chalan_no="'.$chalan_no.'" and color!=""');
$size_count= find_a_field('sale_do_chalan','COUNT(size)','chalan_no="'.$chalan_no.'" and size!=""');



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

$ssql = 'select a.*,b.do_date, b.group_for, b.via_customer from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;



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
		$cash_ledger = 1021000001;
		$dealer_ledger = find_a_field('dealer_info','account_code','dealer_code="'.$master->dealer_id.'"');
		if($dealer_ledger>0){
		$credit_ledger = $dealer_ledger;
		}else{
		$credit_ledger = find_a_field('config_group_class','posLedger','group_for="'.$group_for.'"');
		}
		
$sql = 'select m.pos_id,m.pos_date,s.qty,s.rate,p.total_amt as pos_amt,s.discount,p.paid_amt,i.item_name,d.dealer_name_e,sub.ledger_id_2 from sale_pos_master m left join dealer_info d on d.dealer_code=m.dealer_id left join pos_payment p on p.pos_id=m.pos_id, sale_pos_details s, item_info i, item_sub_group sub where s.item_id=i.item_id and i.sub_group_id=sub.sub_group_id and m.pos_id=s.pos_id and m.status="CHECKED" and m.pos_id="'.$pos_id.'"';
$qry = db_query($sql);
while($data=mysqli_fetch_object($qry)){
$total_amt +=$data->pos_amt;
$total_paid +=$data->paid_amt;
add_to_sec_journal($proj_id, $jv_no, $jv_date, $data->ledger_id_2, $narration, '0',$data->pos_amt,  $tr_from, $tr_no,'',$tr_id,$cc_code,$group_for);
}
add_to_sec_journal($proj_id, $jv_no, $jv_date, $credit_ledger, $narration, $total_amt,'0', $tr_from, $tr_no,'',$tr_id=0,$cc_code,$group_for);
if($total_paid>0){
 add_to_sec_journal($proj_id, $jv_no, $jv_date, $cash_ledger, $narration, $total_paid,'0', $tr_from, $tr_no,'',$tr_id=0,$cc_code,$group_for);
 add_to_sec_journal($proj_id, $jv_no, $jv_date, $credit_ledger, $narration, '0',$total_paid, $tr_from, $tr_no,'',$tr_id=0,$cc_code,$group_for);
}
$up = db_query('update sale_pos_master set status="COMPLETED" where pos_id="'.$pos_id.'"');
echo '<script>window.close()</script>';
}

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

</style>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif; font-size: 10px;">



<div id="pr">
    <h2 align="center">	<input name="button" type="button" onclick="hide();window.print();" value="Print"/></h2>
</div>


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
                        <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" style=" width:100%" />
                        <td width="60%"><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                            <tr>
                              <td style="text-align:center; color:#000; font-size:14px; font-weight:bold;">
						
								<h1 style="margin: 0px;" ><?=$group_data->group_name?></h1>
								<p style="font-size:14px; font-weight:300; color:#000000; margin:0; padding:0;"><?=$group_data->address?></p>
								<p style="font-size:12px; font-weight:300; color:#000000; margin:0; padding:0;"><strong>Phon No. :</strong>  <?=$group_data->mobile?>,  <strong>Email : </strong><?=$group_data->email?></p>  </td>
                            </tr>
                            <tr>


        <!--<td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">WORK ORDER </td>-->
      </tr>
                          </table>
                        <td width="20%"> 
						
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					
					<tr>
					  
					  <td align="center"><h4 style="font-size:16px;">Customer's Copy</h4></td>
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
		          <td width="4%" align="left" valign="middle" style="font-size:12px; font-weight:700;">Customer Name</td>
		          <td width="30%" style="font-size:12px; font-weight:700;">:	&nbsp;
		            <?= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$master->dealer_id.'"');?></td>
	              </tr>
		        <tr>
		          <td align="left" valign="middle"><strong>Address</strong></td>
		          <td>:	&nbsp;
		            <?= find_a_field('dealer_info','address_e','dealer_code="'.$master->dealer_id.'"');?></td>
	              </tr>
		        <tr>
		          <td align="left" valign="middle"><strong>Contact Person</strong></td>
		          <td>:	&nbsp;
                    <?= find_a_field('dealer_info','contact_person_name','dealer_code="'.$master->dealer_id.'"');?></td>
	              </tr>
		        <tr>
		          <td align="left" valign="middle"><strong>Mobile No</strong> </td>
		          <td>:	&nbsp;
	              <?= find_a_field('dealer_info','contact_no','dealer_code="'.$master->dealer_id.'"');?></td>
	              </tr>
		        
		        <tr>
		          <td align="left" valign="middle">&nbsp;</td>
		          <td>&nbsp;</td>
		          </tr>
		        </table>
            </td>
		  </tr>


		</table>		</td></tr>
  
  
 
  <tr>
    <td><div id="pr">
        <div align="left">
<!--          <p>-->
<!--            <input name="button" type="button" onclick="hide();window.print();" value="Print" />-->
<!--          </p>-->
          <nobr>
          <!--<a href="chalan_bill_view.php?v_no=<?=$_REQUEST['v_no']?>">Bill</a>&nbsp;&nbsp;--><!--<a href="do_view.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank"><span style="display:inline-block; font-size:14px; color: #0033FF;">Bill Copy</span></a>-->
          </nobr>
		  <nobr>
          
          <!--<a href="chalan_bill_distributor_vat_copy.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank">Vat Copy</a>-->
          </nobr>	    </div>
      </div>
      
      <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#000000" class="tabledesign"  style="font-size:12px">
        <tr bgcolor="#ffc559">
          <th width="4%" >SL</th>
          <th width="9%" >Item Code </th>
          <th width="37%">Item Description </th>
          <th width="9%" >Unit</th>
          <th width="10%">Quantity</th>
          <th width="10%">U-Price</th>
          <th width="21%">Amount</th>
        </tr>
        <? 

   
$res='select  item_id,rate, sum(qty) as total_unit,sum(total_amt) as total_amt

 from sale_pos_details 
 
 WHERE pos_id='.$pos_id.' group by id';
   
   $i=1;

$query = db_query($res);

while($data=mysqli_fetch_object($query)){

?>
        <tr>
          <td><?=$i++?></td>
          <td><?=$data->item_id?></td>
          <td><?=find_a_field('item_info','item_name','item_id="'.$data->item_id.'"')?></td>
          <td><?=find_a_field('item_info','unit_name','item_id="'.$data->item_id.'"')?></td>
          <td><?=$data->total_unit?></td>
          <td><?=$data->rate?></td>
          <td><?=$data->total_amt?></td>
        </tr>
        <?
		
$total_quantity = $total_quantity + $data->total_unit;
$total_bag_size = $total_bag_size + $data->bag_size;

$total_amount = $total_amount + $data->total_amt;

		 }
		
		?>
        <tr bgcolor="#ffff67">
          <td colspan="3"><div align="right"><strong>Total:</strong></div></td>
          <td>&nbsp;</td>
          <td><strong>
            <?=number_format($total_quantity,0);?>
          </strong></td>
          <td></td>
          <td><strong>
              <?=number_format($total_amount,3);?></td>
        </tr>
        <?php if($master->discount>0){ ?>
        <tr>
          <td colspan="6"><div align="right"><strong>Discount(
            <?=$master->discount?>
            %):</strong></div></td>
          <td><strong>
            <?=number_format($nit_discount=$master->discount/100*$total_amount,2);?>
            <? $tot_amt_after_discount = $total_amount-$nit_discount; ?>
          </strong></td>
        </tr>
        <tr>
          <td colspan="6"><div align="right"><strong>VAT(
                  <?=$master->vat?>
            %):</strong></div></td>
          <td><strong>
            <?=number_format($nit_vat=$master->vat/100*$tot_amt_after_discount,2);?>
          </strong></td>
        </tr>
        <?php } ?>
        <?php if($ch_data->transport_cost>0){ ?>
        <tr >
          <td colspan="6"><div align="right"><strong>Transport Cost:</strong></div></td>
          <td><strong>
            <?=number_format($trans_cost=$ch_data->transport_cost,2);?>
          </strong></td>
        </tr>
        <?php } ?>
        <?php

$grand_total=($total_amount-$nit_discount)+$nit_vat+$ch_data->transport_cost;
?>
        <tr bgcolor="#98ffdc">
          <td colspan="6"><div align="right"><strong> Grand Total:</strong></div></td>
          <td><strong>
            <?=number_format($grand_total,2);?>
          </strong></td>
        </tr>
        <?php /*?><tr>
          <td colspan="6"><div align="right"><strong>Last Closing Balance:</strong></div></td>
          <?
$dealer_codes=find_a_field('dealer_info','account_code','dealer_code="'.$master->dealer_code.'"');


$jv_id=find_a_field('journal','jv_no','tr_no="'.$ch_data->chalan_no.'" and tr_from="Sales"');

$c_b=find_a_field('journal','sum(dr_amt-cr_amt)','jv_no < "'.$jv_id.'" and ledger_id="'.$dealer_codes.'"'); //jjv_date < "'.$ch_data->chalan_date.'" and change by kamrul 18-01-22



 $total_pay=$grand_total+$c_b;
		
		?>
          <td><strong>
            <? if($c_b > 0 ) { echo number_format($c_b,2)." Dr"; } elseif ($c_b < 0 ) { echo number_format(($c_b * (-1)),2)." Cr";  } else echo"0.00";  ?>
          </strong></td>
        </tr>
        <tr>
          <td colspan="6"><div align="right"><strong>Receivable Amount:</strong></div></td>
          <td><strong>
            <? if($total_pay > 0 ) { echo number_format($total_pay,2)." Dr"; } else { echo number_format(($total_pay * (-1)),2)." Cr";  }  ?>
          </strong></td>
        </tr><?php */?>
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
		   <tr>
		  <td align="center" ><?php
		  
		 $ucid=find_a_field('sale_do_master','entry_by','do_no="'.$do_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$ucid.'"')?></td>
		  <td align="center">
		 <?php
		  
		 $uid=find_a_field('sale_do_chalan','entry_by','chalan_no="'.$chalan_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?>		  </td>
		  <td align="center">
		   <?php
		  
		 $euid=find_a_field('sale_do_chalan','checked_by','chalan_no="'.$chalan_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$euid.'"')?>		  </td>
		  <td align="center"> <?php
		  
		 $uid=find_a_field('secondary_journal','checked_by','tr_from="Sales" and tr_no="'.$chalan_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?></td>
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
