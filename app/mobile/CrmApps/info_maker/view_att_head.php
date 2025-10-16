<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

do_calander('#s_date');

do_calander('#e_date');


$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';

auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');


$title='Apps Attendance Information';			// Page Name and Page Title

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





require_once '../assets/template/inc.header.php';

?>
<!--<script type="text/javascript"> function DoNav(lk){

var win = window.location.assign('../appsAtt/edit_att_head.php?sl='+lk, '');
win.focus();
}</script>-->

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



<div class="right_col" role="main">
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
/*

 $res = "select o.sl,a.PBI_ID,a.PBI_NAME as name,
    DATE_FORMAT(o.xdate, '%d-%b-%Y') AS att_date,
    DATE_FORMAT(MIN(o.xtime), '%H:%i:%s') AS inTime,  -- Format inTime as HH:MM:SS
    DATE_FORMAT(MAX(o.xtime), '%H:%i:%s') AS outTime  -- Format outTime as HH:MM:SS

from personnel_basic_info a, designation c, department d,hrm_attdump_apps o 
where a.DESG_ID=c.DESG_ID and a.DEPT_ID=d.DEPT_ID  and a.PBI_ID=o.EMP_CODE and o.incharge_id='".$PBI_ID."'
and o.incharge_status='Pending' group by o.EMP_CODE,o.xdate order by o.sl desc";




echo $crud->link_report($res,$link);         
*/


 ?>
 
 
 <?php
 
   $get_id = $_GET['sl_no'];

 
   if ( isset($_GET['sl_no'])) {
   

	
	$_POST['incharge_status'] = "Approve";
	$_POST['approve_by'] = $_SESSION['user']['id'];
	
    $update = "UPDATE  hrm_attdump_apps SET incharge_status='Approve',approve_by='".$_SESSION['user']['id']."' 
	WHERE sl='".$get_id."'";
    $query=db_query($update);
	
	//$crud->update($sl_id);
    
    // Fetch data for the specific `sl` ID
    $full_att = find_all_field('hrm_attdump_apps', '*', 'sl="'.$get_id.'"');
    $PBI_ID = $full_att->EMP_CODE;
    $PBI = find_all_field('personnel_basic_info', '', 'PBI_ID="'.$PBI_ID.'"');

	
				   $inSq = 'select min(xtime) as xtime, sl from hrm_attdump_apps where xdate = "'.$full_att->xdate.'" and EMP_CODE = '.$full_att->EMP_CODE.' ';
				   $inQ = db_query($inSq);
				   $inData = mysqli_fetch_object($inQ);
	
	            $outSq = 'select max(xtime) as xtime, sl from hrm_attdump_apps where xdate = "'.$full_att->xdate.'" and EMP_CODE = '.$full_att->EMP_CODE.' ';
				$outQ = db_query($outSq);
				$outData = mysqli_fetch_object($outQ);
				

    // Insert IN time record
    $sql_in = 'INSERT INTO hrm_attdump(`ztime`, `bizid`, `EMP_CODE`, `xenrollid` , `time`, `xtime`, `xdate`, `xlocationid`, `latitude`, `longitude`)
               VALUES ("' . date('Y-m-d H:i:s') . '", "' . $PBI_ID . '", "' . $PBI_ID . '",  "' . $PBI_ID . '",
			   "' .$inData->xtime. '", "' . $inData->xtime . '", "' . $full_att->xdate . '", "999", "' . $full_att->latitude . '", "' . $full_att->longitude . '")';
    db_query($sql_in);

    // Insert OUT time record
    $sql_out = 'INSERT INTO hrm_attdump(`ztime`, `bizid`, `EMP_CODE`, `xenrollid` , `time`, `xtime`, `xdate`, `xlocationid`, `latitude`, `longitude`)
                VALUES ("' . date('Y-m-d H:i:s') . '", "' . $PBI_ID . '", "' . $PBI_ID . '", "' . $PBI_ID . '" , "' . $outData->xtime. '", "' . $outData->xtime . '", "' . $full_att->xdate . '", "999", "' . $full_att->latitude . '", "' . $full_att->longitude . '")';
    db_query($sql_out);

    // Redirect after approval
    echo '<script type="text/javascript">parent.parent.document.location.href = "../appsAtt/view_att_head.php";</script>';
    exit();
}

?>

 
  <table class="table table-bordered table-sm">
  <thead class="bg-light">
    <tr class="table-info" align="center">
	  
	  <th>SL</th>
	  <th>Emp ID</th>
	  <th>Name</th>
	  <th>Att Date</th> 
	  <th>In Time</th> 
	  <th>Out Time</th> 
	  <th>Action</th>   
    </tr>
  </thead>
	
  <tbody>
  
  
  
    <? 

$_SESSION['employee_selected']=$_SESSION['user']['id'];





 $res = "select o.sl,a.PBI_ID,a.PBI_NAME as name,
    DATE_FORMAT(o.xdate, '%d-%b-%Y') AS att_date,
    DATE_FORMAT(MIN(o.xtime), '%H:%i:%s') AS inTime,  -- Format inTime as HH:MM:SS
    DATE_FORMAT(MAX(o.xtime), '%H:%i:%s') AS outTime  -- Format outTime as HH:MM:SS

from personnel_basic_info a,hrm_attdump_apps o 
where a.PBI_ID=o.EMP_CODE 
and o.incharge_status='Pending' group by o.sl order by o.sl desc";


$queryd=db_query($res);
while($data = mysqli_fetch_object($queryd)){


  ?>
  
  
   
    <tr align="center">
	
	   <td><?=++$s?></td>
	   <td align="center"><p class="fw-normal mb-1"><?=$data->PBI_ID?></p></td>
		
      <td align="center"><span class="badge badge-primary rounded-pill d-inline"><?=$data->name?></span></td>
	  
	  <td align="center"><span class="badge badge-primary rounded-pill d-inline"><?=$data->att_date?></span></td>
	  <td align="center"><?=$data->inTime?></td>
	  <td align="center"><?=$data->outTime?></td>
	  
	  <td align="center"> 
	  
	<a href="edit_att_head.php?sl=<?=$data->sl?>"> <button type="button" class="btn btn-primary"><i class="far fa-eye"></i></button></a>
	
	
   <!-- Form for the Approval button -->
  <a id="approve-link-<?=$data->sl?>" href="view_att_head.php?sl_no=<?=$data->sl?>" style="display: none;"></a>
<button type="button" class="btn btn-success" onclick="document.getElementById('approve-link-<?=$data->sl?>').click();">
    <i class="far fa-check"></i> Approve
</button>
		  
           <!-- <input type="text" name="sl" value="<? //=$data->sl?>"> 
			
            <button type="submit" name="approve" class="btn btn-success">
                <i class="fa fa-check"></i> Approve
            </button>-->
      
			
			
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
