<?php
session_start();
ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Task Report';
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

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>    
  	<td width="100%" style="padding-right:5%">
		<div class="left">
		

		<div class="col-md-12">
        <div class="card card-outline card-success">
          <div class="card-header">
            <b>Project Progress</b>
            <div class="card-tools">
            	<button class="btn btn-flat btn-sm bg-gradient-success btn-success" style="float:right" id="print"><i class="fa fa-print"></i> Print</button>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive" id="printable">
              <table class="table m-0 table-bordered" id="ac_ledger">
               <!--  <colgroup>
                  <col width="5%">
                  <col width="30%">
                  <col width="35%">
                  <col width="15%">
                  <col width="15%">
                </colgroup> -->
                <thead>
                  <th>#</th>
                  <th>Project</th>
                  <th>Task</th>
                  <th>Completed Task</th>
                  <th>Work Duration</th>
                  <th>Progress</th>
                  <th>Status</th>
                </thead>
                <tbody>
                <?php
                $i = 1;
                // $stat = array("Pending","Started","On-Progress","On-Hold","Over Due","Done");
                // $where = "";
                // if($_SESSION['login_type'] == 2){
                //   $where = " where manager_id = '{$_SESSION['login_id']}' ";
                // }elseif($_SESSION['login_type'] == 3){
                //   $where = " where concat('[',REPLACE(user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' ";
                // }
                // $qry = $conn->query("SELECT * FROM project_list $where order by name asc");
                // while($row= $qry->fetch_assoc()):
                // $tprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']}")->num_rows;
                // $cprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']} and status = 3")->num_rows;
                // $prog = $tprog > 0 ? ($cprog/$tprog) * 100 : 0;
                // $prog = $prog > 0 ?  number_format($prog,2) : $prog;
                // $prod = $conn->query("SELECT * FROM user_productivity where project_id = {$row['id']}")->num_rows;
                // $dur = $conn->query("SELECT sum(time_rendered) as duration FROM user_productivity where project_id = {$row['id']}");
                // $dur = $dur->num_rows > 0 ? $dur->fetch_assoc()['duration'] : 0;
                // if($row['status'] == 0 && strtotime(date('Y-m-d')) >= strtotime($row['start_date'])):
                // if($prod  > 0  || $cprog > 0)
                //   $row['status'] = 2;
                // else
                //   $row['status'] = 1;
                // elseif($row['status'] == 0 && strtotime(date('Y-m-d')) > strtotime($row['end_date'])):
                // $row['status'] = 4;
                // endif;

                $sql="SELECT * FROM project_list $where order by name asc";
                $query = db_query($sql);
                while($data=mysqli_fetch_object($query)){
                  $tprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']}")->num_rows;
                // $cprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']} and status = 3")->num_rows;
                // $prog = $tprog > 0 ? ($cprog/$tprog) * 100 : 0;
                // $prog = $prog > 0 ?  number_format($prog,2) : $prog;
                // $prod = $conn->query("SELECT * FROM user_productivity where project_id = {$row['id']}")->num_rows;
                // $dur = $conn->query("SELECT sum(time_rendered) as duration FROM user_productivity where project_id = {$row['id']}");
                // $dur = $dur->num_rows > 0 ? $dur->fetch_assoc()['duration'] : 0;
                  ?>
                  <tr>
                      <td>
                         <?php echo $i++ ?>
                      </td>
                      <td>
                          <a>
                              <?php echo ucwords($data->name) ?>
                          </a>
                          <br>
                          <small>
                              Due: <?php echo date("Y-m-d",strtotime($data->end_date)) ?>
                          </small>
                      </td>
                      <td class="text-center">
                      	<?php echo number_format($tprog) ?>
                      </td>
                      <td class="text-center">
                      	<?php echo number_format($cprog) ?>
                      </td>
                      <td class="text-center">
                      	<?php echo number_format($dur).' Hr/s.' ?>
                      </td>
                      <td class="project_progress">
                          <div class="progress progress-sm">
                              <div class="progress-bar bg-green" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prog ?>%">
                              </div>
                          </div>
                          <small>
                              <?php echo $prog ?>% Complete
                          </small>
                      </td>
                      <td class="project-state">
                          <?php
                            if($data->status =='Pending'){
                              echo "<span class='badge badge-secondary'>{$data->status}</span>";
                            }elseif($data->status =='Started'){
                              echo "<span class='badge badge-primary'>{$data->status}</span>";
                            }elseif($data->status =='On-Progress'){
                              echo "<span class='badge badge-info'>{$data->status}</span>";
                            }elseif($data->status =='On-Hold'){
                              echo "<span class='badge badge-warning'>{$data->status}</span>";
                            }elseif($data->status =='Over Due'){
                              echo "<span class='badge badge-danger'>{$data->status}</span>";
                            }elseif($data->status =='Done'){
                              echo "<span class='badge badge-success'>{$data->status}</span>";
                            }
                          ?>
                      </td>
                  </tr>
                <?php } //endwhile; ?>
                </tbody>  
              </table>
            </div>
          </div>
        </div>
        </div>
<script>
	$('#print').click(function(){
		start_load()
		var _h = $('head').clone()
		var _p = $('#printable').clone()
		var _d = "<p class='text-center'><b>Project Progress Report as of (<?php echo date("F d, Y") ?>)</b></p>"
		_p.prepend(_d)
		_p.prepend(_h)
		var nw = window.open("","","width=900,height=600")
		nw.document.write(_p.html())
		nw.document.close()
		nw.print()
		setTimeout(function(){
			nw.close()
			end_load()
		},750)
	})
</script>
		
		
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