<?php


require_once "../../../controllers/routing/layout.top.php";
$current_page = "Events";
$title='Event Management';
do_calander("#f_date");
do_calander("#t_date");

$unique='rfq_no';
$table_master='rfq_master';
 $_SESSION[$unique];




if(isset($_POST['award_submit'])){

  //$Crud   = new Crud("auction_vendor_reward");
  
    if($_SESSION[$unique]>0){
       foreach($_POST['award_quantity'] as $key => $value){
          echo $_POST['award_qty'] = $value;
          // $_POST['vendor_id'] = $_POST['vendor_id['.$key.']'];
          // $_POST['unit_price'] = $_POST['unit_price['.$key.']'];
          // $_POST['total_amt'] = $_POST['total_amt['.$key.']'];
          // $_POST['item_id'] = $key;
          // $_POST['rfq_no'] =  $_SESSION[$unique];
          // $_POST['entry_by'] = $_SESSION['user']['id'];
          // $_POST['entry_at'] = date('Y-m-d H:i:s');
          //var_dump($_POST);
          //$Crud->insert();
       }
    }
  
  
  }




if(isset($_POST['back'])){
echo '<script>window.location.href="eprocurement_entry_entry.php"</script>';
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

.attachments .tr1 .td11{
	width:21%;
	padding-left:15px;
	text-align:left;
	font-weight:bold;
}
.attachments .tr1 .td22{
	width:79%;
	text-align:left;
}

.tr1 .td11{
	width:30%;
	text-align:right;
	font-weight:bold;
}
.tr1 .td22{
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

.tr1iangle {
    position: relative;
    float: left;
    width: 0;
    height: 0;
    border-style: solid;
}
.tr1iangle-right {
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

.attachments .tr1 .td11{
	width:21%;
	padding-left:15px;
	text-align:left;
	font-weight:bold;
}
.attachments .tr1 .td22{
	width:79%;
	text-align:left;
}

.tr1 .td11{
	width:30%;
	text-align:right;
	font-weight:bold;
}
.tr1 .td22{
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

.tr1iangle {
    position: relative;
    float: left;
    width: 0;
    height: 0;
    border-style: solid;
}
.tr1iangle-right {
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
	text-align:center;
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
	.sr .sd1,.sr .sd4{width:10%!important;}
	.sr .sd2,.sr .sd5{width:1%!important; text-align:center;}
	.sr .sd3,.sr .sd6{width:30%!important;}


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
</div>

<?php
  //php ini error show
  // ini_set('display_errors', 1);
  // ini_set('display_startup_errors', 1);
  // error_reporting(E_ALL);
?>


<form action="" method="post" id="item_response_form">
		<style>
		.auction table tr td{
		border:0px !important;
		}
		.auction table tbody tr{
		    border-left: 5px solid #28a745;
    		border-bottom: 8px solid #f0f0f0;
		}
		
		</style>
		<div class="pt-1 auction">
    <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
					
                    <tr class="bgc-info">
                        <th scope="col">Item Name</th>
                        <th>Quantity</th>
                        <th scope="col">Supplier</th>
						            <th scope="col">Ceiling Bid</th>
                        <th scope="col">Bid Unit Price</th>
                        <th scope="col">Bid Total Amount</th>
                        <th scope="col">Date & Time</th>
						            <th scope="col">Award Quantity</th>
                    </tr>
					
                    </thead>
                    <tbody class="tbody1">
          <form action="" method="post">
						<?php
                $vendor_id = $_GET['supplier_id'];
                $vendor_name = find_a_field('vendor','vendor_name','vendor_id = '.$vendor_id.'');
          $sql_each_rank = '
                SELECT 
                    rv.*, 
                    rid.expected_qty
           
                FROM 
                    rfq_vendor_item_response rv
                JOIN 
                    rfq_item_details rid 
                ON 
                    rv.rfq_no = rid.rfq_no AND rv.item_id = rid.item_id
                WHERE 
                    rv.rfq_no = "'.$_SESSION['rfq_no'].'" 
                AND 
                    rv.vendor_id = "'.$vendor_id.'"
                ORDER BY 
                    rv.item_id ASC, 
                    rv.entry_at ASC
            ';
              $qry_each_rank = db_query($sql_each_rank);
							while ($res = mysqli_fetch_object($qry_each_rank)) {
						?>
								<tr>
									<td  style=" border-left: 4px solid #298518; "><?php echo find_a_field('item_info','item_name','item_id = '.$res->item_id.''); ?></td>
									<td><?php 
                  // remove after .00
                  echo number_format($res->expected_qty,0);
                  ?></td>
                  <td><?php echo $vendor_name; ?></td>
									<td><?php echo $res->expected_qty;?></td> 
									<td><?php echo number_format($res->unit_price,2); ?> <span class="badge badge-success"><?php echo $res->price_rank; ?></span></td>
									<td><?php echo number_format($total_amt=$res->unit_price * $res->expected_qty,2);?></td>
                  <td><?=$res->entry_at?></td>
                  <td>
                    <input type="hidden" name="total_amt[<?php echo $res->item_id;?>]" value="<?php echo $total_amt; ?>" />
                    <input type="hidden" name="unit_price[<?php echo $res->item_id;?>]" value="<?php echo $res->unit_price; ?>">
                    <input type="hidden" name="vendor_id[<?php echo $res->item_id;?>]" value="<?php echo $res->vendor_id; ?>" />
                    <input type="number" name="award_quantity[<?php echo $res->item_id;?>]" class="form-control text-center" id="award_quantity" style="width: 100px" />
                  </td>
								</tr>
						<?php } //} } ?>
						
				 <tr>
				     <td colspan="6" style="text-align:right">
				         
				     </td>
				     <td><input type="submit" name="award_submit" class="btn btn-primary" value="Submit" /> </td>
				 </tr>
						
		  </form>
					</tbody>
                </table>
  			
 
   
  
  </div>
  
	</form>



</div>

</div>


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
	
	
	function event_confirmation() {
            showLoader();
            var xhr = new XMLHttpRequest();

            xhr.open('POST', 'mail_sender_ajax.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            var rfq_no = '';
           
            xhr.send('rfq_no=' + rfq_no);

            
            xhr.onload = function() {
                if (xhr.status == 200) {
				 hideLoader();
				 redirect_entry_page();
					var res = JSON.parse(xhr.responseText);
					
                    document.getElementById('MailMsg').innerText = res['msg'];
				//	ccmail();
					
                }
            };
        }
		
		 function showLoader() {
        document.getElementById('loader').style.display = 'flex';
    }

    function hideLoader() {
        document.getElementById('loader').style.display = 'none';
    }
	
	function redirect_entry_page(){
	 window.location.href="eprocurement_entry.php";
	}
	
function ccmail(){
var cc='';
getData2('team_mail_sender.php','egyyp',cc);
}
</script>
  
 


  
<?
require_once "../../../controllers/routing/layout.bottom.php";
?>

<?
   function attachment_url_show($trFrom){

    ob_start();
	
	?>
											  
											<?
												$sql = 'select * from rfq_documents_url_information where tr_from like "'.$trFrom.'" and rfq_no="'.$_SESSION['rfq_no'].'" and entry_by = "'.$_SESSION['user']['id'].'"';
												$qry = db_query($sql);
												while($res = mysqli_fetch_object($qry)){
												
											?>
											<?
											if($res->attachment_text == '' || $res->attachment_text=='NULL')
											{
											?>
											<div class="col-sm-8 col-md-8 col-lg-8 pb-1">
													<div class="rounded p-2" style="word-break: break-all; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
													<a href="<?=$res->attachment_url?>" target="_blank" rel="noopener"><em class="fa-solid fa-envelope-open-text fa-xl" style="color: #d6960a;"></em>
														<span><?=$res->attachment_url?></span></a>

													</div>
												</div>
											<? } ?>
											<? } ?>
	 <?																			
		$data = ob_get_clean();	
		echo $data;	
							
  }
  
  ?>	

<?
  function attachment_text_show($trFrom){

    ob_start();
	
	?>
											  
											<?
												$sql = 'select * from rfq_documents_url_information where tr_from like "'.$trFrom.'" and rfq_no="'.$_SESSION['rfq_no'].'" and entry_by = "'.$_SESSION['user']['id'].'"';
												$qry = db_query($sql);
												while($res = mysqli_fetch_object($qry)){
												
											?>
																						<?
											if($res->attachment_url == '' || $res->attachment_url=='NULL')
											{
											?>
												<div class="col-sm-12 col-md-12 col-lg-12 pb-1">
													<div class="rounded p-2" style=" word-break: break-all; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; ">
														<span><em class="fa-solid fa-envelope-open-text fa-xl" style="color: #d6960a;"></em>
															<span><?=$res->attachment_text?></span></span>

													</div>
												</div>
											<? } ?>
											<? } ?>
	 <?																			
		$data = ob_get_clean();	
		echo $data;	
							
  }
  
  ?>