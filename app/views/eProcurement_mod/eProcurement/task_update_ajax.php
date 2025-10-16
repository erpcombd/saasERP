<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);

if (isset($_SESSION['rfq_no']) && isset($_GET['button_name']) && isset($_GET['id_to_update']) && isset($_GET['button_value'])) {

    $rfq_no = $_SESSION['rfq_no'];
    $id_to_update= $_GET['id_to_update'];
    $button_name = $_GET['button_name'];
    $button_value = $_GET['button_value'];
    
    $currenent_sequence= find_a_field('timeline_Tasks','sequence','id="'.$id_to_update.'"');
    $direction='';
    if($currenent_sequence<$button_value){
        $direction='down';
    }elseif($currenent_sequence>$button_value){
        $direction='up';
    }
    
  


    
    if($button_name=='sequence'){
     if($direction=='up'){
        $sql_update = 'UPDATE timeline_Tasks 
        SET sequence = sequence + 1 
        WHERE rfq_no = "' . $rfq_no . '" 
        AND sequence >="'.$button_value.'" AND sequence <="'.$currenent_sequence.'"';
    db_query($sql_update);
     }elseif($direction=='down'){
        $sql_update = 'UPDATE timeline_Tasks 
        SET sequence = sequence - 1 
        WHERE rfq_no = "' . $rfq_no . '" 
        AND sequence <= "'. $button_value.'" AND sequence >="'.$currenent_sequence.'" ';
    db_query($sql_update);
        
     }


    }

    $sql_update = 'UPDATE timeline_Tasks SET '.$button_name.' = "'.$button_value.'" ,entry_by="'.$_SESSION['user']['id'].'",entry_at="'.date('Y-m-d H:i:s').'" WHERE id="'.$id_to_update.'"';
    db_query($sql_update);
    $response = array(
        'status' => 'success',
        'message' => 'Invalid parameters',
        'direction' => $direction,
    );

}


echo json_encode($response);
 ?>