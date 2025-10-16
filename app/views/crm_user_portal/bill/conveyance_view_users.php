<?php



//



//




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";











// ::::: Edit This Section :::::







$title = 'Conveyance Approval';			// Page Name and Page Title



$page = "car_req_entry.php";		// PHP File Name



$root = 'transportation';



$table = 'vehicle_requisition';		// Database Table Name Mainly related to this page			



$unique ='req_no';					//Unique id





//user id

$u_id=$_SESSION['user']['id'];



$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);





	//Insert 
if(isset($_POST['confirmm'])){

$sql='UPDATE bills SET hr_status="Completed", hr_approval_date="'.date("Y-m-d H:i:s").'" WHERE conveyance_no="'.$_GET['con_id'].'"';
$query=db_query($sql);		

echo '<script>window.close();</script>';




}





?>



	







    <div class="form-container_large">



        <div class="container-fluid pt-0 p-0">



          <form action="#" method="POST" enctype="multipart/form-data" class="form1">



            <div class="row m-0">



                <div class="card">



                    <h4 class="text-center bg-titel bold pt-2 pb-2">Conveyance Approval </h4>



                    <div class="card-body">



                        <div class="row m-0">


<table class="table table-bordered table-sm">
  <thead>
    <tr>

	  <th>Conveyance No</th>
	  <th>Emp ID</th>
		
		<th>Emp Name</th>
		<th>Emp Deg.</th>
		<th>Means of Conveyance</th>
		
      <th>Conveyance Type</th>
	  <th>From Address</th>
	  <th>To Address</th>
	  <th>Remarks</th>
      <th>Amount</th>

      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
      // Retrieve data from table
      $sql = "SELECT b.*,p.PBI_NAME,p.PBI_DESIGNATION FROM bills b,personnel_basic_info p where b.emp_code=p.PBI_CODE and b.conveyance_no='".$_GET['con_id']."'";
      $result = db_query($sql);

      // Display data in Bootstrap table with input fields
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
    
		echo '<td>' . $row['conveyance_no'] . '</td>';
		echo '<td>' . $row['emp_code'] . '</td>';
		  
		  echo '<td>' . $row['PBI_NAME'] . '</td>';
		  echo '<td>' . $row['PBI_DESIGNATION'] . '</td>';
		  echo '<td>' . $row['means'] . '</td>';
		  
		echo '<td>' . $row['conveyance_type'] . '</td>';  
		echo '<td>' . $row['from_address'] . '</td>';
		echo '<td>' . $row['to_address'] . '</td>';
		echo '<td>' . $row['remarks'] . '</td>';  
	
        echo '<td><input type="number" name="amount[]" value="' . $row['amount'] . '"></td>';
	
		echo '<input type="hidden" name="bills_id[]" value="' . $row['bills_id'] . '">';
		echo '<input type="hidden" name="conveyance_no[]" value="' . $row['conveyance_no'] . '">';
		
	
		if ($row['status'] == 'Checked' ) {
		
		echo '<td><button  class="btn btn-primary" disabled>Completed</button></td>';
		}else{
		
        echo '<td><button type="submit" name="submit" class="btn btn-danger">Update</button></td>';
		}
		
        echo '</tr>';
      }
    ?>
  </tbody>
</table>




<?  if (isset($_POST['submit'])) {
  // Loop through the input fields and update the corresponding rows in the database
  for ($i = 0; $i < count($_POST['amount']); $i++) {
    $id = $_POST['bills_id'][$i]; // Assuming the IDs start from 1
    $amount = $_POST['amount'][$i];
	$remarks = mysqli_real_escape_string($_POST['hr_remarks'][$i]);
    $con_no = $_POST['conveyance_no'][$i];

    $sql = "UPDATE bills SET amount = '$amount'  WHERE bills_id = $id";
    db_query($sql);
  }

   header("Location:conveyance_employ.php?con_id=$con_no");
   exit;
  // Redirect to the same page to avoid resubmitting the form on refresh
  //header('Location: ' . $_SERVER['PHP_SELF']);
  //exit();
}

?>







                    </div>



                </div>



                </div>




     <!--<div class="n-form-btn-class col-sm-12">
	  <input class="btn btn-success" name="confirmm" type="submit" id="confirmm" value="Confirm and Forward">
					
	</div>-->
	
	    
	
	

        	</div>

    	</form>

 	</div>

</div>











<?



//



//



require_once SERVER_CORE."routing/layout.bottom.php";



?>