<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
do_calander('#s_date');
do_calander('#e_date');
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';
if($_SESSION['employee_selected']>0)
$emp = find_all_field('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID='.$_SESSION['employee_selected']);
// ::::: Edit This Section ::::: 
$title='Leave Information';			// Page Name and Page Title
$page="leave_entry.php";		// PHP File Name
$input_page="leave_entry_input.php";
$root='leave';

$table='hrm_leave_info';
$unique='id';
$shown='s_date';

// ::::: End Edit Section :::::

$crud      =new crud($table);
if(prevent_multi_submit()){
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];
$_REQUEST['entry_at']=date('Y-m-d H:i:s');
$_REQUEST['leave_status']='GRANTED';
$s_date= strtotime($_REQUEST['s_date']);
$e_date= strtotime($_REQUEST['e_date']);

$old_leave = find_a_field('hrm_att_summary','leave_id',' att_date between "'.$_REQUEST['s_date'].'" and  "'.$_REQUEST['e_date'].'" and  emp_id="'.$_SESSION['employee_selected'].'" and leave_id>0');

if($old_leave == 0)
{

$crud->insert();
$_GET['leave_id'] =  mysqli_insert_id();
$full_leave = find_all_field('hrm_leave_info','','id='.$_GET['leave_id']);



for($i=$s_date; $i<=$e_date; $i+=86400){
if($full_leave->half_or_full=="half")
$leave_duration = '0.5';
else
$leave_duration = '1.0';

$att_date=date('Y-m-d',$i);
$sql="select id from hrm_att_summary where emp_id='".$_POST['PBI_ID']."' and att_date='".$att_date."'";
$query=db_query($sql);
$num_rows=mysqli_num_rows($query);
$data=mysqli_fetch_object($query);
	if($num_rows>0){
	$up_query="update hrm_att_summary set leave_id='".$full_leave->id."', leave_type='".$full_leave->type."', leave_reason='".$full_leave->reason."',leave_duration='".$leave_duration."', leave_approved_by='".$_SESSION['user']['id']."', leave_entry_at='".$full_leave->entry_at."', leave_entry_by='".$full_leave->PBI_ID."' where id=".$data->id;
	db_query($up_query);
	}else{
	$ins_query="INSERT INTO hrm_att_summary( att_date, emp_id, leave_id, leave_type, leave_reason, leave_duration,leave_approved_by, leave_entry_at, leave_entry_by) VALUES ('".$att_date."','".$full_leave->PBI_ID."', '".$full_leave->id."', '".$full_leave->type."', '".$full_leave->reason."','".$leave_duration."', '".$_SESSION['user']['id']."', '".$full_leave->entry_at."', '".$full_leave->PBI_ID."')";
	db_query($ins_query);
	}
}
}
else echo $msggg= "<h2 style='color:#FF0000'>You Can't Add Duplicate Leave</h2>";;
}
}





?>
<script type="text/javascript"> function DoNav(lk){
var win = window.open('leave_entry_input.php?id='+lk, '_blank');
  win.focus();
}</script>
<script type="text/javascript">
$(document).ready(function(){

  $("#e_date").change(function (){
     var from_leave = $("#s_date").datepicker('getDate');
     var to_leave = $("#e_date").datepicker('getDate');
    var days   = ((to_leave - from_leave)/1000/60/60/24)+1;

	if(days>0&&days<100){
	$("#total_days").val(days);}
  });
      $("#s_date").change(function (){
     var from_leave = $("#s_date").datepicker('getDate');
     var to_leave = $("#e_date").datepicker('getDate');
    var days   = ((to_leave - from_leave)/1000/60/60/24)+1;
	if(days>0&&days<100){
	$("#total_days").val(days);}
  });
    
  
});
 
</script>

<style type="text/css">
<!--
.style1 {font-size: 24px}
.style2 {
	color: #FFFFFF;
	font-size: 24px;
	font-weight: bold;
}
-->
</style>


<div class="oe_view_manager oe_view_manager_current">
      <form action="" method="post" enctype="multipart/form-data">  
    <? include('../common/title_bar.php');?>
    </form>
        <form action=""  method="post">

        <div class="oe_view_manager_body">
            
                <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
		     
<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">


<? if($emp->PBI_DOC2<date('Y-m-d')){?>
<?
/*$d22=date("2019-12-31");
$d2 = new DateTime($d22);
$cdate = find_a_field('personnel_basic_info','PBI_DOC2','PBI_ID='.$_SESSION['employee_selected']);
if($cdate > date("2019-12-26") &&  $cdate !='0000-00-00'){
$string = $cdate;
$timestamp = strtotime($string);
$tdate = date("d", $timestamp);
$cd =new DateTime($cdate);
$interval = date_diff($cd, $d2);
if($tdate<16){
$total_leave=$interval->format('%m')*2.5+2.5;
//echo $total_leave;
}else{
$total_leave=$interval->format('%m')*2.5;
//echo $total_leave;
}}elseif($cdate < date("2019-12-26") &&  $cdate !='0000-00-00'){
$total_leave = 30; //echo $total_leave;
}elseif($cdate ='0000-00-00'){$total_leave=0; 
//echo $total_leave;
}*/


// Leave quota calculation
$r_date = find_a_field('personnel_basic_info','JOB_STATUS_DATE','PBI_ID='.$_SESSION['employee_selected']);
if($r_date !='0000-00-00'){ $last_date =$r_date; }else{ $last_date = date("2019-12-26"); }

$last_date2 = strtotime($last_date);
$ccdate = $cdate = find_a_field('personnel_basic_info','PBI_DOC2','PBI_ID='.$_SESSION['employee_selected']);
if($cdate < $last_date &&  $cdate !='0000-00-00'){

$ww = date("2019")-1;
$start_date = date(''.$ww.'-12-26');
if($start_date>$cdate){ $cdate = $start_date;}
$doc2 = strtotime($cdate);
$datediff = $last_date2 - $doc2;
$total_d= round($datediff / (60 * 60 * 24)+1);
$total_leave= number_format(((30*$total_d)/365),1);
if($total_leave>30){ $total_leave=30;}
elseif($total_leave<0){ $total_leave=0;}
} else {
$total_leave = 0;
}
// leave consume calculation



?>
<table width="60%" border="0" align="center">
<tr>
  <td colspan="3" align="center"><div align="left">Confirmation Date: <?=$ccdate?></div></td>
  <td align="center">&nbsp;</td>
  <td align="center">&nbsp;</td>
</tr>
<tr>
<tr>
  <td align="center" bgcolor="#CC99FF">Year</td>
<td height="22" align="center" bgcolor="#CC99FF">Leave Quota</td>
<td align="center" bgcolor="#CC99FF">Type</td>
<td align="center" bgcolor="#CC99FF">Leave Consumed</td>
<td align="center" bgcolor="#CC99FF">Leave Available</td>
</tr>

<tr>
  <td align="center">2021</td>
  <td align="center"><?=$total_leave?></td>
<td align="center">Salary Sheet</td>
<td align="center"><?=$leave_c = find_a_field('salary_attendence','sum(lv)','PBI_ID='.$_SESSION['employee_selected'].' and year=2021');
// and year="'.date(Y).'"
?></td>
<td align="center"><?=($total_leave-$leave_c)?></td>
</tr>

<tr>
  <td align="center">&nbsp;</td>
  <td align="center">&nbsp;</td>
  <td align="center">Leave Table </td>
  <td align="center"><?=$leave_c1 = find_a_field('hrm_leave_info','sum(total_days)','type not in("LWP (Leave Without Pay)","Compensatory Off") 
and leave_status NOT IN("Dept. Head Unapproved","Incharge Unapproved")
and s_date >= "2020-12-26" and s_date <= "2021-12-25"
and PBI_ID='.$_SESSION['employee_selected']);?></td>
  <td align="center"><?=($total_leave-$leave_c1)?></td>
</tr>
<tr>






<?
// Leave quota calculation 2020
$job_location = $emp->JOB_LOCATION;
if($job_location==1 || $job_location==88){ $yearly_leave=15;}else{ $yearly_leave=30; }

$r_date = find_a_field('personnel_basic_info','JOB_STATUS_DATE','PBI_ID='.$_SESSION['employee_selected']);
if($r_date !='0000-00-00'){ $last_date =$r_date; }else{ $last_date = date("2020-12-26"); }

$last_date2 = strtotime($last_date);
$cdate = find_a_field('personnel_basic_info','PBI_DOC2','PBI_ID='.$_SESSION['employee_selected']);
if($cdate < $last_date &&  $cdate !='0000-00-00'){

$ww = date("2020")-1;
$start_date = date(''.$ww.'-12-26');
if($start_date>$cdate){ $cdate = $start_date;}
$doc2 = strtotime($cdate);
$datediff = $last_date2 - $doc2;
$total_d= round($datediff / (60 * 60 * 24)+1);
$total_leave= number_format((($yearly_leave*$total_d)/365),1);
if($total_leave>$yearly_leave){ $total_leave=$yearly_leave;}
elseif($total_leave<0){ $total_leave=0;}
} else {
$total_leave = 0;
}
// leave consume calculation
?>
<tr>
  <td align="center">&nbsp;</td>
  <td align="center">&nbsp;</td>
  <td align="center">&nbsp;</td>
  <td align="center">&nbsp;</td>
  <td align="center">&nbsp;</td>
</tr>
<tr>
  <td align="center">2020</td>
  <td align="center"><?=$total_leave?></td>
  <td align="center">Salary Sheet</td>
  <td align="center"><?=$leave_c = find_a_field('salary_attendence','sum(lv)','PBI_ID='.$_SESSION['employee_selected'].' and year=2020');
// and year="'.date(Y).'"
?></td>
  <td align="center"><?=($total_leave-$leave_c)?></td>
</tr>
<tr>
  <td align="center">&nbsp;</td>
  <td align="center">&nbsp;</td>
  <td align="center">Leave Table </td>
  <td align="center"><?=$leave_c1 = find_a_field('hrm_leave_info','sum(total_days)','type not in("LWP (Leave Without Pay)","Compensatory Off") 
and leave_status NOT IN("Dept. Head Unapproved","Incharge Unapproved")
and s_date >= "2019-12-26" and s_date <= "2020-12-25"
and PBI_ID='.$_SESSION['employee_selected']);?></td>
  <td align="center"><?=($total_leave-$leave_c1)?></td>
</tr>
</table>
<? }?>


<br /><div style="text-align:center">
              <div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div class="oe_view_manager_view_list"><div class="oe_list oe_view">
<? 
/*if($_SESSION['employee_selected']>0){
$res = "select o.id,a.PBI_ID,a.PBI_NAME,o.type,o.leave_status,o.s_date as start_date, o.e_date as end_date,o.half_or_full as slot,o.total_days 
from personnel_basic_info a,hrm_leave_info o 
where 
a.PBI_ID=o.PBI_ID 
and o.s_date > '2017-12-25'
and a.PBI_ID='".$_SESSION['employee_selected']."' 
order by o.id desc";


echo $crud->link_report($res,$link);   
}*/      
 ?>
</div></div>
          </div>
    </div>

  </div></div></div>
          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
            
        </div>
 </form>   </div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>