<?php
session_start ();
include "config/access_admin.php";
include "config/db.php";
include 'config/function.php';





if(isset($_POST['Start'])){
$v=0;

    $sql="select * from ss_shop where picture_sm not in(1) and picture_sm!=''";
    $query = mysqli_query($conn,$sql);
    while($info = mysqli_fetch_object($query)){
    
    $input_image='../sec_mobile_app/'.$info->picture_sm;
    
    unlink($input_image);

    
    //mysqli_query($conn, "update ss_shop set picture_sm=1 where dealer_code='".$info->dealer_code."'");
	// Assuming $info->dealer_code is properly sanitized or validated

$dealer_code = $info->dealer_code;

$stmt = $conn->prepare("UPDATE ss_shop SET picture_sm = 1 WHERE dealer_code = ?");
    
$stmt->bind_param("i", $dealer_code);
    

if ($stmt->execute()) {
    $msg = "Update successful";
} else {
    $msg = "Error updating record: " . $stmt->error;
}

$stmt->close();

    $v++;   
    }

echo '<br>Total Image process '.$v.'. Done';
}

?>
<center>
<form method="post" action="">
    
	<input type="submit" name="Start" value="Start SM Image Remove"/>
</form>