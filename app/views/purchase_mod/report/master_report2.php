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


    case 36:
		$report="Purchase Order Details List";
		
	break;
	
	
	case 37:
		$report="Vendor Report";
		
		
		

		 	   
		   
		   
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
	case 35:
		$report="Warehouse Stock Position Report(Closing)";
		if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 
		if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
	    if(isset($group_id)) 			    {$group_id_con=' and s.group_id ='.$group_id;} 

		if(isset($item_id)) 			{$item_con=' and a.item_id='.$item_id;} 
		if(isset($receive_status)) 			{$status_con=' and a.tr_from="'.$receive_status.'"';} 
		if(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 
		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date <="'.$to_date.'"';}

	break;
		
	case 41:
		$report="Requisition vs Purchase vs Receive";
	break;
	
	case 42:
		$report="Purchase Order Item Summary";
	break;

	case 43:
		$report="Purchase Item Historical Report";
	break;
	case 44:
		$report="Purchase Item Rate Variance Report";
	break;
	case 45:
		$report="Vendor Wise Summary Quantity (Month Wise)";
	break;
	case 46:
		$report="Vendor Wise Summary Amount (Month Wise)";
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

$tr_type="Show";

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

<style>

    th {
      background-color: #f4f4f4;
      position: sticky;
      top: 0; /* Position the header at the top */
      z-index: 1; /* Ensure it appears above other rows */
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
		/*$str 	.= '<div class="header">';
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
		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';*/
		
		
		
		
		
		
$str 	.= '<tr style="border: 0px">';
$str 	.= '<th style="border: 0px" colspan="2" width="25%" align="center" >';
if(isset($_SESSION['user']['group']))
	$str 	.= '<img width="50%" src="'.SERVER_ROOT.'public/uploads/logo/'.$_SESSION['proj_id'].'.png'.'">';
$str 	.= '</th>';

$str 	.= '<th style="border: 0px" colspan="6" width="50%" align="center" >';
$str 	.= '<h1 style="font-weight: bolder; text-align: center;">'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';

if(isset($report))
	$str 	.= '<h2 style="margin: 1px; font-size:14px; font-weight: bold;">'.$report.'</h2>';

if(isset($vendor_id))
	$str 	.= '<h2 style="margin: 1px; font-size:12px;"><strong>Broker Name:</strong>'.find_a_field('vendor','vendor_name','vendor_id='.$vendor_id).'</h2>';

if(isset($ctg_warehouse))
	$str 	.= '<h3 style="margin: 1px; font-size:12px;"><strong>Ctg Warehouse:</strong> '.find_a_field('tea_warehouse','warehouse_name','warehouse_id='.$ctg_warehouse).'</h3>';

if(isset($garden_id))
	$str 	.= '<h3 style="margin: 1px; font-size:12px;"><strong>Garden Name:</strong> '.find_a_field('tea_garden','garden_name','garden_id='.$garden_id).'</h3>';


if(isset($to_date))
	$str 	.= '<h2 style="margin: 1px; font-size:12px;"><strong>For the Period of: </strong>'.date("d-m-Y",strtotime($fr_date)).' <strong>To</strong> '.date("d-m-Y",strtotime($to_date)).'</h2>';


if(isset($warehouse_id))
	$str 	.= '<h2 style="margin: 1px; font-size:12px;"><strong>PL/WH Name:</strong> '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</h2>';

//	if(isset($warehouse_id))
//		$str 	.= '<h2 style="margin: 1px; font-size:12px;"><strong>PL/WH Name: </strong>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</h2>';
if(isset($allotment_no))
	$str 	.= '<h2 style="margin: 1px; font-size:12px;"><strong>Allotment No: </strong> '.$allotment_no.'</h2>';

if(isset($item_id))
	$str 	.= '<h2 style="margin: 1px; font-size:12px;"><strong>Item Name: </strong> '.find_a_field('item_info','item_name','item_id='.$item_id).'</h2>';

$str 	.= '</th>';

$str 	.= '<th style="border: 0px" colspan="2" width="25%" align="center" >';
$str 	.= '</th>';
$str 	.= '</tr>';
$str 	.= '<tr><th style="border: 0px" colspan="10">';
$str 	.= '<div class="date" style="margin: 1px; font-size:12px;"> <strong>Reporting Time:</strong> '.date("h:i A d-m-Y").'</div>';
$str 	.= '</th></tr>';


		
		
		
		
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
		<th>Recieve Date</th>
		<th>Vendor Name</th>
		<th>Warehouse Name</th>
		<th>Item Name </th>
		<th>Rate</th>
		<th>Order Qty</th>
		<th>Recieve Qty</th>
		<th>Due Qty</th>
	    <th>Total Amt</th>
	</tr>
<? 


if($_POST['f_date']!=''&&$_POST['t_date']!='')
$con .= ' and a.po_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
if($_POST['vendor_id']>0)
$con .= 'and a.vendor_id="'.$_POST['vendor_id'].'"';
if($_POST['depot_id']>0)
$con .= 'and a.warehouse_id="'.$_POST['depot_id'].'"';

if($_SESSION['user']['depot']==1){
 $res='select  a.po_no, a.po_date, r.po_no, r.rec_date, b.warehouse_name, v.vendor_name,u.fname as entry_by
 
from purchase_master a, purchase_receive r, warehouse b, vendor v,user_activity_management u 
where a.po_no=r.po_no and u.user_id=a.entry_by and a.warehouse_id=b.warehouse_id and  a.vendor_id=v.vendor_id 
'.$con.' group by a.po_no order by a.po_no asc';
} 
else{
 $res='select  a.po_no, a.po_date, r.po_no, r.rec_date, b.warehouse_name, v.vendor_name,u.fname as entry_by
 
from purchase_master a, purchase_receive r, warehouse b, vendor v,user_activity_management u 
where a.po_no=r.po_no and u.user_id=a.entry_by and a.warehouse_id=b.warehouse_id and  a.vendor_id=v.vendor_id 
and  a.warehouse_id = "'.$_SESSION['user']['depot'].'" '.$con.' group by a.po_no order by a.po_no asc';
}

$query = db_query($res);
while($data=mysqli_fetch_object($query))
{

?>

	<tr>
      <td valign="top"><?=$data->po_no;?></td>
	  <td valign="top"><?=$data->po_date;?></td>
	  <td valign="top"><?=$data->rec_date;?></td>
	  <td valign="top"><?=$data->vendor_name;?></td>
	   <td valign="top"><?=$data->warehouse_name;?></td>
	  <td colspan="6">
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable" style="font-size:9px; border:0;">
<? 
if($_POST['item_id']!='')
{
$con .= 'and a.item_id="'.$_POST['item_id'].'"';

}

 $sql = 'select a.*,b.item_name from purchase_invoice a,item_info b where a.item_id=b.item_id and a.po_no="'.$data->po_no.'" '.$con.'';
$sqlq = db_query($sql);
while($info=mysqli_fetch_object($sqlq)){
?>
	<tr style=" border-collapse: collapse;">
	  <td width="19%"><?=$info->item_name.'('.$info->unit_name.')';?></td>
	  <td width="10%"><?=number_format($info->rate,2)?></td>
	  <td width="18%" style="text-align:right"><?=number_format($info->qty,0); $tot_oq+=$info->qty;?></td>
	  <td width="18%" style="text-align:right"><? $rq = find_a_field('purchase_receive','sum(qty)','item_id="'.$info->item_id.'" and po_no="'.$info->po_no.'"'); 
	                     echo number_format($rq,0); $tot_rq+=$rq;?></td>
	  <td width="17%" style="text-align:right"><? $dq = $info->qty - $rq; echo number_format($dq,0); $tot_dq+=$dq; $tot = $rq*$info->rate; $total = $total + $tot;?></td>
	  <td width="17%" style="text-align:right"><?=number_format(($tot),2);?></td>
	</tr>
<? }?>
</table>	  </td>
	</tr>
<? }?>
	<tr>
	  <td colspan="7" valign="top"><div align="right"><strong>Total:</strong></div></td>
	  <td><div align="right"><?=number_format(($tot_oq),0);?></div></td>
	  <td><div align="right"><?=number_format(($tot_rq),0);?></div></td>
	  <td><div align="right"><?=number_format(($tot_dq),0);?></div></div></td>
	  <td><div align="right"><?=number_format(($total),2);?></div></td>
	</tr>
</tbody></table>
<?
}





elseif($_POST['report']==36){

if($_POST['by']>0)
	
		$by_con .= 'and a.entry_by="'.$_POST['by'].'"';
		
		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;}
		if(isset($cat_id)) 		{$cat_con=' and d.id='.$cat_id;}
		if(isset($item_id)) 	{$item_con=' and b.item_id='.$item_id;}
		
		if($_POST['sub_group_id']>0)
		
		$item_con .= 'and d.sub_group_id="'.$_POST['sub_group_id'].'"';

		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';}
		
if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.po_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		   $sqll=' select a.po_no as po_no, a.po_date,(select po_type from purchase_type where id=a.purchase_type) as purchase_type, c.vendor_name as vendor_name,w.warehouse_name, a.vat as vat_percent,a.vat_include as vat_type,a.tax,a.tax_include  as tax_type,a.rebateable,a.rebate_percentage,a.deductible as vds_payable ,a.status, b.id as order_id,d.sub_group_name, e.item_name, b.qty,b.rate,b.with_vat_rate as calculated_rate,b.with_vat_amt as calculated_amount, f.fname as entry_by, a.entry_at
		   from purchase_master a LEFT JOIN purchase_invoice b ON a.po_no=b.po_no 
		   LEFT JOIN vendor c ON c.vendor_id=a.vendor_id 
		   LEFT JOIN warehouse w ON a.warehouse_id=w.warehouse_id
		   LEFT JOIN item_info e ON b.item_id=e.item_id 
		   LEFT JOIN item_sub_group d ON d.sub_group_id=e.sub_group_id 
		   LEFT JOIN user_activity_management f ON f.user_id=a.entry_by 
		   where a.status!="MANUAL" '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$item_sub_con.$status_con.'  order by a.po_no,b.id';	
		   
		   	$sqlll=' select a.po_no as po_no, a.po_date,(select po_type from purchase_type where id=a.purchase_type) as purchase_type, c.vendor_name as vendor_name,w.warehouse_name, a.vat as vat_percent,a.vat_include as vat_type,a.tax,a.tax_include  as tax_type,a.rebateable,a.rebate_percentage,a.deductible as vds_payable ,a.status, b.id as order_id,d.sub_group_name, e.item_name, b.qty,b.rate,b.with_vat_rate as calculated_rate,b.with_vat_amt as calculated_amount, f.fname as entry_by, a.entry_at
		   from purchase_master a LEFT JOIN purchase_invoice b ON a.po_no=b.po_no 
		   LEFT JOIN vendor c ON c.vendor_id=a.vendor_id 
		   LEFT JOIN warehouse w ON a.warehouse_id=w.warehouse_id
		   LEFT JOIN item_info e ON b.item_id=e.item_id 
		   LEFT JOIN item_sub_group d ON d.sub_group_id=e.sub_group_id 
		   LEFT JOIN user_activity_management f ON f.user_id=a.entry_by 
		   where a.status!="MANUAL" '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$item_sub_con.$status_con.'  order by a.po_no,b.id';	
		    
		   $total_count = 0;
		   $current_po_no = 0;
			$query = db_query($sqlll);
			while ($data = mysqli_fetch_object($query)) {
				$po_no[] = $data->po_no;
				$po_data[$data->po_no]['details'][] = $data; // Group data by PO No
				$po_data[$data->po_no]['count'] = isset($po_data[$data->po_no]['count']) ? $po_data[$data->po_no]['count'] + 1 : 1;
				$total_count++;
			}
				


?>
<style>
body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}
</style>

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <thead>
  <tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>
    <tr>
      <!-- <th>S/L</th> -->
      <th>PO No</th>
      <!-- <th>PO Date</th> -->
      <th>Purchase Type</th>
      <th>Vendor Name</th>
      <th>Warehouse Name</th>
      <th>VAT Percent</th>
      <th>VAT Type</th>
      <th>Tax</th>
      <th>Tax Type</th>
      <th>Rebateable</th>
      <th>Rebate Percentage</th>
      <th>VDS Payable</th>
      <th>Status</th>
      <th>Order ID</th>
      <th>Sub Group Name</th>
      <th>Item Name</th>
      <th>Quantity</th>
      <th>Rate</th>
      <th>Calculated Rate</th>
      <th>Calculated Amount</th>
      <th>Entry By</th>
      <th>Entry At</th>
    </tr>
  </thead>
  <tbody>
<?php
$j = 1;
foreach ($po_data as $po_no => $data_group) {
    $rowspan = $data_group['count'];
    $first_row = true;

    // pick background color based on $j (odd = gray, even = light green)
    $bg_color = ($j % 2 != 1) ? "#f0f0f0" : "#d9fdd3";

    foreach ($data_group['details'] as $data) {
        echo "<tr style='background-color: {$bg_color};'>";
        if ($first_row) {
            
            echo "<td rowspan='$rowspan'>{$data->po_no}</td>";
            
            echo "<td rowspan='$rowspan'>{$data->purchase_type}</td>";
            echo "<td rowspan='$rowspan'>{$data->vendor_name}</td>";
            echo "<td rowspan='$rowspan'>{$data->warehouse_name}</td>";
            echo "<td rowspan='$rowspan'>{$data->vat_percent}</td>";
            echo "<td rowspan='$rowspan'>{$data->vat_type}</td>";
            echo "<td rowspan='$rowspan'>{$data->tax}</td>";
            echo "<td rowspan='$rowspan'>{$data->tax_type}</td>";
            echo "<td rowspan='$rowspan'>{$data->rebateable}</td>";
            echo "<td rowspan='$rowspan'>{$data->rebate_percentage}</td>";
            echo "<td rowspan='$rowspan'>{$data->vds_payable}</td>";
            echo "<td rowspan='$rowspan'>{$data->status}</td>";
            $first_row = false;
        }
        echo "<td>{$data->order_id}</td>";
        echo "<td>{$data->sub_group_name}</td>";
        echo "<td>{$data->item_name}</td>";
        echo "<td>{$data->qty}</td>";
        echo "<td>{$data->rate}</td>";
        echo "<td>{$data->calculated_rate}</td>";
        echo "<td>{$data->calculated_amount}</td>";
        echo "<td>{$data->entry_by}</td>";
        echo "<td>{$data->entry_at}</td>";
        echo "</tr>";
		$tot_qty = $tot_qty+$data->qty;
		$tot_calculated_amount = $tot_calculated_amount+$data->calculated_amount;
    }
    $j++;
	
}




?>
 
	<tr>
		<td colspan="16"><div align="right">&nbsp;</div></td>		
		<td><div align="right"><strong>Total:</strong></div></td>	
		<td><div align="right"><?=number_format(($tot_qty),4);?></div></td>	
		<td><div align="right">&nbsp;</div></td>	
		<td><div align="right">&nbsp;</div></td>	
		<td><div align="right"><?=number_format(($tot_calculated_amount),4);?></div></td>	
		<td><div align="right">&nbsp;</div></td>	
		<td><div align="right">&nbsp;</div></td>		
	
	</tr>
	
  </tbody>
</table>

<?
}




elseif($_POST['report']==37){


$report="Vendor Report";
		
		
		

		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';}
		
if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.po_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		   $sql=' SELECT v.vendor_id,v.ledger_id,v.sub_ledger_id,v.vendor_name,c.category_name,v.vendor_company,v.beneficiary_name,v.beneficiary_bank,v.beneficiary_bank_ac,v.swift_code,v.address,v.contact_no,v.sms_mobile_no,v.fax_no,v.email,v.cc_email,v.country,v.contact_person_name,v.contact_person_designation,v.contact_person_mobile,v.status FROM vendor v,vendor_category c WHERE c.id=v.vendor_category order by v.vendor_id ';



?>


<style> 
body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}
</style>

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <thead>
   <tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>


</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>
	

    <tr>
		<th>S/L</th>
		<th>Vendor Id</th>
		<th>Ledger Id</th>
		<th>Sub Ledger Id</th>
		<th>Vendor Name</th>
		<th>Category Name</th>
		<th>Vendor Company</th>
		<th>Beneficiary Name</th>
		<th>Beneficiary Bank</th>
		<th>Beneficiary Bank Ac</th>
		<th>Swift Code</th>
		<th>Address</th>
		<th>Contact No</th>
		<th>Sms Mobile No</th>
		<th>Fax No</th>
		<th>Email</th>
		<th>Cc Email</th>
		<th>Country</th>
		<th>Contact Person Name</th>
		<th>Contact Person Designation</th>
		<th>Contact Person Mobile</th>
		<th>Status</th>
    </tr>
  </thead>
  <tbody>
<? 
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){$j++;
?>
    <tr>
		<td><?=$j;?></td>
		<td style="text-align:center"><?=$data->vendor_id;?></td>
		<td style="text-align:center"><?=$data->ledger_id;?></td>
		<td><?=$data->sub_ledger_id;?></td>
		<td><?=$data->vendor_name;?></td>
		<td><?=$data->category_name;?></td>
		<td><?=$data->vendor_company;?></td>
		<td><?=$data->beneficiary_name;?></td>
		<td><?=$data->beneficiary_bank;?></td>
		<td><?=$data->beneficiary_bank_ac;?></td>
		<td><?=$data->swift_code;?></td>
		<td style="text-align:center"><?=$data->address;?></td>
		<td style="text-align:right"><?=$data->contact_no;?></td>
		<td><?=$data->sms_mobile_no;?></td>
		<td><?=$data->fax_no;?></td>
		<td><?=$data->email;?></td>
		<td><?=$data->cc_email;?></td>
		<td><?=$data->country;?></td>
		<td><?=$data->contact_person_name;?></td>
		<td><?=$data->contact_person_designation;?></td>
		<td><?=$data->contact_person_mobile;?></td>
		<td><?=$data->status;?></td>
		
    </tr>
<? } ?>

	<?php /*?><tr>
		<td colspan="11"><div align="right">&nbsp;</div></td>		
		<td><div align="right"><strong>Total:</strong></div></td>	
		<td><div align="right"><?=number_format(($tot_qty),2);?></div></td>	
		<td><div align="right">&nbsp;</div></td>	
		<td><div align="right">&nbsp;</div></td>
		<td><div align="right">&nbsp;</div></td>
		<td><div align="right">&nbsp;</div></td>
		<td><div align="right">&nbsp;</div></td>
			<td><div align="right">&nbsp;</div></td>
		<td><div align="right">&nbsp;</div></td>
		<td><div align="right">&nbsp;</div></td>
		<td><div align="right">&nbsp;</div></td>
	
	
	</tr><?php */?>
	
  </tbody>
</table>

<?

}







elseif($_POST['report']==38){


$report="Purchase Requisition Report";

if($_POST['by']>0) $by_con .= 'and a.entry_by="'.$_POST['by'].'"';
if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;}
if(isset($item_id)) 	{$item_con=' and b.item_id='.$item_id;}
if($_POST['sub_group_id']>0) $item_con .= 'and d.sub_group_id="'.$_POST['sub_group_id'].'"';
if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';}
if(isset($t_date))  {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.req_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

 $sqll=' select a.req_no,a.req_date,a.req_for,a.req_note,a.need_by,w.warehouse_name,a.status, b.item_id,e.item_name,d.sub_group_name,b.id as order_id, b.qty, b.remarks, a.entry_by,a.entry_at,a.checked_by,a.checked_at from requisition_master a LEFT JOIN requisition_order b ON a.req_no=b.req_no LEFT JOIN warehouse w ON a.warehouse_id=w.warehouse_id LEFT JOIN item_info e ON b.item_id=e.item_id LEFT JOIN item_sub_group d ON d.sub_group_id=e.sub_group_id where a.status!="MANUAL" '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$item_sub_con.$status_con.'  order by a.req_no,b.id';



?>


<style>
body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}
</style>

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <thead>
   <tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>
	

    <tr>
		<th>S/L</th>
		<th>Requisition No</th>
		<th>Requisition Date</th>
		<th>Requisition By</th>
		<th>Requisition Note</th>
		<th>Delivery Deadline</th>
		<th>Warehouse</th>
		<th>Status</th>
		<th>Item ID</th>
		<th>Item Name</th>
		<th>Sub Group Name</th>
		<th>Order ID</th>
		<th>Quantity</th>
		<th>Remarks</th>
		<th>Entry By</th>
		<th>Entry At</th>
		<th>Checked By</th>
		<th>Checked At</th>
    </tr>
  </thead>
  <tbody>
<? 
$query = db_query($sqll);
while($data=mysqli_fetch_object($query)){$j++;
?>
    <tr>
		<td><?=$j;?></td>
		<td style="text-align:center"><?=$data->req_no;?></td>
		<td style="text-align:center"><?=$data->req_date;?></td>
		<td><?=$data->req_for;?></td>
		<td><?=$data->req_note;?></td>
		<td><?=$data->need_by;?></td>
		<td><?=$data->warehouse_name;?></td>
		<td><?=$data->status;?></td>
		<td><?=$data->item_id;?></td>
		<td><?=$data->item_name;?></td>
		<td><?=$data->sub_group_name;?></td>
		<td style="text-align:center"><?=$data->order_id;?></td>
		<td style="text-align:right"><?=$data->qty; $tot_qty += $data->qty;?></td>
		<td><?=$data->remarks;?></td>
		<td><?=find_a_field('user_activity_management','fname','user_id="'.$data->entry_by.'"');?></td>
		<td><?=$data->entry_at;?></td>
		<td><?=find_a_field('user_activity_management','fname','user_id="'.$data->checked_by.'"');?></td>
		<td><?=$data->checked_at;?></td>
    </tr>
<? } ?>

	<tr>
		<td colspan="11"><div align="right">&nbsp;</div></td>		
		<td><div align="right"><strong>Total:</strong></div></td>	
		<td><div align="right"><?=number_format(($tot_qty),2);?></div></td>	
		<td><div align="right">&nbsp;</div></td>	
		<td><div align="right">&nbsp;</div></td>
		<td><div align="right">&nbsp;</div></td>
		<td><div align="right">&nbsp;</div></td>
		<td><div align="right">&nbsp;</div></td>
	
	
	</tr>
	
  </tbody>
</table>

<?

}




elseif($_POST['report']==39){

	


$report="Purchase Receive Report";
		if($_POST['by']>0)
	
		$by_con .= 'and a.entry_by="'.$_POST['by'].'"';
		
		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;}
		if(isset($cat_id)) 		{$cat_con=' and d.id='.$cat_id;}
		if(isset($item_id)) 	{$item_con=' and a.item_id='.$item_id;}
		
		if($_POST['sub_group_id']>0)
		
		$item_con .= 'and d.sub_group_id="'.$_POST['sub_group_id'].'"';

		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';}
		
if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.rec_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		 $sqll='select a.pr_no,a.rec_date,v.vendor_name,a.po_no,w.warehouse_name,a.order_no,d.sub_group_name,a.item_id,e.item_name,a.qty,a.with_vat_rate,a.with_vat_amt,a.vat_amt,a.tax_amt,a.transport_charge,a.other_charge,a.qc_by,a.ch_no,a.remarks, a.status,a.entry_by,a.entry_at from purchase_receive a LEFT JOIN warehouse w ON a.warehouse_id=w.warehouse_id LEFT JOIN vendor v ON a.vendor_id=v.vendor_id LEFT JOIN item_info e ON a.item_id=e.item_id LEFT JOIN item_sub_group d ON d.sub_group_id=e.sub_group_id where a.status="RECEIVED"  '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$item_sub_con.$status_con.'  order by a.pr_no';



?>
<style>
body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}
</style>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <thead>
   <tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>
	

    <tr>
		<th style="text-align:center">S/L</th>
		<th style="text-align:center">PR No</th>
		<th>Receive Date</th>
		<th>Vendor Name</th>
		<th>PO No</th>
		<th>Warehouse Name</th>
		<th>Order No</th>
		<th>Sub Group Name</th>
		<th>Item ID</th>
		<th>Item Name</th>
		<th>Quantity</th>
		<th>Calculated Rate</th>
		<th>Calculated Amount</th>
		<th>VAT Amount</th>
		<th>Tax Amount</th>
		<th>Transport Charge</th>
		<th>Other Charge</th>
		<th>QC By</th>
		<th>Challan No</th>
		<th>Remarks</th>
		<th>Status</th>
		<th>Entry By</th>
		<th>Entry At</th>

    </tr>
  </thead>
  <tbody>
<? 
$query = db_query($sqll);
while($data=mysqli_fetch_object($query)){$j++;
?>
    <tr>
		<td style="text-align:center"><?=$j;?></td>
		<td style="text-align:center"><?=$data->pr_no;?></td>
		<td><?=$data->rec_date;?></td>
		<td><?=$data->vendor_name;?></td>
		<td style="text-align:center"><?=$data->po_no;?></td>
		<td><?=$data->warehouse_name;?></td>
		<td style="text-align:center"><?=$data->order_no;?></td>
		<td><?=$data->sub_group_name;?></td>
		<td><?=$data->item_id;?></td>
		<td><?=$data->item_name;?></td>
		<td style="text-align:right"><?=$data->qty; $tot_qty += $data->qty; ?></td>
		<td style="text-align:right"><?=$data->with_vat_rate; ?></td>
		<td style="text-align:right"><?=$data->with_vat_amt; $tot_with_vat_amt += $data->with_vat_amt;?></td>
		<td style="text-align:right"><?=$data->vat_amt; $tot_vat_amt += $data->vat_amt;?></td>
		<td style="text-align:right"><?=$data->tax_amt; $tot_tax_amt += $data->tax_amt;?></td>
		<td style="text-align:right"><?=$data->transport_charge; $transport_charge += $data->transport_charge;?></td>
		<td style="text-align:right"><?=$data->other_charge; $other_charge += $data->other_charge;?></td>
		<td><?=$data->qc_by;?></td>
		<td><?=$data->ch_no;?></td>
		<td><?=$data->remarks;?></td>
		<td><?=$data->status;?></td>
		<td><?=find_a_field('user_activity_management','fname','user_id="'.$data->entry_by.'"');?></td>
		<td><?=$data->entry_at;?></td>

    </tr>
<? } ?>

	<tr>
		<td colspan="9"><div align="right">&nbsp;</div></td>		
		<td><div align="right"><strong>Total:</strong></div></td>	
		<td><div align="right"><?=number_format(($tot_qty),4);?></div></td>	
		<td><div align="right">&nbsp;</div></td>	
		<td><div align="right"><?=number_format(($tot_with_vat_amt),4);?></div></td>
		<td><div align="right"><?=number_format(($tot_vat_amt),4);?></div></td>
		<td><div align="right"><?=number_format(($tot_tax_amt),4);?></div></td>
		<td><div align="right"><?=number_format(($transport_charge),4);?></div></td>
		<td><div align="right"><?=number_format(($other_charge),4);?></div></td>
		<td><div align="right">&nbsp;</div></td>
		<td><div align="right">&nbsp;</div></td>
		<td><div align="right">&nbsp;</div></td>
		<td><div align="right">&nbsp;</div></td>
		<td><div align="right">&nbsp;</div></td>
		<td><div align="right">&nbsp;</div></td>
	
	
	</tr>
	
  </tbody>
</table>

<?


}


elseif($_POST['report']==40){ 


$report="Purchase Receive Pending";
		if($_POST['by']>0)
	
		$by_con .= 'and a.entry_by="'.$_POST['by'].'"';
		
		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;}
		if(isset($item_id)) 	{$item_con=' and b.item_id='.$item_id;}
		
		if($_POST['sub_group_id']>0)
		
		$item_con .= 'and d.sub_group_id="'.$_POST['sub_group_id'].'"';

		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';}
		
if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.po_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		$sqll='select a.po_no as po_no, a.po_date, w.warehouse_name, b.id as order_id,b.item_id, e.item_name, b.qty from purchase_master a LEFT JOIN purchase_invoice b ON a.po_no=b.po_no LEFT JOIN vendor c ON c.vendor_id=a.vendor_id LEFT JOIN warehouse w ON a.warehouse_id=w.warehouse_id LEFT JOIN item_info e ON b.item_id=e.item_id LEFT JOIN item_sub_group d ON d.sub_group_id=e.sub_group_id LEFT JOIN user_activity_management f ON f.user_id=a.entry_by where a.status IN("CHECKED","COMPLETED") '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$item_sub_con.$status_con.'  order by a.po_no,b.id';
		
	
	$rec_sql='SELECT sum(qty) as total_qty,order_no FROM purchase_receive GROUP BY order_no';
	$rec_query = db_query($rec_sql);
	while($data=mysqli_fetch_object($rec_query)){
		$rec_qty[$data->order_no] = $data->total_qty;
	}
		



?>


<style>
body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}
</style>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <thead>
    <tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>
	

    <tr>
		<th style="text-align:center">S/L</th>
		<th style="text-align:center">PO No</th>
		<th style="text-align:center">PO Date</th>
		<th style="text-align:center">Warehouse Name</th>
		<th style="text-align:center">Order ID</th>
		<th style="text-align:center">Item Id</th>
		<th style="text-align:center">Item Name</th>
		<th style="text-align:center">Order Quantity</th>
		<th style="text-align:center">Receive Quantity</th>
		<th style="text-align:center">Pending Quantity</th>

    </tr>
  </thead>
  <tbody>
<? 
$query = db_query($sqll);
while($data=mysqli_fetch_object($query)){$j++;
?>
    <tr>
		<td style="text-align:center"><?=$j;?></td>
		<td style="text-align:center"><?=$data->po_no;?></td>
		<td><?=$data->po_date;?></td>
		<td><?=$data->warehouse_name;?></td>
		<td style="text-align:center"><?=$data->order_id;?></td>
		<td style="text-align:center"><?=$data->item_id;?></td>
		<td><?=$data->item_name;?></td>
		<td><div align="right"><?=$data->qty; $tot_qty += $data->qty;?></div></td>
		<td><div align="right"><?=$grn_qty = $rec_qty[$data->order_id]; $tot_grn_qty += $grn_qty;?></div></td>
		<td><div align="right"><?=number_format($pending_qty = $data->qty-$rec_qty[$data->order_id],4); $tot_pending_qty += $pending_qty;?></div></td>


    </tr>
<? } ?>

	<tr>
		<td colspan="6"><div align="right">&nbsp;</div></td>		
		<td><div align="right"><strong>Total:</strong></div></td>	
		<td><div align="right"><?=number_format(($tot_qty),4);?></div></td>	
		<td><div align="right"><?=number_format(($tot_grn_qty),4);?></div></td>	
		<td><div align="right"><?=number_format(($tot_pending_qty),4);?></div></td>	
		
	
	
	</tr>
	
  </tbody>
</table>

<?
}










elseif($_POST['report']==43)
{

 $sdate = strtotime($_REQUEST['f_date']);
 $edate = strtotime($_REQUEST['t_date']);

 $s_date =date("Y-m-01",$sdate);
 $m_date = $new_date = date("Y-m-15",$sdate);
 $e_date =date("Y-m-t",$edate);

$start_date = strtotime(date("Y-m-01 00:00:00",strtotime($s_date)));
$end_date = strtotime(date("Y-m-t 23:59:59",strtotime($e_date)));
for($c=1;$c<40;$c++)
{

	if($new_date>$e_date)  {$c=$c-1;break;}
	else
	{
	$st_date[$c] = date("Y-m-01",(strtotime($new_date)));
	$en_date[$c] = date("Y-m-t",(strtotime($new_date)));
  $priod[$c] = date("Ym",(strtotime($new_date)));
	$period_name[$c] = date("M, Y",(strtotime($new_date)));
	}
$new_date = date("Y-m-d",(strtotime($new_date)+2592000));
} 



?>




<style>
body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}
</style>

<table width="100%" border="0" id="ExportTable" cellpadding="2" cellspacing="0">


<thead>

    <tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>


<tbody>


<tr>


<th rowspan="2" style="text-align:center">S/L</th>
<th rowspan="2" ><div align="center">Item Code</div></th>
<th rowspan="2"><div align="center">Item Name</div></th>
<th rowspan="2"><div align="center">Item Group</div></th>
<th rowspan="2"><div align="center">Item Sub Group</div></th>
<th rowspan="2"><div align="center">Unit</div></th>
<th  colspan="<?=$c;?>"><div align="center">Rate</div></th>
<th rowspan="2"><div align="center">Lowest Rate</div></th>
<th rowspan="2"><div align="center">Highest Rate</div></th>


</tr>

<tr>
<? for($p=1;$p<=$c;$p++){?><td><?=$period_name[$p]?></td><? } ?>
</tr>
<? 


if($_POST['f_date']!=''&&$_POST['t_date']!='')


$con .= 'and a.ji_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';


if($_POST['item_id']!=''){$item_con = ' and i.item_id='.$_POST['item_id'];};


if($_POST['group_id']!=''){$group_con = ' and g.group_id='.$_POST['group_id'];};

if(isset($item_group)) 			    	{$item_group_con=' and s.group_id='.$item_group;}

if($_POST['sub_group_id']!=''){$item_sub_con = ' and s.sub_group_id='.$_POST['sub_group_id'];};


$sl=0;


  $arr_sql="SELECT concat(date_format(ji_date,'%Y%m')) month ,sum(item_price*item_in)/sum(item_in) as rate ,item_id FROM `journal_item` WHERE   `tr_from` IN ('Purchase') group by concat(date_format(ji_date,'%Y%m')),item_id";


$arr_query = db_query($arr_sql);

while($arr_data=mysqli_fetch_object($arr_query)){

	$rate[$arr_data->item_id][$arr_data->month]=$arr_data->rate;
}
   $low_sql="SELECT MIN(item_price) rate,item_id FROM `journal_item` WHERE   `tr_from` IN ('Purchase') and ji_date between '".$_POST['f_date']."' and '".$_POST['t_date']."' group by item_id";


$low_query = db_query($low_sql);

while($low_data=mysqli_fetch_object($low_query)){

	$low_rate[$low_data->item_id]=$low_data->rate;
}
  $max_sql="SELECT MAX(item_price) rate,item_id FROM `journal_item` WHERE   `tr_from` IN ('Purchase') and ji_date between '".$_POST['f_date']."' and '".$_POST['t_date']."' group by item_id";


$max_query = db_query($max_sql);

while($max_data=mysqli_fetch_object($max_query)){

	$max_rate[$max_data->item_id]=$max_data->rate;
}



  $res='select i.item_id,i.item_name, i.finish_goods_code as fg_code,i.unit_name,i.pack_unit,s.sub_group_name,g.group_name,i.item_description,i.status,i.entry_at


from item_info i, item_sub_group s, item_group g 


where   s.sub_group_id=i.sub_group_id and s.group_id=g.group_id '.$group_con.$item_con.$item_sub_con.$item_group_con.'  order by i.item_name asc';


$query = db_query($res);


while($data=mysqli_fetch_object($query)){


?>


<tr>


<td style="text-align:center;"><?=++$sl;?></td>
<td style="text-align:center"><?=$data->item_id?></td>
<td><?=$data->item_name?></td>
<td style="text-align:center;"><?=$data->sub_group_name?></td>
<td style="text-align:center;"><?=$data->group_name?></td>



<td style="text-align:center;"><?=$data->unit_name?></td>

<? for($p=1;$p<=$c;$p++){?>
<td style="text-align:center; color: <?  if($p !=1 && $rate[$data->item_id][$priod[$p]] > $rate[$data->item_id][$priod[$p-1]]) echo "red"; else "green";  ?>">


<?=number_format($rate[$data->item_id][$priod[$p]],2)?></td>


<? } ?>
<td style="text-align:center;"><?=number_format($low_rate[$data->item_id],2)?></td>
<td style="text-align:center;"><?=number_format($max_rate[$data->item_id],2)?></td>

</tr>


<? }?>

</tbody>
</table>

<br><br><br><br><br><br>
<?

}

elseif($_POST['report']==46)
{

// Get Start and End Dates from Request
$sdate = strtotime($_REQUEST['f_date']);
$edate = strtotime($_REQUEST['t_date']);

// Define Start, Middle, and End Dates
$s_date = date("Y-m-01", $sdate);
$m_date = date("Y-m-15", $sdate);
$e_date = date("Y-m-t", $edate);

// Convert to Timestamp
$start_date = strtotime(date("Y-m-01 00:00:00", strtotime($s_date)));
$end_date = strtotime(date("Y-m-t 23:59:59", strtotime($e_date)));

// Generate Monthly Periods
$new_date = $m_date;
for ($c = 1; $c < 13; $c++) {
    if ($new_date > $e_date) {
        $c--;
        break;
    }

    $st_date[$c] = date("Y-m-01", strtotime($new_date));
    $en_date[$c] = date("Y-m-t", strtotime($new_date));
    $priod[$c] = date("Ym", strtotime($new_date));
    $period_name[$c] = date("M, Y", strtotime($new_date));
    
    $new_date = date("Y-m-d", strtotime($new_date) + 2592000); // Add one month
}

// Apply Filters
$by_con = isset($_POST['by']) ? ' and pm.entry_by="' . $_POST['by'] . '" ' : '';
$group_con = isset($_POST['group_id']) ? ' and g.group_id="' . $_POST['group_id'] . '" ' : '';
$warehouse_con = isset($warehouse_id) ? ' and a.relevant_warehouse=' . $warehouse_id : '';
$item_con = isset($item_id) ? ' and a.item_id=' . $item_id : '';
$item_sub_con = isset($sub_group_id) ? ' and i.sub_group_id=' . $sub_group_id : '';
$item_group_con = isset($group_id) ? ' and s.group_id=' . $group_id : '';
$vendor_con = isset($vendor_id) ? ' and v.vendor_id=' . $vendor_id : '';
$status_con = ' and a.tr_from = "Purchase" ';
$date_con = isset($t_date) ? ' and a.ji_date between "' . $f_date . '" and "' . $t_date . '"' : '';

// Fetch Monthly Data
$sql = 'SELECT v.vendor_name, v.vendor_id, SUM(a.item_in*a.item_price) AS amount, 
        CONCAT(DATE_FORMAT(a.ji_date, "%Y%m")) AS month 
        FROM journal_item a
        JOIN item_info i ON a.item_id = i.item_id
        JOIN user_activity_management c ON c.user_id = a.entry_by
        JOIN item_sub_group s ON s.sub_group_id = i.sub_group_id
        JOIN item_group g ON s.group_id = g.group_id
        JOIN purchase_receive pr ON a.tr_no = pr.id
        JOIN purchase_master pm ON pr.po_no = pm.po_no
        JOIN vendor v ON pm.vendor_id = v.vendor_id
        WHERE 1=1 and a.ji_date between "'.$f_date.'" and "'.$t_date.'" '.$vendor_con.'
        GROUP BY month, v.vendor_id';

$query = db_query($sql);
while ($data = mysqli_fetch_object($query)) {
    $amount[$data->vendor_id][$data->month] = $data->amount;
}

// Fetch Total Data
$sql_total = 'SELECT v.vendor_name, v.vendor_id, SUM(a.item_in*a.item_price) AS amount
        FROM journal_item a
        JOIN item_info i ON a.item_id = i.item_id
        JOIN user_activity_management c ON c.user_id = a.entry_by
        JOIN item_sub_group s ON s.sub_group_id = i.sub_group_id
        JOIN item_group g ON s.group_id = g.group_id
        JOIN purchase_receive pr ON a.tr_no = pr.id
        JOIN purchase_master pm ON pr.po_no = pm.po_no
        JOIN vendor v ON pm.vendor_id = v.vendor_id
        WHERE 1=1 and a.ji_date between "' . $f_date . '" and "' . $t_date . '" '.$vendor_con.'
        GROUP BY v.vendor_id';

$query_total = db_query($sql_total);
?>

<style>
body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}
</style>




<table width="100%" border="1" cellpadding="2" cellspacing="0">
    <tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>


    <tr>
        <th rowspan="2" style="text-align:center">S/L</th>
        <th rowspan="2" style="text-align:center">Vendor Name</th>
        <th colspan="<?= $c; ?>" style="text-align:center;">Monthly History</th>
        <th rowspan="2" style="text-align:center">Total</th>
    </tr>
    <tr>
        <?php for ($p = 1; $p <= $c; $p++) { ?>
            <th style="text-align:center"><?= $period_name[$p]; ?></th>
        <?php } ?>
    </tr>
    
    <?php $sl = 0; $g_total = 0; while ($data = mysqli_fetch_object($query_total)) { $sl++; ?>
    <tr>
        <td style="text-align:center"><?= $sl; ?></td>
        <td><?= $data->vendor_name; ?></td>
        <?php $y_total = 0; for ($p = 1; $p <= $c; $p++) { 
            $p_total[$p] = $amount[$data->vendor_id][$priod[$p]] ?? 0;
            echo '<td style="text-align:center">' . number_format($p_total[$p], 2) . '</td>';
            $y_total += $p_total[$p];
            $x_total[$p] = $p_total[$p];
        } ?>
        <td style="text-align:center"><?= number_format($y_total, 2); ?></td>
    </tr>
    <?php 
        $g_total += $y_total;
        for ($p = 1; $p <= $c; $p++) {
            $g_x_total[$p] += $x_total[$p];
        }
    } ?>
    
    <tr>
        <td></td>
        <td style="text-align:right"><strong>Total</strong></td>
        <?php for ($p = 1; $p <= $c; $p++) { ?>
            <td style="text-align:center"><?= number_format($g_x_total[$p], 2); ?></td>
        <?php } ?>
        <td style="text-align:center"><?= number_format($g_total, 2); ?></td>
    </tr>
</table>





<?




}



elseif($_POST['report']==45)
{

// Get Start and End Dates from Request
$sdate = strtotime($_REQUEST['f_date']);
$edate = strtotime($_REQUEST['t_date']);

// Define Start, Middle, and End Dates
$s_date = date("Y-m-01", $sdate);
$m_date = date("Y-m-15", $sdate);
$e_date = date("Y-m-t", $edate);

// Convert to Timestamp
$start_date = strtotime(date("Y-m-01 00:00:00", strtotime($s_date)));
$end_date = strtotime(date("Y-m-t 23:59:59", strtotime($e_date)));

// Generate Monthly Periods
$new_date = $m_date;
for ($c = 1; $c < 13; $c++) {
    if ($new_date > $e_date) {
        $c--;
        break;
    }

    $st_date[$c] = date("Y-m-01", strtotime($new_date));
    $en_date[$c] = date("Y-m-t", strtotime($new_date));
    $priod[$c] = date("Ym", strtotime($new_date));
    $period_name[$c] = date("M, Y", strtotime($new_date));
    
    $new_date = date("Y-m-d", strtotime($new_date) + 2592000); // Add one month
}

// Apply Filters
$by_con = isset($_POST['by']) ? ' and pm.entry_by="' . $_POST['by'] . '" ' : '';
$group_con = isset($_POST['group_id']) ? ' and g.group_id="' . $_POST['group_id'] . '" ' : '';
$warehouse_con = isset($warehouse_id) ? ' and a.relevant_warehouse=' . $warehouse_id : '';
$item_con = isset($item_id) ? ' and a.item_id=' . $item_id : '';
$item_sub_con = isset($sub_group_id) ? ' and i.sub_group_id=' . $sub_group_id : '';
$item_group_con = isset($group_id) ? ' and s.group_id=' . $group_id : '';
$vendor_con = isset($vendor_id) ? ' and v.vendor_id=' . $vendor_id : '';
$status_con = ' and a.tr_from = "Purchase" ';
$date_con = isset($t_date) ? ' and a.ji_date between "' . $f_date . '" and "' . $t_date . '"' : '';

// Fetch Monthly Data
$sql = 'SELECT v.vendor_name, v.vendor_id, SUM(a.item_in) AS amount, 
        CONCAT(DATE_FORMAT(a.ji_date, "%Y%m")) AS month 
        FROM journal_item a
        JOIN item_info i ON a.item_id = i.item_id
        JOIN user_activity_management c ON c.user_id = a.entry_by
        JOIN item_sub_group s ON s.sub_group_id = i.sub_group_id
        JOIN item_group g ON s.group_id = g.group_id
        JOIN purchase_receive pr ON a.tr_no = pr.id
        JOIN purchase_master pm ON pr.po_no = pm.po_no
        JOIN vendor v ON pm.vendor_id = v.vendor_id
        WHERE 1=1 and a.ji_date between "'.$f_date.'" and "'.$t_date.'" '.$vendor_con.'
        GROUP BY month, v.vendor_id';

$query = db_query($sql);
while ($data = mysqli_fetch_object($query)) {
    $amount[$data->vendor_id][$data->month] = $data->amount;
}

// Fetch Total Data
$sql_total = 'SELECT v.vendor_name, v.vendor_id, SUM(a.item_in + a.item_ex) AS amount
        FROM journal_item a
        JOIN item_info i ON a.item_id = i.item_id
        JOIN user_activity_management c ON c.user_id = a.entry_by
        JOIN item_sub_group s ON s.sub_group_id = i.sub_group_id
        JOIN item_group g ON s.group_id = g.group_id
        JOIN purchase_receive pr ON a.tr_no = pr.id
        JOIN purchase_master pm ON pr.po_no = pm.po_no
        JOIN vendor v ON pm.vendor_id = v.vendor_id
        WHERE 1=1 and a.ji_date between "' . $f_date . '" and "' . $t_date . '"  '.$vendor_con.'
        GROUP BY v.vendor_id';

$query_total = db_query($sql_total);
?>

<style>
body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}
</style>




<table width="100%" border="1" cellpadding="2" cellspacing="0">

    <tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>

    <tr>
        <th rowspan="2" style="text-align:center">S/L</th>
        <th rowspan="2" style="text-align:center">Vendor Name</th>
        <th colspan="<?= $c; ?>" style="text-align:center;">Monthly History</th>
        <th rowspan="2" style="text-align:center">Total</th>
    </tr>
    <tr>
        <?php for ($p = 1; $p <= $c; $p++) { ?>
            <th style="text-align:center"><?= $period_name[$p]; ?></th>
        <?php } ?>
    </tr>
    
    <?php $sl = 0; $g_total = 0; while ($data = mysqli_fetch_object($query_total)) { $sl++; ?>
    <tr>
        <td style="text-align:center"><?= $sl; ?></td>
        <td ><?= $data->vendor_name; ?></td>
        <?php $y_total = 0; for ($p = 1; $p <= $c; $p++) { 
            $p_total[$p] = $amount[$data->vendor_id][$priod[$p]] ?? 0;
            echo '<td style="text-align: center;">' . number_format($p_total[$p], 2) . '</td>';
            $y_total += $p_total[$p];
            $x_total[$p] = $p_total[$p];
        } ?>
        <td style="text-align:center"><?= number_format($y_total, 2); ?></td>
    </tr>
    <?php 
        $g_total += $y_total;
        for ($p = 1; $p <= $c; $p++) {
            $g_x_total[$p] += $x_total[$p];
        }
    } ?>
    
    <tr>
        <td></td>
        <td style="text-align:right"><strong>Total</strong></td>
        <?php for ($p = 1; $p <= $c; $p++) { ?>
            <td style="text-align:center"><?= number_format($g_x_total[$p], 2); ?></td>
        <?php } ?>
        <td style="text-align:center"><?= number_format($g_total, 2); ?></td>
    </tr>
</table>





<?

}



elseif($_POST['report']==44)
{



if($_POST['f_date']!=''&&$_POST['t_date']!='')


$con .= 'and a.ji_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';


if($_POST['item_id']!=''){$item_con = ' and t1.item_id='.$_POST['item_id'];};


if($_POST['group_id']!=''){$group_con = ' and g.group_id='.$_POST['group_id'];};

if(isset($item_group)) 			    	{$item_group_con=' and s.group_id='.$item_group;}

if($_POST['sub_group_id']!=''){$item_sub_con = ' and s.sub_group_id='.$_POST['sub_group_id'];};

 $sqll='WITH ranked_data AS ( SELECT item_id, id, item_price, tr_from, ROW_NUMBER() OVER (PARTITION BY item_id ORDER BY id DESC) AS row_num FROM journal_item WHERE tr_from IN ("Purchase") ) SELECT t1.item_id, t1.id AS last_id, t2.id AS last_id_before, t1.item_price AS last_item_price, t2.item_price AS last_item_price_before FROM ranked_data t1 JOIN ranked_data t2 ON t1.item_id = t2.item_id AND t1.row_num = 1 AND t2.row_num = 2 '.$group_con.$item_con.$item_sub_con.$item_group_con.' ORDER BY t1.item_id;
';	   
$query =db_query($sqll);
?>
<style>
body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}
</style>



<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <thead>
        <tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>
    <tr>
		<th>S/L</th>
		<th>Item ID</th>
		<th>Item Name</th>
		<th>Last Puchase Price</th>
		<th>Previous Puchase Item Price</th>
    </tr>
  </thead>
  <tbody>
<? while($data=mysqli_fetch_object($query)){$j++;

?>
    <tr>
		<td><?=$j?></td>
		<td><?=$data->item_id;?></td>
		<td><?=find_a_field('item_info','item_name','item_id="'.$data->item_id.'"');?></td>
		<td><?=number_format($data->last_item_price,2);?></td>
		<td><?=number_format($data->last_item_price_before,2);?></td>


    </tr>
<? } ?>

  </tbody>
 
</table>

<?


}






elseif($_POST['report']==42)
{

if(isset($item_id)) 	{$item_con = ' and j.item_id='.$item_id;}	
if($_POST['sub_group_id']>0) $item_sub_con = 'and s.sub_group_id="'.$_POST['sub_group_id'].'"';	
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and j.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

$sqll='SELECT s.sub_group_name,j.item_id,i.item_name,sum(j.item_in) as total_qty, sum(j.item_in*j.item_price) as total_amt FROM journal_item j LEFT JOIN item_info i ON j.item_id = i.item_id LEFT JOIN item_sub_group s ON i.sub_group_id = s.sub_group_id WHERE 1 '.$date_con.$item_con.$item_sub_con.' and j.tr_from LIKE "Purchase" GROUP BY j.item_id';	   
$query =db_query($sqll);
?>


<style>
body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}
</style>

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <thead>
       <tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>
    <tr>
		<th style="text-align:center">S/L</th>
		<th style="text-align:center">Sub Group Name</th>
		<th style="text-align:center">Item ID</th>
		<th style="text-align:center">Item Name</th>
		<th style="text-align:center">Total Quantity</th>
		<th style="text-align:center">Total Amount</th>

    </tr>
  </thead>
  <tbody>
<? while($data=mysqli_fetch_object($query)){$j++;

?>
    <tr>
		<td style="text-align:center"><?=$j?></td>
		<td><?=$data->sub_group_name;?></td>
		<td style="text-align:center"><?=$data->item_id;?></td>
		<td><?=$data->item_name;?></td>
		<td align="right"><?=number_format($data->total_qty,4); $tot_qty += $data->total_qty;?></td>
		<td align="right"><?=number_format($data->total_amt,4); $tot_amount += $data->total_amt;?></td>

    </tr>
<? } ?>


<tr>
		<td colspan="3"><div align="right">&nbsp;</div></td>		
		<td><div align="right"><strong>Total:</strong></div></td>	
		<td><div align="right"><?=number_format(($tot_qty),4);?></div></td>	
		<td><div align="right"><?=number_format(($tot_amount),4);?></div></td>		
		
	
	
	</tr>


  </tbody>
 
</table>

<?

}











elseif($_POST['report']==41){ 
{

if($_POST['by']>0) $by_con .= 'and a.entry_by="'.$_POST['by'].'"';
if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;}
if(isset($item_id)) 	{$item_con=' and b.item_id='.$item_id;}
if($_POST['sub_group_id']>0) $item_con .= 'and d.sub_group_id="'.$_POST['sub_group_id'].'"';
if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';}		
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.req_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

$sqll=' select a.req_no,a.req_date,w.warehouse_name, b.item_id,e.item_name,b.id as req_id, b.qty 
from requisition_master a LEFT JOIN requisition_order b ON a.req_no=b.req_no 
LEFT JOIN warehouse w ON a.warehouse_id=w.warehouse_id 
LEFT JOIN item_info e ON b.item_id=e.item_id 
LEFT JOIN item_sub_group d ON d.sub_group_id=e.sub_group_id 
where a.status IN("CHECKED","COMPLETED")  '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$item_sub_con.$status_con.'  order by a.req_no,b.id';	   
$query =db_query($sqll);


$pur_sql='SELECT sum(qty) as total_qty,req_id FROM purchase_invoice GROUP BY req_id';
$pur_query = db_query($pur_sql);
while($data=mysqli_fetch_object($pur_query)){
	$pur_qty[$data->req_id] = $data->total_qty;
}

$rec_sql='select sum(pr.qty) as total_rec_qty, b.id as req_id from requisition_master a LEFT JOIN requisition_order b ON a.req_no=b.req_no LEFT JOIN purchase_invoice pi ON pi.req_id=b.id LEFT JOIN purchase_receive pr ON pi.id=pr.order_no where a.status IN("CHECKED","COMPLETED") GROUP BY b.id';
$rec_query = db_query($rec_sql);
while($data=mysqli_fetch_object($rec_query)){
	$rec_qty[$data->req_id] = $data->total_rec_qty;
}
  

?>

<style>
body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}
</style>

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <thead>
        <tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>
    <tr>
		<th style="text-align:center">S/L</th>
		<th style="text-align:center">Requisition No</th>
		<th style="text-align:center">Requisition Date</th>
		<th style="text-align:center">Warehouse Name</th>
		<th style="text-align:center">Item ID</th>
		<th style="text-align:center">Item Name</th>
		<th style="text-align:center">Requisition ID</th>
		<th style="text-align:center">Requisition Quantity</th>
		<th style="text-align:center">Purchase Quantity</th>
		<th style="text-align:center">Receive Quantity</th>
    </tr>
  </thead>
  <tbody>
<? while($data=mysqli_fetch_object($query)){$j++;

?>
    <tr>
		<td style="text-align:center"><?=$j?></td>
		<td style="text-align:center"><?=$data->req_no;?></td>
		<td style="text-align:center"><?=$data->req_date;?></td>
		<td><?=$data->warehouse_name;?></td>
		<td style="text-align:center"><?=$data->item_id;?></td>
		<td><?=$data->item_name;?></td>
		<td style="text-align:center"><?=$data->req_id;?></td>
		<td style="text-align:right"><?=number_format($data->qty,4); $tot_qty +=$data->qty; ?></td>
		<td style="text-align:right"><?=$pur_qty[$data->req_id]; $tot_po_qty += $pur_qty[$data->req_id];?></td>
		<td style="text-align:right"><?=$rec_qty[$data->req_id]; $tot_pending_qty += $rec_qty[$data->req_id];?></td>
    </tr>
<? } ?>



<tr>
		<td colspan="6"><div align="right">&nbsp;</div></td>		
		<td><div align="right"><strong>Total:</strong></div></td>	
		<td><div align="right"><?=number_format(($tot_qty),4);?></div></td>	
		<td><div align="right"><?=number_format(($tot_po_qty),4);?></div></td>	
		<td><div align="right"><?=number_format(($tot_pending_qty),4);?></div></td>	
		
	
	
	</tr>

  </tbody>
 
</table>

<?
} 
}






elseif($_POST['report']==35) 
{	 
   if($item_id>0){
    $item_con = ' and i.item_id="'.$item_id.'"';
   }
   if(isset($warehouse_id)) {$warehouse_con=' and a.warehouse_id='.$warehouse_id;}
   if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date <="'.$to_date.'"';}


		  $stockSql='select distinct i.item_id,i.unit_name,i.item_name,s.sub_group_name,i.finish_goods_code,i.d_price,i.pack_size
		   from item_info i, item_sub_group s, item_group g
		   where i.group_for="'.$_SESSION['user']['group'].'" and  g.group_id=s.group_id
		   and i.sub_group_id=s.sub_group_id'.$item_sub_con.$item_con.$group_id_con.' order by i.finish_goods_code,s.sub_group_name,i.item_name';
		   
		$query =db_query($stockSql);   
		
		if($_POST['warehouse_id']>0){  
			 $warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id);
		}else{
		$warehouse_name = 'All Warehouse';
			//$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);
		}
?>



<style>
body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}
</style>


<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead>
   <tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>Closing Stock As On:- '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>
<tr>
<th style="text-align:center">S/L</th>
<th style="text-align:center">Warehouse Name</th>
<th style="text-align:center">Item Code</th>
<th style="text-align:center">Item Group</th>
<th style="text-align:center">FG</th>
<th style="text-align:center">Item Name</th>
<th style="text-align:center">Unit</th>
<th style="text-align:center">CTN Stock</th>
<th style="text-align:center">Final Stock</th>

</tr>
</thead><tbody>
<?
while($data=mysqli_fetch_object($query)){
 
if($_SESSION['user']['depot']==1){ 
    $s='select sum(a.item_in-a.item_ex) as final_stock
from journal_item a where   a.item_id="'.$data->item_id.'" '.$date_con.$status_con.$warehouse_con.' order by a.id desc limit 1';}
else{
  $s='select sum(a.item_in-a.item_ex) as final_stock 
from journal_item a where  a.item_id="'.$data->item_id.'" '.$date_con.$status_con.' and a.warehouse_id="'.$_SESSION['user']['depot'].'"  order by a.id desc limit 1';
}
$avg_rate = find_a_field('journal_item', '(sum(item_in*item_price)/sum(item_in)', 'item_id = "'.$data->item_id.'" and warehouse_id="'.$warehouse_id.'" and ji_date <= "'.$to_date.'"');

$avg_rate_all = find_a_field('journal_item', '(sum(item_in*item_price)/sum(item_in) )', 'item_id = "'.$data->item_id.'" and ji_date <="'.$to_date.'"');
//$avg_rate = find_a_field('journal_item', '(sum(item_in*item_price)-sum(item_ex*item_price))/(sum(item_in)-sum(item_ex))', 'item_id = "'.$data->item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'"');
//and ji_date BETWEEN "'.$fr_date.'" and "'.$to_date.'"'
$q = db_query($s);
$i=mysqli_fetch_object($q);$j++;
//$amt = $i->final_stock*$data->d_price;
$amt = $i->final_stock*$avg_rate;
$total_amt = $total_amt + $amt;
		   ?>
<tr>
<td style="text-align:center"><?=$j?></td>
<td><?=$warehouse_name?></td>
<td style="text-align:center"><?=$data->item_id?></td>
<td><?=$data->sub_group_name?></td>
<td style="text-align:center"><?=$data->finish_goods_code?></td>
<td><?=$data->item_name?></td>
<td style="text-align:center"><?=$data->unit_name?></td>
<td style="text-align:right"><?=number_format(($total_qty=$i->final_stock/$data->pack_size),2); $tot_qty += $total_qty;?></td>
<td style="text-align:right"><?=number_format(($stockk=$i->final_stock),2); $final_qty += $stockk;?></td>

</td>
</tr>




<?
}


		
?>


	<tr>
		<td colspan="6"><div align="right">&nbsp;</div></td>		
		<td><div align="right"><strong>Total:</strong></div></td>	
		<td><div align="right"><?=number_format(($tot_qty),2);?></div></td>	
		<td><div align="right"><?=number_format(($final_qty),2);?></div></td>	
		
	
	
	</tr>

<?

}


elseif(isset($sql)&&$sql!='') echo report_create($sql,1,$str);
?></div>
</body>
</html>

<?
$page_name= $_POST['report'].$report."(Master Report Page)";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>