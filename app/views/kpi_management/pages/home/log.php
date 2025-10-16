<?php
session_start();

require_once("../../config/default_values.php");
require_once('../../config/db_connect_scb_main.php');
require "../../template/log_link.php";

if(isset($_POST['submit'])){
  $pass = $_POST['pass'];
  
  $sql = mysql_query('select pass from welcome_note where pass="'.$pass.'"');
  $data = mysql_fetch_object($sql);
  if($data->pass!=''){
   echo '<script type="text/javascript">
parent.parent.document.location.href = "setup.php";
</script>';

    
  }else{
    echo 'Invalid Login !';
  }
  
 
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container" style="width:500px;">
  <h2>Login </h2>
  <form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label for="note">Enter Password:</label>
      <input type="password" class="form-control" id="pass"  name="pass" value="" style="width:100%; float:left;">
    </div>
    <div class="form-group"><br><br>
      <input type="submit" name="submit" value="Login" class="btn btn-success"/>
    </div>
	
	
      
     
   
    
  
  </form>
</div>

</body>
</html>
        
        
        
    

          

                     
        