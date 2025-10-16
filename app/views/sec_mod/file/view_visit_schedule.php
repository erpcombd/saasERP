<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

include '../config/function.php';
$title='New';	
$today 			  = date('Y-m-d');
$company_id   = $_SESSION['company_id'];
$menu 			  = 'Visit';
$sub_menu 		= 'view_visit_schedule';

$google_api = find1("select map_api from ss_config where id=1");
// if(isset($_POST['search'])){
//     $sql='select * from ss_schedule where PBI_ID="'.$_POST['PBI_ID'].'" and date="'.$_POST['visit_date'].'"';
//     $query = mysqli_query($conn,$sql);
//     $row = mysqli_fetch_object($query);
   
//     $sql2='select * from ss_shop where route_id="'.$row->route_id.'"';
//     $query2 = mysqli_query($conn,$sql2);

// while($row = mysqli_fetch_object($query2)){
//   $latitude	= $row->latitude;
//   $longitude	= $row->longitude;

  
// }
  
//   // echo '<script>alert("' .$sql. '");<script>';
// //  echo '<script>alert("'.$sql.'");<script>';
// }
if(isset($_POST['search'])){
  $sql = 'select * from ss_schedule where PBI_ID="'.$_POST['PBI_ID'].'" and date="'.$_POST['visit_date'].'"';
  $query = mysqli_query($conn,$sql);
  $row = mysqli_fetch_object($query);

  $sql2 = 'select * from ss_shop where route_id="'.$row->route_id.'"';
  $query2 = mysqli_query($conn,$sql2);

  $locations = array();
  $shop_name = array();
  while($row = mysqli_fetch_object($query2)){
      $latitude = $row->latitude;
      $longitude = $row->longitude;
      $shopName=$row->shop_name;
      $locations[] = "{lat: $latitude, lng: $longitude}";
      $shop_name[] = $shopName;

  }
}

?>





  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!--<h1 class="m-0">New</h1>-->
          </div>
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
      <div class="container-fluid n-form1 p-0 mb-2">
	  
	  <form  method="post" action="">
	  	<h3 align="center" class="n-form-titel1 mb-2">New</h3>
        <div class="row"> 
            <div class="col-md-5">
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label">Date : </label>
                    <div class="col-sm-9 p-0">
                        <input class="form-control" name="visit_date" type="date" value="<?=$_POST['visit_date']?>" required/>
                    </div>
                </div>
				</div>

 <div class="col-md-5">
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">SP List :	</label>
                    <div class="col-sm-9 p-0">
                        <select class="form-control" name="PBI_ID" required>
  <option value=""></option>
  <? foreign_relation('ss_user','username','concat(username,"-",fname) as fname',$_POST['PBI_ID'],'1 and status="Active"'); ?>
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
      zoom: 7,
      center: <?php echo $locations[0]; ?> // Center the map somewhere
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
    directionsService.route({
      origin: waypoints[0].location,
      destination: waypoints[waypoints.length - 1].location,
      waypoints: waypoints.slice(1, waypoints.length - 1),
      travelMode: google.maps.TravelMode.DRIVING,
    }, function(response, status) {
      if (status === 'OK') {
        directionsRenderer.setDirections(response);
      } else {
        window.alert('Directions request failed due to ' + status);
      }
    });
  }
  <?php endif; ?>
</script>



      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 


<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>  