<?php 
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$att_id = $_GET['id'];

$title = "Daily Attendance Approved";
$page = "daily_attendance_approved.php";


require_once '../assets/template/inc.header.php';

date_default_timezone_set('Asia/Dhaka');
$title='Attendance Operation';
date("Y-m-d H:i:s");

$table_update ='ss_location_log';
$username	=$_SESSION['user']['username'];
$show       =findall('select username,fname from ss_user where username="'.$username.'"');
$ip = $_SERVER['REMOTE_ADDR'];

$att_info = findall("select * from ss_location_log where id='".$att_id."'");

$unique_master='id';

if(isset($_POST['update_deny'])){
		$_POST['approved_by'] =$_SESSION['user']['username'];
		$_POST['status'] = 'APPROVED';
		$_POST['approved_status'] = 'DENY';
		
		$crud = new crud($table_update);
		$crud->update($unique_master);

		$msg='Approved is successfully Deny';
        redirect2("daily_attendance_status.php");
}

if(isset($_POST['update_allowed'])){
		$_POST['approved_by'] =$_SESSION['user']['username'];
		$_POST['status'] = 'APPROVED';
		$_POST['approved_status'] = 'ALLOWED';
		
		$crud = new crud($table_update);
		$crud->update($unique_master);

		$msg='Approved is successfully Allowed';
        redirect2("daily_attendance_status.php");
}


if(isset($_REQUEST['in_time'])){

    $_POST['type']='Attendance';
    $_POST['attendance_type']='IN TIME';
    $_POST['shop_name']=find1("select shop_name from ss_shop where dealer_code='".$_POST['shop_id']."'");
    $_POST['shop_name_unschedule']=find1("select shop_name from ss_shop where dealer_code='".$_POST['shop_id_unschedule']."'");
    $_POST['status'] = 'UNAPPROVED';
    
    @insert('ss_location_log');
    
    $msg="Attendance In time insert successfully";
    redirect2("daily_attendance_status.php");
}


?>
    
    <style>
        button {
            cursor: pointer;
        }
    </style>
    
    

    
<!-- start of Page Content-->  
   <div class="page-content header-clear-medium">
   
        <div class="card card-style mb-0">
		<form action="" enctype="multipart/form-data" method="post" name="" id="demo" >
		<div class="content mt-0 mb-0">
			
		    <? if(isset($msg)) { ?>

            <div class="alert alert-info" role="alert">
            
            <?=$msg?>

        </div>

        <? } ?>

		
		<? if(isset($msg2)) { ?>

        <div class="alert alert-danger" role="alert">

          <?=$msg2?>

        </div>

        <? } ?>
		<input type="hidden" name="id" value="<?=$att_id;?>">
					
    		<label for="manager_name">User Name</label>
    		<input type="text" class="form-control validate-text w-100" readonly autocomplete="off" value="<?=find1("select fname from ss_user where username='".$att_info->user_id."'");?>">
    		
		    <? $route_id = getScheduleRoute()['route_id']; ?>
			<label for="shop">Schedule Route</label>			
                <input type="text" class="form-control validate-text w-100" value="<?=find1("select route_name from ss_route where route_id='".$att_info->schedule_route."'");?>" readonly autocomplete="off" />
			<div>
		    <label for="dealer_code">Route Wise Shop List</label>
                <input type="text" class="form-control validate-text w-100" value="<?=$att_info->shop_name_unschedule;?>" readonly autocomplete="off" />
			</div>
			
			<br> <hr class="dotted"> <br>
	
            <label for="dealer_code">Un Schedule Route</label>
                <input type="text" class="form-control validate-text w-100" value="<?=find1("select route_name from ss_route where route_id='".$att_info->unschedule_route."'");?>" readonly autocomplete="off" /> 

            <label for="dealer_code">Un Route Wise Shop List</label>
                <input type="text" class="form-control validate-text w-100" value="<?=$att_info->shop_name_unschedule;?>" readonly autocomplete="off" />
                

            <label for="dealer_code" > Reason </label>
                <input type="text" class="form-control validate-text w-100" value="<?=$att_info->reason_unschedule;?>" readonly autocomplete="off" />
            </div>
            
            <br>
						
            
            <div class="w-100 d-flex justify-content-center" id="button_show">
            <button type="submit" class="punch btn btn-danger" name="update_deny" >Deny</button>
            <button type="submit" class="no_scedule btn btn-primary" name="update_allowed" >Allowed</button>
            </div>

	    	</div>
			</div>
				
			</form>
            </div>
			
			
        </div>
    <!-- End of Page Content--> 

<?php 
 require_once '../assets/template/inc.footer.php';
?>
