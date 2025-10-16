<? 
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
require_once '../assets/support/Calendar.php';
//require_once '../assets/support/crud.php';
require_once '../assets/support/custom.php';
//require_once '../assets/support/menu_dynamic.php';
require_once '../assets/support/mix_function.php';
require_once '../assets/support/reg__ajax.php';


$cid = $_SESSION['proj_id'];

$page="home";

require_once '../assets/template/inc.header.php';


$u_id  =  $_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);
$basic = find_all_field('personnel_basic_info','','PBI_ID="'.$PBI_ID.'"');

 $cur = '&#x9f3;';
 $table1 = 'crm_lead_manage';
 
  $tablecustomerlist1 = 'crm_project_org';




if(isset($_POST['insertconverttolead'])){

  echo "ddddddddd";
  $table1 = 'crm_project_lead';
$crud1 = new crud($table1);
$_POST['entry_at']=date('Y-m-d h:i:sa');
$_POST['entry_by'] = $_SESSION['user']['id'];
$log_id=$crud1->insert();

$cd= new crud('crm_lead_log');
 $_POST['lead_id']=$log_id;
 $cd->insert(); 	

// echo "<script>window.top.location='/crm_mod/pages/home/home.php'<script>";
}



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
		<div class="content d-flex justify-content-center align-items-center">
			<span class="font-32 mb-0 color-black">Clients</span>
			<div class="ms-auto">
			</div>
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
		
//		  $leadsQry = "SELECT a.*,o.name FROM $table1 a,crm_project_org o WHERE a.organization=o.id and a.assign_person=$PBI_ID ORDER BY a.id DESC";
		  $leadsQry = "SELECT * FROM  $tablecustomerlist1 WHERE1";
		  $rslt = db_query($leadsQry);

          while($row = mysqli_fetch_object($rslt)){

           

		
		?>	 
		
        <?php /*?><a href="../info_maker/lead_details_show.php?view=<?=encrypTS($row->id)?>&tp='<?=encrypTS('lead')?>'"><?php */?>

            <div class="card card-style  py-4" data-card-height="120">
                <div class="card-center px-4">
                    <div class="d-flex">
<!--                        <div class="align-self-center">
                            <i class="far fa-minus-square color-green-dark fa-2x mt-1 modal-icon"></i>
                        </div>-->
                        <div class="align-self-center ps-4">
                            <h1 class="font-23 mb-0 "><?=$row->name?></h1>
                            <p class="font-13 opacity-70 mt-2 mb-0 "><?=find_a_field('user_activity_management', 'fname', 'PBI_ID = "'.$row->entry_by.'"')?></p>
							<p class="font-11 opacity-50 mt-n2 mb-0 "><?=$row->entry_at?></p>
                        </div>

                        <div class="aling-self-center ms-auto">
							<button  class="btn btn-m float-end rounded-xl shadow-xl text-uppercase font-800 fa-2x mt-1 modal-icon bg-highlight" data-menu="convertToLead"
                     onclick="openModalConverttolead('<?=$row->id;?>','<?=$row->name;?>')"
                      >Convert to Deal</button>
                        </div>
                    </div>
                </div>
                
            </div>


    <?       }  ?>    

        


    </div>
  
  
  
  	<!-- Request convertToLead ---- -->
	<div id="convertToLead" class="menu menu-box-bottom menu-box-detached">
		<div class="menu-title"><h1>Convert To Lead</h1><p class="color-highlight"> Enter Convert To Lead Details</p>
		<a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
		<div class="divider divider-margins mt-3 mb-2"></div>
		<div class="content px-1">
		
		<form id="converttoleadform" method="post" action="">
		  <input type="hidden" name="organization" id="organization">
		
				
				<div class="input-style has-borders no-icon mb-4">
                   <input type="text" name="organizationnamelead" readonly id="organizationnamelead" placeholder="Organization Name">
                    <label for="form7" class="color-highlight">Organization Name</label>
                
                </div>
				<div class="input-style has-borders no-icon mb-4">
                    <input  type="text" name="lead_name" id="lead_name" placeholder="Enter Lead Name">
                    <label for="form7" class="color-highlight">Enter Lead Name</label>
                
                </div>
				<div class="input-style has-borders no-icon mb-4">
                    <input  type="text" name="lead_value" id="lead_value" placeholder="Enter Lead Value">
                    <label for="form7" class="color-highlight">Enter Lead Value</label>
                
                </div>
				
				
				
						<div class="col-12">
							<div class="input-style has-borders no-icon mb-4">
								<label for="form5" class="color-highlight">Assign Person</label>
								 <select name="assign_person" id="form5" required >
								 <option value=""></option>
			
									<? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$assign_person,'1'); ?>
			
								 </select>
								  <span class="disabled"><i class="fa fa-chevron-down"></i></span>
								<i class="fa fa-check valid color-green-dark"></i>
								<i class="fa fa-check disabled invalid color-red-dark"></i>
								<em></em>
							</div>
						  </div>
		
						
						
						
						<div class="col-12">
							<div class="input-style has-borders no-icon mb-4">
								<label for="form5" class="color-highlight">Campaign</label>
						   
								
								 <select  name="campaign" id="form5" required >
								 <option value=""></option>
			
									<? foreign_relation('crm_campaign_management','id','camp_platform',$campaign,'1'); ?>
			
								 </select>
								  <span class="disabled"><i class="fa fa-chevron-down"></i></span>
								<i class="fa fa-check valid color-green-dark"></i>
								<i class="fa fa-check disabled invalid color-red-dark"></i>
								<em></em>
							</div>
						  </div>
					
							<div class="input-style has-borders no-icon mb-4">
								<label for="form5" class="color-highlight">Lead Status</label>
						   
								
								 <select  name="status" id="form5">
								 <option value=""></option>
			
									<? foreign_relation('crm_lead_status','id','status',$lead_status,'1'); ?>
			
								 </select>
								  <span class="disabled"><i class="fa fa-chevron-down"></i></span>
								<i class="fa fa-check valid color-green-dark"></i>
								<i class="fa fa-check disabled invalid color-red-dark"></i>
								<em></em>
							</div>
						  </div>
				
	


				
	<button type="submit" name="insertconverttolead" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 w-100"> Confirm </button>
			
			</form>
		</div>
	</div>
  
  
    <!-- End of Page Content-->
<script>

    function openModalConverttolead(orgId,orgName) {
 
      document.getElementById('organization').value = orgId;
      document.getElementById('organizationnamelead').value = orgName;
    }


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






	
 <? require_once '../assets/template/inc.footer.php'; ?>