<!DOCTYPE html>
<html>
  <head>
<title></title>
    <style>
       /* Set the size of the div element that contains the map */
      #map {
        height: 600px;
        width: 100%;
       }
    </style>
  </head>
  <body>
    <!--The div elements for the map and message -->
    <div id="map"></div>
    <div id="msg"></div>


<script>
// Initialize and add the map
var map;

// Calculate and display the distance between markers
var distance = haversine_distance(mk1, mk2);
document.getElementById('msg').innerHTML = "Distance between markers: " + distance.toFixed(2) + " mi."; 


 
function haversine_distance(mk1, mk2) {
      var R = 6371.0710; // Radius of the Earth in kilometers
      var rlat1 = mk1.position.lat() * (Math.PI/180); // Convert degrees to radians
      var rlat2 = mk2.position.lat() * (Math.PI/180); // Convert degrees to radians
      var difflat = rlat2-rlat1; // Radian difference (latitudes)
      var difflon = (mk2.position.lng()-mk1.position.lng()) * (Math.PI/180); // Radian difference (longitudes)

      var d = 2 * R * Math.asin(Math.sqrt(Math.sin(difflat/2)*Math.sin(difflat/2)+Math.cos(rlat1)*Math.cos(rlat2)*Math.sin(difflon/2)*Math.sin(difflon/2)));
      return d;
}    



function initMap() {
  // The map, centered on Central Park
  const center = {lat: 40.774102, lng: -73.971734};
  const options = {zoom: 15, scaleControl: true, center: center};
  map = new google.maps.Map(
      document.getElementById('map'), options);
  
  // Locations of landmarks
  const dakota = {lat: 40.7767644, lng: -73.9761399};
  const frick = {lat: 40.771209, lng: -73.9673991};
  
  // The markers for The Dakota and The Frick Collection
  var mk1 = new google.maps.Marker({position: dakota, map: map});
  var mk2 = new google.maps.Marker({position: frick, map: map});
  var line = new google.maps.Polyline({path: [dakota, frick], map: map});
}



  
  
   


</script>
    
    
    

<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPfrXFXYtJA_xSPSP4mZcE-qlGSSQzu-0&callback=initMap">
</script>
    
    
    
    
  </body>
</html>


