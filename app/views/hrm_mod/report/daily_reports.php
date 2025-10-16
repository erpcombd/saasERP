<?php

session_start();
//
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';
$title='Attendance Management Report';



do_calander('#ijdb');
do_calander('#ijda');
do_calander('#ppjdb');
do_calander('#ppjda');
do_calander('#PBI_DOB');
//do_calander('#fdate');
//do_calander('#tdate');

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




<style>
  tr:nth-child(odd){
    background-color: white !important;
  }

  tr:nth-child(even){
    background-color: whitesmoke!important;
  }
</style>

<form action="../report/master_report_att_management.php" target="_blank" method="post">
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
                <div class="oe_form_sheetbg">
                  <div class="oe_form_sheet oe_form_sheet_width">
                    <div  class="oe_view_manager_view_list">
                      <div  class="oe_list oe_view">
                          
                             <? include('../common/title_bar_report.php');?>
					  
                    
						  
						  <table width="100%" border="0" class="table table-bordered table-sm">
						      
						      
						      
						 <!-- <thead>
                            <tr class="table-info">
                              <th colspan="6"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
                            </tr>
                          </thead>
						  
						  
                          <tbody>
							  
                            <tr>
                              <td align="right" ><strong>Employee ID: </strong></td>
								
                              <td align="left" >
								 
								  
								 
								
							  
								  
                             	 <input list="pbi" name="pbi_id_in" style="width:160px;" type="text" id="pbi_id_in" class="form-control" />
                                <datalist  id="pbi" >
                                  <option></option>
                                  <? foreign_relation('personnel_basic_info','PBI_CODE','concat(PBI_CODE,"-",PBI_NAME)',$PBI_ID , '1') ;?>
                                </datalist>
                                  
                                
                              </td>
								
                              <td align="right" >&nbsp;</td>
                              <td align="right" ><strong>Service Length : </strong></td>
                              <td><select name="service_length" style="width:160px;" id="service_length" class="form-control">
                                  <option  value="<?=$_POST['service_length']?>"></option>
                                  <option value="1">1 Years</option>
                                  <option value="2">2 Years</option>
                                  <option value="3">3 Years</option>
                                  <option value="4">4 Years</option>
                                  <option value="5">5 Years</option>
                                  <option value="6">6 Years</option>
                                  <option value="7">7 Years</option>
                                  <option value="8">8 Years</option>
                                  <option value="9">9 Years</option>
                                  <option value="10">10 Years</option>
                                </select>
                              </td>
                            </tr>
                            <tr>
                              <td width="17%" align="right" ><strong>Company : </strong></td>
                              <td width="25%" align="left" ><span class="oe_form_group_cell">
                                <select name="PBI_ORG" style="width:160px;" class="form-control" id="PBI_ORG">
                                  <option></option>
                                  <? foreign_relation('user_group','id','group_name',$PBI_ORG);?>
                                </select>
                                </span></td>
                              <td width="9%" align="right" >&nbsp;</td>
                              <td align="right"><strong>Designation : </strong></td>
                              <td align="left"><span class="oe_form_group_cell">
                                <select name="designation" style="width:160px;" class="form-control" id="designation">
                                  <option></option>
                                  <? foreign_relation('designation','DESG_ID','DESG_DESC',$designation,' 1 order by DESG_DESC');?>
                                </select>
                                </span></td>
                            </tr>
                            <tr>
                              <td width="23%" align="right" ><strong>Department : </strong></td>
                              <td width="26%"><span class="oe_form_group_cell">
                                <select name="department" style="width:160px;" class="form-control" id="department">
                                  <option></option>
                                  <? foreign_relation('department','DEPT_ID','DEPT_DESC',$PBI_DEPARTMENT,' 1 order by DEPT_DESC');?>
                                </select>
                                </span></td>
                              <td width="9%" align="right" >&nbsp;</td>
                              <td width="23%" align="right" ><strong>Job Location : </strong></td>
                              <td width="26%"><span class="oe_form_group_cell">
                                <select name="JOB_LOCATION" style="width:160px;" id="JOB_LOCATION"  class="form-control"  >
                                  <option>
                                  <?=$JOB_LOCATION?>
                                  </option>
                                  <option value="1">Head Office</option>
                                  <option value="2">Factory</option>
                                </select>
                                </span></td>
                            </tr>
                            <tr >
                              <td align="right"><strong> Bank Or Cash: </strong></td>
                              <td><select style="width:160px;" name="bank_or_cash" id="bank_or_cash">
                                  <option></option>
                                  <option>Bank</option>
                                  <option>Cash</option>
                                </select>
                              </td>
                              <td align="right">&nbsp;</td>
                              <td align="right"><strong>Job Status : </strong></td>
                              <td><span class="oe_form_group_cell">
                                <select name="job_status" style="width:160px;" class="form-control">
                              
                                  <option>In Service</option>
                                  <option>Not In Service</option>
                                </select>
                                </span></td>
                            </tr>
                     
                            
                            <tr >
                              <td align="right"><strong>Employee Type : </strong></td>
                              <td align="left"><select name="EMPLOYMENT_TYPE" style="width:160px;" id="EMPLOYMENT_TYPE"  class="form-control">
                                  <option></option>
                                  <option>Permanent</option>
                                  <option>Contructual</option>
                                  <option>Probation</option>
                                  <option>6 Months</option>
                                  <option>Trainee</option>
                                </select>
                              </td>
                              <td align="right">&nbsp;</td>
                              <td align="right"><strong>Education : </strong></td>
                              <td><select name="PBI_EDU_QUALIFICATION" style="width:160px;" id="PBI_EDU_QUALIFICATION"  class="form-control">
                                  <option></option>
                                  <? foreign_relation('education_detail','EDUCATION_D_ID','EDUCATION_NOE',$PBI_EDU_QUALIFICATION) ;?>
                                </select>
                                </select></td>
                            </tr>
                            <tr >
                              <td align="right">(Eid)<strong>Bonus: </strong></td>
                              <td align="left"><strong>
                                <select name="bonus_type" style="width:160px;" class="form-control">
                                  <option></option>
                                  <option value="1">Eid-Ul-Fitre</option>
                                  <option value="2">Eid-Ul-Adha</option>
                                </select>
                                </strong></td>
                              <td align="right">&nbsp;</td>
                              <td align="right"></td>
                              <td>
								
							  </td>
                            </tr> -->
						
						
                            <tr>
                              <td align="right">(For Payroll) <strong> Month : </strong></td>
                              <td align="left"><span class="oe_form_group_cell">
								  
                                <select name="mon" style="width:160px;" class="form-control" id="mon">
                                  <option></option>
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
								  
                                </span>
								</td>
								
                              <td align="right" >&nbsp;</td>
                              <td align="right" >(For Payroll)<strong> Year : </strong></td>
                              <td >
								  <select name="year" style="width:160px;" class="form-control" id="year" required="required">
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
								  
							  </td>
                            </tr>
						
						
		
						
                            <tr>
                              <td align="right" style="background-color:#3d6485; color:#FFFFFF; font-size:16px;"><strong> Start Date : </strong></td>
                              <td align="left" style="background-color:#3d6485; font-size:16px;padding-top:4px"><input type="date" style="width:160px;" id="fdate" name="fdate" class="form-control" placeholder="Start Date" value="<?=date('Y-m-01')?>" /></td>
                              <td align="right" style="background-color:#3d6485; font-size:16px;padding-top:4px">&nbsp;</td>
                              <td align="right" style="background-color:#3d6485; color:#FFFFFF; font-size:16px; "><strong> End Date : </strong></td>
                              <td style="background-color:#3d6485; font-size:16px;padding-top:4px"><input type="date" id="tdate" style="width:160px;" name="tdate" class="form-control" placeholder=" End Date" value="<?=date('Y-m-d')?>" /></td>
                            </tr>
                          </tbody>
                        </table>
                        <div style="text-align:center">
                          <table width="100%" class="table table-bordered table-sm">
                            <thead>
                              <tr class="">
                                   <h4 class="text-center bg-titel bold pt-2 pb-2" style=" display: flex; ">
     <div style=" margin-right: 266px; margin-left: 142px; ">
	  Daily report
	  </div>
	   <div style=" margin-right: 293px; ">
	  Monthly report
	  </div>
	   <div>
	  Yearly report
	  </div>
    </h4>
                              </tr>
                            </thead>
                            <tfoot>
                            </tfoot>
                            <tbody align="left">
                              <tr>
							  	<td align="center"><input name="report" type="radio" class="radio" value="121225" /></td>
                                <td align="left"><strong> Daily Present Report </strong></td>
								
								
							    <td align="center"><input name="report" type="radio" class="radio" value="9193"></td>
								<td align="left"><strong>Time Card</strong></td>
								
								
									<td align="center"><input name="report" type="radio" class="radio" value="611111" /></td>
                                <td align="left"><strong>Full Leave Report Details</strong></td>
                                
                                
                                
								 </tr>
                              
                              
                                     
                              <tr>
							     <td align="center"><input name="report" type="radio" class="radio" value="121224" /></td>
                                <td align="left"><strong>Daily Absent Report</strong></td>
							
                                
                                 <td align="center"><input name="report" type="radio" class="radio" value="81" /></td>
                                <td align="left"><strong>Attendance Summary</strong></td>
							  
                               	<td></td>

                                <td ></td>
								
								
								
								
                              </tr>
                              
                              
                             <tr>
							    
								<td align="center"><input name="report" type="radio" class="radio" value="121223" /></td>
                                <td align="left"><strong> Daily Invalid Report </strong></td>
                                
                                	<td align="center"><input name="report" type="radio" class="radio" value="992" /></td>
                                <td align="left"><strong>Early Report</strong></td>
							  
                               
								
									
								
								
                              </tr>
                              
                              
                              
                              <tr>
							    <td align="center"><input name="report" type="radio" class="radio" value="1000" /></td>
                                <td align="left"><strong>Daily Attendance summary</strong></td>
								
								
								<td align="center"><input name="report" type="radio" class="radio" value="20220522" /></td>
                                <td align="left"><strong>Monthly Attendence Sheet</strong></td>
                                
                                	
							  	<td></td>
                                <td ></td>
                               
								
								
								
								
                              </tr>
                              
                              
                              
                              <tr>
							  
							   <td align="center"><input name="report" type="radio" class="radio" value="121235" /></td>
                                <td align="left"><strong>Daily OT Report</strong></td>
                              
                          
                              <td align="center"><input name="report" type="radio" class="radio" value="20220519" /></td>
                                <td align="left"><strong> Amendment Report</strong></td>
                              
							  	<td></td>
                                <td ></td>
								
								
                            <!--    <td align="center"><input name="report" type="radio" class="radio" value="20220524" /></td>
                                <td align="left"><strong>Roster Wise Attendance Summary</strong></td>-->
								
							
                              </tr>
                             
                              
                              <tr>
							  
							    	<td><input name="report" type="radio" class="radio" value="96321" /></td>
                                <td align="left">Daily In Late Report</td>
								
								
                                <td align="center"><input name="report" type="radio" class="radio" value="991" /></td>
                                <td align="left"><strong>Late Report</strong></td>
                                
							
                               	  <td></td>
                                <td ></td>
                             
							
                              </tr>
							  
                              
                              
                              
                              
                               <tr>
                               
                                <td align="center"><input name="report" type="radio" class="radio" value="98741" /></td>
                                <td align="left"><strong>Daily Early Out Report</strong></td>
							
                              <td align="center"><input name="report" type="radio" class="radio" value="9196" /></td>
                            <td align="left"><strong>Tiffin Bill</strong></td>
                                 <td></td>
                                <td ></td>
                    	
							
                              </tr>
                              
                              
                            <tr>
                                 <td><input name="report" type="radio" class="radio" value="999" /></td>
                                <td align="left">Daily Attendance Log Shift Report</td>
							
                              <td align="center"><input name="report" type="radio" class="radio" value="9197" /></td>
                            <td align="left"><strong>Dinner Bill</strong></td>
                               
                       	  <td></td>
                                <td ></td>
							
                              </tr>
                                
                            <tr>
                                 <td></td>
                                <td ></td>
                                
							
                              <td align="center"><input name="report" type="radio" class="radio" value="9632" /></td>
                            <td align="left"><strong>Weekend Allowance Report</strong></td> 
                               
                                <td></td>
                                <td ></td>	
							
                              </tr>
							    <tr>
                                 <td></td>
                                <td ></td>
                                
							
                                     <td align="center"><input name="report" type="radio" class="radio" value="9654" /></td>
                            <td align="left"><strong>Holiday allowance Report</strong></td> 
                               
                                <td></td>
                                <td ></td>	
							
                              </tr>
                              
                                <tr>
                                 <td></td>
                                <td ></td>
                                
							
                                      <td align="center"><input name="report" type="radio" class="radio" value="9198" /></td>
                            <td align="left"><strong>Mobile Bill Report</strong></td>
                               
                                <td></td>
                                <td ></td>	
							
                              </tr>
                              
                               </tr>
                              
                                <tr>
                                 <td></td>
                                <td ></td>
                                
							
                                      <td align="center"><input name="report" type="radio" class="radio" value="1011" /></td>
                            <td align="left"><strong>Appointment  Report</strong></td>
                               
                                <td></td>
                                <td ></td>	
							
                              </tr>
                              
                               </tr>
                              
                                <tr>
                                 <td></td>
                                <td ></td>
                                
							
                                      <td align="center"><input name="report" type="radio" class="radio" value="1012" /></td>
                            <td align="left"><strong>Lefty  Report</strong></td>
                               
                                <td></td>
                                <td ></td>	
							
                              </tr>
                                
                            <!--<tr>-->
                            <!--     <td></td>-->
                            <!--    <td ></td>-->
                                
							
                            <!--  <td align="center"><input name="report" type="radio" class="radio" value="9199" /></td>-->
                            <!--<td align="left"><strong>Mobile Bill Summary Report</strong></td>-->
                               
                            <!--    <td></td>-->
                            <!--    <td ></td>	-->
							
                            <!--  </tr>-->
                              
                             <!--  <tr>-->
                               
                             <!--   <td align="center"><input name="report" type="radio" class="radio" value="98742" /></td>-->
                             <!--   <td align="left"><strong>Daily Leave Report</strong></td>-->
							
                             <!--<td></td>-->
                             <!--   <td ></td>-->
                               
                             <!--   <td></td>-->
                             <!--   <td ></td>	-->
							
                             <!-- </tr>-->
                              
                              <!--<tr>
                                <td align="center"><input name="report" type="radio" class="radio" value="62222" /></td>
                                <td align="left"><strong>Half Leave Report Details</strong></td>
								<td align="center"><input name="report" type="radio" class="radio" value="61" /></td>
                                <td align="left"><strong>Leave Report Summary(Yearly)</strong></td>
                              </tr>-->
                              
                               	<!--<tr>
                                <td align="center"><input name="report" type="radio" class="radio" value="995" /></td>
                                <td align="left"><strong>Leave Report Summary (Monthly)</strong></td>
							    <td align="center"><input name="report" type="radio" class="radio" value="61" /></td>
                                <td align="left"><strong>Leave Report Summary(Yearly)</strong></td>
                              </tr>-->
							  


									
									
									
	

                              
                              <!--<tr >















      <td align="center" ><input name="report" type="radio" class="radio" value="97" /></td>















      <td ><strong>User Access Info(97)</strong></td>















      <td align="center">&nbsp;</td>















      <td>&nbsp;</td>



    </tr>-->
                              <!--<tr >















      <td align="center" ><input name="report" type="radio" class="radio" value="979" /></td>















      <td ><strong>Vehicle Report(979)</strong></td>















      <td align="center">&nbsp;</td>















      <td>&nbsp;</td>



    </tr>-->
                              <!--<tr>



     <td align="center" ><input name="report" type="radio" class="radio" value="2454" /></td>



     <td><strong>Member Birthday Report (2454)</strong></td>



     <td align="center">&nbsp;</td>



     <td>&nbsp;</td>



    </tr>



	



	<tr>



	  <td align="center" ><input name="report" type="radio" class="radio" value="922" /></td>



	  <td><strong>Provident Fund Report(922)</strong></td>



	  <td align="center">&nbsp;</td>



	  <td>&nbsp;</td>



	  </tr>



	<tr>



     <td align="center" ><input name="report" type="radio" class="radio" value="6655" /></td>



     <td><strong>Member PF Report (6655)</strong></td>



     <td align="center">&nbsp;</td>



     <td>&nbsp;</td>



    </tr>-->
                            </tbody>
                          </table>
                          <input name="submit" type="submit" id="submit" value="&emsp;SHOW&emsp;" class="btn btn-danger" style="
    margin-bottom: 12px;
"/>
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
    </div>
  </div>
</form>


<?




require_once SERVER_CORE."routing/layout.bottom.php";







?>
