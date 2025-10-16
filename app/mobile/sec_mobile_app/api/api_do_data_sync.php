<?php
include ("../engine/config/db_con_live_static.php");
// Set response header for CORS (allow access from Flutter)
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

// Include database connection file
 // Assuming you have a db_connection.php file


// Check if POST data is received
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    // Check if data exists
    if (isset($data->doMaster) && isset($data->items)) {
        $doMasterData = $data->doMaster;
        $itemsData = $data->items;
        $userData = $data->userId;


        // Get DoMaster details
        $doNo = $doMasterData->do_no;
        $shopId = $doMasterData->shop_id;
        $doDate = $doMasterData->do_date;
        $latitude = $doMasterData->end_latitude;
        $longitude = $doMasterData->end_longitude;
        $status = $doMasterData->status;
        $sentStatus = $doMasterData->sent_status;

        // Insert into do_master table
        $doMasterQuery = "INSERT INTO ss_do_master( dealer_code, do_date,latitude,longitude, status, entry_by) 
                          VALUES ('$shopId', '$doDate','$latitude','$longitude', 'CHECKED', '$userData')";
        if (mysqli_query($new_conn, $doMasterQuery)) {
            // Get the last inserted do_offline_id
            $doMasterId = mysqli_insert_id($new_conn);

            // Now insert each item from item_details
            foreach ($itemsData as $item) {
                $itemId = $item->item_id;
                $finishGoodsCode = $item->finish_goods_code;
                $itemName = $item->item_name;
                $unitName = $item->unit_name;
                $tPrice = $item->t_price;
                $packSize = $item->pack_size;
                $nspPer = $item->nsp_per;
                $categoryId = $item->category_id;
                $subcategoryId = $item->subcategory_id;
                $offer = $item->offer;
                $qty = $item->qty;
                $amt = $item->amt;
                $total_tp=$tPrice*$qty;
                $unit_price=$tPrice*(1-($nspPer/100));

                // Insert into item_details table
                $itemDetailsQuery = "INSERT INTO  ss_do_details 
                    (do_no, do_date, item_id, dealer_code, nsp_per, unit_price, total_unit, pkt_unit,
                     total_amt,entry_by,t_price,total_tp,status) 
                    VALUES 
                    ('$doMasterId', '$doDate', '$itemId', '$shopId', '$nspPer', ' $unit_price*', 
                    '$qty','$qty', '$amt', '$userData','$tPrice','$total_tp','CHECKED')";

                if (!mysqli_query($new_conn, $itemDetailsQuery)) {
                    // If insertion fails, return an error
                    echo json_encode(["status" => "error", "message" => "Failed to insert item details"]);
                    exit;
                }
            }

            // Send success response
            echo json_encode(["status" => "success", "message" => "Data synced successfully"]);
        } else {
            // If insertion fails, return an error
            echo json_encode(["status" => "error", "message" => "Failed to insert do_master"]);
        }
    } else {
        // If the required data is missing, return an error
        echo json_encode(["status" => "error", "message" => "Invalid data received"]);
    }
} else {
    // If the request is not POST, return an error
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}

// Close the database connection
mysqli_close($new_conn);
?>
