<?php
require_once '../path/to/database/connection.php';

header('Content-Type: application/json');

if (isset($_GET['route_id'])) {
    $routeId = mysqli_real_escape_string($conn, $_GET['route_id']);
    
    $query = "SELECT 
                s.dealer_code, 
                r.route_name, 
                s.shop_name 
              FROM ss_shop s 
              JOIN ss_route r ON s.route_id = r.route_id 
              WHERE s.status = '1' 
                AND s.emp_code = '".$_SESSION['user']['username']."' 
                AND s.route_id = '$routeId'
              ORDER BY r.route_id, s.shop_name";
    
    $result = mysqli_query($conn, $query);
    
    $shops = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $shops[] = $row;
    }
    
    echo json_encode($shops);
} else {
    echo json_encode([]);
}
?>