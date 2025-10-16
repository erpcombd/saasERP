<?php
include ("../engine/config/db_con_live_static.php");

$pdata  = file_get_contents("php://input");
$result = json_decode($pdata);

mysqli_set_charset($new_conn, "utf8mb4");

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Check if the required input parameters exist
if (!isset($result[0]->user) || !isset($result[0]->password)) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'User and password are required']);
    exit;
}

// Get user and password from the input
$user       = $result[0]->user;
$password   = $result[0]->password;

function find1($new_conn, $sql) {
    $query2 = mysqli_query($new_conn, $sql);
    if (!$query2) {
        return null;
    }
    while($info2 = mysqli_fetch_object($query2)) {
        return $info2;
    }
    return null;
}

// Query to check the user credentials
$sql1 = "SELECT * FROM ss_user WHERE username = '".$user."' AND password = '".$password."' AND status='Active'";

$query = mysqli_query($new_conn, $sql1);

// Check if the query was successful
if (!$query) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Error executing query']);
    exit;
}

$data = array();
$user_data = null; // Declare a variable to store user data

while ($info = mysqli_fetch_object($query)) {
    if (!$info) {
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Invalid credentials or inactive user']);
        exit;
    }
    
    // Fetch region, zone, and area names
    $region_name = find1($new_conn, "SELECT BRANCH_NAME FROM branch WHERE BRANCH_ID = '".$info->region_id."'")->BRANCH_NAME;
    $zone_name = find1($new_conn, "SELECT ZONE_NAME FROM zon WHERE ZONE_CODE = '".$info->zone_id."'")->ZONE_NAME;
    $area_name = find1($new_conn, "SELECT AREA_NAME FROM area WHERE AREA_CODE = '".$info->area_id."'")->AREA_NAME;

    // Prepare user data
    $user_data = [
        'user_id' => $info->user_id,
        'username' => $info->username,
        'password' => $info->password,
        'full_name' => $info->fname,
        'mobile' => $info->mobile,
        'dealer_code' => $info->dealer_code,
        'region_id' => $info->region_id,
        'zone_id' => $info->zone_id,
        'area_id' => $info->area_id,
        'region_name' => $region_name,
        'zone_name' => $zone_name,
        'area_name' => $area_name
    ];
}

// If no user was found
if ($user_data === null) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid user credentials']);
    exit;
}

// Now, fetch routes related to the area
 $sql2 = "select s.route_id,r.route_name 
									from ss_route r, ss_shop s where s.route_id=r.route_id and s.emp_code='".$user."' group by s.route_id order by route_name";

$query2 = mysqli_query($new_conn, $sql2);

$routes_data = array();
while ($info2 = mysqli_fetch_object($query2)) {
    $routes_data[] = [
        'route_id' => $info2->route_id,
        'route_name' => $info2->route_name
    ];
}


 $sql3 = 'select dealer_code,shop_name,route_id from ss_shop where status="1" and region_id="'.$user_data['region_id'].'" and zone_id="'.$user_data['zone_id'].'" and area_id="'.$user_data['area_id'].'" order by shop_name ';

$query3 = mysqli_query($new_conn, $sql3);

$shopes_data = array();
while ($info3 = mysqli_fetch_object($query3)) {
    $shopes_data[] = [
        'dealer_code' => $info3->dealer_code,
        'shop_name' => $info3->shop_name,
        'route_id' => $info3->route_id,
    ];
}

$sql4 = 'select id,category_name from item_category where 1 order by category_name ';

$query4 = mysqli_query($new_conn, $sql4);

$category_data = array();
while ($info4 = mysqli_fetch_object($query4)) {
    $category_data[] = [
        'id' => $info4->id,
        'category_name' => $info4->category_name,

    ];
}
$sql5 = 'select id,subcategory_name,category_id from item_subcategory order by subcategory_name ';

$query5 = mysqli_query($new_conn, $sql5);

$sub_category_data = array();
while ($info5 = mysqli_fetch_object($query5)) {
    $sub_category_data[] = [
        'id' => $info5->id,
        'subcategory_name' => $info5->subcategory_name,
        'category_id' => $info5->category_id,

    ];
}
$sql6 = 'select id,subcategory_name,category_id from item_subcategory order by subcategory_name ';

$query6 = mysqli_query($new_conn, $sql6);

$sub_category_data = array();
while ($info6 = mysqli_fetch_object($query6)) {
    $sub_category_data[] = [
        'id' => $info6->id,
        'subcategory_name' => $info6->subcategory_name,
        'category_id' => $info6->category_id,

    ];
}

 $sql7 = 'SELECT i.finish_goods_code, i.item_id, i.item_name, i.unit_name, i.t_price, i.pack_size, i.nsp_per,i.category_id,i.subcategory_id FROM item_info i where i.status_sec=1';
$query7 = mysqli_query($new_conn, $sql7);

$item_data = array();
while ($info7 = mysqli_fetch_object($query7)) {
    $item_data[] = [
        'finish_goods_code' => $info7->finish_goods_code,
        'item_id' => $info7->item_id,
        'item_name' => $info7->item_name,
        'unit_name' => $info7->unit_name,
        't_price' => $info7->t_price,
        'pack_size' => $info7->pack_size,
        'nsp_per' => $info7->nsp_per,
        'category_id' => $info7->category_id,
        'subcategory_id' => $info7->subcategory_id
    ];
}
//ofer calculation table

$sql8 = 'SELECT * FROM ss_gift_offer_invoice WHERE year="' . date('Y') . '" AND mon="' . ltrim(date('m'), '0') . '"';


$query8 = mysqli_query($new_conn, $sql8);

$trade_offer = array();
while ($info8 = mysqli_fetch_object($query8)) {
    $trade_offer[] = [
        'id' => $info8->id,                     // Mapping to 'id' column
        'year' => $info8->year,                 // Mapping to 'year' column
        'mon' => $info8->mon,                   // Mapping to 'mon' column
        'offer_name' => $info8->offer_name,     // Mapping to 'offer_name' column
        'item_list' => $info8->item_list,       // Mapping to 'item_list' column
        'min_taka' => $info8->min_taka,         // Mapping to 'min_taka' column
        'max_taka' => $info8->max_taka,         // Mapping to 'max_taka' column
        'gift_item_id' => $info8->gift_item_id, // Mapping to 'gift_item_id' column
        'git_qty' => $info8->git_qty,           // Mapping to 'git_qty' column
        'gift_item_name' => $info8->gift_item_name, // Mapping to 'gift_item_name' column
        'status' => $info8->status,             // Mapping to 'status' column
        'entry_by' => $info8->entry_by,         // Mapping to 'entry_by' column
        'entry_at' => $info8->entry_at          // Mapping to 'entry_at' column
    ];
}
 $sql9 = 'SELECT * FROM ss_trade_comission WHERE year="' . date('Y') . '" AND mon="' . ltrim(date('m'), '0') . '"';


$query9 = mysqli_query($new_conn, $sql9);

$trade_comission = array();
while ($info9 = mysqli_fetch_object($query9)) {
    $trade_comission[] = [
        'id' => $info9->id,                        // Mapping to 'id' column
        'year' => $info9->year,                    // Mapping to 'year' column
        'mon' => $info9->mon,                      // Mapping to 'mon' column
        'offer_name' => $info9->offer_name,        // Mapping to 'offer_name' column
        'item_group' => $info9->item_group,        // Mapping to 'item_group' column
        'item_list' => $info9->item_list,          // Mapping to 'item_list' column
        'min_qty' => $info9->min_qty,              // Mapping to 'min_qty' column
        'max_qty' => $info9->max_qty,              // Mapping to 'max_qty' column
        'free_qty' => $info9->free_qty,            // Mapping to 'free_qty' column
        'trade_com_per' => $info9->trade_com_per,  // Mapping to 'trade_com_per' column
    ];
}



// Combine user data and route data into one response
$response = [

	'user' => $user_data,
	'routes' => $routes_data,
	'shopes' => $shopes_data,
	'category' => $category_data,
	'sub_category' => $sub_category_data,
	'item' => $item_data,
	'trade_offer' => $trade_offer,
	'trade_comission' => $trade_comission,




];

$jsonResponse = json_encode($response);
if ($jsonResponse === false) {
    echo json_encode(['error' => 'JSON encoding failed', 'json_error' => json_last_error_msg()]);
    exit;
}
echo $jsonResponse;


mysqli_close($new_conn);

?>
