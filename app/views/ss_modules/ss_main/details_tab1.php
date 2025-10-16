<style>
 #loader {
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.7); /* Semi-transparent white background */
        display: flex;
        justify-content: center;
        align-items: center;
        display: none; /* Initially hidden */
    }

    .loader-spinner {
        border: 8px solid #f3f3f3; /* Light grey */
        border-top: 8px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite; /* Animation for rotation */
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="details-tab">
  <div class="row m-0 p-0 pt-4">
  	<div class="col-12 pt-4 pb-4">
		
		
		<h1 class="h1 m-0 p-0 pl-3">
			<em class="fa-solid fa-paperclip"></em> 
			<!--This button is a attachments modal Start-->
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addattachments">General Section</button>
			<!--This button is a attachments modal End-->
		</h1>
		<hr class="m-3" />


<!--Attachments Modal Start-->
<div class="modal fade" id="addattachments" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 650px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">General Section </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  
	  <form method="post" id="att_details_section" enctype="multipart/form-data">
      <div class="modal-body">
		<!--Attachments Modal body Start-->

		<div class="row m-0 p-0 pt-4">
		
			<div class="col-6">			
			<div class="pl-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment Name </p>
				<p class="p-0 m-0" ><input type="text" class="section_name" name="gsection_name" id="gsection_name" value=""><input type="hidden" class="section_type" name="gsection_type" id="gsection_type" value="general"> </p>
			</div>
			
			<div class="pl-3 pt-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment</p>
				<p class="p-0 m-0" ><input type="file" name="details_doc[]" class="att_file" id="att_file_general" accept="*/*" multiple> </p>

			</div>
			
				
			</div>	
			<div class="col-6">
				<p class="p-0 m-0 bold">Instructions to Supplier</p>
				<p class="p-0 m-0">
				
				<textarea id="gterms" name="gterms" rows="2" cols="5" placeholder="Instruction.."></textarea>
				
				</p>
				
				  <input type="checkbox" id="att_response_general" name="att_response_general" value="1">
					<label for="sa2">Allow Supplier to response with attachment</label><br>
					
					<input type="checkbox" id="is_required_general" name="is_required_general" value="1">
					<label for="sa3">Make response required</label><br>
				
				
			</div>
		</div>
		
        
		<!--Attachments Modal body end-->
      </div>
      <div class="modal-footer justify-content-center">
	  			<? if($_SESSION['master_status']=='MANUAL'){?>
				 <button type="button" name="att_details" class="btn1 btn1-bg-update" id="uploadButton" onclick="event_att_insert(document.getElementById('gsection_name').value,document.getElementById('gterms').value,document.getElementById('gsection_type').value,document.getElementById('att_response_general').value,document.getElementById('is_required_general').value,'details_att_general')" data-dismiss="modal">Add Attachment</button>
				 <? } ?>
				 
      </div>
	  </form>
	  
    </div>
  </div>
</div>
<!--Attachments Modal End-->	

<div class="accordion" id="accordionExample">
  <div class="card">
  <button class="btn btn-link collapsed p-0" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
    <div class="card-header" id="headingTwo">
       <h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-list"></em> General Section</h1>
    </div>
	</button>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
	  <!--Attachments Section View Body strat-->
	  
	  
	  <span id="details_att_general">
		<?
		 $sql = 'select * from rfq_doc_details where 1 and rfq_no="'.$_SESSION[$unique].'" and section_type="general"';
		 $qry = db_query($sql);
		 while($doc=mysqli_fetch_object($qry)){
		?>
		<div class="row m-0 p-0 pt-4">
			<div class="col-6 ">
			<div class="pl-3">
				<p class="p-0 m-0" style="font-weight:bold"> <?=$doc->section_name?> </p>
			<? $att_sql = 'select * from rfq_documents_information where section_id="'.$doc->id.'" and rfq_no="'.$_SESSION[$unique].'"';
			 $att_qry = db_query($att_sql);
			 while($att_data=mysqli_fetch_object($att_qry)){
			?>
			
				<p class="p-0 m-0" >
				<a href="../../../controllers/utilities/api_upload_attachment_show.php?name=<?=$att_data->new_name?>&&folder=doc_section" target="_blank" rel="noopener">
												<em class="fa-light fa-file fa-2xl fs-22" style="color: #d6960a;"></em> 
												<span><?=$att_data->original_name?></span>
											</a></p>
			
			<? } ?>
			</div>
			<div class="pl-3 pt-3">
				 <div >
				 <? if($_SESSION['master_status']=='MANUAL'){?>
				 <button type="button" name="add_event_team" 
		class="btn2 btn1-bg-cancel" onclick="event_details_att_cancel('general',<?=$doc->id?>,'details_att_general')">Delete</button>
		 <? } ?>
		</div>
			</div>
			
				
			</div>	
			<div class="col-6">
				<p class="p-0 m-0 bold">Instructions to Supplier</p>
				<p class="p-0 m-0" >
				<?=$doc->terms?>
				</p>
				
				  <input type="checkbox" id="att_response2" name="att_response2" <?php if($doc->att_response>0) {echo 'checked';} else {echo '';}?> >
					<label for="sa2">Allow Supplier to response with attachment</label><br>
					
					<input type="checkbox" id="is_required2" name="is_required2" <?php if($doc->is_required>0) {echo 'checked';} else {echo '';}?>  >
					<label for="sa3">Make response required</label><br>
				
				
			</div>
		</div>
		<? } ?>
		</span>
	  
	  
	  
	  <!--Attachments Section View Body end-->
      </div>
    </div>
  </div>
  
</div>
		



<h1 class="h1 m-0 p-0 pl-3">
			<em class="fa-solid fa-paperclip"></em> 
			<!--This button is a attachments modal Start-->
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#technicalSection">Technical Section</button>
			<!--This button is a attachments modal End-->
			
		</h1>
		<hr class="m-3" />


<!--Attachments Modal Start-->
<div class="modal fade" id="technicalSection" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 650px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Technical Section </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  
	  <form method="post" id="att_details_section" enctype="multipart/form-data">
      <div class="modal-body">
		<!--Attachments Modal body Start-->

		<div class="row m-0 p-0 pt-4">
		
			<div class="col-6">			
			<div class="pl-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment Name </p>
				<p class="p-0 m-0" ><input type="text" class="tsection_name" name="tsection_name" id="tsection_name" value=""><input type="hidden" class="tsection_type" name="tsection_type" id="tsection_type" value="technical"></p>
			</div>
			
			<div class="pl-3 pt-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment</p>
				<p class="p-0 m-0" ><input type="file" name="details_doc[]" class="att_file" id="att_file_technical" accept="*/*" multiple> </p>

			</div>
			
				
			</div>	
			<div class="col-6">
				<p class="p-0 m-0 bold">Instructions to Supplier</p>
				<p class="p-0 m-0">
				
				<textarea id="tterms" name="tterms" rows="2" cols="5" placeholder="Instruction.."></textarea>
				
				</p>
				
				  <input type="checkbox" id="att_response_technical" name="att_response_technical" value="1">
					<label for="sa2">Allow Supplier to response with attachment</label><br>
					
					<input type="checkbox" id="is_required_technical" name="is_required_technical" value="1">
					<label for="sa3">Make response required</label><br>
				
				
			</div>
		</div>
		
        
		<!--Attachments Modal body end-->
      </div>
      <div class="modal-footer justify-content-center">
	  			<? if($_SESSION['master_status']=='MANUAL'){?>
				 <button type="button" name="att_details" class="btn1 btn1-bg-update" id="uploadButton" onclick="event_att_insert(document.getElementById('tsection_name').value,document.getElementById('tterms').value,document.getElementById('tsection_type').value,document.getElementById('att_response_technical').value,document.getElementById('is_required_technical').value,'details_att_technical')" data-dismiss="modal">Add Attachment</button>
				 <? } ?>
				 
      </div>
	  </form>
	  
    </div>
  </div>
</div>		
		
<div id="loader">
    <div class="loader-spinner"></div>
</div>

<!--Attachments Section View Start-->
<div class="accordion" id="showTechSection">
  <div class="card">
  <button class="btn btn-link collapsed p-0" type="button" data-toggle="collapse" data-target="#techView" aria-expanded="false" aria-controls="collapseTwo">
    <div class="card-header" id="headingTwo">
       <h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-list"></em> Technical Section</h1>
    </div>
	</button>
    <div id="techView" class="collapse" aria-labelledby="headingTwo" data-parent="#showTechSection">
      <div class="card-body">
	  <!--Attachments Section View Body strat-->
	  
	  
	  <span id="details_att_technical">
		<?
		 $sql = 'select * from rfq_doc_details where 1 and rfq_no="'.$_SESSION[$unique].'" and section_type="technical"';
		 $qry = db_query($sql);
		 while($doc=mysqli_fetch_object($qry)){
		?>
		<div class="row m-0 p-0 pt-4">
			<div class="col-6 ">
			<div class="pl-3">
				<p class="p-0 m-0" style="font-weight:bold"> <?=$doc->section_name?> </p>
			<? $att_sql = 'select * from rfq_documents_information where section_id="'.$doc->id.'" and rfq_no="'.$_SESSION[$unique].'"';
			 $att_qry = db_query($att_sql);
			 while($att_data=mysqli_fetch_object($att_qry)){
			?>
			
				<p class="p-0 m-0" >
				<a href="../../../controllers/utilities/api_upload_attachment_show.php?name=<?=$att_data->new_name?>&&folder=doc_section" target="_blank" rel="noopener">
												<em class="fa-light fa-file fa-2xl fs-22" style="color: #d6960a;"></em> 
												<span><?=$att_data->original_name?></span>
											</a></p>
			
			<? } ?>
			</div>
			<div class="pl-3 pt-3">
				 <div >
				 <? if($_SESSION['master_status']=='MANUAL'){?>
				 <button type="button" name="add_event_team" 
		class="btn2 btn1-bg-cancel" onclick="event_details_att_cancel('technical',<?=$doc->id?>,'details_att_technical')">Delete</button>
		 <? } ?>
		</div>
			</div>
			
				
			</div>	
			<div class="col-6">
				<p class="p-0 m-0 bold">Instructions to Supplier</p>
				<p class="p-0 m-0" >
				<?=$doc->terms?>
				</p>
				
				  <input type="checkbox" id="att_response2" name="att_response2" <?php if($doc->att_response>0) {echo 'checked';} else {echo '';}?> >
					<label for="sa2">Allow Supplier to response with attachment</label><br>
					
					<input type="checkbox" id="is_required2" name="is_required2" <?php if($doc->is_required>0) {echo 'checked';} else {echo '';}?>  >
					<label for="sa3">Make response required</label><br>
				
				
			</div>
		</div>
		<? } ?>
		</span>
	  
	  
	  
	  <!--Attachments Section View Body end-->
      </div>
    </div>
  </div>
  
</div>
<!--Attachments Section View End-->



<h1 class="h1 m-0 p-0 pl-3">
			<em class="fa-solid fa-paperclip"></em> 
			<!--This button is a attachments modal Start-->
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCommercialSection">Commercial Section</button>
			<!--This button is a attachments modal End-->
		</h1>
		<hr class="m-3" />


<!--Attachments Modal Start-->
<div class="modal fade" id="addCommercialSection" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 650px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Commercial Section </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  
	  <form method="post" id="att_details_section" enctype="multipart/form-data">
      <div class="modal-body">
		<!--Attachments Modal body Start-->

		<div class="row m-0 p-0 pt-4">
		
			<div class="col-6">			
			<div class="pl-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment Name </p>
				<p class="p-0 m-0" ><input type="text" class="csection_name" name="csection_name" id="csection_name" value=""><input type="hidden" class="csection_type" name="csection_type" id="csection_type" value="commercial"></p>
			</div>
			
			<div class="pl-3 pt-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment</p>
				<p class="p-0 m-0" ><input type="file" name="details_doc[]" class="att_file" id="att_file_commercial" accept="*/*" multiple> </p>

			</div>
			
				
			</div>	
			<div class="col-6">
				<p class="p-0 m-0 bold">Instructions to Supplier</p>
				<p class="p-0 m-0">
				
				<textarea id="cterms" name="cterms" rows="2" cols="5" placeholder="Instruction.."></textarea>
				
				</p>
				
				  <input type="checkbox" id="att_response_commercial" name="att_response_commercial" value="1">
					<label for="sa2">Allow Supplier to response with attachment</label><br>
					
					<input type="checkbox" id="is_required_commercial" name="is_required_commercial" value="1">
					<label for="sa3">Make response required</label><br>
				
				
			</div>
		</div>
		
        
		<!--Attachments Modal body end-->
      </div>
      <div class="modal-footer justify-content-center">
	  			<? if($_SESSION['master_status']=='MANUAL'){?>
				 <button type="button" name="att_details" class="btn1 btn1-bg-update" id="uploadButton" onclick="event_att_insert(document.getElementById('csection_name').value,document.getElementById('cterms').value,document.getElementById('csection_type').value,document.getElementById('att_response_commercial').value,document.getElementById('is_required_commercial').value,'details_att_commercial')" data-dismiss="modal">Add Attachment</button>
				 <? } ?>
				 
      </div>
	  </form>
	  
    </div>
  </div>
</div>		
		
<div class="accordion" id="showItemInfo">
  <div class="card">
  <button class="btn btn-link collapsed p-0" type="button" data-toggle="collapse" data-target="#itemView" aria-expanded="false" aria-controls="collapseTwo">
    <div class="card-header" id="headingTwo">
      <h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-list"></em> Commercial Section</h1>
    </div>
	</button>
    <div id="itemView" class="collapse" aria-labelledby="headingTwo" data-parent="#showItemInfo">
      <div class="card-body">
	  <!--Attachments Section View Body strat-->
	  
	  <span id="details_att_commercial">
		<?
		 $sql = 'select * from rfq_doc_details where 1 and rfq_no="'.$_SESSION[$unique].'" and section_type="commercial"';
		 $qry = db_query($sql);
		 while($doc=mysqli_fetch_object($qry)){
		?>
		<div class="row m-0 p-0 pt-4">
			<div class="col-6 ">
			<div class="pl-3">
				<p class="p-0 m-0" style="font-weight:bold"> <?=$doc->section_name?> </p>
			<? $att_sql = 'select * from rfq_documents_information where section_id="'.$doc->id.'" and rfq_no="'.$_SESSION[$unique].'"';
			 $att_qry = db_query($att_sql);
			 while($att_data=mysqli_fetch_object($att_qry)){
			?>
			
				<p class="p-0 m-0" >
				<a href="../../../controllers/utilities/api_upload_attachment_show.php?name=<?=$att_data->new_name?>&&folder=doc_section" target="_blank" rel="noopener">
												<em class="fa-light fa-file fa-2xl fs-22" style="color: #d6960a;"></em> 
												<span><?=$att_data->original_name?></span>
											</a></p>
			
			<? } ?>
			</div>
			<div class="pl-3 pt-3">
				 <div >
				 <? if($_SESSION['master_status']=='MANUAL'){?>
				 <button type="button" name="add_event_team" 
		class="btn2 btn1-bg-cancel" onclick="event_details_att_cancel('commercial',<?=$doc->id?>,'details_att_commercial')">Delete</button>
		 <? } ?>
		</div>
			</div>
			
				
			</div>	
			<div class="col-6">
				<p class="p-0 m-0 bold">Instructions to Supplier</p>
				<p class="p-0 m-0" >
				<?=$doc->terms?>
				</p>
				
				  <input type="checkbox" id="att_response2" name="att_response2" <?php if($doc->att_response>0) {echo 'checked';} else {echo '';}?> >
					<label for="sa2">Allow Supplier to response with attachment</label><br>
					
					<input type="checkbox" id="is_required2" name="is_required2" <?php if($doc->is_required>0) {echo 'checked';} else {echo '';}?>  >
					<label for="sa3">Make response required</label><br>
				
				
			</div>
		</div>
		<? } ?>
		</span>
		
	  
	  <div class="col-12 pt-4 pb-4">
		
		<td class="td2">
			 <div class="row">
              
			<span class=" pl-4 fs-18 bold">Attachments</span> <div class="col-6 attachment-toggle">
								
								
								<span class="attachment-toggle-add-file icon-search fs-14" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">File</span>
																
										   
										  
										  <div class="fileuploadcontainer" >
														
												<form  id="attachmentuploadFormxx" enctype="multipart/form-data">
												<input type="hidden" name="rfq_no" value="<?=$_SESSION[$unique]?>">
												<input type="hidden" name="tr_from" value="details_item">
												<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
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
												  <em class="fa-light fa-cloud-arrow-up fa-2xl"></em>
												  </div>
												
												</div>
												
											  </div>
											  <input type="checkbox" name="sendtosuppliercheckbox" id="sendtosuppliercheckbox" checked>
												<label for="sendtosuppliercheckbox">Send to Supplier</label>
												  <button type="submit" class="d-none"  name="submit" value="Go" class="attachment-toggle-add-file"><em class="fa fa-fw fa-search"></em></button>
												
												</form>
										  </div>
															
															<div class="attachmenturluploadcontainer" >
														
																<form  id="attachmenturluploadForm1" enctype="multipart/form-data">
																<input type="hidden" name="rfq_no" value="<?=$_SESSION[$unique]?>">
																<input type="hidden" name="tr_from" value="details_item">
																<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
																<input type="hidden" name="motherContainer" value="ttttttttttt">
																<input type="hidden" name="datashowContainer" value="attachmentUrlshowcontainer">
																
																<div class="attachment-icon-close-container">
																	<em class="attachment-toggle-add-url fa fa-fw fa-close"></em>
																</div>
																
																<p>Add Your URL here</p>
																<input  type="text" name="attachmenturlinput" id="attachmenturlinput">
																
																<input type="checkbox" name="sendtosuppliercheckbox" id="sendtosuppliercheckbox" checked>
																   <label for="sendtosuppliercheckbox">Send to Supplier</label><br>
																  <button type="submit"  name="submit" value="Go" class="attachment-toggle-add-file btn btn-info">ADD</button>
																
																</form>
															</div>
											  <div class="attachmenttextuploadcontainer" >
														
												<form  id="attachmenttextuploadForm" enctype="multipart/form-data">
												<input type="hidden" name="rfq_no" value="<?=$_SESSION[$unique]?>">
												<input type="hidden" name="tr_from" value="details_item">
												<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
												<input type="hidden" name="motherContainer" value="attachmenttextuploadcontainer">
												<input type="hidden" name="datashowContainer" value="attachmentTextshowcontainer">
												
												<div class="attachment-icon-close-container">
												  <em class="attachment-toggle-add-text fa fa-fw fa-close"></em>
												</div> 
												
												<p>Add Your Text here</p>
												<input  type="text" name="attachmenttextinput" id="attachmenttextinput">
												
												<input type="checkbox" name="sendtosuppliercheckbox" id="sendtosuppliercheckbox" checked>
												  <label for="sendtosuppliercheckbox">Send to Supplier</label><br>
												  <button type="submit"  name="submit" value="Go" class="attachment-toggle-add-file btn btn-info">ADD</button>
												
												</form>
											</div>
											<div class="attachmentshowcontainer container row m-0">
                        <?
						  $sql = 'SELECT * FROM rfq_documents_information WHERE rfq_no = "'.$_SESSION[$unique].'" AND tr_from ="details_item"';
						  $qry = db_query($sql);
						  while($item=mysqli_fetch_object($qry)){
						?>
                                      <div class="col-sm-10 col-md-10 col-lg-10 pb-1">
										<div class="rounded p-2" style="background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
										<a href="../../../controllers/utilities/api_upload_attachment_show.php?name=<?=$item->new_name?>&folder=<?=$item->tr_from?>" target="_blank" rel="noopener">												<em class="fa-light fa-file fa-2xl fs-22" style="color: #d6960a;"></em> 
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



                       <?}?>
						</div>
											  <div class="attachmentUrlshowcontainer container row m-0">
												
											  <?php
												$sql = 'select * from rfq_documents_url_information where tr_from like "details_item" and rfq_no="'.$_SESSION[$unique].'" and entry_by = "'.$_SESSION['user']['id'].'"  AND attachment_url IS NOT NULL';
												$qry = db_query($sql);
												while($res = mysqli_fetch_object($qry)){
												
											?>
												<div class="col-sm-12 col-md-12 col-lg-12 pb-1">
													<div class="rounded p-2" style=" word-break: break-all; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
														<span><em class="fa-solid fa-text-size fa-xl" style="color: #df5c16;"></em>
															<span><?=$res->attachment_url?></span></span>
															<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentTextseventinfo(this,'<?=$res->documents_url_id?>', '<?=$res->rfq_no?>', '5', '<?=$res->entry_by?>', 'attachmenttextuploadcontainereventinfo','attachmentshowcontainereventinfo-text')">
																<em class="fa-solid fa-xmark"></em>
															</button>
													</div>
												</div>
											<? } ?>
											  </div>
											  <div class="attachmentTextshowcontainer container row m-0">
											  <?php
												$sql = 'select * from rfq_documents_url_information where tr_from like "details_item" and rfq_no="'.$_SESSION[$unique].'" and entry_by = "'.$_SESSION['user']['id'].'"  AND attachment_text IS NOT NULL';
												$qry = db_query($sql);
												while($res = mysqli_fetch_object($qry)){
											?> 
											<div class="col-sm-8 col-md-8 col-lg-8 pb-1">
													<div class="rounded p-2" style="word-break: break-all; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
													<a href="<?=$res->attachment_url?>" target="_blank" rel="noopener"><em class="fa-solid fa-text-size fa-xl" style="color: #df5c16;"></em>
														<span><?=$res->attachment_text?></span></a>
															<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentURLseventinfo(this,'<?=$res->documents_url_id?>' , '<?=$res->rfq_no?>', 'sample_value', '<?=$res->entry_by?>', 'attachmenturluploadcontainereventinfo','attachmentshowcontainereventinfo-url')"><em class="fa-solid fa-xmark"></em>
															</button>
													</div>
												</div>
											
											<? } ?>
											  
											  </div>
</div>

			 </div>

		<hr class="m-3" />
		
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
						
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					
					    <tr>
							<td>#1</td>
							<td><input type="text" name="item_desc" id="item_desc" list="item" />
							<datalist id="item">
							 <? foreign_relation('item_info','item_name','""','1')?>
							</datalist></td>
							<td><input type="text" name="expected_qty" id="expected_qty" style="text-align:right" value="0" onkeyup="item_rate_cal()"/></td>
							<td><input type="text" name="unit" id="unit" list="unit_list" />
							<datalist id="unit_list">
							 <? foreign_relation('unit_management','unit_name','""','1')?>
							</datalist>
							</td>
							<td><input type="text" name="price" id="price" style="text-align:right" onkeyup="item_rate_cal()" value="0" readonly="readonly" /></td>
							<td><input type="text" name="currency" id="base_currency" list="currency_list" />
							<datalist id="currency_list">
							 <? foreign_relation('currency_info','currency','""','1')?>
							</datalist>
							</td>
							<td><input type="text" name="item_total_amount" id="item_total_amount" readonly /></td>
	
                        </tr>	
						<tr>
						  <td colspan="7">
						  <? if($_SESSION['master_status']=='MANUAL'){?><button type="button" name="att_details" class="btn1 btn1-bg-update" onclick="event_item_insert()">Add Item</button><? } ?>
						</td>
						</tr>
						</tbody>
						</table>
						
						<table class="table1  table-striped table-bordered table-hover table-sm" id="item_details">
						<tbody class="tbody1">
						
						<tr class="bgc-info">
                        <th scope="col">SL</th>
						<th scope="col">Item Description</th>
                        <th scope="col">Quantity</th>
						<th scope="col">UOM</th>
						<th scope="col">Unit Price</th>
						<th scope="col">Currency</th>
						<th scope="col">Amount</th>
						
						
                    </tr>
						
						<?
		 $sql = 'select r.*,i.item_name from rfq_item_details r, item_info i where i.item_id=r.item_id and r.rfq_no="'.$_SESSION[$unique].'"';
		 $qry = db_query($sql);
		 while($doc=mysqli_fetch_object($qry)){
		?>
						<tr>
						    <td style="text-align:right;"><?=++$j?></td>
							<td style="text-align:left;"><?=$doc->item_name?></td>
							<td style="text-align:right;"><?=$doc->expected_qty?></td>
							<td><?=$doc->unit?></td>
							<td style="text-align:right;"><?=$doc->price?></td>
							<td><?=$doc->currency?></td>
							<td style="text-align:right;"><?=number_format($doc->expected_qty*$doc->price,0)?>
							&nbsp;
							<button type="button" name="add_event_team" 
		class="btn2 btn1-bg-cancel" onclick="event_item_cancel(document.getElementById('new_rfq_no').value,<?=$doc->id?>)">x</button>
		</td>
                            
                        </tr>	
						<? } ?>
							
					</tbody>
                </table>
  
  
  
  
  </div>
		
		
		
	</div>
	  
	  
	  
	  <!--Attachments Section View Body end-->
      </div>
    </div>
  </div>
  
</div>		
		

<h1 class="h1 m-0 p-0 pl-3">
			<em class="fa-solid fa-paperclip"></em> 
			<!--This button is a attachments modal Start-->
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addFormSection">Form Section</button>
			<!--This button is a attachments modal End-->
		</h1>
		<hr class="m-3" />


<!--Attachments Modal Start-->
<div class="modal fade" id="addFormSection" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 650px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Attachments Section </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  
	  <form id="htmlForm" method="post" action="">
		<div class="col-12 pt-4 pb-4">
			<div class="pt-1">
					<div class="row m-0 p-0 pt-4">
					<div class="col-6 ">
					<table class="w-100">
					<tbody>
					<tr class="tr">
						<td class="td1">Name</td>
						<td class="td2"><input name="form_name" type="text" id="form_name" value="" placeholder="Form for event"></td>
					</tr>
		
					<tr class="tr">
						<td class="td1">Description</td>
						<td class="td2"><textarea id="form_description" name="form_description"></textarea>
						</td>
					</tr>
					
					<tr class="tr">
						<td class="td1">Add Field</td>
						<td class="td2"><select class="form-control" id="form_element" name="form_element" style="width:20% !important;" onChange="select_html(this.value,'add');">
									<option>..Select ..</option>
									<? foreign_relation('form_elements','element','element',$form_element,'1');?>
								</select>
						</td>
					</tr>
					
				</tbody>
				</table>
					</div>
                    
                    <div  class="pt-2" style=" width: 100%;" id="html_details">	
						
					</div>
                    
                    <div class="pt-2" style=" width: 100%;">
	<? if($_SESSION['master_status']=='MANUAL'){?><button type="button" name="att_details" class="btn1 btn1-bg-update" onclick="event_form_insert()" data-dismiss="modal">Add Form</button><? } ?>
					</div>
					
				</div>
			
			</div>
		</div>
        </form>
	  
    </div>
  </div>
</div>		
		


<!--Attachments Section View Start-->
<div class="accordion" id="showFormInfo">
  <div class="card">
  <button class="btn btn-link collapsed p-0" type="button" data-toggle="collapse" data-target="#formView" aria-expanded="false" aria-controls="collapseTwo">
    <div class="card-header" id="headingTwo">
       <h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-list"></em> Form Section</h1>
    </div>
	</button>
    <div id="formView" class="collapse" aria-labelledby="headingTwo" data-parent="#showFormInfo">
      <div class="card-body">
	  <!--Attachments Section View Body strat-->
	  
	  
	  <span id="form_details">
		<? 
		$sql = 'select * from rfq_form_master where rfq_no="'.$_SESSION[$unique].'"';
		$qry = db_query($sql);
		while($form_data=mysqli_fetch_object($qry)){
		extract((array) $form_data);
		echo $form_available;
		?>
		<div class="col-12 pt-4 pb-4">
			<h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-file-lines"></em> Form Name - <?=$form_name?></h1>
			<hr class="m-3" />
			
			<div class="pt-1">
					<div class="row m-0 p-0 pt-4">
					
					<? 
		$sqlss = 'select f.*,f.id as form_details_id,e.fetch_file_name,e.element from rfq_form_details f,form_elements e where f.form_element=e.element and form_no="'.$form_no.'" and rfq_no="'.$_SESSION[$unique].'"';
		$qryr = db_query($sqlss);
		while($form_details_data=mysqli_fetch_object($qryr)){
		extract((array) $form_details_data);
		include_once($fetch_file_name);
		}
		?>
				
					
				</div>
			 <div>
			 <? if($_SESSION['master_status']=='MANUAL'){?>
			 <button type="button" name="more_option" class="btn1 btn1-bg-cancel" onClick="remove_form(document.getElementById('new_rfq_no').value,<?=$form_no?>);">Remove Form</button><? } ?>
			 
			 </div>
			</div>
		</div>
	 <? } ?>
	 </span>
	  
	  
	  
	  <!--Attachments Section View Body end-->
      </div>
    </div>
  </div>
  
</div>



		
	</div>
	
		
	
	
  </div>
  
				
  </div>

