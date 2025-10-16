<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Employee Off Board Clearance';	


?>    <!-- Datatables -->



<style>

body {
    background: rgb(99, 39, 120)
}

.form-control:focus {
    box-shadow: none;
    border-color: #BA68C8
}

.profile-button {
    background: rgb(99, 39, 120);
    box-shadow: none;
    border: none
}

.profile-button:hover {
    background: #682773
}

.profile-button:focus {
    background: #682773;
    box-shadow: none
}

.profile-button:active {
    background: #682773;
    box-shadow: none
}

.back:hover {
    color: #682773;
    cursor: pointer
}

.labels {
    font-size: 11px
}

.add-experience:hover {
    background: #BA68C8;
    color: #fff;
    cursor: pointer;
    border: solid 1px #BA68C8
}


</style>




<style>
body{margin-top:20px;
background:#eee;
}

.white-bg {
    background-color: #ffffff;
}
.page-heading {
    border-top: 0;
    padding: 0 10px 20px 10px;
}

.forum-post-container .media {
  margin: 10px 10px 10px 10px;
  padding: 20px 10px 20px 10px;
  border-bottom: 1px solid #f1f1f1;
}
.forum-avatar {
  float: left;
  margin-right: 20px;
  text-align: center;
  width: 110px;
}
.forum-avatar .img-circle {
  height: 48px;
  width: 48px;
}
.author-info {
  color: #676a6c;
  font-size: 11px;
  margin-top: 5px;
  text-align: center;
}
.forum-post-info {
  padding: 9px 12px 6px 12px;
  background: #f9f9f9;
  border: 1px solid #f1f1f1;
}
.media-body > .media {
  background: #f9f9f9;
  border-radius: 3px;
  border: 1px solid #f1f1f1;
}
.forum-post-container .media-body .photos {
  margin: 10px 0;
}
.forum-photo {
  max-width: 140px;
  border-radius: 3px;
}
.media-body > .media .forum-avatar {
  width: 70px;
  margin-right: 10px;
}
.media-body > .media .forum-avatar .img-circle {
  height: 38px;
  width: 38px;
}
.mid-icon {
  font-size: 66px;
}
.forum-item {
  margin: 10px 0;
  padding: 10px 0 20px;
  border-bottom: 1px solid #f1f1f1;
}
.views-number {
  font-size: 24px;
  line-height: 18px;
  font-weight: 400;
}
.forum-container,
.forum-post-container {
  padding: 30px !important;
}
.forum-item small {
  color: #999;
}
.forum-item .forum-sub-title {
  color: #999;
  margin-left: 50px;
}
.forum-title {
  margin: 15px 0 15px 0;
}
.forum-info {
  text-align: center;
}
.forum-desc {
  color: #999;
}
.forum-icon {
  float: left;
  width: 30px;
  margin-right: 20px;
  text-align: center;
}
a.forum-item-title {
  color: inherit;
  display: block;
  font-size: 18px;
  font-weight: 600;
}
a.forum-item-title:hover {
  color: inherit;
}
.forum-icon .fa {
  font-size: 30px;
  margin-top: 8px;
  color: #9b9b9b;
}
.forum-item.active .fa {
  color: #1ab394;
}
.forum-item.active a.forum-item-title {
  color: #1ab394;
}
@media (max-width: 992px) {
  .forum-info {
    margin: 15px 0 10px 0;
    /* Comment this is you want to show forum info in small devices */
    display: none;
  }
  .forum-desc {
    float: none !important;
  }
}





.ibox {
  clear: both;
  margin-bottom: 25px;
  margin-top: 0;
  padding: 0;
}
.ibox.collapsed .ibox-content {
  display: none;
}
.ibox.collapsed .fa.fa-chevron-up:before {
  content: "\f078";
}
.ibox.collapsed .fa.fa-chevron-down:before {
  content: "\f077";
}
.ibox:after,
.ibox:before {
  display: table;
}
.ibox-title {
  -moz-border-bottom-colors: none;
  -moz-border-left-colors: none;
  -moz-border-right-colors: none;
  -moz-border-top-colors: none;
  background-color: #ffffff;
  border-color: #e7eaec;
  border-image: none;
  border-style: solid solid none;
  border-width: 3px 0 0;
  color: inherit;
  margin-bottom: 0;
  padding: 14px 15px 7px;
  min-height: 48px;
}
.ibox-content {
  background-color: #ffffff;
  color: inherit;
  padding: 15px 20px 20px 20px;
  border-color: #e7eaec;
  border-image: none;
  border-style: solid solid none;
  border-width: 1px 0;
}
.ibox-footer {
  color: inherit;
  border-top: 1px solid #e7eaec;
  font-size: 90%;
  background: #ffffff;
  padding: 10px 15px;
}

.message-input {
    height: 90px !important;
}
.form-control, .single-line {
    background-color: #FFFFFF;
    background-image: none;
    border: 1px solid #e5e6e7;
    border-radius: 1px;
    color: inherit;
    display: block;
    padding: 6px 12px;
    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    width: 100%;
    font-size: 14px;
}
.text-navy {
    color: #1ab394;
}
.mid-icon {
    font-size: 66px !important;
}
.m-b-sm {
    margin-bottom: 10px;
}

</style>



<?  

$clearance = find_all_field('hrm_off_board','','PF_STATUS_ID="'.$_GET['asign_id'].'"');


$basic = find_all_field('personnel_basic_info','','PBI_ID="'.$clearance->PBI_ID.'"');

 $module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);

if(isset($_POST['offboard'])){

 $update = "UPDATE hrm_off_board SET off_board_status='Not In Service',activity_date='".$_POST['activity_date']."' WHERE PF_STATUS_ID='".$_GET['asign_id']."'";
$query=db_query($update);

 $updateb = "UPDATE personnel_basic_info SET PBI_JOB_STATUS='Not In Service' WHERE PBI_ID='".$clearance->PBI_ID."'";
 $query=db_query($updateb);


header("Location:employee_offboard_information.php");
exit;

}


?>



<div class="container rounded bg-white ">
    <div class="row pt-4 pb-4" style=" background-color: whitesmoke;">
        
		<div class="col-md-2 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
			<img class="rounded-circle mt-5" src="../../../assets/support/upload_view.php?name=<?=$basic->PBI_PICTURE_ATT_PATH?>&folder=hrm_emp_pic&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" alt="#" style=" height: 90px; width: 100px;">
			<span class="font-weight-bold"><?=$basic->PBI_NAME?></span>
			</div>
        </div>

		
        <div class="col-md-8 border-right">
		
            <div class="forum-item active" style="background-color: #ffff;">
                    <div class="row m-0">
                        <div class="col-md-9">
                            <div class="forum-icon">
                                <i class="fa fa-bolt"></i>
                            </div>
                            <a href="" class="forum-item-title">Accounts</a>
                            <div class="forum-sub-title">Loan, advances, joining expenses, notice pay reimbursement, travel advance. </div>
                        </div>
                        <div class="col-md-1 forum-info">
                            <span class="views-number">Clearance</span>
                            <div>
                                <small><?=$clearance->Accounts?></small>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
				
				
				
				<div class="forum-item active" style="background-color: #ffff;">
                    <div class="row m-0">
                        <div class="col-md-9">
                            <div class="forum-icon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <a href="" class="forum-item-title">HR & Administration</a>
                            <div class="forum-sub-title">Mobile bill, sim card, credit card, health insurance card, key.</div>
                        </div>
                        <div class="col-md-1 forum-info">
                            <span class="views-number">
                               Clearance
                            </span>
                            <div>
                                <small><?=$clearance->HR_Administration?></small>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
				
				
				
				<div class="forum-item active" style="background-color: #ffff;">
                    <div class="row m-0">
                        <div class="col-md-9">
                            <div class="forum-icon">
                                <i class="fa fa-star"></i>
                            </div>
                            <a href="" class="forum-item-title">Information Technology</a>
                            <div class="forum-sub-title">Pc, laptop, printers, email id, SAP id, data drive, other it peripherals etc.</div>
                        </div>
                        <div class="col-md-1 forum-info">
                            <span class="views-number"> Clearance </span>
                            <div>
                                <small><i class="fa fa-check" aria-hidden="true"></i> <?=$clearance->IT?> </small>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
				
				
				
				
				<div class="forum-item active" style="background-color: #ffff;">
                    <div class="row m-0">
                        <div class="col-md-9">
                            <div class="forum-icon">
                                <i class="fa fa-home"></i>
                            </div>
                            <a href="" class="forum-item-title">HR & Administration (Plant)</a>
                            <div class="forum-sub-title">Id card, company accommodation, electricity bill.</div>
                        </div>
                        <div class="col-md-1 forum-info">
                            <span class="views-number">Clearance</span>
                            <div>
                                <small><i class="fa fa-check" aria-hidden="true" style="color:#FF0000"></i> 
								<? if($clearance->HR_Administration_plant>0) {echo $clearance->HR_Administration_plant;}else{ echo "NO";} ?>  </small>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
				
				
				
				<div class="forum-item active" style="background-color: #ffff;">
                    <div class="row m-0">
                        <div class="col-md-9">
                            <div class="forum-icon">
                                <i class="fa fa-bus"></i>
                            </div>
                            <a href="" class="forum-item-title">Project</a>
                            <div class="forum-sub-title">All assigned projects.</div>
                        </div>
                        <div class="col-md-1 forum-info">
                            <span class="views-number">Clearance</span>
                            <div>
                                <small><i class="fa fa-check" aria-hidden="true" style="color:#FF0000"></i> <?=$clearance->project_Clearance?>  </small>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
				
				<div class="forum-item active">
                    <div class="n-form-btn-class" align="center">
                           <input type="date" name="activity_date" class="form-control" id="dateField" />
                    </div>
                </div>
				
				
				
				
				
        </div>
		
		
	    <div class="col-md-2 border-right forum-item active">	
			<div class="forum-sub-title m-0 pl-1"> <h1 style="color:#DC3545"><u> <i class="fa fa-check"></i> Received Asset List</h1></u> </div>
			  <ul style=" padding: 0px; padding-left: 25px; ">
			  <? 
			   $sql = 'select b.item_name,a.item_in
				from product_asign a, item_info b
				where a.product=b.item_id AND a.tr_from="receive" and a.emp_id="'.$clearance->PBI_ID.'"';
				
				$query13 = db_query($sql);
				while($data = mysqli_fetch_object($query13)){

                   ?>
				<li class="forum-item-title"><?=$data->item_name?> (<?=round($data->item_in)?>)</li>
				
				<?  }  ?>
			
			  </ul>
		</div>
		 
			
		
		
		
		 <form method="post" class="container" enctype="multipart/form-data">
		
		<div class="n-form-btn-class">
        <!--            button code hear-->
		<a class="btn btn-primary" href="javascript:history.back()">Back</a>
        <button type="submit" name="offboard" class="btn btn-danger">Proceed</button>

      </div>
	  
	          	
		
        </form>
		
		
		
		
    </div>
</div>
</div>
</div>






<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
