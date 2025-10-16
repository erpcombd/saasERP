<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

if (isset($_SESSION['rfq_no']) && isset($_GET['button_name']) && isset($_GET['button_value'])) {
    $rfq_no = $_SESSION['rfq_no'];
    $button_name = $_GET['button_name'];
    $button_value = $_GET['button_value'];
    $sql_insert = 'INSERT INTO notification_setup_information (rfq_no, ' . $button_name . ') 
    VALUES ("' . $rfq_no . '", "' . $button_value . '") 
    ON DUPLICATE KEY UPDATE ' . $button_name . ' = VALUES(' . $button_name . ')';
    db_query($sql_insert);
    $response = array(
        'status' => 'success',
        'message' => 'Invalid parameters'
    );

}


echo json_encode($response);
 ?>