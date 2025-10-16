<div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="suppliers-tab">
 
  <div class="row m-0 p-1 pt-4">
  	<div class="col-9"></div>

  </div>
  
  
  
    

  <div class="d-flex justify-content-between d-flex-bg-color">
	<div class="dropdown" id="dropdown">
		<button type="button" class="btn1 btn1-bg-submit" onclick="toggleDropdown()" style="margin-top: 7px !important;margin-bottom: 0px !important;">Add Supplier <em class="fa-light fa-chevron-down" style=" padding-left: 10px; font-weight: 600; "></em></button>
		  <div class="dropdown-content" id="myDropdown">
			<a href="">Add New</a>
		  </div>
	</div>
	
	<div class="d-flex justify-content-end"style=" padding: 7px; width: 600px;">
		<div class="form-group row m-0 p-0" style=" width: 300px; ">
		<label for="inputPassword" class="col-sm-2 col-form-label fs-14" style=" padding: 3px; color: white; font-weight: 600 !important; text-align: end; ">Search With</label>
		<div class="col-sm-10">
		        <select id="search_with" name="search_with" class="form-control" style="height: 28px !important;padding-top: 4px; ">
					
					<option value="vendor_name">Name</option>
					<option value="email">Email</option>
					<option value="contact_no">Contact Number</option>
					<option value="address">Address</option>
      			</select>
		</div>
	  </div>

	  <form class="form-inline m-0 p-0" action="">
		<div class="input-group" style=" background-color: white; border-radius: 5px; ">
				  <input type="text" name="search_box" id="search_box" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1" style="height: 28px !important;padding-top: 2px; border-right: none; ">
		  <button type="button" class="input-group-prepend" style=" width: 25%; height: 27px !important; border: none; border-radius: 0px 5px 5px 0px; background-color: white; " onclick="get_vendor(document.getElementById('search_with').value,document.getElementById('search_box').value)">
			<em class="fa-duotone fa-magnifying-glass fa-flip-horizontal fa-xl" style="--fa-primary-color: #b27d0a; --fa-secondary-color: #0ebadd; padding: 12px;"></em>
		  </button>
		</div>
	  </form>
	</div>
	  
</div>




<div class="row m-0 p-0 pt-4">
  	<div class="col-6 pt-4 pb-4">
		
		<table class="w-100">
				<tbody>
				<tr class="tr">
					<td class="td1">Company Name</td>
					<td class="td2"><input name="vendor_company" type="text" id="vendor_company" value="" ></td>
				</tr>
							<tr class="tr">
					<td class="td1">Contact Name</td>
					<td class="td2"><input name="contact_person_name" type="text" id="contact_person_name" value="" ></td>
				</tr>
							<tr class="tr">
					<td class="td1">Email</td>
					<td class="td2"><input name="email" type="email" id="email" value="" ></td>
				</tr>

				
			</tbody>
		</table>
		
	</div>
	
	<div class="col-6  pt-4 pb-4">
	<table class="w-100">
		  <tbody>
				<tr class="tr">
					<td class="td1">Language</td>
					<td class="td2">
							<input type="text" id="language" name="language" list="language_list" class="form-control">
								<datalist id="language_list">
							 <? foreign_relation('language_info','language','""','1')?>
							</datalist>
					
					</td>
				</tr>
				
				<tr class="tr">
					<td class="td1">Region</td>
					<td class="td2">
							<input type="text" id="country" name="country" list="country_list" class="form-control">
								<datalist id="country_list">
							 <? foreign_relation('country','country_name','""','1')?>
							</datalist>

					</td>
				</tr>
				
				<tr class="tr">
					<td class="td1">logo</td>
					<td class="td2"><input type="file" id="vendor_logo" name="vendor_logo" value="" ></td>
				</tr>
				
			</tbody>
		</table>
	
	
	</div>
	<div   style="width: 100%;"><? if($_SESSION['master_status']=='MANUAL'){?>
			<button type="button" class="btn1 btn1-bg-update" onclick="save_vendor(document.getElementById('vendor_company').value,document.getElementById('contact_person_name').value,document.getElementById('email').value,document.getElementById('language').value,document.getElementById('country').value)">Save</button><? } ?>
	</div>
  </div>

  
  
  
  
  
  
  
  
  

  <div class="pt-4">
  	<table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th scope="col">Date Added </th>
                        <th scope="col">Name</th>
                        <th scope="col">Contact Name</th>
						<th scope="col">Email</th>
                        <th scope="col"># of Responses</th>
                        <th scope="col">T&C</th>
                        <th scope="col">Last Seen</th>
						<th scope="col">Contracts</th>
						<th scope="col">Action</th>
                        
                    </tr>
                    </thead>
                    
					
                    <tbody class="tbody1" id="vendor_detailss">
					   <?
		 $sql = 'select v.*,r.id from vendor v,rfq_vendor_details r where v.vendor_id=r.vendor_id and r.rfq_no="'.$_SESSION[$unique].'"';
		 $qry = db_query($sql);
		 while($vendor=mysqli_fetch_object($qry)){
		
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
							<td><input type="checkbox" name="vendor_id_<?=$vendor->vendor_id?>" id="vendor_id_<?=$vendor->vendor_id?>" value="<?=$vendor->vendor_id?>" checked="checked"/>&nbsp;<? if($_SESSION['master_status']=='MANUAL'){?><button type="button" name="remove_vendor" class="btn2 btn1-bg-cancel" onclick="remove_vendor(<?=$vendor->id?>)">x</button><? } ?></td>
                        </tr>
						<? } ?>
														
					</tbody>
					
					
                </table>
  
  
  <form method="post">
   <div   class="p-1">
			    <? 
				if($_SESSION['master_status']=='MANUAL'){
				if($_SESSION[$unique]>0){?>
		    	
				<span id="mail_msg"><button type="button" class="btn1 btn1-bg-update" onclick="mail_send()">Send Mail To Supplier</button></span>
				<input type="submit" name="confirm" id="confirm" class="btn btn-primary" value="Confirm Event" />
				<? }else{?>
				<input type="submit" name="initiate" id="initiate" class="btn btn-primary" value="Save" />
				<? } } ?>
				
				<a href="rfq_preview.php" target="_blank" rel="noopener"><button type="button" class="btn btn-primary">Event Preview</button></a>
			</div>
			</form>
  </div>
  
		
				
  </div>