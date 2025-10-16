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




<select name="pre_ps" id="pre_ps" class="form-control" onchange="getData2('ajax_post.php', 'post_office',this.value,this.value);">
    <option ></option>
    <? foreign_relation('uploadpost','thana','thana',$pre_ps,'  district like "'.$data[0].'" group by thana order by thana');?>
</select>
