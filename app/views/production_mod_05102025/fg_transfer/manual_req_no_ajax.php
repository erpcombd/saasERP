<?php


session_start();


require "../../support/inc.all.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');





 $str = $_POST['data'];


$data=explode('##',$str);


$pl_id=$data[0];
$manual_req_no=$data[1];
$manual_req= find_a_field('fg_transfer_master','manual_req_no','warehouse_from="'.$pl_id.'" order by st_no desc');

$man = explode("-",$manual_req);
 $manual_req_no = $man[1] +1;



$short_code= find_a_field('warehouse','short_code','warehouse_id="'.$pl_id.'"');


if($manual_req_no==0)$manual_req_no=1;

if($short_code=="")$short_code="PL";
$line_req_no=$short_code."-".$manual_req_no;

?>
<input  name="manual_req_no" type="text" id="manual_req_no" value="<?=$line_req_no?>"/>


