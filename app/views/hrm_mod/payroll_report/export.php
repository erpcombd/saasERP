<?

session_start();







require "../../config/inc.all.php";







require "../../classes/report.class.php";







require_once ('../../../acc_mod/common/class.numbertoword.php');

date_default_timezone_set('Asia/Dhaka');

?>


  <table class="table table-bordered">
                       <tr>  
                         <th>Name</th>  
                         <th>Address</th>  
                         <th>City</th>  
                         <th>Postal Code</th>
                         <th>Country</th>
                    </tr>
					

<?php  
//export.php  


if(isset($_POST["export"]))
{
echo $sql = "SELECT * FROM dealer_info where 1 order by dealer_code desc limit 5";  
           $result = db_query($sql);
           while($dt = mysqli_fetch_object($result)){
  
  ?> 
                      <tr>  
                        <td><?=$dt->dealer_code?></td>
                        <td><?=$dt->dealer_name_e?></td>
                        <td><?=$dt->moile_no?></td>
                        <td><?=$dt->propritor_name_e?></td>
                         <td><?=$dt->account_code?></td>
                           </tr>  
					
					
  <?php  }  ?>
  
   </table>
  
  <?php 

  //header('Content-Type: application/xls');
  //header('Content-Disposition: attachment; filename=download.xls');
  //echo $output;
  
  
  header("Content-type: application/vnd.ms-excel; name='excel'");
  header("Content-Disposition: attachment; filename=exportfile.xls");
  header("Pragma: no-cache");
  header("Expires: 0");
  echo $output;


 }

?>