<?php





function getDistance($lat1,$long1,$lat2,$long2){
    // Google API key
    $apiKey = 'AIzaSyCPfrXFXYtJA_xSPSP4mZcE-qlGSSQzu-0';
    

    
    // Get latitude and longitude from the geodata
    $latitudeFrom       = $lat1;
    $longitudeFrom      = $long1;
    $latitudeTo         = $lat2;
    $longitudeTo        = $long2;
    
    // Calculate distance between latitude and longitude
    $theta    = $longitudeFrom - $longitudeTo;
    $dist    = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
    $dist    = acos($dist);
    $dist    = rad2deg($dist);
    $miles    = $dist * 60 * 1.1515;
    
    // Convert unit and return distance

        return round($miles * 1.609344, 2);

}


// from
$lat1='40.7767644';
$long1='-73.9761399';

// to
$lat2='40.771209';
$long2='-73.9673991';

// Get distance in km
$distance = getDistance($lat1,$long1,$lat2,$long2);



echo $distance;

echo '<br>';
if($distance>.5) {echo 'Sorry, you are out of range.';}else{ echo 'Ok, you can take order';}






