<?php
session_start();
require "../../support/inc.all.php";
$sql = 'select * from secondary_journal where tr_from = "DamageReturn" and tr_no in (4090,4092,4094,4095,4100,4101,4102,4105,4109,4110,4113,4114,4120,4140,4142,4143,4145)';
$query =db_query($sql);
while($data=mysqli_fetch_object($query)){
$jv=next_journal_voucher_id();
$jv_no=$data->jv_no;
sec_journal_journal($jv_no,$jv,'DamageReturn');
}
?>