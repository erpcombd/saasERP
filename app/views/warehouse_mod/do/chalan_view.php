<?php

session_start();

//====================== EOF ===================

//var_dump($_SESSION);


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$chalan_no 		= $_REQUEST['v_no'];





$datas=find_all_field('sale_do_chalan','s','chalan_no='.$chalan_no);



$sql1="select b.* from sale_do_details b where b.do_no = '".$datas->do_no."' order by id";

$data1=db_query($sql1);

$pi=0;

$total=0;

while($infos=mysqli_fetch_object($data1)){ 

$entry_time=$infos->entry_time;

	$pi++;

	$sqlc = 'select sum(total_unit) total_unit,driver_name,entry_by,driver_name_real,vehicle_no,delivery_man,chalan_date from sale_do_chalan where chalan_no='.$chalan_no.' and order_no='.$infos->id;

	$queryc=db_query($sqlc);

	$info = mysqli_fetch_object($queryc);

	//$info=find_all_field('sale_do_chalan','s','chalan_no='.$chalan_no.' and order_no='.$infos->id);

	

	

	$do_no=$infos->do_no;
	
	$dept=$infos->depot_id;

	$item_id[] = $infos->item_id;

	$unit_price[] = $infos->unit_price;

	$pkt_size[] = $infos->pkt_size;

	$item = find_all_field('item_info','mhafuz','item_id='.$infos->item_id);

	$item_name[] = $item->item_name;

	$sps[] = $item->sub_pack_size;

	$fgc[] = $item->finish_goods_code;

	$order_total_qty[] = $infos->total_unit;

	$sub_pkt_size[] = (($item->sub_pack_size>1)?$item->sub_pack_size:1);

	

//$pkt_unit[] = $info->pkt_unit;

//$dist_unit[] = $info->dist_unit;

$pkt_unit[] = ($info->total_unit/$infos->pkt_size);

$dist_unit[] = (int)($info->total_unit%$infos->pkt_size);

$total_unit[] = $info->total_unit;

$order_no[]=$infos->id;

$gift_on_order[] = $infos->gift_on_order;

if($info->total_unit>0){

$chalan_date=$info->chalan_date;



$driver_name=$info->driver_name;

$entry_by=$info->entry_by;

$driver_name_real=$info->driver_name_real;

$vehicle_no=$info->vehicle_no;

$delivery_man=$info->delivery_man;

}

}

$ssql = 'select a.*,b.do_date from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;

$dealer = find_all_field_sql($ssql);

$dept = 'select warehouse_name from warehouse where warehouse_id='.$dept;

$deptt = find_all_field_sql($dept);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="bn">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>.: Challan Copy :.</title>

<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>

<script type="text/javascript">

function hide()

{

    document.getElementById("pr").style.display="none";

}

</script>

<style type="text/css">

<!--

.style4 {

	font-size: 18px;

	color: #000000;

}

.style6 {font-size: 10px}

.style8 {font-size: 16px; font-weight:bold}

.style9 {font-size: 12px}

-->

</style>

</head>

<body style="font-family:Tahoma, Geneva, sans-serif">

<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td><div class="header">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">

	  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td width="15%">

                

                <td><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">

                  <tr>

                    <td bgcolor="#00CC33" style="text-align:center; color:#FFF; font-size:14px; font-weight:bold;"><span class="style4"><span style="font-size:20px; color:#000000;">এম&sbquo; আহমেদ টি এন্ড ল্যান্ডস কোঃ লিঃ </span><br />

                          <span class="style6" style="font-size:14px; color: #000000;  "><b>দরগাহ মহল্লা&sbquo; সিলেট।</b>  ফোন নং- ০৮২১-৭১৬৫৫২  <br />ঢাকা- ০২-৪৯৩৪৯৮৭৫&cedil; চট্টগ্রাম- ০৩১-৭১৩৬৩২<br /> <b>মূল্য সংযোজন কর নিবন্ধন নং- ২২০২১০১৩৫৮০ </b></span></span></td>

                  </tr>

                  <tr>

                    <td><div align="center"><strong>Delivery Challan

                     ( <? if($_SESSION['user']['depot']>0)
					  
						echo $deptt->warehouse_name;?>)

                      

                      </strong></div></td>

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

		              <td><span class="style8"><span class="style8" style="font-size:16px; font-weight:bold;"><?php echo ($dealer->dealer_name_b=='')?$dealer->dealer_name_e.'- '.$dealer->dealer_code.' ('.$dealer->team_name.')':$dealer->dealer_name_b.'- '.$dealer->dealer_code.' ('.$dealer->team_name.')';?></span>&nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>

		        <tr>

		          <td align="right" valign="top"> Address:</td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

		            <tr>

		              <td height="60" valign="top"><span class="style8" style="font-size:16px; "><?php echo ($dealer->address_b=='')?$dealer->address_e:$dealer->address_b;?></span>&nbsp;</td>
		              </tr>

		            </table></td>
		          </tr>

		        

		        <tr>

                  <td align="right" valign="middle">Buyer Name:</td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                      <tr>

                        <td><span class="style8" style="font-size:16px; font-weight:bold;"><?php echo ($dealer->propritor_name_b=='')?$dealer->propritor_name_e:$dealer->propritor_name_b;?></span>&nbsp;</td>
                      </tr>

                  </table></td>
		          </tr>
                  <tr>
                    <td align="right" valign="middle">Mobile:</td>
                    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                        <tr>
                          <td><span class="style8" style="font-size:16px; font-weight:bold;"><?php echo $dealer->mobile_no;?></span>&nbsp;</td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>

		          <td width="40%" align="right" valign="middle">DO Date: </td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

		            <tr>
					
					<td><?php echo $dealer->do_date;?>&nbsp;</td>

		              <!--<td><?php echo date('Y-m-d',strtotime($entry_time));?>&nbsp;</td>-->
		              </tr>

		            </table></td>
		          </tr>
		        </table>		      </td>

			<td width="30%"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">

			  <tr>

			    <td align="right" valign="middle">DO No:</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

			      <tr>

			        <td><?php echo $do_no;?>&nbsp;</td>

			        </tr>

			      </table></td>

			    </tr>

			  <tr>

                <td align="right" valign="middle">DO Date:</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td><?php echo $dealer->do_date;?>&nbsp;</td>

                    </tr>

                </table></td>

			    </tr>

			  <tr>

			    <td align="right" valign="middle">Store Serial No:</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

			      <tr>

			        <td style="font-size:16px; font-weight:bold"><?php echo $driver_name;?>&nbsp;</td>

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

                      <td><?php echo $driver_name_real;?>&nbsp;</td>

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

<input name="button" type="button" onclick="hide();window.print();" value="Print" />

<nobr>

<!--<a href="chalan_bill_view.php?v_no=<?=$_REQUEST['v_no']?>">Bill</a>&nbsp;&nbsp;-->
<? if($dealer->team_name=='Corporate'){?>
<a href="chalan_bill_distributor.php?v_no=<?=$_REQUEST['v_no']?>">New Bill</a>&nbsp;&nbsp;<? }
else{?>
<a href="chalan_bill_corporate.php?v_no=<?=$_REQUEST['v_no']?>">New Bill</a>&nbsp;&nbsp;<? }?>

<!--<a href="chalan_view_mis.php?v_no=<?=$_REQUEST['v_no']?>">MIS Copy</a>--></nobr></div>

</div>

<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="2" style="font-size:11px">

       <tr>

        <td rowspan="2" align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>

        <td rowspan="2" align="center" bgcolor="#CCCCCC"><strong>Code</strong></td>

        <td rowspan="2" align="center" bgcolor="#CCCCCC"><div align="center"><strong>Product Name</strong></div></td>



        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Order Qty</strong></td>

        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Undel. Qty</strong></td>

        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Delivery Qty</strong></td>

        </tr>

       <tr>

         <td align="center" bgcolor="#CCCCCC"><strong>Crt</strong></td>

         <td align="center" bgcolor="#CCCCCC"><strong>Kg</strong></td>

         <td align="center" bgcolor="#CCCCCC"><strong>Crt</strong></td>

         <td align="center" bgcolor="#CCCCCC"><strong>Kg</strong></td>

         <td align="center" bgcolor="#CCCCCC"><strong>Crt</strong></td>

         <td align="center" bgcolor="#CCCCCC"><strong>Kg</strong></td>

        </tr>

<? for($i=0;$i<$pi;$i++){if($fgc[$i]!=2000 and $fgc[$i]!=2001 ){?>

      <tr style="font-size:16px;">

        <td align="center" valign="top"><?=++$kk?></td>

        <td align="left" valign="top"><?=$fgc[$i];?></td>

        <td align="left" valign="top"><?=$item_name[$i];?><?=($gift_on_order[$i]>0)?'<b>(Free)</b>':'';?></td>

        <td align="right" valign="top">

		<? //$del_qty = $order_total_qty[$i];

		//if($del_qty>0) echo $del_pkt = @(int)($del_qty/$pkt_size[$i]); else  echo 0;?><?= 0?></td>

        <td align="right" valign="top"><? $del_qty = $order_total_qty[$i];

if($del_qty>0) echo $del_pkt = @($del_qty/$pkt_size[$i]); else echo 0;?>
<?  //$dels_qty = @(int)(($del_qty%$pkt_size[$i])/$sub_pkt_size[$i]); if($dels_qty>0) echo $dels_qty; else echo 0;?></td>

		<td align="right" valign="top">

		<?

		

		$dellS_qty = (find_a_field('sale_do_chalan','sum(total_unit)','order_no="'.$order_no[$i].'"'));

		$dell_qty = $del_qty - $dellS_qty;

		if($dell_qty>0) echo $del_pkt = @(int)($dell_qty/$pkt_size[$i]); else echo 0;

		?>		</td>

        <td align="right" valign="top">
		
		<? if($dell_qty>0) echo $del_dist = @(int)(($dell_qty%$pkt_size[$i])/$sub_pkt_size[$i]); else echo $dell_qty;?></td>

        <td align="right" valign="top"><? //echo $pkt_unit[$i]*1; $t_pkt = $t_pkt + $pkt_unit[$i];
		echo 0;
		?></td>

        <td align="right" valign="top">
		<? echo number_format($pkt_unit[$i]*1,2); $t_pkt = $t_pkt + $pkt_unit[$i];?>
		<? //echo ($dist_unit[$i]/$sub_pkt_size[$i]); $t_pcs = $t_pcs + ($dist_unit[$i]/$sub_pkt_size[$i]);?></td>

        </tr>

<? }}?>

      <tr style="font-size:16px;">

        <td colspan="7" align="right" valign="top"><strong>Total:</strong></td>

        <td align="right" valign="top"><strong><?= 0?></strong></td>

        <td align="right" valign="top"><strong><?=$t_pkt?></strong></td>

      </tr>

    </table></td>

  </tr>

  <tr>

    <td align="center">

    <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td colspan="2" style="font-size:12px">Prepared By: <?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?>&nbsp;&nbsp;&nbsp;||&nbsp;&nbsp;&nbsp;<em>All goods are received in a good condition as per Terms</em></td>

  </tr>

  <tr>

    <td colspan="2"><span class="style9">Chalan Print At: <?=date('Y-m-d h:i:s A');?> </span></td>

    </tr>

  <tr>

    <td width="50%">&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td colspan="2" align="center"><strong><br />

      </strong>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td width="25%"><div align="center">Received By </div></td>

          <td width="25%"><div align="center">Driver</div></td>

          <td width="25%"><div align="center">Store Officer </div></td>

          <td width="25%"><div align="center">Store Incharge </div></td>

          </tr>

      </table></td>

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

