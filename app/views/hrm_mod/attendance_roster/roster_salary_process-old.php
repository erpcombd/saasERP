<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
do_calander('#m_date');
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';
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

$emp_id = $_POST['emp_id'];
$PBI_ORG = $_POST['PBI_ORG'];

$datetime = date('Y-m-d H:i:s');
$start_date = $syear.'-'.sprintf("%02d", $smon).'-26'; 
$startTime = $days1 = strtotime($start_date);
$days_mon = date('t',$startTime);
$end_date   = $year.'-'.($mon).'-25'; 
$endTime = $days2=mktime(0,0,0,$mon,25,$year);

$holy_day=0;



$sql = "SELECT PBI_ID,count(1) off_day
FROM hrm_roster_allocation
WHERE shedule_1 in (11,26,33,50) and `roster_date` BETWEEN '".$start_date."' AND '".$end_date."' 
group by PBI_ID";
	
$query = db_query($sql);
	while($data = mysqli_fetch_object($query))
	{
      $offday_in_month[$data->PBI_ID] = $data->off_day;
	}
	
$sql = "SELECT r.PBI_ID,count(1) off_day
FROM hrm_roster_allocation r, `hrm_att_summary` h, hrm_schedule_info s
WHERE r.shedule_1 = s.id and h.emp_id = r.PBI_ID and (h.iom_sl_no>0 OR h.leave_id>0) and s.schedule_type != 'Regular' and h.att_date = r.roster_date and r.roster_date BETWEEN '".$start_date."' AND '".$end_date."' 
group by r.PBI_ID";
	
$query = db_query($sql);
	while($data = mysqli_fetch_object($query))
	{
	$offiomlv_in_month[$data->PBI_ID] = $data->off_day;
	}

if($emp_id>0)  {$emp_con = " and p.PBI_ID='".$emp_id."'";}
if($PBI_ORG>0) {$ORG_con = " and p.PBI_ORG='".$PBI_ORG."'";}

$sql = "SELECT emp_id,(count(1)-sum(leave_duration)) pre, sum(leave_duration) lv, sum(final_late_min) l_min,sum(final_late_status) l_status,sum(panalty_leave_duration) panalty_lv,p.PBI_DOJ,p.PBI_ID,p.PBI_DUE_DOJ,p.PBI_DOC2
FROM `hrm_att_summary` h,personnel_basic_info p, hrm_roster_allocation r,hrm_schedule_info s
WHERE 
r.shedule_1 = s.id 
and p.PBI_ID=h.emp_id 
and p.employee_type = 'Roster'
and h.emp_id = r.PBI_ID
and h.att_date = r.roster_date
and s.schedule_type!='Offday'
and s.schedule_type!='Leave'
and `att_date` BETWEEN '".$start_date."' 
AND '".$end_date."'  And leave_duration!=1  
AND h.holyday=0 
AND (h.deleted=0 or h.leave_duration>0 or h.iom_sl_no>0)
".$emp_con.$ORG_con." 
group by emp_id";
	
	
$query = db_query($sql);
	while($data = mysqli_fetch_object($query))
	{
	$pi++;
	

	$values[$pi]['emp_id'] = $data->emp_id;
	
		$late_panelty = 0;
		$leave_days_lv = $data->panalty_lv;
		$leave_days_lwp = 0;
		$new_emp_days = 0;
		$new_emp_off = 0;
		$new_emp_holy_day = 0;
		
		
		$late_panelty = (int)(((@($data->l_min/30))>(@($data->l_status/3)))?(@($data->l_min/30)):(@($data->l_status/3))); 

$sch_sql = "select s.schedule_type, count(1) sch_count from hrm_schedule_info s, hrm_roster_allocation r where r.shedule_1 = s.id and r.PBI_ID='".$data->PBI_ID."' and r.roster_date between '".$start_date."' and '".$end_date."' and s.schedule_type != 'Regular' group by s.schedule_type";
$sch_query = db_query($sch_sql);
	while($sch_data = mysqli_fetch_object($sch_query))
	{
	if($sch_data->schedule_type=='Offday'){
	$offday_in_month[$data->PBI_ID] = $sch_data->sch_count;}
	elseif($sch_data->schedule_type=='Absent'){
	$absent_in_month[$data->PBI_ID] = $sch_data->sch_count;}
	elseif($sch_data->schedule_type=='Leave'){
	$leave_in_month[$data->PBI_ID] = $sch_data->sch_count;}
	elseif($sch_data->schedule_type=='IOM'){
	$iom_in_month[$data->PBI_ID] = $sch_data->sch_count;}
	}

if($start_date<$data->PBI_DOC2){
$absent_in_month[$data->PBI_ID] = $absent_in_month[$data->PBI_ID] + $leave_in_month[$data->PBI_ID] + $data->lv;
$leave_in_month[$data->PBI_ID] = 0;
}
else {$leave_in_month[$data->PBI_ID] = $leave_in_month[$data->PBI_ID] + find_a_field('hrm_leave_info','sum(total_days)','PBI_ID="'.$data->PBI_ID.'" and s_date between "'.$start_date.'" and "'.$end_date.'"  and leave_status="GRANTED" ');}
		
		if(strtotime($data->PBI_DOJ)>$startTime){
		$new_emp_days =ceil(($endTime - strtotime($data->PBI_DOJ))/(3600*24))+1;}
		else{
		$new_emp_days = $days_mon;}

	
	$values[$pi]['td'] = $new_emp_days;
	$values[$pi]['od'] = $offday_in_month[$data->PBI_ID];
	$values[$pi]['hd'] = 0;
	$values[$pi]['lt'] = $late_panelty*.5;

	echo $iom_in_month[$data->PBI_ID];
	echo '*'.$offiomlv_in_month[$data->PBI_ID];
	
	$values[$pi]['lv']  = $leave_in_month[$data->PBI_ID];
	$values[$pi]['lwp'] = $absent_in_month[$data->PBI_ID];
	$values[$pi]['pre'] = $data->pre + $iom_in_month[$data->PBI_ID] - $offiomlv_in_month[$data->PBI_ID];

	$values[$pi]['pay'] = $values[$pi]['pre'] + $values[$pi]['lv'] + $values[$pi]['hd'] + $values[$pi]['od'] - $values[$pi]['lt'];
	$values[$pi]['ab']  = (($values[$pi]['td'])-($values[$pi]['pre'] + $values[$pi]['lv'] + $values[$pi]['lwp'] + $values[$pi]['hd'] + $values[$pi]['od']));
	$values[$pi]['lv']  = $leave_in_month[$data->PBI_ID]+$leave_days_lv;
	
}
for($y=1;$y<=$pi;$y++)
{
$found = find_a_field('hrm_attendence_final','1','PBI_ID="'.$values[$y]['emp_id'].'" and mon="'.$mon.'" and year="'.$year.'"');


if($found==0)
			{
$sql = "INSERT INTO `hrm_attendence_final` 
(`mon`, `year`, `PBI_ID`, 
`td`, `od`, `hd`, `lt`, `ab`, `lv`,`lwp`, `pre`, `pay`, `entry_at`, `entry_by`) values
('".$mon."','".$year."','".$values[$y]['emp_id']."',
'".$values[$y]['td']."','".$offday_in_month[$values[$y]['emp_id']]."', '0','".$values[$y]['lt']."','".$values[$y]['ab']."','".$values[$y]['lv']."','".$values[$y]['lwp']."','".$values[$y]['pre']."','".$values[$y]['pay']."','".date('Y-m-d H:i:s')."','".$_SESSION['user']['id']."')";
db_query($sql);
			}
			else
			{
$sql = "Update `hrm_attendence_final` set 

td='".$values[$y]['td']."', od='".$offday_in_month[$values[$y]['emp_id']]."',hd='0', lt='".$values[$y]['lt']."', ab='".$values[$y]['ab']."', lv='".$values[$y]['lv']."', lwp='".$values[$y]['lwp']."', pre='".$values[$y]['pre']."',pay='".$values[$y]['pay']."', entry_at='".date('Y-m-d H:i:s')."', entry_by='".$_SESSION['user']['id']."'

where mon='".$mon."' and year='".$year."' and PBI_ID='".$values[$y]['emp_id']."'"; 

db_query($sql);
}		
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

              <tr>

                <td height="40" colspan="4" bgcolor="#00FF00"><div align="center" class="style1">Salary Process - hrm_attendence_final (Roster) </div></td>
                </tr>

              <tr>
                <td>Employee ID</td>
                <td colspan="3"><label>
                  <input type="text" name="emp_id" id="emp_id" value="<?=$_POST['emp_id']?>" />
                </label></td>
              </tr>
              <tr>
                <td>Company:</td>
                <td colspan="3"><span class="oe_form_group_cell">
                  <select name="PBI_ORG" style="width:160px;" id="PBI_ORG">
                    <? foreign_relation('user_group','id','group_name',$PBI_ORG);?>
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

 </form>   </div>



<?php

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>

