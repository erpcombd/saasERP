<?php
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);

session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

//$user_id	=$_SESSION['user']['user_id'];
//$emp_code	=$_SESSION['user']['id'];
$dealer_code	= $_SESSION['user']['id'];
//$product_group =$_SESSION['user']['product_group'];

$page  = "report_list";
$title = "Reports View";



require_once '../assets/template/inc.header.php';



		
if(isset($_REQUEST['submit'])&&isset($_REQUEST['report'])&&$_REQUEST['report']>0){

		
	$f_date=$_REQUEST['f_date'];
	$t_date=$_REQUEST['t_date'];


$item_con='';

if(isset($item_id))			        {$item_con.=' and i.item_id='.$item_id;}
if(isset($item_brand)) 		        {$item_con.=' and i.item_brand="'.$item_brand.'"';} 
if($_POST['group_for']>0) 	        {$item_con.=' and i.group_for="'.$_POST['group_for'].'"';}
if($_POST['item_group']>0) 	        {$item_con.=' and i.item_group="'.$_POST['item_group'].'"';}
if($_POST['category_id']>0) 	    { $category_id=$_POST['category_id']; $item_con.=' and i.category_id="'.$category_id.'"';}
if($_POST['subcategory_id']>0) 	    { $subcategory_id=$_POST['subcategory_id']; $item_con.=' and i.subcategory_id="'.$subcategory_id.'"';}

	
	if($_POST['warehouse_id']>0) 		$warehouse_id   =$_POST['warehouse_id'];
	if($_REQUEST['item_id']>0) 			$item_id        =$_REQUEST['item_id'];
	
	
	if($_POST['order_type']!='') 		$order_type     =$_POST['order_type'];
	
	if($_POST['issue_status']!='') 		$issue_status   =$_POST['issue_status'];
	if($_POST['item_sub_group']>0) 		$sub_group_id   =$_POST['item_sub_group'];
	if($_POST['item_brand']>0) 			$item_brand     =$_POST['item_brand'];
    
    if($_POST['dealer_code']>0) {
        $dealer_con=' and dealer_code="'.$_POST['dealer_code'].'"';
        $dealer_cond=' and d.dealer_code="'.$_POST['dealer_code'].'"';
        $dealer_conm=' and m.dealer_code="'.$_POST['dealer_code'].'"';
        $dealer_cons=' and s.dealer_code="'.$_POST['dealer_code'].'"';
    }else{
        $_POST['dealer_code'] = $dealer_code;
        $dealer_con=' and dealer_code="'.$_POST['dealer_code'].'"';
        $dealer_cond=' and d.dealer_code="'.$_POST['dealer_code'].'"';
        $dealer_conm=' and m.dealer_code="'.$_POST['dealer_code'].'"';
        $dealer_cons=' and s.dealer_code="'.$_POST['dealer_code'].'"';
    }
        
}


$locationt='';



switch ($_POST['report']) {



case 701:
$report='Sales Report Chalan wise';
break;

case 702:
$report='Sales Return List';
break;

case 703:
$report='Sales Return Details Report';
break;

case 704:
$report='Draft Party Ledger Report';
break;

case 705:
$report='Dealer Commission Report';
break;







case 51:
$report='Confirm Order List';
break;

case 54:
$report='Party wise Order List';
break;

case 55:
$report='Party wise Chalan Report';
break;

case 52:
$report='Delivery List';
break;

case 57:
$report='Pending Order List';
break;

case 53:
$report='Target Vs Order Vs Delivery';
break;

case 56:
$report='Monthly Product Group wise Report';
break;


case 58:
$report='Target Progress Status';
break;

case 101:
$report='Target Vs Sales Report';
break;

case 104:
$report='Dealer Stock Report';
break;


case 105:
$report='Shop List';
break;


case 201:
$report="Opening Stock Entry Report";
break;


case 202:
$report="Product List";
break;





}

?>


   <div class="page-content header-clear-medium">
    <div class="card card-style">
	<div class="content m-0"   style=" overflow: auto; ">	
        <!--<div class="card">-->
        <!--    <div class="card-body">-->


<?php
		$str 	.= '<div class="row col-12">';
// 		$str 	.= '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		
		if(isset($report)) $str 	.= '<center><h3>'.$report.'</h3>';
		if($_POST['dealer_code']>0) $str.= '<h5>Outlet Name:'.find1("select shop_name from ss_shop where dealer_code='".$_POST['dealer_code']."'").'</h5>';
		
		
		if(isset($t_date)) $str 	.= '<h6>Date Interval: '.$f_date.' To '.$t_date.'</h6>';
		
		
		
		if(isset($item_id)) { $item_name = find1("select name from product where id='".$item_id."'");
		$str 	.= '<p>Item Name: '.$item_id.'-'.$item_name.'</p>';
		}
		
		$str.='<div align="right">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		



if($_REQUEST['report']==101) {
$report="Sales Report";

if($_POST['source']!=''){$source = $_POST['source'];}
if($_POST['dealer_code']!=''){$shop_con = "and c.dealer_code='".$_POST['dealer_code']."'"; }

if(isset($t_date)) {
$date_con=' and c.chalan_date between \''.$f_date.'\' and \''.$t_date.'\'';

$year = date("Y",strtotime($t_date));
$mon = date("m",strtotime($t_date));
}
//if($_POST['offer_name']) {$offer_con=" and a.offer_name='".$_POST['offer_name']."'";}


// item wise target
$tc = "select target_con from ss_target_ratio where dealer_code='".$emp_code."' and target_year='".$year."' and target_month='".$mon."' ";
$target_con = find1($tc);
if($target_con<1){ $target_con=100;}


//$dealer_code = find1("select master_dealer_code from ss_shop where emp_code='".$emp_code."' and status=1");
$dealer_code	=$_SESSION['user']['depot'];



// item wise target
$sql_target="select t.item_id,t.target_ctn,target_amount,i.pack_size 
from sale_target_upload t, item_info i where i.item_id=t.item_id 
and target_year='".$year."' and target_month='".$mon."' and dealer_code='".$dealer_code."'";
$query1 = mysqli_query($conn, $sql_target);
while($info=mysqli_fetch_object($query1)){
$target_qty[$info->item_id]=(($info->target_ctn*$info->pack_size)*$target_con)/100;
$target_amt[$info->item_id]=($info->target_amount*$target_con)/100;
}





// item wise sales
$sql_item='select i.item_id,i.finish_goods_code as code,i.item_name,sum(c.total_unit) as qty,sum(c.total_amt) as amount
from item_info i, ss_do_chalan c
where c.item_id=i.item_id
'.$date_con.' and c.entry_by="'.$emp_code.'"
'.$shop_con.'
group by i.item_id
order by i.finish_goods_code,i.item_name';
$query2 = mysqli_query($conn, $sql_item);
while($info2=mysqli_fetch_object($query2)){
$sales_qty[$info2->item_id]=$info2->qty;
$sales_amt[$info2->item_id]=$info2->amount;
}



$res="select i.* from item_info i where 1 order by finish_goods_code";
$query = mysqli_query($conn, $res);
?>
<?=$str?>


<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;zoom: 60%;">
<thead>
<tr class="bg-night-light1">
<th scope="col" class="color-white">S/L</th>
<th scope="col" class="color-white">FG Code</th>
<th scope="col" class="color-white">Item Name</th>
<th scope="col" class="color-white">Target Qty</th>
<th scope="col" class="color-white">Target Amount</th>
<th scope="col" class="color-white">Sales Qty</th>
<th scope="col" class="color-white">Sales Amount</th>
<th scope="col" class="color-white">ShortFall</th>
<th scope="col" class="color-white">Achivement</th>
</tr>
</thead>
<tbody>
<? 
while($data=mysqli_fetch_object($query)){
if($target_qty[$data->item_id]>0 || $sales_qty[$data->item_id]>0){
$s++;
?>
<tr>
  <td><?=$s?></td>
  <td><?=$data->finish_goods_code?></td>
  <td><?=$data->item_name?></td>
  <td><?=(int)$target_qty[$data->item_id];?></td>
  <td><?=(int)$target_amt[$data->item_id]; $gtarget +=$target_amt[$data->item_id];?></td>
  <td><?=(int)$sales_qty[$data->item_id];?></td>
  <td><?=(int)$sales_amt[$data->item_id]; $gsales +=$sales_amt[$data->item_id];?></td>
  <td><? $sfall=(int)($sales_qty[$data->item_id]-$target_qty[$data->item_id]); $gsfall+=$sfall;
  	if($sfall<0){ ?> <span style="color:red; font-weight: bold;"><?=$sfall;?> <? }else{ echo $sfall;} ?>
</td>
  <td><?
$ratio = (($sales_amt[$data->item_id]*100)/$target_amt[$data->item_id]);
if($ratio<>0) {echo number_format($ratio,2); } 
  ?></td>
  </tr>
<? }} ?>
<tr>
<td></td><td></td><td>Total</td><td><? //=$gqty?></td><td><?=(int)$gtarget?></td>
<td></td><td><?=(int)$gsales?></td>
<td><?=number_format($gsfall,0);?></td>
<?
$gratio = (($gsales*100)/$gtarget);
?>
<td><?=number_format($gratio,2);?></td>
</tr>
</tbody>
</table>
<? 
} // end report 101




elseif($_REQUEST['report']==105) {

$shop_code=$_GET['code'];
if($_GET['code']!=''){
    $shop_con=' and dealer_code="'.$shop_code.'"';
}

?>
<?=$str?>
<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;zoom: 60%;">
<tr class="bg-night-light1">
<th scope="col" class="color-white">S/L</th>
<th scope="col" class="color-white">Shop Code</th>
<th scope="col" class="color-white">Shop Name</th>
<th scope="col" class="color-white">Address</th>
<th scope="col" class="color-white">SO Code</th>

<th scope="col" class="color-white">Owner Name</th>
<th scope="col" class="color-white">Owner Mobile</th>
<th scope="col" class="color-white">Manager Name</th>
<th scope="col" class="color-white">Manager Mobile</th>

<th scope="col" class="color-white">Class</th>
<th scope="col" class="color-white">Type</th>
<th scope="col" class="color-white">Channel</th>
<th scope="col" class="color-white">Route Type</th>
<th scope="col" class="color-white">Shop Identity</th>

<th scope="col" class="color-white">Image</th>
</tr>
<tbody>
<? 
$res="select * from ss_shop where master_dealer_code='".$_SESSION['user']['id']."' order by dealer_code desc";
$query = mysqli_query($conn, $res);
while($data=mysqli_fetch_object($query)){
$s++;
?>
<tr>
<td><?=$s?></td>
<td><?=$data->dealer_code?></td>
<td><?=$data->shop_name?></td>
<td><?=$data->shop_address?></td>
<td><?=$data->emp_code?></td>
  
<td><?=$data->shop_owner_name?></td>  
<td><?=$data->mobile?></td>
<td><?=$data->manager_name?></td>  
<td><?=$data->manager_mobile?></td>  

<td><?=$data->shop_class?></td>
<td><?=$data->shop_type?></td>
<td><?=$data->shop_channel?></td>
<td><?=$data->shop_route_type?></td>
<td><?=$data->shop_identity?></td>
<td><? if($data->picture!=''){ ?><a href="../sec_mobile_app/<?=$data->picture?>" target="_blank">View</a><? } ?></td>
</tr>
<? } ?>
</tbody>
</table>
<? 
} // 




elseif($_REQUEST['report']==51) {

$date_con=' and m.do_date between "'.$f_date.'" and "'.$t_date.'" ';

?>
<?=$str?>

<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;zoom: 60%;">
<tr class="bg-night-light1">
<th scope="col" class="color-white">S/L</th>
<th scope="col" class="color-white">Order No</th>
<th scope="col" class="color-white">Order Date</th>
<th scope="col" class="color-white">Party Code</th>
<th scope="col" class="color-white">Party Name</th>
<th scope="col" class="color-white">Party Address</th>
<th scope="col" class="color-white">Order Qty</th>
<th scope="col" class="color-white">Order Amount</th>
</tr>
<tbody>
<? 
 $res="select m.do_no,m.do_date,m.dealer_code,s.shop_name,s.shop_address,sum(d.total_unit) as qty,sum(d.total_amt) as amount
from ss_do_master m, ss_do_details d, ss_shop s
where m.do_no=d.do_no and m.dealer_code=s.dealer_code and m.entry_by='".$_SESSION['user']['username']."' and m.status in('CHECKED','COMPLETED')
".$date_con.$dealer_conm.$route_con."
group by m.do_no
order by m.do_no";
$query = mysqli_query($conn, $res);
while($data=mysqli_fetch_object($query)){
$s++;
?>
<tr>
    <td><?=$s?></td>
    <td><a href="do_view.php?do=<?=$data->do_no?>"><?=$data->do_no?></a></td>
    <td><?=$data->do_date?></td>
    <td><?=$data->dealer_code?></td>
    <td><?=$data->shop_name?></td>
    <td><?=$data->shop_address?></td> 
    <td><?=$data->qty; $gqty+=$data->qty;?></td>
    <td><?=$data->amount; $gamt+=$data->amount;?></td>
</tr>
<? } ?>
<tr style="font-weight:bold;">
    <td colspan="6">Total</td>
    <td><?=$gqty?></td>
    <td><?=$gamt?></td>
</tr>
</tbody>
</table>
<? 
} elseif($_REQUEST['report']==54) {

$date_con=' and m.do_date between "'.$f_date.'" and "'.$t_date.'" ';

?>
<?=$str?>
<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;zoom: 60%;">
<tr class="bg-night-light1">
<th scope="col" class="color-white">S/L</th>
<th scope="col" class="color-white">Party Code</th>
<th scope="col" class="color-white">Party Name</th>
<th scope="col" class="color-white">Party Address</th>
<th scope="col" class="color-white">Order Qty</th>
<th scope="col" class="color-white">Order Amount</th>
</tr>
<tbody>
<? 
$res="select m.dealer_code,s.shop_name,s.shop_address,sum(d.total_unit) as qty,sum(d.total_amt) as amount
from ss_do_master m, ss_do_details d, ss_shop s
where m.do_no=d.do_no and m.dealer_code=s.dealer_code and m.entry_by='".$_SESSION['username']."' and m.status in('CHECKED','COMPLETED')
".$date_con.$dealer_conm."
group by m.dealer_code
order by m.dealer_code";
$query = mysqli_query($conn, $res);
while($data=mysqli_fetch_object($query)){
$s++;
?>
<tr>
    <td><?=$s?></td>
    <td><?=$data->dealer_code?></td>
    <td><?=$data->shop_name?></td>
    <td><?=$data->shop_address?></td> 
    <td><?=$data->qty; $gqty+=$data->qty;?></td>
    <td><?=$data->amount; $gamt+=$data->amount;?></td>
</tr>
<? } ?>
<tr style="font-weight:bold;">
    <td colspan="4">Total</td>
    <td><?=$gqty?></td>
    <td><?=$gamt?></td>
</tr>
</tbody>
</table>
<? 
} elseif($_REQUEST['report']==52) {

$date_con=' and c.chalan_date between "'.$f_date.'" and "'.$t_date.'" ';

?>
<?=$str?>
<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;zoom: 60%;">
<tr class="bg-night-light1">
<th scope="col" class="color-white">S/L</th>
<th scope="col" class="color-white">Chalan No</th>
<th scope="col" class="color-white">Chalan Date</th>
<th scope="col" class="color-white">Party Code</th>
<th scope="col" class="color-white">Party Name</th>
<th scope="col" class="color-white">Party Address</th>
<th scope="col" class="color-white">Chalan Qty</th>
<th scope="col" class="color-white">Chalan Amount</th>
</tr>
<? 
$res="select c.chalan_no,c.chalan_date,c.dealer_code,s.shop_name,s.shop_address,sum(c.total_unit) as qty,sum(c.total_amt) as amount
from ss_do_chalan c, ss_shop s
where c.dealer_code=s.dealer_code and c.entry_by='".$_SESSION['username']."' 
".$date_con.$dealer_cons."
group by c.chalan_no
order by c.chalan_no";

$query = mysqli_query($conn, $res);
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
    <td><?=$data->qty; $gqty+=$data->qty;?></td>
    <td><?=$data->amount; $gamt+=$data->amount;?></td>
</tr>
<? } ?>
<tr style="font-weight:bold;">
    <td colspan="6">Total</td>
    <td><?=$gqty?></td>
    <td><?=$gamt?></td>
</tr>
</table>
<? 
} //



elseif($_REQUEST['report']==55) {

$date_con=' and c.chalan_date between "'.$f_date.'" and "'.$t_date.'" ';

?>
<?=$str?>
<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;zoom: 60%;">
<tr class="bg-night-light1">
<th scope="col" class="color-white">S/L</th>
<th scope="col" class="color-white">Party Code</th>
<th scope="col" class="color-white">Party Name</th>
<th scope="col" class="color-white">Party Address</th>
<th scope="col" class="color-white">Chalan Qty</th>
<th scope="col" class="color-white">Chalan Amount</th>
</tr>
<? 
$res="select c.dealer_code,s.shop_name,s.shop_address,sum(c.total_unit) as qty,sum(c.total_amt) as amount
from ss_do_chalan c, ss_shop s
where c.dealer_code=s.dealer_code and c.entry_by='".$_SESSION['username']."' 
".$date_con.$dealer_cons."
group by c.dealer_code
order by c.dealer_code";

$query = mysqli_query($conn, $res);
while($data=mysqli_fetch_object($query)){
$s++;
?>
<tr>
    <td><?=$s?></td>
    <td><?=$data->dealer_code?></td>
    <td><?=$data->shop_name?></td>
    <td><?=$data->shop_address?></td> 
    <td><?=$data->qty; $gqty+=$data->qty;?></td>
    <td><?=$data->amount; $gamt+=$data->amount;?></td>
</tr>
<? } ?>
<tr style="font-weight:bold;">
    <td colspan="4">Total</td>
    <td><?=$gqty?></td>
    <td><?=$gamt?></td>
</tr>
</table>
<? 
} // 




elseif($_POST['report']==701) {


if(isset($dealer_type)){$dealer_type_con = ' and m.sales_type="'.$dealer_type.'"';}


if(isset($depot_id)) 	{$depot_con=' and c.depot_id="'.$depot_id.'"';} 


if($group_for>0){ $group_for_con=' and c.group_for="'.$group_for.'"';}
if(isset($cor_team)) 	{$cor_team_con=' and d.cor_team="'.$cor_team.'"';} 

$date_con3 = ' and jv_date between "'.$f_date.'" and "'.$t_date.'"';


// zone list
$sql='select ZONE_CODE as zone_id,ZONE_NAME as zone_name from zon';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){$zone_info[$info->zone_id] = $info->zone_name;}



// Discount
$sqld1 = "select sum(total_amt) as total_amt,chalan_no 
from sale_do_master m, sale_do_chalan c, dealer_info d , warehouse w
where m.do_no=c.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=c.depot_id and unit_price<0
".$depot_con.$date_con.$pg_con.$dealer_cond.$dealer_type_con.$group_for_con.$location.$cor_team_con." 
and m.status in ('CHECKED','COMPLETED')
group by chalan_no order by c.chalan_no";

$query1 = mysqli_query($conn,$sqld1);
while($info1 = mysqli_fetch_row($query1)){
    $discount[$info1[1]] = $info1[0];
}



// Special Discount
$sqld1 = "select dr_amt as total_amt,tr_no 
from sale_do_master m,sale_do_chalan c,dealer_info d, journal j, warehouse w
where j.tr_from = 'Sales' and j.tr_no = c.chalan_no and  j.ledger_id='4014000800040000' and m.do_no=c.do_no and m.dealer_code=d.dealer_code 
and w.warehouse_id=c.depot_id ".$depot_con.$date_con.$pg_con.$dealer_cond.$dealer_type_con.$group_for_con.$location.$cor_team_con."  
and m.status in ('CHECKED','COMPLETED')
group by chalan_no order by c.chalan_no";
$query1 = mysqli_query($conn,$sqld1);
while($info1 = mysqli_fetch_row($query1)){
    $sp_discount[$info1[1]] = $info1[0];
}


// Acc offer amt
$sql3 = "select j.tr_no as chalan_no, sum(j.cr_amt) as amt
from journal j
where j.tr_from = 'Sales' 
and j.ledger_id in ('3022100021','3022100031')
".$date_con3."  
group by chalan_no order by chalan_no";
$query3 = mysqli_query($conn,$sql3);
while($info3 = mysqli_fetch_object($query3)){
    $acc_offer_amt[$info3->chalan_no] = $info3->amt;
}


// dealer type
$sql_d="select id,dealer_type from dealer_type where 1";
$queryd = mysqli_query($conn,$sql_d);
while($dt=mysqli_fetch_object($queryd)){
    $dealer_type_show[$dt->id]=$dt->dealer_type;
}


$userinfo = getData2("select user_id,fname,PBI_ID from user_activity_management");

$team_name = getData("select id,dealer_team from dealer_team");

?>
<table id="ExportTable" width="100%" cellspacing="0" cellpadding="2" border="0">
<thead>
<tr><td style="border:0px;" colspan="16"><?=$str?></td></tr>
<tr>
    <th>S/L</th>
    <th>Chalan No</th>
    <th>SO No</th><th>SO Date</th>
    <th>EmpCode</th><th>Order EntryBy</th>
    <th>Chalan Date</th>
    <th>Company Name</th><th>Division</th><th>Depot</th>
    <th>Total Qty</th>
    <th>Total Amt</th>
    <th>Comm%</th>
</tr>

</thead><tbody>
<?
$sqls="select c.chalan_no,m.do_no,m.do_date,c.driver_name as serial_no,c.chalan_date,
d.dealer_code2 as code,d.dealer_name_e as dealer_name,w.warehouse_name as depot,sum(c.total_amt) as total_amt,sum(c.total_unit) as qty,
m.group_for,d.zone_id,
m.delivery_address,sum(c.n_amt) as net_sales,sum(c.vat_amt) as vat_amt, m.comm_per,c.sales_type,m.entry_by

from sale_do_master m, sale_do_chalan c, dealer_info d, warehouse w
where  m.do_no=c.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=c.depot_id 
".$depot_con.$date_con.$pg_con.$dealer_cond.$dealer_type_con.$group_for_con.$location.$cor_team_con." 
and m.status in ('CHECKED','COMPLETED')
group by chalan_no order by c.entry_at";

$query = mysqli_query($conn,$sqls);
while($data=mysqli_fetch_object($query)){
$s++;

$dis = $discount[$data->chalan_no];
$sp_dis = $sp_discount[$data->chalan_no];
$sales = $data->total_amt;
$rcv_t = $rcv_t+$data->rcv_amt;
$dp_t = $dp_t + $dis;
$sp_dp_t = $sp_dp_t + $sp_dis;
$tp_t = $tp_t + ($sales-$dis);

$actual_sales=($sales-$sp_dis);

$tas+=$actual_sales;

?>

<tr>
<td><?=$s?></td>
<td><a href="../../../warehouse_mod/pages/wo/route_chalan_view.php?v_no=<?=$data->chalan_no?>" target="_blank"><?=$data->chalan_no?></a>
<a href="../../../warehouse_mod/pages/wo/route_bill_view.php?v_no=<?=$data->chalan_no?>" target="_blank">Invoice</a>
</td>

<td><?=$data->do_no?></td>
<td><?=$data->do_date?></td>

<td><?=$userinfo[$data->entry_by][1];?></td>
<td><?=$userinfo[$data->entry_by][0];?></td>

<td><?=$data->chalan_date?></td>

<td><?=show_company2($data->group_for);?></td>

<td><?=$zone_info[$data->zone_id]?></td>

<td><?=$data->depot?></td>

<td><?=$data->qty; $gqty+=$data->qty;?></td>
<td><?=number_format(($sales-$dis),2); $gamt+=($sales-$dis)?></td>

<td><?=$data->comm_per;?></td>
</tr>
<?}?>

<tr class="footer">

<td colspan="9"></td>
<td>Total</td>
<td><?=$gqty?></td>
<td><?=$gamt?></td>
</tr>


</tbody></table>



<?

} // end report




elseif($_REQUEST['report']==702) { 


if(isset($dealer_code)){$dealer_con=' and d.dealer_code='.$dealer_code;}

$date_con=' and m.do_date between "'.$fr_date.'" and "'.$to_date.'" ';


if(isset($return_type)) {$return_type_con=' and m.party_return_type="'.$return_type.'"';}


if(isset($dealer_type)) {$dtype_con=' and d.dealer_type="'.$dealer_type.'"';} 

if($_POST['depot_id']>0) { $depot_con=' and w.warehouse_id="'.$_POST['depot_id'].'"';}   

$location=''; $location2='';

if(isset($region_id)) 			{$location.=' and region_id="'.$region_id.'"'; $location2.=' and d.region_id="'.$region_id.'"';}

if(isset($zone_id)) 			{$location.=' and zone_id="'.$zone_id.'"'; $location2.=' and d.zone_id="'.$zone_id.'"';}

if(isset($area_id)) 			{$location.=' and area_id="'.$area_id.'"'; $location2.=' and d.area_code="'.$area_id.'"';}

if(isset($route_id)) 			{$location.=' and route_id="'.$route_id.'"'; $location2.=' and d.route_id="'.$route_id.'"';}
 

?>

<table id="ExportTable" width="100%" cellspacing="0" cellpadding="2" border="0">

<thead><tr><td style="border:0px;" colspan="11"><?=$str?></td></tr>

<tr>

<th>S/L</th>

<th>SR No</th>

<th>SR Date</th>

<th>Depot</th>

<th>Return Type</th>


<th>Company</th>
<th>Chanal No </th>
<th>Chanal Date </th>

<th>Return Qty</th>
<th>Total Amount</th>
<th>Remarks</th>

</tr>

</thead><tbody>



<?
$sql="select m.do_no,m.do_date,m.party_return_type,s.chalan_no,s.chalan_date,d.dealer_code2,d.dealer_name_e as dealer_name,
w.warehouse_name as depot,sum(s.total_unit) as total_qty,sum(s.total_amt) as total_amt,sum(s.trade_amt) as trade_offer,m.status,m.group_for,m.remarks

from sale_return_master m,sale_return_details s, dealer_info d, warehouse w, item_info i
where m.do_no=s.do_no and m.status in ('CHECKED','COMPLETED') 
and m.dealer_code=d.dealer_code 
and w.warehouse_id=m.depot_id 
and i.item_id=s.item_id
".$company_con.$depot_con.$date_con.$item_con.$dealer_cond.$dtype_con.$location2.$return_type_con." 
group by m.do_no
order by m.do_date,m.do_no";

$query = mysql_query($sql);
while($data=mysql_fetch_object($query)){$s++;
?>

<tr>

<td><?=$s?></td>

<td><a href="../sales_return/sales_invoice_print_view.php?v_no=<?=$data->do_no?>" target="_blank"><?=$data->do_no?></a></td>

<td><?=$data->do_date?></td>



<td><?=$data->depot?></td>

<td><?=$data->party_return_type?></td> 

<td><? echo show_company2($data->group_for);?></td>

<td><?=$data->chalan_no?></td>
<td><?=$data->chalan_date?></td>


<td><?=$data->total_qty; $gtotal_qty+=$data->total_qty?></td>
<td style="text-align:right"><?=$data->total_amt; $gtotal=$total+$data->total_amt?></td>

<td></td>
</tr>

<? 
$vat='';
} ?>



<tr class="footer">

<td>&nbsp;</td><td>&nbsp;</td>
<td style="text-align:right">&nbsp;</td>
<td style="text-align:right">&nbsp;</td>
<td style="text-align:right">&nbsp;</td>
<td style="text-align:right">&nbsp;</td>
<td style="text-align:right">&nbsp;</td>

<td style="text-align:right;">Total Amount</td>
<td><?=$gtotal_qty?></td>
<td style="text-align:right;"><?=number_format($gtotal,2)?></td>

</tr>

</tbody>

</table>

<? }




elseif($_REQUEST['report']==703) { 



if(isset($group_for)){$company_con=' and m.group_for='.$group_for;}

if(isset($dealer_code)){$dealer_con=' and d.dealer_code='.$dealer_code;}

$date_con=' and m.do_date between "'.$fr_date.'" and "'.$to_date.'" ';    

if(isset($return_type)) {$return_type_con=' and m.party_return_type="'.$return_type.'"';}

if(isset($dealer_type)) {$dtype_con=' and d.dealer_type="'.$dealer_type.'"';} 

if($_POST['depot_id']>0) { $depot_con=' and w.warehouse_id="'.$_POST['depot_id'].'"';}   

$location=''; $location2='';
if(isset($region_id)) 			{$location.=' and region_id="'.$region_id.'"'; $location2.=' and d.region_id="'.$region_id.'"';}
if(isset($zone_id)) 			{$location.=' and zone_id="'.$zone_id.'"'; $location2.=' and d.zone_id="'.$zone_id.'"';}
if(isset($area_id)) 			{$location.=' and area_id="'.$area_id.'"'; $location2.=' and d.area_code="'.$area_id.'"';}
if(isset($route_id)) 			{$location.=' and route_id="'.$route_id.'"'; $location2.=' and d.route_id="'.$route_id.'"';}

$fg_type        = getData("select id,type_name from product_type");   
?>

<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">

<thead><tr><td style="border:0px;" colspan="14"><?=$str?></td></tr>

<tr>

<th>S/L</th>

<th>SR No</th>
<th>SR Date</th>
<th>FG Code</th><th>Item Name</th>
<th>Depot</th>
<th>Return Type</th>
<th>Chalan No</th>
<th>Chalan Date</th>

<th>Total Unit</th>
<th>Unit Price</th>
<th>Total Amount</th>
<th>Status</th>
</tr>
</thead><tbody>

<?

$sql="select m.do_no,i.fg_type,i.finish_goods_code,i.item_name,m.party_return_type,m.do_date,d.dealer_code2,d.dealer_name_e as dealer_name,w.warehouse_name as depot,s.unit_price,s.total_unit,s.total_amt,m.status,s.chalan_no,s.chalan_date

from sale_return_master m,sale_return_details s,dealer_info d  , warehouse w, item_info i

where m.do_no=s.do_no and m.status in ('CHECKED','COMPLETED') 

and m.dealer_code=d.dealer_code 

and w.warehouse_id=m.depot_id 

and i.item_id=s.item_id

".$company_con.$depot_con.$date_con.$item_con.$dealer_cond.$dtype_con.$location2.$return_type_con." 

order by m.do_date,m.do_no";

$query = mysql_query($sql);

while($data=mysql_fetch_object($query)){$s++;

?>

<tr>

<td><?=$s?></td>

<td><?=$data->do_no?></td>
<td><?=$data->do_date?></td>

<td><?=$data->finish_goods_code?></td>

<td><?=$data->item_name?></td>



<td><?=$data->depot?></td>  
<td><?=$data->party_return_type?></td>  

<td><?=$data->chalan_no?></td><td><?=$data->chalan_date?></td>


<td><?=$data->total_unit; $gqty+=$data->total_unit;?></td>
<td><?=$data->unit_price?></td>



<td style="text-align:right"><?=$data->total_amt; $total=$total+$data->total_amt?></td>

<td style="text-align:right"><?=$data->status?></td>

</tr>

<? } ?>

<tr class="footer">
<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
<td style="text-align:right">&nbsp;</td>
<td style="text-align:right">&nbsp;</td>
<td style="text-align:right;">Total</td>
<td style="text-align:right">&nbsp;</td>
<td style="text-align:right"><?=$gqty;?></td>
<td style="text-align:right;"><?=number_format($total,2)?></td>
</tr>
</tbody>
</table>
<? }



elseif($_REQUEST['report']==704) {



if($_POST['dealer_code']<1){die("select party");}

if($_POST['dealer_code']>0){ $dealer_code=$_POST['dealer_code'];}



$party_info=findall("select * from dealer_info where dealer_code='".$dealer_code."'");



$ledger_id=$party_info->final_account_code;

echo $dealer_code;



if($_POST['group_for']>0){ $company_con=' and group_for="'.$_POST['group_for'].'"'; 

    $group_name = find1("select group_name from user_group where id='".$_POST['group_for']."'");

}else{$group_name='MEP Group';}

$op='';

?>



<div class="row">

    

    <div class="col">

    <? if($_POST['group_for']>0){ ?>
    <!--<img src="../../../logo/<?=$_POST['group_for']?>.png" width="200px" alt="logo" > -->
    <? }else{ ?>

    <!--<img src="../../../logo/group_logo.png" width="200px" alt="logo" >-->

    <? } ?>

    </div>   



    <div class="col"><center>

            <div><h2><?=$group_name;?></h2></div>

            <div>Swarup Ali Chairman Lane, Hatkhola, Barishal-8200</div>

            <div><strong>Party Ledger Report</strong></div>

            <div>Date From: <?=$_POST['f_date'];?> to <?=$_POST['t_date'];?></div>

        </center>

    </div>

    

    <div class="col">

    </div>     

    

</div>









<div class="container mt-2">

<div class="row">

    

    <div class="col">

        <span style="font-weight:700;">Code: <?=$party_info->dealer_code2;?></span>

        <br>
		
		<span style="font-weight:700;">Sub Ledger: <?=$party_info->sub_ledger_id;?></span>

        <br>

        <span style="font-weight:700;">Buyer Name: <?=$party_info->dealer_name_e;?></span>

        <br>

        <span>Address: <?=$party_info->address_e;?></span>

    </div>

    <div class="col text-right">

        <span>Type: <?=find1("select dealer_type from dealer_type where id='".$party_info->dealer_type."'");?></span>

        <br><span>Mobile: <?=$party_info->mobile_no;?></span>

        <br><span>Opening Balance: <strong><?

        $sql_op="select sum(dr_amt-cr_amt) from journal where ledger_id='".$ledger_id."' and sub_ledger=".$party_info->sub_ledger_id."  ".$company_con." and jv_date<'".$_POST['f_date']."'";

        echo $op=(int)find1($sql_op);

        ?></strong></span>

    </div>



</div>



<style>

 table.myFormat th tr td { 

     font-size: 14px;

 }  

 table, th, td {

  border: 1px solid black;

  border-collapse: collapse;

}

.table-bordered td, .table-bordered th{

    border-color: black !important;

}

</style>







<table id="ExportTable" class="table table-bordered mt-3 myFormat">

  <thead>

    <tr>

      <th>SL</th>

      <th style="width:12%">Date</th>


      <th scope="col">Particular</th>

      <th scope="col">Ref. No</th>

      <th scope="col">Company Name</th>

      

      <th scope="col">Debit</th>

      <th scope="col">Credit</th>

      <th scope="col">Balance</th>

    </tr>

  </thead>

  <tbody>

<?

$sql1="select * from journal where ledger_id=".$ledger_id." and sub_ledger=".$party_info->sub_ledger_id."  

".$company_con." 

and jv_date between '".$_POST['f_date']."' and '".$_POST['t_date']."' order by jv_date";

$query=mysql_query($sql1);

$sl=1;

while($data=mysql_fetch_object($query)){

?>

    <tr>

      <td><?=$sl++?></td>

      <td style=""><?=$data->jv_date?></td>

      <!--<td><?=$data->jv_no?></td>-->

      <td><?=$data->tr_from?> - <?=$data->narration?></td>

      <td><?=$data->tr_no?></td>

      <td><?=find1("select company_short_code from user_group where id='".$data->group_for."'");?></td>

      

      <td style="text-align: right;"><?=$data->dr_amt; $gdr_amt+=$data->dr_amt;?></td>

      <td style="text-align: right;"><?=$data->cr_amt; $gcr_amt+=$data->cr_amt;?></td>

      <td style="text-align: right;"><? $closing=($op+$data->dr_amt-$data->cr_amt); echo number_format($closing,2); $op=$closing;?></td>

    </tr>

<? }?>

<tr class="font-weight-bold">

    <td colspan='5'><div class="text-right">Grand Total:</div></td>

    <td style="text-align: right;"><?=$gdr_amt?></td>

    <td style="text-align: right;"><?=$gcr_amt?></td>

    <td style="text-align: right;"><? if($se==0){ echo $op;}else{ echo $closing; }?></td>

</tr>

</tbody>

</table>

<p>Printing Time: <? echo date('Y-m-d H:i:s');?></p>



<div class="text-center"><strong>This is a computer generated statement and not require any signature</strong></div>

</div>





<? 

} // end report





elseif($_POST['report']==53) {

$location='';
if(isset($region_id)) 			{$location.=' and region_id="'.$region_id.'"';}
if(isset($zone_id)) 			{$location.=' and zone_id="'.$zone_id.'"';}
if(isset($area_id)) 			{$location.=' and area_id="'.$area_id.'"';}


	if(isset($t_date)) {
		$to_date=$t_date; 
		$fr_date=$f_date; 

		$yfr_date=(date(('Y'),strtotime($f_date))-1).date(('-m-d'),strtotime($f_date));
		$yto_date=(date(('Y'),strtotime($t_date))-1).date(('-m-d'),strtotime($t_date));
		
		$date_con2=' and a.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';
		$date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';
		$ydate_con=' and a.chalan_date between \''.$yfr_date.'\' and \''.$yto_date.'\'';
		}
		if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
		if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
		
		//if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}

		

if(isset($area_id)) 		{$acon.=' and d.area_code="'.$area_id.'"';}
if(isset($zone_id)) 		{$acon.=' and d.zone_id="'.$zone_id.'"';}
if(isset($region_id)) 		{$acon.=' and d.region_id="'.$region_id.'"';}
 
 
// product group
$sql1="select id,group_name as name from product_group where 1";
$q=mysqli_query($conn,$sql1);
while($info1=mysqli_fetch_object($q)){
    $pgname[$info1->id]=$info1->name;
}

//category
$sql2="select id,category_name as name from item_category where 1";
$q=mysqli_query($conn,$sql2);
while($info2=mysqli_fetch_object($q)){
    $catname[$info2->id]=$info2->name;
}


//Sub category
$sql3="select id,subcategory_name as name from item_subcategory where 1";
$q=mysqli_query($conn,$sql3);
while($info3=mysqli_fetch_object($q)){
    $subcatname[$info3->id]=$info3->name;
}
 
// order
$sql1='select i.item_id,sum(a.total_unit) as qty,sum(a.total_amt) as amount
from ss_do_master m, ss_shop d, ss_do_details a, item_info i
where m.do_no=a.do_no and d.dealer_code=a.dealer_code and a.item_id=i.item_id and m.status in("CHECKED","COMPLETED")
and m.entry_by="'.$_SESSION['username'].'"
	'.$acon.$con.$date_con2.$warehouse_con.$item_con.$item_brand_con.$dtype_con.' 
	group by i.item_id';

$query1 = mysqli_query($conn,$sql1);
while($data1 = mysqli_fetch_object($query1))
	{
	$do_amt[$data1->item_id] = $data1->amount;
	$do_qty[$data1->item_id] = $data1->qty;
	} 
 

// sales
$sql2='select i.item_id,sum(a.total_unit) qty,sum(a.total_amt) as sale_price
from ss_do_master m,ss_shop d, ss_do_chalan a, item_info i
where m.do_no=a.do_no and d.dealer_code=a.dealer_code and a.item_id=i.item_id and m.entry_by="'.$_SESSION['username'].'"
	'.$acon.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.' 
	group by i.item_id';
$query2 = mysqli_query($conn,$sql2);
while($data2 = mysqli_fetch_object($query2))
	{
	$sale_amt[$data2->item_id] = $data2->sale_price;
	$sale_qty[$data2->item_id] = $data2->qty;
	}



// target information	
$fmon = date("Ym",strtotime($f_date));
$tmon = date("Ym",strtotime($t_date));

$sql4='select i.item_id,sum(t.target_qty) as target , sum(t.target_amt) as amount
from sale_target_so t, item_info i
where t.item_id=i.item_id and t.target_period between "'.$fmon.'" and  "'.$tmon.'" and t.so_code="'.$_SESSION['username'].'" 
'.$acon.$item_con.'
group by i.item_id';

$query2 = mysqli_query($conn,$sql4);
while($data2 = mysqli_fetch_object($query2)){
$target_qty[$data2->item_id] = $data2->target;
$target_amt[$data2->item_id] = $data2->amount;
}

?>
<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;zoom: 60%;">
<thead>
<tr>
<td style="border:0px;" colspan="12"><?=$str?><div class="left"></div>
<div class="right"></div>
<div class="date">Reporting Time: <?=date("h:i A d-m-Y")?>.</div></td>
</tr>

<tr class="bg-night-light1">
  <th rowspan="2">S/L</th>
  <th rowspan="2">FG Code</th>
  <th rowspan="2">Product Name</th>
  <th rowspan="2">Group</th>
  <th rowspan="2">Category</th>
  <th rowspan="2">SubCategory</th>
  <th colspan="2"><div align="center">Target</div></th>
  <th colspan="2"><div align="center">Order</div></th>
  <th colspan="2"><div align="center">Delivery</div></th>
  <th colspan="2"><div align="center">Achievement(%)</div></th>
  <th colspan="2"><div align="center">Due/Over Qty</div></th>
  <th colspan="2"><div align="center">Due/Over Amount</div></th>
  <th rowspan="2">Remarks</th>
</tr>

<tr>
  <th scope="col" class="color-white">Qty</th>
  <th scope="col" class="color-white">Amount</th>
  
  <th scope="col" class="color-white">Order Qty</th>
  <th scope="col" class="color-white">Order Amt </th>
  
  <th scope="col" class="color-white">Sales Qty</th>
  <th scope="col" class="color-white">Sales Amt </th>
  
  <th scope="col" class="color-white">Target vs Order</th>
  <th scope="col" class="color-white">Order vs Delivery </th> 
  
  <th scope="col" class="color-white">Target vs Order</th>
  <th scope="col" class="color-white">Order vs Delivery </th>   
  
  <th scope="col" class="color-white">Target vs Order</th>
  <th scope="col" class="color-white">Order vs Delivery </th>  


</tr>
</thead><tbody>
<?
$sql='select i.item_id,i.finish_goods_code as fg_code,i.item_name,i.item_group,i.category_id,i.subcategory_id,i.unit_name from item_info i where 1 and i.sub_group_id=100100000
'.$item_brand_con.$pg_con.$item_con.' 
order by i.item_group,i.category_id,i.subcategory_id';

$query = mysqli_query($conn,$sql);
while($data=mysqli_fetch_object($query)){
    if($target_qty[$data->item_id]>0 || $do_qty[$data->item_id]>0 || $sale_qty[$data->item_id]>0){

$TvO = number_format((($do_amt[$data->item_id]/$target_amt[$data->item_id])*100),2);
$OvD = number_format((($sale_amt[$data->item_id]/$do_amt[$data->item_id])*100),2);

$TvOq = (int)($target_qty[$data->item_id]-$do_qty[$data->item_id]);
$OvDq = (int)($do_qty[$data->item_id]-$sale_qty[$data->item_id]);

$TvOa = (int)($target_amt[$data->item_id]-$do_amt[$data->item_id]);
$OvDa = (int)($do_amt[$data->item_id]-$sale_amt[$data->item_id]);

?>
<tr><td><?=++$s?></td>
  <td><?=$data->fg_code;?></td>
  <td><?=$data->item_name;?></td>
  
  <td><?=$pgname[$data->item_group];?></td>
  <td><?=$catname[$data->category_id];?></td>
  <td><?=$subcatname[$data->subcategory_id];?></td>
  
  <td style="text-align:right"><? echo number_format($target_qty[$data->item_id],0); $gtqty += $target_qty[$data->item_id]; ?></td>
  <td style="text-align:right"><? echo number_format($target_amt[$data->item_id],0); $gtamt += $target_amt[$data->item_id]; ?></td>
  
  <td style="text-align:right"><? echo number_format($do_qty[$data->item_id],0); $gdqty += $do_qty[$data->item_id]; ?></td>
  <td style="text-align:right"><? echo number_format($do_amt[$data->item_id],0); $gdamt += $do_amt[$data->item_id]; ?></td> 
  
  <td style="text-align:right"><? echo number_format($sale_qty[$data->item_id],0); $gsqty += $sale_qty[$data->item_id]; ?></td>
  <td style="text-align:right"><? echo number_format($sale_amt[$data->item_id],0); $gsamt += $sale_amt[$data->item_id]; ?></td>  
  
<td style="text-align:right"><?=$TvO?> %</td>
<td style="text-align:right"><?=$OvD?> %</td>
  
<td style="text-align:right"><?=$TvOq?></td>
<td style="text-align:right"><?=$OvDq?></td>  
  
<td style="text-align:right"><?=$TvOa?></td>
<td style="text-align:right"><?=$OvDa?></td> 
  
  <td style="text-align:right"></td>

</tr>

<? 
}}

$gTvO = number_format((($gdamt/$gtamt)*100),2);
$gOvD = number_format((($gsamt/$gdamt)*100),2);

$gTvOq = (int)($gtqty-$gdqty);
$gOvDq = (int)($gdqty-$gsqty);

$gTvOa = (int)($gtamt-$gdamt);
$gOvDa = (int)($gdamt-$gsamt);
?>
<tr style="font-weight:bold">
  <td  style="text-align:right" colspan="6">Total</td>
  <td style="text-align:right"><?=number_format($gtqty,0);?></td>
  <td style="text-align:right"><?=number_format($gtamt,2);?></td>
  
  <td style="text-align:right"><?=number_format($gdqty,0);?></td>
  <td style="text-align:right"><?=number_format($gdamt,2);?></td>
  
  <td style="text-align:right"><?=number_format($gsqty,0);?></td>
  <td style="text-align:right"><?=number_format($gsamt,2);?></td>
  
  <td style="text-align:right"><?=$gTvO?> %</td>
  <td style="text-align:right"><?=$gOvD?> %</td>
  
  <td style="text-align:right"><?=$gTvOq?></td>
  <td style="text-align:right"><?=$gOvDq?></td>  
  
  <td style="text-align:right"><?=$gTvOa?></td>
  <td style="text-align:right"><?=$gOvDa?></td>  
  
  <td style="text-align:right">&nbsp;</td>
</tr>
</tbody></table>
<?
} // end



elseif($_POST['report']==57) {

	if(isset($t_date)) {
		$to_date=$t_date; 
		$fr_date=$f_date; 

		$yfr_date=(date(('Y'),strtotime($f_date))-1).date(('-m-d'),strtotime($f_date));
		$yto_date=(date(('Y'),strtotime($t_date))-1).date(('-m-d'),strtotime($t_date));
		
		$date_con2=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';
		$date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';
		$ydate_con=' and a.chalan_date between \''.$yfr_date.'\' and \''.$yto_date.'\'';
		}
		if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
		if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
		


// sales
$sql2='select m.do_no,sum(a.total_unit) qty,sum(a.total_amt) as sale_price
from ss_do_master m,ss_shop d, ss_do_chalan a
where m.do_no=a.do_no and d.dealer_code=a.dealer_code 
'.$acon.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.' 
group by m.do_no';

$query2 = mysqli_query($conn,$sql2);
while($data2 = mysqli_fetch_object($query2))
	{
	$sale_amt[$data2->do_no] = $data2->sale_price;
	$sale_qty[$data2->do_no] = $data2->qty;
	}


?>
<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;zoom: 60%;">
<thead>
<tr>
<td style="border:0px;" colspan="12"><?=$str?><div class="left"></div>
<div class="right"></div>
<div class="date">Reporting Time: <?=date("h:i A d-m-Y")?>.</div></td>
</tr>


<tr class="bg-night-light1">
  <th scope="col" class="color-white">SL</th>    
  <th scope="col" class="color-white">Order No</th>
  <th scope="col" class="color-white">Order Date</th>
  <th scope="col" class="color-white">Party Code</th>
  <th scope="col" class="color-white">Party Name </th>
  <th scope="col" class="color-white">Party Address</th>
  <th scope="col" class="color-white">Order Qty</th>
  <th scope="col" class="color-white">Order Amount</th>
</tr>
</thead><tbody>
<?
$res="select m.do_no,m.do_date,m.dealer_code,s.shop_name,s.shop_address,sum(d.total_unit) as qty,sum(d.total_amt) as amount
from ss_do_master m, ss_do_details d, ss_shop s
where m.do_no=d.do_no and m.dealer_code=s.dealer_code and m.entry_by='".$_SESSION['username']."' and m.status in('CHECKED','COMPLETED')
".$date_con2.$dealer_conm."
group by m.do_no
order by m.do_no";
$query = mysqli_query($conn, $res);
while($data=mysqli_fetch_object($query)){
$order_qty = $data->qty; $order_amt=$data->amount;
$delivery_qty = $sale_qty[$data->do_no]; $delivery_amt = $sale_amt[$data->do_no];
$pending_qty = $order_qty-$delivery_qty;
$pending_amt = $order_amt-$delivery_amt;
if($pending_qty>0){
?>
<tr><td><?=++$s?></td>
  <td><?=$data->do_no;?></td>
  <td><?=$data->do_date;?></td>
  <td><?=$data->dealer_code;?></td>
  <td><?=$data->shop_name;?></td>
  <td><?=$data->shop_address;?></td>
  <td style="text-align:right"><?=$pending_qty; $gtqty+=$pending_qty;?></td>
  <td style="text-align:right"><?=$pending_amt; $gtamt+=$pending_amt;?></td>
</tr>

<? }}?>
<tr style="font-weight:bold">
  <td  style="text-align:right" colspan="6">Total</td>
  <td style="text-align:right"><?=number_format($gtqty,0);?></td>
  <td style="text-align:right"><?=number_format($gtamt,2);?></td>
</tr>
</tbody></table>
<?
} // end




elseif($_POST['report']==56) {

$location='';
if(isset($region_id)) 			{$location.=' and region_id="'.$region_id.'"';}
if(isset($zone_id)) 			{$location.=' and zone_id="'.$zone_id.'"';}
if(isset($area_id)) 			{$location.=' and area_id="'.$area_id.'"';}


	if(isset($t_date)) {
		$to_date=$t_date; 
		$fr_date=$f_date; 

		$yfr_date=(date(('Y'),strtotime($f_date))-1).date(('-m-d'),strtotime($f_date));
		$yto_date=(date(('Y'),strtotime($t_date))-1).date(('-m-d'),strtotime($t_date));
		
		$date_con2=' and a.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';
		$date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';
		$ydate_con=' and a.chalan_date between \''.$yfr_date.'\' and \''.$yto_date.'\'';
		}
		if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
		if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
		
		//if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}

		

if(isset($area_id)) 		{$acon.=' and d.area_code="'.$area_id.'"';}
if(isset($zone_id)) 		{$acon.=' and d.zone_id="'.$zone_id.'"';}
if(isset($region_id)) 		{$acon.=' and d.region_id="'.$region_id.'"';}
 
 
// product group
$sql1="select id,group_name as name from product_group where 1";
$q=mysqli_query($conn,$sql1);
while($info1=mysqli_fetch_object($q)){
    $pgname[$info1->id]=$info1->name;
}


 
// order
$sql1='select i.item_group,sum(a.total_unit) as qty,sum(a.total_amt) as amount
from ss_do_master m, ss_shop d, ss_do_details a, item_info i
where m.do_no=a.do_no and d.dealer_code=a.dealer_code and a.item_id=i.item_id and m.status in("CHECKED","COMPLETED")  
and m.entry_by="'.$_SESSION['username'].'"
'.$acon.$con.$date_con2.$warehouse_con.$item_con.$item_brand_con.$dtype_con.' 
group by i.item_group';

$query1 = mysqli_query($conn,$sql1);
while($data1 = mysqli_fetch_object($query1))
	{
	$do_amt[$data1->item_group] = $data1->amount;
	$do_qty[$data1->item_group] = $data1->qty;
	} 
 

// sales
$sql2='select i.item_group,sum(a.total_unit) qty,sum(a.total_amt) as sale_price
from ss_do_master m,ss_shop d, ss_do_chalan a, item_info i
where m.do_no=a.do_no and d.dealer_code=a.dealer_code and a.item_id=i.item_id  
and m.entry_by="'.$_SESSION['username'].'"
'.$acon.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.' 
group by i.item_group';
$query2 = mysqli_query($conn,$sql2);
while($data2 = mysqli_fetch_object($query2))
	{
	$sale_amt[$data2->item_group] = $data2->sale_price;
	$sale_qty[$data2->item_group] = $data2->qty;
	}


// target information	
$fmon = date("Ym",strtotime($f_date));
$tmon = date("Ym",strtotime($t_date));

$sql4='select i.item_group,sum(t.target_qty) as target , sum(t.target_amt) as amount
from sale_target_so t, item_info i
where t.item_id=i.item_id and t.target_period between "'.$fmon.'" and  "'.$tmon.'" and t.so_code="'.$_SESSION['username'].'" 
'.$acon.$item_con.'
group by i.item_group';

$query2 = mysqli_query($conn,$sql4);
while($data2 = mysqli_fetch_object($query2)){
$target_qty[$data2->item_group] = $data2->target;
$target_amt[$data2->item_group] = $data2->amount;
}

?>
<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;zoom: 60%;">
<thead>
<tr>
<td style="border:0px;" colspan="12"><?=$str?><div class="left"></div></td>
</tr>

<tr class="bg-night-light1">
  <th rowspan="2">S/L</th>
  <th rowspan="2">Group</th>
  <th colspan="2"><div align="center">Target</div></th>
  <th colspan="2"><div align="center">Order</div></th>
  <th colspan="2"><div align="center">Delivery</div></th>
  <th colspan="2"><div align="center">Achievement(%)</div></th>
  <th colspan="2"><div align="center">Due/Over Qty</div></th>
  <th colspan="2"><div align="center">Due/Over Amount</div></th>
  <th rowspan="2">Remarks</th>
</tr>

<tr>
  <th scope="col" class="color-white">Qty</th>
  <th scope="col" class="color-white">Amount</th>
  
  <th scope="col" class="color-white">Order Qty</th>
  <th scope="col" class="color-white">Order Amt </th>
  
  <th scope="col" class="color-white">Sales Qty</th>
  <th scope="col" class="color-white">Sales Amt </th>
  
  <th scope="col" class="color-white">Target vs Order</th>
  <th scope="col" class="color-white">Order vs Delivery </th> 
  
  <th scope="col" class="color-white">Target vs Order</th>
  <th scope="col" class="color-white">Order vs Delivery </th>   
  
  <th scope="col" class="color-white">Target vs Order</th>
  <th scope="col" class="color-white">Order vs Delivery </th>   

</tr>
</thead><tbody>
<?
$sql='select i.item_group from item_info i where 1 and i.sub_group_id=100100000
'.$item_brand_con.$pg_con.$item_con.' 
group by i.item_group
order by i.item_group';

$query = mysqli_query($conn,$sql);
while($data=mysqli_fetch_object($query)){

$TvO = number_format((($do_amt[$data->item_group]/$target_amt[$data->item_group])*100),2);
$OvD = number_format((($sale_amt[$data->item_group]/$do_amt[$data->item_group])*100),2);

$TvOq = (int)($target_qty[$data->item_group]-$do_qty[$data->item_group]);
$OvDq = (int)($do_qty[$data->item_group]-$sale_qty[$data->item_group]);

$TvOa = (int)($target_amt[$data->item_group]-$do_amt[$data->item_group]);
$OvDa = (int)($do_amt[$data->item_group]-$sale_amt[$data->item_group]);

// fan
if($data->item_group==12){
    $fan_targetqty=$target_qty[$data->item_group];
    $fan_targetamt=$target_amt[$data->item_group];
    
    $fan_orderqty=$do_qty[$data->item_group];
    $fan_orderamt=$do_amt[$data->item_group];
    
    $fan_chalanqty=$sale_qty[$data->item_group];
    $fan_chalanamt=$sale_amt[$data->item_group];
    
$fanTvO = number_format((($fan_orderqty/$fan_targetamt)*100),2);
$fanOvD = number_format((($fan_chalanamt/$fan_orderamt)*100),2);

$fanTvOq = (int)($fan_targetqty-$fan_orderqty);
$fanOvDq = (int)($fan_orderqty-$fan_chalanqty);

$fanTvOa = (int)($fan_targetamt-$fan_orderamt);
$fanOvDa = (int)($fan_orderamt-$fan_chalanamt);
    
} // end fan

?>
<tr><td><?=++$s?></td>
  <td><?=$pgname[$data->item_group];?></td>
  
  <td style="text-align:right"><? echo number_format($target_qty[$data->item_group],0); $gtqty += $target_qty[$data->item_group]; ?></td>
  <td style="text-align:right"><? echo number_format($target_amt[$data->item_group],0); $gtamt += $target_amt[$data->item_group]; ?></td>
  
  <td style="text-align:right"><? echo number_format($do_qty[$data->item_group],0); $gdqty += $do_qty[$data->item_group]; ?></td>
  <td style="text-align:right"><? echo number_format($do_amt[$data->item_group],0); $gdamt += $do_amt[$data->item_group]; ?></td> 
  
  <td style="text-align:right"><? echo number_format($sale_qty[$data->item_group],0); $gsqty += $sale_qty[$data->item_group]; ?></td>
  <td style="text-align:right"><? echo number_format($sale_amt[$data->item_group],0); $gsamt += $sale_amt[$data->item_group]; ?></td>  
  
  <td style="text-align:right"><?=$TvO?> %</td>
  <td style="text-align:right"><?=$OvD?> %</td>
  
  <td style="text-align:right"><?=$TvOq?></td>
  <td style="text-align:right"><?=$OvDq?></td>  
  
  <td style="text-align:right"><?=$TvOa?></td>
  <td style="text-align:right"><?=$OvDa?></td>
  
  <td style="text-align:right"></td>
</tr>
<? }
$gTvO = number_format((($gdamt/$gtamt)*100),2);
$gOvD = number_format((($gsamt/$gdamt)*100),2);

$gTvOq = (int)($gtqty-$gdqty);
$gOvDq = (int)($gdqty-$gsqty);

$gTvOa = (int)($gtamt-$gdamt);
$gOvDa = (int)($gdamt-$gsamt);

?>
<tr style="font-weight:bold">
  <td  style="text-align:right" colspan="2">Grand Total</td>
  <td style="text-align:right"><?=number_format($gtqty,0);?></td>
  <td style="text-align:right"><?=number_format($gtamt,2);?></td>
  
  <td style="text-align:right"><?=number_format($gdqty,0);?></td>
  <td style="text-align:right"><?=number_format($gdamt,2);?></td>
  
  <td style="text-align:right"><?=number_format($gsqty,0);?></td>
  <td style="text-align:right"><?=number_format($gsamt,2);?></td>
  
  <td style="text-align:right"><?=$gTvO?> %</td>
  <td style="text-align:right"><?=$gOvD?> %</td>
  
  <td style="text-align:right"><?=$gTvOq?></td>
  <td style="text-align:right"><?=$gOvDq?></td>  
  
  <td style="text-align:right"><?=$gTvOa?></td>
  <td style="text-align:right"><?=$gOvDa?></td>  
  
  <td style="text-align:right">&nbsp;</td>
</tr>
<!--fan total-->
<tr style="font-weight:bold">
  <td style="text-align:right" colspan="2">FAN Total</td>
  <td style="text-align:right"><?=number_format($fan_targetqty,0);?></td>
  <td style="text-align:right"><?=number_format($fan_targetamt,2);?></td>
  
  <td style="text-align:right"><?=number_format($fan_orderqty,0);?></td>
  <td style="text-align:right"><?=number_format($fan_orderamt,2);?></td>
  
  <td style="text-align:right"><?=number_format($fan_chalanqty,0);?></td>
  <td style="text-align:right"><?=number_format($fan_chalanamt,2);?></td>
  
  <td style="text-align:right"><?=$fanTvO?> %</td>
  <td style="text-align:right"><?=$fanOvD?> %</td>
  
  <td style="text-align:right"><?=$fanTvOq?></td>
  <td style="text-align:right"><?=$fanOvDq?></td>  
  
  <td style="text-align:right"><?=$fanTvOa?></td>
  <td style="text-align:right"><?=$fanOvDa?></td>  
  
  <td style="text-align:right">&nbsp;</td>
</tr>
<?
// find out without fan
$wfan_targetqty=$gtqty-$fan_targetqty;
$wfan_targetamt=$gtamt-$fan_targetamt;
    
$wfan_orderqty=$gdqty-$fan_orderqty;
$wfan_orderamt=$gdamt-$fan_orderamt;
    
$wfan_chalanqty=$gsqty-$fan_chalanqty;
$wfan_chalanamt=$gsamt-$fan_chalanamt;

$wfanTvO = number_format((($wfan_orderamt/$wfan_targetamt)*100),2);
$wfanOvD = number_format((($wfan_chalanamt/$wfan_orderamt)*100),2);

$wfanTvOq = (int)($wfan_targetqty-$wfan_orderqty);
$wfanOvDq = (int)($wfan_orderqty-$wfan_chalanqty);

$wfanTvOa = (int)($wfan_targetamt-$wfan_orderamt);
$wfanOvDa = (int)($wfan_orderamt-$wfan_chalanamt);

?>
<tr style="font-weight:bold">
  <td style="text-align:right" colspan="2">Without FAN Total</td>
  <td style="text-align:right"><?=number_format($wfan_targetqty,0);?></td>
  <td style="text-align:right"><?=number_format($wfan_targetamt,2);?></td>
  
  <td style="text-align:right"><?=number_format($wfan_orderqty,0);?></td>
  <td style="text-align:right"><?=number_format($wfan_orderamt,2);?></td>
  
  <td style="text-align:right"><?=number_format($wfan_chalanqty,0);?></td>
  <td style="text-align:right"><?=number_format($wfan_chalanamt,2);?></td>
  
  <td style="text-align:right"><?=$wfanTvO?> %</td>
  <td style="text-align:right"><?=$wfanOvD?> %</td>
  
  <td style="text-align:right"><?=$wfanTvOq?></td>
  <td style="text-align:right"><?=$wfanOvDq?></td>  
  
  <td style="text-align:right"><?=$wfanTvOa?></td>
  <td style="text-align:right"><?=$wfanOvDa?></td>  
  
  <td style="text-align:right">&nbsp;</td>
</tr>
</tbody></table>
<?
} // end




elseif($_POST['report']==58) {


function get_working_day($sdate) {

	define('ONE_WEEK', 604800);
    $days=0x20;
	$start=strtotime($sdate);
	$tdate = date("Y-m-t", $start);
	$end=strtotime($tdate);

	$w = array(date('w', $start), date('w', $end));
    $x = floor(($end-$start)/ONE_WEEK);
    $sum = 0;

    for ($day = 0;$day < 7;++$day) {
        if ($days & pow(2, $day)) {
            $sum += $x + ($w[0] > $w[1]?$w[0] <= $day || $day <= $w[1] : $w[0] <= $day && $day <= $w[1]);
        }
    }

$date1 = new DateTime($sdate);
$date2 = new DateTime($tdate);
$total_days  = $date2->diff($date1)->format('%a'); 

return $working_days=($total_days-$sum);

} // end 
$wday = get_working_day($_POST['t_date']);



$location='';
if(isset($region_id)) 			{$location.=' and region_id="'.$region_id.'"';}
if(isset($zone_id)) 			{$location.=' and zone_id="'.$zone_id.'"';}
if(isset($area_id)) 			{$location.=' and area_id="'.$area_id.'"';}


	if(isset($t_date)) {
		$to_date=$t_date; 
		$fr_date=$f_date; 

		$yfr_date=(date(('Y'),strtotime($f_date))-1).date(('-m-d'),strtotime($f_date));
		$yto_date=(date(('Y'),strtotime($t_date))-1).date(('-m-d'),strtotime($t_date));
		
		$date_con2=' and a.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';
		$date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';
		$ydate_con=' and a.chalan_date between \''.$yfr_date.'\' and \''.$yto_date.'\'';
		}
		if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
		if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
		
		//if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}

		

if(isset($area_id)) 		{$acon.=' and d.area_code="'.$area_id.'"';}
if(isset($zone_id)) 		{$acon.=' and d.zone_id="'.$zone_id.'"';}
if(isset($region_id)) 		{$acon.=' and d.region_id="'.$region_id.'"';}
 
 
// product group
$sql1="select id,group_name as name from product_group where 1";
$q=mysqli_query($conn,$sql1);
while($info1=mysqli_fetch_object($q)){
    $pgname[$info1->id]=$info1->name;
}


 
// order
$sql1='select i.item_group,sum(a.total_unit) as qty,sum(a.total_amt) as amount
from ss_do_master m, ss_shop d, ss_do_details a, item_info i
where m.do_no=a.do_no and d.dealer_code=a.dealer_code and a.item_id=i.item_id and m.status in("CHECKED","COMPLETED")  
and m.entry_by="'.$_SESSION['username'].'"
'.$acon.$con.$date_con2.$warehouse_con.$item_con.$item_brand_con.$dtype_con.' 
group by i.item_group';

$query1 = mysqli_query($conn,$sql1);
while($data1 = mysqli_fetch_object($query1))
	{
	$do_amt[$data1->item_group] = $data1->amount;
	$do_qty[$data1->item_group] = $data1->qty;
	} 
 

// sales
$sql2='select i.item_group,sum(a.total_unit) qty,sum(a.total_amt) as sale_price
from ss_do_master m,ss_shop d, ss_do_chalan a, item_info i
where m.do_no=a.do_no and d.dealer_code=a.dealer_code and a.item_id=i.item_id  
and m.entry_by="'.$_SESSION['username'].'"
'.$acon.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.' 
group by i.item_group';
$query2 = mysqli_query($conn,$sql2);
while($data2 = mysqli_fetch_object($query2))
	{
	$sale_amt[$data2->item_group] = $data2->sale_price;
	$sale_qty[$data2->item_group] = $data2->qty;
	}


// target information	
$fmon = date("Ym",strtotime($f_date));
$tmon = date("Ym",strtotime($t_date));

$sql4='select i.item_group,sum(t.target_qty) as target , sum(t.target_amt) as amount
from sale_target_so t, item_info i
where t.item_id=i.item_id and t.target_period between "'.$fmon.'" and  "'.$tmon.'" and t.so_code="'.$_SESSION['username'].'" 
'.$acon.$item_con.'
group by i.item_group';

$query2 = mysqli_query($conn,$sql4);
while($data2 = mysqli_fetch_object($query2)){
$target_qty[$data2->item_group] = $data2->target;
$target_amt[$data2->item_group] = $data2->amount;
}

?>
<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;zoom: 60%;">
<thead>
<tr>
<td style="border:0px;" colspan="12"><?=$str?><div class="left"></div></td>
</tr>

<tr class="bg-night-light1">
  <th scope="col" class="color-white">S/L</th>
  <th scope="col" class="color-white">Group</th>
  <th scope="col" class="color-white"><div align="center">Target</div></th>
  <th scope="col" class="color-white"><div align="center">DT</div></th>
  <th scope="col" class="color-white"><div align="center">RDT</div></th>
  <th scope="col" class="color-white"><div align="center">Order</div></th>
  <th scope="col" class="color-white"><div align="center">Delivery</div></th>
  <th scope="col" class="color-white"><div align="center">Target Due/Over</div></th>
  <th scope="col" class="color-white"><div align="center">Achievement(%)</div></th>
</tr>

</thead><tbody>
<?
$sql='select i.item_group from item_info i where 1 and i.sub_group_id=100100000
'.$item_brand_con.$pg_con.$item_con.' 
group by i.item_group
order by i.item_group';

$query = mysqli_query($conn,$sql);
while($data=mysqli_fetch_object($query)){

$TvO = number_format((($do_amt[$data->item_group]/$target_amt[$data->item_group])*100),2);
//$OvD = number_format((($sale_amt[$data->item_group]/$do_amt[$data->item_group])*100),2);
$TvOa = (int)($target_amt[$data->item_group]-$do_amt[$data->item_group]);
?>
<tr>
    <td><?=++$s?></td>
    <td><?=$pgname[$data->item_group];?></td>
    <td style="text-align:right"><? echo number_format($target_amt[$data->item_group],0); $gtamt += $target_amt[$data->item_group]; ?></td>
    <td><? echo $dt=(int)($target_amt[$data->item_group]/30); $gdt+=$dt;?></td>
    
    <td>
<? 
$due_order =  $target_amt[$data->item_group] - $do_amt[$data->item_group]; 
$rdt=(int)($due_order/$wday); 
if($rdt>0) { echo $rdt; $grdt+=$rdt; }
?> 
</td>

    <td style="text-align:right"><? echo number_format($do_amt[$data->item_group],0); $gdamt += $do_amt[$data->item_group]; ?></td> 
    <td style="text-align:right"><? echo number_format($sale_amt[$data->item_group],0); $gsamt += $sale_amt[$data->item_group]; ?></td>  
    <td style="text-align:right"><?=$TvOa?></td>
    <td style="text-align:right"><?=$TvO?> %</td>
</tr>
<? 
$due_order='';  
}
$gTvO = number_format((($gdamt/$gtamt)*100),2);
$gOvD = number_format((($gsamt/$gdamt)*100),2);
$gTvOa = (int)($gtamt-$gdamt);

?>
<tr style="font-weight:bold">
  <td style="text-align:right" colspan="2">Total</td>
  <td style="text-align:right"><?=number_format($gtamt,2);?></td>
  <td><?=$gdt?></td>
  <td><?=$grdt?></td>
  <td style="text-align:right"><?=number_format($gdamt,2);?></td>
  <td style="text-align:right"><?=number_format($gsamt,2);?></td>
  <td style="text-align:right"><?=$gTvOa?></td>
  
  <td style="text-align:right"><?=$gTvO?> %</td>

</tr>
</tbody></table>
<?
} // end



elseif($_REQUEST['report']==202) {

?>
<?=$str?>
<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;zoom: 60%;">
<tr class="bg-night-light1">
<th scope="col" class="color-white">S/L</th>
<th scope="col" class="color-white">Code</th>
<th scope="col" class="color-white">Product Name</th>
<th scope="col" class="color-white">Unit</th>
<th scope="col" class="color-white">MRP</th>
<th scope="col" class="color-white">TP</th>
<th scope="col" class="color-white">DP</th>
<th scope="col" class="color-white">NSP</th>
</tr>
<tbody>
<?
$res="select * from item_info i where 1 and sub_group_id=100100000 
".$item_con."
order by item_group,category_id,subcategory_id";

$query = mysqli_query($conn, $res);
while($data=mysqli_fetch_object($query)){
$s++;
?>
<tr>
    <td><?=$s?></td>
    <td><?=$data->finish_goods_code?></td>
    <td><?=$data->item_name?></td>
    <td><?=$data->unit_name?></td>
    <td><?=$data->m_price?></td>
    <td><?=$data->t_price?></td> 
    <td><?=$data->d_price;?></td>
<td><? $nsp_amt = $data->t_price *((100-$data->nsp_per)/100); echo number_format($nsp_amt,2);
//echo $data->nsp_price;
?>
</td>
</tr>
<? } ?>
</tbody>
</table>
<? 
} // 





// dealer stock report
elseif($_REQUEST['report']==104) {

//$dealer_code = find1("select master_dealer_code from ss_shop where emp_code='".$emp_code."' and status=1");
$dealer_code	=$_SESSION['user']['warehouse_id'];

if(isset($t_date)) {
$date_con=' and c.chalan_date between \''.$f_date.'\' and \''.$t_date.'\'';

$year = date("Y",strtotime($t_date));
$mon = date("m",strtotime($t_date));
}


$sql="select * from item_category where 1";
$query=mysqli_query($conn,$sql);
while($info1=mysqli_fetch_object($query)){
    $cat_name[$info1->id]=$info1->category_name;
}


$sql2="select * from item_subcategory where 1";
$query2=mysqli_query($conn,$sql2);
while($info2=mysqli_fetch_object($query2)){
    $subcat_name[$info2->id]=$info2->subcategory_name;
}




$opening_date = find1("select max(ji_date) from ss_journal_item where tr_from='Opening' and warehouse_id='".$dealer_code."' ");
if($opening_date=='') {
    $opening_date='2021-08-01';
}

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
<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;zoom: 60%;">
<tr class="bg-night-light1">
<th scope="col" class="color-white">S/L</th>
<th scope="col" class="color-white">Category</th>
<th scope="col" class="color-white">SubCat</th>
<th scope="col" class="color-white">FG Code</th>
<th scope="col" class="color-white">Item Name</th>
<th scope="col" class="color-white">Stock Qty(Pcs)</th>
<th scope="col" class="color-white">Stock Amount</th>
</tr>
<tbody>
<? 
 $sql_list="select category_id,subcategory_id,item_id,finish_goods_code as code,item_name,pack_size,t_price from item_info where 1 order by category_id,subcategory_id";
$query = mysqli_query($conn,$sql_list);
while($data=mysqli_fetch_object($query)){


$qty = ($item_ss[$data->item_id]+$item_in[$data->item_id]);
if($qty<>0){
$s++;
?>
<tr>
  <td><?=$s?></td>
  <td><?=$cat_name[$data->category_id]?></td>
  <td><?=$subcat_name[$data->subcategory_id]?></td>
  <td><?=$data->code?></td>
  <td><?=$data->item_name?></td>
  <td><? $qty= (int)$qty;
  if($qty<0){ ?> <span style="color:red; font-weight: bold;"><?=$qty;?> <? }else{ echo $qty;} ?>
</td>	
<td><?=(int)$amt=($qty*$data->t_price); $gamt +=$amt;?></td>
</tr>
<? 
$qty=0;
}} ?>
<tr>
<td></td><td></td><td></td><td></td><td></td><td>Total</td>
<td><?=number_format($gamt,2);?></td>
</tr>
</tbody>
</table>
<? 
} // end report 104



elseif($_REQUEST['report']==102) {
$report="Target/Primary SO Report";

if($_POST['source']!=''){$source = $_POST['source'];}


if(isset($t_date)) {
$date_con=' and c.chalan_date between \''.$f_date.'\' and \''.$t_date.'\'';

$year = date("Y",strtotime($t_date));
$mon = date("m",strtotime($t_date));
}
//if($_POST['offer_name']) {$offer_con=" and a.offer_name='".$_POST['offer_name']."'";}


// item wise target
if($source=='SO'){
$tc = "select target_con from ss_target_ratio where emp_code='".$emp_code."' and target_year='".$year."' and target_month='".$mon."' ";
$target_con = find1($tc);
if($target_con<1){ $target_con=100;}

if($_SESSION['dsr_login']=='YES'){
$dealer_code = $emp_code;
}else{
$dealer_code = find1("select master_dealer_code from ss_shop where emp_code='".$emp_code."' and status=1");
}

$sql_target="select t.item_id,t.target_ctn,target_amount,i.pack_size 
from sale_target_upload t, item_info i where i.item_id=t.item_id 
and target_year='".$year."' and target_month='".$mon."' and dealer_code='".$dealer_code."'";
$query1 = mysqli_query($conn, $sql_target);
	while($info=mysqli_fetch_object($query1)){
	$target_qty[$info->item_id]=(($info->target_ctn)*$target_con)/100;
	$target_amt[$info->item_id]=($info->target_amount*$target_con)/100;
	}
}else{
if($_SESSION['dsr_login']=='YES'){
$dealer_code = $emp_code;
}else{
$dealer_code = find1("select master_dealer_code from ss_shop where emp_code='".$emp_code."' and status=1");
}
$sql_target="select t.item_id,t.target_ctn,target_amount,i.pack_size 
from sale_target_upload t, item_info i 
where i.item_id=t.item_id 
and target_year='".$year."' and target_month='".$mon."' and dealer_code='".$dealer_code."'";
$query1 = mysqli_query($conn, $sql_target);
	while($info=mysqli_fetch_object($query1)){
	$target_qty[$info->item_id]=$info->target_ctn;
	$target_amt[$info->item_id]=$info->target_amount;
	}
}


// find out dealer info
if($source=='SO'){

if($_SESSION['dsr_login']=='YES'){
$dealer_code = $emp_code;
}else{
$dealer_code = find1("select master_dealer_code from ss_shop where emp_code='".$emp_code."' and status=1");
}

echo '<br>dealer_code='.$dealer_code;

echo '<br>ss_dealer_delivery='.$dealer_delivery = find1("select sum(d.total_amt) from ss_do_chalan d, ss_shop s 
where s.dealer_code=d.dealer_code and d.chalan_date between '".$f_date."' and '".$t_date."' and master_dealer_code='".$dealer_code."' and s.status=1");

echo '<br>ss_emp_delivery='.$emp_delivery = find1("select sum(d.total_amt) from ss_do_chalan d, ss_shop s 
where s.dealer_code=d.dealer_code and d.chalan_date between '".$f_date."' and '".$t_date."' and emp_code='".$emp_code."'  and s.status=1");
echo '<br>con_per='.$con_per = number_format(($emp_delivery/$dealer_delivery)*100,2,'.','');
echo '<br>';
}


// item wise Primary DO
if($source=='SO'){
$sql_item='select i.item_id,i.finish_goods_code as code,i.item_name,sum(d.total_unit/i.pack_size) as qty,sum(d.total_amt) as amount
from item_info i, sale_do_details d, sale_do_master m
where d.item_id=i.item_id and m.do_no=d.do_no
and m.do_date between "'.$f_date.'" and "'.$t_date.'" 
and m.dealer_code="'.$dealer_code.'"
and m.status in("CHECKED","COMPLETED") and d.unit_price>0
group by i.item_id
order by i.finish_goods_code,i.item_name';
$query2 = mysqli_query($conn, $sql_item);
while($info2=mysqli_fetch_object($query2)){
	$do_qty[$info2->item_id]=(int)($info2->qty*$con_per)/100;
	$do_amt[$info2->item_id]=(int)($info2->amount*$con_per)/100;
	}
}else{ // party
$sql_item='select i.item_id,i.finish_goods_code as code,i.item_name,sum(d.total_unit/i.pack_size) as qty,sum(d.total_amt) as amount
from item_info i, sale_do_details d, sale_do_master m
where d.item_id=i.item_id and m.do_no=d.do_no
and m.do_date between "'.$f_date.'" and "'.$t_date.'" 
and m.dealer_code="'.$dealer_code.'"
and m.status in("CHECKED","COMPLETED") and d.unit_price>0
group by i.item_id
order by i.finish_goods_code,i.item_name';
$query2 = mysqli_query($conn, $sql_item);
while($info2=mysqli_fetch_object($query2)){
	$do_qty[$info2->item_id]=(int)$info2->qty;
	$do_amt[$info2->item_id]=(int)$info2->amount;
	}
}


$res="select i.* from item_info i where 1 order by finish_goods_code";
$query = mysqli_query($conn, $res);
?>
<?=$str?>
<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;zoom: 60%;">s
<thead>
<tr class="bg-night-light1">
<th scope="col" class="color-white">S/L</th>
<th scope="col" class="color-white">FG Code</th>
<th scope="col" class="color-white">Item Name</th>
<th scope="col" class="color-white">Target Qty</th>
<th scope="col" class="color-white">Target Amount</th>
<th scope="col" class="color-white">SO Qty</th>
<th scope="col" class="color-white">SO Amount</th>
<th scope="col" class="color-white">ShortFall Qty</th>
<th scope="col" class="color-white">Achivement</th>
</tr>
</thead>
<tbody>
<? 
while($data=mysqli_fetch_object($query)){
if($target_qty[$data->item_id]>0 || $do_qty[$data->item_id]>0){
$s++;
?>
<tr>
  <td><?=$s?></td>
  <td><?=$data->finish_goods_code?></td>
  <td><?=$data->item_name?></td>
  <td><?=(int)$target_qty[$data->item_id];?></td>
  <td><?=(int)$target_amt[$data->item_id]; $gtarget +=$target_amt[$data->item_id];?></td>
  <td><?=(int)$do_qty[$data->item_id];?></td>
  <td><?=(int)$do_amt[$data->item_id]; $gdo_amt +=$do_amt[$data->item_id];?></td>
  <td><? $sfall=(int)($target_qty[$data->item_id]-$do_qty[$data->item_id]); 
  if($sfall<0){ ?> <span style="color:red; font-weight: bold;"><?=$sfall;?> <? }else{ echo $sfall;}
  ?>
 
</td>
  <td><?
$ratio = (($do_amt[$data->item_id]*100)/$target_amt[$data->item_id]);
if($ratio<>0) {echo number_format($ratio,2); } 
  ?></td>
  </tr>
<? }} ?>
<tr>
<td></td><td></td><td><strong>Total</strong></td><td><? //=$gqty?></td>
<td><strong><?=(int)$gtarget?></strong></td>
<td></td>
<td><strong><?=(int)$gdo_amt?></strong></td>
<td><span style="color:red"><strong><?=(int)($gdo_amt-$gtarget);?></strong></span></td>

<? $gratio = (($gdo_amt*100)/$gtarget);?>
<td><strong><?=number_format($gratio,2);?>%</strong></td>
</tr>
</tbody>
</table>
<? 
} // end report 102







elseif($_REQUEST['report']==103) {
$report="Target/Primary Delivery Report";

if($_POST['source']!=''){$source = $_POST['source'];}


if(isset($t_date)) {
$date_con=' and c.chalan_date between \''.$f_date.'\' and \''.$t_date.'\'';

$year = date("Y",strtotime($t_date));
$mon = date("m",strtotime($t_date));
}
//if($_POST['offer_name']) {$offer_con=" and a.offer_name='".$_POST['offer_name']."'";}

// item wise target
if($source=='SO'){
$tc = "select target_con from ss_target_ratio where emp_code='".$emp_code."' and target_year='".$year."' and target_month='".$mon."' ";
$target_con = find1($tc);
if($target_con<1){ $target_con=100;}

if($_SESSION['dsr_login']=='YES'){
$dealer_code = $emp_code;
}else{
$dealer_code = find1("select master_dealer_code from ss_shop where emp_code='".$emp_code."' and status=1");
}


$sql_target="select t.item_id,t.target_ctn,target_amount,i.pack_size 
from sale_target_upload t, item_info i where i.item_id=t.item_id 
and target_year='".$year."' and target_month='".$mon."' and dealer_code='".$dealer_code."'";
$query1 = mysqli_query($conn, $sql_target);
	while($info=mysqli_fetch_object($query1)){
	$target_qty[$info->item_id]=(($info->target_ctn)*$target_con)/100;
	$target_amt[$info->item_id]=($info->target_amount*$target_con)/100;
	}
}else{

if($_SESSION['dsr_login']=='YES'){
$dealer_code = $emp_code;
}else{
$dealer_code = find1("select master_dealer_code from ss_shop where emp_code='".$emp_code."' and status=1");
}

$sql_target="select t.item_id,t.target_ctn,target_amount,i.pack_size 
from sale_target_upload t, item_info i where i.item_id=t.item_id 
and target_year='".$year."' and target_month='".$mon."' and dealer_code='".$dealer_code."'";
$query1 = mysqli_query($conn, $sql_target);
	while($info=mysqli_fetch_object($query1)){
	$target_qty[$info->item_id]=$info->target_ctn;
	$target_amt[$info->item_id]=$info->target_amount;
	}
}

// find out dealer info
if($source=='SO'){

if($_SESSION['dsr_login']=='YES'){
$dealer_code = $emp_code;
}else{
$dealer_code = find1("select master_dealer_code from ss_shop where emp_code='".$emp_code."' and status=1");
}

echo '<br>dealer_code='.$dealer_code;

echo '<br>ss_dealer_delivery='.$dealer_delivery = find1("select sum(d.total_amt) from ss_do_chalan d, ss_shop s 
where s.dealer_code=d.dealer_code and d.chalan_date between '".$f_date."' and '".$t_date."' and master_dealer_code='".$dealer_code."' and s.status=1");

echo '<br>ss_emp_delivery='.$emp_delivery = find1("select sum(d.total_amt) from ss_do_chalan d, ss_shop s 
where s.dealer_code=d.dealer_code and d.chalan_date between '".$f_date."' and '".$t_date."' and emp_code='".$emp_code."'  and s.status=1");
echo '<br>con_per='.$con_per = number_format(($emp_delivery/$dealer_delivery)*100,2,'.','');
echo '<br>';
}

// item wise Primary Chalan
if($source=='SO'){
$sql_item='select i.item_id,i.finish_goods_code as code,i.item_name,sum(c.total_unit/i.pack_size) as qty,sum(c.total_amt) as amount
from item_info i, sale_do_chalan c
where c.item_id=i.item_id
and c.chalan_date between "'.$f_date.'" and "'.$t_date.'" and c.unit_price>0
and c.dealer_code="'.$dealer_code.'"
group by i.item_id
order by i.finish_goods_code,i.item_name';
$query2 = mysqli_query($conn, $sql_item);
	while($info2=mysqli_fetch_object($query2)){
	$do_qty[$info2->item_id]=(int)($info2->qty*$con_per)/100;
	$do_amt[$info2->item_id]=(int)($info2->amount*$con_per)/100;
	}
}else{
$sql_item='select i.item_id,i.finish_goods_code as code,i.item_name,sum(c.total_unit/i.pack_size) as qty,sum(c.total_amt) as amount
from item_info i, sale_do_chalan c
where c.item_id=i.item_id
and c.chalan_date between "'.$f_date.'" and "'.$t_date.'" and c.unit_price>0
and c.dealer_code="'.$dealer_code.'"
group by i.item_id
order by i.finish_goods_code,i.item_name';
$query2 = mysqli_query($conn, $sql_item);
	while($info2=mysqli_fetch_object($query2)){
	$do_qty[$info2->item_id]=(int)($info2->qty);
	$do_amt[$info2->item_id]=(int)($info2->amount);
	}
}	


$res="select i.* from item_info i where 1 order by finish_goods_code";
$query = mysqli_query($conn, $res);
?>
<?=$str?>
<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;zoom: 60%;">
<tr class="bg-night-light1">
<th scope="col" class="color-white">S/L</th>
<th scope="col" class="color-white">FG Code</th>
<th scope="col" class="color-white">Item Name</th>
<th scope="col" class="color-white">Target Qty</th>
<th scope="col" class="color-white">Target Amount</th>
<th scope="col" class="color-white">Delivery Qty</th>
<th scope="col" class="color-white">Delivery Amount</th>
<th scope="col" class="color-white">ShortFall Qty</th>
<th scope="col" class="color-white">Achivement</th>
</tr>
<tbody>
<? 
while($data=mysqli_fetch_object($query)){
if($target_qty[$data->item_id]>0 || $do_qty[$data->item_id]>0){
$s++;
?>
<tr>
  <td><?=$s?></td>
  <td><?=$data->finish_goods_code?></td>
  <td><?=$data->item_name?></td>
  <td><?=(int)$target_qty[$data->item_id];?></td>
  <td><?=(int)$target_amt[$data->item_id]; $gtarget +=$target_amt[$data->item_id];?></td>
  <td><?=(int)$do_qty[$data->item_id];?></td>
  <td><?=(int)$do_amt[$data->item_id]; $gdo_amt +=$do_amt[$data->item_id];?></td>
  <td><? $sfall=(int)($target_qty[$data->item_id]-$do_qty[$data->item_id]); 
  if($sfall<0){ ?> <span style="color:red; font-weight: bold;"><?=$sfall;?> <? }else{ echo $sfall;}
  ?></td>
  <td><?
$ratio = (($do_amt[$data->item_id]*100)/$target_amt[$data->item_id]);
if($ratio<>0) {echo number_format($ratio,2); } 
  ?></td>
  </tr>
<? }} ?>
<tr>
<td></td><td></td><td>Total</td><td><? //=$gqty?></td><td><?=(int)$gtarget?></td>
<td></td><td><?=(int)$gdo_amt?></td>
<td><span style="color:red"><?=(int)($gdo_amt-$gtarget);?></span></td>
<?
$gratio = (($gdo_amt*100)/$gtarget);
?>
<td><?=number_format($gratio,2);?>%</td>
</tr>
</tbody>
</table>
<? 
} // end report 103




elseif($_REQUEST['report']==201){
    
?>
<?=$str?>
<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;zoom: 60%;">
<tr class="bg-night-light1">
<th scope="col" class="color-white">S/L</th>
<th scope="col" class="color-white">Date</th>
<th scope="col" class="color-white">FG Code</th>
<th scope="col" class="color-white">Item Name</th>
<th scope="col" class="color-white">Qty(Pcs)</th>
<th scope="col" class="color-white">TP Amount</th>
</tr>
<tbody>
<? 
$sql_list="select i.finish_goods_code as code,i.item_id,i.item_name,i.t_price,j.*
from item_info i, ss_journal_item j 
where i.item_id=j.item_id and j.ji_date between '".$f_date."' and  '".$t_date."' and warehouse_id='".$_SESSION['warehouse_id']."' and tr_from='Opening'
";
$query = mysqli_query($conn,$sql_list);
while($data=mysqli_fetch_object($query)){
$s++;
?>
<tr>
  <td><?=$s?></td>
  <td><?=$data->ji_date?></td>
  <td><?=$data->code?></td>
  <td><?=$data->item_name?></td>
  <td><?=$data->item_in?></td>
  <td><?=(int)$amt=($data->item_in*$data->t_price); $gamt +=$amt;?></td>
  </tr>
<?  } ?>
<tr>
<td></td><td></td><td></td><td></td><td>Total</td>
<td><?=number_format($gamt,2);?></td>
</tr>
</tbody>
</table>
<? 
} // end



elseif($_POST['report']==201) {
$report ='Item Stock Report';

if($_REQUEST['item_id']>0){ 
$item_id = $_REQUEST['item_id'];
$item_con = ' and i.id="'.$item_id.'"';
}
if($_POST['warehouse_id']) {$w_con=" and j.warehouse_id='".$warehouse_id."'";}


?>
<center><h3 class="card-title"><?=$report?></h3></center><div align="right">Reporting Time:<?=date("h:i A d-m-Y")?></div>

<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;zoom: 60%;">
<thead>
    <tr class="bg-night-light1">
      <th scope="col" class="color-white">S/L</th>
      <th scope="col" class="color-white">Item Company</th>
      <th scope="col" class="color-white">Code</th>
      <th scope="col" class="color-white">Name</th>
      <th scope="col" class="color-white">Stock Qty</th>
      <th scope="col" class="color-white">Price</th>
      <th scope="col" class="color-white">Stock Amount</th>
    </tr>
  </thead>
  <tbody>
<?php
$sql2='select i.item_company,i.id as code, i.name,sum(j.item_in-j.item_ex) as stock,i.cost as price
FROM product i, journal_item j
where i.id=j.item_id and i.type not in ("Discount")
'.$item_con.$w_con.'
group by i.id
order by i.name';
$query= mysqli_query($conn, $sql2);
while($data=mysqli_fetch_object($query)){
$j++;
?>
    <tr>
      <td><?=$j?></td>
      <td><?=$data->item_company?></td>
      <td><?=$data->code?></td>
      <td><?=$data->name?></td>
      <td><?php echo $stock = (int)$data->stock; $gstock+=$data->stock;?></td>
      <td><?=$data->price;?></td>
      <td><? echo $amount = ($data->price*$data->stock); $gamount +=$amount;?></td>
    </tr>
<?php
} // end while
		
?>
    <tr>
      <td></td><td></td><td></td>
      <td><strong>Total</strong></td>
      <td><strong><?=$gstock;?></strong></td><td></td>
      <td><strong><?=$gamount;?></strong></td>
    </tr>
  </tbody>
</table>

<?php
}


elseif($_REQUEST['report']==204) {
$report ='Item Transection Report';

if($_REQUEST['item_id']!=''){ 
    
$item_id = $_REQUEST['item_id'];

if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date;  
$date_con=' and j.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';
}
if($_POST['warehouse_id']) { $w_con=" and j.warehouse_id='".$warehouse_id."'";}

?>
<center>
<h2><?=$company_name;?></h2>
<h3>Item Transection Report</h3>
<h5>Date Interval: <?=$_REQUEST['f_date'];?> to <?=$_REQUEST['t_date'];?></h5>
<h6>Item Name: <?php echo $item_id?>-<?php echo find1("select name from product where id='".$item_id."'");?></h6>
<div align="right">Reporting Time:<?=date("h:i A d-m-Y")?></div>
<div class="table-responsive">
<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;zoom: 60%;">
<thead>
    <tr class="bg-night-light1">
      <th scope="col" class="color-white">S/L</th>
      <th scope="col" class="color-white">Date</th>
      <th scope="col" class="color-white">Code </th>
      <th scope="col" class="color-white">Name</th><th scope="col" class="color-white">Tr NO</th><th scope="col" class="color-white">Type</th>
      <th scope="col" class="color-white">IN</th>
      <th scope="col" class="color-white">OUT</th>
      <th scope="col" class="color-white">Rate</th><th scope="col" class="color-white">Amount</th>
      <th scope="col" class="color-white">Entry At</th>
    </tr>
  </thead>
  <tbody>

<?php
$sql='SELECT j.ji_date,i.id,i.name,j.tr_from as type,j.item_in as item_in,j.item_ex as item_out,j.entry_at,j.sr_no,j.item_price
FROM journal_item j, product i
where j.item_id=i.id and i.id="'.$item_id.'"
'.$date_con.$w_con.'
order by j.ji_date';
$query= mysqli_query($conn, $sql);
while($data=mysqli_fetch_object($query)){
$j++;
?>
    <tr>
      <td><?=$j?></td>
      <td><?=$data->ji_date?></td>
      <td><?=$data->id?></td><td><?=$data->name?></td>
      <td><?=$data->sr_no?></td>
      <td><?=$data->type?></td>
      <td><?=(int)$data->item_in?></td>
      <td><?=(int)$data->item_out?></td>
      <td><?=$data->item_price?></td>
      <td><?=($data->item_price*($data->item_in+$data->item_out));?></td>
      <td><?=$data->entry_at?></td>
      
    </tr>
<?php
$g_in += $data->item_in;
$g_out += $data->item_out;
} // end while
?>
    <tr>
      <td></td><td></td>
      <td></td><td></td>
      <td></td><td><b>Total</b></td>
      <td><b><?=(int)$g_in?></b></td><td><b><?=(int)$g_out?></b></td>
      <td></td>
    </tr>
  </tbody>
</table></div>

<?php
}else{ die('Please select item for this report. Thanks');}
}




elseif($_POST['report']==205) {
//$str='Item wise Profit Report';

if(isset($t_date)) { $date_con=' and w.oi_date between "'.$f_date.'" and "'.$t_date.'"';}
if(isset($item_id)) { $item_id_con=' and i.id="'.$item_id.'"'; }
if($_POST['warehouse_id']) {$w_con=" and w.warehouse_id='".$warehouse_id."'";}

?>
<center>
<?=$str?>  
<!--<h3 class="card-title"><?=$str?></h3>-->
<!--<div align="right">Reporting Time:<?=date("h:i A d-m-Y")?></div>-->
<div class="table-responsive">
<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;zoom: 60%;">
<thead>
    <tr class="bg-night-light1">
      <th scope="col" class="color-white">S/L</th><th scope="col" class="color-white">Date</th><th scope="col" class="color-white">Sales NO</th>
      <th scope="col" class="color-white">Item Company </th>
      <th scope="col" class="color-white">Code </th>
      <th scope="col" class="color-white">Name</th>
      <th scope="col" class="color-white">Sales Qty</th><th scope="col" class="color-white">Cost rate</th><th scope="col" class="color-white">Cost amount</th><th scope="col" class="color-white">Sales price</th><th scope="col" class="color-white">Sales amount</th><th scope="col" class="color-white">Profit</th>
    </tr>
  </thead>
  <tbody>
<?php
$sql='SELECT w.oi_date,w.oi_no,i.item_company, i.id as code, i.name, w.qty as sales_qty, w.cost_rate, 
(w.qty*w.cost_rate) as cost_amount, w.rate as sales_price,(w.qty*w.rate) as sales_amount,
((w.qty*w.rate) - (w.qty*w.cost_rate)) as profit

FROM product i, warehouse_other_issue_detail w
where i.id=w.item_id and w.issue_type="Sales"
'.$item_id_con.$date_con.$w_con.'
order by w.oi_date';

$query= mysqli_query($conn, $sql);
while($data=mysqli_fetch_object($query)){
$j++;
?>
    <tr>
      <td><?=$j?></td>
      <td><?=$data->oi_date?></td>
      <td><?=$data->oi_no?></td>
      <td><?=$data->item_company?></td>
      <td><?=$data->code?></td>
      <td><?=$data->name?></td>
      <td><?php echo $data->sales_qty?></td>
      <td><?php echo $data->cost_rate?></td>
      <td><?php echo round($data->cost_amount,2); $gcost +=$data->cost_amount;?></td>
      <td><?php echo $data->sales_price?></td>
      <td><?php echo round($data->sales_amount,2); $gsales += $data->sales_amount;?></td>
      <td><?php echo round($data->profit,2); $gprofit += $data->profit;?></td>
      
    </tr>
<?php
} // end while
		
?>
    <tr>
      <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
      <td><strong>Total</strong></td>
      <td><strong><?=round($gcost,2)?></strong></td>
      <td></td>
      <td><strong><?=round($gsales,2)?></strong></td>
      <td><strong><?=round($gprofit,2)?></strong></td>
    </tr>
  </tbody>
</table></div>

<?php
}




elseif($_POST['report']==206) {

if(isset($t_date)) { $date_con=' and w.oi_date between "'.$f_date.'" and "'.$t_date.'"';}
if(isset($item_id)) { $item_id_con=' and i.id="'.$item_id.'"'; }
if($_POST['warehouse_id']) {$w_con=" and w.warehouse_id='".$warehouse_id."'";}

?>
<center>
<?=$str?>  
<!--<h3 class="card-title"><?=$str?></h3>-->
<!--<div align="right">Reporting Time:<?=date("h:i A d-m-Y")?></div>-->
<div class="table-responsive">
<table class="table table-striped table-bordered" id="table_report2">
<thead>
    <tr>
      <th scope="col" class="color-white">S/L</th>
      <th scope="col" class="color-white">Item Company</th><th scope="col" class="color-white">Cost amount</th><th scope="col" class="color-white">Sales amount</th><th scope="col" class="color-white">Profit</th>
    </tr>
  </thead>
  <tbody>
<?php
$sql='SELECT w.vendor_id,i.item_company, sum(w.qty*w.cost_rate) as cost_amount, sum(w.qty*w.rate) as sales_amount
FROM product i, warehouse_other_issue_detail w
where i.id=w.item_id and w.issue_type="Sales"
'.$item_id_con.$date_con.$w_con.'
group by i.item_company order by i.item_company';

$query= mysqli_query($conn, $sql);
while($data=mysqli_fetch_object($query)){
$j++;
?>
    <tr>
      <td><?=$j?></td>
      <td><?=$data->item_company?></td>
      <td><?php echo round($data->cost_amount,2); $gcost += $data->cost_amount;?></td>
      <td><?php echo round($data->sales_amount,2); $gsales += $data->sales_amount;?></td>
      <td><?php echo $profit=round(($data->sales_amount-$data->cost_amount),2); $gprofit += $profit;?></td>
      
    </tr>
<?php
} // end while
?>
    <tr>
      <td></td><td><strong>Total</strong></td>
      <td><strong><?=round($gcost,2);?></strong></td>
      <td><strong><?=round($gsales,2);?></strong></td>
      <td><strong><?=round($gprofit,2);?></strong></td>
    </tr>
  </tbody>
</table></div>

<?php
}






elseif($_POST['report']==203){

$f_date = $_REQUEST['f_date'];
$t_date = $_REQUEST['t_date'];

 
if($_POST['item_sub_group']>0) 	$sub_group_id   =$_POST['item_sub_group'];
if($_POST['item_id']>0)         $item_id        =$_POST['item_id'];

$date_con = ' and j.ji_date between "'.$f_date.'" and "'.$t_date.'" ';
if(isset($sub_group_id)) 	{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
if(isset($item_id)) 		{$item_con=' and i.id='.$item_id;} 

if($_POST['warehouse_id']) { $w_con=" and j.warehouse_id='".$warehouse_id."'";}


// opening
$sql="select j.item_id as code,sum(j.item_in - j.item_ex) balance
from journal_item j, product i 
where j.item_id=i.id
and ji_date < '".$f_date."' and warehouse_id = '1' 
".$item_con.$item_sub_con.$w_con." group by i.id";
	
$res = mysqli_query($conn, $sql);
	while($row=mysqli_fetch_object($res))
	{
		$opening[$row->code] = (int)$row->balance;
	}
	
// Closing
$sql="select j.item_id as code,sum(j.item_in - j.item_ex) balance
from journal_item j, product i 
where j.item_id=i.id
and ji_date <= '".$t_date."' and warehouse_id = '1' ".$item_con.$item_sub_con.$w_con." group by i.id";
	
$res = mysqli_query($conn, $sql);
	while($row=mysqli_fetch_object($res))
	{
		$bin_closing[$row->code] = (int)$row->balance;
	}	



// ----------- ALL purchase	
$sql="select j.item_id as code,i.unit_name,sum(j.item_in) balance
from journal_item j, product i 
where j.item_id=i.id 
and j.ji_date between '".$f_date."' and '".$t_date."' and warehouse_id = '1' ".$item_con.$item_sub_con.$w_con." 
AND  j.tr_from IN ('Local Purchase') group by i.id";
$res = mysqli_query($conn, $sql);
	while($row=mysqli_fetch_object($res))
	{
		$purchase[$row->code] = (int)$row->balance;
	}



// ------------------ Other receive	
$sql="select j.item_id as code,i.unit_name,sum(j.item_in) balance
from journal_item j, product i 
where j.item_id=i.id 
and j.ji_date between '".$f_date."' and '".$t_date."' and warehouse_id = '1' ".$item_con.$item_sub_con.$w_con." 
AND  j.tr_from NOT IN ('Local Purchase') group by i.id";
	
$res = mysqli_query($conn, $sql);
	while($row=mysqli_fetch_object($res))
	{
		$other_receive[$row->code] = (int)$row->balance;
	}	

// ----------------- Delivery -------------	
$sql="select j.item_id as code,i.unit_name,sum(j.item_ex) balance
from journal_item j, product i 
where j.item_id=i.id 
and j.ji_date between '".$f_date."' and '".$t_date."' and warehouse_id = '1' ".$item_con.$item_sub_con.$w_con." 
AND  j.tr_from IN ('Other Issue') group by i.id";
	
$res = mysqli_query($conn, $sql);
	while($row=mysqli_fetch_object($res))
	{
		$delivery[$row->code] = (int)$row->balance;
	}



// ----------------- Others issue	
$sql="select j.item_id as code,i.unit_name,sum(j.item_ex) balance
from journal_item j, product i 
where j.item_id=i.id 
and j.ji_date between '".$f_date."' and '".$t_date."' and warehouse_id = '1' ".$item_con.$item_sub_con.$w_con." 
AND  j.tr_from NOT IN ('Other Issue') group by i.id";
	
$res = mysqli_query($conn, $sql);
	while($row=mysqli_fetch_object($res))
	{
		$other_issue[$row->code] = (int)$row->balance;
	}		
		

?>
<center>
<h1><?=$company_name;?></h1>
<h2>Stock Movement Report</h2>
<h3>Date Interval: <?=$_REQUEST['f_date'];?> to <?=$_REQUEST['t_date'];?></h3>
<table class="table table-striped table-bordered">
<thead>
<tr>
  <th scope="col" class="color-white">S/L</th>
  <th scope="col" class="color-white">Code</th>
  <th scope="col" class="color-white">Item Name</th>
  <th bgcolor="#009999">Opening</th>
  <th bgcolor="#009999">Purchase</th>

  <th bgcolor="#009999">Other Receive</th>
  <th bgcolor="#009999">Total</th>

  <th bgcolor="#FF6699">Delivery</th>
  <th bgcolor="#FF6699">Other Issue</th>
  <th bgcolor="#FF6699">Total</th>
  <th scope="col" class="color-white">Closing</th>
  </tr>
</thead>
<tbody>

<?php
$sql="SELECT i.id as code,i.name,i.type
FROM  product i
where 1 and status=1 and i.price>0
".$item_con.$item_sub_con."
order by i.name";

$query = mysqli_query($conn, $sql);
while($data= mysqli_fetch_object($query)){ 
    
$in_total   = $opening[$data->code] + $purchase[$data->code] + $other_receive[$data->code];
$out_total  = $delivery[$data->code] + $other_issue[$data->code];
if($in_total<>0||$out_total<>0||$opening[$data->code]<>0){
?>

<tr>
  <td><?=++$op;?></td>
  <td><a href="master_report.php?report=204&submit=1&item_id=<?php echo $data->code;?>&f_date=<?php echo $f_date;?>&t_date=<?php echo $t_date;?>" target="_blank"><?=$data->code?></a></td>
  <td><?=$data->name?></td>
  <td><?=$opening[$data->code]?></td>
  <td><?=$purchase[$data->code]?></td>

  <td><?=$other_receive[$data->code]?></td>
  <td><?=$in_total?></td>

  <td><?=$delivery[$data->code]?></td>
  <td><?=$other_issue[$data->code]?></td>
  
  <td><?=$out_total?></td>
  
  <?php $closing = $in_total - $out_total; ?>  
  <td><?=$closing?></td>
  </tr>
<? 
$total_opening += $opening[$data->code];
$total_purchase += $purchase[$data->code];
$total_other_receive += $other_receive[$data->code];
$total_in_total += $in_total;

$total_delivery += $delivery[$data->code];
$total_other_issue += $other_issue[$data->code];
$total_out_total += $out_total[$data->code];
$total_closing += $closing;

}
} 
?>
<tr>
  <td bgcolor="#99CC99">&nbsp;</td>
  <td bgcolor="#99CC99">&nbsp;</td>
  <td bgcolor="#99CC99"><strong>Total</strong></td>
  <td bgcolor="#99CC99"><strong><?=$total_opening;?></strong></td>
  <td bgcolor="#99CC99"><strong><?=$total_purchase;?></strong></td>
  <td bgcolor="#99CC99"><strong><?=$total_other_receive;?></strong></td>
  <td bgcolor="#99CC99"><strong><?=$total_in_total;?></strong></td>
  

  <td bgcolor="#99CC99"><strong><?=$total_delivery;?></strong></td>
  <td bgcolor="#99CC99"><strong><?=$total_other_issue;?></strong></td>
  <td bgcolor="#99CC99"><strong><?=$total_out_total;?></strong></td>
  <td bgcolor="#99CC99"><strong><?=$total_closing;?></strong></td>
  </tr>
</tbody></table>

<?php
}
// end stock movement report







elseif(isset($sql)&&$sql!='') echo autoreport2($sql,$str);
?>



</div>
</div>
</div>
<!--    </div>	-->
<!--</div>-->



<?php /*?><script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>	

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
</script><?php */?>
    
 <?php /*?> 
    
    
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/vendor/bootstrap-5/js/bootstrap.bundle.min.js"></script>

    <!-- Customized jquery file  -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/color-scheme.js"></script>

    <!-- Chart js script -->
    <script src="assets/vendor/chart-js-3.3.1/chart.min.js"></script>

    <!-- Progress circle js script -->
    <script src="assets/vendor/progressbar-js/progressbar.min.js"></script>

    <!-- swiper js script -->
    <script src="assets/vendor/swiperjs-6.6.2/swiper-bundle.min.js"></script>

    <!-- daterange picker script -->
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="assets/vendor/daterangepicker/daterangepicker.js"></script>

    <!-- nouislider js -->
    <script src="assets/vendor/nouislider/nouislider.min.js"></script>

    <!-- PWA app service registration and works -->
    <!--<script src="assets/js/pwa-services.js"></script>-->

    <!-- page level custom script -->
    <script src="assets/js/app.js"></script>

</body>

</html><?php */?>

<?php 
 require_once '../assets/template/inc.footer.php';
 ?>

