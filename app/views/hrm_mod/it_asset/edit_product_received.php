<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
?>

<script src="sweetalerts/sweetalert2.min.js"></script>
<script src="sweetalerts/promise-polyfill.js"></script>
<link href="sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<link href="sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />





<!--  Get assign  id  -->
<?php 
if($asign_id = $_GET['asign_id']){
$sql   = "SELECT * FROM product_asign where asign_id = '".$_GET['asign_id']."'";
$result= db_query($sql);
$row   = mysqli_fetch_array($result);

$emp_id  = $row['emp_id'];
$productt = $row['product']; 
$item_in = $row['item_in']; 
$asign_date = $row['asign_date']; 
$remarks = $row['remarks']; 
   
}else{
header('location:product_received.php');
}

?>



<?php 



 if(isset($_POST['update_category'])){
 
 
//Prepare variables for the queries
$emp_id = $_POST["emp_id"]; 
$product_name = $_POST["product"];
$product_qty = $_POST["item_in"];
$assign_date = $_POST["date"];
$remarks = $_POST["remarks"];
 
  //check alredy exist or not
     
     $sql = "SELECT * FROM product_asign WHERE emp_id='$emp_id' and product='$product_name' and item_in='$product_qty' and asign_date='$assign_date'";
     $result = db_query($sql);

     $count = mysqli_num_rows($result);
         
           if($count == 1){
           echo"<script>
               jQuery(function validation() {
                   swal({
                       type: 'error',
                       title: 'Oops...',
                       text: 'Alredy Exist!',
                       footer: '<a href>Please Search this item on Datatable or Add New Item!</a>',
                       padding: '2em'
                   })
               })
           </script> "; }else{

//Update details and activation code in the users table

 $sqlupdate="UPDATE product_asign SET emp_id = '$emp_id',product='$product_name',item_in='$product_qty',asign_date='$assign_date' WHERE tr_from='receive' and asign_id ='".$_GET['asign_id']."' ";
            $result =db_query($sqlupdate);
            if($result){
            echo "<script>
                jQuery(function validation() {
                    swal({
                        title: 'Saved succesfully!',
                        text: 'You Follow The Right Step! ',
                        type: 'success',
                        padding: '2em'
                    })
                })
            </script>";
            } 
			
			}


        
		
		
		}

?>




          <div class="x_content">
                    <br />
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Employee  Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="text" class="form-control" list='eip_ids' name="emp_id" id="emp_id" value="<?=find_a_field('personnel_basic_info','concat(PBI_ID," - ",PBI_NAME)','PBI_ID="'.$emp_id.'"');?>" required />
				    <datalist id='eip_ids'>
                    <option></option>
				    <? foreign_relation('personnel_basic_info','PBI_ID','concat(PBI_ID," - ",PBI_NAME)',$emp_id,'1');?>
					 </datalist>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Product Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="text" class="form-control" list='item' name="product" id="product" value="<?=$productt;?>" requierd/>
                      <datalist id='item'>
                      <option></option>
                      <? foreign_relation('item_info','item_id','concat(item_id," - ",item_name)',$product,'product_nature = "Purchasable"');?>
					  </datalist>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Product QTY</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="item_in" class="form-control col-md-7 col-xs-12" type="number" value="<?=$item_in;?>" name="item_in">
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Assign Date<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="date" name="date" class="date-picker form-control col-md-7 col-xs-12" value="<?=$asign_date?>" required="required" type="date">
                        </div>
                      </div>
					  
					  
					    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Remarks<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="remarks" name="remarks" class="date-picker form-control col-md-7 col-xs-12" value="<?=$remarks?>" type="text">
                        </div>
                      </div>
					  
					  
					  
					  
					  
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                         <a href="product_received.php"> <button class="btn btn-primary" type="button">Cancel</button></a>
						  <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" name="update_category" class="btn btn-success">Submit</button>
                        </div>
                      </div>

                    </form>
                  </div>








                 
        

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>