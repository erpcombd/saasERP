<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

do_calander('#jfdate');
do_calander('#jtdate');

do_calander('#ijdb');
do_calander('#ijda');
do_calander('#ppjdb');
do_calander('#ppjda');

do_calander('#fdate');

do_calander('#tdate');


if($_POST['mon']!=''){
$mon=$_POST['mon'];}
else{
$mon=date('n');
}

if($_POST['year']!=''){
$year=$_POST['year'];}
else{
$year=date('Y');
}
?>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>


<form action="../jobCard/master_report.php" target="_blank" method="post">
<div class="oe_view_manager oe_view_manager_current">

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
<table width="100%" border="0" class="oe_list_content"><thead>
<tr class="oe_list_header_columns">
  <th colspan="4"><span style="text-align: center; font-size:18px; color:#09F">Advance Reporting</span></th>
  </tr>
<tr class="oe_list_header_columns">
  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
  </tr>
</thead><tfoot>
</tfoot><tbody>
  <tr>
    <td align="right" class="alt"><strong>Company :</strong></td>
    <td align="left" class="alt"><span class="oe_form_group_cell">
      <select name="PBI_ORG" style="width:160px;" id="PBI_ORG">
	   <option></option>
        <? foreign_relation('user_group','id','group_name',$PBI_ORG);?>
      </select>
    </span></td>
    <td width="40%" align="right" class="alt"><strong>Department :</strong></td>
    <td width="10%"><span class="oe_form_group_cell">
      <select name="department" style="width:160px;" id="department">
	  <option></option>

        <? foreign_relation('department','DEPT_ID','DEPT_DESC',$PBI_DEPARTMENT);?>
      </select>
    </span></td>
  </tr>

  <tr  class="alt">
    <td align="right"><strong>Designation :</strong></td>
    <td align="left"><span class="oe_form_group_cell">
      <select name="designation" style="width:160px;" id="designation">
	  <option></option>
        <?=foreign_relation('designation','DESG_ID','DESG_DESC',$designation);?>
      </select>
    </span></td>
    <td align="right"><strong>Payroll Type : </strong></td>
    <td>
	<select name="payroll_type" style="width:160px;" id="payroll_type">
	  <option></option>

        <? foreign_relation('salary_payroll_type','id','payroll_type',$payroll_type);?>
      </select>
	</td>
  </tr>
  <tr >
    <td align="right"><strong>Region :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="branch" style="width:160px;" id="branch">
	   <option></option>
        <? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$PBI_BRANCH);?>
      </select>
    </span></td>
    <td align="right"><strong>Salary Shift : </strong></td>
    <td>
		<select name="salary_shift" style="width:160px;" id="salary_shift">
	  <option></option>

        <? foreign_relation('salary_shift_info','id','shift_name',$salary_shift);?>
      </select>
	</td>
  </tr>
  <tr >
    <td align="right"><strong>Zone :</strong></td>
	 <option></option>
    <td align="left"><span class="oe_form_group_cell">
      <select name="zone" style="width:160px;" id="zone">
	  <option></option>
        <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$PBI_ZONE);?>
      </select>
    </span></td>
    <td align="right"><strong>Employment Type :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="PBI_RESIDENT" style="width:160px;" id="PBI_RESIDENT">
        <option></option>
        <? foreign_relation('hrm_residential','id','residential',$PBI_RESIDENT);?>
      </select>
    </span></td>
  </tr>
  <tr >
    <td align="right"><strong>Section :</strong></td>
    <td align="left"><strong>
      <select name="PBI_DOMAIN">
	   <option></option>
        <? foreign_relation('domai','DOMAIN_DESC','DOMAIN_DESC',$_POST['PBI_DOMAIN']);?>
      </select>
    </strong></td>
    <td align="right"><strong>Job Status :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="job_status" style="width:160px;">
        <option></option>
        <option>IN SERVICE</option>
        <option>NOT IN SERVICE</option>
      </select>
    </span></td>
  </tr>

  <tr >
    <td align="right"><strong>Job Location:</strong></td>
    <td align="left">
		<span class="oe_form_group_cell">
      <select name="JOB_LOCATION" style="width:160px;" id="JOB_LOCATION">
	  <option></option>
        <? foreign_relation('job_location_type','id','job_location_name',$JOB_LOCATION);?>
      </select>
    </span>

	</td>
    <td align="right"><strong>Mess Bill Type :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="mess_bill_type" style="width:160px;" id="mess_bill_type">
        <option></option>
        <? foreign_relation('mess_bill_type','id','bill_type',$mess_bill_type);?>
      </select>
    </span></td>
  </tr>
  <tr >
    <td align="right"><strong>Joining Date (From) :</strong></td>
    <td align="left"><input name="jfdate" type="text" id="jfdate" size="30" style="width:160px;" /></td>
    <td align="right"><strong>Joining Date (To) :</strong></td>
    <td><input name="jtdate" type="text" id="jtdate" size="30" style="width:160px;" /></td>
</tr>

  <tr >
    <td align="right"><strong>Eid Bonus : </strong></td>
    <td align="left"><strong>



	  <select name="bonus_type" style="width:160px;" id="bonus_type">
        <option></option>
        <? foreign_relation('salary_festival_bonus','id','festival_type',$bonus_type);?>
      </select>
    </strong></td>
    <td align="right"><strong>PBI ID IN :</strong></td>


    <td>
	<?

		//auto_complete_from_db('personnel_basic_info','EMP_CODE','concat(PBI_ID,"#>",PBI_NAME)','1','pbi_id_in');

		auto_complete_from_db('personnel_basic_info','concat(EMP_CODE," - ",PBI_NAME)','concat(EMP_CODE)','','pbi_id_in');

	?>

	<input name="pbi_id_in" type="text" id="pbi_id_in" /></td>
  </tr>
  <tr >
    <td align="right">Gender</td>
    <td align="left">
	<span class="oe_form_group_cell">
      <select name="gender" style="width:160px;">
        <option></option>
        <option>Male</option>
        <option>Female</option>
      </select>
    </span>
	</td>
    <td align="right"><strong>Temporary Type   :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="temporary_id" style="width:160px;" id="temporary_id">
        <option></option>
        <? foreign_relation('temporary_employment','id','temporary',$temporary_id);?>
      </select>
    </span></td>
  </tr>


  <tr >



    <td align="right"><strong>From Date  :</strong></td>



    <td align="left"><input name="fdate" type="text" id="fdate" size="30" style="width:160px;" value="<?= date('Y-m-d')?>" /></td>



    <td align="right"><strong>To Date  :</strong></td>



    <td><input name="tdate" type="text" id="tdate" size="30" style="width:160px;" value="<?= date('Y-m-d')?>"  /></td>
  </tr>



  <tr >
    <td align="right"><strong>Roster Schedule  :</strong></td>
    <td align="left">
		<select name="shedule_no" style="width:160px;" id="shedule_no">
	  <option></option>
        <? foreign_relation('hrm_schedule_info','id','schedule_name',$shedule_no);?>
      </select>
	</td>
    <td align="right"><strong>Define Shift :</strong>  </td>
    <td>
	<select name="define_shift" style="width:160px;" id="define_shift">
	  <option></option>
        <? foreign_relation('hrm_shift_info','id','shift_name',$define_shift,'1 order by id');?>
      </select>
	</td>
  </tr>


  <!--<tr >



    <td align="right"><strong>From Time  :</strong></td>



    <td align="left">
		<select name="sch_in_time" style="width:160px;">
                    <option selected>
				   <?=$sch_in_time?>
				   </option>

						<option value="07:15:00">07.00 AM</option>

						<option value="14:15:00">02.00 PM</option>

						<option value="22:15:00">10.00 PM</option>
                </select>	</td>



    <td align="right"><strong>To Time  :</strong></td>



    <td>
			<select name="sch_out_time" style="width:160px;">
                   <option selected>
				   <?=$sch_out_time?>
				   </option>
						</option>

						<option value="07:00:00">07.00 AM</option>

						<option value="14:00:00">02.00 PM</option>

						<option value="22:00:00">10.00 PM</option>
                  </select>	</td>
  </tr>-->





  <tr >
    <td align="right" bgcolor="#FF99FF">(For Payroll) Month  :</td>
    <td align="left" bgcolor="#FF99FF"><span class="oe_form_group_cell">
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
    <td align="right" bgcolor="#FF99FF">(For Payroll) Year  :</td>
    <td bgcolor="#FF99FF"><select name="year" style="width:160px;" id="year" required="required">
      <option <?=($year=='2015')?'selected':''?>>2015</option>
      <option <?=($year=='2016')?'selected':''?>>2016</option>
	  <option <?=($year=='2017')?'selected':''?>>2017</option>
      <option <?=($year=='2018')?'selected':''?>>2018</option>
      <option <?=($year=='2019')?'selected':''?>>2019</option>
	  <option <?=($year=='2020')?'selected':''?>>2020</option>
	  <option <?=($year=='2021')?'selected':''?>>2021</option>
	  <option <?=($year=='2022')?'selected':''?>>2022</option>
	  <option <?=($year=='2023')?'selected':''?>>2023</option>
	  <option <?=($year=='2024')?'selected':''?>>2024</option>
	  <option <?=($year=='2025')?'selected':''?>>2025</option>
    </select></td>
  </tr>
  </tbody></table>
<br /><div style="text-align:center">
<table width="100%" class="oe_list_content">
  <thead>
<tr class="oe_list_header_columns">
  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Report</span></th>
  </tr>
  </thead>
  <tfoot>
  </tfoot>
  <tbody>


	  <tr >
	  <td align="center" class="alt"><input name="report" type="radio" class="radio" value="7717"  checked="checked"  /></td>
	  <td class="alt"><strong>Employee ID Card Info (7717)</strong></td>
	  <td align="center">&nbsp;</td>
	  <td>&nbsp;</td>
	  </tr>

	  <tr >
	  <td align="center" class="alt"><input name="report" type="radio" class="radio" value="7719" /></td>
	  <td class="alt"><strong>Employee ID Card Info Backside (7719)</strong></td>
	  <td align="center">&nbsp;</td>
	  <td>&nbsp;</td>
	  </tr>



	  <tr >
	  <td align="center" class="alt"><input name="report" type="radio" class="radio" value="77170001" /></td>
	  <td class="alt"><strong>Employee ID Card Info <span class="style1">(New Update Bangla)</span></strong></td>
	  <td align="center">&nbsp;</td>
	  <td>&nbsp;</td>
	  </tr>




	  <tr >
	  <td align="center" class="alt"><input name="report" type="radio" class="radio" value="77170003" /></td>
	  <td class="alt"><strong>Employee ID Card Info For Staff<span class="style1"> (New Update English)</span></strong></td>
	  <td align="center">&nbsp;</td>
	  <td>&nbsp;</td>
	  </tr>


  </tbody>
</table>
<input name="submit" type="submit" id="submit" value="SHOW" />
          </div></div></div>
          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>

        </div>
  </div>
</form>
<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>
