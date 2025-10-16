<?php
session_start();
require "../../support/inc.all.php";

$table		= 'hms_reservation';
$crud      	= new crud($table);
			
$user_id=$_POST['user_id']=$_SESSION['user']['id'];
$reserve_id=$_REQUEST['reserve_id'];


if($_REQUEST['reserve']=='cancel')
{
$sql="delete from hms_hotel_room_status where reserve_id='$reserve_id'";
	mysql_query($sql);
}


if($_REQUEST['adult'])
{
	$a_name=$_REQUEST['a_name'];
	$a_age=$_REQUEST['a_age'];
	$a_relation=$_REQUEST['a_relation'];
	$a_id_info=$_REQUEST['a_id_info'];
	$sql="INSERT INTO `hms_adults`  (`reserve_id`,  `name`,    `age`,    `relation`,    `id_info`) VALUES 
									('$reserve_id', '$a_name', '$a_age', '$a_relation', '$a_id_info')";
	mysql_query($sql);
}

if($_REQUEST['del_adult'])
{
	$adult_id=$_REQUEST['adult_id'];
	$reserve_id=$_REQUEST['reserve_id'];
	$sql="delete from hms_adults where reserve_id='$reserve_id' and id='$adult_id'";
	mysql_query($sql);
}

if($_REQUEST['del_room'])
{
	$room_id=$_REQUEST['id'];
	$room_id=$_REQUEST['room_id'];
	$reserve_id=$_REQUEST['reserve_id'];
	$sql="delete from hms_hotel_room_status where room_id='$room_id' and reserve_id='$reserve_id'";
	mysql_query($sql);
}


if($_REQUEST['billing'])
{
	$service_room_id=$_REQUEST['service_room_no'];
	$service_id=$_REQUEST['service_id'];
	$reserve_id=$_REQUEST['reserve_id'];

	$bill_amt=$_REQUEST['bill_amt'];
	$paid_amt=$_REQUEST['paid_amt'];
	$detail=$_REQUEST['detail'];
	$bill_date=$_REQUEST['bill_date'];
	$paid_date=$_REQUEST['paid_date'];
	
	 $sql="INSERT INTO `hms_bill_payment_details` (
	`reserve_id` ,
	`room_id` ,
	`service_id` ,
	`bill_amt` ,
	`paid_amt` ,
	`detail` ,
	`bill_date` ,
	`paid_date`
	) VALUES ('$reserve_id', '$service_room_id', '$service_id', '$bill_amt', '$paid_amt', '$detail', '$bill_date', '$paid_date')";
	mysql_query($sql);
	$service_group_id = find_a_field('hms_services','service_group_id'," id ='".$service_id."'");
	 $sql="INSERT INTO `hms_bill_payment` (
	`reserve_id` ,
	`room_id` ,
	`service_id` ,
	`bill_amt` ,
	`paid_amt` ,
	`detail` ,
	`bill_date` ,
	`paid_date`
	) VALUES ('$reserve_id', '$service_room_id', '$service_group_id', '$bill_amt', '$paid_amt', '$detail', '$bill_date', '$paid_date')";
	mysql_query($sql);
}


if($_REQUEST['billing_edit'])
{
	$service_room_id=$_REQUEST['service_room_no'];
	$service_id=$_REQUEST['service_id'];
	$reserve_id=$_REQUEST['reserve_id'];
	
	$bill_id=$_REQUEST['bill_id'];
	$bill_amt=$_REQUEST['bill_amt'];
	$paid_amt=$_REQUEST['paid_amt'];
	$detail=$_REQUEST['detail'];
	$bill_date=$_REQUEST['bill_date'];
	$paid_date=$_REQUEST['paid_date'];
	
	 $sql="update `hms_bill_payment` set 
	 service_id='$service_id', 
	 bill_date='$bill_date',
	 paid_date='$paid_date', 
	 bill_amt='$bill_amt', 
	 paid_amt='$paid_amt', 
	 detail='$detail'
	 where id='$bill_id'";
	mysql_query($sql);
}



?>
<link href="../../css/style.css" type="text/css" rel="stylesheet"/>
<link href="../../css/pagination.css" rel="stylesheet" type="text/css" />
<link href="../../css/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />
<meta name="Developer" content="Md. Mhafuzur Rahman Cell:01815-224424 email:mhafuz@yahoo.com" />
<link href="../../css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../../js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="../../js/jquery.validate.js"></script>
<script type="text/javascript" src="../../js/paging.js"></script>
<script type="text/javascript" src="../../js/ddaccordion.js"></script>
<script type="text/javascript" src="../../js/js.js"></script>
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
	
			$start_date = $check_in;
					// End date
			$end_date = $check_out;
			
			while (strtotime($start_date) <= strtotime($end_date)) {
			$sql="INSERT INTO `hms_hotel_room_status` 
(`room_id` ,
`room_status` ,
`date` ,
`status_date` ,
`reserve_id` ,
`user_id`)
VALUES ('$room_no', '1', '$start_date', '$today', '$reserve_id', '$user_id')";
mysql_query($sql);
				$start_date = date ("Y-m-d", strtotime("+1 day", strtotime($start_date)));
			}
}


if(isset($_POST['client']))
{
			
			$_POST['create_on'] = $today;
			$_POST['user_id']	= $_SESSION['user']['id'];
			
	if($reserve_id>0)
	{
			$_POST['id'] = $reserve_id;
			$crud->update('id');
	}
	else
	{
			$reserve_id = $crud->insert();
	}
}

if($reserve_id>0)
{
		$condition="id=".$reserve_id;
		$data=db_fetch_object('hms_reservation',$condition);
		while (list($key, $value)=each($data))
		{ $$key=$value;}
}
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top">
	
	<form name="check" action="reservation_info.php?reserve_id=<?=$reserve_id?>" method="post" enctype="multipart/form-data">
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
        <td align="left" style="padding:3px;"><textarea name="client_address" cols="20" id="client_address"><?=$client_address?></textarea></td>
      </tr>
      <tr>
        <td align="right" style="padding:3px;">Member ID : </td>
        <td align="left" style="padding:3px;"><input name="client_id" type="text" id="client_id" value="<?=$client_id?>" size="20" /></td>
      </tr>
      <tr bgcolor="#f8fbc1">
        <td align="right" style="padding:3px;">Status  : </td>
        <td align="left" style="padding:3px;">
		<select name="status" id="status">
		<option <? if($status=='Not Confirm') echo 'Selected';?>>Not Confirm</option>
		<option <? if($status=='Confirm') echo 'Selected';?>>Confirm</option>
        </select></td>
      </tr>
      <tr>
        <td align="right" style="padding:3px;">Check In : </td>
        <td align="left" style="padding:3px;"><input name="check_in_date" type="text" id="check_in_date" value="<?=$check_in_date?>" size="10" /></td>
      </tr>
      <tr bgcolor="#f8fbc1">
        <td align="right" style="padding:3px;"><span style="padding:3px;">Check Out :</span></td>
        <td align="left" style="padding:3px;"><input name="check_out_date" type="text" id="check_out_date" value="<?=$check_out_date?>" size="10" /></td>
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
    </table><br>
	<?
	if($reserve_id>0){
	?>
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
	$query=mysql_query($sql);
	while($data=mysql_fetch_row($query)){
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
        <td align="left"><div align="center"><a href="reservation_info.php?id=<?=$room_id?>&amp;date=<?=$date?>&amp;del_adult=1&amp;adult_id=<?=$data[0]?>&amp;reserve_id=<?=$reserve_id?>"><img src="../../images/del.png" width="16" height="16" /></a></div></td>
      </tr>
      <? }?>
    </table>
	
	<?
	}
	?>
	</form>
	</td>
    <td valign="top">
	<?
	if($reserve_id>0){
	?>
	<form name="room" action="reservation_info.php?reserve_id=<?=$reserve_id?>" method="post" enctype="multipart/form-data">
      <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
        <tr bgcolor="#679435">
          <td colspan="3" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Room Reservation  </td>
        </tr>
        
        <tr bgcolor="#f8fbc1">
          <td align="right" style="padding:3px;">Check IN: </td>
          <td align="left" style="padding:3px;"><input name="check_in" type="text" id="check_in" value="<?=$check_in_date?>" size="10" /></td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="right" style="padding:3px;">Check OUT: </td>
          <td align="left" style="padding:3px;"><input name="check_out" type="text" id="check_out" value="<?=$check_out_date?>" size="10" /></td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr bgcolor="#f8fbc1">
          <td width="25%" align="right" style="padding:3px;">Add Room : </td>
          <td width="50%" align="left" style="padding:3px;"><select name="room_no" id="room_no">
              <? 
			  $sql="SELECT a.id,concat(a.room_no,' : ',b.room_type) FROM `hms_hotel_room` a,`hms_room_type` b WHERE b.id=a.room_type_id and a.id not in (select room_id from `hms_hotel_room_status` where room_status>0 and date='$check_in_date')";
			  advance_foreign_relation($sql);?>
            </select>&nbsp;</td>
          <td width="25%" align="center"><span class="blue">
            <input name="room_add" type="submit" id="room_add" value="ADD" />
          </span></td>
        </tr>
      </table><br>
      <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
        <tr bgcolor="#679435">
          <td width="25%" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Room ID </td>
          <td width="25%" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Room Type </td>
          <td width="25%" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Check IN </td>
          <td width="25%" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Check OUT </td>
          <td width="25%" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Reject</td>
        </tr>
<? $sql="select distinct b.id,b.room_no, c.room_type ,(select min(date) from hms_hotel_room_status where a.room_id=room_id and reserve_id=$reserve_id),(select max(date) from hms_hotel_room_status where a.room_id=room_id and reserve_id=$reserve_id) from hms_hotel_room_status a,hms_hotel_room b,hms_room_type c where a.reserve_id=$reserve_id and a.room_id=b.id and b.room_type_id=c.id";
	$query=mysql_query($sql);
	while($data=mysql_fetch_row($query)){
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
          <td align="left"><div align="center"><a href="reservation_info.php?id=<?=$room_id?>&date=<?=$date?>&del_room=1&room_id=<?=$data[0]?>&reserve_id=<?=$reserve_id?>"><img src="../../images/del.png" width="16" height="16" /></a></div></td>
        </tr>
<? }?>  
      </table>
	  </form>
	  
	  <form action="reservation_info.php?reserve_id=<?=$reserve_id?>" method="post" enctype="multipart/form-data" name="account" id="account">
	  <? if($_REQUEST['b_edit']==1){
	  $bill_id=$_REQUEST['bill_id'];
	  $sql="select * from hms_bill_payment where id='$bill_id'";
	  $query=@mysql_query($sql);
	  $data=@mysql_fetch_object($query);
	  ?>
        <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
          <tr bgcolor="#679435">
            <td colspan="4" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Bill and Payment </td>
          </tr>
          <tr>
            <td width="25%" align="right" style="padding:3px;">Service : </td>
            <td width="25%" align="left" style="padding:3px;">
			
			<select name="service_id" id="service_id">
								<?
			$sql="SELECT a.id,a.service_name FROM `hms_services` a WHERE a.service_name like '%Advance%' limit 1";
			 advance_foreign_relation($sql,$data->service_id);
				?>
			</select>
			<label>
			<input type="hidden" name="bill_id" value="<?=$data->id?>" />
			</label></td>
            <td width="25%" align="right"> Room No : </td>
            <td width="25%" align="left" style="padding:3px;">
			
              <select name="service_room_no" id="service_room_no">
              <? 
			  $sql="SELECT distinct a.id,concat(a.room_no,' : ',b.room_type) FROM `hms_hotel_room` a,`hms_room_type` b, hms_hotel_room_status c WHERE b.id=a.room_type_id and a.id in (select room_id from `hms_hotel_room_status` where reserve_id='$reserve_id')";
			  advance_foreign_relation($sql);
			  ?>
              </select>		  </td>
          </tr>
          <tr>
            <td width="25%" align="right" style="padding:3px;">Paid Amt : </td>
            <td width="25%" align="left" style="padding:3px;"><input name="paid_amt" value="<?=$data->paid_amt?>" type="text" id="paid_amt" size="10" /></td>
            <td width="25%" align="right" style="padding:3px;">Paid Date  :</td>
            <td width="25%" align="left" style="padding:3px;"><input name="paid_date" value="<?=$data->paid_date?>" type="text" id="paid_date" size="10" />            </td>
          </tr>
          <tr bgcolor="#f8fbc1">
            <td align="right" style="padding:3px;">Detail : </td>
            <td colspan="2" align="left" style="padding:3px;"><input value="<?=$data->detail?>" name="detail2" type="text" id="detail2" size="35" /></td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr bgcolor="#f8fbc1">
            <td colspan="4" align="right" style="padding:3px;"><div align="center">
              <table width="75%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div align="center"><span class="blue">
                      <input name="billing_edit" type="submit" id="billing_edit" value="Update" />
                    </span></div>
                    <div align="center"></div>                      <div align="center"></div></td>
                  </tr>
                </table>
            </div></td>
          </tr>
        </table>
		<? } else {?>
		<table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
          <tr bgcolor="#679435">
            <td colspan="4" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Bill and Payment </td>
          </tr>
          <tr>
            <td width="25%" align="right" style="padding:3px;">Service : </td>
            <td width="25%" align="left" style="padding:3px;">
			
			<select name="service_id" id="service_id">
				<?
			$sql="SELECT a.id,a.service_name FROM `hms_services` a WHERE a.service_name like '%Advance%' limit 1";
			 advance_foreign_relation($sql);
				?>
			</select>
			<label>
			<input type="hidden" name="bill_id" value="" />
			</label></td>
            <td width="25%" align="right"> Room No : </td>
            <td width="25%" align="left" style="padding:3px;">
			
              <select name="service_room_no" id="service_room_no">
              <? 
			  $sql="SELECT distinct a.id,concat(a.room_no,' : ',b.room_type) FROM `hms_hotel_room` a,`hms_room_type` b, hms_hotel_room_status c WHERE b.id=a.room_type_id and a.id in (select room_id from `hms_hotel_room_status` where reserve_id='$reserve_id')";
			  advance_foreign_relation($sql);
			  ?>
              </select>		  </td>
          </tr>
          <tr bgcolor="#f8fbc1">
            <td width="25%" align="right" style="padding:3px;">Bill Amt  : </td>
            <td width="25%" align="left" style="padding:3px;"><input name="bill_amt" type="text" id="bill_amt" size="10" /></td>
            <td width="25%" align="right" style="padding:3px;">Bill Date  :</td>
            <td width="25%" align="left" style="padding:3px;"><input name="bill_date" type="text" id="bill_date" size="10" /></td>
          </tr>
          <tr>
            <td width="25%" align="right" style="padding:3px;">Paid Amt : </td>
            <td width="25%" align="left" style="padding:3px;"><input name="paid_amt" type="text" id="paid_amt" size="10" /></td>
            <td width="25%" align="right" style="padding:3px;">Paid Date  :</td>
            <td width="25%" align="left" style="padding:3px;">              <input name="paid_date" type="text" id="paid_date" size="10" />            </td>
          </tr>
          <tr bgcolor="#f8fbc1">
            <td width="25%" align="right" style="padding:3px;">Detail : </td>
            <td colspan="2" align="left" style="padding:3px;"><input name="detail" type="text" id="detail" value="" size="35" /></td>
            <td align="center"><span class="blue">
              <input name="billing" type="submit" id="billing" value="Submit" />
            </span></td>
          </tr>
        </table>
		<? }?>
		<br />
	    <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
          <tr bgcolor="#679435">
            <td align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Date </td>
            <td align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Room No </td>
            <td align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Service</td>
            <td align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Bill</td>
            <td align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Paid </td>
            <td align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Edit</td>
          </tr>
		  <?
		  $sql="select a.*,b.room_no,c.service_name from `hms_bill_payment` a,hms_hotel_room b, hms_services c where a.reserve_id='$reserve_id' and a.room_id=b.id and c.id=a.service_id";
		  $query=@mysql_query($sql);
		  $i=1;
		  while($data=@mysql_fetch_object($query))
		  { $i++;?>

          <tr <? if($i%2) echo 'bgcolor="#f8fbc1"';?>>
            <td width="25%" align="right" style="padding:3px;"><div align="center">
              <?=$data->bill_date?>
            </div></td>
            <td width="25%" align="left" style="padding:3px;"><div align="center">
              <?=$data->room_no?>
            </div></td>
            <td width="25%" align="left" style="padding:3px;"><div align="center">
              <?=$data->service_name?>
            </div></td>
            <td width="25%" align="left" style="padding:3px;"><div align="center">
              <?=$data->bill_amt?>
            </div></td>
            <td width="25%" align="left" style="padding:3px;"><div align="center">
              <?=$data->paid_amt?>
            </div></td>
            <td width="25%" align="left" style="padding:3px;"><div align="center"><a href="reservation_info.php?id=<?=$room_id?>&amp;bill_id=<?=$data->id?>&amp;b_edit=1&amp;reserve_id=<?=$reserve_id?>"><img src="../../images/edit.jpg" width="20" height="20" /></a></div></td>
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

if($status_room==1){
?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><label>
        <div align="center">
		<form id="form1" name="form1" method="post" action="check_in_info.php?reserve_id=<?=$reserve_id?>&check_in=1">
          <input type="submit" name="checkin" value="CHECKED IN" style="width:250px; height:40px; font-size:24px" />
		</form>
          </div>
      </label></td>
      <td><div align="center"></div></td>
      <td><label>
        <div align="center">
		<form id="form1" name="form1" method="post" action="?reserve_id=<?=$reserve_id?>&reserve=cancel">
          <input type="submit" name="cancel_r" value="CANCEL RESERVE" style="width:250px; height:40px; font-size:24px" />
		</form>
          </div>
      </label></td>
    </tr>
  </table>
<? }?>
