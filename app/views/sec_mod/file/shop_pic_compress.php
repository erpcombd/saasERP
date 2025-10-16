<?php
ini_set('memory_limit', '1024M'); // or you could use 1G

session_start ();
include "config/access_admin.php";
include "config/db.php";
include 'config/function.php';

function img_compress($input_image,$output_image,$ratio){
    
    $img=imagecreatefromjpeg($input_image);
    imagejpeg($img,$output_image,$ratio);    
}


echo 'New Picture '.find1("select count(*) from ss_shop where image_compress=0");




if(isset($_REQUEST['Start']) || $_GET['submit_again']==1){
$v=0;
$ratio=30;

    $sql="select * from ss_shop where image_compress=0 and dealer_code not in (1000001) limit 25";
    $query = mysqli_query($conn,$sql);
    while($info = mysqli_fetch_object($query)){
    
    $input_image='../sec_mobile_app/'.$info->picture;
    $output_image='../sec_mobile_app/'.$info->picture;
    
    img_compress($input_image,$output_image,$ratio);
    
    //mysqli_query($conn, "update ss_shop set image_compress=1 where dealer_code='".$info->dealer_code."'");
	// Assuming $info->dealer_code is properly sanitized or validated

$dealer_code = $info->dealer_code;

// Prepare a SQL statement
$stmt = $conn->prepare("UPDATE ss_shop SET image_compress = 1 WHERE dealer_code = ?");
    

$stmt->bind_param("s", $dealer_code);
    
if ($stmt->execute()) {
    $msg = "Update successful";
} else {
    $msg = "Error updating record: " . $stmt->error;
}

$stmt->close();

    $v++;   
    }

echo '<br>Total Image process '.$v.'. Done';
    if($v>0){
    redirect2('shop_pic_compress.php?submit_again=1');
    }
    
    
}

?>
<center>
<form method="post" action="">
    
	<input type="submit" name="Start" value="Start Image Compress"/>
</form>