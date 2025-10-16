<?

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

do_calander('#m_date');

$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';


$table='hrm_inout';

$unique='id';



if(isset($_POST["upload"]))
{

$year = $_POST['year'];
$mon = $_POST['mon'];
$datetime = date('Y-m-d H:i:s');
$start_date = $year.'-'.($mon).'-01';
$startTime = $days1 = strtotime($start_date);
$days_mon = date('t',$startTime);
$end_date   = $year.'-'.($mon).'-'.$days_mon;
$endTime = $days2=mktime(0,0,0,$mon,$days_mon,$year);

$holy_day=find_a_field('salary_holy_day','count(holy_day)','holy_day between "'.$start_date.'" and "'.$end_date.'"');

for ($i = $startTime; $i <= $endTime; $i = $i + 86400) {
$day   = date('l',$i);
${'day'.date('N',$i)}++; }
$r_count=${'day5'};

$sql = "SELECT emp_id,sum(leave_duration) lv
FROM `hrm_att_summary` h
WHERE `att_date` BETWEEN '".$start_date."' AND '".$end_date."'  And leave_id>0 
 AND `dayname` = 'Friday' group by emp_id";
	
	
	
	$query = db_query($sql);
	while($data = mysqli_fetch_object($query))
	{
	$total_lv_fri[$data->emp_id] = $data->lv;
	}
$sql = "SELECT emp_id,sum(leave_duration) lv
FROM `hrm_att_summary` h, salary_holy_day d
WHERE att_date=holy_day and `att_date` BETWEEN '".$start_date."' AND '".$end_date."'  And leave_id>'0'
group by emp_id";
	
	
	
	$query = db_query($sql);
	while($data = mysqli_fetch_object($query))
	{
	$total_holyday_leave[$data->emp_id] = $data->lv;
	}


$sql = "SELECT emp_id,(count(1)-sum(leave_duration)) pre, sum(final_late_min) l_min,sum(final_late_status) l_status,p.PBI_DOJ,p.PBI_ID,p.PBI_DUE_DOJ
FROM `hrm_att_summary` h,personnel_basic_info p
WHERE  p.PBI_ORG =11 and p.PBI_ID=h.emp_id and `att_date` BETWEEN '".$start_date."' AND '".$end_date."'  And leave_duration!=1  
AND `dayname` != 'Friday'  group by emp_id";
	
	// emp_id = 9133 and
	
	$query = db_query($sql);
	while($data = mysqli_fetch_object($query))
	{
	$pi++;
	//echo $startTime; echo '<br>'.strtotime($data->PBI_DOJ);
	$values[$pi]['emp_id'] = $data->emp_id;
	
		$late_panelty = 0;
		$leave_days_lv = 0;
		$leave_days_lwp = 0;
		$new_emp_days = 0;
		$new_emp_off = 0;
		$new_emp_holy_day = 0;
		
		
		$late_panelty = (int)(((@($data->l_min/30))>(@($data->l_status/3)))?(@($data->l_min/30)):(@($data->l_status/3))); 
		if(strtotime($data->PBI_DOJ)>$startTime)
		{
		$new_emp_days =ceil(($endTime - strtotime($data->PBI_DOJ))/(3600*24))+1;
		$new_emp_holy_day=find_a_field('salary_holy_day','count(holy_day)','holy_day between "'.$data->PBI_DOJ.'" and "'.$year.'-'.$mon.'-'.$days_mon.'"');
		${'day5'} = 0 ; for ($i = strtotime($data->PBI_DOJ); $i <= $endTime; $i = $i + 86400) {$day   = date('l',$i);${'day'.date('N',$i)}++;}
		$new_emp_off=${'day5'};
		}
		else
		{
		$new_emp_days = $days_mon;
		$new_emp_off = $r_count;
		$new_emp_holy_day = $holy_day;
		}
		
		// leave
		
			if($start_date>$data->PBI_DUE_DOJ)
{
$leave_days_lwp = find_a_field('hrm_leave_info','sum(total_days)','PBI_ID="'.$data->PBI_ID.'" and type="LWP (Leave Without Pay)" and s_date between "'.$start_date.'" and "'.$end_date.'" ');
$leave_days_lv = find_a_field('hrm_leave_info','sum(total_days)','PBI_ID="'.$data->PBI_ID.'" and type!="LWP (Leave Without Pay)" and s_date between "'.$start_date.'" and "'.$end_date.'" ');
}
else
{
$leave_days_lwp = find_a_field('hrm_leave_info','sum(total_days)','PBI_ID="'.$data->PBI_ID.'" and s_date between "'.$start_date.'" and "'.$end_date.'" ');
$leave_days_lv = 0;
}

	$values[$pi]['td'] = $new_emp_days;
	$values[$pi]['od'] = $new_emp_off - $total_lv_fri[$data->PBI_ID];
	$values[$pi]['hd'] = $new_emp_holy_day - $total_holyday_leave[$data->PBI_ID];
	$values[$pi]['lt'] = $late_panelty*.5;
	
	$values[$pi]['lv']  = $leave_days_lv;
	$values[$pi]['lwp'] = $leave_days_lwp;
	$values[$pi]['pre'] = $data->pre;
	//$values[$pi]['pre'] = $new_emp_days - ($leave_days_lv + $leave_days_lwp + $new_emp_holy_day + $values[$pi]['od']);
	$values[$pi]['pay'] = $values[$pi]['pre'] + $values[$pi]['lv'] + $values[$pi]['hd'] + $values[$pi]['od'] - $values[$pi]['lt'];
	$values[$pi]['ab'] = (($values[$pi]['td'])-($values[$pi]['pre'] + $values[$pi]['lv'] + $values[$pi]['lwp'] + $values[$pi]['hd'] + $values[$pi]['od']));
	
	



	}
for($y=1;$y<=$pi;$y++)
{

			$found = find_a_field('hrm_attendence_final','1','PBI_ID="'.$values[$y]['emp_id'].'" and mon="'.$mon.'" and year="'.$year.'"');




			if($found==0)
			{
$sql = "INSERT INTO `hrm_attendence_final` 
(`mon`, `year`, `PBI_ID`, 
`td`, `od`, `hd`, `lt`, `ab`, `lv`,`lwp`, `pre`, `pay`, `entry_at`) values
('".$mon."','".$year."','".$values[$y]['emp_id']."',
'".$values[$y]['td']."','".$values[$y]['od']."', '".$values[$pi]['hd']."','".$values[$pi]['lt']."','".$values[$y]['ab']."','".$values[$y]['lv']."','".$values[$y]['lwp']."','".$values[$y]['pre']."','".$values[$y]['pay']."','".date('Y-m-d H:i:s')."')";
db_query($sql);
			}
			else
			{
$sql = "Update `hrm_attendence_final` set 

td='".$values[$y]['td']."', od='".$values[$y]['od']."',hd='".$values[$y]['hd']."',lt='".$values[$y]['lt']."',ab='".$values[$y]['ab']."',lv='".$values[$y]['lv']."',lwp='".$values[$y]['lwp']."',pre='".$values[$y]['pre']."',pay='".$values[$y]['pay']."',entry_at='".date('Y-m-d H:i:s')."'

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
.style3 {	color: #FF0000;
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

                <td height="40" colspan="4" bgcolor="#00FF00"><div align="center" class="style1">Upload Machine Monthly Attendence (RCB) </div></td>
                </tr>

              <tr>
                <td width="20%">Month :</td>
                <td colspan="3"><span class="oe_form_group_cell">
                  <select name="mon" style="width:160px;" id="mon" required="required">
                  <option value="5" <?=($mon=='5')?'selected':''?>>May</option>
<!--                <option value="1" <?=($mon=='1')?'selected':''?>>Jan</option>
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
                    <option value="12" <?=($mon=='12')?'selected':''?>>Dec</option>-->
                  </select>
                </span></td>
                </tr>
              <tr>
                <td>Year :</td>
                <td colspan="3"><select name="year" style="width:160px;" id="year" required="required">
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
                      <p align="left"><span class="style3">Note: This is Monthly Sync System. BE Careful. </span></p>
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



<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>