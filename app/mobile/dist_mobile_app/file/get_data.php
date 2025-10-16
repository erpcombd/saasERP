<?php
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';



if (isset($_POST['region_id'])) {
    
    echo $sql = "SELECT * FROM zon where REGION_ID=".$_POST['region_id']." order by ZONE_NAME";
    $query = mysqli_query($conn, $sql);
    echo '<option></option>';
    while($data=mysqli_fetch_object($query)){
            echo '<option value='.$data->ZONE_CODE.'>'.$data->ZONE_NAME.'</option>';
         }
    
}elseif (isset($_POST['zone_id'])) {
     

    $sql = "SELECT * FROM area where ZONE_ID=".$_POST['zone_id']." ORDER BY AREA_NAME";
    $query = mysqli_query($conn, $sql);
    echo '<option></option>';
    while($data=mysqli_fetch_object($query)){
            echo '<option value='.$data->AREA_CODE.'>'.$data->AREA_NAME.'</option>';
         }

}elseif (isset($_POST['area_id'])) {
     

    $sql = "SELECT * FROM ss_route where area_id=".$_POST['area_id']." ORDER BY route_name";
    $query = mysqli_query($conn, $sql);
    echo '<option></option>';
    while($data=mysqli_fetch_object($query)){
            echo '<option value='.$data->route_id.'>'.$data->route_name.'</option>';
         }

}elseif (isset($_POST['fg_group'])) {
     
    $sql = "SELECT * FROM item_category where group_id=".$_POST['fg_group']." ORDER BY category_name";
    $query = mysqli_query($conn, $sql);
    echo '<option></option>';
    while($data=mysqli_fetch_object($query)){
            echo '<option value='.$data->id.'>'.$data->category_name.'</option>';
         }

}elseif (isset($_POST['fg_group'])) {
     
    echo $sql = "SELECT * FROM item_category where group_id=".$_POST['fg_group']." ORDER BY category_name";
    $query = mysqli_query($conn, $sql);
    echo '<option></option>';
    while($data=mysqli_fetch_object($query)){
            echo '<option value='.$data->id.'>'.$data->category_name.'</option>';
         }

}elseif (isset($_POST['category_id'])) {
     
    echo $sql = "SELECT * FROM item_subcategory where category_id=".$_POST['category_id']." ORDER BY subcategory_name";
    $query = mysqli_query($conn, $sql);
    echo '<option></option>';
    while($data=mysqli_fetch_object($query)){
            echo '<option value='.$data->id.'>'.$data->subcategory_name.'</option>';
         }

}elseif (isset($_POST['subcategory_id'])) {
     
    $sql = "SELECT item_id,concat(finish_goods_code,'#',item_name) FROM item_info where subcategory_id=".$_POST['subcategory_id']." and status='Active' ORDER BY item_name";
    $query = mysqli_query($conn, $sql);
    
    echo '<option></option>';
            optionlist($sql);

}elseif (isset($_POST['route_id'])) {
     
    $sql = "SELECT dealer_code,concat(dealer_code,' ',shop_name) FROM ss_shop where route_id=".$_POST['route_id']." and status='1' ORDER BY shop_name";
    $query = mysqli_query($conn, $sql);
    
    echo '<option></option>';
            optionlist($sql);

}
















?>