<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";
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
		db_query($sql);
		
		$sql="update hms_hotel_room_status set room_status=0 where date>='$today' and room_status=9 and  reserve_id='$reserve_id'";
		db_query($sql);
		
		$sql="update hms_hotel_room set status=2 where id in (select room_id from hms_hotel_room_status where reserve_id='$reserve_id')";
		db_query($sql);
		
		header("Location:hotel_status.php");
}
if(isset($_REQUEST['del']))
{
$reserve_id=$_REQUEST['reserve_id'];
$del=$_REQUEST['del'];
		$sql="delete from hms_bill_payment where id='$del'";
		db_query($sql);
		
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
	db_query($sql);
}
?>
<!--start-->
<form action="" method="post" name="form2" id="form2">
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
		<div class="n-form">
            
                <h4 align="center" class="n-form-titel1">Bill Information</h4>

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Room No :</label>
                    <div class="col-sm-9 p-0">
						<select name="r_id" id="r_id">
              <? 
			  $sql="SELECT a.id,concat(a.room_no,' : ',b.room_type) FROM `hms_hotel_room` a,`hms_room_type` b WHERE b.id=a.room_type_id and a.status=9 order by a.room_no";
			  advance_foreign_relation($sql,$r_id);?>
			  </select>		                   
					</div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Year :</label>
                    <div class="col-sm-9 p-0">
					<select name="year" id="year" required>
						<option><?=$year?></option>
						<option>2012</option>
						<option>2013</option>
						<option>2014</option>
						<option>2015</option>
					</select>             
                   
				   </div>
                </div>
				
				

                <div class="n-form-btn-class">
                      <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Search details " />	
					  
                </div>

			</div>
        </div>


        <div class="col-sm-6">
           <div class="n-form">
                <h4 align="center" class="n-form-titel1">Owner Details</h4>

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Name :</label>
                    <div class="col-sm-9 p-0">
						<?
if(isset($_REQUEST['r_id']))
{
$r_id=$_REQUEST['r_id'];

$sql="select a.* from hms_reservation a,hms_hotel_room_status b where b.room_id='".$r_id."' and b.reserve_id=a.id and b.room_status=9  order by `date` desc limit 1";
$i=db_query($sql); 
if(mysqli_num_rows($i)>0){
$info=mysqli_fetch_object($i);
$reserve_id=$info->id;
}
}
?> 
			<input  name="" type="text" id="" value="<?=$info->client_name?>"/>      
					</div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Mobile No :</label>
                    <div class="col-sm-9 p-0">
							<span id="fid">
			<input  name="" type="text" id="" value="<?=$info->contact_no?>"/>
			</span>
				   </div>
                </div>		
				


			</div>
        </div>

	</div>
</div>

 </form>
 
 
<!--below table-->
<div class="container-fluid pt-5 p-0 ">		
<? if(isset($reserve_id)&&$reserve_id!=''){?>
<form action="?r_id=<?=$r_id?>" method="post" name="cloud" id="cloud">

<table class="table1  table-striped table-bordered table-hover table-sm">
				<thead class="thead1">
					<tr class="bgc-info">
                        <td>Service</td>
					  	<td>Paid Amt</td>
						<td>Action</td>
						<tbody class="tbody1">
                        
      </tr>
                      <tr>
                        <td> <span id="inst_no"><select name="service_id" id="service_id">
<?
$sql="SELECT a.id,a.service_name FROM `hms_services` a,`hms_service_group` b WHERE b.id in (4,5,8) and b.id=a.service_group_id";
advance_foreign_relation($sql);
?>
</select>
                        </span>
                        <input type="hidden" name="reserve_id" value="<?=$reserve_id?>" />
                        <input type="hidden" name="room_id" value="<?=$r_id?>"/></td>
						  
                          <td><span id="inst_amt"><input name="paid_amt" type="text" id="paid_amt"  tabindex="10" class="input3" style="width:100px;" /> </span>                       </td>
						  <td  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">
						  <input name="billing" type="submit" id="billing" value="Confirm" tabindex="12" class="btn1 btn1-bg-update"/>                       
						  </div>				        </td>
      </tr>	
	  </tbody>			
			</table>
  <div align="center"><a href="bill_invoice_final.php?reserve_no=<?= $reserve_id;?>" target="_blank"><img src="../../../../public/assets/images/print.png" width="30" height="30" border="0" /></a><br />
                      </div>


</form>


<? }?>

<? if(isset($reserve_id)&&$reserve_id!='')
{

$res1='select sum(bill_amt),sum(paid_amt) from `hms_bill_payment` where reserve_id='.$reserve_id;
$datat=mysqli_fetch_row(db_query($res1));

		?>


  <table id="grp" class="table1  table-striped table-bordered table-hover table-sm">
	<thead class="thead1">
		  <tr class="bgc-info">
				  <th>Date</th>
				  <th>Item Detail</th>
				  <th>Detail</th>
				  <th>Amount</th>
				  <th>Service</th>
				  <th>Vat</th>
				  <th>Total</th>
				  <th>Credit</th>
				  <? if($_SESSION['user']['id']==10010||$_SESSION['user']['id']==10018||$_SESSION['user']['id']==10036){?>
				  <th>DEL</th>
				  <? }?>
		  </tr>
	</thead>
	<tbody class="tbody1">

			<? 
			$res='select a.id, a.bill_date, s.service_group,(select service_name from hms_services where id=a.optional_service_id) as detail,a.total_amt as amount,a.service_charge as service, a.vat_amt as Vat, a.bill_amt as total,a.paid_amt as credit from hms_bill_payment a,`hms_service_group` s where s.id=a.service_group_id and a.reserve_id='.$reserve_id.' and a.bill_amt<>a.paid_amt order by a.id';
			$query = db_query($res);
			while($data = mysqli_fetch_object($query)){
			?>
				<tr>
					<td><?=$data->bill_date?></td>
					<td><?=$data->service_group?></td>
					<td><?=$data->detail?></td>
					<td><?=$data->amount?></td>
					<td><?=$data->service?></td>
					<td><?=$data->Vat?></td>
					<td><?=$data->total?></td>
					<td><?=$data->credit?></td>
						  <? if($_SESSION['user']['id']==10010||$_SESSION['user']['id']==10018||$_SESSION['user']['id']==10036){?>
					<td><a href="?reserve_id=<?=$reserve_id?>&del=<?=$data->id?>">X</a></td>
						  <? }?>
				</tr>
			<? } ?>
	
			<tr>
			 <td colspan="6" > Total: </td>
			<td ><input name="user_id" type="text" id="user_id" value="<?=$datat[0]?>" /></td>
			  <td ><input name="name" id="name" type="text" value="<?=$datat[1]?>" /></td>
			</tr>
	
	</tbody>
</table>
  
<? }?>
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
          <input type="submit" name="checkout" value="CHECKED OUT"  class="btn1 btn1-bg-submit"/>
		</form>
        </div>
      </td>
    </tr>
  </table>

    <? } }

else?>
  
  <table class="table1 table-striped table-bordered table-hover table-sm" id="grp">
				  <div align="center">   
            <tr>
              <td>DUE:</td>
              <td><input name="" type="text" value="<?=$due?>"/></td>
            </tr>
          
    
  				
			</table>
			
		
</div>


<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>