<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$product_name = '<p><strong>Please enter a product name!</strong></p>';

//Get username
if(empty($_POST["product"])){
    $errors .= $product_name;
}else{
    $product_name = $_POST["product"];  
}


//no errors

//Prepare variables for the queries

$_POST['entry_by'] = $_SESSION['user']['id'];
$vendor =mysqli_real_escape_string($_POST["vendor"]);
$product_qty = $_POST["item_in"];
$assign_date = $_POST["date"];
$remarks = $_POST["remarks"];



//If there are any errors print error
if($errors){
    $resultMessage = '<div class="alert alert-danger">' . $errors .'</div>';
    echo $resultMessage;
    exit;
}

//Check query multiple 
   $sql = "SELECT * FROM product_asign WHERE vendor='$vendor' and product='$product_name' and item_in='$product_qty' and asign_date='$assign_date'";
     $result = db_query($sql);

     $count = mysqli_num_rows($result);
         
           if($count == 1){
           echo '<div class="alert alert-warning">Oops !! Alredy Exist!</div>'; 
           exit;      
		   
		   }else{
		   
		   
//Insert user details and activation code in the users table		   
 $sql = "INSERT INTO product_asign (`product`,`item_in`,`tr_from`,`asign_date`, `remarks`,`entry_by`,`vendor`) 
         VALUES ('$product_name','$product_qty','purchase','$assign_date', '$remarks','".$_POST['entry_by']."','$vendor')";
$result = db_query($sql);

if($result){

    echo '<div class="alert alert-success">Purchase successfully asigned!</div>'; 
    exit;
}
			
          
}









        
        ?>