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

	

 $sql='UPDATE bills SET status="Checked",  hr_status="Pending"
		

WHERE conveyance_no="'.$_GET['con_id'].'"';

$query=db_query($sql);		

header("Location:conveyance_team_leader.php");
exit; // Make sure to exit after the redirect



}




if(isset($_POST['cancel'])){

$sql='UPDATE bills SET leader_cancel_status="'.mysqli_real_escape_string($_POST['cancelreason']).'",status="Pending" WHERE conveyance_no="'.$_GET['con_id'].'"';
$query=db_query($sql);		

header("Location:conveyance_unapproved_bhaiya.php");
exit; // Make sure to exit after the redirect



}

//



//$car = find_all_field('vehicle_requisition','','req_id="'.$_GET['req_id'].'"');



?>











    <div class="form-container_large">



        <div class="container-fluid pt-0 p-0">



          <form action="" method="post">



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
    
    </tr>
  </thead>
  <tbody>
    <?php
      // Retrieve data from table
      $sql = "SELECT b.*,p.PBI_NAME,p.PBI_DESIGNATION FROM bills b,personnel_basic_info p where b.emp_code=p.PBI_CODE and conveyance_no='".$_GET['con_id']."'";
      $result = db_query($sql);

      // Display data in Bootstrap table with input fields
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
    
		echo '<td>' . $row['conveyance_no'] . '</td>';
		echo '<td>' . $row['emp_code'] . '</td>';
		  
		  echo '<td>' .$row['PBI_NAME']. '</td>';
		  echo '<td>' . $row['PBI_DESIGNATION'] . '</td>';
		  echo '<td>' . $row['means'] . '</td>';
		  
		echo '<td>' . $row['conveyance_type'] . '</td>';  
		echo '<td>' . $row['from_address'] . '</td>';
		echo '<td>' . $row['to_address'] . '</td>'; 
		echo '<td>' . $row['remarks'] . '</td>'; 
		echo '<td>' . $row['amount'] . '</td>';  
	
        //echo '<td><input type="number" name="amount[]" value="' . $row['amount'] . '"></td>';
		//echo '<input type="hidden" name="bills_id[]" value="' . $row['bills_id'] . '">';
		//echo '<input type="hidden" name="conveyance_no[]" value="' . $row['conveyance_no'] . '">';
       // echo '<td><button type="submit" name="submit" class="btn btn-info">Update</button></td>';
        echo '</tr>';
      }
    ?>
  </tbody>
</table>




<? /* if (isset($_POST['submit'])) {
  // Loop through the input fields and update the corresponding rows in the database
  for ($i = 0; $i < count($_POST['amount']); $i++) {
    $id = $_POST['bills_id'][$i]; // Assuming the IDs start from 1
    $amount = $_POST['amount'][$i];
    $con_no = $_POST['conveyance_no'][$i];

    $sql = "UPDATE bills SET amount = '$amount'  WHERE bills_id = $id";
    db_query($sql);
  }

   header("Location: conveyance_view.php?con_id=$con_no");
   exit;

}
*/
?>



                    </div>



                </div>



                </div>











                

                <div class="n-form-btn-class col-sm-12">
				
				
				
					  <button type="button"  class="btn btn-danger cancel-button" data-toggle="modal" data-target="#cancelModal">Conveyance Return</button>
	  
	  
	  	<!--  MODAL START -->		
		<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelModalLabel">Conveyance Return Reason</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
             
                    <div class="modal-body">
                        <textarea name="cancelreason" class="form-control" placeholder="Enter Return reason"></textarea>
                  
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        
						
						<input class="btn btn-danger" name="cancel" type="submit" id="cancel" value="Return">
                    </div>
          
            </div>
        </div>
    </div>
		
		<!--  MODAL END -->		

                    <input class="btn1 btn1-bg-submit xs" name="confirmm" type="submit" id="confirmm" value="Confirm and Forward">
					
					

                </div>

        	</div>

    	</form>

 	</div>

</div>











<?



//



//



require_once SERVER_CORE."routing/layout.bottom.php";



?>