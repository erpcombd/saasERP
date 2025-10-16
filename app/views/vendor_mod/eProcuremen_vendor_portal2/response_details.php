<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Event Management';

do_calander("#f_date");
do_calander("#t_date");
$rfq = find_all_field('rfq_master','','rfq_no="'.$_GET['rfq_no'].'"');
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

<!--This css for clock start-->
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
  /*font-family: 'Orbitron', sans-serif !important;*/
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
		<div class="pt-5" style=" font-size: 18px; padding-left: 2%;"><?=$rfq->event_name.' # '.$rfq->rfq_no?><span>(Active)</span></div>
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
  <!--<li class="nav-item">
    <a class="nav-link active" id="settings-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="settings" aria-selected="true">Event Info</a>
  </li>
 <li class="nav-item">
    <a class="nav-link" id="timeline-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="timeline" aria-selected="false">My Responses</a>
  </li>-->

   <li class="nav-item">
    <a class="nav-link active" id="timeline-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="timeline" aria-selected="true">My Responses</a>
  </li>
  
</ul>


<div class="tab-content" id="myTabContent">

				                
  
 <form action="" method="post" id="cz" enctype="multipart/form-data">
  <div class="tab-pane  fade show active" id="tab2" role="tabpanel" aria-labelledby="details-tab">
  

  
  <div class="row m-0 p-0 pt-4">
  	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-1"> Event Type Settings </h1>
		<p class="p-0 pl-3">Updated "<span>Description</span>" from "<span>Erp revenue Share</span>" to "<span><?=$rfq->event_name?></span>"</p>
		
		
		<h1 class="h1 m-0 p-0 pt-4 pl-1"> Attachments </h1>
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
		<p class="p-0 pl-3">Participation and submission is easy and all done within the system. Response may require forms, attachments, price quotes and/or descriptions of products or services.</p>
		

      <? $terms = find_all_field('rfq_vendor_terms_condition','','rfq_no="'.$_GET['rfq_no'].'" and vendor_id="'.$vendor.'"')?>

		<h1 class="h1 m-0 p-0 pt-4 pl-3"><i class="fa-solid fa-comment"></i> Do you intend to participate in this event? </h1>
		<hr class="m-3" />
		<div class="pl-3">
			<input type="checkbox" id="is_participate" name="is_participate" value="1" <?php if($terms->is_participate>0) echo 'checked'; else echo '';?> >
			<label for="re3">I intend to participate in this event</label><br>
		</div>



		<h1 class="h1 m-0 p-0 pt-4 pl-3"><i class="fa-solid fa-comment"></i> Accept Terms and Conditions </h1>
		<hr class="m-3" />

		<div class="row m-0 p-0 pt-4">
			<div class="col-6 ">
					<p class="p-0 pl-3 bold">Terms and Conditions </p>
					<p class="p-0 pl-3">Please follow the ITB and Scope of work as well as commercial terms and conditions carefully.</p>
			</div>	
			<div class="col-6">
			<p class="p-0 pl-3 bold">Do you accept these Terms and Conditions?</p>
			
				
					&nbsp; &nbsp; <input type="radio" id="condition_1" name="condition_1" value="1" <?php if($terms->condition_1>0) echo 'checked'; else echo '';?>>
					<label for="one">Yes</label><br>
					
					&nbsp; &nbsp; <input type="radio" id="condition_1" name="condition_1" value="0" <?php if($terms->condition_1<1) echo 'checked'; else echo '';?>>
					<label for="two">No</label>
				
				
			</div>
		</div>		
	</div>
  </div>
  
<!--  stype 1 start-->
  <div class="row m-0 p-0 pt-4">
  	<div class="col-6 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><i class="fa-duotone fa-gear"></i> Event Information & Bidding Rules </h1>
		<hr class="m-3" />
		
		<p class="p-0 pl-3 ">Event will end at the Event End Time.</p>
		<p class="p-0 pl-3 m-0 bold">Responses are sealed until event closes</p>
		<p class="p-0 pl-3 m-0 bold">Buyer may choose to award individual line items</p>
	</div>
	
	<div class="col-6  pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><i class="fa-duotone fa-gear"></i> Buyer Attachments </h1>
		<hr class="m-3" />
		
		<p class="p-0 pl-3 "><a href="#">docx.pdf</a></p>	
	
	</div>
  </div>
  
<!--  stype 2nd start-->
  
		<h1 class="h1 m-0 p-0 pt-4 pl-3"><i class="fa-solid fa-comment"></i> Accept Terms and Conditions </h1>
		<hr class="m-3" />
		
  		<div class="row m-0 p-0 pt-4">
			<div class="col-6 ">
					<p class="p-0 pl-3 bold">Terms and Conditions </p>
					<p class="p-0 pl-3">Please follow the ITB and Scope of work as well as commercial terms and conditions carefully.</p>
			</div>	
			<div class="col-6">
			<p class="p-0 pl-3 bold">Do you accept these Terms and Conditions?</p>
			
				
					&nbsp; &nbsp; <input type="radio" id="condition_2" name="condition_2" value="1" <?php if($terms->condition_2>0) echo 'checked'; else echo '';?>>
					<label for="one">Yes</label><br>
					
					&nbsp; &nbsp; <input type="radio" id="condition_2" name="condition_2" value="0" <?php if($terms->condition_2<1) echo 'checked'; else echo '';?>>
					<label for="two">No</label>
				
				
			</div>
		</div>

  		<h1 class="h1 m-0 p-0 pt-4 pl-3"><i class="fa-duotone fa-calendar-days"></i> Timeline </h1>
		<hr class="m-3" />
		 
		
		<div align="center">
		<button name="terms_condition_response" class="btn1 btn1-bg-update">Enter Response</button>
		</div>
  
 
  
  
  <div class="row m-0 p-0 pt-4">
  	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><i class="fa-solid fa-paperclip"></i> Attachments </h1>
		<hr class="m-3" />
		<!--  stype 1 start-->
		<?
		 $sql = 'select * from rfq_doc_details where 1 and rfq_no="'.$_GET['rfq_no'].'"';
		 $qry = db_query($sql);
		 while($doc=mysqli_fetch_object($qry)){
		 $check_file = find_all_field('rfq_vendor_response','','rfq_no="'.$_GET['rfq_no'].'" and event_doc_details_id="'.$doc->id.'"');
		?>
		<div class="row m-0 p-0 pt-4">
			<div class="col-6  p-0">
						
			<div class="pl-3">
				<p class="p-0 m-0" style="font-weight:bold"> <?=$doc->section_name?><input type="hidden" name="file_name" value="<?=$doc->section_name?>" /> </p>
			</div>
			
			<div class="pl-3 pt-3">
				<p class="p-0 m-0" style="font-weight:bold"> Instructions</p>
				<!--<p class="p-0 m-0" >- Please attach the Technical Proposal (without price) file in this section</p>
				<p class="p-0 m-0" >- Please attach the Technical Proposal (without price) file in this section</p>
				<p class="p-0 m-0" >- Please attach the Technical Proposal (without price) file in this section</p>-->
				<?=$doc->terms?>
			</div>
						
			<div class="pl-3 pt-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment </p>
				<p class="p-0 m-0" ><? if($doc->att_file!=''){?><a href="../../../assets/support/upload_view.php?name=<?=$doc->att_file?>&folder=rfq&proj_id=<?=$_SESSION['proj_id']?>&mod=eProcurement_mod" target="_blank">Document</a><? } ?></p>
			</div>
			
				
			</div>	
			<div class="col-6  p-0">
						
			<div class="pl-3">
				<p class="p-0 m-0" style="font-weight:bold"> <?=$doc->section_name?> </p>
			</div>
									
			<div class="pl-3 pt-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment Add <input type="file" id="vendor_att<?=$doc->id?>" name="vendor_att<?=$doc->id?>" /> </p>
				<p class="p-0 m-0" ><?php if($check_file->att_file!=''){?><a href="../../../assets/support/upload_view.php?name=<?=$check_file->att_file?>&folder=rfq&proj_id=<?=$_SESSION['proj_id']?>&mod=vendor_mod" target="_blank">Document</a><? } ?></p>
			</div>
			
				
			</div>
		</div>
		<hr />
		<? } ?>
		<div align="center" class="pt-4">
		<button type="submit" name="vendor_response" class="btn1 btn1-bg-update">Enter Response</button>
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
						<th>My Capacity</th>
                        <th>Expected Qty</th>
						<th>MY Price</th>
						<th>Price x Expected Qty</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					
					    <?
		 $sql = 'select r.*,i.item_name from rfq_item_details r, item_info i where i.item_id=r.item_id and r.rfq_no="'.$_GET['rfq_no'].'"';
		 $qry = db_query($sql);
		 while($item=mysqli_fetch_object($qry)){
		?>
						<tr>
							<td><?=$item->item_name?></td>
							<td><input type="text" name="capacity<?=$item->id?>" value="" /></td>
							<td><input type="text" name="expected_qty<?=$item->id?>" id="expected_qty<?=$item->id?>" value="<?=$item->expected_qty?>" readonly="readonly" /></td>
							<td><input type="text" name="vendor_price<?=$item->id?>" id="vendor_price<?=$item->id?>" value="" onkeyup="cal(<?=$item->id?>)" /></td>
							<td><input type="text" name="vendor_total_amount<?=$item->id?>" id="vendor_total_amount<?=$item->id?>" value="" readonly="readonly" /></td>
							
                            
                        </tr>	
						<? } ?>							
					</tbody>
                </table>
  
  
  		<div align="center" class="pt-4">
		<button type="submit" name="vendor_item_response" class="btn1 btn1-bg-update">Enter Response</button>
		<button type="submit" name="confirm_response" class="btn1 btn1-bg-update">Confirm Response</button>
		</div>
  
  </div>
		
		
		
	</div>
	
  </div>
  
				
  </div> 
  </form>

</div>



</div>

<script>
 
 function cal(id){
 var price = document.getElementById('vendor_price'+id).value*1;
 var qty = document.getElementById('expected_qty'+id).value*1;
 var amount = price*qty;
 document.getElementById('vendor_total_amount'+id).value = amount;
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
      return time < 10 ? `0${time}` : time;
    }
  </script>
<!--this code for clock only end-->

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>