<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$chalan_no 		= $_REQUEST['v_no'];


$datas=find_all_field('lc_workorder_chalan','s','chalan_no='.$chalan_no);

$sql1="select b.* from 
sale_do_chalan b
where b.chalan_no = '".$chalan_no."'";
$data1=db_query($sql1);


$pi=0;
$total=0;
while($info=mysqli_fetch_object($data1)){ 
$pi++;
$chalan_date=$info->chalan_date;
$do_no=$info->do_no;
$order_no[]=$info->order_no;
$driver_name=$info->driver_name;
$vehicle_no=$info->vehicle_no;
$delivery_man=$info->delivery_man;

$item_id[] = $info->item_id;
$unit_price[] = $info->unit_price;
$pkt_size[] = $info->pkt_size;
$sps = find_a_field('item_info','sub_pack_size','item_id='.$info->item_id);
$sub_pkt_size[] = (($sps>1)?$sps:1);
$pkt_unit[] = $info->pkt_unit;
$dist_unit[] = $info->dist_unit;
$total_unit[] = $info->total_unit;
}
$ssql = 'select a.* from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;
$dealer = find_all_field_sql($ssql);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
.style4 {font-size: 18px}
.style6 {font-size: 10px}
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
                <td>
				<table  width="48%" border="0" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:14px; font-weight:bold;">
		  <span class="style4">J &amp; J Essential Products Ltd. <br>
		  <span class="style6">Plot # B-10,11,12, BSCIC Industrial Area, Glora, Manikgonj </span></span></td>
      </tr>
	  <td><div align="center"><strong>Delivery Challan</strong></div></td>
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
		              <td><?php echo $dealer->dealer_name_e.'-'.$dealer->dealer_code.'('.$dealer->product_group.')';?>&nbsp;</td>
		              </tr>
		            </table></td>
		          </tr>
		        <tr>
		          <td align="right" valign="top"> Address:</td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td height="60" valign="top"><?php echo $dealer->address_b.'&nbsp;'.' Mobile: '.$dealer->mobile_no;?>&nbsp;</td>
		              </tr>
		            </table></td>
		          </tr>
		        
		        <tr>
		          <td align="right" valign="middle">Buyer Name:</td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td><?php echo $dealer->propritor_name_b;?>&nbsp;</td>
		              </tr>
		            </table></td>
		          </tr>
		        </table>		      </td>
			<td width="30%"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			  <tr>
                <td align="right" valign="middle"> Date</td>
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
			    <td align="right" valign="middle">Delivery Order No:</td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			      <tr>
			        <td><?php echo $do_no;?>&nbsp;</td>
			        </tr>
			      </table></td>
			    </tr>
			  <tr>
			    <td align="right" valign="middle">Store Serial No:</td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			      <tr>
			        <td><?php echo $driver_name;?>&nbsp;</td>
			        </tr>
			      </table></td>
			    </tr>
			  <tr>
			    <td align="right" valign="middle">Vehicle No:</td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			      <tr><td><?=$vehicle_no?>&nbsp;</td></tr>
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
<a href="chalan_bill_view.php?v_no=<?=$_REQUEST['v_no']?>">Bill</a></div>
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
         <td align="center" bgcolor="#CCCCCC"><strong>Pcs</strong></td>
         <td align="center" bgcolor="#CCCCCC"><strong>Crt</strong></td>
         <td align="center" bgcolor="#CCCCCC"><strong>Pcs</strong></td>
         <td align="center" bgcolor="#CCCCCC"><strong>Crt</strong></td>
         <td align="center" bgcolor="#CCCCCC"><strong>Pcs</strong></td>
        </tr>
<? for($i=0;$i<$pi;$i++){?>

      <tr>
        <td align="center" valign="top"><?=$i+1?></td>
        <td align="left" valign="top"><?=find_a_field('item_info','finish_goods_code','item_id='.$item_id[$i]);?></td>
        <td align="left" valign="top"><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>
        <td align="right" valign="top">
		<? $del_qty = find_a_field('sale_do_details','sum(total_unit)','id="'.$order_no[$i].'"');
		if($del_qty>0) echo $del_pkt = (int)($del_qty/$pkt_size[$i]); else echo 0;?></td>
        <td align="right" valign="top"><?  $dels_qty = (int)(($del_qty%$pkt_size[$i])/$sub_pkt_size[$i]); if($dels_qty>0) echo $dels_qty; else echo 0;?></td>
		<td align="right" valign="top">
		<?
		
		$dellS_qty = (find_a_field('sale_do_chalan','sum(total_unit)','order_no="'.$order_no[$i].'"'));
		$dell_qty = $del_qty - $dellS_qty;
		if($dell_qty>0) echo $del_pkt = (int)($dell_qty/$pkt_size[$i]); else echo 0;
		?>		</td>
        <td align="right" valign="top"><? if($dell_qty>0) echo $del_dist = (int)(($dell_qty%$pkt_size[$i])/$sub_pkt_size[$i]); else echo $dell_qty;?></td>
        <td align="right" valign="top"><? echo $pkt_unit[$i]; $t_pkt = $t_pkt + $pkt_unit[$i];?></td>
        <td align="right" valign="top"><? echo ($dist_unit[$i]/$sub_pkt_size[$i]); $t_pcs = $t_pcs + ($dist_unit[$i]/$sub_pkt_size[$i]);?></td>
        </tr>
<? }?>
      <tr>
        <td colspan="7" align="right" valign="top"><strong>Total:</strong></td>
        <td align="right" valign="top"><strong><?=$t_pkt?></strong></td>
        <td align="right" valign="top"><strong><?=$t_pcs?></strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" style="font-size:12px"><em>All goods are received in a good condition as per Terms</em></td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><strong><br />
      </strong>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><div align="center">Received By </div></td>
          <td><div align="center">Prepared By </div></td>
          <td><div align="center">AM/Manager</div></td>
          <td><div align="center">GM (Sales) </div></td>
          <td><div align="center">Approved By </div></td>
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
