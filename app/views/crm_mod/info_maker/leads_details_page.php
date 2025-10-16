<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title = "Lead Info";
$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);
do_calander('#date');

 $cur = '&#x9f3;';

 $table1 = 'crm_project_lead';
 $tablecontact = 'crm_lead_contacts';
 $tableproductadd = 'crm_lead_product_individual';

 $uniqueproduct="product_individual_id";



 $crudcontact1 = new crud($tablecontact);
 $crudproductadd1 = new crud($tableproductadd);

 $pbi_id  =  $_SESSION['employee_selected'];
 $user_role  =  $_SESSION['user']['fname'];


 $table2 = 'crm_task_lists';
 require "../include/custom.php";

 echo $id = decrypTS($_GET['view']);
 $orgId=find_a_field('crm_project_lead','organization','id="'.$id.'"');

 $qryrr = "SELECT * FROM crm_lead_manage WHERE lead_id = '$id'";

 $rsltrr = db_query($qryrr);
 $rows = mysqli_fetch_object($rsltrr);
 $orgname=$rows->company_name;

 echo $type = decrypTS($_GET['tp']);
$condition="id=".$id;
$data=db_fetch_object('crm_project_lead',$condition);
foreach($data as $key=>$value)
{ $$key=$value;}




if(isset($_POST['insertconverttolead'])){

  $table1 = 'crm_project_lead';
$crud1 = new crud($table1);
$_POST['entry_at']=date('Y-m-d h:i:sa');
$_POST['entry_by'] = $_SESSION['user']['id'];
$log_id=$crud1->insert();

$cd= new crud('crm_lead_log');
 $_POST['lead_id']=$log_id;
 $cd->insert(); 	

 echo "<script>window.top.location='/crm_mod/home/leads.php.php'<script>";
}





if(isset($_POST['contactSubmit']))
{
$_POST['entry_at']=time();
$_POST['entry_by']=$_SESSION['user']['id'];
		$crudcontact1->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';
		 echo "<script>window.top.location='../info_maker/leads_details_page.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
}



$tabletask='crm_task_add_information';		
$crudtask    =new crud($tabletask);		

if(isset($_POST['insertTasks']))
{

$_POST['entry_at']=time();
$_POST['entry_by']=$_SESSION['user']['id'];
		$crudtask->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';
        echo "<script>window.top.location='../info_maker/leads_details_page.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";


}






if (isset($_POST['scCall'])) {

	$crud   = new crud('crm_lead_activity_manage');
	$_POST['entry_by'] = $_SESSION['user']['id'];
	$_POST['entry_at'] = date("Y-m-d H:i:s");
	$crud->insert();

	

	echo "<script>window.top.location='../info_maker/leads_details_page.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";

}
if(isset($_POST['updatecontact']))
{


$_POST['edit_at']=time();
$_POST['edit_by']=$_SESSION['user']['id'];
		$crudcontact1->update('id');
		$type=1;
		$msg='Successfully Updated.';
        echo "<script>window.top.location='../info_maker/leads_details_page.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
}


if(isset($_POST['updateTasks']))
{

    $crud   = new crud('crm_task_add_information');
        $_POST['edit_at']=time();
        $_POST['edit_by']=$_SESSION['user']['id'];
        $crud->update('task_id');
		$type=1;
		$msg='Successfully Updated.';
         echo "<script>window.top.location='../info_maker/leads_details_page.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
}



if(isset($_POST['updatestatus']))
{
    $crud= new crud('crm_lead_activity_manage');
    $crud->update('id');
    // echo $product_individual_id = $_POST['id'];
    // echo $leadstatus=$_POST['id']

        
    // $deletesql = "DELETE FROM crm_lead_product_individual WHERE product_individual_id = " . $product_individual_id;
    // db_query($deletesql);

     echo "<script>window.top.location='../info_maker/leads_details_page?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
}
if(isset($_POST['cancelActivity']))
{

    $crud   = new crud('crm_lead_activity_manage');
        $_POST['edit_at']=time();
        $_POST['edit_by']=$_SESSION['user']['id'];
        $crud->update('activity_id');
		$type=1;
		$msg='Successfully Updated.';
         echo "<script>window.top.location='../info_maker/leads_details_page.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
}


if(isset($_POST['productadd']))
{

$_POST['entry_at']=time();
$_POST['entry_by']=$_SESSION['user']['id'];
		$crudproductadd1->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';

        echo "<script>window.top.location='../info_maker/leads_details_page.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";

 
}



if(isset($_POST['deleteproduct']))
{
       
        $product_individual_id = $_POST['product_individual_id'];
        $deletesql = "DELETE FROM crm_lead_product_individual WHERE product_individual_id = " . $product_individual_id;
        db_query($deletesql);
        $tr_type = "Delete";
        $type = 1;
        $msg = 'Successfully Deleted.';
        echo "<script>window.top.location='../info_maker/leads_details_page.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";


}



$tabletask='crm_task_add_information';		
$crudtask    =new crud($tabletask);		

if(isset($_POST['insertTasks']))
{

$_POST['entry_at']=time();
$_POST['entry_by']=$_SESSION['user']['id'];
		$crudtask->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';
        echo "<script>window.top.location='../info_maker/leads_details_page.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";


}

?>


<script>


                        document.addEventListener("DOMContentLoaded", function () {
                            // Define arrays of colors for background and text (excluding white)
                            var backgroundColors = ["blue", "green", "yellow", "brown", "purple",  "cyan", "pink", "grey"];
                            var textColors = ["blue", "green", "yellow", "brown", "purple",  "cyan", "pink", "grey"];
                        
                            // Select all elements with class 'mycard'
                            var cards = document.querySelectorAll('.mycard');
                        
                            // // Set the first card to have a white background
                            // cards[0].setAttribute('data-background', 'white');
                            // cards[0].setAttribute('data-color', 'black'); // You can set the text color as well
                        
                            // Loop through each card starting from the second one
                            for (var i = 0; i < cards.length; i++) {
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
                        
                                
                        
                            function openModalcontact(contactId, contactName, contactphone,contactemail,contactdesignation) {
                                console.log(contactId, contactName, contactphone,contactemail,contactdesignation)
                                // document.getElementById('id').value = contactId;
                                document.getElementById('contactsave').classList.add('d-none');// or 'inline' depending on your styling
                                document.getElementById('contactedit').classList.remove('d-none');// or 'inline' depending on your styling
                                document.getElementById('contact_name').value = contactName;
                                document.getElementById('contact_phone').value = contactphone;
                                document.getElementById('contact_email').value = contactemail;
                                document.getElementById('contact_designation').value = contactdesignation;
                                
                                var idInput = document.createElement('input');
                                idInput.setAttribute('type', 'hidden');
                                idInput.setAttribute('name', 'id');
                                idInput.setAttribute('id', 'id');
                                idInput.setAttribute('value', contactId);
                        
                                // Append the id input field to the form using the form's ID
                                var form = document.getElementById('contactformidnew');
                                form.appendChild(idInput);
                        
                            }
                            function openModalproduct(productId, productName) {
                                console.log(productId)
                                document.getElementById('product_individual_id').value = productId;
                             // or 'inline' depending on your 
                        
                            }
                            function openModalcancelmeeting(activityId) {
                                console.log(activityId)
                                document.getElementById('activity_id').value = activityId;
                             // or 'inline' depending on your 
                        
                        
                            }
							
							
						 function openModalUpdateTask(taskId) {
							console.log(taskId)
							document.getElementById('task_id').value = taskId;
						 // or 'inline' depending on your 
					      }
                        
                            function openModalfortask(taskId, taskName, taskDetails,taskDate,taskTime) {
                            console.log(taskId, taskName, taskDetails,taskDate,taskTime);
                            document.getElementById('tasktittleid').innerText = taskName;
                            document.getElementById('exampleDetailsid').innerText = 'Task Details: ' + taskDetails;
                        	document.getElementById('exampleDateid').innerText = 'Task Date: ' + taskDate;
                        	document.getElementById('exampleTimeid').innerText = 'Task Time: ' + taskTime;
                        }
                            function openModalStatusUpdate(statusid) {
                                console.log(statusid);
                                var selectElement = document.getElementById('status');
                                console.log(selectElement);
                        // Check if the correct select element is found
                        for (var i = 0; i < selectElement.options.length; i++) {
                            // Check the value of each option
                            if (selectElement.options[i].value == statusid) {
                                selectElement.options[i].selected = true;
                                break;
                            }
                        }
                            document.getElementById('tasktittleid').innerText = taskName;
                            document.getElementById('exampleDetailsid').innerText = 'Task Details: ' + taskDetails;
                        
                        }
                        
                        
                            // JavaScript to handle modal show event
                 
                  

</script>


     <style>
        body{
        		zoom:90%;}
        		.modal-open {
        			zoom: 100%;
        		}
        		.sidebar, .sidemenu{
        			display:none;
        			width: 0% !important;
        		}
        		
        		.main_content{
        			width: 100% !important;
        		}
        		
        		.p{
        			margin: 0px;
        			font-weight: 600;
        			text-transform: capitalize;
        		}
        		
        		
        		.p strong{
        			font-weight: 700;
        		}
        		
        		.p i{
        		font-size: 13px;
        		margin-right: 5px;
        		}
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
        		
        			padding: 0px;
        			border-radius: 10px;
        		}
        		
        		.company-info h2 {
        			font-size: 24px; /* Increased font size */
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
        		
        		.office-address a:hover {
        			text-decoration: underline;
        		}
        		
        			/* Style for the contact form container */
        			.contact-form {
        			  max-width: 400px;
        			  margin: 0 auto;
        			}
        		
        			/* Style for the scrollable div */
        			.scrollable-div {
        			  max-height: 535px; /* Set a fixed height for the scrollable div */
        			  overflow-y: auto; /* Enable vertical scrolling */
        			  border: 1px solid #ccc;
        			  padding: 10px;
        			  scrollbar-width: thin;
        			  scrollbar-color: transparent transparent;
        			}
        			.scrollable-activity {
        			  max-height: 90%; /* Set a fixed height for the scrollable div */
        			  overflow-x: auto; /* Enable vertical scrolling */
        		
        			  scrollbar-width: thin;
        			  scrollbar-color: transparent transparent;
        			}
        			.scrollable-div-product{
					
        			  max-height: 535px; /* Set a fixed height for the scrollable div */
        			  overflow-y: auto; /* Enable vertical scrolling */
        			  border: 1px solid #ccc;
        			  padding: 10px;
        			  scrollbar-width: thin;
        			  scrollbar-color: transparent transparent;
        			}
        		  .floatingshadowfahim{
        			/* box-shadow: 0px 3px 9px 1px rgba(0, 10, 20, 0.2); */
        			/* box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.05) 0px 4px 6px -2px; */
        			box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
        			background-color: #f3f7fa !important;
        		  }
        		  .unplashscreen{
        			/* background-color: whitesmoke; */
        			/* background-image: url("bgunsplash3.jpg");
        			background-size: cover; */
        		  }
        		@import url("https://fonts.googleapis.com/css?family=Montserrat:900");
        		
        		#wrapper {
        		  box-sizing: border-box;
        		  display: flex;
        		  align-items: center;
        		  justify-content: center;
        		}
        		.my-super-cool-btn {
        		  position: relative;
        		  text-decoration: none;
        		  color: #fff;
        		  letter-spacing: 1px;
        		  font-size: 2rem;
        		  box-sizing: border-box;
        		}
        		.my-super-cool-btn span {
        		  position: relative;
        		  box-sizing: border-box;
        		  display: flex;
        		  align-items: center;
        		  justify-content: center;
        		  width: 200px;
        		  height: 200px;
        		}
        		.my-super-cool-btn span:before {
        		  content: "";
        		  width: 100%;
        		  height: 100%;
        		  display: block;
        		  position: absolute;
        		  border-radius: 100%;
        		  border: 7px solid #f3cf14;
        		  box-sizing: border-box;
        		  transition: all 0.85s cubic-bezier(0.25, 1, 0.33, 1);
        		  box-shadow: 0 30px 85px rgba(0, 0, 0, 0.14), 0 15px 35px rgba(0, 0, 0, 0.14);
        		}
        		.my-super-cool-btn:hover span {
        			font-size: 12px !important;
        		}
        		.my-super-cool-btn:hover p {
        			font-size: 12px !important;
        		}
        		.my-super-cool-btn:hover span:before {
        		
        		  transform: scale(0.8);
        		  box-shadow: 0 20px 55px rgba(0, 0, 0, 0.14), 0 15px 35px rgba(0, 0, 0, 0.14);
        		}
        		.my-super-cool-btn .dots-container {
        		  opacity: 0;
        		  animation: intro 1.6s;
        		  animation-fill-mode: forwards;
        		}
        		.my-super-cool-btn  .dot {
        		  width: 8px;
        		  height: 8px;
        		  display: block;
        		  background-color: #f3cf14;
        		  border-radius: 100%;
        		  position: absolute;
        		  transition: all 0.85s cubic-bezier(0.25, 1, 0.33, 1);
        		}
        		.my-super-cool-btn .btn-1 .dot {
        			background-color: red;
        		}
        		
        		.my-super-cool-btn .dot:nth-child(1) {
        		  top: 50px;
        		  left: 50px;
        		  transform: rotate(-140deg);
        		  animation: swag1-out 0.3s;
        		  animation-fill-mode: forwards;
        		  opacity: 0;
        		}
        		.my-super-cool-btn.btn-1 span:before {
        		  border: 7px solid #cadeef; /* Yellow */
        		}
        		
        		.my-super-cool-btn.btn-2 span:before {
        		  border: 7px solid #9394a5; /* Green */
        		}
        		
        		.my-super-cool-btn.btn-3 span:before {
        		  border: 7px solid #6bbf59; /* Blue */
        		}
        		
        		.my-super-cool-btn.btn-4 span:before {
        		  border: 7px solid #FFB996; /* Red */
        		}
        		.my-super-cool-btn .dot:nth-child(2) {
        		  top: 50px;
        		  right: 50px;
        		  transform: rotate(140deg);
        		  animation: swag2-out 0.3s;
        		  animation-fill-mode: forwards;
        		  opacity: 0;
        		}
        		.my-super-cool-btn .dot:nth-child(3) {
        		  bottom: 50px;
        		  left: 50px;
        		  transform: rotate(140deg);
        		  animation: swag3-out 0.3s;
        		  animation-fill-mode: forwards;
        		  opacity: 0;
        		}
        		.my-super-cool-btn .dot:nth-child(4) {
        		  bottom: 50px;
        		  right: 50px;
        		  transform: rotate(-140deg);
        		  animation: swag4-out 0.3s;
        		  animation-fill-mode: forwards;
        		  opacity: 0;
        		}
        		.my-super-cool-btn:hover .dot:nth-child(1) {
        		  animation: swag1 0.3s;
        		  animation-fill-mode: forwards;
        		}
        		.my-super-cool-btn:hover .dot:nth-child(2) {
        		  animation: swag2 0.3s;
        		  animation-fill-mode: forwards;
        		}
        		.my-super-cool-btn:hover .dot:nth-child(3) {
        		  animation: swag3 0.3s;
        		  animation-fill-mode: forwards;
        		}
        		.my-super-cool-btn:hover .dot:nth-child(4) {
        		  animation: swag4 0.3s;
        		  animation-fill-mode: forwards;
        		}
        		@keyframes intro {
        		  0% {
        			opacity: 0;
        		  }
        		  100% {
        			opacity: 1;
        		  }
        		}
        		@keyframes swag1 {
        		  0% {
        			top: 50px;
        			left: 50px;
        			width: 8px;
        		  }
        		  50% {
        			width: 30px;
        			opacity: 1;
        		  }
        		  100% {
        			top: 20px;
        			left: 20px;
        			width: 8px;
        			opacity: 1;
        		  }
        		}
        		@keyframes swag1-out {
        		  0% {
        			top: 20px;
        			left: 20px;
        			width: 8px;
        		  }
        		  50% {
        			width: 30px;
        			opacity: 1;
        		  }
        		  100% {
        			top: 50px;
        			left: 50px;
        			width: 8px;
        			opacity: 0;
        		  }
        		}
        		@keyframes swag2 {
        		  0% {
        			top: 50px;
        			right: 50px;
        			width: 8px;
        		  }
        		  50% {
        			width: 30px;
        			opacity: 1;
        		  }
        		  100% {
        			top: 20px;
        			right: 20px;
        			width: 8px;
        			opacity: 1;
        		  }
        		}
        		@keyframes swag2-out {
        		  0% {
        			top: 20px;
        			right: 20px;
        			width: 8px;
        		  }
        		  50% {
        			width: 30px;
        			opacity: 1;
        		  }
        		  100% {
        			top: 50px;
        			right: 50px;
        			width: 8px;
        			opacity: 0;
        		  }
        		}
        		@keyframes swag3 {
        		  0% {
        			bottom: 50px;
        			left: 50px;
        			width: 8px;
        		  }
        		  50% {
        			width: 30px;
        			opacity: 1;
        		  }
        		  100% {
        			bottom: 20px;
        			left: 20px;
        			width: 8px;
        			opacity: 1;
        		  }
        		}
        		@keyframes swag3-out {
        		  0% {
        			bottom: 20px;
        			left: 20px;
        			width: 8px;
        		  }
        		  50% {
        			width: 30px;
        			opacity: 1;
        		  }
        		  100% {
        			bottom: 50px;
        			left: 50px;
        			width: 8px;
        			opacity: 0;
        		  }
        		}
        		@keyframes swag4 {
        		  0% {
        			bottom: 50px;
        			right: 50px;
        			width: 8px;
        		  }
        		  50% {
        			width: 30px;
        			opacity: 1;
        		  }
        		  100% {
        			bottom: 20px;
        			right: 20px;
        			width: 8px;
        			opacity: 1;
        		  }
        		}
        		@keyframes swag4-out {
        		  0% {
        			bottom: 20px;
        			right: 20px;
        			width: 8px;
        		  }
        		  50% {
        			width: 30px;
        			opacity: 1;
        		  }
        		  100% {
        			bottom: 50px;
        			right: 50px;
        			width: 8px;
        			opacity: 0;
        		  }
        		}
        		
        		span {
        				display: flex;
        				flex-direction: column;
        				align-items: center;
        		
        			}
        		.my-super-cool-btn p{
        			font-size: 17px !important;
        				font-weight:900 !important;
        		}
        	/* Ensure that the body and parent containers take up the full width */
body, html {
    margin: 0;
    padding: 0;
    width: 100%;
}

.container {
    width: 100%; /* Full width container */
    padding: 0;
    margin: 0; /* Remove any margins */
}

/* Set the card to take full width */
.card {
    width: 100%;
    transition: box-shadow 0.3s ease;
}

/* Adjust hover effect */
.card:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Full-width for content */
.company-info {
    font-size: 16px;
    color: #495057;
    width: 100%;
}

h5 {
    color: #343a40;
    width: 100%;
}

i {
    color: #6c757d;
    width: 100%;
}
  	.container-fluid {
   width: 100%;
}
	
        		
    </style>

    <div class="container-fluid ">
		<div class="d-flex flex-row"  style=" font-size: 17px !important; text-align: center; padding: 15px; background: linear-gradient(45deg, #b3c8ff, #7da5ff, #467cff, #0048ff);;">
			<div class="d-inline-flex p-2"> 
			<button class="btn2 btn1-bg-update text-light ml-2 toggle" data-toggle="modal" data-target="#convertToLead" onclick="openModalConverttolead('<?=$row->id;?>','<?=$row->name;?>')">Convert to Lead</button>
		</div> 
	</div>

    <div class="row">
	
        <div class="col-md-6 d-flex align-items-stretch">
		
            <div class="card shadow-sm p-3 mb-3">
						
                <?php
                $sqlTasks = "SELECT * FROM crm_lead_manage WHERE lead_id=$id";
                $resultTasks = db_query($sqlTasks);
                if ($row = mysqli_fetch_object($resultTasks)) { 
                ?>
				<div class="d-flex justify-content-end pt-2 pb-2 pr-2">
				
		<a class="border-0 btn2 btn1-bg-help" href="../home/leads_detail_update.php?view=<?= encrypTS($row->lead_id) ?>&tp=<?= encrypTS('lead') ?>"><i class="fa-solid fa-pen-to-square"></i>
					</a>
				</div>

			
			
			

                <div class="row">
                    <div class="col-md-6">
                        <h6 class="font-weight-bold text-secondary">Lead Information</h6>
                        <div class="d-flex align-items-center mb-2">
                            <span class="font-weight-bold text-muted mr-2">Lead Owner:</span>
                            <span><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$row->lead_owner.'"');?></span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <span class="font-weight-bold text-muted mr-2">Title:</span>
                            <span><?= $row->title; ?></span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <span class="font-weight-bold text-muted mr-2">Phone:</span>
                            <span><i class="fas fa-phone-alt text-success mr-1"></i> <?= $row->phone; ?></span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <span class="font-weight-bold text-muted mr-2">Lead Source:</span>
                            <span><?=find_a_field('crm_lead_source','source','id="'.$row->lead_source.'"');?></span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <span class="font-weight-bold text-muted mr-2">Industry:</span>
                            <span><?=find_a_field('crm_company_category','category_name','id="'.$row->industry.'"');?></span>
                        </div>
						 <div class="d-flex align-items-center mb-2">
                            <span class="font-weight-bold text-muted mr-2">Rating:</span>
                            <span> <?=find_a_field('crm_lead_rating_status','status','id="'.$row->rating.'"');?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="font-weight-bold text-secondary invisible">Hidden Header</h6> <!-- Keeps alignment -->
                        <div class="d-flex align-items-center mb-2">
                            <span class="font-weight-bold text-muted mr-2">Company:</span>
                            <span><?= $row->company_name; ?></span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <span class="font-weight-bold text-muted mr-2">Lead Name:</span>
                            <span><?= $row->first_name; ?> <?= $row->last_name; ?></span>
                        </div>
						<div class="d-flex align-items-center mb-2">
							<span class="font-weight-bold text-muted mr-2">Email:</span>
							<span><a href="mailto:<?= $row->email; ?>"><?= $row->email; ?></a></span>
						</div>
						<div class="d-flex align-items-center mb-2">
							<span class="font-weight-bold text-muted mr-2">Secondary Email:</span>
							<span><a href="mailto:<?= $row->secondary_email; ?>"><?= $row->secondary_email; ?></a></span>
						</div>

                        <div class="d-flex align-items-center mb-2">
                            <span class="font-weight-bold text-muted mr-2">No. of Employees:</span>
                            <span><?= $row->no_of_employees; ?></span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <span class="font-weight-bold text-muted mr-2">Website:</span>
                            <span><a href="#" target="_blank"><?= $row->website; ?></a></span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <span class="font-weight-bold text-muted mr-2">Lead Status:</span>
                            <span> <?=find_a_field('crm_lead_status_manage','status','id="'.$row->lead_status.'"');?></span>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
		
		
		
		
	
	
	
	
	
	<div class="col-md-3">
                <!-- Content for the first column -->
                <div class="card m-0 p-0 scrollable-div" style="max-width: 100% !important;">
                    <div style="text-align: center; background-color: whitesmoke; font-weight: 800; width: 100%;">
                        <div class="d-flex justify-content-between">
                            <div class="pt-2 pb-2 pr-2">
                                <h4 class="text-center bold pt-2 pb-2 pl-2 m-0">Contact Information</h4></div>
                            <div class="pt-2 pb-2 pr-2">
                                <button class="btn2 btn1-bg-update toggle" data-toggle="modal" data-target="#contactmodal"><i class="fa-solid fa-user-plus" style="color: #ffffff;"></i> ADD</button>
                            </div>
                        </div>
                    </div>
                    <div class="row m-0 p-0">
                        <?php
				$sqlTasks = "SELECT * FROM crm_lead_contacts  WHERE lead_id = $id;";
				$resultTasks = db_query($sqlTasks);
				while ($row = mysqli_fetch_object($resultTasks)) { ?>
                            <div class="col-sm-12 p-3">
                                <div class="content1 rounded p-2" style="background-color: #f9f9f9 !important; box-shadow: rgba(17, 17, 26, 0.05) 0px 1px 0px, rgba(17, 17, 26, 0.1) 0px 0px 8px;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h1>
                                    Name: <strong style="font-weight: 600;"><?=$row->contact_name;?></strong>
                                </h1>
                                        <button type="button" class="border-0 btn2 btn1-bg-help" data-toggle="modal" data-target="#contactmodal" onclick="openModalcontact('<?=$row->id;?>', '<?=$row->contact_name;?>', '<?=$row->contact_phone;?>','<?=$row->contact_email;?>','<?=$row->contact_designation?>')">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                    </div>
                                    <div class="social">
                                        <h1>
                                    Designation: <strong style="font-weight: 600;"><?=$row->contact_designation?></strong>
                                </h1>
                                        <h1>
                                    <i class="fa-duotone fa-phone" style="--fa-primary-color: #4e8efd; --fa-secondary-color: #18af22;"></i> <strong style="padding-left: 5px; font-weight: 600;"><?=$row->contact_phone?></strong>
                                </h1>
                                    </div>
                                    <div class="social">
                                        <h1>
                                    <i class="fa-duotone fa-envelope" style="--fa-primary-color: #054ac2; --fa-secondary-color: #07922a;"></i><strong style="padding-left: 5px; font-weight: 600;"><?=$row->contact_email?></strong>
                                </h1>
                                    </div>
                                    <div class="circle"></div>
                                </div>
                            </div>
                            <?php } ?>
                    </div>
                </div>
            </div>
	
	
	
	
	

		
		
		
		            
		
		
		
		
		
		
		<div class="col-md-3">
    <!-- Content for the first column -->
    <div class="card shadow-sm m-0 p-0 scrollable-div" style="max-width: 100% !important;">
        <div class="d-flex justify-content-between align-items-center bg-light p-2">
            <h4 class="m-0 text-secondary font-weight-bold">Product List</h4>
            <button class="btn btn-primary toggle" data-toggle="modal" data-target="#productaddmodal">
                <i class="fa-solid fa-plus"></i> ADD
            </button>
        </div>
        
        <?php
        $sqlTasks = "SELECT * FROM crm_lead_products JOIN crm_lead_product_individual ON crm_lead_products.id=crm_lead_product_individual.product_id WHERE crm_lead_product_individual.lead_id=$id;";
        $resultTasks = db_query($sqlTasks);
        while ($row = mysqli_fetch_object($resultTasks)) { ?>
            <div class="list-group-item d-flex justify-content-between align-items-center p-3 border-bottom">
                <div class="d-flex align-items-center">
                    <span class="font-weight-bold text-dark"><?= $row->products ?></span>
                </div>

                <!-- Button for deleting if there are multiple rows -->
                <?php if (mysqli_num_rows($resultTasks) > 1) { ?>
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#productaddmodaldelete" onclick="openModalproduct('<?= $row->product_individual_id; ?>', '<?= $row->products ?>')">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>
		
		
		
		
		
    </div>
</div>

<?php /*?>
            <div class="col-md-12">
                <!-- Content for the first column -->
                <div class="card m-0 p-0 scrollable-div" style="max-width: 100% !important;">
                    <div style="text-align: center; background-color: whitesmoke; font-weight: 800; width: 100%;">
                        <div class="d-flex justify-content-between">
                            <div class="pt-2 pb-2 pr-2">
                                <h4 class="text-center bold pt-2 pb-2 pl-2 m-0">Contact Information</h4></div>
                            <div class="pt-2 pb-2 pr-2">
                                <button class="btn2 btn1-bg-update toggle" data-toggle="modal" data-target="#contactmodal"><i class="fa-solid fa-user-plus" style="color: #ffffff;"></i> ADD</button>
                            </div>
                        </div>
                    </div>
                    <div class="row m-0 p-0">
                        <?php
				$sqlTasks = "SELECT * FROM crm_lead_contacts  WHERE lead_id = $id;";
				$resultTasks = db_query($sqlTasks);
				while ($row = mysqli_fetch_object($resultTasks)) { ?>
                            <div class="col-sm-6 p-3">
                                <div class="content1 rounded p-2" style="background-color: #f9f9f9 !important; box-shadow: rgba(17, 17, 26, 0.05) 0px 1px 0px, rgba(17, 17, 26, 0.1) 0px 0px 8px;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h1>
                                    Name: <strong style="font-weight: 600;"><?=$row->contact_name;?></strong>
                                </h1>
                                        <button type="button" class="border-0 btn2 btn1-bg-help" data-toggle="modal" data-target="#contactmodal" onclick="openModalcontact('<?=$row->id;?>', '<?=$row->contact_name;?>', '<?=$row->contact_phone;?>','<?=$row->contact_email;?>','<?=$row->contact_designation?>')">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                    </div>
                                    <div class="social">
                                        <h1>
                                    Designation: <strong style="font-weight: 600;"><?=$row->contact_designation?></strong>
                                </h1>
                                        <h1>
                                    <i class="fa-duotone fa-phone" style="--fa-primary-color: #4e8efd; --fa-secondary-color: #18af22;"></i> <strong style="padding-left: 5px; font-weight: 600;"><?=$row->contact_phone?></strong>
                                </h1>
                                    </div>
                                    <div class="social">
                                        <h1>
                                    <i class="fa-duotone fa-envelope" style="--fa-primary-color: #054ac2; --fa-secondary-color: #07922a;"></i><strong style="padding-left: 5px; font-weight: 600;"><?=$row->contact_email?></strong>
                                </h1>
                                    </div>
                                    <div class="circle"></div>
                                </div>
                            </div>
                            <?php } ?>
                    </div>
                </div>
            </div>
           <div class="col-md-12">
    <!-- Content for the first column -->
    <div class="card shadow-sm m-0 p-0 scrollable-div" style="max-width: 100% !important;">
        <div class="d-flex justify-content-between align-items-center bg-light p-2">
            <h4 class="m-0 text-secondary font-weight-bold">Product List</h4>
            <button class="btn btn-primary toggle" data-toggle="modal" data-target="#productaddmodal">
                <i class="fa-solid fa-plus"></i> ADD
            </button>
        </div>
        
        <?php
        $sqlTasks = "SELECT * FROM crm_lead_products JOIN crm_lead_product_individual ON crm_lead_products.id=crm_lead_product_individual.product_id WHERE crm_lead_product_individual.lead_id=$id;";
        $resultTasks = db_query($sqlTasks);
        while ($row = mysqli_fetch_object($resultTasks)) { ?>
            <div class="list-group-item d-flex justify-content-between align-items-center p-3 border-bottom">
                <div class="d-flex align-items-center">
                    <span class="font-weight-bold text-dark"><?= $row->products ?></span>
                </div>

                <!-- Button for deleting if there are multiple rows -->
                <?php if (mysqli_num_rows($resultTasks) > 1) { ?>
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#productaddmodaldelete" onclick="openModalproduct('<?= $row->product_individual_id; ?>', '<?= $row->products ?>')">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>


<?php */?>


        <!-- end Content for the first column -->
<!--




        <div class="container-fluid pt-5 pb-5">


            <div style="display: flex; flex-wrap: wrap; justify-content: space-around; align-items: center;  width: 100%;">

                <div id="wrapper">
                    <button data-toggle="modal" data-target="#schedulemeeting" style="background-color: transparent; border:none;" href="#" class="my-super-cool-btn btn-2">
                        <div class="dots-container">
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="dot"></div>
                        </div>
                        <div>

                            <span style="color:black !important;"> Schedule a Meeting  <i class="fa-solid fa-plus" style=" font-size: 30px; "></i> </span>
                        </div>
                    </button>
                </div>
                <div id="wrapper">
                    <button data-toggle="modal" data-target="#schedulecall" style="background-color: transparent; border:none;" href="#" class="my-super-cool-btn btn-1">

                        <div class="dots-container">
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="dot"></div>
                        </div>
                        <div>

                            <span style="color:black !important;"> Schedule a Call <i class="fa-solid fa-plus" style=" font-size: 30px; "></i> </span>
                        </div>

                    </button>
                </div>

     

                <div id="wrapper">
                    <button data-toggle="modal" data-target="#addtaskmodal" style="background-color: transparent; border:none;" href="#" class="my-super-cool-btn btn-3">
                        <div class="dots-container">
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="dot"></div>
                        </div>
                        <div>

                            <span style="color:black !important;"> Add a task<i class="fa-solid fa-plus" style=" font-size: 30px; "></i> </span>
                        </div>

                    </button>
                </div>



            </div>
        </div>

        <!-- Start sticky note -->




        <!-- Start sticky note -->


        <style>
            .card-big-shadow {
                /*max-width: 320px;*/
        		max-width: 100%;
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
                padding: 20px 20px;
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
                /* -webkit-line-clamp: 4; */
                /* Limit to 5 lines */
                /* -webkit-box-orient: vertical; */
                /* overflow: hidden; */
                /* Set vertical orientation */
                /* text-overflow: ellipsis; */
                /* Add ellipsis for overflow text */
            }
            .mycontent-card{
                margin-top:5px;    
            }
            a:hover, a:focus {
                text-decoration: none;
            }
        
            /*======== COLORS ===========*/
            .mycard[data-color="blue"] {
                /*background: #b8d8d8;*/
        		border-left: 3px solid #b8d8d8;
        		border-right: 3px solid #b8d8d8;
        		margin: 0px;
            }
            .mycard[data-color="blue"] .description {
                color: #506568;
            }
            .mycard[data-color="blue"] .category {
                color: #506568;
        		text-align: left;
            }
        
            .mycard[data-color="green"] {
                /*background: #d5e5a3;*/
        		border-left: 3px solid #d5e5a3;
        		border-right: 3px solid #d5e5a3;
        		margin: 0px;
            }
            .mycard[data-color="green"] .description {
                color: #60773d;
            }
            .mycard[data-color="green"] .category {
                color: #92ac56;
        		text-align: left;
            }
        
            .mycard[data-color="yellow"] {
               /* background: #ffe28c;*/
        	   border-left: 3px solid #ffe28c;
        	   border-right: 3px solid #ffe28c;
        	   margin: 0px;
            }
            .mycard[data-color="yellow"] .description {
                color: #b25825;
            }
            .mycard[data-color="yellow"] .category {
                color: #d88715;
        		text-align: left;
            }
        
            .mycard[data-color="brown"] {
                /*background: #d6c1ab;*/
        		border-left: 3px solid #d6c1ab;
        		border-right: 3px solid #d6c1ab;
        		margin: 0px;
            }
            .mycard[data-color="brown"] .description {
                color: #75442e;
            }
            .mycard[data-color="brown"] .category {
                color: #a47e65;
        		text-align: left;
            }
        
            .mycard[data-color="purple"] {
                /*background: #baa9ba;*/
        		border-left: 3px solid #baa9ba;
        		border-right: 3px solid #baa9ba;
        		margin: 0px;
            }
            .mycard[data-color="purple"] .description {
                color: #3a283d;
            }
            .mycard[data-color="purple"] .category {
                color: #5a283d;
        		text-align: left;
            }
        
            .mycard[data-color="orange"] {
                /*background: #ff8f5e;*/
        		border-left: 3px solid #ff8f5e;
        		border-right: 3px solid #ff8f5e;
        		margin: 0px;
            }
            .mycard[data-color="orange"] .description {
                color: #772510;
            }
            .mycard[data-color="orange"] .category {
                color: #e95e37;
        		text-align: left;
            }
            .mycard[data-color="red"] {
            /*background: #ffcccc;*/
        	border-left: 3px solid #ffcccc;
        	border-right: 3px solid #ffcccc;
        	margin: 0px;
            }
        
            .mycard[data-color="teal"] {
              /*  background: #a7e6e3;*/
        	  border-left: 3px solid #a7e6e3;
        	  border-right: 3px solid #a7e6e3;
        	  margin: 0px;
            }
            .mycard[data-color="teal"] .description {
                color: #004c4c;
            }
            .mycard[data-color="teal"] .category {
                color: #1aa39c;
        		text-align: left;
            }
        
            .mycard[data-color="grey"] {
               /* background: #e6e6e6;*/
        		 border-left: 3px solid #e6e6e6;
        		 border-right: 3px solid #e6e6e6;
        		 margin: 0px;
            }
            .mycard[data-color="grey"] .description {
                color: #4d4d4d;
            }
            .mycard[data-color="grey"] .category {
                color: #808080;
        		text-align: left;
            }
            .mycard[data-color1="white"] {
                   /* background: #f3f7fa !important;*/
        			border-left: 3px solid #f3f7fa;
        			border-right: 3px solid #f3f7fa;
        			margin: 0px;
                }
        
            .mycard[data-color="pink"] {
            /*    background: #ffc0cb;*/
        		border-left: 3px solid #ffc0cb;
        		border-right: 3px solid #ffc0cb;
        		margin: 0px;
            }
            .mycard[data-color="pink"] .description {
                color: #800080;
            }
            .mycard[data-color="pink"] .category {
                color: #ff69b4;
        		text-align: left;
            }
        
            .mycard[data-color="cyan"] {
               /* background: #7fffd4;*/
        		border-left: 3px solid #7fffd4;
        		border-right: 3px solid #7fffd4;
        		margin: 0px;
            }
            .mycard[data-color="cyan"] .description {
                color: #008b8b;
            }
            .mycard[data-color="cyan"] .category {
                color: #00cccc;
        		text-align: left;
            }
        </style>
		
	
	
	
	
	
	
	
		
		
		
		
		
		<style>
        
        
            body {
            background-color: #f5f7fa;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.875rem; /* Smaller base font size */
        }

        .card {
            border: none;
            border-radius: 10px;
            background-color: #edf2f7 !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }



        .card-div {
			width:100%;
            border: none;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
			font-size: 0.875rem;
        }

        .card-header {
            border-bottom: none;
            background-color: #007bff;
            color: #fff;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            padding: 10px 15px; /* Smaller padding */
        }

        .card-header h6 {
            font-weight: 600;
            font-size: 0.95rem; /* Smaller header text */
        }

        .note-item {
            padding: 10px 15px; /* Smaller padding */
            border-bottom: 1px solid #e9ecef;
            background-color: #f8f9fa;
            border-radius: 10px;
            margin-bottom: 10px; /* Smaller margin */
        }

        .note-item img {
            border-radius: 50%;
            width: 30px; /* Smaller avatar */
            height: 30px;
        }

        .note-item .badge {
            font-size: 0.75rem; /* Smaller badge text */
            background-color: #ffcc00;
            color: #333;
        }


        .note-item strong {
            font-size: 0.9rem; /* Smaller note title */
            color: #007bff;
        }

        .note-item p {
            margin: 3px 0 5px 0; /* Smaller spacing */
            font-size: 0.8rem; /* Smaller paragraph text */
        }

        .text-muted {
            font-size: 0.75rem; /* Smaller muted text */
        }

        .text-primary {
            font-weight: 600;
            color: #007bff;
        }

        .form-control {
            border-radius: 20px;
            border: 1px solid #ced4da;
            background-color: #e9ecef;
            font-size: 0.85rem; /* Smaller input text */
        }

        .form-control:focus {
            background-color: #fff;
        }

        .add-note-section {
            padding-top: 10px;
            padding-bottom: 10px;
            background-color: #e9ecef;
            border-radius: 10px;
        }

        .form-group button {
            margin-top: 5px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 20px;
            padding: 5px 15px; /* Smaller button padding */
            font-size: 0.85rem; /* Smaller button text */
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }


.bg-green-dark {
    color: #28a745; /* Dark green color */
}

.bg-red-dark {
    color: #dc3545; /* Dark red color */
}

.bg-blue-dark {
    color: #007bff; /* Dark blue color */
}

.bg-green-dark {
    color: #28a745; /* Dark green color */
}

.bg-red-dark {
    color: #dc3545; /* Dark red color */
}

.bg-blue-dark {
    color: #007bff; /* Dark blue color */
}


        .kanban-board {
            display: flex;
            justify-content: space-around;
            padding: 20px 0;
        }

        .kanban-column {
            flex: 1;
            margin: 0 10px;
            background-color: #edf2f7;
            border-radius: 8px;
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);
            padding: 15px;
            max-height: 600px;
            overflow-y: auto;
            transition: box-shadow 0.3s ease-in-out;
        }

        .kanban-column:hover {
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        }

        .kanban-column h5 {
            margin-bottom: 15px;
            color: #333;
            text-align: center;
            font-weight: 600;
        }

        .kanban-item {
            background-color: #ffffff;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
            cursor: grab;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .kanban-item:hover {
            transform: translateY(-2px);
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.2);
        }

		.meeting-icon {
		  background-color: #28a745;
		  border-radius: 50%;
		  width: 40px;
		  height: 40px;
		}
		
		.meeting-icon i {
			color:#ffffffff;
		  font-size: 20px;
		  
		}
		
		
		.call-icon {
		  background-color: #ffc107;
		  border-radius: 50%;
		  width: 40px;
		  height: 40px;
		}
		
		.call-icon i {
			color:#ffffffff;
		  font-size: 20px;
		  
		}
		
		.task-icon {
		  background-color: #fd7e14;
		  border-radius: 50%;
		  width: 40px;
		  height: 40px;
		}
		
		.task-icon i {
			color:#ffffffff;
		  font-size: 20px;
		  
		}
		.narrow-div {
		  height: 60px;
		  border-radius: 16px;
		  background-color: #edf2f7; /* Optional: background color for the narrow div */
		}
	

    </style>


<?php /*?><div class="container-fluid mt-2">
   <div class="card-div">
      <div class="card-header">
         <h6 class="mb-0">Meeting</h6>
      </div>
      <div class="card-body">
         <?php
            $currentDateTime = date("Y-m-d H:i:s");
            $sqlTasks = "SELECT * FROM crm_lead_activity_manage a WHERE lead_id = $id and activity_type = 'Meeting' ORDER BY activity_id DESC;";
            $resultTasks = db_query($sqlTasks);
            
            while ($row = mysqli_fetch_object($resultTasks)) {
            $date = $row->date;
            $time = $row->time;
            $datetime = $date . ' ' . $time;
            $displayFormat = date('M j, g:i A', strtotime($datetime));
            
            ?>
         <!-- Note Item 1 -->
         <div class="note-item">
            <div class="d-flex align-items-center mb-2">
               <img src="https://via.placeholder.com/40" alt="Avatar" class="rounded-circle">
               <div class="ml-2">
                  <strong><?=$row->subject;?></strong>
                  <p class="mb-1"><?=$row->details;?></p>
                  <p class="mb-1">Location: <?=$row->location;?></p>
               </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
               <div class="d-flex justify-content-between align-items-center">
                  <a href="#" class="text-primary m-2"><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$row->assign_person.'"');?></a>
                  <span class="badge m-2"><?=$row->meeting_type;?></span>
                  <div class="align-self-center">
                     <?php if ($row->priority_status == '3') { ?>
                     <span class="d-inline-flex flex-row  p-2 ">
                     <i class="fas fa-flag bg-green-dark"></i> LOW
                     </span>
                     <?php } elseif ($row->priority_status == '2') { ?>
                     <span class="d-inline-flex flex-row  p-2">
                     <i class="fas fa-flag color-blue-dark"></i>  MEDIUM
                     </span>
                     <?php } elseif ($row->priority_status == '1') { ?>
                     <span class="d-inline-flex flex-row p-2 ">
                     <i class="fas fa-flag bg-red-dark"></i>  HIGH
                     </span>
                     <?php } else { ?>
                     <span class="d-inline-flex flex-row p-2 ">
                     <i class="fas fa-flag bg-red-dark"></i>  NO DATA
                     </span>
                     <?php } ?>
                  </div>
               </div>
               <div class="text-muted">
                  <div class="d-inline-flex flex-row ">
                     <? if($row->status =='2'){ ?>
                     <span class=" bg-green-dark">COMPLETE</span>
                     <? }elseif($row->status =='1'){ ?>
                     <span class=" bg-red-dark">PENDING</span>
                     <? }else{ ?>
                     <span class=" bg-blue-dark">CANCELLED</span>
                     <?  } ?>
                  </div>
                  <?=$displayFormat?>
               </div>
            </div>
         </div>
         <?php } ?>
         <!-- Add Note Section -->
         <!--            <div class="add-note-section">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Add a note...">
                <button type="button">Add Note</button>
            </div>
            </div>-->
      </div>
   </div>
</div>
		


<?php */?>





  <div class="container-fluid mt-5">
    <!-- Narrow Div with Dropdown at the End -->	
    <div class="d-flex align-items-center " style=" font-size: 17px !important; text-align: center; padding: 15px; background: linear-gradient(45deg, #b3c8ff, #7da5ff, #467cff, #0048ff);;" >
	<div>
	<h1>Open Activity</h1>
	</div>
      <div class="flex-grow-1"></div>
      <div class="dropdown">
        <button class="btn btn-secondary mr-4 btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Options
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
 			<button class="dropdown-item" data-toggle="modal" data-target="#schedulecall" type="button">Call</button>
          <button class="dropdown-item" data-toggle="modal" data-target="#schedulemeeting" type="button">Meeting</button>
          <button class="dropdown-item" data-toggle="modal" data-target="#addtaskmodal" type="button">task</button>
        </div>
      </div>
    </div>
  </div>










<div class="container-fluid mt-2">
        <div class="kanban-board">
            <div class="kanban-column">
                <h5>Meeting</h5>
        
				
				

							 <?php
								$currentDateTime = date("Y-m-d H:i:s");
								$sqlTasks = "SELECT * FROM crm_lead_activity_manage a WHERE lead_id = $id and activity_type = 'Meeting' and status LIKE '1' ORDER BY activity_id DESC;";
								$resultTasks = db_query($sqlTasks);
								
								while ($row = mysqli_fetch_object($resultTasks)) {
								$date = $row->date;
								$time = $row->time;
								$datetime = $date . ' ' . $time;
								$displayFormat = date('M j, g:i A', strtotime($datetime));
								
								?>
							 <!-- Note Item 1 -->
							 <div class="kanban-item">
							 	<div class="d-flex flex-row-reverse">
									<button type="button" class=" btn2 btn1-bg-help " data-toggle="modal" data-target="#activityCancelModal" onclick="openModalcancelmeeting('<?=$row->activity_id;?>')" >
                                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                                            </button>
																			</div>
							 							
								<div class="d-flex mb-2">

																			
													
																			
																			
										<div class="meeting-icon d-flex justify-content-center align-items-center">
											<div>
										  	<i class=" fas fa-calendar "></i>
										  </div>
										</div>



								   <div class="ml-2">
									  <strong><?=$row->subject;?></strong>
									  <p class="mb-1"><?=$row->details;?></p>
									  <p class="mb-1">Location: <?=$row->location;?></p>
								   </div>
								</div>
								<div class="d-flex justify-content-between align-items-center">
								   <div class="d-flex justify-content-between align-items-center">
									  <a href="#" class="text-primary m-2"><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$row->assign_person.'"');?></a>
									  <span class="badge m-2"><?=$row->meeting_type;?></span>
									  <div class="align-self-center">
										 <?php if ($row->priority_status == '3') { ?>
										 <span class="d-inline-flex flex-row  p-2 ">
										 <i class="fas fa-flag bg-green-dark"></i> LOW
										 </span>
										 <?php } elseif ($row->priority_status == '2') { ?>
										 <span class="d-inline-flex flex-row  p-2">
										 <i class="fas fa-flag color-blue-dark"></i>  MEDIUM
										 </span>
										 <?php } elseif ($row->priority_status == '1') { ?>
										 <span class="d-inline-flex flex-row p-2 ">
										 <i class="fas fa-flag bg-red-dark"></i>  HIGH
										 </span>
										 <?php } else { ?>
										 <span class="d-inline-flex flex-row p-2 ">
										 <i class="fas fa-flag bg-red-dark"></i>  NO DATA
										 </span>
										 <?php } ?>
									  </div>
								   </div>
								   <div class="text-muted">
									  <div class="d-inline-flex flex-row ">
										 <? if($row->status =='2'){ ?>
										 <span class=" bg-green-dark">COMPLETE</span>
										 <? }elseif($row->status =='1'){ ?>
										 <span class=" bg-red-dark">PENDING</span>
										 <? }else{ ?>
										 <span class=" bg-blue-dark">CANCELLED</span>
										 <?  } ?>
									  </div>
									  <?=$displayFormat?>
								   </div>
								</div>
							 </div>
							 <?php } ?>
							 <!-- Add Note Section -->
							 <!--            <div class="add-note-section">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Add a note...">
									<button type="button">Add Note</button>
								</div>
								</div>-->

				

				
				
				
				
				

            </div>
            <div class="kanban-column">
                <h5>Call</h5>
 <?php
								$currentDateTime = date("Y-m-d H:i:s");
								$sqlTasks = "SELECT * FROM crm_lead_activity_manage a WHERE lead_id = $id and status LIKE '1'  and activity_type = 'Call' ORDER BY activity_id DESC;";
								$resultTasks = db_query($sqlTasks);
								
								while ($row = mysqli_fetch_object($resultTasks)) {
								$date = $row->date;
								$time = $row->time;
								$datetime = $date . ' ' . $time;
								$displayFormat = date('M j, g:i A', strtotime($datetime));
								
								?>
							 <!-- Note Item 1 -->
							 <div class="kanban-item">
							 							 	<div class="d-flex flex-row-reverse">
									<button type="button" class=" btn2 btn1-bg-help " data-toggle="modal" data-target="#activityCancelModal" onclick="openModalcancelmeeting('<?=$row->activity_id;?>')" >
                                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                                            </button>
																			</div>
							 							
								<div class="d-flex align-items-center mb-2">
								   		<div class="call-icon d-flex justify-content-center align-items-center">
											<div>
										  	<i class=" fas fa-phone "></i>
										  </div>
										</div>
								   <div class="ml-2">
									  <strong><?=$row->subject;?></strong>
									  <p class="mb-1"><?=$row->details;?></p>
									  <p class="mb-1">Location: <?=$row->location;?></p>
								   </div>
								</div>
								<div class="d-flex justify-content-between align-items-center">
								   <div class="d-flex justify-content-between align-items-center">
									  <a href="#" class="text-primary m-2"><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$row->assign_person.'"');?></a>
									  <span class="badge m-2"><?=$row->meeting_type;?></span>
									  <div class="align-self-center">
										 <?php if ($row->priority_status == '3') { ?>
										 <span class="d-inline-flex flex-row  p-2 ">
										 <i class="fas fa-flag bg-green-dark"></i> LOW
										 </span>
										 <?php } elseif ($row->priority_status == '2') { ?>
										 <span class="d-inline-flex flex-row  p-2">
										 <i class="fas fa-flag color-blue-dark"></i>  MEDIUM
										 </span>
										 <?php } elseif ($row->priority_status == '1') { ?>
										 <span class="d-inline-flex flex-row p-2 ">
										 <i class="fas fa-flag bg-red-dark"></i>  HIGH
										 </span>
										 <?php } else { ?>
										 <span class="d-inline-flex flex-row p-2 ">
										 <i class="fas fa-flag bg-red-dark"></i>  NO DATA
										 </span>
										 <?php } ?>
									  </div>
								   </div>
								   <div class="text-muted">
									  <div class="d-inline-flex flex-row ">
										 <? if($row->status =='2'){ ?>
										 <span class=" bg-green-dark">COMPLETE</span>
										 <? }elseif($row->status =='1'){ ?>
										 <span class=" bg-red-dark">PENDING</span>
										 <? }else{ ?>
										 <span class=" bg-blue-dark">CANCELLED</span>
										 <?  } ?>
									  </div>
									  <?=$displayFormat?>
								   </div>
								</div>
							 </div>
							 <?php } ?>
							 <!-- Add Note Section -->
							 <!--            <div class="add-note-section">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Add a note...">
									<button type="button">Add Note</button>
								</div>
								</div>-->

				
            </div>
            <div class="kanban-column">
                <h5>Task</h5>




 <?php
								$currentDateTime = date("Y-m-d H:i:s");
								$sqlTasks = "SELECT * FROM crm_lead_activity_manage a WHERE lead_id = $id and activity_type = 'Task' and status LIKE '1'  ORDER BY activity_id DESC;";
								$resultTasks = db_query($sqlTasks);
								
								while ($row = mysqli_fetch_object($resultTasks)) {
								$date = $row->date;
								$time = $row->time;
								$datetime = $date . ' ' . $time;
								$displayFormat = date('M j, g:i A', strtotime($datetime));
								
								?>
							 <!-- Note Item 1 -->
							 <div class="kanban-item">
							 							 	<div class="d-flex flex-row-reverse">
									<button type="button" class=" btn2 btn1-bg-help " data-toggle="modal" data-target="#activityCancelModal" onclick="openModalcancelmeeting('<?=$row->activity_id;?>')" >
                                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                                            </button>
																			</div>
							 							
								<div class="d-flex align-items-center mb-2">
								   			<div class="task-icon d-flex justify-content-center align-items-center">
											<div>
										  	<i class=" fas fa-tasks "></i>
										  </div>
										</div>
								   <div class="ml-2">
									  <strong><?=$row->subject;?></strong>
									  <p class="mb-1"><?=$row->details;?></p>
									  <p class="mb-1">Location: <?=$row->location;?></p>
								   </div>
								</div>
								<div class="d-flex justify-content-between align-items-center">
								   <div class="d-flex justify-content-between align-items-center">
									  <a href="#" class="text-primary m-2"><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$row->assign_person.'"');?></a>
									  <span class="badge m-2"><?=$row->meeting_type;?></span>
									  <div class="align-self-center">
										 <?php if ($row->priority_status == '3') { ?>
										 <span class="d-inline-flex flex-row  p-2 ">
										 <i class="fas fa-flag bg-green-dark"></i> LOW
										 </span>
										 <?php } elseif ($row->priority_status == '2') { ?>
										 <span class="d-inline-flex flex-row  p-2">
										 <i class="fas fa-flag color-blue-dark"></i>  MEDIUM
										 </span>
										 <?php } elseif ($row->priority_status == '1') { ?>
										 <span class="d-inline-flex flex-row p-2 ">
										 <i class="fas fa-flag bg-red-dark"></i>  HIGH
										 </span>
										 <?php } else { ?>
										 <span class="d-inline-flex flex-row p-2 ">
										 <i class="fas fa-flag bg-red-dark"></i>  NO DATA
										 </span>
										 <?php } ?>
									  </div>
								   </div>
								   <div class="text-muted">
									  <div class="d-inline-flex flex-row ">
										 <? if($row->status =='2'){ ?>
										 <span class=" bg-green-dark">COMPLETE</span>
										 <? }elseif($row->status =='1'){ ?>
										 <span class=" bg-red-dark">PENDING</span>
										 <? }else{ ?>
										 <span class=" bg-blue-dark">CANCELLED</span>
										 <?  } ?>
									  </div>
									  <?=$displayFormat?>
								   </div>
								</div>
							 </div>
							 <?php } ?>
							 <!-- Add Note Section -->
							 <!--            <div class="add-note-section">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Add a note...">
									<button type="button">Add Note</button>
								</div>
								</div>-->





            </div>
        </div>
    </div>
		
		








  <div class="container-fluid mt-5">
    <!-- Narrow Div with Dropdown at the End -->	
    <div class=" d-flex align-items-center " style=" font-size: 17px !important; text-align: center; padding: 15px; background: linear-gradient(45deg, #b3c8ff, #7da5ff, #467cff, #0048ff);;">
	<div>
	<h1>Close Activity</h1>
	</div>
      <div class="flex-grow-1"></div>
  </div>










<div class="container-fluid mt-2">
        <div class="kanban-board">
            <div class="kanban-column">
                <h5>Meeting</h5>
        
				
				

							 <?php
								$currentDateTime = date("Y-m-d H:i:s");
								$sqlTasks = "SELECT * FROM crm_lead_activity_manage a WHERE lead_id = $id and activity_type = 'Meeting' and status IN (2,3) ORDER BY activity_id DESC;";
								$resultTasks = db_query($sqlTasks);
								
								while ($row = mysqli_fetch_object($resultTasks)) {
								$date = $row->date;
								$time = $row->time;
								$datetime = $date . ' ' . $time;
								$displayFormat = date('M j, g:i A', strtotime($datetime));
								
								?>
							 <!-- Note Item 1 -->
							 <div class="kanban-item">
							 	<div class="d-flex flex-row-reverse">
									<button type="button" class=" btn2 btn1-bg-help " data-toggle="modal" data-target="#activityCancelModal" onclick="openModalcancelmeeting('<?=$row->activity_id;?>')" >
                                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                                            </button>
																			</div>
							 							
								<div class="d-flex mb-2">

																			
													
																			
																			
										<div class="meeting-icon d-flex justify-content-center align-items-center">
											<div>
										  	<i class=" fas fa-calendar "></i>
										  </div>
										</div>



								   <div class="ml-2">
									  <strong><?=$row->subject;?></strong>
									  <p class="mb-1"><?=$row->details;?></p>
									  <p class="mb-1">Location: <?=$row->location;?></p>
								   </div>
								</div>
								<div class="d-flex justify-content-between align-items-center">
								   <div class="d-flex justify-content-between align-items-center">
									  <a href="#" class="text-primary m-2"><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$row->assign_person.'"');?></a>
									  <span class="badge m-2"><?=$row->meeting_type;?></span>
									  <div class="align-self-center">
										 <?php if ($row->priority_status == '3') { ?>
										 <span class="d-inline-flex flex-row  p-2 ">
										 <i class="fas fa-flag bg-green-dark"></i> LOW
										 </span>
										 <?php } elseif ($row->priority_status == '2') { ?>
										 <span class="d-inline-flex flex-row  p-2">
										 <i class="fas fa-flag color-blue-dark"></i>  MEDIUM
										 </span>
										 <?php } elseif ($row->priority_status == '1') { ?>
										 <span class="d-inline-flex flex-row p-2 ">
										 <i class="fas fa-flag bg-red-dark"></i>  HIGH
										 </span>
										 <?php } else { ?>
										 <span class="d-inline-flex flex-row p-2 ">
										 <i class="fas fa-flag bg-red-dark"></i>  NO DATA
										 </span>
										 <?php } ?>
									  </div>
								   </div>
								   <div class="text-muted">
									  <div class="d-inline-flex flex-row ">
										 <? if($row->status =='2'){ ?>
										 <span class=" bg-green-dark">COMPLETE</span>
										 <? }elseif($row->status =='1'){ ?>
										 <span class=" bg-red-dark">PENDING</span>
										 <? }else{ ?>
										 <span class=" bg-blue-dark">CANCELLED</span>
										 <?  } ?>
									  </div>
									  <?=$displayFormat?>
								   </div>
								</div>
							 </div>
							 <?php } ?>
							 <!-- Add Note Section -->
							 <!--            <div class="add-note-section">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Add a note...">
									<button type="button">Add Note</button>
								</div>
								</div>-->

				

				
				
				
				
				

            </div>
            <div class="kanban-column">
                <h5>Call</h5>
 <?php
								$currentDateTime = date("Y-m-d H:i:s");
								$sqlTasks = "SELECT * FROM crm_lead_activity_manage a WHERE lead_id = $id and status IN (2,3) and activity_type = 'Call' ORDER BY activity_id DESC;";
								$resultTasks = db_query($sqlTasks);
								
								while ($row = mysqli_fetch_object($resultTasks)) {
								$date = $row->date;
								$time = $row->time;
								$datetime = $date . ' ' . $time;
								$displayFormat = date('M j, g:i A', strtotime($datetime));
								
								?>
							 <!-- Note Item 1 -->
							 <div class="kanban-item">
							 							 	<div class="d-flex flex-row-reverse">
									<button type="button" class=" btn2 btn1-bg-help " data-toggle="modal" data-target="#activityCancelModal" onclick="openModalcancelmeeting('<?=$row->activity_id;?>')" >
                                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                                            </button>
																			</div>
							 							
								<div class="d-flex align-items-center mb-2">
								   		<div class="call-icon d-flex justify-content-center align-items-center">
											<div>
										  	<i class=" fas fa-phone "></i>
										  </div>
										</div>
								   <div class="ml-2">
									  <strong><?=$row->subject;?></strong>
									  <p class="mb-1"><?=$row->details;?></p>
									  <p class="mb-1">Location: <?=$row->location;?></p>
								   </div>
								</div>
								<div class="d-flex justify-content-between align-items-center">
								   <div class="d-flex justify-content-between align-items-center">
									  <a href="#" class="text-primary m-2"><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$row->assign_person.'"');?></a>
									  <span class="badge m-2"><?=$row->meeting_type;?></span>
									  <div class="align-self-center">
										 <?php if ($row->priority_status == '3') { ?>
										 <span class="d-inline-flex flex-row  p-2 ">
										 <i class="fas fa-flag bg-green-dark"></i> LOW
										 </span>
										 <?php } elseif ($row->priority_status == '2') { ?>
										 <span class="d-inline-flex flex-row  p-2">
										 <i class="fas fa-flag color-blue-dark"></i>  MEDIUM
										 </span>
										 <?php } elseif ($row->priority_status == '1') { ?>
										 <span class="d-inline-flex flex-row p-2 ">
										 <i class="fas fa-flag bg-red-dark"></i>  HIGH
										 </span>
										 <?php } else { ?>
										 <span class="d-inline-flex flex-row p-2 ">
										 <i class="fas fa-flag bg-red-dark"></i>  NO DATA
										 </span>
										 <?php } ?>
									  </div>
								   </div>
								   <div class="text-muted">
									  <div class="d-inline-flex flex-row ">
										 <? if($row->status =='2'){ ?>
										 <span class=" bg-green-dark">COMPLETE</span>
										 <? }elseif($row->status =='1'){ ?>
										 <span class=" bg-red-dark">PENDING</span>
										 <? }else{ ?>
										 <span class=" bg-blue-dark">CANCELLED</span>
										 <?  } ?>
									  </div>
									  <?=$displayFormat?>
								   </div>
								</div>
							 </div>
							 <?php } ?>
							 <!-- Add Note Section -->
							 <!--            <div class="add-note-section">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Add a note...">
									<button type="button">Add Note</button>
								</div>
								</div>-->

				
            </div>
            <div class="kanban-column">
                <h5>Task</h5>




 <?php
								$currentDateTime = date("Y-m-d H:i:s");
								$sqlTasks = "SELECT * FROM crm_lead_activity_manage a WHERE lead_id = $id and activity_type = 'Task' and status IN (2,3) ORDER BY activity_id DESC;";
								$resultTasks = db_query($sqlTasks);
								
								while ($row = mysqli_fetch_object($resultTasks)) {
								$date = $row->date;
								$time = $row->time;
								$datetime = $date . ' ' . $time;
								$displayFormat = date('M j, g:i A', strtotime($datetime));
								
								?>
							 <!-- Note Item 1 -->
							 <div class="kanban-item">
							 							 	<div class="d-flex flex-row-reverse">
									<button type="button" class=" btn2 btn1-bg-help " data-toggle="modal" data-target="#activityCancelModal" onclick="openModalcancelmeeting('<?=$row->activity_id;?>')" >
                                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                                            </button>
																			</div>
							 							
								<div class="d-flex align-items-center mb-2">
								   			<div class="task-icon d-flex justify-content-center align-items-center">
											<div>
										  	<i class=" fas fa-tasks "></i>
										  </div>
										</div>
								   <div class="ml-2">
									  <strong><?=$row->subject;?></strong>
									  <p class="mb-1"><?=$row->details;?></p>
									  <p class="mb-1">Location: <?=$row->location;?></p>
								   </div>
								</div>
								<div class="d-flex justify-content-between align-items-center">
								   <div class="d-flex justify-content-between align-items-center">
									  <a href="#" class="text-primary m-2"><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$row->assign_person.'"');?></a>
									  <span class="badge m-2"><?=$row->meeting_type;?></span>
									  <div class="align-self-center">
										 <?php if ($row->priority_status == '3') { ?>
										 <span class="d-inline-flex flex-row  p-2 ">
										 <i class="fas fa-flag bg-green-dark"></i> LOW
										 </span>
										 <?php } elseif ($row->priority_status == '2') { ?>
										 <span class="d-inline-flex flex-row  p-2">
										 <i class="fas fa-flag color-blue-dark"></i>  MEDIUM
										 </span>
										 <?php } elseif ($row->priority_status == '1') { ?>
										 <span class="d-inline-flex flex-row p-2 ">
										 <i class="fas fa-flag bg-red-dark"></i>  HIGH
										 </span>
										 <?php } else { ?>
										 <span class="d-inline-flex flex-row p-2 ">
										 <i class="fas fa-flag bg-red-dark"></i>  NO DATA
										 </span>
										 <?php } ?>
									  </div>
								   </div>
								   <div class="text-muted">
									  <div class="d-inline-flex flex-row ">
										 <? if($row->status =='2'){ ?>
										 <span class=" bg-green-dark">COMPLETE</span>
										 <? }elseif($row->status =='1'){ ?>
										 <span class=" bg-red-dark">PENDING</span>
										 <? }else{ ?>
										 <span class=" bg-blue-dark">CANCELLED</span>
										 <?  } ?>
									  </div>
									  <?=$displayFormat?>
								   </div>
								</div>
							 </div>
							 <?php } ?>
							 <!-- Add Note Section -->
							 <!--            <div class="add-note-section">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Add a note...">
									<button type="button">Add Note</button>
								</div>
								</div>-->





            </div>
        </div>
    </div>










<?php /*?><div class="container-fluid mt-2">
    <div class="card-div">
        <div class="card-header">
            <h6 class="mb-0">Call</h6>
        </div>
        <div class="card-body">
		                        <?php
                                $currentDateTime = date("Y-m-d H:i:s");
         $sqlTasks = "SELECT * FROM crm_lead_activity_manage a WHERE lead_id = $id AND activity_type = 'Call' ORDER BY activity_id DESC;";
                                $resultTasks = db_query($sqlTasks);

                                while ($row = mysqli_fetch_object($resultTasks)) {
								$date = $row->date;
								$time = $row->time;
								$datetime = $date . ' ' . $time;
								$displayFormat = date('M j, g:i A', strtotime($datetime));

                                ?>
            <!-- Note Item 1 -->
            <div class="note-item">
                <div class="d-flex align-items-center mb-2">
                    <img src="https://via.placeholder.com/40" alt="Avatar" class="rounded-circle">
                    <div class="ml-2">
                        <strong><?=$row->subject;?></strong>
                        <p class="mb-1"><?=$row->details;?></p>
						<p class="mb-1">Location: <?=$row->location;?></p>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
						<div class="d-flex justify-content-between align-items-center">
							<a href="#" class="text-primary m-2"><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$row->assign_person.'"');?></a>
							<span class="badge m-2"><?=$row->call_type;?></span>
												<div class="align-self-center">
							
														<?php if ($row->priority_status == '3') { ?>
															<span class="d-inline-flex flex-row  p-2 ">
																<i class="fas fa-flag bg-green-dark"></i> LOW
															</span>
														<?php } elseif ($row->priority_status == '2') { ?>
															<span class="d-inline-flex flex-row  p-2">
																<i class="fas fa-flag color-blue-dark"></i>  MEDIUM
															</span>
														<?php } elseif ($row->priority_status == '1') { ?>
															<span class="d-inline-flex flex-row p-2 ">
																<i class="fas fa-flag bg-red-dark"></i>  HIGH
															</span>
														<?php } else { ?>
															<span class="d-inline-flex flex-row p-2 ">
																<i class="fas fa-flag bg-red-dark"></i>  NO DATA
															</span>
														<?php } ?>
	
												</div>
							
						</div>
                    <div class="text-muted">
					<div class="d-inline-flex flex-row ">
										<? if($row->status =='2'){ ?>

                                            <span class=" bg-green-dark">COMPLETE</span>
												<? }elseif($row->status =='1'){ ?>
														   
													<span class=" bg-red-dark">PENDING</span>
														   <? }else{ ?>
														   
														   <span class=" bg-blue-dark">CANCELLED</span>
														   <?  } ?>
					
					</div>
					
                        <?=$displayFormat?>
                    </div>
                </div>
            </div>
       <?php } ?>
           

            <!-- Add Note Section -->
<!--            <div class="add-note-section">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Add a note...">
                    <button type="button">Add Note</button>
                </div>
            </div>-->
			
        </div>
    </div>
</div>



		

<div class="container-fluid mt-2">
    <div class="card-div">
        <div class="card-header">
            <h6 class="mb-0">Task</h6>
        </div>
        <div class="card-body">
		                        <?php
                                $currentDateTime = date("Y-m-d H:i:s");
         $sqlTasks = "SELECT * FROM crm_lead_activity_manage a WHERE lead_id = $id AND activity_type = 'Task' ORDER BY activity_id DESC;";
                                $resultTasks = db_query($sqlTasks);

                                while ($row = mysqli_fetch_object($resultTasks)) {
								$date = $row->date;
								$time = $row->time;
								$datetime = $date . ' ' . $time;
								$displayFormat = date('M j, g:i A', strtotime($datetime));

                                ?>
            <!-- Note Item 1 -->
            <div class="note-item">
                <div class="d-flex align-items-center mb-2">
                    <img src="https://via.placeholder.com/40" alt="Avatar" class="rounded-circle">
                    <div class="ml-2">
                        <strong><?=$row->subject;?></strong>
                        <p class="mb-1"><?=$row->details;?></p>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
						<div class="d-flex justify-content-between align-items-center">
							<a href="#" class="text-primary m-2"><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$row->assign_person.'"');?></a>
							
												<div class="align-self-center">
							
														<?php if ($row->priority_status == '3') { ?>
															<span class="d-inline-flex flex-row  p-2 ">
																<i class="fas fa-flag bg-green-dark"></i> LOW
															</span>
														<?php } elseif ($row->priority_status == '2') { ?>
															<span class="d-inline-flex flex-row  p-2">
																<i class="fas fa-flag color-blue-dark"></i>  MEDIUM
															</span>
														<?php } elseif ($row->priority_status == '1') { ?>
															<span class="d-inline-flex flex-row p-2 ">
																<i class="fas fa-flag bg-red-dark"></i>  HIGH
															</span>
														<?php } else { ?>
															<span class="d-inline-flex flex-row p-2 ">
																<i class="fas fa-flag bg-red-dark"></i>  NO DATA
															</span>
														<?php } ?>
	
												</div>
							
						</div>
                    <div class="text-muted">
					<div class="d-inline-flex flex-row ">
										<? if($row->status =='2'){ ?>

                                            <span class=" bg-green-dark">COMPLETE</span>
												<? }elseif($row->status =='1'){ ?>
														   
													<span class=" bg-red-dark">PENDING</span>
														   <? }else{ ?>
														   
														   <span class=" bg-blue-dark">CANCELLED</span>
														   <?  } ?>
					
					</div>
					
                        <?=$displayFormat?>
                    </div>
                </div>
            </div>
       <?php } ?>
           

            <!-- Add Note Section -->
<!--            <div class="add-note-section">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Add a note...">
                    <button type="button">Add Note</button>
                </div>
            </div>-->
			
        </div>
    </div>
</div><?php */?>




		
		
		
		
		
		
		
		


        <script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>
        <?php /*?>
            <div class="container-fluid pt-3 pb-3 row">
                <!-- meeting -->
                <div class="col-sm-6">
                    <p style="width: 100% !important; text-align: center; padding:0px !important; margin: 0px !important; font-size:14px !important;font-weight:900 !important;">Meetings Details</p>
                    <div class="circle"></div>
                    <div class="row">
                        <?php
                                $currentDateTime = date("Y-m-d H:i:s");
         $sqlTasks = "SELECT * FROM crm_lead_activity a WHERE lead_id = $id AND activity_type = 'Meeting' AND status != 'cancelled' ORDER BY activity_id DESC;";
                                $resultTasks = db_query($sqlTasks);

                                while ($row = mysqli_fetch_object($resultTasks)) {
                                ?>

                            <div class="col-sm-12 mycontent-card">
                                <div class="card-big-shadow">
                                    <div class="mycard card-just-text" data-background="color" data-color="blue" data-radius="none">
                                        <div class="ourcontent">
                                            <div class="d-flex justify-content-between align-items-center ">
                                                <div>
                                                    <h4 class="myh4 category" style=" line-height: 20px; ">Meeting Subject: <?=$row->subject;?></h4>
                                                    <h4 class="myh4 category" style=" line-height: 20px; ">Meeting Type: <? //$row->activity_type;?> <?=$row->meeting_type;?></h4>
                                                    <!-- <h4 class="myh4 title"><a href="#"><?=find_a_field('crm_project_org','name','id="'.$row->organization_id.'"');?></a></h4> -->
                                                    <h4 class="myh4 category" style=" line-height: 20px; ">Visit Date: <?=$row->date;?> (<?=$row->time;?>)</h4>
                                                    <h4 class="myh4 category" style=" line-height: 20px; ">Location: <?=$row->location;?></h4>
                                                    <h4 class="myh4 category"></h4>
                                                    <p class="description" style=" line-height: 20px; ">Note:
                                                        <?=$row->details;?>
                                                    </p>
                                                </div>
                                                <div>
                                                    <div class="d-flex justify-content-between align-items-center ">
                                                        <a class="btn btn-sm btn-info mr-2" href="../info_maker/lead_task_details_show.php?leadid=<?=encrypTS($id)?>&activityid='<?=encrypTS($row->activity_id)?>'"><i class="fa-solid fa-eye"></i></a>
                                                        <button type="button" class="border-0" data-toggle="modal" data-target="#activityCancelModal" onclick="openModalcancelmeeting('<?=$row->activity_id;?>')">
                                                            <i class="fa-solid fa-xmark"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card -->
                                </div>
                            </div>

                            <?php } ?>

                    </div>

                </div>








                <!-- calls -->

                <div class="col-sm-6">
                    <div class="container bootstrap snippets bootdeys">
                        <p style="width: 100% !important; text-align: center;  padding:0px !important; margin: 0px !important; font-size:14px !important;font-weight:900 !important;">Calls Details</p>
                        <div class="circle"></div>

                        <div class="row">




                            <?php
        $currentDateTime = date("Y-m-d H:i:s");
        $sqlTasks = "SELECT * FROM crm_lead_activity a WHERE lead_id = $id AND activity_type = 'call' AND status != 'cancelled' ORDER BY activity_id DESC;";
        $resultTasks = db_query($sqlTasks);

        while ($row = mysqli_fetch_object($resultTasks)) {
        ?>


                                <div class="col-sm-12 mycontent-card">
                                    <div class="card-big-shadow">
                                        <div class="mycard card-just-text" data-background="color" data-color="blue" data-radius="none">
                                            <div class="ourcontent">
                                                <div class="d-flex justify-content-between align-items-center ">
                                                    <div>
                                                        <h4 class="myh4 category" style=" line-height: 20px; ">Call To: <?=$row->call_to;?></h4>
                                                        <h4 class="myh4 category" style=" line-height: 20px; ">Call type: <?=$row->call_type;?> [ <?=$row->date;?> ( <?=$row->time;?> ) ]</h4>
                                                        <!-- <h4 class="myh4 title"><a href="#"><?=find_a_field('crm_project_org','name','id="'.$row->organization_id.'"');?></a></h4> -->
                                                        <!--<h4 class="myh4 category" style=" line-height: 20px; ">Call Date: <?=$row->date;?> (<?=$row->time;?>)</h4>-->
                                                        <h4 class="myh4 category" style=" line-height: 20px; ">Call Purpose:<?=$row->subject;?> </h4>
                                                        <p class="description" style=" line-height: 20px; ">Note:
                                                            <?=$row->details;?>
                                                        </p>
                                                    </div>

                                                    <div>

                                                        <div class="d-flex justify-content-between align-items-center ">
                                                            <a class="btn btn-sm btn-info mr-2" href="../info_maker/lead_task_details_show.php?leadid=<?=encrypTS($id)?>&activityid='<?=encrypTS($row->id)?>'"><i class="fa-solid fa-eye"></i></a>
                                                            <button type="button" class="border-0" data-toggle="modal" data-target="#activityCancelModal" onclick="openModalcancelmeeting('<?=$row->activity_id;?>')">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end card -->
                                    </div>
                                </div>
                                <?php } ?>
                        </div>
                    </div>
                </div>

                <!-- VIsits -->
                <div class="col-sm-4">
                    <div class="container bootstrap snippets bootdeys">

                        <p style="width: 100% !important; text-align: center; padding:0px !important; margin: 0px !important; font-size:14px !important;font-weight:900 !important;">Visits Details</p>
                        <div class="circle"></div>

                        <div class="row">
                            <?php
            $currentDateTime = date("Y-m-d H:i:s");
            $sqlTasks = "SELECT * FROM crm_lead_activity a WHERE lead_id = $id AND activity_type = 'visit' AND status != 'cancelled' ORDER BY activity_id DESC;";
            $resultTasks = db_query($sqlTasks);

            while ($row = mysqli_fetch_object($resultTasks)) {
            ?>
                                <div class="col-sm-12 mycontent-card">
                                    <div class="card-big-shadow">
                                        <div class="mycard card-just-text" data-background="color" data-color="blue" data-radius="none">
                                            <div class="ourcontent">
                                                <div class="d-flex justify-content-between align-items-center ">
                                                    <div>
                                                        <h4 class="myh4 category" style="line-height: 20px;">Visit Purpose: <?=$row->subject;?></h4>
                                                        <h4 class="myh4 category" style="line-height: 20px;">Visit Location: <?=$row->location;?></h4>
                                                        <!-- <h4 class="myh4 title"><a href="#"><?=find_a_field('crm_project_org','name','id="'.$row->organization_id.'"');?></a></h4> -->
                                                        <h4 class="myh4 category" style="line-height: 20px;">Visit Date: <?=$row->date;?> (<?=$row->time;?>)</h4>
                                                        <h4 class="myh4 category"></h4>
                                                        <p class="description" style="line-height: 20px;"> Note:
                                                            <?=$row->details;?>
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <div class="d-flex justify-content-between align-items-center ">
                                                            <a class="btn btn-sm btn-info mr-2" href="../info_maker/lead_task_details_show.php?leadid=<?=encrypTS($id)?>&activityid='<?=encrypTS($row->id)?>'"><i class="fa-solid fa-eye"></i></a>
                                                            <button type="button" class="border-0" data-toggle="modal" data-target="#activityCancelModal" onclick="openModalcancelmeeting('<?=$row->activity_id;?>')">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end card -->
                                    </div>
                                </div>
                                <?php } ?>
                        </div>
                    </div>
                </div>

                <!-- Emails -->
                <div class="col-sm-4">
                    <div class="container bootstrap snippets bootdeys">

                        <p style="width: 100% !important; text-align: center; padding: 0px !important; margin: 0px !important; font-size: 14px !important; font-weight: 900 !important;">Emails Details</p>
                        <div class="circle"></div>

                        <div class="row">
                            <?php
            $currentDateTime = date("Y-m-d H:i:s");
            $sqlTasks = "SELECT * FROM crm_lead_activity a WHERE lead_id = $id AND activity_type = 'Email' AND status != 'cancelled' ORDER BY activity_id DESC;";
            $resultTasks = db_query($sqlTasks);

            while ($row = mysqli_fetch_object($resultTasks)) {
            ?>
                                <div class="col-sm-12 mycontent-card">
                                    <div class="card-big-shadow">
                                        <div class="mycard card-just-text" data-background="color" data-color="blue" data-radius="none">
                                            <div class="ourcontent">
                                                <div class="d-flex justify-content-between align-items-center ">
                                                    <div>
                                                        <h4 class="myh4 category" style="line-height: 20px;">Email to: <?=$row->call_to;?></h4>
                                                        <h4 class="myh4 category" style="line-height: 20px;">Email Subject: <?=$row->subject;?></h4>
                                                        <!-- <h4 class="myh4 title"><a href="#"><?=find_a_field('crm_project_org','name','id="'.$row->organization_id.'"');?></a></h4> -->
                                                        <h4 class="myh4 category" style="line-height: 20px;">Email Date: <?=$row->date;?> (<?=$row->time;?>)</h4>
                                                        <p class="description" style="line-height: 20px;"><strong> Email Body:</strong>
                                                            <?=$row->details;?>
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <div class="d-flex justify-content-between align-items-center ">
                                                            <a class="btn btn-sm btn-info mr-2" href="../info_maker/lead_task_details_show.php?leadid=<?=encrypTS($id)?>&activityid='<?=encrypTS($row->id)?>'"><i class="fa-solid fa-eye"></i></a>
                                                            <button type="button" class="border-0" data-toggle="modal" data-target="#activityCancelModal" onclick="openModalcancelmeeting('<?=$row->activity_id;?>')">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end card -->
                                    </div>
                                </div>
                                <?php } ?>
                        </div>
                    </div>
                </div>


                <div class="col-sm-4">
                    <p style="width: 100% !important; text-align: center; padding: 0px !important; margin: 0px !important; font-size: 14px !important; font-weight: 900 !important;">Tasks Details</p>
                    <div class="circle"></div>
                    <div class="row">
                        <?php
        $currentDateTime = date("Y-m-d H:i:s");
        $sqlTasks = "SELECT * FROM crm_task_add_information WHERE lead_id=$id ORDER BY task_id DESC";
        $resultTasks = db_query($sqlTasks);

        while ($row = mysqli_fetch_object($resultTasks)) {
        ?>
                            <div class="col-sm-12 mycontent-card">
                                <div class="card-big-shadow">
                                    <div class="mycard card-just-text" data-background="color" data-color="blue" data-radius="none">
                                        <div class="ourcontent" style="position: relative;">
                                            <button class="btn2 btn1-bg-update toggle" style="height: 25px; position: absolute; top: 5px; right: 5px; width: 25px;" data-toggle="modal" data-target="#updatetaskmodal" data-task-id="<?=$row->task_id;?>" data-task-name="<?=$row->task_name;?>" data-task-details="<?=$row->task_details;?>"
                                            data-task-Date="<?=$row->task_date;?>" data-task-time="<?=$row->task_time;?>" onclick="openModalfortask('<?=$row->task_id;?>', '<?=$row->task_name;?>','<?=$row->task_details;?>','<?=$row->task_time;?>','<?=$row->task_date;?>')">
                                                <i class="fa-solid fa-pen-to-square" style="color: #ffffff; margin: 0px; font-size: 16px; margin-left: -3px;"></i>
                                            </button>
                                            <h4 class="myh4 category">Task Name: <?=$row->task_name;?></h4>
                                            <h4 class="myh4 title"><a href="#"><?=find_a_field('crm_project_org','name','id="'.$row->organization_id.'"');?></a></h4>
                                            <h4 class="myh4 category">Task Date: <?=$row->task_date;?></h4>
                                            <h4 class="myh4 category">Task Time: <?=$row->task_time;?></h4>
                                            <h4 class="myh4 category">Task Remainder: <?=$row->reaminder_start_date;?> -||- <?=$row->reaminder_start_time;?></h4>
                                            <p class="description">Task Details:
                                                <?=$row->task_details;?>
                                            </p>
                                            <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModalCenter" data-task-id="<?=$row->task_id;?>" data-task-name="<?=$row->task_name;?>" data-task-details="<?=$row->task_details;?>" data-task-Date="<?=$row->task_date;?>"
                                            data-task-time="<?=$row->task_time;?>" onclick="openModalfortask('<?=$row->task_id;?>', '<?=$row->task_name;?>','<?=$row->task_details;?>','<?=$row->task_time;?>','<?=$row->task_date;?>')">
                                                Show More
                                            </button>
                                        </div>
                                    </div>
                                    <!-- end card -->
                                </div>
                            </div>
                            <?php } ?>
                    </div>
                </div>
                <?php */?>




                    <style>
                        /* Custom Styles */
						.nav{
						justify-content: space-around;
						}
                        .nav-tabs {
							padding:20px;
                            border: 1px solid #dee2e6;
                            background: linear-gradient(45deg, #b3c8ff, #7da5ff, #467cff, #0048ff); /* Soft background color */
                            border-radius: 5px;
                        }
                
                        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
                            color: #fff;
                            background-color: #D8F0FA;
                            border-color: #007bff;
                        }
                
                        .nav-tabs .nav-link {
                            color: #007bff;
                            border: 1px solid transparent;
                            border-radius: 5px;
                        }
                
                       .card-header {
                            background-color: #D3BEBD !important;
                            color: #fff;
                            border-radius: 5px 5px 0 0;
                        }
                
                			   /* Define different card colors */
                		.card-visit .card-header {
                			background: linear-gradient(45deg, #6ec979, #8DE697, #B6F3A8) !important; /* Blue color */
                			color: #fff; /* White text */
                		}
                		
                		.card-call .card-header {
                			background: linear-gradient(90deg, #96dcff, #14A6EF) !important; /* Green color */
                			color: #fff; /* White text */
                		}
                		
                		.card-meeting .card-header {
                			background: linear-gradient(45deg, #812f19, #943921, #9f4229, #ad4a32, #bb543b, #c85d44) !important; /* Yellow color */
                			color: #fff; /* White text */
                		}
                		
                		.card-email .card-header {
                			background: linear-gradient(45deg, #800000, #dc143c, #eb4667) !important; /* Red color */
                			color: #fff; /* White text */
                		}
                		.card-task .card-header {
                			background: linear-gradient(45deg, #c11ceb, #6f19b5, #25007a) !important; /* Red color */
                			color: #fff; /* White text */
                		}
                
                
                        .progress-bar-success {
                            background-color: #28a745;
                        }
                
                        .progress-bar-warning {
                            background-color: #ffc107;
                        }
                
                        .progress-bar-danger {
                            background-color: #dc3545;
                        }
                		
                		.card-margin {
                			margin-bottom: 1.875rem;
                		}
                		

                		
                		.card .card-header.no-border {
                			border: 0;
                		}
                		.card .card-header {
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
						padding:20px;
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
						display: flex;
                		  align-items: center;
                		  justify-content: center;
                		  flex-direction: column;
                		  color: #4e73e5;
                		  font-weight: 500;
                		  font-size: 1.5rem;
                		  line-height: 1;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-primary .widget-49-date-month {
						display: flex;
                		  align-items: center;
                		  justify-content: center;
                		  flex-direction: column;
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
                		  background-color: #fcfcfd;
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
                		  font-size: 14px;
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
                		.original-button {
                		  display: flex;
                		  align-items: center;
                		  justify-content: center;
                		  line-height: 1;
                		  text-decoration: none;
                		  color: #e80808;
                		  font-size: 15px;
                		  border-radius: 50px;
                		  width: 100px;
                		  height: 100px;
                		  font-weight: bold;
                		  transition: 0.3s;
                		  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.5);
                		  background-image: ;
                		}
                		
                		.original-button:hover {
                		  transform: translateY(2px);
                		  box-shadow: 0 0 rgba(0, 0, 0, 0);
                		}
                		
                		.complete-button {
                    display: inline-block;
                	margin:16px;
                    padding: 8px 8px;
                    background-color: #14A44D;
                    color: white;
                    text-align: center;
                    text-decoration: none;
                    border: none;
                    border-radius: 16px;
                    cursor: pointer;
                	}
                	
                	.complete-button:hover {
                		background-color: #14A44D;
                	}
                	
                	.complete-button:active {
                		background-color: #14A44D;
                	}
					
					
					.cancelled-button {
                    display: inline-block;
                	margin:16px;
                    padding: 8px 8px;
                    background-color: #DC4C64;
                    color: white;
                    text-align: center;
                    text-decoration: none;
                    border: none;
                    border-radius: 16px;
                    cursor: pointer;
                	}
                	
                	.cancelled-button:hover {
                		background-color: #DC4C64;
                	}
                	
                	.cancelled-button:active {
                		background-color: #DC4C64;
                	}
					
					.pending-button {
                    display: inline-block;
                	margin:16px;
                    padding: 8px 8px;
                    background-color: #E4A11B;
                    color: white;
                    text-align: center;
                    text-decoration: none;
                    border: none;
                    border-radius: 16px;
                    cursor: pointer;
                	}
                	
                	.pending-button:hover {
                		background-color: #E4A11B;
                	}
                	
                	.pending-button:active {
                		background-color: #E4A11B;
                	}
					
                    </style>










          
            
   

  

</div>

</div>

</div>

<!-- Modal End Here -->




<!-- Meeting Cancel Modal -->
            <div class="modal fade" id="activityCancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                <div class="modal-dialog modal-body1" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Activity</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>


                        <form method="post">
                            <div class="modal-body">

                                <!-- <input type="hidden" name="product_individual_id" id="product_individual_id" value="" /> -->
                                <input type="hidden" name="activity_id" id="activity_id" value="" />
                              <!--  <input type="hidden" name="status" id="status" value="cancelled" />-->


                           <div class="form-outline mb-2">

                            <label for="">Change Status</label>
                            <select name="status" id="status">
								<option value=""></option>
								<?=foreign_relation('deal_status','id','status','1');?>
							</select>
                            
                            </div>



                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn1 btn1-bg-cancel" data-dismiss="modal">Cancel</button>
                                <input name="cancelActivity" type="submit" id="cancelactivity" value="OK" class="btn1 btn1-bg-submit">

                                <!-- <button type="submit" name="scCall" class="btn1 btn1-bg-submit">Save </button> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>






            <!-- Model product add information -->
            <div class="modal fade" id="productaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                <div class="modal-dialog modal-body1" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Product List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>


                        <form method="post" id="contacttable">
                            <div class="modal-body">

                                <input type="hidden" name="product_individual_id" id="product_individual_id" value="" />
                                <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />



                                <div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Lead Organization</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                        <p>
                                            <?=$orgname?>
                                        </p>
                                    </div>
                                </div>

                                <div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Product Name:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

                                        <select class="form-control req" name="product_id" id="product_id">

                                            <? foreign_relation('crm_lead_products','id','products',$product,'1'); ?>
                                        </select>
                                    </div>
                                </div>






                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn1 btn1-bg-cancel" data-dismiss="modal">Cancel</button>
                                <input name="productadd" type="submit" id="productadd" value="SAVE" class="btn1 btn1-bg-submit">
                                <input name="updateproduct" type="submit" id="productedit" value="Update" class="btn1 btn1-bg-update d-none">
                                <!-- <button type="submit" name="scCall" class="btn1 btn1-bg-submit">Save </button> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>


<!-- Model Status update information -->
            <div class="modal fade" id="statusmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-body1" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Lead Status Update</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <form method="post" id="statustable">
                            <div class="modal-body">

                                <input type="hidden" name="id" id="id" value="<?=$id?>" />

                                <div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Lead Status:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                        <select class="form-control req" name="status" id="status">
                                            <option>--Please Selected--</option>
                                            <? foreign_relation('crm_lead_status','id','status',$id,'1'); ?>
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn1 btn1-bg-cancel" data-dismiss="modal">Cancel</button>
                                <!-- <input  name="updatestatus" type="submit" id="productedit" value="Update" class="btn1 btn1-bg-update d-none"> -->
                                <!-- <button type="submit" class="btn btn-primary" id="orgsavebtn" name="insert">Save</button> -->

                                <input name="updatestatus" type="submit" id="orgentryeditbtn" value="Update" class="btn1 btn1-bg-update">
                            </div>
                        </form>
                    </div>
                </div>
            </div>




           <!-- product delete modal -->
            <div class="modal fade" id="productaddmodaldelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                <div class="modal-dialog modal-body1" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Products</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>


                        <form method="post" id="contacttable">
                            <div class="modal-body">

                                <!-- <input type="hidden" name="product_individual_id" id="product_individual_id" value="" /> -->
                                <input type="hidden" name="<?=$uniqueproduct?>" id="<?=$uniqueproduct?>" value="" />


                                <p>Are You sure ?</p>



                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn1 btn1-bg-cancel" data-dismiss="modal">Cancel</button>
                                <input name="deleteproduct" type="submit" id="deleteproduct" value="Delete" class="btn1 btn1-bg-submit">
                                <input name="deleteproduct" type="submit" id="deleteproduct" value="Update" class="btn1 btn1-bg-update d-none">
                                <!-- <button type="submit" name="scCall" class="btn1 btn1-bg-submit">Save </button> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
			
			
<!-- Model contact add information -->
            <div class="modal fade" id="contactmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Contact Information</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>


                        <form id="contactformidnew" method="post">
                            <div class="modal-body">

                                <!--<input type="hidden" name="id" id="id" value="5" />-->
                                <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
                                <input type="hidden" name="activity_type" value="Call" />
                                <input type="hidden" name="main" value="1" />


                                <div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Lead Organization</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                        <p>
                                            <?=$orgname?>
                                        </p>
                                    </div>
                                </div>

                                <div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Contact Person Name:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

                                        <input class="form-control req" name="contact_name" id="contact_name">
                                    </div>
                                </div>


                                <div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Contact Person Mobile:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

                                        <input class="form-control req" name="contact_phone" id="contact_phone">
                                    </div>
                                </div>

                                <div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Contact Person Email:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                        <input type="text" name="contact_email" id="contact_email" value="" class="form-control req" />
                                    </div>
                                </div>

                                <div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Contact Person Designation:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                        <input type="text" name="contact_designation" id="contact_designation" value="" class="form-control req" />
                                    </div>
                                </div>



                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn1 btn1-bg-cancel" data-dismiss="modal">Cancel</button>
                                <input name="contactSubmit" type="submit" id="contactsave" value="SAVE" class="btn1 btn1-bg-submit">
                                <input name="updatecontact" type="submit" id="contactedit" value="Update" class="btn1 btn1-bg-update d-none">
                                <!-- <button type="submit" name="scCall" class="btn1 btn1-bg-submit">Save </button> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Model contact EDIT information -->







<!-- add task modal -->
            <div class="modal fade" id="addtaskmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content w-100">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Task</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <div class="modal-body m-3">
                            <form action="" method="post" enctype="multipart/form-data">

                                <div class="form-outline mb-2">
                                    <!-- <input name="task_name" id="task_name" value="" type="text" id="form3Example3" class="form-control form-control-lg" placeholder="Enter your task name" /> -->
                                </div>

                                <input type="text" name="lead_id" id="lead_id" value="<?=$id?>" />
                                <input type="hidden" name="activity_id" id="activity_id" value="<?=$activityd?>" />
                                <div class="form-outline mb-3">
                                    <select class="form-control form-control-lg">
                                        <option value="<?=$orgname?>">
                                            <?=$orgname?>
                                        </option>
                                        <!-- <? //foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id');?> -->
                                    </select>
                                </div>

                                <div class="form-outline mb-2">
                                    <textarea style="font-size: 14px;" class="form-control form-control-lg mb-2" type="text" name="task_details" id="task_details" cols="30" rows="5" placeholder="Tasks Details"></textarea>
                                </div>

                                <div class="form-outline mt-4 mb-2">
                                    <label for="">Enter task date</label>
                                    <input type="date" class="form-control form-control-lg" style="margin-top: 1em !important;" name="task_date" id="task_date" placeholder="Subject">
                                </div>
                                <div class="form-outline mb-2">
                                    <label for="">Enter task Time</label>
                                    <input type="time" class="form-control form-control-lg" style="margin-top: 1em !important;" name="task_time" id="task_time" placeholder="Subject">
                                </div>
																<div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Status:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                        <select class="form-control req" name="status" required>
                                            <option></option>
											<?=foreign_relation('deal_status','id','status','1');?>
                                        </select>
                                    </div>
                                </div>
								
								<div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Priority Status:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                        <select class="form-control req" name="priority_status" required>
                                            <option ></option>
											<?=foreign_relation('crm_priority_status','id','priority_status','1');?>
                                        </select>
                                    </div>
                                </div>
								
                                <div class="form-outline mb-2">
                                    <label for="">Enter Remainder Date</label>
                                    <input type="date" class="form-control form-control-lg" style="margin-top: 1em !important;" name="reaminder_start_date" id="reaminder_start_date" placeholder="Subject">
                                </div>
                                <div class="form-outline mb-2">
                                    <label for="">Enter Remainder Time</label>
                                    <input type="time" class="form-control form-control-lg" style="margin-top: 1em !important;" name="reaminder_start_time" id="reaminder_start_time" placeholder="Subject">
                                </div>

                                <div class="text-center text-lg-start mt-4 pt-2">
                                    <input type="submit" name="insertTasks" id="submit" value="submit" class="btn btn-primary btn-lg" />
                                    <!-- <input name="reset" type="button" class="btn btn-danger btn-lg" id="reset" value="RESET" onclick="parent.location='show_all_tasks.php'"> -->
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>





        <!--Schedule a call Modal Start-->
            <div class="modal fade" id="schedulecall" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Schedule a call</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>


                        <form method="post">
                            <div class="modal-body">
                                <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
                                <input type="hidden" name="call_main" value="Schedule" />
                                <input type="hidden" name="activity_type" value="Call" />
                                <input type="hidden" name="main" value="1" />

                                <div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Lead Organization</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                        <p>
                                            <?=$orgname?>
                                        </p>
                                    </div>
                                </div>
                                <!-- <div class="form-group row m-0 pt-1"> -->
                                <!-- <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Select call Lead:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0"> -->

                                <!-- <select class="form-control req" name="lead_id" id="lead_id">
                                <? 
                               // if($user_role=="Admin"){
                                   // foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id');
                               // }else{
                                //foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id and l.assign_person="'.$pbi_id.'"'); 
                                //}?>
                            </select> -->
                                <!-- </div>
                    </div> -->


                                <div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call to:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

                                        <input class="form-control req" name="call_to" id="call_to">
                                    </div>
                                </div>


                                <div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call type:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                        <select class="form-control req" name="call_type" required>
                                            <option></option>
                                            <option value="Inbound Call">Inbound Call</option>
                                            <option value="Outbound Call">Outbound Call</option>
                                        </select>
                                    </div>
                                </div>
								
								<div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Status:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                        <select class="form-control req" name="status" required>
                                            <option></option>
											<?=foreign_relation('deal_status','id','status','1');?>
                                        </select>
                                    </div>
                                </div>
								
								<div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Priority Status:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                        <select class="form-control req" name="priority_status" required>
                                            <option ></option>
											<?=foreign_relation('crm_priority_status','id','priority_status','1');?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call Date:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                        <input type="text" name="date" id="date" value="" class="form-control req" />
                                    </div>
                                </div>

                                <div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call Time:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                        <input type="time" name="time" id="time" value="" class="form-control req" />
                                    </div>
                                </div>


                                <div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call Purpose:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                        <input type="text" name="subject" id="subject" value="" class="form-control req" />
                                    </div>
                                </div>

                                <div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Note:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                        <textarea class="form-control req1" name="details"></textarea>
                                    </div>
                                </div>




                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn1 btn1-bg-cancel" data-dismiss="modal" >Cancel</button>
                                <button type="submit" name="scCall" class="btn1 btn1-bg-submit">Save </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--Schedule a call Modal End-->


<!-- Model Convert lead  -->
<div class="modal fade" id="convertToLead" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">

        <div class="modal-content">

        <div class="modal-header">

            <h3 class="modal-title" id="exampleModalLongTitle">Organization to Lead Convert</h3>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true" style="font-size:30px !important; color: red;">&times;</span>

            </button>

          </div>

          <form id="converttoleadform" method="post" >

          <input type="hidden" name="organization" id="organization">

          <div class="modal-body">

          <h5 class=text-center>Lead Information</h5>

            <div class="row">
                <div class="col-6">
				 <table class="table">
                    <tbody>
					<tr>
						<td>Organization Name</td>
            <td ><input type="hidden" name="lead_name" class="form-control validate-name" id="form1" value="<?=$orgname?>"></td>
						<!-- <td><select  name="organization"  class=" input_general"  >
              <option id="converttoleadidioption" value=""></option>
						<? foreign_relation('crm_project_org','id','name',$orgAll->id,'id='.$orgAll->id); ?>
						</select></td> -->
						</tr>
						<tr>
							<td>Enter Lead Name</td>
						 
								<td>
								<div >
							<input type="text" name="lead_name" class="form-control validate-name" id="form1" value="<?=$orgname?>">
								</div>
								
								</td>
						<!-- <td>Product</td>
						<td><select  name="product"  class=" input_general" required >
						<option></option>
						<? //foreign_relation('crm_lead_products','id','products',$product,'1'); ?>
						</select></td> -->
						</tr>
						 <tr>	
							<td>Amount</td>
						 
							<td>
								<div >
								<input class="form-control" type="text" name="lead_value" id="lead_value">
								</div>
							
							</td>
						</tr>
						</tbody>
						</table>
						

                </div>
				
				<div class="col-6">
				<table class="table">
                    <tbody>
					<tr>
						<td>Deal Stage</td>
						<td><select  name="status"  class=" input_general" required >
						<option></option>
						<? foreign_relation('crm_deal_stage_status','id','status',$lead_status,'1'); ?>
						</select></td>
						</tr>
						<tr>
						<td>Assign Person</td>
						<td><select  name="assign_person"  class=" input_general" required >
						<option></option>
						<? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$assign_person,'1'); ?>
				</select></td>
						</tr>
						
						<tr>
						<td>Campaign</td>
						<td><select  name="campaign"  class=" input_general" required >
						<option></option>
						<? foreign_relation('crm_campaign_management','id','camp_name',$campaign,'1'); ?>
				</select></td>
						</tr>
						
						
						
						<tr>
						<td>Closing Date</td>
						<td><input class="form-control" type="date" name="closing_date" id="closing_date"></td>
						</tr>
						
						
					</tbody>
					</table>
				
				</div>
				
				
            </div>
			<div class="modal-footer">

            <button type="submit" class="btn btn-primary" name="insertconverttolead">Save</button>

          </div>
          </form>

          

        </div>

      </div>

</div>
         
 


 <!--Meeting Modal 1st Start-->
            <div class="modal fade " id="schedulemeeting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content w-100">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Meeting Add </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <form method="post">
                            <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
							<input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
                            <div class="modal-body">


                                <input type="hidden" name="activity_type" value="Meeting" />
                                <div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Lead Organization</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                        <p>
                                            <?=$orgname?>
                                        </p>
                                    </div>
                                </div>




                                <div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Meeting Type:</label>

                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                        <select class="form-control req" name="meeting_type">
                                            <option value="Online">Online </option>
                                            <option value="Offline">Offline</option>
                                        </select>
                                    </div>
                                </div>



                                <div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Meeting Subject:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                        <input type="text" name="subject" id="subject" value="" class="form-control req" />
                                    </div>
                                </div>

                                <div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Location:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                        <input type="text" name="location" id="location" value="" class="form-control req" />
                                    </div>
                                </div>
								<div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Status:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                        <select class="form-control req" name="status" required>
                                            <option></option>
											<?=foreign_relation('deal_status','id','status','1');?>
                                        </select>
                                    </div>
                                </div>
								
								<div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Priority Status:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                        <select class="form-control req" name="priority_status" required>
                                            <option ></option>
											<?=foreign_relation('crm_priority_status','id','priority_status','1');?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Visit Date:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                        <input type="date" name="date" id="date" value="" class="form-control req" />
                                    </div>
                                </div>
                                <div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Visit Time:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                        <input type="time" name="time" id="time" value="" class="form-control req" />
                                    </div>
                                </div>


                                <div class="form-group row m-0 pt-1">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Note:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                        <textarea class="form-control req1" name="details"></textarea>
                                    </div>
                                </div>




                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn1 btn1-bg-cancel" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="scCall" class="btn1 btn1-bg-submit">Save </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--Meeting  Modal 1st End-->


            <!-- Update task modal -->
            <?
$sqlTasks = "SELECT * FROM crm_task_add_information WHERE lead_id=$id   ORDER BY task_id DESC";
$resultTasks = db_query($sqlTasks);

while ($row = mysqli_fetch_object($resultTasks)) {
?>



                <div class="modal fade " id="updatetaskmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content w-100">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Update Task </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            <div class="modal-body m-3  ">
                                <form action="#" method="post" enctype="multipart/form-data">


                                    <div class="form-outline mb-2">

                                        <input name="task_name" id="newTaskName" type="text" class="form-control form-control-lg" value="<?=$row->task_name;?>" placeholder="Enter your task name" />


                                    </div>

                                    <input type="text" name="lead_id" id="lead_id" value="<?=$id?>" />
                                    <input type="hidden" name="activity_id" id="activity_id" value="<?=$activityd?>" />
                                    <div class="form-outline mb-3">

                                        <select class="form-control form-control-lg ">
                                            <option value="<?=$orgname?>">
                                                <?=$orgname?>
                                            </option>
                                            <!-- <? //foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id');?> -->
                                        </select>

                                    </div>
                                    <!-- <div class="form-outline mb-3">

                                <select class="form-control form-control-lg ">
                                    <option value="<?//=$orgname?>"><?//=$orgname?></option>
                                                <? //foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id');?> -->
                                    <!-- </select> -->

                                    <!-- </div> -->

                                    <div class="form-outline mb-2">

                                        <textarea style=" font-size: 14px;" class="form-control form-control-lg  mb-2" type="text" name="task_details" id="task_details" cols="30" rows="5" placeholder="Tasks Details" value="<?=$row->task_details;?>"></textarea>

                                    </div>


                                    <div class="form-outline mt-4 mb-2">
                                        <label for="">Enter task date </label>
                                        <input type="date" class="form-control form-control-lg " style="margin-top:1em !important;" name="task_date" id="task_date" placeholder="Subject" value="<?=$row->task_date;?>">

                                    </div>
                                    <div class="form-outline mb-2">
                                        <label for="">Enter task Time</label>
                                        <input type="time" class="form-control form-control-lg " style="margin-top:1em !important;" name="task_time" id="task_time" placeholder="Subject" value="<?=$row->task_time;?>>
                            
                            </div>
                            <div class=" form-outline mb-2 ">
                            <label for=" ">Enter Remainder Date</label>
                            <input type="date " class="form-control form-control-lg " style="margin-top:1em !important; " name="reaminder_start_date " id="reaminder_start_date "   placeholder="Subject " value="<?=$row->task_date;?>">

                                    </div>
                                    <div class="form-outline mb-2">

                                        <label for="">Enter Remainder Time</label>
                                        <input type="time" class="form-control form-control-lg " style="margin-top:1em !important;" name="reaminder_start_time" id="reaminder_start_time" placeholder="Subject" value="<?=$row->task_date;?>">

                                    </div>

                                    <div class="text-center text-lg-start mt-4 pt-2">



                                        <input type="submit" name="insertTasks" id="submit" value="Update" class="btn btn-primary btn-lg" />
                                        <!-- <input name="reset" type="button" class="btn btn-danger  btn-lg" id="reset" value="RESET" onclick="parent.location='show_all_tasks.php'"> -->


                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>

                    <?
}
?>
                        <!-- Update task modal End-->


                </div>






                </section>
    </div>

    </div>



    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>



  

    <?
require_once SERVER_CORE."routing/layout.bottom.php";
?>