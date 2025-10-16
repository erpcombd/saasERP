<?php
session_start();
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";

//$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';
$title='Leave & OD Management';	
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

/*if(isset($_POST['lock'])){
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
		
		
		

}*/

?>



<form action="../report/hr_master_report.php" target="_blank" method="post">
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
						





                    </div>
                </div>


            </div>

        </div>
		<br />
		<div class="container-fluid bg-form-titel">
            <div class="row">
                
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="form-group row m-0">
                        <label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Month</label>
                        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
                            <select name="mon" id="mon" required="required">
                                  <option value="01" <?=($mon=='1')?'selected':''?>>January</option>
                                  <option value="02" <?=($mon=='2')?'selected':''?>>February</option>
                                  <option value="03" <?=($mon=='3')?'selected':''?>>March</option>
                                  <option value="04" <?=($mon=='4')?'selected':''?>>April</option>
                                  <option value="05" <?=($mon=='5')?'selected':''?>>May</option>
                                  <option value="06" <?=($mon=='6')?'selected':''?>>June</option>
                                  <option value="07" <?=($mon=='7')?'selected':''?>>July</option>
                                  <option value="08" <?=($mon=='8')?'selected':''?>>August</option>
                                  <option value="09" <?=($mon=='9')?'selected':''?>>September</option>
                                  <option value="10" <?=($mon=='10')?'selected':''?>>October</option>
                                  <option value="11" <?=($mon=='11')?'selected':''?>>November</option>
                                  <option value="12" <?=($mon=='12')?'selected':''?>>December</option>
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
                </tr>
                </thead>
                <tbody class="tbody1">

                <tr>
                    <td><input type="radio" placeholder="test 2" id="1" id="report" name="report" value="226655" checked="checked"/></td>
                    <td class="bold" align="left"> <label for="1">Leave Report</label> </td>
                </tr>
				
				 <tr>
                    <td><input type="radio" id="2" placeholder="test 2" id="report" name="report" value="201912"/></td>
                    <td class="bold" align="left"> <label for="2">OD Report</label> </td>
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



<br />



<?php /*?><form action="../report/hr_master_report.php" target="_blank" method="post">
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
                            
                            <tr class="table-info">
                              <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
                            </tr>
                          </thead>
                          <tfoot>
                          </tfoot>
                          <tbody>
                            <tr>
                              <td align="right" class="alt"  style="font-size:16px"><strong>Company :</strong></td>
                              <td align="left" class="alt"><span class="oe_form_group_cell">
                                <select name="PBI_ORG" style="width:160px;" id="PBI_ORG">
                                  <? foreign_relation('user_group','id','group_name',$PBI_ORG);?>
							
                                </select>
                                </span></td>
                              <td width="40%" align="right" class="alt"  style="font-size:16px"><strong>Department :</strong></td>
                              <td width="10%"><span class="oe_form_group_cell">
                                <select name="department" style="width:160px;" id="department">
								<option></option>
                                  <? foreign_relation('department','DEPT_ID','DEPT_DESC',$PBI_DEPARTMENT,'1 order by DEPT_DESC');?>
                                </select>
                                </span></td>
                            </tr>
                            <tr  class="alt">
                              <td align="right"  style="font-size:16px"><strong>Designation :</strong></td>
                              <td align="left"><span class="oe_form_group_cell">
                                <select name="designation" style="width:160px;" id="designation">
								<option></option>
                                 <? foreign_relation('designation','DESG_ID','DESG_DESC',$ESS_DESIGNATION,'1 order by DESG_DESC');?>
                                </select>
                                </span></td>
                              <td align="right"  style="font-size:16px"><strong>Project / Job Location:</strong></td>
                              <td><span class="oe_form_group_cell">
                                <select name="JOB_LOCATION" id="JOB_LOCATION" style="width:160px;">
								<option></option>
                                  <? foreign_relation('project','PROJECT_ID','PROJECT_DESC',$_POST['JOB_LOCATION'],'1 order by PROJECT_DESC');?>
                                </select>
                                </span></td>
                            </tr>
                            <tr >
                              <td align="right"  style="font-size:16px"><strong>Gender :</strong></td>
                              <td align="left"><span class="oe_form_group_cell">
                                <select name="gender" style="width:160px;">
                                  <option selected="selected"></option>
                                  <option>Male</option>
                                  <option>Female</option>
                                </select>
                                </span></td>
                              <td align="right"  style="font-size:16px"><strong>Job Status :</strong></td>
                              <td><span class="oe_form_group_cell">
                                <select name="job_status" style="width:160px;">
                                  <option selected="selected"></option>
                                  <option>IN SERVICE</option>
                                  <option>NOT IN SERVICE</option>
                                </select>
                                </span></td>
                            </tr>
                        
                         
                            <tr >
                              <td align="right"  style="font-size:16px"><span class="alt"><strong>Bonus Type  : </strong></span></td>
                              <td align="left"><strong>
                                <select name="bonus_type" required = "required" style="width:160px;">
                                  <option value="2">Eid-Ul-Adha</option>
                                  <option value="1">Eid-Ul-Fitre</option>
                                </select>
                              </strong></td>
                              <td align="right">&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr >
                             <td align="right" style="background-color:#35b1ea; color:#FFFFFF; font-size:16px"><span>Month:</span> </td>
                              <td align="left" style="background-color:#35b1ea; font-size:16px"><span class="oe_form_group_cell">
                                <select name="mon" style="width:160px;" id="mon" required="required">
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
                                </span></td>
                         <td align="right" style="background-color:#35b1ea; color:#FFFFFF; font-size:16px; "><span style="float:right">Year  :</span></td>
                              <td style="background-color:#35b1ea; font-size:16px;padding-top:4px"><select name="year" style="width:160px;" id="year" required="required">
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
                              <tr class="oe_list_header_columns">
                                <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Report</span></th>
                              </tr>
                            </thead>
                            <tfoot>
                            </tfoot>
                            <tbody>
                              
                            
                                
							   <tr >
                                <td align="center" class="alt"><input name="report" type="radio" class="radio" value="226655" /></td>
                                <td align="left"><strong>Leave Report </strong><strong></strong></td>
                              
                              </tr>
							  
							  
							   <tr >
                                <td align="center" class="alt"><input name="report" type="radio" class="radio" value="201912" /></td>
                                <td align="left"><strong>OD Report</strong><strong></strong></td>
                              
                              </tr>
                             
                              
							   
							 
                               
                              
                            </tbody>
                          </table>
                          <input name="submit" type="submit" id="submit" class="btn1 btn1-bg-submit" value="SHOW" />
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
    </div>
  </div>
</form><?php */?>




<?

require_once SERVER_CORE."routing/layout.bottom.php";
?>
