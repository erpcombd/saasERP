<?php




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


 $unique='task_id'; 
$title = "Customer Relationship Management Dashboard";



$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');


$table='crm_task_add_information';	


// $title = "All Lead List";

 

$tableprojectlead = 'crm_project_lead';

$tableleadcontacts = 'crm_lead_contacts';

$pbi_id  =  $_SESSION['employee_selected'];
$user_role  =  $_SESSION['user']['fname'];



$crud1 = new crud($table1);

$crud2 = new crud($table2);









// Database Table Name Mainly related to this page

$crud    =new crud($table);
//for update..................................
if(isset($_POST['update']))
{
$_POST['edit_at']=time();
$_POST['edit_by']=$_SESSION['user']['id'];
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
}

$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"');



/*if($_SESSION['employee_selected']==0 || $_SESSION['employee_selected']==''){



header('location:../../../crm_mod/pages/home/index.php');



}*/



 

 $cur = '&#x9f3;';

 

 

 $table1 = 'crm_project_lead';

 $table2 = 'crm_task_lists';

 $table3 = 'crm_call_schedule';
 
 $table4 = 'crm_campaign_management';

 

//  $crud1 = new crud($table1);

//  $crud2 = new crud($table2);

//  $crud3 = new crud($table3);
 
//  $crud4 = new crud($table4);

 


require "../include/custom.php";

echo '<link rel="stylesheet" href="../include/Style/calendarStyle.css">';



?>



        <?php



            if(in_array($_SESSION['employee_selected'], $superID)){

                $con = "";

            }else{

                $con = " AND assigned_person_id = '".$_SESSION['employee_selected']."' ";

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

        

<link rel="stylesheet" href="style.css">

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


</style>

<style>
  .floatingshadowfahim{
    /* box-shadow: 0px 3px 9px 1px rgba(0, 10, 20, 0.2); */
    box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.05) 0px 4px 6px -2px;
    background-color: white;
  }
  .unplashscreen{
    /* background-color: whitesmoke; */
    /* background-image: url("bgunsplash3.jpg");
    background-size: cover; */
  }
</style>

<div class="unplashscreen" id="topcard">
<div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
    <!-- Vertical Navbar -->
 
    <!-- Main content -->
    <div class="h-screen flex-grow-1 overflow-y-lg-auto">
        <!-- Header -->
        <header class="bg-surface-primary border-bottom pt-6">
            <div class="container-fluid">
                <div class="mb-npx">
                    <div class="row align-items-center">
                        <div class="col-sm-6 col-12 mb-4 mb-sm-0">
                            <!-- Title -->
                            <h1 class="h2 mb-0 ls-tight">Application</h1>
                        </div>
                        <!-- Actions -->
                        <div class="col-sm-6 col-12 text-sm-end">
                            <div class="mx-n1">
                                <a href="#" class="btn d-inline-flex btn-sm btn-neutral border-base mx-1">
                                    <span class=" pe-2">
                                        <i class="bi bi-pencil"></i>
                                    </span>
                                    <span>Edit</span>
                                </a>
                                <a href="#" class="btn d-inline-flex btn-sm btn-primary mx-1">
                                    <span class=" pe-2">
                                        <i class="bi bi-plus"></i>
                                    </span>
                                    <span>Create</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Nav -->
                    <ul class="nav nav-tabs mt-4 overflow-x border-0">
                        <li class="nav-item ">
                            <a href="#" class="nav-link active">All files</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link font-regular">Shared</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link font-regular">File requests</a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <!-- Main -->
        <main class="py-6 bg-surface-secondary">
            <div class="container-fluid">
                <!-- Card stats -->
                <div class="row g-6 mb-6">
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card shadow border-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <span class="h6 font-semibold text-muted text-sm d-block mb-2">Budget</span>
                                        <span class="h3 font-bold mb-0">$750.90</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-tertiary text-white text-lg rounded-circle">
                                            <i class="bi bi-credit-card"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 mb-0 text-sm">
                                    <span class="badge badge-pill bg-soft-success text-success me-2">
                                        <i class="bi bi-arrow-up me-1"></i>13%
                                    </span>
                                    <span class="text-nowrap text-xs text-muted">Since last month</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card shadow border-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <span class="h6 font-semibold text-muted text-sm d-block mb-2">New projects</span>
                                        <span class="h3 font-bold mb-0">215</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-primary text-white text-lg rounded-circle">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 mb-0 text-sm">
                                    <span class="badge badge-pill bg-soft-success text-success me-2">
                                        <i class="bi bi-arrow-up me-1"></i>30%
                                    </span>
                                    <span class="text-nowrap text-xs text-muted">Since last month</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card shadow border-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <span class="h6 font-semibold text-muted text-sm d-block mb-2">Total hours</span>
                                        <span class="h3 font-bold mb-0">1.400</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-info text-white text-lg rounded-circle">
                                            <i class="bi bi-clock-history"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 mb-0 text-sm">
                                    <span class="badge badge-pill bg-soft-danger text-danger me-2">
                                        <i class="bi bi-arrow-down me-1"></i>-5%
                                    </span>
                                    <span class="text-nowrap text-xs text-muted">Since last month</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card shadow border-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <span class="h6 font-semibold text-muted text-sm d-block mb-2">Work load</span>
                                        <span class="h3 font-bold mb-0">95%</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-warning text-white text-lg rounded-circle">
                                            <i class="bi bi-minecart-loaded"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 mb-0 text-sm">
                                    <span class="badge badge-pill bg-soft-success text-success me-2">
                                        <i class="bi bi-arrow-up me-1"></i>10%
                                    </span>
                                    <span class="text-nowrap text-xs text-muted">Since last month</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow border-0 mb-7">
                    <div class="card-header">
                        <h5 class="mb-0">Applications</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Company</th>
                                    <th scope="col">Offer</th>
                                    <th scope="col">Meeting</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <img alt="..." src="https://images.unsplash.com/photo-1502823403499-6ccfcf4fb453?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80" class="avatar avatar-sm rounded-circle me-2">
                                        <a class="text-heading font-semibold" href="#">
                                            Robert Fox
                                        </a>
                                    </td>
                                    <td>
                                        Feb 15, 2021
                                    </td>
                                    <td>
                                        <img alt="..." src="https://preview.webpixels.io/web/img/other/logos/logo-1.png" class="avatar avatar-xs rounded-circle me-2">
                                        <a class="text-heading font-semibold" href="#">
                                            Dribbble
                                        </a>
                                    </td>
                                    <td>
                                        $3.500
                                    </td>
                                    <td>
                                        <span class="badge badge-lg badge-dot">
                                            <i class="bg-success"></i>Scheduled
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-neutral">View</a>
                                        <button type="button" class="btn btn-sm btn-square btn-neutral text-danger-hover">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img alt="..." src="https://images.unsplash.com/photo-1610271340738-726e199f0258?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80" class="avatar avatar-sm rounded-circle me-2">
                                        <a class="text-heading font-semibold" href="#">
                                            Darlene Robertson
                                        </a>
                                    </td>
                                    <td>
                                        Apr 15, 2021
                                    </td>
                                    <td>
                                        <img alt="..." src="https://preview.webpixels.io/web/img/other/logos/logo-2.png" class="avatar avatar-xs rounded-circle me-2">
                                        <a class="text-heading font-semibold" href="#">
                                            Netguru
                                        </a>
                                    </td>
                                    <td>
                                        $2.750
                                    </td>
                                    <td>
                                        <span class="badge badge-lg badge-dot">
                                            <i class="bg-warning"></i>Postponed
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-neutral">View</a>
                                        <button type="button" class="btn btn-sm btn-square btn-neutral text-danger-hover">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img alt="..." src="https://images.unsplash.com/photo-1610878722345-79c5eaf6a48c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80" class="avatar avatar-sm rounded-circle me-2">
                                        <a class="text-heading font-semibold" href="#">
                                            Theresa Webb
                                        </a>
                                    </td>
                                    <td>
                                        Mar 20, 2021
                                    </td>
                                    <td>
                                        <img alt="..." src="https://preview.webpixels.io/web/img/other/logos/logo-3.png" class="avatar avatar-xs rounded-circle me-2">
                                        <a class="text-heading font-semibold" href="#">
                                            Figma
                                        </a>
                                    </td>
                                    <td>
                                        $4.200
                                    </td>
                                    <td>
                                        <span class="badge badge-lg badge-dot">
                                            <i class="bg-success"></i>Scheduled
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-neutral">View</a>
                                        <button type="button" class="btn btn-sm btn-square btn-neutral text-danger-hover">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img alt="..." src="https://images.unsplash.com/photo-1612422656768-d5e4ec31fac0?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80" class="avatar avatar-sm rounded-circle me-2">
                                        <a class="text-heading font-semibold" href="#">
                                            Kristin Watson
                                        </a>
                                    </td>
                                    <td>
                                        Feb 15, 2021
                                    </td>
                                    <td>
                                        <img alt="..." src="https://preview.webpixels.io/web/img/other/logos/logo-4.png" class="avatar avatar-xs rounded-circle me-2">
                                        <a class="text-heading font-semibold" href="#">
                                            Mailchimp
                                        </a>
                                    </td>
                                    <td>
                                        $3.500
                                    </td>
                                    <td>
                                        <span class="badge badge-lg badge-dot">
                                            <i class="bg-dark"></i>Not discussed
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-neutral">View</a>
                                        <button type="button" class="btn btn-sm btn-square btn-neutral text-danger-hover">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img alt="..." src="https://images.unsplash.com/photo-1608976328267-e673d3ec06ce?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80" class="avatar avatar-sm rounded-circle me-2">
                                        <a class="text-heading font-semibold" href="#">
                                            Cody Fisher
                                        </a>
                                    </td>
                                    <td>
                                        Apr 10, 2021
                                    </td>
                                    <td>
                                        <img alt="..." src="https://preview.webpixels.io/web/img/other/logos/logo-5.png" class="avatar avatar-xs rounded-circle me-2">
                                        <a class="text-heading font-semibold" href="#">
                                            Webpixels
                                        </a>
                                    </td>
                                    <td>
                                        $1.500
                                    </td>
                                    <td>
                                        <span class="badge badge-lg badge-dot">
                                            <i class="bg-danger"></i>Canceled
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-neutral">View</a>
                                        <button type="button" class="btn btn-sm btn-square btn-neutral text-danger-hover">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img alt="..." src="https://images.unsplash.com/photo-1502823403499-6ccfcf4fb453?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80" class="avatar avatar-sm rounded-circle me-2">
                                        <a class="text-heading font-semibold" href="#">
                                            Robert Fox
                                        </a>
                                    </td>
                                    <td>
                                        Feb 15, 2021
                                    </td>
                                    <td>
                                        <img alt="..." src="https://preview.webpixels.io/web/img/other/logos/logo-1.png" class="avatar avatar-xs rounded-circle me-2">
                                        <a class="text-heading font-semibold" href="#">
                                            Dribbble
                                        </a>
                                    </td>
                                    <td>
                                        $3.500
                                    </td>
                                    <td>
                                        <span class="badge badge-lg badge-dot">
                                            <i class="bg-success"></i>Scheduled
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-neutral">View</a>
                                        <button type="button" class="btn btn-sm btn-square btn-neutral text-danger-hover">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img alt="..." src="https://images.unsplash.com/photo-1610271340738-726e199f0258?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80" class="avatar avatar-sm rounded-circle me-2">
                                        <a class="text-heading font-semibold" href="#">
                                            Darlene Robertson
                                        </a>
                                    </td>
                                    <td>
                                        Apr 15, 2021
                                    </td>
                                    <td>
                                        <img alt="..." src="https://preview.webpixels.io/web/img/other/logos/logo-2.png" class="avatar avatar-xs rounded-circle me-2">
                                        <a class="text-heading font-semibold" href="#">
                                            Netguru
                                        </a>
                                    </td>
                                    <td>
                                        $2.750
                                    </td>
                                    <td>
                                        <span class="badge badge-lg badge-dot">
                                            <i class="bg-warning"></i>Postponed
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-neutral">View</a>
                                        <button type="button" class="btn btn-sm btn-square btn-neutral text-danger-hover">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img alt="..." src="https://images.unsplash.com/photo-1610878722345-79c5eaf6a48c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80" class="avatar avatar-sm rounded-circle me-2">
                                        <a class="text-heading font-semibold" href="#">
                                            Theresa Webb
                                        </a>
                                    </td>
                                    <td>
                                        Mar 20, 2021
                                    </td>
                                    <td>
                                        <img alt="..." src="https://preview.webpixels.io/web/img/other/logos/logo-3.png" class="avatar avatar-xs rounded-circle me-2">
                                        <a class="text-heading font-semibold" href="#">
                                            Figma
                                        </a>
                                    </td>
                                    <td>
                                        $4.200
                                    </td>
                                    <td>
                                        <span class="badge badge-lg badge-dot">
                                            <i class="bg-success"></i>Scheduled
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-neutral">View</a>
                                        <button type="button" class="btn btn-sm btn-square btn-neutral text-danger-hover">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img alt="..." src="https://images.unsplash.com/photo-1612422656768-d5e4ec31fac0?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80" class="avatar avatar-sm rounded-circle me-2">
                                        <a class="text-heading font-semibold" href="#">
                                            Kristin Watson
                                        </a>
                                    </td>
                                    <td>
                                        Feb 15, 2021
                                    </td>
                                    <td>
                                        <img alt="..." src="https://preview.webpixels.io/web/img/other/logos/logo-4.png" class="avatar avatar-xs rounded-circle me-2">
                                        <a class="text-heading font-semibold" href="#">
                                            Mailchimp
                                        </a>
                                    </td>
                                    <td>
                                        $3.500
                                    </td>
                                    <td>
                                        <span class="badge badge-lg badge-dot">
                                            <i class="bg-dark"></i>Not discussed
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-neutral">View</a>
                                        <button type="button" class="btn btn-sm btn-square btn-neutral text-danger-hover">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img alt="..." src="https://images.unsplash.com/photo-1608976328267-e673d3ec06ce?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80" class="avatar avatar-sm rounded-circle me-2">
                                        <a class="text-heading font-semibold" href="#">
                                            Cody Fisher
                                        </a>
                                    </td>
                                    <td>
                                        Apr 10, 2021
                                    </td>
                                    <td>
                                        <img alt="..." src="https://preview.webpixels.io/web/img/other/logos/logo-5.png" class="avatar avatar-xs rounded-circle me-2">
                                        <a class="text-heading font-semibold" href="#">
                                            Webpixels
                                        </a>
                                    </td>
                                    <td>
                                        $1.500
                                    </td>
                                    <td>
                                        <span class="badge badge-lg badge-dot">
                                            <i class="bg-danger"></i>Canceled
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-neutral">View</a>
                                        <button type="button" class="btn btn-sm btn-square btn-neutral text-danger-hover">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer border-0 py-5">
                        <span class="text-muted text-sm">Showing 10 items out of 250 results found</span>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
</div>
         
 




















<?
require_once SERVER_CORE."routing/layout.bottom.php";

?>










