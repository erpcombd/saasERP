<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$table		= 'hms_reservation';
$crud      	= new crud($table);

$user_id=$_POST['user_id']=$_SESSION['user']['id'];
$reserve_id=$_REQUEST['reserve_id'];
$now=time();
$today=date('Y-m-d');
?>
<link href="../../../../public/assets/css/style.css" type="text/css" rel="stylesheet"/>
<link href=../../../../public/assets/css/pagination.css" rel="stylesheet" type="text/css" />
<link href="../../../../public/assets/css/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />
<link href="../../../../public/assets/css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../../../public/assets/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../../../public/assets/js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../../../../public/assets/js/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../../../../public/assets/js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="../../../../public/assets/js/jquery.validate.js"></script>
<script type="text/javascript" src="../../../../public/assets/js/paging.js"></script>
<script type="text/javascript" src="../../../../public/assets/js/ddaccordion.js"></script>
<script type="text/javascript" src="../../../../public/assets/js/js.js"></script>
<?
if($_REQUEST['check_in']==1)
{
		$sql="update `hms_reservation` set checked_in='$now' where id='$reserve_id'";
		db_query($sql);
		
		$sql="update hms_hotel_room_status set room_status=9 where reserve_id='$reserve_id'";
		db_query($sql);
		
		$sql="update hms_hotel_room set status='9' where id in (select room_id from hms_hotel_room_status where reserve_id='$reserve_id')";
		db_query($sql);
echo '<script type="text/javascript">
parent.parent.document.location.href = "../transaction/hotel_status.php";
</script>';
}

if($_REQUEST['check_out']==1)
{
		$sql="update `hms_reservation` set checked_out='$now' where id='$reserve_id'";
		db_query($sql);
		
		$sql="update hms_hotel_room_status set room_status=0 where date>='$today' and room_status=9 and  reserve_id='$reserve_id'";
		db_query($sql);
		
		$sql="update hms_hotel_room set status='2' where id in (select room_id from hms_hotel_room_status where reserve_id='$reserve_id')";
		db_query($sql);
				echo '<script type="text/javascript">
parent.parent.document.location.href = "../transaction/hotel_status.php";
</script>';
}


if($_REQUEST['adult'])
{
	$a_name=$_REQUEST['a_name'];
	$a_age=$_REQUEST['a_age'];
	$a_relation=$_REQUEST['a_relation'];
	$a_id_info=$_REQUEST['a_id_info'];
	$sql="INSERT INTO `hms_adults`  (`reserve_id`,  `name`,    `age`,    `relation`,    `id_info`) VALUES 
									('$reserve_id', '$a_name', '$a_age', '$a_relation', '$a_id_info')";
	db_query($sql);
}

if($_REQUEST['del_adult'])
{
	$adult_id=$_REQUEST['adult_id'];
	$reserve_id=$_REQUEST['reserve_id'];
	$sql="delete from hms_adults where reserve_id='$reserve_id' and id='$adult_id'";
	db_query($sql);
}

if($_REQUEST['del_room'])
{
	$room_id=$_REQUEST['id'];
	$room_id=$_REQUEST['room_id'];
	$reserve_id=$_REQUEST['reserve_id'];
	$sql="delete from hms_hotel_room_status where room_id='$room_id' and reserve_id='$reserve_id'";
	db_query($sql);
}

if($_REQUEST['billing'])
{
	$service_room_id=$_REQUEST['service_room_no'];
	$reserve_id=$_REQUEST['reserve_id'];

	$paid_amt=$_REQUEST['paid_amt'];
	$detail=$_REQUEST['detail'];
	$bill_date=$_REQUEST['paid_date'];
	$paid_date=$_REQUEST['paid_date'];
	$service_group_id=3;
	$service_id=3;



	$sql="INSERT INTO `hms_bill_payment` (
`reserve_id` ,
`room_id` ,
`service_group_id` ,
`paid_amt` ,
`bill_date` ,
`bill_amt` ,
`paid_date`
) VALUES ('$reserve_id', '$service_room_id', '$service_group_id',  '$paid_amt', '$bill_date','0', '$paid_date')";
	db_query($sql);
}

?>

<?
do_calander('#pay_date');
do_calander('#check_in_date');
do_calander('#check_out_date');
do_calander('#check_in');
do_calander('#check_out');
do_calander('#last_reserve_date');
do_calander('#paid_date');
do_calander('#bill_date');
$today=date('Y-m-d');


if(isset($_POST['room_add']))
{
	$room_no=$_POST['room_no'];
	$check_in=$_POST['check_in'];
	$check_out=$_POST['check_out'];
	
	$in_time=$_POST['in_time'];
	$out_time=$_POST['out_time'];
	
			$start_date = $check_in;
			$end_date = $check_out;
			
			if($in_time<600)
			$start_date = date ("Y-m-d", strtotime("-1 day", strtotime($start_date)));
			if($out_time<1230)
			$end_date = date ("Y-m-d", strtotime("-1 day", strtotime($end_date)));
			
			while (strtotime($start_date) <= strtotime($end_date)) {
			$sql="INSERT INTO `hms_hotel_room_status` 
(`room_id` ,
`room_status` ,
`date` ,
`status_date` ,
`reserve_id` ,
`user_id`)
VALUES ('$room_no', '9', '$start_date', '$today', '$reserve_id', '$user_id')";
db_query($sql);
		$sql="update hms_hotel_room set status='9' where id=$room_no";

		db_query($sql);
				$start_date = date ("Y-m-d", strtotime("+1 day", strtotime($start_date)));
			}
}


if(isset($_POST['client']))
{
			
			$_POST['create_on'] = $today;
			$_POST['user_id']	= $_SESSION['user']['id'];
			
	if(reserve_id>0)
	{
			$reserve_id = $crud->insert();
	}
	else
	{
			$_POST['id'] = $reserve_id;
			$crud->update('id');
	}
}

if($reserve_id>0)
{
		$condition="id=".$reserve_id;
		$data=db_fetch_object('hms_reservation',$condition);
		while (list($key, $value)=each($data))
		{ $$key=$value;}
}
//echo "select room_id from `hms_hotel_room_status` where room_status<1 and date='$check_in_date')";
?>

<style type="text/css">
<!--
.style1 {
	font-size: 24px;
	font-weight: bold;
}
-->
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top">
	<?
	if($reserve_id>0){
	?>
	<form name="check" action="?reserve_id=<?=$reserve_id?>" method="post" enctype="multipart/form-data">
<table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
  <tr bgcolor="#679435">
    <td colspan="2" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Client  Information </td>
  </tr>
  <tr bgcolor="#f8fbc1">
    <td width="39%" align="right" style="padding:3px;">Client Name : </td>
    <td width="61%" align="left" style="padding:3px;"><input name="client_name" type="text" id="client_name" value="<?=$client_name?>" size="20" />
      &nbsp;</td>
  </tr>
  <tr>
    <td align="right" style="padding:3px;">Mobile No : </td>
    <td align="left" style="padding:3px;"><input name="contact_no" type="text" id="contact_no" value="<?=$contact_no?>" size="20" /></td>
  </tr>
  <tr bgcolor="#f8fbc1">
    <td style="padding:3px;" align="right">Address  : </td>
    <td align="left" style="padding:3px;"><textarea name="client_address" cols="20" id="client_address"><?=$client_address?>
</textarea></td>
  </tr>
  <tr>
    <td align="right" style="padding:3px;">Member ID : </td>
    <td align="left" style="padding:3px;"><input name="client_id" type="text" id="client_id" value="<?=$client_id?>" size="20" /></td>
  </tr>
  <tr bgcolor="#f8fbc1">
    <td align="right" style="padding:3px;">National ID   : </td>
    <td align="left" style="padding:3px;"><input name="national_id" type="text" id="national_id" value="<?=$national_id?>" size="20" /></td>
  </tr>
  <tr>
    <td align="right" style="padding:3px;">Check In : </td>
    <td align="left" style="padding:3px;"><input name="check_in_date" type="text" id="check_in_date" value="<?=$check_in_date?>" size="10" /> 
	<select name="check_in_time">
	<? if(isset($check_in_time)) {
			if($check_in_time<1200) 
		echo '<option value="'.$check_in_time.'" selected>'.strstr($check_in_time,0,2).':'.strstr($check_in_time,2,2).' AM</option>';
			elseif($check_in_time<1300) 
		echo '<option value="'.$check_in_time.'" selected>'.strstr($check_in_time,0,2).':'.strstr($check_in_time,2,2).' PM</option>';
			else		
		echo '<option value="'.$check_in_time.'" selected>'.strstr($check_in_time,0,2).':'.strstr($check_in_time,2,2).' PM</option>';
		} 
			?>
            <option value="0000">12:00 AM</option>
            <option value="0030">12:30 AM</option>
            <option value="0100">01:00 AM</option>
            <option value="0130">01:30 AM</option>
            <option value="0200">02:00 AM</option>
            <option value="0230">02:30 AM</option>
            <option value="0300">03:00 AM</option>
            <option value="0330">03:30 AM</option>
            <option value="0400">04:00 AM</option>
            <option value="0430">04:30 AM</option>
            <option value="0500">05:00 AM</option>
            <option value="0530">05:30 AM</option>
            <option value="0600">06:00 AM</option>
            <option value="0630">06:30 AM</option>
            <option value="0700">07:00 AM</option>
            <option value="0730">07:30 AM</option>
            <option value="0800">08:00 AM</option>
            <option value="0830">08:30 AM</option>
            <option value="0900">09:00 AM</option>
            <option value="0930">09:30 AM</option>
            <option value="1000">10:00 AM</option>
            <option value="1030">10:30 AM</option>
            <option value="1100">11:00 AM</option>
            <option value="1130">11:30 AM</option>
            <option value="1200">12:00 PM</option>
            <option value="1230">12:30 PM</option>
            <option value="1300">01:00 PM</option>
            <option value="1330">01:30 PM</option>
            <option value="1400">02:00 PM</option>
            <option value="1430">02:30 PM</option>
            <option value="1500">03:00 PM</option>
            <option value="1530">03:30 PM</option>
            <option value="1600">04:00 PM</option>
            <option value="1630">04:30 PM</option>
            <option value="1700">05:00 PM</option>
            <option value="1730">05:30 PM</option>
            <option value="1800">06:00 PM</option>
            <option value="1830">06:30 PM</option>
            <option value="1900">07:00 PM</option>
            <option value="1930">07:30 PM</option>
            <option value="2000">08:00 PM</option>
            <option value="2030">08:30 PM</option>
            <option value="2100">09:00 PM</option>
            <option value="2130">09:30 PM</option>
            <option value="2200">10:00 PM</option>
            <option value="2230">10:30 PM</option>
            <option value="2300">11:00 PM</option>
            <option value="2330">11:30 PM</option>
          </select>
    </td>
  </tr>
  <tr bgcolor="#f8fbc1">
    <td align="right" style="padding:3px;">Check Out :</td>
    <td align="left" style="padding:3px;"><input name="check_out_date" type="text" id="check_out_date" value="<?=$check_out_date?>" size="10" />
	<select name="check_out_time">
	<? if(isset($check_out_time)) {
			if($check_out_time<1200) 
		echo '<option value="'.$check_out_time.'" selected>'.strstr($check_out_time,0,2).':'.strstr($check_out_time,2,2).' AM</option>';
			elseif($check_out_time<1300) 
		echo '<option value="'.$check_out_time.'" selected>'.strstr($check_out_time,0,2).':'.strstr($check_out_time,2,2).' PM</option>';
			else		
		echo '<option value="'.$check_out_time.'" selected>'.strstr($check_out_time,0,2).':'.strstr($check_out_time,2,2).' PM</option>';
		} 
			?>
            <option value="0000">12:00 AM</option>
            <option value="0030">12:30 AM</option>
            <option value="0100">01:00 AM</option>
            <option value="0130">01:30 AM</option>
            <option value="0200">02:00 AM</option>
            <option value="0230">02:30 AM</option>
            <option value="0300">03:00 AM</option>
            <option value="0330">03:30 AM</option>
            <option value="0400">04:00 AM</option>
            <option value="0430">04:30 AM</option>
            <option value="0500">05:00 AM</option>
            <option value="0530">05:30 AM</option>
            <option value="0600">06:00 AM</option>
            <option value="0630">06:30 AM</option>
            <option value="0700">07:00 AM</option>
            <option value="0730">07:30 AM</option>
            <option value="0800">08:00 AM</option>
            <option value="0830">08:30 AM</option>
            <option value="0900">09:00 AM</option>
            <option value="0930">09:30 AM</option>
            <option value="1000">10:00 AM</option>
            <option value="1030">10:30 AM</option>
            <option value="1100">11:00 AM</option>
            <option value="1130">11:30 AM</option>
            <option value="1200">12:00 PM</option>
            <option value="1230">12:30 PM</option>
            <option value="1300">01:00 PM</option>
            <option value="1330">01:30 PM</option>
            <option value="1400">02:00 PM</option>
            <option value="1430">02:30 PM</option>
            <option value="1500">03:00 PM</option>
            <option value="1530">03:30 PM</option>
            <option value="1600">04:00 PM</option>
            <option value="1630">04:30 PM</option>
            <option value="1700">05:00 PM</option>
            <option value="1730">05:30 PM</option>
            <option value="1800">06:00 PM</option>
            <option value="1830">06:30 PM</option>
            <option value="1900">07:00 PM</option>
            <option value="1930">07:30 PM</option>
            <option value="2000">08:00 PM</option>
            <option value="2030">08:30 PM</option>
            <option value="2100">09:00 PM</option>
            <option value="2130">09:30 PM</option>
            <option value="2200">10:00 PM</option>
            <option value="2230">10:30 PM</option>
            <option value="2300">11:00 PM</option>
            <option value="2330">11:30 PM</option>
          </select></td>
  </tr>
  <tr>
    <td align="right" style="padding:3px;">Conformation Date : </td>
    <td align="left" style="padding:3px;"><input name="last_reserve_date" type="text" id="last_reserve_date" value="<?=$last_reserve_date?>" size="10" /></td>
  </tr>
  <tr>
    <td colspan="2" align="right" style="padding:3px;"><div align="center"><span class="blue">
      <input type="submit" name="client" value="Submit" />
    </span></div></td>
  </tr>
</table>
<br>
	<table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
      <tr bgcolor="#679435">
        <td colspan="4" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Other Persons </td>
      </tr>
      <tr bgcolor="#f8fbc1">
        <td align="right" style="padding:3px;">Name : </td>
        <td colspan="3" align="left" style="padding:3px;"><input name="a_name" type="text" id="a_name" size="40" /></td>
        </tr>
      <tr>
        <td align="right" style="padding:3px;">Relation: </td>
        <td align="left" style="padding:3px;"><input name="a_relation" type="text" id="a_relation" size="10" /></td>
        <td align="right" style="padding:3px;">Age : </td>
        <td align="center" style="padding:3px;"><div align="left">
          <input name="a_age" type="text" id="a_age" size="10" />
        </div></td>
      </tr>
      <tr bgcolor="#f8fbc1">
        <td width="25%" align="right" style="padding:3px;">Id Info  : </td>
        <td width="50%" colspan="2" align="left" style="padding:3px;"><input name="a_id_info" type="text" id="a_id_info" size="28" /></td>
        <td width="25%" align="center"><span class="blue">
          <input name="adult" type="submit" id="adult" value="ADD" />
        </span></td>
      </tr>
    </table>
	<table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
      <tr bgcolor="#679435">
        <td width="25%" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Name </td>
        <td width="25%" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Relation </td>
        <td width="25%" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Age </td>
        <td width="25%" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">ID Info </td>
        <td width="25%" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">&nbsp;</td>
      </tr>
      <? $sql="select * from hms_adults where reserve_id='$reserve_id'";
	$query=db_query($sql);
	while($data=mysqli_fetch_row($query)){
?>
      <tr bgcolor="#f8fbc1">
        <td align="right" style="padding:3px;"><div align="center">
            <?=$data[2]?>
        </div></td>
        <td align="right" style="padding:3px;"><div align="center">
            <?=$data[3]?>
        </div></td>
        <td align="right" style="padding:3px;"><div align="center">
            <?=$data[4]?>
        </div></td>
        <td align="left"><div align="center">
            <?=$data[5]?>
        </div></td>
        <td align="left"><div align="center"><a href="?id=<?=$room_id?>&amp;date=<?=$date?>&amp;del_adult=1&amp;adult_id=<?=$data[0]?>&amp;reserve_id=<?=$reserve_id?>"><img src="../../images/del.png" width="16" height="16" /></a></div></td>
      </tr>
      <? }?>
    </table>
	</form>
	<?
	}
	?>
	</td>
    <td valign="top">
	<?
	if($reserve_id>0){
	?>
	<form name="room" action="?reserve_id=<?=$reserve_id?>" method="post" enctype="multipart/form-data">
<table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
  <tr bgcolor="#679435">
    <td colspan="3" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Room Reservation </td>
  </tr>
  <tr bgcolor="#f8fbc1">
    <td align="right" style="padding:3px;">Check IN: </td>
    <td align="left" style="padding:3px;"><input name="check_in" type="text" id="check_in" value="<?=$check_in_date?>" size="10" />
        <select name="in_time" id="in_time">
          <? if(isset($check_in_time)) {
			if($check_in_time<1200) 
		echo '<option value="'.$check_in_time.'" selected>'.substr($check_in_time,0,2).':'.substr($check_in_time,2,2).' AM</option>';
			elseif($check_in_time<1300) 
		echo '<option value="'.$check_in_time.'" selected>'.substr($check_in_time,0,2).':'.substr($check_in_time,2,2).' PM</option>';
			else		
		echo '<option value="'.$check_in_time.'" selected>'.substr($check_in_time,0,2).':'.substr($check_in_time,2,2).' PM</option>';
		} 
			?>
          <option value="0000">12:00 AM</option>
          <option value="0030">12:30 AM</option>
          <option value="0100">01:00 AM</option>
          <option value="0130">01:30 AM</option>
          <option value="0200">02:00 AM</option>
          <option value="0230">02:30 AM</option>
          <option value="0300">03:00 AM</option>
          <option value="0330">03:30 AM</option>
          <option value="0400">04:00 AM</option>
          <option value="0430">04:30 AM</option>
          <option value="0500">05:00 AM</option>
          <option value="0530">05:30 AM</option>
          <option value="0600">06:00 AM</option>
          <option value="0630">06:30 AM</option>
          <option value="0700">07:00 AM</option>
          <option value="0730">07:30 AM</option>
          <option value="0800">08:00 AM</option>
          <option value="0830">08:30 AM</option>
          <option value="0900">09:00 AM</option>
          <option value="0930">09:30 AM</option>
          <option value="1000">10:00 AM</option>
          <option value="1030">10:30 AM</option>
          <option value="1100">11:00 AM</option>
          <option value="1130">11:30 AM</option>
          <option value="1200">12:00 PM</option>
          <option value="1230">12:30 PM</option>
          <option value="1300">01:00 PM</option>
          <option value="1330">01:30 PM</option>
          <option value="1400">02:00 PM</option>
          <option value="1430">02:30 PM</option>
          <option value="1500">03:00 PM</option>
          <option value="1530">03:30 PM</option>
          <option value="1600">04:00 PM</option>
          <option value="1630">04:30 PM</option>
          <option value="1700">05:00 PM</option>
          <option value="1730">05:30 PM</option>
          <option value="1800">06:00 PM</option>
          <option value="1830">06:30 PM</option>
          <option value="1900">07:00 PM</option>
          <option value="1930">07:30 PM</option>
          <option value="2000">08:00 PM</option>
          <option value="2030">08:30 PM</option>
          <option value="2100">09:00 PM</option>
          <option value="2130">09:30 PM</option>
          <option value="2200">10:00 PM</option>
          <option value="2230">10:30 PM</option>
          <option value="2300">11:00 PM</option>
          <option value="2330">11:30 PM</option>
      </select></td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" style="padding:3px;">Check OUT: </td>
    <td align="left" style="padding:3px;"><input name="check_out" type="text" id="check_out" value="<?=$check_out_date?>" size="10" />
        <select name="out_time" id="out_time">
          <? 
			  if(isset($check_out_time)) {
			if($check_out_time<1200) 
		echo '<option value="'.$check_out_time.'" selected>'.substr($check_out_time,0,2).':'.substr($check_out_time,2,2).' AM</option>';
			elseif($check_out_time<1300) 
		echo '<option value="'.$check_out_time.'" selected>'.substr($check_out_time,0,2).':'.substr($check_out_time,2,2).' PM</option>';
			else		
		echo '<option value="'.$check_out_time.'" selected>'.(substr($check_out_time,0,2)-12).':'.substr($check_out_time,2,2).' PM</option>';
		} 
			?>
          <option value="0000">12:00 AM</option>
          <option value="0030">12:30 AM</option>
          <option value="0100">01:00 AM</option>
          <option value="0130">01:30 AM</option>
          <option value="0200">02:00 AM</option>
          <option value="0230">02:30 AM</option>
          <option value="0300">03:00 AM</option>
          <option value="0330">03:30 AM</option>
          <option value="0400">04:00 AM</option>
          <option value="0430">04:30 AM</option>
          <option value="0500">05:00 AM</option>
          <option value="0530">05:30 AM</option>
          <option value="0600">06:00 AM</option>
          <option value="0630">06:30 AM</option>
          <option value="0700">07:00 AM</option>
          <option value="0730">07:30 AM</option>
          <option value="0800">08:00 AM</option>
          <option value="0830">08:30 AM</option>
          <option value="0900">09:00 AM</option>
          <option value="0930">09:30 AM</option>
          <option value="1000">10:00 AM</option>
          <option value="1030">10:30 AM</option>
          <option value="1100">11:00 AM</option>
          <option value="1130">11:30 AM</option>
          <option value="1200">12:00 PM</option>
          <option value="1230">12:30 PM</option>
          <option value="1300">01:00 PM</option>
          <option value="1330">01:30 PM</option>
          <option value="1400">02:00 PM</option>
          <option value="1430">02:30 PM</option>
          <option value="1500">03:00 PM</option>
          <option value="1530">03:30 PM</option>
          <option value="1600">04:00 PM</option>
          <option value="1630">04:30 PM</option>
          <option value="1700">05:00 PM</option>
          <option value="1730">05:30 PM</option>
          <option value="1800">06:00 PM</option>
          <option value="1830">06:30 PM</option>
          <option value="1900">07:00 PM</option>
          <option value="1930">07:30 PM</option>
          <option value="2000">08:00 PM</option>
          <option value="2030">08:30 PM</option>
          <option value="2100">09:00 PM</option>
          <option value="2130">09:30 PM</option>
          <option value="2200">10:00 PM</option>
          <option value="2230">10:30 PM</option>
          <option value="2300">11:00 PM</option>
          <option value="2330">11:30 PM</option>
      </select></td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr bgcolor="#f8fbc1">
    <td width="25%" align="right" style="padding:3px;">Add Room : </td>
    <td width="50%" align="left" style="padding:3px;"><select name="room_no" id="room_no">
      <? 
			  $sql="SELECT a.id,concat(a.room_no,' : ',b.room_type) FROM `hms_hotel_room` a,`hms_room_type` b WHERE b.id=a.room_type_id and a.status in (1,2) order by a.room_no";
			  advance_foreign_relation($sql);?>
    </select>
      &nbsp;</td>
    <td width="25%" align="center"><span class="blue">
      <input name="room_add" type="submit" id="room_add" value="ADD" />
    </span></td>
  </tr>
</table>
<br>
      <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
        <tr bgcolor="#679435">
          <td width="25%" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Room ID </td>
          <td width="25%" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Room Type </td>
          <td width="25%" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Check IN </td>
          <td width="25%" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Check OUT </td>
          <td width="25%" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Reject</td>
        </tr>
<? $sql="select distinct b.id,b.room_no, c.room_type ,(select min(date) from hms_hotel_room_status where a.room_id=room_id and reserve_id=$reserve_id),(select max(date) from hms_hotel_room_status where a.room_id=room_id and reserve_id=$reserve_id) from hms_hotel_room_status a,hms_hotel_room b,hms_room_type c where a.reserve_id=$reserve_id and a.room_id=b.id and b.room_type_id=c.id";
	$query=db_query($sql);
	while($data=mysqli_fetch_row($query)){
?>
        <tr bgcolor="#f8fbc1">
          <td align="right" style="padding:3px;"><div align="center">
            <?=$data[1]?>
          </div></td>
          <td align="right" style="padding:3px;"><div align="center">
            <?=$data[2]?>
          </div></td>
          <td align="right" style="padding:3px;">
            <div align="center">
              <?=$data[3]?>
            </div></td>
          <td align="left">
            <div align="center">
              <?=$data[4]?>
            </div></td>
          <td align="left"><div align="center"><a href="?id=<?=$room_id?>&date=<?=$date?>&del_room=1&room_id=<?=$data[0]?>&reserve_id=<?=$reserve_id?>"><img src="../../images/del.png" width="16" height="16" /></a></div></td>
        </tr>
<? }?>  
      </table>
	  </form>
	  
	  <form action="?reserve_id=<?=$reserve_id?>" method="post" enctype="multipart/form-data" name="account" id="account">
        <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
          <tr bgcolor="#679435">
            <td colspan="4" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Advance Payment </td>
          </tr>
          <tr>
            <td width="25%" align="right" style="padding:3px;">Service : </td>
            <td width="25%" align="left" style="padding:3px;"><select name="service_id" id="service_id">
                <?
			$sql="SELECT a.id,a.service_name FROM `hms_services` a WHERE a.id =3";
			 advance_foreign_relation($sql);
				?>
              </select>
                <label>
                <input type="hidden" name="bill_id" value="" />
              </label></td>
            <td width="25%" align="right"> Total Due : </td>
            <td width="25%" align="left" style="padding:3px;"><?
			$sql="SELECT sum(bill_amt)-sum(paid_amt) FROM `hms_bill_payment` WHERE 
			reserve_id=".$reserve_id;
			?>
                <input name="due" type="text" id="due" value="<?=find_a_field_sql($sql)?>" size="10" /></td>
          </tr>
          <tr>
            <td width="25%" align="right" style="padding:3px;">Paid Amt : </td>
            <td width="25%" align="left" style="padding:3px;"><input name="paid_amt" type="text" id="paid_amt" size="10" /></td>
            <td width="25%" align="right" style="padding:3px;">Paid Date  :</td>
            <td width="25%" align="left" style="padding:3px;"><input name="paid_date" type="text" id="paid_date" value="<?=date('Y-m-d')?>" size="10" />
            </td>
          </tr>
          <tr bgcolor="#f8fbc1">
            <td width="25%" align="right" style="padding:3px;">Detail : </td>
            <td colspan="2" align="left" style="padding:3px;"><input name="detail" type="text" id="detail" value="" size="35" /></td>
            <td align="center"><span class="blue">
              <input name="billing" type="submit" id="billing" value="Submit" />
            </span></td>
          </tr>
        </table>
	    <br />
		<? 
		 $sql="select a.*,c.service_name from `hms_bill_payment` a, hms_services c where a.paid_amt<>a.bill_amt and a.reserve_id='$reserve_id' and c.id=a.service_group_id";?>
        <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
          <tr bgcolor="#679435">
            <td width="20%" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Date </td>
            <td width="40%" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Service</td>
            <td width="20%" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Bill</td>
            <td align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Paid </td>
          </tr>
          <?
		 
		  $query=@db_query($sql);
		  $i=1;
		  while($data=@mysqli_fetch_object($query))
		  { $i++;?>
          <tr <? if($i%2) echo 'bgcolor="#f8fbc1"';?>>
            <td width="20%" align="right" style="padding:3px;"><div align="center">
                <?=$data->bill_date?>
            </div></td>
            <td width="40%" align="left" style="padding:3px;"><div align="center">
                <?=$data->service_name?>
            </div></td>
            <td width="20%" align="left" style="padding:3px;"><div align="center">
                <?=$data->bill_amt?>
            </div></td>
            <td width="20%" align="left" style="padding:3px;"><div align="center">
                <?=$data->paid_amt?>
            </div></td>
          </tr>
          <? }?>
        </table>
      </form>
	  <? }?>
    </td>
  </tr>
</table>
<?
if($reserve_id>0)
{
$status_all = find_all_field('hms_hotel_room_status','room_status',"reserve_id='".$reserve_id."'");
$status_room = $status_all->room_status;
}
?>
<?
$sql="SELECT sum(bill_amt) bill,sum(paid_amt) pail amt FROM `hms_bill_payment` WHERE 
reserve_id=".$reserve_id;

$due = find_all_field_sql($sql);
if($due->bill>0&&(($due->bill-$due->paid)==0)){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>
        <div align="center">
		<form id="form1" name="form1" method="post" action="check_in_info_front.php?reserve_id=<?=$reserve_id?>&check_out=1">
          <input type="submit" name="checkout" value="CHECKED OUT" style="width:250px; height:40px; font-size:24px" />
		</form>
        </div>
      </td>
    </tr>
  </table>
 
    <? }
else{?>
 <div align="center">
    <span class="style1">DUE : </span>
    <input name="" type="text" value="<?=($due->bill-$due->paid)?>" style="width:250px; height:40px; font-size:18px;" />
  </div>
<? }?>