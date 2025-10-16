<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Event Management';

do_calander("#f_date");
do_calander("#t_date");

$table_master='rfq_master';

$table_details='purchase_invoice';

$unique='rfq_no';
if($_GET['rfq_no']>0){
$$unique = $_SESSION[$unique] = $_GET['rfq_no'];
}
if(isset($_POST['initiate']))

{

		$crud   = new crud($table_master);

		if(!isset($_SESSION[$unique])){
		$_POST['rfq_date']=date('Y-m-d');
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:s:i');
		$_POST['eventStartDate'] = date('Y-m-d');
		$_POST['eventEndAt'] = $_POST['eventEndDate'].' '.$_POST['eventEndTime'];
		$_POST['event_info_file'] = upload_file("rfq","event_info_file",rand());
		$_POST['buyer_logo'] = upload_file("rfq","buyer_logo",rand());
		$_POST['event_terms_file'] = upload_file("rfq","terms_and_condition",rand());
		
		$_POST['internal_event_file1'] = upload_file("rfq","internal_event_file1",rand());
		$_POST['internal_event_file2'] = upload_file("rfq","internal_event_file2",rand());
		$_POST['internal_event_file3'] = upload_file("rfq","internal_event_file3",rand());
		
		$$unique=$_SESSION[$unique]=$crud->insert();
		unset($$unique);
		$tr_type="Initiate";
		$type=1;
		$msg='RFQ Generated. (RFQ No :-'.$_SESSION[$unique].')';
		
		


		}else{
		
		$_POST['event_info_file'] = upload_file("rfq","event_info_file",rand());
		$_POST['buyer_logo'] = upload_file("rfq","buyer_logo",rand());
		$_POST['event_terms_file'] = upload_file("rfq","terms_and_condition",rand());
		$_POST['internal_event_file1'] = upload_file("rfq","internal_event_file1",rand());
		$_POST['internal_event_file2'] = upload_file("rfq","internal_event_file2",rand());
		$_POST['internal_event_file3'] = upload_file("rfq","internal_event_file3",rand());
		
		$_POST['eventEndAt'] = $_POST['eventEndDate'].' '.$_POST['eventEndTime'];
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';

		}

}
$$unique=$_SESSION[$unique];

if(isset($_POST['confirm'])){
 $crud   = new crud($table_master);
 $_POST['eventStartDate'] = date('Y-m-d');
 $_POST['status'] = 'CHECKED';
 $crud   = new crud($table_master);
 $crud->update($unique);
 $type=1;
 unset($_SESSION[$unique]);
 unset($$unique);

}

if(isset($_POST['att_details'])){

$crud   = new crud("rfq_doc_details");

		if($_SESSION[$unique]>0){
		$_POST['rfq_no']=$_SESSION[$unique];
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:s:i');
		$_POST['att_file'] = upload_file("rfq","att_file",rand());
		$crud->insert();

		}

}

if(isset($_POST['vendor_details'])){

$crud   = new crud("rfq_vendor_details");

		if($_SESSION[$unique]>0){
		$sql = 'select * from vendor where 1';
		$qry = db_query($sql);
		while($vendor=mysqli_fetch_object($qry)){
		$vendor_id=$_POST['vendor_id_'.$vendor->vendor_id];
		if($vendor_id>0){
		$_POST['vendor_id']=$vendor_id;
		$_POST['rfq_no']=$_SESSION[$unique];
		
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:s:i');
		$_POST['att_file'] = upload_file("rfq","att_file",rand());
		$crud->insert();
        }
		}
		}

}


if(isset($_POST['item_details'])){

$crud   = new crud("rfq_item_details");

		if($_SESSION[$unique]>0){
		$item = end(explode("#",$_POST['item_id']));
		$_POST['item_id'] = $item;
		$_POST['rfq_no']=$_SESSION[$unique];
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:s:i');
		$crud->insert();

		}

}

if($_GET['del_id']>0){

		if($_SESSION[$unique]>0 && $_GET['del_id']>0){
		 $delete = 'delete from rfq_doc_details where id="'.$_GET['del_id'].'"';
		 db_query($delete);
		}
}

if($_GET['del_item_id']>0){

		if($_SESSION[$unique]>0 && $_GET['del_item_id']>0){
		 $delete = 'delete from rfq_item_details where id="'.$_GET['del_item_id'].'"';
		 db_query($delete);
		}
}

if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		foreach ($data as $key => $value)

		{ $$key=$value;}

		

}
//$$unique=$_SESSION[$unique];
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
	
						<div class="form-group row m-0 pb-1">
							<label for="po_no" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Event No & Name</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<input name="event_name" type="text" id="event_name" value="">
                            </div>
                        </div>
	</div>
	<div class="col-sm-3 col-lg-3 col-md-3 col-3">
	</div>
</div>






<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="settings-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="settings" aria-selected="true">Settings</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="timeline-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="timeline" aria-selected="false">Timeline</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="details-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="details" aria-selected="false">Details</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="suppliers-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="suppliers" aria-selected="false">Suppliers</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="evaluations-tab" data-toggle="tab" href="#tab5" role="tab" aria-controls="evaluations" aria-selected="false">Evaluations</a>
  </li>
   <li class="nav-item">
    <a class="nav-link" id="responses-tab" data-toggle="tab" href="#tab6" role="tab" aria-controls="responses" aria-selected="false">Responses</a>
  </li>
</ul>

<form action="" id="cz" method="post" enctype="multipart/form-data">
<div class="tab-content" id="myTabContent">

				                
  <!--1st tab -->
  <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="settings-tab">
  
<!--  stype 1 start-->
  <div class="row m-0 p-0 pt-4">
  	<div class="col-6 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><i class="fa-solid fa-file-lines"></i> Basic Settings </h1>
		<hr class="m-3" />
		
		<table width="100%">
			<tr class="tr">
				<td class="td1">Event Name</td>
				<td class="td2"><input name="event_name" type="text" id="event_name" value="<?=$event_name?>" /><input name="<?=$unique?>" type="hidden" id="<?=$unique?>"
				 value="<?=$$unique?>" /></td>
			</tr>
			
			<tr class="tr">
				<td class="td1">Currency</td>
				<td class="td2">
					<div class="input-group mb-3">
					  <input type="text" class="form-control" id="currency" name="currency" placeholder="0.00" value="<?=$event_name?>" />
					  <div class="input-group-append">
						<span class="input-group-text" id="basic-addon2">BDT</span>					  </div>
					</div>				</td>
			</tr>
						
			<tr class="tr">
				<td class="td1">More Event Info</td>
				<td class="td2"><input type="file" class="event_file" id="event_info_file" name="event_info_file"><? if($event_info_file!=''){?>
<?php /*?>				<a href="../../../assets/support/upload_view.php?name=<?=$event_info_file?>&folder=rfq&proj_id=<?=$_SESSION['proj_id']?>&mod=purchase_mod" target="_blank">Click Here</a><?php */?>
								<a href="../../../assets/support/upload_view.php?name=<?=$event_info_file?>&folder=rfq&proj_id=<?=$_SESSION['proj_id']?>" target="_blank">Click Here</a>
				<? } ?>
				
				</td>
			</tr>
						
			<tr class="tr">
				<td class="td1">Buyer Logo</td>
				<td class="td2"><input type="file" class="event_logo" id="buyer_logo" name="buyer_logo" />
			    <!--<img src="../../../assets/support/upload_view.php?name=<?=$buyer_logo?>&folder=rfq&proj_id=<?=$_SESSION['proj_id']?>&mod=purchase_mod" style="width:20%;" />-->
				<img src="../../../assets/support/upload_view.php?name=<?=$buyer_logo?>&folder=rfq&proj_id=<?=$_SESSION['proj_id']?>" style="width:20%;" />
				</td>
			</tr>
		</table>
		
	</div>
	
	<div class="col-6  pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><i class="fa-solid fa-file-lines"></i> Terms and Conditions </h1>
		<hr class="m-3" />
		
		<table width="100%">
			<tr class="tr">
				<td class="td1">Event Terms</td>
				<td class="td2"><input type="file" class="event_logo" id="terms_and_condition" name="terms_and_condition"><? if($event_terms_file!=''){?>
<?php /*?>				<a href="../../../assets/support/upload_view.php?name=<?=$event_terms_file?>&folder=rfq&proj_id=<?=$_SESSION['proj_id']?>&mod=purchase_mod" target="_blank">Click Here</a><?php */?>
								<a href="../../../assets/support/upload_view.php?name=<?=$event_terms_file?>&folder=rfq&proj_id=<?=$_SESSION['proj_id']?>" target="_blank">Click Here</a>
				<? } ?></td>
			</tr>
		</table>
	
	
	
		<h1 class="h1 m-0 p-0 pl-3 pt-3"><i class="fa-solid fa-file-lines"></i> Documents </h1>
		<hr class="m-3" />
		
		<table width="100%">
			<tr class="tr">
				<td class="td1">Related Documents</td>
				<td class="td2">None</td>
			</tr>
		</table>
	
		
		<h1 class="h1 m-0 p-0 pl-3 pt-3"><i class="fa-solid fa-file-lines"></i> Custom Objects </h1>
		<hr class="m-3" />
		
		<table width="100%">
			<tr class="tr">
				<td colspan="2" class="td2">None</td>
			</tr>
		</table>
	
	
	</div>
  </div>
  
<!--  stype 2nd start-->
<div class="row m-0 p-0 pt-4">
  	<div class="col-6 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><i class="fa-solid fa-file-lines"></i> Internal Event Info </h1>
		<hr class="m-3" />
		
		<table width="100%">
			<tr class="tr">
				<td class="td1">Tag</td>
				<td class="td2"><input type="text" class="tag" id="tag" name="tag" value="<?=$tag?>" /> </td>
			</tr>
			
			<tr class="tr">
				<td class="td1">Event Commodity</td>
				<td class="td2"><input type="text" class="commodity" id="commodity" name="commodity" value="<?=$commodity?>" /> </td>
			</tr>
						
			<tr class="tr">
				<td class="td1">Coupa Commodity</td>
				<td class="td2"><input type="text" class="coupa_commodity" id="coupa_commodity" name="coupa_commodity" value="<?=$coupa_commodity?>" /> </td>
			</tr>
						
			<tr class="tr">
				<td class="td1">Planned Savings</td>
				<td class="td2">
					<div class="input-group mb-3">
					  <input type="text" class="form-control" id="planned_savings" name="planned_savings" value="<?=$planned_savings?>" placeholder="0.00" />
					  <div class="input-group-append">
						<span class="input-group-text" id="planned_savings">BDT</span>
					  </div>
					</div> 
				</td>
			</tr>
									
			<tr class="tr">
				<td class="td1">Cost Avoidance</td>
				<td class="td2">
					<div class="input-group mb-3">
					  <input type="text" class="form-control" id="cost_avoidance" name="cost_avoidance" value="<?=$cost_avoidance?>" placeholder="0.00" />
					  <div class="input-group-append">
						<span class="input-group-text" id="planned_savings">BDT</span>
					  </div>
					</div> 
				</td>
			</tr>
									
			<tr class="tr">
				<td class="td1">Sourcing Type</td>
				<td class="td2">
					<select id="sourcing_type" name="sourcing_type">
					<option></option>
					  <option <?=($sourcing_type=='competitive')?'selected':''?> value="competitive">Competitive</option>
					  <option <?=($sourcing_type=='simplified')?'selected':''?> value="simplified">Simplified</option>
					</select>
				
				</td>
			</tr>
									
			<tr class="tr">
				<td class="td1">RFx Reference #</td>
				<td class="td2"> <input type="text" class="rfx_referance" id="rfx_referance" name="rfx_referance" value="<?=$rfx_referance?>" /> </td>
			</tr>
									
			<tr class="tr">
				<td class="td1">References / Form #</td>
				<td class="td2"> <input type="text" class="referance_form" id="referance_form" name="referance_form" value="<?=$referance_form?>" /> </td>
			</tr>
									
			<tr class="tr">
				<td class="td1">Project Amount</td>
				<td class="td2">
					<div class="input-group mb-3">
					  <input type="text" class="form-control" id="project_amount" name="project_amount" value="<?=$project_amount?>" placeholder="0.00" />
					  <div class="input-group-append">
						<span class="input-group-text" id="planned_savings">BDT</span>
					  </div>
					</div>
				 </td>
			</tr>
									
			<tr class="tr">
				<td class="td1">Attachment 1</td>
				<td class="td2"><input type="file" class="internal_event_file1" id="internal_event_file1" name="internal_event_file1"> <? if($internal_event_file1!=''){?>
<?php /*?>				<a href="../../../assets/support/upload_view.php?name=<?=$internal_event_file1?>&folder=rfq&proj_id=<?=$_SESSION['proj_id']?>&mod=purchase_mod" target="_blank">Click Here</a><?php */?>
								<a href="../../../assets/support/upload_view.php?name=<?=$internal_event_file1?>&folder=rfq&proj_id=<?=$_SESSION['proj_id']?>" target="_blank">Click Here</a>
				<? } ?>	 </td>
			</tr>
									
			<tr class="tr">
				<td class="td1">Attachment 2</td>
				<td class="td2"><input type="file" class="internal_event_file2" id="internal_event_file2" name="internal_event_file2">	<? if($internal_event_file2!=''){?>
<?php /*?>				<a href="../../../assets/support/upload_view.php?name=<?=$internal_event_file2?>&folder=rfq&proj_id=<?=$_SESSION['proj_id']?>&mod=purchase_mod" target="_blank">Click Here</a><?php */?>
								<a href="../../../assets/support/upload_view.php?name=<?=$internal_event_file2?>&folder=rfq&proj_id=<?=$_SESSION['proj_id']?>" target="_blank">Click Here</a>
				
				<? } ?> </td>
			</tr>
												
			<tr class="tr">
				<td class="td1">Attachment 3</td>
				<td class="td2"><input type="file" class="internal_event_file1" id="internal_event_file3" name="internal_event_file3">	<? if($internal_event_file3!=''){?>
<?php /*?>				<a href="../../../assets/support/upload_view.php?name=<?=$internal_event_file3?>&folder=rfq&proj_id=<?=$_SESSION['proj_id']?>&mod=purchase_mod" target="_blank">Click Here</a><?php */?>
								<a href="../../../assets/support/upload_view.php?name=<?=$internal_event_file3?>&folder=rfq&proj_id=<?=$_SESSION['proj_id']?>" target="_blank">Click Here</a>
				<? } ?> </td>
			</tr>
			
												
			<tr class="tr">
				<td class="td1">Other Notes/Comments</td>
				<td class="td2"><textarea id="other_notes" name="other_notes"><?=$other_notes?></textarea>	 </td>
			</tr>
												
			<tr class="tr">
				<td class="td1">Content Groups</td>
				<td class="td2">
  <input type="radio" id="content_group" name="content_group" value="Everyone">
  <label for="vehicle1"><i class="fa-solid fa-users"></i> Everyone</label><br>
  
    <input type="radio" id="content_group" name="content_group" value="Only members of this content groups">
  <label for="vehicle1"> Only members of this content groups</label><br>
				 </td>
			</tr>
			
			
		</table>
		
	</div>
	
	<div class="col-6  pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><i class="fa-solid fa-file-lines"></i> Event Team </h1>
		<hr class="m-3" />
		
		<a class="pl-3"><i class="fa-regular fa-user"></i> Parson 1 <span>(Creator)</span> </a> <br />
		<a class="pl-3"><i class="fa-regular fa-user"></i> Parson 2 <span>(Watcher)</span> </a> <br />
		<a class="pl-3"><i class="fa-regular fa-user"></i> Parson 3 <span>(Watcher)</span> </a> <br />
		<a class="pl-3"><i class="fa-regular fa-user"></i> Parson 4 <span>(Watcher)</span> </a> <br />
	
	
		<h1 class="h1 m-0 p-0 pl-3 pt-4"><i class="fa-solid fa-list"></i> Projects and Tasks </h1>
		<hr class="m-3" />
		
		<table width="100%">
			<tr class="tr">
				<td class="td1">Related Documents</td>
				<td class="td2">None</td>
			</tr>
		</table>
	
	
	</div>
  </div>
  
  
  
  
<!--stype 3rd start-->
  
<div class="row m-0 p-0 pt-4">
  	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><i class="fa-duotone fa-calendar-days"></i> Event Type Settings </h1>
		<hr class="m-3" />
		
		<div class="row m-0 p-0 pt-4">
			<div class="col-6  p-0">
				
				  <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
					<label for="vehicle1">RFx Stage</label><br>
					
					
					&nbsp; &nbsp; <input type="radio" id="rfi" name="rfi" value="RFI">
					<label for="rfi">RFI</label><br>
					&nbsp; &nbsp; <input type="radio" id="rfq" name="rfq" value="rfq">
					<label for="rfq">RFQ</label><br>
					&nbsp; &nbsp; <input type="radio" id="rfp" name="rfp" value="rfp">
					<label for="rfp">RFP</label>
				
					 <br>  
					 <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
					<label for="vehicle1">Auction Stage</label><br>
				
			</div>	
			<div class="col-6 p-0">
				
				  <input type="checkbox" id="vehicle" name="vehicle1" value="">
					<label for="vehicle">Allow multiple response</label><br>
					
					<input type="checkbox" id="ve3" name="ve3" value="ve3">
					<label for="ve3">Hide supplier response (sealed bid)</label><br>
					
					&nbsp; &nbsp; <input type="radio" id="unseal" name="unseal" value="unseal">
					<label for="unseal">Automaticall unseal when event ends</label><br>
					
					&nbsp; &nbsp; <input type="radio" id="Unseal" name="Unseal" value="Unseal">
					<label for="Unseal">Unseal manually</label><br>
					
					&nbsp; &nbsp; &nbsp; &nbsp; <input type="radio" id="one" name="one" value="one">
					<label for="one">In one envelope</label><br>
					
					&nbsp; &nbsp; &nbsp; &nbsp; <input type="radio" id="two" name="two" value="two">
					<label for="two">In two envelope</label>
					 <br>  
				  <input type="checkbox" id="vehicle14" name="vehicle14" value="">
				  <label for="vehicle14">Allow Suppliers to respond with attachments in Massage centre</label><br>
				
				
				
				
					
				<h1 class="h1 m-0 p-0 pb-1 pt-4"> Event Currencies & Exchange Rates <i class="fa-solid fa-circle-exclamation"></i> </h1>

				  <input type="checkbox" id="v001" name="v001" value="">
				  <label for="v001">Allow Suppliers to bid in any of these currencies</label><br>
		
			</div>
		</div>		
	</div>
  </div>
  
  
<!-- stype 4th start-->
<div class="row m-0 p-0 pt-4">
  	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><i class="fa-solid fa-comment"></i> Comments </h1>
		<hr class="m-3" />
		
		
		  <div class="form-group">
			<label for="exampleInputEmail1">Enter Comment</label>
			<textarea id="comment" name="comment"><?=$comment?></textarea>
			<small id="emailHelp" class="form-text text-muted">Send comment notification to a user</small>
		  </div>
		  
		  	<div align="center" class="p-1">
			    <? 
				if($_SESSION[$unique]>0){?>
		    	<input type="submit" name="initiate" id="initiate" class="btn btn-primary" value="Update" />
				<input type="submit" name="confirm" id="confirm" class="btn btn-primary" value="Confirm Event" />
				<? }else{?>
				<input type="submit" name="initiate" id="initiate" class="btn btn-primary" value="Save" />
				<? } ?>
			</div>
			
	</div>
  </div>
    
  
<!-- stype 5th start-->
<div class="row m-0 p-0 pt-4">
  	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><i class="fa-solid fa-clock-rotate-left"></i> History </h1>
		<hr class="m-3" />
		
		<div class="pl-3">
		<p class="p-0 m-0" style=" font-size: 16px !important; font-weight: 500; ">Md. Sarwar Jahan</p>
		<p class="p-0 m-0"> Comment will be hear</p>
		<p class="p-0 m-0"> on 20/12/23 at 12.25 AM</p>
		<hr />
		</div>
				
		<div class="pl-3">
		<p class="p-0 m-0" style=" font-size: 16px !important; font-weight: 500; ">Md. Remon Sarwar</p>
		<p class="p-0 m-0"> Comment will be hear</p>
		<p class="p-0 m-0"> on 23/12/23 at 11.12 AM</p>
		<hr />
		</div>
				
	</div>
  </div>
  
  
  
  </div>
		
  
  

  
				
  
  <!--2nd tab -->
  <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="timeline-tab">

	
	
	<div class="pt-5 pl-3">
		
	  <div class="form-group">
		<label for="eventtimezone">Event Time Zone</label>
					<select id="eventtimezone" name="eventtimezone" style="width: 40% !important;" >
					  <option value="0"></option>
					  <? foreign_relation('time_zone','id','concat(region," ",gmt)',$eventtimezone,'1')?>
					</select>
	  </div>
	  <!--<div class="form-group">
		<label for="eventsubmit">Event Submit</label>
					<select id="eventsubmit" name="eventsubmit" style="width: 40% !important;" >
					  <option value="1">option 1</option>
					  <option value="2">option 2</option>
					</select>
	  </div>-->
	  
	 <!-- <div class="form-group">
		<label for="eventstart">Event Start</label>
					<select id="eventsubmit" name="eventsubmit" style="width: 40% !important;" >
					  <option value="1">option 1</option>
					  <option value="2">option 2</option>
					</select>
	  </div>-->
	  
	  <div class="form-group">
		<label for="eventend">Event End</label>
		<!--<select id="eventend" name="eventend" style="width: 40% !important;" >
				<option value="1">option 1</option>
				<option value="2">option 2</option>
		</select>-->
		<input type="Date" class="form-control pt-1" id="eventEndDate" name="eventEndDate" value="<?=$eventEndDate?>" style="width: 12% !important;" />
		<input type="time" class="form-control  pt-1" id="eventEndTime" name="eventEndTime" value="<?=$eventEndTime?>"  style="width: 12% !important;" />
	  </div>
	  
	  <div align="center" class="p-1">
			    <? 
				if($_SESSION[$unique]>0){?>
		    	<input type="submit" name="initiate" id="initiate" class="btn btn-primary" value="Update" />
				<input type="submit" name="confirm" id="confirm" class="btn btn-primary" value="Confirm Event" />
				<? }else{?>
				<input type="submit" name="initiate" id="initiate" class="btn btn-primary" value="Save" />
				<? } ?>
			</div>
	  
	</div>
	
  </div>
                        


  <!--3rd tab -->
  <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="details-tab">  

  <div class="row m-0 p-0 pt-4">
  	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3 text-center"><i class="fa-solid fa-message-arrow-up-right"></i> Supplier Response </h1>
		<h1 class="h1 m-0 p-0 pl-3"><i class="fa-solid fa-paperclip"></i> Attachments </h1>
		<hr class="m-3" />
		<!--  stype 1 start-->
		<div class="row m-0 p-0 pt-4">
			<div class="col-6 ">
			<h1 class="h1 m-0 p-0 pl-3">Attachments Section</h1>
			
			<div class="pl-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment Name </p>
				<p class="p-0 m-0" ><input type="text" class="section_name" name="section_name" id="section_name" value=""> </p>
			</div>
			
			<div class="pl-3 pt-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment</p>
				<p class="p-0 m-0" ><input type="file" class="att_file" name="att_file" id="att_file"> </p>
				 <div align="right"><button type="submit" name="att_details" class="btn1 btn1-bg-update">Add Attachment</button></div>
			</div>
			
				
			</div>	
			<div class="col-6">
				<p class="p-0 m-0 bold">Instructions to Supplier</p>
				<p class="p-0 m-0" >
				
				<textarea id="terms" name="terms">
				
				</textarea>
				
				</p>
				
				  <input type="checkbox" id="att_response" name="att_response" value="1">
					<label for="sa2">Allow Supplier to response with attachment</label><br>
					
					<input type="checkbox" id="is_required" name="is_required" value="1">
					<label for="sa3">Make response required</label><br>
				
				
			</div>
		</div>
		
		
		<hr />
		<!--stype 2nd start-->
		<?
		 $sql = 'select * from rfq_doc_details where 1 and rfq_no="'.$_SESSION[$unique].'"';
		 $qry = db_query($sql);
		 while($doc=mysqli_fetch_object($qry)){
		?>
		<div class="row m-0 p-0 pt-4">
			<div class="col-6 ">
			<h1 class="h1 m-0 p-0 pl-3">Attachments-<?=++$i;?></h1>
			
			<div class="pl-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment Name </p>
				<p class="p-0 m-0" ><?=$doc->section_name?></p>
			</div>
			
			<div class="pl-3 pt-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment</p>
				<p class="p-0 m-0" ><? if($event_info_file!=''){?>
<?php /*?>				<a href="../../../assets/support/upload_view.php?name=<?=$doc->att_file?>&folder=rfq&proj_id=<?=$_SESSION['proj_id']?>&mod=purchase_mod" target="_blank">Click Here</a><?php */?>
								<a href="../../../assets/support/upload_view.php?name=<?=$doc->att_file?>&folder=rfq&proj_id=<?=$_SESSION['proj_id']?>" target="_blank">Click Here</a>
								
				<? } ?></p>
				 <div align="right"><a href="?del_id=<?=$doc->id?>"><button type="button" class="btn1 btn1-bg-cancel">Delete Section</button></a></div>
			</div>
			
				
			</div>	
			<div class="col-6">
				<p class="p-0 m-0 bold">Instructions to Supplier</p>
				<p class="p-0 m-0" >
				<?=$doc->terms?>
				</p>
				
				  <input type="checkbox" id="att_response2" name="att_response2" <?php if($doc->att_response>0) echo 'checked'; else echo '';?> >
					<label for="sa2">Allow Supplier to response with attachment</label><br>
					
					<input type="checkbox" id="is_required2" name="is_required2" <?php if($doc->is_required>0) echo 'checked'; else echo '';?>  >
					<label for="sa3">Make response required</label><br>
				
				
			</div>
		</div>
		<hr />
		<? } ?>
		
	</div>
	
	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><i class="fa-solid fa-list"></i> Items and Sercices</h1>
		<hr class="m-3" />
		
		<div class="pt-1">
  	<table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Name</th>
                        <th>Expected Qty</th>
						<th>Action</th>
						
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					
					    <tr>
							<td><input type="text" name="item_id" id="item_id" list="item" />
							<datalist id="item">
							 <? foreign_relation('item_info','concat(item_name,"#",item_id)','""','1')?>
							</datalist>
							</td>
							<td><input type="text" name="expected_qty" id="expected_qty" /></td>
							<td><button type="submit" name="item_details" class="btn1 btn1-bg-update">Add Item</button></td>
							
                        </tr>	
						
						<?
		 $sql = 'select r.*,i.item_name from rfq_item_details r, item_info i where i.item_id=r.item_id and r.rfq_no="'.$_SESSION[$unique].'"';
		 $qry = db_query($sql);
		 while($doc=mysqli_fetch_object($qry)){
		?>
						<tr>
							<td><?=$doc->item_name?></td>
							<td><?=$doc->expected_qty?></td>
							<td><a href="?del_item_id=<?=$doc->id?>"><button type="button" class="btn1 btn1-bg-cancel">Delete Item</button></a></td>
                            
                        </tr>	
						<? } ?>					
					</tbody>
                </table>
  
  
  
  
  </div>
		
		
		
	</div>
	
  </div>
  
				
  </div> 
  
  

  <!--4th tab -->
  <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="suppliers-tab">
 
  <div class="row m-0 p-1 pt-4">
  	<div class="col-9"></div>
	<div class="col-3" align="center">
		
		<button type="submit" name="vendor_details" class="btn1 btn1-bg-update">Assign Vendor</button>
	</div>
	
	
  </div>
  

  <div class="pt-4">
  	<table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Date Added </th>
                        <th>Name</th>
                        <th>Contact Name</th>
						<th>Email</th>
                        <th># of Responses</th>
                        <th>T&C</th>
                        <th>Last Seen</th>
						<th>Contracts</th>
						<th>Action</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					   <?
		 $sql = 'select * from vendor where 1';
		 $qry = db_query($sql);
		 while($vendor=mysqli_fetch_object($qry)){
		 $check = find_a_field('rfq_vendor_details','vendor_id','rfq_no="'.$_SESSION[$unique].'" and vendor_id="'.$vendor->vendor_id.'"');
		?>
					    <tr>
                            <td><?=$vendor->entry_at?></td>
							<td><?=$vendor->vendor_name.' ('.$vendor->vendor_id.')'?></td>
                            <td><?=$vendor->contact_no?></td>
                            <td><?=$vendor->email?></td>
							<td></td>
                            <td></td>
                            <td></td>
							<td></td>
							<td><input type="checkbox" name="vendor_id_<?=$vendor->vendor_id?>" id="vendor_id_<?=$vendor->vendor_id?>" value="<?=$vendor->vendor_id?>" <?php if($check>0) echo 'checked'; else echo '';?> /></td>
                        </tr>
						<? } ?>
														
					</tbody>
                </table>
  
  
  
   <div align="center" class="p-1">
			    <? 
				if($_SESSION[$unique]>0){?>
		    	<input type="submit" name="initiate" id="initiate" class="btn btn-primary" value="Update" />
				<input type="submit" name="confirm" id="confirm" class="btn btn-primary" value="Confirm Event" />
				<? }else{?>
				<input type="submit" name="initiate" id="initiate" class="btn btn-primary" value="Save" />
				<? } ?>
			</div>
  </div>
  
		
				
  </div> 
  
  

  <!--5th tab -->
  <div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="evaluations-tab">
  
 
  <div class="row m-0 p-1 pt-4">
  	<div class="col-9"></div>
	<div class="col-3" align="center">
		<button type="button" class="btn1 btn1-bg-cancel">End Event</button>
		<button type="button" class="btn1 btn1-bg-update">Edit Event</button>
	</div>
  </div>
  
  <div class="row m-0 p-0 pt-4">
  	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><i class="fa-solid fa-users"></i> Evaluation Team </h1>
		<hr class="m-3" />
		
		<div class="pt-4">
  	<table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Name</th>
                        <th>Role</th>
						<th>Evaluation Status</th>
                        <th>Sections</th>
						<th>Action</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					
					    <tr>
							<td>sarwar jahan</td>
                            <td>Creator</td>
							<td></td>
							<td> All</td>
							<td></td>
                        </tr>
						
						<tr>
							<td>Remon sarwar</td>
                            <td>Owner</td>
							<td></td>
							<td> All</td>
							<td></td>
                        </tr>
														
					</tbody>
                </table>
  
  
  
  
  </div>
		
		
		
	</div>
	
  </div>
  

				
  </div> 
  
    

  <!--6th tab -->
  <div class="tab-pane fade" id="tab6" role="tabpanel" aria-labelledby="responses-tab">
  
<div class="row m-0 p-0 pt-4">
  	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><i class="fa-solid fa-users"></i> Items and Services</h1>
		<hr class="m-3" />
		
		<div class="pt-4">
  	<table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Name</th>
                        <th>Awarded Supliers</th>
						<th>Expected Qty</th>
                        <th>Best Price</th>
						<th>Price x Expected Qty</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					  <?
		 $sql = 'select r.*,i.item_name from rfq_item_details r, item_info i where i.item_id=r.item_id and r.rfq_no="'.$_SESSION[$unique].'"';
		 $qry = db_query($sql);
		 while($item=mysqli_fetch_object($qry)){
		 $best_price = find_a_field('rfq_vendor_item_response','min(unit_price)','rfq_no="'.$_SESSION[$unique].'" and item_id="'.$item->item_id.'"');
		?>
					    <tr>
							<td><?=$item->item_name?></td>
                            <td></td>
							<td><?=$item->expected_qty?></td>
							<td><?=$best_price?></td>
							<td><?=$item->total_amount?></td>
							
                        </tr>
					   <? } ?>
														
					</tbody>
                </table>
  </div>
  

	</div>
	
	
	<!--2nd start-->
	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><i class="fa-solid fa-users"></i> Responses</h1>
		<hr class="m-3" />
		
		<div class="pt-1">
  	<table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Supplier</th>
                        <th>Response Name</th>
						<th>Submitted</th>
                        <th>Base Price</th>
						<th>Capacity</th>
						<th>Bid Price</th>
						<th>Savings</th>
						<th>Awarded?</th>
						<th>Actions</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					<?
		 $sql = 'select r.*,i.item_name,v.vendor_name from rfq_vendor_item_response r, item_info i, vendor v where r.vendor_id=v.vendor_id and i.item_id=r.item_id and r.rfq_no="'.$_SESSION[$unique].'"';
		 $qry = db_query($sql);
		 while($item=mysqli_fetch_object($qry)){
		?>
					    <tr>
							<td><?=$item->vendor_name?></td>
                            <td><?=$item->response_name?></td>
							<td><?=$item->entry_at?></td>
							<td><?=$item->base_price?></td>
							
							<td><?=$item->capacity?></td>
                            <td><?=$item->unit_price?></td>
							<td></td>
							<td></td>
							<td></td>
							
							<td></td>
                        </tr>
					<? } ?>
					    						
					</tbody>
                </table>
  
  
  
  
  </div>
		
		
		
	</div>
	
  </div>
				
  </div> 
  
</div>


</form>
</div>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>