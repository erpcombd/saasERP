<?php
// Keep session and includes
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

// Validate inputs
$dealer_code = $_SESSION['user']['warehouse_id'] ?? '';
$sub_item = $_POST['sub_group_id'] ?? '';
$do_no = isset($_POST['do_no']) ? (int)$_POST['do_no'] : 0;

// Validate required inputs
if (empty($dealer_code) || empty($sub_item)) {
    echo "<div class='alert alert-danger'>Missing required parameters</div>";
    exit;
}
?>

<table class="table table-borderless text-center rounded-sm shadow-l table-scroll">
    <thead>
        <tr class="bg-night-light">
            <th scope="col" class="color-white">Item</th>
            <th scope="col" class="color-white">Unit</th>
            <th scope="col" class="color-white">Stock</th>
            <th scope="col" class="color-white">TP</th>
            <th scope="col" class="color-white">NSP</th>
            <th scope="col" class="color-white">Offer %</th>
            <th scope="col" class="color-white">Qty</th>
            <th scope="col" class="color-white">Amt</th>
        </tr>
    </thead>
    <tbody>  
    <?php
    // Get the latest opening date - FIXED: Removed echo and used prepared statement
    $opening_sql = "SELECT max(ji_date) as max_date FROM ss_journal_item WHERE tr_from='Opening' AND warehouse_id=?";
    $opening_stmt = mysqli_prepare($conn, $opening_sql);
    mysqli_stmt_bind_param($opening_stmt, "s", $dealer_code);
    mysqli_stmt_execute($opening_stmt);
    $opening_result = mysqli_stmt_get_result($opening_stmt);
    $opening_row = mysqli_fetch_object($opening_result);
    $opening_date = $opening_row->max_date ?? '2021-08-01';
    
    if(empty($opening_date)) {
        $opening_date = '2021-08-01';
    }
    
    // FIXED: Added nsp_per to the SELECT query
    $sql = "SELECT i.finish_goods_code, i.item_id, i.item_name, i.unit_name, i.t_price, i.pack_size, i.nsp_per 
            FROM item_info i 
            WHERE i.sub_group_id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        echo "<div class='alert alert-danger'>Database error: " . mysqli_error($conn) . "</div>";
        exit;
    }
    
    mysqli_stmt_bind_param($stmt, "s", $sub_item);
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($query) == 0) {
        echo "<tr><td colspan='8'>No items found for this subcategory</td></tr>";
    }

    while($data = mysqli_fetch_object($query)) {
        // Check if item is already in the order to pre-populate quantity
        $existing_qty = 0;
        $existing_nsp = $data->nsp_per ?? 0; // FIXED: Now nsp_per exists in query
        
        if($do_no > 0) {
            $check_sql = "SELECT pkt_unit, nsp_per FROM ss_do_details WHERE do_no = ? AND item_id = ?";
            $check_stmt = mysqli_prepare($conn, $check_sql);
            mysqli_stmt_bind_param($check_stmt, "ii", $do_no, $data->item_id);
            mysqli_stmt_execute($check_stmt);
            $check_result = mysqli_stmt_get_result($check_stmt);
            if($check_row = mysqli_fetch_object($check_result)) {
                $existing_qty = $check_row->pkt_unit ?? 0;
                $existing_nsp = $check_row->nsp_per ?? $data->nsp_per;
            }
        }
        
        // Calculate stock - FIXED: Added better error handling
        $sql_in = "SELECT item_id, SUM(total_unit) as qty 
                  FROM sale_do_chalan 
                  WHERE chalan_date >= ? AND dealer_code = ? AND item_id = ?";
        $in_stmt = mysqli_prepare($conn, $sql_in);
        mysqli_stmt_bind_param($in_stmt, "sii", $opening_date, $dealer_code, $data->item_id);
        mysqli_stmt_execute($in_stmt);
        $in_result = mysqli_stmt_get_result($in_stmt);
        $info1 = mysqli_fetch_object($in_result);
        $item_in = $info1->qty ?? 0;
        
        $sql2 = "SELECT item_id, SUM(item_in-item_ex) as qty
                FROM ss_journal_item
                WHERE warehouse_id = ? AND ji_date >= ? AND item_id = ?";
        $stmt2 = mysqli_prepare($conn, $sql2);
        mysqli_stmt_bind_param($stmt2, "isi", $dealer_code, $opening_date, $data->item_id);
        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);
        $info2 = mysqli_fetch_object($result2);
        $stk = $info2->qty ?? 0;
        
        $total_stock = $stk + $item_in;
        
        // FIXED: Added null coalescing operators for safety
        $t_price = $data->t_price ?? 0;
        $nsp_amt_cus = $t_price * (1-($existing_nsp/100));
        $total_amt = $existing_qty * $nsp_amt_cus;
    ?>
    
    <input name="item_ids[]" id="item_ids[]" type="hidden" value="<?=htmlspecialchars($data->item_id)?>"/>
    <input name="item_id_<?=$data->item_id?>" type="text" step="0.01" id="item_id_<?=$data->item_id?>" value="<?=htmlspecialchars($data->item_name)?>" readonly style="display: none;"/>
    <input name="unit_name_<?=$data->item_id?>" type="text" id="unit_name_<?=$data->item_id?>" value="<?=htmlspecialchars($data->unit_name)?>" style="display: none;"/>
    <input name="stock_<?=$data->item_id?>" class="form-control input3" type="text" id="stock_<?=$data->item_id?>" value="<?=$total_stock?>" style="display: none;" readonly />
    <input name="unit_price2_<?=$data->item_id?>" type="number" step="0.01" id="unit_price2_<?=$data->item_id?>" value="<?=$t_price?>" readonly style="display: none;"/>
    <input name="unit_price_<?=$data->item_id?>" type="number" step="0.01" class="form-control input3" id="unit_price_<?=$data->item_id?>" value="<?=number_format($nsp_amt_cus, 2)?>" readonly style="display: none;"/>
    <input name="pkt_size_<?=$data->item_id?>" type="hidden" class="form-control input3" id="pkt_size_<?=$data->item_id?>" value="<?=$data->pack_size ?? 0?>" readonly style="display: none;"/>

    <tr>
        <td colspan="8" align="left" class="sr-td-t">
            <strong><?=htmlspecialchars($data->item_name)?></strong> <?=htmlspecialchars($data->finish_goods_code)?>
        </td> 
    </tr>
    <tr class="sr-td-b">    
        <td></td>
        <td><?=htmlspecialchars($data->unit_name)?></td>
        <td><?=$total_stock?></td>
        <td><?=number_format($t_price, 2)?></td>
        <td id="nsp_display_<?=$data->item_id?>"><?=number_format($nsp_amt_cus, 2)?></td>
        <td> 
            <input type="hidden" id="nsp_per2_<?=$data->item_id?>" value="<?=$data->nsp_per ?? 0?>" />
            <input name="nsp_per_<?=$data->item_id?>" type="number" max="<?=number_format($data->nsp_per ?? 0, 2)?>" id="nsp_per_<?=$data->item_id?>" onchange="update_nsp_amt(<?=$data->item_id?>)" value="<?=number_format($existing_nsp, 2)?>" step="0.01" />
        </td>
        <td>
            <input name="pkt_unit_<?=$data->item_id?>" type="number" id="pkt_unit_<?=$data->item_id?>" onkeyup="update_nsp_amt(<?=$data->item_id?>)" value="<?=$existing_qty?>" step="0.01" />
            <input name="total_unit" type="hidden" id="total_unit" readonly="readonly"/>
            <input name="total_amt" type="hidden" id="total_amt" readonly="readonly"/>
        </td>
        <td>
            <input name="total_amt_<?=$data->item_id?>" value="<?=number_format($total_amt, 2)?>" type="text" id="total_amt_<?=$data->item_id?>" readonly />
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>

<center>
    <input name="addItems" type="submit" value="Add Item" class="b-n btn btn-success" style="width: 33% !important;" />
</center>

<script>
// Function to update NSP amount and total - FIXED: Added better error handling
function update_nsp_amt(id) {
    try {
        var tp_element = document.getElementById("unit_price2_" + id);
        var nsp_element = document.getElementById("nsp_per_" + id);
        var qty_element = document.getElementById("pkt_unit_" + id);
        
        if (!tp_element || !nsp_element || !qty_element) {
            console.error("Required elements not found for item ID: " + id);
            return;
        }
        
        var tp_amt = parseFloat(tp_element.value) || 0;
        var nsp_per_amt = parseFloat(nsp_element.value) || 0;
        var qty = parseFloat(qty_element.value) || 0;
        
        // Calculate NSP after discount
        var final_amt = tp_amt * (1 - (nsp_per_amt / 100));
        
        var unit_price_element = document.getElementById("unit_price_" + id);
        if (unit_price_element) {
            unit_price_element.value = final_amt.toFixed(2);
        }
        
        // Update NSP display
        var nsp_display_element = document.getElementById("nsp_display_" + id);
        if (nsp_display_element) {
            nsp_display_element.textContent = final_amt.toFixed(2);
        }
        
        // Calculate total amount
        var total_amt = qty * final_amt;
        var total_amt_element = document.getElementById("total_amt_" + id);
        if (total_amt_element) {
            total_amt_element.value = total_amt.toFixed(2);
        }
        
        // Update grand total
        updateGrandTotal();
    } catch (error) {
        console.error("Error in update_nsp_amt:", error);
    }
}

// Function to update the grand total - FIXED: Added error handling
function updateGrandTotal() {
    try {
        var grand_total = 0;
        var inputs = document.querySelectorAll('input[id^="total_amt_"]');
        
        inputs.forEach(function(input) {
            var value = parseFloat(input.value) || 0;
            grand_total += value;
        });
        
        // Update total display if it exists in parent document
        if (window.parent && window.parent.document.getElementById('total_item_amt')) {
            window.parent.document.getElementById('total_item_amt').textContent = grand_total.toFixed(2);
        }
    } catch (error) {
        console.error("Error in updateGrandTotal:", error);
    }
}

// Initialize totals on page load
document.addEventListener('DOMContentLoaded', function() {
    updateGrandTotal();
});
</script>