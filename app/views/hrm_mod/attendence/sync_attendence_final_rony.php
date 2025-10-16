<?

ini_set('memory_limit', '512M');

session_start();

//


require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.core/init.php);
require_once SERVER_CORE."routing/layout.top.php";

$title="Late Calculation";

do_calander('#m_date');

$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';





$mon = date("n",strtotime($_POST['e_date']));

$year = date("Y",strtotime($_POST['e_date']));





// -------------------------------------- start process for late calculation ----------------------------

if(isset($_POST["upload"])){











$datetime = date('Y-m-d H:i:s');

$start_date = $_POST['s_date'];

$end_date = $_POST['e_date'];





$startTime  = strtotime($start_date);

$endTime  = strtotime($end_date);;





$emp_id  = find_a_field('personnel_basic_info','PBI_ID','PBI_CODE="'.$_POST['emp_id'].'"');

$PBI_ORG = $_POST['PBI_ORG'];

$job_loc =$_POST['JOB_LOCATION'];





//$start_date = date('Y-m-d',strtotime($_POST['f_date']));

//$end_date = date('Y-m-d',strtotime($_POST['t_date']));





if($emp_id>0)  $emp_con = " and h.emp_id='".$emp_id."'";

if($emp_id>0)  $pbi_con = " and p.PBI_ID='".$emp_id."'";

if($PBI_ORG>0) $ORG_con = " and p.PBI_ORG='".$PBI_ORG."'";

if($job_loc>0) $loc_con = " and p.JOB_LOC_ID='".$job_loc."'";

// Recalculate Start and Old Calculation Clean









if($emp_id!=''){

$clearSql = "UPDATE hrm_att_summary

SET

dayname = dayname(att_date),

late_min = '0',

final_late_min = '0',

final_late_status = '0',

sch_id = '',

sch_in_time = '',

sch_out_time = '',

sch_off_day = '',

early_min = '0',

final_early_min = '0',

final_early_status = '0',

grace_no = '0',

grace_pending_min = '0',

ot_min = '0',

ot_final_min = '0',

ot_final_min = '0',

holyday = '0',
present='0'

WHERE

att_date BETWEEN  '".$start_date."' AND  '".$end_date."'

AND emp_id ='".$emp_id."'";

db_query($clearSql);

}







// Holy Day sync for ALL

 $holysql = "select holy_day from salary_holy_day where holy_day between '".$start_date."' AND '".$end_date."' and job_loc_id in (".$job_loc.",3)";

$holy_query = db_query($holysql);

while($holy_data = mysqli_fetch_object($holy_query))

{

$holy_final_sql = "update hrm_att_summary s,personnel_basic_info p  set s.holyday = 1 where p.PBI_ID=s.emp_id and p.JOB_LOC_ID=".$job_loc." and  s.att_date='".$holy_data->holy_day."'";

db_query($holy_final_sql);

}







// Schedule Info Fetch All

$sql = 'select * from hrm_schedule_info';

$query  =db_query($sql);

while($data=mysqli_fetch_object($query)){

$sch_start[$data->id] = $data->office_start_time;

$sch_end[$data->id] = $data->office_end_time;

$sch_mid[$data->id] = $data->office_mid_time;

}

// Roster Schedule Fetch All

$sql = "select * from hrm_roster_allocation where roster_date  BETWEEN '".$start_date."' AND '".$end_date."' ";

$query  =db_query($sql);

while($data=mysqli_fetch_object($query)){

$roster_assign[$data->PBI_ID][$data->roster_date] = $data->shedule_1;

}

//over_time applicabel

$sql_ot = "select * from salary_info where 1";

$query_ot  =db_query($sql_ot);

while($data_ot=mysqli_fetch_object($query_ot)){

$ot_applicable[$data_ot->PBI_ID] = $data_ot->overtime_applicable;

}

// Main Data Fetch

 $sql = "SELECT h.*,  p.define_schedule, p.define_offday

FROM hrm_att_summary h,personnel_basic_info p

WHERE  p.PBI_ID=h.emp_id 

and h.att_date BETWEEN '".$start_date."' AND '".$end_date."'  ".$emp_con.$ORG_con.$loc_con." 

order by emp_id,att_date";

$query = db_query($sql);

while($data = mysqli_fetch_object($query))

{

$data->nextday_att_day = date('Y-m-d',strtotime($data->att_date)+(24*60*60));

$emp_id = $data->emp_id;

// Fetch Sch ID

if($roster_assign[$data->emp_id][$data->att_date]>0) $sch_id[$data->emp_id][$data->att_date] = $roster_assign[$data->emp_id][$data->att_date];

else $sch_id[$data->emp_id][$data->att_date] = $data->define_schedule;

// Fetch Sch Off Day (SCH NO-3)

if($roster_assign[$data->emp_id][$data->att_date]==3) $sch_off_day[$data->emp_id][$data->att_date] = 1;

elseif($data->define_offday==date('l', strtotime($data->att_date))) $sch_off_day[$data->emp_id][$data->att_date] = 1;

else $sch_off_day[$data->emp_id][$data->att_date] = 0;

// Fetch Sch TIME

$data->sch_in_time  = $sch_in_time[$data->emp_id][$data->att_date]  = $sch_start[$sch_id[$data->emp_id][$data->att_date]];

$data->sch_out_time = $sch_out_time[$data->emp_id][$data->att_date] = $sch_end[$sch_id[$data->emp_id][$data->att_date]];

$data->sch_mid_time = $sch_mid_time[$data->emp_id][$data->att_date] = $sch_mid[$sch_id[$data->emp_id][$data->att_date]];

// UPDATE SCH FOR HALF LEAVE & IOM 

if($data->leave_type == 'Early Half'||$data->iom_type == 'Early Half')

$data->sch_in_time  = $sch_in_time[$data->emp_id][$data->att_date]  = $sch_mid[$sch_id[$data->emp_id][$data->att_date]];

if($data->leave_type == 'Last Half'||$data->iom_type == 'Last Half')

$data->sch_out_time = $sch_out_time[$data->emp_id][$data->att_date] = $sch_mid[$sch_id[$data->emp_id][$data->att_date]];

// Fetch SCH FULL DAY TIME

$sch_in_datetime[$data->emp_id][$data->att_date] = $data->att_date.' '.$sch_in_time[$data->emp_id][$data->att_date];

$sch_out_datetime[$data->emp_id][$data->att_date]= $data->att_date.' '.$sch_out_time[$data->emp_id][$data->att_date];

if($data->sch_in_time>$data->sch_out_time) $sch_out_datetime[$data->emp_id][$data->att_date]= $data->nextday_att_day.' '.$sch_out_time[$data->emp_id][$data->att_date];

$sch_ins_datetime[$data->emp_id][$data->att_date] = strtotime($sch_in_datetime[$data->emp_id][$data->att_date]);

$sch_outs_datetime[$data->emp_id][$data->att_date]= strtotime($sch_out_datetime[$data->emp_id][$data->att_date]);

// FETCH IN OUT TIME

$ins_datetime[$data->emp_id][$data->att_date]  = strtotime($data->in_time);

$outs_datetime[$data->emp_id][$data->att_date] = strtotime($data->out_time);

//LATE EARLY CALCULATION

if($ins_datetime[$data->emp_id][$data->att_date]>$sch_ins_datetime[$data->emp_id][$data->att_date])

//$late_min = round(abs($ins_datetime[$data->emp_id][$data->att_date] - $sch_ins_datetime[$data->emp_id][$data->att_date]) / 60,2)+2;

$late_min = (int)(($ins_datetime[$data->emp_id][$data->att_date] - $sch_ins_datetime[$data->emp_id][$data->att_date]) / 60);

else $late_min = 0 ;

if($late_min>0) $final_late_status = 1;

else $final_late_status = 0;

if(($sch_outs_datetime[$data->emp_id][$data->att_date]>$outs_datetime[$data->emp_id][$data->att_date]) &&  ($outs_datetime[$data->emp_id][$data->att_date]>0)   )

//$early_min = round(abs($sch_outs_datetime[$data->emp_id][$data->att_date] - $outs_datetime[$data->emp_id][$data->att_date]) / 60,2);

$early_min = (int)(($sch_outs_datetime[$data->emp_id][$data->att_date] - $outs_datetime[$data->emp_id][$data->att_date]) / 60);

else $early_min = 0 ;

if($early_min>0) $final_early_status = 1;

else $final_early_status = 0;

if($data->leave_type == 'Full'||$data->iom_type == 'Full'){

$final_early_status = 0;

$final_late_status = 0;

}

if($data->iom_type == 'Last Half' || $data->leave_type == 'Last Half'){

$final_early_status = 0;

}




if( ($ins_datetime[$data->emp_id][$data->att_date]>0) || ($outs_datetime[$data->emp_id][$data->att_date]>0) || ($sch_off_day[$data->emp_id][$data->att_date]==1) || ($data->leave_id>0) || ($data->iom_id>0)){
$present=1;
}else{
$present=0;
}





// for late calculation & Overtime

if($ot_applicable[$data->emp_id]=='YES'){	

if(($outs_datetime[$data->emp_id][$data->att_date]>$sch_outs_datetime[$data->emp_id][$data->att_date])  && ($sch_off_day[$data->emp_id][$data->att_date] == 0) ){

$ot_min = (int)(($outs_datetime[$data->emp_id][$data->att_date] - $sch_outs_datetime[$data->emp_id][$data->att_date]) / 60);





$ot_final_hour = (int)($ot_min/60);

if($ot_final_hour){

$ot_final_status=1;

}else{

$ot_final_status=0;

}

}

elseif(($outs_datetime[$data->emp_id][$data->att_date]>0) && ($sch_off_day[$data->emp_id][$data->att_date] ==1) )

$ot_min = (int)(($outs_datetime[$data->emp_id][$data->att_date] - $ins_datetime[$data->emp_id][$data->att_date]) / 60);





$ot_final_hour = (int)($ot_min/60);



if($ot_final_hour){

$ot_final_status=1;

}else {

$ot_final_status=0;

}



}else {

	$ot_min=0;

  	$ot_final_min=0;

  	$ot_final_hour=0;

  	$ot_final_status=0;

}



///

if($emp_id!=$old_emp_id) {$grace_no=0;$grace_pending_min = 60;}

if($late_min>0){

$grace_no++;

//GRACE CALCULATION

//if($emp_id==$old_emp_id) echo $grace_no++; else {$grace_no=1;$grace_pending_min = 60;}

//$grace_no.'$';

//$emp_id;

if($grace_no<4&&$grace_pending_min>0) 

{

$grace = $grace_no;

if($late_min<=$grace_pending_min)  

{$final_late_min = 0;$final_late_status = 0;$grace_pending_min = $grace_pending_min - $late_min;}

else{

if($late_min>$grace_pending_min) {$final_late_min = $late_min - $grace_pending_min;$grace_pending_min = 0;}

//if($final_late_min>20) $final_late_min = 20;

//else $final_late_min = $late_min - 10;

$final_late_status = 1;

}

} else {

$grace = 0;

//if($late_min>20)     {$final_late_min = 20; }

//else 

$final_late_min = $late_min;

if($final_late_min>0)

$final_late_status = 1;

}

$gp_min = $grace_pending_min;

}

else

{

$final_late_min = 0;

$grace = 0;

$gp_min = 0;

}



$update_sql = "update hrm_att_summary 

set 

sch_off_day = '".$sch_off_day[$data->emp_id][$data->att_date]."',sch_id = '".$sch_id[$data->emp_id][$data->att_date]."',sch_in_time = '".$sch_in_time[$data->emp_id][$data->att_date]."',sch_out_time = '".$sch_out_time[$data->emp_id][$data->att_date]."',sch_mid_time = '".$sch_mid_time[$data->emp_id][$data->att_date]."',

late_min='".$late_min."', final_late_min='".$final_late_min."', final_late_status='".$final_late_status."',

early_min='".$early_min."', final_early_min='".$final_early_min."', final_early_status='".$final_early_status."',

ot_min='".$ot_min."', ot_final_min='".$ot_final_min."',ot_final_hour='".$ot_final_hour."', ot_final_status='".$ot_final_status."',

grace_no='".$grace."',grace_pending_min='".$gp_min."',

process_time='".$datetime."',present='".$present."'

where id=".$data->id;

db_query($update_sql);

$old_emp_id = $data->emp_id;

}

echo ' Process Complete! OK.';

}

?>

<style type="text/css">

<!--

.style1 {font-size: 24px}

-->

</style>





<form action=""  method="post" enctype="multipart/form-data">



    <div class="d-flex justify-content-center">



        <div class="n-form1 fo-width pt-0">

            <h4 class="text-center bg-titel bold pt-2 pb-2">Late Calculation Process</h4>

            <div class="container-fluid p-0">

                <div class="row">

                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                        <div class="form-group row  m-0 mb-1 pl-3 pr-3">

                            <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Employee Code :  </label>

                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

                              <input type="text" name="emp_id2" id="emp_id2" value="<?=$_POST['emp_id']?>" />

                            </div>

                        </div>

                    </div>



                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



                        <div class="form-group row m-0 mb-1 pl-3 pr-3">

                            <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company :    </label>

                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

                              <select name="select" id="select">

                                <? foreign_relation('user_group','id','group_name',$PBI_ORG);?>

                              </select>

                            </div>

                        </div>



                    </div>

					

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



                        <div class="form-group row m-0 mb-1 pl-3 pr-3">

                            <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Job Location :    </label>

                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

                              <select name="JOB_LOCATION" id="JOB_LOCATION"  class="form-control" required="required"  >

                                <option>

                                  <?=$JOB_LOCATION?>

                                </option>

                                <option value="1">Head Office</option>

                                <option value="2">Factory</option>

                              </select>

                            </div>

                        </div>

						

						

						<div class="form-group row m-0 mb-1 pl-3 pr-3">

                            <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Start Date :    </label>

                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

                              <input type="date" name="s_date" id="s_date" value="<?=$_POST['s_date']?>" required  />

                            </div>

                        </div>

						

						



                    </div>



                    





                    







                            <?php /*?><div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                                <div class="form-group row m-0 mb-1 pl-3 pr-3">

                                    <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Month :    </label>

                                    <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

                                        <select name="mon"  id="mon" required>

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



                                    </div>

                                </div>

                            </div><?php */?>



                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                                <div class="form-group row m-0 mb-1 pl-3 pr-3">

                                    <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Year :    </label>

                                    <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">



                                        <select name="year" id="year" required>

											<option <?=($year=='2022')?'selected':''?>>2022</option>

											<option <?=($year=='2023')?'selected':''?>>2023</option>

											<option <?=($year=='2021')?'selected':''?>>2021</option>

										</select>



                                    </div>

                                </div>

								<div class="form-group row m-0 mb-1 pl-3 pr-3">

                            <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> End Date :    </label>

                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

                              <input type="date" name="e_date" id="e_date" value="<?=$_POST['e_date']?>" required  />

                            </div>

                        </div>

                            </div>







                </div>





                <div class="n-form-btn-class">

                    <input name="upload" class="btn1 btn1-bg-submit" type="submit" id="upload" value="Sync All Data" />

                </div>



            </div>



        </div>



    </div>





    





</form>



<?php /*?><div class="oe_view_manager oe_view_manager_current">

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

<td>Job Location</td>

<td><select name="JOB_LOCATION" id="JOB_LOCATION"  class="form-control" required  >

<option><?=$JOB_LOCATION?></option>

<option value="1">Head Office</option>

<option value="2">Factory</option>

</select></td>

</tr>

<tr>

<td width="20%">Month :</td>

<td colspan="3"><span class="oe_form_group_cell">

<select name="mon" style="width:160px;" id="mon" required>

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

</tr><?php */?>

<?php /*?><tr><td>End Date</td>

<td colspan="3"><input type="date" name="f_date" id="f_date" value="<?=$_POST['f_date']?>" /></td></tr>

<tr><td>End Date</td>

<td colspan="3"><input type="date" name="	t_date" id="t_date" value="<?=$_POST['t_date']?>" /></td></tr><?php */?>

<tr>

<?php /*?><td>Year :</td>

<td colspan="3"><select name="year" style="width:160px;" id="year" required>

<option <?=($year=='2022')?'selected':''?>>2022</option>

<option <?=($year=='2023')?'selected':''?>>2023</option>

<option <?=($year=='2021')?'selected':''?>>2021</option>

</select></td>

</tr>

<tr>

<td colspan="4">

<div align="center">

<input name="upload" class="btn1 btn1-bg-submit" type="submit" id="upload" value="Sync All Data" />

</div></td>

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

</form>   </div><?php */?>

<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>