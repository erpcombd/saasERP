<?php
session_start();
require "../../support/inc.all.php";

$date=$_REQUEST['date'];
$id=$_REQUEST['id'];

if(isset($_REQUEST['status']))
{
$status_new=$_REQUEST['status'];
$status_detail=$_REQUEST['status_detail'];
$sql="update hms_hotel_room set status='".$status_new."' , status_detail='".$status_detail."' where id='".$id."'";
mysql_query($sql);
}

$sql="select r.id,f.floor_name,t.room_type,r.room_no,t.rate,t.discount,r.status,r.status_detail from hms_hotel_room r, hms_hotel_floor f, hms_room_type t where r.floor_id=f.id and r.room_type_id=t.id and r.id='".$id."' limit 1";
$query=mysql_query($sql);
if(mysql_num_rows($query)>0)
$data=mysql_fetch_row($query);

$room_status = find_a_field('hms_hotel_room_status','room_status',"room_id='".$data[0]."' and date='".$date."' order by id desc");

if($data[6]==1)
$status='Ready';
elseif($data[6]==2)
$status='Dirty';
elseif($data[6]==9)
$status='Occupied';

elseif($data[6]==29)
$status='Occupied & Dirty';
else
$status='Out of Order';
$status_detail=$data[7];

?>
<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
  <tr bgcolor="#679435">
    <td colspan="2" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Room Status :: <?=$status?></td>
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

<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
  
  <tr>
    <td width="100%" align="right" style="padding:5px;"><form id="form1" name="form1" method="post" action="">
      <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
        <tr bgcolor="#679435">
          <td colspan="2" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Status Detail ::
            <? if($status_detail=='') echo 'NA'; else $status_detail?></td>
        </tr>
        <tr bgcolor="#f8fbc1">
          <td width="39%" align="right" style="padding:5px;">Status Detail : </td>
          <td width="61%" align="left"><label>
            <input name="status_detail" type="text" id="status_detail" size="40" />
			<input name="id" id="id" type="hidden" size="40" value="<?=$id?>" />
          </label></td>
        </tr>
        <tr>
          <td align="right" style="padding:5px;">Status : </td>
          <td align="left"><label>
            <select name="status">
<?
	if($data[6]!=9)
	{ 
		if($data[6]!=1)
		{ 
		?>
		<option value="1">Availavle for Rent</option>
		<?
		}
		if($data[6]>0)
		{ 
		?>
		<option value="0">Out of Order</option>
		<?
		}
		if($data[6]!=2)
		{ 
		?>
		<option value="2">Room Dirty</option>
		<?
		}
	}
	else
	?>
	<option value="29">Occupied & Dirty</option>
	<?
?>
            </select>
          </label></td>
        </tr>
        <tr bgcolor="#f8fbc1">
          <td colspan="2" align="right" style="padding:5px;"><div align="center">
            <input type="submit" name="Submit" value="Submit" style="font-weight:bold; color:#fff; background-color:#669966" />
          </div></td>
          </tr>
      </table>
        </form>
    <div align="center">

	</div>	</td>
  </tr>
</table>
