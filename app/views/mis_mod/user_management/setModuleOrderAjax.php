<?php

    session_start();
    
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

    $data = explode("##", $_POST['data']);
    $id = $data[0];
    $val = $data[1];
    $user = $data[2];
    $by = $_SESSION['user']['id'];
    $at = date('Y:m:d H:i:s');
    
    if($val>0 && $id>0){
        
        if(find_a_field('user_module_order_list', 'count(id)', 'module="'.$id.'" AND user="'.$user.'" ORDER BY id DESC') > 0){
            $sql = "UPDATE user_module_order_list SET order_list = '$val' WHERE `user` = '$user' AND `module` = '$id'";
        }else{
            $sql = "INSERT INTO user_module_order_list(`user`, `module`, `order_list`, `entry_by`, `entry_at`) VALUES ('$user', '$id', '$val', '$by', '$at')";
        }
        
        if(db_query($sql)){
          echo 'Set to '."'".$val."'";
        }else{
          echo 'Failed!';    
        }
    }else{
        echo 'Failed!';    
    }
    
?>