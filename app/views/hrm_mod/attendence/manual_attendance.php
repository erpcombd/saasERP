<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title="Manual Attendance";
do_calander('#m_date');

$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');

$table='hrm_inout';
$unique='id';

if(isset($_POST['search']))

{		

$emp_id=$_POST['PBI_ID'];
$access_date=$a_date=$_POST['m_date'];
$c_date=explode('-',$a_date);
$access_time=$a_date.' '.$_POST['m_hr'].':'.$_POST['m_min'].':'.'00';
$access_stamp=mktime($_POST['m_hr'],$_POST['m_min'],0,$c_date[1],$c_date[2],$c_date[0]);
$sch = find_all_field_sql('select p.off_day,s.office_start_time,s.office_end_time from personnel_basic_info p, hrm_schedule_info s where p.PBI_ID="'.$emp_id.'" and p.office_time=s.id');


	$date = date('Ymd',$access_stamp);
	if(date('N',$access_stamp)==$sch->off_day) $info['status'][$date]=0;
	else{
        if($sch->office_start_time == '')	$info['status'][$date]=1;
        else{$info['late'][$date] = (int)(($access_stamp - strtotime($access_date.' '.$sch->office_start_time))/60);

	if($info['late'][$date]>0) 	$info['status'][$date]=2;
	else $info['status'][$date]=1;

	}}











$sql="INSERT INTO `hrm_inout` (



`employee_id` ,



card_no,



`access_date` ,



`access_time` ,



`access_stamp` ,



`user` ,



`status`,off_day,start_time,end_time )



VALUES ('$emp_id', '$data[3]', '$access_date','$access_time', '$access_stamp', '$user1', '".$info['status'][$date]."','$sch->off_day', '$sch->office_start_time', '$sch->office_end_time')";



$query=db_query($sql);





$att_sql = "INSERT INTO hrm_attdump ( ztime, bizid, xenrollid, xdate, xtime,EMP_CODE) VALUES ('$access_time', '$emp_id', '$emp_id', '$access_date', '$access_time','$emp_id')"	;

$att_query=db_query($att_sql);	



		



}

?>











<style type="text/css">



<!--



.style1 {font-size: 24px}



.style2 {



	color: #FFFFFF;



	font-size: 24px;



	font-weight: bold;



}

-->
</style>




<form action=""  method="post">

    <div class="d-flex justify-content-center">

        <div class="n-form1 fo-width pt-0">
            <h2 class="text-center bg-titel bold pt-2 pb-2">      Manual Attendance     </h2>
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="container">
					<div class="row">

							<div class="form-group col-sm-6 row m-0 mb-1 pl-3 pr-3">
								<label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text" style="text-align:left">Employee Code:  </label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<input name="PBI_ID"  type="text" id="PBI_ID" size="10" onblur="" tabindex="1" />
								</div>
							</div>
							
							
                        <div class="form-group col-sm-6 row m-0 mb-1 pl-3 pr-3">
                            <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Access Date-Time:    </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input type="text" name="m_date" autocomplete="off" id="m_date" />
                            </div>
                        </div>
						
							
							
						</div>

                    </div>

                    <div class="container">


                    </div>


                    <div class="container">
                        <div class="row">
						    <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2"></div>
                            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                                    <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text" >Hours:    </label>
                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 p-0 pr-2">
                                        <select name="m_hr" id="m_hr" >

                                            <? for($i=0;$i<25;$i++){
                                                ?>

                                                <option>

                                                    <?=sprintf('%02d', $i);?>

                                                </option>

                                            <? }?>

                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                                    <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Minutes: </label>
                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 p-0 pr-2">


                                        <select name="m_min"  id="m_min">

                                            <? for($i=0;$i<60;$i++){

                                                ?>


                                                <option>

                                                    <?=sprintf('%02d', $i);?>

                                                </option>

                                            <? }?>

                                        </select>

                                    </div>
                                </div>
                            </div>
							 <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2"></div>
                        </div>


                    </div>


                </div>


                <div class="n-form-btn-class">
                    <input name="search" type="submit" class="btn1 btn1-bg-submit" id="search" value="Manual Attendence" class="form-control" />
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
                                    <img src="../../../assets/support/upload_view.php?name=<? echo $row->PBI_PICTURE_ATT_PATH?>>
                                
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







<br>
<br>
<br>
<br>
<br>
<br>
    <div class="oe_view_manager oe_view_manager_current">
        <form action=""  method="post">
        <div class="oe_view_manager_body">
                <div  class="oe_view_manager_view_list"></div>
                <div class="oe_view_manager_view_form">
                    <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
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
                <td height="40" colspan="4" bgcolor="#00FF00"><div align="center" class="style1">Manual Attendance </div></td>
                </tr>
              <tr>
                <td><div align="right">Employee Code: </div></td>
                <td colspan="3"><input name="PBI_ID"  type="text" id="PBI_ID" size="10" onblur="" tabindex="1" style="width:400px;" class="form-control" /></td>
              </tr>
              <tr>
                <td width="20%"><div align="right">Access Date-Time:</div></td>
                <td><input type="text" name="m_date" autocomplete="off" id="m_date" style="width:50%;" class="form-control" /></td>
                <td>
                    <select name="m_hr" id="m_hr" >
                    <? for($i=7;$i<20;$i++){
	  ?>
                  <option>
                    <?=sprintf('%02d', $i);?>
                    </option>
                    <? }?>
                </select>
                Hr</td>
                <td>
                    <select name="m_min"  id="m_min">
                    <? for($i=0;$i<60;$i++){
	  ?>
                  <option>
                    <?=sprintf('%02d', $i);?>
                    </option>
                    <? }?>
                </select>
                Min</td>
              </tr>
              <tr>
                <td colspan="4" align="center">
                    <input name="search" type="submit" class="btn1 btn1-bg-submit" id="search" value="Manual Attendence" class="form-control" />
                </td>
              </tr>
            </table>
            <br /><div style="text-align:center">
              <div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">
          <div class="oe_view_manager_view_list">
              <div class="oe_list oe_view">
<? if($emp_id>0){
 $ab="SELECT a.PBI_NAME as name, b.DOMAIN_DESC as company_name, c.DEPT_DESC as department, d.DESG_DESC as designation FROM personnel_basic_info a, domai b, department c, designation d WHERE a.PBI_DOMAIN=b.DOMAIN_DESC and a.DEPT_ID=c.DEPT_ID and a.DESG_ID=d.DESG_ID and a.PBI_ID=$emp_id";
$data=db_query($ab);
$emp=mysqli_fetch_object($data);
?>
<span id="id_view">
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td height="50" bgcolor="#006600">
    <div align="center" class="style2">ACCESS IN AT:
  <?=date('d/m/Y H:i:s A',$access_stamp)?>
</div>
</td>
</tr>
<tr>
<td><div align="center"><img src="../../pic/staff/<?php echo $emp_id;?>.jpeg" width="190" height="191" /></div></td>
</tr>
<tr>
<td><div align="center" class="cell_fonts_grant_total style7"><strong><em>Employee Code  : <?php echo $emp_id;?></em></strong></div></td>
</tr>
<tr>
<td><div align="center" class="cell_fonts_grant_total style6"><strong><em><?php echo $emp->name." (".$emp->designation.")";?> </em></strong></div></td>
</tr><tr>
<td><div align="center" class="cell_fonts_grant_total style6"><strong><em><?php echo $emp->department.", ".$emp->company_name;?> </em></strong></div></td>
</tr>
</table>
</span>          
<? }?>
</div>
          </div>
          </div>
    </div>
  </div></div></div>
          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div>
    </div>
    </div>
 </form>   
 </div>
    <*/?>


<?
    
    require_once SERVER_CORE."routing/layout.bottom.php";
?>