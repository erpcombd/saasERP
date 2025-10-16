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
  <th colspan="4"><span style="text-align: center; font-size:18px; color:#09F">Complex Reporting</span></th>
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
    <td width="10%"><span class="oe_form_group_cell">
      <select name="department" style="width:160px;" id="department">
       <? foreign_relation('department','DEPT_ID','DEPT_DESC',$PBI_DEPARTMENT);?>
      </select></span></td>
  </tr>

  <tr  class="alt">
    <td align="right"><strong>Company Name :</strong></td><td align="left"><span class="oe_form_group_cell">
      <select name="domain" style="width:160px;" id="domain">
        <? foreign_relation('domai','DOMAIN_CODE','DOMAIN_DESC',$PBI_DOMAIN, ' 1 order by DOMAIN_CODE');?>
      </select>
    </span></td>
    <td align="right"><strong>Gender :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="gender" style="width:160px;">
        <option selected="selected"></option>
        <option>Male</option>
        <option>Female</option>
      </select>
	  </span></td>
  </tr>
  <tr >
    <td align="right" bgcolor="#CC99FF"><strong>Designation :</strong></td>
    <td align="left" bgcolor="#CC99FF"><span class="oe_form_group_cell">
      <select name="DESG_GRADE1" style="width:160px;" id="DESG_GRADE1">
        <? foreign_relation('designation','DESG_ID','DESG_DESC',$PBI_DESIGNATION, ' 1 order by DESG_DESC');?>
      </select>
    </span></td>
    <td align="right" bgcolor="#CC99FF"><strong>To Designation :</strong></td>
    <td align="left" bgcolor="#CC99FF"><span class="oe_form_group_cell">
      <select name="DESG_GRADE2" style="width:160px;" id="DESG_GRADE2">
        <? foreign_relation('designation','DESG_ID','DESG_DESC',$PBI_DESIGNATION, ' 1 order by DESG_DESC');?>
      </select></span></td>
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
      <option selected="selected"></option>
<option>ALIM</option><option>B Com
</option><option>B Ed
</option><option>B Sc
</option><option>BA
</option><option>BA (Special)
</option><option>BA(Hons)
</option><option>BBS
</option><option>BSC Agri Eng
</option><option>BSC Eng
</option><option>BSS
</option><option>CA(CC)
</option><option>Class Eight
</option><option>Class Five
</option><option>Class Nine
</option><option>Class Seven
</option><option>Class Ten
</option><option>Class Three
</option><option>DAKHIL
</option><option>Diploma Eng
</option><option>Diploma in Ag
</option><option>Diploma in Commerce
</option><option>DVM
</option><option>FADIL
</option><option>Fazil B.A. (Special)
</option><option>Higher Diploma Eng
</option><option>Hons
</option><option>HSC
</option><option>KAMIL
</option><option>M Com</option>
      </select></span></td>
  </tr>
  <tr >
    <td align="right"><strong>Job Status :</strong></td>
    <td align="left"><select name="PBI_JOB_STATUS">
                    <option selected="selected">                      </option>
                    <option>In Service</option>
                    <option>Not In Service</option>
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
  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Columns</span></th>
  </tr>
  </thead>
  <tfoot>
  </tfoot>
  <tbody>
    <tr>
      <td align="center" class="alt"><input name="report" type="hidden" value="201" checked="checked" />
        <input name="PBI_NAME" type="checkbox" id="PBI_NAME" value="1" /></td>
      <td class="alt"><strong>Full Name</strong></td>
      <td width="4%" align="center"><input name="PBI_MARITAL_STA" type="checkbox" id="PBI_MARITAL_STA" value="1" /></td>
      <td width="44%">Marital Status</td>
      </tr>
    <tr>
      <td width="4%" align="center"><input name="PBI_DESIGNATION" type="checkbox" id="PBI_DESIGNATION" value="1" /></td>
      <td width="44%">Designation</td>
      <td align="center" class="alt"><input name="PBI_PRESENT_ADD" type="checkbox" id="PBI_PRESENT_ADD" value="1" /></td>
      <td class="alt">Present Address</td>
    </tr>
    <tr >
      <td align="center" class="alt"><input name="PBI_SEX" type="checkbox" id="PBI_SEX" value="1" /></td>
      <td class="alt">Gender</td>
      <td align="center"><input name="PBI_PERMANENT_ADD" type="checkbox" id="PBI_PERMANENT_ADD" value="1" /></td>
      <td>Permanent Address</td>
    </tr>
    <tr >
      <td align="center" class="alt"><input name="PBI_PHONE" type="checkbox" id="PBI_PHONE" value="1" /></td>
      <td class="alt">Phone No</td>
      <td align="center"><input name="PBI_DOB" type="checkbox" id="PBI_DOB" value="1" /></td>
      <td>Birth Date</td>
      </tr>
    <tr >
      <td align="center" class="alt"><input name="PBI_MOBILE" type="checkbox" id="PBI_MOBILE" value="1" /></td>
      <td class="alt">Mobile No</td>
      <td align="center"><input name="PBI_RELIGION" type="checkbox" id="PBI_RELIGION" value="1" /></td>
      <td>Religion</td>
      </tr>
    <tr >
      <td align="center"><input name="PBI_EMAIL" type="checkbox" id="PBI_EMAIL" value="1" /></td>
      <td>Email </td>
      <td align="center"><input name="JOB_STATUS" type="checkbox" id="JOB_STATUS" value="1" /></td>
      <td>Job Status</td>
    </tr>
    
<tr >
<td align="center"><input name="PBI_DOMAIN" type="checkbox" id="PBI_DOMAIN" value="1" /></td>
<td>Company Name</td>
<td align="center"><input name="PBI_DEPARTMENT" type="checkbox" id="PBI_DEPARTMENT" value="1" /></td>
<td>Department</td>
</tr>

<tr >
<td align="center"><input name="PBI_DOJ" type="checkbox" id="PBI_DOJ" value="1" /></td>
<td>Initial Joining Date </td>
<td align="center"><input name="PBI_DOJ_PP" type="checkbox" id="PBI_DOJ_PP" value="1" /></td>
<td>Joining Date (PP)</td>
</tr>

<tr >
  <td align="center"><input name="PBI_EDU_QUALIFICATION" type="checkbox" id="PBI_EDU_QUALIFICATION" value="1" /></td>
  <td>Educational Qualification</td>
  <td align="center">&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr >
<td align="center"></td>
<td></td>
<td align="center"></td>
<td></td>
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