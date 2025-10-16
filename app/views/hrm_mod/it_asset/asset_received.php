<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$emp_id = '<p><strong>Please enter a username!</strong></p>';
$product_name = '<p><strong>Please enter a product name!</strong></p>';

//Get username
if(empty($_POST["emp_id"])){
    $errors .= $emp_id;
}else{
    $emp_id = $_POST["emp_id"];  
}


if(empty($_POST["product"])){
    $errors .= $product_name;
}else{
    $product_name = $_POST["product"];  
}


//no errors

//Prepare variables for the queries

$_POST['entry_by'] = $_SESSION['user']['id'];
$product_qty = $_POST["item_in"];
$assign_date = $_POST["date"];
$remarks = $_POST["remarks"];

$final_stock += find_a_field('product_asign','sum(item_in-item_ex)','product="'.$_POST["product"].'"');

//If there are any errors print error
if($errors){
    $resultMessage = '<div class="alert alert-danger">' . $errors .'</div>';
    echo $resultMessage;
    exit;
}

//Check query multiple 
   $sql = "SELECT * FROM product_asign WHERE emp_id='$emp_id' and product='$product_name' and item_in='$product_qty' and asign_date='$assign_date'";
     $result = db_query($sql);

     $count = mysqli_num_rows($result);
         
           if($count == 1){
           echo '<div class="alert alert-warning">Oops !! Alredy Exist!</div>'; 
           exit;      
		   
		   }else{
		   
		   
//Insert user details and activation code in the users table		   
 $sql = "INSERT INTO product_asign (`emp_id`, `product`,`item_in`,`final_stock`,`tr_from`,`asign_date`, `remarks`,`entry_by`) 
               VALUES ('$emp_id', '$product_name', '$product_qty','$final_stock','receive','$assign_date', '$remarks','".$_POST['entry_by']."')";
$result = db_query($sql);

if($result){

    echo '<div class="alert alert-success">Product successfully asigned!</div>'; 
    exit;
}
			
          
}









        
        ?>