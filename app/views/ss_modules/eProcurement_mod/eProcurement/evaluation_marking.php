<?php

require_once "../../../controllers/routing/layout.top.php";
$current_page = "Events";
$title='Event Management';

do_calander("#f_date");
do_calander("#t_date");

$unique='rfq_no';
$table_master='rfq_master';

$vendor_id2=$_GET['vendor_id'];
$section_id2=$_GET['evaluation_id'];

$table_details='purchase_invoice';

$unsetSql = 'select * from form_elements where 1';
$usetQry = db_query($unsetSql);
while($elementData=mysqli_fetch_object($usetQry)){
unset($_SESSION[$elementData->element]);
}

if($_GET['rfq_no']>0){
$_SESSION[$unique] = $_GET['rfq_no'];
}


$vendor_name = find_a_field('vendor','vendor_name','vendor_id="'.$_GET['vendor_id'].'"');





if(isset($_POST['unseal'])){
 $Crud   = new Crud($table_master);
 unset($_POST);
 $_POST[$unique] = $_SESSION[$unique];
 $_POST['status'] = 'UNSEALED';
 $Crud->update($unique);
 $type=1;

}


if($_SESSION[$unique]>0)

{

		$condition=$unique."=".$_SESSION[$unique];

		$data=db_fetch_object($table_master,$condition);

		foreach($data as $key => $value)

		{ ${$key}=$value;}

		

}

?>
<? include 'ep_menu.php'; ?>

    <script type="text/javascript" src="../../../../public/assets/js/bootstrap.min.js"></script>	
	<script type="text/javascript" src="../../../../public/assets/js/jquery-3.4.1.min.js"></script>
	
<style>
.nav-tabs .nav-item .nav-link, .nav-tabs .nav-item .nav-link:hover, .nav-tabs .nav-item .nav-link:focus {
    border: 0 !important;
    color: #007bff !important;
    font-weight: 500;
	text-transform: capitalize;
	font-size: 14px !important;
}
.sidebar, .sidemenu{
	display:none;
    width: 0% !important;
}

.main_content{
	width: 100% !important;
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

.tox-notifications-container{
      display: none !important;
  }

</style>



<style>

 .dropdown {
    position: relative;
    display: inline-block;
  }

  .dropdown-content {
    position: absolute;
    background-color: #f9f9f9;
    min-width: 210px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
	left: 10px; 
	padding: 5px 0px;
	border-radius: 3px;
	background-color: white;
  }
  .dropdown-content a{
  	background-color:#fff !important;
	text-align:left;
	padding: 5px 0px 5px 10px;
  }
  .dropdown-content a:hover{
  color:#f37025;
  }
  
.d-flex-bg-color{
background-color:#333 !important;
}
.ep-bg-color{
	background-color:#f5f5f5 !important;
}
.btn1-bg-submit{
	margin:10px !important;
	background-color:#FFFFFF !important;
	color:#333 !important;
	font-weight:bold !important;	
}
.alerts-bg{
	background-color:#f0f0f0;
	padding:10px;
}
.bg-alerts-bg{
background-color:#FFFFFF !important;
}
.alerts-table{
	height:300px !important;
}
.sourcing-table{
	width:100%;
}

.sourcing-table tr:nth-child(odd), .sourcing-table tr:nth-child(even)  {
    background-color: #fff !important;
    color: #333!important;
	text-align:left;
}
.tab-pane{
background-color:#fff !important;
}
.nav-tabs {
    border-bottom: 1px solid #d9d9d9;
    background-color: #fffefe;
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
<? $rfq_data = find_all_field('rfq_master','*','rfq_no="'.$_SESSION['rfq_no'].'"'); ?>

<div class="container mt-1 p-0 ">

<div class="row p-0 pb-5">
	<div class="col-sm-9 col-lg-9 col-md-9 col-9">
	<h1 class="container" style=" font-size: 30px !important; ">
		<?=$rfq_data->event_name;?> #<?=$rfq_data->rfq_version;?>
		
	
	<span style="font-size:11px;">(Evaluation)</span></h1>
						
	</div>
	<div class="col-sm-3 col-lg-3 col-md-3 col-3">
	</div>
</div>

<div class="attachment-toggle">
								
								
								<span class="btn btn-danger" style="cursor: pointer; float: right;" onmouseover="this.style.color='orange'" 
								onmouseout="this.style.color='blue'">File Upload</span>
					
										  
										  
										  <div class="fileuploadcontainer" >
														
												<form  id="attachmentuploadFormxx" enctype="multipart/form-data">
												<input type="hidden" name="rfq_no" value="<?=$_SESSION[$unique]?>">
												<input type="hidden" name="tr_from" value="evalution_marking">
												<input type="hidden" name="entry_by" value="<?=$_SESSION['user']['id']?>">
												<input type="hidden" name="vendor_id" value="<?=$_GET['vendor_id']?>">
												<input type="hidden" name="section_id" value="<?=$_GET['evaluation_id']?>">
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

										  <div class="attachmentshowcontainer container row m-0">
                        <?
						  $sql = 'SELECT * FROM evaluation_documents_information WHERE rfq_no = "'.$_SESSION[$unique].'" AND vendor_id ="'.$vendor_id2.'" AND section_id="'.$section_id2.'"';
						  $qry = db_query($sql);
						  while($item=mysqli_fetch_object($qry)){
						?>
                                      <div class="col-sm-10 col-md-10 col-lg-10 pb-1">
										<div class="rounded p-2" style="background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
										<a href="../../../controllers/utilities/api_upload_attachment_show.php?name=<?=$item->new_name?>&folder=<?=$item->tr_from?>" target="_blank" rel="noopener">
												<em class="fa-solid fa-file fa-2xl fs-22" style="color: #d6960a;"></em> 
												<span><?=$item->original_name?></span>
											</a>
											<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentseventinfo(this,
                                   '<?=$item->id;?>',
                                   '<?=$item->rfq_no;?>',
                                   '<?=$item->vendor_id;?>',
                                   '<?=$item->section_id;?>',
                                   '<?=$motherContainerValue;?>',
                                   '<?=$datashowContainerValue;?>')">
												<em class="fa-solid fa-xmark"></em>
											</button>
										</div>
									</div>
<?}?>
						</div>


											


</div>


			<form method="post" action="" id="ep_form">
			<div id="section_details">
			<?
		$found = 0;
		if($rfq_data->master_rfq_no>0){
			$sql = 'select * from rfq_evaluation_section where rfq_no="'.$rfq_no.'" and master_row_id="'.$_GET['evaluation_id'].'"';
		}else{
			$sql = 'select * from rfq_evaluation_section where rfq_no="'.$rfq_no.'" and id="'.$_GET['evaluation_id'].'"';
		}
		
		//echo $sql = 'select * from rfq_evaluation_section where rfq_no="'.$rfq_no.'" and master_row_id="'.$_GET['evaluation_id'].'"';
		 $qry = db_query($sql);
		 while($doc=mysqli_fetch_object($qry)){
		 $evaluation_status = $doc->status;
		?>

			<div class="col-12 row">
	<div class="col-6 ">
	<?=$doc->section_name.' Evaluation Weightage '.$doc->section_percent?> %
			<fieldset class="scheduler-border">
    
            
            <div id="section_child_details_<?=$doc->id?>"><input type="hidden" name="section_id" id="section_id" value="<?=$doc->id?>" />
			<input type="hidden" name="vendor_id" id="vendor_id" value="<?=$_GET['vendor_id']?>" />
			<input type="hidden" name="section_name" id="section_name" value="<?=$doc->section_name?>" />
			<input type="hidden" name="section_percent" id="section_percent" value="<?=$doc->section_percent?>" />
             <table class="w-100"    border="1">
			 <thead>
			   <tr>
			    <th>Criteria</th>
				<th>Weightage</th>
				<th>Marking</th>
			   </tr>
			 </thead>
            <tbody>
			<?
		 $sql2 = 'select * from rfq_evaluation_section_child where rfq_no="'.$rfq_no.'" and section_id="'.$doc->id.'"';
		 $qry2 = db_query($sql2);
		 while($doc2=mysqli_fetch_object($qry2)){
		 $marking = find_a_field('rfq_evaluation_section_child_vendor','final_mark','setup_detilas_id="'.$doc2->id.'" and vendor_id="'.$_GET['vendor_id'].'" 
		 and edit_by = '.$_SESSION['user']['id'].' '); 
		?>
           
           <tr>
             <td><?=$doc2->child_name?><input type="hidden" name="section_child_id" id="section_child_id" value="<?=$doc2->id?>" /></td>
             <td><?=$doc2->child_percent?>%</td>
   
             <td><input type="text" name="<?=$doc->id.'_'.$doc2->id?>" id="<?=$doc->id.'_'.$doc2->id?>" placeholder="Marking..%" value="<?=$marking?>" required /></td>
           </tr>
			
			
			<? } ?>
			<tr>
			<td colspan="3"  >
			<? if($marking<1){?>
			  <span id="confirmation_msg" style="color:green; font-size:15px;"><button type="button" name="section" class="btn1 btn1-bg-update" onclick="evaluation_confirmation()">Save</button></span>
			  <? } else{ echo 'Already Marking Completed'; } ?>
			  </td>
			</tr>
			</tbody>
            </table>
			</div>
			</fieldset>
            
			</div>
            
			</div>
			
			<? } ?>
			
			</div>
			</form>
			</div>
<script>
function get_response_details(){
var response_type = 'test';
getData2('get_response_details_ajax.php','response_details',response_type,response_type);
}
</script>			
<script type="text/javascript" src="evaluation_confirm_script.js"></script>
<script>

$('.attachment-toggle .attachment-toggle-add-file').click(function(e) {
  var $container = $(this).closest('.attachment-toggle').children('.fileuploadcontainer');

  if ($container.hasClass('fileuploadcontaineropened')) {
    
    $container.removeClass('fileuploadcontaineropened');
  } else {
   
    
    $('.fileuploadcontaineropened').removeClass('fileuploadcontaineropened');
   
    $container.addClass('fileuploadcontaineropened');
    

  }

});

$(' .attachment-icon-close-container').click(function(e) {

var $container = $(this).closest('.attachment-toggle').next('.fileuploadcontainer');

if ($container.hasClass('fileuploadcontaineropened')) {
  
  $container.removeClass('fileuploadcontaineropened');
} else {
  
  
  $('.fileuploadcontaineropened').removeClass('fileuploadcontaineropened');
 
  $container.addClass('fileuploadcontaineropened');
 

}

});


$('.fileuploadcontainer input[type="file"]').on('input', function() {
    var $form = $(this).closest('form');
    $form.trigger('submit');
});

$('.fileuploadcontainer form').submit(function (e) {
  e.preventDefault();

  $('.filepercentageandloader').css('display', 'block');
  $('.drop-area2').css('display', 'none');



  var $container = $(this).closest('.attachment-toggle').find('.attachmentshowcontainer');
  var $mothercontainer = $(this).closest('.attachment-toggle').find('.fileuploadcontainer');

  var files = [];
  var formData = new FormData(this);
  var motherContainerValue = formData.get('motherContainer');
  var datashowContainerValue = formData.get('datashowContainer');
  var progressBarContainer = $('.filepercentageandloader');

  formData.getAll('eprocfiles[]').forEach(function (file, index) {

    if (file.size <= 10 * 1024 * 1024) { // Check if file size is less than or equal to 10 MB
      var fileProgressBar = $('<div class="rounded " style="margin-top: 10px !important; width: 100% !important; height: 70px !important; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6 !important;"><span>'+ file.name+'</span><div class="d-flex justify-content-around align-items-center "><div class="lds-spinner" style="position: relative !important; top: -5px !important;"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div></div>');
      progressBarContainer.append(fileProgressBar)
      files.push({
        name: file.name,
        type: file.type,
        data: null // Placeholder for the file data
      });
    } else {
      var card = $('<div class="col-sm-10 col-md-10 col-lg-10 pb-1"><div class="rounded p-2" style="background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; "><span style="color:red !important">'+file.name+' is more than 10MB</span></div></div>');
      $container.append(card);
    }
  });

  var progressBar = $('.progress-bar');

  // Function to convert file to Base64
  function readFileAsDataURL(file) {
      return new Promise(function(resolve, reject) {
          var reader = new FileReader();
          reader.onload = function(event) {
              resolve(event.target.result);
          };
          reader.onerror = function(error) {
              reject(error);
          };
          reader.readAsDataURL(file);
      });
  }

  // Promise to read all files and convert them to Base64
  var promises = files.map(function(fileObj, index) {
      return readFileAsDataURL(formData.getAll('eprocfiles[]')[index]);
  });

  // Once all files are converted to Base64, continue
  Promise.all(promises).then(function(base64Strings) {
      base64Strings.forEach(function(base64String, index) {
          files[index].data = base64String.split(',')[1]; // Remove the 'data:image/jpeg;base64,' part
      });
      var rfq_no = formData.get('rfq_no');
      var tr_from = formData.get('tr_from');
      var entry_by = formData.get('entry_by');
      var vendor_id = formData.get('vendor_id');
      var section_id = formData.get('section_id');
      // Send the files array as JSON to the server
      $.ajax({
          url: '../../../views/eProcurement_mod/api/new_api_file_upload_evalution_marking.php',
          type: 'POST',
          // data: JSON.stringify({ files: files }),
          data: JSON.stringify({ files: files, rfq_no: rfq_no, tr_from: tr_from, entry_by: entry_by, section_id: section_id,vendor_id:vendor_id }),
          contentType: 'application/json',
          success: function (responseData) {
            
              console.log(responseData);
              var responseObject = JSON.parse(responseData);

              $.each(responseObject, function(index, item) {
                if(item.status=="success"){
                  var card = $('<div class="col-sm-10 col-md-10 col-lg-10 pb-1"><div class="rounded p-2" style="background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; "><a href="../../../controllers/utilities/api_upload_attachment_show.php?name='+item.new_name+'&folder='+item.tr_from+'&original_name='+item.original_name+'" target="_blank" rel="noopener"><em class="fa-solid fa-file fa-2xl fs-22" style="color: #d6960a;"></em> <span>'+item.original_name+'</span></a><button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentseventinfo(this,\''+item.attachment_id+'\',\''+item.rfq_no+'\',\''+item.vendor_id+'\',\''+item.section_id+'\',\''+motherContainerValue+'\',\''+datashowContainerValue+'\')"><em class="fa-solid fa-xmark"></em></button></div></div>');
                }else{
                  var card = $('<div class="col-sm-10 col-md-10 col-lg-10 pb-1"><div class="rounded p-2" style="background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; "></em> <span style="color:red !important">'+item.message+'</span></div></div>');
                }
                  $container.append(card);
                  $mothercontainer.removeClass('fileuploadcontaineropened');

                  $('.filepercentageandloader').empty();
                  $('.filepercentageandloader').css('display', 'none');
                  $('.drop-area2').css('display', 'block');
              });
          },
          error: function (xhr, status, error) {
              console.error('Error uploading image:', error);
              $('#response').text('Error uploading image. Please try again.');
          }
      });
  }).catch(function(error) {
      console.error('Error converting files to Base64:', error);
  });
});


function deleteAttachmentseventinfo(button,attachmentid, masterId, vendor_id, section_id,motherContainerValue,datashowContainerValue) {
  
  var $attachmentcontainershow = $(button).closest('.attachmentshowcontainer');
 
  


    $.ajax({
        url: '../../../views/eProcurement_mod/api/api_attachment_delete_evalution_marking.php',
        type: 'POST',
        data: JSON.stringify({
        attachmentid: attachmentid,
        masterId: masterId,
        vendor_id: vendor_id,
        section_id: section_id
    }),
        success: function(responseData) {

        console.log(responseData)
            
			var responseObject = JSON.parse(responseData);
			$attachmentcontainershow.empty();



		$.each(responseObject, function(index, item) {
			
			var card = $('<div class="col-sm-10 col-md-10 col-lg-10 pb-1"><div class="rounded p-2" style="background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; "><a href="../../../views/eProcurement_mod/utilities/support/api_upload_attachment_show.php?name='+item.new_name+'&folder='+item.tr_from+'" target="_blank" rel="noopener"><em class="fa-solid fa-file fa-2xl fs-22" style="color: #d6960a;"></em> <span>'+item.original_name+'</span></a><button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentseventinfo(this,\''+item.attachment_id+'\',\''+item.rfq_no+'\',\''+item.vendor_id+'\',\''+item.section_id+'\',\''+motherContainerValue+'\',\''+datashowContainerValue+'\')"><em class="fa-solid fa-xmark"></em></button></div></div>');
            
			$attachmentcontainershow.append(card);
		})
            
        },
        error: function(xhr, status, error) {
            console.error('Error uploading image:', error);
            $('#response').text('Error uploading image. Please try again.');
        },
       
    });
}


</script>



<?
require_once "../../../controllers/routing/layout.bottom.php";
?>