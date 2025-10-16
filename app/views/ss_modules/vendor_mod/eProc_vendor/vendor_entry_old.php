<?php
require_once "../../../controllers/routing/layout.top.php";
$title='Event Management';

do_calander("#f_date");
do_calander("#t_date");

unset($_SESSION['response_id']);
?>
    <script type="text/javascript" src="../../../../public/assets/js/bootstrap.min.js"></script>	
	<script type="text/javascript" src="../../../../public/assets/js/jquery-3.4.1.min.js"></script>

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


.tab-content>.active {
    display: block;
    border: 1px solid #f5f5f5;

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
<?php if($_SESSION['msg']!=''){ ?>
 <div class="alert alert-success" role="alert">
  <?php echo $_SESSION['msg'];?>
</div>
<?php unset($_SESSION['msg']); } ?>
<h1 class="container" style=" font-size: 25px !important; ">Welcome to your Sourcing Response Portal!</h1>

<p class="m-0 fs-14 p-4 description" style="line-height: 1.6rem !important; text-align: justify !important; font-weight: 400 !important; color: #2f2f2f !important;"> 

<?=find_a_field('rfq_vendor_massage','vendor_massage','1')?>

</p>

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
		  <button type="submit" class="input-group-prepend" style=" width: 25%; height: 27px !important; border: none; border-radius: 0px 5px 5px 0px; background-color: white; "> Search
		  </button>
		</div>
	  </form>
	</div>
	  
</div>


  <div class="row">	
	<div class="col-12 pt-0 pb-4">	
	<div id="table_show_div" class="pt-1">
  	<table class="table1  table-striped table-bordered table-hover table-sm">
	            <caption></caption>
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th scope="col" scope="col">Event ID</th>
						<th scope="col" scope="col">Event Name</th>
                        <th scope="col" scope="col">Start Date</th>
						<th scope="col" scope="col">End Date</th>
						<th scope="col" scope="col">Status</th>
						<th scope="col" scope="col">Type</th>
						<th scope="col" scope="col">Response</th>
						<th scope="col" scope="col">Action</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					<?
					$now = date('Y-m-d H:i:s');
					$start = date('Y-m-d');
					$vendor = $_SESSION['vendor']['id'];
					$sql = 'select m.*,v.vendor_name ,d.reject_status
					from rfq_master m, rfq_vendor_details d, vendor v 
					where m.rfq_no=d.rfq_no and v.vendor_id=d.vendor_id and d.vendor_id="'.$vendor.'"   and d.status like "INVITED" order by m.rfq_no desc
					';
					// and m.status="CHECKED" and m.eventStartDate<="'.$start.'" and m.eventEndAt>="'.$now.'"
					$qry=db_query($sql);
					while($data=mysqli_fetch_object($qry)){
					if($data->status=='CHECKED'){
					 $status = 'Prod';
					}
					//&& $data->eventEndAt<=$now
					$eventStart = strtotime($data->eventStartDate);
					$startString = strtotime($start);
					
					$eventEnd = strtotime($data->eventEndDate." ".$data->eventEndTime);
					$nowString = strtotime($now);
					?>
					    <tr>
						    <td><?=$data->rfq_version?></td>
							<td><?=$data->event_name?></td>
							<td><?=$data->eventStartDate?></td>
							<td><?=date('Y-m-d', $eventEnd);?></td> 
							<td><?=$status?></td> 
							<td><?=$data->rfx_stage?></td>
							<td><?=find_a_field('rfq_vendor_response','count(id)','vendor_id="'.$vendor.'" and rfq_no="'.$data->rfq_no.'" ')?></td>
							<td>
								<?php if($eventStart<=$startString && $eventEnd>=$nowString && $data->status=="CHECKED" && $data->reject_status=="No"){ ?>
									<a href="vendor_entry_entry.php?rfq_no=<?=$data->rfq_no?>"> <button type="button" class="btn2 btn1-bg-update">Event View</button></a>
								<?php } ?>
							
							<?if($data->reject_status=="Yes"){?>	
							  <span style="color:red;">Not Participated</span>
                            <?}?>
							</td>
                        </tr>	
						<? } //}?>	
						
											
					</tbody>
                </table>
  
  
  
  
  </div>
		
		
		
	</div>
	
  </div>
                        




</div>
<?
require_once "../../../controllers/routing/layout.bottom.php";
?>