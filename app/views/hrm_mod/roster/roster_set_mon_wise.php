<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";



$head='<link href="../../../../public/assets/css/report_selection.css" type="text/css" rel="stylesheet"/>';



do_calander('#roster_date');

do_calander('#s_date');
do_calander('#e_date');

$title='Roster Day Set';			// Page Name and Page Title



/*if(isset($_POST['save']))

{		

		if($_POST['designation']>0)

		$con .=' and a.PBI_DESIGNATION='.$_POST['designation'];

		if($_POST['department']>0)

		$con .=' and a.PBI_DEPARTMENT='.$_POST['department'];

		if($_POST['job_location']>0)

		$con .=' and a.JOB_LOCATION='.$_POST['job_location'];

		if($_POST['group_for']>0)

		$con .=' and a.PBI_ORG='.$_POST['group_for'];

		

		$sql = "select a.PBI_NAME,a.PBI_ID,a.PBI_DESIGNATION,a.PBI_DEPARTMENT from 

		personnel_basic_info a

		where  1 ".$con."  and a.PBI_JOB_STATUS='In Service' order by a.PBI_ID ";

		$query = mysql_query($sql);

		$query = mysql_query($sql);

		while($info=mysql_fetch_object($query))

		{

		$roster_date = $_POST['roster_date'];

		$point_1 = $_POST['point_1_'.$info->PBI_ID];

		$shedule_1 = $_POST['shedule_1_'.$info->PBI_ID];

		$point_2 = $_POST['point_2_'.$info->PBI_ID];

		$shedule_2 = $_POST['shedule_2_'.$info->PBI_ID];

		$entry_by = $_SESSION['user']['id'];

		

			if($point_1>0){

			$sSql = 'select id, PBI_ID from hrm_roster_allocation where PBI_ID="'.$info->PBI_ID.'" and roster_date="'.$roster_date.'"';

			$sQuery = mysql_query($sSql);

			$sData = mysql_fetch_object($sQuery);

			if($sData->id>0){

			$edit_by = $_SESSION['user']['id'];

			$edit_at = date('Y-m-d h:i:s');

			$job_location = $_POST['job_location'];

			$group_for = $_POST['group_for'];

			 $upSql = 'UPDATE hrm_roster_allocation SET point_1="'.$point_1.'", shedule_1="'.$shedule_1.'", point_2="'.$point_2.'", shedule_2="'.$shedule_2.'", edit_at="'.$edit_at.'", edit_by = '.$edit_by.', job_location="'.$job_location.'", group_for = "'.$group_for.'"  WHERE id='.$sData->id;

			mysql_query($upSql);

			

			}else{

			

			$insSql = 'INSERT INTO hrm_roster_allocation(PBI_ID, roster_date, point_1, shedule_1, point_2, shedule_2, job_location,group_for, entry_by) VALUES ("'.$info->PBI_ID.'", "'.$roster_date.'", "'.$point_1.'", "'.$shedule_1.'", "'.$point_2.'", "'.$shedule_2.'", "'.$_POST['job_location'].'", "'.$_POST['group_for'].'", "'.$entry_by.'")';

			mysql_query($insSql);

				}

			}

		}

}*/

?>
<?  


if(isset($_POST['search']))
{

        if($_POST['designation']>0)

		$con .=' and a.PBI_DESIGNATION='.$_POST['designation'];

		if($_POST['department']>0)

		$con .=' and a.PBI_DEPARTMENT='.$_POST['department'];

		if($_POST['job_location']>0)

		$con .=' and a.JOB_LOCATION='.$_POST['job_location'];

		if($_POST['group_for']>0)

		$con .=' and a.PBI_ORG='.$_POST['group_for'];
		
		
		
			$edit_by = $_SESSION['user']['id'];

			$edit_at = date('Y-m-d h:i:s');

			$job_location = $_POST['job_location'];

			$group_for = $_POST['group_for'];
			
			$entry_by = $_SESSION['user']['id'];

		

		$sql = "select a.PBI_NAME,a.PBI_ID,a.PBI_DESIGNATION,a.PBI_DEPARTMENT from 

		personnel_basic_info a

		where  1 ".$con."  and a.PBI_JOB_STATUS='In Service' order by a.PBI_ID ";

		$query = db_query($sql);

		$query = db_query($sql);

		while($info=mysqli_fetch_object($query))

		{
		

$emp_id=$info->PBI_ID; // $_POST['PBI_ID'];
$roster_point=$_POST['point_1'];
$roster_shedule=$_POST['shedule_1'];

$s_date= strtotime($_REQUEST['s_date']);
$e_date= strtotime($_REQUEST['e_date']);

////////////////////////
for($i=$s_date; $i<=$e_date; $i+=86400){
$att_date=date('Y-m-d',$i);


$sSql = 'select id, PBI_ID from hrm_roster_allocation where PBI_ID="'.$info->PBI_ID.'" and roster_date="'.$att_date.'"';
$sQuery = db_query($sSql);
$sData = mysqli_fetch_object($sQuery);
if($sData->id>0){

$upSql = 'UPDATE hrm_roster_allocation SET point_1="'.$roster_point.'", shedule_1="'.$roster_shedule.'", edit_at="'.$edit_at.'", edit_by = '.$edit_by.', 
job_location="'.$job_location.'", group_for = "'.$group_for.'"  WHERE id='.$sData->id;
db_query($upSql);

}else{
$att_sql = "INSERT INTO hrm_roster_allocation (PBI_ID,roster_date,point_1,shedule_1,entry_by) 
VALUES ('$emp_id','$att_date','$roster_point','$roster_shedule','$entry_by')";
$att_query=db_query($att_sql);

}			
			
}
//////////////////////



}

}


?>
<style type="text/css">



</style>
<!--Three input table-->
<div class="form-container_large">
  <h4 class="text-center bg-titel bold pt-2 pb-2"> Select Option </h4>
  <form action="?"  method="post">
    <div class="container-fluid bg-form-titel">
      <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
          <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date</label>
            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
              <input name="roster_date"  class="form-control" type="text" id="roster_date" value="<?=$_POST['roster_date']?>" autocomplete="off" required="required"/>
            </div>
          </div>
        </div>
        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
          <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company</label>
            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
              <select name="group_for" id="group_for"  class="form-control"   onchange="getData2('ajax_location.php', 'loc', this.value,  this.value)" required="required">
                <? foreign_relation('user_group', 'id', 'group_name',$_POST['group_for'],'1 and id="'.$_SESSION['user']['group'].'"')?>
              </select>
            </div>
          </div>
        </div>
		
        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
          <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Job Location</label>
            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
              <select name="job_location"  class="form-control" id="job_location" >
			 <option></option>
                <? foreign_relation('office_location', 'ID', 'LOCATION_NAME',$_POST['job_location'],'1')?>
              </select>
              <input type='hidden' name='area' id='area' value='1' />
            </div>
          </div>
        </div>
		
		
		<div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
          <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Duty Schedule</label>
            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
             <select name="shedule" id="shedule">
                <option></option>
                <? foreign_relation('hrm_schedule_info','id','schedule_name',$shedule,'1');?>
              </select>
            </div>
          </div>
        </div>
		
		
        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
          <input name="create" id="create" value="SHOW EMPLOYEE" type="submit" class="btn1 btn1-submit-input">
        </div>
		
      </div>
    </div>
  
    <div class="container-fluid bg-form-titel">
      <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
          <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Start Date</label>
            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
              <input type="text" name="s_date" autocomplete="off" id="s_date" style="width:50%;" class="form-control" />
            </div>
          </div>
        </div>
        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
          <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">End Date</label>
            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
              <input type="text" name="e_date" autocomplete="off" id="e_date" style="width:50%;" class="form-control" />
            </div>
          </div>
        </div>
		
		
	   <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
          <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Duty Section </label>
            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
            <select name="point_1" id="point_1">
                <option></option>
                <? foreign_relation('hrm_roster_point','id','point_short_name',$point_1,'1');?>
              </select>
            </div>
          </div>
        </div>
		
		
		
        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
          <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Duty Schedule</label>
            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
              <select name="shedule_1" id="shedule_1">
                <option></option>
                <? foreign_relation('hrm_schedule_info','id','schedule_name',$shedule_1,'1');?>
              </select>
            </div>
          </div>
        </div>
		
		
		
        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
          <input name="search" id="search" value="SAVE" type="submit" class="btn1 btn1-submit-input">
        </div>
      </div>
    </div>
    <!-- END NEW SECTION-->
    <? if($_REQUEST['area']>0){?>
    <div class="container-fluid pt-5 p-0 ">
      <table class="table1  table-striped table-bordered table-hover table-sm">
        <thead class="thead1">
          <tr class="bgc-info">
            <th>Code</th>
            <th>Full Name</th>
            <th>Designation</th>
            <th>Department</th>
			<th>Present Schedule Date</th>
            <th>Duty Section </th>
            <th>Duty Schedule </th>
          </tr>
        </thead>
        <tbody class="tbody1">
          <?

							if($_POST['designation']>0)

							$con .=' and a.PBI_DESIGNATION='.$_POST['designation'];

							if($_POST['department']>0)

							$con .=' and a.PBI_DEPARTMENT='.$_POST['department'];

							if($_POST['job_location']>0)

							$con .=' and a.JOB_LOCATION='.$_POST['job_location'];

							/*if($_POST['shedule']>0)

							$con .=' and b.shedule='.$_POST['shedule'];*/

							

							 $sql = "select a.PBI_NAME,a.PBI_ID,a.PBI_DESIGNATION,a.PBI_DEPARTMENT from 

							personnel_basic_info a

							where  1 ".$con."  and a.PBI_JOB_STATUS='In Service' order by a.PBI_ID ";

							$query = db_query($sql);

							while($info=mysqli_fetch_object($query))

							{

							$rosterAllocation = find_all_field('hrm_roster_allocation','','PBI_ID="'.$info->PBI_ID.'" and roster_date="'.$_POST['roster_date'].'"');

							$point_1 = $rosterAllocation->point_1;

							$shedule_1 = $rosterAllocation->shedule_1;

							?>
          <tr>
            <td><?=$info->PBI_ID?>
              <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$info->PBI_ID?>" /></td>
            <td><?=$info->PBI_NAME?></td>
            <td><?=$info->PBI_DESIGNATION?></td>
            <td><?=$info->PBI_DEPARTMENT?></td>
			<td><?=$rosterAllocation->roster_date?></td>
			
            <td><select name="point_1_<?=$info->PBI_ID?>" id="point_1_<?=$info->PBI_ID?>">
                <option></option>
                <? foreign_relation('hrm_roster_point','id','point_short_name',$point_1,'1');?>
              </select>
            </td>
            <td><select name="shedule_1_<?=$info->PBI_ID?>" id="shedule_1_<?=$info->PBI_ID?>">
                <option></option>
                <? foreign_relation('hrm_schedule_info','id','schedule_name',$shedule_1,'1');?>
              </select>
            </td>
          </tr>
          <? 

									  }

									  ?>
        </tbody>
      </table>
      <!--<div class="n-form-btn-class">
        <input name="save" type="submit" id="save" value="SET NEW SCHEDULE" class="btn1 btn1-submit-input" />
      </div>-->
    </div>
    <? } ?>
  </form>
</div>
<?php /*?>

<form action="?"  method="post">

   <div class="oe_view_manager oe_view_manager_current">

    <div class="oe_view_manager_body">

      <div  class="oe_view_manager_view_list"></div>

      <div class="oe_view_manager_view_form">

        <div style="opacity: 1; text-align: right;" class="oe_formview oe_view oe_form_editable">

          <div class="oe_form_buttons"></div>

          <div class="oe_form_sidebar"></div>

          <div class="oe_form_pager"></div>

          <div class="oe_form_container">

            <div class="oe_form">

              <div class="">

                <div class="oe_form_sheetbg">

                  <div class="oe_form_sheet oe_form_sheet_width">

                    <div  class="oe_view_manager_view_list">

                      <div  class="oe_list oe_view">

                        <table width="100%" border="0" class="table table-bordered table-sm">

                          <thead>

                            

                            <tr>

                              <th colspan="4" class="p-3 mb-2 bg-info text-white"><div align="center"><span>Select Options</span></div></th>

                            </tr>

                          </thead>

                          <tfoot>

                          </tfoot>

                          <tbody>

                            

                            

                            <tr >

                              <td width="30%" align="right">&nbsp;</td>

                              <td width="11%" align="right"><div align="right"><strong>Date :</strong></div></td>

                              <td width="32%" align="right"><div align="left"><span class="oe_form_group_cell">

                                <input name="roster_date"  class="form-control" type="text" id="roster_date" value="<?=$_POST['roster_date']?>" autocomplete="off" required="required"/>

                              </span></div></td>

                              <td  align="right"><div align="left"><span class="oe_form_group_cell"> </span></div></td>

                            </tr>

                            

                            <tr>

                              <td align="center" style="text-align: right">&nbsp;</td>

                              <td align="center" style="text-align: right"><div align="right"><strong>Company : </strong></div></td>

                              <td><select name="group_for" id="group_for"  class="form-control"   onchange="getData2('ajax_location.php', 'loc', this.value,  this.value)" required="required">

                                <? foreign_relation('user_group', 'id', 'group_name',$_POST['group_for'],'1 and id="'.$_SESSION['user']['group'].'"')?>

                              </select></td>

                              <td>&nbsp;</td>

                            </tr>

                            

                            <tr>

                              <td align="right">&nbsp;</td>

                              <td align="right"><div align="right"><strong>Job Location : </strong></div></td>

                              <td><select name="job_location"  class="form-control" id="job_location" >

                                <? foreign_relation('office_location', 'ID', 'LOCATION_NAME',$_POST['job_location'],'1')?>

                              </select>

                                <input type='hidden' name='area' id='area' value='1' /></td>

                              <td>&nbsp;</td>

                            </tr>

                            

                             <br />

                             <tr>

                            <td colspan="4" align="center" style="text-align: right"><div align="center">

					

                              <input name="create" id="create" value="SHOW EMPLOYEE" type="submit" class="btn1 btn1-submit-input">

                            </div></td>

                            </tr>

                          </tbody>

                        </table>

               

                        <? if($_REQUEST['area']>0){?>

                        <div style="text-align:center">

                          

                          <div class="oe_form_sheetbg">

                            <div class="oe_form_sheet oe_form_sheet_width">

                              <div class="oe_view_manager_view_list">

                                <div class="oe_list oe_view">

                                  <table width="100%" class="table table-striped table-sm">

                                    <thead>

                                      <tr class="bg-warning">

                                        <th>Code</th>

                                        <th>Full Name</th>

                                        <th>Desg</th>

                                        <th>Dept</th>

                                        <th>Duty Section </th>

                                        <th>Duty Schedule </th>

                                      </tr>

                                    </thead>

                                    <tbody>

                                      <?

		if($_POST['designation']>0)

		$con .=' and a.PBI_DESIGNATION='.$_POST['designation'];

		if($_POST['department']>0)

		$con .=' and a.PBI_DEPARTMENT='.$_POST['department'];

		if($_POST['job_location']>0)

		$con .=' and a.JOB_LOCATION='.$_POST['job_location'];

		if($_POST['group_for']>0)

		$con .=' and a.PBI_ORG='.$_POST['group_for'];

		

		$sql = "select a.PBI_NAME,a.PBI_ID,a.PBI_DESIGNATION,a.PBI_DEPARTMENT from 

		personnel_basic_info a

		where  1 ".$con."  and a.PBI_JOB_STATUS='In Service' order by a.PBI_ID ";

		$query = mysql_query($sql);

		while($info=mysql_fetch_object($query))

		{

		$rosterAllocation = find_all_field('hrm_roster_allocation','','PBI_ID="'.$info->PBI_ID.'" and roster_date="'.$_POST['roster_date'].'"');

		$point_1 = $rosterAllocation->point_1;

		$shedule_1 = $rosterAllocation->shedule_1;

		?>

                                      <tr style="font-size:10px; padding:3px; ">

                                        <td><?=$info->PBI_ID?>

                                          <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$info->PBI_ID?>" /></td>

                                        <td><?=$info->PBI_NAME?></td>

                                        <td><?=$info->PBI_DESIGNATION?></td>

                                        <td><?=$info->PBI_DEPARTMENT?></td>

                                        <td><span class="oe_form_group_cell">

                                          <select name="point_1_<?=$info->PBI_ID?>" id="point_1_<?=$info->PBI_ID?>">

<? foreign_relation('hrm_roster_point','id','point_short_name',$point_1,'1');?>

                                          </select>

                                        </span></td>

                                        <td><span class="oe_form_group_cell">

                                          <select name="shedule_1_<?=$info->PBI_ID?>" id="shedule_1_<?=$info->PBI_ID?>">

<? foreign_relation('hrm_schedule_info','id','schedule_name',$shedule_1,'1');?>

                                          </select>

                                          </span></td>

                                      </tr>

                                      <?

		}

		?>

                                    </tbody>

                                    <tfoot>

                                      <tr>

                                        <td></td>

                                        <td></td>

                                        <td></td>

                                        <td></td>

                                        <td colspan="2"></td>

                                      </tr>

                                    </tfoot>

                                  </table>

                                </div>

                              </div>

                            </div>

                          </div>

						  <br />

						  <input name="save" type="submit" id="save" value="SET NEW SCHEDULE" class="btn btn-warning" />

                          

                        </div>

                        <? }?>

  			    

					        </div>

                        </div>

                        <? ?>

                      </div>

                    </div>

                  </div>

                </div>

                

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

</form><?php */?>
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>
