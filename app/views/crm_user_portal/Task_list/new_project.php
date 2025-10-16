<?php
//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Add Department';
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

	if(isset($_POST['update']))
	{ 
	 $crud   = new crud($table);
	 $_POST['user_ids'] = implode(',',$_POST['user_ids']);
	 $_POST['manager_id'] = $_POST['manager_ids'];
	 $_POST['udate_by']=$_SESSION['user']['id'];
     $_POST['update_at']=date('Y-m-d H:s:i');
	 $crud->update($unique);
		header('Location:project_list.php');
	}

}
	  $sql3="select * from project_list where id = '".$_REQUEST['project_id']."'";
	$query3 = db_query($sql3);
	$data3=mysqli_fetch_object($query3);
	

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
		<form action="" method="post" name="form1" id="form1">
			<div class="col-lg-12">
			<div class="card card-outline card-primary">
				<div class="card-body">
					<form action="" id="manage-project">

				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Name</label>
							<input type="text" class="form-control form-control-sm" name="name" value="<?php if($data3->name!='') echo  $data3->name;?>">
						</div>
					</div>
					<!--<div class="col-md-6">
						<div class="form-group">
							<label for="">Status</label>
							<select name="status" id="status" class="custom-select custom-select-sm">
								<option value="Pending" <?php echo isset($status) && $status == 'Pending' ? 'selected' : '' ?>>Pending</option>
								<option value="Started" <?php echo isset($status) && $status == 'Started' ? 'selected' : '' ?>>Started</option>
								<option value="On-Progress" <?php echo isset($status) && $status == 'On-Progress' ? 'selected' : '' ?>>On-Progress</option>
								<option value="On-Hold" <?php echo isset($status) && $status == 'On-Hold' ? 'selected' : '' ?>>On-Hold</option>
								<option value="Over Due" <?php echo isset($status) && $status == 'Over Due' ? 'selected' : '' ?>>Over Due</option>
								<option value="Done" <?php echo isset($status) && $status == 'Done' ? 'selected' : '' ?>>Done</option>
							</select>
						</div>
					</div>-->
				</div>
				<!--<div class="row">
					<div class="col-md-6">
					<div class="form-group">
					<label for="" class="control-label">Start Date</label>
					<input type="date" class="form-control form-control-sm" autocomplete="off" name="start_date" value="<?php echo isset($start_date) ? date("Y-m-d",strtotime($start_date)) : '' ?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
					<label for="" class="control-label">End Date</label>
					<input type="date" class="form-control form-control-sm" autocomplete="off" name="end_date" value="<?php echo isset($end_date) ? date("Y-m-d",strtotime($end_date)) : '' ?>">
					</div>
				</div>
				</div>-->
				<div class="row">
					<?php //if($_SESSION['login_type'] == 1 ): ?>
				<div class="col-md-6">
					<div class="form-group">
					<label for="" class="control-label">Manager</label>
					<select class="form-control form-control-sm select2" name="manager_ids">
						<option></option>
						<? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$data3->manager_id,'1 order by PBI_NAME asc');?>
					</select>
					</div>
				</div>
			<?php //else: ?>
				<input type="hidden" name="manager_id" value="<?php //echo $_SESSION['login_id'] ?>">
			<?php //endif; ?>
				<div class="col-md-6">
					<div class="form-group">
					<label for="" class="control-label">Team Members</label>
					<select class="form-control form-control-sm select2" multiple="multiple" id="datasss" name="user_ids[]">
						<option></option>
						<? $sq = 'select PBI_ID, PBI_NAME from personnel_basic_info where PBI_ID in ('.$data3->user_ids.') order by PBI_NAME asc' ;
							$qu = db_query($sq);
							while($re=mysqli_fetch_object($qu)){
								echo '<option selected value="'.$re->PBI_ID.'">'.$re->PBI_NAME.'</option>';
							}
						?>
						<? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$manager_id,'1 order by PBI_NAME asc');?>
						
					</select>
					</div>
				</div>
				</div>
				
				<!--<div class="row">
					<div class="col-md-10">
						<div class="form-group">
							<label for="" class="control-label">Description</label>
							<textarea name="description" id="summernote" cols="30" rows="10" class="summernote form-control">
								<?php //echo isset($description) ? $description : '' ?>
							</textarea>
	<script>
      $('#summernote').summernote({
        placeholder: 'Hello stand alone ui',
        tabsize: 2,
        height: 120,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });
    </script>
						</div>
					</div>
				</div>-->
				</form>
				</div>
				<div class="card-footer border-top border-info">
					<div class="d-flex w-100 justify-content-center align-items-center">
					  <? if($_REQUEST['project_id']>0){?>
					  <input type="hidden" name="id" value="<?=$_REQUEST['project_id'];?>"  />
					  <button class="btn btn-success  bg-gradient-primary mx-2" type="submit" name="update" >Update</button>
					  <? }else{ ?>
						<button class="btn btn-success  bg-gradient-primary mx-2" type="submit" name="nledger" >Save</button>
					  <? } ?>	
						<button class="btn btn-info bg-gradient-secondary mx-2" type="button" onclick="location.href='new_project.php'">Cancel</button>
					</div>
				</div>
			</div>
		</div>
		
		</form
		
		
		></div>	
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
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>