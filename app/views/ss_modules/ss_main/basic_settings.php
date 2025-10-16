<?php
  $sql = 'SELECT currency_id FROM rfq_multiple_currency WHERE rfq_no = "'.$_SESSION[$unique].'"';
  $qry = db_query($sql);
  $selected_currency_ids = array();
  while($row=mysqli_fetch_object($qry)){
	
	$selected_currency_ids[] = $row->currency_id;
  }
?>
<script type="text/javascript" src="../../../../public/assets/js/select2.min.js"></script>
<style>
  .select2-container .select2-selection--multiple .select2-selection__rendered {
    display: flex;
    list-style: none;
    padding: 0;
}
.select2-selection__choice{
  display: flex;
  margin: 4px;
  flex-direction: row-reverse;
}
[type=button]:not(:disabled), [type=reset]:not(:disabled), [type=submit]:not(:disabled), button:not(:disabled) {
    cursor: pointer;
    border:none;
}
</style>
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
	
	background-color: #f9f9f994;
}

.tab-content>.active {
    display: block;
    border: 1px solid #f5f5f5;

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


.container {
  position: relative;
  margin-top: 50px;
}

.fileuploadcontainer,.attachmenturluploadcontainer,.attachmenttextuploadcontainer,.internalfileuploadcontainereventinfo,.fileuploadcontainereventinfo,.internalattachmenturluploadcontainereventinfo,.attachmenturluploadcontainereventinfo,.internalattachmenttextuploadcontainereventinfo,.attachmenttextuploadcontainereventinfo{
	margin: 15px;
	display: none;
}


.fileuploadcontainer form,.attachmenturluploadcontainer form,.attachmenttextuploadcontainer form ,.internalfileuploadcontainereventinfo,.fileuploadcontainereventinfo form,.internalattachmenttextuploadcontainereventinfo,.attachmenttextuploadcontainereventinfo form,.internalattachmenturluploadcontainereventinfo,.attachmenturluploadcontainereventinfo form{
  
  border: 0.1px solid  #333;
  padding: 12px;
}

input[type=file]{
  margin-right: 20px;
  border: none;
  background-color: #084cdf;
  padding: 10px 20px;
  border-radius: 10px;
  color: #fff;
  cursor: pointer;
  background-color:#0d45a5;
  
}
.drop-area2{
	border: 2px dashed red;
    display: flex;
    justify-content: center;
    align-items: ce;

	
}

input[type=file]:hover {
  background-color: #0d45a5;
  
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
  background-color: #4b4c4c;
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

<div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="settings-tab">
  <div>
   <?php
    $csql = 'select * from user_group where 1';
	$cqry = db_query($csql);
	while($cdata=mysqli_fetch_object($cqry)){
    $group_check = find_a_field('rfq_group_for','group_for','rfq_no="'.$_SESSION[$unique].'" and group_for="'.$cdata->id.'"');
   ?>
   
   <input type="checkbox" name="group_for" id="group_for" <?=($group_check==$cdata->id)?'checked':''?> value="<?=$cdata->id?>" onchange="company_setup(this.value)" />
   <lebel><?=$cdata->group_name?></lebel>
   <? } ?>
  </div>

  <div class="row m-0 p-0 pt-4">
  	<div class="col-6 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-file-lines"></em> Basic Settings.. </h1>
		<hr class="m-3" />
		
		<table class="w-100">
			<tr class="tr">
				<td class="td1">Event Name<span id="ep"><input type="hidden" name="new_rfq_no" id="new_rfq_no" value="<?=$_SESSION[$unique]?>" /></span></td>
				<td class="td2"><input name="event_name" type="text" id="event_name" autocomplete="on" value="<?=$event_name?>" onchange="master_data(this.name,this.value)" /><input name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="" /></td>
			</tr>
			
			<tr class="tr">
				<td class="td1">Currency</td>
				<td class="td2">
					<div class="input-group mb-3">
					  <input type="text" class="form-control" id="currency" name="currency" value="<?=$currency?>" list="currencyList" onchange="master_data(this.name,this.value);currency_show(this.value)" />
					  <datalist id="currencyList">
					   <? foreign_relation('currency_info','currency','""',$currency,"1")?>
					  <datalist>
					  <div class="input-group-append">
						<span class="input-group-text" id="basic-addon2">BDT</span>					  </div>
					</div>				</td>
			</tr>
						
			<tr class="tr">
				<td class="td1">Attachments</td>
				<td class="td2" colspan="10">

				<div class="attachment-toggle">
								
								
								<span class="attachment-toggle-add-file icon-search fs-14" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">File</span>
								                     <?if($_SESSION['user_role']=='Owner' && $_SESSION['master_status']=='MANUAL'){?>
																<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
																<span class="attachment-toggle-add-url icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Url</span>
																<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
																<span class="attachment-toggle-add-text icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Text</span>
										             <?}?>
										  
										  <div class="fileuploadcontainer" >
														
												<form  id="attachmentuploadFormxx" enctype="multipart/form-data">
												<input type="hidden" name="rfq_no" value="<?=$_SESSION[$unique]?>">
												<input type="hidden" name="tr_from" value="sourcing_basic_settings">
												<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
												<input type="hidden" name="motherContainer" value="fileuploadcontainer">
												<input type="hidden" name="datashowContainer" value="attachmentshowcontainer">
												<div class="attachment-icon-close-container">
												  <i class="attachment-toggle-add-file fa fa-fw fa-close"></i>
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
																<input type="hidden" name="tr_from" value="sourcing_basic_settings">
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
												<input type="hidden" name="tr_from" value="sourcing_basic_settings">
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
						  $sql = 'SELECT * FROM rfq_documents_information WHERE rfq_no = "'.$_SESSION[$unique].'" AND tr_from ="sourcing_basic_settings"';
						  $qry = db_query($sql);
						  while($item=mysqli_fetch_object($qry)){
						?>
                                      <div class="col-sm-10 col-md-10 col-lg-10 pb-1">
										<div class="rounded p-2" style="background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
										<a href="../../../controllers/utilities/api_upload_attachment_show.php?name=<?=$item->new_name?>&folder=<?=$item->tr_from?>" target="_blank" rel="noopener">
												<em class="fa-light fa-file fa-2xl fs-22" style="color: #d6960a;"></em> 
												<span><?=$item->original_name?></span>
											</a>
											<?if($_SESSION['user_role']=='Owner' && $_SESSION['master_status']=='MANUAL'){?>
											<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentseventinfo(this,
                                   '<?=$item->attachment_id;?>',
                                   '<?=$item->rfq_no;?>',
                                   '<?=$item->tr_from;?>',
                                   '<?=$item->entry_by;?>',
                                   '<?=$motherContainerValue;?>',
                                   '<?=$datashowContainerValue;?>')">
												<em class="fa-solid fa-xmark"></em>
											</button>
											<?}?>
										</div>
									</div>



                       <?}?>
						</div>
											  <div class="attachmentUrlshowcontainer container row m-0">
											<?php
												$sql = 'select * from rfq_documents_url_information where tr_from like "sourcing_basic_settings" and rfq_no="'.$_SESSION[$unique].'" and entry_by = "'.$_SESSION['user']['id'].'"  AND attachment_url IS NOT NULL';
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
												$sql = 'select * from rfq_documents_url_information where tr_from like "sourcing_basic_settings" and rfq_no="'.$_SESSION[$unique].'" and entry_by = "'.$_SESSION['user']['id'].'"  AND attachment_text IS NOT NULL';
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
				</td>
                 
			</tr>
						
			<tr class="tr">
				<td class="td1">Buyer Logo</td>
				<td class="td2">
				<form  id="uploadlogobasicsourcing" enctype="multipart/form-data">
												<input type="hidden" name="rfq_no" value="<?=$_SESSION[$unique]?>">
												<input type="hidden" name="tr_from" value="logo">
												<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
												
												<?
										
												    $imgsrc="../../../controllers/utilities/api_upload_attachment_show.php?name=default_logo.png&folder=logo";
													$sql = 'SELECT * FROM rfq_documents_information WHERE rfq_no = "'.$_SESSION[$unique].'" AND tr_from ="logo"';
													$qry = db_query($sql);
													$item = mysqli_fetch_object($qry); 
													if ($item) {
														
														$imgsrc="../../../controllers/utilities/api_upload_attachment_show.php?name=".$item->new_name."&folder=".$item->tr_from;
													}
                                                   
													
													?>
												<label for="basicsourcinglogo" class="btn "><img alt="" id="logoshowbasicsourcing" src="<?=$imgsrc?>" style="width: 100%; max-height: 150px;mix-blend-mode: multiply;"/></label>
												<input class="d-none" type="file" name="eprocfiles[]" id="basicsourcinglogo" accept="*/*">
												<div   id="filepercentageandloader" class="filepercentageandloader" style="display: none !important;">
												  </div>
											
											     <button type="submit" class="d-none"  name="submit" value="Go" class="attachment-toggle-add-file"><em class="fa fa-fw fa-search"></em></button>
											
				</form>
				</td>
			</tr>
		</table>
		
	</div>
	
	<div class="col-6  pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-file-lines"></em> Terms and Conditions </h1>
		<hr class="m-3" />
		
		<table class="w-100">
			<tr class="tr">
				<td class="td1">Event Terms</td>
				<td class="td2">
				<div class="attachment-toggle">
								
								
								<span class="attachment-toggle-add-file icon-search fs-14" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">File</span>
																<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
																<span class="attachment-toggle-add-url icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Url</span>
																<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
																<span class="attachment-toggle-add-text icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Text</span>
										  
										  
										  <div class="fileuploadcontainer" >
														
												<form  id="attachmentuploadFormxx" enctype="multipart/form-data">
												<input type="hidden" name="rfq_no" value="<?=$_SESSION[$unique]?>">
												<input type="hidden" name="tr_from" value="sourcing_terms_condition">
												<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
												<input type="hidden" name="motherContainer" value="fileuploadcontainer">
												<input type="hidden" name="datashowContainer" value="attachmentshowcontainer">
												<div class="attachment-icon-close-container">
												  <em class="attachment-toggle-add-file fa fa-fw fa-close"></em>
												</div>
												<div id="dropArea" class="drop-area">
												
												<input  type="file" name="eprocfiles[]" id="imageInput" accept="*/*" multiple>
												  <div   id="filepercentageandloader" class="filepercentageandloader" style="display: none !important;">
												  </div>
												  
										  
												<div class="drop-area2">
												  <div  >
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
																<input type="hidden" name="tr_from" value="sourcing_terms_condition">
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
												<input type="hidden" name="tr_from" value="sourcing_terms_condition">
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
						  $sql = 'SELECT * FROM rfq_documents_information WHERE rfq_no = "'.$_SESSION[$unique].'" AND tr_from ="sourcing_terms_condition"';
						  $qry = db_query($sql);
						  while($item=mysqli_fetch_object($qry)){
						?>
                                      <div class="col-sm-10 col-md-10 col-lg-10 pb-1">
										<div class="rounded p-2" style="background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
										<a href="../../../controllers/utilities/api_upload_attachment_show.php?name=<?=$item->new_name?>&folder=<?=$item->tr_from?>" target="_blank" rel="noopener">

												<em class="fa-light fa-file fa-2xl fs-22" style="color: #d6960a;"></em> 
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
												$sql = 'select * from rfq_documents_url_information where tr_from like "sourcing_terms_condition" and rfq_no="'.$_SESSION[$unique].'" and entry_by = "'.$_SESSION['user']['id'].'"  AND attachment_url IS NOT NULL';
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
												$sql = 'select * from rfq_documents_url_information where tr_from like "sourcing_terms_condition" and rfq_no="'.$_SESSION[$unique].'" and entry_by = "'.$_SESSION['user']['id'].'"  AND attachment_text IS NOT NULL';
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
				</td>
			</tr>
		</table>
	
	
	
		<h1 class="h1 m-0 p-0 pl-3 pt-3"><em class="fa-solid fa-file-lines"></em> Documents </h1>
		<hr class="m-3" />
		
		<table class="w-100">
			<tr class="tr">
				<td>&nbsp;&nbsp;Related Documents</td>
			</tr>
			
			<?php
				 if($master_rfq_no==0){
				  $sql = 'select * from rfq_master where master_rfq_no="'.$_SESSION[$unique].'"';
				  $qry = db_query($sql);
				  while($round_info = mysqli_fetch_object($qry)){
				  ?>
				  <tr class="tr">
				   <td>&nbsp;&nbsp;<a href="?rfq_no=<?=url_encode($round_info->rfq_no)?>"><?=$round_info->rfq_version?></a></td>
			      </tr>
				  
				  <?
				  }
				 }else{
				 
				  $sql = 'select * from rfq_master where rfq_no="'.$master_rfq_no.'"';
				  $qry = db_query($sql);
				  while($round_info = mysqli_fetch_object($qry)){
				  ?>
				  <tr class="tr">
				   <td>&nbsp;&nbsp;<a href="?rfq_no=<?=url_encode($round_info->rfq_no)?>"><?=$round_info->rfq_version?></a></td>
			      </tr>
				  
				  <?
				  }
				 }
				?>
				
		</table>
	
		
		<h1 class="h1 m-0 p-0 pl-3 pt-3"><em class="fa-solid fa-file-lines"></em> Custom Objects </h1>
		<hr class="m-3" />
		
		<table class="w-100">
			<tr class="tr">
				<td colspan="2" class="td2">None</td>
			</tr>
		</table>
	
	
	</div>
  </div>
  

<div class="row m-0 p-0 pt-4">
  	<div class="col-6 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-file-lines"></em> Internal Event Info </h1>
		<hr class="m-3" />
		
		<table class="w-100">
			<tr class="tr">

				<td class="td1">Tag</td>
				<td class="td2"><em class="fa-solid fa-message-arrow-up-right" title="Write tags with comma(,) separator!"></em><input type="text" class="tag" id="tag" name="tag" value="<?=$tag?>" onchange="master_data(this.name,this.value)" autocomplete="on" /></td>
			</tr>
			
			<tr class="tr">
				<td class="td1">Event Commodity</td>
				<td class="td2"><input type="text" class="commodity" id="commodity" name="commodity" list="eventCommodityList" value="<?=$commodity?>" onchange="master_data(this.name,this.value)" />
				<datalist id="eventCommodityList">
					   <? foreign_relation('event_commodity','event_commodity','""',$commodity,"1")?>
					  <datalist>
				</td>
			</tr>
						
			<tr class="tr">
				<td class="td1">Event sub commodity</td>
				<td class="td2"><input type="text" class="coupa_commodity" id="coupa_commodity" name="coupa_commodity" value="<?=$coupa_commodity?>" list="comidityList" onchange="master_data(this.name,this.value)" />
				<datalist id="comidityList">
					   <? foreign_relation('event_sub_commodity','event_sub_commodity','""',$coupa_commodity,"1")?>
					  <datalist>
					  </td>
			</tr>
						
			<tr class="tr">
				<td class="td1">Planned Savings</td>
				<td class="td2">
					<div class="input-group mb-3">
					  <input type="text" class="form-control" id="planned_savings" name="planned_savings" value="<?=$planned_savings?>" placeholder="0.00" onchange="master_data(this.name,this.value)" />
					  
					  <div class="input-group-append">
						<span class="input-group-text" id="planned_savings">
						 <input type="text" class="form-control" id="planned_savings_currency" name="planned_savings_currency" value="<?=$planned_savings_currency?>" list="currencyList" onchange="master_data(this.name,this.value)" placeholder="Currency.." />
					  <datalist id="planned_savings_currencyList">
					   <? foreign_relation('currency_info','currency','""',$planned_savings_currency,"1")?>
					  <datalist>
						</span>
					  </div>
					</div> 
				</td>
			</tr>
									
			<tr class="tr">
				<td class="td1">Savings Type</td>
				<td class="td2">
					<div class="input-group mb-3">
					  <input type="text" class="form-control" id="cost_avoidance" name="cost_avoidance" value="<?=$cost_avoidance?>" onchange="master_data(this.name,this.value)" list="costAvoidanceList"  />
					  <datalist id="costAvoidanceList">
					   <? foreign_relation('cost_avoidance','cost_avoidance','""',$cost_avoidance,"1")?>
					  <datalist>
					  <div class="input-group-append">
						<span class="input-group-text" id="planned_savings">
						<input type="text" class="form-control" id="cost_avoidance_currency" name="cost_avoidance_currency" value="<?=$cost_avoidance_currency?>" list="cost_avoidance_currencyList" onchange="master_data(this.name,this.value)" placeholder="Currency.." />
					  <datalist id="cost_avoidance_currencyList">
					   <? foreign_relation('currency_info','currency','""',$cost_avoidance_currency,"1")?>
					  <datalist>
					  </span>
					  </div>
					</div> 
				</td>
			</tr>
									
			<tr class="tr">
				<td class="td1">Sourcing Type</td>
				<td class="td2">
					<select id="sourcing_type" name="sourcing_type" onchange="master_data(this.name,this.value)">
					<option></option>
					  
					  <? foreign_relation('sourcing_type','sourcing_type','sourcing_type',$sourcing_type,"1")?>
					</select>
				
				</td>
			</tr>
									
			<tr class="tr">
				<td class="td1">RFx Reference #</td>
				<td class="td2"> <input type="text" class="rfx_referance" id="rfx_referance" name="rfx_referance" value="<?=$rfx_referance?>" onchange="master_data(this.name,this.value)" /> </td>
			</tr>
									
			<tr class="tr">
				<td class="td1">SRF Case Number</td>
				<td class="td2"> <input type="text" class="referance_form" id="referance_form" name="referance_form" value="<?=$referance_form?>" onchange="master_data(this.name,this.value)" /> </td>
			</tr>
									
			<tr class="tr">
				<td class="td1">Project Amount</td>
				<td class="td2">
					<div class="input-group mb-3">
					  <input type="text" class="form-control" id="project_amount" name="project_amount" value="<?=$project_amount?>" onchange="master_data(this.name,this.value)" placeholder="0.00" />
					  <div class="input-group-append">
						<span class="input-group-text" id="planned_savings">
						<input type="text" class="form-control" id="project_amount_currency" name="project_amount_currency" value="<?=$project_amount_currency?>" list="project_amount_currencyList" onchange="master_data(this.name,this.value)" placeholder="Currency.." />
					  <datalist id="project_amount_currencyList">
					   <? foreign_relation('currency_info','currency','""',$project_amount_currency,"1")?>
					  <datalist>
					  </span>
					  </div>
					</div>
				 </td>
			</tr>
									
			<tr class="tr">
				<td class="td1">Attachment </td>
				<td class="td2">
				<div class="attachment-toggle">
								
								
								<span class="attachment-toggle-add-file icon-search fs-14" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">File</span>
																<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
																<span class="attachment-toggle-add-url icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Url</span>
																<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
																<span class="attachment-toggle-add-text icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Text</span>
										  
										  
										  <div class="fileuploadcontainer" >
														
												<form  id="attachmentuploadFormxx" enctype="multipart/form-data">
												<input type="hidden" name="rfq_no" value="<?=$_SESSION[$unique]?>">
												<input type="hidden" name="tr_from" value="sourcing_internel_eventinfo">
												<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
												<input type="hidden" name="motherContainer" value="fileuploadcontainer">
												<input type="hidden" name="datashowContainer" value="attachmentshowcontainer">
												<div class="attachment-icon-close-container">
												  <em class="attachment-toggle-add-file fa fa-fw fa-close"></em>
												</div>
												<div id="dropArea" class="drop-area">
												
												<input  type="file" name="eprocfiles[]" id="imageInput" accept="*/*" multiple>
												  <div   id="filepercentageandloader" class="filepercentageandloader" style="display: none !important;">
												  </div>
												  
										  
												<div class="drop-area2">
												  <div  >
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
																<input type="hidden" name="tr_from" value="sourcing_internel_eventinfo">
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
												<input type="hidden" name="tr_from" value="sourcing_internel_eventinfo">
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
						  $sql = 'SELECT * FROM rfq_documents_information WHERE rfq_no = "'.$_SESSION[$unique].'" AND tr_from ="sourcing_internel_eventinfo"';
						  $qry = db_query($sql);
						  while($item=mysqli_fetch_object($qry)){
						?>
                                      <div class="col-sm-10 col-md-10 col-lg-10 pb-1">
										<div class="rounded p-2" style="background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
										<a href="../../../controllers/utilities/api_upload_attachment_show.php?name=<?=$item->new_name?>&folder=<?=$item->tr_from?>" target="_blank" rel="noopener">

												<em class="fa-light fa-file fa-2xl fs-22" style="color: #d6960a;"></em> 
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
												$sql = 'select * from rfq_documents_url_information where tr_from like "sourcing_internel_eventinfo" and rfq_no="'.$_SESSION[$unique].'" and entry_by = "'.$_SESSION['user']['id'].'"  AND attachment_url IS NOT NULL';
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
												$sql = 'select * from rfq_documents_url_information where tr_from like "sourcing_internel_eventinfo" and rfq_no="'.$_SESSION[$unique].'" and entry_by = "'.$_SESSION['user']['id'].'"  AND attachment_text IS NOT NULL';
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
				</td>
			</tr>																	
			<tr class="tr">
				<td class="td1">Other Notes/Comments</td>
				<td class="td2"><textarea id="other_notes" name="other_notes" onchange="master_data(this.name,this.value)"><?=$other_notes?></textarea>	 </td>
			</tr>
												
			<tr class="tr">
				<td class="td1">Visibility</td>
				<td class="td2">
  <select id="content_group" name="content_group" onchange="master_data(this.name,this.value)">
  <option></option>
   <? foreign_relation('event_visibility_team','id','team',$content_group,'1');?>
  </select>
  
    
				 </td>
			</tr>
			
			
		</table>
		
	</div>
	
	<div class="col-6  pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-file-lines"></em> Event Team </h1>
		
					  
					 
		<hr class="m-3" />
		<select class="form-control" id="event_team_user_id" name="event_team_user_id" style="width:50% !important; float:left;">
		<option>..Select Team Member..</option>
		<?php foreign_relation('user_activity_management','user_id','fname','1');?>
		</select>
		
		<select class="form-control" id="event_team_level" name="event_team_level" style="width:20% !important; float:left;">
		<option>..Select Action..</option>
		<option <?=($event_team_level=='Watcher')?'selected':''?>>Watcher</option>
		<option <?=($event_team_level=='Commercial Evaluator')?'selected':''?>>Commercial Evaluator</option>
		<option <?=($event_team_level=='Technical Evaluator')?'selected':''?>>Technical Evaluator</option>
		<option <?=($event_team_level=='Owner')?'selected':''?>>Owner</option>
		</select>
		
		<? if($_SESSION['master_status']=='MANUAL'){?><button type="button" name="add_event_team" class="btn1 btn1-bg-update" style="width:20% !important;" onclick="event_team_insert(document.getElementById('new_rfq_no').value,document.getElementById('event_team_user_id').value,document.getElementById('event_team_level').value)">Add Team</button><? } ?><br />
		<br />
		<span id="team">
		<?php
		 $sql = 'select a.id,u.fname,a.action from rfq_evaluation_team a, user_activity_management u where a.user_id=u.user_id and a.rfq_no="'.$_SESSION[$unique].'"';
		 $qry = db_query($sql);
		 while($data=mysqli_fetch_object($qry)){
		?>
		<a class="pl-3"><em class="fa-regular fa-user"></em>&nbsp;<?=$data->fname?><span>(<?=$data->action?>)</span> </a><? if($_SESSION['master_status']=='MANUAL'){?><button type="button" name="add_event_team" 
		class="btn2 btn1-bg-cancel" onclick="event_team_cancel(document.getElementById('new_rfq_no').value,<?=$data->id?>)">x</button><? } ?><br />
		<? } ?>
	</span>
	
		<h1 class="h1 m-0 p-0 pl-3 pt-4"><em class="fa-solid fa-list"></em> Projects and Tasks </h1>
		<hr class="m-3" />
		
		<table class="w-100">
			<tr class="tr">
				<td class="td1">Related Documents</td>
				<td class="td2">None</td>
			</tr>
		</table>
	   
	
	</div>
  </div>
  
  
  
  

  
<div class="row m-0 p-0 pt-4">
  	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><em class="fa-duotone fa-calendar-days"></em> Event Type Settings </h1>
		<hr class="m-3" />
		
		<div class="row m-0 p-0 pt-4">
			<div class="col-6  p-0">
				
				  <input type="checkbox" id="vehicle1" name="vehicle1" checked="checked" value="Bike" onchange="master_data(this.name,this.value)">
					<label for="vehicle1">RFx Stage</label><br>
					
					
					&nbsp; &nbsp; <input type="radio" id="rfx_stage" name="rfx_stage" <?php if($rfx_stage=='RFI') {echo 'checked';}?> value="RFI" onchange="master_data(this.name,this.value)">
					<label for="rfi">RFI</label><br>
					&nbsp; &nbsp; <input type="radio" id="rfx_stage" name="rfx_stage" <?php if($rfx_stage=='RFQ') {echo 'checked';}?> value="RFQ" onchange="master_data(this.name,this.value)">
					<label for="rfq">RFQ</label><br>
					&nbsp; &nbsp; <input type="radio" id="rfx_stage" name="rfx_stage" <?php if($rfx_stage=='RFP') {echo 'checked';}?> value="RFP" onchange="master_data(this.name,this.value)">
					<label for="rfp">RFP</label>
				
					 <br>  
					 <input type="checkbox" id="auction_stage" name="auction_stage" <?php if($auction_stage=='yes') {echo 'checked';}?> value="yes" onchange="master_data(this.name,this.value)">
					<label for="vehicle1">Auction Stage</label><br>
				
			</div>	
			<div class="col-6 p-0">
				
				  <input type="checkbox" id="multiple_response" name="multiple_response" <?php if($multiple_response=='yes') {echo 'checked';}?> value="yes" onchange="master_data(this.name,this.value)">
					<label for="vehicle">Allow multiple response</label><br>
					
					<input type="checkbox" id="hide_supplier_response" name="hide_supplier_response" <?php if($hide_supplier_response=='yes') {echo 'checked';}?> value="yes" onchange="master_data(this.name,this.value)">
					<label for="ve3">Hide supplier response (sealed bid)</label><br>
					
					&nbsp; &nbsp; <input type="radio" id="when_unseal" name="when_unseal" <?php if($when_unseal=='after_event_ends') {echo 'checked';}?> value="after_event_ends">
					<label for="unseal">Automaticall unseal when event ends</label><br>
					
					&nbsp; &nbsp; <input type="radio" id="when_unseal" name="when_unseal" <?php if($when_unseal=='manually') {echo 'checked';}?> value="manually" onchange="master_data(this.name,this.value)">
					<label for="Unseal">Unseal manually</label><br>
					
		
					 <br>  
				  <input type="checkbox" id="respond_with_att_chat" name="respond_with_att_chat" <?php if($respond_with_att_chat=='yes') {echo 'checked';}?> value="yes" onchange="master_data(this.name,this.value)">
				  <label for="vehicle14">Allow Suppliers to respond with attachments in Massage centre</label><br>
				
				
				
				
					
				<h1 class="h1 m-0 p-0 pb-1 pt-4"> Event Currencies & Exchange Rates <em class="fa-solid fa-circle-exclamation"></em> </h1>

				  <input type="checkbox" id="other_currency" name="other_currency" <?php if($other_currency=='yes') {echo 'checked';}?> value="yes" onchange="master_data(this.name,this.value)">
				  <label for="v001">Allow Suppliers to bid in any of these currencies</label><br>
				  <div>

				            <h1 class="h1 m-0 p-0 pb-1 pt-4"> Select your currency <em class="fa-solid fa-circle-exclamation"></em> </h1>
						    <span id="showcurrencymmmm"></span>
							<select class="form-select" id="multiple-select-field" data-placeholder="Choose anything" multiple>
							<? foreign_relation('currency_info','id','currency',$planned_savings_currency,"1")?>
							</select>

				  </div>
				  
		
			</div>
		</div>		
	</div>
  </div>
  
  

<div class="row m-0 p-0 pt-4">
  	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-comment"></em> Comments </h1>
		<hr class="m-3" />
		
		
		  <div class="form-group">
			<label for="exampleInputEmail1">Enter Comment</label>
			<textarea id="comment" name="comment" onchange="master_data(this.name,this.value)" autocomplete="on"><?=$comment?></textarea>
			<small id="emailHelp" class="form-text text-muted">Send comment notification to a user</small>
		  </div>
	</div>
  </div>
    
  

<div class="row m-0 p-0 pt-4">
  	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-clock-rotate-left"></em> History </h1>
		<hr class="m-3" />
		
		<?php 
		$sql='select m.comment,u.fname,m.entry_at from rfq_master m,user_activity_management u where m.entry_by=u.user_id and m.rfq_no="'.$_SESSION[$unique].'"';
		$qry = db_query($sql);
		while($comment = mysqli_fetch_object($qry)){
		?>
		<div class="pl-3">
		<p class="p-0 m-0" style=" font-size: 16px !important; font-weight: 500; "><?=$comment->fname?></p>
		<p class="p-0 m-0"> <?=$comment->comment?></p>
		<p class="p-0 m-0"> <?=$comment->entry_at?></p>
		<hr />
		</div>
		<?php } ?>
				
	</div>
  </div>
  
  
  
  </div>
  <script>
	$('#basicsourcinglogo').change(function () {
		$('#uploadlogobasicsourcing button[type="submit"]').click();


});
$('#uploadlogobasicsourcing').submit(function (e) {
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
    
            var fileProgressBar = $('<div class="rounded " style="margin-top: 10px !important; width: 100% !important; height: 70px !important; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6 !important;"><span>'+ file.name+'</span><div class="d-flex justify-content-around align-items-center "><div class="lds-spinner" style="position: relative !important; top: -5px !important;"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div><div class="progress " style="width: 70% !important; height: 12px !important;"><div class="progress-bar"  role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div></div></div></div>');
            progressBarContainer.append(fileProgressBar)
})

var progressBar = $('.progress-bar');

$.ajax({
    url: '../../../views/eProcurement_mod/api/new_api_logo_upload.php',
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
       console.log("Dddddddddd");
      console.log(responseData);
		var responseObject = JSON.parse(responseData);


$.each(responseObject, function(index, item) {
	
	var newImageUrl = "../../../controllers/utilities/api_upload_attachment_show.php?name="+item.new_name+"&folder="+item.tr_from;

	console.log(newImageUrl);
var imageElement = document.getElementById("logoshowbasicsourcing");
imageElement.setAttribute("src", newImageUrl);


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

</script>

<script>
	$(document).ready(function() {
		var selectedValues = <?php echo json_encode($selected_currency_ids); ?>;


         $('#multiple-select-field').val(selectedValues).trigger('change');
	$( '#multiple-select-field' ).select2( {
		theme: "bootstrap-5",
		width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
		placeholder: $( this ).data( 'placeholder' ),
		closeOnSelect: false,
	} );

        function logNewlySelectedOption(selectedValue) {
			getData2('currency_multiple_selectoion.php','showcurrencymmmm',selectedValue);
        }
		function logNewlyUnselectedOption(unselectedValue) {
            getData2('currency_multiple_selectoion_delete.php','showcurrencymmmm',unselectedValue);
        }
     
		$('#multiple-select-field').on('select2:select', function(e) {
            var selectedValue = e.params.data.id;
            logNewlySelectedOption(selectedValue);
        });
		$('#multiple-select-field').on('select2:unselect', function(e) {
            var unselectedValue = e.params.data.id;
            logNewlyUnselectedOption(unselectedValue);
        });
	});
</script>
  