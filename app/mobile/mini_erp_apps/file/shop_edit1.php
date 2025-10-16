<?php

session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$today = date('Y-m-d');

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$shpo_id = $_GET['shop_id'];
$shop_Search_sql = 'select * from ss_shop where dealer_code="' . $shpo_id . '"';
$shop_Search_query = mysqli_query($conn, $shop_Search_sql);
$shop_details_data = mysqli_fetch_object($shop_Search_query);

$table_master = 'ss_shop';
$unique_master = 'dealer_code';
require_once '../assets/template/inc.header.php';

$page = "shop_edit.php";
$title = "Shop Information";



if (isset($_REQUEST['submit']) && $_POST['randcheck'] == $_SESSION['rand']) {



    // check mobile number
    $check_mobile = find1("select mobile from ss_shop where mobile='" . $_POST['mobile'] . "' and dealer_code !='" . $shpo_id . "' ");
    if ($check_mobile == '') {


        $_POST['status'] = '1';
        $_POST['entry_by'] = $username;
        $_POST['emp_code'] = $username;
        $_POST['entry_at'] = date('Y-m-d H:i:s');

        // image upload
        $ff = $username . '_' . time();
        $target_dir = "uploads/";
        $file_name = $target_dir . '' . $ff;
        if ($_FILES["fileToUpload"]["name"] != '') {
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
        }
        // end image upload

        if ($uploadOk == 0) {
            $file_name = '';
        }

        $_POST['picture'] = $file_name;
        $_POST['picture_sm'] = $image_sm;
        $_POST['master_dealer_code'] = $shop_details_data->master_dealer_code;
        $_POST['shop_name'];

        $crud   = new crud($table_master);
        $crud->update($unique_master);

        $msg = "Shop Update Success";
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
<style>
    .btn-right {
        float: right;
    }

    .modal-body {
        max-height: 550px;
        /* Adjust this value as needed */
        overflow-y: auto;
    }
</style>
<!-- start of Page Content-->
<div class="page-content header-clear-medium">

    <div class="card card-style">

        <form class="" method="post" action="" enctype="multipart/form-data">
            <?php $rand = rand();
            $_SESSION['rand'] = $rand; ?>
            <input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />
            <input type="hidden" name="dealer_code" value="<?= $shpo_id ?>" />
            <div class="content">

                <!-- <div class="input-style input-style-always-active  has-borders no-icon mb-4"> -->
                <div class="row mb-0">
                    <div class="col-6">
                        <label for="region_id">Region</label>
                        <select class="form-select form-control-round" name="region_id" id="region_id">
                            <option value="<?= $_SESSION['region_id'] ?>">
                                <?= find1("select BRANCH_NAME from branch where BRANCH_ID='" . $shop_details_data->region_id . "' "); ?>
                            </option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="zone_id"> Zone</label>
                        <select class="form-select form-control-round" name="zone_id" id="zone_id">
                            <option value="<?= $_SESSION['zone_id'] ?>">
                                <?= find1("select ZONE_NAME from zon where ZONE_CODE='" . $shop_details_data->zone_id . "' "); ?>
                            </option>
                        </select>
                    </div>
                </div>

                <!-- <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em> -->
                <!-- </div> -->




                <!-- <div class="input-style input-style-always-active  has-borders no-icon mb-4"> -->

                <!-- <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div> -->


                <!-- <div class="input-style input-style-always-active  has-borders no-icon mb-4"> -->
                <div class="row mb-0">
                    <div class="col-6">
                        <label for="area_id"> Area</label>
                        <select class="form-select form-control-round" name="area_id" id="area_id">
                            <option value="<?= $_SESSION['area_id'] ?>">
                                <?= find1("select AREA_NAME from area where AREA_CODE='" . $shop_details_data->area_id . "' "); ?>
                            </option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="route_id"> Route</label>
                        <select class="form-select form-control-round" name="route_id" id="route_id" required>
                            <option value="<?= $shop_details_data->route_id ?>"> <?= find1("select route_name from ss_route where route_id='" . $shop_details_data->route_id . "' "); ?></option>
                            <? optionlist("select route_id,route_name from ss_route where area_id='" . $_SESSION['area_id'] . "'"); ?>
                        </select>
                    </div>
                </div>

                <!-- <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div> -->



                <!-- <div class="input-style input-style-always-active  has-borders no-icon mb-4"> -->

                <!-- <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div> -->
                <label for="shop_name"> Shop Name</label>
                <input type="text" class="form-control-round" name="shop_name" id="shop_name" value="<?= $shop_details_data->shop_name ?>"
                    required>

                <!-- <div class="input-style input-style-always-active  has-borders no-icon mb-4"> -->
                <div class="row mb-0">
                    <div class="col-6">
                        <label for="shop_owner_name">Owner Name</label>
                        <input type="text" class="form-control-round" name="shop_owner_name" id="shop_owner_name"
                            value="<?= $shop_details_data->shop_owner_name ?>" required>
                    </div>
                    <div class="col-6">
                        <label for="mobile">Owner Mobile <span style="color:red;">(Must be
                                Unique)</span></label>
                        <input type="number" min="8800000000000" max="8899999999999" step="1"
                            class="form-control-round" name="mobile" id="mobile" value="<?= $shop_details_data->mobile ?>" required>
                    </div>
                </div>

                <!-- <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div> -->


                <!-- <div class="input-style input-style-always-active  has-borders no-icon mb-4"> -->
                <label for="shop_address"> Full Address</label>
                <input type="text" class="form-control-round" name="shop_address" id="shop_address" value="<?= $shop_details_data->shop_address ?>"
                    required>
                <!-- <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div> -->

                <!-- <div class="input-style input-style-always-active  has-borders no-icon mb-4"> -->

                <!-- <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div> -->
                <!-- <div class="input-style input-style-always-active  has-borders no-icon mb-4"> -->

                <!-- <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div> -->

                <!-- <div class="input-style input-style-always-active  has-borders no-icon mb-4"> -->

                <div class="row mb-0">
                    <div class="col-6">
                        <label for="manager_name"> Manager Name</label>
                        <input type="text" class="form-control-round" name="manager_name" id="manager_name" value="<?= $shop_details_data->manager_name ?>"
                            required>
                    </div>
                    <div class="col-6">
                        <label for="manager_mobile">Manager Mobile</label>
                        <input type="number" class="form-control-round" name="manager_mobile" id="manager_mobile"
                            value="<?= $shop_details_data->manager_mobile ?>">
                    </div>
                </div>

                <!-- <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div> -->

                <!-- <div class="input-style input-style-always-active  has-borders no-icon mb-4"> -->

                <!-- <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div> -->
                <!-- <div class="input-style input-style-always-active  has-borders no-icon mb-4"> -->
                <div class="row mb-0">
                    <div class="col-6">
                        <label for="shop_identity">Shop Identity</label>
                        <select class="form-control-round" name="shop_identity" required>
                            <option value="<?= $shop_details_data->shop_identity ?>"><?= $shop_details_data->shop_identity ?></option>
                            <option><?= $show2->shop_identity ? $show2->shop_identity : 'Other' ?></option>
                            <option>MEP</option>
                            <option>Other</option>

                        </select>
                    </div>
                    <div class="col-6">
                        <label for="shop_class">Shop Class</label>
                        <select class="form-control-round" name="shop_class" required>
                            <option value="<?= $shop_details_data->shop_class ?>"></option>
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

                <!-- <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div> -->

                <!-- <div class="input-style input-style-always-active  has-borders no-icon mb-4"> -->

                <!-- <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div> -->

                <!-- <div class="input-style input-style-always-active  has-borders no-icon mb-4"> -->
                <div class="row mb-0">
                    <div class="col-6">
                        <label for="shop_type">Shop Type</label>
                        <select class="form-control-round" name="shop_type" required>
                            <option value="<?= $shop_details_data->shop_type ?>"></option>
                            <option><?= $show2->shop_type ?></option>
                            <option>Retailer</option>
                            <option>WholeSale</option>
                            <option>Semi WholeSaler</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="shop_channel"> Shop Channel</label>
                        <select class="form-control-round" name="shop_channel" required>
                            <option value="<?= $shop_details_data->shop_channel ?>"></option>
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

                <!-- <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div> -->


                <!-- <div class="input-style input-style-always-active  has-borders no-icon mb-4"> -->

                <!-- <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div> -->


                <!-- <div class="input-style input-style-always-active  has-borders no-icon mb-4"> -->
                <label for="shop_route_type">Shop Route Type</label>
                <select class="form-control-round" name="shop_route_type" required>
                    <option value="<?= $shop_details_data->shop_route_type ?>"></option>
                    <option><?= $show2->shop_route_type ?></option>
                    <option>Bazar</option>
                    <option>Outsite Bazar</option>
                </select>
                <!-- <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div> -->

                <!-- <div class="input-style input-style-always-active  has-borders no-icon mb-4"> -->
                <div class="row mb-0">
                    <div class="col-6">
                        <label for="latitude">Latitude</label>
                        <input type="text" class="form-control-round" name="latitude" id="latitude" value=""
                            readonly="" required="required">
                    </div>
                    <div class="col-6">
                        <label for="longitude">Longitude</label>
                        <input type="text" class="form-control-round" name="longitude" id="longitude" value=""
                            readonly="" required="required">
                    </div>
                </div>

                <!-- <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div> -->

                <!-- <div class="input-style input-style-always-active  has-borders no-icon mb-4"> -->

                <!-- <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div> -->

                <!-- <div class="input-style input-style-always-active  has-borders no-icon mb-4"> -->
                <label for="fileToUpload">Image</label>
                <input type="file" name="fileToUpload" id="fileToUpload" autocomplete="off"
                    value="<?= $show->picture ?>" class="form-control-round form-control">
                <!-- <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div> -->




                <div class="col-12 d-grid">
                    <input name="submit" type="submit" value="Update Shop" class="btn btn-3d btn-m btn-full mb-3 mt-3 rounded-xs  font-900  btn-primary w-100" />

                </div>
        </form>
    </div>
</div>
</div>
</div>




</div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Shop List</h5>
            </div>
            <div class="modal-body">
                <div class="main-container container">



                    <!-- User list items  -->
                    <div class="row">



                        <?php
                        $sql = "SELECT s.dealer_code, CONCAT(r.route_name, '-', s.shop_name) AS shop_name, s.shop_address
          FROM ss_shop s
          JOIN ss_route r ON s.route_id = r.route_id
          WHERE s.status = '1' 
          AND s.emp_code = '" . $_SESSION['username'] . "'
          ORDER BY r.route_id, s.shop_name";

                        // $query=mysqli_query($conn, $sql);
                        $query = mysqli_query($conn, $sql);
                        while ($data = mysqli_fetch_object($query)) {
                        ?>
                            <div class="col-12">
                                <div class="card shadow-sm mb-2">
                                    <ul class="list-group list-group-flush bg-none">
                                        <li class="list-group-item border-0">
                                            <a href="#">
                                                <div class="row">
                                                    <div class="col-auto">
                                                        <div class="card">
                                                            <div class="card-body p-0">
                                                                <figure class="avatar avatar-50 rounded-15">
                                                                    <img src="assets/img/user1.jpg" alt="">
                                                                </figure>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col px-0">
                                                        <p class="mb-0">Shop Name: <?= $data->shop_name ?><br><small class="text-secondary">Address: <?= $data->shop_address ?></small></p>
                                                    </div>
                                                    <!--<div class="col-auto text-end">
                        <p class="text-secondary text-muted size-10 mb-0">test</p>
                        <p class="text-info">
                            <strong> test</strong>
                        </p>
                    </div>-->
                                                </div>
                                            </a>
                                        </li>

                                    </ul>

                                </div>
                            </div>
                        <? } ?>
                    </div>




                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div>
    </div>
</div>



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
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</main>
<!-- Page ends-->
<? require_once '../assets/template/inc.footer.php'; ?>