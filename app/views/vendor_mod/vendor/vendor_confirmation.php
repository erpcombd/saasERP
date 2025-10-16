<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

do_calander("#f_date");
do_calander("#t_date");
do_datatable('vendor_table');
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

// ::::: Edit This Section ::::: 
$unique='vendor_id';  		// Primary Key of this Database table
$title='Vendor Confirmation' ; 	// Page Name and Page Title
$page="vendor_confirmation.php";		// PHP File Name
$table='vendor';		// Database Table Name Mainly related to this page

$crud      = new crud($table);
$$unique = $_GET[$unique];

$data = "SELECT * FROM vendor WHERE 1";
$query = db_query($data);
$i=1;
while($row =mysqli_fetch_object($query)){
	//for update..................................
	if(isset($_POST['update_'.$row->vendor_id])){
		$approval = 'check';
		
		$sql_data = "UPDATE vendor SET approval='".$approval."' WHERE vendor_id='".$row->vendor_id."' ";
		db_query($sql_data);
	}
						

}


	
if(isset($$unique)){
	$condition=$unique."=".$$unique;	
	$data=db_fetch_object($table,$condition);
	//while (list($key, $value)=each($data)){ $$key=$value;}
	foreach ($data as $key => $value) {
		$$key = $value;
	}
}		
?>

<div class="form-container_large">
  <form id="form1" name="form1" method="post" action="">
	  <div class="container-fluid pt-0 p-0">
	  
	  <table class="table1  table-striped table-bordered table-hover table-sm" id="vendor_table">
                    <thead class="thead1">
                    <tr class="bgc-info">
						<th>SL No</th>
                        <th>Vendor ID</th>
						<th>Vendor Name </th>
						<th>Vendor Address</th>
						<th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					<? 
						//$data = "SELECT * FROM vendor WHERE 1 and approval='uncheck' order by vendor_id ASC"; 
						$data = "SELECT * FROM vendor WHERE 1 order by vendor_id ASC"; 
						$query = db_query($data);
						$i=1;
						while($row =mysqli_fetch_object($query)){
					?>
						<tr>
							<td><?=$i++;?></td>
							<td><?=$row->vendor_id;?></td>
							<td align="left"><?=$row->vendor_name;?></td>
							<td align="left"><?=$row->address;?></td>
							<td align="left"><?=$row->approval;?></td>						
							<td>
								<?php
								 if($row->approval !='uncheck'){?>
										<p class=" btn1-bg-submit">Completed</p>
								<?php } else { ?>									
								<!--<button name="update_<?=$row->vendor_id?>" id="update_<?=$row->vendor_id?>" type="submit" class="btn2 btn1-bg-update">
										Check
									</button>-->
									
									<a href="vendor_info_conf.php?vendor_id=<?=$row->vendor_id?>"><button type="button" class="btn2 btn1-bg-update"><i class="fa-solid fa-pen-to-square"></i></button></a>
								<?php } ?>

								
								
							 </td>
						</tr>
					
					<?php
					}	
					?>
					
					
                    </tbody>
                </table>
	  
	  
	  
	  
	  
	  
	
	  </div>
  </form>
</div>



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>