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
		<div class="pt-5" style=" font-size: 18px; padding-left: 2%;">Erp revenue Shar.... -Event #45304<span>(Active)</span></div>
	</div>
	<div class="col-sm-3 col-lg-3 col-md-3 col-3">
	    <label for="demo">Event End in</label>
		<div class="input-group mb-3">
			10 Days
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
    <a class="nav-link" id="details-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="details" aria-selected="false">Edite RFQ</a>
  </li>
  
</ul>


<div class="tab-content" id="myTabContent">

				                
  <!--1st tab -->
  <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="settings-tab">
  
  
  <div class="row m-0 p-0 pt-4">
  	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-1"> Event Type Settings </h1>
		<p class="p-0 pl-3">Updated "<span>Description</span>" from "<span>Erp revenue Share</span>" to "<span>Test RFQ</span>"</p>
		
		
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
		



		<h1 class="h1 m-0 p-0 pt-4 pl-3"><i class="fa-solid fa-comment"></i> Do you intend to participate in this event? </h1>
		<hr class="m-3" />
		<div class="pl-3">
			<input type="checkbox" id="re3" name="re3" value="re3">
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
			
				<form action="">
					&nbsp; &nbsp; <input type="radio" id="one" name="one" value="one">
					<label for="one">Yes</label><br>
					
					&nbsp; &nbsp; <input type="radio" id="two" name="two" value="two">
					<label for="two">No</label>
				</form>
				
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
			
				<form action="">
					&nbsp; &nbsp; <input type="radio" id="one" name="one" value="one">
					<label for="one">Yes</label><br>
					
					&nbsp; &nbsp; <input type="radio" id="two" name="two" value="two">
					<label for="two">No</label>
				</form>
				
			</div>
		</div>

  		<h1 class="h1 m-0 p-0 pt-4 pl-3"><i class="fa-duotone fa-calendar-days"></i> Timeline </h1>
		<hr class="m-3" />
		 
		
		<div align="center">
		<button class="btn1 btn1-bg-update">Enter Response</button>
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
  <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="details-tab">
  

  <div class="row m-0 p-0 pt-4">
  	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><i class="fa-solid fa-paperclip"></i> Attachments </h1>
		<hr class="m-3" />
		<!--  stype 1 start-->
		<div class="row m-0 p-0 pt-4">
			<div class="col-6  p-0">
						
			<div class="pl-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment Name </p>
			</div>
			
			<div class="pl-3 pt-3">
				<p class="p-0 m-0" style="font-weight:bold"> Instructions</p>
				<p class="p-0 m-0" >- Please attach the Technical Proposal (without price) file in this section</p>
				<p class="p-0 m-0" >- Please attach the Technical Proposal (without price) file in this section</p>
				<p class="p-0 m-0" >- Please attach the Technical Proposal (without price) file in this section</p>
			</div>
						
			<div class="pl-3 pt-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment </p>
				<p class="p-0 m-0" ><a href="#">document.doc</a></p>
			</div>
			
				
			</div>	
			<div class="col-6  p-0">
						
			<div class="pl-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment Name </p>
			</div>
									
			<div class="pl-3 pt-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment Add <input type="file" id="" name="" /> </p>
				<p class="p-0 m-0" ><a href="#">document.doc</a></p>
			</div>
			
				
			</div>
		</div>
		
		
		
		<!--stype 2nd start-->
		<hr />
		<div class="row m-0 p-0 pt-5">
			<div class="col-6  p-0">
						
			<div class="pl-3">
				<p class="p-0 m-0" style="font-weight:bold"> Compliance Documents </p>
			</div>
			
			<div class="pl-3 pt-3">
				<p class="p-0 m-0" style="font-weight:bold"> Instructions</p>
				<p class="p-0 m-0" >- Please attach the Technical Proposal (without price) file in this section</p>
				<p class="p-0 m-0" >- Please attach the Technical Proposal (without price) file in this section</p>
				<p class="p-0 m-0" >- Please attach the Technical Proposal (without price) file in this section</p>
			</div>
						
			<div class="pl-3 pt-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment </p>
				<p class="p-0 m-0" ><a href="#">document.doc</a></p>
			</div>
			
				
			</div>	
			<div class="col-6  p-0">
						
			<div class="pl-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment Name </p>
			</div>
									
			<div class="pl-3 pt-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment Add <input type="file" id="" name="" /> </p>
				<p class="p-0 m-0" ><a href="#">document.doc</a></p>
			</div>
			
				
			</div>
			
		</div>
		
		<!--stype 3rd start-->
		<hr />
		<div class="row m-0 p-0 pt-5">
			<div class="col-6  p-0">
						
			<div class="pl-3">
				<p class="p-0 m-0" style="font-weight:bold"> Draft Contract</p>
			</div>
			
			<div class="pl-3 pt-3">
				<p class="p-0 m-0" style="font-weight:bold"> Instructions</p>
				<p class="p-0 m-0" >- Please attach the Technical Proposal (without price) file in this section</p>
				<p class="p-0 m-0" >- Please attach the Technical Proposal (without price) file in this section</p>
				<p class="p-0 m-0" >- Please attach the Technical Proposal (without price) file in this section</p>
			</div>
						
			<div class="pl-3 pt-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment </p>
				<p class="p-0 m-0" ><a href="#">document.doc</a></p>
			</div>
			
				
			</div>	
			<div class="col-6  p-0">
						
			<div class="pl-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment Name </p>
			</div>
									
			<div class="pl-3 pt-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment Add <input type="file" id="" name="" /> </p>
				<p class="p-0 m-0" ><a href="#">document.doc</a></p>
			</div>
			
				
			</div>
			
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
					
					    <tr>
							<td>supplier's name</td>
							<td> </td>
                            <td> 1.00</td>
							<td>0.50</td>
							<td>0.50 BDT</td>
                        </tr>							
					</tbody>
                </table>
  
  
  		<div align="center" class="pt-4">
		<button class="btn1 btn1-bg-update">Enter Response</button>
		</div>
  
  </div>
		
		
		
	</div>
	
  </div>
  
				
  </div> 
  

</div>



</div>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>