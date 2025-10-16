<?php
function haversineDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo) {
  $earthRadius = 6371000; // Radius of the earth in meters


  
  $latFrom = deg2rad((float) $latitudeFrom);
  $lonFrom = deg2rad((float) $longitudeFrom);
  $latTo = deg2rad((float) $latitudeTo);
  $lonTo = deg2rad((float) $longitudeTo);

  $latDelta = $latTo - $latFrom;
  $lonDelta = $lonTo - $lonFrom;

  $a = pow(sin($latDelta / 2), 2) +
       cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2);
  $c = 2 * asin(sqrt($a));

  return $earthRadius * $c;
}
echo haversineDistance(23.0386278,91.51844179999999,24.213799191800504,90.95220431685448);
?>