<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';
do_calander('#ijdb');
do_calander('#ijda');
do_calander('#ppjdb');
do_calander('#ppjda');
?>

<form action="master_report.php" target="_blank" method="post">
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
  <th colspan="4"><span style="text-align: center; font-size:18px; color:#09F"> Reporting</span></th>
  </tr>
<tr class="oe_list_header_columns">
  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
  </tr>
</thead><tfoot>
</tfoot><tbody>
  <tr>
    <td width="40%" align="right"><strong>Dealer Name :</strong></td>
  <td width="10%" align="left"><input name="dealer_name_e" type="text" id="dealer_name_e" size="30" style="width:160px;"/></td>
  <td width="40%" align="right" class="alt"><strong>Dealer Code  :</strong></td>
    <td width="10%"><input name="dealer_code" type="text" id="dealer_code" size="30" style="width:160px;"/></td>
  </tr>

  <tr  class="alt">
    <td align="right"><strong>Area :</strong></td><td align="left"><span class="oe_form_group_cell">
      <select name="area_code" style="width:160px;" id="area_code">
        <? foreign_relation('area','AREA_NAME','AREA_NAME',$PBI_AREA);?>
      </select>
    </span></td>
    <td align="right"><strong>Thana :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="thana_code" style="width:160px;" id="thana_code">
        <? foreign_relation('location','l_id','l_name',$thana_code,"l_type='TH'");?>
      </select></span></td>
  </tr>
  <tr >
    <td align="right"><strong>Zone :</strong></td>
    <td align="left"><span class="oe_form_group_cell">
      <select name="zone_code" style="width:160px;" id="zone_code">
        <? foreign_relation('zon','ZONE_NAME','ZONE_NAME',$PBI_ZONE);?>
        </select>
      </span></td>
    <td align="right"><strong>District :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="district_code" style="width:160px;" id="district_code">
        <? foreign_relation('location','l_id','l_name',$district_code,'l_type="DT"');?>
        </select></span></td>
  </tr>
  <tr >
    <td align="right"><strong>Region :</strong></td>
    <td align="left"><span class="oe_form_group_cell">
      <select name="region_code" style="width:160px;" id="region_code">
        <? foreign_relation('branch','BRANCH_NAME','BRANCH_NAME',$PBI_BRANCH);?>
      </select>
    </span></td>
    <td align="right"><strong>Division :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="division_code" style="width:160px;" id="division_code">
        <? foreign_relation('location','l_id','l_name',$division_code,'l_type="DV"');?>
      </select></span></td>
  </tr>
  <tr >
    <td align="right"><strong>Product Group :</strong></td>
    <td align="left"><strong>
      <input name="product_group" type="text" id="product_group" size="30" style="width:160px;"/>
    </strong></td>
    <td align="right"><strong>Mobile No :</strong></td>
    <td><input name="mobile_no" type="text" id="mobile_no" size="30" style="width:160px;"/></td>
  </tr>
  <tr >
    <td align="right"><strong>Depot :</strong></td>
    <td align="left"><span class="oe_form_group_cell">
      <select name="depot" style="width:160px;">
        <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot,' warehouse_type != "Purchase"');?>
      </select>
    </span></td>
    <td align="right"><strong>Status :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="canceled" style="width:160px;">
        <option selected="selected"></option>
        <option>Yes</option>
        <option>No</option>
      </select></span></td>
  </tr>
  </tbody></table><br /><div style="text-align:center">
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
      <td width="4%" align="center"><input name="report" type="radio" class="radio" value="801" /></td>
      <td width="44%"><strong> Warehouse Details List </strong><strong></strong></td>
      <td width="4%" align="center">&nbsp;</td>
      <td width="44%">&nbsp;</td>
      </tr>
    <tr  class="alt">
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr >
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
require_once SERVER_CORE."routing/layout.bottom.php";
?>