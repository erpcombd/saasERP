<?php
include ("../config/db.php");
include ("../config/function.php");


$pdata  = file_get_contents("php://input");
$result = json_decode($pdata); 

// 065285be-c098-4e1c-9678-7978e17d2ea1
//$api_key = $result[0]->api_key;
//api_key_check($api_key);


//post data

$entry_by           = $emp_code= $result[0]->entry_by; 
$shop_name          = $result[0]->shop_name ; 
$shop_owner_name    = $result[0]->shop_owner_name;

$master_dealer_code = $result[0]->master_dealer_code;
$route_id           = $result[0]->route_id; 
$area_id            = $result[0]->area_id; 
$zone_id            = $result[0]->zone_id; 
$region_id          = $result[0]->region_id ;
$shop_class         = $result[0]->shop_class; 
$shop_type          = $result[0]->shop_type ;
$shop_channel       = $result[0]->shop_channel;
$shop_route_type    = $result[0]->shop_route_type ; 
$shop_identity      = $result[0]->shop_identity; 
$mobile             = $result[0]->mobile ;
$shop_address       = $result[0]->shop_address; 
$status             = $result[0]->status;
$picture            = $result[0]->picture;
$entry_at           =date('Y-m-d H:i:s');

$latitude           = $result[0]->latitude;
$longitude          = $result[0]->longitude;
echo $route_id;


$data = array();

// upload picture
if($_FILES['picture']['name'] != ''){
	
 	$picture = $_FILES['picture']['name'];
	$feedback=$picture ;

	$target_dir = "../uploads/";
	$picture = date('YmdHis').$entry_by.basename($_FILES["picture"]["name"]);
echo	$target_file = $target_dir . $picture;
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
	
	$check = getimagesize($_FILES["picture"]["tmp_name"]);
	if($check !== false) {
		$uploadOk = 1;
	} else {
		$feedback='File is not an image.';
		$uploadOk = 0;
	}
	
	// Check file size
	if ($_FILES["picture"]["size"] > 500000) {
		$feedback='Sorry, your file is too large.';
		$uploadOk = 0;
	}
	
	// Check if $uploadOk is set to 0 by an error
// 	if ($uploadOk == 1) {
// 		if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
// 			$feedback='The file '. basename( $_FILES["picture"]["name"]). ' has been uploaded.';
// 		} else {
// 			$feedback='Sorry, there was an error uploading your file.';
// 		}
// 	}
if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
        $feedback = 'The file ' . basename($_FILES["picture"]["name"]) . ' has been uploaded.';
    } else {
        $last_error = error_get_last();
        $feedback = 'Sorry, there was an error uploading your file: ' . $last_error['message'];
    }
}

	$getdata=[
		'message'=>$feedback
	];
	array_push($data, $getdata);

	
}

$sql = "INSERT ignore INTO ss_shop (
emp_code, shop_name, shop_address, shop_owner_name, mobile, master_dealer_code, 
region_id, zone_id,area_id,route_id, 
shop_class, shop_type, shop_channel, shop_route_type, shop_identity, 
status, latitude, longitude, picture, entry_by, entry_at
) VALUES (
'".$_POST['emp_code']."', '".$_POST['shop_name']."', '".$_POST['shop_address']."', '".$_POST['shop_owner_name']."', '".$_POST['mobile']."', '".$_POST['master_dealer_code']."', 
'".$_POST['region_id']."', '".$_POST['zone_id']."', '".$_POST['area_id']."', '".$_POST['route_id']."', 
'".$_POST['shop_class']."', '".$_POST['shop_type']."', '".$_POST['shop_channel']."', '".$_POST['shop_route_type']."', '".$_POST['shop_identity']."', 
'".$_POST['status']."', '".$_POST['latitude']."', '".$_POST['longitude']."', '".$picture."', '".$_POST['entry_by']."', '".$entry_at."'
)";


// VALUES (
// 	'".$emp_code."', '".$shop_name."', '".$shop_address."', '".$shop_owner_name."', '".$mobile."', '".$master_dealer_code."', 
// 	'".$region_id."', '".$_POST['zone_id']."','".$area_id."','".$route_id."', 
// 	'".$shop_class."', '".$shop_type."', '".$shop_channel."', '".$shop_route_type."', '".$shop_identity."', 
// 	'".$status."', '".$latitude."', '".$longitude."', '".$picture."', '".$entry_by."', '".$entry_at."'
// 	)";
	

mysqli_query($conn, $sql);

if(mysqli_query($conn, $sql)){ $feedback='Done';}else{ $feedback = 'Failed: ' . mysqli_error($conn);}

	$getdata=[
		'message'=>$feedback
	];
	array_push($data, $getdata);


echo json_encode($data);
mysqli_close($conn);

?>