<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
 

$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);

$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');

$pbi_id  =  $_SESSION['employee_selected'];
$user_role  =  $_SESSION['user']['fname'];

$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"');

 $cur = '&#x9f3;';
//require "../include/custom.php";
 $title = "All ".$CRMleadName." List";

 $tablecustomerlist1 = 'crm_project_org';
 $table2 = 'crm_org_contacts';

 $crud1 = new crud( $tablecustomerlist1);
 $crud2 = new crud($table2);

 if (isset($_POST['insert'])) {
  try {
      $_POST['entry_by'] = $_SESSION['employee_selected'];

      // Insert Logo --Start--
		$folder='Organization_logo';
		$field = 'logo'; 
		$file_name = $folder.'-'.strtotime('now');
		
		if($_FILES['logo']['tmp_name']!=''){
		  $_POST['logo']=upload_file($folder,$field,$file_name);
		
		}
      // Insert Logo --End--
	  
	  // Insert visiting_card_img Start--
		$folder='Organization_card';
		$field = 'visiting_card_img'; 
		$file_name = $folder.'-'.strtotime('now');
		
		if($_FILES['visiting_card_img']['tmp_name']!=''){
		  $_POST['visiting_card_img']=upload_file($folder,$field,$file_name);
		}
      // Insert visiting_card_img End--

      $crud1->insert();

      // Uncomment the following lines if you want to capture errors in the subsequent code block
      // $lastId = getLastInsertID($tablecustomerlist1, 'id');
      // foreach ($_POST['contact_name1'] as $key => $value) {
      //     // Your existing code here
      // }

      // Additional code...

  } catch (Exception $e) {
      // Display or log the error message
      echo "Error: " . $e->getMessage();
  }
}



if(isset($_POST['insertconverttolead'])){
  $table1 = 'crm_lead_manage';
$crud1 = new crud($table1);
$_POST['entry_at']=date('Y-m-d h:i:sa');
$_POST['entry_by'] = $_SESSION['user']['id'];
$log_id=$crud1->insert();

$cd= new crud('crm_lead_log');
 $_POST['lead_id']=$log_id;
 $cd->insert(); 	

// echo "<script>window.top.location='/crm_mod/pages/home/home.php'<script>";
}

if(isset($_POST['updateentrylead'])){
  $crud= new crud('crm_project_org');
  $crud->update('id');
  //  db_query('delete from crm_org_contacts where project_id="'.$id.'"');
  //     foreach ($_POST['contact_name1'] as $key => $value) { 
  //    if($_POST['contact_name1'][$key]!='') {
  //  $sql='INSERT INTO `crm_org_contacts`( `project_id`, `contact_name`, `contact_phone`, `contact_email`, `contact_designation`, `entry_by`, `entry_at`) VALUES ("'.$id.'","'.$_POST['contact_name1'][$key].'","'.$_POST['contact_phone1'][$key].'","'.$_POST['contact_email1'][$key].'","'.$_POST['contact_designation1'][$key].'","'.$_SESSION['user']['id'].'","'.date('Y-m-d H:i:s').'")';
  //  db_query($sql);
  //  }
             
  //     }
    
    // echo "<script>window.top.location='/crm_mod/pages/home/home.php'<script>";
    
  }


 

 if(isset($_POST['update'])){

     

      // update Logo --Start--
		$folder='Organization_logo';
		$field = 'logo'; 
		$file_name = $folder.'-'.strtotime('now');
		
		if($_FILES['logo']['tmp_name']!=''){
		  $_POST['logo']=upload_file($folder,$field,$file_name);
		
		}
      // update Logo --End--
	  
	  // update visiting_card_img Start--
		$folder='Organization_card';
		$field = 'visiting_card_img'; 
		$file_name = $folder.'-'.strtotime('now');
		
		if($_FILES['visiting_card_img']['tmp_name']!=''){
		  $_POST['visiting_card_img']=upload_file($folder,$field,$file_name);
		}
      // update visiting_card_img End--
	 



     $_POST['update_by'] = $_SESSION['employee_selected'];

     $_POST['update_at'] = date('Y-m-d h:s:i');

     

     $crud1->update('id');

 }

 

 
//end



$unique='task_id'; 
$title = "Leads";



$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');


//$table='crm_task_add_information';	


// $title = "All Lead List";

 

$tableprojectlead = 'crm_project_lead';

$tableleadcontacts = 'crm_lead_contacts';

$pbi_id  =  $_SESSION['employee_selected'];
$user_role  =  $_SESSION['user']['fname'];



$crud1 = new crud($table1);

//$crud2 = new crud($table2);









// Database Table Name Mainly related to this page

$crud    =new crud($table);
//for update..................................
// if(isset($_POST['update']))
// {
// $_POST['edit_at']=time();
// $_POST['edit_by']=$_SESSION['user']['id'];
// 		$crud->update($unique);
// 		$type=1;
// 		$msg='Successfully Updated.';
// }

$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"');



/*if($_SESSION['employee_selected']==0 || $_SESSION['employee_selected']==''){



header('location:../../../crm_mod/pages/home/index.php');



}*/



 

 $cur = '&#x9f3;';
 $table1 = 'crm_project_lead';

 //$table2 = 'crm_task_lists';

 //$table3 = 'crm_call_schedule';
 
 //$table4 = 'crm_campaign_management';

 

//  $crud1 = new crud($table1);

//  $crud2 = new crud($table2);

//  $crud3 = new crud($table3);
 
//  $crud4 = new crud($table4);

 


require "../include/custom.php";

//echo '<link rel="stylesheet" href="../include/Style/calendarStyle.css">';


?>



        <?php



            if(in_array($_SESSION['employee_selected'], $superID)){

                $con = "";

            }else{

                $con = " AND assigned_person_id = '".$_SESSION['employee_selected']."' ";

            } 

            

        	
// if(isset($$unique))
// {
// $condition=$unique."=".$$unique;	
// $data=db_fetch_object($table,$condition);
// foreach ($data as $key => $value)
// { $$key=$value;}
// }	
?>


        

<link rel="stylesheet" href="style.css">

<style>
.sidebar, .sidemenu{
	display:none;
    width: 0% !important;
}

.main_content{
	width: 100% !important;
}
  #example{
    margin: 0px !important;
  }
  .sorting{
    background-color: #f8fcfc !important;
  }
  .odd{
    background-color: 'red' !important;
  }

</style>

  <style>.nav-tabs .nav-link.active, .nav-tabs .nav-link.active:active, .nav-tabs .nav-link.active:focus, .nav-tabs .nav-link.active:visited, .nav-tabs .nav-link.active:hover{border-color: #bfc1f5;}
</style>










<style>
.sr-main-content-padding{
padding: 0px !important;

}
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


  .floatingshadowfahim{
    box-shadow: rgb(38 57 77 / 33%) 0px 20px 30px -10px;
    background-color: #fcfcfc !important;
	height: 100% !important;
    width: 100% !important;
    border-radius: 15px !important;
    padding: 15px !important;
  }
    .floatingshadowfahim .rounded{
	text-align:center;
	
	}
	
  .floatingshadowfahim h2 span, .floatingshadowfahim h2 i{
  	font-size:36px !important;
  }
  
  .floatingshadowfahim h2 span i, .floatingshadowfahim h2 i, .floatingshadowfahim h2 .textspan{
      top: 39px !important;
    position: relative;
  }
  
  .unplashscreen{
    /* background-color: whitesmoke; */
    /* background-image: url("bgunsplash3.jpg");
    background-size: cover; */
  }

  tr:nth-child(odd), tr:nth-child(even){
    /* box-shadow: rgb(38, 57, 77) 0px 20px 30px -10px; */
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    background-color: #f3f7fa !important;
  }
  thead, tbody, tfoot, tr, td, th {
    border: none !important;
}
tr{
  margin-top: 5px;
}
table {
    border-spacing: 0px 0.3rem !important;
}
.dataTables_wrapper .dataTables_filter input {
    margin-left: 0.5em;
    
}
label {
    display: inline-block;
    border-radius: 10px;
    padding-bottom:10px;
    padding-right:10px;
    padding-left:10px;
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    background-color: #f3f7fa !important;
}

.table>tbody {
    vertical-align: inherit;
   
}
.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
    width: 100px !important;
}

.dataTables_length label, .dataTables_filter  label{
display: flex;
    justify-content: center;
    align-items: center;
    padding-top: 9px;
}

#customerleadbutton{
z-index:100 !important;  
margin:5px; 
padding:10px !important; 
background-color: #0c8; 
color:#FFFFFF;
box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; 
cursor: pointer;
}
#customerleadbutton,#customerlistbutton{
    width: 135px;
    text-align: center;
}
#customerlistbutton{
z-index:100 !important;
 margin:5px; 
 padding:10px !important; 
 background-color: #3d90a7; 
color:#FFFFFF;
 box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
  cursor: pointer;
}

</style>


<!--       <style>
        .Cancel { background-color: #FFCCCC!important; } /* Light Coral */
        .Lost { background-color: #FF9999!important;} /* Light Salmon */
        .Active { background-color:#D8F0FA!important;} /* Pale green */
		.bg-c-Active {background: linear-gradient(45deg,#2ed8b6,#59e0c5);}
        .Won { background-color: #99CCFF !important; } /*Light Sky Blue*/
		.Proposal { background: #E6E6FA !important; }
		.Qualified { background-color: #FAFAD2 !important; }
		.Negotiation { background-color: #ADD8E6 !important; }
		.Closed { background-color: #CCFFCC !important; }
		.Junk { background-color: #F0E68C !important; }
		.No Bid { background-color: #B0C4DE !important; }
		
       </style>-->
	   
	   
<style>
    .Cancel { 
        background: linear-gradient(45deg, #ffcccc, #ffd6cc) !important; /* Light Coral */
    }
    .Lost { 
        background: linear-gradient(45deg, #ffcccc, #ffd6cc) !important; /* Light Salmon */
    }
    .Active {
        background: linear-gradient(45deg, #b3e6cc, #ccf2d6) !important; /* Light Green */
    }
    .Won { 
        background: linear-gradient(45deg, #cce6ff, #ccf2ff) !important; /* Light Blue */
    }
    .Proposal { 
        background: linear-gradient(45deg, #f2f2f2, #ffffcc) !important; /* Light Gray to Light Yellow */
    }
    .Qualified { 
        background: linear-gradient(45deg, #ffffcc, #ffffe0) !important; /* Light Yellow */
    }
    .Negotiation { 
        background: linear-gradient(45deg, #ccf2ff, #e6f9ff) !important; /* Light Cyan */
    }
    .Closed { 
        background: linear-gradient(45deg, #d9ead3, #e6f2d5) !important; /* Light Green */
    }
    .Junk { 
        background: linear-gradient(45deg, #f2f2f2, #ffffcc) !important; /* Light Gray to Light Yellow */
    }
    .NoBid { 
        background: linear-gradient(45deg, #ccd9e6, #d9d9d9) !important; /* Light Blue to Light Slate Gray */
    }
</style>


	   
	   
	   

<script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>



 
 
 
 

 <div class="container-fluid p-5">
 
 


  
	   
	   
 <div id="leadlistid">
        <div class="m-0 p-0 ">

                <table id="example1" class="table">
                                <thead>

                            <tr>
                                    <th>SN</th>
                                    
                                    <th>Subject</th>
									<th>Project</th>
                            		<th>type</th>

                                    <th>Deadline</th>
									
									
                            		<th>Entry at</th> 
									<th>Status</th>

                                    <th>Action</th>

                            </tr>

                                </thead>

                                <tbody>

                                

                                <?php 

                                

                                    $sn = 1;

                                    if(in_array($_SESSION['employee_selected'], $superID)){

                                        $con = " 1 ";

                                    }else{

                                        $con = " assigned_person_id = '".$_SESSION['employee_selected']."' ";

                                    }

                                    
                                    if($user_role=="Admin"){
                                  
                                        $tasksQry = "SELECT * FROM `crm_lead_activity` WHERE `mode` LIKE 'postsale'";
                                        
                                    }else{
                                        $tasksQry = "SELECT * FROM `crm_lead_activity` WHERE `mode` LIKE 'postsale'";
                                    }
                                    
                                
                                    $rslt = db_query($tasksQry);

                                    while($row = mysqli_fetch_object($rslt)){
									
		

                                ?>

                                

                                    <tr >

                                        <td><?=$sn?></td>
										<td><?=$row->subject?></td>
                                        <td><?=find_a_field('crm_project_org', 'name', 'id = "'.$row->project_id.'"')?></td>
                                        <td><?=$row->activity_type?></td>
										<td><?=$row->deadline?></td>
										
										<td><?=$row->time?> // <?=$row->date?></td>
										
										
										
										
<td><?php
        $status = find_a_field('deal_status', 'status', 'id='.$row->status);
        
        // Assign badge classes based on the status
        $badgeClass = '';
        if ($status == 'Pending') {
            $badgeClass = 'badge-warning';  // Yellow badge for Pending
        } elseif ($status == 'Complete') {
            $badgeClass = 'badge-success';  // Green badge for Complete
        } elseif ($status == 'Cancel') {
            $badgeClass = 'badge-danger';   // Red badge for Cancel
        }
        ?>
        <div class="badge <?=$badgeClass?>"><?= $status; ?></div></td>

                                        <td class="d-flex">

										<a class="btn2 btn1-bg-submit text-light mr-2" 
										href="../home/tasks_detail_update.php?view=<?=encrypTS($row->activity_id)?>"><i class="fa-solid fa-eye"></i></a>
					
					
					
					 

                                        </td>

                                    </tr>

                                

                                <?php 

                                

                                    $sn++;

                                    

                                    } 

                                    

                                ?>

                                

                                </tbody>
                </table>   



        </div>

 </div>













</div>







<!-- Modal End Here -->



<script>

var i=1;

$("#add_row").click(function(){



$('#addr0').append('<div class="row" id="cv'+i+'"><div class="col-md-12"><button idk="'+i+'" class="btn btn-danger btn_remove">X</button></div><div class="col-md-6"> <table class="table"> <tbody><tr><td>Contact Person </td><td><input type="text" name="contact_name1[]" style="border-left:3.5px solid #df5b5b!important;" class="form-control" required></td></tr><tr><td>Phone </td><td><input type="text" name="contact_phone1[]" class="form-control " style="border-left:3.5px solid #df5b5b!important;"  ></td></tr></tbody></table></div><div class="col-md-6"> <table class="table"> <tbody><tr><td>Email </td><td><input type="text" name="contact_email1[]" style="border-left:3.5px solid #df5b5b!important;" class="form-control" ></td></tr><tr><td>Designation </td><td><input type="text" name="contact_designation1[]" class="form-control " style="border-left:3.5px solid #df5b5b!important;"  ></td></tr></tbody></table></div><div class="col-md-6"> <table class="table"> <tbody><tr><td>Department </td><td><input type="text" name="dept[]" style="border-left:3.5px solid #df5b5b!important;" class="form-control"></td></tbody></table></div></div>');
i++;
});



$(document).on('click', '.btn_remove', function () {

    var button_id = $(this).attr("idk");

    $('#cv' + button_id + '').remove();

   

 });

 






</script>



 </div>


</div>
</div>



<!-- Model Convert lead  -->

         
 



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById('leadChart').getContext('2d');
        var leadData = {
            labels: ['Total Active Lead', 'Total Generated Lead'],
            datasets: [{
                data: [
                    <?=find_a_field('crm_project_lead', 'count(id)', 'status = "1"')?>,
                    <?=find_a_field('crm_project_lead', 'count(id)', '1')?>
                ],
                backgroundColor: ['#01307e', '#0d57b9']
            }]
        };
        var leadChart = new Chart(ctx, {
            type: 'pie',
            data: leadData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom'
                }
            }
        });
    });

    function openModalleadentry(orgId, orgName, orgwebsite,orgyearlyturnover,sourcename,orgemployee,orgtype,orgaddress,orgdistrict,
	orgzip,orgcountry,orgdivision,orgdescription,orgconperson,orgconnumber,orgconmail) {
      orgdescription = orgdescription.replace(/"/g, "");

      // description = description.replace(/\n/g, '<br>');

 
      
        // document.getElementById('id').value = contactId;
        document.getElementById('orgsavebtn').classList.add('d-none');// or 'inline' depending on your styling
        document.getElementById('orgentryeditbtn').classList.remove('d-none');// or 'inline' depending on your styling
        document.getElementById('orgname').value = orgName;
 
       var selectElement = document.getElementById('lead_source');
// Check if the correct select element is found
for (var i = 0; i < selectElement.options.length; i++) {
  // Check the value of each option
    if (selectElement.options[i].value == sourcename) {
        selectElement.options[i].selected = true;
        break;
    }
}
        // document.getElementById('lead_type').value = orgName;
       var selectElement = document.getElementById('lead_type');
// Check if the correct select element is found
for (var i = 0; i < selectElement.options.length; i++) {
    // Check the value of each option
    if (selectElement.options[i].value == orgtype) {
        selectElement.options[i].selected = true;
        break;
    }
}
       var selectElement = document.getElementById('district');
// Check if the correct select element is found
for (var i = 0; i < selectElement.options.length; i++) {
    // Check the value of each option
    if (selectElement.options[i].value == orgdistrict) {
        selectElement.options[i].selected = true;
        break;
    }
}
       var selectElement = document.getElementById('zip');
// Check if the correct select element is found
for (var i = 0; i < selectElement.options.length; i++) {
    // Check the value of each option
    if (selectElement.options[i].value == orgzip) {
        selectElement.options[i].selected = true;
        break;
    }
}
       var selectElement = document.getElementById('country');
// Check if the correct select element is found
for (var i = 0; i < selectElement.options.length; i++) {
    // Check the value of each option
    if (selectElement.options[i].value == orgcountry) {
        selectElement.options[i].selected = true;
        break;
    }
}
       var selectElement = document.getElementById('division');
// Check if the correct select element is found
for (var i = 0; i < selectElement.options.length; i++) {
    // Check the value of each option
    if (selectElement.options[i].value == orgdivision) {
        selectElement.options[i].selected = true;
        break;
    }
}

        document.getElementById('annual_revenue').value = orgyearlyturnover;
        document.getElementById('website').value = orgwebsite;
        document.getElementById('total_employees').value = orgemployee;
        document.getElementById('orgaddress').value = orgaddress;
		document.getElementById('contact_person').value = orgconperson;
		document.getElementById('contact_number').value = orgconnumber;
		document.getElementById('contact_email').value = orgconmail;
	    // document.getElementById('lead_type').value = orgtype;
        
        var idInput = document.createElement('input');
        idInput.setAttribute('type', 'hidden');
        idInput.setAttribute('name', 'id');
        idInput.setAttribute('id', 'id');
        idInput.setAttribute('value', orgId);

        // Append the id input field to the form using the form's ID
        var form = document.getElementById('organizationentrytable');
        form.appendChild(idInput);

        document.getElementById('description').value = orgdescription;

    }
    function openModalConverttolead(orgId,orgName) {
 
      document.getElementById('organization').value = orgId;
      document.getElementById('organizationnamelead').value = orgName;
    }
  
</script>


<script>
        $(document).ready(function () {
        $('#example1').DataTable();
		$('#example').DataTable();
		 table.page.len(10).draw();
    });

    $('#leadentrymodal').on('hidden.bs.modal', function(e) {
  $(this).find('#organizationentrytable')[0].reset();
});
    $('#convertToLead').on('hidden.bs.modal', function(e) {
  $(this).find('#converttoleadform')[0].reset();
});
		
	
//	$(document).ready(function() {
//    // Initialize DataTable
//    var table = $('#example').DataTable();
//
//    // Set the length of displayed records
//
//});

</script>

<script>
function togglecustomerlist(){
    document.getElementById("customerlistid").style.display = "block";

    //document.getElementById("customerlistbutton").style.transform = "scale(0.8)";
    document.getElementById("customerlistbutton").style.backgroundColor = "#0c8";
    document.getElementById("customerleadbutton").style.backgroundColor = "#3d90a7";
    document.getElementById("customerleadbutton").style.transform = "scale(1)";
    document.getElementById("leadlistid").style.display = "none";
}

function toggleleadlist(){
    document.getElementById("leadlistid").style.display = "block";

    //document.getElementById("customerleadbutton").style.transform = "scale(0.8)";
    document.getElementById("customerleadbutton").style.backgroundColor = "#0c8";
    document.getElementById("customerlistbutton").style.backgroundColor = "#3d90a7";
    document.getElementById("customerlistbutton").style.transform = "scale(1)";
    document.getElementById("customerlistid").style.display = "none";
}
</script>












<?
require_once SERVER_CORE."routing/layout.bottom.php";

?>










