<?php




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Roster Reporting'; 

$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';



do_calander('#roster_date');do_calander('#roster_date2');







$dept_id = find_a_field('user_activity_management','region_id','user_id="'.$_SESSION['user']['id'].'"');



$dept_name = find_a_field('department','DEPT_SHORT_NAME','DEPT_ID="'.$dept_id.'"');



$sec_id = find_a_field('user_activity_management','zone_id','user_id="'.$_SESSION['user']['id'].'"');



$sec_name = find_a_field('domai','DOMAIN_DESC','DOMAIN_CODE="'.$sec_id.'"');











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






<!--Hrm All report pages design-->
<form action="master_report_roster.php" target="_blank" method="post">
    <div class="form-container_large">
        <h4 class="text-center bg-titel bold pt-2 pb-2"> Select Options </h4>
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <!--left form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
       
                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="group_for" id="group_for"   onchange="getData2('ajax_location.php', 'loc', this.value,  this.value)" required="required">
     									 <? foreign_relation('user_group', 'id', 'group_name',$_POST['group_for'],'1 and id="'.$_SESSION['user']['group'].'"')?>
    							</select>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Job Location </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="JOB_LOCATION" id="JOB_LOCATION">

							  		<option></option>
						
									<? foreign_relation('office_location','ID','LOCATION_NAME',$_POST['JOB_LOCATION'],'1');?>
						
							  </select>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PBI IN </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="pbi_in" type="text" id="pbi_in" value="<?=$_POST['pbi_in']?>"  />
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Start Date </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="roster_date" type="text" id="roster_date" value="<? if(isset($_POST['roster_date'])){ echo $_POST['roster_date']; }else{echo date('Y-m-01'); } ?>" required="required" />
                            </div>
                        </div>
						




                    </div>
                </div>

                <!--Right form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                       

                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Department</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="department"  id="department" class="form-control">
									 <option></option>
							
									<? foreign_relation('department','DEPT_ID','DEPT_DESC',$PBI_DEPART,' 1 order by DEPT_DESC');?>
							
								</select>
                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Schedule</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="schedule">

									 <option></option>

        						<? foreign_relation('hrm_schedule_info','id','schedule_name',$_POST['schedule'],'office_start_time > 0');?>

      							</select>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">End Date</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="roster_date2" type="text" id="roster_date2" value="<? if(isset($_POST['roster_date2'])){ echo $_POST['roster_date2']; }else{echo date('Y-m-d'); } ?>" required="required" />
                            </div>
                        </div>





                    </div>
                </div>


            </div>

        </div>
		<br/>

        <h4 class="text-center bg-titel bold pt-2 pb-2">
            Select report
        </h4>

        <div class="container-fluid p-0 ">
<!--            table start hear-->
            <table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-info">
                    <th  width="5%"></th>
                    <th class="text-left"></th>
                </tr>
                </thead>
                <tbody class="tbody1">

                <tr>
                    <td><input type="radio" placeholder="test 2" id="report" name="report" value="1"/></td>
                    <td class="bold" align="left"> <label for="1">Roster Schedule Report (1)</label> </td>
                </tr>
				
				 <tr>
                    <td><input type="radio"  id="report" name="report" value="2"/></td>
                    <td class="bold" align="left"> <label for="2">Schedule Vs Attendance Report(2)</label> </td>
                </tr>
				
				 <tr>
                    <td><input type="radio"  id="report" name="report" value="2025"/></td>
                    <td class="bold" align="left"> <label for="2025">Roster Schedule Info</label> </td>
                </tr>






                </tbody>
            </table>


            <div class="n-form-btn-class">
                <!--            button code hear-->
                <input name="submit" type="submit" class="btn1 btn1-bg-submit" id="submit" value="SHOW" />
            </div>

        </div>
    </div>

</form>


	








<?php /*?><form action="master_report_roster.php" target="_blank" method="post">



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







<tr class="oe_list_header_columns" align="center">



  <th colspan="4" class="p-3 mb-2 bg-primary text-white"><span>Select Options</span></th>



  </tr>



</thead><tfoot>



</tfoot><tbody>



  <tr>



    <td align="right" class="alt"><strong>Company :</strong></td>



    <td align="left" class="alt"><select name="group_for" id="group_for"   onchange="getData2('ajax_location.php', 'loc', this.value,  this.value)" required="required">



      <? foreign_relation('user_group', 'id', 'group_name',$_POST['group_for'],'1 and id="'.$_SESSION['user']['group'].'"')?>



    </select></td>



    <td width="40%" align="right" class="alt"><strong>Department :</strong></td>



    <td width="10%"><span class="oe_form_group_cell">



      <select name="department" style="width:160px;" id="department" class="form-control">







	   <option></option>







        <? foreign_relation('department','DEPT_ID','DEPT_DESC',$PBI_DEPART,' 1 order by DEPT_DESC');?>







      </select>



    </span></td>



  </tr>







  <tr  class="alt">



    <td align="right"><strong>Job Location:</strong></td>



    <td><span class="oe_form_group_cell">



      <span id="loc"><select name="JOB_LOCATION" id="JOB_LOCATION">

	  <option></option>



        <? foreign_relation('office_location','ID','LOCATION_NAME',$_POST['JOB_LOCATION'],'1');?>



      </select></span>



    </span></td>



    <td align="right"><strong>Section :</strong></td>



    <td><strong>



      <input name="PBI_DOMAIN" style="width:160px;" id="PBI_DOMAIN" value="<?=$sec_name; ?>" readonly="readonly" />



    </strong></td>



  </tr>



  



  <tr >



    <td align="right">PBI IN </td>



    <td align="left"><span class="oe_form_group_cell">



      <input name="pbi_in" type="text" id="pbi_in" value="<?=$_POST['pbi_in']?>"  />



    </span></td>



    <td align="right" class="alt"><strong>Schedule :</strong></td>



    <td class="alt"><strong>



      <select name="schedule">

	  <option></option>



        <? foreign_relation('hrm_schedule_info','id','schedule_name',$_POST['schedule'],'office_start_time > 0');?>



      </select>



    </strong></td>



  </tr>



  <tr >



    <td align="right"><strong>Start Date:</strong></td>



    <td align="left"><span class="oe_form_group_cell">



      <input name="roster_date" type="text" id="roster_date" value="<? if(isset($_POST['roster_date'])){ echo $_POST['roster_date']; }else{echo date('Y-m-01'); } ?>" required="required" />



    </span></td>



    <td align="right"><strong>End  Date:</strong></td>



    <td><span class="oe_form_group_cell">



      <input name="roster_date2" type="text" id="roster_date2" value="<? if(isset($_POST['roster_date2'])){ echo $_POST['roster_date2']; }else{echo date('Y-m-d'); } ?>" required="required" />



    </span></td>



  </tr>



  



  



  </tbody></table>



<div style="text-align:center">



<table width="100%" class="table table-bordered table-sm">



  <thead>



<tr class="oe_list_header_columns">



  <th colspan="4" class=""><span style="text-align: center; font-size:16px; color:#C00">Select Report</span></th>



  </tr>



  </thead>



  <tfoot>



  </tfoot>



  <tbody>



    <tr>



      <td align="center"><input name="report" type="radio" class="radio" value="1"  /></td>



      <td><strong>Roster Schedule Report (1) </strong></td>



      <td align="center">&nbsp;</td>



      <td>&nbsp;</td>



    </tr>



    <tr>



      <td align="center"><input name="report" type="radio" class="radio" value="2"></td>



      <td><strong>Schedule Vs Attendance  Report (2) </strong></td>



      <td align="center">&nbsp;</td>



      <td>&nbsp;</td>



    </tr>



    <!--<tr>



      <td align="center"><input name="report" type="radio" class="radio" value="3" /></td>



      <td><strong>OverTime Report  (3)</strong></td>



      <td align="center">&nbsp;</td>



      <td>&nbsp;</td>



    </tr>-->



    



    



    

	

	  <tr >

	  <td align="center" class="alt"><input name="report" type="radio" class="radio" value="2025" /></td>

	  <td class="alt"><strong>Roster Schedule Info</strong></td>

	  </tr>

	

	

	

	



    



    



<!--    <tr >



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



    </tr>-->



  </tbody>



</table>



<input name="submit" type="submit" class="btn1 btn1-bg-submit" id="submit" value="SHOW" />



          </div></div></div>



          </div>



    </div>



    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">



      <div class="oe_follower_list"></div>



    </div></div></div></div></div>



    </div></div>



            



        </div>



  </div>



</form><?php */?>



<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>