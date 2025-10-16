<?php

session_start();

ob_start();

 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$head='<link href="../../../assets/css/report_selection.css" type="text/css" rel="stylesheet"/>';

do_calander('#ijdb');

do_calander('#ijda');

do_calander('#ppjdb');

do_calander('#ppjda');

if($_POST['mon']!=''){

$mon=$_POST['mon'];}

else{

$mon=date('n');

}



if($_POST['year']!=''){

$year=$_POST['year'];}

else{

$year=date('Y');

}

?>

<?php require_once('../include/custom.php'); ?>

<nav class="navbar navbar-light bg-light" style="box-shadow: 0 3px #0388fc;">
        <div class="ml-auto mr-auto">
            <p style="font-weight:bold">Advanced Reporting</p>
        </div>
</nav>
<form action="crm_new_master_report.php" method="post" target="_blank">
<div class="row">
    <div class="col-md-2">   </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Organization:</label>
            <select name="org" id="org" class="form-control">
            <option value="" selected></option>
            <?php  foreign_relation('crm_project_org', 'id', 'name',$org, '1'); ?>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Lead:</label>
            <select name="lead" id="lead" class="form-control">
            <option value="" selected></option>
            <? foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p','l.id','concat(o.name,"##(",p.products,")")',$organization,'l.organization=o.id and l.product=p.id'); ?>
            </select>
        </div>
    </div>
	
	<?php /*?><div class="col-md-4">
        <div class="form-group">
            <label for="">Lead Information:</label>
            <select name="lead_info" id="lead_info" class="form-control">
            <option value="" selected></option>
            <?php  foreign_relation('crm_project_lead l,crm_project_org o', 'l.id', 'o.name',$lead_info, ' l.organization=o.id order by l.id'); ?>
            </select>
        </div>
    </div><?php */?>
	
	
    
    <div class="col-md-2">   </div>
</div>

        <div class="row mt-3">
            <div class="col-md-2">
            </div>
           <div class="col-md-8">
           <div class="input-group">
                <input type="text" value="From:" style="text-align:center!important; color:white; background-color: #3CBC8D!important;width:65px!important;margin-right: 2px!important;border-radius:0px!important;" readonly/>        
                <input type="date" name="time_from" class="form-control"  aria-label="Username"/>   
                <input type="text" class="p-2 mr-2 ml-2" value="To:" style="text-align:center!important; color:white; background-color: #3CBC8D!important;width:65px!important;margin-right: 2px!important;margin-left: 2px!important;border-radius:0px!important;" readonly/>
                <input type="date" name="time_to" class="form-control"aria-label="Username"/>
            </div>
           </div>
           <div class="col-md-2">

            </div>
        </div>
<div class="row mt-3">
    <div class="col-md-2"></div>
    <div class="col-md-4">
        <div class="form-group pt-3">
                <input type="radio" name="report" id="task_report" value="404" required>
                <label for="task_report" style="cursor:pointer;" > Organization List</label>
        </div>
		
        <div class="form-group pt-3">
                <input type="radio" name="report" id="lead_report" value="606">
                <label for="lead_report" style="cursor:pointer;"> Lead Log Report</label>
        </div>

    </div>
    <div class="col-md-4">
        <div class="form-group pt-3">
                <input type="radio" name="report" id="task_report" value="505" required>
                <label for="task_report" style="cursor:pointer;" >Lead Report</label>
        </div>
        <div class="form-group pt-3">
                <input type="radio" name="report" id="camp_report" value="707">
                <label for="camp_report" style="cursor:pointer;">Lead Activity Report</label>
        </div>

    </div>
</div>
        
<div class="form-group text-center mt-3">
    <button type="submit" href="crm_new_master_report.php" name="view_report" class="btn btn-success" target="_blank">View Report</button>
</div>
</form>



<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>

