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

<form action="../report/master_report_spil.php" target="_blank" method="post">
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
  <th colspan="4"><span style="text-align: center; font-size:18px; color:#09F">Payroll Advance Reporting</span></th>
  </tr>
<tr class="oe_list_header_columns">
  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
  </tr>
</thead><tfoot>
</tfoot><tbody>
  <tr>
    <td width="40%" align="right"><strong>Name :</strong></td>
  <td width="10%" align="left"><input name="name" type="text" id="name" size="30" style="width:160px;"/></td>
  <td width="40%" align="right" class="alt"><strong>Identification Number :</strong></td>
    <td width="10%"><span class="oe_form_group_cell">
      <input type="text" name="employee_selected" id="employee_selected" />
    </span></td>
  </tr>

  <tr  class="alt">
    <td align="right"><strong>Company Name  :</strong></td>
    <td align="left"><span class="oe_form_group_cell">
      <select name="domain" style="width:160px;" id="domain">
         <? foreign_relation('domai','DOMAIN_CODE','DOMAIN_DESC',$PBI_DOMAIN, ' 1 order by DOMAIN_CODE');?>
      </select>
    </span></td>
    <td align="right"><strong>Department :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="department" style="width:160px;" id="department">
        <? foreign_relation('department','DEPT_ID','DEPT_DESC',$PBI_DEPARTMENT);?>
      </select>
    </span></td>
  </tr>
  <tr >
    <td align="right"><strong>Designation :</strong></td>
    <td align="left"><span class="oe_form_group_cell">
      <select name="designation" style="width:160px;" id="designation">
	  <? foreign_relation('designation','DESG_ID','DESG_DESC',$PBI_DESIGNATION);?>
        </select>
      </span></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td align="right"><strong>Gender :</strong></td>
    <td align="left"><span class="oe_form_group_cell">
      <select name="gender" style="width:160px;">
        <option selected="selected"></option>
        <option>Male</option>
        <option>Female</option>
      </select>
    </span></td>
    <td align="right"><strong>Job Status :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="job_status" style="width:160px;">
        <option selected="selected"></option>
        <option>IN SERVICE</option>
        <option>NOT IN SERVICE</option>
      </select>
    </span></td>
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
  <tr >
    <td align="right" bgcolor="#FF99FF">(For Payroll) Month  :</td>
    <td align="left" bgcolor="#FF99FF"><span class="oe_form_group_cell">
      <select name="mon" style="width:160px;" id="mon">
	    <option value="0" <?=($mon=='0')?'selected':''?>></option>
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
    <td bgcolor="#FF99FF"><select name="year" style="width:160px;" id="year">
      <option <?=($year=='0')?'selected':''?>></option>
      <option <?=($year=='2015')?'selected':''?>>2015</option>
      <option <?=($year=='2016')?'selected':''?>>2016</option>
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
    <tr>
      <td width="4%" align="center">&nbsp;</td>
      <td width="44%">&nbsp;</td>
      <td width="4%" align="center">&nbsp;</td>
      <td width="44%">&nbsp;</td>
      </tr>
    <tr  class="alt">
      <td align="center"><input name="report" type="radio" class="radio" value="2" /></td>
      <td><strong>Salary </strong> <strong>Information</strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr >
      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="3" /></td>
      <td class="alt"><strong>Monthly Attendence Report</strong><strong></strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr >
      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="4" /></td>
      <td class="alt"><strong>Over Time Amount Report</strong><strong></strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr >
      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="5" /></td>
      <td class="alt"><strong>Salary Payroll Report (Detail)</strong><strong></strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr >
      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="6" /></td>
      <td class="alt"><strong>Salary Payroll Report (Summary)</strong><strong></strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr >
      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="7" /></td>
      <td class="alt"><strong>Pay Slip (With Over-Time)</strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr >
      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="9" /></td>
      <td class="alt"><strong>Pay Slip (Without Over-Time)</strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    
    <tr >
      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="10" /></td>
      <td class="alt"><strong>Salary Cheque </strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr >
      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="10002" /></td>
      <td class="alt"><strong>PF Report </strong><strong></strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr >
      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="8" /></td>
      <td class="alt"><strong>Salary Payroll Report (Without Overtime)</strong><strong></strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	    <tr >
      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="10001" /></td>
      <td class="alt"><strong>Final Attendance Report</strong><strong></strong></td>
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