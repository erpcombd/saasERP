<?php

session_start();

ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Customer Statement';

$proj_id=$_SESSION['proj_id'];

$fromdate=$_POST['fdate'];
$todate=$_POST['tdate'];


?>



<form id="form1" name="form1" method="post" action="">
								            
	<div class="container-fluid bg-form-titel">
        <div class="row">					
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 pt-1 pb-1">
                        <div class="form-group row m-0">
                            <label class="col-sm-3 col-md-3 col-lg-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Customer Name :</label>
                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 pr-3">
                              <div>  										
								<select name="customer_name" id="customer_name" class="customer_name" value="<?=$_POST['customer_name'];?>">
									<option></option>
									 <?php 
										$sql33="SELECT id, name from info_sr";
										$query23=db_query($sql33);
										while($datarow=mysqli_fetch_object($query23)){
									 ?>
										<option><?=$datarow->name?>--<?=$datarow->id?></option>  
								 	<?php }?>
								 </select>
                            		
		                     </div>

                            </div>
                        </div>
                    </div>

                </div>
               

    </div>

</form>

<?
selected_two("#customer_name");
require_once SERVER_CORE."routing/layout.bottom.php";
?>