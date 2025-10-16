<?php 

//_____________ UNIQUE PRODUCT CODE _________
function generateUniqueProductCode() {
    do {
        $code = str_pad(mt_rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);
        $sql = "SELECT COUNT(*) AS count FROM products WHERE code = '$code'";
        $db = mysqli_connect("localhost", "root", "", "erp"); 
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];
        mysqli_close($db); 

    } while ($count > 0);

    return $code;
}




?>