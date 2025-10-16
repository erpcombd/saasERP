<?php
require_once "../../../controllers/routing/layout.top.php";
$current_page = "Events";
$title='Event Management';
do_calander("#f_date");
do_calander("#t_date");
$_SESSION['rfq_no'] = 406;
$unique='rfq_no';
$table_master='rfq_master';
$table_details='purchase_invoice';

$unsetSql = 'select * from form_elements where 1';
$usetQry = db_query($unsetSql);
while($elementData=mysqli_fetch_object($usetQry)){
unset($_SESSION[$elementData->element]);
}

if(isset($_POST['event_end']) && $_SESSION[$unique]>0){
$up = 'update rfq_master set eventEndAt="'.date('Y-m-d H:i:s').'" where rfq_no="'.$_SESSION[$unique].'"';
db_query($up);
echo '<span style="color:green; font-size:20px;">Event End Successfully</span>';
}

if(isset($_POST['event_edit']) && $_SESSION[$unique]>0){
$up = 'update rfq_master set status="MANUAL" where rfq_no="'.$_SESSION[$unique].'"';
db_query($up);
echo '<span style="color:green; font-size:20px;">Event Opened For Edit</span>';
}
echo $_GET['rfq_no'];
echo  url_decode($_GET['rfq_no']);
if($_GET['rfq_no']!=''){
$_GET['rfq_no'] = url_decode($_GET['rfq_no']);

$_SESSION[$unique] = $_GET['rfq_no'];
$_SESSION['rfq_version'] = find_a_field('rfq_master','rfq_version','rfq_no="'.$_SESSION[$unique].'"');
$_SESSION['master_status'] = find_a_field('rfq_master','status','rfq_no="'.$_SESSION[$unique].'"');
}



echo $_SESSION[$unique];
if($_SESSION[$unique]<1){
$Crud = new Crud($table_master);
$_POST['rfq_date'] = date('Y-m-d');
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$_POST['eventtimezone'] = 'Asia/Dhaka UTC 06:00';
$_POST['rfx_stage'] = 'RFQ';
$max_rfq_no = find_a_field('rfq_master','max(rfq_no)+1','1');
$_POST['rfq_version'] = $max_rfq_no.'-V.0';
$_SESSION[$unique] = $Crud->insert();

$_SESSION['rfq_version'] = $_POST['rfq_version'];
$_SESSION['master_status'] = 'MANUAL';
unset($_POST);
}


if(isset($_POST['confirm'])){
 unset($_POST);
 $Crud   = new Crud($table_master);
 $info = find_all_field('rfq_master','','rfq_no="'.$_SESSION[$unique].'"');
 $_POST['eventEndAt'] =$info->eventEndDate.' '.$info->eventEndTime;
 $_POST['eventStartAt'] =$info->eventStartDate.' '.$info->eventStartTime;
 $_POST['status'] = 'CHECKED';
 if($info->immediate_event_shoot=='checked'){
 $_POST['eventStartTime'] = date('H:i');
 $_POST['eventStartDate'] = date('Y-m-d');
 $_POST['eventStartAt'] = date('Y-m-d H:i');
 }else{
 $_POST['eventStartTime'] = $info->eventStartTime;
 $_POST['eventStartDate'] = $info->eventStartDate;
 $_POST['eventStartAt'] = $info->eventStartAt;
 }
 $master_up = 'update rfq_master set status="CHECKED",eventStartTime="'.$_POST['eventStartTime'].'",eventStartDate="'.$_POST['eventStartDate'].'",eventStartAt="'.$_POST['eventStartAt'].'" where rfq_no="'.$_SESSION[$unique].'"';
 db_query($master_up);
 
 $type=1;
 $up = 'update rfq_vendor_details set status="INVITED" where rfq_no="'.$_SESSION[$unique].'"';
 db_query($up);
 unset($_SESSION[$unique]);
 unset($_SESSION['rfq_version']);
 unset($_SESSION['master_status']);
 header('location:eprocurement_entry.php');
}



if(isset($_POST['unseal'])){
 $Crud   = new Crud($table_master);
 unset($_POST);
 $_POST[$unique] = $_SESSION[$unique];
 $_POST['status'] = 'UNSEALED';
 $Crud->update($unique);
 $type=1;
 
}






if(isset($_POST['item_details'])){

$Crud   = new Crud("rfq_item_details");

		if($_SESSION[$unique]>0){
		$item = end(explode("#",$_POST['item_id']));
		$_POST['item_id'] = $item;
		$_POST['rfq_no']=$_SESSION[$unique];
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:s:i');
		$Crud->insert();

		}

}


if(isset($_POST['add_event_team'])){
$Crud   = new Crud("rfq_evaluation_team");
if($_SESSION[$unique]>0){
		
		$_POST['user_id']=$_POST['event_team_user_id'];
		$_POST['action']=$_POST['event_team_level'];
		$_POST['rfq_no']=$_SESSION[$unique];
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:s:i');
		$Crud->insert();

		}
}



		if($_SESSION[$unique]>0 && $_GET['del_id']>0){
		 $delete = 'delete from rfq_doc_details where id="'.$_GET['del_id'].'"';
		 db_query($delete);
		}




		if($_SESSION[$unique]>0 && $_GET['del_item_id']>0){
		 $delete = 'delete from rfq_item_details where id="'.$_GET['del_item_id'].'"';
		 db_query($delete);
		}


if($_SESSION[$unique]>0)

{

		$condition=$unique."=".$_SESSION[$unique];

		$data=db_fetch_object($table_master,$condition);

	
	foreach ($data as $key => $value)

		{ ${$key}=$value;}

		

}

?>

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
    font-size: 23px !important;
    font-weight: 400;
    color: #d6960a;
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







 .dropdown {
    position: relative;
    display: inline-block;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 210px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
	left: 10px; 
	padding: 5px 0px;
	border-radius: 3px;
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

</style>

<? include_once 'ep_menu.php'; ?>
    <script type="text/javascript" src="../../../../public/assets/js/bootstrap.min.js"></script>	
	<script type="text/javascript" src="../../../../public/assets/js/jquery-3.4.1.min.js"></script>
	


<div class="container mt-1 p-0 ">

<div class="row p-0 pb-5">
	<div class="col-sm-6 col-lg-6 col-md-6 col-6">
	<h1 class="container" style=" font-size: 30px !important; ">Sourcing - <?=$event_name?> #<?=$_SESSION['rfq_version']?></h1>
					
	</div>
	<div class="col-sm-6 col-lg-6 col-md-6 col-6">
	<form method="post">
	<button type="submit" name="event_end" class="btn1 btn1-bg-update" style="width:20% !important;">End</button>
	<button type="submit" name="event_edit" class="btn1 btn1-bg-update" style="width:20% !important;">Edit</button>
	<button type="button" name="add_event_team" class="btn1 btn1-bg-warning" style="width:20% !important;">Hold</button>
	<button type="button" name="add_event_team" class="btn1 btn1-bg-cancel" style="width:20% !important;">Cancel</button>
	</form>
	</div>
</div>






<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="settings-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="settings" aria-selected="true" onclick="settingF('tab1');">Settings</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="timeline-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="timeline" aria-selected="false" onclick="settingF('tab2');">Timeline</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="details-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="details" aria-selected="false" onclick="settingF('tab3');">Details</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="suppliers-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="suppliers" aria-selected="false" onclick="settingF('tab4');">Suppliers</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="evaluations-tab" data-toggle="tab" href="#tab5" role="tab" aria-controls="evaluations" aria-selected="false" onclick="settingF('tab5');">Evaluations</a>
  </li>
   <li class="nav-item">
    <a class="nav-link" id="responses-tab" data-toggle="tab" href="#tab6" role="tab" aria-controls="responses" aria-selected="false" onclick="settingF('tab6');">Responses</a>
  </li>
</ul>


<div class="tab-content" id="myTabContent">

				                
 <? include_once('basic_settings.php');?>
		
  
  
 <? include_once('timeline_tab.php');?>
  		

  <? //include_once('details_tab.php')?> 
  <? include_once('details_tab1.php')?> 
  
 
  <?
  include_once('supplier_tab.php');
  ?> 
  
  <?
  include_once('evaluation_tab_dev.php');

  ?> 
  
   
  <?
  include_once('response_tab.php');
  ?> 
  
</div>

</div>


<script>

function master_data(thisField,thisValue){
getData2('master_ajax.php','ep',thisField,thisValue);
}

function event_team_insert(rfq_no,user_id,level){
getData2('event_team_ajax.php','team',rfq_no,user_id + "|" + level);
}

function event_team_cancel(rfq_no,id){
getData2('event_team_cancel_ajax.php','team',rfq_no,id);
}


function event_details_att_cancel(rfq_no,id,type){
getData2('event_details_att_cancel_ajax.php',type,rfq_no,id);
}

function event_item_insert(){
var rfq_no = document.getElementById('new_rfq_no').value;
var item_info = document.getElementById('item_desc').value;
var unit_name = document.getElementById('unit').value;
var qty = document.getElementById('expected_qty').value;
var price = document.getElementById('price').value;
var currency = document.getElementById('base_currency').value;

var second_part = item_info +"|"+ unit_name +"|"+ qty +"|"+ price +"|"+ currency;

getData2('event_item_ajax.php','item_details',rfq_no,second_part);

}

function event_item_cancel(rfq_no,id){
getData2('event_item_cancel_ajax.php','item_details',rfq_no,id);
}




function select_html(type,action){
	document.getElementById('form_element').value='';
getData2('get_html_element_ajax.php','html_details',type,action);
}





function addOption(type,id) {
  var unique_id = type+'_'+id;
  var total_option = document.getElementById('option_count_'+unique_id).value*1;
 
  var new_total_option = total_option+1;
  
  var newRow = '<tr><td>Option-'+new_total_option+'</td><td><input type="text" name="option_'+new_total_option+'_'+unique_id+'" id="option_3"/></td></tr>';
  document.getElementById('optionsTable_'+unique_id).innerHTML += newRow;
  document.getElementById('option_count_'+unique_id).value = new_total_option;
  }
</script>


<script>
  
  
     function settingF(tab){
       var newURL = '?'+tab;
       history.pushState(null, null, newURL);
	   
	   var tabLinks = document.querySelectorAll('a[role="tab"]');
       tabLinks.forEach(function(tabLink) {
       tabLink.classList.remove("active"); });
	   
	   if(tab=='tab1'){
       var myLink = document.getElementById('settings-tab');
       
	   }else if(tab=='tab2'){
	   var myLink = document.getElementById('timeline-tab');
	   }else if(tab=='tab3'){
	   var myLink = document.getElementById('details-tab');
	   }else if(tab=='tab4'){
	   var myLink = document.getElementById('suppliers-tab');
	   }else if(tab=='tab5'){
	   var myLink = document.getElementById('evaluations-tab');
	   }else if(tab=='tab6'){
	   var myLink = document.getElementById('responses-tab');
	   }
	   
	   myLink.className="nav-link active";
	   area_selector(tab);
	   }
	   
	   
	   function area_selector(tab){
	   
	   
	   document.getElementById('tab1').className="tab-pane fade";
	   document.getElementById('tab2').className="tab-pane fade";
	   document.getElementById('tab3').className="tab-pane fade";
	   document.getElementById('tab4').className="tab-pane fade";
	   document.getElementById('tab5').className="tab-pane fade";
	   document.getElementById('tab6').className="tab-pane fade";
	   
	   document.getElementById(tab).className="tab-pane fade show active";
	   
	   }
  
  var queryString = window.location.search;
  var queryStringWithoutQuestionMark = queryString.substring(1);
  window.onload = settingF(queryStringWithoutQuestionMark);
  
 
</script>





<script>
function toggleDropdown() {
  var dropdown = document.getElementById("myDropdown");
  if (dropdown.style.display === "block") {
    dropdown.style.display = "none";
  } else {
    dropdown.style.display = "block";
  }
}

document.body.addEventListener("click", function(event) {
  var dropdown = document.getElementById("myDropdown");
  var dropdownButton = document.getElementById("dropdown");
  if (!dropdown.contains(event.target) && !dropdownButton.contains(event.target)) {
    dropdown.style.display = "none";
  }
});


function item_rate_cal(){

var qty = document.getElementById("expected_qty").value*1;
var rate = document.getElementById("price").value*1;
var amount = qty*rate;
document.getElementById("item_total_amount").value = amount;
}


function event_att_insert(section_name,terms,section_type,att_response,is_required,type){
showLoader();
var att_response = document.getElementById("att_response_"+section_type).checked;
var is_required  = document.getElementById("is_required_"+section_type).checked;
if(att_response==true){
att_response = 1;
}else{
att_response = 0;
}

if(is_required==true){
is_required = 1;
}else{
is_required = 0;
}

        var formData = new FormData();
        var files = $('#att_file_'+section_type)[0].files;
        for (var i = 0; i < files.length; i++) {
            formData.append('files[]', files[i]);
        }
		formData.append('section_name',section_name);
		formData.append('section_terms',terms);
		formData.append('att_response',att_response);
		formData.append('is_required',is_required);
		formData.append('section_type',section_type);
        
        $.ajax({
            url: 'multiple_att_upload_ajax.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                
                
                xhr.upload.addEventListener('progress', function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total * 100;
                        $('#progress').text('Uploading: ' + percentComplete.toFixed(2) + '%. Wait');
                    }
                }, false);

                return xhr;
            },	
			
            success: function(response){
			 var res = JSON.parse(response);
			 $('#progress').html('Upload successful');
			 get_doc_section(section_type,type);
			 $('#section_name').val('');
			 $('#terms').val('');
			 $('#terms').val('');
			 $('#att_file').val('');
			 $('#att_response').prop('checked', false);
			 $('#is_required').prop('checked', false);
			 $('#progress').html('');
			 hideLoader();
			 },
            error: function(xhr, status, error) {
              
                console.error('Upload error:', error);
                $('#progress').text('Upload error: ' + error);
            }
        });
}

function get_doc_section(section,type){
getData2('get_document_section_ajax.php',type,section,section);
}

function event_form_insert() {
  var formData = $("#htmlForm").serialize();
  $.ajax({
    url: "event_form_insert_ajax.php",
    method: "POST",
    dataType: "JSON",
    data: formData,
    success: function (result, msg) {
      var res = result;
      get_form_content();
      
    },
  });
}

function remove_form(rfq_no, form_id) {
  getData2("event_form_remove_ajax.php", "form_details", rfq_no, form_id);
}

function get_form_content() {
  var type = "type";
  getData2("get_form_content_ajax.php", "form_details", type, type);
}

function company_setup(company) {
  var company = company;
  getData2("company_setup_ajax.php", "company_details", company, company);
}

function currency_show(currency){
            var currency = currency;
			
            var xhr = new XMLHttpRequest();
         
            xhr.open('POST', 'currency_save_ajax.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

           
            xhr.send('currency=' + currency);

            
            xhr.onload = function() {
                if (xhr.status == 200) {
					var res = JSON.parse(xhr.responseText);
                    document.getElementById('planned_savings_currency').value = res['msg'];
					document.getElementById('cost_avoidance_currency').value = res['msg'];
					document.getElementById('project_amount_currency').value = res['msg'];
					document.getElementById('base_currency').value = res['msg'];
                }
            };
        }


    function showLoader() {
        document.getElementById('loader').style.display = 'flex';
    }

    function hideLoader() {
        document.getElementById('loader').style.display = 'none';
    }

</script>
<script type="text/javascript" src="document_script.js"></script>
	<script type="text/javascript" src="vendor_script.js"></script>
	<script type="text/javascript" src="evaluation_section.js"></script>





<?
require_once "../../../controllers/routing/layout.bottom.php";
?>