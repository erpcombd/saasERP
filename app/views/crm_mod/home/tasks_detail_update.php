<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
 


 
				
				
				
				
				



//echo $u_id= $_SESSION['user_id']; //$_SESSION['user']['id'];
$u_id  =  $_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);
$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);

$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');

$pbi_id  =  $_SESSION['employee_selected'];
$user_role  =  $_SESSION['user']['fname'];

$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"');

 $cur = '&#x9f3;';
 require "../include/custom.php";
 $title = "All ".$CRMleadName." List";
  echo $id = decrypTS($_GET['view']);
 $tablecustomerlist1 = 'crm_project_org';
 $table2 = 'crm_org_contacts';

 $crud1 = new crud( $tablecustomerlist1);
 $crud2 = new crud($table2);
 
 $tablelead = 'crm_lead_activity';
 

  


  
  
  
  $basic = find_all_field('crm_lead_activity','','activity_id="'.$id.'"');
  
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

if(isset($_POST['submitinfo']))
{

$_POST['entry_by']=$_SESSION['user']['id'];
		$crudcontact1->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';
		
		
		    // Display the message in a JavaScript alert
    echo "<script type='text/javascript'>alert('$msg');</script>";
	
		echo "<script>window.top.location='../home/leads.php'</script>";
}


if(isset($_POST['updateinfo']))
{
		$crudcontact1 = new crud($tablelead);
		
		$_POST['edit_at']=time();
		$_POST['edit_by']=$_SESSION['user']['id'];
		$crudcontact1->update('activity_id');
		$type=1;
		$msg='Successfully Updated.';

		echo "<script>window.top.location='../home/tasks.php'</script>";
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

        .card {
            border: none;
            border-radius: 10px;
            background-color: #edf2f7 !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }


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



 
 
 
 

<div class="page-content header-clear-medium">
    <div class="card card-style shadow-lg p-3 bg-white rounded">
        <div class="content">
            <form method="post" action="">
				<input type="hidden" class="form-control" name="activity_id" value="<?=$basic->activity_id?>" id="activity_id">
			
                <h1 class="text-center text-primary m-4">Task Information</h1>
                
                <div class="row">


                    <!-- Company Name -->
                    <div class="col-md-12">
          
                            <label for="companyName" >Task Name</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border"><i class="fa fa-building"></i></span>
                                <input type="text" class="form-control" name="subject" value="<?=$basic->subject?>" id="subject" placeholder="Task Name" required>
                            </div>
         
                    </div>






                    <!-- Date -->
                    <div class="col-md-6">
                        <div class=" mb-4">
                            <label for="employees" >Date</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border"><i class="fa fa-users"></i></span>
                                <input type="date" class="form-control" name="date" value="<?=$basic->date?>" id="date">
                            </div>
                        </div>
                    </div>
                    <!-- Date -->
                    <div class="col-md-6">
                        <div class=" mb-4">
                            <label for="employees" >Time</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border"><i class="fa fa-users"></i></span>
                                <input type="time" class="form-control" name="time" value="<?=$basic->time?>" id="time">
                            </div>
                        </div>
                    </div>
					
					
					<!-- Date -->
                    <div class="col-md-6">
                        <div class=" mb-4">
                            <label for="employees" >Deadline</label>
                            <div class="input-group-prepend">
                                
                                <input type="date" class="form-control" name="deadline" value="<?=$basic->deadline?>" id="deadline">
                            </div>
                        </div>
                    </div>
					
					
					
					                   <!-- Lead Source -->

                    <div class="col-md-6">

                    

                            <label for="leadSource" >status</label>

                            <select name="status" id="status" required>

                                <option value="<?=$basic->status?>">  <?= find_a_field('deal_status','status','id='.$basic->status);?></option>

                                <?=foreign_relation('deal_status','id','status','1');?>

                            </select>

                      

                    </div>
					
					


					
					<!-- Assign Person -->
                    <div class="col-md-6">
                        <div class=" mb-4">
                            <label for="employees" >Assign Person</label>
                            <div class="input-group-prepend">
                                
                                <input type="text" class="form-control" name="assign_person" value="<?=$basic->assign_person?>" id="assign_person">
                            </div>
                        </div>
                    </div>
					
					
					
                   

                    
					<div class="mb-4">
                    
                    <label for="form1" class="color-highlight">Description Information</label>
   					<textarea class="form-control " name="details" id="details"   placeholder="Description Information"><?=$basic->details?></textarea>
					
                </div>
					
					
					
                </div>
				


                <!-- Save and Cancel Buttons -->
                <div class="text-center">
                    <input type="submit" name="updateinfo" id="updateinfo" value="Update" class="btn btn-success"></input>
					<a class="btn btn-secondary px-5" 
					href="../home/tasks.php">Cancel</a>
                </div>
            </form>
        </div>
    </div>
	
	
	
	<style>
	
.message-blue {
    position: relative;
    margin-left: 20px;
    margin-bottom: 10px;
    padding: 10px;
    background-color: #A8DDFD;
    width: 200px;
    text-align: left;
    font: 400 .9em 'Open Sans', sans-serif;
    border: 1px solid #97C6E3;
    border-radius: 10px;
    height: auto; /* Auto height for dynamic content */
    word-wrap: break-word; /* Ensure long words break properly */
}

.message-orange {
    position: relative;
    margin-bottom: 10px;
    margin-left: calc(100% - 240px);
    padding: 10px;
    background-color: #f8e896;
    width: 200px;
    text-align: left;
    font: 400 .9em 'Open Sans', sans-serif;
    border: 1px solid #dfd087;
    border-radius: 10px;
    height: auto; /* Auto height for dynamic content */
    word-wrap: break-word; /* Ensure long words break properly */
}

.message-content {
    padding: 0;
    margin: 0;
}

.message-timestamp-right,
.message-timestamp-left {

    font-size: .85em;
    font-weight: 300;
    bottom: 5px;
	
}

.message-timestamp-right {
    right: 5px;
}

.message-timestamp-left {
    left: 5px;
}

.message-blue:after,
.message-blue:before,
.message-orange:after,
.message-orange:before {
    content: '';
    position: absolute;
    width: 0;
    height: 0;
}

.message-blue:after {
    border-top: 15px solid #A8DDFD;
    border-left: 15px solid transparent;
    border-right: 15px solid transparent;
    top: 0;
    left: -15px;
}

.message-blue:before {
    border-top: 17px solid #97C6E3;
    border-left: 16px solid transparent;
    border-right: 16px solid transparent;
    top: -1px;
    left: -17px;
}

.message-orange:after {
    border-bottom: 15px solid #f8e896;
    border-left: 15px solid transparent;
    border-right: 15px solid transparent;
    bottom: 0;
    right: -15px;
}

.message-orange:before {
    border-bottom: 17px solid #dfd087;
    border-left: 16px solid transparent;
    border-right: 16px solid transparent;
    bottom: -1px;
    right: -17px;
}








	
	
	</style>
	<div class="card card-style shadow-lg p-3 bg-white rounded">
	
	<div class="content">
	
	            <?php 
						
						  // Fetch feedback for the current activity
							$activity_id = $basic->activity_id;
							
							$sqlFeedback = "SELECT * FROM crm_lead_activity_feedback WHERE activity_id = $activity_id ORDER BY id DESC";
							$resultFeedback = db_query($sqlFeedback);
							
							while ($feedbackRow = mysqli_fetch_object($resultFeedback)) { 
							
							$entry_person =$feedbackRow->entry_by;
							
				    // Determine the class based on who entered the feedback
						if ($entry_person == $u_id) {
							$tasksperson = "message-orange"; // Current user
							$timestamp_position = "message-timestamp-right";
						} else {
							$tasksperson = "message-blue"; // Other users
							$timestamp_position = "message-timestamp-left";
						}
							
							?>

    <div class="<?= $tasksperson ?>">
        <p class="message-content"><?=$feedbackRow->feedback;?></p>
        <div class="<?= $timestamp_position ?>">
            <?= find_a_field('user_activity_management', 'fname', 'user_id="'.$feedbackRow->entry_by.'"'); ?> 
            <?= date('g:i a', strtotime($feedbackRow->entry_at)); ?>
        </div>
    </div>
	  <?php } ?>
</div>
	</div>
	
	
	
	
</div>






















<!-- Modal Start Here -->

<?php if(isset($_GET['update'])){ 

$datas = find_all_field( $tablecustomerlist1, '', 'id="'.decrypTS($_GET['update']).' AND '.$con.'"'); 

if(isset($datas)){$assigned_id = $datas->assigned_person_id;}else{$assigned_id = $_SESSION['employee_selected'];} 

} ?>



<div id="leadentrymodal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

<div class="modal-dialog modal-lg">

<div class="modal-content">

<div class="modal-header">

    <h5 class="modal-title" id="leadentrymodalLongTitle"><?php if(isset($datas)){echo 'Update';}else{echo 'Create';}?> <?=$CRMleadName?></h5>

    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

      <span aria-hidden="true">&times;</span>

    </button>

  </div>

  <form id="organizationentrytable" method="post" enctype="multipart/form-data">

  

  <div class="modal-body">

  <h5 class=text-center><?php if(isset($datas)){echo 'Update';}else{echo 'New';}?> <?=$CRMleadName?> Information</h5>

    <div class="row">

        

        <div class="col-sm-12">

            <table class="table">

              <tr>

                <td width="120">Organization Name </td>

                <td><input type="text" name="name" id="orgname" value="" class="form-control" style="border-left:3.5px solid #df5b5b!important;" required></td>

              </tr>

          </table>

        </div>

     

        <div class="col-md-6 mt-2">

          <table class="table">

            <tbody>

                

              <?php /*?><tr>

                <td>Assigned to</td>

                <td>

                  <select name="assigned_person_id" id="assigned_person_id" class="selectpicker input_required"  data-live-search="true" required>

                    <?php 

                        

                        if(in_array($_SESSION['employee_selected'], $superID)){ 

                            foreign_relation('user_activity_management', 'distinct(PBI_ID)', 'fname', $datas->assigned_person_id, '1'); 

                        }else{ 

                            foreign_relation('user_activity_management', 'distinct(PBI_ID)', 'fname', $assigned_person_id, 'PBI_ID="'.$assigned_id.'"'); 

                        }

                        

                    ?>

                  </select>

                </td>

              </tr><?php */?>

              

              <tr>

                <td >Source </td>

                <td>
                <!-- <select name="lead_source" id="lead_source"  class="selectpicker input_general"  data-live-search="true"> -->
                  <select name="lead_source" id="lead_source"  class=" input_general"  data-live-search="true">

                    <option id="leadidmodal" value=""></option>

                        <?php foreign_relation('crm_lead_source', 'id', 'source', $datas->lead_source, '1'); ?>

                  </select>

                </td>

              </tr>

              

              <tr>

                <td>Employees</td>

                <td><input type="text" value="<?=$datas->total_employees?>" name="total_employees" id="total_employees" 
				class="form-control" style="border-left: 3.5px solid #aeddf7 !important;"></td>

              </tr>

              

              <tr>

                <td>Yearly Turnover </td>

                <td><input type="text" name="annual_revenue" id="annual_revenue" value="<?=$datas->annual_revenue?>" style="border-left: 3.5px solid #aeddf7 !important;" class="form-control"></td>

              </tr>


              <?php /*?><tr>

                <td><label>Product</label></td>

                <td>

                    <select type="text" name="product" value="<?=$datas->product?>" style="border-left: 3.5px solid #aeddf7 !important;" class="form-control">

                        

                        <?php foreign_relation('crm_lead_products', 'id', 'products', $datas->product, '1'); ?>

                    

                    </select>

                </td>

              </tr><?php */?>

              

            </tbody>

          </table>

        </div>

        <div class="col-md-6  mt-2">

          <table class="table">

            <tbody>

                

              <?php /*?><tr>

                <td>Company </td>

                <td><input type="text" name="company_name" value="<?=$datas->company_name?>" class="form-control" style="border-left:3.5px solid #df5b5b!important;" required></td>

              </tr><?php */?>



              <tr >

                <td>Website</td>

                <td><input type="text" name="website" id="website" value="<?=$datas->website?>" class="form-control" style="border-left: 3.5px solid #aeddf7 !important;"></td>

              </tr>

              

              <tr>

                <td>Type </td>

                <td>

                  <select name="lead_type" id="lead_type" class="input_general" data-live-search="true">

                    <option value="">--None--</option>

                        <?php foreign_relation('crm_lead_type', 'id', 'type', $datas->lead_type, '1'); ?>

                  </select>

                </td>

              </tr>

          
			  
			  
              <tr>

                <td>Organization Logo </td>

                <td><input type="file" name="logo" id="logo" value="<?=$datas->logo?>" style="border-left: 3.5px solid #aeddf7 !important;" class="form-control">
					<?php if ($logo!=''){?>
						<a href="../../../assets/support/upload_view.php?name=<?=$datas->logo?>&folder=Organization_logo&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" target="_blank">View Attachment</a>
					<?php } ?>
				</td>

              </tr>
         <?php /*?>     <tr>

                <td>Status</td>

                <td>

                  <select name="status" class="selectpicker input_required" data-live-search="true" required>

                    <?php foreign_relation('crm_lead_status', 'id', 'status', $datas->status, '1'); ?>

                  </select>

                </td>

              </tr><?php */?>

              

              <?php /*?><tr>

                  <td><label>Logo</label></td>

                  <td>

                    <input type="file" name="logo" id="image" style="display:none;" accept=".png,.jpg,.jpeg">

                    <label for="image">

                        

                        <?php if($datas->logo!=NULL){echo '<span class="text-primary" style="cursor:pointer;font-size:11px;">'.$datas->logo.'</span>';}else{echo '<span class="text-info" style="cursor:pointer;font-size:11px;"><i class="fa fa-paperclip"></i> Attach</span>';} ?>

                        

                    </label>

                  </td>

              </tr><?php */?>

    

            </tbody>

          </table>

        </div>

     

    </div>

    

    <!-- <h5 class="text-center">Contact Information</h5>

     <span  id="addr0">

    <div class="row">

          <div class="col-md-6">

            <table class="table">

              <tbody>

                <tr>

                    <td>Contact Person </td>

                    <td><input type="text" name="contact_name1[]" value="<?=$datas->contact_name?>" style="border-left:3.5px solid #df5b5b!important;" class="form-control" required></td>

                </tr>

                  

                <tr>

                    <td>Phone </td>

                    <td><input type="text" name="contact_phone1[]" class="form-control " style="border-left:3.5px solid #df5b5b!important;" value="+880<?=$datas->contact_phone?>" ></td>

                </tr>

                

              </tbody>

            </table>

          </div>

          

          <div class="col-md-6">

            <table class="table">

              <tbody>

                  

                <tr>

                    <td>Email </td>

                    <td><input type="text" name="contact_email1[]" class="form-control" value="<?=$datas->contact_email?>" style="border-left:3.5px solid #df5b5b!important;"></td>

                </tr>

                

                <tr>

                  <td>Designation</td>

                  <td>

                    <input type="text" name="contact_designation1[]" id="designation" class="form-control" value="<?=$datas->contact_designation?>" style="border-left: 3.5px solid #aeddf7 !important;">

                  </td>

                </tr>

              </tbody>

            </table>

          </div>
          <div class="col-md-6"> <table class="table"> <tbody><tr><td>Department </td><td><input type="text" name="dept[]" style="border-left:3.5px solid #df5b5b!important;" class="form-control"></td></tbody></table></div>

       </div>

          </span>

      <span id="add_row" class="mx-auto text-light mt-3 mb-4 btn btn-primary btn-sm">+ Add Contact</span> -->

    <h5 class="text-center">Address Information</h5>

    <div class="row" id="cv">

      <div class="col-md-6">

        <table class="table">

          <tbody>

            <tr>

              <td>Address</td>

              <td><input type="text" value="<?=$datas->address?>" name="address" id="orgaddress" class="form-control" style="border-left: 3.5px solid #aeddf7 !important;"></td>

            </tr>

            <tr>
              <td>Division</td>
              <td>
                  <select name="division" id="division" class=" input_general" data-live-search="true">
                    <option value="">--Select One--</option>
                    <?php foreign_relation('division','division_CODE','division_name',$datas->division,'1'); ?>
                  </select>
              </td>

            </tr>
               <tr>
              <td>Zip Code</td>
              <td>
                  <select name="zip" id="zip" class=" input_general" data-live-search="true">
                    <option value="">--Select One--</option>
                    <?php foreign_relation('crm_postalcode_list','po_code','concat(po_name,"-",po_code)',$datas->zip,'is_active=1 ORDER BY po_name'); ?>
                  </select>
              </td>

            </tr>

          </tbody>

        </table>

      </div>

      <div class="col-md-6">

        <table class="table">

          <tbody>

                          <tr>

                <td>Visiting Card </td>

                <td><input type="file" name="visiting_card_img" id="visiting_card_img" value="<?=$datas->visiting_card_img?>" style="border-left: 3.5px solid #aeddf7 !important;" class="form-control">
					<?php if ($visiting_card_img!=''){?>
						<a href="../../../assets/support/upload_view.php?name=<?=$datas->visiting_card_img?>&folder=Organization_logo&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" target="_blank">View Attachment</a>
					<?php } ?>
				</td>

              </tr>

            <tr>

              <td>Country</td>

              <td>  

                <select name="country" id="country" class=" input_required" onChange="ccl()"  >

                  <option value="">--Select One--</option>

                  <?php foreign_relation('crm_country_management','id','country_name',$datas->country,'is_active=1 ORDER BY country_name'); ?>

                </select>

                

              </td>

            </tr>
            <tr>
              <td>District</td>
              <td>
                  <select name="district" id="district" class=" input_general" data-live-search="true">
                    <option value="">--Select One--</option>
                    <?php foreign_relation('district_list','id','district_name',$datas->district,'1'); ?>
                  </select>
              </td>

            </tr>

          </tbody>

        </table>

      </div>
	      <h5 class="text-center">Contact Information</h5>

    <div class="row" id="cv">

      <div class="col-md-6">

        <table class="table">

          <tbody>

            <tr>

              <td>Person</td>

              <td>
		
		
<input type="text" value="<?=$datas->contact_person?>" name="contact_person" id="contact_person" 
class="form-control" style="border-left: 3.5px solid #aeddf7 !important;">



			
			
			
			</td>

            </tr>

            
              

          </tbody>

        </table>

      </div>

      <div class="col-md-6">

        <table class="table">

          <tbody>

                          <tr>

              <td>Number</td>

              <td><input type="text" value="<?=$datas->contact_number?>" name="contact_number" id="contact_number" class="form-control" style="border-left: 3.5px solid #aeddf7 !important;"></td>

            </tr>

           
           
          </tbody>

        </table>

      </div>
	  
	  <div class="col-md-12">

        <table class="table">

          <tbody>

            <tr>

              <td>Email</td>

      <td><input type="email" value="<?=$datas->contact_email?>" name="contact_email" id="contact_email" 
	  class="form-control" style="border-left: 3.5px solid #aeddf7 !important;"></td>

            </tr>

            
              

          </tbody>

        </table>

      </div>
	  
	  

        <div class="form-group pt-3 m-0 m-auto">

            <label for="message text-center">Description Information</label>

            <textarea name="description" id="description" class="form-control" style="border-left: 3.5px solid #aeddf7 !important;" cols="40" rows="4"></textarea>

        </div>

        

    </div>

    

    <?php if(!isset($datas)){ ?>

    <div class="form-group pt-3 text-center">

        <input type="checkbox" name="send_a_mail">

        <label> Send a confirmation mail to contact</label>

    </div>

    <?php } ?>

    

  </div>

  

  <?//php if(!isset($datas)){ ?>

  <div class="modal-footer">

    <a type="button" class="btn btn-secondary text-light" data-dismiss="modal">Close</a>

    <button type="submit" class="btn btn-primary" id="orgsavebtn" name="insert">Save</button>

    <input  name="updateentrylead" type="submit" id="orgentryeditbtn" value="Update" class="btn1 btn1-bg-update d-none">

  </div>

  <?/*php }else{ ?>

    <div class="modal-footer">

        <input type="hidden" name="id" value="<?=$datas->id?>">

        <a type="button" class="btn btn-secondary text-light" data-dismiss="modal">Close</a>

        <button type="submit" class="btn btn-warning" name="update">Update</button>

    </div>

  <?php } */?>

  

  </form>

  

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
<div class="modal fade" id="convertToLead" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">

        <div class="modal-content">

        <div class="modal-header">

            <h3 class="modal-title" id="exampleModalLongTitle">Organization to Lead Convert</h3>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

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
            <td ><input type="text" name="organizationnamelead" readonly id="organizationnamelead"></td>
						<!-- <td><select  name="organization"  class=" input_general"  >
              <option id="converttoleadidioption" value=""></option>
						<? //foreign_relation('crm_project_org','id','name',$orgAll->id,'id='.$orgAll->id); ?>
						</select></td> -->
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
						
						<tr>
						<td>Campaign</td>
						<td><select  name="campaign"  class=" input_general" required >
						<option></option>
						<? foreign_relation('crm_campaign_management','id','camp_platform',$campaign,'1'); ?>
				</select></td>
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










