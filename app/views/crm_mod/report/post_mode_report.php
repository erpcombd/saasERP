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
	<div class="col-md-4">
			<div class="form-group">
				<label for="">Company Name :</label>
				<select name="org" id="org" class="form-control">
				<option value="" selected></option>
				<?php  foreign_relation('crm_project_org', 'id', 'name',$org, '1'); ?>
				</select>
			</div>
		</div>
	
		<!--<div class="col-md-2">
			<div class="form-group">
				<label for="">Lead:</label>
				<select name="lead" id="lead" class="form-control">
				<option></option>
				<? foreign_relation('crm_project_lead','id','lead_name',$lead,'1'); ?>
				</select>
			</div>
		</div>-->
		
			<div class="col-md-4">
			<div class="form-group">
				<label for="">Assign Person :</label>
				  <select class="form-control chosen-select" name="assign_person[]" id="emp_id form-4" multiple> 
                                     <option value=""></option>
                                    <?php foreign_relation('personnel_basic_info', 'PBI_ID', 'concat(PBI_ID," - ",PBI_NAME)', $assign_person, '1'); ?>
                                </select>
			</div>
		</div>
		
					<div class="col-md-4">
			<div class="form-group">
				<label for=""> Status :</label>
				<select name="leadstatus" id="leadstatus" class="form-control">
				<option value="" selected></option>
				 <? foreign_relation('deal_status','id','status',$id,'1'); ?>
				</select>
			</div>
		</div>
		<!--<div class="col-md-2">
			<div class="form-group">
				<label for="">Activity Type :</label>
				<select name="activity_type" id="activity_type" class="form-control">
				<option value="" selected></option>
				 <? foreign_relation('crm_lead_activity_type','activity_name','activity_name',$activity_type,'1'); ?>
				</select>
			</div>
		</div>-->

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

            <p >Task Date</p>
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

            <p >Entry Date</p>
        <div class="container-fluid bg-form-titel d-flex justify-content-around">
             
           <div class="col-md-8">
           <div class="input-group">
                <input type="text" value="From:" style="text-align:center!important; color:white; background-color: #3CBC8D!important;width:65px!important;margin-right: 2px!important;border-radius:0px!important;" readonly/>        
                <input type="date" name="time_start" class="form-control"  aria-label="Username"/> 
				  
                <input type="text" value="To:" style="text-align:center!important; color:white; background-color: #3CBC8D!important;width:65px!important;margin-right: 2px!important;border-radius:0px!important;" readonly>
                <input type="date" name="time_end" class="form-control"aria-label="Username"/>
            </div>
           </div>

        </div>
		
		

		
		
		<br />
		
		<h4 class="text-center bg-titel bold p-2">
            Select report
        </h4>

        

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
                <td><input type="radio" name="report" id="task_report" value="420" required></td>
                <td><label for="task_report" style="cursor:pointer;">Task Report</label></td>
				
				<td><input type="radio" name="report" id="lead_report" value="421"></td>
                <td><label for="lead_report" style="cursor:pointer;">Meeting Report</label></td>
            </tr>
            
             
        

			

        </tbody>
    </table>
</div>




<div class="form-group text-center mt-3">
    <button type="submit" href="crm_new_master_report.php" name="view_report" class="btn btn-success" target="_blank">View Report</button>
</div>
</form>

  <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
	<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
	
	<script>
	$(".chosen-select").chosen({
	  no_results_text: "Oops, nothing found!"
	})
	
	</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>

