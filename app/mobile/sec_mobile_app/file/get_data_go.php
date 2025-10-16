<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';


if (isset($_POST['sr_shop'])) {

    echo $sql = "SELECT * FROM zon where REGION_ID=".$_POST['region_id']." order by ZONE_NAME";
    $query = mysqli_query($conn, $sql);
    echo '<option></option>';
    while($data=mysqli_fetch_object($query)){
            echo '<option value='.$data->ZONE_CODE.'>'.$data->ZONE_NAME.'</option>';
         }
    
}elseif (isset($_POST['dealer_code'])) {
    // Retrieve latitude and longitude from the POST request
    $latitude = isset($_POST['latitude']) ? $_POST['latitude'] : '';
    $longitude = isset($_POST['longitude']) ? $_POST['longitude'] : '';

    // Fetch shop details based on dealer code
    $sql = find_all_field('ss_shop', '', 'dealer_code="' . $_POST['dealer_code'] . '"');

    // Calculate the distance using the haversine formula
    $distance = haversineDistance($latitude, $longitude, $sql->latitude, $sql->longitude);

    // Output the distance in a readonly input field
    echo '<input name="order_distance" type="text" id="order_distance" value="' . $distance . '" required class="form-control" readonly />';
}


?>


