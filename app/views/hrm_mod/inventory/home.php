<?php



//====================== EOF ===================




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = "Human Resource Management Dashboard";

 $today = date('Y-m-d');

 $lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));

?>





<!DOCTYPE html>

<html lang="en">



<!-- Mirrored from designreset.com/cork/ltr/demo3/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 05 Mar 2020 08:10:15 GMT -->

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <title>  </title>

   <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

  <!--     Fonts and icons     -->

  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

  <!-- CSS Files -->

  <link href="../../../dashboard_assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />

</head>







<div class="content">

        <div class="container-fluid">







          <div class="row">





            <div class="col-lg-3 col-md-6 col-sm-6">



              <div class="card card-stats" style="border: 1px solid green;">



                <div class="card-header card-header-success card-header-icon">



                  <div class="card-icon p-0">

                    <i class="fas fa-user-check"></i>



                  </div>



                  <p class="card-category">  LifeTime </p>



                  <h3 class="card-title font-siz">

                    <span id="activeEmployee">Checking..</span>

                  </h3>



                </div>



                <div class="card-footer" style="border-top:1px solid green">



                  <div class="stats m-0"><h5 class="m-0 font-weight-bold">Active Employee</h5></div>



                </div>

              </div>

            </div>



            <div class="col-lg-3 col-md-6 col-sm-6">



              <div class="card card-stats" style="border: 1px solid #a217d9;">



                <div class="card-header card-header-primary card-header-icon">



                  <div class="card-icon p-0">

                    <i class="fas fa-users"></i>





                  </div>



                  <p class="card-category"> LifeTime </p>



                  <h3 class="card-title font-siz">

                    <span id="deactiveEmployee">Checking..</span>



                  </h3>



                </div>



                <div class="card-footer" style="border-top:1px solid #a217d9">



                  <div class="stats m-0">

                    <h5 class="m-0 font-weight-bold">Inactive Employee</h5>

                  </div>

                </div>

              </div>

            </div>



            <div class="col-lg-3 col-md-6 col-sm-6">



              <div class="card card-stats" style="border: 1px solid #1ec1d5;">



                <div class="card-header card-header-info card-header-icon">



                  <div class="card-icon p-0">



                    <i class="fas fa-clipboard-list"></i>



                  </div>



                  <p class="card-category">Last 30 Days </p>



                  <h3 class="card-title font-siz">

                    <span id="leave7days">Checking..</span>



                  </h3>



                </div>



                <div class="card-footer" style="border-top:1px solid #1ec1d5">



                  <div class="stats m-0">

                    <h5 class="m-0 font-weight-bold"> TOTAL LEAVE REQUEST</h5>



                  </div>

                </div>

              </div>

            </div>



            <div class="col-lg-3 col-md-6 col-sm-6">



              <div class="card card-stats" style="border: 1px solid orange;">



                <div class="card-header card-header-warning card-header-icon">



                  <div class="card-icon p-0">

                    <i class="fas fa-chart-line"></i>





                  </div>



                  <p class="card-category"> <span id="nextHolidayDate">Checking..</span> </p>



                  <h3 class="card-title" style="font-size: 23px">

                    <span id="nextHoliday">Checking..</span>

                  </h3>



                </div>



                <div class="card-footer" style="border-top:1px solid orange">



                  <div class="stats m-0">

                    <h5 class="m-0 font-weight-bold">NEXT HOLIDAY</h5>



                  </div>



                </div>



              </div>



            </div>





          </div>







          <div class="row">



            <div class="col-lg-4 col-sm-4 col-md-4">



              <div class="container">

                <!--3rd One yeare report chart-->

                <div class="card card-chart">

                  <div class="card-body">

                    <h4 class="card-title">TODAY ATTENDANCE REPORT </h4>

                  </div>

                  <div class="card-header">

                    <div id="reportPage">

                      <canvas id="oilChart"></canvas>

                    </div>

                  </div>

                </div>

              </div>



              <div class="container">



                <!--4rdyeare report chart-->

                <div class="card card-chart">

                  <div class="card-body">

                    <h4 class="card-title">LAST 3 YEAR SALARY REPORTS </h4>

                  </div>

                  <div class="card-header">

                    <div id="reportPage">

                      <canvas id="oneweek"></canvas>

                    </div>

                  </div>

                </div>

              </div>



            </div>



            <div class="col-lg-8 col-sm-8 col-md-8">

              <div class="row">







                <div class="col-lg-6 col-md-6 col-sm-6">



                  <div class="card card-stats">



                    <div class="card-header card-header-danger card-header-icon">



                      <div class="card-icon p-0">



                        <i class="fas fa-chart-line"></i>



                      </div>



                      <p class="card-category"  style="color:#F00712; font-weight:bold;">TODAY ABSENT </p>



<h3 class="card-title">

<form method="post" id="jsform" onClick="onsmit()" action="../attendence/att_master_report.php" target="_blank">
<input type="hidden" name="report" value="210907002">
<input type="hidden" name="JOB_STATUS" value="In Service">
<span  id="todayAbsent">Checking..</span>
<input type="hidden" name="t_date" value="<?=date("Y-m-d")?>">

</form>

</h3>



                    </div>



                    <div class="card-footer">



                      <div class="stats">



                        <i class="material-icons">update</i>  Today



                      </div>



                    </div>



                  </div>



                </div>



                <div class="col-lg-6 col-md-6 col-sm-6">



                  <div class="card card-stats">



                    <div class="card-header card-header-success card-header-icon">



                      <div class="card-icon p-0">



                        <i class="fas fa-chart-line"></i>



                      </div>



                      <p class="card-category" style="color:#0CBB37; font-weight:bold;">TODAY PRESENT</p>



                      <h3 class="card-title">
					  
					  <form method="post" id="jsformc" onClick="onsmitc()" action="../attendence/att_master_report.php" target="_blank">
						<input type="hidden" name="report" value="210907001">
						<input type="hidden" name="JOB_STATUS" value="In Service">
						 <span id="todayPresent">Checking..</span></h3>
						<input type="hidden" name="t_date" value="<?=date("Y-m-d")?>">
						
						</form>
					  
					  
					 



                    </div>



                    <div class="card-footer">



                      <div class="stats">



                        <i class="material-icons">date_range</i> Today



                      </div>



                    </div>



                  </div>



                </div>



                <div class="col-lg-6 col-md-6 col-sm-6">

                  <div class="card card-stats">

                    <div class="card-header card-header-primary card-header-icon">

                      <div class="card-icon p-0">

                        <i class="fas fa-calendar-check"></i>

                      </div>

                      <p class="card-category"  style="color:#BA04F9; font-weight:bold;">LEAVE REQUEST APPROVED </p>

                      <h3 class="card-title">

                        <span id="leaveApprove7days">Checking..</span>



                      </h3>



                    </div>



                    <div class="card-footer">



                      <div class="stats">



                        <i class="material-icons">date_range</i> Last 7 Days



                      </div>

                    </div>

                  </div>

                </div>



                <div class="col-lg-6 col-md-6 col-sm-6">



                  <div class="card card-stats">



                    <div class="card-header card-header-warning card-header-icon">



                      <div class="card-icon p-0">

                        <i class="fas fa-clipboard-list"></i>





                      </div>



                      <p class="card-category" style="color:#F5DB01; font-weight:bold;">LEAVE REQUEST PENDING </p>



                      <h3 class="card-title">  <span id="leavePending7days">Checking..</span>





                      </h3>



                    </div>



                    <div class="card-footer">



                      <div class="stats">



                        <i class="material-icons">update</i>  Last 7 Days



                      </div>



                    </div>



                  </div>



                </div>





                <div class="col-lg-6 col-md-6 col-sm-6">

                  <div class="card card-stats">

                    <div class="card-header card-header-info card-header-icon">

                      <div class="card-icon p-0">

                        <i class="fas fa-male"></i>

                      </div>

                      <p class="card-category"  style="color:#1ec1d5; font-weight:bold;">TOTAL MALE EMPLOYEE </p>

                      <h3 class="card-title">
					  
					  
					    <form method="post" id="jsformm" onClick="onsmitm()" action="../report/master_report.php" target="_blank">
						<input type="hidden" name="report" value="1">
						<input type="hidden" name="PBI_SEX" value="Male">
						 <span id="totalMale">Checking..</span>
						
						</form>

                         



                      </h3>



                    </div>



                    <div class="card-footer">



                      <div class="stats">



                        <i class="material-icons">date_range</i> In Office



                      </div>

                    </div>

                  </div>

                </div>



                <div class="col-lg-6 col-md-6 col-sm-6">



                  <div class="card card-stats">



                    <div class="card-header card-header-success card-header-icon">



                      <div class="card-icon p-0">



                        <i class="fas fa-female"></i>



                      </div>



                      <p class="card-category" style="color:#0CBB37; font-weight:bold;">TOTAL FEMALE EMPLOYEE </p>



                      <h3 class="card-title">  <span id="totalFemale">Checking..</span>





                      </h3>



                    </div>
					
					
					
					



                    <div class="card-footer">



                      <div class="stats">



                        <i class="material-icons">update</i>  In Office



                      </div>



                    </div>



                  </div>



                </div>



<div class="col-lg-12 col-md-12">
<div class="card card-chart" style="height: 290px; background-color: #FFFFFF;">
<h4 class="text-center bg-warning bold pt-2 pb-2">  Notice Board </h4>

<div class="card-header">
<h6 class="bold m-0 p-0"><span id="notice_title">Notice Titel</span></h6>
<p><span id="notice_description">Notice Text</span></p>
</div></div></div>
</div></div>
</div>













          <div class="row">





            <!--1st One Week Purchase report chart-->

            <div class="col-lg-6 col-md-12">

              <div class="card card-chart">

                <div class="card-body">

                  <h4 class="card-title">LAST WEEK ATTENDANCE REPORT </h4>

                  <!--				 	<p class="card-category"><span class="text-success"><i class="fa fa-long-arrow-up"></i> 15% </span> increase. </p>-->

                </div>



                <div class="card-header">

                  <canvas id="chart_0"></canvas>

                </div>



              </div>

            </div>



            <!--Last 5Client Inforamation Tabel -->

            <div class="col-lg-6 col-md-12">

              <div class="card card-chart">

                <div class="card-body table-responsive">

                  <h4 class="card-title text-center font-weight-bold">New 5 Employee Info</h4>

                  <p class="card-category text-center">Just Updated</p>



                  <div id="last5Employee" class="table table-hover table-striped">Checking..</div>

                </div>

              </div>



            </div>









          </div>





























          <!--		  old code-->

<?php /*?>          <div class="row">

            <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats">

                <div class="card-header card-header-warning card-header-icon">

                  <div class="card-icon">

                    <i class="fas fa-users"></i>

                  </div>

                  <p class="card-category" id="dem">Total Active Employee</p>

				  

		  <small class="text-muted"

          <p style="color:#EC8E22;">Total Employee: <?=find_a_field('personnel_basic_info','count(PBI_ID)','1');?> </p>

          </small>

		  

		  <small class="text-muted">

          <p style="color:#EC8E22;">Active Employee: <?=find_a_field('personnel_basic_info','count(PBI_ID)','PBI_JOB_STATUS="In Service"');?> </p>

          </small>

		  

		  <small class="text-muted">

          <p style="color:#EC8E22;">Inactive  Employee: <?=find_a_field('personnel_basic_info','count(PBI_ID)','PBI_JOB_STATUS="Not In Service" and PBI_SEX="Male"');?> </p>

          </small>

		  

		  

                  <h3 class="card-title"><?=find_a_field('personnel_basic_info','count(PBI_ID)','PBI_JOB_STATUS="In Service"');?>

                    <small></small>

                  </h3>

                </div>

				

				

				

			

				

				

				

				<div class="card-footer">

                  <div class="stats">

                    <i class="material-icons">update</i> Male : <?=find_a_field('personnel_basic_info','count(PBI_ID)','PBI_JOB_STATUS="In Service" and PBI_SEX="Male"');?>

                  </div>

              

                  <div class="stats">

                    <i class="material-icons">update</i> Female : <?=find_a_field('personnel_basic_info','count(PBI_ID)','PBI_JOB_STATUS="In Service" and PBI_SEX="Female"');?>

                  </div>

                </div>

				

             

				

				

				

				

              </div>

            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats">

                <div class="card-header card-header-success card-header-icon">

                  <div class="card-icon">

                    <i class="fas fa-briefcase"></i>

                  </div>

                  <p class="card-category">Attendene</p>

				  <?php

                   $todaysdate = date('Y-m-d');

				   $attendt  = find_a_field('hrm_attdump','count(distinct xenrollid)','xdate = "'.$todaysdate.'" ');

				   $totalemp =find_a_field('personnel_basic_info','count(PBI_ID)','PBI_JOB_STATUS="In Service"');

				   $absentTOTAL = $totalemp - $attendt ;

                   ?>

                  <h3 class="card-title"><?=find_a_field('hrm_attdump','count(distinct xenrollid)','xdate = "'.$todaysdate.'" ');?></h3>

                </div>

                <div class="card-footer">

                  <div class="stats">

                    <i class="material-icons">date_range</i>In Office

                  </div>

				  

				  <div class="stats">

                    <i class="material-icons">date_range</i> Absent <? echo $absentTOTAL ?>

                  </div>

				  

                </div>

              </div>

            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats">

                <div class="card-header card-header-danger card-header-icon">

                  <div class="card-icon">

                    <i class="fas fa-plane"></i>

                  </div>

                  <p class="card-category">Total Leave Request</p>

                  <h3 class="card-title"><?=find_a_field('hrm_leave_info','count(id)','1');?></h3>

                </div>

                <div class="card-footer">

                  <div class="stats">

                    <i class="material-icons">local_offer</i>Pending <?=find_a_field('hrm_leave_info','count(id)','leave_status="Unchecked"');?>

                  </div>

				  

				  <div class="stats">

                    <i class="material-icons">local_offer</i> Approved <?=find_a_field('hrm_leave_info','count(id)','leave_status="Checked"');?>

                  </div>

				  

                </div>

              </div>

            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats">

                <div class="card-header card-header-info card-header-icon">

                  <div class="card-icon">

                    <i class="fas fa-car"></i>

                  </div>

                  <p class="card-category">Next Holiday</p>

                  <h3 class="card-title">Eid Festival</h3>

                </div>

                <div class="card-footer">

                  <div class="stats">

                    <i class="material-icons">update</i> Oct 26

                  </div>

                </div>

              </div>

            </div>

          </div><?php */?>

		  

		  

          <?php /*?><div class="row">

            <div class="col-md-4">

              <div class="card card-chart">

                <div class="card-header card-header-success">

                  <div class="ct-chart" id="dailySalesChart"></div>

                </div>

                <div class="card-body">

                  <h4 class="card-title">Total Employee In a week</h4>

                  <p class="card-category">

                    <span class="text-success"><i class="fa fa-long-arrow-up"></i> 10% </span> increase.</p>

                </div>

                <div class="card-footer">

                  <div class="stats">

                    <i class="material-icons">access_time</i> Last Month

                  </div>

                </div>

              </div>

            </div>

            <div class="col-md-4">

              <div class="card card-chart">

                <div class="card-header card-header-warning">

                  <div class="ct-chart" id="websiteViewsChart"></div>

                </div>

                <div class="card-body">

                  <h4 class="card-title">Total Salary in a year</h4>

                 <p class="card-category">

                    <span class="text-success"><i class="fa fa-long-arrow-up"></i> 15% </span> increase</p>

                </div>

                <div class="card-footer">

                  <div class="stats">

                    <i class="material-icons">access_time</i> Last Month

                  </div>

                </div>

              </div>

            </div>

            <div class="col-md-4">

              <div class="card card-chart">

                <div class="card-header card-header-danger">

                  <div class="ct-chart" id="completedTasksChart"></div>

                </div>

                <div class="card-body">

                  <h4 class="card-title">Total Attendene </h4>

                  <p class="card-category">

                    <span class="text-success"><i class="fa fa-long-arrow-up"></i> 15% </span> Increase</p>

                </div>

                <div class="card-footer">

                  <div class="stats">

                    <i class="material-icons">access_time</i> Last 7 Days

                  </div>

                </div>

              </div>

            </div>

          </div><?php */?>

		  

          <?php /*?><div class="row">

            <div class="col-lg-6 col-md-12">

              <div class="card">

                <div class="card-header card-header-tabs card-header-primary">

                  <div class="nav-tabs-navigation">

                    <div class="nav-tabs-wrapper">

                      <span class="nav-tabs-title">Last 5 Leave Task:</span>

                      <ul class="nav nav-tabs" data-tabs="tabs">

                        <li class="nav-item">

                          <a class="nav-link active" href="#profile" data-toggle="tab">

                            <i class="material-icons">bug_report</i> Completed

                            <div class="ripple-container"></div>

                          </a>

                        </li>

                        <li class="nav-item">

                          <a class="nav-link" href="#messages" data-toggle="tab">

                            <i class="material-icons">code</i> Pending

                            <div class="ripple-container"></div>

                          </a>

                        </li>

                        <li class="nav-item">

                          <a class="nav-link" href="#settings" data-toggle="tab">

                            <i class="material-icons">cloud</i> Processing

                            <div class="ripple-container"></div>

                          </a>

                        </li>

                      </ul>

                    </div>

                  </div>

                </div>

                <div class="card-body">

                  <div class="tab-content">

                    <div class="tab-pane active" id="profile">

                      <table class="table">

                        <tbody>

                          <tr>

                            <td>

                              <div class="form-check">

                                <label class="form-check-label">

                                  <input class="form-check-input" type="checkbox" value="" checked>

                                  <span class="form-check-sign">

                                    <span class="check"></span>

                                  </span>

                                </label>

                              </div>

                            </td>

                            <td>Sign contract for "What are conference organizers afraid of?"</td>

                            <td class="td-actions text-right">

                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">

                                <i class="material-icons">edit</i>

                              </button>

                             

                            </td>

                          </tr>

                          <tr>

                            <td>

                              <div class="form-check">

                                <label class="form-check-label">

                                  <input class="form-check-input" type="checkbox" value="">

                                  <span class="form-check-sign">

                                    <span class="check"></span>

                                  </span>

                                </label>

                              </div>

                            </td>

                            <td>Lines From Great Russian Literature? Or E-mails From My Boss?</td>

                            <td class="td-actions text-right">

                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">

                                <i class="material-icons">edit</i>

                              </button>

                           

                            </td>

                          </tr>

                          <tr>

                            <td>

                              <div class="form-check">

                                <label class="form-check-label">

                                  <input class="form-check-input" type="checkbox" value="">

                                  <span class="form-check-sign">

                                    <span class="check"></span>

                                  </span>

                                </label>

                              </div>

                            </td>

                            <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit

                            </td>

                            <td class="td-actions text-right">

                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">

                                <i class="material-icons">edit</i>

                              </button>

                             

                            </td>

                          </tr>

                          <tr>

                            <td>

                              <div class="form-check">

                                <label class="form-check-label">

                                  <input class="form-check-input" type="checkbox" value="" checked>

                                  <span class="form-check-sign">

                                    <span class="check"></span>

                                  </span>

                                </label>

                              </div>

                            </td>

                            <td>Create 4 Invisible User Experiences you Never Knew About</td>

                            <td class="td-actions text-right">

                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">

                                <i class="material-icons">edit</i>

                              </button>

                             

                            </td>

                          </tr>

                        </tbody>

                      </table>

                    </div>

                    <div class="tab-pane" id="messages">

                      <table class="table">

                        <tbody>

                          <tr>

                            <td>

                              <div class="form-check">

                                <label class="form-check-label">

                                  <input class="form-check-input" type="checkbox" value="" checked>

                                  <span class="form-check-sign">

                                    <span class="check"></span>

                                  </span>

                                </label>

                              </div>

                            </td>

                            <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit

                            </td>

                            <td class="td-actions text-right">

                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">

                                <i class="material-icons">edit</i>

                              </button>

                             

                            </td>

                          </tr>

                          <tr>

                            <td>

                              <div class="form-check">

                                <label class="form-check-label">

                                  <input class="form-check-input" type="checkbox" value="">

                                  <span class="form-check-sign">

                                    <span class="check"></span>

                                  </span>

                                </label>

                              </div>

                            </td>

                            <td>Sign contract for "What are conference organizers afraid of?"</td>

                            <td class="td-actions text-right">

                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">

                                <i class="material-icons">edit</i>

                              </button>

                             

                            </td>

                          </tr>

                        </tbody>

                      </table>

                    </div>

                    <div class="tab-pane" id="settings">

                      <table class="table">

                        <tbody>

                          <tr>

                            <td>

                              <div class="form-check">

                                <label class="form-check-label">

                                  <input class="form-check-input" type="checkbox" value="">

                                  <span class="form-check-sign">

                                    <span class="check"></span>

                                  </span>

                                </label>

                              </div>

                            </td>

                            <td>Lines From Great Russian Literature? Or E-mails From My Boss?</td>

                            <td class="td-actions text-right">

                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">

                                <i class="material-icons">edit</i>

                              </button>

                             

                            </td>

                          </tr>

                          <tr>

                            <td>

                              <div class="form-check">

                                <label class="form-check-label">

                                  <input class="form-check-input" type="checkbox" value="" checked>

                                  <span class="form-check-sign">

                                    <span class="check"></span>

                                  </span>

                                </label>

                              </div>

                            </td>

                            <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit

                            </td>

                            <td class="td-actions text-right">

                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">

                                <i class="material-icons">edit</i>

                              </button>

                            

                            </td>

                          </tr>

                          <tr>

                            <td>

                              <div class="form-check">

                                <label class="form-check-label">

                                  <input class="form-check-input" type="checkbox" value="" checked>

                                  <span class="form-check-sign">

                                    <span class="check"></span>

                                  </span>

                                </label>

                              </div>

                            </td>

                            <td>Sign contract for "What are conference organizers afraid of?"</td>

                            <td class="td-actions text-right">

                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">

                                <i class="material-icons">edit</i>

                              </button>

                             

                            </td>

                          </tr>

                        </tbody>

                      </table>

                    </div>

                  </div>

                </div>

              </div>

            </div>

            <div class="col-lg-6 col-md-12">

              <div class="card">

                <div class="card-header card-header-warning">

                  <h4 class="card-title">New 5 Employee Info</h4>

                  <p class="card-category">Just Updated</p>

                </div>

                <div class="card-body table-responsive">

                  <table class="table table-hover">

                    <thead class="text-warning">

                      <th>Employee ID</th>

                      <th>Name</th>

                      <th>Designation</th>

                      <th>Department</th>

                    </thead>

                    <tbody>

                        <?php

                          $sl = 'select * from personnel_basic_info where 1 order by PBI_ID desc limit 5';

                          $qr = db_query($sl);

                          while($dt=mysqli_fetch_object($qr)){

                        ?>

                      <tr>

                        <td><?=$dt->PBI_ID?></td>

                        <td><?=$dt->PBI_NAME?></td>

                        <td><?=find_a_field('designation','DESG_DESC','DESG_ID="'.$dt->PBI_DESIGNATION.'"')?></td>

                        <td><?=find_a_field('department','DEPT_DESC','DEPT_ID="'.$dt->PBI_DEPARTMENT.'"')?></td>

                      </tr>

                     <? } ?>

                    </tbody>

                  </table>

                </div>

              </div>

            </div>

          </div><?php */?>

        </div>

      </div>

	  

<input type="hidden" id="totalPresent" value="0">

<input type="hidden" id="totalAbsent" value="0">



<input type="hidden" id="cYear" value="">

<input type="hidden" id="oYear" value="">

<input type="hidden" id="ooYear" value="">



<input type="hidden" name="hSat" id="hSat" value="">

<input type="hidden" id="hSun" value="">

<input type="hidden" id="hMon" value="">

<input type="hidden" id="hTue" value="">

<input type="hidden" id="hWed" value="">

<input type="hidden" id="hThu" value="">

<input type="hidden" id="hFri" value="">











  <script>

    $(document).ready(function() {

      $().ready(function() {

        $sidebar = $('.sidebar');



        $sidebar_img_container = $sidebar.find('.sidebar-background');



        $full_page = $('.full-page');



        $sidebar_responsive = $('body > .navbar-collapse');



        window_width = $(window).width();



        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();



        if (window_width > 767 && fixed_plugin_open == 'Dashboard') {

          if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {

            $('.fixed-plugin .dropdown').addClass('open');

          }



        }



        $('.fixed-plugin a').click(function(event) {

          // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active

          if ($(this).hasClass('switch-trigger')) {

            if (event.stopPropagation) {

              event.stopPropagation();

            } else if (window.event) {

              window.event.cancelBubble = true;

            }

          }

        });



        $('.fixed-plugin .active-color span').click(function() {

          $full_page_background = $('.full-page-background');



          $(this).siblings().removeClass('active');

          $(this).addClass('active');



          var new_color = $(this).data('color');



          if ($sidebar.length != 0) {

            $sidebar.attr('data-color', new_color);

          }



          if ($full_page.length != 0) {

            $full_page.attr('filter-color', new_color);

          }



          if ($sidebar_responsive.length != 0) {

            $sidebar_responsive.attr('data-color', new_color);

          }

        });



        $('.fixed-plugin .background-color .badge').click(function() {

          $(this).siblings().removeClass('active');

          $(this).addClass('active');



          var new_color = $(this).data('background-color');



          if ($sidebar.length != 0) {

            $sidebar.attr('data-background-color', new_color);

          }

        });



        $('.fixed-plugin .img-holder').click(function() {

          $full_page_background = $('.full-page-background');



          $(this).parent('li').siblings().removeClass('active');

          $(this).parent('li').addClass('active');





          var new_image = $(this).find("img").attr('src');



          if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {

            $sidebar_img_container.fadeOut('fast', function() {

              $sidebar_img_container.css('background-image', 'url("' + new_image + '")');

              $sidebar_img_container.fadeIn('fast');

            });

          }



          if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {

            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');



            $full_page_background.fadeOut('fast', function() {

              $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');

              $full_page_background.fadeIn('fast');

            });

          }



          if ($('.switch-sidebar-image input:checked').length == 0) {

            var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');

            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');



            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');

            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');

          }



          if ($sidebar_responsive.length != 0) {

            $sidebar_responsive.css('background-image', 'url("' + new_image + '")');

          }

        });



        $('.switch-sidebar-image input').change(function() {

          $full_page_background = $('.full-page-background');



          $input = $(this);



          if ($input.is(':checked')) {

            if ($sidebar_img_container.length != 0) {

              $sidebar_img_container.fadeIn('fast');

              $sidebar.attr('data-image', '#');

            }



            if ($full_page_background.length != 0) {

              $full_page_background.fadeIn('fast');

              $full_page.attr('data-image', '#');

            }



            background_image = true;

          } else {

            if ($sidebar_img_container.length != 0) {

              $sidebar.removeAttr('data-image');

              $sidebar_img_container.fadeOut('fast');

            }



            if ($full_page_background.length != 0) {

              $full_page.removeAttr('data-image', '#');

              $full_page_background.fadeOut('fast');

            }



            background_image = false;

          }

        });



        $('.switch-sidebar-mini input').change(function() {

          $body = $('body');



          $input = $(this);



          if (md.misc.sidebar_mini_active == true) {

            $('body').removeClass('sidebar-mini');

            md.misc.sidebar_mini_active = false;



            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();



          } else {



            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');



            setTimeout(function() {

              $('body').addClass('sidebar-mini');



              md.misc.sidebar_mini_active = true;

            }, 300);

          }



          // we simulate the window Resize so the charts will get updated in realtime.

          var simulateWindowResize = setInterval(function() {

            window.dispatchEvent(new Event('resize'));

          }, 180);



          // we stop the simulation of Window Resize after the animations are completed

          setTimeout(function() {

            clearInterval(simulateWindowResize);

          }, 1000);



        });

      });

    });

  </script>

  <script>

    $(document).ready(function() {

      // Javascript method's body can be found in assets/js/demos.js

      md.initDashboardPageCharts();



    });

  </script>











   

<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>



<script>

document.getElementById("colors").onchange = function(){ 

  document.querySelector('.silverheader').style.background = this.value; 

};

</script>













<!--///////////////////////////////////////////chart start values ////////////////////////////////////////////////////////////////-->

<script type="text/javascript">


function onsmit(){
 document.getElementById('jsform').submit();
}
 
function onsmitc(){
 document.getElementById('jsformc').submit();
}
function onsmitm(){
 document.getElementById('jsformm').submit();
}
function onsmitf(){
 document.getElementById('jsformf').submit();
}

  <!--/////////////1st TODAY ATTENDEES REPORT chart//////////////////-->

  function attChart(){

  var present = document.getElementById('totalPresent').value;

  var absent = document.getElementById('totalAbsent').value;

  var oilCanvas = document.getElementById("oilChart");



  Chart.defaults.global.defaultFontFamily = "Lato";

  Chart.defaults.global.defaultFontSize = 18;



  var oilData = {

    labels: [

      "Present",

      "Absent"

    ],

    datasets: [

      {

        data: [present, absent],

        backgroundColor: [

          "#0CBB37",

          "#F5DB01"



        ]

      }]



  };



  var pieChart = new Chart(oilCanvas, {

    type: 'pie',

    data: oilData

  });

}





  <!--///////////// 2st ONE WEEK PURCHASE REPORTchart//////////////////-->

  function oneWeekChart(){

 var hSat = document.getElementById('hSat').value;

var hSun = document.getElementById('hSun').value;

var hMon = document.getElementById('hMon').value;

var hTue = document.getElementById('hTue').value;

var hWed = document.getElementById('hWed').value;

var hThu = document.getElementById('hThu').value;

var hFri = document.getElementById('hFri').value;

  var data = {

    labels: ["Sat", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri"],

    datasets: [{

      label: "ATTENDANCE",

      backgroundColor: "rgba(255,99,132,0.2)",

      borderColor: "rgba(255,99,132,1)",

      borderWidth: 2,

      hoverBackgroundColor: "rgba(255,99,132,0.4)",

      hoverBorderColor: "rgba(255,99,132,1)",

      data: [hSat, hSun, hMon, hTue, hWed, hThu, hFri],

    }]

  };



  var option = {

    scales: {

      yAxes: [{

        stacked: true,

        gridLines: {

          display: true,

          color: "rgba(255,99,132,0.2)"

        }

      }],

      xAxes: [{

        gridLines: {

          display: false

        }

      }]

    }

  };



  Chart.Bar('chart_0', {

    options: option,

    data: data

  });

}











  <!--/////////////3rd LAST 3 YEAR SALARY REPORTS Bar chart//////////////////-->

  function threeYearSalary(){

  var year = document.getElementById('cYear').value;

  var oyear = document.getElementById('oYear').value;

  var ooyear = document.getElementById('ooYear').value;

  var chartColors = {

    red: 'rgb(255, 99, 132)',

    orange: 'rgb(255, 159, 64)',

    yellow: 'rgb(255, 205, 86)',

    green: 'rgb(75, 192, 192)',

    blue: 'rgb(54, 162, 235)',

    purple: 'rgb(153, 102, 255)',

    grey: 'rgb(231,233,237)'

  };



 



  var data =  {

    labels: ["2022", "2021", "2020"],

    datasets: [{

      label: 'SALARY',

      backgroundColor: [

        chartColors.red,

        chartColors.blue,

        chartColors.yellow],



      data: [

          year,

		  oyear,

		  ooyear

      ]

    }]

  };



  var myBar = new Chart(document.getElementById("oneweek"), {

    type: 'horizontalBar',

    data: data,

    options: {

      responsive: true,

      title: {

        display: false,

        text: "Last One week Sales"

      },

      tooltips: {

        mode: 'index',

        intersect: false

      },

      legend: {

        display: false,

      },

      scales: {

        xAxes: [{

          ticks: {

            beginAtZero: true

          }

        }]

      }

    }

  });

  }

</script>



<script>



function view_data(){

$.ajax({

url:"hrm_dashboard_ajax.php",

method:"POST",

dataType:"JSON",

//data:{ data_no:data_no },hSat, hSun, hMon, hTue, hWed, hThu, hFri

success: function(result, msg){

var res = result;

setTimeout(view_data, 5000);

$("#activeEmployee").html(res[0]);

$("#deactiveEmployee").html(res[1]);

$("#leave7days").html(res[2]);

$("#nextHolidayDate").html(res[3]);

$("#nextHoliday").html(res[4]);



$("#totalAbsent").val(res[5]);

$("#totalPresent").val(res[6]);



$("#todayAbsent").html(res[7]);

$("#todayPresent").html(res[8]);



$("#leaveApprove7days").html(res[9]);

$("#leavePending7days").html(res[10]);



$("#totalMale").html(res[11]);

$("#totalFemale").html(res[12]);



$("#cYear").val(res[13]);

$("#oYear").val(res[14]);

$("#ooYear").val(res[15]);



$("#hSat").val(res[16]);

$("#hSun").val(res[17]);

$("#hMon").val(res[18]);

$("#hTue").val(res[19]);

$("#hWed").val(res[20]);

$("#hThu").val(res[21]);

$("#hFri").val(res[22]);



$("#last5Employee").html(res[23]);

$("#notice_title").html(res[24]);
$("#notice_description").html(res[25]);


}

}); 

}

window.onload = setTimeout(view_data, 3000);

window.onload = setTimeout(attChart, 4000);

window.onload = setTimeout(threeYearSalary, 4000);

window.onload = setTimeout(oneWeekChart, 4000);







</script>