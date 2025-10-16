<?php 
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
require_once '../assets/support/emp_apps_function.php';

$title = "DO";
$page = "do.php";


require_once '../assets/template/inc.header.php';

?>


    

<!-- start of Page Content-->  
   <div class="page-content header-clear-medium">
   
   
   

        <div class="card card-style preload-img" data-src="images/pictures/18w.jpg" data-card-height="130">
            <div class="card-center ms-3">
                <h1 class="color-white mb-0">Add to Home</h1>
                <p class="color-white mt-n1 mb-0">On your Mobile Homescreen</p>
            </div>
            <div class="card-center me-3">
                <a href="#" data-back-button class="btn btn-m float-end rounded-xl shadow-xl text-uppercase font-800 bg-highlight">Back Home</a>
            </div>
            <div class="card-overlay bg-black opacity-80"></div>
        </div>
		
		
		

        <div class="card card-style">
			<form action="">
				<div class="content">
					<h4>Simulate Add to Home - Badges</h4>
	
					<div class="input-style has-borders has-icon validate-field mb-4">
						<i class="fa fa-user"></i>
						<input type="name" class="form-control validate-name" id="form1" placeholder="Name">
						<label for="form1" class="color-highlight">Name</label>
						<i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em>(required)</em>
					</div>
	
					<div class="input-style has-borders no-icon validate-field mb-4">
						<input type="email" class="form-control validate-text" id="form2" placeholder="Email">
						<label for="form2" class="color-highlight">Email</label>
						<i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em>(required)</em>
					</div>
	
					<div class="input-style has-borders no-icon validate-field mb-4">
						<input type="password" class="form-control validate-text" id="form3" placeholder="Password">
						<label for="form3" class="color-highlight">Password</label>
						<i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em>(required)</em>
					</div>
	
					<div class="input-style has-borders no-icon validate-field mb-4">
						<input type="url" class="form-control validate-text" id="form44" placeholder="Website">
						<label for="form44" class="color-highlight">Website</label>
						<i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em>(required)</em>
					</div>
	
					<div class="input-style has-borders no-icon validate-field mb-4">
						<input type="tel" class="form-control validate-text" id="form4" placeholder="Phone">
						<label for="form4" class="color-highlight">Phone</label>
						<i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em>(required)</em>
					</div>
	
					<div class="input-style has-borders no-icon mb-4">
						<label for="form5" class="color-highlight">Select A Value</label>
						<select id="form5">
							<option value="default" disabled selected>Select a Value</option>
							<option value="iOS">iOS</option>
							<option value="Linux">Linux</option>
							<option value="MacOS">MacOS</option>
							<option value="Android">Android</option>
							<option value="Windows">Windows</option>
						</select>
						<span><i class="fa fa-chevron-down"></i></span>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<i class="fa fa-check disabled invalid color-red-dark"></i>
						<em></em>
					</div>
	
					<div class="input-style has-borders no-icon mb-4">
						<input type="date" value="2030-12-31" value="2030-12-31" max="2030-01-01" min="2021-01-01" class="form-control validate-text" id="form6" placeholder="Phone">
						<label for="form6" class="color-highlight">Select Date</label>
						<i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
						<i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
					</div>
	
					<div class="input-style has-borders no-icon mb-4">
						<textarea id="form7" placeholder="Enter your message"></textarea>
						<label for="form7" class="color-highlight">Enter your Message</label>
						<em class="mt-n3">(required)</em>
					</div>
					
					<div class="row">
						<div class="col-6">
							<a href="#" class="btn btn-3d btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s border-yellow-dark bg-yellow-light">Buton</a>
						</div>
						<div class="col-6">
							<a href="#" class="btn btn-3d btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s border-mint-dark bg-mint-dark">Initiate</a>
						</div>
					</div>
				</div>
			</form>
            </div>
			
			
			
			<div class="content">
				  <table class="table table-borderless text-center rounded-sm shadow-l" style="overflow: hidden;">
						<thead>
							<tr class="bg-night-light">
								<th scope="col" class="color-white">Brand</th>
								<th scope="col" class="color-white">Device</th>
								<th scope="col" class="color-white">Status</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th scope="row">Apple</th>
								<td class="color-green-dark">$500</td>
								<td><i class="fa fa-arrow-up rotate-45 color-green-dark"></i></td>
							</tr>
							<tr>
								<th scope="row">Android</th>
								<td class="color-yellow-dark">$400</td>
								<td><i class="fa fa-arrow-right rotate-45 color-yellow-dark"></i></td>
							</tr>
							<tr>
								<th scope="row">Nope</th>
								<td class="color-red-dark">$300</td>
								<td><i class="fa fa-arrow-right rotate-90 color-red-dark"></i></td>
							</tr>
						</tbody>
					</table>
			</div>
			
			
			
			
						
		<div class="card card-style">
			<div class="content">
				<div class="d-flex pb-2">
					<div class="align-self-center pe-3">
						<a href="#"><img src="images/pictures/faces/2s.png" width="38" class="rounded-xl"></a>
					</div>
					<div class="align-self-center">
						<h2 class="font-700 mb-0">Any Style</h2>
						<p class="mb-n2 mt-n1 font-700 font-11 text-uppercase color-highlight">Date: 00-00-0000</p>
					</div>
					<div class="align-self-center ms-auto">
						<p class="m-0 p-0">10,000</p>
					</div>
				
				</div>
			</div>
		</div>
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
        </div>
    <!-- End of Page Content--> 
    
    











<?php 
 require_once '../assets/template/inc.footer.php';
 ?>