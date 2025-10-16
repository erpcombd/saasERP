<?

//session_start();

 

 

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
	
	if($_POST['by']>0) 			$by=$_POST['by'];
	if($_POST['vendor_id']>0) 	$vendor_id=$_POST['vendor_id'];
	if($_POST['cat_id']>0) 		$cat_id=$_POST['cat_id'];
	if($_POST['item_id']>0) 	$item_id=$_POST['item_id'];
	if($_POST['sub_group_id']>0)$sub_group_id=$_POST['sub_group_id'];
	if($_POST['status']!='') 	$status=$_POST['status'];

switch ($_POST['report']) {
    case 1:
		$report="Purchase Order Report";
		//if(isset($by)) 			{$by_con=' and a.entry_by='.$by;}
		if($_POST['by']>0)
		
		$by_con .= 'and a.entry_by="'.$_POST['by'].'"';
		
		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;}
		if(isset($cat_id)) 		{$cat_con=' and d.id='.$cat_id;}
		if(isset($item_id)) 	{$item_con=' and b.item_id='.$item_id;}
		
		if($_POST['sub_group_id']>0)
		
		$item_con .= 'and d.sub_group_id="'.$_POST['sub_group_id'].'"';

		//if(isset($sub_group_id)){$item_sub_con=' and d.sub_group_id='.$sub_group_id;} 
		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';}
		
if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.po_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		
		   $sql='select a.po_no as po_no,b.id as order_id, a.po_date,c.vendor_name as vendor_name,e.item_name,a.status,f.fname as entry_by, a.entry_at,d.sub_group_name,b.qty,b.rate,b.amount
		   
		   from purchase_master a, purchase_invoice b, vendor c, item_sub_group d, item_info e, user_activity_management f 
		   where a.po_no=b.po_no and c.vendor_id=a.vendor_id and d.sub_group_id=e.sub_group_id and b.item_id=e.item_id and f.user_id=a.entry_by and a.status!="MANUAL" '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$item_sub_con.$status_con.' order by a.po_no,b.id';
	break;
	
    case 2:
		$report="Purchase Receive Report(PO Wise))";
		if(isset($by)) 			{$by_con=' and a.prepared_by='.$by;} 
		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;} 
		if(isset($cat_id)) 		{$cat_con=' and d.id='.$cat_id;} 
		if(isset($item_id)) 	{$item_con=' and b.item_id='.$item_id;} 
		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';} 
if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.po_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		
  $sql='select a.po_date,c.vendor_name as vendor_name,a.status,f.fname as prepared_by, a.prepared_at,a.id as po_no,b.id as order_id,d.category_name,e.item_name,(b.qty*1.00) as qty,b.rate,b.amount,
((select sum(qty) from purchase_master_chalan where b.id=specification_id)*1.00) as chalan_qty, 
((select b.rate*sum(qty) from purchase_master_chalan where b.id=specification_id)*1.00) as chalan_amt,

if((select count(qty) from purchase_master_chalan where b.id=specification_id)>0,((b.qty-(select sum(qty) from purchase_master_chalan where b.id=specification_id))*1.00),(b.qty*1.00)) as balance_qty
 from purchase_master a, 
purchase_invoice b, vendor c, item_sub_group d, item_info e, user_activity_management f where a.id=b.po_no and c.id=a.vendor_id and d.id=e.product_category_id and b.item_id=e.id and f.user_id=a.prepared_by and a.status!="MANUAL" '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$status_con.' order by a.id,b.id';
	break;
	
	case 3:
		$report="Chalan Report (Chalan Date Wise)";
		if(isset($by)) 			{$by_con=' and a.prepared_by='.$by;} 
		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;} 
		if(isset($cat_id)) 		{$cat_con=' and d.id='.$cat_id;} 
		if(isset($item_id)) 	{$item_con=' and b.item_id='.$item_id;} 
		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';} 
if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.po_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		
		   $sql='select a.po_date,c.vendor_name as vendor_name,a.status,f.fname as prepared_by, a.prepared_at,a.id as po_no,b.id as order_id,d.category_name,e.item_name,(b.qty*1.00) as qty,b.rate,b.amount,
((select sum(qty) from purchase_master_chalan where b.id=specification_id)*1.00) as chalan_qty, 
((select b.qty-sum(qty) from purchase_master_chalan where b.id=specification_id)) as balance_qty from purchase_master a, 
purchase_invoice b, vendor c, item_sub_group d, item_info e, user_activity_management f where a.id=b.po_no and c.id=a.vendor_id and d.id=e.product_category_id and b.item_id=e.id and f.user_id=a.prepared_by and a.status!="MANUAL" '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$status_con.' order by a.id,b.id';
	break;
	case 1005:
		$report="Present Stock";
				if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 
		if(isset($receive_status)) 			{$status_con=' and a.tr_from="'.$receive_status.'"';} 
		elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 
		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date <="'.$to_date.'"';}
		break;
		
		case 1007:
		$report="Present Stock";
				if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 
		if(isset($receive_status)) 			{$status_con=' and a.tr_from="'.$receive_status.'"';} 
		elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 
		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date <="'.$to_date.'"';}
		break;
		
	case 5:
		$report="Purchase History Report";
		if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 
		if(isset($vendor_id)) 	{$vendor_con=' and v.vendor_id='.$vendor_id;} 
		$status_con=' and a.tr_from = "Purchase" ';
		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		
		 $sql='select ji_date as GR_Date,a.sr_no as GR_no,pm.po_date,pm.po_no,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `RQ`,a.item_price as rate,((a.item_in+a.item_ex)*a.item_price) as amount,v.vendor_name,a.entry_at,c.fname as User 
		   
		   from journal_item a, item_info i, user_activity_management c , item_sub_group s , purchase_receive pr,purchase_master pm,vendor v
		   where pm.vendor_id=v.vendor_id and c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and a.item_id=i.item_id and a.warehouse_id="1" and a.tr_no=pr.id and pr.po_no=pm.po_no '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.$vendor_con.' order by a.id';
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
		$str 	.= '<div class="header">';
		if(isset($_SESSION['company_name'])) 
		$str 	.= '<h1>'.find_a_field('user_group','group_name','1').'</h1>';
		if(isset($report)) 
		$str 	.= '<h2>'.$report.'</h2>';
		if(isset($to_date)) 
		$str 	.= '<h2>'.$fr_date.' To '.$to_date.'</h2>';
		$str 	.= '</div>';
		if(isset($_SESSION['company_logo'])) 
		//$str 	.= '<div class="logo"><img height="60" src="'.$_SESSION['company_logo'].'"</div>';
		$str 	.= '<div class="left">';
		if(isset($project_name)) 
		$str 	.= '<p>Project Name: '.$project_name.'</p>';
		if(isset($allotment_no)) 
		$str 	.= '<p>Allotment No.: '.$allotment_no.'</p>';
		$str 	.= '</div><div class="right">';
		if(isset($client_name)) 
		$str 	.= '<p>Client Name: '.$client_name.'</p>';
		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		
		
		
		
if($_REQUEST['report']==1100) { // do summery report modify jan 24 2018

 $sql="select m.do_no,i.item_name,m.do_date,d.dealer_name_e as dealer_name,
w.warehouse_name as depot,s.unit_price,s.total_unit,s.total_amt,m.status


from sale_return_master m,sale_return_details s,dealer_info d  , warehouse w, item_info i,user_group u

where m.status in ('CHECKED','COMPLETED')  and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and i.item_id=s.item_id
".$depot_con.$date_con.$item_con.$dealer_con.$dtype_con." order by m.do_date,m.do_no";


$query = db_query($sql); ?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">

<thead><tr><td style="border:0px;" colspan="11"><?=$str?></td></tr>

<tr>
<th>S/L</th>
<th>SR No</th>
<th>Item Name</th>
<th>SR Date</th>
<th>Dealer Name</th>
<th>Depot</th>
<th>Unit Price</th>
<th>Total Unit</th>
<th>Total Amount</th>
<th>Status</th>
<!--<th>Payment Details</th>
<th>Total Amt</th>-->
</tr>
</thead><tbody>

<?
while($data=mysqli_fetch_object($query)){$s++;

?>
<tr>
<td><?=$s?></td>
<td><?=$data->do_no?></td>
<td><?=$data->item_name?></td>
<td><?=$data->do_date?></td>
<td><?=$data->dealer_name?></td>
<td><?=$data->depot?></td>
<td><?=$data->unit_price?></td>
<td><?=$data->total_unit?></td>
<td style="text-align:right"><?=$data->total_amt; $total=$total+$data->total_amt?></td>
<td style="text-align:right"><?=$data->status?></td>

</tr>
<? } ?>
<tr class="footer">
<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
<td style="text-align:right">&nbsp;</td>
<td style="text-align:right">&nbsp;</td>
<td style="text-align:right;">Total Amount</td>
<td style="text-align:right;"><?=number_format($total,2)?></td>
</tr>
</tbody>
</table>
<? }





		
		
if($_POST['report']==5)
{
$report="Purchase Receive Report";
?>
	<table width="100%" border="0" cellpadding="2" cellspacing="0" id="ExportTable">
		
		<thead>
		<tr><td colspan="19" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('user_group','group_name','1').'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';

if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
<tbody>

	<tr>
		<th>Po No</th>
		<th>Po Date</th>
		<th>Vendor Name</th>
		<th>Item Name </th>
		<th>Rate</th>
		<th>OQ</th>
		<th>RQ</th>
		<th>DQ</th>
	    <th>Amt</th>
	</tr>
<? 


if($_POST['f_date']!=''&&$_POST['t_date']!='')
$con .= ' and a.po_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
if($_POST['vendor_id']>0)
$con .= 'and a.vendor_id="'.$_POST['vendor_id'].'"';

$res='select  a.po_no, a.po_date, v.vendor_name,u.fname as entry_by
from 
purchase_master a,warehouse b, vendor v,user_activity_management u where u.user_id=a.entry_by and a.warehouse_id=b.warehouse_id and  a.vendor_id=v.vendor_id and  a.warehouse_id = "'.$_SESSION['user']['depot'].'" '.$con.' order by a.po_no desc';

$query = db_query($res);
while($data=mysqli_fetch_object($query))
{

?>

	<tr>
      <td valign="top"><?=$data->po_no;?></td>
	  <td valign="top"><?=$data->po_date;?></td>
	  <td valign="top"><?=$data->vendor_name;?></td>
	  <td colspan="6">
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable" style="font-size:9px; border:0;">
<? 
$sql = 'select a.*,b.item_name from purchase_invoice a,item_info b where a.item_id=b.item_id and a.po_no="'.$data->po_no.'"';
$sqlq = db_query($sql);
while($info=mysqli_fetch_object($sqlq)){
?>
	<tr style=" border-collapse: collapse;">
	  <td width="28.5%"><?=$info->item_name.'('.$info->unit_name.')';?></td>
	  <td width="15.3%"><?=number_format($info->rate,2)?></td>
	  <td width="11%"><?=number_format($info->qty,0)?></td>
	  <td width="11%"><? $rq = find_a_field('purchase_receive','sum(qty)','order_no="'.$info->id.'"'); echo number_format($rq,0);?></td>
	  <td width="11%"><? $dq = $info->qty - $rq; if($dq>0) echo number_format($dq,0); $tot = $rq*$info->rate; $total = $total + $tot;?></td>
	  <td width="0%"><?=number_format(($tot),2);?></td>
	</tr>
<? }?>
</table>	  </td>
	</tr>
<? }?>
	<tr>
	  <td colspan="8" valign="top"><div align="right"><strong>Total:</strong></div></td>
	  <td><div align="left">
	    <?=number_format(($total),2);?></div></td>
	</tr>
</tbody></table>
<?
}
elseif(isset($sql)&&$sql!='') echo report_create($sql,1,$str);


elseif($_POST['report']==1007){ // MR vs PO vs GR
$report="Requisition vs PO vs GR";
if($_POST['company_id']>0) {echo 'Must be select Company';} else {

if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
elseif(isset($item_id)) 				{$item_con=' and o.item_id='.$item_id;} 
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and o.req_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($warehouse_id)) 				{$warehouse_con=' and m.warehouse_id='.$warehouse_id;} 
 


$ssql = 'select warehouse_id from warehouse where group_for='.$company_id;
$qquery = db_query($ssql); while($sec = mysqli_fetch_object($qquery)){
if($warehouse_list == '') $warehouse_list .= $sec->warehouse_id; else $warehouse_list .= ','.$sec->warehouse_id;
}
$company_con = ' and m.warehouse_id in ('.$warehouse_list.')';


 $sql3='SELECT  m.req_no,m.req_date,o.id as req_id,o.item_id,o.qty as req_qty,m.req_for,m.req_note,m.status,i.unit_name,m.warehouse_id,
(select sub_group_name from item_sub_group where sub_group_id = i.sub_group_id) as category,
i.item_name,o.qty,o.entry_at
FROM  requisition_order o, requisition_master m, item_info i
where o.req_no = m.req_no and i.item_id = o.item_id '.$date_con.$item_con.$warehouse_con.'
order by m.warehouse_id,o.req_date';
		   
$query =db_query($sql3);   
//$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <thead>
    <tr>
      <td style="border:0px;" colspan="16"><div class="header">
          <!--<h1>Sajeeb Group</h1>--><h2><b><?=$report?></b></h2><h3>Date Interval: <?=$fr_date?> to <?=$to_date?></h3></div>
<div class="left"></div><div class="right"></div><div class="date">Reporting Time:<?=date("h:i A d-m-Y")?>
      </div></td>
    </tr>
    <tr>
      <th>S/L</th>
      <th>Warehouse</th>
      <th>Req No</th>
	  <th>PO No</th>
      <th>Req Date</th>
      <th>Req ID </th>
      <th>Item Group</th>
      <th>Item ID </th>
      <th>Item Name</th>
      <th>Unit</th>
      <th>Req Qty </th>
      <th>PO Qty </th>
      <th>GR Qty </th>
      <th>Pending Qty </th>
    </tr>
  </thead>
  <tbody>
<? while($data=mysqli_fetch_object($query)){
$j++;

$po_qty = find_a_field('purchase_invoice','sum(qty)','req_id="'.$data->req_id.'"');

$value = '';
$ssql = 'select id from purchase_invoice where req_id='.$data->req_id;
$qquery = db_query($ssql); 
while($sec = mysqli_fetch_object($qquery)){
if($value == '') $value .= $sec->id; else $value .= ','.$sec->id; }

$gr_query= 'select sum(qty) from purchase_receive where order_no in ('.$value.')';
$gr_qty = find_a_field_sql($gr_query);

$pending_qty = $data->req_qty - $gr_qty;

?>
    <tr>
      <td><?=$j?></td>
      <td><?=find_a_field('warehouse','warehouse_name','warehouse_id="'.$data->warehouse_id.'"');?></td>
      <td><?=$data->req_no?></td>
	  <td><?=find_a_field('purchase_master','po_no','req_no="'.$data->req_no.'"');?></td>
      <td><?=$data->req_date?></td>
      <td><?=$data->req_id?></td>
      <td><?=$data->category?></td>
      <td>C-<?=$data->item_id?></td>
      <td><?=$data->item_name?></td>
      <td><?=$data->unit_name?></td>
      <td><?=(int)$data->req_qty?></td>
      <td><?=(int)$po_qty?></td>
      <td><?=(int)$gr_qty;?></td>
      <td><b><?=$pending_qty?></b></td>
    </tr>
<? } ?>
  </tbody>
</table>
<?
} // end condition company must be
}

elseif($_POST['report']==1005) 
{
if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;}
if(isset($item_id)) 				{$item_cons=' and i.item_id='.$item_id;}
if($_POST['item_sub_group']>0) 				{$item_cons .=' and i.sub_group_id='.$_POST['item_sub_group'];}
if($_SESSION['user']['depot']==5)
$sql='select distinct i.item_id,i.unit_name,i.item_name,s.sub_group_name,i.finish_goods_code,i.pack_size,i.d_price as item_price
		   from item_info i, item_sub_group s where i.product_nature = "Salable" '.$item_cons.' and 
		   i.sub_group_id=s.sub_group_id order by i.finish_goods_code,s.sub_group_name,i.item_name';
else
 $sql='select distinct i.item_id,i.unit_name,i.item_name,s.sub_group_name,i.finish_goods_code,i.pack_size,i.d_price as item_price
		   from item_info i, item_sub_group s where 1 '.$item_cons.' and 
		   i.sub_group_id=s.sub_group_id order by i.finish_goods_code,s.sub_group_name,i.item_name';
		$query =db_query($sql); 
		if($warehouse_id>0){  
		$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id);
		}else{
		$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);
		}
		//echo $sql;
?>

<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
	<thead>
	<tr>
		<td style="border:0px;" colspan="10">
			<div class="header">
				<h1><?=$company_name?></h1>
				<h2><?=$report?></h2>
				<h2>Closing Stock of Date - <b><?=date("d-m-Y",strtotime($to_date));?></b></h2>
			</div>
			<div class="left">

			</div>
			<div class="right">

			</div>
			<div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div>
		</td>
	</tr>
	<tr>

<th rowspan="2">S/L</th>
<th rowspan="2">Warehouse Name</th>
<th rowspan="2">Item Code</th>
<th rowspan="2">FG</th>
<th rowspan="2">Item Name</th>
<th rowspan="2">Ctn Size</th>
<th rowspan="2">Unit</th>
<th colspan="2">Final Stock</th>
<th rowspan="2">Total Pcs</th>
<th rowspan="2">Rate</th>
<th rowspan="2">Stock Price</th>
</tr>
<tr>
  <th bgcolor="#CCFFFF">Pcs</th>
  <th bgcolor="#FFCCFF">ctr</th>
</tr>

</thead>
	<tbody>
<?
while($data=mysqli_fetch_object($query)){
if($_SESSION['user']['level']==4 or $_SESSION['user']['level']==5){
   $s='select sum(a.item_in-a.item_ex) as final_stock
from journal_item a where  a.item_id="'.$data->item_id.'" '.$date_con.$item_con.$status_con.$warehouse_con.' order by a.id desc limit 1';

 $p='select avg(a.item_price) as item_price_f
from journal_item a where a.tr_from like "Purchase" and a.item_id="'.$data->item_id.'" '.$date_con.$item_con.$status_con.$warehouse_con.' order by a.id desc limit 1';

/*$total_item_price = find_a_field('journal_item a','sum(a.item_price)','a.item_id="'.$data->item_id.'" '.$date_con.$item_con.$status_con.$warehouse_con.'');
$total_in = find_a_field('journal_item a','sum(a.item_in)','a.item_id="'.$data->item_id.'" '.$date_con.$item_con.$status_con.$warehouse_con.'');
$avg_rate = $total_item_price/$total_in;*/

}else{ $s='select sum(a.item_in-a.item_ex) as final_stock
from journal_item a where  a.item_id="'.$data->item_id.'" '.$date_con.$item_con.$status_con.' and a.warehouse_id="'.$_SESSION['user']['depot'].'" order by a.id desc limit 1';

$p='select avg(a.item_price) as item_price_f
from journal_item a where a.tr_from like "Purchase" and  a.item_id="'.$data->item_id.'" '.$date_con.$item_con.$status_con.' and a.warehouse_id="'.$_SESSION['user']['depot'].'" order by a.id desc limit 1';
}
//echo $s;
$q = db_query($s);
$r = db_query($p);
$s = mysqli_fetch_object($r);

$i=mysqli_fetch_object($q);$j++;
		   ?>
<tr <? if($i->final_stock<0) echo 'style="background-color:yellow"'; ?>>
<td><?=$j?></td>
<td><?=$warehouse_name?></td>
<td><?=$data->item_id?></td>
<td><?=$data->finish_goods_code?></td>
<td><?=$data->item_name?></td>
<td><?=$data->pack_size?></td>
<td><?=$data->unit_name?></td>
<td style="text-align:right; background-color:#CCFFFF;"><?=number_format(($i->final_stock/$data->pack_size),2)?></td>
<td style="text-align:right;background-color:#FFCCFF;"><?=($i->final_stock%$data->pack_size)?></td>
<td style="text-align:right"><?=number_format($i->final_stock,2)?></td>
<td style="text-align:right"><?=@number_format(($s->item_price_f),2); $total_rate+=$s->item_price_f;?></td>
<td style="text-align:right"><? $sum = $s->item_price_f*$i->final_stock; echo number_format(($s->item_price_f*$i->final_stock),2); ?></td>
</tr>
<?
$t_unit+=$i->final_stock;
$t_sum = $t_sum + $sum;
}
?>
<tr style="font-weight:bold;">
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td align="right"> <b>Total :</b></td>
<td></td>
<td style="text-align:right; background-color:#CCFFFF;"><?= number_format($t_unit,2)?></td>
<td style="text-align:right;background-color:#FFCCFF;"></td>
<td style="text-align:right"><?= number_format($t_unit,2)?></td>
<td style="text-align:right"><?=number_format($total_rate,2);?></td>
<td style="text-align:right"><?=number_format($t_sum,2)?></td>
</tr>
<?
}


?></div>
</body>
</html>