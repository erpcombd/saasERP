<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');

$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"');

$orgAll=find_all_field('crm_project_org','','id='.$_GET['id']);

 $table1 = 'crm_project_lead';
 $crud1 = new crud($table1);
 
 if(isset($_POST['insert'])){

$_POST['entry_by'] = $_SESSION['user']['id'];
$log_id=$crud1->insert();

$cd= new crud('crm_lead_log');
  $_POST['lead_id']=$log_id;
  $cd->insert(); 	

echo "<script>window.top.location='/crm_mod/pages/home/home.php'</script>";
 }
?>


<div class="modal-dialog modal-lg">

        <div class="modal-content">

        <div class="modal-header">

            <h3 class="modal-title" id="exampleModalLongTitle">Organization to Lead Convert</h3>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

            </button>

          </div>

          <form method="post" >

          <div class="modal-body">

          <h5 class=text-center>Lead Information</h5>

            <div class="row">
                <div class="col-6">
				 <table class="table">
                    <tbody>
					<tr>
						<td>Organization Name</td>
						<td><select  name="organization"  class=" input_general"  >
						<? foreign_relation('crm_project_org','id','name',$orgAll->id,'id='.$orgAll->id); ?>
						</select></td>
						</tr>
						<tr>
							<td>Enter Lead Name</td>
						 
								<td>
								<div >
								<input class="form-control" type="text" name="lead_name" id="lead_name">
								</div>
								
								</td>
						<!-- <td>Product</td>
						<td><select  name="product"  class=" input_general" required >
						<option></option>
						<? //foreign_relation('crm_lead_products','id','products',$product,'1'); ?>
						</select></td> -->
						</tr>
						 <tr>	
							<td>Enter Lead Value</td>
						 
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
						<td>Lead Status</td>
						<td><select  name="status"  class=" input_general" required >
						<option></option>
						<? foreign_relation('crm_lead_status','id','status',$lead_status,'1'); ?>
						</select></td>
						</tr>
						<tr>
						<td>Assign Person</td>
						<td><select  name="assign_person"  class=" input_general" required >
						<option></option>
						<? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$assign_person,'1'); ?>
				</select></td>
						</tr>
					</tbody>
					</table>
				
				</div>
				
				
            </div>
			<div class="modal-footer">

            <button type="submit" class="btn btn-primary" name="insert">Save</button>

          </div>
          </form>

          

        </div>

      </div>



<? require_once SERVER_CORE."routing/layout.bottom.php"; ?>






