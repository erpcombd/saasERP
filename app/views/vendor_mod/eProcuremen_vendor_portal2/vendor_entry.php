<?php

 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Event Management';

do_calander("#f_date");
do_calander("#t_date");
?>
    <script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>	
	<script type="text/javascript" src="../../../assets/js/jquery-3.4.1.min.js"></script>

<style>
.nav-tabs .nav-item .nav-link, .nav-tabs .nav-item .nav-link:hover, .nav-tabs .nav-item .nav-link:focus {
    border: 0 !important;
    color: #007bff !important;
    font-weight: 500;
}

.sidebar, .sidemenu{
	display:none;
    width: 0% !important;
}

.main_content{
	width: 100% !important;
}

.sidebar, .sidemenu{
	display:none;
    width: 0% !important;
}

.main_content{
	width: 100% !important;
}
.nav-tabs{
	border-bottom: 1px solid #d9d9d9;
	/*background-color: ghostwhite;*/
	background-color: #f9f9f994;
}

.tab-content>.active {
    display: block;
    border: 1px solid #f5f5f5;
/*	background-color: #fbfbfb9e;*/
	background-color: #fffffffb;
}

.nav-tabs .nav-item .nav-link.active{
    border: 1px solid #e1e1e1 !important;
    border-radius: 5px 5px 0px 0px;
    border-bottom: 1px solid #f8f8ff !important;
	color: #121089 !important;
}
.nav-tabs .nav-item .nav-link:hover{
    border: 1px solid #e1e1e1 !important;
    border-radius: 5px 5px 0px 0px;
    border-bottom: 1px solid #f8f8ff !important;
}

.h1{
    font-size: 16px !important;
    font-weight: 400;
}

.h1 i{
    font-size: 18px !important;
    font-weight: 400;
	color:#00469e;
}
.attachments .tr .td1{
	width:21%;
	padding-left:15px;
	text-align:left;
	font-weight:bold;
}
.attachments .tr .td2{
	width:79%;
	text-align:left;
}

.tr .td1{
	width:30%;
	text-align:right;
	font-weight:bold;
}
.tr .td2{
	width:70%;
	text-align:left;
	padding-left:6px;
}
tr:nth-child(even) {
    background-color: #fffffffb!important;
	color: #333 !important;
}

tr:nth-child(odd) {
    background-color: #fffffffb !important;
    color: #333 !important;
}

.d-flex-bg-color{
background-color:#333 !important;
}
.ep-bg-color{
	background-color:#f5f5f5 !important;
}
.btn1-bg-submit{
	margin:10px !important;
	background-color:#FFFFFF !important;
	color:#333 !important;
	font-weight:bold !important;	
}
.alerts-bg{
	background-color:#f0f0f0;
	padding:10px;
}
.bg-alerts-bg{
background-color:#FFFFFF !important;
}
.alerts-table{
	height:300px !important;
}
.sourcing-table{
	width:100%;
}

.sourcing-table tr:nth-child(odd), .sourcing-table tr:nth-child(even)  {
    background-color: #fff !important;
    color: #333!important;
	text-align:left;
}
.tab-pane{
height:292px;
background-color:#fff !important;
}
.nav-tabs {
    border-bottom: 1px solid #d9d9d9;
    background-color: #fffefe;
}

  
  
  /*modal start css*/
  .modal-dialog {
    max-width: 1000px;
	top: 10%;
   }
   .modal-header{
	   background-color:#333;
	   padding: 13px;
   }
    
   .modal-header .modal-title, .modal-header button i {
   		color:#fff;
   }

	.new-even{
		width: 100%;
		height: 250px;
		border: 1px solid #d5d4d4;
		border-radius: 10px;
		padding: 10px;
	}
	
	.even-ul,.even-ul .even-li{
		margin:0px;
		padding:0px;
		list-style:none;
		line-height:2;
	}
	.overflow-even{
		overflow-x: hidden !important;
		overflow: scroll;
		height: 160px;
		width: 100%;
	}
	.btn1-bg-cancel,.btn1-bg-cancel:hover {
    	background-color: #efefef;
    	color: #181818;
    	font-weight: bold !important;
	}
</style>
<div class="container pt-2 p-0 ">
<h1 class="container" style=" font-size: 25px !important; ">Welcome to your Sourcing Response Portal!</h1>

<p class="m-0 fs-14 p-4 description" style="line-height: 1.6rem !important; text-align: justify !important; font-weight: 400 !important; color: #2f2f2f !important;"> <span class="bold fs-14">Supplier</span> has been invited by <span class="bold fs-14">Axiata Group of Companies</span> to participate in a sourcing event for <span class="bold fs-14">Test Event new 20.</span> Participation and submission is easy and all done within the system. Response may require forms, attachments, price quotes, and/or descriptions of products or services. If you have responded to the event, please ignore this message</p>

<h1 class="container" style=" font-size: 25px !important; ">All Sourcing Events</h1>
<div class="d-flex justify-content-end d-flex-bg-color">

	<div style=" padding: 5px; ">
		<div class="form-group row m-0 p-0" style=" width: 300px; ">
		<label for="inputPassword" class="col-sm-2 col-form-label fs-14" style=" padding: 3px; color: white; font-weight: 600 !important; text-align: end; ">View</label>
		<div class="col-sm-10">
		        <select id="" name="" class="form-control" style="height: 28px !important;padding-top: 4px; ">
					<option value="ALL"> ALL</option>
					<option value="">opction 1 </option>
					<option value="">opction 2 </option>
      			</select>
		</div>
	  </div>
  </div>
	<div style=" padding: 5px; ">
	  	  <form class="form-inline m-0 p-0" action="">
		<div class="input-group" style=" background-color: white; border-radius: 5px; ">
				  <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1" style="height: 28px !important;padding-top: 2px; border-right: none; ">
		  <button type="submit" class="input-group-prepend" style=" width: 25%; height: 27px !important; border: none; border-radius: 0px 5px 5px 0px; background-color: white; ">
			<i class="fa-duotone fa-magnifying-glass fa-flip-horizontal fa-xl" style="--fa-primary-color: #b27d0a; --fa-secondary-color: #0ebadd; padding: 12px;"></i>
		  </button>
		</div>
	  </form>
	</div>
	  
</div>


  <div class="row">	
	<div class="col-12 pt-0 pb-4">	
	<div class="pt-1">
  	<table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Event ID</th>
						<th>Event Name</th>
                        <th>Start Date</th>
						<th>End Date</th>
						<th>Status</th>
						<th>Type</th>
						<th>Response</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					<?
					$now = date('Y-m-d H:i:s');
					$start = date('Y-m-d');
					$vendor = find_a_field('user_activity_management','vendor_code','user_id="'.$_SESSION['user']['id'].'"');
				echo	$sql = 'select m.*,v.vendor_name 
					from rfq_master m, rfq_vendor_details d, vendor v 
					where m.rfq_no=d.rfq_no and v.vendor_id=d.vendor_id and d.vendor_id="'.$vendor.'" and m.status="CHECKED"  and d.status like "INVITED"
					and m.eventStartDate<="'.$start.'" and m.eventEndDate>="'.$now.'"';
					$qry=db_query($sql);
					while($data=mysqli_fetch_object($qry)){
					if($data->status=='CHECKED'){
					 $status = 'Prod';
					}
					?>
					    <tr>
						    <td><a href="vendor_entry_entry.php?rfq_no=<?=$data->rfq_no?>"> <button type="button" class="btn2 btn1-bg-update"><?=$data->rfq_no?></button></a></td>
							<td align="left"><?=$data->event_name?></td>
							<td><?=$data->eventStartDate?></td>
							<td><?=$data->eventEndAt?></td>
							<td><?=$status?></td>
							<td><?=$data->rfx_stage?></td>
							<td><?=$data->total_response?></td>
                        </tr>	
						<? } ?>						
					</tbody>
                </table>
  
  
  
  
  </div>
		
		
		
	</div>
	
  </div>
                        




</div>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>