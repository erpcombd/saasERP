<?php
session_start ();
include ("config/access_admin.php");
include ("config/db.php");
include 'config/function.php';


$today 			  = date('Y-m-d');
$company_id   = $_SESSION['company_id'];
$menu 			  = 'Visit';
$sub_menu 		= 'view_visit_schedule';

// $google_api = find1("select map_api from ss_config where id=1");
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
  
//   // echo '<script>alert("' .$sql. '");</script>';
// //  echo '<script>alert("'.$sql.'");</script>';
// }
if(isset($_GET['lat']) && $_GET['lat'] > 0){
    $locations = array();
    $shop_name = array();
    $latitude = $_GET['lat'];
    $longitude = $_GET['long'];
    $locations[] = "{lat: $latitude, lng: $longitude}";



}

?>



<?php
include 'inc/header.php';
include 'inc/sidebar.php';
?>  



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">New</h1>
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
      <div class="container-fluid">












<style>
    #map {
      height: 400px;
      width: 100%;
    }
  </style>

  <div id="map"></div>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBesXXt7OdJx2wz7Q3REhPvqgLLKCWYSWI&callback=initMap" async defer></script>

 <script>
const secondRouteCoords1 = [
    {lat: 23.859699258017077, lng: 90.35912946783058},
    {lat: 23.858043303891353, lng: 90.3611146084902},
    {lat: 23.857159800996328, lng: 90.36653598002258}
];



      const secondRouteCoords = [
        {lat: 23.827253919162743, lng: 90.36438198356208},
        {lat: 23.840499451863728, lng: 90.3573505473924},
        {lat: 23.859657206493804, lng: 90.36504517646804}
    ];

  <?php if(isset($_GET['lat']) && $_GET['lat'] > 0): ?>
  function initMap() {
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 13,
      center: <?php echo $locations[0]; ?> // Center the map somewhere
    });

    // Add markers for each location
    <?php foreach($locations as $index => $location): ?>
      new google.maps.Marker({
        position: <?php echo $location; ?>,
        map: map

      });
    <?php endforeach; ?>







  }
  <?php endif; ?>
</script>



      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 


<?php
include 'inc/footer.php';
?>  