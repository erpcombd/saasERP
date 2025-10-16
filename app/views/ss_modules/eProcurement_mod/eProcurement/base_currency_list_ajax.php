<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


$str = $_POST['data'];
$data=explode('##',$str);
$rfq_no = $_SESSION['rfq_no'];


?>

<?php 
	$sql = "select c.id, c.currency from currency_info c, rfq_multiple_currency m where c.id=m.currency_id and rfq_no=".$rfq_no;
	$qry = db_query($sql);
	$cnt = 0;
	while($res = mysqli_fetch_object($qry)){
	$cnt++;
?>
	<option><?=$res->currency;?></option>
<? } ?>
 <? if($cnt==0){ foreign_relation('currency_info','currency','""',$base_currency,'1'); }?>
