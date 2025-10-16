<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
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

$start_date = $syear.'-'.($smon).'-26';
//$start_date = '2018-02-26';

$startTime = $days1 = strtotime($start_date);
$days_mon = date('t',$startTime);

$end_date   = $year.'-'.($mon).'-25';
//$end_date   = '2018-03-25';


$endTime = $days2=mktime(0,0,0,$mon,26,$year);

for ($i = $startTime; $i <= $endTime; $i = $i + 86400) {
$day   = date('l',$i);
${'day'.date('N',$i)}++;} 
$r_count=${'day5'};

if($_POST['emp_id']>0) 	$emp_id=$_POST['emp_id'];

if(isset($emp_id)){
$emp_id_con=" and xenrollid IN (".$_POST['emp_id'].")";
$emp_id_con2=" and emp_id IN (".$_POST['emp_id'].")";
}


//START 1 Deleting All Previous Data
$sql = "delete h.* FROM hrm_att_summary2 h, personnel_basic_info p
WHERE p.PBI_ID=h.emp_id 
and p.employee_type = 'Non Roster'
and h.att_date BETWEEN '".$start_date."' AND '".$end_date."' 
".$ORG_con.$emp_id_con2."";
$query = db_query($sql);	
	
// findout iom and leave then insert
$sql = "insert into hrm_att_summary2 select h.* from hrm_att_summary h, personnel_basic_info p where p.PBI_ID=h.emp_id 
and p.employee_type = 'Non Roster' and h.att_date BETWEEN '".$start_date."' AND '".$end_date."' and (iom_sl_no > 0 or leave_id > 0) 
".$ORG_con.$emp_id_con2;
$query = db_query($sql);	
	
	
	
 $sql = "SELECT h.xenrollid , h.xdate , min(h.xtime) in_time, max(h.xtime) out_time 
FROM hrm_attdump h, personnel_basic_info p
WHERE h.xenrollid = p.PBI_ID
and h.xdate BETWEEN '".$start_date."' AND '".$end_date."' ".$emp_id_con."
and p.employee_type = 'Non Roster'
GROUP BY h.xenrollid , h.xdate
";	



	$query = db_query($sql);
	while($data = mysqli_fetch_object($query))
	{
	$sl++;
	$value[$sl]['emp_id'] = $data->xenrollid;
	$value[$sl]['att_date'] = $data->xdate;
	$value[$sl]['in_time'] = $data->in_time;
	$value[$sl]['out_time'] = $data->out_time;
	}

for($x=1;$x<=$sl;$x++)
{
			$found = find_a_field('hrm_att_summary2','1','emp_id="'.$value[$x]['emp_id'].'" and att_date="'.$value[$x]['att_date'].'"');
		
			if($found==0)
			{
				$sql="INSERT INTO hrm_att_summary2 
				(emp_id, att_date, in_time, out_time, iom_entry_at, iom_entry_by, dayname)
				VALUES 
('".$value[$x]['emp_id']."','".$value[$x]['att_date']."', '".$value[$x]['in_time']."', '".$value[$x]['out_time']."', '".$datetime."', '".$_SESSION['user']['id']."', dayname('".$value[$x]['att_date']."'))";
				$query=db_query($sql);
			}
			else
			{
				$sql='update hrm_att_summary2 set 
in_time="'.$value[$x]['in_time'].'", out_time="'.$value[$x]['out_time'].'", iom_entry_by="'.$value[$x]['emp_id'].'", iom_entry_at="'.$datetime.'"
				where  emp_id="'.$value[$x]['emp_id'].'" and att_date="'.$value[$x]['att_date'].'" ';
				$query=db_query($sql);
			}
}


// office time update


		$year = $_POST['year'];
		$mon = $_POST['mon'];
		if($mon == 1)
		{
		$syear = $year - 1;
		$smon = 12;
		} else{
		$syear = $year;
		$smon =  $mon - 1;
		}
		
		$datetime = date('Y-m-d H:i:s');
		$start_date = $syear.'-'.($smon).'-26';
		//$start_date = '2018-02-26';
		
		$startTime = $days1 = strtotime($start_date);
		$days_mon = date('t',$startTime);
		
		$end_date   = $year.'-'.($mon).'-25';
		//$end_date   = '2018-03-25';
		$endTime = $days2=mktime(0,0,0,$mon,26,$year);

$q1="UPDATE hrm_att_summary2 s, personnel_basic_info p SET  s.sch_in_time = '09:31:00', s.sch_out_time = '18:00:00'
WHERE s.emp_id=p.PBI_ID and p.employee_type = 'Non Roster' and  s.att_date BETWEEN '".$start_date."' AND '".$end_date."' ";
$query=db_query($q1);

$q2="UPDATE hrm_att_summary2 h, hrm_leave_info l, personnel_basic_info p SET h.sch_in_time = '13:01:00', h.sch_out_time = '18:00:00'
WHERE  h.emp_id=p.PBI_ID and p.employee_type = 'Non Roster' and h.leave_id=l.id and h.leave_duration = 0.5 
and l.half_or_full='First Half' and h.att_date BETWEEN '".$start_date."' AND '".$end_date."' ";
$query=db_query($q2);


$q3="UPDATE hrm_att_summary2 h, hrm_leave_info l, personnel_basic_info p SET h.sch_in_time = '09:31:00', h.sch_out_time = '13:00:00'
WHERE  h.emp_id=p.PBI_ID and p.employee_type = 'Non Roster' and  h.leave_id=l.id and h.leave_duration = 0.5
and l.half_or_full='Last Half' and h.att_date BETWEEN '".$start_date."' AND '".$end_date."' ";
$query=db_query($q3);

$q4="UPDATE hrm_att_summary2 set dayname = dayname(att_date) 
WHERE dayname='' and att_date BETWEEN '".$start_date."' AND '".$end_date."' ";
$query=db_query($q4);


// end office time update


// late calculation


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
$start_date = $syear.'-'.($smon).'-26';
$startTime = $days1 = strtotime($start_date);
$days_mon = date('t',$startTime);
$end_date   = $year.'-'.($mon).'-25';
$endTime = $days2= strtotime($end_date);

// this is for only single late or iom remover tools
if($_POST['emp_id']!=''){
$clearSql = "UPDATE hrm_att_summary2
SET
late_min = '0',
grace_no = '0',
final_late_min = '0',
final_late_status = '0'
WHERE
att_date BETWEEN  '".$start_date."' AND  '".$end_date."' 
AND emp_id ='".$_POST['emp_id']."'";
// AND (iom_sl_no != '0' OR leave_id != '0')";
db_query($clearSql);
}

for ($i = $startTime; $i <= $endTime; $i = $i + 86400) {
$day   = date('l',$i);
${'day'.date('N',$i)}++;} 
$r_count=${'day5'};



//1------------------>>>>>--------------------------2
$holysql = "select holy_day from salary_holy_day where holy_day between '".$start_date."' AND '".$end_date."'";
$holy_query = db_query($holysql);
	while($holy_data = mysqli_fetch_object($holy_query))
	{
	$holy_final_sql = "update hrm_att_summary2 set holyday = 1 where att_date='".$holy_data->holy_day."'";
	db_query($holy_final_sql);
	}

$emp_id = $_POST['emp_id'];
$PBI_ORG = $_POST['PBI_ORG'];
if($emp_id>0) $emp_con = " and h.emp_id='".$emp_id."'";
if($PBI_ORG>0) $ORG_con = " and p.PBI_ORG='".$PBI_ORG."'";

$sql = "SELECT h.id,h.emp_id,h.in_time,h.att_date,h.sch_in_time 
FROM hrm_att_summary2 h,personnel_basic_info p
WHERE p.PBI_ID=h.emp_id 
and h.att_date BETWEEN '".$start_date."' AND '".$end_date."' 
and h.dayname!='Friday' and h.holyday=0 
and h.in_time>concat(att_date,' ',sch_in_time) 
and h.leave_duration!=1 and h.iom_sl_no=0 ".$emp_con.$ORG_con." 
and p.PBI_DEPARTMENT NOT IN('Admin (Support Service Section)','TRS','GYM')
and p.JOB_LOCATION in(1,70) and p.employee_type = 'Non Roster'
order by emp_id,att_date";

// and h.att_date not in ('2018-08-01','2018-08-04','2018-08-05','2018-08-06')
	
	$query = db_query($sql);
	while($data = mysqli_fetch_object($query))
	{
$emp_id = $data->emp_id;

if($emp_id==$old_emp_id) $grace_no++; else $grace_no=1;


$in_time = strtotime($data->in_time);
$from_time = strtotime($data->att_date.' '.$data->sch_in_time);
$late_min = round(abs($in_time - $from_time) / 60,2);

if($grace_no<6) 
{$grace = $grace_no;
if($late_min<11)  {$final_late_min = 0;$final_late_status = 0;}
else {

if($late_min>70) $final_late_min = 60;
else $final_late_min = $late_min - 10;

$final_late_status = 1;}
} else {$grace = 0;

if($late_min>60) $final_late_min = 60;
else $final_late_min = $late_min;

}


$update_sql = "update hrm_att_summary2 
set late_min='".$late_min."',grace_no='".$grace."',final_late_min='".$final_late_min."',
final_late_status='".$final_late_status."',process_time='".$datetime."' 
where id=".$data->id;

db_query($update_sql);
$old_emp_id = $data->emp_id;
}


// end late calculation
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
<tr><td height="40" colspan="4" bgcolor="#00FF00"><div align="center" class="style1">Collect Machine Data For User View</div></td></tr>

<tr>
  <td>Employee Code </td>
  <td colspan="3"><input type="text" name="emp_id" id="emp_id" value="<?=$_POST['emp_id']?>" / class="form-control"></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td colspan="3">&nbsp;</td>
</tr>
<tr>
<td width="20%">Month :</td>
<td colspan="3"><span class="oe_form_group_cell">
<select name="mon" style="width:160px;" id="mon" required="required" class="form-control">


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
                <td colspan="3"><select name="year" style="width:160px;" id="year" required="required" class="form-control">
                  <option <?=($year=='2021')?'selected':''?>>2021</option>
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



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>