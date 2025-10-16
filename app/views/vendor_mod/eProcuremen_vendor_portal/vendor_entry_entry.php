<?php
require_once "../../../controllers/routing/layout.top.php";
$title='eProcurement';

$all_yes=false;
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
do_calander("#f_date");
do_calander("#t_date");
$_POST['response_date']=date('Y-m-d');
$unique='rfq_no';
$table_master='rfq_master';
$_POST['entry_at']=date('Y-m-d H:i:s');
$_POST['entry_by']=$_SESSION['user']['id'];

$now = date('Y-m-d H:i:s');




if($_GET[$unique]>0){
	$_SESSION[$unique] = $_GET[$unique];
}

$rfq_master2 = find_all_field('rfq_master','','rfq_no="'.$_SESSION[$unique].'"');

if($_GET['section_id']>0){
	$_SESSION['response_id'] = $_GET['section_id'];
	header('Location:vendor_entry_entry.php?tab3');
}

        $now = date('Y-m-d H:i:s');
		$sql1l = 'insert into vendor_entry_log (rfq_no, field_name, field_value, vendor_id, entry_at) 
					values ('.$_SESSION[$unique].',"Last Seen", "'.$now.'","'.$_SESSION['vendor']['id'].'", "'.$now.'")';
		db_query($sql1l);

$response_id =0;

$rfq_no = $_SESSION[$unique];

$vendor = $_SESSION['vendor']['id'];
//unset($_SESSION['response_id']);

/*if($_GET['mode']=='edit'){
	$upQl = 'update rfq_vendor_response set status = "MANUAL" where rfq_no="'.$_GET['rfq_no'].'" and id="'.$_GET['section_id'].'" ';
	db_query($upQl);
}*/

if(isset($_POST['enter_response'])){
   
	if($_SESSION['response_id']>0){
	    $response_id = $_SESSION['response_id'];
	}else{
	    $prev_response_id = find_a_field('rfq_vendor_response','id','vendor_id="'.$vendor.'" and rfq_no="'.$_SESSION[$unique].'" ');
		
		$Crud   = new Crud("rfq_vendor_response");
		$_POST['rfq_no']=$_SESSION[$unique];
		$_POST['vendor_id']=$vendor;
		$_POST['response_name']=find_a_field('vendor','vendor_name','vendor_id="'.$vendor.'"');
		$response_id = $_SESSION['response_id'] = $Crud->insert();
		
		$sql = 'insert into rfq_documents_information (rfq_no,tr_from,folder_path,	original_name, new_name, terms_accept, section_id, entry_by)
		select DISTINCT rfq_no,tr_from,folder_path,	original_name, new_name, terms_accept, '.$response_id.', entry_by  from rfq_documents_information  where tr_from like "sourcing_attachment_response%"  and entry_by="'.$_SESSION['user']['id'].'" and rfq_no="'.$_SESSION[$unique].'"';
		
		db_query($sql);
		
		$sql1 = 'insert into rfq_documents_url_information (rfq_no,tr_from,attachment_url,	attachment_text, entry_by, section_id)
		select DISTINCT rfq_no,tr_from,attachment_url,	attachment_text, entry_by, '.$response_id.' from rfq_documents_url_information where 
		tr_from like "sourcing_attachment_response%"  and rfq_no="'.$_SESSION[$unique].'" and entry_by = "'.$_SESSION['user']['id'].'" ';
		db_query($sql1);
		
		$sql = 'insert into rfq_form_response (rfq_no,form_no,form_id,	vendor_id, value, section_id)
		select rfq_no,form_no,form_id,vendor_id,value,'.$response_id.' from rfq_form_response where   
		rfq_no="'.$rfq->rfq_no.'" and vendor_id = '.$vendor.' and section_id='.$response_id.' ';
		db_query($sql);
		
		$sql1l = 'insert into vendor_entry_log (rfq_no, response_no, field_name, field_value, vendor_id, entry_at) 
				values ('.$_SESSION[$unique].','.$response_id.',"Enter Response", "Enter response","'.$_SESSION['user']['id'].'", "'.$now.'")';
		db_query($sql1l);
		
	}
	
	
	
	header('Location:vendor_entry_entry.php?tab3');
}
if($_SESSION['response_id']>0){
	$response_id = $_SESSION['response_id']; 
 }
 
$rfq_count = find_a_field('rfq_vendor_details','count(id)','vendor_id="'.$vendor.'" and rfq_no="'.$_SESSION[$unique].'" ');
$want_to_participate = find_a_field('rfq_vendor_details','want_to_participate','vendor_id="'.$vendor.'" and rfq_no="'.$_SESSION[$unique].'" ');

	if($rfq_count>0){
		$rfq = find_all_field('rfq_master','','rfq_no="'.$_SESSION[$unique].'"');
		
		$now = date('Y-m-d H:i:s');
		$start = date('Y-m-d');
		$eventStart = strtotime($data->eventStartDate);
		$startString = strtotime($start);
		
		$eventEnd = strtotime($data->eventEndDate." ".$data->eventEndTime);
		$nowString = strtotime($now);
	
		$response_data = find_a_field('rfq_vendor_response','count(id)','vendor_id="'.$vendor.'" and rfq_no="'.$data->rfq_no.'" and status = "SUBMITED" ');
		
		if($eventStart<=$startString && $eventEnd>=$nowString && $rfq->status=="CHECKED"){
		  if($rfq->multiple_response=='no' && $response_data>0){
				unset($_SESSION[$unique]);
				header('Location:vendor_entry.php');
		  }
		}else{
			unset($_SESSION[$unique]);
			header('Location:vendor_entry.php');
		}
		
	}else{
		unset($_SESSION[$unique]);
		header('Location:vendor_entry.php');
	}	
$provide_by = find_a_field('user_activity_management','fname','user_id="'.$rfq->entry_by.'"');

if(isset($_POST['vendor_response'])){
        
		if($_SESSION[$unique]>0){ 
		$rfq_response_count = 0;
		$rfq_response_count = find_a_field('rfq_vendor_response','response_count','vendor_id="'.$vendor.'" and rfq_no="'.$_SESSION[$unique].'" ');
        $delete = 'delete from rfq_vendor_response where rfq_no="'.$_SESSION[$unique].'" and vendor_id="'.$vendor.'"';
		db_query($delete);
		$Crud   = new Crud("rfq_vendor_response");
		$_POST['rfq_no']=$_SESSION[$unique];
		$_POST['vendor_id']=$vendor;
		$_POST['response_count']=$rfq_response_count+1;
		
		$sql = 'select * from rfq_doc_details where 1 and rfq_no="'.$_SESSION[$unique].'"';
		$qry = db_query($sql);
		while($doc=mysqli_fetch_object($qry)){
		if($_FILES['vendor_att'.$doc->id]['name']!=''){
		$_POST['file_name']=$doc->section_name;
		$_POST['event_doc_details_id']=$doc->id;
		$_POST['att_file'] = upload_file("rfq","vendor_att".$doc->id."",time());
		$Crud->insert();
		}
		}
		}

}
if(isset($_POST['response_reason_textinput_buttonfire'])){
        
	if($_SESSION[$unique]>0){ 

	$update = 'update rfq_vendor_details set reject_reason="'.$_POST['response_reason_textinput'].'",reject_status="Yes" where rfq_no="'.$_SESSION[$unique].'" and vendor_id="'.$vendor.'"';
	db_query($update);
	
	//////////
	
		$sql1l = 'insert into vendor_entry_log (rfq_no, field_name, field_value, vendor_id, entry_at) 
				values ('.$_SESSION[$unique].',"Submit Acceptance", "I not intend to participate in this event for '.$_POST['response_reason_textinput'].'",
				"'.$_SESSION[$unique].'", "'.$now.'")';
		db_query($sql1l);
	
	/////////

	include 'event_reject_mail_sender.php';
    

	}

}



if(isset($_POST['vendor_item_response'])){
        
		if($_SESSION[$unique]>0){
		$rfq_response_count = 0;
		$rfq_response_count = find_a_field('rfq_vendor_response','response_count','vendor_id="'.$vendor.'" and rfq_no="'.$_SESSION[$unique].'" ')+1;
		
		$Crud   = new Crud("rfq_vendor_item_response");
		$_POST['rfq_no']=$_SESSION[$unique];
		$_POST['vendor_id']=$vendor;
		$_POST['response_count']=$rfq_response_count+1;
		
		$sql = 'select * from rfq_item_details where 1 and rfq_no="'.$_SESSION[$unique].'"';
		$qry = db_query($sql);
		while($doc=mysqli_fetch_object($qry)){
		if($_POST['vendor_price'.$doc->id]!=''){
		$_POST['capacity']=$_POST['capacity'.$doc->id];
		$_POST['expected_qty']=$doc->expected_qty;
		$_POST['unit_price']=$_POST['vendor_price'.$doc->id];
		$_POST['total_amount']=$_POST['vendor_total_amount'.$doc->id];
		$_POST['need_by']=$_POST['need_by'.$doc->id];
		$_POST['item_id']=$doc->item_id;
		$_POST['section_id'] = $response_id;
		$_POST['event_item_details_id']=$doc->id;
		//$Crud->insert();
		
		}
		}
		$_SESSION['msg'] = 'Response Submitted successfully';
		}
		
		unset($_SESSION[$unique]);
		unset($_SESSION['response_id']);
		header('Location:vendor_entry.php');

}

if(isset($_POST['terms_condition_response'])){
        $delete = 'delete from rfq_vendor_terms_condition where rfq_no="'.$_SESSION[$unique].'" and vendor_id="'.$vendor.'"';
		db_query($delete);
        $Crud = new Crud("rfq_vendor_terms_condition");
		$_POST['rfq_no']=$_SESSION[$unique];
		$_POST['vendor_id']=$vendor;
		$Crud->insert();
}

if(isset($_POST['confirm_response'])){
 $max_response = find_a_field('rfq_master','total_response','rfq_no="'.$_SESSION[$unique].'"')+1;
 $update = 'update rfq_master set total_response="'.$max_response.'" where rfq_no="'.$_SESSION[$unique].'"';
 db_query($update);
 header('location:vendor_entry.php');
}




			$sql = ' select count(tr_from) from rfq_documents_information where tr_from like "sourcing_terms_condition" and rfq_no='.$rfq->rfq_no;
			$query = db_query($sql);
			$result = mysqli_fetch_row($query);
			$required = $result[0];
			
			$sql = ' select count(tr_from) from rfq_documents_url_information where tr_from like "sourcing_terms_condition" and rfq_no='.$rfq->rfq_no;
			$query = db_query($sql);
			$result = mysqli_fetch_row($query);
			$required += $result[0];
			
			$sql = ' select count(id) from rfq_vendor_terms_condition where condition_1 = 1 and vendor_id='.$vendor.' and rfq_no='.$rfq->rfq_no;
			$query = db_query($sql);
			$result = mysqli_fetch_row($query);
			$completed = $result[0];
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
    border-width: 24px 0 41px 50px;
    border-color: transparent transparent transparent #dfe3e3;
}

</style>




<!--This css for clock start-->
<!--this cdn is for clock font google api-->

  <style>
.ep-clock-bg{
	background-color:#f2f2f2 !important;
	border-radius: 15px;
	box-shadow: inset 4px 4px 5px rgba(255,255,255,0.3), 
		  inset -4px -4px 5px rgba(0,0,0,0.1), 10px 40px 40px rgba(0,0,0,0.1);
		      width: 368px;
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
    width: 255px;
    border-radius: 10px;
    align-items: center;
    background-color: #00bcd4;
    color: #fff;
	text-align: center;
	 
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
#hours,
#minutes {
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
	<div class="col-sm-8 col-lg-8 col-md-8 col-8">
	
		<div class="mt-1 w-100 pr-2">
		
				<form action="vendor_entry.php" method="post">
					<button class="btn1 btn1-bg-hrm" type="submit">Back to Home</button>
				</form>
			
		</div>
		
		<div class="pt-4" style=" font-size: 18px; padding-left: 2%;">
		<?=$rfq->event_name;?> -Event #<?=$rfq->rfq_version;?><span>(<? if($rfq->status=='CHECKED') {echo 'Active';} else {echo 'In Active';}?>)</span></div>
		<? $_SESSION['event_name']=$rfq->event_name?>
	</div>
	<div class="col-sm-4 col-lg-4 col-md-4 col-4" id="fixed">
	<div class="d-flex justify-content-center align-items-center ep-clock-bg  p-3">
		<span class="ep-titel">Event End</span>
			<?
		?>
			
			
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
					<div class="countdown-item">
					  <span id="colon" class="blinking">:</span>
					</div>
					
					<div class="countdown-item">
					   <span id="minutes"></span>
					  <div class="countdown-label">Minutes</div>
					</div>
			  </div>
 
			
			
		</div>
	</div>
</div>





<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="settings-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="settings" aria-selected="true" onclick="settingF('tab1');">Event Info</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="timeline-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="timeline" aria-selected="false" onclick="settingF('tab2');">My Responses</a>
  </li>
  
  <li class="nav-item">
    <?php if($required==$completed){ ?>
    <a class="nav-link" id="details-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="details" aria-selected="false" onclick="settingF('tab3');">Details</a>
  	<?php } ?>
  </li>
  <li style="hidden" class="nav-item ">
    <?php if($required==$completed && $rfq_master2->rfx_stage == 'Auction'){ ?>
    <a class="nav-link" id="bidconsole-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="bidconsole" aria-selected="false" onclick="settingF('tab4');">Bid Console</a>
  	<?php } ?>
  </li>
  
</ul>


<div class="tab-content" id="myTabContent">

				                
  <!--1st tab -->
  <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="settings-tab">
  <p class="m-1 fs-14 p-4 description" style="line-height: 1.6rem !important; text-align: justify !important; font-weight: 400 !important; color: #2f2f2f !important;"> 
  
  	<?=find_a_field('rfq_vendor_massage','vendor_massage','1')?>
  
  </p>
  
  
  <div class="row m-0 p-0 pt-4">
<?if($rfq_master2->rfx_stage =='Auction'){?>
  <div class="col-12 pt-4 pb-4">
  <h1 class="h1 m-0 p-0 pt-4 pl-3" style="font-size: 30px !important;"><em class="fa-solid fa-check-to-slot" style="color: #eb7100; font-size: 30px !important;"></em>Auction Rules</h1>
  <hr style="height:1px;border:none;color:#333;background-color:#333;">
  <div class="pl-3 row">
		<div class="col-sm-6 col-md-6 col-lg-6">
		    <p>Specify how item bidding will begin and end</p>
			<p>Bid rank that triggers overtime </p>
			<p>Start overtime if bid submitted within minutes </p>
			<p>Overtime period </p>
			<p>Improve bid amount by (amount)</p>
			<p>Can participate submit tie bids </p>
			<p>Show participants responses to other participants </p>
			<p>Show Lead bid to all participants</p>
			<p>Restrict bid submission if bid is reduced by more than %</p>
		</div>
		<div class="col-sm-6 col-md-6 col-lg-6">
		    <p><?=$rfq_master2->lot_bidding?> <?if($rfq_master2->lot_bidding=='parallel'){echo '<abbr title="Bidder can bid in parallel for any item at any time during auction period"><em class="fa-solid fa-circle-exclamation"></em></abbr>';}?><?if($rfq_master2->lot_bidding=='serial'){echo '<abbr title="Bidder must bid one by one serially during auction period"><em class="fa-solid fa-circle-exclamation"></em></abbr>';}?></p>
			<?
$rankTriggers = $rfq_master2->rank_tringgers_overtime;

// Ensure the value is an integer
$rankTriggers = (int)$rankTriggers;

// Initialize an empty array to hold the rank labels
$ranks = [];

// Loop to generate the rank labels up to the value of $rankTriggers
for ($i = 1; $i <= $rankTriggers; $i++) {
    $ranks[] = "Rank $i";
}

// Join the rank labels with commas
$rankOutput = implode(', ', $ranks);
?>

<p><?= $rankOutput ?><abbr title="If Rank(s) stated above is changed, it will trigger overtime of bid"><em class="fa-solid fa-circle-exclamation"></em></abbr></p>

			<p><?=$rfq_master2->submitted_within_minutes?> Minutes</p>
			<p><?=$rfq_master2->overtime_period?> Minutes</p>
			<p><?=$rfq_master2->improve_bid_amt?> </p>
			<p><?=$rfq_master2->tie_bids?> </p>
			<p><?=$rfq_master2->show_responses_to_others?> </p>
			<p><?=$rfq_master2->show_lead_bid?> </p>
			<p><?=$rfq_master2->bid_improve_warning_percentage?>%</p>
		</div>

	</div>




	</div>
	<?}?>
  	<div class="col-12 pt-4 pb-4">
	

		<h1 class="h1 m-0 p-0 pt-4 pl-3" style="font-size: 30px !important;"><em class="fa-solid fa-check-to-slot" style="color: #eb7100; font-size: 30px !important;"></em> Accept Terms and Conditions </h1>
		<hr style="height:1px;border:none;color:#333;background-color:#333;">
		<?php
		  $sql = 'select * from rfq_vendor_terms_condition where vendor_id='.$vendor.' and  rfq_no="'.$_SESSION[$unique].'"';
		  $qry = db_query($sql);
		  while($res = mysqli_fetch_object($qry)){
		  
		    if($res->condition_2==1){
				
				$all_yes=false;
			}else{
				$all_yes=true;
			}
		  	$condition_1[$res->type][$res->details_id] = $res->condition_1;
		  	$condition_2[$res->type][$res->details_id] = $res->condition_2;
            
			
			$is_participate = $res->is_participate;
		     
		  }
		  
		 
		?>  
		 <?php
		  $sql = 'select * from rfq_documents_information where tr_from like "sourcing_terms_condition" and rfq_no="'.$_SESSION[$unique].'"';
		  $qry = db_query($sql);
		  while($res = mysqli_fetch_object($qry)){
		  
		   ?>
	 			<div class="allrowshow">
					<div class="pl-3 row">
							<div class="col-sm-16 col-md-6 col-lg-6">
								<p class="m-0" style="font-family: Helvetica,Arial,sans-serif !important; color: #333 !important;font-size: 18px !important; font-weight: 500 !important;">Terms and Conditions</p>
								<a href="../../../controllers/utilities/api_upload_attachment_show.php?name=<?php echo $res->new_name;?>&folder=sourcing_terms_condition&original_name=<?=$res->original_name?>" target="_blank" rel="noopener" style="font-family: Helvetica,Arial,sans-serif !important; color:#0094e4 !important"><?=$res->original_name?></a>
							</div>
							
						<div class="col-sm-16 col-md-6 col-lg-6">

							<h4 style="font-family: Helvetica,Arial,sans-serif !important; color: #333 !important;font-size: 18px !important; font-weight: 400 !important;">Do you accept these Terms and Conditions?</h4>
							<div class="form_element">
								<label class="inlineSelection" style="font-family: Helvetica,Arial,sans-serif !important; color: #60768a !important;font-size: 16px !important; font-weight: 400 !important;">
								<input type="radio" name="term_<?=$res->documents_id;?>"  <? if($condition_1['documents_information'][$res->documents_id]==1) {echo 'checked';}?> id="term_<?=$res->documents_id;?>_true" value="Yes" class="s-termAccept" <?=$disabled?>    onclick="remove_form(this.value,<?=$res->documents_id;?>,'file',<?=$rfq_no;?>)">
								Yes
								</label>
								<br>
								<label class="inlineSelection" style="font-family: Helvetica,Arial,sans-serif !important; color: #60768a !important;font-size: 16px !important; font-weight: 400 !important;">
								<input type="radio"  <? if($condition_2['documents_information'][$res->documents_id]==1) {echo 'checked';}?> name="term_<?=$res->documents_id;?>" id="term_<?=$res->documents_id;?>_false" value="No" class="s-termReject"  onclick="remove_form(this.value,<?=$res->documents_id;?>,'file',<?=$rfq_no;?>)">
								No
								</label>
							</div>


							</div>
						</div>	
				</div>
				
			<?php } ?>	
			
			
			
			<?php
		  $sql = 'select * from rfq_documents_url_information where tr_from like "sourcing_terms_condition" and rfq_no="'.$_SESSION[$unique].'"';
		  $qry = db_query($sql);
		  while($res = mysqli_fetch_object($qry)){
		  
		   ?>
	 			<div class="allrowshow row">
					<div class=" col-sm-6 col-md-6 col-lg-6 pl-3">
							<div class="container row m-0">
							
							<? if($res->attachment_url !=''){ ?>
								
							   <div class="col-sm-8 col-md-8 col-lg-8 pb-1">
									<div class="rounded p-2" style=" word-break: break-all; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
									<a href="<?=$res->attachment_url?>" target="_blank" rel="noopener"><em class="fa-solid fa-link fa-2xl" style="--fa-primary-color: #d6960a; --fa-secondary-color: #d6960a;"></em>
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
								<input type="radio" name="term_<?=$res->documents_url_id ;?>" <? if($condition_1['documents_url_information'][$res->documents_url_id]==1) {echo 'checked';}?> id="term_<?=$res->documents_url_id ;?>_true" value="Yes" class="s-termAccept" <?=$disabled?>   onclick="remove_form(this.value,<?=$res->documents_url_id ;?>,'text',<?=$rfq_no;?>)" >
								Yes
								</label>
								<br>
								<label class="inlineSelection" style="font-family: Helvetica,Arial,sans-serif !important; color: #60768a !important;font-size: 16px !important; font-weight: 400 !important;">
								<input type="radio" <? if($condition_2['documents_url_information'][$res->documents_url_id]==1) {echo 'checked';}?> name="term_<?=$res->documents_url_id ;?>" id="term_<?=$res->documents_url_id ;?>_false" value="No" class="s-termReject"  onclick="remove_form(this.value,<?=$res->documents_url_id ;?>,'text',<?=$rfq_no;?>)">
								No
								</label>
							</div>


							</div>
						</div>	
			<?php } ?>	

<h1 class="h1 m-0 p-0 pt-4 pl-3" style="font-size: 30px !important;"><em class="fa-regular fa-comment fa-5x" style="color: #eb7100; font-size: 30px !important;"></em> Do you intend to participate in this event? </h1>
<hr style="height:1px;border:none;color:#333;background-color:#333;">
<div class="form_element">
	                        
								<label class="inlineSelection" style="font-family: Helvetica,Arial,sans-serif !important; color: #60768a !important;font-size: 16px !important; font-weight: 400 !important;">
								<input type="radio" name="want_to_participate"  <? if($want_to_participate=='Yes') {echo 'checked';}?> id="want_to_participate" value="Yes" class="s-termAccept" <?=$disabled?>    onclick="want_to_participate_form(this.value,this)">
								I intend to participate in this event
								</label>
								<br>
								<label class="inlineSelection" style="font-family: Helvetica,Arial,sans-serif !important; color: #60768a !important;font-size: 16px !important; font-weight: 400 !important;">
								<input type="radio"  <? if($want_to_participate=='No') {echo 'checked';}?> name="want_to_participate" id="want_to_participate" value="No" class="s-termReject"  onclick="want_to_participate_form(this.value,this)">
								I not intend to participate in this event
								</label>
</div>
<div id="want_to_participate_show">
<?if($want_to_participate=='Yes'){?>
<div class="pl-3 row">
		<div class="col-sm-16 col-md-6 col-lg-6">

		<span style="font-family: Helvetica,Arial,sans-serif !important; color:">Robi will be notified of your intent to participate.</span>
	</div>
	<span id="form_details"></span>
</div>	
<span id="participate_button">
	<button class="btn1 btn1-bg-update" id="details-tab" data-toggle="tab" href="#tab3" role="tab"  onclick="is_participate('checked',<?=$rfq_no;?>)" aria-controls="details" aria-selected="false">Submit Acceptence</button>
</span>
<?}else if($want_to_participate=='No'){?>
	<form action="" method="post">
     <div class="row d-flex justify-content-center align-items-center">
	<textarea class="col-4" name="response_reason_textinput" id="response_reason_textinput" rows="10" required></textarea>
	<div class="col-1"></div>
	<button class="btn1 btn1-bg-update" type="submit" name="response_reason_textinput_buttonfire" onclick="event_reject_mail('hhhhhh')" id="details-tab">Enter Reason</button>
	</div>
</form>
<?}?>

</div>
<span id="reason_form"></span>
									
					</div>

  
<!--  stype 1 start-->
<div class="col-sm-12 row m-0 p-0 pt-4">
  	<div class="col-6 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-gear"></em> Event Information & Bidding Rules </h1>
		<hr style="height:1px;border:none;color:#333;background-color:#333;">
	  <div class="p-4" style="background-color: #f5f5f5; !important; ">
	   <p class="p-0 pl-3 ">    </p>
	    <?php if($rfq->multiple_response=='yes'){?>
			<p class="p-0 pl-3 m-0 bold">Allow multiple response <br /> Last submission will be considered for evaluation</p>
		<?php } ?>
		<?php if($rfq->hide_supplier_response=='yes'){?>
			<p class="p-0 pl-3 m-0 bold">Hide supplier response (sealed bid)</p>
		<?php } ?>
		<?php /*?><p class="p-0 pl-3 m-0 bold"><?php if($rfq->when_unseal=='manually'){ echo 'Unseal manually'; }elseif($rfq->when_unseal=='after_event_ends'){ echo 'Automaticall unseal when event ends';}?>   </p><?php */?>
		<?php if($rfq->respond_with_att_chat=='yes'){?>
			<p class="p-0 pl-3 m-0 bold">Allow Suppliers to respond with attachments in Massage centre</p>
		<?php } ?>
		<?php if($rfq->other_currency=='yes'){?>
			<p class="p-0 pl-3 m-0 bold">Allow Suppliers to bid in any of these currencies <br />
			<?php
				$sql_currency = 'select c.currency from rfq_multiple_currency m, currency_info c where m.currency_id=c.id and m.rfq_no='.$rfq->rfq_no.' ';
				$qry = db_query($sql_currency);
				while($res = mysqli_fetch_object($qry)){
					echo $res->currency.'<br>';
				}
			?>
			</p>
			
		<?php } ?>	
	  </div>

	</div>
	
	<div class="col-6  pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-gear"></em>  Attachments </h1>
		<hr style="height:1px;border:none;color:#333;background-color:#333;">
		
		<div class="attachment-toggle">
								
								
                               <!-- <span class="attachment-toggle-add-file icon-search fs-14" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">File</span>
								<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
								<span class="attachment-toggle-add-url icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Url</span>
								<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
								<span class="attachment-toggle-add-text icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Text</span>
           -->
          
          <div class="fileuploadcontainer" >
						
                <form  id="attachmentuploadFormxx" enctype="multipart/form-data">
                <input type="hidden" name="rfq_no" value="<?=$_SESSION[$unique]?>">
                <input type="hidden" name="tr_from" value="sourcing_terms_buery_attahment">
                <input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
                <input type="hidden" name="vendor_id" value="<?=$vendor?>">
                <input type="hidden" name="motherContainer" value="fileuploadcontainer">
                <input type="hidden" name="datashowContainer" value="attachmentshowcontainer">
                <div class="attachment-icon-close-container">
                  <em class="attachment-toggle-add-file fa fa-fw fa-close"></em>
                </div>
                <div id="dropArea" class="drop-area">
                
                <input  type="file" name="eprocfiles[]" id="imageInput" accept="*/*" multiple>
                  <div id="filepercentageandloader" class="filepercentageandloader" style="display: none !important;">
                  </div>
                  
          
                <div class="drop-area2">
                  <div>
                  <p class="m-0">Drag & Drop files here</p>
                  <em class="fa-solid fa-cloud-arrow-up fa-2xl"></em>
                  </div>
                
                </div>
                
              </div>

                  <button type="submit" class="d-none"  name="submit" value="Go" class="attachment-toggle-add-file"><em class="fa fa-fw fa-search"></em></button>
                
                </form>
          </div>
							
							<div class="attachmenturluploadcontainer" >
						
								<form  id="attachmenturluploadForm1" enctype="multipart/form-data">
								<input type="hidden" name="rfq_no" value="<?=$_SESSION[$unique]?>">
								<input type="hidden" name="tr_from" value="sourcing_terms_buery_url">
								<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
								<input type="hidden" name="motherContainer" value="ttttttttttt">
								<input type="hidden" name="datashowContainer" value="attachmentUrlshowcontainer">
								
								<div class="attachment-icon-close-container">
									<em class="attachment-toggle-add-url fa fa-fw fa-close"></em>
								</div>
								
								<p>Add Your URL here</p>
								<input  type="text" name="attachmenturlinput" id="attachmenturlinput">
								

								  <button type="submit"  name="submit" value="Go" class="attachment-toggle-add-file btn btn-info">ADD</button>
								
								</form>
							</div>
              <div class="attachmenttextuploadcontainer" >
						
                <form  id="attachmenttextuploadForm" enctype="multipart/form-data">
                <input type="hidden" name="rfq_no" value="<?=$_SESSION[$unique]?>">
                <input type="hidden" name="tr_from" value="sourcing_terms_buery_text">
                <input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
                <input type="hidden" name="motherContainer" value="attachmenttextuploadcontainer">
                <input type="hidden" name="datashowContainer" value="attachmentTextshowcontainer">
                
                <div class="attachment-icon-close-container">
                  <em class="attachment-toggle-add-text fa fa-fw fa-close"></em>
                </div> 
               
                <p>Add Your Text here</p>
                <textarea name="attachmenttextinput" id="attachmenttextinput" rows="10"></textarea>
                

                  <button type="submit"  name="submit" value="Go" class="attachment-toggle-add-file btn btn-info">ADD</button>
                
                </form>
            </div>
              
				
              </div>
              <div class="attachmentUrlshowcontainer container row m-0">
                
               
              </div>
              <div class="attachmentTextshowcontainer container row m-0">
                
              
              </div> 
     
						<div class="attachmentshowcontainer container row m-0">
						
						 <?php
		  $sql = 'select * from rfq_documents_information where tr_from like "sourcing_basic_settings" and rfq_no="'.$_SESSION[$unique].'"';
		  $qry = db_query($sql);
		  while($res = mysqli_fetch_object($qry)){
		  
		   ?>
	 			
				
				<div class="col-sm-10 col-md-10 col-lg-10 pb-1">
					<div class="rounded p-2" style="background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
						<a href="../../../controllers/utilities/api_upload_attachment_show.php?name=<?php echo $res->new_name;?>&folder=sourcing_basic_settings&original_name=<?=$res->original_name?>" 
						target="_blank" rel="noopener"><em class="fa-solid fa-file fa-2xl fs-22" style="color: #d6960a;"></em> 
						<span><?=$res->original_name?></span></a>
						<!-- <button type="button" style=" display: inline !important;" class="border-0" 
							onclick="deleteAttachmentseventinfo(this,'<?//=$res->documents_id?>', '<?//=$res->rfq_no?>', 'sourcing_terms_buery_attahment', '<?=$res->entry_by?>', 'fileuploadcontainer', 'attachmentshowcontainer')">
							<em class="fa-solid fa-xmark"></em>
						</button> -->
					</div> 
				</div>
				
				
				<hr class="m-3">
			<?php } ?>	
			
                        

                       </div>
			<div class="attachmentTextshowcontainer container row m-0">
          <?php
			  $sql = 'select * from rfq_documents_url_information where tr_from like "sourcing_basic_settings" and rfq_no="'.$_SESSION[$unique].'" and entry_by = "'.$_SESSION['user']['id'].'" ';
			  $qry = db_query($sql);
			  while($res = mysqli_fetch_object($qry)){
			  
		   ?>
		    <div class="col-sm-12 col-md-12 col-lg-12 pb-1">
		   		<div class="rounded p-2" style=" word-break: break-all; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
					<span><em class="fa-solid fa-envelope-open-text fa-xl" style="color: #d6960a;"></em>
						<span><?=$res->attachment_text?> </span></span>
						<!-- <button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentTextseventinfo(this,'<?=$res->documents_url_id?>', '<?=$res->rfq_no?>', 'sourcing_terms_buery_text', '<?=$res->entry_by?>', 'attachmenttextuploadcontainereventinfo','attachmentshowcontainereventinfo-text')">
							<em class="fa-solid fa-xmark"></em>
						</button> -->
				</div>
			</div>
		   <? } ?>

                        </div>
						<div class="attachmentUrlshowcontainer container row m-0">
                        <?php
						  $sql = 'select * from rfq_documents_url_information where tr_from like "sourcing_basic_settings" and rfq_no="'.$_SESSION[$unique].'" and entry_by = "'.$_SESSION['user']['id'].'" ';
						  $qry = db_query($sql);
						  while($res = mysqli_fetch_object($qry)){
					   ?> 
					   <div class="col-sm-8 col-md-8 col-lg-8 pb-1">
					   		<div class="rounded p-2" style="word-break: break-all; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
							<a href="<?=$res->attachment_url?>" target="_blank" rel="noopener"><em class="fa-solid fa-link fa-2xl" style="--fa-primary-color: #d6960a; --fa-secondary-color: #d6960a;"></em>
								<span><?=$res->attachment_url?></span></a>
									<!-- <button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentURLseventinfo(this,'<?=$res->documents_url_id?>' , '<?=$res->rfq_no?>', 'sourcing_terms_buery_url', '<?=$res->entry_by?>', 'attachmenturluploadcontainereventinfo','attachmentshowcontainereventinfo-url')"><em class="fa-solid fa-xmark"></em>
									</button> -->
							</div>
						</div>
					   
					   <? } ?>

                       </div>
					   <!-- last attachments -->
			</div>
	
	</div>
	
				

  </div>

 

  
<!--  stype 2nd start-->

<h1 class="h1 m-0 p-0 pt-4 pl-3"><em class="fa-solid fa-calendar-days"></em> Timeline </h1>
		  <hr style="height:1px;border:none;color:#333;background-color:#333;">

		<div class="container-fluid">
		<div class="d-flex justify-content-center">

			<div class="p-2" style="background-color: #969696 !important; width: 50% ; height:65px;">
			 <div class="d-flex justify-align-content-start ">
			 <div class="rounded"  style="width: 10% ; height:60%;background-color:#3498db !important; overflow:hidden !important">
			     <p class="m-0" style=" text-align:center;"><?=date("M",strtotime($rfq->eventStartDate));?></p>
				 <p class="m-0" style="background-color: #fff !important; text-align:center; position:relative !important; top: 4px;"><?=date("d",strtotime($rfq->eventStartDate));?></p>
			     
			</div>
			<div class="ml-2">
                <span style="color:white">Event starts</span><br>
                <span class="fs-18 bold" style="color:white; font: size 18px !important;"><?php echo date('h:i a', strtotime($rfq->eventStartTime));?></span><span style="color:white;">   Asia/Dhaka</span><br>
			</div>

			 </div>
		
			</div>
			<div class="p-2" style="background-color: #dfe3e3 !important; width: 50% ; height:65px;">
					<div class="d-flex justify-align-content-start ">
					<div class="rounded"  style="width: 10% ; height:60%;background-color:#3498db !important; overflow:hidden !important">
						<p class="m-0" style=" text-align:center;"><?=date("M",strtotime($rfq->eventEndDate));?></p>
						<p class="m-0" style="background-color: #fff !important; text-align:center; position:relative !important; top: 4px;"><?=date("d",strtotime($rfq->eventEndDate));?></p>
						
					</div>
					<div class="ml-2">
						<span style="color:#333">Event End's</span><br>
						<span class="fs-18 bold" style="color:#333; font: size 18px !important;"><?php echo date('h:i a', strtotime($rfq->eventEndTime));?></span><span style="color:#333;">   Asia/Dhaka</span><br>
					</div>

					</div>
			</div>
			<div class="right triangle triangle-right"></div>


		

		</div>
		</div>

		 
		
		<div class="mt-5 w-100 pr-2" id="response_button">
		<?
			if($required==$completed){
			?>
				<!--<button class="btn1 btn1-bg-update" id="details-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="details" aria-selected="false" onclick="settingF('tab3');">Enter Response</button>-->
				<form action="" method="post">
					<button class="btn1 btn1-bg-update" type="submit" name="enter_response" onclick="" id="details-tab">Enter Response</button>
				</form>
				
			<? }else{ ?>
			<button class="btn1 btn1-bg-update" id="details-tab" style="background-color:#95aac175" data-toggle="tab" href="#tab3" role="tab" aria-controls="details" aria-selected="false" disabled >Enter Response</button>
			<? } ?>
		</div>
		

</div>



            
		  
  

  
				
  
  <!--2nd tab -->
  <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="timeline-tab">

	
	
	<div class="col-12 pt-4 pb-4">		
		<div class="pt-1">
  	<table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th scope="col">Response Name</th>
                        <th scope="col">State</th>
						<th scope="col">Submitted At</th>
                        <th scope="col">Total</th>
						<th scope="col">Action </th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					<?
					
					$sql = 'select * from rfq_vendor_response  where rfq_no='.$rfq->rfq_no.' and vendor_id='.$vendor.'  ';
					$query = db_query($sql);
					while($result = mysqli_fetch_object($query)){
					
					$total_amount = find_a_field('rfq_vendor_item_response','sum(total_amount)','vendor_id="'.$result->vendor_id.'" and rfq_no="'.$result->rfq_no.'"  ');
					
					?>
					    <tr>
							<td><?=$result->response_name;?>-#<?=$result->id;?></td>
							<td><? if($result->status=='SUBMITED') {echo 'Submitted';} else {echo 'Work';} ?> </td>
							<td><? if($result->entry_at !='') {echo date('m/d/y',strtotime($result->entry_at));}?></td>
                            <td> <?=$total_amount?></td>
							<td>
		<? if($result->status=='SUBMITED'){ ?>
			<a href="vendor_entry_entry.php?rfq_no=<?=$result->rfq_no;?>&section_id=<?=$result->id?>"><button type="button" class="btn2 btn1-bg-info"><em class="fa-regular fa-eye"></em></button></a>
		<? }else{ ?>					
			<a href="vendor_entry_entry.php?rfq_no=<?=$result->rfq_no;?>&section_id=<?=$result->id?>&mode=edit"> <button type="button" class="btn2 btn1-bg-update"><em class="fa-regular fa-pen-to-square"></em></button></a>
		<? } ?>	
			</td>
                        </tr>		
						
					<? } ?>						
					</tbody>
                </table>
  
  
  
  
  </div>
		
		
		
	</div>
	
  </div>
                        
   

  <!--3rd tab -->
  <!--3rd tab -->
  <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="details-tab">
  
 

  
  
  <div class="row m-0 p-0 pt-4">
	<div class="col-3"></div>
  	<div class="col-6 d-flex ">
	<?
	 
	 $sql_rfq = 'select * from rfq_vendor_response where vendor_id='.$vendor.' and rfq_no='.$rfq->rfq_no.' and id='.$response_id.' ';
	 $query = db_query($sql_rfq);
	 $response_name = mysqli_fetch_object($query);
	
	 ?>	
		<span class="req-input pr-2 ">Response Name:</span>
		<? if($response_name->status=='SUBMITED'){
			echo $response_name->response_name;
			
		   }else{
		
		?>
		
		<input id="response_name" required id="response_name" value="<?=$response_name->response_name;?>" type="text" style="outline-color: orange !important;" onblur="response_nameupdate(this.value,<?=$rfq->rfq_no;?>,<?=$response_id;?>)"   />
		<input type="hidden" value="<?=$response_name->status;?>"  />
		
		<? } ?>
	</div>

  </div>
  

  <div class="row m-0 p-0 pt-4">
  	<div class="col-12 pt-4 pb-4">
	   <h1 class="h1 m-0 p-0 pt-4 pl-3" style="font-size: 30px !important;"><em class="fa-solid fa-paperclip" style="color: #eb7100; font-size: 30px !important;"></em> Attachments </h1>
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
	  $sql = 'select d.* from rfq_doc_details d where    rfq_no="'.$_SESSION[$unique].'" ';
	  $qry = db_query($sql);
	  while($res = mysqli_fetch_object($qry)){
?>   
<form >
</form>  
		<div class="row col-sm-12 m-5 p-0 pt-1">
			<div class="col-5  p-0">
			<h1 class="m-0 p-0 pl-3 fs-22"><?=$res->section_name;?></h1>
			
			<div class="pl-3 mt-3">
				<p class="p-0 m-0 fs-14" style="font-weight:bold"> Instructions </p>
				<?php echo $res->terms; ?>
			</div>
			
			
			<div class="pl-3 pt-3">
				<p class="p-0 m-0 fs-18" style="font-weight:bold"> Attachment</p>
				<div class="row pt-3">
				
	<?php
		$sql2 = 'select d.* from rfq_documents_information d where tr_from like "multiple_doc_section" and section_id = "'.$res->id.'" and rfq_no="'.$rfq->rfq_no.'" ';
		$qry2 = db_query($sql2);
		while($res2 = mysqli_fetch_object($qry2)){
	?>	
				
				<div class="col-sm-10 col-md-10 col-lg-10 pb-1"><div class="rounded p-2" style="background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; "><a href="../../../controllers/utilities/api_upload_attachment_show.php?name=<?php echo $res2->new_name;?>&folder=doc_section&original_name=<?=$res2->original_name?>" target="_blank" rel="noopener">
			
				<em class="fa-solid fa-file fa-2xl fs-22" style="color: #d6960a;"></em> <span style="color:#268ecd;"><?php echo $res2->original_name;?></span></a></div>
				</div>
	<? } ?>			
				


				</div>
			</div>
			
				
			</div>
			<div class="col-1"></div>	
			<div class="vertical-line" style="height: auto; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
			<?php if($res->att_response == 1){ ?>
			<div class="col-5 ml-5 p-0">
			<h1 class="m-0 p-0  fs-22">Response to
			  <?=$res->section_name;?></h1>
			<p class="p-0 mt-3 fs-18 <? if($res->is_required==1){ echo 'req-input'; }?>"  > Attachments</p>
			<div class="attachment-toggle">
			
			<? if($response_name->status=='SUBMITED'){ }else{ ?>	
			
							
				
							<span class="attachment-toggle-add-file icon-search fs-14" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">File</span>
							<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
							<span class="attachment-toggle-add-url icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Url</span>
							<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
							<span class="attachment-toggle-add-text icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Text</span>
		  
		    <? } ?>
						
						<div class="fileuploadcontainer" >
									
							<form  id="attachmentuploadForm" enctype="multipart/form-data">
							<input type="hidden" name="rfq_no" value="<?=$rfq->rfq_no;?>">
							<input type="hidden" name="section_id" value="<?=$_SESSION['response_id']?>">
							<input type="hidden" name="tr_from" value="sourcing_attachment_response<?=$res->id;?>">
							<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
							<input type="hidden" name="vendor_id" value="<?=$vendor?>">
							<input type="hidden" name="motherContainer" value="fileuploadcontainer">
							<input type="hidden" name="datashowContainer" value="attachmentshowcontainer">
							<div class="attachment-icon-close-container">
								<em class="attachment-toggle-add-file fa fa-fw fa-close"></em>
							</div>
							<div id="dropArea" class="drop-area">
						
							<input  type="file" name="eprocfiles[]" id="imageInput" accept="*/*" multiple>
								<div id="filepercentageandloader" class="filepercentageandloader" style="display: none !important;">
								</div>
								
						
							<div class="drop-area2">
								<div>
								<p class="m-0">Drag & Drop files here</p>
								<em class="fa-solid fa-cloud-arrow-up fa-2xl"></em>
								</div>
							
							</div>
							
							</div>

								<button type="submit" class="d-none"  name="submit" value="Go" class="attachment-toggle-add-file"><em class="fa fa-fw fa-search"></em></button>
							
							</form>
						</div>
										
										<div class="attachmenturluploadcontainer" >
									
											<form  id="attachmenturluploadForm1" enctype="multipart/form-data">
											<input type="hidden" name="rfq_no" value="<?=$rfq->rfq_no?>">
											<input type="hidden" name="section_id" value="<?=$_SESSION['response_id']?>">
											<input type="hidden" name="tr_from" value="sourcing_attachment_response_url<?=$res->id;?>">
											<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
											<input type="hidden" name="motherContainer" value="ttttttttttt">
											<input type="hidden" name="datashowContainer" value="attachmentUrlshowcontainer">
											
											<div class="attachment-icon-close-container">
												<em class="attachment-toggle-add-url fa fa-fw fa-close"></em>
											</div>
											
											<p>Add Your URL here</p>
											<input  type="text" name="attachmenturlinput" id="attachmenturlinput">
											
									
												<button type="submit"  name="submit" value="Go" class="attachment-toggle-add-file btn btn-info">ADD</button>
											
											</form>
										</div>
							<div class="attachmenttextuploadcontainer" >
									
							<form  id="attachmenttextuploadForm" enctype="multipart/form-data">
							<input type="hidden" name="rfq_no" value="<?=$rfq->rfq_no?>">
							<input type="hidden" name="section_id" value="<?=$_SESSION['response_id']?>">
							<input type="hidden" name="tr_from" value="sourcing_attachment_response_text<?=$res->id;?>">
							<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
							<input type="hidden" name="motherContainer" value="attachmenttextuploadcontainer">
							<input type="hidden" name="datashowContainer" value="attachmentTextshowcontainer">
							
							<div class="attachment-icon-close-container">
								<em class="attachment-toggle-add-text fa fa-fw fa-close"></em>
							</div> 
							
							<p>Add Your Text here</p>
							<textarea name="attachmenttextinput" id="attachmenttextinput" rows="10"></textarea>
							

								<button type="submit"  name="submit" value="Go" class="attachment-toggle-add-file btn btn-info">ADD</button>
							
							</form>
						</div>
							<div class="attachmentshowcontainer container row m-0">
		  <?php
		  $sql1 = 'select * from rfq_documents_information where tr_from like "sourcing_attachment_response'.$res->id.'" and section_id="'.$response_id.'" and entry_by="'.$_SESSION['user']['id'].'" and rfq_no="'.$_SESSION[$unique].'"';
		  $qry1 = db_query($sql1);
		  while($res1 = mysqli_fetch_object($qry1)){
		  
		  ?>
								<div class="col-sm-10 col-md-10 col-lg-10 pb-1">
									<div class="rounded p-2" style="background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
									
									<a href="../../../controllers/utilities/api_upload_attachment_show.php?name=<?=$res1->new_name?>&folder=<?=$res1->tr_from?>&original_name=<?=$res1->original_name?>" target="_blank" rel="noopener">
									<em class="fa-solid fa-file fa-2xl fs-22" style="color: #d6960a;"></em> <span><?=$res1->original_name?></span></a>
									
					<? if($response_name->status=='SUBMITED'){ }else{ ?>				
									<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentseventinfo(this,'<?=$res1->documents_id?>','<?=$rfq->rfq_no?>','sourcing_attachment_response<?=$res->id;?>','<?=$_SESSION['user']['id']?>','fileuploadcontainer','attachmentshowcontainer','<?=$_SESSION['response_id']?>')">
									<em class="fa-solid fa-xmark"></em></button>
					<? } ?>				
									
									
									</div>
								</div>
		<? } ?>						
								
							
							</div>
							<div class="attachmentUrlshowcontainer container row m-0">
							<?php
						  $sql1 = 'select * from rfq_documents_url_information where tr_from like "sourcing_attachment_response_url'.$res->id.'" and section_id="'.$response_id.'" and rfq_no="'.$_SESSION[$unique].'" and entry_by = "'.$_SESSION['user']['id'].'" ';
						  $qry1 = db_query($sql1);
						  while($res1 = mysqli_fetch_object($qry1)){
					   ?> 
					   <div class="col-sm-8 col-md-8 col-lg-8 pb-1">
					   		<div class="rounded p-2" style="word-break: break-all; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
							<a href="<?=$res1->attachment_url?>" target="_blank" rel="noopener"><em class="fa-solid fa-link fa-2xl" style="--fa-primary-color: #d6960a; --fa-secondary-color: #d6960a;"></em>
								<span><?=$res1->attachment_url?></span></a>
								
					<? if($response_name->status=='SUBMITED'){ }else{ ?>	
									<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentURLseventinfo(this,'<?=$res1->documents_url_id?>' , '<?=$res1->rfq_no?>', 'sourcing_terms_buery_url', '<?=$res1->entry_by?>', 'attachmenturluploadcontainereventinfo','attachmentshowcontainereventinfo-url')"><em class="fa-solid fa-xmark"></em>
									</button>
					 <? } ?>				
									
							</div>
						</div>
					   
					   <? } ?>
							
							</div>
							<div class="attachmentTextshowcontainer container row m-0">
							 <?php
			  $sql1 = 'select * from rfq_documents_url_information where tr_from like "sourcing_attachment_response_text'.$res->id.'" and section_id="'.$response_id.'" and rfq_no="'.$_SESSION[$unique].'" and entry_by = "'.$_SESSION['user']['id'].'" ';
			  $qry1 = db_query($sql1);
			  while($res1 = mysqli_fetch_object($qry1)){
			  
		   ?>
		    <div class="col-sm-12 col-md-12 col-lg-12 pb-1">
		   		<div class="rounded p-2" style=" word-break: break-all; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
					<span><em class="fa-solid fa-envelope-open-text fa-xl" style="color: #d6960a;"></em>
						<span><?=$res1->attachment_text?> </span></span>
						
						<? if($response_name->status=='SUBMITED'){ }else{ ?>
						
						<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentTextseventinfo(this,'<?=$res1->documents_url_id?>', '<?=$res1->rfq_no?>', 'sourcing_attachment_response_text<?=$res->id?>', '<?=$res1->entry_by?>', 'attachmenttextuploadcontainereventinfo','attachmentshowcontainereventinfo-text')">
							<em class="fa-solid fa-xmark"></em>
						</button>
						
						<? } ?>
						
				</div>
			</div>
		   <? } ?>
							
							</div>
			  </div>
			<? } ?>
		</div>
		</div>
	<? } ?>	
<!-------------------------------------------------------------------------------------------------------------------->		
	
	<?php
		 $sql = 'select * from rfq_form_response where   rfq_no="'.$rfq->rfq_no.'" and vendor_id = '.$vendor.' and section_id='.$response_id.' ';
		  $qry = db_query($sql);
		  while($res = mysqli_fetch_object($qry)){
		  
		      $value[$res->form_no][$res->form_id][] = $res->value;
		  
		  }
		  
	?>
	
<?php
  $sql = 'select form_no from rfq_form_details d where   rfq_no="'.$rfq->rfq_no.'" group by form_no ';
  $qry = db_query($sql);
  $res = mysqli_fetch_object($qry);
  if($res->form_no>0){
?> 
	<div class="col-12 pt-4 pb-4">
	   <h1 class="h1 m-0 p-0 pt-4 pl-3" style="font-size: 30px !important;"><em class="fa-regular fa-file-lines" style="color: #eb7100; font-size: 30px !important;"></em>  Forms </h1>
		<hr style="height:1px;border:none;color:#333;background-color:#333;">
		
		<div class="pt-1 col-sm-12">
		<form action="" method="post" id="att_forms" class="col-sm-8" >
<?php
  $sql = 'select form_no from rfq_form_details  where   rfq_no="'.$rfq->rfq_no.'" group by form_no ';
  $qry = db_query($sql);
  while($res = mysqli_fetch_object($qry)){
?> 
		<div class="row">
			
				<table class="w-100" >
					 <thead>
					  <tr>
						<th scope="col">Form- <?=$res->form_no?></th>
						<th scope="col"></th>
					  </tr>
					 </thead>
					 
					 <tbody>
					 <?php
					  $sql1 = 'select d.* from rfq_form_details d where   rfq_no="'.$_SESSION[$unique].'" and form_no="'.$res->form_no.'"  ';
					  $qry1 = db_query($sql1);
					  while($res1 = mysqli_fetch_object($qry1)){
					?> 
				
					<input type="hidden" name="form_id_value" value="<?=$res1->form_no?>" id="form_id_value"/>	
					
					<? if($res1->form_element=='Dropdown'){?> 
					   <tr>
						 <td><?=$res1->lebel?></td>
						 
						 <td colspan="2"><select  name="<?=$res1->id?>" id="<?=$res1->id?>" >
						 						<option <? if($value[$res1->form_no][$res1->id][0]==$res1->option_1) {echo 'selected';} ?> > <?=$res1->option_1?></option>
												<option <? if($value[$res1->form_no][$res1->id][0]==$res1->option_2) {echo 'selected';} ?> ><?=$res1->option_2?></option>
					<?php
					  $sql2 = 'select d.* from rfq_form_element_options d where   rfq_no="'.$_SESSION[$unique].'" and form_no="'.$res->form_no.'" ';
					  $qry2 = db_query($sql2);
					  while($res2 = mysqli_fetch_object($qry2)){
					?> 
					  <option <? if($value[$res1->form_no][$res1->id][0]==$res2->options) {echo 'selected';} ?> ><?=$res2->options?></option>
					<? } ?>
						 				</select>
						 </td>
					   </tr>
					<? } ?>   
			
					   
					 <? if($res1->form_element=='Checkbox'){?>   
					 	<tr>
						 <td><?=$res1->lebel?></td>
						 <td>
						 <? if($res1->option_1 != ''){?>
						  <label class="form-check-label">
							<input type="checkbox" <? if($value[$res1->form_no][$res1->id][0]==$res1->option_1) {echo 'checked';} ?> name="<?=$res1->id?>" id="<?=$res1->id?>" class="form-check-input" 
							value="<?=$res1->option_1?>" >
							<?=$res1->option_1?>
						  </label>
						  <? } ?>
						  </td>
						 </tr>
						 
						<tr>
							<td>&nbsp;</td>
							<td>
						  <? if($res1->option_2 != ''){?>
						  <label class="form-check-label">
							<input type="checkbox" <? if($value[$res1->form_no][$res1->id][1]==$res1->option_2) {echo 'checked';} ?> name="<?=$res1->id?>" id="<?=$res1->id?>" class="form-check-input" 
							value="<?=$res1->option_2?>" >
							<?=$res1->option_2?>
						  </label>
						  <? } ?>
						 </td>
					   </tr>
					  <? } ?> 
	
			<? if($res1->form_element=='Text Field'){?>
					<tr>
						 <td><?=$res1->lebel?></td>
						 <td><input type="text" name="<?=$res1->id?>" value="<?=$value[$res1->form_no][$res1->id][0]?>" id="<?=$res1->id?>"/></td>
					</tr>
			<? } ?>		
			
			
			<? if($res1->form_element=='Text Area'){?>
					<tr>
						 <td><?=$res1->lebel?></td>
						 <td><textarea name="<?=$res1->id?>" id="<?=$res1->id;?>"><?php echo $value[$res1->form_no][$res1->id][0]; ?></textarea></td>
					</tr>
			<? } ?>	
			
			<? if($res1->form_element=='Attachment'){?>
					<tr>
						 <td><?=$res1->lebel?></td>
						 <td>
						 
						 <div class="attachment-toggle" >
								
								<form>

								</form>			
								  <? if($response_name->status=='SUBMITED'){ }else{ ?>
												<span class="attachment-toggle-add-file icon-search fs-14" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">File</span>
																<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
																<span class="attachment-toggle-add-url icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Url</span>
																<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
																<span class="attachment-toggle-add-text icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Text</span>
									<? } ?>	  
										  
										  <div class="fileuploadcontainer" >
														
												<form  id="attachmentuploadFormxx" enctype="multipart/form-data">
												<input type="hidden" name="rfq_no" value="<?=$_SESSION[$unique]?>">
												<input type="hidden" name="tr_from" value="form_response<?=$res1->form_no?>">
												<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
												<input type="hidden" name="vendor_id" value="<?=$vendor?>">
												<input type="hidden" name="section_id" value="<?=$_SESSION['response_id']?>">
												<input type="hidden" name="motherContainer" value="fileuploadcontainer">
												<input type="hidden" name="datashowContainer" value="attachmentshowcontainer">
												<div class="attachment-icon-close-container">
												  <em class="attachment-toggle-add-file fa fa-fw fa-close"></em>
												</div>
												<div id="dropArea" class="drop-area">
											
												<input  type="file" name="eprocfiles[]" id="imageInput" accept="*/*" multiple>
												  <div id="filepercentageandloader" class="filepercentageandloader" style="display: none !important;">
												  </div>
												  
										  
												<div class="drop-area2">
												  <div>
												  <p class="m-0">Drag & Drop files here</p>
												  <em class="fa-solid fa-cloud-arrow-up fa-2xl"></em>
												  </div>
												
												</div>
												
											  </div>

												  <button type="submit" class="d-none"  name="submit" value="Go" class="attachment-toggle-add-file"><em class="fa fa-fw fa-search"></em></button>
												
												</form>
										  </div>
															
															<div class="attachmenturluploadcontainer" >
														
																<form  id="attachmenturluploadForm1" enctype="multipart/form-data">
																<input type="hidden" name="rfq_no" value="<?=$_SESSION[$unique]?>">
																<input type="hidden" name="tr_from" value="form_response<?=$res1->form_no?>">
																<input type="hidden" name="section_id" value="<?=$_SESSION['response_id']?>">
																<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
																<input type="hidden" name="motherContainer" value="ttttttttttt">
																<input type="hidden" name="datashowContainer" value="attachmentUrlshowcontainer">
																
																<div class="attachment-icon-close-container">
																	<em class="attachment-toggle-add-url fa fa-fw fa-close"></em>
																</div>
																
																<p>Add Your URL here</p>
																<input  type="text" name="attachmenturlinput" id="attachmenturlinput">
																

																  <button type="submit"  name="submit" value="Go" class="attachment-toggle-add-file btn btn-info">ADD</button>
																
																</form>
															</div>
											  <div class="attachmenttextuploadcontainer" >
														
												<form  id="attachmenttextuploadForm" enctype="multipart/form-data">
												<input type="hidden" name="rfq_no" value="<?=$_SESSION[$unique]?>">
												<input type="hidden" name="section_id" value="<?=$_SESSION['response_id']?>">
												<input type="hidden" name="tr_from" value="form_response<?=$res1->form_no?>">
												<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
												<input type="hidden" name="motherContainer" value="attachmenttextuploadcontainer">
												<input type="hidden" name="datashowContainer" value="attachmentTextshowcontainer">
												
												<div class="attachment-icon-close-container">
												  <em class="attachment-toggle-add-text fa fa-fw fa-close"></em>
												</div> 
											
												<p>Add Your Text here</p>
												<textarea name="attachmenttextinput" id="attachmenttextinput" rows="10"></textarea>
												

												  <button type="submit"  name="submit" value="Go" class="attachment-toggle-add-file btn btn-info">ADD</button>
												
												</form>
											</div>
											<div class="attachmentshowcontainer container row m-0">
                        <?
						  $sql100 = 'SELECT * FROM rfq_documents_information WHERE rfq_no = "'.$_SESSION[$unique].'" AND tr_from ="form_response'.$res1->form_no.'"';
						  $qry100100 = db_query($sql100);
						  while($item=mysqli_fetch_object($qry100100)){
						?>
                                      <div class="col-sm-10 col-md-10 col-lg-10 pb-1">
										<div class="rounded p-2" style="background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
										<a href="../../../controllers/utilities/api_upload_attachment_show.php?name=<?=$item->new_name?>&folder=<?=$item->tr_from?>&original_name=<?=$item->original_name?>" target="_blank" rel="noopener">
												<em class="fa-solid fa-file fa-2xl fs-22" style="color: #d6960a;"></em> 
												<span><?=$item->original_name?></span>
											</a>
											
								<? if($response_name->status=='SUBMITED'){ }else{ ?>			
											<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentseventinfo(this,
                                   '<?=$item->attachment_id;?>',
                                   '<?=$item->rfq_no;?>',
                                   '<?=$item->tr_from;?>',
                                   '<?=$item->entry_by;?>',
                                   '<?=$motherContainerValue;?>',
                                   '<?=$datashowContainerValue;?>',
                                   '<?=$item->section_id;?>')">
												<em class="fa-solid fa-xmark"></em>
											</button>
								<? } ?>			
											
										</div>
									</div>



                       <? } ?>
						</div>
											  <div class="attachmentUrlshowcontainer container row m-0">
											<?php
												$sql100 = 'select * from rfq_documents_url_information where tr_from like "form_response'.$res1->form_no.'" and rfq_no="'.$_SESSION[$unique].'" and entry_by = "'.$_SESSION['user']['id'].'"  AND attachment_url IS NOT NULL';
												$qry100100 = db_query($sql100);
												while($res100 = mysqli_fetch_object($qry100100)){
												
											?>
												<div class="col-sm-12 col-md-12 col-lg-12 pb-1">
													<div class="rounded p-2" style=" word-break: break-all; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
														<span><em class="fa-solid fa-envelope-open-text fa-xl" style="color: #d6960a;"></em>
															<span><?=$res100->attachment_url?></span></span>
															
										<? if($response_name->status=='SUBMITED'){ }else{ ?>			
															<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentTextseventinfo(this,'<?=$res100->documents_url_id?>', '<?=$res100->rfq_no?>', 'form_response<?=$res1->form_no?>', '<?=$res100->entry_by?>', 'attachmenttextuploadcontainereventinfo','attachmentshowcontainereventinfo-text')">
																<em class="fa-solid fa-xmark"></em>
															</button>
											<? } ?>				
															
													</div>
												</div>
											<? } ?>
																				
											  </div>
											  <div class="attachmentTextshowcontainer container row m-0">
											  <?php
												$sql100 = 'select * from rfq_documents_url_information where tr_from like "form_response'.$res1->form_no.'" and rfq_no="'.$_SESSION[$unique].'" and entry_by = "'.$_SESSION['user']['id'].'"  AND attachment_text IS NOT NULL';
												$qry100100 = db_query($sql100);
												while($res100 = mysqli_fetch_object($qry100100)){
											?> 
											<div class="col-sm-8 col-md-8 col-lg-8 pb-1">
													<div class="rounded p-2" style="word-break: break-all; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
													<a href="<?=$res100->attachment_url?>" target="_blank" rel="noopener"><em class="fa-solid fa-envelope-open-text fa-xl" style="color: #d6960a;"></em>
														<span><?=$res100->attachment_text?></span></a>
														
													<? if($response_name->status=='SUBMITED'){ }else{ ?>	
															<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentURLseventinfo(this,'<?=$res100->documents_url_id?>' , '<?=$res100->rfq_no?>', 'form_response<?=$res1->form_no?>', '<?=$res100->entry_by?>', 'attachmenturluploadcontainereventinfo','attachmentshowcontainereventinfo-url')"><em class="fa-solid fa-xmark"></em>
															</button>
													<? } ?>		
															
													</div>
												</div>
											
											<? } ?>
											  
											  </div>
                     </div>
						 
						 </td>
					</tr>
			<? } ?>		
					  
					 <? } ?>  
					 
					   
					   
					 </tbody>
					</table>
				    
                      
			
		</div>
<? } ?>	

    <? if($response_name->status=='SUBMITED'){ }else{ ?>
		<div class="w-100">
				<button type="button" name="more_option" id="forms_submit_button" class="btn1 btn1-bg-update" onclick="all_form_data(<?=$rfq->rfq_no?>)" >Save</button>
		</div>
	<? } ?> 	
<? } ?>		
</form>
	
	</div>	
		
	</div>
	
	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-list"></em> Items and Services</h1>
		
<?php
		$sql2 = 'select d.* from rfq_documents_information d where tr_from = "details_item"  and rfq_no="'.$rfq->rfq_no.'" ';
		$qry2 = db_query($sql2);
		$res2 = mysqli_fetch_object($qry2);
		if($res2->documents_id !=''){
?>  
<form >
</form>  
		<div class="row col-sm-12 m-5 p-0 pt-1">
			<div class="col-5  p-0">
			<div class="pl-3 pt-3">
				<p class="p-0 m-0 fs-18" style="font-weight:bold"> Attachment</p>
				<div class="row pt-3">
			
	<?php
		$sql1 = 'select d.* from rfq_documents_information d where tr_from = "details_item" and rfq_no="'.$rfq->rfq_no.'" ';
		$qry1 = db_query($sql1);
		while($res1 = mysqli_fetch_object($qry1)){
		?>	
				<div class="col-sm-10 col-md-10 col-lg-10 pb-1"><div class="rounded p-2" style="background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; "><a href="../../../../assets/support/upload_view.php?name=<?php echo $res1->new_name;?>&mod=eProcurement_mod&folder=rfq&proj_id=robi" target="_blank" rel="noopener"><em class="fa-solid fa-file fa-2xl fs-22" style="color: #d6960a;"></em> <span style="color:#268ecd;"><?php echo $res1->original_name;?></span></a></div>
				</div>
			
		<? } ?>		


				</div>
			</div>
			
			
			</div>
			<div class="col-1"></div>	
			<div class="vertical-line" style="height: auto; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
			
			<div class="col-5 ml-5 p-0">
			
			<p class="p-0 mt-3 fs-18 "  > Attachments</p>
			<div class="attachment-toggle">
								
				<? if($response_name->status=='SUBMITED'){ }else{ ?>
							<span class="attachment-toggle-add-file icon-search fs-14" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">File</span>
							<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
							<span class="attachment-toggle-add-url icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Url</span>
							<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
							<span class="attachment-toggle-add-text icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Text</span>
		       <? } ?>
						
						<div class="fileuploadcontainer" >
									
							<form  id="attachmentuploadForm" enctype="multipart/form-data">
							<input type="hidden" name="rfq_no" value="<?=$rfq->rfq_no;?>">
							<input type="hidden" name="tr_from" value="details_item_response">
							<input type="hidden" name="section_id" value="<?=$_SESSION['response_id']?>">
							<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
							<input type="hidden" name="vendor_id" value="<?=$vendor?>">
							<input type="hidden" name="motherContainer" value="fileuploadcontainer">
							<input type="hidden" name="datashowContainer" value="attachmentshowcontainer">
							<div class="attachment-icon-close-container">
								<em class="attachment-toggle-add-file fa fa-fw fa-close"></em>
							</div>
							<div id="dropArea" class="drop-area">
						
							<input  type="file" name="eprocfiles[]" id="imageInput" accept="*/*" multiple>
								<div id="filepercentageandloader" class="filepercentageandloader" style="display: none !important;">
								</div>
								
						
							<div class="drop-area2">
								<div  >
								<p class="m-0">Drag & Drop files here</p>
								<em class="fa-solid fa-cloud-arrow-up fa-2xl"></em>
								</div>
							
							</div>
							
							</div>


								<button type="submit" class="d-none"  name="submit" value="Go" class="attachment-toggle-add-file"><em class="fa fa-fw fa-search"></em></button>
							
							</form>
						</div>
										
										<div class="attachmenturluploadcontainer" >
									
											<form  id="attachmenturluploadForm1" enctype="multipart/form-data">
											<input type="hidden" name="rfq_no" value="<?=$rfq->rfq_no?>">
											<input type="hidden" name="section_id" value="<?=$_SESSION['response_id']?>">
											<input type="hidden" name="tr_from" value="details_item_response_url">
											<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
											<input type="hidden" name="motherContainer" value="ttttttttttt">
											<input type="hidden" name="datashowContainer" value="attachmentUrlshowcontainer">
											
											<div class="attachment-icon-close-container">
												<em class="attachment-toggle-add-url fa fa-fw fa-close"></em>
											</div>
											
											<p>Add Your URL here</p>
											<input  type="text" name="attachmenturlinput" id="attachmenturlinput">
											

												<button type="submit"  name="submit" value="Go" class="attachment-toggle-add-file btn btn-info">ADD</button>
											
											</form>
										</div>
							<div class="attachmenttextuploadcontainer" >
									
							<form  id="attachmenttextuploadForm" enctype="multipart/form-data">
							<input type="hidden" name="rfq_no" value="<?=$rfq->rfq_no?>">
							<input type="hidden" name="section_id" value="<?=$_SESSION['response_id']?>">
							<input type="hidden" name="tr_from" value="details_item_response_text">
							<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
							<input type="hidden" name="motherContainer" value="attachmenttextuploadcontainer">
							<input type="hidden" name="datashowContainer" value="attachmentTextshowcontainer">
							
							<div class="attachment-icon-close-container">
								<em class="attachment-toggle-add-text fa fa-fw fa-close"></em>
							</div> 
						
							<p>Add Your Text here</p>
							<textarea name="attachmenttextinput" id="attachmenttextinput" rows="10"></textarea>
							

								<button type="submit"  name="submit" value="Go" class="attachment-toggle-add-file btn btn-info">ADD</button>
							
							</form>
						</div>
							<div class="attachmentshowcontainer container row m-0">
		  <?php
		  $sql1 = 'select * from rfq_documents_information where tr_from like "details_item_response" and section_id="'.$response_id.'" and entry_by="'.$_SESSION['user']['id'].'" and rfq_no="'.$_SESSION[$unique].'"';
		  $qry1 = db_query($sql1);
		  while($res1 = mysqli_fetch_object($qry1)){
		  
		  ?>
								<div class="col-sm-10 col-md-10 col-lg-10 pb-1">
									<div class="rounded p-2" style="background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
									
									<a href="../../../controllers/utilities/api_upload_attachment_show.php?name=<?=$res1->new_name?>&folder=<?=$res1->tr_from;?>&original_name=<?=$res1->original_name?>" target="_blank" rel="noopener">
									<em class="fa-solid fa-file fa-2xl fs-22" style="color: #d6960a;"></em> <span><?=$res1->original_name?></span></a>
									
									<? if($response_name->status=='SUBMITED'){ }else{ ?>
									<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentseventinfo(this,'<?=$res1->documents_id?>','<?=$rfq->rfq_no?>','details_item_response','<?=$_SESSION['user']['id']?>','fileuploadcontainer','attachmentshowcontainer','<?=$_SESSION['response_id']?>')">
									<em class="fa-solid fa-xmark"></em></button>
									<? } ?>
									
									</div>
								</div>
		<? } ?>						
								
							
							</div>
							<div class="attachmentUrlshowcontainer container row m-0">
							<?php
						  $sql1 = 'select * from rfq_documents_url_information where tr_from like "details_item_response_url" and section_id="'.$response_id.'" and rfq_no="'.$_SESSION[$unique].'" and entry_by = "'.$_SESSION['user']['id'].'" ';
						  $qry1 = db_query($sql1);
						  while($res1 = mysqli_fetch_object($qry1)){
					   ?> 
					   <div class="col-sm-8 col-md-8 col-lg-8 pb-1">
					   		<div class="rounded p-2" style="word-break: break-all; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
							<a href="<?=$res1->attachment_url?>" target="_blank" rel="noopener"><em class="fa-solid fa-link fa-2xl" style="--fa-primary-color: #d6960a; --fa-secondary-color: #d6960a;"></em>
								<span><?=$res1->attachment_url?></span></a>
								
					<? if($response_name->status=='SUBMITED'){ }else{ ?>			
									<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentURLseventinfo(this,'<?=$res1->documents_url_id?>' , '<?=$res1->rfq_no?>', 'sourcing_terms_buery_url', '<?=$res1->entry_by?>', 'attachmenturluploadcontainereventinfo','attachmentshowcontainereventinfo-url')"><em class="fa-solid fa-xmark"></em>
									</button>
					<? } ?>				
									
							</div>
						</div>
					   
					   <? } ?>
							
							</div>
							<div class="attachmentTextshowcontainer container row m-0">
							 <?php
			  $sql1 = 'select * from rfq_documents_url_information where tr_from like "details_item_response_text" and section_id="'.$response_id.'" and rfq_no="'.$_SESSION[$unique].'" and entry_by = "'.$_SESSION['user']['id'].'" ';
			  $qry1 = db_query($sql1);
			  while($res1 = mysqli_fetch_object($qry1)){
			  
		   ?>
		    <div class="col-sm-12 col-md-12 col-lg-12 pb-1">
		   		<div class="rounded p-2" style=" word-break: break-all; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
					<span><em class="fa-solid fa-envelope-open-text fa-xl" style="color: #d6960a;"></em>
						<span><?=$res1->attachment_text?> </span></span>
						
					<? if($response_name->status=='SUBMITED'){ }else{ ?>	
						<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentTextseventinfo(this,'<?=$res1->documents_url_id?>', '<?=$res1->rfq_no?>', 'details_item_response_text', '<?=$res1->entry_by?>', 'attachmenttextuploadcontainereventinfo','attachmentshowcontainereventinfo-text')">
							<em class="fa-solid fa-xmark"></em>
						</button>
					<? } ?>	
						
				</div>
			</div>
		   <? } ?>
							
							</div>
			  </div>
			
		</div>
		</div>
		
	<? } ?>	
		<hr class="m-3" />
	  <div id="alert_bid_div">

	  </div>
	  <input style="display:none;" type="datetime-local" id="event_end_date_show" name="event_end_date_show" value="<?=$rfq->eventEndDate?>T<?=$rfq->eventEndTime?>">
	  <div id="time_extend_div">

	  </div>
	<?
	$rfq_master = find_all_field('rfq_master','','rfq_no="'.$_SESSION[$unique].'"');
	
	?>
  <?if($rfq_master->rfx_stage !='Auction'){?>
		<form action="" method="post" id="item_response_form">
		<div class="pt-1">
  	    <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th scope="col">SL</th>
                        <th scope="col">Item Description</th>
						<th scope="col">Quantity</th>
						<th scope="col">UOM</th>
						<th scope="col">Unit Price</th>
						<th scope="col">Currency</th>
						<th scope="col">Amount</th>
						<th scope="col">Delivery lead time in days</th>
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					<?php
					
						  $sql = 'select d.*, i.item_name from rfq_item_details d, item_info i where i.item_id=d.item_id and  rfq_no="'.$_SESSION[$unique].'" ';
						  $qry = db_query($sql);
						  $i=1;
						  while($res = mysqli_fetch_object($qry)){
						  
						  $itemResponse = find_all_field('rfq_vendor_item_response','*','rfq_no='.$rfq->rfq_no.' and item_id='.$res->item_id.' and vendor_id='.$vendor.' and section_id='.$response_id.' ');
					?> 
					    <tr>
							<td><?=$i++?></td>
							<td><?=$res->item_name?></td>
							<td><?=$res->expected_qty?></td>
							<td><?=$res->unit?></td>
							<td><input type="number" style="text-align:right" id="vendor_price<?=$res->id?>" required name="vendor_price<?=$res->id?>" onkeyup="cal(<?=$res->id?>)" value="<?=$itemResponse->unit_price?>" >
								<input type="hidden" id="expected_qty_<?=$res->id?>"  name="expected_qty_<?=$res->id?>" value="<?=$res->expected_qty?>" >							</td>
							<td>
							<select name="currency_<?=$res->id?>" id="currency_<?=$res->id?>" >
							<?php if($rfq->other_currency=='yes'){?>
								<?php
									$sql_currency = 'select c.currency from rfq_multiple_currency m, currency_info c where m.currency_id=c.id and m.rfq_no='.$rfq->rfq_no.' ';
									$qry_currency = db_query($sql_currency);
									while($res_currency = mysqli_fetch_object($qry_currency)){
										echo '<option value="'.$res_currency->currency.'"';
											if($res_currency->currency==$itemResponse->currency){ echo 'selected';}
										echo ' >'.$res_currency->currency.'</option>';
									}
								?>
								</p>
								
							<?php }else{ ?>	
								<option value="<?=$res->currency;?>" ><?=$res->currency;?></option>
								<?}?>
							</select>
							</td>
							<td><input type="number" style="text-align:right" id="vendor_total_amount<?=$res->id?>" readonly name="vendor_total_amount<?=$res->id?>" value="<?=($itemResponse->unit_price*$itemResponse->expected_qty);?>" ></td>
							<td><input type="text" style="text-align:right" id="need_by<?=$res->id?>"  name="need_by<?=$res->id?>" 
							value="<?=$itemResponse->need_by?>" ></td>
                        </tr>	
					<? } ?>		

					</tbody>
                </table>
  			
 
  
  
  </div>
  
  	<div class="mt-5"  >
	
	  <? if($response_name->status=='SUBMITED'){ }else{ ?>  
	  
		<button class="btn1 btn1-bg-update active" type="button" name="vendor_item_response" id="vendor_item_response" onclick="item_form_submit(<?=$rfq->rfq_no?>,<?=$response_id;?>)" >Submit Response</button>
		
		<? } ?>
		
	</div>
	</form>	
<? } ?>
<? if($rfq_master->rfx_stage == 'Auction'){

	
	
	
	?>
	   <button id="submitAllBids" class="btn btn-primary">Submit All Bids</button>
		<form action="" method="post" id="item_response_form">
		<style>
		.auction table tr td{
		border:0px !important;
		}
		.auction table tbody tr{
		    border-left: 5px solid #28a745;
    		border-bottom: 8px solid #f0f0f0;
		}
		
		</style>
		<div class="pt-1 auction" id="auction_item_table">
		<table class="table1 table-striped table-bordered table-hover table-sm">
    <thead class="thead1">
        <tr class="bgc-info">
            <th scope="col">SL</th>
            <th scope="col">Item Description</th>
            <th scope="col">Item Quantity</th>
            <th scope="col">Units</th>
            <th scope="col">Ceiling Value</th>
            <!-- <th scope="col">Historic Value</th> -->
            <th scope="col">MY BID</th>
            <th scope="col">Total</th>
			<th scope="col">Lead BID</th>
            <th scope="col">Currency</th>
            <th scope="col">My Rank</th>
            <!-- <th scope="col">New BID</th> -->
            <th scope="col">Action</th>

        </tr>
    </thead>

    <tbody class="tbody1">
        <?php
       $current_time = new DateTime();
		$sql = 'SELECT d.*, i.item_name FROM rfq_item_details d, item_info i WHERE i.item_id = d.item_id AND rfq_no = "'.$_SESSION['rfq_no'].'"';
		$qry = db_query($sql);
        $i = 1;
        while ($res = mysqli_fetch_object($qry)) {
            // Get the showtime and endtime
            $showtime = new DateTime($res->visibility_start);
            $endtime = new DateTime($res->visibility_end);
            $lead_bid='';
            $last_minimum_bid=find_a_field('rfq_vendor_item_response','MIN(unit_price)','rfq_no="'.$_SESSION['rfq_no'].'" and vendor_id="'.$_SESSION['user']['id'].'" and item_id="'.$res->item_id.'"');
            // Check if current time is within visibility period
            if ($current_time >= $showtime && $current_time <= $endtime) {
                ?>
                <tr id="bid_row_show_<?=$res->item_id?>">
                    <input type="hidden" id="live_bid_item_id" value="<?=$res->item_id?>">
                    <td><?= $i++ ?></td>
                    <td><?= $res->item_name ?></td>
                    <td><?= $res->expected_qty ?></td>
                    <td><?=$res->unit ?></td>
                    <td><?=number_format($res->ceiling_value,2)?></td>
                    <!-- <td><?//=$res->historic_value?></td> -->
                    <td><input type="text" id="live_bid_item_amount_<?=$res->item_id?>"  name="live_bid_item_amount_<?=$res->item_id?>" value=""></td>
					<td id="total_amount_show_id_<?=$res->item_id?>"></td>
					<td><span id="lead_bid_show_id_<?=$res->item_id?>"></span></td>
                    <td>
							<select name="live_bid_currency_<?=$res->item_id?>" id="live_bid_currency_<?=$res->item_id?>" >
							<?php if($rfq->other_currency=='yes'){?>
								<?php
									$sql_currency = 'select c.currency from rfq_multiple_currency m, currency_info c where m.currency_id=c.id and m.rfq_no='.$_SESSION['rfq_no'].' ';
									$qry_currency = db_query($sql_currency);
									while($res_currency = mysqli_fetch_object($qry_currency)){
										echo '<option value="'.$res_currency->currency.'"';
											// if($res_currency->currency==$itemResponse->currency){ echo 'selected';}
										echo ' >'.$res_currency->currency.'</option>';
									}
								?>
								</p>
								
							<?php }else{ ?>	
								<option value="<?=$res->currency;?>" ><?=$res->currency;?></option>
								<?}?>
							</select>
					</td>
                    <td><span id="rank_show_id_<?=$res->item_id?>"></span></td>

                    <td>
                        <button class="btn1 btn1-bg-update active" type="button" name="vendor_auction_item_response" id="vendor_auction_item_response" onclick="auction_item_bid_update(<?=$res->item_id?>,<?=$_SESSION['user']['id']?>,<?=$_SESSION['rfq_no']?>,<?=$response_id?>,<?=$res->id?>,<?= !empty($last_minimum_bid) ? $last_minimum_bid : 'null' ?>,<?=$rfq_master->bid_improve_warning_percentage?>)">Place Bid</button>
                    </td>

                </tr>
                <?
            }else{
		   ?>
                <tr id="bid_row_show_<?=$res->item_id?>">
                    <input type="hidden" id="live_bid_item_id" value="<?=$res->item_id?>">
                    <td><?= $i++ ?></td>
                    <td><?= $res->item_name ?></td>
                    <td><?= $res->expected_qty ?></td>
                    <td><?=$res->unit ?></td>
                    <td><?= $res->ceiling_value != ''?number_format($res->ceiling_value,2):'';?></td>
                    <!-- <td><?//=$res->historic_value?></td> -->
                    <td><input type="text" id="live_bid_item_amount_<?=$res->item_id?>"  name="live_bid_item_amount_<?=$res->item_id?>" value=""></td>
					<td id="total_amount_show_id_<?=$res->item_id?>"></td>
					<td><span id="lead_bid_show_id_<?=$res->item_id?>"></span></td>
                    <td>
							<select name="live_bid_currency_<?=$res->item_id?>" id="live_bid_currency_<?=$res->item_id?>" >
							<?php if($rfq->other_currency=='yes'){?>
								<?php
									$sql_currency = 'select c.currency from rfq_multiple_currency m, currency_info c where m.currency_id=c.id and m.rfq_no='.$_SESSION['rfq_no'].' ';
									$qry_currency = db_query($sql_currency);
									while($res_currency = mysqli_fetch_object($qry_currency)){
										echo '<option value="'.$res_currency->currency.'"';
											// if($res_currency->currency==$itemResponse->currency){ echo 'selected';}
										echo ' >'.$res_currency->currency.'</option>';
									}
								?>
								</p>
								
							<?php }else{ ?>	
								<option value="<?=$res->currency;?>" ><?=$res->currency;?></option>
								<?}?>
							</select>
					</td>
                    <td><span id="rank_show_id_<?=$res->item_id?>"></span></td>

                    <td>
                    </td>

                </tr>
		 
		 
		 <?
			}
        }
		
        ?>
		<tr>
						<td colspan="6">Total</td>
						<td><span id="total_show"></span></td>
		</tr>					
    </tbody>
</table>
 
  
  
  </div>
  
	</form>	
	<?}?>
	
	</div>
	
	</div>
	
				  
	</div> 



</div>
<!-- 4th tab -->
<div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="bidconsole-tab">
<div class="col-12 pt-4 pb-4">
	<div class="pt-1" id="auction_item_table_console">
	<!-- <canvas id="rfqChart" width="400" height="200"></canvas> -->
	</div>
	<canvas id="rfqChart" width="400" height="200"></canvas>
</div>
  
</div>
<!-- end 4th tab -->
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
	if(rfq_no=='No'){
		document.getElementById('want_to_participate_show').innerHTML='';
		document.getElementById('want_to_participate').checked=false;
	}
    var type = form_id+'##'+type+'##'+rfq;
	getData2('first_response_ajax.php','response_button',rfq_no,type);
	
}



function want_to_participate_form(radio_button_value,radio_button) {
	if(radio_button_value=='Yes'){
    $.ajax({
        url: 'all_terms_check_ajax.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
			console.log(response.all_conditions_met);
            if (response.all_conditions_met) {
                getData2('want_to_participate_ajax.php', 'want_to_participate_show', radio_button_value, radio_button_value);
            } else {
				radio_button.checked = false;
                alert('You must accept all terms and condions');
            }
        },
        error: function() {
            alert('An error occurred while checking conditions.');
			radio_button.checked = false;
        }
    });
}else {
	getData2('want_to_participate_ajax.php', 'want_to_participate_show', radio_button_value, radio_button_value);
}
}





// function participate_success_mail(val,rfq_no){
  
// 	getData2('participate_ajax.php','response_button',rfq_no,val);
// }

/////////////

 function is_participate(val,rfq_no) {
            
 	var xhr = new XMLHttpRequest();
 	xhr.open('POST', 'participate_ajax.php', true);
 	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
 	xhr.send('data=' + rfq_no + '##' + val);
 	xhr.onload = function() {
 		if (xhr.status == 200) {
 			var res = JSON.parse(xhr.responseText);
 			if(res['status']=='success'){
				// alert('hhhhhhhhhhhhhhhh');
				event_initiation_mail();
				 settingF('tab1');
			}
			// alert('hhhhhhhhhhhhhhhh');
 			document.getElementById('response_button').innerHTML = res['button'];
 			document.getElementById('participate_button').innerHTML = res['alert'];
 			document.getElementById('reason_form').innerHTML = res['reason'];
 		}
 	};
 }

///////////

/////////////

 function item_form_submit(rfq_no,section_id) {
	
	var data = rfq_no + '##' + section_id;
	var formData = new FormData(document.getElementById('item_response_form'));
	formData.append('data', data);
 	var xhr = new XMLHttpRequest();
 	xhr.open('POST', 'item_response_ajax.php', true);
 	//xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
 	xhr.send(formData);
 	xhr.onload = function() {
 		if (xhr.status == 200) {
 			var res = JSON.parse(xhr.responseText);
			if(res['required']!='time_exceded'){
			if( res['required'] >  res['completed']){
				alert('All required fields must be filled out');
			}else{
				console.log('fffffffffffffffffffffffffffffffffffffff'+res['required'])
				// ccmail();
				location.replace('vendor_entry.php');
			}
		}else{
         console.log('hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh'+res['required']);
			location.replace('vendor_entry.php');
		}
 			// location.replace('vendor_entry.php');
 			//document.getElementById('participate_button').innerHTML = res['alert'];
 		}
 	};
 }
 

function ccmail(){
var cc='';
getData2('team_mail_sender.php','egyyp',cc);
}
function event_initiation_mail(){
	
var cc='';
getData2('event_initiate_mail_sender.php','egyyp',cc);
}
function event_reject_mail(reject_reason){
	alert(reject_reason)
	
var cc='';
getData2('event_reject_mail_sender.php','egyyp',reject_reason);
}
function response_nameupdate(rfq_no,val,id){
    var type = val+'##'+id;
	getData2SpecialCharecter('response_name_ajax.php','response_name',rfq_no,type);
	
}


$(document).ready(function() {
    auction_item_live_changes();  // Call it once when the page loads
	<?php if($rfq_master->rfx_stage == 'Auction'): ?>
        setInterval(auction_item_live_changes, 5000);
    <?php endif; ?>
   
});
function auction_item_live_changes2() {
    var rfq_no = <?= $_SESSION['rfq_no'] ?>;
    var user_id = <?= $_SESSION['user']['id']; ?>;
	var bid_amount=$('#live_bid_item_amount').val();
	var bid_currency=$('#live_bid_currency').val();

    $.ajax({
        url: 'auction_item_live_api.php',
        type: 'POST',
        dataType: 'json',  // Expecting an HTML response
        contentType: 'application/json',
        data: JSON.stringify({
            rfq_no: rfq_no,
			bid_amount: bid_amount,
            bid_currency: bid_currency,
			user_id:user_id
        }),
        success: function(response) {
			console.log(response)

			response.forEach(function(item) {
				var row = $('#bid_row_show_' + item.item_id);
                $('#rank_show_id_' + item.item_id).text(item.price_rank);
				if(item.show_status=='expired'){
					row.find('button#vendor_auction_item_response').remove();
				}
				if(item.show_status=='active'){
					row.show();
				}

			
                
            });
        
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}
function auction_item_live_changes() {
    var rfq_no = <?= $_SESSION['rfq_no'] ?>;
    var user_id = <?= $_SESSION['user']['id']; ?>;
	var bid_amount=$('#live_bid_item_amount').val();
	var bid_currency=$('#live_bid_currency').val();

    $.ajax({
        url: 'auction_item_live_api.php',
        type: 'POST',
        dataType: 'json',  // Expecting an HTML response
        contentType: 'application/json',
        data: JSON.stringify({
            rfq_no: rfq_no,
			bid_amount: bid_amount,
            bid_currency: bid_currency,
			user_id:user_id
        }),
        success: function(response) {
			var total_value=0;
			var eventEndTimeFromInput = document.getElementById("event_end_date_show").value;
			response.forEach(function(item) {
				var row = $('#bid_row_show_' + item.item_id);
                $('#rank_show_id_' + item.item_id).text(item.price_rank);
                $('#total_amount_show_id_' + item.item_id).text(Number(item.total_amount).toLocaleString('en-US'));
                $('#lead_bid_show_id_' + item.item_id).text(Number(item.lead_bid).toLocaleString('en-US'));
				total_value += parseFloat(item.total_amount || 0);
				if(item.show_status=='expired'){
					row.find('button#vendor_auction_item_response').remove();
					$('#submitAllBids').remove();
				}
				if(item.show_status=='active'){
					row.show();

				}
                console.log(item.event_end_datetime+'jjjjj'+eventEndTimeFromInput);
				document.getElementById("event_end_date_show").value = item.event_end_datetime;
				var inputDate = new Date(eventEndTimeFromInput);  // Input is in "YYYY-MM-DDTHH:MM" format
				var itemEndDate = new Date(item.event_end_datetime.replace(' ', 'T'));  // Replace space with 'T' to match ISO format

				// Check if event_end_datetime from the item is greater than the input value
				console.log(item.event_end_datetime + 'jjjjj' + eventEndTimeFromInput); // Debugging

    if (itemEndDate > inputDate) {
					// Call startCountdown with the new values from the response
					console.log(item.event_end_date+'jjjjj'+item.event_end_time);
					startCountdown(item.event_end_date, item.event_end_time);

					// Set the new event_and_time value to the input field
					// document.getElementById("event_end_date_show").value = item.event_end_datetime;

					// Append the success message
					$('#time_extend_div').html('<div class="alert alert-warning" role="alert">Event Time Extended</div>');

					// Empty the div after 15 seconds
					setTimeout(function() {
						$('#time_extend_div').empty();
					}, 15000); // 15 seconds
				}
			
                
            });
			console.log('gggggggggggggggggggggggggggggggggggg'+total_value);
			$('#total_show').text(Number(total_value.toFixed(2)).toLocaleString('en-US'));
        
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}
function bidconsoletab(itemId,userId,rfqNo,response_id,itedetailsid) {
	var newURL = '?'+'tab4';
       history.pushState(null, null, newURL);
	   
	   var tabLinks = document.querySelectorAll('a[role="tab"]');
       tabLinks.forEach(function(tabLink) {
       tabLink.classList.remove("active"); });

    var rfq_no = <?= $_SESSION['rfq_no'] ?>;
    var user_id = <?= $_SESSION['user']['id']; ?>;


	$.ajax({
    url: 'bid_console_api.php',  // Your PHP script
    type: 'POST',
    dataType: 'json',  // Expecting JSON response now
    contentType: 'application/json',  // Sending JSON data
    data: JSON.stringify({
        rfq_no: rfq_no,
        item_id: itemId,
        user_id: user_id
    }),
    success: function(response) {
        // Replace the content of the div with the new table
        $('#auction_item_table_console').html(response.table);

		//if ($('#rfqChart').length === 0) {
        //$('#auction_item_table').after('<canvas id="rfqChart" width="400" height="200"></canvas>');
   // }

        // Generate the chart with the response data
        var ctx = document.getElementById('rfqChart').getContext('2d');
        new Chart(ctx, {
            type: 'line', // or 'bar', 'line', 'pie', etc.
            data: {
                labels: response.dates,  // X-axis labels (entry_at values)
                datasets: [{
                    label: 'Unit Price',
                    data: response.prices,  // Y-axis data (unit_price values)
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1
                }]
            },

        });
	var myLink = document.getElementById('bidconsole-tab');
	myLink.className="nav-link active";
	area_selector('tab4');
    },
    error: function(xhr, status, error) {
        console.error('Error:', error);
    }
});
}

function auction_item_bid_update(itemId, userId, rfqNo, response_id, itedetailsid, minUnitPrice, improvepercentage) {
    var bid_amount = $('#live_bid_item_amount_' + itemId).val();
    var bid_currency = $('#live_bid_currency_' + itemId).val();

    // Ensure bid_amount is a number for comparison
    var bidAmountNumber = parseFloat(bid_amount);

    if (isNaN(bidAmountNumber)) {
        alert('Please enter a valid bid amount.');
        return;
    }

    // Proceed with percentage check only if minUnitPrice is provided
    if (minUnitPrice) {
        // Convert minUnitPrice to a number
        var minUnitPriceNumber = parseFloat(minUnitPrice);
        if (isNaN(minUnitPriceNumber)) {
            console.error('Invalid minUnitPrice value');
        } else {
            // Calculate the percentage difference between minUnitPrice and bidAmount
            var percentageDifference = ((minUnitPriceNumber - bidAmountNumber) / minUnitPriceNumber) * 100;

            // Check if the percentage difference exceeds the improvepercentage
            if (percentageDifference > improvepercentage) {
                var confirmMessage = 'Your bid is ' + percentageDifference.toFixed(2) + '% lower than your previous bid. Do you want to proceed?';
                if (!confirm(confirmMessage)) {
                    // User chose to cancel, do nothing
                    return;
                }
            }
        }
    }

    // Proceed with the AJAX request if confirmed or if minUnitPrice is empty
    $.ajax({
        url: 'bid_update_api.php',
        type: 'POST',
        dataType: 'json',  // Expecting a JSON response
        contentType: 'application/json',
        data: JSON.stringify({
            bid_amount: bidAmountNumber,
            bid_currency: bid_currency,
            rfq_no: rfqNo,
            item_id: itemId,
            user_id: userId,
            response_id: response_id,
            item_details_id: itedetailsid
        }),
        success: function(response) {
            if (response.status === 'success') {


				    $('#alert_bid_div').append(response.alertmsg);
				// if (response.changeclock) {
				// 	startCountdown(response.eventEndDate, response.eventEndTime);
				// }
            } else {
				$('#alert_bid_div').append(response.alertmsg); // Show failure alert
            }

            setTimeout(function() {
                $('#alert_bid_div').html('');
            }, 7000);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

$('#submitAllBids').click(function () {
        var userId = <?= $_SESSION['user']['id'] ?>; // User ID
        var rfqNo = "<?= $_SESSION['rfq_no'] ?>"; // RFQ number
        var improvePercentage = 10; // Set your percentage for validation

        $('.tbody1 tr').each(function () {
            var itemId = $(this).find('#live_bid_item_id').val();
            var bidAmount = $(this).find('#live_bid_item_amount_' + itemId).val();
            var bidCurrency = $(this).find('#live_bid_currency_' + itemId).val();

            var minUnitPrice = $(this).find('#min_unit_price_' + itemId).val(); // Add a hidden field for min price or fetch dynamically
            var responseId = ""; // Replace with the actual response ID if applicable
            var itemDetailsId = ""; // Replace with actual item details ID if applicable

			// console.log('mmmmmmmmmmmm'+itemId);
			// console.log('mmmmmmmmmmmm'+bidAmount);
			// console.log('mmmmmmmmmmmm'+bidCurrency);

            if (itemId && bidAmount) {
				// console.log('sssssssssssssssssssssssssssssssss'); // Ensure all fields are filled
                auction_item_bid_update(
                    itemId,
                    userId,
                    rfqNo,
                    responseId,
                    itemDetailsId,
                    minUnitPrice,
                    improvePercentage
                );
            }
        });

        // alert('All bids have been processed.');
    });




function all_form_data(rfq_no){
	var form = document.getElementById('att_forms');
    var elements = form.elements;
    var concatenatedString = '';

    for (var i = 0; i < elements.length; i++) {
      if (elements[i].id && elements[i].value) {
	    if (elements[i].type === 'checkbox') {
                concatenatedString += elements[i].id + '#>' + (elements[i].checked ? elements[i].value : '') + '##';
          }else{
        		concatenatedString += elements[i].id + '#>' + elements[i].value + '##';
		 }
      }
    }
	document.getElementById('forms_submit_button').style.display='none';
	getData2('response_forms_ajax.php','all_form_data',rfq_no,concatenatedString);
}

</script>




<script src="document_script.js"></script>
<script>
  
  
     function settingF(tab){
		startCountdown("<?php echo $rfq->eventEndDate; ?>", "<?php echo $rfq->eventEndTime; ?>");
       var newURL = '?'+tab;
       history.pushState(null, null, newURL);
	   
	   var tabLinks = document.querySelectorAll('a[role="tab"]');
       tabLinks.forEach(function(tabLink) {
       tabLink.classList.remove("active"); });
	   
	   if(tab=='tab1'){
       var myLink = document.getElementById('settings-tab');
       
	   }else if(tab=='tab2'){

	   var myLink = document.getElementById('timeline-tab');
	   }else if(tab=='tab3'){
		
      //start calling APi
       	   termsConditionCheck(function(status) {
           

	   })
	  //end calling api





	   var myLink = document.getElementById('details-tab');
	   }else if(tab=='tab4'){
         

		termsConditionCheck(function(status) {
	 

 })






 var myLink = document.getElementById('bidconsole-tab');
 }
	   
	   
	   myLink.className="nav-link active";
	   area_selector(tab);
	   }


	   
	   
	   
	   function area_selector(tab){


	   document.getElementById('tab1').className="tab-pane fade";
	   document.getElementById('tab2').className="tab-pane fade";
	   document.getElementById('tab3').className="tab-pane fade";
	   document.getElementById('tab4').className="tab-pane fade";
	   
	   document.getElementById(tab).className="tab-pane fade show active";
	   
	   }

	   let countdownTimer;

	   function startCountdown(eventEndDate, eventEndTime) {
    // Combine the event date and time
    const eventEndTimeString = eventEndDate + ' ' + eventEndTime;
    const countdownDate = new Date(eventEndTimeString).getTime();

	if (countdownTimer) {
        clearInterval(countdownTimer);
    }

     countdownTimer = setInterval(function() {
        const now = new Date().getTime();
        const distance = countdownDate - now;

        // Calculate days, hours, and minutes
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

        // Update the display
        document.getElementById("days").innerText = formatTime(days);
        document.getElementById("hours").innerText = formatTime(hours);
        document.getElementById("minutes").innerText = formatTime(minutes);

        // If countdown finishes
        if (distance < 0) {
            clearInterval(countdownTimer);  // Stop the countdown
            document.getElementById("days").innerText = "00";
            document.getElementById("hours").innerText = "00";
            document.getElementById("minutes").innerText = "00";
        }
    }, 1000);  // Update the countdown every second
}





	   function termsConditionCheck(callback) {

		   var rfq_no=<?=$_SESSION['rfq_no']?>
            
			var xhr = new XMLHttpRequest();
			xhr.open('POST', 'participate_ajax.php', true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.send('data=' + rfq_no + '##' + 'checkedhhhh');
			xhr.onload = function() {
				if (xhr.status == 200) {
					var res = JSON.parse(xhr.responseText);
					if(res['status']=='success'){
					   callback="success";
				   }
				
				}
			};
		}

  
  var queryString = window.location.search;
  var queryStringWithoutQuestionMark = queryString.substring(1);
  window.onload = settingF(queryStringWithoutQuestionMark);
  
 
</script>


<!-- <script>
    const eventEndTime = "<?php echo $rfq->eventEndDate; ?> <?php echo $rfq->eventEndTime; ?>";
    const countdownDate = new Date(eventEndTime).getTime();

    const countdownTimer = setInterval(function() {
        const now = new Date().getTime();
        const distance = countdownDate - now;

       
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

        
        document.getElementById("days").innerText = formatTime(days);
        document.getElementById("hours").innerText = formatTime(hours);
		document.getElementById("minutes").innerText = formatTime(minutes);

        if (distance < 0) {
            clearInterval(countdownTimer);
            document.getElementById("days").innerText = "00";
            document.getElementById("hours").innerText = "00";
			document.getElementById("minutes").innerText = "00";
        }
    }, 1000);
</script> 
-->

<script> 
    function formatTime(time) {
        return time < 10 ? `0${time}` : time; 
    }
	
	
</script> 

<script>
	   <?if ($all_yes == false): ?>
				document.getElementById('want_to_participate_show').innerHTML='';
				document.getElementById('want_to_participate').checked=false;
		<?php endif; ?>
	</script>



<script src="chart.js"></script>
<script src="chartadapter.js"></script>

<script>

var elementPosition = $('#fixed').offset();

$(window).scroll(function(){
        if($(window).scrollTop() > elementPosition.top){
              $('#fixed').css('position','fixed').css('right','0').css('z-index','999').css('top','0');
        } else {
            $('#fixed').css('position','static');
        }    
});

</script>

<script>
setInterval(function() {
    // Check if the URL contains "tab8" and call the function if true
    if (window.location.href.indexOf("tab3") > -1 || window.location.href.indexOf("tab4")> -1) {
        bidconsoletab();
    }
}, 5000);

// Create an array to store generated colors
var usedColors = {};
var chartInstance = null; // Store the chart instance globally

function bidconsoletab(itemId) {
    var rfq_no = <?= $_SESSION['rfq_no'] ?>;
    var user_id = <?= $_SESSION['user']['id']; ?>;

    $.ajax({
        url: 'bid_selcted_vendor_graph_api.php',
        type: 'POST',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify({
            rfq_no: rfq_no,
            item_id: itemId
        }),
        success: function(response) {
            var ctx = document.getElementById('rfqChart').getContext('2d');
            var datasets = [];
            var allEntryDates = response.all_entry_dates; // X-axis data (all entry_at dates)

            // Loop through each vendor's data to create multiple lines
            response.vendors.forEach(function(vendor) {
                // Align the vendor's prices with the corresponding entry_at date on the X-axis
                var alignedPrices = allEntryDates.map(function(entryAt) {
                    // Return the price for this entry_at, or null if the vendor has no data for this entry_at
                    return vendor.prices[entryAt] || null;
                });

                // Check if the vendor already has a color, otherwise assign a new one
                if (!usedColors[vendor.vendor_name]) {
                    usedColors[vendor.vendor_name] = getUniqueRandomDarkColor();
                }

                datasets.push({
                    label: vendor.vendor_name, // Use vendor name as the label
                    data: alignedPrices, // Aligned prices for all entry_at dates
                    borderColor: usedColors[vendor.vendor_name], // Use the same color for each vendor
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 3, // Make the line thicker
                    fill: false, // Set to false for line graphs
                    spanGaps: true // This will connect the lines even when data points are missing
                });
            });

            // If the chart instance exists, update it, otherwise create it
            if (chartInstance) {
                chartInstance.data.labels = allEntryDates;
                chartInstance.data.datasets = datasets;
                chartInstance.update(); // Update the chart with new data
            } else {
                chartInstance = new Chart(ctx, {
                    type: 'line', // Use 'line' for multi-line graph
                    data: {
                        labels: allEntryDates, // X-axis labels (entry_at dates)
                        datasets: datasets // Data for each vendor
                    },
                    options: {
                        animation: false, // Disable animations
                        responsive: true,
                    }
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

// Utility function to generate a unique random dark color
function getUniqueRandomDarkColor() {
    var color;
    do {
        color = getRandomDarkColor();
    } while (Object.values(usedColors).includes(color)); // Regenerate if the color has been used
    return color;
}

// Function to generate a random dark color
function getRandomDarkColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        // Generate a darker shade by limiting the random range to darker values (e.g., 0 to 7)
        color += letters[Math.floor(Math.random() * 8)]; // This will give us darker colors
    }
    return color;
}

</script>

<?
require_once "../../../controllers/routing/layout.bottom.php";
?>