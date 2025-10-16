<?
session_start();
require "../../../engine/tools/check.php";
require "../../../engine/configure/db_connect.php";
require "../../../engine/tools/my.php";
function report_create($sql,$s='',$head=''){
	if($s!='') $sl=$s;
	if($sql==NULL) return NULL;
		$res	 = mysql_query($sql);
		$cols 	 = mysql_num_fields($res);
		if(isset($sl)) $total_cols=$cols+1; else $total_cols=$cols;
		$str	.= '<table width="100%" border="0" cellpadding="2" cellspacing="0">';
		$str 	.= '<tbody>';
		while($row=mysql_fetch_array($res))
			{				
				$str .='<tr>';
				if(isset($sl)){$str .='<td>'.$sl.'</td>';$sl++;}
				for($i=0;$i<$cols;$i++) 
{
if($_POST['report']==1){
if($coloum[$i]=='rate')
{$str .='<td style="text-align:right">'.@number_format($row[$i],4).'</td>';}
elseif($show[$i]!=1&&(is_numeric($row[$i])))
{$sum[$i]=$sum[$i]+$row[$i]; $str .='<td style="text-align:right">'.$row[$i].'</td>';}
else {$show[$i]=1; $str .='<td>'.$row[$i].'</td>';}}
else{
if($coloum[$i]=='rate')
{$str .='<td style="text-align:right">'.@number_format($row[$i],4).'</td>';}
elseif($show[$i]!=1&&(is_numeric($row[$i])&&strpos($row[$i],'.')||$row[$i]==''))
{$sum[$i]=$sum[$i]+$row[$i]; $str .='<td style="text-align:right">'.@number_format($row[$i],2).'</td>';}
else {$show[$i]=1; $str .='<td>'.$row[$i].'</td>';}}
}
				$str .='</tr>';
			}
		$str .='</tbody>';
	$str .='</table>';
	return $str;

}


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

if($_POST['area_id']!='') 		$area_id=$_POST['area_id'];
if($_POST['zone_id']!='') 		$zone_id=$_POST['zone_id'];
if($_POST['region_id']!='') 		$region_id=$_POST['region_id'];
if($_POST['depot_id']!='') 		$depot_id=$_POST['depot_id'];

if(isset($dealer_type)) 		{$dtype_con=' and d.dealer_type="'.$dealer_type.'"';} 
if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 
if(isset($dealer_type)) 		{$dtype_con=' and d.dealer_type="'.$dealer_type.'"';} 
if(isset($dealer_code)) 		{$dealer_con=' and d.dealer_code='.$dealer_code;}
if(isset($depot_id)) 			{$depot_con=' and d.depot="'.$depot_id.'"';} 
//if(isset($dealer_code)) 		{$dealer_con=' and a.dealer_code="'.$dealer_code.'"';} 
//if(isset($product_group)) 	{$pg_con=' and d.product_group="'.$product_group.'"';} 
if(isset($zone_id)) 			{$zone_con=' and z.ZONE_CODE='.$zone_id;}
if(isset($region_id)) 			{$region_con=' and r.BRANCH_ID='.$region_id;}
//if(isset($item_id)) 			{$item_con=' and b.item_id='.$item_id;} 
//if(isset($status)) 			{$status_con=' and a.status="'.$status.'"';} 
//if(isset($do_no)) 			{$do_no_con=' and a.do_no="'.$do_no.'"';} 
//if(isset($t_date)) 			{$to_date=$t_date; $fr_date=$f_date; $order_con=' and o.order_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
//if(isset($t_date)) 			{$to_date=$t_date; $fr_date=$f_date; $chalan_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

switch ($_POST['report']) {
    case 1:		
	if($dealer_type!='Distributor')
$sql="select d.* from dealer_info d  , warehouse w
where w.warehouse_id=d.depot and d.canceled='Yes'".$depot_con.$date_con.$pg_con.$dealer_con.$dtype_con." order by d.dealer_name_e";
else
$sql="select d.* from dealer_info d  , warehouse w, area a,zon z,branch r
where a.AREA_CODE=d.area_code and w.warehouse_id=d.depot and d.canceled='Yes' and z.ZONE_CODE=a.ZONE_ID and r.BRANCH_ID=z.REGION_ID".$zone_con.$depot_con.$region_con.$date_con.$pg_con.$dealer_con.$dtype_con." order by d.dealer_name_e";
	break;
    case 2:
	if($dealer_type!='Distributor')
$sql="select d.* from 
dealer_info d  , warehouse w
where w.warehouse_id=d.depot and d.canceled='Yes'".$depot_con.$date_con.$pg_con.$dealer_con.$dtype_con." order by d.dealer_name_e";
else
$sql="select d.* from 
dealer_info d  , warehouse w, area a
where a.AREA_CODE=d.area_code and w.warehouse_id=d.depot and d.canceled='Yes'".$depot_con.$date_con.$pg_con.$dealer_con.$dtype_con." order by d.dealer_name_e";
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
</head>
<body>
<div class="main">
  <p>
  <?
if($_POST['report']==1) 
{
$query = mysql_query($sql);
while($data=mysql_fetch_object($query)){
echo '<div style="position:relative;display:block; page-break-after:always; page-break-inside:avoid; width:800px;"><br><br><br>';
?>
  &nbsp;&nbsp;&nbsp;&nbsp;To,<br />
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->propritor_name_e?><br />
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->dealer_name_e?> (<?=$data->dealer_code?>) (<?=$data->product_group?>)<br />
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->address_e?>.<br />
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mobile: <?=$data->mobile_no?><?
echo '</div>';
}
}
else{
$query = mysql_query($sql);
echo '<div style="width:800px;">';
while($data=mysql_fetch_object($query)){
	$i++;
?>

<div style="width:800px; font-size:18px; float:left;">
  &nbsp;&nbsp;&nbsp;&nbsp;To,<br />
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->propritor_name_e?><br />
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->dealer_name_e?> (<?=$data->dealer_code?>) (<?=$data->product_group?>)<br />
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->address_e?>.<br />
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mobile: <?=$data->mobile_no?>
  <br><br><br></div>
  <? if(($i%6==0)) echo '<div style="position:relative;display:block; page-break-after:always; page-break-inside:avoid;">&nbsp;</div>'; ?>
  <?
}
echo '</div>';
	}
?></div>
</body>
</html>