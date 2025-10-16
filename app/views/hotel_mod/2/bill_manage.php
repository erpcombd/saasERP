<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Bill Information (Last Reserve)';
do_calander('#paid_date');
$table='hms_bill_payment';
$unique='id';
$today=date("Y-m-d");
$r_id=$_REQUEST['r_id'];
$user_id=$_POST['user_id']=$_SESSION['user']['id'];

if($_REQUEST['check_out']==1)
{
$reserve_id=$_REQUEST['reserve_id'];
		$sql="update `hms_reservation` set checked_out='$now',check_out_by='$user_id' where id='$reserve_id'";
		mysql_query($sql);
		
		$sql="update hms_hotel_room_status set room_status=0 where date>='$today' and room_status=9 and  reserve_id='$reserve_id'";
		mysql_query($sql);
		
		$sql="update hms_hotel_room set status=2 where id in (select room_id from hms_hotel_room_status where reserve_id='$reserve_id')";
		mysql_query($sql);
		
		header("Location:hotel_status.php");
}

if($_REQUEST['billing']&&$_REQUEST['paid_amt']>0)
{
	$service_room_id=$_REQUEST['room_id'];
	$service_id=$_REQUEST['service_id'];
	$reserve_id=$_REQUEST['reserve_id'];

	$paid_date=$bill_date=date('Y-m-d');
	$paid_amt=$_REQUEST['paid_amt'];
	
	$service_group_id=find_a_field('hms_services','service_group_id',"id=".$service_id);
	$sql="INSERT INTO `hms_bill_payment` (
	`reserve_id` ,
	`room_id` ,
	`service_group_id` ,
	 optional_service_id ,
	`bill_amt` ,
	`bill_date` ,
	`paid_amt` ,
	`paid_date`
	) VALUES ('$reserve_id', '$service_room_id', '$service_group_id','$service_id',  '', '$bill_date','$paid_amt', '$paid_date')";
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
              <? 
			  $sql="SELECT a.id,concat(a.room_no,' : ',b.room_type) FROM `hms_hotel_room` a,`hms_room_type` b WHERE b.id=a.room_type_id and a.status=9 order by a.room_no";
			  advance_foreign_relation($sql,$r_id);?>
			  </select>
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

$sql="select a.* from hms_reservation a,hms_hotel_room_status b where b.room_id='".$r_id."' and b.reserve_id=a.id and b.room_status=9  order by id desc limit 1";
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
                        <td align="center" bgcolor="#0099FF"><strong>Service</strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>Paid Amt</strong></td>
                          <td  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">
						  <input name="billing" type="submit" id="billing" value="Confirm" tabindex="12" class="update"/>                       
						  </div>				        </td>
      </tr>
                      <tr>
                        <td align="center" bgcolor="#CCCCCC">
                          <span id="inst_no">
						 
<select name="service_id" id="service_id">
<?
$sql="SELECT a.id,a.service_name FROM `hms_services` a,`hms_service_group` b WHERE b.id in (4,5,8) and b.id=a.service_group_id";
advance_foreign_relation($sql);
?>
</select>
                        </span>
                        <input type="hidden" name="reserve_id" value="<?=$reserve_id?>" />
                        <input type="hidden" name="room_id" value="<?=$r_id?>"/></td>
						  
                          <td align="center" bgcolor="#CCCCCC">
<span id="inst_amt">
<input name="paid_amt" type="text" id="paid_amt"  tabindex="10" class="input3" style="width:100px;" /> 
</span>                        </td>
      </tr>
  </table>
					  <div align="center"><a href="bill_invoice_final.php?reserve_no=<?= $reserve_id;?>" target="_blank"><img src="../../images/print.png" width="30" height="30" border="0" /></a><br />
                      </div>
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
$res='select a.id, a.bill_date as date, s.service_group as Item_detail,(select service_name from hms_services where id=a.optional_service_id) as detail,a.total_amt as amount,a.service_charge as service, a.vat_amt as Vat, a.bill_amt as total,a.paid_amt as credit from hms_bill_payment a,`hms_service_group` s where s.id=a.service_group_id and a.reserve_id='.$reserve_id.' and a.bill_amt<>a.paid_amt order by a.id';
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
  </table><? }?>
  
<?
if($reserve_id>0){
$sql="SELECT sum(bill_amt)-sum(paid_amt) FROM `hms_bill_payment` WHERE 
reserve_id=".$reserve_id;
$due = find_a_field_sql($sql);
if($due==0){
?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>
        <div align="center">
		<form id="form1" name="form1" method="post" action="?reserve_id=<?=$reserve_id?>&check_out=1">
          <input type="submit" name="checkout" value="CHECKED OUT" style="width:250px; height:40px; font-size:24px" />
		</form>
        </div>
      </td>
    </tr>
  </table>

    <? }
else{?>
  <div align="center">
    <table width="1%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;<span class="style1">DUE: </span></td>
              <td>&nbsp;<input name="" type="text" value="<?=$due?>" style="width:250px; height:40px; font-size:18px;" /></td>
            </tr>
          </table>
    
  </div>
<? }}
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>