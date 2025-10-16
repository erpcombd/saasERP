<?php
//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Task Detials View';
$proj_id=$_SESSION['proj_id'];
$table = 'project_list';
$unique = 'id';
$shown = 'name';
do_datatable('ac_ledger');
$now=time();
if(isset($_POST['project_id']))
{
	
	
	//$id=$_REQUEST['project_id'];
	$name		= mysqli_real_escape_string($_REQUEST['task']);
	$name		= str_replace("'","",$name);
	$name		= str_replace("&","",$name);
	$name		= str_replace('"','',$name);
	//end
	if(isset($_POST['task_submit']))
	{   $task_table = 'task_list';
		$crud   = new crud($task_table);
		$_POST['entry_by'] = $_SESSION['user']['id'];
		$_POST['entry_at'] = date('Y-m-d H:i:s');
		$$unique=$_SESSION[$unique]=$crud->insert();
        unset($$unique); 	
	}
	
	if(isset($_POST['activity_submit']))
	{   $task_table = 'user_productivity';
		
		
		$crud   = new crud($task_table);
		$_POST['time_rendered'] = $mins;
		$_POST['user_id'] = $_SESSION['user']['id'];
		$_POST['date_created'] = date('Y-m-d H:i:s');
		$$unique=$_SESSION[$unique]=$crud->insert();
        unset($$unique); 	
	}
	
	
//for Modify..................................

	if(isset($_POST['task_update']))
	{
	$task_table = 'task_list';
	 $crud   = new crud($task_table);
	 $_POST['udate_by']=$_SESSION['user']['id'];
     $_POST['update_at']=date('Y-m-d H:s:i');
	 $crud->update($unique);

	}

}

	if(isset($_POST['activity_comment']))
	{   $comment_table = 'comment_list';
		$crud   = new crud($comment_table);
		$_POST['entry_by'] = $_SESSION['user']['id'];
		$_POST['entry_at'] = date('Y-m-d H:i:s');
		$$unique=$_SESSION[$unique]=$crud->insert();
        unset($$unique); 	
	}


	$sql="select * from task_list where id='".$_REQUEST['task_id']."'";
	$query = db_query($sql);
	$data=mysqli_fetch_object($query);
	
	$user_ids = find_a_field('project_list','user_ids','id='.$data->project_id);

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
<script src="summer/bootstrap.min.js" ></script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>    
  	<td width="90%" style="padding-right:5%">
		<div class="left">
		
		<div class="col-lg-12">
	<div class="row" style="width:90%">
		
		<div class="col-md-12">
			<div class="card card-outline card-primary">
				<div class="card-header">
					<a href="task_list.php" class="btn btn-info sm">Back</a>
					<span><b>Task List:</b></span>
					<?php //if($_SESSION['login_type'] != 3): ?>
					
				<?php //endif; ?>
				</div>
				<div class="card-body p-0">
					<div class="table-responsive">
					<table class="table table-condensed m-0 table-hover">
						<colgroup>
							<col width="5%">
							<col width="25%">
							<col width="25%">
							<col width="15%">
							<col width="20%">
						</colgroup>
						<thead>
							<th>#</th>
							<th>Task</th>
							<th>Assign Person</th>
							<th>Description</th>
							<th>Status</th>
							<? if($_GET['task_id']!=29){?><th>Action</th><? } ?>
						</thead>
						<tbody>
							<?php 
							$i = 1;
							
							$task_sql="select * from task_list where id='".$data->id."'";
							$task_query = db_query($task_sql);
							while($task_data=mysqli_fetch_object($task_query)){
							?>
								<tr>
			                        <td class="text-center"><?php echo $i++ ?></td>
			                        <td class=""><b><?php echo ucwords($task_data->task); ?></b></td>
									<td class=""><b><?php echo find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$task_data->assign_person); ?></b></td>
			                        <td class=""><p class="truncate"><?php echo html_entity_decode($task_data->description) ?></p></td>
			                        <td>
			                        	<?php 
											  if($task_data->status =='Pending'){
												echo "<span class='badge badge-secondary'>{$task_data->status}</span>";
											  }elseif($task_data->status =='Started'){
												echo "<span class='badge badge-primary'>{$task_data->status}</span>";
											  }elseif($task_data->status =='On-Progress'){
												echo "<span class='badge badge-info'>{$task_data->status}</span>";
											  }elseif($task_data->status =='On-Hold'){
												echo "<span class='badge badge-warning'>{$task_data->status}</span>";
											  }elseif($task_data->status =='Over Due'){
												echo "<span class='badge badge-danger'>{$task_data->status}</span>";
											  }elseif($task_data->status =='Done'){
												echo "<span class='badge badge-success'>{$task_data->status}</span>";
											  }
			                        	?>
			                        </td>
			                        <td class="text-center">
									<? if($_GET['task_id']!=29){?>	<button class="btn btn-primary" data-toggle="modal" data-target="#commentTaskModal<?=$task_data->id?>" type="button" id="new_productivity">
								 Comment</button><? } ?>
<div class="modal fade lg" id="commentTaskModal<?=$task_data->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Task Comment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" style="text-align:left">
          <div class="form-group">
            <label>Comment: </label>
			<input type="hidden" name="m_id" value="<?=$task_data->id?>" class="form-control" >
			<input type="hidden" name="tr_from" value="task" class="form-control" >
            <textarea name="comment" class="form-control" value=""></textarea>
          </div>
		  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="activity_comment"  class="btn btn-primary">Save</button>
      </div>
	 </form> 
    </div>
  </div>
</div>	
<? if($_GET['task_id']!=29){?>							 
<button class="btn btn-info" data-toggle="modal" data-target="#editModal<?=$task_data->id?>" type="button" >Edit</button>
<? } ?>
										
<div class="modal fade lg" id="editModal<?=$task_data->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" style="text-align:left">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Department Name:</label>
			<input type="hidden" name="project_id" value="<?=$task_data->project_id?>" class="form-control" >
			<input type="hidden" name="id" value="<?=$task_data->id;?>" class="form-control" >
            <input type="text" class="form-control" readonly="" value="<?=find_a_field('project_list','name','id='.$task_data->project_id);?>" id="recipient-name">
          </div>
		  <div class="form-group">
            <label for="recipient-name" class="col-form-label">Task:</label>
            <input type="text" class="form-control" name="task" value="<?=$task_data->task;?>" id="recipient-name">
          </div>
		  <div class="form-group">
            <label for="recipient-name" class="col-form-label">Assign Person: </label>
            <select class="form-control select2" name="assign_person" value="" id="recipient-name">
				<?  foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$task_data->assign_person,' PBI_ID in ('.$user_ids.')');?>
			</select>
          </div>
		  <div class="form-group">
            <label for="recipient-name" class="col-form-label">Task Date:</label>
            <input type="date" class="form-control" name="task_date" value="<?=$task_data->task_date?>" id="recipient-name">
          </div>
		  <div class="form-group">
            <label for="recipient-name" class="col-form-label">Task End Date:</label>
            <input type="date" class="form-control" name="task_end_date" value="<?=$task_data->task_end_date?>" id="recipient-name">
          </div>
		  <div class="form-group">
            <span>Start Time:</span>
            <input type="time" style="width:30%" class="form-control" name="start_time" value="<?=$task_data->start_time?>" id="recipient-name">
			<span>End Time:</span>
            <input type="time" class="form-control" style="width:30%" name="end_time" value="<?=$task_data->end_time?>" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Description:</label>
            <textarea class="form-control" name="description" ><? echo html_entity_decode($task_data->description);?></textarea>
          </div>
		  
		  <div class="form-group">
            <label for="recipient-name" class="col-form-label">Status:</label>
            <select name="status" id="status" class="custom-select custom-select-sm">
				<option value="Pending" <?php echo isset($task_data->status) && $task_data->status == 'Pending' ? 'selected' : '' ?>>Pending</option>
				<option value="Started" <?php echo isset($task_data->status) && $task_data->status == 'Started' ? 'selected' : '' ?>>Started</option>
				<option value="On-Progress" <?php echo isset($task_data->status) && $task_data->status == 'On-Progress' ? 'selected' : '' ?>>On-Progress</option>
				<option value="On-Hold" <?php echo isset($task_data->status) && $task_data->status == 'On-Hold' ? 'selected' : '' ?>>On-Hold</option>
				<option value="Over Due" <?php echo isset($task_data->status) && $task_data->status == 'Over Due' ? 'selected' : '' ?>>Over Due</option>
				<option value="Done" <?php echo isset($task_data->status) && $task_data->status == 'Done' ? 'selected' : '' ?>>Done</option>
			</select>
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="task_update"  class="btn btn-primary">Update</button>
      </div>
	 </form> 
    </div>
  </div>
</div>
									</td>
		                    	</tr>
							<?php 
							}
							?>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	<div class="row" style="width:90%">
		
		<div class="col-md-12">
			<div class="card card-outline card-primary">
				<div class="card-header">
					<span><b>Task Comment List:</b></span>
					<?php  $sq = 'select c.comment,c.entry_at,u.fname from comment_list c, user_activity_management u 
							  			   where u.user_id=c.entry_by and c.tr_from like "task" and c.m_id ='.$data->id.' ';
									$qu = db_query($sq);	
									while($re=mysqli_fetch_object($qu)){   
							  ?>
		                      <p><b><?=$re->fname;?> : </b><?=$re->comment;?></p>
							  <? } ?>
				</div>
				<div class="card-body p-0 l-2">
					
				</div>
			</div>
			</div>
		</div>	
	
	
	
	<div class="modal fade lg" id="prodactivityModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Progress/Activity</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Subject:</label>
			<input type="hidden" name="project_id" value="<?=$data->project_id?>" class="form-control" >
			<input type="hidden" name="task_id" value="<?=$data->id?>" class="form-control" >
            <input type="text" class="form-control" readonly="" value="<?=find_a_field('project_list','name','id='.$data->project_id);?>" id="recipient-name">
          </div>
		  
		  <div class="form-group">
            <label for="recipient-name" class="col-form-label">Task:</label>
            <input type="text" class="form-control" name="subject" value="" id="subject">
          </div>
		  
		  <div class="form-group">
            <label for="recipient-name" class="col-form-label">Project.. :</label>
            <select class="form-control form-control-sm" name="project_id" id="project_id">
				 <option></option>
				<? foreign_relation('project','PROJECT_ID','PROJECT_NAME',$_POST['project_id'],'1 order by PROJECT_NAME asc');?>
			</select>
          </div>
		  
		  <div class="form-group">
            <label for="recipient-name" class="col-form-label">Request By:</label>
            <input type="text" class="form-control" name="task_request_by" value="" id="task_request_by">
          </div>
		  
		  <div class="form-group">
            <label for="recipient-name" class="col-form-label">Request Date:</label>
            <input type="date" class="form-control" name="req_date" value="" id="req_date">
          </div>
		  
		   <div class="form-group">
            <label for="recipient-name" class="col-form-label">Complete Date:</label>
            <input type="date" class="form-control" name="complete_date" value="" id="complete_date">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Comment:</label>
            <textarea class="form-control" name="comment" id="comment"></textarea>
          </div>
		  <div class="form-group">
            <label for="recipient-name" class="col-form-label">Status</label>
            <input type="text" class="form-control" name="task_status" value="" id="task_status" placeholder="Completed/Processing..">
          </div>
		  
		  
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="activity_submit"  class="btn btn-primary">Save</button>
      </div>
	 </form> 
    </div>
  </div>
</div>
	
	
	
	<div class="row" style="width:90%">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<b>Members Progress/Activity</b>
					<div class="card-tools" style="float:right">
						<button class="btn btn-primary bg-gradient-primary btn-sm" data-toggle="modal" data-target="#prodactivityModal" type="button" id="new_productivity"><i class="fa fa-plus"></i> New Productivity</button>
					</div>
				</div>
				<div class="card-body">
					<?php 
					// $progress = $conn->query("SELECT p.*,concat(u.firstname,' ',u.lastname) as uname,u.avatar,t.task FROM user_productivity p inner join users u on u.id = p.user_id inner join task_list t on t.id = p.task_id where p.project_id = $id order by unix_timestamp(p.date_created) desc ");
					// while($row = $progress->fetch_assoc()):
					
					$activity_sql="select p.*, u.fname, t.task from user_productivity p, user_activity_management u, task_list t  
					where u.user_id=p.user_id and t.id=p.task_id and t.id='".$data->id."' order by unix_timestamp(p.date_created) desc";
					$activity_query = db_query($activity_sql);
					while($activity_data=mysqli_fetch_object($activity_query)){
					
					
					?>
					
<div class="modal fade lg" id="commentModal<?=$activity_data->id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Progress/Activity</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Comment: </label>
			<input type="hidden" name="m_id" value="<?=$activity_data->id;?>" class="form-control" >
			<input type="hidden" name="tr_from" value="activity" class="form-control" >
            <textarea name="comment" class="form-control" value=""></textarea>
          </div>
		  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="activity_comment"  class="btn btn-primary">Save</button>
      </div>
	 </form> 
    </div>
  </div>
</div>
						<div class="post">

		                      <div class="user-block">
		                      	<?php //if($_SESSION['login_id'] == $row['user_id']): ?>
		                      	<span class="btn-group dropleft float-right">
								  <button class="btn btn-info" data-toggle="modal" data-target="#commentModal<?=$activity_data->id;?>" type="button" id="new_productivity">
								  <i class="fas fa-comment-alt mr-1"> Comment</i></button>
								</span>
								<?php //endif; ?>
		                        <img class="img-circle img-thumbnail p-0 shadow-sm border-info img-sm mr-3" src="avatar.jpg<?php //echo $row['avatar'] ?>" style="width:32px" alt="user image">
		                        <span class="username">
		                          <b><?php echo date('M d, Y',strtotime($activity_data->date)) ?> [ <?php echo ucwords($activity_data->subject) ?> ]</b>
		                        </span>
		                        <span class="description">
		                        	
	                        	</span>

	                        	

		                      </div>
		                      <!-- /.user-block -->
		                      <div>
		                       <?php echo html_entity_decode($activity_data->comment) ?>
		                      </div>
							  <?php  $sq = 'select c.comment,c.entry_at,u.fname from comment_list c, user_activity_management u 
							  			   where u.user_id=c.entry_by and c.tr_from like "activity" and c.m_id ='.$activity_data->id.' ';
									$qu = db_query($sq);	
									while($re=mysqli_fetch_object($qu)){   
							  ?>
		                      <p><b><?=$re->fname;?> : </b><?=$re->comment;?></p>
							  <? } ?>
	                    </div>
	                    <div class="post clearfix"></div>
                    <?php } //endwhile; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
	.users-list>li img {
	    border-radius: 50%;
	    height: 67px;
	    width: 67px;
	    object-fit: cover;
	}
	.users-list>li {
		width: 33.33% !important
	}
	.truncate {
		-webkit-line-clamp:1 !important;
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
  
 $('#summernote').summernote({
        placeholder: '',
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
<?
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>