<?php
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE . "routing/layout.top.php";
//require_once '../../../controllers/core/init.php';

$cid = $_SESSION['proj_id'];
$page = "home";

include_once('../template/header.php'); 
require "../include/custom.php";

$u_id  =  $_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management', 'PBI_ID', 'user_id=' . $u_id);
$basic = find_all_field('personnel_basic_info', '', 'PBI_ID="' . $PBI_ID . '"');

$cur = '&#x9f3;';
$table1 = 'crm_project_lead';
?>

<style>
    .width-100 {
        width: 100%;
    }
</style>

<div class="page-content header-clear-medium"><!-- Opening div.page-content -->
    <div class="card card-style"><!-- Opening div.card -->
        <div class="content"><!-- Opening div.content -->
            <h1>Filter & Label</h1>
        </div><!-- Closing div.content -->
    </div><!-- Closing div.card -->
    
    <div class="card card-style"><!-- Opening div.card -->
        <div class="content mb-0"><!-- Opening div.content -->
            <h4 class="bolder">Filter</h4>
            <div class="list-group list-custom-small list-icon-0"><!-- Opening div.list-group -->
                <a href="#">
                    <i class="fa font-14 fa-share-alt color-red-dark"></i>
                    <span class="font-14">Assign to me</span>
                </a>
            </div><!-- Closing div.list-group -->
            
            <div class="list-group list-custom-small list-icon-0"><!-- Opening div.list-group -->
                <a data-bs-toggle="collapse" class="no-effect collapsed" href="#collapse-2" aria-expanded="false">
                    <i class="fa font-14 fa-envelope color-blue-dark"></i>
                    <span class="font-14">Assign Person</span>
                    <i class="fa fa-angle-down"></i>
                </a>
            </div><!-- Closing div.list-group -->
            
            <div class="collapse" id="collapse-2" style=""><!-- Opening div.collapse -->
                <form action="assign_person_wise_view.php" method="POST">
                    <div class="row mb-0"><!-- Opening div.row -->
                        <div class="col-12"><!-- Opening div.col-6 -->
                            <div class=""><!-- Opening div.input-style -->
                                <label for="emp_id" class="color-highlight text-uppercase font-700 font-10 mt-1">Person Name</label>
                                <select class="form-control req" name="assign_person[]" id="emp_id" multiple > 
                                    <option value=""></option>
                                    <?php foreign_relation('personnel_basic_info', 'PBI_ID', 'concat(PBI_ID," - ",PBI_NAME)', $assign_person, '1'); ?>
                                </select>
                            </div><!-- Closing div.input-style -->
                        </div><!-- Closing div.col-6 -->
						<style type="text/css">
							.select2{
							    width: 100% !important;
							}
						</style>
                        <div class="col-12 pt-1" align="center"><!-- Opening div.col-6 -->
                            <button type="submit" name="scCall" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100">View</button>
                        </div><!-- Closing div.col-6 -->
                    </div><!-- Closing div.row -->
                </form>
            </div><!-- Closing div.collapse -->
            
            <form action="status_page.php" method="POST">
                <div class="list-group list-custom-small list-icon-0"><!-- Opening div.list-group -->
                    <a data-bs-toggle="collapse" class="no-effect collapsed" href="#collapse-3" aria-expanded="false">
                        <i class="fa font-14 fa-phone color-green-dark"></i>
                        <span class="font-14">Company</span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                </div><!-- Closing div.list-group -->
                
                <div class="collapse" id="collapse-3" style=""><!-- Opening div.collapse -->
                    <div class="row mb-0"><!-- Opening div.row -->
                        <div class="col-6"><!-- Opening div.col-6 -->
                            <div class="input-style has-borders no-icon mb-4 input-style-active"><!-- Opening div.input-style -->
                                <label for="lead_id" class="color-highlight text-uppercase font-700 font-10 mt-1">Company Name</label>
                                <select class="form-control req" name="lead_id" id="form5">
                                    <option value=""></option>
                                    <?php foreign_relation('crm_project_org', 'id', 'name', $lead_id, '1'); ?>
                                </select>
                            </div><!-- Closing div.input-style -->
                        </div><!-- Closing div.col-6 -->
                        <div class="col-6"><!-- Opening div.col-6 -->
                            <button type="submit" name="scCall" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100">View</button>
                        </div><!-- Closing div.col-6 -->
                    </div><!-- Closing div.row -->
                </div><!-- Closing div.collapse -->
            </form>
        </div><!-- Closing div.content -->
    </div><!-- Closing div.card -->
    
    <div class="card card-style"><!-- Opening div.card -->
        <div class="content mb-0"><!-- Opening div.content -->
            <h4 class="bolder">Label & Status</h4>
            <div class="list-group list-custom-small list-icon-0"><!-- Opening div.list-group -->
                <a data-bs-toggle="collapse" class="no-effect collapsed" href="#collapse-4" aria-expanded="true">
                    <i class="fa font-14 fa-share-alt color-red-dark"></i>
                    <span class="font-14">Priority</span>
                    <i class="fa fa-angle-down"></i>
                </a>
            </div><!-- Closing div.list-group -->
            
            <div class="collapse show" id="collapse-4" style=""><!-- Opening div.collapse -->
                <div class="list-group list-custom-small ps-3"><!-- Opening div.list-group -->
                    <a href="status_page.php?priority_status=LOW">
                        <i class="fa-solid font-13 fa-flag color-green-dark"></i>
                        <span>LOW</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <a href="status_page.php?priority_status=MEDIUM">
                        <i class="fa-solid font-13 fa-flag color-blue-dark"></i>
                        <span>MEDIUM</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <a href="status_page.php?priority_status=high" class="border-0">
                        <i class="fa-solid font-13 fa-flag color-red-dark"></i>
                        <span>HIGH</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div><!-- Closing div.list-group -->
            </div><!-- Closing div.collapse -->
            
            <div class="list-group list-custom-small list-icon-0"><!-- Opening div.list-group -->
                <a data-bs-toggle="collapse" class="no-effect collapsed" href="#collapse-5" aria-expanded="false">
                    <i class="fa font-14 fa-envelope color-blue-dark"></i>
                    <span class="font-14">Status</span>
                    <i class="fa fa-angle-down"></i>
                </a>
            </div><!-- Closing div.list-group -->
            
            <div class="collapse" id="collapse-5" style=""><!-- Opening div.collapse -->
                <div class="list-group list-custom-small ps-3"><!-- Opening div.list-group -->
                    <a href="status_page.php?status=2">
                        <i class="fa-solid font-13 fa-circle color-green-dark"></i>
                        <span>COMPLETE</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <a href="status_page.php?status=1">
                        <i class="fa-solid font-13 fa-circle color-blue-dark"></i>
                        <span>PENDING</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <a href="status_page.php?status=3" class="border-0">
                        <i class="fa-solid font-13 fa-circle color-red-dark"></i>
                        <span>CANCELLED</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div><!-- Closing div.list-group -->
            </div><!-- Closing div.collapse -->
        </div><!-- Closing div.content -->
    </div><!-- Closing div.card -->
</div><!-- Closing div.page-content -->

<?php 
include_once('../template/link_footer.php');
selected_erp("#emp_id");
?>
