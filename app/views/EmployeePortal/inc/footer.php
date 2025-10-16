<?php






?>
<style>
.footer .nav .nav-item.centerbutton .nav-link > span i {
    transform: rotate(-45deg);
    -webkit-transform: rotate(-45deg);
    display: inline-block;
    width: 26px;
    margin-left: -7px;
    margin-top: 17px;
}
</style>
<!-- Footer -->
<footer class="footer">
    <div class="container">
        <ul class="nav nav-pills nav-justified">
		
			<li class="nav-item">
				<a class="nav-link menu-btn">
				      <span>
                        <i class="bi bi-menu-button-wide" style="font-size: 16px; color: #1ae5ef"></i>
                        <span class="nav-text">More</span>
                    </span>
				
				</a>
			</li>
            <li class="nav-item">
                <a class="nav-link <? if ($page == 'home') {
                                        echo 'active';
                                    } ?>" href="../main/home.php">
                    <span>
                        <i class="nav-icon bi bi-speedometer2 size-22"></i>
                        <span class="nav-text">Dashboard</span>
                    </span>
                </a>
            </li>


<!--            <li class="nav-item centerbutton">
                    <a href="attendance.php" class="nav-link" id="centermenubtn">
                        <span class="theme-linear-gradient">
                            <i class="bi bi-camera size-22"></i>
                            <i class="bi bi-basket size-22"></i>
            </span>
            </a>
            </li>-->
            
            <li class="nav-item centerbutton">
                <a id="centermenubtn" class="nav-link <? if ($page == 'attendance') {
                                        echo 'active';
                                    } ?>" href="../main/daily_attendance2.php">
                    <span class="theme-linear-gradient">
                        <i class="nav-icon bi bi-person-bounding-box size-26" style=" font-size: 25px; "></i>
                        <!--<span class="nav-text">Attendance</span>-->
                    </span>
                </a>
            </li>
			
			<li class="nav-item">
                <a class="nav-link <? if ($page == 'Punch_Status') {
                                        echo 'active';
                                    } ?>" href="att_report.php">
                    <span>
                        <i class="nav-icon bi bi-card-checklist size-22"></i>
                        <span class="nav-text">Status</span>
                    </span>
                </a>
            </li>
			
			
            <li class="nav-item">
                <a class="nav-link <? if ($page == 'report_list') {
                                        echo 'active';
                                    } ?>" href="../main/att_location_report.php">
                    <span>
                        <i class="nav-icon bi bi-window-dock size-22"></i>
                        <span class="nav-text">Reports</span>
                    </span>
                </a>
            </li>
        </ul>
    </div>
</footer>


<!-- Footer ends-->

<!-- filter menu -->
<!--<div class="filter">-->
<!--    <div class="card shadow h-100">-->
<!--        <div class="card-header">-->
<!--            <div class="row">-->
<!--                <div class="col align-self-center">-->
<!--                    <h6 class="mb-0">Filter Criteria</h6>-->
<!--                    <p class="text-secondary small">2154 products</p>-->
<!--                </div>-->
<!--                <div class="col-auto px-0">-->
<!--                    <button class="btn btn-link text-danger filter-close">-->
<!--                        <i class="bi bi-x size-22"></i>-->
<!--                    </button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="card-body overflow-auto">-->
<!--            <div class="mb-4">-->
<!--                <h6>Select Range</h6>-->
<!--                <div id="rangeslider" class="mt-4"></div>-->
<!--            </div>-->

<!--            <div class="row mb-4">-->
<!--                <div class="col">-->
<!--                    <div class="form-floating">-->
<!--                        <input type="number" class="form-control" min="0" max="500" value="100" step="1" id="input-select">-->
<!--                        <label for="input-select">Minimum</label>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-auto align-self-center"> to </div>-->
<!--                <div class="col">-->
<!--                    <div class="form-floating">-->
<!--                        <input type="number" class="form-control" min="0" max="500" value="200" step="1" id="input-number">-->
<!--                        <label for="input-number">Maximum</label>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

<!--            <div class="form-floating mb-4">-->
<!--                <select class="form-control" id="filtertype">-->
<!--                    <option selected>Cloths</option>-->
<!--                    <option>Electronics</option>-->
<!--                    <option>Furniture</option>-->
<!--                </select>-->
<!--                <label for="filtertype">Select Shopping Type</label>-->
<!--            </div>-->

<!--            <div class="form-group floating-form-group active mb-4">-->
<!--                <h6 class="mb-3">Select Facilities</h6>-->

<!--                <div class="form-check form-switch mb-2">-->
<!--                    <input type="checkbox" class="form-check-input" id="men" checked>-->
<!--                    <label class="form-check-label" for="men">Men</label>-->
<!--                </div>-->
<!--                <div class="form-check form-switch mb-2">-->
<!--                    <input type="checkbox" class="form-check-input" id="woman" checked>-->
<!--                    <label class="form-check-label" for="woman">Women</label>-->
<!--                </div>-->
<!--                <div class="form-check form-switch mb-2">-->
<!--                    <input type="checkbox" class="form-check-input" id="Sport">-->
<!--                    <label class="form-check-label" for="Sport">Sport</label>-->
<!--                </div>-->
<!--                <div class="form-check form-switch mb-2">-->
<!--                    <input type="checkbox" class="form-check-input" id="homedecor">-->
<!--                    <label class="form-check-label" for="homedecor">Home Decor</label>-->
<!--                </div>-->
<!--                <div class="form-check form-switch mb-2">-->
<!--                    <input type="checkbox" class="form-check-input" id="kidsplay">-->
<!--                    <label class="form-check-label" for="kidsplay">Kid's Play</label>-->
<!--                </div>-->
<!--            </div>-->

<!--            <div class="form-floating mb-3">-->
<!--                <input type="text" class="form-control" placeholder="Keyword">-->
<!--                <label for="input-select">Keyword</label>-->
<!--            </div>-->

<!--            <div class="form-floating mb-3">-->
<!--                <select class="form-control" id="discount">-->
<!--                    <option>10% </option>-->
<!--                    <option>30%</option>-->
<!--                    <option>50%</option>-->
<!--                    <option>80%</option>-->
<!--                </select>-->
<!--                <label for="discount">Offer Discount</label>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="card-footer">-->
<!--            <button class="btn btn-default w-100 shadow-sm shadow-success btn-rounded">Search</button>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!-- filter menu ends-->

<!-- PWA app install toast message -->
<!--<div class="position-fixed bottom-0 start-50 translate-middle-x  z-index-99">-->
<!--    <div class="toast mb-3" role="alert" aria-live="assertive" aria-atomic="true" id="toastinstall" data-bs-animation="true">-->
<!--        <div class="toast-header">-->
<!--            <img src="assets/img/favicon32.png" class="rounded me-2" alt="...">-->
<!--            <strong class="me-auto">Install PWA App</strong>-->
<!--            <small>now</small>-->
<!--            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>-->
<!--        </div>-->
<!--        <div class="toast-body">-->
<!--            <div class="row">-->
<!--                <div class="col">-->
<!--                    Click "Install" to install PWA app & experience indepedent.-->
<!--                </div>-->
<!--                <div class="col-auto align-self-center ps-0">-->
<!--                    <button class="btn-default btn btn-sm btn-rounded" id="addtohome">Install</button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!-- Required jquery and libraries -->
<script src="../assets/js/jquery-3.3.1.min.js"></script>
<script src="../assets/js/popper.min.js"></script>
<script src="../assets/vendor/bootstrap-5/js/bootstrap.bundle.min.js"></script>

<!-- Customized jquery file  -->
<script src="../assets/js/new-script.js"></script>
<script src="../assets/js/main.js"></script> 
<script src="../assets/js/color-scheme.js"></script>

<!-- Chart js script -->
<script src="../assets/vendor/chart-js-3.3.1/chart.min.js"></script>

<!-- Progress circle js script -->
<script src="../assets/vendor/progressbar-js/progressbar.min.js"></script>

<!-- swiper js script -->
<script src="../assets/vendor/swiperjs-6.6.2/swiper-bundle.min.js"></script>

<!-- daterange picker script -->
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="../assets/vendor/daterangepicker/daterangepicker.js"></script>

<!-- nouislider js -->
<script src="../assets/vendor/nouislider/nouislider.min.js"></script>

<!-- PWA app service registration and works -->
<!--<script src="assets/js/pwa-services.js"></script>-->

<!-- page level custom script -->
<script src="../assets/js/app.js"></script>

</body>

</html>