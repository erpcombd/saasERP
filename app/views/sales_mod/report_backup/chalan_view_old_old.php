<?php

session_start();

//====================== EOF ===================

//var_dump($_SESSION);


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$chalan_no 		= $_REQUEST['v_no'];



$datas=find_all_field('lc_workorder_chalan','s','chalan_no='.$v_no);



$sql1="select d.*,b.*, sum(b.total_unit) as total_unit, d.total_unit as ord_unit, sum(b.total_amt) as total_amt, b.total_unit as item_ex, m.depot_id as depot, m.remarks,  m.mr_no, m.payment_by, m.cash_discount as cash_discountm

from sale_do_chalan b,sale_do_details d,  sale_do_master m 

where d.id=b.order_no and m.do_no=d.do_no and b.chalan_no = '".$chalan_no."' and (b.item_id!=1096000100010239 and b.item_id!=1096000100010312) group by b.order_no order by d.id";
//echo $sql1;
$data1=db_query($sql1);





$pi=0;

$total=0;

while($info=mysqli_fetch_object($data1)){ 

$pi++;

$depot_id=$info->depot;

$cash_discountm=$info->cash_discountm;

$remarks=$info->remarks;

$entry_time=$info->entry_time;

$chalan_date=$info->chalan_date;

$do_no=$info->do_no;

$payment_by=$info->payment_by;

$mr_no=$info->mr_no;


$item_ex[]=$info->item_ex;

$order_no[]=$info->order_no;

$store_sl=$info->driver_name; 

$driver_name=$info->driver_name_real;

$vehicle_no=$info->vehicle_no;

$delivery_man=$info->delivery_man;

$cash_discount=$info->cash_discount;

$del_ord[]=$info->ord_unit;

$undel_ord[]=$info->ord_unit - find_a_field('sale_do_chalan','sum(total_unit)','order_no='.$info->order_no);


$item_id[] = $info->item_id;

$unit_price[] = $info->unit_price;
$t_price[] = $info->t_price;
$pkt_size[] = $info->pkt_size;

$sps = find_a_field('item_info','sub_pack_size','item_id='.$info->item_id);

$sub_pkt_size[] = (($sps>1)?$sps:1);



$total_unit[] = $info->total_unit;

$pkt_unit[] = (int)($info->total_unit/$info->pkt_size);

$dist_unit[] = (int)($info->total_unit%$info->pkt_size);

$ord_unit[] = ($info->ord_unit);

$total_amt[] = $info->total_amt;



}

$entry_sql = 'select u.fname from user_activity_management u, sale_do_master b where u.user_id=b.entry_by and b.do_no='.$do_no;

$entry_by = find_all_field_sql($entry_sql);

$ssql = 'select a.* from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;

$dealer = find_all_field_sql($ssql);

$ssql = 'select b.* from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;

$do = find_all_field_sql($ssql);

$ssqld = 'select a.* from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;

$dd = find_all_field_sql($ssqld);


$dept = 'select warehouse_name from warehouse where warehouse_id='.$depot_id;

$deptt = find_all_field_sql($dept);


//if(isset($_POST['cash_discount']))

//{

//

//	$c_no = $_POST['c_no'];

//	$cash_discount = $_POST['cash_discount'];

//	$ssql='update sale_do_chalan set cash_discount="'.$_POST['cash_discount'].'" where chalan_no="'.$c_no.'"';

//	db_query($ssql);

//

//}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="bn">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>.: Delivery Chalan Bill Report :.</title>

<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>

<script type="text/javascript">

function hide()

{

    document.getElementById("pr").style.display="none";

}

</script>

<style type="text/css">

<!--

.style1 {color: #000000}

.style3 {

	font-size: 11px;

	font-weight: bold;

}

-->

</style>

</head>

<body style="font-family:Tahoma, Geneva, sans-serif"><br /><br /><br />

<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td><div class="header">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">

	  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

          



        </table></td>

	    </tr>

	  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

	  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td width="15%">

                

                <td><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">

                  <tr>

                    <td bgcolor="#00CC33" style="text-align:center; color:#FFF; font-size:14px; font-weight:bold;"><span class="style4"><span style="font-size:20px; color:#000000;">এম&sbquo; আহমেদ টি এন্ড ল্যান্ডস কোঃ লিঃ </span> <br />

                          <span class="style6" style="font-size:14px; color: #000000;  "><b>দরগাহ মহল্লা&sbquo; সিলেট।</b>  ফোন নং- ০৮২১-৭১৬৫৫২ <br />ঢাকা- ০২-৪৯৩৪৯৮৭৫&cedil; চট্টগ্রাম- ০৩১-৭১৩৬৩২<br /> <b>মূল্য সংযোজন কর নিবন্ধন নং- ২২০২১০১৩৫৮০ </b>  </span></span></td>

                  </tr>

                  <tr>

                    <td><div align="center"><strong>Delivery BILL (<?php echo $deptt->warehouse_name;?>)</strong></div></td>

                  </tr>

                </table>                

                <td width="25%"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">

                  <tr>

                    <td align="right" valign="middle"> Chalan Date</td>

                    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                        <tr>

                          <td><?=$chalan_date?>

                            &nbsp;</td>

                        </tr>

                    </table></td>

                  </tr>

                  <tr>

                    <td align="right" valign="middle">Chalan No: </td>

                    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                        <tr>

                          <td><strong><?php echo $chalan_no;?></strong></td>

                        </tr>

                    </table></td>

                  </tr>
				  
				  <tr>

                    <td align="right" valign="middle">DO No: </td>

                    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                        <tr>

                          <td><strong><?php echo $do_no;?></strong></td>

                        </tr>

                    </table></td>

                  </tr>



                </table>                

              </tr>

            </table></td>

          </tr>



        </table></td>

	    </tr>

	  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

		  <tr>

		    <td valign="top">

		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">

		        

                  <tr>

		          <td width="40%" align="right" valign="middle">Dealer Name: </td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

		            <tr>

		              <td><span style="font-size:16px; font-weight:bold;" class="style8"><?php echo ($dealer->dealer_name_b=='')?$dealer->dealer_name_e.'- '.$dealer->dealer_code.' ('.$dealer->team_name.')':$dealer->dealer_name_b.'- '.$dealer->dealer_code.' ('.$dealer->team_name.')';?>&nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>

		        <tr>

		          <td align="right" valign="top"> Address:</td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

		            <tr>

		              <td height="60" valign="top"><span style="font-size:16px; " class="style8"><?php echo ($dealer->address_b=='')?$dealer->address_e:$dealer->address_b;?>&nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>

		        

		        <tr>

                  <td align="right" valign="middle">Buyer Name:</td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                      <tr>

                        
						  <td><span style="font-size:16px; font-weight:bold;" class="style8"><?php echo ($dealer->propritor_name_b=='')?$dealer->propritor_name_e:$dealer->propritor_name_b;?>&nbsp;</span></td>
                      </tr>

                  </table></td>
		          </tr>

                  <tr>
                    <td align="right" valign="middle">Mobile:</td>
                    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                        <tr>
                          <td><span style="font-size:16px; font-weight:bold;" class="style8"><?php echo $dealer->mobile_no;?>&nbsp;</span></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>

		          <td width="40%" align="right" valign="middle">DO Date: </td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

		            <tr>
					
					<td><?php echo $do->do_date;?>&nbsp;</td>
					

		            <!--<td><?php echo date('Y-m-d',strtotime($entry_time));?>&nbsp;</td>-->
		              </tr>

		            </table></td>
		          </tr>
		        </table>		      </td>

			<td width="30%"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">

			<tr>

			    <td align="right" valign="middle">Payment By:</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

			      <tr>

			        <td><strong><?php echo $payment_by;?></strong>&nbsp;</td>
			        </tr>

			      </table></td>
			    </tr>
				
				<? if($mr_no>0){?>

			  <tr>

			    <td align="right" valign="middle">Money Rcv No:</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

			      <tr>

			        <td><?php echo $mr_no;?>&nbsp;</td>
			        </tr>

			      </table></td>
			    </tr>
				
				<? }?>


			  <tr>

			    <td align="right" valign="middle">Store Serial No:</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

			      <tr>

			        <td style="font-size:16px; font-weight:bold"><?php echo $store_sl;?>&nbsp;</td>
			        </tr>

			      </table></td>
			    </tr>

			  <tr>

                <td align="right" valign="middle">Vehicle No:</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td><?=$vehicle_no?>

                        &nbsp;</td>
                    </tr>

                </table></td>
			    </tr>

			  <tr>

                <td align="right" valign="middle">Driver Name: </td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td><?php echo $driver_name;?>&nbsp;</td>
                    </tr>

                </table></td>
			    </tr>

			  <tr>

			    <td align="right" valign="middle">Delivery Man:</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                  <tr>

                    <td><?php echo $delivery_man;?>&nbsp;</td>
                  </tr>

                </table></td>
			    </tr>

			  </table></td>

		  </tr>

		</table></td>

		  </tr>

		</table>		</td>

	  </tr>

    </table>

    </div></td>

  </tr>

  <tr>

    

	<td>	</td>

  </tr>

  

  <tr>

    <td>

      <div id="pr">

  <div align="left">

    <form id="form1" name="form1" method="post" action="">

      <table width="50%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>

          </tr>

      </table>

        </form>

    </div>

</div>

<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="2" style="font-size:13px;">

       

       <tr>

         <td align="center" bgcolor="#FFFFFF"><strong>SL</strong></td>

         <td align="center" bgcolor="#FFFFFF"><strong>Product Name</strong></td>

         <td align="center" bgcolor="#FFFFFF"><strong>NET PRICE </strong></td>

         <td align="center" bgcolor="#FFFFFF"><strong>Order Qty  </strong></td>

         <td align="center" bgcolor="#FFFFFF"><strong>Un Deliver Qty  </strong></td>

         <td align="center" bgcolor="#FFFFFF"><strong>Delivery Kg </strong></td>

         <td align="center" bgcolor="#FFFFFF"><strong>Payable Amt </strong></td>
       </tr>


<? for($i=0;$i<$pi;$i++){ 

$gift_o = find_all_field('sale_do_details','','gift_on_order="'.$order_no[$i].'"  and (item_id=1096000100010239 || item_id=1096000100010312)');

$gift_order  = $gift_o->id;



if($gift_order>0){

$gifts = 'select sum(total_unit) total_unit, unit_price from sale_do_chalan where order_no="'.$gift_order.'" and chalan_no = "'.$chalan_no.'"';

$giftq = db_query($gifts);

$gift = mysqli_fetch_object($giftq);



$per_pcs =  (-1)*(@(($gift->unit_price)/@($total_unit[$i]/$gift->total_unit)));

}

else

{

$gift = 0;

$per_pcs = 0;

}



$g=0;

$items = find_all_field('item_info','item_name','item_id='.$item_id[$i]);

$set = find_all_field('sales_corporate_price','discount','dealer_code="'.$dealer->dealer_code.'" and item_id="'.$item_id[$i].'"');

$fit_size = ($items->sub_pack_size>0)?$items->sub_pack_size:1;

?>

      <tr>

        <td align="center" valign="top"><?=$i+1?></td>

        <td align="left" valign="top"><? echo $items->item_name.'-'.$items->finish_goods_code; if($unit_price[$i]<1) echo ' <b>[Gift Item]</b>';?><?

		$gsql = 'select offer_name from sale_gift_offer g, sale_do_details d where g.id=d.gift_id and d.gift_on_order="'.$order_no[$i].'"';

		$gquery = db_query($gsql);

		while($qdata=mysqli_fetch_object($gquery)){if($g==0) echo '<b>  [Offer-'.$qdata->offer_name; else echo '/'.$qdata->offer_name; $g++; }

		if($g>0) echo ']</b>';?></td>

        <td align="right" valign="top"><?=number_format($unit_price[$i]*$fit_size,2);?></td> 

        <td align="right" valign="top"><?=number_format($ord_unit[$i],2);?></td>

        <td align="right" valign="top"><?=number_format($undel_ord[$i],2);?></td>


		<td align="right" valign="top"><? echo number_format($item_ex[$i],2);$tttttd = $tttttd + $item_ex[$i];?></td>

        <td align="right" valign="top"><? $ttt =($unit_price[$i]*$fit_size)*$item_ex[$i]; echo number_format($ttt,2); $tot = $tot + $ttt; ?></td>
        </tr>

<? }?>

      <tr style="border-bottom:#FFFFFF">

        <td colspan="5" align="center" valign="top"><div align="right"><strong>Total  </strong></div></td>

        <td align="center" valign="top"><div align="right"><strong>

          <?=$tttttd?>

        </strong></div></td>

        <td align="right" valign="top"><strong>

          <?=number_format($tot,2)?>

        </strong></td>
      </tr>

	  <?

	  $sd = $tot*$do->sp_discount;

	  if($sd>0){

	  ?><div align="right"><strong>Special Discount <?=$do->sp_discount?> %: </strong></div>

      <tr>

        <td colspan="6" align="center" valign="top"><div align="right"><strong>Total Amount : </strong></div></td>

        <td align="right" valign="top"><strong>

          <?=number_format((($sd)/100),2)?>

        </strong></td>
      </tr>

	  <? }if($cash_discountm>0){?>

      <tr>

        <td colspan="6" align="center" valign="top"><div align="right"><strong>Commission : <?= $cash_discountm?> %  </strong></div></td>

        <td align="right" valign="top"><strong>

          <?php $dis=number_format((($tot*$cash_discountm)/100),2); echo $dis;?>

        </strong></td>
      </tr>

	  <? }?>

      <tr>

        <td colspan="6" align="center" valign="top"><div align="right"><strong>Net Payable Amount : </strong></div></td>

        <td align="right" valign="top"><strong>

          <?=number_format($tot-(($tot*$cash_discountm)/100),2)?>

        </strong></td>
      </tr>
    </table></td>

  </tr>

  <tr>

    <td align="center">

    <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td colspan="2" style="font-size:10px"><em>N B : This is software generated bill, Signatiory is not required.&nbsp;&nbsp;||&nbsp;&nbsp;&nbsp;All goods are received in a good condition as per Terms </em> </td>

    </tr>
	
	
	
	


  <tr>

    <td width="50%"><?php if($remarks!=""){echo "<span style='font-size:18px'>NOTE: " .$remarks."</span>";}?></td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr>



    <td colspan="2" align="center"><div class="footer_left">

      <table width="100%" border="0" cellspacing="0" cellpadding="0">
 <br />
 <br />
        <tr>
          <td align="center" width="24%"><?php echo $entry_by->fname; ?>&nbsp;</td>
          <td align="center" width="20%">&nbsp;</td>
          <td align="center" width="20%">&nbsp;</td>
          <td align="center" width="18%">&nbsp;</td>
          <td align="center" width="18%">&nbsp;</td>
        </tr>
        <tr>

        
		   
		 <td width="20%"><div align="center"><hr width="90%"></hr>Prepared By </div></td>  
		   
          <td width="20%"><div align="center"><hr width="90%"></hr>Received By </div></td>

          <td width="20%"><div align="center"><hr width="90%"></hr>Store In-Charge </div></td>
			
          

          <td width="20%"><div align="center"><hr width="90%"></hr>Store Officer </div></td>
		  
		  <td width="20%"><div align="center"><hr width="90%"></hr>Driver</div></td>
        </tr>
      </table>

      </div>      <strong><br />

      </strong></td>

    </tr>

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

    </table>

    <div class="footer1"> </div>

    </td>

  </tr>

</table>

</body>

</html>

