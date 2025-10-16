<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$page_id = 35;

if($_POST['mon']!=''){
$mon=$_POST['mon'];}
else{
$mon=date('n');
}

function auto_dropdown($sql){
$res=db_query($sql);
while($data=mysqli_fetch_row($res)){
if($value==$data[0])
echo '<option value="'.$data[0].'" selected>'.$data[1].'</option>';
else
echo '<option value="'.$data[0].'">'.$data[1].'</option>';
}}

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';
do_calander('#start_date');
do_calander('#end_date');
$PBI_ID = $_POST['PBI_ID'];

?><div class="oe_view_manager oe_view_manager_current">
        
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

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view"><form action="?"  method="post">
<table width="100%" border="0" class="oe_list_content"><thead>
<tr class="oe_list_header_columns">
  <th colspan="4"><span style="text-align: center; font-size:18px; color:#09F">Single Log  Report </span></th>
  </tr>
<tr class="oe_list_header_columns">
  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
  </tr>
</thead><tfoot>
</tfoot><tbody>
	  <tr >
	    <td width="37%" align="right">&nbsp;</td>
	    <td width="9%" align="left"><strong>Month</strong></td>
	    <td width="16%" align="right"><span class="oe_form_group_cell">
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
	    <td width="38%">&nbsp;</td>
      </tr>
	  <tr >
	    <td align="right">&nbsp;</td>
	    <td align="left"><strong>Year</strong></td>
	    <td align="right"><select name="year" style="width:160px;" id="year" required="required">
          <option <?=($year=='2021')?'selected':''?>>2021</option>
        </select></td>
	    <td>&nbsp;</td>
      </tr>
	  <tr >
	    <td align="right">&nbsp;</td>
	    <td align="left"><strong>Department :</strong></td>
	    <td align="right"><span class="oe_form_group_cell">
	      <select name="department" style="width:160px;" id="department">
            <? foreign_relation('department','DEPT_ID','DEPT_DESC',$_POST['department'],' 1 order by DEPT_DESC');?>
          </select>
	    </span></td>
	    <td>&nbsp;</td>
      </tr>
	  <tr >
	    <td align="right">&nbsp;</td>
	    <td align="left"><strong>Section:</strong></td>
	    <td align="right"><strong>
	      <select name="PBI_DOMAIN">
            <? foreign_relation('domai','DOMAIN_DESC','DOMAIN_DESC',$_POST['PBI_DOMAIN']);?>
          </select>
	    </strong></td>
	    <td>&nbsp;</td>
      </tr>
<tr class="oe_list_header_columns">
  <th colspan="4"><table width="1%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><input name="create" type="submit" id="create" value="Show Report" /></td>
    </tr>
  </table>    </th>
</tr>

  </tbody></table>
          </form>
		  
<br>

<?php
		if($_POST['department']>0) 		$con .=' and a.DEPT_ID='.$_POST['department'];
		if($_POST['PBI_DOMAIN']!='')	$con .=' and a.PBI_DOMAIN="'.$_POST['PBI_DOMAIN'].'"';

if(isset($_POST["create"])){

$table='hrm_attendence_final2';
$unique='id';
$crud  =new crud($table);
$res = "SELECT h.id, h.PBI_ID, a.PBI_NAME as name, a.PBI_DEPARTMENT as dept,a.PBI_DOMAIN as section,a.PBI_DESIGNATION as desi, h.td, h.od, h.hd, h.lt, h.ab, h.lv, h.lwp, h.pre, h.pay
FROM hrm_attendence_final2 h, personnel_basic_info a
WHERE 
h.PBI_ID=a.PBI_ID and a.PBI_ORG = '".$_SESSION['user']['group']."' 
and h.mon='".$_POST['mon']."' and h.year='".$_POST['year']."'
".$con."
order by dept,section,desi,a.PBI_ID
";
echo $crud->link_report($res,$link);
}
?>
  <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>