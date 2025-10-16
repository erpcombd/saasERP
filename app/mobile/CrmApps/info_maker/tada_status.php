<?php

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

do_calander('#s_date');

do_calander('#e_date');


$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';

auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');


$title='OD Information';			// Page Name and Page Title

$root='iom';

/*$table='hrm_iom_info';
$unique='id';
$shown='s_date';*/


$table='hrm_attdump_apps';		// Database Table Name Mainly related to this page
$unique='sl';				// Primary Key of this Database table
$shown='status';				// For a New or Edit Data a must have data field





$u_id=$_SESSION['user']['id'];

$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);

$PBI = find_all_field('personnel_basic_info','','PBI_ID='.$PBI_ID);

$_SESSION['employee_selected'] = $PBI_ID;



$rep_auth = find_a_field('hrm_iom_info','reporting_auth','PBI_ID='.$PBI_ID);



$crud      =new crud($table);



if(prevent_multi_submit()){


if(isset($_POST[$shown])){

$$unique = $_POST[$unique];

$crud->insert();

}

}

if(isset($_POST['approved'])){
    
            $status = 'CHECKED';
            $id = $_POST['update_id'];
            $update_stmt = $conn->prepare("UPDATE bills_details SET  status = ? WHERE bills_id = ?");
            $update_stmt->bind_param("si", $status, $id);
            
//             echo "DEBUG SQL: UPDATE bills_details SET status = '$status' WHERE bills_id = $id";
// exit;
            
            if ($update_stmt->execute()) {
                $message = "Record updated successfully";
                $message_type = "success";
            } else {
                $message = "Error updating record: " . $conn->error;
                $message_type = "error";
            }
            $update_stmt->close();
    
}


require_once '../assets/template/inc.header.php';
?>


<script type="text/javascript">
$(document).ready(function(){

$("#e_date").change(function (){
var from_leave = $("#s_date").datepicker('getDate');
var to_leave = $("#e_date").datepicker('getDate');
var days   = ((to_leave - from_leave)/1000/60/60/24)+1;


if(days>0&&days<100){
$("#total_days").val(days);}
});


$("#s_date").change(function (){
var from_leave = $("#s_date").datepicker('getDate');
var to_leave = $("#e_date").datepicker('getDate');
var days   = ((to_leave - from_leave)/1000/60/60/24)+1;

if(days>0&&days<100){
$("#total_days").val(days);}
});

});

</script>



<div class="right_col" role="main" style="margin-top: 60px;" >
  <!-- Must not delete it ,this is main design header-->
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <!--<h2>Plain Page</h2>-->
            <div class="clearfix"></div>
          </div>
          <div class="openerp openerp_webclient_container">
            <div class="x_content">
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-primary" align="center">
                    <div class="panel-heading">
                      <!--<h3 class="panel-title">Leave</h3>-->
                    </div>
                    <div class="panel-body">
                      <form action=""  method="post" style="background-color:#FFFFFF">
                        <? 


 ?>
 
 
 <?php


?>

  <table class="table table-bordered table-sm">
  <thead class="bg-light">
    <tr class="table-info" align="center">  
	    <th>SL</th>
	    <th>Conveyance ID</th>
	    <th>Employee Name</th>
	    <th>Entry At</th> 
	    <th>Conveyance Type</th>
	    <th>FROM</th>
	    <th>TO</th>
	    <th>Transport By</th>
	    <th>Amount</th>
	    <th>Approver Remarks</th>
	    <th>status</th>
      <th>Action</th>   
    </tr>
  </thead>
	
  <tbody>
  
  
  
    <? 

$_SESSION['employee_selected']=$_SESSION['user']['id'];




if($_SESSION['user']['id']==10001){
 $res = "select a.*, b.PBI_NAME as name , c.s_date, c.s_time, c.e_time
from bills_details a
join  personnel_basic_info b on a.entry_by = b.PBI_ID 
join hrm_od_info c  on a.od_id = c.id
where a.status in ('UNCHECKED','MANUAL','CHECKED') ";
}
else
{
  $res = "select a.*, b.PBI_NAME as name , c.s_date, c.s_time, c.e_time
from bills_details a 
join personnel_basic_info b on a.entry_by = b.PBI_ID
join hrm_od_info c  on a.od_id = c.id
where a.status in ('UNCHECKED','MANUAL','CHECKED') and a.entry_by = '".$PBI_ID."'";
 
}

$queryd=db_query($res);
while($data = mysqli_fetch_object($queryd)){


  ?>
  
  
   
    <tr align="center">
	
	    <td><?=++$s?></td>
	    <td align="center"><?=$data->od_id?></td>
		
        <td align="center"><span class="badge badge-primary rounded-pill d-inline"><?=$data->name?></span></td>
	  
	    <td align="center"><span class="badge badge-primary rounded-pill d-inline"><?=$data->s_date?></span><br><small><?=$data->s_time?>-<?=$data->e_time?></small></td>
	    <td align="center"><?=$data->conveyance_type?></td>
	    <td><?=$data->from_address?></td>
	    <td><?=$data->to_address?></td>	  
	    <td><?=$data->transport_type?></td>
	    <td align="center"><?=$data->amount?></td>
		  <td align="center"><?=$data->hr_remarks ?? ''?></td>
		  <td align="center"><?=$data->status ?? ''?></td>
      <td align="center"> 
  
	        <a href="tada_details_status.php?sl=<?=$data->bills_id?>"> <button type="button" class="btn btn-primary"><i class="far fa-eye"></i></button></a>
	          <!-- Form for the Approval button -->
            <!--<a id="approve-link-<?//=$data->sl?>" href="view_att_head.php?sl_no=<?=$data->sl?>" style="display: none;"></a>-->
          <input type="hidden" name="update_id" value="<?=$data->bills_id ?>" />
            <!-- <button type="submit" name="approved" class="btn btn-primary">Approved</button> -->
	    </td>

    </tr>
    
	  
	
	<? } ?>
	
	  
  
  </tbody>
</table>

                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- /page content -->
<?



require_once '../assets/template/inc.footer.php';





?>
