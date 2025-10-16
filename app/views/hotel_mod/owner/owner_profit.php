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
	db_query($sql);
}
?>
<?
if((isset($_REQUEST['owner_id']))&&isset($_REQUEST['year']))
{
$owner_id=$_REQUEST['owner_id'];
$year=$_REQUEST['year'];

$sql="select a.* from hms_owner_detail a where a.id='".$owner_id."' limit 1";
$i=db_query($sql);
if(mysqli_num_rows($i)>0)
$info=mysqli_fetch_object($i);
}
?> 





<form action="" method="post" name="form2" id="form2">
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
		<div class="n-form">
            
                <h4 align="center" class="n-form-titel1">Owner Information</h4>

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Owner Name :</label>
                    <div class="col-sm-9 p-0">
						<select name="owner_id" id="owner_id">
							<? foreign_relation('hms_owner_detail','id','name',$owner_id);?>
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
                <h4 align="center" class="n-form-titel1">Client Details</h4>

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Name :</label>
                    <div class="col-sm-9 p-0">
						<input  name="" type="text" id="" value="<?=$info->name?>"/>      
					</div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Address :</label>
                    <div class="col-sm-9 p-0">
							<span id="bld">
							 	<textarea name="" id=""><?=$info->address?></textarea>
							</span>
				   </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Contact no. :</label>
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
		

			
			
			
			
<? if(isset($info->name)&&$info->name!=''){?>
<form action="?r_id=<?=$r_id?>" method="post" name="cloud" id="cloud">

<table class="table1  table-striped table-bordered table-hover table-sm">
				<thead class="thead1">
					<tr class="bgc-info">
                        <td>Year</td>
					  	<td>Owner Name</td>
                        <td>Room-Session</td>
                        <td>Hotel Profit</td>
                        <td>Owner Profit</td>
						<td>Action</td>
					</tr>
				</thead>
				<tbody class="tbody1">
					<tr>
						  <td><input name="year" type="text" class="input3" id="year"  maxlength="100" value="<?=$year?>" readonly/></td>
						  <td>						
						    <input name="owner_name" type="text" class="input3" id="owner_name"  maxlength="100" value="<?=$info->name?>" readonly/>
							<input name="owner_id" type="hidden" class="input3" id="owner_id"  maxlength="100" value="<?=$info->id?>" readonly/>
						  </td>
						  <td>
						  <select name="session_id" id="session_id">
							<? 
							$sql="SELECT c.id,concat(a.room_name,' : ',b.session) FROM `hms_hotel_room` a,`hms_ownership` c, hms_owner_session b WHERE b.id=c.session_id and a.id=c.room_id";
							advance_foreign_relation($sql,$room_id);	
							?>
						  </select>
						  </td>
						   <td>
						   	<span id="inst_date">                      
                            	<input name="hotel_profit" type="text" class="input3" id="hotel_profit"  maxlength="100"/>
                            </span>
						   </td>
						   <td>
						   	<span id="inst_amt">
								<input name="owner_profit" type="text" id="owner_profit"  tabindex="10" class="input3" /> 
							</span>
						   </td>
						   <td><input name="billing" type="submit" id="billing" value="ADD" tabindex="12" class=" btn1 btn1-bg-update"/></td>
					</tr>

				</tbody>				
			</table>


</form>
<? }?>

<? if(isset($info->name)&&$info->name!=''){
$res1='select sum(hotel_profit),sum(owner_profit) from `hms_owner_profit` where owner_id='.$info->id.' and year='.$year;
$data=mysqli_fetch_row(db_query($res1));
?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">

		<tr>
			  <td>
			  
				  <div class="tabledesign2">
					<? 
						$res="select a.id,a.year, b.name,concat(e.room_name,':',c.session) as room_session,a.hotel_profit,a.owner_profit from hms_owner_profit a, hms_owner_detail b, hms_owner_session c, hms_ownership d ,`hms_hotel_room` e where 
						a.session_id=d.id and d.session_id=c.id and d.room_id=e.id and
						b.id=a.owner_id and a.owner_id=".$info->id." and a.year=".$year;
						
						echo link_report($res);
					?>
				  </div>
			  </td>
		</tr>
	    <tr>
		  <td>
			  <table width="47%" border="0" cellspacing="2" cellpadding="0" align="right">
				<tr>
				  <td > Total: </td>
				  <td ><input name="user_id" type="text" id="user_id" value="<?=$data[0]?>" /></td>
				  <td ><input name="name" id="name" type="text" value="<?=$data[1]?>" /></td>
				</tr>
			  </table>
		  </td>
		</tr>
		
    <tr>
     <td>

 </td>
 </tr>
  </table>
  
<? }else {?>
  
  <table class="table1  table-striped table-bordered table-hover table-sm" id="grp">
				<thead class="thead1">
					<tr class="bgc-info">
					  <th>Service Group</th>
					  <th>Bill Date</th>
					  <th>Bill Date</th>
					  <th>Paid Amt</th>
					</tr>
				</thead>
				<tbody class="tbody1">
					<tr>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						   <td>&nbsp;</td>
					</tr>
					<tr>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						   <td>&nbsp;</td>
					</tr>
					<tr>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						   <td>&nbsp;</td>
					</tr>
					<tr>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						   <td>&nbsp;</td>
					</tr>
					<tr>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						   <td>&nbsp;</td>
					</tr>

					<tr>
						  <td colspan="2"> Total: </td>
						  <td><input name="user_id" type="text" id="user_id" value="<?=$data[0]?>" /></td>
						  <td><input name="name" id="name" type="text" value="<?=$data[1]?>" /></td>
					</tr>
				</tbody>				
			</table>
			
<? }?>
		
</div>
	


<?
	require_once SERVER_CORE."routing/layout.bottom.php";
?>