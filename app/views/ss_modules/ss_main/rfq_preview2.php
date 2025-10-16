<?php
require_once "../../../controllers/routing/layout.top.php";
$current_page = "Events";
$title='Event Management';
do_calander("#f_date");
do_calander("#t_date");

$unique='rfq_no';
$table_master='rfq_master';
 $_SESSION[$unique];
$table_details='purchase_invoice';

$unsetSql = 'select * from form_elements where 1';
$usetQry = db_query($unsetSql);
while($elementData=mysqli_fetch_object($usetQry)){
unset($_SESSION[$elementData->element]);
}

$_GET['rfq_no'] = url_decode($_GET['rfq_no']);
if($_GET['rfq_no']>0){
$_SESSION[$unique] = $_GET['rfq_no'];
$_SESSION['rfq_version'] = find_a_field('rfq_master','rfq_version','rfq_no="'.$_SESSION[$unique].'"');
}

if($_SESSION[$unique]<1){
$Crud   = new Crud($table_master);
$_POST['rfq_date'] = date('Y-m-d');
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$_POST['eventtimezone'] = 'Asia/Dhaka UTC 06:00';
$_POST['rfx_stage'] = 'RFQ';
$max_rfq_no = find_a_field('rfq_master','max(rfq_no)+1','1');
$_POST['rfq_version'] = $max_rfq_no.'-V.0';
$_SESSION[$unique] = $Crud->insert();

$_SESSION['rfq_version'] = $_POST['rfq_version'];
unset($_POST);
}




if(isset($_POST['confirm'])){
 unset($_POST);
 $Crud   = new Crud($table_master);
 $info = find_all_field('rfq_master','','rfq_no="'.$_SESSION[$unique].'"');
 $_POST['eventEndAt'] =$info->eventEndDate.' '.$info->eventEndTime;
 $_POST['eventStartAt'] =$info->eventStartDate.' '.$info->eventStartTime;
 $_POST['status'] = 'CHECKED';
 $master_up = 'update rfq_master set status="CHECKED" where rfq_no="'.$_SESSION[$unique].'"';
 db_query($master_up);

 $type=1;
 $up = 'update rfq_vendor_details set status="INVITED" where rfq_no="'.$_SESSION[$unique].'"';
 db_query($up);
 unset($_SESSION[$unique]);
 unset($_SESSION['rfq_version']);
 unset($_SESSION[$unique]);
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



if(isset($_POST['att_details'])){

$Crud   = new Crud("rfq_doc_details");

		if($_SESSION[$unique]>0){
		$_POST['rfq_no']=$_SESSION[$unique];
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:s:i');
		$_POST['att_file'] = upload_file("rfq","att_file",time());
		$Crud->insert();

		}

}

if(isset($_POST['vendor_details'])){

$Crud   = new Crud("rfq_vendor_details");

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
		$_POST['att_file'] = upload_file("rfq","att_file",time());
		$Crud->insert();
        }
		}
		}

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

		//while (list($key, $value)=each($data))
		foreach ($data as $key => $value)

		{ ${$key}=$value;}

		

}

?>
<style>
.h1 {
    font-size: 16px !important;
    font-weight: 400;
}
.h1 i {
    font-size: 23px !important;
    font-weight: 400;
    color: #d6960a;
}
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

input[type=file]::file-selector-button {
  margin-right: 20px;
  border: none;
  background: #084cdf;
  padding: 10px 20px;
  border-radius: 10px;
  color: #fff;
  cursor: pointer;
 
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

input[type=file]::file-selector-button {
  margin-right: 20px;
  border: none;
  background: #084cdf;
  padding: 10px 20px;
  border-radius: 10px;
  color: #fff;
  cursor: pointer;
 
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
<style>
:root, [data-bs-theme=light] {
	    --bs-primary-bg-subtle: #cfe2ff;
		--bs-light: #f8f9fa;
		--bs-primary: #0d6efd;
		--bs-white: #fff;
}
.py-8 {
    padding-bottom: 4.5rem!important;
    padding-top: 4.5rem!important;
}

@media(min-width:576px) {
    .py-sm-8 {
        padding-bottom: 4.5rem!important;
        padding-top: 4.5rem!important;
    }
}

@media(min-width:768px) {
    .py-md-8 {
        padding-bottom: 4.5rem!important;
        padding-top: 4.5rem!important;
    }
}

@media(min-width:992px) {
    .py-lg-8 {
        padding-bottom: 4.5rem!important;
        padding-top: 4.5rem!important;
    }
}

@media(min-width:1200px) {
    .py-xl-8 {
        padding-bottom: 4.5rem!important;
        padding-top: 4.5rem!important;
    }
}

@media(min-width:1400px) {
    .py-xxl-8 {
        padding-bottom: 4.5rem!important;
        padding-top: 4.5rem!important;
    }
}

.bsb-timeline-7 {
    --bsb-tl-color: var(--bs-primary-bg-subtle);
    --bsb-tl-circle-color: var(--bs-light);
    --bsb-tl-circle-border-color: var(--bs-primary);
    --bsb-tl-indicator-color: var(--bs-white);
    --bsb-tl-circle-size: 16px;
    --bsb-tl-circle-offset: 8px;
    --bsb-tl-circle-border-size: 2px;
}

.bsb-timeline-7 .timeline {
    list-style: none;
    margin: 0;
    padding: 0;
    position: relative;
}

.bsb-timeline-7 .timeline:after {
    background-color: var(--bsb-tl-color);
    bottom: 0;
    content: "";
    left: 0;
    margin-left: -1px;
    position: absolute;
    top: 0;
    width: 2px;
}

@media(min-width:768px) {
    .bsb-timeline-7 .timeline:after {
        left: 33%;
    }
}

.bsb-timeline-7 .timeline>.timeline-item {
    margin: 0;
    padding: 0;
    position: relative;
}

.bsb-timeline-7 .timeline>.timeline-item:after {
    background: var(--bsb-tl-circle-color);
    border: var(--bsb-tl-circle-border-size) solid var(--bsb-tl-circle-border-color);
    border-radius: 50%;
    content: "";
    height: var(--bsb-tl-circle-size);
    left: calc(var(--bsb-tl-circle-offset)*-1);
    position: absolute;
    top: calc(50% - var(--bsb-tl-circle-offset));
    width: var(--bsb-tl-circle-size);
    z-index: 1;
}

.bsb-timeline-7 .timeline>.timeline-item .timeline-body {
    margin: 0;
    padding: 0;
    position: relative;
}

.bsb-timeline-7 .timeline>.timeline-item .timeline-meta {
    padding: 0 0 1rem 2.5rem;
}

.bsb-timeline-7 .timeline>.timeline-item:first-child .timeline-meta {
    padding: 2.5rem 0 1rem 2.5rem;
}

.bsb-timeline-7 .timeline>.timeline-item .timeline-content {
    padding: 0 0 2.5rem 0;
}

@media(min-width:768px) {
    .bsb-timeline-7 .timeline>.timeline-item {
        left: 33%;
        width: 67%;
    }
    .bsb-timeline-7 .timeline>.timeline-item .timeline-meta {
        display: flex;
        justify-content: flex-end;
        left: -100%;
        margin: 0;
        padding: 0 2.5rem 0 0;
        position: absolute;
        top: calc(50% - 29px);
        width: 100%;
        z-index: 1;
    }
    .bsb-timeline-7 .timeline>.timeline-item:first-child .timeline-meta {
        padding: 0 2.5rem 0 0;
    }
    .bsb-timeline-7 .timeline>.timeline-item .timeline-content {
        padding: 2.5rem;
    }
    .bsb-timeline-7 .timeline>.timeline-item .timeline-indicator {
        position: relative;
    }
    .bsb-timeline-7 .timeline>.timeline-item .timeline-indicator:after {
        border-width: 1px;
        border: 10px solid var(--bsb-tl-indicator-color);
        border-color: transparent var(--bsb-tl-indicator-color) transparent transparent;
        border-left-width: 0;
        content: "";
        left: calc(2.5rem - 10px);
        position: absolute;
        top: calc(50% - var(--bsb-tl-circle-offset));
        z-index: 1;
    }
}
.bg-success-subtle {
    background-color: var(--bs-success-bg-subtle) !important;
}


@media (min-width: 768px){}
.bsb-timeline-7 .timeline>.timeline-item .timeline-indicator:after {
    border-width: 1px;
    border: 10px solid var(--bsb-tl-indicator-color);
    border-color: transparent var(--bsb-tl-indicator-color) transparent transparent;
    border-left-width: 0;
    content: "";
    left: calc(2.5rem - 10px);
    position: absolute;
    top: calc(50% - var(--bsb-tl-circle-offset));
    z-index: 1;
}

*, ::after, ::before {
    box-sizing: border-box;
}
.btn-task-add {
    background-color: #cfe2ff;
    border: none;
    border-radius: 4px;
    box-shadow: 0 4px 10px 0 rgba(0,0,0,0.2), 0 3px 3px 0 rgba(0,0,0,0.19);
}
.timeline-body .timeline-content{
	padding-top: 5px !important;
	padding-bottom: 5px !important;
}
</style>

  <style>
.ep-clock-bg{
	background-color:#f2f2f2 !important;
	border-radius: 15px;
	box-shadow: inset 4px 4px 5px rgba(255,255,255,0.3), 
		  inset -4px -4px 5px rgba(0,0,0,0.1), 10px 40px 40px rgba(0,0,0,0.1);
		      width: 368px;
}
	.ep-titel{
	font-size: 15px !important;
	margin: 5px;
	    font-weight: 600;
	}
.countdown-container {
  display: flex;
  justify-content: center;
  margin: 0px !important;
   
    height: 75px;
    width: 255px;
    border-radius: 10px;
    align-items: center;
    background-color: #00bcd4;
    color: #fff;
	 
	 box-shadow: -12px -10px 10px rgba(255,255,255,0.2), 15px 15px 15px rgba(0,0,0,0.1), inset -10px -10px 10px rgba(255,255,255,0.2), inset 15px 15px 15px rgba(0,0,0,0.1);
}

.countdown-item {
  margin: 0 10px;
}

.countdown-label {
  /font-family: 'Orbitron', sans-serif !important;/
  font-size: 14px !important;
  color: #fff;
}

#days,
#hours,
#minutes {
  font-size: 24px !important;
  font-weight: bold;
  font-family: 'Orbitron', sans-serif !important;
}

    .blinking {
      animation: blink 3s infinite;
	  font-size: 35px !important;
    font-weight: bold;
    font-family: 'Orbitron', sans-serif !important;
    }

    @keyframes blink {
      50% {
        opacity: 0;
      }
    }

</style>


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

<select class="form-select" id="multiple-select-field" data-placeholder="Choose anything" multiple>
    <option>Christmas Island</option>
    <option>South Sudan</option>
    <option>Jamaica</option>
    <option>Kenya</option>
    <option>French Guiana</option>
    <option>Mayotta</option>
    <option>Liechtenstein</option>
    <option>Denmark</option>
    <option>Eritrea</option>
    <option>Gibraltar</option>
    <option>Saint Helena, Ascension and Tristan da Cunha</option>
    <option>Haiti</option>
    <option>Namibia</option>
    <option>South Georgia and the South Sandwich Islands</option>
    <option>Vietnam</option>
    <option>Yemen</option>
    <option>Philippines</option>
    <option>Benin</option>
    <option>Czech Republic</option>
    <option>Russia</option>
</select>
<script>
  $( '#multiple-select-field' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
    closeOnSelect: false,
} );
</script>

<? include 'ep_menu.php'; ?>
    <script type="text/javascript" src="../../../../public/assets/js/bootstrap.min.js"></script>	
	<script type="text/javascript" src="../../../../public/assets/js/jquery-3.4.1.min.js"></script>
	


<div class="container mt-1 p-0 ">

<div class="row p-0 pb-5">
	<div class="col-sm-8 col-lg-8 col-md-8 col-8">
	<h1 class="container" style=" font-size: 30px !important; "><?=$event_name?> - Event #<?=$_SESSION['rfq_version']?></h1>
						
	</div>
	<div class="col-sm-4 col-lg-4 col-md-4 col-4">
	<div class="d-flex justify-content-center align-items-center ep-clock-bg  p-3">
		<span class="ep-titel">Event End</span>
			<?
		?>
			
			
			  <div class="countdown-container">
					<div class="countdown-item">
					  <span id="days">00</span>
					  <div class="countdown-label">Days</div>
					</div>
					
					<div class="countdown-item">
					  <span id="colon" class="blinking">:</span>
					</div>
					
					<div class="countdown-item">
					  <span id="hours">00</span>
					  <div class="countdown-label">Hours</div>
					</div>
					<div class="countdown-item">
					  <span id="colon" class="blinking">:</span>
					</div>
					
					<div class="countdown-item">
					   <span id="minutes"></span>
					  <div class="countdown-label">Minutes</div>
					</div>
			  </div>
 
			
			
		</div>
	</div>
</div>

<div class="container-fluid  mt-1 p-0 " style=" background-color: #fffefe; ">
  

  <div class="row m-0 p-0 pt-4">
  	<div class="col-6 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-file-lines"></em> Basic Settings.. </h1>
		<hr class="m-3" />
		
		<table class="w-100">
			<tr class="tr">
				<td class="td1">Event Name<span id="ep"></span></td>
				<td class="td2"><p class="m-0 fs-14"><?=$event_name?></p>
				
				</td>
			</tr>
			
			<tr class="tr">
				<td class="td1">Currency</td>
				<td class="td2"> <p class="m-0 fs-14"><?=$currency?> </p>
				</td>
			</tr>
						
			<tr class="tr">
				<td class="td1">Attachments</td>
				<td class="td2" colspan="10">

				<div class="attachment-toggle">
										  
										  <div class="fileuploadcontainer" >
														
												<form  id="attachmentuploadFormxx" enctype="multipart/form-data">
												<input type="hidden" name="rfq_no" value="<?=$_SESSION[$unique]?>">
												<input type="hidden" name="tr_from" value="sourcing_basic_settings">
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
											<a href="../../../../../assets/support/api_upload_attachment_show.php?name='+item.new_name+'" target="_blank" rel="noopener">
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
												
											</button>
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
															<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentURLseventinfo(this,'<?=$res->documents_url_id?>' , '<?=$res->rfq_no?>', 'sample_value', '<?=$res->entry_by?>', 'attachmenturluploadcontainereventinfo','attachmentshowcontainereventinfo-url')">
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
												    $imgsrc="../../../../../assets/support/api_upload_attachment_show.php?name=default.svg.png&folder=logo";
													$sql = 'SELECT * FROM rfq_documents_information WHERE rfq_no = "'.$_SESSION[$unique].'" AND tr_from ="logo"';
													$qry = db_query($sql);
													$item = mysqli_fetch_object($qry); 
													if ($item) {
														
														$imgsrc="../../../../../assets/support/api_upload_attachment_show.php?name=".$item->new_name."&folder=".$item->tr_from;
													}
                                                   
													
													?>
												<label class="btn "><img id="logoshowbasicsourcing" src="<?=$imgsrc?>" style="width: 100%; max-height: 150px;mix-blend-mode: multiply;"/></label>
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
											<a href="../../../../../assets/support/api_upload_attachment_show.php?name='+item.new_name+'" target="_blank" rel="noopener">
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
															<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentURLseventinfo(this,'<?=$res->documents_url_id?>' , '<?=$res->rfq_no?>', 'sample_value', '<?=$res->entry_by?>', 'attachmenturluploadcontainereventinfo','attachmentshowcontainereventinfo-url')"> 
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
				<td class="td1">Related Documents</td>
				<td class="td2">None</td>
			</tr>
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
				<td class="td2"><p class="m-0 fs-14"><?=$tag?> </p> </td>
			</tr>
			
			<tr class="tr">
				<td class="td1">Event Commodity</td>
				<td class="td2"><p class="m-0 fs-14"> <?=$commodity?></p></td>
			</tr>
						
			<tr class="tr">
				<td class="td1">E-Procurement Commodity</td>
				<td class="td2"><p class="m-0 fs-14"> <?=$coupa_commodity?></p> </td>
			</tr>
						
			<tr class="tr">
				<td class="td1">Planned Savings</td>
				<td class="td2"><p class="m-0 fs-14"><?=$planned_savings?> <span><?=$planned_savings_currency?></span> </p> 
				</td>
			</tr>
									
			<tr class="tr">
				<td class="td1">Cost Avoidance</td>
				<td class="td2"><p class="m-0 fs-14"><?=$cost_avoidance?>  <span><?=$cost_avoidance_currency?></span></p> 
				</td>
			</tr>
									
			<tr class="tr">
				<td class="td1">Sourcing Type</td>
				<td class="td2"><p class="m-0 fs-14"><?=$sourcing_type?> </p></td>
			</tr>
									
			<tr class="tr">
				<td class="td1">RFx Reference #</td>
				<td class="td2"><p class="m-0 fs-14"><?=$rfx_referance?> </p> </td>
			</tr>
									
			<tr class="tr">
				<td class="td1">References / Form #</td>
				<td class="td2"><p class="m-0 fs-14"> <?=$referance_form?></p> </td>
			</tr>
									
			<tr class="tr">
				<td class="td1">Project Amount</td>
				<td class="td2"><p class="m-0 fs-14"><?=$project_amount?> <span><?=$project_amount_currency?></span> </p>
				 </td>
			</tr>
									
			<tr class="tr">
				<td class="td1">Attachment </td>
				<td class="td2">
				<div class="attachment-toggle">
								
								
								 
										  
										  
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
											<a href="../../../../../assets/support/api_upload_attachment_show.php?name='+item.new_name+'" target="_blank" rel="noopener">
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
															<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentURLseventinfo(this,'<?=$res->documents_url_id?>' , '<?=$res->rfq_no?>', 'sample_value', '<?=$res->entry_by?>', 'attachmenturluploadcontainereventinfo','attachmentshowcontainereventinfo-url')"> 
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
				<td class="td2"><p class="m-0 fs-14"><?=$other_notes?> </p></td>
			</tr>
												
			<tr class="tr">
				<td class="td1">Content Groups</td>
				<td class="td2">
  <input type="radio" id="content_group" name="content_group" value="Everyone" onchange="master_data(this.name,this.value)">
  <label for="vehicle1"><em class="fa-solid fa-users"></em> Everyone</label><br>
  
    <input type="radio" id="content_group" name="content_group" value="Only members of this content groups" onchange="master_data(this.name,this.value)">
  <label for="vehicle1"> Only members of this content groups</label><br>
				 </td>
			</tr>
			
			
		</table>
		
	</div>
	
	<div class="col-6  pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-file-lines"></em> Event Team </h1>	 
		<hr class="m-3" />

		<span id="team">
		<?php
		 $sql = 'select a.id,u.fname,a.action from rfq_evaluation_team a, user_activity_management u where a.user_id=u.user_id and a.rfq_no="'.$_SESSION[$unique].'"';
		 $qry = db_query($sql);
		 while($data=mysqli_fetch_object($qry)){
		?>
		<a class="pl-3"><em class="fa-regular fa-user"></em>&nbsp;<?=$data->fname?><span>(<?=$data->action?>)</span> </a><br />
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
		
			</div>
		</div>		
	</div>
  </div>
  
 
  </div>
    
  </div>
  
  
				                
 <? ?>
		<div class="container-fluid  mt-1 p-0 " style=" background-color: #fffefe; ">


	
	
<div class="pt-5 pl-3">
	  <h1 class="h1 m-0 p-0 pt-4 pl-3" ><em class="fa-light fa-timeline"></em> Timeline </h1>
		<hr style="height:1px;border:none;color:#333;background-color:#333;">
		
		<div   class="row align-items-center">
		
		  <label class="col-3 fs-18 bold m-0 text-right " for=" eventtimezone" style="font-size: 14px !important;color: #60768a; !important">Event Time Zone :</label>
		  <p class="m-0 col-3 fs-14 text-left pl-0"> <?=$eventtimezone?></p>
		</div>

		<div   class="mt-2 row align-items-center">
		  <label class="col-3 fs-18 bold m-0 text-right" style="font-size: 14px !important;color: #60768a; !important" for="eventend">Event Start Date :</label>
			<p class="m-0 col-3 fs-14 text-left pl-0"> <?=$eventStartDate?> (<?=$eventStartTime?>)</p>
		</div>
		
		<div   class="mt-2 row align-items-center">
		  <label class="col-3 fs-18 bold  m-0 text-right" style="font-size: 14px !important;color: #60768a; !important" for="eventend" style="font-size: 14px !important;color: #60768a; !important">Event End At</label>
		  <p class="m-0 col-3 fs-14 text-left pl-0"> <?=$eventEndDate?> (<?=$eventEndTime?>)</p>
		</div>
		
		
	  </div>
        
	
  </div>
  
  
 <? ?>
	<div class="container-fluid  mt-1 p-0 " style=" background-color: #fffefe; ">

  <div class="row m-0 p-0 pt-4">
  	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3 text-center"><em class="fa-solid fa-message-arrow-up-right"></em> Multiply Attachments </h1>
		
		<h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-paperclip"></em> Attachments </h1>
		<hr class="m-3" />
	
		
		<span id="details_att">
		<?
		 $sql = 'select * from rfq_doc_details where 1 and rfq_no="'.$_SESSION[$unique].'"';
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
			
				<p class="p-0 m-0" ><a href="">
				<a href="../../../../eProcurement/assets/support/api_upload_attachment_show.php?name=<?=$att_data->new_name?>&&folder=doc_section" target="_blank" rel="noopener">
												<em class="fa-light fa-file fa-2xl fs-22" style="color: #d6960a;"></em> 
												<span><?=$att_data->original_name?></span>
											</a></p>
			
			<? } ?>
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
		
	</div>
</div>
		<?php /*?><span id="form_details">
		<? 
		$sql = 'select * from rfq_form_master where rfq_no="'.$_SESSION[$unique].'"';
		$qry = db_query($sql);
		while($form_data=mysqli_fetch_object($qry)){
		extract((array) $form_data);
		echo $form_available;
		?>
		<div class="col-12 pt-4 pb-4">
			<h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-file-lines"></em> Forms Name - <?=$form_name?></h1>
			<hr class="m-3" />
			
			<div class="pt-1">
					<div class="row m-0 p-0 pt-4">
					<div class="col-6 ">
					<table class="w-100">
					<tbody>
					
					
					<tr class="tr">
						<td class="td1">Status : </td>
						<td class="td2"><?=$form_status?></td>
					</tr>
					
								
					<tr class="tr">
						<td class="td1">Description : </td>
						<td class="td2"><?=$form_description?>
						</td>
					</tr>
					
				</tbody>
				</table>
					</div>	
					<div class="col-6">
						<p class="p-0 m-0 bold">Available to</p>
						<p class="p-0 m-0">
						
						
						
						</p>
						
						  <input type="radio" <?php if($form_available=='everyone') {echo 'checked';}?> value="everyone" readonly="readonly">
							<label for="sa2"><em class="fa-duotone fa-user-group fa-flip-horizontal" style="--fa-primary-color: #20304c; --fa-secondary-color: #0eee0e;"></em> Everyone</label><br>
							
							<input type="radio" <?php if($form_available=='event_member') {echo 'checked';}?> value="event_member" readonly="readonly">
							<label for="sa3">Only members of these content groups</label><br />
							
												
							<label for="sa3">Tags : </label><?=$form_tags?>
							<input name="form_tags" type="text" id="form_tags" value="<?=$form_tags?>" style="width: 50% !important; "><br />
							<input type="checkbox" id="form_hide_from_search" name="form_hide_from_search" <?php if($form_hide_from_search=='1') {echo 'checked';}?>  value="1">
							<label for="sa3">Hide From Search</label>
							
						
						
					</div>
					
					
					<? 
		$sqlss = 'select f.*,f.id as form_details_id,e.fetch_file_name,e.element from rfq_form_details f,form_elements e where f.form_element=e.element and form_no="'.$form_no.'" and rfq_no="'.$_SESSION[$unique].'"';
		$qryr = db_query($sqlss);
		while($form_details_data=mysqli_fetch_object($qryr)){
		extract((array) $form_details_data);
		include_once($fetch_file_name);
		}
		?>
				
					
				</div>
			 <div  >
			 <? if($_SESSION['master_status']=='MANUAL'){?>
			 <button type="button" name="more_option" class="btn1 btn1-bg-cancel" onClick="remove_form(document.getElementById('new_rfq_no').value,<?=$form_no?>);">Remove Form</button><? } ?>
			 
			 </div>
			</div>
		</div>
	 <? } ?>
	 </span><?php */?>
	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-list"></em> Items and Sercices</h1>
		<td class="td2">
			 <div class="row">
              
			<span class=" pl-4 fs-18 bold">Attachments  </span> <div class="col-6 attachment-toggle">
										  
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
											<a href="../../../../../assets/support/api_upload_attachment_show.php?name='+item.new_name+'" target="_blank" rel="noopener">
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
															<button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentURLseventinfo(this,'<?=$res->documents_url_id?>' , '<?=$res->rfq_no?>', 'sample_value', '<?=$res->entry_by?>', 'attachmenturluploadcontainereventinfo','attachmentshowcontainereventinfo-url')"> 
															</button>
													</div>
												</div>
											
											<? } ?>
											  
											  </div>
</div>

			 </div>

		<hr class="m-3" />
		
		<div class="pt-1">
						
						<table class="table1  table-striped table-bordered table-hover table-sm" id="item_details">
						                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th scope="col">Name</th>
						<th scope="col">Item Description</th>
                        <th scope="col">Qty</th>
						<th scope="col">UOM</th>
						<th scope="col">Base Price</th>
						<th scope="col">Currency</th>
						<th scope="col">Amount</th>
						<th scope="col">Need By Date</th>
						
                    </tr>
                    </thead>
						<tbody class="tbody1">
						
						<?
		 $sql = 'select r.*,i.item_name from rfq_item_details r, item_info i where i.item_id=r.item_id and r.rfq_no="'.$_SESSION[$unique].'"';
		 $qry = db_query($sql);
		 while($doc=mysqli_fetch_object($qry)){
		?>
						<tr>
							<td><?=$doc->item_name?></td>
							<td><?=$doc->item_desc?></td>
							<td><?=$doc->expected_qty?></td>
							<td><?=$doc->unit?></td>
							<td><?=$doc->price?></td>
							<td><?=$doc->currency?></td>
							<td><?=number_format($doc->expected_qty*$doc->price,0)?></td>
							<td><?=$doc->need_by?></td>
                            
                        </tr>	
						<? } ?>
							
					</tbody>
                </table>
  
  
  
  
  </div>
		
		
		
	</div>
	
  </div>
  
				
  </div>



</div>
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

<select class="form-select" id="multiple-select-field" data-placeholder="Choose anything" multiple>
    <option>Christmas Island</option>
    <option>South Sudan</option>
    <option>Jamaica</option>
    <option>Kenya</option>
    <option>French Guiana</option>
    <option>Mayotta</option>
    <option>Liechtenstein</option>
    <option>Denmark</option>
    <option>Eritrea</option>
    <option>Gibraltar</option>
    <option>Saint Helena, Ascension and Tristan da Cunha</option>
    <option>Haiti</option>
    <option>Namibia</option>
    <option>South Georgia and the South Sandwich Islands</option>
    <option>Vietnam</option>
    <option>Yemen</option>
    <option>Philippines</option>
    <option>Benin</option>
    <option>Czech Republic</option>
    <option>Russia</option>
</select>
<script>
  $( '#multiple-select-field' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
    closeOnSelect: false,
} );
</script>




<script>
    const eventEndTime = "<?php echo $eventEndDate; ?> <?php echo $eventEndTime; ?>";
    const countdownDate = new Date(eventEndTime).getTime();

    const countdownTimer = setInterval(function() {
        const now = new Date().getTime();
        const distance = countdownDate - now;

       
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

        
        document.getElementById("days").innerText = formatTime(days);
        document.getElementById("hours").innerText = formatTime(hours);
		document.getElementById("minutes").innerText = formatTime(minutes);

        if (distance < 0) {
            clearInterval(countdownTimer);
            document.getElementById("days").innerText = "00";
            document.getElementById("hours").innerText = "00";
			document.getElementById("minutes").innerText = "00";
        }
    }, 1000);

    function formatTime(time) {
        return time < 10 ? `0${time}` : time; 
    }
</script>
  
 


  
<?
require_once "../../../controllers/routing/layout.bottom.php";
?>