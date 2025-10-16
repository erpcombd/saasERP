<?php







//







//







require "../../config/inc.all.php";







$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';







do_calander('#f_date');







do_calander('#t_date');







do_calander('#ppjdb');







do_calander('#ppjda');




echo $user_id=$_SESSION['PBI']['ID'];


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







<table width="100%" border="0" class="table table-bordered"><thead>







<tr class="oe_list_header_columns">







  <th colspan="5"><span style="text-align: center; font-size:18px; color:#09F">Advance Reporting</span></th>

  </tr>







<tr class="oe_list_header_columns">







  <th colspan="5"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>

  </tr>







</thead><tfoot>







</tfoot><tbody>







  <tr>







    <td width="40%" colspan="2" align="right"><strong>Name :</strong></td>







  <td width="10%" align="left"><select name="emp_name">

    <? 

	if($_SESSION['user']['level']<5){

	foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$_SESSION['employee_selected'], ' PBI_ID='.$_SESSION['employee_selected']);

	}else{

	foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$emp_name, ' 1 ');}?>

  </select></td>







  <td width="40%" align="right" class="alt"><strong>Department :</strong></td>







    <td width="10%">      <select name="department" style="width:160px;" id="department">







        <? foreign_relation('department','DEPT_ID','DEPT_DESC',$PBI_DEPARTMENT);?>







      </select>    </td>

  </tr>















  <tr  class="alt">

    <td align="right" colspan="2">From</td>

    <td align="right"><input name="f_date" type="text" id="f_date" size="30" style="width:160px;" value="<?=date('Y-m-01')?>" /></td>

    <td align="right"><strong>Gender :</strong></td>

    <td align="right"><select name="gender" style="width:160px;">

        <option selected="selected"></option>

        <option>Male</option>

        <option>Female</option>

    </select></td>

  </tr>

  <tr  class="alt">



<td align="right" colspan="2">To</td>



	<td align="right"><input name="t_date" type="text" id="t_date" size="30" style="width:160px;" value="<?=date('Y-m-d')?>" /></td>

	<td align="right"><strong>Designation :</strong></td>







    



    <td>      







	<select name="designation" style="width:160px;" id="designation">







	  <? foreign_relation('designation','DESG_ID','DESG_DESC',$PBI_DESIGNATION, ' 1 order by DESG_DESC');?>

        </select>	  </td>

  </tr>

  

  <tr  class="alt">



<td align="right" colspan="2">All Project</td>



	<td align="right"><select name="project_id"id="project_id"  style="width:160px; height:30px; padding:5px;">

									  <option value="">Select Project Name</option>

                                          <? foreign_relation('project','PROJECT_ID','PROJECT_NAME',$project_id);?>

                                        </select></td>

	<td align="right">&nbsp;</td>







    



    <td>&nbsp;      







	 </td>

  </tr>







  

  </tbody></table>







<br /><div style="text-align:center">







<table width="100%" class="table table-bordered">







  <thead>







<tr class="oe_list_header_columns">







  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Report</span></th>

  </tr>

  </thead>







  <tfoot>

  </tfoot>







  <tbody>







    <tr>







      <td width="4%" align="center"><input name="report" type="radio" class="radio" value="12345" checked="checked" /></td>







      <td width="44%"><strong>Daily Task Report </strong><strong></strong></td>







      <td width="4%" align="center">&nbsp;</td>







      <td width="44%">&nbsp;</td>

      </tr>

	  

	   <tr>







      <td width="4%" align="center"><input name="report" type="radio" class="radio" value="5482" checked="checked" /></td>







      <td width="44%"><strong>Task Status Report Details </strong><strong></strong></td>







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

      <tr>

        <td align="center"><input name="report" type="radio" class="radio" value="5481"  /></td>

        <td><strong>Daily Att Report </strong><strong></strong></td>

        <td align="center">&nbsp;</td>







      <td>&nbsp;</td>

      </tr>







    <tr>

        <td align="center"><input name="report" type="radio" class="radio" value="007"  /></td>

        <td><strong>Daily Schedule Report </strong><strong></strong></td>

        <td align="center">&nbsp;</td>







      <td>&nbsp;</td>

      </tr>
	  
	  
	 
 <?php /*?><tr>

        <td align="center"><input name="report" type="radio" class="radio" value="050919"  /></td>

        <td><strong>All ERP Schedule Report </strong><strong></strong></td>

        <td align="center">&nbsp;</td>


      <td>&nbsp;</td>

      </tr>
<?php */?>





    <tr >







      <td align="center">&nbsp;</td>







      <td>&nbsp;</td>







      <td align="center">&nbsp;</td>







      <td>&nbsp;</td>

      </tr>







  </tbody>

</table>







<input name="submit" style="background-color:#80FF80;" type="submit" id="submit" value="SHOW" />







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