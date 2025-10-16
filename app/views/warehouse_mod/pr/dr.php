<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$sql = 'SELECT j.id, d.or_no, d.or_date, from_unixtime( j.jv_date, "%Y-%m-%d" ) AS jv_date
FROM warehouse_damage_receive d, journal j
WHERE d.or_date > "2014-12-31"
AND j.tr_from = "DamageReturn"
AND d.or_no = j.tr_id
AND d.or_date != from_unixtime( j.jv_date, "%Y-%m-%d" )';
$query = db_query($sql);
while($data = mysqli_fetch_object($query))
{
$jv_date = strtotime($data->or_date);
echo $ssql = 'update journal set jv_date="'.$jv_date.'" where id = '.$data->id;
//db_query($ssql);
}
echo $x;
?>