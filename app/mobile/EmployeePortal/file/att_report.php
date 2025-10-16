<?php 
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
require_once '../assets/support/emp_apps_function.php';

$u_id= $_SESSION['user']['id'];  //$_SESSION['user_id']; 
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);

$user_id	= $PBI_ID; //$_SESSION['user_id'];

$title = "Punch Report";
$page = "att_report.php";


require_once '../assets/template/inc.header.php';

?>


    

<!-- start of Page Content-->  
   <div class="page-content header-clear-medium">
   
   
   


		
		

        <div class="card card-style">
			<form action="" method="post">
				<div class="content">
					<!--<h4>Attendance Punch Report <br /> <?=$_SESSION['msg']; unset($_SESSION['msg']);?></h4>-->
				<div class="row mb-3">
					<div class="col-12">
						<label for="form6">From Date</label>
						<input type="date"  max="2030-01-01" min="2021-01-01" class="form-control validate-text" id="form6" placeholder="From Date" name="fdate"  value="<?=$_POST['fdate'];?>">
						</div>
						<div class="col-12">
						<label for="form6">To Date</label>
						<input type="date" max="2030-01-01" min="2021-01-01" class="form-control validate-text" id="form6" placeholder="To Date" name="tdate"  value="<?=$_POST['tdate'];?>">
						</div>
						</div>
	
					
					
					<div class="d-flex justify-content-center row">
					
						<div class="col-6">
							<input class="btn btn-3d btn-m btn-full mb-0 b-n rounded-xs font-900 shadow-s btn-success w-100" type="submit" name="show" value="Show" >
						</div>
					</div>
				</div>
			</form>
            </div>
			<? 

if(isset($_POST['show'])){

	if($_POST['fdate'] !='' && $_POST['tdate'] !='') $con = ' and xdate between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'" ' ;

}

$sql = "select * from hrm_attdump  where 1 and EMP_CODE='".$user_id."' ".$con." group by xdate order by sl desc";

if (!empty($sql)) {

$query=db_query($sql);


} else {
   
    echo "Error: Empty query string.";
   
}


while($data=mysqli_fetch_object($query)){

?>  

			
			
			<!--card start report-->
			<div class="card card-style">
			<div class="content">
				<div class="d-flex pb-2">
					<div class="align-self-center pe-3">
						<? 
									   $image_path = find_a_field('personnel_basic_info','PBI_PICTURE_ATT_PATH','PBI_ID="'.$PBI_ID.'"');
									   
									   if($image_path!==""){ 
							
									  ?>
						<a href="#"><img src="../../../assets/support/upload_view.php?name=<?=$image_path?>&folder=hrm_emp_pic&proj_id=<?=$cid1?>&mod=hrm_mod" alt="#" width="38" class="rounded-xl"></a>
						<? }else{?>
							
										<figure class="personal-img avatar avatar-100 rounded-5"> <img src="assets/img/user1.jpg" alt=""> </figure>
										
										<? }?>
					</div>
					<div class="align-self-center">
						<h2 class="font-700 mb-0 f-14"><span class="text-span"><b>Report</b></span>
						<h2 class="font-700 mb-0 f-12"><span class="text-span">Date: </span> <span style=" color: green;"><?=date('Y-M-d',strtotime($data->xdate))?> </span></h2>
					</div>
					<div class="align-self-center ms-auto">
					<?

 $sql2 = "select m.* from hrm_attdump m where 1 and EMP_CODE='".$user_id."' and xdate='".$data->xdate."' ".$con." order by m.sl asc";

if (!empty($sql2)) {

$query2=db_query( $sql2);


} else {
   
    echo "Error: Empty query string.";
   
}




while($data2=mysqli_fetch_object($query2)){

						?>
						<p class="m-0 p-0"><?=date('H:i:s',strtotime($data2->xtime))?></p>
						<? } ?>
					</div>
				
				</div>
			</div>
		</div>
			
			<!--card end report-->
			
			<? } ?> 
			
        </div>
    <!-- End of Page Content--> 
    
    











<?php 
 require_once '../assets/template/inc.footer.php';
 ?>