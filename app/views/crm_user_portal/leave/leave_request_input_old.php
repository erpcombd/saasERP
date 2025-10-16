<?php



@//



//




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 



$title='Leave Application Form';			// Page Name and Page Title



$page="leave_request_input.php";		// PHP File Name



$root='leave';



$table='hrm_leave_info';		// Database Table Name Mainly related to this page



$unique='id';			// Primary Key of this Database table

$shown='type';				// For a New or Edit Data a must have data field

$g_s_date=date('Y-01-01');

$g_e_date=date('Y-12-31');

do_calander('#leave_apply_date');







$unique_name = md5(uniqid(rand(), true));	




// ::::: End Edit Section :::::



// ::::: End Edit Section :::::





$crud=new crud($table);



if($_GET[$unique]>0)



$$unique = $_GET[$unique];



else



$$unique = $_POST[$unique];


$u_id=$_SESSION['user']['id'];

$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);

$leave_id = find_all_field('hrm_leave_info','','id='.$_GET['id']);

$_SESSION['employee_selected'] = $PBI_ID;

$user = find_all_field('personnel_basic_info','','PBI_ID='.$leave_id ->PBI_ID);

$max_id = find_a_field('hrm_leave_info','max(id)','1');

$max_id = $max_id+1;

$PBI = find_all_field('personnel_basic_info','','PBI_ID='.$PBI_ID);

$leave_status = find_a_field('hrm_leave_info','leave_status','id='.$_REQUEST['id']);

$incharge_status = find_a_field('hrm_leave_info','incharge_status','id='.$_REQUEST['id']);



$this_year = date('Y-01-01');

if($_GET['id']>0){

if(($user->EMPLOYMENT_TYPE=='Permanent' || $user->EMPLOYMENT_TYPE=='Temporary-Permanent') && $user->PBI_DOC!=''){

if($user->PBI_DOC<$this_year){

$date1 = $this_year;

}else{

$date1 = $user->PBI_DOC;

}

$date2 = date('Y-m-d');

$diff = abs(strtotime($date2) - strtotime($date1));

$years = floor($diff / (365*60*60*24));

$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));

$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

$approved_month = $months;

$granted_leave = $months*1.25;

}else{

$granted_leave = 0;

}



}else{



if(($PBI->EMPLOYMENT_TYPE=='Permanent' || $PBI->EMPLOYMENT_TYPE=='Temporary-Permanent') && $PBI->PBI_DOC!=''){

if($PBI->PBI_DOC<$this_year){

$date1 = $this_year;

}else{

$date1 = $PBI->PBI_DOC;

}

$date2 = date('Y-m-d');

$diff = abs(strtotime($date2) - strtotime($date1));

$years = floor($diff / (365*60*60*24));

$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));

$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

$approved_month = $months;

$granted_leave = $months*1.25;

}else{

$granted_leave = 0;

}

}



                     //For Mailing







$reporting = find_a_field('essential_info','ESSENTIAL_REPORTING','PBI_ID='.$PBI->PBI_ID);







$reporting_data = find_all_field('personnel_basic_info','','PBI_ID='.$reporting);







$leave_name = find_a_field('hrm_leave_type','leave_type_name','id='.$_POST['type']);



$_REQUEST['s_date']= date('Y-m-d',strtotime($_REQUEST['s_date']));







$_REQUEST['e_date']= date('Y-m-d',strtotime($_REQUEST['e_date']));

$user_leave_rull = find_all_field('hrm_leave_rull_manage','','id='.$PBI->LEAVE_RULE_ID);

if($leave_id>0){







$leave_d = find_all_field('personnel_basic_info','','PBI_ID='.$leave_id->PBI_ID);







$interval = date_diff(date_create(date('Y-m-d')), date_create($leave_d->PBI_DOJ));







	







		 $interval->format("%Y Year, %M Months, %d Days");







		 $total_service_days = $interval->format('%a');







		 }else{







		   







$interval = date_diff(date_create(date('Y-m-d')), date_create($PBI->PBI_DOJ));







	







		 $interval->format("%Y Year, %M Months, %d Days");







		 $total_service_days = $interval->format('%a');





		 }







 $my_leave=mysqli_fetch_object(db_query("select * from hrm_leave_info where PBI_ID='".$_SESSION['employee_selected']."' and s_date='".$_REQUEST['s_date']."' and e_date='".$_REQUEST['e_date']."'"));









$prev_lv=mysqli_num_rows(db_query("select * from hrm_leave_info where incharge_status='Approve' and leave_status='Granted' and PBI_ID='".$_SESSION['employee_selected']."' and s_date between '".$_REQUEST['s_date']."' and '".$_REQUEST['e_date']."'"));





$leave_days_annual = find_a_field('hrm_leave_info','sum(total_days)','PBI_ID="'.$_SESSION['employee_selected'].'" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'" and leave_status="Approve" ');



$balance_leave_days = $granted_leave-$leave_days_annual;



$today_date = date('Y-m-d');



//echo $user_leave_rull->MED. ' OK '.$_POST['type']. ' lv '.$leave_days_sick;



 if(isset($_POST['insert']))







{





if($prev_lv>0){







$msggg= "<h2 style='color:#FF0000'>You Can't Add Same Leave Twice</h2>";







}





elseif(($_POST['type']==1) && ($_POST['total_days']>$balance_leave_days)){







$msggg= "<h2 style='color:#FF0000'>Your Leave Balance Overflow. Please Check Your Earned Leave Days</h2>";







}





else{		



$now= time();





$projectId = array(2,3,4,5);



$_REQUEST['PBI_IN_CHARGE'] = $essentialInfo->ESSENTIAL_REPORTING;





$_REQUEST['entry_at'] = date('Y-m-d H:i:s');







$_REQUEST['s_date']= date('Y-m-d',strtotime($_REQUEST['s_date']));







$_REQUEST['e_date']= date('Y-m-d',strtotime($_REQUEST['e_date']));







$_REQUEST['leave_join_date']= date('Y-m-d',strtotime($_REQUEST['leave_join_date']));





//$_REQUEST['leave_status'] = 'HRM UNCHECKED';







if($_FILES['att_file']['tmp_name']!=''){







			$file_name= $_FILES['att_file']['name'];







			$file_tmp= $_FILES['att_file']['tmp_name'];







			$ext=end(explode('.',$file_name));







			$path='../file/leave_file/';







			move_uploaded_file($file_tmp, $path.$max_id.'.'.$ext);







			$_REQUEST['att_file'] = $max_id.'.'.$ext;







			}

$crud->insert();









//move_uploaded_file($_FILES["att_file"]["tmp_name"], '../../'.$target_file);

$type=1;







$msg='New Entry Successfully Inserted.';



//$to = $reporting_mail;







$str ="<span style='font-weight:bold; font-size:16px;'>Leave applied for</span><br>";







//$str.='<a href="http://aksiderp.com/144133/user_mod/pages/leave/view_leave_incharge.php" style="font-size:16px;">Approve Now</a>';

$str.='<table width="100%" border="1" cellspacing="1" cellpadding="1">

 







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



  







   $ss = "select l.id as leave_id,p.PBI_ID,p.PBI_NAME, desg.DESG_DESC,(select PBI_NAME from personnel_basic_info where PBI_ID=l.leave_responsibility_name) as duties_carried_by, dept.DEPT_DESC, (select PROJECT_DESC from project where PROJECT_ID=p.JOB_LOCATION) as project, l.s_date,l.e_date, l.total_days, t.leave_type_name from personnel_basic_info p, designation desg, department dept, hrm_leave_info l,hrm_leave_type t where 1 and l.s_date='".$_REQUEST['s_date']."' and l.e_date='".$_REQUEST['e_date']."'  and l.PBI_ID=p.PBI_ID and p.PBI_DESIGNATION=desg.DESG_ID and p.PBI_DEPARTMENT=dept.DEPT_ID and l.type=t.id and l.PBI_ID='".$_SESSION['employee_selected']."' ";







	  $query1 = db_query($ss);







	 $data = mysqli_fetch_object($query1);







	 







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







     $str.= '<td>'.date('d-M-Y', strtotime($data->s_date)).'</td>';







	 $str.= '<td>'.date('d-M-Y', strtotime($data->e_date)).'</td>';







	 $str.= '<td>'.$data->total_days.'</td>';







	 $str.= '<td>'.$data->leave_type_name.'</td>';







	 







   $str.= '</tr>';







   







   







  





$headers = "MIME-Version: 1.0\r\n";







$headers .= "Content-Type: text/html; charset=UTF-8\r\n";







$to = $reporting_data->PBI_EMAIL;

//$to = "tanvir@aksidcorp.com";;

$subject = "New Leave Request Pending";







//$txt = " ".$PBI->PBI_NAME." has applied a ".$leave_name." for ".$_POST['total_days']." days";







$headers .= "From: AKSID Human Resources<hr@aksidcorp.com>";







//mail($to,$subject,$str,$headers);

unset($_POST);







unset($$unique);









echo '<script type="text/javascript">parent.parent.document.location.href = "../leave/view_leave.php?notify=12";</script>';

}







}

//for Modify..................................

if(isset($_POST['update']))







{



if($prev_lv>0){







$msggg= "<h2 style='color:#FF0000'>You Can't Add Same Leave Twice</h2>";







}







elseif(($_POST['type']==1) && ($_POST['total_days'])>4){







$msggg= "<h2 style='color:#FF0000'>Casual Leave (CL) will not take more than 4 days<br> (4 দিনের বেশি Casual Leave (CL)  অনুমতি প্রাপ্ত না) </h2>";



}



elseif(($_POST['type']==1) && (($leave_days_casual+$_POST['total_days'])> 15)){







$msggg= "<h2 style='color:#FF0000'>Leave balance overflow.</h2>";







}





elseif( ($_POST['type']==2)  && $_POST['total_days']>2 && $_FILES['att_file']['size'] == 0 ){







$msggg="<h2 style='color:#FF0000'>Medical Certificate is required more than 2 days of sickness







<br> (২ দিনের অতিরিক্ত অসুস্থ থাকলে প্রেসক্রিপশন সংযুক্ত করুন)</h2>";



}





else{		











$extention=explode('.',$_FILES['att_file']['name']);







$extention=strtolower(end($extention));







$target_dir = "file/leave_file/";







$target_file = $target_dir . $$unique.'.'.$extention;

//$_REQUEST['PBI_ID']=$_SESSION['employee_selected'];







//$_REQUEST['leave_status'] = 'PENDING';







//$_REQUEST['leave_status_detail'] = 'Waiting for Replacement';







$_REQUEST['type'] = $_POST['type'];







$_REQUEST['edit_at'] = date('Y-m-d H:i:s');







$_REQUEST['leave_from_date']= date('Y-m-d',strtotime($_REQUEST['leave_from_date']));







$_REQUEST['leave_to_date']= date('Y-m-d',strtotime($_REQUEST['leave_to_date']));







$_REQUEST['leave_join_date']= date('Y-m-d',strtotime($_REQUEST['leave_join_date']));

if($_FILES['att_file']['tmp']!=""){







$_REQUEST['att_file']= $target_file;}

		$crud->update($unique);







		







		move_uploaded_file($_FILES["att_file"]["tmp_name"], '../'.$target_file);







		







		$type=1;







		$msg='Successfully Updated.';







				echo '<script type="text/javascript">







parent.parent.document.location.href = "view_leave.php?notify=12";







</script>';



}



}







//for Delete..................................

if(isset($_POST['not_approve']))







{		unset($_REQUEST);







$_REQUEST['incharge_status'] = 'Not Approve';







$_REQUEST['leave_status'] = '';

$crud->update($unique);











$to = $mmmail;







//$to = $reporting_mail;







$subject = "Leave Request Status";







$txt = "Your requested ".$leave_name." not Approved";







$headers = "From: AKSID Human Resources<hr@aksidcorp.com>";







//mail($to,$subject,$txt,$headers);









echo '<script type="text/javascript">







parent.parent.document.location.href = "../leave/view_leave_incharge.php?notify=12";







</script>';

$type=1;







$msg='Successfully Deleted.';







}

if(isset($_POST['delete']))







{		$condition=$unique."=".$$unique;		$crud->delete($condition);







		unset($$unique);







		echo '<script type="text/javascript">







parent.parent.document.location.href = "view_leave_incharge.php?notify=12";







</script>';







		$type=1;







		$msg='Successfully Deleted.';







}

/*if(isset($_POST['reportingAuthority']))







{		







unset($_REQUEST);







$_REQUEST['type'] = $_POST['type'];







$_REQUEST['leave_status'] = 'Granted';







$_REQUEST['incharge_status'] = 'Approve';







$_REQUEST['s_date'] = $_POST['s_date'];







$_REQUEST['e_date'] = $_POST['e_date'];







$_REQUEST['leave_join_date'] = $_POST['leave_join_date'];







$_REQUEST['total_days'] = $_POST['total_days'];



$_REQUEST['reporting_note'] = $_POST['reporting_note'];







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





   $ss = "select p.PBI_ID,p.PBI_NAME, desg.DESG_DESC,(select PBI_NAME from personnel_basic_info where PBI_ID=l.leave_responsibility_name) as duties_carried_by, dept.DEPT_DESC, (select PROJECT_DESC from project where PROJECT_ID=p.JOB_LOCATION) as project, l.s_date,l.e_date, l.total_days, t.leave_type_name from personnel_basic_info p, designation desg, department dept, hrm_leave_info l,hrm_leave_type t where 1 and l.s_date='".$_REQUEST['s_date']."' and l.e_date='".$_REQUEST['e_date']."'  and l.PBI_ID=p.PBI_ID and p.PBI_DESIGNATION=desg.DESG_ID and p.PBI_DEPARTMENT=dept.DEPT_ID and l.type=t.id and l.PBI_ID='".$leave_id->PBI_ID."' order by l.PBI_ID desc";







	  $query1 = db_query($ss);







	 $data = mysqli_fetch_object($query1);





     $strr.= '<tr align="center">';





     $strr.= '<td>'.$data->PBI_ID.'</td>';





     $strr.= '<td>'.$data->PBI_NAME.'</td>';







     $strr.= '<td>'.$data->DESG_DESC.'</td>';







     $strr.= '<td>'.$data->duties_carried_by.'</td>';







     $strr.= '<td>'.$depp.'</td>';







     $strr.= '<td>'.$data->project.'</td>';







     $strr.= '<td>'.date('d-M-Y', strtotime($data->s_date)).'</td>';







	 $strr.= '<td>'.date('d-M-Y', strtotime($data->e_date)).'</td>';







	 $strr.= '<td>'.$data->total_days.'</td>';







	 $strr.= '<td>'.$data->leave_type_name.'</td>';







   $strr.= '</tr>';







   







   







  





$headers = "MIME-Version: 1.0\r\n";







$headers .= "Content-Type: text/html; charset=UTF-8\r\n";







 $to = "tanvir@aksidcorp.com";







//$to = $reporting_mail;







$subject = "Leave approved from reporting authority";







//$txt = " ".find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$leave_id->reporting_auth)." has approved ".$leave_name." for ".find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$leave_id->PBI_ID)." ";







$headers .= "From: AKSID Human Resources<hr@aksidcorp.com>";







//mail($to,$subject,$strr,$headers);









echo '<script type="text/javascript">







parent.parent.document.location.href = "../leave/view_leave_incharge.php?notify=12";







</script>';

$type=1;







$msg='Successfully Deleted.';







}

*/if(isset($_POST['departmentHead']))







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







foreach ($data as $key => $value)







{ $$key=$value;}







}







if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);











if(isset($_POST['reportingAuthority']))







{



$update = 'update hrm_leave_info set incharge_status="Approve",leave_status="HRM UNCHECKED",type="'.$_POST['type'].'",s_date="'.$_POST['s_date'].'",e_date="'.$_POST['e_date'].'",reason="'.$_POST['reason'].'",leave_join_date="'.$_POST['leave_join_date'].'",reporting_note="'.$_POST['reporting_note'].'",hrm_approved_at="'.date('Y-m-d h:i:s').'",total_days="'.$_POST['total_days'].'" where id="'.$_REQUEST['id'].'"';

db_query($update);



echo '<script type="text/javascript">







parent.parent.document.location.href = "../leave/view_leave_incharge.php?notify=12";







</script>';

$type=1;







$msg='Successfully Updated.';







}

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







   







  







    







    







  







});



 







</script>









<div class="right_col" role="main">   <!-- Must not delete it ,this is main design header-->







          <div class="">







		  







		  







           







        <div class="clearfix"></div>

            <div class="row">







              <div class="col-md-12 col-sm-12 col-xs-12">







                <div class="x_panel">







                  <div class="x_title">







                    <h2></h2>









                    <div class="clearfix"></div>







                  </div>







				  







				  	 <div class="openerp openerp_webclient_container">







                   







			







				  







				  







                  <div class="x_content">



				  



				  



				  



				  <div class="row">



		<div class="col-md-12">



			<div class="panel panel-primary" align="center">



				

                

				<?  if($PBI->incharge_id>0){?>

				<div class="panel-body">





<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">







  <div class="oe_view_manager oe_view_manager_current">







    <div align="right"><? //include('../../common/title_bar.php');?></div>







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







                  <div class="oe_form_sheet oe_form_sheet_width"> <span style=" text-align:center; font-size:12px;" ><?php echo $msggg;  
?></span>

                    <table class="oe_form_group table table-bordered" border="1" cellpadding="0" cellspacing="0">







                      <tbody>







                        <tr class="oe_form_group_row">







                          <td colspan="1" class="oe_form_group_cell" width="100%"><table width="100%" border="0" cellpadding="2" cellspacing="0" class="oe_form_group ">







                              <tbody>







                                







                                <tr class="oe_form_group_row" style="background:#E8E8E8">







                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">







								  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />







                                    <input name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['employee_selected']?>" type="hidden" />







									 <input name="mon" id="mon" value="<?=date('n')?>" type="hidden" />







									  <input name="year" id="year" value="<?=date('Y')?>" type="hidden" />







                                    &nbsp;&nbsp;Leave Types  :</td>









									  <td class="oe_form_group_cell" colspan="4"><select name="type" id="type" style="width:70%" required>

									   <option></option>

									   <? 

									    if($type>0){

										foreign_relation('hrm_leave_type','id','leave_type_name',$type);

										}elseif($PBI->EMPLOYMENT_TYPE=='Non-Permanent'){

										foreign_relation('hrm_leave_type','id','leave_type_name',$type,'id=2');

										}else

										foreign_relation('hrm_leave_type','id','leave_type_name',$type);

									   ?>

									  </select></td>





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







                                        <td width="1"><?php







					  do_calander('#s_date');







					  ?>                            







            







                        <input name="s_date" type="text" id="s_date"  value="<?php if($s_date=='') echo ''; else echo $s_date ; ?>" onkeydown="return false" style="width:150px;;"  required onchange="getData2('leave_ajax.php', 'leave',document.getElementById('s_date').value,document.getElementById('e_date').value)" /></td>







                                        <td width="80"><div align="center"><span class="oe_form_group_cell oe_form_group_cell_label">-to- </span></div></td>







                                        <td width="1"><span class="oe_form_group_cell oe_form_group_cell_label">







                                          <?







 //do_calander('#e_date','-0','+30');

 do_calander('#e_date');







?>







                                          <input name="e_date" type="text" id="e_date"  value="<?php if($e_date=='') echo ''; else echo $e_date ; ?>" style="width:150px;"  onchange="getData2('leave_ajax.php', 'leave',document.getElementById('s_date').value,document.getElementById('e_date').value)" onkeydown="return false" required/>







                                          </span></td>







                                        <td><input type="hidden" value="" name="total_days" id="total_days"/>







                                          <b id="total_leave"> 







                                          <span id="leave"><input type="text" value="<?=find_a_field('hrm_leave_info','total_days','id='.$$unique);?>" name="total_days" id="total_days" readonly="" style="width:30px; border:0px solid $ccc;"/></span>







                                          </b></td>

                                      </tr>







                                    </table></td>

                                </tr>







                                <tr class="oe_form_group_row" style="background:#E8E8E8;">







                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Reason :</td>







                                  <td class="oe_form_group_cell" colspan="4"><span class="oe_form_group_cell oe_form_group_cell_label">







                                    

                                     <input type="text" name="reason" id="reason" value="<?=$reason?>" style="width:70%;"  required />





                                  </span></td>

                                </tr>







                                <tr class="oe_form_group_row">







                                  <td colspan="" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Supporting Doc: </td>







                                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">







								  <table>







								  <tr>







								  <td>







								  <input type="file" name="att_file" id="att_file" /></td>







								     <td>







									 







									 <div  class="btn btn-primary btn-sm"  style="padding: 0px;width: 132px;margin-left: 5px;" >







									 <?







								     if($att_file != ''){







								   ?>







								   <a href="../file/leave_file/<?=$att_file?>" target="_blank" style="color:white;">&nbsp;&nbsp;View Attachment</a>







								   <? } ?>

								   </div>								   </td>

								   </tr>

								   </table>								  </td>

                                </tr>







								<tr class="oe_form_group_row">







                                  <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Submission Date: </td>







                                  <td colspan="4" bgcolor="#E8E8E8" class="oe_form_group_cell"><input type="text" name="leave_apply_date" id="leave_apply_date" value="<?=$leave_apply_date?>" style="width:70%;"  required /></td>

                                </tr>







                                <tr class="oe_form_group_row" style="background:#E8E8E8;">







                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Joining Date After Leave: </td>







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









                                    <?php do_calander('#leave_join_date');?>







                                    <input  name="leave_join_date" type="text" id="leave_join_date" value="<?php if($leave_join_date) echo $leave_join_date; ?>" style="width:70%;" onclick="altmsg()"  required /></td>

                                </tr>







                                







                                <tr class="oe_form_group_row">

                                  <td  bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Substitute Associate : </td>

                                  <td  bgcolor="#E8E8E8" class="oe_form_group_cell" colspan="4"><select name="leave_responsibility_name" id="leave_responsibility_name" style="width:70%;" ><option><option>

                                    <? 







$emp_id = find_a_field('hrm_leave_info','PBI_ID','id='.$_REQUEST['id']);

$dept = find_a_field('personnel_basic_info','DEPT_ID','PBI_ID='.$emp_id);



if($emp_id>0){



foreign_relation('personnel_basic_info p, designation d','p.PBI_ID','concat(p.PBI_NAME," :: ",d.DESG_DESC)',$leave_responsibility_name,'p.DESG_ID=d.DESG_ID and p.PBI_JOB_STATUS="In Service"  and p.DEPT_ID="'.$dept.'" and p.PBI_ID != '.$emp_id.' order by p.PBI_NAME');

 }

else

{

$dept2 = find_a_field('personnel_basic_info','DEPT_ID','PBI_ID='.$_SESSION['employee_selected']);

foreign_relation('personnel_basic_info p, designation d','p.PBI_ID','concat(p.PBI_NAME," :: ",d.DESG_DESC)',$leave_responsibility_name,'p.DESG_ID=d.DESG_ID and p.PBI_JOB_STATUS="In Service" and p.DEPT_ID="'.$PBI->DEPT_ID.'" and p.PBI_ID != '.$_SESSION['employee_selected'].' order by p.PBI_NAME');

}







								  ?>

                                  </select>

                                    <input type="hidden" name="reporting_auth" value="<?=$PBI->incharge_id?>" />                                

                                

                                </tbody>







                          </table></td>







						 







                        </tr>

						

						

						

						







                        <tr>







                          <td><div align="center">







                              <? if(!isset($_GET[$unique])){?>







                              <span class="oe_form_buttons_edit" style="display: inline;">







                              <button name="insert" id="insert" onclick="notempty()" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Apply</button>







                              </span>







                              <? }?>







                             







							  <? if(isset($_GET[$unique]) && $_SESSION['employee_selected']==$leave_id->reporting_auth){?>







                              <span class="oe_form_buttons_edit" style="display: inline;">







                              <button name="reportingAuthority" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Approve</button>







                              </span>







							  <span class="oe_form_buttons_edit" style="display: inline;">







                              <button name="not_approve" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Not Approve</button>







                              </span>







                              <? }?>







							







							  







							    







								 <?







							     if($leave_status =='Pending' && $incharge_status=='Pending'){







							  ?>





							   <? if(isset($_GET[$unique]) && $PBI_ID==$_SESSION['employee_selected']){?> 







                              <span class="oe_form_buttons_edit" style="display: inline;">







                              <button name="update" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Update</button>







                              </span>







							  <span class="oe_form_buttons_edit" style="display: inline;">







                              <button name="delete" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Cancel</button>







                              </span>







                              <? } }?>







                            </div></td>







                        </tr>







                      </tbody>







                    </table>







					









					  <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#ccc">

    <?







	  





if($_REQUEST['id']>0){

$emp_id = find_a_field('hrm_leave_info','PBI_ID','id='.$_REQUEST['id']);

}else{

$emp_id = $_SESSION['employee_selected'];

}



$leave_days_annual=find_a_field('hrm_leave_info','sum(total_days)','type in (1) and leave_status="Approve" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$emp_id);

$leave_days_lwp= find_a_field('hrm_leave_info','sum(total_days)','type=2 and leave_status="Approve" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$emp_id);

$this_year = date('Y-01-01');

if($_GET['id']>0){

if(($user->EMPLOYMENT_TYPE=='Permanent' || $user->EMPLOYMENT_TYPE=='Temporary-Permanent') && $user->PBI_DOC!=''){

if($user->PBI_DOC<$this_year){

$date1 = $this_year;

}else{

$date1 = $user->PBI_DOC;

}

$date2 = date('Y-m-d');

$diff = abs(strtotime($date2) - strtotime($date1));

$years = floor($diff / (365*60*60*24));

$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));

$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

$approved_month = $months;

$granted_leave = $months*1.25;

}else{

$granted_leave = 0;

}



}else{



if(($PBI->EMPLOYMENT_TYPE=='Permanent' || $PBI->EMPLOYMENT_TYPE=='Temporary-Permanent') && $PBI->PBI_DOC!=''){

if($PBI->PBI_DOC<$this_year){

$date1 = $this_year;

}else{

$date1 = $PBI->PBI_DOC;

}

$date2 = date('Y-m-d');

$diff = abs(strtotime($date2) - strtotime($date1));

$years = floor($diff / (365*60*60*24));

$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));

$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

$approved_month = $months;

$granted_leave = $months*1.25;

}else{

$granted_leave = 0;

}

}



$leave_balance = $granted_leave-$leave_days_annual;

	  ?>







	

    <tr>

      <td colspan="11"  bgcolor="#FFFFFF" style="background:#2299C3; color:#FFFFFF;"><div align="center" class="style1">Leave Status of <?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$emp_id)?> for <?php echo date('Y')?></div></td>







    </tr>



    <tr style="background:#f1f1f0" height="60">

      <td width="118" align="center" valign="middle"><strong><span class="style10"><div align="center" style="margin-top:15px">Type</div></span></strong></td>

      

      

      <td width="98" align="center" valign="middle"><div align="center" style="margin-top:13px"><strong><span class="style10"><div align="center">Annual Leave (AL)</div></span></strong></div></td>

	  

	  <td width="98" align="center" valign="middle"><div align="center" style="margin-top:13px"><strong><span class="style10"><div align="center">Leave Without Pay</div></span></strong></div></td>



    </tr>





    <tr>

      <td width="118" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4"><strong>Entitlement</strong></span></div></td>

      <td width="101" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">

        <?=$granted_leave?>

      </span></div></td>

      <td width="130" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">

        

      </span></div></td>

      

    </tr>

   





	

	







	<tr>

      <td width="118" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4"><strong>Availed</strong></span></div></td>

      <td width="101" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">

        <?=$leave_days_annual?>

      </span></div></td>

      <td width="130" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">

        <?=$leave_days_lwp?>

      </span></div></td>

    </tr>







	







	<tr style="font-weight:bold;">

      <td width="118" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"><strong>Balance</strong></span></div></td>

      <td width="101" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">

        <?=$leave_balance?>

      </span></div></td>

      <td width="130" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">

       

      </span></div></td>

    </tr>







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



<? }else{?>



<div style="color:#FF0000; font-weight:bold;">Your Reporting Boss Not Yet Set. Please Contact With HR Department</div>



<? } ?>



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



//



//



require_once SERVER_CORE."routing/layout.bottom.php";



?>







<?  include_once("../../template/footer.php");   ?>







