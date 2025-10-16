<?php

session_start();

//


require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.core/init.php);
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section :::::
$title = 'Overtime Entry';			// Page Name and Page Title
$page = "overtime_entry.php";		// PHP File Name
$root = 'hrm';
$table = 'vehicle_requisition';		// Database Table Name Mainly related to this page			
$unique ='req_no';					//Unique id



//user id
$u_id=$_SESSION['user']['id'];

$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);
?>


<div class="form-container_large">
  <form id="form1" name="form1" method="post" action="">
	  <div class="container-fluid pt-0 p-0">
	   <div class="n-form-btn-class d-flex justify-content-center">
	   <div class="container p-0" style="width:40%; background-color: #e9e9e9;">
	   			<p align="center" class="bold  bg-titel "> Please Select Date</p>
            <div class="form-group row m-0 d-dlx p-3">

              <label class="col-sm-8 col-md-8 col-lg-8 col-xl-8  m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> 
			  
				<input type="date" name="date" id="date" value="" />
			  
			  </label>
              <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 p-0">               
				             <input name="submit" type="submit" class="btn2 btn1-bg-update" value="Select">

              </div>
            </div>
		</div>

      </div>
	  
	  
	  
	  
	  
	  
	  <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
						<th>SL No</th>
                        <th>User Id</th>
                        <th>User Name</th>
						<th>Salary</th>
						<th width="13%">Overtime Hours</th>
                        <th>Overtime Bill </th>
                        <th>Bill Paid</th>
                        <th>Due Bill</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody class="tbody1">
						<tr>
							<td>01</td>
							<td>0000</td>
							<td>Testing1</td>
							<td>20,000.00</td>
							<td>
								<select id="overtime_hours">
									<option >-- select please --</option>
									<option value="1">1 hour</option>
									<option value="2" selected>2 hour</option>
									<option value="3">3 hour</option>
									<option value="4">4 hour</option>
									<option value="5">5 hour</option>
									<option value="6">6 hour</option>
									<option value="7">7 hour</option>
									<option value="8">8 hour</option>
									<option value="9">9 hour</option>
									<option value="10">10 hour</option>
									<option value="11">11 hour</option>
									<option value="12">12 hour</option>
								</select>
							</td>
							<td>133.00</td>
							<td>00.00</td>
							<td>133.00</td>
							<td>
						<button type="button" onclick="DoNav('1');" class="btn2 btn1-bg-update"><i class="fa-solid fa-pen-to-square"></i></button>
						
						<input type="button" onclick="DoNav('1');" class="btn2 btn1-bg-submit" value="Submit"/>

							</td>
						</tr>
						
						<tr>
							<td>02</td>
							<td>0000</td>
							<td>Testing2</td>
							<td>20,000.00</td>
							<td>
								<select id="overtime_hours">
									<option >-- select please --</option>
									<option value="1" selected>1 hour</option>
									<option value="2">2 hour</option>
									<option value="3">3 hour</option>
									<option value="4">4 hour</option>
									<option value="5">5 hour</option>
									<option value="6">6 hour</option>
									<option value="7">7 hour</option>
									<option value="8">8 hour</option>
									<option value="9">9 hour</option>
									<option value="10">10 hour</option>
									<option value="11">11 hour</option>
									<option value="12">12 hour</option>
								</select>
							</td>
							<td>66.66</td>
							<td>00.00</td>
							<td>66.66</td>
							<td>
						<button type="button" onclick="DoNav('1');" class="btn2 btn1-bg-update"><i class="fa-solid fa-pen-to-square"></i></button>
						
						<input type="button" onclick="DoNav('1');" class="btn2 btn1-bg-submit" value="Submit"/>

							</td>
						</tr>

                    </tbody>
                </table>
	  
	  
	  
	  
	  
	  
	  
	
	  </div>
  </form>
</div>



<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";
?>

