<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='eProcurement';

do_calander("#f_date");
do_calander("#t_date");

$master_id = $_GET['rfq_no'];



$rfq = find_all_field('rfq_master','','rfq_no="'.$_GET['rfq_no'].'"');
$provide_by = find_a_field('user_activity_management','fname','user_id="'.$rfq->entry_by.'"');
$vendor = find_a_field('user_activity_management','vendor_code','user_id="'.$_SESSION['user']['id'].'"');
if(isset($_POST['vendor_response'])){
        
		if($_GET['rfq_no']>0){ 
        $delete = 'delete from rfq_vendor_response where rfq_no="'.$_GET['rfq_no'].'" and vendor_id="'.$vendor.'"';
		db_query($delete);
		$crud   = new crud("rfq_vendor_response");
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:s:i');
		$_POST['response_date']=date('Y-m-d');
		$_POST['rfq_no']=$_GET['rfq_no'];
		$_POST['vendor_id']=$vendor;
		
		$sql = 'select * from rfq_doc_details where 1 and rfq_no="'.$_GET['rfq_no'].'"';
		$qry = db_query($sql);
		while($doc=mysqli_fetch_object($qry)){
		if($_FILES['vendor_att'.$doc->id]['name']!=''){
		$_POST['file_name']=$doc->section_name;
		$_POST['event_doc_details_id']=$doc->id;
		$_POST['att_file'] = upload_file("rfq","vendor_att".$doc->id."",rand());
		$crud->insert();
		}
		}
		}

}



if(isset($_POST['vendor_item_response'])){
        
		if($_GET['rfq_no']>0){
        $delete = 'delete from rfq_vendor_item_response where rfq_no="'.$_GET['rfq_no'].'" and vendor_id="'.$vendor.'"';
		db_query($delete);
		$crud   = new crud("rfq_vendor_item_response");
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:s:i');
		$_POST['response_date']=date('Y-m-d');
		$_POST['rfq_no']=$_GET['rfq_no'];
		$_POST['vendor_id']=$vendor;
		
		$sql = 'select * from rfq_item_details where 1 and rfq_no="'.$_GET['rfq_no'].'"';
		$qry = db_query($sql);
		while($doc=mysqli_fetch_object($qry)){
		if($_POST['vendor_price'.$doc->id]!=''){
		$_POST['capacity']=$_POST['capacity'.$doc->id];
		$_POST['expected_qty']=$doc->expected_qty;
		$_POST['unit_price']=$_POST['vendor_price'.$doc->id];
		$_POST['total_amount']=$_POST['vendor_total_amount'.$doc->id];
		$_POST['item_id']=$doc->item_id;
		$_POST['event_item_details_id']=$doc->id;
		$crud->insert();
		}
		}
		}

}

if(isset($_POST['terms_condition_response'])){
        $delete = 'delete from rfq_vendor_terms_condition where rfq_no="'.$_GET['rfq_no'].'" and vendor_id="'.$vendor.'"';
		db_query($delete);
        $crud = new crud("rfq_vendor_terms_condition");
        $_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:s:i');
		$_POST['response_date']=date('Y-m-d');
		$_POST['rfq_no']=$_GET['rfq_no'];
		$_POST['vendor_id']=$vendor;
		$crud->insert();
}

if(isset($_POST['confirm_response'])){
 $max_response = find_a_field('rfq_master','total_response','rfq_no="'.$_GET['rfq_no'].'"')+1;
 $update = 'update rfq_master set total_response="'.$max_response.'" where rfq_no="'.$_GET['rfq_no'].'"';
 db_query($update);
 header('location:vendor_entry.php');
}
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

.attachment-toggle-add-file {
  font-size: 32px;
  color: dimgray;
  /* background-color: #eee; */
  border: 0;
  outline: none;
}

.attachment-toggle .attachment-toggle-add-file.icon-close {
  display: none;
}

.attachment-toggle.opened .attachment-toggle-add-file.icon-search {
  display: none;
}

.attachment-toggle.opened .attachment-toggle-add-file.icon-close {
  display: block;
}

.search-container {
  position: relative;
  transition: all 0.3s;
  max-height: 0;
  overflow: hidden;
  background-color: 'red';
  padding: 12px;
}

.fileuploadcontaineropened{
	display: block !important;
}
.fileuploadcontainerclosed{
	display: block;
}

.search-container.opened {
  max-height: 100px;
  background-color: 'red';
}

.search-container input[type="text"] {
  outline: none;
  font-size: 1.6rem;
  margin: 18px;
  width: 300px;
  background-color: inherit;
  border: 0;
}

.search-container .attachment-toggle-add-file {
  vertical-align: middle;
}

/* Demo CSS */
.container {
  position: relative;
  margin-top: 50px;
}

.fileuploadcontainer,.attachmenturluploadcontainer,.attachmenttextuploadcontainer,.internalfileuploadcontainereventinfo,.fileuploadcontainereventinfo,.internalattachmenturluploadcontainereventinfo,.attachmenturluploadcontainereventinfo,.internalattachmenttextuploadcontainereventinfo,.attachmenttextuploadcontainereventinfo{
	margin: 15px;
	display: none;
}
/* .attachmenturluploadcontainer{
	margin: 15px;
	display: none;
} */

.fileuploadcontainer form,.attachmenturluploadcontainer form,.attachmenttextuploadcontainer form ,.internalfileuploadcontainereventinfo,.fileuploadcontainereventinfo form,.internalattachmenttextuploadcontainereventinfo,.attachmenttextuploadcontainereventinfo form,.internalattachmenturluploadcontainereventinfo,.attachmenturluploadcontainereventinfo form{
  /* position: absolute;
  left: 15px; */
  border: 0.1px solid  #333;
  padding: 12px;
}

input[type=file]::file-selector-button {
  margin-right: 20px;
  border: none;
  background: #138496;;
  padding: 10px 20px;
  border-radius: 10px;
  color: #fff;
  cursor: pointer;
  /* transition: background .2s ease-in-out; */
}
.drop-area2{
	border: 2px dashed red;
    display: flex;
    justify-content: center;
    align-items: ce;

	
}

input[type=file]::file-selector-button:hover {
  background: #138496;;
}


.lds-spinner {
  color: official;
  display: inline-block;
  position: relative;
  width: 40px;
  height: 40px;
  transform: scale(0.35);
}
.lds-spinner div {
  transform-origin: 40px 40px;
  animation: lds-spinner 1.2s linear infinite;
}
.lds-spinner div:after {
  content: " ";
  display: block;
  position: absolute;
  top: 3px;
  left: 37px;
  width: 6px;
  height: 18px;
  border-radius: 20%;
  background: #4b4c4c;
}
.lds-spinner div:nth-child(1) {
  transform: rotate(0deg);
  animation-delay: -1.1s;
}
.lds-spinner div:nth-child(2) {
  transform: rotate(30deg);
  animation-delay: -1s;
}
.lds-spinner div:nth-child(3) {
  transform: rotate(60deg);
  animation-delay: -0.9s;
}
.lds-spinner div:nth-child(4) {
  transform: rotate(90deg);
  animation-delay: -0.8s;
}
.lds-spinner div:nth-child(5) {
  transform: rotate(120deg);
  animation-delay: -0.7s;
}
.lds-spinner div:nth-child(6) {
  transform: rotate(150deg);
  animation-delay: -0.6s;
}
.lds-spinner div:nth-child(7) {
  transform: rotate(180deg);
  animation-delay: -0.5s;
}
.lds-spinner div:nth-child(8) {
  transform: rotate(210deg);
  animation-delay: -0.4s;
}
.lds-spinner div:nth-child(9) {
  transform: rotate(240deg);
  animation-delay: -0.3s;
}
.lds-spinner div:nth-child(10) {
  transform: rotate(270deg);
  animation-delay: -0.2s;
}
.lds-spinner div:nth-child(11) {
  transform: rotate(300deg);
  animation-delay: -0.1s;
}
.lds-spinner div:nth-child(12) {
  transform: rotate(330deg);
  animation-delay: 0s;
}
@keyframes lds-spinner {
  0% {
    opacity: 1;
  }
  100% {
    opacity: 0;
  }
}

.attachmenturluploadcontainer,.attachmenttextuploadcontainer,.internalfileuploadcontainereventinfo,.fileuploadcontainereventinfo {
    position: relative;
}
.fileuploadcontainer {
    position: relative;
}

.attachment-icon-close-container {
    position: absolute;
    right: 0;
    top: 7;
    transform: translateY(-50%);
}

.triangle {
    position: relative;
    float: left;
    width: 0;
    height: 0;
    border-style: solid;
}
.triangle-right {
    border-width: 50px 0 50px 50px;
    border-color: transparent transparent transparent #dfe3e3;
}

</style>




<!--This css for clock start-->
<!--this cdn is for clock font google api-->
  <link href="https://fonts.googleapis.com/css2?family=Orbitron&display=swap" rel="stylesheet">
  <style>
.ep-clock-bg{
	background-color:#f2f2f2 !important;
	border-radius: 15px;
	box-shadow: inset 4px 4px 5px rgba(255,255,255,0.3), 
		  inset -4px -4px 5px rgba(0,0,0,0.1), 10px 40px 40px rgba(0,0,0,0.1);
		      width: 268px;
}
	.ep-titel{
	font-size: 15px !important;
	margin: 5px;
	    font-weight: 600;
	}
.countdown-container {
  display: flex;
  justify-content: center;
  margin: 0px !important;
   
    height: 75px;
    width: 155px;
    border-radius: 10px;
    align-items: center;
    background-color: #00bcd4;
    color: #fff;
	 
	 box-shadow: -12px -10px 10px rgba(255,255,255,0.2), 15px 15px 15px rgba(0,0,0,0.1), inset -10px -10px 10px rgba(255,255,255,0.2), inset 15px 15px 15px rgba(0,0,0,0.1);
}

.countdown-item {
  margin: 0 10px;
}

.countdown-label {
  /font-family: 'Orbitron', sans-serif !important;/
  font-size: 14px !important;
  color: #fff;
}

#days,
#hours {
  font-size: 24px !important;
  font-weight: bold;
  font-family: 'Orbitron', sans-serif !important;
}

    .blinking {
      animation: blink 3s infinite;
	  font-size: 35px !important;
    font-weight: bold;
    font-family: 'Orbitron', sans-serif !important;
    }

    @keyframes blink {
      50% {
        opacity: 0;
      }
    }

</style>
<!--This css for clock end-->


<div class="container pt-2 p-0 ">


<div class="row p-0 pb-5">
	<div class="col-sm-9 col-lg-9 col-md-9 col-9">
		<div class="pt-5" style=" font-size: 18px; padding-left: 2%;">Erp revenue Shar.... -Event #<?=$master_id?><span>(Active)</span></div>
	</div>
	<div class="col-sm-3 col-lg-3 col-md-3 col-3">
	<div class="d-flex justify-content-center align-items-center ep-clock-bg  p-3">
		<span class="ep-titel">Event End</span>
<?php /*?>			<?
$dateString1 = date('Y-m-d H:i:s');
$dateString2 = $rfq->eventEndAt;

$date1 = new DateTime($dateString1);
$date2 = new DateTime($dateString2);

$interval = $date1->diff($date2);

echo $interval->format('%d days , %h hours , %i minutes');
			?><?php */?>
			
			<!--add clock start-->
			  <div class="countdown-container">
					<div class="countdown-item">
					  <span id="days">00</span>
					  <div class="countdown-label">Days</div>
					</div>
					
					<div class="countdown-item">
					  <span id="colon" class="blinking">:</span>
					</div>
					
					<div class="countdown-item">
					  <span id="hours">00</span>
					  <div class="countdown-label">Hours</div>
					</div>
			  </div>
  <!--add clock end-->
			
			
		</div>


	</div>
</div>






<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="settings-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="settings" aria-selected="true">Event Info</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="timeline-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="timeline" aria-selected="false">My Responses</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="details-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="details" aria-selected="false">Details</a>
  </li>
  
</ul>


<div class="tab-content" id="myTabContent">

				                
  <!--1st tab -->
  <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="settings-tab">
  <p class="m-0 fs-14 p-4 description" style="line-height: 1.6rem !important; text-align: justify !important; font-weight: 400 !important; color: #2f2f2f !important;"> <span class="bold fs-14">Supplier</span> has been invited by <span class="bold fs-14">Axiata Group of Companies</span> to participate in a sourcing event for <span class="bold fs-14">Test Event new 20.</span> Participation and submission is easy and all done within the system. Response may require forms, attachments, price quotes, and/or descriptions of products or services. If you have responded to the event, please ignore this message</p>
  
  
  <div class="row m-0 p-0 pt-4">
  	<div class="col-12 pt-4 pb-4">
	
		<!--<h1 class="h1 m-0 p-0 pl-1"> Event Type Settings </h1>
		<p class="p-0 pl-3">Updated "<span>Description</span>" from "<span>Erp revenue Share</span>" to "<span>Test RFQ</span>"</p>
		
		
		<h1 class="h1 m-0 p-0 pt-4 pl-1"> Attachments </h1>
<div class="container">




		<table class="attachments" width="100%">
			<tr class="tr">
				<td class="td1">Updated Attachment name</td>
				<td class="td2">Erp revenue Sharing Model</td>
			</tr>
			
			<tr class="tr">
				<td class="td1">Removed File attachment file</td>
				<td class="td2">Mode_8-Dec.docx</td>
			</tr>
						
			<tr class="tr">
				<td class="td1">Removed File attachment file</td>
				<td class="td2">Mode_7-Dec.docx</td>
			</tr>
		</table>
		
		
		
		<h1 class="h1 m-0 p-0 pt-4 pl-1"> Terms and Conditions </h1>
		<table class="attachments" width="100%">					
			<tr class="tr">
				<td class="td1">Removed File attachment file</td>
				<td class="td2">Mode_7-Dec.docx</td>
			</tr>
		</table>
		<p class="p-0 pl-3">Participation and submission is easy and all done within the system. Response may require forms, attachments, price quotes and/or descriptions of products or services.</p>-->
		



		<h1 class="h1 m-0 p-0 pt-4 pl-3" style="font-size: 30px !important;"><i class="fa-thin fa-comment fa-5x" style="color: #eb7100; font-size: 30px !important;"></i> Do you intend to participate in this event? </h1>
		<hr style="height:1px;border:none;color:#333;background-color:#333;">
		<div class="pl-3 row">
			<div class="col-sm-16 col-md-6 col-lg-6">
					<label class="inlineSelection" style="font-family: Helvetica,Arial,sans-serif !important; color: #60768a !important;font-size: 16px !important; font-weight: 400 !important;">
					<input type="checkbox" name="intend_response" id="intend_response" value="response_intend" data-url="https://axiata-test.coupahost.com/quotes/external_responses/switch_response_intend?id=41100" checked="checked">
					I intend to participate in this event
					</label>
					<br>
					<span style="font-family: Helvetica,Arial,sans-serif !important; color:">Buyer will be notified of your intent to participate.</span>
			</div>

	
		</div>



		<h1 class="h1 m-0 p-0 pt-4 pl-3" style="font-size: 30px !important;"><i class="fa-light fa-check-to-slot" style="color: #eb7100; font-size: 30px !important;"></i> Accept Terms and Conditions </h1>
		<hr style="height:1px;border:none;color:#333;background-color:#333;">
		 <?php
		  $sql = 'select * from documents_information where tr_from like "sourcing_terms_condition" and master_id="'.$_GET['rfq_no'].'"';
		  $qry = db_query($sql);
		  while($res = mysqli_fetch_object($qry)){
		  
		   ?>
	 			<div class="allrowshow">
					<div class="pl-3 row">
							<div class="col-sm-16 col-md-6 col-lg-6">
								<p class="m-0" style="font-family: Helvetica,Arial,sans-serif !important; color: #333 !important;font-size: 18px !important; font-weight: 500 !important;">Terms and Conditions</p>
								<a href="../../../../assets/support/upload_view.php?name=<?php echo $res->new_name;?>&mod=eProcurement_mod&folder=rfq&proj_id=robi" style="font-family: Helvetica,Arial,sans-serif !important; color:#0094e4 !important"><?=$res->original_name?></a>
							</div>
							
						<div class="col-sm-16 col-md-6 col-lg-6">

							<h4 style="font-family: Helvetica,Arial,sans-serif !important; color: #333 !important;font-size: 18px !important; font-weight: 400 !important;">Do you accept these Terms and Conditions?</h4>
							<div class="form_element">
								<label class="inlineSelection" style="font-family: Helvetica,Arial,sans-serif !important; color: #60768a !important;font-size: 16px !important; font-weight: 400 !important;">
								<input type="radio" name="term_<?=$res->documents_id;?>"  <? if($res->terms_accept=='Yes') echo 'checked';?> id="term_<?=$res->documents_id;?>_true" value="Yes" class="s-termAccept" <?=$disabled?>    onclick="remove_form(this.value,<?=$res->documents_id;?>,'file',<?=$master_id;?>)">
								Yes
								</label>
								<br>
								<label class="inlineSelection" style="font-family: Helvetica,Arial,sans-serif !important; color: #60768a !important;font-size: 16px !important; font-weight: 400 !important;">
								<input type="radio"  <? if($res->terms_accept=='No') echo 'checked';?> name="term_<?=$res->documents_id;?>" id="term_<?=$res->documents_id;?>_false" value="No" class="s-termReject"  onclick="remove_form(this.value,<?=$res->documents_id;?>,'file',<?=$master_id;?>)">
								No
								</label>
							</div>


							</div>
						</div>	
				</div>
				<hr class="m-3">
			<?php } ?>	
			
			
			
			<?php
		  $sql = 'select * from documents_url_information where tr_from like "sourcing_terms_condition" and master_id="'.$_GET['rfq_no'].'"';
		  $qry = db_query($sql);
		  while($res = mysqli_fetch_object($qry)){
		  
		   ?>
	 			<div class="allrowshow row">
					<div class=" col-sm-6 col-md-6 col-lg-6 pl-3">
							<div class="container row m-0">
							
							<? if($res->attachment_url !=''){ ?>
								
							   <div class="col-sm-8 col-md-8 col-lg-8 pb-1">
									<div class="rounded p-2" style=" word-break: break-all; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
									<a href="<?=$res->attachment_url?>" target="_blank"><i class="fa-duotone fa-link fa-2xl" style="--fa-primary-color: #d6960a; --fa-secondary-color: #d6960a;"></i>
										<span><?=$res->attachment_url?></span></a>
											
									</div>
								</div>
							<? }else{ ?>
							
								<div class="col-sm-8 col-md-8 col-lg-8 pb-1">
									<div class="rounded p-2" style=" word-break: break-all; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
									
										<span><?=$res->attachment_text?></span>
											
									</div>
								</div>	
							
							<? } ?>
						
							   </div>
							</div>
							
						<div class="col-sm-16 col-md-6 col-lg-6">

							<h4 style="font-family: Helvetica,Arial,sans-serif !important; color: #333 !important;font-size: 18px !important; font-weight: 400 !important;">Do you accept these Terms and Conditions?</h4>
							<div class="form_element">
								<label class="inlineSelection" style="font-family: Helvetica,Arial,sans-serif !important; color: #60768a !important;font-size: 16px !important; font-weight: 400 !important;">
								<input type="radio" name="term_<?=$res->documents_url_id ;?>" <? if($res->terms_accept=='Yes') echo 'checked';?> id="term_<?=$res->documents_url_id ;?>_true" value="Yes" class="s-termAccept" <?=$disabled?>   onclick="remove_form(this.value,<?=$res->documents_url_id ;?>,'text',<?=$master_id;?>)" >
								Yes
								</label>
								<br>
								<label class="inlineSelection" style="font-family: Helvetica,Arial,sans-serif !important; color: #60768a !important;font-size: 16px !important; font-weight: 400 !important;">
								<input type="radio" <? if($res->terms_accept=='No') echo 'checked';?> name="term_<?=$res->documents_url_id ;?>" id="term_<?=$res->documents_url_id ;?>_false" value="No" class="s-termReject"  onclick="remove_form(this.value,<?=$res->documents_url_id ;?>,'text',<?=$master_id;?>)">
								No
								</label>
							</div>


							</div>
						</div>	
				</div>
				<hr class="m-3">
			<?php } ?>		
						
									
					</div>

  
<!--  stype 1 start-->
<div class="col-sm-12 row m-0 p-0 pt-4">
  	<div class="col-6 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><i class="fa-duotone fa-gear"></i> Event Information & Bidding Rules </h1>
		<hr style="height:1px;border:none;color:#333;background-color:#333;">
	  <div class="p-4" style="background-color: #f5f5f5; !important; ">
	   <p class="p-0 pl-3 ">Event will end at the Event End Time.</p>
		<p class="p-0 pl-3 m-0 bold">Responses are sealed until event closes</p>
		<p class="p-0 pl-3 m-0 bold">Buyer may choose to award individual line items</p>
	  </div>

	</div>
	
	<div class="col-6  pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><i class="fa-duotone fa-gear"></i> Buyer Attachments </h1>
		<hr style="height:1px;border:none;color:#333;background-color:#333;">
		
		<div class="attachment-toggle">
								
								
<span class="attachment-toggle-add-file icon-search fs-14" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">File</span>
								<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
								<span class="attachment-toggle-add-url icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Url</span>
								<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
								<span class="attachment-toggle-add-text icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Text</span>
          
          
          <div class="fileuploadcontainer" >
						
                <form  id="attachmentuploadFormxx" enctype="multipart/form-data">
                <input type="hidden" name="master_id" value="<?=$_SESSION[$unique]?>">
                <input type="hidden" name="tr_from" value="sourcing_terms_condition">
                <input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
                <input type="hidden" name="motherContainer" value="fileuploadcontainer">
                <input type="hidden" name="datashowContainer" value="attachmentshowcontainer">
                <div class="attachment-icon-close-container">
                  <i class="attachment-toggle-add-file fa fa-fw fa-close"></i>
                </div>
                <div id="dropArea" class="drop-area">
                <!-- <label for="imageInput" class="btn btn-info">Browse</label> -->
                <input  type="file" name="eprocfiles[]" id="imageInput" accept="*/*" multiple>
                  <div align="center" id="filepercentageandloader" class="filepercentageandloader" style="display: none !important;">
                  </div>
                  
          
                <div class="drop-area2">
                  <div align="center">
                  <p class="m-0">Drag & Drop files here</p>
                  <i class="fa-light fa-cloud-arrow-up fa-2xl"></i>
                  </div>
                
                </div>
                
              </div>
              <input type="checkbox" name="sendtosuppliercheckbox" id="sendtosuppliercheckbox" checked>
                <label for="sendtosuppliercheckbox">Send to Supplier</label>
                  <button type="submit" class="d-none"  name="submit" value="Go" class="attachment-toggle-add-file"><i class="fa fa-fw fa-search"></i></button>
                
                </form>
          </div>
							
							<div class="attachmenturluploadcontainer" >
						
								<form  id="attachmenturluploadForm1" enctype="multipart/form-data">
								<input type="hidden" name="master_id" value="<?=$_SESSION[$unique]?>">
								<input type="hidden" name="tr_from" value="sourcing_terms_condition">
								<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
								<input type="hidden" name="motherContainer" value="ttttttttttt">
								<input type="hidden" name="datashowContainer" value="attachmentUrlshowcontainer">
								
								<div class="attachment-icon-close-container">
									<i class="attachment-toggle-add-url fa fa-fw fa-close"></i>
								</div>
								<!-- <i class="attachment-toggle-add-url fa fa-fw  fa-close"></i> -->
								<p>Add Your URL here</p>
								<input  type="text" name="attachmenturlinput" id="attachmenturlinput">
								
								<input type="checkbox" name="sendtosuppliercheckbox" id="sendtosuppliercheckbox" checked>
								   <label for="sendtosuppliercheckbox">Send to Supplier</label><br>
								  <button type="submit"  name="submit" value="Go" class="attachment-toggle-add-file btn btn-info">ADD</button>
								
								</form>
							</div>
              <div class="attachmenttextuploadcontainer" >
						
                <form  id="attachmenttextuploadForm" enctype="multipart/form-data">
                <input type="hidden" name="master_id" value="<?=$_SESSION[$unique]?>">
                <input type="hidden" name="tr_from" value="sourcing_terms_condition">
                <input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
                <input type="hidden" name="motherContainer" value="attachmenttextuploadcontainer">
                <input type="hidden" name="datashowContainer" value="attachmentTextshowcontainer">
                
                <div class="attachment-icon-close-container">
                  <i class="attachment-toggle-add-text fa fa-fw fa-close"></i>
                </div> 
                <!-- <i class="attachment-toggle-add-text fa fa-fw  fa-close"></i> -->
                <p>Add Your Text here</p>
                <input  type="text" name="attachmenttextinput" id="attachmenttextinput">
                
                <input type="checkbox" name="sendtosuppliercheckbox" id="sendtosuppliercheckbox" checked>
                  <label for="sendtosuppliercheckbox">Send to Supplier</label><br>
                  <button type="submit"  name="submit" value="Go" class="attachment-toggle-add-file btn btn-info">ADD</button>
                
                </form>
            </div>
              <!-- <div class="attachmentshowcontainer container row m-0">
				
              </div>
              <div class="attachmentUrlshowcontainer container row m-0">
                
              
              </div>
              <div class="attachmentTextshowcontainer container row m-0">
                
              
              </div> -->
     
						<div class="attachmentshowcontainer container row m-0">
                        

                       </div>
			<div class="attachmentTextshowcontainer container row m-0">
          <?php
			  $sql = 'select * from documents_url_information where tr_from like "5" and master_id="'.$_GET['rfq_no'].'" and entry_by = "'.$_SESSION['user']['id'].'" ';
			  $qry = db_query($sql);
			  while($res = mysqli_fetch_object($qry)){
			  
		   ?>
		    <div class="col-sm-12 col-md-12 col-lg-12 pb-1">
		   		<div class="rounded p-2" style=" word-break: break-all; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
					<span><i class="fa-solid fa-text-size fa-xl" style="color: #df5c16;"></i>
						<span> test 01</span></span>
						<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentTextseventinfo(this,'<?=$res->documents_url_id?>', '<?=$res->master_id?>', '5', '<?=$res->entry_by?>', 'attachmenttextuploadcontainereventinfo','attachmentshowcontainereventinfo-text')">
							<i class="fa-solid fa-xmark"></i>
						</button>
				</div>
			</div>
		   <? } ?>

                        </div>
						<div class="attachmentUrlshowcontainer container row m-0">
                        <?php
						  $sql = 'select * from documents_url_information where tr_from like "sample_value" and master_id="'.$_GET['rfq_no'].'" and entry_by = "'.$_SESSION['user']['id'].'" ';
						  $qry = db_query($sql);
						  while($res = mysqli_fetch_object($qry)){
					   ?> 
					   <div class="col-sm-8 col-md-8 col-lg-8 pb-1">
					   		<div class="rounded p-2" style="word-break: break-all; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
							<a href="<?=$res->attachment_url?>" target="_blank"><i class="fa-duotone fa-link fa-2xl" style="--fa-primary-color: #d6960a; --fa-secondary-color: #d6960a;"></i>
								<span><?=$res->attachment_url?></span></a>
									<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentURLseventinfo(this,'<?=$res->documents_url_id?>' , '<?=$res->master_id?>', 'sample_value', '<?=$res->entry_by?>', 'attachmenturluploadcontainereventinfo','attachmentshowcontainereventinfo-url')"><i class="fa-solid fa-xmark"></i>
									</button>
							</div>
						</div>
					   
					   <? } ?>

                       </div>
					   <!-- last attachments -->
			</div>
	
	</div>
  </div>

  </div>

  
<!--  stype 2nd start-->

<h1 class="h1 m-0 p-0 pt-4 pl-3"><i class="fa-duotone fa-calendar-days"></i> Timeline </h1>
		  <hr style="height:1px;border:none;color:#333;background-color:#333;">

		<div class="container-fluid">
		<div class="d-flex justify-content-center">

			<div class="p-2" style="background-color: #969696 !important; width: 50% ; height:100px;">
			 <div class="d-flex justify-align-content-start ">
			 <div class="rounded"  style="width: 10% ; height:60%;background-color:#3498db !important; overflow:hidden !important">
			     <p class="m-0" style=" text-align:center;">FEB</p>
				 <p class="m-0" style="background-color: #fff !important; text-align:center; position:relative !important; top: 4px;">21</p>
			     
			</div>
			<div class="ml-2">
                <span style="color:white">Event starts</span><br>
                <span class="fs-18 bold" style="color:white; font: size 18px !important;">12:50pm</span><span style="color:white;">   Asia/Dhaka</span><br>
			</div>

			 </div>
		
			</div>
			<div class="p-2" style="background-color: #dfe3e3 !important; width: 50% ; height:100px;">
					<div class="d-flex justify-align-content-start ">
					<div class="rounded"  style="width: 10% ; height:60%;background-color:#3498db !important; overflow:hidden !important">
						<p class="m-0" style=" text-align:center;">FEB</p>
						<p class="m-0" style="background-color: #fff !important; text-align:center; position:relative !important; top: 4px;">25</p>
						
					</div>
					<div class="ml-2">
						<span style="color:#333">Event End's</span><br>
						<span class="fs-18 bold" style="color:#333; font: size 18px !important;">02:40pm</span><span style="color:#333;">   Asia/Dhaka</span><br>
					</div>

					</div>
			</div>
			<div class="right triangle triangle-right"></div>


		

		</div>
		</div>

		 
		
		<div class="mt-5 w-100 pr-2" align="right">
		<button class="btn1 btn1-bg-update" id="details-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="details" aria-selected="false">Enter Response</button>
		</div>






            
	 </div>
		  
  

  
				
  
  <!--2nd tab -->
  <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="timeline-tab">

	
	
	<div class="col-12 pt-4 pb-4">		
		<div class="pt-1">
  	<table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Response Name</th>
                        <th>State</th>
						<th>Submitted At</th>
                        <th>Total</th>
						<th>Action</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					
					    <tr>
							<td align="left">ERP.COM.BD LIMITED- #000215</td>
							<td> Work</td>
							<td> </td>
                            <td> 0.00</td>
							<td><a href="vendor_entry_entry.php"> <button type="button" class="btn2 btn1-bg-update"><i class="fa-regular fa-pen-to-square"></i></button></a></td>
                        </tr>							
					</tbody>
                </table>
  
  
  
  
  </div>
		
		
		
	</div>
	
  </div>
                        


  <!--3rd tab -->
  <!--3rd tab -->
  <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="details-tab">
  <form action="" method="post" >
  
  <div class="row m-0 p-0 pt-4">
	<div class="col-3"></div>
  	<div class="col-6 d-flex ">
		
		<span class="req-input pr-2 ">Name:</span>
		<input id="name" required type="text" style="outline-color: orange !important;">
	</div>

  </div>
  

  <div class="row m-0 p-0 pt-4">
  	<div class="col-12 pt-4 pb-4">
	   <h1 class="h1 m-0 p-0 pt-4 pl-3" style="font-size: 30px !important;"><i class="fa-light fa-paperclip" style="color: #eb7100; font-size: 30px !important;"></i> Attachments </h1>
		<hr style="height:1px;border:none;color:#333;background-color:#333;">
		<div class="row m-3 ">
				<div class="col-sm-6 col-md-6 col-lg-6 p-3" style="background-color:#268ecd;" ><p class="m-0 bold text-white ">Provided by <?=$provide_by;?></p>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-6 p-3" style="background-color:#268ecd;" ><p class="m-0 text-white  bold">Your Response</p>
				</div>
		</div>
		<!--  stype 1 start-->
<!----------------------------------------------------------------------------------------------------------->		
<?php
	  $sql = 'select d.* from rfq_doc_details d where   rfq_no="'.$_GET['rfq_no'].'" ';
	  $qry = db_query($sql);
	  while($res = mysqli_fetch_object($qry)){
?>     <form >

</form>
		<div class="row m-5 p-0 pt-1">
			<div class="col-5  p-0">
			<h1 class="m-0 p-0 pl-3 fs-22"><?=$res->section_name;?></h1>
			
			<div class="pl-3 mt-3">
				<p class="p-0 m-0 fs-14" style="font-weight:bold"> Instructions </p>
				<?php echo $res->terms; ?>
			</div>
			
			
			<div class="pl-3 pt-3">
				<p class="p-0 m-0 fs-18" style="font-weight:bold"> Attachment</p>
				<div class="row pt-3">
				<div class="col-sm-10 col-md-10 col-lg-10 pb-1"><div class="rounded p-2" style="background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; "><a href="../../../../../assets/support/api_upload_attachment_show.php?name=new_name" target="_blank"><i class="fa-light fa-file fa-2xl fs-22" style="color: #d6960a;"></i> <span style="color:#268ecd;">ProcurEngine_Introduction_20230805_v1.00.pdf</span></a></div></div>
				<div class="col-sm-10 col-md-10 col-lg-10 pb-1"><div class="rounded p-2" style="background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; "><a href="../../../../../assets/support/api_upload_attachment_show.php?name=new_name" target="_blank"><i class="fa-light fa-file fa-2xl fs-22" style="color: #d6960a;"></i> <span style="color:#268ecd;">ProcurEngine_Introduction_20230805_v1.00.pdf</span></a></div></div>
				<div class="col-sm-10 col-md-10 col-lg-10 pb-1"><div class="rounded p-2" style="background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; "><a href="../../../../../assets/support/api_upload_attachment_show.php?name=new_name" target="_blank"><i class="fa-light fa-file fa-2xl fs-22" style="color: #d6960a;"></i> <span style="color:#268ecd;">ProcurEngine_Introduction_20230805_v1.00.pdf</span></a></div></div>


				</div>
			</div>
			
				
			</div>
			<div class="col-1"></div>	
			<div class="vertical-line" style="height: 350px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
			<?php if($res->att_response == 1){ ?>
			<div class="col-5 ml-5 p-0">
			<h1 class="m-0 p-0  fs-22">Response to <?=$res->section_name;?></h1>
			<p class="p-0 mt-3 fs-18 <? if($res->is_required==1){ echo 'req-input'; }?>"  > Attachments</p>
			<div class="attachment-toggle">
								
				
							<span class="attachment-toggle-add-file icon-search fs-14" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">File</span>
							<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
							<span class="attachment-toggle-add-url icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Url</span>
							<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
							<span class="attachment-toggle-add-text icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Text</span>
		
						
						<div class="fileuploadcontainer" >
									
							<form  id="attachmentuploadForm" enctype="multipart/form-data">
							<input type="hidden" name="master_id" value="<?=$_SESSION[$unique]?>">
							<input type="hidden" name="tr_from" value="sourcing_terms_condition">
							<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
							<input type="hidden" name="motherContainer" value="fileuploadcontainer">
							<input type="hidden" name="datashowContainer" value="attachmentshowcontainer">
							<div class="attachment-icon-close-container">
								<i class="attachment-toggle-add-file fa fa-fw fa-close"></i>
							</div>
							<div id="dropArea" class="drop-area">
							<!-- <label for="imageInput" class="btn btn-info">Browse</label> -->
							<input  type="file" name="eprocfiles[]" id="imageInput" accept="*/*" multiple>
								<div align="center" id="filepercentageandloader" class="filepercentageandloader" style="display: none !important;">
								</div>
								
						
							<div class="drop-area2">
								<div align="center">
								<p class="m-0">Drag & Drop files here</p>
								<i class="fa-light fa-cloud-arrow-up fa-2xl"></i>
								</div>
							
							</div>
							
							</div>
							<input type="checkbox" name="sendtosuppliercheckbox" id="sendtosuppliercheckbox" checked>
							<label for="sendtosuppliercheckbox">Send to Supplier</label>
								<button type="submit" class="d-none"  name="submit" value="Go" class="attachment-toggle-add-file"><i class="fa fa-fw fa-search"></i></button>
							
							</form>
						</div>
										
										<div class="attachmenturluploadcontainer" >
									
											<form  id="attachmenturluploadForm1" enctype="multipart/form-data">
											<input type="hidden" name="master_id" value="<?=$_SESSION[$unique]?>">
											<input type="hidden" name="tr_from" value="sourcing_terms_condition">
											<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
											<input type="hidden" name="motherContainer" value="ttttttttttt">
											<input type="hidden" name="datashowContainer" value="attachmentUrlshowcontainer">
											
											<div class="attachment-icon-close-container">
												<i class="attachment-toggle-add-url fa fa-fw fa-close"></i>
											</div>
											<!-- <i class="attachment-toggle-add-url fa fa-fw  fa-close"></i> -->
											<p>Add Your URL here</p>
											<input  type="text" name="attachmenturlinput" id="attachmenturlinput">
											
											<input type="checkbox" name="sendtosuppliercheckbox" id="sendtosuppliercheckbox" checked>
												<label for="sendtosuppliercheckbox">Send to Supplier</label><br>
												<button type="submit"  name="submit" value="Go" class="attachment-toggle-add-file btn btn-info">ADD</button>
											
											</form>
										</div>
							<div class="attachmenttextuploadcontainer" >
									
							<form  id="attachmenttextuploadForm" enctype="multipart/form-data">
							<input type="hidden" name="master_id" value="<?=$_SESSION[$unique]?>">
							<input type="hidden" name="tr_from" value="sourcing_terms_condition">
							<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
							<input type="hidden" name="motherContainer" value="attachmenttextuploadcontainer">
							<input type="hidden" name="datashowContainer" value="attachmentTextshowcontainer">
							
							<div class="attachment-icon-close-container">
								<i class="attachment-toggle-add-text fa fa-fw fa-close"></i>
							</div> 
							<!-- <i class="attachment-toggle-add-text fa fa-fw  fa-close"></i> -->
							<p>Add Your Text here</p>
							<input  type="text" name="attachmenttextinput" id="attachmenttextinput">
							
							<input type="checkbox" name="sendtosuppliercheckbox" id="sendtosuppliercheckbox" checked>
								<label for="sendtosuppliercheckbox">Send to Supplier</label><br>
								<button type="submit"  name="submit" value="Go" class="attachment-toggle-add-file btn btn-info">ADD</button>
							
							</form>
						</div>
							<div class="attachmentshowcontainer container row m-0">
							
							</div>
							<div class="attachmentUrlshowcontainer container row m-0">
							
							
							</div>
							<div class="attachmentTextshowcontainer container row m-0">
							
							
							</div>
					</div>
			<? } ?>
		</div>
		</div>
	<? } ?>	
<!-------------------------------------------------------------------------------------------------------------------->		
	
	

	<div class="col-12 pt-4 pb-4">
	   <h1 class="h1 m-0 p-0 pt-4 pl-3" style="font-size: 30px !important;"><i class="fa-thin fa-file-lines" style="color: #eb7100; font-size: 30px !important;"></i>  Forms </h1>
		<hr style="height:1px;border:none;color:#333;background-color:#333;">
		
		<div class="pt-1 col-sm-12">
<?php
 echo $sql = 'select d.* from rfq_form_details d where   rfq_no="'.$_GET['rfq_no'].'" group by form_no ';
  $qry = db_query($sql);
  while($res = mysqli_fetch_object($qry)){
?> 
		<div class="row">
			<form action="" method="post" class="col-sm-8" >
				<table width="100%" cellpadding="5" cellspacing="2">
					 <thead>
					  <tr>
						<th>Dropdown-<?=$res->form_no?></th>
						<th></th>
					  </tr>
					 </thead>
					 
					 <tbody>
					 <?php
					  $sql1 = 'select d.* from rfq_form_details d where   rfq_no="'.$_GET['rfq_no'].'" and form_no="'.$res->form_no.'" ';
					  $qry1 = db_query($sql1);
					  while($res1 = mysqli_fetch_object($qry1)){
					?> 
					   <tr>
						 <td><?=$res1->lebel?></td>
						 <td><input type="text" name="lebel_<?=$unique_no?>" id="dropdown_name"/></td>
					   </tr>
					 <? } ?>  
					  <!-- <tr>
						 <td>Required</td>
						 <td><input type="checkbox" name="is_required_<?=$unique_no?>" value="1" id="is_required"/></td>
					   </tr>
					   
					   <tr>
						 <td>Hint or Additional Text</td>
						 <td><textarea name="dropdown_hint" id="hint_<?=$unique_no?>"></textarea></td>
					   </tr>
					   
					   <tr>
						 <td>Default Value</td>
						 <td><input type="text" name="default_value_<?=$unique_no?>" id="default_value"/></td>
					   </tr>
					   
					   <tr>
						 <td>Option-1</td>
						 <td><input type="text" name="option_1_<?=$unique_no?>" id="option_1"/></td>
					   </tr>
					   
					   <tr>
						 <td>Option-2</td>
						 <td><input type="text" name="option_2_<?=$unique_no?>" id="option_2"/></td>
					   </tr>-->
					   
					   
					   
					 </tbody>
					</table>
				
				<div align="right" class="w-100">
				<button type="button" name="more_option" class="btn1 btn1-bg-update" onClick="select_html('Dropdown','remove');">Save</button></div>
			</form>
		</div>
<? } ?>	

	
	</div>	
		
	</div>
	
	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><i class="fa-solid fa-list"></i> Items and Services</h1>
		<hr class="m-3" />
		
		<div class="pt-1">
		
  	    <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Name</th>
                        <th>Item Description</th>
						<th>My Capacity</th>
                        <th>Expected Qty</th>
						<th>MY Price</th>
						<th>Price x Expected Qty</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					<?php
						  $sql = 'select d.*, i.item_name from rfq_item_details d, item_info i where i.item_id=d.item_id and  rfq_no="'.$_GET['rfq_no'].'" ';
						  $qry = db_query($sql);
						  while($res = mysqli_fetch_object($qry)){
					?> 
					    <tr>
							<td><?=$res->item_name?></td>
							<td><?=$res->item_desc?></td>
							<td><input type="number" id="capacity<?=$res->id?>" required name="capacity<?=$res->id?>" value="" ></td>
                            <td><?=$res->expected_qty?></td>
							<td><input type="number" id="vendor_price<?=$res->id?>" required name="vendor_price<?=$res->id?>" onkeyup="cal(<?=$res->id?>)" value="" >
								<input type="hidden" id="expected_qty_<?=$res->id?>"  name="expected_qty_<?=$res->id?>" value="<?=$res->expected_qty?>" >
							</td>
							<td><input type="number" id="vendor_total_amount<?=$res->id?>" readonly name="vendor_total_amount<?=$res->id?>" value="" ></td>
                        </tr>	
					<? } ?>							
					</tbody>
                </table>
  			
 
  
  
  </div>
  
  	<div class="mt-5" align="center">
		<button class="btn1 btn1-bg-update active" type="submit" name="vendor_item_response" id="vendor_item_response" >Submit Response</button>
	</div>
	</div>
	
	</div>
	
				  
	</div> 
	
	</form>	
		
		


</div>



</div>


 <script>
  	function cal(val){
		var price = document.getElementById('vendor_price'+val).value*1;
		var qty = document.getElementById('expected_qty_'+val).value*1;
		document.getElementById('vendor_total_amount'+val).value=(price*qty);
	}
  </script>
<script>
function remove_form(rfq_no,form_id,type,rfq){
    var type = form_id+'##'+type+'##'+rfq;
	getData2('first_response_ajax.php','form_details',rfq_no,type);
}
</script>




<script>


$('.attachment-toggle .attachment-toggle-add-file').click(function(e) {
   
  var $container = $(this).closest('.attachment-toggle').children('.fileuploadcontainer');

  if ($container.hasClass('fileuploadcontaineropened')) {
    // If already opened, close it
    $container.removeClass('fileuploadcontaineropened');
  } else {
   
    // Close all other containers
    $('.fileuploadcontaineropened').removeClass('fileuploadcontaineropened');
    // Open the clicked container
    $container.addClass('fileuploadcontaineropened');
    // Focus on input field

  }

});
$('.attachment-toggle .attachment-toggle-add-url').click(function(e) {
   
  var $container = $(this).closest('.attachment-toggle').children('.attachmenturluploadcontainer');
  
  if ($container.hasClass('fileuploadcontaineropened')) {
    // If already opened, close it
    $container.removeClass('fileuploadcontaineropened');
  } else {

    // Close all other containers
    $('.fileuploadcontaineropened').removeClass('fileuploadcontaineropened');
    // Open the clicked container
    $container.addClass('fileuploadcontaineropened');
    // Focus on input field

  }

});
$('.attachment-toggle .attachment-toggle-add-text').click(function(e) {
   
  var $container = $(this).closest('.attachment-toggle').children('.attachmenttextuploadcontainer');
  
  if ($container.hasClass('fileuploadcontaineropened')) {
    // If already opened, close it
    $container.removeClass('fileuploadcontaineropened');
  } else {

    // Close all other containers
    $('.fileuploadcontaineropened').removeClass('fileuploadcontaineropened');
    // Open the clicked container
    $container.addClass('fileuploadcontaineropened');
    // Focus on input field

  }

});
$('.fileuploadcontainer .attachment-toggle-add-file').click(function(e) {

  var $container = $(this).closest('.attachment-toggle').next('.fileuploadcontainer');

  if ($container.hasClass('fileuploadcontaineropened')) {
    // If already opened, close it
    $container.removeClass('fileuploadcontaineropened');
  } else {
    
    // Close all other containers
    $('.fileuploadcontaineropened').removeClass('fileuploadcontaineropened');
    // Open the clicked container
    $container.addClass('fileuploadcontaineropened');
    // Focus on input field

  }

});


$('.fileuploadcontainer input[type="file"]').on('input', function() {
    var $form = $(this).closest('form');
    $form.trigger('submit');
});


$('.fileuploadcontainer form').submit(function (e) {
e.preventDefault();

$('.filepercentageandloader').css('display', 'block');
$('.drop-area2').css('display', 'none');

var formId = $(this).attr('id');
var $container = $(this).closest('.attachment-toggle').find('.attachmentshowcontainer');
var $mothercontainer = $(this).closest('.attachment-toggle').find('.fileuploadcontainer');




var formData = new FormData(this);
    var motherContainerValue = formData.get('motherContainer');
    var datashowContainerValue = formData.get('datashowContainer');
    var progressBarContainer = $('.filepercentageandloader');


        formData.getAll('eprocfiles[]').forEach(function (file, index) {
            // Create a new progress bar for this file
            var fileProgressBar = $('<div class="rounded " style="margin-top: 10px !important; width: 100% !important; height: 70px !important; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6 !important;"><span>'+ file.name+'</span><div class="d-flex justify-content-around align-items-center "><div class="lds-spinner" style="position: relative !important; top: -5px !important;"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div><div class="progress " style="width: 70% !important; height: 12px !important;"><div class="progress-bar"  role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div></div></div></div>');
            progressBarContainer.append(fileProgressBar)
})

var progressBar = $('.progress-bar');

$.ajax({
    url: 'https://robi.clouderp.com.bd/eProcurement_mod/api/new_api_file_upload.php',
    type: 'POST',
    data: formData,
    xhr: function () {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener("progress", function (evt) {
            if (evt.lengthComputable) {
                var percentComplete = (evt.loaded / evt.total) * 100;
                progressBar.width(percentComplete + '%');
                progressBar.attr('aria-valuenow', percentComplete);
                progressBar.text(percentComplete.toFixed(2) + '%');
            }
        }, false);
        return xhr;
    },
    success: function (responseData) {
       
      console.log(responseData);
		var responseObject = JSON.parse(responseData);

// Iterate over each response item
$.each(responseObject, function(index, item) {
	// Create a new card element
	var card = $('<div class="col-sm-10 col-md-10 col-lg-10 pb-1"><div class="rounded p-2" style="background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; "><a href="../../../../../assets/support/api_upload_attachment_show.php?name='+item.new_name+'" target="_blank"><i class="fa-light fa-file fa-2xl fs-22" style="color: #d6960a;"></i> <span>'+item.original_name+'</span></a><button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentseventinfo(this,\''+item.attachment_id+'\',\''+item.master_id+'\',\''+item.tr_from+'\',\''+item.entry_by+'\',\''+motherContainerValue+'\',\''+datashowContainerValue+'\')"><i class="fa-solid fa-xmark"></i></button></div></div>');
	$container.append(card);

    $mothercontainer.removeClass('fileuploadcontaineropened');

	$('.filepercentageandloader').empty();
	$('.filepercentageandloader').css('display', 'none');
    $('.drop-area2').css('display', 'block');

	
});
  


    },
    error: function (xhr, status, error) {
        console.error('Error uploading image:', error);
        $('#response').text('Error uploading image. Please try again.');
    },
    cache: false,
    contentType: false,
    processData: false
});
});

$('.attachmenturluploadcontainer form').submit(function (e) {
e.preventDefault();

var $container = $(this).closest('.attachment-toggle').find('.attachmentUrlshowcontainer');
var $mothercontainer = $(this).closest('.attachment-toggle').find('.attachmenturluploadcontainer');
console.log($mothercontainer);
console.log()
var formId = $(this).attr('id');
var formData = new FormData(this);
var motherContainerValue = formData.get('motherContainer');
var datashowContainerValue = formData.get('datashowContainer');


 


$.ajax({
    url: 'https://robi.clouderp.com.bd/eProcurement_mod/api/new_api_url_upload.php',
    type: 'POST',
    data: formData,

    success: function (responseData) {
   
     

		var responseObject = JSON.parse(responseData);
		

		var card = $('<div class="col-sm-10 col-md-10 col-lg-10 pb-1"><div class="rounded p-2" style=" word-break: break-all; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; "><a href="'+responseObject.url_data+'" target="_blank"><i class="fa-duotone fa-link fa-2xl" style="--fa-primary-color: #d6960a; --fa-secondary-color: #d6960a;"></i><span>'+responseObject.url_data+'</span></a><button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentURLseventinfo(this,\''+responseObject.attachment_id+'\',\''+responseObject.master_id+'\',\''+responseObject.tr_from+'\',\''+responseObject.entry_by+'\',\''+motherContainerValue+'\',\''+datashowContainerValue+'\')"><i class="fa-solid fa-xmark"></i></button></div></div>');
		$container.append(card);
		$mothercontainer.removeClass('fileuploadcontaineropened');
    $('.fileuploadcontaineropened').removeClass('fileuploadcontaineropened');
		

    },
    error: function (xhr, status, error) {
        console.error('Error uploading image:', error);
        $('#response').text('Error uploading image. Please try again.');
    },
    cache: false,
    contentType: false,
    processData: false
});
});

$('.attachmenttextuploadcontainer form').submit(function (e) {
e.preventDefault();

var $container = $(this).closest('.attachment-toggle').find('.attachmentTextshowcontainer');
var $mothercontainer = $(this).closest('.attachment-toggle').find('.attachmenttextuploadcontainer');

var formId = $(this).attr('id');
var formData = new FormData(this);
var motherContainerValue = formData.get('motherContainer');
var datashowContainerValue = formData.get('datashowContainer');
 


$.ajax({
    url: 'https://robi.clouderp.com.bd/eProcurement_mod/api/new_api_text_upload.php',
    type: 'POST',
    data: formData,

    success: function (responseData) {
       
        

		var responseObject = JSON.parse(responseData);

		var card = $('<div class="col-sm-12 col-md-12 col-lg-12 pb-1"><div class="rounded p-2" style=" word-break: break-all; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; "><span><i class="fa-solid fa-text-size fa-xl" style="color: #df5c16;"></i><span> '+responseObject.text_data+'</span></span><button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentTextseventinfo(this,\''+responseObject.attachment_id+'\',\''+responseObject.master_id+'\',\''+responseObject.tr_from+'\',\''+responseObject.entry_by+'\',\''+motherContainerValue+'\',\''+datashowContainerValue+'\')"><i class="fa-solid fa-xmark"></i></button></div></div>');
		$container.append(card);
		$mothercontainer.removeClass('fileuploadcontaineropened');
    $('.fileuploadcontaineropened').removeClass('fileuploadcontaineropened');


    },
    error: function (xhr, status, error) {
        console.error('Error uploading image:', error);
        $('#response').text('Error uploading image. Please try again.');
    },
    cache: false,
    contentType: false,
    processData: false
});
});

function deleteAttachmentseventinfo(button,attachmentid, masterId, trFrom, entryBy,motherContainerValue,datashowContainerValue) {
  
  var $attachmentcontainershow = $(button).closest('.attachmentshowcontainer');
  // Find the .attachmentshowcontainer within the same parent level as .attachment-toggle
  


    $.ajax({
        url: 'https://robi.clouderp.com.bd/eProcurement_mod/api/api_attachment_delete.php',
        type: 'POST',
        data: JSON.stringify({
        attachmentid: attachmentid,
        masterId: masterId,
        trFrom: trFrom,
        entryBy: entryBy
    }),
        success: function(responseData) {
            
			var responseObject = JSON.parse(responseData);
			$attachmentcontainershow.empty();


// Iterate over each response item
		$.each(responseObject, function(index, item) {
			// Create a new card element
			var card = $('<div class="col-sm-10 col-md-10 col-lg-10 pb-1"><div class="rounded p-2" style="background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; "><a href="../../../../../assets/support/api_upload_attachment_show.php?name='+item.new_name+'" target="_blank"><i class="fa-light fa-file fa-2xl fs-22" style="color: #d6960a;"></i> <span>'+item.original_name+'</span></a><button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentseventinfo(this,\''+item.attachment_id+'\',\''+item.master_id+'\',\''+item.tr_from+'\',\''+item.entry_by+'\',\''+motherContainerValue+'\',\''+datashowContainerValue+'\')"><i class="fa-solid fa-xmark"></i></button></div></div>');
            
			$attachmentcontainershow.append(card);
		})
            // Handle the response data here
        },
        error: function(xhr, status, error) {
            console.error('Error uploading image:', error);
            $('#response').text('Error uploading image. Please try again.');
        },
       
    });
}
function deleteAttachmentURLseventinfo(button,attachmentid, masterId, trFrom, entryBy,motherContainerValue,datashowContainerValue) {
  var $attachmentcontainershow = $(button).closest('.attachmentUrlshowcontainer');
 
    $.ajax({
        url: 'https://robi.clouderp.com.bd/eProcurement_mod/api/api_attachment_url_delete.php',
        type: 'POST',
        data: JSON.stringify({
        attachmentid: attachmentid,
        masterId: masterId,
        trFrom: trFrom,
        entryBy: entryBy
    }),
        success: function(responseData) {
           console.log(responseData);
			var responseObject = JSON.parse(responseData);
			$attachmentcontainershow.empty();


// Iterate over each response item
		$.each(responseObject, function(index, item) {
			// Create a new card element
			var card = $('<div class="col-sm-10 col-md-10 col-lg-10 pb-1"><div class="rounded p-2" style=" word-break: break-all; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; "><a href="'+item.url_data+'" target="_blank"><i class="fa-duotone fa-link fa-2xl" style="--fa-primary-color: #d6960a; --fa-secondary-color: #d6960a;"></i><span>'+item.url_data+'</span></a><button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentURLseventinfo(this,\''+item.attachment_id+'\',\''+item.master_id+'\',\''+item.tr_from+'\',\''+item.entry_by+'\',\''+motherContainerValue+'\',\''+datashowContainerValue+'\')"><i class="fa-solid fa-xmark"></i></button></div></div>');            
			$attachmentcontainershow.append(card);
		})
            // Handle the response data here
        },
        error: function(xhr, status, error) {
            console.error('Error uploading image:', error);
            $('#response').text('Error uploading image. Please try again.');
        },
       
    });
}

function deleteAttachmentTextseventinfo(button,attachmentid, masterId, trFrom, entryBy,motherContainerValue,datashowContainerValue) {
  var $attachmentcontainershow = $(button).closest('.attachmentTextshowcontainer');

    $.ajax({
        url: 'https://robi.clouderp.com.bd/eProcurement_mod/api/api_attachment_text_delete.php',
        type: 'POST',
        data: JSON.stringify({
        attachmentid: attachmentid,
        masterId: masterId,
        trFrom: trFrom,
        entryBy: entryBy
    }),
        success: function(responseData) {
            
			var responseObject = JSON.parse(responseData);
			$attachmentcontainershow.empty();


// Iterate over each response item
		$.each(responseObject, function(index, item) {
			// Create a new card element
			var card = $('<div class="col-sm-12 col-md-12 col-lg-12 pb-1"><div class="rounded p-2" style=" height: 40px !important; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; "><span><i class="fa-solid fa-text-size fa-xl" style="color: #df5c16;"></i><span> '+item.text_data+'</span></span><button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentTextseventinfo(this,\''+item.attachment_id+'\',\''+item.master_id+'\',\''+item.tr_from+'\',\''+item.entry_by+'\',\''+motherContainerValue+'\',\''+datashowContainerValue+'\')"><i class="fa-solid fa-xmark"></i></button></div></div>');            
			$attachmentcontainershow.append(card);
		})
            // Handle the response data here
        },
        error: function(xhr, status, error) {
            console.error('Error uploading image:', error);
            $('#response').text('Error uploading image. Please try again.');
        },
       
    });
}


</script>



<!--this code for clock only start-->
<script>
    // Fetch the countdown date from PHP
    const countdownDate = new Date("<?php echo $rfq->eventEndAt; ?>").getTime();

    const countdownTimer = setInterval(function() {
      const now = new Date().getTime();
      const distance = countdownDate - now;

      const days = Math.floor(distance / (1000 * 60 * 60 * 24));
      const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

      document.getElementById("days").innerText = formatTime(days);
      document.getElementById("hours").innerText = formatTime(hours);

      if (distance < 0) {
        clearInterval(countdownTimer);
        document.getElementById("days").innerText = "00";
        document.getElementById("hours").innerText = "00";
      }
    }, 1000);

    function formatTime(time) {
      return time < 10 ? 0${time} : time;
    }
  </script>
<!--this code for clock only end-->


<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>