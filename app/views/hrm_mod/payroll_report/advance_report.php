<?php

session_start();

//

require "../../config/inc.all.php";

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

?>

<form action="../report/master_report.php" target="_blank" method="post">
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
                        <table width="100%" border="0" class="oe_list_content">
                          <thead>
                            <tr class="oe_list_header_columns">
                              <th colspan="4"><span style="text-align: center; font-size:18px; color:#09F">Advance Reporting</span></th>
                            </tr>
                            <tr class="oe_list_header_columns">
                              <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
                            </tr>
                          </thead>
                          <tfoot>
                          </tfoot>
                          <tbody>
                            <tr>
                              <td align="right" class="alt"><strong>Company :</strong></td>
                              <td align="left" class="alt"><span class="oe_form_group_cell">
                                <select name="PBI_ORG" style="width:160px;" id="PBI_ORG">
                                  <? //foreign_relation('user_group','id','group_name',$PBI_ORG);?>
								  <option selected value="2">Aksid Corporation Limited</option>
                                </select>
                                </span></td>
                              <td width="40%" align="right" class="alt"><strong>Department :</strong></td>
                              <td width="10%"><span class="oe_form_group_cell">
                                <select name="department" style="width:160px;" id="department">
                                  <? foreign_relation('department','DEPT_ID','DEPT_DESC',$PBI_DEPARTMENT);?>
                                </select>
                                </span></td>
                            </tr>
                            <tr  class="alt">
                              <td align="right"><strong>Designation :</strong></td>
                              <td align="left"><span class="oe_form_group_cell">
                                <select name="designation" style="width:160px;" id="designation">
                                  <? foreign_relation('designation','DESG_SHORT_NAME','DESG_DESC',$PBI_DESIGNATION,' order by DESG_DESC');?>
                                </select>
                                </span></td>
                              <td align="right"><strong>Job Location:</strong></td>
                              <td><span class="oe_form_group_cell">
                                <select name="JOB_LOCATION" id="JOB_LOCATION" style="width:160px;">
                                  <? foreign_relation('project','PROJECT_ID','PROJECT_DESC',$_POST['JOB_LOCATION'],'1');?>
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
                              <td align="right"><span class="alt"><strong>Bonus Type  : </strong></span></td>
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
                              <td align="right" bgcolor="#FF99FF">(For Payroll) Month  :</td>
                              <td align="left" bgcolor="#FF99FF"><span class="oe_form_group_cell">
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
                              <td align="right" bgcolor="#FF99FF">(For Payroll) Year  :</td>
                              <td bgcolor="#FF99FF"><select name="year" style="width:160px;" id="year" required="required">
                                  <option <?=($year=='2013')?'selected':''?>>2013</option>
                                  <option <?=($year=='2014')?'selected':''?>>2014</option>
                                  <option <?=($year=='2015')?'selected':''?>>2015</option>
                                  <option <?=($year=='2016')?'selected':''?>>2016</option>
                                  <option <?=($year=='2017')?'selected':''?>>2017</option>
                                  <option <?=($year=='2018')?'selected':''?>>2018</option>
                                  <option <?=($year=='2019')?'selected':''?>>2019</option>
                                  <option <?=($year=='2020')?'selected':''?>>2020</option>
                                  <option <?=($year=='2021')?'selected':''?>>2021</option>
                                </select></td>
                            </tr>
                          </tbody>
                        </table>
                        <br />
                        <div style="text-align:center">
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
                                <td width="4%" align="center"><input name="report" type="radio" class="radio" value="1" checked="checked" /></td>
                                <td width="44%"><strong>Basic </strong> <strong>Information</strong></td>
                                <td width="4%" align="center">&nbsp;</td>
                                <td width="44%">&nbsp;</td>
                              </tr>
                              <!--<tr  class="alt">
                                <td align="center"><input name="report" type="radio" class="radio" value="10001"  /></td>
                                <td><strong>Employee Details Information</strong></td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr  class="alt">
                                <td align="center"><input name="report" type="radio" class="radio" value="8" /></td>
                                <td><strong>Staff Mobile Information(Changable)</strong></td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr  class="alt">
                                <td align="center"><input name="report" type="radio" class="radio" value="7" /></td>
                                <td><strong>Payroll </strong> <strong>Information (New)</strong></td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>-->
                              <tr  class="alt">
                                <td align="center"><input name="report" type="radio" class="radio" value="2" /></td>
                                <td><strong>Salary </strong> <strong>Information</strong></td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr >
                                <td align="center" class="alt"><input name="report" type="radio" class="radio" value="3" /></td>
                                <td class="alt"><strong>Monthly Attendence Report</strong><strong></strong></td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
							   <tr >
                                <td align="center" class="alt"><input name="report" type="radio" class="radio" value="132" /></td>
                                <td class="alt"><strong>Monthly Employee Report</strong><strong></strong></td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
							  <tr >
                                <td align="center" class="alt"><input name="report" type="radio" class="radio" value="1333" /></td>
                                <td class="alt"><strong>Promotion Report</strong><strong></strong></td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
							  <tr >
                                <td align="center" class="alt"><input name="report" type="radio" class="radio" value="1444" /></td>
                                <td class="alt"><strong>Increment Report</strong><strong></strong></td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
							   <tr >
                                <td align="center" class="alt"><input name="report" type="radio" class="radio" value="226655" /></td>
                                <td class="alt"><strong>Leave Report </strong><strong></strong></td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <!--<tr >
                                <td align="center" class="alt"><input name="report" type="radio" class="radio" value="4" /></td>
                                <td class="alt"><strong>Over Time Amount Report</strong><strong></strong></td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr >
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
                              </tr>
                              <tr >
                                <td align="center" class="alt"><input name="report" type="radio" class="radio" value="66" /></td>
                                <td class="alt"><strong>Salary Payroll Report (Final)</strong><strong></strong></td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr >
                                <td align="center" class="alt"><input name="report" type="radio" class="radio" value="77" /></td>
                                <td class="alt"><strong>Salary Payroll Report Final (Field)</strong><strong></strong></td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>-->
                              <tr >
                                <td colspan="2" align="center" class="alt"><strong>Salary Reports</strong></td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr >
                                <td align="center" class="alt"><input name="report" type="radio" class="radio" value="78" /></td>
                                <td class="alt"><strong>Salary Report </strong></td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
							  <tr >
							    <td align="center" class="alt"><input name="report" type="radio" class="radio" value="776" /></td>
							    <td class="alt"><strong>Salary Report (Cash Portion)</strong></td>
							    <td align="center">&nbsp;</td>
							    <td>&nbsp;</td>
						      </tr>
							  <tr >
							    <td align="center" class="alt"><input name="report" type="radio" class="radio" value="788" /></td>
							    <td class="alt"><strong>Salary Advice (Bank Account) </strong></td>
							    <td align="center">&nbsp;</td>
							    <td>&nbsp;</td>
						      </tr>
							  <tr >
							    <td align="center" class="alt"><input name="report" type="radio" class="radio" value="789" /></td>
							    <td class="alt"><strong>Salary Advice (Payroll Card) </strong></td>
							    <td align="center">&nbsp;</td>
							    <td>&nbsp;</td>
						      </tr>
							  <tr>
                            <td align="center" class="alt"><input name="report" type="radio" class="radio" value="9999" /></td>
                                <td class="alt"><strong>Salary Summery Sheet (All</strong>)</td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                                <tr>
                            <td align="center" class="alt"><input name="report" type="radio" class="radio" value="8888" /></td>
                                <td class="alt"><strong>Salary Summery Sheet (Cash Portion)</strong></td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
							  <tr >
                                <td colspan="2" align="center" class="alt"><strong>Festival Bonus Reports </strong></td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr >
                                <td align="center" class="alt"><input name="report" type="radio" class="radio" value="777" /></td>
                                <td class="alt"><strong>Festival Bonus Report</strong></td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
							  <tr >
                                <td align="center" class="alt"><input name="report" type="radio" class="radio" value="780" /></td>
                                <td class="alt"><strong>Festival Bonus (Cash Portion)</strong></td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr >
                                <td align="center" class="alt"><input name="report" type="radio" class="radio" value="778" /></td>
                                <td class="alt"><strong>Festival Bonus Advice (Bank Account)</strong></td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr >
                                <td align="center" class="alt"><input name="report" type="radio" class="radio" value="779" /></td>
                                <td class="alt"><strong>Festival Bonus Advice (Payroll Card)</strong></td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              
							  <tr>
                            <td align="center" class="alt"><input name="report" type="radio" class="radio" value="21212" /></td>
                                <td class="alt"><strong>Bonus Summary Sheet</strong></td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              
                               <tr>
                            <td align="center" class="alt"><input name="report" type="radio" class="radio" value="552" /></td>
                                <td class="alt"><strong>Bonus Summary Sheet (Cash)</strong></td>
                                <td align="center">&nbsp;</td>
                               
                              </tr>
                              
                               
                              <tr>
                                <td colspan="2" align="center" class="alt"><strong>Mobile Billing Report </strong></td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr >
                                <td align="center" class="alt"><input name="report" type="radio" class="radio" value="781" /></td>
                                <td class="alt"><strong>Mobile Bill Report</strong> </td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
							  <tr >
                                <td align="center" class="alt"><input name="report" type="radio" class="radio" value="2244" /></td>
                                <td class="alt"><strong>Mobile Bill Summary Report</strong></td>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              
                              
                            </tbody>
                          </table>
                          <input name="submit" type="submit" id="submit" value="SHOW" />
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

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>
