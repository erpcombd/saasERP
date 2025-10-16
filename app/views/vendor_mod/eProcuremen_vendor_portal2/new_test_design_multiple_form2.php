<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
?>

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
  background: #084cdf;
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
  background: #0d45a5;
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
    border-width: 50px 0 50px 50px;
    border-color: transparent transparent transparent #dfe3e3;
}

</style>














<div class="attachment-toggle xxxxxxxxxxxx">
								
								<span class="attachment-toggle-add-file icon-search fs-14" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">File</span>
								<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
								<span class="attachment-toggle-add-url icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Url</span>
								<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
								<span class="attachment-toggle-add-text icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Text</span>

								 
	
							<div class="fileuploadcontainer" >
						
								<form  id="attachmentuploadForm" enctype="multipart/form-data">
								<input type="hidden" name="master_id" value="<?=$_SESSION[$unique]?>">
								<input type="hidden" name="tr_from" value="sourcing_terms_condition">
								<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
								<input type="hidden" name="motherContainer" value="fileuploadcontainer">
								<input type="hidden" name="datashowContainer" value="attachmentshowcontainer">
								<div class="attachment-icon-close-container">
									<i class="attachment-toggle-add-file fa fa-fw fa-close"></i>
								</div>
								<div id="dropArea" class="drop-area">
								<label for="imageInput" class="btn btn-info">Browse</label>
								<input class="d-none" type="file" name="eprocfiles[]" id="imageInput" accept="*/*" multiple>
									<div align="center" id="filepercentageandloader" class="filepercentageandloader" style="display: none !important;">
									</div>
									
					
								<div class="drop-area2">
								  <div align="center">
								  <p class="m-0">Drag & Drop files here</p>
								  <i class="fa-light fa-cloud-arrow-up fa-2xl"></i>
								  </div>
								
								</div>
								
							 </div>
							 <input type="checkbox" name="sendtosuppliercheckbox" id="sendtosuppliercheckbox" checked>
								<label for="sendtosuppliercheckbox">Send to Supplier</label>
								  <button type="submit" class="d-none"  name="submit" value="Go" class="attachment-toggle-add-file"><i class="fa fa-fw fa-search"></i></button>
								
								</form>
							</div>
							<div class="attachmenturluploadcontainer" >
						
								<form  id="attachmenturluploadForm" enctype="multipart/form-data">
								<input type="hidden" name="master_id" value="<?=$_SESSION[$unique]?>">
								<input type="hidden" name="tr_from" value="sourcing_terms_condition">
								<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
								<input type="hidden" name="motherContainer" value="attachmenturluploadcontainer">
								<input type="hidden" name="datashowContainer" value="attachmentUrlshowcontainer">
								
								<div class="attachment-icon-close-container">
									<i class="attachment-toggle-add-url fa fa-fw fa-close"></i>
								</div>
								<!-- <i class="attachment-toggle-add-url fa fa-fw  fa-close"></i> -->
								<p>Add Your URL here</p>
								<input  type="text" name="attachmenturlinput" id="attachmenturlinput">
								
								<input type="checkbox" name="sendtosuppliercheckbox" id="sendtosuppliercheckbox" checked>
								   <label for="sendtosuppliercheckbox">Send to Supplier</label><br>
								  <button type="submit"  name="submit" value="Go" class="attachment-toggle-add-file btn btn-info">ADD</button>
								
								</form>
							</div>

							<div class="attachmenttextuploadcontainer" >
						
								<form  id="attachmenttextuploadForm" enctype="multipart/form-data">
								<input type="hidden" name="master_id" value="<?=$_SESSION[$unique]?>">
								<input type="hidden" name="tr_from" value="sourcing_terms_condition">
								<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
								<input type="hidden" name="motherContainer" value="attachmenttextuploadcontainer">
								<input type="hidden" name="datashowContainer" value="attachmentTextshowcontainer">
								
								<div class="attachment-icon-close-container">
									<i class="attachment-toggle-add-text fa fa-fw fa-close"></i>
								</div> 
								<!-- <i class="attachment-toggle-add-text fa fa-fw  fa-close"></i> -->
								<p>Add Your Text here</p>
								<input  type="text" name="attachmenttextinput" id="attachmenttextinput">
								
								<input type="checkbox" name="sendtosuppliercheckbox" id="sendtosuppliercheckbox" checked>
								   <label for="sendtosuppliercheckbox">Send to Supplier</label><br>
								  <button type="submit"  name="submit" value="Go" class="attachment-toggle-add-file btn btn-info">ADD</button>
								
								</form>
					</div>
                  <div class="attachmentshowcontainer container row m-0">
                
                      
                </div>
                <div class="attachmentUrlshowcontainer container row m-0">
                  
                
                </div>
                <div class="attachmentTextshowcontainer container row m-0">
                  
                
                </div>
          </div>


       <p>fffffffffffffffffffffffffffffffffff</p>
       <p>fffffffffffffffffffffffffffffffffff</p>
       <p>fffffffffffffffffffffffffffffffffff</p>
       <p>fffffffffffffffffffffffffffffffffff</p>

       <div class="attachment-toggle  tttttttttttttt">
								
								<span class="attachment-toggle-add-file icon-search fs-14" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">File</span>
								<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
								<span class="attachment-toggle-add-url icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Url</span>
								<div class="vertical-line" style="height: 20px; width: 1px; background-color: #000; display: inline-block; vertical-align: middle;"></div>
								<span class="attachment-toggle-add-text icon-search" style="cursor: pointer; color: blue;" onmouseover="this.style.color='orange'" onmouseout="this.style.color='blue'">Text</span>

								 
							
							<div class="fileuploadcontainer" >
						
								<form class="xxxxxxxxxxyy" id="attachmentuploadForm1"  enctype="multipart/form-data">
								<input type="hidden" name="master_id" value="<?=$_SESSION[$unique]?>">
								<input type="hidden" name="tr_from" value="sourcing_terms_condition">
								<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
								<input type="hidden" name="motherContainer" value="fileuplo66666666666adcontainer">
								<input type="hidden" name="datashowContainer" value="attachmentshowcontainer">
								<div class="attachment-icon-close-container">
									<i class="attachment-toggle-add-file fa fa-fw fa-close"></i>
								</div>
								<div id="dropArea" class="drop-area">
								<label for="imageInput" class="btn btn-info">Browse gggggggg</label>
								<input class="d-none" type="file" name="eprocfiles[]" id="imageInput" accept="*/*" multiple>
									<div align="center" id="filepercentageandloader" class="filepercentageandloader" style="display: none !important;">
									</div>
									
					
								<div class="drop-area2">
								  <div align="center">
								  <p class="m-0">Drag & Drop files here</p>
								  <i class="fa-light fa-cloud-arrow-up fa-2xl"></i>
								  </div>
								
								</div>
								
							 </div>
							 <input type="checkbox" name="sendtosuppliercheckbox" id="sendtosuppliercheckbox" checked>
								<label for="sendtosuppliercheckbox">Send to Supplier</label>
								  <button type="submit" class="d-none"  name="submit" value="Go" class="attachment-toggle-add-file"><i class="fa fa-fw fa-search"></i></button>
								
								</form>
							</div>
							<div class="attachmenturluploadcontainer" >
						
								<form  id="attachmenturluploadForm" enctype="multipart/form-data">
								<input type="hidden" name="master_id" value="<?=$_SESSION[$unique]?>">
								<input type="hidden" name="tr_from" value="sourcing_terms_condition">
								<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
								<input type="hidden" name="motherContainer" value="attachmenturluploadcontainer">
								<input type="hidden" name="datashowContainer" value="attachmentUrlshowcontainer">
								
								<div class="attachment-icon-close-container">
									<i class="attachment-toggle-add-url fa fa-fw fa-close"></i>
								</div>
								<!-- <i class="attachment-toggle-add-url fa fa-fw  fa-close"></i> -->
								<p>Add Your URL here</p>
								<input  type="text" name="attachmenturlinput" id="attachmenturlinput">
								
								<input type="checkbox" name="sendtosuppliercheckbox" id="sendtosuppliercheckbox" checked>
								   <label for="sendtosuppliercheckbox">Send to Supplier</label><br>
								  <button type="submit"  name="submit" value="Go" class="attachment-toggle-add-file btn btn-info">ADD</button>
								
								</form>
							</div>

							<div class="attachmenttextuploadcontainer" >
						
								<form  id="attachmenttextuploadForm" enctype="multipart/form-data">
								<input type="hidden" name="master_id" value="<?=$_SESSION[$unique]?>">
								<input type="hidden" name="tr_from" value="sourcing_terms_condition">
								<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
								<input type="hidden" name="motherContainer" value="attachmenttextuploadcontainer">
								<input type="hidden" name="datashowContainer" value="attachmentTextshowcontainer">
								
								<div class="attachment-icon-close-container">
									<i class="attachment-toggle-add-text fa fa-fw fa-close"></i>
								</div> 
								<!-- <i class="attachment-toggle-add-text fa fa-fw  fa-close"></i> -->
								<p>Add Your Text here</p>
								<input  type="text" name="attachmenttextinput2" id="attachmenttextinput2">
								
								<input type="checkbox" name="sendtosuppliercheckbox" id="sendtosuppliercheckbox" checked>
								   <label for="sendtosuppliercheckbox">Send to Supplier</label><br>
								  <button type="submit"  name="submit" value="Go" class="attachment-toggle-add-file btn btn-info">ADD</button>
								
								</form>
							</div>

							<div class="attachmentshowcontainer container row m-0">
				
              
							</div>
							<div class="attachmentUrlshowcontainer container row m-0">
								
							
							</div>
							<div class="attachmentTextshowcontainer container row m-0">
								
							
							</div>
              </div>
<script>


$('.attachment-toggle .attachment-toggle-add-file').click(function(e) {
   
  var $container = $(this).closest('.attachment-toggle').children('.fileuploadcontainer');
  console.log($container);
  if ($container.hasClass('fileuploadcontaineropened')) {
    // If already opened, close it
    $container.removeClass('fileuploadcontaineropened');
  } else {
   
    // Close all other containers
    $('.fileuploadcontaineropened').removeClass('fileuploadcontaineropened');
    // Open the clicked container
    $container.addClass('fileuploadcontaineropened');
    // Focus on input field

  }

});
$('.attachment-toggle .attachment-toggle-add-url').click(function(e) {
   
  var $container = $(this).closest('.attachment-toggle').children('.attachmenturluploadcontainer');
  
  if ($container.hasClass('fileuploadcontaineropened')) {
    // If already opened, close it
    $container.removeClass('fileuploadcontaineropened');
  } else {

    // Close all other containers
    $('.fileuploadcontaineropened').removeClass('fileuploadcontaineropened');
    // Open the clicked container
    $container.addClass('fileuploadcontaineropened');
    // Focus on input field

  }

});
$('.attachment-toggle .attachment-toggle-add-text').click(function(e) {
   
  var $container = $(this).closest('.attachment-toggle').children('.attachmenttextuploadcontainer');
  
  if ($container.hasClass('fileuploadcontaineropened')) {
    // If already opened, close it
    $container.removeClass('fileuploadcontaineropened');
  } else {

    // Close all other containers
    $('.fileuploadcontaineropened').removeClass('fileuploadcontaineropened');
    // Open the clicked container
    $container.addClass('fileuploadcontaineropened');
    // Focus on input field

  }

});
$('.fileuploadcontainer .attachment-toggle-add-file').click(function(e) {

  var $container = $(this).closest('.attachment-toggle').next('.fileuploadcontainer');
  console.log($container);
  if ($container.hasClass('fileuploadcontaineropened')) {
    // If already opened, close it
    $container.removeClass('fileuploadcontaineropened');
  } else {
    
    // Close all other containers
    $('.fileuploadcontaineropened').removeClass('fileuploadcontaineropened');
    // Open the clicked container
    $container.addClass('fileuploadcontaineropened');
    // Focus on input field

  }

});



</script>


<script>
$(document).ready(function() { 

$('.fileuploadcontainer input[type="file"]').on('input', function() {
  var $form = $(this).closest('form');
    $form.trigger('submit');
});


  $('.fileuploadcontainer form').submit(function (e) {
e.preventDefault();

$('.filepercentageandloader').css('display', 'block');
$('.drop-area2').css('display', 'none');

var formId = $(this).attr('id');
var $container = $(this).parent().closest('.attachment-toggle');
console.log($container);


var formData = new FormData(this);
var motherContainerValue = formData.get('motherContainer');
console.log(motherContainerValue)
var datashowContainerValue = formData.get('datashowContainer');
 var progressBarContainer = $('.filepercentageandloader');


        formData.getAll('eprocfiles[]').forEach(function (file, index) {
            // Create a new progress bar for this file
            var fileProgressBar = $('<div class="rounded " style="margin-top: 10px !important; width: 100% !important; height: 70px !important; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6 !important;"><span>'+ file.name+'</span><div class="d-flex justify-content-around align-items-center "><div class="lds-spinner" style="position: relative !important; top: -5px !important;"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div><div class="progress " style="width: 70% !important; height: 12px !important;"><div class="progress-bar"  role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div></div></div></div>');
            progressBarContainer.append(fileProgressBar)
})

var progressBar = $('.progress-bar');

$.ajax({
    url: 'https://robi.clouderp.com.bd/eProcurement_mod/api/new_api_file_upload.php',
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
       

		var responseObject = JSON.parse(responseData);

// Iterate over each response item
$.each(responseObject, function(index, item) {
	// Create a new card element
	var card = $('<div class="col-sm-10 col-md-10 col-lg-10 pb-1"><div class="rounded p-2" style="background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; "><a href="../../../../../assets/support/api_upload_attachment_show.php?name='+item.new_name+'" target="_blank"><i class="fa-light fa-file fa-2xl fs-22" style="color: #d6960a;"></i> <span>'+item.original_name+'</span></a><button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentseventinfo(\''+item.attachment_id+'\',\''+item.master_id+'\',\''+item.tr_from+'\',\''+item.entry_by+'\',\''+motherContainerValue+'\',\''+datashowContainerValue+'\')"><i class="fa-solid fa-xmark"></i></button></div></div>');
	$container.append(card);
		  $('.attachment-toggle').removeClass('opened').addClass('closed');
    $('.attachment-toggle, .search-container').removeClass('opened');
	$('.'+motherContainerValue+'').removeClass('fileuploadcontaineropened');
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
})
</script>

<!-- for event info attachment table -->


<!-- for INTERNAL event info attachment table -->

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
