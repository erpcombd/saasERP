<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";




do_calander('#m_date');


if($_POST['mon']!='')	$mon=$_POST['mon'];
else					$mon=date('n');






if(isset($_POST["upload"]))
{
if($_POST['s_date']!='' && $_POST['e_date']!=''){

$start_date = date('Y-m-d',strtotime($_POST['s_date']));
$end_date = date('Y-m-d',strtotime($_POST['e_date']));

$date_con = " and h.xdate BETWEEN '".$start_date."' AND '".$end_date."'";
}

// Schedule Info Fetch All

$sql = 'select * from hrm_schedule_info';
$query  =db_query($sql);
while($data=mysqli_fetch_object($query)){
    $sch_start[$data->id] = $data->office_start_time;
    $sch_end[$data->id] = $data->office_end_time;
    $sch_mid[$data->id] = $data->office_mid_time;
	$sch_last[$data->id] = $data->shift_last_time;
}

// Roster Schedule Fetch All
$sql = "select * from hrm_roster_allocation where roster_date  BETWEEN '".$start_date."' AND '".$end_date."' ";
$query  =db_query($sql);
while($data=mysqli_fetch_object($query)){
    $roster_assign[$data->PBI_ID][$data->roster_date] = $data->shedule_1;
}

$datetime = date('Y-m-d H:i:s');

$_POST['emp_id'] = find_a_field('personnel_basic_info','PBI_ID','PBI_CODE="'.$_POST['emp_id'].'"');
if($_POST['emp_id']>0) 	$emp_id=$_POST['emp_id'];
$PBI_ORG = $_POST['PBI_ORG'];

if($_POST['JOB_LOCATION']>0) $job_location_con = " and p.JOB_LOCATION='".$_POST['JOB_LOCATION']."'";
if($_POST['department']>0) $department_con = " and p.DEPT_ID='".$_POST['department']."'";
$PBI_ORG = $_POST['PBI_ORG'];
if($PBI_ORG>0) $ORG_con = " and p.PBI_ORG='".$PBI_ORG."'";
if(isset($emp_id)){ $emp_id_con=" and EMP_CODE IN (".$_POST['emp_id'].")"; }
$min_in=-1.5;


/*
  $sql = "SELECT p.PBI_ID,a.roster_date,min(d.xtime) in_time,max(d.xtime) out_time,a.shedule_1,s.max_output_hr , p.DEPT_ID
FROM hrm_attdump d, hrm_roster_allocation a , hrm_schedule_info s, personnel_basic_info p 
WHERE 
a.PBI_ID=p.PBI_ID and d.xenrollid=a.PBI_ID and p.employee_type_id =1
and d.xdate in (d.xdate,DATE_ADD(d.xdate, INTERVAL 1 DAY)) 
and a.roster_date between '".$start_date."' and '".$end_date."' and shedule_1=s.id 
and d.xtime between DATE_ADD(concat(a.roster_date,' ',s.office_start_time), INTERVAL ".$min_in." HOUR) 
and DATE_ADD(concat(a.roster_date,' ',s.office_start_time), INTERVAL s.max_output_hr HOUR)  and s.office_start_time != s.office_end_time
".$job_location_con.$emp_id_con.$ORG_con."
group by a.PBI_ID,a.roster_date
";*/
	
	//24 
	
//test

  $sql = "SELECT p.PBI_ID,a.roster_date,min(d.xtime) in_time,max(d.xtime) out_time,a.shedule_1,s.max_output_hr ,s.min_in, p.DEPT_ID
FROM hrm_attdump d, hrm_roster_allocation a , hrm_schedule_info s, personnel_basic_info p 
WHERE 
a.PBI_ID=p.PBI_ID and d.xenrollid=a.PBI_ID and p.employee_type_id=1 
and d.xdate in (d.xdate,DATE_ADD(d.xdate, INTERVAL 1 DAY)) 
and a.roster_date between '".$start_date."' and '".$end_date."' and shedule_1=s.id 
and d.xtime between DATE_ADD(concat(a.roster_date,' ',s.office_start_time), INTERVAL s.min_in HOUR) 
and DATE_ADD(concat(a.roster_date,' ',s.office_start_time), INTERVAL s.max_output_hr HOUR)  and s.office_start_time != s.office_end_time
".$job_location_con.$emp_id_con.$ORG_con."
group by a.PBI_ID,a.roster_date
";

//end test	
	
	$query = db_query($sql);

	while($data = mysqli_fetch_object($query))

	{
	
	$sl++;
	//if($roster_assign[$data->PBI_ID][$data->roster_date]<1)
	 $value[$sl]['sch_in_time']  = $office_in_times  = $sch_start[$data->shedule_1];
	 $value[$sl]['sch_mid_time']  = $office_mid_times  = $sch_mid[$data->shedule_1];
	//else  
		//$value[$sl]['sch_in_time']  = $office_in_times  = $sch_start[$roster_assign[$data->PBI_ID][$data->roster_date]];
	
	//if($roster_assign[$data->PBI_ID][$data->roster_date]<1)
	$value[$sl]['sch_out_time'] = $office_out_times = $sch_end[$data->shedule_1];
	
	$value[$sl]['shift_last_time'] = $office_last_times = $sch_last[$data->shedule_1];
//	else 
		//$value[$sl]['sch_out_time']  = $office_in_times  = $sch_end[$roster_assign[$data->PBI_ID][$data->roster_date]];
	
	
	

	$value[$sl]['emp_id'] = $data->PBI_ID;

	$value[$sl]['att_date'] = $data->roster_date;

	$value[$sl]['sch_id'] = $data->shedule_1;

	$value[$sl]['in_time'] = $data->in_time; $tt1 = explode(" ", $data->in_time); $value[$sl]['in_time2'] = end($tt1);
	
	if($data->in_time!=$data->out_time)  $value[$sl]['out_time'] = $data->out_time; $tt2 = explode(" ", $data->out_time); $value[$sl]['out_time2'] = end($tt2);
	
	
	
	

	}
	
	
	
///////////////////////////////////////////test

 $sql = "SELECT p.PBI_ID,a.roster_date,min(d.xtime) in_time,max(d.xtime) out_time,a.shedule_1,s.max_output_hr ,s.min_in, p.DEPT_ID 
 FROM hrm_attdump d, hrm_roster_allocation a , hrm_schedule_info s, personnel_basic_info p 
WHERE 
a.PBI_ID=p.PBI_ID and d.xenrollid=a.PBI_ID and d.xdate in (d.xdate,DATE_ADD(d.xdate, INTERVAL 1 DAY)) 
and a.roster_date between '".$start_date."' and '".$end_date."' and shedule_1=s.id and p.employee_type_id=1 
and d.xtime between DATE_ADD(concat(a.roster_date,' ',s.office_start_time), INTERVAL s.min_in HOUR) 
and DATE_ADD(concat(a.roster_date,' ',s.office_start_time), INTERVAL s.max_output_hr HOUR)  and s.office_start_time = s.office_end_time
".$job_location_con.$emp_id_con.$ORG_con."
group by a.PBI_ID,a.roster_date
";

	
	
	$query = db_query($sql);

	while($data = mysqli_fetch_object($query))

	{
	
	$sl++;
	//if($roster_assign[$data->PBI_ID][$data->roster_date]<1)
	 $value[$sl]['sch_in_time']  = $office_in_times  = $sch_start[$data->shedule_1];
	 $value[$sl]['sch_mid_time']  = $office_mid_times  = $sch_mid[$data->shedule_1];
	 
	//else  
		//$value[$sl]['sch_in_time']  = $office_in_times  = $sch_start[$roster_assign[$data->PBI_ID][$data->roster_date]];
	
	//if($roster_assign[$data->PBI_ID][$data->roster_date]<1)
	$value[$sl]['sch_out_time'] = $office_out_times = $sch_end[$data->shedule_1];
	
	$value[$sl]['shift_last_time'] = $office_last_times = $sch_last[$data->shedule_1];
//	else 
		//$value[$sl]['sch_out_time']  = $office_in_times  = $sch_end[$roster_assign[$data->PBI_ID][$data->roster_date]];
		
		


	$value[$sl]['emp_id'] = $data->PBI_ID;

	$value[$sl]['att_date'] = $data->roster_date;

	$value[$sl]['sch_id'] = $data->shedule_1;

	$value[$sl]['in_time'] = $data->in_time; $tt1 = explode(" ", $data->in_time); $value[$sl]['in_time2'] = end($tt1);
	
	//if($data->in_time!=$data->out_time) 
	$value[$sl]['out_time'] = $data->out_time; $tt2 = explode(" ", $data->out_time); $value[$sl]['out_time2'] = end($tt2); echo $value[$sl]['out_time'] = $tt1[0].' '.end($tt2);

$min_in = 7;	
			 $sqls = "SELECT min(d.xtime) in_time,max(d.xtime) out_time
FROM hrm_attdump d
WHERE 
d.xdate= '".$tt1[0]."'  and d.EMP_CODE=".$data->PBI_ID."
and d.xtime between DATE_ADD(concat(d.xdate,' ','".$value[$sl]['in_time2']."'), INTERVAL 1 HOUR) 
and DATE_ADD(concat(d.xdate,' ','15:00:00'), INTERVAL ".(7)." HOUR)  

";

 $querys = db_query($sqls);
 $datas = mysqli_fetch_object($querys);
 
 $value[$sl]['first_out'] = $datas->in_time;
 $value[$sl]['second_in'] = $datas->out_time;
 
 

//"SELECT min(d.xtime) in_time,max(d.xtime) out_time FROM hrm_attdump d WHERE d.xdate= '2024-02-01' and d.EMP_CODE='9470' AND d.xtime BETWEEN DATE_ADD(CONCAT(d.xdate, ' ', '08:00:00'), INTERVAL 1 HOUR) AND DATE_ADD(CONCAT(d.xdate, ' ', '15:00:00'), INTERVAL 7 HOUR)";

	}

////////////////////////////////////////////////////end test



for($x=1;$x<=$sl;$x++){

			$found = find_a_field('hrm_att_summary','1','emp_id="'.$value[$x]['emp_id'].'" and att_date="'.$value[$x]['att_date'].'"');

			if($found==0)

			{
			
			
 $sql="INSERT INTO hrm_att_summary 
(emp_id, att_date,sch_id,in_time,in_time2,out_time,out_time2, dayname,sch_in_time,sch_mid_time,
sch_out_time,
first_out,second_in,shift_last_time)
VALUES 

('".$value[$x]['emp_id']."','".$value[$x]['att_date']."', '".$value[$x]['sch_id']."', 
'".$value[$x]['in_time']."', '".$value[$x]['in_time2']."','".$value[$x]['out_time']."',
 '".$value[$x]['out_time2']."',
dayname('".$value[$x]['att_date']."'),
 '".$value[$x]['sch_in_time']."',
 '".$value[$x]['sch_mid_time']."','".$value[$x]['sch_out_time']."',
 '".$value[$x]['first_out']."', '".$value[$x]['second_in']."', '".$value[$x]['shift_last_time']."')";
 
$query=db_query($sql);

			}

			else

			{

			 $sql='update hrm_att_summary set sch_id="'.$value[$x]['sch_id'].'",

in_time="'.$value[$x]['in_time'].'",in_time2="'.$value[$x]['in_time2'].'", out_time="'.$value[$x]['out_time'].'",out_time2="'.$value[$x]['out_time2'].'", sch_in_time="'.$value[$x]['sch_in_time'].'",sch_mid_time="'.$value[$x]['sch_mid_time'].'",sch_out_time="'.$value[$x]['sch_out_time'].'",
first_out="'.$value[$x]['first_out'].'" , second_in="'.$value[$x]['second_in'].'" , shift_last_time="'.$value[$x]['shift_last_time'].'" 
where  emp_id="'.$value[$x]['emp_id'].'" and att_date="'.$value[$x]['att_date'].'" ';

				$query=db_query($sql);

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

<tr><td height="40" colspan="4" bgcolor="#00FF00"><div align="center" class="style1">Collect Machine Data Factory </div></td></tr>



<tr>

  <td>Employee Code </td>

  <td colspan="3"><input type="text" name="emp_id" id="emp_id" value="<?=$_POST['emp_id']?>" /></td>

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

 <td>Location:</td>

  <td colspan="3"><span class="oe_form_group_cell">

    <select name="JOB_LOCATION" style="width:160px;" id="JOB_LOCATION" class="form-control">

        

          <? foreign_relation('office_location','ID','LOCATION_NAME',$_POST['JOB_LOCATION']);?>

      </select>

  </span></td>

</tr>
<tr>

 <td>Department:</td>

  <td colspan="3"><span class="oe_form_group_cell">

    <select name="department"  class="form-control" id="department">



	  <option></option>



        <? foreign_relation('department','DEPT_ID','DEPT_DESC',$department,' 1 order by DEPT_DESC');?>
      </select>

  </span></td>

</tr>
<!--<tr>

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

                </tr>-->

              <!--<tr>

                <td>Year :</td>

                <td colspan="3"><select name="year" style="width:160px;" id="year" required="required">

				  <option <?=($year=='2021')?'selected':''?>>2021</option>

                </select></td>

                </tr>-->

				

				<tr>

                <td>Start Date:</td>

                <td colspan="3"><input type="date" name="s_date" id="s_date" value="<?=$_POST['s_date']?>" /></td>

                </tr>

				

				<tr>

                <td>End Date:</td>

                <td colspan="3"><input type="date" name="e_date" id="e_date" value="<?=$_POST['e_date']?>" /></td>

                </tr>

              

              <tr>



                <td colspan="4">

                  <div align="center">

                    <input name="upload" class="btn1 btn1-bg-submit" type="submit" id="upload" value="Sync All Data" />

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




