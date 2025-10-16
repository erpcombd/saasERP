<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$page_id = 35;

$title='Single Attendance Roster Report (After In , Out Process)';  

function auto_dropdown($sql){

$res=db_query($sql);

while($data=mysqli_fetch_row($res)){

if($value==$data[0]){
echo '<option value="'.$data[0].'" selected>'.$data[1].'</option>';
}

else{
echo '<option value="'.$data[0].'">'.$data[1].'</option>';
}

}}



//ini_set('display_errors', 1);

//ini_set('display_startup_errors', 1);

//error_reporting(E_ALL);

$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

do_calander('#start_date');

do_calander('#end_date');

$PBI_ID = $_POST['PBI_ID'];







$mon=date('n');

if($mon == 1){

$smon = 12;

$syear = date('Y') - 1;

} else {

$smon =  $mon - 1;

$syear = date('Y');

}







?>

<style type="text/css">

<!--

.style2 {color: #FFFFFF; }

-->

</style>






<div class="form-container_large">
 	<form action="?"  method="post">
          <h4 class="text-center bg-titel bold pt-2 pb-2">Select Employee</h4>
        <div class="container-fluid bg-form-titel">
					
		
		
				<div class="row">
					
							<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
								<div class="form-group row m-0">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
										<input type="text" name="start_date" id="start_date"  required 

	value="<? if(isset($_POST['start_date'])){ echo $_POST['start_date']; }else{echo date('Y-m-01'); } ?>" />
	  
									</div>
								</div>
				
							</div>
							<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
								<div class="form-group row m-0">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
										<input type="text" name="end_date" id="end_date"  required 

	 value="<? if(isset($_POST['end_date'])){ echo $_POST['end_date']; }else{echo date('Y-m-25'); } ?>"/>
				
									</div>
								</div>
							</div>
							<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
								<div class="form-group row m-0">
									<label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Employee ID</label>
									<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
					<input name="PBI_ID"  type="text" id="PBI_ID" size="10" onblur="" tabindex="1" style="width:400px;" required="required" value="<?=$_POST['PBI_ID']?>" />
					
					
					
					
					
					
					
					
    
									</div>
								</div>
					</div>
				
					<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
						
						<input name="create" type="submit" id="create" class="btn1 btn1-bg-submit" value="Show Report" />
					</div>
				</div>

			</div>
	
		<br />
		
		<table class="table1  table-striped table-bordered table-hover table-sm">
					<thead class="thead1">
							
					</thead>

					<tbody class="tbody1">
							<? if($_POST['PBI_ID']>0){


								
								$start_date = $_POST['start_date'];
								
								$end_date = $_POST['end_date'];
								
								
								
								$begin = new DateTime($start_date);
								
								$end = new DateTime($end_date);
								
								$end->modify('+1 day');
								
								
								
								$startTime = $days1=mktime(1,1,1,date('m',strtotime($start_date)),26,date('y',strtotime($start_date)));
								
								
								
								$endTime = $days2=mktime(1,1,1,date('m',strtotime($end_date)),25,date('y',strtotime($end_date)));
								
								
								
								$days_mon=($endTime - $startTime)/(3600*24);
								
								
								
								for ($i = $startTime; $i <= $endTime; $i = $i + 86400) {
								
								$day   = date('l',$i);
								
								${'day'.date('N',$i)}++;
								
								
								
								//if(isset($$day))
								
								//$$day .= ',"'.date('Y-m-d', $i).'"';
								
								//else
								
								//$$day .= '"'.date('Y-m-d', $i).'"';
								
								}
								
								
								
								$ab="SELECT 
								
								a.PBI_NAME as name,
								
								c.group_name as company,
								
								desi.DESG_DESC as designation, 
								
								d.DEPT_DESC as department,
								
								j.LOCATION_NAME
								
								FROM 
								
								personnel_basic_info a, 
								
								user_group c, 
								
								department d, 
								
								designation desi,
								
								office_location j 
								
								WHERE 
								
								a.PBI_ORG=c.id and 
								
								a.DEPT_ID=d.DEPT_ID and 
								
								a.DESG_ID=desi.DESG_ID and 
								
								
								
								a.PBI_ID='".$_POST['PBI_ID']."'";
								
								$abb = db_query($ab);
								
								$pbi=mysqli_fetch_object($abb);
								
						?>
						
						
						<tr class="">
							<td>Name: </td>
						
							<td>&nbsp;<?=$pbi->name?></td>
						
							<td>Company:</td>
						
							<td>&nbsp;<?=$pbi->company?>,<?=$pbi->LOCATION_NAME?></td>
						
						</tr>
						<tr class="">

							<td>Designation:</td>
						
							<td>&nbsp;<?=$pbi->designation?></td>
						
							<td>Department:</td>
						
							<td>&nbsp;<?=$pbi->department?></td>
						
						 </tr>
				
						
					</tbody>
				</table>
				
				<? 


					
					// SMS Send
					
					if($_POST['PBI_ID']=='1867'){
					
					$dest_addr='8801711763169';
					
					$sms_text = 'Single Log View from '.$_POST['start_date'].' to '.$_POST['end_date'].' by id:'.$_SESSION['user']['id'];
					
					gpsms('SAJEEBGROUP',$dest_addr,$sms_text);
					
					}
					
					
					
					
					
			 ?>
				
			</form>
			<br />
			
		<table class="table1  table-striped table-bordered table-hover table-sm">
					<thead class="thead1">
							<tr class="bgc-info">
		
							  <th><div align="center">Date</div></th>
						
							  <th><div align="center">Day</div></th>
							  
							   <th>Sch-Point</th>
						
							  <th>Sch-IN</th>
						
							  <th>Sch-Out</th>
						
							  <th><div align="center">IN</div></th>
						
							  <th><span>OUT</span></th>
						
							  <th><span>Grace</span></th>
						
							  <th>LBG</th>
						
							  <th>LAG</th>
						
							  <th>Status</th>
						
						 </tr>
				</thead>

					<tbody class="tbody1">
					
					
					 <? 







					$sql  = 'select office_start_time,office_end_time,r.roster_date att_date,r.point_1,s.schedule_type,s.schedule_name from hrm_roster_allocation r,hrm_schedule_info s where r.shedule_1=s.id and PBI_ID="'.$PBI_ID.'" and  roster_date between "'.$start_date.'" and "'.$end_date.'" order by roster_date asc';
					
					$query = db_query($sql);
					
					while($data=mysqli_fetch_object($query)){
					
					$sch[$data->att_date]['sch_name'] = $data->schedule_name;
					
					$val[$data->att_date]['sch_in_time'] = $data->office_start_time;
					
					$val[$data->att_date]['sch_out_time'] = $data->office_end_time;
					
					$val[$data->att_date]['sch_location'] = $data->point_1;
					
					}
					
					
					
					
					
					$sql  = 'select iom_sl_no,leave_id,att_date from hrm_att_summary where emp_id="'.$PBI_ID.'" and  att_date between "'.$start_date.'" and "'.$end_date.'" and (iom_sl_no>0 or leave_id>0) order by att_date asc';
					
					$query = db_query($sql);
					
					while($data=mysqli_fetch_object($query)){
					
					if($data->iom_sl_no>0){
					$sch[$data->att_date]['iom'] = $data->iom_sl_no;
					}
					
					if($data->leave_id>0){
					$sch[$data->att_date]['leave'] = $data->leave_id;
					}
					
					}
					
					
					
					
					
					$sql  = 'select * from hrm_att_summary where emp_id="'.$PBI_ID.'" and  att_date between "'.$start_date.'" and "'.$end_date.'" order by att_date asc';
					
					$query = db_query($sql);
					
					while($data=mysqli_fetch_object($query)){
					
					$val[$data->att_date]['in_time'] = $data->in_time;
					
					$val[$data->att_date]['out_time'] = $data->out_time;
					
					
					
					
					
					
					
					$val[$data->att_date]['iom'] = $data->iom_sl_no	;
					
					$val[$data->att_date]['leave'] = $data->leave_id;
					
					$val[$data->att_date]['dayname'] = $data->dayname;
					
					
					
					if($data->late_min>0)
					
					$val[$data->att_date]['late_status'] = 'LATE';
					
					$val[$data->att_date]['final_late_min'] = $data->final_late_min;
					
					$val[$data->att_date]['late_min'] = $data->late_min;
					
					$val[$data->att_date]['final_late_status'] = $data->final_late_status;
					
					$val[$data->att_date]['grace_no'] = $data->grace_no;
					
					$val[$data->att_date]['holyday'] = $data->holyday;
					
					
					
					
					
					}
					
					
					
					
					
					
					
					$interval = DateInterval::createFromDateString('1 day');
					
					$period = new DatePeriod($begin, $interval, $end);
					
					//echo $off_day;
					
					foreach ( $period as $dt ){
					
					++$days;
					
					
					
					
					
					
					
					$this_date = $dt->format( "Ymd" );
					
					
					
					$day_date = $dt->format( "Y-m-d" );
					
					
					
					
					
					//$holysql = "select 1 from salary_holy_day where holy_day = '".$day_date."'";
					
					//$holy_query = db_query($holysql);
					
					//$holy = mysqli_fetch_row($holy_query);
					
					//
					
					//
					
					//
					
					
					
					if($sch[$day_date]['leave']>0){
					$val[$day_date]['final_status'] = 'LEAVE';
					}
					
					elseif($sch[$day_date]['iom']>0){
					$val[$day_date]['final_status'] = 'IOM';
					}
					
					
					
					
					
					
					
					elseif($sch[$day_date]['sch_name']=='Leave'){
					$val[$day_date]['final_status'] = 'LEAVE';
					}
					
					
					
					elseif($sch[$day_date]['sch_name']=='LWP'){
					$val[$day_date]['final_status'] = 'LWP';
					}
					
					
					
					elseif($sch[$day_date]['sch_name']=='Compensatory Leave'){
					$val[$day_date]['final_status'] = 'Compensatory Leave';
					}
					
					
					
					elseif($sch[$day_date]['sch_name']=='Shift Change') {$val[$day_date]['final_status'] = 'Shift Change';}
					
					
					
					elseif($sch[$day_date]['sch_name']=='Offday'){
					$val[$day_date]['final_status'] = 'OFFDAY';
					}
					
					elseif($sch[$day_date]['sch_name']=='Holiday'){
					$val[$day_date]['final_status'] = 'HOLIDAY';
					}
					
					
					
					$ydate = date('Y-m-d',(strtotime($day_date) + 86400));
					
					
					
					
					
					$in = $day_date.' '.$val[$day_date]['sch_in_time'];
					
					
					
					if($val[$day_date]['sch_in_time']<$val[$day_date]['sch_out_time']){
					$out = $day_date.' '.$val[$day_date]['sch_out_time'];
					}
					
					else {
					$out = $ydate.' '.$val[$day_date]['sch_out_time'];
					}
					
					
					
					
					
					
					
					
					
					
					
					if($val[$day_date]['final_status']=='')
					
					{
					
					if($val[$day_date]['sch_in_time']=='00:00:00'||$val[$day_date]['sch_out_time']=='00:00:00'||$val[$day_date]['sch_in_time']==''||$val[$day_date]['sch_out_time']==''){
					$val[$day_date]['final_status']='NO SCH';
					}
					
					elseif($val[$day_date]['in_time']==''||$val[$day_date]['out_time']==''){
					$val[$day_date]['final_status']='ABSENT';
					}
					
					elseif($val[$day_date]['out_time']<$out){
					$val[$day_date]['final_status']='EARLY';
					}
					
					
					
					elseif($val[$day_date]['in_time']>$in){
					$val[$day_date]['final_status']='LATE';
					}
					
					else{
					$val[$day_date]['final_status']='REGULAR';
					}
					
					}
					
					
					
					
					
					if($val[$day_date]['final_status']=='ABSENT')
					
					{$text_color = '#ed173b';} 
					
					elseif($val[$day_date]['final_status']=='EARLY')
					
					{$text_color = '#ed173b';} 
					
					elseif($val[$day_date]['final_status']=='LEAVE')
					
					{$text_color = '#E36BEA';} 
					
					elseif($val[$day_date]['final_status']=='LATE')
					
					{$text_color = 'Red';} 
					
					elseif($val[$day_date]['final_status']=='NO SCH')
					
					{$text_color = '#E2DC21';} 
					
					
					
					else {$text_color = 'Black';}
					
					
					
					//if($val[$day_date]['final_status']=='ABSENT')
					
					//$bgcolor = 'RED';
					
					//elseif($val[$day_date]['final_status']=='LEAVE')
					
					//$bgcolor = '#FFCCCC';
					
					//if($val[$day_date]['final_status']=='Compensatory Leave'){
					
					//$bgcolor = '#FF00CC';
					
					//$val[$day_date]['final_status']='CL';}
					
					//elseif($val[$day_date]['final_status']=='OFFDAY')
					
					//$bgcolor = 'Blue';
					
					//elseif($val[$day_date]['final_status']=='EARLY')
					
					//$bgcolor = 'ASH';
					
					//
					
					//elseif($val[$day_date]['final_status']=='IOM')
					
					//$bgcolor = 'Yellow';
					
					//elseif($val[$day_date]['final_status']=='LATE')
					
					//{$bgcolor = 'Orange';}
					
					//elseif($val[$day_date]['final_status']=='REGULAR')
					
					//{$bgcolor = 'GREEN';}
					
					//elseif($val[$day_date]['final_status']=='NO SCH')
					
					//{$bgcolor = 'White';}
					
					?>
					
						<tr>
					
						  <td><?=$dt->format( "Y-m-d" );?></td>
					
						  <td><?=$dt->format("l");?></td>
						  
						  <td><?=find_a_field('crm_project_org','name','');?></td>
					
						  <td><?=$val[$day_date]['sch_in_time'];?></td>
					
						  <td><?=$val[$day_date]['sch_out_time'];?></td>
					
						  <td><?=$val[$day_date]['in_time'];?></td>
					
						  <td><?=$val[$day_date]['out_time'];?></td>
					
						  <td><?=($val[$day_date]['grace_no']>0&&$val[$day_date]['iom']==0)?$val[$day_date]['grace_no']:'';?></td>
					
						  <td><?=($val[$day_date]['iom']==0&&$val[$day_date]['late_min']>0)?$val[$day_date]['late_min']:'';?></td>
					
						  <td><?=($val[$day_date]['iom']==0&&$val[$day_date]['final_late_min']>0)?$val[$day_date]['final_late_min']:'';?></td>
					
						  <td><?=$val[$day_date]['final_status'];?></td>
					
						  </tr>
					
					<? }?>

					

					</tbody>
					
					
					<? } ?>
				</table>


    
</div>







<?php /*?><div class="oe_view_manager oe_view_manager_current">

        

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


<div  class="oe_view_manager_view_list"><div  class="oe_list oe_view"><form action="?"  method="post">

<table width="100%" border="0" class="table table-bordered table-sm"><thead>

</thead><tfoot>

</tfoot><tbody>



  <tr  class="bg-info">

    <td width="37%" align="right"><strong>Employee Code  :</strong></td><td colspan="3" align="left">

	<!--<input name="PBI_ID"  type="text" id="PBI_ID" size="10" onblur="" tabindex="1" style="width:400px;" required value="<?=$_POST['PBI_ID']?>" />-->

	<input name="PBI_ID"  type="text" id="PBI_ID" size="10" onblur="" tabindex="1" style="width:400px;" required="required" value="<?=$_POST['PBI_ID']?>" /></td>

    </tr>

	  <tr >

    <td align="right"><strong>Start Date  :</strong></td>

    <td width="9%" align="left">

	<input type="text" name="start_date" id="start_date" style="width:100px;" required 

	value="<? if(isset($_POST['start_date'])){ echo $_POST['start_date']; }else{echo $syear.'-'.$smon.'-26'; } ?>" /></td>

	

    <td width="16%" align="right"><strong>End Date   :</strong></td>

    <td width="38%">

	<input type="text" name="end_date" id="end_date" style="width:100px;" required 

	 value="<? if(isset($_POST['end_date'])){ echo $_POST['end_date']; }else{echo date('Y-m-25'); } ?>"/></td>

  </tr>

<tr class="oe_list_header_columns">

  <th colspan="4"><table width="1%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><input name="create" type="submit" id="create" class="btn1 btn1-bg-submit" value="Show Report" /></td>

    </tr>

  </table>

    </th>

</tr>



  </tbody></table></form>

<? if($_POST['PBI_ID']>0){



$start_date = $_POST['start_date'];

$end_date = $_POST['end_date'];



$begin = new DateTime($start_date);

$end = new DateTime($end_date);

$end->modify('+1 day');



$startTime = $days1=mktime(1,1,1,date('m',strtotime($start_date)),26,date('y',strtotime($start_date)));



$endTime = $days2=mktime(1,1,1,date('m',strtotime($end_date)),25,date('y',strtotime($end_date)));



$days_mon=($endTime - $startTime)/(3600*24);



for ($i = $startTime; $i <= $endTime; $i = $i + 86400) {

$day   = date('l',$i);

${'day'.date('N',$i)}++;



//if(isset($$day))

//$$day .= ',"'.date('Y-m-d', $i).'"';

//else

//$$day .= '"'.date('Y-m-d', $i).'"';

}





$ab="SELECT 

a.PBI_NAME as name,

c.group_name as company,

desi.DESG_DESC as designation, 

d.DEPT_DESC as department,

j.LOCATION_NAME,a.PBI_DOMAIN as section

FROM 

personnel_basic_info a, 

user_group c, 

department d, 

designation desi,

office_location j 

WHERE 

a.PBI_ORG=c.id and 

a.DEPT_ID=d.DEPT_ID and 

a.DESG_ID=desi.DESG_ID and 

a.PBI_ID='".$_POST['PBI_ID']."'";

$abb = db_query($ab);

$pbi=mysqli_fetch_object($abb);

?>

<div style="text-align:center">

<table  class="table table-bordered table-sm">

  <thead>





<tr><td colspan="4">



<span id="id_view"></span>          



<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr class="table-warning">

    <td>Name: </td>

    <td>&nbsp;<?=$pbi->name?></td>

    <td>Company:</td>

    <td>&nbsp;<?=$pbi->company?>,<?=$pbi->LOCATION_NAME?></td>

  </tr>

  <tr class="table-warning">

    <td>Designation:</td>

    <td>&nbsp;<?=$pbi->designation?></td>

    <td>Department:</td>

    <td>&nbsp;<?=$pbi->department?> (Section: <?=$pbi->section?>) </td>

  </tr>

</table></td></tr>

<tr class="oe_list_header_columns">

  <th colspan="4" style="text-align:center">
  
  <table width="100%" border="0" cellspacing="0" cellpadding="0" id="grp">

   <thead> <tr class="table-danger">

      <th><div align="center">Date</div></th>

      <th><div align="center">Day</div></th>

      <th>Sch-IN</th>

      <th>Sch-Out</th>

      <th><div align="center">IN</div></th>

      <th><span>OUT</span></th>

      <th><span>Grace</span></th>

      <th>LBG</th>

      <th>LAG</th>

      <th>Status</th>

      </tr></thead>

	  <? 







$sql  = 'select office_start_time,office_end_time,r.roster_date att_date,s.schedule_type,s.schedule_name from hrm_roster_allocation r,hrm_schedule_info s where r.shedule_1=s.id and PBI_ID="'.$PBI_ID.'" and  roster_date between "'.$start_date.'" and "'.$end_date.'" order by roster_date asc';

$query = db_query($sql);

while($data=mysqli_fetch_object($query)){

$sch[$data->att_date]['sch_name'] = $data->schedule_name;

$val[$data->att_date]['sch_in_time'] = $data->office_start_time;

$val[$data->att_date]['sch_out_time'] = $data->office_end_time;

}





$sql  = 'select iom_sl_no,leave_id,att_date from hrm_att_summary where emp_id="'.$PBI_ID.'" and  att_date between "'.$start_date.'" and "'.$end_date.'" and (iom_sl_no>0 or leave_id>0) order by att_date asc';

$query = db_query($sql);

while($data=mysqli_fetch_object($query)){

if($data->iom_sl_no>0)

$sch[$data->att_date]['iom'] = $data->iom_sl_no;

if($data->leave_id>0)

$sch[$data->att_date]['leave'] = $data->leave_id;

}





$sql  = 'select * from hrm_att_summary where emp_id="'.$PBI_ID.'" and  att_date between "'.$start_date.'" and "'.$end_date.'" order by att_date asc';

$query = db_query($sql);

while($data=mysqli_fetch_object($query)){

$val[$data->att_date]['in_time'] = $data->in_time;

$val[$data->att_date]['out_time'] = $data->out_time;







$val[$data->att_date]['iom'] = $data->iom_sl_no	;

$val[$data->att_date]['leave'] = $data->leave_id;

$val[$data->att_date]['dayname'] = $data->dayname;



if($data->late_min>0)

$val[$data->att_date]['late_status'] = 'LATE';

$val[$data->att_date]['final_late_min'] = $data->final_late_min;

$val[$data->att_date]['late_min'] = $data->late_min;

$val[$data->att_date]['final_late_status'] = $data->final_late_status;

$val[$data->att_date]['grace_no'] = $data->grace_no;

$val[$data->att_date]['holyday'] = $data->holyday;





}







$interval = DateInterval::createFromDateString('1 day');

$period = new DatePeriod($begin, $interval, $end);

//echo $off_day;

foreach ( $period as $dt ){

++$days;







$this_date = $dt->format( "Ymd" );



$day_date = $dt->format( "Y-m-d" );





//$holysql = "select 1 from salary_holy_day where holy_day = '".$day_date."'";

//$holy_query = db_query($holysql);

//$holy = mysqli_fetch_row($holy_query);

//

//

//



if($sch[$day_date]['leave']>0)

$val[$day_date]['final_status'] = 'LEAVE';

elseif($sch[$day_date]['iom']>0)

$val[$day_date]['final_status'] = 'IOM';







elseif($sch[$day_date]['sch_name']=='Leave')

$val[$day_date]['final_status'] = 'LEAVE';



elseif($sch[$day_date]['sch_name']=='LWP')

$val[$day_date]['final_status'] = 'LWP';



elseif($sch[$day_date]['sch_name']=='Compensatory Leave')

$val[$day_date]['final_status'] = 'Compensatory Leave';



elseif($sch[$day_date]['sch_name']=='Shift Change') $val[$day_date]['final_status'] = 'Shift Change';



elseif($sch[$day_date]['sch_name']=='Offday')

$val[$day_date]['final_status'] = 'OFFDAY';

elseif($sch[$day_date]['sch_name']=='Holiday')

$val[$day_date]['final_status'] = 'HOLIDAY';



$ydate = date('Y-m-d',(strtotime($day_date) + 86400));





$in = $day_date.' '.$val[$day_date]['sch_in_time'];



if($val[$day_date]['sch_in_time']<$val[$day_date]['sch_out_time'])

$out = $day_date.' '.$val[$day_date]['sch_out_time'];

else 

$out = $ydate.' '.$val[$day_date]['sch_out_time'];











if($val[$day_date]['final_status']=='')

{

if($val[$day_date]['sch_in_time']=='00:00:00'||$val[$day_date]['sch_out_time']=='00:00:00'||$val[$day_date]['sch_in_time']==''||$val[$day_date]['sch_out_time']=='')

$val[$day_date]['final_status']='NO SCH';

elseif($val[$day_date]['in_time']==''||$val[$day_date]['out_time']=='')

$val[$day_date]['final_status']='ABSENT';

elseif($val[$day_date]['out_time']<$out)

$val[$day_date]['final_status']='EARLY';



elseif($val[$day_date]['in_time']>$in)

$val[$day_date]['final_status']='LATE';

else

$val[$day_date]['final_status']='REGULAR';

}





if($val[$day_date]['final_status']=='ABSENT')

{$text_color = '#ed173b';} 

elseif($val[$day_date]['final_status']=='EARLY')

{$text_color = '#ed173b';} 

elseif($val[$day_date]['final_status']=='LEAVE')

{$text_color = '#E36BEA';} 

elseif($val[$day_date]['final_status']=='LATE')

{$text_color = 'Red';} 

elseif($val[$day_date]['final_status']=='NO SCH')

{$text_color = '#E2DC21';} 



else {$text_color = 'Black';}



//if($val[$day_date]['final_status']=='ABSENT')

//$bgcolor = 'RED';

//elseif($val[$day_date]['final_status']=='LEAVE')

//$bgcolor = '#FFCCCC';

//if($val[$day_date]['final_status']=='Compensatory Leave'){

//$bgcolor = '#FF00CC';

//$val[$day_date]['final_status']='CL';}

//elseif($val[$day_date]['final_status']=='OFFDAY')

//$bgcolor = 'Blue';

//elseif($val[$day_date]['final_status']=='EARLY')

//$bgcolor = 'ASH';

//

//elseif($val[$day_date]['final_status']=='IOM')

//$bgcolor = 'Yellow';

//elseif($val[$day_date]['final_status']=='LATE')

//{$bgcolor = 'Orange';}

//elseif($val[$day_date]['final_status']=='REGULAR')

//{$bgcolor = 'GREEN';}

//elseif($val[$day_date]['final_status']=='NO SCH')

//{$bgcolor = 'White';}

?>

    <tr bgcolor="<?=$bgcolor?>"; style="border: 1px solid #333333;"}>

      <td><?=$dt->format( "Y-m-d" );?></td>

      <td><?=$dt->format("l");?></td>

      <td><?=$val[$day_date]['sch_in_time'];?></td>

      <td><?=$val[$day_date]['sch_out_time'];?></td>

      <td><?=$val[$day_date]['in_time'];?></td>

      <td><?=$val[$day_date]['out_time'];?></td>

      <td><?=($val[$day_date]['grace_no']>0&&$val[$day_date]['iom']==0)?$val[$day_date]['grace_no']:'';?></td>

      <td><?=($val[$day_date]['iom']==0&&$val[$day_date]['late_min']>0)?$val[$day_date]['late_min']:'';?></td>

      <td><?=($val[$day_date]['iom']==0&&$val[$day_date]['final_late_min']>0)?$val[$day_date]['final_late_min']:'';?></td>

      <td style="color:<?=$text_color;?>"><?=$val[$day_date]['final_status'];?></td>

      </tr>

<? }?>

    <tr bgcolor="#FFFFFF">

      <td colspan="10"><br /></td>

    </tr>

  </table>

  </th>

  </tr>

  </thead>

  <tfoot>

  </tfoot>

  <tbody>

  </tbody>

</table>

  </div><? }?></div></div>

          </div>

    </div>

    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">

      <div class="oe_follower_list"></div>

    </div></div></div></div></div>

    </div></div>

            

        </div>

    </div><?php */?>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>