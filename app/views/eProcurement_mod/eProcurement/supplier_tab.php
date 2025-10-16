<div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="suppliers-tab" style=" min-height: 700px !important; ">
 
  <div class="row m-0 p-1 pt-4">
  	<div class="col-9"></div>

  </div>
  
			<? if($_SESSION['master_status']=='COMPLETE'){ } else{?>
			
  <div class="d-flex justify-content-between d-flex-bg-color">
	<div class="dropdown" id="dropdown">
		<button type="button" class="btn1 btn1-bg-submit" data-toggle="modal" data-target="#addVendorSection" style="margin-top: 7px !important;margin-bottom: 0px !important;">Add New Supplier </button>
		  <div class="dropdown-content" id="myDropdown">
			<a href="">Add New</a>
		  </div>
	</div>
	
	<div class="d-flex justify-content-end"style=" padding: 7px; width: 600px;">
		<div class="form-group row m-0 p-0" style=" width: 350px; ">
		<label for="inputPassword" class="col-sm-4 col-form-label fs-14" style=" padding: 3px; color: white; font-weight: 600 !important; text-align: end; ">Search With</label>
		<div class="col-sm-8">
		        <select id="search_with" name="search_with" class="form-control" style="height: 28px !important;padding-top: 4px; ">
					<!--<option value="">All</option>-->
					<option value="vendor_name">Name</option>
					<option value="email">Email</option>
					<option value="vendor_category">Category</option>
					<option value="contact_no">Contact Number</option>
					<option value="address">Address</option>
      			</select>
		</div>
	  </div>

	  <form class="form-inline m-0 p-0" action="">
		<div class="input-group" style=" background-color: white; border-radius: 5px; ">
				  <input type="text" name="search_box" id="search_box" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1" style="height: 28px !important;padding-top: 2px; border-right: none; " list="vendorList">
				  <datalist id="vendorList">
				  <? foreign_relation('vendor','vendor_name','""',$search_box,'1');?>
				  </datalist>
		  <button type="button" class="input-group-prepend" style=" width: 25%; height: 27px !important; border: none; border-radius: 0px 5px 5px 0px; background-color: white; " onclick="get_vendor(document.getElementById('search_with').value,document.getElementById('search_box').value)">
			Search
		  </button>
		</div>
	  </form>
	</div>
	  
</div>
	<? } ?>


<div class="modal fade" id="addVendorSection" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 650px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Supplier </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  
	  <form id="htmlForm" method="post" action="">
		<div class="col-12 pt-4 pb-4">
			<div class="pt-1">
					<div class="row m-0 p-0 pt-4">
					<div class="col-6 ">
					<table  class="w-100">
				<caption></caption>
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">Suppliers Name</td>
						<td class="td2">
						<input  name="<?=$unique?>" id="<?=$unique?>" value="<?=$_SESSION[$unique]?>" type="hidden" />
						<input name="group_for" required type="hidden" id="group_for" tabindex="1" value="1" >
						<input  name="vendor_name" required type="text" id="vendor_name" tabindex=1 value="<?=$vendor_name?>" required>
						
						</td>
					</tr>
										
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">Suppliers Category	</td>
						<td class="td2">
							<select name="vendor_category" required id="vendor_category"  tabindex=2 required>
									<option></option>
									<? foreign_relation('vendor_category v','v.id','v.category_name',$vendor_category,'v.status="ACTIVE" and v.group_for="'.$_SESSION['user']['group'].'"');?>
							</select>
						</td>
					</tr>
							
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">Primary Contact Name	</td>
						<td class="td2"><input name="contact_person_name" type="text" id="contact_person_name" tabindex=3 value="<?=$contact_person_name?>" /></td>
					</tr>
							
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">Primary Contact Email</td>
						<td class="td2"><input  name="email" type="email" id="email" tabindex=4 value="<?=$email?>" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email address." onkeyup="userCopy(this.value)"/><span id="emailError" style="color: red; font-size: 0.9em;"></span></td>
					</tr>
					
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">Current Address</td>
						<td class="td2"><input  name="address" type="text" id="address" tabindex=5 value="<?=$address?>" required/></td>
					</tr>
					
			</table>
					</div>
					
					<div class="col-sm-6 col-md-6 col-lg-6">
		
		
					<table  class="w-100">
					    <caption></caption>
				
				
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">Supplier User ID</td>
						<td class="td2"><input required type="text" name="tin" id="tin" value="<?=$tin;?>" tabindex=6  /></td>
					</tr>
					
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">Status</td>
						<td class="td2">
						<select name="status" id="status" required="required" tabindex=7 >
                              <option value="ACTIVE">ACTIVE</option>

                               <option value="INACTIVE">INACTIVE</option>


                        </select>
						</td>
					</tr>
					
					
					<tr class="tr">
						<td class="td1 fs-14 bold">Secondary Contact Name</td>
						<td class="td2"><input type="text" name="beneficiary_name" id="beneficiary_name" value="<?=$beneficiary_name?>"  tabindex=8 /></td>
					</tr>
					
					<tr class="tr">
						<td class="td1 fs-14 bold">Secondary Contact Email</td>
						<td class="td2"><input type="email" name="cc_email" id="cc_email" value="<?=$cc_email?>"  tabindex=9/></td>
					</tr>
							
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">Country</td>
						<td class="td2"><input required name="country" type="text" id="country" tabindex=10 value="<?=$country?>" /></td>
					</tr>
						
			</table>

		</div>
                    
                    <div  class="pt-2" style=" width: 100%;" id="html_details">	
						
					</div>
                    
                   <div   style="width: 100%;"><? if($_SESSION['master_status']=='MANUAL' && $_SESSION['user_role']=='Owner'){?>
<button type="button" class="btn1 btn1-bg-update" onclick="save_vendor(

			 		document.getElementById('group_for').value,
					document.getElementById('vendor_name').value,
					document.getElementById('vendor_category').value,
					document.getElementById('contact_person_name').value,
					document.getElementById('email').value,
					document.getElementById('address').value,
					
					document.getElementById('beneficiary_name').value,
					document.getElementById('status').value,
					document.getElementById('tin').value,
					document.getElementById('cc_email').value,
			 
			 document.getElementById('country').value)" data-dismiss="modal">Save</button><? } ?>
	</div>
					
				</div>
			
			</div>
		</div>
        </form>
	  
    </div>
  </div>
</div>


<div id="MailMsg" style="margin-top:30px; background-color:green; color:White;width:100%"></div>
  <div class="pt-4">
  	<span id="vendor_detailss"></span><br />
				
				
				<table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
					<tr>
					 <th class=" req-input" scope="col" colspan="9" style="text-align:center;">Selected Supplier</th>
					</tr>
                    <tr class="bgc-info">
                        <th scope="col">Date Added </th>
                        <th scope="col">Name</th>
                        <th scope="col">Contact Name</th>
						<th scope="col">Email</th>
                        <th scope="col">T&C </th>
						<th scope="col">Offer Submitted</th>
						<th scope="col">Last Seen/View</th>
						<th scope="col">Action</th>
						<th scope="col">Notify</th>
                        
                    </tr>
                    </thead>
                    
					
                    <tbody class="tbody1" id="selected_vendor_detailss">
					
					   <?
		 $sql = 'select v.*,r.id from vendor v,rfq_vendor_details r where v.vendor_id=r.vendor_id and r.rfq_no="'.$_SESSION[$unique].'"';
		 $qry = db_query($sql);
		 if(mysqli_num_rows($qry)<1){
		 ?>
		 <tr>
					 <td colspan="9" style="text-align:center;">..Empty..
					 <input type="hidden" name="supplier_count" id="supplier_count" value="0"  /></td>
					</tr>
					
		 <?
		 }
		 $supplier_count = 0;
		 while($vendor=mysqli_fetch_object($qry)){
		 $supplier_count++;
		 
		 $acceptTC = find_a_field('rfq_vendor_terms_condition','count(id)','rfq_no="'.$_SESSION[$unique].'" and vendor_id = "'.$vendor->vendor_id.'"');
		 
		 $requiredFile = find_a_field('rfq_documents_information','count(tr_from)','tr_from like "sourcing_terms_condition" and rfq_no="'.$_SESSION[$unique].'" ');
		 $requiredText = find_a_field('rfq_documents_url_information','count(tr_from)','tr_from like "sourcing_terms_condition" and rfq_no="'.$_SESSION[$unique].'" ');
		 $offer_submitted = find_a_field('rfq_vendor_response','count(id)','rfq_no='.$_SESSION[$unique].' and status like "SUBMITED" and vendor_id = "'.$vendor->vendor_id.'" ');
		 $last_seen = find_a_field('vendor_entry_log','field_value','rfq_no='.$_SESSION[$unique].' and field_name like "Last Seen" and vendor_id = "'.$vendor->vendor_id.'" ');
		
		?>
					    <tr>
                            <td><?=$vendor->entry_at?></td>
							<td><?=$vendor->vendor_name.' ('.$vendor->vendor_id.')'?></td>
                            <td><?=$vendor->contact_person_name?></td>
                            <td><?=$vendor->email?></td>
							<td><?php echo $acceptTC;?>/<?php echo ($requiredFile+$requiredText);?></td>
							<td><?=$offer_submitted;?></td>
							<td><?=$last_seen;?></td> 
							<td><? if($_SESSION['master_status']=='MANUAL'){?><button type="button" name="remove_vendor" class="btn2 btn1-bg-cancel" onclick="remove_vendor(<?=$vendor->id?>)">x</button><? } ?></td>
							<td><button type="button" onclick="notify_supplier_individual('<?=$vendor->email?>')" class="btn btn-primary">Resend</button></td>
                        </tr>
						<? } ?>
						<input type="hidden" name="supplier_count" id="supplier_count" value="<?=$supplier_count?>"  />
														
					</tbody>
					
					
                </table>
  
   <div id="testmail"></div>

  <div class="pt-4 pb-4">
  <h2><span style="text-align:center; font-size:20px;">Mail Template</span></h2>
  <hr />
  <?php include 'email_preview.php';?>
  </div>
  <form method="post">
   <div   class="p-2" id="preview_button">
			  
		    	
				<!--<span id="mail_msg"><button type="button" class="btn1 btn1-bg-update" onclick="mail_send()">Send Mail To Supplier</button></span>-->
				<!--<a href="email_preview.php" target="_blank" rel="noopener"><button type="button" class="btn btn-primary">Email Preview</button></a>-->
				<!--<input type="submit" name="confirm" id="confirm" class="btn btn-primary" value="Submit Event" />-->
				
				<? if($_SESSION['master_status']=='MANUAL' && $_SESSION['user_role']=='Owner'){?>
				<? if($rfq_data->rfx_stage=='Template'){ }else{ ?>
				<button type="button" onclick="required_field_check()" class="btn btn-primary">Event Preview Before Submission</button>
				<!--<button type="button" onclick="test()" class="btn btn-primary">.</button> -->
				<? } ?>
				<a href="rfq_preview.php" rel="noopener"></a>
				<? } ?>
				 
				
				
			</div>
			</form>
  </div>
  
		
				
  </div>