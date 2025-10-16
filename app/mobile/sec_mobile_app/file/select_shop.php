<?php 

session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Select Shop";
$page = "new_shop.php";


require_once '../assets/template/inc.header.php';


$today = date('Y-m-d');

$user_id = $_SESSION['user_id'];
$username = $_SESSION['user']['username'];
$product_group	=$_SESSION['product_group'];
$region_id	=$_SESSION['region_id'];
$zone_id	=$_SESSION['zone_id'];
$area_id	=$_SESSION['area_id'];


if(isset($_REQUEST['check_shop']) && $_POST['randcheck']==$_SESSION['rand']){


if($_POST['dealer_code']>0){

    redirect('do_route.php?pal=2&party='.$_POST['dealer_code'].'&new=3'); 
            

}else{
    echo 'Select Shop First';
}



} 

//echo "select s.route_id,r.route_name from ss_route r, ss_shop s where s.route_id=r.route_id and s.emp_code='".$_SESSION['user']['username']."' group by s.route_id order by route_name";


?>


    

<!-- start of Page Content-->  
<div class="page-content header-clear-medium">


		
		

<div class="card card-style">
			 <form method="post" action="" enctype="multipart/form-data">
			      <?php $rand=rand(); $_SESSION['rand']=$rand; ?>
					<input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />   
				<div class="content">
			<?  "select s.route_id,r.route_name 
									from ss_route r, ss_shop s where s.route_id=r.route_id and s.emp_code='".$_SESSION['user']['username']."' group by s.route_id order by route_name";?>
					<!-- <div class="input-style input-style-always-active  has-borders no-icon mb-4"> -->
						<label for="region_id">Route</label>						
				
								<select class="form-select form-control" name="route_id" id="route_id" onchange="FetchShopList(this.value)">
									<? if($_POST['route_id']>0){ ?>
										<option value="<?=$_POST['route_id']?>"><?=find1("select route_name from ss_route where route_id='".$_POST['route_id']."'");?></option>
									<? }else{ ?>
									<option></option>
									<? } ?>
									<? optionlist("select s.route_id,r.route_name 
									from ss_route r, ss_shop s where s.route_id=r.route_id and s.emp_code='".$_SESSION['user']['username']."' group by s.route_id order by route_name");?>
								</select> 
						<!-- <span><i class="fa fa-chevron-down"></i></span>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<i class="fa fa-check disabled invalid color-red-dark"></i>
						<em></em> -->
					<!-- </div> -->
					
					<!-- <div class="input-style input-style-always-active  has-borders no-icon mb-4"> -->
						<label for="zone_id">Shop</label>						
								  <select class="form-select form-control" name="dealer_code" id="dealer_code" reqired onChange="getData()">
									<option></option>
									<? //optionlist('select dealer_code,shop_name from ss_shop where status="1" and region_id="'.$region_id.'" and zone_id="'.$zone_id.'" and area_id="'.$area_id.'" order by shop_name'); ?>
									<? if($_POST['route_id']>0){
										optionlist('select dealer_code,shop_name from ss_shop where status="1" 
										and region_id="'.$region_id.'" and zone_id="'.$zone_id.'" and area_id="'.$area_id.'" and route_id="'.$_POST['route_id'].'" order by shop_name');
									}?>
								</select>
						<!-- <span><i class="fa fa-chevron-down"></i></span>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<i class="fa fa-check disabled invalid color-red-dark"></i>
						<em></em> -->
					<!-- </div> -->
				
					
					
					
					<div class="d-flex justify-content-center row mt-3">
						<div class="col-6">
						<input type="submit" name="check_shop" class="b-n btn btn-success btn-3d btn-block  text-light w-100 py-3" value="Go" />							
						</div>
					</div>
				</div>
			</form>
            </div>
			</div>
			






    <!-- End of Page Content--> 
    
 

<?php 
 require_once '../assets/template/inc.footer.php';
 ?>
 

 <!-- main page content ends -->
<script>
// var x = document.getElementById("demo");
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}
function showPosition(position) {
//   x.innerHTML = "Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude;
  
  document.getElementById("latitude").value = position.coords.latitude;
  document.getElementById("longitude").value = position.coords.longitude;
  
}

getLocation();
</script>

<script>
function getData(){
    
var id = document.getElementById("dealer_code").value;

		jQuery.ajax({
			url:'ajax_location.php',
			type:'post',
			data:'id='+id,
			success:function(result){
				var json_data=jQuery.parseJSON(result);

				jQuery('#latitude2').val(json_data.lat2);
				jQuery('#longitude2').val(json_data.long2);

			}

		})
	
}
</script> 

<script>
function FetchShopList(id){
    $('#dealer_code').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { route_id : id},
      success : function(data){
         $('#dealer_code').html(data);
      }

    })
  }

</script> 
