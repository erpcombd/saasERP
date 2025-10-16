<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

function auto_dropdown($sql){
$res=db_query($sql);
while($data=mysqli_fetch_row($res)){
if($value==$data[0]){ echo '<option value="'.$data[0].'" selected>'.$data[1].'</option>';}
else{ echo '<option value="'.$data[0].'">'.$data[1].'</option>';}
}}

do_calander('#m_date');
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';
auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');
$table='hrm_inout';
$unique='id';

if($_POST['mon']!=''){
$mon=$_POST['mon'];}
else{
$mon=date('n');
}


if(isset($_POST["upload"]))
{
$year = $_POST['year'];
$mon = $_POST['mon'];
if($mon == 1)
{
$syear = $year - 1;
$smon = 12;
}
else
{
$syear = $year;
$smon =  $mon - 1;
}

$datetime = date('Y-m-d H:i:s');

$start_date = $syear.'-'.sprintf("%02d", $smon).'-26';


$startTime = $days1 = strtotime($start_date);
$days_mon = date('t',$startTime);

$end_date   = $year.'-'.sprintf("%02d", $mon).'-26';



$endTime = $days2=mktime(0,0,0,$mon,26,$year);

for ($i = $startTime; $i <= $endTime; $i = $i + 86400) {
$day   = date('l',$i);
${'day'.date('N',$i)}++;} 
$r_count=${'day5'};
$PBI_ORG = $_POST['PBI_ORG'];
if($_POST['emp_id']>0){ 	$emp_id=$_POST['emp_id'];}

if(isset($emp_id)){$emp_id_con=" and p.PBI_ID IN (".$_POST['emp_id'].")";}
if($PBI_ORG>0){ $ORG_con = " and p.PBI_ORG='".$PBI_ORG."'";}


$sql = "delete h.* FROM hrm_att_summary2 h, personnel_basic_info p
WHERE p.PBI_ID=h.emp_id 
and p.employee_type IN ('Roster','General Roster') 
and h.att_date BETWEEN '".$start_date."' AND '".$end_date."' 
".$ORG_con.$emp_id_con."";
$query = db_query($sql);


$sql = "insert into hrm_att_summary2 
(emp_id, in_time, out_time, att_date, sch_in_time, sch_out_time, sch_off_day, iom_type, iom_sl_no, iom_reason, iom_approved_by, iom_entry_at, iom_entry_by, leave_id, leave_type, leave_reason, leave_duration, panalty_leave_duration, leave_approved_by, leave_entry_at, leave_entry_by, dayname, late_min, grace_no, final_late_min, final_late_status, process_time, holyday, final_status, deleted)
select
h.emp_id, h.in_time, h.out_time, h.att_date, h.sch_in_time, h.sch_out_time, h.sch_off_day, h.iom_type, h.iom_sl_no, h.iom_reason, h.iom_approved_by, h.iom_entry_at, h.iom_entry_by, h.leave_id, h.leave_type, h.leave_reason, h.leave_duration, h.panalty_leave_duration, h.leave_approved_by, h.leave_entry_at, h.leave_entry_by, h.dayname, h.late_min, h.grace_no, h.final_late_min, h.final_late_status, h.process_time, h.holyday, h.final_status, h.deleted 

from hrm_att_summary h, personnel_basic_info p
where p.PBI_ID=h.emp_id 
and p.employee_type IN ('Roster','General Roster') 
and h.att_date BETWEEN '".$start_date."' AND '".$end_date."' and (iom_sl_no > 0 or leave_id > 0) ".$ORG_con.$emp_id_con;
$query = db_query($sql);

$sql = "delete h.* FROM hrm_att_summary2 h, personnel_basic_info p 
WHERE p.PBI_ID=h.emp_id 
and (p.employee_type = 'Roster' or p.employee_type = 'General Roster')
and h.att_date BETWEEN '".$start_date."' AND '".$end_date."' 
and iom_sl_no = 0 and leave_id = 0
".$ORG_con.$emp_id_con."";
$query = db_query($sql);


$sql = "update hrm_att_summary2 h, personnel_basic_info p set h.deleted=0, h.panalty_leave_duration=0,late_min=0, grace_no=0, final_late_min=0, final_late_status=0
WHERE p.PBI_ID=h.emp_id 
and (p.employee_type = 'Roster' or p.employee_type = 'General Roster')
and h.att_date BETWEEN '".$start_date."' AND '".$end_date."' 
and (iom_sl_no > 0 or leave_id > 0)
".$ORG_con.$emp_id_con."";
$query = db_query($sql);




 $sql = "SELECT xenrollid , xdate , min(xtime) in_time,max(xtime) out_time, sc.office_start_time,sc.office_end_time, p.grace_type
FROM `hrm_attdump` h, hrm_machice_type m, personnel_basic_info p ,hrm_schedule_info sc,hrm_roster_allocation ro
WHERE 
h.xenrollid=ro.PBI_ID
and p.employee_type = 'Roster'
and h.xdate=ro.roster_date
and sc.id=ro.shedule_1 
and p.PBI_ID=h.xenrollid 
and sc.schedule_type = 'Regular'
and xdate BETWEEN '".$start_date."' AND '".$end_date."' 
and h.xmechineid=m.mac_id 
and m.mac_type!='Out' ".$ORG_con.$emp_id_con."
GROUP BY xenrollid , xdate ";

	$query = db_query($sql);
	while($data = mysqli_fetch_object($query))
	{
	$sl++;


	$late_min[$sl] = 0;
	$grace_no[$sl] = 0;
	$final_late_min[$sl] = 0;
	$final_late_status[$sl] = 0;
	$process_time[$sl] = date('Y-m-d H:i:s');

	$emp_ids[$sl] = $emp_id = $data->xenrollid;
	$att_date[$sl] = $data->xdate;
	$next_att_date[$sl] = date('Y-m-d',(strtotime($data->xdate) + 86400));
	$in_time[$sl] = $data->in_time;
	$grace_type_name[$sl] = $data->grace_type;
	
	$office_start_time[$sl] = $data->office_start_time;
	$office_end_time[$sl] = $data->office_end_time;
	$att_date[$sl].' '.$office_start_time[$sl];
	$in_time[$sl];

	
	
	$from_time  = strtotime($att_date[$sl].' '.$office_start_time[$sl]);
	$entry_time = strtotime($in_time[$sl]);
	
	$panalty_leave_duration[$sl] = '0.0';
	
	if((($entry_time - $from_time)/60)>0){
	$late_min[$sl] = (($entry_time - $from_time)/60);}
	else {$late_min[$sl] = 0;}
	
		if($data->grace_type == 'Production Grace'){
			if($late_min[$sl]>10&&$late_min[$sl]<60){
			$panalty_leave_duration[$sl] = '0.5';}
			elseif($late_min[$sl]>60){
			$panalty_leave_duration[$sl] = '1.0';}
		}
		elseif($data->grace_type == 'General Grace'&&$late_min[$sl]>0&&$deleted[$sl]==0)
		{
           
					if($emp_id==$old_emp_id) {$grace_noo++;} else {$grace_noo=1;}
					if($grace_noo<6) 
					{
					$grace_no[$sl] = $grace_noo;
					if($late_min[$sl]<11)  
					{
					$final_late_min[$sl] = 0; 
					$final_late_status[$sl] = 0;
					}
					else 
					{
					if($late_min[$sl]>70) {$final_late_min[$sl] = 60;}
					else {$final_late_min[$sl] = $late_min[$sl] - 10;}
					$final_late_status[$sl] = 1;
					}
					} 
					else 
					{
					$grace_no[$sl] = 0;
					if($late_min[$sl]>0){	if($late_min[$sl]>60){ $final_late_min[$sl] = 60;} else{ $final_late_min[$sl] = $late_min[$sl];} $final_late_status[$sl] = 1;}
					else 				{$final_late_status[$sl] = 0;}
					
					}
					$old_emp_id = $emp_id;
		
		}
		elseif($data->grace_type == 'No Grace')
		{
		if($late_min[$sl]>0) {$deleted[$sl] = 1;}
		}
		
	}


	
    $sql = "SELECT xenrollid , xdate , max(xtime) out_time  
	FROM `hrm_attdump` h, hrm_machice_type m,personnel_basic_info p
	
	WHERE p.PBI_ID=h.xenrollid 
	and p.employee_type = 'Roster'
	and xdate BETWEEN '".$start_date."' AND '".$end_date."' 
	and h.xmechineid=m.mac_id and m.mac_type!='In' 
	".$ORG_con.$emp_id_con."
	GROUP BY xenrollid,xdate";
	
	$query = db_query($sql);
	while($data = mysqli_fetch_object($query))
	{
	$out_time[$data->xenrollid][$data->xdate] = $data->out_time;
	}
	

	
	


	
	$sql = "SELECT xenrollid , xdate , max(xtime) out_time  ,sc.office_start_time,sc.office_end_time
	FROM hrm_attdump h, hrm_machice_type m,personnel_basic_info p, hrm_schedule_info sc, hrm_roster_allocation ro
	
	WHERE 
	p.PBI_ID=h.xenrollid 
	and p.PBI_ID=ro.PBI_ID
	and h.xdate=ro.roster_date
	and sc.id=ro.shedule_1 
	and sc.schedule_type!='Regular'
	and p.employee_type = 'Roster'
	and xdate BETWEEN '".$start_date."' AND '".$end_date."' 
	and h.xmechineid=m.mac_id 
	and m.mac_type!='In' 
	".$ORG_con.$emp_id_con."
	GROUP BY xenrollid ,xdate ";
	
	$query = db_query($sql);
	while($data = mysqli_fetch_object($query))
	{
	$date = date('Y-m-d',(strtotime($data->xdate) - 86400));
	

	$out_time[$data->xenrollid][$date] = $data->out_time;
	}
	
	
	
		
    $sql = "SELECT xenrollid , xdate , max(xtime) out_time  ,sc.office_start_time,sc.office_end_time
	FROM hrm_attdump h, hrm_machice_type m,personnel_basic_info p, hrm_schedule_info sc, hrm_roster_allocation ro
	
	WHERE 
	p.PBI_ID=h.xenrollid 
	and h.xenrollid=ro.PBI_ID
	and p.employee_type = 'Roster'
	and p.PBI_ID=ro.PBI_ID
	and h.xdate=ro.roster_date
	and sc.id=ro.shedule_1 
	and xtime < concat(h.xdate,' ',sc.office_start_time)
	and xdate BETWEEN '".$start_date."' AND '".$end_date."' 
	and h.xmechineid=m.mac_id 
	and m.mac_type!='In' 
	".$ORG_con.$emp_id_con."
	GROUP BY xenrollid ,xdate ";
	
	$query = db_query($sql);
	while($data = mysqli_fetch_object($query))
	{
	$date = date('Y-m-d',(strtotime($data->xdate) - 86400));
	if($data->out_time<($data->xdate.' '.$data->office_start_time))

	$out_time[$data->xenrollid][$date] = $data->out_time;
	$out_time2[$data->xenrollid][$date] = $data->out_time;
	
	}
	

	
		$sql = "SELECT xenrollid , xdate , max(xtime) out_time  ,sc.office_start_time,sc.office_end_time
	FROM hrm_attdump h, hrm_machice_type m,personnel_basic_info p, hrm_schedule_info sc, hrm_roster_allocation ro
	
	WHERE 
	p.PBI_ID=h.xenrollid 
	and p.PBI_ID=ro.PBI_ID
	and h.xdate=ro.roster_date
	and sc.id=ro.shedule_1 
	and sc.schedule_type!='Regular'
	and p.employee_type = 'Roster'
	and xdate BETWEEN '".$start_date."' AND '".$end_date."' 
	and h.xmechineid=m.mac_id 
	and m.mac_type!='In' 
	".$ORG_con.$emp_id_con."
	GROUP BY xenrollid ,xdate ";
	
	$query = db_query($sql);
	while($data = mysqli_fetch_object($query))
	{
	$date = date('Y-m-d',(strtotime($data->xdate) - 86400));

	$out_time2[$data->xenrollid][$date] = $data->out_time;

	}
	
for($x=1;$x<=$sl;$x++)
{

    
	if($office_end_time[$x]>$office_start_time[$x])
{
$exit_time = $out_time[$emp_ids[$x]][$att_date[$x]];
$sch_out   = $att_date[$x].' '.$office_end_time[$x];
if($sch_out>$exit_time) {$deleted[$x] = 1;}
		
$sql="INSERT INTO hrm_att_summary2 
	(emp_id, att_date, in_time,out_time, sch_in_time, sch_out_time,  dayname, 
	panalty_leave_duration, deleted, late_min, grace_no, final_late_min, final_late_status, process_time)
	VALUES 
('".$emp_ids[$x]."','".$att_date[$x]."', '".$in_time[$x]."','".$out_time[$emp_ids[$x]][$att_date[$x]]."','".$office_start_time[$x]."','".$office_end_time[$x]."', dayname('".$att_date[$x]."'), '".$panalty_leave_duration[$x]."','".$deleted[$x]."','".$late_min[$x]."','".$grace_no[$x]."','".$final_late_min[$x]."','".$final_late_status[$x]."','".$process_time[$x]."')";
}

else
{
$exit_time = $out_time2[$emp_ids[$x]][$att_date[$x]];
$sch_out   = $next_att_date[$x].' '.$office_end_time[$x];


		if($sch_out>$exit_time) {$deleted[$x] = 1;}
		
	$sql="INSERT INTO hrm_att_summary2 
	(emp_id, att_date, in_time,out_time, sch_in_time, sch_out_time,  dayname, 
	panalty_leave_duration, deleted, late_min, grace_no, final_late_min, final_late_status, process_time)
	VALUES 
('".$emp_ids[$x]."','".$att_date[$x]."', '".$in_time[$x]."','".$out_time2[$emp_ids[$x]][$att_date[$x]]."','".$office_start_time[$x]."','".$office_end_time[$x]."', dayname('".$att_date[$x]."'), '".$panalty_leave_duration[$x]."','".$deleted[$x]."','".$late_min[$x]."','".$grace_no[$x]."','".$final_late_min[$x]."','".$final_late_status[$x]."','".$process_time[$x]."')";
}

	
	$query=db_query($sql);

	
}

echo 'Complete';
}
?>


<style type="text/css">
<!--
.style1 {font-size: 24px}
.style2 {
	color: #FF66CC;
	font-weight: bold;
}
-->
</style>

<div class="oe_view_manager oe_view_manager_current">
<form action=""  method="post" enctype="multipart/form-data">
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

<table width="80%" border="1" align="center">
<tr><td height="40" colspan="4" bgcolor="#00FF00"><div align="center" class="style1">Collect Attendance Information </div></td></tr>

<tr>
  <td>Employee Code </td>
  <td colspan="3">
  <input type="text" name="emp_id" id="emp_id" value="<?=$_POST['emp_id']?>" /></td>
</tr>
<tr>
  <td>Company:</td>
  <td colspan="3">
<!--  <span class="oe_form_group_cell">
    <select name="PBI_ORG" style="width:160px;" id="PBI_ORG">
      <? foreign_relation('user_group','id','group_name',$PBI_ORG,'1 and id="'.$_SESSION['user']['group'].'"');?>
    </select>
  </span>-->
<span class="oe_form_group_cell">
                  <select name="PBI_ORG" style="width:160px;" id="PBI_ORG">
                    <option value="<?=$_SESSION['user']['group']?>"><?=find_a_field('user_group','group_name','id='.$_SESSION['user']['group']);?></option>
                  </select>
</span></td>
</tr>
<tr>
<td width="20%">Month :</td>
<td colspan="3"><span class="oe_form_group_cell">
<select name="mon" style="width:160px;" id="mon" required="required">


<option value="1" <?=($mon=='1')?'selected':''?>>Jan</option>
<option value="2" <?=($mon=='2')?'selected':''?>>Feb</option>
<option value="3" <?=($mon=='3')?'selected':''?>>Mar</option>
<option value="4" <?=($mon=='4')?'selected':''?>>Apr</option>
<option value="5" <?=($mon=='5')?'selected':''?>>May</option>
<option value="6" <?=($mon=='6')?'selected':''?>>Jun</option>
<option value="7" <?=($mon=='7')?'selected':''?>>Jul</option>
<option value="8" <?=($mon=='8')?'selected':''?>>Aug</option>
<option value="9" <?=($mon=='9')?'selected':''?>>Sep</option>
<option value="10" <?=($mon=='10')?'selected':''?>>Oct</option>
<option value="11" <?=($mon=='11')?'selected':''?>>Nov</option>
<option value="12" <?=($mon=='12')?'selected':''?>>Dec</option>

          </select>
                </span></td>
                </tr>
              <tr>
                <td>Year :</td>
                <td colspan="3"><select name="year" style="width:160px;" id="year" required="required">
                  <option <?=($year=='2021')?'selected':''?>>2021</option>
				  <option <?=($year=='2020')?'selected':''?>>2020</option>
                  <option <?=($year=='2019')?'selected':''?>>2019</option>
                </select></td>
                </tr>
              
              <tr>

                <td colspan="4">
                  <div align="center">
                    <input name="upload" type="submit" id="upload" value="Sync All Data" />
                  </div></td>
                </tr>


              <tr>

                <td colspan="4"><label>

                    <div align="center">
                      <p>&nbsp;</p>
                      </div>

                    </label></td>
              </tr>
            </table>

            <br />
          </div>
          </div>

          </div>

    </div>

<div class="oe_chatter"><div class="oe_followers oe_form_invisible">
<div class="oe_follower_list"></div>
</div></div></div></div></div>
</div></div>
</div>
</form></div>



<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>

