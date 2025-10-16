<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$group=$_POST['group_id'];

$sCode=find_a_field('fa_item_sub_group','description','sub_group_id="'.$group.'"');

$rCount=find_a_field('fa_register','item_code','fa_sub_group="'.$group.'" order by id DESC');

$fNumber=explode("-",$rCount);

$nmbr=$fNumber[1]+1;

$final= $sCode."-".$nmbr;

 echo $final;

