<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Posting Entey Management';			// Page Name and Page Title
$page="posting _entey.php";		// PHP File Name
$input_page="posting_entey_input.php";
$root='hrm';
$link="posting_entey_input.php";

$table='posting';		// Database Table Name Mainly related to this page
$unique='POSTING_CODE';			// Primary Key of this Database table
$shown='POSTING_NAME';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud      =new crud($table);

echo $required_id=find_a_field($table,$unique,"PBI_ID='".$_SESSION['employee_selected']."'");
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;
if(isset($_POST[$shown]))
{	if(isset($_POST['insert']))
		{		
				$_POST['PBI_ID']=$_SESSION['employee_selected'];
				unset($_POST[$unique]);
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
foreach ($data as $key =>$value)
{ $$key=$value;}
}
?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show('ggg', '<?=SERVER_ROOT?>app/views/hrm_mod/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}</script>







    <form  action="" method="post" enctype="multipart/form-data">
        <? include('../common/title_bar.php');?>
        <? include('../common/report_bar.php');?>
        

<!--        top form start hear-->
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <!--left form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Posting Name</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                            <input name="POSTING_NAME" type="text" id="POSTING_NAME" value="<?=$POSTING_NAME?>" />
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Designation</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select name="POSTING_DESIGNATION" id="POSTING_DESIGNATION">
                           			 <? foreign_relation('designation','DESG_SHORT_NAME','DESG_DESC',$POSTING_DESIGNATION);?>
                          		</select>
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Comany Name</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select name="POSTING_DOMAIN" id="POSTING_DOMAIN">
                            		<? foreign_relation('user_group','id','group_name',$POSTING_DOMAIN);?>
                         		 </select>

                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Project</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select name="POSTING_PROJECT">
                             		 <? foreign_relation('project','PROJECT_ID','PROJECT_NAME',$POSTING_PROJECT);?>
                         		 </select>

                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Department</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select name="POSTING_DEPARTMENT">
                             		 <? foreign_relation('department','DEPT_SHORT_NAME','DEPT_DESC',$POSTING_DEPARTMENT);?>
                          		</select>

                            </div>
                        </div>

                    </div>



                </div>

                <!--Right form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Zone</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                               <select name="POSTING_ZONE">
                              		<? foreign_relation('zon','ZONE_NAME','ZONE_NAME',$POSTING_ZONE);?>
                         	   </select>
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Area</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select name="POSTING_AREA">
                              		 <? foreign_relation('area','AREA_NAME','AREA_NAME',$POSTING_AREA );?>
                          		</select>
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Branch</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select name="POSTING_BRANCH">
                              		<? foreign_relation('branch','BRANCH_NAME','BRANCH_NAME',$POSTING_BRANCH);?>
                         	    </select>

                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Posting By</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input value="" id="dp" class="oe_datepicker_container hasDatepicker" disabled="disabled" style="display: none;" type="text" />
                            <input name="POSTING_BY" type="text" id="POSTING_BY" value="<?=$POSTING_BY?>" />

                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Memo No</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input name="POSTING_MEMO" type="text" id="POSTING_MEMO" value="<?=$POSTING_MEMO?>" />

                            </div>
                        </div>

                    </div>



                </div>


            </div>

            
        </div>

        <!--return Table design start-->
        
    </form>


<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>