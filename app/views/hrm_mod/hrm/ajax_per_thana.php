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




<select name="PBI_PER_POLICE" id="PBI_PER_POLICE" class="form-control" onchange="getData2('ajax_per_post.php', 'PBI_PER_PO',this.value,this.value);">
    <option ></option>
    <? foreign_relation('uploadpost','thana','thana',$PBI_PER_POLICE,'  district like "'.$data[0].'" group by thana order by thana');?>
</select>
