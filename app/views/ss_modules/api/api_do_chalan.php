<?php
include("../config/db.php");
include("../config/function.php");

date_default_timezone_set('Asia/Dhaka');

// Read the raw POST data
$pdata = file_get_contents("php://input");
// Decode the JSON data
$data = json_decode($pdata, true); // true to get an associative array

// Check if data is not empty
if (!empty($data)) {
    foreach ($data as $item) {
        // Extract item properties
        $orderId = $item['order_id'];
        $shopId = $item['shop_id'];
        $itemName = $item['item_name'];
        $rate = $item['rate'];
        $stock = $item['stock'];
        $orderQuantity = $item['orderquantity'];
        $cq = $item['CQ'];
        $doNo = $item['do_no'];
        $itemId = $item['item_id'];
        $dealerCode = $item['dealer_code'];
        $unitPrice = $item['unit_price'];
        $nspPer = $item['nsp_per'];
        $totalUnit = $item['total_unit'];
        $totalAmt = $item['total_amt'];
        $currentDate = $item['current_date'];
        
        $CQAmount = $cq * $rate;
        
        // Insertion query
        $sql_insert = "INSERT INTO ssn_do_chalan (order_no, do_no, item_id, dealer_code, t_price, unit_price, total_unit, total_amt, chalan_date, depot_id, CQ, CQ_amount) 
            VALUES ('$orderId', '$doNo', '$itemId', '$shopId', '$rate', '$unitPrice', '$totalUnit', '$totalAmt', '$currentDate', '$dealerCode', '$cq', '$CQAmount')";
        
        // Perform insertion
        if (mysqli_query($conn, $sql_insert)) {
            // Insertion successful
            echo json_encode(array("message" => "Data inserted successfully"));
            
            // Update query for ss_journal_item
            $sql_update = "UPDATE ssn_journal_item 
                           SET item_ex = item_ex + $cq 
                           WHERE item_id = '$itemId'";
            
            // Perform update
            if (!mysqli_query($conn, $sql_update)) {
                // Error in update
                echo json_encode(array("error" => "Error updating ss_journal_item: " . mysqli_error($conn)));
            }
           
        } else {
            // Error in insertion
            echo json_encode(array("error" => "Error inserting data: " . mysqli_error($conn)));
        }
    }
     $sql_update_doMaster = "UPDATE ssn_do_master 
                           SET status = 'COMPLETED' 
                           WHERE do_no = '$doNo'";
            
            // Perform update
            if (!mysqli_query($conn, $sql_update_doMaster)) {
                // Error in update
                echo json_encode(array("error" => "Error updating ss_do_master " . mysqli_error($conn)));
            }
} else {
    // No data received
    echo json_encode(array("error" => "No data received"));
}

mysqli_close($conn);
?>
