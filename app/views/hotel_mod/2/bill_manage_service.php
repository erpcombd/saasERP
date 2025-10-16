<?php
session_start();
ob_start();
require "../../support/inc.all.php";

$service_group_id=$_SESSION['user']['id'];
$group=find_all_field('hms_service_group','vat','id='.$service_group_id);
$vat=$group->vat;
$service_rate=$group->service_charge;
$title='Bill Create';
$today=date('Y-m-d');

do_calander('#bill_date');
if(isset($_POST['save']))
{
$count 			=$_REQUEST['count'];

$bill_date	=$_REQUEST['bill_date'];
$name=$_REQUEST['name'];
$contact_no=$_REQUEST['contact_no'];

if($_REQUEST['room_id']>0)
{
$room_id=$_REQUEST['room_id'];
$reserve_id=find_a_field('hms_hotel_room_status','reserve_id','room_id='.$room_id.' and room_status=9 order by id desc ');
}


$total_amt=$_REQUEST['total_amt'];
$vat_amt=$_REQUEST['vat_amt'];
$service_charge=$_REQUEST['service_charge'];
$bill_amt=$_REQUEST['payable_amt'];
$discount_amt=$_REQUEST['total_dis_amt'];
$paid_amt=$_REQUEST['paid_amt'];

$service_staff_id=$_REQUEST['service_staff_id'];
$service_point_id=$_REQUEST['service_point_id'];

if($paid_amt==$bill_amt) $paid_date=$bill_date;
$sql="INSERT INTO `hms_bill_payment` (
`name` ,
`contact_no` ,
`reserve_id` ,
`room_id` ,
`service_group_id` ,
`total_amt` ,
`paid_amt` ,
`detail` ,
`bill_date` ,
`discount_amt` ,
`vat_amt` ,
`bill_amt` ,
`service_charge` ,
`paid_date` ,
`service_staff_id` ,
`service_point_id`
) VALUES ('$name', '$contact_no', '$reserve_id', '$room_id', '$service_group_id', '$total_amt', '$paid_amt', '$detail', '$bill_date','$discount_amt','$vat_amt','$bill_amt', '$service_charge', '$paid_date','$service_staff_id','$service_point_id')";
mysql_query($sql);

$bill_no	=mysql_insert_id();
for($j=1; $j <= $count; $j++)  //data insert loop
	{
		if($_REQUEST['deleted'.$j] == 'no')
		{
			$service_id 	= $_REQUEST['service_id'.$j];		
			$unit_price		= $_REQUEST['unit_price'.$j];	
			$qty			= $_REQUEST['qty'.$j];
			$dis_amt 		= $_REQUEST['dis_amt'.$j];		
			$bill_amt		= $_REQUEST['bill_amt'.$j];
		
		$sql="INSERT INTO `hms_bill_payment_details` (
		`bill_no`,
		`reserve_id` ,
		`room_id` ,
		`service_id` ,
		`bill_amt` ,
		`bill_date` ,
		unit_price,
		discount_amt,
		qty
		) VALUES ('$bill_no', '$reserve_id', '$room_id', '$service_id', '$bill_amt', '$bill_date', '$unit_price','$dis_amt', '$qty')";
		mysql_query($sql);
		}
}

$now=time();
}
?>


<style>
.datagtable
{
	border-bottom:1px solid #CCC;
}
.datagtable td
{
	border-left:1px solid #CCC;
}
.datagtable input
{
	border:0;	
}

.deleted, .deleted input
{
	background:#F00;
	color:#FFF;
}
img
{
border:0px;
}
</style>
<script type="text/javascript">
function check()
{

	if (((document.getElementById('bill_amt').value)*1)<1) 
	{
		alert('Bill Is not Possible.');
		return false;
	}
	else
	{	

	var service_id=((document.getElementById('service_id').value)*1);
	var unit_price=((document.getElementById('unit_price').value)*1);
	var qty=((document.getElementById('qty').value)*1);
	var dis_amt=((document.getElementById('dis_amt').value)*1);
	var bill_amt=((document.getElementById('bill_amt').value)*1);
	var bill_date=((document.getElementById('bill_date').value)*1);
	var count=((document.getElementById('count').value)*1);
	
		$.ajax({
		  url: '../../common/bill_manage_rent.php',
		  data: "unit_price="+unit_price+"&qty="+qty+"&dis_amt="+dis_amt+"&bill_amt="+bill_amt+"&service_id="+service_id+"&bill_date="+bill_date+"&count="+count,
		  success: function(data) {						
				$('#tbl').append(data);	
			 }
		});

document.getElementById("total_amt").value = ((document.getElementById("total_amt").value)*1)+((document.getElementById("bill_amt").value)*1);

service_charge_cal();
sub_total_cal();
vat_cal();
total_cal();
	$('#desc').val('');
	$('#unit_price').val('');
	$('#qty').val('');
	$('#dis_amt').val('');
	$('#bill_amt').val('');

	document.getElementById("count").value = ((document.getElementById("count").value)*1)+1;
	}
return true;
}
function getunitprice()
{
	var a=document.getElementById('service_id').value;
			$.ajax({
		  url: '../../common/get_unit_price.php',
		  data: "a="+a,
		  success: function(data) {						
				$('#pid').html(data);
				document.getElementById('dis_amt').value=document.getElementById('temp_dis').value;	
			 }
		});


}
function do_discount()
{
document.getElementById('dis_amt').value=document.getElementById('temp_dis').value;
}
function getroomprice()
{
	var a=document.getElementById('service_id').value;
			$.ajax({
		  url: '../../common/get_room_price.php',
		  data: "a="+a,
		  success: function(data) {						
				$('#pid').html(data);	
			 }
		});
}
function billamt()
{

	var unit_price=((document.getElementById('unit_price').value)*1);
	var qty=((document.getElementById('qty').value)*1);
	var dis_amt=((document.getElementById('dis_amt').value)*1);
	var bill_amt=(unit_price-dis_amt)*qty;
	document.getElementById('bill_amt').value=bill_amt;
}
function service_charge_cal()
{
	var total_amt=((document.getElementById('total_amt').value)*1);
	var service=((document.getElementById('service_rate').value)*1);

	var service_amt=(service/100)*total_amt;
	document.getElementById('service_charge').value=service_amt;
}
function sub_total_cal()
{
	var total_amt=((document.getElementById('total_amt').value)*1);
	var service_charge=((document.getElementById('service_charge').value)*1);
	var sub_total=(total_amt+service_charge);

	document.getElementById('sub_total').value=sub_total;
}
function vat_cal()
{
	var total_amt=((document.getElementById('sub_total').value)*1);
	var vat=((document.getElementById('vat').value)*1);

	var vat_amt=(vat/100)*total_amt;
	document.getElementById('vat_amt').value=vat_amt;
}
function total_cal()
{
	
	var sub_total=((document.getElementById('sub_total').value)*1);
	var vat_amt=((document.getElementById('vat_amt').value)*1);
	var total_dis_amt=((document.getElementById('total_dis_amt').value)*1);

	var payable_amt=(sub_total+vat_amt-total_dis_amt);
	document.getElementById('payable_amt').value=payable_amt;
}
</script>
 <div class="form-container">
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td valign="top">
						<fieldset style="width:275px">
						<legend>Customer Info</legend>
						<div>
						<label>Name : </label>
						<input  name="name" type="text" id="name" value="" style="width:150px"/>
						</div>
						<div>
						<label>Contact No: </label>
						<input  name="contact_no" type="text" id="contact_no" value="" style="width:150px"/>
						</div>
						<div>
						<label>Holding Room: </label>
						<select name="room_id" id="room_id">
						<option value="0">Guest</option>
                          <? 
			  $sql="SELECT a.id,concat(a.room_no,' : ',b.room_type) FROM `hms_hotel_room` a,`hms_room_type` b WHERE b.id=a.room_type_id and a.status=9 order by a.room_no";
			  advance_foreign_relation($sql,$room_id);?>
                        </select>
						</div>
						</fieldset>

						<fieldset style="width:275px">
						<legend>Bill Details</legend>
						<div>
						<label>Bill No : </label>
						<input  name="bill_no" type="text" id="bill_no" readonly value="<?=next_value('id','hms_bill_payment')?>"/>
						</div>
						<div>
						<label for="email">Bill Date :  </label>
						<input  name="bill_date" type="text" id="bill_date" value="<?=date('Y-m-d')?>"/>
						</div>
                        <div>
						<label for="email">Service Point : </label>
						<select name="service_point_id" id="service_point_id" style="width:100px">
						  <option value="0">Select One</option>
						  <? 
			  $sql="SELECT a.id,a.point_name FROM `hms_service_point` a WHERE a.service_group_id=".$_SESSION['user']['id'];
			  advance_foreign_relation($sql);?>
						  </select>
                        </div>
                        <div>
						<label for="email">Service Provider :  </label>
						<select name="service_staff_id" id="service_staff_id" style="width:100px">
						  <option value="0">Select One</option>
						  <? 
			  $sql="SELECT a.id,a.staff_name FROM `hms_service_staff` a WHERE a.service_group_id=".$_SESSION['user']['id'];
			  advance_foreign_relation($sql);?>
						  </select>
                        </div>
						</fieldset>					  </td>
                      <td valign="top">
						
					  <br /></td>
                      <td valign="top">
					  <div class="tabledesign1" style="height:197px; width:440px">
						                               <table cellspacing="0" cellpadding="0" width="440px">
                                <tr>
                                  <th>Last 10 Bill No</th>
                                  <th>Customer</th>
                                  <th>Bill Amt </th>
								  
                                  <th>Paid Amt </th>
                                  <th>Print</th>
                                </tr> <?

$sql1="select id,name,bill_amt,paid_amt from hms_bill_payment where service_group_id='$service_group_id' order by id desc limit 9";
$query1=mysql_query($sql1);
if(mysql_num_rows($query1)>0)
{
while($payable=mysql_fetch_row($query1)){
						  ?>
                               
                                <tr class="alt">
                                  <td><?=$payable[0]?></td>
                                  <td><?=$payable[1]?></td>
                                  <td><?=$payable[2]?></td>
                                  <td><?=$payable[3]?></td>
                                  <td><a href="bill_invoice.php?bill_no=<?= $payable[0];?>" target="_blank"><img src="../../images/print.png" width="16" height="16" border="0"></a></td>
                                </tr>

							 <? }}?>
                              </table>
                          </div>					  </td>
                    </tr>
                    <tr>
                      <td valign="top">					  					  </td>
                      <td valign="top">					  					  </td>
                      <td valign="top">					  					  </td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>  
				  <table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                      <tr>
                        <td align="center">Item/Service Name </td>
                          <td align="center">Unit Price </td>
                          <td align="center">Qty</td>
                          <td align="center">Discount Amt </td>
                          <td align="center">Amount</td>
                          <td  rowspan="2" align="center">
						  <div class="button">
						  <input name="add" type="button" id="add" value="ADD" tabindex="12" class="update" onclick="check();"/>                       
						  </div>					      </td>
                        </tr>
                      <tr>
                        <td align="center">
<?
$sql="SELECT a.id,a.service_name FROM `hms_services` a WHERE a.service_group_id=".$_SESSION['user']['id'];
?>
<select name="service_id" id="service_id" onchange="getunitprice()" style="width:225px;">
<option></option>
<?
$res=mysql_query($sql);
while($data=mysql_fetch_row($res))
{
echo '<option value="'.$data[0].'">'.$data[1].'</option>';
}
?>
</select><input name="temp_dis" type="hidden" class="input3" id="temp_dis" readonly value=""/>
	  					  </td>
                          <td align="center">
                            <span id="pid">
<input name="unit_price" type="text" class="input3" id="unit_price"  maxlength="100" style="width:95px;text-align:right;" onchange="billamt()"/>
                          </span>						</td>
						  
                          <td><input name="qty" type="text" class="input3" id="qty"  maxlength="50" style="width:95px;text-align:right;" onchange="billamt()"/></td>

                          <td align="center">
<span id="inst_amt">
<input name="dis_amt" type="text" id="dis_amt"  tabindex="10" class="input3" style="width:95px;text-align:right;"  onchange="billamt()"/> 
</span>                          </td>
						 
						  
                          <td align="center"><input name="bill_amt" type="text" class="input3" id="bill_amt"  maxlength="100" style="width:95px;text-align:right;" readonly/></td>
                        </tr>
                      <tr>
                        <td colspan="6" align="left">
<span id="tbl">
</span> </td>
                        </tr>
                    </table></td>
                </tr>
                <tr>
                  <td><table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="2" rowspan="7"><table width="2%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td><div class="button">
                                <div align="center">
                                  <input name="count" id="count" type="hidden" value="<? if(isset($count)&&$count>0) echo $count;?>" />
                                  <input name="save" type="submit" id="save" value="Confirm" onclick="check_ability()" style="width:160px; height:50"/>
                                </div>
                            </div>
                               </td>
                          </tr>
                      </table></td>
                      <td><strong>Amount : </strong></td>
                      <td width="1%"><input name="total_amt" type="text" id="total_amt"  tabindex="10" class="input3" style="width:100px;text-align:right;" readonly="readonly" /></td>
                    </tr>
                    <tr>
                      <td bgcolor="#669966"><strong>Service Charge (
                        <?=$service_rate?>
                        %)  : </strong></td>
                      <td bgcolor="#663366"><input name="service_rate" type="hidden" id="service_rate"  tabindex="10" class="input3" style="width:100px;" readonly="readonly" value="<?=$service_rate?>" />
                          <input name="service_charge" type="text" id="service_charge"  tabindex="10" class="input3" style="width:100px;text-align:right;" onchange="total_cal()" /></td>
                    </tr>
                    <tr>
                      <td bgcolor="#333399"><strong>Sub Total : </strong></td>
                      <td bgcolor="#333399"><input name="sub_total" type="text" class="input3 " id="sub_total" style="width:100px;text-align:right;"  tabindex="10" onchange="total_cal()" /></td>
                    </tr>
                    <tr>
                      <td bgcolor="#FF6699"><strong>Vat (
                        <?=$vat?>
                        %) : </strong></td>
                      <td bgcolor="#FF6699"><input name="vat_amt" type="text" id="vat_amt"  tabindex="10" class="input3" style="width:100px;text-align:right;" readonly="readonly" />
                          <input name="vat" type="hidden" id="vat"  tabindex="10" class="input3" style="width:100px;" readonly="readonly" value="<?=$vat?>" />
                      </td>
                    </tr>
                    <tr>
                      <td bgcolor="#CC6600"><strong>Discount : </strong></td>
                      <td bgcolor="#CC6600"><input name="total_dis_amt" type="text" id="total_dis_amt"  tabindex="10" class="input3" style="width:100px;text-align:right;" onchange="total_cal()"/></td>
                    </tr>
                    <tr>
                      <td bgcolor="#000000"><strong>Payable Amount : </strong></td>
                      <td><input name="payable_amt" type="text" id="payable_amt"  tabindex="10" class="input3" style="width:100px;text-align:right;" readonly="readonly" /></td>
                    </tr>
                    <tr>
                      <td bgcolor="#FF3300"><strong>Paid Amount : </strong></td>
                      <td bgcolor="#FF3300"><input name="paid_amt" type="text" id="paid_amt"  tabindex="10" class="input3" style="width:100px;text-align:right;" /></td>
                    </tr>
                  </table></td>
                </tr>
                
            </table></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
</div>
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout_s.php");
?>
