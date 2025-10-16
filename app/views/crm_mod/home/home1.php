<?php




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


 $unique='task_id'; 
$title = "Customer Relationship Management Dashboard";



$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');


$table='crm_task_add_information';		// Database Table Name Mainly related to this page

$crud    =new crud($table);
//for update..................................
if(isset($_POST['update']))
{
$_POST['edit_at']=time();
$_POST['edit_by']=$_SESSION['user']['id'];
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
}

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

            

        	
if(isset($$unique))
{
$condition=$unique."=".$$unique;	
$data=db_fetch_object($table,$condition);
foreach ($data as $key => $value)
{ $$key=$value;}
}	
?>

<script type="text/javascript">
  function nav(lkf){document.location.href = '<?=$page?>?<?=$unique?>='+lkf;}
</script>

        

    

  <style>.nav-tabs .nav-link.active, .nav-tabs .nav-link.active:active, .nav-tabs .nav-link.active:focus, .nav-tabs .nav-link.active:visited, .nav-tabs .nav-link.active:hover{border-color: #bfc1f5;}
</style>










<style>

.order-card {
    color: #fff;
}

.bg-c-blue {
    background: linear-gradient(45deg,#4099ff,#73b4ff);
}

.bg-c-green {
    background: linear-gradient(45deg,#2ed8b6,#59e0c5);
}

.bg-c-yellow {
    background: linear-gradient(45deg,#FFB64D,#ffcb80);
}

.bg-c-pink {
    background: linear-gradient(45deg,#FF5370,#ff869a);
}


.mycard2 {
    padding-left:2px;
    padding-right:2px;
    border-radius: 5px;
    -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    border: none;
    margin-bottom: 30px;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}

.mycard2 .card-block {

    padding: 25px;
}

.order-card i {
    font-size: 26px;
}

.f-left {
    float: left;
}

.f-right {
    float: right;
}

.order-card:hover {
    transform: translateY(-10px);
    -webkit-transform: translateY(-10px);
    -moz-transform: translateY(-10px);
    -ms-transform: translateY(-10px);
    -o-transform: translateY(-10px);
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    -webkit-box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
}

.order-card:hover .card-block {
    background-color: rgba(255, 255, 255, 0.1);
}

.order-card:hover h6, .order-card:hover h2 {
    color: #fff;
}
#topcard{
  padding-top: 15px;
  padding-left: 15px;
  padding-right: 15px;
}
.textspan{
  font-size:25px !important;
}


</style>

<div class="card card-stats" id="topcard">
<div class="row">
        <div class="col-md-3 col-xl-3">
            <div class="mycard2 bg-c-blue order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Total Active Lead</h6>
                    <h2 class="text-right"><i class="fa-solid fa-users-medical f-left"></i><span class="textspan"><?=find_a_field('crm_project_lead', 'count(id)', 'status = "1"')?></span></h2>
                    
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-xl-3">
            <div class="mycard2 bg-c-green order-card">
                <div class="card-block">
                    <h6 class="m-b-20"> Total Generated Lead</h6>
                    <h2 class="text-right"><i class="fa-solid fa-users-gear f-left"></i><span class="textspan"><?=find_a_field('crm_project_lead', 'count(id)', '1')?></span></h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-xl-3">
            <div class="mycard2 bg-c-yellow order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Running Projects</h6>
                    <h2 class="text-right"><i class="fas fa-chart-pie f-left"></i><span class="textspan"><?=find_a_field('crm_project_lead a, crm_project_org b', 'count(b.id)', 'a.organization=b.id AND a.status="1"')?></span></h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-xl-3">
            <div class="mycard2 bg-c-pink order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Total Task</h6>
                    <h2 class="text-right"><i class="fas fa-tasks f-left"></i><span class="textspan"><?=find_a_field('crm_task_add_information', 'count(task_id)', '1')?></span></h2>
                </div>
            </div>
        </div>
        
<!-- 
        <div class="col-md-2 col-xl-3">
            <div class="mycard2 bg-c-pink order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Total Expenses</h6>
                    <h2 class="text-right"><i class="fa-solid fa-square-dollar f-left"></i><span><//?php $tb=find_a_field('crm_campaign_management', 'sum(budget)', '1');if($tb>0){echo $tb;}else{echo '0.00';}?> $</span></h2>
                </div>
            </div>
        </div> -->

</div>
</div>
         
 


















<style>
    

    .card-big-shadow {
        max-width: 320px;
        position: relative;
    }

    .coloured-cards .mycard {
        margin-top: 30px;
    }

    .mycard[data-radius="none"] {
        border-radius: 0px;
    }
    .mycard {
        border-radius: 8px;
        box-shadow: 0 2px 2px rgba(204, 197, 185, 0.5);
        background-color: #FFFFFF;
        color: #252422;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
    }


    .mycard[data-background="image"] .title, .mycard[data-background="image"] .stats, .mycard[data-background="image"] .category, .mycard[data-background="image"] .description, .mycard[data-background="image"] .content, .mycard[data-background="image"] .card-footer, .mycard[data-background="image"] small, .mycard[data-background="image"] .content a, .mycard[data-background="color"] .title, .mycard[data-background="color"] .stats, .mycard[data-background="color"] .category, .mycard[data-background="color"] .description, .mycard[data-background="color"] .content, .mycard[data-background="color"] .card-footer, .mycard[data-background="color"] small, .card[data-background="color"] .content a {
        color: #FFFFFF;
    }
    .mycard.card-just-text .ourcontent {
        padding: 50px 65px;
        text-align: center;
    }
    .mycard .content {
        padding: 20px 20px 10px 20px;
    }
    .mycard[data-color="blue"] .category {
        color: #7a9e9f;
    }

    .mycard .category, .mycard .label {
        font-size: 14px;
        margin-bottom: 0px;
    }
    .card-big-shadow:before {
        background-image: url("http://static.tumblr.com/i21wc39/coTmrkw40/shadow.png");
        background-position: center bottom;
        background-repeat: no-repeat;
        background-size: 100% 100%;
        bottom: -12%;
        content: "";
        display: block;
        left: -12%;
        position: absolute;
        right: 0;
        top: 0;
        z-index: 0;
    }
    h4, .myh4 {
        font-size: 1.5em;
        font-weight: 600;
        line-height: 1.2em;
    }
    h6, .myh6 {
        font-size: 0.9em;
        font-weight: 600;
        text-transform: uppercase;
    }
    .mycard .description {
        font-size: 16px;
        color: #66615b;
        display: -webkit-box;
        /* Set as a block element */
        -webkit-line-clamp: 4;
        /* Limit to 5 lines */
        -webkit-box-orient: vertical;
        overflow: hidden;
        /* Set vertical orientation */
        text-overflow: ellipsis;
        /* Add ellipsis for overflow text */
    }
    .mycontent-card{
        margin-top:30px;    
    }
    a:hover, a:focus {
        text-decoration: none;
    }

    /*======== COLORS ===========*/
    .mycard[data-color="blue"] {
        background: #b8d8d8;
    }
    .mycard[data-color="blue"] .description {
        color: #506568;
    }

    .mycard[data-color="green"] {
        background: #d5e5a3;
    }
    .mycard[data-color="green"] .description {
        color: #60773d;
    }
    .mycard[data-color="green"] .category {
        color: #92ac56;
    }

    .mycard[data-color="yellow"] {
        background: #ffe28c;
    }
    .mycard[data-color="yellow"] .description {
        color: #b25825;
    }
    .mycard[data-color="yellow"] .category {
        color: #d88715;
    }

    .mycard[data-color="brown"] {
        background: #d6c1ab;
    }
    .mycard[data-color="brown"] .description {
        color: #75442e;
    }
    .card[data-color="brown"] .category {
        color: #a47e65;
    }

    .mycard[data-color="purple"] {
        background: #baa9ba;
    }
    .mycard[data-color="purple"] .description {
        color: #3a283d;
    }
    .mycard[data-color="purple"] .category {
        color: #5a283d;
    }

    .mycard[data-color="orange"] {
        background: #ff8f5e;
    }
    .mycard[data-color="orange"] .description {
        color: #772510;
    }
    .mycard[data-color="orange"] .category {
        color: #e95e37;
    }
</style>


  <script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>

  

<div class="container">
<div class="container bootstrap snippets bootdeys">
            <div class="row">
  <?php
$currentDateTime = date("Y-m-d H:i:s");
$sqlTasks = "SELECT * FROM crm_task_add_information WHERE CONCAT(reaminder_start_date, ' ', reaminder_start_time) <= '$currentDateTime' and marked_as_done ='0'";
$resultTasks = db_query($sqlTasks);

while ($row = mysqli_fetch_object($resultTasks)) {
 $organization=find_a_field('crm_project_org','name','id="'.$row->organization_id.'"');
?>

<div class="col-md-4 col-sm-6 mycontent-card">
    <div class="card-big-shadow">
        <div class="mycard card-just-text" data-background="color" data-color="blue" data-radius="none">
            <div class="ourcontent">
                <h6 class="myh6 category"><?=$row->task_name;?></h6>
                <h4 class="myh4 title"><a href="#"><?=$organization?></a></h4>
                <p class="description"><?=$row->task_details;?> </p>
                <button type="button" class="btn btn-outline-success" data-toggle="modal"
                        data-target="#exampleModalCenter"
                        data-task-id="<?=$row->task_id;?>"
                        data-task-name="<?=$row->task_name;?>"
                        data-task-details="<?=$row->task_details;?>"
                        onclick="openModal('<?=$row->task_id;?>', '<?=$row->task_name;?>', '<?=$row->task_details;?>','<?=$organization?>','<?=$row->task_time;?>','<?=$row->task_date;?>')">
                         Show More
                </button>
            </div>
        </div> <!-- end card -->
    </div>
</div>
<?php } ?>

                
            </div>
            </div>

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

<!-- 


        <div class="row">

            <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats" style="border: 1px solid orange;">

                <div class="card-header card-header-warning card-header-icon">

                  <div class="card-icon p-0">
					<i class="fa-solid fa-users-medical"></i>
                   

                  </div>

                  <p class="card-category">  </p>

                  <h3 class="card-title font-siz"><//?=find_a_field('crm_project_lead', 'count(id)', 'status = "1"')?></h3>

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
                    <//?=find_a_field('crm_project_lead', 'count(id)', '1')?>
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
                   <//?php $tb=find_a_field('crm_campaign_management', 'sum(budget)', '1');if($tb>0){echo $tb;}else{echo '0.00';}?> $
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
                    <small>?</small>
                    <//?=find_a_field('crm_project_lead a, crm_project_org b', 'count(b.id)', 'a.organization=b.id AND a.status="1"')?>
                  </h3>

                </div>

                <div class="card-footer" style="border-top:1px solid #1ec1d5">

                  <div class="stats m-0">
				  <h5 class="m-0 bold"> Running Projects</h5>

                  </div>
                </div>
              </div>
            </div>

          </div> -->


          <!-- new card added -->



          <!-- end new  card added -->



		  
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







                  
                          <!-- Start timeline -->
<Style>


.timelinecontainer {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 0 1rem;
  /* background: linear-gradient(45deg, #209cff, #68e0cf); */
  padding: 3rem 0;
}

.timelinewrapper{
  background: #eaf6ff;
  padding: 1rem;
  border-radius: 15px;
}
.mysessions {
  margin-top: 2rem;
  border-radius: 12px;
  position: relative;
}

#timelineid  {
  padding-bottom: 1.5rem;
  border-left: 1px solid #abaaed;
  position: relative;
  padding-left: 20px;
  margin-left: 10px;
}
#timelineid:last-child {
  border: 0px;
  padding-bottom: 0;
}
#timelineid:before {
  content: "";
  width: 15px;
  height: 15px;
  background: white;
  border: 1px solid #4e5ed3;
  box-shadow: 3px 3px 0px #bab5f8;
  box-shadow: 3px 3px 0px #bab5f8;
  border-radius: 50%;
  position: absolute;
  left: -10px;
  top: 0px;
} 
.mytime {
  color: #2a2839;
  font-family: "Poppins", sans-serif;
  font-weight: 500;
}
@media screen and (min-width: 601px) {
  .mytime {
    font-size: 0.9rem;
  }
}
@media screen and (max-width: 600px) {
  .mytime {
    margin-bottom: 0.3rem;
    font-size: 0.85rem;
  }
}




</Style>

<div class="timelinecontainer">
  <div class="timelinewrapper">
    <h1> A day in my 'sleepy' life 😅</h1>
  
    <ul class="mysessions">
      <li id="timelineid">
        <div class="mytime">09:00 AM</div>
        <h3 class="fs-1">Company Name</h3>
        <p class="myptag">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis consequatur nam ut sequi perferendis dolor iste rerum neque nostrum aperiam, quidem quasi tempora. Dolorum omnis, sunt consequatur accusamus non ad. Cumque ducimus impedit maxime consequuntur eos dicta commodi totam inventore incidunt minus cum similique harum, voluptate amet ipsam sed necessitatibus est, esse id quam accusantium tempore? Debitis impedit commodi cumque velit illo incidunt reiciendis culpa iste maxime quibusdam tenetur, quo quaerat accusamus, animi eum molestias excepturi dolores iure vel. Sit, asperiores sapiente! Impedit ipsam perferendis porro exercitationem, at deleniti numquam maiores debitis facilis? Incidunt odio facilis sint dolore laudantium tempore? 🤯</p>
        
      </li>
      <li id="timelineid">
        <div class="mytime">09:05 AM</div>
        <p>Few more minutes of sleep won't do anyone any harm 🤷..</p>
      </li id="timelineid">
      <li id="timelineid">
        <div class="mytime">09:30 AM</div>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora reprehenderit nisi rem cumque officia iusto alias distinctio atque corporis velit sed id perspiciatis maiores quibusdam natus tempore molestias, quod labore enim quasi inventore beatae? Delectus, mollitia. Labore voluptates dolor laboriosam ea laudantium corrupti illo quasi perferendis saepe similique obcaecati eaque mollitia, iure ducimus non doloremque consequuntur nam veniam aut, officia magni, nihil nisi cum! Facilis beatae mollitia esse eum nobis odio et velit praesentium necessitatibus iusto est dolorem, saepe illum incidunt dicta voluptate repellat at debitis quae quaerat soluta qui! Ipsa quasi, quod veritatis ab laudantium dicta? Aperiam, corrupti magnam! 🙄</p>
      </li>
      <li id="timelineid">
        <div class="mytime">1:00 PM</div>
        <p>How can I feel sleepy again?😵</p>
      </li id="timelineid">
      
    </ul>
  </div>
</div> 




<!-- End timeline -->




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


<!-- 

 <style>


.card4 {
    border: 0;
    box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
    -webkit-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
    -moz-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
    -ms-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
}
.card4 {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #FFF9F9;
    background-clip: border-box;
    border: 1px solid #e6e4e9;
    border-radius: 8px;
}

.card4 .card-header.no-border {
    border: 0;
}
.card4 .card-header {
    background: none;
    padding: 0 0.9375rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    min-height: 50px;
}
.card-header:first-child {
    border-radius: calc(8px - 1px) calc(8px - 1px) 0 0;
}

.widget-49 .widget-49-title-wrapper {
  display: flex;
  align-items: center;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-primary {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: #edf1fc;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-primary .widget-49-date-day {
  color: #4e73e5;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-primary .widget-49-date-month {
  color: #4e73e5;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-secondary {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: #F1FAFF;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-secondary .widget-49-date-day {
  color: #dde1e9;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-secondary .widget-49-date-month {
  color: #dde1e9;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-success {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: #e8faf8;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-success .widget-49-date-day {
  color: #17d1bd;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-success .widget-49-date-month {
  color: #17d1bd;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-info {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: #ebf7ff;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-info .widget-49-date-day {
  color: #36afff;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-info .widget-49-date-month {
  color: #36afff;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-warning {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: floralwhite;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-warning .widget-49-date-day {
  color: #FFC868;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-warning .widget-49-date-month {
  color: #FFC868;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-danger {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: #feeeef;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-danger .widget-49-date-day {
  color: #F95062;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-danger .widget-49-date-month {
  color: #F95062;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-light {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: #fefeff;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-light .widget-49-date-day {
  color: #f7f9fa;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-light .widget-49-date-month {
  color: #f7f9fa;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-dark {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: #ebedee;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-dark .widget-49-date-day {
  color: #394856;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-dark .widget-49-date-month {
  color: #394856;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-base {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: #f0fafb;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-base .widget-49-date-day {
  color: #68CBD7;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-base .widget-49-date-month {
  color: #68CBD7;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-meeting-info {
  display: flex;
  flex-direction: column;
  margin-left: 1rem;
}

.widget-49 .widget-49-title-wrapper .widget-49-meeting-info .widget-49-pro-title {
  color: #3c4142;
  font-size: 22px;
}

.widget-49 .widget-49-title-wrapper .widget-49-meeting-info .widget-49-meeting-time {
  color: #B1BAC5;
  font-size: 13px;
}

.widget-49 .widget-49-meeting-points {
  font-weight: 400;
  font-size: 13px;
  margin-top: .5rem;
}

.widget-49 .widget-49-meeting-points .widget-49-meeting-item {
  display: list-item;
  color: #727686;
}

.widget-49 .widget-49-meeting-points .widget-49-meeting-item span {
  margin-left: .5rem;
}

.widget-49 .widget-49-meeting-action {
  text-align: right;
}

.widget-49 .widget-49-meeting-action a {
  text-transform: uppercase;
}
    </style>   -->

<div class="modal fade " id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <!-- <div class="modal-dialog modal-dialog-centered" role="document"> -->
    <!-- <div class="d-flex justify-content-center align-items-center  "> -->
      <div style="min-height: 300px;min-width: 500px;">
                <div class="card4 card-margin">
                    <div class="card-header no-border">
                        <h4 id="taskorganizationid"></h4>
                    </div>
                    <div class="card-body pt-0">
                        <div class="widget-49">
                            <div class="widget-49-title-wrapper">
                                <div class="widget-49-date-primary">
                                    <span class="widget-49-date-day" id="dayofmonth">09</span>
                                    <span class="widget-49-date-month" id="monthname">apr</span>
                                </div>
                                <div class="widget-49-meeting-info">
                                    <span class="widget-49-pro-title" id="tasktittleid"></span>
                                    <span class="widget-49-meeting-time" id="tasktime"></span>
                                </div>
                            </div>
                            <div class="widget-49-meeting-points">
                               <p id="taskDetailsid"></p>
                            </div>
                            <div class="text-center text-lg-start mt-4 pt-2" style="z-index: 100;">
                      <form action="<?=$page?>?<?=$unique?>=<?=$$unique?>" method="post" enctype="multipart/form-data">
                      <input name="<?=$unique?>" required="" type="hidden" id="<?=$unique?>" value="<?=$$unique;?>" >

                      <button> </button>
                      <input type="text" class=" d-none  form-control form-control-lg " style="margin-top:1em !important;" name="marked_as_done" id="marked_as_done" value="1" >
                      <input type="submit" name="update" id="update" class="btn btn-primary btn-lg" value="Mark as Done"/>
                      <input name="reset" type="button" class="btn btn-danger  btn-lg" id="reset" value="RESET" onclick="parent.location='show_all_tasks.php'">
                    </form>
          </div>
                        </div>
                    </div>
                </div>
            </div>
     
        </div>

      <!-- </div> -->

             
    <!-- </div>  -->
</div>


<script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../../assets/js/popper.min.js"></script>
<script type="text/javascript" src="../../../assets/js/jquery-3.4.1.min.js"></script>
 
<script>
    // JavaScript for generating random colors for data-background and data-color
    document.addEventListener("DOMContentLoaded", function () {
      alert("hhhhhh");
    
        // Define arrays of colors for background and text
        var backgroundColors = ["blue", "green", "yellow", "brown", "purple", "orange"];
        var textColors = ["blue", "green", "yellow", "brown", "purple", "orange"];

        // Select all elements with class 'mycard'
        var cards = document.querySelectorAll('.mycard');

        // Loop through each card
        cards.forEach(function (card) {
            // Generate a random index to select a color from the arrays
            var randomBackgroundIndex = Math.floor(Math.random() * backgroundColors.length);
            var randomTextIndex = Math.floor(Math.random() * textColors.length);

            // Get the random colors
            var randomBackgroundColor = backgroundColors[randomBackgroundIndex];
            var randomTextColor = textColors[randomTextIndex];

            // Set the data-background attribute to the random background color
            card.setAttribute('data-background', randomBackgroundColor);
            // Set the data-color attribute to the random text color
            card.setAttribute('data-color', randomTextColor);

            // Add the random color classes to the card
            card.classList.add('mycard[data-background="' + randomBackgroundColor + '"]');
            card.classList.add('mycard[data-color="' + randomTextColor + '"]');

            // Remove the selected colors from the arrays to avoid duplicates
            backgroundColors.splice(randomBackgroundIndex, 1);
            textColors.splice(randomTextIndex, 1);
        });


    });

    function openModal(taskId, taskName, taskDetails, organization, tasktime, taskdate) {
    console.log(taskId);

    // Create a new Date object using the taskdate string
    const dateObject = new Date(taskdate);

    // Get the month name
    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    const monthName = monthNames[dateObject.getMonth()];

    // Get the day of the week
    const dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    const dayName = dayNames[dateObject.getDay()];
    const dayOfMonth = dateObject.getDate();

    console.log("Month: " + monthName);
    console.log("Day: " + dayOfMonth);
    

    // Display the information in your modal
    document.getElementById('dayofmonth').innerText = dayOfMonth;
    document.getElementById('monthname').innerText = monthName;
    document.getElementById('task_id').value =taskId;
    
    document.getElementById('tasktittleid').innerText = taskName;
    document.getElementById('tasktime').innerText = tasktime;
    document.getElementById('taskorganizationid').innerText = organization;
    document.getElementById('taskDetailsid').innerText = taskDetails;
   
    // Display the month name and day

}


    // JavaScript to handle modal show event


 
</script>




<?
require_once SERVER_CORE."routing/layout.bottom.php";

?>










