<?php
session_start();
ob_start();
require "../../config/inc.all.php";
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';
do_calander('#ijdb');
do_calander('#ijda');
do_calander('#ppjdb');
do_calander('#ppjda');
?>

<form action="../report/master_report.php" target="_blank" method="post">
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
    <td width="40%" align="right"><strong>Name :</strong></td>
  <td width="10%" align="left"><input name="name" type="text" id="name" size="30" style="width:160px;"/></td>
  <td width="40%" align="right" class="alt"><strong>Department :</strong></td>
    <td width="10%">      <select name="department" style="width:160px;" id="department">
        <? foreign_relation('department','DEPT_ID','DEPT_DESC',$PBI_DEPARTMENT);?>
      </select>    </td>
  </tr>

  <tr  class="alt">
    <td align="right"><strong>Company Name :</strong></td><td align="left">      
	<select name="domain" style="width:160px;" id="domain">
        <? foreign_relation('domai','DOMAIN_CODE','DOMAIN_DESC',$PBI_DOMAIN, ' 1 order by DOMAIN_CODE');?>
      </select>
    </td>
    <td align="right"><strong>Designation :</strong></td>
    <td>      
	<select name="designation" style="width:160px;" id="designation">
	  <? foreign_relation('designation','DESG_ID','DESG_DESC',$PBI_DESIGNATION, ' 1 order by DESG_DESC');?>
        </select>	  </td>
  </tr>
  <tr >
    <td align="right"><strong>Gender :</strong></td>
    <td align="left">      <select name="gender" style="width:160px;">
        <option selected="selected"></option>
        <option>Male</option>
        <option>Female</option>
      </select>    </td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td align="right"><strong>Blood Group :</strong></td>
    <td align="left"><span class="oe_form_group_cell">
      <select name="blood_group" style="width:160px;" id="blood_group">
        <option selected="selected"></option>
<option>A(+ve)</option>
                            <option>A(-ve)</option>
                            <option>AB(+ve)</option>
                            <option>AB(-ve)</option>
                            <option>B(+ve)</option>
                            <option>B(-ve)</option>
                            <option>O(+ve)</option>
                            <option>O(-ve)</option>
                            <option>N/I</option>
      </select>
    </span></td>
    <td align="right"><strong>Edu Qualification :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="edu_qua" style="width:160px;" id="edu_qua">
      <? foreign_relation('edu_qua','EDU_QUA_DESC','EDU_QUA_DESC',$edu_qua, ' 1 order by EDU_QUA_DESC');?>
      </select></span></td>
  </tr>
  <tr >
    <td align="right"><strong>Job Status :</strong></td>
    <td align="left"><select name="PBI_JOB_STATUS">
                    <option selected="selected"></option>
                    <? foreign_relation('job_status','job_status','job_status',$job_status, ' 1 order by job_status');?>
                  </select>&nbsp;</td>
    <td align="right"><strong>Age (More Than) :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="age" style="width:160px;" id="age">
        <option selected="selected"></option>
        <? for($i=60;$i>24;$i--) echo '<option>'.$i.'</option>';?>
      </select></span></td>
  </tr>
  <tr >
    <td align="right"><strong>Initial Joining Date(Before) :</strong></td>
    <td align="left"><input name="ijdb" type="text" id="ijdb" size="30" style="width:160px;" /></td>
    <td align="right"><strong>Initial Joining Date(After) :</strong></td>
    <td><input name="ijda" type="text" id="ijda" size="30" style="width:160px;" /></td>
  </tr>
  <tr >
    <td align="right"><strong>P Post Joining Date(Before)  :</strong></td>
    <td align="left"><input name="ppjdb" type="text" id="ppjdb" size="30" style="width:160px;" /></td>
    <td align="right"><strong>P Post  Joining Date(After)  :</strong></td>
    <td><input name="ppjda" type="text" id="ppjda" size="30" style="width:160px;" /></td>
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
    <tr>
      <td width="4%" align="center"><input name="report" type="radio" class="radio" value="1" checked="checked" /></td>
      <td width="44%"><strong>Basic </strong> <strong>Information</strong></td>
      <td width="4%" align="center">&nbsp;</td>
      <td width="44%">&nbsp;</td>
      </tr>
    <!--<tr  class="alt">
      <td align="center"><input name="report" type="radio" class="radio" value="2" /></td>
      <td><strong>Educational Qualification</strong><strong></strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr >
      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="3" /></td>
      <td class="alt"><strong>Designation Wise Count</strong><strong></strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr >-->
      <td align="center" class="alt">&nbsp;</td>
      <td class="alt">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr >
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr >
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
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
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>