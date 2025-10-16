<?php
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
include '../config/function.php';

$title='Individually Tracking Report';
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

    $sql3 = 'select * from ss_location_log where 	user_id="'.$_POST['PBI_ID'].'" AND DATE(access_time)="'.$_POST['visit_date'].'"';
  $query3 = mysqli_query($conn,$sql3);

  $locations = array();
  $locations2 = array();

  while($row = mysqli_fetch_object($query3)){
    if($row->latitude !='' && $row->longitude!=''){
    $latitude = $row->latitude;
    $longitude = $row->longitude;
   
    $locations2[] = "{lat: $latitude, lng: $longitude}";
    }

}
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
            <h1 class="m-0">   Tracking Individual </h1>
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






<form  method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="0">


<tr>
<td style="width: 100px;">Date : </td>
<td><input class="form-control" name="visit_date" type="date" value="<?=$_POST['visit_date']?>" required/></td>

<td>SO List : </td> 
<td>
<select class="form-control" name="PBI_ID" required>
  <option value=""></option>
  <? foreign_relation('ss_user','user_id','concat(username,"-",fname) as fname',$_POST['PBI_ID'],'1 and status="Active"'); ?>
</select>  
</td>

<td>&nbsp;&nbsp;</td>
<td><input name="search" type="submit" id="search" value="Search" class="btn btn-warning" /></td>

</tr> 
</table>
</form>





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
      zoom: 12,
      center: <?php echo $locations2[0] ?? $locations[0]; ?>,
    });

    const trackingPath = [
      <?php echo implode(",", $locations2); ?>
    ];

    // Draw the polyline for the entire tracking path
    const trackingLine = new google.maps.Polyline({
      path: trackingPath,
      geodesic: true,
      strokeColor: "#00B300",
      strokeOpacity: 1.0,
      strokeWeight: 4,
    });
    trackingLine.setMap(map);

    // Place a marker for each tracking point
    trackingPath.forEach((point, index) => {
  let label = "";
  let iconUrl = "http://maps.google.com/mapfiles/ms/icons/orange-dot.png"; // default for intermediate

  if (index === 0) {
    label = "S";
    iconUrl = "http://maps.google.com/mapfiles/ms/icons/green-dot.png"; // start point
  } else if (index === trackingPath.length - 1) {
    label = "E";
    iconUrl = "http://maps.google.com/mapfiles/ms/icons/red-dot.png"; // last point (end)
  }

  new google.maps.Marker({
    position: point,
    map,
    title: `Point ${index + 1}`,
    label: label,
    icon: iconUrl
  });
});


    // Optional: Add shop markers
    const shops = [
      <?php echo implode(",", $locations); ?>
    ];

    shops.forEach((shopLoc) => {
      new google.maps.Marker({
        position: shopLoc,
        map,
        icon: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
        title: "Shop"
      });
    });
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



<script type="text/javascript">

  function FetchItemCategory(id){

    $('#category_id').html('');

    $('#subcategory_id').html('');

    $.ajax({

      type:'post',

      url: 'get_data.php',

      data : { item_group : id},

      success : function(data){

         $('#category_id').html(data);

      }



    })

  }



  function FetchItemSubcategory(id){

    $('#subcategory_id').html('');

    $.ajax({

      type:'post',

      url: 'get_data.php',

      data : { category_id : id},

      success : function(data){

         $('#subcategory_id').html(data);

      }



    })

  }



</script>