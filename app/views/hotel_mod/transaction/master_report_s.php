<?
session_start();
require "../../common/check.php";
require "../../config/db_connect.php";
require "../../common/report.class.php";
require "../../common/my.php";
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

		
		$sql='select a.id as bill_no,a.bill_date,if(a.room_id=0,"Guest",(select room_no from hms_hotel_room where id=a.room_id)) as room_no,
		if(a.service_staff_id=0,"Not Defined",(select staff_name from hms_service_staff where id=a.service_staff_id)) as Waiter,
		 a.total_amt,a.discount_amt discount,
		if(a.paid_in="Cash"||a.paid_in="",a.paid_amt,"0.00" ) cash,
		if(a.paid_in="Credit Card",a.paid_amt,"0.00" ) Online, 
		if(a.paid_amt<a.bill_amt,(a.bill_amt - a.paid_amt),"0.00" ) Credit,
		if(a.paid_amt<a.bill_amt,(a.bill_amt - a.paid_amt),"0.00" ) balance,if(a.paid_in="Complementary",a.paid_amt,"0.00" ) Complementary from hms_bill_payment a where 1 '.$date_con.$service_con.' ' ;
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
	if((strlen($_POST['t_date'])==10)&&(strlen($_POST['f_date'])==10))
	{
	$to_date=$_POST['t_date'];
	$fr_date=$_POST['f_date'];
		$date_con='  and  h.checked_in>0 and check_in_date between \''.$fr_date.'\' and \''.$to_date.'\'';
	}
	else
	$date_con = ' and  h.checked_in>0';
	$sql="select distinct(r.id), r.room_no,h.client_name as guest_name, h.company_name,h. contact_no,h.national_id,h.passport_no, h.no_of_adult as NoA, h.no_of_child as NoC,h.nationality,h.check_in_date as arrival_date, h.check_out_date as departure_date from 
	hms_hotel_room_status s,
	hms_hotel_room r,
	hms_reservation h where s.room_id=r.id and h.id=s.reserve_id ".$date_con;
		
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
AND s.room_status =1
AND h.id = s.reserve_id
AND h.check_in_date between '".$fr_date."' and '". $to_date."' 
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
AND s.room_status =1
AND h.id = s.reserve_id
AND h.check_out_date between '".$fr_date."' and '". $to_date."' 
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
}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$report?></title>
<link href="../../css/report.css" type="text/css" rel="stylesheet" />
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

if($_POST['report']==1)
{
?>
<style type="text/css">

th {

    text-align: center;
}
</style>
<table cellspacing="0" cellpadding="2" border="0" width="100%"><thead><tr><td colspan="12" style="border:0px;"><?=$str?></td></tr>
<tr><th>S/L</th><th>Bill No</th><th>Bill Date</th><th>Room No</th><th>Waiter</th><th>Total Amt</th><th>Discount</th>
  <th>Complementary</th>
  <th>Cash</th><th>Online</th><th>Credit</th><th>Balance</th></tr></thead>
<?
$query = mysql_query($sql);
while($data = mysql_fetch_row($query)){
?>
<tbody><tr><td><? echo ++$sa;?></td><td><a href="../transaction/bill_invoice.php?bill_no=<?=$data[0]?>" target="_blank"><?=$data[0]?></a></td><td><?=$data[1]?></td><td><?=$data[2]?></td><td><?=$data[3]?></td><td style="text-align:right"><?=$data[4]?></td><td style="text-align:right"><?=$data[5]?></td>
  <td style="text-align:right"><?=$data[10]?></td>
  <td style="text-align:right"><?=$data[6]?></td><td style="text-align:right"><?=$data[7]?></td><td style="text-align:right"><?=$data[8]?></td><td style="text-align:right"><?=$data[9]?></td></tr>
<? }?>

<tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table>
<?
}

elseif(isset($sql)&&$sql!='') echo report_create($sql,1,$str);
?></div>
</body>
</html>