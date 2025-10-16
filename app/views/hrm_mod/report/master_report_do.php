<?
session_start();
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
require "../../engine/tools/check.php";
require "../../engine/configure/db_connect.php";
require "../../engine/tools/my.php";
require "../../engine/tools/report.class.php";

date_default_timezone_set('Asia/Dhaka');

if($_REQUEST['report']>0)
{
	if((strlen($_REQUEST['t_date'])==10)&&(strlen($_REQUEST['f_date'])==10))
	{
		$t_date=$_REQUEST['t_date'];
		$f_date=$_REQUEST['f_date'];
	}
	
if($_REQUEST['product_group']!='') 	$product_group=$_REQUEST['product_group'];
if($_REQUEST['item_brand']!='') 	$item_brand=$_REQUEST['item_brand'];
if($_REQUEST['item_id']>0) 			$item_id=$_REQUEST['item_id'];
if($_REQUEST['dealer_code']>0) 	 	$dealer_code=$_REQUEST['dealer_code'];
if($_REQUEST['dealer_type']!='') 	$dealer_type=$_REQUEST['dealer_type'];

if($_REQUEST['status']!='') 		$status=$_REQUEST['status'];
if($_REQUEST['do_no']!='') 			$do_no=$_REQUEST['do_no'];
if($_REQUEST['area_id']!='') 		$area_id=$_REQUEST['area_id'];
if($_REQUEST['zone_id']!='') 		$zone_id=$_REQUEST['zone_id'];
if($_REQUEST['region_id']>0) 		$region_id=$_REQUEST['region_id'];
if($_REQUEST['depot_id']!='') 		$depot_id=$_REQUEST['depot_id'];

if(isset($item_brand)) 			{$item_brand_con=' and i.item_brand="'.$item_brand.'"';} 
if(isset($dealer_code)) 		{$dealer_con=' and a.dealer_code="'.$dealer_code.'"';} 
if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
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
//if(isset($do_no)) 			{$do_no_con=' and a.do_no="'.$do_no.'"';} 
//if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $order_con=' and o.order_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
//if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $Damage_con=' and c.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

switch($_REQUEST['report']) {
case 1:
		$report="Item Wise Order Based Detail Report(DO DATE)";
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		break;
		case 2:
		$report="Item Wise Delivery Based Detail Report(DO DATE)";
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		break;

		case 3:
		$report="Item Wise Delivery Based Detail Report(CH DATE)";
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		break;
				case 4:
		$report="Free Item Review Report";
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		break;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$region_name?> <?=$zone_name?> <?=$dealer_name?> <?=$report?></title>
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<link href="../css/report.css" type="text/css" rel="stylesheet" />
<script language="javascript">
function hide()
{document.getElementById('pr').style.display='none';}
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
.style3 {font-weight: bold}
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
		if(isset($dealer_name)) 
		$str 	.= '<h2>Dealer Name : '.$dealer_name.'</h2>';
		if(isset($item_info->item_id)) 
		$str 	.= '<h2>Item Name : '.$item_info->item_name.'('.$item_info->finish_goods_code.')'.'('.$item_info->sales_item_type.')'.'('.$item_info->item_brand.')'.'</h2>';
		if(isset($to_date)) 
		$str 	.= '<h2>Date Interval : '.$fr_date.' To '.$to_date.'</h2>';
		if(isset($product_group)) 
		$str 	.= '<h2>Product Group : '.$product_group.'</h2>';
		
		if(isset($item_brand)) 
		$str 	.= '<h2>Item Brand : '.$item_brand.'</h2>';
		
		if(isset($region_name)) $str .= '<h2>Region Name : '.$region_name.'</h2>';
		if(isset($zone_name)) $str 	.= '<h2>Zone Name: '.$zone_name.'</h2>';
		if(isset($area_name)) $str 	.= '<h2>Area Name: '.$area_name.'</h2>';
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
if($_REQUEST['report']==1) 
{
?><table width="100%" cellspacing="0" cellpadding="2" border="0">
<?

$sql="select c.id,c.do_no, c.do_no,c.do_date,d.dealer_code,d.dealer_name_e dealer_name,i.item_name,sum(c.total_unit) total_unit,c.unit_price,
sum(c.total_amt) total_amt,w.warehouse_name as depot,a.AREA_NAME,z.ZONE_CODE ZONE_ID,z.ZONE_NAME,r.BRANCH_NAME,d.dealer_code,d.product_group,i.pack_size  
from 
sale_do_master m, sale_do_details c,dealer_info d  , warehouse w ,item_info i, area a, zon z, branch r

where 
d.area_code=a.AREA_CODE and a.ZONE_ID =z.ZONE_CODE and z.REGION_ID=r.BRANCH_ID and c.unit_price>0 and 
i.item_id=c.item_id and m.do_no=c.do_no and c.dealer_code=d.dealer_code and w.warehouse_id=d.depot ".$item_con.$depot_con.$date_con.$pg_con.$con.$dealer_type_con.$damage_con."   group by d.dealer_code,i.item_id order by z.ZONE_CODE,d.dealer_code desc";

$query = db_query($sql);

?>
<thead><tr><td style="border:0px;" colspan="6"><?=$str?></td></tr><tr><th>S/L</th>
<th>Dealer Code</th>
<th>Dealer Name-Area</th>
<th>Zone Name</th><th>Item Name Name</th>
<th>Grp</th>
<th>Unit Price</th>
<th>CTN</th>
<th>PCS</th>
<th>Total AMT</th>
</tr></thead><tbody>
<? 
$zone_total = 0;
$dealer_total = 0;
$region_total = 0;
while($data=mysqli_fetch_object($query)){$s++;




if($old_dealer_code != $data->dealer_code&&$old_dealer_code != ''){
echo '
<tr style="background-color:#FFFF99">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Total Amount</td>
  <td>'.$dealer_total.'</td>
</tr>';
$dealer_total = 0;
}
if($old_zone_code != $data->ZONE_ID&&$old_zone_code != ''){
echo '
<tr style="background-color:#FFF000">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Zone Total Amount</td>
  <td>'.$zone_total.'</td>
</tr>';
$zone_total = 0;
}
?>

<tr><td><?=$s?></td><td><?=($old_dealer_code!=$data->dealer_code)?$data->dealer_code:'';?></td>
  <td><?=($old_dealer_code!=$data->dealer_code)?$data->dealer_name.'-'.$data->AREA_NAME:'';?></td>
  <td><?=($old_dealer_code!=$data->dealer_code)?'Zone-'.$data->ZONE_NAME:'';?></td><td><?=$data->item_name?></td><td><?=$data->product_group;?></td>


<td><?=$data->unit_price;?></td>
<td><?=(int)($data->total_unit/$data->pack_size);?></td>
<td><?=(int)($data->total_unit%$data->pack_size);?></td>
<td><?=number_format($data->total_amt,2)?></td>
</tr>
<?
$zone_total = $zone_total + $data->total_amt;
$dealer_total = $dealer_total + $data->total_amt;
$region_total = $region_total + $data->total_amt;

$old_dealer_code = $data->dealer_code;
$old_zone_code = $data->ZONE_ID;



}

echo '
<tr style="background-color:#FFFF99">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Total Amount</td>
  <td>'.$dealer_total.'</td>
</tr>';


echo '
<tr style="background-color:#FFF000">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Zone Total Amount</td>
  <td>'.$zone_total.'</td>
</tr>';


?></tbody></table>
<?
}

elseif($_REQUEST['report']==2) 
{
?><table width="100%" cellspacing="0" cellpadding="2" border="0">
<?

$sql="select c.id,c.do_no, c.do_no,c.do_date,d.dealer_code,d.dealer_name_e dealer_name,i.item_name,sum(c.total_unit) total_unit,c.unit_price,
sum(c.total_amt) total_amt,w.warehouse_name as depot,a.AREA_NAME,z.ZONE_CODE ZONE_ID,z.ZONE_NAME,r.BRANCH_NAME,d.dealer_code,d.product_group,i.pack_size 
from 
sale_do_master m, sale_do_chalan c,dealer_info d  , warehouse w ,item_info i, area a, zon z, branch r

where 
d.area_code=a.AREA_CODE and a.ZONE_ID =z.ZONE_CODE and z.REGION_ID=r.BRANCH_ID and c.unit_price>0 and 
i.item_id=c.item_id and m.do_no=c.do_no and c.dealer_code=d.dealer_code and w.warehouse_id=d.depot ".$item_con.$depot_con.$date_con.$pg_con.$con.$dealer_type_con.$damage_con." group by d.dealer_code,i.item_id order by z.ZONE_CODE,d.dealer_code desc";

$query = db_query($sql);

?>
<thead><tr><td style="border:0px;" colspan="6"><?=$str?></td></tr><tr><th>S/L</th>
<th>Dealer Code</th>
<th>Dealer Name-Area</th>
<th>Zone Name</th><th>Item Name Name</th>
<th>Grp</th>
<th>Unit Price</th>
<th>CTN</th>
<th>PCS</th>
<th>Total AMT</th>
</tr></thead><tbody>
<? 
$zone_total = 0;
$dealer_total = 0;
$region_total = 0;
while($data=mysqli_fetch_object($query)){$s++;




if($old_dealer_code != $data->dealer_code&&$old_dealer_code != ''){
echo '
<tr style="background-color:#FFFF99">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Total Amount</td>
  <td>'.$dealer_total.'</td>
</tr>';
$dealer_total = 0;
}
if($old_zone_code != $data->ZONE_ID&&$old_zone_code != ''){
echo '
<tr style="background-color:#FFF000">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Zone Total Amount</td>
  <td>'.$zone_total.'</td>
</tr>';
$zone_total = 0;
}
?>

<tr><td><?=$s?></td><td><?=($old_dealer_code!=$data->dealer_code)?$data->dealer_code:'';?></td>
  <td><?=($old_dealer_code!=$data->dealer_code)?$data->dealer_name.'-'.$data->AREA_NAME:'';?></td>
  <td><?=($old_dealer_code!=$data->dealer_code)?'Zone-'.$data->ZONE_NAME:'';?></td><td><?=$data->item_name?></td><td><?=$data->product_group;?></td>


<td><?=$data->unit_price;?></td>
<td><?=(int)($data->total_unit/$data->pack_size);?></td>
<td><?=(int)($data->total_unit%$data->pack_size);?></td>
<td><?=number_format($data->total_amt,2)?></td>
</tr>
<?
$zone_total = $zone_total + $data->total_amt;
$dealer_total = $dealer_total + $data->total_amt;
$region_total = $region_total + $data->total_amt;

$old_dealer_code = $data->dealer_code;
$old_zone_code = $data->ZONE_ID;



}

echo '
<tr style="background-color:#FFFF99">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Total Amount</td>
  <td>'.$dealer_total.'</td>
</tr>';


echo '
<tr style="background-color:#FFF000">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Zone Total Amount</td>
  <td>'.$zone_total.'</td>
</tr>';


?></tbody></table>
<?
}

elseif($_REQUEST['report']==3) 
{
?><table width="100%" cellspacing="0" cellpadding="2" border="0">
<?

$sql="select c.id,c.do_no, c.do_no,c.do_date,d.dealer_code,d.dealer_name_e dealer_name,i.item_name,sum(c.total_unit) total_unit,c.unit_price,
sum(c.total_amt) total_amt,w.warehouse_name as depot,a.AREA_NAME,z.ZONE_CODE ZONE_ID,z.ZONE_NAME,r.BRANCH_NAME,d.dealer_code,d.product_group,i.pack_size 
from 
sale_do_master m, sale_do_chalan c,dealer_info d  , warehouse w ,item_info i, area a, zon z, branch r

where 
d.area_code=a.AREA_CODE and a.ZONE_ID =z.ZONE_CODE and z.REGION_ID=r.BRANCH_ID and c.unit_price>0 and 
i.item_id=c.item_id and m.do_no=c.do_no and c.dealer_code=d.dealer_code and w.warehouse_id=d.depot ".$item_con.$depot_con.$date_con.$pg_con.$con.$dealer_type_con.$damage_con." group by d.dealer_code,i.item_id order by z.ZONE_CODE,d.dealer_code desc";

$query = db_query($sql);

?>
<thead><tr><td style="border:0px;" colspan="6"><?=$str?></td></tr><tr><th>S/L</th>
<th>Dealer Code</th>
<th>Dealer Name-Area</th>
<th>Zone Name</th><th>Item Name Name</th>
<th>Grp</th>
<th>Unit Price</th>
<th>CTN</th>
<th>PCS</th>
<th>Total AMT</th>
</tr></thead><tbody>
<? 
$zone_total = 0;
$dealer_total = 0;
$region_total = 0;
while($data=mysqli_fetch_object($query)){$s++;




if($old_dealer_code != $data->dealer_code&&$old_dealer_code != ''){
echo '
<tr style="background-color:#FFFF99">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Total Amount</td>
  <td>'.$dealer_total.'</td>
</tr>';
$dealer_total = 0;
}
if($old_zone_code != $data->ZONE_ID&&$old_zone_code != ''){
echo '
<tr style="background-color:#FFF000">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Zone Total Amount</td>
  <td>'.$zone_total.'</td>
</tr>';
$zone_total = 0;
}
?>

<tr><td><?=$s?></td><td><?=($old_dealer_code!=$data->dealer_code)?$data->dealer_code:'';?></td>
  <td><?=($old_dealer_code!=$data->dealer_code)?$data->dealer_name.'-'.$data->AREA_NAME:'';?></td>
  <td><?=($old_dealer_code!=$data->dealer_code)?'Zone-'.$data->ZONE_NAME:'';?></td><td><?=$data->item_name?></td><td><?=$data->product_group;?></td>


<td><?=$data->unit_price;?></td>
<td><?=(int)($data->total_unit/$data->pack_size);?></td>
<td><?=(int)($data->total_unit%$data->pack_size);?></td>
<td><?=number_format($data->total_amt,2)?></td>
</tr>
<?
$zone_total = $zone_total + $data->total_amt;
$dealer_total = $dealer_total + $data->total_amt;
$region_total = $region_total + $data->total_amt;

$old_dealer_code = $data->dealer_code;
$old_zone_code = $data->ZONE_ID;



}

echo '
<tr style="background-color:#FFFF99">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Total Amount</td>
  <td>'.$dealer_total.'</td>
</tr>';


echo '
<tr style="background-color:#FFF000">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Zone Total Amount</td>
  <td>'.$zone_total.'</td>
</tr>';


?></tbody></table>
<?
}

elseif($_REQUEST['report']==4) 
{
?><table width="100%" cellspacing="0" cellpadding="2" border="0">
<?

$sql="select c.id,c.do_no, c.do_no,c.do_date,d.dealer_code,d.dealer_name_e dealer_name,i.item_name,sum(c.total_unit) total_unit,c.unit_price,
sum(c.total_amt) total_amt,w.warehouse_name as depot,a.AREA_NAME,d.dealer_code,d.product_group,i.pack_size 
from 
sale_do_master m, sale_do_details c,dealer_info d  , warehouse w ,item_info i, area a

where 
d.area_code=a.AREA_CODE and c.unit_price==0 and 
i.item_id=c.item_id and m.do_no=c.do_no and c.dealer_code=d.dealer_code and w.warehouse_id=d.depot ".$item_con.$depot_con.$date_con.$pg_con.$con.$dealer_type_con.$damage_con." group by d.dealer_code,i.item_id order by z.ZONE_CODE,d.dealer_code desc";

$query = db_query($sql);

?>
<thead><tr><td style="border:0px;" colspan="6"><?=$str?></td></tr><tr><th>S/L</th>
<th>Dealer Code</th>
<th>Dealer Name-Area</th>
<th>Zone Name</th><th>Item Name Name</th>
<th>Grp</th>
<th>Unit Price</th>
<th>CTN</th>
<th>PCS</th>
<th>Total AMT</th>
</tr></thead><tbody>
<? 
$zone_total = 0;
$dealer_total = 0;
$region_total = 0;
while($data=mysqli_fetch_object($query)){$s++;




if($old_dealer_code != $data->dealer_code&&$old_dealer_code != ''){
echo '
<tr style="background-color:#FFFF99">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Total Amount</td>
  <td>'.$dealer_total.'</td>
</tr>';
$dealer_total = 0;
}
if($old_zone_code != $data->ZONE_ID&&$old_zone_code != ''){
echo '
<tr style="background-color:#FFF000">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Zone Total Amount</td>
  <td>'.$zone_total.'</td>
</tr>';
$zone_total = 0;
}
?>

<tr><td><?=$s?></td><td><?=($old_dealer_code!=$data->dealer_code)?$data->dealer_code:'';?></td>
  <td><?=($old_dealer_code!=$data->dealer_code)?$data->dealer_name.'-'.$data->AREA_NAME:'';?></td>
  <td><?=($old_dealer_code!=$data->dealer_code)?'Zone-'.$data->ZONE_NAME:'';?></td><td><?=$data->item_name?></td><td><?=$data->product_group;?></td>


<td><?=$data->unit_price;?></td>
<td><?=(int)($data->total_unit/$data->pack_size);?></td>
<td><?=(int)($data->total_unit%$data->pack_size);?></td>
<td><?=number_format($data->total_amt,2)?></td>
</tr>
<?
$zone_total = $zone_total + $data->total_amt;
$dealer_total = $dealer_total + $data->total_amt;
$region_total = $region_total + $data->total_amt;

$old_dealer_code = $data->dealer_code;
$old_zone_code = $data->ZONE_ID;



}

echo '
<tr style="background-color:#FFFF99">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Total Amount</td>
  <td>'.$dealer_total.'</td>
</tr>';


echo '
<tr style="background-color:#FFF000">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Zone Total Amount</td>
  <td>'.$zone_total.'</td>
</tr>';


?></tbody></table>
<?
}
elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}}
?></div>
<!--<script type="text/javascript">
 
$("tr").not(':first').hover(
  function () {
    $(this).css("background","yellow");
  }, 
  function () {
    $(this).css("background","");
  }
);
 
</script>-->
</body>
</html>
