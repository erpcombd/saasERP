<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Add Task' ; 	// Page Name and Page Title
?>


<!-- <style>
  
  .card-body{
    background-color: #FAF9F6;
  }
</style> -->

<!-- 


                <div class="card shadow border-0 mb-7">
                    <div class="card-header">
                        <h5 class="mb-0">Applications</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Company</th>
                                    <th scope="col">Offer</th>
                                    <th scope="col">Meeting</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        
                                        <a class="text-heading font-semibold" href="#">
                                            Robert Fox
                                        </a>
                                    </td>
                                    <td>
                                        Feb 15, 2021
                                    </td>
                                    <td>
                                        
                                        <a class="text-heading font-semibold" href="#">
                                            Dribbble
                                        </a>
                                    </td>
                                    <td>
                                        $3.500
                                    </td>
                                    <td>
                                        <span class="badge badge-lg badge-dot">
                                            <i class="bg-success"></i>Scheduled
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-neutral">View</a>
                                        <button type="button" class="btn btn-sm btn-square btn-neutral text-danger-hover">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       
                                        <a class="text-heading font-semibold" href="#">
                                            Darlene Robertson
                                        </a>
                                    </td>
                                    <td>
                                        Apr 15, 2021
                                    </td>
                                    <td>
                                        
                                        <a class="text-heading font-semibold" href="#">
                                            Netguru
                                        </a>
                                    </td>
                                    <td>
                                        $2.750
                                    </td>
                                    <td>
                                        <span class="badge badge-lg badge-dot">
                                            <i class="bg-warning"></i>Postponed
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-neutral">View</a>
                                        <button type="button" class="btn btn-sm btn-square btn-neutral text-danger-hover">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        
                                        <a class="text-heading font-semibold" href="#">
                                            Theresa Webb
                                        </a>
                                    </td>
                                    <td>
                                        Mar 20, 2021
                                    </td>
                                    <td>
                                        
                                        <a class="text-heading font-semibold" href="#">
                                            Figma
                                        </a>
                                    </td>
                                    <td>
                                        $4.200
                                    </td>
                                    <td>
                                        <span class="badge badge-lg badge-dot">
                                            <i class="bg-success"></i>Scheduled
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-neutral">View</a>
                                        <button type="button" class="btn btn-sm btn-square btn-neutral text-danger-hover">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        
                                        <a class="text-heading font-semibold" href="#">
                                            Kristin Watson
                                        </a>
                                    </td>
                                    <td>
                                        Feb 15, 2021
                                    </td>
                                    <td>
                                        
                                        <a class="text-heading font-semibold" href="#">
                                            Mailchimp
                                        </a>
                                    </td>
                                    <td>
                                        $3.500
                                    </td>
                                    <td>
                                        <span class="badge badge-lg badge-dot">
                                            <i class="bg-dark"></i>Not discussed
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-neutral">View</a>
                                        <button type="button" class="btn btn-sm btn-square btn-neutral text-danger-hover">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        
                                        <a class="text-heading font-semibold" href="#">
                                            Cody Fisher
                                        </a>
                                    </td>
                                    <td>
                                        Apr 10, 2021
                                    </td>
                                    <td>
                                        
                                        <a class="text-heading font-semibold" href="#">
                                            Webpixels
                                        </a>
                                    </td>
                                    <td>
                                        $1.500
                                    </td>
                                    <td>
                                        <span class="badge badge-lg badge-dot">
                                            <i class="bg-danger"></i>Canceled
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-neutral">View</a>
                                        <button type="button" class="btn btn-sm btn-square btn-neutral text-danger-hover">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        
                                        <a class="text-heading font-semibold" href="#">
                                            Robert Fox
                                        </a>
                                    </td>
                                    <td>
                                        Feb 15, 2021
                                    </td>
                                    <td>
                                        
                                        <a class="text-heading font-semibold" href="#">
                                            Dribbble
                                        </a>
                                    </td>
                                    <td>
                                        $3.500
                                    </td>
                                    <td>
                                        <span class="badge badge-lg badge-dot">
                                            <i class="bg-success"></i>Scheduled
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-neutral">View</a>
                                        <button type="button" class="btn btn-sm btn-square btn-neutral text-danger-hover">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        
                                        <a class="text-heading font-semibold" href="#">
                                            Darlene Robertson
                                        </a>
                                    </td>
                                    <td>
                                        Apr 15, 2021
                                    </td>
                                    <td>
                                        
                                        <a class="text-heading font-semibold" href="#">
                                            Netguru
                                        </a>
                                    </td>
                                    <td>
                                        $2.750
                                    </td>
                                    <td>
                                        <span class="badge badge-lg badge-dot">
                                            <i class="bg-warning"></i>Postponed
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-neutral">View</a>
                                        <button type="button" class="btn btn-sm btn-square btn-neutral text-danger-hover">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        
                                        <a class="text-heading font-semibold" href="#">
                                            Theresa Webb
                                        </a>
                                    </td>
                                    <td>
                                        Mar 20, 2021
                                    </td>
                                    <td>
                                        
                                        <a class="text-heading font-semibold" href="#">
                                            Figma
                                        </a>
                                    </td>
                                    <td>
                                        $4.200
                                    </td>
                                    <td>
                                        <span class="badge badge-lg badge-dot">
                                            <i class="bg-success"></i>Scheduled
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-neutral">View</a>
                                        <button type="button" class="btn btn-sm btn-square btn-neutral text-danger-hover">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        
                                        <a class="text-heading font-semibold" href="#">
                                            Kristin Watson
                                        </a>
                                    </td>
                                    <td>
                                        Feb 15, 2021
                                    </td>
                                    <td>
                                        
                                        <a class="text-heading font-semibold" href="#">
                                            Mailchimp
                                        </a>
                                    </td>
                                    <td>
                                        $3.500
                                    </td>
                                    <td>
                                        <span class="badge badge-lg badge-dot">
                                            <i class="bg-dark"></i>Not discussed
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-neutral">View</a>
                                        <button type="button" class="btn btn-sm btn-square btn-neutral text-danger-hover">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <button type="button" class="btn btn-light">
                                          <i class="">

                                          </i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        
                                        <a class="text-heading font-semibold" href="#">
                                            Cody Fisher
                                        </a>
                                    </td>
                                    <td>
                                        Apr 10, 2021
                                    </td>
                                    <td>
                                        
                                        <a class="text-heading font-semibold" href="#">
                                            Webpixels
                                        </a>
                                    </td>
                                    <td>
                                        $1.500
                                    </td>
                                    <td>
                                        <span class="badge badge-lg badge-dot">
                                            <i class="bg-danger"></i>Canceled
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-neutral">View</a>
                                        <button type="button" class="btn btn-sm btn-square btn-neutral text-danger-hover">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer border-0 py-5">
                        <span class="text-muted text-sm">Showing 10 items out of 250 results found</span>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>




 -->
<style>

.card1 {
  position: relative;
  width: 250px;
  padding: 20px;
  box-shadow: 3px 10px 20px rgba(0, 0, 0, 0.2);
  border-radius: 3px;
  border: 0;
  margin:15px;

}
.content1 {
    padding: 2px;
    display: flex;
    flex-direction: column;
  }


  /* #00d4ff */


  .company-info {

    padding: 20px;
    border-radius: 10px;
}

.company-info h2 {
    font-size: 24px !important; /* Increased font size */
            font-weight: bold; /* Made the text bold */

    color: #007bff;
    
}

.office-address {
    background-color: #e6f7ff;
    padding: 10px;
    border-radius: 5px;
}

.office-address h3 {
    
    color: #007bff;
}

.office-address a {
    color: #007bff;
    text-decoration: none;
}


.officetype{
   
    padding: 5px;
    border-radius: 5px;
}

.card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
            max-width: 600px;
            transition: box-shadow 0.3s ease;
        }
        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

</style>


<div class="container-fluid">
    <div class="row">
      <div class="col-md-3">
        <!-- Content for the first column -->
        <div class="card p-3 ">
            <div class="title">
            <div class="d-flex justify-content-end"> <i class="fa-solid fa-pen-to-square"></i></div>
                    <h1 class="myh6">Company Name</h1>
                    <h2>"Contact Information"</h2>

                    
            </div>
            <div class="content1">
                <h1 class="d-flex justify-content-center p-2 "style="background-color: #D8F0FA;" >Person -1</h1>
                    <div class="social">
                        <h1>Designation:</h1>
                        <h1>Department: HR</h1>
                        <h1><span><i class="fa-solid fa-phone"></i> </span>Phone Number :+018000000000</h1>
                    </div>
                    <div class="social">
                        
                        <h1><span><i class="fa-solid fa-envelope"></i> </span>Email :123@gmail.com</h1>
                    </div>
                    <div class="circle"></div>
            </div>
            <div class="content1">
                <h1>Person -1</h1>
                    <div class="social">
                        
                        <h1><span><i class="fa-solid fa-phone"></i> </span>Phone Number :+018000000000</h1>
                    </div>
                    <div class="social">
                        
                        <h1><span><i class="fa-solid fa-envelope"></i> </span>Email :123@gmail.com</h1>
                    </div>
                    <div class="circle"></div>
                    
                    <div class="d-flex justify-content-center p-3">
        <a class="btn btn-sm btn-info mr-2" href="'">Add New</i></a>
        </div>
            </div>
        </div>
      </div>
      <div class="col-md-6">
        <!-- Content for the first column -->
<div class="card">
        
        <div class="company-info">
            <p class="myh6 d-flex justify-content-center" style="background-color: #D8F0FA;">Company: Abc Ashraf Organization</p>
            <p style="font-size: 15px !important;"><i class="fa-solid fa-magnifying-glass-arrow-right"></i> Source: Referred by someone</p>
            <div class="circle" ></div>
            <div class="officetype">
            <p style="font-size: 15px !important;"><i class="fa-solid fa-industry"></i> Work Field: Ad Agency</p>
            <p style="font-size: 15px !important;"><i class="fa-solid fa-coins"></i> Revenue: $10,000.00/year</p>
            <p style="font-size: 15px !important;"><i class="fa-solid fa-users"></i> Total Employee(s): 100</p>
            </div>

            <div class="circle"></div>
            
            <div class="office-address">
            
                <h3 style="font-size: 30px;"> Office Address</h3>
                <p style="font-size: 15px !important;"><i class="fa-solid fa-briefcase"></i>  Address: Mirpur DOHS, Dhaka Cantonment TSO-1206, Bangladesh</p>
                <p style="font-size: 15px !important;"><i class="fa-solid fa-globe"></i> <a href=""></a> Website:abc@gmail.com</p>
            </div>
            <div class="circle"></div>
        </div>


</div>




        <!-- end Content for the first column -->
      </div>
      <div class="col-md-3">
        <!-- Content for the first column -->

        <div class="card" >
            <div class="card-header">
            <div class=" d-flex justify-content-end"> <i class="fa-solid fa-pen-to-square"></i></div>
                 Product List
            </div>
                <ul class="list-group">
                <li class="list-group-item">Cras justo odio</li>
                <div class="circle"></div>
                <li class="list-group-item">Dapibus ac facilisis in</li>
                <div class="circle"></div>
                <li class="list-group-item">Morbi leo risus</li>
                <div class="circle"></div>
                <li class="list-group-item">Porta ac consectetur ac</li>
                <div class="circle"></div>
                <li class="list-group-item">Vestibulum at eros</li>
                <div class="circle"></div>
                </ul>
                <div class="d-flex justify-content-center p-3">
        <a class="btn btn-sm btn-info mr-2" href="'">Add New</i></a>
        </div>
        </div>

        
        <!-- end Content for the first column -->
      </div>
    </div>
</div>


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
        font-size: 2.5em;
        font-weight: 1000;
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

    .mycard[data-color="orange"] {
        background: #ff8f5e;
    }
    .mycard[data-color="orange"] .description {
        color: #772510;
    }
    .mycard[data-color="orange"] .category {
        color: #e95e37;
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
</style>

<script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>

<div class="container card-stats"">
    <div class="container bootstrap snippets bootdeys">
            <div class="row">
                <?php
                $currentDateTime = date("Y-m-d H:i:s");
                $sqlTasks = "SELECT * FROM crm_lead_activity a WHERE lead_id = 4;";
                $resultTasks = db_query($sqlTasks);

                while ($row = mysqli_fetch_object($resultTasks)) {
                ?>

        <div class="col-md-4 col-sm-6 mycontent-card">
            <div class="card-big-shadow">
                <div class="mycard card-just-text" data-background="color" data-color="blue" data-radius="none">
                    <div class="ourcontent">
                        <h6 class="myh6 category"><?=$row->activity_type;?></h6>
                        <!-- <h4 class="myh4 title"><a href="#"><?=find_a_field('crm_project_org','name','id="'.$row->organization_id.'"');?></a></h4> -->
                        <h4 class="myh4 category"><?=$row->date;?></h4>
                        <h4 class="myh4 category"><?=$row->time;?></h4>
                        <p class="description"><?=$row->details;?> </p>

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
    </div>
</div>
<script>
    // JavaScript for generating random colors for data-background and data-color
    document.addEventListener("DOMContentLoaded", function () {
        // Define arrays of colors for background and text
        var backgroundColors = ["blue", "green", "yellow", "brown", "purple", "orange", "cyan", "pink", "grey"];
        var textColors = ["blue", "green", "yellow", "brown", "purple", "orange", "cyan", "pink", "grey"];

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

        });
    });

    function openModal(taskId, taskName, taskDetails) {
        console.log(taskId, taskName, taskDetails)
        document.getElementById('tasktittleid').innerText = taskName;
        // document.getElementById('task-id').innerText = 'Task ID: ' + taskId;
        // document.getElementById('task-name').innerText = 'Task Name: ' + taskName;
        document.getElementById('exampleDetailsid').innerText = 'Task Details: ' + taskDetails;
    }

    // JavaScript to handle modal show event
</script>




<!-- End Sticky note -->


</div>































<!-- <style>
    

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
 -->


<!-- <div class="container-fluid ">
<section class="vh-100">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
          class="img-fluid" alt="Sample image">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form>
          <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
            <p class="lead fw-normal mb-0 me-3">Sign in with</p>
            <button type="button" class="btn btn-primary btn-floating mx-1">
              <i class="fab fa-facebook-f"></i>
            </button>

            <button type="button" class="btn btn-primary btn-floating mx-1">
              <i class="fab fa-twitter"></i>
            </button>

            <button type="button" class="btn btn-primary btn-floating mx-1">
              <i class="fab fa-linkedin-in"></i>
            </button>
          </div>

          <div class="divider d-flex align-items-center my-4">
            <p class="text-center fw-bold mx-3 mb-0">Or</p>
          </div> -->

          <!-- Email input -->
          <!-- <div class="form-outline mb-4">
            <input type="email" id="form3Example3" class="form-control form-control-lg"
              placeholder="Enter a valid email address" />
            <label class="form-label" for="form3Example3">Email address</label>
          </div> -->

          <!-- Password input -->
          <!-- <div class="form-outline mb-3">
            <input type="password" id="form3Example4" class="form-control form-control-lg"
              placeholder="Enter password" />
            <label class="form-label" for="form3Example4">Password</label>
          </div> -->

          <!-- <div class="d-flex justify-content-between align-items-center"> -->
            <!-- Checkbox -->
            <!-- <div class="form-check mb-0">
              <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
              <label class="form-check-label" for="form2Example3">
                Remember me
              </label>
            </div>
            <a href="#!" class="text-body">Forgot password?</a>
          </div> -->

          <!-- <div class="text-center text-lg-start mt-4 pt-2">
            <button type="button" class="btn btn-primary btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
            <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="#!"
                class="link-danger">Register</a></p>
          </div>

        </form>
      </div>
    </div>
  </div>
  <div
    class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary"> -->
    <!-- Copyright -->
    <!-- <div class="text-white mb-3 mb-md-0">
      Copyright © 2020. All rights reserved.
    </div> -->
    <!-- Copyright -->

    <!-- Right -->
    <!-- <div>
      <a href="#!" class="text-white me-4">
        <i class="fab fa-facebook-f"></i>
      </a>
      <a href="#!" class="text-white me-4">
        <i class="fab fa-twitter"></i>
      </a>
      <a href="#!" class="text-white me-4">
        <i class="fab fa-google"></i>
      </a>
      <a href="#!" class="text-white">
        <i class="fab fa-linkedin-in"></i>
      </a>
    </div> -->
    <!-- Right -->
  <!-- </div>
</section>


</div>
 -->









    <!-- Modal -->
    <!-- <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Task title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni quasi iste consequatur aliquid,
                        aperiam libero pariatur blanditiis numquam quod quia minima fugit mollitia animi itaque
                        reiciendis
                        maxime, nesciunt dolorem minus? Dolorem expedita quidem odio aliquid nihil voluptatibus iure
                        aperiam
                        fugiat? Deleniti doloribus perspiciatis quidem, debitis asperiores quia cum consectetur enim
                        nobis
                        voluptatem dolores, libero aperiam consequatur nostrum ducimus pariatur nesciunt laborum
                        assumenda
                        non veniam. Consectetur molestias saepe veniam id aliquam a tempora quas. Sed consectetur,
                        temporibus ab praesentium libero magni? Est, excepturi quos quo repellendus expedita reiciendis.
                        Eligendi, rerum quis non dolor placeat a? Exercitationem nobis a sed quas quidem.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Mark as Done</button>
                </div>
            </div>
        </div>
    </div> -->





  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
 



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>