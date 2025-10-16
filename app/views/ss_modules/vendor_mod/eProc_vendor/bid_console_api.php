<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";

header('Content-Type: application/json');  // Return JSON response

// Read the JSON input
$input = json_decode(file_get_contents('php://input'), true);



$rfq_name = $input['rfq_no'] ?? '';
$item_id = $input['item_id'] ?? '';
$user_id = $input['user_id'] ?? '';

$sql = 'SELECT t.*, i.item_name, d.expected_qty
FROM rfq_vendor_item_response t
JOIN item_info i ON t.item_id = i.item_id
JOIN rfq_item_details d ON t.rfq_no = d.rfq_no AND t.item_id = d.item_id
WHERE t.rfq_no = "'.$rfq_name.'" 
  AND t.item_id = "'.$item_id.'" 
  AND t.vendor_id = "'.$user_id.'"
ORDER BY t.entry_at ASC;';


$qry = db_query($sql);

// Arrays to store chart data
$prices = [];
$dates = [];

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
            $prices[] = $res->unit_price * $res->expected_qty;
            $dates[] = $res->entry_at;
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
    'dates' => $dates        // Dates for the chart
]);
