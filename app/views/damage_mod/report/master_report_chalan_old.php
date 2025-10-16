<?
session_start();
require "../../../engine/tools/check.php";
require "../../../engine/configure/db_connect.php";
require "../../../engine/tools/my.php";
require "../../../engine/tools/report.class.php";

date_default_timezone_set('Asia/Dhaka');

if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)
{
	if((strlen($_POST['t_date'])==10)&&(strlen($_POST['f_date'])==10))
	{
		$t_date=$_POST['t_date'];
		$f_date=$_POST['f_date'];
	}
	
if($_POST['product_group']!='') $product_group=$_POST['product_group'];
if($_POST['item_brand']!='') 	$item_brand=$_POST['item_brand'];
if($_POST['item_id']>0) 		$item_id=$_POST['item_id'];
if($_POST['dealer_code']>0) 	$dealer_code=$_POST['dealer_code'];
if($_POST['dealer_type']!='') 	$dealer_type=$_POST['dealer_type'];

if($_POST['status']!='') 		$status=$_POST['status'];
if($_POST['or_no']!='') 		$or_no=$_POST['or_no'];
if($_POST['area_id']!='') 		$area_id=$_POST['area_id'];
if($_POST['zone_id']!='') 		$zone_id=$_POST['zone_id'];
if($_POST['region_id']>0) 		$region_id=$_POST['region_id'];
if($_POST['depot_id']!='') 		$depot_id=$_POST['depot_id'];

if(isset($item_brand)) 			{$item_brand_con=' and i.item_brand="'.$item_brand.'"';} 
if(isset($dealer_code)) 		{$dealer_con=' and a.dealer_code="'.$dealer_code.'"';} 
if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 

if(isset($dealer_type)) 		{$dtype_con=' and d.dealer_type="'.$dealer_type.'"';}
if(isset($dealer_type)) 		{$dealer_type_con=' and d.dealer_type="'.$dealer_type.'"';}

if(isset($item_id))				{$item_con=' and i.item_id='.$item_id;} 
if(isset($depot_id)) 			{$depot_con=' and d.depot="'.$depot_id.'"';} 

$item_info = find_all_field('item_info','','item_id='.$item_id);

//if(isset($dealer_code)) 		{$dealer_con=' and a.dealer_code="'.$dealer_code.'"';} 
//if(isset($product_group)) 	{$pg_con=' and d.product_group="'.$product_group.'"';} 
//if(isset($zone_id)) 			{$zone_con=' and a.buyer_id='.$zone_id;}
//if(isset($region_id)) 		{$region_con=' and d.id='.$region_id;}
//if(isset($item_id)) 			{$item_con=' and b.item_id='.$item_id;} 
//if(isset($status)) 			{$status_con=' and a.status="'.$status.'"';} 
//if(isset($or_no)) 			{$or_no_con=' and a.or_no="'.$or_no.'"';} 
//if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $order_con=' and o.order_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
//if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $Damage_con=' and c.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

switch ($_POST['report']) {
case 1:
	if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
	$report="Delivery Damage Summary Brief";
	break;
case 2:
		$report="Item Wise Damage Details Report";
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
	break;
case 21:
$report="Item wise Sales vs Damage Report";
	break;
	case 3:
$report="Delivered Damage Report (Damage Wise)";
if(isset($dealer_type)) 		{$dtype_con=' and d.dealer_type="'.$dealer_type.'"';} 
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($dealer_code)) {$dealer_con=' and m.vendor_id='.$dealer_code;} 
if(isset($item_id)){$item_con=' and i.item_id='.$item_id;} 
if(isset($depot_id)) {$depot_con=' and d.depot="'.$depot_id.'"';} 
	break;
	case 6:
	if($_REQUEST['damage_no']>0)
header("Location:../damage_report/damage_view_print.php?req_no=".$_REQUEST['damage_no']);
	break;
	case 5:
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($product_group)) 	{$pg_con=' and d.product_group="'.$product_group.'"';} 
$report="Delivery Order Brief Report (Region Wise)";
	break;
	    case 7:
		$report="Item wise DO Report";
if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 

$sql = "select concat(i.finish_goods_code,'- ',item_name) as item_name,i.item_brand,i.sales_item_type as `group`,
floor(sum(o.total_unit)/o.pkt_size) as crt,
mod(sum(o.total_unit),o.pkt_size) as pcs, 
sum(o.total_amt)as dP,
sum(o.total_unit*o.t_price)as tP
from 
warehouse_damage_receive m,sale_do_details o, item_info i,dealer_info d
where m.or_no=o.or_no and m.vendor_id=d.dealer_code and i.item_id=o.item_id   ".$date_con.$item_con.$item_brand_con.$pg_con.' group by i.finish_goods_code';
	break;
		case 8:
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($product_group)) 	{$pg_con=' and d.product_group="'.$product_group.'"';} 
$report="Dealer Performance Report";
	    case 9:
		$report="Item Report (Region Wise)";
if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 
		break;
		
		case 10:
		$report="Daily Collection Summary";
		
$sql="select m.or_no,m.or_date,concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  ,d.product_group as grp, m.bank as bank_name,m.branch as branch_name,m.payment_by as payment_mode, m.rcv_amt as amount,m.remarks,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as Varification_Sign,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as DO_Section_sign from 
warehouse_damage_receive m,dealer_info d  , warehouse w
where   m.vendor_id=d.dealer_code and w.warehouse_id=d.depot".$date_con.$pg_con." order by m.entry_at";
		break;
		
		case 11:
		$report="Daily Collection &amp; Order Summary";
		
$sql="select m.or_no, m.or_date, concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  ,d.product_group as grp, m.bank as bank_name, m.payment_by as payment_mode,m.remarks, m.rcv_amt as collection_amount,(select sum(total_amt) from sale_do_details where or_no=m.or_no) as DP_Total,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' from 
warehouse_damage_receive m,dealer_info d  , warehouse w 
where   m.vendor_id=d.dealer_code and w.warehouse_id=d.depot".$date_con.$pg_con." order by m.entry_at";
		break;
				case 13:
		$report="Daily Collection Summary(EXT)";
		
$sql="select m.or_no,m.or_date,m.entry_at,concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  ,d.product_group as grp, m.bank as bank_name,m.branch as branch_name,m.payment_by as payment_mode, m.rcv_amt as amount,m.remarks,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as Varification_Sign,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as DO_Section_sign from 
warehouse_damage_receive m,dealer_info d  , warehouse w
where   m.vendor_id=d.dealer_code and w.warehouse_id=d.depot".$date_con.$pg_con." order by m.entry_at";
		break;
    case 111:
	if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
$report="Corporate Damage Summary Brief";
	break;
	    case 112:
	if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
$report="SuperShop Damage Summary Brief";
	break;
	
	    case 1004:
		$report="Warehouse Stock Position Report(Closing)";

		break;
		case 107:
		$report="Regional Sales Vs Damage Report (TK)";

		break;
		case 108:
		$report="Zone Wise Sales Vs Damage Report (TK)";
		
		break;
		case 109:
		$report="Party Wise  Sales Vs Damage Report (TK)";

		break;									
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$report?></title>
<link href="../../css/report.css" type="text/css" rel="stylesheet" />
<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>
    <style type="text/css" media="print">
      div.page
      {
        page-break-after: always;
        page-break-inside: avoid;
      }
    </style>
    <style type="text/css">
<!--
.style1 {color: #FFFFFF}
.style2 {
	font-size: 16px;
	font-weight: bold;
}
-->
    </style>
</head>
<body>
<div align="center" id="pr">
<input type="button" value="Print" onclick="hide();window.print();"/>
</div>
<div class="main">
<?
		$str 	.= '<div class="header">';
		if(isset($_SESSION['company_name'])) 
		$str 	.= '<h1>'.$_SESSION['company_name'].'</h1>';
		if(isset($report)) 
		$str 	.= '<h2>'.$report.'</h2>';
		if(isset($dealer_code)) 
		$str 	.= '<h2>Dealer Name : '.$dealer_code.' - '.find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code).'</h2>';
		if(isset($item_info->item_id)) 
		$str 	.= '<h2>Item Name : '.$item_info->item_name.'('.$item_info->finish_goods_code.')'.'('.$item_info->sales_item_type.')'.'('.$item_info->item_brand.')'.'</h2>';
		if(isset($to_date)) 
		$str 	.= '<h2>Date Interval : '.$fr_date.' To '.$to_date.'</h2>';
		if(isset($product_group)) 
		$str 	.= '<h2>Product Group : '.$product_group.'</h2>';
		if(isset($region_id)) 
		$str 	.= '<h2>Region Name : '.find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$region_id).'</h2>';
		elseif(isset($zone_id)) 
		$str 	.= '<h2>Zone Name: '.find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id).'</h2>';
		if(isset($dealer_type)) 
		$str 	.= '<h2>Dealer Type : '.$dealer_type.'</h2>';
		$str 	.= '</div>';
		$str 	.= '<div class="left" style="width:100%">';

//		if(isset($allotment_no)) 
//		$str 	.= '<p>Allotment No.: '.$allotment_no.'</p>';
//		$str 	.= '</div><div class="right">';
//		if(isset($client_name)) 
//		$str 	.= '<p>Dealer Name: '.$dealer_name.'</p>';
//		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';
if($_POST['report']==1004) 
{

			if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
			elseif(isset($item_id)) 			{$item_sub_con=' and i.item_id='.$item_id;} 
			
			if(isset($product_group)) 			{$product_group_con=' and i.sales_item_type="'.$product_group.'"';} 
			
			if(isset($t_date)) 
			{$to_date=$t_date; $fr_date=$f_date; $date_con=' and ji_date <="'.$to_date.'"';}
		
		
		$sql='select distinct i.item_id,i.unit_name,i.item_name,"Finished Goods",i.finish_goods_code,i.sales_item_type,i.item_brand,i.pack_size 
		   from item_info i where i.sub_group_id="1096000100010000" '.$item_sub_con.$product_group_con.' order by i.item_brand,i.item_name';
		   
		$query =db_query($sql);
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><td style="border:0px;" colspan="8"><div class="header"><h1>Sajeeb Group</h1><h2><?=$report?></h2>
<h2>Closing Stock of Date-<?=$to_date?></h2></div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>
<th>S/L</th>
<th>Item Brand</th>
<th>Group</th>
<th>FG</th>
<th>Item Name</th>
<th>Unit</th>
<th>Dhaka</th>
<th>Chittagong</th>
<th>Borisal</th>
<th>Bogura</th>
<th>Sylhet</th>
<th>Jessore</th>
<th>Total</th>
</tr>
</thead><tbody>
<?
while($data=mysqli_fetch_object($query)){


$dhaka = 	(int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="3"')/$data->pack_size);
//$ctg = 		(int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="6"')/$data->pack_size);
$ctg = '';
$sylhet =   (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="9"')/$data->pack_size);
$bogura =   (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="7"')/$data->pack_size);
$borisal =  (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="8"')/$data->pack_size);
$jessore =  (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="10"')/$data->pack_size);
$total = 	$dhaka + $ctg + $sylhet + $bogura + $borisal + $jessore;	   

//echo $sql = 'select sum(item_in-item_ex) from journal_item where item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="9"';?>
<tr>
<td><?=++$j?></td>
<td><?=$data->item_brand?></td>
<td><?=$data->sales_item_type?></td>
<td><?=$data->finish_goods_code?></td>
<td><?=$data->item_name?></td>
<td><?=$data->unit_name?></td>
<td style="text-align:right"><?=(int)$dhaka?></td>
<td style="text-align:right"><?=(int)$ctg?></td>
<td style="text-align:right"><?=(int)$borisal?></td>
<td style="text-align:right"><?=(int)$bogura?></td>
<td style="text-align:right"><?=(int)$sylhet?></td>
<td style="text-align:right"><?=(int)$jessore?></td>
<td style="text-align:right"><div align="right">
  <?=(int)$total?>
  &nbsp;</div></td>
</tr>
<?
}
		
?>
</tbody></table>
<?

}elseif($_POST['report']==2) 
{

$sql="select c.id,m.or_no as Damage_No, m.or_no,m.manual_or_no ,c.or_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,i.item_name,c.qty,c.rate,c.amount,w.warehouse_name as depot,d.area_code as area_name,d.dealer_code from 
warehouse_damage_receive m,warehouse_damage_receive_detail c,dealer_info d  , warehouse w ,item_info i
where i.item_id=c.item_id and m.or_no=c.or_no and m.vendor_id=d.dealer_code and w.warehouse_id=d.depot ".$item_con.$depot_con.$date_con.$pg_con.$dealer_con.$dealer_type_con." order by m.manual_or_no desc";

$query = db_query($sql);

echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="9">'.$str.'</td></tr><tr><th>S/L</th><th>Damage No</th><th>Serial No</th><th>Entry Date</th><th>Dealer Name</th><th>Item Name Name</th><th>Cause</th><th>Depot</th><th>Grp</th><th>Rate</th><th>Qty</th><th>DM Total</th><th>Payable DM</th></tr></thead>
<tbody>';

while($data=mysqli_fetch_object($query)){$s++;

$sqld = 'select d.amount,c.damage_cause as total_amt from warehouse_damage_receive_detail d, damage_cause c where c.id=d.receive_type and c.payable="Yes" and d.id='.$data->id;
$info2 = mysqli_fetch_row(db_query($sqld));
$rcv_t = $rcv_t+$data->rcv_amt;
$dp_t = $dp_t+$data->amount;
$tp_t = $tp_t+$info2[0];

?>
<tr><td><?=$s?></td><td><a href="../damage_report/damage_view_print.php?req_no=<?=$data->or_no?>" target="_blank"><?=$data->or_no?></a></td><td><?=$data->manual_or_no?></td><td><?=$data->or_date?></td><td><?=$data->dealer_name?></td><td><?=$data->item_name?></td><td><?=$info2[1];?></td><td><?=$data->depot;?></td><td><?=find_a_field('dealer_info','product_group','dealer_code='.$data->dealer_code);?></td>


<td><?=$data->rate;?></td><td><?=$data->qty;?></td>

<td><?=number_format($data->amount,2)?></td><td><?=number_format($info2[0],2)?></td></tr>
<?
}
?><tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><?=number_format($dp_t,2)?></td><td><?=number_format($tp_t,2)?></td></tr></tbody></table>
<?
}elseif($_POST['report']==1) 
{

$sql="select distinct m.or_no as Damage_No, m.or_no,m.manual_or_no ,c.or_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot,d.area_code as area_name,d.dealer_code from 
warehouse_damage_receive m,warehouse_damage_receive_detail c,dealer_info d  , warehouse w 
where m.or_no=c.or_no and m.vendor_id=d.dealer_code and w.warehouse_id=d.depot ".$depot_con.$date_con.$pg_con.$dealer_con.$dealer_type_con." order by m.manual_or_no desc";

$query = db_query($sql);

echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="9">'.$str.'</td></tr><tr><th>S/L</th><th>Damage No</th><th>Serial No</th><th>Entry Date</th><th>Dealer Name</th><th>Area</th><th>Depot</th><th>Grp</th><th>DM Total</th><th>Payable DM</th></tr></thead>
<tbody>';

while($data=mysqli_fetch_object($query)){$s++;

$sqld = 'select sum(amount) as total_amt from warehouse_damage_receive_detail   where or_no='.$data->or_no;
$info = mysqli_fetch_row(db_query($sqld));
$sqld = 'select sum(d.amount) as total_amt from warehouse_damage_receive_detail d, damage_cause c where c.id=d.receive_type and c.payable="Yes" and d.or_no='.$data->or_no;
$info2 = mysqli_fetch_row(db_query($sqld));
$rcv_t = $rcv_t+$data->rcv_amt;
$dp_t = $dp_t+$info[0];
$tp_t = $tp_t+$info2[0];

?>
<tr><td><?=$s?></td><td><a href="../damage_report/damage_view_print.php?req_no=<?=$data->or_no?>" target="_blank"><?=$data->or_no?></a></td><td><?=$data->manual_or_no?></td><td><?=$data->or_date?></td><td><?=$data->dealer_name?></td><td><?=find_a_field('area','AREA_NAME','AREA_CODE='.$data->area_name)?></td><td><?=$data->depot?></td><td><?=find_a_field('dealer_info','product_group','dealer_code='.$data->dealer_code)?></td><td><?=number_format($info[0],2)?></td><td><?=number_format($info2[0],2)?></td></tr>
<?
}
?><tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><?=number_format($dp_t,2)?></td><td><?=number_format($tp_t,2)?></td></tr></tbody></table>
<?
}

elseif($_POST['report']==21) 
{
	
$report="Item Wise Sales Vs Damage Comparison Report";
$sql="select i.* from item_info i where i.product_nature='Salable' and finish_goods_code>0 and finish_goods_code<5000 order by i.item_name";
$query = db_query($sql);
?><table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="10"><?=$str?></td></tr>
  
  <tr>
    <th rowspan="2">S/L</th>
    <th rowspan="2">FG</th>
    <th rowspan="2">Product Name </th>
    <th colspan="2">Sales</th>
    <th colspan="2">Damage</th>
    <th rowspan="2">Sales (BDT) </th>
    <th rowspan="2">Payable Damage (BDT) </th>
    <th rowspan="2">Ratio</th>
  </tr>
  <tr>
<th>Ctn</th>
<th>Pcs</th>
<th>Ctn</th>
<th>Pcs</th>
</tr></thead>
<tbody>
<?
while($data=mysqli_fetch_object($query)){$s++;
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
$sqld = 'select sum(total_unit) as total_unit,sum(total_amt) as total_amt from sale_do_chalan  where item_id='.$data->item_id.$date_con;
$sales = mysqli_fetch_object(db_query($sqld));
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
$sqld = 'select sum(a.qty) as total_unit,sum(a.amount) as total_amt from warehouse_damage_receive_detail a,damage_cause d   where d.id=a.receive_type and d.payable="Yes" and a.item_id='.$data->item_id.$date_con;
$damage = mysqli_fetch_object(db_query($sqld));
$pdm = (@($damage->total_amt/$sales->total_amt)*100);

if($pdm>5)
$color = 'color:red;';
elseif($pdm>2)
$color = 'color:brown;';
elseif($pdm>0)
$color = 'color:green;';
else
$color = 'color:black;';
?>
<tr>
	<td><?=$s?></td>
	<td><?=$data->finish_goods_code?></td>
	<td><?=$data->item_name?></td>
	<td><div align="right">
	  <?=(int)($sales->total_unit/$data->pack_size);?>
	  </div></td>
	<td><div align="right">
	  <?=(int)($sales->total_unit%$data->pack_size);?>
	</div></td>
	<td><div align="right">
	  <?=(int)($damage->total_unit/$data->pack_size);?>
	  </div></td>
	<td><div align="right">
      <?=(int)($damage->total_unit%$data->pack_size);?>
    </div></td>
	<td><div align="right">
	  <?=number_format($sales->total_amt,2);$s_total = $s_total + $sales->total_amt;?>
	  </div></td>
	<td><div align="right">
	  <?=number_format($damage->total_amt,2);$d_total = $d_total + $damage->total_amt;?>
	  </div></td>
	<td style="font-weight:bold;<?=$color?>"><div align="right">
	  <?=number_format($pdm,2);?>%</div></td>
	</tr>
<?
}
?><tr class="footer"><td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td><div align="right">
    <?=number_format($s_total,2)?>
  </div></td>
  <td><div align="right">
    <?=number_format($d_total,2)?>
  </div></td>
  <td></td></tr></tbody></table>
<?
}
elseif($_POST['report']==111) 
{
$sql="select distinct c.or_no , m.or_no,c.or_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot from 
warehouse_damage_receive m,warehouse_damage_receive_detail c,dealer_info d  , warehouse w
where  m.or_no=c.or_no  and m.vendor_id=d.dealer_code and w.warehouse_id=d.depot and d.dealer_type = 'Corporate'".$depot_con.$date_con.$pg_con.$dealer_con." order by m.or_date,m.or_no";
$query = db_query($sql);
echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="9">'.$str.'</td></tr><tr><th>S/L</th><th>Damage No</th><th>Do No</th><th>Damage Date</th><th>Dealer Name</th><th>Depot</th><th>Total</th><th>Discount</th><th>Net Total</th></tr></thead>
<tbody>';
while($data=mysqli_fetch_object($query)){$s++;
$sqld = 'select sum(total_amt) from warehouse_damage_receive_detail  where Damage_no='.$data->Damage_no;
$info = mysqli_fetch_row(db_query($sqld));
$dp_t = $dp_t+$info[0];
$dis = find_a_field('warehouse_damage_receive','sp_discount','or_no="'.$data->or_no.'"');
$tod = ($info[0]*$dis)/100;
$tot = $info[0]-($info[0]*$dis)/100;
$tod_t = $tod_t + $tod;
$tot_t = $tot_t + $tot;
?>
<tr><td><?=$s?></td><td><a href="Damage_view.php?v_no=<?=$data->Damage_no?>" target="_blank"><?=$data->Damage_no?></a></td><td><?=$data->or_no?></td><td><?=$data->or_date?></td><td><?=$data->dealer_name?></td><td><?=$data->depot?></td><td><?=$info[0]?></td><td><?=$tod?></td><td><?=$tot?></td></tr>
<?
}
echo '<tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>'.number_format($dp_t,2).'</td><td>'.number_format($tod_t,2).'</td><td>'.number_format($tot_t,2).'</td></tr></tbody></table>';

}
elseif($_POST['report']==112) 
{
$sql="select distinct c.or_no , m.or_no,c.or_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot from 
warehouse_damage_receive m,warehouse_damage_receive_detail c,dealer_info d  , warehouse w
where  m.or_no=c.or_no  and m.vendor_id=d.dealer_code and w.warehouse_id=d.depot and d.dealer_type = 'SuperShop'".$depot_con.$date_con.$pg_con.$dealer_con." order by m.or_date,m.or_no";
$query = db_query($sql);
echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="9">'.$str.'</td></tr><tr><th>S/L</th><th>Damage No</th><th>Do No</th><th>Damage Date</th><th>Dealer Name</th><th>Depot</th><th>Total</th><th>Discount</th><th>Net Total</th></tr></thead>
<tbody>';
while($data=mysqli_fetch_object($query)){$s++;
$sqld = 'select sum(total_amt) from warehouse_damage_receive_detail  where Damage_no='.$data->Damage_no;
$info = mysqli_fetch_row(db_query($sqld));
$dp_t = $dp_t+$info[0];
$dis = find_a_field('warehouse_damage_receive','sp_discount','or_no="'.$data->or_no.'"');
$tod = ($info[0]*$dis)/100;
$tot = $info[0]-($info[0]*$dis)/100;
$tod_t = $tod_t + $tod;
$tot_t = $tot_t + $tot;
?>
<tr><td><?=$s?></td><td><a href="Damage_view.php?v_no=<?=$data->Damage_no?>" target="_blank"><?=$data->Damage_no?></a></td><td><?=$data->or_no?></td><td><?=$data->or_date?></td><td><?=$data->dealer_name?></td><td><?=$data->depot?></td><td><?=$info[0]?></td><td><?=$tod?></td><td><?=$tot?></td></tr>
<?
}
echo '<tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>'.number_format($dp_t,2).'</td><td>'.number_format($tod_t,2).'</td><td>'.number_format($tot_t,2).'</td></tr></tbody></table>';

}
elseif($_POST['report']==3) 
{
$sql2 	= "select distinct m.or_no,m.or_no as Damage_no, d.dealer_code,d.dealer_name_e,w.warehouse_name,m.or_date as or_date,d.address_e,d.mobile_no,d.product_group from 
warehouse_damage_receive m, dealer_info d , warehouse w
where m.vendor_id=d.dealer_code and w.warehouse_id=d.depot ".$date_con.$depot_con.$dtype_con.$pg_con.$dealer_con;
$query2 = db_query($sql2);

while($data=mysqli_fetch_object($query2)){
echo '<div style="position:relative;display:block; width:100%; page-break-after:always; page-break-inside:avoid">';
	$dealer_code = $data->dealer_code;
	$Damage_no = $data->Damage_no;
	$dealer_name = $data->dealer_name_e;
	$warehouse_name = $data->warehouse_name;
	$or_date = $data->or_date;
	$or_no = $data->or_no;
		if($dealer_code>0) 
{
$str 	.= '<p style="width:100%">Dealer Name: '.$dealer_name.' - '.$dealer_code.'('.$data->product_group.')</p>';
$str 	.= '<p style="width:100%">Damage NO: '.$Damage_no.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:'.$or_date.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DO NO: '.$or_no.' 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Depot:'.$warehouse_name.'</p>
<p style="width:100%">Destination:'.$data->address_e.'('.$data->mobile_no.')</p>';

$dealer_con = ' and m.vendor_id='.$dealer_code;
$do_con = ' and m.or_no='.$or_no;
$sql = "select concat(i.finish_goods_code,'- ',item_name) as item_name,da.damage_cause,c.qty,c.rate,(c.rate*c.qty) as total_amt from 
warehouse_damage_receive m,warehouse_damage_receive_detail c, item_info i,dealer_info d , warehouse w,damage_cause da
where c.receive_type = da.id and c.or_no='".$or_no."' and  m.or_no=c.or_no and i.item_id=c.item_id and m.vendor_id=d.dealer_code  and w.warehouse_id=d.depot ".$date_con.$item_con.$depot_con.$dtype_con.$do_con." order by m.or_date desc";
}

	echo report_create($sql,1,$str);
		$str = '';
		echo '</div>';
}
}
elseif($_POST['report']==5) 
{
if(isset($region_id)) 
$sqlbranch 	= "select * from branch where BRANCH_ID=".$region_id;
else
$sqlbranch 	= "select * from branch";
$querybranch = db_query($sqlbranch);
while($branch=mysqli_fetch_object($querybranch)){
	$rp=0;
	echo '<div>';
if(isset($zone_id)) 
$sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID." and ZONE_CODE=".$zone_id;
else
$sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID;

	$queryzone = db_query($sqlzone);
	while($zone=mysqli_fetch_object($queryzone)){
if($area_id>0) 
$area_con = "and a.AREA_CODE=".$area_id;
$sql="select m.or_no,m.or_date,concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,w.warehouse_name as depot,a.AREA_NAME as area,d.product_group as grp,(select sum(qty*rate) from warehouse_damage_receive_detail where or_no=m.or_no) as DM_Total from 
warehouse_damage_receive m,dealer_info d  , warehouse w,area a
where   m.vendor_id=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con.$area_con." order by or_no";

$sqlt="select  sum(m.qty*m.rate) as DM_total from 
warehouse_damage_receive_detail m,dealer_info d  , warehouse w,area a
where   m.vendor_id=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con.$area_con;

		$queryt = db_query($sqlt);
		$t= mysqli_fetch_object($queryt);
		if($t->DM_total>0)
		{
			if($rp==0) {$reg_total=0;$dp_total=0; $str .= '<p style="width:100%">Region Name: '.$branch->BRANCH_NAME.' Region</p>';$rp++;}
			$str .= '<p style="width:100%">Zone Name: '.$zone->ZONE_NAME.' Zone</p>';
			echo report_create($sql,1,$str);
			$str = '';
			
			$reg_total= $reg_total+$t->total;
			$DM_total= $DM_total+$t->DM_total;
		}

	}
	
			if($rp>0){
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;"></td></tr></thead>
<tbody>
  <tr class="footer">
    <td align="right"><?=$branch->BRANCH_NAME?> Region   DM Total: <?=number_format($DM_total,2);$DM_total=0;?></td></tr></tbody>
</table><br /><br /><br />
<?  }
	echo '</div>';
}



}
elseif($_POST['report']==9) 
{
if(isset($region_id)) 
$sqlbranch 	= "select * from branch where BRANCH_ID=".$region_id;
else
$sqlbranch 	= "select * from branch";
$querybranch = db_query($sqlbranch);
while($branch=mysqli_fetch_object($querybranch)){
	$rp=0;
	echo '<div>';
if(isset($zone_id)) 
$sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID." and ZONE_CODE=".$zone_id;
else
$sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID;

	$queryzone = db_query($sqlzone);
	while($zone=mysqli_fetch_object($queryzone)){
if($area_id>0) 
$area_con = "and a.AREA_CODE=".$area_id;

$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,
floor(sum(o.total_unit)/o.pkt_size) as crt,
mod(sum(o.total_unit),o.pkt_size) as pcs, 
sum(o.total_amt) as DP,
sum(o.total_unit*o.t_price) as TP
from 
warehouse_damage_receive m,sale_do_details o, item_info i, warehouse w, dealer_info d, area a
where m.or_no=o.or_no and m.vendor_id=d.dealer_code and w.warehouse_id=d.depot and i.item_id=o.item_id and a.AREA_CODE=d.area_code   and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$item_con.$item_brand_con.$pg_con.$area_con.' group by i.finish_goods_code';

$sqlt="select sum(o.t_price*o.total_unit) as total,sum(total_amt) as dp_total
from 
warehouse_damage_receive m,sale_do_details o, item_info i, warehouse w, dealer_info d, area a
where m.or_no=o.or_no and m.vendor_id=d.dealer_code and w.warehouse_id=d.depot and i.item_id=o.item_id and a.AREA_CODE=d.area_code   and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$item_con.$item_brand_con.$pg_con.$area_con.'';

		$queryt = db_query($sqlt);
		$t= mysqli_fetch_object($queryt);
		if($t->total>0)
		{
			if($rp==0) {$reg_total=0;$dp_total=0; 
			$str .= '<p style="width:100%">Region Name: '.$branch->BRANCH_NAME.' Region</p>';$rp++;}
			$str .= '<p style="width:100%">Zone Name: '.$zone->ZONE_NAME.' Zone</p>';
			echo report_create($sql,1,$str);
			$str = '';
			
			$reg_total= $reg_total+$t->total;
			$dp_total= $dp_total+$t->dp_total;
		}

	}
	
			if($rp>0){
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;"></td></tr></thead>
<tbody>
  <tr class="footer">
    <td align="right"><?=$branch->BRANCH_NAME?> Region  DP Total: <?=number_format($dp_total,2)?> ||| TP Total: <?=number_format($reg_total,2)?></td></tr></tbody>
</table><br /><br /><br />
<?  }
	echo '</div>';
}



}
elseif($_POST['report']==8) 
{
if(isset($region_id)) 
$sqlbranch 	= "select * from branch where BRANCH_ID=".$region_id;
else
$sqlbranch 	= "select * from branch";
$querybranch = db_query($sqlbranch);
while($branch=mysqli_fetch_object($querybranch)){
	$rp=0;
	echo '<div>';
if(isset($zone_id)) 
$sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID." and ZONE_CODE=".$zone_id;
else
$sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID;

	$queryzone = db_query($sqlzone);
	while($zone=mysqli_fetch_object($queryzone)){
if(isset($area_id)) 
{
$sql="select concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,w.warehouse_name as depot,a.AREA_NAME as area,d.product_group as grp,(select sum(total_amt) from sale_do_details where or_no=m.or_no) as DP_Total,(select sum(t_price*total_unit) from sale_do_details where or_no=m.or_no)  as TP_Total from 
warehouse_damage_receive m,dealer_info d  , warehouse w,area a
where   m.vendor_id=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." and a.AREA_CODE=".$area_id." ".$date_con.$pg_con." order by or_no";
$sqlt="select sum(s.t_price*s.total_unit) as total,sum(total_amt) as dp_total from 
warehouse_damage_receive m,dealer_info d  , warehouse w,area a,sale_do_details s
where   m.vendor_id=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and s.or_no=m.or_no and a.AREA_CODE=".$area_id." and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con;
}
else
{
$sql="select concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,w.warehouse_name as depot,a.AREA_NAME as area,d.product_group as grp,(select sum(total_amt) from sale_do_details where or_no=m.or_no) as DP_Total,(select sum(t_price*total_unit) from sale_do_details where or_no=m.or_no)  as TP_Total from 
warehouse_damage_receive m,dealer_info d  , warehouse w,area a
where   m.vendor_id=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con." order by or_no";
$sqlt="select sum(s.t_price*s.total_unit) as total,sum(total_amt) as dp_total from 
warehouse_damage_receive m,dealer_info d  , warehouse w,area a,sale_do_details s
where   m.vendor_id=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and s.or_no=m.or_no and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con;
}
		$queryt = db_query($sqlt);
		$t= mysqli_fetch_object($queryt);
		if($t->total>0)
		{
			if($rp==0) {$reg_total=0;$dp_total=0; $str .= '<p style="width:100%">Region Name: '.$branch->BRANCH_NAME.' Region</p>';$rp++;}
			$str .= '<p style="width:100%">Zone Name: '.$zone->ZONE_NAME.' Zone</p>';
			echo report_create($sql,1,$str);
			$str = '';
			
			$reg_total= $reg_total+$t->total;
			$dp_total= $dp_total+$t->dp_total;
		}

	}
	
			if($rp>0){
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;"></td></tr></thead>
<tbody>
  <tr class="footer">
    <td align="right"><?=$branch->BRANCH_NAME?> Region  DP Total: <?=number_format($dp_total,2)?> ||| TP Total: <?=number_format($reg_total,2)?></td></tr></tbody>
</table><br /><br /><br />
<?  }
	echo '</div>';
}



}

elseif($_REQUEST['report']==107) 
{
echo $str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td bgcolor="#333333"><span class="style3 style1">S/L</span></td>
    <td bgcolor="#333333"><span class="style3 style1">REGION NAME </span></td>

<td colspan="4" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES</span></div></td>

    <td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
    <td colspan="4" bgcolor="#333333"><div align="center" class="style1"><span class="style3">DAMAGE</span></div></td>
    <td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
    <td colspan="4" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES/DAMAGE RATIO</span></div></td>
  </tr>
	<tr>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
	</tr>
 <?
 

if(isset($item_id)) 		{$con=' and c.item_id="'.$item_id.'"';}
$sql = "select BRANCH_ID,BRANCH_NAME from branch  order by BRANCH_NAME";

$query = @db_query($sql);
while($item=@mysqli_fetch_object($query)){

$BRANCH_ID = $item->BRANCH_ID;


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a, zon z where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'sqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a, zon z where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'sqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a, zon z where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'sqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a, zon z where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'sqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'totala'} = ${'totala'} + ${'sqlmona'}[0];
${'totalb'} = ${'totalb'} + ${'sqlmonb'}[0];
${'totalc'} = ${'totalc'} + ${'sqlmonc'}[0];
${'totalm'} = ${'totalm'} + ${'sqlmonm'}[0];

${'total'} = ${'sqlmona'}[0] + ${'sqlmonb'}[0] + ${'sqlmonc'}[0] + ${'sqlmonm'}[0];

${'totalall'} = ${'totalall'} + ${'total'};
${'totalr'.$BRANCH_ID} = ${'totalr'.$BRANCH_ID} + ${'total'};

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a, zon z,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'dsqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a, zon z,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'dsqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a, zon z ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'dsqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a, zon z ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'dsqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'dtotala'} = ${'dtotala'} + ${'dsqlmona'}[0];
${'dtotalb'} = ${'dtotalb'} + ${'dsqlmonb'}[0];
${'dtotalc'} = ${'dtotalc'} + ${'dsqlmonc'}[0];
${'dtotalm'} = ${'dtotalm'} + ${'dsqlmonm'}[0];

${'dtotal'} = ${'dsqlmona'}[0] + ${'dsqlmonb'}[0] + ${'dsqlmonc'}[0] + ${'dsqlmonm'}[0];

${'dtotalall'} = ${'dtotalall'} + ${'dtotal'};
${'dtotalr'.$BRANCH_ID} = ${'dtotalr'.$BRANCH_ID} + ${'dtotal'};
?>
  
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><?=$item->BRANCH_NAME?></td>

<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $totalallr= $totalallr + ${'totalr'.$BRANCH_ID};echo number_format(${'totalr'.$BRANCH_ID},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $dtotalallr= $dtotalallr + ${'dtotalr'.$BRANCH_ID};echo number_format(${'dtotalr'.$BRANCH_ID},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmona'}[0]/${'sqlmona'}[0])*100),2);?>%
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonb'}[0]/${'sqlmonb'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonc'}[0]/${'sqlmonc'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonm'}[0]/${'sqlmonm'}[0])*100),2);?>
  %</div></td>
  </tr>
  <? }




$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Corporate'".$con;

${'sqlmonco'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d where c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Corporate'".$con;

${'dsqlmonco'} = mysqli_fetch_row(db_query($sqql));
  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td>&nbsp;</td>
      <td><strong>D Total</strong></td>

<td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totala'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totalb'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalc'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalm'}),2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($totalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotala'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalb'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalc'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalm'},2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($dtotalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotala'}*100/${'totala'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalb'}*100/${'totalb'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalc'}*100/${'totalc'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalm'}/${'totalm'},2);?>
  %</div></td>
    </tr>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td>Corporate</td>
	

<td colspan="4" bgcolor="#99CCFF"><div align="center">
  <?=number_format(${'sqlmonco'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <?=number_format(${'sqlmonco'}[0],2);?>
</strong></div></td>
<td colspan="4" bgcolor="#99CCFF"><div align="center">
  <?=number_format(${'dsqlmonco'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <?=number_format(${'dsqlmonco'}[0],2);?>
</strong></div></td>
<td colspan="4" bgcolor="#99CCFF"><div align="center">
  <?=@number_format(${'dsqlmonco'}[0]*100/${'sqlmonco'}[0],2);?>
  %</div></td>
    </tr>
	<?


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'sqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'totalsu'} = ${'totalsu'} + ${'sqlmonsu'}[0];

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d where c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'dsqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'dtotalsu'} = ${'dtotalsu'} + ${'dsqlmonsu'}[0];

?>
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
<td><?=++$j?></td>
<td>SuperShop</td>

<td colspan="4" bgcolor="#99CCFF"><div align="center">
  <?=number_format(${'sqlmonsu'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <?=number_format(${'sqlmonsu'}[0],2);?>
</strong></div></td>
<td colspan="4" bgcolor="#99CCFF"><div align="center">
  <?=number_format(${'dsqlmonsu'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <?=number_format(${'dsqlmonsu'}[0],2);?>
</strong></div></td>
<td colspan="4" bgcolor="#99CCFF"><div align="center">
  <?=@number_format(${'dsqlmonsu'}[0]*100/${'sqlmonsu'}[0],2);?>
  %</div></td>
</tr>
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
  <td>&nbsp;</td>
  <td><strong>Corporate+SuperShop</strong></td>


<td colspan="4" bgcolor="#FFFF66"><div align="center">
  <?=number_format(($sqlmonsu[0]+$sqlmonco[0]),2);?>
</div></td>

<td bgcolor="#FFFF99"><div align="right">
  <?=number_format(($sqlmonsu[0]+$sqlmonco[0]),2);?>
</div></td>
<td colspan="4" bgcolor="#FFFF66"><div align="center">
  <?=number_format(($dsqlmonsu[0]+$dsqlmonco[0]),2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format(($dsqlmonsu[0]+$dsqlmonco[0]),2);?>
</div></td>
<td colspan="4" bgcolor="#FFFF66"><div align="center">
  <?=@number_format(($dsqlmonsu[0]+$dsqlmonco[0])*100/($sqlmonsu[0]+$sqlmonco[0]),2);?>
  %</div></td>
</tr>
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
<td>&nbsp;</td>
<td><strong>N Total</strong>  <div align="center"></div></td>
<td colspan="4">&nbsp;</td>
<?

${'totalallall'} = ${'totalallall'} + (${'totalc'}+${'totals'}+${'totalco'});
?>
<td bgcolor="#FF3333"><div align="right"><strong>
  <?=number_format(($sqlmonsu[0]+$sqlmonco[0]+$totalall),2);?>
</strong></div></td>
<td colspan="4">&nbsp;</td>
<td bgcolor="#FF3333"><div align="right"><strong>
  <?=number_format(($dsqlmonsu[0]+$dsqlmonco[0]+$dtotalall),2);?>
</strong></div></td>
<td colspan="4" bgcolor="#FF9999"><div align="center"><strong>
  <?=@number_format(($dsqlmonsu[0]+$dsqlmonco[0]+$dtotalall)*100/($sqlmonsu[0]+$sqlmonco[0]+$totalall),2);?>
  %</strong></div></td>
</tr>
</table></td>
</tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
<?
	$f_date = date((date('Y',strtotime($f_date))-1).'-m-d',strtotime($f_date));
	$t_date = date((date('Y',strtotime($t_date))-1).'-m-d',strtotime($t_date));
?>
  <tr>
    <td bgcolor="#99CCCC"><div align="center"><span class="style2">Last Year Same Time Position<br />Period: <?=$f_date?> to <?=$t_date?></span></div></td>
</tr>  <tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>
<?
${'totala'} = 0;
${'totalb'} = 0;
${'totalc'} = 0;
${'totalm'} = 0;

${'total'} = 0;
${'totalall'} = 0;

${'dtotala'} = 0;
${'dtotalb'} = 0;
${'dtotalc'} = 0;
${'dtotalm'} = 0;


${'dtotalall'} = 0;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td bgcolor="#333333"><span class="style3 style1">S/L</span></td>
    <td bgcolor="#333333"><span class="style3 style1">REGION NAME </span></td>

<td colspan="4" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES</span></div></td>

    <td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
    <td colspan="4" bgcolor="#333333"><div align="center" class="style1"><span class="style3">DAMAGE</span></div></td>
    <td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
    <td colspan="4" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES/DAMAGE RATIO</span></div></td>
  </tr>
	<tr>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
	</tr>
 <?
 ${'totalr'.$BRANCH_ID} = 0 ;
${'dtotalr'.$BRANCH_ID} = 0;
if(isset($item_id)) 		{$con=' and c.item_id="'.$item_id.'"';}
$sql = "select BRANCH_ID,BRANCH_NAME from branch  order by BRANCH_NAME";

$query = @db_query($sql);
while($item=@mysqli_fetch_object($query)){

$BRANCH_ID = $item->BRANCH_ID;


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a, zon z where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'sqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a, zon z where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'sqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a, zon z where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'sqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a, zon z where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'sqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'totala'} = ${'totala'} + ${'sqlmona'}[0];
${'totalb'} = ${'totalb'} + ${'sqlmonb'}[0];
${'totalc'} = ${'totalc'} + ${'sqlmonc'}[0];
${'totalm'} = ${'totalm'} + ${'sqlmonm'}[0];

${'total'} = ${'sqlmona'}[0] + ${'sqlmonb'}[0] + ${'sqlmonc'}[0] + ${'sqlmonm'}[0];

${'totalall'} = ${'totalall'} + ${'total'};

${'totalr'.$BRANCH_ID} = ${'totalr'.$BRANCH_ID} + ${'total'};

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a, zon z ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'dsqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a, zon z ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'dsqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a, zon z ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'dsqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a, zon z ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'dsqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'dtotala'} = ${'dtotala'} + ${'dsqlmona'}[0];
${'dtotalb'} = ${'dtotalb'} + ${'dsqlmonb'}[0];
${'dtotalc'} = ${'dtotalc'} + ${'dsqlmonc'}[0];
${'dtotalm'} = ${'dtotalm'} + ${'dsqlmonm'}[0];

${'dtotal'} = ${'dsqlmona'}[0] + ${'dsqlmonb'}[0] + ${'dsqlmonc'}[0] + ${'dsqlmonm'}[0];

${'dtotalall'} = ${'dtotalall'} + ${'dtotal'};

${'dtotalr'.$BRANCH_ID} = ${'dtotalr'.$BRANCH_ID} + ${'dtotal'};
?>
  
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><a target="_blank" href="?report=108&region_id=<?=$BRANCH_ID?>&f_date=<?=$_REQUEST['f_date']?>&t_date=<?=$_REQUEST['t_date']?>"><?=$item->BRANCH_NAME?></td>

<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $totalallr= $totalallr + ${'totalr'.$BRANCH_ID};echo number_format(${'totalr'.$BRANCH_ID},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $dtotalallr= $dtotalallr + ${'dtotalr'.$BRANCH_ID};echo number_format(${'dtotalr'.$BRANCH_ID},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmona'}[0]/${'sqlmona'}[0])*100),2);?>%
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonb'}[0]/${'sqlmonb'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonc'}[0]/${'sqlmonc'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonm'}[0]/${'sqlmonm'}[0])*100),2);?>
  %</div></td>
  </tr>
  <? }




$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Corporate'".$con;

${'sqlmonco'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d where c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Corporate'".$con;

${'dsqlmonco'} = mysqli_fetch_row(db_query($sqql));
  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td>&nbsp;</td>
      <td><strong>D Total</strong></td>

<td bgcolor="#FFFF66"><div align="right"><?=number_format((${'totala'}),2);?></div></td>
<td bgcolor="#FFFF66"><div align="right"><?=number_format((${'totalb'}),2);?></div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalc'}),2);?></div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalm'}),2);?></div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($totalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotala'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalb'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalc'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalm'},2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($dtotalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotala'}*100/${'totala'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotala'}*100/${'totalb'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalb'}*100/${'totalc'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalm'}/${'totalm'},2);?>
  %</div></td>
    </tr>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td>Corporate</td>
	

<td colspan="4" bgcolor="#99CCFF"><div align="center">
  <?=number_format(${'sqlmonco'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <?=number_format(${'sqlmonco'}[0],2);?>
</strong></div></td>
<td colspan="4" bgcolor="#99CCFF"><div align="center">
  <?=number_format(${'dsqlmonco'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <?=number_format(${'dsqlmonco'}[0],2);?>
</strong></div></td>
<td colspan="4" bgcolor="#99CCFF"><div align="center">
  <?=@number_format(${'dsqlmonco'}[0]*100/${'sqlmonco'}[0],2);?>
  %</div></td>
    </tr>
	<?


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'sqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'totalsu'} = ${'totalsu'} + ${'sqlmonsu'}[0];

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d where c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'dsqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'dtotalsu'} = ${'dtotalsu'} + ${'dsqlmonsu'}[0];

?>
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
<td><?=++$j?></td>
<td>SuperShop</td>

<td colspan="4" bgcolor="#99CCFF"><div align="center">
  <?=number_format(${'sqlmonsu'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <?=number_format(${'sqlmonsu'}[0],2);?>
</strong></div></td>
<td colspan="4" bgcolor="#99CCFF"><div align="center">
  <?=number_format(${'dsqlmonsu'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <?=number_format(${'dsqlmonsu'}[0],2);?>
</strong></div></td>
<td colspan="4" bgcolor="#99CCFF"><div align="center">
  <?=@number_format(${'dsqlmonsu'}[0]*100/${'sqlmonsu'}[0],2);?>
  %</div></td>
</tr>
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
  <td>&nbsp;</td>
  <td><strong>Corporate+SuperShop</strong></td>


<td colspan="4" bgcolor="#FFFF66"><div align="center">
  <?=number_format(($sqlmonsu[0]+$sqlmonco[0]),2);?>
</div></td>

<td bgcolor="#FFFF99"><div align="right">
  <?=number_format(($sqlmonsu[0]+$sqlmonco[0]),2);?>
</div></td>
<td colspan="4" bgcolor="#FFFF66"><div align="center">
  <?=number_format(($dsqlmonsu[0]+$dsqlmonco[0]),2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format(($dsqlmonsu[0]+$dsqlmonco[0]),2);?>
</div></td>
<td colspan="4" bgcolor="#FFFF66"><div align="center">
  <?=@number_format(($dsqlmonsu[0]+$dsqlmonco[0])*100/($sqlmonsu[0]+$sqlmonco[0]),2);?>
  %</div></td>
</tr>
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
<td>&nbsp;</td>
<td><strong>N Total</strong>  <div align="center"></div></td>
<td colspan="4">&nbsp;</td>
<?
${'totalallall'} = ${'totalallall'} + (${'totalc'}+${'totals'}+${'totalco'});
?>
<td bgcolor="#FF3333"><div align="right"><strong>
  <?=number_format(($sqlmonsu[0]+$sqlmonco[0]+$totalall),2);?>
</strong></div></td>
<td colspan="4">&nbsp;</td>
<td bgcolor="#FF3333"><div align="right"><strong>
  <?=number_format(($dsqlmonsu[0]+$dsqlmonco[0]+$dtotalall),2);?>
</strong></div></td>
<td colspan="4" bgcolor="#FF9999"><div align="center"><strong>
  <?=@number_format(($dsqlmonsu[0]+$dsqlmonco[0]+$dtotalall)*100/($sqlmonsu[0]+$sqlmonco[0]+$totalall),2);?>
  %</strong></div></td>
</tr>
</table></td>
  </tr>
</table>
<?
}
elseif($_REQUEST['report']==108) 
{
echo $str;

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td bgcolor="#333333"><span class="style3 style1">S/L</span></td>
    <td bgcolor="#333333"><span class="style3 style1">ZONE NAME </span></td>

<td colspan="4" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES</span></div></td>

    <td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
    <td colspan="4" bgcolor="#333333"><div align="center" class="style1"><span class="style3">DAMAGE</span></div></td>
    <td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
    <td colspan="4" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES/DAMAGE RATIO</span></div></td>
  </tr>
	<tr>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
	</tr>
 <?
 

if(isset($item_id)) 		{$con=' and c.item_id="'.$item_id.'"';}
$sql = "select ZONE_CODE,ZONE_NAME from zon where REGION_ID=".$_POST['region_id']." order by ZONE_NAME";

$query = @db_query($sql);
while($item=@mysqli_fetch_object($query)){

$ZONE_CODE = $item->ZONE_CODE;


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'sqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'sqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'sqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'sqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'totala'} = ${'totala'} + ${'sqlmona'}[0];
${'totalb'} = ${'totalb'} + ${'sqlmonb'}[0];
${'totalc'} = ${'totalc'} + ${'sqlmonc'}[0];
${'totalm'} = ${'totalm'} + ${'sqlmonm'}[0];

${'total'} = ${'sqlmona'}[0] + ${'sqlmonb'}[0] + ${'sqlmonc'}[0] + ${'sqlmonm'}[0];

${'totalall'} = ${'totalall'} + ${'total'};
${'totalr'.$ZONE_CODE} = ${'totalr'.$ZONE_CODE} + ${'total'};

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'dsqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'dsqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'dsqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'dsqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'dtotala'} = ${'dtotala'} + ${'dsqlmona'}[0];
${'dtotalb'} = ${'dtotalb'} + ${'dsqlmonb'}[0];
${'dtotalc'} = ${'dtotalc'} + ${'dsqlmonc'}[0];
${'dtotalm'} = ${'dtotalm'} + ${'dsqlmonm'}[0];

${'dtotal'} = ${'dsqlmona'}[0] + ${'dsqlmonb'}[0] + ${'dsqlmonc'}[0] + ${'dsqlmonm'}[0];

${'dtotalall'} = ${'dtotalall'} + ${'dtotal'};
${'dtotalr'.$ZONE_CODE} = ${'dtotalr'.$ZONE_CODE} + ${'dtotal'};
?>
  
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><?=$item->ZONE_NAME?></td>

<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $totalallr= $totalallr + ${'totalr'.$ZONE_CODE};echo number_format(${'totalr'.$ZONE_CODE},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $dtotalallr= $dtotalallr + ${'dtotalr'.$ZONE_CODE};echo number_format(${'dtotalr'.$ZONE_CODE},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmona'}[0]/${'sqlmona'}[0])*100),2);?>%
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonb'}[0]/${'sqlmonb'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonc'}[0]/${'sqlmonc'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonm'}[0]/${'sqlmonm'}[0])*100),2);?>
  %</div></td>
  </tr>
  <? }



  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td colspan="2"><strong>Total</strong></td>
      <td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totala'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totalb'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalc'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalm'}),2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($totalall,2);$totalall=0;?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotala'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalb'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalc'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalm'},2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($dtotalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotala'}*100/${'totala'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalb'}*100/${'totalb'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalc'}*100/${'totalc'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalm'}/${'totalm'},2);?>
  %</div></td>
    </tr>
    
	<?


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'sqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'totalsu'} = ${'totalsu'} + ${'sqlmonsu'}[0];

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d where c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'dsqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'dtotalsu'} = ${'dtotalsu'} + ${'dsqlmonsu'}[0];

?>

</table></td>
</tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
<?
	$f_date = date((date('Y',strtotime($f_date))-1).'-m-d',strtotime($f_date));
	$t_date = date((date('Y',strtotime($t_date))-1).'-m-d',strtotime($t_date));
?>
  <tr>
    <td bgcolor="#99CCCC"><div align="center"><span class="style2">Last Year Same Time Position<br />Period: <?=$f_date?> to <?=$t_date?></span></div></td>
</tr>  <tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>
<?
${'totala'} = 0;
${'totalb'} = 0;
${'totalc'} = 0;
${'totalm'} = 0;

${'total'} = 0;
${'totalall'} = 0;

${'dtotala'} = 0;
${'dtotalb'} = 0;
${'dtotalc'} = 0;
${'dtotalm'} = 0;

${'dtotalall'} = 0;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td bgcolor="#333333"><span class="style3 style1">S/L</span></td>
    <td bgcolor="#333333"><span class="style3 style1">ZONE NAME </span></td>

<td colspan="4" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES</span></div></td>

    <td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
    <td colspan="4" bgcolor="#333333"><div align="center" class="style1"><span class="style3">DAMAGE</span></div></td>
    <td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
    <td colspan="4" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES/DAMAGE RATIO</span></div></td>
  </tr>
	<tr>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
	</tr>
 <?
 ${'totalr'.$ZONE_CODE} = 0 ;
${'dtotalr'.$ZONE_CODE} = 0;
if(isset($item_id)) 		{$con=' and c.item_id="'.$item_id.'"';}
$sql = "select ZONE_CODE,ZONE_NAME from zon where REGION_ID=".$_POST['region_id']." order by ZONE_NAME";

$query = @db_query($sql);
while($item=@mysqli_fetch_object($query)){

$ZONE_CODE = $item->ZONE_CODE;
${'totalr'.$ZONE_CODE} = 0;

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'sqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'sqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'sqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'sqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'totala'} = ${'totala'} + ${'sqlmona'}[0];
${'totalb'} = ${'totalb'} + ${'sqlmonb'}[0];
${'totalc'} = ${'totalc'} + ${'sqlmonc'}[0];
${'totalm'} = ${'totalm'} + ${'sqlmonm'}[0];

${'total'} = ${'sqlmona'}[0] + ${'sqlmonb'}[0] + ${'sqlmonc'}[0] + ${'sqlmonm'}[0];

${'totalall'} = ${'totalall'} + ${'total'};

${'totalr'.$ZONE_CODE} = ${'totalr'.$ZONE_CODE} + ${'total'};

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'dsqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'dsqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'dsqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'dsqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'dtotala'} = ${'dtotala'} + ${'dsqlmona'}[0];
${'dtotalb'} = ${'dtotalb'} + ${'dsqlmonb'}[0];
${'dtotalc'} = ${'dtotalc'} + ${'dsqlmonc'}[0];
${'dtotalm'} = ${'dtotalm'} + ${'dsqlmonm'}[0];

${'dtotal'} = ${'dsqlmona'}[0] + ${'dsqlmonb'}[0] + ${'dsqlmonc'}[0] + ${'dsqlmonm'}[0];

${'dtotalall'} = ${'dtotalall'} + ${'dtotal'};

${'dtotalr'.$ZONE_CODE} = ${'dtotalr'.$ZONE_CODE} + ${'dtotal'};
?>
  
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><?=$item->ZONE_NAME?></td>

<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $totalallr= $totalallr + ${'totalr'.$ZONE_CODE};echo number_format(${'totalr'.$ZONE_CODE},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $dtotalallr= $dtotalallr + ${'dtotalr'.$ZONE_CODE};echo number_format(${'dtotalr'.$ZONE_CODE},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmona'}[0]/${'sqlmona'}[0])*100),2);?>%
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonb'}[0]/${'sqlmonb'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonc'}[0]/${'sqlmonc'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonm'}[0]/${'sqlmonm'}[0])*100),2);?>
  %</div></td>
  </tr>
  <? }



  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td colspan="2"><strong>Total</strong></td>
      <td bgcolor="#FFFF66"><div align="right"><?=number_format((${'totala'}),2);?></div></td>
<td bgcolor="#FFFF66"><div align="right"><?=number_format((${'totalb'}),2);?></div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalc'}),2);?></div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalm'}),2);?></div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($totalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotala'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalb'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalc'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalm'},2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($dtotalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotala'}*100/${'totala'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotala'}*100/${'totalb'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalb'}*100/${'totalc'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalm'}/${'totalm'},2);?>
  %</div></td>
    </tr>
    
	<?


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'sqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'totalsu'} = ${'totalsu'} + ${'sqlmonsu'}[0];

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d where c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'dsqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'dtotalsu'} = ${'dtotalsu'} + ${'dsqlmonsu'}[0];

?>
</table></td>
  </tr>
</table>
<?
}
elseif($_REQUEST['report']==109) 
{
echo $str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
	<td bgcolor="#333333"><span class="style3 style1">S/L</span></td>
	<td bgcolor="#333333"><span class="style3 style1">ZONE NAME </span></td>
	<td colspan="4" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES</span></div></td>
	<td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
	<td colspan="4" bgcolor="#333333"><div align="center" class="style1"><span class="style3">DAMAGE</span></div></td>
	<td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
	<td colspan="4" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES/DAMAGE RATIO</span></div></td>
  </tr>
	<tr>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
	</tr>
<?
if(isset($item_id)) {$con=' and c.item_id="'.$item_id.'"';}
$sql = "select d.dealer_code,d.dealer_name_e as dealer_name,a.AREA_NAME as area from area a,dealer_info d where d.area_code=a.AREA_CODE and a.ZONE_ID=".$_POST['zone_id']." order by dealer_name_e";

$query = @db_query($sql);
while($dealer=@mysqli_fetch_object($query)){

$dealer_code = $dealer->dealer_code;


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and  d.dealer_code='".$dealer_code."'".$con;
${'sqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and  d.dealer_code='".$dealer_code."'".$con;
${'sqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and  d.dealer_code='".$dealer_code."'".$con;
${'sqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and  d.dealer_code='".$dealer_code."'".$con;
${'sqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'totala'} = ${'totala'} + ${'sqlmona'}[0];
${'totalb'} = ${'totalb'} + ${'sqlmonb'}[0];
${'totalc'} = ${'totalc'} + ${'sqlmonc'}[0];
${'totalm'} = ${'totalm'} + ${'sqlmonm'}[0];

${'total'} = ${'sqlmona'}[0] + ${'sqlmonb'}[0] + ${'sqlmonc'}[0] + ${'sqlmonm'}[0];

${'totalall'} = ${'totalall'} + ${'total'};
${'totalr'.$dealer_code} = ${'totalr'.$dealer_code} + ${'total'};

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and  d.dealer_code='".$dealer_code."'".$con;
${'dsqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and  d.dealer_code='".$dealer_code."'".$con;
${'dsqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and  d.dealer_code='".$dealer_code."'".$con;
${'dsqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and  d.dealer_code='".$dealer_code."'".$con;
${'dsqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'dtotala'} = ${'dtotala'} + ${'dsqlmona'}[0];
${'dtotalb'} = ${'dtotalb'} + ${'dsqlmonb'}[0];
${'dtotalc'} = ${'dtotalc'} + ${'dsqlmonc'}[0];
${'dtotalm'} = ${'dtotalm'} + ${'dsqlmonm'}[0];

${'dtotal'} = ${'dsqlmona'}[0] + ${'dsqlmonb'}[0] + ${'dsqlmonc'}[0] + ${'dsqlmonm'}[0];

${'dtotalall'} = ${'dtotalall'} + ${'dtotal'};
${'dtotalr'.$dealer_code} = ${'dtotalr'.$dealer_code} + ${'dtotal'};
?>
  
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><?=$dealer->dealer_name?></td>

<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $totalallr= $totalallr + ${'totalr'.$dealer_code};echo number_format(${'totalr'.$dealer_code},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $dtotalallr= $dtotalallr + ${'dtotalr'.$dealer_code};echo number_format(${'dtotalr'.$dealer_code},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmona'}[0]/${'sqlmona'}[0])*100),2);?>%
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonb'}[0]/${'sqlmonb'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonc'}[0]/${'sqlmonc'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonm'}[0]/${'sqlmonm'}[0])*100),2);?>
  %</div></td>
  </tr>
  <? }



  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td colspan="2"><strong>Total</strong></td>
      <td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totala'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totalb'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalc'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalm'}),2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($totalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotala'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalb'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalc'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalm'},2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($dtotalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotala'}*100/${'totala'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalb'}*100/${'totalb'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalc'}*100/${'totalc'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalm'}/${'totalm'},2);?>
  %</div></td>
    </tr>
    
	<?


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'sqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'totalsu'} = ${'totalsu'} + ${'sqlmonsu'}[0];

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d where c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'dsqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'dtotalsu'} = ${'dtotalsu'} + ${'dsqlmonsu'}[0];

?>

</table></td>
</tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
<?
	$f_date = date((date('Y',strtotime($f_date))-1).'-m-d',strtotime($f_date));
	$t_date = date((date('Y',strtotime($t_date))-1).'-m-d',strtotime($t_date));
?>
  <tr>
    <td bgcolor="#99CCCC"><div align="center"><span class="style2">Last Year Same Time Position<br />Period: <?=$f_date?> to <?=$t_date?></span></div></td>
</tr>  <tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>
<?
${'totala'} = 0;
${'totalb'} = 0;
${'totalc'} = 0;
${'totalm'} = 0;

${'total'} = 0;
${'totalall'} = 0;

${'dtotala'} = 0;
${'dtotalb'} = 0;
${'dtotalc'} = 0;
${'dtotalm'} = 0;


${'dtotalall'} = 0;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td bgcolor="#333333"><span class="style3 style1">S/L</span></td>
    <td bgcolor="#333333"><span class="style3 style1">ZONE NAME </span></td>

<td colspan="4" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES</span></div></td>

    <td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
    <td colspan="4" bgcolor="#333333"><div align="center" class="style1"><span class="style3">DAMAGE</span></div></td>
    <td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
    <td colspan="4" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES/DAMAGE RATIO</span></div></td>
  </tr>
	<tr>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
	</tr>
 <?
 $j=0;
 ${'totalr'.$dealer_code} = 0 ;
${'dtotalr'.$dealer_code} = 0;
if(isset($item_id)) 		{$con=' and c.item_id="'.$item_id.'"';}
$sql = "select d.dealer_code,d.dealer_name_e as dealer_name,a.AREA_NAME as area from area a,dealer_info d where d.area_code=a.AREA_CODE and a.ZONE_ID=".$_POST['zone_id']." order by dealer_name_e";

$query = @db_query($sql);
while($dealer=@mysqli_fetch_object($query)){
${'totalr'.$dealer_code} = 0;
$dealer_code = $dealer->dealer_code;


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and  d.dealer_code='".$dealer_code."'".$con;
${'sqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and  d.dealer_code='".$dealer_code."'".$con;
${'sqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and  d.dealer_code='".$dealer_code."'".$con;
${'sqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and  d.dealer_code='".$dealer_code."'".$con;
${'sqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'totala'} = ${'totala'} + ${'sqlmona'}[0];
${'totalb'} = ${'totalb'} + ${'sqlmonb'}[0];
${'totalc'} = ${'totalc'} + ${'sqlmonc'}[0];
${'totalm'} = ${'totalm'} + ${'sqlmonm'}[0];

${'total'} = ${'sqlmona'}[0] + ${'sqlmonb'}[0] + ${'sqlmonc'}[0] + ${'sqlmonm'}[0];

${'totalall'} = ${'totalall'} + ${'total'};

${'totalr'.$dealer_code} = ${'totalr'.$dealer_code} + ${'total'};

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and  d.dealer_code='".$dealer_code."'".$con;
${'dsqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and  d.dealer_code='".$dealer_code."'".$con;
${'dsqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and  d.dealer_code='".$dealer_code."'".$con;
${'dsqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and  d.dealer_code='".$dealer_code."'".$con;
${'dsqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'dtotala'} = ${'dtotala'} + ${'dsqlmona'}[0];
${'dtotalb'} = ${'dtotalb'} + ${'dsqlmonb'}[0];
${'dtotalc'} = ${'dtotalc'} + ${'dsqlmonc'}[0];
${'dtotalm'} = ${'dtotalm'} + ${'dsqlmonm'}[0];

${'dtotal'} = ${'dsqlmona'}[0] + ${'dsqlmonb'}[0] + ${'dsqlmonc'}[0] + ${'dsqlmonm'}[0];

${'dtotalall'} = ${'dtotalall'} + ${'dtotal'};

${'dtotalr'.$dealer_code} = ${'dtotalr'.$dealer_code} + ${'dtotal'};

?>
  
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><?=$dealer->dealer_name?></td>

<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $totalallr= $totalallr + ${'totalr'.$dealer_code}; echo number_format(${'total'},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $dtotalallr= $dtotalallr + ${'dtotalr'.$dealer_code};echo number_format(${'dtotalr'.$dealer_code},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmona'}[0]/${'sqlmona'}[0])*100),2);?>%
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonb'}[0]/${'sqlmonb'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonc'}[0]/${'sqlmonc'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonm'}[0]/${'sqlmonm'}[0])*100),2);?>
  %</div></td>
  </tr>
  <? }



  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td colspan="2"><strong>Total</strong></td>
      <td bgcolor="#FFFF66"><div align="right"><?=number_format((${'totala'}),2);?></div></td>
<td bgcolor="#FFFF66"><div align="right"><?=number_format((${'totalb'}),2);?></div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalc'}),2);?></div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalm'}),2);?></div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($totalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotala'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalb'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalc'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalm'},2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($dtotalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotala'}*100/${'totala'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotala'}*100/${'totalb'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalb'}*100/${'totalc'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalm'}/${'totalm'},2);?>
  %</div></td>
    </tr>
    
	<?


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'sqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'totalsu'} = ${'totalsu'} + ${'sqlmonsu'}[0];

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d where c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'dsqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'dtotalsu'} = ${'dtotalsu'} + ${'dsqlmonsu'}[0];

?>
</table></td>
  </tr>
</table>
<?
}
elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}
?></div>
</body>
</html>