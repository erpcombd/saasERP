<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Chalan List";
$page = "chalan_list.php";
$username = $_SESSION['user']['username'];
$emp_code = $username;

// Save filter options in session when form is submitted
if(isset($_POST['submitit'])) {
    $_SESSION['chalan_filters'] = [
        'fdate' => $_POST['fdate'] ?: date('Y-m-01'),
        'tdate' => $_POST['tdate'] ?: date('Y-m-d'),
        'route_id' => $_POST['route_id'] ?: '',
        'dealer_code' => $_POST['dealer_code'] ?: '',
        'submitted' => true
    ];
}

// Get values from POST or session or default
$fdate = isset($_POST['fdate']) ? $_POST['fdate'] : (isset($_SESSION['chalan_filters']['fdate']) ? $_SESSION['chalan_filters']['fdate'] : date('Y-m-01'));
$tdate = isset($_POST['tdate']) ? $_POST['tdate'] : (isset($_SESSION['chalan_filters']['tdate']) ? $_SESSION['chalan_filters']['tdate'] : date('Y-m-d'));
$route_id = isset($_POST['route_id']) ? $_POST['route_id'] : (isset($_SESSION['chalan_filters']['route_id']) ? $_SESSION['chalan_filters']['route_id'] : '');
$dealer_code = isset($_POST['dealer_code']) ? $_POST['dealer_code'] : (isset($_SESSION['chalan_filters']['dealer_code']) ? $_SESSION['chalan_filters']['dealer_code'] : '');
$submitted = isset($_POST['submitit']) || (isset($_SESSION['chalan_filters']['submitted']) && $_SESSION['chalan_filters']['submitted']);

require_once '../assets/template/inc.header.php';
?>

<div class="page-content header-clear-medium">
    <form action="" method="post" name="codz" id="codz">
        <div class="card card-style">
            <div class="content mt-0 ms-0 me-0">
                <label for="fdate">Date Form</label>
                <input type="date" class="form-control validate-text" name="fdate" id="fdate" value="<?= $fdate ?>" />

                <label for="tdate">Date To</label>
                <input type="date" class="form-control validate-text" name="tdate" id="tdate" value="<?= $tdate ?>" />

                <label for="region_id">Route</label>
                <select class="form-select form-control" name="route_id" id="route_id" onchange="FetchShopList(this.value)">
                    <?php if($route_id > 0): ?>
                        <option value="<?= $route_id ?>"><?= find1("select route_name from ss_route where route_id='" . $route_id . "'"); ?></option>
                    <?php else: ?>
                        <option></option>
                    <?php endif; ?>
                    <?php optionlist("select s.route_id,r.route_name 
                        from ss_route r, ss_shop s where s.route_id=r.route_id and s.emp_code='" . $_SESSION['user']['username'] . "' group by s.route_id order by route_name"); ?>
                </select>

                <label for="market_id">Shop</label>
                <select  name="dealer_code" id="dealer_code" class="form-select form-control" reqired onChange="getData()">
                    <option value="">Select Shop</option>
                    <?php if($dealer_code != ''): ?>
                        <?php /*?><option value="<?= $dealer_code ?>" selected>
                            <?= find1("select shop_name from ss_shop where dealer_code='" . $dealer_code . "'"); ?>
                        </option><?php */?>
                    <?php endif; ?>
                    <?php
                   
optionlist("SELECT dealer_code, shop_name 
        FROM ss_shop 
        WHERE region_id='" . $_SESSION['user']['region_id'] . "' 
        AND zone_id='" . $_SESSION['user']['zone_id'] . "' 
        AND area_id='" . $_SESSION['user']['area_id'] . "' 
        AND route_id='" . $route_id . "' 
        ORDER BY shop_name");
?>
                </select>

                <div class="d-flex justify-content-center row m-0 mt-3">
                    <div class="col-6">
                        <input class="b-n btn btn-success btn-3d btn-block text-light w-100 py-3" 
                               type="submit" name="submitit" id="submitit" value="View" />
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php
    if ($submitted) {
        $con = '';
        $shop_con = '';

        if ($fdate != '' && $tdate != '')
            $con .= 'and c.chalan_date between "' . $fdate . '" and "' . $tdate . '"';

        if ($dealer_code) {
            $shop_con = ' and s.dealer_code="' . $dealer_code . '"';
        }

        $sql = "select c.do_no,c.chalan_date,c.chalan_no,s.shop_name, s.*,sum(c.total_amt) as total_amt 
            from ss_shop s,ss_do_chalan c 
            where s.dealer_code=c.dealer_code
            and c.entry_by='" . $emp_code . "'
            " . $con . $shop_con . "
            group by c.chalan_no order by c.chalan_no DESC";

        $query = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_object($query)) {
    ?>
            <div class="card card-style card-bg">
                <div class="content m-3">
                    <div class="d-flex pb-0">
                        <div class="align-self-center">
                            <h2 class="font-700 mb-0 f-14"><span class="text-span">Shop:</span> <?= $data->shop_name ?></h2>
                            <h2 class="font-700 mb-0 f-12"><span class="text-span">Order:</span> <span style="color:#0069b5;"><?= $data->do_no; ?></span> | <span class="text-span">Challan:</span> <span style=" color: green; "><?= $data->chalan_no; ?></span> </h2>
                            <h2 class="font-700 mb-0 f-12"><span class="text-span">Challan Date:</span> <span class="color-highlight"><?= $data->chalan_date ?></span></h2>
                            <h2 class="font-700 mb-0 f-12"><span class="text-span">Delivery Amount:</span> <span class="color-highlight f-17"><?= $data->total_amt; ?></span></h2>
                        </div>
                        <div class="align-self-center ms-auto">
                            <div class="d-flex gap-2 justify-content-end align-items-center">
                                <div class="w-50">
                                    <a href="chalan_view.php?v=<?= $data->chalan_no ?>">
                                        <button class="b-n btn btn-info btn-3d btn-block p-2 mb-1 text-light w-100" style=" height: 35px !important; padding-top: 5px !important;"><i class="fa-solid fa-eye"></i></button>
                                    </a>
                                    <a href="chalan_print.php?v=<?= $data->chalan_no ?>">
                                        <button class="b-n btn btn-warning btn-3d btn-block p-2 mt-1 text-light w-100" style=" height: 35px !important; padding-top: 5px !important;"><i class="fa-solid fa-print"></i></button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } 
    } ?>
</div>
<!-- End of Page Content-->

<?php require_once '../assets/template/inc.footer.php'; ?>

<script>
// Function to populate shop dropdown based on selected route

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



// Auto-preserve state when navigating back to this page
document.addEventListener('DOMContentLoaded', function() {
    // If we have session data and we're coming back to this page, auto-submit the form
    if (<?= isset($_SESSION['chalan_filters']['submitted']) && !isset($_POST['submitit']) ? 'true' : 'false' ?>) {
        // Form will be auto-populated from session values
        setTimeout(function() {
            // Small delay to ensure form is fully loaded
            document.getElementById('submitit').click();
        }, 100);
    }
});
</script>