<?php
require_once "../../../controllers/routing/layout.top.php";
$current_page = "response";
$title='Response Entry';

do_calander("#f_date");
do_calander("#t_date");
unset($_SESSION['rfq_no']);
?>
<? include 'ep_menu.php'; ?>
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

 .dropdown {
    position: relative;
    display: inline-block;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 210px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
	left: 10px; 
	padding: 5px 0px;
	border-radius: 3px;
  }
  .dropdown-content a{
  	background-color:#fff !important;
	text-align:left;
	padding: 5px 0px 5px 10px;
  }
  .dropdown-content a:hover{
  color:#f37025;
  }
  
  

  .fs-8{font-size:8px !important;}.fs-9{font-size:9px !important;}.fs-10{font-size:10px !important;}.fs-11{font-size:11px !important;}.fs-12{font-size:12px !important;}.fs-13{font-size:13px !important;} .fs-14{font-size:14px !important;}  .fs-15{font-size:15px !important;}  .fs-16{font-size:16px !important;}  .fs-17{font-size:17px !important;}  .fs-18{font-size:18px !important;}  .fs-19{font-size:19px !important;}  .fs-20{font-size:20px !important;} .fs-21{font-size:21px !important;}.fs-22{font-size:22px !important;}

  
  
  .modal-dialog {
    max-width: 1000px;
	top: 10%;
   }
   .modal-header{
	   background-color:#333;
	   padding: 13px;
   }
    
   .modal-header .modal-title, .modal-header button i {
   		color:#fff;
   }

	.new-even{
		width: 100%;
		height: 250px;
		border: 1px solid #d5d4d4;
		border-radius: 10px;
		padding: 10px;
	}
	
	.even-ul,.even-ul .even-li{
		margin:0px;
		padding:0px;
		list-style:none;
		line-height:2;
	}
	.overflow-even{
		overflow-x: hidden !important;
		overflow: scroll;
		height: 160px;
		width: 100%;
	}
	.btn1-bg-cancel,.btn1-bg-cancel:hover {
    	background-color: #efefef;
    	color: #181818;
    	font-weight: bold !important;
	}
</style>
<h1 class="container" style=" font-size: 30px !important; ">Response Items</h1>
<div class="container ep-bg-color pt-0 mt-5 p-0 ">

<div class="d-flex justify-content-start d-flex-bg-color">
	<div class="dropdown" id="dropdown">
		<button type="button" class="btn1 btn1-bg-submit" onclick="toggleDropdown()" style=" margin-bottom: 4px !important; ">Export to <em class="fa-light fa-chevron-down" style=" padding-left: 10px; font-weight: 600; "></em></button>
		  <div class="dropdown-content" id="myDropdown">
			<a href="#">CSV plain (current columns)</a>
			<a href="#">CSV for Excel (current columns)</a>
			<a href="#">Excel (current columns)</a>
		  </div>
	</div>


	<div style=" padding-top: 10px; ">
		<div class="form-group row m-0 p-0" style=" width: 300px; ">
		<label for="inputPassword" class="col-sm-2 col-form-label fs-14" style=" padding: 3px; color: white; font-weight: 600 !important; text-align: end; ">View</label>
		<div class="col-sm-10">
		        <select id="" name="" class="form-control" style="height: 28px !important;padding-top: 4px; ">
					<option value="ALL"> ALL</option>
					<option value="">Response Line Details </option>
					<option value="">Create View </option>
      			</select>
		</div>
	  </div>
  </div>
	<div style=" padding-top: 10px; ">
	  	  <form class="form-inline m-0 p-0" action="">
		<div class="input-group" style=" background-color: white; border-radius: 5px; ">
				  <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1" style="height: 28px !important;padding-top: 2px; border-right: none; ">
		  <button type="submit" class="input-group-prepend" style=" width: 25%; height: 27px !important; border: none; border-radius: 0px 5px 5px 0px; background-color: white; ">
			<em class="fa-duotone fa-magnifying-glass fa-flip-horizontal fa-xl" style="--fa-primary-color: #b27d0a; --fa-secondary-color: #0ebadd; padding: 12px;"></em>
		  </button>
		</div>
	  </form>
	</div>
	  
</div>

<table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th scope="col">Supplier </th>
						<th scope="col">Awarded Suppliers</th>
                        <th scope="col">Response Name</th>
                        <th scope="col">Submitted</th>
						<th scope="col">item</th>
                        <th scope="col">Base Price</th>
						<th scope="col">Item Price</th>
						<th scope="col">Capacity</th>
						<th scope="col">Item Quantity</th>
						<th scope="col">Total</th>
						<th scope="col">Award</th>
						<th scope="col">Event Name</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
																			
					</tbody>
                </table>

</div>


<?
require_once "../../../controllers/routing/layout.bottom.php";
?>