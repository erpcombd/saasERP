<?php

session_start();
//

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.core/init.php);
require_once SERVER_CORE."routing/layout.top.php";

$title="Machine Data Sync (Roster)";

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
    $sch_break[$data->id]=$data->break_time;
	$sch_type[$data->id] =$data->sch_type;
}


// Roster Schedule Fetch All
$sql = "select * from hrm_roster_allocation where roster_date  BETWEEN '".$start_date."' AND '".$end_date."' ";
$query  =db_query($sql);
while($data=mysqli_fetch_object($query)){
    $roster_assign[$data->PBI_ID][$data->roster_date] = $data->shedule_1;
}

$datetime = date('Y-m-d H:i:s');


// Holy Day sync for ALL
$holysql = "select holy_day from salary_holy_day where holy_day between '".$start_date."' AND '".$end_date."' and job_loc_id in (".$job_loc.",3)";// Make Status
$holy_query = db_query($holysql);
while($holy_data = mysqli_fetch_object($holy_query)){
$holy_day[$holy_data->holy_day]=1;
}

// Grace ALL
$grace_sql ="select * from grace_type";
$grace_query = db_query($grace_sql);

while($grace_data=mysqli_fetch_object($grace_query)){
	
	$grace_time[$grace_data->ID]=$grace_data->grace_time;
	$grace_days[$grace_data->ID]=$grace_data->total_grace_days;
	$total_grace_time[$grace_data->ID]=$grace_data->total_grace_time;
}


$emp_id = find_a_field('personnel_basic_info','PBI_ID','PBI_CODE="'.$_POST['emp_id'].'"');
if(isset($emp_id))
{
$emp_id_con=" and d.EMP_CODE IN (".$emp_id.")";
$pbi_id_con=" and p.PBI_ID IN (".$emp_id.")";
}

//over_time applicabel

$sql_ot = "select * from salary_info where 1"; // Make Joining
$query_ot  =db_query($sql_ot);

while($data_ot=mysqli_fetch_object($query_ot)){
$ot_applicable[$data_ot->PBI_ID] = $data_ot->overtime_applicable;
$ot_weekend_applicable[$data_ot->PBI_ID] = $data_ot->ot_weekend_applicable;
$ot_holiday_applicable[$data_ot->PBI_ID] = $data_ot->ot_holiday_applicable;
$ot_hour_adjust[$data_ot->PBI_ID] =$data_ot->overtime_hour_adjust;
}


if($_POST['JOB_LOCATION']>0) $job_location_con = " and p.JOB_LOC_ID='".$_POST['JOB_LOCATION']."'";
if($_POST['department']>0) $department_con = " and p.DEPT_ID='".$_POST['department']."'";
if($_POST['PBI_ORG']>0) $ORG_con = " and p.PBI_ORG='".$_POST['PBI_ORG']."'";


	

$sql = " SELECT d.EMP_CODE,a.roster_date,min(d.xtime) in_time,max(d.xtime) out_time,a.shedule_1,p.schedule_type,p.PBI_ID
FROM hrm_attdump d, hrm_roster_allocation a , hrm_schedule_info s,personnel_basic_info p
WHERE  a.PBI_ID=p.PBI_ID and  d.EMP_CODE=a.PBI_ID and  d.xdate in (d.xdate,DATE_ADD(d.xdate, INTERVAL 1 DAY)) and  a.roster_date between '".$start_date."' and '".$end_date."' and shedule_1=s.id and  
d.xtime between   DATE_ADD(concat(a.roster_date,' ',s.office_start_time), INTERVAL ".min_in." HOUR) and DATE_ADD(concat(a.roster_date,' ',s.office_end_time), INTERVAL ".max_out." HOUR) ".$job_location_con.$emp_id_con.$department_con."
group by a.PBI_ID,a.roster_date";
	
$query = db_query($sql);
while($data = mysqli_fetch_object($query))

	{
	
	$sl++;

     $value[$data->PBI_ID][$data->roster_date]['sch_in_time']  = $office_in_times  = $sch_start[$data->shedule_1];
	 $value[$data->PBI_ID][$data->roster_date]['sch_mid_time']  = $office_mid_times  = $sch_mid[$data->shedule_1];
	 $value[$data->PBI_ID][$data->roster_date]['sch_out_time'] = $office_out_times = $sch_end[$data->shedule_1];
	

	$value[$data->PBI_ID][$data->roster_date]['emp_id'] = $data->EMP_CODE;
	$value[$data->PBI_ID][$data->roster_date]['att_date'] = $data->roster_date;
	$value[$data->PBI_ID][$data->roster_date]['sch_id'] = $data->shedule_1;
	echo $value[$data->PBI_ID][$data->roster_date]['in_time'] = $data->in_time;
	if($data->in_time!=$data->out_time)
    $value[$data->PBI_ID][$data->roster_date]['out_time'] = $data->out_time;

	}


$ssql = "select id,emp_id,att_date from hrm_att_summary where   att_date BETWEEN '".$start_date."' AND '".$end_date."'";
$squery = db_query($ssql);
while($sdata=mysqli_fetch_object($squery))
{
    $founds[$sdata->emp_id][$sdata->att_date] = $sdata->id;
}

$start = strtotime( $_POST['s_date'] );
$end = strtotime( $_POST['e_date'] );


$sqll = "SELECT p.PBI_ID,p.define_schedule,p.define_offday,p.punch_type,p.grace_type,p.define_offday2,p.PBI_DOJ
FROM personnel_basic_info p WHERE  1 ".$job_location_con.$emp_id_con.$department_con." order by p.PBI_ID";
$queryy = db_query($sqll);

while($datas=mysqli_fetch_object($queryy)){

for ( $i = $start; $i <= $end; $i = $i + 86400 ) {
  		$thisDate = date( 'Y-m-d', $i );
		
		 $found = 0;
		 $found = $founds[$datas->PBI_ID][$thisDate];
		
		if($found==0)

			{				
$sql="INSERT INTO hrm_att_summary 
(emp_id,att_date,sch_id,in_time,out_time, dayname,sch_in_time,sch_mid_time,sch_out_time)

VALUES 

('".$datas->PBI_ID."','".$thisDate."', '".$value[$datas->PBI_ID][$thisDate]['sch_id']."','".$value[$datas->PBI_ID][$thisDate]['in_time']."','".$value[$datas->PBI_ID][$thisDate]['out_time']."',
dayname('".$thisDate."'), '".$value[$datas->PBI_ID][$thisDate]['sch_in_time']."','".$value[$datas->PBI_ID][$thisDate]['sch_mid_time']."','".$value[$datas->PBI_ID][$thisDate]['sch_out_time']."')";
$query=db_query($sql);

			}
			
		else{
				
				
$sql='update hrm_att_summary set sch_id="'.$value[$datas->PBI_ID][$thisDate]['sch_id'].'",
in_time="'.$value[$datas->PBI_ID][$thisDate]['in_time'].'", out_time="'.$value[$datas->PBI_ID][$thisDate]['out_time'].'", sch_in_time="'.$value[$datas->PBI_ID][$thisDate]['sch_in_time'].'",sch_mid_time="'.$value[$datas->PBI_ID][$thisDate]['sch_mid_time'].'",sch_out_time="'.$value[$datas->PBI_ID][$thisDate]['sch_out_time'].'" where  emp_id="'.$datas->PBI_ID.'" and att_date="'.$thisDate.'" ';
			$query=db_query($sql);
		
		}
		
		
		
		
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







<form action=""  method="post" enctype="multipart/form-data">

    <div class="d-flex justify-content-center">

        <div class="n-form1 fo-width pt-0">
            <h4 class="text-center bg-titel bold pt-2 pb-2">      Collect Machine Data Factory  </h4>
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group row  m-0 mb-1 pl-3 pr-3">
                            <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Employee Code :  </label>
                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                                <input type="text" name="emp_id" id="emp_id" value="<?=$_POST['emp_id']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                        <div class="form-group row m-0 mb-1 pl-3 pr-3">
                            <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company :    </label>
                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                                <select name="PBI_ORG"  id="PBI_ORG">

							  <? foreign_relation('user_group','id','group_name',$_POST['PBI_ORG']);?>
						
							</select>
                            </div>
                        </div>

                    </div>


                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                        <div class="form-group row m-0 mb-1 pl-3 pr-3">
                            <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Location :    </label>
                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                                <select name="JOB_LOCATION"  id="JOB_LOCATION">
								
							
								  <? foreign_relation('job_location_type','id','job_location_name',$JOB_LOCATION,'id=2');?>
							
								</select>
                            </div>
                        </div>

                    </div>


                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                        <div class="form-group row m-0 mb-1 pl-3 pr-3">
                            <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Department :    </label>
                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                                <select name="department"  class="form-control" id="department">

							  <option></option>
						
								<? foreign_relation('department','DEPT_ID','DEPT_DESC',$department,' 1 order by DEPT_DESC');?>
							  </select>
                            </div>
                        </div>

                    </div>



                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                                    <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Start Date : </label>
                                    <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                                      <input type="date" name="s_date" id="s_date" value="<?=$_POST['s_date']?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                                    <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">End Date :    </label>
                                    <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

                                        <input type="date" name="e_date" id="e_date" value="<?=$_POST['e_date']?>" autocomplete="off"/>

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


    <div class="container-fluid p-0 pt-5">

        <div class="oe_list oe_view">



            <? if($emp_id>0){


                $ab="SELECT a.PBI_NAME as name, b.DOMAIN_DESC as company_name, c.DEPT_DESC as department, d.DESG_DESC as designation FROM personnel_basic_info a, domai b, department c, designation d WHERE a.PBI_DOMAIN=b.DOMAIN_DESC and a.DEPT_ID=c.DEPT_ID and a.DESG_ID=d.DESG_ID and a.PBI_ID=$emp_id";

                $data=db_query($ab);

                $emp=mysqli_fetch_object($data);

                ?>



                <span id="id_view">
                                <h4 class="text-center bgc-success bold p-3">

                                    ACCESS IN AT:
                                    <?=date('d/m/Y H:i:s A',$access_stamp)?>
                                </h4>

                                <div align="center">
                                    <img src="../../pic/staff/<?php echo $emp_id;?>.jpeg" width="190" height="191" />
                                </div>

                                <div align="center" class="cell_fonts_grant_total p-3">
                                    <h4 class="bold">Employee Code  : <?php echo $emp_id;?></h4>

                                </div>

                                <div align="center" class="cell_fonts_grant_total style6">
                                    <h4 class="bold"><?php echo $emp->name." (".$emp->designation.")";?></h4

                                ></div>

                                <div align="center" class="cell_fonts_grant_total style6">
                                    <h4 class="bold"><?php echo $emp->department.", ".$emp->company_name;?> </h4

                                ></div>


                </span>

            <? }?>



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

    <select name="JOB_LOCATION" style="width:160px;" id="JOB_LOCATION">
	 <option></option>

      <? foreign_relation('job_location_type','id','job_location_name',$JOB_LOCATION,'id=2');?>

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

</form></div><?php */?>


<?

$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";

?>




