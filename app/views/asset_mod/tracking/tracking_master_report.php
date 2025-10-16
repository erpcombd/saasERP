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

		$report="Chalan Report (Purchase Order Wise)";

		if(isset($by)) 			{$by_con=' and a.prepared_by='.$by;} 

		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;} 

		if(isset($cat_id)) 		{$cat_con=' and d.id='.$cat_id;} 

		if(isset($item_id)) 	{$item_con=' and b.item_id='.$item_id;} 

		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';} 

if(isset($t_date)) 

{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.po_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		

echo  $sql='select a.po_date,c.vendor_name as vendor_name,a.status,f.fname as prepared_by, a.prepared_at,a.id as po_no,b.id as order_id,d.category_name,e.item_name,(b.qty*1.00) as qty,b.rate,b.amount,

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

	case 4:

	if($_REQUEST['wo_id']>0)

header("Location:work_order_print.php?po_no=".$_REQUEST['wo_id']);

	break;

	case 5:

		$report="Purchase Receive Report";

		if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 

		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 

		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 

		if(isset($vendor_id)) 	{$vendor_con=' and v.vendor_id='.$vendor_id;} 

		$status_con=' and a.tr_from = "Purchase" ';

		

		if(isset($t_date)) 

		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		

		 $sql='select ji_date as GR_Date,a.sr_no as GR_no,pm.po_date,pm.po_no,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `RQ`,a.item_price as rate,((a.item_in+a.item_ex)*a.item_price) as amount,v.vendor_name,a.entry_at,c.fname as User 

		   

		   from journal_item a, item_info i, user_activity_management c , item_sub_group s ,item_group g, purchase_receive pr,purchase_master pm,vendor v

		   where pm.vendor_id=v.vendor_id and c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and a.item_id=i.item_id and a.warehouse_id="1" and  s.group_id=g.group_id and g.group_name like "%FIXED ASSET%" and a.tr_no=pr.id and pr.po_no=pm.po_no '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.$vendor_con.' order by a.id';

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

		

if($_POST['report']==404)

{

$report="Asset Schedule Reports";

?>

	<table width="100%" border="0" cellpadding="2" cellspacing="0" id="ExportTable">

		

		<thead>

		<tr><td colspan="19" style="border:0px;">

		<?

		echo '<div class="header">';

		echo '<h1>'.find_a_field('project_info','proj_name','1').'</h1>';

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
		<th>Sl</th>
		<th>Name of Office</th>
		<th>Name of the Area</th>
		<th>Name of the Item</th>
		<th>User Name</th>
		<th>Condition</th>
		<th>Purchase Value</th>
		<th>Year of Purchase</th>
		<th>Tag Number</th>
		<TH>Status</TH>

	</tr>

<? 

if($_POST['f_date']!=''&&$_POST['t_date']!=''){

$con .= ' and r.reg_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';}

if($_POST['item_id']!=''){

$con .= ' and r.item_id="'.$_POST['item_id'].'"';}


$pr='SELECT serial_no FROM `journal_asset_item` WHERE tr_from="Issue" group by serial_no;';
$prQuery=db_query($pr);
while($pData=mysqli_fetch_object($prQuery)){
 $cr='SELECT j.serial_no,p.PBI_NAME FROM journal_asset_item j,fixed_asset_issue_details d,personnel_basic_info p 
WHERE j.tr_no=d.id and d.PBI_ID=p.PBI_ID and j.tr_from="Issue" and j.serial_no="'.$pData->serial_no.'" order by j.id desc limit 1';
$crQuery=db_query($cr);
while($cData=mysqli_fetch_object($crQuery)){
		$currentUser[$cData->serial_no]=$cData->PBI_NAME;
}
}



 $res='select r.*,a.area_name,i.item_name from  asset_register r,asset_area a,item_info i where r.area_code=a.id and r.item_id=i.item_id '.$con.'';

$query = db_query($res);

while($data=mysqli_fetch_object($query))

{
?>
	<tr>
		 <td><?=++$i;?></td>
		 <td><?=$_SESSION['company_name']?></td>
		 <td><?=$data->area_name?></td>
		 <td valign="top"><?=$data->item_name;?></td>
	 	 <td valign="top"><?=($data->item_status=="InService")? $currentUser[$data->sl_no] : '' ?></td>
	     <td valign="top"><?=$data->quality;?></td>
	  	 <td valign="top"><?=$data->price ?></td>
		 <td valign="top"><?=date("Y",strtotime($data->reg_date)) ?></td>
	 	 <td valign="top"><?=$data->sl_no;?></td>
		 <td valign="top"><?=$data->item_status?></td>
	</tr>
<?

 }?>

	<tr>

	  <td colspan="8" valign="top"><div align="right"><strong>Total Number of Item:</strong></div></td>

	  <td><div align="left">

	    <?=number_format(($i),2);?></div></td>
		<td></td>

	</tr>

</tbody></table>

<?

}

elseif($_POST['report']==505)

{

$report="Asset Tracking Report";

if($_POST['group_for']!=''){
$con =' and j.group_for="'.$_POST['group_for'].'"';
$company_name = find_a_field('user_group','group_name','id="'.$_POST['group_for'].'"');
}

?>

	<table width="100%" border="0" cellpadding="2" cellspacing="0" id="ExportTable">

		

		<thead>

		<tr><td colspan="19" style="border:0px;">

		<?

		echo '<div class="header">';
		echo '<h1>'.$company_name.'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		echo '</div>';
		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>

<tbody>

	<tr>
		<th>Sl</th>
		<th>Tag Number</th>
		<th>Asset Name</th>
		<th>Category</th>
		<th>Serial</th>
		<th>Purchase Date</th>
		<th>Purchase Price</th>
		<th>Location</th>
		<th>Assigned To/User</th>
		<th>Condition</th>
		<th>Maintenance Schedule</th>
		<th>Last Maintenance Date</th>
		<th>Warranty Expiry Date</th>
		<th>Depreciation</th>
		<th>Current Value</th>
		<th>Status</th>
		<th>Comments/Notes..</th>
		
	</tr>

<? 


if($_POST['warehouse_id']!=''){
$warehouse = explode("#",$_POST['warehouse_id']);
$con .=' and j.warehouse_id="'.$warehouse[1].'"';
$branch_con =' and j.warehouse_id="'.$warehouse[1].'"';
}
$crb='SELECT 
    j.tr_from, 
    j.item_id, 
    j.asset_tag, 
    j.id, 
    u.fname,
	i.item_name,
	s.sub_group_name,
	r.price,
	r.po_date
FROM 
    journal_asset_item j
INNER JOIN (
    SELECT 
        asset_tag, 
        item_id, 
        MAX(id) AS max_id 
    FROM 
        journal_asset_item 
    GROUP BY 
        asset_tag, 
        item_id
) grouped_j 
    ON j.asset_tag = grouped_j.asset_tag 
    AND j.item_id = grouped_j.item_id 
    AND j.id = grouped_j.max_id
LEFT JOIN 
    user_activity_management u 
    ON u.user_id = j.user_id,
	item_info i,asset_register r,item_sub_group s
	where i.item_id=j.item_id and i.sub_group_id=s.sub_group_id and j.asset_tag=r.asset_id 
	
ORDER BY 
    j.id DESC;';
		$crQuerys=db_query($crb);
		while($cData=mysqli_fetch_object($crQuerys)){
				$currentUser[$cData->asset_tag][$cData->id]=$cData->fname;
				$location[$cData->asset_tag][$cData->id]=$cData->tr_from;
				$tag_no[$cData->asset_tag][$cData->id]=$cData->asset_tag;
				$po_date[$cData->asset_tag][$cData->id]=$cData->po_date;
				$po_price[$cData->asset_tag][$cData->id]=$cData->price;
				$sub_group_name[$cData->asset_tag][$cData->id]=$cData->sub_group_name;
				
			}
	
	
	
	/*$tag = 'select j.*,s.sub_group_name from asset_register j,item_info i,item_sub_group s where s.sub_group_id=i.sub_group_id and j.item_id=i.item_id '.$con.' group by j.asset_id';
	$tag_qry = db_query($tag);
	while($register = mysqli_fetch_object($tag_qry)){
	 $tag_no[$register->asset_id] = $register->asset_id;
	 $reg_date[$register->asset_id] = $register->reg_date;
	 $po_date[$register->asset_id] = $register->po_date;
	 $po_price[$register->asset_id] = $register->price;
	 $register_note[$register->asset_id] = $register->note;
	 $sub_group_name[$register->asset_id] = $register->sub_group_name;
	}
	*/

if($_POST['warehouse_id']!=''){
$warehouse = explode("#",$_POST['warehouse_id']);
$con =' and j.warehouse_id="'.$warehouse[1].'"';
}

if($_POST['sub_group_id']!=''){
$sub_group = explode("#",$_POST['sub_group_id']);
$con .=' and i.sub_group_id="'.$sub_group[1].'"';
}


if($_POST['asset_id']!=''){
$con .=' and j.asset_tag="'.$_POST['asset_id'].'"';
}
 $res='SELECT j.*, i.item_name FROM journal_asset_item j INNER JOIN (SELECT asset_tag, item_id, 
            MAX(id) AS max_id 
        FROM 
            journal_asset_item 
        GROUP BY 
            asset_tag, 
            item_id
    ) grouped_j 
    ON 
        j.asset_tag = grouped_j.asset_tag 
        AND j.item_id = grouped_j.item_id 
        AND j.id = grouped_j.max_id
    LEFT JOIN 
        item_info i 
    ON 
        j.item_id = i.item_id
		where 1 '.$con.'
    ORDER BY 
        j.id DESC';

$query = db_query($res);

while($data=mysqli_fetch_object($query))

{

?>
	<tr>
		 <td><?=++$i;?></td>
		 <td><?=$tag_no[$data->asset_tag][$data->id]?></td>
		 <td><?=$data->item_name?></td>
		 <td><?=$sub_group_name[$data->asset_tag][$data->id]?></td>
		 <td><?=$data->serial_no?></td>
		 <td><?=$po_date[$data->asset_tag][$data->id]?></td>
		 <td><?=$po_price[$data->asset_tag][$data->id]?></td>
		 <td><?=$location[$data->asset_tag][$data->id]?></td>
		 <td><?=$currentUser[$data->asset_tag][$data->id]?></td>
		 <td><?=$data->serial_no2?></td>
		 <td><?=$data->serial_no2?></td>
		 <td><?=$data->serial_no2?></td>
		 <td><?=$data->serial_no2?></td>
		 <td><?=$data->serial_no2?></td>
		 <td><?=$data->serial_no2?></td>
		 <td><?=$data->serial_no2?></td>
		 <td><?=$data->serial_no2?></td>
	</tr>

<?
 
 }?>

	

</tbody></table>

<?

}

elseif($_POST['report']==506)

{

$report="Registered Asset Information";

if($_POST['group_for']!=''){
$con =' and a.group_for="'.$_POST['group_for'].'"';
$company_name = find_a_field('user_group','group_name','id="'.$_POST['group_for'].'"');
}

?>

	<table width="100%" border="0" cellpadding="2" cellspacing="0" id="ExportTable">

		

		<thead>

		<tr><td colspan="19" style="border:0px;">

		<?

		echo '<div class="header">';
		echo '<h1>'.$company_name.'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		echo '</div>';
		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>

<tbody>

	<tr>
		<th>Sl</th>
		<th>Asset Group</th>
		<th>Asset Sub Group</th>
		<th>Asset Name</th>
		<th>Asset ID</th>
		<th>Acquisition cost</th>
		<th>Salvage Value</th>
		<th>Estimated Life in Month</th>
		<th>Estimated unit of Production</th>
		<th>Condition</th>
		<th>Status</th>
	</tr>

<? 

if($_POST['item_id']>0){
$con .= ' and j.item_id="'.$_POST['item_id'].'"';

}


if($_POST['warehouse_id']!=''){
$warehouse = explode("#",$_POST['warehouse_id']);
$con =' and a.warehouse_id="'.$warehouse[1].'"';
}

if($_POST['sub_group_id']!=''){
$sub_group = explode("#",$_POST['sub_group_id']);
$con .=' and i.sub_group_id="'.$sub_group[1].'"';
}

if($_POST['group_id']!=''){
$group = explode("#",$_POST['group_id']);
$con .=' and s.group_id="'.$group[1].'"';
}





$res='select a.*, i.item_name,s.sub_group_name,g.group_name from asset_register a, item_info i, item_sub_group s, item_group g where a.item_id=i.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id '.$con.'';

$query = db_query($res);

while($data=mysqli_fetch_object($query))

{

?>
	<tr>
		 <td><?=++$i;?></td>
		 
		 <td><?=$data->group_name?></td>
		 <td><?=$data->sub_group_name?></td>
		 <td><?=$data->item_name?></td>
		 <td><?=$data->asset_id?></td>
		 <td><?=$data->price?></td>
		 <td><?=$data->salvage_value?></td>
		 <td><?=$data->life_duration?></td>
		 <td><?=$data->estd_production_unit?></td>
		 <td><?=$data->quality?></td>
		 <td><?=$data->item_status?></td>
	</tr>

<?
 
 }?>

	

</tbody></table>

<?

}

elseif(isset($sql)&&$sql!='') echo report_create($sql,1,$str);





?></div>

</body>

</html>