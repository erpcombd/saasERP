<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Bill Information(Date Wise)';
do_calander('#bill_date');
do_calander('#occu_date');
$table='hms_bill_payment';
$unique='id';
$today=date("Y-m-d");

if($_REQUEST['billing'])
{
	$service_room_id=$_REQUEST['room_id'];
	$service_id=$_REQUEST['service_id'];
	$reserve_id=$_REQUEST['reserve_id'];

	$bill_amt=date('Y-m-d');
	$paid_amt=$_REQUEST['paid_amt'];
	
	$sql="INSERT INTO `hms_bill_payment` (
	`reserve_id` ,
	`room_id` ,
	`service_group_id` ,
	`paid_amt` ,
	`bill_date` ,
	`bill_amt` ,
	`paid_date`
	) VALUES ('$reserve_id', '$service_room_id', '4',  '$paid_amt', '$bill_amt','0', '$bill_amt')";
	mysql_query($sql);
}
?>
<div class="form-container_large">
<form action="" method="post" name="form2" id="form2">
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>
			<fieldset>
			<legend>Bill Information</legend>
			<div>
			<label>Room No : </label>
<select name="r_id" id="r_id">
			<? $sql="SELECT a.id,concat(a.room_no,' : ',b.room_type) FROM `hms_hotel_room` a,`hms_room_type` b WHERE b.id=a.room_type_id order by a.room_no";
			advance_foreign_relation($sql,$r_id);?>
			  </select>
			</div>
			<div>
			<label>Occupy Date : </label>
<input name="occu_date" type="text" id="occu_date" value="<? if(isset($occu_date)) echo $occu_date; else echo date('Y-m-d');?>" />
			</div>
			<div class="buttonrow" style="margin-left:154px;"><input name="submit" type="submit" class="btn1" value="Search details " /></div>
			</fieldset>	</td>
    <td>
			<fieldset>
			<legend>Owner Details</legend>
			<div>
			<label>Name : </label>
<?
if(isset($_REQUEST['r_id']))
{
$r_id=$_REQUEST['r_id'];
$occu_date=$_REQUEST['occu_date'];
$sql="select a.* from hms_reservation a,hms_hotel_room_status b where b.room_id='".$r_id."' and b.date='".$occu_date."' and b.reserve_id=a.id order by id desc limit 1";
$i=mysql_query($sql);
if(mysql_num_rows($i)>0){
$info=mysql_fetch_object($i);
$reserve_id=$info->id;
}
}
?> 
			<input  name="" type="text" id="" value="<?=$info->client_name?>"/>
			</div>
			<div>
			<label for="email">Address : </label>
			<span id="bld">
			<textarea name="" id=""><?=$info->client_address?></textarea>
			</span>                                        </div>
			<div>
			<label for="fname">Mobile no. : </label>
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
<? if(isset($reserve_id)&&$reserve_id!=''){?>
<form action="?r_id=<?=$r_id?>" method="post" name="cloud" id="cloud">
<table  width="50%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
  <tr>
    <td align="center" bgcolor="#0099FF"><strong>Service Group</strong></td>
    <td align="center" bgcolor="#0099FF"><strong>Paid Amt</strong></td>
    <td  rowspan="2" align="center" bgcolor="#FF0000"><div class="button">
      <input name="billing" type="submit" id="billing" value="Confirm" tabindex="12" class="update"/>
    </div></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#CCCCCC"><span id="inst_no">
      <select name="service_id" id="service_id">
        <?
$sql="SELECT a.id,a.service_group FROM `hms_service_group` a WHERE a.id =4";
advance_foreign_relation($sql);
?>
      </select>
      </span>
        <input type="hidden" name="reserve_id" value="<?=$reserve_id?>" />
        <input type="hidden" name="room_id" value="<?=$r_id?>"/></td>
    <td align="center" bgcolor="#CCCCCC"><span id="inst_amt">
      <input name="paid_amt" type="text" id="paid_amt"  tabindex="10" class="input3" style="width:100px;" />
    </span> </td>
  </tr>
</table>
<div align="center"><a href="bill_invoice_final.php?reserve_no=<?= $reserve_id;?>" target="_blank"><img src="../../images/print.png" width="30" height="30" border="0" /></a><br />
</div>
<br />
</form>
<? }?>
<div class="box4">
<? if(isset($reserve_id)&&$reserve_id!='')
{

$res1='select sum(bill_amt),sum(paid_amt) from `hms_bill_payment` where reserve_id='.$reserve_id;
$data=mysql_fetch_row(mysql_query($res1));

		?>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td><div class="tabledesign2">
        <? 
$res='select a.id,s.service_group, a.bill_date,a.bill_amt,a.paid_amt from hms_bill_payment a,`hms_service_group` s where s.id=a.service_group_id and a.reserve_id='.$reserve_id;
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
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>