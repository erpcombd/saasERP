<?php
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$date=$_REQUEST['date'];
$id=$_REQUEST['id'];

$sql="select r.id,f.floor_name,t.room_type,r.room_no,t.rate,t.discount,r.status,r.status_detail from hms_hotel_room r, hms_hotel_floor f, hms_room_type t where r.floor_id=f.id and r.room_type_id=t.id and r.id='".$id."' limit 1";
$query=mysqli_query($conn,$sql);
if(mysqli_num_rows($query)>0)
$data=mysqli_fetch_row($query);
    $o_status=$data[6];
	$status_all = find_all_field('hms_hotel_room_status','room_status',"room_id='".$data[0]."' and date='".$date."' order by id desc");
	$status = $status_all->room_status;
	$reserve_id = $status_all->reserve_id;

	if($status==1)// reserve
	$room_status='Reserved';
	elseif($status==9) // book
	$room_status='Booked';
	else // free
	{
	if($o_status==9)
	{
	$status_all = find_all_field('hms_hotel_room_status','room_status',"room_id='".$data[0]."' order by id desc");
	$status = $status_all->room_status;
	$reserve_id = $status_all->reserve_id;
	}
	else
	$room_status='Free';
	}
	$reserve_all = find_all_field('hms_reservation','id',"id='".$reserve_id."'");
	
	if($o_status==0)
	$room_status='Out of Order';
	//echo $o_status;
?>
<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
  <tr bgcolor="#679435">
    <td colspan="2" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Room Information </td>
  </tr>
  <tr bgcolor="#f8fbc1">
    <td width="39%" align="right" style="padding:5px;">Room No :  </td>
    <td width="61%" align="left"><?=$data[3]?>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" style="padding:5px;">Floor No : </td>
    <td align="left"><?=$data[1]?></td>
  </tr>
  <tr bgcolor="#f8fbc1">
    <td style="padding:5px;" align="right">Room Type :  </td>
    <td align="left"><?=$data[2]?></td>
  </tr>
  <tr>
    <td style="padding:5px;" align="right">Rent Price :  </td>
    <td align="left"><?=$data[4]?></td>
  </tr>
  <tr bgcolor="#f8fbc1">
    <td style="padding:5px;" align="right">Vat : </td>
    <td align="left"><?=$data[5]?></td>
  </tr>
  <tr>
    <td style="padding:5px;" align="right">Status Detail : </td>
    <td align="left"><?=$data[7]?></td>
  </tr>
</table>
<? if($o_status>0){?>
<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
  <tr bgcolor="#679435">
    <td colspan="2" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Room Status :: <?=$room_status?> </td>
  </tr>
  <? if($status>0){
  ?>
  <tr bgcolor="#f8fbc1">
    <td width="39%" align="right" style="padding:5px;">Client Name : </td>
    <td width="61%" align="left"><?=$reserve_all->client_name?>
      &nbsp;</td>
  </tr>
  <tr>
    <td align="right" style="padding:5px;">Client Address : </td>
    <td align="left"><?=$reserve_all->client_address?></td>
  </tr>
  <tr bgcolor="#f8fbc1">
    <td style="padding:5px;" align="right">Contact No : </td>
    <td align="left"><?=$reserve_all->contact_no?></td>
  </tr>
  <? }?>
  <tr>
    <td colspan="2" align="right" style="padding:5px;">
	<div align="center">
	<?
	if($o_status==9)
	{ 
	?>
	<a href="check_in_info_front.php?reserve_id=<?=$reserve_id?>">CHECK IN DETAILS</a>
	<?
	}
	elseif($status==1)
	{
	?><a href="reservation_info_front.php?reserve_id=<?=$reserve_id?>">RESERVED CHECK IN</a>
	<?}
	else
	{?><!-- <a href="reservation_info_front.php?id=<?=$id?>&date=<?=$date?>"> --> NEW CHECK IN<!--</a> -->
	<? }
	?>
	</div>
	</td>
	
    
  </tr>
  <tr bgcolor="#f8fbc1">
    <td colspan="2" align="right" style="padding:5px;"><div align="center"><a target="_blank" href="bill_manage.php?r_id=<?=$id?>">BILL INFO</a></div></td>
  </tr>

</table>
<? }?>