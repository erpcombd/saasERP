<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 



$title='Personal File Check Status';			// Page Name and Page Title



$page="pf_status.php";		// PHP File Name



$input_page="pf_status_input.php";



$root='hrm';







$table='pf_status';		// Database Table Name Mainly related to this page



$unique='PF_STATUS_ID';			// Primary Key of this Database table



$shown='PF_STATUS_CV';				// For a New or Edit Data a must have data field







// ::::: End Edit Section :::::







$crud      =new crud($table);











$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);















if($required_id>0)



$$unique = $_GET[$unique] = $required_id;



if(isset($_POST[$shown]))



{	if(isset($_POST['insert']))



		{		



$_POST['PBI_ID']=$_SESSION['employee_selected'];

$folder='hrm_emp_pic'; 

$field = 'PBI_PICTURE_ATT_PATH'; 

$file_name = $folder.'-'.$_SESSION['employee_selected'];



if($_FILES['PBI_PICTURE_ATT_PATH']['tmp_name']!=''){

$_POST['PBI_PICTURE_ATT_PATH']=upload_file($folder,$field,$file_name);

}







				$crud->insert();



				$type=1;



				$msg='New Entry Successfully Inserted.';



				unset($_POST);



				unset($$unique);



$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);



if($required_id>0)



$$unique = $_GET[$unique] = $required_id;



		}



	//for Modify..................................



	if(isset($_POST['update']))



	{

	

	








				$crud->update($unique);



				$type=1;



	}



}







if(isset($$unique))



{



$condition=$unique."=".$$unique;



$data=db_fetch_object($table,$condition);



foreach($data as $key => $value)



{ $$key=$value;}



}



?>





<script type="text/javascript"> function DoNav(lk){



	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)



	}</script>

<style>



.style1{



padding-left:20px;



}



</style>







<div class="oe_view_manager oe_view_manager_current">

<? include('../common/title_bar.php');?>

<div class="oe_view_manager_body">

<div  class="oe_view_manager_view_list"></div>

<div class="oe_view_manager_view_form">

<div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">

<div class="oe_form_buttons"></div>

<div class="oe_form_sidebar"></div>

<div class="oe_form_pager"></div>

<div class="oe_form_container">

<div class="oe_form">

<div class="">

<? include('../common/input_bar.php');?>

<div class="oe_form_sheetbg">

<div class="oe_form_sheet oe_form_sheet_width">









<div class="content-wrapper" >
    <!-- Content Header (Page header) -->
    

    <!-- Main content -->
  <section class="content">

      <!-- Default box -->
    <div class="card card-solid">
        <div class="card-body pb-0">
          <div class="row ">
			  
			  
            <div class="col-12 col-sm-4 col-md-4 ">
              <div class="card bg-light">
                <div class="card-header text-muted border-bottom-0">
                  Digital Strategist
                </div>
                <div class="card-body pt-0">
                  <div class="row">
					  <div class="col-sm-12">
						  <div class="row">
						  						 
							  <div class="col-sm-7"> 
						    <h2 class="lead"><b>Nicole Pearson</b></h2>
						  </div>
                    <div class="col-sm-5 text-center">
                      <img style="border-radius:60%;"src="../../pic/employee.png" alt="image" class="img-circle img-fluid">
                    </div>
						  </div>
						 
					  
					  </div>
                    <div class="col-sm-12">

                      
                      <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: Demo Street 123, Demo City 04312, NJ</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: + 800 - 12 12 23 52</li>
                      </ul>
                    </div>

                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                    <a href="#" class="btn btn-sm bg-teal">
                      <i class="fas fa-comments"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-primary">
                      <i class="fas fa-user"></i> View Profile
                    </a>
                  </div>
                </div>
              </div>
            </div>
          
		  </div>
            
		  
	  </div>
			  
			  
            
			  
        </div>
    <!-- /.card-body --><!-- /.card-footer --><!-- /.card -->

    </section>
    <!-- /.content -->
  </div>


<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>

