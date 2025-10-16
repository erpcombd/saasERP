<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 

$title='Personal File Check Status';// Page Name and Page Title
$page="pf_status.php";	// PHP File Name
$input_page="pf_status_input.php";
$root='hrm';
$table='pf_status';		// Database Table Name Mainly related to this page
$unique='PF_STATUS_ID';	// Primary Key of this Database table
$shown='PF_STATUS_CV';	// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::

$crud = new crud($table);
$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);
$required_id = find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);

if($required_id>0)

$$unique = $_GET[$unique] = $required_id;





if(isset($$unique)){

$condition=$unique."=".$$unique;

$data=db_fetch_object($table,$condition);

foreach($data as $key => $value)

{ $$key=$value;}

}

?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}
</script>
<style>
	
.style1{
padding-left:20px;
}

.container {
  padding: 2rem 0rem;
}

h4 {
  margin: 2rem 0rem 1rem;
}

.table-image {
  td, th {
    vertical-align: middle;
  }
}

</style>
<form action="" method="post" enctype="multipart/form-data">
  <? include('../common/title_bar.php');?>
  <table class="table table-bordered table-sm">
    <thead class="bg-light">
      <tr class="table-info" align="center">
        <th>SL</th>
        <th>Employee ID</th>
		<th>Attendance Date</th>
		
        <th>Punch Time</th>
        <!-- <th>View</th> -->
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <? 

$start = date("Y-m-26", strtotime("-1 month")); 
$end   = date("Y-m-25");
 
 
$sqld = 'select *
from hrm_attdump
where EMP_CODE="'.$_SESSION['employee_selected'].'" and xdate BETWEEN "'.$start.'" AND "'.$end.'" order by xdate';


$queryd=db_query($sqld);
while($data = mysqli_fetch_object($queryd)){

 $pf = find_all_field('pf_status','','PBI_ID="'.$_SESSION['employee_selected'].'"');

  ?>
      <tr align="center">
        <td><?=++$s?></td>
        <td align="center"><p class="fw-normal mb-1"><?=$data->EMP_CODE?></p></td>
		<td align="center"><p class="fw-normal mb-1"><?=$data->xdate?></p></td>
        <td align="center"><span class="badge badge-success rounded-pill d-inline"><?=date("h:i A", strtotime($data->ztime));?></span></td>
        <td align="center"> <a href="att_log_delete.php?asign_id=<?=$data->sl;?>" onclick="return confirm('Are you sure you want to delete this item?');"   
			class="btn btn-danger btn-flat"> <i class="fa fa-trash"></i> </a> </td>
      </tr>
      <? } ?>
    </tbody>
  </table>
</form>
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>
