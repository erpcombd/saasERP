<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Payroll Salary Reports';		



$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';



do_calander('#ijdb');



do_calander('#ijda');



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



if(isset($_POST['lock'])){



$check_sql = 'select 1 from salary_lock where month='.$_POST['mon'].' and year='.$_POST['year'].'';



$check_query = db_query($check_sql);



$last_check = mysqli_num_rows($check_query );



if($last_check >0){



echo "<h3 style='text-align:center;background-color:red;color:white;'>This month and Year Salary Exist. Lock down is not possible</h3>";



}else{



for($i=0;$i<count($_POST['tr_type']);$i++){



$sql = 'INSERT INTO `salary_lock`( `month`, `year`, `job_location`, `salary_amount`, `tr_type`) 



VALUES ("'.$_POST['mon'].'","'.$_POST['year'].'","'.$_POST['job_location'][$i].'" , "'.$_POST['salary_amount'][$i].'" ,"'.$_POST['tr_type'][$i].'" )';



db_query($sql);



}



echo "<h3 style='text-align:center;background-color:green;color:white;'>Salary is been Locked</h3>";



}



}



//auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_JOB_STATUS)','PBI_ID','1','PBI_ID');



?>



<style>



.frmSearch {border: 1px solid #a8d4b1;}



#country-list{float:left;list-style:none;margin-top:-3px;padding:0;width:190px;position: absolute;}



#country-list li{padding: 10px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}



#country-list li:hover{background:#ece3d2;cursor: pointer;}



#id_no{padding: 10px;border: #a8d4b1 1px solid;}




 tr:nth-child(odd){
     background-color: white !important;
 }

tr:nth-child(even){
    background-color: whitesmoke!important;
}
</style>





<form action="../report/hr_master_report.php" target="_blank" method="post">
    <div class="form-container_large">
        <h4 class="text-center bg-titel bold pt-2 pb-2"> COMPENSATION MANAGEMENT </h4>
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <!--left form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
       
                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="PBI_ORG"  id="PBI_ORG">
                                  <? foreign_relation('user_group','id','group_name',$PBI_ORG);?>
							
                                </select>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Designation </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="designation"  id="designation">
								<option></option>
                                 <? foreign_relation('designation','DESG_ID','DESG_DESC',$ESS_DESIGNATION,'1 order by DESG_DESC');?>
                                </select>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Gender </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="gender" >
                                  <option selected="selected"></option>
                                  <option>Male</option>
                                  <option>Female</option>
                                </select>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Bonus Type </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="bonus_type" required = "required" >
                                  <option value="2">Eid-Ul-Adha</option>
                                  <option value="1">Eid-Ul-Fitre</option>
                                </select>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Assesment Year </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="financial_year"  id="financial_year"  class="form-control">

										<option></option>
										
										<option>2021-2022</option>
										
										<option>2022-2023</option>
										
										<option>2023-2024</option>
										
										<option>2024-2025</option>
										
										<option>2025-2026</option>
										
										<option>2026-2027</option>
										
										<option>2027-2028</option>
										
										<option>2028-2029</option>
									
										<option>2029-2030</option>
										
								</select>
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
                                <select name="department" id="department">
								<option></option>
                                  <? foreign_relation('department','DEPT_ID','DEPT_DESC',$PBI_DEPARTMENT,'1 order by DEPT_DESC');?>
                                </select>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Job Location</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="JOB_LOCATION" id="JOB_LOCATION" >
								<option></option>
                                  <? foreign_relation('project','PROJECT_ID','PROJECT_DESC',$_POST['JOB_LOCATION'],'1 order by PROJECT_DESC');?>
                                </select>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Job Status</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="job_status" >
                                  <option selected="selected"></option>
                                  <option>IN SERVICE</option>
                                  <option>NOT IN SERVICE</option>
                                </select>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">ID NO</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input type="text" id="id_no" name="id_no" placeholder="Employee Name..." />
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Tax Calculated With</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="tax_calculate_type" id="tax_calculate_type">

									<option>Assessment Year</option>
									
									<option>Date</option>
								
								</select>
                            </div>
                        </div>
						
						





                    </div>
                </div>


            </div>

        </div>
		<br />
		<div class="container-fluid bg-form-titel">
            <div class="row">
                
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="form-group row m-0">
                        <label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Month</label>
                        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
                            <select name="mon" id="mon" required="required">
                                  <option value="01" <?=($mon=='1')?'selected':''?>>Jan</option>
                                  <option value="02" <?=($mon=='2')?'selected':''?>>Feb</option>
                                  <option value="03" <?=($mon=='3')?'selected':''?>>Mar</option>
                                  <option value="04" <?=($mon=='4')?'selected':''?>>Apr</option>
                                  <option value="05" <?=($mon=='5')?'selected':''?>>May</option>
                                  <option value="06" <?=($mon=='6')?'selected':''?>>Jun</option>
                                  <option value="07" <?=($mon=='7')?'selected':''?>>Jul</option>
                                  <option value="08" <?=($mon=='8')?'selected':''?>>Aug</option>
                                  <option value="09" <?=($mon=='9')?'selected':''?>>Sep</option>
                                  <option value="10" <?=($mon=='10')?'selected':''?>>Oct</option>
                                  <option value="11" <?=($mon=='11')?'selected':''?>>Nov</option>
                                  <option value="12" <?=($mon=='12')?'selected':''?>>Dec</option>
                           </select>

                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="form-group row m-0">
                        <label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Year</label>
                        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
                            <select name="year"  id="year" required="required">
                                  <option <?=($year=='2013')?'selected':''?>>2013</option>
                                  <option <?=($year=='2014')?'selected':''?>>2014</option>
                                  <option <?=($year=='2015')?'selected':''?>>2015</option>
                                  <option <?=($year=='2016')?'selected':''?>>2016</option>
                                  <option <?=($year=='2017')?'selected':''?>>2017</option>
                                  <option <?=($year=='2018')?'selected':''?>>2018</option>
                                  <option <?=($year=='2019')?'selected':''?>>2019</option>
                                  <option <?=($year=='2020')?'selected':''?>>2020</option>
                                  <option <?=($year=='2021')?'selected':''?>>2021</option>
								    <option <?=($year=='2022')?'selected':''?>>2022</option>



                                  <option <?=($year=='2023')?'selected':''?>>2023</option>



                                  <option <?=($year=='2024')?'selected':''?>>2024</option>



                                  <option <?=($year=='2025')?'selected':''?>>2025</option>
								   <option <?=($year=='2026')?'selected':''?>>2026</option>



                                  <option <?=($year=='2027')?'selected':''?>>2027</option>
								  
								  
								  <option <?=($year=='2028')?'selected':''?>>2028</option>



                                  <option <?=($year=='2029')?'selected':''?>>2029</option>



                                  <option <?=($year=='2030')?'selected':''?>>2030</option>
                                </select>

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
					 <th  width="5%"></th>
                    <th class="text-left"></th>
                </tr>
                </thead>
                <tbody class="tbody1">

                <tr>
                    <td><input type="radio" "id="report" name="report" value="202" checked="checked"/></td>
                    <td class="bold" align="left"> <label for="1">Salary Information</label> </td>
					
					<td><input type="radio"  id="report" name="report" value="78"/></td>
                    <td class="bold" align="left"> <label for="2">Salary Report</label> </td>
                </tr>
				
				 <tr>
                    <td><input type="radio"  id="report" name="report" value="8888"/></td>
                    <td class="bold" align="left"> <label for="5">Salary Summary Sheet (Cash Portion)</label> </td>
					
					<td><input type="radio"  id="report" name="report" value="9999" /></td>
                    <td class="bold" align="left"> <label for="4">Salary Summary Sheet (All)</label> </td>
                </tr>
				<tr>
                    <td><input type="radio"  id="report" name="report" value="776" /></td>
                    <td class="bold" align="left"> <label for="3">Salary Report (Cash Portion)</label> </td>
					
					<td><input type="radio"  id="report" name="report" value="4512"/></td>
                    <td class="bold" align="left"> <label for="6">Salary Advice</label> </td>
                </tr>
				<tr>
                    <td><input type="radio"  id="report" name="report" value="233332"/></td>
                    <td class="bold" align="left"> <label for="6">Yearly Individual Salary Statement</label> </td>
					
					<td><input type="radio"  id="report" name="report" value="21211212" /></td>
                    <td class="bold" align="left"> <label for="7">Individual Fiscal Salary Statement</label> </td>
                </tr>
				<tr>
                    <td><input type="radio" id="8"  name="report" value="5312021"/></td>
                    <td class="bold" align="left"> <label for="8">Salary Certificate</label> </td>
					
					<td><input type="radio" id="report" name="report" value="5312029"/></td>
                    <td class="bold" align="left"> <label for="9">Salary Certificate Tax</label> </td>
                </tr>
				<tr>
                    <td><input type="radio" id="10" name="report" value="4763"/></td>
                    <td class="bold" align="left"> <label for="10">Advance Salary Report</label> </td>
					
					<td><input type="radio"  id="report" name="report" value="551010" /></td>
                    <td class="bold" align="left"> <label for="11">Yearly Department Wise Salary Statement</label> </td>
                </tr>
				<tr>
                    <td><input type="radio"  id="report" name="report" value="144441"/></td>
                    <td class="bold" align="left"> <label for="12">Salary Comparision Report</label> </td>
					
				     <td><input type="radio"  id="report" name="report" value="591010" /></td>
                    <td class="bold" align="left"> <label for="11">Employee Provident Fund Report</label> </td>
					
					
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






<?php /*?>
<div class="right_col" role="main">



<!-- Must not delete it ,this is main design header-->



<div class="">



<div class="clearfix"></div>



<div class="row">



<div class="col-md-12 col-sm-12 col-xs-12">



<div class="x_panel">



<div class="openerp openerp_webclient_container">



<div class="x_content">



<form action="../report/hr_master_report.php" target="_blank" method="post">



<div class="oe_view_manager oe_view_manager_current">



<div class="oe_view_manager_body">



<div  class="oe_view_manager_view_list"></div>



<div class="oe_view_manager_view_form">



<div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">



<div class="oe_form_buttons"></div>



<div class="oe_form_sidebar"></div>



<div class="oe_form_pager"></div>



<div class="oe_form_container">



<div class="oe_form">



<div class="">



<div  class="oe_view_manager_view_list">



<div  class="oe_list oe_view">



<table width="100%" border="0" class="table table-bordered table-sm">



<thead>



<tr class="table-success">



<th colspan="4"><span style="text-align: center; font-size:19px; color:#089c84">



<center>



COMPENSATION MANAGEMENT



</center>



</span></th>



</tr>



</thead>



<tfoot>



</tfoot>



<tbody>



<tr>



<td align="right" style="font-size:16px" class="alt"><strong>Company :</strong></td>



<td align="left" class="alt"><span class="oe_form_group_cell">



<select name="PBI_ORG" style="width:160px;" id="PBI_ORG">



<? foreign_relation('user_group','id','group_name',$PBI_ORG);?>



</select>



</span></td>



<td width="40%" align="right" class="alt" style="font-size:16px"><strong>Department :</strong></td>



<td width="10%"><span class="oe_form_group_cell">



<select name="department" style="width:160px;" id="department">



<option></option>



<? foreign_relation('department','DEPT_ID','DEPT_DESC',$PBI_DEPARTMENT,'1 order by DEPT_DESC');?>



</select>



</span></td>



</tr>



<tr  class="alt">



<td align="right" style="font-size:16px"><strong>Designation :</strong></td>



<td align="left"><span class="oe_form_group_cell">



<select name="designation" style="width:160px;" id="designation">



<option></option>



<? foreign_relation('designation','DESG_ID','DESG_DESC',$ESS_DESIGNATION,'1 order by DESG_DESC');?>



</select>



</span></td>



<td align="right" style="font-size:16px"><strong>Project / Job Location:</strong></td>



<td><span class="oe_form_group_cell">



<select name="JOB_LOCATION" id="JOB_LOCATION" style="width:160px;">



<option></option>



<? foreign_relation('project','PROJECT_ID','PROJECT_DESC',$_POST['JOB_LOCATION'],'1 order by PROJECT_DESC');?>



</select>



</span></td>



</tr>



<tr >



<td align="right" style="font-size:16px"><strong>Gender :</strong></td>



<td align="left"><span class="oe_form_group_cell">



<select name="gender" style="width:160px;">



<option selected="selected"></option>



<option>Male</option>



<option>Female</option>



</select>



</span></td>



<td align="right" style="font-size:16px"><strong>Job Status :</strong></td>



<td><span class="oe_form_group_cell">



<select name="job_status" style="width:160px;">



<option selected="selected"></option>



<option>IN SERVICE</option>



<option>NOT IN SERVICE</option>



</select>



</span></td>



</tr>



<tr >



<td align="right" style="font-size:16px"><span class="alt"><strong>Bonus Type  : </strong></span></td>



<td align="left"><strong>



<select name="bonus_type" required = "required" style="width:160px;">



<option value="2">Eid-Ul-Adha</option>



<option value="1">Eid-Ul-Fitre</option>



</select>



</strong></td>



<td align="right" style="font-size:16px"><strong>ID NO:</strong></td>



<td align="center"><span class="oe_form_group_cell">



<div class="frmSearch">



<input type="text" id="id_no" name="id_no" placeholder="Employee Name..." />



<div id="suggesstion-box"></div>



</div>



<? //foreign_relation('personnel_basic_info','PBI_ID','CONCAT("",PBI_ID,"","-", " ",PBI_NAME )',$PBI_ID);?>



</span></td>



</tr>



<tr >



<td align="right" style="font-size:16px"><span class="alt"><strong>Assesment Year  : </strong></span></td>



<td align="left"><strong>



<select name="financial_year"  id="financial_year"  class="form-control">



<option></option>



<option>2021-2022</option>



<option>2022-2023</option>



<option>2023-2024</option>



<option>2024-2025</option>



<option>2025-2026</option>



<option>2026-2027</option>



<option>2027-2028</option>



<option>2028-2029</option>



<option>2029-2030</option>



</select>



</strong></td>



<td align="right" style="font-size:16px"><strong>Tax Calculated With:</strong></td>



<td align="center"><span class="oe_form_group_cell">



<div class="frmSearch">



<select name="tax_calculate_type" id="tax_calculate_type">



<option>Assessment Year</option>



<option>Date</option>



</select>



<div id="suggesstion-box"></div>



</div>



<? //foreign_relation('personnel_basic_info','PBI_ID','CONCAT("",PBI_ID,"","-", " ",PBI_NAME )',$PBI_ID);?>



</span></td>



</tr>



<tr>



<td align="right" style="background-color:#089c84; color:#FFFFFF; font-size:16px"><span>Month:</span> </td>



<td align="left" style="background-color:#089c84; color:#FFFFFF; font-size:16px"><span class="oe_form_group_cell">



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



<td align="right" style="background-color:#089c84; color:#FFFFFF; font-size:16px; "><span style="float:right">Year  :</span></td>



<td style="background-color:#089c84; font-size:16px;padding-top:4px"><select name="year" style="width:160px;" id="year" required="required">



<option <?=($year=='2013')?'selected':''?>>2013</option>



<option <?=($year=='2014')?'selected':''?>>2014</option>



<option <?=($year=='2015')?'selected':''?>>2015</option>



<option <?=($year=='2016')?'selected':''?>>2016</option>



<option <?=($year=='2017')?'selected':''?>>2017</option>



<option <?=($year=='2018')?'selected':''?>>2018</option>



<option <?=($year=='2019')?'selected':''?>>2019</option>



<option <?=($year=='2020')?'selected':''?>>2020</option>



<option <?=($year=='2021')?'selected':''?>>2021</option>



<option <?=($year=='2022')?'selected':''?>>2022</option>



<option <?=($year=='2023')?'selected':''?>>2023</option>



<option <?=($year=='2024')?'selected':''?>>2024</option>



<option <?=($year=='2025')?'selected':''?>>2025</option>



<option <?=($year=='2026')?'selected':''?>>2026</option>



<option <?=($year=='2027')?'selected':''?>>2027</option>



<option <?=($year=='2028')?'selected':''?>>2028</option>



<option <?=($year=='2029')?'selected':''?>>2029</option>



<option <?=($year=='2030')?'selected':''?>>2030</option>



</select></td>



</tr>



</tbody>



</table>



<div style="text-align:center">



<table width="100%" class="table table-bordered table-sm">



<thead>



<tr class="">



<th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Report</span></th>



</tr>



</thead>



<tfoot>



</tfoot>



<tbody>



<tr  class="alt">



<td align="center"><input name="report" type="radio" class="radio" value="202" /></td>



<td align="left"><strong>Salary </strong> <strong>Information</strong></td>



</tr>



<tr >



<td align="center" class="alt"><input name="report" type="radio" class="radio" value="78" /></td>



<td align="left"><strong>Salary Report </strong></td>



</tr>



<tr >



<td align="center" class="alt"><input name="report" type="radio" class="radio" value="776" /></td>



<td align="left"><strong>Salary Report (Cash Portion)</strong></td>



</tr>



<tr>



<td align="center" class="alt"><input name="report" type="radio" class="radio" value="9999" /></td>



<td align="left"><strong>Salary Summery Sheet (All</strong>)</td>



</tr>



<tr>



<td align="center" class="alt"><input name="report" type="radio" class="radio" value="8888" /></td>



<td align="left"><strong>Salary Summery Sheet (Cash Portion)</strong></td>



</tr>



<tr >



<td align="center" class="alt"><input name="report" type="radio" class="radio" value="4512" /></td>



<td align="left"><strong>Salary Advice</strong></td>



</tr>



<tr>



<td align="center" class="alt"><input name="report" type="radio" class="radio" value="233332" /></td>



<td align="left"><strong>Yearly Individual Salary Statement</strong></td>



</tr>



<tr>



<td align="center" class="alt"><input name="report" type="radio" class="radio" value="21211212" /></td>



<td align="left"><strong>Individual Fiscal Salary Statement</strong></td>



</tr>



<!--<tr >



<td align="center" class="alt"><input name="report" type="radio" class="radio" value="45963214" /></td>



<td align="left"><strong>Pay Slip</strong></td>



</tr>-->



<tr >



<td align="center" class="alt"><input name="report" type="radio" class="radio" value="5312021" /></td>



<td align="left"><strong>Salary Certificate</strong></td>



</tr>



<tr >



<td align="center" class="alt"><input name="report" type="radio" class="radio" value="5312029" /></td>



<td align="left"><strong>Salary Certificate Tax</strong></td>



</tr>



<tr>



<td align="center" class="alt"><input name="report" type="radio" class="radio" value="4763" /></td>



<td align="left"><strong>Advance Salary Report</strong></td>



</tr>



<tr>



<td align="center" class="alt"><input name="report" type="radio" class="radio" value="551010" /></td>



<td align="left"><strong>Yearly Department Wise Salary Statement</strong></td>



</tr>



<tr >



<td align="center" class="alt"><input name="report" type="radio" class="radio" value="144441" /></td>



<td align="left"><strong>Salary Comparison Report</strong><strong></strong></td>



</tr>



</tbody>



</table>



<input name="submit" type="submit" id="submit" class="btn1 btn1-bg-submit" value="SHOW" />



</div>



</div>



</div>



</div>



</div>



<div class="oe_chatter">



<div class="oe_followers oe_form_invisible">



<div class="oe_follower_list"></div>



</div>



</div>



</div>



</div>



</div>



</div>



</div>



</form>



</td>



</td>



</td>



</div>



</div>



</div>



</div>



</div>



</div>
<?php */?>


<!-- /page content -->



<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>



<script>



$(document).ready(function(){



$("#id_no").keyup(function(){



$.ajax({



type: "POST",



url: "auto_com.php",



data:'keyword='+$(this).val(),



beforeSend: function(){



$("#id_no").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");



},



success: function(data){



$("#suggesstion-box").show();



$("#suggesstion-box").html(data);



$("#id_no").css("background","#FFF");



}



});



});



});



function selectCountry(val) {



$("#id_no").val(val);



$("#suggesstion-box").hide();



}



</script>



<?




require_once SERVER_CORE."routing/layout.bottom.php";



?>
