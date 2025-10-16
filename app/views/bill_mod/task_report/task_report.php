<?php




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';



$title='Advance Reporting';



do_calander('#end_date');



do_calander('#start_date');



do_calander('#ppjdb');



do_calander('#ppjda');



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



?><style type="text/css">



<!--



.style1 {



	font-size: 16px;



	color: #C00;



}



-->



</style>







<form action="../task_report/master_report.php" target="_blank" method="post">



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



<table width="100%" border="0" class="table table-bordered table-sm"><thead>



<!--<tr class="oe_list_header_columns" style="text-align:center">



  <th colspan="4"><center><span style="text-align: center; font-size:18px; color:#09F">Advance Reporting</span></center></th>



  </tr>-->



<!--<tr class="oe_list_header_columns" style="text-align:center">



  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>



  </tr>-->



</thead><tfoot>



</tfoot><tbody>



  <tr>



    <td align="right" class="alt"><strong>Company :</strong></td>



    <td align="left" class="alt"><span class="oe_form_group_cell">



      <select name="PBI_ORG" style="width:160px;" id="PBI_ORG" class="form-control">



        <? foreign_relation('user_group','id','group_name',$PBI_ORG);?>
      </select>



    </span></td>



    <td width="40%" align="right" class="alt"><strong>Department :</strong></td>



    <td width="10%"><span class="oe_form_group_cell">



      <select name="department" style="width:160px;" id="department" class="form-control">



	   <option></option>



        <? foreign_relation('department','DEPT_ID','DEPT_DESC',$PBI_DEPART,' 1 order by DEPT_DESC');?>
      </select>



    </span></td>
  </tr>







  
  <tr >



    <td align="right"><strong>Branch :</strong></td>



    <td align="left"><span class="oe_form_group_cell">



      <select name="PBI_BRANCH" style="width:160px;" id="PBI_BRANCH" class="form-control">



	  <option></option>



        <? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$PBI_BRANCH);?>
      </select>



    </span></td>



    <td align="right"><strong>Employee:</strong></td>



    <td><span class="oe_form_group_cell">



      <select name="PBI_ID" id="PBI_ID" style="width:160px;" class="form-control">
         <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$_POST['PBI_ID'],'1')?>
      </select> 



    </span></td>
  </tr>



  




  <tr class="table-primary">



    <td align="right">Start Date   :</td>



    <td align="left"><span class="oe_form_group_cell">



      <input type="text" name="start_date" id="start_date" class="form-control" />



    </span></td>



    <td align="right">End Date   :</td>



    <td> <input type="text" name="end_date" id="end_date" class="form-control" /></td>
  </tr>



  </tbody></table>

<div style="text-align:center">



<table width="100%" class="table table-bordered table-sm">




  <tbody>



    <tr>



      <td align="center">&nbsp;</td>



      <td align="left"><span class="style1" style="text-decoration:underline;">Select Report </span></td>



     



    </tr>



    <tr>



      <td width="4%" align="center"><input name="report" type="radio" class="radio" value="999" checked="checked" /></td>



      <td width="44%" align="left"><strong>Progress Report</strong></td>

    </tr>


  </tbody>



</table>



<input name="submit" type="submit" id="submit" class="btn btn-danger" value="SHOW" />



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