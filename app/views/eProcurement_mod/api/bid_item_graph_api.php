<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";

header('Content-Type: application/json');  // Return JSON response

// Read the JSON input
$input = json_decode(file_get_contents('php://input'), true);



$rfq_name = $input['rfq_no'] ?? '';
$item_id = $input['item_id'] ?? '';
// $user_id = $input['user_id'] ?? '';







$sql = 'WITH VendorMinPrices AS (
                  SELECT 
                      rv.rfq_no, 
                      rv.item_id, 
                      rv.vendor_id, 
                      MIN(rv.unit_price) AS min_unit_amount 
                  FROM 
                      rfq_vendor_item_response rv
                  WHERE 
                      rv.rfq_no = "'.$rfq_name.'" AND item_id="'.$item_id.'"
                  GROUP BY 
                      rv.rfq_no, rv.item_id, rv.vendor_id
              ),
              RankedVendors AS (
                  SELECT 
                      vmp.rfq_no, 
                      vmp.item_id, 
                      vmp.vendor_id, 
                      vmp.min_unit_amount, 
                      RANK() OVER (PARTITION BY vmp.rfq_no, vmp.item_id ORDER BY vmp.min_unit_amount ASC) AS price_rank 
                  FROM 
                      VendorMinPrices vmp
              )
              SELECT 
                  rv.rfq_no, 
                  rv.item_id, 
                  rv.vendor_id, 
                  rv.min_unit_amount, 
                  rv.price_rank,
                  rid.expected_qty, 
                  rid.visibility_start,  
                  rid.visibility_end,
                  v.vendor_name   
              FROM 
                  RankedVendors rv
              JOIN 
                  rfq_item_details rid ON rv.rfq_no = rid.rfq_no AND rv.item_id = rid.item_id
              JOIN 
                  vendor v  ON rv.vendor_id = v.vendor_id
              ';


$qry = db_query($sql);

// Arrays to store chart data
$prices = [];
$vendor_names = [];

// Start output buffering for the table
ob_start();
?>

<!-- Table HTML -->
<table class="table1 table-striped table-bordered table-hover table-sm">
    <thead class="thead1">
        <tr class="bgc-info">
            <th scope="col">SL</th>
            <th scope="col">Item Description</th>
            <th scope="col">Item Quantity</th>
            <th scope="col">Unit Price</th>
            <th scope="col">Total</th>
            <th scope="col">Date & Time</th>
        </tr>
    </thead>
    <tbody class="tbody1">
        <?php
        $i = 1;
        while ($res = mysqli_fetch_object($qry)) {
            // Collect data for the chart
            $prices[] = $res->min_unit_amount * $res->expected_qty;
            $vendor_names[] = $res->vendor_name;
            ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $res->item_name ?></td>
                <td><?=$res->expected_qty?></td> <!-- Replace with dynamic quantity if needed -->
                <td><?= $res->unit_price ?></td>
                <td><?= $res->unit_price * $res->expected_qty ?></td> <!-- Assuming quantity is 10 for total -->
                <td><?= $res->entry_at ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>

<?php
// Capture the table HTML
$table_html = ob_get_clean();

// Return the JSON response with both table and chart data
echo json_encode([
    'table' => $table_html,  // Table HTML
    'prices' => $prices,     // Prices for the chart
    'dates' => $vendor_names        // Dates for the chart
]);
