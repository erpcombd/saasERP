<?php 
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

// ini_set('display_errors','1');
// ini_set('display_startup_errors','1');
// error_reporting(E_ALL);

$title = "Daily Attendance";
$page = "daily_attendance.php";


require_once '../assets/template/inc.header.php';

date_default_timezone_set('Asia/Dhaka');
$title='Attendance Operation';
date("Y-m-d H:i:s");


$username	=$_SESSION['user']['username'];
$show       =findall('select username,fname from ss_user where username="'.$username.'"');
$ip = $_SERVER['REMOTE_ADDR'];


$in_info = findall("select * from ss_location_log where access_date='".date('Y-m-d')."' and user_id='".$username."' and attendance_type='IN TIME'");
$out_info = findall("select * from ss_location_log where access_date='".date('Y-m-d')."' and user_id='".$username."' and attendance_type='OUT TIME'");

$check_intime = $in_info->access_time;
$check_outtime= $out_info->access_time;

if(isset($_REQUEST['in_time'])){
    // Validate that shop_id is selected
    if($_POST['shop_id'] == '0' || empty($_POST['shop_id'])) {
        $msg2 = "Please select a shop from Route Wise Shop List";
    } else {
        $_POST['type']='Attendance';
        $_POST['attendance_type']='IN TIME';
        $_POST['shop_name']=find1("select shop_name from ss_shop where dealer_code='".$_POST['shop_id']."'");
        $_POST['shop_name_unschedule']=find1("select shop_name from ss_shop where dealer_code='".$_POST['shop_id_unschedule']."'");
        $_POST['status'] = 'APPROVED';
        $_POST['approved_status'] = 'ALLOWED';
        
        @insert('ss_location_log');
        
        $msg="Attendance In time insert successfully";
        redirect2("daily_attendance.php");
    }
}

if(isset($_REQUEST['in_time_approved'])){
    // Validate unschedule inputs
    if(empty($_POST['unschedule_route']) || empty($_POST['shop_id_unschedule']) || empty($_POST['reason_unschedule'])) {
        $msg2 = "Please complete all fields in the Un Schedule section";
    } else {
        $_POST['type']='Attendance';
        $_POST['attendance_type']='IN TIME';
        $_POST['shop_name']=find1("select shop_name from ss_shop where dealer_code='".$_POST['shop_id_unschedule']."'");
        $_POST['shop_name_unschedule']=find1("select shop_name from ss_shop where dealer_code='".$_POST['shop_id_unschedule']."'");
        $_POST['status'] = 'UNAPPROVED';
        $_POST['approved_status'] = 'PENDING';
        
        @insert('ss_location_log');
        
        $msg="Attendance In time insert successfully";
        redirect2("daily_attendance.php");
    }
}

if(isset($_REQUEST['out_time'])){
    
    $_POST['type']='Attendance';
    $_POST['attendance_type']='OUT TIME';
    $shop_info =findall("select * from ss_shop where dealer_code='".$_POST['shop_id']."'");
    $_POST['shop_name']     =$shop_info->shop_name;
    $_POST['shop_address']  =$shop_info->shop_address;
    
    $datetime1 = new DateTime($check_intime);
    $datetime2 = new DateTime($_POST['access_time']);
    
    $interval = $datetime1->diff($datetime2);
    $_POST['work_time_min'] = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;
    
    @insert('ss_location_log');
    
    $msg="Attendance Out time insert successfully";
    redirect2("daily_attendance.php");
}

?>
    
<style>
    #content {
        display: none; /* Initially hidden */
    }
    button {
        cursor: pointer;
    }
    .form-error {
        color: red;
        font-size: 14px;
        margin-top: 5px;
    }
	
</style>
<script>
    function cus_toggle(){
        var content = document.getElementById('content');
        var buttonShow = document.getElementById('button_show');
        var scheduledSection = document.getElementById('scheduled_section');
        
        if(content.style.display === "none" || content.style.display === "") {
            content.style.display = "block";
            scheduledSection.style.display = "none";
        } else {
            content.style.display = "none";
            scheduledSection.style.display = "block";
        }
    }
    
    function toggleBackToScheduled() {
        var content = document.getElementById('content');
        var scheduledSection = document.getElementById('scheduled_section');
        
        content.style.display = "none";
        scheduledSection.style.display = "block";
    }
    
    // Function to scroll to the top of the page - not using smooth scrolling for better compatibility
    function scrollToTop() {
        window.scrollTo(0, 0);
    }
</script>
    
<!-- start of Page Content-->  
<div class="page-content header-clear-medium">
   
    <div class="card card-style mb-0 ">
        <div class="content mt-0 mb-0" >
            
            <?php if(isset($msg)): ?>
            <div class="alert alert-info" role="alert">
                <?=$msg?>
            </div>
            <?php endif; ?>
            
            <?php if(isset($msg2)): ?>
            <div class="alert alert-danger" role="alert">
                <?=$msg2?>
            </div>
            <?php endif; ?>
            
            <input type="hidden" name="xtime" value="<?=date("Y-m-d H:i:s")?>">
            <input type="hidden" name="xdate" value="<?=date("Y-m-d")?>">
            
            <label for="manager_name">User Name</label>
            <input type="text" class="form-control validate-text w-100" name="fname" required="required" disabled autocomplete="off" value="<?=$show->fname?>">
            
            <!-- Scheduled Section -->
            <div id="scheduled_section">
                <form action="" method="post" id="scheduled_form">
                    <?php $route_id = getScheduleRoute()['route_id']; ?>
                    <label for="shop">Schedule Route</label>			
                    <input type="hidden" value="<?=$route_id;?>" name="schedule_route" readonly>
                    <input value="<?php echo getScheduleRoute()['route_name']; ?>" readonly>
                    
                    <div>
                        <label for="dealer_code">Route Wise Shop List</label>
                        <select name="shop_id" id="shop_id" class="w-100 rounded">
                            <option value="0">Select Shop</option>
                            <?php optionlist('select s.dealer_code,concat(s.shop_name) as shop_name 
                            from ss_shop s, ss_route r 
                            where s.route_id=r.route_id and s.status="1" and r.route_id = "'.$route_id.'" and s.emp_code="'.$_SESSION['user']['username'].'" 
                            order by r.route_id,s.shop_name'); ?>
                        </select>
                        <div class="form-error" id="shop_id_error"></div>
                    </div>
                    
                    <br>
                    
                    <input type="hidden" name="access_date" value="<?=date('Y-m-d')?>">
                    <input type="hidden" name="access_time" value="<?=date('Y-m-d H:i:s')?>">
                    <input type="hidden" name="user_id" value="<?=$username;?>">
                    <input type="hidden" name="ip" value="<?=$ip;?>">
                    <input type="hidden" name="latitude" id="latitude" value="">
                    <input type="hidden" name="longitude" id="longitude" value="">
                    
                    <div class="w-100 d-flex justify-content-center">
                        <button type="submit" class="punch btn btn-success" name="in_time" id="submit_scheduled">Submit</button>
                        <button type="button" class="no_scedule btn btn-primary" onclick="cus_toggle()">Un Schedule</button>
                    </div>
                </form>
            </div>
            
            <!-- Unscheduled Section -->
            <div id="content" class="m-0 p-0">
                <form action="" method="post" id="unschedule_form">
                    <div>
                        <label for="unschedule_route">Un Schedule Route</label>
                        <select name="unschedule_route" id="unschedule_route" onchange="FetchShopList(this.value)" class="w-100 rounded">
                            <option value="">Select Route</option>
                            <?php optionlist("select s.route_id,r.route_name from ss_route r, ss_shop s where s.route_id=r.route_id and s.emp_code='".$_SESSION['user']['username']."' group by s.route_id order by route_name"); ?>
                        </select>
                        <div class="form-error" id="unschedule_route_error"></div>
                    </div>
                    
                    <div>
                        <label for="shop_id_unschedule">Shop List</label>
                        <select name="shop_id_unschedule" id="shop_id_unschedule" class="w-100 rounded">
                            <option value="">Select Shop</option>
                            <?php if(isset($shop_id_unschedule)): ?>
                                <option value="<?=$shop_id_unschedule?>" selected><?=find1("select concat(dealer_code,'-',shop_name) from ss_shop where dealer_code='".$shop_id_unschedule."'");?></option>
                            <?php endif; ?>
                        </select>
                        <div class="form-error" id="shop_id_unschedule_error"></div>
                    </div>
                    
                    <div>
                        <label for="reason_unschedule">Reason</label>
                        <input type="text" placeholder="Add no schedule Reason" id="reason_unschedule" name="reason_unschedule" class="rounded">
                        <div class="form-error" id="reason_unschedule_error"></div>
                    </div>
                    
                    <br>
                    
                    <input type="hidden" name="access_date" value="<?=date('Y-m-d')?>">
                    <input type="hidden" name="access_time" value="<?=date('Y-m-d H:i:s')?>">
                    <input type="hidden" name="user_id" value="<?=$username;?>">
                    <input type="hidden" name="ip" value="<?=$ip;?>">
                    <input type="hidden" name="latitude" id="latitude_unschedule" value="">
                    <input type="hidden" name="longitude" id="longitude_unschedule" value="">
                    
                    <div class="w-100 d-flex justify-content-center">
                        <button type="submit" class="btn btn-danger" name="in_time_approved" id="submit_unscheduled">Send</button>
                        <button type="button" class="btn btn-primary ml-2" onclick="toggleBackToScheduled()" style="margin-left: 10px;">Back</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 
<?php 
require_once '../assets/template/inc.footer.php';
?>
 
<script>
function FetchShopList(id){
    $('#shop_id_unschedule').html('<option value="">Select Shop</option>');
    if(id) {
        $.ajax({
            type: 'post',
            url: 'get_data.php',
            data: { route_id: id },
            success: function(data){
                $('#shop_id_unschedule').html(data);
            }
        });
    }
}

function getLocation(){
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    }
}

function showPosition(position){
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    
    document.getElementById("latitude").value = latitude; 
    document.getElementById("longitude").value = longitude;
    
    // Also set for unscheduled form
    if(document.getElementById("latitude_unschedule")) {
        document.getElementById("latitude_unschedule").value = latitude;
    }
    if(document.getElementById("longitude_unschedule")) {
        document.getElementById("longitude_unschedule").value = longitude;
    }
}

document.body.onload = function(){
    getLocation();
};

// Add event listeners for form validation
document.addEventListener('DOMContentLoaded', function() {
    // Scheduled form validation
    document.getElementById('scheduled_form').addEventListener('submit', function(e) {
        var shopId = document.getElementById('shop_id').value;
        var shopIdError = document.getElementById('shop_id_error');
        
        if(shopId == '0' || shopId == '') {
            e.preventDefault();
            shopIdError.textContent = 'Please select a shop from the list';
        } else {
            shopIdError.textContent = '';
        }
    });
    
    // Unscheduled form validation
    document.getElementById('unschedule_form').addEventListener('submit', function(e) {
        var valid = true;
        
        var unscheduleRoute = document.getElementById('unschedule_route').value;
        var unscheduleRouteError = document.getElementById('unschedule_route_error');
        
        var shopIdUnschedule = document.getElementById('shop_id_unschedule').value;
        var shopIdUnscheduleError = document.getElementById('shop_id_unschedule_error');
        
        var reasonUnschedule = document.getElementById('reason_unschedule').value;
        var reasonUnscheduleError = document.getElementById('reason_unschedule_error');
        
        if(unscheduleRoute == '') {
            unscheduleRouteError.textContent = 'Please select a route';
            valid = false;
        } else {
            unscheduleRouteError.textContent = '';
        }
        
        if(shopIdUnschedule == '') {
            shopIdUnscheduleError.textContent = 'Please select a shop';
            valid = false;
        } else {
            shopIdUnscheduleError.textContent = '';
        }
        
        if(reasonUnschedule == '') {
            reasonUnscheduleError.textContent = 'Please provide a reason';
            valid = false;
        } else {
            reasonUnscheduleError.textContent = '';
        }
        
        if(!valid) {
            e.preventDefault();
        }
    });
});

// Direct implementation of auto-scroll to top for all inputs

</script>
