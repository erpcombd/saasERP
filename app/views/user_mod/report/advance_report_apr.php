<?php
//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
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
  <th colspan="4"><span style="text-align: center; font-size:18px; color:#09F">APR Advance Reporting</span></th>
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
        <? foreign_relation('department','DEPT_SHORT_NAME','DEPT_DESC',$PBI_DEPARTMENT);?>
      </select>
    </span></td>
  </tr>

  <tr  class="alt">
    <td align="right"><strong>Domain :</strong></td><td align="left"><span class="oe_form_group_cell">
      <select name="domain" style="width:160px;" id="domain">
        <? foreign_relation('domai','DOMAIN_SHORT_NAME','DOMAIN_SHORT_NAME',$PBI_DOMAIN);?>
      </select>
    </span></td>
    <td align="right"><strong>Project :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="project" style="width:160px;" id="project">
        <? foreign_relation('project','PROJECT_SHORT_NAME','PROJECT_DESC',$PBI_PROJECT);?>
      </select>
    </span></td>
  </tr>
  <tr >
    <td align="right"><strong>Designation :</strong></td>
    <td align="left"><span class="oe_form_group_cell">
      <select name="designation" style="width:160px;" id="designation">
        <? foreign_relation('designation','DESG_SHORT_NAME','DESG_DESC',$PBI_DESIGNATION);?>
        </select>
      </span></td>
    <td align="right"><strong>Area :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="area" style="width:160px;" id="area">
        <? foreign_relation('area','AREA_NAME','AREA_NAME',$PBI_AREA);?>
        </select>
      </span></td>
  </tr>
  <tr >
    <td align="right"><strong>Zone :</strong></td>
    <td align="left"><span class="oe_form_group_cell">
      <select name="zone" style="width:160px;" id="zone">
        <? foreign_relation('zon','ZONE_NAME','ZONE_NAME',$PBI_ZONE);?>
      </select>
    </span></td>
    <td align="right"><strong>Branch :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="branch" style="width:160px;" id="branch">
        <? foreign_relation('branch','BRANCH_NAME','BRANCH_NAME',$PBI_BRANCH);?>
      </select>
    </span></td>
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
        </select></span></td>
  </tr>
  <tr >
    <td align="right"><strong>Recommendation for Promotion :</strong></td>
    <td align="left"><select name="d_r_promotion">
      <option selected="selected"> </option>
                    <option>Yes</option>
                    <option>No</option>
                    <option>N/A</option>
    </select></td>
    <td align="right"><strong>Age (More Than) :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="age" style="width:160px;" id="age">
        <option selected="selected"></option>
        <? for($i=60;$i>24;$i--) echo '<option>'.$i.'</option>';?>
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
    <td align="right"><strong style="color:#C00">APR Marks(Before) :</strong></td>
    <td align="left"><input name="markb" type="text" id="markb" size="30" style="width:160px;" /></td>
    <td align="right"><strong style="color:#C00">APR Marks(After) :</strong></td>
    <td><input name="marka" type="text" id="marka" size="30" style="width:160px;" /></td>
  </tr>
  </tbody></table><br /><div style="text-align:center">
<table width="100%" class="oe_list_content">
  <thead>
<tr class="oe_list_header_columns">
  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Report for Year <span class="oe_form_group_cell">
    <select name="year" style="width:160px;" id="year">
      <option>2006</option>
      <option>2007</option>
      <option>2008</option>
      <option>2009</option>
      <option>2010</option>
      <option>2011</option>
      <option selected="selected">2012</option>
      <option>2013</option>
    </select>
  to 
  <select name="year2" style="width:160px;" id="year2">
    <option>2006</option>
    <option>2007</option>
    <option>2008</option>
    <option>2009</option>
    <option>2010</option>
    <option>2011</option>
    <option selected="selected">2012</option>
    <option>2013</option>
  </select>
  <span style="font-size:12px; color:#090">[2nd Year Field Only for 'No APR Report'] </span> </span></span></th>
  </tr>
  </thead>
  <tfoot>
  </tfoot>
  <tbody>
    <tr>
      <td width="4%" align="center"><input name="report" type="radio" class="radio" value="101"  /></td>
      <td colspan="3"><strong>Total APR Form </strong><strong><span style="font-size:12px; color:#090">[1st year field select '2012' will show ONLY 2012 year's APR holder's 2010,2011,2012 marks and average with other info] </span> </strong></td>
      </tr>
    <tr  class="alt">
      <td align="center"><input name="report" type="radio" class="radio" value="102" /></td>
      <td width="44%"><strong>Below Average Marks</strong><strong></strong></td>
      <td width="4%" align="center">&nbsp;</td>
      <td width="44%">&nbsp;</td>
      </tr>
    <tr >
      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="103" /></td>
      <td class="alt"><strong>Below Service Length</strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr >
      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="104" /></td>
      <td class="alt"><strong>No APR Form </strong><strong></strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr >
      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="105" /></td>
      <td class="alt"><strong> 3 Year Up & No Recommendation </strong><strong></strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr >
      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="106" /></td>
      <td class="alt"><strong> Recommend But 3 Year Not Up</strong><strong></strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr >
      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="107" /></td>
      <td class="alt"><strong> Total Promotion Recommended</strong><strong></strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr >
      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="108" /></td>
      <td class="alt"><strong> Over Age</strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr >
      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="109" /></td>
      <td class="alt"><strong> Already Promoted</strong><strong></strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr >
      <td align="center" class="alt">&nbsp;</td>
      <td class="alt">&nbsp;</td>
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
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>