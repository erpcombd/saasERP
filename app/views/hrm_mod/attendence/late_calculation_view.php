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



// -------------------------------------- start process for late calculation ----------------------------
if(isset($_POST["upload"])){

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


echo ' Process Complete';
}
?>


<style type="text/css">
<!--
.style1 {font-size: 24px}
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
                <td height="40" colspan="4" bgcolor="#00FF00"><div align="center" class="style1">Late Calculation Process </div></td>
                </tr>

<tr><td>Employee ID</td>
<td colspan="3"><input type="text" name="emp_id" id="emp_id" value="<?=$_POST['emp_id']?>" /></td></tr>
<tr><td>Company:</td>
<td colspan="3"><span class="oe_form_group_cell">
<select name="PBI_ORG" style="width:160px;" id="PBI_ORG">
<? foreign_relation('user_group','id','group_name',$PBI_ORG);?>
</select>
</span></td></tr>

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

                    <p><strong>For remove old late calculation Information.</strong></p>
                    <div align="center">
                      <p align="left">UPDATE hrm_att_summary2 set<br />
                        late_min=0,grace_no=0,final_late_min=0,final_late_status=0<br />
                        WHERE<br />
                        att_date BETWEEN '2018-02-26' AND '2018-03-25'<br />
                        and emp_id in(9011);</p>
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