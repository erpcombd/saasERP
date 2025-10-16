<?php


session_start();


require "../../support/inc.all.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');





$str = $_POST['data'];


$data=explode('##',$str);  


 $pur=$data[0];

 //auto_complete_from_db('accounts_ledger','ledger_name','ledger_id',' parent>0  ','purpose');
$test=substr_replace($pur,"",8);

if($pur<=0){
$con .=' and dstr=1 ';
}
echo '<select id="purpose" name="purpose"  required style="width:150px"  >';
  foreign_relation('accounts_ledger','ledger_id','ledger_name',$purpose,' parent=0 and ledger_id like "'.$test.'%" and ledger_group_id in (1031,4002,4004,4003,1034,2006) '.$con.' ');
echo '</select>';

?>
<!--<input  name="purpose" type="text" id="purpose" value="<?=$test?>"/>-->

 

