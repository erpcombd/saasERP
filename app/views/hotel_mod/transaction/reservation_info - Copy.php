<?php
require_once "../../../assets/template/layout.top.php";

$date=$_REQUEST['date'];
$id=$room_id=$_REQUEST['id'];
$user_id=$_POST['user_id']=$_SESSION['user']['id'];
$reserve_id=$_REQUEST['reserve_id'];

if($_REQUEST['del'])
{
	$room_id=$_REQUEST['room_id'];
}

if($reserve_id>0)
{
	$sql="select r.id,f.floor_name,t.room_type,r.room_no,t.rate,t.vat from hms_hotel_room r, hms_hotel_floor f, hms_room_type t where r.floor_id=f.id and r.room_type_id=t.id and r.id='".$id."' limit 1";
	$query=mysql_query($sql);
	
	if(mysql_num_rows($query)>0)
	$data=mysql_fetch_row($query);
	
	$status_all = find_all_field('hms_hotel_room_status','room_status',"room_id='".$data[0]."' and date='".$date."'");
	$status = $status_all->room_status;
	
	if($status==1)// reserve
	{
	$room_status='Reserved';
	$reserve_id = $status_all->reserve_id;
	}
	
}
else // free
{
$room_status='Free';
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
$date=$_REQUEST['date'];
$id=$_REQUEST['id'];

do_calander('#pay_date');
do_calander('#check_in_date');
do_calander('#check_out_date');
do_calander('#last_reserve_date');
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
	if($room_status!='Reserved')
	{
		$table		='hms_reservation';
		$crud      	=new crud($table);
		$_POST['create_on']=$today;
		$_POST['user_id']=$_SESSION['user']['id'];
		$reserve_id = $crud->insert();
		
							// Start date
							
			$start_date = $_POST['check_in_date'];
					// End date
			$end_date = $_POST['check_out_date'];
			
			while (strtotime($start_date) <= strtotime($end_date)) {
			$sql="INSERT INTO `hms_hotel_room_status` 
(`room_id` ,
`room_status` ,
`date` ,
`status_date` ,
`reserve_id` ,
`user_id`)
VALUES ('$room_id', '1', '$start_date', '$today', '$reserve_id', '$user_id')";
mysql_query($sql);
				$start_date = date ("Y-m-d", strtotime("+1 day", strtotime($start_date)));
			}
$status=1;
$room_status='Reserved';
	}
	else
	{
			$table		= 'hms_reservation';
			$crud      	= new crud($table);
			$_POST['create_on'] = $today;
			$_POST['user_id']	= $_SESSION['user']['id'];
			$_POST['id'] = $reserve_id;
			$crud->update('id');
	}
}

if($status==1)
{
		$condition="id=".$reserve_id;
		$data=db_fetch_object('hms_reservation',$condition);
		while (list($key, $value)=each($data))
		{ $$key=$value;}
}
//echo "select room_id from `hms_hotel_room_status` where room_status<1 and date='$check_in_date')";
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
        <td width="39%" align="right" style="padding:5px;">Client Name : </td>
        <td width="61%" align="left"><input name="client_name" type="text" id="client_name" value="<?=$client_name?>" size="20" />          
          &nbsp;</td>
      </tr>
      <tr>
        <td align="right" style="padding:5px;">Mobile No : </td>
        <td align="left"><input name="contact_no" type="text" id="contact_no" value="<?=$contact_no?>" size="20" /></td>
      </tr>
      <tr bgcolor="#f8fbc1">
        <td style="padding:5px;" align="right">Address  : </td>
        <td align="left"><textarea name="client_address" cols="20" id="client_address"><?=$client_address?>
        </textarea></td>
      </tr>
      <tr>
        <td align="right" style="padding:5px;">Member ID : </td>
        <td align="left"><input name="client_id" type="text" id="client_id" value="<?=$client_id?>" size="20" /></td>
      </tr>
      <tr bgcolor="#f8fbc1">
        <td align="right" style="padding:5px;">Status  : </td>
        <td align="left">
		<select name="status" id="status">
		<option <? if($status=='Not Confirm') echo 'Selected';?>>Not Confirm</option>
		<option <? if($status=='Confirm') echo 'Selected';?>>Confirm</option>
        </select></td>
      </tr>
      <tr>
        <td align="right" style="padding:5px;">Check In: </td>
        <td align="left" style="padding:5px;"><input name="check_in_date" type="text" id="check_in_date" value="<?=$check_in_date?>" size="10" /></td>
      </tr>
      <tr bgcolor="#f8fbc1">
        <td align="right"><span style="padding:5px;">Check Out:</span></td>
        <td align="left"><input name="check_out_date" type="text" id="check_out_date" value="<?=$check_out_date?>" size="10" /></td>
      </tr>
      <tr>
        <td align="right" style="padding:5px;">Conformation Date :</td>
        <td align="left" style="padding:5px;"><input name="last_reserve_date" type="text" id="last_reserve_date" value="<?=$last_reserve_date?>" size="10" /></td>
      </tr>
      <tr>
        <td colspan="2" align="right" style="padding:5px;"><div align="center"><span class="blue">
            <input type="submit" name="client" value="Insert" />
        </span></div></td>
        </tr>
    </table>
	</form>
	
	</td>
    <td valign="top">
	<?
	if($status==1){
	?>
	  <form action="" method="post" enctype="multipart/form-data" name="account" id="account">
        <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
          <tr bgcolor="#679435">
            <td colspan="4" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Advance Amount </td>
          </tr>
          <tr>
            <td width="25%" align="right" style="padding:5px;">Service : </td>
            <td width="50%" colspan="2" align="left" style="padding:5px;">&nbsp;</td>
            <td width="25%" align="center">&nbsp;</td>
          </tr>
          <tr bgcolor="#f8fbc1">
            <td align="right" style="padding:5px;">Amt  : </td>
            <td align="left"><input name="address2" type="text" id="address2" size="10" /></td>
            <td align="left"><span style="padding:5px;">Date  :</span></td>
            <td align="left"><input name="pay_date" type="text" id="pay_date" size="10" /></td>
          </tr>
          <tr>
            <td align="right" style="padding:5px;">Detail : </td>
            <td colspan="2" align="left" style="padding:5px;"><input name="address4" type="text" id="address4" value="" size="35" /></td>
            <td align="center"><span class="blue">
              <input name="account" type="submit" id="account" value="Paid" />
            </span></td>
          </tr>
        </table>
	    <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
          <tr bgcolor="#679435">
            <td align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Date</td>
            <td align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Amount</td>
            <td align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Detail</td>
          </tr>
          <tr bgcolor="#f8fbc1">
            <td width="25%" align="right" style="padding:5px;">&nbsp;</td>
            <td width="25%" align="left">&nbsp;</td>
            <td width="25%" align="left">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" style="padding:5px;">&nbsp;</td>
            <td align="right" style="padding:5px;">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
        </table>
      </form>
	  <form name="room" action="" method="post" enctype="multipart/form-data">
      <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
        <tr bgcolor="#679435">
          <td colspan="3" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Room Information  </td>
        </tr>
        
        <tr bgcolor="#f8fbc1">
          <td align="right" style="padding:5px;">Check IN: </td>
          <td align="left" style="padding:5px;"><input name="check_in" type="text" id="check_in" value="<?=$check_in_date?>" size="10" /></td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="right" style="padding:5px;">Check OUT: </td>
          <td align="left" style="padding:5px;"><input name="check_out" type="text" id="check_out" value="<?=$check_out_date?>" size="10" /></td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr bgcolor="#f8fbc1">
          <td width="25%" align="right" style="padding:5px;">Add Room : </td>
          <td width="50%" align="left" style="padding:5px;"><select name="room_no" id="room_no">
              <? 
			  $sql="SELECT a.id,concat(a.room_no,' : ',b.room_type) FROM `hms_hotel_room` a,`hms_room_type` b WHERE b.id=a.room_type_id and a.id not in (select room_id from `hms_hotel_room_status` where room_status>0 and date='$check_in_date')";
			  advance_foreign_relation($sql);?>
            </select>&nbsp;</td>
          <td width="25%" align="center"><span class="blue">
            <input name="room_add" type="submit" id="room_add" value="ADD" />
          </span></td>
        </tr>
      </table>
      <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
        <tr bgcolor="#679435">
          <td width="25%" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Room ID </td>
          <td width="25%" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Room Type </td>
          <td width="25%" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Check IN </td>
          <td width="25%" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Check OUT </td>
          <td width="25%" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Reject</td>
        </tr>
<? 	$sql="select distinct b.id,b.room_no, c.room_type ,(select min(date) from hms_hotel_room_status where a.room_id=room_id),(select max(date) from hms_hotel_room_status where a.room_id=room_id) from hms_hotel_room_status a,hms_hotel_room b,hms_room_type c where a.reserve_id=$reserve_id and a.room_id=b.id and b.room_type_id=c.id";
	$query=mysql_query($sql);
	while($data=mysql_fetch_row($query)){
?>
        <tr bgcolor="#f8fbc1">
          <td align="right" style="padding:5px;"><div align="center">
            <?=$data[1]?>
          </div></td>
          <td align="right" style="padding:5px;"><div align="center">
            <?=$data[2]?>
          </div></td>
          <td align="right" style="padding:5px;">
            <div align="center">
              <?=$data[3]?>
            </div></td>
          <td align="left">
            <div align="center">
              <?=$data[4]?>
            </div></td>
          <td align="left"><div align="center"><a href="reservation_info.php?id=<?=$room_id?>&date=<?=$date?>&del=1&room_id=<?=$data[0]?>&reserve_id=<?=$reserve_id?>"><img src="../../images/del.png" width="16" height="16" /></a></div></td>
        </tr>
<? }?>  
      </table>
	  </form>
	  <? }?>
	  </td>
  </tr>
</table>
