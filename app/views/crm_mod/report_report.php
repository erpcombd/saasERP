<?
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
date_default_timezone_set('Asia/Dhaka');

if(isset($_REQUEST['submit'])&&isset($_REQUEST['report'])&&$_REQUEST['report']>0){
	if((strlen($_REQUEST['t_date'])==10)){
		$t_date=$_REQUEST['t_date'];
		$f_date=$_REQUEST['f_date'];
	}
	
	if($_REQUEST['product_group']!='')  $product_group=$_REQUEST['product_group'];
	if($_REQUEST['item_brand']!='') 	$item_brand=$_REQUEST['item_brand'];
	if($_REQUEST['item_id']!='') 		    $item_id=$_REQUEST['item_id'];
	if($_REQUEST['dealer_code']>0) 	    $dealer_code=$_REQUEST['dealer_code'];
	if($_REQUEST['item_mother_group']>0) 	$item_mother_group=$_REQUEST['item_mother_group'];
	if($_REQUEST['item_group']>0) 		$item_group=$_REQUEST['item_group'];
	if($_REQUEST['item_sub_group']>0) 	$item_sub_group=$_REQUEST['item_sub_group'];
	if($_REQUEST['item_type']>0) 		$item_type=$_REQUEST['item_type'];
	if($_REQUEST['sale_type']>0) 		$item_type=$_REQUEST['sale_type'];
	if($_REQUEST['status']!='') 		$status=$_REQUEST['status'];
	if($_REQUEST['do_no']!='') 		    $do_no=$_REQUEST['do_no'];
	if($_REQUEST['area_id']!='') 		$area_id=$_REQUEST['area_id'];
	if($_REQUEST['zone_id']!='') 		$zone_id=$_REQUEST['zone_id'];
	if($_REQUEST['region_id']>0) 		$region_id=$_REQUEST['region_id'];
	if($_REQUEST['depot_id']!='') 		$depot_id=$_REQUEST['depot_id'];
	if($_REQUEST['group_for']>0) 		$group_for=$_REQUEST['group_for'];
	
	$item_info = find_all_field('item_info','','item_id='.$item_id);
	
	if(isset($item_brand)) 			{$item_brand_con=' and i.item_brand="'.$item_brand.'"';}
	if(isset($dealer_code)) 		{$dealer_con=' and a.dealer_code="'.$dealer_code.'"';}
	if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
	if(isset($dealer_type)) 		{if($dealer_type=='Distributor') {$dtype_con=' and d.dealer_type="Distributor"';} else {$dtype_con=' and d.dealer_type!="Distributor"';}}

	if(isset($dealer_type)) 		{if($dealer_type=='Distributor') {$dealer_type_con=' and d.dealer_type="Distributor"';} else {$dealer_type_con=' and d.dealer_type!="Distributor"';}}
	
	if(isset($dealer_code)) 		{$dealer_con=' and m.dealer_code='.$dealer_code;}
	if(isset($item_id))				{$item_con=' and i.item_id='.$item_id;}
	if(isset($depot_id)) 			{$depot_con=' and d.depot="'.$depot_id.'"';}
	
	switch ($_REQUEST['report']) {
	case 1:
		$report="Delivery Order Summary Brief";
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
	function hide(){
		document.getElementById('pr').style.display='none';
	}
</script>

<style type="text/css" media="print">
	div.page{
		page-break-after: always;
		page-break-inside: avoid;
	}
</style>
<?
	require_once  SERVER_CORE."core/inc.exporttable.php";
?>
</head>

<body>

	<div class="main">
	
	<?
	$str 	.= '<div class="header">';

	if(isset($_SESSION['user']['group']))
	$str 	.= '<h1>'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';
	
	if(isset($report))
	$str 	.= '<h2>'.$report.'</h2>';
	
	if(isset($dealer_code))
	$str 	.= '<h2>Dealer Name : '.$dealer_code.' - '.find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code).'</h2>';
	
	//if(isset($depot_id))
	//$str 	.= '<h2>Warehouse: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$depot_id).'</h2>';
	
	if(isset($item_brand))
	$str 	.= '<h2>Item Brand : '.$item_brand.'</h2>';
	
	if(isset($item_info->item_id))
	$str 	.= '<h2>Item Name : '.$item_info->item_name.'('.$item_info->finish_goods_code.')'.'('.$item_info->sales_item_type.')'.'('.$item_info->item_brand.')'.'</h2>';
	
	//if(isset($to_date))
	//$str 	.= '<h2>Date Interval : '.date("d-m-Y",strtotime($fr_date)).' To '.date("d-m-Y",strtotime($to_date)).'</h2>';
	
	if(isset($product_group))
	$str 	.= '<h2>Product Group : '.$product_group.'</h2>';
	
	if(isset($region_id))
	$str 	.= '<h2>Region Name : '.find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$region_id).'</h2>';
	
	if(isset($zone_id))
	$str 	.= '<h2>Zone Name: '.find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id).'</h2>';
	
	if(isset($area_id))
	$str 	.= '<h2>Area Name: '.find_a_field('area','AREA_NAME','AREA_CODE='.$area_id).'</h2>';
	
	if(isset($dealer_type))
	$str 	.= '<h2>Dealer Type : '.$dealer_type.'</h2>';
	
	$str 	.= '</div>';
	$str 	.= '<div class="left" style="width:100%">';
	
	
if($_REQUEST['report']==20241029) {
$report="OD & TADA Details Report";
?>


<table width="100%">
	<tr>
	<td width="25%" align="center" style="border:0px; border-color:white;">
	<img src="../../../../public/uploads/logo/<?=$_SESSION['proj_id']?>.png" style="width:50%"> 
	</td>
	
	<td  width="50%" style="border:0px; border-color:white;">
	<table width="100%">
	
	<tr align="center" >
	
	<td style="font-size:18px; border:0px; border-color:white;"><strong><?=find_a_field('user_group','group_name','id='.$_SESSION['user']['group'])?></strong></td>
	
	</tr>
	
	<tr align="center" >
	
	<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>
	
	</tr>
	
	<tr>
	
	<td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Employee : &nbsp;<?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$_POST['PBI_ID'].'"')?>-<?=$_POST['PBI_ID']?></td>
	
	</tr>
	
	<tr>
	
	<td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Date of: <?php echo date('d-M-Y',strtotime($_REQUEST['f_date']));?> and <?php echo date('d-M-Y',strtotime($_REQUEST['t_date']));?></td>
	
	</tr>
	
	</table>
	
	</td>
	
	<td  width="25%" align="center" style="border:0px; border-color:white;">&nbsp;</td>
	
	</tr>
	
	</table>

	<table width="100%" border="0" cellpadding="2" cellspacing="0" id="ExportTable">
	
	<thead>
	
	<tr height="30">
		<th bgcolor="#FFFACD">SL</th>
		<th bgcolor="#FFFACD">EMPLOYEE CODE</th>
		<th bgcolor="#FFFACD">EMPLOYEE NAME</th>
		<th bgcolor="#FFFACD">PROJECT NAME</th>
		<th bgcolor="#FFFACD">OD DATE</th>
		<th bgcolor="#FFFACD">START TIME</th>
		<th bgcolor="#FFFACD">END TIME</th>
		<th bgcolor="#FFFACD">CONVINCE BILL</th>
		<th bgcolor="#FFFACD">TOTAL AMOUNT</th>
	</tr>
	
	</thead>
	<tbody>
	<?php 
		if($_POST['f_date']!=''){
		$date_con = ' o.s_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
		}
		
		if($_POST['PBI_ID']!=''){
		$emp_con = ' and  o.PBI_ID = '.$_POST['PBI_ID'].'';
		}
		
		//echo $sql_data1 = 'SELECT * FROM hrm_od_info WHERE  1 '.$date_con.' ';
			$sql_data1 = 'SELECT o.id as od_id, o.*, u.PBI_NAME, p.name as project_name FROM hrm_od_info o, personnel_basic_info u, crm_project_org p WHERE '.$date_con.$emp_con.' AND o.project_id=p.id AND o.PBI_ID=u.PBI_ID';
			$query = db_query($sql_data1);
		$sl=1;
		while($info=mysqli_fetch_object($query)){
	?>
		<tr>
			<td><?=$sl++;?></td>
			<td><?=$info->PBI_ID;?></td>
			<td><?=$info->PBI_NAME;?></td>
			<td><?=$info->project_name;?></td>
			<td><?=$info->s_date;?></td>
			<td><?=$info->s_time;?></td>
			<td><?=$info->e_time;?></td>
			<td>
				<?php
					// SQL query to get the row from the bills table
					$sql_bill = "SELECT * FROM bills WHERE od_id ='" . $info->od_id . "'";
					$query3 = db_query($sql_bill);
					// Fetch the row containing conveyance types and amounts
					$row = mysqli_fetch_assoc($query3);
				
					// Split conveyance_type and amount if they are comma-separated
					$conveyance_types = explode(',', $row['conveyance_type']); 
					$amounts = explode(',', $row['amount']); 
					
					$total_amount = 0;
				
					// Loop through each conveyance type and display with corresponding amount
					foreach ($conveyance_types as $index => $type) {
						$amount = isset($amounts[$index]) ? $amounts[$index] : 0;  
						echo '<p class="'.strtolower($type).'" style=" font-size: 12px; ">'.ucfirst($type).': <span>'.$amount.'</span></p>';
						$total_amount += (float)$amount;  // Convert to float in case it's a string
					}
				?>
			</td>
			<td align="right"><strong><?=number_format($total_amount,2); $all_total +=$total_amount; ?></strong></td>
		</tr>
	<? } ?>
		
		<tr>
			<td colspan="8" align="right"> Total </td>
			<td align="right"><strong><?=number_format($all_total,2);?></strong></td>
		</tr>
	</tbody>
	</table>





<? }
if($_REQUEST['report']==202410292) {
$report="OD & TADA Summary Report";
?>


<table width="100%">
	<tr>
	<td width="25%" align="center" style="border:0px; border-color:white;">
	<img src="../../../../public/uploads/logo/<?=$_SESSION['proj_id']?>.png" style="width:50%"> 
	</td>
	
	<td  width="50%" style="border:0px; border-color:white;">
	<table width="100%">
	
	<tr align="center" >
	
	<td style="font-size:18px; border:0px; border-color:white;"><strong><?=find_a_field('user_group','group_name','id='.$_SESSION['user']['group'])?></strong></td>
	
	</tr>
	
	<tr align="center" >
	
	<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>
	
	</tr>
	
	<tr>
	
	<td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Employee : &nbsp;<?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$_POST['PBI_ID'].'"')?>-<?=$_POST['PBI_ID']?></td>
	
	</tr>
	
	<tr>
	
	<td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Date of: <?php echo date('d-M-Y',strtotime($_REQUEST['f_date']));?> and <?php echo date('d-M-Y',strtotime($_REQUEST['t_date']));?></td>
	
	</tr>
	
	</table>
	
	</td>
	
	<td  width="25%" align="center" style="border:0px; border-color:white;">&nbsp;</td>
	
	</tr>
	
	</table>

	<table width="100%" border="0" cellpadding="2" cellspacing="0" id="ExportTable">
	
	<thead>
	
	<tr height="30">
		<th bgcolor="#FFFACD">SL</th>
		<th bgcolor="#FFFACD">EMPLOYEE CODE</th>
		<th bgcolor="#FFFACD">EMPLOYEE NAME</th>
		<th bgcolor="#FFFACD">PERIOD</th>
		<th bgcolor="#FFFACD">CONVINCE BILL</th>
		
	</tr>
	
	</thead>
	<tbody>
	<?php 
		if($_POST['f_date']!=''){
		$date_con = ' o.s_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
		$fdate = $_POST['f_date'];
		$tdate = $_POST['t_date'];
		}
		
		if($_POST['PBI_ID']!=''){
		$emp_con = ' and  u.PBI_ID = '.$_POST['PBI_ID'].'';
		}
		
		
		function getBill($pbi_id,$sdate,$edate){
					
				 $sql_bill = "SELECT b.* FROM bills b,  hrm_od_info h WHERE b.od_id=h.id and h.s_date between '".$sdate."' and '".$edate."' and h.PBI_ID ='" . $pbi_id . "'";
					$query3 = db_query($sql_bill);
					while($row = mysqli_fetch_assoc($query3)){

					$amounts = explode(',', $row['amount']);
					$amt1 = (int)$amounts[0];
					$amt2 = (int)$amounts[1];
					$amt3 = (int)$amounts[2];
					$amt4 = (int)$amounts[3];
				    $total_bill += $amt1+$amt2+$amt3+$amt4;
				    }
					
					
					return $total_bill;
				
					
		}
				
		
		//echo $sql_data1 = 'SELECT * FROM hrm_od_info WHERE  1 '.$date_con.' ';
			 $sql_data1 = 'SELECT u.PBI_ID, u.PBI_NAME FROM personnel_basic_info u WHERE 1 '.$emp_con.'';
			$query = db_query($sql_data1);
		$sl=1;
		while($info=mysqli_fetch_object($query)){
		    $total_bill = getBill($info->PBI_ID,$fdate,$tdate);
		    $grand_total +=$total_bill;
	?>
		<tr>
			<td><?=$sl++;?></td>
			<td><?=$info->PBI_ID;?></td>
			<td><?=$info->PBI_NAME;?></td>
			
			<td><?=date('M-Y',strtotime($fdate));?></td>
			<td align="right"><?=number_format($total_bill,2)?></td>
			
		</tr>
	<? } ?>
		
		<tr>
			<td colspan="4" align="right"> Total </td>
			<td align="right"><strong><?=number_format($grand_total,2);?></strong></td>
		</tr>
	</tbody>
	</table>





<? }
elseif($_REQUEST['report']==20241030) {
$report="TADA Report Details";
?>





<?
}
elseif($_REQUEST['report']==210907001) {
	$report="Monthly Attendance Report";
?>

	<table width="100%">
	<tr>
	<td width="25%" align="center" style="border:0px; border-color:white;">
	<img src="../../../../public/uploads/logo/<?=$_SESSION['proj_id']?>.png" style="width:50%"> 
	</td>
	
	<td  width="50%" style="border:0px; border-color:white;">
	<table width="100%">
	
	<tr align="center" >
	
	<td style="font-size:18px; border:0px; border-color:white;"><strong><?=find_a_field('user_group','group_name','id='.$_SESSION['user']['group'])?></strong></td>
	
	</tr>
	
	<tr align="center" >
	
	<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>
	
	</tr>
	
	<tr>
	
	<td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Employee : &nbsp;<?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$_POST['PBI_ID'].'"')?>-<?=$_POST['PBI_ID']?></td>
	
	</tr>
	
	<tr>
	
	<td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Date of: <?php echo date('d-M-Y',strtotime($_REQUEST['f_date']));?> and <?php echo date('d-M-Y',strtotime($_REQUEST['t_date']));?></td>
	
	</tr>
	
	</table>
	
	</td>
	
	<td  width="25%" align="center" style="border:0px; border-color:white;">&nbsp;</td>
	
	</tr>
	
	</table>
	
	<table width="100%" border="0" cellpadding="2" cellspacing="0" id="ExportTable">
	
	<thead>
	
	<tr height="30">
		<th width="2%" bgcolor="#FFFACD">SL</th>
		<th width="9%" bgcolor="#FFFACD">EMPLOYEE CODE</th>
		<th width="15%" bgcolor="#FFFACD">EMPLOYEE NAME</th>
		<th width="10%" bgcolor="#FFFACD">DEPARTMENT</th>
		<th width="8%" bgcolor="#FFFACD">DESIGNATION</th>
		<th width="15%" bgcolor="#FFFACD">DATE</th>
		<th width="15%" bgcolor="#FFFACD">IN TIME</th>
		<th width="20%" bgcolor="#FFFACD">OUT TIME</th>
		<th width="20%" bgcolor="#FFFACD">STATUS</th>
	</tr>
	
	</thead><tbody>
	
	<? $sl=1;
	
	if($_POST['f_date']!=''){
	$date_con = ' and h.xdate between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
	}
	
	$sql = "select h.xenrollid,h.xdate,  min(h.xtime) as min_time from hrm_attdump h where 1 ".$date_con." group by h.xdate,h.xenrollid order by h.xdate";
	$query = db_query($sql);
	while($info=mysqli_fetch_object($query)){
		$min_time[$info->xenrollid][$info->xdate]=$info->min_time;
	}
	
	$sql = "select h.xenrollid,h.xdate,  max(h.xtime) as max_time  from hrm_attdump h where 1 ".$date_con." group by h.xdate,h.xenrollid order by h.xdate";
	
	$query = db_query($sql);
	
	while($info=mysqli_fetch_object($query)){
		$max_time[$info->xenrollid][$info->xdate]=$info->max_time;
		$xenrollid[$info->xenrollid][$info->xdate]=$info->xenrollid;
	}
	
	if($_POST['PBI_ID']!='')
	
	$pbi_id_con .= ' and p.PBI_ID = "'.$_POST['PBI_ID'].'" ';
	
	$f_date = $_POST['f_date'];
	
	$t_date = $_POST['t_date'];
	
	$sql = "select p.* from personnel_basic_info p where 1 ".$pbi_id_con."";
	
	$res	 = db_query($sql);
	
	while($row=mysqli_fetch_object($res))
	
	{
	
	$absent = 0;
	
	$late = 0;
	
	$early = 0;
	
	$present = 0;
	
	$friday = 0;
	
	$leave = 0;
	
	for($i=$f_date;$i<=$t_date;$i = date('Y-m-d', strtotime( $i . " +1 days"))){
	
	if($min_time[$row->PBI_ID][$i]!='' || $max_time[$row->PBI_ID][$i]!=''){
	
	$present++;
	
	$status= 'Present';
	
	$new_min_time=date("h:i:s a",strtotime($min_time[$row->PBI_ID][$i]));
	
	$max_min_time=date("h:i:s a",strtotime($max_time[$row->PBI_ID][$i]));
	
	$office_in_time = strtotime($i.' 10:00:00');
	
	$office_out_time = strtotime($i.' 18:00:00');
	
	$in = strtotime($min_time[$row->PBI_ID][$i]);
	
	$out = strtotime($max_time[$row->PBI_ID][$i]);
	
	if($in>$office_in_time){
	
	$status = 'Late';
	
	$late++;
	
	}
	
	}else{
	
	$friday_check = date('D',strtotime($i));
	
	if($friday_check=='Fri'){
	
	$status =  'Friday';
	
	$friday++;
	
	}else{
	
	$leave_check = find_a_field('hrm_att_summary','id','att_date="'.$i.'" and leave_id>0 and emp_id="'.$row->PBI_ID.'"');
	
	if($leave_check>0){
	
	$status='Leave';
	
	$leave++;
	
	}else{
	
	$new_min_tim = '';
	
	$max_min_time = '';
	
	$absent++;
	
	$status =  'Absent';
	
	}
	
	}
	
	}
	
	?>
	
	<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
	
	<td><?=$sl++;?></td>
	
	<td><?=$row->PBI_ID?></td>
	
	<td><?=$row->PBI_NAME?></td>
	
	<td><?=find_a_field('department','DEPT_DESC','DEPT_ID='.$row->DEPT_ID);?></td>
	
	<td><?=find_a_field('designation','DESG_DESC','DESG_ID='.$row->DESG_ID);?></td>
	
	<td><?php echo date('d-M-Y',strtotime($i));?></td>
	
	<td><?=$new_min_time;$new_min_time=''?></td>
	
	<td><?=$max_min_time;$max_min_time='';?></td>
	
	<td><?=$status;$status='';?></td>
	
	</td>
	
	</tr>
	
	<?  } } ?>
	
	<tr>
	
	<td colspan="5"><strong>Total</strong></td>
	
	<td><strong>Present : <?=$present+$friday+$leave; $present=0;$friday=0;$leave=0;?></strong></td>
	
	<td><strong>Absent : <?=$absent; $absent=0;?></strong></td>
	
	<td><strong>Leave : <?=$leave;$leave=0;?></strong></td>
	
	<td><strong>Late : <?=$late; $late=0;?></strong></td>
	
	</tr>
	
	</tbody>
	
	</table>
<?
}
	
elseif($_REQUEST['report']==210907002) 
{
?>
	
	
<?
}
elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}
?>
	
	<table width="100%" border="0" bordercolor="#FFFFFF" cellpadding="0" cellspacing="0" id="ExportTable" style="border:0px;border-color:#FFF;" >
		<tr>
			<td style="border:0px;border-color:#FFF;">&nbsp;</td>
			<td style="border:0px;border-color:#FFF;">&nbsp;</td>
			<td style="border:0px;border-color:#FFF;">&nbsp;</td>
			<td style="border:0px;border-color:#FFF;">&nbsp;</td>
		</tr>
		<tr>
			<td style="border:0px;border-color:#FFF;">&nbsp;</td>
			<td style="border:0px;border-color:#FFF;">&nbsp;</td>
			<td style="border:0px;border-color:#FFF;">&nbsp;</td>
			<td style="border:0px;border-color:#FFF;">&nbsp;</td>
		</tr>
		<tr>
			<td style="border:0px;border-color:#FFF;">&nbsp;</td>
			<td style="border:0px;border-color:#FFF;">&nbsp;</td>
			<td style="border:0px;border-color:#FFF;">&nbsp;</td>
			<td style="border:0px;border-color:#FFF;">&nbsp;</td>
		</tr>
		<tr>
			<td style="border:0px;border-color:#FFF;">&nbsp;</td>
			<td style="border:0px;border-color:#FFF;">&nbsp;</td>
			<td style="border:0px;border-color:#FFF;">&nbsp;</td>
			<td style="border:0px;border-color:#FFF;">&nbsp;</td>
		</tr>
		<tr>
			<td width="25%" align="center" style="border:0px;border-color:#FFF;"><strong><u>HR Manager </u></strong></td>
			<td width="25%" align="center" style="border:0px;border-color:#FFF;"><strong><u>Asst. Manager </u></strong></td>
			<td width="25%" align="center" style="border:0px;border-color:#FFF;"><strong><u>General Manager </u></strong></td>
			<td width="25%" align="center" style="border:0px;border-color:#FFF;"><strong><u>Authorized By</u></strong></td>
		</tr>
		<tr>
			<td align="center" style="border:0px;border-color:#FFF;">&nbsp;</td>
			<td align="center" style="border:0px;border-color:#FFF;">&nbsp;</td>
			<td align="center" style="border:0px;border-color:#FFF;">&nbsp;</td>
			<td align="center" style="border:0px;border-color:#FFF;">&nbsp;</td>
		</tr>
	</table>
	
	<table width="100%" border="0" bordercolor="#FFFFFF" cellpadding="0" cellspacing="0" id="ExportTable" style="border:0px;border-color:#FFF;" >
		<tr>
			<td style="border:0px;border-color:#FFF;">&nbsp;</td>
			<td style="border:0px;border-color:#FFF;">&nbsp;</td>
			<td style="border:0px;border-color:#FFF;">&nbsp;</td>
			<td style="border:0px;border-color:#FFF;">&nbsp;</td>
		</tr>
	</table>
	
	</div>
</body>
</html>