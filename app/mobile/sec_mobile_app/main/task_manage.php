<? 

session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$cid = $_SESSION['proj_id'];
?>



<?php

   

//session_start();

//include 'config/db.php';

//include '../config/function.php';
include '../config/access.php';

$user_id	=$_SESSION['user_id'];



$page="home";






?>



<?php 
include_once('../template/header.php'); 

?>


<? 


//echo $u_id= $_SESSION['user_id']; //$_SESSION['user']['id'];
 $u_id  =  $_SESSION['user']['id'];

$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);

$currentMonth = date("m");
$currentYear = date("Y");

$attedance = find_all_field('hrm_attendence_final','','PBI_ID="'.$PBI_ID.'" and mon="'.$currentMonth.'" and year="'.$currentYear.'"');

$basic = find_all_field('personnel_basic_info','','PBI_ID="'.$PBI_ID.'"');

?>


	<div class="page-content header-clear-medium">

		<!--
			How to find your preferred action sheet fast and easy in this large page:

			For example, if you want to use the data-menu="menu-call" actionsheet please use CTRL+F or CMD+F
			and search for id="menu-call". This is the easiest way to locate your preferred action sheet.
		-->




		
		
		    <div class="card card-style">
			<div class="content mb-0">
				<h3>Your Tasks</h3>
				<p class="font-11 mt-n2 mb-0 opacity-50">7/10 Tasks Completed</p>
				<div class="divider mt-3 mb-3"></div>
				<a href="#" class="d-flex pb-3 mb-2">
					<i class="align-self-center fa-fw font-12 line-height-xs">🏠</i>
					<h5 class="align-self-center ps-2 ms-2 mb-0 font-15 font-600 line-height-xs">Home</h5>
					<span class="align-self-center badge bg-gray-light color-black opacity-50 ms-auto font-10 font-500">10</a>
				</a>
				<a href="#" class="d-flex pb-3 mb-2">
					<i class="align-self-center fa-fw font-12 line-height-xs">📅</i>
					<h5 class="align-self-center ps-2 ms-2 mb-0 font-15 font-600 line-height-xs">Today</h5>
					<span class="align-self-center badge bg-gray-light color-black opacity-50 ms-auto font-10 font-500">8</a>
				</a>
				<a href="#" class="d-flex pb-3 mb-2">
					<i class="align-self-center fa-fw font-12 line-height-xs">💼</i>
					<h5 class="align-self-center ps-2 ms-2 mb-0 font-15 font-600 line-height-xs">Business</h5>
					<span class="align-self-center badge bg-gray-light color-black opacity-50 ms-auto font-10 font-500">28</a>
				</a>
				<a href="#" class="d-flex pb-3 mb-2">
					<i class="align-self-center fa-fw font-12 line-height-xs">😃</i>
					<h5 class="align-self-center ps-2 ms-2 mb-0 font-15 font-600 line-height-xs">Personal</h5>
					<span class="align-self-center badge bg-gray-light color-black opacity-50 ms-auto font-10 font-500">4</a>
				</a>
				<a href="#" class="d-flex pb-2 mb-2">
					<i class="align-self-center fa-fw font-12 line-height-xs">🚗</i>
					<h5 class="align-self-center ps-2 ms-2 mb-0 font-15 font-600 line-height-xs">Road Trip</h5>
					<span class="align-self-center badge bg-gray-light color-black opacity-50 ms-auto font-10 font-500">18</a>
				</a>
				<div class="divider mb-3"></div>
				<a href="#" class="d-flex pb-3 mb-2">
					<i class="align-self-center fa-fw fa fa-check color-theme opacity-50 font-12"></i>
					<h5 class="align-self-center ps-2 ms-2 mb-0 font-15 font-600 line-height-xs">Complete</h5>
					<span class="align-self-center badge bg-gray-light color-black opacity-50 ms-auto font-10 font-500">43</a>
				</a>
			</div>
		</div>
		
		
		
		
		
		<div class="card card-style">
			<div class="content mb-0" id="tab-group-1">
				<div class="tab-controls tabs-medium tabs-rounded" data-highlight="bg-highlight">
					<a href="#" class="font-600" data-active data-bs-toggle="collapse" data-bs-target="#tab-1">Action Sheets</a>
					<a href="#" class="font-600" data-bs-toggle="collapse" data-bs-target="#tab-2">Action Modals</a>
				</div>
				<div class="clearfix mb-3"></div>
				<div data-bs-parent="#tab-group-1" class="collapse show" id="tab-1">
					<div class="list-group list-custom-small icon-0">
						<a href="#" data-menu="menu-upload"><i class="fa fa-list color-blue-dark"></i><span>Upload Attachement</span><i class="fa fa-angle-right"></i></a>
						<a href="#" data-menu="menu-manage"><i class="fa fa-cog color-red-dark"></i><span>Project Management</span><i class="fa fa-angle-right"></i></a>
						<a href="#" data-menu="menu-team"><i class="fa fa-user color-blue-dark"></i><span>Manage Team</span><i class="fa fa-angle-right"></i></a>
						<a href="#" data-menu="menu-member"><i class="fa fa-lock color-brown-dark"></i><span>Member Permissions</span><i class="fa fa-angle-right"></i></a>
						<a href="#" data-menu="menu-dates"><i class="fa fa-calendar color-green-dark"></i><span>Project Deadlines </span><i class="fa fa-angle-right"></i></a>
					</div>
				</div>
				<div data-bs-parent="#tab-group-1" class="collapse" id="tab-2">
					<div class="list-group list-custom-small icon-0">
						<a href="#" data-menu="menu-modal-upload"><i class="fa fa-list color-blue-dark"></i><span>Upload Attachement</span><i class="fa fa-angle-right"></i></a>
						<a href="#" data-menu="menu-modal-manage"><i class="fa fa-cog color-red-dark"></i><span>Project Management</span><i class="fa fa-angle-right"></i></a>
						<a href="#" data-menu="menu-modal-team"><i class="fa fa-user color-blue-dark"></i><span>Manage Team</span><i class="fa fa-angle-right"></i></a>
						<a href="#" data-menu="menu-modal-member"><i class="fa fa-lock color-brown-dark"></i><span>Member Permissions</span><i class="fa fa-angle-right"></i></a>
						<a href="#" data-menu="menu-modal-dates"><i class="fa fa-calendar color-green-dark"></i><span>Project Deadlines </span><i class="fa fa-angle-right"></i></a>
					</div>
				</div>
			</div>
		</div>

		<a href="actions-list.html" class="btn btn-m rounded-sm btn-full btn-margins bg-highlight font-700 text-uppercase">View More Action Sheets and Modals</a>

		<div class="footer card card-style">
			<a href="#" class="footer-title"><span class="color-highlight">StickyMobile</span></a>
			<p class="footer-text"><span>Made with <i class="fa fa-heart color-highlight font-16 ps-2 pe-2"></i> by Enabled</span><br><br>Powered by the best Mobile Website Developer on Envato Market. Elite Quality. Elite Products.</p>
			<div class="text-center mb-3">
				<a href="#" class="icon icon-xs rounded-sm shadow-l me-1 bg-facebook"><i class="fab fa-facebook-f"></i></a>
				<a href="#" class="icon icon-xs rounded-sm shadow-l me-1 bg-twitter"><i class="fab fa-twitter"></i></a>
				<a href="#" class="icon icon-xs rounded-sm shadow-l me-1 bg-phone"><i class="fa fa-phone"></i></a>
				<a href="#" data-menu="menu-share" class="icon icon-xs rounded-sm me-1 shadow-l bg-red-dark"><i class="fa fa-share-alt"></i></a>
				<a href="#" class="back-to-top icon icon-xs rounded-sm shadow-l bg-dark-light"><i class="fa fa-angle-up"></i></a>
			</div>
			<p class="footer-copyright">Copyright &copy; Enabled <span id="copyright-year">2017</span>. All Rights Reserved.</p>
			<p class="footer-links"><a href="#" class="color-highlight">Privacy Policy</a> | <a href="#" class="color-highlight">Terms and Conditions</a> | <a href="#" class="back-to-top color-highlight"> Back to Top</a></p>
			<div class="clear"></div>
		</div>

	</div>

	<!-- Menu Upload-->
	<div id="menu-upload"
		 class="menu menu-box-bottom menu-box-detached">
		<div class="list-group list-custom-small ps-2 me-4">
			<a href="#">
				<i class="font-14 fa fa-file color-gray-dark"></i>
				<span class="font-13">File</span>
				<i class="fa fa-angle-right"></i>
			</a>
			<a href="#">
				<i class="font-14 fa fa-image color-gray-dark"></i>
				<span class="font-13">Photo</span>
				<i class="fa fa-angle-right"></i>
			</a>
			<a href="#">
				<i class="font-14 fa fa-video color-gray-dark"></i>
				<span class="font-13">Video</span>
				<i class="fa fa-angle-right"></i>
			</a>
			<a href="#">
				<i class="font-14 fa fa-user color-gray-dark"></i>
				<span class="font-13">Camera</span>
				<i class="fa fa-angle-right"></i>
			</a>
			<a href="#">
				<i class="font-14 fa fa-map-marker color-gray-dark"></i>
				<span class="font-13">Location</span>
				<i class="fa fa-angle-right"></i>
			</a>
		</div>
	</div>

	<!-- Menu Upload-->
	<div id="menu-modal-upload"
		 class="menu menu-box-modal menu-box-detached">
		<div class="list-group list-custom-small ps-2 me-4">
			<a href="#">
				<i class="font-14 fa fa-file color-gray-dark"></i>
				<span class="font-13">File</span>
				<i class="fa fa-angle-right"></i>
			</a>
			<a href="#">
				<i class="font-14 fa fa-image color-gray-dark"></i>
				<span class="font-13">Photo</span>
				<i class="fa fa-angle-right"></i>
			</a>
			<a href="#">
				<i class="font-14 fa fa-video color-gray-dark"></i>
				<span class="font-13">Video</span>
				<i class="fa fa-angle-right"></i>
			</a>
			<a href="#">
				<i class="font-14 fa fa-user color-gray-dark"></i>
				<span class="font-13">Camera</span>
				<i class="fa fa-angle-right"></i>
			</a>
			<a href="#">
				<i class="font-14 fa fa-map-marker color-gray-dark"></i>
				<span class="font-13">Location</span>
				<i class="fa fa-angle-right"></i>
			</a>
		</div>
	</div>


	<!-- Menu Manage-->
	<div id="menu-manage" class="menu menu-box-bottom menu-box-detached">
		<div class="menu-title"><h1>Manage Project </h1><p class="color-theme opacity-40">Manage your Project Details</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
		<div class="divider divider-margins mb-n2"></div>
		<div class="content mt-2">
			<div class="list-group list-custom-large">
				<a href="#" data-menu="menu-team">
					<i class="fa font-14 fa-user bg-green-dark rounded-s"></i>
					<span>Team</span>
					<strong>Assign Members</strong>
					<i class="fa fa-angle-right"></i>
				</a>
				<a href="#" data-menu="menu-dates" class="border-0">
					<i class="fa font-14 fa-cog bg-blue-dark rounded-s"></i>
					<span>Dates</span>
					<strong>Project Timeframe</strong>
					<i class="fa fa-angle-right"></i>
				</a>
			</div>
		</div>
	</div>

	<!-- Menu Manage-->
	<div id="menu-modal-manage" class="menu menu-box-modal menu-box-detached">
		<div class="menu-title"><h1>Manage Project </h1><p class="color-theme opacity-40">Manage your Project Details</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
		<div class="divider divider-margins mb-n2"></div>
		<div class="content mt-2">
			<div class="list-group list-custom-large">
				<a href="#" data-menu="menu-modal-team">
					<i class="fa font-14 fa-user bg-green-dark rounded-s"></i>
					<span>Team</span>
					<strong>Assign Members</strong>
					<i class="fa fa-angle-right"></i>
				</a>
				<a href="#" data-menu="menu-modal-dates" class="border-0">
					<i class="fa font-14 fa-cog bg-blue-dark rounded-s"></i>
					<span>Dates</span>
					<strong>Project Timeframe</strong>
					<i class="fa fa-angle-right"></i>
				</a>
			</div>
		</div>
	</div>

	<!-- Menu Team-->
	<div id="menu-team" class="menu menu-box-bottom menu-box-detached">
		<div class="menu-title"><h1>Manage Team </h1><p class="color-theme opacity-40">Manage your Project Details</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
		<div class="divider divider-margins mb-n2"></div>
		<div class="content mt-2">
			<div class="list-group list-custom-small">
				<a href="#" data-menu="menu-member">
					<img src="images/pictures/faces/1small.png" width="35" class="rounded-sm me-2">
					<span>John Doe</span>
					<strong class="badge bg-green-dark">YOU</strong>
					<i class="fa fa-angle-right"></i>
				</a>
				<a href="#" data-menu="menu-member">
					<img src="images/pictures/faces/2small.png" width="35" class="rounded-sm me-2">
					<span>James Bond</span>
					<strong class="badge bg-yellow-dark">FRONT END</strong>
					<i class="fa fa-angle-right"></i>
				</a>
				<a href="#" data-menu="menu-member">
					<img src="images/pictures/faces/4small.png" width="35" class="rounded-sm me-2">
					<span>Jack Sir</span>
					<strong class="badge bg-blue-dark">GRAPHIC DESIGN</strong>
					<i class="fa fa-angle-right"></i>
				</a>
				<a href="#" data-menu="menu-member">
					<img src="images/pictures/faces/3small.png" width="35" class="rounded-sm me-2">
					<span>Jack Son</span>
					<strong class="badge bg-red-dark">SERVER LANGUAGE</strong>
					<i class="fa fa-angle-right"></i>
				</a>
			</div>
			<a href="#" data-menu="menu-manage" class="btn btn-full btn-m rounded-sm bg-highlight shadow-xl text-uppercase font-900 mt-3 mb-3">Back to Settings</a>
		</div>
	</div>

	<!-- Menu Team-->
	<div id="menu-modal-team" class="menu menu-box-modal menu-box-detached">
		<div class="menu-title"><h1>Manage Team </h1><p class="color-theme opacity-40">Manage your Project Details</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
		<div class="divider divider-margins mb-n2"></div>
		<div class="content mt-2">
			<div class="list-group list-custom-small">
				<a href="#" data-menu="menu-modal-member">
					<img src="images/pictures/faces/1small.png" width="35" class="rounded-sm me-2">
					<span>John Doe</span>
					<strong class="badge bg-green-dark">YOU</strong>
					<i class="fa fa-angle-right"></i>
				</a>
				<a href="#" data-menu="menu-modal-member">
					<img src="images/pictures/faces/2small.png" width="35" class="rounded-sm me-2">
					<span>James Bond</span>
					<strong class="badge bg-yellow-dark">FRONT END</strong>
					<i class="fa fa-angle-right"></i>
				</a>
				<a href="#" data-menu="menu-modal-member">
					<img src="images/pictures/faces/4small.png" width="35" class="rounded-sm me-2">
					<span>Jack Sir</span>
					<strong class="badge bg-blue-dark">GRAPHIC DESIGN</strong>
					<i class="fa fa-angle-right"></i>
				</a>
				<a href="#" data-menu="menu-modal-member">
					<img src="images/pictures/faces/3small.png" width="35" class="rounded-sm me-2">
					<span>Jack Son</span>
					<strong class="badge bg-red-dark">SERVER LANGUAGE</strong>
					<i class="fa fa-angle-right"></i>
				</a>
			</div>
			<a href="#" data-menu="menu-modal-manage" class="btn btn-full btn-m rounded-sm bg-highlight shadow-xl text-uppercase font-900 mt-3 mb-3">Back to Settings</a>
		</div>
	</div>

	<!-- Menu Team Member-->
	<div id="menu-member" class="menu menu-box-bottom menu-box-detached">
		<div class="menu-title"><h1>John Doe </h1><p class="color-theme opacity-40">Manage Permissions</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
		<div class="divider divider-margins mb-n2"></div>
		<div class="content mt-2">
			<div class="list-group list-custom-small">
				<a href="#" data-trigger-switch="switch-1">
					<i class="fa fa-upload bg-gray-dark rounded-sm ms-0"></i>
					<span>Upload Files</span>
					<div class="custom-control small-switch ios-switch">
						<input type="checkbox" class="ios-input" id="switch-1" checked>
						<label class="custom-control-label" for="switch-1"></label>
					</div>
				</a>
				<a href="#" data-trigger-switch="switch-2">
					<i class="fa fa-download bg-blue-dark rounded-sm ms-0"></i>
					<span>Download Files</span>
					<div class="custom-control small-switch ios-switch">
						<input type="checkbox" class="ios-input" id="switch-2" checked>
						<label class="custom-control-label" for="switch-2"></label>
					</div>
				</a>
				<a href="#" data-trigger-switch="switch-3">
					<i class="fa fa-check bg-green-dark rounded-sm ms-0"></i>
					<span>Complete Task</span>
					<div class="custom-control small-switch ios-switch">
						<input type="checkbox" class="ios-input" id="switch-3">
						<label class="custom-control-label" for="switch-3"></label>
					</div>
				</a>
				<a href="#" data-trigger-switch="switch-4">
					<i class="fa fa-plus bg-brown-dark rounded-sm ms-0"></i>
					<span>Add New Members</span>
					<div class="custom-control small-switch ios-switch">
						<input type="checkbox" class="ios-input" id="switch-4">
						<label class="custom-control-label" for="switch-4"></label>
					</div>
				</a>
			</div>
			<a href="#" data-menu="menu-team" class="btn btn-full btn-m rounded-sm bg-highlight shadow-xl text-uppercase font-900 mt-3 mb-3">Back to Members</a>
		</div>
	</div>

	<!-- Menu Team Member-->
	<div id="menu-modal-member" class="menu menu-box-modal menu-box-detached">
		<div class="menu-title"><h1>John Doe </h1><p class="color-theme opacity-40">Manage Permissions</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
		<div class="divider divider-margins mb-n2"></div>
		<div class="content mt-2">
			<div class="list-group list-custom-small">
				<a href="#" data-trigger-switch="switch-1a">
					<i class="fa fa-upload bg-gray-dark rounded-sm ms-0"></i>
					<span>Upload Files</span>
					<div class="custom-control small-switch ios-switch">
						<input type="checkbox" class="ios-input" id="switch-1a" checked>
						<label class="custom-control-label" for="switch-1a"></label>
					</div>
				</a>
				<a href="#" data-trigger-switch="switch-2a">
					<i class="fa fa-download bg-blue-dark rounded-sm ms-0"></i>
					<span>Download Files</span>
					<div class="custom-control small-switch ios-switch">
						<input type="checkbox" class="ios-input" id="switch-2a" checked>
						<label class="custom-control-label" for="switch-2a"></label>
					</div>
				</a>
				<a href="#" data-trigger-switch="switch-3a">
					<i class="fa fa-check bg-green-dark rounded-sm ms-0"></i>
					<span>Complete Task</span>
					<div class="custom-control small-switch ios-switch">
						<input type="checkbox" class="ios-input" id="switch-3a">
						<label class="custom-control-label" for="switch-3a"></label>
					</div>
				</a>
				<a href="#" data-trigger-switch="switch-4a">
					<i class="fa fa-plus bg-brown-dark rounded-sm ms-0"></i>
					<span>Add New Members</span>
					<div class="custom-control small-switch ios-switch">
						<input type="checkbox" class="ios-input" id="switch-4a">
						<label class="custom-control-label" for="switch-4a"></label>
					</div>
				</a>
			</div>
			<a href="#" data-menu="menu-modal-team" class="btn btn-full btn-m rounded-sm bg-highlight shadow-xl text-uppercase font-900 mt-3 mb-3">Back to Members</a>
		</div>
	</div>

	<!-- Menu Dates-->
	<div id="menu-dates" class="menu menu-box-bottom menu-box-detached">
		<div class="menu-title"><h1>Dates </h1><p class="color-theme opacity-40">Project Deadlines</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
		<div class="divider divider-margins mb-4"></div>
		<div class="content mt-2">
			<div class="input-style input-style-2">
				<span class="input-style-1-active">Project Deadline</span>
				<em><i class="fa fa-angle-down"></i></em>
				<input type="date" value="1980-08-26">
			</div>
			<div class="input-style input-style-2">
				<span class="input-style-1-active">Project Priority</span>
				<em><i class="fa fa-angle-down"></i></em>
				<select>
					<option value="a" selected>Low</option>
					<option value="b">Medium</option>
					<option value="c">High</option>
					<option value="d">Critical</option>
				</select>
			</div>
			<div class="input-style input-style-2">
				<span class="input-style-1-active">Project Status</span>
				<em><i class="fa fa-angle-down"></i></em>
				<select>
					<option value="1">Planing</option>
					<option value="2" selected>Developing</option>
					<option value="3">Complete</option>
				</select>
			</div>

		 <a href="#" data-menu="menu-manage" class="btn btn-full btn-m rounded-sm bg-highlight shadow-xl text-uppercase font-900 mt-3 mb-3">Back to Members</a>
		</div>
	</div>

	<!-- Menu Dates-->
	<div id="menu-modal-dates" class="menu menu-box-bottom menu-box-detached">
		<div class="menu-title"><h1>Dates </h1><p class="color-theme opacity-40">Project Deadlines</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
		<div class="divider divider-margins mb-4"></div>
		<div class="content mt-2">
			<div class="input-style input-style-2">
				<span class="input-style-1-active">Project Deadline</span>
				<em><i class="fa fa-angle-down"></i></em>
				<input type="date" value="1980-08-26">
			</div>
			<div class="input-style input-style-2">
				<span class="input-style-1-active">Project Priority</span>
				<em><i class="fa fa-angle-down"></i></em>
				<select>
					<option value="a" selected>Low</option>
					<option value="b">Medium</option>
					<option value="c">High</option>
					<option value="d">Critical</option>
				</select>
			</div>
			<div class="input-style input-style-2">
				<span class="input-style-1-active">Project Status</span>
				<em><i class="fa fa-angle-down"></i></em>
				<select>
					<option value="1">Planing</option>
					<option value="2" selected>Developing</option>
					<option value="3">Complete</option>
				</select>
			</div>

		 <a href="#" data-menu="menu-modal-manage" class="btn btn-full btn-m rounded-sm bg-highlight shadow-xl text-uppercase font-900 mt-3 mb-3">Back to Members</a>
		</div>
	</div>


	<?php include_once('../template/link_footer.php'); ?>