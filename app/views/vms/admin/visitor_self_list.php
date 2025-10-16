<?php
session_start ();
include ("../config/access_admin.php");
include ("../config/db.php");
include '../config/function.php';
$menu = 'Visitor';
$sub_menu = 'visitor_list';
$today = date('Y-m-d');
$company_id     = $_SESSION['company_id'];
?>
        
<!--Top header	-->	
<?php include("inc/header.php");?>
<?php include("inc/header_top.php");?>
        
		
		
<!--BODY Start	-->	
		<section class="content-main">
            <div class="content-header">
                        <h2 class="content-title">Visitor Request List</h2>
                        <div>
                            <a href="visitor_self_list.php"><button class="btn btn-md rounded font-sm hover-up">Visitor Request List 
                            <?php echo find1("select count(visitor_id) from visitor_table_self where sync_status=0 and company_id='".$company_id."'");?></button></a>
                            
                            <a href="visitor_entry.php"><button class="btn btn-md rounded font-sm hover-up">New Visitor</button></a>
                        </div>
                    </div>
            
              

<div class="card mb-4">

<div class="card-body">
<div class="table-responsive">
<table class="table table-striped">
    <thead>
        <tr>
      <th scope="col">LOG</th>
      <th scope="col">visitor_name</th>
	  <th scope="col">Image</th>
      <th scope="col">meet_person_name</th>

	  <th scope="col">reason_to_meet</th>
	  <th scope="col">visitor_intime</th>
	  <th scope="col">visitor_outtime</th>
	  <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
<?php 
$sql = "select v.* from visitor_table_self v where 1 and sync_status=0 and v.company_id='".$company_id."'  order by visitor_id desc ";
$query=mysqli_query($conn, $sql);
while($data=mysqli_fetch_object($query)){
?>
    <tr>
      <td class="align-middle"><a href="visitor_card.php?log=<?php echo $data->visitor_id;?>"><?php echo $data->visitor_id;?></a></th>
	  <td class="align-middle"><?php echo $data->visitor_name;?><br><?php echo $data->visitor_mobile_no;?><br><?php echo $data->visitor_nid;?><br><?php echo $data->visitor_address;?></td>
	  
	  
	  <td class="align-middle"><img src="visitor_image/<?php echo $data->visitor_in_image;?>"></td>
	  <td class="align-middle"><?php echo $data->visitor_meet_person_name;?><br><?php echo find1("select department_name from setup_department where department_id='".$data->visitor_department."'");?></td>
	  <td class="align-middle"><?php echo $data->visitor_reason_to_meet;?></td>
	  <td class="align-middle"><?php echo $data->visitor_enter_time;?></td>

<td class="align-middle">
<a href="visitor_entry_confirm.php?req=<?php echo $data->visitor_id;?>"><button name="status" class="btn btn-success">Process</button></a>
</td>
	  	  
        </tr>
        <?php } ?>
</tbody>
</table>	
</div></div></div>
				
				

				

<!-- /end Body page -->
			
			
			
</section> 		
<!-- Body end// -->
        
		
		
<?php include("inc/footer.php");?>