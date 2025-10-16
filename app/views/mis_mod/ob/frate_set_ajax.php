<?
session_start();
require "../../support/inc.all.php";

  $item_id=$_REQUEST['item_id'];
  $f_price=$_REQUEST['f_price'];
  $d_price=$_REQUEST['d_price'];
  $t_price=$_REQUEST['t_price'];
  $m_price=$_REQUEST['m_price'];
$sql = 'update item_info set f_price="'.$f_price.'", d_price="'.$d_price.'", t_price="'.$t_price.'", m_price="'.$m_price.'" where item_id='.$item_id;
db_query($sql);

echo 'Success!';
?>