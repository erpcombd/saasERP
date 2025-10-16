<?php

session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Shop Information";
$page = "new_shop.php";


require_once '../assets/template/inc.header.php';


$today = date('Y-m-d');

$user_id = $_SESSION['user_id'];
$username = $_SESSION['user']['username'];


if (isset($_REQUEST['submit']) && $_POST['randcheck'] == $_SESSION['rand']) {
    // check mobile number
    // print_r($_POST);
    // exit;
    $check_mobile = find1("select mobile from ss_shop where mobile='" . $_POST['mobile'] . "' ");
    if ($check_mobile == '') {
        $_POST['status'] = '1';
        $_POST['entry_by'] = $username;
        $_POST['emp_code'] = $username;
        $_POST['entry_at'] = date('Y-m-d H:i:s');

        // image upload
        $ff = $username . '_' . time();
        $target_dir = "uploads/";
        $file_name = $target_dir . '' . $ff;

        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 26214400000) {
            echo "Sorry, your file is too large.<br>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
            //echo "Sorry, your given file type is not allowed.<br>";
            $uploadOk = 0;
            $image_ok = 0;
        }

        $file_name = $file_name . '.' . $imageFileType;

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.<br>";

            // if everything is ok, try to upload file
        } else {

            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file_name)) {


                // -------------------------------------   Start image small size	------------------------------------

                // $file = getimagesize($file_name);

                // $split = explode(".",$file_name);
                // $new_name = $split[0];
                // $image_sm = $new_name.'_sm.jpg';

                // header('Content-Type: image/jpeg');

                // 				list($width,$height)= getimagesize($file_name);
                // 				$nwidth=$width/4;
                // 				$nheight=$height/4;
                // 				$newimage = imagecreatetruecolor($nwidth,$nheight);

                // 					if($file['mime']=="image/jpeg"){
                // 						$source=imagecreatefromjpeg($file_name);
                // 					}elseif($file['mime']=="image/png"){
                // 						$source=imagecreatefrompng($file_name);
                // 					}elseif($file['mime']=="image/jpg"){
                // 						$source=imagecreatefromjpg($file_name);
                // 					}

                // 				imagecopyresized($newimage,$source,0,0,0,0,$nwidth,$nheight,$width,$height);
                // 				imagejpeg($newimage,$image_sm);

                // end image small process	           
                echo "Picture has been uploaded.<br>";
            } else {
                echo "Sorry, there was an error uploading your file.<br>";
            }
        }
        // end image upload
        if ($uploadOk == 0) {
            $file_name = '';
        }

        $_POST['picture'] = $file_name;
        $_POST['picture_sm'] = $image_sm;
        $_POST['master_dealer_code'] = $_SESSION['user']['warehouse_id'];
        @insert('ss_shop');

        $msg = "New Shop Registration Success";
        //redirect("home.php");
?>
        <script>
            window.location.href = "../main/home.php";
        </script>
<?



    } else {
        echo 'Sorry your given Mobile number alerady in our Database. So, Please check';
    }
}


?>




<!-- start of Page Content-->
<div class="page-content header-clear-medium">

    <div class="container m-0">
        <div class="row m-0">
            <div class="d-flex">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
                    See Shop List
                </button>
            </div>
        </div>
    </div>

    <div class="card card-style m-0">
        <form method="post" action="" enctype="multipart/form-data">
            <?php $rand = rand();
            $_SESSION['rand'] = $rand; ?>
            <input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />
            <div class="content">
                <div class="row mb-0">
                    <div class="col-6">
                        <label for="region_id">Region</label>
                        <select name="region_id" id="region_id" class="form-control">
                            <option value="<?= $_SESSION['user']['region_id'] ?>">
                                <?= find1("select BRANCH_NAME from branch where BRANCH_ID='" . $_SESSION['user']['region_id'] . "' "); ?>
                            </option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="zone_id">Zone</label>
                        <select name="zone_id" id="zone_id" class="form-control">
                            <option value="<?= $_SESSION['user']['zone_id'] ?>">
                                <?= find1("select ZONE_NAME from zon where ZONE_CODE='" . $_SESSION['user']['zone_id'] . "' "); ?>
                            </option>
                        </select>
                    </div>

                </div>

                <div class="row mb-0">
                    <div class="col-6">
                        <label for="area_id">Area</label>
                        <select name="area_id" id="area_id" class="form-control">
                            <option value="<?= $_SESSION['user']['area_id'] ?>">
                                <?= find1("select AREA_NAME from area where AREA_CODE='" . $_SESSION['user']['area_id'] . "' "); ?>
                            </option>
                        </select>
                    </div>


                    <div class="col-6">
                        <label for="route_id">Route Name <span class="text-danger">*</span></label>
                        <select name="route_id" id="route_id" required class="form-control" required>
                            <option></option>
                            <? optionlist("select route_id,route_name from ss_route where area_id='" . $_SESSION['user']['area_id'] . "'"); ?>
                        </select>
                    </div>
                </div>


                <label for="shop_name">Shop Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control validate-text" name="shop_name" id="shop_name" value="" required placeholder="Shop Name">

                <label for="shop_address">Shop Address <span class="text-danger">*</span></label>
                <textarea name="shop_address" id="shop_address" placeholder="Full Address" required class="form-control"></textarea>

                <div class="row mb-0">
                    <div class="col-6">
                        <label for="shop_owner_name">Owner Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control validate-text" name="shop_owner_name" id="shop_owner_name" value="" placeholder="Owner Name" required>
                    </div>
                    <div class="col-6">
                        <label for="mobile">Owner Mobile <span class="text-danger">*</span></label>
                        <span style="color:#FF0000; zoom: 45%;"> (Must be Unique)</span>
                        <input type="number" min="8800000000000" max="8899999999999" step="1" name="mobile" id="mobile" value="8801" required class="form-control validate-text" placeholder="Owner Mobile">

                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-6">
                        <label for="manager_name">Manager Name</label>
                        <input type="text" class="form-control validate-text" name="manager_name" id="manager_name" value="" placeholder="Manager Name" required>
                    </div>
                    <div class="col-6">
                        <label for="mobile">Manager Mobile</label>
                        <input type="number" class="form-control validate-text" name="manager_mobile" id="manager_mobile" value="8801" placeholder="Manager Mobile">
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-6">
                        <label for="electrician_name">Electrician Name </label>
                        <input type="text" class="form-control validate-text" name="electrician_name" id="electrician_name" placeholder="Electrician Name" required>
                    </div>
                    <div class="col-6">
                        <label for="mobile">Electrician Mobile No.</label>
                        <input type="number" class="form-control validate-text" name="electrician_mobile_no" id="electrician_mobile_no" value="8801" placeholder="Electrician mobile no" required>
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-6">
                        <label for="">Shop Identity <span class="text-danger">*</span></label>
                        <select name="shop_identity" required class="form-control">
                            <option><?= $show2->shop_identity ? $show2->shop_identity : 'Other' ?></option>
                            <option>MEP</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="">Shop Class <span class="text-danger">*</span></label>

                        <select name="shop_class" required class="form-control">
                            <option><?= $show2->shop_class ?></option>
                            <option>Gold 50000 to 100000</option>
                            <option>Diamond 100000 to 150000</option>
                            <option>Silver 25000 to 50000</option>
                            <option>Platinum Plus 200000 to above</option>
                            <option>Bronze 1 to 25000</option>
                            <option>Platinum 150000 to 200000</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-6">
                        <label for="">Shop Type <span class="text-danger">*</span></label>
                        <select name="shop_type" required class="form-control">
                            <option><?= $show2->shop_type ?></option>
                            <option>Retailer</option>
                            <option>WholeSale</option>
                            <option>Semi WholeSaler</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="">Shop Channel <span class="text-danger">*</span></label>
                        <select name="shop_channel" required class="form-control">
                            <option><?= $show2->shop_channel ?></option>
                            <option>Electric</option>
                            <option>Electronics</option>
                            <option>Stationary</option>
                            <option>Departmental Store</option>
                            <option>Grosary </option>
                            <option>Hardware</option>
                            <option>Library</option>
                            <option>Pharmacy</option>
                        </select>
                    </div>
                </div>

                <!-- <div class="input-style input-style-always-active  has-borders no-icon mb-4"> -->

                <!-- <span><i class="fa fa-chevron-down"></i></span>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<i class="fa fa-check disabled invalid color-red-dark"></i>
						<em>(required)</em>
					</div> 
					 -->

                <label for="">Shop Route Type <span class="text-danger">*</span></label>
                <select name="shop_route_type" required class="form-control">
                    <option><?= $show2->shop_route_type ?></option>
                    <option>Bazar</option>
                    <option>Outsite Bazar</option>
                </select>

                <label for="cluster_market_name">Cluster Market Name</label>
                <input type="text" class="form-control validate-text" name="cluster_market_name" id="cluster_market_name" value="" required placeholder="Enter cluster market name" required>

                <div class="row mb-0">
                    <div class="col-6">
                        <label for="latitude">Latitude</label>
                        <input type="text" class="form-control" name="latitude" id="latitude" value="" readonly="" required="required">
                    </div>
                    <div class="col-6">
                        <label for="longitude">Longitude</label>
                        <input type="text" class="form-control validate-text" name="longitude" id="longitude" value="" readonly="" required="required">
                    </div>
                </div>
                <label for="fileToUpload">Image <span class="text-danger">*</span></label>
                <input type="file" name="fileToUpload" id="fileToUpload" autocomplete="off" value="<?= $show->picture ?>" required class="form-control">

                <div class="d-flex justify-content-center row mt-3">
                    <div class="col-6">
                        <input type="submit" name="submit" class="b-n btn btn-success btn-3d btn-block  text-light w-100 py-3" value="Add New" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>



<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Shop List</h5>
            </div>
            <div class="modal-body">
                <div class="main-container container p-0" style=" overflow: auto; ">
                    <!--User list items-->
                    <?php
                    $sql = "SELECT s.dealer_code, CONCAT(r.route_name, '-', s.shop_name) AS shop_name, s.shop_address,s.picture
                            FROM ss_shop s
                            JOIN ss_route r ON s.route_id = r.route_id
                            WHERE s.status = '1' 
                            AND s.emp_code = '" . $_SESSION['user']['username'] . "'
                            ORDER BY r.route_id, s.shop_name";
                    // $query=mysqli_query($conn, $sql);
                    $query = mysqli_query($conn, $sql);
                    while ($data = mysqli_fetch_object($query)) {
                    ?>
                        <!-- <a href="shop_edit.php?shop_id=<?= $data->dealer_code ?>">
                            <div class="card card-style mb-3 ms-0 me-0">
                                <div class="content m-3">
                                    <div class="d-flex pb-2">
                                        <div class="align-self-center pe-3">
                                            <img src=" <?= $data->picture ?>" width="38" class="rounded-xl">
                                        </div>
                                        <div class="align-self-center">
                                            <h2 class="font-700 mb-0">Shop Name: <?= $data->shop_name ?></h2>
                                            <p class="mb-n2 mt-n1 font-700 font-11 text-uppercase color-highlight">Address: <?= $data->shop_address ?></p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </a>-->

                        <div class="card card-style card-bg m-0 mb-2" style="background-color: #f6f6f6 !important;">
                            <div class="content m-2 ">
                                <div class="d-flex pb-0">
                                    <div class="align-self-center pe-3 challan-i">
                                        <i class="fa-thin fa-shop"></i>
                                        <!--<img src=" <?= $data->picture ?>" width="38" class="rounded-xl">-->
                                    </div>
                                    <div class="align-self-center">
                                        <h2 class="font-700 mb-0 f-14"><span class="text-span">Shop Name: </span> <?= $data->shop_name ?></h2>
                                        <h2 class="font-700 mb-0 f-12"><span class="text-span">Address: </span> <span class="color-highlight"><?= $data->shop_address ?></span></h2>

                                    </div>
                                    <div class="align-self-center ms-auto">
                                        <div class="d-flex gap-2 justify-content-end align-items-center">
                                            <div class="w-100">
                                                <a href="shop_edit.php?shop_id=<?= $data->dealer_code ?>">
                                                    <button class="b-n btn btn-info btn-3d btn-block p-2 mb-1  text-light w-100" style=" height: 35px !important; padding-top: 5px !important;"><i class="fa-light fa-pen-to-square"></i></button>
                                                </a>
                                            </div>

                                        </div>

                                        <!-- <p class="m-0 p-0">339.45</p> -->

                                    </div>
                                </div>
                            </div>
                        </div>


                    <? } ?>




                </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>


        </div>
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

    //getLocation();
    window.onload = getLocation;
</script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>