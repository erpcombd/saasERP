<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
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
			<? $sql="SELECT a.id,concat(a.room_no,' : ',b.room_type) FROM `hms_hotel_room` a,`hms_room_type` b WHERE b.id=a.room_type_id order by a.room_no";
			advance_foreign_relation($sql,$_REQUEST['r_id']);?>
			  </select>		                   
					</div>
                </div>

             
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Occupy Date :</label>
                    <div class="col-sm-9 p-0">
    <input name="occu_date" type="text" id="occu_date" value="<? if(isset($_REQUEST['occu_date'])) echo $_REQUEST['occu_date']; else echo date('Y-m-d');?>" />
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
$occu_date=$_REQUEST['occu_date'];
$sql="select a.* from hms_reservation a,hms_hotel_room_status b where b.room_id='".$r_id."' and b.date='".$occu_date."' and b.reserve_id=a.id order by id desc limit 1";
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
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Address :</label>
                    <div class="col-sm-9 p-0">
							<span id="bld">
			<textarea name="" id=""><?=$info->client_address?></textarea>
			</span> 
				   </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Mobile NO :</label>
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

<br />

<? if(isset($reserve_id)&&$reserve_id!=''){?>
<form action="?r_id=<?=$r_id?>" method="post" name="cloud" id="cloud">
<table class="table1  table-striped table-bordered table-hover table-sm">
				<thead class="thead1">
					<tr class="bgc-info">
                        <td>Service Group</td>
					  	<td>Paid Amt</td>
                        <td >Action</td>
						<tbody class="tbody1">
						<td><span id="inst_no">
      <select name="service_id" id="service_id">
        <?
$sql="SELECT a.id,a.service_group FROM `hms_service_group` a WHERE a.id =4";
advance_foreign_relation($sql);
?>
      </select>
      </span>
        <input type="hidden" name="reserve_id" value="<?=$reserve_id?>" />
        <input type="hidden" name="room_id" value="<?=$r_id?>"/></td>
    <td ><span id="inst_amt">
      <input name="paid_amt" type="text" id="paid_amt"  tabindex="10" class="input3" style="width:100px;" />
    </span></td>
	<td><input name="billing" type="submit" id="billing" value="Confirm" tabindex="12" class="btn1 btn1-bg-update"/></td>
                        
					</tr>
				</thead>
				</tbody>								
			</table>
	<div align="center"><a href="bill_invoice_final.php?reserve_no=<?= $reserve_id;?>" target="_blank"><img src="../../../../public/assets/images/print.png" width="30" height="30" border="0" /></a><br />
</div>
<br />


</form>

<? }?>
<div class="box4">
<? if(isset($reserve_id)&&$reserve_id!='')
{

$res1='select sum(bill_amt),sum(paid_amt) from `hms_bill_payment` where reserve_id='.$reserve_id;
$data=mysqli_fetch_row(db_query($res1));

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
      <td><table width="45%" border="0" cellspacing="2" cellpadding="0" align="right">
        <tr>
          <td > Total: </td>
          <td ><input name="user_id" type="text" id="user_id" value="<?=$data[0]?>" /></td>
          <td ><input name="name" id="name" type="text" value="<?=$data[1]?>" /></td>
		</tr>
		
    <tr>
     <td>

 </td>
 </tr>
  </table>
<? }?></div>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>