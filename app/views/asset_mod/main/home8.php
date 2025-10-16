<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = "Fixed Asset Dashboard";


 $today = date('Y-m-d');

 $lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));

?>









<div class="content">

  <div class="container-fluid">

<h1>Fixed Asset Home Page</h1>

  



  </div>

</div>    





















   

<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>