<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Add Task' ; 	// Page Name and Page Title
?>



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
        -webkit-line-clamp: 4;
        /* Limit to 4 lines */
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
                <a style="color: black !important" href="/crm_mod/pages/task_management/show_all_tasks.php"><i class="fa-solid fa-circle-plus fa-2xl" ></i></a>
                
            </div>
        </div> <!-- end card -->
    </div>
</div>             

  <?php



$currentDateTime = date("Y-m-d H:i:s");
$sqlTasks = "SELECT * FROM crm_task_add_information WHERE CONCAT(reaminder_start_date, ' ', reaminder_start_time) <= '$currentDateTime'";
$resultTasks = db_query($sqlTasks);

while ($row = mysqli_fetch_object($resultTasks)) {
?>
<div class="col-md-4 col-sm-6 mycontent-card">
    
    <div class="card-big-shadow">
        <div class="mycard card-just-text"data-background="color" data-color="blue" data-radius="none">
            <div class="ourcontent">
                <h6 class="myh6 category"><?=$row->task_name;?></h6>
                <h4 class="myh4 title"><a href="#"><?=find_a_field('crm_project_org','name','id="'.$row->organization_id.'"');?></a></h4>
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
                <button type="button" class="btn btn-primary">Mark as Done</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    
                </div>
            </div>
        </div>
    </div>










<!-- 
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
 



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>