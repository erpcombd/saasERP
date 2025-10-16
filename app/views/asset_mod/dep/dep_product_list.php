<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title = 'Depreciation Calculation';

//do_datatable('item_table');
if (isset($_POST['submit'])) {


    $sql = 'select i.item_id,i.dep_price,s.sub_group_id,s.ledger_id_2 from item_info i,item_sub_group s,item_group g where i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and g.group_name like "%FIXED ASSET%"';
    $query = db_query($sql);
    while ($data = mysqli_fetch_object($query)) {


        $year = $_POST['year'];
        $item_id = $data->item_id;
        $rate = $_POST['rate_' . $data->item_id];
        $qty = $_POST['qty_' . $data->item_id];
        $amount = $_POST['amount_' . $data->item_id];
        $avgPrice = $_POST['avg_' . $data->item_id] * $_POST['qty_' . $data->item_id] * $rate / 100;

        $EData = find_all_field('depreciation_rate', '', 'year="' . $year . '" and item_id="' . $item_id . '"');
        if ($EData->year != $year && $EData->item_id != $item_id && $qty != 0) {
            $iSql = 'insert into depreciation_rate (year,item_id,rate,qty,amount,entry_by,item_sub_group,sub_group_ledger) 
        values
         ("' . $year . '","' . $item_id . '","' . $rate . '","' . $qty . '","' . $avgPrice . '","' . $_SESSION['user']['id'] . '","' . $data->sub_group_id . '","' . $data->ledger_id_2 . '")';
            db_query($iSql);
        } else {
            $uSql = 'update depreciation_rate set rate="' . $rate . '",qty="' . $qty . '",amount="' . $avgPrice . '" where year="' . $year . '" and item_id="' . $item_id . '"';
            db_query($uSql);
        }
    }
    $proj_id = 'clouderp';
    $jv_no = next_journal_sec_voucher_id();
    $jv_date = date('Y-m-d');
    $narration = 'depreciation Journal';
    //!$total_amt = $_POST['totalAmt'];
    $tr_from = 'FixedAsset';
    $tr_no = $year;
    $group_for =  $_SESSION['user']['group'];
    $cr_ledger = find_a_field('config_group_class', 'depreciation_ledger', 'group_for="' . $group_for . '"');

    $secSql = 'select sub_group_ledger,sum(amount) as amount from depreciation_rate where year="' . $_POST['year'] . '" group by item_sub_group';
    $secQuery = db_query($secSql);
    while ($secData = mysqli_fetch_object($secQuery)) {
        add_to_sec_journal($proj_id, $jv_no, $jv_date, $secData->sub_group_ledger, $narration, '0', $secData->amount, $tr_from, $tr_no, '', $tr_id = 0, $cc_code, $group_for, '', '', '', '', '', '', '', "NO");
        $total_amt += $secData->amount;
    }

    add_to_sec_journal($proj_id, $jv_no, $jv_date, $cr_ledger, $narration, $total_amt, '0', $tr_from, $tr_no, '', $tr_id = 0, $cc_code, $group_for, '', '', '', '', '', '', '', "NO");
}
?>

<script>
    function cal(id) {

        var rate = $("#rate_" + id).val() * 1;

        var amt = $("#amount_" + id).val() * 1
        var tot = amt * rate / 100;
        $("#depAmount_" + id).val(tot);

    }
</script>
<form action="" method="post">
    <div class="row">
        <div class="col-1">year: </div>

        <div class="col-4">

            <select name="year">
                <option value="<?= $_POST['year'] ?>"><?= $_POST['year'] ?></option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
            </select>
        </div>
        <div class="col-2"><button type="submit" class="btn btn-info" name="show">Search</button> </div>

    </div>
</form>
<br>
<form action="" method="post">
    <? if (isset($_POST['show'])) {
        if ($_POST['year'] != '') {
            $year = $_POST['year'];
    ?>
            <div class="tabledesign2" style="width:100%">

                <table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">

                    <tr>

                        <th width="13%"> Sub Group </th>

                        <th width="12%">Item ID </th>

                        <th width="15%">Item Name </th>

                        <th width="8%">Unit Name </th>

                        <th width="10%">Depreciation Rate </th>

                        <th width="10%">Stock Qty</th>

                        <th width="10%">Average Rate</th>

                        <th width="10%">Amount</th>

                        <th width="10%">Depreciation Amount </th>

                    </tr>
                    <?php   // ! ji_date between "' . date($year . "-01-01") . '" and "' . date($year . "-12-31") . '"
                    $jSql = 'select item_id, sum(item_in-item_ex) as stock,sum(item_in*final_price-item_ex*final_price)/sum(item_in-item_ex) as avgRate from journal_item  group by item_id';
                    $jQuery = db_query($jSql);
                    while ($jRow = mysqli_fetch_object($jQuery)) {
                        $jData[$jRow->item_id] = number_format($jRow->stock, 2);
                        $avgData[$jRow->item_id] = number_format($jRow->avgRate, 2);
                    }


                    $sql = 'select i.item_id,i.item_name,i.unit_name,i.dep_price,s.sub_group_name from item_info i,item_sub_group s,item_group g where i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and g.group_name like "%FIXED ASSET%"';
                    $query = db_query($sql);
                    while ($data = mysqli_fetch_object($query)) {

                        $depAmt = ($avgData[$data->item_id] * $jData[$data->item_id]) * $data->dep_price / 100;;

                        $amt = $avgData[$data->item_id] * $jData[$data->item_id];
                    ?>

                        <tr bgcolor="<?= ($i % 2) ? '#E8F3FF' : '#fff'; ?>">

                            <td><input type="text" name="sub_group" value="<?= $data->sub_group_name; ?>" readonly></td>
                            <td><input type="text" name="item_id" value="<?= $data->item_id; ?>" readonly></td>
                            <td><input type="text" name="item_name" value="<?= $data->item_name; ?>" readonly></td>
                            <td><input type="text" name="unit_name" value="<?= $data->unit_name; ?>" readonly></td>
                            <td><input type="text" name="rate_<?= $data->item_id ?>" onchange="cal(<?= $data->item_id ?>)" id="rate_<?= $data->item_id ?>" value="<?= $data->dep_price; ?>" readonly></td>
                            <td><input type="text" name="qty_<?= $data->item_id ?>" id="qty_<?= $data->item_id ?>" value="<?= $jData[$data->item_id] ?>" readonly></td>
                            <td><input type="text" name="avg_<?= $data->item_id ?>" value="<?= $avgData[$data->item_id] ?>" readonly></td>
                            <td><input type="text" name="amount_<?= $data->item_id ?>" id="amount_<?= $data->item_id ?>" value="<?= $amt; ?>" readonly></td>
                            <td><input type="text" name="depAmount_<?= $data->item_id ?>" id="depAmount_<?= $data->item_id ?>" value="<?= $depAmt; ?>" readonly></td>
                        </tr>
                    <? $totdAmt += $depAmt;
                        $tot += $amt;
                    } ?>
                    <tr style="font-size:16px; font-weight:700">
                        <td colspan="7" style="text-align: right;">Total</td>
                        <input type="hidden" name="totalAmt" value="<?= $totdAmt ?>">
                        <td><?= $tot ?></td>
                        <td><?= $totdAmt; ?></td>
                    </tr>

                </table>
            </div>


            <input type="hidden" name="year" value="<?= $year ?>">
            <div class="col-12 d-flex justify-content-center mt-5">

                <button class="btn btn-success" name="submit" type="submit">Submit</button>


            </div>
</form>
<? }
    } ?>


<? require_once SERVER_CORE."routing/layout.bottom.php"; ?>