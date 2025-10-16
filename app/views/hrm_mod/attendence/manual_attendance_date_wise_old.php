<?php








require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title="Manual Attendance";



do_calander('#s_date');


do_calander('#e_date');




$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';







auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');







$table='hrm_inout';







$unique='id';















if(isset($_POST['search']))
{		

$emp_id=$_POST['PBI_ID'];

$access_date=$a_date=$_POST['s_date'];
$access_e_date=$a_date=$_POST['e_date'];


$c_date=explode('-',$a_date);

$access_stamp=mktime($_POST['m_hr'],$_POST['m_min'],0,$c_date[1],$c_date[2],$c_date[0]);

$time =  $_POST['m_hr'].':'.$_POST['m_min'].':'.'00';

$sch = find_all_field_sql('select p.off_day,s.office_start_time,s.office_end_time from personnel_basic_info p, hrm_schedule_info s where p.PBI_ID="'.$emp_id.'" and p.office_time=s.id');



$date = date('Ymd',$access_stamp);
/*if(date('N',$access_stamp)==$sch->off_day) $info['status'][$date]=0;
else{
if($sch->office_start_time == '')	$info['status'][$date]=1;
else{$info['late'][$date] = (int)(($access_stamp - strtotime($access_date.' '.$sch->office_start_time))/60);

if($info['late'][$date]>0) 	$info['status'][$date]=2;
else 	$info['status'][$date]=1;
}}*/




$s_date= strtotime($_REQUEST['s_date']);
$e_date= strtotime($_REQUEST['e_date']);

////////////////////////


for($i=$s_date; $i<=$e_date; $i+=86400){


 $att_date=date('Y-m-d',$i);
 
 $access_time=$att_date.' '.$_POST['m_hr'].':'.$_POST['m_min'].':'.'00';

 $att_sql = "INSERT INTO hrm_attdump ( ztime, bizid, xdate, xtime,EMP_CODE,xenrollid,time) 
VALUES ('$access_time', '$emp_id', '$att_date', '$access_time','$emp_id','$emp_id','$time')";
$att_query=db_query($att_sql);






}
//////////////////////


	







		







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






<script type="text/javascript">



$(document).ready(function(){







  $("#e_date").change(function (){



     var from_leave = $("#s_date").datepicker('getDate');



     var to_leave = $("#e_date").datepicker('getDate');



    var days   = ((to_leave - from_leave)/1000/60/60/24)+1;







	if(days>0&&days<100){



	$("#total_days").val(days);}



  });



      $("#s_date").change(function (){



     var from_leave = $("#s_date").datepicker('getDate');



     var to_leave = $("#e_date").datepicker('getDate');



    var days   = ((to_leave - from_leave)/1000/60/60/24)+1;



	if(days>0&&days<100){



	$("#total_days").val(days);}



  });



    



  



});



 



</script>















    <form action=""  method="post">

        <div class="d-flex justify-content-center">

            <div class="n-form1 fo-width pt-0">
                <h4 class="text-center bg-titel bold pt-2 pb-2">      Manual Attendance Date Wise    </h4>
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="container">

                            <div class="form-group row  m-0 mb-1 pl-3 pr-3">
                                <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Employee Code:  </label>
                                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                                    <input name="PBI_ID"  type="text" id="PBI_ID" size="10" onblur="" tabindex="1"  class="form-control" />
                                </div>
                            </div>

                        </div>

                        <div class="container">

                            <div class="form-group row m-0 mb-1 pl-3 pr-3">
                                <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Access Date-Time:    </label>


                                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2">
                                    <input type="text" name="s_date" autocomplete="off" id="s_date" class="form-control" />
                                </div>

                                <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1 p-0 pr-2 bold" align="center">
                                    -To-
                                </div>

                                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2">
                                    <input type="text" name="e_date" autocomplete="off" id="e_date" class="form-control" />
                                </div>

                            </div>

                        </div>


                        <div class="container">
                            <div class="row">


                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group row m-0 mb-1 pl-3 pr-3">
                                        <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Hr:    </label>
                                        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                                            <select name="m_hr" id="m_hr" ><? for($i=0;$i<24;$i++){ ?>
                                                    <option><?=sprintf('%02d', $i);?></option>
                                                <? }?></select>


                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group row m-0 mb-1 pl-3 pr-3">
                                        <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Min:    </label>
                                        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                                            <select name="m_min"  id="m_min">
                                                <? for($i=0;$i<60;$i++){?>
                                                    <option><?=sprintf('%02d', $i);?></option>
                                                <? }?> </select>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="n-form-btn-class">
                        <input name="search" type="submit" class="btn1 btn1-bg-submit" id="search" value="Manual Attendence" />
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
                                    <h4 class="bold">Employee Code  :  <?php echo $emp_id;?></h4>

                                </div>

                                                        <div align="center" class="cell_fonts_grant_total style6">
                                                            <h4 class="bold"> <?php echo $emp->name." (".$emp->designation.")";?></h4>
                                                        </div>

                                <div align="center" class="cell_fonts_grant_total style6">
                                    <h4 class="bold"><?php echo $emp->department.", ".$emp->company_name;?> </h4></div>


</span>

                <? }?>




            </div>


        </div>


    </form>






<?/*>
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







                <td height="40" colspan="4" bgcolor="#00FF00"><div align="center" class="style1">Manual Attendance </div></td>







                </tr>







              <tr>







                <td><div align="right">Employee Code: </div></td>







                <td colspan="3"><input name="PBI_ID"  type="text" id="PBI_ID" size="10" onblur="" tabindex="1" style="width:400px;" class="form-control" /></td>







              </tr>







              <tr>


<td width="20%"><div align="right">Access Date-Time:</div></td>
<td><input type="text" name="s_date" autocomplete="off" id="s_date" style="width:50%;" class="form-control" /></td>

<td><input type="text" name="e_date" autocomplete="off" id="e_date" style="width:50%;" class="form-control" /></td>



<td><select name="m_hr" id="m_hr" ><? for($i=7;$i<20;$i++){ ?>
<option><?=sprintf('%02d', $i);?></option>
<? }?></select>Hr</td>
<td><select name="m_min"  id="m_min">
<? for($i=0;$i<60;$i++){?>
<option><?=sprintf('%02d', $i);?></option>
<? }?> </select> Min</td>
 </tr>


 <tr>







                <td colspan="4" align="center"><input name="search" type="submit" class="btn btn-success form-control" id="search" value="Manual Attendence" /></td>







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







<td height="50" bgcolor="#006600"><div align="center" class="style2">ACCESS IN AT: 







  <?=date('d/m/Y H:i:s A',$access_stamp)?>







</div></td>







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







</div></div>







          </div>







    </div>















  </div>
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

    <*/?>







<?







$main_content=ob_get_contents();







ob_end_clean();







require_once SERVER_CORE."routing/layout.bottom.php";







?>