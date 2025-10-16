<?php
session_start ();
include ("../config/access_admin.php");
include ("../config/db.php");
include '../config/function.php';
$today = date('Y-m-d');
$log = $_GET['log'];
$visitor = findall("select * from visitor_table where visitor_id='".$log."'");
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/imgs/theme/favicon.svg">
    <!-- Template CSS -->
    <link href="assets/css/main.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/custom.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/custom_card.css" rel="stylesheet" type="text/css" />
</head>
<body>


<style>
.mycard{
    width: 18rem;
}  
.footer_title{
    font-size: 20px;
    background-color: #efefef;
    font-weight: 700;
}
.card-content card_title {
  margin: 0 0 5px;
  font-weight: 600;
  font-size:25px;
}
.card-content span {
  display: block;
  font-size: 15px;
  margin-top:10px;
}    
    
</style>



<section>

    	<div class="row">
    	    


    		<div class="mycard">
    		    <div class="card profile-card-3">
    		        <div class="text-center" style="background-color: rgba(0, 0, 0, 0.2);"> <img src="../images/logo.png" class="footer_logo"/></div>
    		        <div class="background-block">
    		            <img src="visitor_image/<?php echo $visitor->visitor_in_image;?>" alt="profile-sample1" class="background"/>
    		        </div>
    		        
    		        
    		        <!--<div class="profile-thumb-block">-->
    		        <!--    <img src="visitor_image/<?php echo $visitor->visitor_in_image;?>" alt="profile-image" class="profile"/>-->
    		        <!--</div>-->
    		        
    		        
    		        <div class="card-content">
                    <div class="card_title"><?php echo $visitor->visitor_name?></div>
                    <span><?php echo $visitor->visitor_mobile_no?></span>
                    
                    
                    <div><img src="https://chart.apis.google.com/chart?cht=qr&chs=100x100&chl=<?php echo $visitor->visitor_id?>"></div>
                    
                    </div>
                </div>


  
  
  <div class="text-center footer_title" style="background-color: rgba(0, 0, 0, 0.2);"> Visitor PASS</div>

    		</div>
    		


    		
    	</div>

</section>    
    

        










<!--Footer Part-->
<script src="assets/js/vendors/jquery-3.6.0.min.js"></script>
<script src="assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="assets/js/vendors/select2.min.js"></script>
<script src="assets/js/vendors/perfect-scrollbar.js"></script>
<script src="assets/js/vendors/jquery.fullscreen.min.js"></script>
<script src="assets/js/vendors/chart.js"></script>
<!-- Main Script -->
<script src="assets/js/main.js" type="text/javascript"></script>
<script src="assets/js/custom-chart.js" type="text/javascript"></script>
</body>
</html>