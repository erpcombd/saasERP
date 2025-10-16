<?php
require_once "../../../assets/template/layout.top.php";
$title = "Sales management Dashboard";

require_once "../../template/inc.notify.php";
 $today = date('Y-m-d');
 $lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));
 $cur = '&#x9f3;';
?>




 <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>


  <script src="../../../dashboard_assets/morris/morris.min.js" type="text/javascript"></script>
  <script src=""></script>
  <link rel="stylesheet" href="../../../dashboard_assets/morris/morris.css"/>


<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from designreset.com/cork/ltr/demo3/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 05 Mar 2020 08:10:15 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>  </title>
   <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="../../../dashboard_assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
</head>



<div class="content">
        
		<div class="row">
			<div class="col-md-3" >
			 	<div style="background:#90EE90;margin:2px; height:166px;width:250px;border-radius:41px;">
					
				</div>
			</div>
			<div class="col-md-3"  >
				<div style="background:#90EE90;margin:2px; height:166px;width:250px;border-radius:41px;">
					
				</div>
			</div>
			<div class="col-md-3"  >
				<div style="background:#90EE90;margin:2px; height:166px;width:250px;border-radius:41px;">
					
				</div>
			</div>
			<div class="col-md-3"  >
					<div style="background:#90EE90;margin:2px; height:166px;width:250px;border-radius:41px;">
					
				</div>
			</div>
		</div>
		
		
      </div>




   
<?

require_once "../../../assets/template/layout.bottom.php";

?>