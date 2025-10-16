<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Bill Information';
do_calander('#bill_date');
$table='hms_bill_payment';
$unique='id';
$today=date("Y-m-d");
$r_id=$_REQUEST['r_id'];
if($_REQUEST['billing'])
{
	$service_room_id=$_REQUEST['room_id'];
	$service_id=$_REQUEST['service_id'];
	$reserve_id=$_REQUEST['reserve_id'];

	$bill_amt=$_REQUEST['bill_amt'];
	$unit_price=$_REQUEST['unit_price'];
	$qty=$_REQUEST['qty'];
	$bill_date=$_REQUEST['bill_date'];
	
	
	$sql="INSERT INTO `hms_bill_payment_details` (
	`reserve_id` ,
	`room_id` ,
	`service_id` ,
	`bill_amt` ,
	`detail` ,
	`bill_date` ,
	unit_price,
	qty
	) VALUES ('$reserve_id', '$service_room_id', '$service_id', '$bill_amt',  '$detail', '$bill_date', '$unit_price', '$qty')";
	mysql_query($sql);
}
?>
<script type="text/javascript">
function getunitprice()
{
	var a=document.getElementById('service_id').value;

			$.ajax({
		  url: '../../common/get_unit_price.php',
		  data: "a="+a,
		  success: function(data) {						
				$('#pid').html(data);	
			 }
		});
}
function billamt()
{
	var a=document.getElementById('unit_price').value;
	var b=document.getElementById('qty').value;
	var c=(a*1)*(b*1);
	document.getElementById('bill_amt').value=c;
			
}
</script><div class="form-container_large">
<form action="" method="post" name="form2" id="form2">
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>
			<fieldset>
			<legend>Bill Information</legend>
			<div>
			<label>Room No : </label>
<select name="r_id" id="r_id">
<option value="0">Guest</option>
              <? 
			  $sql="SELECT a.id,concat(a.room_no,' : ',b.room_type) FROM `hms_hotel_room` a,`hms_room_type` b WHERE b.id=a.room_type_id order by a.room_no";
			  advance_foreign_relation($sql,$r_id);?>
			  </select>
			</div>
			<div class="buttonrow" style="margin-left:154px;"><input name="submit" type="submit" class="btn1" value="Select Customer" /></div>
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

$sql="select a.* from hms_reservation a,hms_hotel_room_status b where b.room_id='".$r_id."' and b.reserve_id=a.id order by id desc limit 1";
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
			<input name="" type="text" id="" value="<?=$info->client_address?>" />
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
<div align="center">
  <table width="30%" height="35" border="0" cellpadding="0" cellspacing="0" bgcolor="#3399FF">
    <tr>
      <td width="50%"><div align="right"><strong>Date: </strong></div></td>
      <td width="50%">
<? 
if($_REQUEST['bill_date'])
$bill_date=$_REQUEST['bill_date'];
else
$bill_date=date('Y-m-d');
?>
<input name="bill_date" type="text" class="input3" value="<?=$bill_date?>" id="bill_date"  maxlength="100" style="width:80px;"/>
</td>
    </tr>
  </table>
</div>
<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                          
                      <tr>
                        <td align="center" bgcolor="#0099FF"><strong>Service Item </strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>Unit Price </strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>Qty</strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>Bill Amt </strong></td>
                        <td  rowspan="2" align="center" bgcolor="#FF0000">
                          <div class="button">
<input name="billing" type="submit" id="billing" value="ADD" tabindex = "12" class="update"/>
                          </div>
						</td>
      </tr>
                      <tr>
                        <td align="center" bgcolor="#CCCCCC">
                          <span id="inst_no">
                          <select name="service_id" id="service_id" onchange="getunitprice()">
						  <option></option>
								<?
$sql="SELECT a.id,a.service_name FROM `hms_services` a WHERE a.service_group_id=".$_SESSION['user']['id'];
advance_foreign_relation($sql,$data->service_id);
				?>
			</select>
                        </span>
                        <input type="hidden" name="reserve_id" value="<?=$reserve_id?>" />
                        <input type="hidden" name="room_id" value="<?=$r_id?>"/></td>
						  
                          <td bgcolor="#CCCCCC"><div align="center"><span id='pid'>
                          <input name="unit_price" type="text" class="input3" id="unit_price"  maxlength="100" style="width:70px;" onchange="billamt()"/>
                          </span></div></td>
                          <td bgcolor="#CCCCCC"><div align="center">
                            <input name="qty" type="text" class="input3" id="qty"  maxlength="50" style="width:60px;" onchange="billamt()"/>
                          </div></td>
                          <td bgcolor="#CCCCCC"> 
                            <div align="center"><span id="inst_date">                      
                            <input name="bill_amt" type="text" class="input3" id="bill_amt"  maxlength="100" style="width:100px;"/>
                            </span> </div></td>
      </tr>
    </table>
					  <br /><br /><br /><br />
</form>
<? }?>
<div class="box4">
<? if(isset($reserve_id)&&$reserve_id!='')
{
$res1='select b.bill_amt,b.paid_amt from hms_services a, hms_bill_payment b where a.service_group_id=b.service_id and b.reserve_id='.$reserve_id.' and  a.service_group_id='.$_SESSION['user']['id'];

$data=mysql_fetch_row(mysql_query($res1));
?>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td><div class="tabledesign2">
        <? 
$res='select a.id,b.service_name, a.bill_date,a.unit_price,a.qty,a.bill_amt from hms_bill_payment_details a, hms_services b,`hms_service_group` s where s.id=a.service_id and a.reserve_id='.$reserve_id.' and a.service_id=b.id and b.service_group_id='.$_SESSION['user']['id'].' order by id';
echo link_report($res);
		?>

      </div></td>
    </tr>
	<tr>
      <td><table width="75%" border="0" cellspacing="0" cellpadding="0" align="right">
        <tr>
          <td rowspan="5" ><div align="center"><span class="button">
<input name="billing2" type="submit" id="billing2" value="Confirm Paid" tabindex="12" class="update" style="width:200px"/>
          </span></div></td>
<td bgcolor="#FF9999" ><strong> Amount: </strong></td>
<td bgcolor="#FF9999" ><input name="bill_amount" type="text" id="bill_amount" value="<?=$bill_amount?>" /></td>
          </tr>
        <tr>
<td><strong>Vat (%):</strong></td>
<td><input name="name2" type="text" id="name2" value="<?=$data[1]?>" /></td>
        </tr>
        <tr>
<td><strong>Service Charge: </strong></td>
<td><input name="service_charge" type="text" id="service_charge" value="<?=$service_charge?>" /></td>
        </tr>
		<tr>
<td bgcolor="#FF3333"><strong>Total Amount: </strong></td>
<td bgcolor="#FF3333"><input name="name3" type="text" id="name3" value="<?=$data[1]?>" /></td>
		</tr>
        <tr>
<td bgcolor="#CC9900" ><strong>Total Paid: </strong></td>
<td bgcolor="#CC9900" ><input name="name4" type="text" id="name4" value="<?=$data[1]?>" /></td>
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
include ("../../template/main_layout_s.php");
?>