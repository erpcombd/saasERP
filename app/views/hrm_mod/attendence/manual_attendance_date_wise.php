<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title="Attendance Date Wise";



do_calander('#s_date');



do_calander('#e_date');



$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';



auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');



$table='hrm_inout';



$unique='id';



if(isset($_POST['search']))



{		


 $user_id=$_SESSION['user']['id'];
$emp_id=$_POST['PBI_ID'];



$access_date=$a_date=$_POST['s_date'];



$access_e_date=$a_date=$_POST['e_date'];



$c_date=explode('-',$a_date);



//$access_stamp=mktime($_POST['m_hr'],$_POST['m_min'],0,$c_date[1],$c_date[2],$c_date[0]);
$access_stamp = mktime($_POST['m_hr'], $_POST['m_min'], 0, $c_date[1], $c_date[2], intval($c_date[0]));




$time =  $_POST['m_hr'].':'.$_POST['m_min'].':'.'00';



$sch = find_all_field_sql('select p.off_day,s.office_start_time,s.office_end_time from personnel_basic_info p, hrm_schedule_info s where p.PBI_ID="'.$emp_id.'" and p.office_time=s.id');



$date = date('Ymd',$access_stamp);



/*if(date('N',$access_stamp)==$sch->off_day) $info['status'][$date]=0;



else{



if($sch->office_start_time == '')	$info['status'][$date]=1;



else{$info['late'][$date] = (int)(($access_stamp - strtotime($access_date.' '.$sch->office_start_time))/60);



if($info['late'][$date]>0) 	$info['status'][$date]=2;



else 	$info['status'][$date]=1;



}}*/



$s_date= strtotime($_REQUEST['s_date']);



$e_date= strtotime($_REQUEST['e_date']);



////////////////////////



for($i=$s_date; $i<=$e_date; $i+=86400){



$empd = explode(",", $_POST['PBI_ID']);



foreach($empd as $emp){



	$att_date=date('Y-m-d',$i);

	

	$access_time=$att_date.' '.$_POST['m_hr'].':'.$_POST['m_min'].':'.'00';

	

	 $att_sql = "INSERT INTO hrm_attdump ( ztime, bizid, xenrollid, xdate, xtime,EMP_CODE,time,entry_by) 

	

	VALUES ('$access_time', '$emp', '$emp', '$att_date', '$access_time','$emp','$time','$user_id')";

	

	$att_query=db_query($att_sql);

	

	/// For out time 

	if($_POST['o_hr']>0){

		$access_time=$att_date.' '.$_POST['o_hr'].':'.$_POST['o_min'].':'.'00';

		

		$att_sql1 = "INSERT INTO hrm_attdump ( ztime, bizid, xenrollid, xdate, xtime,EMP_CODE,time,entry_by) 

		

		VALUES ('$access_time', '$emp', '$emp', '$att_date', '$access_time','$emp','$time','$user_id')";

		

		$att_query1=db_query($att_sql1);

	}



 }

}



//////////////////////



}



?>



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



<div class="oe_view_manager oe_view_manager_current">

  
  

<form action=""  method="post">







<table align="center" class="table table-bordered table-sm">
                          <tbody><tr>
                            <td colspan="8" bgcolor="#00FF00"><div align="center" style="font-size:24px">Manual Attendance </div></td>
                          </tr>
                          <tr>
                            <td colspan="8"><div align="center"></div></td>
                          </tr>
						  
                          <tr>
                            <td colspan="2" width="20%"><div align="right">Employee Code : </div></td>

                            <td colspan="4" ><input name="PBI_ID"  type="text" id="PBI_ID" size="10" onblur="" tabindex="1" style="width:400px;" class="form-control" /></td>
							<td colspan="2" width="20%"></td>
                          </tr>
						  
                          <tr>
                            <td colspan="2"><div align="right">Access Date-Time : </div></td>
                            <td colspan="2">
								<input type="text" name="s_date" autocomplete="off" id="s_date" style="width:50%;" class="form-control" />
							</td>
                            <td colspan="2"><input type="text" name="e_date" autocomplete="off" id="e_date" style="width:50%;" class="form-control" /></td>

							<td colspan="2" width="20%"></td>
                          </tr>
						  
						  
						  
                          <tr>
                            <td colspan="2"><div align="right">Punch : </div></td>

                            <td>
								<select name="m_hr" id="m_hr" >
									<? for($i=7;$i<24;$i++){ ?>
									<option><?=sprintf('%02d', $i);?></option>
									<? }?>
								</select>
								In Hr
							</td>
							
                            <td> 
								<select name="m_min"  id="m_min">
									<? for($i=0;$i<60;$i++){?>
									<option><?=sprintf('%02d', $i);?></option>
									<? }?> 
								</select>
								In Min 
							</td>
							
							<td>
								<select name="o_hr" id="o_hr" >
									<option>00</option>
									<? for($i=1;$i<24;$i++){ ?>
									<option><?=sprintf('%02d', $i);?></option>							
									<? }?>
								</select>
								Out Hr
							</td>
							
							<td>
								<select name="o_min"  id="o_min">
									<? for($i=0;$i<60;$i++){?>
									<option><?=sprintf('%02d', $i);?></option>
									<? }?> 
								</select>
								Out Min
							</td>
								
							<td colspan="2" width="20%"></td>
                          </tr>                          
                          
						  
                          <tr >
						  <td colspan="3" width="20%"></td>
                            <td colspan="2" style="text-align:center"><div align="center" style="text-align:center">
							<input name="search" type="submit" class="btn btn-success form-control" id="search" value="Manual Attendence" />

                              </div></td>
                          </tr>
                        </tbody>
						
						</table>



<div class="oe_view_manager_body">
<div class="oe_view_manager_view_form">
<div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
<div class="oe_form_container">
<div class="oe_form">
<div class="">
<div class="oe_form_sheetbg">
<div class="oe_form_sheet oe_form_sheet_width">
<div  class="oe_view_manager_view_list">
<div  class="oe_list oe_view">
<div style="text-align:center">
<div class="oe_form_sheetbg">
<div class="oe_form_sheet oe_form_sheet_width">
<div class="oe_view_manager_view_list">
<div class="oe_list oe_view">



<? if($emp_id>0){



$ab="SELECT a.PBI_NAME as name, b.DOMAIN_DESC as company_name, c.DEPT_DESC as department, d.DESG_DESC as designation FROM personnel_basic_info a, domai b, department c, designation d WHERE a.PBI_DOMAIN=b.DOMAIN_DESC and a.DEPT_ID=c.DEPT_ID and a.DESG_ID=d.DESG_ID and a.PBI_ID=$emp_id";



$data=db_query($ab);



$emp=mysqli_fetch_object($data);



?>



<span id="id_view">



<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">



<tr>



<td height="50" bgcolor="#006600"><div align="center" class="style2">ACCESS IN AT: 



<?=date('d/m/Y H:i:s A',$access_stamp)?>



</div></td>



</tr>



<tr>



<td><div align="center"><img src="../../pic/staff/<?php echo $emp_id;?>.jpeg" width="190" height="191" /></div></td>



</tr>



<tr>



<td><div align="center" class="cell_fonts_grant_total style7"><strong><em>Employee Code  : <?php echo $emp_id;?></em></strong></div></td>



</tr>



<tr>



<td><div align="center" class="cell_fonts_grant_total style6"><strong><em><?php echo $emp->name." (".$emp->designation.")";?> </em></strong></div></td>



</tr><tr>



<td><div align="center" class="cell_fonts_grant_total style6"><strong><em><?php echo $emp->department.", ".$emp->company_name;?> </em></strong></div></td>



</tr>



</table>



</span>          



<? }?>



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