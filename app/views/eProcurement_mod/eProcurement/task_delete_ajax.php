<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


if (isset($_SESSION['rfq_no']) && isset($_GET['button_name']) && isset($_GET['id_to_delete']) && isset($_GET['button_value'])) {
    
  

    $rfq_no = $_SESSION['rfq_no'];
    $id_to_update= $_GET['id_to_delete'];
    $button_name = $_GET['button_name'];
    $button_value = $_GET['button_value'];
    
    // if($button_name=='sequence'){
        $sql_update = 'UPDATE timeline_Tasks 
        SET sequence = sequence - 1 
        WHERE rfq_no = "' . $rfq_no . '" 
        AND sequence >= ' . $button_value;
    db_query($sql_update);
    // }
    $sql_delete = 'DELETE FROM timeline_Tasks WHERE id="'.$id_to_update.'"';
    db_query($sql_delete);
    $response = array(
        'status' => 'success',
        'message' => 'Invalid parameters'
    );

}


echo json_encode($response);
 ?>