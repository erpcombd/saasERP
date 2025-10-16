<?php
@session_start();
ob_start();
require_once "../../config/inc.all.php";

// ::::: Edit This Section ::::: 

$title='Leave Application Form';			// Page Name and Page Title

$page="half_leave_request_input.php";		// PHP File Name

$root='leave';

$table='hrm_leave_info';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='type';				// For a New or Edit Data a must have data field

$g_s_date=date('Y-01-01');
$g_e_date=date('Y-12-31');



do_calander('#leave_apply_date');











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







$reporting = find_a_field('essential_info','ESSENTIAL_REPORTING','PBI_ID='.$PBI->PBI_ID);



$reporting_data = find_all_field('personnel_basic_info','','PBI_ID='.$reporting);







$leave_id = find_all_field('hrm_leave_info','','id='.$_REQUEST['id']);



 



 $mmmail = find_a_field('personnel_basic_info','PBI_EMAIL','PBI_ID='.$leave_id ->PBI_ID);
 $number = find_a_field('personnel_basic_info','PBI_MOBILE','PBI_ID='.$leave_id ->PBI_ID);







//$_REQUEST['s_date']= date('Y-m-d',strtotime($_REQUEST['s_date']));



//$_REQUEST['e_date']= date('Y-m-d',strtotime($_REQUEST['e_date']));







$user_leave_rull = find_all_field('hrm_leave_rull_manage','','id='.$PBI->LEAVE_RULE_ID);







$leave_days_casual=find_a_field('hrm_leave_info','sum(total_days)','type="Casual Leave" and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$_SESSION['employee_selected']);







$leave_days_sick=find_a_field('hrm_leave_info','sum(total_days)','type="Sick Leave" and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$_SESSION['employee_selected']);




$leave_days_annual=find_a_field('hrm_leave_info','sum(total_days)','type="Annual" and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$_SESSION['employee_selected']);











$prev_lv=mysql_num_rows(mysql_query("select * from hrm_leave_info where PBI_ID='".$_SESSION['employee_selected']."' and s_date='".$_REQUEST['s_date']."' and e_date='".$_REQUEST['e_date']."'"));







//echo $user_leave_rull->MED. ' OK '.$_POST['type']. ' lv '.$leave_days_sick;



$today_date = date('Y-m-d');



if(isset($_POST['insert']))

{

if(($_POST['half_leave_date']) < $today_date){



$msggg= "<h2 style='color:#FF0000'>You can not apply back date leave <br> (আপনি পূর্ববর্তি ছুটি আবেদনের জন্য অনুমতি প্রাপ্ত না)</h2>";



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







$_REQUEST['leave_status'] = "PENDING";







$_REQUEST['half_or_full'] = "Half";







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











//$to = $reporting_mail;



$str ="<span style='font-weight:bold; font-size:16px;'>Leave applied for</span>";







$str.='<table width="100%" border="1" cellspacing="1" cellpadding="1">







 



  <tr style="background:#abc4d6;">



    <td width="5%"><div align="center" style="font-weight:bold; background:#abc4d6;">ID</div></td>



    <td width="11%"><div align="center" style="font-weight:bold;">Name</div></td>



	<td width="10%"><div align="center" style="font-weight:bold;">Designation</div></td>



    <td width="15%"><div align="center" style="font-weight:bold;">Duties Carried By</div></td>



    <td width="10%"><div align="center" style="font-weight:bold;">Department</div></td>



	<td width="10%"><div align="center" style="font-weight:bold;">Job Location/Project</div></td>



    <td width="10%"><div align="center" style="font-weight:bold;">Start Time</div></td>



	 <td width="10%"><div align="center" style="font-weight:bold;">End Time</div></td>



	  <td width=2%"><div align="center" style="font-weight:bold;">Total Hours</div></td>



	  <td width=2%"><div align="center" style="font-weight:bold;">Leave Date</div></td>



	   <td width="17%"><div align="center" style="font-weight:bold;">Leave Type</div></td>



    



    



  </tr>';















  



   $ss = "select p.PBI_ID,p.PBI_NAME, desg.DESG_DESC,(select PBI_NAME from personnel_basic_info where PBI_ID=l.leave_responsibility_name) as duties_carried_by, dept.DEPT_DESC, (select PROJECT_DESC from project where PROJECT_ID=p.JOB_LOCATION) as project, TIME_FORMAT(l.s_time, '%h:%i') as s_time,TIME_FORMAT(l.e_time, '%h:%i') as e_time, l.total_hrs, l.type,l.half_leave_date from personnel_basic_info p, designation desg, department dept, hrm_leave_info l where 1 and l.type='Short Leave (SHL)' and l.half_leave_date='".$_REQUEST['half_leave_date']."' and l.PBI_ID=p.PBI_ID and p.PBI_DESIGNATION=desg.DESG_ID and p.PBI_DEPARTMENT=dept.DEPT_ID and  l.PBI_ID='".$_SESSION['employee_selected']."' order by l.id desc ";



	  $query1 = mysql_query($ss);



	 $data = mysql_fetch_object($query1);



	 



	 if($data->DEPT_DESC == 'NO DEPARTMENT'){



	 $dep = '';



	 }else{



	 $dep = $data->DEPT_DESC;



	 }



	 







   $str.= '<tr align="center">';



     $str.= '<td>'.$data->PBI_ID.'</td>';



     $str.= '<td>'.$data->PBI_NAME.'</td>';



     $str.= '<td>'.$data->DESG_DESC.'</td>';



     $str.= '<td>'.$data->duties_carried_by.'</td>';



     $str.= '<td>'.$dep.'</td>';



     $str.= '<td>'.$data->project.'</td>';



     $str.= '<td>'.$data->s_time.'</td>';



	 $str.= '<td>'.$data->e_time.'</td>';



	 $str.= '<td>'.$data->total_hrs.'</td>';



	  $str.= '<td>'.$data->half_leave_date.'</td>';



	 $str.= '<td>'.$data->type.'</td>';



   $str.= '</tr>';



   



   



   







$headers = "MIME-Version: 1.0\r\n";



$headers .= "Content-Type: text/html; charset=UTF-8\r\n";



$to = $reporting_data->PBI_EMAIL;



//$to = "tanvir@aksidcorp.com";;







$subject = "Short Leave Request Pending";



//$txt = " ".$PBI->PBI_NAME." has applied a ".$leave_name." for ".$_POST['total_days']." days";



$headers .= "From: AKSID Human Resources<hr@aksidcorp.com>";



mail($to,$subject,$str,$headers);











unset($_POST);



unset($$unique);



echo '<script type="text/javascript">parent.parent.document.location.href = "../leave/view_leave_half.php?notify=12";</script>';







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



parent.parent.document.location.href = "view_leave_half.php?notify=12";



</script>';



}



//for Delete..................................







if(isset($_POST['delete']))



{		$condition=$unique."=".$$unique;		$crud->delete($condition);



		unset($$unique);



		echo '<script type="text/javascript">



parent.parent.document.location.href = "view_leave_half.php?notify=12";



</script>';



		$type=1;



		$msg='Successfully Deleted.';



}







if(isset($_POST['reportingAuthority']))



{		



unset($_REQUEST);



//$_REQUEST['leave_status'] = 'Approve';



$_REQUEST['incharge_status'] = 'Approve';

$_REQUEST['reporting_note'] = $_POST['reporting_note'];

$_REQUEST['s_time'] = $_POST['s_time'];

$_REQUEST['e_time'] = $_POST['e_time'];

$_REQUEST['total_hrs'] = $_POST['total_hrs'];



$crud->update($unique);







$strr ="<span style='font-weight:bold; font-size:16px;'>Leave has approved for</span>";







$strr.='<table width="100%" border="1" cellspacing="1" cellpadding="1">







 



  <tr style="background:#abc4d6;">



    <td width="5%"><div align="center" style="font-weight:bold; background:#abc4d6;">ID</div></td>



    <td width="11%"><div align="center" style="font-weight:bold;">Name</div></td>



	<td width="10%"><div align="center" style="font-weight:bold;">Designation</div></td>



    <td width="15%"><div align="center" style="font-weight:bold;">Duties Carried By</div></td>



    <td width="10%"><div align="center" style="font-weight:bold;">Department</div></td>



	<td width="10%"><div align="center" style="font-weight:bold;">Job Location/Project</div></td>



    <td width="10%"><div align="center" style="font-weight:bold;">Start Date</div></td>



	 <td width="10%"><div align="center" style="font-weight:bold;">End Date</div></td>



	  <td width=2%"><div align="center" style="font-weight:bold;">Total Days</div></td>



	   <td width="17%"><div align="center" style="font-weight:bold;">Leave Type</div></td>



    



    



  </tr>';















  



   $ss = "select p.PBI_ID,p.PBI_NAME, desg.DESG_DESC,(select PBI_NAME from personnel_basic_info where PBI_ID=l.leave_responsibility_name) as duties_carried_by, dept.DEPT_DESC, (select PROJECT_DESC from project where PROJECT_ID=p.JOB_LOCATION) as project, TIME_FORMAT(l.s_time, '%h:%i') as start_time,TIME_FORMAT(l.e_time, '%h:%i') as end_time, l.total_hrs, l.type from personnel_basic_info p, designation desg, department dept, hrm_leave_info l where 1 and l.half_leave_date='".$_REQUEST['half_leave_date']."' and l.PBI_ID=p.PBI_ID and p.PBI_DESIGNATION=desg.DESG_ID and p.PBI_DEPARTMENT=dept.DEPT_ID and l.PBI_ID='".$leave_id->PBI_ID."' and l.type not in (1,2,3,4,5,6,7,8,9) order by l.PBI_ID desc";



	  $query1 = mysql_query($ss);



	 $data = mysql_fetch_object($query1);



	 $type_name = 'Short Leave (SHL)';



	 if($data->DEPT_DESC == 'NO DEPARTMENT'){



	 $depp = '';



	 }else{



	 $depp = $data->DEPT_DESC;



	 }



	 







   $strr.= '<tr align="center">';



     $strr.= '<td>'.$data->PBI_ID.'</td>';



     $strr.= '<td>'.$data->PBI_NAME.'</td>';



     $strr.= '<td>'.$data->DESG_DESC.'</td>';



     $strr.= '<td>'.$data->duties_carried_by.'</td>';



     $strr.= '<td>'.$depp.'</td>';



     $strr.= '<td>'.$data->project.'</td>';



     $strr.= '<td>'.$data->start_time.'</td>';



	 $strr.= '<td>'.$data->end_time.'</td>';



	 $strr.= '<td>'.$data->total_hrs.'</td>';



	 $strr.= '<td>'.$type_name.'</td>';



   $strr.= '</tr>';



   



   



   







$headers = "MIME-Version: 1.0\r\n";



$headers .= "Content-Type: text/html; charset=UTF-8\r\n";



 $to = "tanvir@aksidcorp.com";



//$to = $reporting_mail;



$subject = "Short Leave has approved for";



$txt = "Short Leave request pending";



$headers .= "From: AKSID Human Resources<hr@aksidcorp.com>" . "\r\n" .



"CC: bimol@erp.com.bd";



mail($to,$subject,$txt,$headers);







echo '<script type="text/javascript">



parent.parent.document.location.href = "../leave/view_leave_incharge_half.php?notify=12";



</script>';







$type=1;



$msg='Successfully Deleted.';



}







if(isset($_POST['not_approve']))



{		



unset($_REQUEST);



$_REQUEST['leave_status'] = '';



$_REQUEST['incharge_status'] = 'Not Approve';



$crud->update($unique);



//Text Sms

function sms($dest_addr,$sms_text){
          
       
$url = "https://api.mobireach.com.bd/SendTextMessage?Username=aksid&Password=Akhr@2019&From=AKSID_HR";

$fields = array(
    'Username'      => "aksid",
    'Password'      => "Akhr@2019",
    'From'          => "AKSID HR",
    'To'            => $dest_addr,
    'Message'       => $sms_text
);

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, count($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));

//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);


}

            $recipients='88'.$number.'';
			
			$massage  = "Your requested Leave is not approved\r\n";
			$massage.="Leave Type: Short Leave (SHL)\r\n";
			$massage.="Time: ".date('h:i a', strtotime($_POST['s_time']))." to ".date('h:i a', strtotime($_POST['e_time']))."\r\n";
			$massage.="Date: ".date('d-M-Y',strtotime($_POST['half_leave_date']))."\r\n";
			

     
	      $sms_result=sms($recipients,$massage);
	
	
 //Text Sms





echo '<script type="text/javascript">



parent.parent.document.location.href = "../leave/view_leave_incharge_half.php?notify=12";



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



$_REQUEST['leave_status'] = 'Granted';



$crud->update($unique);







echo '<script type="text/javascript">



parent.parent.document.location.href = "../leave/view_leave_incharge.php?notify=12";



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
           <div class="panel-heading"><h3 class="panel-title">Short Leave Application Form</h3>
           </div>
		   <div class="panel-body">





<form action="" method="post" enctype="multipart/form-data" autocomplete="off">



  <div class="oe_view_manager oe_view_manager_current">



    <? include('../../common/title_bar.php');?>



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



                  <div class="oe_form_sheet oe_form_sheet_width" align="center" style=" font-size:12px;"><?php echo $msggg;?>



				 <? 



				  $curMonthTo = date('Y-m-01');



				  $curMonthFrom = date('Y-m-31');



				  



				  $date_dfrnc = date_diff(date_create(date('Y-m-d')), date_create($PBI->PBI_DOJ));



                  $total_job_days = $date_dfrnc->format('%a');



				  


                 if($leave_id->PBI_ID>0){
				 $leave_days_half=find_a_field('hrm_leave_info','sum(total_days)','type="Short Leave (SHL)" and leave_status="Granted" and half_leave_date between "'.$curMonthTo.'" and "'.$curMonthFrom.'" and PBI_ID='.$leave_id->PBI_ID);
				 }else{
				 $leave_days_half=find_a_field('hrm_leave_info','sum(total_days)','type="Short Leave (SHL)" and leave_status="Granted" and half_leave_date between "'.$curMonthTo.'" and "'.$curMonthFrom.'" and PBI_ID='.$_SESSION['employee_selected']);
				 }



				 



				 if($leave_days_half == 1){



				   echo "<h2 style='color:green'>1 Day Short Leave (SHL) Already Availed <br> ১ টি  Short Leave(SHL) ইতিমধ্যে সম্পূর্ণ হয়েছে </h2>";



				 }elseif($leave_days_half == 2){



				   echo "<h2 style='color:green'>2 Day's Short Leave (SHL) Already Availed <br> 2 টি  Short Leave(SHL) ইতিমধ্যে সম্পূর্ণ হয়েছে </h2>";



				 }elseif($leave_days_half == 3 && $total_job_days<365 && $essentialInfo->EMPLOYMENT_TYPE != 'Permanent'){



				   echo "<h2 style='color:red'>3 Day's Short Leave (SHL) Will Deduct 1 day Salary <br> ১ দিনের বেতন কর্তন করা হবে </h2>";



				 }elseif($leave_days_half == 3 && $total_job_days<365){



				   echo "<h2 style='color:red'>3 Day's Short Leave (SHL) Will Deduct 1 day Casual Leave(CL) <br> ১ দিনের Casual Leave(CL) কর্তন করা হবে  </h2>";



				 }elseif($leave_days_half == 3 && $total_job_days>365 && $essentialInfo->EMPLOYMENT_TYPE == 'Permanent'){



				   echo "<h2 style='color:red'>3 Day's Short Leave (SHL) Will Deduct 1 day Annual Leave(AL) <br> ১ দিনের Annual Leave(AL) কর্তন করা হবে  </h2>";



				 }else{



				   echo "<h2></h2>";



				 }



				 ?>



                    <table class="oe_form_group table table-bordered" border="0" cellpadding="0" cellspacing="0">



                      <tbody>



                        <tr class="oe_form_group_row">



                          <td colspan="1" class="oe_form_group_cell" width="100%"><table width="100%" border="0" cellpadding="2" cellspacing="0" class="oe_form_group ">



                              <tbody>



                                



                                <tr class="oe_form_group_row">



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">



								  



								  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />



                                    <input name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['user']['id']?>" type="hidden" />



									 <input name="mon" id="mon" value="<?=date('n')?>" type="hidden" />



									  <input name="year" id="year" value="<?=date('Y')?>" type="hidden" />



                                    &nbsp;&nbsp;Leave Types  :</td>



                                  <td class="oe_form_group_cell" colspan="4">



								  <input type="text" name="type" value="Short Leave (SHL)"  readonly  />                             </td>
                                </tr>



                                <!--<tr class="oe_form_group_row">



                  <td  id="MATERNITY_LEAVE_LEVEL1" bgcolor="#fff" colspan="1" class="oe_form_group_cell oe_form_group_cell_label MATERNITY_LEAVE">&nbsp;&nbsp;আপনি কি আগে ছুটি ভোগ করেছেন? :</td>



                  <td id="MATERNITY_LEAVE_INPUT1" bgcolor="#fff" class="oe_form_group_cell MATERNITY_LEAVE">



				  <select onChange="MATERNITY_yes_check(this.value)" id="MATERNITY_past" name="MATERNITY_past">



                     <option value="" selected="selected">বাছাই করুন</option>



                          <option <?php if($MATERNITY_past=="yes") echo "selected"; ?> value="yes">হ্যা</option>



                             <option <?php if($MATERNITY_past=="no") echo "selected"; ?> value="no">না</option>



                         </select></td>



						    <td id="materlan_count_level" bgcolor="#fff" colspan="2" class="oe_form_group_cell oe_form_group_cell_label MATERNITY_LEAVE">&nbsp;&nbsp;কতবার ভোগ করেছেন? :</td>



                  <td id="materlan_count_input" bgcolor="#fff" class="oe_form_group_cell MATERNITY_LEAVE">



				  <select name="materlan_count" id="materlan_count">



                       <option value="" selected="selected">বাছাই করুন</option>



                       <option <?php if($materlan_count==1) echo "selected"; ?> value="1">১ বার</option>



                       <option <?php if($materlan_count==2) echo "selected"; ?> value="2">২ বার</option>



                       </select></td>



                  </tr>-->



                                



                                <!--<tr class="oe_form_group_row">



                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;সংযুক্তি :</td>



                  <td colspan="3" class="oe_form_group_cell"><input type="file" name="att_file" /></td>



                  </tr>-->



                                



                                <tr class="oe_form_group_row">



                                  <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Duration : </td>



                                  <td colspan="4" bgcolor="#E8E8E8" class="oe_form_group_cell"><table width="100%" border="0">



                                      <tr>



                                        <td width="1">



                                          



										     <select name="s_time" id="s_time" class="form-control" onchange="totalhrs();" required>



											  <option disabled="disabled">Select Start Time</option>



											 <?

											    if($s_time!=''){

											  ?>



											 <option  value="<?=$s_time?>"><?=date('h:i a', strtotime($s_time));?></option>

											 

											 <? } ?>



											  <option value="<?=date('Y-m-d');?> 08:00:00">08:00 AM</option>



											 <option value="<?=date('Y-m-d');?> 08:30:00">08:30 AM</option>



											<option value="<?=date('Y-m-d');?> 09:00:00">09:00 AM</option>



											   <option value="<?=date('Y-m-d');?> 09:30:00">09:30 AM</option>



											    <option value="<?=date('Y-m-d');?> 10:00:00">10:00 AM</option>



											   <option value="<?=date('Y-m-d');?> 10:30:00">10:30 AM</option>



											    <option value="<?=date('Y-m-d');?> 11:00:00">11:00 AM</option>



											    <option value="<?=date('Y-m-d');?> 11:30:00">11:30 AM</option>



												 <option value="<?=date('Y-m-d');?> 12:00:00">12:00 PM</option>



												 <option value="<?=date('Y-m-d');?> 12:30:00">12:30 PM</option>



												  <option value="<?=date('Y-m-d');?> 13:00:00">01:00 PM</option>



												   <option value="<?=date('Y-m-d');?> 13:30:00">01:30 PM</option>



												     <option value="<?=date('Y-m-d');?> 14:00:00">02:00 PM</option>



													 <option value="<?=date('Y-m-d');?> 14:30:00">02:30 PM</option>



													 <option value="<?=date('Y-m-d');?> 15:00:00">03:00 PM</option>



													 



													   <option value="<?=date('Y-m-d');?> 15:30:00">03:30 PM</option>



													   <option value="<?=date('Y-m-d');?> 16:00:00">04:00 PM</option>



													    <option value="<?=date('Y-m-d');?> 16:30:00">04:30 PM</option>

														

														<option value="<?=date('Y-m-d');?> 17:00:00">05:00 PM</option>



														<option value="<?=date('Y-m-d');?> 17:30:00">05:30 PM</option>
											 </select>										  </td>



                                        <td width="80"><div align="center"><span class="oe_form_group_cell oe_form_group_cell_label">-to- </span></div></td>



                                        <td width="1"><span class="oe_form_group_cell oe_form_group_cell_label">



                                         



                                         <select name="e_time" id="e_time" onchange="totalhrs();" required>



											  <option disabled="disabled">Select End Time</option>



											  

                                              <?

											    if($e_time!=''){

											  ?>

											 <option value="<?=$e_time?>"><?=date('h:i a', strtotime($e_time));?></option>



											 <? 

											  }

											 ?>



											  

                                               <option value="<?=date('Y-m-d');?> 08:30:00">08:30 AM</option>

											   

											  <option value="<?=date('Y-m-d');?> 09:00:00">09:00 AM</option>



											   <option value="<?=date('Y-m-d');?> 09:30:00">09:30 AM</option>



											    <option value="<?=date('Y-m-d');?> 10:00:00">10:00 AM</option>



											   <option value="<?=date('Y-m-d');?> 10:30:00">10:30 AM</option>

											   

											   <option value="<?=date('Y-m-d');?> 11:00:00">11:00 AM</option>



											    <option value="<?=date('Y-m-d');?> 11:30:00">11:30 AM</option>



												 <option value="<?=date('Y-m-d');?> 12:00:00">12:00 PM</option>



												 <option value="<?=date('Y-m-d');?> 12:30:00">12:30 PM</option>



												  <option value="<?=date('Y-m-d');?> 13:00:00">01:00 PM</option>



												   <option value="<?=date('Y-m-d');?> 13:30:00">01:30 PM</option>



												     <option value="<?=date('Y-m-d');?> 14:00:00">02:00 PM</option>



													 <option value="<?=date('Y-m-d');?> 14:30:00">02:30 PM</option>



													 <option value="<?=date('Y-m-d');?> 15:00:00">03:00 PM</option>



													 



													   <option value="<?=date('Y-m-d');?> 15:30:00">03:30 PM</option>



													   <option value="<?=date('Y-m-d');?> 16:00:00">04:00 PM</option>



													    <option value="<?=date('Y-m-d');?> 16:30:00">04:30 PM</option>



														<option value="<?=date('Y-m-d');?> 17:00:00">05:00 PM</option>



														<option value="<?=date('Y-m-d');?> 17:30:00">05:30 PM</option>



														<option value="<?=date('Y-m-d');?> 18:00:00">06:00 PM</option>
											 </select>



											 



                                          </span>										  </td>



                                        <td>



										



 										   &nbsp;&nbsp;<b id="total_leave"> Total <input type="text" name="total_hrs" id="total_hrs" value="<? if($total_hrs) echo $total_hrs;?>" style="width:5px;"  readonly=""/>



                                          Hrs (Max 3 Hrs)



                                          </b></td>
                                      </tr>



                                    </table></td>
                                </tr>



								



								<tr class="oe_form_group_row">



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;Leave&nbsp;Date : </td>



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



                                    <?php do_calander('#half_leave_date');?>



                                    <input  name="half_leave_date" type="date" id="half_leave_date" value="<?php if($half_leave_date) echo $half_leave_date; ?>" required/></td>
                                </tr>



                                <tr class="oe_form_group_row">



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Reason :</td>



                                  <td class="oe_form_group_cell" colspan="4"><span class="oe_form_group_cell oe_form_group_cell_label">



                                    <textarea name="reason" style="width:500px;" required><?=$reason?></textarea>



                                  </span></td>
                                </tr>



                                <tr class="oe_form_group_row">



                                  <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Supporting Doc: </td>



                                  <td colspan="4" bgcolor="#E8E8E8" class="oe_form_group_cell"><input type="file" name="att_file" /><input type="hidden" name="total_days" value="1"></td>
                                </tr>



								<tr class="oe_form_group_row">



                                  <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Submission Date: </td>



                                  <td colspan="4" bgcolor="#E8E8E8" class="oe_form_group_cell"><input type="date" name="leave_apply_date" id="leave_apply_date" value="<?=$leave_apply_date?>" required /></td>
                                </tr>



                                



								







                                <tr class="oe_form_group_row">
                                  <td  bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Substitute Associate : </td>
                                  <td  bgcolor="#E8E8E8" class="oe_form_group_cell" colspan="4"><select name="leave_responsibility_name" id="leave_responsibility_name" style="width:420px;" >



								<? 



								   $emp_id = find_a_field('hrm_leave_info','PBI_ID','id='.$_REQUEST['id']);



								  $dept = find_a_field('personnel_basic_info','PBI_DEPARTMENT','PBI_ID='.$emp_id); 



								  $projec_t = find_a_field('personnel_basic_info','JOB_LOCATION','PBI_ID='.$emp_id); 



								  



								  if($emp_id>0){



								  if($projec_t>0){



								  foreign_relation('personnel_basic_info p, designation d','p.PBI_ID','concat(p.PBI_NAME," :: ",d.DESG_DESC)',$leave_responsibility_name,'p.PBI_DESIGNATION=d.DESG_ID and p.PBI_JOB_STATUS="In Service" and p.JOB_LOCATION="'.$projec_t.'" and p.PBI_ID not in (8,9,25)  and p.PBI_ID != '.$emp_id.' order by p.PBI_NAME');



								    }else{



									 foreign_relation('personnel_basic_info p, designation d','p.PBI_ID','concat(p.PBI_NAME," :: ",d.DESG_DESC)',$leave_responsibility_name,'p.PBI_DESIGNATION=d.DESG_ID and p.PBI_JOB_STATUS="In Service"  and p.PBI_DEPARTMENT="'.$dept.'" and p.PBI_ID not in (8,9,25) and p.PBI_ID != '.$emp_id.' order by p.PBI_NAME');



									 }



									 }



									else{



									



									



								  $dept2 = find_a_field('personnel_basic_info','PBI_DEPARTMENT','PBI_ID='.$_SESSION['employee_selected']); 



								  $projec_t2 = find_a_field('personnel_basic_info','JOB_LOCATION','PBI_ID='.$_SESSION['employee_selected']);



									 



									 if($projec_t2>0){



									  foreign_relation('personnel_basic_info p, designation d','p.PBI_ID','concat(p.PBI_NAME," :: ",d.DESG_DESC)',$leave_responsibility_name,'p.PBI_DESIGNATION=d.DESG_ID and p.PBI_JOB_STATUS="In Service" and p.JOB_LOCATION="'.$PBI->JOB_LOCATION.'" and p.PBI_ID not in (8,9,25) and p.PBI_ID != '.$_SESSION['employee_selected'].' order by p.PBI_NAME');                                     }else{



									   foreign_relation('personnel_basic_info p, designation d','p.PBI_ID','concat(p.PBI_NAME," :: ",d.DESG_DESC)',$leave_responsibility_name,'p.PBI_DESIGNATION=d.DESG_ID and p.PBI_JOB_STATUS="In Service" and p.PBI_DEPARTMENT="'.$PBI->PBI_DEPARTMENT.'" and p.PBI_ID not in (8,9,25) and p.PBI_ID != '.$_SESSION['employee_selected'].' order by p.PBI_NAME');



									  }



									



									}



								  ?>



								  



                                    </select>
                                    <input type="hidden" name="reporting_auth" value="<?=find_a_field('essential_info','ESSENTIAL_REPORTING','PBI_ID='.$_SESSION['user']['id'])?>" />                                
                                <tr class="oe_form_group_row">



                                  <td  bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;Approve/Not Approve Note</td>



                                  <td  bgcolor="#E8E8E8" class="oe_form_group_cell" colspan="4"><span class="oe_form_group_cell oe_form_group_cell_label">
                                    <textarea name="reporting_note" id="reporting_note" style="width:500px;" ><?=$reporting_note?>
                                    </textarea>
                                  </span>
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



                             



							  <? if(isset($_GET[$unique]) && $_SESSION['employee_selected']==$PBI_IN_CHARGE){?>



                              <span class="oe_form_buttons_edit" style="display: inline;">



                              <button name="reportingAuthority" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Approve</button>



                              </span>



							   <span class="oe_form_buttons_edit" style="display: inline;">



                              <button name="not_approve" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Not Approve</button>



                              </span>



                              <? }?>



							  <? if(isset($_GET[$unique]) && $PBI_DEPT_HEAD==$_SESSION['employee_selected']){?>



                              <span class="oe_form_buttons_edit" style="display: inline;">



                              <button name="departmentHead" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Approve</button>



                              </span>



							  <span class="oe_form_buttons_edit" style="display: inline;">



                              <button name="delete" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">No Approve</button>



                              </span>



                              <? }?>



							  



							  <?



								   if($status == 'PENDING'){



								?>



								



								 <? if(isset($_GET[$unique]) && $PBI_ID==$_SESSION['employee_selected']){?>



                              <span class="oe_form_buttons_edit" style="display: inline;">



                              <button name="update" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Update</button>



                              </span>



							  <span class="oe_form_buttons_edit" style="display: inline;">



                              <button name="delete" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Cancel</button>



                              </span>



                              <? }?>



							  



							  <? if(isset($_GET[$unique])){?>



                              



                              <? } } ?>



							  



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

		

		











<script type="text/javascript">



$(document).ready(function(){







 $("#MATERNITY_LEAVE_LEVEL1").hide();



   $("#MATERNITY_LEAVE_INPUT1").hide();



 $('#leave_type').click(function(){



  var num =$("#leave_type").val();



   if(num=="MATERNITY"){



   $("#MATERNITY_LEAVE_LEVEL1").show();



   $("#MATERNITY_LEAVE_INPUT1").show();



    



   }



   else{



    $("#MATERNITY_LEAVE_LEVEL1").hide();



    $("#MATERNITY_LEAVE_INPUT1").hide();



     $("#materlan_count_level").hide();



   $("#materlan_count_input").hide();



   }



 });



 



 



  $('#MATERNITY_past').click(function(){



  var num =$("#MATERNITY_past").val();



   if(num=="yes"){



   $("#materlan_count_level").show();



   $("#materlan_count_input").show();



    



   }



   else{



    $("#materlan_count_level").hide();



   $("#materlan_count_input").hide();



   }



 });



 



  $("#materlan_count").change(function (){



    var materlan_count =  $("#materlan_count").val();



	



  if(materlan_count==2){



    alert("You are not Eligible for this Leave.");



	$('button[type="submit"]').attr('disabled','disabled');



  }else{



  $('button[type="submit"]').removeAttr('disabled');



  }



   



  });



   



  $("#e_date").change(function (){



     var from_leave = $("#s_date").datepicker('getDate');



     var to_leave = $("#e_date").datepicker('getDate');



    var days   = ((to_leave - from_leave)/1000/60/60/24)+1;







	$("#total_days").val(days);



	



	$("#total_leave").text(' Total  '+ days +'  Days ');



  });



    



    



  



});







  function totalhrs(){



	  var sTime = $("#s_time").val();



	  var eTime = $('#e_time').val();



	  var t1 = Date.parse(sTime);



	  var t2 = Date.parse(eTime);



	  document.getElementById('total_hrs').value = parseFloat(((t2-t1)/60)/60000);







  }



         					  



 



</script>

<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>

<?  include_once("../../template/footer.php");   ?>