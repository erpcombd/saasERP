<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once '../assets/support/custom.php';
require_once(SERVER_CORE.'core/init.php');

$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);

$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');

$pbi_id  =  $_SESSION['employee_selected'];
$user_role  =  $_SESSION['user']['fname'];

$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"');

$cur = '&#x9f3;';
$title = "All ".$CRMleadName." List";

$tablecustomerlist1 = 'crm_project_org';
$table2 = 'crm_org_contacts';

$crud1 = new crud($tablecustomerlist1);
$crud2 = new crud($table2);

if (isset($_POST['insert'])) {
    try {
        $_POST['entry_by'] = $_SESSION['employee_selected'];
        $_POST['entry_at'] = date('Y-m-d H:i:s');

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
        echo "<script>alert('Customer added successfully!'); window.location.reload();</script>";

    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}

if(isset($_POST['insertconverttolead'])){
    $table1 = 'crm_project_lead';
    $crud1 = new crud($table1);
    $_POST['entry_at']=date('Y-m-d H:i:s');
    $_POST['entry_by'] = $_SESSION['user']['id'];
    $log_id=$crud1->insert();

    $cd= new crud('crm_lead_log');
    $_POST['lead_id']=$log_id;
    $cd->insert();
    echo "<script>alert('Successfully converted to lead!'); window.location.reload();</script>";     
}

if(isset($_POST['updateentrylead'])){
    $crud= new crud('crm_project_org');
    $crud->update('id');
    echo "<script>alert('Lead updated successfully!'); window.location.reload();</script>";
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
    $_POST['update_at'] = date('Y-m-d H:i:s');
    $crud1->update('id');
    echo "<script>alert('Customer updated successfully!'); window.location.reload();</script>";
}

$unique='task_id'; 
$title = "CRM Dashboard";

$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');

$tableprojectlead = 'crm_project_lead';
$tableleadcontacts = 'crm_lead_contacts';

$pbi_id  =  $_SESSION['employee_selected'];
$user_role  =  $_SESSION['user']['fname'];

$table1 = 'crm_project_org';
$crud1 = new crud($table1);
$crud = new crud($table1);

$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"');

$cur = '&#x9f3;';
$table1 = 'crm_project_lead';


if(in_array($_SESSION['employee_selected'], $superID)){
    $con = "";
} else {
    $con = " AND assigned_person_id = '".$_SESSION['employee_selected']."' ";
}

require_once '../assets/template/inc.header.php';
?>

<!-- Include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Include DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<link rel="stylesheet" href="style.css">

<style>
.sidebar, .sidemenu{
    display:none;
    width: 0% !important;
}

.main_content{
    width: 100% !important;
}
#example, #example1{
    margin: 0px !important;
}
.sorting{
    background-color: #f8fcfc !important;
}
.odd{
    background-color: 'red' !important;
}

.nav-tabs .nav-link.active, .nav-tabs .nav-link.active:active, .nav-tabs .nav-link.active:focus, .nav-tabs .nav-link.active:visited, .nav-tabs .nav-link.active:hover{
    border-color: #bfc1f5;
}

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

.floatingshadowfahim {
    box-shadow: rgb(38 57 77 / 33%) 0px 20px 30px -10px;
    background-color: #fcfcfc !important;
    height: 100% !important;
    width: 100% !important;
    border-radius: 15px !important;
    padding: 15px !important;
}

.floatingshadowfahim .rounded{
    text-align:center;
}

.floatingshadowfahim h2 span, .floatingshadowfahim h2 i{
    font-size:36px !important;
}

.floatingshadowfahim h2 span i, .floatingshadowfahim h2 i, .floatingshadowfahim h2 .textspan{
    top: 39px !important;
    position: relative;
}

.unplashscreen{
    padding-bottom: 200px;
}

tr:nth-child(odd), tr:nth-child(even){
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    background-color: #f3f7fa !important;
}

thead, tbody, tfoot, tr, td, th {
    border: none !important;
}

tr{
    margin-top: 5px;
}

table {
    border-spacing: 0px 0.3rem !important;
}

.dataTables_wrapper .dataTables_filter input {
    margin-left: 0.5em;
}

label {
    display: inline-block;
    border-radius: 10px;
    padding-bottom:10px;
    padding-right:10px;
    padding-left:10px;
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    background-color: #f3f7fa !important;
}

.table>tbody {
    vertical-align: inherit;
}


.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
    width: 100px !important;
}

.dataTables_length label, .dataTables_filter label{
    display: flex;
    justify-content: center;
    align-items: center;
    padding-top: 9px;
}

#customerleadbutton{
    z-index:100 !important;  
    margin:5px; 
    padding:10px !important; 
    background-color: #3d90a7; 
    color:#FFFFFF;
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; 
    cursor: pointer;
    width: 135px;
    text-align: center;
    border-radius: 5px;
}

#customerlistbutton{
    z-index:100 !important;
    margin:5px; 
    padding:10px !important; 
    background-color: #0c8; 
    color:#FFFFFF;
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    cursor: pointer;
    width: 135px;
    text-align: center;
    border-radius: 5px;
}

.Cancel { 
    background: linear-gradient(45deg, #ffcccc, #ffd6cc) !important;
}
.Lost { 
    background: linear-gradient(45deg, #ffcccc, #ffd6cc) !important;
}
.Active {
    background: linear-gradient(45deg, #b3e6cc, #ccf2d6) !important;
}
.Won { 
    background: linear-gradient(45deg, #cce6ff, #ccf2ff) !important;
}
.Proposal { 
    background: linear-gradient(45deg, #f2f2f2, #ffffcc) !important;
}
.Qualified { 
    background: linear-gradient(45deg, #ffffcc, #ffffe0) !important;
}
.Negotiation { 
    background: linear-gradient(45deg, #ccf2ff, #e6f9ff) !important;
}
.Closed { 
    background: linear-gradient(45deg, #d9ead3, #e6f2d5) !important;
}
.Junk { 
    background: linear-gradient(45deg, #f2f2f2, #ffffcc) !important;
}
.NoBid { 
    background: linear-gradient(45deg, #ccd9e6, #d9d9d9) !important;
}

.input_general, .input_required {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    border-left: 3.5px solid #aeddf7 !important;
}

.input_required {
    border-left: 3.5px solid #df5b5b !important;
}

.btn2 {
    padding: 5px 10px;
    border-radius: 4px;
    text-decoration: none;
    margin: 0 2px;
    border: none;
    cursor: pointer;
    display: inline-block;
}

.btn1-bg-submit {
    background-color: #28a745;
    color: white;
}

.btn1-bg-help {
    background-color: #ffc107;
    color: white;
}

.btn1-bg-update {
    background-color: #17a2b8;
    color: white;
}

.d-none {
    display: none !important;
}
</style>

<div class="unplashscreen pr-0 mt-4 " id="topcard">
    <div class="col-sm-12" style="position: relative !important; bottom: -60px !important; display: flex; flex-direction: row; justify-content: center; align-items: center;">
        <p id="customerleadbutton" class="rounded" onclick="toggleleadlist()">See Lead List</p>
        <p id="customerlistbutton" class="rounded" onclick="togglecustomerlist()">See Customer List</p>
    </div>

    <!-- for leads list -->
    <div id="leadlistid" style="display:none;">
        <div class="m-0 p-0">
            <table id="example1" class="table">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Organization</th>
                        <th>Lead Name</th>
                        <th>Product</th>
                        <th>Assigned to</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sn = 1;
                    if($user_role=="Admin"){
                        $leadsQry = "SELECT a.*,o.name FROM $tableprojectlead a,crm_project_org o WHERE a.organization=o.id ORDER BY a.id DESC";
                    } else {
                        $leadsQry = "SELECT a.*,o.name FROM $tableprojectlead a,crm_project_org o WHERE a.organization=o.id and a.assign_person=$pbi_id ORDER BY a.id DESC";
                    }
                    
                    $rslt = db_query($leadsQry);
                    while($row = mysqli_fetch_object($rslt)){
                        
                        // for warning by color
                        $status = $row->status;
                        if($row->status ==1){
                            $status = 'Active';
                        } elseif($row->status ==2){
                            $status = 'Lost';
                        } elseif($row->status ==3){
                            $status = 'Won';
                        } elseif($row->status ==4){
                            $status = 'Cancel';
                        } elseif($row->status ==5){
                            $status = 'No Bid';
                        } elseif($row->status ==6){
                            $status = 'Proposal';
                        } elseif($row->status ==7){
                            $status = 'Qualified';
                        } elseif($row->status ==8){
                            $status = 'Negotiation';
                        } elseif($row->status ==9){
                            $status = 'Closed';
                        } else {
                            $status = 'Junk';
                        }

                        $class = '';
                        switch ($status) {
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
                            default:
                                $class = 'Active';
                                break;
                        }
                    ?>
                        <tr class="<?=$class?>">
                            <td><?=$row->id?></td>
                            <td><?=$row->name?></td>
                            <td><?=$row->lead_name?></td>
                            <td><?=find_a_field('crm_lead_products', 'products', 'id = "'.$row->product.'"')?></td>
                            <td><?=find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID = "'.$row->assign_person.'"')?></td>
                            <td><?=find_a_field('crm_lead_status', 'status', 'id = "'.$row->status.'"')?></td>
                            <td><?=$row->entry_at?></td>
                            <td class="d-flex">
                                <a class="btn2 btn1-bg-submit text-light mr-2" href="../info_maker/lead_details_show.php?view=<?=encrypTS($row->id)?>&tp=<?=encrypTS('lead')?>"><i class="fa-solid fa-eye"></i></a>
                            </td>
                        </tr>
                    <?php 
                        $sn++;
                    } 
                    ?>
                </tbody>
            </table>   
        </div>
    </div>

    <!-- for customer list -->
    <div id="customerlistid">
        <div class="row well">
            <div class="col-md-12 text-left pr-4">
              
             
						
						 <a data-toggle="modal" data-target="#leadentrymodal" id="addNewCustomerBtn" class="btn btn-success text-light" style="margin-top:12px; margin-bottom:14px;">+ Add New</a>

            </div>    
        </div>

        <div class="col-md-12 m-0 p-0">
            <table id="example" class="table">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Entry By</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sn = 1;
                    $leadsQry = "SELECT * FROM $tablecustomerlist1 WHERE 1";
                    $rslt = db_query($leadsQry);
                    while($row = mysqli_fetch_object($rslt)){
                    ?>
                        <tr>
                            <td><?=$sn?></td>
                            <td><?=$row->name?></td>
                            <td><?=find_a_field('user_activity_management', 'fname', 'PBI_ID = "'.$row->entry_by.'"')?></td>
                            <td><?=$row->entry_at?></td>
                            <td class="d-flex justify-content-center">
                                <a class="btn2 btn1-bg-submit text-light" href="../info_maker/crm_view.php?view=<?=encrypTS($row->id)?>&tp=<?=encrypTS('lead')?>">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <button class="btn2 btn1-bg-update ml-2" onclick="editCustomer(<?=$row->id;?>, '<?=addslashes($row->name);?>', '<?=addslashes($row->website);?>','<?=addslashes($row->annual_revenue);?>','<?=addslashes($row->lead_source);?>','<?=addslashes($row->total_employees);?>','<?=addslashes($row->lead_type);?>','<?=addslashes($row->address);?>','<?=addslashes($row->district);?>','<?=addslashes($row->zip);?>','<?=addslashes($row->country);?>','<?=addslashes($row->division);?>','<?=htmlspecialchars($row->description, ENT_QUOTES);?>','<?=addslashes($row->contact_person);?>','<?=addslashes($row->contact_number);?>','<?=addslashes($row->contact_email);?>','<?=addslashes($row->latitude);?>','<?=addslashes($row->longitude);?>')">
                                    <i class="fa-solid fa-pencil" style="color: #ffffff;"></i>
                                </button>
                                <button class="btn2 btn1-bg-update text-light ml-2" onclick="setOrganizationForLead(<?=$row->id;?>,'<?=addslashes($row->name);?>')">
                                    Convert to Lead
                                </button>
                            </td>
                        </tr>
                    <?php 
                        $sn++;
                    } 
                    ?>
                </tbody>
            </table>   
        </div>
    </div>
</div>

<!-- Modal for Customer Entry/Edit -->
<div id="customerEntryModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="customerEntryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customerEntryModalLabel">Create Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="font-size:30px !important; color: red;">&times;</span>
                </button>
            </div>
            <form id="customerForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div style="background-color: #66FFFF;" class="m-3 p-2">
                        <h5 class="text-center mb-2">New Customer Information</h5>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table">
                                <tr>
                                    <td width="120">Customer Name <span style="color: red;">*</span></td>
                                    <td><input type="text" name="name" id="orgname" value="" class="form-control input_required" required></td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6 mt-2">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Source</td>
                                        <td>
                                            <select name="lead_source" id="lead_source" class="input_general" data-live-search="true">
                                                <option value="">--Select--</option>
                                                <?php foreign_relation('crm_lead_source', 'id', 'source', '', '1'); ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Employees</td>
                                        <td><input type="text" name="total_employees" id="total_employees" class="form-control input_general"></td>
                                    </tr>
                                    <tr>
                                        <td>Yearly Turnover</td>
                                        <td><input type="text" name="annual_revenue" id="annual_revenue" class="form-control input_general"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6 mt-2">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Website</td>
                                        <td><input type="text" name="website" id="website" class="form-control input_general"></td>
                                    </tr>
                                    <tr>
                                        <td>Type</td>
                                        <td>
                                            <select name="lead_type" id="lead_type" class="input_general" data-live-search="true">
                                                <option value="">--None--</option>
                                                <?php foreign_relation('crm_lead_type', 'id', 'type', '', '1'); ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Organization Logo</td>
                                        <td><input type="file" name="logo" id="logo" class="form-control input_general"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div style="background-color: #CCFFCC;" class="m-3 p-1">
                        <h5 class="text-center mt-2 mb-2">Address Information</h5>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Country</td>
                                        <td>
                                            <select name="country" id="country" class="input_general">
                                                <option value="">--Select--</option>
                                                <?php foreign_relation('crm_country_management','id','country_name','','is_active=1 ORDER BY country_name'); ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Division</td>
                                        <td>
                                            <select name="division" id="division" class="input_general" data-live-search="true">
                                                <option value="">--Select--</option>
                                                <?php foreign_relation('division','division_CODE','division_name','','1'); ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>District</td>
                                        <td>
                                            <select name="district" id="district" class="input_general" data-live-search="true">
                                                <option value="">--Select--</option>
                                                <?php foreign_relation('district_list','id','district_name','','1'); ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Longitude</td>
                                        <td><input type="text" name="longitude" id="longitude" class="form-control input_general"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Zip Code</td>
                                        <td>
                                            <select name="zip" id="zip" class="input_general" data-live-search="true">
                                                <option value="">--Select--</option>
                                                <?php foreign_relation('crm_postalcode_list','po_code','concat(po_name,"-",po_code)','','is_active=1 ORDER BY po_name'); ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Address</td>
                                        <td><input type="text" name="address" id="orgaddress" class="form-control input_general"></td>
                                    </tr>
                                    <tr>
                                        <td>Latitude</td>
                                        <td><input type="text" name="latitude" id="latitude" class="form-control input_general"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div style="background-color: #FFCCFF;" class="m-3 p-1">
                        <h5 class="text-center mt-2 mb-2">Contact Information</h5>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Person <span style="color: red;">*</span></td>
                                        <td><input type="text" name="contact_person" id="contact_person" class="form-control input_required" required></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Number <span style="color: red;">*</span></td>
                                        <td><input type="text" name="contact_number" id="contact_number" class="form-control input_required" required></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6 mt-1">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Email <span style="color: red;">*</span></td>
                                        <td><input type="email" name="contact_email" id="contact_email" class="form-control input_required" required></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6 mt-1">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Visiting Card</td>
                                        <td><input type="file" name="visiting_card_img" id="visiting_card_img" class="form-control input_general"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-12 pt-3">
                            <div class="form-group">
                                <label for="description">Description Information</label>
                                <textarea name="description" id="description" class="form-control input_general" cols="40" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="id" id="customerId" value="">
                    <button type="button" class="btn btn-danger text-white" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveCustomerBtn" name="insert">Save</button>
                    <button type="submit" class="btn btn-warning d-none" id="updateCustomerBtn" name="update">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Convert to Lead -->
<div class="modal fade" id="convertToLeadModal" tabindex="-1" role="dialog" aria-labelledby="convertToLeadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="convertToLeadModalLabel">Organization to Lead Convert</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="font-size:30px !important; color: red;">&times;</span>
                </button>
            </div>
            <form id="convertToLeadForm" method="post">
                <input type="hidden" name="organization" id="leadOrganizationId">
                <div class="modal-body">
                    <h5 class="text-center mb-2">Lead Information</h5>
                    <div class="row">
                        <div class="col-6">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Organization Name</td>
                                        <td><input type="text" name="organizationnamelead" readonly id="organizationnamelead" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td>Enter Lead Name</td>
                                        <td>
                                            <select name="lead_name" class="input_general" required>
                                                <option value="">--Select--</option>
                                                <?php foreign_relation('crm_lead_type','id','type','','1'); ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Enter Lead Value</td>
                                        <td><input class="form-control" type="text" name="lead_value" id="lead_value"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Lead Status</td>
                                        <td>
                                            <select name="status" class="input_general" required>
                                                <option value="">--Select--</option>
                                                <?php foreign_relation('crm_lead_status','id','status','','1'); ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Assign Person</td>
                                        <td>
                                            <select name="assign_person" class="input_general" required>
                                                <option value="">--Select--</option>
                                                <?php foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME','','1'); ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Campaign</td>
                                        <td>
                                            <select name="campaign" class="input_general" required>
                                                <option value="">--Select--</option>
                                                <?php foreign_relation('crm_campaign_management','id','camp_platform','','1'); ?>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="insertconverttolead">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Global variables to track current state
let currentEditingId = null;

$(document).ready(function() {
    // Initialize DataTables
    initializeDataTables();
    
    // Set up event handlers
    setupEventHandlers();
    
    // Set up form handlers
    setupFormHandlers();
});

function initializeDataTables() {
    if ($.fn.DataTable) {
        $('#example1').DataTable({
            pageLength: 10,
            responsive: true,
            destroy: true
        });
        $('#example').DataTable({
            pageLength: 10,
            responsive: true,
            destroy: true
        });
    }
}

function setupEventHandlers() {
    // Add New Customer button
    $('#addNewCustomerBtn').on('click', function() {
        resetCustomerForm();
        $('#customerEntryModal').modal('show');
    });
    
    // Modal event handlers
    $('#customerEntryModal').on('hidden.bs.modal', function() {
        currentEditingId = null;
        resetCustomerForm();
    });
    
    $('#convertToLeadModal').on('hidden.bs.modal', function() {
        $('#convertToLeadForm')[0].reset();
        $('#leadOrganizationId').val('');
    });
}

function setupFormHandlers() {
    // Customer form submission
    $('#customerForm').on('submit', function(e) {
        if (!validateCustomerForm()) {
            e.preventDefault();
            return false;
        }
        
        // Show loading state
        const submitBtn = currentEditingId ? $('#updateCustomerBtn') : $('#saveCustomerBtn');
        submitBtn.prop('disabled', true).text('Processing...');
    });
    
    // Convert to lead form submission
    $('#convertToLeadForm').on('submit', function(e) {
        if (!validateLeadForm()) {
            e.preventDefault();
            return false;
        }
        
        $(this).find('button[type="submit"]').prop('disabled', true).text('Converting...');
    });
}

function validateCustomerForm() {
    const requiredFields = [
        { id: 'orgname', name: 'Customer Name' },
        { id: 'contact_person', name: 'Contact Person' },
        { id: 'contact_number', name: 'Contact Number' },
        { id: 'contact_email', name: 'Contact Email' }
    ];
    
    for (let field of requiredFields) {
        const element = document.getElementById(field.id);
        const value = element ? element.value.trim() : '';
        if (!value) {
            alert(`Please fill in the ${field.name} field`);
            if (element) element.focus();
            return false;
        }
    }
    
    // Email validation
    const email = document.getElementById('contact_email').value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert('Please enter a valid email address');
        document.getElementById('contact_email').focus();
        return false;
    }
    
    return true;
}

function validateLeadForm() {
    const requiredFields = [
        { name: 'lead_name', label: 'Lead Name' },
        { name: 'status', label: 'Lead Status' },
        { name: 'assign_person', label: 'Assign Person' },
        { name: 'campaign', label: 'Campaign' }
    ];
    
    for (let field of requiredFields) {
        const element = document.querySelector(`[name="${field.name}"]`);
        const value = element ? element.value : '';
        if (!value) {
            alert(`Please select a ${field.label}`);
            if (element) element.focus();
            return false;
        }
    }
    
    return true;
}

function resetCustomerForm() {
    const form = document.getElementById('customerForm');
    if (form) {
        form.reset();
        document.getElementById('customerId').value = '';
        
        // Reset button states
        $('#saveCustomerBtn').removeClass('d-none');
        $('#updateCustomerBtn').addClass('d-none');
        $('#customerEntryModalLabel').text('Create Customer');
        
        currentEditingId = null;
    }
}

function editCustomer(orgId, orgName, orgwebsite, orgyearlyturnover, sourcename, orgemployee, orgtype, orgaddress, orgdistrict, orgzip, orgcountry, orgdivision, orgdescription, orgconperson, orgconnumber, orgconmail, orglatitude, orglongitude) {
    currentEditingId = orgId;
    
    // Clean the description
    orgdescription = orgdescription ? orgdescription.replace(/"/g, "").replace(/\\/g, "") : "";
    
    // Show update button, hide save button
    $('#saveCustomerBtn').addClass('d-none');
    $('#updateCustomerBtn').removeClass('d-none');
    $('#customerEntryModalLabel').text('Update Customer');
    
    // Set form values
    setFormValue('orgname', orgName);
    setFormValue('latitude', orglatitude);
    setFormValue('longitude', orglongitude);
    setFormValue('annual_revenue', orgyearlyturnover);
    setFormValue('website', orgwebsite);
    setFormValue('total_employees', orgemployee);
    setFormValue('orgaddress', orgaddress);
    setFormValue('contact_person', orgconperson);
    setFormValue('contact_number', orgconnumber);
    setFormValue('contact_email', orgconmail);
    setFormValue('description', orgdescription);
    setFormValue('customerId', orgId);
    
    // Set select values
    setSelectValue('lead_source', sourcename);
    setSelectValue('lead_type', orgtype);
    setSelectValue('district', orgdistrict);
    setSelectValue('zip', orgzip);
    setSelectValue('country', orgcountry);
    setSelectValue('division', orgdivision);
    
    // Show modal
    $('#customerEntryModal').modal('show');
}

function setFormValue(elementId, value) {
    const element = document.getElementById(elementId);
    if (element) {
        element.value = value || '';
    }
}

function setSelectValue(selectId, value) {
    const selectElement = document.getElementById(selectId);
    if (selectElement && value) {
        // Try to find and select the matching option
        for (let i = 0; i < selectElement.options.length; i++) {
            if (selectElement.options[i].value == value || selectElement.options[i].text == value) {
                selectElement.selectedIndex = i;
                break;
            }
        }
    }
}

function setOrganizationForLead(orgId, orgName) {
    setFormValue('leadOrganizationId', orgId);
    setFormValue('organizationnamelead', orgName);
    $('#convertToLeadModal').modal('show');
}

function togglecustomerlist() {
    const customerList = document.getElementById("customerlistid");
    const leadList = document.getElementById("leadlistid");
    const customerButton = document.getElementById("customerlistbutton");
    const leadButton = document.getElementById("customerleadbutton");

    if (customerList && leadList && customerButton && leadButton) {
        customerList.style.display = "block";
        leadList.style.display = "none";
        
        customerButton.style.backgroundColor = "#0c8";
        leadButton.style.backgroundColor = "#3d90a7";
        
        // Reinitialize DataTable
        setTimeout(() => {
            if ($.fn.DataTable.isDataTable('#example')) {
                $('#example').DataTable().columns.adjust().responsive.recalc();
            }
        }, 100);
    }
}

function toggleleadlist() {
    const customerList = document.getElementById("customerlistid");
    const leadList = document.getElementById("leadlistid");
    const customerButton = document.getElementById("customerlistbutton");
    const leadButton = document.getElementById("customerleadbutton");

    if (customerList && leadList && customerButton && leadButton) {
        leadList.style.display = "block";
        customerList.style.display = "none";
        
        leadButton.style.backgroundColor = "#0c8";
        customerButton.style.backgroundColor = "#3d90a7";
        
        // Reinitialize DataTable
        setTimeout(() => {
            if ($.fn.DataTable.isDataTable('#example1')) {
                $('#example1').DataTable().columns.adjust().responsive.recalc();
            }
        }, 100);
    }
}
</script>

<?php
require_once '../assets/template/inc.footer.php';
?>