
<?php
// Delete the entire zip folder
$zipFolder = "../../../../public/uploads/zip/";

// Check if the zip folder exists
if (is_dir($zipFolder)) {
    // Open the directory
    if ($handle = opendir($zipFolder)) {
        // Iterate over the directory
        while (($file = readdir($handle)) !== false) {
            // Skip . and ..
            if ($file != "." && $file != "..") {
                // Delete the file or subdirectory
                if (is_dir($zipFolder . $file)) {
                    // Recursively delete subdirectories
                    deleteDirectory($zipFolder . $file);
                } else {
                    // Delete files
                    unlink($zipFolder . $file);
                }
            }
        }
        // Close the directory handle
        closedir($handle);
        
        // Delete the empty directory
        if (is_dir($zipFolder)) {
            rmdir($zipFolder);
            // echo 'Zip folder deleted successfully.';
        }
    } else {
        // echo 'Failed to open directory.';
    }
} else {
    // echo 'Zip folder does not exist.';
}

// Recursive function to delete subdirectories and files
function deleteDirectory($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir . "/" . $object)) {
                    deleteDirectory($dir . "/" . $object);
                } else {
                    unlink($dir . "/" . $object);
                }
            }
        }
        rmdir($dir);
    }
}
?>
<?php
require_once "../../../controllers/routing/layout.top.php";
$current_page = "Events";
$title='Event Management';
do_calander("#f_date");
do_calander("#t_date");
$unique='rfq_no';
$table_master='rfq_master';
$table_details='purchase_invoice';
if($_GET['clear']>0){
unset($_SESSION[$unique]);
unset($_SESSION['master_status']);
unset($_SESSION['rfq_version']);
unset($_SESSION['user_role']);
echo '<script>window.location.href="eprocurement_entry_entry.php?tab1"</script>';
}

$unsetSql = 'select * from form_elements where 1';
$usetQry = db_query($unsetSql);
while($elementData=mysqli_fetch_object($usetQry)){
	unset($_SESSION[$elementData->element]);
}

if($_POST['event_end_remarks']!='' && $_SESSION[$unique]>0){
$rfq->eventEndDate.' '.$rfq->eventEndTime;
$eventEndDate = date('Y-m-d');
$eventEndTime = date('H:i:s');

$up = 'update rfq_master set eventEndDate="'.$eventEndDate.'", eventEndTime="'.$eventEndTime.'", eventEndAt="'.date('Y-m-d H:i:s').'",event_end_remarks="'.$_POST['event_end_remarks'].'" where rfq_no="'.$_SESSION[$unique].'"';
db_query($up);
echo '<span style="color:green; font-size:20px;">Event End Successfully</span>';

///////////
$now = date('Y-m-d H:i:s');
$_POST['rfq_no'] = $_SESSION[$unique];
$_POST['field_name'] = 'Status';
$_POST['field_value'] = 'Event End. End comment: "'.$_POST['event_end_remarks'].'" ';
$_POST['entry_at'] = $now;
$_POST['entry_by'] = $_SESSION['user']['id'];

$Crud   = new Crud('rfq_logs');
$Crud->insert();
/////////////


}

if(isset($_POST['event_edit']) && $_SESSION[$unique]>0){
$up = 'update rfq_master set status="MANUAL" where rfq_no="'.$_SESSION[$unique].'"';
db_query($up);
$_SESSION['master_status']='MANUAL';

///////////
$now = date('Y-m-d H:i:s');
$_POST['rfq_no'] = $_SESSION[$unique];
$_POST['field_name'] = 'Status';
$_POST['field_value'] = 'Edit Mode ON';
$_POST['entry_at'] = $now;
$_POST['entry_by'] = $_SESSION['user']['id'];

$Crud   = new Crud('rfq_logs');
$Crud->insert();
/////////////

echo '<span style="color:green; font-size:20px;">Event Opened For Edit</span>';
}

if($_GET['old_rfq_no']!=''){
$_GET['rfq_no'] = url_decode($_GET['old_rfq_no']);
$user_check = find_a_field('rfq_evaluation_team','action','user_id="'.$_SESSION['user']['id'].'" and rfq_no="'.$_GET['rfq_no'].'"');
if($user_check==''){
echo '<script>window.close()</script>';
}else{
$_SESSION[$unique] = $_GET['rfq_no'];

if($user_check=='Watcher' || $user_check=='Evaluator'){
$_SESSION['master_status'] = 'NO';
}else{
$_SESSION['user_role'] = $user_check;
$_SESSION['master_status'] = find_a_field('rfq_master','status','rfq_no="'.$_SESSION[$unique].'"');
}

$_SESSION['rfq_version'] = find_a_field('rfq_master','rfq_version','rfq_no="'.$_SESSION[$unique].'"');
echo '<script>window.location.href="eprocurement_entry_entry.php?tab1"</script>';
}
}

if($_SESSION[$unique]<1 && $_GET['old_rfq_no']==''){
$Crud = new Crud($table_master);
$_POST['rfq_date'] = date('Y-m-d');
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$_POST['eventtimezone'] = 'Asia/Dhaka UTC 06:00';
$_POST['currency'] = 'BDT';

$_POST['multiple_response'] = 'yes';
$_POST['when_unseal'] = 'manually';

$_POST['manual_unseal'] = 'SEALED';

$_POST['planned_savings_currency'] = 'BDT';
$_POST['cost_avoidance_currency'] = 'BDT';
$_POST['project_amount_currency'] = 'BDT';
$_POST['group_for'] = 1;

$_POST['eventStartDate'] = date('Y-m-d');
$_POST['eventStartTime'] = date('H:s');
$_POST['eventStartAt'] = $_POST['eventStartDate'].' '.$_POST['eventStartTime'];

$_POST['eventEndDate'] =  date('Y-m-d', strtotime('+7 day'));
$_POST['eventEndTime'] = date('H:s');
$_POST['eventEndAt'] = $_POST['eventEndDate'].' '.$_POST['eventEndTime'];

$_POST['rfx_stage'] = $_GET['rfx_stage'];
$_POST['mail_template'] = find_a_field('mail_template_setup','mail_template','id=1');
$max_rfq_no = find_a_field('rfq_master','max(rfq_no)+1','1');
$_POST['rfq_version'] = $max_rfq_no.'-Round.0';
$_SESSION[$unique] = $Crud->insert();







$Crud = new Crud('rfq_evaluation_team');
$_POST['rfq_no'] = $_SESSION[$unique];
$_POST['user_id'] = $_SESSION['user']['id'];
$_POST['action'] = 'Owner';
$_SESSION['user_role'] = 'Owner';
$_POST['is_master'] = 'Yes';
$Crud->insert();






//automated task
$Crud_TASK = new Crud('timeline_Tasks');
$sql_task_automation="SELECT * FROM default_timeline_Tasks";
$sql_task_automation_query= db_query($sql_task_automation);
while($automated_task = mysqli_fetch_object($sql_task_automation_query)){

  $sql_rp_team = '';
  
  if($automated_task->responsible=="supply chain"){
    $sql_rp_team = 'select a.id,u.fname,a.action,a.is_master,u.email from rfq_evaluation_team a, user_activity_management u where a.user_id=u.user_id and a.rfq_no="'.$_SESSION['rfq_no'].'" and a.action="Owner" limit 1';
    }elseif($automated_task->responsible=="business user"){
     $sql_rp_team = 'select a.id,u.fname,a.action,a.is_master,u.email from rfq_evaluation_team a, user_activity_management u where a.user_id=u.user_id and a.rfq_no="'.$_SESSION['rfq_no'].'" and a.action="Evaluator" limit 1';

    }else{
     $sql_rp_team = 'select a.id,u.fname,a.action,a.is_master,u.email from rfq_evaluation_team a, user_activity_management u where a.user_id=u.user_id and a.rfq_no="'.$_SESSION['rfq_no'].'" and a.action="uuuuuuuuuuuuuuuuuuuuuuuuu" limit 1';

    }



  $qry_rp_team = db_query($sql_rp_team);
  $rp_team_member=mysqli_fetch_object($qry_rp_team);



  $_POST['rfq_no'] = $_SESSION[$unique];
  $_POST['sequence'] = $automated_task->sequence;
  $_POST['task'] = $automated_task->task;
  $_POST['responsible'] = $automated_task->responsible;
  $_POST['taskOwner'] = $rp_team_member->fname;
  $_POST['startDate'] = date('Y-m-d');
  $_POST['endDate'] = date('Y-m-d', strtotime('+7 day'));
  $Crud_TASK->insert();

}
//automated task end






$_SESSION['rfq_version'] = $_POST['rfq_version'];
$_SESSION['master_status'] = 'MANUAL';

///
$Crud   = new Crud('rfq_group_for');

$_POST['rfq_no'] = $_SESSION[$unique];
$_POST['group_for'] = 1;
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud->insert();
///








unset($_POST);
}

$total_vendor_response = find_a_field('rfq_vendor_response','count(id)','rfq_no="'.$_SESSION[$unique].'"');
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
 $_POST['unseal_status'] = 'UNSEALED';
 $Crud->update($unique);
 $type=1;
 
 ///////////
$now = date('Y-m-d H:i:s');
$_POST['rfq_no'] = $_SESSION[$unique];
$_POST['field_name'] = 'Status';
$_POST['field_value'] = 'Unseal Event';
$_POST['entry_at'] = $now;
$_POST['entry_by'] = $_SESSION['user']['id'];

$Crud   = new Crud('rfq_logs');
$Crud->insert();
/////////////
 
}


if($_POST['event_complete_remarks'] !=''){
 $Crud   = new Crud($table_master);
 unset($_POST);
 $_POST[$unique] = $_SESSION[$unique];
 $_POST['status'] = 'COMPLETE';
 $Crud->update($unique);
 $type=1;
 
 ///////////
$now = date('Y-m-d H:i:s');
$_POST['rfq_no'] = $_SESSION[$unique];
$_POST['field_name'] = 'Status';
$_POST['field_value'] = 'Complete Event';
$_POST['entry_at'] = $now;
$_POST['entry_by'] = $_SESSION['user']['id'];

$Crud   = new Crud('rfq_logs');
$Crud->insert();
/////////////
 
}

////////////////// Reward \\\\\\\\\\\\\\\\\\


if($_POST['award'] !=''){
 $award_update = 'update rfq_vendor_details set award_per = "'.$_POST['award_per'].'" , status = "SELECTED" where rfq_no = "'.$_SESSION[$unique].'" and vendor_id = "'.$_POST['vendor_id'].'"  ';
 db_query($award_update);
 
 ///////////
$now = date('Y-m-d H:i:s');
$_POST['rfq_no'] = $_SESSION[$unique];
$_POST['field_name'] = 'Status';
$_POST['field_value'] = 'Vendor awarded';
$_POST['entry_at'] = $now;
$_POST['entry_by'] = $_SESSION['user']['id'];

$Crud   = new Crud('rfq_logs');
$Crud->insert();
/////////////
 
}

//////////////////Reward end \\\\\\\\\\\\\\\

if($_POST['event_cancel_remarks']!=''){
 
 $Crud   = new Crud($table_master);
 unset($_POST);
 $_POST[$unique] = $_SESSION[$unique];
 $_POST['status'] = 'CANCELED';
 $Crud->update($unique);
 $type=1;
 
 ///////////
$now = date('Y-m-d H:i:s');
$_POST['rfq_no'] = $_SESSION[$unique];
$_POST['field_name'] = 'Status';
$_POST['field_value'] = 'Event Cancelled. Remarks : '.$_POST['event_cancel_remarks'];
$_POST['entry_at'] = $now;
$_POST['entry_by'] = $_SESSION['user']['id'];

$Crud   = new Crud('rfq_logs');
$Crud->insert();
/////////////
 
}

if(isset($_POST['update_mail_template'])){
 $Crud   = new Crud($table_master);
 $mail_template = $_POST['mail_template'];
 unset($_POST);
 $_POST[$unique] = $_SESSION[$unique];
 $_POST['mail_template'] = $mail_template;
 $Crud->update($unique);
 $type=1;
 
 ///////////
$now = date('Y-m-d H:i:s');
$_POST['rfq_no'] = $_SESSION[$unique];
$_POST['field_name'] = 'Mail Template';
$_POST['field_value'] = 'Mail template updated';
$_POST['entry_at'] = $now;
$_POST['entry_by'] = $_SESSION['user']['id'];

$Crud   = new Crud('rfq_logs');
$Crud->insert();
/////////////
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
<style>
.ep-clock-bg{
	background-color:#f2f2f2 !important;
	border-radius: 15px;
	box-shadow: inset 4px 4px 5px rgba(255,255,255,0.3), 
		  inset -4px -4px 5px rgba(0,0,0,0.1), 10px 40px 40px rgba(0,0,0,0.1);
		      width: 295px;
			      float: right;
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
   
    height: 55px;
    width: 245px;
    border-radius: 10px;
    align-items: center;
    background-color: #00bcd4;
    color: #fff;
	text-align: center;
	 
	 box-shadow: -12px -10px 10px rgba(255,255,255,0.2), 15px 15px 15px rgba(0,0,0,0.1), inset -10px -10px 10px rgba(255,255,255,0.2), inset 15px 15px 15px rgba(0,0,0,0.1);
}

.countdown-item {
  margin: 0 10px;
      padding-top: 5px;
}

.countdown-label {
  font-family: 'Orbitron', sans-serif !important;
  font-size: 12px !important;
  color: #fff;
}

#days,
#hours,
#minutes {
  font-size: 25px !important;
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
<? include_once 'ep_menu.php'; ?>
    <script type="text/javascript" src="../../../../public/assets/js/bootstrap.min.js"></script>	
	<script type="text/javascript" src="../../../../public/assets/js/jquery-3.4.1.min.js"></script>
	
<? $rfq_data = find_all_field('rfq_master','*','rfq_no="'.$_SESSION['rfq_no'].'"');

   
?>

<div class="container mt-1 p-0 ">
<? if($_SESSION['roundingMessage'] != ''){ echo $_SESSION['roundingMessage']; unset($_SESSION['roundingMessage']); }?>
<div class="row p-0 pb-2">
	<div class="col-sm-6 col-lg-6 col-md-6 col-6">
	<h1 class="container m-0" style=" font-size: 25px !important; "><?=$event_name?> #<?=$_SESSION['rfq_version']?></h1>
					
	</div>
	<div class="col-sm-6 col-lg-6 col-md-6 col-6 d-flex justify-content-center align-items-center">
	<form method="post" id="action_form" class="row p-0 col-sm-12 d-flex justify-content-end align-items-center">
	<!-- Button trigger modal Start-->
	<? $eventEndAt = $rfq_data->eventEndDate.' '.$rfq_data->eventEndTime;
	
		$eventEndAtInt = strtotime($eventEndAt);
		$currentDateTime = strtotime(date('Y-m-d H:i:s'));
		
	 ?>
	
	<? if($_SESSION['user_role']=='Owner'){?>
	
		<? if($rfq_data->status == 'MANUAL'){?>
					<button type="button" name="event_cancel" onclick="cancel_event_confirmation()" id="event_cancel" class="btn1 btn1-bg-cancel" style="width:20% !important;">RFQ Cancel</button>
					
					<? }elseif($rfq_data->status == 'COMPLETE'){ ?>
					<a href="rounding.php?rfq_no=<?=$rfq_data->rfq_no?>" rel="noopener">
					<button type="button" name="add_event_team" class="btn1 btn1-bg-hrm" style="width:100% !important; float:right;">Create New Round</button>
					</a>
		            <? } elseif($rfq_data->status == 'CANCELED'){ ?>
		
					<? } elseif($rfq_data->status == 'UNSEALED' || $rfq_data->unseal_status == 'UNSEALED'){ ?>
		
					<a href="rounding.php?rfq_no=<?=$rfq_data->rfq_no?>" rel="noopener">
							<button type="button" name="add_event_team" class="btn1 btn1-bg-hrm" style="width:100% !important; float:right;">Create New Round</button>
					</a>
					
					<button type="button" name="event_completed" id="event_completed" value="" class="btn1 btn1-bg-update" onclick="event_complete()" style="width:20% !important;">Event Completed</button>
					
					<? } elseif($eventEndAtInt<=$currentDateTime){ ?>
						<button type="submit" name="event_edit" class="btn1 btn1-bg-help" style="width:20% !important;">Reopen</button>
		            <? } elseif($rfq_data->status == 'CHECKED'){?>
					<button type="button" name="event_end" class="btn1 btn1-bg-cancel"  onclick="write_remarks()" style="width:20% !important;">End</button>
					<button type="submit" name="event_edit" class="btn1 btn1-bg-update" style="width:20% !important;">Edit</button>
					<button type="button" name="add_event_team" class="btn1 btn1-bg-warning" style="width:20% !important;">Hold</button>
					<!--<button type="submit" name="event_end" class="btn btn-primary"  data-dismiss="modal">End</button>-->
					<button type="button" name="event_cancel" id="event_cancel" onclick="cancel_event_confirmation()" class="btn1 btn1-bg-cancel" style="width:20% !important;">RFQ Cancel</button>
					
		<? }} ?>
	<!-- Button trigger modal end-->
	<script>
	 function write_remarks(){
	  var userText = prompt("Why Doing This!");
	  if(userText !== null){
	  document.getElementById('event_end_remarks').value = userText;
	  document.getElementById('action_form').submit();
	  
	  }else{
	  return false;
	  }
	 }
	</script>
	
	 <script>
        function event_complete() {
            var userResponse = confirm("Are you sure you want to proceed?");
            if (userResponse) {
                // User clicked OK
                document.getElementById('event_complete_remarks').value = 'event_completed';
				document.getElementById('action_form').submit();
            } else {
                // User clicked Cancel
					  return false;
            }
			
        }
		
		 function event_cancel(){
    
            var userResponse = confirm("Are you sure you want to proceed?");
            if (userResponse) {
                // User clicked OK
                document.getElementById('event_cancel_remarks').value = 'event cancelled';
				document.getElementById('action_form').submit();
            } else {
                // User clicked Cancel
					  return false;
            }
			
        }
      function cancel_event_confirmation(){
        var userInput = prompt("Are you sure you want to remove this section? If yes, please provide a reason:");
    if (userInput !== null && userInput.trim() !== "") {
      console.log(userInput.trim());
        document.getElementById('event_cancel_remarks').value = userInput.trim();
        document.getElementById('action_form').submit();

    }
    else if(userInput.trim() == ""){
        alert("please provide a reason");
      }
      }
    </script>
	
	<input type="hidden" name="event_complete_remarks" id="event_complete_remarks" value="" />
	<input type="hidden" name="event_cancel_remarks" id="event_cancel_remarks" value="" />
	<input type="hidden" name="event_end_remarks" id="event_end_remarks" value="" />
	</form>
	</div>
	</div>
	
<? if($_SESSION['master_status']=='CHECKED'){?>
<div class="row p-0 pb-2">
	<div class="col-sm-8 col-lg-8 col-md-8 col-8"></div>
	<div class="col-sm-4 col-lg-4 col-md-4 col-4" id="fixed">
	<div class="d-flex justify-content-center align-items-center ep-clock-bg  p-2">
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
<? } ?>






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
 <?
   if($_SESSION['user_role']=='Owner' || $_SESSION['user']['id']==$entry_by){
 ?>
  <li class="nav-item">
    <a class="nav-link" id="evaluations-tab" data-toggle="tab" href="#tab5" role="tab" aria-controls="evaluations" aria-selected="false" onclick="settingF('tab5');">Evaluations</a>
  </li>
   <li class="nav-item">
    <a class="nav-link" id="suppliers-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="suppliers" aria-selected="false" onclick="settingF('tab4');">Suppliers</a>
  </li>
  
  <?php
  }

   if($total_vendor_response>0){
  ?>
   <li class="nav-item">
    <a class="nav-link" id="responses-tab" data-toggle="tab" href="#tab6" role="tab" aria-controls="responses" aria-selected="false" onclick="settingF('tab6');">Responses</a>
  </li>
  <? }?>
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


function notify_supplier_individual(vendor_email) {
            showLoader();
            $.ajax({
            url: 'individual_mail_sender.php',
            type: 'POST',
            data: JSON.stringify({ vendor_email: vendor_email}),
            contentType: 'application/json',

    success: function (responseData) {
   
      hideLoader()
      var res = JSON.parse(responseData);
            document.getElementById('MailMsg').innerText = res['msg'];

            // Remove the message after 3 seconds
            setTimeout(function() {
                document.getElementById('MailMsg').innerText = '';
            }, 3000);



  
    

		

    },
    error: function (xhr, status, error) {
        console.error('Error uploading image:', error);
        $('#response').text('Error uploading image. Please try again.');
    },
    cache: false,
    contentType: false,
    processData: false
});
        }

    function showLoader() {
    document.getElementById('loader').style.display = 'flex';
}

    function hideLoader() {
        document.getElementById('loader').style.display = 'none';
    }

// function notify_supplier_individual(vendor_email){

//   var cc='';
//   getData2('individual_mail_sender.php','testmail',vendor_email);
// }

function required_field_check_old(){
  <?
    $event_starttime = find_a_field('rfq_master','eventStartAt','rfq_no="'.$_SESSION['rfq_no'].'"');
    $first_notification_time = find_a_field('notification_setup_information','notification_start_date','rfq_no="'.$_SESSION['rfq_no'].'"');
  ?>
	var event_name = document.getElementById("event_name").value;
	var commodity = document.getElementById("commodity").value;
	
	var coupa_commodity = document.getElementById("coupa_commodity").value;
	var sourcing_type = document.getElementById("sourcing_type").value;
	var rfx_referance = document.getElementById("rfx_referance").value;
	var referance_form = document.getElementById("referance_form").value;
	var project_amount = document.getElementById("project_amount").value;
	var content_group = document.getElementById("content_group").value;
	var supplier_count = document.getElementById("supplier_count").value*1;



  var notification_start_date_element = document.getElementById("notification_start_date");
  var notification_start_date = notification_start_date_element ? notification_start_date_element.value : null;
  var immediate_event_shoot = document.getElementById("immediate_event_shoot").checked;
  var eventStartDate = document.getElementById('eventStartDate').value;
  var eventStartTime = document.getElementById('eventStartTime').value;
  var eventStartDateTime = new Date(eventStartDate + 'T' + eventStartTime);
  var sendNotification = document.querySelector('input[name="want_to_send_notification"]:checked').value;

  
if(sendNotification=='Yes'){
  if (immediate_event_shoot) {
        if (notification_start_date) {
          var notificationDate = new Date(notification_start_date);
            var currentDate = new Date();
            if (notificationDate < currentDate) {
                alert('Notification time cannot be smaller than the current time');
                return; // Exit the function to prevent further checks
            }
        } else {
            alert('Notification start date is required');
            return; // Exit the function to prevent further checks
        }
    }else{
      if (notification_start_date) {
        var notificationDate = new Date(notification_start_date);
          if (notificationDate < eventStartDateTime) {
            alert('Notification time cannot be smaller than the event start time');
          }
    } else {
            alert('Notification start date is required');
            return; // Exit the function to prevent further checks
        }
    }
}

	


	if(event_name ==''){
		alert('Event name is required');
	}else if(commodity==''){
		alert('Commodity is required');
	}else if(coupa_commodity==''){
		alert('Sub Commodity is required');
	}else if(sourcing_type==''){
		alert('Sourcing type is required');
	}else if(rfx_referance==''){
		alert('Rfx referance is required');
	}else if(referance_form==''){
		alert('SRF case number is required');
	}else if(project_amount==''){
		alert('Project amount is required');
	}else if(content_group==''){
		alert('Visibility is required');
	}else if(supplier_count==0){
		alert('Please add supplier to continue');
	}else{
		location.replace('rfq_preview.php');
	}
	
}

/////////////////////////////
function termsConditionCheck(callback) {
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'terms_condition_check_ajax.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.send('type=commodity');
  xhr.onload = function() {
    if (xhr.status == 200) {
      var res = JSON.parse(xhr.responseText);
      console.log(res);
      callback(res); // Pass the response to the callback
    }
  };
}
  
/*function test() {
  termsConditionCheck(function(termsCondition) {
    if (termsCondition === 0) { // Check if the response is 0
      alert('The response is 0');
    } else {
      alert(JSON.stringify(termsCondition)); // Convert the object to a string for alert
    }
  });
}*/

function required_field_check(){

	termsConditionCheck(function(termsCondition) {
    if (termsCondition === 0) { // Check if the response is 0
      alert('Please add terms and conditions');
	  return;
    } 
  	
	
  <?
    $event_starttime = find_a_field('rfq_master','eventStartAt','rfq_no="'.$_SESSION['rfq_no'].'"');
    $first_notification_time = find_a_field('notification_setup_information','notification_start_date','rfq_no="'.$_SESSION['rfq_no'].'"');
  ?>
	var event_name = document.getElementById("event_name").value;
	var commodity = document.getElementById("commodity").value;
	
	var coupa_commodity = document.getElementById("coupa_commodity").value;
	var sourcing_type = document.getElementById("sourcing_type").value;
	var rfx_referance = document.getElementById("rfx_referance").value;
	var referance_form = document.getElementById("referance_form").value;
	var project_amount = document.getElementById("project_amount").value;
	var content_group = document.getElementById("content_group").value;
	var supplier_count = document.getElementById("supplier_count").value*1;



  var notification_start_date_element = document.getElementById("notification_start_date");
  var notification_start_date = notification_start_date_element ? notification_start_date_element.value : null;
  var immediate_event_shoot = document.getElementById("immediate_event_shoot").checked;
  var eventStartDate = document.getElementById('eventStartDate').value;
  var eventStartTime = document.getElementById('eventStartTime').value;
  var eventStartDateTime = new Date(eventStartDate + 'T' + eventStartTime);
  var sendNotification = document.querySelector('input[name="want_to_send_notification"]:checked').value;

  
if(sendNotification=='Yes'){
  if (immediate_event_shoot) {
        if (notification_start_date) {
          var notificationDate = new Date(notification_start_date);
            var currentDate = new Date();
            if (notificationDate < currentDate) {
                alert('Notification time cannot be smaller than the current time');
                return; // Exit the function to prevent further checks
            }
        } else {
            alert('Notification start date is required');
            return; // Exit the function to prevent further checks
        }
    }else{
      if (notification_start_date) {
        var notificationDate = new Date(notification_start_date);
          if (notificationDate < eventStartDateTime) {
            alert('Notification time cannot be smaller than the event start time');
          }
    } else {
            alert('Notification start date is required');
            return; // Exit the function to prevent further checks
        }
    }
}

	


	if(event_name ==''){
		alert('Event name is required');
	}else if(commodity==''){
		alert('Commodity is required');
	}else if(coupa_commodity==''){
		alert('Sub Commodity is required');
	}else if(sourcing_type==''){
		alert('Sourcing type is required');
	}else if(rfx_referance==''){
		alert('Rfx referance is required');
	}else if(referance_form==''){
		alert('SRF case number is required');
	}else if(project_amount==''){
		alert('Project amount is required');
	}else if(content_group==''){
		alert('Visibility is required');
	}else if(supplier_count==0){
		alert('Please add supplier to continue');
	}else{
		location.replace('rfq_preview.php');
	}
	
	});
	
}


////////////////////////////  
function master_data(thisField,thisValue){
  var encodedEventName = encodeURIComponent(thisValue);
  getData2('master_ajax.php','ep',thisField,encodedEventName);	 

}
function master_data_event_timeline(thisField,thisValue){
  var start_date =document.getElementById('eventStartDate').value;
  var end_date =document.getElementById('eventEndDate').value;
  const currentDate = new Date();
  const currentDateString = currentDate.toISOString().split('T')[0];
  const currentTimeString = currentDate.toTimeString().split(' ')[0].substring(0, 5);
  console.log(thisValue,currentDateString);

  if(thisField=='eventStartDate'){
    if ( thisValue>=currentDateString) {
      getData2('master_ajax.php','ep',thisField,thisValue);	
  
  }else{
    alert("You can't select previous date");
    document.getElementById('eventStartDate').value='';
  }

  }

  if(thisField=='eventStartTime'){
    
    if (start_date>currentDateString) {
      getData2('master_ajax.php','ep',thisField,thisValue);	
  }else if(start_date==currentDateString){
    if(thisValue>=currentTimeString){
      getData2('master_ajax.php','ep',thisField,thisValue);	
    }else{
      alert("You can't select previous time");
      document.getElementById('eventStartTime').value='';
    }
  }

  }
  if(thisField=='eventEndDate'){
    if ( thisValue>=currentDateString) {
      getData2('master_ajax.php','ep',thisField,thisValue);	
  
  }else{
    alert("You can't select previous date");
    document.getElementById('eventEndDate').value='';
  }

  }

  if(thisField=='eventEndTime'){
    if (end_date>currentDateString) {
      getData2('master_ajax.php','ep',thisField,thisValue);	
  }else if(end_date==currentDateString){
    if(thisValue>=currentTimeString){
      getData2('master_ajax.php','ep',thisField,thisValue);	
    }else{
      alert("You can't select previous time");
      document.getElementById('eventEndTime').value='';
    }
  }

  }



// 

}



function subComodity(rfq_no,commodity) {
	
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'sub_comodity_ajax.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.send('commodity=' + rfq_no + '&type=commodity');
  xhr.onload = function() {
                if (xhr.status == 200) {
					var res = JSON.parse(xhr.responseText);
					console.log(res);
                   document.getElementById('comidityList').innerHTML = res['comidityList'];
                }
            };
  
}


function event_team_insert(rfq_no,user_id,level) {
	var myArray = user_id.split("::");
	 user_id = myArray[0];
   var event_team_user_id=document.getElementById('event_team_user_id').value;
   var event_team_level = document.getElementById('event_team_level').value;
	if(event_team_user_id != '' && event_team_level!='' ){
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'event_team_ajax.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.send('user_id=' + user_id + '&level=' + level);
  xhr.onload = function() {
                if (xhr.status == 200) {
					var res = JSON.parse(xhr.responseText);
                   document.getElementById('team').innerHTML = res['teamList'];
				   document.getElementById('eventTeamAssign').innerHTML = res['teamListAssign']; 
				   document.getElementById('event_team_user_id').value = '';
           document.getElementById('event_team_user_id').value = '';
            document.getElementById('event_team_level').value = '';

                }
            };

          }else{
            
            if(event_team_user_id == ''){
              alert("Team Member is Empty")
            }
            else if(event_team_level == ''){
              alert("Team Member level is Empty")
            }
          }
  
}

function event_team_cancel(rfq_no,id){

var xhr = new XMLHttpRequest();
  xhr.open('POST', 'event_team_cancel_ajax.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.send('team_id=' + id);
  xhr.onload = function() {
                if (xhr.status == 200) {
					var res = JSON.parse(xhr.responseText);
                   document.getElementById('team').innerHTML = res['teamList'];
				   document.getElementById('eventTeamAssign').innerHTML = res['teamListAssign'];
					
                }
            };
}


function event_details_att_cancel(section,id,type){

getData2('event_details_att_cancel_ajax.php',type,section,id);
}
function event_details_att_cancel_individual(section,id,type,doc_id){
  var concatanatedids=id+'#'+doc_id;
getData2('event_details_att_cancel_individual_ajax.php',type,section,concatanatedids);
}

function event_details_att_edit_individual(section,type,doc_id,doc_terms,doc_names){
  
  document.getElementById('gsection_name_edit').value=doc_names;
  document.getElementById('gterms_edit').value=doc_terms;
  document.getElementById('doc_id_individual').value=doc_id;
  document.getElementById('gsection_type').value=section;
  document.getElementById('details_att_show_div').value=type;

//   var concatanatedids=id+'#'+doc_id;
// getData2('event_details_att_cancel_individual_ajax.php',type,section,concatanatedids);
}



function event_item_insert(){
var rfq_no = document.getElementById('new_rfq_no').value;
var item_info = document.getElementById('item_desc').value;
var unit_name = document.getElementById('unit').value;
var qty = document.getElementById('expected_qty').value;
var price = document.getElementById('price').value;
var currency = document.getElementById('base_currency').value;
var need_by = document.getElementById('need_by').value;

var second_part = item_info +"|"+ unit_name +"|"+ qty +"|"+ price +"|"+ currency +"|"+need_by;

	if(item_info != '' && qty >0 ){
		getData2('event_item_ajax.php','item_details',rfq_no,second_part);
  
    document.getElementById('item_desc').value='';
    document.getElementById('unit').value='';
    document.getElementById('expected_qty').value='';
    document.getElementById('price').value='0';
    document.getElementById('base_currency').value='';
    document.getElementById('need_by').value='';
	}else{
		alert('Item description and qty is required');
	}
}

function event_item_cancel(rfq_no,id){
getData2('event_item_cancel_ajax.php','item_details',rfq_no,id);
}
function event_item_cancel_individual(rfq_no,id){
getData2('event_item_cancel_individual_ajax.php','item_details',rfq_no,id);
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
        // var files = $('#att_file_'+section_type)[0].files;
        var files = [];
        var files2 = $('#att_file_'+section_type)[0].files;
        for (var i = 0; i < files2.length; i++) {
            formData.append('details_doc[]', files2[i]);
        }
        formData.getAll('details_doc[]').forEach(function (file, index) {
          console.log(file.name);
          if (file.size <= 10 * 1024 * 1024) { // Check if file size is less than or equal to 10 MB

            files.push({
              name: file.name,
              type: file.type,
              data: null // Placeholder for the file data
            });
          } else {

          }
          });
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
      return readFileAsDataURL(formData.getAll('details_doc[]')[index]);
  });

  // Once all files are converted to Base64, continue
  Promise.all(promises).then(function(base64Strings) {
      base64Strings.forEach(function(base64String, index) {
          files[index].data = base64String.split(',')[1]; // Remove the 'data:image/jpeg;base64,' part
      });

 
      $.ajax({
          url: 'multiple_att_upload_ajax.php',
          type: 'POST',
          // data: JSON.stringify({ files: files }),
          data: JSON.stringify({ files: files, section_name: section_name, section_terms: terms, att_response: att_response, is_required: is_required,section_type:section_type }),
          contentType: 'application/json',
          success: function (response) {
            
            console.log(response);
              var res = JSON.parse(response);
              $('#progress').html('Upload successful');
              get_doc_section(section_type,type);
              $('#section_name').val('');
              $('#terms').val('');
              $('#terms').val('');
              $('#att_file').val('');
              
              $('#att_file_commercial').val('');
              $('#att_file_technical').val('');
              $('#att_file_general').val('');
              $('#uploadButton').hide();
              $('#uploadButton1').hide();
              $('#uploadButton2').hide();
              
              
              $('#att_response').prop('checked', false);
              $('#is_required').prop('checked', false);
              $('#progress').html('');
              hideLoader();
          },
          error: function (xhr, status, error) {
              console.error('Error uploading image:', error);
              $('#response').text('Error uploading image. Please try again.');
          }
      });
  }).catch(function(error) {
      console.error('Error converting files to Base64:', error);
  });


		// formData.append('section_name',section_name);
		// formData.append('section_terms',terms);
		// formData.append('att_response',att_response);
		// formData.append('is_required',is_required);
		// formData.append('section_type',section_type);
        
    //     $.ajax({
    //         url: 'multiple_att_upload_ajax.php',
    //         type: 'POST',
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         xhr: function() {
    //             var xhr = new window.XMLHttpRequest();
                
                
    //             xhr.upload.addEventListener('progress', function(evt) {
    //                 if (evt.lengthComputable) {
    //                     var percentComplete = evt.loaded / evt.total * 100;
    //                     $('#progress').text('Uploading: ' + percentComplete.toFixed(2) + '%. Wait');
    //                 }
    //             }, false);

    //             return xhr;
    //         },	
			
    //         success: function(response){
    //         console.log(response);
		// 	 var res = JSON.parse(response);
		// 	 $('#progress').html('Upload successful');
		// 	 get_doc_section(section_type,type);
		// 	 $('#section_name').val('');
		// 	 $('#terms').val('');
		// 	 $('#terms').val('');
		// 	 $('#att_file').val('');
			 
		// 	 $('#att_file_commercial').val('');
		// 	 $('#att_file_technical').val('');
		// 	 $('#att_file_general').val('');
		// 	 $('#uploadButton').hide();
		// 	 $('#uploadButton1').hide();
		// 	 $('#uploadButton2').hide();
			 
			 
		// 	 $('#att_response').prop('checked', false);
		// 	 $('#is_required').prop('checked', false);
		// 	 $('#progress').html('');
		// 	 hideLoader();
		// 	 },
    //         error: function(xhr, status, error) {
              
    //             console.error('Upload error:', error);
    //             $('#progress').text('Upload error: ' + error);
    //         }
    //     });
}




//att edit insert start
function event_att_insert_edit(section_name,terms,section_type,att_response,is_required,type,doc_id_individual){


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
        // var files = $('#att_file_'+section_type)[0].files;
        var files = [];
        // var files2 = $('#att_edit_file_'+section_type)[0].files;
        var files2 = $('#att_edit_file_general')[0].files;
        for (var i = 0; i < files2.length; i++) {
            formData.append('details_doc[]', files2[i]);
        }
        formData.getAll('details_doc[]').forEach(function (file, index) {
          console.log(file.name);
          if (file.size <= 10 * 1024 * 1024) { // Check if file size is less than or equal to 10 MB
          
            files.push({
              name: file.name,
              type: file.type,
              data: null // Placeholder for the file data
            });
          } else {

          }
          });
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
      return readFileAsDataURL(formData.getAll('details_doc[]')[index]);
  });

  // Once all files are converted to Base64, continue
  Promise.all(promises).then(function(base64Strings) {
      base64Strings.forEach(function(base64String, index) {
          files[index].data = base64String.split(',')[1]; // Remove the 'data:image/jpeg;base64,' part
      });

 
      $.ajax({
          url: 'multiple_att_upload_edit_ajax.php',
          type: 'POST',
          // data: JSON.stringify({ files: files }),
          data: JSON.stringify({ files: files, section_name: section_name, section_terms: terms, att_response: att_response, is_required: is_required,section_type:section_type,doc_id_individual:doc_id_individual}),
          contentType: 'application/json',
          success: function (response) {
            
            console.log(response);
              var res = JSON.parse(response);
              $('#progress').html('Upload successful');
              $("#att_edit_section_individual").trigger("reset");
              get_doc_section(section_type,type);
              $('#section_name').val('');
              $('#terms').val('');
              $('#terms').val('');
              $('#att_file').val('');
              
              $('#att_file_commercial').val('');
              $('#att_file_technical').val('');
              $('#att_file_general').val('');
              $('#uploadButton').hide();
              $('#uploadButton1').hide();
              $('#uploadButton2').hide();
              
              
              $('#att_response').prop('checked', false);
              $('#is_required').prop('checked', false);
              $('#progress').html('');
              hideLoader();
          },
          error: function (xhr, status, error) {
              console.error('Error uploading image:', error);
              $('#response').text('Error uploading image. Please try again.');
          }
      });
  }).catch(function(error) {
      console.error('Error converting files to Base64:', error);
  });



}







function is_want_to_send_notification(button_name, button_value) {
    

    $.ajax({
        url: 'entry_into_notification_setup_ajax.php',
        type: 'GET',
        dataType: 'json',
        data: {
            button_name: button_name,
            button_value: button_value
        },
        success: function(response) {
          
        },
        error: function() {
            alert('An error occurred while checking conditions.');
        }
    });
}










function get_doc_section(section,type){

getData2('get_document_section_ajax.php',type,section,section);
}

function base_currency_list(rfq_no){
	var type='';
	var id=''; 
	getData2('base_currency_list_ajax.php','currency_list',rfq_no,id);
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
  getData2("company_setup_ajax.php", "group_for_logo", company, company);
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
					document.getElementById('project_amount_currency').value = res['msg'];
                    document.getElementById('planned_savings_currency').value = res['msg'];
					document.getElementById('cost_avoidance_currency').value = res['msg'];
					document.getElementById('base_currency').value = res['msg']; 
                }
            };
        }
		
	function visibility(content_group){
            var content_group = content_group;
			
            var xhr = new XMLHttpRequest();
         
            xhr.open('POST', 'visibility_save_ajax.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.send('content_group=' + content_group);

            xhr.onload = function() {
                if (xhr.status == 200) {
					var res = JSON.parse(xhr.responseText);
					document.getElementById('content_group').value = res['msg'];
                    document.getElementById('team').innerHTML = res['team'];
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

<? if($_SESSION['master_status']=='CHECKED'){?>
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

<script>

var elementPosition = $('#fixed').offset();

$(window).scroll(function(){
        if($(window).scrollTop() > elementPosition.top){
              $('#fixed').css('position','fixed').css('right','0').css('z-index','999').css('top','0');
        } else {
            $('#fixed').css('position','static');
        }    
});

</script>
<? }?>

<?
require_once "../../../controllers/routing/layout.bottom.php";
?>