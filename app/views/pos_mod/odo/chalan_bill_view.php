<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);
require_once "../../../assets/support/inc.all.php";

$chalan_no 		= $_REQUEST['v_no'];


$datas=find_all_field('lc_workorder_chalan','s','chalan_no='.$v_no);

$sql1="select b.* from 
sale_do_chalan b
where b.chalan_no = '".$chalan_no."'";
$data1=mysql_query($sql1);


$pi=0;
$total=0;
while($info=mysql_fetch_object($data1)){ 
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
	$item = find_all_field('item_info','mhafuz','item_id='.$infos->item_id);
	$item_name[] = $item->item_name;
	$sps[] = $item->sub_pack_size;
	$fgc[] = $item->finish_goods_code;
$sub_pkt_size[] = (($sps>1)?$sps:1);
$pkt_unit[] = $info->pkt_unit;
$dist_unit[] = $info->dist_unit;
$total_unit[] = $info->total_unit;
}
$ssql = 'select a.* from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;
$dealer = find_all_field_sql($ssql);
$ssql = 'select b.* from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;
$do = find_all_field_sql($ssql);

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
		          <td><?php echo $dealer->dealer_name_e;?></td>
		          </tr>
		        <tr>
		          <td align="left" valign="top"> Address:</td>
		          <td><?php echo $dealer->address_e?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Contact Person:</td>
		          <td><?php echo $dealer->propritor_name_e.' Mobile: '.$dealer->mobile_no;;?></td>
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
<input name="button" type="button" onclick="hide();window.print();" value="Print" />
</div>
</div>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="2" style="font-size:11px;">
       
       <tr>
         <td rowspan="2" align="center" bgcolor="#FFFFFF"><strong>SL</strong></td>
         <td rowspan="2" align="center" bgcolor="#FFFFFF"><strong>Product Name</strong></td>
         <td rowspan="2" align="center" bgcolor="#FFFFFF"><strong>MRP </strong></td>
         <td rowspan="2" align="center" bgcolor="#FFFFFF"><strong>TP/Pc</strong></td>
         <td rowspan="2" align="center" bgcolor="#FFFFFF"><strong>TP Per Ctn </strong></td>
         <td colspan="2" align="center" bgcolor="#FFFFFF"><strong>Order</strong></td>
         <td rowspan="2" align="center" bgcolor="#FFFFFF"><strong>Amount</strong></td>
       </tr>
       <tr>
         <td align="center" bgcolor="#FFFFFF"><strong>Crt </strong></td>
         <td align="center" bgcolor="#FFFFFF"><strong>Pcs. </strong></td>
        </tr>
<? for($i=0;$i<$pi;$i++){ if($fgc[$i]!=2000 and $fgc[$i]!=2001 ){
$items = find_all_field('item_info','item_name','item_id='.$item_id[$i]);
$set = find_all_field('sales_corporate_price','discount','dealer_code="'.$dealer->dealer_code.'" and item_id="'.$item_id[$i].'"');
$fit_size = ($items->sub_pack_size>0)?$items->sub_pack_size:1;
?>
      <tr>
        <td align="center" valign="top"><?=$i+1?></td>
        <td align="left" valign="top"><?=$item_name[$i];?></td>
        <td align="right" valign="top"><?=number_format($items->m_price*$fit_size,0)?></td>
        <td align="right" valign="top"><?=$unit_price[$i]*$fit_size?></td>
        <td align="right" valign="top"><?=($unit_price[$i]*$items->pack_size)?></td>

		<td align="right" valign="top"><? echo $pkt_unit[$i]; $tdp = $tdp + $pkt_unit[$i];?></td>
        <td align="right" valign="top"><? echo ($dist_unit[$i]/$sub_pkt_size[$i]); $tdpc = $tdpc + ($dist_unit[$i]/$sub_pkt_size[$i]);?></td>
        <td align="right" valign="top"><? $ttt = (($unit_price[$i])*$total_unit[$i]); echo number_format($ttt,2); $tot = $tot + $ttt; ?></td>
        </tr>
<? }}?>
      <tr style="border-bottom:#FFFFFF">
        <td colspan="5" align="center" valign="top"><div align="right"><strong>Total  </strong></div></td>
        <td align="center" valign="top"><div align="right"><strong>
          <?=$tdp?>
        </strong></div></td>
        <td align="center" valign="top"><div align="right"><strong>
          <?=$tdpc?>
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
        <td colspan="7" align="center" valign="top"><div align="right"><strong>Special Discount <?=$do->sp_discount?> %: </strong></div></td>
        <td align="right" valign="top"><strong>
          <?=number_format((($sd)/100),2)?>
        </strong></td>
      </tr>
	  <? }?>
      <tr>
        <td colspan="7" align="center" valign="top"><div align="right"><strong>Total Payable Amount: </strong></div></td>
        <td align="right" valign="top"><strong>
          <?=number_format(($tot-($tot*$do->sp_discount)/100),2)?>
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
