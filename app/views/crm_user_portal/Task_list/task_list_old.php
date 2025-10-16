<?php
//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Task List';
$proj_id=$_SESSION['proj_id'];
$table = 'project_list';
$unique = 'id';
$shown = 'name';
do_datatable('ac_ledger');
$now=time();
if(isset($_REQUEST['name']))
{
	
	
	$id=$_REQUEST['project_id'];
	$name		= mysqli_real_escape_string($_REQUEST['name']);
	$name		= str_replace("'","",$name);
	$name		= str_replace("&","",$name);
	$name		= str_replace('"','',$name);
	//end
	if(isset($_POST['nledger']))
	{
		$crud   = new crud($table);
		$_POST['user_ids'] = implode(',',$_POST['user_ids']);
		$_POST['manager_id'] = $_POST['manager_ids'];
		$_POST['entry_by'] = $_SESSION['user']['id'];
		$_POST['entry_at'] = date('Y-m-d H:i:s');
		$$unique=$_SESSION[$unique]=$crud->insert();
        unset($$unique); 	
	}

//for Modify..................................

	if(isset($_POST['mledger']))
	{
	 $crud   = new crud($table);
	 $_POST['udate_by']=$_SESSION['user']['id'];
     $_POST['update_at']=date('Y-m-d H:s:i');
	 $crud->update($unique);

	}

}
	 $sql="select * from task_project where project_id='".$_REQUEST['project_id']."'";
	$query = db_query($sql);
	$data=mysqli_fetch_object($query);

auto_complete_from_db('accounts_ledger','concat(ledger_name,"#>",ledger_id)','concat(ledger_name,"#>",ledger_id)','ledger_id like "%00000000"','under');
?>
<style type="text/css">
<!--
.style3 {color: #FFFFFF; font-weight: bold; }
-->
</style>
<link href="summer/summernote-lite.min.css" rel="stylesheet">
<script src="summer/summernote-lite.min.js"></script>
<link rel="stylesheet" href="summer/select2.min.css">
<link rel="stylesheet" href="summer/select2-bootstrap4.min.css">
<script src="summer/select2.full.min.js"></script>





<div class="form-container_large">
        <div class="container-fluid pt-5 p-0" >
            
            <table class="table1  table-striped table-bordered table-hover table-sm" id="ac_ledger">
                <thead class="thead1">
                <tr class="bgc-info">
				<th>SL</th>
                    <th>Department</th>
						<th>Task</th>
						<th>Date</th>
						<th>Time</th>
						<th>Assign To</th>
						<th>Task Status</th>
						<th>Action</th>
                </tr>
                </thead>

                <tbody class="tbody1">

                <?php
					$i = 1;
					 
					$sql="select t.*, p.name as pname, t.task_date,p.status as pstatus, t.task_end_date,t.start_time, t.end_time ,p.id as pid,i.PBI_NAME 
					from task_list t , project_list p, personnel_basic_info i 
					  where  p.id = t.project_id and t.status !='Done' and i.PBI_ID=t.assign_person and t.assign_person in ('".$_SESSION['employee_selected']."',0) order by p.name asc ";
					$query = db_query($sql);
					while($data=mysqli_fetch_object($query)){

					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
						<td>
							<?php echo ucwords($data->pname) ?>
						</td>
						<td>
							<?php echo ucwords($data->task) ?>
							<p class="truncate"><?php echo strip_tags($desc) ?></p>
						</td>
						<td><?php echo $data->task_date .'<br> '.$data->task_end_date; ?></td>
						<td><?php echo $data->start_time .'<br> '.$data->end_time; ?></td>
						<td class="text-center">
							<?php echo $data->PBI_NAME;?>
						</td>
						<td>
                        	<?php 
                        	if($data->status == 'Pending'){
						  		echo "<span class='badge badge-secondary'>Pending</span>";
                        	}elseif($data->status == 'On-Progress'){
						  		echo "<span class='badge badge-primary'>On-Progress</span>";
                        	}elseif($data->status == 'Done'){
						  		echo "<span class='badge badge-success'>Done</span>";
                        	}
                        	?>
                        </td>
						<td class="text-center">
			                    <a href="view_task.php?task_id=<?=$data->id?>" class="btn1 btn1-bg-submit">Submit Progress</a>
						</td>
					</tr>	
				<?php } //endwhile; ?>

                </tbody>
            </table>


        </div>
</div>



<?php /*?><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>    
  	<td width="100%" style="padding-right:5%">
		<div class="left">
		

		<div class="col-lg-12" style="width:100%">
	<div class="card card-outline card-success">
		<div class="card-header">
			<div class="card-tools">
				<!--<button class="btn btn-primary btn-sm btn-default btn-flat border-primary" href=""><i class="fa fa-plus"></i> Add New Task</button>-->
			</div>
		</div>
		<div class="card-body" style="width:100%;overflow: scroll;">
			<table class="table tabe-hover table-condensed" id="ac_ledger">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="20%">
					<col width="15%">
					<col width="15%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Department</th>
						<th>Task</th>
						<th>Date</th>
						<th>Time</th>
						<th>Assign To</th>
						<th>Task Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					 
					$sql="select t.*, p.name as pname, t.task_date,p.status as pstatus, t.task_end_date,t.start_time, t.end_time ,p.id as pid,i.PBI_NAME 
					from task_list t , project_list p, personnel_basic_info i 
					  where  p.id = t.project_id and i.PBI_ID=t.assign_person and t.assign_person in ('".$_SESSION['employee_selected']."',0) order by p.name asc ";
					$query = db_query($sql);
					while($data=mysqli_fetch_object($query)){

					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
						<td>
							<p><b><?php echo ucwords($data->pname) ?></b></p>
						</td>
						<td>
							<p><b><?php echo ucwords($data->task) ?></b></p>
							<p class="truncate"><?php echo strip_tags($desc) ?></p>
						</td>
						<td><b><?php echo $data->task_date .'<br> '.$data->task_end_date; ?></b></td>
						<td><b><?php echo $data->start_time .'<br> '.$data->end_time; ?></b></td>
						<td class="text-center">
							<?php echo $data->PBI_NAME;?>
						</td>
						<td>
                        	<?php 
                        	if($data->status == 'Pending'){
						  		echo "<span class='badge badge-secondary'>Pending</span>";
                        	}elseif($data->status == 'On-Progress'){
						  		echo "<span class='badge badge-primary'>On-Progress</span>";
                        	}elseif($data->status == 'Done'){
						  		echo "<span class='badge badge-success'>Done</span>";
                        	}
                        	?>
                        </td>
						<td class="text-center">
			                    <a href="view_task.php?task_id=<?=$data->id?>" class="btn btn-info btn-sm">Submit Progress</a>
						</td>
					</tr>	
				<?php } //endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<style>
	table p{
		margin: unset !important;
	}
	table td{
		vertical-align: middle !important
	}
</style>
		
		
		</div>	
	</td>
  </tr>
</table><?php */?>




<script type="text/javascript">
function Do_Nav(){
	var URL = 'pop_ledger_selecting_list.php';
	popUp(URL);
}

function DoNav(theUrl){
	document.location.href = 'add_project.php?project_id='+theUrl;
}

function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");
}
</script>
<script type="text/javascript">
	document.onkeypress=function(e){
	var e=window.event || e
	var keyunicode=e.charCode || e.keyCode
	if (keyunicode==13)
	{
		return false;
	}
}

$(document).ready(function(){
	  $('.select2').select2({
	    placeholder:"Please select here",
	    width: "100%"
	  });
  })
</script>
<?
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>