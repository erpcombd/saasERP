    <?php
    session_start();
    require_once "../engine/routing/default_values.php";
    require_once SERVER_CORE . "core/init.php";
    require_once '../assets/support/ss_function.php';
    //var_dump($_SESSION);
	$menu = 'challan';
	$menu_active='active';
    $title = "Chalan List";
    $page = "chalan_list.php";
    //$user_id	=$_SESSION['user_id'];
    $username    = $_SESSION['user']['id'];
    $emp_code = $username;
    require_once '../assets/template/inc.header.php';
    ?>

    <div class="page-content header-clear-medium">
        <form action="" method="post" name="codz" id="codz">

            <div class="card card-style">
                <div class="content mt-0 ms-0 me-0">
                    <label for="fdate">Date Form</label>
                    <input type="date" class="form-control validate-text" name="fdate" id="fdate" value="<?= $_POST['fdate'] ? $_POST['fdate'] : date('Y-m-01') ?>" />

                    <label for="tdate">Date To</label>
                    <input type="date" class="form-control validate-text" name="tdate" id="tdate" value="<?= $_POST['tdate'] ? $_POST['tdate'] : date('Y-m-d') ?>" />

                    <label for="market_id">Shop</label>
                    <select type="text" name="dealer_code" id="dealer_code" autocomplete="off" class="form-control-round">
                        <option><?= $_POST['dealer_code'] ?></option>
                        <?
                        optionlist("select dealer_code,shop_name from ss_shop where region_id='" . $_SESSION['user']['region_id'] . "' and zone_id='" . $_SESSION['user']['zone_id'] . "' and area_id='" . $_SESSION['user']['area_id'] . "' order by region_id,zone_id,area_id,shop_name");
                        ?>
                    </select>

                    <div class="d-flex justify-content-center row m-0 mt-3">
                        <div class="col-6">
                            <input class="b-n btn btn-success btn-3d btn-block  text-light w-100 py-3" type="submit" name="submitit" id="submitit" value="View" />
                        </div>
                    </div>
                </div>
        </form>
    </div>

    <?
    if (isset($_POST['submitit'])) {

        if ($_POST['fdate'] != '' && $_POST['tdate'] != '')
            $con .= 'and c.chalan_date between "' . $_POST['fdate'] . '" and "' . $_POST['tdate'] . '"';

        if ($_POST['dealer_code']) {
            $shop_con = ' and s.dealer_code="' . $_POST['dealer_code'] . '"';
        }

        $sql = "select c.do_no,c.chalan_date,c.chalan_no,s.shop_name, s.*,sum(c.total_amt) as total_amt 
            from ss_shop s,ss_do_chalan c 
            where s.dealer_code=c.dealer_code
            and c.depot_id='" . $emp_code . "'
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
                                <div class="w-100">
                                    <a href="chalan_view.php?v=<?= $data->chalan_no ?>">
                                        <button class="b-n btn btn-info btn-3d btn-block p-2 mb-1  text-light w-100" style=" height: 35px !important; padding-top: 5px !important;"><i class="fa-solid fa-eye"></i></button>
                                    </a>
							   <a href="chalan_print.php?v=<?= $data->chalan_no ?>">
								<button class="b-n btn btn-warning btn-3d btn-block  text-light w-100"><i class="fa-solid fa-print"></i></button>
								</a>
                                </div>

                            </div>

                            <!-- <p class="m-0 p-0"><?= $data->total_amt; ?></p> -->

                        </div>
                    </div>
                </div>
            </div>
        <? } ?>
    <? } ?>
    </div>
    <!-- End of Page Content-->
    <?php
    require_once '../assets/template/inc.footer.php';
    ?>