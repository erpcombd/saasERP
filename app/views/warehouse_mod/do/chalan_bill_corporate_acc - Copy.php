<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$chalan_no 		= $_REQUEST['v_no'];


$datas=find_all_field('lc_workorder_chalan','s','chalan_no='.$v_no);

$sql1="select d.*,b.*,sum(b.total_unit) as total_unit,sum(b.total_amt) as total_amt from sale_do_chalan b,sale_do_details d where d.id=b.order_no and b.chalan_no = '".$chalan_no."' and (b.item_id!=1096000100010239 and b.item_id!=1096000100010312) group by b.order_no";
$data1=db_query($sql1);


$pi=0;
$total=0;
while($info=mysqli_fetch_object($data1)){ 
$pi++;$entry_time=$info->entry_time;
$chalan_date=$info->chalan_date;
$do_no=$info->do_no;
$order_no[]=$info->order_no;
$driver_name=$info->driver_name;
$vehicle_no=$info->vehicle_no;
$delivery_man=$info->delivery_man;
$cash_discount=$info->cash_discount;

$item_id[] = $info->item_id;
$unit_price[] = $info->unit_price;
$pkt_size[] = $info->pkt_size;
$sps = find_a_field('item_info','sub_pack_size','item_id='.$info->item_id);
$sub_pkt_size[] = (($sps>1)?$sps:1);
$pkt_unit[] = (int)($info->total_unit/$info->pkt_size);
$dist_unit[] = (int)($info->total_unit%$info->pkt_size);
$total_unit[] = $info->total_unit;
$total_amt[] = $info->total_amt;

}
$ssql = 'select a.* from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;
$dealer = find_all_field_sql($ssql);
$ssql = 'select b.* from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;
$do = find_all_field_sql($ssql);


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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Cash Memo :.</title>
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
.style6 {color: #FF3366; font-weight: bold; }
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
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>
				<table width="60%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td bgcolor="#00CC66" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;"><span class="style1">BILL</span></td>
      </tr>
    </table></td>
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
		          <td width="20%" align="left" valign="middle">Ref No: </td>
		          <td width="80%"><?php echo $do->ref_no;?></td>
		        </tr>
		        <tr>
                  <td align="left" valign="middle">Party Name:</td>
		          <td><?php echo $dealer->dealer_code.'-'.$dealer->dealer_name_e.'('.$dealer->product_group.')';?></td>
		          </tr>
		        <tr>
		          <td align="left" valign="top"> Address:</td>
		          <td><?php echo $dealer->address_e?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Contact Person:</td>
		          <td><?php echo $dealer->propritor_name_e.' Mobile: '.$dealer->mobile_no;;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle"><span class="style6">Offer Date:</span></td>
		          <td><span class="style6">
		            <?=date('Y-m-d',strtotime($entry_time));?>
		          </span></td>
		        </tr>
		        </table>		      </td>
			<td width="30%"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			  <tr>
                <td width="48%" align="right" valign="middle"> <div align="left">Delivery Date</div></td>
			    <td width="52%"><?=$chalan_date?></td>
			  </tr>
			  <tr>
			    <td align="right" valign="middle"><div align="left">Order Date: </div></td>
			    <td><?=$do->do_date?></td>
			    </tr>
			  <tr>
			    <td align="right" valign="middle"><div align="left">DO No:</div></td>
			    <td><?php echo $do_no;?></td>
			  </tr>
			  <tr>
			    <td align="right" valign="middle"><div align="left">Challan No:</div></td>
			    <td><?php echo $chalan_no;?></td>
			  </tr>
			  <tr>
                <td align="right" valign="middle"><div align="left">Bill No:</div></td>
			    <td><strong><?php echo $do->remarks;?></strong></td>
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
          <td>&nbsp;</td>
          <td><label></label>
            <input type="hidden" name="c_no" id="c_no" value="<?=$chalan_no?>" /></td>
          <td><label></label></td>
        </tr>
      </table>
        </form>
    </div>
</div>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="2" style="font-size:11px;">
       
       <tr>
         <td rowspan="2" align="center" bgcolor="#FFFFFF"><strong>SL</strong></td>
         <td rowspan="2" align="center" bgcolor="#FFFFFF"><strong>Product Name</strong></td>
         <td rowspan="2" align="center" bgcolor="#FFFFFF"><strong>MRP </strong></td>
         <td rowspan="2" align="center" bgcolor="#FFFFFF"><strong>DP/Pc</strong></td>
         <td rowspan="2" align="center" bgcolor="#FFFFFF"><strong>DP/Ctn </strong></td>
         <td rowspan="2" align="center" bgcolor="#FFFFFF"><strong>Dis/Ctn </strong></td>
         <td colspan="2" align="center" bgcolor="#FFFFFF"><strong>Delivery</strong></td>
         <td rowspan="2" align="center" bgcolor="#FFFFFF"><strong>Total Amt </strong></td>
         <td rowspan="2" align="center" bgcolor="#FFFFFF"><strong>Discount</strong></td>
         <td rowspan="2" align="center" bgcolor="#FFFFFF"><strong>Payable Amt </strong></td>
       </tr>
       <tr>
         <td align="center" bgcolor="#FFFFFF"><strong>Crt </strong></td>
         <td align="center" bgcolor="#FFFFFF"><strong>Pcs. </strong></td>
        </tr>
<? for($i=0;$i<$pi;$i++){ 
$gift_o = find_all_field('sale_do_details','','gift_on_order="'.$order_no[$i].'"  and (item_id=1096000100010239 || item_id=1096000100010312)');
$gift_order  = $gift_o->id;

if($gift_order>0){
$gifts = 'select sum(total_unit) total_unit, unit_price from sale_do_chalan where order_no="'.$gift_order.'" and chalan_no = "'.$chalan_no.'"';
$giftq = db_query($gifts);
$gift = mysqli_fetch_object($giftq);
$per_pcs =  (-1)*(@(@($gift->unit_price)/($total_unit[$i]/$gift->total_unit)));
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
        <td align="left" valign="top"><? echo $items->item_name.'-'.$items->finish_goods_code; ?><?
		$gsql = 'select offer_name from sale_gift_offer g, sale_do_details d where g.id=d.gift_id and d.gift_on_order="'.$order_no[$i].'"';
		$gquery = db_query($gsql);
		while($qdata=mysqli_fetch_object($gquery)){if($g==0) echo '<b>  [Offer-'.$qdata->offer_name; else echo '/'.$qdata->offer_name; $g++; }
		if($g>0) echo ']</b>';?></td>
        <td align="right" valign="top"><?=number_format($items->m_price*$fit_size,0)?></td>
        <td align="right" valign="top"><?=$unit_price[$i]*$fit_size?></td>
        <td align="right" valign="top"><?=($unit_price[$i]>0)?($unit_price[$i]*$items->pack_size):'';?></td>
        <td align="right" valign="top"><?=(($per_pcs*$pkt_size[$i])>0)?$per_pcs*$pkt_size[$i]:'0';?></td>

		<td align="right" valign="top"><? echo $pkt_unit[$i]; $tdp = $tdp + $pkt_unit[$i];?></td>
        <td align="right" valign="top"><? echo ($dist_unit[$i]/$sub_pkt_size[$i]); $tdpc = $tdpc + ($dist_unit[$i]/$sub_pkt_size[$i]);?></td>
        <td align="right" valign="top"><? $tttt = $unit_price[$i]*$total_unit[$i]; echo  number_format($tttt,2); $ttttt = $ttttt + $tttt;?></td>
        <td align="right" valign="top"><? $discount = ($per_pcs)*$total_unit[$i]; echo  number_format($discount,2); $tdiscount = $tdiscount + $discount;?></td>
        <td align="right" valign="top"><? $ttt = $total_amt[$i]-$discount; echo number_format($ttt,2); $tot = $tot + $ttt; ?></td>
        </tr>
<? }?>
      <tr style="border-bottom:#FFFFFF">
        <td colspan="6" align="center" valign="top"><div align="right"><strong>Total  </strong></div></td>
        <td align="center" valign="top"><div align="right"><strong>
          <?=$tdp?>
        </strong></div></td>
        <td align="center" valign="top"><div align="right"><strong>
          <?=$tdpc?>
        </strong></div></td>
        <td align="right" valign="top"><? echo  number_format($ttttt,2);?></td>
        <td align="right" valign="top"><? echo  number_format($tdiscount,2);?></td>
        <td align="right" valign="top"><strong>
          <?=number_format($tot,2)?>
        </strong></td>
      </tr>
	  <?
	  $sd = $tot*$do->sp_discount;
	  if($sd>0){
	  ?><div align="right"><strong>Special Discount <?=$do->sp_discount?> %: </strong></div>
      <tr>
        <td colspan="10" align="center" valign="top"><div align="right"><strong>Special Discount <?=$do->sp_discount?> %: </strong></div></td>
        <td align="right" valign="top"><strong>
          <?=number_format((($sd)/100),2)?>
        </strong></td>
      </tr>
	  <? }if($cash_discount>0){?>
      <tr>
        <td colspan="10" align="center" valign="top"><div align="right"><strong>Cash Discount  : </strong></div></td>
        <td align="right" valign="top"><strong>
          <?=number_format($cash_discount,2)?>
        </strong></td>
      </tr>
	  <? }?>
      <tr>
        <td colspan="10" align="center" valign="top"><div align="right"><strong>Total Payable Amount : </strong></div></td>
        <td align="right" valign="top"><strong>
          <?=number_format((($tot-($tot*$do->sp_discount)/100)-$cash_discount),2)?>
        </strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" style="font-size:12px"><em>N B : This is software generated bill, Signatiory is not required. </em></td>
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
    <td colspan="2" align="center"><div class="footer_left">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="33%">            <div align="left">Received By</div></td>
          <td width="67%">Store In-Charge </td>
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
