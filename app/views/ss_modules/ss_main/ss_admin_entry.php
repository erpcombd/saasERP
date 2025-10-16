<?php

require_once "../../../controllers/routing/layout.top.php";
$current_page = "events";
$title='eProcurement Entry';
do_calander("#f_date");
do_calander("#t_date");
do_datatable('rfq_table');
unset($_SESSION['rfq_no']);
unset($_SESSION['rfq_version']);
unset($_SESSION['master_status']);
?>
<? include_once 'ep_menu.php'; ?>
    <script type="text/javascript" src="../../../../public/assets/js/bootstrap.min.js"></script>	
	<script type="text/javascript" src="../../../../public/assets/js/jquery-3.4.1.min.js"></script>

<style>
.nav-tabs .nav-item .nav-link, .nav-tabs .nav-item .nav-link:hover, .nav-tabs .nav-item .nav-link:focus {
    border: 0 !important;
    color: #007bff !important;
    font-weight: 500;
}
.sidebar, .sidemenu{
	display:none;
    width: 0% !important;
}

.main_content{
	width: 100% !important;
}

.tab-content>.active {
    display: block;
    border: 1px solid #f5f5f5;
	background-color: #fbfbfb9e;
}

.nav-tabs .nav-item .nav-link.active{
    border: 1px solid #e1e1e1 !important;
    border-radius: 5px 5px 0px 0px;
    border-bottom: 1px solid #f8f8ff !important;
}
.nav-tabs .nav-item .nav-link:hover{
    border: 1px solid #e1e1e1 !important;
    border-radius: 5px 5px 0px 0px;
    border-bottom: 1px solid #f8f8ff !important;
}
.d-flex-bg-color{
background-color:#333 !important;
}
.ep-bg-color{
	background-color:#f5f5f5 !important;
}
.btn1-bg-submit{
	margin:10px !important;
	background-color:#FFFFFF !important;
	color:#333 !important;
	font-weight:bold !important;	
}
.alerts-bg{
	background-color:#f0f0f0;
	padding:10px;
}
.bg-alerts-bg{
background-color:#FFFFFF !important;
}
.alerts-table{
	height:300px !important;
}
.sourcing-table{
	width:100%;
}

.sourcing-table tr:nth-child(odd), .sourcing-table tr:nth-child(even)  {
    background-color: #fff !important;
    color: #333!important;
	text-align:left;
}
.tab-pane{
height:292px;
background-color:#fff !important;
}
.nav-tabs {
    border-bottom: 1px solid #d9d9d9;
    background-color: #fffefe;
}

.individual-officer-card{
	box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
	position: relative;

	padding: 15px;
    margin: 10px;
	width:270px;
    height: 210px;
	border-radius: 6px;
	cursor: pointer;
	overflow: hidden;
	
}


.mother-container{
	margin:1rem 4rem 1rem 4rem;
}

.profile-pic{
	height:100px;
	width: 100px;
	border-radius: 50%;
	
}
.mother-container-sales-officers{
	
    display: flex;
    flex-wrap: wrap;

   

}
.individual-officer-card-inner{

}
.custom-svg {
  position: absolute;
  top: -20px;
  left: -53px;
  width: 100%; /* Make the SVG responsive */
  height: auto;
  transform: scale(2);
}
.custom-svg-reverse {
  position: absolute;
  top: -20px;
  left: -53px;
  width: 100%; /* Make the SVG responsive */
  height: auto;
  transform: scale(2);
}

</style>


<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<h1 class="container" style="font-family: 'Poppins', sans-serif; font-weight: 500; font-style: normal; font-size: 46px !important;" >Sales Officers <?=$_SESSION['msg'];unset($_SESSION['msg']);?></h1>

<div class="mother-container">
	<div class="mother-container-sales-officers">
		<?
		$sql="select * from ssn_user";
		$qry = db_query($sql);
		while($user=mysqli_fetch_object($qry)){
		?>
		<div class="individual-officer-card ">
		<svg class="custom-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 550 350">
			<path fill="#e3ffd7" fill-opacity="1" d="M 425 101 L 150 100 L 150 350 Q 231 357 250 300 Q 263 266 293 257 Q 358 244 361 184 C 367.5 143 417.5 143 424 102"></path>
		</svg>
			<div class="individual-officer-card-inner row">
			<div class="col-5">
			<img alt="" class=" profile-pic" id="logoshowbasicsourcing" src="../../controllers/
	utilities/upload_attachment_show.php?name=fahim.png&folder=profile_pics" />	
			</div>

	         <div class="col-7">
			  
			    <span style="white-space: nowrap !important; font-family: 'Poppins', sans-serif; font-weight: 500; font-style: normal; font-size: 14px !important; "><?=$user->fname?></span><br>
				<span style="white-space: nowrap !important; font-family: 'Poppins', sans-serif; font-weight: 500; font-style: normal; font-size: 12px !important;">Region: <?=find_a_field('ssn_branch','BRANCH_NAME','BRANCH_ID="'.$user->region_id.'"');?></span><br>
				<span style="white-space: nowrap !important; font-family: 'Poppins', sans-serif; font-weight: 500; font-style: normal; font-size: 12px !important;">Zone: <?=find_a_field('ssn_zone','ZONE_NAME','ZONE_CODE="'.$user->zone_id.'"');?></span><br>
				<span style=" font-family: 'Poppins', sans-serif; font-weight: 500; font-style: normal; font-size: 12px !important;">Area: <?=find_a_field('ssn_area','AREA_NAME','AREA_CODE="'.$user->area_id.'"');?></span><br>

			   
			 </div>
			</div>
	
		</div>
       <?}?>
	</div>
</div>
<?
require_once "../../../controllers/routing/layout.bottom.php";
?>