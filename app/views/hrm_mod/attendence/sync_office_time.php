
<?php

session_start();
//

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.core/init.php);
require_once SERVER_CORE."routing/layout.top.php";




do_calander('#m_date');

do_calander('#date_start');

do_calander('#date_end');

$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');

$table='hrm_inout';

$unique='id';



if($_POST['mon']!=''){

$mon=$_POST['mon'];}

else{

$mon=date('n');

}





if(isset($_POST["upload"])){



if($_POST['emp_id']>0) {

$PBI_ID=$_POST['emp_id'];

$emp_con = " and p.PBI_ID='".$PBI_ID."'";

}



$PBI_ORG = $_POST['PBI_ORG'];

$date_start = $_POST['date_start'];

$date_end = $_POST['date_end'];



$start_time2 = $_POST['start_time2'];

$end_time2 = $_POST['end_time2'];

$mid_time2 = $_POST['mid_time2'];

$time22 = strtotime($mid_time2);

$mid_time3 = date("H:i:s", strtotime('+1 minutes', $time22));







if($PBI_ORG>0) $ORG_con = " and p.PBI_ORG='".$PBI_ORG."'";



if($date_start>0 && $date_end>0){

$start_date = $date_start;

$end_date   = $date_end;

}else{

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

		

} // end if date		



$q1="UPDATE hrm_att_summary s, personnel_basic_info p SET  s.sch_in_time = '".$start_time2."', s.sch_out_time = '".$end_time2."'

WHERE s.emp_id=p.PBI_ID and p.employee_type = 'Non Roster' and  s.att_date BETWEEN '".$start_date."' AND '".$end_date."'

".$emp_con.$ORG_con."

";

$query=db_query($q1);



$q2="UPDATE hrm_att_summary h, hrm_leave_info l, personnel_basic_info p SET h.sch_in_time = '".$mid_time3."', h.sch_out_time = '".$end_time2."'

WHERE  h.emp_id=p.PBI_ID and p.employee_type = 'Non Roster' and h.leave_id=l.id and h.leave_duration = 0.5 

and l.half_or_full='First Half' and h.att_date BETWEEN '".$start_date."' AND '".$end_date."' 

".$emp_con.$ORG_con."

";

$query=db_query($q2);





$q3="UPDATE hrm_att_summary h, hrm_leave_info l, personnel_basic_info p SET h.sch_in_time = '".$start_time2."', h.sch_out_time = '".$mid_time2."'

WHERE  h.emp_id=p.PBI_ID and p.employee_type = 'Non Roster' and  h.leave_id=l.id and h.leave_duration = 0.5

and l.half_or_full='Last Half' and h.att_date BETWEEN '".$start_date."' AND '".$end_date."' 

".$emp_con.$ORG_con."

";

$query=db_query($q3);



$q4="UPDATE hrm_att_summary set dayname = dayname(att_date) 

WHERE dayname='' and att_date BETWEEN '".$start_date."' AND '".$end_date."' ";

$query=db_query($q4);





echo 'Office Time Update Successfully';

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

<tr><td height="40" colspan="6" bgcolor="#00FF00"><div align="center" class="style1">Office Time Update  </div></td></tr>



<tr>

  <td>Employee Code </td>

  <td><input type="text" name="emp_id" id="emp_id" value="<?=$_POST['emp_id']?>" /></td>

  <td>Start Time </td>

  <td colspan="3"><input type="text" name="start_time2" id="start_time2" value="<?=$start_time2?$start_time2:'09:31:00';?>" /></td>

</tr>

<tr>

  <td>Company:</td>

  <td><span class="oe_form_group_cell">

    <select name="PBI_ORG" style="width:160px;" id="PBI_ORG">

      <? foreign_relation('user_group','id','group_name',$PBI_ORG);?>

    </select>

  </span></td>

  <td>End Time </td>

  <td colspan="3"><input type="text" name="end_time2" id="end_time2" value="<?=$end_time2?$end_time2:'18:00:00';?>" /></td>

</tr>

<tr>

  <td>Year :</td>

  <td><select name="year" style="width:160px;" id="year" required="required">

    <option <?=($year=='2021')?'selected':''?>>2021</option>

  </select></td>

  <td>Break Time </td>

  <td colspan="3"><input type="text" name="mid_time2" id="mid_time2" value="<?=$mid_time2?$mid_time2:'13:00:00';?>" /></td>

</tr>

<tr>

<td width="20%">Month :</td>

<td><span class="oe_form_group_cell">

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

<td>&nbsp;</td>

<td colspan="3">&nbsp;</td>

                </tr>

              <tr>

                <td>Or Custom Date : </td>

                <td>Start: <input name="date_start" type="text" id="date_start" autocomplete="off" value="<?=$date_start?$date_start:'';?>"/>End: 

				<input name="date_end" type="text" id="date_end" autocomplete="off" value="<?=$date_end?$date_end:'';?>"/></td>

                <td>&nbsp;</td>

                <td colspan="3">&nbsp;</td>

              </tr>

              <tr>

                <td>&nbsp;</td>

                <td>&nbsp;</td>

                <td>&nbsp;</td>

                <td colspan="3">&nbsp;</td>

                </tr>

              

              <tr>



                <td colspan="6">

                  <div align="center">

                    <input name="upload" type="submit" id="upload" value="Update" />

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



 </form>   </div>


<?

$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";

?>




