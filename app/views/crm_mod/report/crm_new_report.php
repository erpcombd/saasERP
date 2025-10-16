<?php
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


<style>
.divpad{
padding-left:100px !important;
padding-right:100px !important;
}


 tr:nth-child(odd){
     background-color: white !important;
 }

tr:nth-child(even){
    background-color: whitesmoke!important;
}
</style>



<?php require_once('../include/custom.php'); ?>

<nav class="navbar navbar-light bg-light" style="box-shadow: 0 3px #0388fc;">
        <div class="ml-auto mr-auto">
            <p style="font-weight:bold">Advanced Reporting</p>
        </div>
</nav>

<form action="crm_new_master_report.php" method="post" target="_blank">
<div class="row d-flex justify-content-center p-2">
	<div class="divpad row p-2">
	<div class="col-md-2">
			<div class="form-group">
				<label for="">Organization:</label>
				<select name="org" id="org" class="form-control">
				<option value="" selected></option>
				<?php  foreign_relation('crm_project_org', 'id', 'name',$org, '1'); ?>
				</select>
			</div>
		</div>
	
		<div class="col-md-2">
			<div class="form-group">
				<label for="">Lead:</label>
				<select name="lead" id="lead" class="form-control">
				<option></option>
				<? foreign_relation('crm_project_lead','id','lead_name',$lead,'1'); ?>
				</select>
			</div>
		</div>
		
			<div class="col-md-2">
			<div class="form-group">
				<label for="">Assign Person :</label>
				<select name="assignperson" id="assignperson" class="form-control">
				<option value="" selected></option>
				<?php  foreign_relation(' personnel_basic_info', 'PBI_ID', 'PBI_NAME',$org, '1'); ?>
				</select>
			</div>
		</div>
		
					<div class="col-md-2">
			<div class="form-group">
				<label for="">Lead Status :</label>
				<select name="leadstatus" id="leadstatus" class="form-control">
				<option value="" selected></option>
				 <? foreign_relation('crm_lead_status','id','status',$id,'1'); ?>
				</select>
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="">Activity Type :</label>
				<select name="activity_type" id="activity_type" class="form-control">
				<option value="" selected></option>
				 <? foreign_relation('crm_lead_activity_type','activity_name','activity_name',$activity_type,'1'); ?>
				</select>
			</div>
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
	
	
    
 
</div>
<br />
        <div class="container-fluid bg-form-titel d-flex justify-content-around">

           <div class="col-md-8">
           <div class="input-group">
                <input type="text" value="From:" style="text-align:center!important; color:white; background-color: #3CBC8D!important;width:65px!important;margin-right: 2px!important;border-radius:0px!important;" readonly/>        
                <input type="date" name="time_from" class="form-control"  aria-label="Username"/> 
				  
                <input type="text" value="To:" style="text-align:center!important; color:white; background-color: #3CBC8D!important;width:65px!important;margin-right: 2px!important;border-radius:0px!important;" readonly>
                <input type="date" name="time_to" class="form-control"aria-label="Username"/>
            </div>
           </div>

        </div>
		
	
		<br />
		
		<h4 class="text-center bg-titel bold p-2">
            Select report
        </h4>
<!--		
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
		</div>-->
        

<div class="container-fluid p-2">
    <table class="table1 table-striped table-bordered table-hover table-sm">
        <thead class="thead1">
            <tr class="bgc-info">
                <th></th>
                <th></th>
				<th></th>
				<th></th>
            </tr>
        </thead>
        <tbody class="tbody1">
            <tr>
                <td><input type="radio" name="report" id="task_report" value="404" required></td>
                <td><label for="task_report" style="cursor:pointer;">Organization List []</label></td>
				
				<td><input type="radio" name="report" id="lead_report" value="606"></td>
                <td><label for="lead_report" style="cursor:pointer;">Lead Log Report []</label></td>
            </tr>

            <tr>
                <td><input type="radio" name="report" id="lead_report" value="410"></td>
                <td><label for="lead_report" style="cursor:pointer;">Open Sales Deals(No Activity) Report []</label></td>
				
				<td><input type="radio" name="report" id="task_report" value="993" required></td>
                <td><label for="task_report" style="cursor:pointer;">Schedule Report [ 19 ]</label></td>	
            </tr>
            
			<tr>
                <td><input type="radio" name="report" id="task_report" value="405" required></td>
                <td><label for="task_report" style="cursor:pointer;">Sales Last Week List []</label></td>
				
				<td><input type="radio" name="report" id="lead_report" value="406"></td>
                <td><label for="lead_report" style="cursor:pointer;">Today's Call Report []</label></td>
            </tr>
            
            <tr>
                <td><input type="radio" name="report" id="task_report" value="411" required></td>
                <td><label for="task_report" style="cursor:pointer;">NO CONTACT 15 DAYS Customer List []</label></td>
				
				<td><input type="radio" name="report" id="lead_report" value="408"></td>
                <td><label for="lead_report" style="cursor:pointer;">Completed Sales Monthly Report []</label></td>
				
            </tr>
            
            <tr>
                <td><input type="radio" name="report" id="task_report" value="409" required></td>
                <td><label for="task_report" style="cursor:pointer;">Field Visit Log (Custom Report or Activity Timeline) [ 1 ]</label></td>

				<td><input type="radio" name="report" id="task_report" value="505" required></td>
                <td><label for="task_report" style="cursor:pointer;">Lead Report (Contacts Report with Lifecycle Stage & Lead Source) [ 2 ]</label></td>				
				
            </tr>
            
            <tr>

				<td><input type="radio" name="report" id="task_report" value="811" required></td>
                <td><label for="task_report" style="cursor:pointer;">Sales Report (Deal Pipeline Report) [ 3 ]</label></td>
				
				<td><input type="radio" name="report" id="lead_report" value="24082025"></td>
  				<td><label for="lead_report" style="cursor:pointer;">Final Sales with Deal Closed Report [ 4 ]</label></td>
               
            </tr>

			<tr>
				<td><input type="radio" name="report" id="camp_report" value="708"></td>
                <td><label for="camp_report" style="cursor:pointer;">Client Follow-up report [ 5 ]</label></td>

				<td><input type="radio" name="report" id="camp_report" value="38082025"></td>
                <td><label for="camp_report" style="cursor:pointer;">Re-Order Sales Report [ 6 ]</label></td>   

  			</tr>

			<tr>
				<td><input type="radio" name="report" id="lead_report" value="25082025"></td>
  				<td><label for="lead_report" style="cursor:pointer;">Additional Sales & Visit Reports (Table Wise Format) [ 7 ]</label></td>
  				
				<td><input type="radio" name="report" id="task_report" value="830" required></td>
                <td><label for="task_report" style="cursor:pointer;">Sales Territory Visit Report [ 8 ]</label></td>

  				
  			</tr>

			<tr>
				<td><input type="radio" name="report" id="lead_report" value="26082025"></td>
  				<td><label for="lead_report" style="cursor:pointer;">Sales Conversion Funnel Report [ 9 ]</label></td>

				<td><input type="radio" name="report" id="task_report" value="407" required></td>
                <td><label for="task_report" style="cursor:pointer;">Lost Deal Analysis Report [ 10 ]</label></td>

  			</tr>

			<tr>

				<td><input type="radio" name="report" id="lead_report" value="27082025"></td>
  				<td><label for="lead_report" style="cursor:pointer;">Response Time Report (Lead to Contact) [ 11 ]</label></td>

  				<td><input type="radio" name="report" id="lead_report" value="32082025"></td>
  				<td><label for="lead_report" style="cursor:pointer;">New Lead Follow-Up Workflow [ 12 ]</label></td>

  				
  			</tr>

			  <tr>
				<td><input type="radio" name="report" id="lead_report" value="33082025"></td>
  				<td><label for="lead_report" style="cursor:pointer;">No-response Follow-up Workflow [ 13 ]</label></td>
				
				<td><input type="radio" name="report" id="lead_report" value="34082025"></td>
  				<td><label for="lead_report" style="cursor:pointer;">Proposal/Deal Stage Follow-up Workflow [ 14 ]</label></td>

            </tr>
			
            <tr>
				<td><input type="radio" name="report" id="task_report" value="903" required></td>
                <td><label for="task_report" style="cursor:pointer;">Re-Order or After-Sales Follow-Up [ 15 ]</label></td>
                
				<td><input type="radio" name="report" id="task_report" value="913" required></td>
                <td><label for="task_report" style="cursor:pointer;">Missed Meeting Reschedule Workflow [ 16 ]</label></td>

            </tr>
			
			<tr>  
				<td><input type="radio" name="report" id="task_report" value="987" required></td>
                <td><label for="task_report" style="cursor:pointer;">MONTHLY SALES ACTIVITY REPORT (TABLE FORMAT) [ 17 ]</label></td>	

				<td><input type="radio" name="report" id="task_report" value="971" required></td>
                <td><label for="task_report" style="cursor:pointer;">Monthly Sales Summary Report(Table Format) [ 18 ]</label></td>
				            
            </tr>
        </tbody>
    </table>
</div>




<div class="form-group text-center mt-3">
    <button type="submit" href="crm_new_master_report.php" name="view_report" class="btn btn-success" target="_blank">View Report</button>
</div>
</form>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>

