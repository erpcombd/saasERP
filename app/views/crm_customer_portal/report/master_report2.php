<?

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
date_default_timezone_set('Asia/Dhaka');

if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)
{
	if((strlen($_POST['t_date'])==10)&&(strlen($_POST['f_date'])==10))
	{
		$t_date=$_POST['t_date'];
		$f_date=$_POST['f_date'];
	}
	
	if($_POST['warehouse_id']>0) 				$warehouse_id=$_POST['warehouse_id'];
	if($_POST['item_id']>0) 					$item_id=$_POST['item_id'];
	if($_POST['receive_status']!='') 			$receive_status=$_POST['receive_status'];
	if($_POST['issue_status']!='') 				$issue_status=$_POST['issue_status'];
	if($_POST['item_sub_group']>0) 				$sub_group_id=$_POST['item_sub_group'];
	if($_POST['item_brand']!='') 				    $item_brand=$_POST['item_brand'];
	if($_POST['product_group']!='') 			$product_group=$_POST['product_group'];
	if($_POST['dealer_type']!='') 				$dealer_type=$_POST['dealer_type'];



switch ($_POST['report']) {
    
	case 1:
		$report="Warehouse Item Transection Report";
		if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 
		
		if(isset($receive_status)){	
			if($receive_status=='All_Purchase')
			{$status_con=' and a.tr_from in ("Purchase","Local Purchase","Import")';}
			else
			{$status_con=' and a.tr_from="'.$receive_status.'"';}
		}
		
		elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 
		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		
		 $sql='select ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `IN`,a.item_ex as `OUT`,a.item_price as rate,((a.item_in+a.item_ex)*a.item_price) as amount,a.tr_from as tr_type,sr_no, (select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.tr_no,a.entry_at,c.fname as User 
		   
		   from journal_item a, item_info i, user_activity_management c , item_sub_group s where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and
		    a.item_id=i.item_id'.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' order by a.id';
	break;
    case 2:
		$report="Warehouse Present Stock";
		if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 
		if(isset($receive_status)) 			{$status_con=' and a.tr_from="'.$receive_status.'"';} 
		elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 
		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.journal_item between \''.$fr_date.'\' and \''.$to_date.'\'';}
		

	break;
	    case 3:
		$report="Warehouse Present Stock";
		if(isset($warehouse_id)) 				{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 
		if(isset($receive_status)) 				{$status_con=' and a.tr_from="'.$receive_status.'"';} 
		elseif(isset($issue_status)) 			{$status_con=' and a.tr_from="'.$issue_status.'"';} 
		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.journal_item between \''.$fr_date.'\' and \''.$to_date.'\'';}
		

		break;
	
    	case 4:
		$report="Warehouse Present Stock (Finish Goods)";
		break;
	
		case 5:
		$report="Details Sales Report";
		if(isset($warehouse_id)) 			{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 
		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 
		if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 

		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between "'.$fr_date.'" and "'.$to_date.'"';}

		
		$sql='select 
		m.pi_no,
		a.ji_date,
		w.warehouse_name  as warehouse_to,
		i.item_brand as brand,
		a.sr_no,
		i.finish_goods_code as fg,
		i.item_name,
		
		i.unit_name as unit,
		a.item_in as qty,
		a.item_price as rate,
		(a.item_in*a.item_price) as amt
		from journal_item a, item_info i, user_activity_management c,warehouse w,production_issue_master m,production_issue_detail d  where w.use_type="SD" and a.item_in>0 and 
		d.id=a.tr_no and d.pi_no=m.pi_no and w.warehouse_id=a.warehouse_id and a.tr_from="Issue" and c.user_id=a.entry_by and a.item_id=i.item_id'.$date_con.$warehouse_con.$item_con.$item_brand_con.' group by d.id order by a.id';
		
		break;
		
		case 6:
		$report="Sales Report(Brief)";
		if(isset($warehouse_id)) 			{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 
		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 
		if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 

		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between "'.$fr_date.'" and "'.$to_date.'"';}

		
		$sql='select 
		
		i.finish_goods_code as fg,
		i.item_name,
		i.unit_name as unit,
		i.item_brand as brand,
		sum(a.item_in) as qty,
		sum(a.item_in*a.item_price)/sum(a.item_in) as rate,
		sum(a.item_in*a.item_price) as sale_Amt,
		i.p_price as rate,
		sum(a.item_in*p_price) as cost_Amt,
		(sum(a.item_in*a.item_price) - sum(a.item_in*p_price))profit
		from journal_item a, item_info i, user_activity_management c,warehouse w where w.use_type="SD" and a.item_in>0 and 
		w.warehouse_id=a.warehouse_id and a.tr_from="Issue" and c.user_id=a.entry_by and a.item_id=i.item_id'.$date_con.$warehouse_con.$item_con.$item_brand_con.' group by  a.item_id order by i.finish_goods_code';
		break;
		
		
		case 7:
		$report="Chalan Wise Sales Report";
		if(isset($warehouse_id)) 			{$con.=' and m.warehouse_to='.$warehouse_id;}

		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $con.=' and m.pi_date between "'.$fr_date.'" and "'.$to_date.'"';}

		$sql='select 
m.pi_no, m.pi_date,  w.warehouse_name as warehouse_to, m.remarks as sl_no, m.carried_by,
		sum(a.item_in*a.item_price) as amt
		from journal_item a, item_info i, user_activity_management c,warehouse w,production_issue_master m,production_issue_detail d  where w.use_type="SD" and a.item_in>0 and  
		d.id=a.tr_no and d.pi_no=m.pi_no and w.warehouse_id=a.warehouse_id and a.tr_from="Issue" and c.user_id=a.entry_by and a.item_id=i.item_id'.$con.' group by d.pi_no order by a.id';
				
		//$sql='select  	a.pi_no, a.pi_date,  b.warehouse_name as Depot, a.remarks as sl_no, a.carried_by,sum(total_amt) as total_amt from production_issue_master a,production_issue_detail c,warehouse b where   a.warehouse_from='.$_SESSION['user']['depot'].' and a.pi_no=c.pi_no and a.warehouse_to=b.warehouse_id and b.use_type!="PL" '.$con.' group by c.pi_no order by a.pi_no desc';
		break;
		
		case 51:
		$report="Details Return Report";
		if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 
		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand="'.$item_brand.'"';} 
		if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 
		if(isset($dealer_type)) 			{$dealer_type_con=' and d.dealer_type="'.$dealer_type.'"';} 
		if(isset($product_group)) 			{$product_group_con=' and d.product_group="'.$product_group.'"';} 

		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.or_date between "'.$fr_date.'" and "'.$to_date.'"';}
		
	if(isset($dealer_type)){
		if($dealer_type=='MordernTrade')		{$dealer_type_con = ' and ( d.dealer_type="Corporate" or  d.dealer_type="SuperShop" or  d.product_group="M") ';}
		elseif($dealer_type=='Distributor')		{$dealer_type_con = ' and d.dealer_type="'.$dealer_type.'" and ( d.product_group!="M") ';}
		else 									{$dealer_type_con = ' and d.dealer_type="'.$dealer_type.'"';}
		}

		
$sql='select  
		a.or_no as sr_no,
		a.or_date as sr_date,
		a.vendor_id as dealer_code,
		a.vendor_name as dealer,
		a.or_subject as serial_no,
		a.or_details as chalan_no,
		i.item_brand as brand,
		i.finish_goods_code as fg,
		i.item_name,
		
		i.unit_name as unit,
		b.rate,
		b.qty,
		(b.rate*b.qty) as Total,(rate*bonus_qty) as free_goods,(bonus_rate*qty) as cash_discount,
		((qty*rate)-(rate*bonus_qty)) as sales_return

from item_info i,warehouse_other_receive a, warehouse_other_receive_detail b ,warehouse w, dealer_info d
where 
a.vendor_id=d.dealer_code 
and b.warehouse_id=w.warehouse_id 
and a.or_no=b.or_no and b.item_id=i.item_id 
and w.group_for = '.$_SESSION['user']['group'].'
and a.receive_type LIKE "%return%" '.$date_con.$warehouse_con.$item_con.$item_brand_con.$dealer_type_con.$product_group_con.' 
order by a.or_date,a.or_no';
		
		break;
		
		
case 54:
		$report="Chalan wise Return Report";
		if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 
		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand="'.$item_brand.'"';} 
		if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 
		if(isset($dealer_type)) 			{$dealer_type_con=' and d.dealer_type="'.$dealer_type.'"';} 
		if(isset($product_group)) 			{$product_group_con=' and d.product_group="'.$product_group.'"';} 

		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.or_date between "'.$fr_date.'" and "'.$to_date.'"';}
		
	if(isset($dealer_type)){
		if($dealer_type=='MordernTrade')		{$dealer_type_con = ' and ( d.dealer_type="Corporate" or  d.dealer_type="SuperShop" or  d.product_group="M") ';}
		elseif($dealer_type=='Distributor')		{$dealer_type_con = ' and d.dealer_type="'.$dealer_type.'" and ( d.product_group!="M") ';}
		else 									{$dealer_type_con = ' and d.dealer_type="'.$dealer_type.'"';}
		}

		
		$sql='select  
		a.or_no as sr_no,
		a.or_date as sr_date,
		a.vendor_id as dealer_code,
		a.vendor_name as dealer,
		a.or_subject as serial_no,
		a.or_details as chalan_no,
		
		sum((b.rate*b.qty)) as Total,
		sum((rate*bonus_qty)) as free_goods,
		sum((bonus_rate*qty)) as cash_discount,
		sum(((qty*rate)-(rate*bonus_qty))) as sales_return

from item_info i,warehouse_other_receive a, warehouse_other_receive_detail b ,warehouse w, dealer_info d
where 
a.vendor_id=d.dealer_code 
and b.warehouse_id=w.warehouse_id 
and a.or_no=b.or_no and b.item_id=i.item_id 
and w.group_for = '.$_SESSION['user']['group'].'
and a.receive_type LIKE "%return%" '.$date_con.$warehouse_con.$item_con.$item_brand_con.$dealer_type_con.$product_group_con.' 
group by a.or_no
order by a.or_date,a.or_no';
		
		break;		
		
case 52:
		$report="Sales Report(Brief)";

		//if(isset($warehouse_id)) 			{$con.=' and a.warehouse_id='.$warehouse_id;} 
		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand="'.$item_brand.'"';} 
		//if(isset($item_id)) 			    {$con.=' and a.item_id='.$item_id;} 
		if(isset($product_group)) 			{$con.=' and d.product_group='.'"'.$product_group.'"';}
		if(isset($dealer_type)) 			{$con.=' and d.dealer_type='.'"'.$dealer_type.'"';}
		

		if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $con.=' and a.or_date between "'.$fr_date.'" and "'.$to_date.'"';}
		
if(isset($dealer_type)){
		if($dealer_type=='MordernTrade')		{$dealer_type_con = ' and ( d.dealer_type="Corporate" or  d.dealer_type="SuperShop" or  d.product_group="M") ';}
		elseif($dealer_type=='Distributor')		{$dealer_type_con = ' and d.dealer_type="'.$dealer_type.'" and ( d.product_group!="M") ';}
		else 									{$dealer_type_con = ' and d.dealer_type="'.$dealer_type.'"';}
		}

		
		$sql='select  
		a.or_no as sr_no,
		a.or_date as sr_date, a.actual_receive_date as chalan_date,
		d.dealer_type,
		a.vendor_id as dealer_code,
		a.vendor_name as dealer_name,
		d.product_group,
		a.or_subject as serial_no,
		a.or_details as chalan_no,
		
		sum(b.rate*b.qty) as Total,
		sum(b.rate*bonus_qty) as free_goods,
		sum(bonus_rate*qty) as cash_discount,
		sum((qty*rate)-(rate*bonus_qty)) as sales_return
		
		from warehouse_other_receive a, warehouse_other_receive_detail b,dealer_info d
		where
		a.or_no=b.or_no 
		and d.group_for = '.$_SESSION['user']['group'].'
		and a.vendor_id=d.dealer_code
		and a.receive_type LIKE "%return%" '.$con.' 
		group by a.or_no order by a.or_date';
		break;
		
		
case 53:
		$report="Sales Report(Party Brief)";

		//if(isset($warehouse_id)) 			{$con.=' and a.warehouse_id='.$warehouse_id;} 
		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand="'.$item_brand.'"';} 
		//if(isset($item_id)) 			    {$con.=' and a.item_id='.$item_id;} 
		if(isset($product_group)) 			{$con.=' and d.product_group='.'"'.$product_group.'"';}
		if(isset($dealer_type)) 			{$con.=' and d.dealer_type='.'"'.$dealer_type.'"';}

		if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $con.=' and a.or_date between "'.$fr_date.'" and "'.$to_date.'"';}

		
$sql='select 
(select BRANCH_NAME from branch where BRANCH_ID=d.region_id) as region,
(select ZONE_NAME from zon where ZONE_CODE=d.zone_id) as zone,
(select AREA_NAME from area where AREA_CODE=d.area_code) as area, 
		
		a.vendor_id as dealer_code,
		a.vendor_name as dealer_name,
		d.dealer_type,
		d.product_group,
		sum(b.rate*b.qty) as Total,
		sum(rate*bonus_qty) as free_goods,
		sum(bonus_rate*qty) as cash_discount,
		sum((qty*rate)-(rate*bonus_qty)) as sales_return
		
		from warehouse_other_receive a, warehouse_other_receive_detail b,dealer_info d
		where
		a.or_no=b.or_no 
		and d.group_for = '.$_SESSION['user']['group'].'
		and a.vendor_id=d.dealer_code
		and a.receive_type LIKE "%return%" '.$con.' 
		group by a.vendor_id
		order by d.region_id,d.zone_id
		';
		break;		
		
		
case 2001:
		$report="Item Wise Sales Return Report (At A Glance)";
		
	if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con .= ' and a.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		if($_POST['cut_date']!='') 								$date_con .= ' and  a.chalan_date<="'.$_POST['cut_date'].'"'; 
		if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
		if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
		
if(isset($dealer_type)){
		if($dealer_type=='MordernTrade')		{$dealer_type_con = ' and ( d.dealer_type="Corporate" or  d.dealer_type="SuperShop" or  d.product_group="M") ';}
		elseif($dealer_type=='Distributor')		{$dealer_type_con = ' and d.dealer_type="'.$dealer_type.'" and ( d.product_group!="M") ';}
		else 									{$dealer_type_con = ' and d.dealer_type="'.$dealer_type.'"';}
		}
		
		if(isset($product_group)) 			{$product_group_con=' and d.product_group="'.$product_group.'"';} 
		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand="'.$item_brand.'"';} 

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

</head>
<body>
<div align="center" id="pr">
<input type="button" value="Print" onclick="hide();window.print();"/>
</div>
<div class="main">
<?
		$str 	.= '<div class="header">';
		$str 	.= '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		$str 	.= '<h2>'.$report.'</h2>';
		if(isset($to_date)) 
		$str 	.= '<h2>'.$fr_date.' To '.$to_date.'</h2>';
		$str 	.= '</div>';
		if(isset($_SESSION['company_logo'])) 
		//$str 	.= '<div class="logo"><img height="60" src="'.$_SESSION['company_logo'].'"</div>';
		$str 	.= '<div class="left">';
		if(($warehouse_id>0)) 
		$str 	.= '<p>Warehouse Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
		if(isset($allotment_no)) 
		$str 	.= '<p>Allotment No.: '.$allotment_no.'</p>';
		$str 	.= '</div><div class="right">';
		
		if(isset($dealer_type)) 
		$str 	.= '<h2>Dealer Type : '.$dealer_type.'</h2>';
		$str 	.= '</div>';
		
		
		if(isset($item_id)) 
		$str 	.= '<p>Item Name: '.$client_name.'</p>';
		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		
		
if($_POST['report']==2) 
{
		$sql='select distinct i.item_id,i.unit_name,i.item_name,s.sub_group_name,i.finish_goods_code
		   from item_info i, item_sub_group s where 
		   i.sub_group_id=s.sub_group_id'.$item_sub_con.' order by i.finish_goods_code,s.sub_group_name,i.item_name';
		   
		$query =db_query($sql);   
		$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id);
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><td style="border:0px;" colspan="9"><div class="header"><h1>Sajeeb Group</h1><h2>Warehouse Present Stock</h2></div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>
<th>S/L</th>
<th>Warehouse Name</th>
<th>Item Code</th>
<th>Item Group</th>
<th>FG</th>
<th>Item Name</th>
<th>Unit</th>
<th>Final Stock</th>
<th>Rate</th>
<th>Stock Price</th>
</tr>
</thead><tbody>
<?
while($data=mysqli_fetch_object($query)){
$s='select a.final_stock,a.final_price as rate,(a.final_stock*a.final_price) as Stock_price  
from journal_item a where  a.item_id="'.$data->item_id.'" '.$date_con.$warehouse_con.$item_con.$status_con.' order by a.id desc limit 1';
$q = db_query($s);
$i=mysqli_fetch_object($q);$j++;
		   ?>
<tr>
<td><?=$j?></td>
<td><?=$warehouse_name?></td>
<td><?=$data->item_id?></td>
<td><?=$data->sub_group_name?></td>
<td><?=$data->finish_goods_code?></td>
<td><?=$data->item_name?></td>
<td ><?=$data->unit_name?></td>
<td style="text-align:right"><?=$i->final_stock?></td>
<td style="text-align:right"><?=$i->rate?></td>
<td style="text-align:right"><?=$i->Stock_price?></td>
</tr>
<?
}
		


}

if($_POST['report']==2001) 
{
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead>
<tr><td style="border:0px;" colspan="6"><?=$str?><div class="left"></div>
<div class="right"></div>
</td></tr>

<tr>
  <th rowspan="2">S/L</th>
  <th rowspan="2">CODE</th>
<th rowspan="2">Product Name</th>
<th rowspan="2">GRP</th>
<th colspan="2">SALES RETURN</th>
<th colspan="2">CP</th>
  <th colspan="5">AMOUNT IN TAKA</th>
  </tr>
<tr>
  <th>CTN</th>
  <th>PCS</th>
  <th>CTN</th>
  <th>PCS</th>
  <th>SALES RETURN</th>
  <th>FREE</th>
  <th>DISCOUNT</th>
  <th>CP</th>
  <th>Actial Sales Return</th>
  </tr>

</thead><tbody>
<?

		
echo $sql='select 
		i.item_id,
		sum(a.qty*i.f_price) as FP

from dealer_info d, warehouse_other_receive_detail a, item_info i 
where d.dealer_code=a.vendor_id and a.receive_type like "%Return%" and a.rate=0 
and d.group_for = '.$_SESSION['user']['group'].'
and a.item_id=i.item_id 
'.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dealer_type_con.$pg_con.$product_group_con.' 
group by a.item_id order by i.finish_goods_code';
	
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$cp[$data->item_id] = $data->FP;
}

echo $sql='select 
		i.finish_goods_code as fg,
		i.item_id,
		i.item_name,i.sales_item_type,
		i.unit_name as unit,
		i.item_brand as brand,
		i.pack_size,
		sum(a.qty) div i.pack_size as pkt,
		sum(a.qty) mod i.pack_size as pcs,
		sum(a.qty) qty,
		sum(a.qty*i.d_price) as DP,
		sum(a.qty*a.rate)/sum(a.qty) as sale_price,
		sum(a.qty*a.bonus_rate) as discount,
		sum(a.rate*a.bonus_qty) as free,
		sum(a.qty*a.rate) as actual_price

from dealer_info d, warehouse_other_receive_detail a, item_info i 

where d.dealer_code=a.vendor_id and a.receive_type like "%Return%" 
and d.group_for = '.$_SESSION['user']['group'].'
and a.item_id=i.item_id  
'.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dealer_type_con.$pg_con.$product_group_con.' 
group by a.item_id order by i.finish_goods_code';
	

$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$payable = $data->actual_price - ((($citem[$data->item_id])*(-1)) + (($ditem[$data->item_id])));
$payable_total = $payable_total + $payable;
$dis_total = $dis_total + (($citem[$data->item_id])*(-1));
$dis_total2 = $dis_total2 + (($ditem[$data->item_id]));
$actual_total = $actual_total + $data->actual_price;
$total_qty = $ditemqty[$data->item_id] + $data->qty;
$cp_total = $cp[$data->item_id] + $cp_total;
$ac = ($data->actual_price - $data->free);

?>
<tr><td><?=++$s?></td><td><?=$data->fg?></td>
  <td><?=$data->item_name?></td>
  <td><?=$data->sales_item_type?></td>
  <td><?=$data->pkt?></td><td><?=number_format((($data->pcs)),0)?></td><td><span style="text-align:right">
    <?=number_format((($pitempkt[$data->item_id])),0)?>
  </span></td>
  <td><span style="text-align:right">
    <?=number_format((($pitempcs[$data->item_id])),0)?>
  </span></td>
  <td style="text-align:right"><?=number_format((($data->actual_price)),2)?></td>
  <td style="text-align:right"><?=number_format((($data->free)),2)?></td>
  <td style="text-align:right"><?=number_format((($data->discount)),2)?></td>
  <td style="text-align:right"><?=number_format((($cp[$data->item_id])),2)?></td>
  <td style="text-align:right"><?=number_format((($ac)),2)?></td>
  </tr>
<?
$total_actual_price = $total_actual_price + $data->actual_price;
$total_ac = $total_ac + $ac;
$total_free = $total_free + $data->free;
$total_dis = $total_dis + $data->discount;
}
?>
<tr class="footer"><td>&nbsp;</td><td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
  <td colspan="3" style="text-align:right"><?=number_format((($total_actual_price)),2)?></td>
  <td><span style="text-align:right"><?=number_format((($total_free)),2)?></span></td>
  <td><span style="text-align:right"><?=number_format((($total_dis)),2)?></span></td>
  <td><span style="text-align:right"><?=number_format((($cp_total)),2)?></span></td>

  <td><span style="text-align:right"><?=number_format((($total_ac)),2)?></span></td>
  </tr></tbody></table>
<?
}




elseif($_POST['report']==4) 
{
		$sql='select i.item_id,i.unit_name,i.item_name,i.sales_item_type,i.finish_goods_code,i.item_brand,i.pack_unit,i.pack_size,i.sales_item_type from item_info i where 
		   i.product_nature = "Salable"  order by i.finish_goods_code,i.item_name';
		   
		$query =db_query($sql);  
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><td style="border:0px;" colspan="12"><div class="header"><h1>Sajeeb Group</h1><h2>Warehouse Present Stock</h2></div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>
<th>S/L</th>
<th>FG Code </th>
<th>Brand</th>
<th>Group</th>
<th>Item Name </th>
<th>Pack Size </th>
<th>Pcs Unit</th>
<th bgcolor="#FFCCFF">CRT</th>
<th bgcolor="#CCCCFF">PCS</th>
<th>Rate</th>
<th>Stock Price</th>
</tr>
</thead><tbody>
<?
while($data=mysqli_fetch_object($query)){
$s='select a.final_stock,a.final_price as rate,(a.final_stock*a.final_price) as Stock_price from journal_item a where  a.item_id="'.$data->item_id.'"  and a.warehouse_id='.$_SESSION['user']['depot'].' order by a.id desc limit 1';
$q = db_query($s);
$i=mysqli_fetch_object($q);$j++;
		   ?>
<tr><td><?=$j?></td>
  <td><?=$data->finish_goods_code?></td>
  <td><?=$data->item_brand?></td>
  <td ><?=$data->sales_item_type?></td>
  <td ><?=$data->item_name?></td>
  <td ><?=$data->pack_size?></td>
  <td ><?=$data->unit_name?></td>
	
<td bgcolor="#FFCCFF" style="text-align:right"><?=(int)($i->final_stock/$data->pack_size)?></td>
<td bgcolor="#CCCCFF" style="text-align:right"><?=(int)($i->final_stock%$data->pack_size)?></td>
<td style="text-align:right"><?=$i->rate?></td><td style="text-align:right"><?=$i->Stock_price?></td></tr>
		   <?
}

}

elseif($_POST['report']==71) 
{
		$sql='select i.item_id,i.unit_name,i.item_name,i.sales_item_type,i.finish_goods_code,i.item_brand,i.pack_unit,i.pack_size,i.sales_item_type from item_info i where 
		   i.product_nature = "Salable"  order by i.finish_goods_code,i.item_name';
		   
		$query =db_query($sql);  
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><td style="border:0px;" colspan="12"><div class="header"><h1>Sajeeb Group</h1><h2>Warehouse Present Stock</h2></div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>
<th>S/L</th>
<th>FG Code </th>
<th>Brand</th>
<th>Group</th>
<th>Item Name </th>
<th>Pack Size </th>
<th>Pcs Unit</th>
<th bgcolor="#FFCCFF">CRT</th>
<th bgcolor="#CCCCFF">PCS</th>
<th>Rate</th>
<th>Stock Price</th>
</tr>
</thead><tbody>
<?
while($data=mysqli_fetch_object($query)){
$s='select a.final_stock,a.final_price as rate,(a.final_stock*a.final_price) as Stock_price from journal_item a where  a.item_id="'.$data->item_id.'"  and a.warehouse_id='.$_SESSION['user']['depot'].' order by a.id desc limit 1';
$q = db_query($s);
$i=mysqli_fetch_object($q);$j++;
		   ?>
<tr><td><?=$j?></td>
  <td><?=$data->finish_goods_code?></td>
  <td><?=$data->item_brand?></td>
  <td ><?=$data->sales_item_type?></td>
  <td ><?=$data->item_name?></td>
  <td ><?=$data->pack_size?></td>
  <td ><?=$data->unit_name?></td>
	
<td bgcolor="#FFCCFF" style="text-align:right"><?=(int)($i->final_stock/$data->pack_size)?></td>
<td bgcolor="#CCCCFF" style="text-align:right"><?=(int)($i->final_stock%$data->pack_size)?></td>
<td style="text-align:right"><?=$i->rate?></td><td style="text-align:right"><?=$i->Stock_price?></td></tr>
		   <?
}

}
elseif(isset($sql)&&$sql!='') echo report_create($sql,1,$str);
?></tbody></table>
</div>
</body>
</html>