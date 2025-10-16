<?php




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title = "Customer Relationship Management Dashboard";



$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');



$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"');



/*if($_SESSION['employee_selected']==0 || $_SESSION['employee_selected']==''){



header('location:../../../crm_mod/pages/home/index.php');



}*/



 

 $cur = '&#x9f3;';

 

 

 $table1 = 'crm_project_lead';

 $table2 = 'crm_task_lists';

 $table3 = 'crm_call_schedule';
 
 $table4 = 'crm_campaign_management';

 

//  $crud1 = new crud($table1);

//  $crud2 = new crud($table2);

//  $crud3 = new crud($table3);
 
//  $crud4 = new crud($table4);

 


require "../include/custom.php";

echo '<link rel="stylesheet" href="../include/Style/calendarStyle.css">';



?>



        <?php



            if(in_array($_SESSION['employee_selected'], $superID)){

                $con = "";

            }else{

                $con = " AND assigned_person_id = '".$_SESSION['employee_selected']."' ";

            } 

            

        ?>

        

        

    

  <style>.nav-tabs .nav-link.active, .nav-tabs .nav-link.active:active, .nav-tabs .nav-link.active:focus, .nav-tabs .nav-link.active:visited, .nav-tabs .nav-link.active:hover{border-color: #bfc1f5;}
</style>

  <script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>

  

<div class="container">

  <div class="row" style="margin-bottom:25px">

    <!--<div class="col-md-3 my-dashboard-stat" onclick="location.href='../lead_management/show_all_leads.php';">-->

    <!--  <div class="card my-dashboard-stat-bg bg-light mb-3" style="max-width:9rem;max-height:3rem;">-->
          
    <!--      <span class="stat-name text-center"><?//=$CRMleadName?>(s)</span>-->
          <!--<div class="stat-counter card-header h2 text-center"> <?//=find_a_field($table1, 'count(*)', '1'.$con)?> </div>-->

    <!--  </div>-->

    <!--</div>-->
    
    <!--<div class="col-md-3 my-dashboard-stat" onclick="location.href='../task_management/show_all_tasks.php';">-->

    <!--  <div class="card my-dashboard-stat-bg bg-light mb-3" style="max-width:10rem;max-height:3rem;">-->
          
    <!--      <span class="stat-name text-center"><?//=$CRMtaskName?>(s)</span>-->
          <!--<div class="stat-counter card-header h2 text-center"> <?//=find_a_field($table2, 'count(*)', '1'.$con)?> </div>-->

    <!--  </div>-->

    <!--</div>-->



    <!--<div class="col-md-6">-->
    <!--  <div class="card bg-light mb-3" style="max-width: 120rem;">-->
    <!--    <div class="card-header h2"> // find_a_field($table3, 'count(*)', '1'.$con) </div>-->
    <!--    <a href="#" data-toggle="modal" data-target=".call-modal-lg" >-->
    <!--        <i class="fa fa-plus-circle fa-2x" style="position:absolute;right:15px;top:12px;z-index:5;" aria-hidden="true"></i>-->
    <!--      </a>-->
	
    <!--    <div class="card-body" >-->
    <!--      <h5 class="card-title text-danger"> //$CRMscheduleName?> </h5>-->
    <!--      <p class="card-text text-muted">Meet your //$CRMscheduleName?> in time</p>-->
    <!--    </div>-->
    <!--    <div class="card-footer" style="border-top:1px solid tomato">-->
    <!--    <div class="form-group text-end">-->
    <!--      <a href="../call_schedules/show_call_schedules.php" class="btn btn-sm">Show All</a>-->
    <!--    </div>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</div>-->

    

    

    <!-- Call and Meeting Module Modal Start Here -->

    <div class="modal fade call-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

    <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLongTitle">Make a <?=$CRMscheduleName?> </h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <form method="post">

      <div class="modal-body">

      <h5 class=text-center>Call Information</h5>

        <div class="row">

            <div class="col-sm-6">

              <table class="table">

                <tbody>

                  <tr>

                    <td>Call To</td>

                    <td>

                      <select name="project_id" id="project_id" class="form-control" style="border-left:3.5px solid #df5b5b!important;" required>

                        <option value=""></option>

                        <?php foreign_relation('crm_project_lead','id','contact_person_name',$project_id,'1') ?>

                      </select>

                    </td>

                  </tr>

                  <tr>

                    <td>Call type </td>

                    <td>

                      <select name="call_type_id" id="call_type_id" class="form-control">

                        <option value="1">Outbound</option>

                        <option value="2">Inbound</option>

                        <option value="3">Missed</option>

                      </select>

                    </td>

                  </tr>

                </tbody>

              </table>

            </div>

            <div class="col-sm-6">

              <table class="table">

                <tbody>

                  <tr>

                    <td>Purpose</td>

                    <td>

                      <select name="purpose_id" id="purpose_id" class="form-control">

                      <option value=""></option>  

                      <?php foreign_relation('crm_task_purpose','id','purpose',$purpose_id,'1') ?>

                      </select>

                    </td>

                  </tr>

                  <tr>

                      <td>Call Result</td>

                      <td>

                        <select name="result_id" id="result_id" class="form-control">

                          <option value="">-None-</option>

                          <option value="1" selected>Interested</option>

                          <option value="2">Not Interested</option>

                          <option value="3">No Response</option>

                        </select>

                      </td>

                  </tr>

                  

                </tbody>

              </table>

            </div>

            <div class="col-md-12">

              <table class="table">

                <tbody>

                  <tr>

                    <td style="width:20%;">Call Start Time</td>

                    <td>

                    <div class="input-group">

                        <input type="datetime-local" min="<?=$today?>" name="call_start_time" class="form-control" />

                       

                      </div>

                    </td>

                  </tr>

                  <tr>

                    <td style="width:20%;">Call Duration</td>

                    <td>

                      <div class="input-group">

                        <input type="text" name="call_duration_min" class="form-control" aria-label="Username"/>

                        <input type="text" class="form-control" value="Minutes" style="text-align:center!important;" readonly/>

                        <input type="text" name="call_duration_sec" class="form-control" class="form-control" aria-label="Username"/>

                        <input type="text" class="form-control" value="Seconds" style="text-align:center!important;" readonly/>

                      </div>

                    </td>

                  </tr>

                  <tr>

                    <td style="width:20%">Subject</td>

                    <td>

                      <input type="text" name="subject" id="subject" class="form-contol">

                    </td>

                  </tr>

                </tbody>

              </table>

            </div>

        </div>

      </div> 

      <div class="row">

          <div class="form-group pt-3 m-0 m-auto">

            <label for="message text-center">Description Information</label>

            <textarea name="description" class="form-control" cols="40" rows="4"></textarea>

          </div>

        </div>     

      <div class="modal-footer">

        <a type="button" class="btn btn-secondary text-light" data-dismiss="modal">Close</a>

        <button type="submit" class="btn btn-primary" name="insert_call_log">Save</button>

      </div>

      

      </form>

      

    </div>

  </div>

</div>

    <!-- Call and Meeting Module Modal End Here -->
    <!--<div class="col-md-6">-->
    <!--  <div class="card bg-light mb-3" style="max-width: 120rem;">-->
    <!--    <div class="card-header h2">//find_a_field($table4, 'count(*)', '1'.$con)</div>-->
    <!--    <a href="#" data-toggle="modal" data-target=".campaign-modal-lg">-->
    <!--        <i class="fa fa-plus-circle fa-2x" style="position:absolute;right:15px;top:12px;z-index:5;"></i>-->
    <!--      </a>-->
    <!--    <div class="card-body" >-->
    <!--      <h5 class="card-title text-danger"> $CRMcampaignName?> </h5>-->
    <!--      <p class="card-text text-muted"> $CRMcampaignName?> for reaching more clients</p>-->
    <!--    </div>-->
    <!--    <div class="card-footer" style="border-top:1px solid tomato">-->
    <!--    <div class="form-group text-end">-->
    <!--      <a href="#" class="btn btn-sm">Show All</a>-->
    <!--    </div>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</div>-->

    

  </div>

</div>




<div class="container-fluid">




        <div class="row">

            <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats" style="border: 1px solid orange;">

                <div class="card-header card-header-warning card-header-icon">

                  <div class="card-icon p-0">
					<i class="fa-solid fa-users-medical"></i>
                   

                  </div>

                  <p class="card-category">  </p>

                  <h3 class="card-title font-siz"><?=find_a_field('crm_project_lead', 'count(id)', 'status = "1"')?></h3>

                    <small></small>

                  </h3>

                </div>

               <div class="card-footer" style="border-top:1px solid orange">

                  <div class="stats m-0">
				  <h5 class="m-0 bold">Total Active Lead</h5>

                  </div>

                </div>

              </div>

            </div>





            <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats" style="border: 1px solid green;">

                <div class="card-header card-header-success card-header-icon">

                  <div class="card-icon p-0">

                   <i class="fa-solid fa-users-gear"></i>

                  </div>

                  <p class="card-category"> </p>

                  <h3 class="card-title font-siz">
                    <?=find_a_field('crm_project_lead', 'count(id)', '1')?>
                  </h3>

                </div>

                <div class="card-footer" style="border-top:1px solid green">

                  <div class="stats m-0"><h5 class="m-0 bold"> Total Generated Lead</h5></div>

                </div>
              </div>
            </div>
    



            <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats" style="border: 1px solid red;">

                <div class="card-header card-header-danger card-header-icon">

                  <div class="card-icon p-0">

                   <i class="fa-solid fa-square-dollar"></i>

                  </div>

                  <p class="card-category">  </p>

                  <h3 class="card-title font-siz">
                   <?php $tb=find_a_field('crm_campaign_management', 'sum(budget)', '1');if($tb>0){echo $tb;}else{echo '0.00';}?> $
                  </h3>

                </div>

                <div class="card-footer" style="border-top:1px solid red">

                  <div class="stats m-0">
				  <h5 class="m-0 bold"> Total Expenses</h5>
                  </div>
                </div>
              </div>
            </div>





            <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats" style="border: 1px solid #1ec1d5;">

                <div class="card-header card-header-info card-header-icon">

                  <div class="card-icon p-0">

                    <i class="fas fa-chart-pie"></i>

                  </div>

                  <p class="card-category"> </p>

                  <h3 class="card-title font-siz">
                    <!--<small>?</small>-->
                    <?=find_a_field('crm_project_lead a, crm_project_org b', 'count(b.id)', 'a.organization=b.id AND a.status="1"')?>
                  </h3>

                </div>

                <div class="card-footer" style="border-top:1px solid #1ec1d5">

                  <div class="stats m-0">
				  <h5 class="m-0 bold"> Running Projects</h5>

                  </div>
                </div>
              </div>
            </div>



          </div>

		  
		  <div class="row">
		  <!--2nd Dealy seals reporte chart-->
				<div class="col-lg-6 col-md-12">
					<div class="card card-chart">
						<div class="card-body">
							<h4 class="card-title bold" align="center" ><?=$CRMtaskName?> List  </h4>
						</div>
						<div class="card-header">
        <nav>

          <div class="nav nav-tabs" id="nav-tab" role="tablist1" style="padding: 0px; background:#efefef;">

            <a class="nav-item nav-link active" id="nav-task-current-tab" data-toggle="tab" href="#nav-task-current" role="tab" aria-controls="nav-task-current" aria-selected="true">Current</a>

            <a class="nav-item nav-link" id="nav-task-upcoming-tab" data-toggle="tab" href="#nav-task-upcoming" role="tab" aria-controls="nav-task-upcoming" aria-selected="false">Upcoming</a>

          

          </div>

        </nav>

        <div class="tab-content mt-1" id="nav-tabContent">

          <div class="tab-pane fade show active" id="nav-task-current" role="tabpanel1" aria-labelledby="nav-task-current">

          <div class="overflow-auto" style="height:300px;">

              <table class="table table-bordered">

                  

                <thead class="thead-dark">

                  <tr>

                    <th>SN</th>

                    <th>Activity</th>

                    <th>Lead Name</th>

                    <th>Date</th>

                    <th>Details</th>

                  </tr>

                </thead>
                <tbody>
                  <?php 
             $leadsQry = "SELECT a.*,concat(o.name,'##',p.products) as activity FROM crm_lead_activity a,crm_project_lead l,crm_project_org o,crm_lead_products p WHERE a.lead_id=l.id and l.organization=o.id and l.product=p.id and a.date='".date("Y-m-d")."' group by a.id";

                    $rslt = db_query($leadsQry);
$i=1;
                    while($row = mysqli_fetch_object($rslt)){

                  

                  ?>

                    

                  <tr>
				  <td><?=$i++?></td>
				  <td><?=$row->activity_type?></td>
				  <td><?=$row->activity?></td>
				   <td><?=$row->date?><br /><?=date("h:i A ",strtotime($row->time))?> </td>
				  <td><?=$row->details?></td>
				  

    

                  </tr>

                  <? $i++; } if($i==1){
                    
                    echo '
                        <tr><td colspan="5" class="text-center" style="background-color:var(--child-odd-color)!important;border:1px solid rgb(230 230 230);">&nbsp;</td>
                        <tr><td colspan="5" class="text-center" style="background-color:var(--child-odd-color)!important;border:1px solid rgb(230 230 230);">&nbsp;</td>
                        <tr><td colspan="5" class="text-center" style="background-color:var(--child-odd-color)!important;border:1px solid rgb(230 230 230);">&nbsp;</td>
                        <tr><td colspan="5" class="text-center" style="background-color:var(--child-odd-color)!important;border:1px solid rgb(230 230 230);">&nbsp;</td>
                        <tr><td colspan="5" class="text-center" style="background-color:var(--child-odd-color)!important;border:1px solid rgb(230 230 230);">Hurray!! You have no task for now...</td></tr>
                        <tr><td colspan="5" class="text-center" style="background-color:var(--child-odd-color)!important;border:1px solid rgb(230 230 230);">&nbsp;</td>
                        <tr><td colspan="5" class="text-center" style="background-color:var(--child-odd-color)!important;border:1px solid rgb(230 230 230);">&nbsp;</td>
                        <tr><td colspan="5" class="text-center" style="background-color:var(--child-odd-color)!important;border:1px solid rgb(230 230 230);">&nbsp;</td>
                        <tr><td colspan="5" class="text-center" style="background-color:var(--child-odd-color)!important;border:1px solid rgb(230 230 230);">&nbsp;</td>
                        
                    ';
                     
                    } 
                ?>

         



                </tbody>

                

              </table>

            </div>

          </div>

          

          <div class="tab-pane fade" id="nav-task-upcoming" role="tabpanel1" aria-labelledby="nav-task-upcoming">

            <div class="overflow-auto" style="height:300px;">

              <table class="table table-bordered">

                  

                <thead class="thead-dark">

                  <tr>

                    <th>SN</th>

                    <th>Activity</th>

                    <th>Lead Name</th>

                    <th>Date</th>

                    <th>Details</th>

                  </tr>

                </thead>
                <tbody>
                  <?php 
             $leadsQry = "SELECT a.*,concat(o.name,'##',p.products) as activity FROM crm_lead_activity a,crm_project_lead l,crm_project_org o,crm_lead_products p WHERE a.lead_id=l.id and l.organization=o.id and l.product=p.id and a.date>'".date("Y-m-d")."' group by a.id";

                    $rslt = db_query($leadsQry);
                    $i=1;
                    while($row = mysqli_fetch_object($rslt)){

                  

                  ?>

                    

                  <tr>
				  <td><?=$i++?></td>
				  <td><?=$row->activity_type?></td>
				  <td><?=$row->activity?></td>
				  <td><?=$row->date?><br /><?=date("h:i A ",strtotime($row->time))?> </td>
				  <td><?=$row->details?></td>
				  

    

                  </tr>

                  <? $i++; } if($i==1){
                    echo '
                        <tr><td colspan="5" class="text-center" style="background-color:var(--child-odd-color)!important;border:1px solid rgb(230 230 230);">&nbsp;</td>
                        <tr><td colspan="5" class="text-center" style="background-color:var(--child-odd-color)!important;border:1px solid rgb(230 230 230);">&nbsp;</td>
                        <tr><td colspan="5" class="text-center" style="background-color:var(--child-odd-color)!important;border:1px solid rgb(230 230 230);">&nbsp;</td>
                        <tr><td colspan="5" class="text-center" style="background-color:var(--child-odd-color)!important;border:1px solid rgb(230 230 230);">&nbsp;</td>
                        </tr><tr><td colspan="5" class="text-center" style="background-color:var(--child-odd-color)!important;border:1px solid rgb(230 230 230);">Hurray!! You have no upcomming task for now...</td></tr>
                        <tr><td colspan="5" class="text-center" style="background-color:var(--child-odd-color)!important;border:1px solid rgb(230 230 230);">&nbsp;</td>
                        <tr><td colspan="5" class="text-center" style="background-color:var(--child-odd-color)!important;border:1px solid rgb(230 230 230);">&nbsp;</td>
                        <tr><td colspan="5" class="text-center" style="background-color:var(--child-odd-color)!important;border:1px solid rgb(230 230 230);">&nbsp;</td>
                        <tr><td colspan="5" class="text-center" style="background-color:var(--child-odd-color)!important;border:1px solid rgb(230 230 230);">&nbsp;</td>
                        ';
                    }
                  
                  ?>

         



                </tbody>

                

              </table>

            </div>    

          </div>

          

          

        </div>

						</div>
					</div>
				</div>
				
				
				<!--1st One yeare report chart-->
			  <div class="col-lg-6 col-md-12">
				<div class="card card-chart">
					<div class="card-body">
					  	<h4 class="card-title bold" align="center"><?=$CRMscheduleName?> List  </h4>
	<!--				 	<p class="card-category"><span class="text-success"><i class="fa fa-long-arrow-up"></i> 15% </span> increase. </p>-->
					</div>
			
					<div class="card-header">

        <nav>

          <div class="nav nav-tabs" id="nav-tab" role="tablist1" style="padding: 0px; background:#efefef;">

            <a class="nav-item nav-link active" id="nav-task-current-tab" data-toggle="tab" href="#nav-task-schedule" role="tab" aria-controls="nav-task-schedule" aria-selected="true">schedule</a>

            <a class="nav-item nav-link" id="nav-schedule-upcoming-tab" data-toggle="tab" href="#nav-schedule-upcoming" role="tab" aria-controls="nav-schedule-upcoming" aria-selected="false">Upcoming</a>

            <a class="nav-item nav-link" id="nav-schedule-due-tab" data-toggle="tab" href="#nav-schedule-due" role="tab" aria-controls="nav-schedule-due" aria-selected="false">Due</a>

          </div>

        </nav>

        <div class="tab-content mt-1" id="nav-tabContent">

          <div class="tab-pane fade show active" id="nav-task-schedule" role="tabpanel1" aria-labelledby="nav-task-schedule">

          <div class="overflow-auto" style="height:300px; font-size:12px;">

              <table class="table">

                  

                <thead class="thead-dark">

                  <tr>

                    <th>Title</th>

                    <th>From</th>

                    <th>To</th>

                    <th>Related to</th>

                    <th>Contact Name</th>

                  </tr>

                </thead>

                

                <tbody>

                    

                  <tr onClick="window.location.href=''">

                    <td>Webinar1</td>

                    <td>02/22/2023 <br> 04:55 PM</td>

                    <td>02/22/2023 <br> 04:55 PM</td>

                    <td>Printing Dimensions</td>

                    <td>Kris Marrier</td>

                  </tr>



                </tbody>

                

              </table>

            </div>

          </div>

          

          <div class="tab-pane fade" id="nav-schedule-upcoming" role="tabpanel1" aria-labelledby="nav-schedule-upcoming">

            <div class="overflow-auto" style="height:300px;">

              <table class="table">

                  

                <thead class="thead-dark">

                  <tr>

                    <th>Title</th>

                    <th>From</th>

                    <th>To</th>

                    <th>Related to</th>

                    <th>Contact Name</th>

                  </tr>

                </thead>

                

                <tbody>

                    

                  <tr onClick="window.location.href=''">

                    <td>Webinar2</td>

                    <td>02/22/2023 <br> 04:55 PM</td>

                    <td>02/22/2023 <br> 04:55 PM</td>

                    <td>Printing Dimensions</td>

                    <td>Kris Marrier</td>

                  </tr>

    

                </tbody>

                

              </table>

            </div>    

          </div>

          

          <div class="tab-pane fade" id="nav-schedule-due" role="tabpanel1" aria-labelledby="nav-schedule-due">

              <div class="overflow-auto" style="height:300px;">

              <table class="table">

                  

                <thead class="thead-dark">

                  <tr>

                    <th>Title</th>

                    <th>From</th>

                    <th>To</th>

                    <th>Related to</th>

                    <th>Contact Name</th>

                  </tr>

                </thead>

                

                <tbody>

                    

                  <tr onClick="window.location.href=''">

                    <td>Webinar3</td>

                    <td>02/22/2023 <br> 04:55 PM</td>

                    <td>02/22/2023 <br> 04:55 PM</td>

                    <td>Printing Dimensions</td>

                    <td>Kris Marrier</td>

                  </tr>

                  

                </tbody>

                

              </table>

            </div>

          </div>

        </div>

					</div>
	
			   </div>
			</div>
				

				
								
				<!--4th Monthly seals report chart-->	
				<div class="col-lg-6 col-md-12">
					<div class="card card-chart">
						<div class="card-body">
							<h4 class="card-title">Calander </h4>
						</div>
						<div class="card-header">



                <?php
              
                    $eventDates = array("");
                    $eventDetails = array("");
                    
                    $salaryHolidaysQry = "SELECT * FROM salary_holy_day WHERE holy_day LIKE '%".date('Y')."%'";
                    $salaryHolidaysRslt = db_query($salaryHolidaysQry);
                    
                    while($salaryHolidays = mysqli_fetch_object($salaryHolidaysRslt)){
            
                        array_push($eventDates, $salaryHolidays->holy_day);
                        array_push($eventDetails, $salaryHolidays->reason);
                                        
                    }


                    
                ?>
                    
                    
                    <script type="text/javascript" language="javascript">
        
                    const eventDates = [];
                    const eventDetails = [];
            
                    <?php foreach($eventDates as $key => $val){ ?>
                        eventDates.push("<?=$val?>");
                    <?php } ?>
                    
                    <?php foreach($eventDetails as $key => $val){ ?>
                        eventDetails.push("<?=$val?>");
                    <?php } ?>
                    
                </script>
                
                
            <?php
            
                    include '../include/Calendar.php';

                    $calendar = new Calendar(date('Y-m-d'));

                    $calendar->setUser($_SESSION['user']['id']);
    
                    foreach($offDays as $key => $val){
                        $calendar->add_weekly_offdays($val);
                    }
                    
                    foreach($partialOffDays as $key => $val){
                        $calendar->add_partialWeekly_offdays($val);
                    }

                    foreach($eventDates as $key => $val){

                        if($key!=0){

                            $calendar->add_event($eventDetails[$key], $val, 1, 'red');

                        }

                    }
                

                    ?>


                    <?=$calendar?>
                    
                    
                    <?php
                    
                        $myTasks = $calendar->getMyMonthlyTasks();
                        $myDates = $calendar->getMyMonthlyDates();
                    
                    ?>


                    <script>
                    
                        var myTasks = [];
                        var myDates = [];
                        
                        
                        <?php foreach($myTasks as $key => $val){ ?>
                            myTasks.push("<?=$val?>");
                        <?php } ?>
                        
                        <?php foreach($myDates as $key => $val){ ?>
                            myDates.push("<?=$val?>");
                        <?php } ?>
                        
                    </script>

						</div>
					</div>
				</div>

			
			
							
				<!--3rd One yeare report chart-->	
				<div class="col-lg-6 col-md-12">
					<div class="card card-chart">
						<div class="card-body">
							<h4 class="card-title">Events: </h4>
						</div>
						<div class="card-header">
						<div class="col-md-12">

              <ul>

                    <li id="event-details" class="text-center font-weight-bold" style="list-style:none;margin: 15px 0 15px 0px;background:#b6e1fb26;padding:5px;font-size:14px;">

                        --Select A Date From The Calender--

                    </li>

                  <?php foreach($eventDates as $key => $val){ if($key!=0 && substr($val,5,2)==date('m')){ ?>

                        <li class="hide-on-elem"> <span> <?=$val?> : </span> <span> <?=$eventDetails[$key];?> </span> </li>

                  <?php } } ?>



              </ul>

          </div>
						</div>
					</div>
				</div>
			
			
		
				
			  </div>
		  </div>





<?php /*?><section class="mt-3">

  <div class="container">

    <div class="row">

      

      <!-- Task Lists -Start- -->

      <div class="col-md-6 task-lists" style="border: 1px solid #0f21320d;">

        <h5 class="text-center" style="margin-top:5px;"><?=$CRMtaskName?> List </h5>

        <nav>

          <div class="nav nav-tabs" id="nav-tab" role="tablist1" style="padding: 0px; background:#efefef;">

            <a class="nav-item nav-link active" id="nav-task-current-tab" data-toggle="tab" href="#nav-task-current" role="tab" aria-controls="nav-task-current" aria-selected="true">Current</a>

            <a class="nav-item nav-link" id="nav-task-upcoming-tab" data-toggle="tab" href="#nav-task-upcoming" role="tab" aria-controls="nav-task-upcoming" aria-selected="false">Upcoming</a>

            <a class="nav-item nav-link" id="nav-task-due-tab" data-toggle="tab" href="#nav-task-due" role="tab" aria-controls="nav-task-due" aria-selected="false">Due</a>

          </div>

        </nav>

        <div class="tab-content mt-1" id="nav-tabContent">

          <div class="tab-pane fade show active" id="nav-task-current" role="tabpanel1" aria-labelledby="nav-task-current">

          <div class="overflow-auto" style="height:420px;">

              <table class="table">

                  

                <thead class="thead-dark">

                  <tr>

                    <th>SN</th>

                    <th><?=$CRMtaskName?></th>

                    <th>Assigned</th>

                    <th>Due Time</th>

                    <th>Status</th>

                    <th>Priority</th>

                  </tr>

                </thead>

                

                <tbody>

                    

                  <?php 

                  

                    $sn=1;

                    $curTasksQry = "SELECT * FROM $table2 WHERE to_time >= '$today' AND status = '1' AND status = '3'".$con;

                    $curTaskRslt = db_query($curTasksQry);

                    while($curTaskData = mysqli_fetch_object($curTaskRslt)){

                  

                  ?>

                    

                  <tr onclick="window.location.href='../task_management/show_all_tasks.php?update=<?=encrypTS($curTaskData->id)?>'">

                    <td><?=$sn?></td>

                    <td><?=$curTaskData->task_name?></td>

                    <td>By: <?=find_a_field('user_activity_management', 'fname', 'PBI_ID = "'.$curTaskData->entry_by.'"')?> <br>To: <?=find_a_field('user_activity_management', 'fname', 'PBI_ID = "'.$curTaskData->assigned_person_id.'"')?></td>

                    <td><?=$curTaskData->entry_time?> | <?=$curTaskData->to_time?></td>

                    <td><?=find_a_field('crm_task_status', 'status', 'id="'.$curTaskData->status.'"') ?></td>

                    <td><?=$Priority_ar[$curTaskData->priority]?></td>

                  </tr>

                  

                  <?php $sn++; } ?>



                </tbody>

                

              </table>

            </div>

          </div>

          

          <div class="tab-pane fade" id="nav-task-upcoming" role="tabpanel1" aria-labelledby="nav-task-upcoming">

            <div class="overflow-auto" style="height:420px;">

              <table class="table">

                  

                <thead class="thead-dark">

                  <tr>

                    <th>SN</th>

                    <th><?=$CRMtaskName?></th>

                    <th>Assigned</th>

                    <th>Due Time</th>

                    <th>Status</th>

                    <th>Priority</th>

                  </tr>

                </thead>

                

                <tbody>

                    

                  <?php 

                  

                    $sn=1;

                    $upcomingTasksQry = "SELECT * FROM $table2 WHERE to_time > '$today' AND (status = '1' OR status = '3') ".$con;

                    $upcomingTaskRslt = db_query($upcomingTasksQry);

                    while($upcomingTaskData = mysqli_fetch_object($upcomingTaskRslt)){

                  

                  ?>

                    

                  <tr onclick="window.location.href='../task_management/show_all_tasks.php?update=<?=encrypTS($upcomingTaskData->id)?>'">

                    <td><?=$sn?></td>

                    <td><?=$upcomingTaskData->task_name?></td>

                    <td>By: <?=find_a_field('user_activity_management', 'fname', 'PBI_ID = "'.$upcomingTaskData->entry_by.'"')?> <br>To: <?=find_a_field('user_activity_management', 'fname', 'PBI_ID = "'.$upcomingTaskData->assigned_person_id.'"')?></td>

                    <td><?=$upcomingTaskData->entry_at?> | <?=$upcomingTaskData->to_time?></td>

                    <td><?=find_a_field('crm_task_status', 'status', 'id="'.$upcomingTaskData->status.'"') ?></td>

                    <td><?=$Priority_ar[$upcomingTaskData->priority]?></td>

                  </tr>

                  

                  <?php $sn++; } ?>



                </tbody>

                

              </table>

            </div>    

          </div>

          

          <div class="tab-pane fade" id="nav-task-due" role="tabpanel1" aria-labelledby="nav-task-due">

              <div class="overflow-auto" style="height:420px;">

              <table class="table">

                  

                <thead class="thead-dark">

                  <tr>

                    <th>SN</th>

                    <th><?=$CRMtaskName?></th>

                    <th>Assigned</th>

                    <th>Due Time</th>

                    <th>Status</th>

                    <th>Priority</th>

                  </tr>

                </thead>

                

                <tbody>

                    

                  <?php 

                  

                    $sn=1;

                    $dueTasksQry = "SELECT * FROM $table2 WHERE to_time < '$today' AND (status = '1' OR status = '3') ".$con;

                    $dueTaskRslt = db_query($dueTasksQry);

                    while($dueTaskData = mysqli_fetch_object($dueTaskRslt)){

                  

                  ?>

                    

                  <tr onclick="window.location.href='../task_management/show_all_tasks.php?update=<?=encrypTS($dueTaskData->id)?>'">

                    <td><?=$sn?></td>

                    <td><?=$dueTaskData->task_name?></td>

                    <td>By: <?=find_a_field('user_activity_management', 'fname', 'PBI_ID = "'.$dueTaskData->entry_by.'"')?> <br>To: <?=find_a_field('user_activity_management', 'fname', 'PBI_ID = "'.$dueTaskData->assigned_person_id.'"')?></td>

                    <td><?=$dueTaskData->entry_at?> | <?=$dueTaskData->to_time?></td>

                    <td><?=find_a_field('crm_task_status', 'status', 'id="'.$dueTaskData->status.'"') ?></td>

                    <td><?=$Priority_ar[$dueTaskData->priority]?></td>

                  </tr>

                  

                  <?php $sn++; } ?>



                </tbody>

                

              </table>

            </div>

          </div>

        </div>

      </div>

      <!-- Task Lists -End- -->

      

      <!-- Schedule List -Start- -->

      <div class="col-md-6 task-lists" style="border: 1px solid #0f21320d;">

        <h5 class="text-center" style="margin-top:5px;"><?=$CRMscheduleName?> List </h5>

        <nav>

          <div class="nav nav-tabs" id="nav-tab" role="tablist1" style="padding: 0px; background:#efefef;">

            <a class="nav-item nav-link active" id="nav-task-current-tab" data-toggle="tab" href="#nav-task-schedule" role="tab" aria-controls="nav-task-schedule" aria-selected="true">schedule</a>

            <a class="nav-item nav-link" id="nav-schedule-upcoming-tab" data-toggle="tab" href="#nav-schedule-upcoming" role="tab" aria-controls="nav-schedule-upcoming" aria-selected="false">Upcoming</a>

            <a class="nav-item nav-link" id="nav-schedule-due-tab" data-toggle="tab" href="#nav-schedule-due" role="tab" aria-controls="nav-schedule-due" aria-selected="false">Due</a>

          </div>

        </nav>

        <div class="tab-content mt-1" id="nav-tabContent">

          <div class="tab-pane fade show active" id="nav-task-schedule" role="tabpanel1" aria-labelledby="nav-task-schedule">

          <div class="overflow-auto" style="height:420px; font-size:12px;">

              <table class="table">

                  

                <thead class="thead-dark">

                  <tr>

                    <th>Title</th>

                    <th>From</th>

                    <th>To</th>

                    <th>Related to</th>

                    <th>Contact Name</th>

                  </tr>

                </thead>

                

                <tbody>

                    

                  <tr onClick="window.location.href=''">

                    <td>Webinar1</td>

                    <td>02/22/2023 <br> 04:55 PM</td>

                    <td>02/22/2023 <br> 04:55 PM</td>

                    <td>Printing Dimensions</td>

                    <td>Kris Marrier</td>

                  </tr>



                </tbody>

                

              </table>

            </div>

          </div>

          

          <div class="tab-pane fade" id="nav-schedule-upcoming" role="tabpanel1" aria-labelledby="nav-schedule-upcoming">

            <div class="overflow-auto" style="height:420px;">

              <table class="table">

                  

                <thead class="thead-dark">

                  <tr>

                    <th>Title</th>

                    <th>From</th>

                    <th>To</th>

                    <th>Related to</th>

                    <th>Contact Name</th>

                  </tr>

                </thead>

                

                <tbody>

                    

                  <tr onClick="window.location.href=''">

                    <td>Webinar2</td>

                    <td>02/22/2023 <br> 04:55 PM</td>

                    <td>02/22/2023 <br> 04:55 PM</td>

                    <td>Printing Dimensions</td>

                    <td>Kris Marrier</td>

                  </tr>

    

                </tbody>

                

              </table>

            </div>    

          </div>

          

          <div class="tab-pane fade" id="nav-schedule-due" role="tabpanel1" aria-labelledby="nav-schedule-due">

              <div class="overflow-auto" style="height:420px;">

              <table class="table">

                  

                <thead class="thead-dark">

                  <tr>

                    <th>Title</th>

                    <th>From</th>

                    <th>To</th>

                    <th>Related to</th>

                    <th>Contact Name</th>

                  </tr>

                </thead>

                

                <tbody>

                    

                  <tr onClick="window.location.href=''">

                    <td>Webinar3</td>

                    <td>02/22/2023 <br> 04:55 PM</td>

                    <td>02/22/2023 <br> 04:55 PM</td>

                    <td>Printing Dimensions</td>

                    <td>Kris Marrier</td>

                  </tr>

                  

                </tbody>

                

              </table>

            </div>

          </div>

        </div>

      </div>

      <!-- Schedule List -End- -->

      

    </div>



  </div>

</section><?php */?>





<br/><br/>

<section>

    <div class="container">

        <div class="row">
          

          <!-- Task Calendar -Start- -->

          <?php /*?><div class="col-md-8">


                <?php
              
                    $eventDates = array("");
                    $eventDetails = array("");
                    
                    $salaryHolidaysQry = "SELECT * FROM salary_holy_day WHERE holy_day LIKE '%".date('Y')."%'";
                    $salaryHolidaysRslt = db_query($salaryHolidaysQry);
                    
                    while($salaryHolidays = mysqli_fetch_object($salaryHolidaysRslt)){
            
                        array_push($eventDates, $salaryHolidays->holy_day);
                        array_push($eventDetails, $salaryHolidays->reason);
                                        
                    }


                    
                ?>
                    
                    
                    <script type="text/javascript" language="javascript">
        
                    const eventDates = [];
                    const eventDetails = [];
            
                    <?php foreach($eventDates as $key => $val){ ?>
                        eventDates.push("<?=$val?>");
                    <?php } ?>
                    
                    <?php foreach($eventDetails as $key => $val){ ?>
                        eventDetails.push("<?=$val?>");
                    <?php } ?>
                    
                </script>
                
                
            <?php
            
                    include '../include/Calendar.php';

                    $calendar = new Calendar(date('Y-m-d'));

                    $calendar->setUser($_SESSION['employee_selected']);
    
                    foreach($offDays as $key => $val){
                        $calendar->add_weekly_offdays($val);
                    }
                    
                    foreach($partialOffDays as $key => $val){
                        $calendar->add_partialWeekly_offdays($val);
                    }

                    foreach($eventDates as $key => $val){

                        if($key!=0){

                            $calendar->add_event($eventDetails[$key], $val, 1, 'red');

                        }

                    }
                

                    ?>


                    <?=$calendar?>
                    
                    
                    <?php
                    
                        $myTasks = $calendar->getMyMonthlyTasks();
                        $myDates = $calendar->getMyMonthlyDates();
                    
                    ?>


                    <script>
                    
                        var myTasks = [];
                        var myDates = [];
                        
                        
                        <?php foreach($myTasks as $key => $val){ ?>
                            myTasks.push("<?=$val?>");
                        <?php } ?>
                        
                        <?php foreach($myDates as $key => $val){ ?>
                            myDates.push("<?=$val?>");
                        <?php } ?>
                        
                    </script>
                    

                    

          </div><?php */?>

          <!-- Task Calendar -End- -->

          

          <!-- Task Event -End- --> 

          <?php /*?><div class="col-md-4">

              <h3>Events:</h3>

              <ul>

                    <li id="event-details" class="text-center font-weight-bold" style="list-style:none;margin: 15px 0 15px 0px;background:#b6e1fb26;padding:5px;font-size:14px;">

                        --Select A Date From The Calender--

                    </li>

                  <?php foreach($eventDates as $key => $val){ if($key!=0 && substr($val,5,2)==date('m')){ ?>

                        <li class="hide-on-elem"> <span> <?=$val?> : </span> <span> <?=$eventDetails[$key];?> </span> </li>

                  <?php } } ?>



              </ul>

          </div><?php */?>

          <!-- Task Event -End- -->

          

        </div>

    </div>

</section>







<?php //Custom JS Functions -Start- ?>

<script>

    function imAnEvent(date){
        
        var flag = 0, eventByDate='Regular Workday', tasksByDate='', schedulesByDate='';
        
        if(eventDates.indexOf(date) != -1){  

           eventByDate = eventDetails[eventDates.indexOf(date)];
            
           flag++;
           
        }
        
        if(myDates.indexOf(date) != -1){  
            
           if(myTasks[myDates.indexOf(date)] != ''){
              tasksByDate = '<br><small>Task(s): '+myTasks[myDates.indexOf(date)];
           }
           
           flag++;
           
        }
        
        if(flag==0){

            document.getElementById("event-details").innerHTML = 'No Event Found!';

        }else{
            document.getElementById("event-details").innerHTML = eventByDate+tasksByDate+'</small>';
        }

    }



</script>



<script>



    function myReminderSB() {

      var check = document.getElementById("customSwitch2");

      var remind_at = document.getElementById("remind_at");

      if (check.checked == true){

        remind_at.style.display = "block";

        remind_at.disabled=false;

      } else {

         remind_at.style.display = "none";

         remind_at.disabled=true;

      }

    }



</script>

<?php //Custom JS Functions -End- ?>









<?
require_once SERVER_CORE."routing/layout.bottom.php";

?>










