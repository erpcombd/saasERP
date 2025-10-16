<?php
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
include '../config/function.php';

$title='Shop Location';
$today 			  = date('Y-m-d');
$company_id   = $_SESSION['user']['company_id'];
$menu 			  = 'Tracking';
$sub_menu 		= 'track_last_location';

$google_api = find1("select map_api from ss_config where id=1");
?>





  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            
<!--            <h1 class="m-0">Shop Location</h1>
-->          </div>
<!--           <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div> -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



    <!-- Main content -->
    <section class="content">
      <div class="container-fluid n-form1">
	  
	  
<form  method="post" action="">
      <div class="row">
        <div class="col-md-8">
          <div class="form-group row m-0 pl-3 pr-3 p-1">
            <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label">Zone : </label>
            <div class="col-sm-9 p-0">
<select class="form-control" name="zon_id" required>
  <option value=""></option>
  <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$_POST['zon_id'],'1'); ?>
</select>            </div>
          </div>
        </div>
		
        
        <div class="col-md-4">
          <div class="col-sm-3 pl-0 pr-0 col-form-label">
            <input name="insert" type="submit" id="insert" value="Search" class="btn1 btn1-bg-submit"/>
          </div>
        </div>
      </div>
    </form>	 
</div>
<? if(isset($_POST['search'])){ 
  // if($_POST['zon_id']>0){ $zone_id = $_POST['zon_id']; $zone_con = ' and zone_id="'.$zone_id.'"';} 
  
 $sql = 'select * from ss_shop where zone_id="'.$_POST['zon_id'].'"';

$query = mysqli_query($conn, $sql);
$totalLat = 0;
$totalLng = 0;
$count = 0;


  while ($row = mysqli_fetch_assoc($query)) {

     $latitude = $row['latitude'];
     $longitude = $row['longitude'];
     $shopName=$row['shop_name'];

     $totalLat += $latitude;
     $totalLng += $longitude;
     $count++;


    $locations[] = "{lat: $latitude, lng: $longitude}";
    $shop_name[] = $shopName;

 }

 $avgLat = $totalLat / $count;
 $avgLng = $totalLng / $count;

// Center of the locations array
$locationsCenter = ["lat" => $avgLat, "lng" => $avgLng];
}
  ?>


<style>
    #map {
      height: 400px;
      width: 100%;
    }
  </style>

  <div id="map"></div>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBesXXt7OdJx2wz7Q3REhPvqgLLKCWYSWI&callback=initMap" async defer></script>

 <script>
  <?php if(isset($_POST['search'])): ?>
  function initMap() {
    var totalLat = 0, totalLng = 0;



    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 7,
      center: {lat: <?php echo $locationsCenter['lat']; ?>, lng: <?php echo $locationsCenter['lng']; ?>} // Center the map somewhere
    });

    var image = {
      url: 'shop.png',
      scaledSize: new google.maps.Size(40, 40), 
      labelOrigin: new google.maps.Point(20, -10)// Size of the icon
    };


    // Add markers for each location
    <?php foreach($locations as $index => $location): ?>
      new google.maps.Marker({
        position: <?php echo $location; ?>,
        map: map,
        icon: image,
        label: {
        fontSize: "8pt",
        marginTop: "-20px",
        text: '<?php echo $shop_name[$index]; ?>',
    }

      });
    <?php endforeach; ?>

    // Create a DirectionsService object
    const directionsService = new google.maps.DirectionsService();
    
    // Create a DirectionsRenderer object
    const directionsRenderer = new google.maps.DirectionsRenderer({
      map: map,
    });

    // Create a waypoints array for the directions
    let waypoints = [];
    <?php foreach($locations as $location): ?>
      waypoints.push({
        location: <?php echo $location; ?>,
        stopover: true
      });
    <?php endforeach; ?>

    // Request directions from Google Maps Directions Service

  }
  <?php endif; ?>
</script>
















      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?> 