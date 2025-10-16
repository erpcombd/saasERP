<?php
session_start();
require_once "../../../assets/support/inc.all.php";

 $fg_code=$_POST['item'];

$all = find_all_field('item_info','','finish_goods_code="'.$fg_code.'" ');
$sec_unit=$all->pack_unit;
$sec_qty=$all->carton_qty;
 
  $change = array($sec_unit,$sec_qty);
  echo implode('~',$change);



 ?>



