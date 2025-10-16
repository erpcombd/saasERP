<?php
session_start ();
include ("../config/db.php");
include '../config/function.php';
$company_id     = $_SESSION['company_id'];


if(isset($_POST["query"]))  
 {  
      $output = '';  
      $query = "SELECT v.*,max(visitor_enter_date) FROM visitor_table v WHERE company_id='".$company_id."' and visitor_name LIKE '%".$_POST["query"]."%' group by visitor_mobile_no";  
      $result = mysqli_query($conn, $query);  
      $output = '<ul class="list-group">';  
      if(mysqli_num_rows($result) > 0)  
      {  
           while($data = mysqli_fetch_object($result))  
           {  
                $output .= '<li id="hello" class="list-group-item list-group-item-info">'.$data->visitor_name.'<img src="visitor_image/'.$data->visitor_in_image.'" style="width:120px;"></li>';  
           }  
      }  
      else  
      {  
           $output .= '';  
      }  
      $output .= '</ul>';  
      echo $output;  
 }  
 ?>