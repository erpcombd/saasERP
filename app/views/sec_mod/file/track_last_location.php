<?php
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
include '../config/function.php';

$title='Last Position';
$today 			  = date('Y-m-d');
$company_id   = $_SESSION['company_id'];
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
<!--          <h1 class="m-0">Last Position</h1>
-->        </div>
        <!--           <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div> -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <!-- Main content -->
  <section class="content">
  <div class="container-fluid n-form1 p-0">
  	<h3 align="center" class="n-form-titel1 mb-2">Last Location</h3>
    <form  method="post" action="">
      <div class="row">
        <div class="col-md-5">
          <div class="form-group row m-0 pl-3 pr-3 p-1">
            <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label">Date : </label>
            <div class="col-sm-9 p-0">
              <input class="form-control" name="visit_date" type="date" value="<?=$_POST['visit_date']?$_POST['visit_date']:date('Y-m-d');?>" required/>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div class="form-group row m-0 pl-3 pr-3 p-1">
            <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">So Names : </label>
            <div class="col-sm-9 p-0">
              <select class="form-control" name="user_id" required>
                <option value=""></option>
				<? foreign_relation('ss_user','username','concat(username,"-",fname) as fname',$_POST['PBI_ID'],'1 and status="Active"'); ?>
                <? //foreign_relation('ss_user','user_id','fname',$_POST['user_id'],'1'); ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <div class="col-sm-3 pl-0 pr-0 col-form-label">
            <input name="search" type="submit" id="insert" value="Search" class="btn1 btn1-bg-submit"/>
          </div>
        </div>
      </div>
    </form>
  </div>
  <? if(isset($_POST['search'])){ 
  
    $sql = 'SELECT ss_user.fname, ss_user.mobile, ss_user.address, ss_location_log.latitude, ss_location_log.longitude, ss_location_log.access_time AS last_access_time
  FROM ss_location_log
  INNER JOIN ss_user ON ss_location_log.user_id = ss_user.username and ss_user.username="'.$_POST['user_id'].'"
  WHERE DATE(ss_location_log.access_time)="'.$_POST['visit_date'].'"
  ORDER BY id DESC LIMIT 1';

$query = mysqli_query($conn, $sql);

  while ($row = mysqli_fetch_assoc($query)) {

     $latitude = $row['latitude'];
     $longitude = $row['longitude'];
     $shopName=$row['fname'];
    $locations[] = "{lat: $latitude, lng: $longitude}";
    $shop_name[] = $shopName;

 }
}
  ?>
  <style>
    #map {
      height: 400px;
      width: 100%;
    }
  </style>
  <div id="map"></div>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAlikB8yJL0j_2j_ofL0xIHR6WkmAWYBN8&callback=initMap" async defer></script>
  <script>
  <?php if(isset($_POST['search'])): ?>
  function initMap() {
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 13,
      center: <?php echo $locations[0]; ?> // Center the map somewhere
    });

    // Add markers for each location
    <?php foreach($locations as $index => $location): ?>
      new google.maps.Marker({
        position: <?php echo $location; ?>,
        map: map,
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
</div>
<!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>
