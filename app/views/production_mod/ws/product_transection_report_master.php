<?

//require "../../../engine/tools/check.php";
//require "../../../engine/configure/db_connect.php";
//require "../../../engine/tools/my.php";


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


date_default_timezone_set('Asia/Dhaka');



if(isset($_REQUEST['submit'])&&isset($_REQUEST['report'])&&$_REQUEST['report']>0)

{

	if((strlen($_REQUEST['t_date'])==10)&&(strlen($_REQUEST['f_date'])==10))

	{

		$to_date=$_REQUEST['t_date'];

		$fr_date=$_REQUEST['f_date'];

		$date_con=' and j.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';

	}



if($_REQUEST['item']!=''){$item = explode('#>',$_REQUEST['item']);

if($item[1]>0){			

$item_id=$item[1];}}

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

where w.warehouse_id=j.warehouse_id and j.warehouse_id='".$_POST['warehouse_id']."' ".$date_con.$item_con." order by j.id";

	break;

	case 2:

$report="BIN CARD (Summary)";

		$s=1;

$sql="select j.* from 

journal_item j  , warehouse w

where w.warehouse_id=j.warehouse_id and j.warehouse_id='".$_POST['warehouse_id']."' ".$date_con.$item_con." order by j.id";

	break;

	case 3:

$report="Product BIN CARD (Details)";

if($_POST['warehouse_id']>0) $con = " and j.warehouse_id='".$_POST['warehouse_id']."'";



elseif($_POST['section_id']>0)

{

	$sections .= '';

	$ssql = 'select warehouse_id from warehouse where section_id='.$_POST['section_id'];

	$qquery = db_query($ssql);

	while($sec = mysqli_fetch_object($qquery))

	{

	if($sections == '') $sections .= $sec->warehouse_id;

	else $sections .= ','.$sec->warehouse_id;

	}

	$con = " and j.warehouse_id in (".$sections.")";

}

$sql="select j.* from 

journal_item j  , warehouse w

where w.warehouse_id=j.warehouse_id ".$con.$date_con.$item_con." and w.warehouse_id!=5 order by j.ji_date";

	break;

		case 4:

$report="BIN CARD";



$sql="select j.* from 

journal_item j  , warehouse w

where w.warehouse_id=j.warehouse_id and j.warehouse_id='".$_POST['warehouse_id']."' ".$date_con.$item_con." order by j.ji_date";

	break;

	

			case 5:

$report="BIN CARD (Finish Goods)";



$sql="select j.* from 

journal_item j  , warehouse w

where w.warehouse_id=j.warehouse_id and j.warehouse_id='".$_POST['warehouse_id']."' ".$date_con.$item_con." order by j.ji_date";

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

</head>

<body>

<div align="center" id="pr">

<input type="button" value="Print" onclick="hide();window.print();"/>

</div>

<div class="main">

<?



if($_REQUEST['report']==5) {



		if($sql==NULL) return NULL;

		$res	 = db_query($sql);

?>

  <table width="100%" border="0" cellpadding="2" cellspacing="0">



		<thead>

		<tr><td colspan="14" style="border:0px;">

		<?

		echo '<div class="header">';

		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_POST['warehouse_id']).'</h1>';

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

		echo '<p>Warehouse Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$_POST['warehouse_id']).'</p>';

		echo '</div><div class="date" style="width:40%; text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		?>

		</td></tr>

		<tr>

		  <th rowspan="2">S/L</th>

		  <th rowspan="2">Date</th>

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

			if($sl==1) 

			{

			$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item where warehouse_id = "'.$_POST['warehouse_id'].'" and ji_date<"'.$fr_date.'" and item_id='.$item_id);

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

  <table width="100%" border="0" cellpadding="2" cellspacing="0">



		<thead>

		<tr><td colspan="13" style="border:0px;">

		<?

		echo '<div class="header">';

		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_POST['warehouse_id']).'</h1>';

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

		echo '<p>Warehouse Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$_POST['warehouse_id']).'</p>';

		echo '</div><div class="date" style="width:40%; text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		?>

		</td></tr>

		<tr>

		  <th rowspan="2">S/L</th>

		  <th rowspan="2">Date</th>

		  <th rowspan="2" bgcolor="#99CC99" style="text-align:center">SR NO </th>

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

			$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item where warehouse_id = "'.$_POST['warehouse_id'].'" and ji_date<"'.$fr_date.'" and item_id='.$item_id);

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

		<table width="100%" border="0" cellpadding="2" cellspacing="0">

		

		<thead>

		<tr><td colspan="19" style="border:0px;">

		<?

		echo '<div class="header">';

		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_POST['warehouse_id']).'</h1>';

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

		echo '<p>Warehouse Name: '.(($_POST['warehouse_id']>0)?find_a_field('warehouse','warehouse_name','warehouse_id='.$_POST['warehouse_id']):'All Production Line').'</p>';

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

		<th rowspan="2" bgcolor="#FF99FF" style="text-align:center">Relevant Place</th>

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

		<? $sl=1;

		while($row=mysqli_fetch_object($res))

		{



		if($sl==1) 

		{



		$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item j where 1 and warehouse_id!=5 and ji_date<"'.$fr_date.'" and item_id='.$item_id.' '.$con);

		$pre_stock = $pre->pre_stock;

		$pre_price = @($pre->pre_amt/$pre->pre_stock);

		$pre_amt   = $pre->pre_amt;

		}

		else

		{

		$pre_stock = $final_stock;

		$pre_price = $final_price;

		}



		$final_stock = number_format($pre_stock + ($row->item_in-($row->item_ex)),4,'.','');

		//$final_stock = number_format(($pre_stock+($row->item_in - $row->item_ex)),2,'.');

		$final_price = @((($pre_stock*$pre_price)+(($row->item_in-$row->item_ex)*$row->item_price))/$final_stock);

		?>

		

		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>

		<td><?=$sl++;?></td>

		<td><?=$row->ji_date?></td>

		<td><?=$pre_stock?></td>

		<td><?=number_format($pre_price,2)?></td>

		<td><?=number_format(($pre_stock*$pre_price),2)?></td>

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

		<td><?=$final_stock?></td>

		<td><?=number_format($final_price,2)?></td>

		<td><?=number_format(($final_stock*$final_price),2)?></td>

		<td><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$row->warehouse_id);?></td>

		<td><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$row->relevant_warehouse);?></td>

		

		</tr>

		<? }?>

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

		<td>&nbsp;</td>

		</tr>

		</tbody>

		</table>

		<?

}

elseif($_REQUEST['report']==1) {



		if($sql==NULL) return NULL;

		$res	 = db_query($sql);

		?>

  <table width="100%" border="0" cellpadding="2" cellspacing="0">



		<thead>

		<tr><td colspan="17" style="border:0px;">

		<?

		echo '<div class="header">';

		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_POST['warehouse_id']).'</h1>';

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

		echo '<p>Warehouse Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$_POST['warehouse_id']).'</p>';

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

		<table width="100%" border="0" cellpadding="2" cellspacing="0">



		<thead>

		<tr><td colspan="10" style="border:0px;">

		<?

		echo '<div class="header">';

		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_POST['warehouse_id']).'</h1>';

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

		echo '<p>Warehouse Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$_POST['warehouse_id']).'</p>';

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

<?      while($row=mysqli_fetch_object($res))

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

<? }?>

</tbody>

</table>

<?

}

?>



</div>

</body>

</html>