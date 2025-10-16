<?php

@session_start();

ob_start();

require_once "../../config/inc.all.php";




// ::::: Edit This Section ::::: 

$title='OD Application Form';			// Page Name and Page Title

$page="half_leave_request_input.php";		// PHP File Name



$root='od';

$table='hrm_od_info';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='type';				// For a New or Edit Data a must have data field



$g_s_date=date('Y-01-01');

$g_e_date=date('Y-12-31');




// ::::: End Edit Section :::::


// ::::: End Edit Section :::::



$crud      =new crud($table);



if(isset($_GET[$unique]))

$$unique = $_GET[$unique];

else

$$unique = $_POST[$unique];

$PBI = find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);

$essentialInfo = find_all_field('essential_info','','PBI_ID='.$_SESSION['employee_selected']);

$status = find_a_field('hrm_leave_info','leave_status','id='.$_REQUEST['id']);



if(isset($_POST['insert']))

{
 if($_POST['type']!=4){
 $s_time_check = explode(':',$_POST['s_time']);
 $e_time_check = explode(':',$_POST['e_time']);
    
 if($s_time_check[1]=='' || $e_time_check[1]==''){
   
   $msggg = '<span style="color:red;font-weight:bold; font-size:16px;">Opps! Time Format Not Valid</span>';
 
 }elseif($_POST['s_time_format']=='' || $_POST['e_time_format']=='' ){
 
 $msggg = '<span style="color:red;font-weight:bold; font-size:16px;">Opps! AM/PM  must not be empty</span>';
 
 }else{


$now= time();

$extention=explode('.',$_FILES['att_file']['name']);

$extention=strtolower(end($extention));

$target_dir = "picture/leave_files/";

$target_file = $target_dir . $$unique.'.'.$extention;



$projectId = array(2,3,4,5);

//$_REQUEST['PBI_ID']=$_SESSION['employee_selected'];

$_REQUEST['PBI_IN_CHARGE'] = $essentialInfo->ESSENTIAL_REPORTING;



if(in_array($essentialInfo->ESSENTIAL_PROJECT, $projectId)){

$_REQUEST['PBI_DEPT_HEAD'] = 111659;}



$_REQUEST['od_status'] = "Pending";



$_REQUEST['half_or_full'] = "od";



$_REQUEST['entry_at'] = date('Y-m-d H:i:s');

//$_REQUEST['s_date']= date('Y-m-d',strtotime($_REQUEST['s_date']));

//$_REQUEST['e_date']= date('Y-m-d',strtotime($_REQUEST['e_date']));

//$_REQUEST['leave_join_date']= date('Y-m-d',strtotime($_REQUEST['leave_join_date']));



if($_FILES['att_file']['tmp_name']!=""){

$_REQUEST['att_file']= $target_file;}

$crud->insert();





move_uploaded_file($_FILES["att_file"]["tmp_name"], '../../'.$target_file);



$type=1;

$msg='New Entry Successfully Inserted.';





unset($_POST);

unset($$unique);

echo '<script type="text/javascript">parent.parent.document.location.href = "../od/view_od.php?notify=12";</script>';



}
}else{
    
	
	$now= time();

$extention=explode('.',$_FILES['att_file']['name']);

$extention=strtolower(end($extention));

$target_dir = "picture/leave_files/";

$target_file = $target_dir . $$unique.'.'.$extention;



$projectId = array(2,3,4,5);

//$_REQUEST['PBI_ID']=$_SESSION['employee_selected'];

$_REQUEST['PBI_IN_CHARGE'] = $essentialInfo->ESSENTIAL_REPORTING;



if(in_array($essentialInfo->ESSENTIAL_PROJECT, $projectId)){

$_REQUEST['PBI_DEPT_HEAD'] = 111659;}



$_REQUEST['od_status'] = "Pending";



$_REQUEST['half_or_full'] = "od";



$_REQUEST['entry_at'] = date('Y-m-d H:i:s');

//$_REQUEST['s_date']= date('Y-m-d',strtotime($_REQUEST['s_date']));

//$_REQUEST['e_date']= date('Y-m-d',strtotime($_REQUEST['e_date']));

//$_REQUEST['leave_join_date']= date('Y-m-d',strtotime($_REQUEST['leave_join_date']));



if($_FILES['att_file']['tmp_name']!=""){

$_REQUEST['att_file']= $target_file;}

$crud->insert();





move_uploaded_file($_FILES["att_file"]["tmp_name"], '../../'.$target_file);



$type=1;

$msg='New Entry Successfully Inserted.';





unset($_POST);

unset($$unique);

echo '<script type="text/javascript">parent.parent.document.location.href = "../od/view_od.php?notify=12";</script>';
	
}

}



//for Modify..................................



if(isset($_POST['update']))

{



$extention=explode('.',$_FILES['att_file']['name']);

$extention=strtolower(end($extention));

$target_dir = "picture/leave_files/";

$target_file = $target_dir . $$unique.'.'.$extention;



//$_REQUEST['PBI_ID']=$_SESSION['employee_selected'];

//$_REQUEST['leave_status'] = 'PENDING';

//$_REQUEST['leave_status_detail'] = 'Waiting for Replacement';

$_REQUEST['edit_at'] = date('Y-m-d H:i:s');

$_REQUEST['leave_from_date']= date('Y-m-d',strtotime($_REQUEST['leave_from_date']));

$_REQUEST['leave_to_date']= date('Y-m-d',strtotime($_REQUEST['leave_to_date']));

$_REQUEST['leave_join_date']= date('Y-m-d',strtotime($_REQUEST['leave_join_date']));



if($_FILES['att_file']['tmp']!=""){

$_REQUEST['att_file']= $target_file;}



		$crud->update($unique);

		

		move_uploaded_file($_FILES["att_file"]["tmp_name"], '../../'.$target_file);

		

		$type=1;

		$msg='Successfully Updated.';

				echo '<script type="text/javascript">

parent.parent.document.location.href = "view_od.php?notify=12";

</script>';

}

//for Delete..................................



if(isset($_POST['delete']))

{		$condition=$unique."=".$$unique;		$crud->delete($condition);

		unset($$unique);

		echo '<script type="text/javascript">

parent.parent.document.location.href = "view_od.php?notify=12";

</script>';

		$type=1;

		$msg='Successfully Deleted.';

}



if(isset($_POST['reportingAuthority']))

{		

unset($_REQUEST);

$_REQUEST['od_status'] = 'Pending';

$_REQUEST['incharge_status'] = 'Approve';

$crud->update($unique);



echo '<script type="text/javascript">

parent.parent.document.location.href = "../od/view_od_incharge.php?notify=12";

</script>';



$type=1;

$msg='Successfully Deleted.';

}

if(isset($_POST['not_approve']))

{		

unset($_REQUEST);

$_REQUEST['od_status'] = '';
$_REQUEST['incharge_status'] = 'Not Approve';

$crud->update($unique);



echo '<script type="text/javascript">

parent.parent.document.location.href = "../od/view_od_incharge.php?notify=12";

</script>';



$type=1;

$msg='Successfully Deleted.';

}



if(isset($_POST['departmentHead']))

{		

unset($_REQUEST);

$_REQUEST['leave_status'] = 'Approve';

$crud->update($unique);



echo '<script type="text/javascript">

parent.parent.document.location.href = "../leave/view_leave_incharge.php?notify=12";

</script>';



$type=1;

$msg='Successfully Deleted.';

}



if(isset($_POST['hrapprove']))

{	
unset($_REQUEST);	

$_REQUEST['od_status'] = 'Granted';

$crud->update($unique);



echo '<script type="text/javascript">

parent.parent.document.location.href = "../od/view_od_hrm.php?notify=12";

</script>';



$type=1;

$msg='Successfully Deleted.';

}

if(isset($_POST['not_granted']))

{	
unset($_REQUEST);	

$_REQUEST['od_status'] = 'Not Granted';

$crud->update($unique);



echo '<script type="text/javascript">

parent.parent.document.location.href = "../od/view_od_hrm.php?notify=12";

</script>';



$type=1;

$msg='Successfully Deleted.';

}



if(isset($$unique))

{+

$condition=$unique."=".$$unique;

$data=db_fetch_object($table,$condition);

while (list($key, $value)=each($data))

{ $$key=$value;}

}

if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);



if(isset($_POST['departmentHead']))

{		

$_REQUEST['leave_status'] = 'Approve';

$crud->update($unique);



echo '<script type="text/javascript">

parent.parent.document.location.href = "../leave/view_leave_incharge.php?notify=12";

</script>';



$type=1;

$msg='Successfully Deleted.';

}

?>

<style type="text/css">

.MATERNITY_LEAVE{

display:none;

}



input[type="radio"], input[type="checkbox"] {

    line-height: normal;

    margin: 4px 0 0;

	width:20px;

}

.radio, .checkbox {

    min-height: 20px;

    padding-left: 20px;

}

.checkbox {

    margin-right: 4px !important;

}



.radio.inline, .checkbox.inline {

    display: inline-block;

    margin-bottom: 0;

    padding-top: 5px;

    vertical-align: middle;

}.radio.inline, .checkbox.inline {

    display: inline-block;

    margin-bottom: 0;

    padding-top: 5px;

    vertical-align: middle;

}

.radio.inline + .radio.inline, .checkbox.inline + .checkbox.inline {

    margin-left: 10px;

}

</style>

<script type="text/javascript">

$(document).ready(function(){



  $("#e_date").change(function (){

     var from_leave = $("#s_date").datepicker('getDate');

     var to_leave = $("#e_date").datepicker('getDate');

    var days   = ((to_leave - from_leave)/1000/60/60/24)+1;



	$("#total_days").val(days);

	

	$("#total_leave").text(' Total  '+ days +'  Days ');

  });

    

    

  

});

  

  function totalhrs(){
     
	  
	  var time1 = document.getElementById('s_time').value;
        var time2 = document.getElementById('e_time').value;
		
		var e_time_format = document.getElementById('e_time_format').value;
		var s_time_format = document.getElementById('s_time_format').value;
        
        var hour=0;
        var minute=0;
        var second=0;
        
        var splitTime1= time1.split(':');
        var splitTime2= time2.split(':');
		
		var splitt= time1.split('.');
		
		var splitt2= time2.split('.');
		
		var semi= time1.split(';');
		
		var semi2= time2.split(';');
		
		var coma= time1.split(',');
		
		var coma2= time2.split(',');
		
		if(splitt[0]>0){
		 alert('Please submit valid time format (00:00)');
		 location.reload();
		}else if(splitt2[0]>0){
		alert('Please submit valid time format (00:00)');
		location.reload();
		}else if(coma[0]>0){
		alert('Please submit valid time format (00:00)');
		location.reload();
		}else if(coma2[0]>0){
		alert('Please submit valid time format (00:00)');
		location.reload();
		}else if(semi[0]>0){
		alert('Please submit valid time format (00:00)');
		location.reload();
		}else if(semi2[0]>0){
		alert('Please submit valid time format (00:00)');
		location.reload();
		}else{
		if(s_time_format=='PM' && e_time_format=='PM' ){
		  if(parseInt(splitTime1[0])==12){
		  
		  splitTime2P = parseInt(splitTime2[0])+12;
		  hour = parseInt(splitTime2P)-parseInt(splitTime1[0]);
		  
		  }else{
		  splitTime2P = parseInt(splitTime2[0]);
		  hour = parseInt(splitTime2P)-parseInt(splitTime1[0]);
		  }
		  
		}else if(e_time_format=='PM'){
		
		  splitTime2P = parseInt(splitTime2[0])+12;
		  hour = parseInt(splitTime2P)-parseInt(splitTime1[0]);
		
		}else{
		 hour = parseInt(splitTime2[0])-parseInt(splitTime1[0]);
		}
		
		
        if(splitTime1[1]>splitTime2[1]){
		
		 var perfect_time = parseInt(splitTime1[1])-parseInt(splitTime2[1]);
		     hour = hour-1;
			 minute = 60-perfect_time;
		
		}else{
		  
		  perfect_time = parseInt(splitTime2[1])-parseInt(splitTime1[1]);
		  
		  minute = perfect_time;
		}
		
		/*if(timeInMinute_min_div>=60){
		    hour = timeInMinute_min_div/60;
			minute = timeInMinute_min_div%60;
		   
		}*/
		
		
		
       //hour = hour + minute/60;
       //minutes = minute%60;
	   
	   if(splitTime2[0]==12 && e_time_format=='PM'){
	      
		  hour = hour-12;
	   
	   }
        
	  document.getElementById('test').value = splitTime2[1]; 
	  document.getElementById('total_hrs').value = hour+':'+minute;
	  }
  }

  function changeType(){

     

	 var status = document.getElementById('type').value;

	

	 if(status==1){

	 

	 document.getElementById('nameofowner').style.display='';

	 document.getElementById('companyname').style.display='';
	 
	 document.getElementById('address2').style.display='';
	 
	 

	

	 

	 }

	  if(status !=1){

	 

	 document.getElementById('nameofowner').style.display='none';

	 document.getElementById('companyname').style.display='none';
	 
	  document.getElementById('address2').style.display='none';
	 
	

	 

	 }

	 

	 if(status==2){

	 

	 document.getElementById('name').style.display='';

	 document.getElementById('designation1').style.display='';

	 document.getElementById('companynameOr').style.display='';
	 
	  document.getElementById('address3').style.display='';
	

	 

	 }

	 if(status !=2){

	 

	 document.getElementById('name').style.display='none';

	 document.getElementById('designation1').style.display='none';

	 document.getElementById('companynameOr').style.display='none';
	 
	 document.getElementById('address3').style.display='none';
	  
	 

	 

	 }

	 

	 if(status==3){

	 

	 document.getElementById('appointmentwith').style.display='';

	 document.getElementById('designation').style.display='';

	 document.getElementById('projectname').style.display='';

	 }

	 

	 if(status !=3){

	 

	 document.getElementById('appointmentwith').style.display='none';

	 document.getElementById('designation').style.display='none';

	 document.getElementById('projectname').style.display='none';

	 

	 }

	 

	  if(status==4){

	 

	 document.getElementById('place').style.display='';

	 document.getElementById('time').style.display='none';

	 

	 }

	 

	  if(status !=4){

	 

	 document.getElementById('place').style.display='none';

	 document.getElementById('time').style.display='';

	 

	 }
	 
	 
	 
	  if(status==5){

	 

	 document.getElementById('companynameOr2').style.display='';
	 document.getElementById('destination').style.display='';
	 document.getElementById('address').style.display='';
	 


	 

	 }

	 

	  if(status !=5){

	 

	 document.getElementById('companynameOr2').style.display='none';
	 document.getElementById('destination').style.display='none';
	 document.getElementById('address').style.display='none';
	 

	 

	 }


	 

	 

  

  }
  window.onload = changeType;

</script>


<div class="right_col" role="main">   <!-- Must not delete it ,this is main design header-->
          <div class="">
		  
		  
           
        <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
				  
				  	 <div class="openerp openerp_webclient_container">
                   
			
				  
				  
                  <div class="x_content">
				  
				  
				  
				  
				  
				  
				  
				  <div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary" align="center">
				<div class="panel-heading">
					<h3 class="panel-title">Application For OD <?=$test[1];?></h3>
				</div>
				<div class="panel-body">
				
				
				
				
				
				

<form action="" method="post" enctype="multipart/form-data" autocomplete="off">

  <div class="oe_view_manager oe_view_manager_current">

    <? include('../../common/title_bar_od_new.php');?>

    <div class="oe_view_manager_body">

      <div  class="oe_view_manager_view_list"></div>

      <div class="oe_view_manager_view_form">

        <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">

          <div class="oe_form_buttons"></div>

          <div class="oe_form_sidebar"></div>

          <div class="oe_form_pager"></div>

          <div class="oe_form_container">

            <div class="oe_form">

              <div class="">

                <div class="oe_form_sheetbg">

                  <div class="oe_form_sheet oe_form_sheet_width"> <?php echo $msggg; ?>

                    <table class="oe_form_group table-bordered" border="0" cellpadding="0" cellspacing="0">

                      <tbody>

                        <tr class="oe_form_group_row">

                          <td colspan="1" class="oe_form_group_cell" width="100%"><table width="100%" border="0" cellpadding="2" cellspacing="0" class="oe_form_group ">

                              <tbody>

                                

                                <tr class="oe_form_group_row">

                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">

								  

								  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />

                                    <input name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['user']['id']?>" type="hidden" />
									 <input name="year" id="year" value="<?=date('Y')?>" type="hidden" />
									  <input name="mon" id="mon" value="<?=date('n')?>" type="hidden" />

                                    &nbsp;&nbsp;OD Type  :</td>

                                  <td class="oe_form_group_cell" colspan="4">

								  <select name="type" id="type" onchange="changeType()" required>

								   <?= foreign_relation('od_type','id','type_name',$type);?>

								  </select>                             </td>

                                </tr>

								

								<tr class="oe_form_group_row" id="nameofowner" style="display:none">

                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">

                                    &nbsp;&nbsp;Name of Owner  :</td>

                                  <td class="oe_form_group_cell" colspan="4">

								  <input type="text" name="client_name" value="<?=$client_name?>" id="client_name"  />                             </td>

                                </tr>

								<tr class="oe_form_group_row" id="name" style="display:none">

                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">

                                    &nbsp;&nbsp;Name  :</td>

                                  <td class="oe_form_group_cell" colspan="4">

								  <input type="text" name="name" value="<?=$name?>" id="name"  />                             </td>

                                </tr>

								<tr class="oe_form_group_row" id="appointmentwith" style="display:none">

                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">

                                    &nbsp;&nbsp;Appointment With  :</td>

                                  <td class="oe_form_group_cell" colspan="4">

								  <input type="text" name="appointment_with" value="<?=$appointment_with?>" id="appointment_with"  />                             </td>

                                </tr>

								

								<tr class="oe_form_group_row" id="designation" style="display:none">

                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">

                                    &nbsp;&nbsp;Designation.  :</td>

                                  <td class="oe_form_group_cell" colspan="4">

								  <input type="text" name="designations" value="<?=$designations?>" id="designations"  />                             </td>

                                </tr>

								<tr class="oe_form_group_row" id="designation1" style="display:none">

                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">

                                    &nbsp;&nbsp;Designation  :</td>

                                  <td class="oe_form_group_cell" colspan="4">

								  <input type="text" name="designation" value="<?=$designation?>" id="designation"  />                             </td>

                                </tr>

								

								<tr class="oe_form_group_row" id="companyname" style="display:none">

                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">

                                    &nbsp;&nbsp;Company Name  :</td>

                                  <td class="oe_form_group_cell" colspan="4">

								  <input type="text" name="company_name" id="company_name" value="<?=$company_name?>"  />                             </td>

                                </tr>

								<tr class="oe_form_group_row" id="destination" style="display:none">

                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" style="">

                                    &nbsp;&nbsp;OD Destination  :</td>

                                  <td class="oe_form_group_cell" colspan="4">

								  <input type="text" name="od_destination" value="<?=$od_destination?>" id="od_destination" placeholder="Ex. Bank, Head Office,Training"   />                             </td>

                                </tr>
								
								

								<tr class="oe_form_group_row" id="companynameOr" style="display:none">

                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">

                                    &nbsp;&nbsp;Company/Organization Name  :</td>

                                  <td class="oe_form_group_cell" colspan="4">

								  <input type="text" name="organization" value="<?=$organization?>" id="organization"  />                             </td>

                                </tr>
								
								<tr class="oe_form_group_row" id="companynameOr2" style="display:none">

                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">

                                    &nbsp;&nbsp;Company/Organization Name  :</td>

                                  <td class="oe_form_group_cell" colspan="4">

								  <input type="text" name="organization2" value="<?=$organization2?>" id="organization"  />                             </td>

                                </tr>
								
								<tr class="oe_form_group_row" id="place" style="display:none">

                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" style="">

                                    &nbsp;&nbsp;Place/Address  :</td>

                                  <td class="oe_form_group_cell" colspan="4">

								  <input type="text" name="place" value="<?=$place?>" id="place"  />                             </td>

                                </tr>
								
								<tr class="oe_form_group_row" id="address" style="display:none">

                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" style="">

                                    &nbsp;&nbsp;Place/Address  :</td>

                                  <td class="oe_form_group_cell" colspan="4">

								  <input type="text" name="place2" value="<?=$place2?>" id="place"  />                             </td>

                                </tr>
								
								<tr class="oe_form_group_row" id="address2" style="display:none">

                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" style="">

                                    &nbsp;&nbsp;Place/Address  :</td>

                                  <td class="oe_form_group_cell" colspan="4">

								  <input type="text" name="place3" value="<?=$place3?>" id="place"  />                             </td>

                                </tr>
								
								<tr class="oe_form_group_row" id="address3" style="display:none">

                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" style="">

                                    &nbsp;&nbsp;Place/Address  :</td>

                                  <td class="oe_form_group_cell" colspan="4">

								  <input type="text" name="place4" value="<?=$place4?>" id="place"  />                             </td>

                                </tr>

								

								<tr class="oe_form_group_row" id="projectname" style="display:none">

                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">

                                    &nbsp;&nbsp;Project Name  :</td>

                                  <td class="oe_form_group_cell" colspan="4">

								  <input type="text" name="project_name" value="<?=$project_name?>" id="project_name"  />                             </td>

                                </tr>

								

								
								
								

								

                                

                                

                                <tr class="oe_form_group_row" id="time">

                                  <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Duration : </td>

                                  <td colspan="4" bgcolor="#E8E8E8" class="oe_form_group_cell"><table width="100%" border="0">

                                      <tr>

                                        <td width="1"> 
                                             

											 <input type="text" name="s_time" id="s_time" value="<?=$s_time?>" style="width:150px; margin-top:4px;" placeholder="Start Time:(ex:10:30)" onBlur="totalhrs();" />

											 <input type="hidden" name="s_time1" id="s_time1" value="<? echo date('Y-m-d ');?>"  />
											  <input type="hidden" name="test" id="test" />
											 

											
										  </td>

                                        <td width="80"><div align="center"><span class="oe_form_group_cell oe_form_group_cell_label"><select name="s_time_format" id="s_time_format" style="width:10px;" onBlur="totalhrs();" ><option><?=$s_time_format?></option><option>AM</option><option>PM</option></select>-to-</span></div></td>

                                        <td width="1"><span class="oe_form_group_cell oe_form_group_cell_label">

                                        <input type="text" name="e_time" id="e_time" value="<?=$e_time?>" style="width:150px;" placeholder="End Time:(ex:04:00)" onBlur="totalhrs();" />
                                         
                                          </span>


									    </td>

                                        <td>

										

 										  <select name="e_time_format" id="e_time_format" style="width:10px; margin-top:4px;" onBlur="totalhrs();" ><option><?=$e_time_format?></option><option>PM</option><option>AM</option></select> &nbsp;&nbsp;<b id="total_leave_hrs"> Total <input type="text" name="total_hrs" id="total_hrs" value="<?=$total_hrs?>" style="width:5px;"  readonly=""/>

                                          Hrs

                                          

                                          </b></td>

                                      </tr>

                                    </table></td>

                                </tr>

								

								

								<tr class="oe_form_group_row">
                                  <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;OD Date : </td>
                                  <td colspan="4" bgcolor="#E8E8E8" class="oe_form_group_cell"><table width="100%" border="0">
                                      <tr>
                                        <td width="1"><?php
					  do_calander('#s_date');
					  ?>                            
            
                        <input name="s_date" type="date" id="s_date" class="form-control" value="<?php if($s_date=='') echo ''; else echo $s_date ; ?>"  required/></td>
                                        <td width="80"><div align="center"><span class="oe_form_group_cell oe_form_group_cell_label">-to- </span></div></td>
                                        <td width="1"><span class="oe_form_group_cell oe_form_group_cell_label">
                                          <?
 do_calander('#e_date','-0','+30');
?>
                                          <input name="e_date" type="date" id="e_date"  value="<?php if($e_date=='') echo ''; else echo $e_date ; ?>"  onchange="getData2('leave_ajax.php', 'leave',document.getElementById('s_date').value,document.getElementById('e_date').value)" required/>
                                          </span></td>
                                        <td><input type="hidden" value="" name="total_days" id="total_days"/>
                                          &nbsp;&nbsp;<b id="total_leave">
                                          <span id="leave"><input type="text" value="<?=find_a_field('hrm_od_info','total_days','id='.$$unique);?>" name="total_days" id="total_days" readonly="" style="width:10px; border:0px solid $ccc;"/></span>
                                          
                                        
										  
                                          </b></td>
                                      </tr>
                                    </table></td>
                                </tr>

								

                                <tr class="oe_form_group_row">

                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Reason :</td>

                                  <td class="oe_form_group_cell" colspan="4"><span class="oe_form_group_cell oe_form_group_cell_label">

                                    <textarea name="reason" style="width:500px;" required><?=$reason?></textarea>

                                  </span></td>

                                </tr>

                                <tr class="oe_form_group_row">

                                  <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Supporting Doc: </td>

                                  <td colspan="4" bgcolor="#E8E8E8" class="oe_form_group_cell"><input type="file" name="att_file" /></td>

                                </tr>

                                <tr class="oe_form_group_row">

                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;OD Submission &nbsp;Date : </td>

                                  <td class="oe_form_group_cell" colspan="4"><script language="javascript">



$('#leave_to_date').change(function() {



     var from_leave = $("#leave_from_date").datepicker('getDate');

     var to_leave = $("#leave_to_date").datepicker('getDate');

    var days   = ((to_leave - from_leave)/1000/60/60/24)+1;



	



           $.ajax({

            success: function(response) {

           $( "#leave_join_date" ).datepicker({

			changeMonth: true,

			changeYear: true,

			minDate: +days, 

			maxDate: +30, 

			dateFormat: "dd-mm-yy"

		});

                /*added following line to solve this issue ..but not worked*/

                //$( ".datepicker" ).datepicker({dateFormat: "dd-mm-yy"});



            } ,

            error: function () {}

        });

       });

</script>

                                    <?php do_calander('#od_date');?>

                                    <input  name="od_date" type="date" id="od_date" value="<?=$od_date; ?>" required/></td>

                                </tr>

								



                              

									 <input type="hidden" name="reporting_auth" value="<?=find_a_field('essential_info','ESSENTIAL_REPORTING','PBI_ID='.$_SESSION['user']['id'])?>" />

                              </tbody>

                          </table></td>

						 

                        </tr>

                        <tr>

                          <td><div align="center">

                              <? if(!isset($_GET[$unique])){?>

                              <span class="oe_form_buttons_edit" style="display: inline;">

                              <button name="insert" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Apply</button>

                              </span>

                              <? }?>

                             

							  <? if(isset($_GET[$unique]) && $_SESSION['employee_selected']==$PBI_IN_CHARGE && $incharge_status=='Pending'){?>

                              <span class="oe_form_buttons_edit" style="display: inline;">

                              <button name="reportingAuthority" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Approve</button>

                              </span>
							  
							  <span class="oe_form_buttons_edit" style="display: inline;">

                              <button name="not_approve" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Not Approve</button>

                              </span>

                              <? }?>

							  

							  <? if(isset($_GET[$unique]) && $_SESSION['employee_selected']==101656 && $incharge_status == 'Approve'){?>

                              <span class="oe_form_buttons_edit" style="display: inline;">

                              <button name="hrapprove" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Granted</button>

                              </span>

							  <span class="oe_form_buttons_edit" style="display: inline;">

                              <button name="not_granted" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Not Granted</button>

                              </span>

                              <? }?>

								<? if($od_status=='Pending' && $incharge_status=='Pending' ){?>

								 <? if(isset($_GET[$unique]) && $PBI_ID==$_SESSION['employee_selected']){?>

                              <span class="oe_form_buttons_edit" style="display: inline;">

                              <button name="update" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Update</button>

                              </span>

							   <span class="oe_form_buttons_edit" style="display: inline;">

                              <button name="delete" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Cancel</button>

                              </span>

                              <? } } ?>

							  

							  <? if(isset($_GET[$unique])){?>

                             

                              <? }  ?>

							  

                            </div></td>

                        </tr>

                      </tbody>

                    </table>

                  </div>

                </div>

                <div class="oe_chatter">

                  <div class="oe_followers oe_form_invisible">

                    <div class="oe_follower_list"></div>

                  </div>

                </div>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

</form>


</div>
</div>
</div>
</div>

</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");

?>


<?  include_once("../../template/footer.php");   ?>