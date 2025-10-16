<?php




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 

$title='Application for Outside Duty';			// Page Name and Page Title

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







$u_id=$_SESSION['user']['id'];

$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);

$PBI = find_all_field('personnel_basic_info','','PBI_ID='.$PBI_ID);

$_SESSION['employee_selected'] = $PBI_ID;





//$PBI = find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);

$essentialInfo = find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);

$status = find_a_field('hrm_leave_info','leave_status','id='.$_REQUEST['id']);

$leave_id = find_all_field('hrm_od_info','','id='.$_REQUEST['id']);









if(isset($_POST['insert']))

{







if($_POST['type']!=4){

$s_time_check = explode(':',$_POST['s_time']);

$e_time_check = explode(':',$_POST['e_time']);



if($s_time_check[1]=='' || $e_time_check[1]==''){

$msggg = '<span style="color:red;font-weight:bold; font-size:16px;">Opps! Time Format Not Valid</span>';

}elseif($_POST['s_time_format']=='' || $_POST['e_time_format']=='' ){

$msggg = '<span style="color:red;font-weight:bold; font-size:16px;">Opps! AM/PM  must not be empty</span>';





/*}elseif($_POST['total_days']==''){  

$msggg= "<h2 style='color:#FFF;background-color:#50A3B9' class='alert alert-danger'>Opps! Select Od date Again</h2>";*/



}else{

$now= time();

$extention=explode('.',$_FILES['att_file']['name']);

$extention=strtolower(end($extention));

$target_dir = "picture/leave_files/";

$target_file = $target_dir . $$unique.'.'.$extention;

$projectId = array(2,3,4,5);

//$_REQUEST['PBI_ID']=$_SESSION['employee_selected'];

$_POST['PBI_IN_CHARGE']=$PBI->incharge_id; // $essentialInfo->ESSENTIAL_REPORTING;

if(in_array($essentialInfo->ESSENTIAL_PROJECT, $projectId)){

$_REQUEST['PBI_DEPT_HEAD'] = 111659;}







if($_POST['s_time_format'] == 'PM'){

$s_new_time = $s_time_check[0]+12;

$_REQUEST['s_time_int'] = $s_new_time.':'.$s_time_check[1];

}else{

$_REQUEST['s_time_int'] = $_POST['s_time'];

}



if($_POST['e_time_format'] == 'PM'){



$e_new_time = $e_time_check[0]+12;

$_REQUEST['e_time_int'] = $e_new_time.':'.$e_time_check[1];

}else{

$_REQUEST['e_time_int'] = $_POST['e_time'];



}

$_REQUEST['od_status'] = "Pending";



$_REQUEST['half_or_full'] = "od";



$_POST['entry_at'] = date('Y-m-d H:i:s');

$_POST['entry_by'] = $PBI->PBI_ID;



//$_REQUEST['s_date']= date('Y-m-d',strtotime($_REQUEST['s_date']));



//$_REQUEST['e_date']= date('Y-m-d',strtotime($_REQUEST['e_date']));





//$_REQUEST['leave_join_date']= date('Y-m-d',strtotime($_REQUEST['leave_join_date']));



if($_FILES['att_file']['tmp_name']!=""){

$_REQUEST['att_file']= $target_file;



}



unset($_REQUEST['id']);



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



unset($_REQUEST['id']);





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
$_POST['od_status'] = 'Pending';
$_POST['incharge_status'] = 'Approve';
$_REQUEST['s_time'] = $_POST['s_time'];
$_REQUEST['e_time'] = $_POST['e_time'];
$_REQUEST['total_hrs'] = $_POST['total_hrs'];
$_POST['auth_date'] = date('Y-m-d');
//$_POST['reporting_auth'] = $PBI->incharge_id;
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
$_POST['od_status'] = '';
$_POST['incharge_status'] = 'Not Approve';
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
$_POST['od_status'] = 'Granted';
$_POST['s_time'] = $_POST['s_time'];
$_POST['e_time'] = $_POST['e_time'];
$_POST['total_hrs'] = $_POST['total_hrs'];

$from_date=strtotime($_POST['s_date']);
$to_date=strtotime($_POST['e_date']);

$iom_start_time =  date("H:i:s",strtotime($_POST['s_time']));

$iom_end_time   =  date("H:i:s",strtotime($_POST['e_time']));

$crud->update($unique);


/*OD AUTOMATION FOR HRM ATD SUMMART START*/

$full_leave = find_all_field('hrm_od_info','','id='.$leave_id->id);



$iom_sl_no=  db_insert_id();
for($i=$from_date; $i<=$to_date; $i=$i+86400)
{
$att_date=date('Y-m-d',$i);
$found = find_a_field('hrm_att_summary','iom_id','emp_id="'.$full_leave->PBI_ID.'" and att_date="'.$att_date.'"');
if($found==0)
{


$sql="INSERT INTO hrm_att_summary (emp_id, iom_type, iom_sl_no, iom_reason, att_date,iom_start_time,iom_end_time,iom_id, iom_entry_at, iom_entry_by, dayname)
VALUES ('$leave_id->PBI_ID','Full', '$full_leave->id', '$full_leave->reason', '$att_date', '$iom_start_time' , '$iom_end_time','$full_leave->id', '$full_leave->entry_at', '$full_leave->entry_by', dayname('".$att_date."'))";
$query=db_query($sql);
}
else
{
$sql='update hrm_att_summary set iom_type="Full", iom_sl_no="'.$full_leave->id.'", iom_start_time="'.$iom_start_time.'", iom_end_time="'.$iom_end_time.'", iom_id="'.$full_leave->id.'",
iom_reason="'.$full_leave->reason.'", dayname=dayname("'.$att_date.'") ,iom_entry_at="'.$full_leave->entry_at.'", 
iom_entry_by="'.$full_leave->entry_by.'"

where  emp_id="'.$leave_id->PBI_ID.'" and att_date="'.$att_date.'" ';
$query=db_query($sql);
}

} 


/*OD AUTOMATION FOR HRM ATD SUMMART END*/




echo '<script type="text/javascript">
parent.parent.document.location.href = "../od/view_od_hrm.php?notify=12";
</script>';
$type=1;

$msg='Successfully Deleted.';

}















if(isset($_POST['not_granted']))















{	







unset($_REQUEST);	















$_POST['od_status'] = 'Not Granted';















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















foreach ($data as $key => $value)















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













tr:nth-child(odd){
    background-color: #fafafa !important;
}
tr:nth-child(Even){
    background-color: #fafafa !important;
}
tr td,tr{
    border: 0px !important;
    background-color: #FFFFFF;
}


</style>

<script src="sweetalerts/sweetalert2.min.js"></script>

<script src="sweetalerts/promise-polyfill.js"></script>

<link href="sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />

<link href="sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />

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







Swal.fire({

  title: 'OPPS....',

  text: "Please submit valid time format 00:00",

  icon: 'warning',

  //showCancelButton: true,

  confirmButtonColor: '#3085d6',

  cancelButtonColor: '#d33',

  confirmButtonText: 'OK'

}).then((result) => {

 //location.reload();

})

		 //alert('Please submit valid time format (00:00)');







		// location.reload();







		}else if(splitt2[0]>0){

		

  Swal.fire({

  title: 'OPPS....',

  text: "Please submit valid time format 00:00",

  icon: 'warning',

  //showCancelButton: true,

  confirmButtonColor: '#3085d6',

  cancelButtonColor: '#d33',

  confirmButtonText: 'OK'

}).then((result) => {

 //location.reload();

})







		 //alert('Please submit valid time format (00:00)');

         //location.reload();







		}else if(coma[0]>0){

		

		

 Swal.fire({

  title: 'OPPS....',

  text: "Please submit valid time format 00:00",

  icon: 'warning',

  //showCancelButton: true,

  confirmButtonColor: '#3085d6',

  cancelButtonColor: '#d33',

  confirmButtonText: 'OK'

}).then((result) => {

 //location.reload();

})







		//alert('Please submit valid time format (00:00)');

        //location.reload();







		}else if(coma2[0]>0){

		

  Swal.fire({

  title: 'OPPS....',

  text: "Please submit valid time format 00:00",

  icon: 'warning',

  //showCancelButton: true,

  confirmButtonColor: '#3085d6',

  cancelButtonColor: '#d33',

  confirmButtonText: 'OK'

}).then((result) => {

 //location.reload();

})







		//alert('Please submit valid time format (00:00)');

        //location.reload();







		}else if(semi[0]>0){

		

		

		Swal.fire({

		  title: 'OPPS....',

		  text: "Please submit valid time format 00:00",

		  icon: 'warning',

		  //showCancelButton: true,

		  confirmButtonColor: '#3085d6',

		  cancelButtonColor: '#d33',

		  confirmButtonText: 'OK'

		}).then((result) => {

		 //location.reload();

		})







		//alert('Please submit valid time format (00:00)');

        //location.reload();







		}else if(semi2[0]>0){

		

		Swal.fire({

		  title: 'OPPS....',

		  text: "Please submit valid time format 00:00",

		  icon: 'warning',

		  //showCancelButton: true,

		  confirmButtonColor: '#3085d6',

		  cancelButtonColor: '#d33',

		  confirmButtonText: 'OK'

		}).then((result) => {

		 //location.reload();

		})







		//alert('Please submit valid time format (00:00)');

        //location.reload();







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



document.getElementById('companyname').style.display='';

document.getElementById('address2').style.display='';

document.getElementById('notify_market').style.display='';



}







if(status !=1){

document.getElementById('companyname').style.display='none';

document.getElementById('address2').style.display='none';

document.getElementById('notify_market').style.display='none';



}













if(status==2){

document.getElementById('name').style.display='';

document.getElementById('designation1').style.display='';

document.getElementById('companynameOr').style.display='';

document.getElementById('address3').style.display='';

document.getElementById('notify_client').style.display='';

}





if(status !=2){

document.getElementById('name').style.display='none';

document.getElementById('designation1').style.display='none';

document.getElementById('companynameOr').style.display='none';

document.getElementById('address3').style.display='none';

document.getElementById('notify_client').style.display='none';

}















	 















	 if(status==3){















	 















	 //document.getElementById('appointmentwith').style.display='';















	 //document.getElementById('designation').style.display='';















	 document.getElementById('projectname').style.display='';



    document.getElementById('notify_project').style.display='';











	 }















	 















	 if(status !=3){















	 















	 //document.getElementById('appointmentwith').style.display='none';















	 //document.getElementById('designation').style.display='none';





document.getElementById('projectname').style.display='none';

document.getElementById('notify_project').style.display='none';

}



if(status==4){

document.getElementById('place').style.display='';



document.getElementById('time').style.display='none';



document.getElementById('notify_office_tour').style.display='';



}



if(status !=4){



document.getElementById('place').style.display='none';



document.getElementById('time').style.display='';

document.getElementById('notify_office_tour').style.display='none';



}







	 











if(status==5){

document.getElementById('companynameOr2').style.display='';

document.getElementById('destination').style.display='';

document.getElementById('address').style.display='';

document.getElementById('notify_others').style.display='';



}

if(status !=5){

document.getElementById('companynameOr2').style.display='none';

document.getElementById('destination').style.display='none';

document.getElementById('address').style.display='none';

document.getElementById('notify_others').style.display='none';

}



if(status==6){

document.getElementById('name').style.display='';

document.getElementById('designation1').style.display='';

document.getElementById('companynameOr').style.display=''; 

document.getElementById('place').style.display='';

document.getElementById('notify_product_delivery').style.display='';



}





if(status !=6){

document.getElementById('notify_product_delivery').style.display='none';



}





if(status==7){

document.getElementById('daytourtype').style.display='';

document.getElementById('name').style.display='';

document.getElementById('designation1').style.display='';

document.getElementById('companynameOr2').style.display='';

document.getElementById('address').style.display='';

document.getElementById('time').style.display='';

document.getElementById('notify_daytour').style.display='';











}



if(status !=7){  

document.getElementById('daytourtype').style.display='none';

document.getElementById('notify_daytour').style.display='none';







}







}







window.onload = changeType;













</script>









<div class="right_col" role="main">

<!-- Must not delete it ,this is main design header-->

<div class="">

  <div class="clearfix"></div>

  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">

      <div class="x_panel">

        <div class="x_title">

         

          

          <div class="clearfix"></div>

        </div>

        <div class="openerp openerp_webclient_container">

          <div class="x_content">

            <div class="row">

              <div class="col-md-12">

                <div class="panel panel-primary" align="center">

                  <div class="panel-heading">

                    <h3 class="panel-title">

                      <?=$test[1];?>

                    </h3>

                  </div>

                  <div class="panel-body">

                    <form action="" method="post" enctype="multipart/form-data" autocomplete="off">

                      <div class="oe_view_manager oe_view_manager_current">

                        <? //include('../../common/title_bar_od_new.php');?>

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

									  

                                        <table class="table table-sm">

                                          <tr class="oe_form_group_row" id="notify_market" style="display:none">

                                            <td class="oe_form_group_cell" colspan="4" style="text-align: center;">

											   <div class="alert alert-info" role="alert">

												 Market Visit/Purchase is for any kind of purchases/procurements or for any gift purchases.					

												 <br> মার্কেট ভিজিট/ পারচেজ্ হল যেকোনো ধরনের কেনাকাটা/প্রকিউরমেন্ট বা উপহার কেনার জন্য।

												</div>

																							

											</td>

                                          </tr>

										  

										  

										  <tr class="oe_form_group_row" id="notify_client" style="display:none">

                                            <td class="oe_form_group_cell" colspan="4" style="text-align: center;">

											<div class="alert alert-info" role="alert">

											Client Visit is a visit to any Client at normal office time.				

 <br> ক্লায়েন্ট ভিজিট হল সাধারণ অফিস টাইমে ক্লায়েন্টের কাছে ভিজিট করা।</div>

											</td>

                                          </tr>

										  

										  

										  <tr class="oe_form_group_row" id="notify_project" style="display:none">

                                            <td class="oe_form_group_cell" colspan="4" style="text-align: center;">

											 <div class="alert alert-info" role="alert">

											ERP Project Visit is a visit to the projects that ERP is working for.				

 <br> ERP প্রজেক্ট ভিজিট হল ERP যে প্রোজেক্টের জন্য কাজ করছে সেগুলি ভিজিট করতে যাওয়া।</div>

											</td>

                                          </tr>

										  

										  

										  <tr class="oe_form_group_row" id="notify_product_delivery" style="display:none">

                                            <td class="oe_form_group_cell" colspan="4" style="text-align: center;">

											 <div class="alert alert-info" role="alert">

Product Delievery is the delivery of products from our stores to our parties/clients . It is mainly for the employees who are working in the store and Logistics Department.				

 <br> প্রোডাক্ট ডেলিভারি হল স্টোর থেকে আমাদের পার্টি/ক্লায়েন্টদের কাছে পণ্যের ডেলিভারি দেওয়া। এটি মূলত কর্মচারীদের জন্য যারা স্টোর এবং লজিস্টিক ডিপার্টমেন্টে কাজ করছেন।</div>

											</td>

                                          </tr>

										  

										  

										  

										  <tr class="oe_form_group_row" id="notify_daytour" style="display:none">

                                            <td class="oe_form_group_cell" colspan="4" style="text-align: center;">

										 <div class="alert alert-info" role="alert">

Day Tour is any tour inside/outside Dhaka that is completed within one day. Day Tour starts at early morning (4:00 am onwards and ends at maximum 11:59 pm).<br>

ডে ট্যুর হল ঢাকার ভিতরে/বাইরে যে কোন ট্যুর যা একদিনের মধ্যে সম্পন্ন হয়। ডে ট্যুর সময়-(ভোর ৪টা থেকে সর্বোচ্চ রাত ১১.৫৯ পর্যন্ত)<br>

Day Tour (Management will check your full Track).<br>

ডে ট্যুর (ম্যানেজমেন্ট আপনার সম্পূর্ণ ট্র্যাক পর্যবেক্ষণ করবে)</div>

											</td>

                                          </tr>

										  

										  

										  <tr class="oe_form_group_row" id="notify_office_tour" style="display:none">

                                            <td class="oe_form_group_cell" colspan="4" style="text-align: center;">

											 <div class="alert alert-info" role="alert">

											Office Tour is any tour outside Dhaka that takes more than one day.<br />				

 অফিস ট্যুর হল ঢাকার বাইরের যেকোনো ট্যুর যা এক দিনের বেশি সময়ের জন্য হয়ে থাকে।</div>

											</td>

                                          </tr>

										  

										  

										   <tr class="oe_form_group_row" id="notify_others" style="display:none">

                                            <td class="oe_form_group_cell" colspan="4" style="text-align: center;">

											 <div class="alert alert-info" role="alert">

											Others are outside duties such as visiting Bank for office, visiting head office for trainings/meetings, etc for employees who work outside Dhaka.  These ODs are miscellaneous and do not fit in with any other types of ODs.<br />				

 Others হল বাইরের ডিউটি যেমন অফিসের কাজে ব্যাংকে যাওয়া, ঢাকার বাইরে কাজ করে এমন কর্মচারীদের ট্রেনিং/মিটিং এর জন্য হেড অফিসে আসা ইত্যাদি। এই OD গুলি বিবিধ এবং অন্য কোন ধরনের OD এর মত না।</div>

											</td>

                                          </tr>

										  

										  

										  

                                        </table>

										

										

										

										

										    <div class="card">

											

										

  

											  <div class="card-body">

    

								

										

                                        <table class="table table-bordered table-sm" border="0" cellpadding="0" cellspacing="0">

                                          <tbody>

                                          

                                          <tr class="oe_form_group_row">

                                            <td colspan="1" class="oe_form_group_cell" width="100%"><table width="100%" border="0" cellpadding="2" cellspacing="0" class="oe_form_group ">

                                                <tbody>

                                                  <tr class="oe_form_group_row">

                                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />

                                                      <input name="PBI_ID" id="PBI_ID" value="<?=$PBI_ID;?>" type="hidden" />

                                                      <input name="year" id="year" value="<?=date('Y')?>" type="hidden" />

                                                      <input name="mon" id="mon" value="<?=date('n')?>" type="hidden" />

                                                      &nbsp;&nbsp;OD Type  :</td>

                                                    <td class="oe_form_group_cell" colspan="4"><select name="type" id="type" onchange="changeType()" style="width:460px" required>

                                                        <?= foreign_relation('od_type','id','type_name',$type,'1 order by type_name');?>

                                                      </select>

                                                    </td>

                                                  </tr>

												  

												  

												  

                                                <?php /*?>  <tr class="oe_form_group_row" id="nameofowner" style="display:none">

                                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Name of Owner  :</td>

                                                    <td class="oe_form_group_cell" colspan="4"><input type="text" name="client_name" value="<?=$client_name?>" id="client_name" style="width:460px" />

                                                    </td>

                                                  </tr><?php */?>

												  

												  

												  

												 <tr class="oe_form_group_row" id="daytourtype" style="display:none">

                                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Day Tour Type :</td>

                                                    <td class="oe_form_group_cell" colspan="4">

												    <select name="daytour_name"  style="width:460px" >

													    <option selected="selected"><?=$daytour_name?></option>

                        <option value="Day Tour (Early Morning & Late Night) 4:00 AM - 7:00 AM to After 8:00 PM">Day Tour (Early Morning & Late Night) 4:00 AM - 7:00 AM to After 8:00 PM</option>

						<option value="Day Tour (Early Morning & Normal Time) 4:00 AM - 7:00 AM to 7:59 PM">Day Tour (Early Morning & Normal Time) 4:00 AM - 7:00 AM to 7:59 PM</option>

						<option value="Day Tour (Normal Time & Late Night) 7:01 AM to After 8:00 PM">Day Tour (Normal Time & Late Night) 7:01 AM to After 8:00 PM</option>

                                                      </select>

                                                    </td>

											

                                                  </tr>

												  

												  

												  

												

												  

												  

												  

                                                  <tr class="oe_form_group_row" id="name" style="display:none">

                                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Client Name  :</td>

                                                    <td class="oe_form_group_cell" colspan="4"><input type="text" name="name" value="<?=$name?>" id="name" style="width:460px" />

                                                    </td>

                                                  </tr>

                                                  <tr class="oe_form_group_row" id="appointmentwith" style="display:none">

                                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Appointment With  :</td>

                                                    <td class="oe_form_group_cell" colspan="4"><input type="text" name="appointment_with" value="<?=$appointment_with?>" id="appointment_with" style="width:460px" />

                                                    </td>

                                                  </tr>

                                                  <!--<tr class="oe_form_group_row" id="designation" style="display:none">















                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">















                                    &nbsp;&nbsp;Designation.  :</td>















                                  <td class="oe_form_group_cell" colspan="4">















								  <input type="text" name="designations" value="<?=$designations?>" id="designations"  />                             </td>















                                </tr>-->

                                                  <tr class="oe_form_group_row" id="designation1" style="display:none">

                                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Client Designation  :</td>

                                                    <td class="oe_form_group_cell" colspan="4"><input type="text" name="designation" value="<?=$designation?>" id="designation" style="width:460px"  />

                                                    </td>

                                                  </tr>

                                                  <tr class="oe_form_group_row" id="companyname" style="display:none">

                                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Company Name  :</td>

                                                    <td class="oe_form_group_cell" colspan="4"><input type="text" name="company_name" id="company_name" value="<?=$company_name?>" style="width:460px" />

                                                    </td>

                                                  </tr>

                                                  <tr class="oe_form_group_row" id="destination" style="display:none">

                                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" style="">&nbsp;&nbsp;OD Purpose  :</td>

                                                    <td class="oe_form_group_cell" colspan="4"><input type="text" name="od_destination" value="<?=$od_destination?>" id="od_destination" style="width:460px" placeholder="Ex. Bank, Head Office,Training"   />

                                                    </td>

                                                  </tr>

                                                  <tr class="oe_form_group_row" id="companynameOr" style="display:none">

                                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Company/Organization Name  :</td>

                                                    <td class="oe_form_group_cell" colspan="4"><input type="text" name="organization" value="<?=$organization?>" id="organization" style="width:460px"  />

                                                    </td>

                                                  </tr>

                                                  <tr class="oe_form_group_row" id="companynameOr2" style="display:none">

                                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Company/Organization Name  :</td>

                                                    <td class="oe_form_group_cell" colspan="4"><input type="text" name="organization2" value="<?=$organization2?>" id="organization" style="width:460px"  />

                                                    </td>

                                                  </tr>

                                                  <tr class="oe_form_group_row" id="place" style="display:none">

                                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" style="">&nbsp;&nbsp;Place/Address  :</td>

                                                    <td class="oe_form_group_cell" colspan="4"><input type="text" name="place" value="<?=$place?>" id="place" style="width:460px"  />

                                                    </td>

                                                  </tr>

                                                  <tr class="oe_form_group_row" id="address" style="display:none">

                                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" style="">&nbsp;&nbsp;Place/Address  :</td>

                                                    <td class="oe_form_group_cell" colspan="4"><input type="text" name="place2" value="<?=$place2?>" id="place" style="width:460px" />

                                                    </td>

                                                  </tr>

                                                  <tr class="oe_form_group_row" id="address2" style="display:none">

                                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" style="">&nbsp;&nbsp;Place/Address  :</td>

                                                    <td class="oe_form_group_cell" colspan="4"><input type="text" name="place3" value="<?=$place3?>" id="place" style="width:460px"  />

                                                    </td>

                                                  </tr>

                                                  <tr class="oe_form_group_row" id="address3" style="display:none">

                                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" style="">&nbsp;&nbsp;Place/Address  :</td>

                                                    <td class="oe_form_group_cell" colspan="4"><input type="text" name="place4" value="<?=$place4?>" id="place" style="width:460px"  />

                                                    </td>

                                                  </tr>

                                                  <tr class="oe_form_group_row" id="projectname" style="display:none">

                                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Project Name  :</td>

                                                    <td class="oe_form_group_cell" colspan="4"><input type="text" name="project_name" value="<?=$project_name?>" id="project_name" style="width:460px" />

                                                    </td>

                                                  </tr>

												  

												 

												  

                                                  <tr class="oe_form_group_row" id="time">

                                                    <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Duration : </td>

                                                    <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell"><table width="100%" border="0">

                                                        <tr>

                                                          <td colspan="1"><input type="text" name="s_time" id="s_time" value="<?=$s_time?>" style="margin-top:4px;" placeholder="Start Time:(ex:10:30)" onBlur="totalhrs();" />

                                                            <input type="hidden" name="s_time1" id="s_time1" value="<? echo date('Y-m-d ');?>"  />

                                                            <input type="hidden" name="test" id="test" />                                                          </td>

                                                          <td colspan="1" width="80"><div align="center"><span class="oe_form_group_cell oe_form_group_cell_label">

                                                              <select name="s_time_format" id="s_time_format"  onBlur="totalhrs();" >

                                                                <option>

                                                                <?=$s_time_format?>

                                                                </option>

                                                                <option>AM</option>

                                                                <option>PM</option>

                                                              </select>-to-

                                                              

															  

															  </span></div></td>

                                                          <td colspan="1"><span class="oe_form_group_cell oe_form_group_cell_label">

                                                            <input type="text" name="e_time" id="e_time" value="<?=$e_time?>"  placeholder="End Time:(ex:04:00)" onBlur="totalhrs();" />

                                                            </span> </td>

                                                          <td width=""><select name="e_time_format" id="e_time_format" style="margin-top:4px;" onBlur="totalhrs();" >

                                                              <option>

                                                              <?=$e_time_format?>

                                                              </option>

                                                              <option>PM</option>

                                                              <option>AM</option>

                                                            </select>

                                                            <b id="total_leave_hrs"> Total

                                                            <input type="text"  name="total_hrs" id="total_hrs" value="<?=$total_hrs?>"   readonly=""/>

                                                            Hrs </b></td>

                                                        </tr>

                                                      </table></td>

                                                  </tr>

												  

												  

                                                  <tr class="oe_form_group_row">

                                                    <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;OD Date : </td>

                                                    <td colspan="4" bgcolor="#E8E8E8" class="oe_form_group_cell"><table width="100%" border="0">

                                                        <tr>

                                                          <td><?php







					  do_calander('#s_date');







					  ?>

                                                            <input name="s_date" type="text" id="s_date" class="form-control" value="<?php if($s_date=='') echo ''; else echo $s_date ; ?>"  required/></td>

                                                          <td width="80"><div align="center"><span class="oe_form_group_cell oe_form_group_cell_label">-to- </span></div></td>

                                                          <td><span class="oe_form_group_cell oe_form_group_cell_label">

                                                            <?







 do_calander('#e_date','-0','+30');







?>

                                                            <input name="e_date" type="text" id="e_date"  value="<?php if($e_date=='') echo ''; else echo $e_date ; ?>"  onchange="getData2('leave_ajax.php', 'leave',document.getElementById('s_date').value,document.getElementById('e_date').value)" required/>

                                                            </span></td>

                                                          <td><input type="hidden" value="" name="total_days" id="total_days"/>

                                                            &nbsp;&nbsp;<b id="total_leave"> <span id="leave">

                                                            <input type="text" value="<?=find_a_field('hrm_od_info','total_days','id='.$$unique);?>" name="total_days" id="total_days" readonly="" 

															style="border:0px solid $ccc;"/>

                                                            </span> </b></td>

                                                        </tr>

                                                      </table></td>

                                                  </tr>

                                                  <tr class="oe_form_group_row">

                                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Reason :</td>

                                                    <td class="oe_form_group_cell" colspan="4"><span class="oe_form_group_cell oe_form_group_cell_label">

                                                      <textarea name="reason" style="width:500px;" required><?=$reason?>

</textarea>

                                                      </span></td>

                                                  </tr>

                                                  <tr class="oe_form_group_row">

                                                    <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Supporting Doc: </td>

                                                    <td colspan="4" bgcolor="#E8E8E8" class="oe_form_group_cell"><input type="file" name="att_file" /></td>

                                                  </tr>

                                                  <tr class="oe_form_group_row">

                                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>

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

                                                      <input  name="od_date" type="hidden" id="od_date" value="<?=date('Y-m-d'); ?>"/>

                                                    </td>

                                                  </tr>

                                              <?php /*?>  <input type="hidden" name="reporting_auth" value="<?=$PBI->incharge_id;?>" /><?php */?>

                                                </tbody>

                                                

                                              </table></td>

                                          </tr>

                                          <tr>

                                            <td><div align="center">

                                                <? if(!isset($_GET[$unique])){?>

                                                <span class="oe_form_buttons_edit" style="display: inline;">

                                                <button name="insert" accesskey="S" class="btn btn-danger" type="submit">Apply</button>

                                                </span>

                                                <? }?>

                                                <? if(isset($_GET[$unique]) && $_SESSION['employee_selected']==$PBI_IN_CHARGE && $incharge_status=='Pending'){?>

                                                <span class="oe_form_buttons_edit" style="display: inline;">

                                                <button name="reportingAuthority" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Approve</button>

                                                </span> <span class="oe_form_buttons_edit" style="display: inline;">

                                                <button name="not_approve" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Not Approve</button>

                                                </span>

                                                <? }?>

                                                <? if(isset($_GET[$unique]) && $_SESSION['employee_selected']==8 && $incharge_status == 'Approve'){?>

                                                <span class="oe_form_buttons_edit" style="display: inline;">

                                                <button name="hrapprove" accesskey="S" class="btn btn-info" type="submit">Granted</button>

                                                </span> <span class="oe_form_buttons_edit" style="display: inline;">

                                                <button name="not_granted" accesskey="S" class="btn btn-danger" type="submit">Not Granted</button>

                                                </span>

                                                <? }?>

                                                <? if($od_status=='Pending' && $incharge_status=='Pending' ){?>

                                                <? if(isset($_GET[$unique]) && $PBI_ID==$_SESSION['employee_selected']){?>

                                                <span class="oe_form_buttons_edit" style="display: inline;">

                                                <button name="update" accesskey="S" class="btn btn-danger" type="submit">Update</button>

                                                </span> <span class="oe_form_buttons_edit" style="display: inline;">

                                                <button name="delete" accesskey="S" class="btn btn-danger" type="submit">Cancel</button>

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



//



//



require_once SERVER_CORE."routing/layout.bottom.php";







?>



