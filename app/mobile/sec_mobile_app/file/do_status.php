<?php 
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Order List";
$page = "do_status.php";
$user_id = $_SESSION['user_id'];
$username = $_SESSION['user']['username'];
$emp_code = $username;
$today = date('Y-m-d');

$unique = 'do_no';
$target_url = 'do_view.php';

// Save form data in session when the form is submitted
if(isset($_POST['submitit'])) {
    $_SESSION['do_fdate'] = $_POST['fdate'] ? $_POST['fdate'] : date('Y-m-01');
    $_SESSION['do_tdate'] = $_POST['tdate'] ? $_POST['tdate'] : date('Y-m-d');
    $_SESSION['do_submitted'] = true;
}

$fdate = isset($_POST['fdate']) ? $_POST['fdate'] : (isset($_SESSION['chalan_filters']['fdate']) ? $_SESSION['chalan_filters']['fdate'] : date('Y-m-01'));
$tdate = isset($_POST['tdate']) ? $_POST['tdate'] : (isset($_SESSION['chalan_filters']['tdate']) ? $_SESSION['chalan_filters']['tdate'] : date('Y-m-d'));
$route_id = isset($_POST['route_id']) ? $_POST['route_id'] : (isset($_SESSION['chalan_filters']['route_id']) ? $_SESSION['chalan_filters']['route_id'] : '');
$dealer_code = isset($_POST['dealer_code']) ? $_POST['dealer_code'] : (isset($_SESSION['chalan_filters']['dealer_code']) ? $_SESSION['chalan_filters']['dealer_code'] : '');
$submitted = isset($_POST['submitit']) || (isset($_SESSION['chalan_filters']['submitted']) && $_SESSION['chalan_filters']['submitted']);

require_once '../assets/template/inc.header.php';

if($_REQUEST[$unique]>0) {
    $_SESSION[$unique] = $_REQUEST[$unique];
    header('location:'.$target_url);
}
?>
<script language="javascript">
function custom(theUrl) {
    window.open('<?=$target_url?>?do='+theUrl);
}
</script>

<!-- start of Page Content-->  
<div class="page-content header-clear-medium">
    <!-- Keeping original back button but adding a script to handle it -->
    <!--<a href="order_list.php" class="back-button">
        <button class="btn btn-print text-center" style="background-color:#00BCD4 !important; margin-left: 5px; color: #fff !important;">Back</button>
    </a>-->
    
    <form action="" method="post" name="codz" id="codz">
        <div class="card card-style mb-0">
            <div class="content m-0">
                <label for="fdate">Date Form</label>
                <input type="date" class="form-control validate-text" name="fdate" id="fdate" 
                       value="<?= isset($_POST['fdate']) ? $_POST['fdate'] : (isset($_SESSION['do_fdate']) ? $_SESSION['do_fdate'] : date('Y-m-01')) ?>" />
                
                <label for="tdate">Date To</label>
                <input type="date" class="form-control validate-text" name="tdate" id="tdate" 
                       value="<?= isset($_POST['tdate']) ? $_POST['tdate'] : (isset($_SESSION['do_tdate']) ? $_SESSION['do_tdate'] : date('Y-m-d')) ?>" />
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

    <div class="card card-style"> 
        <div class="content ms-0 me-0">
            <div class="table-responsive pt-3" style="zoom: 74%;">
                <table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;">
                    <thead>
                        <tr class="bg-night-light1">
                            <th scope="col" class="color-white">Order No</th>
                            <th scope="col" class="color-white">Order Date</th>
                            <th scope="col" class="color-white">Party Code</th>
                            <th scope="col" class="color-white">Party Name</th>
                            <th scope="col" class="color-white">Order Qty</th>
                            <th scope="col" class="color-white">Order amt</th>
                            <th scope="col" class="color-white">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    // Check if we have data to display - either from form submission or session
                    $shouldShowData = isset($_POST['submitit']) || isset($_SESSION['do_submitted']);
                    
                    if($shouldShowData) {
                        $con = '';
                        
                        // Use either POST data or session data
                        $fdate = isset($_POST['fdate']) ? $_POST['fdate'] : $_SESSION['do_fdate'];
                        $tdate = isset($_POST['tdate']) ? $_POST['tdate'] : $_SESSION['do_tdate'];
                        
                        if($fdate != '' && $tdate != '')
                            $con .= 'and m.do_date between "'.$fdate.'" and "'.$tdate.'"';
                        
                        $res = 'select m.do_no, m.do_no as do_no, m.do_date, m.remarks, s.shop_name as party, s.dealer_code as party_code, FORMAT(sum(d.total_amt),2) as Total, sum(d.pkt_unit) as qty
                            from ss_do_master m, ss_do_details d, ss_shop s
                            where m.do_no=d.do_no and m.dealer_code=s.dealer_code and m.status in("Checked","COMPLETED")
                            '.$con.' and m.entry_by="'.$emp_code.'"
                            group by m.do_no order by m.do_no desc';
                        
                        $query = mysqli_query($conn, $res);
                        $sl = 1;
                        while($data = mysqli_fetch_object($query)){
                        ?>
                            <tr>
                                <td style="color: green; font-weight: bold;"><?=$data->do_no;?></td>
                                <td><?=$data->do_date;?></td>
                                <td style="color: #0069b5; font-weight: bold;"><?=$data->party_code;?></td>
                                <td><?=$data->party;?></td>
                                <td><?=$data->qty;?></td>
                                <td><?=$data->Total;?></td>
                                <td class="d-flex gap-2 justify-content-center align-items-center">
                                    <a href="do_view.php?do=<?=$data->do_no;?>"> 
                                        <button class="b-n btn btn-info btn-3d btn-block text-light w-100">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </a>
                                    <a href="do_print_view.php?do=<?=$data->do_no;?>">
                                        <button class="b-n btn btn-warning btn-3d btn-block text-light w-100">
                                            <i class="fa-solid fa-print"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        <?php } 
                    } ?>
                    </tbody>
                </table>
            </div> 
        </div>
    </div>
</div>
<!-- End of Page Content--> 

<?php 
require_once '../assets/template/inc.footer.php';
?>

<script>
// Intercept the back button click to maintain state

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


document.querySelector('.back-button').addEventListener('click', function(e) {
    // If we have session data and this is a back action, prevent default behavior
    if (<?= isset($_SESSION['do_submitted']) ? 'true' : 'false' ?>) {
        e.preventDefault();
        // Trigger form submission with existing session data
        document.getElementById('fdate').value = '<?= isset($_SESSION['do_fdate']) ? $_SESSION['do_fdate'] : date('Y-m-01') ?>';
        document.getElementById('tdate').value = '<?= isset($_SESSION['do_tdate']) ? $_SESSION['do_tdate'] : date('Y-m-d') ?>';
        document.getElementById('submitit').click();
    }
});
</script>