<?php
session_start();
ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Department List';
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
	//$sql="select * from task_project where project_id='".$_REQUEST['project_id']."'";
//	$query = db_query($sql);
//	$data=mysqli_fetch_object($query);

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

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>    
  	<td width="100%" style="padding-right:5%">
		<div class="left">
		

		<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
           
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-condensed" id="ac_ledger">
				<colgroup>
					<col width="5%">
					<col width="35%">
					<col width="35%">
					<col width="35%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Department</th>
						<th>Manager</th>
						<th>Team Members</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					 $i = 1;
					
					
					 $sql="select * from project_list where 1 order by id desc";
					$query = db_query($sql);
					while($data=mysqli_fetch_object($query)){ 
					?>
					<tr>
						<td align="center"><?php echo $i++ ?></td>
						<td>
							<p><b><?php echo ucwords($data->name) ?></b></p>
							<p class="truncate"><?php echo strip_tags($desc) ?></p>
						</td>
						<td><b><?php echo find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$data->manager_id); ?></b></td>
						<td><dl>
								<?php 
								if(!empty($data->user_ids)){
								$sql1="select PBI_NAME,PBI_ID from personnel_basic_info where PBI_ID in ($data->user_ids) ";
								$query1 = db_query($sql1);
								while($datas=mysqli_fetch_object($query1)){
								?>
									<dd>
										<div class="d-flex align-items-center mt-1">
											<b><?php echo ucwords($datas->PBI_NAME); ?></b>
										</div>
									</dd>
								
								<?php }} ?>
							</dl></td>
						
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true" onclick="location.href='view_project.php?project_id=<?=$data->id?>'">
		                      View Details
		                    </button>
							
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info "  aria-expanded="true" onclick="location.href='new_project.php?project_id=<?=$data->id?>'">
		                     Edit
		                    </button>
		                    
		                  <?php //endif; ?>
		                    </div>
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
</table>




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
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>