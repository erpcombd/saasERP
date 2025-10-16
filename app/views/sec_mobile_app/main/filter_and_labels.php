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
.width-100{

width:100%;
}
</style>



<div class="page-content header-clear-medium">

        <div class="card card-style">
            <div class="content">
                <h1>Filter & Label</h1>
        
             
            </div>
        </div>

<div class="card card-style">
            <div class="content mb-0">
                   
                <h4 class="bolder">Filter</h4>
            
                                
                
                <div class="list-group list-custom-small list-icon-0">
                    <a  href="#" >
                        <i class="fa font-14 fa-share-alt color-red-dark"></i>
                        <span class="font-14">Assign to me</span>
                        <!--<i class="fa fa-angle-down"></i>-->
                    </a>        
                </div>
                                          
                
                <div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect collapsed" href="#collapse-2" aria-expanded="false">
                        <i class="fa font-14 fa-envelope color-blue-dark"></i>
                        <span class="font-14">Assign Person</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
				
				
		
				
				<div class="collapse" id="collapse-2" style="">
    <form id="employeeForm" action="assign_person_wise_view.php" method="POST">
        <div class="row mb-0">
            <div class="col-6">
                <div class="input-style has-borders no-icon mb-4 input-style-active">
                    <label for="emp_id" class="color-highlight text-uppercase font-700 font-10 mt-1">Person Name</label>
                    <input type="text" list="eip_ids" name="emp_id" id="emp_id" class="form-control validate-text" value="<?=$_POST['emp_id']?>">
                    <datalist id="eip_ids">
                        <option></option>
                        <?
						foreign_relation('personnel_basic_info','PBI_ID','concat(PBI_ID," - ",PBI_NAME)',$emp_id,'1');
						?>
                    </datalist>
                 
                    
					
		
 


                </div>
            </div>
            <div class="col-6">
                <button type="submit" name="scCall" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100">View</button>
            </div>
        </div>
    </form>
</div>



				
                
                <div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect collapsed" href="#collapse-3" aria-expanded="false">
                        <i class="fa font-14 fa-phone color-green-dark"></i>
                        <span class="font-14">Company</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
                <div class="collapse" id="collapse-3" style="">
                    					<div class="row mb-0">
							  <div class="col-6">
								<div class="input-style has-borders no-icon mb-4 input-style-active">
								  <label for="form6" class="color-highlight text-uppercase font-700 font-10 mt-1">Company Name</label>
									<input type="text"  name="show" class="form-control validate-text" id="form6">
								</div>
							  </div>
							  <div class="col-6">
								<button type="submit" name="scCall" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100"> View </button>
							  </div>
							</div>

                </div>
		</div>
	</div>
	
	
	
	
	
	<div class="card card-style">
            <div class="content mb-0">
                   
                <h4 class="bolder">Label & Status</h4>
            
                                
                
                <div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect collapsed" href="#collapse-4" aria-expanded="true">
                        <i class="fa font-14 fa-share-alt color-red-dark"></i>
                        <span class="font-14">Priority</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
                <div class="collapse show" id="collapse-4" style="">
				
                    <div class="list-group list-custom-small ps-3">
                        <a href="#">
                            <i class="fa-solid font-13 fa-flag color-green-dark"></i>
                            <span>LOW</span>
                            <i class="fa fa-angle-right"></i>
                        </a>        
                        <a href="#">
                            <i class="fa-solid font-13 fa-flag color-blue-dark"></i>
                            <span>MEDIUM</span>
                            <i class="fa fa-angle-right"></i>
                        </a>        
                        <a href="#" class="border-0">
                            <i class="fa-solid font-13 fa-flag color-red-dark"></i>
                            <span>HIGH</span>
                            <i class="fa fa-angle-right"></i>
                        </a>        
                    </div>
                </div>                                
                
                <div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect collapsed" href="#collapse-5" aria-expanded="false">
                        <i class="fa font-14 fa-envelope color-blue-dark"></i>
                        <span class="font-14">Status</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
                <div class="collapse" id="collapse-5" style="">
                    <div class="list-group list-custom-small ps-3">
                        <a href="#">
                            <i class="fa-solid font-13 fa-circle color-green-dark"></i>
                            <span>COMPLETE</span>
                            <i class="fa fa-angle-right"></i>
                        </a>        
                        <a href="#">
                            <i class="fa-solid font-13 fa-circle color-blue-dark"></i>
                            <span>PENDING</span>
                            <i class="fa fa-angle-right"></i>
                        </a>        
                        <a href="#" class="border-0">
                            <i class="fa-solid font-13 fa-circle color-red-dark"></i>
                            <span>CANCELLED</span>
                            <i class="fa fa-angle-right"></i>
                        </a>        
                    </div>
                </div>
		</div>
	</div>
	
</div>


<script>
    document.getElementById('employeeForm').addEventListener('submit', function(event) {
        var empInfo = document.getElementById('emp_info').value;
        var parts = empInfo.split(' - ');
        if (parts.length === 2) {
            document.getElementById('emp_id').value = parts[0];
         
        }
    });
</script>

	
<?php include_once('../template/link_footer.php'); ?>