<?php

 

 

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

</style>
<div class="container-fluid pt-2 p-0 ">


<div class="row p-0 pb-5">
	<div class="col-sm-9 col-lg-9 col-md-9 col-9">
		<!--<div class="pt-5" style=" font-size: 18px; padding-left: 2%;">Erp revenue Shar.... -Event #45304<span>(Active)</span></div>-->
	</div>
	<div class="col-sm-3 col-lg-3 col-md-3 col-3">
	    <label for="demo">Event End in</label>
		<div class="input-group mb-3">
			10 Days
		</div>
	</div>
</div>






<ul class="nav nav-tabs" id="myTab" role="tablist">
  <!--<li class="nav-item">
    <a class="nav-link active" id="settings-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="settings" aria-selected="true">Event Info</a>
  </li>-->
  <li class="nav-item">
    <a class="nav-link " id="timeline-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="timeline" aria-selected="false">My Responses</a>
  </li>
 <!-- <li class="nav-item">
    <a class="nav-link" id="details-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="details" aria-selected="false">Edite RFQ</a>
  </li>-->
  
</ul>


<div class="tab-content" id="myTabContent">

				                
  <!--1st tab -->
  
		
  
  

  
				
  
  <!--2nd tab -->
  <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="timeline-tab">

	
	
	<div class="col-12 pt-4 pb-4">		
		<div class="pt-1">
  	<table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Event Name</th>
                        <th>Start Date</th>
						<th>End Date</th>
						<th>Action</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					<?
					$vendor = find_a_field('user_activity_management','vendor_code','user_id="'.$_SESSION['user']['id'].'"');
					$sql = 'select m.*,v.vendor_name from rfq_master m, rfq_vendor_details d, vendor v where m.rfq_no=d.rfq_no and v.vendor_id=d.vendor_id and d.vendor_id="'.$vendor.'"';
					$qry=db_query($sql);
					while($data=mysqli_fetch_object($qry)){
					?>
					    <tr>
							<td align="left"><?=$data->event_name?></td>
							<td><?=$data->eventStartDate?></td>
							<td><?=$data->eventEndAt?></td>
							<td><a href="response.php?rfq_no=<?=$data->rfq_no?>"> <button type="button" class="btn2 btn1-bg-update">Response</button></a></td>
                        </tr>	
						<? } ?>						
					</tbody>
                </table>
  
  
  
  
  </div>
		
		
		
	</div>
	
  </div>
                        


  <!--3rd tab -->
   
  

</div>



</div>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>