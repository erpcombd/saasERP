<?php
session_start ();
include ("../config/access_admin.php");
include ("../config/db.php");
include '../config/function.php';
$menu = 'Report';
$sub_menu = 'report_list';
$today = date('Y-m-d');
?>
        
<!--Top header	-->	
<?php include("inc/header.php");?>
<?php include("inc/header_top.php");?>
        

<section class="content-main">
<div class="content-header">
<h2 class="content-title">Visitor List</h2>
</div>

<div class="card mb-4">
<div class="card-body">
<!--BODY Start	-->
				
				

				

<!-- Body end -->
</section> 		

        
		
		
<?php include("inc/footer.php");?>