<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

if($_GET["id"]==1){
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">

    <title>Absent Report</title>
  </head>
  <body>
  <center><h3 class="m-3"><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"')?></h3></center>
  <center><h5 class="m-3">Absent Report</h5></center>
  <center>date: <?=date("Y-m-d")?></center>
  
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">EMPLOYEE CODE</th>
      <th scope="col">EMPLOYEE NAME</th>
      <th scope="col">DEPARTMENT</th>
	  <th scope="col">DESIGNATION</th>
	  <th scope="col">ABSENT DATE</th>
	  <tr>

    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
	   <td>@mdo</td>
	    <td>@mdo</td>
    </tr>
 
  </tbody>
</table>


  </body>
</html>




<? } ?>




