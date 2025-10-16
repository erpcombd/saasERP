<?
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



date_default_timezone_set('Asia/Dhaka');
//echo $_REQUEST['report'];
if(isset($_REQUEST['submit'])&&isset($_REQUEST['report'])&&$_REQUEST['report']>0)
{
	if((strlen($_REQUEST['t_date'])==10))
	{
		$t_date=$_REQUEST['t_date'];
		$f_date=$_REQUEST['f_date'];
	}
	
if($_REQUEST['product_group']!='')  $product_group=$_REQUEST['product_group'];
if($_REQUEST['item_brand']!='') 	$item_brand=$_REQUEST['item_brand'];
if($_REQUEST['item_id']>0) 		    $item_id=$_REQUEST['item_id'];

if($_REQUEST['status']!='') 		$status=$_REQUEST['status'];


$item_info = find_all_field('item_info','','item_id='.$item_id);

if(isset($item_brand)) 			{$item_brand_con=' and i.item_brand="'.$item_brand.'"';} 
if(isset($dealer_code)) 		{$dealer_con=' and a.dealer_code="'.$dealer_code.'"';} 
 
if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($product_group)) {
if($product_group=='ABCDE') 
$pg_con=' and d.product_group!="M" and d.product_group!=""';
else $pg_con=' and d.product_group="'.$product_group.'"';
}

$item_con='';

if(isset($item_id))			        {$item_con.=' and i.item_id='.$item_id;}
if(isset($item_brand)) 		        {$item_con.=' and i.item_brand="'.$item_brand.'"';} 
if($_REQUEST['group_for']>0) 	        {$item_con.=' and i.group_for="'.$_REQUEST['group_for'].'"';}
if($_REQUEST['item_group']>0) 	        {$item_con.=' and i.item_group="'.$_REQUEST['item_group'].'"';}
if($_REQUEST['category_id']>0) 	    { $category_id=$_REQUEST['category_id']; $item_con.=' and i.category_id="'.$category_id.'"';}
if($_REQUEST['subcategory_id']>0) 	    { $subcategory_id=$_REQUEST['subcategory_id']; $item_con.=' and i.subcategory_id="'.$subcategory_id.'"';}



if($dealer_type!=''){
if($dealer_type=='MordernTrade')		{$dtype_con=$dealer_type_con = ' and ( d.dealer_type="Corporate" or  d.dealer_type="SuperShop" or  d.product_group="M") ';}
else 									{$dtype_con=$dealer_type_con = ' and d.dealer_type="'.$dealer_type.'"';}}
		
if(isset($dealer_code)) 		{$dealer_con=' and m.dealer_code='.$dealer_code;} 
if(isset($item_id))				{$item_con=' and i.item_id='.$item_id;} 
if(isset($depot_id)) 			{$depot_con=' and d.depot="'.$depot_id.'"';} 


switch ($_REQUEST['report']) {


case 1:
	$report="Sales Order Brief Report";
	break;
	
case 8:
    $report="Requisition Vs Delivery Report";
break;


case 9:
    $report="My Requisition Vs Delivery Report";
break;


case 5:
		$report="Issue Report Details";
		if(isset($warehouse_id)) 			{$warehouse_con=' and m.warehouse_to='.$warehouse_id;} 
		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 
		//if(isset($item_id)) 			    {$item_con=' and d.item_id='.$item_id;} 

		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.pi_date between "'.$fr_date.'" and "'.$to_date.'"';}




if($_POST['warehouse_id']>0){
    $wto_con = ' and m.warehouse_to='.$_POST['warehouse_id']; 
}else{
    
        $ssql = 'select warehouse_id from warehouse where use_type IN ("SD","WH") ';
        $qquery = mysql_query($ssql);
        while($sec = mysql_fetch_object($qquery))
        {
        if($warehouse_list == '') $warehouse_list .= $sec->warehouse_id;
        else $warehouse_list .= ','.$sec->warehouse_id;
        }  
    $wto_con = ' and m.warehouse_to in ('.$warehouse_list.')'; 
}
		
$sql='select 
		m.pi_no,
		m.pi_date,
		w.warehouse_name  as warehouse,
		i.item_brand as brand,
		i.finish_goods_code as fg,
		i.item_name,m.returnable,
		i.pack_size,
		i.unit_name as unit,
		d.total_unit as qty,
		d.unit_price as rate,
		d.total_amt as amount
		
		from item_info i, warehouse w, fg_issue_master m, fg_issue_detail d  
		where 
		m.warehouse_from='.$_SESSION['user']['depot'].' 
		'.$wto_con.'
		and d.pi_no=m.pi_no and w.warehouse_id=m.warehouse_from 
		and m.status not in("MANUAL") 
		and d.item_id=i.item_id 
		'.$date_con.$warehouse_con.$item_con.$item_brand_con.' 
		group by d.id 
		order by d.pi_date,m.pi_no';
		
		break;


case 6:
		$report="Issue Report(Brief)";
		if(isset($warehouse_id)) 			{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;}  
		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 
		//if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;}
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between "'.$fr_date.'" and "'.$to_date.'"';}

$sql='select 	
		i.finish_goods_code as fg,
		i.item_name,i.sales_item_type as grp,
		i.pack_size,
		i.unit_name as unit,
		i.item_brand as brand,
		(sum(a.item_ex) DIV i.pack_size) as CTN,
		(sum(a.item_ex) MOD i.pack_size) as Pcs,
		sum(a.item_ex) as Total_qty,
		sum(a.item_price*a.item_ex) as amount
			
		from journal_item a, item_info i,warehouse w  		
		where w.use_type!="PL" 
		and a.item_id=i.item_id
		and a.item_ex>0
		and a.warehouse_id='.$_SESSION['user']['depot'].'
		and w.warehouse_id=a.warehouse_id 
		and (a.tr_from="Transfered" OR a.tr_from="Transit")		
		'.$date_con.$warehouse_con.$item_con.$item_brand_con.' 		
		group by  a.item_id 
		order by i.finish_goods_code';
	
break;
	

case 7:
		$report="Chalan Wise Sales Report";
		if(isset($warehouse_id)) {$con.=' and m.warehouse_to='.$warehouse_id;}

		
		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $con.=' and m.pi_date between "'.$fr_date.'" and "'.$to_date.'"';}
		
$w_in = find_in_sql("select warehouse_id from warehouse where use_type in('SD','WH')");		
		

echo $sql='select m.pi_no, m.pi_date, (select warehouse_name from warehouse where warehouse_id=m.warehouse_to) as send_to, m.remarks as sl_no, m.carried_by,
sum(i.d_price*d.total_unit) as dp_amt

from item_info i, warehouse w, fg_issue_master m, fg_issue_detail d  

where d.pi_no=m.pi_no and d.item_id=i.item_id and w.warehouse_id=d.warehouse_from 
and d.warehouse_from='.$_SESSION['user']['depot'].' 
and m.warehouse_to in('.$w_in.')
'.$con.' 
group by d.pi_no order by m.pi_date';
				
break;



case 501:
		$report="Details Receive Report";
		if(isset($warehouse_id)) 			{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 
		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 
		//if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 

		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between "'.$fr_date.'" and "'.$to_date.'"';}
//{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.pi_date between "'.$fr_date.'" and "'.$to_date.'"';}
		
		$sql='select 
		m.pi_no,
		a.ji_date,
		w.warehouse_name  as warehouse,
		i.item_brand as brand,
		a.sr_no,
		i.finish_goods_code as fg,
		i.item_name,m.returnable,
		i.unit_name as unit,
		
		sum(a.item_in) as qty,
		d.total_amt as chalan_amount,
		i.d_price as dp_price,
		(a.item_in*i.d_price) as dp_total_amt
from journal_item a, item_info i,warehouse w,fg_issue_master m,fg_issue_detail d  

where a.item_in>0 and a.warehouse_id='.$_SESSION['user']['depot'].' 
and d.id=a.tr_no and d.pi_no=m.pi_no and w.warehouse_id=a.relevant_warehouse 
and (a.tr_from="Issue" or a.tr_from="Transfered" or a.tr_from="Transit") 
and a.item_id=i.item_id
'.$date_con.$warehouse_con.$item_con.$item_brand_con.' 
group by d.id order by a.ji_date';
		
break;
		


case 502:
		$report="Receive Report(Brief)";
		if(isset($warehouse_id)) 			{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 
		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 
		//if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 
		
		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between "'.$fr_date.'" and "'.$to_date.'"';}

$sql='select 
		i.item_brand as brand,
		i.finish_goods_code as fg,
		i.item_name,
		i.unit_name as unit,
		sum(a.item_in) as qty,
		avg(i.d_price) as avg_dp_price,
		(sum(a.item_in*i.d_price)) as dp_total_amt,
		avg(d.unit_price) as avg_actual_price,
		(sum(a.item_in*d.unit_price)) as actual_total_amt
		

from journal_item a, item_info i,fg_issue_master m,fg_issue_detail d  
where a.item_in>0 
and a.warehouse_id='.$_SESSION['user']['depot'].' and d.id=a.tr_no and d.pi_no=m.pi_no 
and (a.tr_from="Issue" or a.tr_from="Transfered" or a.tr_from="Transit") 
and a.item_id=i.item_id 
'.$warehouse_con.$date_con.$item_con.$item_brand_con.' 
group by i.item_id order by a.ji_date';

break;
		
		
case 503:
		$report="PR Wise Receive Report";
		if(isset($warehouse_id))	{$warehouse_con.=' and m.warehouse_from='.$warehouse_id;} 
		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.receive_date between "'.$fr_date.'" and "'.$to_date.'"';}

/*$sql='select 
m.pi_no,m.rec_sl_no, m.pi_date,  w.warehouse_name as Depot, m.remarks as sl_no, m.carried_by,
sum(a.item_in*d.unit_price) as amt
from journal_item a, item_info i,warehouse w,fg_issue_master m,fg_issue_detail d  

where a.item_in>0 and a.warehouse_id='.$_SESSION['user']['depot'].' 
and d.id=a.tr_no and d.pi_no=m.pi_no and w.warehouse_id=a.relevant_warehouse 
and (a.tr_from="Issue" or a.tr_from="Transfered" or a.tr_from="Transit") 
and a.item_id=i.item_id
'.$con.$date_con.' 
group by d.pi_no order by m.pi_date';*/


$sql='select 
m.pi_no, m.pi_date, m.remarks as pi_sl_no,m.receive_date,m.rec_sl_no,
(select warehouse_name from warehouse where warehouse_id=m.warehouse_from) as issue_from ,w.warehouse_name as destination, m.carried_by, 
sum(d.total_amt) as actual_amount,
sum(d.total_unit*i.d_price) as dp_amount

from item_info i,warehouse w,fg_issue_master m,fg_issue_detail d 
where 
d.pi_no=m.pi_no
and d.item_id=i.item_id
and w.warehouse_id=d.warehouse_to
'.$warehouse_con.$date_con.' 
and d.warehouse_to='.$_SESSION['user']['depot'].' 
group by m.pi_no order by m.pi_no';
				

break;


case 504:
		$report="Own STORE Less Qty Receive Report";
		if(isset($warehouse_id)) 			{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 
		//if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 
		if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 

		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.receive_date between "'.$fr_date.'" and "'.$to_date.'"';}
		
$sql='select m.pi_no,m.pi_date as issue_date,m.receive_date,w.warehouse_name as warehouse_from,i.finish_goods_code as fg,i.item_name,i.unit_name as unit,
d.total_unit as issue_qty,d.rec_qty,(d.total_unit-d.rec_qty) as short_qty, d.rec_note
		
from item_info i,warehouse w, fg_issue_master m, fg_issue_detail d  

where d.pi_no=m.pi_no and d.item_id=i.item_id
and w.warehouse_id=m.warehouse_from and m.status="RECEIVED" 
and m.warehouse_to='.$_SESSION['user']['depot'].'
and d.rec_status="Pending"
'.$date_con.$warehouse_con.$item_con.$item_brand_con.' 
group by d.id order by m.receive_date';
		
break;


case 505:
		$report="Other Store Less Qty Receive Report";
		if(isset($warehouse_id)) 			{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 
		//if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 
		if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 

		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.receive_date between "'.$fr_date.'" and "'.$to_date.'"';}
		
$sql='select m.pi_no,m.pi_date as issue_date,m.receive_date,w.warehouse_name as warehouse_to,i.finish_goods_code as fg,i.item_name,i.unit_name as unit,
d.total_unit as issue_qty,d.rec_qty,(d.total_unit-d.rec_qty) as short_qty, d.rec_note
		
from item_info i,warehouse w, fg_issue_master m, fg_issue_detail d  

where d.pi_no=m.pi_no and d.item_id=i.item_id
and w.warehouse_id=m.warehouse_from and m.status="RECEIVED" 
and m.warehouse_from='.$_SESSION['user']['depot'].'
and d.rec_status="Pending"
'.$date_con.$warehouse_con.$item_con.$item_brand_con.' 
group by d.id order by m.receive_date';
		
break;







}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$report?></title>
<link href="../../../assets/css/report.css" type="text/css" rel="stylesheet" />
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
.style3 {color: #FFFFFF; font-weight: bold; }
.style5 {color: #FFFFFF}
-->
    </style>
</head>
<body>
<!--<div align="center" id="pr">
<input type="button" value="Print" onclick="hide();window.print();"/>
</div>-->
<div class="main">
<?
		$str 	.= '<div class="header">';
		if(isset($_SESSION['company_name'])) $str 	.= '<h1>MEP Group</h1>';
		//$str 	.= '<h1>'.$_SESSION['company_name'].'</h1>';
		if(isset($report)) 
		$str 	.= '<h2>'.$report.'</h2>';
		if(isset($dealer_code)) 
		$str 	.= '<h2>Dealer Name : '.$dealer_code.' - '.find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code).'</h2>';
		if(isset($depot_id)) 
		$str 	.= '<h2>Depot Name : '.find_a_field('warehouse','warehouse_name','warehouse_id='.$depot_id).'</h2>';
		if(isset($item_brand)) 
		$str 	.= '<h2>Item Brand : '.$item_brand.'</h2>';
		if(isset($item_info->item_id)) 
		$str 	.= '<h2>Item Name : '.$item_info->item_name.'('.$item_info->finish_goods_code.')'.'('.$item_info->sales_item_type.')'.'('.$item_info->item_brand.')'.'</h2>';
		if(isset($to_date)) 
		$str 	.= '<h2>Date Interval : '.$fr_date.' To '.$to_date.'</h2>';
		if(isset($product_group)) 
		$str 	.= '<h2>Product Group : '.$product_group.'</h2>';
		if(isset($region_id)) 
		$str 	.= '<h2>Region Name : '.find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$region_id).'</h2>';
		if(isset($zone_id)) 
		$str 	.= '<h2>Zone Name: '.find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id).'</h2>';
		if(isset($area_id)) 
		$str 	.= '<h3>Area Name: '.find_a_field('area','AREA_NAME','AREA_CODE='.$area_id).'</h3>';		
		if(isset($dealer_type)) 
		$str 	.= '<h2>Dealer Type : '.$dealer_type.'</h2>';
		$str 	.= '</div>';
		$str 	.= '<div class="left" style="width:100%">';



if($_REQUEST['report']==1) { // do summery report modify jan 24 2018

$sql="select m.do_no,i.item_name,m.do_date,m.entry_at ,m.entry_time,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,
w.warehouse_name as depot,
m.rcv_amt,m.received_amt as acc_amt,
concat(m.payment_by,m.bank,m.remarks) as Payment_Details 

from sale_do_master m,sale_do_details s,dealer_info d  , warehouse w, item_info i

where m.do_no=s.do_no and m.status in ('CHECKED','COMPLETED')  and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and i.item_id=s.item_id
".$depot_con.$date_con.$item_con.$dealer_con.$dtype_con." order by m.do_date,m.do_no";


$query = mysql_query($sql); ?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="11"><?=$str?></td></tr>
<tr>
<th>S/L</th>
<th>So No</th>
<th>Item Name</th>
<th>So Date</th>
<th>Confirm At</th>
<th>Entry At</th>
<th>Dealer Name</th>
<th>Depot</th>
<th>Rcv Amt</th>
<th>Acc Amt</th>
<th>Payment Details</th>
<th>Total Amt</th>
</tr>
</thead><tbody>

<?
while($data=mysql_fetch_object($query)){$s++;
$sqld = 'select sum(total_amt),sum(t_price*total_unit) from sale_do_details where do_no='.$data->do_no;
$info = mysql_fetch_row(mysql_query($sqld));
$rcv_t = $rcv_t+$data->rcv_amt;
$acc_t = $acc_t+$data->acc_amt;
$dp_t = $dp_t+$info[0];
$tp_t = $tp_t+$info[1];
?>
<tr>
<td><?=$s?></td>
<td><a href="../wo/sales_order_print_view.php?v_no=<?=$data->do_no?>" target="_blank"><?=$data->do_no?></a></td>
<td><?=$data->item_name?></td>
<td><?=$data->do_date?></td>
<td><?=$data->entry_at?></td>
<td><?=$data->entry_time?></td>
<td><?=$data->dealer_name?></td>
<td><?=$data->depot?></td>
<td style="text-align:right"><?=$data->rcv_amt?></td>
<td style="text-align:right"><?=$data->acc_amt?></td>
<td><?=$data->Payment_Details?></td>
<td><?=$info[0]?></td>
</tr>
<? } ?>
<tr class="footer">
<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
<td style="text-align:right"><?=number_format($rcv_t,2)?></td>
<td style="text-align:right"><?=number_format($acc_t,2)?></td>
<td>&nbsp;</td>
<td><?=number_format($dp_t,2)?></td>
</tr>
</tbody>
</table>
<? }





elseif($_REQUEST['report']==8) {
    

?>
<table id="ExportTable" width="100%" border="0" cellpadding="2" cellspacing="0">
		<thead>
			<tr>
				<td colspan="10" style="border:0px;"><div class="header">
				 <?=$str;?>
				</td>
			</tr>
			<tr>
				<th>S/L</th>
				<th>Req No</th>
				<th>Req Date</th>
				<th>Req From</th>
				<th>Company</th>
				<th>Item ID</th><th>Item Name</th>
				<th>Req Qty</th><th>Issued Qty</th><th>Pending Qty</th>
			</tr>
		</thead>
		<tbody>
<?
$sql="select m.req_no,m.req_date,i.item_id,i.finish_goods_code,i.item_name,sum(d.qty) as req_qty , m.group_for, m.warehouse_id as req_from
from requisition_fg_master m, requisition_fg_order d, item_info i
where m.req_no=d.req_no and i.item_id=d.item_id and m.warehouse_to='".$_SESSION['user']['depot']."' and m.req_date between '".$f_date."' and '".$t_date."' 
and m.status in('PENDING','CHECKED','COMPLETED') 
".$item_con."
group by m.req_no,i.item_id";
$squery=mysql_query($sql);
$sl =1;
while($res =mysql_fetch_object($squery)){ 

$issue_qty=find1("select sum(total_unit) from fg_issue_detail where req_no='".$res->req_no."' and item_id='".$res->item_id."' ");

?>
<tr>
    <td><?=$sl++;?></td>
    <td align="center"><?=$res->req_no;?></td>
    <td><?=$res->req_date;?></td>
    <td><?=show_warehouse($res->req_from);?></td>
    <td><?=show_company2($res->group_for);?></td>
    <td><?=$res->finish_goods_code;?></td>
    <td><?=$res->item_name;?></td>
    <td><?=$res->req_qty;?></td>
    <td><?=$issue_qty?></td>
    <td><?=$res->req_qty-$issue_qty;?></td>

</tr>
<?
}
?>

</tbody>
</table>
<?	
}


elseif($_REQUEST['report']==9) {
 
 

?>
<table width="100%" border="0" cellpadding="2" cellspacing="0">
		<thead>
			<tr>
				<td colspan="10" style="border:0px;"><div class="header">
				 <?=$str;?>
				</td>
			</tr>
			<tr>
				<th>S/L</th>
				<th>Req No</th>
				<th>Req Date</th>
				<th>Req TO</th>
				<th>Company</th>
				<th>Item ID</th><th>Item Name</th>
				<th>Req Qty</th><th>Issued Qty</th><th>Pending Qty</th>
			</tr>
		</thead>
		<tbody>
<?
$sql="select m.req_no,m.req_date,i.item_id,i.finish_goods_code,i.item_name,sum(d.qty) as req_qty , m.group_for, m.warehouse_to as req_to
from requisition_fg_master m, requisition_fg_order d, item_info i
where m.req_no=d.req_no and i.item_id=d.item_id and m.warehouse_id='".$_SESSION['user']['depot']."' 
and m.req_date between '".$f_date."' and '".$t_date."' and m.status in('PENDING','CHECKED','COMPLETE') 
".$item_con."
group by m.req_no,i.item_id";
$squery=mysql_query($sql);
$sl =1;
while($res =mysql_fetch_object($squery)){ 

$issue_qty=find1("select sum(total_unit) from fg_issue_detail where req_no='".$res->req_no."' and item_id='".$res->item_id."' ");

?>
<tr>
    <td><?=$sl++;?></td>
    <td align="center"><?=$res->req_no;?></td>
    <td><?=$res->req_date;?></td>
    <td><?=show_warehouse($res->req_to);?></td>
    <td><?=show_company2($res->group_for);?></td>
    
    <td><?=$res->finish_goods_code;?></td>
    <td><?=$res->item_name;?></td>
    
    <td><?=$res->req_qty; $greq_qty+=$res->req_qty;?></td>
    <td><?=$issue_qty; $gissue_qty+=$issue_qty;?></td>
    <td><?=$res->req_qty-$issue_qty; $gpending+=$res->req_qty-$issue_qty;?></td>

</tr>
<?
}
?>
<tr>
    <td colspan="7">Total</td>
    <td><?=$greq_qty;?></td>
    <td><?=$gissue_qty?></td>
    <td><?=$gpending;?></td>
</tr>



</tbody>
</table>
<?	
}









elseif($_REQUEST['report']==2012) {
    
if(isset($dealer_code)) 
$sqlbranch 	= "select * from dealer_info where dealer_type like 'Distributor' and dealer_code = ".$dealer_code;
else
$sqlbranch 	= "select * from dealer_info where dealer_type like 'Distributor' ";
$querybranch = mysql_query($sqlbranch);
while($branch=mysql_fetch_object($querybranch)){
	$rp=0;
	echo '<div>';
	
$op_sql = "select sum(item_in-item_ex) as stock , warehouse_id, item_id from journal_item where warehouse_id = ".$branch->dealer_depo." group by item_id ";
$op_query= mysql_query($op_sql);
while($opqr = mysql_fetch_object($op_query)){
	$depo_op[$opqr->warehouse_id][$opqr->item_id] = $opqr->stock;
}

$op_sql1 = "select sum(total_unit) as stock , dealer_code, item_id from sale_do_chalan where dealer_code = ".$branch->dealer_code." and chalan_date<'".$_POST['f_date']."' group by item_id ";
$op_query1= mysql_query($op_sql1);
while($opqr1 = mysql_fetch_object($op_query1)){
	$depo_chalan[$opqr1->dealer_code][$opqr1->item_id] = $opqr1->stock;
}

 $op_sql2 = "select sum(total_unit) as stock , dealer_code, item_id from sale_do_chalan where dealer_code = ".$branch->dealer_code." and chalan_date between '".$_POST['f_date']."' and '".$_POST['t_date']."' group by item_id ";
$op_query2= mysql_query($op_sql2);
while($opqr2 = mysql_fetch_object($op_query2)){
	 $chalan[$opqr2->dealer_code][$opqr2->item_id] = $opqr2->stock;
}
//if(isset($zone_id)) 
//$sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID." and ZONE_CODE=".$zone_id;
//else
// $sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID;
//
//	$queryzone = mysql_query($sqlzone);
//	while($zone=mysql_fetch_object($queryzone)){
if($area_id>0) 
$area_con = "and a.AREA_CODE=".$area_id;

$sql = "select i.item_id,i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,
floor(sum(o.total_unit)/i.pack_size) as crt,
mod(sum(o.total_unit),i.pack_size) as pcs, 
sum(o.total_unit) as total_unit,
sum(o.total_amt) as DP,
sum(o.total_unit*o.t_price) as TP
from 
ss_do_master m,ss_do_details o, item_info i, warehouse w, dealer_info d, area a
where m.do_no=o.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and i.item_id=o.item_id and a.AREA_CODE=d.area_code 
and m.status in ('CHECKED','COMPLETED') and m.dealer_code=".$branch->dealer_code." and o.unit_price>0
".$date_con.$item_con.$item_brand_con.$pg_con.$area_con.' 
group by i.finish_goods_code';

 $sqlt="select sum(o.t_price*o.total_unit) as total,sum(total_amt) as dp_total, sum(total_unit) as unit_total
from 
ss_do_master m,ss_do_details o, item_info i, warehouse w, dealer_info d, area a
where m.do_no=o.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot 
and i.item_id=o.item_id and a.AREA_CODE=d.area_code  and m.status in ('CHECKED','COMPLETED') 
and o.unit_price>0
and m.dealer_code=".$branch->dealer_code." ".$date_con.$item_con.$item_brand_con.$pg_con.$area_con.'';

		$queryt = mysql_query($sqlt);
		$t= mysql_fetch_object($queryt);
		if($t->dp_total>0)
		{
			if($rp==0) {$reg_total=0;$dp_total=0; 
			$str .= '<p style="width:100%"><strong>Dealer Name: '.$branch->dealer_name_e.' Dealer Code: '.$branch->dealer_code.' </strong></p>';$rp++;}
			$str .= '<p style="width:100%">Address: '.$branch->address_e. ' <strong>Mobile: </strong>'.$branch->mobile_no.' </p>';
		?>	
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		<thead>
			<tr>
				<td colspan="10" style="border:0px;"><div class="header">
				 <?=$str;?>
				</td>
			</tr>
			<tr>
				<th>S/L</th>
				<th>Code</th>
				<th>Item Name</th>
				<th>Item Brand</th>
				<th>Group</th>
				<th>Opening Stock</th>
				<th>Chalan Qty</th>
				<th>Total Stock</th>
				<th>Sales Qty</th>
				<th>Present Stock</th>
				<th>DP</th>
				<th>TP</th>
			</tr>
		</thead>
		<tbody>
		<?
		
			$unit_total1 = 0;
			$reg_total1  = 0;
			$dp_total1   = 0;
		
		 $squery=mysql_query($sql);
			$sl =1;
			while($res = mysql_fetch_object($squery)){ ?>
			<tr>
				<td><?=$sl++;?></td>
				<td align="center"><?=$res->code;?></td>
				<td><?=$res->item_name;?></td>
				<td><?=$res->item_brand;?></td>
				<td><?=$res->group;?></td>
				<td align="right"><?=$op_stock = ($depo_op[$branch->dealer_depo][$res->item_id]+$depo_chalan[$branch->dealer_code][$res->item_id]);?></td>
				<td align="right"><?=$chalan1 = $chalan[$branch->dealer_code][$res->item_id];?></td>
				<td align="right"><?=$stock=($op_stock+$chalan1);?></td>
				<td align="right"><?=$res->total_unit;?></td>
				<td align="right"><?=$present_stock = ($stock - $res->total_unit);?></td>
				<td align="right"><?=$res->DP;?></td>
				<td align="right"><?=$res->TP;?></td>
			</tr>
		 
		<?
		}
			//echo report_create($sql,1,$str);
			$str = '';
			
			$unit_total1 = $unit_total1+$t->unit_total;
			$reg_total1  = $reg_total1+$t->total;
			$dp_total1   = $dp_total1+$t->dp_total;
			
		}

	//}
?>
			<tr>
				<td></td>
				<td colspan="7" align="right">Total:</td>
				<td align="right"><strong><?=number_format($unit_total1,2);?></strong></td>
				<td align="right"></td>
				<td align="right"><strong><?=number_format($dp_total1,2);?></strong></td>
				<td align="right"><strong><?=number_format($reg_total1,2);?></strong></td>
			</tr>
		  </tbody>
</table>
<?	
}
}


elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}
?>
</div>
</body>
</html>
<?
$page_name= $_POST['report'].$report."(Master Report Page)";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>