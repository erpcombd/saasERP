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


if(isset($_POST['reportcreation'])){
	
	
	$Crud = new Crud('report_information');
	$_POST['entry_by']=$_SESSION['user']['id'];
	$_POST['entry_at']=date('Y-m-d H:i:s');
	$report_id=$Crud->insert();
    echo '<script type="text/javascript">
            window.location.href = "eprocurement_report.php?unique_report_id=' . $report_id . '";
          </script>';
}
if(isset($_POST['deleteReport'])){

	
$deletesql='DELETE FROM report_structure_information WHERE report_id = "'.$_POST['report_id_to_delete'].'";';
db_query($deletesql);
$deletesql='DELETE FROM report_information WHERE id = "'.$_POST['report_id_to_delete'].'";';
db_query($deletesql);



}



if(isset($_POST['del'])){
	$rfq_master = find_all_field('rfq_master','*','rfq_no='.$_POST['rfq_no']);
	if($rfq_master->status=='MANUAL'){
		
		$delQl = 'update rfq_master set del = 1 where rfq_no = '.$rfq_master->rfq_no;
		db_query($delQl);   
	
		/*$delQl = 'delete from rfq_master where rfq_no='.$rfq_master->rfq_no;
		db_query($delQl);
		
		$delQl = 'delete from rfq_documents_information where rfq_no='.$rfq_master->rfq_no;
		db_query($delQl);
		
		$delQl = 'delete from rfq_documents_url_information where rfq_no='.$rfq_master->rfq_no;
		db_query($delQl);
		$delQl = 'delete from rfq_doc_details where rfq_no='.$rfq_master->rfq_no;
		db_query($delQl);
		$delQl = 'delete from rfq_evaluation_section where rfq_no='.$rfq_master->rfq_no;
		db_query($delQl);
		$delQl = 'delete from rfq_evaluation_section_child where rfq_no='.$rfq_master->rfq_no;
		db_query($delQl);
		$delQl = 'delete from rfq_evaluation_section_child_vendor where rfq_no='.$rfq_master->rfq_no;
		db_query($delQl);
		$delQl = 'delete from rfq_evaluation_section_vendor where rfq_no='.$rfq_master->rfq_no;
		db_query($delQl);
		$delQl = 'delete from rfq_evaluation_team where rfq_no='.$rfq_master->rfq_no;
		db_query($delQl);
		$delQl = 'delete from rfq_form_details where rfq_no='.$rfq_master->rfq_no;
		db_query($delQl);
		$delQl = 'delete from rfq_form_element_options where rfq_no='.$rfq_master->rfq_no;
		db_query($delQl);
		$delQl = 'delete from rfq_form_master where rfq_no='.$rfq_master->rfq_no;
		db_query($delQl);
		$delQl = 'delete from rfq_form_response where rfq_no='.$rfq_master->rfq_no;
		db_query($delQl);
		$delQl = 'delete from rfq_group_for where rfq_no='.$rfq_master->rfq_no;
		db_query($delQl);
		$delQl = 'delete from rfq_item_details where rfq_no='.$rfq_master->rfq_no;
		db_query($delQl);
		$delQl = 'delete from rfq_multiple_currency where rfq_no='.$rfq_master->rfq_no;
		db_query($delQl);
		
		$delQl = 'delete from rfq_section_evaluation_team where rfq_no='.$rfq_master->rfq_no;
		db_query($delQl);
		$delQl = 'delete from rfq_vendor_details where rfq_no='.$rfq_master->rfq_no;
		db_query($delQl);
		$delQl = 'delete from rfq_vendor_item_response where rfq_no='.$rfq_master->rfq_no;
		db_query($delQl);
		
		
		$delQl = 'delete from rfq_vendor_response where rfq_no='.$rfq_master->rfq_no;
		db_query($delQl);
		$delQl = 'delete from rfq_vendor_terms_condition where rfq_no='.$rfq_master->rfq_no;
		db_query($delQl);*/
		
		$msg = "Deleted Successfuly";
	}
}
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
	.ul{
	list-style:none;
	padding-left:5px;
	}
	.ul .li{
	
	}
</style>
<h1 class="container" style=" font-size: 30px !important; ">Robi Group eSourcing Platform  &nbsp; <?php if($_SESSION['msg']!=''){ echo $_SESSION['msg'];unset($_SESSION['msg']);}else{ echo '';}?></h1>
<div class="container ep-bg-color pt-0 mt-5 p-0 ">

<!-- <div class="alert alert-warning">
  <strong>Warning!</strong> This is test server
</div> -->

<div class="d-flex justify-content-start d-flex-bg-color">
	<div><a class="toggle"><button type="button" class="btn1 btn1-bg-submit" data-toggle="modal" data-target="#productaddmodal">Create Event</button></a></div>
	<div><a class="toggle"><button type="button" class="btn1 btn1-bg-submit" data-toggle="modal" data-target="#productaddmodal">Create Template</button></a></div>
	<div><a class="toggle"><button type="button" class="btn1 btn1-bg-submit" data-toggle="modal" data-target="#reportcreationmodal">Create Report</button></a></div>
	
	<div style=" padding-top: 10px; ">
		<div class="form-group row m-0 p-0" style=" width: 400px; ">
		<label for="inputPassword" class="col-sm-2 col-form-label fs-14" style=" padding: 3px; color: white; font-weight: 600 !important; text-align: end; ">Edit</label>
		<div class="col-sm-10">

				 <style>
					.dropdown-toggle::after {
    display: inline-block;
    margin-left: .255em;
    vertical-align: .255em;
    content: "";
    border-top: .3em solid;
    border-right: .3em solid transparent;
    border-bottom: 0;
    border-left: .3em solid transparent;
    float: right !important;
    margin-top: 7px;
}
				 </style>
<div class="btn-group w-100">
  <button class="btn btn-secondary text-left btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style=" background-color: white; color: #333; ">
    Edit/Delete
  </button>
  <div class="dropdown-menu w-100">
  <?
					$sqlb_tt = 'select * from report_information where entry_by="'.$_SESSION['user']['id'].'"';
					$qryb_tt = db_query($sqlb_tt);
					while($latest=mysqli_fetch_object($qryb_tt)){
                      ?>
					  <div class="d-flex">
					  <a class="dropdown-item" href="eprocurement_report.php?unique_report_id=<?=$latest->id?>" style="display: inline-block; vertical-align: middle;">
							<?=$latest->report_unique_name?>
						</a>
					<form action="" method="post" style="display: inline-block; vertical-align: middle; margin-right: 10px;">
						<input type="hidden" id="report_id_to_delete" name="report_id_to_delete" value="<?=$latest->id?>">
						<input type="submit" name="deleteReport" class="btn1 btn1-bg-cancel" style="background-color:#e23a6f; color:white; min-width: 50px !important"   value="Delete">
					</form>

					</div>

					  <?
					} ?>
  </div>
</div>
		</div>
	  </div>
  </div>

	<div style=" padding-top: 10px; ">
		<div class="form-group row m-0 p-0" style=" width: 200px; ">
		<label for="inputPassword" class="col-sm-2 col-form-label fs-14" style=" padding: 3px; color: white; font-weight: 600 !important; text-align: end; ">View</label>
		<div class="col-sm-10">

				 <style>
					.dropdown-toggle::after {
    display: inline-block;
    margin-left: .255em;
    vertical-align: .255em;
    content: "";
    border-top: .3em solid;
    border-right: .3em solid transparent;
    border-bottom: 0;
    border-left: .3em solid transparent;
    float: right !important;
    margin-top: 7px;
}
				 </style>
<div class="btn-group w-100">
  <button class="btn btn-secondary text-left btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style=" background-color: white; color: #333; ">
    View Report
  </button>
  <div class="dropdown-menu w-100">
  <?
					$sqlb_tt = 'select * from report_information where entry_by="'.$_SESSION['user']['id'].'"';
					$qryb_tt = db_query($sqlb_tt);
					while($latest=mysqli_fetch_object($qryb_tt)){
                      ?>
					  <a class="dropdown-item" href="eprocurement_report_view.php?report_id=<?=$latest->id?>"><?=$latest->report_unique_name?></a> 
					  <?
					} ?>
  </div>
</div>
		</div>
	  </div>
  </div>
	<!-- <div style=" padding-top: 10px; ">
	  	  <form class="form-inline m-0 p-0" action="">
		<div class="input-group" style=" background-color: white; border-radius: 5px; ">
				  <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1" style="height: 28px !important;padding-top: 2px; border-right: none; ">
		  <button type="submit" class="input-group-prepend" style=" width: 25%; height: 27px !important; border: none; border-radius: 0px 5px 5px 0px; background-color: white; ">
			Search
		  </button>
		</div>
	  </form>
	</div> -->
	  
</div>

<div class="row m-0 p-0 pt-3 pb-3">
	<div class="col-sm-6 col-md-6 col-lg-6">
		<h3 class="bold m-0 alerts-bg">Recent Events</h3>
		<div class="row m-0 p-0 col-sm-12 bg-alerts-bg alerts-table" style=" overflow: hidden; ">
		
		
		
		<ul class="ul">
							<?
						$sqlb = 'select r.*,u.fname from rfq_master r, user_activity_management u, rfq_evaluation_team t where t.rfq_no=r.rfq_no and t.user_id="'.$_SESSION['user']['id'].'" and u.user_id=r.entry_by and r.del !=1 group by t.rfq_no,r.rfq_no order by r.rfq_no desc limit 10';
					$qryb = db_query($sqlb);
					while($latest=mysqli_fetch_object($qryb)){
$date1 = new DateTime(date('Y-m-d'));
$date2 = new DateTime($latest->eventEndDate);

$interval = $date1->diff($date2);

$days = $interval->format('%a');
$curDateInt = strtotime(date('Y-m-d'));
$endDateInt = strtotime($latest->eventEndDate);
if($curDateInt>$endDateInt){
	$days = 0;
}
							?>	
					   		<li class="li"><span class="bold">#<a href="../eProcurement/eprocurement_entry_entry.php?old_rfq_no=<?=url_encode($latest->rfq_no)?>&&clear=1" style=" font-weight: 600; font-size: 14px !important; "> <?=$latest->rfq_version?></span> -  <?=$latest->event_name?></a>&nbsp;-&nbsp;<?=$days;?> day remaining </td>
                        </li>
						<? } ?>
		</ul>

		</div>
	</div>
	<div class="col-sm-6 col-md-6 col-lg-6 pl-0">
	<div class="container-fluid p-0">
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="opportunities-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Tab 1</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="eventtypes-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Tab 2</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="savings-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">Tab 3</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="Savings-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false">Tab 4</a>
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

                <table id="example" class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
						<tr class="bgc-info">
							<th scope="col">Event & Round Number</th>
							<th scope="col">Created Date</th>
							<th scope="col">Event Name</th>
							<th scope="col">Creator</th>

							<th scope="col">Start Date</th>
							<th scope="col">End Date</th>
							<th scope="col">status</th>
							<th scope="col">Type</th>
							<th scope="col">Responses</th>
							<th scope="col">Actions</th>
							
							<th scope="col">Visibility</th>
							<th scope="col">RFQ Reference </th>
						</tr>
                    </thead>

                    <tbody class="tbody1">
					<?php 
					$sql = 'select r.*,u.fname from rfq_master r, user_activity_management u, rfq_evaluation_team t where t.rfq_no=r.rfq_no and t.user_id="'.$_SESSION['user']['id'].'" and u.user_id=r.entry_by and r.del !=1 group by t.rfq_no,r.rfq_no order by r.rfq_no desc';
					$qry = db_query($sql);
					while($rfq=mysqli_fetch_object($qry)){
					
					$eventEndAt = $rfq->eventEndDate.' '.$rfq->eventEndTime;
					$eventEndAtInt = strtotime($eventEndAt);
					$currentDateTime = strtotime(date('Y-m-d H:i:s'));
					
					$winner_id = find_a_field('rfq_vendor_details','vendor_id','rfq_no="'.$rfq->rfq_no.'" and status="SELECTED"');
					$winner_name = find_a_field('vendor','vendor_name','vendor_id="'.$winner_id.'"');
					if($rfq->status=='MANUAL'){
					$status = 'Draft';
					}elseif($rfq->status=='COMPLETE'){
					$status = 'Completed';
					}elseif($rfq->status=='CANCELED'){
					$status = 'Cancelled';
					}elseif($eventEndAtInt<=$currentDateTime){
					$status = 'Evaluation';
					}elseif($rfq->status=='CHECKED'){
					$status = 'Live';
					}elseif($rfq->status=='UNSEALED'){
					$status = 'Evaluation';
					}else{
					$status = $rfq->status;
					}
					if($rfq->master_rfq_no==0){
					 $rounding = '<a href="rounding.php?rfq_no='.$rfq->rfq_no.'" target="_blank" rel="noopener">#'.$rfq->rfq_no.' New Round</a>';
					}else{
					$rounding = '';
					}
					$role = find_a_field('rfq_evaluation_team','action','rfq_no="'.$rfq->rfq_no.'" and user_id="'.$_SESSION['user']['id'].'"');
					
					$rfq->eventEndAt = $rfq->eventEndDate." ".$rfq->eventEndTime;
					
					$responses = find_a_field('rfq_vendor_response','count(DISTINCT vendor_id)','rfq_no='.$rfq->rfq_no.' and status like "SUBMITED" ');
					?>
					
					    <tr>
                            <td style="white-space:nowrap"><a href="../eProcurement/eprocurement_entry_entry.php?old_rfq_no=<?=url_encode($rfq->rfq_no)?>&&clear=1" target="_blank" rel="noopener"><?=$rfq->rfq_version?></a></td>
							
							<td><?=$rfq->entry_at?></td>
                            <td><?=$rfq->event_name?></td>
                            <td><?=$rfq->fname?></td>
                            <td><?=$rfq->eventStartDate?></td>
							<td><?=$rfq->eventEndAt?></td>
							<td><?=$status?></td>
							<td><?=$rfq->rfx_stage?></td>
							<td><?=$responses ?></td>
							<td><? if($rfq->status=='MANUAL' && $role=='Owner'){ //=$rfq->action?>
								<form action="" method="post">
									<input type="hidden" name="rfq_no" value="<?=$rfq->rfq_no;?>"  />
									<input type="submit" class="btn1 btn1-bg-cancel" style="background-color:#e23a6f; color:white; min-width: 50px !important" name="del" id="del" value="Delete"  />
								</form>
								<? } ?>
							</td>
							<td><?=find_a_field('event_visibility_team','team','id="'.$rfq->content_group.'"');?> </td>
							<td><?=$rfq->rfx_referance;?> </td>
                        </tr>
						<? } ?>
					</tbody>
                </table>





</div>





<!-- report modal start -->
<div class="modal fade" id="reportcreationmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

<div class="modal-dialog modal-body1" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title fs-17" id="exampleModalLabel">Create Report</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<em class="fs-18 bold fa-solid fa-xmark"></em>
			</button>
		</div>
	   
<div class="modal-body">
  
  
	<div class="row m-0 p-0">
		
    
	<form class="form-inline m-0 p-0" action="" method="post">
		<div class="input-group" style=" background-color: white; border-radius: 5px; ">
				  <input type="text" name="report_unique_name" id="report_unique_name" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1" style="height: 28px !important;padding-top: 2px; border-right: none; ">
				  
				  <!-- <input type="" name="report_unique_name" value="<?//=$rfq->rfq_no;?>"  /> -->
				  <input type="submit" class="btn1 btn btn-success" style="background-color:#28a745; color:white; min-width: 50px !important" name="reportcreation" id="del" value="Create"  />
		</div>
	  </form>
											
	</div>
 </div>
			
			<div class="modal-footer">
				<button type="button" class="btn1 btn1-bg-cancel fs-13" data-dismiss="modal">Cancel</button>
			</div>

	</div>
</div>
</div>
<!-- report modal end -->





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
			  
			  
				<div class="row m-0 p-0">
					<div class="col-sm-4 col-md-4 col-lg-4">
						<div class="new-even">
							<h2 class="bold fs-18">Create New Event</h2>
							<ul class="even-ul">
								<a href="eprocurement_entry_entry.php?clear=1&rfx_stage=RFI"><li class="even-li fs-14">RFI</li></a>
								<a href="eprocurement_entry_entry.php?clear=1&rfx_stage=RFQ"><li class="even-li fs-14">RFQ</li></a>
								<a href="eprocurement_entry_entry.php?clear=1&rfx_stage=RFP"><li class="even-li fs-14">RFP</li></a>
								<a href="eprocurement_entry_entry.php?clear=1&rfx_stage=Template"><li class="even-li fs-14">Template</li></a>
								<a href="eprocurement_entry_entry.php?clear=1&rfx_stage=Auction"><li class="even-li fs-14">Reverse Auction</li></a>
								<a href="eprocurement_entry_entry.php?clear=1&rfx_stage=ForwardAuction"><li class="even-li fs-14">Forward Auction</li></a>
							</ul>
						</div>
					</div>
					<div class="col-sm-4 col-md-4 col-lg-4">
						<div class="new-even">
							<h2 class="bold fs-18">Create from Template</h2>
							 <input type="text" class="form-control-plaintext" id="template_id" name="" value="" onkeyup="get_event_template_lis(<?=$_SESSION['user']['id']?>,'templateEventList',this.value)" placeholder="Search by Template ID or Name">
							<div class="overflow-even">
								<ul class="even-ul" id="templateEventList">
									<?
								$sql2 = 'select r.*,u.fname from rfq_master r, user_activity_management u, rfq_evaluation_team t 
								where t.rfq_no=r.rfq_no and u.user_id=r.entry_by and r.rfx_stage ="Template" and r.del !=1
								group by t.rfq_no,r.rfq_no order by r.rfq_no desc';
								
								$qry2 = db_query($sql2);
								while($rfq_copy=mysqli_fetch_object($qry2)){
								?>
				<a href="event_template_copy.php?rfq_no=<?=url_encode($rfq_copy->rfq_no)?>"><li class="even-li fs-14">#<?=$rfq_copy->rfq_no?> - <?=$rfq_copy->event_name?></li></a>
									<? } ?>
									
								</ul>
							</div>
						</div>
					</div>

					<div class="col-sm-4 col-md-4 col-lg-4">
						<div class="new-even">
							<h2 class="bold fs-18">Create from Event</h2>
							 <input type="text" class="form-control-plaintext" id="event_id" name="event_id" value="" onkeyup="get_event_lis(<?=$_SESSION['user']['id']?>,'copyEventList',this.value)" placeholder="Search by Event ID or Name">
							<div class="overflow-even">
								<ul class="even-ul" id="copyEventList">
								<?
								$sql2 = 'select r.*,u.fname from rfq_master r, user_activity_management u, rfq_evaluation_team t where t.rfq_no=r.rfq_no and t.user_id="'.$_SESSION['user']['id'].'" and u.user_id=r.entry_by and r.del !=1 group by t.rfq_no,r.rfq_no order by r.rfq_no desc';
					$qry2 = db_query($sql2);
					while($rfq_copy=mysqli_fetch_object($qry2)){
								?>
									<a href="event_copy.php?rfq_no=<?=url_encode($rfq_copy->rfq_no)?>"><li class="even-li fs-14">#<?=$rfq_copy->rfq_no?> - <?=$rfq_copy->event_name?></li></a>
									<? } ?>
									

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
function get_event_lis(user_id,type,data){
	getData2('get_event_list_ajax.php',type,user_id,data);
}

function get_event_template_lis(user_id,type,data){
	getData2('get_event_template_list_ajax.php',type,user_id,data);
}


</script>


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
#require_once "../../../controllers/routing/layout.bottom.php";
?>

<?
	datatable("#example");
	require_once SERVER_ROOT."public/assets/datatable/datatable.php";
	require_once "../../../controllers/routing/layout.bottom.php";
?>