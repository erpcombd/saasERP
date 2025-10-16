<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

do_calander('#issue_date');
do_calander('#exp_date');
do_calander('#rec_date');
do_calander('#ins_start_date');
do_calander('#ins_end_date');



// ::::: Edit This Section ::::: 
$unique='task_id';  		// Primary Key of this Database table
$title='Add Task' ; 	// Page Name and Page Title
$page="show_all_tasks.php";		// PHP File Name
$table='crm_task_add_information';		// Database Table Name Mainly related to this page


$crud    =new crud($table);
$$unique = $_GET[$unique];



//for update..................................
if(isset($_POST['update']))
{
$_POST['edit_at']=time();
$_POST['edit_by']=$_SESSION['user']['id'];
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
}
	
	
if(isset($$unique))
{
$condition=$unique."=".$$unique;	
$data=db_fetch_object($table,$condition);
foreach ($data as $key => $value)
{ $$key=$value;}
}	




// ::::: Edit This Section ::::: 
$title='Add Task' ; 
require "../include/custom.php";
$leadid = decrypTS($_GET['leadid']);
echo $activityd = decrypTS($_GET['activityid']);
$orgId=find_a_field('crm_project_lead','organization','id="'.$leadid.'"');

$qryrr = "SELECT * FROM crm_project_org WHERE id = '$orgId'";

$rsltrr = db_query($qryrr);
$rows = mysqli_fetch_object($rsltrr);
$orgname=$rows->name;

//for submit..................................
if(isset($_POST['submit'])) {
    try {
   
        $_POST['entry_at'] = time();
        $_POST['entry_by'] = $_SESSION['user']['id'];
        $crud->insert();
        $type = 1;
        $msg = 'New Entry Successfully Inserted.';
        echo "<script>window.top.location='../info_maker/lead_task_details_show.php?leadid=" . encrypTS($leadid) . "&activityid=" . encrypTS($activityd) . "'</script>";
    } catch (Exception $e) {
        // If an error occurs during insertion, catch the exception and handle it
        $type = 0; // You can set an error type to differentiate from success
        $msg = 'Error occurred while inserting: ' . $e->getMessage(); // Get the error message
    }
}

// Page Name and Page Title
?>

<script type="text/javascript">
  function nav(lkf){document.location.href = '<?=$page?>?<?=$unique?>='+lkf;}
</script>


<style>  

.divider:after,
.divider:before {
content: "";
flex: 1;
height: 1px;
background: #eee;
}
.h-custom {
height: calc(100% - 73px);
}
@media (max-width: 450px) {
.h-custom {
height: 100%;
}
}
</style>

<div class="container-fluid">
  
<!-- Start sticky note -->


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
        /* background-image: url("http://static.tumblr.com/i21wc39/coTmrkw40/shadow.png"); */
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
        /* -webkit-line-clamp: 4; */
        /* Limit to 4 lines */
        /* -webkit-box-orient: vertical; */
        /* overflow: hidden; */
        /* Set vertical orientation */
        /* text-overflow: ellipsis; */
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
    
    .mycard[data-color1="white"] {
        background: #f3f7fa !important;
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
    .mycard[data-color="brown"] .category {
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


    .mycard[data-color="red"] {
    background: #ffcccc;
    }

    .mycard[data-color="teal"] {
    background: #a7e6e3;
    }
    .mycard[data-color="teal"] .description {
    color: #004c4c;
    }
    .mycard[data-color="teal"] .category {
    color: #1aa39c;
    }

    .mycard[data-color="grey"] {
    background: #e6e6e6;
    }
    .mycard[data-color="grey"] .description {
    color: #4d4d4d;
    }
    .mycard[data-color="grey"] .category {
    color: #808080;
    }

    .mycard[data-color="pink"] {
    background: #ffc0cb;
    }
        .mycard[data-color="pink"] .description {
    color: #800080;
    }
    .mycard[data-color="pink"] .category {
    color: #ff69b4;
    }

    .mycard[data-color="cyan"] {
    background: #7fffd4;
    }
    .mycard[data-color="cyan"] .description {
    color: #008b8b;
    }
    .mycard[data-color="cyan"] .category {
    color: #00cccc;
    }
    .mycontent-card {
        margin-top: 30px;
    }

    /* Updated styles for card elements */
    .mycard {
        border-radius: 25px !important; /* Adjust the border-radius for rounded corners */
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1)!important; /* Adjust the box-shadow for a softer shadow effect */
        background-color: #ffffff;
        color: #333333;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
        transition: all 0.3s ease;
    }

    .mycard:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15)!important; /* Adjust the hover box-shadow */
    }

    .myh6 {
        font-size: 1.1em;
        font-weight: bold;
        text-transform: uppercase;
        color: #007bff; /* Blue color for heading */
        margin-bottom: 10px;
    }

    .myh4 {
        font-size: 1.3em;
        font-weight: bold;
        color: #333333; /* Dark color for title */
        margin-bottom: 15px;
    }

    .description {
        font-size: 16px;
        color: #666666; /* Gray color for description */
        line-height: 1.5;
        margin-bottom: 20px;
    }

    .btn-outline-success {
        background-color: #28a745; /* Green color for button */
        color: #ffffff; /* White color for button text */
        border-color: #28a745; /* Green color for button border */
        transition: all 0.3s ease;
    }

    .btn-outline-success:hover {
        background-color: #218838; /* Darker green color on hover */
        border-color: #1e7e34; /* Darker green color for button border on hover */
    }

    .btn-circle.btn-xl {
			width: 80px;
			height: 80px;
			/* padding: 13px 18px; */
			/* border-radius: 60px; */
			text-align: center;
		}
        .fa-2xl{
            padding-top: 50px;
            font-size:70px;
            text-align: center;
        }
    /* .btn-primary{
        background-color:#9bd4e4 !important;
    } */

</style>


<script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>

<div class="container card-stats">


<div class="container bootstrap snippets bootdeys">
            <div class="row">
            <div class="col-md-4 col-sm-6 mycontent-card">
    
    <div class="card-big-shadow ">
        <div class="mycard card-just-text " style="height: 200px">
            <div class="ourcontent justify-content-center">
                <button data-toggle="modal" data-target="#addtaskmodal" style="background-color: transparent; border:none;" ><i class="fa-solid fa-plus fa-2xl"></i></button>
                
            </div>
        </div> <!-- end card -->
    </div>
</div>             

  <?php



$currentDateTime = date("Y-m-d H:i:s");
$sqlTasks = "SELECT * FROM crm_task_add_information WHERE lead_id=$leadid and activity_id=$activityd ORDER BY task_id DESC";
$resultTasks = db_query($sqlTasks);

while ($row = mysqli_fetch_object($resultTasks)) {
?>
<div class="col-md-4 col-sm-6 mycontent-card">
    
    <div class="card-big-shadow">
        <div class="mycard card-just-text"data-background="color" data-color="blue" data-radius="none">
            <div class="ourcontent">
                <h6 class="myh6 category"><?=$row->task_name;?></h6>
                <h4 class="myh4 title"><a href="#"><?=find_a_field('crm_project_org','name','id="'.$row->organization_id.'"');?></a></h4>
                <h4 class="myh4 category"><?=$row->task_date;?></h4>
                <h4 class="myh4 category"><?=$row->task_time;?></h4>
                <p class="description"><?=$row->task_details;?> </p>
                <button type="button" class="btn btn-outline-success" data-toggle="modal"
                        data-target="#exampleModalCenter"
                        data-task-id="<?=$row->task_id;?>"
                        data-task-name="<?=$row->task_name;?>"
                        data-task-details="<?=$row->task_details;?>"
                        onclick="openModal('<?=$row->task_id;?>', '<?=$row->task_name;?>', '<?=$row->task_details;?>')">
                         Show More
                </button>
            </div>
        </div> <!-- end card -->
    </div>
</div>
<?php } ?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Define arrays of colors for background and text (excluding white)
    var backgroundColors = ["blue", "green", "yellow", "brown", "purple",  "cyan", "pink", "grey"];
    var textColors = ["blue", "green", "yellow", "brown", "purple",  "cyan", "pink", "grey"];

    // Select all elements with class 'mycard'
    var cards = document.querySelectorAll('.mycard');

    // Set the first card to have a white background
    cards[0].setAttribute('data-background', 'white');
    cards[0].setAttribute('data-color', 'black'); // You can set the text color as well

    // Loop through each card starting from the second one
    for (var i = 1; i < cards.length; i++) {
        // Generate a random index to select a color from the arrays
        var randomBackgroundIndex = Math.floor(Math.random() * backgroundColors.length);
        var randomTextIndex = Math.floor(Math.random() * textColors.length);

        // Get the random colors
        var randomBackgroundColor = backgroundColors[randomBackgroundIndex];
        var randomTextColor = textColors[randomTextIndex];

        // Set the data-background attribute to the random background color
        cards[i].setAttribute('data-background', randomBackgroundColor);
        // Set the data-color attribute to the random text color
        cards[i].setAttribute('data-color', randomTextColor);

        // Add the random color classes to the card
        cards[i].classList.add('mycard[data-background="' + randomBackgroundColor + '"]');
        cards[i].classList.add('mycard[data-color="' + randomTextColor + '"]');
    }
});

function openModal(taskId, taskName, taskDetails) {
    console.log(taskId, taskName, taskDetails);
    document.getElementById('tasktittleid').innerText = taskName;
    document.getElementById('exampleDetailsid').innerText = 'Task Details: ' + taskDetails;
}


    // JavaScript to handle modal show event
</script>




<!-- End Sticky note -->




</div>





















<!-- Sticky note model -->

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold fw-10 w-100 p-1" style="height:30px !important; font-size: 24px !important" id="tasktittleid"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body shadow rounded m-3  ">
                    <p  id="exampleDetailsid"></p>
                </div>
                <div class="modal-footer">
                <!-- <button type="button" class="btn btn-primary">Mark as Done</button> -->
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- add task modal -->

<div class="modal fade " id="addtaskmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  
<div class="modal-dialog" role="document">
<div class="modal-content w-100">

<div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Task </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

<div class="modal-body m-3  ">
                        <form action="" method="post" enctype="multipart/form-data">
                        

                            <div class="form-outline mb-2">
                        
                                <input name="task_name" id="task_name" value="" type="text"  class="form-control form-control-lg"
                                placeholder="Enter your task name" />
                            
                            </div>

                            <input type="hidden" name="lead_id" id="lead_id" value="<?=$leadid?>" />
                            <input type="hidden" name="activity_id" id="activity_id" value="<?=$activityd?>" />
                            <div class="form-outline mb-3">

                                <select class="form-control form-control-lg ">
                                    <option value="<?=$orgname?>"><?=$orgname?></option>
                                                <!-- <? //foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id');?> -->
                                    </select>
                            
                            </div>

                                <div class="form-outline mb-2">
                                
                                    <textarea style=" font-size: 14px;"  class="form-control form-control-lg  mb-2"  type="text"  name="task_details" id="task_details" cols="30" rows="5" placeholder="Tasks Details"></textarea>
                                
                                </div>

                            
                            <div class="form-outline mt-4 mb-2">
                            <label for="">Enter task date</label>
                            <input type="date" class="form-control form-control-lg " style="margin-top:1em !important;" name="task_date" id="task_date"   placeholder="Subject">
                            
                            </div>
                            <div class="form-outline mb-2">
                            <label for="">Enter task Time</label>
                            <input type="time" class="form-control form-control-lg " style="margin-top:1em !important;" name="task_time" id="task_time"   placeholder="Subject">
                            
                            </div>
                            <div class="form-outline mb-2">
                            <label for="">Enter Remainder Date</label>
                            <input type="date" class="form-control form-control-lg " style="margin-top:1em !important;" name="reaminder_start_date" id="reaminder_start_date"   placeholder="Subject">
                            
                            </div>
                            <div class="form-outline mb-2">

                            <label for="">Enter Remainder Time</label>
                            <input type="time" class="form-control form-control-lg " style="margin-top:1em !important;" name="reaminder_start_time" id="reaminder_start_time"   placeholder="Subject">
                            
                            </div>

                    
                    
                        
                        

                            <div class="text-center text-lg-start mt-4 pt-2">

                            
                    
                            <input type="submit" name="submit" id="submit" class="btn btn-primary btn-lg"/>
                            <!-- <input name="reset" type="button" class="btn btn-danger  btn-lg" id="reset" value="RESET" onclick="parent.location='show_all_tasks.php'"> -->
             

                            </div>

                            </form>
                        </div>
                        </div>
                    </div>

                    </section>
                    </div>
 
</div>






<!-- 
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
 



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>