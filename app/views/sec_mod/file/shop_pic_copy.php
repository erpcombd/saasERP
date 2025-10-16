<?php
session_start ();
include "config/access_admin.php";
include "config/db.php";
include 'config/function.php';


echo 'Total Picture '.find1("select count(*) from ss_shop where copy_done=0");



if(isset($_REQUEST['Start']) || $_GET['submit_again']==1){
$v=0;

    $sql="select dealer_code,picture from ss_shop where copy_done=0 and picture !='' order by dealer_code desc limit 30";
    $query = mysqli_query($conn,$sql);
    while($info = mysqli_fetch_object($query)){


// Remote image URL
echo '<br>'.$url="https://ezzy-erp.com/ss/sec_mobile_app/".$info->picture;

// Image path
$img ='../sec_mobile_app/'.$info->picture;

// Save image
$ch = curl_init($url);
$fp = fopen($img, 'wb');
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
fclose($fp);


 
 
  // update database  
   // mysqli_query($conn, "update ss_shop set copy_done=1 where dealer_code='".$info->dealer_code."'");
   // Assuming $info->dealer_code is properly sanitized or validated

$dealer_code = $info->dealer_code;

$stmt = $conn->prepare("UPDATE ss_shop SET copy_done = 1 WHERE dealer_code = ?");
    
$stmt->bind_param("i", $dealer_code); 
if ($stmt->execute()) {
    $msg = "Update successful";
} else {
    $msg = "Error updating record: " . $stmt->error;
}

$stmt->close();

    $v++;   
    }

echo '<br><br>Total Image Copy '.$v.'. Done';
redirect2('shop_pic_copy.php?submit_again=1');
}

?>





<center>
<form method="post" action="">
    
	<input type="submit" name="Start" value="Start Image Copy"/>
</form>