<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

include '../config/function.php';

$title='General Settings';	
$today 			  = date('Y-m-d');
$company_id   = $_SESSION['company_id'];
$menu 			  = 'Setup';
$sub_menu 		= 'settings';


if(isset($_REQUEST['update_config'])){
    
    unset($_POST['update_config']);
    $_POST['update_by']=$_SESSION['username'];
    $_POST['update_at']=date('Y-m-d H:i:s');
    
    @update('ss_config','id=1');
    
    $msg="Update Success";
    //redirect("new_shop.php");
}



?>






  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
<!--            <h1 class="m-0">General Settings</h1>
-->          </div>
<!--           <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div> -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
<?
$data = findall('select * from ss_config where id=1');
?>
<div class="row">
                <div class="col-md-9 mx-auto">
                    <div class="card card-light shadow-sm mb-4">
					<h4 align="center" class="n-form-titel1 mb-0"> <?=$title?></h4>
                        <div class="card-body bg-form-titel">
                            
                            <form class="" method="post" action="">
                                
                                <div class="row form-floating mb-2">
                                    <div class="col-md-6"><label for="select">Mobile App Running</label></div>
                                    <div class="col-md-6 mb-2">
                                    <select class="form-select form-control" name="app_status" id="app_status">
                                        <option value="<?=$data->app_status?>"><? if($data->app_status==1) echo 'Yes'; else echo 'No';?></option>
                                        <option value="1">Yes</option value="0"><option>No</option>
                                    </select>
                                    </div>
                                </div>
                                
                                <div class="row form-floating mb-2">
                                    <div class="col-md-6"><label for="city">App Status Notice</label></div>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="form-control" name="app_status_notice" id="app_status_notice"  value="<?=$data->app_status_notice?>" required>
                                    </div>    
                                </div> 
                                
                                <div class="row form-floating mb-2">
                                    <div class="col-md-6"><label for="select">Mobile User Report Status</label></div>
                                    <div class="col-md-6 mb-2">
                                    <select class="form-select form-control" name="report_status" id="report_status">
                                        <option value="<?=$data->report_status?>"><? if($data->report_status==1) echo 'Yes'; else echo 'No';?></option>
                                        <option value="1">Yes</option value="0"><option>No</option>
                                    </select>
                                    </div>
                                </div> 
                                
                                <!--<div class="row form-floating mb-3">-->
                                <!--    <div class="col-md-6"><label for="">Google Map API</label></div>-->
                                <!--    <div class="col-md-6">-->
                                <!--        <input type="text" class="form-control" name="map_api" id="map_api"  value="<?=$data->map_api?>" required>-->
                                <!--    </div>    -->
                                <!--</div>                                 -->
                                
                                <div class="row form-floating mb-1">
                                    <div class="col-md-6"><label for="select">Mobile User Geofence Lock</label></div>
                                    <div class="col-md-6 mb-2">
                                    <select class="form-select form-control" name="geo_lock" id="geo_lock">
                                        <option value="<?=$data->geo_lock?>"><? if($data->geo_lock==1) echo 'Yes'; else echo 'No';?></option>
                                        <option value="1">Yes</option value="0"><option>No</option>
                                    </select>
                                    </div>
                                </div>                                

                                <div class="row form-floating mb-1">
                                    <div class="col-md-6"><label for="city">Order Distance (Kilometer)</label></div>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="form-control" name="order_km" id="order_km"  value="<?=$data->order_km?>" required>
                                    </div>    
                                </div>
                                
                            
                            <div class="d-grid text-center">
							<input type="submit" name="update_config" class="btn1 btn1-submit-input" value="Update" align="middle"/></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>












      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 


<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>  