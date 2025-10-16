<?
session_start();
require "../../../engine/tools/check.php";
require "../../../engine/configure/db_connect.php";
require "../../../engine/tools/my.php";

date_default_timezone_set('Asia/Dhaka');

if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)
{
	if((strlen($_POST['t_date'])==10)&&(strlen($_POST['f_date'])==10))
	{
		$to_date=$_POST['t_date'];
		$fr_date=$_POST['f_date'];
		$date_con=' and j.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';
	}

if($_POST['item']!='')          $item = explode('#>',$_POST['item']);
if($item[1]>0){			
$item_id=$item[1];
$item_info = find_all_field('item_info','item_name','item_id='.$item_id);
$item_con=' and j.item_id='.$item_id;
}
switch ($_POST['report']) {
case 1:
$report="BIN CARD (Details)";
		$s=1;
$sql="select j.* from 
journal_item j  , warehouse w
where w.warehouse_id=j.warehouse_id".$date_con.$item_con." order by j.id";
	break;
case 1:
$report="BIN CARD (Summary)";
		$s=1;
$sql="select j.* from 
journal_item j  , warehouse w
where w.warehouse_id=j.warehouse_id".$date_con.$item_con." order by j.id";
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
<div align="center" id="pr">
<input type="button" value="Print" onclick="hide();window.print();"/>
</div>
<div class="main">
<?


if(isset($sql)&&$report!="BIN CARD (Summary)") {

		if($sql==NULL) return NULL;
		$res	 = mysql_query($sql);
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">

		<thead>
		<tr><td colspan="17" style="border:0px;">
		<?
		echo '<div class="header">';
		if(isset($_SESSION['company_name'])) 
		echo '<h1>'.$_SESSION['company_name'].'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';


		echo '<h2>Product Name : '.$item_info->item_name.'(Code:'.$item_info->item_id.')'.'</h2>';
		echo '</div>';
		echo '<div class="left" style="width:50%">';
		if(isset($to_date)) 
		echo '<p>Date Interval : '.$fr_date.' To '.$to_date.'</p>';

		echo '<p>Product Description: '.$item_info->item_description.'</p>';
		echo '</div><div class="right" style="width:40%">';
		echo '<p>Warehouse Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</p>';
		echo '</div><div class="date" style="width:40%; text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		  <th rowspan="2">S/L</th>
		  <th rowspan="2">Date</th>
		  <th colspan="3" style="text-align:center">OPENING BALANCE</th>
		  <th colspan="5" style="text-align:center">PRODUCT RECEIVED</th>
		  <th colspan="5" style="text-align:center">PRODUCT ISSUED</th>
		  <th colspan="3" style="text-align:center">CLOSING BALANCE</th>
		  </tr>
		<tr>
<!--		j.ji_date,j.pre_stock,j.item_in,j.item_ex,j.final_stock,j.tr_from,j.tr_no,j.entry_by,j.entry_at-->
		<th>Qty</th>
		<th>Rate</th>		
		<th>Taka</th>
		<th>Tr Type</th>
		<th>Tr No</th>
		<th>Qty</th>
		<th>Rate</th>		
		<th>Taka</th>
		<th>Tr Type</th>
		<th>Tr No</th>
		<th>Qty</th>
		<th>Rate</th>
		<th>Taka</th>
		<th>Qty</th>
		<th>Rate</th>
		<th>Taka</th>
		</tr>
		</thead><tbody>
<?
		while($row=mysql_fetch_object($res))
			{$sl++;?>
					<tr>
			<td><?=$sl?></td>
			<td><?=$row->ji_date?></td>
			<td><?=$row->pre_stock?></td>
			<td><?=number_format($row->pre_price,2)?></td>
			<td><?=number_format(($row->pre_stock*$row->pre_price),2)?></td>
            <? if($row->item_in>0){?>
			<td><?=$row->tr_from?></td>
			<td><?=$row->tr_no?></td>
			<td><?=$row->item_in?></td>
			<td><?=number_format($row->item_price,2)?></td>
			<td><?=number_format(($row->item_in*$row->item_price),2)?></td>
            <? }else{echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';}?>
            <? if($row->item_ex>0){?>
			<td><?=$row->tr_from?></td>
			<td><?=$row->tr_no?></td>
			<td><?=$row->item_ex?></td>
			<td><?=number_format($row->item_price,2)?></td>
			<td><?=number_format(($row->item_ex*$row->item_price),2)?></td>
            <? }else{echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';}?>
			<td><?=$row->final_stock?></td>
			<td><?=number_format($row->final_price,2)?></td>
			<td><?=number_format(($row->final_stock*$row->final_price),2)?></td>
            </tr>
			<? }
			?>
</tbody>
</table>
<?
}
else
{

		if($sql==NULL) return NULL;
		$res	 = mysql_query($sql);
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">

		<thead>
		<tr><td colspan="11" style="border:0px;">
		<?
		echo '<div class="header">';
		if(isset($_SESSION['company_name'])) 
		echo '<h1>'.$_SESSION['company_name'].'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';


		echo '<h2>Product Name : '.$item_info->item_name.'(Code:'.$item_info->item_id.')'.'</h2>';
		echo '</div>';
		echo '<div class="left" style="width:50%">';
		if(isset($to_date)) 
		echo '<p>Date Interval : '.$fr_date.' To '.$to_date.'</p>';

		echo '<p>Product Description: '.$item_info->item_description.'</p>';
		echo '</div><div class="right" style="width:40%">';
		echo '<p>Warehouse Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</p>';
		echo '</div><div class="date" style="width:40%; text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		  <th rowspan="2">S/L</th>
		  <th rowspan="2">Date</th>
		  <th colspan="2" style="text-align:center">OPENING BALANCE</th>
		  <th colspan="3" style="text-align:center">PRODUCT RECEIVED</th>
		  <th colspan="3" style="text-align:center">PRODUCT ISSUED</th>
		  <th style="text-align:center">CLOSING BALANCE</th>
		  </tr>
		<tr>
<!--		j.ji_date,j.pre_stock,j.item_in,j.item_ex,j.final_stock,j.tr_from,j.tr_no,j.entry_by,j.entry_at-->
		<th>Qty</th>
		<th>Rate</th>		
		<th>Tr Type</th>
		<th>Tr No</th>
		<th>Qty</th>
		<th>Tr Type</th>
		<th>Tr No</th>
		<th>Qty</th>
		<th>Qty</th>
		</tr>
		</thead><tbody>
<?
		while($row=mysql_fetch_object($res))
			{$sl++;?>
					<tr>
			<td><?=$sl?></td>
			<td><?=$row->ji_date?></td>
			<td><?=$row->pre_stock?></td>
			<td><?=number_format($row->pre_price,2)?></td>
			<? if($row->item_in>0){?>
			<td><?=$row->tr_from?></td>
			<td><?=$row->tr_no?></td>
			<td><?=$row->item_in?></td>
			<? }else{echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';}?>
            <? if($row->item_ex>0){?>
			<td><?=$row->tr_from?></td>
			<td><?=$row->tr_no?></td>
			<td><?=$row->item_ex?></td>
			<? }else{echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';}?>
			<td><?=$row->final_stock?></td>
			</tr>
			<? }
			?>
</tbody>
</table>
<?
}
?>

</div>
</body>
</html>