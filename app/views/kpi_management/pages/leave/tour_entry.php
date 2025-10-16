<?php
session_start();
ob_start();
require_once "../../config/inc.all.php";
do_calander('#s_date');
do_calander('#e_date');
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';
auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');
// ::::: Edit This Section ::::: 
$title='Official Tour Information';			// Page Name and Page Title
$page="tour_entry.php";		// PHP File Name
$input_page="tour_entry_input.php";
$root='leave';

$table='hrm_offical_tour';
$unique='id';
$shown='s_date';

// ::::: End Edit Section :::::

$crud      =new crud($table);
if(prevent_multi_submit()){
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];
$crud->insert();
}
}





?>
<script type="text/javascript"> function DoNav(lk){
return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
}</script>
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
                <td height="40" colspan="2" bgcolor="#00FF00"><div align="center" class="style1">Official Tour Entry </div></td>
                </tr>
              <tr>
                <td width="20%"><div align="right">Employee Code : </div></td>
                <td><input name="PBI_ID"  type="text" id="PBI_ID" size="10" onblur="" tabindex="1" style="width:400px;" /></td>
              </tr>
              
              <tr>
                <td align="right" bgcolor="#EBEBEB"><div align="right"> Start Date :</div></td>
                <td bgcolor="#EBEBEB"><input type="text" name="s_date" id="s_date" style="width:100px;" /></td>
              </tr>
              <tr>
                <td align="right"><div align="right"> End Date :</div></td>
                <td><input type="text" name="e_date" id="e_date" style="width:100px;" /></td>
              </tr>
              <tr>
                <td bgcolor="#EBEBEB"><div align="right">Total  Days : </div></td>
                <td bgcolor="#EBEBEB"><input type="text" name="total_days" id="total_days" style="width:100px;" readonly="" required="required" /></td>
              </tr>
              <tr>
                <td bgcolor="#FFFFFF"><div align="right">Reason :</div></td>
                <td bgcolor="#FFFFFF"><label>
                  <input name="reason" type="text" id="reason" />
                </label></td>
              </tr>
              <tr>
                <td bgcolor="#EBEBEB"><div align="right">Paid Status : </div></td>
                <td bgcolor="#EBEBEB"><label>
                  <select name="paid_status" id="paid_status">
                    <option>Paid</option>
                    <option>Unpaid</option>
                  </select>
                </label></td>
              </tr>
              
              <tr>
                <td colspan="2"><label>
                    <div align="center">
                      <input name="search" type="submit" id="search" value="add" />
                    </div>
                  </label></td>
              </tr>
            </table>
            <br /><div style="text-align:center">
              <div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div class="oe_view_manager_view_list"><div class="oe_list oe_view">
<? if($_POST['PBI_ID']>0)
$res = "select o.id,a.PBI_ID,a.PBI_NAME,c.DESG_DESC,d.DEPT_DESC,o.s_date as start_date, o.e_date as end_date,o.total_days from personnel_basic_info a,designation c, department d,hrm_offical_tour o where a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID  and a.PBI_ID=o.PBI_ID and  a.PBI_ID='".$_POST['PBI_ID']."' order by o.id desc";
else
$res = "select o.id,a.PBI_ID,a.PBI_NAME,c.DESG_DESC,d.DEPT_DESC,o.s_date as start_date, o.e_date as end_date,o.total_days from personnel_basic_info a,designation c, department d,hrm_offical_tour o where a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID  and a.PBI_ID=o.PBI_ID  order by o.id desc";
echo $crud->link_report($res,$link);         
 ?>
</div></div>
          </div>
    </div>

  </div></div></div>
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
include ("../../template/main_layout.php");
?>