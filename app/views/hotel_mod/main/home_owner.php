<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Owner Profit';
$table='hms_owner_profit';
$unique='id';

if($_REQUEST['billing'])
{
	$owner_id=$_REQUEST['owner_id'];
	$year=$_REQUEST['year'];
	$session_id=$_REQUEST['session_id'];

	$hotel_profit=$_REQUEST['hotel_profit'];
	$owner_profit=$_REQUEST['owner_profit'];

	
	 $sql="INSERT INTO `hms_owner_profit` (
	`owner_id` ,
	`year` ,
	`session_id` ,
	`hotel_profit` ,
	`owner_profit` 
	) VALUES ('$owner_id', '$year', '$session_id', '$hotel_profit', '$owner_profit')";
	mysql_query($sql);
}
?>
<?
if((isset($_REQUEST['owner_id']))&&isset($_REQUEST['year']))
{
$owner_id=$_REQUEST['owner_id'];
$year=$_REQUEST['year'];

$sql="select a.* from hms_owner_detail a where a.id='".$owner_id."' limit 1";
$i=mysql_query($sql);
if(mysql_num_rows($i)>0)
$info=mysql_fetch_object($i);
}
?> 
<div class="form-container_large">
<form action="" method="post" name="form2" id="form2">
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>
			<fieldset>
			<legend>Owner Information</legend>
			
						<div>
			<label>Year : </label>
			<input  name="owner_id" type="hidden" id="owner_id" value="<?=$_SESSION['user']['id']?>"/>
<select name="year" id="year">
<option><?=$year?></option>
<option>2012</option>
<option>2013</option>
<option>2014</option>
<option>2015</option>
</select>
			</div>
			<div class="buttonrow" style="margin-left:154px;"><input name="submit" type="submit" class="btn1" value="Search details " /></div>
			</fieldset>	</td>
    <td>
			<fieldset>
			<legend>Owner Details</legend>
			<div>
			<label>Name : </label>

			<input  name="" type="text" id="" value="<?=$info->name?>"/>
			</div>
			<div>
			<label for="email">Address : </label>
			<span id="bld">
			<textarea name="" id=""><?=$info->address?></textarea>
			</span>                                        </div>
			<div>
			<label for="fname">Contact no. : </label>
			<span id="fid">
			<input  name="" type="text" id="" value="<?=$info->contact_no?>"/>
			</span>                                        </div>
			</fieldset>	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</div>

<div class="box4">
<? if(isset($info->name)&&$info->name!=''){
$res1='select sum(hotel_profit),sum(owner_profit) from `hms_owner_profit` where owner_id='.$info->id.' and year='.$year;
$data=mysql_fetch_row(mysql_query($res1));

		?>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td><div class="tabledesign2">
        <? 

$res="select a.id, b.name,concat(e.room_name,':',c.session) as room_session,a.hotel_profit,a.owner_profit from hms_owner_profit a, hms_owner_detail b, hms_owner_session c, hms_ownership d ,`hms_hotel_room` e where 
a.session_id=d.id and d.session_id=c.id and d.room_id=e.id and
b.id=a.owner_id and a.owner_id=".$info->id." and a.year=".$year;





echo link_report($res);
		?>

      </div></td>
    </tr>
	    <tr>
      <td><table width="47%" border="0" cellspacing="2" cellpadding="0" align="right">
        <tr>
          <td > Total: </td>
          <td ><input name="user_id" type="text" id="user_id" value="<?=$data[0]?>" /></td>
          <td ><input name="name" id="name" type="text" value="<?=$data[1]?>" /></td>
        </tr>
      </table></td>
    </tr>
	
	

				
    <tr>
     <td>

 </td>
    </tr>
  </table><? }?></div>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>