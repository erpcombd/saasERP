<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
//require "../../config/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
 $str = $_POST['data'];
$data=explode('##',$str);
?>

<select name="PBI_PER_PO" id="PBI_PER_PO" class="form-control" onchange="getData2('ajax_per_post_code.php', 'PBI_per_postCode',this.value,this.value);">
    <option ></option>
    <? foreign_relation('uploadpost','post','post',$PBI_PER_PO,'  thana like "'.$data[0].'" order by post');?>
</select>