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

//for submit..................................
if(isset($_POST['submit']))
{		
$_POST['entry_at']=time();
$_POST['entry_by']=$_SESSION['user']['id'];
		$crud->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';
}

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




<div class="container-fluid  ">

<section class="">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
          class="img-fluid" alt="Sample image">
      </div>
      <div class="col-md-2 col-lg-6 col-xl-4 offset-xl-1 position-relative ">
      <form action="" method="post" enctype="multipart/form-data">
      





          <div class="form-outline mb-4">
       
            <input name="task_name" id="task_name" value="" type="text" id="form3Example3" class="form-control form-control-lg"
              placeholder="Enter your task name" />
         
          </div>

         
          <div class="form-outline mb-3">
            <select class="form-control form-control-lg " name="lead_id" id="lead_id">
                            <? foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id');?>
                  </select>
          
          </div>

            <div class="form-outline mb-4">
              
                <textarea style=" font-size: 14px;"  class="form-control form-control-lg  mb-4"  type="text"  name="task_details" id="task_details" cols="30" rows="5" placeholder="Tasks Details"></textarea>
              
            </div>

         
        <div class="form-outline mt-4 mb-4">
        <label for="">Enter task date</label>
          <input type="date" class="form-control form-control-lg " style="margin-top:1em !important;" name="task_date" id="task_date"   placeholder="Subject">
         
          </div>
          <div class="form-outline mb-4">
          <label for="">Enter task Time</label>
          <input type="time" class="form-control form-control-lg " style="margin-top:1em !important;" name="task_time" id="task_time"   placeholder="Subject">
         
          </div>
          <div class="form-outline mb-4">
          <label for="">Enter Remainder Date</label>
          <input type="date" class="form-control form-control-lg " style="margin-top:1em !important;" name="reaminder_start_date" id="reaminder_start_date"   placeholder="Subject">
         
          </div>
          <div class="form-outline mb-4">

          <label for="">Enter Remainder Time</label>
          <input type="time" class="form-control form-control-lg " style="margin-top:1em !important;" name="reaminder_start_time" id="reaminder_start_time"   placeholder="Subject">
         
          </div>

  
  
    
    

          <div class="text-center text-lg-start mt-4 pt-2">

          
 
          <input type="submit" name="submit" id="submit" class="btn btn-primary btn-lg"/>
          <input name="reset" type="button" class="btn btn-danger  btn-lg" id="reset" value="RESET" onclick="parent.location='show_all_tasks.php'">
          

          </div>

        </form>
      </div>
    </div>
  </div>

</section>

<!-- <div class="d-flex justify-content-center"> -->
<!-- 
<div class="shadow rounded p-4 fahimbody position-relative ">
      <form action="<? //=$page?>?<? //=$unique?>=<? //=$$unique?>" method="post" enctype="multipart/form-data" class="cf">
      

            <div class="half left cf" style="z-index:200 !important;">
                <input type="text" class="greenhover" name="task_name" style="z-index:200 !important;" id="task_name" value="" placeholder="Name">
                <select class="form-control mt-3   border-0 greenhover rounded" name="organization_id" id="organization_id">
                            <? //foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.organization', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id'); ?>
                  </select>
                <input type="date" class="greenhover" style="margin-top:1em !important;" name="task_date" id="task_date"   placeholder="Subject">
                <input type="text" class="greenhover" style="margin-top:1em !important;" name="task_time" id="task_time" value=""   placeholder="Subject">
                <input type="date" class="greenhover" style="margin-top:1em !important;" name="reaminder_start_date" id="reaminder_start_date"   placeholder="Subject">
                <input type="text" class="greenhover" style="margin-top:1em !important;" name="reaminder_start_time" id="tasreaminder_start_timek_time" value=""   placeholder="Subject">

          </div>
          <div class="half right cf">
            <textarea name="message" class="greenhover" type="text" id="input-message" name="task_details" id="task_details" cols="30" rows="5" placeholder="Tasks Details"></textarea>
          </div>
          <input type="submit" name="submit" id="submit" class="btn1 btn1-bg-submit"/>
          <input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="RESET" onclick="parent.location='show_all_tasks.php'">
      </form> -->

<!-- </div> -->
 
<!-- </div> -->



</div>



<script type="text/javascript">
  
</script>


<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>