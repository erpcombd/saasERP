<?

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';

date_default_timezone_set('Asia/Dhaka');

if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)
{
	if($_POST['room_id']>0)
	{
		$room_id=$_POST['room_id'];

	}
	if((strlen($_POST['t_date'])==10)&&(strlen($_POST['f_date'])==10))
	{
	$t_date=$_POST['t_date'];
	$f_date=$_POST['f_date'];
	}
	if($_POST['service_id']>0)
	$service_id=$_POST['service_id'];

switch ($_POST['report']) {
    case 1:
		$report="Daily Sales Summary";
		if(isset($room_id)) {$room_con=' and a.room_id='.$room_id;} 
		if(isset($service_id)) {$service_con=' and a.service_group_id='.$service_id;} 
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.bill_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		
		$sql='select a.id as bill_no,(select id from hms_reservation where id=a.reserve_id) as reserve_id,(select client_name from hms_reservation where id=a.reserve_id) as guest_name,s.service_group, a.bill_date,a.bill_amt,a.paid_date,a.paid_amt from hms_bill_payment a,`hms_service_group` s where s.id=a.service_group_id '.$date_con.$service_con.' group by service_group_id' ;
	break;
    case 2:
		$report="Daily Cash Report";
		if(isset($room_id)) {$room_con=' and a.room_id='.$room_id;} 
		if(isset($service_id)) {$service_con=' and a.service_group_id='.$service_id;} 
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.bill_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		
		$sql='select a.reserve_id,b.room_no,c.client_name,s.service_group, c.check_in_date as check_in,c.check_out_date as check_out,  a.paid_date,a.bill_amt , if(a.service_group_id = 5,a.paid_amt,"0.00") as discount_amt, if(a.service_group_id != 5,a.paid_amt,"0.00") as paid_amt from hms_bill_payment a,`hms_service_group` s,hms_hotel_room b,hms_reservation c where c.id=a.reserve_id and a.room_id=b.id and s.id=a.service_group_id '.$date_con.$service_con.$room_con ;
		break;
		
    case 3:
	$report="Pending Billing Report ";
		if(isset($room_id)) {$room_con=' and a.room_id='.$room_id;} 
		if(isset($service_id)) {$service_con=' and a.service_group_id='.$service_id;} 
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.bill_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		
		$sql='select a.id,s.service_group,b.room_name, a.bill_date,a.bill_amt,a.paid_date,a.paid_amt from hms_bill_payment a,`hms_service_group` s,hms_hotel_room b where a.bill_amt>a.paid_amt and  a.room_id=b.id and s.id=a.service_group_id '.$date_con.$service_con.$room_con ;
		break;
	    case 4:
$report="Present Hotel Room Status";

	$sql="select f.floor_name,r.room_no,t.room_type,IF(r.status=9,'Occupied','Vaccent') as occupied,IF(r.status=2,'Dirty','Clean') as readiness,IF(r.status=0,'Out of Order','OK') as room_status from hms_hotel_room r, hms_hotel_floor f, hms_room_type t where r.floor_id=f.id and r.room_type_id=t.id order by f.floor_no,t.id";
		break;
	    case 5:
$report="Present Occupancy Report";

	$sql="select f.floor_name,r.room_no,t.room_type,IF(r.status=9,'Occupied','Vaccent') as occupied from hms_hotel_room r, hms_hotel_floor f, hms_room_type t where r.floor_id=f.id and r.room_type_id=t.id order by f.floor_no,t.id";
		break;
	    case 6:
$report="Present Hotel Room Dirty Status";

	$sql="select f.floor_name,r.room_no,t.room_type,IF(r.status=2,'Dirty','Clean') as readiness from hms_hotel_room r, hms_hotel_floor f, hms_room_type t where r.floor_id=f.id and r.room_type_id=t.id and r.status=2 order by f.floor_no,t.id";
		break;
	    case 7:
$report="Present Hotel Room Out of Order";

	$sql="select f.floor_name,r.room_no,t.room_type,IF(r.status=0,'Out of Order','OK') as room_status from hms_hotel_room r, hms_hotel_floor f, hms_room_type t where r.floor_id=f.id and r.room_type_id=t.id and r.status=0 order by f.floor_no,t.id";
		break;
	    case 8:
$report="Present Floor wise Room Status";

	$sql="select f.floor_name, (select count(1) from hms_hotel_room r where r.floor_id=f.id and r.status=9) as occupied,(select count(1) from hms_hotel_room r where r.floor_id=f.id and r.status=2) as Dirty,(select count(1) from hms_hotel_room r where r.floor_id=f.id and r.status=0) as out_of_order
	,(select count(1) from hms_hotel_room r where r.floor_id=f.id and r.status=1) as reserved
	,(select count(1) from hms_hotel_room r where r.floor_id=f.id) as Total_room
	 from hms_hotel_floor f order by floor_no";
		break;
		case 9:
$report="Daily Guest Report";

	$date_con = ' ';
	$sql="select GROUP_CONCAT(distinct r.room_no SEPARATOR ', ') Room_No,h.reference_card Card_No,h.check_in_date ,concat(substring(h.check_in_time,1,2),':',substring(h.check_in_time,3,2)) check_in_time ,h.client_name as guest_name, h.reference_agent company,h.nationality,h.no_of_adult as Person,  h.check_out_date  from 
	hms_hotel_room_status s,
	hms_hotel_room r,
	hms_reservation h where s.room_id=r.id and s.room_status=9 and s.date='".date('Y-m-d')."' and h.id=s.reserve_id ".$date_con." group by s.reserve_id";
		

		
		
		break;
		case 10:
		$service_bill_no=$_POST['service_bill_no'];
		header('Location:../transaction/bill_invoice.php?bill_no='.$service_bill_no);
		break;
		case 11:
		$rent_bill_no=$_POST['rent_bill_no'];
		header('Location:../transaction/bill_invoice_room.php?bill_no='.$rent_bill_no);
		break;
		case 12:
		$reserve_id=$_POST['reserve_id'];
		header('Location:../transaction/bill_invoice_bill.php?reserve_no='.$reserve_id);
		break;
		case 21:
		$report="Reservation Status Report (Date Wise)";
		$to_date=$_POST['t_date'];
		$fr_date=$_POST['f_date'];
		$sql="SELECT  h.id AS reserve_id,r.room_no, h.client_name, h.check_in_date, h.check_out_date, t.room_type,s.date
FROM hms_hotel_room r, hms_room_type t, hms_hotel_room_status s, hms_reservation h
WHERE r.room_type_id = t.id
AND s.room_id = r.id
AND s.room_status =1
AND h.id = s.reserve_id
AND s.date between '".$fr_date."' and '". $to_date."' 
ORDER BY r.room_no";
		break;
		case 22:
		$report="Expected Arrival Status Report (Date Wise)";
		$to_date=$_POST['t_date'];
		$fr_date=$_POST['f_date'];
		$sql="SELECT h.id AS reserve_id, h.client_name, h.check_in_date, h.check_out_date, t.room_type, r.room_no,s.date
FROM hms_hotel_room r, hms_room_type t, hms_hotel_room_status s, hms_reservation h
WHERE r.room_type_id = t.id
AND s.room_id = r.id
AND s.room_status =1
AND h.id = s.reserve_id
AND s.date between '".$fr_date."' and '". $to_date."' 
ORDER BY r.room_no";
		break;
		case 23:
		$report="Check In Status Report (Date Wise)";
		$to_date=$_POST['t_date'];
		$fr_date=$_POST['f_date'];
		$sql="SELECT h.id AS reserve_id, h.client_name, h.check_in_date, h.check_out_date, t.room_type, r.room_no,s.date
FROM hms_hotel_room r, hms_room_type t, hms_hotel_room_status s, hms_reservation h
WHERE r.room_type_id = t.id
AND s.room_id = r.id
AND s.room_status =9
AND h.id = s.reserve_id
AND h.check_in_date='".$fr_date."' group by s.reserve_id  
ORDER BY r.room_no";
		break;
		case 24:
		$report="Check Out Status Report (Date Wise)";
		$to_date=$_POST['t_date'];
		$fr_date=$_POST['f_date'];
		$sql="SELECT h.id AS reserve_id, h.client_name, h.check_in_date, h.check_out_date, t.room_type, r.room_no,s.date
FROM hms_hotel_room r, hms_room_type t, hms_hotel_room_status s, hms_reservation h
WHERE r.room_type_id = t.id
AND s.room_id = r.id
AND s.room_status =9
AND h.id = s.reserve_id
AND h.check_out_date='".$fr_date."' group by s.reserve_id   
ORDER BY r.room_no";
		break;
		case 25:
		$report="Daily Payment Receive Report";
if(isset($service_id)) {$service_con=' and a.service_group_id='.$service_id;}
if(isset($t_date)){$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.paid_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		
$sql='select a.id,s.service_group,b.room_name, a.bill_date,a.bill_amt,a.paid_date,a.paid_amt from hms_bill_payment a, `hms_service_group` s, hms_hotel_room b where a.room_id=b.id and s.id=a.service_group_id '.$date_con.$service_con ;
		break;
		case 26:
		$report="In House Guest Ledger";
		$date=date('Y-m-d');
$sql='SELECT s.reserve_id,h.client_name,(select sum(bill_amt) from hms_bill_payment where reserve_id=h.id and service_group_id=2) as room_rent,(select sum(bill_amt) from hms_bill_payment where reserve_id=h.id) as total_amount,(select sum(paid_amt) from hms_bill_payment where reserve_id=h.id) as credit,(select (sum(bill_amt)-sum(paid_amt)) from hms_bill_payment where reserve_id=h.id) as balance FROM `hms_hotel_room` r,`hms_hotel_room_status` s, hms_reservation h WHERE r.status=9 and r.id=s.room_id and s.reserve_id=h.id and s.date="'.$date.'" group by reserve_id' ;
		break;
		case 27:
		$report="Payment Receivable Report";
	if((strlen($_POST['t_date'])==10)&&(strlen($_POST['f_date'])==10))
	{
	$to_date=$_POST['t_date'];
	$fr_date=$_POST['f_date'];
		$date_con='  and  b.paid_date between \''.$fr_date.'\' and \''.$to_date.'\'';
	}
		$sql='SELECT b.reserve_id,a.check_in_date,a.check_out_date,a.client_address,a.contact_no, b.paid_amt FROM `hms_bill_payment` b, hms_reservation a WHERE b.reserve_id=a.id and b.optional_service_id=21 and b.paid_amt>0 '.$date_con.'  order by reserve_id desc' ;
		break;
		
		case 28:
		$report="Payment Receivable Report (Received)";
	if((strlen($_POST['t_date'])==10)&&(strlen($_POST['f_date'])==10))
	{
	$to_date=$_POST['t_date'];
	$fr_date=$_POST['f_date'];
		$date_con='  and  b.paid_date between \''.$fr_date.'\' and \''.$to_date.'\'';
	}
		$sql='SELECT b.reserve_id,a.check_in_date,a.check_out_date,a.client_address,a.contact_no, b.paid_amt FROM `hms_bill_payment` b, hms_reservation a WHERE b.reserve_id=a.id and b.optional_service_id=22 and b.paid_amt>0 '.$date_con.'  order by reserve_id desc' ;
		break;
		case 30:
		$report="Master Sales Report";

		
		break;
				case 31:
		$report="Daily Sales Report";

		
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
</head>
<body>
<div align="center" id="pr">
<input type="button" value="Print" onclick="hide();window.print();"/>
</div>
<div class="main">
<?
		$str 	.= '<div class="header">';
		if(isset($_SESSION['company_name'])) 
		$str 	.= '<h1>'.$_SESSION['company_name'].'</h1>';
		if(isset($report)) 
		$str 	.= '<h2>'.$report.'</h2>';
		if(isset($t_date)) 
		$str 	.= '<h2>'.$f_date.' To '.$t_date.'</h2>';
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

if($_POST['report']==30)
{
?>
<table cellspacing="0" cellpadding="2" border="0" width="100%"><thead><tr><td colspan="24" style="border:0px;"><?=$str?></td></tr>

    <tr>
      <th colspan="10">Information</th>
      <th colspan="9">Daily Sale</th>
      <th colspan="5">Collection</th>
      </tr>
  <tr><th>S/L</th>
    <th>Card No</th>
    <th>Bill No</th>
    <th>Guest Name</th>
    <th>Company</th>
    <th>Check In Date</th>
    <th>Check Out Date</th>
    <th>Person</th>
    <th>Room No</th>
    <th>Room Allocated</th>
    <th>Room Charge</th>
    <th>Resturent</th>
    <th>Mini Bar</th>
    <th>Rent a Car </th><th>Laundry</th>
    <th>Conferance Hall</th>
    <th>Extra Bed</th>
    <th>Vat &amp; SC</th>
    <th>Total</th>
    <th>Discount</th>
    <th>Cash</th>
    <th>Card/Online</th>
    <th>Due/Credit</th>
    <th>Total</th>
    </tr></thead><tbody>
    <?
			if(isset($room_id)) {$room_con=' and a.room_id='.$room_id;} 
		if(isset($service_id)) {$service_con=' and a.service_group_id='.$service_id;} 
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and s.date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		
		
		$date_con = ' ';

		$sql22="select s.reserve_id,GROUP_CONCAT(distinct r.room_no SEPARATOR ', ') Room_No,count(distinct r.room_no) allocated_room,h.reference_card Card_No,h.check_in_date ,concat(substring(h.check_in_time,1,2),':',substring(h.check_in_time,3,2)) check_in_time ,h.client_name as guest_name, h.reference_agent company,h.nationality,h.no_of_adult as Person,  h.check_out_date  from 
	hms_hotel_room_status s,
	hms_hotel_room r,
	hms_reservation h where s.room_id=r.id and h.id=s.reserve_id ".$date_con." group by s.reserve_id";
	$query = db_query($sql22);
	while($data = mysqli_fetch_object($query)){

    $res = "select sum(total_amt) total_sum,service_group_id from hms_bill_payment where reserve_id='".$data->reserve_id."' group by service_group_id";
	$resquery = db_query($res);
	while($info = mysqli_fetch_object($resquery)){
	$val[$info->service_group_id][$data->reserve_id] = $info->total_sum;
	}
	?>
    <tr><td><?=++$sl?></td>
        <td><?=$data->Card_No?></td>
        <td><?=$data->reserve_id?></td>
        <td><?=$data->guest_name?></td>
        <td><?=$data->company?></td>
        <td><?=$data->check_in_date?></td>
        <td><?=$data->check_out_date?></td>
        <td><?=$data->Person?></td>
        <td><?=$data->Room_No?></td>
		<td><?=$data->allocated_room?></td>
		<td><?=$val['2'][$data->reserve_id]+$val['3'][$data->reserve_id]?></td>
		<td><?=$val['1'][$data->reserve_id]?></td>
        <td><?=$val['13'][$data->reserve_id]?></td>
        <td><?=$val['7'][$data->reserve_id]?></td>
		<td><?=$val['6'][$data->reserve_id]?></td>
        <td><?=$val['10'][$data->reserve_id]?></td>
        <td><?=$val['12'][$data->reserve_id]?></td>
		<td><?=$vat_sc=find_a_field('hms_bill_payment','sum(service_charge+vat_amt)','reserve_id='.$data->reserve_id)?></td>
		<td><?=$total = ($val['1'][$data->reserve_id]+$val['2'][$data->reserve_id]+$val['3'][$data->reserve_id]+$val['6'][$data->reserve_id]+$val['7'][$data->reserve_id]+$val['10'][$data->reserve_id]+$val['13'][$data->reserve_id]+$val['12'][$data->reserve_id]+$vat_sc)?></td>
        <td><?=$discount=find_a_field('hms_bill_payment','sum(paid_amt)','service_group_id = 5 and reserve_id='.$data->reserve_id)?></td>
        <td><?=$cash=find_a_field('hms_bill_payment','sum(paid_amt)','service_group_id!=5 and service_group_id!=8 and reserve_id='.$data->reserve_id)?></td>
        <td><?=$online=find_a_field('hms_bill_payment','sum(paid_amt)','optional_service_id = 148 and reserve_id='.$data->reserve_id)?></td>
         <td><?=$due=find_a_field('hms_bill_payment','sum(paid_amt)','optional_service_id = 21 and reserve_id='.$data->reserve_id)?></td>
        <td><?=($cash+$online+$due+=$discount)?></td>
      </tr>
        
     <? }?></tbody></table>
<? 
}
elseif($_POST['report']==31)
{
?>
<table cellspacing="0" cellpadding="2" border="0" width="100%"><thead><tr><td colspan="27" style="border:0px;"><?=$str?></td></tr>

    <tr>
      <th colspan="10">Information</th>
      <th rowspan="2">Opening</th>
      <th colspan="10">Daily Sale</th>
      <th colspan="5">Collection</th>
      <th>&nbsp;</th>
    </tr>
  <tr><th>S/L</th>
    <th>Card No</th>
    <th>Bill No</th>
    <th>Guest Name</th>
    <th>Company</th>
    <th>Check In Date</th>
    <th>Check Out Date</th>
    <th>Person</th>
    <th>Room No</th>
    <th>Room Allocated</th>
    <th>Room Charge</th>
    <th>Resturent</th>
    <th>Mini Bar</th>
    <th>Rent a Car </th><th>Laundry</th>
    <th>Conferance Hall</th>
    <th>Extra Bed</th>
    <th>Others</th>
    <th>Vat &amp; SC</th>
    <th>Total</th>
    <th>Discount</th>
    <th>Cash</th>
    <th>Card/Online</th>
    
    <th>Due/Credit</th>
    <th>Total</th>
    <th>Closing</th>
    </tr></thead><tbody>
    <?
		if(isset($room_id)) {$room_con=' and a.room_id='.$room_id;} 
		if(isset($service_id)) {$service_con=' and a.service_group_id='.$service_id;} 
		$fr_date2 = date('Y-m-d',(strtotime($fr_date)-84600));
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_conss=' and b.bill_date between \''.$fr_date2.'\' and \''.$to_date.'\'';
		$date_con=' and b.bill_date between \''.$fr_date.'\' and \''.$to_date.'\'';
		$date_cons=' and bill_date between \''.$fr_date.'\' and \''.$to_date.'\'';
		$date_pre_con=' and bill_date <= \''.$fr_date.'\'';
		}
		
		

		$sql22="select s.reserve_id,h.reference_card Card_No,h.check_in_date ,GROUP_CONCAT(distinct r.room_no SEPARATOR ', ') Room_No,
		count(distinct r.room_no) allocated_room,concat(substring(h.check_in_time,1,2),':',substring(h.check_in_time,3,2)) check_in_time ,h.client_name as guest_name, 
		h.reference_agent company,h.nationality,h.no_of_adult as Person,  h.check_out_date  from 
	hms_hotel_room_status s,
	hms_hotel_room r,
	hms_reservation h,
	hms_bill_payment b
	 where s.room_id=r.id and h.id=s.reserve_id and b.reserve_id=s.reserve_id ".$date_cons." group by s.reserve_id";
	$query = db_query($sql22);
	while($data = mysqli_fetch_object($query)){
	
	$opening=find_a_field('hms_bill_payment','sum(bill_amt-paid_amt)',' bill_date<"'.$f_date.'" and reserve_id='.$data->reserve_id);
	$closing=find_a_field('hms_bill_payment','sum(bill_amt-paid_amt)',' bill_date<="'.$t_date.'" and reserve_id='.$data->reserve_id);
    $res = "select sum(b.total_amt) total_sum,b.service_group_id from hms_bill_payment b where b.reserve_id='".$data->reserve_id."' ".$date_con." group by b.service_group_id";
	$resquery = mysqli_query($res);
	while($info = mysqli_fetch_object($resquery)){
	$val[$info->service_group_id][$data->reserve_id] = $info->total_sum;
	}
	?>
    <tr>
<td><?=++$sl?></td>
<td><a target=”_blank” href="../transaction/bill_invoice_final.php?reserve_no=<?=$data->reserve_id?>"><?=$data->Card_No?></a></td>
<td><?=$data->reserve_id?></td>
<td><?=$data->guest_name?></td>
<td><?=$data->company?></td>
<td><?=$data->check_in_date?></td>
<td><?=$data->check_out_date?></td>
<td><?=$data->Person?></td>
<td><?=$data->Room_No?></td>
<td><?=$data->allocated_room?><? $allocated_total = $allocated_total + $data->allocated_room; ?></td>
<td><?=$opening; $total_opening = $total_opening + $opening;?></td>
<td><?=($val['2'][$data->reserve_id]+$val['3'][$data->reserve_id]); $total23 = $total23 + ($val['2'][$data->reserve_id]+$val['3'][$data->reserve_id]);?></td>
<td><?=$val['1'][$data->reserve_id]; $total1 = $total1 + ($val['1'][$data->reserve_id]);?></td>
<td><?=$val['13'][$data->reserve_id]; $total13 = $total13 + ($val['13'][$data->reserve_id]);?></td>
<td><?=$val['7'][$data->reserve_id]; $total7 = $total17 + ($val['7'][$data->reserve_id]);?></td>
<td><?=$val['6'][$data->reserve_id]; $total6 = $total6 + ($val['6'][$data->reserve_id]);?></td>
<td><?=$val['10'][$data->reserve_id]; $total10 = $total10 + ($val['10'][$data->reserve_id]);?></td>
<td><?=$val['12'][$data->reserve_id]; $total12 = $total12 + ($val['12'][$data->reserve_id]);?></td>
<td><?=$val['14'][$data->reserve_id]; $total14 = $total14 + ($val['14'][$data->reserve_id]);?></td>
<td><?=$vat_sc=find_a_field('hms_bill_payment','sum(service_charge+vat_amt)','reserve_id='.$data->reserve_id.$date_cons); $total_vat_sc = $total_vat_sc+$vat_sc;?></td>
<td><?=$total = ($val['1'][$data->reserve_id]+$val['2'][$data->reserve_id]+$val['3'][$data->reserve_id]+$val['6'][$data->reserve_id]+$val['7'][$data->reserve_id]+$val['10'][$data->reserve_id]+$val['14'][$data->reserve_id]+$val['13'][$data->reserve_id]+$val['12'][$data->reserve_id]+$vat_sc); $all_total = $all_total + $total;?></td>
<td><?=$discount=find_a_field('hms_bill_payment','sum(paid_amt)','service_group_id = 5 and reserve_id='.$data->reserve_id.$date_cons);$all_discount = $all_discount + $discount;?></td>
<td><?=$cash=find_a_field('hms_bill_payment','sum(paid_amt)','optional_service_id != 148 and service_group_id!=5 and service_group_id!=8 and reserve_id='.$data->reserve_id.$date_cons);$all_cash = $all_cash + $cash;?></td>
<td><?=$online=find_a_field('hms_bill_payment','sum(paid_amt)','optional_service_id = 148 and reserve_id='.$data->reserve_id.$date_cons);$all_online = $all_online + $online;?></td>
<td><?=$due=find_a_field('hms_bill_payment','sum(paid_amt)','optional_service_id = 21 and reserve_id='.$data->reserve_id.$date_cons);$all_due = $all_due + $due;?></td>
<td><?=$col_total = ($cash+$online+$due+$discount); $all_col_total = $all_col_total + $col_total;?></td>
<td><?=$closing;  $total_closing = $total_closing + $closing;?></td>
      </tr>
        
     <? }?>
<tr><td colspan="9">&nbsp;</td>
<td><?=$allocated_total;?></td>
<td><?=$total_opening;?></td>
<td><?=$total23;?></td>
<td><?=$total1;?></td>
<td><?=$total13;?></td>
<td><?=$total7;?></td>
<td><?=$total6;?></td>
<td><?=$total10;?></td>
<td><?=$total12;?></td>
<td><?=$total14;?></td>
<td><?=$total_vat_sc;?></td>
<td><?=$all_total;?></td>
<td><?=$all_discount;?></td>
<td><?=$all_cash;?></td>
<td><?=$all_online;?></td>
<td><?=$all_due;?></td>
<td><?=$all_col_total;?></td>
<td><?=$total_closing;?></td>
      </tr>
     </tbody></table>
<br /><br /><table width="50%" border="0" align="center">
  <tr>
    <td width="50%">Net Sales</td>
    <td>Total Collection</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td>Total Sales:</td>
        <td><?=$all_total;?></td>
      </tr>
      <tr>
        <td>Total Discount:</td>
        <td><?=$all_discount;?></td>
      </tr>
      <tr>
        <td>Total Net Sales:</td>
        <td><?=$all_total-$all_discount;?></td>
      </tr>
      
    </table></td>
    <td><table width="100%" border="0">
      
      <tr>
        <td>Cash:</td>
        <td><?=$all_cash;?></td>
      </tr>
      <tr>
        <td>Online:</td>
        <td><?=$all_online;?></td>
      </tr>
      <tr>
        <td>Total Collection:</td>
        <td><?=$all_cash+$all_online;?></td>
      </tr>
    </table></td>
  </tr>
</table>

<? 
}

elseif($_POST['report']==32)
{
?>
<table cellspacing="0" cellpadding="2" border="0" width="100%"><thead><tr><td colspan="25" style="border:0px;"><?=$str?></td></tr>

    <tr>
      <th colspan="10">Information</th>
      <th colspan="10">Daily Sale</th>
      <th colspan="5">Collection</th>
      </tr>
  <tr><th>S/L</th>
    <th>Card No</th>
    <th>Bill No</th>
    <th>Guest Name</th>
    <th>Company</th>
    <th>Check In Date</th>
    <th>Check Out Date</th>
    <th>Person</th>
    <th>Room No</th>
    <th>Room Allocated</th>
    <th>Room Charge</th>
    <th>Resturent</th>
    <th>Mini Bar</th>
    <th>Rent a Car </th><th>Laundry</th>
    <th>Conferance Hall</th>
    <th>Extra Bed</th>
    <th>Others</th>
    <th>Vat &amp; SC</th>
    <th>Total</th>
    <th>Discount</th>
    <th>Cash</th>
    <th>Card/Online</th>
    
    <th>Due/Credit</th>
    <th>Total</th>
    </tr></thead><tbody>
    <?
		if(isset($room_id)) {$room_con=' and a.room_id='.$room_id;} 
		if(isset($service_id)) {$service_con=' and a.service_group_id='.$service_id;} 
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and h.check_out_date between \''.$fr_date.'\' and \''.$to_date.'\'';
		$date_cons='';
		$date_pre_con=' and bill_date <= \''.$fr_date.'\'';
		}
		
		

		 $sql22="select s.reserve_id,GROUP_CONCAT(distinct r.room_no SEPARATOR ', ') Room_No,count(distinct r.room_no) allocated_room,h.reference_card Card_No,h.check_in_date ,concat(substring(h.check_in_time,1,2),':',substring(h.check_in_time,3,2)) check_in_time ,h.client_name as guest_name, h.reference_agent company,h.nationality,h.no_of_adult as Person,  h.check_out_date  from 
	hms_hotel_room_status s,
	hms_hotel_room r,
	hms_reservation h,
	hms_bill_payment b
	 where s.room_id=r.id and h.id=s.reserve_id and b.reserve_id=s.reserve_id  and h.check_out_by>0 ".$date_con." group by s.reserve_id";
	$query = db_query($sql22);
	while($data = mysqli_fetch_object($query)){
	
	//$opening=find_a_field('hms_bill_payment','sum(bill_amt-paid_amt)',' bill_date<"'.$f_date.'" and reserve_id='.$data->reserve_id);
	//$closing=find_a_field('hms_bill_payment','sum(bill_amt-paid_amt)',' bill_date<="'.$t_date.'" and reserve_id='.$data->reserve_id);
    $res = "select sum(b.total_amt) total_sum,b.service_group_id from hms_bill_payment b where b.reserve_id='".$data->reserve_id."'  group by b.service_group_id";
	$resquery = db_query($res);
	while($info = mysqli_fetch_object($resquery)){
	$val[$info->service_group_id][$data->reserve_id] = $info->total_sum;
	}
	?>
    <tr>
<td><?=++$sl?></td>
<td><?=$data->Card_No?></td>
<td><?=$data->reserve_id?></td>
<td><?=$data->guest_name?></td>
<td><?=$data->company?></td>
<td><?=$data->check_in_date?></td>
<td><?=$data->check_out_date?></td>
<td><?=$data->Person?></td>
<td><?=$data->Room_No?></td>
<td><?=$data->allocated_room?></td>
<td><?=($val['2'][$data->reserve_id]+$val['3'][$data->reserve_id]); $total23 = $total23 + ($val['2'][$data->reserve_id]+$val['3'][$data->reserve_id]);?></td>
<td><?=$val['1'][$data->reserve_id]; $total1 = $total1 + ($val['1'][$data->reserve_id]);?></td>
<td><?=$val['13'][$data->reserve_id]; $total13 = $total13 + ($val['13'][$data->reserve_id]);?></td>
<td><?=$val['7'][$data->reserve_id]; $total7 = $total17 + ($val['7'][$data->reserve_id]);?></td>
<td><?=$val['6'][$data->reserve_id]; $total6 = $total6 + ($val['6'][$data->reserve_id]);?></td>
<td><?=$val['10'][$data->reserve_id]; $total10 = $total10 + ($val['10'][$data->reserve_id]);?></td>
<td><?=$val['12'][$data->reserve_id]; $total12 = $total12 + ($val['12'][$data->reserve_id]);?></td>
<td><?=$val['14'][$data->reserve_id]; $total14 = $total14 + ($val['14'][$data->reserve_id]);?></td>
<td><?=$vat_sc=find_a_field('hms_bill_payment','sum(service_charge+vat_amt)','reserve_id='.$data->reserve_id.$date_cons); $total_vat_sc = $total_vat_sc+$vat_sc;?></td>
<td><?=$total = ($val['1'][$data->reserve_id]+$val['2'][$data->reserve_id]+$val['3'][$data->reserve_id]+$val['6'][$data->reserve_id]+$val['7'][$data->reserve_id]+$val['10'][$data->reserve_id]+$val['14'][$data->reserve_id]+$val['13'][$data->reserve_id]+$val['12'][$data->reserve_id]+$vat_sc); $all_total = $all_total + $total;?></td>
<td><?=$discount=find_a_field('hms_bill_payment','sum(paid_amt)','service_group_id = 5 and reserve_id='.$data->reserve_id.$date_cons);$all_discount = $all_discount + $discount;?></td>
<td><?=$cash=find_a_field('hms_bill_payment','sum(paid_amt)','service_group_id!=5 and service_group_id!=8 and reserve_id='.$data->reserve_id.$date_cons);$all_cash = $all_cash + $cash;?></td>
<td><?=$online=find_a_field('hms_bill_payment','sum(paid_amt)','optional_service_id = 148 and reserve_id='.$data->reserve_id.$date_cons);$all_online = $all_online + $online;?></td>
<td><?=$due=find_a_field('hms_bill_payment','sum(paid_amt)','optional_service_id = 21 and reserve_id='.$data->reserve_id.$date_cons);$all_due = $all_due + $due;?></td>
<td><?=$col_total = ($cash+$online+$due+$discount); $all_col_total = $all_col_total + $col_total;?></td>
</tr>
        
     <? }?>
         <tr><td colspan="10">&nbsp;</td>
<td><?=$total23;?></td>
<td><?=$total1;?></td>
<td><?=$total13;?></td>
<td><?=$total7;?></td>
<td><?=$total6;?></td>
<td><?=$total10;?></td>
<td><?=$total12;?></td>
<td><?=$total14;?></td>
<td><?=$total_vat_sc;?></td>
<td><?=$all_total;?></td>
<td><?=$all_discount;?></td>
<td><?=$all_cash;?></td>
<td><?=$all_online;?></td>
<td><?=$all_due;?></td>
<td><?=$all_col_total;?></td>
</tr>
     </tbody></table>
<br /><br /><table width="50%" border="0" align="center">
  <tr>
    <td width="50%">Net Sales</td>
    <td>Total Collection</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td>Total Sales:</td>
        <td><?=$all_total;?></td>
      </tr>
      <tr>
        <td>Total Discount:</td>
        <td><?=$all_discount;?></td>
      </tr>
      <tr>
        <td>Total Net Sales:</td>
        <td><?=$all_total-$all_discount;?></td>
      </tr>
      
    </table></td>
    <td><table width="100%" border="0">
      
      <tr>
        <td>Cash:</td>
        <td><?=$all_cash;?></td>
      </tr>
      <tr>
        <td>Online:</td>
        <td><?=$all_online;?></td>
      </tr>
      <tr>
        <td>Total Collection:</td>
        <td><?=$all_cash+$all_online;?></td>
      </tr>
    </table></td>
  </tr>
</table>

<? 
}
else echo report_create($sql,1,$str);
?></div>
</body>
</html>