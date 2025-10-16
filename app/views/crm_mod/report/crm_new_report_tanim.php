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

<form action="crm_new_master_report_tanim.php" method="post" target="_blank">
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
                <td><label for="task_report" style="cursor:pointer;">Organization List</label><span>(404)</span></td>
				
				<td><input type="radio" name="report" id="lead_report" value="606"></td>
                <td><label for="lead_report" style="cursor:pointer;">Lead Log Report</label><span>(606)</span></td>
            </tr>
            <tr>
                <td><input type="radio" name="report" id="task_report" value="505" required></td>
                <td><label for="task_report" style="cursor:pointer;">Lead Report</label><span>(505)</span></td>
				
				 <td><input type="radio" name="report" id="camp_report" value="707"></td>
                <td><label for="camp_report" style="cursor:pointer;">Lead Activity Report</label><span>(707)</span></td>
                
                
            </tr>
             <tr>
                <td><input type="radio" name="report" id="task_report" value="405" required></td>
                <td><label for="task_report" style="cursor:pointer;">Sales Last Week List</label><span>(405)</span></td>
				
				<td><input type="radio" name="report" id="lead_report" value="406"></td>
                <td><label for="lead_report" style="cursor:pointer;">Today's Call Report</label><span>(406)</span></td>
            </tr>
            
                <tr>
                <td><input type="radio" name="report" id="task_report" value="407" required></td>
                <td><label for="task_report" style="cursor:pointer;">Sales Lost Last Month List</label><span>(407)</span></td>
				
				<td><input type="radio" name="report" id="lead_report" value="408"></td>
                <td><label for="lead_report" style="cursor:pointer;">Completed Sales Monthly Report</label><span>(408)</span></td>
            </tr>
            
             </tr>
            
                <tr>
                <td><input type="radio" name="report" id="task_report" value="409" required></td>
                <td><label for="task_report" style="cursor:pointer;">Today's Meetings / Visits List</label><span>(409)</span></td>
				
				<td><input type="radio" name="report" id="lead_report" value="410"></td>
                <td><label for="lead_report" style="cursor:pointer;">Open Sales Deals(No Activity) Report</label><span>(410)</span></td>
            </tr>
            
            
             </tr>
            
                <tr>
                <td><input type="radio" name="report" id="task_report" value="411" required></td>
                <td><label for="task_report" style="cursor:pointer;">NO CONTACT 15 DAYS Customer List</label><span>(411)</span></td>
				
				<td><input type="radio" name="report" id="camp_report" value="708"></td>
                <td><label for="camp_report" style="cursor:pointer;">Detail Lead Activity Report</label><span>(708)</span></td>
               
            </tr>
		
			
        </tbody>
    </table>
</div>




<div class="form-group text-center mt-3">
    <button type="submit" href="crm_new_master_report_tanim.php" name="view_report" class="btn btn-success" target="_blank">View Report</button>
</div>
</form>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>

