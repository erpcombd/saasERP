<?php
//
//====================== EOF ===================
//var_dump($_SESSION);
require_once "../../../engine/tools/check.php";
require_once "../../../engine/configure/db_connect.php";
require_once "../../../engine/tools/my.php";
require_once "../../../engine/tools/class.numbertoword.php";



$v_no 		= $_REQUEST['v_no'];

if(isset($_POST['change']))
{

$sql = 'UPDATE  `sale_chalan_bill` SET  `vat` =  '.$_POST['vat'].',`vat_note` =  "'.$_POST['vat_note'].'",
`discount` =  '.$_POST['discount'].' WHERE  `id` ='.$v_no.'';
db_query($sql);
}

$bill=find_all_field('sale_chalan_bill','s','id='.$v_no);

$chalan_nox = explode(',',$bill->chalan_no);
$chalan_no = $chalan_nox[0];

$datas=find_all_field('lc_workorder_chalan','s','chalan_no='.$chalan_no);
$ww=find_all_field('lc_workorder','s','id='.$datas->wo_id);
$from_d = find_all_field('user_activity_management','fname','user_id='.$ww->prepared_by);
$sql1="select sum(c.qty) as qty,c.specification_id from lc_workorder_chalan c where c.chalan_no in (".$bill->chalan_no.") group by  c.specification_id";
$data1=db_query($sql1);


$pi=0;
$total=0;
//echo $sql2;
while($info=mysqli_fetch_object($data1)){ 
$pi++;


$sl[]=$pi;
$qty[]=$info->qty;
$order=find_all_field('lc_workorder_details','rate','id='.$info->specification_id);
$item=find_all_field('item_info','rate','item_id='.$order->item_id);
$rate[] = $order->rate;
if($item->pack_unit=='Dz')
$amount[]=($order->rate/12)*$info->qty;
else
$amount[]=($order->rate)*$info->qty;
$items[]=$item->item_name;

$specification[]=$order->specification;
$meassurment[]=$order->meassurment;
$item_id[]=$order->item_id;
$style_no[]=$order->style_no;
}
$buyer_name =  find_a_field('lc_brand_buyer','brand_buyer_name','id='.$info->buyer);
$buyer = $info->buyer_id;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Chalan Depot :.</title>
<link href="../../css/report.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
<style type="text/css">
<!--
.style7 {font-size: 12px}
.style8 {
	font-size: 14px;
	font-weight: bold;
}
td {
	padding: 0px 0px;
}
.style5 {font-size: 12}
-->
</style>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif">
<br /><br /><form action="" method="post"><table width="700" border="1" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="header">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td width="20%" valign="top"><? $path=str_replace(' ','',"../../../logo/ripon.jpg"); 
			if(is_file($path)) echo '<img src="'.$path.'" height="70" />';?></td>
			<td width="50%" align="center" valign="middle"><table width="60%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">BILL</td>
  </tr>
</table>   </td>
			<td width="30%"><table width="100%" border="0" cellspacing="0">
			  <tr>
                <td align="right" valign="middle">Bill NO : </td>
			    <td><?php echo $bill->id;?></td>
			    </tr>
			  <tr>
			    <td width="40%" align="right" valign="middle">Bill Date : </td>
			    <td><?php echo $bill->bill_date;?></td>
			    </tr>
			  </table></td>
		  </tr>
		</table>
    </div></td>

  </tr>
  <tr>
    
	<td>	</td>
  </tr>
  
  <tr>
    <td style="border:0px;">
<div id="pr">
<div align="left">
<input name="button" type="button" onclick="hide();window.print();" value="Print" />

<input type="submit" name="change" value="CHANGE" />
<input name="chalan_no" type="hidden" value="<?=$v_no?>" />
</div>
</div>
<table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#333333" bgcolor="#FFFFFF">
  <tr>
    <td bordercolor="#333333" bgcolor="#CCCCCC"><div align="center"><span class="style7">SHIPPER/EXPORTER</span></div></td>
    <td bordercolor="#333333" bgcolor="#CCCCCC"><div align="center"><span class="style7">RECEIVER/BILL TO </span></div></td>
  </tr>
  <tr>
    <td width="50%" valign="top" bordercolor="#333333"><span class="style8"><?=$_SESSION['user']['depot_name']?>
    </span><br /> 
    <span class="style7">Office: <?=$_SESSION['company_address']?></span></td>
    <td width="50%" valign="top" bordercolor="#333333"><span class="style7">
      <? $par=find_all_field('lc_buyer','buyer_name','id='.$ww->buyer_id);
echo '<span class="style8">'.$par->buyer_name.' </span><BR><span class="style7">Address:'.$par->address.' Contact:'.$par->contact_person_name.' Cell:'.$par->contact_person_cell.'</span>';
					?>
    </span></td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td width="50%"><span class="style7">Ref No# <?=$ww->manual_no?> </span></td>
    <td><span class="style7">Buyer Name: <strong><? echo $buyer_name;?></strong></span></td>
    </tr>
</table>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0">
  <tr>
    <td align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>
    <td align="center" bgcolor="#CCCCCC"><div align="center"><strong>Item</strong></div></td>
    <td align="center" bgcolor="#CCCCCC"><strong>Style/PO No</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>Spec</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>Measurement</strong></td>
    <td width="5%" align="center" bgcolor="#CCCCCC"><strong>Rate</strong></td>
    <td width="5%" align="center" bgcolor="#CCCCCC"><strong>Delivery Qty.</strong></td>
    <td width="5%" align="center" bgcolor="#CCCCCC"><strong>Amount</strong></td>
  </tr>
  <? for($i=0;$i<$pi;$i++){?>
  <tr>
    <td align="center" valign="top"><?=$sl[$i]?></td>
    <td align="left" valign="top">
      <div align="left">
        <?=$items[$i];?>
      </div></td><td align="right" valign="top"><div align="center">
      <?=$style_no[$i]?>
    </div></td>
    <td align="right" valign="top"><div align="center">
      <?=$specification[$i]?>
    </div></td>
    <td align="right" valign="top"><div align="center">
      <?=$meassurment[$i]?>
    </div></td>
    <td align="right" valign="top"><?=$rate[$i]?></td>
    <td align="right" valign="top"><?=number_format($qty[$i],2)?></td>
    <td align="right" valign="top"><?=number_format($amount[$i],2)?></td>
  </tr>
  <? $total = $total + $amount[$i]; $totalt = $totalt+$qty[$i];}?>
  <tr>
    <td colspan="6" align="right">Total  :</td>
    <td align="right"><strong><?php echo number_format($totalt,0);?></strong></td>
    <td align="right"><strong><?php echo number_format($total,2);?></strong></td>
  </tr>
  <tr>
    <td colspan="7" align="right">Discount (If Applied) : </td>
    <td align="right"><input name="discount" type="text" id="discount" style="width:80px; font-size:10px;text-align:right; font-weight:bold;" value="<?=$bill->discount?>" /></td>
  </tr>
  <tr>
    <td colspan="7" align="right"><label>
      <input name="vat_note" type="text" id="vat_note" style="width:300px; border-color:#FFFFFF; border:0px;" align="left" value="<?=$bill->vat_note?>" />
    </label>
      Vat/Tax (If Applied) : </td>
    <td align="right"><input name="vat" type="text" id="vat" style="width:80px; font-size:10px;text-align:right; font-weight:bold;" value="<?=$bill->vat?>"/></td>
  </tr>
  <tr>
    <td colspan="7" align="right">Total : </td>
    <td align="right"><input name="last_total" type="text" id="last_total" style="width:80px; font-size:10px;text-align:right; font-weight:bold;" value="<?php 
	$ddd = $total-($discount-$vat);
	echo number_format(($total-$bill->discount+$bill->vat),2);?>"/></td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td style="border:0px;" align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr style="border:#666666">
	    <td  colspan="3" style="font-size:12px;border:0px;"><strong><u>Chalan No: <?=$bill->chalan_no?></u></strong></td>
	    </tr>
	  <tr>
      <td  colspan="3" style="font-size:12px;border:0px;"><strong>Inwords: &nbsp;
          <?=convertNumber_nodoller($ddd);
?>
      </strong><br /></td>
    </tr>
  <tr>
    <td  colspan="3" style="font-size:12px;border:0px;"><ul>
      
          <li class="style5">Bill must be proceed within negotiable date .</li>
          <li><em>All goods are received in a good condition as per L/C Terms</em></li>
          <li>Claims for short receive, part delievery must be advised in writing with in three (3) days after delievery. </li>
          <li class="style5">Contact Person:
            <?=$from_d->fname;?>
            . Mobile no#
            <?=$from_d->mobile;?>. Email#
			  <?=$from_d->email;?>
          </li>
          </ul></td>
    </tr>
  <tr>
    <td style="border:0px;" width="50%">&nbsp;</td>
    <td style="border:0px;">&nbsp;</td>
    <td style="border:0px;">&nbsp;</td>
  </tr>
  <tr>
    <td style="border:0px;">&nbsp;</td>
    <td style="border:0px;">&nbsp;</td>
    <td style="border:0px;">&nbsp;</td>
  </tr>
  <tr>
    <td style="border:0px;">&nbsp;</td>
    <td style="border:0px;">&nbsp;</td>
    <td style="border:0px;">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top" style="border:0px;"><strong>--------------------------------<br /> 
      Prepared By
</strong></td>
    <td align="center" valign="top" style="border:0px;"><strong>--------------------------------<br />
    Received By </strong></td>
    <td style="border:0px;" align="center"><strong>--------------------------------<br /> 
      Authorized<br />
      <?=$_SESSION['user']['depot_name']?>
    </strong></td>
  </tr>
    </table>
    </td>
  </tr>
</table></form>
</body>
</html>
