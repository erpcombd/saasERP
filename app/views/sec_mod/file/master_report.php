<?php


session_start ();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
//require_once SERVER_CORE."routing/layout.top.php";
include '../config/function.php';
	require_once(SERVER_CORE.'core/inc.exporttable.php');


$user           = $_SESSION['user']['username'];
$company_id     = $_SESSION['user']['company_id'];
$company_name   = find1('select company_name from setup_company where id="'.$company_id.'"');

$customer_group = find1('select customer_group_id from ledger_config where group_for="'.$company_id.'"');

		
if(isset($_REQUEST['submit'])&&isset($_REQUEST['report'])&&$_REQUEST['report']>0){

		
	$f_date=$_REQUEST['f_date'];
	$t_date=$_REQUEST['t_date'];

	if($_POST['group_for']>0) 				    $group_for=$_POST['group_for'];
	if($_POST['warehouse_id']>0) 				$warehouse_id=$_POST['warehouse_id'];
	if($_POST['dealer_code']>0) 				$dealer_code=$_POST['dealer_code'];
	if($_POST['so_code']>0) 				    $so_code=$_POST['so_code'];
	if($_REQUEST['item_id']>0) 					$item_id=$_REQUEST['item_id'];
	
	
	if($_POST['order_type']!='') 				$order_type=$_POST['order_type'];
	
	if($_POST['issue_status']!='') 				$issue_status=$_POST['issue_status'];
	if($_POST['item_sub_group']>0) 				$sub_group_id=$_POST['item_sub_group'];
	if($_POST['item_brand']>0) 				    $item_brand=$_POST['item_brand'];
	if($_REQUEST['product_group']!='')          $product_group=$_REQUEST['product_group'];
	
	if($_POST['region_id']!='') 				$region_id=$_POST['region_id'];
	if($_POST['zone_id']!='') 				    $zone_id=$_POST['zone_id'];
	if($_POST['area_id']!='') 				    $area_id=$_POST['area_id'];
	if($_POST['route_id']!='') 				    $route_id=$_POST['route_id'];

$location='';
if(isset($region_id)) 			{$location.=' and d.region_id="'.$region_id.'"';}
if(isset($zone_id)) 			{$location.=' and d.zone_id="'.$zone_id.'"';}
if(isset($area_id)) 			{$location.=' and d.area_code="'.$area_id.'"';}
//if(isset($route_id)) 			{$location.=' and d.route_id="'.$route_id.'"';}

$locationt='';
if(isset($region_id)) 			{$locationt.=' and t.region_id="'.$region_id.'"';}
if(isset($zone_id)) 			{$locationt.=' and t.zone_id="'.$zone_id.'"';}
if(isset($area_id)) 			{$locationt.=' and t.area_id="'.$area_id.'"';}
//if(isset($route_id)) 			{$locationt.=' and t.route_id="'.$route_id.'"';}


$item_con='';
if($item_id>0) {$item_con.=' and i.item_id="'.$item_id.'"';}
if($group_for>0) {$item_con.=' and i.group_for="'.$group_for.'"';}
if($product_group>0) {$item_con.=' and i.item_group="'.$product_group.'"';}


switch ($_POST['report']) {


case 1:
$report="Sales Officer User List";
break;



case 899:
$report="Item List";
break;


case 51:
$report="Item Wise Order Vs Sales Report";
break;

case 52:
$report="Outelet Wise Order Vs Sales Report";
break;

case 53:
$report="NSP Report Chalan wise";
break;

case 54:
$report="NSP Report Outlet wise";
break;

case 55:
$report="NSP Report Detials";
break;

case 125:
$report="Rx Visit Report";
break;



case 101:
$report="Item Wise Target Vs Sales Report";
break;	


case 102:
$report="Dearler Wise Target Vs Sales Report";
break;	

case 103:
$report="SO wise Order/Delivery Report";
break;	

case 104:
$report="Dealer Stock Report";
break;

case 105:
$report="Dealer Wise Stock Report";
break;


case 110:
$report="Field Officer Contribution File";
if($_POST['dealer_code']!='') $dealer_con.=' and dealer_code = "'.$_POST['dealer_code'].'"';

$year = date("Y",strtotime($t_date));
$mon = date("m",strtotime($t_date));


if(isset($region_id)) 			{$location.=' and d.region_id="'.$region_id.'"';}
if(isset($zone_id)) 			{$location.=' and d.zone_id="'.$zone_id.'"';}
if(isset($area_id)) 			{$location.=' and d.area_id="'.$area_id.'"';}

$sql="select t.target_year,t.target_month,t.dealer_code,t.dealer_name,t.emp_code,t.emp_name,t.target_con
from ss_target_ratio t , dealer_info d
where t.dealer_code=d.dealer_code and t.target_year='".$year."' and t.target_month='".$mon."' 
".$con.$dealer_con.$location."
order by t.dealer_code,t.emp_code
";
break;

	
	
case 501:
$report="Secondary Sales Mobile App Login Report";
break;

case 503:
$report="Attedance Report";
break;

case 504:
$report="Visit Report";
break;


case 502:
$report="Secondary Sales Mobile App Login Report";

$sql="select s.access_date,DAYNAME(s.access_date) as Day,count(DISTINCT(user_id)) as Login_user
from personnel_basic_info p, ss_location_log s
where s.user_id = p.PBI_ID and s.access_date between '".$_POST['f_date']."' and '".$_POST['t_date']."'
".$pg_con.$location." 
and p.PBI_JOB_STATUS='In Service' and s.type='SO Login'
group by s.access_date 
order by s.access_date";

break;






break;


case 900:
$report="Item List";

$sql="select item_id,finish_goods_code as product_code,item_group,category_id,subcategory_id,item_name,unit_name,m_price as mrp,t_price as tp,nsp_per,status
from item_info
where 1
order by item_group,category_id,subcategory_id,item_name";

break;


case 904:
$report="Shop List";

break;


case 901:
$report="Target Upload item wise";
$mon = $_POST['mon'];
$year = $_POST['year'];
$grp = $_POST['product_group'];
if($_POST['product_group']!=''){ $grp_con=' and grp="'.$grp.'"';}


 $sql="select fg_code,item_id,sum(target_ctn) as total_ctn,d_price,sum(target_amount) as total_amount
	from sale_target_upload 
	where target_year='".$year."' and target_month='".$mon."'
".$con.$grp_con."
group by item_id order by fg_code
";

break;	

case 902:
$report="Target Upload Dealer Wise";

$mon = $_POST['mon'];
$year = $_POST['year'];
$grp = $_POST['product_group'];
if($_POST['product_group']!=''){ $grp_con=' and grp="'.$grp.'"';}
	
$sql="select dealer_code,sum(target_ctn) as total_ctn,sum(target_amount) as total_amount
	from sale_target_upload 
	where target_year='".$year."' and target_month='".$mon."'
".$con.$grp_con."
group by dealer_code order by dealer_code
";

break;	


case 903:
$report="Target Upload File";

if($_POST['dealer_code']!='') $dealer_con.=' and t.dealer_code = "'.$_POST['dealer_code'].'"';


$mon = $_POST['mon'];
$year = $_POST['year'];
//$grp = $_POST['product_group']; if($_POST['product_group']!=''){ $grp_con=' and t.grp="'.$grp.'"';}


$sql="select t.target_year,t.target_month,t.grp,t.dealer_code,t.item_id,t.fg_code,i.item_name, t.target_ctn,t.d_price,t.target_amount,t.entry_by,t.entry_at
from sale_target_upload t, item_info i 
where t.item_id = i.item_id and t.target_year='".$year."' and t.target_month='".$mon."'
".$con.$dealer_con."
order by t.dealer_code,t.fg_code
";

break;	











}}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Report</title>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 4px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>




<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">-->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>-->


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css"> 


  
</head>

<body>

<div class="row">
    <div class="col-12">
        <!--<div class="card">-->
        <!--    <div class="card-body">-->


<?php
		//$str 	.= '<div class="header">';
// 		$str 	.= '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
$str.= '<center><span style="font-size:25px;"><?=$company_name;?></span><br>';
		
		if(isset($report)) $str.= '<span style="font-size:18px;">'.$report.'</span>';
		
		if(isset($t_date)) $str.= '<p style="font-size:12px;">Date Interval: '.$f_date.' To '.$t_date.'</p>';
		
		if(isset($group_for)) { $item_company = find1("select group_name from user_group where id='".$group_for."'");
		$str.= '<p>Item Company: '.$item_company.'</p>';
		}
		
		if(isset($product_group)) { $product_group_name = find1("select group_name from product_group where id='".$product_group."'");
		$str.= '<p>Product Group: '.$product_group_name.'</p>';
		}		
		
		if(isset($item_id)) { $item_name = find1("select item_name from item_info where item_id='".$item_id."'");
		$str.= '<p>Item Name: '.$item_id.'-'.$item_name.'</p>';
		}
		
		if(isset($region_id)) { $region_name = find1("select BRANCH_NAME from branch where BRANCH_ID='".$region_id."'");}
		if(isset($zone_id)) { $zone_name = find1("select ZONE_NAME from zon where ZONE_CODE='".$zone_id."'");}
		if(isset($area_id)) { $area_name = find1("select AREA_NAME from area where AREA_CODE='".$area_id."'");}
		if(isset($route_id)) { $route_name = find1("select route_name from ss_route where route_id='".$route_id."'");}
		if($region_id>0 || $zone_id>0 || $area_id>0 || $route_id>0){
		$str.= '<p>Location : '.$region_name.' '.$zone_name.' '.$area_name.' '.$route_name.'</p>';
		}		
		
		if($dealer_code>0) { $dealer_name = find1("select concat(dealer_code2,' ',dealer_name_e) as dealer_name from dealer_info where dealer_code='".$dealer_code."'");
		$str.= '<p>Dealer Name: '.$dealer_name.'</p>';
		}		
		

		
		$str.='<div align="right">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		



if($_REQUEST['report']==1) { 


// region list
$sql='select BRANCH_ID  as region_id,BRANCH_NAME as region_name from branch';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){$region_info[$info->region_id] = $info->region_name;}

// zone list
$sql='select ZONE_CODE as zone_id,ZONE_NAME as zone_name from zon';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){$zone_info[$info->zone_id] = $info->zone_name;}

// area list
$sql='select AREA_CODE as area_id,AREA_NAME as area_name from area';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){$area_info[$info->area_id] = $info->area_name;}


//if(isset($product_group)) { $pg_con=' and p.PBI_GROUP="'.$product_group.'"';}

if(isset($region_id)) 			{$location.=' and p.PBI_BRANCH="'.$region_id.'"';}
if(isset($zone_id)) 			{$location.=' and p.PBI_ZONE="'.$zone_id.'"';}
if(isset($area_id)) 			{$location.=' and p.PBI_AREA="'.$area_id.'"';}

//--------------- Dealer Info -----------------		
$sql_ssales='select * from dealer_info where 1';
$query3 = mysqli_query($conn,$sql_ssales);
while($info=mysqli_fetch_object($query3)){
$dc2[$info->dealer_code]=($info->dealer_code2);
$dc_name[$info->dealer_code]=($info->dealer_name_e);
}


?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="9"><?=$str;?></td></tr>
<tr>
<th>S/L</th>
<th>Region</th>
<th>Zone</th>
<th>Area</th>
<th>Employee Code</th>
<th>Name</th>
<th>Mobile</th>
<th>Dealer Code</th>
<th>Dealer Code2</th>
<th>Dealer Name</th>
</tr>
</thead><tbody>

<?
$sql="select s.* from ss_user s
where 1 and status='Active'
".$pg_con.$location." 
order by s.region_id,s.zone_id,s.area_id,s.dealer_code,s.username";

$query = mysqli_query($conn,$sql); 
while($data=mysqli_fetch_object($query)){
$s++;
?>
<tr>
<td><?=$s?></td>
<td><?=$region_info[$data->region_id];?></td>
<td><?=$zone_info[$data->zone_id];?></td>
<td><?=$area_info[$data->area_id];?></td>
<td><?=$data->username?></td>
<td><?=$data->fname?></td>
<td><?=$data->mobile?></td>

<td><?=$data->dealer_code?></td>
<td><?=$dc2[$data->dealer_code];?></td>
<td><?=$dc_name[$data->dealer_code];?></td>

</tr>
<? } ?>
</tbody>
</table>
<? }






if($_REQUEST['report']==899) { 







?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="9"><?=$str;?></td></tr>
<tr>
<th>S/L</th>
<th>Item ID</th>
<th>Item Code</th>
<th>Item Name</th>
<th>Item Category</th>
<th>Unit</th>

</tr>
</thead><tbody>

<?
 $sql="select *
from item_info
where 1
order by item_name";

$query = mysqli_query($conn,$sql); 
while($data=mysqli_fetch_object($query)){
$s++;
?>
<tr>
<td><?=$s?></td>
<td><?=$data->item_id;?></td>
<td><?=$data->finish_goods_code;?></td>
<td><?=$data->item_name;?></td>
<td><?=find_a_field('item_sub_group','sub_group_name','sub_group_id="'.$data->sub_group_id.'"');?></td>
<td><?=$data->unit_name?></td>



</tr>
<? } ?>
</tbody>
</table>
<? }



elseif($_REQUEST['report']==51){


if(isset($t_date)) {
$to_date=$t_date; $fr_date=$f_date; 
$date_con2=' and c.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';
$date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';

$year = date("Y",strtotime($t_date));
$mon = date("m",strtotime($t_date));
}

$location=''; $location2='';
if(isset($region_id)) 			{$location.=' and region_id="'.$region_id.'"'; $location2.=' and region_id="'.$region_id.'"';}
if(isset($zone_id)) 			{$location.=' and zone_id="'.$zone_id.'"'; $location2.=' and zone_id="'.$zone_id.'"';}
if(isset($area_id)) 			{$location.=' and area_id="'.$area_id.'"'; $location2.=' and area_code="'.$area_id.'"';}
if(isset($route_id)) 			{$location.=' and route_id="'.$route_id.'"'; $location2.=' and route_id="'.$route_id.'"';}

if($_POST['so']>0) 				{$so_con.=' and s.emp_code="'.$so.'"';}

if($_POST['dealer_code']>0) 	{
    $dealer_con.=' and dealer_code="'.$_POST['dealer_code'].'"';
    $dealer_con2.=' and s.dealer_code="'.$_POST['dealer_code'].'"';
    $dealer_con3.=' and c.depot_id="'.$_POST['dealer_code'].'"';
}


//--------------- Item wise secondary Order -----------------		
$sql_sales='select i.item_id, i.item_name,i.unit_name, sum(c.total_unit) as qty,sum(c.total_amt) as amount
from item_info i, ss_do_details c, ss_shop s
where i.item_id=c.item_id and s.dealer_code=c.dealer_code 
'.$date_con2.$item_con.$location.$so_con.$dealer_con3.'
group by item_id order by item_id';
$query2 = mysqli_query($conn,$sql_sales);
while($info=mysqli_fetch_object($query2)){
$order_qty[$info->item_id]=($info->qty);
$order_amt[$info->item_id]=($info->amount);
}



		
//--------------- Item wise secondary sales -----------------		
$sql_sales='select i.item_id, i.item_name,i.unit_name, sum(c.total_unit) as qty,sum(c.total_amt) as amount
from item_info i, ss_do_chalan c, ss_shop s
where i.item_id=c.item_id and s.dealer_code=c.dealer_code 
'.$date_con.$item_con.$location.$so_con.$dealer_con3.'
group by item_id order by item_id';
$query2 = mysqli_query($conn,$sql_sales);
while($info=mysqli_fetch_object($query2)){
$sales_qty[$info->item_id]=($info->qty);
$sales_amt[$info->item_id]=($info->amount);
}




?>
<table width="100%" cellspacing="0" cellpadding="2"  border="0">
<tr><td style="border:0px;" colspan="11"><?=$str?></td></tr>
<tr>
<th>S/L</th>
<th>FG Code</th>
<th>Item Name</th>
<th bgcolor="#00CCCC">Order Qty</th>
<th>Order Amt</th>

<th bgcolor="#00CCCC">Sales Qty</th>
<th>Sales Amt</th>
<th bgcolor="#00CCCC">Short Fall Qty</th>
<th>Ach%</th>
</tr>
<? 
$res="select i.* from item_info i where 1 
".$item_con." order by finish_goods_code";
$query=mysqli_query($conn,$res);
while($data=mysqli_fetch_object($query)){

if($target_qty[$data->item_id]>0 || $sales_qty[$data->item_id]>0){
$s++;
?>
<tr>
  <td><?=$s?></td>
  <td><?=$data->finish_goods_code?></td>
  <td><?=$data->item_name?></td>
  <td><?=(int)($order_qty[$data->item_id]);?></td>
  <td><?=(int)$order_amt[$data->item_id]; $gorder +=$order_amt[$data->item_id];?></td>
  

  <td><?=(int)($sales_qty[$data->item_id]);?></td>
  <td><?=(int)$sales_amt[$data->item_id]; $gsales +=$sales_amt[$data->item_id];?></td>
  <td><? $sfall=(int)(($sales_qty[$data->item_id]-$order_qty[$data->item_id])); $gsfall+=$sfall;
  if($sfall<0){ ?> <span style="color:red; font-weight: bold;"><?=$sfall;?> <? }else{ echo $sfall;} 
  ?></td>
  <td><?
			$ratio = (($sales_amt[$data->item_id]*100)/$order_amt[$data->item_id]);
			if($ratio<>0) {echo number_format($ratio,2); } 
  ?> % </td>
  </tr>
<? }} ?>
<tr>
<td></td><td></td><td><div align="right"><strong>Total</strong></div></td><td><strong>
  <? //=$gqty?></strong></td>
<td><strong><?=$gorder?></strong></td>

<td></td>
<td><strong><?=$gsales?></strong></td>
<td><strong><?=number_format($gsfall,0);?></strong></td>
<? $gratio = (($gsales*100)/$gorder); ?>
<td><strong><?=number_format($gratio,2);?> % </strong></td>
</tr>
</table>
<?
//$str = '';

} // end 51






elseif($_REQUEST['report']==210907001) {

		$report="Daily Attendance Report";

		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		?>

		<style>
        .late { background-color: #F0E445; } /* Light pink */
        .absent { background-color: #E73F6B; } /* Light salmon */
        .present { background-color: #64CD8A; } /* Pale green */
        .leave { background-color: #7239EA; } /* Pale green */
       </style>
		<table width="100%">

	   	<tr>

		<td width="25%" align="center" style="border:0px; border-color:white;">

		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" style="width:50%">

		</td>

		<td  width="50%" style="border:0px; border-color:white;">

			<table width="100%"  >

				<tr align="center" >
					<td style="font-size:18px; border:0px; border-color:white;"><strong><?=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG'])?></strong></td>
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>
				</tr>
		 <? if ($_REQUEST['ledger_group']>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong> Group: <?=find_a_field('ledger_group','group_name','group_id='.$_REQUEST['ledger_group'])?></strong></td>
         </tr>

		 <? }?>

		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Date of:<?php echo date('d-m-Y',strtotime($_REQUEST['t_date']));?></td>

         </tr>
			</table>
		</td>
		<td  width="25%" align="center" style="border:0px; border-color:white;">&nbsp;</td>
		</tr>
		<tr>
			<div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td>
		</tr>
       </table>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		<thead>
		<tr height="30">
		<th width="2%" bgcolor="#FFFACD" style="text-align:center">SL</th>
		<th width="9%" bgcolor="#FFFACD" style="text-align:center">ID NO</th>
		<th width="15%" bgcolor="#FFFACD" style="text-align:center">Employee Name</th>
		<!--<th width="8%" bgcolor="#FFFACD" style="text-align:center">Designation</th>
        <th width="10%" bgcolor="#FFFACD" style="text-align:center">Department</th>-->
		<th width="8%" bgcolor="#FFFACD" style="text-align:center">Attendance Date</th>

		<th width="8%" bgcolor="#FFFACD" style="text-align:center">In Time</th>

		<th width="8%" bgcolor="#FFFACD" style="text-align:center">Out Time</th>

	<!--	<th width="8%" bgcolor="#FFFACD" style="text-align:center">Schedule</th>
		
		<th width="8%" bgcolor="#FFFACD" style="text-align:center">Working Location</th>
		
		<th width="8%" bgcolor="#FFFACD" style="text-align:center">Distance</th>-->
       
        <th width="8%" bgcolor="#FFFACD" style="text-align:center">Location</th>

		<th width="20%" bgcolor="#FFFACD" style="text-align:center">Status</th>

		</tr>
		</thead><tbody>

		<? $sl=1;

		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}


    if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
    if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}
 
 	// if schedule has been given then active bellow query
     // $sql = "select EMP_CODE,  min(xtime) as min_time,latitude,longitude,sch_latitude_point,sch_longitude_point,schedule_notes from hrm_attdump where xdate ='".$t_date."' group by EMP_CODE ";
	 
	 // this for the location of od punch
	 $sql = "select EMP_CODE,  min(xtime) as min_time,latitude,longitude,sch_latitude_point,sch_longitude_point,schedule_notes from hrm_attdump where xdate ='".$t_date."' group by EMP_CODE ";
     $query = db_query($sql);
     while($info=mysqli_fetch_object($query)){

      $min_time[$info->EMP_CODE]=$info->min_time;

      $in_latitutee[$info->EMP_CODE]=$info->latitude;
      $in_longitudee[$info->EMP_CODE]=$info->longitude;
	
      $in_from_latitutee[$info->EMP_CODE]=$info->sch_latitude_point;
      $in_from_longitudee[$info->EMP_CODE]=$info->sch_longitude_point;



		}



       $sql = "select EMP_CODE,  max(xtime) as max_time  from hrm_attdump where xdate ='".$t_date."' group by EMP_CODE ";



		 $query = db_query($sql);



		 while($info=mysqli_fetch_object($query)){



  		 $max_time[$info->EMP_CODE]=$info->max_time;



		 $EMP_CODE[$info->EMP_CODE]=$info->EMP_CODE;



		}


		
		  $sql = "select id,PBI_ID  from hrm_leave_info where s_date>='".$f_date."' or e_date<='".$t_date."' and leave_status='GRANTED' and incharge_status='Approve' group by PBI_ID ";
		
		//$sql = "select id,emp_id  from hrm_att_summary where att_date ='".$t_date."' and leave_id>0 group by emp_id ";

         $query = db_query($sql);
         while($info=mysqli_fetch_object($query)){

		 $leave[$info->PBI_ID]=$info->PBI_ID;
          }

         $holyday=find_a_field('salary_holy_day','id','holy_day="'.$t_date.'"');

if($_POST['JOB_STATUS']!='')
$emp_status_con .= ' and p.status = "'.$_POST['JOB_STATUS'].'" ';

	  $sql="select p.* from ss_user p where 1 ".$emp_status_con." order by p.username ";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{


		 $new_min_time=date("h:i:s a",strtotime($min_time[$row->user_id]));

		 $max_min_time=date("h:i:s a",strtotime($max_time[$row->user_id]));

		 $i = $t_date;	
		 

		 $office_in_time = strtotime($i.' 09:00:00');
		 $office_out_time = strtotime($i.' 18:00:00');

		 $in = strtotime($min_time[$row->user_id]);
		 $out = strtotime($max_time[$row->user_id]);

           $in_latitute =  $in_latitutee[$row->user_id]; 
		
             $in_longitude = $in_longitudee[$row->user_id];
           $in_from_latitute =  $in_from_latitutee[$row->user_id]; 
               $in_from_longitude = $in_from_longitudee[$row->user_id];




		 if($in>0 || $out>0){

          $status = 'Present';
         }else{
           $status = 'Absent';
           $new_min_time = '';
		   $max_min_time = '';
         }

		   if($in>$office_in_time){
		    $status = 'Late';
			$late++;
		   }

		    if($max_min_time=="" && $holyday>0){
            $status = 'Holyday';

		 }
		 $leave_check=find_a_field('hrm_leave_info','count(id)','PBI_ID="'.$row->user_id.'" and s_date<="'.$t_date.'" and e_date>="'.$t_date.'" and leave_status="GRANTED" and incharge_status="Approve"');
		

		 if($leave_check>0){
		     
		     $status = 'Leave';
		     $new_min_time = '';
		     $max_min_time = '';
		 }


		    // for warning by color
		        $class = '';
               switch ($status) {
                case 'Late':
                    $class = 'late';
                    break;
                case 'Absent':
                    $class = 'absent';
                    break;
                case 'Present':
                    $class = 'present';
                    break;

                 case 'Leave':
                    $class = 'leave';
                    break;
            }





		?>
		<? //if($xenrollid[$row->PBI_ID]>0) {?>

<?

 $shift_id = find_a_field('hrm_roster_allocation','shedule_1',' PBI_ID="'.$row->PBI_ID.'"   and roster_date="'.date('Y-m-d',strtotime($t_date)).'" ');
 
 $working_loc = find_a_field('hrm_od_info','project_id',' PBI_ID="'.$row->PBI_ID.'"   and s_date="'.$t_date.'" ');

?>





		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>



		<td style="text-align:center"><?=$sl++;?></td>
		
	
       
     
       <td style="text-align:center"><?=$row->username?></td>
       <td><?=$row->fname?></td>
	   
	  <?php /*?> <td><?=find_a_field('designation','DESG_DESC','DESG_ID='.$row->DESG_ID);?></td>
		<td><?=find_a_field('department','DEPT_DESC','DEPT_ID='.$row->DEPT_ID);?></td><?php */?>
		

		<td style="text-align:center"><?php echo date('d-M-Y',strtotime($t_date));?></td>

		<td style="text-align:center"><?=$new_min_time;?>  </td>

       <td style="text-align:center"><? if($max_min_time!=$new_min_time) echo $max_min_time;?></td>

	   <?php /*?><td><?=find_a_field('hrm_attdump','schedule_notes','xenrollid="'.$row->PBI_ID.'" and xdate ="'.$t_date.'"');?></td>
	   <td><?=find_a_field('crm_project_org','name','id="'.$working_loc.'"');?></td>
	   <td><? 
	   if($in_from_latitute !='' && $in_from_longitude !='' && $in_latitute !='' && $in_longitude!=''){
	   $d_distance=haversineDistance($in_from_latitute,$in_from_longitude,$in_latitute,$in_longitude);
	   echo number_format($d_distance, 2) . ' meters';
	   }else{
	   }
	 ?>   
	</td><?php */?>
	
       <td align="center"><?  
    
      if($in_latitute!='' && $in_longitude!=''){?>
       <a href="https://www.latlong.net/c/?lat=<?=$in_latitute?>&long=<?=$in_longitude?>" target="_blank" class="btn btn-warning btn-xs"><button>View</button></a>
      <? } ?></td>
	<td class="<?=$class?>" style="text-align:center"><?=$status?></td>
		</tr>

<?  } //} ?>
		</tbody>
		</table>
 		</tbody>
 		</table>

		<?

 }



elseif($_REQUEST['report']==52){

$location=''; $location2='';
if(isset($t_date)) {
$to_date=$t_date; $fr_date=$f_date; 
$date_con2=' and c.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';
$date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';

$year = date("Y",strtotime($t_date));
$mon = date("m",strtotime($t_date));
}


if(isset($region_id)) 			{$location.=' and region_id="'.$region_id.'"'; $location2.=' and region_id="'.$region_id.'"';}
if(isset($zone_id)) 			{$location.=' and zone_id="'.$zone_id.'"'; $location2.=' and zone_id="'.$zone_id.'"';}
if(isset($area_id)) 			{$location.=' and area_id="'.$area_id.'"'; $location2.=' and area_code="'.$area_id.'"';}
if(isset($route_id)) 			{$location.=' and route_id="'.$route_id.'"'; $location2.=' and route_id="'.$route_id.'"';}


if($_POST['dealer_code']>0) 	{
    $dealer_con.=' and dealer_code="'.$_POST['dealer_code'].'"';
    $dealer_con2.=' and s.dealer_code="'.$_POST['dealer_code'].'"';
    $dealer_con3.=' and c.depot_id="'.$_POST['dealer_code'].'"';
}


//--------------- Item wise secondary Order -----------------		
$sql_sales='select s.dealer_code,sum(c.total_amt) as amount
from item_info i, ss_do_details c, ss_shop s
where i.item_id=c.item_id and s.dealer_code=c.dealer_code 
'.$date_con2.$item_con.$location.$so_con.$dealer_con3.'
group by s.dealer_code order by dealer_code';

$query2 = mysqli_query($conn,$sql_sales);
while($info=mysqli_fetch_object($query2)){
$order_amt[$info->dealer_code]=($info->amount);
}

		
//--------------- Item wise secondary sales -----------------		
$sql_sales='select s.dealer_code,sum(c.total_amt) as amount
from item_info i, ss_do_chalan c, ss_shop s
where i.item_id=c.item_id and s.dealer_code=c.dealer_code 
'.$date_con.$item_con.$location.$so_con.$dealer_con3.'
group by dealer_code order by dealer_code';

$query2 = mysqli_query($conn,$sql_sales);
while($info=mysqli_fetch_object($query2)){
$sales_amt[$info->dealer_code]=($info->amount);
}


?>
<table width="100%" cellspacing="0" cellpadding="2"  border="0">
<tr><td style="border:0px;" colspan="11"><?=$str?></td></tr>
<tr>
<th>S/L</th>
<th>Shop Code</th>
<th>Shop Name</th>

<th>Order Amt</th>
<th>Sales Amt</th>

<th bgcolor="#00CCCC">Short Fall</th>
<th>Ach%</th>
</tr>
<? 
$res="select s.* from ss_shop s
where 1 
".$location." 
order by dealer_code";

$query=mysqli_query($conn,$res);
while($data=mysqli_fetch_object($query)){

if($order_amt[$data->dealer_code]>0 || $sales_amt[$data->dealer_code]>0){
$s++;
?>
<tr>
  <td><?=$s?></td>
  <td><?=$data->dealer_code?></td>
  <td><?=$data->shop_name?></td>
  
  <td><?=(int)$order_amt[$data->dealer_code]; $gorder +=$order_amt[$data->dealer_code];?></td>
  <td><?=(int)$sales_amt[$data->dealer_code]; $gsales +=$sales_amt[$data->dealer_code];?></td>
  <td><? $sfall=(int)(($sales_amt[$data->dealer_code]-$order_amt[$data->dealer_code])); $gsfall+=$sfall;
  if($sfall<0){ ?> <span style="color:red; font-weight: bold;"><?=$sfall;?> <? }else{ echo $sfall;} 
  ?></td>
  <td><?
			$ratio = (($sales_amt[$data->dealer_code]*100)/$order_amt[$data->dealer_code]);
			if($ratio<>0) {echo number_format($ratio,2); } 
  ?> % </td>
  </tr>
<? 
}
} ?>
<tr>
<td></td><td></td><td><div align="right"><strong>Total</strong></div></td>
<td><strong><?=$gorder?></strong></td>
<td><strong><?=$gsales?></strong></td>
<td><strong><?=number_format($gsfall,0);?></strong></td>
<? $gratio = (($gsales*100)/$gorder); ?>
<td><strong><?=number_format($gratio,2);?> % </strong></td>
</tr>
</table>
<?
//$str = '';

} // end 52




elseif($_REQUEST['report']==53){


if(isset($t_date)) {
$to_date=$t_date; $fr_date=$f_date; 
$date_con2=' and c.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';
$date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';

$year = date("Y",strtotime($t_date));
$mon = date("m",strtotime($t_date));
}

$location=''; $location2='';
if(isset($region_id)) 			{$location.=' and region_id="'.$region_id.'"'; $location2.=' and region_id="'.$region_id.'"';}
if(isset($zone_id)) 			{$location.=' and zone_id="'.$zone_id.'"'; $location2.=' and zone_id="'.$zone_id.'"';}
if(isset($area_id)) 			{$location.=' and area_id="'.$area_id.'"'; $location2.=' and area_code="'.$area_id.'"';}
if(isset($route_id)) 			{$location.=' and route_id="'.$route_id.'"'; $location2.=' and route_id="'.$route_id.'"';}

if($_POST['so']>0) 				{$so_con.=' and s.emp_code="'.$so.'"';}

if($_POST['dealer_code']>0) 	{
    $dealer_con.=' and dealer_code="'.$_POST['dealer_code'].'"';
    $dealer_con2.=' and s.dealer_code="'.$_POST['dealer_code'].'"';
    $dealer_con3.=' and c.depot_id="'.$_POST['dealer_code'].'"';
}

?>
<table width="100%" cellspacing="0" cellpadding="2"  border="0">
<tr><td style="border:0px;" colspan="11"><?=$str?></td></tr>
<tr>
<th>S/L</th>
<th>Chalan Date</th><th>Chalan No</th>
<th>Shop Name</th>
<th>TP Amt</th>
<th>Sales Amt</th>
<th>Trade Offer</th>
</tr>
<? 
$res='select c.*,s.shop_name, sum(c.total_tp) as tp,sum(c.total_amt) as amount,sum(c.total_tp-c.total_amt) as nsp_amount
from item_info i, ss_do_chalan c, ss_shop s
where i.item_id=c.item_id and s.dealer_code=c.dealer_code 
'.$date_con.$item_con.$location.$so_con.$dealer_con3.'
group by chalan_no order by chalan_no';
$query=mysqli_query($conn,$res);
while($data=mysqli_fetch_object($query)){
$s++;
?>
<tr>
  <td><?=$s?></td>
  <td><?=$data->chalan_date?></td>
  <td><?=$data->chalan_no?></td>
  <td><?=$data->shop_name?></td>
  <td><?=(int)$data->tp; $gtp +=$data->tp;?></td>
  <td><?=(int)$data->amount; $gsales +=$data->amount;?></td>
  <td><?=(int)$data->nsp_amount; $gnsp +=$data->nsp_amount;?></td>
</tr>
<? } ?>
<tr>
    <td colspan="4"><div align="right"><strong>Total</strong></div></td>
    <td><strong><?=(int)$gtp?></strong></td>
    <td><strong><?=(int)$gsales?></strong></td>
    <td><strong><?=(int)$gnsp?></strong></td>
</tr>
</table>
<?

} // end 53




elseif($_REQUEST['report']==54){


if(isset($t_date)) {
$to_date=$t_date; $fr_date=$f_date; 
$date_con2=' and c.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';
$date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';

$year = date("Y",strtotime($t_date));
$mon = date("m",strtotime($t_date));
}

$location=''; $location2='';
if(isset($region_id)) 			{$location.=' and region_id="'.$region_id.'"'; $location2.=' and region_id="'.$region_id.'"';}
if(isset($zone_id)) 			{$location.=' and zone_id="'.$zone_id.'"'; $location2.=' and zone_id="'.$zone_id.'"';}
if(isset($area_id)) 			{$location.=' and area_id="'.$area_id.'"'; $location2.=' and area_code="'.$area_id.'"';}
if(isset($route_id)) 			{$location.=' and route_id="'.$route_id.'"'; $location2.=' and route_id="'.$route_id.'"';}

if($_POST['so']>0) 				{$so_con.=' and s.emp_code="'.$so.'"';}

if($_POST['dealer_code']>0) 	{
    $dealer_con.=' and dealer_code="'.$_POST['dealer_code'].'"';
    $dealer_con2.=' and s.dealer_code="'.$_POST['dealer_code'].'"';
    $dealer_con3.=' and c.depot_id="'.$_POST['dealer_code'].'"';
}

?>
<table width="100%" cellspacing="0" cellpadding="2"  border="0">
<tr><td style="border:0px;" colspan="11"><?=$str?></td></tr>
<tr>
<th>S/L</th>
<th>Shop Code</th>
<th>Shop Name</th>
<th>Shop Address</th>
<th>TP Amt</th>
<th>Sales Amt</th>
<th>Trade Offer</th>
</tr>
<? 
$res='select c.*,s.shop_name,s.shop_address, sum(c.total_tp) as tp, sum(c.total_amt) as amount,sum(c.total_tp-c.total_amt) as nsp_amount
from item_info i, ss_do_chalan c, ss_shop s
where i.item_id=c.item_id and s.dealer_code=c.dealer_code 
'.$date_con.$item_con.$location.$so_con.$dealer_con3.'
group by dealer_code order by shop_name';
$query=mysqli_query($conn,$res);
while($data=mysqli_fetch_object($query)){
$s++;
?>
<tr>
  <td><?=$s?></td>
  <td><?=$data->dealer_code?></td>
  <td><?=$data->shop_name?></td>
  <td><?=$data->shop_address?></td>
  <td><?=(int)$data->tp; $gtp +=$data->tp;?></td>
  <td><?=(int)$data->amount; $gsales +=$data->amount;?></td>
  <td><?=(int)$data->nsp_amount; $gnsp +=$data->nsp_amount;?></td>
</tr>
<? } ?>
<tr>
    <td colspan="4"><div align="right"><strong>Total</strong></div></td>
    <td><strong><?=(int)$gtp?></strong></td>
    <td><strong><?=(int)$gsales?></strong></td>
    <td><strong><?=(int)$gnsp?></strong></td>
</tr>
</table>
<?

} // end 54





elseif($_REQUEST['report']==55){


if(isset($t_date)) {
$to_date=$t_date; $fr_date=$f_date; 
$date_con2=' and c.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';
$date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';

$year = date("Y",strtotime($t_date));
$mon = date("m",strtotime($t_date));
}

$location=''; $location2='';
if(isset($region_id)) 			{$location.=' and region_id="'.$region_id.'"'; $location2.=' and region_id="'.$region_id.'"';}
if(isset($zone_id)) 			{$location.=' and zone_id="'.$zone_id.'"'; $location2.=' and zone_id="'.$zone_id.'"';}
if(isset($area_id)) 			{$location.=' and area_id="'.$area_id.'"'; $location2.=' and area_code="'.$area_id.'"';}
if(isset($route_id)) 			{$location.=' and route_id="'.$route_id.'"'; $location2.=' and route_id="'.$route_id.'"';}

if($_POST['so']>0) 				{$so_con.=' and s.emp_code="'.$so.'"';}

if($_POST['dealer_code']>0) 	{
    $dealer_con.=' and dealer_code="'.$_POST['dealer_code'].'"';
    $dealer_con2.=' and s.dealer_code="'.$_POST['dealer_code'].'"';
    $dealer_con3.=' and c.depot_id="'.$_POST['dealer_code'].'"';
}

?>
<table width="100%" cellspacing="0" cellpadding="2"  border="0">
<tr><td style="border:0px;" colspan="11"><?=$str?></td></tr>
<tr>
<th>S/L</th>
<th>Chalan No</th><th>Chalan Date</th>
<th>Shop Code</th><th>Shop Name</th><th>Shop Address</th>
<th>Item Code</th><th>Item Name</th>
<th>TP Amt</th><th>Sales Amt</th><th>Trade Offer</th>
</tr>
<? 
$res='select c.*,i.item_name,s.shop_name,s.shop_address, c.total_tp as tp, c.total_amt as amount,c.total_tp-c.total_amt as nsp_amount
from item_info i, ss_do_chalan c, ss_shop s
where i.item_id=c.item_id and s.dealer_code=c.dealer_code 
'.$date_con.$item_con.$location.$so_con.$dealer_con3.'
order by chalan_no';
$query=mysqli_query($conn,$res);
while($data=mysqli_fetch_object($query)){
$s++;
?>
<tr>
  <td><?=$s?></td>
  <td><?=$data->chalan_no?></td>
  <td><?=$data->chalan_date?></td>
  
  <td><?=$data->dealer_code?></td>
  <td><?=$data->shop_name?></td>
  <td><?=$data->shop_address?></td>
  
  <td><?=$data->item_id?></td>
  <td><?=$data->item_name?></td>
  
  <td><?=(int)$data->tp; $gtp +=$data->tp;?></td>
  <td><?=(int)$data->amount; $gsales +=$data->amount;?></td>
  <td><?=(int)$data->nsp_amount; $gnsp +=$data->nsp_amount;?></td>
</tr>
<? } ?>
<tr>
    <td colspan="8"><div align="right"><strong>Total</strong></div></td>
    <td><strong><?=(int)$gtp?></strong></td>
    <td><strong><?=(int)$gsales?></strong></td>
    <td><strong><?=(int)$gnsp?></strong></td>
</tr>
</table>
<?

} // end 55











elseif($_REQUEST['report']==101){

$location=''; $location2='';
if(isset($t_date)) {
$to_date=$t_date; $fr_date=$f_date; 
$date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';

$year = date("Y",strtotime($t_date));
$mon = date("m",strtotime($t_date));
}


if(isset($region_id)) 			{$location.=' and region_id="'.$region_id.'"'; $location2.=' and region_id="'.$region_id.'"';}
if(isset($zone_id)) 			{$location.=' and zone_id="'.$zone_id.'"'; $location2.=' and zone_id="'.$zone_id.'"';}
if(isset($area_id)) 			{$location.=' and area_id="'.$area_id.'"'; $location2.=' and area_code="'.$area_id.'"';}
if(isset($route_id)) 			{$location.=' and route_id="'.$route_id.'"'; $location2.=' and route_id="'.$route_id.'"';}

if($_POST['so_code']>0) 				{$so_con.=' and s.emp_code="'.$so_code.'"';}

if($_POST['dealer_code']>0) 	{
    $dealer_con.=' and dealer_code="'.$_POST['dealer_code'].'"';
    $dealer_con2.=' and s.dealer_code="'.$_POST['dealer_code'].'"';
    $dealer_con3.=' and c.depot_id="'.$_POST['dealer_code'].'"';
}


// item wise target
if($_POST['so_code']>0){
$emp_code=$_POST['so_code'];

$tc = "select target_con from ss_target_ratio where emp_code='".$emp_code."' and target_year='".$year."' and target_month='".$mon."' ";
$target_con = find1($tc);
if($target_con<1){ $target_con=100;}

//$dealer_code = find1("select master_dealer_code from ss_shop where emp_code='".$emp_code."'");
$dealer_code = $_POST['dealer_code'];

$sql_target="select t.item_id,t.target_ctn,target_amount,i.pack_size 
from sale_target_upload t, item_info i where i.item_id=t.item_id 
and target_year='".$year."' and target_month='".$mon."' and dealer_code='".$dealer_code."'";
$query1 = mysqli_query($conn,$sql_target);
while($info=mysqli_fetch_object($query1)){
$target_qty[$info->item_id]=(($info->target_ctn*$info->pack_size)*$target_con)/100;
$target_amt[$info->item_id]=($info->target_amount*$target_con)/100;
}
}else{

$sql_target="select t.item_id,sum(t.target_ctn) as target_ctn,sum(t.target_amount) as target_amount,i.pack_size 
from sale_target_upload t, item_info i 
where i.item_id=t.item_id and target_year='".$year."' and target_month='".$mon."' 
".$location.$dealer_con."
group by i.item_id";
$query1 = mysqli_query($conn,$sql_target);
	while($info=mysqli_fetch_object($query1)){
	$target_qty[$info->item_id]=($info->target_ctn*$info->pack_size);
	$target_amt[$info->item_id]=($info->target_amount);
	}
}


//--------------- Item wise Primary sales -----------------		
$sql_ssales='select i.item_id, i.item_name,i.unit_name, sum(c.total_unit) as qty,sum(c.total_amt) as amount
from item_info i, sale_do_chalan c, dealer_info s
where i.item_id=c.item_id and s.dealer_code=c.dealer_code 
'.$date_con.$item_con.$location2.$so_con.$dealer_con2.'
and c.total_amt>0
group by item_id order by item_id';
$query3 = mysqli_query($conn,$sql_ssales);
while($info=mysqli_fetch_object($query3)){
$ssales_qty[$info->item_id]=($info->qty);
$ssales_amt[$info->item_id]=($info->amount);
}



		
//--------------- Item wise secondary sales -----------------		
$sql_sales='select i.item_id, i.item_name,i.unit_name, sum(c.total_unit) as qty,sum(c.total_amt) as amount
from item_info i, ss_do_chalan c, ss_shop s
where i.item_id=c.item_id and s.dealer_code=c.dealer_code 
'.$date_con.$item_con.$location.$so_con.$dealer_con3.'
group by item_id order by item_id';
$query2 = mysqli_query($conn,$sql_sales);
while($info=mysqli_fetch_object($query2)){
$sales_qty[$info->item_id]=($info->qty);
$sales_amt[$info->item_id]=($info->amount);
}




?>
<table width="100%" cellspacing="0" cellpadding="2"  border="0">
<tr><td style="border:0px;" colspan="11"><?=$str?></td></tr>
<tr>
<th>S/L</th>
<th>FG Code</th>
<th>Item Name</th>
<th bgcolor="#00CCCC">Target CTN</th>
<th>Target Amt</th>

<th>P Sales Ctn </th>
<th>Pri Sales Amt</th>

<th>P SFall</th>
<th>P Ach%</th>
<th bgcolor="#00CCCC">S Sales CTN</th>
<th>S Sales Tqty</th>
<th>S Sales Amt</th>
<th bgcolor="#00CCCC">S SFall</th>
<th>SAch%</th>
</tr>
<? 
$res="select i.* from item_info i where 1 
".$item_con." order by finish_goods_code";
$query=mysqli_query($conn,$res);
while($data=mysqli_fetch_object($query)){

if($target_qty[$data->item_id]>0 || $sales_qty[$data->item_id]>0){
$s++;
?>
<tr>
  <td><?=$s?></td>
  <td><?=$data->finish_goods_code?></td>
  <td><?=$data->item_name?></td>
  <td><?=(int)($target_qty[$data->item_id]/$data->pack_size);?></td>
  <td><?=(int)$target_amt[$data->item_id]; $gtarget +=$target_amt[$data->item_id];?></td>
  
  <td><?=(int)($ssales_qty[$data->item_id]/$data->pack_size);?></td>
  <td><?=(int)$ssales_amt[$data->item_id]; $gssales +=$ssales_amt[$data->item_id];?></td> 
  <td><? $ssfall=(int)(($ssales_qty[$data->item_id]-$target_qty[$data->item_id])/$data->pack_size); $gssfall+=$ssfall;
  if($ssfall<0){ ?>
    <span style="color:red; font-weight: bold;">
    <?=$ssfall;?>
    <? }else{ echo $ssfall;} 
  ?>
    </span></td>
  <td><?
			$ratio2 = (($ssales_amt[$data->item_id]*100)/$target_amt[$data->item_id]);
			if($ratio2<>0) {echo number_format($ratio2,2); } 
  ?> % </td>
  
  
  <td><?=(int)($sales_qty[$data->item_id]/$data->pack_size);?></td>
  <td><?=(int)($sales_qty[$data->item_id]);?></td>
  <td><?=(int)$sales_amt[$data->item_id]; $gsales +=$sales_amt[$data->item_id];?></td>
  <td><? $sfall=(int)(($sales_qty[$data->item_id]-$target_qty[$data->item_id])/$data->pack_size); $gsfall+=$sfall;
  if($sfall<0){ ?> <span style="color:red; font-weight: bold;"><?=$sfall;?> <? }else{ echo $sfall;} 
  ?></td>
  <td><?
			$ratio = (($sales_amt[$data->item_id]*100)/$target_amt[$data->item_id]);
			if($ratio<>0) {echo number_format($ratio,2); } 
  ?> % </td>
  </tr>
<? }} ?>
<tr>
<td></td><td></td><td><div align="right"><strong>Total</strong></div></td><td><strong>
  <? //=$gqty?></strong></td>
<td><strong><?=$gtarget?></strong></td>
<td></td>
<td><strong><?=$gssales?></strong></td>
<td></td>
<td></td>
<td></td><td></td>
<td><strong><?=$gsales?></strong></td>
<td><strong><?=number_format($gsfall,0);?></strong></td>
<? $gratio = (($gsales*100)/$gtarget); ?>
<td><strong><?=number_format($gratio,2);?> % </strong></td>
</tr>
</table>
<?
//$str = '';

} // end 101




elseif($_REQUEST['report']==102){

$location='';
if(isset($t_date)) {
$to_date=$t_date; $fr_date=$f_date; 
$date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';
$date_con2=' and c.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';

$year = date("Y",strtotime($t_date));
$smon = date("m",strtotime($f_date));
$tmon = date("m",strtotime($t_date));
}

if(isset($product_group)) {$pg_con=' and s.product_group="'.$product_group.'"';
$pg_con2=' and t.grp="'.$product_group.'"';
}

if(isset($region_id)) 			{$location.=' and region_id="'.$region_id.'"';}
if(isset($zone_id)) 			{$location.=' and zone_id="'.$zone_id.'"';}
if(isset($area_id)) 			{$location.=' and area_id="'.$area_id.'"';}


if($_POST['dealer_code']>0) 	{
    $dealer_con.=' and dealer_code="'.$_POST['dealer_code'].'"';
    $dealer_con2.=' and s.dealer_code="'.$_POST['dealer_code'].'"';
    $dealer_con3.=' and c.depot_id="'.$_POST['dealer_code'].'"';
}

// -------------- Item wise target --------------
$sql_target="select t.dealer_code as code,sum(t.target_ctn) as target_ctn,sum(t.target_amount) as target_amount,i.pack_size 
from sale_target_upload t, item_info i 
where i.item_id=t.item_id and target_year='".$year."' and target_month between ".$smon." and ".$tmon." 
".$location.$dealer_con."
group by code";
$query1 = mysqli_query($conn,$sql_target);
while($info=mysqli_fetch_object($query1)){
$target_qty[$info->code]=($info->target_ctn*$info->pack_size);
$target_amt[$info->code]=($info->target_amount);
}

		
//--------------- Item wise sales -----------------		
$sql_sales='select c.depot_id as code, sum(c.total_unit) as qty,sum(c.total_amt) as amount
from item_info i, ss_do_chalan c, ss_shop s
where i.item_id=c.item_id and s.dealer_code=c.dealer_code 
'.$date_con.$pg_con.$location.$dealer_con3.'
group by code order by code';
$query2 = mysqli_query($conn,$sql_sales);
while($info=mysqli_fetch_object($query2)){
$sales_qty[$info->code]=($info->qty);
$sales_amt[$info->code]=($info->amount);
}



//--------------- Item wise Order -----------------		
$sql_sales='select m.depot_id as code, sum(c.total_unit) as qty,sum(c.total_amt) as amount
from item_info i, ss_do_details c, ss_shop s, ss_do_master m
where i.item_id=c.item_id and s.dealer_code=c.dealer_code and m.do_no=c.do_no
'.$date_con2.$pg_con.$location.$dealer_con3.'
and m.status in("CHECKED","COMPLETED")
group by code order by code';
$query2 = mysqli_query($conn,$sql_sales);
while($info=mysqli_fetch_object($query2)){
$order_amt[$info->code]=($info->amount);
}


//--------------- Primary DO -----------------		
$sql_pdo='select s.dealer_code as code, sum(c.total_unit) as qty,sum(c.total_amt) as amount
from item_info i, sale_do_details c, dealer_info s, sale_do_master m
where i.item_id=c.item_id and s.dealer_code=c.dealer_code and m.do_no=c.do_no and m.status in("CHECKED","COMPLETED") 
'.$date_con2.$pg_con.$location.$dealer_con3.'
group by code order by code';
$query5 = mysqli_query($conn,$sql_pdo);
while($info=mysqli_fetch_object($query5)){
$pri_do[$info->code]=($info->amount);
}


//--------------- Primary Chalan -----------------		
$sql_pch='select s.dealer_code as code, sum(c.total_unit) as qty,sum(c.total_amt) as amount
from item_info i, sale_do_chalan c, dealer_info s
where i.item_id=c.item_id and s.dealer_code=c.dealer_code '.$date_con.$pg_con.$location.$dealer_con3.'
group by code order by code';
$query6 = mysqli_query($conn,$sql_pch);
while($info=mysqli_fetch_object($query6)){
$pri_chalan[$info->code]=($info->amount);
}


//--------------- Dealer wise NSP Dis amount -----------------		
$sql_nsp='select c.depot_id as code, sum(c.total_tp-c.total_amt) as amount
from item_info i, ss_do_chalan c, ss_shop s
where i.item_id=c.item_id and s.dealer_code=c.dealer_code 
'.$date_con.$pg_con.$location.$dealer_con3.'
group by code order by code';

$query2 = mysqli_query($conn,$sql_nsp);
while($info=mysqli_fetch_object($query2)){
$nsp_amt[$info->code]=($info->amount);
}



?>
<table width="100%" cellspacing="0" cellpadding="2"  border="0">
<tr><td style="border:0px;" colspan="17"><?=$str?></td></tr>
<tr>
<th>S/L</th>
<th>Region</th><th>Zone</th><th>Area</th>
<th>Dealer Code</th>
<th>Dealer Name</th>
<th bgcolor="#00FFFF">Target Amt</th>

<th bgcolor="#00CC66">Pri DO</th>
<th bgcolor="#00CC66">SFall</th>
<th bgcolor="#00CC66">Ach%</th>
<th bgcolor="#9966FF">Pri Sale</th>
<th bgcolor="#9966FF">SFall</th>
<th bgcolor="#9966FF">Ach%</th>

<th>Order Amt</th>
<th bgcolor="#FF9933">Sales Amt</th>
<th bgcolor="#FF9933">SFall</th>
<th bgcolor="#FF9933">Ach%</th>
<th>NSP Dis</th>
</tr>
<? 
$res="select dealer_code as code,d.* 
from dealer_info d where 1 
".$location.$dealer_con."
order by region_id,zone_id,area_code,dealer_code";
$query=mysqli_query($conn,$res);
while($data=mysqli_fetch_object($query)){

// if($target_amt[$data->code]<>0 ||
// $pri_do[$data->code]<>0 ||
// $pri_chalan[$data->code]<>0 ||
// $order_amt[$data->code]<>0 ||
// $sales_amt[$data->code]<>0
//  ){
$s++;
?>
<tr>
<td><?=$s?></td>
<td><?=find_a_field('branch','BRANCH_NAME','BRANCH_ID="'.$data->region_id.'"');?></td> 
<td><?=find_a_field('zon','ZONE_NAME','ZONE_CODE="'.$data->zone_id.'"');?></td> 
<td><?=find_a_field('area','AREA_NAME','AREA_CODE="'.$data->area_code.'"');?></td> 
<td><?=$data->dealer_code?></td>
<td><?=$data->dealer_name_e?></td>
<td><?=(int)$target_amt[$data->code]; $gtarget +=$target_amt[$data->code];?></td>  

<td><?=(int)$pri_do[$data->code]; $gpdo +=$pri_do[$data->code];?></td>
<td><? $diff1=(int)($pri_do[$data->code]-$target_amt[$data->code]); $gap1 +=$diff1;
if($diff1<0){ ?> <span style="color:red; font-weight: bold;"><?=$diff1;?> <? }else{ echo $diff1;} ?></td>
<td><? $ratio1 = (($pri_do[$data->code]*100)/$target_amt[$data->code]); if($ratio1<>0) {echo number_format($ratio1,2); } ?>%</td>

<td><?=(int)$pri_chalan[$data->code]; $gpch +=$pri_chalan[$data->code];?></td>
<td><? $diff2=(int)($pri_chalan[$data->code]-$target_amt[$data->code]); $gap2 +=$diff2;
if($diff2<0){ ?> <span style="color:red; font-weight: bold;"><?=$diff2;?> <? }else{ echo $diff2;} 
?></td>
<td><? $ratio2 = (($pri_chalan[$data->code]*100)/$target_amt[$data->code]); if($ratio2<>0) {echo number_format($ratio2,2); } ?>%</td>


<td><?=(int)$order_amt[$data->code]; $gorder +=$order_amt[$data->code];?></td>
  
  <td><?=(int)$sales_amt[$data->code]; $gsales +=$sales_amt[$data->code];?></td>
  <td><? $diff=(int)($sales_amt[$data->code]-$target_amt[$data->code]); $gap +=$diff;
  if($diff<0){ ?> <span style="color:red; font-weight: bold;"><?=$diff;?> <? }else{ echo $diff;} ?></td>
  <td><?
$ratio = (($sales_amt[$data->code]*100)/$target_amt[$data->code]);
if($ratio<>0) {echo number_format($ratio,2); } 
  ?>%</td>

<td><?=$nsp_amt[$data->code]; $gnsp+=$nsp_amt[$data->code]; ?></td>
</tr>
<? 
//} // end if value 0

$target_amt[$data->code]='';
$pri_do[$data->code]='';
$pri_chalan[$data->code]='';
$order_amt[$data->code]='';
$sales_amt[$data->code]='';

} // end while
 ?>
<tr>
<td></td><td></td><td></td><td></td><td></td>
<td><div align="right"><strong>Total</strong></div></td>
<td bgcolor="#00FFFF"><strong><?=(int)$gtarget?></strong></td>

<td bgcolor="#00CC66"><strong><?=(int)$gpdo?></strong></td>
<td bgcolor="#00CC66"><strong><?=(int)$gap1?></strong></td>
<td bgcolor="#00CC66"><strong>
<? $gratio1 = (($gpdo*100)/$gtarget);?> 
<?=number_format($gratio1,2);?>%</strong></td>
<td bgcolor="#9966FF"><strong><?=(int)$gpch?></strong></td>
<td bgcolor="#9966FF"><strong><?=(int)$gap2?></strong></td>
<td bgcolor="#9966FF"><strong>
<? $gratio2 = (($gpch*100)/$gtarget);?>  
<?=number_format($gratio2,2);?>%</strong></td>

<td><strong><?=(int)$gorder?></strong></td>

<td bgcolor="#FF9933"><strong><?=(int)$gsales?></strong></td>
<td bgcolor="#FF9933"><strong><?=(int)$gap?></strong></td>
<? $gratio = (($gsales*100)/$gtarget);?>
<td bgcolor="#FF9933"><strong><?=number_format($gratio,2);?>%</strong></td>
<td><strong><?=(int)$gnsp?></strong></td>
</tr>
</table>
<?
//$str = '';

} // end 102








elseif($_REQUEST['report']==103){


$location='';
if(isset($t_date)) {
$to_date=$t_date; $fr_date=$f_date; 
$date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';
$date_con2=' and c.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';

$year = date("Y",strtotime($t_date));
$mon = date("m",strtotime($t_date));
}

if(isset($product_group)) {$pg_con=' and s.product_group="'.$product_group.'"';
$pg_con2=' and t.grp="'.$product_group.'"';
}

if(isset($region_id)) 			{$location.=' and region_id="'.$region_id.'"';}
if(isset($zone_id)) 			{$location.=' and zone_id="'.$zone_id.'"';}
if(isset($area_id)) 			{$location.=' and area_id="'.$area_id.'"';}

if($_POST['dealer_code']>0) 	{
    $dealer_con.=' and dealer_code="'.$_POST['dealer_code'].'"';
    $dealer_con2.=' and s.dealer_code="'.$_POST['dealer_code'].'"';
    $dealer_con3.=' and c.depot_id="'.$_POST['dealer_code'].'"';
}

// -------------- Dealer Wise Target --------------
$sql_target="select t.so_code as code, sum(t.target_amt) as target_amount 
from sale_target_so t 
where target_year='".$year."' and target_month='".$mon."' 
".$dealer_con."
group by code";
$query1 = mysqli_query($conn,$sql_target);
while($info=mysqli_fetch_object($query1)){
$target_dealer_amt[$info->code]=($info->target_amount);
}



// -------------- Memo Count --------------
$sql_memo="select s.username as code,sum(m.memo) as memo
from ss_do_master m, ss_user s 
where m.entry_by=s.username
and m.do_date between '".$f_date."' and '".$t_date."' 
and m.status in ('CHECKED','COMPLETED')
".$location.$pg_con.$dealer_con3."
group by code";
$query3 = mysqli_query($conn,$sql_memo);
while($info3=mysqli_fetch_object($query3)){
$memo[$info3->code]=$info3->memo;
}



// -------------- Order Amount --------------
$sql_target="select s.username as code, sum(c.total_amt) as amount
from ss_do_master m, ss_do_details c, ss_user s
where m.do_no=c.do_no and s.username=m.entry_by
and m.do_date between '".$f_date."' and '".$t_date."' 
and m.status in ('CHECKED','COMPLETED')
".$location.$pg_con.$dealer_con3."
group by code";
$query1 = mysqli_query($conn,$sql_target);
while($info=mysqli_fetch_object($query1)){
$order_amt[$info->code]=($info->amount);
}

		
//--------------- Delivery Amount -----------------		
$sql_sales='select s.username as code,sum(c.total_amt) as amount
from ss_do_chalan c, ss_user s
where s.username=c.entry_by '.$date_con.$pg_con.$location.$dealer_con3.'
group by code order by code';
$query2 = mysqli_query($conn,$sql_sales);
while($info=mysqli_fetch_object($query2)){
$sales_amt[$info->code]=($info->amount);
}


?>
<table width="100%" cellspacing="0" cellpadding="2"  border="0">
<tr><td style="border:0px;" colspan="9"><?=$str?></td></tr>
<tr>
<th>S/L</th>
<th>Region</th><th>Zone</th><th>Area</th>
<th>Dealer Info</th>
<th>SO Code</th>
<th>SO Name</th>
<th>Target</th>
<th>Memo</th>
<th>Order</th>
<th>Delivery</th>
<th>D/T%</th>
</tr>
<? 
$res="select username as code,s.* 
from ss_user s
where 1 
".$location.$dealer_con."
order by region_id,zone_id,area_id,dealer_code,code";
$query=mysqli_query($conn,$res);
while($data=mysqli_fetch_object($query)){
$s++;
$dealer_info= findall('select dealer_code,dealer_name_e from dealer_info where dealer_code="'.$data->dealer_code.'" and canceled="No" ');
?>
<tr>
    <td><?=$s?></td>
    <td><?=find_a_field('branch','BRANCH_NAME','BRANCH_ID="'.$data->region_id.'"');?></td> 
    <td><?=find_a_field('zon','ZONE_NAME','ZONE_CODE="'.$data->zone_id.'"');?></td> 
    <td><?=find_a_field('area','AREA_NAME','AREA_CODE="'.$data->area_id.'"');?></td> 
    <td><?=$dealer_info->dealer_code?>-<?=$dealer_info->dealer_name_e?></td>
    
    <td><?=$data->code?></td>
    <td><?=$data->fname?></td>
    <td><? echo $so_target = $target_dealer_amt[$data->code]; $gso_target +=  $so_target; ?></td>
  
    <td><?=$memo[$data->code]; $gmemo +=$memo[$data->code];?></td>

    <td><?=$order_amt[$data->code]; $gorder_amt +=$order_amt[$data->code];?></td>
    <td><?=$sales_amt[$data->code]; $gsales_amt +=$sales_amt[$data->code];?></td>
<td>
<? 
echo $per = number_format(($sales_amt[$data->code]/$so_target)*100,2);
?> %</td>
</tr>
<? 

$target_dealer_amt[$data->code]='';
$memo[$data->code]='';
$order_amt[$data->code]='';
$sales_amt[$data->code]='';


} ?>
<tr>
<td></td><td></td><td></td><td></td><td></td><td></td>
<td><div align="right"><strong>Total</strong></div></td>
<td><strong><?=$gso_target?></strong></td>
<td><strong><?=$gmemo?></strong></td>
<td><strong><?=$gorder_amt?></strong></td>
<td><strong><?=$gsales_amt;?></strong></td>

<td><strong>
<?
echo $gper = number_format(($gsales_amt/$gso_target)*100,2);
?> %</strong></td>
</tr>
</table>
<?
//$str = '';

} // end







elseif($_REQUEST['report']==104){
    
$report="Dealer Stock Report";
$dealer_code = $_POST['dealer_code'];

if($dealer_code==''){ die("Please Select Dealer Code");}

if(isset($t_date)) {
$date_con=' and c.chalan_date between \''.$f_date.'\' and \''.$t_date.'\'';

$year = date("Y",strtotime($t_date));
$mon = date("m",strtotime($t_date));
}

//$opening_date = find1("select max(ji_date) from ss_journal_item where tr_from='".Opening."' and warehouse_id='".$dealer_code."' ");

$opening_date= '2021-01-01';

$sql_in="select item_id, sum(total_unit) as qty 
from sale_do_chalan 
where chalan_date>='".$opening_date."' and dealer_code='".$dealer_code."' group by item_id";
$query1 = mysqli_query($conn,$sql_in);
while($info1=mysqli_fetch_object($query1)){
$item_in[$info1->item_id]=$info1->qty;
}


$sql2="select item_id,sum(item_in-item_ex) as qty
from ss_journal_item
where warehouse_id='".$dealer_code."' and ji_date>='".$opening_date."'
group by item_id";
$query2 = mysqli_query($conn,$sql2);
while($info2=mysqli_fetch_object($query2)){
$item_ss[$info2->item_id]=$info2->qty;
}


?>
<?=$str?>
<table width="100%" cellspacing="0" cellpadding="2"  border="0">
<tr>
<th>S/L</th>
<th>FG Code</th>
<th>Item Name</th>
<th>Stock Qty(Pcs)</th><th>Stock Ctn</th>
<th>Stock Amount</th>
</tr>
<? 
$sql_list="select item_id,finish_goods_code as code,item_name,pack_size,t_price from item_info where 1 ";
$query = mysqli_query($conn,$sql_list);
while($data=mysqli_fetch_object($query)){


$qty = ($item_ss[$data->item_id]+$item_in[$data->item_id]);
if($qty<>0){
$s++;
?>
<tr>
  <td><?=$s?></td>
  <td><?=$data->code?></td>
  <td><?=$data->item_name?></td>
  <td><? $qty=(int)$qty;
  if($qty<0){ ?> <span style="color:red; font-weight: bold;"><?=$qty;?> <? }else{ echo $qty;} 
  ?></td>
  <td><?=(int)($qty/$data->pack_size);?></td>
  <td><?=(int)$amt=($qty*$data->t_price); $gamt +=$amt;?></td>
  </tr>
<? 
$qty=0;
}} ?>
<tr>
<td></td><td></td><td></td><td></td><td>Total</td>
<td><?=number_format($gamt,2);?></td>
</tr>
</table>
<? 
} // end 104







elseif($_REQUEST['report']==904){
 
// region list
$sql='select BRANCH_ID  as region_id,BRANCH_NAME as region_name from branch';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){$region_info[$info->region_id] = $info->region_name;}

// zone list
$sql='select ZONE_CODE as zone_id,ZONE_NAME as zone_name from zon';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){$zone_info[$info->zone_id] = $info->zone_name;}

// area list
$sql='select AREA_CODE as area_id,AREA_NAME as area_name from area';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){$area_info[$info->area_id] = $info->area_name;} 

// route list
$sql='select route_id,route_name from ss_route';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){$route_info[$info->route_id] = $info->route_name;}  

// user wise dealer code
$sql='select username,dealer_code from ss_user';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){
    $dealer_info[$info->username] = $info->dealer_code;
} 

// dealer info table
$sql='select dealer_code,dealer_name_e,dealer_code2 from dealer_info';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){
    $dealer_name[$info->dealer_code] = $info->dealer_name_e;
    $dealer_id[$info->dealer_code] = $info->dealer_code2;
}  

$location=''; $location2='';
if(isset($region_id)) 			{$location.=' and region_id="'.$region_id.'"'; $location2.=' and region_id="'.$region_id.'"';}
if(isset($zone_id)) 			{$location.=' and zone_id="'.$zone_id.'"'; $location2.=' and zone_id="'.$zone_id.'"';}
if(isset($area_id)) 			{$location.=' and area_id="'.$area_id.'"'; $location2.=' and area_code="'.$area_id.'"';}
if(isset($route_id)) 			{$location.=' and route_id="'.$route_id.'"'; $location2.=' and route_id="'.$route_id.'"';}
    
?>
<?=$str?>
<table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">
<thead>
<tr>
<th>S/L</th>
<th>Zone</th>
<th>Territory</th>
<th>Route Name</th>
<th>Route Points</th>


<th>Distributor Code</th>
<th>Distributor Name</th>

<th>Shop Code</th>
<th>Shop Name</th>
<th>Full Address</th>
<th>SP Code</th>

<th>Owner Name</th>
<th>Owner Mobile</th>
<th>Manager Name</th>
<th>Manager Mobile</th>


<th>Type</th>


<th>Image</th>
<th>Map</th>
</thead>
</tr>
<? 
$sql_list="select * from ss_shop d where 1 
".$location."
order by region_id,zone_id,area_id,route_id,dealer_code";
$query = mysqli_query($conn,$sql_list);
while($data=mysqli_fetch_object($query)){
$s++;
?>
<tr>
  <td><?=$s?></td>
<td><?=$region_info[$data->region_id];?></td>
<td><?=$zone_info[$data->zone_id]?></td>
<td><?=$area_info[$data->area_id]?></td>
<td><?=$route_info[$data->route_id]?></td>

<td><?=$d=$dealer_info[$data->emp_code];?></td>
<td><?=$dealer_id[$d];?></td>
<td><?=$dealer_name[$d];?></td>
  

<td><?=$data->shop_name?></td>
<td><?=$data->shop_address?></td>
<td><?=$data->emp_code?></td>
  
<td><?=$data->shop_owner_name?></td>  
<td><?=$data->mobile?></td>
<td><?=$data->manager_name?></td>  
<td><?=$data->manager_mobile?></td>  


<td><?=$data->shop_type?></td>
<td><? if($data->picture!=''){ ?><a href="../sec_mobile_app/<?=$data->picture?>" target="_blank">View</a><? } ?></td>
<td><a href="https://maps.google.com/?q=<?=$data->latitude?>+<?=$data->longitude?>" target="_blank">https://maps.google.com/?q=<?=$data->latitude?>+<?=$data->longitude?></a></td>

</tr>
<? } ?>

</table>
<? 
} // end

elseif($_REQUEST['report']==125){


  if(isset($t_date)) {
  $to_date=$t_date; $fr_date=$f_date; 
  $date_con=' and do_date between \''.$fr_date.'\' and \''.$to_date.'\'';

  
  $year = date("Y",strtotime($t_date));
  $mon = date("m",strtotime($t_date));
  }
  

  
  if($_POST['so_code']>0) 				{$so_con.=' and entry_by="'.$_POST['so_code'].'"';}
  

  
  $s=0;
	

  
  
  
  
  ?>
<div>
<?=$str?>
</div>
<table width="80%" cellspacing="0" cellpadding="2"  border="0">
  
  <tr>
  <th>S/L</th>
  <th>SO Code</th>
  <th>SO Name</th>
  <th>Shop Name</th>
  <th>Date</th>
  <th>Uploads Files</th>

  </tr>

  <? 
  $res='SELECT * FROM ss_doc_master WHERE 1'.$so_con. $date_con;
  $query=mysqli_query($conn,$res);
  while($data=mysqli_fetch_object($query)){
    $s++;
$so_name=find_a_field('ss_user','fname','username="'.$data->entry_by.'"');
$shop_name=find_a_field('ss_shop','shop_name','dealer_code="'.$data->dealer_code.'"');
  
  ?>

  <tr>
  <td><?=$s?></td>
  <td><?=$data->entry_by?></td>
  <td><?=$so_name?></td>
  <td><?=$shop_name?></td>
  <td><?=$data->do_date?></td>
   <td><a href="rx_image_view.php?do_no=<?=$data->do_no?>&so_name=<?=$so_name?>&date=<?=$data->do_date?>&shop_name=<?=$shop_name?>" target="blank">see files</a></td>
>
  </tr>





    
 

 

  <? } ?>
  </table>

  <?
  //$str = '';
  } // end 51
// dealer wise stock report
elseif($_POST['report']==105) {
 
if(isset($item_id)) 				{$item_id_con=' and i.item_id='.$item_id;} 
if(isset($dealer_code)) {
$dealer_con=' and dealer_code='.$dealer_code;
$dealer_con2=' and warehouse_id='.$dealer_code;
}
			
if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; 
						
			
$date_con=' and do_date between "'.$fr_date.'" and "'.$to_date.'" ';
$chalan_date_con=' and chalan_date between "'.$fr_date.'" and "'.$to_date.'" ';
$date_damage_con=' and or_date between "'.$fr_date.'" and "'.$to_date.'" ';}

if(isset($region_id)) 			{$location.=' and d.region_id="'.$region_id.'"';}
if(isset($zone_id)) 			{$location.=' and d.zone_id="'.$zone_id.'"';}
if(isset($area_id)) 			{$location.=' and d.area_id="'.$area_id.'"';}

// Opening date calculation
/*$sql_op="select warehouse_id as dealer_code,max(ji_date) as opening_date 
from ss_journal_item where tr_from='Opening' and warehouse_id>0 group by warehouse_id order by warehouse_id ";
$query_op = mysql_query($sql_op);
while($info_op=mysql_fetch_object($query_op)){
$opening_date[$info_op->dealer_code]=$info_op->opening_date;
}*/


$opening_date = '2022-07-01';

// Dealer STOCK QTY
 $sql_in="select dealer_code,item_id, sum(total_unit) as qty 
from sale_do_chalan 
where chalan_date>='".$opening_date."' and unit_price>0
".$dealer_con."
group by dealer_code,item_id";
$query1 = mysqli_query($conn,$sql_in);
while($info1=mysqli_fetch_object($query1)){
	$item_in[$info1->dealer_code][$info1->item_id]=$info1->qty;
}


// SS bin card
 $sql_ss="select warehouse_id as dealer_code,item_id,sum(item_in-item_ex) as qty
from ss_journal_item
where ji_date>='".$opening_date."' and warehouse_id>0 ".$dealer_con2."
group by warehouse_id,item_id";
$query2 = mysqli_query($conn,$sql_ss);
while($info2=mysqli_fetch_object($query2)){
	$item_ss[$info2->dealer_code][$info2->item_id]=$info2->qty;
}



?>
<?=$str?>
<div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <thead>
    <tr>
      <th>S/L-105</th>
      <th>Location</th>
      <th>Dealer Code </th>
      <th>Dealer Name </th>
      <? 
// Item List
  $sql_item="select item_id,item_name,finish_goods_code 
from item_info where 1 order by finish_goods_code";
$query_item = mysqli_query($conn,$sql_item);	  
while($item_info=mysqli_fetch_object($query_item)){ ?>
      <th height="150" bgcolor="#339999"> <font class="vertical-text" style="margin-top:170px; width:5px; vertical-align:bottom"><nobr>
	  <? echo $item_info->finish_goods_code;?>-<? echo $item_info->item_name;?></nobr></font> </th>  
      <? } ?>
    </tr>
  </thead>
  <tbody>
    <?


// Dealer list
  $sql='select dealer_code as code,dealer_name_e as dealer_name, region_code,zone_code,area_code
from dealer_info d
where 1 
'.$location.$dealer_con.'
order by region_code,zone_code,area_code,dealer_code';
$query =mysqli_query($conn,$sql);
while($data=mysqli_fetch_object($query)){
$closing_qty=0;
?>
    <tr>
      <td><?=++$k?></td>
      <td><?=find_a_field('branch','BRANCH_NAME','BRANCH_ID="'.$data->region_id.'"');?>
          <br/><?=find_a_field('zon','ZONE_NAME','ZONE_CODE="'.$data->zone_id.'"');?>
        <br/><?=find_a_field('area','AREA_NAME','AREA_CODE="'.$data->area_code.'"');?>
      </td>
      <td><?=$data->code?></td>
      <td><?=$data->dealer_name?></td>


<? 
// Item List
$sql_item="select item_id,item_name,finish_goods_code from item_info where 1 order by finish_goods_code";
$query_item = mysqli_query($conn,$sql_item);
	 while($item_info=mysqli_fetch_object($query_item)){ 
		$closing_qty = ($item_in[$data->code][$item_info->item_id] + $item_ss[$data->code][$item_info->item_id]);
?>
      <td style="text-align:right"><? if($closing_qty<>0) echo $closing_qty; $gclosing_qty[$item_info->item_id] += $closing_qty;?></td>
      <? } ?>
    </tr>
    <? } ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td bgcolor="#CCCC33"><strong>Total</strong></td>
<? 
// Item List
$sql_item="select item_id,item_name,finish_goods_code 
from item_info where 1  order by finish_goods_code";	  
$query_item = mysqli_query($conn,$sql_item);
while($item_info=mysqli_fetch_object($query_item)){ ?>
      <td bgcolor="#CCCC33"><strong>
        <?=(int)$gclosing_qty[$item_info->item_id];?>
      </strong></td>
      <? } ?>
    </tr>
  </tbody>
</table>
<?
} // end 105








elseif($_REQUEST['report']==501) { 

$location='';
if(isset($region_id)) 			{$location.=' and p.PBI_BRANCH="'.$region_id.'"';}
if(isset($zone_id)) 			{$location.=' and p.PBI_ZONE="'.$zone_id.'"';}
if(isset($area_id)) 			{$location.=' and p.PBI_AREA="'.$area_id.'"';}

if(isset($product_group)) { $pg_con=' and p.PBI_GROUP="'.$product_group.'"';}


// region list
$sql='select BRANCH_ID  as region_id,BRANCH_NAME as region_name from branch';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){$region_info[$info->region_id] = $info->region_name;}

// zone list
$sql='select ZONE_CODE as zone_id,ZONE_NAME as zone_name from zon';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){$zone_info[$info->zone_id] = $info->zone_name;}

// area list
$sql='select AREA_CODE as area_id,AREA_NAME as area_name from area';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){$area_info[$info->area_id] = $info->area_name;}




 ?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="9"><?=$str;?></td></tr>
<tr>
<th>S/L</th>
<th>Region</th><th>Zone</th><th>Area</th>
<th>Login Date</th>
<th>Time</th>
<th>SO Code</th>
<th>Name</th>
<th>Log</th>
<th>Map</th>
</tr>
</thead><tbody>

<?
$sql="select p.PBI_BRANCH,p.PBI_ZONE,p.PBI_AREA,s.access_date,s.access_time,s.user_id as so_code,p.PBI_NAME as so_name, s.latitude,s.longitude
from personnel_basic_info p, ss_location_log s
where s.user_id = p.PBI_ID and s.access_date between '".$_POST['f_date']."' and '".$_POST['t_date']."'
".$pg_con.$location." 
and p.PBI_JOB_STATUS='In Service' and s.type='SO Login'

order by p.PBI_BRANCH,p.PBI_ZONE,p.PBI_AREA,access_time desc";

// group by s.user_id

$query = mysqli_query($conn,$sql);
while($data=mysqli_fetch_object($query)){
$s++;
?>
<tr>
<td><?=$s?></td>
<td><?=$region_info[$data->PBI_BRANCH];?></td>
<td><?=$zone_info[$data->PBI_ZONE];?></td>
<td><?=$area_info[$data->PBI_AREA];?></td>
<td><?=$data->access_date?></td>
<td><?=$data->access_time?></td>
<td><?=$data->so_code?></td>
<td><?=$data->so_name?></td>
<td><?=$data->latitude?>-<?=$data->longitude?></td>
<td><a href="view_map_sng_viwe.php?lat=<?=$data->latitude?>&long=<?=$data->longitude?>" target="_blank">Map</a></td>
</tr>
<? } ?>
</tbody>
</table>
<? } // end 501



elseif($_REQUEST['report']==504) { 


$location='';
if(isset($region_id)) 			{$location.=' and sp.region_id="'.$region_id.'"';}
if(isset($zone_id)) 			{$location.=' and sp.zone_id="'.$zone_id.'"';}
if(isset($area_id)) 			{$location.=' and sp.area_id="'.$area_id.'"';}

if(isset($product_group))       { $pg_con=' and p.PBI_GROUP="'.$product_group.'"';}
if($_POST['so_code']>0)    { $emp_con=' and p.username="'.$_POST['so_code'].'"';}
if(isset($_POST['so_code'])){
 
  if($_POST['f_date']==$_POST['t_date']){
   $sql_r = 'select * from ss_schedule where PBI_ID="' . $_POST['so_code'] . '" and date="' .$_POST['f_date']. '"';
  $query_r = mysqli_query($conn,$sql_r);
  $row_r = mysqli_fetch_object($query_r);
 echo  $sql_route_count="SELECT COUNT(*) as route_count FROM ss_shop WHERE route_id = '".$row_r->route_id."'";
  $sql_route_query_r = mysqli_query($conn,$sql_route_count);
  $route_count = mysqli_fetch_object($sql_route_query_r);
  $visit_sql="select COUNT(DISTINCT dealer_code) as total_visit from ss_do_master where do_date='".date('Y-m-d')."' and entry_by='".$_POST['so_code'] ."'";
  $visit_sql_query_r = mysqli_query($conn,$visit_sql);
  $visit_count = mysqli_fetch_object($visit_sql_query_r);
  }
}

// region list
$sql='select BRANCH_ID  as region_id,BRANCH_NAME as region_name from branch';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){$region_info[$info->region_id] = $info->region_name;}

// zone list
$sql='select ZONE_CODE as zone_id,ZONE_NAME as zone_name from zon';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){$zone_info[$info->zone_id] = $info->zone_name;}

// area list
$sql='select AREA_CODE as area_id,AREA_NAME as area_name from area';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){$area_info[$info->area_id] = $info->area_name;}




?>
<?if($route_count->route_count>$visit_count->total_visit){?>
  <div style="color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; padding: 0.75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: 0.25rem;" role="alert">
  Not Visited all the scheduled shop
</div>
<?}else{?>
  <div style="color: #155724; background-color: #d4edda; border-color: #c3e6cb; padding: 0.75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: 0.25rem;" role="alert">
  Visited all the scheduled shop
</div>

  <?}?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="9"><?=$str;?></td></tr>
<tr>
<th>S/L</th>
<th>Region</th><th>Zone</th><th>Area</th>
<th>SO Code</th><th>Name</th>
<th>Order No</th>
<th>Visit Date</th><th>Time</th>

<th>Shop Name</th><th>Stay min</th>
<th>Activity</th><th>Amount</th>
<th>Status</th><th>Map</th>
</tr>
</thead><tbody>

<?
 $sql="select s.do_no,p.region_id,p.zone_id,p.area_id,s.do_date,s.entry_at,s.entry_by as so_code,s.checked_at,s.staytime,p.fname as so_name, s.latitude,s.longitude, sp.shop_name, s.shop_status,s.do_no,s.status

from ss_user p, ss_do_master s, ss_shop sp
where s.entry_by = p.username and sp.dealer_code=s.dealer_code
and s.do_date between '".$_POST['f_date']."' and '".$_POST['t_date']."'
".$pg_con.$location.$emp_con." 


group by s.do_no
order by p.region_id,p.zone_id,p.area_id,so_code,entry_at desc";

// group by s.user_id

$query = mysqli_query($conn,$sql);
while($data=mysqli_fetch_object($query)){
$s++;
?>
<tr>
<td><?=$s?></td>
<td><?=$region_info[$data->region_id];?></td>
<td><?=$zone_info[$data->zone_id];?></td>
<td><?=$area_info[$data->area_id];?></td>

<td><?=$data->so_code?></td>
<td><?=$data->so_name?></td>
<td><?=$data->do_no?></td>
<td><?=$data->do_date?></td>
<td><?=$data->entry_at?></td>

<td><?=$data->shop_name?></td>


<td><?

$entry_at   =$data->entry_at;
$checked_at =$data->checked_at;

if($checked_at>0 && $entry_at>0){

    echo $stay_min = $data->staytime.'Min';    
}

?>

</td>


<td><?=$data->shop_status?></td>
<td><?=$do_amt=find1("select sum(total_amt) from ss_do_details where do_no='".$data->do_no."'"); $gtotal+=$do_amt;?></td>

<td><?=$data->status?></td>
<td><? if($data->latitude!='' && $data->longitude!=''){?>
    <a href="view_map_sng_viwe.php?lat=<?=$data->latitude?>&long=<?=$data->longitude?>" target="_blank">Map</a>
    <? } ?>
    </td>
</tr>
<? } ?>
<tr>
    <td colspan="12">Total</td>
    <td><?=$gtotal?></td>
</tr>
</tbody>
</table>
<? } // end 504




elseif($_REQUEST['report']==503503) { 


$location='';
if(isset($region_id)) 			{$location.=' and p.region_id="'.$region_id.'"';}
if(isset($zone_id)) 			{$location.=' and p.zone_id="'.$zone_id.'"';}
if(isset($area_id)) 			{$location.=' and p.area_id="'.$area_id.'"';}

if(isset($product_group)) { $pg_con=' and p.PBI_GROUP="'.$product_group.'"';}
if(isset($so_code)) { 
    $so_code_con1=' and user_id="'.$so_code.'" ';
    $so_code_con2=' and p.username="'.$so_code.'" ';
}

// region list
$sql='select BRANCH_ID  as region_id,BRANCH_NAME as region_name from branch';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){$region_info[$info->region_id] = $info->region_name;}

// zone list
$sql='select ZONE_CODE as zone_id,ZONE_NAME as zone_name from zon';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){$zone_info[$info->zone_id] = $info->zone_name;}

// area list
$sql='select AREA_CODE as area_id,AREA_NAME as area_name from area';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){$area_info[$info->area_id] = $info->area_name;}


// out time
 $sql9="select s.access_date,s.user_id as so_code,s.access_time,latitude,longitude
from ss_location_log s
where s.access_date between '".$_POST['f_date']."' and '".$_POST['t_date']."'
".$pg_con." 
and s.type='Attendance' and s.attendance_type='OUT TIME'
group by s.access_date, so_code, s.access_time
";
$query = mysqli_query($conn,$sql9);
while($info = mysqli_fetch_object($query)){
	$out_time[$info->access_date][$info->so_code] = $info->access_time;
	$out_map_latitude[$info->access_date][$info->so_code] = $info->latitude;
	$out_map_longitude[$info->access_date][$info->so_code] = $info->longitude;
	$out_shop_info[$info->access_date][$info->so_code] = $info->shop_name;
}


?>
<table id="ExportTable" width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="9"><?=$str;?></td></tr>
<tr>
<th>S/L</th>
<th>Date</th>
<th>Area</th>
<th>Zone</th>
<th>Region</th>
<th>SO Code</th>
<th>Name</th>
<th>IN Time</th>
<!--<th>IN Shop Address</th>-->
<th>OUT Time</th>
<!--<th>Out Shop Address</th>-->
<th>Status</th>
<th>Image</th>
</tr>
</thead><tbody>

<?
  //$sql1="select s.access_date,s.access_time,p.username as so_code,p.fname as so_name,p.user_id, sr.user_id,sr.area_id, a.AREA_CODE, a.AREA_NAME, a.ZONE_ID, z.ZONE_CODE, z. ZONE_NAME, z.REGION_ID, b.BRANCH_ID,b.BRANCH_NAME ,    s.latitude,s.longitude,s.att_img from ss_user p, ss_location_log s, ss_user_route sr, area a, zon z, branch b where s.user_id = p.username and p.user_id=sr.user_id and sr.area_id= a.AREA_CODE and a.ZONE_ID=b.BRANCH_ID and s.access_date between '".$_POST['f_date']."' and '".$_POST['t_date']."'".$pg_con.$location.$so_code_con2." and p.status='Active' and s.type='Attendance' and s.attendance_type='IN TIME' order by p.region_id,p.zone_id,p.area_id,p.username ";

// group by s.user_id
$doQty = "SELECT a.*,b.AREA_NAME FROM ss_user_route a Left JOIN area b ON b.AREA_CODE=a.area_id WHERE 1";
    $do_qty_query=mysqli_query($conn,$doQty);
    while($do_qty_data=mysqli_fetch_object($do_qty_query)){
         
        $sale_qty[$do_qty_data->user_id][] =$do_qty_data->AREA_NAME;
		 $sale_qty2[$do_qty_data->user_id][] =$do_qty_data->area_id;
}
// implode(", ", $sale_qty[26]);




 //implode(", ", $sale_qty2[26]);


$sql1="select p.region_id,p.zone_id,p.area_id,s.access_date,s.access_time,p.username as so_code,p.fname as so_name, s.latitude,s.longitude,s.att_img,p.user_id 

from ss_user p, ss_location_log s 

where s.user_id = p.user_id and s.access_date between '".$_POST['f_date']."' and '".$_POST['t_date']."' ".$pg_con.$location.$so_code_con2." and p.status='Active' and s.type='Attendance' and s.attendance_type ='IN TIME' order by p.region_id,p.zone_id,p.area_id,p.username ";




$query = mysqli_query($conn,$sql1,$sql1ll);

while($data=mysqli_fetch_object($query)){
$s++;
$zone_id = 0;
$zone_codes = []; 
?>
<tr>
<td><?=$s?></td>
<td><?=$data->access_date?></td>
<td><?=implode(", ", $sale_qty[$data->user_id]);?></td>

<td><?

 $doQty3 = "SELECT DISTINCT b.ZONE_NAME,b.ZONE_CODE, a.AREA_CODE FROM area a LEFT JOIN zon b ON a.ZONE_ID=b.ZONE_CODE WHERE a.AREA_CODE IN (".implode(", ", $sale_qty2[$data->user_id]).")";
 $do_qty_query3=mysqli_query($conn,$doQty3);
  $zone_names = [];
    while($do_qty_data3=mysqli_fetch_object($do_qty_query3)){
     if (!in_array($do_qty_data3->ZONE_NAME, $zone_names)) {     
    	 $zone_names[] = $do_qty_data3->ZONE_NAME;
		  $zone_codes[] = $do_qty_data3->ZONE_CODE;
	}
}
echo implode(", ", $zone_names);
$zone_id = implode(", ", $zone_codes);

?></td>

<td><?

  $doQty6 = "SELECT a.BRANCH_ID,a.BRANCH_NAME FROM branch a LEFT JOIN zon b ON a.BRANCH_ID=b.REGION_ID WHERE b.ZONE_CODE IN (".$zone_id.")";
 $do_qty_query6=mysqli_query($conn,$doQty6);
  $resion_names = [];
    while($do_qty_data6=mysqli_fetch_object($do_qty_query6)){
	
	  $do_qty_data6->BRANCH_NAME;
     if (!in_array($do_qty_data6->BRANCH_NAME, $resion_names)) {     
    	 $resion_names[] = $do_qty_data6->BRANCH_NAME;
	}
}
echo implode(", ", $resion_names);



?></td>


<td><?=$data->so_code?></td>
<td><?=$data->so_name?></td>
<td>
<? echo $data->access_time;?>&nbsp;&nbsp;<a href="view_map_sng_viwe.php?lat=<?=$data->latitude?>&long=<?=$data->longitude?>" target="_blank">Map</a>
</td>



<?php /*?><td><?=$data->shop_name?><br><?=$data->shop_address?></td><?php */?>


<td><? echo $out_time[$data->access_date][$data->so_code];?>
&nbsp;&nbsp;<a href="view_map_sng_viwe.php?lat=<?=$out_map_latitude[$data->access_date][$data->so_code]?>&long=<?=$out_map_longitude[$data->access_date][$data->so_code]?>" target="_blank">Map</a>
</td>
<?php /*?><td><?=$out_shop_info[$data->access_date][$data->so_code];?></td><?php */?>


<td>
<?
if($data->access_time!='' && $out_time[$data->access_date][$data->so_code]!=''){
$in_dt = new DateTime($data->access_time);                              $in_time2 = $in_dt->format('Y-m-d H:i:s');
$out_dt = new DateTime($out_time[$data->access_date][$data->so_code]);  $out_time2 = $out_dt->format('Y-m-d H:i:s');

  $inTime =  strtotime($in_time2); 
$outTime =  strtotime($out_time2); 

  $access_in = $data->access_date.' 09:00:00';
 $access_in = strtotime($access_in);
$access_out = $data->access_date.' 18:00:00';
$access_out = strtotime($access_out);
$status = 'Regular'; 

if($inTime>$access_in){
  $status='Late';
}



if($outTime<$access_out){
 $status='Early Out';
}

if($inTime>$access_in && $outTime<$access_out){
 $status='Late and Early Out';
}
echo $status;

    
}else { echo 'Missing';}
?></td>
<td><img src="../../../mobile/sec_mobile_app/file/uploads/attendance_pic/<?=$data->att_img?>" alt="Girl in a jacket" width="100" height="100"></td>

</tr>
<? 

} ?>
</tbody>
</table>
<? } // end old 503


elseif($_REQUEST['report']==503) { 


$location='';
if(isset($region_id)) 			{$location.=' and p.region_id="'.$region_id.'"';}
if(isset($zone_id)) 			{$location.=' and p.zone_id="'.$zone_id.'"';}
if(isset($area_id)) 			{$location.=' and p.area_id="'.$area_id.'"';}

if(isset($product_group)) { $pg_con=' and p.PBI_GROUP="'.$product_group.'"';}
if(isset($so_code)) { 
    $so_code_con1=' and user_id="'.$so_code.'" ';
    $so_code_con2=' and p.username="'.$so_code.'" ';
}

// region list
$sql='select BRANCH_ID  as region_id,BRANCH_NAME as region_name from branch';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){$region_info[$info->region_id] = $info->region_name;}

// zone list
$sql='select ZONE_CODE as zone_id,ZONE_NAME as zone_name from zon';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){$zone_info[$info->zone_id] = $info->zone_name;}

// area list
$sql='select AREA_CODE as area_id,AREA_NAME as area_name from area';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){$area_info[$info->area_id] = $info->area_name;}


// out time
 $sql9="select s.access_date,s.user_id as so_code,s.access_time,latitude,longitude
from ss_location_log s
where s.access_date between '".$_POST['f_date']."' and '".$_POST['t_date']."'
".$pg_con." 
and s.type='Attendance' and s.attendance_type='OUT TIME'
group by s.access_date, so_code, s.access_time
";
$query = mysqli_query($conn,$sql9);
while($info = mysqli_fetch_object($query)){
	$out_time[$info->access_date][$info->so_code] = $info->access_time;
	$out_map_latitude[$info->access_date][$info->so_code] = $info->latitude;
	$out_map_longitude[$info->access_date][$info->so_code] = $info->longitude;
	$out_shop_info[$info->access_date][$info->so_code] = $info->shop_name;
}


?>
<table id="ExportTable" width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="9"><?=$str;?></td></tr>
<tr>
<th>S/L</th>
<th>Date</th>
<th>Area</th>
<th>Zone</th>
<th>Region</th>
<th>SO Code</th>
<th>Name</th>
<th>IN Time</th>
<!--<th>IN Shop Address</th>-->
<th>OUT Time</th>
<!--<th>Out Shop Address</th>-->
<th>Status</th>
<th>Image</th>
</tr>
</thead><tbody>

<?
  //$sql1="select s.access_date,s.access_time,p.username as so_code,p.fname as so_name,p.user_id, sr.user_id,sr.area_id, a.AREA_CODE, a.AREA_NAME, a.ZONE_ID, z.ZONE_CODE, z. ZONE_NAME, z.REGION_ID, b.BRANCH_ID,b.BRANCH_NAME ,    s.latitude,s.longitude,s.att_img from ss_user p, ss_location_log s, ss_user_route sr, area a, zon z, branch b where s.user_id = p.username and p.user_id=sr.user_id and sr.area_id= a.AREA_CODE and a.ZONE_ID=b.BRANCH_ID and s.access_date between '".$_POST['f_date']."' and '".$_POST['t_date']."'".$pg_con.$location.$so_code_con2." and p.status='Active' and s.type='Attendance' and s.attendance_type='IN TIME' order by p.region_id,p.zone_id,p.area_id,p.username ";

// group by s.user_id
$doQty = "SELECT a.*,b.AREA_NAME FROM ss_user_route a Left JOIN area b ON b.AREA_CODE=a.area_id WHERE 1";
    $do_qty_query=mysqli_query($conn,$doQty);
    while($do_qty_data=mysqli_fetch_object($do_qty_query)){
         
        $sale_qty[$do_qty_data->user_id][] =$do_qty_data->AREA_NAME;
		 $sale_qty2[$do_qty_data->user_id][] =$do_qty_data->area_id;
}
// implode(", ", $sale_qty[26]);




 //implode(", ", $sale_qty2[26]);


$sql1="select p.region_id,p.zone_id,p.area_id,s.access_date,s.access_time,s.user_id as so_code,p.fname as so_name, s.latitude,s.longitude,s.att_img,p.user_id 

from ss_user p, ss_location_log s 

where s.user_id = p.user_id and s.access_date between '".$_POST['f_date']."' and '".$_POST['t_date']."' ".$pg_con.$location.$so_code_con2." and p.status='Active' and s.type='Attendance' and s.attendance_type = 'IN TIME' order by p.region_id,p.zone_id,p.area_id,p.username ";




$query = mysqli_query($conn,$sql1,$sql1ll);

while($data=mysqli_fetch_object($query)){
$s++;
$zone_id = 0;
$zone_codes = []; 
?>
<tr>
<td><?=$s?></td>

<td><?=$data->access_date?></td>
<td><?=implode(", ", $sale_qty[$data->user_id]);?></td>

<td><?

 $doQty3 = "SELECT DISTINCT b.ZONE_NAME,b.ZONE_CODE, a.AREA_CODE FROM area a LEFT JOIN zon b ON a.ZONE_ID=b.ZONE_CODE WHERE a.AREA_CODE IN (".implode(", ", $sale_qty2[$data->user_id]).")";
 $do_qty_query3=mysqli_query($conn,$doQty3);
  $zone_names = [];
    while($do_qty_data3=mysqli_fetch_object($do_qty_query3)){
     if (!in_array($do_qty_data3->ZONE_NAME, $zone_names)) {     
    	 $zone_names[] = $do_qty_data3->ZONE_NAME;
		  $zone_codes[] = $do_qty_data3->ZONE_CODE;
	}
}
echo implode(", ", $zone_names);
$zone_id = implode(", ", $zone_codes);

?></td>

<td><?

  $doQty6 = "SELECT a.BRANCH_ID,a.BRANCH_NAME FROM branch a LEFT JOIN zon b ON a.BRANCH_ID=b.REGION_ID WHERE b.ZONE_CODE IN (".$zone_id.")";
 $do_qty_query6=mysqli_query($conn,$doQty6);
  $resion_names = [];
    while($do_qty_data6=mysqli_fetch_object($do_qty_query6)){
	
	  $do_qty_data6->BRANCH_NAME;
     if (!in_array($do_qty_data6->BRANCH_NAME, $resion_names)) {     
    	 $resion_names[] = $do_qty_data6->BRANCH_NAME;
	}
}
echo implode(", ", $resion_names);



?></td>


<td><?=$data->so_code?></td>
<td><?=$data->so_name?></td>
<td>
<? echo $data->access_time;?>&nbsp;&nbsp;<a href="view_map_sng_viwe.php?lat=<?=$data->latitude?>&long=<?=$data->longitude?>" target="_blank">Map</a>
</td>

<?php /*?><td>
<? echo $data->access_time;?>&nbsp;&nbsp;<a href="view_map_sng_viwe.php?lat=<?=$data->latitude?>&long=<?=$data->longitude?>" target="_blank">Map</a>
</td><?php */?>

<?php /*?><td><?=$data->shop_name?><br><?=$data->shop_address?></td><?php */?>


<td><? echo $out_time[$data->access_date][$data->so_code];?>
&nbsp;&nbsp;<a href="view_map_sng_viwe.php?lat=<?=$out_map_latitude[$data->access_date][$data->so_code]?>&long=<?=$out_map_longitude[$data->access_date][$data->so_code]?>" target="_blank">Map</a>
</td>
<?php /*?><td><?=$out_shop_info[$data->access_date][$data->so_code];?></td><?php */?>


<td>
<?
if($data->access_time!='' && $out_time[$data->access_date][$data->so_code]!=''){
$in_dt = new DateTime($data->access_time);                              $in_time2 = $in_dt->format('Y-m-d H:i:s');
$out_dt = new DateTime($out_time[$data->access_date][$data->so_code]);  $out_time2 = $out_dt->format('Y-m-d H:i:s');

  $inTime =  strtotime($in_time2); 
$outTime =  strtotime($out_time2); 

  $access_in = $data->access_date.' 09:00:00';
 $access_in = strtotime($access_in);
$access_out = $data->access_date.' 18:00:00';
$access_out = strtotime($access_out);
$status = 'Regular'; 

if($inTime>$access_in){
  $status='Late';
}



if($outTime<$access_out){
 $status='Early Out';
}

if($inTime>$access_in && $outTime<$access_out){
 $status='Late and Early Out';
}
echo $status;

    
}else { echo 'Missing';}
?></td>
<td><img src="../../../mobile/sec_mobile_app/file/uploads/attendance_pic/<?=$data->att_img?>" alt="Girl in a jacket" width="100" height="100"></td>

</tr>
<? 

} ?>
</tbody>
</table>
<? } // end 503


elseif($_REQUEST['report']==5) 
{
if(isset($region_id)) 
$sqlbranch 	= "select * from branch where BRANCH_ID=".$region_id;
else
$sqlbranch 	= "select * from branch";
$querybranch = mysqli_query($conn,$sqlbranch);
while($branch=mysqli_fetch_object($querybranch)){
	$rp=0;
	echo '<div>';
if(isset($zone_id)) 
$sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID." and ZONE_CODE=".$zone_id;
else
$sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID;

	$queryzone = mysqli_query($conn,$sqlzone);
	while($zone=mysqli_fetch_object($queryzone)){
if($area_id>0) 
$area_con = "and a.AREA_CODE=".$area_id;
$sql="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,w.warehouse_name as depot,a.AREA_NAME as area,d.product_group as grp,(select sum(total_amt) from sale_do_details where do_no=m.do_no) as DP_Total,(select sum(t_price*total_unit) from sale_do_details where do_no=m.do_no)  as TP_Total from 
sale_do_master m,dealer_info d  , warehouse w,area a
where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con.$area_con." order by do_no";
$sqlt="select sum(s.t_price*s.total_unit) as total,sum(total_amt) as dp_total from 
sale_do_master m,dealer_info d  , warehouse w,area a,sale_do_details s
where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and s.do_no=m.do_no and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con.$area_con;

		$queryt = mysqli_query($conn,$sqlt);
		$t= mysqli_fetch_object($queryt);
		if($t->total>0)
		{
			if($rp==0) {$reg_total=0;$dp_total=0; $str .= '<p style="width:100%">Region Name: '.$branch->BRANCH_NAME.' Region</p>';$rp++;}
			$str .= '<p style="width:100%">Zone Name: '.$zone->ZONE_NAME.' Zone</p>';
			echo report_create($sql,1,$str);
			$str = '';
			
			$reg_total= $reg_total+$t->total;
			$dp_total= $dp_total+$t->dp_total;
		}

	}
	
if($rp>0){
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;"></td></tr></thead>
<tbody>
  <tr class="footer">
    <td align="right"><?=$branch->BRANCH_NAME?> Region  DP Total: <?=number_format($dp_total,2)?> ||| TP Total: <?=number_format($reg_total,2)?></td></tr></tbody>
</table><br /><br /><br />
<?  }
	echo '</div>';
}
?>

<?
}














// modify april 21
elseif($_REQUEST['report']==2000) 
{
if(isset($t_date)) 	
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';
$cdate_con=' and do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($product_group)) 		{$pg_con=' and i.sales_item_type="'.$product_group.'"';} 
if($depot_id>0) 				{$dpt_con=' and d.depot="'.$depot_id.'"';} 


$sqlr = "select * from branch";
$queryr = mysqli_query($conn,$sqlr);
while($region = mysqli_fetch_object($queryr)){
$region_id = $region->BRANCH_ID;

$sql = "select i.finish_goods_code as code, sum(o.total_unit) as total_unit
from sale_do_master m,sale_do_details o, item_info i,dealer_info d, area a, zon z
where o.unit_price>0 and m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') and d.area_code=a.AREA_CODE and a.ZONE_ID=z.ZONE_CODE and z.REGION_ID=".$region_id."
".$dtype_con.$date_con.$item_con.$item_brand_con.$pg_con.$dpt_con.' 
group by i.finish_goods_code';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){
$do_qty[$info->code][$region_id] = $info->total_unit;
}}

if(isset($product_group)) 		{$pg_con=' and i.sales_item_type like "%'.$product_group.'%"';}
		$sql = "select 
		i.finish_goods_code as code, 
		i.item_name, i.item_brand, i.brand_category_type,
		i.sales_item_type as `group`,i.pack_size,i.d_price
		from 
		item_info i
		where 1 ".$item_con.$item_brand_con.$pg_con.' 
		group by i.finish_goods_code';
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead>
<tr><td style="border:0px;" colspan="16"><?=$str?></td></tr><tr>
<th height="20">S/L</th>
<th>Code</th>
<th>Item Name</th>
<th>Grp</th>
<th>Brand</th>
<th>Sub-Brand</th>
<th>DHK North</th>
<th>DHK South</th>
<th>Ctg</th>
<th>Comilla</th>
<th>Sylhet</th>
<th>Barisal</th>
<th>Bogra</th>
<th>Total</th>
</tr></thead>
<tbody>
<?
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){

$total_item = 
(int)($do_qty[$info->code][13]/$info->pack_size)+
(int)($do_qty[$info->code][12]/$info->pack_size)+
(int)($do_qty[$info->code][3]/$info->pack_size)+
(int)($do_qty[$info->code][4]/$info->pack_size)+
(int)($do_qty[$info->code][5]/$info->pack_size)+
(int)($do_qty[$info->code][9]/$info->pack_size)+
(int)($do_qty[$info->code][10]/$info->pack_size)+
(int)($do_qty[$info->code][8]/$info->pack_size);

if($total_item>0){
?>
<tr><td><?=++$i;?></td>
  <td><?=$info->code;?></td>
  <td><?=$info->item_name;?></td>
  <td><?=$info->group?></td>
  <td><?=$info->item_brand?></td>
  <td style="text-align:center"><?=$info->brand_category_type?></td>
  <td style="text-align:right"><?=(int)($do_qty[$info->code][13]/$info->pack_size)?></td>
  <td style="text-align:right"><?=(int)($do_qty[$info->code][12]/$info->pack_size)?></td>
  <td style="text-align:right"><?=(int)($do_qty[$info->code][3]/$info->pack_size)?></td>
  <td style="text-align:right"><?=(int)($do_qty[$info->code][4]/$info->pack_size)?></td>
  <td style="text-align:right"><?=(int)($do_qty[$info->code][5]/$info->pack_size)?></td>
  <td style="text-align:right"><?=(int)($do_qty[$info->code][10]/$info->pack_size)?></td>
  <td style="text-align:right"><?=(int)($do_qty[$info->code][8]/$info->pack_size)?></td>
  <td style="text-align:right"><?=number_format($total_item,0);?></td></tr>
<?
}}
?>
</tbody></table>
<?
$str = '';

}




elseif(isset($sql)&&$sql!='') echo autoreport2($sql,$str);
?>




</div>
</div>
<!--    </div>	-->
<!--</div>-->


    
<!--<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>	-->


<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>


<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>


<script>
  
  $(function () {
    $("#example1").DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": false,
      "autoWidth": false,
      "responsive": false,
      "responsive": false, 
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
  
  
    $(function () {
    $("#examplefull").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
  
  
  
  
  
</script>


<script>
$(document).ready(function() {
    $('#example').DataTable( {
        "paging":   false,
        "ordering": true,
        "info":     true
    } );
} );

$(document).ready(function() {
    $('.table_report_all').DataTable( {
        "paging":   false,
        "ordering": true,
        "info":     false
    } );
} );
</script>
    
  
    
    
</body>
</html>


