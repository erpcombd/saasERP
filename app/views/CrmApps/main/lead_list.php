<? 
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
//require_once '../../../controllers/core/init.php';


$cid = $_SESSION['proj_id'];

$page="home";

include_once('../template/header.php'); 

require "../include/custom.php";

$u_id  =  $_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);
$basic = find_all_field('personnel_basic_info','','PBI_ID="'.$PBI_ID.'"');

 $cur = '&#x9f3;';
 $table1 = 'crm_project_lead';
 
 


?>


<style>
    .Cancel { 
        background-color: #ff4d4d !important; /* Red */
    }
    .Lost { 
        background-color: #ff704d !important; /* Dark Salmon */
    }
    .Active {
        background-color: #66cc66 !important; /* Green */
    }
    .Won { 
        background-color: #4da6ff !important; /* Blue */
    }
    .Proposal { 
        background-color: #cccccc !important; /* Gray */
    }
    .Qualified { 
        background-color: #ffff66 !important; /* Yellow */
    }
    .Negotiation { 
        background-color: #66d9ff !important; /* Cyan */
    }
    .Closed { 
        background-color: #85e085 !important; /* Medium Green */
    }
    .Junk { 
        background-color: #cccccc !important; /* Gray */
    }
    .NoBid { 
        background-color: #99aabb !important; /* Slate Blue */
    }
</style>





    <div class="page-content header-clear-medium">

        <div class="card card-style">
            <div class="content">
                <h1>Lead List</h1>
        
             
            </div>
        </div>

        <style>
            @keyframes modal-icon {
                0% {transform:scale(1, 1); opacity:0.5;}
                50% {transform:scale(1.1, 1.1); opacity:1}
                100% {transform:scale(1, 1); opacity:0.5;}
            }
            .modal-icon{animation:modal-icon 1.6s; animation-iteration-count: infinite;}

            @keyframes action-icon {
                0% {transform:translateY(0px); opacity:1;}
                50% {transform:translateY(5px); opacity:0.5}
                100% {transform:translateY(0px); opacity:1;}
            }
            .action-icon{animation:action-icon 1.6s; animation-iteration-count: infinite;}
        </style>
		
		<? 
		
		   $sn = 1;
		
		  $leadsQry = "SELECT a.*,o.name FROM $table1 a,crm_project_org o WHERE a.organization=o.id and a.assign_person=$PBI_ID ORDER BY a.id DESC";
		  $rslt = db_query($leadsQry);

          while($row = mysqli_fetch_object($rslt)){
		  
			$entryAt = $row->entry_at;
			$formattedDate = date('d M, Y', strtotime($entryAt));
			$formattedTime = date('h:i A', strtotime($entryAt));
		    // for warning by color
		  $status = $row->status;
				
		
		
		  if($row->status ==1){
          $status = 'Active';
          }elseif($row->status ==2){
          $status = 'Lost';
          }elseif($row->status ==3){
		  $status = 'Won';
		  }elseif($row->status ==4){
		  $status = 'Cancel';
		  }elseif($row->status ==5){
		  $status = 'No Bid';
		  }elseif($row->status ==6){
		  $status = 'Proposal';
		  }elseif($row->status ==7){
		  $status = 'Qualified';
		  }elseif($row->status ==8){
		  $status = 'Negotiation';
		  }elseif($row->status ==9){
		  $status = 'Closed';
		  }else{
		  $status = 'Junk';
		  }

		 
		 
		 
		       $class = '';
               switch ($status) {
                case 'Active':
                    $class = 'Active';
                    break;
                case 'Lost':
                    $class = 'Lost';
                    break;
                case 'Won':
                    $class = 'Won';
                    break;
				case 'Cancel':
                    $class = 'Cancel';
                    break;
				case 'No Bid':
                    $class = 'NoBid';
                    break;
				case 'Proposal':
                    $class = 'Proposal';
                    break;
				case 'Qualified':
                    $class = 'Qualified';
                    break;
				case 'Negotiation':
                    $class = 'Negotiation';
                    break;
				case 'Closed':
                    $class = 'Closed';
                    break;
					
				case 'Junk':
                    $class = 'Junk';
                    break;

            }

		
		?>	 
		
        <a href="../info_maker/lead_details_show.php?view=<?=encrypTS($row->id)?>&tp='<?=encrypTS('lead')?>'">
		
            <div class="card card-style bg-5 py-4" data-card-height="120">
                <div class="card-center px-4">
                    <div class="d-flex">
<!--                        <div class="align-self-center">
                            <i class="far fa-minus-square color-green-dark fa-2x mt-1 modal-icon"></i>
                        </div>-->
                        <div class="align-self-center ps-4">
                            <h1 class="font-23 mb-0 color-white"><?=$row->name?></h1>
                            <p class="font-11 opacity-50 mt-n2 mb-0 color-white"><?=$row->lead_name?></p>
							<p class="font-11 opacity-50 mt-n2 mb-0 color-white"><?=$formattedDate?> <?=$formattedTime?></p>
                        </div>

                        <div class="aling-self-center ms-auto">
                            <!--<i class="fa fa-arrow-right pt-3 color-white opacity-60"></i>-->
							<a href="../info_maker/lead_details_show.php?view=<?=encrypTS($row->id)?>&tp='<?=encrypTS('lead')?>'" class="btn btn-m float-end rounded-xl shadow-xl text-uppercase font-800 <?=$class?> fa-2x mt-1 modal-icon bg-highlight"><?=find_a_field('crm_lead_status', 'status', 'id = "'.$row->status.'"')?></a>
                        </div>
                    </div>
                </div>
                <div class="card-overlay bg-black opacity-80"></div>
            </div>
        </a>

    <?       } ?>    

        


    </div>

    <!-- End of Page Content-->
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
                backgroundColor: ['#F7E3EE', '#D8F0FA']
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






	
<?php include_once('../template/link_footer.php'); ?>