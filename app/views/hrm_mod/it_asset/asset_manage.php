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
$product_qty = $_POST["item_ex"];
$assign_date = $_POST["date"];
$remarks = $_POST["remarks"];



//If there are any errors print error
if($errors){
    $resultMessage = '<div class="alert alert-danger">' . $errors .'</div>';
    echo $resultMessage;
    exit;
}


//Check query multiple 
     $sql = "SELECT * FROM product_asign WHERE emp_id='$emp_id' and product='$product_name' and item_ex='$product_qty' and asign_date='$assign_date'";
     $result = db_query($sql);

     $count = mysqli_num_rows($result);
         
           if($count == 1){
           echo '<div class="alert alert-warning">Oops !! Alredy Exist!</div>'; 
           exit;      
		   
		   }else{

//Insert user details and activation code in the users table

 $sql = "INSERT INTO product_asign (`emp_id`, `product`,`item_ex`,`tr_from`,`asign_date`, `remarks`,`entry_by`) 
               VALUES ('$emp_id', '$product_name', '$product_qty','assign', '$assign_date', '$remarks','".$_POST['entry_by']."')";
$result = db_query($sql);
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


        
        ?>

<script src="sweetalerts/sweetalert2.min.js"></script>
<script src="sweetalerts/promise-polyfill.js"></script>
<link href="sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<link href="sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />