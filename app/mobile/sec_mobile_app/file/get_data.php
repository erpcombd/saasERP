<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
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
     
    $sql = "SELECT * FROM item_group where group_for=".$_POST['fg_group']." ORDER BY group_name";
    $query = mysqli_query($conn, $sql);
    echo '<option></option>';
    while($data=mysqli_fetch_object($query)){
            echo '<option value='.$data->group_id.'>'.$data->group_name.'</option>';
         }

}elseif (isset($_POST['group_id'])) {
     
    $sql = "SELECT * FROM item_sub_group where group_id=".$_POST['group_id']." ORDER BY sub_group_name";
    $query = mysqli_query($conn, $sql);
    echo '<option></option>';
    while($data=mysqli_fetch_object($query)){
            echo '<option value='.$data->sub_group_id.'>'.$data->sub_group_name.'</option>';
         }

}elseif (isset($_POST['sub_group_id'])) {
     
    $sql = "SELECT item_id,concat(finish_goods_code,'#',item_name) FROM item_info where sub_group_id=".$_POST['sub_group_id']." and status='Active' ORDER BY item_name";
    $query = mysqli_query($conn, $sql);
    echo '<option></option>';
            optionlist($sql);

}

elseif (isset($_POST['route_id'])) {
     
   $sql = 'select s.dealer_code,concat(s.dealer_code,"-",s.shop_name) as shop_name 
    from ss_shop s, ss_route r 
    where s.route_id=r.route_id and s.status="1" and s.emp_code="'.$_SESSION['user']['username'].'" and r.route_id="'.$_POST['route_id'].'"
    order by r.route_id,s.shop_name';
    
    $query = mysqli_query($conn, $sql);
    echo '<option></option>';
        optionlist($sql);

}


?>