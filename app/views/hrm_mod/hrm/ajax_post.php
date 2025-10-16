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

<select name="post_office" id="post_office" class="form-control" onchange="getData2('ajax_post_code.php', 'post_code',this.value,this.value);">
    <option ></option>
    <? foreign_relation('uploadpost','post','post',$post_office,'  thana like "'.$data[0].'" order by post');?>
</select>