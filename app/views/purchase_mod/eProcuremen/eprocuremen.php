<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='eProcurement';

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
		<div class="pt-5" style=" font-size: 18px; padding-left: 2%;">Erp revenue Shar.... -Event #45304<span>(Active)</span></div>
	</div>
	<div class="col-sm-3 col-lg-3 col-md-3 col-3">
	    <label for="demo">Revisions</label>
		<div class="input-group mb-3">
		    <select>
				<option>--- Please Select ---</option>
				<option value="prod" selected>Prod</option>
				<option value="complete">Complete</option>
				<option value="sealed">Sealed</option>
				<option value="new">New</option>
			</select>
		</div>
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


<div class="tab-content" id="myTabContent">

				                
  <!--1st tab -->
  <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="settings-tab">
  
  <div class="row m-0 p-0 pt-4">
  	<div class="col-9"></div>
	<div class="col-3" align="center">
		<button type="button" class="btn1 btn1-bg-cancel">End Event</button>
		<button type="button" class="btn1 btn1-bg-update">Edit Event</button>
	</div>
  </div>
  
<!--  stype 1 start-->
  <div class="row m-0 p-0 pt-4">
  	<div class="col-6 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><i class="fa-solid fa-file-lines"></i> Basic Settings </h1>
		<hr class="m-3" />
		
		<table width="100%">
			<tr class="tr">
				<td class="td1">Event Name</td>
				<td class="td2">Erp revenue Sharing Model</td>
			</tr>
			
			<tr class="tr">
				<td class="td1">Currency</td>
				<td class="td2">BDT</td>
			</tr>
						
			<tr class="tr">
				<td class="td1">More Event Info</td>
				<td class="td2">input file</td>
			</tr>
						
			<tr class="tr">
				<td class="td1">Buyer Logo</td>
				<td class="td2"><img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" style="width:100px;" height="50px"> </td>
			</tr>
		</table>
		
	</div>
	
	<div class="col-6  pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><i class="fa-solid fa-file-lines"></i> Terms and Conditions </h1>
		<hr class="m-3" />
		
		<table width="100%">
			<tr class="tr">
				<td class="td1">Event Terms</td>
				<td class="td2">file.doc (-suppiler)
					<p class="p-0 m-0"> Supplier will be required to agree to terms electronically</p>
				</td>
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
				<td class="td2">None</td>
			</tr>
			
			<tr class="tr">
				<td class="td1">Event Commodity</td>
				<td class="td2">Platform as a Service (PaaS)</td>
			</tr>
						
			<tr class="tr">
				<td class="td1">Coupa Commodity</td>
				<td class="td2">IT Software and Applications</td>
			</tr>
						
			<tr class="tr">
				<td class="td1">Planned Savings</td>
				<td class="td2">0.00 BDT </td>
			</tr>
									
			<tr class="tr">
				<td class="td1">Cost Avoidance</td>
				<td class="td2">0.00 BDT </td>
			</tr>
									
			<tr class="tr">
				<td class="td1">Sourcing Type</td>
				<td class="td2">Competitive Bid </td>
			</tr>
									
			<tr class="tr">
				<td class="td1">RFx Reference #</td>
				<td class="td2"> kdlf </td>
			</tr>
									
			<tr class="tr">
				<td class="td1">References / Form #</td>
				<td class="td2"> 552128 </td>
			</tr>
									
			<tr class="tr">
				<td class="td1">Project Amount</td>
				<td class="td2">None </td>
			</tr>
									
			<tr class="tr">
				<td class="td1">Attachment 1</td>
				<td class="td2">None </td>
			</tr>
									
			<tr class="tr">
				<td class="td1">Attachment 1</td>
				<td class="td2">None </td>
			</tr>
												
			<tr class="tr">
				<td class="td1">Content Groups</td>
				<td class="td2">
  <input type="radio" id="vehicle1" name="vehicle11" value="Bike">
  <label for="vehicle1"><i class="fa-solid fa-users"></i> Everyone</label><br>
  
    <input type="radio" id="vehicle1" name="vehicle12" value="Bike">
  <label for="vehicle1"> Only members of tese content groups</label><br>
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
				<form action="">
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
				</form>
			</div>	
			<div class="col-6 p-0">
				<form action="">
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
				</form>
				
				
				
					
				<h1 class="h1 m-0 p-0 pb-1 pt-4"> Event Currencies & Exchange Rates <i class="fa-solid fa-circle-exclamation"></i> </h1>

				  <input type="checkbox" id="v001" name="v001" value="">
				  <label for="v001">Allow Suppliers to bid in any of these currencies</label><br>
		
					<div align="center">
						<button type="button" class="btn1 btn1-bg-cancel">End Event</button>
						<button type="button" class="btn1 btn1-bg-update">Edit Event</button>
					</div>
			</div>
		</div>		
	</div>
  </div>
  
  
<!-- stype 4th start-->
<div class="row m-0 p-0 pt-4">
  	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><i class="fa-solid fa-comment"></i> Comments </h1>
		<hr class="m-3" />
		<form action="">
		
		  <div class="form-group">
			<label for="exampleInputEmail1">Enter Comment</label>
			<textarea></textarea>
			<small id="emailHelp" class="form-text text-muted">Send comment notification to a user</small>
		  </div>
		  
		  	<div align="center" class="p-1">
		    	<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>		
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
		<form>
	  <div class="form-group">
		<label for="eventtimezone">Event Time Zone</label>
		<input type="text" class="form-control" id="eventtimezone" style="width: 40% !important;" />
	  </div>
	  <div class="form-group">
		<label for="eventsubmit">Event Submit</label>
		<input type="text" class="form-control" id="eventsubmit" style="width: 40% !important;" />
	  </div>
	  
	  <div class="form-group">
		<label for="eventstart">Event Start</label>
		<input type="text" class="form-control" id="eventstart" style="width: 40% !important;" />
	  </div>
	  
	  <div class="form-group">
		<label for="eventend">Event End</label>
		<input type="text" class="form-control" id="eventend" style="width: 20% !important;" />
		<input type="Date" class="form-control pt-1" id="eventend" style="width: 10% !important;" />
		<input type="time" class="form-control  pt-1" id="eventend" style="width: 10% !important;" />
	  </div>
	  

	</form>
	</div>
	
  </div>
                        


  <!--3rd tab -->
  <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="details-tab">
  
  
  <div class="row m-0 p-0 pt-4">
  	<div class="col-9"></div>
	<div class="col-3" align="center">
		<button type="button" class="btn1 btn1-bg-cancel">End Event</button>
		<button type="button" class="btn1 btn1-bg-update">Edit Event</button>
	</div>
  </div>
  

  <div class="row m-0 p-0 pt-4">
  	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3 text-center"><i class="fa-solid fa-message-arrow-up-right"></i> Supplier Response </h1>
		<h1 class="h1 m-0 p-0 pl-3"><i class="fa-solid fa-paperclip"></i> Attachments </h1>
		<hr class="m-3" />
		<!--  stype 1 start-->
		<div class="row m-0 p-0 pt-4">
			<div class="col-6  p-0">
			<h1 class="h1 m-0 p-0 pl-3">Attachments Section</h1>
			
			<div class="pl-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment Name </p>
				<p class="p-0 m-0" >Scope & ITB</p>
			</div>
			
			<div class="pl-3 pt-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment</p>
				<p class="p-0 m-0" >Attachment file.doc</p>
				<p class="p-0 m-0" >Attachment file.doc</p>
				<p class="p-0 m-0" >Attachment file.doc</p>
			</div>
			
				
			</div>	
			<div class="col-6 p-0">
				<p class="p-0 m-0 bold">Instructions to Supplier</p>
				<p class="p-0 m-0" >a. commercial offer titled as ....</p>
				<p class="p-0 m-0" >b. Tachnical offer for......</p>
				<form action="">
				  <input type="checkbox" id="sa2" name="sa2" value="sa2">
					<label for="sa2">Allow Supplier to response with attachment</label><br>
					
					<input type="checkbox" id="sa3" name="sa3" value="sa3">
					<label for="sa3">Make response required</label><br>
				</form>
				
			</div>
		</div>
		
		
		
		<!--stype 2nd start-->
		<div class="row m-0 p-0 pt-5">
			<div class="col-6  p-0">
			<h1 class="h1 m-0 p-0 pl-3">Attachments Section</h1>
			
			<div class="pl-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment Name </p>
				<p class="p-0 m-0" >Compliance Documents</p>
			</div>
			
			<div class="pl-3 pt-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment</p>
				<p class="p-0 m-0" >Attachment file.doc</p>
				<p class="p-0 m-0" >Attachment file.doc</p>
				<p class="p-0 m-0" >Attachment file.doc</p>
			</div>
			
				
			</div>	
			<div class="col-6 p-0">
				<p class="p-0 m-0 bold">Instructions to Supplier</p>
				<p class="p-0 m-0" >1. Sealed & signed-off Polices & compliance Sheets</p>
				<p class="p-0 m-0" >2. SRF in excel & PDF</p>
				<form action="">
				  <input type="checkbox" id="sa2" name="sa2" value="sa2">
					<label for="sa2">Allow Supplier to response with attachment</label><br>
					
					<input type="checkbox" id="sa3" name="sa3" value="sa3">
					<label for="sa3">Make response required</label><br>
				</form>
				
			</div>
		</div>
	</div>
	
	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><i class="fa-solid fa-list"></i> Items and Sercices</h1>
		<hr class="m-3" />
		
		<div class="pt-1">
  	<table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Name</th>
                        <th>Status</th>
						<th>My Capacity</th>
                        <th>Expected Qty</th>
						<th>MY Price</th>
						<th>Price x Expected Qty</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					
					    <tr>
							<td>supplier's name</td>
							<td> </td>
							<td> </td>
                            <td> 1.00</td>
							<td>0.50</td>
							<td>0.50 BDT</td>
                        </tr>							
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
		<button type="button" class="btn1 btn1-bg-cancel">End Event</button>
		<button type="button" class="btn1 btn1-bg-update">Edit Event</button>
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
					
					    <tr>
                            <td>12/11/2023</td>
							<td>sarwar jahan</td>
                            <td>remon sarwar</td>
                            <td> remonsarwar@gmail.com</td>
							<td>1</td>
                            <td> 1 of 1 Accepted</td>
                            <td> A month ago</td>
							<td> </td>
							<td><button type="button" class="btn2 btn1-bg-update"><i class="fa-regular fa-pen-to-square"></i></button></td>
                        </tr>
														
					</tbody>
                </table>
  
  
  
  
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
					
					    <tr>
							<td>Item name</td>
                            <td></td>
							<td> 2.00</td>
							<td> 0.00 BDT</td>
							<td>Action</td>
                        </tr>
					    <tr>
							<td>Item name</td>
                            <td></td>
							<td> 2.00</td>
							<td> 0.00 BDT</td>
							<td>Action</td>
                        </tr>
														
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
					
					    <tr>
							<td>ERP it ltd</td>
                            <td> CloudERP limited</td>
							<td>12-12-23 7.29 PM</td>
							<td>0.00 BDT</td>
							
							<td>100%</td>
                            <td> 20,000.00 BDT</td>
							<td>10,000 BDT</td>
							<td></td>
							
							<td></td>
                        </tr>
					
					    <tr>
							<td>ERP it ltd</td>
                            <td> CloudERP limited</td>
							<td>12-12-23 7.29 PM</td>
							<td>0.00 BDT</td>
							
							<td>100%</td>
                            <td> 20,000.00 BDT</td>
							<td>10,000 BDT</td>
							<td></td>
							
							<td></td>
                        </tr>
						
														
					</tbody>
                </table>
  
  
  
  
  </div>
		
		
		
	</div>
	
  </div>
				
  </div> 
  
</div>



</div>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>