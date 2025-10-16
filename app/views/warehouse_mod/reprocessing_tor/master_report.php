<?
session_start();
require "../../../engine/tools/check.php";
require "../../../engine/configure/db_connect.php";
require "../../support/inc.all.php";
date_default_timezone_set('Asia/Dhaka');
		function ssd($qty,$pk,$colour='')
		{
		if($colour!='') $c = 'bgcolor="'.$colour.'" ';
		echo '
		<td '.$c.'>'.(int)($qty/$pk).'</td>
		<td '.$c.'>'.($qty%$pk).'</td>
		<td '.$c.'>'.(int)$qty.'</td>
			';
		}
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
	if($_POST['item_brand']>0) 				    $item_brand=$_POST['item_brand'];
switch ($_POST['report']) {

    case 1:
		$report="Warehouse Item Transection Report";
		if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 
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

		
		 $sql='select ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `IN`,a.item_ex as `OUT`,a.item_price as rate,((a.item_in+a.item_ex)*a.item_price) as amount,a.tr_from as tr_type,sr_no,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.tr_no,a.entry_at,c.fname as User 
		   
		   from journal_item a, item_info i, user_activity_management c , item_sub_group s where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and
		    a.item_id=i.item_id and a.warehouse_id="'.$_SESSION['user']['depot'].'" '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' order by a.id';
	break;
	case 1199:
		$report="Import Item Receive Report";
		if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 
		
		$status_con=' and a.receive_type="Import"';
		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}


		 $sql='select a.or_no,a.or_date,a.origin,a.lc_no,s.sub_group_name as Category,i.item_id,i.item_name,i.unit_name as unit,b.qty as `IN`, b.rate as rate,((b.qty)*b.rate) as amount,a.receive_type as tr_type,a.entry_at,c.fname as User 
		   
		   from warehouse_other_receive a, warehouse_other_receive_detail b, item_info i, user_activity_management c , item_sub_group s where c.user_id=a.entry_by and a.or_no=b.or_no and s.sub_group_id=i.sub_group_id and
		    b.item_id=i.item_id and a.warehouse_id="'.$_SESSION['user']['depot'].'" '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' order by a.or_no';
	break;
    case 1008:
		$report="Warehouse Advance Purchase Report";
		
		if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 
		

		$status_con=' and a.tr_from in ("Purchase","Local Purchase","Import")';

		
		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		
		 $sql='select 
	 a.item_id,
	 i.item_name,
	 s.sub_group_name as Category,
	 i.unit_name as unit,
	 sum(a.item_in) as `total_qty`,
	 (sum(a.item_in*a.item_price)/sum(a.item_in)) as rate,
	 sum(a.item_in*a.item_price) as amount
		   
		   from journal_item a, item_info i, user_activity_management c , item_sub_group s where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and
		    a.item_id=i.item_id and a.warehouse_id="'.$_SESSION['user']['depot'].'" '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' group by a.item_id order by a.id';
	break;
    case 2:
		$report="Warehouse Stock Position Report(Closing)";
		if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 
		if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
		elseif(isset($item_id)) 			{$item_con=' and a.item_id='.$item_id;} 
		if(isset($receive_status)) 			{$status_con=' and a.tr_from="'.$receive_status.'"';} 
		elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 
		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date <="'.$to_date.'"';}
		

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
				if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 
		if(isset($receive_status)) 			{$status_con=' and a.tr_from="'.$receive_status.'"';} 
		elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 
		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date <="'.$to_date.'"';}
		break;
	
		case 5:
		$report="Details Sales Report";
		if(isset($warehouse_id)) 			{$warehouse_con=' and w.warehouse_id='.$warehouse_id;} 
		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 
		if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 

		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between "'.$fr_date.'" and "'.$to_date.'"';}

		
//$sql='select 
//m.pi_no,
//a.ji_date,
//w.warehouse_name  as warehouse,
//i.item_brand as brand,
//a.sr_no,
//i.finish_goods_code as fg,
//i.item_name,
//
//i.unit_name as unit,
//a.item_in as qty,
//a.item_price as rate,
//(a.item_in*a.item_price) as amt
//from journal_item a, item_info i, user_activity_management c,warehouse w,production_issue_master m,production_issue_detail d  where w.use_type="SD" and a.item_in>0 and a.relevant_warehouse='.$_SESSION['user']['depot'].' and 
//d.id=a.tr_no and d.pi_no=m.pi_no and w.warehouse_id=a.warehouse_id and (a.tr_from="Issue" OR a.tr_from="Transfered" OR a.tr_from="Transit") and c.user_id=a.entry_by and a.item_id=i.item_id'.$date_con.$warehouse_con.$item_con.$item_brand_con.' group by d.id order by a.id';
		
		$sql='select 
		m.pi_no,
		a.ji_date,
		w.warehouse_name  as warehouse,
		i.item_brand as brand,
		a.sr_no,
		i.finish_goods_code as fg,
		i.item_name,
		i.pack_size,
		i.unit_name as unit,
		a.item_ex as qty,
		i.f_price as Cost_Price,
		(a.item_ex*i.f_price) as Cost_Amt,
		i.d_price as DP_Price,
		(a.item_ex*i.d_price) as DP_Amt
		from journal_item a, item_info i, user_activity_management c, warehouse w, production_issue_master m, production_issue_detail d  where 

		w.use_type!="PL" and a.item_ex>0 and a.warehouse_id='.$_SESSION['user']['depot'].' and 
		d.id=a.tr_no and d.pi_no=m.pi_no and w.warehouse_id=a.relevant_warehouse and (a.tr_from="Issue" OR a.tr_from="Transfered" OR a.tr_from="Transit") and 
		c.user_id=a.entry_by and a.item_id=i.item_id '.$date_con.$warehouse_con.$item_con.$item_brand_con.' group by d.id order by a.ji_date';
		
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
		sum(a.item_ex) as qty,
		
		i.f_price as Cost_Price,
		sum(a.item_ex*f_price) as cost_Amt,
		i.d_price as DP_Price,
		sum(a.item_ex*i.d_price) as DP_Amt
		from journal_item a, item_info i, user_activity_management c,warehouse w  where w.use_type!="PL" and a.item_ex>0 and a.warehouse_id='.$_SESSION['user']['depot'].' and 
		w.warehouse_id=a.warehouse_id and (a.tr_from="Issue" OR a.tr_from="Transfered" OR a.tr_from="Transit") and c.user_id=a.entry_by and a.item_id=i.item_id'.$date_con.$warehouse_con.$item_con.$item_brand_con.' group by  a.item_id order by i.finish_goods_code';
		break;
		
		
		case 7:
		$report="Chalan Wise Sales Report";
		if(isset($warehouse_id)) 			{$con.=' and m.warehouse_to='.$warehouse_id;}

		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $con.=' and m.pi_date between "'.$fr_date.'" and "'.$to_date.'"';}

		$sql='select 
m.pi_no, m.pi_date,  w.warehouse_name as Depot, m.remarks as sl_no, m.carried_by,
		sum(a.item_in*i.f_price) as cost_amt,sum(a.item_in*i.d_price) as DP_amt
		from journal_item a, item_info i, user_activity_management c,warehouse w,production_issue_master m,production_issue_detail d  where w.use_type="SD" and a.item_in>0 and a.relevant_warehouse='.$_SESSION['user']['depot'].' and 
		d.id=a.tr_no and d.pi_no=m.pi_no and w.warehouse_id=a.warehouse_id and (a.tr_from="Issue" OR a.tr_from="Transfered" OR a.tr_from="Transit") and c.user_id=a.entry_by and a.item_id=i.item_id'.$con.' group by d.pi_no order by m.pi_date';
				
		//$sql='select  	a.pi_no, a.pi_date,  b.warehouse_name as Depot, a.remarks as sl_no, a.carried_by,sum(total_amt) as total_amt from production_issue_master a,production_issue_detail c,warehouse b where   a.warehouse_from='.$_SESSION['user']['depot'].' and a.pi_no=c.pi_no and a.warehouse_to=b.warehouse_id and b.use_type!="PL" '.$con.' group by c.pi_no order by a.pi_no desc';
		break;
case 8:
		$report="Warehouse Item Transection Report(Entry Wise)";
		if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 
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
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.entry_at between \''.$fr_date.'\' and \''.date('Y-m-d',strtotime($_POST['t_date'])+24*60*60).'\'';}
		

		
		 $sql='select a.entry_at,ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `IN`,a.item_ex as `OUT`,a.item_price as rate,((a.item_in+a.item_ex)*a.item_price) as amount,a.tr_from as tr_type,sr_no,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.tr_no,c.fname as User ," " as Line_Manager
		   
		   from journal_item a, item_info i, user_activity_management c , item_sub_group s where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and
		    a.item_id=i.item_id and a.warehouse_id="'.$_SESSION['user']['depot'].'" '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' order by warehouse';
	break;
		case 1001:
		$report="Chalan Wise Sales Report";
		if(isset($warehouse_id)) 			{$con.=' and m.warehouse_to='.$warehouse_id;}

		
		if(isset($t_date)) 
		{$con.=' and m.pi_date between "'.$fr_date.'" and "'.$to_date.'"';}


		break;
		
		case 10011:
		$report="Chalan Wise Sales Report";
		if(isset($warehouse_id)) 			{$con.=' and m.warehouse_to='.$warehouse_id;}

		
		if(isset($t_date)) 
		{$con.=' and m.pi_date between "'.$fr_date.'" and "'.$to_date.'"';}


		break;
		
		
		case 501:
		$report="Details Receive Report";
		if(isset($warehouse_id)) 			{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 
		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 
		if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 

		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between "'.$fr_date.'" and "'.$to_date.'"';}

		
		$sql='select 
		m.pi_no,
		a.ji_date,
		w.warehouse_name  as warehouse,
		i.item_brand as brand,
		a.sr_no,
		i.finish_goods_code as fg,
		i.item_name,
		
		i.unit_name as unit,
		a.item_in as qty,
		i.f_price as Cost_Price,
		(a.item_in*i.f_price) as Cost_Amt,
		i.d_price as DP_Price,
		(a.item_in*i.d_price) as DP_Amt
		from journal_item a, item_info i, user_activity_management c,warehouse w,production_issue_master m,production_issue_detail d  where a.item_in>0 and a.warehouse_id='.$_SESSION['user']['depot'].' and 
		d.id=a.tr_no and d.pi_no=m.pi_no and w.warehouse_id=a.relevant_warehouse and (a.tr_from="Issue" or a.tr_from="Transfered" or a.tr_from="Transit") and c.user_id=a.entry_by and a.item_id=i.item_id'.$date_con.$warehouse_con.$item_con.$item_brand_con.' group by d.id order by a.ji_date';
		
		break;
		
		case 502:
		$report="Receive Report(Brief)";
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
		
		
		i.f_price as Cost_Price,
		sum(a.item_in*f_price) as cost_Amt,
		i.d_price as DP_Price,
		sum(a.item_in*i.d_price) as DP_Amt
		
		from journal_item a, item_info i, user_activity_management c,warehouse w  where a.item_in>0 and a.warehouse_id='.$_SESSION['user']['depot'].' and 
		w.warehouse_id=a.relevant_warehouse and (a.tr_from="Issue" or a.tr_from="Transfered" or a.tr_from="Transit") and c.user_id=a.entry_by and a.item_id=i.item_id'.$date_con.$warehouse_con.$item_con.$item_brand_con.' group by  a.item_id order by i.finish_goods_code';
		break;
		
		
		case 503:
		$report="PR Wise Receive Report";
		if(isset($warehouse_id)) 			{$con.=' and a.relevant_warehouse='.$warehouse_id;} 

		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $con.=' and m.pi_date between "'.$fr_date.'" and "'.$to_date.'"';}

		$sql='select 
m.pi_no,m.rec_sl_no, m.pi_date,  w.warehouse_name as Depot, m.remarks as sl_no, m.carried_by,
		sum(a.item_in*i.d_price) as amt
		from journal_item a, item_info i, user_activity_management c,warehouse w,production_issue_master m,production_issue_detail d  where a.item_in>0 and a.warehouse_id='.$_SESSION['user']['depot'].' and 
		d.id=a.tr_no and d.pi_no=m.pi_no and w.warehouse_id=a.relevant_warehouse and (a.tr_from="Issue" or a.tr_from="Transfered" or a.tr_from="Transit") and c.user_id=a.entry_by and a.item_id=i.item_id'.$con.' group by d.pi_no order by m.pi_date';
				
		//$sql='select  	a.pi_no, a.pi_date,  b.warehouse_name as Depot, a.remarks as sl_no, a.carried_by,sum(total_amt) as total_amt from production_issue_master a,production_issue_detail c,warehouse b where   a.warehouse_from='.$_SESSION['user']['depot'].' and a.pi_no=c.pi_no and a.warehouse_to=b.warehouse_id and b.use_type!="PL" '.$con.' group by c.pi_no order by a.pi_no desc';
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
<style type="text/css">
.vertical-text {
	transform: rotate(270deg);
	transform-origin: left top 1;
	float:left;
	width:2px;
	padding:1px;
	font-size:10px;
	font-family:Arial, Helvetica, sans-serif;
}
</style>
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
		if(isset($warehouse_id))
		$str 	.= '<p>PL/WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
		if(isset($allotment_no)) 
		$str 	.= '<p>Allotment No.: '.$allotment_no.'</p>';
		$str 	.= '</div><div class="right">';
		if(isset($item_id)) 
		$str 	.= '<p>Item Name: '.$client_name.'</p>';
		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		
		
if($_POST['report']==2) 
{
		$sql='select i.item_id,i.unit_name,i.item_name,s.sub_group_name,i.finish_goods_code,
		i.d_price,
		FORMAT(sum(a.item_in-a.item_ex),2) as final_stock,
		sum((a.item_in-a.item_ex)*(a.item_price)) as Stock_price
		   from item_info i, item_sub_group s,journal_item a where a.warehouse_id="'.$_SESSION['user']['depot'].'" and  
		   i.item_id = a.item_id and i.sub_group_id=s.sub_group_id'.$item_sub_con.' group by i.item_id order by i.finish_goods_code,s.sub_group_name,i.item_name';
		   
		$query =db_query($sql);   
		$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="9"><div class="header"><h1>Sajeeb Group</h1><h2><?=$report?></h2>
<h2>Closing Stock of Date-<?=$to_date?></h2></div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>
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
//$s='select FORMAT(sum(a.item_in-a.item_ex),2) as final_stock,sum((a.item_in-a.item_ex)*(a.item_price)) as Stock_price  
// from journal_item a where  a.item_id="'.$data->item_id.'" '.$date_con.$item_con.$status_con.' and a.warehouse_id="'.$_SESSION['user']['depot'].'" order by a.id desc limit 1';
// $q = db_query($s);
// $i=mysqli_fetch_object($q);
$j++;
$amt = $data->final_stock*$data->d_price;
$total_amt = $total_amt + $amt;
		   ?>
<tr>
<td><?=$j?></td>
<td><?=$warehouse_name?></td>
<td><?=$data->item_id?></td>
<td><?=$data->sub_group_name?></td>
<td><?=$data->finish_goods_code?></td>
<td><?=$data->item_name?></td>
<td><?=$data->unit_name?></td>
<td style="text-align:right"><?=$data->final_stock?></td>
<td style="text-align:right"><?=@number_format($data->d_price,2)?></td>
<td style="text-align:right"><?=number_format(($amt),2)?></td>
</tr>
<?
}
		
?>
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td>Total: </td>
<td style="text-align:right"><?=number_format(($total_amt),2)?></td>
</tr>
</tbody>
</table>
<?

}
elseif($_POST['report']==4) 
{
if(isset($item_id)) 				{$item_cons=' and i.item_id='.$item_id;}
if($_SESSION['user']['depot']==5)
$sql='select distinct i.item_id,i.unit_name,i.item_name,s.sub_group_name,i.finish_goods_code,i.pack_size,i.p_price as item_price
		   from item_info i, item_sub_group s where i.product_nature = "Salable" '.$item_cons.' and 
		   i.sub_group_id=s.sub_group_id order by i.finish_goods_code,s.sub_group_name,i.item_name';
else
$sql='select distinct i.item_id,i.unit_name,i.item_name,s.sub_group_name,i.finish_goods_code,i.pack_size,i.f_price as item_price
		   from item_info i, item_sub_group s where i.product_nature = "Salable" '.$item_cons.' and 
		   i.sub_group_id=s.sub_group_id order by i.finish_goods_code,s.sub_group_name,i.item_name';
		$query =db_query($sql);   
		$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);
?>

<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><td style="border:0px;" colspan="10"><div class="header"><h1>Sajeeb Group</h1><h2><?=$report?></h2>
<h2>Closing Stock of Date-<?=$to_date?></h2></div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>
<th rowspan="2">S/L</th>
<th rowspan="2">Warehouse Name</th>
<th rowspan="2">Item Code</th>
<th rowspan="2">FG</th>
<th rowspan="2">Item Name</th>
<th rowspan="2">Pack Size</th>
<th rowspan="2">Unit</th>
<th colspan="2">Final Stock</th>
<th rowspan="2">Total Pcs</th>
<th rowspan="2">Rate</th>
<th rowspan="2">Stock Price</th>
</tr>
<tr>
  <th bgcolor="#CCFFFF">ctr</th>
  <th bgcolor="#FFCCFF">pcs</th>
</tr>

</thead><tbody>
<?
while($data=mysqli_fetch_object($query)){
$s='select sum(a.item_in-a.item_ex) as final_stock
from journal_item a where  a.item_id="'.$data->item_id.'" '.$date_con.$item_con.$status_con.' and a.warehouse_id="'.$_SESSION['user']['depot'].'" order by a.id desc limit 1';
$q = db_query($s);
$i=mysqli_fetch_object($q);$j++;
		   ?>
<tr>
<td><?=$j?></td>
<td><?=$warehouse_name?></td>
<td><?=$data->item_id?></td>
<td><?=$data->finish_goods_code?></td>
<td><?=$data->item_name?></td>
<td><?=$data->pack_size?></td>
<td><?=$data->unit_name?></td>
<td style="text-align:right; background-color:#CCFFFF;"><?=(int)($i->final_stock/$data->pack_size)?></td>
<td style="text-align:right;background-color:#FFCCFF;"><?=($i->final_stock%$data->pack_size)?></td>
<td style="text-align:right"><?=(int)$i->final_stock?></td>
<td style="text-align:right"><?=@number_format(($data->item_price),2)?></td>
<td style="text-align:right"><? $sum =$data->item_price*$i->final_stock; echo number_format(($data->item_price*$i->final_stock),2);?></td>
</tr>
<?
$t_sum = $t_sum + $sum;
}
?>
<tr>
<td><?=$j?></td>
<td><?=$warehouse_name?></td>
<td><?=$data->item_id?></td>
<td><?=$data->finish_goods_code?></td>
<td><?=$data->item_name?></td>
<td><?=$data->item_name?></td>
<td><?=$data->unit_name?></td>
<td style="text-align:right; background-color:#CCFFFF;"></td>
<td style="text-align:right;background-color:#FFCCFF;"></td>
<td style="text-align:right"></td>
<td style="text-align:right"></td>
<td style="text-align:right"><?=number_format($t_sum,2)?></td>
</tr>
<?
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
  <td><?=$data->sales_item_type?></td>
  <td><?=$data->item_name?></td>
  <td><?=$data->pack_size?></td>
  <td><?=$data->unit_name?></td>
	
<td bgcolor="#FFCCFF" style="text-align:right"><?=(int)($i->final_stock/$data->pack_size)?></td>
<td bgcolor="#CCCCFF" style="text-align:right"><?=(int)($i->final_stock%$data->pack_size)?></td>
<td style="text-align:right"><?=$i->rate?></td><td style="text-align:right"><?=$i->Stock_price?></td></tr>
		   <?
}
}

elseif($_POST['report']==1004)
{
		$report="RM Consumtion Report";
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		if(isset($sub_group_id)){$s_con.=' and i.sub_group_id="'.$sub_group_id.'"';} 
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="17" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
if(isset($warehouse_id))
		echo '<p>PL/WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th rowspan="2">S/L</th>
		<th rowspan="2">Item Code </th>
		<th rowspan="2">Item Name </th>
		<th colspan="3" bgcolor="#99CC99" style="text-align:center">OPENING BALANCE</th>
		<th colspan="3" bgcolor="#339999" style="text-align:center">PRODUCT RECEIVED</th>
		<th colspan="3" bgcolor="#FFCC66" style="text-align:center">PRODUCT ISSUED</th>
		<th colspan="3" bgcolor="#FFFF99" style="text-align:center">CLOSING BALANCE</th>
		</tr>
		<tr>
		<th bgcolor="#99CC99">Qty</th>
		<th bgcolor="#99CC99">Rate</th>		
		<th bgcolor="#99CC99">Taka</th>
		<th bgcolor="#339999">Qty</th>
		<th bgcolor="#339999">Rate</th>		
		<th bgcolor="#339999">Taka</th>
		<th bgcolor="#FFCC66">Qty</th>
		<th bgcolor="#FFCC66">Rate</th>
		<th bgcolor="#FFCC66">Taka</th>
		<th bgcolor="#FFFF99">Qty</th>
		<th bgcolor="#FFFF99">Rate</th>
		<th bgcolor="#FFFF99">Taka</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
$sql="select distinct j.item_id,i.item_name from item_info i,journal_item j where i.item_id=j.item_id and product_nature='Salable' ".$con." order by i.product_nature,i.item_name";
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{
$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item j where ji_date<"'.$f_date.'" and item_id='.$row->item_id.$con);
		$pre_stock = (int)$pre->pre_stock;
		$pre_price = @($pre->pre_amt/$pre->pre_stock);
		$pre_amt   = $pre->pre_amt;

		$in = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item j where item_in>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id.$con);
		$in_stock = (int)$in->pre_stock;
		$in_price = @($in->pre_amt/$in->pre_stock);
		$in_amt   = $pre->pre_amt;
		

		$out = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item j where item_ex>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id.$con);
		$out_stock = (int)$out->pre_stock;
		$out_price = @($out->pre_amt/$out->pre_stock);
		$out_amt   = $pre->pre_amt;
		

		
		$final_stock = $pre_stock+($in_stock-$out_stock);
		$final_price = @((($pre_stock*$pre_price)+($in_stock*$in_price)-($out_stock*$out_price))/$final_stock);
		if($pre_stock>0||$in_stock>0||$out_stock>0||$out_stock>0){
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->item_id?></td>
		<td><?=$row->item_name?></td>
		<td><?=$pre_stock?></td>
		<td><?=number_format($pre_price,2)?></td>
		<td><?=number_format(($pre_stock*$pre_price),2)?></td>

		<td><?=$in_stock?></td>
		<td><?=number_format($in_price,2)?></td>
		<td><?=number_format(($in_price*$in_stock),2)?></td>


		<td><?=$out_stock?></td>
		<td><?=number_format($out_price,2)?></td>
		<td><?=number_format(($out_price*$out_stock),2)?></td>
		<td><?=$final_stock?></td>
		<td><?=number_format($final_price,2)?></td>
		<td><?=number_format(($final_stock*$final_price),2)?></td>
</tr><? }}?>
		
		</tbody>
		</table>
		<?
}
elseif($_POST['report']==1005)
{
		$report="FG Production Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="17" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
if(isset($warehouse_id))
		echo '<p>PL/WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th rowspan="2">S/L</th>
		<th rowspan="2">Item Code </th>
		<th rowspan="2">Item Name </th>
		<th colspan="3" bgcolor="#99CC99" style="text-align:center">OPENING BALANCE</th>
		<th colspan="3" bgcolor="#339999" style="text-align:center">PRODUCT RECEIVED</th>
		<th colspan="3" bgcolor="#FFCC66" style="text-align:center">PRODUCT ISSUED</th>
		<th colspan="3" bgcolor="#FFFF99" style="text-align:center">CLOSING BALANCE</th>
		</tr>
		<tr>
		<th bgcolor="#99CC99">Qty</th>
		<th bgcolor="#99CC99">Rate</th>		
		<th bgcolor="#99CC99">Taka</th>
		<th bgcolor="#339999">Qty</th>
		<th bgcolor="#339999">Rate</th>		
		<th bgcolor="#339999">Taka</th>
		<th bgcolor="#FFCC66">Qty</th>
		<th bgcolor="#FFCC66">Rate</th>
		<th bgcolor="#FFCC66">Taka</th>
		<th bgcolor="#FFFF99">Qty</th>
		<th bgcolor="#FFFF99">Rate</th>
		<th bgcolor="#FFFF99">Taka</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		$sql="select distinct j.item_id,i.item_name from item_info i,journal_item j where i.item_id=j.item_id and product_nature='Salable' ".$con." order by i.product_nature,i.item_name";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item j where ji_date<"'.$f_date.'" and item_id='.$row->item_id.$con);
		$pre_stock = (int)$pre->pre_stock;
		$pre_price = @($pre->pre_amt/$pre->pre_stock);
		$pre_amt   = $pre->pre_amt;

		$in = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item j where item_in>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id.$con);
		$in_stock = (int)$in->pre_stock;
		$in_price = @($in->pre_amt/$in->pre_stock);
		$in_amt   = $pre->pre_amt;
		

		$out = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item j where item_ex>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id.$con);
		$out_stock = (int)$out->pre_stock;
		$out_price = @($out->pre_amt/$out->pre_stock);
		$out_amt   = $pre->pre_amt;
		

		
		$final_stock = $pre_stock+($in_stock-$out_stock);
		$final_price = @((($pre_stock*$pre_price)+($in_stock*$in_price)-($out_stock*$out_price))/$final_stock);
		if($pre_stock>0||$in_stock>0||$out_stock>0||$out_stock>0){
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->item_id?></td>
		<td><?=$row->item_name?></td>
		<td><?=$pre_stock?></td>
		<td><?=number_format($pre_price,2)?></td>
		<td><?=number_format(($pre_stock*$pre_price),2)?></td>

		<td><?=$in_stock?></td>
		<td><?=number_format($in_price,2)?></td>
		<td><?=number_format(($in_price*$in_stock),2)?></td>


		<td><?=$out_stock?></td>
		<td><?=number_format($out_price,2)?></td>
		<td><?=number_format(($out_price*$out_stock),2)?></td>
		<td><?=$final_stock?></td>
		<td><?=number_format($final_price,2)?></td>
		<td><?=number_format(($final_stock*$final_price),2)?></td>
</tr><? }}?>
		
		</tbody>
		</table>
		<?
}
elseif($_POST['report']==1001&&$sub_group_id>0) 
{
$sql='select i.item_id,i.unit_name,i.item_name  from item_info i where i.sub_group_id='.$sub_group_id.' order by i.finish_goods_code,i.item_name';
		   
		$query =db_query($sql);  
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <thead><tr><td style="border:0px;" colspan="31"><div class="header"><h1>Sajeeb Group</h1>
<h2>Stock Valuation Report<br />
  <? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
  <? if(isset($t_date)) 
	echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';?>
</div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>
<th rowspan="2">S/L</th>
<th rowspan="2">Item Name </th>
<th rowspan="2">Unit</th>
<th colspan="3" bgcolor="#CC99FF"><div align="center">Opening </div></th>
<th colspan="3" bgcolor="#99FFFF"><div align="center">Purchase</div></th>
<th colspan="3" bgcolor="#FFCCFF"><div align="center">Other Receive </div></th>
<th colspan="3" bgcolor="#FFCC66"><div align="center">Total Receive </div></th>
<th colspan="3"><div align="center">Sales</div></th>
<th colspan="3"><div align="center">Consumption</div></th>
<th colspan="3"><div align="center">Other Issue </div></th>
<th colspan="3"><div align="center">Total Issue </div></th>
<th colspan="3"><div align="center">Closing</div></th>
</tr><tr>
<th bgcolor="#CC99FF">Qty</th>
<th bgcolor="#CC99FF">AVR</th>
<th bgcolor="#CC99FF">Amt </th>
<th bgcolor="#99FFFF">Qty</th>
<th bgcolor="#99FFFF">AVR</th>
<th bgcolor="#99FFFF">Amt </th>
<th bgcolor="#FFCCFF">Qty</th>
<th bgcolor="#FFCCFF">AVR</th>
<th bgcolor="#FFCCFF">Amt </th>
<th bgcolor="#FFCC66">Qty</th>
<th bgcolor="#FFCC66">AVR</th>
<th bgcolor="#FFCC66">Amt </th>
<th>Qty</th>
<th>AVR</th>
<th>Amt </th>
<th>Qty</th>
<th>AVR</th>
<th>Amt </th>
<th>Qty</th>
<th>AVR</th>
<th>Amt </th>
<th>Qty</th>
<th>AVR</th>
<th>Amt </th>
<th>Qty</th>
<th>AVR</th>
<th>Amt </th>
</tr>
</thead><tbody>
<?
while($row=mysqli_fetch_object($query)){
$pre_stock = $pre_price = $pre_amt   = $in_stock = $in_price = $in_amt   = $pur_stock = $pur_price = $pur_amt   = $or_stock = $or_amt   = $or_price = $out_stock = $out_price = $out_amt   = $sale_stock = $sale_price = $sale_amt   = $pro_stock = $pro_price = $pro_amt   = $oi_stock = $oi_amt   = $oi_price = $final_stock = $final_amt   = $final_price = 0;

$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item where warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date<"'.$f_date.'" and item_id='.$row->item_id);
		$pre_stock = (int)$pre->pre_stock;
		$pre_price = @($pre->pre_amt/$pre->pre_stock);
		$pre_amt   = $pre->pre_amt;

		$in = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id);
		$in_stock = (int)$in->pre_stock;
		$in_price = @($in->pre_amt/$in->pre_stock);
		$in_amt   = $in->pre_amt;
		
		$pur = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from="Purchase" and item_id='.$row->item_id);
		$pur_stock = (int)$pur->pre_stock;
		$pur_price = @($pur->pre_amt/$pur->pre_stock);
		$pur_amt   = $pur->pre_amt;
		
		$pur = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from!="Purchase" and item_id='.$row->item_id);
		$or_stock = (int)$or->pre_stock;
		$or_amt   = @($or->pre_amt/$or->pre_stock);
		$or_price = $or->pre_amt;
		
		
		$out = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id);
		$out_stock = (int)$out->pre_stock;
		$out_price = @($out->pre_amt/$out->pre_stock);
		$out_amt   = $out->pre_amt;
		
		$sale = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from="Sales" and item_id='.$row->item_id);
		$sale_stock = (int)$sale->pre_stock;
		$sale_price = @($sale->pre_amt/$sale->pre_stock);
		$sale_amt   = $sale->pre_amt;
		
		$pro = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from="Issue" and item_id='.$row->item_id);
		$pro_stock = (int)$pro->pre_stock;
		$pro_price = @($pro->pre_amt/$pro->pre_stock);
		$pro_amt   = $pro->pre_amt;
		

		
		
		$oi = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from!="Sales" and tr_from!="Issue" and item_id='.$row->item_id);
		$oi_stock = (int)$oi->pre_stock;
		$oi_amt   = @($oi->pre_amt/$oi->pre_stock);
		$oi_price = $oi->pre_amt;
		
		$final_stock = $pre_stock+($in_stock-$out_stock);
		$final_amt   = @($pre_stock*$pre_price)+($in_stock*$in_price)-($out_stock*$out_price);
		$final_price = @(($final_amt)/$final_stock);
		
		
		?>
<tr><td><?=++$j?></td>
  <td><?=$row->item_name?></td>
  <td><nobr><?=$row->unit_name?></nobr></td>
  <td bgcolor="#CC99FF"><div align="right">
    <?=$pre_stock?>
  </div></td>
  <td bgcolor="#CC99FF"><div align="right">
    <?=number_format($pre_price,2)?>
  </div></td>
  <td bgcolor="#CC99FF"><div align="right">
    <?=number_format($pre_amt,2)?>
  </div></td>
  <td bgcolor="#99FFFF"><div align="right">
    <?=$pur_stock?>
  </div></td>
  <td bgcolor="#99FFFF"><div align="right">
    <?=number_format($pur_price,2)?>
  </div></td>
  <td bgcolor="#99FFFF"><div align="right">
    <?=number_format($pur_amt,2)?>
  </div></td>
  <td bgcolor="#FFCCFF"><div align="right">
    <?=$or_stock?>
  </div></td>
  <td bgcolor="#FFCCFF"><div align="right">
    <?=number_format($or_price,2)?>
  </div></td>
  <td bgcolor="#FFCCFF"><div align="right">
    <?=number_format($or_amt,2)?>
  </div></td>
  <td bgcolor="#FFCC66"><div align="right">
    <?=$in_stock?>
  </div></td>
  <td bgcolor="#FFCC66"><div align="right">
    <?=number_format($in_price,2)?>
  </div></td>
  <td bgcolor="#FFCC66"><div align="right">
    <?=number_format($in_amt,2)?>
  </div></td>
  <td><div align="right">
    <?=$sale_stock?>
  </div></td>
  <td><div align="right">
    <?=number_format($sale_price,2)?>
  </div></td>
  <td><div align="right">
    <?=number_format($sale_amt,2)?>
  </div></td>
  <td><div align="right">
    <?=$pro_stock?>
  </div></td>
  <td><div align="right">
    <?=number_format($pro_price,2)?>
  </div></td>
  <td><div align="right">
    <?=number_format($pro_amt,2)?>
  </div></td>
  <td><div align="right">
    <?=$oi_stock?>
  </div></td>
  <td><div align="right">
    <?=number_format($oi_price,2)?>
  </div></td>
  <td><div align="right">
    <?=number_format($oi_amt,2)?>
  </div></td>
  <td><div align="right">
    <?=$out_stock?>
  </div></td>
  <td><div align="right">
    <?=number_format($out_price,2)?>
  </div></td>
  <td><div align="right">
    <?=number_format($out_amt,2)?>
  </div></td>
  <td><div align="right">
    <?=$final_stock?>
  </div></td>
  <td><div align="right">
    <?=number_format($final_price,2)?>
  </div></td>
  <td><div align="right">
    <?=number_format($final_amt,2)?>
  </div></td>
</tr>
<?
}
?></tbody></table>
<?
}
elseif($_POST['report']==10011) 
{
if($item_id>0) 		{$item_con = ' and i.item_id='.$item_id;}
if($sub_group_id>0) {$sub_item_con = ' and i.sub_group_id='.$sub_group_id;}

$sql='select i.item_id,i.unit_name,i.item_name  from item_info i where 1 '.$sub_item_con.$item_con.'  order by i.finish_goods_code,i.item_name';
$query =db_query($sql);
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <thead><tr><td style="border:0px;" colspan="35"><div class="header"><h1>Sajeeb Group</h1>
<h2>Stock Valuation Report(HFL)<br />
  <? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
  <? if(isset($t_date)) 
	echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';?>
</div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>
<th rowspan="2">S/L</th>
<th rowspan="2">Item Name </th>
<th rowspan="2">Unit</th>
<th colspan="5" bgcolor="#CC99FF"><div align="center">Opening </div></th>
<th colspan="3" bgcolor="#99FFFF"><div align="center">Purchase</div></th>
<th colspan="3" bgcolor="#FFCCFF"><div align="center">Other Receive </div></th>
<th colspan="3" bgcolor="#FFFF00"><div align="center">Total IN </div></th>
<th colspan="3" bgcolor="#99FFFF"><div align="center">Material Sales</div></th>
<th colspan="3" bgcolor="#FFCCFF"><div align="center">Consumption </div></th>
<th colspan="3" bgcolor="#FFCC66"><div align="center">Other Issue </div></th>
<th colspan="3" bgcolor="#FF3366"><div align="center">Total OUT </div></th>
<th colspan="5" bgcolor="#CC99FF"><div align="center">Closing</div></th>
</tr><tr>
<th bgcolor="#CC99FF">WHQty</th>
<th bgcolor="#CC99FF">PLQty</th>
<th bgcolor="#CC99FF">TQty</th>
<th bgcolor="#CC99FF">AVR</th>
<th bgcolor="#CC99FF">Amt </th>
<th bgcolor="#99FFFF">Qty</th>
<th bgcolor="#99FFFF">AVR</th>
<th bgcolor="#99FFFF">Amt </th>
<th bgcolor="#FFCCFF">Qty</th>
<th bgcolor="#FFCCFF">AVR</th>
<th bgcolor="#FFCCFF">Amt </th>
<th bgcolor="#FFFF00">Qty</th>
<th bgcolor="#FFFF00">AVR</th>
<th bgcolor="#FFFF00">Amt </th>
<th bgcolor="#99FFFF">Qty</th>
<th bgcolor="#99FFFF">AVR</th>
<th bgcolor="#99FFFF">Amt </th>
<th bgcolor="#FFCCFF">Qty</th>
<th bgcolor="#FFCCFF">AVR</th>
<th bgcolor="#FFCCFF">Amt </th>
<th bgcolor="#FFCC66">Qty</th>
<th bgcolor="#FFCC66">AVR</th>
<th bgcolor="#FFCC66">Amt </th>
<th bgcolor="#FF3366">Qty</th>
<th bgcolor="#FF3366">AVR</th>
<th bgcolor="#FF3366">Amt </th>
<th bgcolor="#CC99FF">WHQty</th>
<th bgcolor="#CC99FF">PLQty</th>
<th bgcolor="#CC99FF">TQty</th>
<th bgcolor="#CC99FF">AVR</th>
<th bgcolor="#CC99FF">Amt </th>
</tr>
</thead><tbody>
<?
while($row=mysqli_fetch_object($query)){
$pre_stock = $pre_price = $pre_amt   = $in_stock = $in_price = $in_amt   = $pur_stock = $pur_price = $pur_amt   = $or_stock = $or_amt   = $or_price = $out_stock = $out_price = $out_amt   = $sale_stock = $sale_price = $sale_amt   = $pro_stock = $pro_price = $pro_amt   = $oi_stock = $oi_amt   = $oi_price = $final_stock = $final_amt   = $final_price = 0;


		$pr = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date < "'.$f_date.'" and (tr_from="Purchase" or tr_from="Local Purchase" or tr_from="Import") and item_id='.$row->item_id);
		$pr_price = @($pr->pre_amt/$pr->pre_stock);
		
		$pr_end = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date <= "'.$t_date.'" and (tr_from="Purchase" or tr_from="Local Purchase" or tr_from="Import") and item_id='.$row->item_id);
		$pr_end_price = @($pr->pre_amt/$pr->pre_stock);

		$pur = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and (tr_from="Purchase" or tr_from="Local Purchase" or tr_from="Import") and item_id='.$row->item_id);
		$pur_stock = (int)$pur->pre_stock;
		$pur_price = @($pur->pre_amt/$pur->pre_stock);
		$pur_amt   = $pur->pre_amt;



$pre = find_all_field_sql('select sum(j.item_in-j.item_ex) as pre_stock from journal_item j,warehouse w where w.warehouse_id=j.warehouse_id and (w.master_warehouse_id = "'.$_SESSION['user']['depot'].'" or  w.warehouse_id = "'.$_SESSION['user']['depot'].'") and j.ji_date<"'.$f_date.'" and j.item_id='.$row->item_id);
		$pret_stock = (int)$pre->pre_stock;
		$pret_price = $pr_price;
		$pret_amt   = $pre->pre_stock*$pr_price;

//echo 'select sum(item_in-item_ex) as pre_stock from journal_item where warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date<"'.$f_date.'" and item_id='.$row->item_id;
		$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock from journal_item where warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date<"'.$f_date.'" and item_id='.$row->item_id);
		$pre_stock = (int)$pre->pre_stock;
		$lpre_stock = $pret_stock - $pre_stock;
		
		
		$in = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id);
		$in_stock = (int)$in->pre_stock;
		$in_price = @($in->pre_amt/$in->pre_stock);
		$in_amt   = $in->pre_amt;
		

		$pur = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from!="Purchase" and tr_from!="Local Purchase" and tr_from!="Import" and item_id='.$row->item_id);
		$or_stock = (int)$or->pre_stock;
		$or_amt   = @($or->pre_amt/$or->pre_stock);
		$or_price = $or->pre_amt;
		
		
		$sale = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from="Other Sales" and item_id='.$row->item_id);
		$sale_stock = (int)$sale->pre_stock;
		$sale_price = $pr_price;
		$sale_amt   = $sale_stock*$pr_price;
		
		
		$pro = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from="Consumption" and item_id='.$row->item_id);
		$pro_stock = (int)$pro->pre_stock;
		$pro_price = $pr_price;
		$pro_amt   = $pr_price*$pro_stock;
		
		$out = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from!="issue" and item_id='.$row->item_id);
		$out_stock = (int)($out->pre_stock + $pro_stock);
		$out_price = $pr_price;
		$out_amt   = $pr_price*$out_stock;
		
		$oi = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from!="Other Sales" and tr_from!="Issue" and item_id='.$row->item_id);
		$oi_stock = (int)$oi->pre_stock;
		$oi_amt   = @($oi->pre_amt/$oi->pre_stock);
		$oi_price = $oi->pre_amt;
		
		$final_stock = $pre_stock+($in_stock-$out_stock);
		$final_amt   = @($pre_stock*$pre_price)+($in_stock*$in_price)-($out_stock*$out_price);
		$final_price = @(($final_amt)/$final_stock);

$pre = find_all_field_sql('select sum(j.item_in-j.item_ex) as pre_stock,sum((j.item_in-j.item_ex)*j.item_price) as pre_amt from journal_item j,warehouse w where w.warehouse_id=j.warehouse_id and (w.master_warehouse_id = "'.$_SESSION['user']['depot'].'" or  w.warehouse_id = "'.$_SESSION['user']['depot'].'") and j.ji_date<="'.$t_date.'" and j.item_id='.$row->item_id);
		$final_stock = (int)$pre->pre_stock;
		$final_amt = $pr_end_price;
		$final_price   = $pre->pre_stock*$pr_end_price;

$pre = find_all_field_sql('select sum(j.item_in-j.item_ex) as pre_stock from journal_item j,warehouse w where w.warehouse_id=j.warehouse_id and w.master_warehouse_id = "'.$_SESSION['user']['depot'].'" and j.ji_date<="'.$t_date.'" and j.item_id='.$row->item_id);
		$lfinal_stock = (int)$pre->pre_stock;
		$prefinal_stock = (int)($final_stock -$pre->pre_stock);
		?>
<tr><td><?=++$j?></td>
  <td><?=$row->item_name?></td>
  <td><nobr><?=$row->unit_name?></nobr></td>
  <td bgcolor="#CC99FF"><?=$pre_stock?></td>
  <td bgcolor="#CC99FF"><?=$lpre_stock?></td>
  <td bgcolor="#CC99FF"><div align="right">
    <?=$pret_stock?>
  </div></td>
  <td bgcolor="#CC99FF"><div align="right">
    <?=number_format($pr_price,2)?>
  </div></td>
  <td bgcolor="#CC99FF"><div align="right">
    <?=number_format(($pr_price*$pret_stock),2)?>
  </div></td>
  <td bgcolor="#99FFFF"><div align="right">
    <?=$pur_stock?>
  </div></td>
  <td bgcolor="#99FFFF"><div align="right">
    <?=number_format($pur_price,2)?>
  </div></td>
  <td bgcolor="#99FFFF"><div align="right">
    <?=number_format($pur_amt,2)?>
  </div></td>
  <td bgcolor="#FFCCFF"><div align="right">
    <?=$or_stock?>
  </div></td>
  <td bgcolor="#FFCCFF"><div align="right">
    <?=number_format($or_price,2)?>
  </div></td>
  <td bgcolor="#FFCCFF"><div align="right">
    <?=number_format($or_amt,2)?>
  </div></td>
  <td bgcolor="#FFFF00"><div align="right">
    <?=$in_stock?>
  </div></td>
  <td bgcolor="#FFFF00"><div align="right">
    <?=number_format($in_price,2)?>
  </div></td>
  <td bgcolor="#FFFF00"><div align="right">
    <?=number_format($in_amt,2)?>
  </div></td>
  <td bgcolor="#99FFFF"><div align="right">
    <?=$sale_stock?>
  </div></td>
  <td bgcolor="#99FFFF"><div align="right">
    <?=number_format($sale_price,2)?>
  </div></td>
  <td bgcolor="#99FFFF"><div align="right">
    <?=number_format($sale_amt,2)?>
  </div></td>
  <td bgcolor="#FFCCFF"><div align="right">
    <?=$pro_stock?>
  </div></td>
  <td bgcolor="#FFCCFF"><div align="right">
    <?=number_format($pro_price,2)?>
  </div></td>
  <td bgcolor="#FFCCFF"><div align="right">
    <?=number_format($pro_amt,2)?>
  </div></td>
  <td bgcolor="#FFCC66"><div align="right">
    <?=$oi_stock?>
  </div></td>
  <td bgcolor="#FFCC66"><div align="right">
    <?=number_format($oi_price,2)?>
  </div></td>
  <td bgcolor="#FFCC66"><div align="right">
    <?=number_format($oi_amt,2)?>
  </div></td>
  <td bgcolor="#FF3366"><div align="right">
    <?=$out_stock?>
  </div></td>
  <td bgcolor="#FF3366"><div align="right">
    <?=number_format($out_price,2)?>
  </div></td>
  <td bgcolor="#FF3366"><div align="right">
    <?=number_format($out_amt,2)?>
  </div></td>
  <td bgcolor="#CC99FF"><?=$prefinal_stock?></td>
  <td bgcolor="#CC99FF"><?=$lfinal_stock?></td>
  <td bgcolor="#CC99FF"><div align="right">
    <?=$final_stock?>
  </div></td>
  <td bgcolor="#CC99FF"><div align="right">
    <?=number_format($final_price,2)?>
  </div></td>
  <td bgcolor="#CC99FF"><div align="right">
    <?=number_format($final_amt,2)?>
  </div></td>
</tr>
<?
}
?></tbody></table>
<?
}
elseif($_POST['report']==1003)
{
		$report="Material Consumption  Report";
		if(isset($warehouse_id)) 			{$con.=' and m.warehouse_to='.$warehouse_id;}
		
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		<thead>
		<tr><td colspan="17" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th rowspan="2">S/L</th>
		<th rowspan="2">Item Code </th>
		<th rowspan="2">Item Name </th>
		<th colspan="3" bgcolor="#99CC99" style="text-align:center">OPENING BALANCE</th>
		<th colspan="3" bgcolor="#339999" style="text-align:center">PRODUCT RECEIVED</th>
		<th colspan="3" bgcolor="#FFCC66" style="text-align:center">PRODUCT ISSUED</th>
		<th colspan="3" bgcolor="#FFFF99" style="text-align:center">CLOSING BALANCE</th>
		</tr>
		<tr>
		<th bgcolor="#99CC99">Qty</th>
		<th bgcolor="#99CC99">Rate</th>		
		<th bgcolor="#99CC99">Taka</th>
		<th bgcolor="#339999">Qty</th>
		<th bgcolor="#339999">Rate</th>		
		<th bgcolor="#339999">Taka</th>
		<th bgcolor="#FFCC66">Qty</th>
		<th bgcolor="#FFCC66">Rate</th>
		<th bgcolor="#FFCC66">Taka</th>
		<th bgcolor="#FFFF99">Qty</th>
		<th bgcolor="#FFFF99">Rate</th>
		<th bgcolor="#FFFF99">Taka</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		$sql="select i.item_id,i.item_name from item_info i where i.sub_group_id='".$sub_group_id."'	order by i.product_nature,i.item_name";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item where warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date<"'.$f_date.'" and item_id='.$row->item_id);
		$pre_stock = (int)$pre->pre_stock;
		$pre_price = @($pre->pre_amt/$pre->pre_stock);
		$pre_amt   = $pre->pre_amt;

		$in = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id);
		$in_stock = (int)$in->pre_stock;
		$in_price = @($in->pre_amt/$in->pre_stock);
		$in_amt   = $pre->pre_amt;
		

		$out = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id);
		$out_stock = (int)$out->pre_stock;
		$out_price = @($out->pre_amt/$out->pre_stock);
		$out_amt   = $pre->pre_amt;
		

		
		$final_stock = $pre_stock+($in_stock-$out_stock);
		$final_price = @((($pre_stock*$pre_price)+($in_stock*$in_price)-($out_stock*$out_price))/$final_stock);
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><a target="_blank" href="../ws/product_transection_report_master.php?item_id=<?=$row->item_id?>&f_date=<?=$f_date?>&t_date=<?=$t_date?>&submit=3&report=3"><?=$row->item_id?></a></td>
		<td><?=$row->item_name?></td>
		<td><?=$pre_stock?></td>
		<td><?=number_format($pre_price,2)?></td>
		<td><?=number_format(($pre_stock*$pre_price),2)?></td>

		<td><?=$in_stock?></td>
		<td><?=number_format($in_price,2)?></td>
		<td><?=number_format(($in_price*$in_stock),2)?></td>


		<td><?=$out_stock?></td>
		<td><?=number_format($out_price,2)?></td>
		<td><?=number_format(($out_price*$out_stock),2)?></td>
		<td><?=$final_stock?></td>
		<td><?=number_format($final_price,2)?></td>
		<td><?=number_format(($final_stock*$final_price),2)?></td>
</tr><? }?>
		
		</tbody>
		</table>
		<?
}
elseif($_POST['report']==1009)
{
		$report="Daily Stock Issue Report";
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">

		<thead>
		<tr><td colspan="9" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'-'.$_POST['sales_item_type'].'</h2>';

if(isset($t_date)) 
		echo '<h2>Reporting Date : '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		
		

		if($_POST['sales_item_type']!='')
		$dg = ' and i.sales_item_type like "%'.$_POST['sales_item_type'].'%"';
		$sql="select distinct i.item_id,i.item_name,i.sales_item_type,i.pack_size,i.finish_goods_code,i.sales_item_type from item_info i, journal_item c where  i.finish_goods_code>0 and c.item_ex>0 and c.item_id=i.item_id and c.ji_date='".$_POST['t_date']."' and i.finish_goods_code!=2000 and i.finish_goods_code!=2001 ".$dg." and c.warehouse_id='".$_SESSION['user']['depot']."' order by i.item_id";
		$res	 = db_query($sql);
		$rows = mysqli_num_rows($res);
		while($row=mysqli_fetch_object($res))
		{
		$item_code[] = $row->item_id;
		$item_name[] = $row->item_name;
		$sales_item_type[] = $row->sales_item_type;
		$pack_size[] = $row->pack_size;
		$finish_goods_code[] = $row->finish_goods_code;
		}
		
		$sql="select distinct c.chalan_no,c.driver_name from item_info i,sale_do_chalan c where c.chalan_type='Delivery' and i.item_id=c.item_id  and c.chalan_date='".$_POST['t_date']."' and c.depot_id='".$_SESSION['user']['depot']."'  ".$dg." order by c.chalan_no ";
		$res	 = db_query($sql);
		$chalan = mysqli_num_rows($res);
		while($row=mysqli_fetch_object($res))
		{$rsr_no[] = $row->chalan_no; $dsr_no[] = $row->driver_name;}
		
		$sql="select distinct c.sr_no from item_info i,journal_item c where i.item_id=c.item_id  and c.ji_date='".$_POST['t_date']."' and c.warehouse_id='".$_SESSION['user']['depot']."'  ".$dg." and (c.tr_from = 'Reprocess Issue'||c.tr_from = 'Issue'||c.tr_from = 'Transit'||c.tr_from = 'Transfered') and c.item_ex>0 order by c.sr_no ";
		$res	 = db_query($sql);
		$store = mysqli_num_rows($res);
		while($row=mysqli_fetch_object($res))
		{$srsr_no[] = $row->sr_no; $sdsr_no[] = $row->sr_no;}
		
		$sql="select distinct c.sr_no,ch.driver_name from item_info i,journal_item c, sale_other_chalan ch where ch.chalan_no=c.sr_no and i.item_id=c.item_id  and c.ji_date='".$_POST['t_date']."' and c.warehouse_id='".$_SESSION['user']['depot']."'  ".$dg." and (c.tr_from = 'Other Sales'||c.tr_from = 'Staff Sales') and c.item_ex>0 order by c.sr_no ";
		$res	 = db_query($sql);
		$os = mysqli_num_rows($res);
		while($row=mysqli_fetch_object($res))
		{$ossr_no[] = $row->sr_no; $osdsr_no[] = $row->driver_name;}
		
		$sql="select distinct c.sr_no,ch.driver_name from item_info i,journal_item c, sale_other_chalan ch where ch.chalan_no=c.sr_no and i.item_id=c.item_id  and c.ji_date='".$_POST['t_date']."' and c.warehouse_id='".$_SESSION['user']['depot']."'  ".$dg." and (c.tr_from = 'Entertainment Issue'||c.tr_from = 'Sample Issue'||c.tr_from = 'Gift Issue') and c.item_ex>0 order by c.sr_no ";
		$res	 = db_query($sql);
		$other = mysqli_num_rows($res);
		while($row=mysqli_fetch_object($res))
		{$orsr_no[] = $row->sr_no; $odsr_no[] = $row->driver_name;}
		
		$sql="select sum(item_ex-item_in) as item_ex,item_id,tr_no,sr_no,tr_from from journal_item where ji_date='".$_POST['t_date']."' and warehouse_id='".$_SESSION['user']['depot']."' group by item_id,sr_no,tr_from";
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{
			if($row->tr_from=='Sales'||$row->tr_from=='SalesReturn')
			$citem_ex[$row->sr_no][$row->item_id] = $citem_ex[$row->sr_no][$row->item_id] + $row->item_ex;
			
			elseif(($row->tr_from=='Reprocess Issue')||($row->tr_from=='Issue')||($row->tr_from=='Transfered')||($row->tr_from=='Transit'))
			$sitem_ex[$row->sr_no][$row->item_id] = $row->item_ex;
			
			elseif(($row->tr_from=='Staff Sales')||($row->tr_from=='Other Sales'))
			$ositem_ex[$row->sr_no][$row->item_id] = $row->item_ex;
			else
			$oitem_ex[$row->sr_no][$row->item_id] = $row->item_ex;
		}
		?>
		</td></tr>
		<tr>
		  <th rowspan="2">S/L</th>
		  <th rowspan="2">Item Name </th>
		  <th colspan="<?=$chalan?>"><div align="center">Party Chalan</div></th>
          <? if($os>0){?><th colspan="<?=$os?>" style="text-align:center">Other Sales</th><? }?>
		  <th bgcolor="#99CC99" style="text-align:center">Total</th>
		  <? if($store>0){?><th colspan="<?=$store?>"><div align="center">Store Chalan</div></th><? }?>
		  <th bgcolor="#99CC99" style="text-align:center">Total</th>
		  <? if($other>0){?><th colspan="<?=$other?>"><div align="center">Other Issue</div></th><? }?>
		  <th bgcolor="#99CC99" style="text-align:center">Total</th>
		  <th bgcolor="#99CC99" style="text-align:center">ALL-TOTAL</th>
		  </tr>
		
			<tr>
				<? for($j=0;$j<$chalan;$j++){?>
				<th height="100" bgcolor="#339999" style="width:5px;"><font class="vertical-text"><?=$dsr_no[$j]?></font></th>
				<? }?>   
                <? for($j=0;$j<$os;$j++){?>
                <th height="100" bgcolor="#339999" style="width:5px;"><font class="vertical-text"><?=$osdsr_no[$j]?></font></th>
				<? }?>                    
				<th bgcolor="#339999" style="font-size:10px; font-weight:normal; padding:1px;">Ctn-Pcs</th>
				<? for($j=0;$j<$store;$j++){?>
			  <th height="100" bgcolor="#339999" style="width:5px;"><p><font class="vertical-text"><?=$srsr_no[$j]?></font></p></th>
				<? }?>                      
				<th bgcolor="#339999" style="font-size:10px; font-weight:normal; padding:1px;">Ctn-Pcs</th>
				<? for($j=0;$j<$other;$j++){?>
				<th height="100" bgcolor="#339999" style="width:5px;"><p><font class="vertical-text"><?=$odsr_no[$j]?></font></p></th>
				<? }?>                      
				<th bgcolor="#339999" style="font-size:10px; font-weight:normal; padding:1px;">Ctn-Pcs</th>
                <th bgcolor="#339999" style="font-size:10px; font-weight:normal; padding:1px;">Ctn-Pcs</th>
			</tr>
		</thead><tbody>
		<? for($x=0;$x<$rows;$x++){?>
				<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
				<td><?=++$sl;?></td>
				<td><?=$item_name[$x]?>(<?=$finish_goods_code[$x]?>)</td>
<!--1-->
		<? for($j=0;$j<$chalan;$j++){?>
				<td style="font-family:Arial, Helvetica, sans-serif;size:11px; padding:0px;">
					<? if($citem_ex[$rsr_no[$j]][$item_code[$x]]>0)
					{
						$total[$item_code[$x]] = $total[$item_code[$x]] + $citem_ex[$rsr_no[$j]][$item_code[$x]];
						$ctotal[$item_code[$x]] = $ctotal[$item_code[$x]] + $citem_ex[$rsr_no[$j]][$item_code[$x]];
						echo (int)(($citem_ex[$rsr_no[$j]][$item_code[$x]])/$pack_size[$x]); 
						if((($citem_ex[$rsr_no[$j]][$item_code[$x]])%$pack_size[$x])>0) 
						echo '-'.(($citem_ex[$rsr_no[$j]][$item_code[$x]])%$pack_size[$x]);
					}?>
				</td>
		<? }?>
		<? for($j=0;$j<$os;$j++){?>
				<td style="font-family:Arial, Helvetica, sans-serif;size:11px; padding:0px;">
					<? if($ositem_ex[$ossr_no[$j]][$item_code[$x]]>0)
					{
						$total[$item_code[$x]] = $total[$item_code[$x]] + $ositem_ex[$ossr_no[$j]][$item_code[$x]];
						$stotal[$item_code[$x]] = $stotal[$item_code[$x]] + $ositem_ex[$ossr_no[$j]][$item_code[$x]];
						echo (int)(($ositem_ex[$ossr_no[$j]][$item_code[$x]])/$pack_size[$x]); 
						if((($ositem_ex[$ossr_no[$j]][$item_code[$x]])%$pack_size[$x])>0) 
						echo '-'.(($ositem_ex[$ossr_no[$j]][$item_code[$x]])%$pack_size[$x]);
					}?>
				</td>
		<? }?>
				<td>
					<?
					if($total[$item_code[$x]]>0)
					{
						echo (int)(($total[$item_code[$x]])/$pack_size[$x]); 
						if((($total[$item_code[$x]])%$pack_size[$x])>0) 
						echo '-'.(($total[$item_code[$x]])%$pack_size[$x]);
					}
					?>
				</td>
				
<!--2-->		
		<? for($j=0;$j<$store;$j++){?>
				<td style="font-family:Arial, Helvetica, sans-serif;size:11px; padding:0px;">
					<? if($sitem_ex[$srsr_no[$j]][$item_code[$x]]>0)
					{
						$total[$item_code[$x]] = $total[$item_code[$x]] + $sitem_ex[$srsr_no[$j]][$item_code[$x]];
						$stotal[$item_code[$x]] = $stotal[$item_code[$x]] + $sitem_ex[$srsr_no[$j]][$item_code[$x]];
						echo (int)(($sitem_ex[$srsr_no[$j]][$item_code[$x]])/$pack_size[$x]); 
						if((($sitem_ex[$srsr_no[$j]][$item_code[$x]])%$pack_size[$x])>0) 
						echo '-'.(($sitem_ex[$srsr_no[$j]][$item_code[$x]])%$pack_size[$x]);
					}?>
				</td>
		<? }?>
				<td>
					<?
					if($total[$item_code[$x]]>0)
					{
						echo (int)(($stotal[$item_code[$x]])/$pack_size[$x]); 
						if((($stotal[$item_code[$x]])%$pack_size[$x])>0) 
						echo '-'.(($stotal[$item_code[$x]])%$pack_size[$x]);
					}
					?>
				</td>
				
				
<!--3-->				
		<? for($j=0;$j<$other;$j++){?>
				<td style="font-family:Arial, Helvetica, sans-serif;size:11px; padding:0px;">
					<? if($oitem_ex[$orsr_no[$j]][$item_code[$x]]>0)
					{
						$total[$item_code[$x]] = $total[$item_code[$x]] + $oitem_ex[$orsr_no[$j]][$item_code[$x]];
						$ototal[$item_code[$x]] = $ototal[$item_code[$x]] + $oitem_ex[$orsr_no[$j]][$item_code[$x]];
						echo (int)(($oitem_ex[$orsr_no[$j]][$item_code[$x]])/$pack_size[$x]); 
						if((($oitem_ex[$orsr_no[$j]][$item_code[$x]])%$pack_size[$x])>0) 
						echo '-'.(($oitem_ex[$orsr_no[$j]][$item_code[$x]])%$pack_size[$x]);
					}?>
				</td>
		<? }?>
				<td>
					<?
					if($total[$item_code[$x]]>0)
					{
						echo (int)(($ototal[$item_code[$x]])/$pack_size[$x]); 
						if((($ototal[$item_code[$x]])%$pack_size[$x])>0) 
						echo '-'.(($ototal[$item_code[$x]])%$pack_size[$x]);
					}
					?>
				</td>
								<td>
					<?
					if($total[$item_code[$x]]>0)
					{
						echo (int)(($total[$item_code[$x]])/$pack_size[$x]); 
						if((($total[$item_code[$x]])%$pack_size[$x])>0) 
						echo '-'.(($total[$item_code[$x]])%$pack_size[$x]);
					}
					?>
				</td>
				</tr>
		<? }?>
		</tbody>
		</table>
		<?
}
elseif($_POST['report']==1006)
{
		$report="Product Movement Detail Report (Depot)";
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="36" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';

if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		  <th rowspan="3">S/L</th>
		  <th rowspan="3">FG</th>
		  <th rowspan="3">Item Name </th>
		  <th rowspan="3">Grp</th>
		  <th colspan="3" rowspan="2"><div align="center">Opening</div></th>
		  <th colspan="12" bgcolor="#339999" style="text-align:center">Item Out </th>
		  <th colspan="12" bgcolor="#99CC99" style="text-align:center">Item In </th>
		  <th colspan="3" rowspan="2"><div align="center">Closing</div></th>
		</tr>
		<tr>
		  <th colspan="3" bgcolor="#339999" style="text-align:center">Party Chalan </th>
		  <th colspan="3" bgcolor="#339999" style="text-align:center">Store Chalan </th>
		  <th colspan="3" bgcolor="#339999" style="text-align:center">Other Issue </th>
		  <th colspan="3" bgcolor="#339999" style="text-align:center">Total Issue </th>
		  <th colspan="3" bgcolor="#339999" style="text-align:center">Sales Return </th>
		  <th colspan="3" bgcolor="#339999" style="text-align:center">Store Chalan </th>
		  <th colspan="3" bgcolor="#339999" style="text-align:center">Other Receive </th>
		  <th colspan="3" bgcolor="#339999" style="text-align:center">Total Receive </th>
		  </tr>
		<tr>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
if($item_id>0) 				{$item_con=' and i.item_id='.$item_id;} 
		$sql="select i.item_id,i.item_name,i.sales_item_type,i.pack_size,i.finish_goods_code,i.sales_item_type from item_info i where i.finish_goods_code>0  ".$item_con." order by i.item_id";
		$table = 'journal_item';
		$show_in = 'sum(item_in-item_ex)';
		$show_ex = 'sum(item_ex-item_in)';

		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{
		echo '';
		$pre_con = 'warehouse_id="'.$_SESSION['user']['depot'].'" and item_id="'.$row->item_id.'" and ji_date < "'.$f_date.'"';
		$pro_con = 'warehouse_id="'.$_SESSION['user']['depot'].'" and item_id="'.$row->item_id.'" and ji_date <= "'.$t_date.'"';
		$con = 'warehouse_id="'.$_SESSION['user']['depot'].'" and item_id="'.$row->item_id.'" and ji_date between "'.$f_date.'" and "'.$t_date.'"';
		$open = find_a_field($table,$show_in,$pre_con);
		$issue_in = find_a_field($table,'sum(item_in)',$con.' and tr_from = "Issue"');
		$return = find_a_field($table,'sum(item_in)',$con.' and tr_from = "Return"');
		$total_in = find_a_field($table,'sum(item_in)',$con);
		$otr_in = $total_in - ($issue_in + $return);

		$sales = find_a_field($table,'sum(item_ex)',$con.' and tr_from = "Sales"');
		$issue_ex = find_a_field($table,'sum(item_ex)',$con.' and tr_from = "Issue"');
		$total_ex = find_a_field($table,'sum(item_ex)',$con);
		$otr_ex = $total_ex - ($issue_ex + $sales);
		$closing = find_a_field($table,$show_in,$pro_con);

		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->finish_goods_code?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->sales_item_type?></td>
		
		<? ssd($open,$row->pack_size);?>
		<? ssd($sales,$row->pack_size);?>
		<? ssd($issue_ex,$row->pack_size);?>
		<? ssd($otr_ex,$row->pack_size);?>
		<? ssd($total_ex,$row->pack_size);?>
		<? ssd($return,$row->pack_size);?>
		<? ssd($issue_in,$row->pack_size);?>
		<? ssd($otr_in,$row->pack_size);?>
		<? ssd($total_in,$row->pack_size);?>
		<? ssd($closing,$row->pack_size);?>
		</tr><? }?>
		
		</tbody>
		</table>
		<?
}

elseif($_POST['report']==1007)
{		if($item_id>0) 				{$item_con=' and i.item_id='.$item_id;} 
		$report="Product Movement Summary Report (Depot)";
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="17" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';

if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		  <th rowspan="2">S/L</th>
		  <th rowspan="2">Item Name </th>
		  <th rowspan="2">Grp</th>
		  <th colspan="3"><div align="center">Opening</div></th>
		  <th colspan="3" bgcolor="#339999" style="text-align:center">Item Out/Total Issue </th>
		  <th colspan="3" bgcolor="#99CC99" style="text-align:center">Item In/Total Receive </th>
		  <th colspan="3"><div align="center">Closing</div></th>
		</tr>
		
		<tr>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		if($item_id>0) 				{$item_con=' and i.item_id='.$item_id;} 
		$sql="select i.item_id,i.item_name,i.sales_item_type,i.pack_size,i.finish_goods_code,i.sales_item_type from item_info i where i.finish_goods_code>0 ".$item_con." order by i.item_id";
		$table = 'journal_item';
		$show_in = 'sum(item_in-item_ex)';
		$show_ex = 'sum(item_ex-item_in)';

		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{
		echo '';
		$pre_con = 'warehouse_id="'.$_SESSION['user']['depot'].'" and item_id="'.$row->item_id.'" and ji_date < "'.$f_date.'"';
		$pro_con = 'warehouse_id="'.$_SESSION['user']['depot'].'" and item_id="'.$row->item_id.'" and ji_date <= "'.$t_date.'"';
		$con = 'warehouse_id="'.$_SESSION['user']['depot'].'" and item_id="'.$row->item_id.'" and ji_date between "'.$f_date.'" and "'.$t_date.'"';
		$open = find_a_field($table,$show_in,$pre_con);
		$total_in = find_a_field($table,'sum(item_in)',$con);
		$total_ex = find_a_field($table,'sum(item_ex)',$con);
		$closing = find_a_field($table,$show_in,$pro_con);

		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->sales_item_type?></td>
		
		<? ssd($open,$row->pack_size);?>
		<? ssd($total_ex,$row->pack_size,'#99FFFF');?>
		<? ssd($total_in,$row->pack_size,'#FFCCFF');?>
		<? ssd($closing,$row->pack_size);?>
		</tr><? }?>
		
		</tbody>
		</table>
		<?
}
elseif($_POST['report']==10091)
{		if($item_id>0) 				{$item_con=' and i.item_id='.$item_id;} 
		$report="Daily HFL Sales Report";
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="4" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>Daily HFL Sales Report to Sajeeb Corporation</h2>';

if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		  <th>Date</th>
		  <th>Sales Value</th>
		  </tr>
		</thead><tbody>
		<? 
		$sql = 'select ji.item_ex*i.f_price from  journal_item ji, item_info i where ji.warehouse_id and ji.ji_date = "'.$f_date.'" and ji.item_id=i.item_id';
		$sales_amount = find_a_field_sql($sql);

$t_date2 = date('Y-m-d',strtotime($t_date . ' +1 day'));
$begin = new DateTime($f_date);
$end = new DateTime($t_date2);

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

foreach ( $period as $dt ){
$present_date = $dt->format("Y-m-d");
$sales_amount = 0;
$sql = 'select sum(ji.item_ex*i.f_price) from  journal_item ji, item_info i where ji.warehouse_id=5 and ji.ji_date = "'.$present_date.'" and ji.item_id=i.item_id';
$sales_amount = find_a_field_sql($sql);
$total_amount = $total_amount + $sales_amount;
		?>
		
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$present_date;?></td>
		<td><?=number_format($sales_amount,2)?></td>
		</tr><? }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>Total: </td>
		  <td><?=number_format($total_amount,2)?></td>
		  </tr>
		</tbody>
		</table>
		<?
}
elseif(isset($sql)&&$sql!='') echo report_create($sql,1,$str);
?>
</div>
</body>
</html>