<?php
require_once "../../../controllers/routing/layout.top.php";
$title='eProcurement';
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
do_calander("#f_date");
do_calander("#t_date");
$_POST['response_date']=date('Y-m-d');
$unique='rfq_no';
$table_master='rfq_master';
$_POST['entry_at']=date('Y-m-d H:i:s');
$_POST['entry_by']=$_SESSION['user']['id'];


if($_GET[$unique]>0){
	$_SESSION[$unique] = $_GET[$unique];
}

if($_GET['section_id']>0){
	$_SESSION['response_id'] = $_GET['section_id'];
	header('Location:vendor_entry_entry.php?tab3');
}


$response_id =0;

$rfq_no = $_SESSION[$unique];

$vendor = $_SESSION['vendor']['id'];
//unset($_SESSION['response_id']);
if(isset($_POST['enter_response'])){
   
	if($_SESSION['response_id']>0){
	    $response_id = $_SESSION['response_id'];
	}else{
	    $prev_response_id = find_a_field('rfq_vendor_response','id','vendor_id="'.$vendor.'" and rfq_no="'.$_SESSION[$unique].'" ');
		
		$Crud   = new Crud("rfq_vendor_response");
		$_POST['rfq_no']=$_SESSION[$unique];
		$_POST['vendor_id']=$vendor;
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
		
	}
	header('Location:vendor_entry_entry.php?tab3');
}
if($_SESSION['response_id']>0){
	$response_id = $_SESSION['response_id']; 
 }
 
$rfq_count = find_a_field('rfq_vendor_details','count(id)','vendor_id="'.$vendor.'" and rfq_no="'.$_SESSION[$unique].'" ');

	if($rfq_count>0){
		$rfq = find_all_field('rfq_master','','rfq_no="'.$_SESSION[$unique].'"');
		
		
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
    
   echo "<script>location.replace('vendor_entry.php');</script>";
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
		<?=$rfq->event_name;?> -Event #<?=$rfq_no?><span>(<? if($rfq->status=='CHECKED') {echo 'Active';} else {echo 'In Active';}?>)</span></div>
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
  
</ul>


<div class="tab-content" id="myTabContent">

				                
  <!--1st tab -->
  <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="settings-tab">
  <p class="m-1 fs-14 p-4 description" style="line-height: 1.6rem !important; text-align: justify !important; font-weight: 400 !important; color: #2f2f2f !important;"> 
  
  	<?=find_a_field('rfq_vendor_massage','vendor_massage','1')?>
  
  </p>
  
  
  <div class="row m-0 p-0 pt-4">
  	<div class="col-12 pt-4 pb-4">
	

		<h1 class="h1 m-0 p-0 pt-4 pl-3" style="font-size: 30px !important;"><em class="fa-solid fa-check-to-slot" style="color: #eb7100; font-size: 30px !important;"></em> Accept Terms and Conditions </h1>
		<hr style="height:1px;border:none;color:#333;background-color:#333;">
		<?php
		  $sql = 'select * from rfq_vendor_terms_condition where vendor_id='.$vendor.' and  rfq_no="'.$_SESSION[$unique].'"';
		  $qry = db_query($sql);
		  while($res = mysqli_fetch_object($qry)){
		  
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
	<div class="pl-3 row">
		<div class="col-sm-16 col-md-6 col-lg-6">
		<label class="inlineSelection" style="font-family: Helvetica,Arial,sans-serif !important; color: #60768a !important;font-size: 16px !important; 
		font-weight: 400 !important;">
		<input type="checkbox" name="intend_response" id="intend_response"  value="checked" <?php if($is_participate==1) echo 'checked'; ?>  >
		I intend to participate in this event
		</label>
		<br>
		<span style="font-family: Helvetica,Arial,sans-serif !important; color:">Buyer will be notified of your intent to participate.</span>
	</div>
	<span id="form_details"></span>
</div>	
<span id="participate_button">
	<button class="btn1 btn1-bg-update" id="details-tab" data-toggle="tab" href="#tab3" role="tab"  onclick="is_participate(document.getElementById('intend_response').value,<?=$rfq_no;?>);is_participate2(document.getElementById('intend_response').value,<?=$rfq_no;?>)" aria-controls="details" aria-selected="false">Submit Acceptence</button>
</span>
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
			<p class="p-0 pl-3 m-0 bold">Allow multiple response</p>
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
							<td><? if($total_amount>0) {echo 'Submitted';} else {echo 'Work';} ?> </td>
							<td><? if($result->entry_at !='') {echo date('m/d/y',strtotime($result->entry_at));}?></td>
                            <td> <?=$total_amount?></td>
							<td><a href="vendor_entry_entry.php?rfq_no=<?=$result->rfq_no;?>&section_id=<?=$result->id?>"> <button type="button" class="btn2 btn1-bg-update"><em class="fa-regular fa-pen-to-square"></em></button></a></td>
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
		<input id="response_name" required id="response_name" value="<?=$response_name->response_name;?>" type="text" style="outline-color: orange !important;" onblur="response_nameupdate(this.value,<?=$rfq->rfq_no;?>,<?=$response_id;?>)"   />
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
		$sql2 = 'select d.* from rfq_documents_information d where section_id = "'.$res->id.'" and rfq_no="'.$rfq->rfq_no.'" ';
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
								
				
							<span class="attachment-toggle-add-file icon-search fs-14" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">File</span>
							<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
							<span class="attachment-toggle-add-url icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Url</span>
							<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
							<span class="attachment-toggle-add-text icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Text</span>
		
						
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
									<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentseventinfo(this,'<?=$res1->documents_id?>','<?=$rfq->rfq_no?>','sourcing_attachment_response<?=$res->id;?>','<?=$_SESSION['user']['id']?>','fileuploadcontainer','attachmentshowcontainer')">
									<em class="fa-solid fa-xmark"></em></button>
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
									<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentURLseventinfo(this,'<?=$res1->documents_url_id?>' , '<?=$res1->rfq_no?>', 'sourcing_terms_buery_url', '<?=$res1->entry_by?>', 'attachmenturluploadcontainereventinfo','attachmentshowcontainereventinfo-url')"><em class="fa-solid fa-xmark"></em>
									</button>
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
						<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentTextseventinfo(this,'<?=$res1->documents_url_id?>', '<?=$res1->rfq_no?>', 'sourcing_attachment_response_text<?=$res->id?>', '<?=$res1->entry_by?>', 'attachmenttextuploadcontainereventinfo','attachmentshowcontainereventinfo-text')">
							<em class="fa-solid fa-xmark"></em>
						</button>
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

								</form>							<span class="attachment-toggle-add-file icon-search fs-14" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">File</span>
																<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
																<span class="attachment-toggle-add-url icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Url</span>
																<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
																<span class="attachment-toggle-add-text icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Text</span>
										  
										  
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
											<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentseventinfo(this,
                                   '<?=$item->attachment_id;?>',
                                   '<?=$item->rfq_no;?>',
                                   '<?=$item->tr_from;?>',
                                   '<?=$item->entry_by;?>',
                                   '<?=$motherContainerValue;?>',
                                   '<?=$datashowContainerValue;?>')">
												<em class="fa-solid fa-xmark"></em>
											</button>
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
															<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentTextseventinfo(this,'<?=$res100->documents_url_id?>', '<?=$res100->rfq_no?>', 'form_response<?=$res1->form_no?>', '<?=$res100->entry_by?>', 'attachmenttextuploadcontainereventinfo','attachmentshowcontainereventinfo-text')">
																<em class="fa-solid fa-xmark"></em>
															</button>
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
															<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentURLseventinfo(this,'<?=$res100->documents_url_id?>' , '<?=$res100->rfq_no?>', 'form_response<?=$res1->form_no?>', '<?=$res100->entry_by?>', 'attachmenturluploadcontainereventinfo','attachmentshowcontainereventinfo-url')"><em class="fa-solid fa-xmark"></em>
															</button>
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
		<div class="w-100">
				<button type="button" name="more_option" id="forms_submit_button" class="btn1 btn1-bg-update" onclick="all_form_data(<?=$rfq->rfq_no?>)" >Save</button>
		</div>
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
								
				
							<span class="attachment-toggle-add-file icon-search fs-14" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">File</span>
							<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
							<span class="attachment-toggle-add-url icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Url</span>
							<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
							<span class="attachment-toggle-add-text icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Text</span>
		
						
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
									<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentseventinfo(this,'<?=$res1->documents_id?>','<?=$rfq->rfq_no?>','details_item_response','<?=$_SESSION['user']['id']?>','fileuploadcontainer','attachmentshowcontainer')">
									<em class="fa-solid fa-xmark"></em></button>
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
									<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentURLseventinfo(this,'<?=$res1->documents_url_id?>' , '<?=$res1->rfq_no?>', 'sourcing_terms_buery_url', '<?=$res1->entry_by?>', 'attachmenturluploadcontainereventinfo','attachmentshowcontainereventinfo-url')"><em class="fa-solid fa-xmark"></em>
									</button>
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
						<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentTextseventinfo(this,'<?=$res1->documents_url_id?>', '<?=$res1->rfq_no?>', 'details_item_response_text', '<?=$res1->entry_by?>', 'attachmenttextuploadcontainereventinfo','attachmentshowcontainereventinfo-text')">
							<em class="fa-solid fa-xmark"></em>
						</button>
				</div>
			</div>
		   <? } ?>
							
							</div>
			  </div>
			
		</div>
		</div>
		
	<? } ?>	
		<hr class="m-3" />
		
		<div class="pt-1">
		<form action="" method="post" id="item_response_form">
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
	    
		<button class="btn1 btn1-bg-update active" type="button" name="vendor_item_response" id="vendor_item_response" onclick="item_form_submit(<?=$rfq->rfq_no?>,<?=$response_id;?>)" >Submit Response</button>
	</div>
	</form>	

	
	</div>
	
	</div>
	
				  
	</div> 



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
	getData2('first_response_ajax.php','response_button',rfq_no,type);
	
}



//function is_participate(val,rfq_no){
//   
//	getData2('participate_ajax.php','response_button',rfq_no,val);
//}

/////////////

 function is_participate(val,rfq_no) {
            
 	var xhr = new XMLHttpRequest();
 	xhr.open('POST', 'participate_ajax.php', true);
 	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
 	xhr.send('data=' + rfq_no + '##' + val);
 	xhr.onload = function() {
 		if (xhr.status == 200) {
 			var res = JSON.parse(xhr.responseText);
 			
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
			if( res['required'] >  res['completed']){
				alert('All required fields must be filled out');
			}else{
				ccmail();
				location.replace('vendor_entry.php');
			}
 			
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
function response_nameupdate(rfq_no,val,id){
    var type = val+'##'+id;
	getData2('response_name_ajax.php','response_name',rfq_no,type);
	
}


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
	   var myLink = document.getElementById('details-tab');
	   }
	   
	   myLink.className="nav-link active";
	   area_selector(tab);
	   }
	   
	   
	   function area_selector(tab){


	   document.getElementById('tab1').className="tab-pane fade";
	   document.getElementById('tab2').className="tab-pane fade";
	   document.getElementById('tab3').className="tab-pane fade";
	   
	   document.getElementById(tab).className="tab-pane fade show active";
	   
	   }
  
  var queryString = window.location.search;
  var queryStringWithoutQuestionMark = queryString.substring(1);
  window.onload = settingF(queryStringWithoutQuestionMark);
  
 
</script>


<script>
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

    function formatTime(time) {
        return time < 10 ? `0${time}` : time; 
    }
	
	
</script>

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


<?
require_once "../../../controllers/routing/layout.bottom.php";
?>