<?
 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

date_default_timezone_set('Asia/Dhaka');

if(isset($_REQUEST['submit'])&&isset($_REQUEST['report'])&&$_REQUEST['report']>0)
{
	if((strlen($_REQUEST['t_date'])==10))
	{
		$to_date=$_REQUEST['t_date'];
		$fr_date=$_REQUEST['f_date'];
		$date_con=' and j.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';
	}

if($_REQUEST['item']!=''){$item = explode('#>',$_REQUEST['item']);
if($item[1]>0){			
$item_id=$item[1];}}

if($_REQUEST['warehouse_id']>0)  {         $warehouse_id = $_REQUEST['warehouse_id'];}
if($warehouse_id>0){
$warehouse_info = find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id);
$warehouse_con=' and j.warehouse_id='.$warehouse_id;
}
else{ $warehouse_info = "All Warehouse";}

if($_REQUEST['item_id']>0)  {         $item_id = $_REQUEST['item_id'];}
if($item_id>0){

$item_info = find_all_field('item_info','item_name','item_id='.$item_id);
$item_con=' and j.item_id='.$item_id;
}

switch ($_REQUEST['report']) {
case 1:
$report="BIN CARD (Details)";
		$s=1;
$sql="select j.* from 
journal_item j  , warehouse w
where w.warehouse_id=j.warehouse_id and j.warehouse_id='".$_SESSION['user']['depot']."' ".$date_con.$item_con." order by j.id";
	break;
	case 2:
$report="BIN CARD (Summary)";
		$s=1;
$sql="select j.* from 
journal_item j  , warehouse w
where w.warehouse_id=j.warehouse_id and j.warehouse_id='".$_SESSION['user']['depot']."' ".$date_con.$item_con." order by j.id";
	break;
	case 3:
$report="Product BIN CARD (Date Wise)";

$sql="select j.* from 
journal_item j  , warehouse w
where w.warehouse_id=j.warehouse_id and j.warehouse_id='".$_SESSION['user']['depot']."' ".$date_con.$item_con." order by j.ji_date";
	break;
	case 33:
$report="Product BIN CARD (Date Wise)";

     $sql="select j.* from 
journal_item j  , warehouse w
where w.warehouse_id=j.warehouse_id".$date_con.$item_con.$warehouse_con." order by j.ji_date, j.entry_at";
	break;
	
		case 34:
$report="Product BIN CARD (Date Wise)";

     $sql="select j.* from 
journal_item j  , warehouse w
where w.warehouse_id=j.warehouse_id".$date_con.$item_con.$warehouse_con." order by j.ji_date, j.entry_at";
	break;
	
	case 235:
$report="Product BIN CARD (Date Wise)";

     $sql="select j.* from 
journal_item j  , warehouse w
where w.warehouse_id=j.warehouse_id".$date_con.$item_con.$warehouse_con." order by j.ji_date, j.id";
	break;
	
	case 2482025:
$report="Product BIN CARD (ID Wise)";

     $sql="select j.* from 
journal_item j  , warehouse w
where w.warehouse_id=j.warehouse_id".$date_con.$item_con.$warehouse_con." order by j.id";
	break;
	
		case 4:
$report="BIN CARD";

$sql="select j.* from 
journal_item j  , warehouse w
where w.warehouse_id=j.warehouse_id and j.warehouse_id='".$_SESSION['user']['depot']."' ".$date_con.$item_con." order by j.ji_date";
	break;
	
case 5:
$report="BIN CARD (Finish Goods)";
$sql="select j.* from 
journal_item j  , warehouse w
where w.warehouse_id=j.warehouse_id and j.warehouse_id='".$_SESSION['user']['depot']."' ".$date_con.$item_con." order by j.ji_date";
break;
	


}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$report?></title>
<link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />
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

	<?
	require_once "../../../controllers/core/inc.exporttable.php";
	?>

</head>
<body>
<!--<div align="center" id="pr">-->
<!--<input type="button" value="Print" onclick="hide();window.print();"/>-->
<!--</div>-->
<div class="main">
<?

if($_REQUEST['report']==5) {

		if($sql==NULL) return NULL;
		$res	 = db_query($sql);
?>
  <table width="100%" border="0" cellpadding="2" cellspacing="0" id="ExportTable">

		<thead>
		<tr><td colspan="22" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';


		echo '<h2>Product Name : '.$item_info->finish_goods_code.'-'.$item_info->item_name.' (Code:'.$item_info->item_id.')'.'<br>';
		echo 'Product Unit : '.$item_info->unit_name.'</h2>';
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
		  <th rowspan="2" bgcolor="#99CC99" style="text-align:center">DP SL </th>
		  <th rowspan="2" bgcolor="#99CC99" style="text-align:center">CHALAN  NO </th>
		  <th colspan="3" bgcolor="#99CC99" style="text-align:center">OPENING BALANCE</th>
		  <th colspan="4" bgcolor="#339999" style="text-align:center">PRODUCT RECEIVED</th>
		  <th colspan="4" bgcolor="#FFCC66" style="text-align:center">PRODUCT ISSUED</th>
		  <th colspan="3" bgcolor="#FFFF99" style="text-align:center">CLOSING BALANCE</th>
		  <th rowspan="2" bgcolor="#FF99FF" style="text-align:center">Place</th>
		  <th colspan="2" bgcolor="#FFFF99" style="text-align:center">Prepared </th>
		  <th rowspan="2" bgcolor="#FFFF99" style="text-align:center">Note</th>
		  </tr>
		<tr>
		  <th bgcolor="#99CC99">CTN</th>
		  <th bgcolor="#99CC99">PCS</th>
		  <th bgcolor="#99CC99">TQty</th>
		  <th bgcolor="#339999">Tr Type</th>
			<th bgcolor="#339999">Tr No</th>
			<th bgcolor="#339999"><div align="right">CTN</div></th>
			<th bgcolor="#339999"><div align="right">PCS</div></th>
			<th bgcolor="#FFCC66">Tr Type</th>
			<th bgcolor="#FFCC66">Tr No</th>
			<th bgcolor="#FFCC66"><div align="right">CTN</div></th>
			<th bgcolor="#FFCC66"><div align="right">PCS</div></th>
			<th bgcolor="#FFFF99">CTN</th>
			<th bgcolor="#FFFF99">PCS</th>
			<th bgcolor="#FFFF99">TQty</th>
			<th bgcolor="#FFFF99" style="text-align:center">BY</th>
		    <th bgcolor="#FFFF99" style="text-align:center">AT</th>
		</tr>
		</thead><tbody>
<? $sl=1;
while($row=mysqli_fetch_object($res))
			{
			unset($pi);
			if($row->relevant_warehouse>0) 
			{
				$psql = 'select m.* from production_issue_master m,production_issue_detail d where d.pi_no=m.pi_no and d.id='.$row->tr_no;
				$pi = find_all_field_sql($psql);
			}
			if($sl==1) 
			{
				$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item where warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date<"'.$fr_date.'" and item_id='.$item_id);
				$pre_stock = (int)$pre->pre_stock;
				$pre_price = @($pre->pre_amt/$pre->pre_stock);
				$pre_amt   = $pre->pre_amt;
			}
			else
			{
				$pre_stock = $final_stock;
				$pre_price = $final_price;
			}
				$final_stock = @($pre_stock+($row->item_in-$row->item_ex));
				$final_price = @((($pre_stock*$pre_price)+(($row->item_in-$row->item_ex)*$row->item_price))/$final_stock);
			?>
			
			<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
			<td><?=$sl++;?></td>
			<td><?=$row->ji_date?></td>
			<td><? 
			if($row->tr_from=='Sales'){ 
				echo find_a_field('sale_do_chalan','driver_name','chalan_no='.$row->sr_no); 
				}elseif($row->tr_from=='Export Sales'){ 
				echo find_a_field('export_sale_do_chalan','driver_name','chalan_no='.$row->sr_no); 
				}elseif ($row->relevant_warehouse>0){ 
			echo ($pi->pi_no>0)?$pi->remarks:$row->sr_no;
			}
			?></td>
			<td><?=($pi->pi_no>0)?$pi->pi_no:$row->sr_no;?></td>
			
			<td><?=(int)($pre_stock/$item_info->pack_size)?></td>
			<td><?=(int)($pre_stock%$item_info->pack_size)?></td>
			<td><?=$pre_stock?></td>
			<? if($row->item_in>0){?>
			<td><?=$row->tr_from?></td>
			<td><?=$row->tr_no?></td>
			<td><div align="right"><? echo $item_ctn_in = (int)($row->item_in/$item_info->pack_size);?></div></td>
			<td><div align="right"><? echo $item_pcs_in = (int)($row->item_in%$item_info->pack_size); $total_in = $total_in + $row->item_in;?></div></td>
			<? }else{echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';}?>
            <? if($row->item_ex>0){?>
			<td><?=$row->tr_from?></td>
			<td><?=$row->tr_no?></td>
			<td><div align="right"><? echo $item_ctn_ex = (int)($row->item_ex/$item_info->pack_size);?></div></td>
			<td><div align="right"><? echo $item_pcs_ex = (int)($row->item_ex%$item_info->pack_size); $total_ex = $total_ex + $row->item_ex;?></div></td>
			

            <? }else{echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';}?>
			
            <td><?=(int)($final_stock/$item_info->pack_size)?></td>
            <td><?=(int)($final_stock%$item_info->pack_size)?></td>
			<td><?=$final_stock?></td>
			<td>&nbsp;<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$row->relevant_warehouse);?></td>
            <td>&nbsp;<?=find_a_field('user_activity_management','fname','user_id='.$row->entry_by)?></td>
            <td>&nbsp;<?=$row->entry_at?></td>
			<td>&nbsp;</td>
			</tr>
			<? }?>
			<tr class="footer">
			  			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td colspan="3">&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td><div align="right"><?=number_format((int)($total_in/$item_info->pack_size),2);?></div></td>
			  <td><div align="right"><?=number_format((int)($total_in%$item_info->pack_size),2);?></div></td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td><div align="right"><?=number_format((int)($total_ex/$item_info->pack_size),2);?></div></td>
			  <td><div align="right"><?=number_format((int)($total_ex%$item_info->pack_size),2);?></div></td>
			  <td colspan="5">&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>
</tbody>
</table>
<?
}








elseif($_REQUEST['report']==4) {

		if($sql==NULL) return NULL;
		$res	 = db_query($sql);
?>
  <table width="100%" border="0" cellpadding="2" cellspacing="0" id="ExportTable">

		<thead>
		<tr><td colspan="17" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';


		echo '<h2>Product Name : '.$item_info->item_name.' (Code:'.$item_info->item_id.')'.'<br>';
		echo 'Product Unit : '.$item_info->unit_name.'</h2>';
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
		  <th rowspan="2" bgcolor="#99CC99" style="text-align:center">S. Entry  NO </th>
		  <th colspan="5" bgcolor="#339999" style="text-align:center">PRODUCT RECEIVED</th>
		  <th colspan="5" bgcolor="#FFCC66" style="text-align:center">PRODUCT ISSUED</th>
		  <th rowspan="2" bgcolor="#FF99FF" style="text-align:center">Place</th>
		  <th colspan="2" bgcolor="#FFFF99" style="text-align:center">Prepared </th>
		  <th rowspan="2" bgcolor="#FFFF99" style="text-align:center">Note</th>
		  </tr>
		<tr>
			<th bgcolor="#339999">Tr Type</th>
			<th bgcolor="#339999">Tr No</th>
			<th bgcolor="#339999">Qty</th>
			<th bgcolor="#339999">Rate</th>		
			<th bgcolor="#339999">Taka</th>
			<th bgcolor="#FFCC66">Tr Type</th>
			<th bgcolor="#FFCC66">Tr No</th>
			<th bgcolor="#FFCC66">Qty</th>
			<th bgcolor="#FFCC66">Rate</th>
			<th bgcolor="#FFCC66">Taka</th>
		    <th bgcolor="#FFFF99" style="text-align:center">BY</th>
		    <th bgcolor="#FFFF99" style="text-align:center">AT</th>
		</tr>
		</thead><tbody>
<? $sl=1;
		while($row=mysqli_fetch_object($res))
			{
			if($sl==1) 
			{
			$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item where warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date<"'.$fr_date.'" and item_id='.$item_id);
			$pre_stock = (int)$pre->pre_stock;
			$pre_price = @($pre->pre_amt/$pre->pre_stock);
			$pre_amt   = $pre->pre_amt;
			}
			else
			{
			$pre_stock = $final_stock;
			$pre_price = $final_price;
			}
			
			$final_stock = @($pre_stock+($row->item_in-$row->item_ex));
			$final_price = @((($pre_stock*$pre_price)+(($row->item_in-$row->item_ex)*$row->item_price))/$final_stock);
			?>
			
			<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
			<td><?=$sl++;?></td>
			<td><?=$row->ji_date?></td>
			<td><?=$row->sr_no;?></td>
            <? if($row->item_in>0){?>
			<td><?=$row->tr_from?></td>
			<td><?=$row->tr_no?></td>
			<td><?=$row->item_in; $total_in = $total_in + $row->item_in;?></td>
			<td><?=number_format($row->item_price,2)?></td>
			<td><?=number_format(($row->item_in*$row->item_price),2)?></td>
            <? }else{echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';}?>
            <? if($row->item_ex>0){?>
			<td><?=$row->tr_from?></td>
			<td><?=$row->tr_no?></td>
			<td><?=$row->item_ex; $total_ex = $total_ex + $row->item_ex;?></td>
			<td><?=number_format($row->item_price,2)?></td>
			<td><?=number_format(($row->item_ex*$row->item_price),2)?></td>
            <td><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$row->relevant_warehouse);?></td>
            <td>&nbsp;<?=find_a_field('user_activity_management','fname','user_id='.$row->entry_by)?></td>
            <td>&nbsp;<?=$row->entry_at?></td>
            <? }else{echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';}?>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			</tr>
			<? }?>
			<tr class="footer">
			  			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td><?=number_format($total_in,2);?></td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td><?=number_format($total_ex,2);?></td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td colspan="2">&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  
		  </tr>
</tbody>
</table>
<?
}
elseif($_REQUEST['report']==3)
{
		if($sql==NULL) return NULL;
		$res	 = db_query($sql);
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0" id="ExportTable">
		
		<thead>
		<tr><td colspan="13" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
		
		echo '<h2>Product Name : '.$item_info->item_name.' (Code:'.$item_info->item_id.')'.'<br>';
		echo 'Product Unit : '.$item_info->unit_name.'</h2>';
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
		<th rowspan="2"  bgcolor="#a7d6ff" >S/L-3</th>
		<th rowspan="2"  bgcolor="#a7d6ff" >Date</th>
		<th rowspan="2"  bgcolor="#a7d6ff" >TR No </th>
		<th rowspan="2"  bgcolor="#a7d6ff" >SR No </th>
		<th colspan="1" bgcolor="#99CC99" style="text-align:center">OPENING BALANCE</th>
		<th colspan="2" bgcolor="#339999" style="text-align:center">PRODUCT RECEIVED</th>
		<th colspan="2" bgcolor="#FFCC66" style="text-align:center">PRODUCT ISSUED</th>
		<th colspan="1" bgcolor="#FFFF99" style="text-align:center">CLOSING BALANCE</th>
		<th rowspan="2" bgcolor="#FF99FF" style="text-align:center">Place</th>
		<th rowspan="2" bgcolor="#00CC99" style="text-align:center">BY</th>
		<th rowspan="2" bgcolor="#00CC99" style="text-align:center">AT</th>
		</tr>
		<tr>
		<th bgcolor="#99CC99">Qty</th>

		<th bgcolor="#339999">Tr Type</th>
		<th bgcolor="#339999">Qty</th>
		<th bgcolor="#FFCC66">Tr Type</th>
		<th bgcolor="#FFCC66">Qty</th>
		<th bgcolor="#FFFF99">Qty</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		while($row=mysqli_fetch_object($res))
		{
		if($sl==1) 
		{
		$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item where warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date<"'.$fr_date.'" and item_id='.$item_id);
		$pre_stock = (int)$pre->pre_stock;
		$pre_price = @($pre->pre_amt/$pre->pre_stock);
		$pre_amt   = $pre->pre_amt;
		}
		else
		{
		$pre_stock = $final_stock;
		$pre_price = $final_price;
		}
		
		$final_stock = $pre_stock+($row->item_in-$row->item_ex);
		$final_price = @((($pre_stock*$pre_price)+(($row->item_in-$row->item_ex)*$row->item_price))/$final_stock);
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->ji_date?></td>
		<td><?=$row->tr_no?></td>
		<td><?=$row->sr_no?></td>
		<td><?=$pre_stock?></td>

		<? if($row->item_in>0){?>
		<td><?=$row->tr_from?></td>
		<td><?=$row->item_in; $total_in = $total_in + $row->item_in;?></td>
		<? }else{echo '<td>&nbsp;</td><td>&nbsp;</td>';}?>
		<? if($row->item_ex>0){?>
		<td><?=$row->tr_from?></td>
		<td><?=$row->item_ex; $total_ex = $total_ex + $row->item_ex;?></td>
		<? }else{echo '<td>&nbsp;</td><td>&nbsp;</td>';}?>
		<td><?=$final_stock?></td>

		<td><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$row->relevant_warehouse);?></td>
		<td><?=find_a_field('user_activity_management','fname','user_id='.$row->entry_by)?></td>
		<td><?=$row->entry_at?></td>
		</tr>
		<? }?>
		<tr class="footer">
				  <td>&nbsp;</td>
		          <td>&nbsp;</td>
                  <td>&nbsp;</td>
          <td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td><?=number_format($total_in,2);?></td>
		<td>&nbsp;</td>
		<td><?=number_format($total_ex,2);?></td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		</tbody>
		</table>
		<?
}
elseif($_REQUEST['report']==33)
{
		if($sql==NULL) return NULL;
		$res	 = db_query($sql);
		if($item_id>0){
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0" id="ExportTable">
		
		<thead>
		<tr><td colspan="14" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1 class="center">'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';
		if(isset($report)) 
		echo '<h2 class="center">'.$report.'</h2>';
		
		
		echo '<h2 class="center">Product Name : '.$item_info->item_name.' (Code:'.$item_info->item_id.')'.' (FG Code:'.$item_info->finish_goods_code.')'.'<br>';
		echo 'Product Unit : '.$item_info->unit_name.'</h2>';
		echo '</div>';
		echo '<div class="center" style="width:50%">';
		if(isset($to_date)) 
		echo '<p >Date Interval : '.$fr_date.' To '.$to_date.'</p>';
		
		echo '</div><div class="center" style="width:40%">';
 		echo '<p>Warehouse Name: '.$warehouse_info.'</p>';
		echo '</div><div class="date" style="width:40%; text-align:right; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th rowspan="2" bgcolor="#a7d6ff" style="text-align:center" >S/L</th>
		<th rowspan="2" bgcolor="#a7d6ff" style="text-align:center" >Date</th>
		<th rowspan="2" bgcolor="#a7d6ff" style="text-align:center" >TR No </th>
		<th rowspan="2" bgcolor="#a7d6ff" style="text-align:center" >SR No </th>
		<th colspan="1" bgcolor="#99CC99" style="text-align:center">OPENING BALANCE</th>
		<th colspan="2" bgcolor="#339999" style="text-align:center">PRODUCT RECEIVED</th>
		<th colspan="2" bgcolor="#FFCC66" style="text-align:center">PRODUCT ISSUED</th>
		<th colspan="1" bgcolor="#FFFF99" style="text-align:center">CLOSING BALANCE</th>
		<th rowspan="2" bgcolor="#FF99FF" style="text-align:center">To Place</th>
		<th rowspan="2" bgcolor="#FF99FF" style="text-align:center">Relevant Place</th>
		<th rowspan="2" bgcolor="#00CC99" style="text-align:center">BY</th>
		<th rowspan="2" bgcolor="#00CC99" style="text-align:center">AT</th>
		</tr>
		<tr>
		<th bgcolor="#99CC99" style="text-align:center">Qty</th>

		<th bgcolor="#339999" style="text-align:center">Tr Type</th>
		<th bgcolor="#339999" style="text-align:center">Qty</th>
		<th bgcolor="#FFCC66" style="text-align:center">Tr Type</th>
		<th bgcolor="#FFCC66" style="text-align:center">Qty</th>
		<th bgcolor="#FFFF99" style="text-align:center">Qty</th>
		</tr>
		</thead><tbody>
		<? $sl=1; 
		
		$pre_stock = 0;
		$pre_price = 0;
		$pre_amt   = 0;
		while($row=mysqli_fetch_object($res))
		{
		    
		if($sl==1) 
		{
		$pre = find_all_field_sql("select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item where ji_date<'".$fr_date."'  and item_id='".$item_id."' ".$warehouse_con." ");
		$pre_stock = number_format($pre->pre_stock,6,'.','');
// 		if($pre->pre_amt>0){ $pre_price =  @($pre->pre_amt/$pre->pre_stock);}

        if ($pre->pre_amt > 0 && $pre->pre_stock > 0) {
            $pre_price = $pre->pre_amt / $pre->pre_stock;
        } else {
        
            $pre_price = 0; 
        }

		$pre_amt   = $pre->pre_amt;
		
		}
		else
		{
		$pre_stock = number_format($final_stock,6,'.','');
		$pre_price = number_format($final_price,6,'.','');
		}
		
		$rest_check = $row->item_in-$row->item_ex;
 		$final_stock = ($pre_stock+($row->item_in-$row->item_ex));
// 		$final_price = @((($pre_stock*$pre_price)+(($row->item_in-$row->item_ex)*$row->item_price))/$final_stock);
		
		if($final_stock>0){$final_price = @((($pre_stock*$pre_price)+(($row->item_in-$row->item_ex)*$row->item_price))/$final_stock);}
		else{ $final_price = 0;}
		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td style="text-align:center"><?=$sl++;?></td>
		<td style="text-align:center"><?=$row->ji_date?></td>
		<td style="text-align:center"><?=$row->tr_no?></td>
		<td style="text-align:center"><?=$row->sr_no?></td>
		<td style="text-align:right"><?=$pre_stock; $p_stok = $p_stok + $pre_stock;?></td>

		<? if($row->item_in>0){?>
		<td><?=$row->tr_from?></td>
		<td style="text-align:right"><?=$row->item_in; $total_in = $total_in + $row->item_in;?></td>
		<? }else{echo '<td>&nbsp;</td><td>&nbsp;</td>';}?>
		<? if($row->item_ex>0){?>
		<td><?=$row->tr_from?></td>
		<td style="text-align:right"><?=$row->item_ex; $total_ex = $total_ex + $row->item_ex;?></td>
		<? }else{echo '<td>&nbsp;</td><td>&nbsp;</td>';}?>
		<td style="text-align:right"><?=number_format($final_stock,2); $total_final_stock =  $total_final_stock+ $final_stock;?></td>

		<td><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$row->warehouse_id);?></td>
		<td><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$row->relevant_warehouse);?></td>
		<td><?=find_a_field('user_activity_management','fname','user_id='.$row->entry_by)?></td>
		<td><?=$row->entry_at?></td>
		</tr>
		<? }?>
		<tr>
				  <td>&nbsp;</td>
		          <td>&nbsp;</td>
                  <td>&nbsp;</td>
          <td style="text-align:right"><strong>Total :</strong></td>
		<td style="text-align:right"><? number_format($p_stok,2);?></td>

		<td>&nbsp;</td>
		<td style="text-align:right"><?=number_format($total_in,2);?></td>
		<td>&nbsp;</td>
		<td style="text-align:right"><?=number_format($total_ex,2);?></td>
		<td style="text-align:right"><? number_format($total_final_stock,2);?></td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		</tbody>
		</table>
		<?
}
else{
echo "Please select an Item";
}
}


elseif($_REQUEST['report']==235)
{

		if($sql==NULL) return NULL;
		$res	 = db_query($sql);
		if($item_id>0){
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0" id="ExportTable">
		
		<thead>
		<tr><td colspan="18" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1 class="center">'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';
		if(isset($report)) 
		echo '<h2 class="center">'.$report.'</h2>';
		
		
		echo '<h2 class="center">Product Name : '.$item_info->item_name.' (Code:'.$item_info->item_id.')'.' (FG Code:'.$item_info->finish_goods_code.')'.'<br>';
		echo 'Product Unit : '.$item_info->unit_name.'</h2>';
		echo '</div>';
		echo '<div class="left" style="width:50%">';
		if(isset($to_date)) 
		echo '<p>Date Interval : '.$fr_date.' To '.$to_date.'</p>';
		
		echo '</div><div class="right" style="width:40%">';
 		echo '<p>Warehouse Name: '.$warehouse_info.'</p>';
		echo '</div><div class="date" style="text-align:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th rowspan="2" bgcolor="#a7d6ff" style="text-align:center">S/L</th>
		<th rowspan="2" bgcolor="#a7d6ff" style="text-align:center">Date</th>
		<th rowspan="2" bgcolor="#a7d6ff"  style="text-align:center">TR No </th>
		<th rowspan="2" bgcolor="#a7d6ff" style="text-align:center">SR No </th>
		<th colspan="2" bgcolor="#99CC99" style="text-align:center">OPENING BALANCE</th>
		<th colspan="3" bgcolor="#339999" style="text-align:center">PRODUCT RECEIVED</th>
		<th colspan="3" bgcolor="#FFCC66" style="text-align:center">PRODUCT ISSUED</th>
		<th colspan="2" bgcolor="#FFFF99" style="text-align:center">CLOSING BALANCE</th>
		<th rowspan="2" bgcolor="#FF99FF" style="text-align:center">To Place</th>
		<th rowspan="2" bgcolor="#FF99FF" style="text-align:center">Relevant Place</th>
		<th rowspan="2" bgcolor="#00CC99" style="text-align:center">BY</th>
		<th rowspan="2" bgcolor="#00CC99" style="text-align:center">AT</th>
		</tr>
		<tr>
		<th bgcolor="#99CC99" style="text-align:center">Qty</th>
		<th bgcolor="#99CC99" style="text-align:center">Rate</th>

		<th bgcolor="#339999" style="text-align:center">Tr Type</th>
		<th bgcolor="#339999" style="text-align:center">Qty</th>
		<th bgcolor="#339999" style="text-align:center">Rate</th>
		
		<th bgcolor="#FFCC66" style="text-align:center">Tr Type</th>
		<th bgcolor="#FFCC66" style="text-align:center">Qty</th>
		<th bgcolor="#FFCC66" style="text-align:center">Rate</th>
		
		<th bgcolor="#FFFF99" style="text-align:center">Qty</th>
		<th bgcolor="#FFFF99" style="text-align:center">Rate</th>
		</tr>
		</thead><tbody>
		<? $sl=1; 
		
		$pre_stock = 0;
		$pre_price = 0;
		$pre_amt   = 0;
		while($row=mysqli_fetch_object($res))
		{
		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td style="text-align:center"><?=$sl++;?></td>
		<td style="text-align:center"><?=$row->ji_date?></td>
		<td style="text-align:center"><?=$row->tr_no?></td>
		<td style="text-align:center"><?=$row->sr_no?></td>
		<td style="text-align:right"><?=$row->pre_stock?></td>
		<td><?=$row->pre_price?></td>

		<? if($row->item_in>0){?>
		<td><?=$row->tr_from?></td>
		<td style="text-align:right"><?=$row->item_in; $total_in = $total_in + $row->item_in;?></td>
		<td style="text-align:center"><?=$row->item_price; ?></td>
		<? }else{echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';}?>
		<? if($row->item_ex>0){?>
		<td><?=$row->tr_from?></td>
		<td style="text-align:right"> <?=$row->item_ex; $total_ex = $total_ex + $row->item_ex;?></td>
		<td style="text-align:center"><?=$row->item_price; ?></td>
		<? }else{echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';}?>
		<td style="text-align:right"><?=$row->final_stock?></td>
		<td style="text-align:center"><?=$row->final_price?></td>

		<td><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$row->warehouse_id);?></td>
		<td><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$row->relevant_warehouse);?></td>
		<td><?=find_a_field('user_activity_management','fname','user_id='.$row->entry_by)?></td>
		<td><?=$row->entry_at?></td>
		</tr>
		<? }?>
		<tr >
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td style="text-align:right"><strong>Total :</strong></td>
			<td><?=number_format($total_in,2);?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><?=number_format($total_ex,2);?></td>
			<td>&nbsp;</td>
			
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		</tbody>
		</table>
		<?
}else{
echo "Please select an Item";
}
}

elseif($_REQUEST['report']==2482025)
{

		if($sql==NULL) return NULL;
		$res	 = db_query($sql);
		if($item_id>0){
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0" id="ExportTable">
		
		<thead>
		<tr><td colspan="18" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1 class="center">'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';
		if(isset($report)) 
		echo '<h2 class="center">'.$report.'</h2>';
		
		
		echo '<h2 class="center">Product Name : '.$item_info->item_name.' (Code:'.$item_info->item_id.')'.' (FG Code:'.$item_info->finish_goods_code.')'.'<br>';
		echo 'Product Unit : '.$item_info->unit_name.'</h2>';
		echo '</div>';
		echo '<div class="left" style="width:50%">';
		if(isset($to_date)) 
		echo '<p>Date Interval : '.$fr_date.' To '.$to_date.'</p>';
		
		echo '</div><div class="right" style="width:40%">';
 		echo '<p>Warehouse Name: '.$warehouse_info.'</p>';
		echo '</div><div class="date" style="text-align:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th rowspan="2" bgcolor="#a7d6ff" style="text-align:center">S/L</th>
		<th rowspan="2" bgcolor="#a7d6ff" style="text-align:center">Date</th>
		<th rowspan="2" bgcolor="#a7d6ff"  style="text-align:center">TR No </th>
		<th rowspan="2" bgcolor="#a7d6ff" style="text-align:center">SR No </th>
		<th colspan="2" bgcolor="#99CC99" style="text-align:center">OPENING BALANCE</th>
		<th colspan="3" bgcolor="#339999" style="text-align:center">PRODUCT RECEIVED</th>
		<th colspan="3" bgcolor="#FFCC66" style="text-align:center">PRODUCT ISSUED</th>
		<th colspan="2" bgcolor="#FFFF99" style="text-align:center">CLOSING BALANCE</th>
		<th rowspan="2" bgcolor="#FF99FF" style="text-align:center">To Place</th>
		<th rowspan="2" bgcolor="#FF99FF" style="text-align:center">Relevant Place</th>
		<th rowspan="2" bgcolor="#00CC99" style="text-align:center">BY</th>
		<th rowspan="2" bgcolor="#00CC99" style="text-align:center">AT</th>
		</tr>
		<tr>
		<th bgcolor="#99CC99" style="text-align:center">Qty</th>
		<th bgcolor="#99CC99" style="text-align:center">Rate</th>

		<th bgcolor="#339999" style="text-align:center">Tr Type</th>
		<th bgcolor="#339999" style="text-align:center">Qty</th>
		<th bgcolor="#339999" style="text-align:center">Rate</th>
		
		<th bgcolor="#FFCC66" style="text-align:center">Tr Type</th>
		<th bgcolor="#FFCC66" style="text-align:center">Qty</th>
		<th bgcolor="#FFCC66" style="text-align:center">Rate</th>
		
		<th bgcolor="#FFFF99" style="text-align:center">Qty</th>
		<th bgcolor="#FFFF99" style="text-align:center">Rate</th>
		</tr>
		</thead><tbody>
		<? $sl=1; 
		
		$pre_stock = 0;
		$pre_price = 0;
		$pre_amt   = 0;
		while($row=mysqli_fetch_object($res))
		{
		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td style="text-align:center"><?=$sl++;?></td>
		<td style="text-align:center"><?=$row->ji_date?></td>
		<td style="text-align:center"><?=$row->tr_no?></td>
		<td style="text-align:center"><?=$row->sr_no?></td>
		<td style="text-align:right"><?=$row->pre_stock?></td>
		<td><?=$row->pre_price?></td>

		<? if($row->item_in>0){?>
		<td><?=$row->tr_from?></td>
		<td style="text-align:right"><?=$row->item_in; $total_in = $total_in + $row->item_in;?></td>
		<td style="text-align:center"><?=$row->item_price; ?></td>
		<? }else{echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';}?>
		<? if($row->item_ex>0){?>
		<td><?=$row->tr_from?></td>
		<td style="text-align:right"> <?=$row->item_ex; $total_ex = $total_ex + $row->item_ex;?></td>
		<td style="text-align:center"><?=$row->item_price; ?></td>
		<? }else{echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';}?>
		<td style="text-align:right"><?=$row->final_stock?></td>
		<td style="text-align:center"><?=$row->final_price?></td>

		<td><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$row->warehouse_id);?></td>
		<td><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$row->relevant_warehouse);?></td>
		<td><?=find_a_field('user_activity_management','fname','user_id='.$row->entry_by)?></td>
		<td><?=$row->entry_at?></td>
		</tr>
		<? }?>
		<tr >
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td style="text-align:right"><strong>Total :</strong></td>
			<td><?=number_format($total_in,2);?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><?=number_format($total_ex,2);?></td>
			<td>&nbsp;</td>
			
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		</tbody>
		</table>
		<?
}else{
echo "Please select an Item";
}
}








elseif($_REQUEST['report']==34)
{
		if($sql==NULL) return NULL;
		$res	 = db_query($sql);
		if($item_id>0){
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0" id="ExportTable">
		
		<thead>
		<tr><td colspan="16" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1 class="center">'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';
		if(isset($report)) 
		echo '<h2 class="center">'.$report.'</h2>';
		
		
		echo '<h2 class="center">Product Name : '.$item_info->item_name.' (Code:'.$item_info->item_id.')'.' (FG Code:'.$item_info->finish_goods_code.')'.'<br>';
		echo 'Product Unit : '.$item_info->unit_name.'</h2>';
		echo '</div>';
		echo '<div class="center" style="width:50%">';
		if(isset($to_date)) 
		echo '<p>Date Interval : '.$fr_date.' To '.$to_date.'</p>';
		
		echo '</div><div class="center" style="width:40%">';
 		echo '<p>Warehouse Name: '.$warehouse_info.'</p>';
		echo '</div><div class="date" style="width:40%; text-align:right; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th rowspan="2" bgcolor="#a7d6ff" style="text-align:center" >S/L</th>
		<th rowspan="2" bgcolor="#a7d6ff" style="text-align:center" >Date</th>
		<th rowspan="2" bgcolor="#a7d6ff" style="text-align:center">TR No </th>
		<th rowspan="2" bgcolor="#a7d6ff"  style="text-align:center">SR No </th>
		<th colspan="1" bgcolor="#99CC99" style="text-align:center">OPENING BALANCE</th>
		<th colspan="3" bgcolor="#339999" style="text-align:center">PRODUCT RECEIVED</th>
		<th colspan="3" bgcolor="#FFCC66" style="text-align:center">PRODUCT ISSUED</th>
		<th colspan="1" bgcolor="#FFFF99" style="text-align:center">CLOSING BALANCE</th>
		<th rowspan="2" bgcolor="#FF99FF" style="text-align:center">To Place</th>
		<th rowspan="2" bgcolor="#FF99FF" style="text-align:center">Relevant Place</th>
		<th rowspan="2" bgcolor="#00CC99" style="text-align:center">BY</th>
		<th rowspan="2" bgcolor="#00CC99" style="text-align:center">AT</th>
		</tr>
		<tr>
		<th bgcolor="#99CC99" style="text-align:center">Qty</th>

		<th bgcolor="#339999" style="text-align:center">Tr Type</th>
		<th bgcolor="#339999" style="text-align:center">Qty</th>
		<th bgcolor="#339999" style="text-align:center">Rate</th>
		
		<th bgcolor="#FFCC66" style="text-align:center">Tr Type</th>
		<th bgcolor="#FFCC66" style="text-align:center">Qty</th>
		<th bgcolor="#FFCC66" style="text-align:center">Rate</th>
		
		<th bgcolor="#FFFF99" style="text-align:center">Qty</th>
		</tr>
		</thead><tbody>
		<? $sl=1; 
		
		$pre_stock = 0;
		$pre_price = 0;
		$pre_amt   = 0;
		while($row=mysqli_fetch_object($res))
		{
		    
		if($sl==1) 
		{
		$pre = find_all_field_sql("select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item where ji_date<'".$fr_date."'  and item_id='".$item_id."' ".$warehouse_con." ");
		$pre_stock = number_format($pre->pre_stock,6,'.','');
// 		if($pre->pre_amt>0){ $pre_price =  @($pre->pre_amt/$pre->pre_stock);}

        if ($pre->pre_amt > 0 && $pre->pre_stock > 0) {
            $pre_price = $pre->pre_amt / $pre->pre_stock;
        } else {
        
            $pre_price = 0; 
        }

		$pre_amt   = $pre->pre_amt;
		
		}
		else
		{
		$pre_stock = number_format($final_stock,6,'.','');
		$pre_price = number_format($final_price,6,'.','');
		}
		
		$rest_check = $row->item_in-$row->item_ex;
 		$final_stock = ($pre_stock+($row->item_in-$row->item_ex));
// 		$final_price = @((($pre_stock*$pre_price)+(($row->item_in-$row->item_ex)*$row->item_price))/$final_stock);
		
		if($final_stock>0){$final_price = @((($pre_stock*$pre_price)+(($row->item_in-$row->item_ex)*$row->item_price))/$final_stock);}
		else{ $final_price = 0;}
		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td style="text-align:center"><?=$sl++;?></td>
		<td style="text-align:center"><?=$row->ji_date?></td>
		<td style="text-align:center"><?=$row->tr_no?></td>
		<td style="text-align:center"><?=$row->sr_no?></td>
		<td style="text-align:right"><?=$pre_stock?></td>

		<? if($row->item_in>0){?>
		<td><?=$row->tr_from?></td>
		<td style="text-align:right"><?=$row->item_in; $total_in = $total_in + $row->item_in;?></td>
		<td style="text-align:center"><?=$row->item_price; ?></td>
		<? }else{echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';}?>
		<? if($row->item_ex>0){?>
		<td><?=$row->tr_from?></td>
		<td style="text-align:right"><?=$row->item_ex; $total_ex = $total_ex + $row->item_ex;?></td>
		<td style="text-align:center"><?=$row->item_price; ?></td>
		<? }else{echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';}?>
		<td style="text-align:right"><?=number_format($final_stock,2)?></td>

		<td><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$row->warehouse_id);?></td>
		<td><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$row->relevant_warehouse);?></td>
		<td><?=find_a_field('user_activity_management','fname','user_id='.$row->entry_by)?></td>
		<td><?=$row->entry_at?></td>
		</tr>
		<? }?>
		<tr >
				  <td>&nbsp;</td>
		          <td>&nbsp;</td>
                  <td>&nbsp;</td>
          <td>&nbsp;</td>
		<td>&nbsp;</td>

		<td style="text-align:right"><strong>Total :</strong></td>
		<td style="text-align:right"><?=number_format($total_in,2);?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td style="text-align:right"><?=number_format($total_ex,2);?></td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		</tbody>
		</table>
		<?
}else{
echo "Please select an Item";
}
}
elseif($_REQUEST['report']==1) {

		if($sql==NULL) return NULL;
		$res	 = db_query($sql);
		?>
  <table width="100%" border="0" cellpadding="2" cellspacing="0" id="ExportTable">

		<thead>
		<tr><td colspan="19" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';


		echo '<h2>Product Name : '.$item_info->item_name.' (Code:'.$item_info->item_id.')'.'<br>';
		echo 'Product Unit : '.$item_info->unit_name.'</h2>';
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
		  <th colspan="3" bgcolor="#99CC99" style="text-align:center">OPENING BALANCE</th>
		  <th colspan="5" bgcolor="#339999" style="text-align:center">PRODUCT RECEIVED</th>
		  <th colspan="5" bgcolor="#FFCC66" style="text-align:center">PRODUCT ISSUED</th>
		  <th colspan="3" bgcolor="#FFFF99" style="text-align:center">CLOSING BALANCE</th>
		  <th rowspan="2" bgcolor="#FF99FF" style="text-align:center">Place</th>
		</tr>
		<tr>
			<th bgcolor="#99CC99">Qty</th>
			<th bgcolor="#99CC99">Rate</th>		
			<th bgcolor="#99CC99">Taka</th>
			<th bgcolor="#339999">Tr Type</th>
			<th bgcolor="#339999">Tr No</th>
			<th bgcolor="#339999">Qty</th>
			<th bgcolor="#339999">Rate</th>		
			<th bgcolor="#339999">Taka</th>
			<th bgcolor="#FFCC66">Tr Type</th>
			<th bgcolor="#FFCC66">Tr No</th>
			<th bgcolor="#FFCC66">Qty</th>
			<th bgcolor="#FFCC66">Rate</th>
			<th bgcolor="#FFCC66">Taka</th>
			<th bgcolor="#FFFF99">Qty</th>
			<th bgcolor="#FFFF99">Rate</th>
			<th bgcolor="#FFFF99">Taka</th>
		  </tr>
		</thead><tbody>
<?
		while($row=mysqli_fetch_object($res))
			{
			if($old_price>0) $open_price = $old_price;
			else $open_price = $row->pre_price;
			$sl++;?>
			
			<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
			<td><?=$sl?></td>
			<td><?=$row->ji_date?></td>
			<td><?=$row->pre_stock?></td>
			<td><?=number_format($open_price,2)?></td>
			<td><?=number_format(($row->pre_stock*$open_price),2)?></td>
            <? if($row->item_in>0){?>
			<td><?=$row->tr_from?></td>
			<td><?=$row->tr_no?></td>
			<td><?=$row->item_in; $total_in = $total_in + $row->item_in;?></td>
			<td><?=number_format($row->item_price,2)?></td>
			<td><?=number_format(($row->item_in*$row->item_price),2)?></td>
            <? }else{echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';}?>
            <? if($row->item_ex>0){?>
			<td><?=$row->tr_from?></td>
			<td><?=$row->tr_no?></td>
			<td><?=$row->item_ex; $total_ex = $total_ex + $row->item_ex;?></td>
			<td><?=number_format($row->item_price,2)?></td>
			<td><?=number_format(($row->item_ex*$row->item_price),2)?></td>
            <? }else{echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';}?>
			<td><?=$row->final_stock?></td>
			<td><?=number_format($row->final_price,2)?></td>
			<td><?=number_format(($row->final_stock*$row->final_price),2)?></td>
			<td><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$row->relevant_warehouse);?></td>
            </tr>
			<? $old_price = $row->final_price;}?>
			<tr class="footer">
			  			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td><?=number_format($total_in,2);?></td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td><?=number_format($total_ex,2);?></td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>
</tbody>
</table>
<?
}
else
{

		if($sql==NULL) return NULL;
		$res	 = db_query($sql);
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0" id="ExportTable">

		<thead>
		<tr><td colspan="10" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';


		echo '<h2>Product Name : '.$item_info->item_name.'(Code:'.$item_info->item_id.')'.'<br>';
		echo 'Product Unit : '.$item_info->unit_name.'</h2>';
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
		  <th style="text-align:center">OPENING BALANCE</th>
		  <th colspan="3" style="text-align:center">PRODUCT RECEIVED</th>
		  <th colspan="3" style="text-align:center">PRODUCT ISSUED</th>
		  <th style="text-align:center">CLOSING BALANCE</th>
		  </tr>
		<tr>
<!--		j.ji_date,j.pre_stock,j.item_in,j.item_ex,j.final_stock,j.tr_from,j.tr_no,j.entry_by,j.entry_at-->
		<th>Qty</th>
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
		while($row=mysqli_fetch_object($res))
			{$sl++;?>
					<tr>
			<td><?=$sl?></td>
			<td><?=$row->ji_date?></td>
			<td><?=$row->pre_stock?></td>
			<? if($row->item_in>0){?>
			<td><?=$row->tr_from?></td>
			<td><?=$row->tr_no?></td>
			<td><?=$row->item_in?></td>
			<? }else{echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';}?>
            <? if($row->item_ex>0){?>
			<td><?=$row->tr_from?></td>
			<td><?=$row->tr_no?></td>
			<td><?=$row->item_ex?></td>
			<? }else{echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';}?>
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