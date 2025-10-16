<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";




// ::::: Edit This Section :::::





$title = 'Disciplinary Approval';			// Page Name and Page Title



$page = "car_req_entry.php";		// PHP File Name



$root = 'transportation';



$table = 'disciplinary_action';		// Database Table Name Mainly related to this page			



$unique ='id';					//Unique id





//user id

$u_id=$_SESSION['user']['id'];



$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);





	//Insert 







	if(isset($_POST['confirmm'])){



		 $sql="INSERT INTO vehicle_requisition (PBI_ID,req_no, req_date, v_date, prj_name, person, clnt_prf,clnt_org_name,land, pup, dop, emp_name, mb_no, v_s_t, nop)







		VALUES ('".$PBI_ID."','".$_POST['req_no']."', '".$_POST['req_date']."', '".$_POST['v_date']."', '".$_POST['prj_name']."', '".$_POST['person']."', '".$_POST['clnt_prf']."', '".$_POST['clnt_org_name']."','".$_POST['land']."', 



		'".$_POST['pup']."','".$_POST['dop']."','".$_POST['emp_name']."','".$_POST['mb_no']."','".$_POST['v_s_t']."',



		'".$_POST['nop']."')";



		



		$query=db_query($sql);



   header("Location:separation_request_form.php");

   exit; // Make sure to exit after the redirect



}







?>
<style>
  /* Add some spacing between form rows */
  .form-row {
    margin-bottom: 20px;
  }

  /* Style the labels */
  label {
    font-weight: bold !important;
  }

  /* Style the textareas */
  textarea {
    resize: vertical !important;
    /* Allow vertical resizing */
  }

  /* Style the select element */
  select {
    width: 100% !important;
    /* Full width */
  }

  /* Style the form-control elements */
  .form-control {
    border: 1px solid #ced4da !important;
    /* Add a border */
    border-radius: 4px !important;
    /* Add rounded corners */
  }

  /* Add some padding to the card body */
  .card-body {
    padding: 20px !important;
  }

  .bg-titel {
    background: linear-gradient(45deg, #1717cf, #2B2BFF, #5656FF) !important;
  }
</style>

<div class="card">
    <div class="card-body">
            <!--edit form -->
  <style>
    .button {
      position: relative;
      background-color: #04AA6D;
      border: none;
      font-size: 28px;
      color: #FFFFFF;
      padding: 20px;
      width: 200px;
      text-align: center;
      -webkit-transition-duration: 0.4s;
      /* Safari */
      transition-duration: 0.4s;
      text-decoration: none;
      overflow: hidden;
      cursor: pointer;
    }

    .button:after {
      content: "";
      background: #90EE90;
      display: block;
      position: absolute;
      padding-top: 300%;
      padding-left: 350%;
      margin-left: -20px !important;
      margin-top: -120%;
      opacity: 0;
      transition: all 0.8s
    }

    .button:active:after {
      padding: 0;
      margin: 0;
      opacity: 1;
      transition: 0s
    }

    tr:nth-child(odd) {
      background-color: #EEEDED !important;
    }

    tr:nth-child(Even) {
        
    }
  </style>
  <form action="" method="post" id="form1">
    <table class="table1  table-striped table-bordered table-hover table-sm">
      <br>
      <tbody class="tbody1">
        <table class="table1  table-striped table-bordered table-hover table-sm">
          <thead class="thead1 bg-titel">
            <tr class="bgc-info">
              <th style="text-align: center">No.</th>
              <th style="text-align: center">Emp Name</th>
              <th style="text-align: center">Date of Incident</th>
              <th style="text-align: center">Time of Incident</th>
              <th style="text-align: center">Witnesse Name</th>
              <th style="width:50px;text-align: center">Status</th>
              <th style="width:50px;text-align: center">Action</th>
            </tr>
          </thead>
          <tbody class="tbody1">
            <?

//user id
$u_id=$_SESSION['user']['id'];

 $PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);


 $username = find_a_field('user_activity_management','fname','user_id='.$u_id);



if(isset($_POST['fdate'])) {

$g_s_date=$_POST['fdate'];
$g_e_date=$_POST['tdate'];

} else {
  
$g_s_date=date('Y-01-01');
$g_e_date=date('Y-12-31');

}









//and a.entry_by='.$_SESSION['employee_selected'].'


        if($_POST['department']>0)			$con .=' and p.DEPT_ID='.$_POST['department'];
		if($_POST['job_location']>0)		$con .=' and p.JOB_LOCATION='.$_POST['job_location'];
		if($_POST['group_for']>0)			$con .=' and p.PBI_ORG='.$_POST['group_for'];
		if($_POST['PBI_GROUP']!='')		    $con .=' and p.PBI_GROUP="'.$_POST['PBI_GROUP'].'"';

  //and  a.PBI_ID="'.$PBI_ID.'"
 	 $result = 'SELECT * FROM `disciplinary_action`'; 

	$query=db_query($result);
	// Initialize the counter
                $counter = 1;
	while($data = mysqli_fetch_object($query)){

?>
            <tr>
              <td style="width:180px"> <?= $counter++; ?> </td>
              <td style="width:180px"> <?= find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$data->PBI_ID); ?> </td>
              <td style="width:180px"> <?=date('d-M-Y',strtotime($data->dateIncident))?> </td>
              <td style="text-align:center">
                 <?=date('h:i:sa',strtotime($data->timeIncident))?>
                </td>

              <td style="text-align:center"> <?=$data->witnesses?> </td>
              <td style="width:50px,text-align:center">
                    <?php 
                    if ($data->status == 1) {
                      echo "Pending";
                    } elseif ($data->status == 2) {
                      echo "Approve";
                    } else {
                      echo "No data";
                    }
                  ?>
              </td>
               <td style="width:50px,text-align:center">
                 <a href="discipline_approval_view.php?id=<?= $data->id; ?>" class="btn btn-primary">
        View 
    </a>
              </td>
             
            </tr> <? } ?><?  
/*	if($_GET['asign_id']>0){

$update = "update hrm_iom_info set iom_status='GRANTED',dept_head_status='Approve' where id='".$_GET['asign_id']."'";

$query=mysql_query($update);

 $ss = mysql_query("select * from hrm_iom_info  where id='".$_GET['asign_id']."'");
$dataa = mysql_fetch_object($ss);


$from_date = strtotime($dataa->s_date);
$to_date= strtotime($dataa->e_date);
$emp_id = $dataa->PBI_ID;
$iom_type =  $dataa->type;
$iom_sl_no =  $dataa->id;
$iom_entry_at= $dataa->entry_at;
$iom_entry_by= $dataa->entry_by;
$s_time = $dataa->s_time; 
$e_time =  $dataa->e_time;





for($i=$from_date; $i<=$to_date; $i=$i+86400)
{
$att_date=date('Y-m-d',$i);

$found = find_a_field('hrm_att_summary','1','emp_id="'.$emp_id.'" and att_date="'.$att_date.'"');
if($found==0)
{
 $sql="INSERT INTO hrm_att_summary (emp_id, iom_type, iom_id, att_date,iom_start_time,iom_end_time,iom_entry_at,iom_entry_by,iom_category, dayname)
VALUES ('$emp_id', '$iom_type', '$iom_sl_no','$att_date','$s_time','$e_time','$iom_entry_at','$iom_entry_by','$iom_category', dayname('".$att_date."'))";
$query=mysql_query($sql);
}

else{
 $sql='update hrm_att_summary set iom_type="'.$iom_type.'", iom_id="'.$iom_sl_no.'",iom_start_time="'.$s_time.'",iom_end_time="'.$e_time.'",dayname=dayname("'.$att_date.'"),

iom_entry_at="'.$iom_entry_at.'", iom_entry_by="'.$iom_entry_by.'",iom_category="'.$iom_category.'"

where  emp_id="'.$emp_id.'" and att_date="'.$att_date.'" ';

$query=mysql_query($sql);

}



} 




header('location:iom_approval_all.php');
	
	
	}*/
	
	
	?>
          </tbody>
  </form>
  </table>
  </div>
  </div>
  </div>
  </div>
    </div>
    
  
</div>
 
<script>
document.addEventListener("DOMContentLoaded", function() {
  var today = new Date().toISOString().split('T')[0];
  ["separationdate"].forEach(function(id) {
    var dateInput = document.getElementById(id);
    if (!dateInput.value) dateInput.value = today;
  });
});

</script>


<!-- Include Bootstrap CSS and JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<?php
if(isset($_POST['confirm'])) {
    $separationdate = $_POST['separationdate'];
    $separationreason = $_POST['separationreason'];
    $comments = $_POST['comments'];


    // Prepare and bind SQL statement
    $ins_sql = $insert_sql = "INSERT INTO `separation_details` (`PBI_ID`, `separationdate`, `separationreason`, `comments`) 
                   VALUES ('$PBI_ID', '$separationdate', '$separationreason', '$comments')";

    $ins_sql=db_query($ins_sql);
  
  if($ins_sql) {
            echo "<script>alert('Data Inserted into Database');
             window.location.href = window.location.href;
            </script>";
        } else {
            echo "<script>alert('Failed to insert data');</script>";       
        }
  
  }
?>








<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>