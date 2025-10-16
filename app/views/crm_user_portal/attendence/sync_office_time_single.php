<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
do_calander('#m_date');
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';
auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');
$table='hrm_inout';
$unique='id';

if($_POST['mon']!=''){
$mon=$_POST['mon'];}
else{
$mon=date('n');
}


if(isset($_POST["upload"])){

/*		$year = $_POST['year'];
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
		$endTime = $days2=mktime(0,0,0,$mon,26,$year);*/
		
		$start_date='2019-08-10';
		$end_date='2019-08-10';

echo $q1="UPDATE hrm_att_summary s, personnel_basic_info p SET  s.sch_in_time = '09:31:00', s.sch_out_time = '17:00:00'
WHERE s.emp_id=p.PBI_ID and p.employee_type = 'Non Roster' and  s.att_date BETWEEN '".$start_date."' AND '".$end_date."' ";
$query=db_query($q1);

$q2="UPDATE hrm_att_summary h, hrm_leave_info l, personnel_basic_info p SET h.sch_in_time = '13:01:00', h.sch_out_time = '17:00:00'
WHERE  h.emp_id=p.PBI_ID and p.employee_type = 'Non Roster' and h.leave_id=l.id and h.leave_duration = 0.5 
and l.half_or_full='First Half' and h.att_date BETWEEN '".$start_date."' AND '".$end_date."' ";
$query=db_query($q2);


$q3="UPDATE hrm_att_summary h, hrm_leave_info l, personnel_basic_info p SET h.sch_in_time = '09:31:00', h.sch_out_time = '13:00:00'
WHERE  h.emp_id=p.PBI_ID and p.employee_type = 'Non Roster' and  h.leave_id=l.id and h.leave_duration = 0.5
and l.half_or_full='Last Half' and h.att_date BETWEEN '".$start_date."' AND '".$end_date."' ";
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
<tr><td height="40" colspan="4" bgcolor="#00FF00"><div align="center" class="style1">Office Time Update  </div></td></tr>

<tr>
  <td>&nbsp;</td>
  <td colspan="3">&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td colspan="3">&nbsp;</td>
</tr>
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

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>