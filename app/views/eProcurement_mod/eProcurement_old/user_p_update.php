<?php
require_once "../../../controllers/routing/layout.top.php";
$current_page = "events";
$title='eProcurement Entry';
do_calander("#f_date");
do_calander("#t_date");
do_datatable('rfq_table');
unset($_SESSION['rfq_no']);
unset($_SESSION['rfq_version']);
unset($_SESSION['master_status']);
var_dump($_SESSION);
?>
<? include_once 'ep_menu.php'; ?>
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
	background-color: #fbfbfb9e;
}

.nav-tabs .nav-item .nav-link.active{
    border: 1px solid #e1e1e1 !important;
    border-radius: 5px 5px 0px 0px;
    border-bottom: 1px solid #f8f8ff !important;
}
.nav-tabs .nav-item .nav-link:hover{
    border: 1px solid #e1e1e1 !important;
    border-radius: 5px 5px 0px 0px;
    border-bottom: 1px solid #f8f8ff !important;
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

 .dropdown {
    position: relative;
    display: inline-block;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 210px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
	left: 10px; 
	padding: 5px 0px;
	border-radius: 3px;
	background-color: white;
  }
  .dropdown-content a{
  	background-color:#fff !important;
	text-align:left;
	padding: 5px 0px 5px 10px;
  }
  .dropdown-content a:hover{
  color:#f37025;
  }
  
  
  
  .fs-8{font-size:8px !important;}.fs-9{font-size:9px !important;}.fs-10{font-size:10px !important;}.fs-11{font-size:11px !important;}.fs-12{font-size:12px !important;}.fs-13{font-size:13px !important;} .fs-14{font-size:14px !important;}  .fs-15{font-size:15px !important;}  .fs-16{font-size:16px !important;}  .fs-17{font-size:17px !important;}  .fs-18{font-size:18px !important;}  .fs-19{font-size:19px !important;}  .fs-20{font-size:20px !important;} .fs-21{font-size:21px !important;}.fs-22{font-size:22px !important;}
  
  
  
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
<h1 class="container" style=" font-size: 30px !important; ">Sourcing Manager</h1>
<div class="container ep-bg-color pt-0 mt-5 p-0 ">

<div class="d-flex justify-content-start d-flex-bg-color">
	<div><a class="toggle"><button type="button" class="btn1 btn1-bg-submit" data-toggle="modal" data-target="#productaddmodal">Create Event</button></a></div>
	<div><a class="toggle"><button type="button" class="btn1 btn1-bg-submit" data-toggle="modal" data-target="#productaddmodal">Create Template</button></a></div>
	
	<div class="dropdown" id="dropdown">
		<button type="button" class="btn1 btn1-bg-submit" onclick="toggleDropdown()" style=" margin-bottom: 4px !important; ">Export to <em class="fa-light fa-chevron-down" style=" padding-left: 10px; font-weight: 600; "></em></button>
		  <div class="dropdown-content" id="myDropdown">
			<a href="#">CSV plain (current columns)</a>
			<a href="#">CSV for Excel (current columns)</a>
			<a href="#">Excel (current columns)</a>
		  </div>
	</div>


	<div style=" padding-top: 10px; ">
		<div class="form-group row m-0 p-0" style=" width: 300px; ">
		<label for="inputPassword" class="col-sm-2 col-form-label fs-14" style=" padding: 3px; color: white; font-weight: 600 !important; text-align: end; ">View</label>
		<div class="col-sm-10">
		        <select id="" name="" class="form-control" style="height: 28px !important;padding-top: 4px; ">
					<option value="ALL"> ALL</option>
					<option value="">Active </option>
					<option value="">AJ_SAVINGS_VIEW </option>
					<option value="">Production </option>
					<option value="">RFI </option>
					<option value="">RFP </option>
					<option value="">RFQ </option>
        			<option value="" >Robi monthly project list</option>
					<option value="" selected="selected">Robi Sourcing Project List </option>
					<option value=""> Robi Sourcing visible to all</option>
					<option value=""> Robi yearly project list</option>
					<option value=""> RPA Sourcing </option>
					<option value=""> Sourcing Report W</option>
					<option value=""> Suppliers</option>
					<option value=""> Test Events</option>
					<option value=""> Create View</option>
      			</select>
		</div>
	  </div>
  </div>
	<div style=" padding-top: 10px; ">
	  	  <form class="form-inline m-0 p-0" action="">
		<div class="input-group" style=" background-color: white; border-radius: 5px; ">
				  <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1" style="height: 28px !important;padding-top: 2px; border-right: none; ">
		  <button type="submit" class="input-group-prepend" style=" width: 25%; height: 27px !important; border: none; border-radius: 0px 5px 5px 0px; background-color: white; ">
			<em class="fa-duotone fa-magnifying-glass fa-flip-horizontal fa-xl" style="--fa-primary-color: #b27d0a; --fa-secondary-color: #0ebadd; padding: 12px;"></em>
		  </button>
		</div>
	  </form>
	</div>
	  
</div>

<div class="row m-0 p-0 pt-3 pb-3">
	<div class="col-sm-4 col-md-4 col-lg-4">
		<h3 class="bold m-0 alerts-bg">Alerts</h3>
		<div class="row m-0 p-0 col-sm-12 bg-alerts-bg alerts-table">
		
				<table class="sourcing-table">
                    <tbody class="tbody1">				
					    <tr>
							<td class="w-20">10/02/24</td>
							<td class="w-80"><span class="bold">#41083</span> - <a href="#" style=" font-weight: 600; font-size: 14px !important; ">Test Event esourche</a> ended 1 days ago</td>
                        </tr>	
					    <tr>
							<td class="w-20">10/02/24</td>
							<td class="w-80"><span class="bold">#41083</span> - <a href="#" style=" font-weight: 600; font-size: 14px !important; ">Test Event esourche</a> ended 1 days ago</td>
                        </tr>	
					    <tr>
							<td class="w-20">10/02/24</td>
							<td class="w-80"><span class="bold">#41083</span> - <a href="#" style=" font-weight: 600; font-size: 14px !important; ">Test Event esourche</a> ended 1 days ago</td>
                        </tr>	
					    <tr>
							<td class="w-20">10/02/24</td>
							<td class="w-80"><span class="bold">#41083</span> - <a href="#" style=" font-weight: 600; font-size: 14px !important; ">Test Event esourche</a> ended 1 days ago</td>
                        </tr>	
					    <tr>
							<td class="w-20">10/02/24</td>
							<td class="w-80"><span class="bold">#41083</span> - <a href="#" style=" font-weight: 600; font-size: 14px !important; ">Test Event esourche</a> ended 1 days ago</td>
                        </tr>	

											
					</tbody>
                </table>

		</div>
	</div>
	<div class="col-sm-8 col-md-8 col-lg-8 pl-0">
	<div class="container-fluid p-0">
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="opportunities-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Opportunities</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="eventtypes-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Event Types</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="savings-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">Savings</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="Savings-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false">Top Commodities Savings</a>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="settings-tab">Opportunities content</div>
    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="timeline-tab">Event Types content</div>
    <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="details-tab">Savings content</div>
    <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="suppliers-tab">Top Commodities Savings</div>
  </div>
</div>
	
	
	
	</div>
	
</div>

</div>


<div class="container-fluid pt-3 p-5 ">

                <table id="rfq_table" class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th scope="col">Event# </th>
						<th scope="col">Rounding# </th>
						<th scope="col">Created Date</th>
                        <th scope="col">Revision</th>
                        <th scope="col">Event Name</th>
						<th scope="col">Creator</th>

                        <th scope="col">Start Date</th>
						<th scope="col">End Date</th>
						<th scope="col">status</th>
						<th scope="col">Type</th>
						<th scope="col">Responses</th>
						<th scope="col">Actions</th>
						
						<th scope="col">Content Groups</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					<?php 
					$sql = 'select r.*,u.fname from rfq_master r, user_activity_management u where u.user_id=r.entry_by order by r.rfq_no desc';
					$qry = db_query($sql);
					while($rfq=mysqli_fetch_object($qry)){
					$winner_id = find_a_field('rfq_vendor_details','vendor_id','rfq_no="'.$rfq->rfq_no.'" and status="SELECTED"');
					$winner_name = find_a_field('vendor','vendor_name','vendor_id="'.$winner_id.'"');
					if($rfq->status=='CHECKED'){
					$status = 'Prod';
					}elseif($rfq->status=='MANUAL'){
					$status = 'Draft';
					}else{
					$status = $rfq->status;
					}
					if($rfq->master_rfq_no==0){
					 $rounding = '<a href="rounding.php?rfq_no='.$rfq->rfq_no.'" target="_blank" rel="noopener">#'.$rfq->rfq_no.' New Round</a>';
					}else{
					$rounding = '';
					}
					?>
					
					    <tr>
                            <td><a href="../eProcurement/eprocurement_entry_entry.php?rfq_no=<?=url_encode($rfq->rfq_no)?>" target="_blank" rel="noopener"><?=$rfq->rfq_version?></a></td>
							<td><?=$rounding?></td>
							<td><?=$rfq->entry_at?></td>
							<td></td>
                            <td><?=$rfq->event_name?></td>
                            <td><?=$rfq->fname?></td>

                            <td><?=$rfq->eventStartDate?></td>
							<td><?=$rfq->eventEndAt?></td>
							<td><?=$status?></td>
							<td><?=$rfq->rfx_stage?></td>
							<td><?=$rfq->total_response?></td>
							<td><?=$rfq->action?></td>
							
							<td> </td>


                        </tr>
						<? } ?>
														
					</tbody>
                </table>





        </div>





<div class="modal fade" id="productaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog modal-body1" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-17" id="exampleModalLabel">Create Event</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <em class="fs-18 bold fa-solid fa-xmark"></em>
                        </button>
                    </div>
                   
			<div class="modal-body">
			  <div class="form-group pb-3 row">
				<label for="staticEmail" class="col-sm-2 col-form-label fs-15">Select Commodity</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control-plaintext" id="" name="" value="" placeholder="Commodity selection will filter templates and events" style=" width: 40% !important; ">
				</div>
			  </div>
			  
				<div class="row m-0 p-0">
					<div class="col-sm-4 col-md-4 col-lg-4">
						<div class="new-even">
							<h2 class="bold fs-18">Create New Event</h2>
							<ul class="even-ul">
								<a href="#"><li class="even-li fs-14">RFI</li></a>
								<a href="eprocurement_entry_entry.php"><li class="even-li fs-14">RFQ</li></a>
								<a href="#"><li class="even-li fs-14">RFP</li></a>
								<a href="#"><li class="even-li fs-14">English Reverse Auction</li></a>
							</ul>
						</div>
					</div>
					<div class="col-sm-4 col-md-4 col-lg-4">
						<div class="new-even">
							<h2 class="bold fs-18">Create from Template</h2>
							 <input type="text" class="form-control-plaintext" id="" name="" value="" placeholder="Search by Template ID or Name">
							<div class="overflow-even">
								<ul class="even-ul">
									<a href="#"><li class="even-li fs-14">#41078 - Test Event esourche</li></a>
									<a href="#"><li class="even-li fs-14">#41077 - Test1</li></a>
									<a href="#"><li class="even-li fs-14">#41076 - Test2 </li></a>
									<a href="#"><li class="even-li fs-14">#41075 - Test</li></a>
									
									<a href="#"><li class="even-li fs-14">#41077 - Test1</li></a>
									<a href="#"><li class="even-li fs-14">#41076 - Test2 </li></a>
									<a href="#"><li class="even-li fs-14">#41075 - Test</li></a>									
									<a href="#"><li class="even-li fs-14">#41077 - Test1</li></a>
									
									<a href="#"><li class="even-li fs-14">#41076 - Test2 </li></a>
									<a href="#"><li class="even-li fs-14">#41075 - Test</li></a>
									

								</ul>
							</div>
						</div>
					</div>

					<div class="col-sm-4 col-md-4 col-lg-4">
						<div class="new-even">
							<h2 class="bold fs-18">Create from Template</h2>
							 <input type="text" class="form-control-plaintext" id="" name="" value="" placeholder="Search by Event ID or Name">
							<div class="overflow-even">
								<ul class="even-ul">
									<a href="#"><li class="even-li fs-14">#41078 - Test Event esourche</li></a>
									<a href="#"><li class="even-li fs-14">#41077 - Test1</li></a>
									<a href="#"><li class="even-li fs-14">#41076 - Test2 </li></a>
									<a href="#"><li class="even-li fs-14">#41075 - Test</li></a>
									
									<a href="#"><li class="even-li fs-14">#41077 - Test1</li></a>
									<a href="#"><li class="even-li fs-14">#41076 - Test2 </li></a>
									<a href="#"><li class="even-li fs-14">#41075 - Test</li></a>									
									<a href="#"><li class="even-li fs-14">#41077 - Test1</li></a>
									
									<a href="#"><li class="even-li fs-14">#41076 - Test2 </li></a>
									<a href="#"><li class="even-li fs-14">#41075 - Test</li></a>
									

								</ul>
							</div>
						</div>
					</div>

				
							                            
				</div>
             </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn1 btn1-bg-cancel fs-13" data-dismiss="modal">Cancel</button>
                        </div>

                </div>
            </div>
</div>


<script>
function toggleDropdown() {
  var dropdown = document.getElementById("myDropdown");
  if (dropdown.style.display === "block") {
    dropdown.style.display = "none";
  } else {
    dropdown.style.display = "block";
  }
}

document.body.addEventListener("click", function(event) {
  var dropdown = document.getElementById("myDropdown");
  var dropdownButton = document.getElementById("dropdown");
  if (!dropdown.contains(event.target) && !dropdownButton.contains(event.target)) {
    dropdown.style.display = "none";
  }
});
</script>

<?
require_once "../../../controllers/routing/layout.bottom.php";
?>